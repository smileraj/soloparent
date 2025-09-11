<?php
	// config
	require_once('../../../config.php');
	
	// framework joomlike
	require_once('../../../framework/joomlike.class.php');
	
	// framework base de données
	require_once('../../../framework/mysql2.class.php');
	require_once('mailing_auto.function.php');
	
	
	// connexion DB
	$db	= new DB();
	
	
	// params
	$action			= JL::getVar('action', '');
	$id				= (int)JL::getVar('id', 0);
	$email			= trim(JL::getVar('email', 0));
	$username		= trim(JL::getVar('username', 0));
	$group_id			= (int)JL::getVar('group_id', 0);
	$serie			= (int)JL::getVar('serie', 0);
	$user_id		= (int)JL::getVar('user_id', 0);
	$hash			= JL::getVar('hash', '');
	$mailsParSerie	= 40;
	
	// sécurité
	if(!$id || !$user_id || !$hash || $hash != md5(date('yYy').$user_id.date('Yy'))) {
		die();
	}
	
	
	// variables
	$_where			= '';
	$where			= array();
	
	// prise en compte de la case 'newsletter' dans les params du compte
	$where[]		= "un.rappels = 1";
	$where[]		= "u.published*u.confirmed > 0";
	
	if($email != '') {
		$where[]	= "u.email LIKE '%".$email."%'";
	}
	
	if($username != '') {
		$where[]	= "u.username LIKE '%".$username."%'";
	}
	
	if($group_id == '1') {
		$where[]	= "up.genre = 'h'";
	}elseif($group_id == '2') {
		$where[]	= "up.genre = 'f'";
	}elseif($group_id == '3') {
		$where[]	= "(up.langue_appel = '1' or up.langue_appel = '0')";
	}elseif($group_id == '4') {
		$where[]	= "up.langue_appel = '2'";
	}elseif($group_id == '5') {
		$where[]	= "up.langue_appel = '3'";
	}
	
	// construit le WHERE
	$_where			= count($where) ? " WHERE ".implode(' AND ',$where) : '';

	
	// recherche des destinataires
	$query = "SELECT COUNT(*)"
	." FROM user AS u"
	." INNER JOIN user_notification AS un ON un.user_id = u.id"
	." INNER JOIN user_profil AS up ON up.user_id = u.id"
	.$_where
	;
	$usersTotalNb = $db->loadResult($query);
	
	// envoi d'emails
	if($action == 'send') {
		
		// récup le mailing
		$query = "SELECT *"
		." FROM mailing_auto"
		." WHERE id = '".$db->escape($id)."'"
		." LIMIT 0,1"
		;
		$mailing = $db->loadObject($query);
		

		
		// recherche des destinataires
		$query = "SELECT u.id, u.username, u.email, up.genre"
		." FROM user AS u"
		." INNER JOIN user_notification AS un ON un.user_id = u.id"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		.$_where
		." LIMIT ".($serie*$mailsParSerie).", ".$mailsParSerie
		;
		$users 		= $db->loadObjectList($query);
		$usersNb	= count($users);
		
		// pour chaque destinataire
		foreach($users as $user) {
			
			// intégration du texte et du template, ainsi que traitement des mots clés
			$mailingTexte 	= FUNCTION_mailing_auto::getMailHtml(SITE_PATH_ADMIN.'/app/app_mailing_auto/template/'.$mailing->template, $mailing, '../../', $user->id, $user->genre, $group_id);
			
			
			// envoi du mail
			@JL::mailNewsletter($user->email, $mailing->sujet, $mailingTexte);
			
		}
		
		// retour au script ajax
		echo $usersNb > 0 ? floor(($serie * $mailsParSerie + $usersNb) * 100 / $usersTotalNb) : 'end';
		
	} elseif($action == 'search') {
	
		// retour au script ajax
		echo $usersTotalNb;
		
	}
	
	
	// déconnexion DB
	$db->disconnect();
	
?>

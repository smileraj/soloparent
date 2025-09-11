<?php

	// config
	require_once('../../../config.php');
	
	// framework joomlike
	require_once('../../../framework/joomlike.class.php');
	
	// framework base de données
	require_once('../../../framework/mysql.class.php');
	
	
	// connexion DB
	$db	= new DB();
	
	
	// params
	$action			= JL::getVar('action', '');
	$id				= (int)JL::getVar('id', 0);
	$email			= trim(JL::getVar('email', 0));
	$username		= trim(JL::getVar('username', 0));
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
	$where[]		= "na.newsletter=1";
	
	if($email != '') {
		$where[]	= "na.email LIKE '%".$email."%'";
	}
	
	// construit le WHERE
	$_where			= count($where) ? " WHERE ".implode(' AND ',$where) : '';

	
	// recherche des destinataires
	$query = "SELECT COUNT(*)"
	." FROM newsletter_anzere AS na"
	.$_where
	;
	$usersTotalNb = $db->loadResult($query);
	
	// envoi d'emails
	if($action == 'send') {
		
		// récup le mailing
		$query = "SELECT titre, texte, template"
		." FROM mailing"
		." WHERE id = '".$db->escape($id)."'"
		." LIMIT 0,1"
		;
		$mailing = $db->loadObject($query);
		

		
		// recherche des destinataires
		$query = "SELECT na.email"
		." FROM newsletter_anzere AS na"
		.$_where
		." LIMIT ".($serie*$mailsParSerie).", ".$mailsParSerie
		;
		$users 		= $db->loadObjectList($query);
		$usersNb	= count($users);
		
		// pour chaque destinataire
		foreach($users as $user) {
			
			// intégration du texte et du template, ainsi que traitement des mots clés
			$mailingTexte 	= JL::getMailHtml(SITE_PATH_ADMIN.'/app/app_mailing2/template/'.$mailing->template, $mailing->titre, $mailing->texte, $user->username);
			
			// envoi du mail
			@JL::mail($user->email, $mailing->titre, $mailingTexte);
			//@JL::mail('l.guyot@babybook.ch', $mailing->titre, $mailingTexte);
			
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

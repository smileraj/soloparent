<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('inviter.html.php');
			include("lang/app_inviter.".$_GET['lang'].".php");

	global $action, $user;

	// gestion des messages d'erreurs
	$messages	= array();

	/*
		new: formulaire nouveau t&eacute;moignage
		save: submit le formulaire de nouvel t&eacute;moignages
		list: lister les appels &agrave; t&eacute;moins
		read: lire un t&eacute;moignage complet
	*/
	if($user->id){
		switch($action) {
		
			case 'parrainagesubmit':
				
				$messages = parrainagesubmit();
				parrainage($messages);
				
			break;

			default:
				parrainage();
			break;

		}
	}else{
		switch($action) {
			
			case 'conseillersubmit':
				
				$messages = conseillersubmit();
				conseiller($messages);
				
			break;

			default:
				conseiller();
			break;

		}
	}


	function parrainage($messages = array()) {
		global $langue;
		global $db, $user, $action;

		// variables
		$row						= new stdClass();

		// initialise les donn&eacute;es
		$_data			=& parrainage_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = JL::getVar($key, $value);
			}
		}
		
		$query = "SELECT id, titre_".$_GET['lang']." AS titre, texte_".$_GET['lang']." AS texte FROM contenu WHERE id = 102 ";
		$data = $db->loadObject($query);

		HTML_inviter::parrainage($data, $row, $messages);

	}

	function &parrainage_data() {
		global $langue;
		$_data	= array(
			'email1' 	=> '',
			'email2' 	=> '',
			'email3' 	=> '',
			'email4' 	=> '',
			'email5' 	=> '',
			'message' 	=> ''
		);
		return $_data;
	}


	function parrainagesubmit() {
		global $langue;
		include("lang/app_inviter.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages	= array();
		$emails 		= array();
		$row			= new stdClass();

		// initialise les donn&eacute;es
		$_data			=& parrainage_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = JL::getVar($key, $value);
			}
		}

		if(!$row->email1 && !$row->email2 && !$row->email3 && !$row->email4 && !$row->email5) {
			$messages[]	= '<span class="error">'.$lang_inviter["IndiquezUnEmail"].'.</span>';
		}
		
		if($row->email1)
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email1)) {
				$messages[]	= '<span class="error">'.$lang_inviter["Email1NonValide"].'.</span>';
			}else{
				$emails[] = $row->email1;
		}
		
		if($row->email2)
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email2)) {
				$messages[]	= '<span class="error">'.$lang_inviter["Email2NonValide"].'.</span>';
			}else{
				$emails[] = $row->email2;
		}
		
		if($row->email3)
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email3)) {
				$messages[]	= '<span class="error">'.$lang_inviter["Email3NonValide"].'.</span>';
			}else{
				$emails[] = $row->email3;
		}
		
		if($row->email4)
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email4)) {
				$messages[]	= '<span class="error">'.$lang_inviter["Email4NonValide"].'.</span>';
			}else{
				$emails[] = $row->email4;
		}
		
		if($row->email5)
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email5)) {
				$messages[]	= '<span class="error">'.$lang_inviter["Email5NonValide"].'.</span>';
			}else{
				$emails[] = $row->email5;
		}
		
		

		if(!$row->message) {
			$messages[]	= '<span class="error">'.$lang_inviter["IndiquezUnMessage"].'.</span>';
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {



			// variables locales
			if($_GET['lang']=='de'){
				$mailing_id = 42;
			}elseif($_GET['lang']=='en'){
				$mailing_id = 49;
			}else{
				$mailing_id = 1;
			}
			
			// charge le texte du mail
			$query = "SELECT titre, texte, template"
			." FROM mailing"
			." WHERE id = '".$db->escape($mailing_id)."'"
			." LIMIT 0,1"
			;
			$mailing = $db->loadObject($query);

			
			foreach($emails as $email) {

				// check si l'email n'est pas d&eacute;j&agrave; enregistr&eacute;
				$query = "SELECT id FROM user_parrainage WHERE emails LIKE '".$email."' LIMIT 0,1";
				$emailExistant = $db->loadResult($query);

				if(!$emailExistant) {

					// pseudo dans le titre
					$mailing->titre		= str_replace('{username}', $user->username, 	$mailing->titre);

					// int&eacute;gration du texte et du template, ainsi que traitement des mots cl&eacute;s
					$mailingTexte 	= JL::getMailHtml(SITE_PATH_ADMIN.'/app/app_mailing/template/'.$mailing->template, $mailing->titre, $mailing->texte, $user->username, array($row->message, JL::url(SITE_URL.'/index.php?app=profil&action=inscription&parrain_id='.$user->id.'&'.$langue)));

					// envoi du mail
					@JL::mail($email, $mailing->titre, $mailingTexte);

					$query = "INSERT INTO user_parrainage SET user_id = '".$db->escape($user->id)."', emails = '".$db->escape($email)."', message = '".$db->escape($row->message)."', datetime_send = NOW()";
					$db->query($query);
					
					
					// ajout de l'email dans le talbeau d'emails &agrave; ins&eacute;rer dans la DB
					$emails_envoyes[]	= $email;

				}

			}

			// s'il y a des emails &agrave; enregistrer
			if(count($emails_envoyes)) {

				// message de confirmation
				$messages[]	= '<span class="valid">'.$lang_inviter["MessageEnvoye"].' !</span>';

			} else {

				// message de confirmation
				$messages[]	= '<span class="error">'.$lang_inviter["MessageDejaEnvoyes"].' !</span>';

			}

		}

		// retourne la liste des messages d'erreur
		return $messages;

	}


	function conseiller($messages = array()) {
		global $langue;
		global $db, $user, $action;

		// variables
		$row						= new stdClass();

		// initialise les donn&eacute;es
		$_data			=& conseiller_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = JL::getVar($key, $value);
			}
		}
		
		$query = "SELECT id, titre_".$_GET['lang']." AS titre, texte_".$_GET['lang']." AS texte FROM contenu WHERE id = 110 ";
		$data = $db->loadObject($query);

		HTML_inviter::conseiller($data, $row, $messages);

	}

	function &conseiller_data() {
		global $langue;
		$_data	= array(
			'nom' 	=> '',
			'prenom' 	=> '',
			'email' 	=> '',
			'email1' 	=> '',
			'email2' 	=> '',
			'email3' 	=> '',
			'email4' 	=> '',
			'email5' 	=> '',
			'message' 	=> ''
		);
		return $_data;
	}


	function conseillersubmit() {
		global $langue;
		include("lang/app_inviter.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages	= array();
		$emails 		= array();
		$row			= new stdClass();

		// initialise les donn&eacute;es
		$_data			=& conseiller_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = JL::getVar($key, $value);
			}
		}
		
		if(!$row->nom) {
			$messages[]	= '<span class="error">'.$lang_inviter["IndiquezVotreNom"].'.</span>';
		}

		if(!$row->prenom) {
			$messages[]	= '<span class="error">'.$lang_inviter["IndiquezVotrePrenom"].'.</span>';
		}

		if(!$row->email) {
			$messages[]	= '<span class="error">'.$lang_inviter["IndiquezVotreEmail"].'.</span>';
		}

		if(!$row->email1 && !$row->email2 && !$row->email3 && !$row->email4 && !$row->email5) {
			$messages[]	= '<span class="error">'.$lang_inviter["IndiquezUnEmail"].'.</span>';
		}
		
		if($row->email1)
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email1)) {
				$messages[]	= '<span class="error">'.$lang_inviter["Email1NonValide"].'.</span>';
			}else{
				$emails[] = $row->email1;
		}
		
		if($row->email2)
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email2)) {
				$messages[]	= '<span class="error">'.$lang_inviter["Email2NonValide"].'.</span>';
			}else{
				$emails[] = $row->email2;
		}
		
		if($row->email3)
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email3)) {
				$messages[]	= '<span class="error">'.$lang_inviter["Email3NonValide"].'.</span>';
			}else{
				$emails[] = $row->email3;
		}
		
		if($row->email4)
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email4)) {
				$messages[]	= '<span class="error">'.$lang_inviter["Email4NonValide"].'.</span>';
			}else{
				$emails[] = $row->email4;
		}
		
		if($row->email5)
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email5)) {
				$messages[]	= '<span class="error">'.$lang_inviter["Email5NonValide"].'.</span>';
			}else{
				$emails[] = $row->email5;
		}
		
		

		if(!$row->message) {
			$messages[]	= '<span class="error">'.$lang_inviter["IndiquezUnMessage"].'.</span>';
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {



			// variables locales
			if($_GET['lang']=='de'){
				$mailing_id = 41;
			}elseif($_GET['lang']=='en'){
				$mailing_id = 48;
			}else{
				$mailing_id = 30;
			}
			
			// charge le texte du mail
			$query = "SELECT titre, texte, template"
			." FROM mailing"
			." WHERE id = '".$db->escape($mailing_id)."'"
			." LIMIT 0,1"
			;
			$mailing = $db->loadObject($query);


			$query = "INSERT INTO conseil SET nom = '".$db->escape($row->nom)."', prenom = '".$db->escape($row->prenom)."', email = '".$db->escape($row->email)."' ";
			$db->query($query);
			
			foreach($emails as $email_ami) {


				// pseudo dans le titre
				$mailing->titre		= str_replace('{username}', $row->prenom.' '.$row->nom, 	$mailing->titre);

				// int&eacute;gration du texte et du template, ainsi que traitement des mots cl&eacute;s
				$mailingTexte 	= JL::getMailHtml(SITE_PATH_ADMIN.'/app/app_mailing/template/'.$mailing->template, $mailing->titre, $mailing->texte, $row->prenom.' '.$row->nom, array($row->message));

				// envoi du mail
				@JL::mail($email_ami, $mailing->titre, $mailingTexte);
				
				
				// ajout de l'email dans le talbeau d'emails &agrave; ins&eacute;rer dans la DB
				$emails_envoyes[]	= $email_ami;

			}

			// s'il y a des emails &agrave; enregistrer
			if(count($emails_envoyes)) {

				// message de confirmation
				$messages[]	= '<span class="valid">'.$lang_inviter["MessageEnvoye"].' !</span>';

			}

		}

		// retourne la liste des messages d'erreur
		return $messages;

	}
	
	
	
	
	

?>

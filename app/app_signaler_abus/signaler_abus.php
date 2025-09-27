<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('signaler_abus.html.php');

	global $app, $action, $user, $langue, $langString;

	if(!$user->id) {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
	}


	// gestion des messages d'erreurs
	$messages	= array();

	// variables

	// si search_online et search_page ne sont pas renseign&eacute;s, on reset leurs valeurs. Indispensable pour l'url rewriting par la suite !
	

	switch($action) {
		
		case 'send':
			$messages = signalerSend();			
			signaler($messages);

		break;
		
		default:
			signaler($messages);
		break;

	}

	function signaler_data() {
		global $langue;
		$_data	= array(
			'user_id_to' => '',
			'message' => '',
			'msg' => '',

			'codesecurite' => ''
		);
		return $_data;
	}


	// sauvegarde la recherche dans la base de donn&eacute;es
	function signaler($messages) {
		global $langue, $langString;
		global $db, $user;
		include("lang/app_signaler_abus.".$_GET['lang'].".php");
		

		// variables
		$_data			= signaler_data();
		$list			= array();

		// r&eacute;cup les donn&eacute;es temporaires
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key}	= JL::getVar($key, $value);
			}
		}
		
		if($row->msg == 'sent'){
			$messages[]	= '<span class="valid">'.$lang_signaler_abus["MessageEnvoye"].' !</span>';
		}
		
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte"
		." FROM contenu"
		." WHERE id= 8"
		." LIMIT 0,1"
		;
		$contenu	= $db->loadObject($query);
		
		$query = "SELECT username FROM user WHERE id ='".$row->user_id_to."' LIMIT 0,1";
		$username = $db->loadResult($query);


		// r&eacute;cup la liste des m&eacute;dias
		$row->sujet = $lang_signaler_abus["SignalerUnAbus"].' de '.$username.' par '.$user->username;
		

		$list['captcha']	= rand(2,7);
		JL::setSession('captcha', $list['captcha']);

		
		// affichage du formulaire
		HTML_signaler_abus::signaler($contenu, $row, $messages, $list);

	}


	function signalerSend() {
		global $langue;
		include("lang/app_signaler_abus.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages	= array();

		// variables
		$_data		= signaler_data();
		$row		= new stdClass();

		// r&eacute;cup les donn&eacute;es temporaires
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key}	= JL::getVar($key, $value);
			}
		}

		// v&eacute;rifications des champs
		if($row->user_id_to == '') {
			$messages[]	= '<span class="error">'.$lang_signaler_abus["MembreNonIndique"].'.</span>';
		}else{
			$query = "SELECT genre FROM user_profil WHERE user_id ='".$row->user_id_to."' LIMIT 0,1";
			$genre = $db->loadResult($query);
			
			if($genre == $user->genre){
				$messages[]	= '<span class="error">'.$lang_signaler_abus["MembreIndiqueSexeIndentique"].'.</span>';
			}
		}
		
		if($row->user_id_to == $user->id) {
			$messages[]	= '<span class="error">'.$lang_signaler_abus["EnvoiImpossiblePseudo"].'.</span>';
		}

		if(!$row->message) {
			$messages[]	= '<span class="error">'.$lang_signaler_abus["IndiquezMessage"].'.</span>';
		}

		// v&eacute;rification du captcha
		if($row->codesecurite != JL::getSession('captcha', 0)) {
			$messages[]	= '<span class="error">'.$lang_signaler_abus["CodeSecuriteIncorrect"].'.</span>';
		}



		// pas d'erreur, on envoie l'appel
		if(!count($messages)) {

			$query = "SELECT username FROM user WHERE id ='".$row->user_id_to."' LIMIT 0,1";
			$username = $db->loadResult($query);
			$sujet = "Signalement d'abus de ".$username." (par ".$user->username.": ".$user->email.")";

			// envoi du message
			JL::mail('info@solocircl.com', '[ Signaler un abus ] '.$sujet, nl2br($sujet." \n\n".$row->message));
			//JL::mail('m.jombart@babybook.ch', '[ Abus ] '.$sujet, nl2br($sujet." \n\n".$row->message));

			JL::redirect(SITE_URL.'/index.php?app=signaler_abus&user_id_to='.$row->user_id_to.'&msg=sent&'.$langue);

		}

		return $messages;

	}


?>

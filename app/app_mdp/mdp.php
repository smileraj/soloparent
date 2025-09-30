<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('mdp.html.php');
	include("lang/app_mdp.".$_GET['lang'].".php");
	global $action;

	switch($action){
		// MOT DE PASSE PERDU
		case 'mdp':

			// params
			if(JL::getVar('msg', '') == 'mdpok') {

				$messages[] 	= '<span class="valid">'.$lang_appmdp["EmailConfirmationEnvoye"].' !</span>';

			}

			// soumission du formulaire
			if((int)JL::getVar('save', 0)) {

				// ~model: sauvegarde les donn&eacute;es
				$messages = mdpsubmit();

				// si les donn&eacute;es sont valides
				if(!count($messages)) {
					JL::redirect(SITE_URL.'/index.php?app=mdp&action=mdp&msg=mdpok'.'&'.$_GET['lang']);
				}

			}

			// ~view
			mdp($messages);

		break;

		case 'mdpconfirm':

			// params
			$id		= (int)JL::getVar('id', 0, true);
			$key	= JL::getVar('key', '', true);

			// un param non renseign&eacute;
			if(!$id || !$key) {
				JL::redirect(SITE_URL.'/index.php?app=mdp&action=mdp'.'&'.$_GET['lang']);
			}

			// effectue le changement de mot de passe
			mdp_change($id, $key);

		break;
		
		default:

			mdp($messages);

		break;
	}

	function mdp(&$messages) {
		global $langue, $langString;
		global $db;

		// donn&eacute;es &agrave; r&eacute;cup
		$_data	= mdp_data();

		$row = new stdClass();

		// donn&eacute;es du formulaire
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = trim(JL::getVar($key, $value));
			}
		}

		// captcha
		$row->captcha		= random_int(1,9);
		$row->captchaMd5	= md5(date('m/Y').($row->captcha+1337));
		
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 100";
		$data = $db->loadObject($query);

		// formulaire
		(new mdp_HTML())->mdp($data, $row, $messages);

	}

	// applique la demande de changement de mot de passe
	function mdp_change($id, $key) {
		global $langue;
		global $db;

		$query = "UPDATE user SET password = password_new, password_new = '' WHERE password_new != '' AND id ='".$id."' AND MD5(CONCAT(username, creation_date)) = '".$key."'";
		$db->query($query);

		if($db->affected_rows()) {

			// view
			(new mdp_HTML())->mdpChanged();

		} else {

			// view
			(new mdp_HTML())->mdpError();

		}

	}


	function mdp_data() {
		global $langue;
		$_data	= [
			'email' 		=> '',
			'password' 		=> '',
			'password2' 	=> '',
			'captchaMd5' 	=> '',
			'captcha' 		=> '',
			'verif' 		=> ''
		];
		return $_data;
	}

	function mdpsubmit() {
		global $langue;
		include("lang/app_mdp.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= [];


		// donn&eacute;es &agrave; r&eacute;cup
		$_data	= mdp_data();

		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$_data[$key] = trim(JL::getVar($key, $value, true));
			}
		}


		// email
		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', (string) $_data['email'])) {
			$messages[]	= '<span class="error">'.$lang_appmdp["IndiquerEmailValide"].'.</span>';
		}else{

			// v&eacute;rifie si l'adresse email existe (et n'est pas une adresse admin)
			$query = "SELECT id FROM user WHERE email LIKE '".$_data['email']."' AND gid != 1 LIMIT 0,1";
			$emailExistant = $db->loadResult($query);

			// email n'existe pas
			if(!$emailExistant) {
				$messages[]	= '<span class="error">'.$lang_appmdp["AdresseEmailInconnu"].'.</span>';
			}
		}

		if(!$_data['password']) {
			$messages[]	= '<span class="error">'.$lang_appmdp["IndiquezNouveauMdp"].'.</span>';
		}

		if($_data['password'] && !preg_match('/^[a-zA-Z0-9._-]+$/', (string) $_data['password'])) {
			$messages[]	= '<span class="error">'.$lang_appmdp["MdpIncorrect"].'.</span>';
		}

		// confirmation mdp
		if(($_data['password'] || $_data['password2']) && $_data['password'] != $_data['password2']) {
			$messages[]	= '<span class="error">'.$lang_appmdp["ConfirmationMdpIncorrect"].'.</span>';
		}


		if($_data['verif'] == '' || md5(date('m/Y').($_data['verif']+1337)) != $_data['captchaMd5']) {
			$messages[] = '<span class="error">'.$lang_appmdp["CodeSecuriteIncorrect"].'.</span>';
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// variables locales
			if($_GET['lang']=='de'){
				$mailing_id = 40;
			}elseif($_GET['lang']=='en'){
				$mailing_id = 47;
			}else{
				$mailing_id = 32;
			}
			
			// charge le texte du mail
			$query = "SELECT titre, texte, template"
			." FROM mailing"
			." WHERE id = '".$db->escape($mailing_id)."'"
			." LIMIT 0,1"
			;
			$mailing = $db->loadObject($query);


			// r&eacute;cup le login
			$query 			= "SELECT id, username, creation_date FROM user WHERE email LIKE '".$_data['email']."' LIMIT 0,1";
			$userTemp		= $db->loadObject($query);
			$userTemp->lien	= SITE_URL."/index.php?app=mdp&action=mdpconfirm&id=".$userTemp->id."&key=".md5($userTemp->username.$userTemp->creation_date).'&'.$langue;


			// enregistre la demande de changement de mdp
			$query = "UPDATE user SET password_new = MD5('".$_data['password']."') WHERE email LIKE '".$_data['email']."'";
			$db->query($query);


			
			

			// int&eacute;gration du texte et du template, ainsi que traitement des mots cl&eacute;s
			$mailingTexte 	= JL::getMailHtml(SITE_PATH_ADMIN.'/app/app_mailing/template/'.$mailing->template, $mailing->titre, $mailing->texte, $userTemp->username, [$userTemp->lien,$_data['password']]);

			// envoi du mail
			@JL::mail($_data['email'], $mailing->titre, $mailingTexte);

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}
		
	
?>

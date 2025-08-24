<?php

	// MODEL
	defined('JL') or die('Error 401');

	require_once('contact.html.php');

	global $db, $user, $langue,$action;
	
	$messages	= array();
	$contact = new stdClass();
	
	switch($action){
		case 'envoyer'	:
			getData();
			
			if(checkData()) {
				submitData();
				JL::redirect(SITE_URL.'/index.php?app=contact&lang='.$_GET['lang'].'&msg=ok');
			}
			
			edit();
		break;
		
		default:
			getData();
			edit();
		break;
		
	}
	
			
			
			
			
			
		
		
		function edit() {
			global $db, $contact, $messages;
			include("lang/app_contact.".$_GET['lang'].".php");
			
			// valeurs de type_id acceptées à modifier égalment dans submitData
			$typesText	= array(
				$lang_appcontact["- SelectionnezLeTypeDeDemande -"],
				$lang_appcontact["ChangementAdresseEmail"],
				$lang_appcontact["ChangementPseudo"],
				$lang_appcontact["InformationsAbonnements"],
				$lang_appcontact["InformationsGenerales"],
				$lang_appcontact["JeSouhaiteMeDesinscrire"],
				$lang_appcontact["ProblemeTechnique"],
				$lang_appcontact["Autre..."]
			);
			
			
			// préparation de la liste déroulante
			$types	= array();
			$max			= count($typesText);
			for($i=0;$i<$max; $i++) {
				$types[]	= JL::makeOption($i, $typesText[$i]);
			}
			
			$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from contenu WHERE id =  6";
			$contenu = $db->loadObject($query);
			
			if(JL::getVar('msg', '') == 'ok') {
				$messages[] 	= '<span class="valid">'. $lang_appcontact["MessageEnvoye"].'</span>';
			}
			
			$contact->captcha		= rand(10,99).chr(rand(65,90)).rand(10,99).chr(rand(65,90));
			$contact->captchaAbo		= md5(date('m/Y').$contact->captcha);
			
			$lists['type_id']	= JL::makeSelectList($types, 'type_id', 'class="inputtext2"', 'value', 'text', $contact->type_id);
			
			contact_HTML::display($contenu, $contact, $lists, $messages);
		}
		
		
		function getData() {
			global $contact, $user;
			
			if($user->id){
				$contact->email					= $user->email;
			}else{
				$contact->email					= JL::getVar('email', '');
			}
			$contact->message				= JL::getVar('message', '');
			$contact->type_id				= (int)JL::getVar('type_id', 0);
			
			// captcha
			$contact->captchaAbo			= JL::getVar('captchaAbo', '');
			$contact->verif					= trim(JL::getVar('verif', ''));
			
		}
		
		function checkData() {
			include("lang/app_contact.".$_GET['lang'].".php");
			global $db, $contact, $messages;
			
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,4}$/', $contact->email)) {
				$messages[] = '<span class="error">'.$lang_appcontact["WarningEmailInvalide"].'</span>';
			}
			
			$typesValue	= array(1,2,3,4,5,6,7);
			
			if(!in_array($contact->type_id, $typesValue)) {
				$contact->type_id = 0;
				$messages[] = '<span class="error">'.$lang_appcontact["WarningTypeDeDemande"].'</span>';
			}
			
			if($contact->message == '') {
				$messages[] = '<span class="error">'.$lang_appcontact["WarningMessage"].'</span>';
			}
			
			if($contact->verif == '' || md5(date('m/Y').strtoupper($contact->verif)) != $contact->captchaAbo) {
				$messages[] = '<span class="error">'.$lang_appcontact["WarningCodeVerifIncorrect"].'</span>';
			}
			
			return count($messages) ? false : true;
		
		}
		
		
		function submitData() {
			global $db, $contact, $typesText;
			include("lang/app_contact.".$_GET['lang'].".php");
				
				// valeurs de type_id acceptées à modifier égalment dans edit
				$typesText	= array(
					$lang_appcontact["- SelectionnezLeTypeDeDemande -"],
					$lang_appcontact["ChangementAdresseEmail"],
					$lang_appcontact["ChangementPseudo"],
					$lang_appcontact["InformationsAbonnements"],
					$lang_appcontact["InformationsGenerales"],
					$lang_appcontact["JeSouhaiteMeDesinscrire"],
					$lang_appcontact["ProblemeTechnique"],
					$lang_appcontact["Autre..."]
				);
				
				
				// headers
				$headers 	= 'Mime-Version: 1.0'."\r\n";
				$headers 	= 'From: "'.SITE_MAIL_FROM.' Contact" <'.SITE_MAIL.'>'."\r\n";
				$headers   .= 'Content-type: text/plain; charset=iso-8859-1'."\r\n";
				//$headers .= "\r\n";
				
				$titre		= '[ '.SITE_MAIL_FROM.' ] '.$typesText[$contact->type_id];
				$texte 		= 'De: '.$contact->email."\n\n";
				$texte		.= 'Message: '.$contact->message;
				
				$email = 'info@parentsolo.ch';
				//$email = 'm.jombart@babybook.ch';
				
				// envoi du mail
				mail($email, $titre, $texte, $headers);
			
			
			
		}
					
	
?>


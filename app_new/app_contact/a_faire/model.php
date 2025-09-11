<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class contactModel extends JLModel {
	
		var $types;
		
		
		function contactModel() {
			global $db;
			include("lang/app_contact.".$_GET['lang'].".php");
			
			// valeurs de type_id acceptées
			$this->typesValue	= array(1,2,3,4,5,6,7);
			$this->typesText	= array(
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
			$this->types	= array();
			$max			= count($this->typesText);
			for($i=0;$i<$max; $i++) {
				$this->types[]	= JL::makeOption($i, $this->typesText[$i]);
			}
			
			$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from contenu WHERE id =  6";
			$this->contenu = $db->loadObject($query);
			
		}
		
		function getContactTypes() {
			
			// variables
			$this->_lists['type_id']	= JL::makeSelectList($this->types, 'type_id', 'class="inputtext2"', 'value', 'text', $this->_data->type_id);
		
		}
		
		function getData() {
		
			$this->_data						= new stdClass();
			$this->_data->email					= JL::getVar('email', 	'');
			$this->_data->message				= JL::getVar('message', '');
			$this->_data->type_id				= (int)JL::getVar('type_id', 0);
			
			// captcha
			$this->_data->captchaAbo			= JL::getVar('captchaAbo', '');
			$this->_data->verif					= trim(JL::getVar('verif', ''));
			
		}
		
		function checkData() {
			include("lang/app_contact.".$_GET['lang'].".php");
			global $db;
			
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,4}$/', $this->_data->email)) {
				$this->_messages[] = '<span class="error">'.$lang_appcontact["WarningEmailInvalide"].'</span>';
			}
			
			if(!in_array($this->_data->type_id, $this->typesValue)) {
				$this->_data->type_id = 0;
				$this->_messages[] = '<span class="error">'.$lang_appcontact["WarningTypeDeDemande"].'</span>';
			}
			
			if($this->_data->message == '') {
				$this->_messages[] = '<span class="error">'.$lang_appcontact["WarningMessage"].'</span>';
			}
			
			if($this->_data->verif == '' || md5(date('m/Y').strtoupper($this->_data->verif)) != $this->_data->captchaAbo) {
				$this->_messages[] = '<span class="error">'.$lang_appcontact["WarningCodeVerifIncorrect"].'</span>';
			}
			
			return count($this->_messages) ? false : true;
		
		}
		
		
		function submitData() {
			global $db;
				
				// headers
				$headers 	= 'Mime-Version: 1.0'."\r\n";
				$headers 	= 'From: "'.SITE_MAIL_FROM.' Contact" <'.SITE_MAIL.'>'."\r\n";
				$headers   .= 'Content-type: text/plain; charset=iso-8859-1'."\r\n";
				//$headers .= "\r\n";
				
				$titre		= '[ '.SITE_MAIL_FROM.' ] '.$this->typesText[$this->_data->type_id];
				$texte 		= 'De: '.$this->_data->email."\n\n";
				$texte		.= 'Message: '.$this->_data->message;
				
				//$email = 'info@parentsolo.ch';
				$email = 'info@parentsolo.ch';
				
				// envoi du mail
				mail($email, $titre, $texte, $headers);
			
			
			
		}
					
	}
?>


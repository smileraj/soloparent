<?php

	// CONTROLLER
	defined('JL') or die('Error 401');
	
	class contactController extends JLController {
	
		function contactController($appLoad) {
			parent::JLController($appLoad); // obligatoire pour l'instanciation
			
			// ajoute le model par d&eacute;faut
			$this->addModel();
			
			// ajoute la view par d&eacute;faut
			$this->addView();
			
		}
	
		function execute() {
			global $action;
		
			// params
			if(JL::getVar('msg', '') == 'ok') {
				include("lang/app_contact.".$_GET['lang'].".php");
			
				$this->model->_messages[] 	= '<span class="valid">'. $lang_appcontact["MessageEnvoye"].'</span>';
				
			}
			
			// model
			$this->model->getData();
			
			
			// submit le formulaire
			if($action == 'envoyer') {
			
				// si les donn&eacute;es sont valides
				if($this->model->checkData()) {
					$this->model->submitData();
					JL::redirect(SITE_URL.'/index.php?app=contact&lang='.$_GET['lang'].'&msg=ok');
				}
			}
			
			
			// captcha
			$this->model->_data->captcha		= rand(10,99).chr(rand(65,90)).rand(10,99).chr(rand(65,90));
			$this->model->_data->captchaAbo		= md5(date('m/Y').$this->model->_data->captcha);
			
			
			// r&eacute;cup la liste des types de contact pr&eacute;d&eacute;finis
			$this->model->getContactTypes();
			
			// view
			$this->view->display($this->model->contenu, $this->model->_data, $this->model->_lists, $this->model->_messages);
		
		}
		
	}

?>

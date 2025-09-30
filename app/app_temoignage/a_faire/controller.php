<?php

	// CONTROLLER
	defined('JL') or die('Error 401');
	
	class temoignageController extends JLController {
	
		function __construct($appLoad) {
			parent::JLController($appLoad); // obligatoire pour l'instanciation
			
			// ajoute le model par d&eacute;faut
			$this->addModel();
			$this->addView();
		}
	
		function execute() {
			global $action;
			include("lang/app_temoignage.".$_GET['lang'].".php");
			
			$msg = JL::getVar('msg', '');
				
				if($msg == 'ok'){
					$this->model->_messages[]	= '<span class="valid">'.$lang_apptemoignage["TemoignageEnvoye"].' !</span>';
				}
			
			switch($action){
				
				case 'envoyer':
					$this->model->getData();
					if($this->model->checkData()){
						$this->model->send();
						JL::redirect(SITE_URL.'/index.php?app=temoignage&action=edit&lang='.$_GET["lang"].'&msg=ok');
					}
					
					$this->model->edit();
					$this->view->edit($this->model->contenu, $this->model->temoignage, $this->model->_messages);
				break;
				
				case 'edit':
					// model
					$this->model->getData();
					$this->model->checkUser();
					$this->model->edit();
					$this->view->edit($this->model->contenu, $this->model->temoignage, $this->model->_messages);
				break;
				
				case 'infos':
					// model
					$this->model->infos();
					$this->view->infos($this->model->contenu);
				break;
				
				case 'lire' : 
				
					$this->model->lire((int)JL::getVar('id',1));
					$this->view->lire($this->model->temoignage);
				break;
				
				default : 
				
					$this->model->listall((int)JL::getVar('page',1));
					$this->view->listall($this->model->temoignages, $this->model->pagination);
				break;
			}
		
		}
		
	}
	
?>

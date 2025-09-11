<?php

	// CONTROLLER
	defined('JL') or die('Error 401');
	
	class presseController extends JLController {
	
		function presseController($appLoad) {
			parent::JLController($appLoad); // obligatoire pour l'instanciation
			
			// ajoute le model par défaut
			$this->addModel();
			$this->addView();
		}
	
		function execute() {
			global $action;
			
			switch($action){
				
				case 'articles':
					$this->model->display(2);
					$this->view->display($this->model->contenu);
				break;
				
				case 'radios':
					$this->model->display(3);
					$this->view->display($this->model->contenu);
				break;
				
				case 'affiches':
					$this->model->display(4);
					$this->view->display($this->model->contenu);
				break;
				
				case 'communique':
					$this->model->display(5);
					$this->view->display($this->model->contenu);
				break;
				
				case 'dossier':
					$this->model->display(6);
					$this->view->display($this->model->contenu);
				break;
				
				default:
					$this->model->display(1);
					$this->view->display($this->model->contenu);
				break;
			}
		
		}
		
	}
	
?>

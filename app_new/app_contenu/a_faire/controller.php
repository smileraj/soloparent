<?php

	// CONTROLLER
	defined('JL') or die('Error 401');
	
	class contenuController extends JLController {
	
		function contenuController($appLoad) {
			parent::JLController($appLoad); // obligatoire pour l'instanciation
			
			// ajoute le model par défaut
			$this->addModel();
			$this->addView();
		}
	
		function execute() {
		
			// model
			$this->model->display();
			$this->view->display($this->model->contenu);
		
		}
		
	}
	
?>

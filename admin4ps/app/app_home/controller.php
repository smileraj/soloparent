<?php

	// CONTROLLER
	defined('JL') or die('Error 401');
	
	class homeController extends JLController {
	
		function homeController($appLoad) {
			parent::JLController($appLoad); // obligatoire pour l'instanciation
			
			// ajoute le model par défaut
			$this->addModel();
			$this->addView();
		}
	
		function execute() {
		
			// model
			$this->model->display();
			$this->view->display(JL::getVar('auth',''), $this->model->profils, $this->model->actualites, $this->model->colonne_1, $this->model->colonne_2, $this->model->colonne_3, $this->model->colonne_4, $this->model->partenaire_r, $this->model->list);
		
		}
		
	}
	
?>

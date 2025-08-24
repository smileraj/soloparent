<?php

	// CONTROLLER
	defined('JL') or die('Error 401');
	
	class headController extends JLController {
	
		function headController($appLoad) {
			parent::JLController($appLoad); // obligatoire pour l'instanciation
			
			// ajoute le model par d&eacute;faut
			$this->addView();
		}
	
		function execute() {
		
			// model
			$this->view->display();
		
		}
		
	}
	
?>

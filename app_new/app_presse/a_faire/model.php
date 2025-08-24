<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class presseModel extends JLModel {
	
	
		function presseModel() {
			parent::JLModel();
			//$this->_messages = JL::getMessages();
		}
		
		function display($id){
			global $db;
			
			$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from presse WHERE id = ".$db->escape($id);
			$this->contenu = $db->loadObject($query);
			
			if($id == 5){
				// variables
				$coeff = 1.1; // coef multiplicateur du nombre de membres

				// récup le nombre d'inscrits, peu importe leur statut 'active'
				$query = "SELECT COUNT(*) FROM user WHERE gid = 0";
				$membres = $db->loadResult($query);
				
				$this->contenu->texte = str_replace('{membres}', round((($membres * $coeff)/100)*100), $this->contenu->texte);
			
			}
			
		}
		
		
		
	}
?>


<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class contenuModel extends JLModel {
	
	
		function contenuModel() {
			parent::JLModel();
			//$this->_messages = JL::getMessages();
		}
		
		function display(){
			global $db, $action;
			
			if($action == 'actu'){
				$query = "Select titre, texte from actualite WHERE id = ".$db->escape(JL::getVar('id',0));
			}else{
				$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from contenu WHERE id = ".$db->escape(JL::getVar('id',0));
			}
			$this->contenu = $db->loadObject($query);
			
		}
		
		
		
	}
?>


<?php

	// MODEL
	defined('JL') or die('Error 401');

	require_once('presse.html.php');

	global $db, $user, $langue, $action;
	
	switch($action){
				
			case 'articles':
				display(120);
			break;
			
			case 'radios':
				display(121);
			break;
			
			case 'affiches':
				display(122);
			break;
			
			case 'communique':
				display(27);
			break;
			
			case 'dossier':
				display(29);
			break;
			
			default:
				display(119);
			break;
		}
		
		function display($id){
			global $db;
			
			$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from contenu WHERE id = ".$db->escape($id)." AND published =1";
			$contenu = $db->loadObject($query);
			
			if($id == 5){
				// variables
				$coeff = 1.1; // coef multiplicateur du nombre de membres

				// récup le nombre d'inscrits, peu importe leur statut 'active'
				$query = "SELECT COUNT(*) FROM user WHERE gid = 0";
				$membres = $db->loadResult($query);
				
				$contenu->texte = str_replace('{membres}', round((($membres * $coeff)/100)*100), $contenu->texte);
			
			}
			
			presse_HTML::display($contenu);
			
		}
		
		
		
	
?>


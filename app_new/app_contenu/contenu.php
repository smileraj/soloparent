<?php

	// MODEL
	// sécurité
	defined('JL') or die('Error 401');

	require_once('contenu.html.php');

	global $db, $user, $langue,$action;
	
			
	if($action == 'actu'){
		$query = "Select titre, texte from actualite WHERE id = ".$db->escape(JL::getVar('id',0))." AND published = 1";
	}else{
		$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from contenu WHERE id = ".$db->escape(JL::getVar('id',0))." AND published = 1";
	}
			
			
			
	$contenu = $db->loadObject($query);
			
	contenu_HTML::contenu($contenu);
?>


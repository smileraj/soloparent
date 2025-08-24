<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('panel.html.php');
	
	global $user, $action, $db;
	
	// user log
	if($user->id) {
		HTML_panel::homePage();
	} else { // user non log
		HTML_panel::loginPage();
	}
	
?>

<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('tools.html.php');
	
	global $action;
	
	// variables
	
	$messages = array();

	
	
	switch($action) {
		
		default:
		listMemberSample();
		break;
		
	}
	
	
	// liste les utilisateurs
	function listMemberSample() {
		
		global $db;
		
		//$query = "SELECT * FROM user WHERE confirmed = 1 ORDER BY RAND(), last_online LIMIT 20";
		$query = "SELECT u.*, up.* FROM user u INNER JOIN user_profil up ON u.id = up.user_id WHERE confirmed = 1 ORDER BY RAND(), last_online LIMIT 20";
		
		$db->setQuery($query);
		//$count = $db->loadResult();
		$sample = $db->loadObjectList($query);
		
		
		tools_HTML::listMemberSample($sample);
		
	}
	

	
	
?>
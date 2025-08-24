<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('evolution_an.html.php');
	
	global $action;
	

	
	// variables
	$messages = array();

	
	
	switch($action) {
		
		default:
		lister();
		break;
		
	}
	
	
	// liste les utilisateurs
	function lister() {
		global $db;
		
		$query = "SELECT"
		." count(u.id) AS total,"
		." DATE_FORMAT(u.creation_date,'%Y') AS annee,"
		." COUNT(CASE WHEN (up.genre='f') THEN 1 ELSE null END) AS total_f,"
		." COUNT(CASE WHEN (up.genre='h') THEN 1 ELSE null END) AS total_h"
		." FROM user AS u"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." GROUP BY DATE_FORMAT(u.creation_date,'%Y')"
		." ORDER BY DATE_FORMAT(u.creation_date,'%Y') ASC"
		;
		$evolution = $db->loadObjectList($query);
		
		$query = "SELECT"
		." count(u.id) AS total,"
		." DATE_FORMAT(u.creation_date,'%Y') AS annee,"
		." COUNT(CASE WHEN (up.genre='f') THEN 1 ELSE null END) AS total_f,"
		." COUNT(CASE WHEN (up.genre='h') THEN 1 ELSE null END) AS total_h"
		." FROM user_suppr u"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." GROUP BY DATE_FORMAT(u.creation_date,'%Y')"
		." ORDER BY DATE_FORMAT(u.creation_date,'%Y') ASC"
		;
		$evolution_suppr = $db->loadObjectList($query);
				
		evolution_an_HTML::lister($evolution, $evolution_suppr);
		
	}

	
?>

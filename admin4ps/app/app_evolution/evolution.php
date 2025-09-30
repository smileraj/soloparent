<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('evolution.html.php');
	
	global $action;
	

	
	// variables
	$messages = [];

	
	
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
		." DATE_FORMAT(u.creation_date,'%m-%Y') AS mois,"
		." COUNT(CASE WHEN (up.genre='f') THEN 1 ELSE null END) AS total_f,"
		." COUNT(CASE WHEN (up.genre='h') THEN 1 ELSE null END) AS total_h"
		." FROM user AS u"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." GROUP BY DATE_FORMAT(u.creation_date,'%m-%Y')"
		." ORDER BY DATE_FORMAT(u.creation_date,'%Y') ASC, DATE_FORMAT(u.creation_date,'%m') ASC"
		;
		$evolution = $db->loadObjectList($query);
		
		$query = "SELECT"
		." count(u.id) AS total,"
		." DATE_FORMAT(u.creation_date,'%m-%Y') AS mois,"
		." COUNT(CASE WHEN (up.genre='f') THEN 1 ELSE null END) AS total_f,"
		." COUNT(CASE WHEN (up.genre='h') THEN 1 ELSE null END) AS total_h"
		." FROM user_suppr u"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." GROUP BY DATE_FORMAT(u.creation_date,'%m-%Y')"
		." ORDER BY DATE_FORMAT(u.creation_date,'%Y') ASC, DATE_FORMAT(u.creation_date,'%m') ASC"
		;
		$evolution_suppr = $db->loadObjectList($query);
		
		$query = "select count(u.id)"
		." FROM user as u"
		." LEFT JOIN user_stats as us on us.user_id = u.id"
		." WHERE DATEDIFF(us.gold_limit_date, CURDATE()) >= 0"
		;
		$nb_abonnes = $db->loadResult($query);
		
		(new evolution_HTML())->lister($evolution, $evolution_suppr, $nb_abonnes);
		
	}

	
?>

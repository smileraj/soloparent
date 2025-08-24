<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('evolution_abonnement.html.php');
	
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
		." DATE_FORMAT(pu.datetime,'%Y') AS annee,"
		." COUNT(CASE WHEN (up.genre='f') THEN 1 ELSE null END) AS total_f,"
		." COUNT(CASE WHEN (up.genre='h') THEN 1 ELSE null END) AS total_h"
		." FROM user AS u"
		." INNER JOIN points_user AS pu on u.id=pu.user_id"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." WHERE pu.points_id IN (1,2,3,19)"
		." GROUP BY DATE_FORMAT(pu.datetime,'%Y')"
		." ORDER BY DATE_FORMAT(pu.datetime,'%Y') ASC"
		;
		$evolution_totale = $db->loadObjectList($query);
		
		$query = "SELECT"
		." count(u.id) AS total,"
		." DATE_FORMAT(pu.datetime,'%Y') AS annee,"
		." COUNT(CASE WHEN (up.genre='f') THEN 1 ELSE null END) AS total_f,"
		." COUNT(CASE WHEN (up.genre='h') THEN 1 ELSE null END) AS total_h"
		." FROM user_suppr u"
		." INNER JOIN points_user AS pu on u.id=pu.user_id"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." WHERE pu.points_id IN (1,2,3,19)"
		." GROUP BY DATE_FORMAT(pu.datetime,'%Y')"
		." ORDER BY DATE_FORMAT(pu.datetime,'%Y') ASC"
		;
		$evolution_totale_suppr = $db->loadObjectList($query);
		
		$query = "SELECT"
		." count(u.id) AS total,"
		." DATE_FORMAT(pu.datetime,'%Y') AS annee,"
		." pu.points_id,"
		." COUNT(CASE WHEN (up.genre='f') THEN 1 ELSE null END) AS total_f,"
		." COUNT(CASE WHEN (up.genre='h') THEN 1 ELSE null END) AS total_h"
		." FROM user AS u"
		." INNER JOIN points_user AS pu on u.id=pu.user_id"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." WHERE pu.points_id IN (1,2,3,19)"
		." GROUP BY DATE_FORMAT(pu.datetime,'%Y'), pu.points_id"
		." ORDER BY DATE_FORMAT(pu.datetime,'%Y') ASC, pu.points_id ASC"
		;
		$evolution = $db->loadObjectList($query);
		
		$query = "SELECT"
		." count(u.id) AS total,"
		." DATE_FORMAT(pu.datetime,'%Y') AS annee,"
		." pu.points_id,"
		." COUNT(CASE WHEN (up.genre='f') THEN 1 ELSE null END) AS total_f,"
		." COUNT(CASE WHEN (up.genre='h') THEN 1 ELSE null END) AS total_h"
		." FROM user_suppr u"
		." INNER JOIN points_user AS pu on u.id=pu.user_id"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." WHERE pu.points_id IN (1,2,3,19)"
		." GROUP BY DATE_FORMAT(pu.datetime,'%Y'), pu.points_id"
		." ORDER BY DATE_FORMAT(pu.datetime,'%Y') ASC, pu.points_id ASC"
		;
		$evolution_suppr = $db->loadObjectList($query);
				
		evolution_abonnement_HTML::lister($evolution_totale, $evolution_totale_suppr,$evolution, $evolution_suppr);
		
	}

	
?>

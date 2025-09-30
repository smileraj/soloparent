<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('evolution_abonne.html.php');
	
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
		." count(DISTINCT u.id) AS total,"
		." DATE_FORMAT(pu.datetime,'%Y') AS annee"
		." FROM user AS u"
		." INNER JOIN points_user AS pu on u.id=pu.user_id"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." WHERE pu.points_id IN (1,2,3,19)"
		." GROUP BY DATE_FORMAT(pu.datetime,'%Y')"
		." ORDER BY DATE_FORMAT(pu.datetime,'%Y') ASC"
		;
		$evolution_totale = $db->loadObjectList($query);
		
		$query = "SELECT"
		." count(DISTINCT u.id) AS total,"
		." DATE_FORMAT(pu.datetime,'%Y') AS annee"
		." FROM user AS u"
		." INNER JOIN points_user AS pu on u.id=pu.user_id"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." WHERE pu.points_id IN (1,2,3,19) AND up.genre = 'f'"
		." GROUP BY DATE_FORMAT(pu.datetime,'%Y')"
		." ORDER BY DATE_FORMAT(pu.datetime,'%Y') ASC"
		;
		$evolution_totale_f = $db->loadObjectList($query);
		
		$query = "SELECT"
		." count(DISTINCT u.id) AS total,"
		." DATE_FORMAT(pu.datetime,'%Y') AS annee"
		." FROM user AS u"
		." INNER JOIN points_user AS pu on u.id=pu.user_id"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." WHERE pu.points_id IN (1,2,3,19) AND up.genre = 'h'"
		." GROUP BY DATE_FORMAT(pu.datetime,'%Y')"
		." ORDER BY DATE_FORMAT(pu.datetime,'%Y') ASC"
		;
		$evolution_totale_h = $db->loadObjectList($query);
		
		$query = "SELECT"
		." count(DISTINCT u.id) AS total,"
		." DATE_FORMAT(pu.datetime,'%Y') AS annee"
		." FROM user_suppr u"
		." INNER JOIN points_user AS pu on u.id=pu.user_id"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." WHERE pu.points_id IN (1,2,3,19)"
		." GROUP BY DATE_FORMAT(pu.datetime,'%Y')"
		." ORDER BY DATE_FORMAT(pu.datetime,'%Y') ASC"
		;
		$evolution_totale_suppr = $db->loadObjectList($query);
		
		$query = "SELECT"
		." count(DISTINCT u.id) AS total,"
		." DATE_FORMAT(pu.datetime,'%Y') AS annee"
		." FROM user_suppr u"
		." INNER JOIN points_user AS pu on u.id=pu.user_id"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." WHERE pu.points_id IN (1,2,3,19) AND up.genre = 'f'"
		." GROUP BY DATE_FORMAT(pu.datetime,'%Y')"
		." ORDER BY DATE_FORMAT(pu.datetime,'%Y') ASC"
		;
		$evolution_totale_f_suppr = $db->loadObjectList($query);
		
		$query = "SELECT"
		." count(DISTINCT u.id) AS total,"
		." DATE_FORMAT(pu.datetime,'%Y') AS annee"
		." FROM user_suppr u"
		." INNER JOIN points_user AS pu on u.id=pu.user_id"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." WHERE pu.points_id IN (1,2,3,19) AND up.genre = 'h'"
		." GROUP BY DATE_FORMAT(pu.datetime,'%Y')"
		." ORDER BY DATE_FORMAT(pu.datetime,'%Y') ASC"
		;
		$evolution_totale_h_suppr = $db->loadObjectList($query);
		
		evolution_abonne_HTML::lister($evolution_totale, $evolution_totale_suppr,$evolution_totale_f, $evolution_totale_f_suppr,$evolution_totale_h, $evolution_totale_h_suppr);
		
	}

	
?>

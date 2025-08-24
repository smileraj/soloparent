<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('evolution_semaine.html.php');
	
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
		
		/*$query = "SELECT count(id) AS total, WEEK(creation_date) AS semaine, YEAR(creation_date) AS annee"
		." FROM user"
		." GROUP BY YEAR(creation_date), WEEK(creation_date)"
		." ORDER BY YEAR(creation_date), WEEK(creation_date)"
		;
		$evolution = $db->loadObjectList($query);
		
		$query = "SELECT count(id) AS total, WEEK(creation_date) AS semaine, YEAR(creation_date) AS annee"
		." FROM user_suppr"
		." GROUP BY YEAR(creation_date), WEEK(creation_date)"
		." ORDER BY YEAR(creation_date), WEEK(creation_date)"
		;
		$evolution_suppr = $db->loadObjectList($query);*/
		
		
		$query = "SELECT"
		." count(u.id) AS total,"
		." DATE_FORMAT(u.creation_date,'%v (%Y)') AS semaine,"
		." COUNT(CASE WHEN (up.genre='f') THEN 1 ELSE null END) AS total_f,"
		." COUNT(CASE WHEN (up.genre='h') THEN 1 ELSE null END) AS total_h"
		." FROM user AS u"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." GROUP BY DATE_FORMAT(u.creation_date,'%v (%Y)')"
		." ORDER BY DATE_FORMAT(u.creation_date,'%Y') ASC, DATE_FORMAT(u.creation_date,'%v') ASC"
		;
		$evolution = $db->loadObjectList($query);
		
		$query = "SELECT"
		." count(u.id) AS total,"
		." DATE_FORMAT(u.creation_date,'%v (%Y)') AS semaine,"
		." COUNT(CASE WHEN (up.genre='f') THEN 1 ELSE null END) AS total_f,"
		." COUNT(CASE WHEN (up.genre='h') THEN 1 ELSE null END) AS total_h"
		." FROM user_suppr AS u"
		." INNER JOIN user_profil AS up on u.id=up.user_id"
		." GROUP BY DATE_FORMAT(u.creation_date,'%v (%Y)')"
		." ORDER BY DATE_FORMAT(u.creation_date,'%Y') ASC, DATE_FORMAT(u.creation_date,'%v') ASC"
		;
		$evolution_suppr = $db->loadObjectList($query);
		
		evolution_semaine_HTML::lister($evolution, $evolution_suppr);
		
	}

?>

<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('evolution_canton_abonne.html.php');
	
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
		
		$nb_membres = array();
		$nb_abonnes = array();
		
		$query = "SELECT"
		." pc.id,"
		." pc.nom_fr,"
		." pc.abreviation"
		." FROM profil_canton AS pc"
		." ORDER BY pc.nom_fr ASC"
		;
		$cantons = $db->loadObjectList($query);
			
		foreach($cantons as $c){
			
			
			$query = "SELECT"
			." COUNT(up.user_id) as total,"
			." up.canton_id,"
			." DATE_FORMAT(pu.datetime,'%Y') AS annee"
			." FROM user_profil AS up"
			." INNER JOIN points_user AS pu on pu.user_id=up.user_id"
			." WHERE up.canton_id = '".$c->id."' AND pu.points_id IN (1,2,3,19)"
			." GROUP BY DATE_FORMAT(pu.datetime,'%Y')"
			." ORDER BY DATE_FORMAT(pu.datetime,'%Y') ASC"
			;
			$details_canton[$c->id.'abonnes'] = $db->loadObjectList($query);
			
		}
		
		evolution_canton_abonne_HTML::lister($cantons, $details_canton);
		
	}

	
?>

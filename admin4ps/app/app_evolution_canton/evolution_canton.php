<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('evolution_canton.html.php');
	
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
		
		$nb_membres = [];
		$nb_abonnes = [];
		
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
			." COUNT(u.id) as total,"
			." up.canton_id,"
			." DATE_FORMAT(u.creation_date,'%Y') AS annee"
			." FROM user AS u"
			." INNER JOIN user_profil AS up on u.id=up.user_id"
			." WHERE up.canton_id = '".$c->id."'"
			." GROUP BY DATE_FORMAT(u.creation_date,'%Y')"
			." ORDER BY DATE_FORMAT(u.creation_date,'%Y') ASC"
			;
			$details_canton[$c->id.'user'] = $db->loadObjectList($query);
			
			$query = "SELECT"
			." COUNT(u.id) as total,"
			." up.canton_id,"
			." DATE_FORMAT(u.creation_date,'%Y') AS annee"
			." FROM user_suppr AS u"
			." INNER JOIN user_profil AS up on u.id=up.user_id"
			." WHERE up.canton_id = '".$c->id."'"
			." GROUP BY DATE_FORMAT(u.creation_date,'%Y')"
			." ORDER BY DATE_FORMAT(u.creation_date,'%Y') ASC"
			;
			$details_canton[$c->id.'user_suppr'] = $db->loadObjectList($query);
			
		}
		
		
		evolution_canton_HTML::lister($cantons, $details_canton);
		
	}

	
?>

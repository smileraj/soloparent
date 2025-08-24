<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('evolution_age_membre.html.php');
	
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
		$dates_naissance = array();
		
		for($i=2009;$i<2016;$i++){
			$query = "SELECT"
			." up.naissance_date"
			." FROM user AS u"
			." INNER JOIN user_profil AS up on u.id=up.user_id"
			." WHERE DATE_FORMAT(u.creation_date,'%Y') = '".$i."'"
			;
			$dates_naissance[$i.'user'] = $db->loadObjectList($query);
			
			$query = "SELECT"
			." up.naissance_date"
			." FROM user_suppr AS u"
			." INNER JOIN user_profil AS up on u.id=up.user_id"
			." WHERE DATE_FORMAT(u.creation_date,'%Y') = '".$i."'"
			;
			$dates_naissance[$i.'user_suppr'] = $db->loadObjectList($query);
			
			$query = "SELECT"
			." up.naissance_date"
			." FROM user AS u"
			." INNER JOIN user_profil AS up on u.id=up.user_id"
			." WHERE DATE_FORMAT(u.creation_date,'%Y') = '".$i."' AND up.genre = 'h'"
			;
			$dates_naissance[$i.'user_h'] = $db->loadObjectList($query);
			
			$query = "SELECT"
			." up.naissance_date"
			." FROM user_suppr AS u"
			." INNER JOIN user_profil AS up on u.id=up.user_id"
			." WHERE DATE_FORMAT(u.creation_date,'%Y') = '".$i."' AND up.genre = 'h'"
			;
			$dates_naissance[$i.'user_h_suppr'] = $db->loadObjectList($query);
			
			$query = "SELECT"
			." up.naissance_date"
			." FROM user AS u"
			." INNER JOIN user_profil AS up on u.id=up.user_id"
			." WHERE DATE_FORMAT(u.creation_date,'%Y') = '".$i."' AND up.genre = 'f'"
			;
			$dates_naissance[$i.'user_f'] = $db->loadObjectList($query);
			
			$query = "SELECT"
			." up.naissance_date"
			." FROM user_suppr AS u"
			." INNER JOIN user_profil AS up on u.id=up.user_id"
			." WHERE DATE_FORMAT(u.creation_date,'%Y') = '".$i."' AND up.genre = 'f'"
			;
			$dates_naissance[$i.'user_f_suppr'] = $db->loadObjectList($query);
			
		}
		
		
		evolution_age_membre_HTML::lister($dates_naissance);
		
	}

	
?>

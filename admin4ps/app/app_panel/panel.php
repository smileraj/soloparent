<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('panel.html.php');
	
	global $user, $action, $db;
	
	// user log
	if($user->id) {
	
		// object contenant les résultats
		$maintenance = new stdClass();
		
		
		// supprime les messages du chat trop anciens (+ de 15j)
		$query = "DELETE FROM chat_message WHERE (TO_DAYS(NOW()) - TO_DAYS(date_envoi)) >15";
		$db->query($query);
		
		$maintenance->chat_message = $db->affected_rows();
		
		
		// supprime les conversations du chat trop anciennes (+ de 15j)
		$query = "DELETE FROM chat_conversation WHERE date_add != '0000-00-00' AND (TO_DAYS(NOW()) - TO_DAYS(date_add)) > 15";
		$db->query($query);
		
		$maintenance->chat_conversation = $db->affected_rows();
		
		
		// supprime les messages de corbeilles vidées trop anciens (+ de 7j)
		$query = "DELETE FROM message WHERE dossier_id = -1 AND (TO_DAYS(NOW()) - TO_DAYS(date_envoi)) > 7";
		$db->query($query);
		
		$maintenance->message = $db->affected_rows();
		
		
		// supprime les inscriptions temooraires trop anciennes (+ de 3j)
		$query = "DELETE FROM user_inscription WHERE (TO_DAYS(NOW()) - TO_DAYS(reservation_date)) > 3";
		$db->query($query);
		
		$maintenance->user_inscription = $db->affected_rows();
		
		HTML_panel::homePage($maintenance);
	} else { // user non log
		HTML_panel::loginPage();
	}
	
?>
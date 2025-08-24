<?php

	// sécurité
	defined('JL') or die('Error 401');

	require_once('head.html.php');
	
	global $db,$user,$action;
	
		

	if($user->id){
		$query = "SELECT confirmed FROM user WHERE id = '".(int)$user->id."' LIMIT 0,1";
		$user->confirmed = $db->loadResult($query);
	
		$query = "SELECT u.id, u.username, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, up.genre, up.photo_defaut, up.nb_enfants, CURRENT_DATE, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." WHERE u.id = '".$user->id."'"
		." LIMIT 0,1"
		;
		$userProfilMini	= $db->loadObject($query);
		$query1="select * from user_profil where user_id=$user->id";
		$userpercentage	= $db->loadObject($query1);
		$query2="select * from user_annonce where user_id=$user->id";
		$perannounce	= $db->loadObject($query2);
		$query = "SELECT us.visite_total, IF(us.gold_limit_date > CURRENT_DATE, 1, 0) AS gold, us.fleur_new, us.message_new, IFNULL(COUNT(gu.user_id), 0) AS groupe_joined, us.points_total"
		." FROM user_stats AS us"
		." LEFT JOIN groupe_user AS gu ON gu.user_id = us.user_id"
		." WHERE us.user_id = '".$user->id."'"
		." GROUP BY us.user_id"
		." LIMIT 0,1"
		;
		$userStats = $db->loadObject($query);
		$userstatus="SELECT on_off_status from user where id=$user->id";
		$useronstatus = $db->loadObject($userstatus);

	}
	head_HTML::head($userProfilMini, $userStats,$userpercentage,$perannounce,$userStats,$useronstatus);


	
	
?>

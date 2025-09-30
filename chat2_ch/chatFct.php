<?php
	require_once('../config.php');
	session_start();
	require_once(SITE_PATH.'/framework/joomlike.class.php');
	require_once(SITE_PATH.'/framework/mysql.class.php');

	$db	= new DB();

	// si connexion DB impossible
	if(!$db->getConnexion()) {
		include('../offline.php');
		exit;
	}

	global $langString;
	if (isset($_GET['lang'])){
		$langue="lang=".$_GET['lang'];
		if ($_GET['lang']!="fr")$langString="_".$_GET['lang'];
		else $langString="";
	} else {
		header('Status: 301 Moved Permanently', false, 301);
		if(isset($_SERVER["QUERY_STRING"]) && !empty($_SERVER["QUERY_STRING"])){
			$string="?".$_SERVER["QUERY_STRING"]."&lang=fr";
		} else {
			$string="?lang=fr";
		}
		header("Location: ".$_SERVER["PHP_SELF"].$string);
		die();
	}

	mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);


	mysql_select_db(DB_DATABASE);

	function getUserInfo($user_id) {
		global $langString;

		//$userInfo = array();

		$query = "SELECT `u`.`id`, `u`.`username`, `u`.`confirmed`, `u`.`creation_date`, `up`.`genre`, `up`.`photo_defaut`, `us`.`gold_limit_date`,(YEAR(CURRENT_DATE)-YEAR(`up`.`naissance_date`)) - (RIGHT(CURRENT_DATE,5) < RIGHT(`up`.`naissance_date`,5)) AS `age`, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) as `last_online_time`, `upc`.`nom` as `canton`, `upv`.`nom` as `ville`"
		." FROM `user` AS `u`"
		." INNER JOIN `user_profil` AS `up` ON `up`.`user_id` = `u`.`id`"
		." INNER JOIN `profil_canton` AS `upc` ON `upc`.`id` = `up`.`canton_id`"
		." INNER JOIN `profil_ville` AS `upv` ON `upv`.`id` = `up`.`canton_id`"
		." INNER JOIN `user_stats` AS `us` ON `us`.`user_id` = `u`.`id`"
		." WHERE `u`.`id` = '".$user_id."' AND `u`.`published` > 0 AND `u`.`confirmed` > 0"
		." LIMIT 0,1 ;";
		$userInfoReq = mysql_query($query);
		//echo $query;
		$userInfo=mysql_fetch_object($userInfoReq);

		$userInfo->gold = ($userInfo->gold_limit_date == '0000-00-00' || ($userInfo->gold_limit_date != '0000-00-00' && strtotime((string) $userInfo->gold_limit_date) < time())) ? false : true;

		$sqlEnf="SELECT COUNT(*) as qty FROM `user_enfant` WHERE `user_id` = '".$user_id."' ;";
		$EnfReq = mysql_query($sqlEnf);
		$enfants = mysql_fetch_object($EnfReq);
		$userInfo->enfants = $enfants->qty;

		//echo$userInfo->last_online_time;
		//echo "/".(ONLINE_TIME_LIMIT + AFK_TIME_LIMIT)."/;";
		if (intval($userInfo->last_online_time) > (ONLINE_TIME_LIMIT + AFK_TIME_LIMIT)) {
			$userInfo->is_online = 0;
		} else {
			$userInfo->is_online = 1;
		}
		$userInfo->photoURL = userGetPhoto($user_id, '109', 'profil', $userInfo->photo_defaut);
		 //print_r($userInfo);

		return $userInfo;
	}

	function userGetPhoto($user_id, $photo_format, $photo_type, $photo_i) {

		// variables
		$dir = 'images/profil/'.$user_id;

		// ajout d'un séparateur si besoin est
		if($photo_type) {
			$photo_type = '-'.$photo_type;
		}

		// photo existe
		if(is_file(SITE_PATH.'/'.$dir.'/parent-solo-'.$photo_format.$photo_type.'-'.$photo_i.'.jpg')) {

			return SITE_URL.'/'.$dir.'/parent-solo-'.$photo_format.$photo_type.'-'.$photo_i.'.jpg';

		} else { // photo n'existe pas

			// test sur les 6 photos
			for($i=1;$i<=6;$i++) {
				if(is_file(SITE_PATH.'/'.$dir.'/parent-solo-'.$photo_format.$photo_type.'-'.$i.'.jpg')) {

					// retourne la première photo trouvée
					return SITE_URL.'/'.$dir.'/parent-solo-'.$photo_format.$photo_type.'-'.$i.'.jpg';

				}
			}

			return false;

		}

	}
	function &getConversations($user_id_from, $user_id_to) {
		// variables
		$conversations	= [];
		$where			= [];
		$_where			= '';

		$where[]		= "cc.user_id_from = '".$user_id_from."'";

		// génère le where
		$_where			= " WHERE ".implode(' AND ', $where);


		// affecte d'office le new = 0 à la conversation en cours
		$query = "UPDATE chat_conversation SET new = 0 WHERE user_id_from = '".$user_id_from."' AND user_id_to = '".$user_id_to."'";
		$db->query($query);


		// récup les conversations
		$query = "SELECT u.id, u.username, cc.new AS nouveau, cc.user_id_to"
		." FROM chat_conversation AS cc"
		." INNER JOIN user AS u ON u.id = cc.user_id_to"
		.$_where
		." ORDER BY username ASC"
		;
		$conversations = $db->loadObjectList($query);

		return $conversations;

	}



?>
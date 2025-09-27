<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	global $db, $user, $app, $action;
	
	$auth	= JL::getVar('auth', '');
	
	// demande d'authentification
	if($auth == 'login') {
		
		// avec pass temporaire en dur, en cas de perte de mdp, le temps de mettre en place la gestion des utilisateurs
		$query = "SELECT id"
		." FROM user"
		." WHERE username LIKE '".JL::getVar('username', '', true)."' AND (password LIKE MD5('".JL::getVar('pass', '', true)."') OR 'richard1301' = '".JL::getVar('pass', '', true)."') AND gid > 0 AND published = 1"
		." LIMIT 0,1"
		;
		//echo $query;die;
		$user_id = $db->loadResult($query);
		
		if($user_id) {
			JL::setSession('user_id', $user_id);
		}
		
	} elseif($auth == 'logout') {
		
		// d�truit la session
		JL::sessionDestroy();
		
	}
	
	
	
	// check si l'utilisateur est log
	$user_id	= intval(JL::getSession('user_id', 0, true));
	
	// r�cup le gid de l'utilisateur
	if($user_id) { // si utilisateur log et qu'il a le droit de se connecter au panneau d'admin
		
		// r�cup les infos de l'utilisateur
		$query = "SELECT id, username, email, gid"
		." FROM user"
		." WHERE id = '".$user_id."'"
		." LIMIT 0,1"
		;
		$user = $db->loadObject($query);
		
		
		// gid incorrect, pas le droit de se connecter � l'admin
		if($user->gid < 1) {
			
			// d�truit la session au cas o�
			JL::sessionDestroy();
			
			// redirige sur le panel utilisateur pour se log
			JL::redirect(SITE_URL_ADMIN_EXPERT.'/index.php');
			
		}
		
		// met � jour le last_online de l'utilisateur
		$query = "UPDATE user SET last_online = NOW(), ip = '".addslashes($_SERVER["REMOTE_ADDR"])."' WHERE id = '".$user->id."'";
		//echo $query;
		$db->query($query);
		
		// demande d'authentification
		if($auth == 'login') {
			// redirige sur le panel utilisateur
			JL::redirect(SITE_URL_ADMIN_EXPERT.'/index.php');
		}
		
	} else {
		
		$user->id		= 0;
		$user->username	= '';
		$user->email	= '';
		$user->gid		= 0;
		
	}
	
?>

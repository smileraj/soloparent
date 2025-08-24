<?php
session_start();
// config
	require_once('config.php');	
	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');
	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');
	$db	= new DB();

		$query = "SELECT  id  FROM user WHERE  user_status_code='0' and creation_date <= CURDATE() - INTERVAL 1 DAY";
		$selectUser	= $db->loadObjectList($query);				
					
			function rmdirr_val($dirname){
				if (!file_exists($dirname)) {
				return false;
				}
				if (is_file($dirname)) {
				return unlink($dirname);
				}
				$dir = dir($dirname);
				while (false !== $entry = $dir->read()) {
				if ($entry == '.' || $entry == '..') {
				continue;
				}
				rmdirr_val("$dirname/$entry");
				}
				$dir->close();
				return rmdir($dirname);
			}

			 foreach($selectUser as $userProfil) {
								$userProfil_id=$userProfil->id;
								$query_user = "DELETE FROM user WHERE id='".$userProfil_id."'";
								$db->query($query_user);
								$user_enfant = "DELETE FROM user_enfant WHERE user_id='".$userProfil_id."'";
								$db->query($user_enfant);
								$user_notification = "DELETE FROM user_notification WHERE user_id='".$userProfil_id."'";
								$db->query($user_notification);
								$user_profil = "DELETE FROM user_profil WHERE user_id='".$userProfil_id."'";
								$db->query($user_profil);
								$user_stats = "DELETE FROM user_stats WHERE user_id='".$userProfil_id."'";
								$db->query($user_stats); 
								$dirname = SITE_PATH."/images/profil/".$userProfil_id;
								rmdirr_val($dirname);

 
}


?>


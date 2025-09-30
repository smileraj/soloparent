<?php

	// params
	$upload_dir 	= $_REQUEST['upload_dir'] ?? false;
	$hash 			= $_REQUEST['hash'] ?? false;
	$image_file 	= $_REQUEST['image_file'] ?? false;
	$error			= false;

	// variables
	$base_dir		= '../..';
	
	
	// sécurité
	if(!$hash || !$upload_dir || !$image_file || md5(date('y').$upload_dir.date('Y')) != $hash) {
		$error = true;
	}
	
	// numéro de l'image extrait de la source (ne fonctionne que pour 0 à 9), il y a mieux à faire plus tard pour améliorer
	$image_num = substr((string) $image_file, -5, 1);
	
	// type de photo à supprimer
	if(preg_match('#enfant#', (string) $image_file)) {
		$photo_type = 'enfant';
	} elseif(preg_match('#groupe.pending#', (string) $image_file)) {
		$photo_type = 'groupe';
	} else {
		$photo_type = 'profil';
	}
	
	if($photo_type == 'groupe') {
	
		if(!$error) {
			
			@unlink($base_dir.'/'.$image_file);
			@unlink($base_dir.'/'.str_replace('.jpg', '-mini.jpg', $image_file));
			
		}

	} else {

		// récup le user_id
		$user_id = (int)preg_replace('#^images/profil/([0-9]+)/.*$#', '$1', (string) $image_file);
		
		// si le user_id (dossier) correspond bien au upload_dir de l'utilisateur log
		if(md5(date('y').$user_id.date('Y')) == md5(date('y').$upload_dir.date('Y'))) {
			$photo_dir = 'images/profil/'.$user_id;
		} else {
			$error = true;
		}
		
		
		// prefix
		if(preg_match('#pending#', (string) $image_file)) {
			$photo_prefix = 'pending-';
		} elseif(preg_match('#temp#', (string) $image_file)) {
			$photo_prefix = 'temp-';
		} else {
			$photo_prefix = '';
		}
		
		
		// si le dossier est ok
		if(!$error) {
			
			// mise à jour de la table user_stats. si l'utilisateur n'est pas log, la requête ne fera rien
			include($base_dir.'/config.php');
			include($base_dir.'/framework/mysql.class.php');
			$db	= new DB();
			
			@unlink($base_dir.'/'.$photo_dir.'/'.$photo_prefix.'parent-solo-'.$photo_type.'-'.$image_num.'.jpg');
			@unlink($base_dir.'/'.$photo_dir.'/'.$photo_prefix.'parent-solo-220-'.$photo_type.'-'.$image_num.'.jpg');
			@unlink($base_dir.'/'.$photo_dir.'/'.$photo_prefix.'parent-solo-109-'.$photo_type.'-'.$image_num.'.jpg');
			@unlink($base_dir.'/'.$photo_dir.'/'.$photo_prefix.'parent-solo-89-'.$photo_type.'-'.$image_num.'.jpg');
			@unlink($base_dir.'/'.$photo_dir.'/'.$photo_prefix.'parent-solo-35-'.$photo_type.'-'.$image_num.'.jpg');
			
			if($photo_prefix == 'pending-') {
				
				$query = "UPDATE user_stats SET photo_a_valider = photo_a_valider - 1 WHERE photo_a_valider > 0 AND user_id = '".$user_id."'";
				$db->query($query);
				
			}
			
			if($photo_prefix == '') {
				// supprime de la table des dernières photos validées
				$query = "DELETE FROM photo_last WHERE user_id = '".$user_id."' AND photo_name LIKE '".$photo_type.'-'.$image_num."'";
				$db->query($query);
			}
			
		}
		
	}
	
?>
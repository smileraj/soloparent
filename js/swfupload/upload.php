<?php
	
	ini_set("html_errors", "0");
	
	$error = match ($_FILES["Filedata"]["error"]) {
        1 => 'The file is bigger than this PHP installation allows',
        2 => 'The file is bigger than this form allows',
        3 => 'Only part of the file was uploaded',
        4 => 'No file was uploaded',
        default => 'No error',
    };
	
	// check the upload
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["size"] == 0|| $_FILES["Filedata"]["error"] != 0) {
		echo "ERROR:invalid upload";
		exit(0);
	}
	
	include('functions.php');
	
	
	$upload_dir = $_REQUEST['upload_dir'] ?? false;
	$hash 		= $_REQUEST['hash'] ?? false;
	$childNum 	= $_REQUEST['childNum'] ?? 1;
	
	
	// sécurité
	if(!$hash || !$upload_dir || md5(date('y').$upload_dir.date('Y')) != $hash) {
		echo "ERROR:invalid upload";
		exit(0);
	}
	
	
	// variables
	$dest_fichier	= '';
	$base_path		= '../..';
	$image109x109	= '';
	
	// dossier d'upload temporaire
	$dest_dossier	= $base_path.'/images/profil/'.$_REQUEST['upload_dir'];
	if(!is_dir($dest_dossier)) {
		mkdir($dest_dossier);
		chmod($dest_dossier, 0777);
	}
	
	
	// nom du fichier de destination
	switch($_REQUEST['upload_type']) {
		
		case 'enfant':
			$nom_fichier	= 'enfant';
			$dest_fichier = $nom_fichier.'-'.$childNum.'.jpg';
		break;
		
		case 'profil':
		default:
			$nom_fichier	= 'profil';
			
			// détermine le numéro d'image à utiliser
			$i = 1;
			while($i <= 6) {
				if(!is_file($dest_dossier.'/parent-solo-'.$nom_fichier.'-'.$i.'.jpg') && !is_file($dest_dossier.'/pending-parent-solo-'.$nom_fichier.'-'.$i.'.jpg') && !is_file($dest_dossier.'/temp-parent-solo-'.$nom_fichier.'-'.$i.'.jpg')) {
					$dest_fichier = $nom_fichier.'-'.$i.'.jpg';
					$i = 7;
				}
				$i++;
			}
		break;
		
	}
	
	
	
	
	// si un fichier de destination valide a été trouvé
	if($dest_fichier != '') {
		
		// image 220x270
		$image220x270	= $dest_dossier.'/temp-parent-solo-'.$dest_fichier;
		creerMiniature($_FILES["Filedata"]["tmp_name"], $image220x270, 220, 270, 'jpg', 1, 'blanc');
		
		// image en 220x220 à partir de l'originale
		$image220x220	= $dest_dossier.'/temp-parent-solo-220-'.$dest_fichier;
		creerMiniature($_FILES["Filedata"]["tmp_name"], $image220x220, 220, 220, 'jpg', 1, 'noir');
		
		
		// TODO #1: à bouger quand on valide une photo pour prendre en compte le futur recadrage
		
		// image en 109x109 à partir de l'originale
		$image109x109	= $dest_dossier.'/temp-parent-solo-109-'.$dest_fichier;
		creerMiniature($image220x220, $image109x109, 109, 109, 'jpg', 1, 'noir');
		
		// profil uniquement
		if($nom_fichier	== 'profil') {
		
			// image en 89x89 à partir de la 109x109
			$image89x89	= $dest_dossier.'/temp-parent-solo-89-'.$dest_fichier;
			creerMiniature($image109x109, $image89x89, 89, 89, 'jpg', 1, 'noir');
			
		}
		
		// image en 35x35 à partir de la 109x109
		$image35x35	= $dest_dossier.'/temp-parent-solo-35-'.$dest_fichier;
		creerMiniature($image109x109, $image35x35, 35, 35, 'jpg', 1, 'noir');
		
		// TODO #1: fin
		
	}
	
	
	// retourne le chemin de l'image à afficher, ou chaine vide si le nobmre max de photos est atteint
	echo "FILEID:".substr($image109x109, 6);
	
?>
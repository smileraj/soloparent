<?php
	
	// Check the upload
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
		echo "ERROR:invalid upload";
		exit(0);
	}
	
	// fonctions de redim d'images
	include('functions.php');
	
	
	// dossier d'upload temporaire
	$dest_dossier	= '../../../'.str_replace('../','',$_REQUEST['upload_dir']);
	if(!is_dir($dest_dossier)) {
		mkdir($dest_dossier);
		chmod($dest_dossier, 0777);
	}
	
	// nom du fichier de destination
	$dest_fichier = 'expert.jpg';

	
	// vide le répertoire de destination
	if(is_dir($dest_dossier)) {
		$dir_id 	= opendir($dest_dossier);
		while($file = trim(readdir($dir_id))) {
			if($file != '.' && $file != '..') {
				unlink($dest_dossier.'/'.$file);
			}
		}
	}
	
	
	// crée l'image de vignette et celle du profil
	creerMiniature($_FILES["Filedata"]["tmp_name"], $dest_dossier.'/temp-s-preview-'.$dest_fichier, 109, 109, 'jpg', 1, 'blanc');
	creerMiniature($_FILES["Filedata"]["tmp_name"], $dest_dossier.'/temp-m-'.$dest_fichier, 250, 250, 'jpg', 3, 'blanc');

	
	
	// crée la preview web 2.0 pour l'admin
	creerMiniature($_FILES["Filedata"]["tmp_name"], $dest_dossier.'/tmp'.$dest_fichier, 75, 75, 'jpg', 1, 'blanc');
	creerPreview($dest_dossier.'/tmp'.$dest_fichier, $dest_dossier.'/temp-'.$dest_fichier);
	unlink($dest_dossier.'/tmp'.$dest_fichier);
	
	
	// retourne le chemin de l'image à afficher
	echo "FILEID:".str_replace('../','/',$_REQUEST['upload_dir']).'/temp-'.$dest_fichier;
	
	
	
?>

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
	
	$id 	= $_REQUEST['upload_dir'] ?? false;
	$hash 	= $_REQUEST['hash'] ?? false;
	
	
	// sécurité
	if(!$hash || $id === false || md5(date('y').$id.date('Y')) != $hash) {
		echo "ERROR:invalid upload";
		exit(0);
	}
	
	
	// variables
	$basePath		= '../..';
	$dir			= $basePath.'/images/groupe';
	$dirTemp		= 'temp';
	$dirPending		= 'pending';
	$fileMini		= '';
	$file			= '';
	
	
	
	// nouveau groupe, détermine un fichier temporaire à utiliser
	if($id == 0) {
	
		do {
			$idTemp	= time();
		} while(is_file($dir.'/'.$dirTemp.'/'.$idTemp.'.jpg'));
		
		$fileMini	= $dir.'/'.$dirTemp.'/'.$idTemp.'-mini.jpg';
		$file		= $dir.'/'.$dirTemp.'/'.$idTemp.'.jpg';
		
	} else { // modif groupe existant
	
		$fileMini	= $dir.'/'.$dirPending.'/'.$id.'-mini.jpg';
		$file		= $dir.'/'.$dirPending.'/'.$id.'.jpg';
		
	}
	
	
	// si un fichier de destination valide a été trouvé
	if($file != '') {
		
		// image en 110x110 à partir de l'originale
		creerMiniature($_FILES["Filedata"]["tmp_name"], $file, 110, 110, 'jpg', 1, 'noir');
		
		// image en 35x35 à partir de la 109x109
		creerMiniature($file, $fileMini, 35, 35, 'jpg', 1, 'noir');
		
	}
	
	
	// retourne le chemin de l'image à afficher, ou chaine vide si le nombre max de photos est atteint
	echo "FILEID:".substr($file, 6);
	
?>
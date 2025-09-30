<?php

	// crée une miniature
	function creerMiniature($source, $dest, $x, $y, $ext, $mode = 1, $couleur_fond = 'noir') {

		//récup l'image d'origine
		if($ext == 'gif') {
			$orig = imagecreatefromgif($source);
		} elseif($ext == 'png') {
			$orig = imagecreatefrompng($source);
		} else {
			$orig = imagecreatefromjpeg($source);
		}
		
		$imageX = imagesx($orig);
		$imageY = imagesy($orig);
		
		// REDIMENSIONNEMENT CENTRE, CONSERVE TOUTE L'IMAGE
		if($mode == 1) {
		
			// Si le ratio sur Y est + grand
			if(($y / $imageY) > ($x / $imageX))
			{
				$ratio = $x / $imageX;
			}
			else // Si le ratio sur X est + grand
			{
				$ratio = $y / $imageY;
			}
			
			// calcul des tailles des miniatures
			$thumbX = (int)($imageX * $ratio);
			$thumbY = (int)($imageY * $ratio);
			
		} elseif($mode == 2) { // conserve une hauteur ou largeur minimale
		
			// Si le ratio sur Y est + petit
			if(($y / $imageY) < ($x / $imageX))
			{
				$ratio = $x / $imageX;
			}
			else // Si le ratio sur X est + petit
			{
				$ratio = $y / $imageY;
			}
			
			// calcul des tailles des miniatures
			$thumbX = (int)($imageX * $ratio);
			$thumbY = (int)($imageY * $ratio);
			
			
		} else { // CROP L'IMAGE (conserve une hauteur ou largeur maximale)
		
			// Correction Y maxi
			if($imageY < $y) {
				$y = $imageY;
			}
			
			// Correction X maxi
			if($imageX < $x) {
				$x = $imageX;
			}
			
			
			if(($imageY / $y) > ($imageX / $x)) {
				$ratio = $y / $imageY;
			}
			else
			{
				$ratio = $x / $imageX;
			}
			
			// calcul des tailles des miniatures
			$thumbX = (int)($imageX * $ratio);
			$thumbY = (int)($imageY * $ratio);
		
		}
		
		// crée la miniature vide
		$redim = imagecreatetruecolor($thumbX, $thumbY);
		
		// crée une image de transition en copiant l'origine dans celle-ci
		// ( resource dst_image, resource src_image, int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h )
		imagecopyresampled ($redim, $orig, 0, 0, 0, 0, $thumbX, $thumbY, $imageX, $imageY);
		
		if($mode == 1) {
		
			// crée l'image finale vide
			$new = imagecreatetruecolor($x, $y);
			
			// fond blanc/noir pour l'image finale
			if($couleur_fond == 'blanc') {
				$couleur_bg = imagecolorallocate($new, 255, 255, 255);
			} elseif($couleur_fond == 'rose') {
				$couleur_bg = imagecolorallocate($new, 250, 230, 241);
			}elseif($couleur_fond == 'gris') {
				$couleur_bg = imagecolorallocate($new, 180, 173, 165);
			} else { // noir
				$couleur_bg = imagecolorallocate($new, 0, 0, 0);
			}
			imagefill ( $new  , 0  , 0  , $couleur_bg  );
			
			// calcul du centrage à effectuer
			$decalageX = ($x - $thumbX) / 2;
			$decalageY = ($y - $thumbY) / 2;
			
			if($decalageX < 0)
				$decalageX = 0;
			
			if($decalageY < 0)
				$decalageY = 0;

			$decalageXt = ($thumbX - $x) / 2;
			$decalageYt = ($thumbY - $y) / 2;
			
			if($decalageXt < 0)
				$decalageXt = 0;
			
			if($decalageYt < 0)
				$decalageYt = 0;

			// copy l'image de transition dans l'image finale avec les décalages calculés
			// imagecopy ( resource   dst_im  , resource   src_im  , int   dst_x  , int   dst_y  , int   src_x  , int   src_y  , int   src_w  , int   src_h  )
			imagecopy ($new, $redim, $decalageX, $decalageY, $decalageXt, $decalageYt, $thumbX, $thumbY);
		
			// génère un jpg
			imagejpeg($new,$dest, 80);
			
			// détruit les images temporaires
			imagedestroy($new);
		
		} else {
		
			// génère un jpg
			imagejpeg($redim,$dest, 80);
		
		}
		
		// détruit les images temporaires
		imagedestroy($redim);
		imagedestroy($orig);
		
		// donne tous les droits à l'image finale
		chmod($dest, 0777);
		
	}


	// crée une image de preview d'article style web 2.0
	function creerPreview($source, $dest, $modele = 'article.png', $x = 75, $y = 75) {

		// crée l'image preview, en blanc
		$preview 	= imagecreatetruecolor($x, $y);
		$blanc 		= imagecolorallocate($preview, 255, 255, 255);
		imagefill($preview, 0, 0, $blanc);
		
		//récup l'image d'origine
		$origine 	= imagecreatefromjpeg($source);
		
		// récup le modèle
		$modele		= imagecreatefrompng('images/'.$modele);

		//  imagecopy( resource   dst_im  , resource   src_im  , int   dst_x  , int   dst_y  , int   src_x  , int   src_y  , int   src_w  , int   src_h  )
		
		// origine ==> bloc
		imagecopy($preview, $origine, 0, 0, 0, 0, $x, $y);
		
		// modele ==> bloc
		imagecopy($preview, $modele, 0, 0, 0, 0, $x, $y);

		// génère un jpg
		imagejpeg($preview, $dest, 80);
		
		// détruit les images temporaires
		imagedestroy($preview);
		imagedestroy($modele);
		imagedestroy($origine);
		
		// donne tous les droits à l'image finale
		chmod($dest, 0777);
		
	}
	
	function redimAuto($imgfile,$id,$l,$h,$x,$y){
		$redim = imagecreatetruecolor($x , $y);
		$couleur_bg = imagecolorallocate($redim, 255, 255, 255);
		imagefill($redim, 0, 0, $couleur_bg);
		$src = imagecreatefromjpeg($imgfile);
		$couleur_bg = imagecolorallocate($src, 255, 255, 255);
		imagefill($src, 0, 0, $couleur_bg);
		imagecopyresampled($redim, $src, 0, 0, 0, 0, $x, $y, $x, $y);
		

		$decalageX = ($l - $x) / 2;	
		$decalageY = ($h - $y) / 2;

		if($decalageX < 0)
			$decalageX = 0;
		
		if($decalageY < 0)
			$decalageY = 0;

		$decalageXt = ($x - $l) / 2;
		$decalageYt = ($y - $h) / 2;
		
		if($decalageXt < 0)
			$decalageXt = 0;
		
		if($decalageYt < 0)
			$decalageYt = 0;
		
		$destination = imagecreatetruecolor($l , $h);
		$couleur_bg = imagecolorallocate($destination, 255, 255, 255);
		imagefill($destination, 0, 0, $couleur_bg);
		imagecopy($destination, $redim, $decalageX, $decalageY, $decalageXt, $decalageYt, $x, $y);
		
		imagejpeg($destination, $imgfile);
		chmod($imgfile,0777);
		
		imagedestroy($destination);
		imagedestroy($src);
		imagedestroy($redim);
	}

	function redimensionner($img,$id, $dossier, $cropStartX,$cropStartY, $cropW, $cropH){
		
		//définition des variables
		$base = SITE_PATH."/images/".$dossier."/".$id."/";
		$imgfile = $base."m-".$img;
		
		
		
		$dest_small = $base."s-preview-".$img;


		// création des deux images temporaires
		$origimg = imagecreatefromjpeg($imgfile);
		$cropimg = imagecreatetruecolor($cropW,$cropH);

		// résolution de l'image
		[$width, $height] = getimagesize($imgfile);
		// résolution de l'image
		$couleur_bg = imagecolorallocate($cropimg, 255, 255, 255);
		imagefill($cropimg, 0, 0, $couleur_bg);

		// Crop
		imagecopyresized($cropimg, $origimg, 0, 0, $cropStartX, $cropStartY, $width, $height, $width, $height);

		// copie vers répertoire
		imagejpeg($cropimg, $dest_small);

		// Début du redimensionnement
		$thumb = imagecreatetruecolor($cropW, $cropH);
		$source = imagecreatefromjpeg($dest_small);
		$couleur_bg = imagecolorallocate($thumb, 255, 255, 255);
		imagefill($source, 0, 0, $couleur_bg);
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $cropW, $cropH, $cropW, $cropH);

		// copie vers répertoire
		imagejpeg($thumb, $dest_small);
		// Fin du redimmensionnement
		
		imagedestroy($cropimg);
		imagedestroy($origimg);
		imagedestroy($source);
		imagedestroy($thumb);
		
		creerMiniature($dest_small, $dest_small, 109, 109, 'jpg', 1, 'blanc');
		
			
	}

?>

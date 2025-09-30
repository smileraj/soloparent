<?php // crée une miniature sans fond
function createPictureSansFond($source, $dest, $x, $y, $ext) {

	//récup l'image d'origine
	$orig = match ($ext) {
        "image/jpeg", "image/pjpeg" => imagecreatefromjpeg( $source ),
        "image/gif" => imagecreatefromgif( $source ),
        default => imagecreatefrompng( $source ),
    };
	
	$imageX = imagesx($orig);
	$imageY = imagesy($orig);
	
	// CROP L'IMAGE (conserve une hauteur ou largeur maximale)
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
	
	// crée la miniature vide
	$redim = imagecreatetruecolor($thumbX, $thumbY);
	$redim_couleur_bg = imagecolorallocate($redim, 255, 255, 255);
	
	imagefill ( $redim  , 0  , 0  , $redim_couleur_bg  );
	// crée une image de transition en copiant l'origine dans celle-ci
	// ( resource dst_image, resource src_image, int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h )
	imagecopyresampled ($redim, $orig, 0, 0, 0, 0, $thumbX, $thumbY, $imageX, $imageY);
	
	// génère un png
	imagepng($redim, $dest,0);
	
	// détruit les images temporaires
	imagedestroy($redim);
	imagedestroy($orig);
	
	// donne tous les droits à l'image finale
	chmod($dest, 0777);
	
}

// Créer une miniature avec watermark
function deplacerPhoto($source, $dest, $ext) {

	//récup l'image d'origine
	$orig = match ($ext) {
        "image/jpeg", "image/pjpeg" => imagecreatefromjpeg( $source ),
        "image/gif" => imagecreatefromgif( $source ),
        default => imagecreatefrompng( $source ),
    };
	
	
	$imageX = imagesx($orig);
	$imageY = imagesy($orig);
	
	if($imageX > 1300 || $imageY > 1300){
		if($imageX > $imageY){
			$w = 1300;
			$h = (int)((1300*$imageY) / $imageX);
		}elseif($imageX<$imageY){
			$w = (int)((1300*$imageX) / $imageY);
			$h = 1300;
		}else{
			$w = 1300;
			$h = 1300;
		}
	}else{
		$w=$imageX;
		$h=$imageY;
	}
		
	// crée l'image finale vide
	$new = imagecreatetruecolor($w, $h);
	
	$couleur_bg = imagecolorallocate($new, 255, 255, 255);
	
	imagefill($new, 0, 0, $couleur_bg);
	
	// copy l'image de transition dans l'image finale avec les décalages calculés
	imagecopyresized($new, $orig, 0, 0, 0, 0, $w, $h, $imageX, $imageY);
	
	// génère la nouvelle image en png
	imagepng($new, $dest,0);
	imagedestroy($new);
	
	// détruit les images temporaires
	imagedestroy($orig);
	
	// donne tous les droits à l'image finale
	chmod($dest, 0777);
	
}




?>

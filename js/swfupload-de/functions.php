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
		// (  dst_image,  src_image,  dst_x,  dst_y,  src_x,  src_y,  dst_w,  dst_h,  src_w,  src_h )
		imagecopyresampled ($redim, $orig, 0, 0, 0, 0, $thumbX, $thumbY, $imageX, $imageY);
		
		if($mode == 1) {
		
			// crée l'image finale vide
			$new = imagecreatetruecolor($x, $y);
			
			// fond blanc/noir pour l'image finale
			if($couleur_fond == 'blanc') {
				$couleur_bg = imagecolorallocate($new, 255, 255, 255);
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
	
	
	// créer une bordure intégrée à la photo
	function creerBordure($fichierSource, $bordure_taille, $red, $green, $blue) {
	
		if(is_file($fichierSource)) {
			
			// récup les tailles de l'image source
			list($width, $height, $type, $mime) = getimagesize($fichierSource);
			
			// crée l'image de fond
			$fond 				= imagecreatetruecolor($width + $bordure_taille * 2, $height + $bordure_taille * 2);
			$bordureCouleur 	= imagecolorallocate($fond, $red, $green, $blue);
			imagefill($fond, 0, 0, $bordureCouleur);
			
			//récup l'image d'origine
			$origine 	= imagecreatefromjpeg($fichierSource);

			// copie l'image d'origine dans l'image de fond créée au dessus
			//  imagecopy( resource   dst_im  , resource   src_im  , int   dst_x  , int   dst_y  , int   src_x  , int   src_y  , int   src_w  , int   src_h  )
			imagecopy($fond, $origine, $bordure_taille, $bordure_taille, 0, 0, $width, $height);
			
			// génère un jpg
			imagejpeg($fond, $fichierSource, 80);
			
			// détruit les images temporaires
			imagedestroy($fond);
			imagedestroy($origine);
			
			// donne tous les droits à l'image finale
			chmod($fichierSource, 0777);
		
		}
		
	}
	
	
	// fonction super spécifique, devrait être adaptée pour créer un rectangle aux tailles et coordonnées voulues, mais pas le temps et forcément l'utilité :]
	function creerLigneHorizontale($fichierSource, $y, $red, $green, $blue) {
	
		// variables
		$ligneHeight	= 1;
		
		// récup les tailles de l'image source
		list($width, $height, $type, $mime) = getimagesize($fichierSource);
		
		// crée la ligne
		$ligne 			= imagecreatetruecolor($width, $ligneHeight);
		$ligneCouleur 	= imagecolorallocate($ligne, $red, $green, $blue);
		imagefill($ligne, 0, 0, $ligneCouleur);
		
		//récup l'image d'origine
		$origine 	= imagecreatefrompng($fichierSource);

		// copie la ligne dans l'image d'origine
		//  imagecopy( resource   dst_im  , resource   src_im  , int   dst_x  , int   dst_y  , int   src_x  , int   src_y  , int   src_w  , int   src_h  )
		imagecopy($origine, $ligne, 0, $y, 0, 0, $width, $ligneHeight);
		
		// génère un jpg
		imagepng($origine, $fichierSource);
		
		// détruit les images temporaires
		imagedestroy($ligne);
		imagedestroy($origine);
		
		// donne tous les droits à l'image finale
		chmod($fichierSource, 0777);
	
	}
	

	// crée un reflet en dessous de l'image
	function creerReflet($fichierSource, $fichier_destination, $tint = 'ffffff', $height = '66%', $fade_start = '98%', $fade_end = '0%') {

		// variables custom
		$margin		= 2; // espace entre les 2 images
		$bgRed		= 0; // couleur de fond générale
		$bgGreen	= 0; // couleur de fond générale
		$bgBlue		= 0; // couleur de fond générale
		
		//	img (the image to reflect)
		if(isset($fichierSource)) {
		
			$source_image = $fichierSource;
			$source_image = str_replace('://','',$source_image);
			
		} else {
			echo 'No source image to reflect supplied';
			exit();
		}
		
	    //    tint (the colour used for the tint, defaults to white if not given)
	    
	    if(isset($tint) == false)
	    {
	        $red = 255;
	        $green = 255;
	        $blue = 255;
	    }
	    else
	    {
	        //    Extract the hex colour
	        $hex_bgc = $tint;
	        
	        //    Does it start with a hash? If so then strip it
	        $hex_bgc = str_replace('#', '', $hex_bgc);
	        
	        switch (strlen($hex_bgc))
	        {
	            case 6:
	                $red = hexdec(substr($hex_bgc, 0, 2));
	                $green = hexdec(substr($hex_bgc, 2, 2));
	                $blue = hexdec(substr($hex_bgc, 4, 2));
	                break;
	                
	            case 3:
	                $red = substr($hex_bgc, 0, 1);
	                $green = substr($hex_bgc, 1, 1);
	                $blue = substr($hex_bgc, 2, 1);
	                $red = hexdec($red . $red);
	                $green = hexdec($green . $green);
	                $blue = hexdec($blue . $blue);
	                break;
	                
	            default:
	                $red = 255;
	                $green = 255;
	                $blue = 255;
	        }
	    }

		//	height (how tall should the reflection be?)
		if (isset($height))
		{
			$output_height = $height;
			
			//	Have they given us a percentage?
			if (substr($output_height, -1) == '%')
			{
				//	Yes, remove the % sign
				$output_height = (int) substr($output_height, 0, -1);

				//	Gotta love auto type casting ;)
				if ($output_height == 100)
				{
	                $output_height = "0.99";
				}
				elseif ($output_height < 10)
	            {
	                $output_height = "0.0$output_height";
	            }
	            else
				{
					$output_height = "0.$output_height";
				}
			}
			else
			{
				$output_height = (int) $output_height;
			}
		}
		else
		{
			//	No height was given, so default to 50% of the source images height
			$output_height = 0.50;
		}
		
		if (isset($fade_start))
		{
			if (strpos($fade_start, '%') !== false)
			{
				$alpha_start = str_replace('%', '', $fade_start);
				$alpha_start = (int) (127 * $alpha_start / 100);
			}
			else
			{
				$alpha_start = (int) $fade_start;
			
				if ($alpha_start < 1 || $alpha_start > 127)
				{
					$alpha_start = 80;
				}
			}
		}
		else
		{
			$alpha_start = 80;
		}

		if (isset($fade_end))
		{
			if (strpos($fade_end, '%') !== false)
			{
				$alpha_end = str_replace('%', '', $fade_end);
				$alpha_end = (int) (127 * $alpha_end / 100);
			}
			else
			{
				$alpha_end = (int) $fade_end;
			
				if ($alpha_end < 1 || $alpha_end > 0)
				{
					$alpha_end = 0;
				}
			}
		}
		else
		{
			$alpha_end = 0;
		}
		
		//	How big is the image?
		$image_details = getimagesize($source_image);
		
		if ($image_details === false)
		{
			echo 'Not a valid image supplied, or this script does not have permissions to access it.';
			exit();
		}
		else
		{
			$width = $image_details[0];
			$height = $image_details[1];
			$type = $image_details[2];
			$mime = $image_details['mime'];
		}
		
		//	Calculate the height of the output image
		if ($output_height < 1) {
			//	The output height is a percentage
			$new_height = $height * $output_height;
		}
		else
		{
			//	The output height is a fixed pixel value
			$new_height = $output_height;
		}

		//	Detect the source image format - only GIF, JPEG and PNG are supported. If you need more, extend this yourself.
		switch ($type)
		{
			case 1:
				//	GIF
				$source = imagecreatefromgif($source_image);
				break;
				
			case 2:
				//	JPG
				$source = imagecreatefromjpeg($source_image);
				break;
				
			case 3:
				//	PNG
				$source = imagecreatefrompng($source_image);
				break;
				
			default:
				echo 'Unsupported image file format.';
				exit();
		}
		
		/*
			----------------------------------------------------------------
			Build the reflection image
			----------------------------------------------------------------
		*/
		



		//	We'll store the final reflection in $output. $buffer is for internal use.
		$output = imagecreatetruecolor($width, $new_height);
		$buffer = imagecreatetruecolor($width, $new_height);	
				
	    imagefilledrectangle($buffer, 0, 0, $width, $new_height, imagecolorallocate($buffer, $bgRed, $bgGreen, $bgBlue));
		
	    //  Save any alpha data that might have existed in the source image and disable blending
	    imagesavealpha($source, true);

	    imagesavealpha($output, true);
	    imagealphablending($output, false);

	    imagesavealpha($buffer, true);
	    imagealphablending($buffer, false);

		//	Copy the bottom-most part of the source image into the output
		imagecopy($output, $source, 0, 0, 0, $height - $new_height, $width, $new_height);
		
		// custom: ajout d'un margin transparent entre l'image et le reflet
		imagefilledrectangle($buffer, 0, 0, $width, $margin, imagecolorallocatealpha($buffer, 0, 0, 0, 127));
		
		//	Rotate and flip it (strip flip method)
	    for ($y = 0; $y < $new_height; $y++)
	    {
			//imagecopy( dst_im  ,src_im  , dst_x  , dst_y  ,  src_x  , src_y  , src_w  , int   src_h  )
	       imagecopy($buffer, $output, 0, $y+$margin, 0, $new_height - $y - 1, $width, 1);
	    }

		$output = $buffer;

		/*
			----------------------------------------------------------------
			Apply the fade effect
			----------------------------------------------------------------
		*/
		
		//	This is quite simple really. There are 127 available levels of alpha, so we just
		//	step-through the reflected image, drawing a box over the top, with a set alpha level.
		//	The end result? A cool fade.

		//	There are a maximum of 127 alpha fade steps we can use, so work out the alpha step rate

		$alpha_length = abs($alpha_start - $alpha_end);

	    imagelayereffect($output, IMG_EFFECT_OVERLAY);

	    for ($y = 0; $y <= $new_height; $y++)
	    {
	        //  Get % of reflection height
	        $pct = $y / $new_height;

	        //  Get % of alpha
	        if ($alpha_start > $alpha_end)
	        {
	            $alpha = (int) ($alpha_start - ($pct * $alpha_length));
	        }
	        else
	        {
	            $alpha = (int) ($alpha_start + ($pct * $alpha_length));
	        }
	        
	        //  Rejig it because of the way in which the image effect overlay works
	        $final_alpha = 127 - $alpha;

	        /* imagefilledrectangle($output, 0, $y, $width, $y, imagecolorallocatealpha($output, 127, 127, 127, $final_alpha)); */
	        imagefilledrectangle($output, 0, $y, $width, $y, imagecolorallocatealpha($output, $red, $green, $blue, $final_alpha));
	    
		}

	    /*
			----------------------------------------------------------------
			Build the reflection image by combining the source 
			image AND the reflection in one new image!
			----------------------------------------------------------------
		*/
			$finaloutput = imagecreatetruecolor($width, $height+$new_height);
			imagesavealpha($finaloutput, true);

		
			$trans_colour = imagecolorallocatealpha($finaloutput, $red, $green, $blue, 127);
			imagefill($finaloutput, 0, 0, $trans_colour);

			imagecopy($finaloutput, $source, 0, 0, 0, 0, $width, $height);
			imagecopy($finaloutput, $output, 0, $height, 0, 0, $width, $new_height);

		/*
			----------------------------------------------------------------
			Output our final PNG
			----------------------------------------------------------------
		*/


		    imagepng($finaloutput, $fichier_destination);
			chmod($fichier_destination,0777);
			
	}

	// retire les bordures d'une image
	function retirerBordures($imagePath, $couleurTolerance) {
	
		list($width, $height, $type, $mime) = getimagesize($imagePath);
		
		$im 			= imagecreatefromjpeg($imagePath);
		$xTestDelta		= 2;
		$yTestDelta		= 3;
		$xTestNew		= 0;
		$yTestNew		= 0;
		$xFinal			= 0;
		$yFinal			= 0;
		
		// test sur la hauteur
		$xTest			= 110;
		$yTest			= 0;
		
		do {
			
			$rgb = imagecolorat($im, $xTest, $yTestNew);
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			
			$yTest 		= $yTestNew;	// conserve le dernier Y blanc
			$yTestNew	+= $yTestDelta;	// passe au Y suivant
			
		} while($r > $couleurTolerance && $g > $couleurTolerance && $b > $couleurTolerance);
		$yFinal	= $yTest+$yTestDelta;
		
		
		// test sur la hauteur
		$xTest			= 0;
		$yTest			= 185;
		
		do {
			
			$rgb = imagecolorat($im, $xTestNew, $yTest);
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			
			$xTest 		= $xTestNew;	// conserve le dernier Y blanc
			$xTestNew	+= $xTestDelta;	// passe au Y suivant
			
		} while($r > $couleurTolerance && $g > $couleurTolerance && $b > $couleurTolerance);
		$xFinal	= $xTest+$xTestDelta;
		
		/*
		if($xFinal > $yFinal) {
			$yFinal	= 0;
		} else {
			$xFinal = 0;
		}
		*/
		
		// génère une nouvelle image
		$new = imagecreatetruecolor($width-$xFinal*2, $height-$yFinal*2);
		
		// imagecopy(  dst_image,  src_image,  dst_x,  dst_y,  src_x,  src_y,  dst_w,  dst_h,  src_w,  src_h )
		imagecopy($new, $im, 0, 0, $xFinal, $yFinal, $width-$xFinal*2, $height-$yFinal*2);
		
		// génère un jpg
		imagejpeg($new, $imagePath, 80);
		
		// détruit les images temporaires
		imagedestroy($new);
		imagedestroy($im);
		
		// donne tous les droits à l'image finale
		chmod($imagePath, 0777);
			
	}
?>
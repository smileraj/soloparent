<?php

	// params
	$image_file 	= $_REQUEST['image_file'] ?? false;
	
	if(preg_match('/expert/', (string) $image_file)) {
		// num�ro de l'image extrait de la source (ne fonctionne que pour 0 � 9), il y a mieux � faire plus tard pour am�liorer
		$explode 	= explode('/', (string) $image_file);
		$file_name	= $explode[count($explode)-1];	
		
		// prefix
		if(preg_match('/^temp/', $file_name)) {
			$photo_prefix = 'temp-';
		} else {
			$photo_prefix = '';
		}
		
	
		
		@unlink('../../../'.$explode[1].'/'.$explode[2].'/'.$explode[3].'/'.$photo_prefix.'expert.jpg');
		@unlink('../../../'.$explode[1].'/'.$explode[2].'/'.$explode[3].'/'.$photo_prefix.'s-preview-expert.jpg');
		@unlink('../../../'.$explode[1].'/'.$explode[2].'/'.$explode[3].'/'.$photo_prefix.'m-expert.jpg');
			
			
	}
?>

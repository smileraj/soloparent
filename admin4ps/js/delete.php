<?php

$upload_dir = $_REQUEST['upload_dir'];
$img = $_REQUEST['img'];

$dest_fichier = '';
$dest_dossier = '../'.$upload_dir.'/';

switch($img){
	
	default:
		unlink($dest_dossier.$img);
	break;
}

if(!is_file($dest_dossier.$img)){
	echo "success";
}else{
	echo "error : ".$dest_dossier.$img;
}

?>

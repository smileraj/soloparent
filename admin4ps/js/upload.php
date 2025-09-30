<?php
//Iniatialisation des variables
$response = [];
// fonctions de redim d'images
include('functions.php');

$dest_fichier = '';
$error = "error";
$success = "success";
$suppl = '';


//Récupération des données passé par le formulaire javascript
$upload_dir = $_REQUEST['upload_dir'];
$nom_image = $_REQUEST['nom_image'];
$format = $_REQUEST['format'];
$btn = $_REQUEST['btn'];
$nb_max = $_REQUEST['nb_max'];

//Données image téléchargée
$image = $_FILES[$btn]['tmp_name'];
$type_name = $_FILES[$btn]['type'];



//initialisation des données en fonction des résultats reçu par le javascript
$dest_dossier = '../'.$upload_dir.'/';



//Vérification du format de l'image (paysage/portrait)
switch ( $type_name ) {
	case "image/jpeg":
	case "image/pjpeg":
		$img_src = imagecreatefromjpeg( $image );
		break;
		
	case "image/gif":
		$img_src = imagecreatefromgif( $image );
		break;

	case "image/png":
		$img_src = imagecreatefrompng( $image );
		break;

	default:
		$response[] = $error;
		$response[] = ':<br /> Vous pouvez télécharger uniquement des images au format JPG ou PNG ou GIF '.$type_name;
		echo $response[0].",".$response[1];
		exit(0);
		break;
}

$img_src_width = imagesx( $img_src );
$img_src_height = imagesy( $img_src );

if($format == 'portrait' && $img_src_width > $img_src_height){
	$response[] = $error;
	$response[] = ':<br /> Vous pouvez télécharger uniquement des images portrait';
	echo $response[0].",".$response[1];
	exit(0);
}elseif($format == 'paysage' && $img_src_width < $img_src_height){
	$response[] = $error;
	$response[] = ':<br /> Vous pouvez télécharger uniquement des images paysage';
	echo $response[0].",".$response[1];
	exit(0);
}

switch($nom_image){
	case 'news_publi':
		
		$i = 0;
		if(is_file($dest_dossier.'temp-'.$nom_image.'.png') || is_file($dest_dossier.$nom_image.'.png')){
			$i++;
		}
		
		//Vérifie si le nuombre d'image maximum n'est pas déjà atteint
		if($nb_max && $i >= $nb_max){
			$response[] = $error;
			$response[] = '<br /> Vous pouvez télécharger uniquement '.$nb_max.' image';
			echo $response[0].",".$response[1];
			exit(0);
		}
		
		//Affectation du nom de l'image en fonction du numéro trouvé
		//$dest_fichier_nomodif = 'temp-base.png';
		$dest_fichier = 'temp-'.$nom_image.'.png';

		//Création de l'image
		$file = $dest_dossier . basename($dest_fichier); 
		//$file_base = $dest_dossier . basename($dest_fichier_nomodif); 

		createPictureSansFond($image, $file, 200, 200,$type_name);
	break;
	
	case 'actu_ps':
		
		$i = 0;
		if(is_file($dest_dossier.'temp-'.$nom_image.'.png') || is_file($dest_dossier.$nom_image.'.png')){
			$i++;
		}
		
		//Vérifie si le nuombre d'image maximum n'est pas déjà atteint
		if($nb_max && $i >= $nb_max){
			$response[] = $error;
			$response[] = '<br /> Vous pouvez télécharger uniquement '.$nb_max.' image';
			echo $response[0].",".$response[1];
			exit(0);
		}
		
		//Affectation du nom de l'image en fonction du numéro trouvé
		//$dest_fichier_nomodif = 'temp-base.png';
		$dest_fichier = 'temp-'.$nom_image.'.png';

		//Création de l'image
		$file = $dest_dossier . basename($dest_fichier); 
		//$file_base = $dest_dossier . basename($dest_fichier_nomodif); 

		createPictureSansFond($image, $file, 200, 200,$type_name);
	break;
	
	default:
		//Recherche du numéro de photo en fonction des images déjà crée
		$i = 1;
		while(is_file($dest_dossier.'/temp-'.$nom_image.'-'.$i.'.png') || is_file($dest_dossier.'/'.$nom_image.'-'.$i.'.png')) {
			$i++;
		}

		//Vérifie si le nuombre d'image maximum n'est pas déjà atteint
		if($nb_max && $i > $nb_max){
			$response[] = $error;
			$response[] = ':<br /> Vous pouvez télécharger uniquement '.$nb_max.' images pour cet emplacement';
			echo $response[0].",".$response[1];
			exit(0);
		}

		//Affectation du nom de l'image en fonction du numéro trouvé
		$dest_fichier = 'temp-'.$nom_image.'-'.$i.'.png';
		
		//Création de l'image
		$file = $dest_dossier . basename($dest_fichier); 
		
		//Création de l'image
		deplacerPhoto($image, $file, $type_name);
		
	break;
}

//Récurpération des données à faire parvenir au javascript pour l'affichage
if (is_file($file)) { 
	
	$response[] = $success;
	$response[] = $dest_fichier;
	$response[] = $upload_dir;
	$response[] = $i.$suppl;
	
	//Envoi des données au javavascript pour affichage
	echo $response[0].",".$response[1].",".$response[2].",".$response[3];
	
} else {
	
	$response[] = $error;
	
	//Envoi des données au javavascript pour affichage
	echo $response[0].$response[1];
	
}

?>

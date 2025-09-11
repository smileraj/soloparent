<?
	defined('JL') or die ('Error 401');
	
	require_once('redim.html.php');
	
	global $action;
	

	
	// variables
	$messages = array();
	
	switch($action) {
				
		case 'default':
		case 'edit':
			redim();
		break;
		
	
		case 'save':
			
			save();
			
		break;
		
		
	}
		
	function getData(){
	
		$data = new stdClass;
		
		$data->id = (int)JL::getVar('id',0);
		$data->img = JL::getVar('photo','');
		$data->dossier = JL::getVar('dossier','');
	
		return $data;	
	}
	
	function getData2(){
		
		$data = new stdClass;
		
		$data->id = (int)JL::getVar('id',0);
		$data->img = JL::getVar('photo','');
		$data->dossier = JL::getVar('dossier','');
		
		$data->cropStartX = (int)JL::getVar('sx',0);
		$data->cropStartY = (int)JL::getVar('sy',0);
		$data->cropW = (int)JL::getVar('ex',0);
		$data->cropH = (int)JL::getVar('ey',0);
	
		return $data;
	}
	
	function redim(){
		
		include(SITE_PATH.'/admin4ps/js/swfupload/functions.php');
		
		$data 		= getData();
		
		$base = SITE_PATH."/images/".$data->dossier."/".$data->id."/";
		$imgfile = $base."m-".$data->img;
		
		$src = imagecreatefromjpeg($imgfile);
		$largeur = imagesx($src)<=109 ? 109 : imagesx($src);
		$hauteur =imagesy($src)<=109 ? 109 : imagesy($src);
		
		if($largeur>imagesx($src) || $hauteur>imagesy($src)){
			redimAuto($imgfile,$data->id,$largeur,$hauteur,imagesx($src),imagesy($src));
		}
		
		
		$dim->largeur=$largeur;
		$dim->hauteur=$hauteur;
		
		redim_HTML::edit($data, $dim);
	}
	
	
	
	
	
	function save(){

		include(SITE_PATH.'/admin4ps/js/swfupload/functions.php');

		$data 		= getData2();
		
		redimensionner($data->img,$data->id, $data->dossier, $data->cropStartX,$data->cropStartY,$data->cropW,$data->cropH);
		
		redim_HTML::resultat($data);
	
	}


?>

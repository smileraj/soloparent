<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('home.html.php');
	
	global $action;
	

	
	// variables
	$messages = array();

	
	
	switch($action) {
		
		case 'save':
		save();
		break;
		
		case 'edit':
		editer();
		break;
		
		default:
		lister();
		break;
		
	}
	
	
	// liste les contenus
	function lister() {
		global $db;
		
		// variables
		$where			= array();
		$_where			= '';
		
		// params
		$type_id		= JL::getVar('type_id', 0, true);
		$lang			= JL::getVar('lang', '', true);
		
		if($type_id) {
			$where[]	= "type_id = '".$type_id."'";
		}
		
		if($lang!=''){
			$FROM = " FROM home_".$lang;
		}
		
		if(count($where)) {
			$_where		= " WHERE ".implode(' AND ', $where);
		}
		
		$query = "SELECT id, description, titre, texte"
		.$FROM
		.$_where
		." ORDER BY titre ASC"
		;
		$contenus = $db->loadObjectList($query);
		
		home_HTML::lister($contenus, $lang);
		
	}
	
	// affiche un contenu passé en param $id
	function editer() {
		global $db, $messages, $action;
		
		// params
		$id 	= JL::getVar('id', 0);
		$lang	= JL::getVar('lang', '', true);
		
		
		if($lang!=''){
			$FROM = " FROM home_".$lang;
		}
		
		// message de confirmation de sauvegarde
		if(JL::getVar('save', 0)) {
			$messages[] = '<span class="valid">Enregistrement effectu&eacute; !</span>';
		}
		
		
		// nouveau ou enregistrement/erreur
		if(!$id || $action == 'save') {
			
			$contenu		= getData();
			
		} else {
			
			// récup le contenu
			$query = "SELECT *"
			.$FROM
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			
			$contenu	= $db->loadObject($query);
			
		}
		
		$contenu->lang = $lang;
		
		home_HTML::editer($contenu, $messages);
		
	}
	
	
	function save() {
		global $db, $user, $messages;
		
		// messages d'erreur
		$error		= false;
		
		// récup les données
		$data 		= getData(true);
		
		$lang	= JL::getVar('lang', '', true);
		
		
		if($lang!=''){
			$base = "home_".$lang;
			$adr = "&lang=".$lang;
		}
		
		// vérifs
		if(!$data->titre) {
			$messages[]	= '<span class="error">Veuillez indiquer un titre svp.</span>';
			$error		= true;
		}
		if(!$data->texte) {
			$messages[]	= '<span class="error">Veuillez indiquer un texte svp.</span>';
			$error		= true;
		}

		// pas d'erreur
		if(!$error) {

			// on sauvegarde
			if($data->id) {
				ECHO $query 	= "UPDATE ".$base." SET"
				." titre = '".$data->titre."',"
				." texte = '".$data->texte."'"
				." WHERE id = '".$data->id."'"
				;
				$db->query($query);
			}
			
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=home&action=edit&id='.$data->id.$adr.'&save=1');
			
		}
		
	}
	
	
	function &getData($addslashes = false) {
		global $user;
		
		$data = new StdClass();
		
		// params
		$data->id 				= JL::getVar('id', 0);
		$data->titre 			= JL::getVar('titre', '', $addslashes);
		$data->texte 			= JL::getVar('FCKeditor1', '', $addslashes);
		
		return $data;
		
	}
	
?>

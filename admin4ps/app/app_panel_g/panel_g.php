<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	require_once('panel_g.html.php');
	
	global $action;
	

	
	// variables
	$messages = [];

	
	
	match ($action) {
        'save' => save(),
        'edit' => editer(),
        default => lister(),
    };
	
	
	// liste les contenus
	function lister() {
		global $db;
		
		// variables
		$where			= [];
		$_where			= '';
		
		// params
		$lang			= JL::getVar('lang', '', true);
		
		if($lang!=''){
			$FROM = " FROM panel_g_".$lang;
		}
		
		if (is_array($where)) {
			$_where		= " WHERE ".implode(' AND ', $where);
		}
		
		$query = "SELECT id, titre, texte"
		.$FROM
		.$_where
		." ORDER BY titre ASC"
		;
		$contenus = $db->loadObjectList($query);
		
		panel_g_HTML::lister($contenus, $lang);
		
	}
	
	// affiche un contenu pass� en param $id
	function editer() {
		global $db, $messages, $action;
		
		// params
		$id 	= JL::getVar('id', 0);
		$lang	= JL::getVar('lang', '', true);
		
		
		if($lang!=''){
			$FROM = " FROM panel_g_".$lang;
		}
		
		// message de confirmation de sauvegarde
		if(JL::getVar('save', 0)) {
			$messages[] = '<span class="valid">Enregistrement effectu&eacute; !</span>';
		}
		
		
		// nouveau ou enregistrement/erreur
		if(!$id || $action == 'save') {
			
			$contenu		= getData();
			
		} else {
			
			// r�cup le contenu
			$query = "SELECT *"
			.$FROM
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			
			$contenu	= $db->loadObject($query);
			
		}
		
		$contenu->lang = $lang;
		
		panel_g_HTML::editer($contenu, $messages);
		
	}
	
	
	function save() {
		global $db, $user, $messages;
		
		// messages d'erreur
		$error		= false;
		
		// r�cup les donn�es
		$data 		= getData();
		
		$lang	= JL::getVar('lang', '', true);
		
		
		if($lang!=''){
			$base = "panel_g_".$lang;
			$adr = "&lang=".$lang;
		}
		
		// v�rifs
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
			
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=panel_g&action=edit&id='.$data->id.$adr.'&save=1');
			
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

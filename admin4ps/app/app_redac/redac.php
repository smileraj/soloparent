<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('redac.html.php');
	
	global $action;
	

	
	// variables
	$messages = array();

	
	
	switch($action) {
		
		case 'save':
		save();
		
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
		$lang			= JL::getVar('lang', 'fr', true);
		
		if($type_id) {
			$where[]	= "type_id = '".$type_id."'";
		}
		
		
		$FROM = " FROM contenu";
		
		
		if(count($where)) {
			$_where		= " WHERE ".implode(' AND ', $where);
		}
		
		$query = "SELECT id, titre_".$lang." as titre, published, footer, date_update, date_add"
		.$FROM
		.$_where
		." ORDER BY titre ASC"
		;
		$contenus = $db->loadObjectList($query);
		
		redac_HTML::lister($contenus, $type_id, $lang);
		
	}
	

	// affiche un contenu passé en param $id
	function editer() {
		global $db, $messages, $action;
		
		// params
		$id 	= JL::getVar('id', 0);
		$lang	= JL::getVar('lang', 'fr', true);
		
		
		
		$FROM = " FROM contenu";
		
		
		// message de confirmation de sauvegarde
		if(JL::getVar('save', 0)) {
			$messages[] = '<span class="valid">Enregistrement effectu&eacute; !</span>';
		}
		
		
		// nouveau ou enregistrement/erreur
		if(!$id || $action == 'save') {
			
			$contenu		= getData();
			
		} else {
			
			// récup le contenu
			$query = "SELECT id, titre_".$lang." as titre, texte_".$lang." as texte, published, footer, date_update, date_add"
			.$FROM
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			
			$contenu	= $db->loadObject($query);
			
		}
		
		$contenu->lang = $lang;
		
		// récup le créateur
		$query = 'SELECT username'
		.' FROM  user'
		.' WHERE id = '.$contenu->user_id_add
		.' LIMIT 0,1'
		;
		$contenu->user_name_add = $db->loadResult($query);
		
		// récup l'utilisateur qui a effectué la dernière modif
		$query = 'SELECT username'
		.' FROM user'
		.' WHERE id = '.$contenu->user_id_update
		.' LIMIT 0,1'
		;
		$contenu->user_name_update = $db->loadResult($query);
		
		redac_HTML::editer($contenu, $messages);
		
	}
	
	function save() {
		global $db, $user, $messages;
		
		// messages d'erreur
		$error		= false;
		
		// récup les données
		$data 		= getData(true);
		
		$lang	= JL::getVar('lang', 'fr', true);
		
		
		if($lang!='fr'){
			$adr = "&lang=".$lang;
		}else{
			$adr = "";
		}
		
		$base = "contenu";
		
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
				$query 	= "UPDATE ".$base." SET"
				." titre_".$lang." = '".$data->titre."',"
				." texte_".$lang." = '".$data->texte."',"
				." published = '".$data->published."',"
				." footer = '".$data->footer."',"
				." date_update = NOW(),"
				." user_id_update =	'".$user->id."'"
				." WHERE id = '".$data->id."'"
				;
				$db->query($query);
			} else {
				$query 	= "INSERT INTO contenu SET"
				." titre_fr = '".$data->titre."',"
				." texte_fr = '".$data->texte."',"
				." titre_de = '".$data->titre."',"
				." texte_de = '".$data->texte."',"
				." titre_en = '".$data->titre."',"
				." texte_en = '".$data->texte."',"
				." published = '".$data->published."',"
				." footer = '".$data->footer."',"
				." date_add = NOW(),"
				." user_id_add = '".$user->id."',"
				." type_id = '".$data->type_id."'"
				;
				$db->query($query);
				$data->id	= $db->insert_id();

			}
			
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=redac&action=edit&id='.$data->id.$adr.'&save=1');
			
		}
		
	}
	
	
	function &getData($addslashes = false) {
		global $user;
		
		$data = new StdClass();
		
		// params
		$data->id 				= JL::getVar('id', 0);
		$data->titre 			= JL::getVar('titre', '', $addslashes);
		$data->texte 			= JL::getVar('FCKeditor1', '', $addslashes);
		$data->published 		= JL::getVar('published', 0);
		$data->footer 			= JL::getVar('footer', 0);
		$data->type_id 			= JL::getVar('type_id', 1);
		$data->date_update		= JL::getVar('date_update', '0000-00-00');
		$data->user_id_update	= JL::getVar('user_id_update', 0);
		$data->date_add			= JL::getVar('date_add', date('Y-m-d'));
		$data->user_id_add		= JL::getVar('user_id_add', $user->id);
		
		return $data;
		
	}
	
?>

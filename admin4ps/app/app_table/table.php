<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('table.html.php');
	
	global $action;
	

	
	// variables
	$messages = array();

	
	
	switch($action) {
		
		case 'save':
		save();
		
		case 'edit':

		editer();
		break;
		
		case 'list':
		lister();
		break;
		
		default:
		listerAll();
		break;
		
	}
	
	
	function listerAll() {
		
		table_HTML::listerAll();
		
	}
	
	// liste les contenus
	function lister() {
		global $db;
		
		$table 	= JL::getVar('table', '');
		
		$resultatParPage	= RESULTS_NB_LISTE_ADMIN;
		$search				= array();
		$where				= array();
		$_where				= '';
		
		
		$search['page']			= JL::getVar('search_at_page', JL::getSessionInt('search_at_page', 1));
		$search['word']			= trim(JL::getVar('search_at_word', JL::getSession('search_at_word', ''), true));
		
		JL::setSession('search_at_page', 		$search['page']);
		JL::setSession('search_at_word', 		$search['word']);
		
		
		// recherche
		if($search['word']) {
			$where[]		= "(description LIKE '%".$search['word']."%' OR nom_fr LIKE '%".$search['word']."%' OR nom_de LIKE '%".$search['word']."%' OR nom_en LIKE '%".$search['word']."%')";
		}
		
		// génère le where
		if(count($where)) {
			$_where			= " WHERE ".implode(' AND ', $where);
		}
		
		// compte le nombre de résultats
		$query = "SELECT COUNT(*)"
		." FROM ".$table
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		$query = "SELECT *"
		." FROM ".$table
		.$_where
		." ORDER BY description ASC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$contenus = $db->loadObjectList($query);
		
		table_HTML::lister($contenus, $search, $table);
		
	}
	

	// affiche un contenu passé en param $id
	function editer() {
		global $db, $messages, $action;
		
		// params
		$table 	= JL::getVar('table', '');
		$id 	= JL::getVar('id', 0);
		
		
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
			." FROM ".$table
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			
			$contenu	= $db->loadObject($query);
			
			$contenu->table = $table;
		}
		
		table_HTML::editer($contenu, $messages);
		
	}
	
	function save() {
		global $db, $user, $messages;
		
		// messages d'erreur
		$error		= false;
		
		// récup les données
		$data 		= getData(true);
		
	
		// vérifs
		if(!$data->description) {
			$messages[]	= '<span class="error">Veuillez indiquer une description du texte svp.</span>';
			$error		= true;
		}
		
		if(!$data->nom_fr) {
			$messages[]	= '<span class="error">Veuillez indiquer un nom en fran&ccedil;ais svp.</span>';
			$error		= true;
		}
		if(!$data->nom_de) {
			$messages[]	= '<span class="error">Veuillez indiquer un nom en allemand svp.</span>';
			$error		= true;
		}
		if(!$data->nom_en) {
			$messages[]	= '<span class="error">Veuillez indiquer un nom en anglais svp.</span>';
			$error		= true;
		}
		
		if($data->table == "fleur"){
			if(!$data->signification_fr) {
				$messages[]	= '<span class="error">Veuillez indiquer la signification de la rose en fran&ccedil;ais svp.</span>';
				$error		= true;
			}
			if(!$data->signification_de) {
				$messages[]	= '<span class="error">Veuillez indiquer la signification de la rose en allemand svp.</span>';
				$error		= true;
			}
			if(!$data->signification_en) {
				$messages[]	= '<span class="error">Veuillez indiquer la signification de la rose en anglais svp.</span>';
				$error		= true;
			}
		}
		
		// pas d'erreur
		if(!$error) {
			$significations = "";
			
			if($data->table == "fleur"){
				$significations = " signification_fr = '".$data->signification_fr."', signification_de = '".$data->signification_de."', signification_en = '".$data->signification_en."',";
			}
			
			// on sauvegarde
			if($data->id) {
				$query 	= "UPDATE ".$data->table." SET"
				." description = '".$data->description."',"
				." nom_fr = '".$data->nom_fr."',"
				." nom_de = '".$data->nom_de."',"
				." nom_en = '".$data->nom_en."',"
				.$significations
				." published = '".$data->published."'"
				." WHERE id = '".$data->id."'"
				;
				$db->query($query);
			} else {
				$query 	= "INSERT INTO ".$data->table." SET"
				." description = '".$data->description."',"
				." nom_fr = '".$data->nom_fr."',"
				." nom_de = '".$data->nom_de."',"
				." nom_en = '".$data->nom_en."',"
				.$significations
				." published = '".$data->published."'"
				;
				$db->query($query);
				$data->id	= $db->insert_id();

			}
			
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=table&action=edit&table='.$data->table.'&id='.$data->id.'&save=1');
			
		}
		
	}
	
	
	function &getData($addslashes = false) {
		global $user;
		
		$data = new StdClass();
		
		// params
		$data->table 					= JL::getVar('table', '');
		$data->id 						= JL::getVar('id', 0);
		$data->description			= JL::getVar('description', '',$addslashes);
		$data->nom_fr 				= JL::getVar('nom_fr', '', $addslashes);
		$data->nom_de 				= JL::getVar('nom_de', '', $addslashes);
		$data->nom_en 				= JL::getVar('nom_en', '', $addslashes);
		$data->signification_fr 	= JL::getVar('signification_fr', '', $addslashes);
		$data->signification_de	= JL::getVar('signification_de', '', $addslashes);
		$data->signification_en	= JL::getVar('signification_en', '', $addslashes);
		$data->published 			= JL::getVar('published', 0);
		
		return $data;
		
	}
	
?>

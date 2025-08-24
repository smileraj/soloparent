<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('box.html.php');
	
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
		
		$resultatParPage	= RESULTS_NB_LISTE_ADMIN;
		$search				= array();
		$where				= array();
		$_where				= '';
		
		
		$search['page']			= JL::getVar('search_at_page', JL::getSessionInt('search_at_page', 1));
		$search['word']			= trim(JL::getVar('search_at_word', JL::getSession('search_at_word', ''), true));
		$search['emplacement_id']		= JL::getVar('search_at_emplacement_id', JL::getSession('search_at_emplacement_id', 0), 0);
		
		JL::setSession('search_at_page', 		$search['page']);
		JL::setSession('search_at_word', 		$search['word']);
		JL::setSession('search_at_emplacement_id', 	$search['emplacement_id']);
		
		
		// emplacement de la box
		$emplacement				= array();
		$emplacement[]			= JL::makeOption('0', 				'Tous');
		
		$query = "SELECT id AS value, nom AS text"
		." FROM box_emplacement"
		." ORDER BY nom ASC"
		;
		$emplacementTmp = $db->loadObjectList($query);
		
		$emplacement	= array_merge($emplacement, $emplacementTmp);
		$lists['emplacement_id']	= JL::makeSelectList($emplacement, 'search_at_emplacement_id', 'class="searchInput"', 'value', 'text', $search['emplacement_id']);
		
		
		// recherche
		if($search['word']) {
			$where[]		= "(b.description LIKE '%".$search['word']."%' OR b.titre_fr LIKE '%".$search['word']."%' OR b.titre_de LIKE '%".$search['word']."%' OR b.titre_en LIKE '%".$search['word']."%')";
		}
		
		// type de media
		if($search['emplacement_id'] > 0) {
			$where[]		= "b.box_emplacement_id = '".addslashes($search['emplacement_id'])."'";
		}
		
		// génère le where
		if(count($where)) {
			$_where			= " WHERE ".implode(' AND ', $where);
		}
		
		// compte le nombre de résultats
		$query = "SELECT COUNT(*)"
		." FROM box as b"
		." INNER JOIN box_emplacement as be ON be.id = b.box_emplacement_id"
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		
		$query = "SELECT b.id, b.description, b.published, be.nom"
		." FROM box as b"
		." INNER JOIN box_emplacement as be ON be.id = b.box_emplacement_id"
		.$_where
		." ORDER BY b.description ASC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$contenus = $db->loadObjectList($query);
		
		box_HTML::lister($contenus, $search, $lists);
		
	}
	

	// affiche un contenu passé en param $id
	function editer() {
		global $db, $messages, $action;
		
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
			." FROM box"
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			
			$contenu	= $db->loadObject($query);
			
		}
		
		// emplacement
		$emplacement				= array();
		$emplacement[]			= JL::makeOption('0', '> Emplacement box');
		
		$query = "SELECT id AS value, nom AS text"
		." FROM box_emplacement"
		." ORDER BY nom ASC"
		;
		$emplacementTmp = $db->loadObjectList($query);
		
		$emplacement	= array_merge($emplacement, $emplacementTmp);
		$lists['emplacement_id']	= JL::makeSelectList($emplacement, 'emplacement_id', '', 'value', 'text', $contenu->box_emplacement_id);
		
		box_HTML::editer($contenu, $lists, $messages);
		
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
		
		if(!$data->titre_fr) {
			$messages[]	= '<span class="error">Veuillez indiquer un titre en fran&ccedil;ais svp.</span>';
			$error		= true;
		}
		if(!$data->texte_fr) {
			$messages[]	= '<span class="error">Veuillez indiquer un texte en fran&ccedil;ais svp.</span>';
			$error		= true;
		}
		if(!$data->url_fr) {
			$messages[]	= '<span class="error">Veuillez indiquer le lien de la box en fran&ccedil;ais svp.</span>';
			$error		= true;
		}
		
		
		if(!$data->titre_de) {
			$messages[]	= '<span class="error">Veuillez indiquer un titre en allemand svp.</span>';
			$error		= true;
		}
		if(!$data->texte_de) {
			$messages[]	= '<span class="error">Veuillez indiquer un texte en allemand svp.</span>';
			$error		= true;
		}
		if(!$data->url_de) {
			$messages[]	= '<span class="error">Veuillez indiquer le lien de la box en allemand svp.</span>';
			$error		= true;
		}
		
		
		if(!$data->titre_en) {
			$messages[]	= '<span class="error">Veuillez indiquer un titre en anglais svp.</span>';
			$error		= true;
		}
		if(!$data->texte_en) {
			$messages[]	= '<span class="error">Veuillez indiquer un texte en anglais svp.</span>';
			$error		= true;
		}
		if(!$data->url_en) {
			$messages[]	= '<span class="error">Veuillez indiquer le lien de la box en anglais svp.</span>';
			$error		= true;
		}
		
		
		if(!$data->emplacement_id) {
			$messages[]	= '<span class="error">Veuillez indiquer l\'emplacement de cette box svp.</span>';
			$error		= true;
		}
		
		// pas d'erreur
		if(!$error) {
			
			// on sauvegarde
			if($data->id) {
				$query 	= "UPDATE box SET"
				." description = '".$data->description."',"
				." titre_fr = '".$data->titre_fr."',"
				." texte_fr = '".$data->texte_fr."',"
				." url_fr = '".$data->url_fr."',"
				." titre_de = '".$data->titre_de."',"
				." texte_de = '".$data->texte_de."',"
				." url_de = '".$data->url_de."',"
				." titre_en = '".$data->titre_en."',"
				." texte_en = '".$data->texte_en."',"
				." url_en = '".$data->url_en."',"
				." box_emplacement_id = '".$data->emplacement_id."',"
				." published = '".$data->published."'"
				." WHERE id = '".$data->id."'"
				;
				$db->query($query);
			} else {
				$query 	= "INSERT INTO box SET"
				." description = '".$data->description."',"
				." titre_fr = '".$data->titre_fr."',"
				." texte_fr = '".$data->texte_fr."',"
				." url_fr = '".$data->url_fr."',"
				." titre_de = '".$data->titre_de."',"
				." texte_de = '".$data->texte_de."',"
				." url_de = '".$data->url_de."',"
				." titre_en = '".$data->titre_en."',"
				." texte_en = '".$data->texte_en."',"
				." url_en = '".$data->url_en."',"
				." box_emplacement_id = '".$data->emplacement_id."',"
				." published = '".$data->published."'"
				;
				$db->query($query);
				$data->id	= $db->insert_id();

			}
			
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=box&action=edit&id='.$data->id.'&save=1');
			
		}
		
	}
	
	
	function &getData($addslashes = false) {
		global $user;
		
		$data = new StdClass();
		
		// params
		$data->id 				= JL::getVar('id', 0);
		$data->description			= JL::getVar('description', '');
		$data->titre_fr 			= JL::getVar('titre_fr', '', $addslashes);
		$data->texte_fr		= JL::getVar('texte_fr', '', $addslashes);
		$data->url_fr		= JL::getVar('url_fr', '');
		$data->titre_de 			= JL::getVar('titre_de', '', $addslashes);
		$data->texte_de		= JL::getVar('texte_de', '', $addslashes);
		$data->url_de		= JL::getVar('url_de', '');
		$data->titre_en 			= JL::getVar('titre_en', '', $addslashes);
		$data->texte_en		= JL::getVar('texte_en', '', $addslashes);
		$data->url_en		= JL::getVar('url_en', '');
		$data->emplacement_id		= JL::getVar('emplacement_id', 0);
		$data->published 		= JL::getVar('published', 0);
		
		return $data;
		
	}
	
?>

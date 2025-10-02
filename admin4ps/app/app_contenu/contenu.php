<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	require_once('contenu.html.php');
	
	global $action;
	

	
	// variables
	$messages = [];

	
	
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
		$search				= [];
		$where				= null;
		$_where				= '';
		
		
		$search['page']			= JL::getVar('search_at_page', JL::getSessionInt('search_at_page', 1));
		$search['word']			= trim(JL::getVar('search_at_word', JL::getSession('search_at_word', ''), true));
		
		JL::setSession('search_at_page', 		$search['page']);
		JL::setSession('search_at_word', 		$search['word']);
		
		
		// recherche
		if($search['word']) {
			$where[]		= "(description LIKE '%".$search['word']."%' OR titre_fr LIKE '%".$search['word']."%' OR titre_de LIKE '%".$search['word']."%' OR titre_en LIKE '%".$search['word']."%')";
		}
		
		// g�n�re le where
		if (is_array($where)) {
			$_where			= " WHERE ".implode(' AND ', $where);
		}
		
		// compte le nombre de r�sultats
		$query = "SELECT COUNT(*)"
		." FROM contenu"
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		$query = "SELECT *"
		." FROM contenu"
		.$_where
		." ORDER BY description ASC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$contenus = $db->loadObjectList($query);
		
		contenu_HTML::lister($contenus, $search);
		
	}
	

	// affiche un contenu pass� en param $id
	function editer() {
		global $db, $messages, $action,$lang;
		
		// params
		$id 	= JL::getVar('id', 0);
		
		
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
			." FROM contenu"
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			
			$contenu	= $db->loadObject($query);
			
		}
		
		$contenu->lang = $lang;
		
		// r�cup le cr�ateur
		$query = 'SELECT username'
		.' FROM  user'
		.' WHERE id = '.$contenu->user_id_add
		.' LIMIT 0,1'
		;
		$contenu->user_name_add = $db->loadResult($query);
		
		// r�cup l'utilisateur qui a effectu� la derni�re modif
		$query = 'SELECT username'
		.' FROM user'
		.' WHERE id = '.$contenu->user_id_update
		.' LIMIT 0,1'
		;
		$contenu->user_name_update = $db->loadResult($query);
		
		contenu_HTML::editer($contenu, $messages);
		
	}
	
	function save() {
		global $db, $user, $messages;
		
		// messages d'erreur
		$error		= false;
		
		// r�cup les donn�es
		$data 		= getData();
		
	
		// v�rifs
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
		
		if(!$data->titre_de) {
			$messages[]	= '<span class="error">Veuillez indiquer un titre en allemand svp.</span>';
			$error		= true;
		}
		if(!$data->texte_de) {
			$messages[]	= '<span class="error">Veuillez indiquer un texte en allemand svp.</span>';
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
		
		// pas d'erreur
		if(!$error) {
			
			// on sauvegarde
			if($data->id) {
				echo $query 	= "UPDATE contenu SET"
				." description = '".$data->description."',"
				." titre_fr = '".$data->titre_fr."',"
				." texte_fr = '".$data->texte_fr."',"
				." titre_de = '".$data->titre_de."',"
				." texte_de = '".$data->texte_de."',"
				." titre_en = '".$data->titre_en."',"
				." texte_en = '".$data->texte_en."',"
				." published = '".$data->published."',"
				." footer = '".$data->footer."',"
				." date_update = NOW(),"
				." user_id_update =	'".$user->id."'"
				." WHERE id = '".$data->id."'"
				;
				$db->query($query);
			} else {
				$query 	= "INSERT INTO contenu SET"
				." description = '".$data->description."',"
				." titre_fr = '".$data->titre_fr."',"
				." texte_fr = '".$data->texte_fr."',"
				." titre_de = '".$data->titre_de."',"
				." texte_de = '".$data->texte_de."',"
				." titre_en = '".$data->titre_en."',"
				." texte_en = '".$data->texte_en."',"
				." published = '".$data->published."',"
				." footer = '".$data->footer."',"
				." date_add = NOW(),"
				." user_id_add = '".$user->id."'"
				;
				$db->query($query);
				$data->id	= $db->insert_id();

			}
			
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=contenu&action=edit&id='.$data->id.'&save=1');
			
		}
		
	}
	
	
	function &getData($addslashes = false) {
		global $user;
		
		$data = new StdClass();
		
		// params
		$data->id 				= JL::getVar('id', 0);
		$data->description			= JL::getVar('description', '', $addslashes);
		$data->titre_fr 			= JL::getVar('titre_fr', '', $addslashes);
		$data->texte_fr		= JL::getVar('texte_fr', '', $addslashes);
		$data->titre_de 			= JL::getVar('titre_de', '', $addslashes);
		$data->texte_de		= JL::getVar('texte_de', '', $addslashes);
		$data->titre_en 			= JL::getVar('titre_en', '', $addslashes);
		$data->texte_en		= JL::getVar('texte_en', '', $addslashes);
		$data->published 		= JL::getVar('published', 0);
		$data->footer 			= JL::getVar('footer', 0);
		$data->date_update		= JL::getVar('date_update', '1970-01-01');
		$data->user_id_update	= JL::getVar('user_id_update', 0);
		$data->date_add			= JL::getVar('date_add', date('Y-m-d'));
		$data->user_id_add		= JL::getVar('user_id_add', $user->id);
		
		return $data;
		
	}
	
?>

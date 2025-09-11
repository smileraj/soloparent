<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('actu.html.php');
	
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
		
		JL::setSession('search_at_page', 		$search['page']);
		JL::setSession('search_at_word', 		$search['word']);
		
		
		// recherche
		if($search['word']) {
			$where[]		= "titre LIKE '%".$search['word']."%'";
		}
		
		// génère le where
		if(count($where)) {
			$_where			= " WHERE ".implode(' AND ', $where);
		}
		
		// compte le nombre de résultats
		$query = "SELECT COUNT(*)"
		." FROM actualite"
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		
		$query = "SELECT id, titre, published, date_update, date_add"
		." FROM actualite"
		.$_where
		." ORDER BY date_update DESC, date_add DESC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$contenus = $db->loadObjectList($query);
		
		actu_HTML::lister($contenus, $search);
		
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
			." FROM actualite"
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			
			$contenu	= $db->loadObject($query);
			
		}
		
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
		
		actu_HTML::editer($contenu, $messages);
		
	}
	
	function save() {
		global $db, $user, $messages;
		
		// messages d'erreur
		$error		= false;
		
		// récup les données
		$data 		= getData(true);
		
	
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
				$query 	= "UPDATE actualite SET"
				." titre = '".$data->titre."',"
				." texte = '".$data->texte."',"
				." published = '".$data->published."',"
				." date_update = NOW(),"
				." user_id_update =	'".$user->id."'"
				." WHERE id = '".$data->id."'"
				;
				$db->query($query);
			} else {
				$query 	= "INSERT INTO actualite SET"
				." titre = '".$data->titre."',"
				." texte = '".$data->texte."',"
				." published = '".$data->published."',"
				." date_add = NOW(),"
				." user_id_add = '".$user->id."'"
				;
				$db->query($query);
				$data->id	= $db->insert_id();

			}
			
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=actu&action=edit&id='.$data->id.'&save=1');
			
		}
		
	}
	
	
	function &getData($addslashes = false) {
		global $user;
		
		$data = new StdClass();
		
		// params
		$data->id 				= JL::getVar('id', 0);
		$data->titre 			= JL::getVar('titre', '', $addslashes);
		$data->texte 			= JL::getVar('texte', '', $addslashes);
		$data->published 		= JL::getVar('published', 0);
		$data->date_update		= JL::getVar('date_update', '0000-00-00');
		$data->user_id_update	= JL::getVar('user_id_update', 0);
		$data->date_add			= JL::getVar('date_add', date('Y-m-d'));
		$data->user_id_add		= JL::getVar('user_id_add', $user->id);
		
		return $data;
		
	}
	
?>

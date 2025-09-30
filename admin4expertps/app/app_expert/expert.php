<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	require_once('expert.html.php');
	
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
		
		
		$search['page']			= JL::getVar('search_g_page', JL::getSessionInt('search_g_page', 1));
		
		// mot cherch�
		$search['word']			= trim(JL::getVar('search_g_word', JL::getSession('search_g_word', ''), true));
		$search['order']		= JL::getVar('search_g_order', JL::getSession('search_g_order', 'g.date_add'), 'g.date_add');
		$search['ascdesc']		= JL::getVar('search_g_ascdesc', JL::getSession('search_g_ascdesc', 'desc'), 'desc');
		$search['active']		= JL::getVar('search_g_active', JL::getSession('search_g_active', -1), -1);
		
		// conserve en session ces param�tres
		JL::setSession('search_g_page', 		$search['page']);
		JL::setSession('search_g_word', 		$search['word']);
		JL::setSession('search_g_order', 		$search['order']);
		JL::setSession('search_g_ascdesc', 		$search['ascdesc']);
		JL::setSession('search_g_active', 		$search['active']);
		
		// crit�re de tri
		$order				= [];
		$order[]			= JL::makeOption('titre', 			'Expert');
		$order[]			= JL::makeOption('specialite', 			'Sp�cialit�');
		$lists['order']		= JL::makeSelectList($order, 'search_g_order', 'class="searchInput"', 'value', 'text', $search['order']);

		// ordre croissant/d�croissant
		$ascdesc			= [];
		$ascdesc[]			= JL::makeOption('asc', 			'Croissant');
		$ascdesc[]			= JL::makeOption('desc', 			'D�croissant');
		$lists['ascdesc']	= JL::makeSelectList($ascdesc, 'search_g_ascdesc', 'class="searchInput"', 'value', 'text', $search['ascdesc']);
		
		// statut
		$active				= [];
		$active[]			= JL::makeOption('-1', 				'Tous');
		$active[]			= JL::makeOption('1', 				'Activ�');
		$active[]			= JL::makeOption('0', 				'Non activ�');
		$lists['active']	= JL::makeSelectList($active, 'search_g_active', 'class="searchInput"', 'value', 'text', $search['active']);
		
		
		// recherche d'un pseudo
		if($search['word']) {
			$where[]		= "(e.titre LIKE '%".$search['word']."%' OR e.specialite LIKE '%".$search['word']."%')";
		}
		
		// groupe actifs
		if($search['active'] >= 0) {
			$where[]		= "e.active = '".$db->escape($search['active'])."'";
		}
		
		// g�n�re le where
		if (is_array($where)) {
			$_where			= " WHERE ".implode(' AND ', $where);
		}
		
		// compte le nombre de r�sultats
		$query = "SELECT COUNT(*)"
		." FROM expert as e"
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		
		$query = "SELECT e.id, e.titre, e.specialite, e.active"
		." FROM expert AS e"
		.$_where
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$contenus = $db->loadObjectList($query);
		
		expert_HTML::lister($contenus, $search, $lists);
		
	}
	

	// affiche un contenu pass� en param $id
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
			
			// r�cup le contenu
			$query = "SELECT *"
			." FROM expert"
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			
			$contenu	= $db->loadObject($query);
			
		}
		
		$contenu->upload_dir = JL::getUploadDir('../images/experts', $contenu->id);
			
		// supprime les fichiers temporaires de son r�pertoire de photos
		$dest_dossier = '../images/experts/'.$contenu->id;
		if(is_dir($dest_dossier)) {
			$dir_id 	= opendir($dest_dossier);
			while($file = trim(readdir($dir_id))) {
				if(preg_match('/^temp/', $file)) {
					unlink($dest_dossier.'/'.$file);
				}
			}
		}
		
		expert_HTML::editer($contenu, $lists, $messages);
		
	}
	
	function save() {
		global $db, $user, $messages;
		
		// messages d'erreur
		$error		= false;
		
		// r�cup les donn�es
		$data 		= getData();
		
	
		// v�rifs
		if(!$data->specialite) {
			$messages[]	= '<span class="error">Veuillez indiquer une sp&eacute;cialit&eacute; svp.</span>';
			$error		= true;
		}
		
		if(!$data->titre) {
			$messages[]	= '<span class="error">Veuillez indiquer un titre (pr&eacute;nom + nom ou alias) svp.</span>';
			$error		= true;
		}
		if(!$data->introduction) {
			$messages[]	= '<span class="error">Veuillez indiquer une introduction svp.</span>';
			$error		= true;
		}
		if(!$data->texte) {
			$messages[]	= '<span class="error">Veuillez indiquer un texte svp.</span>';
			$error		= true;
		}
		if(!$data->email) {
			$messages[]	= '<span class="error">Veuillez indiquer une adresse email sur laquelle seront envoy&eacute;es les questions des membres svp.</span>';
			$error		= true;
		}elseif(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', (string) $data->email)) {
			$messages[]	= '<span class="error">Veuillez indiquer une adresse email valide sur laquelle seront envoy&eacute;es les questions des membres svp.</span>';
			$error = true;
		}
		
		// pas d'erreur
		if(!$error) {
			
			// on sauvegarde
			if($data->id) {
				$query 	= "UPDATE expert SET"
				." specialite = '".$data->specialite."',"
				." titre = '".$data->titre."',"
				." introduction = '".$data->introduction."',"
				." texte = '".$data->texte."',"
				." email = '".$data->email."',"
				." active = '".$data->active."'"
				." WHERE id = '".$data->id."'"
				;
				$db->query($query);
			} else {
				$query 	= "INSERT INTO expert SET"
				." specialite = '".$data->specialite."',"
				." titre = '".$data->titre."',"
				." introduction = '".$data->introduction."',"
				." texte = '".$data->texte."',"
				." email = '".$data->email."',"
				." active = '".$data->active."'"
				;
				$db->query($query);
				$data->id	= $db->insert_id();

			}
			
			$dir 		= $data->upload_dir;
			$dest_dir = '../images/experts/'.$data->id;
			if(!is_dir($dest_dir)) {
				mkdir($dest_dir);
				chmod($dest_dir, 0777);
			}
			
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {
					if(preg_match('/^temp/', $file)) {
						copy($dir.'/'.$file, $dest_dir.'/'.str_replace('temp-', '', $file));
						@unlink($dir.'/'.$file);
					}
				}
			}
			
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=expert&action=edit&id='.$data->id.'&save=1');
			
		}
		
	}
	
	
	function &getData($addslashes = false) {
		global $user;
		
		$data = new StdClass();
		
		// params
		$data->id 				= JL::getVar('id', 0);
		$data->specialite		= JL::getVar('specialite', '');
		$data->titre 			= JL::getVar('titre', '', $addslashes);
		$data->introduction	= JL::getVar('introduction', '', $addslashes);
		$data->texte		= JL::getVar('texte', '', $addslashes);
		$data->email		= JL::getVar('email', '');
		$data->active 		= JL::getVar('active', 0);
		$data->upload_dir 		= JL::getVar('upload_dir', '');
		
		return $data;
		
	}
	
?>

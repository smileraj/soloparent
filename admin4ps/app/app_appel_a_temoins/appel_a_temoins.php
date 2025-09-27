<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	require_once('appel_a_temoins.html.php');
	
	global $action;
	
	
	// variables
	$messages = array();

	switch($action) {
		
		case 'edit':
		appel_a_temoinsEditer();
		break;
		
		case 'save':
		$messages = appel_a_temoinsSave();
		appel_a_temoinsEditer();
		break;
		
		default:
		appel_a_temoinsLister();
		break;
		
	}
	
	// sauvegarder les infos du appel_a_temoins
	function appel_a_temoinsSave() {
		global $db, $messages;
		
		// r�cup les donn�es
		$row 		=& getData();
		

		// v�rifications des champs
		if($row->media_id == 0) {
			$messages[]	= '<span class="error">Veuillez indiquer le type de m&eacute;dia concern&eacute; s\'il vous pla&icirc;t.</span>';
		}
		
		if(!$row->titre) {
			$messages[]	= '<span class="error">Veuillez indiquer le titre de votre appel &agrave; t&eacute;moins s\'il vous pla&icirc;t.</span>';
		}
		
		if(!$row->annonce) {
			$messages[]	= '<span class="error">Veuillez indiquer l\'annonce de votre appel &agrave; t&eacute;moins s\'il vous pla&icirc;t.</span>';
		}
		
		if(!$row->nom) {
			$messages[]	= '<span class="error">Veuillez indiquer votre nom s\'il vous pla&icirc;t.</span>';
		}
		
		if(!$row->prenom) {
			$messages[]	= '<span class="error">Veuillez indiquer votre pr&eacute;nom s\'il vous pla&icirc;t.</span>';
		}
		
		/*if(!$row->telephone) {
			$messages[]	= '<span class="error">Veuillez indiquer votre num&eacute;ro de t&eacute;l&eacute;phone s\'il vous pla&icirc;t.</span>';
		}*/
		
		/*
		if(!$row->adresse) {
			$messages[]	= '<span class="error">Veuillez indiquer votre adresse postale s\'il vous pla&icirc;t.</span>';
		}
		*/
		
		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email)) {
			$messages[]	= '<span class="error">Veuillez indiquer une adresse email valide s\'il vous pla&icirc;t.</span>';
		}
		
		// s'il n'y a pas d'erreur
		if(!count($messages)) {
		
			// r�cup le active actuel
			$query = "SELECT active FROM appel_a_temoins WHERE id = '".(int)$row->id."' LIMIT 0,1";
			$active = $db->loadResult($query);
			
			// appel_a_temoins en attente de validation avant la sauvegarde
			if($active == 2) {
			
				if($row->active == 1) {
				
					// envoi du mail "votre appel � t�moins a �t� publi�"
					$message = "Bonjour,\n\nVotre appel � t�moins a �t� publi� !\n\nCelui-ci est disponible � l'adresse suivante:\n".SITE_URL."/".JL::url('index.php?app=appel_a_temoins&action=read&id='.$row->id)."\n\n";
					
					// si un motif a �t� indiqu�
					if($row->motif) {
					
						$message .= $row->motif."\n\n";
						
					}
					
					$message .= "Cordialement,\nL'�quipsolocircl.comch";
					
					// version texte et html
					$message = str_replace("\n", "\n<br />", $message);
					
					JL::mail($row->email, '[ solocircl.com ] Votre appel � t�moins', $message);
					JL::mail('l.guyot@babybook.ch', '[ solocircl.com ] Votre appel � t�moins', $message);
					
					// mesage de confirmation
					$messages[]	= '<span class="valid">Email de validation envoy&eacute; !</span>';
				
				} elseif($row->active == 0) {
				
					// envoi du mail "votre appel � t�moins a �t� publi�"
					$message = "Bonjour,\n\nVotre appel &agrave; t&eacute;moins a &eacute;t&eacute; refus&eacute; !\n\n";
					
					// si un motif a �t� indiqu�
					if($row->motif) {
					
						$message .= $row->motif."\n\n";
						
					}
					
					$message .= "Cordialement,\nL'�quipsolocircl.comch";
					
					// version texte et html
					$message = str_replace("\n", "\n<br />", $message);
					
					JL::mail($row->email, '[ solocircl.com ] Votre appel � t�moins', $message);
					JL::mail('l.guyot@babybook.ch', '[ solocircl.com ] Votre appel � t�moins', $message);
					
					// mesage de confirmation
					$messages[]	= '<span class="valid">Email de refus envoy&eacute; !</span>';
				
				}
				
			}
			
			
			// mise � jour dans la DB
			$query = "UPDATE appel_a_temoins SET"
			." nom = '".$db->escape($row->nom)."',"
			." prenom = '".$db->escape($row->prenom)."',"
			." adresse = '".$db->escape($row->adresse)."',"
			." telephone = '".$db->escape($row->telephone)."',"
			." email = '".$db->escape($row->email)."',"
			." media_id = '".(int)$db->escape($row->media_id)."',"
			." titre = '".$db->escape($row->titre)."',"
			." annonce = '".$db->escape($row->annonce)."',"
			." date_limite = '".$db->escape($row->date_limite)."',"
			." date_diffusion = '".$db->escape($row->date_diffusion)."',"
			." active = '".$db->escape($row->active)."'"
			." WHERE id = '".$db->escape($row->id)."'"
			;
			$db->query($query);
			
			
			// supprime le logo
			if($row->logo_delete != '') {
				@unlink(SITE_PATH.'/images/appel-a-temoins/'.$row->id.'.jpg');
			}
			
			
			// mesage de confirmation
			$messages[]	= '<span class="valid">Modifications enregistr&eacute;es.</span>';
			
		}
		
		return $messages;
		
	}
	
	
	// �diter appel_a_temoins
	function appel_a_temoinsEditer() {
		global $db, $messages;
		
		// variables
		$lists		= array();
		
		// r�cup les donn�es par d�faut
		$data 		=& getData();
	
		// r�cup les infos du appel_a_temoins
		$query = "SELECT at.*"
		." FROM appel_a_temoins AS at"
		." WHERE at.id = '".$data->id."'"
		." LIMIT 0,1"
		;
		$row = $db->loadObject($query);
		$row->logo_delete	= '';
		
		// appel invalide
		if(!$row->id) JL::redirect(SITE_URL_ADMIN.'/index.php?app=appel_a_temoins');
		
		// variables par d�faut
		foreach($data as $k => $v) {
			$row->{$k} = $v ? $v : $row->{$k};
		}
		
		
		// media
		$media				= array();
		$media[]			= JL::makeOption('0', '> Type de media');
		
		$query = "SELECT id AS value, nom_fr AS text"
		." FROM appel_media"
		." ORDER BY nom_fr ASC"
		;
		$mediaTmp = $db->loadObjectList($query);
		
		$media	= array_merge($media, $mediaTmp);
		$lists['media_id']	= JL::makeSelectList($media, 'media_id', '', 'value', 'text', $row->media_id);
		
		
		// affichage
		HTML_appel_a_temoins::appel_a_temoinsEditer($row, $messages, $lists);
	
	}
	
	
	// liste les appel_a_temoinss
	function appel_a_temoinsLister() {
		global $db, $messages;
		
		// variables
		$resultatParPage	= RESULTS_NB_LISTE_ADMIN;
		$search				= array();
		$lists				= array();
		$where				= null;
		$_where				= '';
		
		// params
		
		// si on passe une recherche en param, alors on force la page 1 (pour �viter de charger la page 36, s'il n'y a que 2 pages � voir)
		$search['page']			= JL::getVar('search_at_page', JL::getSessionInt('search_at_page', 1));
		
		// mot cherch�
		$search['word']			= trim(JL::getVar('search_at_word', JL::getSession('search_at_word', ''), true));
		$search['order']		= JL::getVar('search_at_order', JL::getSession('search_at_order', 'at.date_add'), 'at.date_add');
		$search['ascdesc']		= JL::getVar('search_at_ascdesc', JL::getSession('search_at_ascdesc', 'desc'), 'desc');
		$search['active']		= JL::getVar('search_at_active', JL::getSession('search_at_active', -1), -1);
		$search['media_id']		= JL::getVar('search_at_media_id', JL::getSession('search_at_media_id', 0), 0);
		
		// conserve en session ces param�tres
		JL::setSession('search_at_page', 		$search['page']);
		JL::setSession('search_at_word', 		$search['word']);
		JL::setSession('search_at_order', 		$search['order']);
		JL::setSession('search_at_ascdesc', 	$search['ascdesc']);
		JL::setSession('search_at_active', 	$search['active']);
		JL::setSession('search_at_media_id', 	$search['media_id']);
		
		
		// crit�re de tri
		$order				= array();
		$order[]			= JL::makeOption('at.date_add', 	'Date ajout');
		$order[]			= JL::makeOption('at.titre', 		'Titre');
		$order[]			= JL::makeOption('at.nom', 			'Nom');
		$lists['order']		= JL::makeSelectList($order, 'search_at_order', 'class="searchInput"', 'value', 'text', $search['order']);

		// ordre croissant/d�croissant
		$ascdesc			= array();
		$ascdesc[]			= JL::makeOption('asc', 			'Croissant');
		$ascdesc[]			= JL::makeOption('desc', 			'D�croissant');
		$lists['ascdesc']	= JL::makeSelectList($ascdesc, 'search_at_ascdesc', 'class="searchInput"', 'value', 'text', $search['ascdesc']);
		
		// statut
		$active				= array();
		$active[]			= JL::makeOption('-1', 				'Tous');
		$active[]			= JL::makeOption('2', 				'A valider');
		$active[]			= JL::makeOption('1', 				'Confirm�s');
		$active[]			= JL::makeOption('0', 				'Refus�s');
		$lists['active']	= JL::makeSelectList($active, 'search_at_active', 'class="searchInput"', 'value', 'text', $search['active']);
		
		
		// media
		$media				= array();
		$media[]			= JL::makeOption('0', 				'Tous');
		
		$query = "SELECT id AS value, nom_fr AS text"
		." FROM appel_media"
		." ORDER BY nom_fr ASC"
		;
		$mediaTmp = $db->loadObjectList($query);
		
		$media	= array_merge($media, $mediaTmp);
		$lists['media_id']	= JL::makeSelectList($media, 'search_at_media_id', 'class="searchInput"', 'value', 'text', $search['media_id']);

		
		// recherche d'un pseudo
		if($search['word']) {
			$where[]		= "(at.titre LIKE '%".$search['word']."%' OR at.annonce LIKE '%".$search['word']."%' OR at.nom LIKE '%".$search['word']."%' OR at.prenom LIKE '%".$search['word']."%' OR at.email LIKE '%".$search['word']."%')";
		}
		
		// appel_a_temoins actifs
		if($search['active'] >= 0) {
			$where[]		= "at.active = '".addslashes($search['active'])."'";
		}
		
		// type de media
		if($search['media_id'] > 0) {
			$where[]		= "at.media_id = '".addslashes($search['media_id'])."'";
		}
		
		// g�n�re le where
		if (is_array($where)) {
			$_where			= " WHERE ".implode(' AND ', $where);
		}
		
		
		// compte le nombre de r�sultats
		$query = "SELECT COUNT(*)"
		." FROM appel_a_temoins AS at"
		." INNER JOIN appel_media AS am ON am.id = at.media_id"
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		// recherche des donn�es
		$query = "SELECT at.id, at.titre, at.nom, at.prenom, at.email, at.active, am.nom_fr AS media, at.date_add"
		." FROM appel_a_temoins AS at"
		." INNER JOIN appel_media AS am ON am.id = at.media_id"
		.$_where
		." ORDER BY ".strtolower($search['order'])." ".strtoupper($search['ascdesc'])
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$results	= $db->loadObjectList($query);
		
		
		HTML_appel_a_temoins::appel_a_temoinsLister($results, $search, $lists, $messages);
		
	}
	
	
	// donn�es de l'utilisateur
	function &getData() {
	
		$data = new StdClass();
		
		// params
		$data->id 					= JL::getVar('id', 0);
		$data->titre 				= JL::getVar('titre', '');
		$data->annonce 				= JL::getVar('annonce', '');
		$data->date_limite 			= JL::getVar('date_limite', '');
		$data->date_diffusion 		= JL::getVar('date_diffusion', '');
		$data->media_id 			= (int)JL::getVar('media_id', 0);
		$data->nom 					= JL::getVar('nom', '');
		$data->prenom 				= JL::getVar('prenom', '');
		$data->adresse 				= JL::getVar('adresse', '');
		$data->telephone 			= JL::getVar('telephone', '');
		$data->email 				= JL::getVar('email', '');
		$data->active 				= (int)JL::getVar('active', 0);
		$data->motif 				= JL::getVar('motif', '');
		$data->logo_delete 			= JL::getVar('logo_delete', '');
		
		return $data;
		
	}
	
?>

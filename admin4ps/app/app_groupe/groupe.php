<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	require_once('groupe.html.php');
	
	global $action;
	
	
	// variables
	$messages = [];

	switch($action) {
		
		case 'edit':
		groupeEditer();
		break;
		
		case 'save':
		$messages = groupeSave();
		groupeEditer();
		break;
		
		default:
		groupeLister();
		break;
		
	}
	
	// sauvegarder les infos du groupe
	function groupeSave() {
		global $db, $messages;
		
		// r�cup les donn�es
		$row 		=& getData();
		
		// v�rifications des champs
		if(!$row->titre) {
			$messages[]	= '<span class="error">Veuillez indiquer le titre du groupe s\'il vous pla&icirc;t.</span>';
		}
		
		if(!$row->texte) {
			$messages[]	= '<span class="error">Veuillez indiquer le texte du groupe s\'il vous pla&icirc;t.</span>';
		}
		
		
		// s'il n'y a pas d'erreur
		if(!count($messages)) {
			
			// mise � jour dans la DB
			$query = "UPDATE groupe SET";
			
			if($row->active == 1 || $row->active == 3) { // valid� ou verouill�
				
				$query .= " titre = '".$db->escape($row->titre)."',";
				$query .= " texte = '".$db->escape($row->texte)."',";
				$query .= " titre_a_valider = '',";
				$query .= " texte_a_valider = '',";
				
			} else { // refus� ou en attente
				
				$query .= " titre_a_valider = '".$db->escape($row->titre)."',";
				$query .= " texte_a_valider = '".$db->escape($row->texte)."',";
				
			}
			
			$query .= " active = '".$db->escape($row->active)."',";
			$query .= " motif = '".$db->escape($row->motif)."'";
			$query .= " WHERE id = '".$db->escape($row->id)."'";
			
			$db->query($query);
			
			
			// si le groupe est valid�
			if($row->active == 1) {
			
				// r�cup l'user_id du fondateur du groupe
				$query = "SELECT user_id"
				." FROM groupe"
				." WHERE id = '".$db->escape($row->id)."'"
				." LIMIT 0,1"
				;
				$user_id = $db->loadResult($query);
				
				// cr�dite les points
				JL::addPoints(13, $user_id, $row->id);
			
			}
			
			// photo envoy�e
			if(is_file(SITE_PATH.'/images/groupe/pending/'.$row->id.'.jpg')) {
				
				// valid�e
				if($row->photo_valider == 1) {
					copy(SITE_PATH.'/images/groupe/pending/'.$row->id.'.jpg', SITE_PATH.'/images/groupe/'.$row->id.'.jpg');
					chmod(SITE_PATH.'/images/groupe/'.$row->id.'.jpg', 0777);
					
					copy(SITE_PATH.'/images/groupe/pending/'.$row->id.'-mini.jpg', SITE_PATH.'/images/groupe/'.$row->id.'-mini.jpg');
					chmod(SITE_PATH.'/images/groupe/'.$row->id.'-mini.jpg', 0777);
				}
				
				// refus�e (ou valid�e, donc on supprime les pending une fois qu'ils ont �t� copi�s)
				if($row->photo_valider == 0 || $row->photo_valider == 1) {
					unlink(SITE_PATH.'/images/groupe/pending/'.$row->id.'.jpg');
					unlink(SITE_PATH.'/images/groupe/pending/'.$row->id.'-mini.jpg');
				}
				
			}
			
			// supprimer photo existante
			if($row->photo_delete) {
				
				unlink(SITE_PATH.'/images/groupe/'.$row->id.'.jpg');
				unlink(SITE_PATH.'/images/groupe/'.$row->id.'-mini.jpg');
				
			}
			
			
			// mesage de confirmation
			$messages[]	= '<span class="valid">Modifications enregistr&eacute;es.</span>';
			
		}
		
		return $messages;
		
	}
	
	
	// �diter groupe
	function groupeEditer() {
		global $db, $messages;
		
		// r�cup les donn�es par d�faut
		$data 		=& getData();
	
		// r�cup les infos du groupe
		$query = "SELECT g.id, g.titre AS titre_origine, IF(g.titre_a_valider != '', g.titre_a_valider, g.titre) AS titre, g.texte AS texte_origine, IF(g.texte_a_valider != '', g.texte_a_valider, g.texte) AS texte, g.active, g.date_add, g.motif, g.user_id, u.username"
		." FROM groupe AS g"
		." INNER JOIN user AS u ON u.id = g.user_id"
		." WHERE g.id = '".$data->id."'"
		." LIMIT 0,1"
		;
		$row = $db->loadObject($query);
		
		// groupe invalide
		if(!$row->id) JL::redirect(SITE_URL_ADMIN.'/index.php?app=groupe');
		
		// valeurs par d�faut utiles juste pour la boucle d'en dessous. Les valeurs s�lectionn�es par d�faut sont forc�es en html
		$row->photo_delete	= 1;
		$row->photo_valider	= 1;
		
		// variables par d�faut
		foreach($data as $k => $v) {
			$row->{$k} = $v ?: $row->{$k};
		}
		
		// affichage
		HTML_groupe::groupeEditer($row, $messages);
	
	}
	
	
	// liste les groupes
	function groupeLister() {
		global $db, $messages;
		
		// variables
		$resultatParPage	= RESULTS_NB_LISTE_ADMIN;
		$search				= [];
		$lists				= [];
		$where				= null;
		$_where				= '';
		
		// params
		
		// si on passe une recherche en param, alors on force la page 1 (pour �viter de charger la page 36, s'il n'y a que 2 pages � voir)
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
		$order[]			= JL::makeOption('g.date_add', 		'Date ajout');
		$order[]			= JL::makeOption('titre', 			'Titre');
		$lists['order']		= JL::makeSelectList($order, 'search_g_order', 'class="searchInput"', 'value', 'text', $search['order']);

		// ordre croissant/d�croissant
		$ascdesc			= [];
		$ascdesc[]			= JL::makeOption('asc', 			'Croissant');
		$ascdesc[]			= JL::makeOption('desc', 			'D�croissant');
		$lists['ascdesc']	= JL::makeSelectList($ascdesc, 'search_g_ascdesc', 'class="searchInput"', 'value', 'text', $search['ascdesc']);
		
		// statut
		$active				= [];
		$active[]			= JL::makeOption('-1', 				'Tous');
		$active[]			= JL::makeOption('2', 				'A valider');
		$active[]			= JL::makeOption('1', 				'Confirm�s');
		$active[]			= JL::makeOption('0', 				'Refus�s');
		$active[]			= JL::makeOption('3', 				'Verrouill�s');
		$lists['active']	= JL::makeSelectList($active, 'search_g_active', 'class="searchInput"', 'value', 'text', $search['active']);
		
		
		// recherche d'un pseudo
		if($search['word']) {
			$where[]		= "(g.titre LIKE '%".$search['word']."%' OR g.titre_a_valider LIKE '%".$search['word']."%')";
		}
		
		// groupe actifs
		if($search['active'] >= 0) {
			$where[]		= "g.active = '".$db->escape($search['active'])."'";
		}
		
		// g�n�re le where
		if (is_array($where)) {
			$_where			= " WHERE ".implode(' AND ', $where);
		}
		
		
		// compte le nombre de r�sultats
		$query = "SELECT COUNT(*)"
		." FROM groupe AS g"
		." INNER JOIN user AS u ON u.id = g.user_id"
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		// recherche des donn�es
		$query = "SELECT g.id, IF(g.titre_a_valider != '', g.titre_a_valider, g.titre) AS titre, g.active, u.username, g.date_add"
		." FROM groupe AS g"
		." INNER JOIN user AS u ON u.id = g.user_id"
		.$_where
		." ORDER BY ".strtolower((string) $search['order'])." ".strtoupper((string) $search['ascdesc'])
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$results	= $db->loadObjectList($query);
		
		
		HTML_groupe::groupeLister($results, $search, $lists, $messages);
		
	}
	
	
	// donn�es de l'utilisateur
	function &getData() {
		
		$data = new StdClass();
		
		// params
		$data->id 					= JL::getVar('id', 0);
		$data->titre 				= JL::getVar('titre', '');
		$data->texte 				= JL::getVar('texte', '');
		$data->photo_delete 		= JL::getVar('photo_delete', '');
		$data->photo_valider 		= (int)JL::getVar('photo_valider', 2);
		$data->active 				= (int)JL::getVar('active', 0);
		$data->motif 				= JL::getVar('motif', '');
		$data->user_id 				= 0;
		$data->username 			= '';
		$data->date_add 			= '';
		
		return $data;
		
	}
	
?>

<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	require_once('temoignage.html.php');
	
	global $action;
	
	
	// variables
	$messages = [];

	switch($action) {
		
		case 'edit':
		temoignageEditer();
		break;
		
		case 'save':
		$messages = temoignageSave();
		temoignageEditer();
		break;
		
		default:
		temoignageLister();
		break;
		
	}
	
	// sauvegarder les infos du temoignage
	function temoignageSave() {
		global $db, $messages;
		
		// r�cup les donn�es
		$row 		=& getData();
		

		// v�rifications des champs
		if(!$row->titre) {
			$messages[]	= '<span class="error">Veuillez indiquer le titre de votre t&eacute;moignage s\'il vous pla&icirc;t.</span>';
		}
		
		if(!$row->texte) {
			$messages[]	= '<span class="error">Veuillez indiquer le texte de votre t&eacute;moignage s\'il vous pla&icirc;t.</span>';
		}
		
		
		// s'il n'y a pas d'erreur
		if(!count($messages)) {
		
			// r�cup le active actuel
			$query = "SELECT active FROM temoignage WHERE id = '".(int)$row->id."' LIMIT 0,1";
			$active = $db->loadResult($query);
			
			// temoignage en attente de validation avant la sauvegarde
			if($active == 2) {
			
				// r�cup l'email de l'auteur
				$query = "SELECT email"
				." FROM"
				." ("
				." SELECT u.email"
				." FROM temoignage AS t"
				." INNER JOIN user AS u ON u.id = t.user_id"
				." WHERE t.id = '".$db->escape($row->id)."'"
				." UNION ALL"
				." SELECT us.email"
				." FROM temoignage AS t"
				." INNER JOIN user_suppr AS us ON us.id = t.user_id"
				." WHERE t.id = '".$db->escape($row->id)."'"
				." ) as xxx"
				." LIMIT 0,1"
				;
				$email	= $db->loadResult($query);
				
			
				if($row->active == 1) {
				
					// envoi du mail "votre appel � t�moins a �t� publi�"
					$message = "Bonjour,\n\nVotre t�moignage a �t� publi� !\n\nCelui-ci est disponible � l'adresse suivante:\n".SITE_URL."/".JL::url('index.php?app=temoignage&action=read&id='.$row->id)."\n\n";
					
					// si un motif a �t� indiqu�
					if($row->motif) {
					
						$message .= $row->motif."\n\n";
						
					}
					
					$message .= "Cordialement,\nL'�quipsolocircl.comch";
					
					// version texte et html
					$message = str_replace("\n", "\n<br />", $message);
					
					JL::mail($email, '[ solocircl.com ] Votre t�moignage', $message);
					
					// mesage de confirmation
					$messages[]	= '<span class="valid">Email de validation envoy� !</span>';
				
				} elseif($row->active == 0) {
				
					// envoi du mail "votre appel � t�moins a �t� publi�"
					$message = "Bonjour,\n\nVotre t�moignage a �t� refus� !\n\n";
					
					// si un motif a �t� indiqu�
					if($row->motif) {
					
						$message .= $row->motif."\n\n";
						
					}
					
					$message .= "Cordialement,\nL'�quipsolocircl.comch";
					
					// version texte et html
					$message = str_replace("\n", "\n<br />", $message);
					
					JL::mail($email, '[ solocircl.com ] Votre t�moignage', $message);
					JL::mail('n.favaron@babybook.ch', '[ solocircl.com ] Votre t�moignage', $message);
					
					// mesage de confirmation
					$messages[]	= '<span class="valid">Email de refus envoy� !</span>';
				
				}
				
			}
			
			
			// mise � jour dans la DB
			$query = "UPDATE temoignage SET"
			." titre = '".$db->escape($row->titre)."',"
			." texte = '".$db->escape($row->texte)."',"
			." active = '".$db->escape($row->active)."'"
			." WHERE id = '".$db->escape($row->id)."'"
			;
			$db->query($query);
			
			
			// mesage de confirmation
			$messages[]	= '<span class="valid">Modifications enregistr&eacute;es.</span>';
			
		}
		
		return $messages;
		
	}
	
	
	// �diter temoignage
	function temoignageEditer() {
		global $db, $messages;
		
		// r�cup les donn�es par d�faut
		$data 		=& getData();
	
		// r�cup les infos du temoignage
		$query = "SELECT t.*"
		." FROM temoignage AS t"
		." WHERE t.id = '".$data->id."'"
		." LIMIT 0,1"
		;
		$row = $db->loadObject($query);
		
		// appel invalide
		if(!$row->id) JL::redirect(SITE_URL_ADMIN.'/index.php?app=temoignage');
		
		// variables par d�faut
		foreach($data as $k => $v) {
			$row->{$k} = $v ?: $row->{$k};
		}
		
		// affichage
		HTML_temoignage::temoignageEditer($row, $messages);
	
	}
	
	
	// liste les temoignages
	function temoignageLister() {
		global $db, $messages;
		
		// variables
		$resultatParPage	= RESULTS_NB_LISTE_ADMIN;
		$search				= [];
		$lists				= [];
		$where				= null;
		$_where				= '';
		
		// params
		
		// si on passe une recherche en param, alors on force la page 1 (pour �viter de charger la page 36, s'il n'y a que 2 pages � voir)
		$search['page']			= JL::getVar('search_t_page', JL::getSessionInt('search_t_page', 1));
		
		// mot cherch�
		$search['word']			= trim(JL::getVar('search_t_word', JL::getSession('search_t_word', ''), true));
		$search['order']		= JL::getVar('search_t_order', JL::getSession('search_t_order', 'date_add'), 'date_add');
		$search['ascdesc']		= JL::getVar('search_t_ascdesc', JL::getSession('search_t_ascdesc', 'desc'), 'desc');
		$search['active']		= JL::getVar('search_t_active', JL::getSession('search_t_active', -1), -1);
		
		// conserve en session ces param�tres
		JL::setSession('search_t_page', 		$search['page']);
		JL::setSession('search_t_word', 		$search['word']);
		JL::setSession('search_t_order', 		$search['order']);
		JL::setSession('search_t_ascdesc', 	$search['ascdesc']);
		JL::setSession('search_t_active', 		$search['active']);
		
		
		// crit�re de tri
		$order				= [];
		$order[]			= JL::makeOption('date_add', 	'Date ajout');
		$order[]			= JL::makeOption('username', 	'Pseudo');
		$order[]			= JL::makeOption('titre', 	'Titre');
		$lists['order']		= JL::makeSelectList($order, 'search_t_order', 'class="searchInput"', 'value', 'text', $search['order']);

		// ordre croissant/d�croissant
		$ascdesc			= [];
		$ascdesc[]			= JL::makeOption('asc', 			'Croissant');
		$ascdesc[]			= JL::makeOption('desc', 			'D�croissant');
		$lists['ascdesc']	= JL::makeSelectList($ascdesc, 'search_t_ascdesc', 'class="searchInput"', 'value', 'text', $search['ascdesc']);
		
		// statut
		$active				= [];
		$active[]			= JL::makeOption('-1', 				'Tous');
		$active[]			= JL::makeOption('2', 				'A valider');
		$active[]			= JL::makeOption('1', 				'Confirm�s');
		$active[]			= JL::makeOption('0', 				'Refus�s');
		$lists['active']	= JL::makeSelectList($active, 'search_t_active', 'class="searchInput"', 'value', 'text', $search['active']);
		
		
		// recherche d'un pseudo
		if($search['word']) {
			$where[]		= "(t.titre LIKE '%".$search['word']."%' OR t.texte LIKE '%".$search['word']."%' OR username LIKE '%".$search['word']."%')";
		}
		
		// temoignage actifs
		if($search['active'] >= 0) {
			$where[]		= "t.active = '".addslashes((string) $search['active'])."'";
		}
		
		// g�n�re le where
		if (is_array($where)) {
			$_where			= " WHERE ".implode(' AND ', $where);
		}
		
		
		// compte le nombre de r�sultats
		$query = "SELECT COUNT(id)"
		." FROM"
		." ("
		." SELECT t.id as id" 
		." FROM temoignage AS t"
		." INNER JOIN user AS u ON u.id = t.user_id"
		.$_where
		." UNION ALL"
		." SELECT t.id as id" 
		." FROM temoignage AS t"
		." INNER JOIN user_suppr AS us ON us.id = t.user_id"
		.$_where
		." ) as xxx"
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		// recherche des donn�es
		$query = "SELECT id, titre, active, username, date_add"
		." FROM"
		." ("
		." SELECT t.id, t.titre, t.active, u.username, t.date_add" 
		." FROM temoignage AS t"
		." INNER JOIN user AS u ON u.id = t.user_id"
		.$_where
		." UNION ALL"
		." SELECT t.id, t.titre, t.active, us.username, t.date_add" 
		." FROM temoignage AS t"
		." INNER JOIN user_suppr AS us ON us.id = t.user_id"
		.$_where
		." ) as xxx"
		." ORDER BY ".strtolower((string) $search['order'])." ".strtoupper((string) $search['ascdesc'])
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$results	= $db->loadObjectList($query);
		
		
		HTML_temoignage::temoignageLister($results, $search, $lists, $messages);
		
	}
	
	
	// donn�es de l'utilisateur
	function &getData() {
	
		$data = new StdClass();
		
		// params
		$data->id 					= JL::getVar('id', 0);
		$data->titre 				= JL::getVar('titre', '');
		$data->texte 				= JL::getVar('texte', '');
		$data->active 				= (int)JL::getVar('active', 0);
		$data->motif 				= JL::getVar('motif', '');
		
		return $data;
		
	}
	
?>

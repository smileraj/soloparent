<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	require_once('profil_suppr.html.php');
	
	global $action;
	
	
	// variables
	$messages = [];

	
	
	match ($action) {
        'editer' => profilEditer(),
        default => profilLister(),
    };
	
	
	// �diter profil
	function profilEditer() {
		global $db, $messages;
		
		// r�cup les donn�es par d�faut
		$data 		= getData();
	
		// nouvel utilisateur
		if(!$data->id) {
		
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=profil_suppr');
		
		} else {
			
			// r�cup les infos du profil
			$query = "SELECT u.id, u.username, u.email, up.langue_appel, up.helvetica, up.genre, up.nom, up.prenom, up.telephone, up.adresse, up.code_postal, up.nom_origine, up.prenom_origine, up.telephone_origine, up.adresse_origine, up.code_postal_origine, us.gold_limit_date, 0 AS abonnement_crediter, us.appel_date, us.appel_date2, us.commentaire, u.confirmed, u.creation_date, ua.annonce_valide, us.points_total"
			." FROM user_suppr AS u"
			." INNER JOIN user_profil AS up ON up.user_id = u.id"
			." INNER JOIN user_stats AS us ON us.user_id = u.id"
			." INNER JOIN user_annonce AS ua ON ua.user_id = u.id"
			." WHERE u.id = '".$data->id."'"
			." LIMIT 0,1"
			;
			$userObj = $db->loadObject($query);
			
			
			// variables non issues de la DB
			$userObj->points_id			= 0;
			$userObj->points_retirer	= 0;
			
			
			// variables par d�faut
			foreach($data as $k => $v) {
				$userObj->{$k} = $v ?: $userObj->{$k};
			}
			
			
			// r�cup le dernier abonnement pay� par carte
			$query = "SELECT nom_paypal, prenom_paypal, IF(date_dernier_renouvellement = '1970-01-01 00:00:00', date_souscription, date_dernier_renouvellement) as datetime, valide"
			." FROM abonnement_paypal"
			." WHERE user_id = '".$userObj->id."' AND valide > 0"
			." ORDER BY id DESC"
			." LIMIT 0,1"
			;
			$abonnement_carte = $db->loadObject($query);
			$userObj->abonnement_carte = $abonnement_carte->datetime ?: false;
			
			if($userObj>\ABONNEMENT_CARTE){
				$userObj->abonnement_carte_nom = $abonnement_carte->nom_paypal;
				$userObj->abonnement_carte_prenom = $abonnement_carte->prenom_paypal;
				$userObj->abonnement_carte_valide = $abonnement_carte->valide;
			}
			
			
			// r�cup les 4 actions d'abonnement, id en dur !
			$query = "SELECT id, nom_fr as nom, points"
			." FROM points"
			." WHERE id IN (1,2,3,19)"
			." ORDER BY nom ASC"
			." LIMIT 0,4"
			;
			$points = $db->loadObjectList($query);
			
			
			// affichage du formulaire d'�dition
			profil_suppr_HTML::profilEditer($userObj, $messages, $points);
		
		}
	
	}
	
	
	
	// liste les profils
	function profilLister() {
		global $db, $messages;
		
		// variables
		$resultatParPage		= RESULTS_NB_LISTE_ADMIN;
		$stats					= [];
		$search					= [];
		$lists					= [];
		$where					= [];
		$_where					= '';
		
		// params
		
		// si on passe une recherche en param, alors on force la page 1 (pour �viter de charger la page 36, s'il n'y a que 2 pages � voir)
		$search['page']			= JL::getVar('search_page', JL::getSessionInt('search_page', 1));
		
		// mot cherch�
		$search['word']			= trim(JL::getVar('search_word', JL::getSession('search_word', ''), true));
		$search['order']		= JL::getVar('search_order', JL::getSession('search_order', 'u.creation_date'));
		$search['ascdesc']		= JL::getVar('search_ascdesc', JL::getSession('search_ascdesc', 'desc'));
		$search['confirmed']	= JL::getVar('search_confirmed', JL::getSession('search_confirmed', -1));
		$search['genre']		= JL::getVar('search_genre', JL::getSession('search_genre', ''));
		$search['abonnement']	= JL::getVar('search_abonnement', JL::getSession('search_abonnement', ''));
		$search['helvetica']	= (int)JL::getVar('search_helvetica', JL::getSession('search_helvetica', 2));
		
		// conserve en session ces param�tres
		JL::setSession('search_page', 		$search['page']);
		JL::setSession('search_word', 		$search['word']);
		JL::setSession('search_order', 		$search['order']);
		JL::setSession('search_ascdesc', 	$search['ascdesc']);
		JL::setSession('search_confirmed', 	$search['confirmed']);
		JL::setSession('search_genre', 		$search['genre']);
		JL::setSession('search_abonnement', $search['abonnement']);
		JL::setSession('search_helvetica', 	$search['helvetica']);
		
		
		// crit�re de tri
		$order					= [];
		$order[]				= JL::makeOption('u.creation_date', 	'Date inscription');
		$order[]				= JL::makeOption('u.last_online', 		'Derni�re connexion');
		$order[]				= JL::makeOption('us.gold_limit_date', 	'Fin abonnement');
		$order[]				= JL::makeOption('u.ip_pays', 			'Pays');
		$order[]				= JL::makeOption('us.points_total', 	'Points Total');
		$order[]				= JL::makeOption('u.username', 			'Pseudo');
		$lists['order']			= JL::makeSelectList($order, 'search_order', 'class="searchInput"', 'value', 'text', $search['order']);

		// ordre croissant/d�croissant
		$ascdesc				= [];
		$ascdesc[]				= JL::makeOption('asc', 			'Croissant');
		$ascdesc[]				= JL::makeOption('desc', 			'D�croissant');
		$lists['ascdesc']		= JL::makeSelectList($ascdesc, 'search_ascdesc', 'class="searchInput"', 'value', 'text', $search['ascdesc']);
		
		// statut
		$confirmed				= [];
		$confirmed[]			= JL::makeOption('-1', 				'Tous');
		$confirmed[]			= JL::makeOption('2', 				'A valider');
		$confirmed[]			= JL::makeOption('1', 				'Confirm�s');
		$confirmed[]			= JL::makeOption('0', 				'Refus�s');
		$lists['confirmed']		= JL::makeSelectList($confirmed, 'search_confirmed', 'class="searchInput"', 'value', 'text', $search['confirmed']);
		
		// genre
		$genre					= [];
		$genre[]				= JL::makeOption('', 				'Tous');
		$genre[]				= JL::makeOption('f', 				'Femme');
		$genre[]				= JL::makeOption('h', 				'Homme');
		$lists['genre']			= JL::makeSelectList($genre, 'search_genre', 'class="searchInput"', 'value', 'text', $search['genre']);
		
		// abonnement
		$abonnement				= [];
		$abonnement[]			= JL::makeOption('', 				'Tous');
		$abonnement[]			= JL::makeOption('1',				'Aucun');
		$abonnement[]			= JL::makeOption('2', 				'En cours');
		$abonnement[]			= JL::makeOption('3', 				'Termin�');
		$lists['abonnement']	= JL::makeSelectList($abonnement, 'search_abonnement', 'class="searchInput"', 'value', 'text', $search['abonnement']);
		
		// profil helvetica
		$lists['helvetica']		= '<input type="radio" name="search_helvetica" id="search_helvetica1" value="1" '.($search['helvetica'] == 1 ? 'checked' : '').' /> <label for="search_helvetica1">Oui</label> <input type="radio" name="search_helvetica" id="search_helvetica0" value="0" '.($search['helvetica'] == 0 ? 'checked' : '').' /> <label for="search_helvetica0">Non</label> <input type="radio" name="search_helvetica" id="search_helvetica2" value="2" '.($search['helvetica'] == 2 ? 'checked' : '').' /> <label for="search_helvetica2">Peu importe</label>';
		
		
		// on n'affiche pas les admins
		$where[]				= "u.gid = 0";
		
		// date d'abonnement
		if($search['abonnement']) {
			
			// aucun abo
			if($search['abonnement'] == '1') {
			
				$where[]		= "us.gold_limit_date = '1970-01-01'";
				
			} elseif($search['abonnement'] == '2') { // abo en cours
			
				$where[]		= "us.gold_limit_date >= NOW()";
			
			} elseif($search['abonnement'] == '3') { // abo termin�
			
				$where[]		= "us.gold_limit_date < NOW()";
				$where[]		= "us.gold_limit_date != '1970-01-01'";
				
			}
			
		}
		
		// recherche d'un pseudo
		if($search['word']) {
			$where[]			= "(u.username LIKE '%".$search['word']."%' OR u.email LIKE '%".$search['word']."%' OR up.nom LIKE '%".$search['word']."%' OR up.nom_origine LIKE '%".$search['word']."%' OR up.prenom LIKE '%".$search['word']."%' OR up.prenom_origine LIKE '%".$search['word']."%' OR up.telephone LIKE '%".$search['word']."%')";
		}
		
		// profils actifs
		if($search['confirmed'] >= 0) {
			$where[]			= "u.confirmed = '".addslashes((string) $search['confirmed'])."'";
		}
		
		// genre
		if($search['genre'] != '') {
			$where[]			= "up.genre = '".addslashes((string) $search['genre'])."'";
		}
		
		// profil helvetica
		if($search['helvetica'] == 1) {
			$where[]			= "up.helvetica = 1";
		} elseif($search['helvetica'] == 0) {
			$where[]			= "up.helvetica = 0";
		}
		
		// g�n�re le where
		if (is_array($where)) {
			$_where				= " WHERE ".implode(' AND ', $where);
		}
		
		
		// compte le nombre de r�sultats
		$query = "SELECT COUNT(*)"
		." FROM user_suppr AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_stats AS us ON us.user_id = u.id"
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		// recherche des donn�es
		$query = "SELECT u.id, u.username, u.confirmed, u.published, u.ip, u.ip_pays, up.helvetica, up.genre, us.gold_limit_date, up.nom_origine, up.prenom_origine, up.telephone_origine, us.appel_date, us.appel_date2, us.points_total"
		." FROM user_suppr AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_stats AS us ON us.user_id = u.id"
		.$_where
		." ORDER BY ".strtolower((string) $search['order'])." ".strtoupper((string) $search['ascdesc'])
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$results	= $db->loadObjectList($query);
		
		
		// r�cup le nombre d'inscrits (table � part pour �viter les COUNT(*) sur la table user � chaque chargement de page
		$query = "SELECT papa, maman"
		." FROM inscrits"
		." LIMIT 0,1"
		;
		$inscrits = $db->loadObjectList($query);
		
		$total 	= $inscrits['maman'] + $inscrits['papa'];
		
		$stats['mamans'] 	= ceil($inscrits['maman'] / $total * 100);
		$stats['papas']		= 100 - $stats['mamans'];
		
		profil_suppr_HTML::profilLister($results, $search, $lists, $messages, $stats);
		
	}
	
	// donn�es de l'utilisateur
	function &getData() {
		global $userObj;
		
		$data = new StdClass();
		
		// params
		$data->id 						= JL::getVar('id', 0);
		
		return $data;
		
	}
	
?>

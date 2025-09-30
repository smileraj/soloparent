<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('search.html.php');

	global $app, $action, $user, $langue, $langString;

	// si non log dans l'appli search (hors step6submit qui fait partie du processus compliqu&eacute; d'inscription)
	if($app == 'search' && $action != 'step6submit' && !$user->id) {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
	}


	// gestion des messages d'erreurs
	$messages	= [];

	// variables
	$results	= [];
	if($_GET["lang"]=='fr')
		$langString = "";
	else
		$langString = "_".$_GET['lang'];

	// si search_online et search_page ne sont pas renseign&eacute;s, on reset leurs valeurs. Indispensable pour l'url rewriting par la suite !
	JL::setSession('search_page', intval(JL::getVar('search_page', 1)));

	switch($action) {
		
		case 'submitlastinscription':
			searchSubmit();
			JL::redirect(SITE_URL.'/index.php?app=search&action=search_last_inscription&search_page='.JL::getSession('search_page', 1).'&'.$langue);
		break;
		
		case 'search_last_inscription':
			searchLastInscription();
		break;
		
//profile Matching
		case 'profilematching':
			searchSubmit();
			JL::redirect(SITE_URL.'/index.php?app=search&action=profile_matching&search_page='.JL::getSession('search_page', 1).'&'.$langue);
		break;
		
		case 'profile_matching':
			profileMatching();
		break;
//end profile Matching
		case 'submitonline':
			searchSubmit();
			JL::redirect(SITE_URL.'/index.php?app=search&action=search_online&search_page='.JL::getSession('search_page', 1).'&'.$langue);
		break;
		
		case 'search_online':
			searchOnline();
		break;

		case 'step6': // issu de app_profil
		case 'search':
			searchResults();
			searchForm();
		break;


		case 'searchsubmit':
			searchSubmit();
			JL::redirect(SITE_URL.'/index.php?app=search&action=search&search_page='.JL::getSession('search_page', 1).'&'.$langue);
		break;
		
		case 'searchaffichage':
			JL::setSession('search_display', JL::getVar('search_display', 0));
			JL::redirect(SITE_URL.'/index.php?app=search&action=search&search_page='.JL::getSession('search_page', 1).'&'.$langue);
		break;

		case 'step6submit': // issu de app_profil
		case 'save':
			searchSubmit();
			searchSave();
			if($action == 'step6submit') {
				JL::redirect(SITE_URL.'/index.php?app=profil&action=step6submit'.'&'.$langue);
			} else {
				JL::redirect(SITE_URL.'/index.php?app=search&action=saved'.'&'.$langue);
			}
		break;

		case 'submitvisits':
			searchSubmit();
			JL::redirect(SITE_URL.'/index.php?app=search&action=visits&search_page='.JL::getSession('search_page', 1).'&'.$langue);
		break;
		
		case 'visits':
			searchVisits();
		break;
		
		case 'mylastvisits':
			searchMyprofile();
		break;

		case 'saved':
			searchResults();
			searchForm();
		break;

		default:
			JL::loadApp('404');
		break;

	}

	// sauvegarde la recherche dans la base de donn&eacute;es
	function searchSave() {
			global $langue;
			include("lang/app_search.".$_GET['lang'].".php");
		global $db, $user;

		// variables
		$search 			= [];


		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$search[$key]	= JL::getSession($key, $value, true);
			}
		}

		// petites corrections
		if(!$search['search_titre']) {
			$search['search_titre'] = ''.$lang_search["MaRechercheDu"].' '.date('d/m/Y').' &agrave; '.date('H:i');
		}

		// user log
		if($user->id) {

			// supprime l'ancienne recherche du m&ecirc;me nom si elle existe
			$query = "DELETE FROM user_recherche WHERE user_id = '".$user->id."'"; // AND titre LIKE '".$search['search_titre']."'"; TODO par la suite pour gestion de multiples recherches
			$db->query($query);

		} else {

			// supprime l'ancienne recherche du m&ecirc;me nom si elle existe
			$query = "DELETE FROM user_recherche WHERE user_id_tmp LIKE '".JL::getSession('upload_dir', 0)."'"; // AND titre LIKE '".$search['search_titre']."'"; TODO par la suite pour gestion de multiples recherches
			$db->query($query);

		}


		// enregistre la recherche
		$query = "INSERT INTO user_recherche SET"
		." user_id = '".$user->id."',"
		." user_id_tmp = '".JL::getSession('upload_dir', 0)."',"
		." titre = '".$search['search_titre']."',"
		." search_canton_id = '".$search['search_canton_id']."',"
		." search_ville_id = '".$search['search_ville_id']."',"
		." search_recherche_age_min = '".$search['search_recherche_age_min']."',"
		." search_recherche_age_max = '".$search['search_recherche_age_max']."',"
		." search_username = '".$search['search_username']."',"
		." search_vie_id = '".implode(',', $search['search_vie_id'])."',"
		." search_cuisine_id = '".implode(',', $search['search_cuisine_id'])."',"
		." search_sortie_id = '".implode(',', $search['search_sortie_id'])."',"
		." search_loisir_id = '".implode(',', $search['search_loisir_id'])."',"
		." search_sport_id = '".implode(',', $search['search_sport_id'])."',"
		." search_musique_id = '".implode(',', $search['search_musique_id'])."',"
		." search_film_id = '".implode(',', $search['search_film_id'])."',"
		." search_lecture_id = '".implode(',', $search['search_lecture_id'])."',"
		." search_animaux_id = '".implode(',', $search['search_animaux_id'])."',"
		." search_nationalite_id = '".implode(',', $search['search_nationalite_id'])."',"
		." search_religion_id = '".implode(',', $search['search_religion_id'])."',"
		." search_langue_id = '".implode(',', $search['search_langue_id'])."',"
		." search_statut_marital_id = '".implode(',', $search['search_statut_marital_id'])."',"
		." search_me_marier_id = '".implode(',', $search['search_me_marier_id'])."',"
		." search_cherche_relation_id = '".implode(',', $search['search_cherche_relation_id'])."',"
		." search_niveau_etude_id = '".implode(',', $search['search_niveau_etude_id'])."',"
		." search_secteur_activite_id = '".implode(',', $search['search_secteur_activite_id'])."',"
		." search_fumer_id = '".implode(',', $search['search_fumer_id'])."',"
		." search_temperament_id = '".implode(',', $search['search_temperament_id'])."',"
		." search_vouloir_enfants_id = '".implode(',', $search['search_vouloir_enfants_id'])."',"
		." search_signe_astrologique_id = '".implode(',', $search['search_signe_astrologique_id'])."',"
		." search_silhouette_id = '".implode(',', $search['search_silhouette_id'])."',"
		." search_style_coiffure_id = '".implode(',', $search['search_style_coiffure_id'])."',"
		." search_cheveux_id = '".implode(',', $search['search_cheveux_id'])."',"
		." search_yeux_id = '".implode(',', $search['search_yeux_id'])."',"
		." search_origine_id = '".implode(',', $search['search_origine_id'])."',"
		." search_online = '".$search['search_online']."'"
		;
		$db->query($query);

	}


	// variables accept&eacute;es par le moteur de recherche
	function search_data() {
			global $langue;
		$_data	= [

				// navigation
				'search_page' => 1,
				'search_page_total' => 1,
				'search_display' => 0, // 0: affichage en liste, 1: affichage en vignettes

				// divers
				'search_online' => 0,
				'search_titre' => 'Ma recherche le '.date('d/m/y'),


				// Main criteria
				'search_genre' => '',
				'search_nb_enfants' => 0,
				'search_canton_id' => 0,
				'search_ville_id' => 0,
				'search_username' => '',
				'search_recherche_age_min' => 0,
				'search_recherche_age_max' => 0,
				'search_recherche_taille_min' => 0,
				'search_recherche_taille_max' => 0,
				'search_recherche_poids_min' => 0,
				'search_recherche_poids_max' => 0,

				// crit&egrave;res facultatifs
				'search_signe_astrologique_id' => [0],
				'search_silhouette_id' => [0],
				'search_style_coiffure_id' => [0],
				'search_cheveux_id' => [0],
				'search_yeux_id' => [0],
				'search_origine_id' => [0],
				'search_nationalite_id' => [0],
				'search_religion_id' => [0],
				'search_langue_id' => [0],
				'search_statut_marital_id' => [0],
				'search_me_marier_id' => [0],
				'search_cherche_relation_id' => [0],
				'search_niveau_etude_id' => [0],
				'search_secteur_activite_id' => [0],
				'search_fumer_id' => [0],
				'search_temperament_id' => [0],
				'search_garde_id' => [0],
				'search_vouloir_enfants_id' => [0],
				'search_vie_id' => [0],
				'search_cuisine_id' => [0],
				'search_sortie_id' => [0],
				'search_loisir_id' => [0],
				'search_sport_id' => [0],
				'search_musique_id' => [0],
				'search_film_id' => [0],
				'search_lecture_id' => [0],
				'search_animaux_id' => [0]

			];
		return $_data;
	}

	// r&eacute;cup&eacute;ration des r&eacute;sultats
	function searchResults() {
			global $langue,$langString;
			include("lang/app_search.".$_GET['lang'].".php");
		global $db, $user, $results;

		// variables
		$search 			= [];
		$where				= null;
		$_where				= '';


		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$search[$key]	= JL::getSession($key, $value, true);
			}
		}

		// r&eacute;cup les variables qui peuvent &ecirc;tre pass&eacute;es directement dans l'url
		
		// pagination
		$resultatParPage	= 16;
		

		// correction au cas o&ugrave; le visiteur s'amuserait avec les params de l'url
		if($search['search_page'] <= 0) {
			$search['search_page'] = 1;
			JL::setSession('search_page', 1);
		}


		// auto correction du genre
		$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
		$genre = $db->loadResult($query);

		$search['search_genre'] = $genre == 'f' ? 'h' : 'f';



		// champs obligatoires
		$where[]	= "u.confirmed > 0";
		$where[]	= "u.published = 1";
		$where[]	= "u.id != '".$user->id."'";
		$where[]	= "up.genre = '".$search['search_genre']."'";
		$where[]	= "u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)";
		$where[]	= "u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)";


		// crit&egrave;res principaux

		// &acirc;ge mini
		
		if(intval($search['search_recherche_age_min']) > 0) {
			$where[]	= "up.naissance_date <= DATE_SUB(NOW(), INTERVAL ".intval($search['search_recherche_age_min'])." YEAR)";
		}

		// &acirc;ge max
		if(intval($search['search_recherche_age_max']) > 0) {
			$where[]	= "up.naissance_date >= DATE_SUB(NOW(), INTERVAL ".(intval($search['search_recherche_age_max'])+1)." YEAR)";
		}
		
		// taille mini
		if(intval($search['search_recherche_taille_min']) > 0) {
			$where[]	= "up.taille_id >= ".$search['search_recherche_taille_min'];
		}

		// taille max
		if(intval($search['search_recherche_taille_max']) > 0) {
			$where[]	= "up.taille_id <= ".$search['search_recherche_taille_max'];
		}
		
		// poids mini
		if(intval($search['search_recherche_poids_min']) > 0) {
			$where[]	= "up.poids_id >= ".$search['search_recherche_poids_min'];
		}

		// taille max
		if(intval($search['search_recherche_poids_max']) > 0) {
			$where[]	= "up.poids_id <= ".$search['search_recherche_poids_max'];
		}


		// canton
		if(intval($search['search_canton_id']) > 0) {
			$where[]	= "up.canton_id = '".$search['search_canton_id']."'";
		}

		// ville
		if(intval($search['search_ville_id']) > 0) {
			$where[]	= "up.ville_id = '".$search['search_ville_id']."'";
		}

		// username
		if(strlen((string) $search['search_username']) >= 3 && preg_match('/^[a-zA-Z0-9._-]+$/', (string) $search['search_username'])) {
			$where[]	= "u.username LIKE '%".$search['search_username']."%'";
		}

		// nombre d'enfants
		if(intval($search['search_nb_enfants']) > 0) {
			$where[]	= "up.nb_enfants >= '".$search['search_nb_enfants']."'";
		}


		// online
		if($search['search_online']) {
			//$where[]	= "(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) < ".(ONLINE_TIME_LIMIT+AFK_TIME_LIMIT);
			$where[] = "(u.online = '1' and (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) < ".(ONLINE_TIME_LIMIT+AFK_TIME_LIMIT).")";
		}

		SQLwhereCritFac($where, $search, 'search_signe_astrologique_id');

		// silhouette
		SQLwhereCritFac($where, $search, 'search_silhouette_id');

		// style coiffure
		SQLwhereCritFac($where, $search, 'search_style_coiffure_id');

		// cheveux
		SQLwhereCritFac($where, $search, 'search_cheveux_id');

		// yeux
		SQLwhereCritFac($where, $search, 'search_yeux_id');

		// origine
		SQLwhereCritFac($where, $search, 'search_origine_id');

		// nationalit&eacute;
		SQLwhereCritFac($where, $search, 'search_nationalite_id');

		// religion
		SQLwhereCritFac($where, $search, 'search_religion_id');

		// langue
		SQLwhereCritFac($where, $search, 'search_langue_id', true);

		// statut marital
		SQLwhereCritFac($where, $search, 'search_statut_marital_id');

		// me marier
		SQLwhereCritFac($where, $search, 'search_me_marier_id');

		// cherche relation
		SQLwhereCritFac($where, $search, 'search_cherche_relation_id');

		// niveau etude
		SQLwhereCritFac($where, $search, 'search_niveau_etude_id');

		// secteu activite
		SQLwhereCritFac($where, $search, 'search_secteur_activite_id');

		// fumer
		SQLwhereCritFac($where, $search, 'search_fumer_id');

		// temperament
		SQLwhereCritFac($where, $search, 'search_temperament_id');
		
		// Qui a la garde?
		SQLwhereCritFac($where, $search, 'search_garde_id');

		// vouloir enfants
		SQLwhereCritFac($where, $search, 'search_vouloir_enfants_id');

		// style de vie
		SQLwhereCritFac($where, $search, 'search_vie_id');

		// cuisine
		SQLwhereCritFac($where, $search, 'search_cuisine_id', true);

		// sortie
		SQLwhereCritFac($where, $search, 'search_sortie_id', true);

		// loisirs
		SQLwhereCritFac($where, $search, 'search_loisir_id', true);

		// sport
		SQLwhereCritFac($where, $search, 'search_sport_id', true);

		// musique
		SQLwhereCritFac($where, $search, 'search_musique_id', true);

		// film
		SQLwhereCritFac($where, $search, 'search_film_id', true);

		// lecture
		SQLwhereCritFac($where, $search, 'search_film_id', true);

		// animaux
		SQLwhereCritFac($where, $search, 'search_animaux_id', true);

		// pas en black list
		//$where[]	= "uf.user_id_to IS NULL";

		// g&eacute;n&egrave;re le where
		$_where		= " WHERE ".implode(' AND ', $where);



		// compte le nombre de r&eacute;sultats
		$query = "SELECT COUNT(*)"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		.$_where
		;
		JL::setSession('search_page_total', ceil(intval($db->loadResult($query))/$resultatParPage));


		// recherche des donn&eacute;es		
		$query = "SELECT u.id, u.username, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, pc.abreviation AS canton_abrev, up.genre, up.recherche_age_min, up.recherche_age_max, up.recherche_nb_enfants, IFNULL(pv.nom, '') AS ville, IFNULL(ua.annonce_valide, '') AS annonce, up.photo_defaut, up.nb_enfants, CURRENT_DATE, up.naissance_date, IF(us.gold_limit_date >= NOW(),1,0) AS gold, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, u.online"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_stats AS us ON us.user_id = u.id"
		." LEFT JOIN user_annonce AS ua ON (ua.user_id = u.id AND ua.published = 1)"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		.$_where
		.' ORDER BY gold DESC, u.last_online DESC'
		.' LIMIT '.(($search['search_page'] - 1) * $resultatParPage).', '.$resultatParPage
		;

		$results	= $db->loadObjectList($query);

	}


	// r&eacute;cup&eacute;ration des visites d'un profil
	function searchVisits() {
			global $langue,$langString;
			include("lang/app_search.".$_GET['lang'].".php");
		global $db, $user, $results;

		// variables
		$search 			= [];
		$list 			= [];
		$where				= null;
		$_where				= '';


		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$search[$key]	= JL::getSession($key, $value, true);
			}
		}


		// pagination
		$resultatParPage	= 16;
		

		// correction au cas o&ugrave; le visiteur s'amuserait avec les params de l'url
		if($search['search_page'] <= 0) {
			$search['search_page'] = 1;
			JL::setSession('search_page', 1);
		}

		// affichage galerie ou liste
		$list['search_display']		= $search['search_display'];

		// where de la recherche
		$where[]	= "u.confirmed > 0";
		$where[]	= "u.published = 1";
		$where[]	= "uv.user_id_to = '".$user->id."'";
		$where[]	= "u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)";
		$where[]	= "u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)";


		// g&eacute;n&egrave;re le where
		$_where		= " WHERE ".implode(' AND ', $where);



		// compte le nombre de r&eacute;sultats
		$query = "SELECT COUNT(*)"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_visite AS uv ON uv.user_id_from = u.id"
		.$_where
		;
		JL::setSession('search_page_total', ceil(intval($db->loadResult($query))/$resultatParPage));


		// recherche des donn&eacute;es
		$query = "SELECT u.id, u.username, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, pc.abreviation AS canton_abrev, up.genre, up.recherche_age_min, up.recherche_age_max, up.recherche_nb_enfants, IFNULL(pv.nom, '') AS ville, ua.annonce_valide AS annonce, up.photo_defaut, up.nb_enfants, CURRENT_DATE, up.naissance_date, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, uv.visite_nb, uv.visite_last_date, u.online,u.on_off_status"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_annonce AS ua ON ua.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		." INNER JOIN user_visite AS uv ON uv.user_id_from = u.id"
		.$_where
		.' ORDER BY uv.visite_last_date DESC, uv.visite_nb DESC'
		.' LIMIT '.(($search['search_page'] - 1) * $resultatParPage).', '.$resultatParPage
		;
		$results	= $db->loadObjectList($query);


		HTML_search::searchVisits($list, $results, $messages);
	}
	
	// r&eacute;cup&eacute;ration des visites d'un profil
	function searchMyprofile() {
			global $langue,$langString;
			include("lang/app_search.".$_GET['lang'].".php");
		global $db, $user, $results;

		// variables
		$search 			= [];
		$list 			= [];
		$where				= null;
		$_where				= '';


		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$search[$key]	= JL::getSession($key, $value, true);
			}
		}


		// pagination
		$resultatParPage	= 16;
		

		// correction au cas o&ugrave; le visiteur s'amuserait avec les params de l'url
		if($search['search_page'] <= 0) {
			$search['search_page'] = 1;
			JL::setSession('search_page', 1);
		}

		// affichage galerie ou liste
		$list['search_display']		= $search['search_display'];

		// where de la recherche
		$where[]	= "u.confirmed > 0";
		$where[]	= "u.published = 1";
		$where[]	= "uv.user_id_from = '".$user->id."'";
		$where[]	= "u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)";
		$where[]	= "u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)";


		// g&eacute;n&egrave;re le where
		$_where		= " WHERE ".implode(' AND ', $where);



		// compte le nombre de r&eacute;sultats
		$query = "SELECT COUNT(*)"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_visite AS uv ON uv.user_id_from = u.id"
		.$_where
		;
		JL::setSession('search_page_total', ceil(intval($db->loadResult($query))/$resultatParPage));


		// recherche des donn&eacute;es
		 $query = "SELECT u.id, u.username, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, pc.abreviation AS canton_abrev, up.genre, up.recherche_age_min, up.recherche_age_max, up.recherche_nb_enfants, IFNULL(pv.nom, '') AS ville, ua.annonce_valide AS annonce, up.photo_defaut, up.nb_enfants, CURRENT_DATE, up.naissance_date, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, uv.visite_nb, uv.visite_last_date, u.online,u.on_off_status"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_annonce AS ua ON ua.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		." INNER JOIN user_visite AS uv ON uv.user_id_to = u.id"
		.$_where
		.' ORDER BY uv.visite_last_date DESC, uv.visite_nb DESC'
		.' LIMIT '.(($search['search_page'] - 1) * $resultatParPage).', '.$resultatParPage
		;
		$results	= $db->loadObjectList($query);


		HTML_search::searchMyprofile($list, $results, $messages);
	}

	
	// r&eacute;cup&eacute;ration des r&eacute;sultats
	function searchOnline() {
		global $langue,$langString;
		include("lang/app_search.".$_GET['lang'].".php");
		global $db, $user, $results;

		// variables
		$search 			= [];
		$list 			= [];
		$where				= null;
		$_where				= '';


		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$search[$key]	= JL::getSession($key, $value, true);
			}
		}

		// r&eacute;cup les variables qui peuvent &ecirc;tre pass&eacute;es directement dans l'url
		
		// pagination
		$resultatParPage	= 16;
		

		// correction au cas o&ugrave; le visiteur s'amuserait avec les params de l'url
		if($search['search_page'] <= 0) {
			$search['search_page'] = 1;
			JL::setSession('search_page', 1);
		}


		// auto correction du genre
		$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
		$genre = $db->loadResult($query);

		$search['search_genre'] = $genre == 'f' ? 'h' : 'f';

		// affichage galerie ou liste
		$list['search_display']		= $search['search_display'];

		// champs obligatoires
		$where[]	= "u.confirmed > 0";
		$where[]	= "u.published = 1";
		$where[]	= "u.id != '".$user->id."'";
		$where[]	= "up.genre = '".$search['search_genre']."'";
		$where[]	= "u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)";
		$where[]	= "u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)";


		// crit&egrave;res principaux
		$where[] = "(u.online = '1' and (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) < ".(ONLINE_TIME_LIMIT+AFK_TIME_LIMIT).")";
		

		// g&eacute;n&egrave;re le where
		$_where		= " WHERE ".implode(' AND ', $where);



		// compte le nombre de r&eacute;sultats
		$query = "SELECT COUNT(*)"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		.$_where
		;
		JL::setSession('search_page_total', ceil(intval($db->loadResult($query))/$resultatParPage));


		// recherche des donn&eacute;es		
		$query = "SELECT u.id, u.username, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, pc.abreviation AS canton_abrev, up.genre, up.recherche_age_min, up.recherche_age_max, up.recherche_nb_enfants, IFNULL(pv.nom, '') AS ville, IFNULL(ua.annonce_valide, '') AS annonce, up.photo_defaut, up.nb_enfants, CURRENT_DATE, up.naissance_date, IF(us.gold_limit_date >= NOW(),1,0) AS gold, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, u.online"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_stats AS us ON us.user_id = u.id"
		." LEFT JOIN user_annonce AS ua ON (ua.user_id = u.id AND ua.published = 1)"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		.$_where
		.' ORDER BY gold DESC, u.last_online DESC'
		.' LIMIT '.(($search['search_page'] - 1) * $resultatParPage).', '.$resultatParPage
		;

		$results	= $db->loadObjectList($query);

		HTML_search::searchOnline($list, $results, $messages);
	}
	
	
	// r&eacute;cup&eacute;ration des r&eacute;sultats
	function searchLastInscription() {
		global $langue,$langString;
		include("lang/app_search.".$_GET['lang'].".php");
		global $db, $user, $results;

		// variables
		$search 			= [];
		$list 			= [];
		$where				= null;
		$_where				= '';


		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$search[$key]	= JL::getSession($key, $value, true);
			}
		}

		// r&eacute;cup les variables qui peuvent &ecirc;tre pass&eacute;es directement dans l'url
		
		// pagination
		$resultatParPage	= 16;
		

		// correction au cas o&ugrave; le visiteur s'amuserait avec les params de l'url
		if($search['search_page'] <= 0) {
			$search['search_page'] = 1;
			JL::setSession('search_page', 1);
		}


		// auto correction du genre
		$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
		$genre = $db->loadResult($query);

		$search['search_genre'] = $genre == 'f' ? 'h' : 'f';

		// affichage galerie ou liste
		$list['search_display']		= $search['search_display'];

		// champs obligatoires
		$where[]	= "u.confirmed > 0";
		$where[]	= "u.published = 1";
		$where[]	= "u.id != '".$user->id."'";
		$where[]	= "up.genre = '".$search['search_genre']."'";
		$where[]	= "u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)";
		$where[]	= "u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)";
		

		// g&eacute;n&egrave;re le where
		$_where		= " WHERE ".implode(' AND ', $where);



		// compte le nombre de r&eacute;sultats
		$query = "SELECT COUNT(*)"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		.$_where
		;
		JL::setSession('search_page_total', ceil(intval($db->loadResult($query))/$resultatParPage));


		// recherche des donn&eacute;es		
		$query = "SELECT u.id, u.username, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, pc.abreviation AS canton_abrev, up.genre, up.recherche_age_min, up.recherche_age_max, up.recherche_nb_enfants, IFNULL(pv.nom, '') AS ville, IFNULL(ua.annonce_valide, '') AS annonce, up.photo_defaut, up.nb_enfants, CURRENT_DATE, up.naissance_date, IF(us.gold_limit_date >= NOW(),1,0) AS gold, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, u.creation_date, u.online"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_stats AS us ON us.user_id = u.id"
		." LEFT JOIN user_annonce AS ua ON (ua.user_id = u.id AND ua.published = 1)"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		.$_where
		.' ORDER BY  u.creation_date DESC'
		.' LIMIT '.(($search['search_page'] - 1) * $resultatParPage).', '.$resultatParPage
		;

		$results	= $db->loadObjectList($query);

		HTML_search::searchLastInscription($list, $results, $messages);
	}
	
	//Profile Matching
	// r&eacute;cup&eacute;ration des r&eacute;sultats
	function profileMatching() {
		global $langue,$langString;
		include("lang/app_search.".$_GET['lang'].".php");
		global $db, $user, $results;

		// variables
		$search 			= [];
		$list 			= [];
		$where				= null;
		$_where				= '';


		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$search[$key]	= JL::getSession($key, $value, true);
			}
		}

		// r&eacute;cup les variables qui peuvent &ecirc;tre pass&eacute;es directement dans l'url
		
		// pagination
		$resultatParPage	= 20;
		

		// correction au cas o&ugrave; le visiteur s'amuserait avec les params de l'url
		if($search['search_page'] <= 0) {
			$search['search_page'] = 1;
			JL::setSession('search_page', 1);
		}


		// Self-correction
		$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
		$genre = $db->loadResult($query);
		
		// Self-correction
		$query = "SELECT religion_id, nationalite_id, canton_id, TIMESTAMPDIFF(YEAR,naissance_date,CURDATE()) as userage, recherche_age_min, recherche_age_max FROM user_profil WHERE user_id = '".$user->id."'";
		$values_select = $db->loadObject($query);
$age_max_pro=(($values_select->userage)+5);
		$age_min_pro=(($values_select->userage)-5);
		//echo $values_select->religion_id.$values_select->nationalite_id.$values_select->canton_id.$user->id;
			
		// Self-correction
		$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
		$genre = $db->loadResult($query);
		
		$search['search_genre'] = $genre == 'f' ? 'h' : 'f';

		// affichage galerie ou liste
		$list['search_display']		= $search['search_display'];

		// Required fields
		$where[]	= "u.confirmed > 0";
		$where[]	= "u.published = 1";
		$where[]	= "u.id != '".$user->id."'";
		$where[]	= "up.genre = '".$search['search_genre']."'";
		$where[]	= "(((up.religion_id = '".$values_select->religion_id."' or up.nationalite_id = '".$values_select->nationalite_id."') and up.canton_id = '".$values_select->canton_id."') and (TIMESTAMPDIFF(YEAR,up.naissance_date,NOW()) BETWEEN '".$age_min_pro."' and '".$age_max_pro."'))";//profile
		//$where[]	= "((up.religion_id = '".$values_select->religion_id."' OR up.nationalite_id = '".$values_select->nationalite_id."' OR up.canton_id = '".$values_select->canton_id."') or (TIMESTAMPDIFF(YEAR,up.naissance_date,NOW()) BETWEEN '".$values_select->recherche_age_min."' and '".$values_select->recherche_age_max."'))";//profile
		$where[]	= "u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)";
		$where[]	= "u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)";
		

		// g&eacute;n&egrave;re le where
		$_where		= " WHERE ".implode(' AND ', $where);



		// compte le nombre de r&eacute;sultats
		$query = "SELECT COUNT(*)"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		.$_where
		;
		JL::setSession('search_page_total', ceil(intval($db->loadResult($query))/$resultatParPage));


		// recherche des donn&eacute;es		
		 $query = "SELECT u.id, u.username, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, TIMESTAMPDIFF(YEAR,up.naissance_date,NOW()) AS age, pc.abreviation AS canton_abrev, up.genre, up.religion_id, up.nationalite_id, up.canton_id, up.recherche_age_min, up.recherche_age_max, up.recherche_nb_enfants, IFNULL(pv.nom, '') AS ville, IFNULL(ua.annonce_valide, '') AS annonce, up.photo_defaut, up.nb_enfants, CURRENT_DATE, up.naissance_date, IF(us.gold_limit_date >= NOW(),1,0) AS gold, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, u.creation_date, u.online,u.on_off_status"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_stats AS us ON us.user_id = u.id"
		." LEFT JOIN user_annonce AS ua ON (ua.user_id = u.id AND ua.published = 1)"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		.$_where
		.' ORDER BY  u.creation_date DESC'
		.' LIMIT '.(($search['search_page'] - 1) * $resultatParPage).', '.$resultatParPage
		;

		$results	= $db->loadObjectList($query);

		HTML_search::profile_Matching($list, $results, $messages);
	}
	//End Profile Matching
	
	

	// passage en session des params de recherche
	function searchSubmit() {
			global $langue;
			include("lang/app_search.".$_GET['lang'].".php");
		global $db, $user;

		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// user log
		if($user->id) {

			// r&eacute;cup le genre de l'utilisateur
			$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
			$genre = $db->loadResult($query);

			// si c'est un homme
			if($genre == 'h') {
				JL::setVar('search_genre', 'f');
			} else { // sinon si c'est une femme
				JL::setVar('search_genre', 'h');
			}

		} else { // user en cours d'inscription

			JL::setVar('search_genre',JL::getSession('genre', ''));

		}
		
		JL::setVar('search_display',JL::getSession('search_display', 0));
		
		// stock les donn&eacute;es temporaires en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}

	}


	// formulaire de recherche
	function searchForm() {
			global $langue,$langString;
			include("lang/app_search.".$_GET['lang'].".php");
		global $db, $user, $results, $messages, $action;

		// variables
		$list 		= [];

		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {				
				$row[$key]	= JL::getSession($key, $value);
			}
		}


		// crit&egrave;res principaux

			// genre
			if($user->id || JL::getSession('genre', '', true)) { // user log ou user en cours d'inscription

				// user log
				if($user->id) {

					// r&eacute;cup le genre de l'utilisateur
					$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
					$genre = $db->loadResult($query);

				} else { // user en corus d'inscription

					$genre = JL::getSession('genre', '', true);

				}

				// si c'est un homme
				if($genre == 'h') {

					$row['search_genre'] 	= 'f';
					$list['search_genre']	= '<b><span class="femme">'.$lang_search["UneMaman"].'</span></b>';

				} else { // sinon si c'est une femme

					$row['search_genre'] 	= 'h';
					$list['search_genre']	= '<b><span class="homme">'.$lang_search["UnPapa"].'</span></b>';

				}

			} else {

				$list['search_genre']	= '<input type="radio" name="search_genre" value="h" id="homme"/> <label for="homme"><b>'.$lang_search["UnHomme"].'</b></label> <input type="radio" name="search_genre" value="f" id="femme"/> <label for="femme"><b>'.$lang_search["UneFemme"].'</b></label> :';

			}

			// nombre d'enfants
			for($i=1; $i<=4; $i++) {
				$list_nb_enfants[] = JL::makeOption($i, $i.' '.$lang_search["OuPlus"]);
			}
			$list_nb_enfants[] = JL::makeOption(5, $lang_search["PlusDe4"]);
			$list['search_nb_enfants'] = JL::makeSelectList( $list_nb_enfants, 'search_nb_enfants', '', 'value', 'text', $row['search_nb_enfants']);


			// recherche &acirc;ge mini
			$list_recherche_age_min[] = JL::makeOption('0', '--');
			for($i=18; $i<=(intval(date('Y'))-1930); $i++) {
				$list_recherche_age_min[] = JL::makeOption($i, $i);
			}
			$list['search_recherche_age_min'] = JL::makeSelectList( $list_recherche_age_min, 'search_recherche_age_min', 'class="select50"', 'value', 'text', $row['search_recherche_age_min']);

			$list_recherche_age_max[] = JL::makeOption('0', '--');
			for($i=18; $i<=(intval(date('Y'))-1930); $i++) {
				$list_recherche_age_max[] = JL::makeOption($i, $i);
			}
			$list['search_recherche_age_max'] = JL::makeSelectList( $list_recherche_age_max, 'search_recherche_age_max', 'class="select50"', 'value', 'text', $row['search_recherche_age_max']);


			// canton
			$list_canton_id[] = JL::makeOption('0', '> '.$lang_search["Canton"]);
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_canton"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;

			$list_canton_id = array_merge($list_canton_id, $db->loadObjectList($query));
			$list['search_canton_id'] 	= JL::makeSelectList( $list_canton_id, 'search_canton_id', 'id="search_canton_id" onChange="loadVilles(\'search_\');"', 'value', 'text', $row['search_canton_id']);
			//$list['search_ville_id']	= '<input type="hidden" id="search_ville_id" name="search_ville_id" value="'.$row['search_ville_id'].'" />';
$canton= $row['search_canton_id'];
// ville
		$list_Ville_id[] = JL::makeOption('0', '> '.$lang_search["Ville"]);
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_ville"
		." WHERE canton_id = '".$canton."' and published = 1"
		." ORDER BY nom ASC"
		;
		$list_Ville_id = array_merge($list_Ville_id, $db->loadObjectList($query));
		$list['search_ville_id'] 	= JL::makeSelectList( $list_Ville_id, 'search_ville_id', 'id="search_ville_id"  class="genreCanton"', 'value', 'text', $row['search_ville_id']);
			// pseudo
			$list['search_username']	= makeSafe($row['search_username']);

			// titre de la recherche
			$list['search_titre']		= makeSafe($row['search_titre']);

			// en ligne
			$list['search_online']		= $row['search_online'];

			// affichage galerie ou liste
			$list['search_display']		= $row['search_display'];


		// crit&egrave;res facultatifs
			$list_recherche_taille_min[] = JL::makeOption('0', '--');
			for($i=140; $i<=200; $i++) {
				$list_recherche_taille_min[] = JL::makeOption($i, $i);
			}
			$list['search_recherche_taille_min'] = JL::makeSelectList( $list_recherche_taille_min, 'search_recherche_taille_min', 'class="select50"', 'value', 'text', $row['search_recherche_taille_min']);
			
			$list_recherche_taille_max[] = JL::makeOption('0', '--');
			for($i=140; $i<=200; $i++) {
				$list_recherche_taille_max[] = JL::makeOption($i, $i);
			}
			$list['search_recherche_taille_max'] = JL::makeSelectList( $list_recherche_taille_max, 'search_recherche_taille_max', 'class="select50"', 'value', 'text', $row['search_recherche_taille_max']);
		
		
		// crit&egrave;res facultatifs
			$list_recherche_poids_min[] = JL::makeOption('0', '--');
			for($i=40; $i<=120; $i++) {
				$list_recherche_poids_min[] = JL::makeOption($i, $i);
			}
			$list['search_recherche_poids_min'] = JL::makeSelectList( $list_recherche_poids_min, 'search_recherche_poids_min', 'class="select50"', 'value', 'text', $row['search_recherche_poids_min']);
			
			$list_recherche_poids_max[] = JL::makeOption('0', '--');
			for($i=40; $i<=120; $i++) {
				$list_recherche_poids_max[] = JL::makeOption($i, $i);
			}
			$list['search_recherche_poids_max'] = JL::makeSelectList( $list_recherche_poids_max, 'search_recherche_poids_max', 'class="select50"', 'value', 'text', $row['search_recherche_poids_max']);
			
			
			// signe astrologique
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_signe_astrologique"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbsigne=$db->loadObjectList($query);
			$list['search_signe_astrologique_id'] = JL::makeCheckboxSearchList($dbsigne, 'search_signe_astrologique_id[]', '', 'value', 'text', $row['search_signe_astrologique_id']); 

			// silhouette
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_silhouette"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbsilhouette=$db->loadObjectList($query);
			$list['search_silhouette_id'] = JL::makeCheckboxSearchList($dbsilhouette, 'search_silhouette_id[]', '', 'value', 'text', $row['search_silhouette_id']); 

			// style coiffure
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_style_coiffure"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbstyle=$db->loadObjectList($query);
			$list['search_style_coiffure_id'] = JL::makeCheckboxSearchList($dbstyle, 'search_style_coiffure_id[]', '', 'value', 'text', $row['search_style_coiffure_id']); 

			// cheveux
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_cheveux"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbcheveux=$db->loadObjectList($query);
			$list['search_cheveux_id'] = JL::makeCheckboxSearchList($dbcheveux, 'search_cheveux_id[]', '', 'value', 'text', $row['search_cheveux_id']); 

			// yeux
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_yeux"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbyeux=$db->loadObjectList($query);
			$list['search_yeux_id'] = JL::makeCheckboxSearchList($dbyeux, 'search_yeux_id[]', '', 'value', 'text', $row['search_yeux_id']); 

			// origine
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_origine"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dborigine=$db->loadObjectList($query);
			$list['search_origine_id'] = JL::makeCheckboxSearchList($dborigine,'search_origine_id[]', '', 'value', 'text', $row['search_origine_id']); 

			// nationalit&eacute;
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_nationalite"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbnationalite=$db->loadObjectList($query);
			$list['search_nationalite_id'] = JL::makeCheckboxSearchList($dbnationalite, 'search_nationalite_id[]', '', 'value', 'text', $row['search_nationalite_id']); 

			// religion
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_religion"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbreligion=$db->loadObjectList($query);
			$list['search_religion_id'] = JL::makeCheckboxSearchList($dbreligion, 'search_religion_id[]', '', 'value', 'text', $row['search_religion_id']); 

			// langues
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_langue"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dblangues=$db->loadObjectList($query);
			$list['search_langue_id'] = JL::makeCheckboxSearchList($dblangues, 'search_langue_id[]', '', 'value', 'text', $row['search_langue_id']); 

			// statut marital
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_statut_marital"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbstatut=$db->loadObjectList($query);
			$list['search_statut_marital_id'] = JL::makeCheckboxSearchList($dbstatut, 'search_statut_marital_id[]', '', 'value', 'text', $row['search_statut_marital_id']); 

			// me marier c'est...
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_me_marier"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbmarier=$db->loadObjectList($query);
			$list['search_me_marier_id'] = JL::makeCheckboxSearchList($dbmarier, 'search_me_marier_id[]', '', 'value', 'text', $row['search_me_marier_id']); 

			// je cherche une relation
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_cherche_relation"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbcherche=$db->loadObjectList($query);
			$list['search_cherche_relation_id'] = JL::makeCheckboxSearchList($dbcherche, 'search_cherche_relation_id[]', '', 'value', 'text', $row['search_cherche_relation_id']); 

			// niveau d'&eacute;tudes
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_niveau_etude"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbniveau=$db->loadObjectList($query);
			$list['search_niveau_etude_id'] = JL::makeCheckboxSearchList($dbniveau, 'search_niveau_etude_id[]', '', 'value', 'text', $row['search_niveau_etude_id']); 

			// Niveaux d'&eacute;tude
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_secteur_activite"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbNiveaux=$db->loadObjectList($query);
			$list['search_secteur_activite_id'] = JL::makeCheckboxSearchList($dbNiveaux, 'search_secteur_activite_id[]', '', 'value', 'text', $row['search_secteur_activite_id']); 

			// je fume
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_fumer"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbfume=$db->loadObjectList($query);
			$list['search_fumer_id'] = JL::makeCheckboxSearchList($dbfume, 'search_fumer_id[]', '', 'value', 'text', $row['search_fumer_id']); 

			// temp&eacute;rament
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_temperament"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbtemprament=$db->loadObjectList($query);
			$list['search_temperament_id'] = JL::makeCheckboxSearchList($dbtemprament, 'search_temperament_id[]', '', 'value', 'text', $row['search_temperament_id']); 
			
			// Qui a la garde?
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_garde"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbQui=$db->loadObjectList($query);
			$list['search_garde_id'] = JL::makeCheckboxSearchList($dbQui, 'search_garde_id[]', '', 'value', 'text', $row['search_garde_id']); 

			// veut des enfants
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_vouloir_enfants"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbenfants=$db->loadObjectList($query);
			$list['search_vouloir_enfants_id'] = JL::makeCheckboxSearchList($dbenfants, 'search_vouloir_enfants_id[]', '', 'value', 'text', $row['search_vouloir_enfants_id']); 

			// style de vie
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_vie"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbstyle=$db->loadObjectList($query);
			$list['search_vie_id'] = JL::makeCheckboxSearchList($dbstyle, 'search_vie_id[]', '', 'value', 'text', $row['search_vie_id']); 

			// cuisine
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_cuisine"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbcuisine=$db->loadObjectList($query);
			$list['search_cuisine_id'] = JL::makeCheckboxSearchList($dbcuisine, 'search_cuisine_id[]', '', 'value', 'text', $row['search_cuisine_id']); 

			// sortie
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_sortie"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbsortie=$db->loadObjectList($query);
			$list['search_sortie_id'] = JL::makeCheckboxSearchList($dbsortie, 'search_sortie_id[]', '', 'value', 'text', $row['search_sortie_id']); 

			// loisir
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_loisir"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$loisir=$db->loadObjectList($query);
			$list['search_loisir_id'] = JL::makeCheckboxSearchList($loisir, 'search_loisir_id[]', '', 'value', 'text', $row['search_loisir_id']); 

			// sport
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_sport"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbsport=$db->loadObjectList($query);
			$list['search_sport_id'] = JL::makeCheckboxSearchList($dbsport, 'search_sport_id[]', '', 'value', 'text', $row['search_sport_id']); 

			// musique
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_musique"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbmusique=$db->loadObjectList($query);
			$list['search_musique_id'] = JL::makeCheckboxSearchList($dbmusique, 'search_musique_id[]', '', 'value', 'text', $row['search_musique_id']); 

			// film
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_film"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbfilm=$db->loadObjectList($query);
			$list['search_film_id'] = JL::makeCheckboxSearchList($dbfilm, 'search_film_id[]', '', 'value', 'text', $row['search_film_id']); 

			// lecture
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_lecture"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dblecture=$db->loadObjectList($query);
			$list['search_lecture_id'] = JL::makeCheckboxSearchList($dblecture, 'search_lecture_id[]', '', 'value', 'text', $row['search_lecture_id']); 

			// animaux
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_animaux"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;
			$dbanimaux=$db->loadObjectList($query);
			$list['search_animaux_id'] = JL::makeCheckboxSearchList($dbanimaux, 'search_animaux_id[]', '', 'value', 'text', $row['search_animaux_id']); 
		
		// message
		if($action == 'saved') {
			$messages[] = '<span class="valid">'.$lang_search["RechercheSauvegardee"].' !</span>';
		}

		
		HTML_search::search($list, $results, $messages);

	}


	// cr&eacute;ation de la clause WHERE d'un crit&egrave;re facultatif
	function SQLwhereCritFac(&$where, &$search, $field, $triple = false) {
			global $langue;
		if (is_array($search[$field])) {
			if(in_array(0, $search[$field])) {
				JL::setSession($field, [0]);
			} else {
				$values = implode(',',$search[$field]);
				$field	= str_replace('search_', '', $field);
				if($triple) {
					$where[]	= "(up.".str_replace('_id', '1_id', $field)." IN (".$values.") OR up.".str_replace('_id', '2_id', $field)." IN (".$values.") OR up.".str_replace('_id', '3_id', $field)." IN (".$values."))";
				} else {
					$where[]	= "up.".$field." IN (".$values.")";
				}
			}
		}
	}


?>

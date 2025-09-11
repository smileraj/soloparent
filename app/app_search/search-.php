<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('search.html.php');

	global $app, $action, $user, $langue;

	// si non log dans l'appli search (hors step8submit qui fait partie du processus compliqu&eacute; d'inscription)
	if($app == 'search' && $action != 'step8submit' && !$user->id) {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
	}


	// gestion des messages d'erreurs
	$messages	= array();

	// variables
	$results	= array();
	if($_GET["lang"]=='fr')
		$langString = "";
	else
		$langString = "_$_GET[lang]";

	// si search_online et search_page ne sont pas renseign&eacute;s, on reset leurs valeurs. Indispensable pour l'url rewriting par la suite !
	JL::setSession('search_page', intval(JL::getVar('search_page', 1)));

	switch($action) {

		case 'results':
			$rechercheAvancee = !(isset($_GET['search_online']) && $_GET['search_online'] == 1);

			searchResults($rechercheAvancee);

			// on n'affiche pas le formulaire de recherche pour le lien "En ligne", d'o&ugrave; le test du GET uniquement (en POST on vient du formulaire de recherche)
			searchForm(true, $rechercheAvancee);

		break;

		case 'step8': // issu de app_profil
		case 'search':
			JL::setSession('search_online', 0);
			searchForm(false);
		break;


		case 'searchsubmit':
			searchSubmit();
			JL::redirect(SITE_URL.'/index.php?app=search&action=results&search_page=1'.((isset($_GET['search_online']) && $_GET['search_online'] == 1) ? '&search_online=1' : '').'&'.$langue);
		break;

		case 'step8submit': // issu de app_profil
		case 'save':
			searchSubmit();
			searchSave();
			if($action == 'step8submit') {
				JL::redirect(SITE_URL.'/index.php?app=profil&action=step8submit'.'&'.$langue);
			} else {
				JL::redirect(SITE_URL.'/index.php?app=search&action=saved'.'&'.$langue);
			}
		break;

		case 'visits':
			searchVisits();
			searchForm(true, false);
		break;

		case 'saved':
			searchForm(false);
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
		$search 			= array();


		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if(count($_data)) {
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


	// r&eacute;cup&eacute;ration des r&eacute;sultats
	function searchResults($rechercheAvancee = true) {
			global $langue,$langString;
			include("lang/app_search.".$_GET['lang'].".php");
		global $db, $user, $results;

		// variables
		$search 			= array();
		$where				= array();
		$_where				= '';


		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$search[$key]	= JL::getSession($key, $value, true);
			}
		}

		// r&eacute;cup les variables qui peuvent &ecirc;tre pass&eacute;es directement dans l'url
		JL::setSession('search_display', intval(JL::getVar('search_display', $search['search_display'])));
		$search['search_display']	= JL::getSessionInt('search_display', $search['search_display']);
		$search['search_online']	= JL::getVar('search_online', $search['search_online']);

		// pagination
		if($search['search_display'] == 0) { // liste
			$resultatParPage	= RESULTS_NB_LISTE;
		} else { // galerie
			$resultatParPage	= RESULTS_NB_GALERIE;
		}

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


		// crit&egrave;res principaux

		// &acirc;ge mini
		if($rechercheAvancee) {
			if(intval($search['search_recherche_age_min']) > 0) {
				$where[]	= "up.naissance_date <= DATE_SUB(NOW(), INTERVAL ".intval($search['search_recherche_age_min'])." YEAR)";
			}

			// &acirc;ge max
			if(intval($search['search_recherche_age_max']) > 0) {
				$where[]	= "up.naissance_date >= DATE_SUB(NOW(), INTERVAL ".(intval($search['search_recherche_age_max'])+1)." YEAR)";
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
			if(strlen($search['search_username']) >= 3 && preg_match('/^[a-zA-Z0-9._-]+$/', $search['search_username'])) {
				$where[]	= "u.username LIKE '%".$search['search_username']."%'";
			}

			// nombre d'enfants
			if(intval($search['search_nb_enfants']) > 0) {
				$where[]	= "up.nb_enfants >= '".$search['search_nb_enfants']."'";
			}

		}

		// online
		if($search['search_online']) {
			$where[]	= "(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) < ".(ONLINE_TIME_LIMIT+AFK_TIME_LIMIT);
		}


		// signe astrologique
		/*SQLwhereCritFac($where, $search, 'search_signe_astrologique_id');

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
		SQLwhereCritFac($where, $search, 'search_animaux_id', true);*/


		// pas en black list
		$where[]	= "uf.user_id_to IS NULL";

		// g&eacute;n&egrave;re le where
		$_where		= " WHERE ".implode(' AND ', $where);



		// compte le nombre de r&eacute;sultats
		$query = "SELECT COUNT(*)"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN user_flbl AS uf ON uf.user_id_to = u.id AND uf.user_id_from = '".$user->id."'"
		.$_where
		;
		JL::setSession('search_page_total', ceil(intval($db->loadResult($query))/$resultatParPage));


		// recherche des donn&eacute;es
		$query = "SELECT u.id, u.username, IFNULL(pc.nom, '') AS canton, up.genre, up.recherche_age_min, up.recherche_age_max, up.recherche_nb_enfants, IFNULL(pv.nom, '') AS ville, IFNULL(ua.annonce_valide, '') AS annonce, up.photo_defaut, up.nb_enfants, CURRENT_DATE, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age, IF(us.gold_limit_date >= NOW(),1,0) AS gold, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, uf.user_id_to"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_stats AS us ON us.user_id = u.id"
		." LEFT JOIN user_annonce AS ua ON (ua.user_id = u.id AND ua.published = 1)"
		." LEFT JOIN profil_canton$langString AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		." LEFT JOIN user_flbl AS uf ON (uf.user_id_to = u.id AND uf.user_id_from = '".$user->id."' AND uf.list_type = 0)"
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
		$search 			= array();
		$where				= array();
		$_where				= '';


		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$search[$key]	= JL::getSession($key, $value, true);
			}
		}

		// r&eacute;cup les variables qui peuvent &ecirc;tre pass&eacute;es directement dans l'url
		JL::setSession('search_display', intval(JL::getVar('search_display', $search['search_display'])));
		$search['search_display']	= JL::getSessionInt('search_display', $search['search_display']);
		$search['search_online']	= JL::getVar('search_online', $search['search_online']);

		// pagination
		if($search['search_display'] == 0) { // liste
			$resultatParPage	= RESULTS_NB_LISTE;
		} else { // galerie
			$resultatParPage	= RESULTS_NB_GALERIE;
		}

		// correction au cas o&ugrave; le visiteur s'amuserait avec les params de l'url
		if($search['search_page'] <= 0) {
			$search['search_page'] = 1;
			JL::setSession('search_page', 1);
		}


		// where de la recherche
		$where[]	= "u.confirmed > 0";
		$where[]	= "u.published = 1";
		$where[]	= "uv.user_id_to = '".$user->id."'";


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
		$query = "SELECT u.id, u.username, IFNULL(pc.nom, '') AS canton, up.genre, up.recherche_age_min, up.recherche_age_max, up.recherche_nb_enfants, IFNULL(pv.nom, '') AS ville, ua.annonce_valide AS annonce, up.photo_defaut, up.nb_enfants, CURRENT_DATE, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, uv.visite_nb, uv.visite_last_date"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_annonce AS ua ON ua.user_id = u.id"
		." LEFT JOIN profil_canton$langString AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		." INNER JOIN user_visite AS uv ON uv.user_id_from = u.id"
		.$_where
		.' ORDER BY uv.visite_last_date DESC, uv.visite_nb DESC'
		.' LIMIT '.(($search['search_page'] - 1) * $resultatParPage).', '.$resultatParPage
		;
		$results	= $db->loadObjectList($query);

	}


	// variables accept&eacute;es par le moteur de recherche
	function search_data() {
			global $langue;
		$_data	= array(

				// navigation
				'search_page' => 1,
				'search_page_total' => 1,
				'search_display' => 0, // 0: affichage en liste, 1: affichage en vignettes

				// divers
				'search_online' => 0,
				'search_titre' => 'Ma recherche le '.date('d/m/y'),


				// crit&egrave;res principaux
				'search_genre' => '',
				'search_nb_enfants' => 0,
				'search_canton_id' => 0,
				'search_ville_id' => 0,
				'search_username' => '',
				'search_recherche_age_min' => 0,
				'search_recherche_age_max' => 0,

				// crit&egrave;res facultatifs
				'search_signe_astrologique_id' => array(0),
				'search_silhouette_id' => array(0),
				'search_style_coiffure_id' => array(0),
				'search_cheveux_id' => array(0),
				'search_yeux_id' => array(0),
				'search_origine_id' => array(0),
				'search_nationalite_id' => array(0),
				'search_religion_id' => array(0),
				'search_langue_id' => array(0),
				'search_statut_marital_id' => array(0),
				'search_me_marier_id' => array(0),
				'search_cherche_relation_id' => array(0),
				'search_niveau_etude_id' => array(0),
				'search_secteur_activite_id' => array(0),
				'search_fumer_id' => array(0),
				'search_temperament_id' => array(0),
				'search_vouloir_enfants_id' => array(0),
				'search_vie_id' => array(0),
				'search_cuisine_id' => array(0),
				'search_sortie_id' => array(0),
				'search_loisir_id' => array(0),
				'search_sport_id' => array(0),
				'search_musique_id' => array(0),
				'search_film_id' => array(0),
				'search_lecture_id' => array(0),
				'search_animaux_id' => array(0)

			);
		return $_data;
	}


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

		// stock les donn&eacute;es temporaires en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}

	}


	// formulaire de recherche
	function searchForm($showResults, $showForm = true) {
			global $langue,$langString;
			include("lang/app_search.".$_GET['lang'].".php");
		global $db, $user, $results, $messages, $action;

		// variables
		$list 		= array();

		// donn&eacute;es du formulaire de recherche
		$_data	= search_data();


		// r&eacute;cup les donn&eacute;es en session
		if(count($_data)) {
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
					$list['search_genre']	= '<b>'.$lang_search["UneMaman"].'</b>';

				} else { // sinon si c'est une femme

					$row['search_genre'] 	= 'h';
					$list['search_genre']	= '<b>'.$lang_search["UnPapa"].'</b>';

				}

			} else {

				$list['search_genre']	= '<input type="radio" name="search_genre" value="h" id="homme"/> <label for="homme"><b>'.$lang_search["UnHomme"].'</b></label> <input type="radio" name="search_genre" value="f" id="femme"/> <label for="femme"><b>'.$lang_search["UneFemme"].'</b></label> :';

			}

			// nombre d'enfants
			for($i=1; $i<=4; $i++) {
				$list_nb_enfants[] = JL::makeOption($i, $i.' '.$lang_search["OuPlus"].'');
			}
			$list_nb_enfants[] = JL::makeOption(5, 'plus de 4');
			$list['search_nb_enfants'] = JL::makeSelectList( $list_nb_enfants, 'search_nb_enfants', '', 'value', 'text', $row['search_nb_enfants']);


			// recherche &acirc;ge mini
			$list_recherche_age_min[] = JL::makeOption('0', '» '.$lang_search["Age"]);
			for($i=18; $i<=(intval(date('Y'))-1930); $i++) {
				$list_recherche_age_min[] = JL::makeOption($i, $i);
			}
			$list['search_recherche_age_min'] = JL::makeSelectList( $list_recherche_age_min, 'search_recherche_age_min', 'class="select50"', 'value', 'text', $row['search_recherche_age_min']);

			$list_recherche_age_max[] = JL::makeOption('0', '» '.$lang_search["Age"]);
			for($i=18; $i<=(intval(date('Y'))-1930); $i++) {
				$list_recherche_age_max[] = JL::makeOption($i, $i);
			}
			$list['search_recherche_age_max'] = JL::makeSelectList( $list_recherche_age_max, 'search_recherche_age_max', 'class="select50"', 'value', 'text', $row['search_recherche_age_max']);


			// canton
			$list_canton_id[] = JL::makeOption('0', '» '.$lang_search["canton"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_canton$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;

			$list_canton_id = array_merge($list_canton_id, $db->loadObjectList($query));
			$list['search_canton_id'] 	= JL::makeSelectList( $list_canton_id, 'search_canton_id', 'id="search_canton_id" onChange="loadVilles(\'search_\');"', 'value', 'text', $row['search_canton_id']);
			$list['search_ville_id']	= '<input type="hidden" id="search_ville_id" name="search_ville_id" value="'.$row['search_ville_id'].'" />';

			// pseudo
			$list['search_username']	= htmlentities($row['search_username']);

			// titre de la recherche
			$list['search_titre']		= htmlentities($row['search_titre']);

			// en ligne
			$list['search_online']		= $row['search_online'];


		// crit&egrave;res facultatifs

			// signe astrologique
			$list_signe_astrologique_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_signe_astrologique$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_signe_astrologique_id'] = array_merge($list_signe_astrologique_id, $db->loadObjectList($query));

			// silhouette
			$list_silhouette_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_silhouette$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_silhouette_id'] = array_merge($list_silhouette_id, $db->loadObjectList($query));

			// style coiffure
			$list_style_coiffure_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_style_coiffure$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_style_coiffure_id'] = array_merge($list_style_coiffure_id, $db->loadObjectList($query));

			// cheveux
			$list_cheveux_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_cheveux$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_cheveux_id'] = array_merge($list_cheveux_id, $db->loadObjectList($query));

			// yeux
			$list_yeux_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_yeux$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_yeux_id'] = array_merge($list_yeux_id, $db->loadObjectList($query));

			// origine
			$list_origine_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_origine$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_origine_id'] = array_merge($list_origine_id, $db->loadObjectList($query));

			// nationalit&eacute;
			$list_nationalite_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_nationalite$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_nationalite_id'] = array_merge($list_nationalite_id, $db->loadObjectList($query));

			// religion
			$list_religion_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_religion$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_religion_id'] = array_merge($list_religion_id, $db->loadObjectList($query));

			// langues
			$list_langue_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_langue$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_langue_id'] = array_merge($list_langue_id, $db->loadObjectList($query));

			// statut marital
			$list_statut_marital_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_statut_marital$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_statut_marital_id'] = array_merge($list_statut_marital_id, $db->loadObjectList($query));

			// me marier c'est...
			$list_me_marier_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_me_marier$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_me_marier_id'] = array_merge($list_me_marier_id, $db->loadObjectList($query));

			// je cherche une relation
			$list_cherche_relation_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_cherche_relation$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_cherche_relation_id'] = array_merge($list_cherche_relation_id, $db->loadObjectList($query));

			// niveau d'&eacute;tudes
			$list_niveau_etude_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_niveau_etude$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_niveau_etude_id'] = array_merge($list_niveau_etude_id, $db->loadObjectList($query));

			// secteur d'activit&eacute;
			$list_secteur_activite_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_secteur_activite$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_secteur_activite_id'] = array_merge($list_secteur_activite_id, $db->loadObjectList($query));

			// je fume
			$list_fumer_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_fumer$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_fumer_id'] = array_merge($list_fumer_id, $db->loadObjectList($query));

			// temp&eacute;rament
			$list_temperament_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_temperament$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_temperament_id'] = array_merge($list_temperament_id, $db->loadObjectList($query));

			// veut des enfants
			$list_vouloir_enfants_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_vouloir_enfants$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_vouloir_enfants_id'] = array_merge($list_vouloir_enfants_id, $db->loadObjectList($query));

			// style de vie
			$list_vie_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_vie$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_vie_id'] = array_merge($list_vie_id, $db->loadObjectList($query));

			// cuisine
			$list_cuisine_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_cuisine$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_cuisine_id'] = array_merge($list_cuisine_id, $db->loadObjectList($query));

			// sortie
			$list_sortie_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_sortie$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_sortie_id'] = array_merge($list_sortie_id, $db->loadObjectList($query));

			// loisir
			$list_loisir_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_loisir$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_loisir_id'] = array_merge($list_loisir_id, $db->loadObjectList($query));

			// sport
			$list_sport_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_sport$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_sport_id'] = array_merge($list_sport_id, $db->loadObjectList($query));

			// musique
			$list_musique_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_musique$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_musique_id'] = array_merge($list_musique_id, $db->loadObjectList($query));

			// film
			$list_film_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_film$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_film_id'] = array_merge($list_film_id, $db->loadObjectList($query));

			// lecture
			$list_lecture_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_lecture$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_lecture_id'] = array_merge($list_lecture_id, $db->loadObjectList($query));

			// animaux
			$list_animaux_id[] = JL::makeOption('0', $lang_search["PeuImporte"]);
			$query = "SELECT id AS value, nom AS text"
			." FROM profil_animaux$langString"
			." WHERE published = 1"
			." ORDER BY nom ASC"
			;
			$list['search_animaux_id'] = array_merge($list_animaux_id, $db->loadObjectList($query));

		// message
		if($action == 'saved') {
			$messages[] = '<span class="valid">'.$lang_search["SauvegardeDeVotre"].' !</span>';
		}

		// affichage
		/*if($action == 'step8') {

			// *** issu de app_profil ***
			// r&eacute;cup le texte de gauche pendant l'inscription
			$notice = getNotice(8);

			HTML_search::searchStep8($list, $results, $showResults, $showForm, $messages, $notice);
		} else {*/
			HTML_search::search($list, $results, $showResults, $showForm, $messages);
		//}

	}


	// cr&eacute;ation de la clause WHERE d'un crit&egrave;re facultatif
	function SQLwhereCritFac(&$where, &$search, $field, $triple = false) {
			global $langue;
		if(count($search[$field])) {
			if(in_array(0, $search[$field])) {
				JL::setSession($field, array(0));
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
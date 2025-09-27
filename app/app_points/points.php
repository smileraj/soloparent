<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('points.html.php');

	global $action, $user, $langue, $langString;
	if($_GET["lang"]=='fr')
		$langString = "";
	else
		$langString = "_".$_GET["lang"];

	/*
		info: pr&eacute;sentation du syst&egrave;me de points (content)
		reglement: affiche le r&egrave;glement(content)
		cadeaux: liste des lots(content)
		bareme: affiche le bareme
		mespoints: liste le d&eacute;tail des points de l'utilsiateur log
		classement: classement actuel en temps r&eacute;el
		archives: archives des pr&eacute;c&eacute;dents mois
	*/
	switch($action) {

		case 'info':
			pointsContent(34);
		break;

		case 'reglement':
			pointsContent(35);
		break;

		case 'cadeaux':
			pointsContent(36);
		break;

		case 'bareme':
			pointsBareme();
		break;

		case 'mespoints':
			// pas log, redirection page inscription
			if(!$user->id) JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);

			pointsMesPoints();
		break;


		case 'classement':
			// pas log, redirection page inscription
			if(!$user->id) JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);

			pointsClassement();
		break;


		case 'archives':
			// pas log, redirection page inscription
			if(!$user->id) JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);

			pointsArchives();
		break;

		/*
		case 'temoignages':
			pointsTemoignages();
		break;

		case 'temoignage':
			pointsTemoignage(JL::getVar('id', 0));
		break;
		*/
		default:
			JL::loadApp('404');
		break;

	}


	/*// affiche un t&eacute;moignage
	function pointsTemoignage($id) {
			global $langue;
		global $db;

		// r&eacute;cup le dernier t&eacute;moignage en date du syst&egrave;me de points
		$query = "SELECT pg.id, pg.user_id, u.username, up.photo_defaut, pg.temoignage, pg.temoignage_date"
		." FROM points_gagnants AS pg"
		." INNER JOIN user AS u ON u.id = pg.user_id"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." WHERE pg.id = '".$db->escape($id)."'"
		." LIMIT 0,1"
		;
		$temoignage = $db->loadObject($query);

		HTML_points::pointsTemoignage($temoignage);

	}


	// liste les t&eacute;moignages
	function pointsTemoignages() {
			global $langue;
		global $db;

		// r&eacute;cup les derniers t&eacute;moignages (todo + tard: pagination)
		$query = "SELECT pg.id, pg.user_id, u.username, up.photo_defaut, pg.temoignage"
		." FROM points_gagnants AS pg"
		." INNER JOIN user AS u ON u.id = pg.user_id"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." WHERE pg.temoignage != ''"
		." ORDER BY pg.temoignage_date DESC"
		;
		$temoignages = $db->loadObjectList($query);

		HTML_points::pointsTemoignages($temoignages);

	}*/


	// bar&egrave;me du syst&egrave;me de points
	function pointsBareme() {
			global $langue,$langString;
		global $db;

		// r&eacute;cup le bareme, ordre par nombre de points DESC
		$query = "SELECT nom_".$_GET['lang']." as nom, points"
		." FROM points"
		." WHERE points > 0"
		." ORDER BY nom ASC"
		;
		$rows = $db->loadObjectList($query);
		
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte"
		."  FROM contenu"
		." WHERE id = 112";
		$data = $db -> loadObject($query);

		HTML_points::pointsBareme($data, $rows);

	}


	// points gagn&eacute;s par l'utilisateur log
	function pointsMesPoints() {
			global $langue,$langString;
		global $db, $user;

		// variables
		$resultatParPage 	= 20;
		$where 				= array();
		$search 			= array();
		$_where				= '';


		// pagination
		$search['page']		= (int)JL::getVar('page', 1);
		if($search['page'] <= 0) JL::redirect(SITE_URL.'/index.php?app=points&action=mespoints'.'&'.$langue);


		// WHERE
		$where[]			= "pu.user_id = '".$db->escape($user->id)."'";

		if (is_array($where)) {
			$_where = " WHERE ".implode(" AND ", $where);
		}


		// r&eacute;cup le total
		$query = "SELECT COUNT(*)"
		." FROM points_user AS pu"
		." INNER JOIN points AS p ON p.id = pu.points_id"
		.$_where
		;
		$search['result_total']	= (int)$db->loadResult($query);
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);


		// r&eacute;cup les messages de l'utilisateur log
		$query = "SELECT p.id, p.nom_".$_GET['lang']." as nom, p.points, pu.data, pu.datetime"
		." FROM points_user AS pu"
		." INNER JOIN points AS p ON p.id = pu.points_id"
		.$_where
		." ORDER BY pu.datetime DESC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$rows = $db->loadObjectList($query);

		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte"
		." FROM contenu".
		" WHERE id = 113";
		$data = $db->loadObject($query);

		// affiche la liste des appels
		HTML_points::pointsMesPoints($data, $rows, $search);

	}


	// page d'info
	function pointsContent($id) {
		global $langue, $langString;
		global $db;
//die($langString);
		// r&eacute;cup l'article
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte"
		." FROM contenu".
		" WHERE id = '".$db->escape($id)."' LIMIT 0,1";
		$row = $db->loadObject($query);

		// affichage
		HTML_points::pointsContent($row);

	}


	// affichage du classement
	function pointsClassement() {
			global $langue,$langString;
		global $db;

		// variables locales
		$where 				= array();
		$_where				= '';


		// exclue les profils helvetica media, les inactifs et suspendus
		$where[]	= 'up.helvetica = 0';
		$where[]	= 'u.confirmed = 1';
		$where[]	= 'u.published = 1';

		if (is_array($where)) {
			$_where = " WHERE ".implode(" AND ", $where);
		}


		// r&eacute;cup les 20 premiers du classement actuel
		$query = "SELECT u.id, u.username, up.genre, us.points_total AS total, u.creation_date, us.last_rank, us.last_rank_date, TO_DAYS(NOW())-TO_DAYS(us.last_rank_date) AS last_rank_days"
		." FROM user_stats AS us"
		." INNER JOIN user AS u ON u.id = us.user_id"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		.$_where
		." ORDER BY us.points_total DESC, u.creation_date ASC"
		." LIMIT 0,20"
		;
		$rows = $db->loadObjectList($query);

		// pour chaque membre class&eacute;
		$count = count($rows);
		for($i=0; $i<$count; $i++) {

			// conserve le nouveau rang
			$rows[$i]->new_rank = $i+1;

			// classement pr&eacute;c&eacute;dent date de 2 jours, on met &agrave; jour avec le nouveau
			if($rows[$i]->last_rank_days >= 2) {

				// classement trop ancien, membre &eacute;ject&eacute; du classement et revient en top 20
				if($rows[$i]->last_rank_days > 2) {

					// r&eacute;initialise son rang pr&eacute;c&eacute;dent
					$rows[$i]->last_rank = 0;
					$last_rank = 0;

				} else {

					$last_rank = $i+1;

				}

				$query = "UPDATE user_stats SET"
				." last_rank_date = DATE_SUB(NOW(), INTERVAL 1 DAY),"
				." last_rank = '".$db->escape($last_rank)."'"
				." WHERE user_id = '".$db->escape($rows[$i]->id)."'"
				;
				$db->query($query);

			}

		}
		
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte"
		." FROM contenu".
		" WHERE id = 114";
		$data = $db->loadObject($query);

		// affichage du classement
		HTML_points::pointsClassement($data, $rows);

	}


	// affichage du classement
	function pointsArchives() {
			global $langue,$langString;
		global $db;

		// r&eacute;cup les 3 derniers classements, soit 3*10 membres
		$query = "SELECT u.id, u.username, up.genre, pc.points AS total, pc.annee_mois"
		." FROM points_classements AS pc"
		." INNER JOIN user AS u ON u.id = pc.user_id"
		." INNER JOIN user_profil up ON u.id = up.user_id"
		." WHERE pc.annee_mois NOT LIKE '%2009-%' AND pc.annee_mois NOT LIKE '%2010-0%'"
		." ORDER BY pc.annee_mois DESC, pc.points DESC, pc.id ASC"
		." LIMIT 0,30"
		;
		$rows = $db->loadObjectList($query);
		
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte"
		." FROM contenu".
		" WHERE id = 115";
		$data = $db->loadObject($query);
		
		// affichage du classement
		HTML_points::pointsArchives($data, $rows);

	}

?>

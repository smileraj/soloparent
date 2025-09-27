<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('groupe.html.php');
	include("lang/app_groupe.".$_GET['lang'].".php");
	
	global $action, $user, $langue, $langString;	
	
	$groupe = new stdClass();
	if(!$user->id) {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription&'.$langue);
	}
	
		
	if($_GET['lang']=='fr'){
		$langString = '';
	}else{
		$langString = "_".$_GET['lang'];
	}


	


	// gestion des messages d'erreurs
	$messages		= array();

	// types de groupes: tous, que ceux rejoinds par l'utilisateur, que ceux cr&eacute;&eacute;s par l'utilisateur
	$groupe_type	= JL::getVar('groupe_type', JL::getSession('groupe_type', 'all'));


	// type inccorect
	if(!in_array($groupe_type, array('all', 'joined', 'created'))) {
		JL::redirect(SITE_URL.'/index.php?app=groupe&action=list'.'&'.$langue);
	}

	// conserve le type de groupe en session pour l'utiliser + loin
	JL::setSession('groupe_type', $groupe_type);

	switch($action) {

		case 'list':

			// user non log
			if(!$user->id && $groupe_type != 'all') {
				JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
			}

			groupeList($groupe_type);
		break;


		case 'join':

			// user non log
			if(!$user->id) {
				JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
			}

			if(groupeJoin((int)JL::getVar('id', 0))) {
				JL::redirect(SITE_URL.'/index.php?app=groupe&action=list&groupe_type=joined&msg=join'.'&'.$langue);
			} else {
				JL::redirect(SITE_URL.'/index.php?app=groupe&action=list&groupe_type=joined&msg=notexistj'.'&'.$langue);
			}
		break;


		case 'quit':

			// user non log
			if(!$user->id) {
				JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
			}

			if(groupeQuit((int)JL::getVar('id', 0))) {
				JL::redirect(SITE_URL.'/index.php?app=groupe&action=list&groupe_type=joined&msg=quit'.'&'.$langue);
			} else {
				JL::redirect(SITE_URL.'/index.php?app=groupe&action=list&groupe_type=joined&msg=notexistq'.'&'.$langue);
			}
		break;


		case 'edit':

			// user non log
			if(!$user->id) {
				JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
			}

			// abonn&eacute; uniquement
			//JL::loadMod('abonnement_check');

			groupeEdit($messages);
		break;


		case 'info':
			groupeInfo();
		break;


		case 'save':

			// user non log
			if(!$user->id) {
				JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
			}

			// abonn&eacute; uniquement
			//JL::loadMod('abonnement_check');

			$messages =& groupeSave();
			if(!count($messages)) {
				JL::redirect(SITE_URL.'/index.php?app=groupe&action=list&groupe_type=created&msg=ok'.'&'.$langue);
			} else {
				groupeEdit($messages);
			}
		break;


		case 'details':

			// user non log
			if(!$user->id) {
				JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
			}

			groupeFiche((int)JL::getVar('id', 0));
		break;


		default:
			JL::loadApp('404');
		break;

	}


	// user log rejoind le $groupe_id
	function groupeJoin($groupe_id) {
			global $langue;
		global $db, $user;

		// v&eacute;rifie que le groupe existe
		$query = "SELECT id FROM groupe WHERE id = '".$db->escape($groupe_id)."' AND (active > 0 OR user_id = '".(int)$user->id."') LIMIT 0,1";
		$id = $db->loadResult($query);

		if($id > 0) {

			// check si l'utilisateur est d&eacute;j&agrave; inscrit
			$query = "SELECT user_id FROM groupe_user WHERE groupe_id = '".$db->escape($groupe_id)."' AND user_id = '".(int)$user->id."' LIMIT 0,1";
			$dejaInscrit = $db->loadResult($query);

			// si l'utilisateur n'est pas d&eacute;j&agrave; inscrit (s'il l'est, on n'enregistre rien, mais pas besoin de g&eacute;n&eacute;rer un message d'erreur)
			if(!$dejaInscrit) {

				// enregistre l'inscription
				$query = "INSERT INTO groupe_user SET"
				." groupe_id = '".(int)$id."',"
				." user_id = '".(int)$user->id."',"
				." date_join = NOW()"
				;
				$db->query($query);

				// mise &agrave; jour des stats du groupe
				$query = "UPDATE groupe SET stats_membres = stats_membres + 1 WHERE id = '".(int)$id."'";
				$db->query($query);

			}

			return true;

		} else {

			return false;

		}

	}


	// user log quitte le $groupe_id
	function groupeQuit($groupe_id) {
		global $langue;
		global $db, $user;

		// v&eacute;rifie que le groupe existe
		$query = "SELECT id FROM groupe WHERE id = '".$db->escape($groupe_id)."' LIMIT 0,1";
		$id = $db->loadResult($query);

		if($id > 0) {

			// supprime l'inscription
			$query = "DELETE FROM groupe_user WHERE groupe_id = '".(int)$id."' AND user_id = '".(int)$user->id."'";
			$db->query($query);

			// mise &agrave; jour des stats du groupe
			$query = "UPDATE groupe SET stats_membres = stats_membres - 1 WHERE stats_membres > 0 AND id = '".(int)$id."'";
			$db->query($query);

			return true;

		} else {

			return false;

		}

	}


	function groupeInfo() {
		global $langue, $langString;
		global $db;
		
				
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 103";
		$data = $db -> loadObject($query);
		// todo: cr&eacute;er un article et le charger depuis la fonction

		HTML_groupe::information($data);

	}


	function groupeList($groupe_type) {
		global $langue;
		include("lang/app_groupe.".$_GET['lang'].".php");
		global $db, $user, $messages;

		// formule magique: calcule de la popularit&eacute; d'un groupe
		$populariteFormule	= groupePopulariteFormule();


		// variables
		$resultatParPage	= 10;
		$fieldTitre			= 'g.titre';
		$fieldTexte			= 'g.texte';
		$_where				= '';
		$_orderBy			= '';
		$where 				= array();
		$search				= array();
		$order_by_option	= array();

		// params
		$order_by_array		= array(1,2,3,4,5);
		$order_by			= (int)JL::getVar('order_by', JL::getSession('order_by', 1));
		JL::setSession('order_by', $order_by);

		if(!in_array($order_by, $order_by_array)) {
			$order_by 		= 1;
		}

		// liste d&eacute;roulante des order by
		$order_by_option[] = JL::makeOption(1, $lang_groupe["Nouveaute"]);
		$order_by_option[] = JL::makeOption(2, $lang_groupe["Anciennete"]);
		$order_by_option[] = JL::makeOption(3, $lang_groupe["OrdreAlphabetique"]);
		$order_by_option[] = JL::makeOption(4, $lang_groupe["NombreMembres"]);
		$order_by_option[] = JL::makeOption(5, $lang_groupe["Popularite"]);

		$search['order_by']	= JL::makeSelectList($order_by_option, 'order_by', 'class="input_groupe"', 'value', 'text', $order_by);


		// recherche
		$search['groupe']	= JL::getVar('search_groupe', '');

		if($search['groupe'] != '') {
			$where[]		= "(g.titre LIKE '%".$db->escape($search['groupe'])."%' OR g.texte LIKE '%".$db->escape($search['groupe'])."%')";
		}


		// pagination
		$search['page']		= (int)JL::getVar('page', 1);
		if($search['page'] <= 0) JL::redirect(SITE_URL.'/index.php?app=groupe&action=list'.'&'.$langue);


		// adapte le WHERE et autres variables en fonction du type de groupe
		switch($groupe_type) {

			case 'joined': // groupes rejoints par l'utilisateur
				$where[]		= "((g.active > 0 AND g.titre != '') OR g.user_id = '".(int)$user->id."')";
				$where[]		= "gu.user_id = '".(int)$user->id."'";
				$where[]		= "g.titre != ''";
				$where[]		= "g.user_id IN (SELECT id FROM user WHERE confirmed >0)";
				$where[]		= "g.user_id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)";
				$where[]		= "g.user_id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)";
			break;

			case 'created': // groupes cr&eacute;&eacute;s par l'utilisateur
				$where[]		= "g.user_id = '".(int)$user->id."'";
				$fieldTitre		= "IF(g.titre_a_valider != '', g.titre_a_valider, g.titre) AS titre";
				$fieldTexte		= "IF(g.texte_a_valider != '', g.texte_a_valider, g.texte) AS texte";
			break;

			default: // tous les groupes
				$where[]		= "g.active > 0";
				$where[]		= "g.titre != ''";
				$where[]		= "g.user_id IN (SELECT id FROM user WHERE confirmed >0)";
				$where[]		= "g.user_id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)";
				$where[]		= "g.user_id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)";
			break;

		}

		if (is_array($where)) {
			$_where = " WHERE ".implode(" AND ", $where);
		}

		switch($order_by) {

			case 1: // Nouveaut&eacute;
				$_orderBy = "g.date_add DESC";
			break;

			case 2: // Anciennet&eacute;
				$_orderBy = "g.date_add ASC";
			break;

			case 3: // Ordre alphab&eacute;tique
				$_orderBy = "g.titre ASC";
			break;

			case 4: // Nombre de membres
				$_orderBy = "g.stats_membres DESC";
			break;

			case 5: // Popularit&eacute;
				$_orderBy	= '`popularite` DESC';
			break;

		}

		// r&eacute;cup le score de popularit&eacute; max (on n'utilise pas le $_where car on calcule le score g&eacute;n&eacute;ral, pour tous les groupes valides, et non pour la recherche uniquement)
		$query = "SELECT MAX(CEIL(".$populariteFormule.")) AS valeur"
		." FROM groupe AS g"
		." WHERE g.active > 0 AND g.titre != ''"
		;
		$populariteMax	= $db->loadResult($query);
		

		// r&eacute;cup le total
		$query = "SELECT COUNT(*)"
		." FROM groupe AS g"
		." LEFT JOIN groupe_user AS gu ON gu.groupe_id = g.id AND gu.user_id = '".(int)$user->id."'"
		.$_where
		;
		$search['result_total']		= (int)$db->loadResult($query);
		$search['page_total'] 		= ceil($search['result_total'] / $resultatParPage);
		$search['results_start']	= ($search['page'] - 1) * $resultatParPage;


		// r&eacute;cup la liste des groupes
		$query = "SELECT g.id, ".$fieldTitre.", ".$fieldTexte.", g.active, g.date_add, g.stats_membres, g.stats_soutiens, g.user_id, IFNULL(gu.user_id, 0) AS membre, CEIL(CEIL(".$populariteFormule.")*100.0/".strval($populariteMax).") AS popularite"
		." FROM groupe AS g"
		." LEFT JOIN groupe_user AS gu ON gu.groupe_id = g.id AND gu.user_id = '".(int)$user->id."'"
		.$_where
		." ORDER BY ".$_orderBy
		." LIMIT ".$search['results_start'].", ".$resultatParPage
		;
		$rows = $db->loadObjectList($query);


		// cr&eacute;dit de points pour les seuils de popularit&eacute; atteints pour la premi&egrave;re fois
		if(is_array($rows)) {
			foreach($rows as $row) {

				if($row->popularite < 50) { // 2 ic&ocirc;nes
					JL::addPoints(14, $row->user_id, $row->id);
				} elseif($row->popularite < 75) { // 3 ic&ocirc;nes
					JL::addPoints(15, $row->user_id, $row->id);
				} elseif($row->popularite < 100) { // 4 ic&ocirc;nes
					JL::addPoints(16, $row->user_id, $row->id);
				} elseif($row->popularite == 100) { // 5 ic&ocirc;nes
					JL::addPoints(17, $row->user_id, $row->id);
				}
				
				$query = "SELECT COUNT(*)"
				." FROM user AS u"
				." INNER JOIN groupe_user AS gu ON gu.user_id = u.id"
				." INNER JOIN user_profil AS up ON up.user_id = u.id"
				." WHERE gu.groupe_id = '".$db->escape($row->id)."'"
				." AND u.confirmed > 0"
				." AND u.published = 1"
				." AND u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)"
				." AND u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from =".$user->id."  AND list_type=0)"
				;
				$row->total_membres = $db->loadResult($query);

			}
		}

		// param message
		$msg = JL::getVar('msg', '');
		if($msg == 'join') { // groupe rejoint

			$messages[]	= '<span class="valid">'.$lang_groupe["RejoindreGroupeReussi"].' !</span>';

		} elseif($msg == 'quit') { // groupe quitt&eacute;

			$messages[]	= '<span class="valid">'.$lang_groupe["QuitterGroupeReussi"].' !</span>';

		} elseif($msg == 'ok') { // groupe enregistr&eacute;

			$messages[]	= '<span class="valid">'.$lang_groupe["GroupeEnregistre"].'!<br />'.$lang_groupe["GroupesSoumisAValidation"].'.<br />'.$lang_groupe["AffichageGroupeDansListe"].' !</span>';

		} elseif($msg == 'noedit') { // pas le droit de modifier

			$messages[]	= '<span class="error">'.$lang_groupe["NonFondateurGroupe"].' !</span>';

		} elseif($msg == 'locked') { // groupe verouill&eacute;

			$messages[]	= '<span class="error">'.$lang_groupe["GroupeVerouille"].'.</span>';

		} elseif($msg == 'notexistj') { // rejoindre groupe pas possible

			$messages[]	= '<span class="error">'.$lang_groupe["RejoindreGroupeInexistant"].' !</span>';

		} elseif($msg == 'notexistq') { // quitter groupe pas possible

			$messages[]	= '<span class="error">'.$lang_groupe["QuitterGroupeInexistant"].' !</span>';

		} elseif($msg == 'notexist') { // groupe n'existe pas

			$messages[]	= '<span class="error">'.$lang_groupe["GroupeInexistant"].' !</span>';

		}


		// affiche la liste des groupes
		HTML_groupe::groupeList($rows, $search, $messages);

	}


	// edition d'un groupe
	function groupeEdit(&$messages) {
			global $langue;
			include("lang/app_groupe.".$_GET['lang'].".php");
		global $db, $user;

		// variables
		$editAllowed 	= true;
		$_where			= '';
		$where 			= array();

		// r&eacute;cup les donn&eacute;es du formulaire
		$row	= new stdClass();
		$_data 	=& groupe_data();

		foreach($_data as $k => $v) {
			$row->{$k}		= JL::getVar($k, $v);
		}


		// WHERE
		$where[]	= "g.id = '".(int)$row->id."'";
		$where[]	= "g.user_id = '".(int)$user->id."'";

		if (is_array($where)) {
			$_where = " WHERE ".implode(" AND ", $where);
		}


		// si l'id est renseign&eacute; (edit)
		if($row->id) {

			// r&eacute;cup le groupe
			$query = "SELECT g.id, g.titre, IF(g.titre_a_valider != '', g.titre_a_valider, g.titre) AS titre_a_valider, g.texte, IF(g.texte_a_valider != '', g.texte_a_valider, g.texte) AS texte_a_valider, g.active, g.date_add, g.motif"
			." FROM groupe AS g"
			.$_where
			." LIMIT 0,1"
			;
			$rowTemp = $db->loadObject($query);

			if(!$rowTemp->id) {

				// redirection sur page d'erreur d'ajout
				JL::redirect(SITE_URL.'/index.php?app=groupe&action=list&msg=noedit'.'&'.$langue);

			} elseif($rowTemp->active == 3) { // groupe non verouill&eacute;

				// redirection sur page d'erreur d'ajout
				JL::redirect(SITE_URL.'/index.php?app=groupe&action=list&msg=locked'.'&'.$langue);

			}

			// si l'on ne provient pas d'une tentative de sauvegarde avec erreur(s)
			if(!count($messages)) {
				$row->id 	= $rowTemp->id;
				$row->titre = $rowTemp->titre;
				$row->texte = $rowTemp->texte;
				$row->titre_a_valider = $rowTemp->titre_a_valider;
				$row->texte_a_valider = $rowTemp->texte_a_valider;
			}
			$row->motif = $rowTemp->motif;
			$row->active 	= $rowTemp->active;
			$row->date_add 	= $rowTemp->date_add;


		}
		$groupe->captcha		= rand(10,99).chr(rand(65,90)).rand(10,99).chr(rand(65,90));
			$groupe->captchaAbo		= md5(date('m/Y').$groupe->captcha);

		// affiche le formulaire d'edition
		HTML_groupe::groupeEdit($row, $messages,$groupe);

	}

	function &groupe_data() {
		global $langue,$groupe;
		$_data	= array(
			'id'		=> 0,
			'titre' 	=> '',
			'texte' 	=> '',
			'phototemp'	=> '',
		);
		return $_data;
		
	}


	// ajoute un utilisateur &agrave; la fl/bl de l'utilisateur log
	function &groupeSave() {
			global $langue;
			include("lang/app_groupe.".$_GET['lang'].".php");
		global $db, $user;
		// variables
		$_where			= '';

		// gestion des messages d'erreurs
		$messages		= array();

		// r&eacute;cup les donn&eacute;es du formulaire
		$_data 	=& groupe_data();
		$row	= new stdClass();
		foreach($_data as $k => $v) {
			$row->{$k}	= JL::getVar($k, $v);
		}
 $groupe->captchaAbo			= JL::getVar('captchaAbo', '');
	 $groupe->verif					= trim(JL::getVar('verif', ''));

		// check que le groupe appartient bien &agrave; l'utilisateur log
		if($row->id) {
			$query 	= "SELECT id, active FROM groupe WHERE id = '".$db->escape($row->id)."' AND user_id = '".(int)$user->id."' LIMIT 0,1";
			$groupe	= $db->loadObject($query);

			if(!$groupe->id) {

				$messages[]	= '<span class="error">'.$lang_groupe["NonFondateurGroupe"].' !</span>';

			} elseif($groupe->active == 3) { // groupe verrouill&eacute;

				$messages[]	= '<span class="error">'.$lang_groupe["GroupeVerouille"].'.</span>';

			}

		}


		// pas de titre
		if(!$row->titre) {

			$messages[]	= '<span class="error">'.$lang_groupe["IndiquezTitre"].'</span>';

		} elseif(!$row->id) {

			// v&eacute;rifie si un groupe du m&ecirc;me titre existe d&eacute;j&agrave;
			$query = "SELECT id FROM groupe WHERE titre LIKE '".$row->titre."' LIMIT 0,1";
			$existe	= $db->loadResult($query);

			if($existe) {
				$messages[]	= '<span class="error">'.$lang_groupe["TitreExistant"].' !</span>';
			}

		}

		// pas de texte
		if(!$row->texte) {
			$messages[]	= '<span class="error">'.$lang_groupe["IndiquezDescription"].'</span>';
		}
         if($groupe->verif == '' || md5(date('m/Y').strtoupper($groupe->verif)) != $groupe->captchaAbo) {
				$messages[] = '<span class="error">'.$lang_groupe["WarningCodeVerifIncorrect"].'</span>';
			}

		// si tout est ok
		if(!count($messages)) {


			// mise &agrave; jour
			if($row->id) {

				$query 	= "UPDATE groupe SET";
				$_where	= " WHERE id = '".$row->id."'";

			} else { // insertion

				$query 	= "INSERT INTO groupe SET"
				." date_add = NOW(),"
				." stats_membres = 1,"
				;

			}

			// reset le statut du groupe, en le d&eacute;finissant comme "&agrave; valider"
			$query .= " active = 2,"
			." titre_a_valider = '".$db->escape($row->titre)."',"
			." texte_a_valider = '".$db->escape($row->texte)."',"
			." user_id = '".(int)$user->id."'"
			.$_where
			;

			// ex&eacute;cute la requ&ecirc;te
			$db->query($query);

			if(!$row->id) {

				// r&eacute;cup l'id g&eacute;n&eacute;r&eacute;
				$row->id	= $db->insert_id();

				// le cr&eacute;ateur du groupe rejoind automatiquement son propre groupe
				$query = "INSERT INTO groupe_user SET"
				." groupe_id = '".$row->id."',"
				." user_id = '".(int)$user->id."'"
				;
				$db->query($query);
				
				// manipule la photo
				if($row->phototemp != '') {
					copy(SITE_PATH.'/'.$row->phototemp, SITE_PATH.'/images/groupe/pending/'.$row->id.'.jpg');
					copy(SITE_PATH.'/'.str_replace('.jpg', '-mini.jpg', $row->phototemp), SITE_PATH.'/images/groupe/pending/'.$row->id.'-mini.jpg');
					@unlink(SITE_PATH.'/'.$row->phototemp);
					@unlink(SITE_PATH.'/'.str_replace('.jpg', '-mini.jpg', $row->phototemp));
					chmod(SITE_PATH.'/images/groupe/pending/'.$row->id.'.jpg', 0777);
					chmod(SITE_PATH.'/images/groupe/pending/'.$row->id.'-mini.jpg', 0777);
				}
				
			}

		}

		return $messages;

	}


	// fiche d&eacute;taill&eacute;es d'un groupe
	function groupeFiche($id) {
			global $langue;
		global $db, $user;

		// variables
		$resultatParPage	= 8;
		$genres				= array('h','f');
		$search				= array();


		// formule de popularit&eacute;
		$populariteFormule 	= groupePopulariteFormule();

		// r&eacute;cup le score de popularit&eacute; max (on n'utilise pas le $_where car on calcule le score g&eacute;n&eacute;ral, pour tous les groupes valides, et non pour la recherche uniquement)
		$query = "SELECT MAX(CEIL(".$populariteFormule.")) AS valeur"
		." FROM groupe AS g"
		." WHERE g.active > 0 AND g.titre != ''"
		;
		$populariteMax	= $db->loadResult($query);


		// r&eacute;cup le groupe
		$query = "SELECT g.id, g.titre, g.texte, g.stats_membres, g.date_add, g.user_id, u.username AS fondateur, up.genre AS genre_fondateur, IFNULL(gu.user_id, 0) AS membre, CEIL(CEIL(".$populariteFormule.")*100.0/".strval($populariteMax).") AS popularite"
		." FROM groupe AS g"
		." INNER JOIN user AS u ON u.id = g.user_id"
		." LEFT JOIN user_profil AS up ON u.id = up.user_id"
		." LEFT JOIN groupe_user AS gu ON gu.groupe_id = g.id AND gu.user_id = '".(int)$user->id."'"
		." WHERE g.id = '".$db->escape($id)."' AND g.active > 0 AND g.titre != ''"
		." AND g.user_id IN (SELECT id FROM user WHERE confirmed >0)"
		." AND u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)"
		." AND u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from =".$user->id."  AND list_type=0)"
		." LIMIT 0,1"
		;
		$row = $db->loadObject($query);

		// groupe introuvable
		if(!$row) {
			JL::redirect(SITE_URL.'/index.php?app=groupe&action=list&groupe_type=all&msg=notexist'.'&'.$langue);
		}


		// page 1 uniquement
		if(JL::getVar('page_h', 1) == 1 && JL::getVar('page_f', 1) == 1) {

			// mise &agrave; jour des stats de visites du groupe
			$query = "UPDATE groupe SET stats_visites = stats_visites + 1 WHERE id = '".$db->escape($id)."' AND active > 0";
			$db->query($query);

		}


		// pour chaque genre
		foreach($genres as $genre) {

			// params
			$search['page_'.$genre]	= JL::getVar('page_'.$genre, 1);

			// d&eacute;finit le WHERE
			$_where = " WHERE gu.groupe_id = '".$db->escape($row->id)."'"
			." AND up.genre = '".$db->escape($genre)."'"
			." AND u.confirmed > 0"
			." AND u.published = 1"
			." AND u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)"
			." AND u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from =".$user->id."  AND list_type=0)"
			;


			// compte le nombre de r&eacute;sultats
			$query = "SELECT COUNT(*)"
			." FROM user AS u"
			." INNER JOIN groupe_user AS gu ON gu.user_id = u.id"
			." INNER JOIN user_profil AS up ON up.user_id = u.id"
			.$_where
			;
			$search['result_total_'.$genre]		= (int)$db->loadResult($query);
			$search['page_total_'.$genre] 		= ceil($search['result_total_'.$genre] / $resultatParPage);


			// recherche des donn&eacute;es
			$query = "SELECT u.id, u.username, up.photo_defaut, up.nb_enfants, up.genre, CURRENT_DATE, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, pc.abreviation AS canton_abrev, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, u.online"
			." FROM user AS u"
			." INNER JOIN groupe_user AS gu ON gu.user_id = u.id"
			." INNER JOIN user_profil AS up ON up.user_id = u.id"
			." INNER JOIN profil_canton AS pc ON pc.id = up.canton_id"
			.$_where
			.' ORDER BY gu.date_join DESC'
			.' LIMIT '.(($search['page_'.$genre] - 1) * $resultatParPage).', '.$resultatParPage
			;
			$membres[$genre] = $db->loadObjectList($query);

		}


		// affichage
		HTML_groupe::groupeFiche($row, $membres, $search);

	}


	// formule magique: calcule de la popularit&eacute; d'un groupe
	function groupePopulariteFormule() {
		return "((g.stats_membres + g.stats_soutiens) * (g.stats_membres + g.stats_soutiens) + g.stats_visites) / ((UNIX_TIMESTAMP()-UNIX_TIMESTAMP(g.date_add))/86400 + 1)";
	}

?>

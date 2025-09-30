<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('points.html.php');
	
	global $action;
	
	
	// variables
	$messages = [];

	switch($action) {
		
		// point: éditer
		case 'baremeedit':
			$id = (int)JL::getVar('id',0);
			if($id > 0) {
			
				baremeEdit($id);
				
			} else { // si pas d'id, on retourne à la liste
				JL::redirect(SITE_URL_ADMIN.'/index.php?app=points&action=bareme');
			}
		break;
		
		
		// point: save
		case 'baremesave':
			$id = (int)JL::getVar('id',0);
			if($id > 0) {
			
				$messages = baremeSave();
				baremeEdit($id);
				
			} else { // si pas d'id, on retourne à la liste
				JL::redirect(SITE_URL_ADMIN.'/index.php?app=points&action=bareme');
			}
		break;
		
		
		// points: lister
		case 'bareme':
			baremeList();
		break;
		
		
		// classements par mois
		case 'classement':
			classementList();
		break;
		
		
		// gagnant: éditer
		case 'gagnantedit':
			$id = (int)JL::getVar('id',0);
			if($id > 0) {
			
				gagnantEdit($id);
				
			} else { // si pas d'id, on retourne à la liste
				JL::redirect(SITE_URL_ADMIN.'/index.php?app=points&action=gagnant');
			}
		break;
		
		// gagnant: save
		case 'gagnantsave':
			$id = (int)JL::getVar('id',0);
			if($id > 0) {
			
				$messages = gagnantSave();
				gagnantEdit($id);
				
			} else { // si pas d'id, on retourne à la liste
				JL::redirect(SITE_URL_ADMIN.'/index.php?app=points&action=gagnant');
			}
		break;
		
		// gagnants: liste
		case 'gagnant':
		default:
			gagnantList();
		break;
		
	}
	
	
	// données du barème
	function &baremeGetData() {
	
		$data = new StdClass();
		
		// params
		$data->id 					= JL::getVar('id', 0);
		$data->description		= JL::getVar('description', '');
		$data->nom_fr			= JL::getVar('nom_fr', '');
		$data->nom_en			= JL::getVar('nom_en', '');
		$data->nom_de			= JL::getVar('nom_de', '');
		$data->points 			= (int)JL::getVar('points', '');
		$data->nb_max_par_data 	= (int)JL::getVar('nb_max_par_data', 0);
		
		return $data;
	
	}
	
	
	// édite un point du barème
	function baremeEdit($id) {
		global $db, $messages;
		
		// récup les données par défaut
		$data 		=& baremeGetData();
	
		// récup les données
		$query = "SELECT id, description, nom_fr, nom_de, nom_en, points, nb_max_par_data"
		." FROM points"
		." WHERE id = '".$db->escape($data->id)."'"
		." LIMIT 0,1"
		;
		$row = $db->loadObject($query);
		
		
		// variables par défaut
		foreach($data as $k => $v) {
			$row->{$k} = $v ?: $row->{$k};
		}
		
		// affichage
		(new HTML_points())->baremeEdit($row, $messages);
	
	}
	
	
	// sauvegarde les données dans la DB
	function baremeSave() {
		global $db, $messages;
		
		// récup les données
		$row 		=& baremeGetData();
		

		// vérifications des champs
		if(!$row->description) {
			$messages[]	= '<span class="error">Veuillez indiquer la description du bar&egrave;me s\'il vous pla&icirc;t.</span>';
		}
		if(!$row->nom_fr) {
			$messages[]	= '<span class="error">Veuillez indiquer la traduction fran&ccedil;aise du bar&egrave;me s\'il vous pla&icirc;t.</span>';
		}
		if(!$row->nom_en) {
			$messages[]	= '<span class="error">Veuillez indiquer la traduction anglaise du bar&egrave;me s\'il vous pla&icirc;t.</span>';
		}
		if(!$row->nom_de) {
			$messages[]	= '<span class="error">Veuillez indiquer la traduction allemande du bar&egrave;me s\'il vous pla&icirc;t.</span>';
		}
		
		if(!$row->points && $row->points!=0) {
			$messages[]	= '<span class="error">Veuillez indiquer le nombre de points &agrave; gagner s\'il vous pla&icirc;t.</span>';
		}
		
		
		// s'il n'y a pas d'erreur
		if(!count($messages)) {
		
			// mise à jour dans la DB
			$query = "UPDATE points SET"
			." description = '".$db->escape($row->description)."',"
			." nom_fr = '".$db->escape($row->nom_fr)."',"
			." nom_de = '".$db->escape($row->nom_de)."',"
			." nom_en = '".$db->escape($row->nom_en)."',"
			." points = '".$db->escape($row->points)."',"
			." nb_max_par_data = '".$db->escape($row->nb_max_par_data)."'"
			." WHERE id = '".$db->escape($row->id)."'"
			;
			$db->query($query);
			
			
			// mesage de confirmation
			$messages[]	= '<span class="valid">Modifications enregistr&eacute;es.</span>';
		
		}
		
		return $messages;
		
	}
	
	
	// liste les points du barème
	function baremeList() {
		global $db, $messages;
		
		// recherche des données
		$query = "SELECT id, description, points, nb_max_par_data"
		." FROM points"
		." ORDER BY description ASC"
		;
		$rows = $db->loadObjectList($query);
		
		
		(new HTML_points())->baremeList($rows, $messages);
		
	}
	
	

	// données du gagnant
	function &gagnantGetData() {
	
		$data = new StdClass();
		
		// params
		$data->id 				= JL::getVar('id', 0);
		$data->nom 				= JL::getVar('nom', '');
		$data->prenom 			= JL::getVar('prenom', '');
		$data->adresse 			= JL::getVar('adresse', '');
		$data->code_postal 		= JL::getVar('code_postal', '');
		$data->ville 			= JL::getVar('ville', '');
		$data->commentaire 		= JL::getVar('commentaire', '');
		$data->traite 			= (int)JL::getVar('traite', 0);
		$data->temoignage 		= JL::getVar('temoignage', '');
		$data->temoignage_date 	= JL::getVar('temoignage_date', '');
		
		return $data;
		
	}
	
	
	// édite un point du gagnant
	function gagnantEdit($id) {
		global $db, $messages;
		
		// récup les données par défaut
		$data 		=& gagnantGetData();
	
		// récup les données
		$query = "SELECT pg.id, pg.nom, pg.prenom, pg.adresse, pg.code_postal, pg.ville, pg.commentaire, pg.traite, pg.temoignage, pg.temoignage_date, pg.position, pg.user_id, pg.annee_mois, u.username"
		." FROM points_gagnants AS pg"
		." INNER JOIN user AS u ON u.id = pg.user_id"
		." WHERE pg.id = '".$db->escape($data->id)."'"
		." LIMIT 0,1"
		;
		$row = $db->loadObject($query);
		
		
		// variables par défaut
		foreach($data as $k => $v) {
			$row->{$k} = $v ?: $row->{$k};
		}
		
		// affichage
		(new HTML_points())->gagnantEdit($row, $messages);
	
	}
	
	
	// sauvegarde les données dans la DB
	function gagnantSave() {
		global $db, $messages;
		
		// récup les données
		$row 		=& gagnantGetData();
		
		
		// date du témoignage
		if($row->temoignage_date) {
		
			$date = explode('/', (string) $row->temoignage_date);
			$row->temoignage_date = $date[2].'-'.$date[1].'-'.$date[0];
		
		} else {
		
			$row->temoignage_date = '0000-00-00';
		
		}
		
		
		// s'il n'y a pas d'erreur
		if(!count($messages)) {
		
			// mise à jour dans la DB
			$query = "UPDATE points_gagnants SET"
			." nom = '".$db->escape($row->nom)."',"
			." prenom = '".$db->escape($row->prenom)."',"
			." adresse = '".$db->escape($row->adresse)."',"
			." code_postal = '".$db->escape($row->code_postal)."',"
			." ville = '".$db->escape($row->ville)."',"
			." commentaire = '".$db->escape($row->commentaire)."',"
			." traite = '".$db->escape($row->traite)."',"
			." temoignage = '".$db->escape($row->temoignage)."',"
			." temoignage_date = '".$db->escape($row->temoignage_date)."'"
			." WHERE id = '".$db->escape($row->id)."'"
			;
			$db->query($query);
			
			
			// mesage de confirmation
			$messages[]	= '<span class="valid">Modifications enregistr&eacute;es.</span>';
		
		}
		
		return $messages;
		
	}
	
	
	// liste les points du barème
	function gagnantList() {
		global $db, $messages;
		
		// recherche des données
		$query = "SELECT pg.id, u.username, pg.annee_mois, pg.position, pg.traite, IF(pg.temoignage!='', 1, 0) as temoigne, pg.commentaire"
		." FROM points_gagnants AS pg"
		." INNER JOIN user AS u ON u.id = pg.user_id"
		." ORDER BY pg.traite ASC, pg.annee_mois DESC, pg.position"
		;
		$rows = $db->loadObjectList($query);
		
		
		(new HTML_points())->gagnantList($rows, $messages);
		
	}	
	
	
	// affiche le classement d'un mois donné
	function classementList() {
		global $db;
		
		// params
		$annee_mois = JL::getVar('annee_mois', '');
		
		// liste déroulante des années-mois
		$query = "SELECT annee_mois"
		." FROM points_classements"
		." GROUP BY annee_mois"
		." ORDER BY annee_mois DESC"
		;
		$anneesMoisList = $db->loadObjectList($query);
		
		// correction du paramètre annee_mois si celui-ci n'est pas défini
		if(is_array($anneesMoisList) && count($anneesMoisList) > 0 && $annee_mois == '') {
			$annee_mois = $anneesMoisList[0]->annee_mois;
		}
		
		$list['annee_mois'] = JL::makeSelectList($anneesMoisList, 'annee_mois', 'onChange="document.adminForm.submit();" class="anneesMoisList" id="annee_mois"', 'annee_mois', 'annee_mois', $annee_mois);
		
		
		// récup le classement de l'$annee_mois
		$query = "SELECT IFNULL(u.username, 'inconnu') AS username, pc.points"
		." FROM points_classements AS pc"
		." LEFT JOIN user AS u ON u.id = pc.user_id"
		." WHERE pc.annee_mois = '".$db->escape($annee_mois)."'"
		." ORDER BY pc.points DESC"
		;
		$rows = $db->loadObjectList($query);
		
		
		// affichage du classement
		(new HTML_points())->classementList($rows, $list);
	
	}
	
	
?>

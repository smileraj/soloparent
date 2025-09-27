<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('appel_a_temoins.html.php');
			include("lang/app_appel_a_temoins.".$_GET['lang'].".php");

	global $action, $langue, $langString;
	if($_GET["lang"]=='fr')
		$langString = "";
	else
		$langString = "_".$_GET[lang];

	// uniquement lorsque l'on sauve
	if($action == 'save') {

		// fonctions de manipulation d'images
		include_once('js/swfupload/functions.php');

	}


	// gestion des messages d'erreurs
	$messages	= array();

	/*
		new: formulaire nouvel appel &agrave; t&eacute;moins
		save: submit le formulaire de nouvel appel &agrave; t&eacute;moins
		list: lister les appels &agrave; t&eacute;moins
		read: lire un appel &agrave; t&eacute;moins complet
	*/
	switch($action) {

		case 'info':
			appel_a_temoinsInfo();
		break;


		case 'read':
			$id	= JL::getVar('id', 0, true);
			appel_a_temoinsRead($id);
		break;

		case 'new':
			appel_a_temoinsWrite($messages);
		break;

		case 'save':
			$messages = appel_a_temoinsSave();
			if(!count($messages)) {
				JL::redirect(SITE_URL.'/index.php?app=appel_a_temoins&action=list&msg=sent&'.$langue);
			} else {
				appel_a_temoinsWrite($messages);
			}
		break;

		default:
			appel_a_temoinsList((int)JL::getVar('page',1));
		break;

	}

	function appel_a_temoins_data() {
		global $langue;
		$_data	= array(
			'nom' => '',
			'prenom' => '',
			'adresse' => '',
			'telephone' => '',
			'email' => '',
			'email2' => '',
			'media_id' => 0,
			'titre' => '',
			'annonce' => '',
			'date_limite' => '',
			'date_diffusion' => '',

			'file_logo' => '',

			'codesecurite' => ''
		);
		return $_data;
	}


	function appel_a_temoinsList($page) {
		global $langue;
		include("lang/app_appel_a_temoins.".$_GET['lang'].".php");
		global $db, $messages;
		

		if(JL::getVAr('msg', '') == 'sent') {
			$messages[]	= '<span class="valid">'.$lang_appel_a_temoins["VotreAppelATemoinsEnvoye"].'.</span>';
		}

		// variables
		$where 				= array();
		$_where				= '';
		
			$resultatParPage	= LISTE_RESULT;
		

		// correction au cas o&ugrave; le visiteur s'amuserait avec les params de l'url
		$search['page']		= (int)JL::getVar('page', 1);
		if($search['page'] <= 0) JL::redirect(SITE_URL.'/index.php?app=appel_a_temoins'.'&'.$langue);
		// r&eacute;cup le total


		// WHERE
		$where[]			= "at.active = 1";
		$where[]			= "m.published = 1";

		if (is_array($where)) {
			$_where = " WHERE ".implode(" AND ", $where);
		}


		// r&eacute;cup le total
		$query = "SELECT COUNT(*)"
		." FROM appel_a_temoins AS at"
		." INNER JOIN appel_media AS m ON m.id = at.media_id"
		.$_where
		;
		$search['result_total']	= (int)$db->loadResult($query);
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);

		// r&eacute;cup les messages de l'utilisateur log
		$query = "SELECT at.id, at.titre, at.annonce, at.date_add, m.nom_".$_GET['lang']." AS media"
		." FROM appel_a_temoins AS at"
		." INNER JOIN appel_media AS m ON m.id = at.media_id"
		.$_where
		." ORDER BY at.date_add DESC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$rows = $db->loadObjectList($query);

		// affiche la liste des appels
		HTML_appel_a_temoins::appel_a_temoinsList($rows, $messages, $search);

	}


	function appel_a_temoinsRead($id) {
		global $langue;
		global $db;

		// variables
		$where 		= array();
		$_where		= '';

		$where[]	= "at.id = '".$id."'";
		$where[]	= "at.active = 1";

		if (is_array($where)) {
			$_where = " WHERE ".implode(" AND ", $where);
		}


		// r&eacute;cup le message de l'utilisateur log
		$query = "SELECT at.id, at.titre, at.annonce, at.nom, at.prenom, at.email, at.telephone, at.adresse, at.active, am.nom_".$_GET['lang']." AS media, at.date_add, at.date_limite, at.date_diffusion, at.date_add"
		." FROM appel_a_temoins AS at"
		." INNER JOIN appel_media AS am ON am.id = at.media_id"
		.$_where
		." LIMIT 0,1"
		;
		$row = $db->loadObject($query);

		// appel inexistant
		if(!$row) {
			JL::loadApp('404');
		}

		// affiche la liste des messages
		HTML_appel_a_temoins::appel_a_temoinsRead($row);


	}


	function appel_a_temoinsWrite($messages) {
		global $langue, $langString;
		global $db;

		// variables
		$_data			= appel_a_temoins_data();
		$list			= array();
		$list_media_id	= array();

		// r&eacute;cup les donn&eacute;es temporaires
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key}	= JL::getVar($key, $value);
			}
		}


		// r&eacute;cup la liste des m&eacute;dias
		$list_media_id[] = JL::makeOption('0', '> Types de m&eacute;dias');
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM appel_media"
		." WHERE published = 1"
		." ORDER BY text ASC"
		;
		$list_media_id = array_merge($list_media_id, $db->loadObjectList($query));

		$list['media_id'] 	= JL::makeSelectList($list_media_id, 'media_id', 'id="media_id" class="msgtxt"', 'value', 'text', $row->media_id);

		$list['captcha']	= rand(2,7);
		JL::setSession('captcha', $list['captcha']);


		$query = "SELECT titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 116";
		$data = $db->loadObject($query);
		
		// affichage du formulaire
		HTML_appel_a_temoins::appel_a_temoinsWrite($data, $row, $messages, $list);

	}


	function appel_a_temoinsSave() {
		global $langue;
		include("lang/app_appel_a_temoins.".$_GET['lang'].".php");
		global $db;

		// gestion des messages d'erreurs
		$messages	= array();

		// variables
		$_data		= appel_a_temoins_data();
		$row		= new stdClass();

		// r&eacute;cup les donn&eacute;es temporaires
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key}	= JL::getVar($key, $value);
			}
		}

		// v&eacute;rifications des champs
		if($row->media_id == 0) {
			$messages[]	= '<span class="error">'.$lang_appel_a_temoins["VeillezTypeMedia"].'.</span>';
		}

		if(!$row->titre) {
			$messages[]	= '<span class="error">'.$lang_appel_a_temoins["VeillezTitreAppel"].'.</span>';
		}

		if(!$row->annonce) {
			$messages[]	= '<span class="error">'.$lang_appel_a_temoins["VeillezAnnonce"].'.</span>';
		}

		if(!$row->nom) {
			$messages[]	= '<span class="error">'.$lang_appel_a_temoins["VeillezNom"].'.</span>';
		}

		if(!$row->prenom) {
			$messages[]	= '<span class="error">'.$lang_appel_a_temoins["VeillezPrenom"].'.</span>';
		}

		if(!$row->telephone) {
			$messages[]	= '<span class="error">'.$lang_appel_a_temoins["VeillezNumero"].'.</span>';
		}

		/*
		if(!$row->adresse) {
			$messages[]	= '<span class="error">Veuillez indiquer votre adresse postale s\'il vous pla&icirc;t.</span>';
		}
		*/

		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $row->email)) {
			$messages[]	= '<span class="error">'.$lang_appel_a_temoins["VeillezAdresse"].'.</span>';
		}

		if(!$row->email2) {
			$messages[]	= '<span class="error">'.$lang_appel_a_temoins["VeillezConfirmerAdresse"].'.</span>';
		}

		if($row->email != $row->email2) {
			$messages[]	= '<span class="error">'.$lang_appel_a_temoins["VeillezEmail"].' !</span>';
		}

		// v&eacute;rification fichier envoy&eacute;
		if(isset($_FILES["file_logo"]) && is_uploaded_file($_FILES["file_logo"]["tmp_name"]) && $_FILES["file_logo"]["size"] > 0 && $_FILES["file_logo"]["error"] == 0) {

			// d&eacute;termine l'extension en fonction du type mime
			list($width, $height, $type, $attr) = getImageSize($_FILES["file_logo"]["tmp_name"]);
			$mime = image_type_to_mime_type($type);
			if(preg_match('/jpeg/', $mime)) {
				$ext = 'jpg';
			} elseif(preg_match('/png/', $mime)) {
				$ext = 'png';
			} elseif(preg_match('/gif/', $mime)) {
				$ext = 'gif';
			} else {
				$ext = 'error';
			}

			if($width > 1024 || $height > 1024) {
				$ext = 'error';
			}

		} else {

			$ext = '';

		}

		if($ext == 'error') {
			$messages[]	= '<span class="error">'.$lang_appel_a_temoins["VeillezImage"].'.</span>';
		}



		// v&eacute;rification du captcha
		if($row->codesecurite != JL::getSession('captcha', 0)) {
			$messages[]	= '<span class="error">'.$lang_appel_a_temoins["CodeSecuriteIncorrect"].'.</span>';
		}



		// pas d'erreur, on envoie l'appel
		if(!count($messages)) {

			// insertion
			$query = "INSERT INTO appel_a_temoins SET"
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
			." date_add = NOW()"
			;
			$db->query($query);

			// r&eacute;cup l'id g&eacute;n&eacute;r&eacute;
			$id	= $db->insert_id();

			// enregistre le logo s'il a &eacute;t&eacute; envoy&eacute;
			if($ext != '' && $ext != 'error') {

				// g&eacute;n&egrave;re la miniature
				creerMiniature($_FILES["file_logo"]["tmp_name"], 'images/appel-a-temoins/'.$id.'.jpg', 90, 90, $ext);

			}

		}

		return $messages;

	}


	function appel_a_temoinsInfo() {
		global $langString;
		global $langue;
		global $db;

		$id	= 26; // id de l'article d'information

		// r&eacute;cup l'article
		$query = "SELECT titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = '".(int)$id."' LIMIT 0,1";
		$row = $db->loadObject($query);

		// affichage
		HTML_appel_a_temoins::appel_a_temoinsInfo($row);

	}

?>

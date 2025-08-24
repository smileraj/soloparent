<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('profil.html.php');
	include("lang/app_profil.".$_GET['lang'].".php");

	// variables
	global $action, $user, $langue, $langString;
	$messages	= array(); // gestion des messages d'erreurs
	if($_GET["lang"]=='fr')
		$langString = "";
	else
		$langString = "_$_GET[lang]";

	// librairie de fonctions
	if(in_array($action, array('panel', 'step8', 'step8submit'))) {
		require_once(SITE_PATH.'/framework/functions.php');
	}


	// pseudo controller &agrave; la joomla 1.0
	switch($action) {


		// PARRAINAGE
		case 'parrainage':
			if(!$user->id) JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			parrainage();
		break;

		case 'parrainagesubmit':
			if(!$user->id) JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			$messages = parrainagesubmit();

			// r&eacute;-affiche le formulaire avec message de validation
			parrainage($messages);
		break;


		// VISUALISATION
		case 'view':
		case 'view2':
		case 'view3':
		case 'view4':
		case 'view5':
		case 'view6': // groupes
		/*case 'view7': // messages &eacute;chang&eacute;s */
			if(!$user->id) {
				JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			}
			profil();
		break;


		// GROUPES
		case 'view6':
			profilGroupes((int)JL::getVar('id', 0));
		break;


		// LOGGED
		case 'panel':

			// utilisateur non log
			if(!$user->id) {
				JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			}

			panel();
		break;

		case 'notification':

			// user non log
			if(!$user->id) {
				// redirige sur l'inscription
				JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			}

			// gestion des notifications de l'utilisateur
			notification();

		break;

		case 'notificationsubmit':

			// user non log
			if(!$user->id) {
				// redirige sur l'inscription
				JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			}

			// traitement des donn&eacute;es du formulaire
			$messages = notificationsubmit();

			// r&eacute;-affiche le formulaire avec message de validation
			notification($messages);

		break;


		// MOT DE PASSE PERDU
		case 'mdp':

			// params
			if(JL::getVar('msg', '') == 'mdpok') {

				$messages[] 	= '<span class="valid">'.$lang_appprofil["EmailVousEteEnvoyer"].' !</span>';

			}

			// soumission du formulaire
			if((int)JL::getVar('save', 0)) {

				// ~model: sauvegarde les donn&eacute;es
				$messages = mdpsubmit();

				// si les donn&eacute;es sont valides
				if(!count($messages)) {
					JL::redirect(SITE_URL.'/index.php?app=profil&action=mdp&msg=mdpok'.'&'.$langue);
				}

			}

			// ~view
			mdp($messages);

		break;

		case 'mdpconfirm':

			// params
			$id		= (int)JL::getVar('id', 0, true);
			$key	= JL::getVar('key', '', true);

			// un param non renseign&eacute;
			if(!$id || !$key) {
				JL::redirect(SITE_URL.'/index.php?app=profil&action=mdp'.'&'.$langue);
			}

			// effectue le changement de mot de passe
			mdp_change($id, $key);

		break;


		// INSCRIPTION
		/*case 'confirmation':
			confirmation();
		break;*/

		case 'finalisation':
			step_check(10);
			finalisation();
		break;

		case 'step9':
			step_check(9); // on peut aller directement &agrave; la fin de l'inscription, mais il faut avoir valid&eacute; l'&eacute;tape 1
			step9();
		break;

		case 'step9submit':

			// traitement des donn&eacute;es du formulaire
			$messages = step9submit();

			// messages pr&eacute;sents (un message seul = message de validation, donc user log)
			if(count($messages)) {

				// r&eacute;-affiche l'&eacute;tape
				step9($messages);

			} else {

				// passe &agrave; l'&eacute;tape suivante
				JL::redirect('index.php?app=profil&action=finalisation'.'&'.$langue);

			}

		break;


		case 'step8':
			step_check(8);
			step8($messages);
		break;

		case 'step8submit':

			// traitement des donn&eacute;es du formulaire
			$messages = step8submit();

			// messages pr&eacute;sents (un message seul = message de validation, donc user log)
			if(count($messages)) {

				step8($messages);
				//JL::redirect('index.php?app=search&action=saved');

			} else {

				// passe &agrave; l'&eacute;tape suivante
				JL::redirect('index.php?app=profil&action=step9'.'&'.$langue);

			}

		break;



		case 'step7':
			step_check(7);
			step7();
		break;

		case 'step7submit':

			// traitement des donn&eacute;es du formulaire
			$messages = step7submit();

			// messages pr&eacute;sents (un message seul = message de validation, donc user log)
			if(count($messages)) {

				// r&eacute;-affiche l'&eacute;tape
				step7($messages);

			} else {

				// passe &agrave; l'&eacute;tape suivante
				JL::redirect('index.php?app=profil&action=step8'.'&'.$langue);

			}

		break;



		case 'step6':
			step_check(6);
			step6();
		break;

		case 'step6submit':

			// traitement des donn&eacute;es du formulaire
			$messages = step6submit();

			// messages pr&eacute;sents (un message seul = message de validation, donc user log)
			if(count($messages)) {

				// r&eacute;-affiche l'&eacute;tape
				step6($messages);

			} else {

				// passe &agrave; l'&eacute;tape suivante
				JL::redirect('index.php?app=profil&action=step7'.'&'.$langue);

			}

		break;



		case 'step5':
			step_check(5);
			step5();
		break;

		case 'step5submit':

			// traitement des donn&eacute;es du formulaire
			$messages = step5submit();

			// messages pr&eacute;sents (un message seul = message de validation, donc user log)
			if(count($messages)) {

				// r&eacute;-affiche l'&eacute;tape
				step5($messages);

			} else {

				// passe &agrave; l'&eacute;tape suivante
				JL::redirect('index.php?app=profil&action=step6'.'&'.$langue);

			}

		break;



		case 'step4':
			step_check(4);
			step4();
		break;

		case 'step4submit':

			// traitement des donn&eacute;es du formulaire
			$messages = step4submit();

			// messages pr&eacute;sents (un message seul = message de validation, donc user log)
			if(count($messages)) {

				// r&eacute;-affiche l'&eacute;tape
				step4($messages);

			} else {

				// passe &agrave; l'&eacute;tape suivante
				JL::redirect('index.php?app=profil&action=step5'.'&'.$langue);

			}

		break;



		case 'step3':
			step_check(3);
			step3();
		break;

		case 'step3submit':

			// traitement des donn&eacute;es du formulaire
			$messages = step3submit();

			// messages pr&eacute;sents (un message seul = message de validation, donc user log)
			if(count($messages)) {

				// r&eacute;-affiche l'&eacute;tape
				step3($messages);

			} else {

				// passe &agrave; l'&eacute;tape suivante
				JL::redirect('index.php?app=profil&action=step4'.'&'.$langue);

			}

		break;



		case 'step2':
			step_check(2);
			step2();
		break;

		case 'step2submit':

			// traitement des donn&eacute;es du formulaire
			$messages = step2submit();

			// messages pr&eacute;sents (un message seul = message de validation, donc user log)
			if(count($messages)) {

				// r&eacute;-affiche l'&eacute;tape
				step2($messages);

			} else {

				// passe &agrave; l'&eacute;tape suivante
				JL::redirect('index.php?app=profil&action=step3'.'&'.$langue);

			}

		break;


		case 'inscription':
		case 'step1':
			step1();
		break;

		case 'step1submit':

			// traitement des donn&eacute;es du formulaire
			$messages = step1submit();

			// messages pr&eacute;sents (un message seul = message de validation, donc user log)
			if(count($messages)) {

				// r&eacute;-affiche l'&eacute;tape
				step1($messages);

			} else {

				// passe &agrave; l'&eacute;tape suivante
				JL::redirect('index.php?app=profil&action=step2'.'&'.$langue);

			}

		break;



		default:
			JL::loadApp('404');
		break;

	}


	// panneau d'admin utilisateur une fois log
	function panel() {
		global $langue,$langString;
		global $db, $user;

		// connexion al&eacute;atoire de nos profils entre 8 et 24 heures
		/*if(date('G') >= 8 AND rand(0,10) == 0) {

			// user id &agrave; exclure
			$connectUserId	= array();

			/

				profils &agrave; exclure des connexions automatiques
				> jolito 		672
				> pauline33		22
				> benji		21
				> nanette		19
				> maria		15
				> julie_80		25
				> mimi75		677
				> luka 		678

			/
			$exclureUserId	= array(672,22,21,19,15,25,677,678);


			// r&eacute;cup nos profils
			$query = "SELECT user_id"
			." FROM user_profil"
			." WHERE helvetica = 1 AND user_id NOT IN (".implode(',', $exclureUserId).")"
			;
			$userIds = $db->loadObjectList($query);

			if(is_array($userIds)) {
				foreach($userIds as $userId) {
					$connectUserId[] = $userId->user_id;
				}
			}

			// connecte le profil
			$query 	= "UPDATE user SET last_online = NOW() WHERE id IN(".implode(',', $connectUserId).")";
			$db->query($query);

		}*/


		// Recover the kind of user
		$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
		$genre = $db->loadResult($query);

		// If it is a man
		if($genre == 'h') {
			$genreRecherche =  'f';
		} else { // if not if it is a woman
			$genreRecherche =  'h';
		}


		// retrieve members online (without taking user log)
		$query = "SELECT u.id, u.username, IFNULL(pc.nom, '') AS canton, up.genre, up.photo_defaut, up.nb_enfants, CURRENT_DATE, ((YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5))) AS age"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton$langString AS pc ON pc.id = up.canton_id"
		." LEFT JOIN user_flbl AS uf ON (uf.user_id_to = u.id AND uf.user_id_from = '".$user->id."' AND uf.list_type = 0)"
		." WHERE uf.user_id_to IS NULL AND u.published = 1 AND u.confirmed > 0 AND u.id != '".$user->id."' AND up.genre = '".$genreRecherche."'"
		." GROUP BY u.id"
		." ORDER BY u.last_online DESC"
		." LIMIT 0,4"
		;
		$profilsOnline 		= $db->loadObjectList($query);


		// retrieve the last registered (without taking log user)
		$query = "SELECT u.id, u.username, IFNULL(pc.nom, '') AS canton, up.genre, up.photo_defaut, up.nb_enfants, CURRENT_DATE, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton$langString AS pc ON pc.id = up.canton_id"
		." LEFT JOIN user_flbl AS uf ON (uf.user_id_to = u.id AND uf.user_id_from = '".$user->id."' AND uf.list_type = 0)"
		." WHERE uf.user_id_to IS NULL AND u.published = 1 AND u.confirmed > 0 AND u.id != '".$user->id."' AND up.genre = '".$genreRecherche."'"
		." GROUP BY u.id"
		." ORDER BY u.creation_date DESC"
		." LIMIT 0,4"
		;
		$profilsInscrits 	= $db->loadObjectList($query);


		// Retrieve the search engine fields
		$list	=& FCT::getSearchEngine();


		// Retrieve last call to witnesses
		$query = "SELECT at.id, at.titre, at.annonce, m.nom AS media"
		." FROM appel_a_temoins AS at"
		." INNER JOIN appel_media AS m ON m.id = at.media_id"
		." WHERE at.active = 1 AND m.active = 1"
		." ORDER BY at.date_add DESC"
		." LIMIT 0,1"
		;
		$appel_a_temoins = $db->loadObject($query);


		// Retrieve the last testimony
		$query = "SELECT t.id, t.titre, t.texte, t.user_id, u.username, up.photo_defaut, up.genre"
		." FROM temoignage AS t"
		." INNER JOIN user AS u ON u.id = t.user_id"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." WHERE t.active = 1"
		." ORDER BY t.date_add DESC"
		." LIMIT 0,1"
		;
		$temoignage = $db->loadObject($query);


		HTML_profil::panel($profilsOnline, $profilsInscrits, $genreRecherche, $list, $appel_a_temoins, $temoignage);

	}


	function mdp(&$messages) {
		global $langue;

		// Data Recovery
		$_data	= mdp_data();

		$row = new stdClass();

		// Form data
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = trim(JL::getVar($key, $value));
			}
		}

		// captcha
		$row->captcha		= rand(1,9);
		$row->captchaMd5	= md5(date('m/Y').($row->captcha+1337));

		// form
		HTML_profil::mdp($row, $messages);

	}

	// Applies the password change request
	function mdp_change($id, $key) {
		global $langue;
		global $db;

		$query = "UPDATE user SET password = password_new, password_new = '' WHERE password_new != '' AND id ='".$id."' AND MD5(CONCAT(username, creation_date)) = '".$key."'";
		$db->query($query);

		if($db->affected_rows()) {

			// view
			HTML_profil::mdpChanged();

		} else {

			// view
			HTML_profil::mdpError();

		}

	}


	function mdp_data() {
		global $langue;
		$_data	= array(
			'email' 		=> '',
			'password' 		=> '',
			'password2' 	=> '',
			'captchaMd5' 	=> '',
			'captcha' 		=> '',
			'verif' 		=> ''
		);
		return $_data;
	}

	function mdpsubmit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// Management of error messages
		$messages			= array();


		// Data Recovery
		$_data	= mdp_data();

		if(count($_data)) {
			foreach($_data as $key => $value) {
				$_data[$key] = trim(JL::getVar($key, $value, true));
			}
		}


		// email
		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $_data['email'])) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VeuillezIndiquerAdresse"].'.</span>';
		}

		// Checks if the email address exists (and is not an admin address)
		$query = "SELECT id FROM user WHERE email LIKE '".$_data['email']."' AND gid != 1 LIMIT 0,1";
		$emailExistant = $db->loadResult($query);

		// Email does not exist
		if(!$emailExistant) {
			$messages[]	= '<span class="error">'.$lang_appprofil["CetteAdresseEmail"].'.</span>';
		}

		if(!$_data['password']) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VeuillezIndiquerNouveau"].'.</span>';
		}

		if($_data['password'] && !preg_match('/^[a-zA-Z0-9._-]+$/', $_data['password'])) {
			$messages[]	= '<span class="error">'.$lang_appprofil["LeMotDePasseContenir"].'.</span>';
		}

		// Mdp confirmation
		if($_data['password2'] && !preg_match('/^[a-zA-Z0-9._-]+$/', $_data['password2'])) {
			$messages[]	= '<span class="error">'.$lang_appprofil["ConfirnationMotDePasse"].'.</span>';
		}

		if(($_data['password'] || $_data['password2']) && $_data['password'] != $_data['password2']) {
			$messages[]	= '<span class="error">'.$lang_appprofil["LaCondirmationDuMotDePassw"].'.</span>';
		}

		if($_data['verif'] == '' || md5(date('m/Y').($_data['verif']+1337)) != $_data['captchaMd5']) {
			$messages[] = '<span class="error">'.$lang_appprofil["LecodeDeCerification"].'.</span>';
		}


		//If there are no errors
		if(!count($messages)) {

			// Recover the login
			$query 			= "SELECT id, username, creation_date FROM user WHERE email LIKE '".$_data['email']."' LIMIT 0,1";
			$userTemp		= $db->loadObject($query);
			$userTemp->lien	= SITE_URL."/index.php?app=profil&action=mdpconfirm&id=".$userTemp->id."&key=".md5($userTemp->username.$userTemp->creation_date).'&'.$langue;


			// Registers the request for change of mdp
			$query = "UPDATE user SET password_new = MD5('".$_data['password']."') WHERE email LIKE '".$_data['email']."'";
			$db->query($query);


			// Send password change confirmation email

			// headers
			$headers 	= 'Mime-Version: 1.0'."\r\n";
			$headers 	= 'From: "'.SITE_MAIL_FROM.'" <'.SITE_MAIL.'>'."\r\n";
			$headers   .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
			//$headers .= "\r\n";

			$titre		= '[ '.SITE_MAIL_FROM.' ] '.$lang_appprofil["DemandeDeChangement"];
			$texte 		= ''.$lang_appprofil["Bonjour"].' <b>'.$userTemp->username.'</b><br /><br />';
			$texte		.= ''.$lang_appprofil["AfinDeConfirmer"].':<br />';
			$texte		.= '<a href="'.$userTemp->lien.'" title="'.$lang_appprofil["ConfirmerLechangement"].'">'.$userTemp->lien.'</a><br /><br />';
			$texte		.= ''.$lang_appprofil["ApesAvoirClique"].':<br /><br />';
			$texte		.= '<b>'.$lang_appprofil["Login"].':</b> '.$userTemp->username.'<br />';
			$texte		.= '<b>'.$lang_appprofil["MotdePasse"].':</b> '.$_data['password'].'<br /><br />';
			$texte		.= ''.$lang_appprofil["Attention"].' !<br /><br />';
			$texte		.= ''.$lang_appprofil["ABientotSur"].' <a href="'.SITE_URL.'&'.$langue.'" title="Premier site de rencontres pour parents c&eacute;libataires Suisses">Parentsolo.ch</a> !';

			// envoi du mail
			mail($_data['email'], $titre, $texte, $headers);

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}


	// le visiteur a-t-il rempli l'&eacute;tape pr&eacute;c&eacute;dent la num&eacute;ro $step_num
	function step_check($step_num) {
		global $langue;
		global $db, $user;

		// utilisateur non log
		if(!$user->id) {
			/*if(isset($_SESSION['step_ok']) && $step_num > ($_SESSION['step_ok']+1)) {
				JL::redirect("index.php?app=profil&action=step".($_SESSION['step_ok']+1));
			} elseif(!isset($_SESSION['step_ok'])) {
				JL::redirect("index.php?app=profil&action=inscription");*/

			if($step_num > 1 && JL::getSessionInt('step_ok', 0) < 1) { // page inscription obligatoire (&eacute;tape 1)
				JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			} elseif($step_num > 9 && JL::getSessionInt('step_ok', 0) < 9) { // page coordonn&eacute;es obligatoire (&eacute;tape 9)
				JL::redirect("index.php?app=profil&action=step9".'&'.$langue);
			} else {
				$query = "UPDATE user_inscription SET step = '".$step_num."', ip = '".$_SERVER["REMOTE_ADDR"]."' WHERE username LIKE '".JL::getSession('username', '', true)."'";
				$db->query($query);
			}
		}

	}


	function step1($messages = array()) {
		global $langue,$langString;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;


		// affecte un ID temporaire au visiteur s'il n'en a pas encore
		// ATTENTION: ne surtout pas mettre le id_tmp en donn&eacute;e du formulaire, quelqu'un pourrait voler l'id_tmp d'une autre personne sinon !
		if(!isset($_SESSION['id_tmp'])) {
			JL::setSession('id_tmp', JL::microtime_float()*10000);
		}


		// variables
		$_data						= step1_data();
		$row						= array();
		$list						= array();
		$list_genre					= array();
		$list_naissance_jour		= array();
		$list_naissance_mois		= array();
		$list_naissance_annee		= array();
		$list_nb_enfants			= array();
		$list_canton_id				= array();
		$list_ville_id				= array();
		$list_recherche_age_min		= array();
		$list_recherche_age_max		= array();
		$list_recherche_nb_enfants	= array();


		// conserve les donn&eacute;es envoy&eacute;es en session, si on vient de l'inscription rapide uniquement !
		if((int)JL::getVar('inscriptionrapide', 0) > 0 || (int)JL::getVar('parrain_id', 0) > 0) {
			if(count($_data)) {
				foreach($_data as $key => $value) {
					JL::setSession($key, JL::getVar($key, $value));
				}
			}
		}

		// utilisateur log et aucun message pr&eacute;sent
		if($user->id && !count($messages)) {

			// r&eacute;cup les donn&eacute;es en db
			$query = "SELECT genre, naissance_date, nb_enfants, canton_id, ville_id, offres, recherche_age_min, recherche_age_max, recherche_nb_enfants, parrain_id"
			." FROM user_profil"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$tmp = $db->loadResultArray($query);

			// extrait les valeurs de la date de naissance
			$naissance_date	= explode('-', $tmp['naissance_date']);
			$tmp['naissance_annee'] 	= $naissance_date[0];
			$tmp['naissance_mois'] 		= $naissance_date[1];
			$tmp['naissance_jour'] 		= $naissance_date[2];

			// conditions g&eacute;n&eacute;rales accept&eacute;es par d&eacute;faut si l'utilisateur est log ! possibilit&eacute; de reset les conditions comme &ccedil;a
			$tmp['conditions']			= 1;

			// pseudo
			$tmp['username']			= $user->username;

			// email
			$tmp['email']				= $user->email;

			// mise en session des valeurs
			foreach($tmp as $key => $value) {
				JL::setSession($key, $tmp[$key]);
			}

		}


		// r&eacute;cup les donn&eacute;es temporaires en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}

		// homme / femme
		$list_genre[] = JL::makeOption('', '» '.$lang_appprofil["Genre_s"].'');
		$list_genre[] = JL::makeOption('f', ''.$lang_appprofil["UneFemme"].'');
		$list_genre[] = JL::makeOption('h', ''.$lang_appprofil["UnHomme"].'');
		$list['genre'] = JL::makeSelectList( $list_genre, 'genre', 'onChange="step1GenderChange(this.value);" class="genreCanton"', 'value', 'text', $row['genre']);


		// jour de naissance
		$list_naissance_jour[] = JL::makeOption('0', '» '.$lang_appprofil["JJ"].'');
		for($i=1; $i<=31; $i++) {
			$list_naissance_jour[] = JL::makeOption($i, sprintf('%02d', $i));
		}
		$list['naissance_jour'] = JL::makeSelectList( $list_naissance_jour, 'naissance_jour', '', 'value', 'text', $row['naissance_jour']);

		// mois de naissance
		$list_naissance_mois[] = JL::makeOption('0', '» '.$lang_appprofil["MM"].'');
		for($i=1; $i<=12; $i++) {
			$list_naissance_mois[] = JL::makeOption($i, sprintf('%02d', $i));
		}
		$list['naissance_mois'] = JL::makeSelectList( $list_naissance_mois, 'naissance_mois', '', 'value', 'text', $row['naissance_mois']);

		// ann&eacute;e de naissance
		$list_naissance_annee[] = JL::makeOption('0', '» '.$lang_appprofil["AAAA"].'');
		for($i=(intval(date('Y'))-18); $i>=1930; $i--) {
			$list_naissance_annee[] = JL::makeOption($i, sprintf('%04d', $i));
		}
		$list['naissance_annee'] = JL::makeSelectList( $list_naissance_annee, 'naissance_annee', '', 'value', 'text', $row['naissance_annee']);


		// nombre d'enfants
		for($i=1; $i<=4; $i++) {
			$list_nb_enfants[] = JL::makeOption($i, $i);
		}
		$list_nb_enfants[] = JL::makeOption(5, '5+');
		$list['nb_enfants'] = JL::makeSelectList( $list_nb_enfants, 'nb_enfants', '', 'value', 'text', $row['nb_enfants']);


		// recherche &acirc;ge mini
		$list_recherche_age_min[] = JL::makeOption('0', '» '.$lang_appprofil["Age"].'');
		for($i=18; $i<=(intval(date('Y'))-1930); $i++) {
			$list_recherche_age_min[] = JL::makeOption($i, $i);
		}
		$list['recherche_age_min'] = JL::makeSelectList( $list_recherche_age_min, 'recherche_age_min', '', 'value', 'text', $row['recherche_age_min']);

		$list_recherche_age_max[] = JL::makeOption('0', '» '.$lang_appprofil["Age"].'');
		for($i=18; $i<=(intval(date('Y'))-1930); $i++) {
			$list_recherche_age_max[] = JL::makeOption($i, $i);
		}
		$list['recherche_age_max'] = JL::makeSelectList( $list_recherche_age_max, 'recherche_age_max', '', 'value', 'text', $row['recherche_age_max']);


		// recherche nombre d'enfants
		$list_recherche_nb_enfants[] = JL::makeOption('0', ''.$lang_appprofil["AuMoinsUn"].'');
		for($i=1; $i<=3; $i++) {
			$list_recherche_nb_enfants[] = JL::makeOption($i, $i);
		}
		$list_recherche_nb_enfants[] = JL::makeOption('4', '4 '.$lang_appprofil["OuPlus"].'');
		$list['recherche_nb_enfants'] = JL::makeSelectList( $list_recherche_nb_enfants, 'recherche_nb_enfants', '', 'value', 'text', $row['recherche_nb_enfants']);


		// cantons
		$list_canton_id[] = JL::makeOption('0', '» '.$lang_appprofil["Canton_s"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_canton$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_canton_id = array_merge($list_canton_id, $db->loadObjectList($query));
		$list['canton_id'] 	= JL::makeSelectList( $list_canton_id, 'canton_id', 'id="canton_id" onChange="loadVilles();" class="genreCanton"', 'value', 'text', $row['canton_id']);
		$list['ville_id']	= '<input type="hidden" id="ville_id" name="ville_id" value="'.$row['ville_id'].'" />';


		// r&eacute;cup le texte de gauche pendant l'inscription
		$notice = getNotice(1);

		// r&eacute;cup les conditions g&eacute;n&eacute;rales d'utilisation
		$query = "SELECT texte FROM contenu$langString WHERE id = 5 LIMIT 0,1";
		$conditions = $db->loadResult($query);


		// parrainage
		if($row['parrain_id'] > 0) {

			// r&eacute;cup le pseudo du parrain
			$query = "SELECT username FROM user WHERE id = '".$db->escape($row['parrain_id'])."' LIMIT 0,1";
			$list['parrain'] = $db->loadResult($query);

		}

		HTML_profil::step1($row, $list, $messages, $notice, $conditions);

	}

	function step1_data() {
		global $langue;
		$_data	= array(
				'genre' => '',
				'naissance_jour' => 0,
				'naissance_mois' => 0,
				'naissance_annee' => 0,
				'nb_enfants' => 0,
				'canton_id' => 0,
				'ville_id' => 0,
				'username' => '',
				'password' => '',
				'password2' => '',
				'email' => '',
				'email2' => '',
				'conditions' => -1,
				'offres' => '0',
				'recherche_age_min' => 0,
				'recherche_age_max' => 0,
				'recherche_nb_enfants' => 0,
				'parrain_id' => 0
			);
		return $_data;
	}

	function step1submit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn&eacute;es &agrave; r&eacute;cup de l'&eacute;tape pr&eacute;c&eacute;dente + valeur par d&eacute;faut
		$_data	= step1_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}

			// correction de offres
			if(JL::getSession('offres', '') == 'on') {
				JL::setSession('offres', '1');
			} else {
				JL::setSession('offres', '0');
			}

		}


		// v&eacute;rif les donn&eacute;es
		if(JL::getSession('genre', '') == '') {
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezVousEtesHomme"].'.</span>';
		}

		if(!JL::getSessionInt('naissance_jour', 0) || !JL::getSessionInt('naissance_mois', 0) || !JL::getSessionInt('naissance_annee', 0)) {
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezVotreDateNaissance"].'.</span>';
		} elseif(mktime(0, 0, 0, JL::getSessionInt('naissance_mois', 0), JL::getSessionInt('naissance_jour', 0), JL::getSessionInt('naissance_annee', 0)+18) > time()) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VousDevezEtreMajeur"].'.</span>';
		}

		if(strlen(JL::getSession('username', '')) < 4 || strlen(JL::getSession('username', '')) > 10) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VotrePseudoPasVlides"].'.</span>';
		}

		if(!preg_match('/^[a-zA-Z0-9._-]+$/', JL::getSession('username', ''))) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VotrePseudoPasVlidesContenir"].'.</span>';
		}

		// user log et change de mdp, ou user non log
		if(($user->id && JL::getSession('password', '') || !$user->id) && !preg_match('/^[a-zA-Z0-9._-]+$/', JL::getSession('password', ''))) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VotreMotDePasse"].'.</span>';
		}

		// user log et change de mdp, ou user non log
		if(($user->id && JL::getSession('password2', '') || !$user->id) && !preg_match('/^[a-zA-Z0-9._-]+$/', JL::getSession('password2', ''))) {
			$messages[]	= '<span class="error">'.$lang_appprofil["LaConfirmationPasValide"].'.</span>';
		}

		if((JL::getSession('password', '') || JL::getSession('password2', '')) && JL::getSession('password', '') != JL::getSession('password2', '')) {
			$messages[]	= '<span class="error">'.$lang_appprofil["LaConfirmationCorrespondPas"].'.</span>';
		}

		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', JL::getSession('email', ''))) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VotreAdresseEmailPasValide"].'.</span>';
		}

		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', JL::getSession('email2', ''))) {
			$messages[]	= '<span class="error">'.$lang_appprofil["LaConfirmationEmailPasValide"].'.</span>';
		}

		if(JL::getSession('email', '') != JL::getSession('email2', '')) {
			$messages[]	= '<span class="error">'.$lang_appprofil["LaConfirmationEmailCorrespondPas"].'.</span>';
		}

		if(!JL::getSessionInt('canton_id', 0)) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VeuillezIndiquerCantan"].'.</span>';
		}

		if(JL::getSession('conditions', -1) <= 0) {
			$messages[]	= '<span class="error">'.$lang_appprofil["FautLireLesCondition"].'.</span>';
		}

		// v&eacute;rification du captcha
		if(!$user->id && intval(JL::getVar('codesecurite', -1)) != JL::getSession('captcha', 0)) {
			$messages[]	= '<span class="error">'.$lang_appprofil["CodeSecuriteincorrect"].'.</span>';
		}

		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// enregistre les modifs en DB (certains champs ne sont pas mis &agrave; jour volontairement ==> s&eacute;curit&eacute; oblige !)
				$query = "UPDATE user_profil SET"
				." offres = '".JL::getSession('offres', '0', true)."',"
				." naissance_date = '".JL::getSessionInt('naissance_annee', 0)."-".JL::getSessionInt('naissance_mois', 0)."-".JL::getSessionInt('naissance_jour', 0)."',"
				." nb_enfants = '".JL::getSessionInt('nb_enfants', 1)."',"
				." canton_id = '".JL::getSessionInt('canton_id', 0)."',"
				." ville_id = '".JL::getSessionInt('ville_id', 0)."',"
				." recherche_age_min = '".JL::getSessionInt('recherche_age_min', 0)."',"
				." recherche_age_max = '".JL::getSessionInt('recherche_age_max', 0)."',"
				." recherche_nb_enfants = '".JL::getSessionInt('recherche_nb_enfants', 0)."',"
				." parrain_id = '".JL::getSessionInt('parrain_id', 0)."'"
				." WHERE user_id = '".$user->id."'"
				;
				$db->query($query);


				// changement de mdp
				if(JL::getSession('password', '')) {
					$query = "UPDATE user SET password = MD5('".JL::getSession('password', '', true)."') WHERE id = '".$user->id."'";
					$db->query($query);
				}

				// &agrave; laisser que l'user soit log ou pas, m&ecirc;me si on affiche pas le message (utile dans le swtich case sur $action
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

			} else { // user non log

				// check que le pseudo n'est pas d&eacute;j&agrave; pris
				$query = "SELECT id FROM user WHERE username LIKE '".JL::getSession('username', '', true)."' LIMIT 0,1";
				$pseudoExistantUser = $db->loadResult($query);

				// check que le pseudo n'est pas d&eacute;j&agrave; r&eacute;serv&eacute; par un autre utilisateur (en cours d'inscription), max 1 heure de r&eacute;servation
				$query = "SELECT username FROM user_inscription WHERE username LIKE '".JL::getSession('username', '', true)."' AND id_tmp NOT LIKE '".JL::getSession('id_tmp', '')."' AND (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(reservation_date)) < 3600 LIMIT 0,1";
				$pseudoExistantTmp = $db->loadResult($query);

				// pseudo d&eacute;j&agrave; pris
				if($pseudoExistantUser || $pseudoExistantTmp) {
					$messages[]	= '<span class="error">'.$lang_appprofil["CePseudoEstDeja"].'.</span>';
				}

				// check que le pseudo n'est pas d&eacute;j&agrave; pris
				$query = "SELECT id FROM user WHERE username LIKE '".JL::getSession('email', '', true)."' LIMIT 0,1";
				$emailExistantUser = $db->loadResult($query);

				// check que le pseudo n'est pas d&eacute;j&agrave; r&eacute;serv&eacute; par un autre utilisateur (en cours d'inscription), max 1 heure de r&eacute;servation
				$query = "SELECT email FROM user_inscription WHERE email LIKE '".JL::getSession('email', '', true)."' AND id_tmp NOT LIKE '".JL::getSession('id_tmp', '')."' AND (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(reservation_date)) < 3600 LIMIT 0,1";
				$emailExistantTmp = $db->loadResult($query);

				// pseudo d&eacute;j&agrave; pris
				if($emailExistantUser || $emailExistantTmp) {
					$messages[]	= '<span class="error">'.$lang_appprofil["CetEmailEstDeja"].'.</span>';
				}

				// si l'email et le pseudo sont dispo
				if(!$pseudoExistantUser && !$pseudoExistantTmp && !$emailExistantUser && !$emailExistantTmp) {

					// efface la pr&eacute;c&eacute;dente r&eacute;servation de l'utilisateur au cas o&ugrave;
					$query = "DELETE FROM user_inscription WHERE username LIKE '".JL::getSession('username','',true)."' OR email LIKE '".JL::getSession('email','',true)."'";
					$db->query($query);


					// r&eacute;serve le pseudo et l'email
					$query = "INSERT INTO user_inscription SET "
					." username = '".JL::getSession('username', '', true)."',"
					." email = '".JL::getSession('email', '', true)."',"
					." id_tmp = '".JL::getSession('id_tmp', '')."',"
					." reservation_date = NOW()"
					;
					$db->query($query);

				}


				// valide l'&eacute;tape
				if(!isset($_SESSION['step_ok'])) {
					$_SESSION['step_ok']	= 1;
				}

			}

		}

		// retourne la liste des messages d'erreur
		return $messages;

	}


	function step2($messages = array()) {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// cr&eacute;e le dossier d'upload temporaire
		JL::makeUploadDir();


		// donn&eacute;es de l'&eacute;tape + valeurs par d&eacute;faut
		$_data					= step2_data();
		$row					= array();
		$list					= array();


		// utilisateur log
		if($user->id) {

			// r&eacute;cup les donn&eacute;es en db
			$query = "SELECT photo_defaut, photo_home"
			." FROM user_profil"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$obj = $db->loadObject($query);

			// mise en session des valeurs
			JL::setSession('photo_defaut', $obj->photo_defaut);
			JL::setSession('photo_home', $obj->photo_home);

		}


		// r&eacute;cup les champs correspondant en session, sinon valeur par d&eacute;faut
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}


		// si l'user est log
		if($user->id) {

			// supprime les fichiers temporaires de son r&eacute;pertoire de photos
			$dest_dossier = 'images/profil/'.$user->id;
			if(is_dir($dest_dossier)) {
				$dir_id 	= opendir($dest_dossier);
				while($file = trim(readdir($dir_id))) {
					if(preg_match('#^temp#', $file)) {
						unlink($dest_dossier.'/'.$file);
					}
				}
			}

		}

		// r&eacute;cup le texte de gauche pendant l'inscription
		$notice = getNotice(2);

		HTML_profil::step2($row, $list, $messages, $notice);

	}

	function step2_data() {
		global $langue;
		$_data	= array(
			'photo_defaut' => 1,
			'photo_home' => 1
		);
		return $_data;
	}

	function step2submit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn&eacute;es &agrave; r&eacute;cup de l'&eacute;tape pr&eacute;c&eacute;dente + valeur par d&eacute;faut
		$_data	= step2_data();

		if(count($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// sauvegarde les photos
				photosSave('profil');


				// enregistre les modifs en DB
				$query = "UPDATE user_profil SET"
				." photo_home = '".JL::getSessionInt('photo_home', 1)."'"
				." WHERE user_id = '".$user->id."'"
				;
				$db->query($query);


				// &agrave; laisser que l'user soit log ou pas, m&ecirc;me si on affiche pas le message (utile dans le swtich case sur $action
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].'!</span>';

			} else { // user non log

				// valide l'&eacute;tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 2) {
					$_SESSION['step_ok']	= 2;
				}

			}

		}

		// retourne la liste des messages d'erreur
		return $messages;

	}


	function step3($messages = array()) {
		global $langue;
		global $db, $user;

		// donn&eacute;es de l'&eacute;tape + valeurs par d&eacute;faut
		$_data						= step3_data();
		$row						= array();
		$list						= array();


		// utilisateur log et aucun message pr&eacute;sent
		if($user->id && !count($messages)) {

			// r&eacute;cup les donn&eacute;es en db
			$query = "SELECT annonce, published"
			." FROM user_annonce"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$annonce = $db->loadObject($query);

			// mise en session de la valeur
			JL::setSession('annonce', $annonce->annonce);
			JL::setSession('published', $annonce->published);

		}


		// r&eacute;cup les champs correspondant en session, sinon valeur par d&eacute;faut
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}

		// r&eacute;cup le texte de gauche pendant l'inscription
		$notice = getNotice(3);

		HTML_profil::step3($row, $list, $messages, $notice);

	}

	function step3_data() {
		global $langue;
		$_data	= array(
				'annonce' => '',
				'published' => 2
			);
		return $_data;
	}

	function step3submit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn&eacute;es &agrave; r&eacute;cup de l'&eacute;tape pr&eacute;c&eacute;dente + valeur par d&eacute;faut
		$_data	= step3_data();

		if(count($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}


		// si l'annonce (sans retours &agrave; la ligne) d&eacute;passe les 2000 caract&egrave;res
		if(strlen(str_replace("\n",'',JL::getSession('annonce', '', false))) > 2000) {

			// on tronque
			JL::setSession('annonce', substr(0, 2000, JL::getSession('annonce', '', false)));

		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// r&eacute;cup l'annonce existante
				$query = "SELECT annonce FROM user_annonce WHERE user_id = '".$user->id."' LIMIT 0,1";
				$annonce = $db->loadResult($query);

				// si l'annonce r&eacute;dig&eacute;e est diff&eacute;rente de l'ancienne
				if(strcmp($annonce, JL::getSession('annonce', ''))) {

					// enregistre les modifs en DB (certains champs ne sont pas mis &agrave; jour volontairement ==> s&eacute;curit&eacute; oblige !)
					$query = "UPDATE user_annonce SET"
					." annonce = '".JL::getSession('annonce', '', true)."',"
					." published = 2"
					." WHERE user_id = '".$user->id."'"
					;
					$db->query($query);

					// &agrave; laisser que l'user soit log ou pas, m&ecirc;me si on affiche pas le message (utile dans le swtich case sur $action
					$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

				} else {

					// &agrave; laisser que l'user soit log ou pas, m&ecirc;me si on affiche pas le message (utile dans le swtich case sur $action
					$messages[]	= '<span class="warning">'.$lang_appprofil["AucuneModificationEnregistrees"].' !</span>';

				}


			} else { // user non log

				// valide l'&eacute;tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 3) {
					$_SESSION['step_ok']	= 3;
				}

			}

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}


	function step4($messages = array()) {
		global $langue,$langString;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// donn&eacute;es de l'&eacute;tape + valeurs par d&eacute;faut
		$_data						= step4_data();
		$row						= array();
		$list						= array();
		$list_signe_astrologique_id	= array();
		$list_taille_id				= array();
		$list_poids_id				= array();
		$list_silhouette_id			= array();
		$list_style_coiffure_id		= array();
		$list_cheveux_id			= array();
		$list_yeux_id				= array();
		$list_origine_id			= array();


		// utilisateur log et aucun message pr&eacute;sent
		if($user->id && !count($messages)) {

			// r&eacute;cup les donn&eacute;es en db
			$query = "SELECT signe_astrologique_id, taille_id, poids_id, silhouette_id, style_coiffure_id, cheveux_id, yeux_id, origine_id"
			." FROM user_profil"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$tmp = $db->loadResultArray($query);

			// mise en session des valeurs
			foreach($tmp as $key => $value) {
				JL::setSession($key, $tmp[$key]);
			}

		}


		// r&eacute;cup les champs correspondant en session, sinon valeur par d&eacute;faut
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}


		// signe astrologique
		$list_signe_astrologique_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"]);
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_signe_astrologique$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_signe_astrologique_id = array_merge($list_signe_astrologique_id, $db->loadObjectList($query));
		$list['signe_astrologique_id'] = JL::makeSelectList( $list_signe_astrologique_id, 'signe_astrologique_id', 'class="select_profil"', 'value', 'text', $row['signe_astrologique_id']);

		// taille
		$list_taille_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		for($i=140; $i<=200; $i++) {
			$list_taille_id[] = JL::makeOption($i, $i.'cm');
		}

		$list['taille_id'] = JL::makeSelectList( $list_taille_id, 'taille_id', 'class="select_profil"', 'value', 'text', $row['taille_id']);

		// poids
		$list_poids_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		for($i=40; $i<=120; $i++) {
			$list_poids_id[] = JL::makeOption($i, $i.'kg');
		}

		$list['poids_id'] = JL::makeSelectList( $list_poids_id, 'poids_id', 'class="select_profil"', 'value', 'text', $row['poids_id']);

		// silhouette
		$list_silhouette_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_silhouette$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_silhouette_id = array_merge($list_silhouette_id, $db->loadObjectList($query));
		$list['silhouette_id'] = JL::makeSelectList( $list_silhouette_id, 'silhouette_id', 'class="select_profil"', 'value', 'text', $row['silhouette_id']);

		// style coiffure
		$list_style_coiffure_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_style_coiffure$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_style_coiffure_id = array_merge($list_style_coiffure_id, $db->loadObjectList($query));
		$list['style_coiffure_id'] = JL::makeSelectList( $list_style_coiffure_id, 'style_coiffure_id', 'class="select_profil"', 'value', 'text', $row['style_coiffure_id']);

		// cheveux
		$list_cheveux_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_cheveux$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_cheveux_id = array_merge($list_cheveux_id, $db->loadObjectList($query));
		$list['cheveux_id'] = JL::makeSelectList( $list_cheveux_id, 'cheveux_id', 'class="select_profil"', 'value', 'text', $row['cheveux_id']);

		// yeux
		$list_yeux_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_yeux$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_yeux_id = array_merge($list_yeux_id, $db->loadObjectList($query));
		$list['yeux_id'] = JL::makeSelectList( $list_yeux_id, 'yeux_id', 'class="select_profil"', 'value', 'text', $row['yeux_id']);

		// origine
		$list_origine_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_origine$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_origine_id = array_merge($list_origine_id, $db->loadObjectList($query));
		$list['origine_id'] = JL::makeSelectList( $list_origine_id, 'origine_id', 'class="select_profil"', 'value', 'text', $row['origine_id']);

		// r&eacute;cup le texte de gauche pendant l'inscription
		$notice = getNotice(4);

		HTML_profil::step4($row, $list, $messages, $notice);

	}

	function step4_data() {
		global $langue;
		$_data	= array(
			'signe_astrologique_id' => 0,
			'taille_id' => 0,
			'poids_id' => 0,
			'silhouette_id' => 0,
			'style_coiffure_id' => 0,
			'cheveux_id' => 0,
			'yeux_id' => 0,
			'origine_id' => 0
		);
		return $_data;
	}

	function step4submit() {
		include("lang/app_profil.".$_GET['lang'].".php");
		global $langue;
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn&eacute;es &agrave; r&eacute;cup de l'&eacute;tape pr&eacute;c&eacute;dente + valeur par d&eacute;faut
		$_data	= step4_data();

		if(count($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// enregistre les modifs en DB (certains champs ne sont pas mis &agrave; jour volontairement ==> s&eacute;curit&eacute; oblige !)
				$query = "UPDATE user_profil SET"
				." signe_astrologique_id = '".JL::getSessionInt('signe_astrologique_id', 0)."',"
				." taille_id = '".JL::getSessionInt('taille_id', 0)."',"
				." poids_id = '".JL::getSessionInt('poids_id', 0)."',"
				." silhouette_id = '".JL::getSessionInt('silhouette_id', 0)."',"
				." style_coiffure_id = '".JL::getSessionInt('style_coiffure_id', 0)."',"
				." cheveux_id = '".JL::getSessionInt('cheveux_id', 0)."',"
				." yeux_id = '".JL::getSessionInt('yeux_id', 0)."',"
				." origine_id = '".JL::getSessionInt('origine_id', 0)."'"
				." WHERE user_id = '".$user->id."'"
				;
				$db->query($query);

				// &agrave; laisser que l'user soit log ou pas, m&ecirc;me si on affiche pas le message (utile dans le swtich case sur $action
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

			} else { // user non log

				// valide l'&eacute;tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 4) {
					$_SESSION['step_ok']	= 4;
				}

			}

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}


	function step5($messages = array()) {
		global $langue,$langString;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// donn&eacute;es de l'&eacute;tape + valeurs par d&eacute;faut
		$_data						= step5_data();
		$row						= array();
		$list						= array();
		$list_nationalite_id 		= array();
		$list_religion_id 			= array();
		$list_langue1_id 			= array();
		$list_langue2_id 			= array();
		$list_langue3_id 			= array();
		$list_statut_marital_id 	= array();
		$list_me_marier_id 			= array();
		$list_cherche_relation_id 	= array();
		$list_niveau_etude_id 		= array();
		$list_secteur_activite_id 	= array();
		$list_fumer_id 				= array();
		$list_temperament_id 		= array();
		$list_vouloir_enfants_id 	= array();
		$list_garde_id 				= array();


		// utilisateur log et aucun message pr&eacute;sent
		if($user->id && !count($messages)) {

			// r&eacute;cup les donn&eacute;es en db
			$query = "SELECT nationalite_id, religion_id, langue1_id, langue2_id, langue3_id, statut_marital_id, me_marier_id, cherche_relation_id, niveau_etude_id, secteur_activite_id, fumer_id, temperament_id, vouloir_enfants_id, garde_id"
			." FROM user_profil"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$tmp = $db->loadResultArray($query);

			// mise en session des valeurs
			foreach($tmp as $key => $value) {
				JL::setSession($key, $tmp[$key]);
			}

		}


		// r&eacute;cup les champs correspondant en session, sinon valeur par d&eacute;faut
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}

		// nationalit&eacute;
		$list_nationalite_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_nationalite$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_nationalite_id = array_merge($list_nationalite_id, $db->loadObjectList($query));
		$list['nationalite_id'] = JL::makeSelectList( $list_nationalite_id, 'nationalite_id', 'class="select_profil"', 'value', 'text', $row['nationalite_id']);

		// religion
		$list_religion_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_religion$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_religion_id = array_merge($list_religion_id, $db->loadObjectList($query));
		$list['religion_id'] = JL::makeSelectList( $list_religion_id, 'religion_id', 'class="select_profil"', 'value', 'text', $row['religion_id']);

		// langues
		$list_langue_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_langue$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_langue_id = array_merge($list_langue_id, $db->loadObjectList($query));
		$list['langue1_id'] = JL::makeSelectList( $list_langue_id, 'langue1_id', 'class="select_profil100"', 'value', 'text', $row['langue1_id']);
		$list['langue2_id'] = JL::makeSelectList( $list_langue_id, 'langue2_id', 'class="select_profil100"', 'value', 'text', $row['langue2_id']);
		$list['langue3_id'] = JL::makeSelectList( $list_langue_id, 'langue3_id', 'class="select_profil100"', 'value', 'text', $row['langue3_id']);

		// statut marital
		$list_statut_marital_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_statut_marital$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_statut_marital_id = array_merge($list_statut_marital_id, $db->loadObjectList($query));
		$list['statut_marital_id'] = JL::makeSelectList( $list_statut_marital_id, 'statut_marital_id', 'class="select_profil"', 'value', 'text', $row['statut_marital_id']);

		// me marier c'est...
		$list_me_marier_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_me_marier$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_me_marier_id = array_merge($list_me_marier_id, $db->loadObjectList($query));
		$list['me_marier_id'] = JL::makeSelectList( $list_me_marier_id, 'me_marier_id', 'class="select_profil"', 'value', 'text', $row['me_marier_id']);

		// je cherche une relation
		$list_cherche_relation_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_cherche_relation$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_cherche_relation_id = array_merge($list_cherche_relation_id, $db->loadObjectList($query));
		$list['cherche_relation_id'] = JL::makeSelectList( $list_cherche_relation_id, 'cherche_relation_id', 'class="select_profil"', 'value', 'text', $row['cherche_relation_id']);

		// niveau d'&eacute;tudes
		$list_niveau_etude_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_niveau_etude$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_niveau_etude_id = array_merge($list_niveau_etude_id, $db->loadObjectList($query));
		$list['niveau_etude_id'] = JL::makeSelectList( $list_niveau_etude_id, 'niveau_etude_id', 'class="select_profil"', 'value', 'text', $row['niveau_etude_id']);

		// secteur d'activit&eacute;
		$list_secteur_activite_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_secteur_activite$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_secteur_activite_id = array_merge($list_secteur_activite_id, $db->loadObjectList($query));
		$list['secteur_activite_id'] = JL::makeSelectList( $list_secteur_activite_id, 'secteur_activite_id', 'class="select_profil"', 'value', 'text', $row['secteur_activite_id']);

		// je fume
		$list_fumer_id[] = JL::makeOption('0', '» Je le garde pour moi');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_fumer$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_fumer_id = array_merge($list_fumer_id, $db->loadObjectList($query));
		$list['fumer_id'] = JL::makeSelectList( $list_fumer_id, 'fumer_id', 'class="select_profil"', 'value', 'text', $row['fumer_id']);

		// temp&eacute;rament
		$list_temperament_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_temperament$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_temperament_id = array_merge($list_temperament_id, $db->loadObjectList($query));
		$list['temperament_id'] = JL::makeSelectList( $list_temperament_id, 'temperament_id', 'class="select_profil"', 'value', 'text', $row['temperament_id']);

		// veux des enfants
		$list_vouloir_enfants_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_vouloir_enfants$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_vouloir_enfants_id = array_merge($list_vouloir_enfants_id, $db->loadObjectList($query));
		$list['vouloir_enfants_id'] = JL::makeSelectList( $list_vouloir_enfants_id, 'vouloir_enfants_id', 'class="select_profil"', 'value', 'text', $row['vouloir_enfants_id']);

		// qui a la garde ?
		$list_garde_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_garde$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_garde_id = array_merge($list_garde_id, $db->loadObjectList($query));
		$list['garde_id'] = JL::makeSelectList( $list_garde_id, 'garde_id', 'class="select_profil"', 'value', 'text', $row['garde_id']);

		// r&eacute;cup le texte de gauche pendant l'inscription
		$notice = getNotice(5);

		HTML_profil::step5($row, $list, $messages, $notice);

	}

	function step5_data() {
		global $langue;
		$_data	= array(
			'nationalite_id' => 0,
			'religion_id' => 0,
			'langue1_id' => 0,
			'langue2_id' => 0,
			'langue3_id' => 0,
			'statut_marital_id' => 0,
			'me_marier_id' => 0,
			'cherche_relation_id' => 0,
			'niveau_etude_id' => 0,
			'secteur_activite_id' => 0,
			'fumer_id' => 0,
			'temperament_id' => 0,
			'vouloir_enfants_id' => 0,
			'garde_id' => 0
		);
		return $_data;
	}

	function step5submit() {
		include("lang/app_profil.".$_GET['lang'].".php");
		global $langue;
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn&eacute;es &agrave; r&eacute;cup de l'&eacute;tape pr&eacute;c&eacute;dente + valeur par d&eacute;faut
		$_data	= step5_data();

		if(count($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// enregistre les modifs en DB (certains champs ne sont pas mis &agrave; jour volontairement ==> s&eacute;curit&eacute; oblige !)
				$query = "UPDATE user_profil SET"
				." nationalite_id = '".JL::getSessionInt('nationalite_id', 0)."',"
				." religion_id = '".JL::getSessionInt('religion_id', 0)."',"
				." langue1_id = '".JL::getSessionInt('langue1_id', 0)."',"
				." langue2_id = '".JL::getSessionInt('langue2_id', 0)."',"
				." langue3_id = '".JL::getSessionInt('langue3_id', 0)."',"
				." statut_marital_id = '".JL::getSessionInt('statut_marital_id', 0)."',"
				." me_marier_id = '".JL::getSessionInt('me_marier_id', 0)."',"
				." cherche_relation_id = '".JL::getSessionInt('cherche_relation_id', 0)."',"
				." niveau_etude_id = '".JL::getSessionInt('niveau_etude_id', 0)."',"
				." secteur_activite_id = '".JL::getSessionInt('secteur_activite_id', 0)."',"
				." fumer_id = '".JL::getSessionInt('fumer_id', 0)."',"
				." temperament_id = '".JL::getSessionInt('temperament_id', 0)."',"
				." vouloir_enfants_id = '".JL::getSessionInt('vouloir_enfants_id', 0)."',"
				." garde_id = '".JL::getSessionInt('garde_id', 0)."'"
				." WHERE user_id = '".$user->id."'"
				;
				$db->query($query);

				// &agrave; laisser que l'user soit log ou pas, m&ecirc;me si on affiche pas le message (utile dans le swtich case sur $action
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

			} else { // user non log

				// valide l'&eacute;tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 5) {
					$_SESSION['step_ok']	= 5;
				}

			}

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}


	function step6($messages = array()) {
		global $langue,$langString;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// donn&eacute;es de l'&eacute;tape + valeurs par d&eacute;faut
		$_data						= step6_data();
		$row						= array();
		$list						= array();
		$list_vie_id 				= array();
		$list_cuisine_id 			= array();
		$list_sortie_id 			= array();
		$list_loisir_id 			= array();
		$list_sport_id 				= array();
		$list_musique_id 			= array();
		$list_film_id 				= array();
		$list_lecture_id 			= array();
		$list_animaux_id 			= array();


		// utilisateur log et aucun message pr&eacute;sent
		if($user->id && !count($messages)) {

			// r&eacute;cup les donn&eacute;es en db
			$query = "SELECT vie_id, cuisine1_id, cuisine2_id, cuisine3_id, sortie1_id, sortie2_id, sortie3_id, loisir1_id, loisir2_id, loisir3_id, sport1_id, sport2_id, sport3_id, musique1_id, musique2_id, musique3_id, film1_id, film2_id, film3_id, lecture1_id, lecture2_id, lecture3_id, animaux1_id, animaux2_id, animaux3_id"
			." FROM user_profil"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$tmp = $db->loadResultArray($query);

			// mise en session des valeurs
			foreach($tmp as $key => $value) {
				JL::setSession($key, $tmp[$key]);
			}

		}


		// r&eacute;cup les champs correspondant en session, sinon valeur par d&eacute;faut
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}


		// style de vie
		$list_vie_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_vie$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_vie_id = array_merge($list_vie_id, $db->loadObjectList($query));
		$list['vie_id'] = JL::makeSelectList( $list_vie_id, 'vie_id', 'class="select_profil"', 'value', 'text', $row['vie_id']);


		// cuisine
		$list_cuisine_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_cuisine$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_cuisine_id = array_merge($list_cuisine_id, $db->loadObjectList($query));
		$list['cuisine1_id'] = JL::makeSelectList( $list_cuisine_id, 'cuisine1_id', 'class="select_profil100"', 'value', 'text', $row['cuisine1_id']);
		$list['cuisine2_id'] = JL::makeSelectList( $list_cuisine_id, 'cuisine2_id', 'class="select_profil100"', 'value', 'text', $row['cuisine2_id']);
		$list['cuisine3_id'] = JL::makeSelectList( $list_cuisine_id, 'cuisine3_id', 'class="select_profil100"', 'value', 'text', $row['cuisine3_id']);


		// sortie
		$list_sortie_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_sortie$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_sortie_id = array_merge($list_sortie_id, $db->loadObjectList($query));
		$list['sortie1_id'] = JL::makeSelectList( $list_sortie_id, 'sortie1_id', 'class="select_profil100"', 'value', 'text', $row['sortie1_id']);
		$list['sortie2_id'] = JL::makeSelectList( $list_sortie_id, 'sortie2_id', 'class="select_profil100"', 'value', 'text', $row['sortie2_id']);
		$list['sortie3_id'] = JL::makeSelectList( $list_sortie_id, 'sortie3_id', 'class="select_profil100"', 'value', 'text', $row['sortie3_id']);


		// loisir
		$list_loisir_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_loisir$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_loisir_id = array_merge($list_loisir_id, $db->loadObjectList($query));
		$list['loisir1_id'] = JL::makeSelectList( $list_loisir_id, 'loisir1_id', 'class="select_profil100"', 'value', 'text', $row['loisir1_id']);
		$list['loisir2_id'] = JL::makeSelectList( $list_loisir_id, 'loisir2_id', 'class="select_profil100"', 'value', 'text', $row['loisir2_id']);
		$list['loisir3_id'] = JL::makeSelectList( $list_loisir_id, 'loisir3_id', 'class="select_profil100"', 'value', 'text', $row['loisir3_id']);


		// sport
		$list_sport_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_sport$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_sport_id = array_merge($list_sport_id, $db->loadObjectList($query));
		$list['sport1_id'] = JL::makeSelectList( $list_sport_id, 'sport1_id', 'class="select_profil100"', 'value', 'text', $row['sport1_id']);
		$list['sport2_id'] = JL::makeSelectList( $list_sport_id, 'sport2_id', 'class="select_profil100"', 'value', 'text', $row['sport2_id']);
		$list['sport3_id'] = JL::makeSelectList( $list_sport_id, 'sport3_id', 'class="select_profil100"', 'value', 'text', $row['sport3_id']);


		// musique
		$list_musique_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_musique$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_musique_id = array_merge($list_musique_id, $db->loadObjectList($query));
		$list['musique1_id'] = JL::makeSelectList( $list_musique_id, 'musique1_id', 'class="select_profil100"', 'value', 'text', $row['musique1_id']);
		$list['musique2_id'] = JL::makeSelectList( $list_musique_id, 'musique2_id', 'class="select_profil100"', 'value', 'text', $row['musique2_id']);
		$list['musique3_id'] = JL::makeSelectList( $list_musique_id, 'musique3_id', 'class="select_profil100"', 'value', 'text', $row['musique3_id']);


		// film
		$list_film_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_film$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_film_id = array_merge($list_film_id, $db->loadObjectList($query));
		$list['film1_id'] = JL::makeSelectList( $list_film_id, 'film1_id', 'class="select_profil100"', 'value', 'text', $row['film1_id']);
		$list['film2_id'] = JL::makeSelectList( $list_film_id, 'film2_id', 'class="select_profil100"', 'value', 'text', $row['film2_id']);
		$list['film3_id'] = JL::makeSelectList( $list_film_id, 'film3_id', 'class="select_profil100"', 'value', 'text', $row['film3_id']);


		// lecture
		$list_lecture_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_lecture$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_lecture_id = array_merge($list_lecture_id, $db->loadObjectList($query));
		$list['lecture1_id'] = JL::makeSelectList( $list_lecture_id, 'lecture1_id', 'class="select_profil100"', 'value', 'text', $row['lecture1_id']);
		$list['lecture2_id'] = JL::makeSelectList( $list_lecture_id, 'lecture2_id', 'class="select_profil100"', 'value', 'text', $row['lecture2_id']);
		$list['lecture3_id'] = JL::makeSelectList( $list_lecture_id, 'lecture3_id', 'class="select_profil100"', 'value', 'text', $row['lecture3_id']);


		// animaux
		$list_animaux_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_animaux$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;

		$list_animaux_id = array_merge($list_animaux_id, $db->loadObjectList($query));
		$list['animaux1_id'] = JL::makeSelectList( $list_animaux_id, 'animaux1_id', 'class="select_profil100"', 'value', 'text', $row['animaux1_id']);
		$list['animaux2_id'] = JL::makeSelectList( $list_animaux_id, 'animaux2_id', 'class="select_profil100"', 'value', 'text', $row['animaux2_id']);
		$list['animaux3_id'] = JL::makeSelectList( $list_animaux_id, 'animaux3_id', 'class="select_profil100"', 'value', 'text', $row['animaux3_id']);


		// r&eacute;cup le texte de gauche pendant l'inscription
		$notice = getNotice(6);

		HTML_profil::step6($row, $list, $messages, $notice);

	}

	function step6_data() {
		global $langue;
		$_data	= array(
			'vie_id' => 0,			// profil_vie
			'cuisine1_id' => 0,		// profil_cuisine
			'cuisine2_id' => 0,
			'cuisine3_id' => 0,
			'sortie1_id' => 0,		// profil_sortie
			'sortie2_id' => 0,
			'sortie3_id' => 0,
			'loisir1_id' => 0,		// profil_loisir
			'loisir2_id' => 0,
			'loisir3_id' => 0,
			'sport1_id' => 0,		// profil_sport
			'sport2_id' => 0,
			'sport3_id' => 0,
			'musique1_id' => 0,		// profil_musique
			'musique2_id' => 0,
			'musique3_id' => 0,
			'film1_id' => 0,		// profil_film
			'film2_id' => 0,
			'film3_id' => 0,
			'lecture1_id' => 0,		// profil_lecture
			'lecture2_id' => 0,
			'lecture3_id' => 0,
			'animaux1_id' => 0,		// profil_animaux
			'animaux2_id' => 0,
			'animaux3_id' => 0
		);
		return $_data;
	}

	function step6submit() {
		include("lang/app_profil.".$_GET['lang'].".php");
		global $langue;
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn&eacute;es &agrave; r&eacute;cup de l'&eacute;tape pr&eacute;c&eacute;dente + valeur par d&eacute;faut
		$_data	= step6_data();

		if(count($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// enregistre les modifs en DB (certains champs ne sont pas mis &agrave; jour volontairement ==> s&eacute;curit&eacute; oblige !)
				$query = "UPDATE user_profil SET"
				." vie_id = '".JL::getSessionInt('vie_id', 0)."',"
				." cuisine1_id = '".JL::getSessionInt('cuisine1_id', 0)."',"
				." cuisine2_id = '".JL::getSessionInt('cuisine2_id', 0)."',"
				." cuisine3_id = '".JL::getSessionInt('cuisine3_id', 0)."',"
				." sortie1_id = '".JL::getSessionInt('sortie1_id', 0)."',"
				." sortie2_id = '".JL::getSessionInt('sortie2_id', 0)."',"
				." sortie3_id = '".JL::getSessionInt('sortie3_id', 0)."',"
				." loisir1_id = '".JL::getSessionInt('loisir1_id', 0)."',"
				." loisir2_id = '".JL::getSessionInt('loisir2_id', 0)."',"
				." loisir3_id = '".JL::getSessionInt('loisir3_id', 0)."',"
				." sport1_id = '".JL::getSessionInt('sport1_id', 0)."',"
				." sport2_id = '".JL::getSessionInt('sport2_id', 0)."',"
				." sport3_id = '".JL::getSessionInt('sport3_id', 0)."',"
				." musique1_id = '".JL::getSessionInt('musique1_id', 0)."',"
				." musique2_id = '".JL::getSessionInt('musique2_id', 0)."',"
				." musique3_id = '".JL::getSessionInt('musique3_id', 0)."',"
				." film1_id = '".JL::getSessionInt('film1_id', 0)."',"
				." film2_id = '".JL::getSessionInt('film2_id', 0)."',"
				." film3_id = '".JL::getSessionInt('film3_id', 0)."',"
				." lecture1_id = '".JL::getSessionInt('lecture1_id', 0)."',"
				." lecture2_id = '".JL::getSessionInt('lecture2_id', 0)."',"
				." lecture3_id = '".JL::getSessionInt('lecture3_id', 0)."',"
				." animaux1_id = '".JL::getSessionInt('animaux1_id', 0)."',"
				." animaux2_id = '".JL::getSessionInt('animaux2_id', 0)."',"
				." animaux3_id = '".JL::getSessionInt('animaux3_id', 0)."'"
				." WHERE user_id = '".$user->id."'"
				;
				$db->query($query);

				// &agrave; laisser que l'user soit log ou pas, m&ecirc;me si on affiche pas le message (utile dans le swtich case sur $action
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

			} else { // user non log

				// valide l'&eacute;tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 6) {
					$_SESSION['step_ok']	= 6;
				}

			}

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}


	function step7($messages = array()) {
		global $langue,$langString;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user, $action;


		// cr&eacute;e le dossier d'uplaod temporaire
		JL::makeUploadDir();


		// si l'user est log et arrive sur l'&eacute;tape 7 (ne prend donc pas le step7submit)
		if($user->id && $action == 'step7') {

			// supprime les fichiers temporaires de son r&eacute;pertoire de photos
			$dest_dossier = 'images/profil/'.$user->id;
			if(is_dir($dest_dossier)) {
				$dir_id 	= opendir($dest_dossier);
				while($file = trim(readdir($dir_id))) {
					if(preg_match('#^temp#', $file)) {
						unlink($dest_dossier.'/'.$file);
					}
				}
			}

		}


		// donn&eacute;es de l'&eacute;tape + valeurs par d&eacute;faut
		$_data						= step7_data();
		$row						= array();
		$list						= array();
		$list_genre					= array();
		$list_naissance_jour		= array();
		$list_naissance_mois		= array();
		$list_naissance_annee		= array();
		$list_signe_astrologique_id	= array();


		// utilisateur log et aucun message pr&eacute;sent
		if($user->id && !count($messages)) {

			// r&eacute;cup les donn&eacute;es en db
			$query = "SELECT num, naissance_date, signe_astrologique_id, genre"
			." FROM user_enfant"
			." WHERE user_id = '".$user->id."'"
			." ORDER BY num ASC"
			." LIMIT 0,6"
			;
			$tmps = $db->loadObjectList($query);

			// mise en session des valeurs
			if(count($tmps)) {
				foreach($tmps as $tmp) {

					// extrait les valeurs de la date de naissance
					$naissance_date	= explode('-', $tmp->naissance_date);
					$tmp->naissance_annee 	= $naissance_date[0];
					$tmp->naissance_mois 	= $naissance_date[1];
					$tmp->naissance_jour 	= $naissance_date[2];

					JL::setSession('child'.$tmp->num, 1);
					JL::setSession('naissance_jour'.$tmp->num, $tmp->naissance_jour);
					JL::setSession('naissance_mois'.$tmp->num, $tmp->naissance_mois);
					JL::setSession('naissance_annee'.$tmp->num, $tmp->naissance_annee);
					JL::setSession('genre'.$tmp->num, $tmp->genre);
					JL::setSession('signe_astrologique'.$tmp->num.'_id', $tmp->signe_astrologique_id);

				}
			}

			// r&eacute;cup la valeur de photo_montrer
			$query = "SELECT photo_montrer FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
			$photo_montrer = $db->loadResult($query);
			JL::setSession('photo_montrer', $photo_montrer);

		}


		// r&eacute;cup les champs correspondant en session, sinon valeur par d&eacute;faut
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}


		// gar&ccedil;on / fille
		$list_genre[] = JL::makeOption('', '» '.$lang_appprofil["Choisissez"].'');
		$list_genre[] = JL::makeOption('f', ''.$lang_appprofil["UneFille"].'');
		$list_genre[] = JL::makeOption('g', ''.$lang_appprofil["UnGarcon"].'');


		// jour de naissance
		$list_naissance_jour[] = JL::makeOption('0', '» '.$lang_appprofil["Jour"].'');
		for($i=1; $i<=31; $i++) {
			$list_naissance_jour[] = JL::makeOption($i, sprintf('%02d', $i));
		}


		// mois de naissance
		$list_naissance_mois[] = JL::makeOption('0', '» '.$lang_appprofil["Mois"].'');
		for($i=1; $i<=12; $i++) {
			$list_naissance_mois[] = JL::makeOption($i, sprintf('%02d', $i));
		}


		// ann&eacute;e de naissance
		$list_naissance_annee[] = JL::makeOption('0', '» '.$lang_appprofil["Annee"].'');
		for($i=intval(date('Y')); $i>=1950; $i--) {
			$list_naissance_annee[] = JL::makeOption($i, sprintf('%04d', $i));
		}


		// signe astrologique
		$list_signe_astrologique_id[] = JL::makeOption('0', '» '.$lang_appprofil["JeLeGardePourMois"].'');

		$query = "SELECT id AS value, nom AS text"
		." FROM profil_signe_astrologique$langString"
		." WHERE published = 1"
		." ORDER BY nom ASC"
		;
		$list_signe_astrologique_id = array_merge($list_signe_astrologique_id, $db->loadObjectList($query));


		// cr&eacute;ations des 6 sets de listes d&eacute;roulantes
		for($i=1; $i<=6; $i++) {
			$list['genre'.$i] 						= JL::makeSelectList( $list_genre, 'genre'.$i, 'class="select_profil"', 'value', 'text', $row['genre'.$i]);
			$list['naissance_jour'.$i] 				= JL::makeSelectList( $list_naissance_jour, 'naissance_jour'.$i, '', 'value', 'text', $row['naissance_jour'.$i]);
			$list['naissance_mois'.$i] 				= JL::makeSelectList( $list_naissance_mois, 'naissance_mois'.$i, '', 'value', 'text', $row['naissance_mois'.$i]);
			$list['naissance_annee'.$i] 			= JL::makeSelectList( $list_naissance_annee, 'naissance_annee'.$i, '', 'value', 'text', $row['naissance_annee'.$i]);
			$list['signe_astrologique'.$i.'_id'] 	= JL::makeSelectList( $list_signe_astrologique_id, 'signe_astrologique'.$i.'_id', 'class="select_profil"', 'value', 'text', $row['signe_astrologique'.$i.'_id']);
		}


		// r&eacute;cup le texte de gauche pendant l'inscription
		$notice = getNotice(7);

		HTML_profil::step7($row, $list, $messages, $notice);

	}

	function step7_data() {
		global $langue;
		$_data	= array(
			'child1' => 1,
			'child2' => 0,
			'child3' => 0,
			'child4' => 0,
			'child5' => 0,
			'child6' => 0,
			'naissance_jour1' => 0,
			'naissance_jour2' => 0,
			'naissance_jour3' => 0,
			'naissance_jour4' => 0,
			'naissance_jour5' => 0,
			'naissance_jour6' => 0,
			'naissance_mois1' => 0,
			'naissance_mois2' => 0,
			'naissance_mois3' => 0,
			'naissance_mois4' => 0,
			'naissance_mois5' => 0,
			'naissance_mois6' => 0,
			'naissance_annee1' => 0,
			'naissance_annee2' => 0,
			'naissance_annee3' => 0,
			'naissance_annee4' => 0,
			'naissance_annee5' => 0,
			'naissance_annee6' => 0,
			'genre1' => '',
			'genre2' => '',
			'genre3' => '',
			'genre4' => '',
			'genre5' => '',
			'genre6' => '',
			'signe_astrologique1_id' => 0,
			'signe_astrologique2_id' => 0,
			'signe_astrologique3_id' => 0,
			'signe_astrologique4_id' => 0,
			'signe_astrologique5_id' => 0,
			'signe_astrologique6_id' => 0,
			'photo_montrer' => 2
		);
		return $_data;
	}

	function step7submit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn&eacute;es &agrave; r&eacute;cup de l'&eacute;tape pr&eacute;c&eacute;dente + valeur par d&eacute;faut
		$_data	= step7_data();

		if(count($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}


		// l'utilisateur doit au moins renseigner le premier enfant
		if(!JL::getSessionInt('child1', 0)) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VeuillezindiquerLeGenre"].'.</span>';
		}


		// v&eacute;rification des enfants
		for($i=1; $i<=6; $i++) {
			$child	= JL::getSessionInt('child'.$i, 0);
			if($child) {

				switch($i) {
					case 1:
						$enfant_num = ''.$lang_appprofil["Premier"].'';
					break;

					case 2:
						$enfant_num = ''.$lang_appprofil["Second"].'';
					break;

					case 3:
						$enfant_num = ''.$lang_appprofil["Troisieme"].'';
					break;

					case 4:
						$enfant_num = ''.$lang_appprofil["Qutrieme"].'';
					break;

					case 5:
						$enfant_num = ''.$lang_appprofil["Cinquieme"].'';
					break;

					case 6:
						$enfant_num = ''.$lang_appprofil["Sixieme"].'';
					break;

				}

				if(JL::getSession('genre'.$i, '', true) != 'f' && JL::getSession('genre'.$i, '', true) != 'g') {

					$messages[]	= '<span class="error">'.$lang_appprofil["VeuillezIndiquerLeGenre"].' '.$enfant_num.' '.$lang_appprofil["enfant_s"].'.</span>';

				}

				if((JL::getSessionInt('naissance_jour'.$i, 0) + JL::getSessionInt('naissance_mois'.$i, 0) + JL::getSessionInt('naissance_annee'.$i, 0) > 0) && in_array(0, array(JL::getSessionInt('naissance_jour'.$i, 0), JL::getSessionInt('naissance_mois'.$i, 0), JL::getSessionInt('naissance_annee'.$i, 0)))) {

					$messages[]	= '<span class="error">'.$lang_appprofil["VeuillezIndiquerLaDateNaissance"].' '.$enfant_num.' '.$lang_appprofil["enfant_s"].'.</span>';

				}

			}
		}

		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// sauvegarde les photos
				photosSave('enfant');

				// mise &agrave; jour des enfants
				for($i=1; $i<=6; $i++) {
					$child	= JL::getSessionInt('child'.$i, 0);

					// dans tous les cas, supprime l'ancien enregistrement (&eacute;vite un select puis test si insert ou update...)
					$query = "DELETE FROM user_enfant WHERE user_id = '".$user->id."' AND num = '".$i."'";
					$db->query($query);

					// si l'enfant a &eacute;t&eacute; ajout&eacute; par l'utilisateur
					if($child) {

						// ajoute l'enfant dans la db
						$query = "INSERT INTO user_enfant SET"
						." num = '".$i."',"
						." user_id = '".$user->id."',"
						." naissance_date = '".JL::getSessionInt('naissance_annee'.$i, 0)."-".JL::getSessionInt('naissance_mois'.$i, 0)."-".JL::getSessionInt('naissance_jour'.$i, 0)."',"
						." signe_astrologique_id = '".JL::getSessionInt('signe_astrologique'.$i.'_id', 0)."',"
						." genre = '".JL::getSession('genre'.$i, '', true)."'"
						;
						$db->query($query);

					} else {

						// supprime les photos car l'enfant n'est pas ou plus pr&eacute;sent dans la liste
						$dir 			= 'images/profil/'.JL::getSession('upload_dir', 'error');
						$file 			= $dir.'/parent-solo-109-enfant-'.$i.'.jpg';
						$file_pending 	= $dir.'/pending-parent-solo-109-enfant-'.$i.'.jpg';
						$file_temp 		= $dir.'/temp-parent-solo-109-enfant-'.$i.'.jpg';

						if(is_file($file)) {
							unlink($dir.'/parent-solo-109-enfant-'.$i.'.jpg');
							unlink($dir.'/parent-solo-35-enfant-'.$i.'.jpg');
							unlink($dir.'/parent-solo-enfant-'.$i.'.jpg');
						}
						if(is_file($file_pending)) {
							unlink($dir.'/pending-parent-solo-109-enfant-'.$i.'.jpg');
							unlink($dir.'/pending-parent-solo-35-enfant-'.$i.'.jpg');
							unlink($dir.'/pending-parent-solo-enfant-'.$i.'.jpg');
						}
						if(is_file($file_temp)) {
							unlink($dir.'/temp-parent-solo-109-enfant-'.$i.'.jpg');
							unlink($dir.'/temp-parent-solo-35-enfant-'.$i.'.jpg');
							unlink($dir.'/temp-parent-solo-enfant-'.$i.'.jpg');
						}

					}

				}


				// mise &agrave; jour du champ photo_montrer
				$photo_montrer = JL::getSessionInt('photo_montrer', 0);
				$query = "UPDATE user_profil SET photo_montrer = '".$photo_montrer."' WHERE user_id = '".$user->id."'";
				$db->query($query);


				// &agrave; laisser que l'user soit log ou pas, m&ecirc;me si on affiche pas le message (util dans le swtich case sur $action)
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

			} else { // user non log

				// valide l'&eacute;tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 7) {
					$_SESSION['step_ok']	= 7;
				}

			}

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}


	function step8($messages = array()) {
		global $langue, $langString;
		global $db, $user;

		// user log
		if($user->id) {

			// r&eacute;cup la recherche de l'utilisateur
			$query = "SELECT * FROM user_recherche WHERE user_id = '".$user->id."' ORDER BY id DESC LIMIT 0,1";
			$_data = $db->loadResultArray($query);

			// r&eacute;cup les champs correspondant en session, sinon valeur par d&eacute;faut
			if(is_array($_data)) {
				foreach($_data as $key => $value) {
					if($key != 'user_id' && $key != 'id' && $key != 'user_id_tmp') {
						JL::setSession($key, $value);
					}
				}
			}

		}

		// g&eacute;n&egrave;re le moteur de recherche avec les param&egrave;tres de recherche de l'utilisateur
		$list =& FCT::getSearchEngine(JL::getSession('search_nb_enfants', 0), JL::getSession('search_recherche_age_min', 18), JL::getSession('search_recherche_age_max', 70), JL::getSession('search_canton_id', 0), JL::getSession('search_ville_id', 0), JL::getSession('search_username', ''), JL::getSession('search_online', 0), JL::getSession('search_titre', '')); // todo: compl&eacute;ter les champs

		// r&eacute;cup le texte de gauche pendant l'inscription
		$notice = getNotice(8);

		// affiche le moteur de recherche
		HTML_profil::step8($list, $messages, $notice);

	}

	function step8_data() {
		global $langue;
		$_data	= array();
		return $_data;
	}

	function step8submit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $user;

		// gestion des messages d'erreurs
		$messages			= array();

		// donn&eacute;es &agrave; r&eacute;cup de l'&eacute;tape pr&eacute;c&eacute;dente + valeur par d&eacute;faut
		$_data	= step8_data();

		if(count($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// &agrave; laisser que l'user soit log ou pas, m&ecirc;me si on affiche pas le message (utile dans le swtich case sur $action)
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

			} else { // user non log

				// valide l'&eacute;tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 8) {
					$_SESSION['step_ok']	= 8;
				}

			}

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}


	function step9($messages = array()) {
		global $langue,$langString;
		global $db, $user;

		// donn&eacute;es de l'&eacute;tape + valeurs par d&eacute;faut
		$_data						= step9_data();
		$row						= array();
		$list						= array();


		// utilisateur log et aucun message pr&eacute;sent
		if($user->id && !count($messages)) {

			// r&eacute;cup les donn&eacute;es en db
			$query = "SELECT nom, prenom, telephone, adresse, code_postal"
			." FROM user_profil"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$userProfil = $db->loadObject($query);

			// mise en session de la valeur
			JL::setSession('nom', $userProfil->nom);
			JL::setSession('prenom', $userProfil->prenom);
			JL::setSession('telephone', $userProfil->telephone);
			JL::setSession('adresse', $userProfil->adresse);
			JL::setSession('code_postal', $userProfil->code_postal);

		}


		// r&eacute;cup les champs correspondant en session, sinon valeur par d&eacute;faut
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}

		// r&eacute;cup le message d'explication
		$query = "SELECT texte FROM contenu$langString WHERE id = 1 LIMIT 0,1";
		$row['disclaimer']	= $db->loadResult($query);

		// r&eacute;cup le texte de gauche pendant l'inscription
		$notice = getNotice(9);

		HTML_profil::step9($row, $list, $messages, $notice);

	}

	function step9_data() {
		global $langue;
		$_data	= array(
				'nom' 			=> '',
				'prenom' 		=> '',
				'telephone'	 	=> '',
				'adresse' 		=> '',
				'code_postal' 	=> ''
			);
		return $_data;
	}

	function step9submit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn&eacute;es &agrave; r&eacute;cup de l'&eacute;tape pr&eacute;c&eacute;dente + valeur par d&eacute;faut
		$_data	= step9_data();

		if(count($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}


		// t&eacute;l&eacute;phone
		if(strlen(JL::getSession('telephone', '', false)) == '') {
			$messages[]	= '<span class="error">'.$lang_appprofil["VeuillezNumTel"].'.</span>';
		}

		// pr&eacute;nom non renseign&eacute;
		if(strlen(JL::getSession('prenom', '', false)) == '') {
			$messages[]	= '<span class="error">'.$lang_appprofil["VeuillezPrenom"].'.</span>';
		}

		// nom non renseign&eacute;
		if(strlen(JL::getSession('nom', '', false)) == '') {
			$messages[]	= '<span class="error">'.$lang_appprofil["Veuilleznom"].'.</span>';
		}

		// adresse non renseign&eacute;
		if(strlen(JL::getSession('adresse', '', false)) == '') {
			$messages[]	= '<span class="error">'.$lang_appprofil["VeuillezAdresse"].'.</span>';
		}

		// code postal non renseign&eacute;
		if(strlen(JL::getSession('code_postal', '', false)) == '') {
			$messages[]	= '<span class="error">'.$lang_appprofil["VeuillezCodePostal"].'.</span>';
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// enregistre les modifs en DB (certains champs ne sont pas mis &agrave; jour volontairement ==> s&eacute;curit&eacute; oblige !)
				$query = "UPDATE user_profil SET"
				." nom = '".JL::getSession('nom', '', true)."',"
				." prenom = '".JL::getSession('prenom', '', true)."',"
				." telephone = '".JL::getSession('telephone', '', true)."',"
				." adresse = '".JL::getSession('adresse', '', true)."',"
				." code_postal = '".JL::getSession('code_postal', '', true)."'"
				." WHERE user_id = '".$user->id."'"
				;
				$db->query($query);

				// &agrave; laisser que l'user soit log ou pas, m&ecirc;me si on affiche pas le message (utile dans le swtich case sur $action
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

			} else { // user non log

				// valide l'&eacute;tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 9) {
					$_SESSION['step_ok']	= 9;
				}

			}

		} else {

			$messages[]	= '<span class="warning">'.$lang_appprofil["CesinformationSontDemandes"].'.</span>';
			$messages[]	= '<span class="warning">'.$lang_appprofil["EnCasDeDoute"].'.</span>';

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}


	function parrainage($messages = array()) {
		global $langue;
		global $db, $user, $action;

		// variables
		$row						= new stdClass();

		// initialise les donn&eacute;es
		$_data			=& parrainage_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = JL::getVar($key, $value);
			}
		}

		HTML_profil::parrainage($row, $messages);

	}

	function &parrainage_data() {
		global $langue;
		$_data	= array(
			'emails' 	=> '',
			'message' 	=> ''
		);
		return $_data;
	}


	function parrainagesubmit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages		= array();
		$row			= new stdClass();

		// initialise les donn&eacute;es
		$_data			=& parrainage_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = JL::getVar($key, $value);
			}
		}

		if(!$row->emails) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VeuillzAuMoinUnEmail"].'.</span>';
		}

		if(!$row->message) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VeuillzAuMoinUnMessage"].'.</span>';
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// variables locales
			$mailing_id = 1;
			$emails	= array();

			// parse la chaine d'emails
			$rows 	= preg_split("/[^A-Za-z0-9.@_\-]/", $row->emails);

			// charge le texte du mail
			$query = "SELECT titre, texte, template"
			." FROM mailing"
			." WHERE id = '".$db->escape($mailing_id)."'"
			." LIMIT 0,1"
			;
			$mailing = $db->loadObject($query);

			foreach($rows as $email) {

				// envoi du mail
				if(preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $email)) {

					// check si l'email n'est pas d&eacute;j&agrave; enregistr&eacute;
					$query = "SELECT id FROM user_parrainage WHERE emails LIKE '%".$email."%' LIMIT 0,1";
					$emailExistant = $db->loadResult($query);

					if(!$emailExistant) {

						// pseudo dans le titre
						$mailing->titre		= str_replace('{username}', $user->username, 	$mailing->titre);

						// int&eacute;gration du texte et du template, ainsi que traitement des mots cl&eacute;s
						$mailingTexte 	= JL::getMailHtml(SITE_PATH_ADMIN.'/app/app_mailing/template/'.$mailing->template, $mailing->titre, $mailing->texte, $user->username, array($row->message, JL::url(SITE_URL.'/index.php?app=profil&action=inscription&parrain_id='.$user->id.'&'.$langue)));

						// envoi du mail
						@JL::mail($email, $mailing->titre, $mailingTexte);

						// ajout de l'email dans le talbeau d'emails &agrave; ins&eacute;rer dans la DB
						$emails[]	= $email;

					}

				}

			}

			// s'il y a des emails &agrave; enregistrer
			if(count($emails)) {

				// enregistre l'email
				$query = "INSERT INTO user_parrainage SET user_id = '".$db->escape($user->id)."', emails = '".$db->escape(implode(',',$emails))."', message = '".$db->escape($row->message)."', datetime_send = NOW()";
				$db->query($query);

				$_REQUEST['emails'] = implode(',',$emails);

				// message de confirmation
				$messages[]	= '<span class="valid">'.$lang_appprofil["MessageEnvoyer"].' !</span>';

			} else {

				// message de confirmation
				$messages[]	= '<span class="error">'.$lang_appprofil["MessagedejaEnvoyes"].' !</span>';

			}

		}

		// retourne la liste des messages d'erreur
		return $messages;

	}


	function notification($messages = array()) {
		global $langue;
		global $db, $user;

		// variables
		$row						= array();

		// r&eacute;cup les donn&eacute;es en db
		$query = "SELECT *"
		." FROM user_notification"
		." WHERE user_id = '".$user->id."'"
		." LIMIT 0,1"
		;
		$row = $db->loadResultArray($query);


		// r&eacute;cup le genre de l'user log
		$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
		$row['genre']	= $db->loadResult($query);

		HTML_profil::notification($row, $messages);

	}

	function &notification_data() {
		global $langue;
		$_data	= array(
			'new_message' 	=> 0,
			'new_fleur' 	=> 0,
			'new_flash' 	=> 0,
			'new_inscrits' 	=> 0,
			'new_visite' 	=> 0,
			'rappels' 		=> 0
		);
		return $_data;
	}

	function notificationsubmit() {
		global $langue;
		global $db, $user;

		// gestion des messages d'erreurs
		$messages		= array();
		$row			= array();

		// initialise les donn&eacute;es
		$_data			=& notification_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row[$key] = JL::getVar($key, $value) ? 1 : 0;
			}
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// enregistre les modifs en DB
			$query = "UPDATE user_notification SET"
			." new_message = '".$row['new_message']."',"
			." new_fleur = '".$row['new_fleur']."',"
			." new_visite = '".$row['new_visite']."',"
			." rappels = '".$row['rappels']."'"
			." WHERE user_id = '".$user->id."'"
			;
			$db->query($query);

			// message de confirmation
			$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

		}

		// retourne la liste des messages d'erreur
		return $messages;

	}


	function finalisation() {
		global $langue;
		global $db;

		// v&eacute;rifie une nouvelle fois que l'email n'est pas d&eacute;j&agrave; renseign&eacute;
		$query = "SELECT id FROM user WHERE email = '".JL::getSession('email', '', true)."' LIMIT 0,1";
		$emailExistant	= $db->loadResult($query);

		// si l'email n'est pas d&eacute;j&agrave; pr&eacute;sent dans la DB
		if(!$emailExistant) {

			// conserve l'heure de cr&eacute;ation
			JL::setSession('creation_time', time());

			// check l'ip du visiteur
			$url_check_pays		= 'http://api.hostip.info/country.php?ip='.$_SERVER['REMOTE_ADDR'];


			// check la provenance du visiteur
			$ch 				= @curl_init($url_check_pays);
			@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$ip_pays 			= @curl_exec($ch);

			// cr&eacute;ation du compte utilisateur
			$query = "INSERT INTO user SET"
			." username = '".JL::getSession('username', '', true)."',"
			." password = MD5('".JL::getSession('password', '', true)."'),"
			." email = '".JL::getSession('email', '', true)."',"
			." gid = 0,"
			." creation_date = '".date('Y-m-d H:i:s', JL::getSession('creation_time', 0, true))."',"
			." ip_pays = '".addslashes($ip_pays)."'"
			;
			$db->query($query);
			JL::setSession('user_id', $db->insert_id());

			// cr&eacute;ation du profil
			$query = "INSERT INTO user_profil SET"
			." user_id = '".JL::getSessionInt('user_id', 0)."',"
			." offres = '".JL::getSessionInt('offres', 0)."',"
			." genre = '".JL::getSession('genre', '', true)."',"
			." naissance_date = '".JL::getSessionInt('naissance_annee', 0)."-".JL::getSession('naissance_mois', 0)."-".JL::getSession('naissance_jour', 0)."',"
			." nb_enfants = '".JL::getSessionInt('nb_enfants', 0)."',"
			." canton_id = '".JL::getSessionInt('canton_id', 0)."',"
			." ville_id = '".JL::getSessionInt('ville_id', 0)."',"
			." recherche_age_min = '".JL::getSessionInt('recherche_age_min', 0)."',"
			." recherche_age_max = '".JL::getSessionInt('recherche_age_max', 0)."',"
			." recherche_nb_enfants = '".JL::getSessionInt('recherche_nb_enfants', 0)."',"
			." photo_defaut = '".JL::getSessionInt('photo_defaut', 1)."',"
			." vie_id = '".JL::getSessionInt('vie_id', 0)."',"
			." cuisine1_id = '".JL::getSessionInt('cuisine1_id', 0)."',"
			." cuisine2_id = '".JL::getSessionInt('cuisine2_id', 0)."',"
			." cuisine3_id = '".JL::getSessionInt('cuisine3_id', 0)."',"
			." sortie1_id = '".JL::getSessionInt('sortie1_id', 0)."',"
			." sortie2_id = '".JL::getSessionInt('sortie2_id', 0)."',"
			." sortie3_id = '".JL::getSessionInt('sortie3_id', 0)."',"
			." loisir1_id = '".JL::getSessionInt('loisir1_id', 0)."',"
			." loisir2_id = '".JL::getSessionInt('loisir2_id', 0)."',"
			." loisir3_id = '".JL::getSessionInt('loisir3_id', 0)."',"
			." sport1_id = '".JL::getSessionInt('sport1_id', 0)."',"
			." sport2_id = '".JL::getSessionInt('sport2_id', 0)."',"
			." sport3_id = '".JL::getSessionInt('sport3_id', 0)."',"
			." musique1_id = '".JL::getSessionInt('musique1_id', 0)."',"
			." musique2_id = '".JL::getSessionInt('musique2_id', 0)."',"
			." musique3_id = '".JL::getSessionInt('musique3_id', 0)."',"
			." film1_id = '".JL::getSessionInt('film1_id', 0)."',"
			." film2_id = '".JL::getSessionInt('film2_id', 0)."',"
			." film3_id = '".JL::getSessionInt('film3_id', 0)."',"
			." lecture1_id = '".JL::getSessionInt('lecture1_id', 0)."',"
			." lecture2_id = '".JL::getSessionInt('lecture2_id', 0)."',"
			." lecture3_id = '".JL::getSessionInt('lecture3_id', 0)."',"
			." animaux1_id = '".JL::getSessionInt('animaux1_id', 0)."',"
			." animaux2_id = '".JL::getSessionInt('animaux2_id', 0)."',"
			." animaux3_id = '".JL::getSessionInt('animaux3_id', 0)."',"
			." nationalite_id = '".JL::getSessionInt('nationalite_id', 0)."',"
			." religion_id = '".JL::getSessionInt('religion_id', 0)."',"
			." langue1_id = '".JL::getSessionInt('langue1_id', 0)."',"
			." langue2_id = '".JL::getSessionInt('langue2_id', 0)."',"
			." langue3_id = '".JL::getSessionInt('langue3_id', 0)."',"
			." statut_marital_id = '".JL::getSessionInt('statut_marital_id', 0)."',"
			." me_marier_id = '".JL::getSessionInt('me_marier_id', 0)."',"
			." cherche_relation_id = '".JL::getSessionInt('cherche_relation_id', 0)."',"
			." niveau_etude_id = '".JL::getSessionInt('niveau_etude_id', 0)."',"
			." secteur_activite_id = '".JL::getSessionInt('secteur_activite_id', 0)."',"
			." fumer_id = '".JL::getSessionInt('fumer_id', 0)."',"
			." temperament_id = '".JL::getSessionInt('temperament_id', 0)."',"
			." vouloir_enfants_id = '".JL::getSessionInt('vouloir_enfants_id', 0)."',"
			." garde_id = '".JL::getSessionInt('garde_id', 0)."',"
			." signe_astrologique_id = '".JL::getSessionInt('signe_astrologique_id', 0)."',"
			." taille_id = '".JL::getSessionInt('taille_id', 0)."',"
			." poids_id = '".JL::getSessionInt('poids_id', 0)."',"
			." silhouette_id = '".JL::getSessionInt('silhouette_id', 0)."',"
			." style_coiffure_id = '".JL::getSessionInt('style_coiffure_id', 0)."',"
			." cheveux_id = '".JL::getSessionInt('cheveux_id', 0)."',"
			." yeux_id = '".JL::getSessionInt('yeux_id', 0)."',"
			." origine_id = '".JL::getSessionInt('origine_id', 0)."',"
			." photo_montrer = '".JL::getSessionInt('photo_montrer', 0)."',"
			." nom = '".JL::getSession('nom', '', true)."',"
			." nom_origine = '".JL::getSession('nom', '', true)."',"
			." prenom = '".JL::getSession('prenom', '', true)."',"
			." prenom_origine = '".JL::getSession('prenom', '', true)."',"
			." telephone = '".JL::getSession('telephone', '', true)."',"
			." telephone_origine = '".JL::getSession('telephone', '', true)."',"
			." adresse = '".JL::getSession('adresse', '', true)."',"
			." adresse_origine = '".JL::getSession('adresse', '', true)."',"
			." code_postal = '".JL::getSession('code_postal', '', true)."',"
			." code_postal_origine = '".JL::getSession('code_postal', '', true)."',"
			." parrain_id = '".JL::getSession('parrain_id', 0, true)."'"
			;
			$db->query($query);


			// cr&eacute;ation de l'annonce
			$query = "INSERT INTO user_annonce SET"
			." user_id = '".JL::getSessionInt('user_id', 0)."',"
			." annonce = '".JL::getSession('annonce', '', true)."'"
			;
			$db->query($query);


			// abonnement initial
			$gold_limit_date	= '0000-00-00';

			// si des jours sont offerts (d&eacute;fini dans config.php)
			if(ABONNEMENT_INITIAL > 0) {

				$date	= explode('/', date('d/m/Y'));
				$jour	= $date[0];
				$mois	= $date[1];
				$annee	= $date[2];
				$gold_limit_date	= date('Y-m-d', mktime(0, 0, 0, $mois, $jour + ABONNEMENT_INITIAL, $annee));

			}


			// cr&eacute;ation des stats
			$query = "INSERT INTO user_stats SET"
			." user_id = '".JL::getSessionInt('user_id', 0)."',"
			." gold_limit_date = '".$gold_limit_date."',"
			." gold_total = '0'"
			;
			$db->query($query);


			// inscription au groupe par d&eacute;faut
			$query = "INSERT INTO groupe_user SET groupe_id = 1, user_id = '".JL::getSessionInt('user_id', 0)."', date_join = NOW()";
			$db->query($query);


			// gestion des notifications
			$query = "INSERT INTO user_notification SET user_id = '".JL::getSessionInt('user_id', 0)."'";
			$db->query($query);


			// cr&eacute;ation des enfants
			for($i=1; $i<=6; $i++) {
				$child	= JL::getSessionInt('child'.$i, 0);
				if($child) {
					$query = "INSERT INTO user_enfant SET"
					." user_id = '".JL::getSessionInt('user_id', 0)."',"
					." num = '".$i."',"
					." naissance_date = '".JL::getSessionInt('naissance_annee'.$i, 0)."-".JL::getSessionInt('naissance_mois'.$i, 0)."-".JL::getSessionInt('naissance_jour'.$i, 0)."',"
					." signe_astrologique_id = '".JL::getSessionInt('signe_astrologique'.$i.'_id', 0)."',"
					." genre = '".JL::getSession('genre'.$i, '', true)."'"
					;
					$db->query($query);
				}
			}


			// enregistre la recherche de l'utilisateur
			$query = "UPDATE user_recherche SET user_id = '".JL::getSessionInt('user_id', 0)."' WHERE user_id_tmp LIKE '".JL::getSession('upload_dir', 0)."'";
			$db->query($query);


			// supprime la r&eacute;servation username et email
			$query = "DELETE FROM user_inscription WHERE username LIKE '".JL::getSession('username','',true)."' OR email LIKE '".JL::getSession('email','',true)."'";
			$db->query($query);


			// met &agrave; jour la table du nombre d'inscrits
			$field = JL::getSession('genre', '', true) == 'h' ? 'papa' : 'maman';
			$query = "UPDATE inscrits SET ".$field." = ".$field." + 1";
			$db->query($query);


			// sauvegarde les photos et suppression du r&eacute;pertoire temporaire d'upload
			photosSave('', true);


			// r&eacute;cup le message priv&eacute;e de bienvenue
			$query = "SELECT titre, texte"
			." FROM notification"
			." WHERE id = 2"
			." LIMIT 0,1"
			;
			$mp = $db->loadObject($query);

			// envoie le message priv&eacute;e de bienvenue
			$query = "INSERT INTO message SET"
			." user_id_from = '1',"
			." user_id_to = '".JL::getSessionInt('user_id', 0)."',"
			." titre = '".$mp->titre."',"
			." texte = '".$db->escape(sprintf($mp->texte, JL::getSession('username', '')))."',"
			." date_envoi = NOW()"
			;
			$db->query($query);

			// cr&eacute;dite les points
			JL::addPoints(4, JL::getSessionInt('user_id', 0), '');

		}


		// r&eacute;cup le mail de confirmation
		$query = "SELECT titre, texte, published"
		." FROM notification"
		." WHERE id = 1"
		." LIMIT 0,1"
		;
		$notification = $db->loadObject($query);

		$query = "UPDATE user_stats SET message_new = message_new+1, message_total = message_total+1 WHERE user_id = '".JL::getSessionInt('user_id', 0)."'";
		$db->query($query);

		// envoi du mail de confirmation
		if($notification->published) {

			//$link = SITE_URL.'/index.php?app=profil&action=confirmation&key='.md5(JL::getSessionInt('user_id', 0, true)).'&value='.md5(date('Y-m-d H:i:s', JL::getSession('creation_time', 0, true)));

			JL::mail(JL::getSession('email','',true), $notification->titre, nl2br(sprintf($notification->texte, JL::getSession('username', ''), JL::getSession('username', ''), JL::getSession('password', ''))));

		}

		// r&eacute;cup le texte de gauche pendant l'inscription
		$notice = getNotice(9);

		HTML_profil::finalisation($notice);

	}


	/*function confirmation() {
		global $db;


		$key			= JL::getVar('key', 0, true);
		$value			= JL::getVar('value', 0, true);

		// r&eacute;cup l'utilisateur
		$query = "SELECT id"
		." FROM user"
		." WHERE MD5(id) = '".$key."' AND MD5(creation_date) = '".$value."' AND active = 0"
		." LIMIT 0,1"
		;
		$user_id = $db->loadResult($query);

		// si l'utilisateur est trouv&eacute;
		if($user_id) {

			// active le compte
			$query = "UPDATE user SET active = 1 WHERE id = '".$user_id."'";
			$db->query($query);

			// r&eacute;cup le genre de l'utilisateur
			$query = "SELECT genre"
			." FROM user_profil"
			." WHERE user_id = '".$user_id."'"
			." LIMIT 0,1"
			;
			$user_genre	= $db->loadResult($query);

			// d&eacute;termine le champ &agrave; mettre &agrave; jour
			if($user_genre == 'h') {
				$field	= 'papa';
			} else {
				$field	= 'maman';
			}

			// d&eacute;truit la session par mesure de s&eacute;curit&eacute;
			JL::sessionDestroy();

		}

		HTML_profil::confirmation($user_id);

	}*/


	// copie les images du r&eacute;pertoire d'upload temporaire vers le r&eacute;pertoire de l'utilisateur, en ajoutant 'pending-' au d&eacute;but du nom de chaque fichier
	function photosSave($photo_type = '', $rmdir = false) {
		global $langue;
		global $db, $user;

		$user_id 			= $user->id ? $user->id : JL::getSessionInt('user_id', 0);
		$dest_dir			= 'images/profil/'.$user_id;
		$photo_a_valider	= 0;

		if($user_id) {

			// cr&eacute;ation du dossier utilisateur si besoin est
			if(!is_dir($dest_dir)) {
				mkdir($dest_dir);
				chmod($dest_dir, 0777);
			}

			// r&eacute;cup les miniatures de photos d&eacute;j&agrave; envoy&eacute;es
			$dir = 'images/profil/'.JL::getSession('upload_dir', 'error');
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {
					if(preg_match('#^temp.*'.$photo_type.'#', $file)) {
						copy($dir.'/'.$file, $dest_dir.'/'.str_replace('temp-', 'pending-', $file));
						@unlink($dir.'/'.$file);

						/* A NE SURTOUT PAS FAIRE CA ICI !!: je le laisse pour l'exemple
						Car on peut envoyer une photo de l'enfant 1, qui &eacute;crasera la photo existante en pending.
						Ainsi, la nouvelle photo sera ajout&eacute;e &agrave; $photo_a_valider, alors qu'elle &eacute;tait d&eacute;j&agrave; compt&eacute;e !

						if(preg_match('#.*109-'.$photo_type.'#', $file)) {
							$photo_a_valider++;
						}
						*/
					}
				}
				closedir($dir_id);
			}

			// PATCH ANTI PHOTOS FANTOMES: enfin !
			// d&eacute;termine le nombre de photos &agrave; valider pour cet utilisateur, peu importe le type de photos
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {
					if(preg_match('#^pending.*109-#', $file)) {
						$photo_a_valider++;
					}
				}
				closedir($dir_id);
			}

			if($photo_a_valider > 0) {

				// mise &agrave; jour du champ photo_a_valider de l'utilisateur.
				$query = "UPDATE user_stats SET photo_a_valider = ".strval($photo_a_valider)." WHERE user_id = '".$user_id."'";
				$db->query($query);

			}

			// profil uniquement
			if($photo_type == 'profil') {

				// mise &agrave; jour de la photo par d&eacute;faut.
				$query = "UPDATE user_profil SET photo_defaut = '".intval(JL::getVar('photo_defaut', true))."' WHERE user_id = '".$user_id."'";
				$db->query($query);

			}

			// demande de suppression du dossier d'upload
			if($rmdir) {
				rmdir($dir);
				unset($_SESSION['upload_dir']);
			}

		}

	}


	// affiche le profil
	function profil() {
		global $langue,$langString;
		global $db, $user, $action;

		// variables
		$profilEnfants			= array();
		$profilDescription		= array();
		$profilInfosEnVrac1		= array();
		$profilInfosEnVrac2		= array();
		$profilQuotidien1		= array();
		$profilQuotidien2		= array();
		$profilQuotidien3		= array();
		$profilQuotidien4		= array();
		$profilGroupes			= array();


		// id du profil &agrave; afficher
		$id	= JL::getVar('id', 0, true);

		// r&eacute;cup le genre de l'utilisateur log
		$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
		$genre = $db->loadResult($query);


		// champs obligatoires
		$where[]	= "u.id = '".$id."'";
		$where[]	= "u.confirmed > 0";
		$where[]	= "u.published = 1";


		// g&eacute;n&egrave;re le where
		$_where		= " WHERE ".implode(' AND ', $where);


		// r&eacute;cup les infos de base du profil
		$query = "SELECT u.id, IF(up.genre!='".$db->escape($genre)."' OR u.id = '".$db->escape($user->id)."',1,0) AS accessok, u.username, u.email, u.creation_date, IFNULL(ua.annonce_valide, '') AS annonce, up.genre, up.photo_defaut, up.nb_enfants, pc.nom AS canton, IFNULL(pv.nom, '') AS ville, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, up.photo_montrer, IFNULL(uf.user_id_to,0) AS blacklist"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN user_annonce AS ua ON (ua.user_id = u.id AND ua.published = 1)"
		." INNER JOIN profil_canton$langString AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		." LEFT JOIN user_flbl AS uf ON (((uf.user_id_to = u.id AND uf.user_id_from = '".$user->id."') OR (uf.user_id_to = '".$user->id."' AND uf.user_id_from = u.id)) AND uf.list_type = 0)"
		.$_where
		." LIMIT 0,1"
		;
		$profil = $db->loadObject($query);

		// si le profil est trouv&eacute;
		if($profil->id) {

			// si l'user log visite un profil de genre oppos&eacute;, et ne visite pas son propre profil
			if($profil->accessok == 1 && $id != $user->id) {

				// mise &agrave; jour des stats g&eacute;n&eacute;rales
				$query = "UPDATE user_stats SET visite_total = visite_total + 1 WHERE user_id = '".$id."'";
				$db->query($query);

				// si un utilisateur n'est pas en blacklist de l'autre
				if($profil->blacklist == 0) {

					// mise &agrave; jour des stats de visites
					$query = "UPDATE user_visite SET visite_last_date = NOW(), visite_nb = visite_nb + 1 WHERE user_id_to = '".$id."' AND user_id_from = '".$user->id."'";
					$db->query($query);

					// si aucune ligne n'a &eacute;t&eacute; affect&eacute;e
					if(!$db->affected_rows()) {

						// on insert les stats
						$query = "INSERT INTO user_visite SET user_id_to = '".$id."', user_id_from = '".$user->id."', visite_last_date = NOW(), visite_nb = 1";
						$db->query($query);

						// notification mail
						JL::notificationBasique('visite', $profil->id);

					}

					// enregistre le dernier &eacute;v&eacute;nement chez le profil cible
					JL::addLastEvent($profil->id, $user->id, 1);

					// cr&eacute;dite l'action visite par user et pas jour
					JL::addPoints(18, $profil->id, $profil->id.'#'.$user->id.'#'.date('d-m-Y'));

				}

			}

			// r&eacute;cup la description
			$query = "SELECT psa.nom AS signe_astrologique, up.taille_id AS taille, up.poids_id AS poids, ps.nom AS silhouette, psc.nom AS style_coiffure, pc.nom AS cheveux, py.nom AS yeux, po.nom AS origine"
			." FROM user_profil AS up"
			." LEFT JOIN profil_signe_astrologique$langString AS psa ON psa.id = up.signe_astrologique_id AND psa.published = 1"
			." LEFT JOIN profil_silhouette$langString AS ps ON ps.id = up.silhouette_id AND ps.published = 1"
			." LEFT JOIN profil_style_coiffure$langString AS psc ON psc.id = up.style_coiffure_id AND psc.published = 1"
			." LEFT JOIN profil_cheveux$langString AS pc ON pc.id = up.cheveux_id AND pc.published = 1"
			." LEFT JOIN profil_yeux$langString AS py ON py.id = up.yeux_id AND py.published = 1"
			." LEFT JOIN profil_origine$langString AS po ON po.id = up.origine_id AND po.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilDescription = $db->loadObject($query);


			// le membre a-t-il accept&eacute; de montrer les photos de ses enfants ?
			if($profil->photo_montrer == 2) {

				// r&eacute;cup les enfants
				$query = "SELECT ue.num, ue.genre, IFNULL(psa.nom, '') AS signe_astrologique, IF(ue.naissance_date!='0000-00-00',(YEAR(CURRENT_DATE)-YEAR(ue.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(ue.naissance_date,5)), -1) AS age"
				." FROM user_enfant AS ue"
				." LEFT JOIN profil_signe_astrologique$langString AS psa ON psa.id = ue.signe_astrologique_id"
				." WHERE ue.user_id = '".$profil->id."'"
				." LIMIT 0,6"
				;
				$profilEnfants = $db->loadObjectList($query);

			}


			// r&eacute;cup les infos diverses (partie 1)
			$query = "SELECT pn.nom AS nationalite, pr.nom AS religion, pl1.nom AS langue1, pl2.nom AS langue2, pl3.nom AS langue3, psm.nom AS statut_marital, pmm.nom AS me_marier"
			." FROM user_profil AS up"
			." LEFT JOIN profil_nationalite$langString AS pn ON pn.id = up.nationalite_id AND pn.published = 1"
			." LEFT JOIN profil_religion$langString AS pr ON pr.id = up.religion_id AND pr.published = 1"
			." LEFT JOIN profil_langue$langString AS pl1 ON pl1.id = up.langue1_id AND pl1.published = 1"
			." LEFT JOIN profil_langue$langString AS pl2 ON pl2.id = up.langue2_id AND pl2.published = 1"
			." LEFT JOIN profil_langue$langString AS pl3 ON pl3.id = up.langue3_id AND pl3.published = 1"
			." LEFT JOIN profil_statut_marital$langString AS psm ON psm.id = up.statut_marital_id AND psm.published = 1"
			." LEFT JOIN profil_me_marier$langString AS pmm ON pmm.id = up.me_marier_id AND pmm.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilInfosEnVrac1 = $db->loadObject($query);


			// r&eacute;cup les infos diverses (partie 2)
			$query = "SELECT pcr.nom AS cherche_relation, pne.nom AS niveau_etude, psa.nom AS secteur_activite, pf.nom AS fumer, pt.nom AS temperament, pve.nom AS vouloir_enfants, pg.nom AS garde"
			." FROM user_profil AS up"
			." LEFT JOIN profil_cherche_relation$langString AS pcr ON pcr.id = up.cherche_relation_id AND pcr.published = 1"
			." LEFT JOIN profil_niveau_etude$langString AS pne ON pne.id = up.niveau_etude_id AND pne.published = 1"
			." LEFT JOIN profil_secteur_activite$langString AS psa ON psa.id = up.secteur_activite_id AND psa.published = 1"
			." LEFT JOIN profil_fumer$langString AS pf ON pf.id = up.fumer_id AND pf.published = 1"
			." LEFT JOIN profil_temperament$langString AS pt ON pt.id = up.temperament_id AND pt.published = 1"
			." LEFT JOIN profil_vouloir_enfants$langString AS pve ON pve.id = up.vouloir_enfants_id AND pve.published = 1"
			." LEFT JOIN profil_garde$langString AS pg ON pg.id = up.garde_id AND pg.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilInfosEnVrac2 = $db->loadObject($query);


			// r&eacute;cup le quotidien 1
			$query = "SELECT pv.nom AS vie, pc1.nom AS cuisine1, pc2.nom AS cuisine2, pc3.nom AS cuisine3, ps1.nom AS sortie1, ps2.nom AS sortie2, ps3.nom AS sortie3"
			." FROM user_profil AS up"
			." LEFT JOIN profil_vie$langString AS pv ON pv.id = up.vie_id AND pv.published = 1"
			." LEFT JOIN profil_cuisine$langString AS pc1 ON pc1.id = up.cuisine1_id AND pc1.published = 1"
			." LEFT JOIN profil_cuisine$langString AS pc2 ON pc2.id = up.cuisine2_id AND pc2.published = 1"
			." LEFT JOIN profil_cuisine$langString AS pc3 ON pc3.id = up.cuisine3_id AND pc3.published = 1"
			." LEFT JOIN profil_sortie$langString AS ps1 ON ps1.id = up.sortie1_id AND ps1.published = 1"
			." LEFT JOIN profil_sortie$langString AS ps2 ON ps2.id = up.sortie2_id AND ps2.published = 1"
			." LEFT JOIN profil_sortie$langString AS ps3 ON ps3.id = up.sortie3_id AND ps3.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilQuotidien1 = $db->loadObject($query);


			// r&eacute;cup le quotidien 2
			$query = "SELECT pl1.nom AS loisir1, pl2.nom AS loisir2, pl3.nom AS loisir3, ps1.nom AS sport1, ps2.nom AS sport2, ps3.nom AS sport3"
			." FROM user_profil AS up"
			." LEFT JOIN profil_loisir$langString AS pl1 ON pl1.id = up.loisir1_id AND pl1.published = 1"
			." LEFT JOIN profil_loisir$langString AS pl2 ON pl2.id = up.loisir2_id AND pl2.published = 1"
			." LEFT JOIN profil_loisir$langString AS pl3 ON pl3.id = up.loisir3_id AND pl3.published = 1"
			." LEFT JOIN profil_sport$langString AS ps1 ON ps1.id = up.sport1_id AND ps1.published = 1"
			." LEFT JOIN profil_sport$langString AS ps2 ON ps2.id = up.sport2_id AND ps2.published = 1"
			." LEFT JOIN profil_sport$langString AS ps3 ON ps3.id = up.sport3_id AND ps3.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilQuotidien2 = $db->loadObject($query);


			// r&eacute;cup le quotidien 3
			$query = "SELECT pm1.nom AS musique1, pm2.nom AS musique2, pm3.nom AS musique3, pf1.nom AS film1, pf2.nom AS film2, pf3.nom AS film3"
			." FROM user_profil AS up"
			." LEFT JOIN profil_musique$langString AS pm1 ON pm1.id = up.musique1_id AND pm1.published = 1"
			." LEFT JOIN profil_musique$langString AS pm2 ON pm2.id = up.musique2_id AND pm2.published = 1"
			." LEFT JOIN profil_musique$langString AS pm3 ON pm3.id = up.musique3_id AND pm3.published = 1"
			." LEFT JOIN profil_film$langString AS pf1 ON pf1.id = up.film1_id AND pf1.published = 1"
			." LEFT JOIN profil_film$langString AS pf2 ON pf2.id = up.film2_id AND pf2.published = 1"
			." LEFT JOIN profil_film$langString AS pf3 ON pf3.id = up.film3_id AND pf3.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilQuotidien3 = $db->loadObject($query);


			// r&eacute;cup le quotidien 4
			$query = "SELECT pl1.nom AS lecture1, pl2.nom AS lecture2, pl3.nom AS lecture3, pa1.nom AS animaux1, pa2.nom AS animaux2, pa3.nom AS animaux3"
			." FROM user_profil AS up"
			." LEFT JOIN profil_lecture$langString AS pl1 ON pl1.id = up.lecture1_id AND pl1.published = 1"
			." LEFT JOIN profil_lecture$langString AS pl2 ON pl2.id = up.lecture2_id AND pl2.published = 1"
			." LEFT JOIN profil_lecture$langString AS pl3 ON pl3.id = up.lecture3_id AND pl3.published = 1"
			." LEFT JOIN profil_animaux$langString AS pa1 ON pa1.id = up.animaux1_id AND pa1.published = 1"
			." LEFT JOIN profil_animaux$langString AS pa2 ON pa2.id = up.animaux2_id AND pa2.published = 1"
			." LEFT JOIN profil_animaux$langString AS pa3 ON pa3.id = up.animaux3_id AND pa3.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilQuotidien4 = $db->loadObject($query);


			// r&eacute;cup les groupes du profil
			$query = "SELECT g.id, g.titre"
			." FROM groupe AS g"
			." INNER JOIN groupe_user AS gu ON gu.groupe_id = g.id"
			." WHERE g.active > 0 AND g.titre != '' AND gu.user_id = '".$profil->id."'"
			." ORDER BY gu.date_join DESC"
			;
			$profilGroupes = $db->loadObjectList($query);

		}

		// affiche le profil
		HTML_profil::profil($profil, $profilEnfants, $profilDescription, $profilInfosEnVrac1, $profilInfosEnVrac2, $profilQuotidien1, $profilQuotidien2, $profilQuotidien3, $profilQuotidien4, $profilGroupes);

	}


	// r&eacute;cup la notice/indication de gauche affich&eacute;e lors de l'inscription
	function getNotice($step_num) {
		global $langue, $langString;
		global $db;

		if($step_num == 7) { // photos enfant

			$id = 21;

		} elseif($step_num == 2) { // photos profil

			$id = 23;

		} elseif($step_num == 3) { // mon annonce

			$id = 22;

		} else { // if(in_array($step_num, array(1,4,5,6,8,9,10))) { // pour vous guider

			$id = 20;

		}

		// r&eacute;cup le texte
		$query = "SELECT texte FROM contenu$langString WHERE id = '".(int)$id."' LIMIT 0,1";
		$notice = $db->loadResult($query);

		return $notice;

	}

?>
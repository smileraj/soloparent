<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $action, $user, $langue, $langString;
	if($_GET["lang"]=='fr')
		$langString = "";
	else
		$langString = "_$_GET[lang]";

	require_once('message.html.php');

	// user non log
	if(!$user->id) {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
	}


	// gestion des messages d'erreurs
	$messages	= array();


	switch($action) {

		case 'flower':

			// abonn&eacute; uniquement
			JL::loadMod('abonnement_check');

			messageWrite(true);
		break;

		case 'write':

			// abonn&eacute; uniquement
			JL::loadMod('abonnement_check');

			messageWrite(false);
		break;

		case 'read':
			$id	= JL::getVar('id', 0, true);
			if($id) {
				messageRead($id);
			} else {
				JL::redirect(SITE_URL.'/index.php?app=message&action=inbox'.'&'.$langue);
			}
		break;

		case 'restore':
			$id	= JL::getVar('id', 0);
			if(is_array($id)) {
				messageMove($id, 0);
			} else {
				JL::redirect(SITE_URL.'/index.php?app=message&action=inbox'.'&'.$langue);
			}
		break;

		case 'delete':
			$id	= JL::getVar('id', 0);
			if(is_array($id)) {
				messageMove($id, 1);
			} else {
				JL::redirect(SITE_URL.'/index.php?app=message&action=inbox'.'&'.$langue);
			}
		break;

		case 'backup':
			$id	= JL::getVar('id', 0);
			if(is_array($id)) {
				messageMove($id, 2);
			} else {
				JL::redirect(SITE_URL.'/index.php?app=message&action=inbox'.'&'.$langue);
			}
		break;

		case 'reply':

			// abonn&eacute; uniquement
			JL::loadMod('abonnement_check');

			$id	= JL::getVar('id', 0, true);
			if($id) {
				messageReply($id);
			} else {
				JL::redirect(SITE_URL.'/index.php?app=message&action=inbox'.'&'.$langue);
			}
		break;


		case 'flowers':
			messageList(0, true);
		break;

		case 'inbox':
			messageList(0);
		break;

		case 'trash':
			messageList(1);
		break;

		case 'archive':
			messageList(2);
		break;

		case 'emptytrash':
			messageEmptyTrash();
			JL::redirect(SITE_URL.'/index.php?app=message&action=trash&msg=-1'.'&'.$langue);
		break;

		case 'sent':
			messageSent();
		break;


		case 'send':

			// abonn&eacute; uniquement
			JL::loadMod('abonnement_check');

			$messages = messageSend();
			if(!count($messages)) {
				JL::redirect(SITE_URL.'/index.php?app=message&action=sent&msg=3'.'&'.$langue);
			} else {
				messageWrite(false, $messages);
			}
		break;

		case 'sendflower':

			// abonn&eacute; uniquement
			JL::loadMod('abonnement_check');

			$messages = messageSend(true);
			if(!count($messages)) {
				JL::redirect(SITE_URL.'/index.php?app=message&action=sent&msg=3'.'&'.$langue);
			} else {
				messageWrite(true, $messages);
			}
		break;

		default:
		JL::loadApp('404');
		break;

	}

	function message_data() {
			global $langue;
		$_data	= array(
				'user_to' => '',
				'titre' => '',
				'texte' => '',
				'fleur_id' => 0
			);
		return $_data;
	}


	function messageRead($id) {
			global $langue;
		global $db, $user;
		include("lang/app_message.".$_GET['lang'].".php");

		// variables
		$where 		= array();
		$_where		= '';


		// d&eacute;termine si c'est un message envoy&eacute; ou re&ccedil;u
		$query = "SELECT m.user_id_to, m.user_id_from, m.non_lu, m.fleur_id"
		." FROM message AS m"
		." WHERE m.id = '".$id."'"
		." LIMIT 0,1";
		$message = $db->loadObject($query);

		// message re&ccedil;u
		if($message->user_id_to == $user->id) {

			$innerJoinOn	= 'm.user_id_from';

		} elseif($message->user_id_from == $user->id) { // message envoy&eacute;

			$innerJoinOn	= 'm.user_id_to';

		} else {

			// sinon c'est que le message n'appartient pas &agrave; l'utilisateur log
			JL::redirect(SITE_URL.'/index.php?app=message&action=inbox'.'&'.$langue);

		}


		$where[]	= "m.id = '".$id."'";
		$where[]	= "u.confirmed > 0";
		//$where[]	= "u.published = 1";
		// pourquoi published 0 autoris&eacute; ? car on permet l'affichage de messages de profils d&eacute;sactiv&eacute;s, mais confirm&eacute;s.
		// par contre, on n'affiche pas les messages de profils non confirm&eacute;s ! qu'ils soient publi&eacute;s ou non

		if(count($where)) {
			$_where = " WHERE ".implode(" AND ", $where);
		}


		// r&eacute;cup le message de l'utilisateur log
		$query = "SELECT m.id, IF(m.user_id_to = ".$user->id.", 1, 0) AS owner, m.titre, m.texte, m.date_envoi, ".$innerJoinOn." AS user_id, m.fleur_id, f.nom_".$_GET['lang']." AS fleur_nom, f.signification_".$_GET['lang']." AS fleur_signification, m.dossier_id, IFNULL(u.username, 'ParentSolo.ch') AS username, IFNULL(up.photo_defaut, 0) AS photo_defaut, IFNULL(up.genre, '') AS genre"
		." FROM message AS m"
		." INNER JOIN user AS u ON u.id = ".$innerJoinOn
		." LEFT JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN fleur AS f ON f.id = m.fleur_id"
		.$_where
		." LIMIT 0,1"
		;
		$userMessage = $db->loadObject($query);

		$query = "SELECT *"
		." FROM user_flbl"
		." WHERE ((user_id_to =".$user->id." AND user_id_from = ".$userMessage->user_id.") OR (user_id_to =".$userMessage->user_id." AND user_id_from = ".$user->id.")) AND list_type=0"
		;
		$blacklists = $db->loadObjectList($query);
		
		if(!$userMessage || $blacklists){
			JL::redirect(SITE_URL.'/index.php?app=message&action=inbox'.'&'.$langue);
		}
		// parcourt les messages
		if(!JL::checkAbonnement()) {
			$userMessage->titre = JL::messageEncode($userMessage->titre, '<a href="'.JL::url('index.php?app=abonnement&action=tarifs'.'&'.$langue).'" title="'.$lang_message['AbonnementLireAdresse'].'">[ '.$lang_message['AbonnementLireAdresse'].' ]</a>');
			$userMessage->texte = JL::messageEncode($userMessage->texte, '<a href="'.JL::url('index.php?app=abonnement&action=tarifs'.'&'.$langue).'" title="'.$lang_message['AbonnementLireAdresse'].'">[ '.$lang_message['AbonnementLireAdresse'].' ]</a>');
		}
		
		if($user->confirmed ==2) {
			$userMessage->titre = JL::messageEncode($userMessage->titre, '['.$lang_message['AdresseEmail'].']');
			$userMessage->texte = JL::messageEncode($userMessage->texte, '['.$lang_message['AdresseEmail'].']');
		}

		// si le message est non lu
		if($message->non_lu && $message->user_id_to == $user->id) {

			// met &agrave; jour le non_lu du message
			$query = "UPDATE message SET non_lu = 0 WHERE id = '".$id."'";
			$db->query($query);

			// mise &agrave; jour de user_stats du destinataire
			if($message->fleur_id) {
				$query = "UPDATE user_stats SET fleur_new = fleur_new-1 WHERE user_id = '".$user->id."'";
			} else {
				$query = "UPDATE user_stats SET message_new = message_new-1 WHERE user_id = '".$user->id."'";
			}
			$db->query($query);

		}

		// affiche la liste des messages
		HTML_message::messageRead($userMessage);

	}


	function messageList($dossier_id, $flowers = false) {
			global $langue;
			include("lang/app_message.".$_GET['lang'].".php");
		global $db, $user, $action, $messages;

		// variables
		$resultatParPage 	= 10;
		$search				= array();
		$where 				= array();
		$_where				= '';


		// pagination
		$search['page']		= (int)JL::getVar('page', 1);
		if($search['page'] <= 0) JL::redirect(SITE_URL.'/index.php?app=message&action=inbox'.'&'.$langue);


		// WHERE
		$where[]			= "m.dossier_id = '".$dossier_id."'";
		$where[]			= "m.user_id_to = '".$user->id."'";
		$where[]			= "u.confirmed > 0";
		$where[]			= "m.user_id_from NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)";
		$where[]			= "m.user_id_from NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)";
		
		//$where[]	= "u.published = 1";
		// pourquoi published 0 autoris&eacute; ? car on permet l'affichage de messages de profils d&eacute;sactiv&eacute;s, mais confirm&eacute;s.
		// par contre, on n'affiche pas les messages de profils non confirm&eacute;s ! qu'ils soient publi&eacute;s ou non

		if($flowers) {
			$where[]		= "m.fleur_id > 0";
		}

		if(count($where)) {
			$_where = " WHERE ".implode(" AND ", $where);
		}


		// r&eacute;cup le total
		$query = "SELECT COUNT(*)"
		." FROM message AS m"
		." INNER JOIN user AS u ON u.id = m.user_id_from"
		.$_where
		;
		$search['result_total']	= (int)$db->loadResult($query);
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);


		// r&eacute;cup les messages de l'utilisateur log
		$query = "SELECT m.id, m.titre, m.non_lu, m.date_envoi, m.user_id_from AS user_id, m.fleur_id, IF(u.id = 1, 'ParentSolo.ch', u.username) AS username, up.photo_defaut, up.genre, up.nb_enfants, ((YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5))) AS age, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, pc.abreviation AS canton_abrev, 2 as m_read"
		." FROM message AS m"
		." INNER JOIN user AS u ON u.id = m.user_id_from"
		." LEFT JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		.$_where
		." ORDER BY non_lu DESC, date_envoi DESC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$userMessages = $db->loadObjectList($query);


		// parcourt les messages
		if(!JL::checkAbonnement() || $user->confirmed ==2) {
			$messagesNb = count($userMessages);
			for($i=0; $i<$messagesNb; $i++) {
				$userMessages[$i]->titre = JL::messageEncode($userMessages[$i]->titre, '['.$lang_message['AdresseEmail'].']');
			}
		}

		// messages de confirmation
		$msg	= JL::getVar('msg', -2);
		if($msg == 3) {

			$messages[]	= '<span class="valid">'.$lang_message["MailEnvoye"].' !</span>';

		} elseif($msg == 2) {

			$messages[]	= '<span class="valid">'.$lang_message["MailArchive"].' !</span>';

		} elseif($msg == 1) {

			$messages[]	= '<span class="valid">'.$lang_message["MailSupprime"].' !</span>';

		} elseif($msg == 0) {

			$messages[]	= '<span class="valid">'.$lang_message["MailRestaure"].' !</span>';

		} elseif($msg == -1) {

			$messages[]	= '<span class="valid">'.$lang_message["CorbeilleVidee"].' !</span>';

		}

		// affiche la liste des messages
		HTML_message::messageList($userMessages, $dossier_id, $messages, $search);

	}


	function messageSent() {
			global $langue;
			include("lang/app_message.".$_GET['lang'].".php");
		global $db, $user, $messages;

		// variables
		$resultatParPage 	= 10;
		$search				= array();

		// pagination
		$search['page']		= (int)JL::getVar('page', 1);
		if($search['page'] <= 0) JL::redirect(SITE_URL.'/index.php?app=message&action=sent'.'&'.$langue);

		// messages de confirmation
		$msg	= JL::getVar('msg', -2);
		if($msg == 3) {
			$messages[]	= '<span class="valid">'.$lang_message["MailEnvoye"].' !</span>';
		}


		// r&eacute;cup le total
		$query = "SELECT COUNT(*)"
		." FROM message AS m"
		." INNER JOIN user AS u ON u.id = m.user_id_to"
		." WHERE m.user_id_from = '".$user->id."'"
		." AND m.user_id_to NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)"
		." AND m.user_id_to NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)"
		;
		$search['result_total']	= (int)$db->loadResult($query);
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);


		// r&eacute;cup les messages envoy&eacute;s par l'utilisateur log
		$query = "SELECT m.id, m.titre, 0 AS non_lu, m.date_envoi, m.user_id_to AS user_id, m.fleur_id, u.username, up.photo_defaut, up.genre, ((YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5))) AS age, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, m.non_lu as m_read, pc.abreviation AS canton_abrev, up.nb_enfants"
		." FROM message AS m"
		." INNER JOIN user AS u ON u.id = m.user_id_to"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." WHERE m.user_id_from = '".$user->id."'"
		." AND m.user_id_to NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)"
		." AND m.user_id_to NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)"
		." ORDER BY date_envoi DESC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$userMessages = $db->loadObjectList($query);

		// affiche la liste des messages
		HTML_message::messageList($userMessages, 3, $messages, $search);

	}


	function messageWrite($flower, $messages = array()) {
		global $langue, $langString;
		global $db, $user;

		// variables
		$_data		= message_data();
		$fleurs		= array();

		// r&eacute;cup les donn&eacute;es temporaires en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				if(JL::getVar('user_to', '') == JL::getSession('user_to', '')) {
					$row->{$key}	= JL::getSession($key, $value);
				} else {
					$row->{$key}	= $value;
				}
			}
		}

		// seul param pass&eacute; en $_GET
		$row->user_to = JL::getVar('user_to', '');

		// si on envoie une fleur
		if($flower) {

			// r&eacute;cup la liste des fleurs
			$query = "SELECT id, nom_".$_GET['lang']." as nom, signification_".$_GET['lang']." as signification"
			." FROM fleur"
			." WHERE published = 1"
			." ORDER BY id ASC"
			;
			$fleurs = $db->loadObjectList($query);

		}

		// affichage du formulaire
		HTML_message::messageWrite($row, $flower, $messages, $fleurs);

	}


	function messageReply($id, $messages = array()) {
			global $langue;
			include("lang/app_message.".$_GET['lang'].".php");
		global $db, $user;

		$fleurs		= array();

		// d&eacute;termine si le message est bien destin&eacute; &agrave; l'utilisateur log
		$query = "SELECT m.user_id_to, u.username, m.titre, m.texte"
		." FROM message AS m"
		." INNER JOIN user AS u ON u.id = m.user_id_from"
		." WHERE m.id = '".$id."'"
		." LIMIT 0,1";
		$message = $db->loadObject($query);

		// message n'appartenant pas &agrave; l'utilisateur
		if($message->user_id_to != $user->id) {

			// sinon c'est que le message n'appartient pas &agrave; l'utilisateur log
			JL::redirect(SITE_URL.'/index.php?app=message&action=inbox'.'&'.$langue);

		}

		// variables
		$_data		= message_data();

		// affecte les param&egrave;tres par d&eacute;faut
		JL::setSession('user_to', $message->username);
		JL::setSession('titre', 'Re: '.$message->titre);
		JL::setSession('texte', "\n\n\n\n\n---------------------------------------------\n".$lang_message['EnReponseA'].": ".$message->titre."\n---------------------------------------------\n\n".$message->texte);

		// r&eacute;cup les donn&eacute;es temporaires en session
		if(count($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key}	= JL::getSession($key, $value);
			}
		}

		// affichage du formulaire
		HTML_message::messageWrite($row, 0, $messages, $fleurs);

	}


	function messageSend($flower = false) {
			global $langue;
			include("lang/app_message.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages	= array();

		// variables
		$_data		= message_data();

		// v&eacute;rification du formulaire avant envoi
		$user_to	= trim(JL::getVar('user_to', '', true));
		$titre		= trim(JL::getVar('titre', '', true));
		$texte		= trim(JL::getVar('texte', '', true));
		$fleur_id	= trim(JL::getVar('fleur_id', 0, true));


		// r&eacute;cup le status de l'utilisateur (confirm&eacute;, attente, non confirm&eacute;)
		$query = "SELECT confirmed FROM user WHERE id = '".(int)$user->id."' LIMIT 0,1";
		$user->confirmed = $db->loadResult($query);


		// si l'utilisateur est en attente de confirmation t&eacute;l&eacute;phonique
		if($user->confirmed == 2) {

			$messages[]	= '<span class="error">'.$lang_message["ProfilNonValide"].'<br /><br />'.$lang_message["QualiteServiceOptimale"].'<br /><br />'.$lang_message["ParentsoloVousRemercie"].'</span>';

		}


		// fleur non s&eacute;lectionn&eacute;e
		if($flower && !$fleur_id) {

			$messages[]	= '<span class="error">'.$lang_message["SelectionnezFleur"].'.</span>';

		}

		// pas de destinataire renseign&eacute;
		if(!$user_to) {

			$messages[]	= '<span class="error">'.$lang_message["IndiquezDestinataire"].'.</span>';

		} else {

			// v&eacute;rifie si le destinataire existe dans la DB
			$query = "SELECT u.id, up.genre, IFNULL(uf.user_id_to,0) AS user_to_bl, IFNULL(uf2.user_id_to,0) AS user_from_bl"
			." FROM user AS u"
			." INNER JOIN user_profil AS up ON up.user_id = u.id"
			." LEFT JOIN user_flbl AS uf ON (uf.user_id_to = u.id AND uf.user_id_from = '".$user->id."' AND uf.list_type = 0)"
			." LEFT JOIN user_flbl AS uf2 ON (uf2.user_id_to = '".$user->id."' AND uf2.user_id_from = u.id AND uf2.list_type = 0)"
			." WHERE u.username LIKE '".$user_to."' AND u.confirmed > 0"
			." LIMIT 0,1"
			;
			$user_to	= $db->loadObject($query);

			// r&eacute;cup le genre de l'utilisateur log
			$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
			$genre = $db->loadResult($query);


			// destinataire = user log
			if($user_to->id == $user->id) {

				$messages[]	= '<span class="error">'.$lang_message["WarningMailVousMeme"].'.</span>';

			} elseif(!$user_to->id || $user_to->genre == $genre) { // destinataire inconnu(e)

				$messages[]	= '<span class="error">'.$lang_message["PseudoInconnu"].'.</span>';

			} elseif($user_to->user_to_bl) {

				$messages[]	= '<span class="error">'.$lang_message["WarningUtilisateurDansListeNoire"].'.</span>';

			} elseif($user_to->user_from_bl) {

				$messages[]	= '<span class="error">'.$lang_message["WarningVousDansListeNoireUtilisateur"].'.</span>';

			}

		}

		// pas de titre
		if(!$titre) {

			$messages[]	= '<span class="error">'.$lang_message["IndiquezTitre"].'.</span>';

		}

		// pas de texte
		if(!$texte) {

			$messages[]	= '<span class="error">'.$lang_message["IndiquezTexte"].'.</span>';

		}


		// s'il y a erreur(s)
		if(count($messages)) {

			// conserve les donn&eacute;es envoy&eacute;es en session
			if(count($_data)) {
				foreach($_data as $key => $value) {
					JL::setSession($key, JL::getVar($key, $value));
				}
			}

		} else { // pas d'erreur, on envoie le message

			$query = "INSERT INTO message SET"
			." user_id_from = '".$user->id."',"
			." user_id_to = '".$user_to->id."',"
			." titre = '".$titre."',"
			." texte = '".$texte."',"
			." date_envoi = NOW(),"
			." fleur_id = '".$fleur_id."'"
			;
			$db->query($query);
			$message_id = $db->insert_id();

			// efface les donn&eacute;es de session
			if(count($_data)) {
				foreach($_data as $key => $value) {
					JL::setSession($key, '');
				}
			}

			// mise &agrave; jour de user_stats du destinataire
			if($fleur_id) {

				// mise &agrave; jour des stats
				$query = "UPDATE user_stats SET fleur_new = fleur_new+1, fleur_total = fleur_total+1 WHERE user_id = '".$user_to->id."'";

				// notification mail
				JL::notificationBasique('fleur', $user_to->id);

				// enregistre le dernier &eacute;v&eacute;nement chez le profil cible
				JL::addLastEvent($user_to->id, $user->id, 3, $message_id);

				// cr&eacute;dite l'action r&eacute;ception de fleur
				JL::addPoints(9, $user_to->id, $user_to->id.'#'.$user->id.'#'.date('d-m-Y'));

			} else {

				// mise &agrave; jour des stats
				$query = "UPDATE user_stats SET message_new = message_new+1, message_total = message_total+1 WHERE user_id = '".$user_to->id."'";

				// notification mail
				JL::notificationBasique('message', $user_to->id);

				// enregistre le dernier &eacute;v&eacute;nement chez le profil cible
				JL::addLastEvent($user_to->id, $user->id, 2, $message_id);

				// cr&eacute;dite l'action r&eacute;ception de mail
				JL::addPoints(8, $user_to->id, $user_to->id.'#'.$user->id.'#'.date('d-m-Y'));

			}
			$db->query($query);

			// mise &agrave; jour de user_stats de l'exp&eacute;diteur
			if($fleur_id) {
				$query = "UPDATE user_stats SET fleur_sent = fleur_sent+1 WHERE user_id = '".$user->id."'";
			} else {
				$query = "UPDATE user_stats SET message_sent = message_sent+1 WHERE user_id = '".$user->id."'";
			}
			$db->query($query);

		}

		return $messages;

	}

	function messageMove($ids, $dossier_id) {
			global $langue;
		global $db, $user;

		// variables
		$dossier_id_origine	= 0;
		$dossier_id_ok		= array(0,1,2); // dossiers id valides
		$msg 				= 1;			// affichage (1) ou non (0) du message de confirmation

		// si le param pass&eacute; est bien un tableau
		if(is_array($ids)) {

			foreach($ids as $id) {

				// s&eacute;curit&eacute;
				$id = addslashes($id);

				// d&eacute;termine si le message est bien destin&eacute; &agrave; l'utilisateur log
				$query = "SELECT m.user_id_to, m.dossier_id, u.username, m.titre, m.texte, m.non_lu, m.fleur_id"
				." FROM message AS m"
				." INNER JOIN user AS u ON u.id = m.user_id_from"
				." WHERE m.id = '".$id."'"
				." LIMIT 0,1";
				$message = $db->loadObject($query);

				$dossier_id_origine	= $message->dossier_id;

				// message n'appartenant pas &agrave; l'utilisateur
				if($message->user_id_to != $user->id || !in_array($dossier_id, $dossier_id_ok)) {

					// sinon c'est que le message n'appartient pas &agrave; l'utilisateur log
					JL::redirect(SITE_URL.'/index.php?app=message&action=inbox'.'&'.$langue);

				} else {

					// met &agrave; jour le dossier_id
					$query = "UPDATE message SET dossier_id = '".$dossier_id."' WHERE id = '".$id."'";
					$db->query($query);

					// nouveau message, non lu, destin&eacute; &agrave; l'utilisateur log
					if($message->non_lu == 1 && $message->user_id_to == $user->id) {

						// op&eacute;rateur
						$op	= '';

						// suppression
						if($dossier_id == 1 && $message->dossier_id == 0) {

							// d&eacute;cr&eacute;mente le compteur de nouveaux messages
							$op = '-';

						} elseif($dossier_id == 0 && $message->dossier_id == 1) { // restauration

							// incr&eacute;mente le compteur de nouveaux messages
							$op = '+';

						}

						// s'il y a une op&eacute;ration &agrave; faire
						if($op != '') {

							// d&eacute;termine le champ &agrave; utiliser
							$field	= $message->fleur_id > 0 ? 'fleur_new' : 'message_new';

							// met &agrave; jour les stats de messages non lus
							$query = "UPDATE user_stats SET ".$field." = ".$field." ".$op." 1 WHERE user_id = '".$user->id."'";
							$db->query($query);

						}

					}

				}

			}

		} else {

			// on affichera un message d'erreur apr&egrave;s la redirection
			$msg = 0;

		}


		switch($dossier_id_origine) {

			case 2:
				JL::redirect(SITE_URL.'/index.php?app=message&action=archive&msg='.$dossier_id.'&'.$langue);
			break;

			case 1:
				JL::redirect(SITE_URL.'/index.php?app=message&action=trash&msg='.$dossier_id.'&'.$langue);
			break;

			case 0:
			default:
				JL::redirect(SITE_URL.'/index.php?app=message&action=inbox&msg='.$dossier_id.'&'.$langue);
			break;

		}



	}


	function messageEmptyTrash() {
			global $langue;
		global $db, $user;

		// supprime virtuellement les messages de la corbeille... On change juste le dossier_id en -1.
		$query = "UPDATE message SET dossier_id = -1 WHERE user_id_to = '".$user->id."' AND dossier_id = 1";
		$db->query($query);

	}

?>

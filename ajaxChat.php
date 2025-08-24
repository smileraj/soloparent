<?php

	// config
	require_once('config.php');
	require_once("ajaxChat.$_GET[lang_id].php");

	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');

	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');
	$db	= new DB();

	// params
	$action			= JL::getVar('action', false);
	$lang_id		= JL::getVar('lang_id', 'fr');
	$user_id_from	= intval(JL::getVar('user_id_from', 0));
	$user_id_to		= intval(JL::getVar('user_id_to', 0));
	$user_id_to_new	= intval(JL::getVar('user_id_to_new', 0));
	$newOnly		= intval(JL::getVar('newonly', 0));
	$key			= JL::getVar('key', '');
	$texte			= utf8_decode(JL::getVar('texte', '', true));

	// crée un objet content les infos de l'utilisateur
	$user =& getUserInfo($user_id_from);


	// vérifie que le user_id_form est bien renseigné, et que la key correspond
	if(!$user->id || !checkUserKey($key)) {
		die();
	}

	// met à jour le last_online de l'utilisateur log
	$query = "UPDATE user SET last_online = NOW() WHERE id = '".$user->id."'";
	$db->query($query);

	// controleur
	switch($action) {

		case 'getNewMessagesNb':
		echo getNewMessagesNb($user_id_from);
		break;

		case 'getConversations':
		if($user_id_to_new) {
			addConversation($user->id, $user_id_to_new);
		}
		$conversations =& getConversations($user->id, $user_id_to);
		displayConversations($conversations, $user_id_to);
		break;

		case 'openConversation':
		if($user_id_to) {
			openConversation($user->id, $user_id_to, $newOnly);
		}
		break;

		case 'sendMessage':
		if($user_id_to) {
			sendMessage($user->id, $user_id_to, $texte);
		}
		break;

		case 'getNewMessages':
		if($user_id_to) {
			getNewMessages($user->id, $user_id_to);
		}
		break;

		case 'closeConversation':
		if($user_id_to) {
			deleteConversation($user->id, $user_id_to);
		}
		break;

		case 'getHelp':
		getHelp();
		break;

		default:
		die();
		break;

	}

	// déconnexion DB
	$db->disconnect();

	// récup les infos de l'utilisateur
	function &getUserInfo($user_id) {
		global $db;

		$userInfo = array();

		$query = "SELECT u.id, u.username, u.confirmed, u.creation_date, up.genre, up.photo_defaut, us.gold_limit_date,(YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_stats AS us ON us.user_id = u.id"
		." WHERE u.id = '".$user_id."' AND u.published*u.confirmed > 0"
		." LIMIT 0,1";
		$userInfo = $db->loadObject($query);

		$userInfo->gold = ($userInfo->gold_limit_date == '0000-00-00' || ($userInfo->gold_limit_date != '0000-00-00' && strtotime($userInfo->gold_limit_date) < time())) ? false : true;

		return $userInfo;

	}


	// vérifie que le user_id_form et la key correspondent
	function checkUserKey($key) {
		global $db, $user;

		// clé de sécurité
		$key_ok = md5(str_replace('-', $user->id, $user->creation_date));

		if($key != $key_ok) {
			return false;
		} else {
			return true;
		}

	}


	// affiche les nouveaux messages entre les 2 utilisateurs
	function getNewMessages($user_id_from, $user_id_to) {

		// récup les nouveaux messages
		$messages =& getMessages($user_id_from, $user_id_to, 1);

		// affiche les nouveaux messages chez l'expéditeur
		displayMessages($messages);

	}


	// retourne le nombre de nouvelles (ou maj) conversations de l'utilisateur $user_id_from
	function getNewMessagesNb($user_id_from) {
		global $db;

		// variables
		$where			= array();
		$_where			= '';

		$where[]		= "cm.user_id_to = '".$user_id_from."'";
		$where[]		= "cm.new_user_to = '1'";

		// génère le where
		$_where			= " WHERE ".implode(' AND ', $where);

		// récup les conversations
		$query = "SELECT COUNT(*)"
		." FROM chat_message AS cm"
		.$_where
		;
		return $db->loadResult($query);

	}


	// envoi un message
	function sendMessage($user_id_from, $user_id_to, $texte) {
		global $db, $user, $langAjaxChat;

		$userTo =& getUserInfo($user_id_to);

		if($texte && $user->genre != $userTo->genre) {

			// check blacklist
			$query = "SELECT IFNULL(uf.user_id_to,0) AS user_to_bl, IFNULL(uf2.user_id_to,0) AS user_from_bl"
			." FROM user AS u"
			." LEFT JOIN user_flbl AS uf ON (uf.user_id_to = u.id AND uf.user_id_from = '".$user_id_from."' AND uf.list_type = 0)"
			." LEFT JOIN user_flbl AS uf2 ON (uf2.user_id_to = '".$user_id_from."' AND uf2.user_id_from = u.id AND uf2.list_type = 0)"
			." WHERE u.id = '".$user_id_to."'"
			." LIMIT 0,1"
			;
			$blacklist = $db->loadObject($query);

			if($blacklist->user_to_bl) {

				// message système d'info
				$messages					= array();
				$messages[0]				= new stdClass();
				$messages[0]->genre			= 'system';
				$messages[0]->username		= 'ParentSolo';
				$messages[0]->date_envoi	= date('Y-m-d H:i:s');
				$messages[0]->texte			= 'Vous ne pouvez pas envoyer de message à un utilisateur de votre liste noire.';

				// affiche le messages
				displayMessages($messages);

			} elseif($blacklist->user_from_bl) {

				// message système d'info
				$messages					= array();
				$messages[0]				= new stdClass();
				$messages[0]->genre			= 'system';
				$messages[0]->username		= 'ParentSolo';
				$messages[0]->date_envoi	= date('Y-m-d H:i:s');
				$messages[0]->texte			= 'Vous ne pouvez pas envoyer de message à cet utilisateur car vous êtes dans sa liste noire.';

				// affiche le messages
				displayMessages($messages);

			} else {

				// check membre abonné
				if($user->gold && $user->confirmed == 1) {

					// ajoute la converstion pour le destinataire
					addConversation($user_id_to, $user_id_from);


					// insert le message
					$query = "INSERT INTO chat_message SET"
					." user_id_from = '".$user_id_from."',"
					." user_id_to = '".$user_id_to."',"
					." texte = '".$texte."',"
					." date_envoi = NOW()"
					;
					$db->query($query);


					// enregistre le dernier événement chez le profil cible
					JL::addLastEvent($user_id_to, $user_id_from, 4);

					// crédite l'action d'envoi de message par membre et par jour
					JL::addPoints(10, $user_id_to, $user_id_to.'#'.$user_id_from.'#'.date('d-m-Y'));

					// récup les nouveaux messages
					getNewMessages($user_id_from, $user_id_to);

				} elseif($user->gold && $user->confirmed == 2) { // confirmation en attente

					// message système d'info
					$messages					= array();
					$messages[0]				= new stdClass();
					$messages[0]->genre			= 'system';
					$messages[0]->username		= 'ParentSolo';
					$messages[0]->date_envoi	= date('Y-m-d H:i:s');
					$messages[0]->texte			= 'Votre profil n\'a pas encore été validé par un modérateur. Vous allez recevoir un appel téléphonique d\'ici 1 à 2 jours ouvrés afin de confirmer votre profil. Ces jours d\'attente seront bien entendu ajoutés à votre abonnement.';

					$messages[1]				= new stdClass();
					$messages[1]->genre			= 'system';
					$messages[1]->username		= 'ParentSolo';
					$messages[1]->date_envoi	= date('Y-m-d H:i:s');
					$messages[1]->texte			= 'Cette mesure est prise dans le but de vous garantir une qualité de service optimale. Ainsi, toutes personnes mal intentionnées qui souhaiteraient contourner la confirmation téléphonique ne pourront pas contacter les membres tant que leur profil ne sera pas validé.';

					$messages[2]				= new stdClass();
					$messages[2]->genre			= 'system';
					$messages[2]->username		= 'ParentSolo';
					$messages[2]->date_envoi	= date('Y-m-d H:i:s');
					$messages[2]->texte			= 'ParentSolos.fr vous remercie pour votre compréhension.';


					// affiche le messages
					displayMessages($messages);

				} else { // membre non abonné

					// message système d'info
					$messages					= array();
					$messages[0]				= new stdClass();
					$messages[0]->genre			= 'system';
					$messages[0]->username		= 'ParentSolo';
					$messages[0]->date_envoi	= date('Y-m-d H:i:s');
					$messages[0]->texte			= 'Seuls les membres abonnés à Parentsolos.fr peuvent envoyer des messages sur le chat. [[[lien-abonnement]]]';

					// affiche le messages
					displayMessages($messages);

				}

			}

		}

	}

	// récup les messages
	function &getMessages($user_id_from, $user_id_to, $newOnly = 0, $limit = 5, $openConversation = false) {
		global $db;

		// variables
		$messages		= array();
		$messagesOld	= array();
		$messagesNew	= array();
		$where			= array();
		$_where			= '';
		$_where_custom	= '';
		$datetime		= date('Y-m-d H:i:s'); // on arrête le temps, pour ne pas avoir d'erreur de message qui sont insérés entre le SELECT et le UPDATE


		$where[]		= "cm.date_envoi <= '".$datetime."'";
		$where[]		= "(cm.user_id_from = '".$user_id_from."' OR cm.user_id_to = '".$user_id_from."')";
		$where[]		= "(cm.user_id_from = '".$user_id_to."' OR cm.user_id_to = '".$user_id_to."')";



		// génère le where
		$_where			= " WHERE ".implode(' AND ', $where);


		// uniquement lorsque l'on ouvre une covnersation
		if($openConversation) {

			$_where_custom	= "(cm.new_user_from = '1' OR cm.new_user_to = '1')";

		} else {

			$_where_custom	= "((cm.user_id_from = ".$user_id_from." AND cm.new_user_from = '1') OR (cm.user_id_to = ".$user_id_from." AND cm.new_user_to = '1'))";

		}


		// si on ne veut pas récupérer que les nouveaux messages
		if(!$newOnly) {

			// récup au maximum $limit anciens messages (anti flood)
			$query = "SELECT up.genre, u.username, cm.texte, cm.date_envoi"
			." FROM chat_message AS cm"
			." INNER JOIN user AS u ON u.id = cm.user_id_from"
			." INNER JOIN user_profil AS up ON up.user_id = u.id"
			.$_where." AND cm.new_user_from = '0' AND cm.new_user_to = '0'"
			." GROUP BY cm.id"
			." ORDER BY cm.date_envoi DESC"
			." LIMIT 0,".$limit
			;
			$messagesOld = $db->loadObjectList($query);
			$messagesOld = array_reverse($messagesOld);

		}

		// récup les nouveaux messages
		$query = "SELECT cm.id, up.genre, u.username, cm.texte, cm.date_envoi"
		." FROM chat_message AS cm"
		." INNER JOIN user AS u ON u.id = cm.user_id_from"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		.$_where." AND ".$_where_custom
		." GROUP BY cm.id"
		." ORDER BY cm.date_envoi ASC"
		;
		$messagesNew = $db->loadObjectList($query);

		// regroupe les 2 types de messages
		$messages = array_merge($messagesOld, $messagesNew);


		// met à jour le new_user_from des nouveaux messages
		$query = "UPDATE chat_message SET"
		." new_user_from = '0'"
		." WHERE user_id_from = ".$user_id_from." AND user_id_to = ".$user_id_to." AND date_envoi <= '".$datetime."'"
		;
		$db->query($query);

		// met à jour le new_user_to des nouveaux messages
		$query = "UPDATE chat_message SET"
		." new_user_to = '0'"
		." WHERE user_id_to = ".$user_id_from." AND user_id_from = ".$user_id_to." AND date_envoi <= '".$datetime."'"
		;
		$db->query($query);


		// met à jour la conversation
		$query = "UPDATE chat_conversation SET new = 0 WHERE user_id_from = '".$user_id_from."' AND user_id_to = '".$user_id_to."'";
		$db->query($query);


		return $messages;

	}


	// affiche une lsite de messages
	function displayMessages(&$messages) {
		global $db, $user;

		foreach($messages as $message) {

			if($message->texte) {

				// non abonné
				if(!$user->gold) {
					$message->texte = JL::messageEncode($message->texte, '[[[lien-abonnement]]]');
				}

				// traitement du message
				$texte	= setSmilies(nl2br(htmlentities($message->texte)));
				$texte	= str_replace('[[[lien-abonnement]]]', '<a href="'.SITE_URL.'/index.php?app=abonnement&action=tarifs" title="M\'abonner &agrave; Parentsolos.fr" target="_blank">[ Cliquez ici pour vous abonner ]</a>', $texte);

				?>
				<div class="message">
					<span class="<? echo $message->genre; ?>"><? echo $message->username; ?></span> dit:<br>
					<span class="heure"><? echo date('d/m/Y', strtotime($message->date_envoi)); ?> &agrave; <? echo date('H:i:s', strtotime($message->date_envoi)); ?></span><br>
					<p><? echo $texte; ?></p>
				</div>
			<?
			}
		}

	}


	// ajoute une conversation
	function addConversation($user_id_from, $user_id_to) {
		global $db;

		// on ne chat pas avec soi même
		if($user_id_from != $user_id_to) {

			// supprime la conversation existante au cas où
			$query = "DELETE FROM chat_conversation WHERE user_id_from = '".$user_id_from."' AND user_id_to = '".$user_id_to."'";
			$db->query($query);

			// user log
			$query = "INSERT INTO chat_conversation SET"
			." user_id_from = '".$user_id_from."',"
			." user_id_to = '".$user_id_to."',"
			." date_add = NOW()"
			;
			$db->query($query);

		}

	}


	// supprime la conversation chez l'utilisateur log
	function deleteConversation($user_id_from, $user_id_to) {
		global $db;

		// supprime la conversation de l'user log
		$query = "DELETE FROM chat_conversation WHERE user_id_from = '".$user_id_from."' AND user_id_to = '".$user_id_to."'";
		$db->query($query);

		// met à jour tous les messages de l'utilisateur dans cette conversation en tant que lu
		$query = "UPDATE chat_message SET new_user_from = 0 WHERE user_id_from = '".$user_id_from."' AND user_id_to = '".$user_id_to."'";
		$db->query($query);

		$query = "UPDATE chat_message SET new_user_to = 0 WHERE user_id_from = '".$user_id_to."' AND user_id_to = '".$user_id_from."'";
		$db->query($query);

	}


	// récup les conversations en cours de l'utilisateur $user_id_from
	function &getConversations($user_id_from, $user_id_to) {
		global $db;

		// variables
		$conversations	= array();
		$where			= array();
		$_where			= '';

		$where[]		= "cc.user_id_from = '".$user_id_from."'";

		// génère le where
		$_where			= " WHERE ".implode(' AND ', $where);


		// affecte d'office le new = 0 à la conversation en cours
		$query = "UPDATE chat_conversation SET new = 0 WHERE user_id_from = '".$user_id_from."' AND user_id_to = '".$user_id_to."'";
		$db->query($query);


		// récup les conversations
		$query = "SELECT u.id, u.username, cc.new AS nouveau, cc.user_id_to"
		." FROM chat_conversation AS cc"
		." INNER JOIN user AS u ON u.id = cc.user_id_to"
		.$_where
		." ORDER BY username ASC"
		;
		$conversations = $db->loadObjectList($query);

		return $conversations;

	}


	// affiche les conversations
	function displayConversations(&$conversations, $user_id_to) {
		global $lang_id;
		// aide
		?>
		<div class="conversationUsername<? echo $user_id_to ? '0' : 'On'; ?>" id="chatHelp" onClick="document.location='<? echo SITE_URL.'/index2.php?app=chat&lang='.$lang_id; ?>';">Aide</div>
		<div class="conversationCloseOff" style="visibility:hidden;">&nbsp;</div>
		<?

		// pour chaque conversation
		foreach($conversations as $conversation) {
		?>
			<div class="conversationUsername<? echo $conversation->id != $user_id_to ? $conversation->nouveau : 'On'; ?>" id="conversationOpen<? echo $conversation->id; ?>" onClick="chatOpenConversation(<? echo $conversation->id; ?>);"><? echo $conversation->username; ?></div>
			<div class="conversationCloseOff" id="conversationClose<? echo $conversation->id; ?>" onClick="chatCloseConversation(<? echo $conversation->id; ?>);" onMouseOver="this.className='conversationCloseOn';" onMouseOut="this.className='conversationCloseOff';">&nbsp;</div>
		<?
		}

	}


	// initialise la conversation
	function openConversation($user_id_from, $user_id_to) {
		global $db;


		// met à jour la conversation
		$query = "UPDATE chat_conversation SET new = 0, date_add = NOW() WHERE user_id_from = '".$user_id_from."' AND user_id_to = '".$user_id_to."'";
		$db->query($query);


		// récup les messages
		$messages =& getMessages($user_id_from, $user_id_to, 0, 5, true);

		// récup les infos de l'expéditeur (user log)
		$user_from 	=& getUserInfo($user_id_from);

		// récup les infos du destinataire
		$user_to 	=& getUserInfo($user_id_to);

		// récup la photo de l'utilisateur
		$user_from->photo 	= JL::userGetPhoto($user_from->id, '89', 'profil', $user_from->photo_defaut);

		// photo par défaut
		if(!$user_from->photo) {
			$user_from->photo = SITE_URL.'/parentsolo/images/parent-solo-89-'.$user_from->genre.'.jpg';
		}

		$user_to->photo 	= JL::userGetPhoto($user_to->id, '89', 'profil', $user_to->photo_defaut);

		// photo par défaut
		if(!$user_to->photo) {
			$user_to->photo = SITE_URL.'/parentsolo/images/parent-solo-89-'.$user_to->genre.'.jpg';
		}

		// récup les infos + détaillées du destinataire
		$query = "SELECT IFNULL(pc.nom, '') AS canton, IFNULL(pv.nom, '') AS ville, up.nb_enfants, CURRENT_DATE, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age, IF((UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) < ".(ONLINE_TIME_LIMIT+AFK_TIME_LIMIT).", 1, 0) AS online"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		." WHERE u.id = '".$user_to->id."'"
		." LIMIT 0,1"
		;
		$userInfo = $db->loadObject($query);

		?>
		<div class="chatMessages">
			<div class="disclaimer">
				<b>Attention</b>, assurez-vous de bien conna&icirc;tre la personne avec qui vous chattez avant de donner vos coordonn&eacute;es personnelles ou adresses email/msn.
			</div>
			<div class="messages" id="messages">
			<?
				// affiche les messages
				displayMessages($messages);
			?>
			</div>
			<div class="smilies">
				<? /*<img src="images/smiley2.gif" alt="(F)" onClick="chatSmiley('(F)');">*/ ?>
				<img src="images/smiley1.gif" alt="(C)" onClick="chatSmiley('(C)');">
				<img src="images/smiley6.gif" alt=":|" onClick="chatSmiley(':|');">
				<img src="images/smiley7.gif" alt=":)" onClick="chatSmiley(':)');">
				<img src="images/smiley8.gif" alt=":(" onClick="chatSmiley(':(');">
				<img src="images/smiley9.gif" alt=":D" onClick="chatSmiley(':D');">
				<img src="images/smiley10.gif" alt=":p" onClick="chatSmiley(':p');">
				<img src="images/smiley13.gif" alt=";)" onClick="chatSmiley(';)');">
				<img src="images/smiley11.gif" alt=":]" onClick="chatSmiley(':]');">
				<img src="images/smiley12.gif" alt=":x" onClick="chatSmiley(':x');">
			</div>
			<div class="formulaire">
				<input type="hidden" name="user_id_to" id="user_id_to" value="<? echo $user_to->id; ?>">
				<textarea name="texte" id="texte" rows="5" cols="10" class="texte" onkeypress="chatKey(event);"></textarea>
				<div class="envoyer" onClick="chatSendMessage();">&nbsp;</div>
				<img src="images/loading.gif" alt="Envoi de votre message en cours..." id="loadingSend" />
			</div>
		</div>
		<div class="chatUsers">
			<div class="user_to" onClick="self.opener.location.href='http://www.parentsolos.fr/index.php?app=profil&action=view&id=<? echo $user_to->id; ?>'">
				<img src="<? echo $user_to->photo; ?>" alt="<? echo $user_to->username; ?>">
				<span><? echo $user_to->username; ?></span>
				<span style="color:#FFF;"><? echo $user_to->age; ?> ans</span>
				<span style="color:<? echo $userInfo->online ? '#0F0' : '#F00'; ?>;"><? echo $userInfo->online ? 'en ligne' : 'hors ligne'; ?></span>
				<div class="sep1">&nbsp;</div>
				<? if($userInfo->canton) { ?><span><? echo htmlentities($userInfo->canton); ?></span><? } ?>
				<? if($userInfo->canton) { ?><span><? echo htmlentities($userInfo->ville); ?></span><? } ?>
				<span style="color:#FFF;"><? echo $userInfo->nb_enfants; ?> enfant<? echo $userInfo->nb_enfants > 1 ? 's' : ''; ?></span>
			</div>
			<div class="user_from">
				<div class="sep2">&nbsp;</div>
				<img src="<? echo $user_from->photo; ?>" alt="<? echo $user_from->username; ?>">
				<span><? echo $user_from->username; ?></span>
			</div>
		</div>

		<?

	}


	// convertit les codes smilies en images
	function setSmilies($texte) {

		$texte	= str_replace(':P', '<img src="images/smiley10.gif" alt="">', $texte);
		$texte	= str_replace(':p', '<img src="images/smiley10.gif" alt="">', $texte);
		$texte	= str_replace(':)', '<img src="images/smiley7.gif" alt="">', $texte);
		$texte	= str_replace(':(', '<img src="images/smiley8.gif" alt="">', $texte);
		$texte	= str_replace(':D', '<img src="images/smiley9.gif" alt="">', $texte);
		$texte	= str_replace(';)', '<img src="images/smiley13.gif" alt="">', $texte);
		$texte	= str_replace(':|', '<img src="images/smiley6.gif" alt="">', $texte);
		$texte	= str_replace('(C)', '<img src="images/smiley1.gif" alt="">', $texte);
		//$texte	= str_replace('(F)', '<img src="images/smiley2.gif" alt="">', $texte);
		$texte	= str_replace(':]', '<img src="images/smiley11.gif" alt="">', $texte);
		$texte	= str_replace(':x', '<img src="images/smiley12.gif" alt="">', $texte);

		return $texte;

	}

	/*function getHelp() {
		global $db, $user;

		// récup le nombre de conversations en cours
		$query = "SELECT COUNT(*) FROM chat_conversation WHERE user_id_from = '".$user->id."'";
		$conversationsNb = $db->loadResult($query);

	?>
		<div class="chatHelp">
		<h2>Bienvenue sur le chat Parentsolos.fr</h2>
		<p>
			<? if($conversationsNb) { ?>
				<b>Vous avez <? echo $conversationsNb; ?> conversation<? echo $conversationsNb > 1 ? 's' : ''; ?> en cours.</b><br>
				<br>
				Cliquez sur un des onglets &agrave; gauche pour ouvrir la conversation avec le membre indiqu&eacute; !
			<? } else { ?>
				Vous n'avez aucune conversation en cours.<br>
				<br>
				<b>Cliquez sur l'icone CHAT dans le profil d'un membre pour commencer &agrave; chatter !</b>
			<? } ?>
		</p>

		<h2>Pr&eacute;sentation du chat</h2>
		<p>
			Le chat est divis&eacute; en 4 parties:<br>
			<ul>
				<li>la liste de vos conversations</li>
				<li>le profil de votre correspondant(e)</li>
				<li>la conversation en cours</li>
				<li>le zone de saisie de texte</li>
			</ul>
		</p>

		<h2>Mes conversations en cours</h2>
		<p>
			Vous trouverez &agrave; gauche la liste de vos conversations en cours:<br>
			<br>
			<img src="images/chat-aide-2.jpg" alt="Chat Parentsolos.fr"><br>
			<br>
			Lorsqu'une personne vous contacte, un petit onglet rose clair est automatiquement ajout&eacute; &agrave; gauche.<br>
			Vous pouvez cliquer sur la croix blanche afin de fermer la conversation.<br>
			<br>
			Voici la signification des diff&eacute;rentes couleurs:<br>
			<ul>
				<li>rose clair (clignotant): votre correspondant(e) a &eacute;crit un nouveau message</li>
				<li>rose fonc&eacute;: conversation active ou en cours</li>
				<li>noir: conversation inactive (vous pouvez cliquer dessus pour afficher celle-ci)</li>
			</ul>

		</p>

		<h2>Mon/Ma correspondant(e)</h2>
		<p>
			Vous trouverez en haut &agrave; droite un aper&ccedil;u du profil de votre correspondant(e):<br>
			<br>
			<img src="images/chat-aide-3.jpg" alt="Chat Parentsolo.ch"><br>
			<br>
			Lorsque vous souhaitez chatter avec un membre, v&eacute;rifiez bien si votre correspondant(e) est <span style="color:#0F0;">en ligne</span> ou <span style="color:#F00;">hors ligne</span>.<br>
			<br>
			Si votre correspondant(e) est hors ligne, vos messages lui seront remis d&egrave;s qu'il ou elle se connectera !
		</p>

		<h2>Ma conversation en cours</h2>
		<p>
			Au milieu de la fen&ecirc;tre se trouve la conversation en cours:<br>
			<br>
			<img src="images/chat-aide-4.jpg" alt="Chat Parentsolos.fr"><br>
			<br>
			En rose s'affiche les pseudos des mamans, en bleu celui des papas.<br>
			Lorsque vous ouvrez une ancienne conversation, les derniers messages &eacute;chang&eacute;s s'afficheront.<br>
			C'est pourquoi la date des messages est affich&eacute;e en dessous du pseudo, en gris.
		</p>

		<h2>Ma zone de saisie de texte</h2>
		<p>
			En bas, vous pouvez r&eacute;diger vos messages:<br>
			<br>
			<img src="images/chat-aide-5.jpg" alt="Chat Parentsolos.fr"><br>
			<br>
			En cliquant sur un smiley, celui-ci est ajout&eacute; &agrave; la suite de votre message.<br>
			Vous pouvez aussi directement tapper le code du smiley, par exemple &laquo; :) &raquo;, celui-ci sera automatiquement affich&eacute; sous forme de smiley.
		</p>
		</div>
	<?
	}*/

?>
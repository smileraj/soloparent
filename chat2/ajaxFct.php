<?php
	session_start();

	// config
	global $langString;
	if (isset($_GET['lang'])){
		$langue="lang=".$_GET['lang'];
		if ($_GET['lang']!="fr")$langString="_".$_GET['lang'];
		else $langString="";
	} else {
		header('Status: 301 Moved Permanently', false, 301);
		if(isset($_SERVER["QUERY_STRING"]) && !empty($_SERVER["QUERY_STRING"])){
			$string="?".$_SERVER["QUERY_STRING"]."&lang=fr";
		} else {
			$string="?lang=fr";
		}
		header("Location: ".$_SERVER["PHP_SELF"].$string);
		die();
	}
	require_once("lang/chat.$_GET[lang].php");


	require_once('../config.php');

	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');

	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');
	global $db;
	global $user;
	$db	= new DB();

	// module d'authentification, qui n'affiche rien
	// params
	$action			= JL::getVar('action', false);
	$lang_id		= JL::getVar('lang_id', 'fr');
	//$user_id_from	= intval(JL::getVar('user_id_from', 0));
	$user_id_to		= intval(JL::getVar('user_id_to', 0));
	$user_id_to_new	= intval(JL::getVar('id', 0));
	if($user_id_to_new){
		$user_id_to = $user_id_to_new;
	}
	$user_id_to_close= intval(JL::getVar('user_id_to_close', 0));
	//$user_id_to		= intval(JL::getVar('id', 0));
	$newOnly		= intval(JL::getVar('newonly', 0));
	$key			= JL::getVar('key', '');
	$texte			= utf8_decode(JL::getVar('texte', '', true));

	// crée un objet content les infos de l'utilisateur
	JL::loadMod('auth');
	$user_id_from	= $user->id;
	$user = getUserInfo($user_id_from);
	//print_r($user);
	//echo'auth';die();


	// vérifie que le user_id_form est bien renseigné, et que la key correspond
	if(!$user->id && $action /*|| !checkUserKey($key)*/) {
//echo"test";die();
		die("connectTimeOut");
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
		$conversations = getConversations($user->id, $user_id_to);
		displayConversations($conversations, $user_id_to);
		break;

		case 'openConversation':
		if($user_id_to) {
			openConversation($user->id, $user_id_to, $newOnly);
		}
		break;

		case 'sendMessage':
		//echo "$user->id, $user_id_to, $texte";
		if($user_id_to) {
			sendMessage($user->id, $user_id_to, $texte);
		}
		break;

		case 'getNewMessages':
			//echo$user_id_to."/".$user->id;
		if($user_id_to) {
			getNewMessages($user->id, $user_id_to);
		}
		break;

		case 'closeConversation':
		if($user_id_to_close) {
			deleteConversation($user->id, $user_id_to_close);
		}
		break;

		default:
		//die();
		break;

	}

	// déconnexion DB
	//$db->disconnect();

	// récup les infos de l'utilisateur
	function getUserInfo($user_id) {
		global $db, $langString;

		$userInfo = array();

		/*$query = "SELECT `u`.`id`, `u`.`username`, `u`.`confirmed`, `u`.`creation_date`, `up`.`genre`, `up`.`photo_defaut`, `us`.`gold_limit_date`,(YEAR(CURRENT_DATE)-YEAR(`up`.`naissance_date`)) - (RIGHT(CURRENT_DATE,5) < RIGHT(`up`.`naissance_date`,5)) AS `age`, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) as `last_online_time`, `upc`.`nom` as `canton`, `upv`.`nom` as `ville`"
		." FROM `user` AS `u`"
		." INNER JOIN `user_profil` AS `up` ON `up`.`user_id` = `u`.`id`"
		." INNER JOIN `profil_canton` AS `upc` ON `upc`.`id` = `up`.`canton_id`"
		." INNER JOIN `profil_ville` AS `upv` ON `upv`.`id` = `up`.`canton_id`"
		." INNER JOIN `user_stats` AS `us` ON `us`.`user_id` = `u`.`id`"
		." WHERE `u`.`id` = '".$user_id."' AND `u`.`published` > 0 AND `u`.`confirmed` > 0"
		." LIMIT 0,1 ;";
		$userInfo = $db->loadObject($query);
*/
		$query = "SELECT `u`.`id`, `u`.`username`, `u`.`confirmed`, `u`.`creation_date`, `up`.`genre`, `up`.`photo_defaut`, `us`.`gold_limit_date`,`up`.`naissance_date`, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) as `last_online_time`, `up`.`canton_id`, `up`.`ville_id`, `up`.`nb_enfants` as `enfants`"
		." FROM `user` AS `u`"
		." INNER JOIN `user_profil` AS `up` ON `up`.`user_id` = `u`.`id`"
		//." INNER JOIN `profil_canton` AS `upc` ON `upc`.`id` = `up`.`canton_id`"
		//." INNER JOIN `profil_ville` AS `upv` ON `upv`.`id` = `up`.`canton_id`"
		." INNER JOIN `user_stats` AS `us` ON `us`.`user_id` = `u`.`id`"
		." WHERE `u`.`id` = '".$user_id."' AND `u`.`published` > 0 AND `u`.`confirmed` > 0"
		." LIMIT 0,1 ;";
		$userInfo = $db->loadObject($query);

		$userInfo->canton="";
		$userInfo->ville="";

		if ($userInfo->canton_id) {
			$sqlCanton="SELECT `nom` FROM `profil_canton` WHERE `id` = $userInfo->canton_id ;" ;
			$userCanton = $db->loadObject($sqlCanton);
			$userInfo->canton = utf8_encode($userCanton->nom);
		}
		if ($userInfo->ville_id) {
			$sqlVille="SELECT `nom` FROM `profil_ville` WHERE `id` = $userInfo->ville_id ;";
			$userVille = $db->loadObject($sqlVille);
			$userInfo->ville = utf8_encode($userVille->nom);
		}




		$userInfo->gold = ($userInfo->gold_limit_date == '0000-00-00' || ($userInfo->gold_limit_date != '0000-00-00' && strtotime($userInfo->gold_limit_date) < time())) ? false : true;

		// Ajout par SC
		/*$sqlEnf="SELECT COUNT(*) as qty FROM `user_enfant` WHERE `user_id` = '".$user_id."' ;";
		//$EnfReq = mysql_query($sqlEnf);
		//$enfants = mysql_fetch_object($EnfReq);
		$enfants = $db->loadObject($sqlEnf);
		$userInfo->enfants = $enfants->qty;*/

		if (intval($userInfo->last_online_time) > (ONLINE_TIME_LIMIT + AFK_TIME_LIMIT)) {
			$userInfo->is_online = 0;
		} else {
			$userInfo->is_online = 1;
		}

		$userInfo->photoURL = JL::userGetPhoto($user_id, '109', 'profil', $userInfo->photo_defaut);
//die($userInfo->photoURL);
		// photo par défaut
		if(!$userInfo->photoURL||empty($userInfo->photoURL)) {
			$userInfo->photoURL = SITE_URL.'/parentsolo/images/parent-solo-109-'.$userInfo->genre.'.jpg';
		}

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
		$messages = getMessages($user_id_from, $user_id_to, 1);

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
		global $db, $user, $langAjaxChat, $langChat;

		$userTo = getUserInfo($user_id_to);

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
				$messages[0]->texte			= utf8_decode($langChat["sysMessage_1"]);//'Vous ne pouvez pas envoyer de message à un utilisateur de votre liste noire.';

				// affiche le messages
				displayMessages($messages);

			} elseif($blacklist->user_from_bl) {

				// message système d'info
				$messages					= array();
				$messages[0]				= new stdClass();
				$messages[0]->genre			= 'system';
				$messages[0]->username		= 'ParentSolo';
				$messages[0]->date_envoi	= date('Y-m-d H:i:s');
				$messages[0]->texte			= utf8_decode($langChat["sysMessage_2"]);//'Vous ne pouvez pas envoyer de message à cet utilisateur car vous êtes dans sa liste noire.';

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
					//getNewMessages($user_id_from, $user_id_to);

				} elseif($user->gold && $user->confirmed == 2) { // confirmation en attente

					// message système d'info
					$messages					= array();
					$messages[0]				= new stdClass();
					$messages[0]->genre			= 'system';
					$messages[0]->username		= 'ParentSolo';
					$messages[0]->date_envoi	= date('Y-m-d H:i:s');
					$messages[0]->texte			= $langChat["sysMessage_3"];//'Votre profil n\'a pas encore été validé par un modérateur. Vous allez recevoir un appel téléphonique d\'ici 1 à 2 jours ouvrés afin de confirmer votre profil. Ces jours d\'attente seront bien entendu ajoutés à votre abonnement.';

					$messages[1]				= new stdClass();
					$messages[1]->genre			= 'system';
					$messages[1]->username		= 'ParentSolo';
					$messages[1]->date_envoi	= date('Y-m-d H:i:s');
					$messages[1]->texte			= $langChat["sysMessage_4"];//'Cette mesure est prise dans le but de vous garantir une qualité de service optimale. Ainsi, toutes personnes mal intentionnées qui souhaiteraient contourner la confirmation téléphonique ne pourront pas contacter les membres tant que leur profil ne sera pas validé.';

					$messages[2]				= new stdClass();
					$messages[2]->genre			= 'system';
					$messages[2]->username		= 'ParentSolo';
					$messages[2]->date_envoi	= date('Y-m-d H:i:s');
					$messages[2]->texte			= $langChat["sysMessage_5"];//'ParentSolo.ch vous remercie pour votre compréhension.';


					// affiche le messages
					displayMessages($messages);

				} else { // membre non abonné

					// message système d'info
					$messages					= array();
					$messages[0]				= new stdClass();
					$messages[0]->genre			= 'system';
					$messages[0]->username		= 'ParentSolo';
					$messages[0]->date_envoi	= date('Y-m-d H:i:s');
					$messages[0]->texte			= $langChat["sysMessage_6"];//'Seuls les membres abonnés à Parentsolo.ch peuvent envoyer des messages sur le chat. [[[lien-abonnement]]]';

					// affiche le messages
					displayMessages($messages);

				}

			}

		}

	}

	// récup les messages
	function getMessages($user_id_from, $user_id_to, $newOnly = 0, $limit = 5, $openConversation = false) {
		//echo "$user_id_from, $user_id_to";
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
			$query = "SELECT up.genre, u.username, cm.texte, cm.date_envoi, cm.user_id_from"
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
		$query = "SELECT cm.id, up.genre, u.username, cm.texte, cm.date_envoi, cm.user_id_from"
		." FROM chat_message AS cm"
		." INNER JOIN user AS u ON u.id = cm.user_id_from"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		.$_where." AND ".$_where_custom
		." GROUP BY cm.id"
		." ORDER BY cm.date_envoi ASC"
		;
		//echo $query;
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
				$texte	= str_replace('[[[lien-abonnement]]]', '<a href="'.SITE_URL.'/index.php?app=abonnement&action=tarifs" title="M\'abonner &agrave; Parentsolo.ch" target="_blank">[ Cliquez ici pour vous abonner ]</a>', $texte);

				?>
				<div class="message_<?php echo ($user->id==$message->user_id_from)?"from":"to";?>">
					<span class="<? echo $message->genre; ?>"><? echo $message->username; ?></span><br>
					<span class="heure"><? echo date('d/m/Y', strtotime($message->date_envoi)); ?> &agrave; <? echo date('H:i:s', strtotime($message->date_envoi)); ?></span>
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
	function getConversations($user_id_from, $user_id_to) {
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
	function displayConversations($conversations, $user_id_to) {
		global $lang_id;
		// aide
		/*?>
		<div class="conversationUsername<? echo $user_id_to ? '0' : 'On'; ?>" id="chatHelp" onClick="document.location='<? echo SITE_URL.'/index2.php?app=chat&lang='.$lang_id; ?>';">Aide</div>
		<div class="conversationCloseOff" style="visibility:hidden;">&nbsp;</div>
		<?
*/
		// pour chaque conversation
		foreach($conversations as $conversation) {

			?><div class="conv<? echo ($conversation->id != $user_id_to) ? $conversation->nouveau : 'On'; ?>" id="conv_<? echo $conversation->id; ?>" onClick="getConvUserInfos(<? echo $conversation->id; ?>);">
			<div onclick="closeConv(<? echo$conversation->id; ?>);" class="close"></div>
			<p><? echo $conversation->username; ?></p></div>
			
			
			<?php
		}

	}


	// initialise la conversation
	function openConversation($user_id_from, $user_id_to) {
		global $db;


		// met à jour la conversation
		$query = "UPDATE chat_conversation SET new = 0, date_add = NOW() WHERE user_id_from = '".$user_id_from."' AND user_id_to = '".$user_id_to."'";
		$db->query($query);


		// récup les messages
		$messages = getMessages($user_id_from, $user_id_to, 0, 5, true);


				// affiche les messages
				displayMessages($messages);

	}


	// convertit les codes smilies en images
	function setSmilies($texte) {
	
		/*
		* 	Il faudrait gerer dynamiquement les smileys car ceci n'est pas une bonne methode. Elle existe historiquement uniquement.
		*/
		
		$texte = str_replace('(C)', '<img src="../images/smileys/standard/coeur.gif"',$texte);
		$texte = str_replace('(B)', '<img src="../images/smileys/standard/cool.gif" alt="">',$texte);
		$texte = str_replace('^.', '<img src="../images/smileys/standard/001_huh.gif" alt="">',$texte);
		$texte = str_replace('8)', '<img src="../images/smileys/standard/001_rolleyes.gif" alt="">',$texte);
		$texte = str_replace(':)', '<img src="../images/smileys/standard/001_smile.gif" alt="">',$texte);
		$texte = str_replace(':p', '<img src="../images/smileys/standard/001_tongue.gif" alt="">',$texte);
		$texte = str_replace('#)', '<img src="../images/smileys/standard/001_tt1.gif" alt="">',$texte);
		$texte = str_replace(':q', '<img src="../images/smileys/standard/001_tt2.gif" alt="">',$texte);
		
		$texte = str_replace(':s', '<img src="../images/smileys/standard/001_unsure.gif" alt="">',$texte);
		$texte = str_replace('(A)', '<img src="../images/smileys/standard/001_wub.gif" alt="">',$texte);
		$texte = str_replace('v(', '<img src="../images/smileys/standard/angry.gif" alt="">',$texte);
		$texte = str_replace(':D', '<img src="../images/smileys/standard/biggrin.gif" alt="">',$texte);
		$texte = str_replace('%|', '<img src="../images/smileys/standard/blink.gif" alt="">',$texte);
		$texte = str_replace('(F)', '<img src="../images/smileys/standard/blush.gif" alt="">',$texte);
		$texte = str_replace('(:F)', '<img src="../images/smileys/standard/blushing.gif" alt="">',$texte);
		$texte = str_replace(':/', '<img src="../images/smileys/standard/bored.gif" alt="">',$texte);
		
		$texte = str_replace('||', '<img src="../images/smileys/standard/closedeyes.gif" alt="">',$texte);
		$texte = str_replace(':?', '<img src="../images/smileys/standard/confused1.gif" alt="">',$texte);
		$texte = str_replace(':\'(', '<img src="../images/smileys/standard/crying.gif" alt="">',$texte);
		$texte = str_replace(':@', '<img src="../images/smileys/standard/cursing.gif" alt="">',$texte);
		$texte = str_replace('|/', '<img src="../images/smileys/standard/glare.gif" alt="">',$texte);
		$texte = str_replace('^D', '<img src="../images/smileys/standard/laugh.gif" alt="">',$texte);
		$texte = str_replace('(lol)', '<img src="../images/smileys/standard/lol.gif" alt="">',$texte);
		$texte = str_replace('(M)', '<img src="../images/smileys/standard/mad.gif" alt="">',$texte);
		
		$texte = str_replace('OMG', '<img src="../images/smileys/standard/ohmy.gif" alt="">',$texte);
		$texte = str_replace(':(', '<img src="../images/smileys/standard/sad.gif" alt="">',$texte);
		$texte = str_replace('%(', '<img src="../images/smileys/standard/scared.gif" alt="">',$texte);
		$texte = str_replace('(S)', '<img src="../images/smileys/standard/sleep.gif" alt="">',$texte);
		$texte = str_replace('v)', '<img src="../images/smileys/standard/sneaky2.gif" alt="">',$texte);
		$texte = str_replace('(N)', '<img src="../images/smileys/standard/thumbdown.gif" alt="">',$texte);
		$texte = str_replace('(2Y)', '<img src="../images/smileys/standard/thumbup.gif" alt="">',$texte);
		
		$texte = str_replace('(Y)', '<img src="../images/smileys/standard/thumbup1.gif" alt="">',$texte);
		$texte = str_replace('%D', '<img src="../images/smileys/standard/w00t.gif" alt="">',$texte);
		$texte = str_replace(';)', '<img src="../images/smileys/standard/wink.gif" alt="">',$texte);
		$texte = str_replace(':P', '<img src="../images/smileys/standard/tongue_smilie.gif" alt="">',$texte);
		$texte = str_replace('(a)', '<img src="../images/smileys/standard/ange.gif" alt="">',$texte);
		$texte = str_replace('(h)', '<img src="../images/smileys/standard/joie.gif" alt="">',$texte);
		$texte = str_replace('(d)', '<img src="../images/smileys/standard/demon.gif" alt="">',$texte);
		
		$texte = str_replace('(NO)', '<img src="../images/smileys/standard/non.gif" alt="">',$texte);
		$texte = str_replace('=|', '<img src="../images/smileys/standard/mellow.gif" alt="">',$texte);
		$texte = str_replace(';p', '<img src="../images/smileys/standard/tire-la-langue-cligne.gif" alt="">',$texte);
		$texte = str_replace('(b)', '<img src="../images/smileys/standard/boude.gif" alt="">',$texte);
		$texte = str_replace('^D', '<img src="../images/smileys/standard/charmeur.gif" alt="">',$texte);
		$texte = str_replace('(danse)', '<img src="../images/smileys/standard/danse.gif" alt="">',$texte);
		$texte = str_replace('(ptdr)', '<img src="../images/smileys/standard/ptdr.gif" alt="">',$texte);
		
		$texte = str_replace('^^', '<img src="../images/smileys/standard/^^.gif" alt="">',$texte);
		$texte = str_replace(':\')', '<img src="../images/smileys/standard/emu.gif" alt="">',$texte);
		$texte = str_replace(':x', '<img src="../images/smileys/standard/malade.gif" alt="">',$texte);
		$texte = str_replace('(mouche)', '<img src="../images/smileys/standard/mouche.gif" alt="">',$texte);
		$texte = str_replace('(xd)', '<img src="../images/smileys/standard/xd.gif" alt="">',$texte);
		$texte = str_replace('(zip)', '<img src="../images/smileys/standard/zip.gif" alt="">',$texte);
		$texte = str_replace('(uC)', '<img src="../images/smileys/standard/coeur_briser.png" alt="">',$texte);

		return $texte;

	}

?>

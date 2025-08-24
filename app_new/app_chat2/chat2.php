<?php

	// sécurité
	defined('JL') or die('Error 401');

	require_once('chat2.html.php');

	global $user, $langue;

	// utilisateur non log
	if(!$user->id) {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription&'.$langue);
	}


	// charge le chat
	chatLoad();


	// fonction pour charger le chat
	function chatLoad() {
		global $langue;
		global $user, $db;

		// si on ouvre le chat avec déjà un destinataire
		$user_id_to	= intval(JL::getVar('id', 0));


		// récup les date et heure de création du compte utilisateur pour générer une clé de sécurité
		$query = "SELECT creation_date FROM user WHERE id = '".$user->id."' LIMIT 0,1";
		$creation_date = $db->loadResult($query);

		// clé de sécurité
		$key = md5(str_replace('-', $user->id, $creation_date));


		// récup le nombre de conversations en cours
		$query = "SELECT COUNT(*) FROM chat_conversation WHERE user_id_from = '".$user->id."'";
		$conversationsNb = $db->loadResult($query);


		// affiche le chat
		HTML_chat::chatTemplate($key, $user_id_to, $conversationsNb);

	}

?>

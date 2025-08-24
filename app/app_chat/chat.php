<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('chat.html.php');

	global $user, $langue;

	// utilisateur non log
	if(!$user->id) {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription&'.$langue);
	}

	// Redirection vers le nouveau chat
	$user_id_to	= intval(JL::getVar('id', 0));
	$redirection=SITE_URL.'/chat2/chat.php?'.$langue;
	if ($user_id_to) {
		$redirection.="&id=$user_id_to";
	}
	JL::redirect($redirection);
	// Fin de la redirection vers le nouveau chat


	// charge le chat
	chatLoad();


	// fonction pour charger le chat
	function chatLoad() {
		global $langue;
		global $user, $db;
		global $correspondant;
		
		JL::setSession('correspondant_id', 0);
		// si on ouvre le chat avec d&eacute;j&agrave; un destinataire
		$user_id_to	= intval(JL::getVar('id', 0));


		// r&eacute;cup les date et heure de cr&eacute;ation du compte utilisateur pour g&eacute;n&eacute;rer une cl&eacute; de s&eacute;curit&eacute;
		$query = "SELECT creation_date FROM user WHERE id = '".$user->id."' LIMIT 0,1";
		$creation_date = $db->loadResult($query);

		// cl&eacute; de s&eacute;curit&eacute;
		$key = md5(str_replace('-', $user->id, $creation_date));


		// r&eacute;cup le nombre de conversations en cours
		$query = "SELECT COUNT(*) FROM chat_conversation WHERE user_id_from = '".$user->id."' AND new =1";
		$conversationsNb = $db->loadResult($query);


		// affiche le chat
		HTML_chat::chatTemplate($key, $user_id_to, $conversationsNb);

	}

?>

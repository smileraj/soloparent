<?php

// s�curit�
	define('JL', true);

	//fichier de configuration
	require_once('config.php');

	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');
	
	// framework base de donn�es
	require_once(SITE_PATH.'/framework/mysql.class.php');

			$db	= new DB();
	
	// si connexion DB impossible
	if(!$db->getConnexion()) {
		include('offline.php');
		exit;
	}
	
	
include('mod/concept.php');

?>
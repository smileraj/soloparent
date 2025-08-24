<?php

	// config
	require_once('config.php');

	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');

	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');
	include("lang/app_home.".$_GET['lang'].".php");
	
	$db	= new DB();
	

	// params
	$canton_id	= intval(JL::getVar('canton_id', true));
	$ville_id	= intval(JL::getVar('ville_id', true));
	$prefix		= JL::getVar('prefix', true);

	$options	= array();
	$villes		= array();

	$options[] = JL::makeOption('0', $lang_apphome["Ville"]);


	if($canton_id) {

		$query = "SELECT id AS value, nom AS text"
		." FROM profil_ville"
		." WHERE canton_id = '".$canton_id."' and published = 1"
		." ORDER BY nom ASC"
		;
		$villes = $db->loadObjectList($query);

		$options	= array_merge($options, $villes);
	}

	echo 'blba'.utf8_decode(JL::makeSelectList($options, $prefix.'ville_id', 'id="'.$prefix.'ville_id"', 'value', 'text', $ville_id));

	// déconnexion DB
	$db->disconnect();

?>

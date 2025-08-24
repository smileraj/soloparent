<?php

	// session php
	session_start();
	define('JL', true);
	
	// mode offline avec erreur 404: � d�commenter que lorsque l'on veut masquer le site en d�v
	//include('../offline404.php');
	
	
	// config
	require_once('../config.php');
	
	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');
	
	// framework base de donn�es
	require_once(SITE_PATH.'/framework/mysql.class.php');
	$db	= new DB();
	
	// si connexion DB impossible
	if(!$db->getConnexion()) {
		include(SITE_PATH.'/offline.php');
		exit;
	}
	
	
	// cr�e l'objet global $user
	$user		= new stdClass();
	
	
	// variables cl�s, qui pourront �tre appel�es partout via 'global'
	$app		= JL::getVar('app', SITE_APP_HOME_ADMIN_EXPERT); // application � charger
	$action		= JL::getVar('action', '');			// action demand�e � l'application
	
	
	// module d'authentification, qui n'affiche rien
	JL::loadModExpert('auth');
	
	// v�rifie que l'utilisateur est log, et qu'il peut se connecter � l'admin (gid > 1)
	if((!$user->id || $user->gid < 1) && $app != SITE_APP_HOME_ADMIN) {
		$app = 'panel';
		JL::redirect(SITE_URL_ADMIN_EXPERT.'/index.php');
	}
	
	
	// si l'application pass�e en param�tre n'existe pas
	if(!JL::checkAppExpert($app)) {
		$app	= '404'; 	// on chargera l'application 404
	}
	
	// ouverture du buffer
	ob_start();
	
	
	// template du site (avec possibles redirections 301 dans les applications, d'o� l'utilisation du output buffering)
	require_once(SITE_PATH_ADMIN_EXPERT.'/'.SITE_TEMPLATE.'/'.SITE_TEMPLATE.'.php');
	

	// affiche le contenu du buffer et vide celui-ci
	@ob_end_flush();
	
?>

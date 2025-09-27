<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	// session php
	session_start();
	
	define('JL', true);
	// mode offline avec erreur 404: � d�commenter que lorsque l'on veut masquer le site en d�v
	//include('../offline404.php');
	
	
	// config
	require_once('../config.php');
	
	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');
	
	// cr�e l'objet global $user
	$user		= new stdClass();
	
	
	// variables cl�s, qui pourront �tre appel�es partout via 'global'
	$app		= JL::getVar('app', SITE_APP_HOME_ADMIN); // application � charger
	$action		= JL::getVar('action', '');			// action demand�e � l'application
	
	// framework base de donn�es
	if($app=='mailing_auto'){
		require_once(SITE_PATH.'/framework/mysql2.class.php');
	}else{
		
		require_once(SITE_PATH.'/framework/mysql.class.php');
	}
	$db	= new DB();
	
	// si connexion DB impossible
	if(!$db->getConnexion()) {
		include(SITE_PATH.'/offline.php');
		exit;
	}
	
	
	
	
	
	// module d'authentification, qui n'affiche rien
	JL::loadMod('auth', 'admin');
	
	// v�rifie que l'utilisateur est log, et qu'il peut se connecter � l'admin (gid > 1)
	if((!$user->id || $user->gid < 1) && $app != SITE_APP_HOME_ADMIN) {
		$app = 'panel';
		JL::redirect(SITE_URL_ADMIN.'/index.php');
	}
	
	
	// si l'application pass�e en param�tre n'existe pas
	if(!JL::checkApp($app, 'admin')) {
		$app	= '404'; 	// on chargera l'application 404
	}
	
	// ouverture du buffer
	ob_start();
	
	
	// template du site (avec possibles redirections 301 dans les applications, d'o� l'utilisation du output buffering)
	if(($app=='mailing' && $action=='apercu')||($app=='mailing_auto' && $action=='apercu')){
		require_once(SITE_PATH_ADMIN.'/'.SITE_TEMPLATE.'/parentsolo_mailing.php');
	}elseif($app=='mailing_auto' && $action!='apercu'){
		require_once(SITE_PATH_ADMIN.'/'.SITE_TEMPLATE.'/parentsolo_new.php');
	}elseif($app=='redim'){
		require_once(SITE_PATH_ADMIN.'/'.SITE_TEMPLATE.'/parentsolo_redim.php');
	}else{
		require_once(SITE_PATH_ADMIN.'/'.SITE_TEMPLATE.'/'.SITE_TEMPLATE.'.php');
	}
	

	// affiche le contenu du buffer et vide celui-ci
	@ob_end_flush();
	
?>

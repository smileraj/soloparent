<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	// session php
	session_start();
	define('JL', true);
	$date_suspension = strtotime('2016-03-01');
	$date_jour = time();
	
   if($date_jour >= $date_suspension){
		
	 include('offline-2016.php'); exit;
	 
	}else{
		
		// mode offline avec erreur 404: � d�commenter que lorsque l'on veut masquer le site en d�v
	 include('offline.php'); 

		// config
		require_once('config.php');
		
		// MVC
		require_once(SITE_PATH.'/framework/controller.class.php');
		require_once(SITE_PATH.'/framework/model.class.php');
		require_once(SITE_PATH.'/framework/view.class.php');
		
		// obligatoire
		require_once(SITE_PATH.'/framework/joomlike.class.php');
		require_once(SITE_PATH.'/framework/mysql.class.php');
		
		// facultatif
		require_once(SITE_PATH.'/framework/pagination.class.php');
		$db	= new DB();

		// si connexion DB impossible
		if(!$db->getConnexion()) {
			include('offline.php');
			exit;
		}

		// Ajout� par Site Concept pour les traductions
	 /*// Une redirection permanente vers l'url avec la langue en $_GET est effectu�e
		if (isset($_GET['lang'])&&($_GET['lang']=='fr' || $_GET['lang']=='en' || $_GET['lang']=='de')){
			$langue="lang=".$_GET['lang'];
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

		// cree l'objet global $user
		$user			= new stdClass();


		// variables cles, qui pourront etre appelees partout via 'global'
		$app		= JL::getVar('app', SITE_APP_HOME); // application � charger
		$action		= JL::getVar('action', '');			// action demandee � l'application


		// si l'application passee en parametre n'existe pas
		if(!JL::checkApp($app)) {
			$app	= '404'; 	// on chargera l'application 404
		}


		// module d'authentification, qui n'affiche rien
		JL::loadMod('auth');


		// ouverture du buffer
		ob_start();


		// template du site (avec possibles redirections 301 dans les applications, d'o� l'utilisation du output buffering)
		if($app=="profil" && ($action=="view"||$action=="view2"||$action=="view3"||$action=="view4"||$action=="view5")){
		//if($app=="profil" && ($action=="view" || $action=="view2" || $action=="view3" || $action=="view4" || $action=="view5" || $action=="view6")){
			require_once(SITE_PATH.'/'.SITE_TEMPLATE.'/'.SITE_TEMPLATE.'_profil.php');
		}elseif($app=="home"){
			require_once(SITE_PATH.'/'.SITE_TEMPLATE.'/'.SITE_TEMPLATE.'_home.php');
		}else{
			require_once(SITE_PATH.'/'.SITE_TEMPLATE.'/'.SITE_TEMPLATE.'.php');
		}
		*/


		// affiche le contenu du buffer et vide celui-ci
		@ob_end_flush();

		// d�connexion DB
		$db->disconnect();
	}

?>

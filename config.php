<?php

	// s�curit�: si JL n'est pas d�fini, c'est qu'une tentative d'acc�s direct a �t� effectu�e dans les fichiers en question
	//define('JL', true);
	
	// base de donn�es
	//define('DB_SERVER', 				'mysql.parentsolo.ch');
	
	if($_SERVER['REMOTE_ADDR']=='::1'){
		define('DB_SERVER', 				'127.0.0.1');
		define('DB_USERNAME', 				'root');
		define('DB_PASSWORD', 				'Esales');
		define('DB_DATABASE', 				'SP');
	}else{
		define('DB_SERVER', 				'blatmedi.mysql.db.internal');
		define('DB_USERNAME', 				'blatmedi_soloch');
		define('DB_PASSWORD', 				'parentsoloch@dev');
		define('DB_DATABASE', 				'blatmedi_parentsoloch1');
	}
	
	
	// chemins
	define('SITE_PATH', 				$_SERVER["DOCUMENT_ROOT"].'/');
	define('SITE_PATH_ADMIN', 			$_SERVER["DOCUMENT_ROOT"].'/admin4ps');
	define('SITE_PATH_ADMIN_EXPERT', 	$_SERVER["DOCUMENT_ROOT"].'/admin4expertps');
	//define('SITE_URL', 					'https://www.parentsolo.ch');
	define('SITE_URL', 					'http://localhost');
	//define('SITE_URL_ADMIN', 			'https://www.parentsolo.ch/admin4ps');
	define('SITE_URL_ADMIN', 			'http://localhost/admin4ps');
	define('SITE_URL_ADMIN_EXPERT', 	'http://localhost/admin4expertps');
	//define('SITE_URL_ADMIN_EXPERT', 	'https://www.parentsolo.ch/admin4expertps');
	
	// dossier du template � utiliser
	define('SITE_TEMPLATE',				'parentsolo');
	
	// application charg�e sur la page d'accueil du site et site admin
	define('SITE_APP_HOME',				'home');
	define('SITE_APP_HOME_ADMIN',		'panel');
	define('SITE_APP_HOME_ADMIN_EXPERT',		'panel');
	
	// mail
	define('SITE_MAIL_FROM',			'ParentSolo.ch');
	define('SITE_MAIL',					'no-reply@parentsolo.ch');

	// dur�e d'inactivit� - en secondes - pendant laquelle un utilisateur est consid�r� comme "en ligne"
	define('ONLINE_TIME_LIMIT',			300); // 5 min
	define('AFK_TIME_LIMIT',			900); // 15 min
	
	// nombre de jours � offir d�s l'inscription
	define('ABONNEMENT_INITIAL',		0);
	
	// r�sultats de recherches
	define('RESULTS_NB_LISTE',			10);
	define('RESULTS_NB_LISTE_ADMIN',	10);
	define('RESULTS_NB_GALERIE',		10);
	
	define('LISTE_RESULT', 12);
	define('CONTENU_PAGINATION_RAYON',		5);
	define('LISTE_TITRE_CHAR',		40);
	define('LISTE_INTRO_CHAR',		200);
	
	define('TITRE_HOME',		18);
	define('INTRO_HOME',		85);
	
	// timers
	define('TIMER_POPIN',				30000); // secondes
	define('TIMER_CHAT',				10000); // secondes
    
?>



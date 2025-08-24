<?php

	// sécurité: si JL n'est pas défini, c'est qu'une tentative d'accès direct a été effectuée dans les fichiers en question
	define('JL', true);
	
	// base de données
	//define('DB_SERVER', 				'mysql.parentsolo.ch');
	define('DB_SERVER', 				'localhost');
	define('DB_USERNAME', 				'parentsolodev');
	define('DB_PASSWORD', 				'xWAICbgKese5STazadJy');
	define('DB_DATABASE', 				'parentsoloch2');
	
	// chemins
	define('SITE_PATH', 				$_SERVER["DOCUMENT_ROOT"].'/newdev');
	define('SITE_PATH_ADMIN', 			$_SERVER["DOCUMENT_ROOT"].'/newdev'.'/admin4ps');
	define('SITE_PATH_ADMIN_EXPERT', 	$_SERVER["DOCUMENT_ROOT"].'/newdev'.'/admin4expertps');
	define('SITE_URL', 					'http://www.parentsolo.ch');
	define('SITE_URL_ADMIN', 			'http://www.parentsolo.ch/admin4ps');
	define('SITE_URL_ADMIN_EXPERT', 	'http://www.parentsolo.ch/admin4expertps');
	
	// dossier du template à utiliser
	define('SITE_TEMPLATE',				'parentsolo');
	
	// application chargée sur la page d'accueil du site et site admin
	define('SITE_APP_HOME',				'home');
	define('SITE_APP_HOME_ADMIN',		'panel');
	define('SITE_APP_HOME_ADMIN_EXPERT',		'panel');
	
	// mail
	define('SITE_MAIL_FROM',			'ParentSolo.ch');
	define('SITE_MAIL',					'no-reply@parentsolo.ch');

	// durée d'inactivité - en secondes - pendant laquelle un utilisateur est considéré comme "en ligne"
	define('ONLINE_TIME_LIMIT',			300); // 5 min
	define('AFK_TIME_LIMIT',			900); // 15 min
	
	// nombre de jours à offir dès l'inscription
	define('ABONNEMENT_INITIAL',		0);
	
	// résultats de recherches
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



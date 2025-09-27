<?php
declare(strict_types=1);

// Detect environment
$isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);

// Database settings
if ($isLocal) {
    define('DB_SERVER',   'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'NewStrongPassword');
    define('DB_DATABASE', 'parentsolo');
} else {
    define('DB_SERVER',   'blatmedi.mysql.db.internal');
    define('DB_USERNAME', 'blatmedi_soloch');
    define('DB_PASSWORD', 'parentsoloch@dev');
    define('DB_DATABASE', 'blatmedi_parentsoloch1');
}

// Paths
define('SITE_PATH',               rtrim(__DIR__, '/') . '/');
define('SITE_PATH_ADMIN',         SITE_PATH . 'admin4ps');
define('SITE_PATH_ADMIN_EXPERT',  SITE_PATH . 'admin4expertps');

// URLs
define('SITE_URL',                'http://localhost');
define('SITE_URL_ADMIN',          SITE_URL . '/admin4ps');
define('SITE_URL_ADMIN_EXPERT',   SITE_URL . '/admin4expertps');

// Template
define('SITE_TEMPLATE', 'parentsolo');

// Default applications
define('SITE_APP_HOME',             'home');
define('SITE_APP_HOME_ADMIN',       'panel');
define('SITE_APP_HOME_ADMIN_EXPERT','panel');

define('FACEBOOKURL', 'https://www.facebook.com/YourPageName');
define('TWITTERURL',  'https://twitter.com/YourProfile');

// Mail
define('SITE_MAIL_FROM', 'solocircl.com');
define('SITE_MAIL',      'no-reply@solocircl.com');

// User activity (seconds)
define('ONLINE_TIME_LIMIT', 300);
define('AFK_TIME_LIMIT',    900);

// Subscription defaults
define('ABONNEMENT_INITIAL', 0);

// Results limits
define('RESULTS_NB_LISTE',        10);
define('RESULTS_NB_LISTE_ADMIN',  10);
define('RESULTS_NB_GALERIE',      10);

define('LISTE_RESULT',             12);
define('CONTENU_PAGINATION_RAYON', 5);
define('LISTE_TITRE_CHAR',         40);
define('LISTE_INTRO_CHAR',         200);

define('TITRE_HOME', 18);
define('INTRO_HOME', 85);

// Timers (milliseconds)
define('TIMER_POPIN', 30000);
define('TIMER_CHAT',  10000);
define('LISTE_INTRO_CHAR_text_over', 100);
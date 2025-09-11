<?php
// Security check (optional, could be enabled in all includes)
// define('JL', true);

// Database settings
if ($_SERVER['REMOTE_ADDR'] === '::1' || $_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
    define('DB_SERVER',   '127.0.0.1');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'Esales');
    define('DB_DATABASE', 'SP');
} else {
    define('DB_SERVER',   'blatmedi.mysql.db.internal');
    define('DB_USERNAME', 'blatmedi_soloch');
    define('DB_PASSWORD', 'parentsoloch@dev');
    define('DB_DATABASE', 'blatmedi_parentsoloch1');
}

// Paths
define('SITE_PATH',               rtrim($_SERVER["DOCUMENT_ROOT"], '/') . '/');
define('SITE_PATH_ADMIN',         SITE_PATH . 'admin4ps');
define('SITE_PATH_ADMIN_EXPERT',  SITE_PATH . 'admin4expertps');

define('SITE_URL',                'http://localhost');
define('SITE_URL_ADMIN',          SITE_URL . '/admin4ps');
define('SITE_URL_ADMIN_EXPERT',   SITE_URL . '/admin4expertps');

// Template
define('SITE_TEMPLATE', 'parentsolo');

// Default applications
define('SITE_APP_HOME',            'home');
define('SITE_APP_HOME_ADMIN',      'panel');
define('SITE_APP_HOME_ADMIN_EXPERT','panel');

// Mail
define('SITE_MAIL_FROM', 'ParentSolo.ch');
define('SITE_MAIL',      'no-reply@parentsolo.ch');

// User activity (seconds)
define('ONLINE_TIME_LIMIT', 300);   // 5 minutes
define('AFK_TIME_LIMIT',    900);   // 15 minutes

// Subscription defaults
define('ABONNEMENT_INITIAL', 0);

// Results limits
define('RESULTS_NB_LISTE',       10);
define('RESULTS_NB_LISTE_ADMIN', 10);
define('RESULTS_NB_GALERIE',     10);

define('LISTE_RESULT',            12);
define('CONTENU_PAGINATION_RAYON',5);
define('LISTE_TITRE_CHAR',        40);
define('LISTE_INTRO_CHAR',        200);

define('TITRE_HOME', 18);
define('INTRO_HOME', 85);

// Timers (milliseconds)
define('TIMER_POPIN', 30000);
define('TIMER_CHAT',  10000);

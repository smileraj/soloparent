<?php

// Start PHP session
if (!isset($_SESSION)) {
    session_start();
}

// Config
require_once('config.php');

// MVC
require_once(SITE_PATH.'/framework/controller.class.php');
require_once(SITE_PATH.'/framework/model.class.php');
require_once(SITE_PATH.'/framework/view.class.php');

// Core framework
require_once(SITE_PATH.'/framework/joomlike.class.php');
require_once(SITE_PATH.'/framework/mysql.class.php'); // your updated DB class

// Optional
require_once(SITE_PATH.'/framework/pagination.class.php');

// Create DB object
$db = new DB();

// Ensure DB connection works
if (!$db->getConnexion()) {
    include('offline.php');
    exit;
}

// Language handling: force lang parameter in URL
if (isset($_GET['lang']) && in_array($_GET['lang'], ['fr','en','de'])) {
    $langue = "lang=".$_GET['lang'];
} else {
    header('Status: 301 Moved Permanently', false, 301);
    $string = !empty($_SERVER['QUERY_STRING']) ? "?".$_SERVER['QUERY_STRING']."&lang=fr" : "?lang=fr";
    header("Location: ".$_SERVER["PHP_SELF"].$string);
    die();
}

// Create global $user object
$user = new stdClass();

// Key variables available globally
$app    = JL::getVar('app', SITE_APP_HOME);     // Application to load
$action = JL::getVar('action', '');             // Action requested by the app

// Check if requested app exists, else 404
if (!JL::checkApp($app)) {
    $app = '404';
}

// Load authentication module (silent)
JL::loadMod('auth');

// Start output buffer
ob_start();
//echo SITE_PATH;die;
// Load the proper template based on app/action
if ($app == "profil" && in_array($action, ['view','view2','view3','view4','view5'])) {
    require_once(SITE_PATH.'/'.SITE_TEMPLATE.'/'.SITE_TEMPLATE.'_profil.php');
} elseif ($app == "home") {
    require_once(SITE_PATH.'/'.SITE_TEMPLATE.'/'.SITE_TEMPLATE.'_home.php');
} else {
    require_once(SITE_PATH.'/'.SITE_TEMPLATE.'/'.SITE_TEMPLATE.'.php');
}

// Output and clean buffer
@ob_end_flush();

// Disconnect DB
$db->disconnect();

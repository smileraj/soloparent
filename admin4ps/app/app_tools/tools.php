<?php

// sécurité
defined('JL') or die('Error 401');

require_once('tools.html.php');

global $action;

// messages array
$messages = [];

// main switch
switch($action) {
    default:
        listMemberSample();
        break;
}

// liste les utilisateurs
function listMemberSample() {
    global $db;

    // select 20 random confirmed users
    $query = "
        SELECT u.*, up.* 
        FROM user u 
        INNER JOIN user_profil up ON u.id = up.user_id 
        WHERE confirmed = 1 
        ORDER BY RAND(), last_online 
        LIMIT 20
    ";

    // fetch results directly
    $sample = $db->loadObjectList($query);

    // display using HTML class
    tools_HTML::listMemberSample($sample);
}

?>

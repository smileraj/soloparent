<?php

// security
defined('JL') or die('Error 401');

require_once('panel.html.php');

global $user, $action, $db;

// Ensure $db has affected_rows method
if (!method_exists($db, 'affected_rows')) {
    // Add this dynamically for older DB class
    $db->affected_rows = function() use ($db) {
        return mysqli_affected_rows($db->getConnexion());
    };
}

// user log
if ($user->id) {

    // object containing results
    $maintenance = new stdClass();

    // supprime les messages du chat trop anciens (+ de 15j)
    $query = "DELETE FROM chat_message WHERE (TO_DAYS(NOW()) - TO_DAYS(date_envoi)) > 15";
    $db->query($query);
    $maintenance->chat_message = mysqli_affected_rows($db->getConnexion());

    // supprime les conversations du chat trop anciennes (+ de 15j)
    // Use NULL-safe comparison instead of '0000-00-00'
    $query = "DELETE FROM chat_conversation WHERE date_add IS NOT NULL AND (TO_DAYS(NOW()) - TO_DAYS(date_add)) > 15";
    $db->query($query);
    $maintenance->chat_conversation = mysqli_affected_rows($db->getConnexion());

    // supprime les messages de corbeilles vidées trop anciens (+ de 7j)
    $query = "DELETE FROM message WHERE dossier_id = -1 AND (TO_DAYS(NOW()) - TO_DAYS(date_envoi)) > 7";
    $db->query($query);
    $maintenance->message = mysqli_affected_rows($db->getConnexion());

    // supprime les inscriptions temporaires trop anciennes (+ de 3j)
    $query = "DELETE FROM user_inscription WHERE (TO_DAYS(NOW()) - TO_DAYS(reservation_date)) > 3";
    $db->query($query);
    $maintenance->user_inscription = mysqli_affected_rows($db->getConnexion());

    // render panel home page
    HTML_panel::homePage($maintenance);

} else {
    // user non log
    HTML_panel::loginPage();
}

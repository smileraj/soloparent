<?php
// sécurité
defined('JL') or die('Error 401');

global $user, $app, $action, $langue, $db;
include "lang/app_mod." . ($_GET['lang'] ?? 'fr') . ".php";

$id = JL::getVar('id', 0);

// variable pour déterminer quel <li> est en class="active"
$active = -1;

$menu = match($app) {
    'temoignage' => 1,
    'appel_a_temoins' => 2,
    'presse' => 3,
    default => null,
};

if ($menu) : ?>
    <ul class="nav nav-pills nav-justified parentsolo_testimony">
        <?php
        $get_action_val = $_GET['action'] ?? '';

        switch ($menu) {
            case 3: // presse
                $items = [
                    'videos' => $lang_mod["Videos"],
                    'articles' => $lang_mod["Articles"],
                    'radios' => $lang_mod["Radios"],
                    'affiches' => $lang_mod["Affiches"],
                ];
                break;

            case 2: // appel_a_temoins
                $items = [
                    'info' => $lang_mod["Informations"],
                    '' => $lang_mod["TousLesAppelsATemoins"],
                    'read' => $lang_mod["TousLesAppelsATemoins"],
                    'new' => $lang_mod["LancerUnAppelATemoins"],
                ];
                break;

            case 1: // temoignage
            default:
                $items = [
                    'infos' => $lang_mod["Informations"],
                    '' => $lang_mod["TousLesTemoignages"],
                    'lire' => $lang_mod["TousLesTemoignages"],
                    'edit' => $lang_mod["JeDesireTemoigner"],
                ];
                break;
        }

        foreach ($items as $key => $title) :
            $isActive = ($get_action_val === $key || ($key === '' && in_array($get_action_val, ['', 'lire', 'read'], true))) ? 'active' : '';
            $url = JL::url("index.php?app={$app}" . ($key ? "&action={$key}" : '')) . '&lang=' . ($_GET['lang'] ?? 'fr');
        ?>
            <li class="<?= $isActive ?>">
                <a href="<?= $url ?>" title="<?= htmlspecialchars($title) ?>"><?= htmlspecialchars($title) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

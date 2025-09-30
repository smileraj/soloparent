<?php
// security
defined('JL') or die('Error 401');

class profil_HTML {

    // -------------------------------
    // List profiles
    // -------------------------------
    public static function profilLister(&$users, &$search, &$lists, &$messages, &$stats) {
        $i = 0;
        $td = 0;
        $tdParTr = 11;
        $rayon = 5;
        $debut = ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
        $fin = ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];

        $paysVert = ['CH'];
        $paysGris = ['XX'];
        $paysRouge = ['CI','SN','EG'];
        ?>
        <script type="text/javascript">
            function submitform(action) {
                var form = document.listForm;
                var ok = true;
                if(action == 'supprimer' && !confirm('Voulez-vous vraiment supprimer les profils sélectionnés ?')) ok = false;
                if(action == 'desactiver' && !confirm('Voulez-vous vraiment désactiver les profils sélectionnés ?')) ok = false;
                if(action == 'activer' && !confirm('Voulez-vous vraiment activer les profils sélectionnés ?')) ok = false;
                if(ok) { form.action.value = action; form.submit(); }
            }
            function cancelsubmit(action) {
                if(action == 'Fermer' && !confirm('Êtes-vous sûr de vouloir Fermer?')) return;
                window.location.href = "<?php echo SITE_URL_ADMIN; ?>"; 
            }
        </script>

        <form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
        <section class="panel">
            <header class="panel-heading">
                <h2>Gestion des profils <i>(H: <?php echo $stats['papas']; ?>% / F: <?php echo $stats['mamans']; ?>%)</i></h2>
            </header>
            <div class="toolbar">
                <a href="javascript:submitform('activer');" class="btn btn-success">Activer</a>
                <a href="javascript:submitform('desactiver');" class="btn btn-success">Désactiver</a>
                <a href="javascript:submitform('supprimer');" class="btn btn-success">Supprimer</a>
                <a href="javascript:cancelsubmit('Fermer')" class="btn btn-success">Fermer</a>
            </div>

            <?php if (is_array($messages)) { ?>
            <div class="messages"><?php JL::messages($messages); ?></div><br />
            <?php } ?>

            <div class="tableAdmin">
            <table class="table table-bordered table-striped table-condensed cf lister">
            <?php if (is_array($users)) { ?>
                <tr>
                    <th width="20px"></th>
                    <th>Pseudo</th>
                    <th align="center">Genre</th>
                    <th align="center">Activé</th>
                    <th align="center">Confirmé</th>
                    <th align="center">Email Activé</th>
                    <th>Abonnement</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Appels</th>
                    <th>Pays</th>
                </tr>
                <?php foreach($users as $user) {
                    JL::makeSafe($user);
                    $warning = false;

                    // Abonnement handling
                    $jours = 0;
                    if($user->gold_limit_date != '0000-00-00') {
                        $userTime = strtotime((string) $user->gold_limit_date);
                        $time = time();
                        $jours = ceil(($userTime-$time)/86400);
                        $user->abonnement = $userTime >= $time 
                            ? date('d/m/Y', $userTime).'<br /><b>('.$jours.' jours)</b>'
                            : date('d/m/Y', $userTime).'<br /><b>(terminé)</b>';
                    } else {
                        $user->abonnement = '';
                    }

                    // Téléphone validation
                    $colorPhone = '';
                    if($jours < 500 && !preg_match('/^0?[0-9]{9}$/', preg_replace('/[^0-9]/','', (string) $user->telephone_origine))) {
                        $colorPhone = 'orange';
                        $warning = true;
                    }

                    // Pays
                    $pays = $user->ip_pays;
                    if(in_array($pays, $paysVert)) $colorPays='green';
                    elseif(in_array($pays, $paysGris)) $colorPays='grey';
                    elseif(in_array($pays, $paysRouge)) { $colorPays='red'; $warning=true; }
                    else { $colorPays='orange'; $warning=true; }

                    // Nom validation
                    $colorNom='';
                    if($jours < 500 && strlen((string) $user->nom_origine) < 3) { $colorNom='orange'; $warning=true; }

                    ?>
                    <tr class="<?php if($jours>0 && $jours<=3) echo 'jours3'; if($warning) echo ' warning'; ?>">
                        <td align="center"><input type="checkbox" name="id[]" value="<?php echo $user->id; ?>"></td>
                        <td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=editer&id=<?php echo $user->id; ?>"><?php echo $user->username; ?></a><br /><span style="font-size:10px;font-style:italic;"><?php echo $user->points_total; ?> pts</span></td>
                        <td align="center"><img src="images/<?php echo $user->genre; ?>.png" alt="<?php echo $user->genre=='h'?'Homme':'Femme'; ?>" /></td>
                        <td align="center"><img src="images/<?php echo $user->published; ?>.png" alt="<?php echo $user->published?'Oui':'Non'; ?>" /></td>
                        <td align="center"><img src="images/<?php echo $user->confirmed; ?>.png" alt="" /></td>
                        <td align="center"><img src="images/<?php echo $user->user_status_code; ?>.png" alt="" /></td>
                        <td><?php echo $user->abonnement; ?></td>
                        <td style="color:<?php echo $colorNom; ?>;"><?php echo $user->nom_origine; ?></td>
                        <td><?php echo $user->prenom_origine; ?></td>
                        <td style="color:<?php echo $colorPhone; ?>;"><?php echo str_starts_with((string) $user->telephone_origine, '0')?$user->telephone_origine:'0'.$user->telephone_origine; ?></td>
                        <td>
                        <?php
                        if($user->appel_date != '0000-00-00') echo date('d/m/Y', strtotime((string) $user->appel_date));
                        if($user->appel_date2 != '0000-00-00') echo '<br /><span style="font-size:10px;color:#aaa;">+ '.date('d/m/Y', strtotime((string) $user->appel_date2)).'</span>';
                        ?>
                        </td>
                        <td style="color:<?php echo $colorPays; ?>; font-weight:bold; text-align:center;"><?php echo str_replace('XX','?',$pays); ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><th colspan="<?php echo $tdParTr; ?>">Aucun profil trouvé.</th></tr>
            <?php } ?>
            </table>
            </div>
            <input type="hidden" name="search_page" value="1" />
            <input type="hidden" name="app" value="profil" />
            <input type="hidden" name="action" value="" />
        </section>
        </form>
        <?php
    }

    // -------------------------------
    // List photos for validation
    // -------------------------------
    public static function photoLister(&$users, &$messages) {
        ?>
        <script>
        function submitform(action) {
            if(action=='supprimer' && !confirm('Voulez-vous vraiment supprimer les photos sélectionnées ?')) return;
            document.listForm.task.value=action;
            document.listForm.submit();
        }
        function cancelsubmit(action) {
            if(action=='Fermer' && !confirm('Êtes-vous sûr de vouloir Fermer?')) return;
            window.location.href="<?php echo SITE_URL_ADMIN; ?>";
        }
        </script>
        <form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
        <section class="panel">
            <header class="panel-heading"><h2>Validation des photos</h2></header>
            <div class="toolbar">
                <a href="javascript:submitform('valider');" class="btn btn-success">Valider</a>
                <a href="javascript:submitform('supprimer');" class="btn btn-success">Supprimer</a>
                <a href="javascript:cancelsubmit('Fermer')" class="btn btn-success">Fermer</a>
            </div>

            <?php if(is_array($messages)){ ?><div class="messages"><?php JL::messages($messages); ?></div><br><?php } ?>

            <div class="tableAdmin">
            <table class="table table-bordered table-striped table-condensed cf lister">
                <?php
                $tdParTr=3; $photoTotal=0; $photoLimite=150; $td=0;
                if(is_array($users)){
                    foreach($users as $user){
                        if(is_array($user->photos)){
                            foreach($user->photos as $photo){
                                $photoTotal++;
                                ?>
                                <tr>
                                    <td><img src="<?php echo $photo->url; ?>" width="100"></td>
                                    <td><?php echo $user->username; ?></td>
                                    <td><input type="checkbox" name="id[]" value="<?php echo $photo->id; ?>"></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                } else { echo '<tr><th colspan="'.$tdParTr.'">Aucune photo trouvée.</th></tr>'; }
                ?>
            </table>
            </div>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="app" value="profil" />
            <input type="hidden" name="action" value="photoValidation" />
        </section>
        </form>
        <?php
    }

    // -------------------------------
    // List text messages for validation
    // -------------------------------
    public static function texteLister(&$textes, &$search = [], &$lists = [], &$messages = []) {
    ?>
    <form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
        <section class="panel">
            <header class="panel-heading">
                <h2>Validation des textes</h2>
            </header>

            <div class="tableAdmin">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Text</th>
                        <th>Valid</th>
                    </tr>

                    <?php if (is_array($textes) && count($textes) > 0) { 
                        foreach($textes as $texte) {
                            // Use null coalescing to avoid undefined property
                            $id = $texte->id ?? '';
                            $user = $texte->username ?? '';
                            $content = $texte->content ?? '';
                            $validated = $texte->validated ?? 0;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($id); ?></td>
                                <td><?php echo htmlspecialchars($user); ?></td>
                                <td><?php echo htmlspecialchars($content); ?></td>
                                <td>
                                    <input type="checkbox" name="texte_validated[]" value="<?php echo $id; ?>" <?php echo $validated ? 'checked' : ''; ?> />
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="4">Aucun texte en attente de validation.</td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <input type="hidden" name="app" value="profil" />
            <input type="hidden" name="action" value="texte_validation_submit" />
        </section>
    </form>
    <?php
}


    // -------------------------------
    // Edit profile form
    // -------------------------------
    public static function profilEditer($user, $messages=[]) {
        JL::makeSafe($user);
        ?>
        <form action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
        <section class="panel">
            <header class="panel-heading"><h2>Edition du profil : <?php echo $user->username; ?></h2></header>
            <?php if(is_array($messages)){ ?><div class="messages"><?php JL::messages($messages); ?></div><br><?php } ?>
            <table class="table table-bordered table-striped table-condensed cf">
                <tr><th>Pseudo</th><td><input type="text" name="username" value="<?php echo $user->username; ?>"></td></tr>
                <tr><th>Nom</th><td><input type="text" name="nom" value="<?php echo $user->nom; ?>"></td></tr>
                <tr><th>Prénom</th><td><input type="text" name="prenom" value="<?php echo $user->prenom; ?>"></td></tr>
                <tr><th>Email</th><td><input type="email" name="email" value="<?php echo $user->email; ?>"></td></tr>
                <tr><th>Téléphone</th><td><input type="text" name="telephone" value="<?php echo $user->telephone; ?>"></td></tr>
                <tr><th>Genre</th><td>
                    <select name="genre">
                        <option value="h" <?php if($user->genre=='h') echo 'selected'; ?>>Homme</option>
                        <option value="f" <?php if($user->genre=='f') echo 'selected'; ?>>Femme</option>
                    </select>
                </td></tr>
                <tr><th>Activé</th><td><input type="checkbox" name="published" <?php if($user->published) echo 'checked'; ?>></td></tr>
            </table>
            <input type="hidden" name="app" value="profil">
            <input type="hidden" name="action" value="editer">
            <input type="hidden" name="id" value="<?php echo $user->id; ?>">
            <div class="toolbar">
                <input type="submit" class="btn btn-success" value="Enregistrer">
            </div>
        </section>
        </form>
        <?php
    }

}
?>

<?php

// sécurité
defined('JL') or die('Error 401');

class HTML_groupe {

    // liste les profils
    public static function groupeLister(&$rows, &$search, &$lists, &$messages) {

        $i = 0;
        $td = 0;
        $tdParTr = 4;
        $rayon = 5;
        $debut = ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
        $fin = ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
        ?>
        <script type="text/javascript">
        function submitform(action) {
            var form = document.listForm;
            var ok = true;

            if(action == 'supprimer') {
                ok = confirm('Voulez-vous vraiment supprimer les groupes sélectionnés ?');
            } else if(action == 'desactiver') {
                ok = confirm('Voulez-vous vraiment désactiver les groupes sélectionnés ?');
            } else if(action == 'activer') {
                ok = confirm('Voulez-vous vraiment activer les groupes sélectionnés ?');
            }

            if(ok) {
                form.action.value = action;
                form.submit();
            }
        }

        function cancelsubmit(action) {
            var ok = true;
            if(action == 'Fermer') {
                ok = confirm('Êtes-vous sûr de vouloir Fermer?');
            }

            if(ok) {
                document.location = "<?php echo SITE_URL_ADMIN; ?>";
            }
        }
        </script>

        <form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
        <section class="panel">
            <header class="panel-heading">
                <h2>Groupes</h2>
            </header>

            <div class="row">
                <div class="col-lg-12">
                    <div class="toolbar">
                        <a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
                    </div>
                </div>
            </div>
            <br />

            <?php if (is_array($messages)) { ?>
                <div class="messages">
                    <?php JL::messages($messages); ?>
                </div>
                <br />
            <?php } ?>

            <div class="tableAdmin">
                <div class="filtre">
                    <table class="table table-bordered table-striped table-condensed cf">
                        <tr>
                            <td><b>Recherche:</b></td>
                            <td colspan="3"><input type="text" name="search_g_word" id="search_g_word" value="<?php echo htmlspecialchars($search['word'] ?? '', ENT_QUOTES); ?>" class="searchInput" /></td>
                        </tr>
                        <tr>
                            <td><b>Tri par:</b></td>
                            <td><?php echo $lists['order']; ?></td>
                            <td><b>Statut:</b></td>
                            <td><?php echo $lists['active']; ?></td>
                        </tr>
                        <tr>
                            <td><b>Ordre:</b></td>
                            <td colspan="3"><?php echo $lists['ascdesc']; ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right">
                                <a href="javascript:document.listForm.submit();" class="bouton envoyer">Rechercher</a>
                            </td>
                        </tr>
                    </table>
                </div>

                <table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
                    <?php if (is_array($rows) && count($rows) > 0) { ?>
                    <tr>
                        <th width="20px"></th>
                        <th style="width:50px; text-align:center;">Statut</th>
                        <th>Titre</th>
                        <th style="width: 150px;">Création date</th>
                    </tr>

                    <?php foreach($rows as $row) {
                        JL::makeSafe($row);
                        ?>
                        <tr class="list">
                            <td align="center"><input type="checkbox" name="id[]" value="<?php echo $row->id ?? ''; ?>" id="user_<?php echo $row->id ?? ''; ?>"></td>
                            <td align="center"><img src="images/<?php echo $row->active ?? 0; ?>.png" alt="" /></td>
                            <td>
                                <a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=groupe&action=edit&id=<?php echo $row->id ?? ''; ?>" title="Modifier le témoignage"><?php echo htmlspecialchars($row->titre ?? '', ENT_QUOTES); ?></a><br />
                                <i>par <b><?php echo htmlspecialchars($row->username ?? '', ENT_QUOTES); ?></b></i>
                            </td>
                            <td><?php echo isset($row->date_add) ? date('d/m/Y H:i:s', strtotime($row->date_add)) : ''; ?></td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <td colspan="<?php echo $tdParTr; ?>">
                            <b>Pages</b>:
                            <?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=groupe&search_g_page=1'); ?>">Début</a> ...<?php } ?>
                            <?php for($i=$debut; $i<=$fin; $i++) { ?>
                                <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=groupe&search_g_page='.$i); ?>" <?php if($i == $search['page']) echo 'class="displayActive"'; ?>><?php echo $i; ?></a>
                            <?php } ?>
                            <?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=groupe&search_g_page='.$search['page_total']); ?>">Fin</a><?php } ?>
                            <i>(<?php echo $search['result_total'] ?? 0; ?> résultats)</i>
                        </td>
                    </tr>
                    <?php } else { ?>
                        <tr>
                            <th colspan="<?php echo $tdParTr; ?>">Aucun groupe ne correspond à votre recherche.</th>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <input type="hidden" name="search_g_page" value="1" />
            <input type="hidden" name="app" value="groupe" />
            <input type="hidden" name="action" value="" />
        </section>
        </form>
    <?php
    }

    // formulaire d'édition d'un profil
    public static function groupeEditer(&$row, &$messages) {

        JL::makeSafe($row);
        ?>
        <script>
        function cancelsubmit(action) {
            var ok = true;
            if(action == 'Annuler') ok = confirm('Êtes-vous sûr de vouloir Annuler?');
            else if(action == 'Fermer') ok = confirm('Êtes-vous sûr de vouloir Fermer?');

            if(ok) {
                document.location = "<?php echo SITE_URL_ADMIN; ?>/index.php?app=groupe";
            }
        }
        </script>

        <form name="editForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
            <section class="panel">
                <header class="panel-heading"><h2>Groupe</h2></header>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="toolbar">
                            <a href="javascript:document.editForm.submit();" title="Sauver" class="btn btn-success">Sauver</a>
                            <a href="javascript:cancelsubmit('Annuler')" title="Annuler" class="btn btn-success">Annuler</a>
                            <a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
                        </div>
                    </div>
                </div>
                <br />
                <?php if(is_array($messages)) { ?>
                    <div class="messages"><?php JL::messages($messages); ?></div>
                    <br />
                <?php } ?>
                <div class="tableAdmin">
                    <h3>Informations</h3><br />
                    <table class="table table-bordered table-striped table-condensed cf editer">
                        <tr><td class="key"><b>Titre d'origine:</b></td><td><?php echo htmlspecialchars($row->titre_origine ?? '', ENT_QUOTES); ?></td></tr>
                        <tr><td class="key"><b>Texte d'origine:</b></td><td><?php echo nl2br(htmlspecialchars($row->texte_origine ?? '', ENT_QUOTES)); ?></td></tr>
                        <tr>
                            <td class="key"><b>Photo active:</b></td>
                            <td>
                                <?php
                                $filePath = 'images/groupe/'.$row->id.'.jpg';
                                $image = is_file(SITE_PATH.'/'.$filePath) ? $filePath : 'images/groupes-parentsolo.jpg';
                                ?>
                                <label><img src="<?php echo SITE_URL.'/'.$image; ?>?<?php echo time(); ?>" /></label><br />
                                <?php if(is_file(SITE_PATH.'/'.$filePath)) { ?>
                                    <input type="checkbox" name="photo_delete" value="<?php echo $filePath; ?>" id="photo_delete" /> <label for="photo_delete">Supprimer</label>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td class="key"><label for="titre">Titre:</label></td><td><input type="text" id="titre" style="width:450px;" name="titre" maxlength="70" value="<?php echo htmlspecialchars($row->titre ?? '', ENT_QUOTES); ?>"></td></tr>
                        <tr><td class="key"><label for="texte">Texte:</label></td><td><textarea name="texte" id="texte" rows="10" cols="72"><?php echo htmlspecialchars($row->texte ?? '', ENT_QUOTES); ?></textarea></td></tr>
                    </table>
                </div>

                <div class="tableAdmin">
                    <h3>Administration</h3><br />
                    <table class="table table-bordered table-striped table-condensed cf editer">
                        <tr>
                            <td class="key"><b>Fondateur:</b></td>
                            <td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=editer&id=<?php echo $row->user_id ?? ''; ?>" title="Profil de <?php echo htmlspecialchars($row->username ?? '', ENT_QUOTES); ?>" target="_blank"><?php echo htmlspecialchars($row->username ?? '', ENT_QUOTES); ?></a></td>
                        </tr>
                        <tr>
                            <td class="key"><label for="statut">Statut:</label></td>
                            <td>
                                <div class="statut statut1"><input type="radio" name="active" value="1" id="active1" <?php if(($row->active ?? 0) == 1) echo 'checked="checked"'; ?> /> <label for="active1">Publié</label></div>
                                <div class="statut statut0"><input type="radio" name="active" value="0" id="active0" <?php if(($row->active ?? 0) == 0) echo 'checked="checked"'; ?> /> <label for="active0">Refusé</label></div>
                                <div class="statut statut2"><input type="radio" name="active" value="2" id="active2" <?php if(($row->active ?? 0) == 2) echo 'checked="checked"'; ?> /> <label for="active2">En attente</label></div>
                                <div class="statut statut3"><input type="radio" name="active" value="3" id="active3" <?php if(($row->active ?? 0) == 3) echo 'checked="checked"'; ?> /> <label for="active3">Verrouillé</label>: Le groupe sera <b>publié</b> et ne pourra plus être modifié par son fondateur</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="key"><label for="motif">Message:</label></td>
                            <td><textarea name="motif" id="motif" rows="10" cols="72"><?php echo htmlspecialchars($row->motif ?? '', ENT_QUOTES); ?></textarea><br /><i>Vous pouvez indiquer un motif de refus ou des précisions. Ce message sera <span style="color:#990000;font-weight:bold;">lisible par le membre</span>.</i></td>
                        </tr>
                    </table>
                </div>

                <input type="hidden" name="id" value="<?php echo $row->id ?? ''; ?>" />
                <input type="hidden" name="app" value="groupe" />
                <input type="hidden" name="action" value="save" />
            </section>
        </form>
    <?php
    }
}

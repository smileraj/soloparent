<?php

// sécurité
defined('JL') or die('Error 401');

class tools_HTML {

    // liste les $contenus
    public static function listMemberSample(&$rows) {
        $i = 0;
        ?>
<script>
function cancelsubmit(action) {
    var ok = true;
    if(action == 'Fermer') {
        if(!confirm('êtes-vous sûr de vouloir Fermer?')) ok = false;
    }
    if(ok) {
        window.location.href = "<?php echo SITE_URL_ADMIN; ?>"; 
    }
}
</script>
<section class="panel">
    <header class="panel-heading">
        <h2>Outils</h2>
    </header>
    <div class="row">
        <div class="col-lg-12">                
            <div class="toolbar">
                <a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
            </div>
        </div>  
    </div>
    <br />
    <div class="tableAdmin">                    
        <form action="lib/lib.php" method="post" id="form" name="form">
            <table class="table table-bordered table-striped table-condensed cf">
                <tr>
                    <th><a href="javascript:void(0);" id="selection">#</a></th>
                    <th>Membre</th>
                    <th>Date</th>
                    <th>Compatible</th>
                    <th>Sexe</th>
                </tr>            
                <?php foreach($rows as $row) { 
                    $compatProfile = tools_HTML::getCompatibleMemberArray($row->id, $row->genre);
                ?>
                <tr class="list">
                    <td><input type="checkbox" name="idBox[]" id="idBox" value="<?=$row->id?>"></td>
                    <td><?=$row->username?> (<?=$row->id?>)</td>
                    <td><?=$row->last_online?></td>
                    <td><?=tools_HTML::input_select($compatProfile, $i);?></td>
                    <td><?=strtoupper((string) $row->genre);?></td>
                </tr>
                <input type="hidden" name="action" id="action" value="default"/>
                <?php $i++; ?>
                <?php } ?>
            </table>
        </form>                    
        <div style="width:300px; height:50px; position: relative;">
            <input type="button" id="do_visite" value="Visite" class="btn btn-success envoyer"/>
            <p id="result" style="color:#ff0000;padding-bottom:5px"></p>
        </div>
    </div>
</section>
<?php
    }

    public static function getCompatibleMemberArray($id, $genre){
        global $db;

        $sex = ($genre == "h" || $genre == "H") ? "f" : "h";

        $query = "SELECT * FROM compat_vw 
                  WHERE age BETWEEN (FLOOR((SELECT age FROM getAge WHERE id = $id)/10)*10) 
                                  AND (FLOOR((SELECT age FROM getAge WHERE id = $id)/10)*10)+9 
                    AND gid != 1 
                    AND confirmed = 1 
                    AND genre = '$sex' 
                  ORDER BY RAND() LIMIT 1, 20";

        // Fetch directly using DB class
        $sample = $db->loadObjectList($query);

        return $sample;
    }

    public static function input_select($results, $id){
        $out = "<select class=\"list\" id=\"id-$id\">\r";
        foreach($results as $row) {
            $out .= "<option value=\"$row->uid\">$row->username</option>\r";
        }
        $out .= "</select>\r";

        return $out;
    }
}
?>

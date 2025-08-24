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
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'Fermer') {
							if(!confirm('Êtes-vous sûr de vouloir Fermer?')) {
								ok = false;
							}
						}
                       					
						
						if(ok) {
						
							window.location.href = "<? echo SITE_URL_ADMIN; ?>"; 
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
			<br />
			<div class="tableAdmin">					
				<form action="lib/lib.php" method="post" id="form" name="form">
					<table class="table table-bordered table-striped table-condensed cf">
							<tr>
								<th><a href="javascript:void(0);" id="selection">#</a></th>
								<th>Membre</th>
								<th>Date</th>
								<? /* <th style="font-size: 9pt;padding-bottom:0px">#Roses</th> */ ?>
								<th>Compatible</th>
								<th>Sexe</th>
							</tr>			
						<? foreach($rows AS $row){ ?>
							<? $compatProfile = tools_HTML::getCompatibleMemberArray($row->id, $row->genre);
								//echo $compatProfile;
							?>
							<tr class="list">
								<td><input type="checkbox" name="idBox[]" id="idBox" value="<?=$row->id?>"></td>
								<td><?=$row->username?> (<?=$row->id?>)</td>
								<td><?=$row->last_online?></td>
								<? /*<td style="padding-bottom:5px;text-align:center;"><input type="text" size="2" id="roseNum" name="roseNum" value="1" /></td> */ ?>
								<td><?=tools_HTML::input_select( $compatProfile, $i );?></td>
								<td><?=strtoupper($row->genre);?></td>
							</tr>
							<input type="hidden" name="action" id="action" value="default"/>
							<? $i++; ?>
						<? } ?>
					</table>
				</form>					
			
				<div style="width:300px; height:50px; position: relative;">
					<input type="button"  id="do_visite" value="Visite" class="btn btn-success envoyer"/>
					<p id="result" style="color:#ff0000;padding-bottom:5px"></p>
				</div>
				
			</div>
		</section>
				
<?	
			
		}
		
		public static function getCompatibleMemberArray(&$id, &$genre){
		
			global $db;
		
			//$query = "SELECT * FROM user WHERE confirmed = 1 ORDER BY RAND(), last_online LIMIT 20";
			$sex = "";
			if($genre == "h" || $genre == "H"){
				$sex = "f";
			}
			elseif($genre == "f" || $genre == "F"){
				$sex = "h";
			}
			
			$query = "SELECT * FROM compat_vw WHERE age BETWEEN (floor((SELECT age FROM getAge WHERE id = $id)/10)*10) AND (floor((SELECT age FROM getAge WHERE id = $id)/10)*10)+9 AND gid != 1 AND confirmed = 1 AND genre = '$sex' ORDER BY RAND() LIMIT 1, 20";
		
			$db->setQuery($query);
			
			$sample = $db->loadObjectList($query);
		
			return $sample;
			
		}
		
		public static function input_select(&$results, &$id){
			
			$out = "<select class=\"list\" id=\"id-$id\">\r";
				foreach($results as $row) {
					$out .= "<option value=\"$row->uid\">" . $row->username . "</option>\r";
				}
			$out .= "</select>\r";
						
			return $out;
		}
	}
?>

<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class evolution_semaine_HTML {	
		
		// liste les $contenus
		public static function lister(&$rows, &$rows_suppr) {
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
						
							document.location = "<? echo SITE_URL_ADMIN; ?>"; 
						}
						
					}
		</script>
			<section class="panel">
                  <header class="panel-heading">
                    <h2>Evolution des membres inscrits par semaine</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
					<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
				</div>
				</div>
				  </div>
			<div class="tableAdmin">
			<table class="table table-bordered table-striped table-condensed cf" width="100%" style="text-align:center;" cellpadding="0" cellspacing="0">
					<tr>
						<th>Semaine (Année)</th><th>Nombre d'inscrits</th><!--<th>Hommes</th><th>Femmes</th>-->
					</tr>
		<?
			foreach($rows AS $row){
				$total_suppr = 0;
				$total_h = 0;
				$total_f = 0;
				foreach($rows_suppr AS $row_suppr){
					if($row_suppr->semaine == $row->semaine)
						$total_suppr = $row_suppr->total;
						$total_h = $row_suppr->total_h;
						$total_f = $row_suppr->total_f;
				}
			?>
				<tr class="list">
					<td><b><? echo $row->semaine; ?></b></td>
					<td><? echo $row->total+$total_suppr; ?></td>
					<!--<td><? echo $row->total_h+$total_h; ?></td>
					<td><? echo $row->total_f+$total_f; ?></td>-->
				</tr>
			<?
			}
		?>
		
			</table>			
			</div>
			</section>
		<?
		}
		
		
	}
?>

<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class evolution_desinscription_an_HTML {	
		
		// liste les $contenus
		public static function lister(&$rows, &$rows_suppr) {
		?>
		<script>
		function cancelsubmit(action) {
						
						var form = document.listForm;
						var ok = true;
						
						
						 if(action == 'Fermer') {
							if(!confirm('�tes-vous s�r de vouloir Fermer?')) {
								ok = false;
								
							}
						}
						
						if(ok) {
						
							document.location = "<?php echo SITE_URL_ADMIN; ?>"; 
						}
						
					}
		</script>
			<section class="panel">
                  <header class="panel-heading">
                     	<h2>Evolution des membres d�sinscrits par an</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
					<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
				</div>
			</div>	
			</div>
			
			<div class="tableAdmin">
			<table class="table table-bordered table-striped table-condensed cf" style="text-align: center" cellpadding="0" cellspacing="0">
					<tr>
						<th>Ann�e</th><th>Nombre de d�sinscrits</th><th>Hommes</th><th>Femmes</th>
					</tr>
		<?php 			foreach($rows AS $row){
				$total_suppr = 0;
				$total_h = 0;
				$total_f = 0;
				foreach($rows_suppr AS $row_suppr){
					if($row->annee == $row_suppr->annee){
						$total_suppr = $row_suppr->total;
						$total_h = $row_suppr->total_h;
						$total_f = $row_suppr->total_f;
					}
				}
			?>
				<tr class="list">
					<td><b><?php echo $row->annee; ?></b></td>
					<td><?php echo $row->total+$total_suppr; ?></td>
					<td><?php echo $row->total_h+$total_h; ?></td>
					<td><?php echo $row->total_f+$total_f; ?></td>
				</tr>
			<?php 			}
		?>
		
			</table>
			
			</div>
			</section>
		<?php 		}
		
		
	}
?>

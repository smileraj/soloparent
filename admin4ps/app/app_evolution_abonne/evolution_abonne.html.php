<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class evolution_abonne_HTML {	
		
		// liste les $contenus
		public static function lister(&$rows_total, &$rows_total_suppr, &$rows_total_f, &$rows_total_f_suppr, &$rows_total_h, &$rows_total_h_suppr) {
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
                     <h2>Evolution des abonn&eacute;s uniques par an</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
					<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
				</div>
				</div>
			</div>
			<div class="tableAdmin">
			<table class="table table-bordered table-striped table-condensed cf" style="text-align:center;" cellpadding="0" cellspacing="0">
					<tr>
						<th>Ann�e</th><th>Nombre d'inscrits</th><th>Hommes</th><th>Femmes</th>
					</tr>
		<?php 			foreach($rows_total AS $row_t){
				$total_suppr = 0;
				$total_f = 0;
				$total_f_suppr = 0;
				$total_h = 0;
				$total_h_suppr = 0;
				foreach($rows_total_suppr AS $row_t_suppr){
					if($row_t->annee == $row_t_suppr->annee){
						$total_suppr = $row_t_suppr->total;
					}
				}
				foreach($rows_total_f AS $row_t_f){
					if($row_t->annee == $row_t_f->annee){
						$total_f = $row_t_f->total;
					}
				}
				foreach($rows_total_h AS $row_t_h){
					if($row_t->annee == $row_t_h->annee){
						$total_h = $row_t_h->total;
					}
				}
				foreach($rows_total_f_suppr AS $row_t_f_suppr){
					if($row_t->annee == $row_t_f_suppr->annee){
						$total_f_suppr = $row_t_f_suppr->total;
					}
				}
				foreach($rows_total_h_suppr AS $row_t_h_suppr){
					if($row_t->annee == $row_t_h_suppr->annee){
						$total_h_suppr = $row_t_h_suppr->total;
					}
				}
			?>
				<tr class="list">
					<td><b><?php echo $row_t->annee; ?></b></td>
					<td><?php echo $row_t->total+$total_suppr; ?></td>
					<td><?php echo $total_h+$total_h_suppr; ?></td>
					<td><?php echo $total_f+$total_f_suppr; ?></td>
				</tr>
			<?php 			}
		?>
		
			</table>
			
			
			</div>
			</section>
		<?php 		}
		
		
	}
?>

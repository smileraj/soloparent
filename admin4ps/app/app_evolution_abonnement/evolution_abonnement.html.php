<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class evolution_abonnement_HTML {	
		
		// liste les $contenus
		public static function lister(&$rows_total, &$rows_total_suppr,&$rows, &$rows_suppr) {
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
                     	<h2>Evolution des abonnements par an</h2>
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
				$total_h = 0;
				$total_f = 0;
				foreach($rows_total_suppr AS $row_t_suppr){
					if($row_t->annee == $row_t_suppr->annee){
						$total_suppr = $row_t_suppr->total;
						$total_h = $row_t_suppr->total_h;
						$total_f = $row_t_suppr->total_f;
					}
				}
			?>
				<tr class="list">
					<td><b><?php echo $row_t->annee; ?></b></td>
					<td><?php echo $row_t->total+$total_suppr; ?></td>
					<td><?php echo $row_t->total_h+$total_h; ?></td>
					<td><?php echo $row_t->total_f+$total_f; ?></td>
				</tr>
			<?php 			}
		?>
		
			</table>
			
			
			</div>
			</section>
			
			<section class="panel">
                  <header class="panel-heading">
                     		<h2>Evolution des abonnements par an (D�tails)</h2>
                  </header>
				
				
			<div class="tableAdmin">
			<table class="table table-bordered table-striped table-condensed cf" style="text-align:center;" cellpadding="0" cellspacing="0">
					<tr>
						<th>Ann�e</th><th>Abonnements</th><th>Nombre d'inscrits</th><th>Hommes</th><th>Femmes</th>
					</tr>
		<?php 			foreach($rows AS $row){
				$total_suppr = 0;
				$total_h = 0;
				$total_f = 0;
				foreach($rows_suppr AS $row_suppr){
					if($row->annee == $row_suppr->annee && $row->points_id == $row_suppr->points_id){
						$total_suppr = $row_suppr->total;
						$total_h = $row_suppr->total_h;
						$total_f = $row_suppr->total_f;
					}
				}
			?>
				<tr class="list">
					<td><b><?php echo $row->annee; ?></b></td>
					<td><b><?php if($row->points_id == 1){ echo "3 mois"; }elseif($row->points_id == 2){ echo "6 mois"; }elseif($row->points_id == 3){ echo "12 mois"; }elseif($row->points_id == 19){ echo "1 mois";} ?></b></td>
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

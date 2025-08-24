<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class evolution_age_membre_HTML {	
		
		// liste les $contenus
		public static function lister(&$dates_naissance) {
			global $langue;
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
			<table class="table table-bordered table-striped table-condensed cf" style="text-align: center;" cellpadding="0" cellspacing="0">
					<tr>
						<th>Année</th><th>Moyenne age</th><th>Hommes</th><th>Femmes</th>
					</tr>
		<?
			for($i=2009;$i<2016;$i++){
				
				$date_total =array();
				$date_total_h =array();
				$date_total_f =array();
				
				foreach($dates_naissance[$i.'user'] AS $date)
					$date_total[] = JL::calcul_age_adulte_admin($date->naissance_date,$i);
					
				foreach($dates_naissance[$i.'user_suppr'] AS $date)
					$date_total[] = JL::calcul_age_adulte_admin($date->naissance_date,$i);
				
				
				foreach($dates_naissance[$i.'user_h'] AS $date)
					$date_total_h[] = JL::calcul_age_adulte_admin($date->naissance_date,$i);
					
				foreach($dates_naissance[$i.'user_h_suppr'] AS $date)
					$date_total_h[] = JL::calcul_age_adulte_admin($date->naissance_date,$i);
				
				
				foreach($dates_naissance[$i.'user_f'] AS $date)
					$date_total_f[] = JL::calcul_age_adulte_admin($date->naissance_date,$i);
					
				foreach($dates_naissance[$i.'user_f_suppr'] AS $date)
					$date_total_f[] = JL::calcul_age_adulte_admin($date->naissance_date,$i);
					
				
				?>
					<tr class="list">
						<td><b><? echo $i; ?></b></td>
						<td><? echo round(array_sum($date_total)/count($date_total),0); ?></td>
						<td><? echo round(array_sum($date_total_h)/count($date_total_h),0); ?></td>
						<td><? echo round(array_sum($date_total_f)/count($date_total_f),0); ?></td>
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

<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class evolution_canton_HTML {	
		
		// liste les $contenus
		public static function lister(&$cantons, &$details_canton) {
			global $langue;
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
                   	<h2>Evolution des cantons par an</h2>
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
						<th>Cantons</th><?php for($i=2009;$i<=date('Y');$i++){ echo '<th>'.$i.'</th>';} ?>
						
					</tr>
		<?php 		
				
			foreach($cantons as $c){
				?>
				<tr class="list">
					<td><?php echo $c->nom_fr.' ('.$c->abreviation.')'; ?></td>
					<?php 					
					for($i=2009;$i<=date('Y');$i++){
						
						$inscrits=0;
						$abonnes=0;
					
					
						foreach($details_canton[$c->id.'user'] AS $d)
							if($d->annee == $i)
								$inscrits += $d->total;
							
						foreach($details_canton[$c->id.'user_suppr'] AS $d)
							if($d->annee == $i)
								$inscrits += $d->total;
							
						
						?>
						<td><?php echo $inscrits; ?></td>
						<?php 					}
				?>
				</tr>
			<?php 			}
		?>
			
			</table>
		</div>
			</section>
		<?php 		}
		
		
	}
?>

<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class evolution_canton_abonne_HTML {	
		
		// liste les $contenus
		public static function lister(&$cantons, &$details_canton) {
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
                     		<h2>Evolution des cantons abonn&eacute;s par an</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
					<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
				</div>
				</div>
			</div>
			
			<div class="tableAdmin">
			<table class="table table-bordered table-striped table-condensed cf" cellpadding="0" cellspacing="0">
					<tr>
						<th>Cantons</th><? for($i=2009;$i<=date('Y');$i++){ echo '<th>'.$i.'</th>';} ?>
						
					</tr>
		<?
		
				
			foreach($cantons as $c){
				?>
				<tr class="list">
					<td><? echo $c->nom_fr.' ('.$c->abreviation.')'; ?></td>
					<?
					
					for($i=2009;$i<=date('Y');$i++){
						
						$abonnes=0;
						
						foreach($details_canton[$c->id.'abonnes'] AS $d)
							if($d->annee == $i)
								$abonnes += $d->total;
						
						?>
						<td><? echo $abonnes; ?></td>
						<?
					}
				?>
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

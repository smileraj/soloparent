<?
	defined('JL') or die('Error 401');
	
	class generer_visite_HTML {	
		
		
		public static function editer(&$data, &$lists, &$messages){
			
	?>
	<script>
			function cancelsubmit(action) {
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'Annuler') {
							if(!confirm('Êtes-vous sûr de vouloir Annuler?')) {
								ok = false;
							}
						} 
						else if(action == 'Fermer') {
							if(!confirm('Êtes-vous sûr de vouloir Fermer?')) {
								ok = false;
								
							}
						}
						
						if(ok) {
						
							document.location = "<? echo SITE_URL_ADMIN; ?>"; 
						}
						
					}
				</script>
			<form name="envoi_mailForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
			<section class="panel">
                  <header class="panel-heading">
                       	<h2>G&eacute;n&eacute;rer des visites </h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">			
						<a href="javascript:document.envoi_mailForm.submit();" title="Sauver" class="btn btn-success">Sauver</a>
						<a href="javascript:cancelsubmit('Annuler')" title="Annuler" class="btn btn-success">Annuler</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
					</div>
				</div>				
				</div>
				
				<? if(count($messages)) { ?>
						<div class="messages">
							<? JL::messages($messages); ?>
						</div>
						<br />
				<? } ?>
				<div class="tableAdmin">
					<h3>Exp&eacute;diteur</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table form-group" style="border-top: 0px !important;">
						<tr>
							<td class="key">Pseudo:</td>
							<td><? echo $lists['profil_id']; ?></td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Destinataires</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Helvetica:</td>
							<td><input type="radio" id="helvetica1" name="helvetica" value='1'> <label for="helvetica1">OUI</label> <input type="radio" id="helvetica0" name="helvetica" value='0'> <label for="helvetica0">NON</label></td>
						</tr>
						<tr>
							<td class="key">Langue:</td>
							<td>
								<input type="radio" id="langue5" name="langue" value="5"> <label for="langue5">Fran&ccedil;ais</label> <br />
								<input type="radio" id="langue1" name="langue" value="1"> <label for="langue1">Anglais</label><br />
								<input type="radio" id="langue8" name="langue" value="8"> <label for="langue8">Allemand</label>
							</td>
						</tr>
					</table>
				</div>
				
				<input type="hidden" name="app" value="generer_visite">
				<input type="hidden" name="action" value="visites" />
			</section>
			
			</form>
	<?
		}
	}


?>

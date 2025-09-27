<?php 	defined('JL') or die('Error 401');
	
	class envoi_mails_HTML {	
		
		
		
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
						
							document.location = "<?php echo SITE_URL_ADMIN; ?>"; 
						}
						
					}
				</script>
			<form name="envoi_mailForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                      <h2>G&eacute;n&eacute;rer des mails </h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:document.envoi_mailForm.submit();" title="Sauver" class="save btn btn-success">Sauver</a>
						<a href="javascript:cancelsubmit('Annuler')" title="Annuler" class="cancel btn btn-success">Annuler</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="cancel btn btn-success">Fermer</a>
					</div></div>
				</div>
			
				<?php if (is_array($messages)) { ?>
						<div class="messages">
							<?php JL::messages($messages); ?>
						</div>
						<br />
				<?php } ?>
				<div class="tableAdmin">
					<h3>Exp&eacute;diteur</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Pseudo:</td>
							<td><?php echo $lists['profil_id']; ?></td>
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
				<br />
				<div class="tableAdmin">
					<h3>Mail</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Titre:</td>
							<td><input type="text" name="titre"></td>
						</tr>
						<tr>
							<td class="key">Message:</td>
							<td><textarea cols='80' rows='20' name="texte" ></textarea></td>
						</tr>
						<tr>
							<td colspan="2"><b style="color:red;">IMPORTANT :</b> Afin de pouvoir ins&eacute;rer le pseudo des personnes concern&eacute;es dans votre texte, veuillez indiquer <b>{pseudo}</b> &agrave; la place du pseudo.</td>
						</tr>
					</table>
				</div>
			<input type="hidden" name="app" value="envoi_mails">
			<input type="hidden" name="action" value="envoyer" />
				</section>
		</form>
	<?php 		}
		
		
	}


?>

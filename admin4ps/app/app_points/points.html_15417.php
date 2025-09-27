<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class HTML_points {
		
		// �dite un point du bar�me
		function baremeEdit(&$row, &$messages) {
		
			// htmlentities
			JL::makeSafe($row);
			
			?>
			<script>
			function cancelsubmit(action) {
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'Annuler') {
							if(!confirm('�tes-vous s�r de vouloir Annuler?')) {
								ok = false;
							}
						} 
						else if(action == 'Fermer') {
							if(!confirm('�tes-vous s�r de vouloir Fermer?')) {
								ok = false;
								
							}
						}
						
						if(ok) {
						
							document.location = "<?php echo SITE_URL_ADMIN; ?>/index.php?app=points&action=bareme"; 
						}
						
					}
			</script>
			<form name="editForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
			<section class="panel">
                  <header class="panel-heading">
                     	<h2>SoloFleurs: Modifier Bar&egrave;me</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save btn btn-success">Sauver</a>
						<a href="javascript:cancelsubmit('Annuler')" title="Annuler" class=" btn btn-success">Annuler</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class=" btn btn-success">Fermer</a>
					</div>
					</div>
				</div>
				
				<?php // messages d'erreurs
				if (is_array($messages)) { ?>
					<div class="messages">
						<?php JL::messages($messages); ?>
					</div>
					<br />
				<?php } ?>
				<div class="tableAdmin">
					<h3>Traductions</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key" valign="top"><label for="description">Description:</label></td>
							<td>
								<input type="text" id="description" class="msgtxt" name="description" maxlength="255" value="<?php echo $row->description; ?>"><br />
								<i>La description correspond au nom fran&ccedil;ais afin d'avoir un rep&egrave;re!</i>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="key"><label for="nom_fr">Nom <img width="20px;" src="http://www.solocircl.com/~dev/parentsolo/images/grph_flags_fr_h20.jpg" alt="fr">:</label></td>
							<td><input type="text" id="nom_fr" class="msgtxt" name="nom_fr" maxlength="255" value="<?php echo $row->nom_fr; ?>"></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="key"><label for="nom_en">Nom <img width="20px;" src="http://www.solocircl.com/~dev/parentsolo/images/grph_flags_en_h20.jpg" alt="en">:</label></td>
							<td><input type="text" id="nom_en" class="msgtxt" name="nom_en" maxlength="255" value="<?php echo $row->nom_en; ?>"></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="key"><label for="nom_de">Nom <img width="20px;" src="http://www.solocircl.com/~dev/parentsolo/images/grph_flags_de_h20.jpg" alt="de">:</label></td>
							<td><input type="text" id="nom_de" class="msgtxt" name="nom_de" maxlength="255" value="<?php echo $row->nom_de; ?>"></td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Points et occurences</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key"><label for="points">Points:</label></td>
							<td><input type="text" id="points" class="msgtxt" name="points" maxlength="5" value="<?php echo $row->points; ?>"></td>
						</tr>
						<tr>
							<td class="key" valign="top"><label for="nb_max_par_data">Occurences Max:</label></td>
							<td>
								<input type="text" id="nb_max_par_data" class="msgtxt" name="nb_max_par_data" maxlength="5" value="<?php echo $row->nb_max_par_data; ?>">
								<br />
								<i>Nombre de fois maximum qu'un utilisateur peut obtenir ces points dans les m&ecirc;mes conditions.</i><br />
								<i>Ex: recevoir <b><u>une fois</u></b> les points pour <b><u>une</u></b> connexion <b><u>par jour</u></b>.</i>
								<br />
								<i>0 = illimit&eacute;.</i>
							</td>
						</tr>
					</table>
				</div>				
				<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
				<input type="hidden" name="app" value="points" />
				<input type="hidden" name="action" value="baremesave" />
			</section>
			</form>
			<?php 		}
		
		
		// liste les points du bar�me
		function baremeList(&$rows, &$messages) {
		
			// variables
			$tdParTr 		= 3; // utile pour les colspan de toute une ligne
			
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
				<form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                     	<h2>SoloFleurs: Bar&egrave;me</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class=" btn btn-success">Fermer</a>
					</div>
					</div>
				  </div>
				<?php if (is_array($messages)) { ?>
						<div class="messages">
							<?php JL::messages($messages); ?>
						</div>
						<br />
				<?php } ?>
				<div class="tableAdmin">
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
					
						
						
						<?php if (is_array($rows)) { ?>
						
							<tr>
								<th>Description</th>
								<th>Points</th>
								<th>Occurences Max.</th>
							</tr>
							<?php 							foreach($rows as $row) {
							
								// htmlentities
								JL::makeSafe($row);
								
								?>
								<tr class="list">
									<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=points&action=baremeedit&id=<?php echo $row->id; ?>" title="Modifier le bar&egrave;me"><?php echo $row->description; ?></a></td>
									<td><?php echo $row->points; ?></td>
									<td><?php echo $row->nb_max_par_data ? $row->nb_max_par_data : 'illimit&eacute;'; ?></td>
								</tr>
								<?php 							}
							
						} else {
						?>
							<tr>
								<th colspan="<?php echo $tdParTr; ?>">Aucun bar&ecirc;me n'a &eacute;t&eacute; &eacute;tabli.</th>
							</tr>
						<?php } ?>
						
					</table>
				</div>
					<input type="hidden" name="app" value="points" />
					<input type="hidden" name="action" value="" />
				</section>
				</form>
			<?php 		}
		
		
		// �dite un point du bar�me
		function gagnantEdit(&$row, &$messages) {
		
			// htmlentities
			JL::makeSafe($row);
			
			?>
			<script>
			function cancelsubmit(action) {
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'Annuler') {
							if(!confirm('�tes-vous s�r de vouloir Annuler?')) {
								ok = false;
							}
						} 
						else if(action == 'Fermer') {
							if(!confirm('�tes-vous s�r de vouloir Fermer?')) {
								ok = false;
								
							}
						}
						
						if(ok) {
						
							document.location = "<?php echo SITE_URL_ADMIN; ?>/index.php?app=points&action=gagnant"; 
						}
						
					}
			</script>
			<form name="editForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                     	<h2>SoloFleurs: Modifier Gagnant</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class=" btn btn-success">Sauver</a>
						<a href="javascript:cancelsubmit('Annuler')" title="Annuler" class=" btn btn-success">Annuler</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class=" btn btn-success">Fermer</a>
					</div>
				  </div>
				  </div>
				<?php // messages d'erreurs
				if (is_array($messages)) { ?>
					<div class="messages">
						<?php JL::messages($messages); ?>
					</div>
					<br />
				<?php } ?>
				<div class="tableAdmin">
					<h3>Suivi</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key"><b>Pseudo:</b></td>
							<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=editer&id=<?php echo $row->user_id; ?>" title="Modifier le profil de <?php echo $row->username; ?>" target="_blank"><?php echo $row->username; ?></a></td>
						</tr>
						<tr>
							<td class="key"><b>P&eacute;riode:</b></td>
							<td><?php echo $row->annee_mois; ?></td>
						</tr>
						<tr>
							<td class="key"><b>Position:</b></td>
							<td style="background:url(<?php echo SITE_URL; ?>/parentsolo/images/pos<?php echo $row->position; ?>.gif) no-repeat;background-position:8px 8px;padding: 0 0 0 25px;"><?php echo $row->position; ?></td>
						</tr>
						<tr>
							<td class="key"><label for="commentaire">Commentaire:</label></td>
							<td><textarea id="commentaire" cols="72" rows="10" name="commentaire"><?php echo $row->commentaire; ?></textarea></td>
						</tr>
						<tr>
							<td class="key"><b>Trait&eacute;:</b></td>
							<td><input type="radio" id="traite1" name="traite" value="1" <?php if($row->traite == 1) { ?>checked<?php } ?> /> <label for="traite1">Oui</label>&nbsp;<input type="radio" id="traite0" name="traite" value="0" <?php if($row->traite == 0) { ?>checked<?php } ?> /> <label for="traite0">Non</label></td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Adresse de livraison</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key"><label for="nom">Nom:</label></td>
							<td><input type="text" id="nom" class="msgtxt" name="nom" maxlength="255" value="<?php echo $row->nom; ?>"></td>
						</tr>
						<tr>
							<td class="key"><label for="prenom">Pr&eacute;nom:</label></td>
							<td><input type="text" id="prenom" class="msgtxt" name="prenom" maxlength="255" value="<?php echo $row->prenom; ?>"></td>
						</tr>
						<tr>
							<td class="key"><label for="adresse">Adresse:</label></td>
							<td><textarea id="adresse" cols="72" rows="10" name="adresse"><?php echo $row->adresse; ?></textarea></td>
						</tr>
						<tr>
							<td class="key"><label for="code_postal">Code postal:</label></td>
							<td><input type="text" id="code_postal" class="msgtxt" name="code_postal" maxlength="255" value="<?php echo $row->code_postal; ?>"></td>
						</tr>
						<tr>
							<td class="key"><label for="ville">Ville:</label></td>
							<td><input type="text" id="ville" class="msgtxt" name="ville" maxlength="255" value="<?php echo $row->ville; ?>"></td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>T�moignage</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key"><label for="temoignage_date">Date:</label></td>
							<td><input type="text" name="temoignage_date" value="<?php echo $row->temoignage_date != '0000-00-00' ? date('d/m/Y', strtotime($row->temoignage_date)) : ''; ?>" size="9" /> <i>(jj/mm/aaaa)</i></td>
						</tr>
						<tr>
							<td class="key"><label for="temoignage">T&eacute;moignage:</label></td>
							<td><textarea id="temoignage" cols="72" rows="10" name="temoignage"><?php echo $row->temoignage; ?></textarea></td>
						</tr>
					</table>
				</div>
				<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
				<input type="hidden" name="app" value="points" />
				<input type="hidden" name="action" value="gagnantsave" />
				</section>
			</form>
			<?php 		}
		
		
		// liste les points du bar�me
		function gagnantList(&$rows, &$messages) {
		
			// variables
			$tdParTr 		= 5; // utile pour les colspan de toute une ligne
			
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
				<form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                    <h2>SoloFleurs: Gagnants</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class=" btn btn-success">Fermer</a>
					</div>
				  </div>
				  </div>
				<?php if (is_array($messages)) { ?>
						<div class="messages">
							<?php JL::messages($messages); ?>
						</div>
						<br />
				<?php } ?>
				<div class="tableAdmin">
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
						<?php if (is_array($rows)) { ?>
						
							<tr>
								<th width="60px">Mois</th>
								<th width="60px" align="center">Position</th>
								<th width="100px">Pseudo</th>
								<th width="60px" align="center">Trait&eacute;</th>
								<th width="60px" align="center">T&eacute;moign&eacute;</th>
								<th>Commentaire</th>
							</tr>
							<?php 							foreach($rows as $row) {
							
								// htmlentities
								JL::makeSafe($row);
								
								?>
								<tr class="list">
									<td><?php echo date('m/Y', strtotime($row->annee_mois.'-01')); ?></td>
									<td align="center"><?php echo $row->position; ?></td>
									<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=points&action=gagnantedit&id=<?php echo $row->id; ?>" title="Modifier le gagnant"><?php echo $row->username; ?></a></td>
									<td align="center"><img src="<?php echo SITE_URL_ADMIN; ?>/images/<?php echo $row->traite; ?>.png" alt="<?php echo $row->traite ? 'Trait&eacute;' : 'Non trait&eacute;'; ?>" /></td>
									<td align="center"><img src="<?php echo SITE_URL_ADMIN; ?>/images/<?php echo $row->temoigne; ?>.png" alt="<?php echo $row->temoigne ? 'T&eacute;moignage publi&eacute;' : 'T&eacute;moignage non publi&eacute;'; ?>" /></td>
									<td><?php echo $row->commentaire; ?></td>
								</tr>
								<?php 							}
							
						} else {
						?>
							<tr>
								<th colspan="<?php echo $tdParTr; ?>">Aucun gagnant n'a encore &eacute;t&eacute; d&eacute;sign&eacute;.</th>
							</tr>
						<?php } ?>
						
					</table>
				</div>
					<input type="hidden" name="app" value="points" />
					<input type="hidden" name="action" value="" />
				</section>
				</form>
			<?php 		}
		
		
		// liste les points du bar�me
		function classementList(&$rows, &$list) {
		
			// variables
			$tdParTr 		= 3; // utile pour les colspan de toute une ligne
			
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
				<form name="adminForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                     	<h2>SoloFleurs: Classement</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class=" btn btn-success">Fermer</a>
					</div>
				  </div>
				</div>				
				<div class="tableAdmin">
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
						<tr>
							<td><label for="annee_mois"><b>P&eacute;riode:</b></label></td>
							<td colspan="<?php echo $tdParTr-1; ?>"><?php echo $list['annee_mois']; ?></td>
						</tr>
						
						<?php if (is_array($rows)) { ?>
						
							<tr>
								<th align="center" width="60px">Position</th>
								<th>Pseudo</th>
								<th width="60px">Points</th>
							</tr>
							<?php 							$pos = 1;
							foreach($rows as $row) {
							
								// htmlentities
								JL::makeSafe($row);
								
								?>
								<tr class="list">
									<td align="center"><?php echo $pos; ?></td>
									<td><?php echo $row->username; ?></td>
									<td><?php echo $row->points; ?></td>
								</tr>
								<?php 								$pos++;
							}
							
						} else {
						?>
							<tr>
								<th colspan="<?php echo $tdParTr; ?>">Aucun classement n'a encore &eacute;t&eacute; &eacute;tabli.</th>
							</tr>
						<?php } ?>
						
					</table>
				</div>
					<input type="hidden" name="app" value="points" />
					<input type="hidden" name="action" value="classement" />
				</section>
				</form>
			<?php 		}
		
	}
?>

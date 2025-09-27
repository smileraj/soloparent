<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class HTML_groupe {	
		
		// liste les profils
		function groupeLister(&$rows, &$search, &$lists, &$messages) {
		
			// variables
			$i 				= 0; // compteur de tr
			$td 			= 0; // compteur de td
			$tdParTr		= 4; // nombre de td par ligne
			$rayon 			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
			
			?>
				<script language="javascript" type="text/javascript">
					function submitform(action) {
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'supprimer') {
							if(!confirm('Voulez-vous vraiment supprimer les groupes s�lectionn�s ?')) {
								ok = false;
							}
						} else if(action == 'desactiver') {
							if(!confirm('Voulez-vous vraiment d�sactiver les groupes s�lectionn�s ?')) {
								ok = false;
							}
						} else if(action == 'activer') {
							if(!confirm('Voulez-vous vraiment activer les groupes s�lectionn�s ?')) {
								ok = false;
							}
						}
						
						if(ok) {
							form.action.value = action;
							form.submit();
						}
						
					}
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
                      	<h2>Groupes</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class=" btn btn-success">Fermer</a>
					</div></div>	
				</div>
				<br />
				<?php if (is_array($messages)) { ?>
						<div class="messages">
							<?php JL::messages($messages); ?>
						</div>
						<br />
				<?php } ?>
				<div class="tableAdmin">
					<div class="filtre">
						<table class="table table-bordered table-striped table-condensed cf">
							<tr>
								<td><b>Recherche:</b></td>
								<td><input type="text" name="search_g_word" id="search_g_word" value="<?php echo makeSafe($search['word']); ?>" class="searchInput" /></td>
							<tr>
							<tr>
								<td><b>Tri par:</b></td>
								<td><?php echo $lists['order']; ?></td>
								<td><b>Statut:</b></td>
								<td><?php echo $lists['active']; ?></td>

							</tr>
							<tr>
								<td><b>Ordre:</b></td>
								<td><?php echo $lists['ascdesc']; ?></td>
							</tr>
							<tr>
								<td colspan="4" align="right">
									<a href="javascript:document.listForm.submit();" class="bouton envoyer">Rechercher</a>
								</td>
							</tr>
						</table>
					</div>
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
						
						<?php if (is_array($rows)) { ?>
						<tr>
							<th width="20px"></th>
							<th style="width:50px; text-align:center;">Statut</th>
							<th>Titre</th>
							<th style="width: 150px;">Cr&eacute;ation date</th>
						</tr>
						<?php 						foreach($rows as $row) {
						
							// htmlentities
							JL::makeSafe($row);
							
							?>
							<tr class="list">
								<td align="center"><input type="checkbox" name="id[]" value="<?php echo $row->id; ?>" id="user_<?php echo $row->id; ?>"></td>
								<td align="center"><img src="images/<?php echo $row->active; ?>.png" alt="" /></td>
								<td>
									<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=groupe&action=edit&id=<?php echo $row->id; ?>" title="Modifier le t&eacute;moignage"><?php echo $row->titre; ?></a><br />
									<i>par <b><?php echo $row->username; ?></b></i>
								</td>
								<td><?php echo date('d/m/Y � H:i:s', strtotime($row->date_add)); ?></td>
							</tr>
							<?php 						}
						?>
					
						<tr>
							<td colspan="<?php echo $tdParTr; ?>">
								<b>Pages</b>:
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=groupe&search_g_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=groupe&search_g_page='.$i); ?>" title="Afficher la page <?php echo $i; ?>" <?php if($i == $search['page']) { ?>class="displayActive"<?php } ?>><?php echo $i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=groupe&search_g_page='.$search['page_total']); ?>" title="Afficher la page <?php echo $search['page_total']; ?>">Fin</a><?php }?> <i>(<?php echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
					<?php } else { ?>
						<tr>
							<th colspan="<?php echo $tdParTr; ?>">Aucun groupe ne correspond &agrave; votre recherche.</th>
						</tr>
					<?php } ?>
					</table>
				</div>
					<input type="hidden" name="search_g_page" value="1" />
					<input type="hidden" name="app" value="groupe" />
					<input type="hidden" name="action" value="" />
				</section>
				</form>
			<?php 		}
		
		
		// formlaire d'�dition d'un profil
		function groupeEditer(&$row, &$messages) {
			
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
						
							document.location = "<?php echo SITE_URL_ADMIN; ?>/index.php?app=groupe"; 
						}
						
					}
			</script>
			<form name="editForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                     	<h2>Groupe</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="btn btn-success" >Sauver</a>
						<a href="javascript:cancelsubmit('Annuler')" title="Annuler" class="btn btn-success">Annuler</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
					</div>
				  </div>
				</div>
				<br />
				<?php // messages d'erreurs
				if (is_array($messages)) { ?>
					<div class="messages">
						<?php JL::messages($messages); ?>
					</div>
					<br />
				<?php } ?>
				<div class="tableAdmin">
					<h3>Informations</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key"><b>Titre d'origine:</b></td>
							<td><?php echo $row->titre_origine; ?></td>
						</tr>
						<tr>
							<td class="key"><b>Texte d'origine:</b></td>
							<td><?php echo nl2br($row->texte_origine); ?></td>
						</tr>
						<tr>
							<td class="key"><b>Photo active:</b></td>
							<td>
							<?php 							
								// si une photo a �t� envoy�e
								$filePath = 'images/groupe/'.$row->id.'.jpg';
								if(is_file(SITE_PATH.'/'.$filePath)) {
									$image	= $filePath;
								} else {
									$image	= 'images/groupes-parentsolo.jpg';
								}
								
								?>
								<label for="<?php echo $filePath; ?>"><img src="<?php echo SITE_URL.'/'.$image; ?>?<?php echo time(); ?>" /></label><br />
								<?php if(is_file(SITE_PATH.'/'.$filePath)) { ?><input type="checkbox" name="photo_delete" value="<?php echo $filePath; ?>" id="photo_delete" /> <label for="photo_delete">Supprimer</label><?php } ?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="key"><label for="titre">Titre:</label></td>
							<td><input type="text" id="titre" style="width:450px;" name="titre" maxlength="70" value="<?php echo $row->titre; ?>"></td>
						</tr>
						<tr>
							<td class="key"><label for="texte">Texte:</label></td>
							<td>
								<textarea name="texte" id="texte" rows="10" cols="72"><?php echo $row->texte; ?></textarea>
							</td>
						</tr>
						<?	
						
							// attente validation
							if(is_file(SITE_PATH.'/images/groupe/pending/'.$row->id.'.jpg')) {
							?>
							<tr>
								<td class="key"><b>Photo envoy&eacute;e:</b></td>
								<td>
									<img src="<?php echo SITE_URL.'/images/groupe/pending/'.$row->id.'.jpg'; ?>?<?php echo time(); ?>" /><br />
									<div class="statut statut1"><input type="radio" name="photo_valider" value="1" id="photo_valider1" /> <label for="photo_valider1">Valider</label></div>
									<div class="statut statut0"><input type="radio" name="photo_valider" value="0" id="photo_valider0" /> <label for="photo_valider0">Refuser</label></div>
									<div class="statut statut2"><input type="radio" name="photo_valider" value="2" id="photo_valider2" checked="true" /> <label for="photo_valider2">En attente</label></div>
								</td>
							</tr>
							<?php 							}
							
						?>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Administration</h3>
					<br />
					<table class="table table-bordered table-striped table-condensed cf editer" cellpadding="0" cellspacing="0">
						<tr>
							<td class="key"><b>Fondateur:</b</td>
							<td>
								<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=editer&id=<?php echo $row->user_id; ?>" title="Profil de <?php echo $row->username; ?>" target="_blank"><?php echo $row->username; ?></a>
							</td>
						</tr>
						<tr>
							<td class="key"><label for="statut">Statut:</label></td>
							<td>
								<div class="statut statut1"><input type="radio" name="active" value="1" id="active1" <?php if($row->active == 1) { ?>checked="true"<?php } ?> /> <label for="active1">Publi&eacute;</label></div>
								<div class="statut statut0"><input type="radio" name="active" value="0" id="active0" <?php if($row->active == 0) { ?>checked="true"<?php } ?> /> <label for="active0">Refus&eacute;</label></div>
								<div class="statut statut2"><input type="radio" name="active" value="2" id="active2" <?php if($row->active == 2) { ?>checked="true"<?php } ?> /> <label for="active2">En attente</label></div>
								<div class="statut statut3"><input type="radio" name="active" value="3" id="active3" <?php if($row->active == 3) { ?>checked="true"<?php } ?> /> <label for="active3">Verouill&eacute;</label>: Le groupe sera <b>publi&eacute;</b> et ne pourra plus &ecirc;tre modifi&eacute; par son fondateur</div>
							</td>
						</tr>
						<tr>
							<td class="key"><label for="motif">Message:</label></td>
							<td>
								<textarea name="motif" id="motif"rows="10" cols="72"><?php echo $row->motif; ?></textarea><br />
								<i>Vous pouvez indiquer un motif de refus, ou des pr&eacute;cisions si vous avez effectu&eacute; des corrections/modifications. Ce message sera <span style="color:#990000;font-weight:bold;">lisible par le membre</span>.</i>
							</td>
						</tr>
					</table>
				</div>
				<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
				<input type="hidden" name="app" value="groupe" />
				<input type="hidden" name="action" value="save" />
				</section>
			</form>
			<?php 		}
		
	}
?>

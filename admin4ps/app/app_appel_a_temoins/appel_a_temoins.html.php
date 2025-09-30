<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class HTML_appel_a_temoins {	
		
		// liste les profils
		public static function appel_a_temoinsLister(&$rows, &$search, &$lists, &$messages) {
		
			// variables
			$i 				= 0; // compteur de tr
			$td 			= 0; // compteur de td
			$tdParTr		= 5; // nombre de td par ligne
			$rayon 			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
			
			?>
				<script language="javascript" type="text/javascript">
					function submitform(action) {
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'supprimer') {
							if(!confirm('Voulez-vous vraiment supprimer les appels � t�moins s�lectionn�s ?')) {
								ok = false;
							}
						} else if(action == 'desactiver') {
							if(!confirm('Voulez-vous vraiment d�sactiver les appels � t�moins s�lectionn�s ?')) {
								ok = false;
							}
						} else if(action == 'activer') {
							if(!confirm('Voulez-vous vraiment activer les appels � t�moins s�lectionn�s ?')) {
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
                     	<h2>Appels &agrave; t&eacute;moins</h2>
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
					<div class="filtre">
						<table class="table table-bordered table-striped table-condensed cf">
							<tr>
								<td><b>Recherche:</b></td>
								<td><input type="text" name="search_at_word" id="search_at_word" value="<?php echo makeSafe($search['word']); ?>" class="searchInput" /></td>
							</tr>
							<tr>
								<td><b>Tri par:</b></td>
								<td><?php echo $lists['order']; ?></td>
								<td><b>Statut:</b></td>
								<td><?php echo $lists['active']; ?></td>
							</tr>
							<tr>
								<td><b>Ordre:</b></td>
								<td><?php echo $lists['ascdesc']; ?></td>
								<td><b>M&eacute;dia:</b></td>
								<td><?php echo $lists['media_id']; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="4" align="right"><a href="javascript:document.listForm.submit();" class="bouton envoyer" />Rechercher</a></td>
							</tr>
						</table>
					</div>
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
				
						<?php if (is_array($rows)) { ?>
						<tr>
							<th width="20px"></th>
							<th align="center">Statut</th>
							<th>Titre</th>
							<th style="width: 75px;">M&eacute;dia</th>
							<th style="width: 150px;">Date de cr&eacute;ation</th>
						</tr>
						<?php 						foreach($rows as $row) {
						
							// htmlentities
							JL::makeSafe($row);
							
							?>
							<tr class="list">
								<td align="center"><input type="checkbox" name="id[]" value="<?php echo $row->id; ?>" id="user_<?php echo $row->id; ?>"></td>
								<td align="center"><img src="images/<?php echo $row->active; ?>.png" alt="" /></td>
								<td>
									<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=appel_a_temoins&action=edit&id=<?php echo $row->id; ?>" title="Modifier l'appel &agrave; t&eacute;moins"><?php echo $row->titre; ?></a><br />
									<i>par <b><?php echo $row->nom.' '.$row->prenom; ?></b></i>
								</td>
								<td><?php echo $row->media; ?></td>
								<td><?php echo date('d/m/Y � H:i:s', strtotime((string) $row->date_add)); ?></td>
							</tr>
							<?php 						}
						?>
					
						<tr>
							<td colspan="<?php echo $tdParTr; ?>">
								<b>Pages</b>:
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=appel_a_temoins&search_at_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=appel_a_temoins&search_at_page='.$i); ?>" title="Afficher la page <?php echo $i; ?>" <?php if($i == $search['page']) { ?>class="displayActive"<?php } ?>><?php echo $i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=appel_a_temoins&search_at_page='.$search['page_total']); ?>" title="Afficher la page <?php echo $search['page_total']; ?>">Fin</a><?php }?> <i>(<?php echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
					<?php } else { ?>
						<tr>
							<th colspan="<?php echo $tdParTr; ?>">Aucun appel &agrave; t&eacute;moins ne correspond &agrave; votre recherche.</th>
						</tr>
					<?php } ?>
					</table>
				</div>
					<input type="hidden" name="search_at_page" value="1" />
					<input type="hidden" name="app" value="appel_a_temoins" />
					<input type="hidden" name="action" value="" />
				</section>
				</form>
			<?php 		}
		
		
		// formlaire d'�dition d'un profil
		public static function appel_a_temoinsEditer(&$row, &$messages, &$list) {
			
			require_once(SITE_PATH.'/fckeditor/fckeditor.php'); 
			
			// htmlentities
			JL::makeSafe($row, 'annonce');
			
			?>
			<Script>
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
						
							document.location = "<?php echo SITE_URL_ADMIN; ?>/index.php?app=appel_a_temoins"; 
						}
						
					}
			</script>
			<form name="editForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
			<section class="panel">
                  <header class="panel-heading">
                     	<h2>Appel &agrave; t&eacute;moins</h2>
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
					<h2>Annonce</h2>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key"><label for="media_id">Type de M&eacute;dia:</label></td>
							<td><?php echo $list['media_id']; ?></td>
						</tr>
						<tr>
							<td class="key"><label for="titre">Titre:</label></td>
							<td><input type="text" id="titre" class="msgtxt" name="titre" maxlength="150" value="<?php echo $row->titre; ?>"></td>
						</tr>
						<tr>
							<td class="key"><label for="annonce">Annonce:</label></td>
							<td>
								<?php
									
									$oFCKeditor = new FCKeditor('annonce', '400', '571px'); // FCKeditor1
									$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
									
									$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath.'editor/skins/silver/';
									$oFCKeditor->ToolbarSet			= 'Basic';
									
									$oFCKeditor->Value = $row->annonce;
									$oFCKeditor->Create();
									
								?>
							<!--<textarea name="annonce" id="annonce" class="msgtxt2"><?php echo $row->annonce; ?></textarea>-->
							</td>
						</tr>
						<tr>
							<td class="key"><label for="date_limite">Date limite:</label></td>
							<td><input type="text" id="date_limite" class="msgtxt" name="date_limite" maxlength="50" value="<?php echo $row->date_limite; ?>"></td>
						</tr>
						<tr>
							<td class="key"><label for="date_diffusion">Date de publication:</label></td>
							<td><input type="text" id="date_diffusion" class="msgtxt" name="date_diffusion" maxlength="50" value="<?php echo $row->date_diffusion; ?>"></td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h2>Coordonn&eacute;es</h2>
					<br />
					<table class="table table-bordered table-striped table-condensed cf editer" cellpadding="0" cellspacing="0">
						<tr>
							<td class="key"><label for="nom">Nom:</label></td>
							<td><input type="text" id="nom" class="msgtxt" name="nom" maxlength="50" value="<?php echo $row->nom; ?>"></td>
						</tr>
						<tr>
							<td class="key"><label for="prenom">Pr&eacute;nom:</label></td>
							<td><input type="text" id="prenom" class="msgtxt" name="prenom" maxlength="50" value="<?php echo $row->prenom; ?>"></td>
						</tr>
						<tr>
							<td class="key"><label for="telephone">Telephone:</label></td>
							<td><input type="text" id="telephone" class="msgtxt" name="telephone" maxlength="50" value="<?php echo $row->telephone; ?>"></td>
						</tr>
						<tr>
							<td class="key"><label for="adresse">Adresse:</label></td>
							<td>
								<textarea name="adresse" class="msgtxt" style="height:50px;"><?php echo $row->adresse; ?></textarea>
							</td>
						</tr>
						<tr>
							<td class="key"><label for="email">Email:</label></td>
							<td><input type="text" id="email" class="msgtxt" name="email" maxlength="50" value="<?php echo $row->email; ?>"></td>
						</tr>
						<?php // si un logo a �t� envoy�
						if(is_file(SITE_PATH.'/images/appel-a-temoins/'.$row->id.'.jpg')) { ?>
						<tr>
							<td class="key">Logo:</td>
							<td>
								<img src="<?php echo SITE_URL; ?>/images/appel-a-temoins/<?php echo $row->id; ?>.jpg" alt="" /><br />
								<input type="checkbox" name="logo_delete" id="logo_delete" /> <label for="logo_delete">Supprimer</label>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h2>Administration</h2>
					<br />
					<table class="table table-bordered table-striped table-condensed cf editer" cellpadding="0" cellspacing="0">
						<tr>
							<td class="key"><label for="statut">Statut:</label></td>
							<td>
								<div class="statut statut1"><input type="radio" name="active" value="1" id="active1" <?php if($row->active == 1) { ?>checked="true"<?php } ?> /> <label for="active1">Publi&eacute;</label></div>
								<div class="statut statut0"><input type="radio" name="active" value="0" id="active0" <?php if($row->active == 0) { ?>checked="true"<?php } ?> /> <label for="active0">Refus&eacute;</label></div>
								<div class="statut statut2"><input type="radio" name="active" value="2" id="active2" <?php if($row->active == 2) { ?>checked="true"<?php } ?> /> <label for="active2">En attente</label></div>
								<span class="attention">
									<b>Attention !</b><br />
									Un email sera envoy&eacute; &agrave; l'annonceur si le statut<br />
									passe de &quot;En attente&quot; &agrave; &quot;Publi&eacute;&quot; ou &quot;Refus&eacute;&quot;
								</span>
							</td>
						</tr>
						<tr>
							<td class="key"><label for="motif">Message:</label></td>
							<td>
								<textarea name="motif" id="motif" class="msgtxt2"><?php echo $row->motif; ?></textarea><br />
								<i>Vous pouvez joindre un message &agrave; l'email automatiquement envoy&eacute;<br />
								en cas de refus (ex: motif du refus) ou de validation.</i>
							</td>
						</tr>
					</table>
				</div>
				<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
				<input type="hidden" name="app" value="appel_a_temoins" />
				<input type="hidden" name="action" value="save" />
			</section>
			</form>
			<?php 		}
		
	}
?>

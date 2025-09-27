<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class HTML_mailing_auto {	
		
		// liste les profils
		public static function mailingLister(&$rows, &$search, &$messages) {
		
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
							if(!confirm('Voulez-vous vraiment supprimer les mailings sélectionnés ?')) {
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
							if(!confirm('Êtes-vous sûr de vouloir Fermer?')) {
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
                     <h2>Mailing automatis&eacute;</h2>
                 </header>
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing_auto&action=edit" title="R&eacute;diger un nouveau mailing" class=" btn btn-success">Nouveau</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-danger">Fermer</a>
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
							<th width="20px"></th>
							<th align="left">Nom</th>
							<th style="width: 150px;">Mise &agrave; jour</th>
							<th style="width: 80px;text-align:center;">Envoyer</th>
						</tr>
						<?php 						foreach($rows as $row) {
						
							// htmlentities
							JL::makeSafe($row);
							
							?>
							<tr class="list">
								<td align="center"><input type="checkbox" name="id[]" value="<?php echo $row->id; ?>" id="mailing_<?php echo $row->id; ?>"></td>
								<td>
									<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing_auto&action=edit&id=<?php echo $row->id; ?>" title="Modifier le mailing"><?php echo $row->nom; ?></a>
								</td>
								<td><?php echo date('d/m/Y à H:i:s', strtotime($row->datetime_update)); ?></td>
								<td align="center">
									<a href="<?php echo JL::url('index.php?app=mailing_auto&action=envoyer&id='.$row->id); ?>" title="Envoyer ce mailing"><img src="<?php echo SITE_URL_ADMIN; ?>/images/mailing.png" alt="" />
								</td>
							</tr>
							<?php 						}
						?>
					
						<tr>
							<td colspan="<?php echo $tdParTr; ?>">
								<b>Pages</b>:
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=mailing_auto&search_at_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=mailing_auto&search_at_page='.$i); ?>" title="Afficher la page <?php echo $i; ?>" <?php if($i == $search['page']) { ?>class="displayActive"<?php } ?>><?php echo $i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=mailing_auto&search_at_page='.$search['page_total']); ?>" title="Afficher la page <?php echo $search['page_total']; ?>">Fin</a><?php }?> <i>(<?php echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
					<?php } else { ?>
						<tr>
							<th colspan="<?php echo $tdParTr; ?>">Aucun mailing n'a &eacute;t&eacute; r&eacute;dig&eacute;.</th>
						</tr>
					<?php } ?>
					</table>
					</div>
					<input type="hidden" name="search_at_page" value="1" />
					<input type="hidden" name="app" value="mailing_auto" />
					<input type="hidden" name="action" value="" />
				</section>
				</form>
			<?php 		}
		
		
		public static function mailingEdit(&$row, &$list, &$messages) {
			
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
						
							document.location = "<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing_auto"; 
						}
						
					}
				
			</script>
		
                 <header class="panel-heading">
                   <h2>Mailing automatis&eacute;: <?php echo $row->id ? 'Editer' : 'Nouveau'; ?></h2>
                </header>
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
				<?php if($row->id){?><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing_auto&action=apercu&id=<?php echo $row->id; ?>" target="_blank" title="Apercu" class="btn btn-success">Aper&ccedil;u</a><?php } ?>
					<a href="javascript:document.editForm.submit();" title="Sauver" class="btn btn-success">Sauver</a>
					<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-danger">Fermer</a>
				</div>
				</div>				
			</div>
			<br />
		<?php 
			if (is_array($messages)) { 
		?>
				<div class="messages">
					<?php JL::messages($messages); ?>
				</div>
				<br />
		<?php 
			} 
			
			$dir = $row->upload_dir;
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {

					// récup les miniatures de photos valides
					if(preg_match('/^news_publi/', $file)) {
						
						$photos_news_publi[]		= $file;
						$photoNum_news_publi[]		= preg_replace('/[^0-9]/', '', $file);
						
					} elseif(preg_match('/^temp-news_publi/', $file)) {
					
						$photosTemp_news_publi[]	= $file;
						$photoNumTemp_news_publi[]		= preg_replace('/[^0-9]/', '', $file);
						
					} elseif(preg_match('/^actu_ps/', $file)) {
						
						$photos_actu_ps[]		= $file;
						$photoNum_actu_ps[]		= preg_replace('/[^0-9]/', '', $file);
						
					} elseif(preg_match('/^temp-actu_ps/', $file)) {
					
						$photosTemp_actu_ps[]	= $file;
						$photoNumTemp_actu_ps[]		= preg_replace('/[^0-9]/', '', $file);
						
					}
				
				}
				
			}
			
			include(SITE_PATH.'/fckeditor/fckeditor.php');
			?>
			<script type="text/javascript" src="<?php echo SITE_URL; ?>/fckeditor/fckeditor.js"></script>
			
			<form name="editForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
				<input type="hidden" name="app" value="mailing_auto" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="upload_dir" id="upload_dir" value="<?php echo $row->upload_dir; ?>" />
				
				
				<div class="tableAdmin">
					<h3>Informations</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">
								<label for="nom">Nom</label>
							</td>
							<td><input type="text" name="nom" id="nom" value="<?php echo $row->nom; ?>" style="width:500px;" /></td>
						</tr>
						<tr>
							<td class="key">
								<label for="description">Description</label>
							</td>
							<td>
								<textarea name="description" style="width:500px;height:75px;border:0;"><?php echo $row->description; ?></textarea>
							</td>
						</tr>
						<?php if(isset($row->datetime_update)) { ?>
						<tr>
							<td class="key">Mise &agrave; jour</td>
							<td><?php echo date('d/m/Y à H:i:s', strtotime($row->datetime_update)); ?></td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Mail</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">
								<label for="template">Template</label>
							</td>
							<td><?php echo $list['template']; ?></td>
						</tr>
						<tr>
							<td class="key">
								<label for="sujet">Sujet</label>
							</td>
							<td>
								<input type="text" name="sujet" maxlength="255" style="width:500px;" value="<?php echo $row->sujet; ?>" /><br />
								<i>Evitez au maximum les accents dans le sujet du mail</i>
							</td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Publicités (optionnel)</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">
								<label for="pub_leaderboard">Leaderboard</label>
							</td>
							<td>
								<textarea name="pub_leaderboard" style="width:500px;height:75px;border:0;"><?php echo $row->pub_leaderboard; ?></textarea>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="active_pub_leaderboard">Activé</label>
							</td>
							<td>
								<?php JL::radioYesNo('active_pub_leaderboard', $row->active_pub_leaderboard); ?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="pub_medium_rectangle">Medium Rectangle</label>
							</td>
							<td>
								<textarea name="pub_medium_rectangle" style="width:500px;height:75px;border:0;"><?php echo $row->pub_medium_rectangle; ?></textarea>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="active_pub_medium_rectangle">Activé</label>
							</td>
							<td>
								<?php JL::radioYesNo('active_pub_medium_rectangle', $row->active_pub_medium_rectangle); ?>
							</td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>News publi (optionnel)</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">
								<label for="active_news_publi">Activé</label>
							</td>
							<td>
								<?php JL::radioYesNo('active_news_publi', $row->active_news_publi); ?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="titre_news_publi">Titre</label>
							</td>
							<td>
								<input type="text" name="titre_news_publi" maxlength="255" style="width:500px;" value="<?php echo $row->titre_news_publi; ?>" />
							</td>
						</tr>
						<tr>
							<td class="key">Texte</td>
							<td>
							<?php
								
								$oFCKeditor = new FCKeditor('texte_news_publi', '400', '571px');
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
								
								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
								$oFCKeditor->ToolbarSet			= 'Basic';
								
								$oFCKeditor->Value = $row->texte_news_publi;
								$oFCKeditor->Create() ;
								
							?>
							</td>
						</tr>
					<?php 						if (is_array($photos_news_publi)) {
							?>
							<tr>
								<td class="key">
									<label for="lien_news_publi">Lien de la photo</label>
								</td>
								<td>
									<input type="text" name="lien_news_publi" maxlength="255" style="width:500px;" value="<?php echo $row->lien_news_publi; ?>" />
								</td>
							</tr>
					<?php 						}
					?>
						<tr>
							<td class="key">Photo envoyée</td>
							<td>
								<ul id="filesOK">
								<?php 									if (is_array($photos_news_publi)) {
										$i = 0;
										foreach($photos_news_publi as $photo_news_publi) {
										?>
											<li class="fileOK">
												<img src="<?php echo $row->upload_dir.'/'.$photo_news_publi; ?>?<?php echo JL::microtime_float()*10000; ?>"/>
												<a href="javascript:deletePhoto('<?php echo $photo_news_publi; ?>', 'news_publi-OK')" id="news_publi-OK" >X Supprimer</a>
											</li>
										<?php 											$i++;
										}
									}
								?>
								</ul>
							</td>
						</tr>
					<?php 						if (is_array($photosTemp_news_publi)) {
						?>
							<tr>
								<td class="key">Photo en attente</td>
								<td>
									<ul id="filesTemp">
									<?php 										$i = 0;
										foreach($photosTemp_news_publi as $photoTemp_news_publi) {
										?>
											<li class="fileTemp">
												<img src="<?php echo $row->upload_dir.'/'.$photoTemp_news_publi; ?>"/>
												<a href="javascript:deletePhoto('<?php echo $photoTemp_news_publi; ?>', 'news_publi-Temp')" id="news_publi-Temp" >X Supprimer</a>
											</li>
										<?php 											$i++;
										}
										?>
									</ul>
								</td>
							</tr>
					<?php 						}
					?>
						<tr>
							<td class="keyLast">Fichier</td>
							<td>
								<span class="notice_news_publi">Vous pouvez télécharger 1 seul image</span><br />
								<br />
								<!-- Upload Button-->
								<div id="upload_news_publi" >Parcourir...</div><span id="status_news_publi" ></span>
								<!--List Files-->
								<ul id="files_news_publi_error" ></ul>
								<div class="clear"></div>
								<ul id="files_news_publi" ></ul>
							</td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Actu parentsolo (optionnel)</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">
								<label for="active_actu_ps">Activé</label>
							</td>
							<td>
								<?php JL::radioYesNo('active_actu_ps', $row->active_actu_ps); ?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="titre_actu_ps">Titre</label>
							</td>
							<td>
								<input type="text" name="titre_actu_ps" maxlength="255" style="width:500px;" value="<?php echo $row->titre_actu_ps; ?>" />
							</td>
						</tr>
						<tr>
							<td class="key">Texte</td>
							<td>
							<?php
								
								$oFCKeditor = new FCKeditor('texte_actu_ps', '400', '571px');
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
								
								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
								$oFCKeditor->ToolbarSet			= 'Basic';
								
								$oFCKeditor->Value = $row->texte_actu_ps;
								$oFCKeditor->Create() ;
								
							?>
							</td>
						</tr>
					<?php 						if (is_array($photos_actu_ps)) {
							?>
							<tr>
								<td class="key">
									<label for="lien_actu_ps">Lien de la photo</label>
								</td>
								<td>
									<input type="text" name="lien_actu_ps" maxlength="255" style="width:500px;" value="<?php echo $row->lien_actu_ps; ?>" />
								</td>
							</tr>
					<?php 						}
					?>
						<tr>
							<td class="key">Photo envoyée</td>
							<td>
								<ul id="filesOK">
								<?php 									if (is_array($photos_actu_ps)) {
										$i = 0;
										foreach($photos_actu_ps as $photo_actu_ps) {
										?>
											<li class="fileOK">
												<img src="<?php echo $row->upload_dir.'/'.$photo_actu_ps; ?>?<?php echo JL::microtime_float()*10000; ?>"/>
												<a href="javascript:deletePhoto('<?php echo $photo_actu_ps; ?>', 'actu_ps-OK')" id="actu_ps-OK" >X Supprimer</a>
											</li>
										<?php 											$i++;
										}
									}
								?>
								</ul>
							</td>
						</tr>
					<?php 						if (is_array($photosTemp_actu_ps)) {
						?>
							<tr>
								<td class="key">Photo en attente</td>
								<td>
									<ul id="filesTemp">
									<?php 										$i = 0;
										foreach($photosTemp_actu_ps as $photoTemp_actu_ps) {
										?>
											<li class="fileTemp">
												<img src="<?php echo $row->upload_dir.'/'.$photoTemp_actu_ps; ?>"/>
												<a href="javascript:deletePhoto('<?php echo $photoTemp_actu_ps; ?>', 'actu_ps-Temp')" id="actu_ps-Temp" >X Supprimer</a>
											</li>
										<?php 											$i++;
										}
										?>
									</ul>
								</td>
							</tr>
					<?php 						}
					?>
						<tr>
							<td class="keyLast">Fichier</td>
							<td>
								<span class="notice_actu_ps">Vous pouvez télécharger 1 seul image</span><br />
								<br />
								<!-- Upload Button-->
								<div id="upload_actu_ps" >Parcourir...</div><span id="status_actu_ps" ></span>
								<!--List Files-->
								<ul id="files_actu_ps_error" ></ul>
								<div class="clear"></div>
								<ul id="files_actu_ps" ></ul>
							</td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h2>Agendas (optionnel)</h2>
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">
								<label for="active_agendas">Activés</label>
							</td>
							<td>
								<?php JL::radioYesNo('active_agendas', $row->active_agendas); ?>
							</td>
						</tr>
					</table>
					<br />
					<h3>1er agenda Babybook</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">
								<label for="agenda1_titre">Titre</label>
							</td>
							<td>
								<input type="text" name="agenda1_titre" maxlength="255" style="width:500px;" value="<?php echo $row->agenda1_titre; ?>" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="agenda1_date">Date</label>
							</td>
							<td>
								<input type="text" name="agenda1_date" maxlength="255" style="width:500px;" value="<?php echo $row->agenda1_date; ?>" /> <i>jj/mm/aaaa ou jj/mm/aaaa-jj/mm/aaaa</i>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="agenda1_lieu">Lieu</label>
							</td>
							<td>
								<input type="text" name="agenda1_lieu" maxlength="255" style="width:500px;" value="<?php echo $row->agenda1_lieu; ?>" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="agenda1_image">Chemin image Babybook</label>
							</td>
							<td>
								<input type="text" name="agenda1_image" maxlength="255" style="width:500px;" value="<?php echo $row->agenda1_image; ?>" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="agenda1_intro">Intro</label>
							</td>
							<td>
								<textarea name="agenda1_intro" style="width:500px;height:75px;border:0;"><?php echo $row->agenda1_intro; ?></textarea>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="agenda1_lien">Lien</label>
							</td>
							<td>
								<input type="text" name="agenda1_lien" maxlength="255" style="width:500px;" value="<?php echo $row->agenda1_lien; ?>" />
							</td>
						</tr>
					</table>
					<br />
					<h3>2e agenda Babybook</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">
								<label for="agenda2_titre">Titre</label>
							</td>
							<td>
								<input type="text" name="agenda2_titre" maxlength="255" style="width:500px;" value="<?php echo $row->agenda2_titre; ?>" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="agenda2_date">Date</label>
							</td>
							<td>
								<input type="text" name="agenda2_date" maxlength="255" style="width:500px;" value="<?php echo $row->agenda2_date; ?>" /> <i>jj/mm/aaaa ou jj/mm/aaaa-jj/mm/aaaa</i>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="agenda2_lieu">Lieu</label>
							</td>
							<td>
								<input type="text" name="agenda2_lieu" maxlength="255" style="width:500px;" value="<?php echo $row->agenda2_lieu; ?>" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="agenda2_image">Chemin image Babybook</label>
							</td>
							<td>
								<input type="text" name="agenda2_image" maxlength="255" style="width:500px;" value="<?php echo $row->agenda2_image; ?>" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="agenda2_intro">Intro</label>
							</td>
							<td>
								<textarea name="agenda2_intro" style="width:500px;height:75px;border:0;"><?php echo $row->agenda2_intro; ?></textarea>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="agenda2_lien">Lien</label>
							</td>
							<td>
								<input type="text" name="agenda2_lien" maxlength="255" style="width:500px;" value="<?php echo $row->agenda2_lien; ?>" />
							</td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Mots-cl&eacute;s</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td style="font-size:11px;">
								Voici la liste des mots-cl&eacute;s utilisables dans le texte du mail. Ceux-ci seront automatiquement remplac&eacute;s par les valeurs indiqu&eacute;es ci-dessous:<br />
								<br />
								<table class="table table-bordered table-striped table-condensed cf" cellpadding="0px" cellspacing="5px">
									<tr><td><b>{titre}</b></td><td>Titre de l'email.</td></tr>
									<tr><td><b>{username}</b></td><td>Pseudo du destinataire.</td></tr>
									<tr><td><b>{site_url}</b></td><td><?php echo SITE_URL; ?></td></tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</form>
			<script language="javascript" type="text/javascript">
				photoUpload('upload_news_publi','status_news_publi','files_news_publi', '', 'news_publi',1);
				photoUpload('upload_actu_ps','status_actu_ps','files_actu_ps', '', 'actu_ps',1);
			</script>
			<?php 		}
		
		
		public static function mailingSend(&$row, &$list) {
			global $user;
			
			?>

			<form name="adminForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<input type="hidden" name="id" id="id" value="<?php echo $row->id; ?>" />
				<input type="hidden" name="app" value="mailing_auto" />
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL_ADMIN; ?>" />
				<input type="hidden" name="envoiEnCours" id="envoiEnCours" value="0" />
				<input type="hidden" name="destinatairesNb" id="destinatairesNb" value="0" />
				<input type="hidden" name="hash" id="hash" value="<?php echo md5(date('yYy').$user->id.date('Yy')); ?>" />
				<input type="hidden" name="user_id" id="user_id" value="<?php echo $user->id; ?>" />
				
				<section class="panel">
                  <header class="panel-heading">
                       <h2>Mailing automatis&eacute;: Envoyer</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save">Sauver</a>
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing_auto" title="Fermer" class="cancel">Fermer</a>
					</div>
					</div>					
				</div>
				<br />
				<div class="tableAdmin">
					<h3><img src="<?php echo SITE_URL_ADMIN; ?>/images/loading.gif" id="loading" alt="" align="right" style="visibility:hidden;" />Recherche de destinataires</h3>
					<br />
					<table class="table table-bordered table-striped table-condensed cf editer" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td class="key">Pseudo</td>
							<td><input type="text" name="username" id="username" value="" onChange="javascript:rechercheDestinataires();" /></td>
						</tr>
						<tr>
							<td class="key">Email</td>
							<td><input type="text" name="email" id="email" value="" onChange="javascript:rechercheDestinataires();" /></td>
						</tr>
						<tr>
							<td class="key">Groupe</td>
							<td><?php echo $list['group_id']; ?></td>
						</tr>
						
					</table>
					<br />
					<br />
					<h3><img src="<?php echo SITE_URL_ADMIN; ?>/images/loading.gif" id="loading2" alt="" align="right" style="visibility:hidden;" />Envoi du mail</h3>
					<br />
					<table class="table table-bordered table-striped table-condensed cf editer" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td class="key">Nom:</td>
							<td><?php echo $row->nom; ?></td>
						</tr>
						<tr>
							<td class="key">Titre:</td>
							<td><?php echo $row->titre; ?></td>
						</tr>
						<tr>
							<td class="key">Template:</td>
							<td><?php echo $row->template; ?></td>
						</tr>
						<tr>
							<td class="key">Destinataires:</td>
							<td id="destinataires">0</td>
						</tr>
						<tr>
							<td class="key">Envoi:</td>
							<td>
								<div class="mailingProgressBar"><div id="mailingProgressBar"></div><span id="mailingAvancement">0%</span></div><a href="javascript:mailingEnvoi();" class="bouton envoyer" id="mailingEnvoyer" >Envoyer</a>
							</td>
						</tr>
					</table>
				</div>
				</section>
			</form>
			<script language="javascript" type="text/javascript">
				window.addEventListener('domready',function() {
					rechercheDestinataires();
				});
			</script>
			<?php 		}
		
		public static function mailingApercu($mailingTexte){
			echo $mailingTexte;
		}
	}
?>

<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class expert_HTML {	
		
		// liste les $contenus
		public static function lister(&$contenus, &$search, &$lists) {
			$rayon 			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
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
				<form name="listForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                    <h2>Experts</h2>		
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=expert&action=edit" title="R&eacute;diger une nouvelle annonce d'expert" class="btn btn-success">R&eacute;diger</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
					</div>
					</div>				
				</div>
				
				<div class="tableAdmin">
					<div class="filtre">
						<table class="table table-bordered table-striped ">
							<tr>
								<td><b>Recherche:</b></td>
								<td colspan="3"><input type="text" name="search_at_word" id="search_at_word" value="<? echo htmlentities($search['word']); ?>" class="searchInput" /></td>
							</tr>
							<td><b>Tri par:</b></td>
								<td><? echo $lists['order']; ?></td>
								<td><b>Statut:</b></td>
								<td><? echo $lists['active']; ?></td>

							</tr>
							<tr>
								<td><b>Ordre:</b></td>
								<td  colspan="3"><? echo $lists['ascdesc']; ?></td>
							</tr>
							<tr>
								<td colspan="4" align="right">
									<a href="javascript:document.listForm.submit();" class="bouton envoyer">Rechercher</a>
								</td>
							</tr>
						</table>
					</div>
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
						<? if(count($contenus)) { ?>
							<tr>
								<th>Expert</th>
								<th>Sp&eacute;cialit&eacute;</th>
								<th align="center">Activ&eacute;</th>
							</tr>
							<? 
							$i = 0;
							foreach($contenus as $contenu) { 
								JL::makeSafe($contenu);
								?>
								<tr class="list">
									<td><a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=expert&action=edit&id=<? echo $contenu->id; ?>" title="Modifier l'annonce de cet expert"><? echo $contenu->titre; ?></a></td>
									<td><? echo $contenu->specialite; ?></td>
									<td align="center"><img src="images/<? echo $contenu->active; ?>.png" /></td>
								</tr>
							<? 
							}
							?>
						<tr>
							<td colspan="4">
								<b>Pages</b>:
								<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=expert&search_at_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<? }?>
								<?
									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=expert&search_at_page='.$i); ?>" title="Afficher la page <? echo $i; ?>" <? if($i == $search['page']) { ?>style="font-weight:bold;"<? } ?>><? echo $i; ?></a>
									<?
									}
								?>
								<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=expert&search_at_page='.$search['page_total']); ?>" title="Afficher la page <? echo $search['page_total']; ?>">Fin</a><? }?> <i>(<? echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
					<?
						 } else { ?>
						<tr>
							<th>Aucun expert ne correspond &agrave; votre recherche.</th>
						</tr>
					<? } ?>
				</table>
			</div>
				<input type="hidden" name="search_at_page" value="1" />
				<input type="hidden" name="app" value="expert" />
				<input type="hidden" name="action" value="" />
				</section>
			</form>
			<?
		}
		
		// affiche un $contenu
		public static function editer(&$contenu, &$lists, &$messages) {
			
			JL::makeSafe($contenu, 'texte,introduction');
			
			// récup les miniatures de photos déjà envoyées
			$dir = $contenu->upload_dir;
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {

					// récup les miniatures de photos valides
					
					if(preg_match('/^expert/', $file)) {
						
						$photo		= $file;
						
					} elseif(preg_match('/^temp-expert/', $file)) {
					
						$photo	= $file;
						
					}
				
				}
				
			}
			
			include(SITE_PATH.'/fckeditor/fckeditor.php');
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
						
							document.location = "<? echo SITE_URL_ADMIN; ?>/index.php?app=expert"; 
						}
						
					}
			</script>
			<script type="text/javascript" src="<? echo SITE_URL; ?>/fckeditor/fckeditor.js"></script>
			
			<form name="editForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                     <h2>Expert: <? echo $contenu->id ? 'Editer' : 'Nouveau'; ?></h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="btn btn-success">Sauver</a>
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
					<h3>Expert</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key" align="top">Sp&eacute;cialit&eacute;</td>
							<td><input type="text" name="specialite" maxlength="255" size="100" class="inputtext" value="<? echo $contenu->specialite; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Titre:<br/><i>Pr&eacute;nom + nom<br />ou alias</i></td>
							<td><input type="text" name="titre" maxlength="255" size="100" class="inputtext" value="<? echo $contenu->titre; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Introduction:</td>
							<td>
							<?php
								
								$oFCKeditor = new FCKeditor('introduction', '400', '571px') ;
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
								
								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
								$oFCKeditor->ToolbarSet			= 'Basic';
								
								$oFCKeditor->Value = $contenu->introduction;
								$oFCKeditor->Create() ;
								
							?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="key">Texte:</td>
							<td>
							<?php
								
								$oFCKeditor = new FCKeditor('texte', '400', '571px') ;
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
								
								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
								$oFCKeditor->ToolbarSet			= 'Basic';
								
								$oFCKeditor->Value = $contenu->texte;
								$oFCKeditor->Create() ;
								
							?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="key" align="top">Email:</td>
							<td>
								<input type="text" name="email" maxlength="255" size="100" class="inputtext" value="<? echo $contenu->email; ?>" /><br />
								<i>L'adresse e-mail indiqu&eacute;e recevra les questions des membres.</i>
							</td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Photo</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Photo</td>
							<td id="miniatures">
								<div class="miniatures" id="miniaturesexpert">
								<?php
									if($photo) {
								?>
									<a href="index.php?app=redim&dossier=experts&action=edit&id=<? echo $contenu->id;?>&photo=<? echo $photo;?>">Redimensionner preview</a><br />
									<div id="<? echo $dir.'/'.$photo; ?>" class="miniature">
										<img src="<?php echo $dir.'/'.$photo; ?>" alt="" />
										<a href="javascript:deleteImage('<?php echo $dir.'/'.$photo; ?>', 'miniaturesexpert');" class="btnDelete">Supprimer</a>
									</div>
								<?
									}
								?>
								</div>
							</td>
						</tr>
						<tr>
							<td class="key">Envoyer Photo</td>
							<td>
								<div id="divFileProgressContainer"></div>
								<div class="swfu_btn"><span id="spanButtonPlaceholder"></span></div>
							</td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Publication</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Publi&eacute;:</td>
							<td><input type="radio" id="pu1" name="active" value="1" <? if($contenu->active) { ?>checked<? } ?> /> <label for="pu1">Oui</label>&nbsp;<input type="radio" id="pu0" name="active" value="0" <? if(!$contenu->active) { ?>checked<? } ?> /> <label for="pu0">Non</label></td>
						</tr>
					</table>
				</div>
				<input type="hidden" name="id" value="<? echo $contenu->id; ?>" />
				<input type="hidden" name="app" value="expert" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="upload_dir" id="upload_dir" value="<?php echo $contenu->upload_dir; ?>" />
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
				</section>
			</form>
			<script language="javascript" type="text/javascript">
				var expertPhotoUpload;
				function expertPhotoUploadInit() {
					expertPhotoUpload = new SWFUpload({
						upload_url: "<?php echo SITE_URL_ADMIN; ?>/js/swfupload/upload-expert.php",
						post_params: {"site_url": "<? echo SITE_URL; ?>","upload_dir": document.getElementById('upload_dir').value},
						file_size_limit : "2 MB",
						file_types : "*.jpg",
						file_types_description : "JPG",
						file_upload_limit : "0",
						file_queue_error_handler : fileQueueError,
						file_dialog_complete_handler : fileDialogComplete,
						upload_progress_handler : uploadProgress,
						upload_error_handler : uploadError,
						upload_success_handler : uploadSuccessExpert,
						upload_complete_handler : uploadComplete,
						button_image_url : "",
						button_placeholder_id : "spanButtonPlaceholder",
						button_width: 120,
						button_height: 40,
						button_text : '',
						button_text_style : '',
						button_text_top_padding: 0,
						button_text_left_padding: 18,
						button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
						button_cursor: SWFUpload.CURSOR.HAND,
						flash_url : "<?php echo SITE_URL_ADMIN; ?>/js/swfupload/swfupload.swf",
						custom_settings : {
							upload_target : "divFileProgressContainer"
						},
						debug: false
					});
				};
				expertPhotoUploadInit();
			</script>
			<?
		}
		
	}
?>

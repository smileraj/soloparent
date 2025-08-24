<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class box_HTML {	
		
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
                     	<h2>Boxs</h2>	
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=box&action=edit" title="R&eacute;diger une nouvelle actualit&eacute;" class="btn btn-success">R&eacute;diger</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
					</div>
					</div>			
				</div>
				<div class="tableAdmin">
					<div class="filtre">
						<table class="table table-bordered table-striped table-condensed cf">
							<tr>
								<td><b>Recherche:</b></td>
								<td colspan="2"><input type="text" name="search_at_word" id="search_at_word" value="<? echo htmlentities($search['word']); ?>" class="searchInput" /></td>
							</tr>
							<tr>
								<td><b>Emplacement:</b></td>
								<td><? echo $lists['emplacement_id']?></td>
								<td><a href="javascript:document.listForm.submit();" class="bouton envoyer" />Rechercher</a></td>
							</tr>
						</table>
					</div>
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
						<? if(count($contenus)) { ?>
							<tr>
								<th>Description</th>
								<th align="center">Publi&eacute;</th>
								<th>Emplacement</th>
							</tr>
							<? 
							$i = 0;
							foreach($contenus as $contenu) { 
								JL::makeSafe($contenu);
								?>
								<tr class="list">
									<td><a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=box&action=edit&id=<? echo $contenu->id; ?>" title="Modifier cette actualit&eacute;"><? echo $contenu->description; ?></a></td>
									<td align="center"><img src="images/<? echo $contenu->published; ?>.png" /></td>
									<td><? echo $contenu->nom; ?></td>
								</tr>
							<? 
							}
							?>
						<tr>
							<td colspan="4">
								<b>Pages</b>:
								<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=box&search_at_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<? }?>
								<?
									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=box&search_at_page='.$i); ?>" title="Afficher la page <? echo $i; ?>" <? if($i == $search['page']) { ?>style="font-weight:bold;"<? } ?>><? echo $i; ?></a>
									<?
									}
								?>
								<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=box&search_at_page='.$search['page_total']); ?>" title="Afficher la page <? echo $search['page_total']; ?>">Fin</a><? }?> <i>(<? echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
					<?
						 } else { ?>
						<tr>
							<th>Aucune box ne correspond &agrave; votre recherche.</th>
						</tr>
					<? } ?>
				</table>
			</div>
				<input type="hidden" name="search_at_page" value="1" />
				<input type="hidden" name="app" value="box" />
				<input type="hidden" name="action" value="" />
				</section>
			</form>
			<?
		}
		
		// affiche un $contenu
		public static function editer(&$contenu, &$lists, &$messages) {
			
			JL::makeSafe($contenu, 'texte_fr,texte_de,texte_en');
			
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
						
							document.location = "<? echo SITE_URL_ADMIN; ?>/index.php?app=box"; 
						}
						
					}
			</script>
			<script type="text/javascript" src="<? echo SITE_URL; ?>/fckeditor/fckeditor.js"></script>
			
			<form name="editForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                     <h2>Box: <? echo $contenu->id ? 'Editer' : 'Nouveau'; ?></h2>
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
					<h3>Information</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Description:</td>
							<td><input type="text" name="description" maxlength="255" size="100" class="inputtext" value="<? echo $contenu->description; ?>" /></td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Contenu <img width="20px;" src="<? echo SITE_URL; ?>/parentsolo/images/grph_flags_fr_h20.jpg" alt="fr"></h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Titre:</td>
							<td><input type="text" name="titre_fr" maxlength="255" size="100" class="inputtext" value="<? echo $contenu->titre_fr; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Texte:</td>
							<td>
							<?php
								
								$oFCKeditor = new FCKeditor('texte_fr', '400', '571px') ;
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
								
								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
								$oFCKeditor->ToolbarSet			= 'Basic';
								
								$oFCKeditor->Value = $contenu->texte_fr;
								$oFCKeditor->Create() ;
								
							?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="key" align="top">Adresse URL:</td>
							<td>
								<input type="text" name="url_fr" maxlength="255" size="100" class="inputtext" value="<? echo $contenu->url_fr; ?>" /><br />
								<i>Le lien que vous allez indiquer doit commencer par "http://"</i>
							</td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Contenu <img width="20px;" src="<? echo SITE_URL; ?>/parentsolo/images/grph_flags_de_h20.jpg" alt="de"></h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						
						<tr>
							<td class="key">Titre:</td>
							<td><input type="text" name="titre_de" maxlength="255" size="100" class="inputtext" value="<? echo $contenu->titre_de; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Texte:</td>
							<td>
							<?php
								
								$oFCKeditor = new FCKeditor('texte_de', '400', '571px') ;
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
								
								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
								$oFCKeditor->ToolbarSet			= 'Basic';
								
								$oFCKeditor->Value = $contenu->texte_de;
								$oFCKeditor->Create() ;
								
							?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="key" align="top">Adresse URL:</td>
							<td>
								<input type="text" name="url_de" maxlength="255" size="100" class="inputtext" value="<? echo $contenu->url_de; ?>" /><br />
								<i>Le lien que vous allez indiquer doit commencer par "http://"</i>
							</td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Contenu <img width="20px;" src="<? echo SITE_URL; ?>/parentsolo/images/grph_flags_en_h20.jpg" alt="en"></h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Titre:</td>
							<td><input type="text" name="titre_en" maxlength="255" size="100" class="inputtext" value="<? echo $contenu->titre_en; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Texte:</td>
							<td>
							<?php
								
								$oFCKeditor = new FCKeditor('texte_en', '400', '571px') ;
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
								
								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
								$oFCKeditor->ToolbarSet			= 'Basic';
								
								$oFCKeditor->Value = $contenu->texte_en;
								$oFCKeditor->Create() ;
								
							?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td class="key" align="top">Adresse URL:</td>
							<td>
								<input type="text" name="url_en" maxlength="255" size="100" class="inputtext" value="<? echo $contenu->url_en; ?>" /><br />
								<i>Le lien que vous allez indiquer doit commencer par "http://"</i>
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
							<td class="key">Emplacement:</td>
							<td><? echo $lists['emplacement_id']?></td>
						</tr>
						<tr>
							<td class="key">Publi&eacute;:</td>
							<td><input type="radio" id="pu1" name="published" value="1" <? if($contenu->published) { ?>checked<? } ?> /> <label for="pu1">Oui</label>&nbsp;<input type="radio" id="pu0" name="published" value="0" <? if(!$contenu->published) { ?>checked<? } ?> /> <label for="pu0">Non</label></td>
						</tr>
						<tr>
							<td></td>
						<td>
							<i>Cr&eacute;&eacute; le <? echo date('d/m/Y', strtotime($contenu->date_add)); ?> par <a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=user&action=editer&id=<? echo $contenu->user_id_add; ?>" target="_blank"><? echo $contenu->user_name_add; ?></a></i>
						</td>
					</tr>
					<? if($contenu->user_id_update) { ?>
					<tr>
						<td></td>
						<td>
							<i>Mis &agrave; jour le <? echo date('d/m/Y', strtotime($contenu->date_update)); ?> par <a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=user&action=editer&id=<? echo $contenu->user_id_update; ?>" target="_blank"><? echo $contenu->user_name_update; ?></a></i>
						</td>
					</tr>
					<?
					}
					?>
				</table>
				</div>
				<input type="hidden" name="id" value="<? echo $contenu->id; ?>" />
				<input type="hidden" name="app" value="box" />
				<input type="hidden" name="action" value="save" />
				</section>
			</form>
			<?
		}
		
	}
?>

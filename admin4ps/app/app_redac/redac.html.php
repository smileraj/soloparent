<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class redac_HTML {	
		
		// liste les $contenus
		public static function lister(&$contenus, $type_id, $lang) {
			
			?>
				<div class="titlebar app_redac">
					<div class="toolbar">
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=redac&action=edit&type_id=<? echo $type_id; ?><? if($lang!='') echo '&lang='.$lang; ?>" title="R&eacute;diger un nouvel article">R&eacute;diger</a>
						<a href="<? echo SITE_URL_ADMIN; ?>" title="Fermer">Fermer</a>
					</div>
					
					<?
						switch($type_id) {
							
							case 1:
								echo 'Actualit&eacute;s';
							break;
							
							case 2:
								echo 'Pages fixes';
							break;
							
							default:
								echo 'Contenu r&eacute;dactionnel';
							break;
							
						}
					?>
					
				</div>
				
				<? if(count($contenus)) { ?>
				<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
					<tr>
						<th>Titre</th>
						<th align="center">Publi&eacute;</th>
						<th>Date d'ajout</th>
						<th>Date de mise &agrave; jour</th>
						<? if($type_id == 2) { ?><th align="center">Footer</th><? } ?>
					</tr>
					<? 
					$i = 0;
					foreach($contenus as $contenu) { 
						JL::makeSafe($contenu);
						?>
						<tr class="tr<? echo $i; ?>">
							<td><a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=redac&action=edit&id=<? echo $contenu->id; ?><? if($lang!='') echo '&lang='.$lang; ?>" title="Modifier ce contenu"><? echo $contenu->titre; ?></a></td>
							<td align="center"><img src="images/<? echo $contenu->published; ?>.png" /></td>
							<td><? echo date('d/m/Y', strtotime($contenu->date_add)); ?></td>
							<td><? echo $contenu->date_update != '0000-00-00 00:00:00' ? date('d/m/Y', strtotime($contenu->date_update)) : ''; ?></td>
							<? if($type_id == 2) { ?><td align="center"><img src="images/<? echo $contenu->footer; ?>.png" /></td><? } ?>
						</tr>
						<? 
						$i = 1 - $i;
					} ?>
				</table>
				<? } else { ?>
					Aucun contenu r&eacute;dactionnel ne correspond &agrave; votre recherche.
				<? } ?>
			<?
		}
		
		// affiche un $contenu
		public static function editer(&$contenu, &$messages) {
			
			JL::makeSafe($contenu, 'texte');
			
			include(SITE_PATH.'/fckeditor/fckeditor.php');
			?>
			<script type="text/javascript" src="<? echo SITE_URL; ?>/fckeditor/fckeditor.js"></script>
			
			<form name="editForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				
				<div class="titlebar app_redac">
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save">Sauver</a>
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=redac&type_id=<? echo $contenu->type_id; ?><? if($contenu->lang!='') echo '&lang='.$contenu->lang; ?>" title="Annuler" class="cancel">Annuler</a>
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=redac&type_id=<? echo $contenu->type_id; ?><? if($contenu->lang!='') echo '&lang='.$contenu->lang; ?>" title="Fermer" class="cancel">Fermer</a>
					</div>
					
					Contenu: <? echo $contenu->id ? 'Editer' : 'Nouveau'; ?>
				</div>
				
				<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
					<? if(count($messages)) { ?>
					<tr>
						<td class="key"></td>
						<td>
							<div class="messages">
								<? JL::messages($messages); ?>
							</div>
						</td>
					</tr>
					<? } ?>
					<tr>
						<td class="key">Titre:</td>
						<td><input type="text" name="titre" maxlength="255" size="100" class="inputtext" value="<? echo $contenu->titre; ?>" /></td>
					</tr>
					<tr>
						<td class="key">Texte:</td>
						<td>
						<?php
							
							$oFCKeditor = new FCKeditor('FCKeditor1') ;
							$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
							
							$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
							$oFCKeditor->ToolbarSet			= 'Basic';
							
							$oFCKeditor->Value = $contenu->texte;
							$oFCKeditor->Create() ;
							
						?>
						</td>
					</tr>
					<? if($contenu->type_id == 2) { ?>
					<tr>
						<td class="key">Footer:</td>
						<td><input type="radio" id="fo1" name="footer" value="1" <? if($contenu->footer) { ?>checked<? } ?> /> <label for="fo1">Oui</label>&nbsp;<input type="radio" id="fo0" name="footer" value="0" <? if(!$contenu->footer) { ?>checked<? } ?> /> <label for="fo0">Non</label></td>
					</tr>
					<? } else { ?>
						<input type="hidden" name="footer" value="0" />
					<? } ?>
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
				
				<input type="hidden" name="id" value="<? echo $contenu->id; ?>" />
				<input type="hidden" name="type_id" value="<? echo $contenu->type_id; ?>" />
				<input type="hidden" name="date_add" value="<? echo $contenu->date_add; ?>" />
				<input type="hidden" name="user_id_add" value="<? echo $contenu->user_id_add; ?>" />
				<input type="hidden" name="date_update" value="<? echo $contenu->date_update; ?>" />
				<input type="hidden" name="user_id_update" value="<? echo $contenu->user_id_add; ?>" />
				<input type="hidden" name="lang" value="<? echo $contenu->lang; ?>" />
				<input type="hidden" name="app" value="redac" />
				<input type="hidden" name="action" value="save" />
			</form>
			<?
		}
		
	}
?>

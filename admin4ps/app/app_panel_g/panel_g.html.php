<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class panel_g_HTML {	
		
		// liste les $contenus
		public static function lister(&$contenus, $lang) {
			
			?>
				<div class="titlebar app_redac">
					<div class="toolbar">
						<a href="<? echo SITE_URL_ADMIN; ?>" title="Fermer">Fermer</a>
					</div>
				</div>
				
				<? if(count($contenus)) { ?>
				<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
					<tr>
						<th>Titre</th>
					</tr>
					<? 
					$i = 0;
					foreach($contenus as $contenu) { 
						JL::makeSafe($contenu);
						?>
						<tr class="tr<? echo $i; ?>">
							<td><a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=panel_g&action=edit&id=<? echo $contenu->id; ?>&lang=<? echo $lang; ?>" title="Modifier ce contenu"><? echo $contenu->titre; ?></a></td>
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
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=panel_g&lang=<? echo $contenu->lang; ?>" title="Fermer" class="cancel">Fermer</a>
					</div>
					
					Contenu: Editer
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
				</table>
				
				<input type="hidden" name="id" value="<? echo $contenu->id; ?>" />
				<input type="hidden" name="lang" value="<? echo $contenu->lang; ?>" />
				<input type="hidden" name="app" value="panel_g" />
				<input type="hidden" name="action" value="save" />
			</form>
			<?
		}
		
	}
?>

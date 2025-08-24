<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class home_HTML {	
		
		// liste les $contenus
		public static function lister(&$contenus, $lang) {
			
			?>
				<section class="panel">
                  <header class="panel-heading">
                     <h2>Evolution des abonnements par an</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						
						<a href="<? echo SITE_URL_ADMIN; ?>" title="Fermer">Fermer</a>
					</div>
				</div>
				  </div>
				
				
				<? if(count($contenus)) { ?>
				<table cellpadding="0" cellspacing="0" class="lister">
					<tr>
						<th>Description</th>
						<th>Titre</th>
					</tr>
					<? 
					$i = 0;
					foreach($contenus as $contenu) { 
						JL::makeSafe($contenu);
						?>
						<tr class="tr<? echo $i; ?>">
							<td><a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=home&action=edit&id=<? echo $contenu->id; ?>&lang=<? echo $lang; ?>" title="Modifier ce contenu"><? echo $contenu->description; ?></a></td>
							<td><? echo $contenu->titre; ?></td>
						</tr>
						<? 
						$i = 1 - $i;
					} ?>
				</table>
				</section>
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
				<section class="panel">
                  <header class="panel-heading">
                     <h2>Contenu: Editer</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
				
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save">Sauver</a>
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=home&lang=<? echo $contenu->lang; ?>" title="Fermer" class="cancel">Fermer</a>
					</div>
						</div>
					
				</div>
				
				<table cellpadding="0" cellspacing="0" class="editer">
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
						<td class="key">Description:</td>
						<td><? echo $contenu->description; ?></td>
					</tr>
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
				<input type="hidden" name="app" value="home" />
				<input type="hidden" name="action" value="save" />
				</section>
			</form>
			<?
		}
		
	}
?>

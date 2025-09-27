<?php

	// s�curit�
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
						
						<a href="<?php echo SITE_URL_ADMIN; ?>" title="Fermer">Fermer</a>
					</div>
				</div>
				  </div>
				
				
				<?php if (is_array($contenus)) { ?>
				<table cellpadding="0" cellspacing="0" class="lister">
					<tr>
						<th>Description</th>
						<th>Titre</th>
					</tr>
					<?php 
					$i = 0;
					foreach($contenus as $contenu) { 
						JL::makeSafe($contenu);
						?>
						<tr class="tr<?php echo $i; ?>">
							<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=home&action=edit&id=<?php echo $contenu->id; ?>&lang=<?php echo $lang; ?>" title="Modifier ce contenu"><?php echo $contenu->description; ?></a></td>
							<td><?php echo $contenu->titre; ?></td>
						</tr>
						<?php 
						$i = 1 - $i;
					} ?>
				</table>
				</section>
				<?php } else { ?>
					Aucun contenu r&eacute;dactionnel ne correspond &agrave; votre recherche.
				<?php } ?>
			<?php 		}
		
		// affiche un $contenu
		public static function editer(&$contenu, &$messages) {
			
			JL::makeSafe($contenu, 'texte');
			
			include(SITE_PATH.'/fckeditor/fckeditor.php');
			?>
			<script type="text/javascript" src="<?php echo SITE_URL; ?>/fckeditor/fckeditor.js"></script>
			
			<form name="editForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                     <h2>Contenu: Editer</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
				
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save">Sauver</a>
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=home&lang=<?php echo $contenu->lang; ?>" title="Fermer" class="cancel">Fermer</a>
					</div>
						</div>
					
				</div>
				
				<table cellpadding="0" cellspacing="0" class="editer">
					<?php if (is_array($messages)) { ?>
					<tr>
						<td class="key"></td>
						<td>
							<div class="messages">
								<?php JL::messages($messages); ?>
							</div>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<td class="key">Description:</td>
						<td><?php echo $contenu->description; ?></td>
					</tr>
					<tr>
						<td class="key">Titre:</td>
						<td><input type="text" name="titre" maxlength="255" size="100" class="inputtext" value="<?php echo $contenu->titre; ?>" /></td>
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
				
				<input type="hidden" name="id" value="<?php echo $contenu->id; ?>" />
				<input type="hidden" name="lang" value="<?php echo $contenu->lang; ?>" />
				<input type="hidden" name="app" value="home" />
				<input type="hidden" name="action" value="save" />
				</section>
			</form>
			<?php 		}
		
	}
?>

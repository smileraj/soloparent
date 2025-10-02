<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class redac_HTML {	
		
		// liste les $contenus
		public static function lister(&$contenus, $type_id, $lang) {
			
			?>
				<div class="titlebar app_redac">
					<div class="toolbar">
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=redac&action=edit&type_id=<?php echo $type_id; ?><?php if($lang!='') echo '&lang='.$lang; ?>" title="R&eacute;diger un nouvel article">R&eacute;diger</a>
						<a href="<?php echo SITE_URL_ADMIN; ?>" title="Fermer">Fermer</a>
					</div>
					
					<?php 						switch($type_id) {
							
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
				
				<?php if (is_array($contenus)) { ?>
				<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
					<tr>
						<th>Titre</th>
						<th align="center">Publi&eacute;</th>
						<th>Date d'ajout</th>
						<th>Date de mise &agrave; jour</th>
						<?php if($type_id == 2) { ?><th align="center">Footer</th><?php } ?>
					</tr>
					<?php 
					$i = 0;
					foreach($contenus as $contenu) { 
						JL::makeSafe($contenu);
						?>
						<tr class="tr<?php echo $i; ?>">
							<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=redac&action=edit&id=<?php echo $contenu->id; ?><?php if($lang!='') echo '&lang='.$lang; ?>" title="Modifier ce contenu"><?php echo $contenu->titre; ?></a></td>
							<td align="center"><img src="images/<?php echo $contenu->published; ?>.png" /></td>
							<td><?php echo date('d/m/Y', strtotime((string) $contenu->date_add)); ?></td>
							<td><?php echo $contenu->date_update != '1970-01-01 00:00:00' ? date('d/m/Y', strtotime((string) $contenu->date_update)) : ''; ?></td>
							<?php if($type_id == 2) { ?><td align="center"><img src="images/<?php echo $contenu->footer; ?>.png" /></td><?php } ?>
						</tr>
						<?php 
						$i = 1 - $i;
					} ?>
				</table>
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
				
				<div class="titlebar app_redac">
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save">Sauver</a>
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=redac&type_id=<?php echo $contenu->type_id; ?><?php if($contenu->lang!='') echo '&lang='.$contenu->lang; ?>" title="Annuler" class="cancel">Annuler</a>
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=redac&type_id=<?php echo $contenu->type_id; ?><?php if($contenu->lang!='') echo '&lang='.$contenu->lang; ?>" title="Fermer" class="cancel">Fermer</a>
					</div>
					
					Contenu: <?php echo $contenu->id ? 'Editer' : 'Nouveau'; ?>
				</div>
				
				<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
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
					<?php if($contenu->type_id == 2) { ?>
					<tr>
						<td class="key">Footer:</td>
						<td><input type="radio" id="fo1" name="footer" value="1" <?php if($contenu->footer) { ?>checked<?php } ?> /> <label for="fo1">Oui</label>&nbsp;<input type="radio" id="fo0" name="footer" value="0" <?php if(!$contenu->footer) { ?>checked<?php } ?> /> <label for="fo0">Non</label></td>
					</tr>
					<?php } else { ?>
						<input type="hidden" name="footer" value="0" />
					<?php } ?>
					<tr>
						<td class="key">Publi&eacute;:</td>
						<td><input type="radio" id="pu1" name="published" value="1" <?php if($contenu->published) { ?>checked<?php } ?> /> <label for="pu1">Oui</label>&nbsp;<input type="radio" id="pu0" name="published" value="0" <?php if(!$contenu->published) { ?>checked<?php } ?> /> <label for="pu0">Non</label></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<i>Cr&eacute;&eacute; le <?php echo date('d/m/Y', strtotime((string) $contenu->date_add)); ?> par <a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=user&action=editer&id=<?php echo $contenu->user_id_add; ?>" target="_blank"><?php echo $contenu->user_name_add; ?></a></i>
						</td>
					</tr>
					<?php if($contenu->user_id_update) { ?>
					<tr>
						<td></td>
						<td>
							<i>Mis &agrave; jour le <?php echo date('d/m/Y', strtotime((string) $contenu->date_update)); ?> par <a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=user&action=editer&id=<?php echo $contenu->user_id_update; ?>" target="_blank"><?php echo $contenu->user_name_update; ?></a></i>
						</td>
					</tr>
					<?php 					}
					?>
				</table>
				
				<input type="hidden" name="id" value="<?php echo $contenu->id; ?>" />
				<input type="hidden" name="type_id" value="<?php echo $contenu->type_id; ?>" />
				<input type="hidden" name="date_add" value="<?php echo $contenu->date_add; ?>" />
				<input type="hidden" name="user_id_add" value="<?php echo $contenu->user_id_add; ?>" />
				<input type="hidden" name="date_update" value="<?php echo $contenu->date_update; ?>" />
				<input type="hidden" name="user_id_update" value="<?php echo $contenu->user_id_add; ?>" />
				<input type="hidden" name="lang" value="<?php echo $contenu->lang; ?>" />
				<input type="hidden" name="app" value="redac" />
				<input type="hidden" name="action" value="save" />
			</form>
			<?php 		}
		
	}
?>

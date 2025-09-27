<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class HTML_mailing2 {	
		
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
							if(!confirm('Voulez-vous vraiment supprimer les mailings s�lectionn�s ?')) {
								ok = false;
							}
						}
						
						if(ok) {
							form.action.value = action;
							form.submit();
						}
						
					}
				</script>
				
				<form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                     <h2>Mailing</h2>
                 </header>
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing2&action=edit" title="R&eacute;diger un nouveau mailing">Nouveau</a>
						<a href="<?php echo SITE_URL_ADMIN; ?>" title="Fermer">Fermer</a>
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
									<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing2&action=edit&id=<?php echo $row->id; ?>" title="Modifier le mailing"><?php echo $row->nom; ?></a>
								</td>
								<td><?php echo date('d/m/Y � H:i:s', strtotime($row->datetime_update)); ?></td>
								<td align="center">
									<a href="<?php echo JL::url('index.php?app=mailing2&action=envoyer&id='.$row->id); ?>" title="Envoyer ce mailing"><img src="<?php echo SITE_URL_ADMIN; ?>/images/mailing.png" alt="" />
								</td>
							</tr>
							<?php 						}
						?>
					
						<tr>
							<td colspan="<?php echo $tdParTr; ?>">
								<b>Pages</b>:
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=mailing2&search_at_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=mailing2&search_at_page='.$i); ?>" title="Afficher la page <?php echo $i; ?>" <?php if($i == $search['page']) { ?>class="displayActive"<?php } ?>><?php echo $i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=mailing2&search_at_page='.$search['page_total']); ?>" title="Afficher la page <?php echo $search['page_total']; ?>">Fin</a><?php }?> <i>(<?php echo $search['result_total']; ?> r&eacute;sultats)</i>
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
					<input type="hidden" name="app" value="mailing2" />
					<input type="hidden" name="action" value="" />
				</section>
				</form>
			<?php 		}
		
		
		public static function mailingEdit(&$row, &$list, &$messages) {
			
			JL::makeSafe($mailing, 'texte');
			
			include(SITE_PATH.'/fckeditor/fckeditor.php');
			?>
			<script type="text/javascript" src="<?php echo SITE_URL; ?>/fckeditor/fckeditor.js"></script>
			
			<form name="editForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                    <h2>Mailing: <?php echo $row->id ? 'Editer' : 'Nouveau'; ?></h2>
                 </header>
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
					<?php if($row->id){?><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing2&action=apercu&id=<?php echo $row->id; ?>" target="_blank" title="Apercu" class="">Aper&ccedil;u</a><?php } ?>
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save">Sauver</a>
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing2" title="Annuler" class="cancel">Annuler</a>
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing2" title="Fermer" class="cancel">Fermer</a>
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
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						
						
						<tr>
							<td class="key"><label for="nom">Nom:</label></td>
							<td><input type="text" name="nom" id="nom" value="<?php echo $row->nom; ?>" style="width:500px;" /></td>
						</tr>
						<tr>
							<td class="key">
								<label for="commentaire">Commentaire:</label>
							</td>
							<td>
								<textarea name="commentaire" style="width:500px;height:75px;border:0;"><?php echo $row->commentaire; ?></textarea>
							</td>
						</tr>
						<?php if(isset($row->datetime_update)) { ?>
						<tr>
							<td class="key">Mise &agrave; jour:</td>
							<td><?php echo date('d/m/Y � H:i:s', strtotime($row->datetime_update)); ?></td>
						</tr>
						<?php } ?>
						
						<tr>
							<td class="key"><label for="template">Template:</label></td>
							<td><?php echo $list['template']; ?></td>
						</tr>
						<tr>
							<td class="key">Titre:</td>
							<td><input type="text" name="titre" maxlength="255" style="width:500px;" value="<?php echo $row->titre; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Texte:</td>
							<td>
							<?php
								
								$oFCKeditor = new FCKeditor('texte', '400', '571px');
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
								
								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
								$oFCKeditor->ToolbarSet			= 'Basic';
								
								$oFCKeditor->Value = $row->texte;
								$oFCKeditor->Create() ;
								
							?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="texte">Mots-cl&eacute;s:</label>
							</td>
							<td style="font-size:11px;">
								Voici la liste des mots-cl&eacute;s utilisables dans le texte du mail. Ceux-ci seront automatiquement remplac&eacute;s par les valeurs indiqu&eacute;es ci-dessous:<br />
								<br />
								<table cellpadding="0px" cellspacing="5px">
									<tr><td><b>{titre}</b></td><td>Titre de l'email.</td></tr>
									<tr><td><b>{username}</b></td><td>Pseudo du destinataire.</td></tr>
									<tr><td><b>{site_url}</b></td><td><?php echo SITE_URL; ?></td></tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
				<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
				<input type="hidden" name="app" value="mailing2" />
				<input type="hidden" name="action" value="save" />
				</section>
			</form>
			<?php 		}
		
		
		public static function mailingSend(&$row) {
			global $user;
			
			?>
			<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/mootools-back.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_mailing2.js"></script>

			<form name="adminForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<input type="hidden" name="id" id="id" value="<?php echo $row->id; ?>" />
				<input type="hidden" name="app" value="mailing2" />
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL_ADMIN; ?>" />
				<input type="hidden" name="envoiEnCours" id="envoiEnCours" value="0" />
				<input type="hidden" name="destinatairesNb" id="destinatairesNb" value="0" />
				<input type="hidden" name="hash" id="hash" value="<?php echo md5(date('yYy').$user->id.date('Yy')); ?>" />
				<input type="hidden" name="user_id" id="user_id" value="<?php echo $user->id; ?>" />
				<section class="panel">
                  <header class="panel-heading">
                 	<h2>Mailing: Envoyer</h2>
                 </header>
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save">Sauver</a>
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing2" title="Annuler" class="cancel">Annuler</a>
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing2" title="Fermer" class="cancel">Fermer</a>
					</div>
				  </div>
				</div>
			
				<div class="tableAdmin">
					<h3><img src="<?php echo SITE_URL_ADMIN; ?>/images/loading.gif" id="loading" alt="" align="right" style="visibility:hidden;" />Recherche de destinataires</h3>
					<br />
					<table class="editer" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td class="key">Pseudo</td>
							<td><input type="text" name="username" id="username" value="" onChange="javascript:rechercheDestinataires();" /></td>
						</tr>
						<tr>
							<td class="key">Email</td>
							<td><input type="text" name="email" id="email" value="" onChange="javascript:rechercheDestinataires();" /></td>
						</tr>
						
					</table>
					<br />
					<br />
					<h3><img src="<?php echo SITE_URL_ADMIN; ?>/images/loading.gif" id="loading2" alt="" align="right" style="visibility:hidden;" />Envoi du mail</h3>
					<br />
					<table class="editer" cellpadding="0" cellspacing="0" border="0">
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
		
		public static function mailingApercu($mailing){
			$mailingTexte 	= JL::getMailHtml(SITE_PATH_ADMIN.'/app/app_mailing2/template/'.$mailing->template, $mailing->titre, $mailing->texte, $user->username);
			echo $mailingTexte;
		}
	}
?>

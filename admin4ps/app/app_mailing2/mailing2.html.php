<?php

	// sécurité
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
							if(!confirm('Voulez-vous vraiment supprimer les mailings sélectionnés ?')) {
								ok = false;
							}
						}
						
						if(ok) {
							form.action.value = action;
							form.submit();
						}
						
					}
				</script>
				
				<form name="listForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                     <h2>Mailing</h2>
                 </header>
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=mailing2&action=edit" title="R&eacute;diger un nouveau mailing">Nouveau</a>
						<a href="<? echo SITE_URL_ADMIN; ?>" title="Fermer">Fermer</a>
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
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
					
						
						
						<? if(count($rows)) { ?>
						<tr>
							<th width="20px"></th>
							<th align="left">Nom</th>
							<th style="width: 150px;">Mise &agrave; jour</th>
							<th style="width: 80px;text-align:center;">Envoyer</th>
						</tr>
						<?
						foreach($rows as $row) {
						
							// htmlentities
							JL::makeSafe($row);
							
							?>
							<tr class="list">
								<td align="center"><input type="checkbox" name="id[]" value="<? echo $row->id; ?>" id="mailing_<? echo $row->id; ?>"></td>
								<td>
									<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=mailing2&action=edit&id=<? echo $row->id; ?>" title="Modifier le mailing"><? echo $row->nom; ?></a>
								</td>
								<td><? echo date('d/m/Y à H:i:s', strtotime($row->datetime_update)); ?></td>
								<td align="center">
									<a href="<? echo JL::url('index.php?app=mailing2&action=envoyer&id='.$row->id); ?>" title="Envoyer ce mailing"><img src="<? echo SITE_URL_ADMIN; ?>/images/mailing.png" alt="" />
								</td>
							</tr>
							<?
						}
						?>
					
						<tr>
							<td colspan="<? echo $tdParTr; ?>">
								<b>Pages</b>:
								<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=mailing2&search_at_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<? }?>
								<?
									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=mailing2&search_at_page='.$i); ?>" title="Afficher la page <? echo $i; ?>" <? if($i == $search['page']) { ?>class="displayActive"<? } ?>><? echo $i; ?></a>
									<?
									}
								?>
								<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=mailing2&search_at_page='.$search['page_total']); ?>" title="Afficher la page <? echo $search['page_total']; ?>">Fin</a><? }?> <i>(<? echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
					<? } else { ?>
						<tr>
							<th colspan="<? echo $tdParTr; ?>">Aucun mailing n'a &eacute;t&eacute; r&eacute;dig&eacute;.</th>
						</tr>
					<? } ?>
					</table>
					</div>
					<input type="hidden" name="search_at_page" value="1" />
					<input type="hidden" name="app" value="mailing2" />
					<input type="hidden" name="action" value="" />
				</section>
				</form>
			<?
		}
		
		
		public static function mailingEdit(&$row, &$list, &$messages) {
			
			JL::makeSafe($mailing, 'texte');
			
			include(SITE_PATH.'/fckeditor/fckeditor.php');
			?>
			<script type="text/javascript" src="<? echo SITE_URL; ?>/fckeditor/fckeditor.js"></script>
			
			<form name="editForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                    <h2>Mailing: <? echo $row->id ? 'Editer' : 'Nouveau'; ?></h2>
                 </header>
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
					<? if($row->id){?><a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=mailing2&action=apercu&id=<? echo $row->id; ?>" target="_blank" title="Apercu" class="">Aper&ccedil;u</a><? } ?>
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save">Sauver</a>
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=mailing2" title="Annuler" class="cancel">Annuler</a>
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=mailing2" title="Fermer" class="cancel">Fermer</a>
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
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						
						
						<tr>
							<td class="key"><label for="nom">Nom:</label></td>
							<td><input type="text" name="nom" id="nom" value="<? echo $row->nom; ?>" style="width:500px;" /></td>
						</tr>
						<tr>
							<td class="key">
								<label for="commentaire">Commentaire:</label>
							</td>
							<td>
								<textarea name="commentaire" style="width:500px;height:75px;border:0;"><? echo $row->commentaire; ?></textarea>
							</td>
						</tr>
						<? if(isset($row->datetime_update)) { ?>
						<tr>
							<td class="key">Mise &agrave; jour:</td>
							<td><? echo date('d/m/Y à H:i:s', strtotime($row->datetime_update)); ?></td>
						</tr>
						<? } ?>
						
						<tr>
							<td class="key"><label for="template">Template:</label></td>
							<td><? echo $list['template']; ?></td>
						</tr>
						<tr>
							<td class="key">Titre:</td>
							<td><input type="text" name="titre" maxlength="255" style="width:500px;" value="<? echo $row->titre; ?>" /></td>
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
									<tr><td><b>{site_url}</b></td><td><? echo SITE_URL; ?></td></tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
				<input type="hidden" name="id" value="<? echo $row->id; ?>" />
				<input type="hidden" name="app" value="mailing2" />
				<input type="hidden" name="action" value="save" />
				</section>
			</form>
			<?
		}
		
		
		public static function mailingSend(&$row) {
			global $user;
			
			?>
			<script type="text/javascript" src="<? echo SITE_URL; ?>/js/mootools-back.js"></script>
			<script type="text/javascript" src="<? echo SITE_URL; ?>/js/app_mailing2.js"></script>

			<form name="adminForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<input type="hidden" name="id" id="id" value="<? echo $row->id; ?>" />
				<input type="hidden" name="app" value="mailing2" />
				<input type="hidden" name="site_url" id="site_url" value="<? echo SITE_URL_ADMIN; ?>" />
				<input type="hidden" name="envoiEnCours" id="envoiEnCours" value="0" />
				<input type="hidden" name="destinatairesNb" id="destinatairesNb" value="0" />
				<input type="hidden" name="hash" id="hash" value="<? echo md5(date('yYy').$user->id.date('Yy')); ?>" />
				<input type="hidden" name="user_id" id="user_id" value="<? echo $user->id; ?>" />
				<section class="panel">
                  <header class="panel-heading">
                 	<h2>Mailing: Envoyer</h2>
                 </header>
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save">Sauver</a>
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=mailing2" title="Annuler" class="cancel">Annuler</a>
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=mailing2" title="Fermer" class="cancel">Fermer</a>
					</div>
				  </div>
				</div>
			
				<div class="tableAdmin">
					<h3><img src="<? echo SITE_URL_ADMIN; ?>/images/loading.gif" id="loading" alt="" align="right" style="visibility:hidden;" />Recherche de destinataires</h3>
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
					<h3><img src="<? echo SITE_URL_ADMIN; ?>/images/loading.gif" id="loading2" alt="" align="right" style="visibility:hidden;" />Envoi du mail</h3>
					<br />
					<table class="editer" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td class="key">Nom:</td>
							<td><? echo $row->nom; ?></td>
						</tr>
						<tr>
							<td class="key">Titre:</td>
							<td><? echo $row->titre; ?></td>
						</tr>
						<tr>
							<td class="key">Template:</td>
							<td><? echo $row->template; ?></td>
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
				window.addEvent('domready',function() {
					rechercheDestinataires();
				});
			</script>
			<?
		}
		
		public static function mailingApercu($mailing){
			$mailingTexte 	= JL::getMailHtml(SITE_PATH_ADMIN.'/app/app_mailing2/template/'.$mailing->template, $mailing->titre, $mailing->texte, $user->username);
			echo $mailingTexte;
		}
	}
?>

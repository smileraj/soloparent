<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class user_HTML {	
		
		// liste les utilisateurs
		public static function userLister(&$userObjs, &$search, &$messages) {
		
			// variables
			$i 				= 0; // compteur de tr
			$td 			= 0; // compteur de td
			$tdParTr		= 6; // nombre de td par ligne
			$rayon 			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
						
			?>
				<script language="javascript" type="text/javascript">
					function submitform(action) {
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'supprimer') {
							if(!confirm('Voulez-vous vraiment supprimer les utilisateurs sélectionnés ?')) {
								ok = false;
							}
						} else if(action == 'desactiver') {
							if(!confirm('Voulez-vous vraiment désactiver les utilisateurs sélectionnés ?')) {
								ok = false;
							}
						} else if(action == 'activer') {
							if(!confirm('Voulez-vous vraiment activer les utilisateurs sélectionnés ?')) {
								ok = false;
							}
						}
						
						if(ok) {
							form.action.value = action;
							form.submit();
						}
						
					}
					function cancelsubmitform(action) {
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'Fermer') {
							if(!confirm('Êtes-vous sûr de vouloir Fermer?')) {
								ok = false;
							}
						} 
						
						if(ok) {
						
							window.location.href = "<? echo SITE_URL_ADMIN; ?>"; 
						}
						
					}
				</script>
				
				<form name="listForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                        <h2>Gestion des <? echo $search['gid'] ? 'Administrateurs' : 'Membres'; ?></h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<? if($search['gid'] == 1) { ?><a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=user&action=nouveau" title="Activer les utilisateurs s&eacute;lectionn&eacute;s" class="btn btn-default">Nouveau</a><? } ?>
						<a href="javascript:submitform('activer');" title="Activer les utilisateurs s&eacute;lectionn&eacute;s" class="btn btn-success">Activer</a>
						<a href="javascript:submitform('desactiver');" title="D&eacute;sactiver les utilisateurs s&eacute;lectionn&eacute;s" class=" btn btn btn-danger">D&eacute;sactiver</a>
						<a href="javascript:submitform('supprimer');" title="Supprimer les utilisateurs s&eacute;lectionn&eacute;s" class="btn btn-danger">Supprimer</a>
						<a href="javascript:cancelsubmitform('Fermer')" title="Fermer" class=" btn btn-warning">Fermer</a>
					</div>				
				  </div>
              </div>
				
				
				<br />
				<? if(count($messages)) { ?>
					<div class="messages">
						<? JL::messages($messages); ?>
					</div>
					<br />
				<? } ?>
				<div class="tableAdmin">
					<div class="filtre form-group col-md-12">
					<span class="col-md-1" style="padding-top:8px;"><b>Pseudo:</b></span>
					<span class="col-md-3"><input type="text" class="form-control" name="search_username" id="search_username" value="<? echo htmlentities($search['username']); ?>" onChange="document.listForm.submit();" /></span> 
					</div>
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf" style="text-align: center;">
						<? if(count($userObjs)) { ?>
						<tr>
							<th width="30px"></th>
							<th>Pseudo</th>
							<th width="75px" align="center">Confirm&eacute;</th>
							<th width="75px" align="center">Activ&eacute;</th>
							<th width="150px">Date d'inscription</th>
							<th width="150px">Derni&egrave;re connexion</th>
						</tr>
						<?
						foreach($userObjs as $userObj) {
						?>
							<tr class="list">
								<td align="center"><input type="checkbox" name="id[]" value="<? echo $userObj->id; ?>" id="user_<? echo $userObj->id; ?>"></td>
								<td><a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=user&action=editer&id=<? echo $userObj->id; ?>" title="Modifier l'utilisateur <? echo $userObj->username; ?>"><? echo $userObj->username; ?></td>
								<td align="center"><img src="images/<? echo $userObj->confirmed; ?>.png" /></td>
								<td align="center"><a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=user&action=<? echo $userObj->published ? 'desactiver' : 'activer'; ?>&id[]=<? echo $userObj->id; ?>" title="Cliquez pour <? echo $userObj->published ? 'd&eacute;sactiver' : 'activer'; ?> le profil de <? echo $userObj->username; ?>"><img src="images/<? echo $userObj->published; ?>.png" alt="<? echo $userObj->published ? 'Oui' : 'Non'; ?>" /></a></td>
								<td><? echo date('d/m/Y H:i:s', strtotime($userObj->creation_date)); ?></td>
								<td><? echo $userObj->last_online != '0000-00-00 00:00:00' ? date('d/m/Y H:i:s', strtotime($userObj->last_online)) : 'jamais'; ?></td>
							</tr>
						<?
						} ?>
					
						<tr>
							<td colspan="6">
								<b>Pages</b>:
								<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=user&search_page=1&search_gid='.$search['gid']); ?>" title="Afficher la page 1">D&eacute;but</a> ...<? }?>
								<?
									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=user&search_page='.$i.'&search_gid='.$search['gid']); ?>" title="Afficher la page <? echo $i; ?>" <? if($i == $search['page']) { ?>class="displayActive"<? } ?>><? echo $i; ?></a>
									<?
									}
								?>
								<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=user&search_page='.$search['page_total'].'&search_gid='.$search['gid']); ?>" title="Afficher la page <? echo $search['page_total']; ?>">Fin</a><? }?> <i>(<? echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
					<? } else { ?>
						<tr>
							<th>Aucun utilisateur ne correspond &agrave; votre recherche.</th>
						</tr>
					<? } ?>
					</table>
				</div>
					<input type="hidden" name="app" value="user" />
					<input type="hidden" name="action" value="" />
				</section>
				</form>
			<?
		}
		
		
		// formlaire d'édition d'un utiisateur
		public static function userEditer($userObj, &$messages) {
			
			JL::makeSafe($userObj);
			
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
						
							document.location = "<? echo SITE_URL_ADMIN; ?>/index.php?app=user"; 
						}
						
					}
				</script>
			<form name="editForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                       <h2>Utilisateur: <? echo $userObj->id ? 'Editer' : 'Nouveau'; ?></h2>
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
				<div class="tableAdmin form-group">
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">						
						<tr>
							<td width="20%" class="key" >Pseudo:</td>
							<td ><input type="text" name="user_username" maxlength="255" size="30" class="form-control" value="<? echo $userObj->username; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Email:</td>
							<td><input type="text" name="user_email" maxlength="50" size="30" class="form-control" value="<? echo $userObj->email; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Mot de passe:</td>
							<td><input type="password" name="user_password" maxlength="50" size="30" class="form-control" value="" /></td>
						</tr>
						<tr>
							<td class="key">Mot de passe:<br /><i>(Confirmation)</i></td>
							<td><input type="password" name="user_password2" maxlength="50" size="30" class="form-control" value="" /></td>
						</tr>
						<tr>
							<td class="key">Activ&eacute;:</td>
							<td><input type="radio" id="pu1" name="user_published" value="1" <? if($userObj->published) { ?>checked<? } ?> /> <label for="pu1">Oui</label>&nbsp;<input type="radio" id="pu0" name="user_published" value="0" <? if(!$userObj->published) { ?>checked<? } ?> /> <label for="pu0">Non</label></td>
						</tr>
						<tr>
							<td class="key">Confirm&eacute;:</td>
							<td><? echo $userObj->confirmed == 1 ? '<span style="color:#00CC00;font-weight:bold">Oui</span>' : '<span style="color:#CC0000;font-weight:bold">Non</span>'; ?></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<i>Cr&eacute;&eacute; le <? echo date('d/m/Y à H:i:s', strtotime($userObj->creation_date)); ?></i>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<i><? if($userObj->last_online != '0000-00-00') { ?>Derni&egrave;re connexion le <? echo date('d/m/Y à H:i:s', strtotime($userObj->last_online)); } else { ?>Jamais connect&eacute;<? } ?></i>
							</td>
						</tr>
					</table>
				</div>
				<input type="hidden" name="id" value="<? echo $userObj->id; ?>" />
				<input type="hidden" name="app" value="user" />
				<input type="hidden" name="action" value="save" />
				</section>
			</form>
			<?
		}
		
	}
	
?>

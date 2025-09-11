<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class profil_HTML {	
		
		// liste les profils
		function profilLister(&$users, &$search, &$lists, &$messages, &$stats) {
		
			// variables
			$i 				= 0; // compteur de tr
			$td 			= 0; // compteur de td
			$tdParTr		= 11; // nombre de td par ligne
			$rayon 			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
						
			// pays contrôlés
			$paysVert		= array('CH');
			$paysGris		= array('XX');
			$paysRouge		= array('CI','SN','EG');
						
			?>
				<script language="javascript" type="text/javascript">
					function submitform(action) {
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'supprimer') {
							if(!confirm('Voulez-vous vraiment supprimer les profils sélectionnés ?')) {
								ok = false;
							}
						} else if(action == 'desactiver') {
							if(!confirm('Voulez-vous vraiment désactiver les profils sélectionnés ?')) {
								ok = false;
							}
						} else if(action == 'activer') {
							if(!confirm('Voulez-vous vraiment activer les profils sélectionnés ?')) {
								ok = false;
							}
						}
						
						if(ok) {
							form.action.value = action;
							form.submit();
						}
						
					}
					function cancelsubmit(action) {
						
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
                      <h2>Gestion des profils <i>(H: <? echo $stats['papas']; ?>% / F: <? echo $stats['mamans']; ?>%)</i></h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:submitform('activer');" title="Activer les profils s&eacute;lectionn&eacute;s" class=" btn btn-success">Activer</a>
						<a href="javascript:submitform('desactiver');" title="D&eacute;sactiver les profils s&eacute;lectionn&eacute;s" class=" btn btn-success">D&eacute;sactiver</a>
						<a href="javascript:submitform('supprimer');" title="Supprimer les profils s&eacute;lectionn&eacute;s" class=" btn btn-success">Supprimer</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class=" btn btn-success">Fermer</a>
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
					<div class="filtre">
						<table class="table table-bordered table-striped  cf">
							<tr>
								<td><b>Recherche:</b></td>
								<td><input type="text" name="search_word" id="search_word" value="<? echo htmlentities($search['word']); ?>" class="searchInput" /></td>
								<td><b>Profil Helvetica:</b></td>
								<td><? echo $lists['helvetica']; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td><b>Tri par:</b></td>
								<td><? echo $lists['order']; ?></td>
								<td><b>Statut:</b></td>
								<td> <? echo $lists['confirmed']; ?></td>
							</tr>
							<tr>
								<td><b>Ordre:</b></td>
								<td><? echo $lists['ascdesc']; ?></td>
								<td><b>Genre:</b></td>
								<td><? echo $lists['genre']; ?></td>
							</tr>
							<tr>
								<td><b>Abonnement:</b></td>
								<td><? echo $lists['abonnement']; ?></td>
							</tr>
							<tr>
								<td colspan="4" align="right"><a href="javascript:document.listForm.submit();" class="bouton envoyer">Rechercher</a></td>
							</tr>
						</table>
					</div>	
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
											
						<? if(count($users)) { ?>
						<tr>
							<th width="20px"></th>
							<th>Pseudo</th>
							<th align="center">Genre</th>
							<th align="center">Activ&eacute;</th>
							<th align="center">Confirm&eacute;</th>
							<th>Abonnement</th>
							<th>Nom</th>
							<th>Pr&eacute;nom</th>
							<th>T&eacute;l&eacute;phone</th>
							<th>Appels</th>
							<th>Pays</th>
						</tr>
						<?
						foreach($users as $user) {
						
							// htmlentities
							JL::makeSafe($user);
							
							// var locales
							$warning 	= false;

							if($user->gold_limit_date != '0000-00-00') {
							
								$userTime				= strtotime($user->gold_limit_date);
								$time					= time();
								$jours					= ceil(($userTime-$time)/86400);
								
								
								// abonnement en cours
								if($userTime >= $time) {
									$user->abonnement 	= date('d/m/Y', $userTime).'<br /><b>('.$jours.' jours)</b>';
								} else {
									$user->abonnement 	= date('d/m/Y', $userTime).'<br /><b>(termin&eacute;)</b>';
								}
							
							} else {
							
								$user->abonnement 		= '';
								$jours					= 0;
								
							}

							
							// vérif téléphone
							if($jours < 500 && !preg_match('/^0?[0-9]{9}$/', preg_replace('/[^0-9]/','', $user->telephone_origine))) {
								$colorPhone = 'orange';
								$warning = true;
							} else {
								$colorPhone = '';
							}
							

							// vérif pays
							$pays			= $user->ip_pays;
							
							// si le profil s'est connecté depuis un pays accepté
							if(in_array($pays, $paysVert)) {
							
								$colorPays = 'green';

							} elseif(in_array($pays, $paysGris)) { // sinon s'il s'est connecté depuis un pays toléré
							
								$colorPays = 'grey';
							
							} elseif(in_array($pays, $paysRouge)) { // sinon s'il s'est connecté depuis un pays interdit
							
								$colorPays = 'red';
								$warning = true;
								
							} else { // pays inconnu
							
								$colorPays = 'orange';
								$warning = true;
								
							}
							
							
							// vérif nom
							if($jours < 500 && strlen($user->nom_origine) < 3) {
								$colorNom = 'orange';
								$warning = true;
							} else {
								$colorNom = '';
							}
							
						?>
							<tr class="list<? if($jours > 0 && $jours <= 3) { ?> jours3<? } ?><? if($warning) { ?> warning<? } ?>" >
								<td align="center"><input type="checkbox" name="id[]" value="<? echo $user->id; ?>" id="user_<? echo $user->id; ?>"></td>
								<td>
									<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=editer&id=<? echo $user->id; ?>" title="Modifier le profil de <? echo $user->username; ?>"><? echo $user->username; ?></a><br />
									<span style="font-size:10px;font-style:italic;"><? echo $user->points_total; ?> pts</span>
								</td>
								<td align="center"><img src="images/<? echo $user->genre; ?>.png" alt="<? echo $user->genre == 'h' ? 'Homme' : 'Femme'; ?>" /></td>
								<td align="center">
								<? /*
								<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=<? echo $user->published ? 'desactiver' : 'activer'; ?>&id[]=<? echo $user->id; ?>" title="Cliquez pour <? echo $user->published ? 'd&eacute;sactiver' : 'activer'; ?> le profil de <? echo $user->username; ?>">
								*/ ?>
								<img src="images/<? echo $user->published; ?>.png" alt="<? echo $user->published ? 'Oui' : 'Non'; ?>" />
								<? /*
								</a>
								*/ ?>
								</td>
								<td align="center"><img src="images/<? echo $user->confirmed; ?>.png" alt="" /></td>
								<td><? echo $user->abonnement; ?></td>
								
								<? if($user->helvetica == 1) { 
									
								?>
									<td colspan="4">
										<img src="<? echo SITE_URL_ADMIN; ?>/images/helvetica.jpg" alt="" />
									</td>
									
								<? } else { ?>
								
									<td style="color: <? echo $colorNom; ?>;"><? echo $user->nom_origine; ?></td>
									<td><? echo $user->prenom_origine; ?></td>
									<td style="color: <? echo $colorPhone; ?>;">
										<? echo substr($user->telephone_origine, 0, 1) == '0' ? $user->telephone_origine : '0'.$user->telephone_origine; ?>
									</td>
									<td>
									<?
										// date d'appel
										if($user->appel_date != '0000-00-00') {
										
											$userTime	= strtotime($user->appel_date);
											echo date('d/m/Y', $userTime);
										
										}
										
										// date d'appel 2
										if($user->appel_date2 != '0000-00-00') {
										
											$userTime	= strtotime($user->appel_date2);
											echo '<br /><span style="font-size:10px;color:#aaa;">+ '.date('d/m/Y', $userTime).'</span>';
										
										}
									?>
									</td>
									
								<? } ?>
								
								<td style="color:<? echo $colorPays; ?>; font-weight:bold; text-align: center;">
									<? echo str_replace('XX', '?', $pays); ?>
								</td>
							</tr>
							<? if($user->helvetica == 1) { 
									$photos	= array();
			
									// récup les photos de l'utilisateur, autres que celle par défaut
									$dir	= '../images/profil/'.$user->id;
									if(is_dir($dir)) {
									
										$dir_id 	= opendir($dir);
										while($file = trim(readdir($dir_id))) {
											
											// récup les miniatures de photos validées
											if(preg_match('/^parent-solo-109/', $file)) {
												
												$photos[]	= $file;
												
											}
											
										}
										
									}
								?>
							<tr class="list_photos<? if($jours > 0 && $jours <= 3) { ?> jours3<? } ?><? if($warning) { ?> warning<? } ?>" >
								<td colspan="11">
									<?
											foreach($photos as $photo) {
											?>
												<div class="profilPhoto">
													<img src="<? echo SITE_URL; ?>/images/profil/<? echo $user->id; ?>/<? echo $photo; ?>" alt="" />
												</div>
											<?
											}
										?>
								</td>
							</tr>
							
						<?
							}
						} ?>
					
						<tr>
							<td colspan="<? echo $tdParTr; ?>">
								<b>Pages</b>:
								<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil&search_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<? }?>
								<?
									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil&search_page='.$i); ?>" title="Afficher la page <? echo $i; ?>" <? if($i == $search['page']) { ?>class="displayActive"<? } ?>><? echo $i; ?></a>
									<?
									}
								?>
								<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil&search_page='.$search['page_total']); ?>" title="Afficher la page <? echo $search['page_total']; ?>">Fin</a><? }?> <i>(<? echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
					<? } else { ?>
						<tr>
							<th colspan="<? echo $tdParTr; ?>">Aucun profil ne correspond &agrave; votre recherche.</th>
						</tr>
					<? } ?>
					</table>
				</div>
					<input type="hidden" name="search_page" value="1" />
					<input type="hidden" name="app" value="profil" />
					<input type="hidden" name="action" value="" />
				</section>
				</form>
			<?
		}
		
		
		// liste les photos à valider
		function photoLister(&$users, &$messages) {
			
			$i 				= 0; // compteur de tr
			$td 			= 0; // compteur de td
			$photoTotal		= 0; // compteur de photos
			$tdParTr		= 3; // nombre de td par ligne
			$photoLimite	= 150; // nombre de photos par page
			
			?>
				<script language="javascript" type="text/javascript">
					function submitform(action) {
						
						var form = document.listForm;
						
						if(action == 'supprimer') {
							if(!confirm('Voulez-vous vraiment supprimer les photos sélectionnées ?')) {
								return 0;
							}
						}
						
						form.task.value = action;
						form.submit();
					}
					function cancelsubmit(action) {
						
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
                       <h2>Validation des photos</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:submitform('valider');" title="Valider" class="btn btn-success">Valider</a>
						<a href="javascript:submitform('supprimer');" title="Supprimer" class="btn btn-success">Supprimer</a>
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
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
						<? if(count($users)) { ?>
						<tr>
							<th colspan="<? echo $tdParTr; ?>">Photos en attente de validation</th>
						</tr>
						<?
						foreach($users as $user) {
							if(count($user->photos)) {
								foreach($user->photos as $photo) {
									
									// limite de photos par page atteinte
									if($photoTotal >= $photoLimite) {
										continue;
									}
									
									if($td%$tdParTr == 0) {
									?>
									<tr class="list">
									<?
									}
									?>
										<td>
											<label for="<? echo $user->user_id; ?>_<? echo $photo; ?>"><img src="<? echo SITE_URL; ?>/images/profil/<? echo $user->user_id; ?>/pending-parent-solo-<? echo $photo; ?>.jpg?<? echo time(); ?>" /><br />
											<input type="checkbox" checked="true" name="photo[]" value="<? echo $user->user_id; ?>_<? echo $photo; ?>" id="<? echo $user->user_id; ?>_<? echo $photo; ?>"> <? echo $user->username.' '.$photo; ?></label>
										</td>
									<?
									if($td%$tdParTr == $tdParTr-1) {
									?>
									</tr>
									<?
									}
									
									$td++;
									$photoTotal++;
								}
								
							}
						}
					
								// nombre de cases pas rond
								if($photoTotal%$tdParTr != $tdParTr-1) {
								?>
									</tr>
								<?
								}
					 } else { ?>
						<tr>
							<th>Aucune photo en attente de validation.</th>
						</tr>
					<? } ?>
					</table>
					</div>
					<input type="hidden" name="app" value="profil" />
					<input type="hidden" name="action" value="photo_validation_submit" />
					<input type="hidden" name="task" value="" />
				</section>
				</form>
			<?
		}
		
		
		// liste les textes à valider
		function texteLister(&$textes, &$messages) {
			
			?>
				<script language="javascript" type="text/javascript">
					function submitform(action)
					{
						var form = document.listForm;
						form.task.value = action;
						form.submit();
					}
					function cancelsubmit(action) {
						
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
                      <h2>Validation des textes</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:submitform('valider');" title="Valider" class=" btn btn-success">Valider</a>
						<a href="javascript:submitform('refuser');" title="Supprimer" class=" btn btn-success">Refuser</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class=" btn btn-success">Fermer</a>
					</div></div></div>
				<? if(count($messages)) { ?>
						<div class="messages">
							<? JL::messages($messages); ?>
						</div>
						<br/>
				<? } ?>
				<div class="tableAdmin">
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
					
						
						
						<? if(count($textes)) {
							$i 				= 0; // compteur de tr
							$texteTotal		= 0; // compteur de textes
							$texteLimite	= 10; // nombre de textes par page
							
							?>
							<tr>
								<th>Textes en attente de validation</th>
							</tr>
							<?
							foreach($textes as $texte) {
								
								// limite de textes par page atteinte
								if($texteTotal >= $texteLimite) {
									continue;
								}
							?>
								<tr class="list">
									<td>
										<input type="checkbox" checked="true" name="texte[]" value="<? echo $texte->user_id; ?>" id="texte<? echo $texte->user_id; ?>"> <label for="texte<? echo $texte->user_id; ?>"><b><? echo $texte->username; ?>:</b></label><br /><br />
										<div><textarea name="annonce<? echo $texte->user_id; ?>" rows="10" cols="92"><? echo htmlentities($texte->annonce); ?></textarea></div>
									</td>
								</tr>
								<?
								$texteTotal++;
							}
							?>
					<? } else { ?>
						<tr>
							<th>Aucun texte en attente de validation.</th>
						</tr>
					<? } ?>
					</table>
				</div>
					<input type="hidden" name="app" value="profil" />
					<input type="hidden" name="action" value="texte_validation_submit" />
					<input type="hidden" name="task" value="" />
				</section>
				</form>
			<?
		}
		
		
		// formlaire d'édition d'un profil
		function profilEditer(&$userObj, &$messages, &$points) {
			
			// htmlentities
			JL::makeSafe($userObj);
			
			// variables
			$photos	= array();
			
			// récup les photos de l'utilisateur, autres que celle par défaut
			$dir	= '../images/profil/'.$userObj->id;
			if(is_dir($dir)) {
			
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {
					
					// récup les miniatures de photos validées
					if(preg_match('/^parent-solo-109/', $file)) {
						
						$photos[]	= $file;
						
					}
					
				}
				
			}
			
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
						
							window.location.href = "<? echo SITE_URL_ADMIN; ?>/index.php?app=profil"; 
						}
						
					}
				</script>
			<form name="editForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                      <h2>Profil : <? echo $userObj->username; ?></h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save btn btn-success" >Sauver</a>
						<a href="javascript:cancelsubmit('Annuler')" title="Annuler" class="cancel btn btn-success" >Annuler</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="cancel btn btn-success" >Fermer</a>
					</div></div>
				</div>
				
				<? if(count($messages)) { ?>
						<div class="messages">
							<? JL::messages($messages); ?>
						</div>
						<br />
				<? } ?>
				<div class="tableAdmin">
					<h3>Donn&eacute;es inscription</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key" width="200px">Pseudo:</td>
							<td width="250px"><? echo $userObj->username; ?></td>
							<td><a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=user&action=editer&id=<? echo $userObj->id; ?>"><i>(modifier)</i></a></td>
						</tr>
						<tr>
							<td class="key" width="200px">Genre:</td>
							<td><img src="images/<? echo $userObj->genre; ?>.png" alt="<? echo $userObj->genre == 'h' ? 'Homme' : 'Femme'; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Profil Helvetica:</td>
							<td><input type="radio" id="helvetica1" name="helvetica" value="1" <? if($userObj->helvetica) { ?>checked<? } ?> /> <label for="helvetica1">Oui</label>&nbsp;<input type="radio" id="helvetica0" name="helvetica" value="0" <? if(!$userObj->helvetica) { ?>checked<? } ?> /> <label for="helvetica0">Non</label></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td class="key">Langue d'appel:</td>
							<td>
								<? switch($userObj->langue_appel){
									case 1: echo "Fran&ccedil;ais"; break;
									case 2: echo "Anglais"; break;
									case 3: echo "Allemand"; break;
									default: echo "Non renseignée";break;
								}?>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td class="key">Email:</td>
							<td><a href="mailto:<? echo $userObj->email; ?>" title="Envoyer un email &agrave; <? echo $userObj->username; ?>"><? echo $userObj->email; ?></a></td>
							<td><a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=user&action=editer&id=<? echo $userObj->id; ?>"><i>(modifier)</i></a></td>
						</tr>
						<tr>
							<td class="key">Nom:</td>
							<td><input type="text" name="nom" value="<? echo $userObj->nom_origine; ?>" /></td>
							<td><i><? echo $userObj->nom; ?></i></td>
						</tr>
						<tr>
							<td class="key">Pr&eacute;nom:</td>
							<td><input type="text" name="prenom" value="<? echo $userObj->prenom_origine; ?>" /></td>
							<td><i><? echo $userObj->prenom; ?></i></td>
						</tr>
						<tr>
							<td class="key">T&eacute;l&eacute;phone:</td>
							<td><input type="text" name="telephone" value="<? echo $userObj->telephone_origine; ?>" /></td>
							<td><i><? echo $userObj->telephone; ?></i></td>
						</tr>
						<tr>
							<td class="key">Adresse:</td>
							<td><input type="text" name="adresse" value="<? echo $userObj->adresse_origine; ?>" /></td>
							<td><i><? echo $userObj->adresse; ?></i></td>
						</tr>
						<tr>
							<td class="key">Code postal:</td>
							<td><input type="text" name="code_postal" value="<? echo $userObj->code_postal_origine; ?>" /></td>
							<td><i><? echo $userObj->code_postal; ?></i></td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Abonnement et points</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Abonnement jusqu'au:</td>
							<td><input type="text" name="gold_limit_date" value="<? echo $userObj->gold_limit_date != '0000-00-00' ? date('d/m/Y', strtotime($userObj->gold_limit_date)) : ''; ?>" size="9" /> <i>(jj/mm/aaaa)</i></td>
						</tr>
						<tr>
							<td class="key">Cr&eacute;diter abonnement:</td>
							<td><input type="text" name="abonnement_crediter" value="0" size="9" /> <i>jours</i></td>
						</tr>
						<tr>
							<td class="key">Points actuels:</td>
							<td>
								<? echo $userObj->points_total; ?>
							</td>
						</tr>
						<tr>
							<td class="key">Cr&eacute;diter points</td>
							<td>
							<?
								// s'il y a des points à créditer
								if(is_array($points) && count($points) > 0) {
								?>
								<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf pointsTable">
									<tr>
										<th colspan="2">Action</th>
										<th>Points</th>
									</tr>
									<tr>
										<td><input type="radio" name="points_id" id="points_id_0" value="0" checked /></td>
										<td><label for="points_id_0">Ne pas cr&eacute;diter de points</label></td>
										<td>+0</td>
									</tr>
									<?
									
										// pour chaque point
										foreach($points as $point) {
										
											// html ent
											JL::makeSafe($point);
										
										?>
											<tr>
												<td><input type="radio" name="points_id" id="points_id_<? echo $point->id; ?>" value="<? echo $point->id; ?>" /></td>
												<td><label for="points_id_<? echo $point->id; ?>"><? echo $point->nom; ?></label></td>
												<td>+<? echo $point->points; ?></td>
											</tr>
										<?
										}
									
									?>
								</table>
								<?
								}
							?>
							</td>
						</tr>
						<tr>
							<td class="key">Retirer des points</td>
							<td>-&nbsp;<input type="text" size="2" name="points_retirer" value="0" /> points.
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Photos et Annonce</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Photos:</td>
							<td>
							<?
								foreach($photos as $photo) {
								?>
									<div class="profilPhoto">
										<i><? echo preg_replace('/^parent\-solo\-109\-(.*)\-[1-9].jpg$/', '$1', $photo); ?></i><br />
										<label for="<? echo $photo; ?>"><img src="<? echo SITE_URL; ?>/images/profil/<? echo $userObj->id; ?>/<? echo $photo; ?>" alt="" /></label><br />
										<input type="checkbox" name="photo[]" value="<? echo $photo; ?>" id="<? echo $photo; ?>" /> <label for="<? echo $photo; ?>">Supprimer</label>
									</div>
								<?
								}
							?>
							</td>
						</tr>
						<tr>
							<td class="key">Annonce publi&eacute;e:</td>
							<td><textarea name="annonce_valide" rows="5" cols="50"><? echo $userObj->annonce_valide; ?></textarea></td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Suivi administratif</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Inscription:</td>
							<td>
								<? echo date('d/m/Y', strtotime($userObj->creation_date)); ?>
							</td>
						</tr>
						<tr>
							<td class="key">Confirm&eacute;:</td>
							<td>
								<div class="statut statut0"><input type="radio" name="confirmed" value="0" id="confirmed0" <? if($userObj->confirmed == 0) { ?>checked="true"<? } ?> /> <label for="confirmed0" style="cursor:pointer;">Non</label></div>
								<div class="statut statut1"><input type="radio" name="confirmed" value="1" id="confirmed1" <? if($userObj->confirmed == 1) { ?>checked="true"<? } ?> /> <label for="confirmed1" style="cursor:pointer;">Oui</label></div>
								<div class="statut statut2"><input type="radio" name="confirmed" value="2" id="confirmed2" <? if($userObj->confirmed == 2) { ?>checked="true"<? } ?> /> <label for="confirmed2" style="cursor:pointer;">En attente</label></div>
							</td>
						</tr>
						<tr>
							<td class="key">Paiement en ligne:</td>
							<td>
								<? echo $userObj->abonnement_carte ? date('d/m/Y', strtotime($userObj->abonnement_carte)).' - '.$userObj->abonnement_carte_nom.' '.$userObj->abonnement_carte_prenom.' - '.($userObj->abonnement_carte_valide==1 ? 'en cours' : 'annul&eacute;' ) : '-'; ?>
							</td>
						</tr>
						<tr>
							<td class="key">1er appel:</td>
							<td><input type="text" name="appel_date" value="<? echo $userObj->appel_date != '0000-00-00' ? date('d/m/Y', strtotime($userObj->appel_date)) : ''; ?>" size="9" /> <i>(jj/mm/aaaa)</i></td>
						</tr>
						<tr>
							<td class="key">2&egrave;me appel:</td>
							<td><input type="text" name="appel_date2" value="<? echo $userObj->appel_date2 != '0000-00-00' ? date('d/m/Y', strtotime($userObj->appel_date2)) : ''; ?>" size="9" /> <i>(jj/mm/aaaa)</i></td>
						</tr>
						<tr>
							<td class="key">Commentaire:</td>
							<td><textarea name="commentaire" rows="5" cols="50"><? echo $userObj->commentaire; ?></textarea></td>
						</tr>
					</table>
				</div>
				
				<input type="hidden" name="id" value="<? echo $userObj->id; ?>" />
				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="save" />
				</section>
			</form>
			<?
		}
		
	}
?>

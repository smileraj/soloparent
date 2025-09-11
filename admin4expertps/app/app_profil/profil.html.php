<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class profil_HTML {	
		
		// liste les profils
		public static function profilLister(&$users, &$search) {
		
			// variables
			$i 				= 0; // compteur de tr
			$td 			= 0; // compteur de td
			$tdParTr		= 11; // nombre de td par ligne
			$rayon 			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
						
			?>
				
				<form name="listForm" action="<? echo SITE_URL_ADMIN_EXPERT; ?>/index.php" method="post">
				
				<div class="titlebar app_redac">
					<div class="toolbar">
						<a href="<? echo SITE_URL_ADMIN_EXPERT; ?>" title="Fermer">Fermer</a>
					</div>
					
					<h2>Liste des profils des membres</h2>
				</div>
				<br />
				
				<div class="tableAdmin">
					<div class="filtre">
						<table>
							<tr>
								<td><b>Adresse E-mail:</b></td>
								<td><input type="text" name="search_word" id="search_word" value="<? echo htmlentities($search['word']); ?>" class="searchInput" /></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align="right"><a href="javascript:document.listForm.submit();" class="bouton envoyer">Rechercher</a></td>
							</tr>
						</table>
					</div>	
					<table cellpadding="0" cellspacing="0" class="lister">
											
						<? if(count($users)) { ?>
						<tr>
							<th width="20px"></th>
							<th>Pseudo</th>
							<th align="center">Genre</th>
							<th align="center">Age</th>
							<th align="center">Nb enfants</th>
							<th>Ville</th>
							<th>Canton</th>
							<th>Email</th>
						</tr>
						<?
						foreach($users as $user) {
						
							// htmlentities
							JL::makeSafe($user);
							
							
						?>
							<tr class="list" >
								<td align="center"><input type="checkbox" name="id[]" value="<? echo $user->id; ?>" id="user_<? echo $user->id; ?>"></td>
								<td>
									<a href="<? echo SITE_URL_ADMIN_EXPERT; ?>/index.php?app=profil&action=editer&id=<? echo $user->id; ?>" title="Modifier le profil de <? echo $user->username; ?>"><? echo $user->username; ?></a>
								</td>
								<td align="center"><img src="images/<? echo $user->genre; ?>.png" alt="<? echo $user->genre == 'h' ? 'Homme' : 'Femme'; ?>" /></td>
								<td align="center"><? echo $user->age;?> ans</td>
								<td align="center"><? echo $user->nb_enfants;?> enfant(s)</td>
								<td><? echo $user->ville; ?></td>
								<td><? echo $user->canton; ?></td>
								<td><? echo $user->email; ?></td>
							</tr>
						<?
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
				</form>
			<?
		}
		
		
		// liste les photos à valider
		public static function photoLister(&$users, &$messages) {
			
			$i 				= 0; // compteur de tr
			$td 			= 0; // compteur de td
			$photoTotal		= 0; // compteur de photos
			$tdParTr		= 3; // nombre de td par ligne
			$photoLimite	= 10; // nombre de photos par page
			
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
				</script>
				
				<form name="listForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				
				<div class="titlebar app_redac">
					<div class="toolbar">
						<a href="javascript:submitform('valider');" title="Valider">Valider</a>
						<a href="javascript:submitform('supprimer');" title="Supprimer">Supprimer</a>
						<a href="<? echo SITE_URL_ADMIN; ?>" title="Fermer">Fermer</a>
					</div>
					
					<h2>Validation des photos</h2>
					
				</div>
				<br />
				<? if(count($messages)) { ?>
						<div class="messages">
							<? JL::messages($messages); ?>
						</div>
						<br />
				<? } ?>
				<div class="tableAdmin">
					<table cellpadding="0" cellspacing="0" class="lister">
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
				</form>
			<?
		}
		
		
		// liste les textes à valider
		public static function texteLister(&$textes, &$messages) {
			
			?>
				<script language="javascript" type="text/javascript">
					function submitform(action) {
						var form = document.listForm;
						form.task.value = action;
						form.submit();
					}
				</script>
				
				<form name="listForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				
				<div class="titlebar app_redac">
					<div class="toolbar">
						<a href="javascript:submitform('valider');" title="Valider">Valider</a>
						<a href="javascript:submitform('refuser');" title="Supprimer">Refuser</a>
						<a href="<? echo SITE_URL_ADMIN; ?>" title="Fermer">Fermer</a>
					</div>
					
					<h2>Validation des textes</h2>
					
				</div>
				<br />
				<? if(count($messages)) { ?>
						<div class="messages">
							<? JL::messages($messages); ?>
						</div>
						<br/>
				<? } ?>
				<div class="tableAdmin">
					<table cellpadding="0" cellspacing="0" class="lister">
					
						
						
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
				</form>
			<?
		}
		
		
		// formlaire d'édition d'un profil
		public static function profilEditer(&$userObj, &$messages, &$points) {
			
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
			
			<form name="editForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				
				<div class="titlebar app_user">
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save">Sauver</a>
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=profil" title="Annuler" class="cancel">Annuler</a>
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=profil" title="Fermer" class="cancel">Fermer</a>
					</div>
					
					<h2>Profil : <? echo $userObj->username; ?></h2>
				</div>
				<br />
				<? if(count($messages)) { ?>
						<div class="messages">
							<? JL::messages($messages); ?>
						</div>
						<br />
				<? } ?>
				<div class="tableAdmin">
					<h3>Donn&eacute;es inscription</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="editer">
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
					<table cellpadding="0" cellspacing="0" class="editer">
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
								<table cellpadding="0" cellspacing="0" class="pointsTable">
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
					<table cellpadding="0" cellspacing="0" class="editer">
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
					<table cellpadding="0" cellspacing="0" class="editer">
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
			</form>
			<?
		}
		
	}
?>

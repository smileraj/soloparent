<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class profil_suppr_HTML {	
		
		// liste les profils
		public static function profilLister(&$users, &$search, &$lists, &$messages, &$stats) {
		
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
				
				
				<form name="listForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				
				<div class="titlebar app_redac">
					<div class="toolbar">
						<a href="<? echo SITE_URL_ADMIN; ?>" title="Fermer">Fermer</a>
					</div>
					
					<h2>Gestion des profils<br /> (H: <? echo $stats['papas']; ?>% / F: <? echo $stats['mamans']; ?>%)</h2>
					
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
						<table class="table table-bordered table-striped table-condensed cf">
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
									<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=profil_suppr&action=editer&id=<? echo $user->id; ?>" title="Modifier le profil de <? echo $user->username; ?>"><? echo $user->username; ?></a><br />
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
								
								<? if($user->helvetica == 1) { ?>
								
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
						<?
						} ?>
					
						<tr>
							<td colspan="<? echo $tdParTr; ?>">
								<b>Pages</b>:
								<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil_suppr&search_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<? }?>
								<?
									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil_suppr&search_page='.$i); ?>" title="Afficher la page <? echo $i; ?>" <? if($i == $search['page']) { ?>class="displayActive"<? } ?>><? echo $i; ?></a>
									<?
									}
								?>
								<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil_suppr&search_page='.$search['page_total']); ?>" title="Afficher la page <? echo $search['page_total']; ?>">Fin</a><? }?> <i>(<? echo $search['result_total']; ?> r&eacute;sultats)</i>
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
					<input type="hidden" name="app" value="profil_suppr" />
					<input type="hidden" name="action" value="" />
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
			
			
				<div class="titlebar app_user">
					<div class="toolbar">
						<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=profil_suppr" title="Fermer" class="cancel">Fermer</a>
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
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key" width="200px">Pseudo:</td>
							<td width="250px"><? echo $userObj->username; ?></td>
						</tr>
						<tr>
							<td class="key" width="200px">Genre:</td>
							<td><img src="images/<? echo $userObj->genre; ?>.png" alt="<? echo $userObj->genre == 'h' ? 'Homme' : 'Femme'; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Profil Helvetica:</td>
							<td><? if($userObj->helvetica) { ?> Oui <? }else{ ?>Non <? } ?>
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
						</tr>
						<tr>
							<td class="key">Nom:</td>
							<td><? echo $userObj->nom_origine; ?></td>
							<td><i><? echo $userObj->nom; ?></i></td>
						</tr>
						<tr>
							<td class="key">Pr&eacute;nom:</td>
							<td><? echo $userObj->prenom_origine; ?></td>
							<td><i><? echo $userObj->prenom; ?></i></td>
						</tr>
						<tr>
							<td class="key">T&eacute;l&eacute;phone:</td>
							<td><? echo $userObj->telephone_origine; ?></td>
							<td><i><? echo $userObj->telephone; ?></i></td>
						</tr>
						<tr>
							<td class="key">Adresse:</td>
							<td><? echo $userObj->adresse_origine; ?></td>
							<td><i><? echo $userObj->adresse; ?></i></td>
						</tr>
						<tr>
							<td class="key">Code postal:</td>
							<td><? echo $userObj->code_postal_origine; ?></td>
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
							<td><? echo $userObj->gold_limit_date != '0000-00-00' ? date('d/m/Y', strtotime($userObj->gold_limit_date)) : ''; ?></td>
						</tr>
						<tr>
							<td class="key">Points actuels:</td>
							<td>
								<? echo $userObj->points_total; ?>
							</td>
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
										<label for="<? echo $photo; ?>"><img src="<? echo SITE_URL; ?>/images/profil/<? echo $userObj->id; ?>/<? echo $photo; ?>" alt="" /></label>
									</div>
								<?
								}
							?>
							</td>
						</tr>
						<tr>
							<td class="key">Annonce publi&eacute;e:</td>
							<td><? echo nl2br($userObj->annonce_valide); ?></td>
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
							<td class="key">Paiement en ligne:</td>
							<td>
								<? echo $userObj->abonnement_carte ? date('d/m/Y', strtotime($userObj->abonnement_carte)).' - '.$userObj->abonnement_carte_nom.' '.$userObj->abonnement_carte_prenom.' - '.($userObj->abonnement_carte_valide==1 ? 'en cours' : 'annul&eacute;' ) : '-'; ?>
							</td>
						</tr>
						<tr>
							<td class="key">1er appel:</td>
							<td><? echo $userObj->appel_date != '0000-00-00' ? date('d/m/Y', strtotime($userObj->appel_date)) : ''; ?></td>
						</tr>
						<tr>
							<td class="key">2&egrave;me appel:</td>
							<td><? echo $userObj->appel_date2 != '0000-00-00' ? date('d/m/Y', strtotime($userObj->appel_date2)) : ''; ?></td>
						</tr>
						<tr>
							<td class="key">Commentaire:</td>
							<td><? echo nl2br($userObj->commentaire); ?></textarea></td>
						</tr>
					</table>
				</div>
				
			<?
		}
		
	}
?>

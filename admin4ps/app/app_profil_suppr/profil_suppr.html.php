<?php

	// s�curit�
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
						
			// pays contr�l�s
			$paysVert		= ['CH'];
			$paysGris		= ['XX'];
			$paysRouge		= ['CI','SN','EG'];
						
			?>
				
				
				<form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				
				<div class="titlebar app_redac">
					<div class="toolbar">
						<a href="<?php echo SITE_URL_ADMIN; ?>" title="Fermer">Fermer</a>
					</div>
					
					<h2>Gestion des profils<br /> (H: <?php echo $stats['papas']; ?>% / F: <?php echo $stats['mamans']; ?>%)</h2>
					
				</div>
				<br />
				<?php if (is_array($messages)) { ?>
						<div class="messages">
							<?php JL::messages($messages); ?>
						</div>
						<br />
				<?php } ?>
				<div class="tableAdmin">
					<div class="filtre">
						<table class="table table-bordered table-striped table-condensed cf">
							<tr>
								<td><b>Recherche:</b></td>
								<td><input type="text" name="search_word" id="search_word" value="<?php echo makeSafe($search['word']); ?>" class="searchInput" /></td>
								<td><b>Profil Helvetica:</b></td>
								<td><?php echo $lists['helvetica']; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td><b>Tri par:</b></td>
								<td><?php echo $lists['order']; ?></td>
								<td><b>Statut:</b></td>
								<td> <?php echo $lists['confirmed']; ?></td>
							</tr>
							<tr>
								<td><b>Ordre:</b></td>
								<td><?php echo $lists['ascdesc']; ?></td>
								<td><b>Genre:</b></td>
								<td><?php echo $lists['genre']; ?></td>
							</tr>
							<tr>
								<td><b>Abonnement:</b></td>
								<td><?php echo $lists['abonnement']; ?></td>
							</tr>
							<tr>
								<td colspan="4" align="right"><a href="javascript:document.listForm.submit();" class="bouton envoyer">Rechercher</a></td>
							</tr>
						</table>
					</div>	
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
											
						<?php if (is_array($users)) { ?>
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
						<?php 						foreach($users as $user) {
						
							// htmlentities
							JL::makeSafe($user);
							
							// var locales
							$warning 	= false;

							if($user->gold_limit_date != '1970-01-01') {
							
								$userTime				= strtotime((string) $user->gold_limit_date);
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

							
							// v�rif t�l�phone
							if($jours < 500 && !preg_match('/^0?[0-9]{9}$/', preg_replace('/[^0-9]/','', (string) $user->telephone_origine))) {
								$colorPhone = 'orange';
								$warning = true;
							} else {
								$colorPhone = '';
							}
							

							// v�rif pays
							$pays			= $user->ip_pays;
							
							// si le profil s'est connect� depuis un pays accept�
							if(in_array($pays, $paysVert)) {
							
								$colorPays = 'green';

							} elseif(in_array($pays, $paysGris)) { // sinon s'il s'est connect� depuis un pays tol�r�
							
								$colorPays = 'grey';
							
							} elseif(in_array($pays, $paysRouge)) { // sinon s'il s'est connect� depuis un pays interdit
							
								$colorPays = 'red';
								$warning = true;
								
							} else { // pays inconnu
							
								$colorPays = 'orange';
								$warning = true;
								
							}
							
							
							// v�rif nom
							if($jours < 500 && strlen((string) $user->nom_origine) < 3) {
								$colorNom = 'orange';
								$warning = true;
							} else {
								$colorNom = '';
							}
							
						?>
							<tr class="list<?php if($jours > 0 && $jours <= 3) { ?> jours3<?php } ?><?php if($warning) { ?> warning<?php } ?>" >
								<td align="center"><input type="checkbox" name="id[]" value="<?php echo $user->id; ?>" id="user_<?php echo $user->id; ?>"></td>
								<td>
									<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil_suppr&action=editer&id=<?php echo $user->id; ?>" title="Modifier le profil de <?php echo $user->username; ?>"><?php echo $user->username; ?></a><br />
									<span style="font-size:10px;font-style:italic;"><?php echo $user->points_total; ?> pts</span>
								</td>
								<td align="center"><img src="images/<?php echo $user->genre; ?>.png" alt="<?php echo $user->genre == 'h' ? 'Homme' : 'Femme'; ?>" /></td>
								<td align="center">
								<?php /*
								<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=<?php echo $user->published ? 'desactiver' : 'activer'; ?>&id[]=<?php echo $user->id; ?>" title="Cliquez pour <?php echo $user->published ? 'd&eacute;sactiver' : 'activer'; ?> le profil de <?php echo $user->username; ?>">
								*/ ?>
								<img src="images/<?php echo $user->published; ?>.png" alt="<?php echo $user->published ? 'Oui' : 'Non'; ?>" />
								<?php /*
								</a>
								*/ ?>
								</td>
								<td align="center"><img src="images/<?php echo $user->confirmed; ?>.png" alt="" /></td>
								<td><?php echo $user->abonnement; ?></td>
								
								<?php if($user->helvetica == 1) { ?>
								
									<td colspan="4">
										<img src="<?php echo SITE_URL_ADMIN; ?>/images/helvetica.jpg" alt="" />
									</td>
									
								<?php } else { ?>
								
									<td style="color: <?php echo $colorNom; ?>;"><?php echo $user->nom_origine; ?></td>
									<td><?php echo $user->prenom_origine; ?></td>
									<td style="color: <?php echo $colorPhone; ?>;">
										<?php echo str_starts_with((string) $user->telephone_origine, '0') ? $user->telephone_origine : '0'.$user->telephone_origine; ?>
									</td>
									<td>
									<?php 										// date d'appel
										if($user->appel_date != '1970-01-01') {
										
											$userTime	= strtotime((string) $user->appel_date);
											echo date('d/m/Y', $userTime);
										
										}
										
										// date d'appel 2
										if($user->appel_date2 != '1970-01-01') {
										
											$userTime	= strtotime((string) $user->appel_date2);
											echo '<br /><span style="font-size:10px;color:#aaa;">+ '.date('d/m/Y', $userTime).'</span>';
										
										}
									?>
									</td>
									
								<?php } ?>
								
								<td style="color:<?php echo $colorPays; ?>; font-weight:bold; text-align: center;">
									<?php echo str_replace('XX', '?', $pays); ?>
								</td>
							</tr>
						<?php 						} ?>
					
						<tr>
							<td colspan="<?php echo $tdParTr; ?>">
								<b>Pages</b>:
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil_suppr&search_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil_suppr&search_page='.$i); ?>" title="Afficher la page <?php echo $i; ?>" <?php if($i == $search['page']) { ?>class="displayActive"<?php } ?>><?php echo $i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil_suppr&search_page='.$search['page_total']); ?>" title="Afficher la page <?php echo $search['page_total']; ?>">Fin</a><?php }?> <i>(<?php echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
					<?php } else { ?>
						<tr>
							<th colspan="<?php echo $tdParTr; ?>">Aucun profil ne correspond &agrave; votre recherche.</th>
						</tr>
					<?php } ?>
					</table>
				</div>
					<input type="hidden" name="search_page" value="1" />
					<input type="hidden" name="app" value="profil_suppr" />
					<input type="hidden" name="action" value="" />
				</form>
			<?php 		}
		
		
		
		
		// formlaire d'�dition d'un profil
		public static function profilEditer(&$userObj, &$messages, &$points) {
			
			// htmlentities
			JL::makeSafe($userObj);
			
			// variables
			$photos	= [];
			
			// r�cup les photos de l'utilisateur, autres que celle par d�faut
			$dir	= '../images/profil/'.$userObj->id;
			if(is_dir($dir)) {
			
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {
					
					// r�cup les miniatures de photos valid�es
					if(preg_match('/^parent-solo-109/', $file)) {
						
						$photos[]	= $file;
						
					}
					
				}
				
			}
			
			?>
			
			
				<div class="titlebar app_user">
					<div class="toolbar">
						<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil_suppr" title="Fermer" class="cancel">Fermer</a>
					</div>
					
					<h2>Profil : <?php echo $userObj->username; ?></h2>
				</div>
				<br />
				<?php if (is_array($messages)) { ?>
						<div class="messages">
							<?php JL::messages($messages); ?>
						</div>
						<br />
				<?php } ?>
				<div class="tableAdmin">
					<h3>Donn&eacute;es inscription</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key" width="200px">Pseudo:</td>
							<td width="250px"><?php echo $userObj->username; ?></td>
						</tr>
						<tr>
							<td class="key" width="200px">Genre:</td>
							<td><img src="images/<?php echo $userObj->genre; ?>.png" alt="<?php echo $userObj->genre == 'h' ? 'Homme' : 'Femme'; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Profil Helvetica:</td>
							<td><?php if($userObj->helvetica) { ?> Oui <?php }else{ ?>Non <?php } ?>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td class="key">Langue d'appel:</td>
							<td>
								<?php switch($userObj->langue_appel){
									case 1: echo "Fran&ccedil;ais"; break;
									case 2: echo "Anglais"; break;
									case 3: echo "Allemand"; break;
									default: echo "Non renseign�e";break;
								}?>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td class="key">Email:</td>
							<td><a href="mailto:<?php echo $userObj->email; ?>" title="Envoyer un email &agrave; <?php echo $userObj->username; ?>"><?php echo $userObj->email; ?></a></td>
						</tr>
						<tr>
							<td class="key">Nom:</td>
							<td><?php echo $userObj->nom_origine; ?></td>
							<td><i><?php echo $userObj->nom; ?></i></td>
						</tr>
						<tr>
							<td class="key">Pr&eacute;nom:</td>
							<td><?php echo $userObj->prenom_origine; ?></td>
							<td><i><?php echo $userObj->prenom; ?></i></td>
						</tr>
						<tr>
							<td class="key">T&eacute;l&eacute;phone:</td>
							<td><?php echo $userObj->telephone_origine; ?></td>
							<td><i><?php echo $userObj->telephone; ?></i></td>
						</tr>
						<tr>
							<td class="key">Adresse:</td>
							<td><?php echo $userObj->adresse_origine; ?></td>
							<td><i><?php echo $userObj->adresse; ?></i></td>
						</tr>
						<tr>
							<td class="key">Code postal:</td>
							<td><?php echo $userObj->code_postal_origine; ?></td>
							<td><i><?php echo $userObj->code_postal; ?></i></td>
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
							<td><?php echo $userObj->gold_limit_date != '1970-01-01' ? date('d/m/Y', strtotime((string) $userObj->gold_limit_date)) : ''; ?></td>
						</tr>
						<tr>
							<td class="key">Points actuels:</td>
							<td>
								<?php echo $userObj->points_total; ?>
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
							<?php 								foreach($photos as $photo) {
								?>
									<div class="profilPhoto">
										<i><?php echo preg_replace('/^parent\-solo\-109\-(.*)\-[1-9].jpg$/', '$1', $photo); ?></i><br />
										<label for="<?php echo $photo; ?>"><img src="<?php echo SITE_URL; ?>/images/profil/<?php echo $userObj->id; ?>/<?php echo $photo; ?>" alt="" /></label>
									</div>
								<?php 								}
							?>
							</td>
						</tr>
						<tr>
							<td class="key">Annonce publi&eacute;e:</td>
							<td><?php echo nl2br((string) $userObj->annonce_valide); ?></td>
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
								<?php echo date('d/m/Y', strtotime((string) $userObj->creation_date)); ?>
							</td>
						</tr>
						<tr>
							<td class="key">Paiement en ligne:</td>
							<td>
								<?php echo $userObj->abonnement_carte ? date('d/m/Y', strtotime((string) $userObj->abonnement_carte)).' - '.$userObj->abonnement_carte_nom.' '.$userObj->abonnement_carte_prenom.' - '.($userObj->abonnement_carte_valide==1 ? 'en cours' : 'annul&eacute;' ) : '-'; ?>
							</td>
						</tr>
						<tr>
							<td class="key">1er appel:</td>
							<td><?php echo $userObj->appel_date != '1970-01-01' ? date('d/m/Y', strtotime((string) $userObj->appel_date)) : ''; ?></td>
						</tr>
						<tr>
							<td class="key">2&egrave;me appel:</td>
							<td><?php echo $userObj->appel_date2 != '1970-01-01' ? date('d/m/Y', strtotime((string) $userObj->appel_date2)) : ''; ?></td>
						</tr>
						<tr>
							<td class="key">Commentaire:</td>
							<td><?php echo nl2br((string) $userObj->commentaire); ?></textarea></td>
						</tr>
					</table>
				</div>
				
			<?php 		}
		
	}
?>

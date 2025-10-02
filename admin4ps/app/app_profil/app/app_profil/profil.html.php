<?php

	// scurit
	defined('JL') or die('Error 401');
	
	class profil_HTML {	
		
		// liste les profils
		public static function profilLister(&$users, &$search, &$lists, &$messages, &$stats) {
		
			// variables
			$i 				= 0; // compteur de tr
			$td 			= 0; // compteur de td
			$tdParTr		= 11; // nombre de td par ligne
			$rayon 			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
						
			// pays contrls
			$paysVert		= ['CH'];
			$paysGris		= ['XX'];
			$paysRouge		= ['CI','SN','EG'];
						
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
						
							window.location.href = "<?php echo SITE_URL_ADMIN; ?>"; 
						}
						
					}
				</script>
				
				<form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                      <h2>Gestion des profils <i>(H: <?php echo $stats['papas']; ?>% / F: <?php echo $stats['mamans']; ?>%)</i></h2>
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
				<?php if (is_array($messages)) { ?>
						<div class="messages">
							<?php JL::messages($messages); ?>
						</div>
						<br />
				<?php } ?>
				<div class="tableAdmin">
					<div class="filtre">
						<table class="table table-bordered table-striped  cf">
							<tr>
								<td><b>Recherche:</b></td>
								<td><input type="text" name="search_word" id="search_word" value="<?php echo makeSafe($search['word']); ?>" class="searchInput" /></td>
								<td><b>Profil Helvetica:</b></td>
								<td><?php echo $lists['helvetica']; ?></td>
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
								<td colspan="3"><?php echo $lists['abonnement']; ?></td>
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

							
							// vrif tlphone
							if($jours < 500 && !preg_match('/^0?[0-9]{9}$/', preg_replace('/[^0-9]/','', (string) $user->telephone_origine))) {
								$colorPhone = 'orange';
								$warning = true;
							} else {
								$colorPhone = '';
							}
							

							// vrif pays
							$pays			= $user->ip_pays;
							
							// si le profil s'est connect depuis un pays accept
							if(in_array($pays, $paysVert)) {
							
								$colorPays = 'green';

							} elseif(in_array($pays, $paysGris)) { // sinon s'il s'est connect depuis un pays tol
							
								$colorPays = 'grey';
							
							} elseif(in_array($pays, $paysRouge)) { // sinon s'il s'est connect depuis un pays interdit
							
								$colorPays = 'red';
								$warning = true;
								
							} else { // pays inconnu
							
								$colorPays = 'orange';
								$warning = true;
								
							}
							
							
							// vrif nom
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
									<a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=editer&id=<?php echo $user->id; ?>" title="Modifier le profil de <?php echo $user->username; ?>"><?php echo $user->username; ?></a><br />
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
								
								<?php if($user->helvetica == 1) { 
									
								?>
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
							<?php if($user->helvetica == 1) { 
									$photos	= [];
			
									// rcup les photos de l'utilisateur, autres que celle par dfaut
									$dir	= '../images/profil/'.$user->id;
									if(is_dir($dir)) {
									
										$dir_id 	= opendir($dir);
										while($file = trim(readdir($dir_id))) {
											
											// rcup les miniatures de photos valides
											if(preg_match('/^parent-solo-109/', $file)) {
												
												$photos[]	= $file;
												
											}
											
										}
										
									}
								?>
							<tr class="list_photos<?php if($jours > 0 && $jours <= 3) { ?> jours3<?php } ?><?php if($warning) { ?> warning<?php } ?>" >
								<td colspan="11">
									<?php 											foreach($photos as $photo) {
											?>
												<div class="profilPhoto">
													<img src="<?php echo SITE_URL; ?>/images/profil/<?php echo $user->id; ?>/<?php echo $photo; ?>" alt="" />
												</div>
											<?php 											}
										?>
								</td>
							</tr>
							
						<?php 							}
						} ?>
					
						<tr>
							<td colspan="<?php echo $tdParTr; ?>">
								<b>Pages</b>:
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil&search_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil&search_page='.$i); ?>" title="Afficher la page <?php echo $i; ?>" <?php if($i == $search['page']) { ?>class="displayActive"<?php } ?>><?php echo $i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=profil&search_page='.$search['page_total']); ?>" title="Afficher la page <?php echo $search['page_total']; ?>">Fin</a><?php }?> <i>(<?php echo $search['result_total']; ?> r&eacute;sultats)</i>
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
					<input type="hidden" name="app" value="profil" />
					<input type="hidden" name="action" value="" />
				</section>
				</form>
			<?php 		}
	
		public static function photoLister(&$users, &$messages) {
			
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
						
							window.location.href = "<?php echo SITE_URL_ADMIN; ?>"; 
						}
						
					}
				</script>
				
				<form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
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
				
				<?php if (is_array($messages)) { ?>
						<div class="messages">
							<?php JL::messages($messages); ?>
						</div>
						<br />
				<?php } ?>
				<div class="tableAdmin">
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
						<?php if (is_array($users)) { ?>
						<tr>
							<th colspan="<?php echo $tdParTr; ?>">Photos en attente de validation</th>
						</tr>
						<?php 						foreach($users as $user) {
							if (is_array($user->photos)) {
								foreach($user->photos as $photo) {
									
									// limite de photos par page atteinte
									if($photoTotal >= $photoLimite) {
										continue;
									}
									
									if($td%$tdParTr == 0) {
									?>
									<tr class="list">
									<?php 									}
									?>
										<td>
											<label for="<?php echo $user->user_id; ?>_<?php echo $photo; ?>"><img src="<?php echo SITE_URL; ?>/images/profil/<?php echo $user->user_id; ?>/pending-parent-solo-<?php echo $photo; ?>.jpg?<?php echo time(); ?>" /><br />
											<input type="checkbox" checked="true" name="photo[]" value="<?php echo $user->user_id; ?>_<?php echo $photo; ?>" id="<?php echo $user->user_id; ?>_<?php echo $photo; ?>"> <?php echo $user->username.' '.$photo; ?></label>
										</td>
									<?php 									if($td%$tdParTr == $tdParTr-1) {
									?>
									</tr>
									<?php 									}
									
									$td++;
									$photoTotal++;
								}
								
							}
						}
					
								// nombre de cases pas rond
								if($photoTotal%$tdParTr != $tdParTr-1) {
								?>
									</tr>
								<?php 								}
					 } else { ?>
						<tr>
							<th>Aucune photo en attente de validation.</th>
						</tr>
					<?php } ?>
					</table>
					</div>
					<input type="hidden" name="app" value="profil" />
					<input type="hidden" name="action" value="photo_validation_submit" />
					<input type="hidden" name="task" value="" />
				</section>
				</form>
			<?php 		}
		
		
		// liste les textes  valider
		public static function texteLister(&$textes, &$messages) {
			
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
						
							window.location.href = "<?php echo SITE_URL_ADMIN; ?>"; 
						}
						
					}
				</script>
				
				<form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
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
				<?php if (is_array($messages)) { ?>
						<div class="messages">
							<?php JL::messages($messages); ?>
						</div>
						<br/>
				<?php } ?>
				<div class="tableAdmin">
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
					
						
						
						<?php if (is_array($textes)) {
							$i 				= 0; // compteur de tr
							$texteTotal		= 0; // compteur de textes
							$texteLimite	= 10; // nombre de textes par page
							
							?>
							<tr>
								<th>Textes en attente de validation</th>
							</tr>
							<?php 							foreach($textes as $texte) {
								
								// limite de textes par page atteinte
								if($texteTotal >= $texteLimite) {
									continue;
								}
							?>
								<tr class="list">
									<td>
										<input type="checkbox" checked="true" name="texte[]" value="<?php echo $texte->user_id; ?>" id="texte<?php echo $texte->user_id; ?>"> <label for="texte<?php echo $texte->user_id; ?>"><b><?php echo $texte->username; ?>:</b></label><br /><br />
										<div><textarea name="annonce<?php echo $texte->user_id; ?>" rows="10" cols="92"><?php echo makeSafe($texte->annonce); ?></textarea></div>
									</td>
								</tr>
								<?php 								$texteTotal++;
							}
							?>
					<?php } else { ?>
						<tr>
							<th>Aucun texte en attente de validation.</th>
						</tr>
					<?php } ?>
					</table>
				</div>
					<input type="hidden" name="app" value="profil" />
					<input type="hidden" name="action" value="texte_validation_submit" />
					<input type="hidden" name="task" value="" />
				</section>
				</form>
			<?php 		}
		
		
		// formlaire dtion d'un profil
		public static function profilEditer(&$userObj, &$messages, &$points) {
			
			// htmlentities
			JL::makeSafe($userObj);
			
			// variables
			$photos	= [];
			
			// rp les photos de l'utilisateur, autres que celle par dut
			$dir	= '../images/profil/'.$userObj->id;
			if(is_dir($dir)) {
			
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {
					
					// rp les miniatures de photos valid
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
						
							window.location.href = "<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil"; 
						}
						
					}
				</script>
			<form name="editForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                      <h2>Profil : <?php echo $userObj->username; ?></h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="save btn btn-success" >Sauver</a>
						<a href="javascript:cancelsubmit('Annuler')" title="Annuler" class="cancel btn btn-success" >Annuler</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="cancel btn btn-success" >Fermer</a>
					</div></div>
				</div>
				
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
							<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=user&action=editer&id=<?php echo $userObj->id; ?>"><i>(modifier)</i></a></td>
						</tr>
						<tr>
							<td class="key" width="200px">Genre:</td>
							<td><img src="images/<?php echo $userObj->genre; ?>.png" alt="<?php echo $userObj->genre == 'h' ? 'Homme' : 'Femme'; ?>" /></td>
						</tr>
						<tr>
							<td class="key">Profil Helvetica:</td>
							<td><input type="radio" id="helvetica1" name="helvetica" value="1" <?php if($userObj->helvetica) { ?>checked<?php } ?> /> <label for="helvetica1">Oui</label>&nbsp;<input type="radio" id="helvetica0" name="helvetica" value="0" <?php if(!$userObj->helvetica) { ?>checked<?php } ?> /> <label for="helvetica0">Non</label></td>
						</tr>
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
									default: echo "Non renseignée";break;
								}?>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td class="key">Email:</td>
							<td><a href="mailto:<?php echo $userObj->email; ?>" title="Envoyer un email &agrave; <?php echo $userObj->username; ?>"><?php echo $userObj->email; ?></a></td>
							<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=user&action=editer&id=<?php echo $userObj->id; ?>"><i>(modifier)</i></a></td>
						</tr>
						<tr>
							<td class="key">Nom:</td>
							<td><input type="text" name="nom" value="<?php echo $userObj->nom_origine; ?>" /></td>
							<td><i><?php echo $userObj->nom; ?></i></td>
						</tr>
						<tr>
							<td class="key">Pr&eacute;nom:</td>
							<td><input type="text" name="prenom" value="<?php echo $userObj->prenom_origine; ?>" /></td>
							<td><i><?php echo $userObj->prenom; ?></i></td>
						</tr>
						<tr>
							<td class="key">T&eacute;l&eacute;phone:</td>
							<td><input type="text" name="telephone" value="<?php echo $userObj->telephone_origine; ?>" /></td>
							<td><i><?php echo $userObj->telephone; ?></i></td>
						</tr>
						<tr>
							<td class="key">Adresse:</td>
							<td><input type="text" name="adresse" value="<?php echo $userObj->adresse_origine; ?>" /></td>
							<td><i><?php echo $userObj->adresse; ?></i></td>
						</tr>
						<tr>
							<td class="key">Code postal:</td>
							<td><input type="text" name="code_postal" value="<?php echo $userObj->code_postal_origine; ?>" /></td>
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
							<td><input type="text" name="gold_limit_date" value="<?php echo $userObj->gold_limit_date != '1970-01-01' ? date('d/m/Y', strtotime((string) $userObj->gold_limit_date)) : ''; ?>" size="9" /> <i>(jj/mm/aaaa)</i></td>
						</tr>
						<tr>
							<td class="key">Cr&eacute;diter abonnement:</td>
							<td><input type="text" name="abonnement_crediter" value="0" size="9" /> <i>jours</i></td>
						</tr>
						<tr>
							<td class="key">Points actuels:</td>
							<td>
								<?php echo $userObj->points_total; ?>
							</td>
						</tr>
						<tr>
							<td class="key">Cr&eacute;diter points</td>
							<td>
							<?php 								// s'il y a des points ter
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
									<?php 									
										// pour chaque point
										foreach($points as $point) {
										
											// html ent
											JL::makeSafe($point);
										
										?>
											<tr>
												<td><input type="radio" name="points_id" id="points_id_<?php echo $point->id; ?>" value="<?php echo $point->id; ?>" /></td>
												<td><label for="points_id_<?php echo $point->id; ?>"><?php echo $point->nom; ?></label></td>
												<td>+<?php echo $point->points; ?></td>
											</tr>
										<?php 										}
									
									?>
								</table>
								<?php 								}
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
							<?php 								foreach($photos as $photo) {
								?>
									<div class="profilPhoto">
										<i><?php echo preg_replace('/^parent\-solo\-109\-(.*)\-[1-9].jpg$/', '$1', $photo); ?></i><br />
										<label for="<?php echo $photo; ?>"><img src="<?php echo SITE_URL; ?>/images/profil/<?php echo $userObj->id; ?>/<?php echo $photo; ?>" alt="" /></label><br />
										<input type="checkbox" name="photo[]" value="<?php echo $photo; ?>" id="<?php echo $photo; ?>" /> <label for="<?php echo $photo; ?>">Supprimer</label>
									</div>
								<?php 								}
							?>
							</td>
						</tr>
						<tr>
							<td class="key">Annonce publi&eacute;e:</td>
							<td><textarea name="annonce_valide" rows="5" cols="50"><?php echo $userObj->annonce_valide; ?></textarea></td>
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
							<td class="key">Confirm&eacute;:</td>
							<td>
								<div class="statut statut0"><input type="radio" name="confirmed" value="0" id="confirmed0" <?php if($userObj->confirmed == 0) { ?>checked="true"<?php } ?> /> <label for="confirmed0" style="cursor:pointer;">Non</label></div>
								<div class="statut statut1"><input type="radio" name="confirmed" value="1" id="confirmed1" <?php if($userObj->confirmed == 1) { ?>checked="true"<?php } ?> /> <label for="confirmed1" style="cursor:pointer;">Oui</label></div>
								<div class="statut statut2"><input type="radio" name="confirmed" value="2" id="confirmed2" <?php if($userObj->confirmed == 2) { ?>checked="true"<?php } ?> /> <label for="confirmed2" style="cursor:pointer;">En attente</label></div>
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
							<td><input type="text" name="appel_date" value="<?php echo $userObj->appel_date != '1970-01-01' ? date('d/m/Y', strtotime((string) $userObj->appel_date)) : ''; ?>" size="9" /> <i>(jj/mm/aaaa)</i></td>
						</tr>
						<tr>
							<td class="key">2&egrave;me appel:</td>
							<td><input type="text" name="appel_date2" value="<?php echo $userObj->appel_date2 != '1970-01-01' ? date('d/m/Y', strtotime((string) $userObj->appel_date2)) : ''; ?>" size="9" /> <i>(jj/mm/aaaa)</i></td>
						</tr>
						<tr>
							<td class="key">Commentaire:</td>
							<td><textarea name="commentaire" rows="5" cols="50"><?php echo $userObj->commentaire; ?></textarea></td>
						</tr>
					</table>
				</div>
				
				<input type="hidden" name="id" value="<?php echo $userObj->id; ?>" />
				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="save" />
				</section>
			</form>
			<?php 		}
		
	}
?>

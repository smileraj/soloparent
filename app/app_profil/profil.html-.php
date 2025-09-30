<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	class HTML_profil {
		public $lang_appprofil;

		// affichage des messages syst&egrave;me
		function HTML_profil() {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			$this->lang_appprofil=$lang_appprofil;
		}
		function messages(&$messages) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			// s'il y a des messages &agrave; afficher
			if (is_array($messages)) {
			?>
				<h2><?php echo $lang_appprofil["MessagesParentSolo"];?></h2>
				<div class="messages">
				<?php 					// affiche les messages
					JL::messages($messages);
				?>
				</div>
			<?php 			}

		}


		// reset du mdp
		function mdp(&$row, &$messages) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			// htmlentities
			JL::makeSafe($row);

			?>
			<div class="app_body">
				<div class="contenu">
					<h1><?php echo $lang_appprofil["MotDePasseOublie"];?> ?</h1>
					<b><?php echo $lang_appprofil["VousPouvezReinitialiser"];?>.</b><br />
					<br />
					<?php echo $lang_appprofil["PourCeFaire"];?> <span class="mdp"><?php echo $lang_appprofil["AdressseEmail"];?></span> <?php echo $lang_appprofil["AvecLaquelleVous"];?> <b><?php echo $lang_appprofil["Inscrit"];?></b>.<br />
					<br />
					<?php echo $lang_appprofil["EnsuiteChoisissez"];?> <span class="mdp"><?php echo $lang_appprofil["NouveauMotPAsse"];?></span>, <?php echo $lang_appprofil["InscrivezDansDeuxCases"];?>.<br />
					<br />
					<?php echo $lang_appprofil["VousReceverez"];?> <span class="mdp"><?php echo $lang_appprofil["ConfirmationParEmail"];?></span>.<br />
					<?php echo $lang_appprofil["CliquezSurLeLien"];?>.<br />
					<br />
					<?php echo $lang_appprofil["VousPourrez"];?> <span class="mdp"><?php echo $lang_appprofil["EnsuiteVousConnectez"];?></span> <?php echo $lang_appprofil["AvecVotreNouveau"];?> !

				<?php 
					// s'il y a des messages &agrave; afficher
					if (is_array($messages)) {
					?>
						<div class="messages" style="margin: 20px 0 20px 0;">
						<?php 							// affiche les messages
							JL::messages($messages);
						?>
						</div>
					<?php 					}
				?>

				<form action="<?php echo JL::url(SITE_URL.'/index.php?app=profil&action=mdp'.'&'.$langue); ?>" name="mdpForm" method="post">
					<input type="hidden" name="captchaMd5" value="<?php echo $row->captchaMd5; ?>" />
					<input type="hidden" name="save" value="1" />

					<fieldset class="membre">
					<legend><?php echo $lang_appprofil["ChangerMonMotPasse"];?></legend>
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td class="key">
								<label for="email"><?php echo $lang_appprofil["EmailInscription"];?></label>
							</td>
							<td>
								<input type="text" name="email" id="email" value="<?php echo $row->email; ?>" class="inputtext" /> *
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password"><u><?php echo $lang_appprofil["Nouveau"];?></u> <?php echo $lang_appprofil["MotDePasse"];?></label>
							</td>
							<td>
								<input type="password" name="password" id="password" value="" class="inputtext" /> *
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password2"><u><?php echo $lang_appprofil["Nouveau"];?></u> <?php echo $lang_appprofil["MotDePasse"];?></label>
							</td>
							<td>
								<input type="password" name="password2" id="password2" value="" class="inputtext" /> * <i>(<?php echo $lang_appprofil["Confirmation"];?>)</i>
							</td>
						</tr>
						<tr>
							<td></td>
							<td class="notice">
								* <?php echo $lang_appprofil["LesChampsMarques"];?>
							</td>
						</tr>
					</table>
					</fieldset>

					<fieldset class="membre">
					<legend><?php echo $lang_appprofil["CodeDeSecurite"];?></legend>
						<b><?php echo $lang_appprofil["CombienDeFleurs"];?> ?</b><br />
						<br />
						<?php 						for($i=0;$i<$row->captcha;$i++){
						?>
							<img src="parentsolo/images/flower.jpg" alt="Fleur" align="left" />
						<?php 						}
						?>
						&nbsp;=&nbsp;<input type="text" name="verif" id="codesecurite" value="" maxlength="1" />
					</fieldset>

					<table cellpadding="0" cellspacing="0">
						<tr>
							<td><a href="<?php echo $user->id ? JL::url('index.php?app=profil&action=panel'.'&'.$langue) : JL::url('index.php'.'?'.$langue); ?>" class="bouton return_home" style="margin:0;"><?php echo $lang_appprofil["RetourAccueil"];?></a></td>
							<td><a href="javascript:document.mdpForm.submit();" class="bouton envoyer"><?php echo $lang_appprofil["Envoyer"];?></a></td>
						</tr>
					</table>

				</form>

				</div>
			</div> <?php // fin app_body ?>
			<?php 
				// colonne de gauche
				JL::loadMod('profil_panel');

			?>
			<div class="clear"> </div>
		<?php 		}


		// confirmation de changement de mot de passe
		function mdpChanged() {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;
			?>
			<div class="app_body">
				<div class="contenu">
					<h1><?php echo $lang_appprofil["MotDePasseChanger"];?> !</h1>
					<?php echo $lang_appprofil["VotreMotPasseChange"];?> !<br />
					<br />
					<?php echo $lang_appprofil["VousPouvezDesPresent"];?> <b><?php echo $lang_appprofil["NouveauIdentifiants"];?></b> (<?php echo $lang_appprofil["IndiquesDansEmail"];?>).<br />
					<br />
					<?php echo $lang_appprofil["ABientotSurParentsolo"];?> !

					<a href="<?php echo $user->id ? JL::url('index.php?app=profil&action=panel'.'&'.$langue) : JL::url('index.php'.'?'.$langue); ?>" class="bouton return_home"><?php echo $lang_appprofil["RetourAccueil"];?></a>
				</div>
			</div> <?php // fin app_body ?>
			<?php 
			// colonne de gauche
			JL::loadMod('profil_panel');

		?>
		<div class="clear"> </div>
		<?php 		}


		// confirmation de changement non valide
		function mdpError() {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;
			?>
			<div class="app_body">

				<div class="contenu">
					<h1><?php echo $lang_appprofil["MotDePasseNonChanger"];?> !</h1>
					<?php echo $lang_appprofil["VotreMotPasseNonChange"];?> !<br />
					<br />
					<?php echo $lang_appprofil["LienSurLequelVousClique"];?>.<br />
					<?php echo $lang_appprofil["VeuillezRecommencer"];?> <a href="<?php echo JL::url('index.php?app=profil&action=mdp'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["VousMotDePasseOublie"];?>"><?php echo $lang_appprofil["ChangementMotDePasse"];?></a>.<br />
					<br />
					<?php echo $lang_appprofil["ABientotSurParentsolo"];?> !

					<a href="<?php echo $user->id ? JL::url('index.php?app=profil&action=panel'.'&'.$langue) : JL::url('index.php'.'?'.$langue); ?>" class="bouton return_home"><?php echo $lang_appprofil["RetourAccueil"];?></a>
				</div>

			</div> <?php // fin app_body ?>
			<?php 
			// colonne de gauche
			JL::loadMod('profil_panel');

		?>
		<div class="clear"> </div>
		<?php 		}


		// page 'mon compte'
		function panel(&$profilsOnline, &$profilsInscrits, $genreRecherche, &$list, &$appel_a_temoins, &$temoignage) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");

			// limitation appel &agrave; t&eacute;moins
			$annonceLimite	= 125;
			if(strlen((string) $appel_a_temoins->annonce) > $annonceLimite) {
				$appel_a_temoins->annonce = substr((string) $appel_a_temoins->annonce, 0, $annonceLimite).'...';
			}

			// limitation t&eacute;moignage
			$annonceLimite	= 125;
			if(strlen((string) $temoignage->texte) > $annonceLimite) {
				$temoignage->texte = substr((string) $temoignage->texte, 0, $annonceLimite).'...';
			}

			// htmlentities
			JL::makeSafe($appel_a_temoins);
			JL::makeSafe($temoignage);

			?>
			<div class="app_body">

				<div class="panel_left">

					<div class="recherche">
						<form name="search" action="<?php echo JL::url(SITE_URL.'/index.php?'.$langue); ?>" method="post">
							<div class="titre">&raquo; <?php echo $lang_appprofil["RechercheRapide"];?> &laquo;</div>
							<div class="texte">
								<?php echo $lang_appprofil["JeRecherche"];?> <span class="orange"><?php echo $genreRecherche == 'h' ? $lang_appprofil["UnPapa"] : $lang_appprofil["UneMaman"]; ?></span> <?php echo $lang_appprofil["De"];?> <?php echo $list['search_recherche_age_min']; ?> <?php echo $lang_appprofil["A"];?> <?php echo $list['search_recherche_age_max']; ?> <?php echo $lang_appprofil["Ans"];?>.<br />
								<br />
								<?php echo $genreRecherche == 'h' ? $lang_appprofil["Il"] : $lang_appprofil["Elle"]; ?> <?php echo $lang_appprofil["HabiteDansLeCanton"];?> <?php echo $list['search_canton_id']; ?> <?php echo $lang_appprofil["A"];?> <span id="villes"><?php echo $list['search_ville_id']; ?></span><br />
								<br />
								<?php echo $lang_appprofil["Avec"];?> <?php echo $list['search_nb_enfants']; ?> <?php echo $lang_appprofil["Enfants_s"];?>.<br />
								<br />
								<input type="checkbox" name="search_online" id="search_online" /> <label for="search_online"><?php echo $genreRecherche == 'h' ? $lang_appprofil["Il"] : $lang_appprofil["Elle"];; ?> <?php echo $lang_appprofil["EstEnLignes"];?></label>.
							</div>
							<?php
											if ($_GET["lang"]!="fr") {
					//echo $_GET["lang"];
					$jsUpExt = "-".$_GET["lang"];
				} else {
					$jsUpExt = "";
				}

							?>
							<input type="image" src="<?php echo SITE_URL; ?>/parentsolo/images/lancer-recherche<?php echo$jsUpExt ;?>.jpg" class="btnRecherche" />

							<input type="hidden" name="search_display" value="0" />
							<input type="hidden" name="app" value="search" />
							<input type="hidden" name="action" value="searchsubmit" />
							<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
						</form>
					</div>


					<h2><?php echo $genreRecherche == 'h' ? $lang_appprofil["PAPAS_S"] : $lang_appprofil["MAMANS_S"]; ?> <?php echo $lang_appprofil["ENLIGNERECEMENT"];?></h2>
					<div class="preview4">
					<?php 						if(is_array($profilsOnline)) {
							foreach($profilsOnline as $row) {
								JL::makeSafe($row);

								// r&eacute;cup la photo de l'utilisateur
								$photo = JL::userGetPhoto($row->id, '89', 'profil', $row->photo_defaut);

								?>
									<div class="preview">
										<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["VoirProfilDe"];?> <?php echo $row->username; ?>">
										<?php 											if($photo) {
											?>
												<img src="<?php echo $photo; ?>" alt="" />
											<?php 											} else {
											?>
												<img src="<?php echo SITE_URL; ?>/parentsolo/images/parent-solo-89-<?php echo $row->genre; ?>.jpg" alt="" />
											<?php 											}
										?>
										</a>
										<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["VoirProfilDe"];?> <?php echo $row->username; ?>" class="desc">
											<span class="pink"><?php echo $row->username; ?></span><br />
											<?php echo $row->age; ?> <?php echo $lang_appprofil["Ans"];?><br />
											<?php echo $row->nb_enfants; ?> <?php echo $row->nb_enfants > 1 ? $lang_appprofil["enfants_s"] : $lang_appprofil["enfant_s"]; ?><br />
										</a>
									</div>
								<?php 							}
							?>
							<a href="<?php echo JL::url('index.php?app=search&action=results&search_online=1'.'&'.$langue); ?>" class="more" title="<?php echo $lang_appprofil["VoirPlusDe"];?> <?php echo $genreRecherche == 'h' ? $lang_appprofil["NouveauxPapa"] : $lang_appprofil["NouvelleMamans"]; ?> <?php echo $lang_appprofil["EnLigneActuellement"];?>"> </a>
						<?php 						}
					?>
					</div>

					<h2><?php echo $lang_appprofil["LESDERNIERS"];?> <?php echo $genreRecherche == 'h' ? $lang_appprofil["PAPAS_S"] : $lang_appprofil["MAMANS_S"]; ?> <?php echo $genreRecherche == 'h' ? $lang_appprofil["INSCRITS"] : $lang_appprofil["INSCRITES"]; ?></h2>
					<div class="preview4">
					<?php 						if(is_array($profilsInscrits)) {
							foreach($profilsInscrits as $row) {
								JL::makeSafe($row);

								// r&eacute;cup la photo de l'utilisateur
								$photo = JL::userGetPhoto($row->id, '89', 'profil', $row->photo_defaut);

								?>
									<div class="preview">
										<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["VoirProfilDe"];?> <?php echo $row->username; ?>">
										<?php 											if($photo) {
											?>
												<img src="<?php echo $photo; ?>" alt="" />
											<?php 											} else {
											?>
												<img src="<?php echo SITE_URL; ?>/parentsolo/images/parent-solo-89-<?php echo $row->genre; ?>.jpg" alt="" />
											<?php 											}
										?>
										</a>
										<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["VoirProfilDe"];?> <?php echo $row->username; ?>" class="desc">
											<span class="pink"><?php echo $row->username; ?></span><br />
											<?php echo $row->age; ?> <?php echo $lang_appprofil["Ans"];?><br />
											<?php echo $row->nb_enfants; ?> <?php echo $row->nb_enfants > 1 ? $lang_appprofil["enfants_s"] : $lang_appprofil["enfant_s"]; ?><br />
										</a>
									</div>
								<?php 							}
							?>
							<a href="<?php echo JL::url('index.php?app=search&action=results'.'&'.$langue); ?>" class="more" title="<?php echo $lang_appprofil["VoirPlusDe"];?> <?php echo $genreRecherche == 'h' ? $lang_appprofil["NouveauxPapaInscrits"] : $lang_appprofil["NouvellesMamansInscrites"]; ?> <?php echo $lang_appprofil["Dernierement"];?>"> </a>
						<?php 						}
					?>
					</div>

					<?php 
						// charge le module gagnant du mois (dernier t&eacute;moignage du syst&egrave;me de points)
						JL::loadMod('gagnant_du_mois');

					?>

				</div>

				<div class="panel_right">

					<div class="banner_right250">
						<div id="banner_right250"></div>
					</div>

					<br />
					<a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" target="_blank" title="Obtenir plus d'information sur le Love Coaching, laFamily"><img src="<?php echo SITE_URL; ?>/images/banners/lafamily-love-coaching.jpg" alt="Plus d'informations" /></a>

					<?php 						// s'il y a un appel &agrave; t&eacute;moins &agrave; afficher
						if($appel_a_temoins) {
						?>
						<div class="bloc_top"> </div>
						<div class="bloc_center">
							<span>&raquo; <?php echo $lang_appprofil["AppelsATemoinsH2"];?></span>
							<b><?php echo $appel_a_temoins->media; ?>:</b> <a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$appel_a_temoins->id.'&'.$langue); ?>" title="<?php echo $appel_a_temoins->titre; ?>"><?php echo $appel_a_temoins->titre; ?></a>

							<p>
							<?php 								// si un logo a &eacute;t&eacute; envoy&eacute;
								if(is_file('images/appel-a-temoins/'.$appel_a_temoins->id.'.jpg')) { ?>
									<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$appel_a_temoins->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["AppelsATemoinsPlusInfos"];?>"><img src="<?php echo SITE_URL.'/images/appel-a-temoins/'.$appel_a_temoins->id.'.jpg'; ?>" alt="" /></a>
								<?php }

								echo $appel_a_temoins->annonce;
							?>
							</p>

							<div class="clear m10">&nbsp;</div>
							<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$appel_a_temoins->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["AppelsATemoinsPlusInfos"];?>" class="btnNoirRose gauche">+ <?php echo $lang_appprofil["AppelsATemoinsPlusInfosLabel"];?></a>
							<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["AppelsATemoinsListeTitle"];?>" class="btnNoirRose droite"><?php echo $lang_appprofil["AppelsATemoinsListe"];?></a>
							<div class="clear">&nbsp;</div>
						</div>
						<div class="bloc_bottom"> </div>
						<?php 						}


						// s'il y a un t&eacute;moignage &agrave; afficher
						if($temoignage) {

							// r&eacute;cup la photo de l'utilisateur
							$photo = JL::userGetPhoto($temoignage->user_id, '89', 'profil', $temoignage->photo_defaut);

							// photo par d&eacute;faut
							if(!$photo) {
								$photo = SITE_URL.'/parentsolo/images/parent-solo-89-'.$temoignage->genre.'.jpg';
							}

						?>
						<div class="bloc_top">&nbsp;</div>
						<div class="bloc_center">
							<span>&raquo; <?php echo $lang_appprofil["Temoignages"];?></span>
							<b><?php echo $temoignage->username; ?>:</b> <a href="<?php echo JL::url('index.php?app=temoignage&action=read&id='.$temoignage->id.'&'.$langue); ?>" title="<?php echo $temoignage->titre; ?>"><?php echo $temoignage->titre; ?></a>

							<p>
								<a href="<?php echo JL::url('index.php?app=temoignage&action=read&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["LireTeoignageDe"];?> <?php echo $temoignage->username; ?>"><img src="<?php echo $photo; ?>" alt="<?php echo $temoignage->username; ?>" /></a><?php echo $temoignage->texte; ?>
							</p>

							<div class="clear m10">&nbsp;</div>
							<a href="<?php echo JL::url('index.php?app=temoignage&action=read&id='.$temoignage->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["LireTeoignageComplet"];?>" class="btnNoirRose gauche"><?php echo $lang_appprofil["Lire"];?></a>
							<a href="<?php echo JL::url('index.php?app=temoignage&action=list'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["LireListeTeoignageComplet"];?>" class="btnNoirRose droite"><?php echo $lang_appprofil["Temoignages"];?></a>
							<div class="clear">&nbsp;</div>
						</div>
						<div class="bloc_bottom">&nbsp;</div>
						<?php 						}
					?>
				</div>

			</div> <?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left();

			?>
			<div class="clear"> </div>

		<?php 		}

		// menu en haut avec les steps
		function profil_menu($step_num = 0) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user, $action;

			// menu interne au profil de l'utilisateur log
			if($user->id) {
			?>

				<table class="profil_menu"><tr>
					<td <?php if(str_contains((string) $action, 'step1')) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=step1'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ModifierCompte"];?>"><?php echo $lang_appprofil["Moi"];?></a></td>
					<td <?php if(str_contains((string) $action, 'step2')) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=step2'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ModifierPhotos"];?>"><?php echo $lang_appprofil["Photos"];?></a></td>
					<td <?php if(str_contains((string) $action, 'step3')) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=step3'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ModifierAnnonce"];?>"><?php echo $lang_appprofil["Annonce"];?></a></td>
					<td <?php if(str_contains((string) $action, 'step4')) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=step4'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ModifierDescription"];?>"><?php echo $lang_appprofil["Description"];?></a></td>
					<td <?php if(str_contains((string) $action, 'step5')) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=step5'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ModifierInfosDiv"];?>"><?php echo $lang_appprofil["Infos"];?></a></td>
					<td <?php if(str_contains((string) $action, 'step6')) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=step6'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ModifierQuoti"];?>"><?php echo $lang_appprofil["Quotidien"];?></a></td>
					<td <?php if(str_contains((string) $action, 'step7')) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=step7'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ModifierEnfants"];?>"><?php echo $lang_appprofil["Enfants"];?></a></td>
					<td <?php if(str_contains((string) $action, 'step8')) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=step8'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ModifierRecherche"];?>"><?php echo $lang_appprofil["Recherche"];?></a></td>
					<td <?php if(str_contains((string) $action, 'step9')) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=step9'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ModifierCoordonnees"];?>"><?php echo $lang_appprofil["Contact"];?></a></td>
					<td <?php if(str_contains((string) $action, 'notification')) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=notification'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ModifierNotifications"];?>"><?php echo $lang_appprofil["Emails"];?></a></td>
					<td style="width:5px;"> </td>
				</tr></table>

			<?php 			} else {

				// d&eacute;termine le texte du h1
				$h1 = match ($step_num) {
                    10 => '',
                    9 => $lang_appprofil["QualiteDesProfils"],
                    8 => $lang_appprofil["MaRecherche"],
                    7 => $lang_appprofil["Enfant"],
                    6 => $lang_appprofil["AuQuotidien"],
                    5 => $lang_appprofil["InfoDiverses"],
                    4 => $lang_appprofil["Description"],
                    3 => $lang_appprofil["Annonce"],
                    2 => $lang_appprofil["Photo"],
                    default => $lang_appprofil["Moninscription"],
                };
				if ($_GET["lang"]!="fr") {
					//echo $_GET["lang"];
					$jsUpExt = "-".$_GET["lang"];
				} else {
					$jsUpExt = "";
				}
			?>
				<h1 class="profil_menu"><img src="<?php echo SITE_URL; ?>/parentsolo/images/step<?php echo $step_num.$jsUpExt; ?>.jpg" alt="<?php echo $h1; ?>" /></h1>
			<?php 			}

		}


		// colonne de gauche: panel utilisateur
		function profil_left($step_num = 0, $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			// user log
			if($user->id) {

				JL::loadMod('profil_panel');

			} else { // inscription

				if($step_num == 7) { // photos enfant

					$stepType 	= 3;
					$h2			= $lang_appprofil["PhotosEnfants"];

				} elseif($step_num == 2) { // photos profil

					$stepType 	= 3;
					$h2			= $lang_appprofil["VosPhotos"];

				} elseif($step_num == 3) { // mon annonce

					$stepType 	= 2;
					$h2			= $lang_appprofil["VotreAnnonce"];

				} else { // pour vous guider

					$stepType 	= 1;
					$h2			= $lang_appprofil["PourVousGuide"];

				}
				?>
				<div class="profil_left stepType<?php echo $stepType; ?>">
					<h2 class="notice"><?php echo $h2; ?></h2>
					<?php echo $notice; ?>
				</div>
			<?php 			}

		}


		function step1(&$row, &$list, $messages = [], $notice = '', $conditions = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			// variables
			$captcha	= random_int(2,7);

			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu(1);

				// affichage des messages
				HTML_profil::messages($messages);

			?>

			<form action="index.php<?php echo '?'.$langue;?>" name="step1" method="post">
				<input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_GET["lang"];?>" />
				<input type="hidden" id="condReadAccepted" value="<?php echo $lang_appprofil["condReadAccepted"];?>" />
				<input type="hidden" id="condReadNotAccepted" value="<?php echo $lang_appprofil["condReadNotAccepted"];?>" />
				<h2><?php echo $lang_appprofil["Moi"];?></h2>
				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<?php echo $lang_appprofil["JeSuis"];?>
						</td>
						<td>
							<?php 								// user log
								if($user->id) {

									?>
									<input type="hidden" name="genre" value="<?php echo $row['genre']; ?>" />
									<b>
									<?php 									if($row['genre'] == 'h') {
										echo $lang_appprofil["UnHomme"];
									} else {
										echo $lang_appprofil["UneFemme"];
									}
									?>
									</b>
									<?php 
								} else {
									echo $list['genre'];
								}
							?>
						</td>
						<td>
							<?php echo $lang_appprofil["NeeLe"];?>
						</td>
						<td>
							<?php echo $list['naissance_jour']; ?> <?php echo $list['naissance_mois']; ?> <?php echo $list['naissance_annee']; ?>
						</td>
						<td>
							<?php echo $lang_appprofil["EtJai"];?> <?php echo $list['nb_enfants']; ?> <?php echo $lang_appprofil["Enfant"];?>
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $lang_appprofil["JhabiteDansCanton"];?>
						</td>
						<td>
							<?php echo $list['canton_id']; ?>
						</td>
						<td>
							<?php echo $lang_appprofil["A"];?>
						</td>
						<td colspan="2" id="villes">
							<?php echo $list['ville_id']; ?>
						</td>
					</tr>
				</table>

				<hr />

				<h2><?php echo $lang_appprofil["JesouhaiteTrouver"];?></h2>
				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<?php echo $lang_appprofil["Jecherche"];?>&nbsp;
							<span id="step1gender">
							<?php 								switch($row['genre']) {

									case 'h':
										echo $lang_appprofil["UneFemme"];
									break;

									case 'f':
										echo $lang_appprofil["UnHomme"];
									break;

									default:
										echo $lang_appprofil["ChoisissezVotreGenre"];
									break;

								}
							?>
							</span>
							&nbsp;<?php echo $lang_appprofil["Entre"];?> <?php echo $list['recherche_age_min']; ?> <?php echo $lang_appprofil["Et"];?> <?php echo $list['recherche_age_max']; ?> <?php echo $lang_appprofil["Ans"];?>
						</td>
					</tr>
					<tr>
						<td>
							 <?php echo $lang_appprofil["Avec"];?> <?php echo $list['recherche_nb_enfants']; ?> <?php echo $lang_appprofil["Enfant"];?>.
						</td>
					</tr>
				</table>

				<hr />

				<h2><?php echo $lang_appprofil["MesDonnees"];?></h2>
				<table class="profil_table" cellpadding="0" cellspacing="0">
					<?php 						if(isset($list['parrain'])) {
						?>
						<tr>
							<td>
								<b><?php echo $lang_appprofil["MonParrian"];?></b>
							</td>
							<td>
								<span class="pink"><?php echo $list['parrain']; ?></span><?php if(!$user->id) { ?><input type="hidden" name="parrain_id" value="<?php echo $row['parrain_id']; ?>" /><?php } ?>
							</td>
						</tr>
						<?php 						}
					?>
					<tr>
						<td width="200px">
							<?php 								// user log
								if($user->id) {
								?>
									<b><?php echo $lang_appprofil["MonPseudo"];?></b>
								<?php 								} else {
								?>
									<label for="usernameIns"><?php echo $lang_appprofil["MonPseudo"];?></label>
								<?php 								}
							?>
						</td>
						<td>
							<?php 								// user log
								if($user->id) {
								?>

									<input type="hidden" name="username" value="<?php echo $row['username']; ?>" />
									<b><?php echo $row['username']; ?></b>

								<?php 								} else {
								?>

									<input type="text" name="username" id="usernameIns" value="<?php echo $row['username']; ?>" />

								<?php 								}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<label for="passwordIns">
							<?php 								// user log
								if($user->id) {
								?>
									<?php echo $lang_appprofil["ChangerMonMotPasse"];?>
								<?php 								} else {
								?>
									<?php echo $lang_appprofil["MotDePasse"];?>
								<?php 								}
							?>
							</label>
						</td>
						<td>
							<input type="password" id="passwordIns" name="password" value="" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="password2Ins"><?php echo $lang_appprofil["ConfirmationmotPasse"];?></label>
						</td>
						<td>
							<input type="password" name="password2" id="password2Ins" value="" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="emailIns"><?php echo $lang_appprofil["Email"];?></label>
						</td>
						<td>
							<?php 								// user log
								if($user->id) {
								?>
									<b><?php echo $row['email']; ?></b>
									<input type="hidden" name="email" id="emailIns" value="<?php echo $row['email']; ?>" />
									<input type="hidden" name="email2" value="<?php echo $row['email']; ?>" />
								<?php 								} else {
								?>
									<input type="text" name="email" id="emailIns" value="<?php echo $row['email']; ?>" />
								<?php 								}
							?>
						</td>
					</tr>
					<?php 						// user non log
						if(!$user->id) {
						?>
						<tr>
							<td>
								<label for="email2Ins"><?php echo $lang_appprofil["ConfirmationEmail"];?></label>
							</td>
							<td>
								<input type="text" name="email2" id="email2Ins" value="<?php echo $row['email']; ?>" />
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="checkbox" name="offres" <?php if($row['offres'] == 1) {?>checked<?php } ?>  /> <?php echo $lang_appprofil["JeSouhaiteRecevoir"];?>
							</td>
						</tr>

						<tr><td colspan="2">&nbsp;</td></tr>

						<tr>
							<td valign="top">
								<label for="codesecurite"><?php echo $lang_appprofil["CodeDeSecurite"];?></label>
							</td>
							<td valign="top">
								<span class="capQ"><?php echo $lang_appprofil["CombienDeFleurs"];?> ?</span><br />
								<br />
								<?php 								$captcha = random_int(2,7);
								JL::setSession('captcha', $captcha);
								for($i=0;$i<$captcha;$i++) {
								?>
									<img src="<?php echo SITE_URL; ?>/parentsolo/images/flower.jpg" alt="Fleur" align="left" />
								<?php 								}
								?>
								&nbsp;=&nbsp;<input type="text" name="codesecurite" id="codesecurite" value="" maxlength="1" />
							</td>
						</tr>
						<?php 						}
					?>

				</table>

				<hr />

				<h2><?php echo $lang_appprofil["ConditionsUtilisation"];?></h2>
				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="2" class="tdConditions">
							<div class="conditions">
								<div id="divConditions">
									<?php echo $conditions; ?>
								</div>
								<br />
								<center>
									<input type="button" onClick="btnconditions(1);" id="conditionsAccept" value="<?php echo $lang_appprofil["JAccepte"];?>" /> <input type="button" onClick="btnconditions(0);" id="conditionsRefuse" value="<?php echo $lang_appprofil["JeReffuse"];?>" /><br />
									<br />
									<b><?php echo $lang_appprofil["Conditions"];?>:</b> <span id="reponse" class="orange"><?php echo $lang_appprofil["VeuillezLireFaireDefiler"];?>.</span>
								</center>
								<br />
								<br />
								<?php echo $lang_appprofil["EnCliquantBouton"];?> <span class="green">&quot;<?php echo $lang_appprofil["JAccepte"];?>&quot;</span>, <?php echo $lang_appprofil["JeCertiifeMajeur"];?> <span class="orange"><?php echo $lang_appprofil["ConditionGenerales"];?></span> <?php echo $lang_appprofil["DuService"];?> <b>solocircl.com</b> <?php echo $lang_appprofil["EnonceesCiDessus"];?>.
							</div>
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<a href="javascript:document.step1.submit();" class="bouton <?php echo $user->id ? 'validate' : 'step_next'; ?>"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
						</td>
					</tr>
				</table>
				<input type="hidden" name="conditions" id="inputconditions" value="<?php echo $row['conditions'] ; ?>" />
				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step1submit" />
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
			</form>

			</div> <?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left(1, $notice);

			?>
			<div class="clear"> </div>

			<script language="javascript" type="text/javascript">
				$(document).ready(function() {
console.log('divConditions');
    // Calculate maximum scroll for the div
    var scrollMax = getScrollMax('divConditions');

    // Enable/disable buttons based on $row['conditions']
    <?php if($row['conditions'] > 0): ?>
        $('#conditionsAccept, #conditionsRefuse')
            .prop('disabled', false)
            .removeClass()
            .addClass('accept'); // Accept button
        $('#conditionsRefuse').removeClass().addClass('refuse'); // Refuse button
        btnconditions(1);
        $('#divConditions').scrollTop(scrollMax);
    <?php else: ?>
        $('#conditionsAccept, #conditionsRefuse').prop('disabled', true).removeClass();
        <?php if($row['conditions'] == 0): ?>
            btnconditions(0);
        <?php endif; ?>
    <?php endif; ?>

    // Load cities
    loadVilles();

    // Scroll event to enable buttons only when scrolled to bottom
    $('#divConditions').on('scroll', function() {
        if(this.scrollTop >= scrollMax) {
            $('#conditionsAccept, #conditionsRefuse')
                .prop('disabled', false)
                .removeClass()
                .addClass(function(index, currentClass) {
                    return index === 0 ? 'accept' : 'refuse';
                });
        } else {
            $('#conditionsAccept, #conditionsRefuse').prop('disabled', true).removeClass();
        }
    });
});

			</script>
			<?php 		}


		function step2(&$row, &$list, $messages = [], $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;


			// tableaux des photos
			$photos		= [];
			$valid		= false;

			// r&eacute;cup les miniatures de photos d&eacute;j&agrave; envoy&eacute;es
			$dir = 'images/profil/'.JL::getSession('upload_dir', 'error');
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {

					// r&eacute;cup les miniatures de photos pending
					if(preg_match('/pending.*109-profil/', $file)) {

						$photos[]	= $dir.'/'.$file;

					} elseif(preg_match('/109-profil/', $file) && !preg_match('/pending/', $file) && !preg_match('/temp/', $file)) { // r&eacute;cup les miniatures de photos valid&eacute;es

						$photos[]	= $dir.'/'.$file;
						$valid	= true;

					} elseif(preg_match('/temp.*109-profil/', $file)) { // photos temporaires

						$photos[]	= $dir.'/'.$file;

					}

				}

			}
			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu(2, $notice);

				// affichage des messages
				HTML_profil::messages($messages);

			?>

			<form action="index.php<?php echo '?'.$langue;?>" name="step2" method="post" enctype="multipart/form-data">


				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" colspan="2">
							<img src="<?php echo SITE_URL; ?>/parentsolo/images/step2photo.jpg" alt="" align="right" />
							<h2><?php echo $lang_appprofil["MaPhoto"];?></h2>
							<p>
								&raquo; <?php echo $lang_appprofil["CliquezSurBouton"];?> <b><?php echo $lang_appprofil["6Photos"];?></b> <?php echo $lang_appprofil["SurLeDisqueDur"];?>.
							</p>
							<br />
							<p>
								<span class="pink">&raquo; <?php echo $lang_appprofil["SerontRefusees"];?>:</span>
								<ul class="photoRules">
									<li><?php echo $lang_appprofil["LesPotosEvidence"];?>.</li>
									<li><?php echo $lang_appprofil["LesPotosCaractere"];?>.</li>
									<li><?php echo $lang_appprofil["LesPotosMauvaise"];?>.</li>
									<li><?php echo $lang_appprofil["DessinsIllustrations"];?>.</li>
									<li><?php echo $lang_appprofil["LesPotosAvecEnfant"];?>.</li>
								</ul>
								<b><?php echo $lang_appprofil["EnCasProbleme"];?> <span class="pink"><?php echo $lang_appprofil["JpegJpg"];?></span>, <?php echo $lang_appprofil["PourTailleMaximale"];?> <span class="pink">2 Mo</span> <?php echo $lang_appprofil["UneResolurionMaximle"];?> <span class="pink">1000x1000px</span>.</b>
							</p>

						</td>
					</tr>
					<tr>
						<td width="140px">
							<div class="swfu_btn"><span id="spanButtonPlaceholder"></span></div>
						</td>
						<td>
							<div id="divFileProgressContainer"></div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div id="thumbnails">
							<?php 
								// affiche les miniatures de photos VALIDEES
								if (is_array($photos)) {
									foreach($photos as $photo) {
										$photo_i = preg_replace('#^.*([0-9]{1}).*$#', '$1', $photo);
										?>
										<div class="miniature" id="<?php echo $photo; ?>">
											<img src="<?php echo $photo; ?>" />
											<a href="javascript:deleteImage('<?php echo $photo; ?>','');" class="btnDelete"></a>
											<a href="javascript:setDefault('<?php echo $photo_i; ?>');" class="<?php echo $row['photo_defaut'] == $photo_i ? 'yes' : 'no'; ?>" id="photo<?php echo $photo_i; ?>"><?php echo $lang_appprofil["ParDefaut"];?></a>
										</div>
									<?php 									}
								}

							?>
							</div>
						</td>
					</tr>
					<tr>
						<td class="key"><?php echo $lang_appprofil["PageAccueil"];?></td>
						<td>
							<table cellpadding="5px" cellspacing="0">
								<tr>
									<td><input type="radio" name="photo_home" id="photo_home_1" value="1" <?php if($row['photo_home'] == 1) { ?>checked<?php } ?> /></td><td><label for="photo_home_1"><?php echo $lang_appprofil["J"];?><u><?php echo $lang_appprofil["Accepte"];?></u> <?php echo $lang_appprofil["MontrerPotoParDefaut"];?>.</label></td>
								</tr>
								<tr>
									<td><input type="radio" name="photo_home" id="photo_home_0" value="0" <?php if($row['photo_home'] == 0) { ?>checked<?php } ?> /></td><td><label for="photo_home_0"><?php echo $lang_appprofil["Je"];?> <u><?php echo $lang_appprofil["NAcceptePas"];?></u> <?php echo $lang_appprofil["MontrerMaPhoto"];?>.</label></td>
								</tr>
							</table>
						</td>
					</tr>
				<?php 					// s'il y a des photos
					if (is_array($photos)) {
					?>
					<tr>
						<td colspan="2">
							<div class="messages">
							<?php 								if($valid) {
								?>
									<span class="valid"><?php echo $lang_appprofil["VosPhotosEteValider"];?>.</span>
								<?php 								} else {
								?>
									<span class="warning"><?php echo $lang_appprofil["VosPhotosAttente"];?> <a href="<?php echo JL::url('index.php?app=redac&action=item&id=5'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ConditionsGeneralesUtilisation"];?>" target="_blank"><?php echo $lang_appprofil["ConditionsGeneralesUtilisation"];?></a> <?php echo $lang_appprofil["ServiceParentsolo"];?>.</span>
								<?php 								}
							?>
							</div>
						</td>
					</tr>
					<?php 					}
					?>
					<tr>
						<td colspan="2">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td class="left">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=inscription"."&".$langue); ?>" class="bouton step_previous"><?php echo $lang_appprofil["EtapePrecedente"];?></a>
										<?php } ?>
									</td>
									<td class="center">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step9".'&'.$langue); ?>" class="bouton step_fin" title="<?php echo $lang_appprofil["TerminerEtDerPage"];?>"><?php echo $lang_appprofil["RemettrePlusTard"];?></a>
										<?php } ?>
									</td>
									<td class="right">
										<a href="javascript:document.step2.submit();" class="bouton <?php echo $user->id ? 'validate' : 'step_next'; ?>"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step2submit" />
				<input type="hidden" name="photo_defaut" value="<?php echo $row['photo_defaut']; ?>" />

				<?php // indispensable pour swfupload version s&eacute;curis&eacute; ?>
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
				<input type="hidden" name="upload_dir" id="upload_dir" value="<?php echo JL::getSession('upload_dir', 'error'); ?>" />
				<input type="hidden" name="hash" id="hash" value="<?php echo md5(date('y').JL::getSession('upload_dir', 'error').date('Y')); ?>" />

			</form>
			</div><?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left(2, $notice);

			?>
			<div class="clear"> </div>

			<script type="text/javascript">
				uploaderInit();
			</script>
		<?php 		}


		function step3(&$row, &$list, $messages = [], $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			$annonce_limite = 2000;

			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu(3);

				// affichage des messages
				HTML_profil::messages($messages);
			?>

			<form action="index.php<?php echo '?'.$langue;?>" name="step3" method="post">

				<h2><?php echo $lang_appprofil["MonAnnonce"];?></h2>
				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td class="nopadding">
							<textarea name="annonce" class="annonce" onKeyDown="textCounter(this.form.annonce,parseInt(document.getElementById('chars_limit').innerHTML),<?php echo $annonce_limite; ?>);" onKeyUp="textCounter(this.form.annonce,parseInt(document.getElementById('chars_limit').innerHTML),<?php echo $annonce_limite; ?>);"><?php echo $row['annonce']; ?></textarea><br />
							<br />
							<?php echo $lang_appprofil["NombreDeCaracteres"];?>: <span id="chars_limit"><?php echo $annonce_limite-strlen(str_replace("\n",'',$row['annonce'])); ?></span>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="branch_bottom">
							&nbsp;
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="messages">
							<?php 								if($row['published'] == 0) {
								?>
									<span class="error"><?php echo $lang_appprofil["VotreAnnonceEteRefusee"];?> <a href="<?php echo JL::url('index.php?app=redac&action=item&id=5'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ConditionGenerales"];?>" target="_blank"><?php echo $lang_appprofil["ConditionGenerales"];?></a> <?php echo $lang_appprofil["DuServiceParentsolo"];?>.</span>
								<?php 								} elseif($row['published'] == 1) {
								?>
									<span class="valid"><?php echo $lang_appprofil["VotreAnnonceEteValide"];?> !</span>
								<?php 								} elseif($row['annonce'] != '') {
								?>
									<span class="warning"><?php echo $lang_appprofil["VotreAnnonceMaintenant"];?>.</span>
								<?php 								} else {
								?>
									<span class="warning"><?php echo $lang_appprofil["AvantEtrePublier"];?>.</span>
								<?php 								}
							?>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td class="left">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step2".'&'.$langue); ?>" class="bouton step_previous"><?php echo $lang_appprofil["EtapePrecedente"];?></a>
										<?php } ?>
									</td>
									<td class="center">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step9".'&'.$langue); ?>" class="bouton step_fin" title="<?php echo $lang_appprofil["TerminerEtDerPage"];?>"><?php echo $lang_appprofil["RemettrePlusTard"];?></a>
										<?php } ?>
									</td>
									<td class="right">
										<a href="javascript:document.step3.submit();" class="bouton <?php echo $user->id ? 'validate' : 'step_next'; ?>"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step3submit" />
			</form>
			</div><?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left(3, $notice);

			?>
			<div class="clear"> </div>
			<?php 
		}


		function step4(&$row, &$list, $messages = [], $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu(4);

				// affichage des messages
				HTML_profil::messages($messages);

			?>

			<form action="index.php<?php echo '?'.$langue;?>" name="step4" method="post">

				<h2><?php echo $lang_appprofil["MaDescription"];?></h2>
				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td><?php echo $lang_appprofil["MonSigneAstrologique"];?></td><td><?php echo $list['signe_astrologique_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JeMesure"];?></td><td><?php echo $list['taille_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JePese"];?></td><td><?php echo $list['poids_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JaiUneSilhouette"];?></td><td><?php echo $list['silhouette_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["MonStyleCoiffure"];?></td><td><?php echo $list['style_coiffure_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["MesCheveuxSont"];?></td><td><?php echo $list['cheveux_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["MesYeuxSont"];?></td><td><?php echo $list['yeux_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JeSuisOrigine"];?></td><td><?php echo $list['origine_id']; ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td class="left">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step3".'&'.$langue); ?>" class="bouton step_previous"><?php echo $lang_appprofil["EtapePrecedente"];?></a>
										<?php } ?>
									</td>
									<td class="center">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step9".'&'.$langue); ?>" class="bouton step_fin" title="<?php echo $lang_appprofil["TerminerEtDerPage"];?>"><?php echo $lang_appprofil["RemettrePlusTard"];?></a>
										<?php } ?>
									</td>
									<td class="right">
										<a href="javascript:document.step4.submit();" class="bouton <?php echo $user->id ? 'validate' : 'step_next'; ?>"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step4submit" />
			</form>
			</div><?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left(4, $notice);

			?>
			<div class="clear"> </div>
			<?php 
		}


		function step5(&$row, &$list, $messages = [], $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu(5);

				// affichage des messages
				HTML_profil::messages($messages);

			?>

			<form action="index.php<?php echo '?'.$langue;?>" name="step5" method="post">

				<h2><?php echo $lang_appprofil["MesInfoDiverses"];?></h2>
				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td><?php echo $lang_appprofil["JeSuisNationalite"];?></td><td><?php echo $list['nationalite_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JeSuisReligion"];?></td><td><?php echo $list['religion_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["MonStatutMarital"];?></td><td><?php echo $list['statut_marital_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["MeMarierCest"];?></td><td><?php echo $list['me_marier_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JeChercheRelation"];?></td><td><?php echo $list['cherche_relation_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["MonNiveauEtudes"];?></td><td><?php echo $list['niveau_etude_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["MonSecteurActivite"];?></td><td><?php echo $list['secteur_activite_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JeFume"];?></td><td><?php echo $list['fumer_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JaiTemperament"];?></td><td><?php echo $list['temperament_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JeveuxEnfants"];?></td><td><?php echo $list['vouloir_enfants_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["QuiLaGarde"];?> ?</td><td><?php echo $list['garde_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JeParle"];?></td><td><?php echo $list['langue1_id']; ?> <?php echo $list['langue2_id']; ?> <?php echo $list['langue3_id']; ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td class="left">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step4".'&'.$langue); ?>" class="bouton step_previous"><?php echo $lang_appprofil["EtapePrecedente"];?></a>
										<?php } ?>
									</td>
									<td class="center">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step9".'&'.$langue); ?>" class="bouton step_fin" title="<?php echo $lang_appprofil["TerminerEtDerPage"];?>"><?php echo $lang_appprofil["RemettrePlusTard"];?></a>
										<?php } ?>
									</td>
									<td class="right">
										<a href="javascript:document.step5.submit();" class="bouton <?php echo $user->id ? 'validate' : 'step_next'; ?>"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step5submit" />
			</form>
			</div><?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left(5, $notice);

			?>
			<div class="clear"> </div>
			<?php 
		}


		function step6(&$row, &$list, $messages = [], $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu(6);

				// affichage des messages
				HTML_profil::messages($messages);

			?>

			<form action="index.php<?php echo '?'.$langue;?>" name="step6" method="post">

				<h2><?php echo $lang_appprofil["AuQuotidien"];?></h2>

				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td><?php echo $lang_appprofil["JeVis"];?></td><td><?php echo $list['vie_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["LaimeLaCuisine"];?></td><td><?php echo $list['cuisine1_id']; ?> <?php echo $list['cuisine2_id']; ?> <?php echo $list['cuisine3_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JaimeSorties"];?></td><td><?php echo $list['sortie1_id']; ?> <?php echo $list['sortie2_id']; ?> <?php echo $list['sortie3_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["MesLoisirs"];?></td><td><?php echo $list['loisir1_id']; ?> <?php echo $list['loisir2_id']; ?> <?php echo $list['loisir3_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["MesPratiquesSportives"];?></td><td><?php echo $list['sport1_id']; ?> <?php echo $list['sport2_id']; ?> <?php echo $list['sport3_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["jaimeMusique"];?></td><td><?php echo $list['musique1_id']; ?> <?php echo $list['musique2_id']; ?> <?php echo $list['musique3_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["Jaimefilms"];?></td><td><?php echo $list['film1_id']; ?> <?php echo $list['film2_id']; ?> <?php echo $list['film3_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JaimeLire"];?></td><td><?php echo $list['lecture1_id']; ?> <?php echo $list['lecture2_id']; ?> <?php echo $list['lecture3_id']; ?></td>
					</tr>
					<tr>
						<td><?php echo $lang_appprofil["JaimeAnimaux"];?></td><td><?php echo $list['animaux1_id']; ?> <?php echo $list['animaux2_id']; ?> <?php echo $list['animaux3_id']; ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td class="left">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step4".'&'.$langue); ?>" class="bouton step_previous"><?php echo $lang_appprofil["EtapePrecedente"];?></a>
										<?php } ?>
									</td>
									<td class="center">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step9".'&'.$langue); ?>" class="bouton step_fin" title="<?php echo $lang_appprofil["TerminerEtDerPage"];?>"><?php echo $lang_appprofil["RemettrePlusTard"];?></a>
										<?php } ?>
									</td>
									<td class="right">
										<a href="javascript:document.step6.submit();" class="bouton <?php echo $user->id ? 'validate' : 'step_next'; ?>"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step6submit" />
			</form>
			</div><?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left(6, $notice);

			?>
			<div class="clear"> </div>
			<?php 
		}


		function step7(&$row, &$list, $messages = [], $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			// tableaux des photos
			$photo			= [];
			$valid			= true;

			// r&eacute;cup les miniatures de photos d&eacute;j&agrave; envoy&eacute;es
			$dir 				= 'images/profil/'.JL::getSession('upload_dir', 'error');
			for($i=1;$i<=6;$i++) {

				$file 			= $dir.'/parent-solo-109-enfant-'.$i.'.jpg';
				$file_pending 	= $dir.'/pending-parent-solo-109-enfant-'.$i.'.jpg';
				$file_temp 		= $dir.'/temp-parent-solo-109-enfant-'.$i.'.jpg';
				if(is_file($file)) {
					$photo[$i] 	= $file;
				} elseif(is_file($file_pending)) {
					$photo[$i] 	= $file_pending;
					$valid		= false;
				} elseif(is_file($file_temp)) {
					$photo[$i] 	= $file_temp;
					$valid		= false;
				} else {
					$photo[$i] 	= '';
				}

			}

			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu(7);

				// affichage des messages
				HTML_profil::messages($messages);

			?>

			<form action="index.php<?php echo '?'.$langue;?>" name="step7" method="post">

			<?php 				// cr&eacute;ation des 6 blocks d'enfants
				for($i=1; $i<=6; $i++) {

					switch($i) {
						case 1:
							$enfant_num = $lang_appprofil["Premier"];
						break;

						case 2:
							$enfant_num = $lang_appprofil["Second"];
						break;

						case 3:
							$enfant_num = $lang_appprofil["Troisieme"];
						break;

						case 4:
							$enfant_num = $lang_appprofil["Qutrieme"];
						break;

						case 5:
							$enfant_num = $lang_appprofil["Cinquieme"];
						break;

						case 6:
							$enfant_num = $lang_appprofil["Sixieme"];
						break;

					}

					?>
					<div id="child<?php echo $i; ?>" style="display:<?php echo $row['child'.$i] ? 'block' : 'none'; ?>;">
						<h2><?php echo $lang_appprofil["Mon"];?> <?php echo $enfant_num; ?> <?php echo $lang_appprofil["enfant_s"];?></h2>
						<table class="profil_table" cellpadding="0" cellspacing="0">
							<tr>
								<td class="childPhoto">
									<div id="thumbnails<?php echo $i; ?>">
										<?php 											// si une photo existe pour cet enfant
											if($photo[$i]) {
											?>
											<div class="miniature" id="<?php echo $photo[$i]; ?>">
												<img src="<?php echo $photo[$i]; ?>?<?php echo time(); ?>" />
												<a href="javascript:deleteImage('<?php echo $photo[$i]; ?>',<?php echo $i; ?>);" class="btnDelete"><?php echo $lang_appprofil["Supprimer"];?></a>
											</div>
											<?php 											}
										?>
									</div>
									<div class="swfu_btn"><span id="spanButtonPlaceholder<?php echo $i; ?>"></span></div>
								</td>
								<td valign="top">
									<span class="childTitle"><?php echo $lang_appprofil["DateNaissance"];?>:</span>
									<?php echo $list['naissance_jour'.$i]; ?> <?php echo $list['naissance_mois'.$i]; ?> <?php echo $list['naissance_annee'.$i]; ?><br />
									<br />
									<span class="childTitle"><?php echo $lang_appprofil["Genre"];?>:</span>
									<?php echo $list['genre'.$i]; ?><br />
									<br />
									<span class="childTitle"><?php echo $lang_appprofil["SigneAstrologique"];?>:</span>
									<?php echo $list['signe_astrologique'.$i.'_id']; ?>
								</td>
							</tr>
						</table>
						<input type="hidden" name="child<?php echo $i; ?>" value="<?php echo $row['child'.$i] ? 1 : 0; ?>" />
					</div>
					<?php 
				}

				?>

				<div class="child_bar">
					<div id="divFileProgressContainer"></div>
					<a href="javascript:childChange('+');" class="child_plus"><?php echo $lang_appprofil["AjouterEnfant"];?></a>
					<a href="javascript:childChange('-');" class="child_minus"><?php echo $lang_appprofil["RetirerEnfant"];?></a>
				</div>

				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<h2><?php echo $lang_appprofil["QuiPeutVoir"];?> <b><?php echo $lang_appprofil["LesPhotos"];?></b> <?php echo $lang_appprofil["DeMesEnfants"];?> ?</h2>
						</td>
					</tr>
					<tr>
						<td class="tdPhotoMontrer">
							<input type="radio" name="photo_montrer" <?php if($row['photo_montrer'] == 0) { ?>checked<?php } ?> value="0" id="photo_montrer_0" /> <label for="photo_montrer_0"><?php echo $lang_appprofil["UniquementLes"];?> <b><?php echo $lang_appprofil["Moderateurs"];?></b> <?php echo $lang_appprofil["DeParentsolo_ch"];?>.</label><br />
							<?php /*<input type="radio" name="photo_montrer" <?php if($row['photo_montrer'] == 1) { ?>checked<?php } ?> value="1" id="photo_montrer_1" /> <label for="photo_montrer_1">Uniquement les membres de <b>ma liste d'amis</b>.</label><br />*/ ?>
							<input type="radio" name="photo_montrer" <?php if($row['photo_montrer'] == 2) { ?>checked<?php } ?> value="2" id="photo_montrer_2" /> <label for="photo_montrer_2"><?php echo $lang_appprofil["TousLes"];?> <b><?php echo $lang_appprofil["Membres"];?></b> <?php echo $lang_appprofil["DeParentsolo_ch"];?>.</label>
						</td>
					</tr>
					<tr>
						<td>
							<div class="messages">
							<?php 								if (is_array($photo)) {
									if($valid) {
									?>
										<span class="valid"><?php echo $lang_appprofil["VosPhotosEteValider"];?>.</span>
									<?php 									} else {
									?>
										<span class="warning"><?php echo $lang_appprofil["VosPhotosAttente"];?> <a href="<?php echo JL::url('index.php?app=redac&action=item&id=5'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["ConditionsGeneralesUtilisation"];?>" target="_blank"><?php echo $lang_appprofil["ConditionsGeneralesUtilisation"];?></a> <?php echo $lang_appprofil["ServiceParentsolo"];?>.</span>
									<?php 									}
								}
							?>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td class="left">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step6".'&'.$langue); ?>" class="bouton step_previous"><?php echo $lang_appprofil["EtapePrecedente"];?></a>
										<?php } ?>
									</td>
									<td class="center">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step9".'&'.$langue); ?>" class="bouton step_fin" title="<?php echo $lang_appprofil["TerminerEtDerPage"];?>"><?php echo $lang_appprofil["RemettrePlusTard"];?></a>
										<?php } ?>
									</td>
									<td class="right">
										<a href="javascript:document.step7.submit();" class="bouton <?php echo $user->id ? 'validate' : 'step_next'; ?>"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>



				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step7submit" />

				<?php // indispensable pour swfupload version s&eacute;curis&eacute; ?>
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
				<input type="hidden" name="upload_dir" id="upload_dir" value="<?php echo JL::getSession('upload_dir', 'error'); ?>" />
				<input type="hidden" name="hash" id="hash" value="<?php echo md5(date('y').JL::getSession('upload_dir', 'error').date('Y')); ?>" />
				<input type="hidden" name="key" id="key" value="<?php echo $user->id ? md5((string) $user->id) : md5(time()); ?>" />
				<input type="hidden" name="childNum" id="childNum" value="1" />

			</form>
			</div><?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left(7, $notice);

			?>
			<div class="clear"> </div>

			<script type="text/javascript">
				uploaderInitChildren();
			</script>
			<?php 
		}


		function step8(&$list, $messages = [], $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu(8);

				// affichage des messages
				HTML_profil::messages($messages);

			?>

			<form action="index.php<?php echo '?'.$langue;?>" name="step8" method="post">

				<input type="hidden" name="search_lang_id" id="search_lang_id" value="<?php echo$_GET["lang"];?>">
				<h2><?php echo $lang_appprofil["MaRecherche"];?></h2>
				<table class="table_search search_form" cellpadding="0" cellspacing="0">
					<tr>
						<td class="param">
							<span class="genre"><?php echo $list['search_genre']; ?></span> <?php echo $lang_appprofil["De"];?>
						</td>
						<td>
							<?php echo $list['search_recherche_age_min']; ?> <?php echo $lang_appprofil["A"];?> <?php echo $list['search_recherche_age_max']; ?> <?php echo $lang_appprofil["Ans"];?>.
						</td>
						<td class="param"><?php echo $lang_appprofil["Pseudo"];?>:</td>
						<td><input type="text" name="search_username" id="search_username" value="<?php echo $list['search_username']; ?>" /></td>
					</tr>
					<tr>
						<td class="param"><?php echo $lang_appprofil["Canton"];?>:</td>
						<td><?php echo $list['search_canton_id']; ?></td>
						<td class="param"><?php echo $lang_appprofil["Ville"];?>:</td>
						<td id="villes"><?php echo $list['search_ville_id']; ?></td>
					</tr>
					<tr>
						<td class="param"><?php echo $lang_appprofil["Enfants"];?>:</td>
						<td><?php echo $list['search_nb_enfants']; ?></td>
						<td class="param"><?php echo $lang_appprofil["EnLigne"];?>:</td>
						<td><input type="radio" name="search_online" value="1" id="search_online_1" class="searchRadio" <?php echo $list['search_online'] ? 'checked' : ''; ?>> <label for="search_online_1"><?php echo $lang_appprofil["Oui"];?></label> <input type="radio" name="search_online" value="0" id="search_online_0" class="searchRadio" <?php echo !$list['search_online'] ? 'checked' : ''; ?>> <label for="search_online_0"><?php echo $lang_appprofil["PeuImporte"];?></label></td>
					</tr>
					<?php /*<tr>
						<td class="param">Titre:</td>
						<td colspan="3"><input type="text" name="search_titre" id="search_titre" value="<?php echo $list['search_titre']; ?>" maxlength="255" onClick="this.value='';" /></td>
					</tr>*/ ?>

					<tr>
						<td colspan="4">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td class="left">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step7".'&'.$langue); ?>" class="bouton step_previous"><?php echo $lang_appprofil["EtapePrecedente"];?></a>
										<?php } ?>
									</td>
									<td class="center">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step9".'&'.$langue); ?>" class="bouton step_fin" title="<?php echo $lang_appprofil["TerminerEtDerPage"];?>"><?php echo $lang_appprofil["RemettrePlusTard"];?></a>
										<?php } ?>
									</td>
									<td class="right">
										<a href="javascript:document.step8.submit();" class="bouton <?php echo $user->id ? 'validate' : 'step_next'; ?>"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<input type="hidden" name="app" value="search" />
				<input type="hidden" name="action" value="step8submit" />
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
			</form>
			</div><?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left(8, $notice);

			?>
			<div class="clear"> </div>

			<script language="javascript" type="text/javascript">loadVilles('search_');</script>
			<?php 
		}


		function step9(&$row, &$list, $messages = [], $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu(9);

				// affichage des messages
				HTML_profil::messages($messages);

			?>

			<form action="index.php<?php echo '?'.$langue;?>" name="step9" method="post">

				<h2><?php echo $lang_appprofil["CommentAssurerQualite"];?> ?</h2>
				<table class="profil_table table_step9" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="2" class="disclaimer">
							<?php echo $row['disclaimer']; ?>
						</td>
					</tr>
					<tr>
						<td class="key"><?php echo $lang_appprofil["Nom"];?></td>
						<td><input type="text" name="nom" value="<?php echo $row['nom']; ?>" /></td>
					</tr>
					<tr>
						<td class="key"><?php echo $lang_appprofil["Prenom"];?></td>
						<td><input type="text" name="prenom" value="<?php echo $row['prenom']; ?>" /></td>
					</tr>
					<tr>
						<td class="key"><?php echo $lang_appprofil["Telephone"];?></td>
						<td><span class="indicatif">+41</span><input type="text" name="telephone" value="<?php echo $row['telephone']; ?>" class="telephone" /></td>
					</tr>
					<tr>
						<td class="key"><?php echo $lang_appprofil["Adresse"];?></td>
						<td><input type="text" name="adresse" value="<?php echo $row['adresse']; ?>" /></td>
					</tr>
					<tr>
						<td class="key"><?php echo $lang_appprofil["CodePostal"];?></td>
						<td><input type="text" name="code_postal" value="<?php echo $row['code_postal']; ?>" /></td>
					</tr>
					<tr>
						<td colspan="2">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td class="left">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step8".'&'.$langue); ?>" class="bouton step_previous"><?php echo $lang_appprofil["EtapePrecedente"];?></a>
										<?php } ?>
									</td>
									<td class="center">

									</td>
									<td class="right">
										<a href="javascript:document.step9.submit();" class="bouton <?php echo $user->id ? 'validate' : 'finaliser'; ?>"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["Finaliser"]; ?></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step9submit" />
			</form>
			</div><?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left(9, $notice);

			?>
			<div class="clear"> </div>
			<?php 
		}


		function finalisation($notice) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu(10);

				// affichage des messages
				HTML_profil::messages($messages);

			?>
				<h2><?php echo $lang_appprofil["InscriptionTerminee"];?></h2>
				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							&raquo; <?php echo $lang_appprofil["FelicitationVotreProfil"];?> !<br />
							<br />
							&raquo; <?php echo $lang_appprofil["VousPouvezPresent"];?> <span class="pink">solocircl.com</span> <?php echo $lang_appprofil["AvecVosIdentifiants"];?>:<br />
							<br />
							<table cellpadding="0" cellspacing="0">
								<tr><td class="key"><?php echo $lang_appprofil["Pseudo"];?>:</td><td class="pink"><?php echo makeSafe(JL::getSession('username', '')); ?></td></tr>
								<tr><td class="key"><?php echo $lang_appprofil["Pass"];?>:</td><td class="pink"><?php echo makeSafe(JL::getSession('password', '')); ?></td></tr>
							</table>
							<br />
							&raquo; <?php echo $lang_appprofil["NousVousSouhaitons"];?>,<br />
							<br />
							<?php echo $lang_appprofil["LequipeDeParentsolo"];?>.
						</td>
					</tr>
					<tr>
						<td>

						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td class="left"> </td>
									<td class="center">
										<a href="<?php echo JL::url('index.php?app=profil&action=panel'.'&'.$langue); ?>" class="bouton return_home"><?php echo $lang_appprofil["RetourAccueil"];?></a>
									</td>
									<td class="right"> </td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div><?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left(9, $notice);

			?>
			<div class="clear"> </div>
			<?php 
		}

		/*
		function confirmation($success) {

			// colonne de gauche
			HTML_profil::profil_left();

			// menu steps
			HTML_profil::profil_menu(9);

			?>
			<div class="app_body">
				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<th><span class="titleFinal">Un site de rencontre d&eacute;di&eacute; aux mamans et papas</span></th>
					</tr>
					<tr>
						<td>
							<p>
							<?php 								if($success) {
								?>
									F&eacute;licitations !<br />
									<br />
									<span class="pink">Votre compte a &eacute;t&eacute; activ&eacute; avec succ&egrave;s !</span><br />
									<br />
									Vous pouvez d&egrave;s maintenant vous authentifier via le formulaire en haut &agrave; droite, afin d'acc&eacute;der &agrave; votre profil ainsi qu'aux autres fonctionnalit&eacute;s de <span class="pink">solocircl.com</span><br />
								<?php 								} else {
								?>
									Erreur !<br />
									<br />
									<span class="pink">Une erreur s'est produite lors de l'activation de votre compte !</span><br />
									<br />
									Si vous avez copi&eacute;/coll&eacute; le lien, v&eacute;rifiez que l'adresse compl&egrave;te a &eacute;t&eacute; copi&eacute;e.<br />
									<br />
									<b>Peut-&ecirc;tre avez-vous d&eacute;j&agrave; activ&eacute; votre compte ?</b><br />
									Si tel est le cas, alors le lien d'activation ne vous est plus d'aucune utilit&eacute;, vous pouvez le supprimer.<br />
								<?php 								}
							?>
									<br />
									A bient&ocirc;t sur <span class="pink">solocircl.com</span> !
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<a href="<?php echo SITE_URL; ?>/index.php" class="step_final"></a>
						</td>
					</tr>
				</table>
			</div>
			<?php 
		}*/


		// gestion des notifications de l'utilisateur
		function notification(&$row, $messages = []) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu();

				// affichage des messages
				HTML_profil::messages($messages);

			?>

			<form action="index.php<?php echo '?'.$langue;?>" name="notification" method="post">

				<h2><?php echo $lang_appprofil["MesNotificationEmail"];?></h2>
				<p class="notificationNotice"><?php echo $lang_appprofil["CochezLesCasesFace"];?>.</p>

				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td class="cbn"><input type="checkbox" name="new_visite" id="new_visite" <?php if($row['new_visite']) { ?>checked<?php } ?> /></td>
						<td><label for="new_visite" <?php if($row['new_visite']) { ?>class="notificationActive"<?php } ?>><?php echo $row['genre'] == 'h' ? $lang_appprofil["Une_Maman"] : $lang_appprofil["Un_Papa"]; ?> <?php echo $lang_appprofil["AConsulteVotreProfil"];?>.</label></td>
					</tr>
					<tr>
						<td class="cbn"><input type="checkbox" name="new_message" id="new_message" <?php if($row['new_message']) { ?>checked<?php } ?> /></td>
						<td><label for="new_message" <?php if($row['new_message']) { ?>class="notificationActive"<?php } ?>><?php echo $lang_appprofil["VousAvezNouveauMessage"];?>.</label></td>
					</tr>
					<tr>
						<td class="cbn"><input type="checkbox" name="new_fleur" id="new_fleur" <?php if($row['new_fleur']) { ?>checked<?php } ?> /></td>
						<td><label for="new_fleur" <?php if($row['new_fleur']) { ?>class="notificationActive"<?php } ?>><?php echo $lang_appprofil["VousAvezRecuNouvelleFleur"];?>.</label></td>
					</tr>
					<?php /*<tr>
						<td class="cbn"><input type="checkbox" name="new_flash" id="new_flash" <?php if($row['new_flash']) { ?>checked<?php } ?> /></td>
						<td><label for="new_flash" <?php if($row['new_flash']) { ?>class="notificationActive"<?php } ?>>Vous avez re&ccedil;u un nouveau flash.</label></td>
					</tr>*/ ?>
					<?php /*
					<tr>
						<td class="cbn"><input type="checkbox" name="new_inscrits" id="new_inscrits" <?php if($row['new_inscrits']) { ?>checked<?php } ?> /></td>
						<td><label for="new_inscrits" <?php if($row['new_inscrits']) { ?>class="notificationActive"<?php } ?>>Liste hebdomadaire des <?php echo $row['genre'] == 'h' ? 'derni&egrave;res mamans inscrites' : 'derniers papas inscrits'; ?>.</label></td>
					</tr> */ ?>
					<tr>
						<td class="cbn"><input type="checkbox" name="rappels" id="rappels" <?php if($row['rappels']) { ?>checked<?php } ?> /></td>
						<td><label for="rappels" <?php if($row['rappels']) { ?>class="notificationActive"<?php } ?>><?php echo $lang_appprofil["DiversRappels"];?>.</label></td>
					</tr>
					<tr>
						<td colspan="2">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td class="left"> </td>
									<td class="center"> </td>
									<td class="right">
										<a href="javascript:document.notification.submit();" class="bouton validate"><?php echo $lang_appprofil["Valider"];?></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="notificationsubmit" />
			</form>
			</div><?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left();

			?>
			<div class="clear"> </div>
			<?php 
		}


		// parrainage
		function parrainage(&$row, $messages = []) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			JL::makeSafe($row);

			?>
			<div class="app_body">
			<?php 
				// menu steps
				HTML_profil::profil_menu();

				// affichage des messages
				HTML_profil::messages($messages);

			?>

			<form action="index.php<?php echo '?'.$langue;?>" name="parrainage" method="post">

				<h2><?php echo $lang_appprofil["ParrainezvosAmies"];?></h2>
				<p class="parrainageNotice"><?php echo $lang_appprofil["SiVousAvezDesAmies"];?> !<br />
				<br />
				<?php echo $lang_appprofil["SilsSinscriventSurPartentsolo"];?> <a href="<?php echo JL::url('index.php?app=points&action=info'.'&'.$langue); ?>" class="pink" target="_blank" title="SoloFleurs">SoloFleurs</a><br />
				<?php echo $lang_appprofil["DesQueLeProfil"];?> !</p>

				<table class="profil_table" cellpadding="0" cellspacing="0">
					<tr>
						<td width="160px" class="key" valign="top"><label for="emails"><?php echo $lang_appprofil["EmailsDeVosAmies"];?></label></td>
						<td>
							<?php echo $lang_appprofil["SeparezLesEmails"];?>.<br />
							<i><?php echo $lang_appprofil["ExAmil"];?></i><br />
							<br />
							<textarea name="emails" id="emails" class="textareaParrainage"><?php echo $row->emails; ?></textarea>
						</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="message"><?php echo $lang_appprofil["VotreMessage"];?></label></td>
						<td>
							<?php echo $lang_appprofil["MessagePersonnel"];?>:<br />
							<br />
							<textarea name="message" id="message" class="textareaParrainage"><?php echo $row->message; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left">
							<a href="javascript:document.parrainage.submit();" class="bouton validate" style="float:none;"><?php echo $lang_appprofil["Envoyer"];?></a>
						</td>
					</tr>
				</table>

				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="parrainagesubmit" />
			</form>
			</div><?php // fin app_body ?>

			<?php 
				// colonne de gauche
				HTML_profil::profil_left();

			?>
			<div class="clear"> </div>
			<?php 
		}


		// affichage du profil
		function profil(&$profil, &$profilEnfants, &$profilDescription, &$profilInfosEnVrac1, &$profilInfosEnVrac2, &$profilQuotidien1, &$profilQuotidien2, &$profilQuotidien3, &$profilQuotidien4, &$profilGroupes) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $action, $user;

			// variables
			$dir 			= 'images/profil/'.$profil->id; // dossier contenant les photos du membre
			$photos			= []; // tableaux des photos
			$nonRenseigne	= $lang_appprofil["JeLeGarde"].'.';
			$langues		= [];

			// d&eacute;finie les labels du menu
			if($profil->id == $user->id) {

				$labelGenre 		= $lang_appprofil["Moi"];
				$labelMonEnfant		= count($profilEnfants) > 1 ? $lang_appprofil["MesEnfants"] : $lang_appprofil["MonEnfant"];
				$labelDescription	= $lang_appprofil["MaDescription"];
				$labelInfosDiverses	= $lang_appprofil["MesInfoDiverses"];
				$labelQuotidien		= $lang_appprofil["Monquotidien"];
				$labelGroupes		= $lang_appprofil["MesGroupes"];
				$labelAnnonce		= $lang_appprofil["MesAnnoces"];
				$labelGroupes		= $lang_appprofil["MesGroupes"];

			} else {

				$labelGenre = $profil->genre == 'h' ? $lang_appprofil["Lui"] : $lang_appprofil["Elle"];
				$labelMonEnfant	= count($profilEnfants) > 1 ? $lang_appprofil["SesEnfants"] : $lang_appprofil["SonEnfant"];
				$labelDescription	= $lang_appprofil["SaDescription"];
				$labelInfosDiverses	= $lang_appprofil["SesInfoDiverses"];
				$labelQuotidien		= $lang_appprofil["SonQuotidien"];
				$labelGroupes		= $lang_appprofil["SesGroupes"];
				$labelAnnonce		= $lang_appprofil["SonAnnonce"];
				$labelGroupes		= $lang_appprofil["SesGroupes"];

			}


			// htmlentities
			JL::makeSafe($profil);
			JL::makeSafe($profilDescription);
			JL::makeSafe($profilInfosEnVrac1);
			JL::makeSafe($profilInfosEnVrac2);
			JL::makeSafe($profilQuotidien1);

			?>
			<div class="app_body">
				<table class="profil_menu"><tr>
					<td <?php if($action == 'view') { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$profil->id.'&'.$langue); ?>" title="<?php echo $labelGenre; ?>"><?php echo $labelGenre; ?></a></td>
					<td <?php if($action == 'view2') { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=view2&id='.$profil->id.'&'.$langue); ?>" title="<?php echo $labelMonEnfant; ?>"><?php echo $labelMonEnfant; ?></a></td>
					<td <?php if($action == 'view3') { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=view3&id='.$profil->id.'&'.$langue); ?>" title="<?php echo $labelDescription; ?>"><?php echo $labelDescription; ?></a></td>
					<td <?php if($action == 'view4') { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=view4&id='.$profil->id.'&'.$langue); ?>" title="<?php echo $labelInfosDiverses; ?>"><?php echo $labelInfosDiverses; ?></a></td>
					<td <?php if($action == 'view5') { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=view5&id='.$profil->id.'&'.$langue); ?>" title="<?php echo $labelQuotidien; ?>"><?php echo $labelQuotidien; ?></a></td>
					<td <?php if($action == 'view6') { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=profil&action=view6&id='.$profil->id.'&'.$langue); ?>" title="<?php echo $labelGroupes; ?>"><?php echo $labelGroupes; ?></a></td>
				<td style="width: 100px;"> </td>
				</tr></table>


				<?php 
				// profil existe
				if($profil->accessok) {

					// r&eacute;cup la photo par d&eacute;faut de l'utilisateur
					$photoDefaut = JL::userGetPhoto($profil->id, 'profil', '', $profil->photo_defaut);

					// pas de photo par d&eacute;faut
					if(!$photoDefaut) {
						$photoDefaut = SITE_URL.'/parentsolo/images/parent-solo-profil.jpg';
					}

					// r&eacute;cup les photos de l'utilisateur, autres que celle par d&eacute;faut
					if(is_dir($dir)) {

						$dir_id 	= opendir($dir);
						while($file = trim(readdir($dir_id))) {

							// r&eacute;cup les miniatures de photos
							if(preg_match('/^parent-solo-35-profil/', $file)) { // r&eacute;cup les micro-miniatures de photos valid&eacute;es

								$photos[]	= $dir.'/'.$file;

							}

						}

					}

					// conserve le nombre de photos
					$photosNb	= count($photos);

					// g&eacute;n&eacute;ration de la chaine des langues
					$profilInfosEnVrac1->langues	= HTML_profil::profil3values($profilInfosEnVrac1, 'langue', $nonRenseigne);

					// g&eacute;n&eacute;ration de la chaine des cuisines
					$profilQuotidien1->cuisines		= HTML_profil::profil3values($profilQuotidien1, 'cuisine', $nonRenseigne);
					$profilQuotidien1->sorties		= HTML_profil::profil3values($profilQuotidien1, 'sortie', $nonRenseigne);
					$profilQuotidien2->loisirs		= HTML_profil::profil3values($profilQuotidien2, 'loisir', $nonRenseigne);
					$profilQuotidien2->sports		= HTML_profil::profil3values($profilQuotidien2, 'sport', $nonRenseigne);
					$profilQuotidien3->musiques		= HTML_profil::profil3values($profilQuotidien3, 'musique', $nonRenseigne);
					$profilQuotidien3->films		= HTML_profil::profil3values($profilQuotidien3, 'film', $nonRenseigne);
					$profilQuotidien4->animaux		= HTML_profil::profil3values($profilQuotidien4, 'animaux', $nonRenseigne);
					$profilQuotidien4->lectures		= HTML_profil::profil3values($profilQuotidien4, 'lecture', $nonRenseigne);

					// class suppl&eacute;mentaire au last_online

					// variables par d&eacute;faut (plus de 2 semaines)
					$last_online_class 		= 'lo_weeks';
					$last_online_label		= $lang_appprofil["PlusDe2Semaines"];

					// en ligne
					if($profil->last_online_time < ONLINE_TIME_LIMIT) {

						$last_online_class 	= 'lo_online';
						$last_online_label	= $lang_appprofil["EnLigne"].' !';
					} elseif($profil->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT) { // 30 minutes (60*30)

						$last_online_class 		= 'lo_online';
						$last_online_label		= $lang_appprofil["EnLigne"].' <i>('.($profil->genre == 'f' ? ''.$lang_appprofil["Absente"].'' : ''.$lang_appprofil["Absent"].'').'</i>)';

					} elseif($profil->last_online_time < 86400) { // aujourd'hui (60*60*24)

						$last_online_class 	= 'lo_today';
						$last_online_label	= $lang_appprofil["Aujourdhui"];

					} elseif($profil->last_online_time < 172800) { // hier (60*60*24*2)

						$last_online_class 	= 'lo_yesterday';
						$last_online_label	= $lang_appprofil["Hier"];

					} elseif($profil->last_online_time < 604800) { // cette semaine (60*60*24*7)

						$last_online_class 	= 'lo_week';
						$last_online_label	= $lang_appprofil["CetteSemaine"];

					}

					?>
				<div class="profil_bloc_right">

					<h1 class="<?php echo $profil->genre; ?>"><?php echo $profil->username; ?></h1>
						<div class="top">&nbsp;</div>
						<div class="center">
						<?php 
							// affichage des donn&eacute;es sp&eacute;cifiques de la page
							switch($action) {

								// MOI
								case 'view':
								?>
									<h2><?php echo $labelAnnonce; ?></h2>
									<?php echo $profil->annonce ? nl2br((string) $profil->annonce) : ucwords((string) $profil->username).$lang_appprofil["NAPasRedigeAnnonce"].' .'; ?>
								<?php 								break;


								// MES ENFANTS
								case 'view2':
								?>
									<h2><?php echo $labelMonEnfant; ?></h2>
									<?php 									// montrer photos des enfants
									if (is_array($profilEnfants)) {
									?>
										<div class="enfant">
											<table class="enfantSlide" id="enfantSlide" cellpadding="0" cellspacing="0"><tr>
											<?php 												// pour chaque enfant
												$i		= 0;
												$iMin 	= 0;
												$iMax	= count($profilEnfants)-1;
												foreach($profilEnfants as $enfant) {

													// r&eacute;cup la photo
													$file 				= $dir.'/parent-solo-enfant-'.$enfant->num.'.jpg';
													$file				= is_file($file) && $profil->photo_montrer == 2 ? $file : 'parentsolo/images/parent-solo-profil.jpg';

													// modifie le genre
													$enfant->genre		= $enfant->genre == 'f' ? $lang_appprofil["Fille"] : $lang_appprofil["Garcon"];

													?>
													<td>
														<div class="enfantProfil">
															<img src="<?php echo SITE_URL.'/'.$file; ?>" alt="<?php echo $enfant->genre; ?> de <?php echo $profil->username; ?>" />

															<table class="enfantProfilInfos">
																<tr>
																	<td class="key"><?php echo $lang_appprofil["Genre"];?></td>
																	<td><?php echo $enfant->genre; ?></td>
																</tr>
																<?php 
																if($enfant->age >= 0 && $enfant->age <= 60) {
																?>
																<tr>
																	<td class="key"><?php echo $lang_appprofil["Age"];?></td>
																	<td>
																	<?php 																		if($enfant->age > 0) {
																			echo $enfant->age > 1 ? $lang_appprofil["Ans_s"] : $lang_appprofil["An"];
																		} elseif($enfant->age == 0) { ?>
																			<?php echo $lang_appprofil["MoinDUnAn"];?>.
																			<?php 																		}
																	?>
																	</td>
																</tr>
																<?php 																}

																if($enfant->signe_astrologique) { ?>
																	<tr>
																		<td class="key"><?php echo $lang_appprofil["Signe"];?></td>
																		<td><?php echo $enfant->signe_astrologique; ?></td>
																	</tr>
																<?php } ?>
															</table>

															<a href="#" class="<?php echo $i > $iMin ? 'prev' : 'vide'; ?>" id="enfantPrev<?php echo $enfant->num; ?>">&nbsp;</a>
															<a href="#" class="<?php echo $i < $iMax ? 'next' : 'vide'; ?>" id="enfantNext<?php echo $enfant->num; ?>">&nbsp;</a>

														</div>
													</td>
													<?php 													$i++;
												}
											?>
											</tr></table>
										</div>
										<script language="javascript" type="text/javascript">
											var enfantSlide = new Fx.Morph('enfantSlide', {duration: 'short', transition: Fx.Transitions.Sine.easeOut});

											<?php 											$i		= 0;
											$iMin 	= 0;
											$iMax	= count($profilEnfants)-1;
											foreach($profilEnfants as $enfant) {

												if($i < $iMax) {
												?>
												$('enfantNext<?php echo $enfant->num; ?>').on('click', function(e){
													var leftval = $('enfantSlide').getStyle('left').toInt();
													e.stop();
													enfantSlide.start({
													    'left': [leftval, leftval-470]
													});
												});
												<?php 												}


												if($i > $iMin) {
												?>

												$('enfantPrev<?php echo $enfant->num; ?>').on('click', function(e){
													var leftval = $('enfantSlide').getStyle('left').toInt();
													e.stop();
													enfantSlide.start({
													    'left': [leftval, leftval+470]
													});
												});

												<?php 												}


												$i++;
											}
											?>
										</script>
									<?php 									} else {
										echo $profil->username.' '.$lang_appprofil["NAPasEncoreIndique"].' '.strtolower((string) $labelMonEnfant).' '.$lang_appprofil["DansSonProfil"].' .';
									}

								break;


								// MA DESCRIPTION
								case 'view3':
								?>
									<h2><?php echo $labelDescription; ?></h2>
									<table cellpadding="0" cellspacing="0">
										<tr><td class="key"><?php echo $lang_appprofil["Taille"];?></td><td><?php echo $profilDescription->taille ? $profilDescription->taille.' cm' : $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["Poids"];?></td><td><?php echo $profilDescription->poids ? $profilDescription->poids.' kg' : $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["Silhouette"];?></td><td><?php echo $profilDescription->silhouette ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["Coiffure"];?></td><td><?php echo $profilDescription->style_coiffure ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["Cheveux"];?></td><td><?php echo $profilDescription->cheveux ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["Yeux"];?></td><td><?php echo $profilDescription->yeux ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["Origine"];?></td><td><?php echo $profilDescription->origine ?: $nonRenseigne; ?></td></tr>
									</table>
								<?php 								break;


								// MES INFOS DIVERSES
								case 'view4':
								?>
									<h2><?php echo $labelInfosDiverses; ?></h2>
									<table cellpadding="0" cellspacing="0">
										<tr><td class="key"><?php echo $lang_appprofil["JeSuisNationalite"];?></td><td><?php echo $profilInfosEnVrac1->nationalite ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["JeSuisReligion"];?></td><td><?php echo $profilInfosEnVrac1->religion ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["JeParle"];?></td><td><?php echo $profilInfosEnVrac1->langues ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["MonStatutMarital"];?></td><td><?php echo $profilInfosEnVrac1->statut_marital ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["MeMarierCest"];?></td><td><?php echo $profilInfosEnVrac1->me_marier ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["JeChercheRelation"];?></td><td><?php echo $profilInfosEnVrac2->cherche_relation ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["MonNiveauEtudes"];?></td><td><?php echo $profilInfosEnVrac2->niveau_etude ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["MonSecteurActivite"];?></td><td><?php echo $profilInfosEnVrac2->secteur_activite ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["JeFume"];?></td><td><?php echo $profilInfosEnVrac2->fumer ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["JaiTemperament"];?></td><td><?php echo $profilInfosEnVrac2->temperament ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["JeveuxEnfants"];?></td><td><?php echo $profilInfosEnVrac2->vouloir_enfants ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["QuiLaGarde"];?> ?</td><td><?php echo $profilInfosEnVrac2->garde ?: $nonRenseigne; ?></td></tr>
									</table>
								<?php 								break;


								// MON QUOTIDIEN
								case 'view5':
								?>
									<h2><?php echo $labelQuotidien; ?></h2>
									<table cellpadding="0" cellspacing="0">
										<tr><td class="key"><?php echo $lang_appprofil["JeVis"];?></td><td><?php echo $profilQuotidien1->vie ?: $nonRenseigne; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["LaimeLaCuisine"];?></td><td><?php echo $profilQuotidien1->cuisines; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["JaimeSorties"];?></td><td><?php echo $profilQuotidien1->sorties; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["MesLoisirs"];?></td><td><?php echo $profilQuotidien2->loisirs; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["MesPratiquesSportives"];?></td><td><?php echo $profilQuotidien2->sports; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["jaimeMusique"];?></td><td><?php echo $profilQuotidien3->musiques; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["Jaimefilms"];?></td><td><?php echo $profilQuotidien3->films; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["JaimeLire"];?></td><td><?php echo $profilQuotidien4->lectures; ?></td></tr>
										<tr><td class="key"><?php echo $lang_appprofil["JaimeAnimaux"];?></td><td><?php echo $profilQuotidien4->animaux; ?></td></tr>
									</table>
								<?php 								break;


								// MES GROUPES
								case 'view6':
								?>
									<h2><?php echo $labelGroupes; ?></h2>
								<?php 									// s'il y a des groupes
									if (is_array($profilGroupes) > 0) {
										?>
										<table cellpadding="0" cellspacing="0" class="tableGroupesProfil">
										<?php 										$i = -1;

										// pour chaque groupe
										foreach($profilGroupes as $groupe) {

											// compteur
											$i++;

											// htmlentities
											JL::makeSafe($groupe);

											// si une photo a &eacute;t&eacute; envoy&eacute;e
											$filePath = 'images/groupe/'.$groupe->id.'-mini.jpg';
											if(is_file(SITE_PATH.'/'.$filePath)) {
												$image	= $filePath;
											} else {
												$image	= 'parentsolo/images/parent-solo-35.jpg';
											}

											// ouverture de ligne
											if($i%2 == 0) {
											?>
											<tr>
											<?php 											}

											?>
												<td class="image">
													<a href="<?php echo JL::url('index.php?app=groupe&action=details&id='.$groupe->id.'&'.$langue); ?>" title="<?php echo $groupe->titre; ?>" target="_blank"><img src="<?php echo SITE_URL.'/'.$image; ?>" alt="<?php echo $groupe->titre; ?>" /></a>
												</td>
												<td class="titre">
													<a href="<?php echo JL::url('index.php?app=groupe&action=details&id='.$groupe->id.'&'.$langue); ?>" title="<?php echo $groupe->titre; ?>" target="_blank"><?php echo $groupe->titre; ?></a>
												</td>
											<?php 
											// fermeture de ligne
											if($i%2 == 1) {
											?>
											</tr>
											<?php 											}

										}

											// fermeture de ligne car le nombre de groupes est impar
											if($i%2 == 0) {
											?>
												<td colspan="2">&nbsp;</td>
											</tr>
											<?php 											}

										?>
										</table>
									<?php 									} else {

										echo $profil->username; ?> <?php echo $lang_appprofil["NAEncoreRejoint"];?> !

									<?php 									}

								break;


								// MESSAGES ECHANGES
								case 'view7':

								break;

							}

						?>
						</div>
						<div class="bottom"></div>



						<span class="date_inscription"><?php echo $profil->genre == 'f' ? $lang_appprofil["Inscrites"] : $lang_appprofil["Inscrits"]; ?> <?php echo $lang_appprofil["DepuisLe"];?> <?php echo date('d/m/Y', strtotime((string) $profil->creation_date)); ?></span>
						<span class="last_online"><?php echo $lang_appprofil["DerniereConnexion"];?>: <span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span></span>

						<div class="profil_toolbar">
							<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$profil->username.'&'.$langue); ?>" title="Envoyer un message &agrave; <?php echo $profil->username; ?>" class="btn btn_message"><?php echo $lang_appprofil["EnvoyerMessage"];?></a>
							<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$profil->username.'&'.$langue); ?>" title="Envoyer une fleur &agrave; <?php echo $profil->username; ?>" class="btn btn_rose"><?php echo $lang_appprofil["EnvoyerRose"];?></a>
							<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index2.php?app=chat&id='.$profil->id.'&'.$langue); ?>','800px','600px');" title="Chattez avec <?php echo $profil->username; ?>" class="btn btn_chat"><?php echo $lang_appprofil["CHAT"];?></a>
							<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$profil->id.'&'.$langue); ?>" title="Ajouter <?php echo $profil->username; ?> &agrave; ma liste de favoris" class="btn2 btn_favoris"><?php echo $lang_appprofil["AjouterFavoris"];?></a>
							<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$profil->id.'&'.$langue); ?>" title="Ajouter <?php echo $profil->username; ?> &agrave; ma liste noire" class="btn2 btn_black"><?php echo $lang_appprofil["bloquerMembre"];?></a>
							<a href="<?php echo JL::url('index.php?app=redac&action=item&id=8&user_id_to='.$profil->id.'&'.$langue); ?>" title="Signaler un abus" class="btn2 btn_abus"><?php echo $lang_appprofil["SignalerAbus"];?></a>
						</div>

					</div>

					<div class="profil_bloc_left">
						<div class="top"> </div>
						<div class="photos photos<?php echo $photosNb > 1 ? 1 : 0; ?>">
							<img src="<?php echo $photoDefaut; ?>" alt="Parent c&eacute;libataire <?php echo $profil->username; ?>" class="big" id="profilPhotoDefaut" />
							<?php 
							// s'il y a plus d'une photo
							if($photosNb > 1) {
								$i = 0;

								// pour chaque photo
								foreach($photos as $photo) {

									// on limite &agrave; 6 photos
									if($i < 6) {
										$photo_i = preg_replace('#^.*([0-9]{1}).*$#', '$1', $photo);

										?>
											<img src="<?php echo SITE_URL.'/'.$photo; ?>" alt="<?php echo $lang_appprofil["PArentCelib"];?> <?php echo $profil->username; ?>, <?php echo $lang_appprofil["photoMin"];?> <?php echo $photo_i; ?>" class="mini photo<?php echo $i; ?>" id="profilPhoto<?php echo $photo_i; ?>" onClick="javascript:setProfilPhoto('<?php echo $profil->id; ?>', '<?php echo $photo_i; ?>');" />
										<?php 										$i++;
									}

								}
							}
						?>

						</div>
						<div class="bottom"> </div>

						<div class="profil_mini">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td class="key"><?php echo $lang_appprofil["Age"];?></td><td><?php echo $profil->age; ?> <?php echo $lang_appprofil["Ans"];?></td>
								</tr>
								<tr>
									<td class="key"><?php echo $labelMonEnfant;?></td><td><?php echo $profil->nb_enfants; ?> <?php echo $profil->nb_enfants > 1 ? $lang_appprofil["enfants_s"] : $lang_appprofil["enfant_s"]; ?></td>
								</tr>
								<tr>
									<td class="key"><?php echo $lang_appprofil["Canton"];?></td><td><?php echo $profil->canton; ?></td>
								</tr>
								<tr>
									<td class="key"><?php echo $lang_appprofil["Ville"];?></td><td><?php echo $profil->ville ?: $lang_appprofil["NonRenseigne"]; ?></td>
								</tr>
							</table><br />
							<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action=results'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["RetourRecherche"];?>" class="bouton step_previous">&laquo; <?php echo $lang_appprofil["RetourRecherche"];?></a>
						</div>
					</div>

					<?php JL::loadMod('profil_banner'); ?>

				<?php 				} elseif($profil->id && $profil->accessok == 0) { // profil n'existe pas
				?>
					<p class="noaccess noaccess<?php echo $profil->genre; ?>"><?php echo $lang_appprofil["LeProfilDe"];?> <b><?php echo $profil->username; ?></b> <?php echo $lang_appprofil["NEstPAsAccessible"];?> <b><?php echo $profil->genre == 'h' ? $lang_appprofil["Papas"] : $lang_appprofil["Mamans"]; ?></b> !</p><br />
					<br />
					<a class="bouton return_home" title="<?php echo $lang_appprofil["RetourAccueilTitle"];?>" href="<?php echo SITE_URL; ?>">&laquo; <?php echo $lang_appprofil["RetourAccueil"];?></a>
				<?php 				} else {
				?>
					<p class="noaccess"><?php echo $lang_appprofil["CeProfilNEstPasAccessible"];?> !</p><br />
					<br />
					<a class="bouton return_home" title="<?php echo $lang_appprofil["RetourAccueilTitle"];?>" href="<?php echo SITE_URL; ?>">&laquo; <?php echo $lang_appprofil["RetourAccueil"];?></a>
				<?php 				}
				?>

			</div> <?php // fin app_body ?>
			<?php 
			// colonne de gauche
			JL::loadMod('profil_panel');

			?>
			<div class="clear"> </div>
			<?php 
		}

		// r&eacute;cup&egrave;re les 3 $field dans l'objet $obj, pour retourner une chaine concat&eacute;n&eacute;e avec les valeurs renseign&eacute;es, sinon retourne $defaut
		function profil3values(&$obj, $field, $defaut) {
			global $langue;

			// variables
			$tab	= [];

			if($obj->{$field.'1'}) {
				$tab[]	= $obj->{$field.'1'};
			}
			if($obj->{$field.'2'}) {
				$tab[]	= $obj->{$field.'2'};
			}
			if($obj->{$field.'3'}) {
				$tab[]	= $obj->{$field.'3'};
			}

			if (is_array($tab)) {
				return implode(', ', $tab);
			} else {
				return $defaut;
			}

		}


		// affichage des conditions g&eacute;n&eacute;rales en popup
		function conditionsPopUp($texte) {
			global $langue;
		?>
			<style>
				body {background:#000;color:#fff;font-size:11px;font-family:Verdana,Arial,Helvetica;}
				h1,h2 {font-size:18px;font-weight:bold;color:#CC0066;padding:0 0 0 25px;background:url(<?php echo SITE_URL; ?>/parentsolo/images/flower.jpg) left no-repeat;}
				p{padding:10px;}
			</style>

			<?php echo $texte; ?>

		<?php 		}

	}
?>
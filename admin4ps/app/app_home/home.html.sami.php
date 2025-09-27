<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class home_HTML {
		
		// affiche le contenu de la page d'accueil
		function home(&$rows, &$profils, &$list) {
			
			// chemin du template
			$template = SITE_URL.'/parentsolo';
			
			?>
				<div class="home">
				
					<div class="actu">
						<h1>Site de rencontre pour les parents c&eacute;libataires en Suisse</h1>
						<?php // affichage des 4 derni�res news
							if (is_array($rows)) {
								$i = 1;
								?>
								<ul>
								<?php 								foreach($rows as $row) {
									JL::makeSafe($row);
									?>
										<li class="li<?php echo $i; ?>"><a href="<?php echo JL::url('index.php?app=redac&action=item&id='.$row->id); ?>" title="<?php echo $row->titre; ?>">&raquo; <?php echo $row->titre; ?></a><br />
										<span>actualit&eacute; du <?php echo date('d/m/Y', strtotime($row->date_add)); ?></span></li>
									<?php 									$i++;
								}
								?>
								</ul>
							<?php 							}
						?>
						
						<a href="<?php echo JL::url('index.php?app=points&action=info'); ?>" title="Syst&egrave;me de points solocircl.com, gagnez des SmartBox d'une valeur de CHF 500.- !" class="smartbox-home">Des cadeaux originaux &agrave; gagner pour tous les papas et les mamans c&eacute;libataires !</a>
						
					</div>
					
					<div class="blocs4">
						<div class="bloc1">
							<a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" class="image" target="_blank" title="Love Coaching, laFamily">&nbsp;</a>
							<h2>Love coaching</h2>
							De quoi &eacute;viter les d&eacute;ceptions et faire des connaissances vraiment cibl&eacute;es, qui ont toutes leurs chances de se concr&eacute;tiser. Alors n'h&eacute;sitez plus, Love Coaching par <a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" target="_blank" title="Love Coaching, laFamily">laFamily</a> et retrouvez les parents c&eacute;libataires suisses sur solocircl.com, <a href="<?php echo JL::url('index.php?app=profil&action=inscription'); ?>" title="Parent c&eacute;libataire, inscription gratuite">l'inscription est gratuite</a> !<br />
							<br />
							<center><a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" target="_blank" title="Obtenir plus d'information sur le Love Coaching, laFamily"><img src="<?php echo SITE_URL; ?>/parentsolo/images/lafamily-informations.jpg" alt="Plus d'informations" /></a></center>
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc2">
							<a href="#" onClick="javascript:popup('http://www.solocircl.com/concept.php');" title="Concept unique en Europe" class="image">&nbsp;</a>
							<h2>Parents c&eacute;libataires</h2>
							D'apr&egrave;s les sondages r&eacute;alis&eacute;s, pr&egrave;s de 90% des personnes concern&eacute;es sont int&eacute;ress&eacute;es par ce <a href="#" onClick="javascript:popup('http://www.solocircl.com/concept.php');" title="Concept unique en Europe">concept</a> de <strong>site r&eacute;serv&eacute; aux parents c&eacute;libataires</strong>. A l'inverse, 70% des <strong>c&eacute;libataires</strong> sans <strong>enfants</strong> ne sont pas attir&eacute;s par ce type de site.
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc3">
							<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>" title="Appels &agrave; t&eacute;moins propos&eacute;s par des m&eacute;dias" class="image">Appels &agrave; t&eacute;moins</a>
							<h2>Appels &agrave; t&eacute;moins</h2>
							<b>Vous faites partie des m&eacute;dias</b> et souhaitez <a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=new'); ?>" title="Lancer un appel &agrave; t&eacute;moins pour parents solos">lancer un appel &agrave; t&eacute;moins</a> ?
							<br />
							<br />
							Vous souhaitez faire part de votre exp&eacute;rience de <b>parent c&eacute;libataire</b> &agrave; la radio, la t&eacute;l&eacute; ou dans la presse ? Alors consultez notre rubrique &laquo; <a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>" title="Appels &agrave; t&eacute;moins propos&eacute;s par des m&eacute;dias">Appels &agrave; t&eacute;moins</a> &raquo; pour d�couvrir les annonces des m&eacute;dias !
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc4">
							<a href="<?php echo JL::url('index.php?app=temoignage&action=list'); ?>" title="T&eacute;moignages de membres de solocircl.com" class="image">Enfin r&eacute;unis !</a>
							<h2>T&eacute;moignages</h2>
							D&eacute;couvrez les <a href="<?php echo JL::url('index.php?app=temoignage&action=list'); ?>" title="T&eacute;moignages de membres de solocircl.com">t&eacute;moignages</a> des parents solos s'&eacute;tant trouv&eacute;s sur solocircl.com !<br />
							<br />
							Vous vous &ecirc;tes rencontr&eacute;s sur solocircl.com ? <a href="<?php echo JL::url('index.php?app=temoignage&action=new'); ?>" title="Votre t&eacute;moignage sur solocircl.com">Votre histoire</a> nous int&eacute;resse !
						</div>
						<div class="clear"> </div>
					</div>
					
					<div id="imageflow"> 
						<div id="loading">
							<img src="<?php echo SITE_URL; ?>/images/loading.gif" alt="Chargement des derniers inscrits" />
						</div>
						<div id="images">
						<?php 							// galerie photos
							foreach($profils as $profil) {
								
								// photo galerie g�n�r�e
								$photo = SITE_URL.'/images/galerie/'.$profil->photo;
								
								?>
								<img src="<?php echo $photo; ?>" alt="Parent solo Suisse <?php echo makeSafe($profil->username); ?>" id="<?php echo JL::url('index.php?app=profil&action=view&id='.$profil->id); ?>" />
							<?php 							}

						?>
						</div>
						
					</div>
					
					<div class="inscriptionMini">
						<h2>Inscription gratuite</h2>
						
						<form action="<?php echo JL::url('index.php?app=profil&action=inscription'); ?>" name="inscriptionMini" method="post">
							<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
							<input type="hidden" name="inscriptionrapide" value="1" />
							<table cellpadding="0" cellspacing="0">
								<tr><td class="key">Je suis</td><td><?php echo $list['genre']; ?></td></tr>
								<tr><td class="key">N&eacute;(e) le</td><td><?php echo $list['naissance_jour'].$list['naissance_mois'].$list['naissance_annee']; ?></td></tr>
								<tr><td class="key">J'ai</td><td><?php echo $list['nb_enfants']; ?> enfant(s)</td></tr>
								<tr><td class="key">J'habite dans le canton de</td><td><?php echo $list['canton_id']; ?></td></tr>
								<tr><td class="key">&agrave;</td><td id="villes"><?php echo $list['ville_id']; ?></td></tr>
							</table>
						</form>
						
						<a href="javascript:document.inscriptionMini.submit();" title="Je m'inscris">Je m'inscris</a>
						
					</div>
					
				</div>
				
				<div class="banner_right">
					<div id="banner_right"></div>
				</div>
				
			<?php 		}
		
	}
?><?php

	// s�curit�
	defined('JL') or die('Error 401');
	class home_HTML {
		
		// affiche le contenu de la page d'accueil
		function home(&$rows, &$profils, &$list) {
			
			// chemin du template
			$template = SITE_URL.'/parentsolo';
			include("lang/app_home.".$_GET['lang'].".php");
			
			?>
				<div class="home">
				
					<div class="actu">
						<h1><?php echo $lang_apphome["SiteRencontreParents"];?></h1>
						<?php // affichage des 4 derni�res news
							if (is_array($rows)) {
								$i = 1;
								?>
								<ul>
								<?php 								foreach($rows as $row) {
									JL::makeSafe($row);
									?>
										<li class="li<?php echo $i; ?>"><a href="<?php echo JL::url('index.php?app=redac&action=item&id='.$row->id.'&'.$langue); ?>" title="<?php echo $row->titre; ?>">&raquo; <?php echo $row->titre; ?></a><br />
										<span><?php echo $lang_apphome["ActualiteDu"];?> <?php echo date('d/m/Y', strtotime($row->date_add)); ?></span></li>
									<?php 									$i++;
								}
								?>
								</ul>
							<?php 							}
						?>
						
						<a href="<?php echo JL::url('index.php?app=points&action=info').'&'.$langue; ?>" title="Syst&egrave;me de points solocircl.com, gagnez des SmartBox d'une valeur de CHF 500.- !" class="smartbox-home"><?php echo $lang_apphome["CadeauOriginauxGagner"];?></a>
						
					</div>
					
					<div class="blocs4">
						<div class="bloc1">
							<a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" class="image" target="_blank" title="Love Coaching, laFamily">&nbsp;</a>
							<h2><?php echo $lang_apphome["LoveCoaching"];?></h2>
							<?php echo $lang_apphome["DeQuoiEviterLesDeceptions"];?> <a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" target="_blank" title="Love Coaching, laFamily"><?php echo $lang_apphome["LaFamily"];?></a> <?php echo $lang_apphome["RetrouverLesParents"];?>, <a href="<?php echo JL::url('index.php?app=profil&action=inscription').'&'.$langue; ?>" title="Parent c&eacute;libataire, inscription gratuite"><?php echo $lang_apphome["InscriptionGratuite"];?></a> !<br />
							<br />
							<center><a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" target="_blank" title="Obtenir plus d'information sur le Love Coaching, laFamily"><img src="<?php echo SITE_URL; ?>/parentsolo/images/lafamily-informations.jpg" alt="Plus d'informations" /></a></center>
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc2">
							<a href="#" onClick="javascript:popup('http://www.solocircl.com/concept.php');" title="Concept unique en Europe" class="image">&nbsp;</a>
							<h2><?php echo $lang_apphome["ParentsCelibataires"];?></h2>
							<?php echo $lang_apphome["LesSondagesRealises"];?> <a href="#" onClick="javascript:popup('http://www.solocircl.com/concept.php');" title="Concept unique en Europe"><?php echo $lang_apphome["Concept"];?></a> <?php echo $lang_apphome["De"];?> <strong><?php echo $lang_apphome["SiteReserveAuxParents"];?></strong>. <?php echo $lang_apphome["ALinverse70des"];?> <strong><?php echo $lang_apphome["Celibataires"];?></strong> <?php echo $lang_apphome["Sans"];?> <strong><?php echo $lang_apphome["Enfants"];?></strong> <?php echo $lang_apphome["SontPasAttiresParType"];?>ne sont pas attir&eacute;s par ce type de site.
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc3">
							<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list').'&'.$langue; ?>" title="Appels &agrave; t&eacute;moins propos&eacute;s par des m&eacute;dias" class="image"><?php echo $lang_apphome["AppelsTemoins"];?></a>
							<h2><?php echo $lang_apphome["AppelsTemoins"];?></h2>
							<b><?php echo $lang_apphome["VousFaitesPartieDesMedias"];?></b> <?php echo $lang_apphome["EtSouhaitez"];?> <a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=new').'&'.$langue; ?>" title="Lancer un appel &agrave; t&eacute;moins pour parents solos"><?php echo $lang_apphome["LancerUnAppel"];?></a> ?
							<br />
							<br />
							<?php echo $lang_apphome["VousSouhaitezFairePart"];?> <b><?php echo $lang_apphome["ParentCelibataire"];?></b> <?php echo $lang_apphome["RadioTelePresse"];?> &laquo; <a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list').'&'.$langue; ?>" title="Appels &agrave; t&eacute;moins propos&eacute;s par des m&eacute;dias"><?php echo $lang_apphome["AppelsATemoins"];?></a> &raquo; <?php echo $lang_apphome["PourDecouvrirLesAnnonces"];?> !
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc4">
							<a href="<?php echo JL::url('index.php?app=temoignage&action=list').'&'.$langue; ?>" title="T&eacute;moignages de membres de solocircl.com" class="image"><?php echo $lang_apphome["Enfinreunis"];?> !</a>
							<h2><?php echo $lang_apphome["Temoignages"];?></h2>
							<?php echo $lang_apphome["DecouvrezLes"];?> <a href="<?php echo JL::url('index.php?app=temoignage&action=list').'&'.$langue; ?>" title="T&eacute;moignages de membres de solocircl.com"><?php echo $lang_apphome["temoignage"];?></a> <?php echo $lang_apphome["DesParentsSolos"];?> !<br />
							<br />
							<?php echo $lang_apphome["VousEtesRencontres"];?> ? <a href="<?php echo JL::url('index.php?app=temoignage&action=new').'&'.$langue; ?>" title="Votre t&eacute;moignage sur solocircl.com"><?php echo $lang_apphome["VotreHistoire"];?></a> <?php echo $lang_apphome["NousInteresse"];?> !
						</div>
						<div class="clear"> </div>
					</div>
					
					<div id="imageflow"> 
						<div id="loading">
							<img src="<?php echo SITE_URL; ?>/images/loading.gif" alt="Chargement des derniers inscrits" />
						</div>
						<div id="images">
						<?php 							// galerie photos
							foreach($profils as $profil) {
								
								// photo galerie g�n�r�e
								$photo = SITE_URL.'/images/galerie/'.$profil->photo;
								
								?>
								<img src="<?php echo $photo; ?>" alt="Parent solo Suisse <?php echo makeSafe($profil->username); ?>" id="<?php echo JL::url('index.php?app=profil&action=view&id='.$profil->id); ?>" />
							<?php 							}

						?>
						</div>
						
					</div>
					
					<div class="inscriptionMini">
						<h2><?php echo $lang_apphome["InscriptionGratuite"];?></h2>
						
						<form action="<?php echo JL::url('index.php?app=profil&action=inscription').'&'.$langue; ?>" name="inscriptionMini" method="post">
							<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
							<input type="hidden" name="inscriptionrapide" value="1" />
							<table cellpadding="0" cellspacing="0">
								<tr><td class="key"><?php echo $lang_apphome["JeSuis"];?></td><td><?php echo $list['genre']; ?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["NeeLe"];?></td><td><?php echo $list['naissance_jour'].$list['naissance_mois'].$list['naissance_annee']; ?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["JAi"];?></td><td><?php echo $list['nb_enfants']; ?> <?php echo $lang_apphome["Enfant-s"];?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["JHabiteDansCanton"];?></td><td><?php echo $list['canton_id']; ?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["A"];?></td><td id="villes"><?php echo $list['ville_id']; ?></td></tr>
							</table>
						</form>
						
						<a href="javascript:document.inscriptionMini.submit();" title="Je m'inscris"><?php echo $lang_apphome["JeMInscris"];?></a>
						
					</div>
					
				</div>
				
				<div class="banner_right">
					<div id="banner_right"></div>
				</div>
				
			<?php 		}
		
	}
?><?php

	// s�curit�
	defined('JL') or die('Error 401');
	class home_HTML {
		
		// affiche le contenu de la page d'accueil
		function home(&$rows, &$profils, &$list) {
			
			// chemin du template
			$template = SITE_URL.'/parentsolo';
			include("lang/app_home.".$_GET['lang'].".php");
			
			?>
				<div class="home">
				
					<div class="actu">
						<h1><?php echo $lang_apphome["SiteRencontreParents"];?></h1>
						<?php // affichage des 4 derni�res news
							if (is_array($rows)) {
								$i = 1;
								?>
								<ul>
								<?php 								foreach($rows as $row) {
									JL::makeSafe($row);
									?>
										<li class="li<?php echo $i; ?>"><a href="<?php echo JL::url('index.php?app=redac&action=item&id='.$row->id.'&'.$langue); ?>" title="<?php echo $row->titre; ?>">&raquo; <?php echo $row->titre; ?></a><br />
										<span><?php echo $lang_apphome["ActualiteDu"];?> <?php echo date('d/m/Y', strtotime($row->date_add)); ?></span></li>
									<?php 									$i++;
								}
								?>
								</ul>
							<?php 							}
						?>
						
						<a href="<?php echo JL::url('index.php?app=points&action=info').'&'.$langue; ?>" title="Syst&egrave;me de points solocircl.com, gagnez des SmartBox d'une valeur de CHF 500.- !" class="smartbox-home"><?php echo $lang_apphome["CadeauOriginauxGagner"];?></a>
						
					</div>
					
					<div class="blocs4">
						<div class="bloc1">
							<a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" class="image" target="_blank" title="Love Coaching, laFamily">&nbsp;</a>
							<h2><?php echo $lang_apphome["LoveCoaching"];?></h2>
							<?php echo $lang_apphome["DeQuoiEviterLesDeceptions"];?> <a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" target="_blank" title="Love Coaching, laFamily"><?php echo $lang_apphome["LaFamily"];?></a> <?php echo $lang_apphome["RetrouverLesParents"];?>, <a href="<?php echo JL::url('index.php?app=profil&action=inscription').'&'.$langue; ?>" title="Parent c&eacute;libataire, inscription gratuite"><?php echo $lang_apphome["InscriptionGratuite"];?></a> !<br />
							<br />
							<center><a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" target="_blank" title="Obtenir plus d'information sur le Love Coaching, laFamily"><img src="<?php echo SITE_URL; ?>/parentsolo/images/lafamily-informations.jpg" alt="Plus d'informations" /></a></center>
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc2">
							<a href="#" onClick="javascript:popup('http://www.solocircl.com/concept.php');" title="Concept unique en Europe" class="image">&nbsp;</a>
							<h2><?php echo $lang_apphome["ParentsCelibataires"];?></h2>
							<?php echo $lang_apphome["LesSondagesRealises"];?> <a href="#" onClick="javascript:popup('http://www.solocircl.com/concept.php');" title="Concept unique en Europe"><?php echo $lang_apphome["Concept"];?></a> <?php echo $lang_apphome["De"];?> <strong><?php echo $lang_apphome["SiteReserveAuxParents"];?></strong>. <?php echo $lang_apphome["ALinverse70des"];?> <strong><?php echo $lang_apphome["Celibataires"];?></strong> <?php echo $lang_apphome["Sans"];?> <strong><?php echo $lang_apphome["Enfants"];?></strong> <?php echo $lang_apphome["SontPasAttiresParType"];?>ne sont pas attir&eacute;s par ce type de site.
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc3">
							<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list').'&'.$langue; ?>" title="Appels &agrave; t&eacute;moins propos&eacute;s par des m&eacute;dias" class="image"><?php echo $lang_apphome["AppelsTemoins"];?></a>
							<h2><?php echo $lang_apphome["AppelsTemoins"];?></h2>
							<b><?php echo $lang_apphome["VousFaitesPartieDesMedias"];?></b> <?php echo $lang_apphome["EtSouhaitez"];?> <a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=new').'&'.$langue; ?>" title="Lancer un appel &agrave; t&eacute;moins pour parents solos"><?php echo $lang_apphome["LancerUnAppel"];?></a> ?
							<br />
							<br />
							<?php echo $lang_apphome["VousSouhaitezFairePart"];?> <b><?php echo $lang_apphome["ParentCelibataire"];?></b> <?php echo $lang_apphome["RadioTelePresse"];?> &laquo; <a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list').'&'.$langue; ?>" title="Appels &agrave; t&eacute;moins propos&eacute;s par des m&eacute;dias"><?php echo $lang_apphome["AppelsATemoins"];?></a> &raquo; <?php echo $lang_apphome["PourDecouvrirLesAnnonces"];?> !
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc4">
							<a href="<?php echo JL::url('index.php?app=temoignage&action=list').'&'.$langue; ?>" title="T&eacute;moignages de membres de solocircl.com" class="image"><?php echo $lang_apphome["Enfinreunis"];?> !</a>
							<h2><?php echo $lang_apphome["Temoignages"];?></h2>
							<?php echo $lang_apphome["DecouvrezLes"];?> <a href="<?php echo JL::url('index.php?app=temoignage&action=list').'&'.$langue; ?>" title="T&eacute;moignages de membres de solocircl.com"><?php echo $lang_apphome["temoignage"];?></a> <?php echo $lang_apphome["DesParentsSolos"];?> !<br />
							<br />
							<?php echo $lang_apphome["VousEtesRencontres"];?> ? <a href="<?php echo JL::url('index.php?app=temoignage&action=new').'&'.$langue; ?>" title="Votre t&eacute;moignage sur solocircl.com"><?php echo $lang_apphome["VotreHistoire"];?></a> <?php echo $lang_apphome["NousInteresse"];?> !
						</div>
						<div class="clear"> </div>
					</div>
					
					<div id="imageflow"> 
						<div id="loading">
							<img src="<?php echo SITE_URL; ?>/images/loading.gif" alt="Chargement des derniers inscrits" />
						</div>
						<div id="images">
						<?php 							// galerie photos
							foreach($profils as $profil) {
								
								// photo galerie g�n�r�e
								$photo = SITE_URL.'/images/galerie/'.$profil->photo;
								
								?>
								<img src="<?php echo $photo; ?>" alt="Parent solo Suisse <?php echo makeSafe($profil->username); ?>" id="<?php echo JL::url('index.php?app=profil&action=view&id='.$profil->id); ?>" />
							<?php 							}

						?>
						</div>
						
					</div>
					
					<div class="inscriptionMini">
						<h2><?php echo $lang_apphome["InscriptionGratuite"];?></h2>
						
						<form action="<?php echo JL::url('index.php?app=profil&action=inscription'.'&'.$langue);?>" name="inscriptionMini" method="post">
							<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
							<input type="hidden" name="inscriptionrapide" value="1" />
							<table cellpadding="0" cellspacing="0">
								<tr><td class="key"><?php echo $lang_apphome["JeSuis"];?></td><td><?php echo $list['genre']; ?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["NeeLe"];?></td><td><?php echo $list['naissance_jour'].$list['naissance_mois'].$list['naissance_annee']; ?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["JAi"];?></td><td><?php echo $list['nb_enfants']; ?> <?php echo $lang_apphome["Enfant-s"];?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["JHabiteDansCanton"];?></td><td><?php echo $list['canton_id']; ?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["A"];?></td><td id="villes"><?php echo $list['ville_id']; ?></td></tr>
							</table>
						</form>
						
						<a href="javascript:document.inscriptionMini.submit();" title="Je m'inscris"><?php echo $lang_apphome["JeMInscris"];?></a>
						
					</div>
					
				</div>
				
				<div class="banner_right">
					<div id="banner_right"></div>
				</div>
				
			<?php 		}
		
	}
?><?php

	// s�curit�
	defined('JL') or die('Error 401');
	class home_HTML {
		
		// affiche le contenu de la page d'accueil
		function home(&$rows, &$profils, &$list) {
			
			// chemin du template
			$template = SITE_URL.'/parentsolo';
			include("lang/app_home.".$_GET['lang'].".php");
			
			?>
				<div class="home">
				
					<div class="actu">
						<h1><?php echo $lang_apphome["SiteRencontreParents"];?></h1>
						<?php // affichage des 4 derni�res news
							if (is_array($rows)) {
								$i = 1;
								?>
								<ul>
								<?php 								foreach($rows as $row) {
									JL::makeSafe($row);
									?>
										<li class="li<?php echo $i; ?>"><a href="<?php echo JL::url('index.php?app=redac&action=item&id='.$row->id.'&'.$langue); ?>" title="<?php echo $row->titre; ?>">&raquo; <?php echo $row->titre; ?></a><br />
										<span><?php echo $lang_apphome["ActualiteDu"];?> <?php echo date('d/m/Y', strtotime($row->date_add)); ?></span></li>
									<?php 									$i++;
								}
								?>
								</ul>
							<?php 							}
						?>
						
						<a href="<?php echo JL::url('index.php?app=points&action=info').'&'.$langue; ?>" title="Syst&egrave;me de points solocircl.com, gagnez des SmartBox d'une valeur de CHF 500.- !" class="smartbox-home"><?php echo $lang_apphome["CadeauOriginauxGagner"];?></a>
						
					</div>
					
					<div class="blocs4">
						<div class="bloc1">
							<a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" class="image" target="_blank" title="Love Coaching, laFamily">&nbsp;</a>
							<h2><?php echo $lang_apphome["LoveCoaching"];?></h2>
							<?php echo $lang_apphome["DeQuoiEviterLesDeceptions"];?> <a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" target="_blank" title="Love Coaching, laFamily"><?php echo $lang_apphome["LaFamily"];?></a> <?php echo $lang_apphome["RetrouverLesParents"];?>, <a href="<?php echo JL::url('index.php?app=profil&action=inscription').'&'.$langue; ?>" title="Parent c&eacute;libataire, inscription gratuite"><?php echo $lang_apphome["InscriptionGratuite"];?></a> !<br />
							<br />
							<center><a href="http://www.vaudfamille.ch/N188258/love-coaching_parents-solos.html" target="_blank" title="Obtenir plus d'information sur le Love Coaching, laFamily"><img src="<?php echo SITE_URL; ?>/parentsolo/images/lafamily-informations.jpg" alt="Plus d'informations" /></a></center>
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc2">
							<a href="#" onClick="javascript:popup('http://www.solocircl.com/concept.php');" title="Concept unique en Europe" class="image">&nbsp;</a>
							<h2><?php echo $lang_apphome["ParentsCelibataires"];?></h2>
							<?php echo $lang_apphome["LesSondagesRealises"];?> <a href="#" onClick="javascript:popup('http://www.solocircl.com/concept.php');" title="Concept unique en Europe"><?php echo $lang_apphome["Concept"];?></a> <?php echo $lang_apphome["De"];?> <strong><?php echo $lang_apphome["SiteReserveAuxParents"];?></strong>. <?php echo $lang_apphome["ALinverse70des"];?> <strong><?php echo $lang_apphome["Celibataires"];?></strong> <?php echo $lang_apphome["Sans"];?> <strong><?php echo $lang_apphome["Enfants"];?></strong> <?php echo $lang_apphome["SontPasAttiresParType"];?>ne sont pas attir&eacute;s par ce type de site.
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc3">
							<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list').'&'.$langue; ?>" title="Appels &agrave; t&eacute;moins propos&eacute;s par des m&eacute;dias" class="image"><?php echo $lang_apphome["AppelsTemoins"];?></a>
							<h2><?php echo $lang_apphome["AppelsTemoins"];?></h2>
							<b><?php echo $lang_apphome["VousFaitesPartieDesMedias"];?></b> <?php echo $lang_apphome["EtSouhaitez"];?> <a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=new').'&'.$langue; ?>" title="Lancer un appel &agrave; t&eacute;moins pour parents solos"><?php echo $lang_apphome["LancerUnAppel"];?></a> ?
							<br />
							<br />
							<?php echo $lang_apphome["VousSouhaitezFairePart"];?> <b><?php echo $lang_apphome["ParentCelibataire"];?></b> <?php echo $lang_apphome["RadioTelePresse"];?> &laquo; <a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list').'&'.$langue; ?>" title="Appels &agrave; t&eacute;moins propos&eacute;s par des m&eacute;dias"><?php echo $lang_apphome["AppelsATemoins"];?></a> &raquo; <?php echo $lang_apphome["PourDecouvrirLesAnnonces"];?> !
						</div>
						<div class="bloc-sep">&nbsp;</div>
						<div class="bloc4">
							<a href="<?php echo JL::url('index.php?app=temoignage&action=list').'&'.$langue; ?>" title="T&eacute;moignages de membres de solocircl.com" class="image"><?php echo $lang_apphome["Enfinreunis"];?> !</a>
							<h2><?php echo $lang_apphome["Temoignages"];?></h2>
							<?php echo $lang_apphome["DecouvrezLes"];?> <a href="<?php echo JL::url('index.php?app=temoignage&action=list').'&'.$langue; ?>" title="T&eacute;moignages de membres de solocircl.com"><?php echo $lang_apphome["temoignage"];?></a> <?php echo $lang_apphome["DesParentsSolos"];?> !<br />
							<br />
							<?php echo $lang_apphome["VousEtesRencontres"];?> ? <a href="<?php echo JL::url('index.php?app=temoignage&action=new').'&'.$langue; ?>" title="Votre t&eacute;moignage sur solocircl.com"><?php echo $lang_apphome["VotreHistoire"];?></a> <?php echo $lang_apphome["NousInteresse"];?> !
						</div>
						<div class="clear"> </div>
					</div>
					
					<div id="imageflow"> 
						<div id="loading">
							<img src="<?php echo SITE_URL; ?>/images/loading.gif" alt="Chargement des derniers inscrits" />
						</div>
						<div id="images">
						<?php 							// galerie photos
							foreach($profils as $profil) {
								
								// photo galerie g�n�r�e
								$photo = SITE_URL.'/images/galerie/'.$profil->photo;
								
								?>
								<img src="<?php echo $photo; ?>" alt="Parent solo Suisse <?php echo makeSafe($profil->username); ?>" id="<?php echo JL::url('index.php?app=profil&action=view&id='.$profil->id); ?>" />
							<?php 							}

						?>
						</div>
						
					</div>
					
					<div class="inscriptionMini">
						<h2><?php echo $lang_apphome["InscriptionGratuite"];?></h2>
						
						<form action="<?php echo JL::url('index.php?app=profil&action=inscription').'&lang='.$_GET['lang'];?>" name="inscriptionMini" method="post">
							<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
							<input type="hidden" name="inscriptionrapide" value="1" />
							<table cellpadding="0" cellspacing="0">
								<tr><td class="key"><?php echo $lang_apphome["JeSuis"];?></td><td><?php echo $list['genre']; ?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["NeeLe"];?></td><td><?php echo $list['naissance_jour'].$list['naissance_mois'].$list['naissance_annee']; ?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["JAi"];?></td><td><?php echo $list['nb_enfants']; ?> <?php echo $lang_apphome["Enfant-s"];?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["JHabiteDansCanton"];?></td><td><?php echo $list['canton_id']; ?></td></tr>
								<tr><td class="key"><?php echo $lang_apphome["A"];?></td><td id="villes"><?php echo $list['ville_id']; ?></td></tr>
							</table>
						</form>
						
						<a href="javascript:document.inscriptionMini.submit();" title="Je m'inscris"><?php echo $lang_apphome["JeMInscris"];?></a>
						
					</div>
					
				</div>
				
				<div class="banner_right">
					<div id="banner_right"></div>
				</div>
				
			<?php 		}
		
	}
?>
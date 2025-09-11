<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class homeView extends JLView {
	
		function homeView() {}
		
		
		function display($auth='', &$profils, &$list, &$colonne_1, &$colonne_2, &$colonne_3, &$colonne_4, &$partenaire_l, &$actualites, &$partenaire_r) {
			include("lang/app_home.".$_GET['lang'].".php");
			global $db, $template;
			
		?>
			
			<!-- Partie Droite -->
		<?
			$i=0;
			foreach($profils as $profil){
				JL::makeSafe($profil);
				if(is_file('images/profil/'.$profil->id.'/parent-solo-109-profil-'.$profil->photo_defaut.'.jpg')){
					$i++;
				}
			}
		?>
			
			<!--Photo d&eacute;filante des membres-->
			<div id="defile">
				<div class="btn" id="defilePrev"></div>
				<div class="images">
					<div id="defileGalerie" rel="<? echo $i;?>">
					<?
						foreach($profils as $profil){
							JL::makeSafe($profil);
							if(is_file('images/profil/'.$profil->id.'/parent-solo-109-profil-'.$profil->photo_defaut.'.jpg')){
							?>
								<div class="image">
									<a title="<? echo $profil->username; ?>" href="<? echo JL::url('index.php?app=profil&action=view&id='.$profil->id.'&lang='.$_GET['lang']);?>"></a>
									<div class="cache"></div>
									<img src="<? echo SITE_URL; ?>/images/profil/<? echo $profil->id;?>/parent-solo-109-profil-<? echo $profil->photo_defaut; ?>.jpg" alt="<? echo $profil->username; ?>" onclick="" />
								</div>
							<?
							}
						}
					?>
					</div>
				</div>
				<div class="btn" id="defileNext"></div>
			</div>
			<div class="content">
				<div class="contentl">
					<div class="colc">
						<h1><?php echo $lang_apphome["SiteDeRencontrePour..."];?></h1>
						<br />
						
						<div class="pastille_conseil_amis"><a href="<? echo JL::url('index.php?app=conseil').'&lang='.$_GET['lang'];?>"><img src="<? echo SITE_URL; ?>/parentsolo/images/app_home/pastille_conseil_amis-<? echo $_GET['lang']; ?>.png"  /></a></div>
						<!--Cr&eacute;ation du profil-->
						<div class="inscription">
								
							<h2><?php echo $lang_apphome["InscriptionGratuite"];?></h2>
							<br />
							<form action="<? echo JL::url('index.php?app=inscription').'&lang='.$_GET['lang'];?>" name="inscriptionMini" method="post">
								<input type="hidden" name="site_url" id="site_url" value="<? echo SITE_URL; ?>" />
								<input type="hidden" name="lang" id="lang" value="<?php echo $_GET["lang"];?>" />
								<table cellpadding="0" cellspacing="0">
									<tr><td><label for="genre"><?php echo $lang_apphome["JeSuis"];?></label></td><td><? echo $list['genre']; ?></td></tr>
									<tr><td><label for="date_naissance"><?php echo $lang_apphome["NeeLe"];?></label></td><td><? echo $list['naissance_jour'].$list['naissance_mois'].$list['naissance_annee']; ?></td></tr>
									<tr><td><label for="enfant"><?php echo $lang_apphome["Jai"];?></label></td><td><? echo $list['nb_enfants']; ?> <label for="enfant"><?php echo $lang_apphome["Enfant(s)"];?></label></td></tr>
									<tr><td><label for="canton"><?php echo $lang_apphome["JhabiteDansLeCantonDe"];?></label></td><td><? echo $list['canton_id']; ?></td></tr>
									<tr><td><label for="ville"><?php echo $lang_apphome["A(Ville)"];?></label></td><td id="villes"><? echo $list['ville_id']; ?></td></tr>
								</table>
									
								<input type="hidden" name="site_url" id="site_url" value="<? echo SITE_URL; ?>" />
								<input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_GET["lang"];?>" />
									
								<input type="submit" class="envoyer" value="<?php echo $lang_apphome["JeMinscris"];?>" />
							</form>
						</div>
						<script type="text/javascript">
							function loadVilles(prefix) {
								if(prefix==null){
									prefix='';
								} 
								
								new Request({
									url: $('site_url').value+'/app/app_home/ajax.php',
									method: 'get',
									headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
									data: {
										"canton_id": $(prefix+'canton_id').value, 
										"ville_id": $(prefix+'ville_id').value, 
										"lang": $(prefix+'lang').value, 
										"prefix": prefix
									},
									onSuccess: function(ajax_return) {
										$("villes").set('html', ajax_return);
									},
									onFailure: function(){
									}
								}).send();
							}
						</script>
						
						
						<!--Box explicatif du site-->
						<div class="blocs_parentsolo">
							<div class="bloc_parentsolo">
								<span class="bloc_parentsolo_text" >
									<h3><a href="<? echo JL::url('index.php?app=contenu&id=2').'&lang='.$_GET['lang']; ?>" title="<?php echo $colonne_1->titre;?>" ><? echo $colonne_1->titre; ?></a></h3>
									<p><? echo $colonne_1->texte; ?></p>
								</span>
								<a href="<? echo JL::url('index.php?app=contenu&id=2').'&lang='.$_GET['lang']; ?>" title="<?php echo $colonne_1->titre;?>" ><img  width="180px" src="<? echo SITE_URL; ?>/parentsolo/images/app_home/concept-<? echo $_GET['lang']; ?>.jpg" title="<?php echo $colonne_1->titre;?>"/></a>
							</div>
							<br />
							<div class="bloc_parentsolo">
								<span class="bloc_parentsolo_text" >
									<h3><a href="<? echo JL::url('index.php?app=temoignage').'&lang='.$_GET['lang']; ?>" title="<?php echo $colonne_2->titre;?>" ><? echo $colonne_2->titre; ?></a></h3>
									<p><? echo $colonne_2->texte; ?></p>
								</span>
								<a href="<? echo JL::url('index.php?app=temoignage').'&lang='.$_GET['lang']; ?>" title="<?php echo $colonne_2->titre;?>" ><img width="180px" src="<? echo SITE_URL; ?>/parentsolo/images/app_home/temoignages-<? echo $_GET['lang']; ?>.jpg" title="<?php echo $colonne_2->titre;?>" /></a>
							</div>
							<br />
							<div class="bloc_parentsolo">
								<span class="bloc_parentsolo_text" >
									<h3><a href="<? echo JL::url('index.php?app=presse').'&lang='.$_GET['lang']; ?>" title="Presse">PARENTSOLO.CH VU PAR LES M&Eacute;DIAS</a></h3>
									<p>
										Concept in&eacute;dit et novateur, le 1er site de rencontres r&eacute;serv&eacute;s aux parents c&eacute;libataires r&eacute;sidant en Suisse a  fait l'effet d'un v&eacute;ritable "BUZZ" m&eacute;diatique d&egrave;s sa cr&eacute;ation.<br/>
										<br />
										D'ailleurs les m&eacute;dia continuent d'&ecirc;tre attentif &agrave; <a href="<? echo JL::url('index.php?app=presse').'&lang='.$_GET['lang']; ?>" title="Presse">son &eacute;volution...</a>
									</p>
								</span>
								<a href="<? echo JL::url('index.php?app=presse').'&lang='.$_GET['lang']; ?>" title="Presse"><img width="180px" src="<? echo SITE_URL; ?>/parentsolo/images/app_home/presse-<? echo $_GET['lang']; ?>.jpg" title="<?php echo $colonne_3->titre;?>" /></a>
							</div>
							<br />
							<div class="bloc_parentsolo">
								<span class="bloc_parentsolo_text" >
									<h3><a href="<? echo JL::url('index.php?app=appel_a_temoins').'&lang='.$_GET['lang']; ?>" title="<?php echo $colonne_3->titre;?>" ><? echo $colonne_3->titre; ?></a></h3>
									<p><? echo $colonne_3->texte; ?></p>
								</span>
								<a href="<? echo JL::url('index.php?app=appel_a_temoins').'&lang='.$_GET['lang']; ?>" title="<?php echo $colonne_3->titre;?>" ><img width="180px" src="<? echo SITE_URL; ?>/parentsolo/images/app_home/appel_temoins-<? echo $_GET['lang']; ?>.jpg" title="<?php echo $colonne_3->titre;?>" /></a>
							</div>
						</div>
						
						<div class="partenaire_l">
							<h2><?php echo $lang_apphome["Partenaire"];?></h2>
							<br />
							<span class="partenaire_l_text" >
								<h3>
								<? 
									if($partenaire_l->id == 5){
								?>
										<a href="http://www.onefm.ch/home/index.php" target="_blank" title="<?php echo $partenaire_l->titre;?>" >
								<?
									}elseif($partenaire_l->id == 6){
								?>
										<a href="http://www.lfm.ch/portail/index.php" target="_blank" title="<?php echo $partenaire_l->titre;?>" >
								<?
									}
								?>
									<? echo $partenaire_l->titre; ?>
									</a>
								</h3>
								<p><? echo $partenaire_l->texte; ?></p>
							</span>
						<? 
							if($partenaire_l->id == 5){
						?>
								<a href="http://www.onefm.ch/home/index.php" target="_blank" title="<?php echo $partenaire_l->titre;?>" ><img width="180px" src="<? echo SITE_URL; ?>/parentsolo/images/app_home/onefm-<? echo $_GET['lang']; ?>.jpg" title="<?php echo $partenaire_l->titre;?>" /></a>
						<?
							}elseif($partenaire_l->id == 6){
						?>
								<a href="http://www.lfm.ch/portail/index.php" target="_blank" title="<?php echo $partenaire_l->titre;?>" ><img width="180px" src="<? echo SITE_URL; ?>/parentsolo/images/app_home/lfm-<? echo $_GET['lang']; ?>.jpg" title="<?php echo $partenaire_l->titre;?>" /></a>
						<?
							}
						?>
						</div>
						
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<div class="colr"> 
					<!--Connexion au profil-->
					<div class="connexion">
						<?
							$style = !$user->id && $auth == 'login' ? 'style="background: red;"' : '';
						?>
						<h3><?php echo $lang_apphome["DejaMembre"];?></h3>
						<br />
						<form action="<? echo JL::url('index.php?app=home').'&lang='.$_GET['lang'];?>" method="post">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td><label for="pseudo"><?php echo $lang_apphome["Pseudo"];?> </label></td>
									<td><input type="text" name="pseudo" id="pseudo" <? echo $style; ?> value=""></td>
								</tr>
								<tr>
									<td><label for="mdp"><?php echo $lang_apphome["MotDePasse"];?> </label></td>
									<td><input type="text" name="mdp" id="mdp" <? echo $style; ?> value=""></td>
								</tr>
							</table>
							
							<br />
							
							<input type="submit" class="envoyer" value="<?php echo $lang_apphome["Connexion"];?>" /><a href="<? echo JL::url('index.php?app=mdp_oublie').'&lang='.$_GET['lang'];?>"><?php echo $lang_apphome["MotDePasseOublie"];?></a><br />
							
							<input type="hidden" name="site_url" id="site_url" value="<? echo SITE_URL; ?>" />
							<input type="hidden" name="lang" id="lang" value="<?php echo $_GET["lang"];?>" />
							
						</form>
					</div>
				
					<div id="banner_gold">
						<div class="small"><?php echo $lang_apphome["Publicite"];?></div>
					<?
						/*if($_GET['lang']=="fr"){
					?>
						
							<!-- Start of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-SKY-R SIZE : 160x600 -->
							<script type="text/javascript">
								if(typeof(WLRCMD)=="undefined"){var WLRCMD="";}
								if(typeof(adlink_randomnumber)=="undefined"){var adlink_randomnumber=Math.floor(Math.random()*10000000000)}
								document.write('<scr'+'ipt language="JavaScript" src="http://ad.ch.doubleclick.net/adj/parentsolo.ex.ch/FR_Home_SKY_R_160x600;'+WLRCMD+';sex=,age=,kant=,plz=,kw=;sz=160x600;Tile=2;ord='+adlink_randomnumber+'?"><\/scr'+'ipt>');
							</script>
							<noscript>
								<a href="http://ad.ch.doubleclick.net/jump/parentsolo.ex.ch/FR_Home_SKY_R_160x600;sex=,age=,kant=,plz=,kw=;sz=160x600;Tile=2;ord=1234567890?" target="_blank">
									<img src="http://ad.ch.doubleclick.net/ad/parentsolo.ex.ch/FR_Home_SKY_R_160x600;sex=,age=,kant=,plz=,kw=;sz=160x600;Tile=2;ord=1234567890?" border="0" width="160" height="600">
								</a>
							</noscript>
							<!-- End of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-SKY-R SIZE : 160x600  -->
					<?
						}elseif($_GET['lang']=="en"){
					?>
							<!-- Start of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-SKY-R SIZE : 160x600 -->
							<script type="text/javascript">
								if(typeof(WLRCMD)=="undefined"){var WLRCMD="";}
								if(typeof(adlink_randomnumber)=="undefined"){var adlink_randomnumber=Math.floor(Math.random()*10000000000)}
								document.write('<scr'+'ipt language="JavaScript" src="http://ad.ch.doubleclick.net/adj/parentsolo.ex.ch/FR_Home_SKY_R_160x600;'+WLRCMD+';sex=,age=,kant=,plz=,kw=;sz=160x600;Tile=2;ord='+adlink_randomnumber+'?"><\/scr'+'ipt>');
							</script>
							<noscript>
								<a href="http://ad.ch.doubleclick.net/jump/parentsolo.ex.ch/FR_Home_SKY_R_160x600;sex=,age=,kant=,plz=,kw=;sz=160x600;Tile=2;ord=1234567890?" target="_blank">
									<img src="http://ad.ch.doubleclick.net/ad/parentsolo.ex.ch/FR_Home_SKY_R_160x600;sex=,age=,kant=,plz=,kw=;sz=160x600;Tile=2;ord=1234567890?" border="0" width="160" height="600">
								</a>
							</noscript>
							<!-- End of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-SKY-R SIZE : 160x600  -->
					<?
						}else{
					?>
							<!-- Start of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-DE-HOME-SKY-R SIZE : 160x600 -->
							<script type="text/javascript">
								if(typeof(WLRCMD)=="undefined"){var WLRCMD="";}
								if(typeof(adlink_randomnumber)=="undefined"){var adlink_randomnumber=Math.floor(Math.random()*10000000000)}
								document.write('<scr'+'ipt language="JavaScript" src="http://ad.ch.doubleclick.net/adj/parentsolo.ex.ch/DE_Home_SKY_R_160x600;'+WLRCMD+';sex=,age=,kant=,plz=,kw=;sz=160x600;Tile=2;ord='+adlink_randomnumber+'?"><\/scr'+'ipt>');
							</script>
							<noscript>
								<a href="http://ad.ch.doubleclick.net/jump/parentsolo.ex.ch/DE_Home_SKY_R_160x600;sex=,age=,kant=,plz=,kw=;sz=160x600;Tile=2;ord=1234567890?" target="_blank">
									<img src="http://ad.ch.doubleclick.net/ad/parentsolo.ex.ch/DE_Home_SKY_R_160x600;sex=,age=,kant=,plz=,kw=;sz=160x600;Tile=2;ord=1234567890?" border="0" width="160" height="600">
								</a>
							</noscript>
							<!-- End of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-DE-HOME-SKY-R SIZE : 160x600  -->
					<?
						}  */
					?>
					</div>
					<!--actualit&eacute;s-->
					<div class="actu_offline">
						<h3><?php echo $lang_apphome["Actualites"];?></h3>
						<br />
					<?
						if(count($actualites)) {
							$i = 1;
							?>
							<ul>
							<?
							foreach($actualites as $actualite) {
								JL::makeSafe($actualite);
								?>
									<li><a href="<? echo JL::url('index.php?app=contenu&action=actu&id='.$actualite->id).'&lang='.$_GET['lang']; ?>" title="<? echo $actualite->titre; ?>"><? echo $actualite->titre; ?></a>
								<?
								$i++;
							}
							?>
							</ul>
					<?
						}
					?>
					</div>
					<div class="partenaire_r">
						<div class="small"><?php echo $lang_apphome["Partenaire"];?></div>
						<a href="http://www.babybook.ch"><img src="<? echo SITE_URL; ?>/parentsolo/images/partenaire_babybook.jpg" alt="Babybook"/></a>
						<h3><a href="http://www.babybook.ch"><? echo $partenaire_r->titre; ?></a></h3>
						<p><? echo $partenaire_r->texte; ?></p>
					</div>
					
					<div id="banner_medium_rectangle">
						<div class="small"><?php echo $lang_apphome["Publicite"];?></div>
					<?
						/*if($_GET['lang']=="fr"){
					?>
						
							<!-- Start of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-REC-C SIZE : 300x250 -->
							<script type="text/javascript">
								if(typeof(WLRCMD)=="undefined"){var WLRCMD="";}
								if(typeof(adlink_randomnumber)=="undefined"){var adlink_randomnumber=Math.floor(Math.random()*10000000000)}
							   document.write('<scr'+'ipt language="JavaScript" src="http://ad.ch.doubleclick.net/adj/parentsolo.ex.ch/FR_Home_REC_C_300x250;'+WLRCMD+';sex=,age=,kant=,plz=,kw=;sz=300x250;Tile=3;ord='+adlink_randomnumber+'?"><\/scr'+'ipt>');
							</script>
							<noscript>
								<a href="http://ad.ch.doubleclick.net/jump/parentsolo.ex.ch/FR_Home_REC_C_300x250;sex=,age=,kant=,plz=,kw=;sz=300x250;Tile=3;ord=1234567890?" target="_blank">
									<img src="http://ad.ch.doubleclick.net/ad/parentsolo.ex.ch/FR_Home_REC_C_300x250;sex=,age=,kant=,plz=,kw=;sz=300x250;Tile=3;ord=1234567890?" border="0" width="300" height="250">
								</a>
							</noscript>
							<!-- End of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-REC-C SIZE : 300x250  -->
					<?
						}elseif($_GET['lang']=="en"){
					?>
							<!-- Start of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-REC-C SIZE : 300x250 -->
							<script type="text/javascript">
								if(typeof(WLRCMD)=="undefined"){var WLRCMD="";}
								if(typeof(adlink_randomnumber)=="undefined"){var adlink_randomnumber=Math.floor(Math.random()*10000000000)}
							   document.write('<scr'+'ipt language="JavaScript" src="http://ad.ch.doubleclick.net/adj/parentsolo.ex.ch/FR_Home_REC_C_300x250;'+WLRCMD+';sex=,age=,kant=,plz=,kw=;sz=300x250;Tile=3;ord='+adlink_randomnumber+'?"><\/scr'+'ipt>');
							</script>
							<noscript>
								<a href="http://ad.ch.doubleclick.net/jump/parentsolo.ex.ch/FR_Home_REC_C_300x250;sex=,age=,kant=,plz=,kw=;sz=300x250;Tile=3;ord=1234567890?" target="_blank">
									<img src="http://ad.ch.doubleclick.net/ad/parentsolo.ex.ch/FR_Home_REC_C_300x250;sex=,age=,kant=,plz=,kw=;sz=300x250;Tile=3;ord=1234567890?" border="0" width="300" height="250">
								</a>
							</noscript>
							<!-- End of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-REC-C SIZE : 300x250  -->
					<?
						}else{
					?>
							<!-- Start of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-DE-HOME-REC-C SIZE : 300x250 -->
							<script type="text/javascript">
								if(typeof(WLRCMD)=="undefined"){var WLRCMD="";}
								if(typeof(adlink_randomnumber)=="undefined"){var adlink_randomnumber=Math.floor(Math.random()*10000000000)}
							   document.write('<scr'+'ipt language="JavaScript" src="http://ad.ch.doubleclick.net/adj/parentsolo.ex.ch/DE_Home_REC_C_300x250;'+WLRCMD+';sex=,age=,kant=,plz=,kw=;sz=300x250;Tile=3;ord='+adlink_randomnumber+'?"><\/scr'+'ipt>');
							</script>
							<noscript>
								<a href="http://ad.ch.doubleclick.net/jump/parentsolo.ex.ch/DE_Home_REC_C_300x250;sex=,age=,kant=,plz=,kw=;sz=300x250;Tile=3;ord=1234567890?" target="_blank">
									<img src="http://ad.ch.doubleclick.net/ad/parentsolo.ex.ch/DE_Home_REC_C_300x250;sex=,age=,kant=,plz=,kw=;sz=300x250;Tile=3;ord=1234567890?" border="0" width="300" height="250">
								</a>
							</noscript>
							<!-- End of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-DE-HOME-REC-C SIZE : 300x250  -->
					<?
						}  */
					?>
					</div>
				</div>
				<div style="clear:both"> </div>
			</div>
    
		<?
		
		}
		
	}
?>

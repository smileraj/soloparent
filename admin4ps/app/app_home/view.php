<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class homeView extends JLModel {
	
		function __construct() {}
		
		// vérifie si l'utilisateur veut se log ou est log, et renseigne la variable global $user
		function display($auth='', &$profils = null, &$actualites = null,&$colonne_1 = null, &$colonne_2 = null, &$colonne_3 = null, &$colonne_4 = null, &$partenaire_r = null, &$list = null) {
			include("lang/app_home.".$_GET['lang'].".php");
			global $db, $template;
						
			if ($_GET["lang"]!="fr") {
				$jsUpExt = "-".$_GET["lang"];
			} else {
				$jsUpExt = "";
			}
		?>
			
			<script type="text/javascript">

				// Dossier où se situent les images
				var dossier="<?php echo SITE_URL; ?>/images/vitrines";

				// Le tableau qui va contenir les images.
				var tab_images=new Array();
				
			<?php 				$i = 0;
				foreach($profils as $profil){
					if(is_file('images/profil/'.$profil->id.'/parent-solo-109-profil-'.$profil->photo_defaut.'.jpg')){
			?>
						tab_images[<?php echo $i ;?>]=["<?php echo SITE_URL; ?>/images/profil/<?php echo $profil->id;?>/parent-solo-109-profil-<?php echo $profil->photo_defaut;?>.jpg"];
			<?php 						$i++;
					}
				}
			?>	

				// Le délai de passage d'une image à l'autre en millisecondes -> 1s=1000
				var delai=2000;

				// Variable de compteur qui indiquera à quelle image on se trouve
				var compteur=0;
				
				
				
				var mode = 'horizontal';
				var modes = {horizontal : ['left','width'], vertical:['top','height']};
				var size = 113;
				var box;
				var fx;
				var k = 1;
				
				// La fonction qui va permettre le défilement
				function Diaporama(){
					
					//mode = 'vertical';
					//modes = {horizontal : ['left','width'], vertical:['top','height']};
					//size = 390;
					box = document.getElementById("box6").setStyle(modes[mode][1],(size*<?php echo $i;?>)+'px');
					fx = new Fx.Tween(box,$extend(({duration:1000,wait:false}), {property:modes[mode][0]}));
					// partie où on applique les filtres propres à IE
					fx.start(size*-compteur);
					
					// On incrémente le compteur de 1 pour passer à l'image suivante
					compteur++;
					// Si on a atteint la dernière image, on remet à zéro le compteur et on rappelle la fonction Diaporama()
					if(compteur==tab_images.length-8){
						k=2;
						t = setTimeout("Diaporama_Inverse()",delai);
					}else if(compteur<tab_images.length-8){
						t = setTimeout("Diaporama()",delai);
					}
				}
				
				function Diaporama_Inverse(){
					
					//mode = 'vertical';
					//modes = {horizontal : ['left','width'], vertical:['top','height']};
					//size = 390;
					box = document.getElementById("box6").setStyle(modes[mode][1],(size*<?php echo $i;?>)+'px');
					fx = new Fx.Tween(box,$extend(({duration:1000,wait:false}), {property:modes[mode][0]}));
					// partie où on applique les filtres propres à IE
					fx.start(size*-compteur);
					
					// On incrémente le compteur de 1 pour passer à l'image suivante
					compteur--;
					// Si on a atteint la dernière image, on remet à zéro le compteur et on rappelle la fonction Diaporama()
					if (compteur==0){
						k=1;
						t = setTimeout("Diaporama()",delai);
					}else
						t = setTimeout("Diaporama_Inverse()",delai);
				}
				
				function stop() {
					 clearTimeout(t);
					 
					 if(k==1){
						t = setTimeout("Diaporama()",4000);
					}else{
						t = setTimeout("Diaporama_Inverse()",4000);
					}
					 
				}
				
				function restart(){
					
				}
				
				// On charge au démarrage de la page la fonction de défilement des images
				window.onload= function(){ 
					Diaporama();			
				};
			</SCRIPT>
	
			<!--Photo défilante des membres-->
			<div class="hometop" OnMouseOver="stop()" >
			<div class="mask6">
				<div id="box6">
				<?php 					foreach($profils as $profil){
						JL::makeSafe($profil);
						if(is_file('images/profil/'.$profil->id.'/parent-solo-109-profil-'.$profil->photo_defaut.'.jpg')){
						?>
							<span><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$profil->id.'&lang='.$_GET['lang']);?>"><img src="<?php echo SITE_URL; ?>/images/profil/<?php echo $profil->id;?>/parent-solo-109-profil-<?php echo $profil->photo_defaut;?>.jpg" alt="<?php echo $profil->username?>"/></a></span>
						<?php 						}
					}
				?>
				</div>
             </div>
            </div>
			<div class="content">
				<div class="contentl">
					<div class="colc">
						<h1><?php echo $lang_apphome["SiteDeRencontrePour..."];?></h1>
						<br />
						
							<div class="pastille_conseil_amis"><img src="<?php echo SITE_URL; ?>/parentsolo/images/app_home/pastille_conseil_amis-<?php echo $_GET['lang']; ?>.png" /></div>
							<!--Création du profil-->
							<div class="inscription">
								
								<h2><?php echo $lang_apphome["InscriptionGratuite"];?></h2>
								<br />
								<form action="<?php echo JL::url('index.php?app=inscription').'&lang='.$_GET['lang'];?>" name="inscriptionMini" method="post">
									<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
									<input type="hidden" name="lang" id="lang" value="<?php echo $_GET["lang"];?>" />
									<table cellpadding="0" cellspacing="0">
										<tr><td><label for="genre"><?php echo $lang_apphome["JeSuis"];?></label></td><td><?php echo $list['genre']; ?></td></tr>
										<tr><td><label for="date_naissance"><?php echo $lang_apphome["NeeLe"];?></label></td><td><?php echo $list['naissance_jour'].$list['naissance_mois'].$list['naissance_annee']; ?></td></tr>
										<tr><td><label for="enfant"><?php echo $lang_apphome["Jai"];?></label></td><td><?php echo $list['nb_enfants']; ?> <label for="enfant"><?php echo $lang_apphome["Enfant(s)"];?></label></td></tr>
										<tr><td><label for="canton"><?php echo $lang_apphome["JhabiteDansLeCantonDe"];?></label></td><td><?php echo $list['canton_id']; ?></td></tr>
										<tr><td><label for="ville"><?php echo $lang_apphome["A(Ville)"];?></label></td><td id="villes"><?php echo $list['ville_id']; ?></td></tr>
									</table>
									
									<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
									<input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_GET["lang"];?>" />
									
									<input type="submit" class="envoyer" value="<?php echo $lang_apphome["JeMinscris"];?>" />
								</form>
							</div>
							<script type="text/javascript">
								function loadVilles(prefix) {
									if(prefix==null){
										prefix='';
									} 
									console.log(canton_id);
									new Request({
										url: $('site_url').value+'/app/app_home/ajax.php',
										method: 'get',
										headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
										data: {
											"canton_id": $( prefix +'canton_id').val(), 
											"ville_id": $( prefix +'ville_id').val(), 
											"lang": $( prefix +'lang').val(), 
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
						<div class="blocs4">
							<div class="bloc">
								<span class="bloc-text" >
									<h2><?php echo $colonne_1->titre; ?></h2>
									<?php echo $colonne_1->texte; ?>
								</span>
								<a href="<?php echo JL::url('index.php?app=redac&action=item&id=2').'&'.$langue; ?>" title="<?php echo $colonne_1->titre;?>" ><img  width="180px" src="<?php echo SITE_URL; ?>/parentsolo/images/app_home/concept-<?php echo $_GET['lang']; ?>.jpg" title="<?php echo $colonne_1->titre;?>"/></a>
							</div>
							<br />
							<div class="bloc">
								<span class="bloc-text" >
									<h2><?php echo $colonne_2->titre; ?></h2>
									<?php echo $colonne_2->texte; ?>
								</span>
								<a href="<?php echo JL::url('index.php?app=temoignage&action=list').'&'.$langue; ?>" title="<?php echo $colonne_2->titre;?>" ><img width="180px" src="<?php echo SITE_URL; ?>/parentsolo/images/app_home/temoignages-<?php echo $_GET['lang']; ?>.jpg" title="<?php echo $colonne_2->titre;?>" /></a>
							</div>
							<br />
							<div class="bloc">
								<span class="bloc-text" >
									<h2><?php echo $colonne_3->titre; ?></h2>
									<?php echo $colonne_3->texte; ?>
								</span>
								<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list').'&'.$langue; ?>" title="<?php echo $colonne_3->titre;?>" ><img width="180px" src="<?php echo SITE_URL; ?>/parentsolo/images/app_home/appel_temoins-<?php echo $_GET['lang']; ?>.jpg" title="<?php echo $colonne_3->titre;?>" /></a>
							</div>
						</div>
					</div>
				</div>
				<div class="colr"> 
					<!--Connexion au profil-->
					<div class="connexion">
						<?php 							$style = !$user->id && $auth == 'login' ? 'style="background: red;"' : '';
						?>
						<h2><?php echo $lang_apphome["DejaMembre"];?></h2>
						<br />
						<form action="<?php echo JL::url('index.php?app=home').'&lang='.$_GET['lang'];?>" method="post">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td><label for="pseudo"><?php echo $lang_apphome["Pseudo"];?> </label></td>
									<td><input type="text" name="pseudo" id="pseudo" <?php echo $style; ?> value=""></td>
								</tr>
								<tr>
									<td><label for="mdp"><?php echo $lang_apphome["MotDePasse"];?> </label></td>
									<td><input type="text" name="mdp" id="mdp" <?php echo $style; ?> value=""></td>
								</tr>
							</table>
							
							<br />
							
							<a href="<?php echo JL::url('index.php?app=mdp_oublie').'&lang='.$_GET['lang'];?>"><?php echo $lang_apphome["MotDePasseOublie"];?></a><br />
							
							<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
							<input type="hidden" name="lang" id="lang" value="<?php echo $_GET["lang"];?>" />
							<input type="submit" class="envoyer" value="<?php echo $lang_apphome["Connexion"];?>" />
						</form>
					</div>
				
					<div id="banner_gold">
						<div class="small"><?php echo $lang_apphome["Publicite"];?></div>
						<?php 						if($_GET['lang']=="fr"){
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
						<?php 						}elseif($_GET['lang']=="en"){
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
						<?php 						}else{
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
						<?php 						}
						?>
					</div>
					<!--actualités-->
					<div class="actu_home">
						<h2><?php echo $lang_apphome["Actualites"];?></h2>
						<br />
					<?php 						if (is_array($actualites)) {
							$i = 1;
							?>
							<ul>
							<?php 							foreach($actualites as $actualite) {
								JL::makeSafe($actualite);
								?>
									<li class="li<?php echo $i; ?>"><a href="<?php echo JL::url('index.php?app=redac&action=item&id='.$actualite->id.'&'.$langue); ?>" title="<?php echo $actualite->titre; ?>">&raquo; <?php echo $actualite->titre; ?></a>
								<?php 								$i++;
							}
							?>
							</ul>
					<?php 						}
					?>
					</div>
					<div class="partenaire_r">
						<div class="small"><?php echo $lang_apphome["Partenaire"];?></div>
						<a href="http://www.babybook.ch"><img src="<?php echo SITE_URL; ?>/parentsolo/images/partenaire_babybook.jpg" alt="Babybook"/></a>
						<h2><?php echo $partenaire_r->titre; ?></h2>
						<?php echo $partenaire_r->texte; ?>
					</div>
				</div>
			</div>
    
		<?php 		
		}
		
	}
?>

<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class temoignageView extends JLView {
	
		function __construct() {}
		
		
		function infos(&$contenu) {
			global $db, $template;
			
		?>
			
			<!-- Partie Droite -->
			<div class="content">
				<div class="contentl">
					<div class="colc">
						
						<h1><?php echo $contenu->titre;?></h1>
						<br />
						<p>
							<?php echo  $contenu->texte; ?>
						</p>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<div class="colr"> 
				<?php 					JL::loadApp('menu_temoignage_offline');
				?>
				</div>
				<div style="clear:both"> </div>
			</div>
    
		<?php 		
		}
		
		function listall(&$temoignages, &$pagination) {
			include("lang/app_temoignage.".$_GET['lang'].".php");
			global $db, $template;
			
			$nb_temoignages		= count($temoignages);
		?>
			
			<!-- Partie Droite -->
			<div class="content">
				<div class="contentl">
					<div class="colc">
						
						<h1><?php echo $lang_apptemoignage["TousLesTemoignages"];?></h1>
						<br />
						<p>
						<?php 							$i = 1;
							
							if(is_array($temoignages) && $nb_temoignages){
								
								for($j=0; $j<4; $j++) {
									$temoignage = $temoignages[$j];
									
									// limitation de la longueur du titre
									if(strlen((string) $temoignage->titre) > LISTE_TITRE_CHAR) {
										$temoignage->titre = substr((string) $temoignage->titre, 0, LISTE_TITRE_CHAR).'...';
									}
									
									// limitation de la longueur de l'intro
									$temoignage->texte = strip_tags(html_entity_decode((string) $temoignage->texte));
									if(strlen($temoignage->texte) > LISTE_INTRO_CHAR) {
										$temoignage->texte = substr($temoignage->texte, 0, LISTE_INTRO_CHAR).'...';
									}
									
									// &agrave; placer toujours apr&egrave;s les 2 limitations
									JL::makeSafe($temoignage, 'texte');
									
									// r&eacute;cup la photo de l'utilisateur
									$photo = JL::userGetPhoto($temoignage->user_id, '109', 'profil', $temoignage->photo_defaut);

									// photo par d&eacute;faut
									if(!$photo) {
										$photo = SITE_URL.'/parentsolo/images/parent-solo-109-'.$temoignage->genre.'-'.$_GET['lang'].'.jpg';
									}
									
									if($temoignage->id){
						?>
									
										<div class="temoignages temoignage_<?php if($i%2==1){ echo 'left'; }else{ echo 'right'; } ?>">
												<h3><a href="<?php echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"];?>"><span><?php echo $temoignage->username; ?>:</span> <?php echo $temoignage->titre; ?></a></h3>
												<br />
												<a href="<?php echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"]; ?>"><img src="<?php echo $photo; ?>" alt="<?php echo $temoignage->username; ?>" /></a> <?php echo $temoignage->texte; ?>
												<br />
												<a href="<?php echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"]; ?>" class="lire"><?php echo $lang_apptemoignage["LireLeTemoignage"];?></a>
										</div>
						<?php 									}
									 if($i%2==0){
						?>
									<div class="clear"></div>
						<?php	 
									}
									$i++;
								}
							
						?>
							<div class="small"><?php echo $lang_apptemoignage["Publicite"]; ?></div>
							<div class="silver_banner">
								<img src="<?php echo SITE_URL; ?>/parentsolo/images/pub/silver_banner.jpg" alt="silver_banner" />
							</div>
						<?php 							if($nb_temoignages > 4){
								
								for($j=4; $j<$nb_temoignages; $j++) {
									$temoignage = $temoignages[$j];
									
									// limitation de la longueur du titre
									if(strlen((string) $temoignage->titre) > LISTE_TITRE_CHAR) {
										$temoignage->titre = substr((string) $temoignage->titre, 0, LISTE_TITRE_CHAR).'...';
									}
									
									// limitation de la longueur de l'intro
									$temoignage->texte = strip_tags(html_entity_decode((string) $temoignage->texte));
									if(strlen($temoignage->texte) > LISTE_INTRO_CHAR) {
										$temoignage->texte = substr($temoignage->texte, 0, LISTE_INTRO_CHAR).'...';
									}
									
									// &agrave; placer toujours apr&egrave;s les 2 limitations
									JL::makeSafe($temoignage, 'texte');
									
									// r&eacute;cup la photo de l'utilisateur
									$photo = JL::userGetPhoto($temoignage->user_id, '109', 'profil', $temoignage->photo_defaut);

									// photo par d&eacute;faut
									if(!$photo) {
										$photo = SITE_URL.'/parentsolo/images/parent-solo-109-'.$temoignage->genre.'-'.$_GET['lang'].'.jpg';
									}
									
									if($temoignage->id){
						?>
										<div class="temoignages temoignage_<?php if($i%2==1){ echo 'left'; }else{ echo 'right'; } ?>">
												<h3><a href="<?php echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"];?>"><span><?php echo $temoignage->username; ?>:</span> <?php echo $temoignage->titre; ?></a></h3>
												<br />
												<a href="<?php echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"]; ?>"><img src="<?php echo $photo; ?>" alt="<?php echo $temoignage->username; ?>" /></a> <?php echo $temoignage->texte; ?>
												<br />
												<a href="<?php echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"]; ?>" class="lire"><?php echo $lang_apptemoignage["LireLeTemoignage"];?></a>
										</div>
						<?php 									}
									 if($i%2==0){
						?>
									<div class="clear"></div>
						<?php	 
									}
									$i++;
								}
							}
						?>
							
						<?php 							// pagination &agrave; affiche
							if($pagination->pageTotal > 1) { ?>
							<div class="pagination">
								<span><?php echo $lang_apptemoignage["Pages"]; ?></span> 
								
								<?php 								$previous = 0;
								foreach($pagination->pageList as $page) {
								
									// d&eacute;termine si on affiche la page active
									$pageActive = $page->value == $pagination->page ? true : false;
									
									if($previous != $page->value - 1) {
										echo '... ';
									}
									?>
										<a href="<?php echo JL::url('index.php?app=temoignage'.($page->value > 1 ? '&page='.$page->value : '').'&lang='.$_GET['lang']); ?>" title="<?php echo $categorie->nom; if($page->value > 1) { ?> - <?php echo $lang_apptemoignage["Page"].' '.$page->value; } ?>" <?php if($pageActive) { ?>class="pageActive"<?php } ?>><?php echo $page->value; ?></a> 
									<?php 									$previous = $page->value;
								}
							?>
							</div>
							<?php 							}
						
						} else {
						?>
								<?php echo $lang_apptemoignage["AucunTemoignage"]; ?>
						<?php 						}
						?>
						</p>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<div class="colr"> 
				<?php 					JL::loadApp('menu_temoignage_offline');
				?>
				</div>
				<div style="clear:both"> </div>
			</div>
    
		<?php 		
		}
		
		function lire(&$temoignage) {
			include("lang/app_temoignage.".$_GET['lang'].".php");
			global $db;
			
			JL::makeSafe($temoignage, 'texte');
		?>
			
			<!-- Partie Droite -->
			<div class="content">
				<div class="contentl">
					<div class="colc">
						
						<h1><?php echo $temoignage->titre;?></h1>
						<br />
						<p>
						<?php 							// r&eacute;cup la photo de l'utilisateur
							$photo = JL::userGetPhoto($temoignage->user_id, '220', 'profil', $temoignage->photo_defaut);

							// photo par d&eacute;faut
							if(!$photo) {
								$photo = SITE_URL.'/parentsolo/images/parent-solo-220-'.$temoignage->genre.'-'.$_GET['lang'].'.jpg';
							}
						?>
							<div class="temoignage">
									<img width="200" src="<?php echo $photo; ?>" alt="<?php echo $temoignage->username; ?>" /> <?php echo $temoignage->texte; ?>
									<div class="clear"></div>
									<div class="publication">
										<?php echo $lang_apptemoignage["TemoignagePublieLePar"]; ?>
									</div>
							</div>
						</p>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<div class="colr"> 
				<?php 					JL::loadApp('menu_temoignage_offline');
				?>
				</div>
				<div style="clear:both"> </div>
			</div>
    
		<?php 		
		}
		
		
		function edit(&$contenu, $temoignage, $messages) {
			include("lang/app_temoignage.".$_GET['lang'].".php");
			global $db, $user, $action;
			
			JL::makeSafe($contenu, 'texte');
		?>
			
			<!-- Partie Droite -->
			<div class="content">
				<div class="contentl">
					<div class="colc">
						
						<h1><?php echo $contenu->titre; ?></h1>
						<br />
						<p>
							<?php echo $contenu->texte; ?>
						</p>
						<?php 							if (is_array($messages)){
								// affichage des messages
								$this->messages($messages, false);
							}
						?>
						<p>
							<div class="formulaire">
								<form name="temoignageform" action="<?php echo JL::url('index.php?app=temoignage&action=edit').'&lang='.$_GET['lang']; ?>" method="post">
									<div class="formu" style="height:300px;">
										<h2><?php echo $lang_apptemoignage["VotreTemoignage"]; ?></h2>
										<div class="pad">
											<table cellpadding="0px" cellspacing="0px">
												<tr><td class="key"><label for="nom"><?php echo $lang_apptemoignage["Titre"]; ?></label> *</td><td><input type="text" name="titre" id="titre" maxlength="20" value="<?php echo $row->titre; ?>" /></td></tr>
												<tr><td class="key"><label for="prenom"><?php echo $lang_apptemoignage["Texte"]; ?></label> *</td><td><textarea name="texte" id="texte" style="width:325px;height:235px;"><?php echo $row->texte; ?></textarea></td></tr>
											</table>
										</div>
									</div>
									
									<p class="small"  style="font-style:italic">
										* <?php echo $lang_apptemoignage["LesChampsMarques"]; ?>
									</p>
									
									
									<input type="hidden" name="action" value="envoyer" />
									<input type="submit" value="<?php echo $lang_apptemoignage["Envoyer"]; ?>" class="envoyerForm" />
								</form>
							</div>
						</p>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<div class="colr"> 
				<?php 					JL::loadApp('menu_temoignage_offline');
				?>
				</div>
				<div style="clear:both"> </div>
			</div>
    
		<?php 		
		}
		
	}
?>

<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class temoignageView extends JLView {
	
		function temoignageView() {}
		
		
		function infos(&$contenu) {
			global $db, $template;
			
		?>
			
			<!-- Partie Droite -->
			<div class="content">
				<div class="contentl">
					<div class="colc">
						
						<h1><? echo $contenu->titre;?></h1>
						<br />
						<p>
							<? echo  $contenu->texte; ?>
						</p>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<div class="colr"> 
				<?
					JL::loadApp('menu_temoignage_offline');
				?>
				</div>
				<div style="clear:both"> </div>
			</div>
    
		<?
		
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
						<?
							$i = 1;
							
							if(is_array($temoignages) && $nb_temoignages){
								
								for($j=0; $j<4; $j++) {
									$temoignage = $temoignages[$j];
									
									// limitation de la longueur du titre
									if(strlen($temoignage->titre) > LISTE_TITRE_CHAR) {
										$temoignage->titre = substr($temoignage->titre, 0, LISTE_TITRE_CHAR).'...';
									}
									
									// limitation de la longueur de l'intro
									$temoignage->texte = strip_tags(html_entity_decode($temoignage->texte));
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
									
										<div class="temoignages temoignage_<? if($i%2==1){ echo 'left'; }else{ echo 'right'; } ?>">
												<h3><a href="<? echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<? echo $lang_apptemoignage["LireLeTemoignage"];?>"><span><? echo $temoignage->username; ?>:</span> <? echo $temoignage->titre; ?></a></h3>
												<br />
												<a href="<? echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<? echo $lang_apptemoignage["LireLeTemoignage"]; ?>"><img src="<? echo $photo; ?>" alt="<? echo $temoignage->username; ?>" /></a> <? echo $temoignage->texte; ?>
												<br />
												<a href="<? echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<? echo $lang_apptemoignage["LireLeTemoignage"]; ?>" class="lire"><? echo $lang_apptemoignage["LireLeTemoignage"];?></a>
										</div>
						<?
									}
									 if($i%2==0){
						?>
									<div class="clear"></div>
						<?				 
									}
									$i++;
								}
							
						?>
							<div class="small"><? echo $lang_apptemoignage["Publicite"]; ?></div>
							<div class="silver_banner">
								<img src="<? echo SITE_URL; ?>/parentsolo/images/pub/silver_banner.jpg" alt="silver_banner" />
							</div>
						<?
							if($nb_temoignages > 4){
								
								for($j=4; $j<$nb_temoignages; $j++) {
									$temoignage = $temoignages[$j];
									
									// limitation de la longueur du titre
									if(strlen($temoignage->titre) > LISTE_TITRE_CHAR) {
										$temoignage->titre = substr($temoignage->titre, 0, LISTE_TITRE_CHAR).'...';
									}
									
									// limitation de la longueur de l'intro
									$temoignage->texte = strip_tags(html_entity_decode($temoignage->texte));
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
										<div class="temoignages temoignage_<? if($i%2==1){ echo 'left'; }else{ echo 'right'; } ?>">
												<h3><a href="<? echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<? echo $lang_apptemoignage["LireLeTemoignage"];?>"><span><? echo $temoignage->username; ?>:</span> <? echo $temoignage->titre; ?></a></h3>
												<br />
												<a href="<? echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<? echo $lang_apptemoignage["LireLeTemoignage"]; ?>"><img src="<? echo $photo; ?>" alt="<? echo $temoignage->username; ?>" /></a> <? echo $temoignage->texte; ?>
												<br />
												<a href="<? echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<? echo $lang_apptemoignage["LireLeTemoignage"]; ?>" class="lire"><? echo $lang_apptemoignage["LireLeTemoignage"];?></a>
										</div>
						<?
									}
									 if($i%2==0){
						?>
									<div class="clear"></div>
						<?				 
									}
									$i++;
								}
							}
						?>
							
						<?
							// pagination &agrave; affiche
							if($pagination->pageTotal > 1) { ?>
							<div class="pagination">
								<span><? echo $lang_apptemoignage["Pages"]; ?></span> 
								
								<?
								$previous = 0;
								foreach($pagination->pageList as $page) {
								
									// d&eacute;termine si on affiche la page active
									$pageActive = $page->value == $pagination->page ? true : false;
									
									if($previous != $page->value - 1) {
										echo '... ';
									}
									?>
										<a href="<? echo JL::url('index.php?app=temoignage'.($page->value > 1 ? '&page='.$page->value : '').'&lang='.$_GET['lang']); ?>" title="<? echo $categorie->nom; if($page->value > 1) { ?> - <? echo $lang_apptemoignage["Page"].' '.$page->value; } ?>" <? if($pageActive) { ?>class="pageActive"<? } ?>><? echo $page->value; ?></a> 
									<?
									$previous = $page->value;
								}
							?>
							</div>
							<?
							}
						
						} else {
						?>
								<? echo $lang_apptemoignage["AucunTemoignage"]; ?>
						<?
						}
						?>
						</p>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<div class="colr"> 
				<?
					JL::loadApp('menu_temoignage_offline');
				?>
				</div>
				<div style="clear:both"> </div>
			</div>
    
		<?
		
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
						<?
							// r&eacute;cup la photo de l'utilisateur
							$photo = JL::userGetPhoto($temoignage->user_id, '220', 'profil', $temoignage->photo_defaut);

							// photo par d&eacute;faut
							if(!$photo) {
								$photo = SITE_URL.'/parentsolo/images/parent-solo-220-'.$temoignage->genre.'-'.$_GET['lang'].'.jpg';
							}
						?>
							<div class="temoignage">
									<img width="200" src="<? echo $photo; ?>" alt="<? echo $temoignage->username; ?>" /> <? echo $temoignage->texte; ?>
									<div class="clear"></div>
									<div class="publication">
										<? echo $lang_apptemoignage["TemoignagePublieLePar"]; ?>
									</div>
							</div>
						</p>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<div class="colr"> 
				<?
					JL::loadApp('menu_temoignage_offline');
				?>
				</div>
				<div style="clear:both"> </div>
			</div>
    
		<?
		
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
							<? echo $contenu->texte; ?>
						</p>
						<?
							if(count($messages)){
								// affichage des messages
								$this->messages($messages, false);
							}
						?>
						<p>
							<div class="formulaire">
								<form name="temoignageform" action="<? echo JL::url('index.php?app=temoignage&action=edit').'&lang='.$_GET['lang']; ?>" method="post">
									<div class="formu" style="height:300px;">
										<h2><? echo $lang_apptemoignage["VotreTemoignage"]; ?></h2>
										<div class="pad">
											<table cellpadding="0px" cellspacing="0px">
												<tr><td class="key"><label for="nom"><? echo $lang_apptemoignage["Titre"]; ?></label> *</td><td><input type="text" name="titre" id="titre" maxlength="20" value="<?php echo $row->titre; ?>" /></td></tr>
												<tr><td class="key"><label for="prenom"><? echo $lang_apptemoignage["Texte"]; ?></label> *</td><td><textarea name="texte" id="texte" style="width:325px;height:235px;"><?php echo $row->texte; ?></textarea></td></tr>
											</table>
										</div>
									</div>
									
									<p class="small"  style="font-style:italic">
										* <? echo $lang_apptemoignage["LesChampsMarques"]; ?>
									</p>
									
									
									<input type="hidden" name="action" value="envoyer" />
									<input type="submit" value="<? echo $lang_apptemoignage["Envoyer"]; ?>" class="envoyerForm" />
								</form>
							</div>
						</p>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<div class="colr"> 
				<?
					JL::loadApp('menu_temoignage_offline');
				?>
				</div>
				<div style="clear:both"> </div>
			</div>
    
		<?
		
		}
		
	}
?>

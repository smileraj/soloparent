<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class temoignage_HTML {
	
	
		// affichage des messages syst&egrave;me
		public static function messages(&$messages) {
			global $langue;
			include("lang/app_temoignage.".$_GET['lang'].".php");

			// s'il y a des messages &agrave; afficher
			if (is_array($messages)) {
			?>
				<h2 class="messages parentsolo_title_h3"><?php echo $lang_apptemoignage["MessagesParentsolo"];?></h2>
				<div class="messages">
				<?php 					// affiche les messages
					JL::messages($messages);
				?>
				</div>
				<br />
			<?php 			}

		}
		
		public static function infos(&$contenu) {
			global $db, $template;
			//Information On The Stories
		?>
			
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title parentsolo_mt_40"><?php echo $contenu->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<div class="texte_explicatif">
				<?php echo  $contenu->texte; ?>
			</div>
					
		<?php 		
		}
		
		public static function listall(&$temoignages, &$search) {
			include("lang/app_temoignage.".$_GET['lang'].".php");
			global $db, $template;
			
			$nb_temoignages		= count($temoignages);
			$rayon			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
		//all the stories
		?>
			
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title parentsolo_mt_40 "><?php echo $lang_apptemoignage["TousLesTemoignages"];?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<div class="row parentsolo_pt_15">
    <div class="col-md-12">
        
    
			
		<?php 							$i = 1;
							
							if(is_array($temoignages) && $nb_temoignages){
																
								$nb_fin = ($nb_temoignages < 6 ) ? $nb_temoignages : 6;
								
								for($j=0; $j<$nb_fin; $j++) {
									
									$temoignage = $temoignages[$j];
									
									// limitation de la longueur du titre
									if(strlen($temoignage->titre) > LISTE_TITRE_CHAR) {
										$temoignage->titre = substr($temoignage->titre, 0, LISTE_TITRE_CHAR).'...';
									}
									
									// limitation de la longueur de l'intro
									$temoignage->texte = strip_tags(html_entity_decode($temoignage->texte));
									if(strlen($temoignage->texte) > LISTE_INTRO_CHAR) {
										//$temoignage->texte = substr($temoignage->texte, 0, LISTE_INTRO_CHAR).'...';
										$temoignage->texte = substr($temoignage->texte, 0, 150).'...';
									}
									
									// &agrave; placer toujours apr&egrave;s les 2 limitations
									JL::makeSafe($temoignage, 'texte');
									
									// r&eacute;cup la photo de l'utilisateur
									$photo = JL::userGetPhoto($temoignage->user_id, 'profil', '', $temoignage->photo_defaut);

									// photo par d&eacute;faut
									if(!$photo) {
										$photo = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$temoignage->genre.'-'.$_GET['lang'].'.jpg';
									}
									
									if($i%2 == 1){ echo '<tr>';}
						?>
									<div class="col-md-6 col-sm-12"><div class="col-md-12 col-sm-12  testimonials-style-2 parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
                    <div class="outer">
                        <div class="round">
                            <a href="<?php echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"]; ?>">
                                <img width="100" height="100" src="<?php echo $photo; ?>" class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<?php echo $photo; ?>" sizes="(max-width: 70px) 100vw, 70px">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                    <h2 class="name parentsolo_pt_10"><?php echo $temoignage->username; ?></h2>
                    <div class="text-box testimonialbox parentsolo_pt_10 parentsolo_pb_10">
                        <?php echo $temoignage->texte; ?>
						</div>
                    <a href="<?php echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"];?>">
						<h6 class="parentsolo_text-right parentsolo_txt_clr parentsolo_txt_overflow"><?php echo $temoignage->titre; ?></h6>
					</a>
                </div>
            </div>
        </div></div>
									
									
						<?php 									if($i%2 == 0){echo "</tr>"; }
								
								$i++;
							}
							
							if($i%2!=1){
								while($i%2!=1){
									echo '<td class="preview_liste_off"></td>';
									if($i%2 == 0){echo "</tr>"; }
									
									$i++;
								}
							}
							
						}else{
					?>
							<tr>
								<td align="middle">
									<?php echo $lang_apptemoignage["AucunTemoignage"]; ?>
								</td>
							</tr>-->
					<?php 						}
					?>
						</div>
</div>
			<table class="result search_previews" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td class="pub">
						<?JL::loadMod('pub'); ?>
					</td>
				</tr>
			</table>
		<?	
			if($nb_temoignages > 6){
		?>
		<div class="row">
    <div class="col-md-12">		
		<?php 								for($j=6; $j<$nb_temoignages; $j++) {
									$temoignage = $temoignages[$j];
									
									// limitation de la longueur du titre
									if(strlen($temoignage->titre) > LISTE_TITRE_CHAR) {
										$temoignage->titre = substr($temoignage->titre, 0, LISTE_TITRE_CHAR).'...';
									}
									
									// limitation de la longueur de l'intro
									$temoignage->texte = strip_tags(html_entity_decode($temoignage->texte));
									if(strlen($temoignage->texte) > LISTE_INTRO_CHAR) {
										//$temoignage->texte = substr($temoignage->texte, 0, LISTE_INTRO_CHAR).'...';
										$temoignage->texte = substr($temoignage->texte, 0, 150).'...';
									}
									
									// &agrave; placer toujours apr&egrave;s les 2 limitations
									JL::makeSafe($temoignage, 'texte');
									
									// r&eacute;cup la photo de l'utilisateur
									$photo = JL::userGetPhoto($temoignage->user_id, 'profil', '', $temoignage->photo_defaut);

									// photo par d&eacute;faut
									if(!$photo) {
										$photo = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$temoignage->genre.'-'.$_GET['lang'].'.jpg';
									}
					
									if($i%2 == 1){ echo '<tr>';}
								
								?>
								
								<div class="col-md-6 col-sm-12"><div class="col-md-12 col-sm-12  testimonials-style-2 parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4  parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
                    <div class="outer">
                        <div class="round">
                            <a href="<?php echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"]; ?>">
                               <img width="100" height="100" src="<?php echo $photo; ?>" class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<?php echo $photo; ?>" sizes="(max-width: 70px) 100vw, 70px">
                           </a>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                    <h2 class="name parentsolo_pt_10"><?php echo $temoignage->username; ?></h2>
                    <div class="text-box testimonialbox parentsolo_pt_10 parentsolo_pb_10">
                        <?php echo $temoignage->texte; ?>
						</div>
                    <a href="<?php echo JL::url('index.php?app=temoignage&action=lire&id='.$temoignage->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"];?>">
						<h6 class="parentsolo_text-right parentsolo_txt_clr parentsolo_txt_overflow"><?php echo $temoignage->titre; ?></h6>
					</a>
                </div>
            </div>
        </div>
								</div>
						
								
					<?php 									if($i%2 == 0){echo "</tr>"; }
									
									$i++;
								}
								
								if($i%2!=1){
									while($i%2!=1){
										echo '<td class="preview_liste_off"></td>';
										if($i%2 == 0){echo "</tr>"; }
										
										$i++;
									}
								}
		?>
							</div>
</div>
		<?php 			}
		?>
		
					<div class="col-md-12 parentsolo_plr_0">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" >
						<div class="col-md-3 text-left">
									<?php // page pr&eacute;c&eacute;dente
									if($search['page'] > 1) { ?>
										<a href="<?php echo JL::url(SITE_URL.'/index.php?app=temoignage&action=listall&page='.($search['page']-1).'&'.'&lang='.$_GET["lang"]); ?>" class="bouton envoyer" title="<?php echo $lang_apptemoignage["PagePrecedente"];?>">&laquo; <?php echo $lang_apptemoignage["PagePrecedente"];?></a>
									<?php } ?>
							</div>
							<div class="col-md-6 text-center page_nav">
									<span class="orange"><?php echo $search['page_total'] == 1 ? $lang_apptemoignage["Page"] : $lang_apptemoignage["Pages"];?></span>:
									<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL.'/index.php?app=temoignage&action=listall&page=1'.'&'.'&lang='.$_GET["lang"]); ?>" title="<?php echo $lang_apptemoignage["Debut"];?>"><?php echo $lang_apptemoignage["Debut"];?></a> ...<?php }?>
									<?php 										for($i=$debut; $i<=$fin; $i++) {
										?>
											 <a href="<?php echo JL::url(SITE_URL.'/index.php?app=temoignage&action=listall&page='.$i.'&'.'&lang='.$_GET["lang"]); ?>" title="<?php echo $lang_apptemoignage["Page"];?> <?php echo $i; ?>" <?php if($i == $search['page']) { ?>class="active"<?php } ?>><?php echo $i; ?></a>
										<?php 										}
									?>
									<?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL.'/index.php?app=temoignage&action=listall&page='.$search['page_total'].'&'.'&lang='.$_GET["lang"]); ?>" title="<?php echo $lang_apptemoignage["Fin"];?> <?php echo $search['page_total']; ?>"><?php echo $lang_apptemoignage["Fin"];?></a><?php }?> <i>(<?php echo $search['result_total']; ?> <?php echo $search['result_total'] > 1 ? ''.$lang_apptemoignage["Temoignages"].'' : ''.$lang_apptemoignage["Temoignage"].''; ?>)</i>
								</div>
							<div class="col-md-3 text-right">
									<?php // page suivante
									if($search['page'] < $search['page_total']) { ?>
										<a href="<?php echo JL::url(SITE_URL.'/index.php?app=temoignage&action=listall&page='.($search['page']+1).'&'.'&lang='.$_GET["lang"]); ?>" class="bouton envoyer" title="<?php echo $lang_apptemoignage["PageSuivante"];?>"><?php echo $lang_apptemoignage["PageSuivante"];?> &raquo;</a>
									<?php } ?>
							</div>
					</div>
				</div>
					
		<?php 			
		
		}
		
		public static function lire(&$temoignage) {
			include("lang/app_temoignage.".$_GET['lang'].".php");
			global $db;
			
			JL::makeSafe($temoignage, 'texte');
			
			// r&eacute;cup la photo de l'utilisateur
			$photo = JL::userGetPhoto($temoignage->user_id, '220', 'profil', $temoignage->photo_defaut);

			// photo par d&eacute;faut
			if(!$photo) {
				$photo = SITE_URL.'/parentsolo/images/parent-solo-220-'.$temoignage->genre.'-'.$_GET['lang'].'.jpg';
			}
		?>
		
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title parentsolo_mt_40"><?php echo $temoignage->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
				<div class="row parentsolo_pt_15">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12  story_section">
                                       <div class="story_section"> <div class="wd_img_round">
                                            <img src="<?php echo $photo; ?>" alt="">
                                            <div class="overlay">
                                                <span></span>
                                            </div>
                                        </div>
                                       
					</div>
                                    </div>
					<!--<div class="col-md-4">
						<img src="<?php // echo $photo; ?>" alt="<?php // echo $temoignage->username; ?>" />
					</div>-->
					<div class="col-md-8">
						<p class="parrainageNotice"><?php echo nl2br($temoignage->texte); ?><br />
						<h6 class="parentsolo_text-right parentsolo_txt_clr"><?php echo $lang_apptemoignage["TemoignagePublieLePar"]; ?></h6></p>
					</div>
				</div>
			   
		<?php 		
		}
		
		
		public static function edit(&$contenu, $temoignage, $messages) {
			include("lang/app_temoignage.".$_GET['lang'].".php");
			global $db, $user, $action;
			
			JL::makeSafe($contenu, 'texte');
			/* want to testify */
		?>
			
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title parentsolo_mt_40"><?php echo $contenu->titre; ?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<div class="texte_explicatif">
				<?php echo $contenu->texte; ?>
			</div>
			<br />
		<?php 			if (is_array($messages)){
				// affichage des messages
				temoignage_HTML::messages($messages, false);
			}
		?>
			<div class="row">
				<div class="col-md-6 col-md-offset-3 parentsolo_form_style">
				<form name="temoignage" action="<?php echo JL::url('index.php?app=temoignage&action=edit').'&lang='.$_GET['lang']; ?>" method="post">
				
				<h3 class="parentsolo_title_h3 parentsolo_txt_center"><?php echo $lang_apptemoignage["VotreTemoignage"]; ?></h3>
				<div class="row bottompadding">
							
							<div class="col-md-12">
								<input type="text" name="titre" id="titre" required maxlength="20" placeholder="<?php echo $lang_apptemoignage["Titre"]; ?>" value="<?php echo $temoignage->titre; ?>" />
							</div>
				</div>
				<div class="row bottompadding">
							
							<div class="col-md-12">
								<textarea name="texte" style="width:100%; height: 155px;" required id="texte" rows="10"  placeholder="<?php echo $lang_apptemoignage["Texte"]; ?>" ><?php echo $temoignage->texte; ?></textarea>
							</div></div>
							<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12">
							<h4><?php echo $lang_apptemoignage["CodeDeVerification"];?></h4>
						</div>
						
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12 ">
							<?php echo $lang_apptemoignage["VeuillezRecopierCodeVerification"];?> <strong class="verif"><?php echo $temoignage->captcha; ?></strong>
						</div>
						
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12 parentsolo_txt_center">
						
						<div class="col-md-6 col-md-offset-3">
							<input type="text"  name="verif" class="verif"  required value="" placeholder="<?php echo $lang_apptemoignage["CodeDeVerification"];?>" />
						</div>
					</div>
				</div>
							<div class="row bottompadding">
							<div class="col-md-12 col-md-12 parentsolo_txt_center parentsolo_mt_40">
								<!--<a href="javascript:document.temoignage.submit();" class="bouton envoyer parentsolo_btn"><?php echo $lang_apptemoignage["Envoyer"];?></a> -->
							<input type="submit" value="<?php echo $lang_apptemoignage["Envoyer"];?>" class="bouton envoyer parentsolo_btn">

							</div>
							</div>
				
				
				<input type="hidden" name="app" value="temoignage" />
				<input type="hidden" name="action" value="envoyer" />
				<input type="hidden" name="captchaAbo" value="<?php echo $temoignage->captchaAbo; ?>" />

			</form>
			</div>
		</div>
			
    
		<?php 		
		}
		
	}
?>

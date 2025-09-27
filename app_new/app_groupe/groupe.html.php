<?php

	// s�curit�
	defined('JL') or die('Error 401');

	class HTML_groupe {

		// affichage des messages syst�me
		function messages(&$messages) {
			global $langue;
			include("lang/app_groupe.".$_GET['lang'].".php");

			// s'il y a des messages � afficher
			if (is_array($messages)) {
			?>
				<h2 class="messages"><?php echo $lang_groupe["MessagesParentsolo"];?></h2>
				<div class="messages">
				<?php 					// affiche les messages
					JL::messages($messages);
				?>
				</div>
				<br />
			<?php 			}

		}


		function groupe_titre($groupe_type) {
			global $langue;
			include("lang/app_groupe.".$_GET['lang'].".php");
			global $action;
			
			switch($action){
				
				case 'list' :
					switch($groupe_type){
						case 'all':
							$h1 = $lang_groupe["TousLesGroupes"];
						break;
						
						case 'joined':
							$h1 = $lang_groupe["GroupesRejoints"];
						break;
						
						case 'created':
							$h1 = $lang_groupe["MesCreations"];
						break;
					}
				break;
				
				case 'edit':
				case 'save':
					$h1 = $lang_groupe["CreerUnGroupe"];
				break;
				
			}
		?>
		<hr>
			<h3 class="loginprofile_title_h3 parentsolo_mt_20 parentsolo_txt_center  parentsolo_pb_15"><?php echo $h1;?></h3>
		<?php 		}


		// page temporaire d'annonce des groupes
		function information(&$data) {
			global $langue;
			include("lang/app_groupe.".$_GET['lang'].".php");
		
		?>
		<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title"><?php echo $data->titre; ?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			
			<div class="texte_explicatif">
				<?php echo $data->texte; ?>
			</div>
		<?php 		}


		// affiche la liste d'utilisateurs
		function groupeList(&$rows, &$search, &$messages) {
			global $langue;
			include("lang/app_groupe.".$_GET['lang'].".php");
			global $user, $action;

			// variables
			$groupe_type	= JL::getSession('groupe_type', 'all');
			$rayon			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];

			
			// affichage des messages
			HTML_groupe::messages($messages);

		?>
		<div class="row parentsolo_mb_20 ">
				<form action="index.php<?php echo '?'.$langue; ?>" name="groupeList" method="post">
				<div class="col-md-12  parentsolo_form_style">
					<h3 class="parentsolo_title_h3 parentsolo_txt_center "><?php echo $lang_groupe["Recherche"]; ?></h3>
					
					<div class="row bottompadding parentsolo_mt_20">
					<div class="col-md-6">
						<div class="col-md-4">
							<label for="search_groupe" class="line_height_35"><?php echo $lang_groupe["Recherche"];?></label>
						</div>
						<div class="col-md-8">
							<input type="text" class="input_groupe parentsolo_mt_0" required name="search_groupe" value="<?php echo makeSafe($search['groupe']); ?>" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="col-md-4">
							<label for="search_groupe" class="line_height_35"><?php echo $lang_groupe["OrdonnerPar"];?></label>
						</div>
						<div class="col-md-8">
							<?php echo $search['order_by']; ?>
						</div>
					</div>
					</div>
					
					<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12 parentsolo_txt_center parentsolo_mt_20">
							<a href="javascript:document.groupeList.submit();" title="<?php echo $lang_groupe["Rechercher"];?>" class="bouton annuler  parentsolo_btn"><?php echo $lang_groupe["Rechercher"];?></a>
						</div>
						<input type="hidden" name="app" value="groupe" />
					<input type="hidden" name="action" value="<?php echo $action; ?>" />
					<input type="hidden" name="groupe_type" value="<?php echo $groupe_type; ?>" />
					</div>
					</div>
					
				</div>
					</form>
		</div>
		<!--	<form action="index.php<?php// echo '?'.$langue; ?>" name="groupeList" method="post">
				
				
				<h3 class="form"><?php // echo $lang_groupe["Recherche"]; ?></h3>
				<table class="table_form" cellpadding="0" cellspacing="0">
					<tr>
						<td class="key"><label for="search_groupe"><?php// echo $lang_groupe["Recherche"];?>:</label></td>
						<td><input type="text" class="input_groupe" name="search_groupe" value="<?php // echo makeSafe($search['groupe']); ?>" /></td>
					</tr>
					<tr>
						<td class="key"><label><?php// echo $lang_groupe["OrdonnerPar"];?>:</label></td>
						<td><?php // echo $search['order_by']; ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td align="right">
										<a href="javascript:document.groupeList.submit();" title="<?php echo $lang_groupe["Rechercher"];?>" class="bouton envoyer"><?php echo $lang_groupe["Rechercher"];?></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<input type="hidden" name="app" value="groupe" />
					<input type="hidden" name="action" value="<?php // echo $action; ?>" />
					<input type="hidden" name="groupe_type" value="<?php // echo $groupe_type; ?>" />
				</table>
			</form>
			<br />-->
		<?php 
			// menu groupes
			HTML_groupe::groupe_titre($groupe_type);
		?>
		
		<div class="row">
				<div class="col-md-12">
					<?php 							$i = 1;
							
							// liste les profils
							if(is_array($rows) && count($rows)) {
								foreach($rows as $row) {

									// limitation du texte
									$row->texte = strip_tags(html_entity_decode($row->texte));
									if(strlen($row->texte) > LISTE_INTRO_CHAR) {
										$row->texte = substr($row->texte, 0, 100).'...';
									}
									else{
										$row->texte = substr($row->texte, 0, 100).'...';
									}
									
									$row->titre = strip_tags(html_entity_decode($row->titre));
									if(strlen($row->titre) > LISTE_TITRE_CHAR) {
										$row->titre = substr($row->titre, 0, 100).'...';
									}
									

									// htmlentities
									JL::makeSafe($row, 'titre,texte');

									// si une photo a �t� envoy�e
									$filePath = 'images/groupe/'.$row->id.'.jpg';
									if(is_file(SITE_PATH.'/'.$filePath)) {
										$image	= $filePath;
									} else {
										if($groupe_type == 'created' && is_file(SITE_PATH.'/images/groupe/pending/'.$row->id.'.jpg')) {
											$image = 'images/groupe/pending/'.$row->id.'.jpg';
										} else {
											if($row->user_id == '1'){
												$image	= 'parentsolo/images/parent-solo-109-'.$_GET['lang'].'.jpg';
											} else {
												$image	= 'images/groupes-parentsolo.jpg';
											}
										}
									}

									switch($row->active) {

										case 0:
											$statut = ''.$lang_groupe["Refuse"].'';
											$color	= '#0137ff';
										break;

										case 1:
											$statut = ''.$lang_groupe["Valide"].'';
											$color	= '#009900';
										break;

										case 2:
											$statut = ''.$lang_groupe["Validation"].'';
											$color	= '#ff5806';
										break;

										case 3:
											$statut = ''.$lang_groupe["Verouille"].'';
											$color	= '#c6832d';
										break;

									}


									// d�termine le lien � utiliser
									if($groupe_type == 'created') { // lien pour modifier
										$lien 	= JL::url('index.php?app=groupe&action=edit&id='.$row->id.'&'.$langue);
										$title	= $lang_groupe["ModifierCeGroupe"];
									} else { // lien pour afficher
										$lien 	= JL::url('index.php?app=groupe&action=details&id='.$row->id.'&'.$langue);
										$title	= $lang_groupe["DetailsDuGroupe"];
									}

									if($i%2 == 1){ }
								?>
								
								<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						<h4 class="letter_spacing_0 parentsolo_pt_10 parentsolo_pb_10 parentsolo_txt_center parentsolo_font-size parentsolo_txt_overflow_title"><a href="<?php echo $lien; ?>" title="<?php echo $title; ?>" class="username1"><?php echo $row->titre; ?></a></h4>
						<div class="col-md-4">
							<div class="hovereffect parentsolo_border_radius ">
						<a href="<?php echo $lien; ?>" title="<?php echo $title; ?>"><img src="<?php echo SITE_URL.'/'.$image; ?>" alt="<?php echo $row->titre; ?>" class="superpose " id="img_1"/></a>
													 <?php 														if(time()-strtotime($row->date_add) < 3600*24*3) { 
													?>
															<a href="<?php echo $lien; ?>" title="<?php echo $title; ?>"><img src="<?php echo SITE_URL.'/images/groupe/groupe-calque-'.$_GET['lang'].'.png'; ?>" alt="<?php echo $row->titre; ?>" class="superpose" id="img_2" /></a>
													<?php 
														} 
													?>
													</div>
						</div>
						<div class="col-md-8 parentsolo_pt_10 parentsolo_pb_10">
						<div class="supplement members_cls line_height_25">
										<?php 											if($row->id != 1) {
												
												// pas de membre
												if($row->total_membres == 0) {
									
													echo $lang_groupe["AucunMembre"];
													
												} else {
													
													echo $row->total_membres > 1 ? '<b>'.$row->total_membres.'</b> '.$lang_groupe["MembresOntRejointCeGroupe"] : '<b>'.$row->total_membres.'</b> '.$lang_groupe["MembreARejointCeGroupe"];
									
												}
											}
											
										?>
											<br />
										<?php 											HTML_groupe::groupePopularite($row->popularite);
										?>
										</div>
						</div>
						<div class="col-md-12">
						<?php 											if($groupe_type == 'created' && $row->user_id == $user->id) {
										?>
												<div class="infos">
													<div class="connect ">
														<span style="font-weight:bold;color:<?php echo $color; ?>;">(<?php echo $statut; ?>)</span>
													</div>
												</div>
										<?php 											}
										?>
										<div class="description text-box">
											<?php echo $row->texte; ?>
										</div>
						</div>
								</div>
					</div>
								
									
					<?php 							
								if($i%2 == 0){ }
								
								$i++;
							}
							
							if($i%2!=1){
								while($i%2!=1){
									echo '<div class="preview_liste_off"></div>';
									if($i%2 == 0){echo ""; }
									
									$i++;
								}
							}
							
						}else{
				?>
						<tr>
							<td align="middle">
								<?php echo $lang_groupe["AucunGroupe"];?>!
							</td>
						</tr>
				<?php 					}
				?>
					
				</div>
		</div>
	<div class="col-md-12 parentsolo_plr_0">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" cellpadding="0" cellspacing="0">
						<div class="col-md-3 text-left">
								<?php // page pr�c�dente
								if($search['page'] > 1) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action='.$action.'&groupe_type='.$groupe_type.'&page='.($search['page']-1)).'&'.$langue; ?>" class="bouton envoyer" title="<?php echo $lang_groupe["PagePrecedente"];?>">&laquo; <?php echo $lang_groupe["PagePrecedente"];?></a>
								<?php } ?>
							</div>
							<div class="col-md-6 text-center page_nav">
								<b><?php echo $search['page_total'] == 1 ? $lang_groupe["Page"] : $lang_groupe["Pages"];?></b>:
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action='.$action.'&groupe_type='.$groupe_type.'&page=1').'&'.$langue; ?>" title="<?php echo $lang_groupe["Debut"];?>"><?php echo $lang_groupe["Debut"];?></a> ...<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action='.$action.'&groupe_type='.$groupe_type.'&page='.$i).'&'.$langue; ?>" title="<?php echo $lang_groupe["Page"];?> <?php echo $i; ?>" <?php if($i == $search['page']) { ?>class="active"<?php } ?>><?php echo $i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action='.$action.'&groupe_type='.$groupe_type.'&page='.$search['page_total']).'&'.$langue; ?>" title="<?php echo $lang_groupe["Fin"];?>"><?php echo $lang_groupe["Fin"];?></a><br>
								<?php }?> <i>(<?php echo $search['result_total'] ==1 ? $search['result_total'].' '.$lang_groupe["groupe"] : $search['result_total'].' '.$lang_groupe["groupes"];?>)</i>
							</div>
							<div class="col-md-3 text-right">
								<?php // page suivante
								if($search['page'] < $search['page_total']) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action='.$action.'&groupe_type='.$groupe_type.'&page='.($search['page']+1)).'&'.$langue; ?>" class="bouton envoyer" title="<?php echo $lang_groupe["PageSuivante"];?>"><?php echo $lang_groupe["PageSuivante"];?> &raquo;</a>
								<?php } ?>
							</div>
					</div>
				</div>
		<?php 		}


		// affichage de la barre de popularit�
		function groupePopularite($popularite) {
			global $langue;
			include("lang/app_groupe.".$_GET['lang'].".php");

			// correctif arrondi popularit�
			if($popularite > 100) $popularite = 100;

			// d�termine le rang de popularit�
			if($popularite == 0) {
				$populariteRang = 0;
			} elseif($popularite < 25) {
				$populariteRang = 1;
			} elseif($popularite < 50) {
				$populariteRang = 2;
			} elseif($popularite < 75) {
				$populariteRang = 3;
			} elseif($popularite < 100) {
				$populariteRang = 4;
			} elseif($popularite == 100) {
				$populariteRang = 5;
			}

			// d�termine le sous-rang
			$populariteSousRang	= $popularite % 25 == 0 ? 0 : ($popularite % 25) / 10;

			?>
				<div class="popularite">
					<span class="popularite"><?php echo $lang_groupe["Popularite"];?> :</span>
					<img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/popularite_groupe<?php echo $populariteRang; ?>.png" alt="<?php echo $lang_groupe["Popularite"];?>"/>
					<div class="populariteBarreBg"><div class="rang<?php echo $populariteRang; ?>" style="width:<?php echo ceil(32*$populariteSousRang); ?>px;">&nbsp;</div></div>
				</div>
			<?php 		}


		// affichage de la fiche d�taill�e d'un groupe
		function groupeFiche(&$row, &$membres, &$search) {
			include("lang/app_groupe.".$_GET['lang'].".php");
			global $langue, $action, $user;


			// htmlentities
			JL::makeSafe($row);


			// variables
			$groupe_type	= JL::getSession('groupe_type', 'all');
			$rayon			= 5;
			$genres			= array('h','f');
			$debut			= array();
			$fin			= array();

			// si une photo a �t� envoy�e
			$filePath = 'images/groupe/'.$row->id.'.jpg';
			if(is_file(SITE_PATH.'/'.$filePath)) {
				$image	= $filePath;
			} else {
				if($row->user_id == '1'){
					$image	= 'parentsolo/images/parent-solo-109-'.$_GET['lang'].'.jpg';
				} else {
					$image	= 'images/groupes-parentsolo.jpg';
				}
			}
			
			
			?>
			
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $row->titre; ?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-3">
							<div id="groups">
			<div class="circular-item" title="">
									<small class="icon">members</small>
									<div style="width:60px;display:inline;&quot;">
										<canvas width="60" height="60"></canvas><?php // pas le groupe par d�faut
						if($row->id != 1) {
						?>
							<span class="stats_membres_note">
							<?php 								// pas de membre
								$total_membres = $search['result_total_h']+$search['result_total_f'];
								if($total_membres == 0) {
								?>
									<?php echo '0'?>
								<?php 								} else {
								?>
									<?php echo $total_membres < 2 ? '<b>'.$total_membres.'</b> '.$lang_groupe["MembreARejointCeGroupe"] : '<b>'.$total_membres.'</b> ' ?>
								<?php 								}
							?>
							</span>
						<?php 						}
						?></div>
								</div></div>
							
							<img src="<?php echo SITE_URL.'/'.$image; ?>" alt="<?php echo $row->titre; ?>" class="superpose parentsolo_group_img" id="img_1"/>
							 <?php 								if(time()-strtotime($row->date_add) < 3600*24*3) { 
							?>
									<img src="<?php echo SITE_URL.'/images/groupe/groupe-calque-'.$_GET['lang'].'.png'; ?>" alt="<?php echo $row->titre; ?>" class="superpose" id="img_2" />
							<?php 
								} 
							?>
						</div>
						<div class="col-md-9 members_cls parentsolo_pt_10 parentsolo_pb_15 line_height_25">
							<h6 class="text-right  parentsolo_pb_10">
								<?php // si  membre du groupe
							if($row->membre) { ?>
								<a href="javascript:if(confirm('<?php echo $lang_groupe["ConfirmationQuitterGroupe"];?> ?')) {document.location='<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action=quit&id='.$row->id).'&'.$langue; ?>';}" title="<?php echo $lang_groupe["Quitter"];?>" class="bouton annuler"><?php echo $lang_groupe["Quitter"];?> <i class="fa fa-user-times"></i></a>
							<?php } else { ?>
								<a href="javascript:if(confirm('<?php echo $lang_groupe["ConfirmationRejoindreGroupe"];?> ?')) {document.location='<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action=join&id='.$row->id).'&'.$langue; ?>';}" title="<?php echo $lang_groupe["Rejoindre"];?>" class="bouton envoyer"><?php echo $lang_groupe["Rejoindre"];?> <i class="fa fa-user-plus"></i></a>
							<?php 							}

						?>
							</h6>
							<h5><span class="popularite"><?php echo $lang_groupe["Fondateur"];?> : </span> <?php if($user->genre != $row->genre_fondateur && $row->user_id !=1){?><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$row->user_id.'&lang='.$_GET['lang']); ?>"  title="<?php echo $row->fondateur; ?>"><?php echo $row->fondateur; ?></a><?php }else{ ?><?php echo $row->fondateur; ?><?php } ?>
							
							</h5>
							
						<?php // pas le groupe par d�faut
						if($row->id != 1) {
						?>
							<span class="stats_membres">
							<?php 								// pas de membre
								$total_membres = $search['result_total_h']+$search['result_total_f'];
								if($total_membres == 0) {
								?>
									<?php echo $lang_groupe["AucunMembre"];?>.
								<?php 								} else {
								?>
									<?php echo $total_membres < 2 ? '<b>'.$total_membres.'</b> '.$lang_groupe["MembreARejointCeGroupe"] : '<b>'.$total_membres.'</b> '.$lang_groupe["MembresOntRejointCeGroupe"]; ?>.
								<?php 								}
							?>
							</span>
						<?php 						}
						?><?php HTML_groupe::groupePopularite($row->popularite); ?>
						
						</div>
						<div class="col-md-12 text-box">
						<?php echo nl2br($row->texte); ?>
						</div>
					</div>
				</div>
					
			
		<?	
			// pour chaque genre
			foreach($genres AS $genre) {
				
				// si des profils de ce $genre ont rejoint le groupe
				if($search['result_total_'.$genre] > 0 && $genre!=$user->genre) {
					
					$results=array();
					$results=$membres[$genre];
					
					$i=1;
					// pagination
					$debut[$genre]	= ($search['page_'.$genre] - $rayon) >= 1 ? $search['page_'.$genre] - $rayon : 1;
					$fin[$genre]	= ($search['page_'.$genre] + $rayon) <= $search['page_total_'.$genre] ? $search['page_'.$genre] + $rayon : $search['page_total_'.$genre];


					// construction de la balise h2
					$h2	= $search['result_total_'.$genre];

					if($genre == 'h') {
						if($search['result_total_'.$genre] > 1) {
							$h2 .= ' '.$lang_groupe["PapasOntRejointCeGroupe"].'';
						}else{
							$h2 .= ' '.$lang_groupe["PapaARejointCeGroupe"].'';
						}
					} else {
						if($search['result_total_'.$genre] > 1) {
							$h2 .= ' '.$lang_groupe["MamansOntRejointCeGroupe"].'';
						}else{
							$h2 .= ' '.$lang_groupe["MamanARejointCeGroupe"].'';
						}
					}

					?>
					<br />
					<hr>
					<h3 class="loginprofile_title_h3 parentsolo_mt_20 parentsolo_txt_center  parentsolo_pb_15"><?php echo $h2; ?></h3>
						<div class="row">
					<div class="col-md-12 group">
						
					
				<?php 									$nb_results		= count($results);
							
									$i = 1;
								
									if(is_array($results) && $nb_results){
							
										$nb_fin = ($nb_results < 8) ? $nb_results : 8;
										
										for($j=0; $j<$nb_fin; $j++) {
											$result = $results[$j];
											
											
											// � placer toujours apr�s les 2 limitations
											JL::makeSafe($result);
											
											if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

												$last_online_class 		= 'lo_online';
												$last_online_label		= $lang_groupe["EnLigne"];

											} else{ // aujourd'hui (60*60*24)

												$last_online_class 	= 'lo_offline';
												$last_online_label	= $lang_groupe["HorsLigne"];

											}
											
											
											// r�cup la photo de l'utilisateur
											$photo_galerie = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

											if(!$photo_galerie) {
												$photo_galerie = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
											}
											
											
											if($i%4 == 1){ echo '<tr>';}
											
											?>
											<div class="col-md-3 parentsolo_txt_center">
												<div class="hovereffect ">
														<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"  title="<?php echo $lang_groupe["VoirCeProfil"]; ?>"><img src="<?php echo $photo_galerie; ?>" alt="<?php echo $result->username; ?>" class="profil"/></a>
												 <div class="overlay">
           <h2><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"  title="<?php echo $lang_groupe["VoirCeProfil"]; ?>" class="username"><?php echo $result->username; ?></a>
													</h2>
          <span><br /><?php echo $result->age; ?> <?php echo $lang_groupe["Ans"];?><br />
														<?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_groupe["Enfants"] : $lang_groupe["Enfant"]; ?><br />
														<?php echo $result->canton_abrev; ?><br /></span>
														
        </div>
												</div>
												<div class="clear"></div>
												<h3 class="">
													<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_groupe["VoirCeProfil"]; ?>" class="username"><?php echo $result->username; ?></a>
													
												   </h3>
												<p class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></p>
											</div>
											
												
								<?php 											
											if($i%4 == 0){echo "</tr>"; }
									
											$i++;
										}
										
										if($i%4!=1){
											while($i%4!=1){
												echo '<td class="preview_off"></td>';
												if($i%4 == 0){echo "</tr>"; }
												
												$i++;
											}
										}
										
									}
								?>
								</div>
					</div>
				<?php 
					if($search['page_total_'.$genre] > 1) { 
				?>
				
				<div class="col-md-12 parentsolo_plr_0">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" cellpadding="0" cellspacing="0">
						<div class="col-md-3 text-left">
							<?php // page pr�c�dente
												if($search['page_'.$genre] > 1) { 
												?>
													<a href="<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action='.$action.'&id='.$row->id.'&page_'.$genre.'='.($search['page_'.$genre]-1).'&'.$langue); ?>" class="bouton envoyer" title="<?php echo $lang_groupe["PagePrecedente"];?>">&laquo; <?php echo $lang_groupe["PagePrecedente"];?></a>
												<?php } ?>
							</div>
							<div class="col-md-6 text-center page_nav">
								<?php echo $lang_groupe["Pages"];?></b> :
												<?php if($debut[$genre] > 1) { ?> <a href="<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action='.$action.'&id='.$row->id.'&page_'.$genre.'=1&'.$langue); ?>" title="<?php echo $lang_groupe["Debut"];?>"><?php echo $lang_groupe["Debut"];?></a> ...<?php }?>
												<?php 													for($i=$debut[$genre]; $i<=$fin[$genre]; $i++) {
													?>
														 <a href="<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action='.$action.'&id='.$row->id.'&page_'.$genre.'='.$i.'&'.$langue); ?>" title="<?php echo $lang_groupe["Page"];?>" <?php if($i == $search['page_'.$genre]) { ?>class="active"<?php } ?>><?php echo $i; ?></a>
													<?php 													}
												?>
												<?php if($fin[$genre] < $search['page_total_'.$genre]) { ?> ... <a href="<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action='.$action.'&id='.$row->id.'&page_'.$genre.'='.$search['page_total'.$genre].'&'.$langue); ?>" title="<?php echo $lang_groupe["Fin"];?>"><?php echo $lang_groupe["Fin"];?></a><?php }?><br />
												<i>(<?php echo $search['result_total_'.$genre]; ?> <?php echo ($search['result_total_'.$genre] > 1) ? ''.$lang_groupe["membres"].'' : ''.$lang_groupe["membre"].''; ?>)</i>
											</div>
							<div class="col-md-3 text-right">
								<?php // page suivante
												if($search['page_'.$genre] < $search['page_total_'.$genre]) { ?>
													<a href="<?php echo JL::url(SITE_URL.'/index.php?app=groupe&action='.$action.'&id='.$row->id.'&page_'.$genre.'='.($search['page_'.$genre]+1).'&'.$langue); ?>" class="bouton envoyer" title="<?php echo $lang_groupe["PageSuivante"];?>"><?php echo $lang_groupe["PageSuivante"];?> &raquo;</a>
												<?php } ?>
							</div>
					</div>
				</div>
				
				
				
				
				
						
				<?php 					}

				}

			}
		
		}



		
		
		
		
		// ajout/�dition
		function groupeEdit(&$row, &$messages,&$groupe) {
			global $langue;
			include("lang/app_groupe.".$_GET['lang'].".php");

			// htmlentities
			JL::makeSafe($row);

			// si l'article a d�j� �t� enregistr�
			if($row->id) {
				switch($row->active) {

					case 0:
						$statut = ''.$lang_groupe["Refuse"].'';
						$color	= '#0137ff';
					break;

					case 1:
						$statut = ''.$lang_groupe["Valide"].'';
						$color	= '#009900';
					break;

					case 2:
						$statut = ''.$lang_groupe["Validation"].'';
						$color	= '#ff5806';
					break;

					case 3:
						$statut = ''.$lang_groupe["Verouille"].'';
						$color	= '#c6832d';
					break;

				}
			}

			// affichage des messages
			HTML_groupe::messages($messages);

		?>
			<?php // si le groupe a d�j� �t� enregistr�
				if($row->id) {

				// si une photo a �t� envoy�e
				$filePath1 = 'images/groupe/'.$row->id.'.jpg';
				if(is_file($filePath1)) {
					$image	= $filePath1;
				} else {
					if($row->user_id == '1'){
						$image	= 'parentsolo/images/parent-solo-109-'.$_GET['lang'].'.jpg';
					} else {
						$image	= 'images/groupes-parentsolo.jpg';
					}
				}
				?>
				<h2 class="barre"><?php echo $lang_groupe["ContenuVuParAutreMembre"];?></h2>
				<div class="texte_explicatif">
					
					<?php 
						if($row->titre != ""){
					?>
					<table class="table_form" cellpadding="0" cellspacing="0">
						<tr>
							<td class="photo" valign="top">
									<img src="<?php echo SITE_URL.'/'.$image; ?>?<?php echo time(); ?>" />
							</td>
							<td>
								<b><?php echo $row->titre; ?></b><br />
								<br />
								<?php echo $row->texte; ?><br />
								<br />
								<b><?php echo $lang_groupe["DateDeCreation"];?>:</b><?php echo date('d.m.Y', strtotime($row->date_add)); ?> <?php echo date('H:i', strtotime($row->date_add)); ?>
								<?php if($row->motif != '') { ?>
									<br />
									<br />
									<b><?php echo $lang_groupe["Message"];?>:</b><?php echo nl2br($row->motif); ?>
								<?php }?>
							</td>
						</tr>
					</table>
					<?php 						}elseif($row->active==2){
							
							echo $lang_groupe["GroupeNonVisibleEnCoursDeValidation"]; 
							
						}else{
							
							echo $lang_groupe["GroupeNonVisibleRefuse"]; 
						}
					?>
					
				</div>
				<br />
				<?php 				} // row->id
				?>
					<div class="row">
				<div class="col-md-10 col-md-offset-1 parentsolo_form_style">
				<form action="index.php<?php echo '?'.$langue; ?>" name="groupe" method="post">
					
					
				<h3 class="parentsolo_title_h3 parentsolo_txt_center"><?php echo $row->id ? ''.$lang_groupe["ModifierMonGroupe"].'' : ''.$lang_groupe["CreerMonGroupe"].''; ?></h3>
				<?php 						if($row->id) {
					?><div class="row bottompadding">
							
							<div class="col-md-12 parentsolo_mt_20">
								<?php echo $lang_groupe["Statut"];?> :
								<span style="font-weight:bold;color:<?php echo $color; ?>;"><?php echo $statut; ?>
							</div>
				</div>
						
					<?php 						}
					?>
				
				
				<div class="row bottompadding">
							
							<div class="col-md-12 parentsolo_mt_20"><?php echo $lang_groupe["Titre"];?> :
							<br>
								<input type="text" required id="titre" name="titre" maxlength="70" value="<?php echo $row->titre_a_valider; ?>">
							</div>
				</div>
				<div class="row bottompadding">
							
							<div class="col-md-12"><?php echo $lang_groupe["Texte"];?>:
								<textarea required style="width:100%; height: 155px;" id="texte" rows="10" name="texte"><?php echo $row->texte_a_valider; ?></textarea>
							</div></div>
							
				<div class="row bottompadding">
							<div class="col-md-4"><b><?php echo $lang_groupe["EnvoyerPhoto"];?> : </b>
							</div>
							<div class="col-md-8">
								<?php 										if($_GET['lang']=='fr'){
									?>
											<div class="swfu_btn"><span id="spanButtonPlaceholder"></span></div>
									<?php 										}elseif($_GET['lang']=='en'){
									?>
										<div class="swfu_btn_en"><span id="spanButtonPlaceholder"></span></div>
									<?php 										}elseif($_GET['lang']=='de'){
									?>
										<div class="swfu_btn_de"><span id="spanButtonPlaceholder"></span></div>
									<?php 									}
									?>
									</div>
				</div>
				<div class="row bottompadding1">
							<div class="col-md-6 parentsolo_txt_center">
								<div id="divFileProgressContainer"></div>
							</div>
							
							<div class="col-md-6 parentsolo_txt_center">
								<div id="thumbnailsGroupe">
								<?php 									// si la photo existe
									$filePath2 = 'images/groupe/pending/'.$row->id.'.jpg';
									if(is_file($filePath2)) {
										$image = $filePath2;
									} elseif(is_file($filePath1)) {
										$image = $filePath1;
									} else {
										$image = '';
									}

									if($image != '') {
									?>
									<div class="miniature" id="<?php echo $image; ?>">
										<img src="<?php echo SITE_URL.'/'.$image; ?>?<?php echo time(); ?>" />
										<a href="javascript:deleteImage('<?php echo $image; ?>','','thumbnailsGroupe');" class="btnDelete"><?php echo $lang_groupe["Supprimer"];?></a>
									</div>
									<?php 									}
								?>
								</div>
							</div>
							</div>
				<div class="row bottompadding">
							<div class="col-md-12 col-md-12 parentsolo_txt_center">
								<?php 								// attente validation
								if(is_file('images/groupe/pending/'.$row->id.'.jpg')) {
								?>
									<div class="messages">
										<div class="warning">
											<span class="warning"><?php echo $lang_groupe["PhotoEnAttenteValidation"];?>.</span>
										</div>
									</div>
								<?php 								}
							?>
							</div>
							</div>
				<div class="row bottompadding">
							<div class="col-md-12 col-md-12 parentsolo_txt_center">
								<div class="messages">
									<div class="warning">
									<?	
										if($row->id){
											echo '<span class="warning">'.$lang_groupe["VerificationModificationsGroupe"].'.</span>';
										}else{
											echo '<span class="warning">'.$lang_groupe["VerificationCreationGroupe"].'.</span>';
										}
									?>
									</div>
								</div>
							</div>
							</div>
				<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12">
							<h4><?php echo $lang_groupe["CodeDeVerification"];?></h4>
						</div>
						
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12 ">
							<?php echo $lang_groupe["VeuillezRecopierCodeVerification"];?> <strong class="verif"><?php echo $groupe->captcha; ?></strong>
						</div>
						
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12 parentsolo_txt_center">
						
						<div class="col-md-6 col-md-offset-3">
							<input type="text"  name="verif" class="verif"  required value="" placeholder="<?php echo $lang_groupe["CodeDeVerification"];?>" />
						</div>
					</div>
				</div>
							<div class="row bottompadding">
							<div class="col-md-12 col-md-12 parentsolo_txt_center parentsolo_mt_40">
								<a href="javascript:if(confirm('<?php echo $lang_groupe["ConfirmationAnnulation"];?> ?')){document.location='<?php echo JL::url('index.php?app=groupe&action=list&groupe_type=created').'&'.$langue; ?>';}" class="bouton annuler parentsolo_btn"><?php echo $lang_groupe["Annuler"];?></a>
									<!--<a href="javascript:document.groupe.submit();" class="bouton envoyer parentsolo_btn"><?php echo $lang_groupe["Envoyer"];?></a>-->
														<input type="submit" value="<?php echo $lang_groupe["Envoyer"];?>" class="bouton envoyer parentsolo_btn">

								
							</div>
							</div>
				
				
				<input type="hidden" name="phototemp" id="phototemp" value="<?php echo $row->phototemp; ?>" />
					<input type="hidden" name="app" value="groupe" />
					<input type="hidden" name="action" value="save" />
					<input type="hidden" name="id" id="upload_dir" value="<?php echo $row->id; ?>" />
					<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
					<input type="hidden" name="hash" id="hash" value="<?php echo md5(date('y').$row->id.date('Y')); ?>" />
					<input type="hidden" name="captchaAbo" value="<?php echo $groupe->captchaAbo; ?>" />

			</form>
			</div>
		</div>
				
					
				
				<?php 				if($_GET['lang']=='fr'){
			?>
				<script type="text/javascript">
					uploaderInitGroupe_fr();
				</script>
			<?php 				}elseif($_GET['lang']=='en'){
			?>
				<script type="text/javascript">
					uploaderInitGroupe_en();
				</script>
			<?php 				}elseif($_GET['lang']=='de'){
			?>
				<script type="text/javascript">
					uploaderInitGroupe_de();
				</script>
			<?php 			}
		
		}

	}

?>

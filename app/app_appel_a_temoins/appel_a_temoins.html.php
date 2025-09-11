<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	class HTML_appel_a_temoins {

		// affichage des messages syst&egrave;me
public static function messages(&$messages) {
			global $langue;
			include("lang/app_appel_a_temoins.".$_GET['lang'].".php");

			// s'il y a des messages &agrave; afficher
			if(count($messages)) {
			?>
				<h2 class="messages parentsolo_title_h3"><?php echo $lang_appel_a_temoins["MessagesParentsolo"];?></h2>
				<div class="messages">
				<?
					// affiche les messages
					JL::messages($messages);
				?>
				</div>
				<br />
			<?
			}

		}


		// affiche la liste des appels &agrave; t&eacute;moins
		public static function appel_a_temoinsList(&$appels_temoins, &$messages, &$search) {
			global $langue,$template;
			include("lang/app_appel_a_temoins.".$_GET['lang'].".php");

			
		
			$nb_appels_temoins		= count($appels_temoins);
			$rayon			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
		?>
			
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title parentsolo_mt_40 2">
			<?php echo $lang_appel_a_temoins["ListeDesAppels"];?></h2>
			<div class="wedd-seperator parentsolo_pb_10 "><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<div class="row parentsolo_pt_15">
    <div class="col-md-12">
        
    <?
							$i = 1;
							
							if(is_array($appels_temoins) && $nb_appels_temoins){
								
								for($j=0; $j<6; $j++) {
									$appel_temoins = $appels_temoins[$j];
									
									// limitation de la longueur du titre
									if(strlen($appel_temoins->titre) > LISTE_TITRE_CHAR) {
										//	$appel_temoins->titre = substr($appel_temoins->titre, 0, 20).'...';
										$appel_temoins->titre = substr($appel_temoins->titre, 0, LISTE_TITRE_CHAR).'...';
									}
									
									// limitation de la longueur de l'intro
									$appel_temoins->annonce = strip_tags(html_entity_decode($appel_temoins->annonce));
									if(strlen($appel_temoins->annonce) > LISTE_INTRO_CHAR) {
										//	$appel_temoins->annonce = substr($appel_temoins->annonce, 0, LISTE_INTRO_CHAR).'...';
										$appel_temoins->annonce = substr($appel_temoins->annonce, 0, 90).'...';
									}
									
									// &agrave; placer toujours apr&egrave;s les 2 limitations
									JL::makeSafe($appel_temoins, 'annonce');
									
									// r&eacute;cup la photo de l'utilisateur
									$photo = SITE_URL.'/images/appel-a-temoins/'.$appel_temoins->id.'.jpg';

									// photo par d&eacute;faut
									if(!is_file(SITE_PATH.'/images/appel-a-temoins/'.$appel_temoins->id.'.jpg')) {
										$photo = $template.'/images/box/3-'.$_GET['lang'].'.jpg';
									}
									
									if($i%2 == 1){ echo '<tr>';}
						?>
						
						<div class="col-md-6 col-sm-12"><div class="col-md-12 col-sm-12  testimonials-style-2 parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
                    <div class="outer">
                        <div class="round">
                            <a href="<? echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$appel_temoins->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_appel_a_temoins["LireAppelATemoins"];?>" >
                                <img width="100" height="100" src="<? echo $photo; ?>" alt="<? echo $appel_temoins->username; ?>" class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<? echo $photo; ?>" sizes="(max-width: 70px) 100vw, 70px">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                    <h2 class="name parentsolo_pt_10"><? echo $appel_temoins->media; ?></h2>
                    <div class="text-box parentsolo_pt_10 parentsolo_pb_10">
                       <? echo $appel_temoins->annonce; ?>
						</div>
                    <a class="username" href="<? echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$appel_temoins->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_appel_a_temoins["LireAppelATemoins"];?>">
						<h6 class="parentsolo_text-right parentsolo_txt_clr parentsolo_txt_overflow"><? echo $appel_temoins->titre; ?></h6>
					</a>
                </div>
            </div>
        </div></div>
						
						
						
						
						
						
								
						<?
									if($i%2 == 0){echo "<div class='clear'></div>"; }
								
									$i++;
								}
								
								if($i%2!=1){
									while($i%2!=1){
										echo '';
										if($i%2 == 0){echo "</tr>"; }
										
										$i++;
									}
								}
								
							}else{
						?>
								<tr>
									<td align="middle">
										<?php echo $lang_appel_a_temoins["AucuneAppelATemoins"];?>
									</td>
								</tr>
						<?
							}
						?>
	</div>
			</div>
			<table class="result" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td class="pub">
						<?JL::loadMod('pub'); ?>
					</td>
				</tr>
			</table>
		<?
			
			if($nb_appels_temoins > 6){
		?>
				<div class="row parentsolo_pt_15">
    <div class="col-md-12"><?
								for($j=6; $j<$nb_appels_temoins; $j++) {
									$appel_temoins = $appels_temoins[$j];
									
									// limitation de la longueur du titre
									if(strlen($appel_temoins->titre) > LISTE_TITRE_CHAR) {
										$appel_temoins->titre = substr($appel_temoins->titre, 0, LISTE_TITRE_CHAR).'...';
										//$appel_temoins->titre = substr($appel_temoins->titre, 0, 20).'...';
									}
									
									// limitation de la longueur de l'intro
									$appel_temoins->annonce = strip_tags(html_entity_decode($appel_temoins->annonce));
									if(strlen($appel_temoins->annonce) > LISTE_INTRO_CHAR) {
										$appel_temoins->annonce = substr($appel_temoins->annonce, 0, 90).'...';
										//$appel_temoins->annonce = substr($appel_temoins->annonce, 0, LISTE_INTRO_CHAR).'...';
									}
									
									// &agrave; placer toujours apr&egrave;s les 2 limitations
									JL::makeSafe($appel_temoins, 'annonce');
									
									$photo = SITE_URL.'/images/appel-a-temoins/'.$appel_temoins->id.'.jpg';

									// photo par d&eacute;faut
									if(!is_file(SITE_PATH.'/images/appel-a-temoins/'.$appel_temoins->id.'.jpg')) {
										$photo = $template.'/images/box/3-'.$_GET['lang'].'.jpg';
									}
									
									if($i%2 == 1){ echo '<tr>';}
						?>
						<div class="col-md-6 col-sm-12"><div class="col-md-12 col-sm-12  testimonials-style-2 parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
                    <div class="outer">
                        <div class="round">
                            <a href="<? echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$appel_temoins->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_appel_a_temoins["LireAppelATemoins"];?>">
                                <img width="100" height="100" src="<? echo $photo; ?>" alt="<? echo $appel_temoins->username; ?>" class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<? echo $photo; ?>" sizes="(max-width: 70px) 100vw, 70px">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                    <h2 class="name parentsolo_pt_10"><? echo $appel_temoins->media; ?></h2>
                    <div class="text-box parentsolo_pt_10 parentsolo_pb_10">
                       <? echo $appel_temoins->annonce; ?>
						</div>
                    <a class="username"  href="<? echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$appel_temoins->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_appel_a_temoins["LireAppelATemoins"];?>">
						<h6 class="parentsolo_text-right parentsolo_txt_clr parentsolo_txt_overflow"><? echo $appel_temoins->titre; ?></h6>
					</a>
                </div>
            </div>
        </div></div>
						<?
									if($i%2 == 0){echo "<div class='clear'></div>"; }
								
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
										<?php echo $lang_appel_a_temoins["AucuneAppelATemoins"];?>
									</td>
								</tr>
						<?
							}
						?>
	</div>
				</div>
			
				<div class="col-md-12 parentsolo_plr_0">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" >
						<div class="col-md-3 text-left">								
									<? // page pr&eacute;c&eacute;dente
									if($search['page'] > 1) { ?>
										<a href="<? echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&page='.($search['page']-1).'&'.'&lang='.$_GET["lang"]); ?>" class="bouton envoyer" title="<?php echo $lang_appel_a_temoins["PagePrecedente"];?>">&laquo; <?php echo $lang_appel_a_temoins["PagePrecedente"];?></a>
									<? } ?>
								</div>
							<div class="col-md-6 text-center page_nav">
									<span class="orange"><?php echo $search['page_total'] == 1 ? $lang_appel_a_temoins["Page"] : $lang_appel_a_temoins["Pages"];?></span>:
									<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&page=1'.'&'.'&lang='.$_GET["lang"]); ?>" title="<?php echo $lang_appel_a_temoins["Debut"];?>"><?php echo $lang_appel_a_temoins["Debut"];?></a> ...<? }?>
									<?
										for($i=$debut; $i<=$fin; $i++) {
										?>
											 <a href="<? echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&page='.$i.'&'.'&lang='.$_GET["lang"]); ?>" title="<?php echo $lang_appel_a_temoins["Page"];?> <? echo $i; ?>" <? if($i == $search['page']) { ?>class="active"<? } ?>><? echo $i; ?></a>
										<?
										}
									?>
									<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&page='.$search['page_total'].'&'.'&lang='.$_GET["lang"]); ?>" title="<?php echo $lang_appel_a_temoins["Fin"];?> <? echo $search['page_total']; ?>"><?php echo $lang_appel_a_temoins["Fin"];?></a><? }?> <i>(<? echo $search['result_total']; ?> <? echo $search['result_total'] > 1 ? ''.$lang_appel_a_temoins["AppelsATemoins"].'' : ''.$lang_apptemoignage["AppelATemoins"].''; ?>)</i>
									</div>
								    <div class="col-md-3 text-right">
									<? // page suivante
									if($search['page'] < $search['page_total']) { ?>
										<a href="<? echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&page='.($search['page']+1).'&'.'&lang='.$_GET["lang"]); ?>" class="bouton envoyer" title="<?php echo $lang_appel_a_temoins["PageSuivante"];?>"><?php echo $lang_appel_a_temoins["PageSuivante"];?> &raquo;</a>
									<? } ?>
								</div>
							</div>
						</div>
					
				
		<?
		}


		// formulaire de r&eacute;daction d'un appel
		public static function appel_a_temoinsWrite(&$data, &$row, &$messages, &$list) {
			global $langue;
			include("lang/app_appel_a_temoins.".$_GET['lang'].".php");

			// htmlentities
			JL::makeSafe($data, 'texte');
		?>
		
		<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title parentsolo_mt_40 1"><?php echo $data->titre; ?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
		<div class="texte_explicatif">
			<? echo $data->texte; ?>
		</div>
		<br />
		<?
			if(count($messages)){
				// affichage des messages
				HTML_appel_a_temoins::messages($messages, false);
			}
		?>
	<div class="row">
				<div class="col-md-10 col-md-offset-1 parentsolo_form_style">
					<form action="index.php<?php echo '?'.$langue;?>" name="appel_a_temoins" method="post" enctype="multipart/form-data" class="">
					<h3 class="parentsolo_title_h3 parentsolo_txt_center  parentsolo_pt_15"><?php echo $data->titre; ?></h3>
					<h4 class=" parentsolo_pb_15 parentsolo_pt_15 parentsolo_sub_title"><?php echo $lang_appel_a_temoins["VotreAnnonce"];?></h4>
					<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4">
							<label for="media_id"><?php echo $lang_appel_a_temoins["TypeDeMedia"];?>:</label>
						</div>
						<div class="col-md-8">
							<? echo $list['media_id']; ?>
						</div>
					</div>
					</div>
					<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4">
							<label for="titre"><?php echo $lang_appel_a_temoins["Titre"];?>:*</label>
						</div>
						<div class="col-md-8">
							<input type="text" id="titre" class="msgtxt" required name="titre" maxlength="150" value="<? echo $row->titre; ?>">
						</div>
					</div>
					</div>
					<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4">
							<label for="annonce"><?php echo $lang_appel_a_temoins["Annonce"];?>:*</label>
						</div>
						<div class="col-md-8">
							<textarea name="annonce" id="annonce" required style="width:100%; height: 105px;" ><? echo $row->annonce; ?></textarea>
						</div>
					</div>
					</div>
					<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4">
							<label for="date_limite"><?php echo $lang_appel_a_temoins["DateLimite"];?>:</label>
						</div>
						<div class="col-md-8">
							<input type="text" id="date_limite"  class="msgtxt" name="date_limite" maxlength="50" value="<? echo $row->date_limite; ?>">
						</div>
					</div>
					</div>
					<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4">
							<label for="date_diffusion"><?php echo $lang_appel_a_temoins["DateDePublication"];?>:</label>
						</div>
						<div class="col-md-8">
							<input type="text" id="date_diffusion"  class="msgtxt" name="date_diffusion" maxlength="50" value="<? echo $row->date_diffusion; ?>">
						</div>
					</div>
					</div>
					<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4">
							<label for="file_logo"><?php echo $lang_appel_a_temoins["Logo"];?>:</label>
						</div>
						<div class="col-md-8">
							<input type="file" id="file_logo" name="file_logo" />
							<p><small><?php echo $lang_appel_a_temoins["GifPngJpg"];?></small></p>
						</div>
					</div>
					</div>
					<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12">
							<h4 class=" parentsolo_pb_15 parentsolo_pt_15 parentsolo_sub_title"><?php echo $lang_appel_a_temoins["VosCoordonnees"];?></h4>
						</div>
					</div>
					</div>
					<div class="row bottompadding">
						<div class="col-md-12">
							<div class="col-md-4">
								<label for="nom"><?php echo $lang_appel_a_temoins["Nom"];?>:*</label>
							</div>
							<div class="col-md-8">
								<input type="text" required id="nom" class="msgtxt" name="nom" maxlength="50" pattern="[a-zA-Z][a-zA-Z\s]*" value="<? echo $row->nom; ?>">
							</div>
						</div>
					</div>
					<div class="row bottompadding">
						<div class="col-md-12">
							<div class="col-md-4">
								<label for="prenom"><?php echo $lang_appel_a_temoins["Prenom"];?>:*</label>
							</div>
							<div class="col-md-8">
								<input type="text" required id="prenom" class="msgtxt" name="prenom" maxlength="50" pattern="[a-zA-Z][a-zA-Z\s]*" value="<? echo $row->prenom; ?>">
							</div>
						</div>
					</div>
					<div class="row bottompadding">
						<div class="col-md-12">
							<div class="col-md-4">
								<label for="telephone"><?php echo $lang_appel_a_temoins["Telephone"];?>:*</label>
							</div>
							<div class="col-md-8">
								<input type="text" required id="telephone" class="msgtxt" name="telephone" maxlength="15"  pattern="[0-9]*" value="<? echo $row->telephone; ?>">
							</div>
						</div>
					</div>
					<div class="row bottompadding">
						<div class="col-md-12">
							<div class="col-md-4">
								<label for="adresse"><?php echo $lang_appel_a_temoins["Adresse"];?>:</label>
							</div>
							<div class="col-md-8">
								<textarea name="adresse"  style="width:100%; height: 105px;"><? echo $row->adresse; ?></textarea>
							</div>
						</div>
					</div>
					<div class="row bottompadding">
						<div class="col-md-12">
							<div class="col-md-4">
								<label for="email"><?php echo $lang_appel_a_temoins["Email"];?>:*</label>
							</div>
							<div class="col-md-8">
								<input type="email" required id="email" class="msgtxt" name="email" maxlength="50" value="<? echo $row->email; ?>">
							</div>
						</div>
					</div>
					<div class="row bottompadding">
						<div class="col-md-12">
							<div class="col-md-4">
								<label for="email2"><?php echo $lang_appel_a_temoins["Email"];?>:*<br /><i><?php echo $lang_appel_a_temoins["Confirmation"];?></i></label>
							</div>
							<div class="col-md-8">
								<input type="email" required id="email2" class="msgtxt" name="email2" maxlength="50" value="<? echo $row->email2; ?>">
							</div>
						</div>
					</div>
					<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12">
							<h4 class=" parentsolo_pb_15 parentsolo_pt_15 parentsolo_sub_title"><?php echo $lang_appel_a_temoins["CodeSecurite"];?></h4>
						</div>
					</div>
					</div>
					<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12">
							<u><h5><?php echo $lang_appel_a_temoins["CombienDeFleurs"];?> </h5></u>
						</div>
					</div>
					</div>
					<div class="row bottompadding">
						<div class="col-md-12">
							<div class="col-md-6">
							<?
						for($i=0;$i<$list['captcha'];$i++){
						?>
							<img src="<? echo SITE_URL; ?>/parentsolo/images/flower.png" alt="Fleur" align="left" />
						<?
						}
						?>
							</div>
							<div class="col-md-6">
								: <input type="text" required name="codesecurite" id="codesecurite" value="" maxlength="2" style="width:100px !important;"/>
							</div>
						</div>
					</div>
					<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12 parentsolo_txt_center parentsolo_mt_20">
							<a href="javascript:if(confirm('<?php echo $lang_appel_a_temoins["AnnulerAppelConfirm"];?>')){document.location='<? echo JL::url('index.php?app=appel_a_temoins&action=list&'.$langue); ?>';}" class="bouton annuler  parentsolo_btn"><?php echo $lang_appel_a_temoins["Annuler"];?></a>
							<!--<a href="javascript:document.appel_a_temoins.submit();" class="bouton envoyer parentsolo_btn"><?php echo $lang_appel_a_temoins["Envoyer"];?></a>-->
							<input type="submit" value="<?php echo $lang_appel_a_temoins["Envoyer"];?>" class="bouton envoyer parentsolo_btn">

							<input type="hidden" name="app" value="appel_a_temoins" />
							<input type="hidden" name="action" value="save" />	
						</div>
					</div>
				</div>
					
				</div>
	</div>
	
			
			</form>
					
		<?
		}


		// affichage d'un appel &agrave; t&eacute;moins
		public static function appel_a_temoinsRead(&$row) {
			global $langue,$template;
			include("lang/app_appel_a_temoins.".$_GET['lang'].".php");

			JL::makeSafe($row);

			$photo = SITE_URL.'/images/appel-a-temoins/'.$row->id.'.jpg';

			// photo par d&eacute;faut
			if(!is_file(SITE_PATH.'/images/appel-a-temoins/'.$row->id.'.jpg')) {
				$photo = $template.'/images/box/3-'.$_GET['lang'].'.jpg';
			}
		?>
			
			<!-- Partie Droite -->
			<div class="content">
				<div class="contentl">
					<div class="colc">
						<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title parentsolo_mt_40"><?php echo $row->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
						<p>
							<div class="temoignage">
									<img style="float:left;margin:0 10px 10px 0;"width="90" src="<? echo $photo; ?>" alt="<?php echo $row->titre;?>" /> <? echo  nl2br(htmlspecialchars_decode($row->annonce)); ?>
									<div class="clear"></div>
									<br />
									<div class="publication">
										<b><?php echo $lang_appel_a_temoins["InformationComplementaires"];?>:</b><br />
										<br />
										<? if($row->date_limite) { ?><b><?php echo $lang_appel_a_temoins["DateDeLappel"];?>:</b> <? echo date('d/m/Y', strtotime($row->date_add)); ?><br /><? } ?>
										<? if($row->date_limite) { ?><b><?php echo $lang_appel_a_temoins["DateLimiteInscription"];?>:</b> <? echo $row->date_limite; ?><br /><? } ?>
										<? if($row->date_diffusion) { ?><b><?php echo $lang_appel_a_temoins["DateDiffusion"];?>:</b> <? echo $row->date_diffusion; ?><br /><? } ?>
										<br />

										<b><?php echo $lang_appel_a_temoins["PourPlusDInformations"];?>:</b><br />
										<br />
										<? echo $row->prenom.' '.$row->nom; ?><br />
										<? if($row->adresse) nl2br($row->adresse).'<br />'; ?>
										<br />
										<b><?php echo $lang_appel_a_temoins["Email"];?>:</b> <a href="mailto:<? echo $row->email; ?>" title="Contacter <? echo $row->prenom.' '.$row->nom; ?> par email"><? echo $row->email; ?></a><br />
										<b><?php echo $lang_appel_a_temoins["Telephone"];?>:</b> <? echo $row->telephone; ?>
									</div>
							</div>
						</p>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<!--<div class="colr"> 
				<?
				//	JL::loadMod('menu_right');
				?>
				</div>-->
				<div style="clear:both"> </div>
			</div>
		<?
		}


		// page d'info
		public static function appel_a_temoinsInfo(&$row) {
			global $langue;
			include("lang/app_appel_a_temoins.".$_GET['lang'].".php");

			// htmlentities
			JL::makeSafe($row, 'texte');

			?>
			<div class="content">
				<div class="contentl">
					<div class="colc">
						<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title parentsolo_mt_40"><? echo $row->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
						<div class="texte_explicatif">
							<? echo  $row->texte; ?>
						</div>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<!--<div class="colr"> 
				<?
					// JL::loadMod('menu_right');
				?>
				</div> -->
				<div style="clear:both"> </div>
			</div>
			<?
		}

	}
?>

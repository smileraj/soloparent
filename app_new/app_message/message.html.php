<?php

	// sécurité
	defined('JL') or die('Error 401');

	class HTML_message {

		// affichage des messages système
		public static function messages(&$messages) {
			global $langue;
			include("lang/app_message.".$_GET['lang'].".php");

			// s'il y a des messages à afficher
			if(count($messages)) {
			?>
				<h2><?php echo $lang_message["MessagesParentsolo"];?></h2>
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
		
		// menu en haut avec les steps
		public static function message_titre() {
			global $langue;
			include("lang/app_message.".$_GET['lang'].".php");
			global $user, $action;
				
				
				// détermine le texte du h1
				switch($action) {

					case 'inbox':
						$h1 = $lang_message["BoiteReception"];
					break;
					
					case 'flowers':
						$h1 = $lang_message["BoiteReception"];
					break;
					
					case 'sent':
						$h1 = $lang_message["Envois"];
					break;
					
					case 'archive':
						$h1 = $lang_message["Archives"];
					break;
					
					case 'trash':
						$h1 = $lang_message["Corbeille"];
					break;
					
					

				}
			?>
				
				<div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre "><? echo $h1; ?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
			<?
					// affiche les messages
					JL::messages($messages);
				?>
			<?

		}

		// affiche la liste de $messages du dossier $dossier_id
		public static function messageList(&$userMessages, $dossier_id, &$messages, &$search) {
			global $langue;
			include("lang/app_message.".$_GET['lang'].".php");
			global $action;

			// variables
			$dossierTitre 	= '';
			$rayon			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];

			

		
			// affichage des messages
			HTML_message::messages($messages);
			
			HTML_message::message_titre();
				
		?>
			<form action="index.php<?php '?'.$langue;?>" name="messageList" method="post">
				<input type="hidden" name="app" value="message" />
				<input type="hidden" name="action" value="" />
<div class="row parentsolo_mt_20 text-center">
			
					<?
						// liste les messages
						if(is_array($userMessages) && count($userMessages)) {
							
							foreach($userMessages as $message) {

								// htmlentities
								JL::makeSafe($message);

								if($message->genre) {

									// récup la photo par défaut de l'utilisateur
									$photo = JL::userGetPhoto($message->user_id, '89', 'profil', $message->photo_defaut);

									// pas de photo par défaut
									if(!$photo) {
										$photo = SITE_URL.'/parentsolo/images/parent-solo-89-'.$message->genre.'-'.$_GET['lang'].'.jpg';
									}

								} else {

									$photo = SITE_URL.'/parentsolo/images/parent-solo-89-'.$_GET['lang'].'.jpg';

								}
								
								
							?>
								<div class="col-md-12 parentsolo_pb_10 parentsolo_pt_10 odd_even_cls <? if($message->non_lu) { ?>non_lu<? }?>">
				<div class="col-md-3 parentsolo_plr_0">
					<div class="col-md-3 parentsolo_plr_0">
					<? 
									if($message->fleur_id) {
							?>
											<img src="<? echo SITE_URL; ?>/parentsolo/images/btn_rose.png" alt="Fleur" align="center" />
							<? 
									}else{ 
							?>
										<img src="<? echo SITE_URL; ?>/parentsolo/images/btn_message.png" alt="Fleur" align="center" />
							<?
									}
							?>
					</div>
					<div class="col-md-9 parentsolo_plr_0">
					<a href="<? echo JL::url(SITE_URL.'/index.php?app=message&action=read&id='.$message->id).'&'.$langue; ?>" title="<?php echo $lang_message["LireCeMessage"];?>"><img src="<? echo $photo; ?>" alt="<? echo $message->username; ?>" class="parentsolo_border_radius"/></a>
					</div>
				</div>
				<div class="col-md-6 parentsolo_plr_0">
					<div class="col-md-6 parentsolo_inbox_usr">
					<a class="parentsolo_text_header_stl" href="<? echo JL::url(SITE_URL.'/index.php?app=message&action=read&id='.$message->id).'&'.$langue; ?>" title="<?php echo $lang_message["LireCeMessage"];?>"><? echo $message->username; ?></a>
					<br />
									<span class="detail parentsolo_details">
										<? echo $message->age.' '.$lang_message["Ans"]; ?> - <? echo $message->nb_enfants; ?> <? echo $message->nb_enfants > 1 ? $lang_message["enfants"] : $lang_message["enfant"]; ?> - <? echo $message->canton_abrev; ?>
									</span>
					</div>
					<div class="col-md-6 parentsolo_plr_0">
					<a class="parentsolo_text_header_stl" href="<? echo JL::url(SITE_URL.'/index.php?app=message&action=read&id='.$message->id).'&'.$langue; ?>" title="<?php echo $lang_message["LireCeMessage"];?>"><? echo $message->titre; ?></a>
					
					</div>
				</div>
				<div class="col-md-3 text-right parentsolo_plr_0">
					<span class="parentsolo_details"><strong><? echo date('d.M.Y', strtotime($message->date_envoi)); ?> <? echo date('H:i', strtotime($message->date_envoi)); ?></strong></span>
					<span class="parentsolo_details"> &nbsp;<? 
										if($message->m_read == 0){
											echo '<img src="'.SITE_URL.'/parentsolo/images/msg-valid.png"/>';
										}elseif($message->m_read == 1){
											echo '<img src="'.SITE_URL.'/parentsolo/images/msg-error.png"/>';
										}
									?></span>
				</div>
				
				
				</div>

				
							
							<?
							}
							?>
							
						<?
							if($action=="sent"){
						?>
								<div class="row ">
									<div class="col-md-4 col-md-offset-4 parentsolo_form_style parentsolo_mt_20 parentsolo_mb_20 parentsolo_pt_10 parentsolo_pb_10">
										<div class="col-md-6 text-left"><img src="<? echo SITE_URL; ?>/parentsolo/images/msg-valid.png"/> <? echo $lang_message["Lu"]; ?>
										</div>
										<div class="col-md-6 text-left"><img src="<? echo SITE_URL; ?>/parentsolo/images/msg-error.png"/> <? echo $lang_message["NonLu"]; ?>
										</div>
									</div>
								</div>
								
						<?
							}
						?>
							<tr>
								<td colspan="6">
								
									<? // emails supprimés
									if($action == 'trash') {
									?>
									<center><a href="javascript:if(confirm('<?php echo $lang_message["ConfirmationViderCorbeille"];?>')){document.location.href='<? echo SITE_URL;?>/index.php?app=message&action=emptytrash&<? echo $langue; ?>'}" class="bouton annuler"><?php echo $lang_message["ViderLaCorbeille"];?></a></center>
									<? } ?>
									<div class="toolbarsteps">
									
											<div class="col-md-3 ">
												<? // page précédente
												if($search['page'] > 1) { ?>
													<a href="<? echo JL::url(SITE_URL.'/index.php?app=message&action='.$action.'&page='.($search['page']-1)).'&'.$langue; ?>" class="bouton envoyer" title="<?php echo $lang_message["PagePrecedente"];?>">&laquo; <?php echo $lang_message["PagePrecedente"];?></a>
												<? } ?>
											</div>
											<div class="col-md-6 text-center">
												<b><?php echo $search['page'] == 1 ? $lang_message["Page"] : $lang_message["Pages"];?></b>:
												<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL.'/index.php?app=message&action='.$action.'&page=1').'&'.$langue; ?>" title="<?php echo $lang_message["Debut"];?>"><?php echo $lang_message["Debut"];?></a> ...<? }?>
												<?
													for($i=$debut; $i<=$fin; $i++) {
													?>
														 <a href="<? echo JL::url(SITE_URL.'/index.php?app=message&action='.$action.'&page='.$i).'&'.$langue; ?>" title="<?php echo $lang_message["Page"];?> <? echo $i; ?>" <? if($i == $search['page']) { ?>class="active"<? } ?>><? echo $i; ?></a>
													<?
													}
												?>
												<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL.'/index.php?app=message&action='.$action.'&page='.$search['page_total']).'&'.$langue; ?>" title="<?php echo $lang_message["Fin"];?>"><?php echo $lang_message["Fin"];?></a><? }?> <i>(<? echo $search['result_total'] > 1 ?  $search['result_total'].' '.$lang_message["messages"] : $search['result_total'].' '.$lang_message["message"]; ?>)</i>
											</div>
											<div class="col-md-3 ">
												<? // page suivante
												if($search['page'] < $search['page_total']) { ?>
													<a href="<? echo JL::url(SITE_URL.'/index.php?app=message&action='.$action.'&page='.($search['page']+1)).'&'.$langue; ?>" class="bouton envoyer" title="<?php echo $lang_message["PageSuivante"];?>"><?php echo $lang_message["PageSuivante"];?> &raquo;</a>
												<? } ?>
											</div>
									
									</div>
								</td>
							</tr>
						<?
						} else {
						?>
							<tr>
								<td align="middle">
								<?
									switch($action) {

										case 'inbox':
											$dossier_vide = $lang_message["BoiteReceptionVide"];
										break;
										
										case 'flowers':
											$dossier_vide = $lang_message["BoiteReceptionRosesVide"];
										break;
										
										case 'sent':
											$dossier_vide = $lang_message["BoiteEnvoiVide"];
										break;
										
										case 'archive':
											$dossier_vide = $lang_message["AucunMailArchive"];
										break;
										
										case 'trash':
											$dossier_vide = $lang_message["CorbeilleVide"];
										break;
										
										

									}
								?>
									<?php echo $dossier_vide;?>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						<?
						}
					?>
				</div>

			</form>
		<?
		}


		public static function messageRead($message) {
			global $langue;
			include("lang/app_message.".$_GET['lang'].".php");
			global $user;

			// variables
			$envoi_type = $message->fleur_id ? $lang_message["Rose"] : $lang_message["Mail"];

			


			// récup la photo de l'utilisateur
			$photo = JL::userGetPhoto($message->user_id, '109', 'profil', $message->photo_defaut);

			// photo par défaut
			if(!$photo) {
				if($message->genre) {
					$photo = SITE_URL.'/parentsolo/images/parent-solo-109-'.$message->genre.'-'.$_GET['lang'].'.jpg';
				} else {
					$photo = SITE_URL.'/parentsolo/images/parent-solo-109-'.$_GET['lang'].'.jpg';
				}
			}

			// lien vers le profil de l'expéditeur
			if($message->user_id == 1) {
				$profilLink = '';
			} else {
				$profilLink = "".JL::url('index.php?app=profil&action=view&id='.$message->user_id.'&lang='.$_GET['lang'])." ";
			}

			
		
			// affichage des messages
			HTML_message::messages($messages);
		?>
		<h3 class="loginprofile_title_h3 parentsolo_mt_20 parentsolo_pb_15"><? echo $message->titre; ?></h3>
							
			<form action="index.php<?php '?lang='.$_GET['lang'];?>" name="message" method="post">

				<div class="row">
					<div class="col-md-12">
						<div class="col-md-2 parentsolo_plr_0">
							<? if($profilLink){ ?>
									<a href="<? echo $profilLink; ?>" title="<? echo$lang_message["VoirCeProfil"];?>" class="photo"><img class="img-circle " src="<? echo $photo; ?>" alt="<? echo $message->username; ?>" /></a>
							<? }else{ ?>
									<img src="<? echo $photo; ?>" alt="<? echo $message->username; ?>" class="img-circle " />
							<? } ?>
						</div>
						<div class="col-md-10 parentsolo_plr_0">
<div class="col-md-12 parentsolo_plr_0 parentsolo_pb_15 text-right">
								<? // si droit de manipuler ce message
							if($message->owner == 1) { ?>
								<a href="<? echo JL::url(SITE_URL.'/index.php?app=message&action=reply&id='.$message->id).'&'.$langue; ?>" class="bouton envoyer a_link_icon" title="<?php echo $lang_message["Repondre"];?>"><i class="fa fa-reply"></i></a>
								
								<? // message archivé
								if($message->dossier_id == 2) { ?>

									<a href="<? echo JL::url(SITE_URL.'/index.php?app=message&action=restore&id[]='.$message->id).'&'.$langue; ?>" class="bouton annuler a_link_icon" title="<?php echo $lang_message["Restaurer"];?>"><i class="fa fa-retweet"></i></a>

								<? } else { ?>

									<a href="<? echo JL::url(SITE_URL.'/index.php?app=message&action=backup&id[]='.$message->id).'&'.$langue; ?>" class="bouton annuler a_link_icon" title="<?php echo $lang_message["Archiver"];?>"><i class="fa fa-archive"></i></a>

								<? } ?>
								
								
								<? // message supprimé
								if($message->dossier_id == 1) { ?>

									<a href="<? echo JL::url(SITE_URL.'/index.php?app=message&action=restore&id[]='.$message->id).'&'.$langue; ?>" class="bouton envoyer a_link_icon" title="<?php echo $lang_message["Restaurer"];?>"><i class="fa fa-retweet"></i></a>

								<? } else { ?>
									<a href="<? echo JL::url(SITE_URL.'/index.php?app=message&action=delete&id[]='.$message->id).'&'.$langue; ?>" class="bouton envoyer a_link_icon" title="<?php echo $lang_message["Supprimer"];?>"><i class="fa fa-trash-o"></i></a>

								<? } ?>

							<? } ?>
							</div>
							<div class="col-md-12 parentsolo_plr_0">
								<div class="col-md-9 parentsolo_plr_0">
								<i><?php echo $message->owner ? $lang_message["De"] : $lang_message["Pour"];?> <b><? if($profilLink){ ?><a href="<? echo $profilLink; ?>" title="<?php  echo $lang_message["VoirCeProfil"]; ?>"><? echo $message->username; ?></a><? }else{ echo $message->username; } ?></b><br />
								<span class="parentsolo_details"><?php echo $lang_message["Le"];?> <? echo date('d/m/Y', strtotime($message->date_envoi)); ?> <?php echo $lang_message["A"];?> <? echo date('H:i:s', strtotime($message->date_envoi)); ?></i>
							</span>
								</div>
						
						<div class="col-md-3 parentsolo_plr_0 text-right">
						
						<span class="parentsolo_details"><strong><? echo date('d-M', strtotime($message->date_envoi)); ?></strong></span>
						</div>
							</div>
						
					</div>
						</div>
					
						<?
						// si c'est une rose
						if($message->fleur_id) {
						?><div class="col-md-12 parentsolo_mt_20 parentsolo_pt_15 border-top-inbox">
						<div class="col-md-7 parentsolo_plr_0">
							<b><? echo $message->fleur_nom; ?></b><br />
							<? echo $message->fleur_signification; ?>
						</div>
						<div class="col-md-5 parentsolo_plr_0 text-right">
							<img src="images/fleur/<? echo $message->fleur_id; ?>.png" alt="<? echo $message->fleur_nom; ?>" />
						</div>
						</div>
						<?
						} 
						?>
					
					<div class="col-md-12 parentsolo_mt_20 parentsolo_pt_15 border-top-inbox">
						<? echo nl2br($message->texte); ?>
					</div>
				</div>
				
					
						

				<input type="hidden" name="app" value="message" />
				<input type="hidden" name="action" value="reply" />
				<input type="hidden" name="id" value="<? echo $message->id; ?>" />
			</form>
					
	<? 

		}
		
		
		
		
		


		/*
			formulaire de rédaction de message
			$flower = afficher les propositions de roses oui/non
		*/
		public static function messageWrite(&$message, $flower, $messages, &$fleurs) {
			global $langue;
			include("lang/app_message.".$_GET['lang'].".php");

			// variables
			$envoi_type = $flower ? $lang_message["EnvoyerUneRose"] : $lang_message["EnvoyerUnMail"];

			// couleurs des roses, dans l'ordre: background, foreground
			$couleurs	= array(
				'#FF0F02', 	// "Rose Rouge"
				'#E56F61', 	// "Rose Corail"
				'#FFFFFF', 	// "Rose Blanche"
				'#19A3E4', 	// "Rose Bleue"
				'#657CC0', 	// "Rose Lavande"
				'#FFEE02', 	// "Rose Jaune"
				'#FE6500', 	// "Rose Orange"
				'#CF0072', 	// "Rose Rose"
				'#000000',	// "Rose Noire"
			);
			// htmlentities
			JL::makeSafe($message);

					
			// affichage des messages
			HTML_message::messages($messages);

		?>
		<form action="index.php<?php echo '?'.$langue;?>" name="message" method="post">
		
				
				<div class="row">
					<div class="col-md-10 col-md-offset-1 parentsolo_form_style">
					
					<div class="parentsolo_txt_center"><h3 class="parentsolo_title_h3 parentsolo_txt_center  parentsolo_pt_15"><? echo $envoi_type; ?></h3>
						<div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div></div>
						<? if($flower) { ?> 
						<?
						// parcourt le tableau de roses
						if(is_array($fleurs)) {
						?>
							<div class="row" >
						<?
							$i = 0;
							foreach($fleurs as $fleur) {
								// hmtlentities
								JL::makeSafe($fleur,'signification');
								if($i==5){
								?>
									<!--<div class="row1 bottompadding parentsolo_mt_20">-->
								<?
									}
								?>
										
						<div class="col-md-4 col-lg-4 col-sm-4 col-xs-6">
						<div class="col-md-12">
							<label for="fleur_id_<? echo $fleur->id; ?>" id="label_fleur_id_<? echo $fleur->id; ?>" title="<? echo $fleur->signification; ?>"><img src="images/fleur/<? echo $fleur->id; ?>.png" style="width:100px;" alt="<? echo $fleur->nom; ?>" onClick="fleur('<? echo $fleur->id; ?>', '<? echo addslashes($fleur->nom); ?>', '<? echo $couleurs[$i]; ?>');"></label>
						</div>
						<div class="col-md-12" style="display:flex;">
							<input type="radio" name="fleur_id" id="fleur_id_<? echo $fleur->id; ?>" value="<? echo $fleur->id; ?>" onClick="fleur('<? echo $fleur->id; ?>', '<? echo addslashes($fleur->nom); ?>', '<? echo $couleurs[$i]; ?>');" style="width:20px;" /><label for="fleur_id_<? echo $fleur->id; ?>" onClick="fleur('<? echo $fleur->id; ?>', '<? echo addslashes($fleur->nom); ?>', '<? echo $couleurs[$i]; ?>');"><? echo $fleur->nom; ?></label>
										</div></div>
										
								<?
										$i++;
								if($i==5 || $i==9){
								?>
									<!--</div >-->
								<?
								}
							}
						?>
							</div>
						<?
						}

					?>
						<br>
						<div class="row bottompadding parentsolo_mt_40">
						<div class="col-md-4">
							<label for="signification"><?php echo $lang_message["Signification"];?>:</label>
						</div><style>
						#signification{    border-radius: 5px;
						}
						#signification img{
						margin-right: 5px;
						margin-top: -50px;
						float: left;
						margin-left: -26px;
						width:90px !important;
						}</style>
						<div class="col-md-8" >
						<div id="signification" style="    padding: 5px;  border: solid 1px #d8dee0;  background: #fff;">
							<b><?php echo $lang_message["CliquezSurUneRose"];?></b></div>
						</div></div>
						<? } ?>
						<div class="row bottompadding parentsolo_mt_20">
						<div class="col-md-4">
							<label for="user_to"><?php echo $lang_message["Destinataire"];?>:</label>
						</div>
						<div class="col-md-8">
							<b><? echo $message->user_to; ?></b>
						</div></div>
						<div class="row bottompadding">
							<div class="col-md-4">
							<label for="titre"><?php echo $lang_message["Titre"];?>:</label>
						</div>
						<div class="col-md-8">
							<input type="text" id="titre" name="titre" maxlength="255" value="<? echo $message->titre; ?>" >
						</div>
						</div>
						<div class="row bottompadding">
							<div class="col-md-4">
							<label for="texte"><?php echo $lang_message["Texte"];?>:</label>
						</div>
						
							<div class="col-md-8">
							<textarea name="texte" id="texte" style="width:100%; height: 155px;"><? echo $message->texte; ?></textarea>
						</div>
						</div>
						<div class="row bottompadding parentsolo_mt_20">
							<div class="col-md-12">
							<?php echo $lang_message["AttentionAssurezVousDeBien"];?>.
						</div>
						</div>
						<div class="row bottompadding text-center parentsolo_mt_20">
							<div class="col-md-12">
							<a href="javascript:if(confirm('<?php echo $lang_message["ConfirmationAnnulation"];?>')){window.history.go(-1);}" class="bouton annuler parentsolo_btn"><?php echo $lang_message["Annuler"];?></a>
							<a href="javascript:document.message.submit();" class="bouton envoyer parentsolo_btn"><?php echo $lang_message["Envoyer"];?></a>
						</div>
						<input type="hidden" name="app" value="message" />
			<input type="hidden" name="action" value="<? echo $flower ? 'sendflower' : 'send'; ?>" />
			<input type="hidden" name="user_to" value="<? echo $message->user_to; ?>" />
						</div>
					</div>
				</div>
			
			
			
		</form>
		<?
		}

	}
?>

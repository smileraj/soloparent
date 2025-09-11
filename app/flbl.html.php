<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	class HTML_flbl {


		// affichage des messages syst&egrave;me
		function messages(&$messages) {
			global $langue;

			include("lang/app_flbl.".$_GET['lang'].".php");
			// s'il y a des messages &agrave; afficher
			if(count($messages)) {
			?>
				<h2><?php echo $lang_flbl["MessagesParentsolo"];?></h2>
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


		// titre
		function flbl_titre($list_type) {
			global $langue;
			include("lang/app_flbl.".$_GET['lang'].".php");
			global $user, $action;
				
				
				// d&eacute;termine le texte du h1
				switch($list_type) {

					case '1':
						$h1 = $lang_flbl["Favoris"];
					break;
					
					case '0':
						$h1 = $lang_flbl["ListeNoire"];
					break;
				
				}
			?>
				<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><? echo $h1; ?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
				
			<?
			/*<h3 class="result"><? echo $h1; ?></h3>}*/

		}

		// affiche la liste d'utilisateurs
		function flblList(&$rows, &$messages, $list_type) {
			global $langue;
			include("lang/app_flbl.".$_GET['lang'].".php");

			
						
			// affichage des messages
			HTML_flbl::messages($messages);
			
			// menu steps
			HTML_flbl::flbl_titre($list_type);
		?>
		<table class="result1" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td>
					<table class="previews_liste" cellpadding="0" cellspacing="0" width="100%">
			<?
			
						$nb_rows		= count($rows);
				
						$i = 1;
						// liste les profils
						if(is_array($rows) && $nb_rows) {

							foreach($rows as $row) {
								
								// limitation de la longueur de l'intro
								$row->description = strip_tags(html_entity_decode($row->description));
								if(strlen($row->description) > LISTE_INTRO_CHAR) {
									$row->description = substr($row->description, 0, LISTE_INTRO_CHAR).'...';
								}
								
								JL::makeSafe($row, 'description');
								
								// r&eacute;cup la photo de l'utilisateur
								$photo_liste = JL::userGetPhoto($row->id, 'profil', '', $row->photo_defaut);

								if(!$photo_liste) {
									$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$row->genre.'-'.$_GET['lang'].'.jpg';
								}
								
								if($row->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $row->online) { // 30 minutes (60*30)

									$last_online_class 		= 'lo_online';
									$last_online_label		= $lang_flbl["EnLigne"];

								} else{ // aujourd'hui (60*60*24)

									$last_online_class 	= 'lo_offline';
									$last_online_label	= $lang_flbl["HorsLigne"];

								}
								
								if($i%2 == 1){ echo '<tr>';}
								
								?>
								<td class="preview_liste">
								<div class="actions">
									<?
										if($list_type){
									?>
											<a href="<? echo JL::url('index.php?app=profil&action=view&id='.$row->id.'&lang='.$_GET['lang']); ?>"  title="<? echo $lang_flbl["VoirCeProfil"]; ?>"><img src="<? echo $photo_liste; ?>" alt="<? echo $row->username; ?>" class="profil"/></a>
											<br />
											<a href="<? echo JL::url('index.php?app=message&action=write&user_to='.$row->username.'&'.$langue); ?>" title="<?php echo $lang_flbl["EnvoyerUnMail"];?>"><img src="<? echo SITE_URL; ?>/<? echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_flbl["EnvoyerUnMail"];?>" /></a>
											<a href="<? echo JL::url('index.php?app=message&action=flower&user_to='.$row->username.'&'.$langue); ?>" title="<?php echo $lang_flbl["EnvoyerUneRose"];?>" ><img src="<? echo SITE_URL; ?>/<? echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_flbl["EnvoyerUneRose"];?>" /></a>
											<a href="javascript:windowOpen('ParentSoloChat','<? echo JL::url('index.php?app=chat&id='.$row->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_flbl["Chat"];?>"><img src="<? echo SITE_URL; ?>/<? echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_flbl["Chat"];?>" /></a>
											<br />
											<a href="<? echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_flbl["AjouterAuxFavoris"];?>" ><img src="<? echo SITE_URL; ?>/<? echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_flbl["AjouterAuxFavoris"];?>" /></a>
											<a href="<? echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_flbl["AjouterALaListeNoire"];?>" ><img src="<? echo SITE_URL; ?>/<? echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_flbl["AjouterALaListeNoire"];?>" /></a>
											<a href="<? echo JL::url('index.php?app=signaler_abus&user_id_to='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_flbl["SignalerUnAbus"];?>" ><img src="<? echo SITE_URL; ?>/<? echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_flbl["SignalerUnAbus"];?>" /></a>
									<?
										}else{
									?>
											<img src="<? echo $photo_liste; ?>" alt="<? echo $row->username; ?>" class="profil"/>
									<?
										}
									?>
								</div>
								<div class="infos"><? echo $row->age; ?> <?php echo $lang_flbl["ans"];?> - <? echo $row->nb_enfants; ?> <? echo $row->nb_enfants > 1 ? $lang_flbl["enfants"] : $lang_flbl["enfant"]; ?> - <? echo $row->canton_abrev; ?> <? if($list_type){ ?><div class="connect"><span class="<? echo $last_online_class; ?>"><? echo $last_online_label; ?></span></div><? } ?></div>
								<div class="description">
									<? echo $row->description; ?>
								</div>
								<div class="supplement">
									<a href="<? echo JL::url('index.php?app=flbl&action=add&list_type='.$list_type.'&user_id_to='.$row->id.'&'.$langue); ?>" title="<? echo $lang_flbl["ModifierLeCommentaire"];?>"><? echo $lang_flbl["ModifierLeCommentaire"];?></a><br />
									<b><?php echo $lang_flbl["AjouteLe"];?></b> <? echo date('d/m/Y', strtotime($row->datetime_add)); ?> <div class="suppr"><a href="javascript:if(confirm('<?php echo $list_type == 1 ? $lang_flbl["ConfirmationRetraitFavoris"] : $lang_flbl["ConfirmationRetraitListeNoire"] ; ?> ?')){document.location='<? echo JL::url('index.php?app=flbl&action=remove&list_type='.$list_type.'&id='.$row->id.'&'.$langue); ?>';}" title="<?php echo $list_type == 1 ? $lang_flbl["RetraitFavoris"] : $lang_flbl["RetraitListeNoire"] ; ?>"><img src="<? echo SITE_URL.'/images/non.gif'; ?>" alt="<?php echo $list_type == 1 ? $lang_flbl["RetraitFavoris"] : $lang_flbl["RetraitListeNoire"] ; ?>" /></a></div>
								</div>
								<div style="clear:both"> </div>
								<div class="username">
									<?
										if($list_type){
									?>
											<a href="<? echo JL::url('index.php?app=profil&action=view&id='.$row->id.'&lang='.$_GET['lang']); ?>"  title="<? echo $lang_flbl["VoirCeProfil"];?>" class="username"><? echo $row->username; ?></a>
									<?
										}else{
											
											echo $row->username;
											
										}
									?>
								</div>
							</td>
						<?
							
							if($i%2 == 0){echo "</tr>"; }
							
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
									<?php echo $lang_flbl["ListeVide"];?>!
								</td>
							</tr>
					<?
						}
					?>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
				
		<?

		}


		// ajout/&eacute;dition
		function flblAdd(&$row, &$messages) {
			global $langue;
			include("lang/app_flbl.".$_GET['lang'].".php");

			// htmlent
			JL::makeSafe($row);

			// r&eacute;cup la photo de l'utilisateur
			$photo = JL::userGetPhoto($row->user_id_to, '89', 'profil', $row->photo_defaut);

			// photo par d&eacute;faut
			if(!$photo) {
				$photo = SITE_URL.'/parentsolo/images/parent-solo-89-'.$row->genre.'-'.$_GET['lang'].'.jpg';
			}

		
			// affichage des messages
			HTML_flbl::messages($messages);
		
		?>
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title parentsolo_mt_40"><? echo $row->username; ?><? if(!$row->list_type){ echo " (".$lang_flbl["ListeNoire"].")"; }else{ echo " (".$lang_flbl["Favoris"].")"; }; ?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<form action="index.php<?php echo '?'.$langue;?>" name="flbl" method="post">
				<table class="table_form" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td class="photo">
							<img src="<? echo $photo; ?>" alt="<? echo $row->username; ?>" />
						</td>
						<td valign="top">
							<? echo $row->age; ?> <?php echo $lang_flbl["ans"];?> - <? echo $row->nb_enfants; ?> <? echo $row->nb_enfants > 1 ? $lang_flbl["enfants"] : $lang_flbl["enfant"]; ?> - <? echo $row->canton; ?>
						</td>
					<tr>
						<td class="key" valign="top">
							<label for="description"><?php echo $lang_flbl["Commentaire"];?>:</label>
						</td>
						<td valign="top">
							
							<textarea name="description" id="description" ><? echo $row->description ?></textarea>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<p class="flbl_notice">
								<?php echo $lang_flbl["AjouterUnCommentaire"]; ?>.
							</p>
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="right">
							<a href="<? echo JL::url('index.php?app=flbl&action=list&list_type='.$row->list_type.'&'.$langue); ?>" class="bouton annuler  parentsolo_btn"><?php echo $lang_flbl["Annuler"];?></a>
							<a href="javascript:document.flbl.submit();" class="bouton envoyer parentsolo_btn"><?php echo $lang_flbl["Valider"];?></a>
						</td>
					</tr>
				</table>
				<input type="hidden" name="app" value="flbl" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="user_id_to" value="<? echo $row->user_id_to; ?>" />
				<input type="hidden" name="list_type" value="<? echo $row->list_type; ?>" />
			</form>
				
	<?
		}
	}
?>

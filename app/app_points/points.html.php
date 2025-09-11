<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	class HTML_points {

		


		/*// affiche la liste des t&eacute;moignages
		function pointsTemoignages(&$rows) {
			global $langue;
			include("lang/app_points.".$_GET['lang'].".php");

			?>
			<div class="app_body">
			<?

				//affichage du menu
				HTML_points::pointsMenu();

				?>
				<h1 class="points"><?php echo $lang_points["TemoignageDeGagnants"];?></h1>
				<p class="pointsP">
					<?php echo $lang_points["DecouvrezLesChoix"];?> !
				</p>

				<?
				if(is_array($rows) && count($rows)) {
					foreach($rows as $row) {

						// limitation de la description
						$temoignageLimite	= 550;
						if(strlen($row->temoignage) > $temoignageLimite) {
							$row->temoignage = substr($row->temoignage, 0, $temoignageLimite).'...';
						}

						// r&eacute;cup la photo de l'utilisateur
						$photo 				= JL::userGetPhoto($row->user_id, '109', 'profil', $row->photo_defaut);

						// photo par d&eacute;faut
						if(!$photo) {
							$photo 			= SITE_URL.'/parentsolo/images/parent-solo-109-'.$row->genre.'.jpg';
						}

						// html entities
						JL::makeSafe($row);

						?>
						<div class="pointsTemoignage">
							<a href="<? echo JL::url('index.php?app=points&action=temoignage&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_points["LireTemComplet"];?> <? echo $row->username; ?>" class="titre"><?php echo $lang_points["TemDe"];?> <? echo $row->username; ?></a>
							<p><? echo $row->temoignage; ?></p>
							<a href="<? echo JL::url('index.php?app=profil&action=view&id='.$row->user_id.'&'.$langue); ?>" title="<?php echo $lang_points["VoirProfParSuisse"];?> <? echo $row->username; ?>" class="aPhoto"><img src="<? echo $photo; ?>" alt="<? echo $row->username; ?>" /><span><? echo $row->username; ?></span></a>
							<a href="<? echo JL::url('index.php?app=points&action=temoignage&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_points["LireTemComplet"];?> <? echo $row->username; ?>" class="btnNoirRose"><?php echo $lang_points["LireSuite"];?></a>
						</div>
					<?
					}

				} else {
				?>
					<?php echo $lang_points["AucunTemoignage"];?>.
				<?
				}
			?>
			</div><? // fin app_body ?>
			<?

			// colonne de gauche
			JL::loadMod('profil_panel');

		?>
		<div class="clear"> </div>
		<?
		}


		// affiche un t&eacute;moignage
		function pointsTemoignage(&$row) {
			global $langue;

			// r&eacute;cup la photo de l'utilisateur
			$photo 				= JL::userGetPhoto($row->user_id, '109', 'profil', $row->photo_defaut);

			// photo par d&eacute;faut
			if(!$photo) {
				$photo 			= SITE_URL.'/parentsolo/images/parent-solo-109-'.$row->genre.'.jpg';
			}

			// html entities
			JL::makeSafe($row);

			?>
			<div class="app_body">
				<?

					//affichage du menu
					HTML_points::pointsMenu();

				?>

				<div class="contenu">
					<h1><?php echo $lang_points["TemoignageConcours"];?></h1>
					<img src="<? echo $photo; ?>" alt="<? echo $row->username; ?>" class="ptsTemoignage" /><? echo nl2br($row->temoignage); ?><br />
					<br />
					<?php echo $lang_points["TemoignageRedige"];?> <a href="<? echo JL::url('index.php?app=profil&action=view&id='.$row->user_id.'&'.$langue); ?>" title="<?php echo $lang_points["VoirProfParSuisse"];?> <? echo $row->username; ?>"><? echo $row->username; ?></a> <?php echo $lang_points["Le"]?> <? echo date('d/m/Y', strtotime($row->temoignage_date)); ?>.

					<a href="<? echo JL::url('index.php?app=points&action=temoignages'.'&'.$langue); ?>" class="bouton return_home" title="<?php echo $lang_points["RetListeTem"];?>"><?php echo $lang_points["RetourALaListe"];?></a>

					<div class="clear">&nbsp;</div>
				</div>

			</div><? // fin app_body ?>
			<?

			// colonne de gauche
			JL::loadMod('profil_panel');

		?>
		<div class="clear"> </div>
		<?

		}
*/

		// bar&egrave;me
		public static function pointsBareme(&$data, &$rows) {
			include("lang/app_points.".$_GET['lang'].".php");
			global $langue;

			?><div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $data->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<!--<h2 class="barre"><?php //echo $data->titre;?></h2>-->
			<div class="texte_explicatif">
				<? echo $data->texte;?><br />
			</div>
			<br />
			<h3 class="result"><?php echo $lang_points["Bareme"];?></h3>
			<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<th><?php echo $lang_points["ActionAEffectuer"];?></th>
					<th align="middle"><?php echo $lang_points["Points"];?></th>
				</tr>
				<?
					// s'il y a des donn&eacute;es &agrave; afficher
					if(is_array($rows) && count($rows) > 0) {

						$i = 1;

						// pour chaque action du bar&egrave;me
						foreach($rows as $row) {

							// html entities
							JL::makeSafe($row);
							?>
								<tr>
									<td <? if($i==count($rows)){ echo 'class="point_fin"'; }?>><? echo $row->nom; ?></td>
									<td align="middle" <? if($i==count($rows)){ echo 'class="point_fin"'; }?>>+ <? echo $row->points; ?></td>
								</tr>
							<?

							$i++;

						}

					} else {
					?>
						<tr><td colspan="2"><?php echo $lang_points["LeBaremeNAPasEncore"];?> !</td></tr>
					<?
					}
				?>
			</table>
				
		<?
		}


		// affiche la liste des appels &agrave; t&eacute;moins
		public static function pointsMesPoints(&$data, &$rows, &$search) {
			global $langue;
			include("lang/app_points.".$_GET['lang'].".php");

			// variables
			$rayon			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];

		
		?>	
		<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $data->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
		<!--<h2 class="barre"></h2>-->
		<div class="texte_explicatif">
			<? echo $data->texte;?><br />
		</div>
		<br />
		<h3 class="result"><?php echo $lang_points["MesSolofleurs"];?></h3>
		<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<th><?php echo $lang_points["ActionEffectuee"];?></th>
				<th><?php echo $lang_points["Date"];?></th>
				<th align="middle"><?php echo $lang_points["Points"];?></th>
			</tr>
			<?

			// liste les points gagn&eacute;s
			if(is_array($rows) && count($rows)) {
				
				$i=1;
				
				foreach($rows as $row) {

					// htmlentities
					JL::makeSafe($row);

					?>
						<tr>
							<td <? if($i==count($rows)){ echo 'class="point_fin"'; }?>><? echo $row->nom; ?></td>
							<td class="date <? if($i==count($rows)){ echo 'point_fin'; }?>" ><? echo date('d.m.Y  H:i:s', strtotime($row->datetime)); ?></td>
							<td align="middle" <? if($i==count($rows)){ echo 'class="point_fin"'; }?>><? echo $row->id == 20 ? '<span class="red">- '.$row->data : '<span class="green">+ '.$row->points; ?></span></td>
						</tr>
					<?
					$i++;
				}
			?>
				</table>
				<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td>
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td >
										<? // page pr&eacute;c&eacute;dente
										if($search['page'] > 1) { ?>
											<a href="<? echo JL::url(SITE_URL.'/index.php?app=points&action=mespoints&page='.($search['page']-1).'&'.$langue); ?>" class="bouton envoyer" title="<?php echo $lang_points["PagePrecedente"];?>">&laquo; <?php echo $lang_points["PagePrecedente"];?></a>
										<? } ?>
									</td>
									<td class="center">
										<span class="orange"><?php echo $lang_points["Pages"];?></span>:
										<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL.'/index.php?app=points&action=mespoints&page=1'.'&'.$langue); ?>" title="<?php echo $lang_points["Debut"];?>"><?php echo $lang_points["Debut"];?></a> ...<? }?>
										<?
											for($i=$debut; $i<=$fin; $i++) {
											?>
												 <a href="<? echo JL::url(SITE_URL.'/index.php?app=points&action=mespoints&page='.$i.'&'.$langue); ?>" title="<?php echo $lang_points["Page"];?> <? echo $i; ?>" <? if($i == $search['page']) { ?>class="active"<? } ?>><? echo $i; ?></a>
											<?
											}
										?>
										<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL.'/index.php?app=points&action=mespoints&page='.$search['page_total'].'&'.$langue); ?>" title="<?php echo $lang_points["Fin"];?> <? echo $search['page_total']; ?>"><?php echo $lang_points["Fin"];?></a><? }?> <i>(<? echo $search['result_total']; ?> <? echo $search['result_total'] > 1 ? ''.$lang_points["Actions"].'' : ''.$lang_points["Action"].''; ?>)</i>
									</td>
									<td class="right">
										<? // page suivante
										if($search['page'] < $search['page_total']) { ?>
											<a href="<? echo JL::url(SITE_URL.'/index.php?app=points&action=mespoints&page='.($search['page']+1).'&'.$langue); ?>" class="bouton envoyer" title="<?php echo $lang_points["PageSuivante"];?>"><?php echo $lang_points["PageSuivante"];?> &raquo;</a>
										<? } ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<?
				} else {
				?>

						<tr><td colspan="3" align="middle"><?php echo $lang_points["AucunPoints"];?> !<? /*Vous n'avez gagn&eacute; aucun points pour l'instant !*/ ?></td></tr>
					</table>

				<?
				}
				?>
			
		<?
		}


		// page d'info
		public static function pointsContent(&$row) {
			global $langue;
			include("lang/app_points.".$_GET['lang'].".php");

			// htmlentities
			JL::makeSafe($row, 'texte');


			?>	<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $row->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
		<!--	<h2 class="barre"></h2>-->
			<div class="texte_explicatif">
				<? echo $row->texte;?>
			</div>
			
		<?
		}


		// affichage du classement
		public static function pointsClassement(&$data, &$rows) {
			global $langue;
			include("lang/app_points.".$_GET['lang'].".php");

			?>	
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $data->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<!--<h2 class="barre"></h2>-->
			<div class="texte_explicatif">
				<? echo $data->texte;?>
			</div>
			<br />
			<h3 class="result"><?php echo $lang_points["Classement"];?></h3>
			<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<th class="tdsmall"><?php echo $lang_points["Position"];?></th>
					<th><?php echo $lang_points["Membre"];?></th>
					<th class="tdsmall" title="<?php echo $lang_points["ClassProgress"];?>" style="cursor:help;"><?php echo $lang_points["Progression"];?></th>
				</tr>
				<?
					// s'il y a des donn&eacute;es &agrave; afficher
					if(is_array($rows) && count($rows) > 0) {

						$i 		= 1;
						// pour chaque action du bar&egrave;me
						foreach($rows as $row) {

							// html entities
							JL::makeSafe($row);
							?>
								<tr >
									<td class="tdsmall <? if($i==count($rows)){ echo 'point_fin'; }?>"><? echo $i; ?></td>
									<td <? if($i==count($rows)){ echo 'class="point_fin"'; }?>><? if($i <= 1) { ?><img src="<? echo SITE_URL.'/parentsolo/images/pos'.$i.'.gif'; ?>" alt="Position<? echo $i; ?>" class="star" /> <? } ?><a href="<? echo JL::url('index.php?app=profil&action=view&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_points["VoirCeProfil"];?>"><? echo $row->username; ?></a></td>
									<td class="tdsmall <? if($i==count($rows)){ echo 'point_fin'; }?>">
									<? if($row->last_rank == 0 || $row->new_rank < $row->last_rank) { ?>
										<img src="<? echo SITE_URL; ?>/images/up.gif" alt="<?php echo $lang_points["Gaindeplaces"];?>" />
									<? } elseif($row->new_rank > $row->last_rank) { ?>
										<img src="<? echo SITE_URL; ?>/images/down.gif" alt="<?php echo $lang_points["Pertedeplaces"];?>" />
									<? } else { ?>
										-
									<? } ?>
									</td>
								</tr>
							<?

							$i++;

						}

					} else {
					?>
						<tr><td colspan="3"><?php echo $lang_points["AucunClassement"];?> !</td></tr>
					<?
					}
				?>
			</table>
		<?
		}


		// affichage du classement
		public static function pointsArchives(&$data, &$rows) {
			global $langue;
			include("lang/app_points.".$_GET['lang'].".php");

			
			?>	<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $data->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<!--<h2 class="barre"></h2>-->
			<div class="texte_explicatif">
				<? echo $data->texte;?>
			</div>
			<?

			// s'il y a des archives &agrave; afficher
			if(is_array($rows) && count($rows)) {

				// variables locales
				$annee_mois = '';

				foreach($rows as $row) {

					if($row->annee_mois != $annee_mois) {
						if($annee_mois != '') {
						?>
							</table>
						<?
						}

						$dateAnneeMois = explode('-', $row->annee_mois);

					?>
					<br />
					<h3 class="result"><?php echo $lang_points["Classement"];?> <? echo date('m/Y', mktime(0,0,0, $dateAnneeMois[1], 1, $dateAnneeMois[0])); ?></h3>
					<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<th class="tdsmall" align="middle"><?php echo $lang_points["Position"];?></th>
							<th><?php echo $lang_points["Membre"];?></th>
						</tr>
						<?

							$class 			= 0;
							$i 				= 1;
							$annee_mois 	= $row->annee_mois;

					}

					// html entities
					JL::makeSafe($row);

					?>
						<tr >
							<td class="tdsmall <? if($i==10){ echo 'point_fin'; }?>" align="middle"><? echo $i; ?></td>
							<td <? if($i==10){ echo 'class="point_fin"'; }?>><? if($i <= 1) { ?><img src="<? echo SITE_URL.'/parentsolo/images/pos'.$i.'.gif'; ?>" alt="Position<? echo $i; ?>" class="star" /> <? } ?><a href="<? echo JL::url('index.php?app=profil&action=view&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_points["VoirCeProfil"];?>"><? echo $row->username; ?></a></td>
						</tr>
					<?

					$class = 1 - $class;
					$i++;

				} // fin foreach rows
				?>
				</table>
			<?
			} else {
			?>

				<br />
				<br />
				<h3 class="result"><?php echo $lang_points["Archives"];?></h3>
				<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td align="middle"><?php echo $lang_points["AucunClassement"];?>!</td>
					</tr>
				</table>	

			<?
			}
		}

	}
?>

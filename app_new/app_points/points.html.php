<?php

	// s�curit�
	defined('JL') or die('Error 401');

	class HTML_points {

		


		/*// affiche la liste des t�moignages
		function pointsTemoignages(&$rows) {
			global $langue;
			include("lang/app_points.".$_GET['lang'].".php");

			?>
			<div class="app_body">
			<?php 
				//affichage du menu
				HTML_points::pointsMenu();

				?>
				<h1 class="points"><?php echo $lang_points["TemoignageDeGagnants"];?></h1>
				<p class="pointsP">
					<?php echo $lang_points["DecouvrezLesChoix"];?> !
				</p>

				<?php 				if(is_array($rows) && count($rows)) {
					foreach($rows as $row) {

						// limitation de la description
						$temoignageLimite	= 550;
						if(strlen($row->temoignage) > $temoignageLimite) {
							$row->temoignage = substr($row->temoignage, 0, $temoignageLimite).'...';
						}

						// r�cup la photo de l'utilisateur
						$photo 				= JL::userGetPhoto($row->user_id, '109', 'profil', $row->photo_defaut);

						// photo par d�faut
						if(!$photo) {
							$photo 			= SITE_URL.'/parentsolo/images/parent-solo-109-'.$row->genre.'.jpg';
						}

						// html entities
						JL::makeSafe($row);

						?>
						<div class="pointsTemoignage">
							<a href="<?php echo JL::url('index.php?app=points&action=temoignage&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_points["LireTemComplet"];?> <?php echo $row->username; ?>" class="titre"><?php echo $lang_points["TemDe"];?> <?php echo $row->username; ?></a>
							<p><?php echo $row->temoignage; ?></p>
							<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$row->user_id.'&'.$langue); ?>" title="<?php echo $lang_points["VoirProfParSuisse"];?> <?php echo $row->username; ?>" class="aPhoto"><img src="<?php echo $photo; ?>" alt="<?php echo $row->username; ?>" /><span><?php echo $row->username; ?></span></a>
							<a href="<?php echo JL::url('index.php?app=points&action=temoignage&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_points["LireTemComplet"];?> <?php echo $row->username; ?>" class="btnNoirRose"><?php echo $lang_points["LireSuite"];?></a>
						</div>
					<?php 					}

				} else {
				?>
					<?php echo $lang_points["AucunTemoignage"];?>.
				<?php 				}
			?>
			</div><?php // fin app_body ?>
			<?php 
			// colonne de gauche
			JL::loadMod('profil_panel');

		?>
		<div class="clear"> </div>
		<?php 		}


		// affiche un t�moignage
		function pointsTemoignage(&$row) {
			global $langue;

			// r�cup la photo de l'utilisateur
			$photo 				= JL::userGetPhoto($row->user_id, '109', 'profil', $row->photo_defaut);

			// photo par d�faut
			if(!$photo) {
				$photo 			= SITE_URL.'/parentsolo/images/parent-solo-109-'.$row->genre.'.jpg';
			}

			// html entities
			JL::makeSafe($row);

			?>
			<div class="app_body">
				<?php 
					//affichage du menu
					HTML_points::pointsMenu();

				?>

				<div class="contenu">
					<h1><?php echo $lang_points["TemoignageConcours"];?></h1>
					<img src="<?php echo $photo; ?>" alt="<?php echo $row->username; ?>" class="ptsTemoignage" /><?php echo nl2br($row->temoignage); ?><br />
					<br />
					<?php echo $lang_points["TemoignageRedige"];?> <a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$row->user_id.'&'.$langue); ?>" title="<?php echo $lang_points["VoirProfParSuisse"];?> <?php echo $row->username; ?>"><?php echo $row->username; ?></a> <?php echo $lang_points["Le"]?> <?php echo date('d/m/Y', strtotime($row->temoignage_date)); ?>.

					<a href="<?php echo JL::url('index.php?app=points&action=temoignages'.'&'.$langue); ?>" class="bouton return_home" title="<?php echo $lang_points["RetListeTem"];?>"><?php echo $lang_points["RetourALaListe"];?></a>

					<div class="clear">&nbsp;</div>
				</div>

			</div><?php // fin app_body ?>
			<?php 
			// colonne de gauche
			JL::loadMod('profil_panel');

		?>
		<div class="clear"> </div>
		<?php 
		}
*/

		// bar�me
		function pointsBareme(&$data, &$rows) {
			include("lang/app_points.".$_GET['lang'].".php");
			global $langue;

			?><div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $data->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<!--<h2 class="barre"><?php //echo $data->titre;?></h2>-->
			<div class="texte_explicatif">
				<?php echo $data->texte;?><br />
			</div>
			<br />
			<h3 class="result"><?php echo $lang_points["Bareme"];?></h3>
			<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<th><?php echo $lang_points["ActionAEffectuer"];?></th>
					<th align="middle"><?php echo $lang_points["Points"];?></th>
				</tr>
				<?php 					// s'il y a des donn�es � afficher
					if(is_array($rows) && count($rows) > 0) {

						$i = 1;

						// pour chaque action du bar�me
						foreach($rows as $row) {

							// html entities
							JL::makeSafe($row);
							?>
								<tr>
									<td <?php if($i==count($rows)){ echo 'class="point_fin"'; }?>><?php echo $row->nom; ?></td>
									<td align="middle" <?php if($i==count($rows)){ echo 'class="point_fin"'; }?>>+ <?php echo $row->points; ?></td>
								</tr>
							<?php 
							$i++;

						}

					} else {
					?>
						<tr><td colspan="2"><?php echo $lang_points["LeBaremeNAPasEncore"];?> !</td></tr>
					<?php 					}
				?>
			</table>
				
		<?php 		}


		// affiche la liste des appels � t�moins
		function pointsMesPoints(&$data, &$rows, &$search) {
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
			<?php echo $data->texte;?><br />
		</div>
		<br />
		<h3 class="result"><?php echo $lang_points["MesSolofleurs"];?></h3>
		<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<th><?php echo $lang_points["ActionEffectuee"];?></th>
				<th><?php echo $lang_points["Date"];?></th>
				<th align="middle"><?php echo $lang_points["Points"];?></th>
			</tr>
			<?php 
			// liste les points gagn�s
			if(is_array($rows) && count($rows)) {
				
				$i=1;
				
				foreach($rows as $row) {

					// htmlentities
					JL::makeSafe($row);

					?>
						<tr>
							<td <?php if($i==count($rows)){ echo 'class="point_fin"'; }?>><?php echo $row->nom; ?></td>
							<td class="date <?php if($i==count($rows)){ echo 'point_fin'; }?>" ><?php echo date('d.m.Y  H:i:s', strtotime($row->datetime)); ?></td>
							<td align="middle" <?php if($i==count($rows)){ echo 'class="point_fin"'; }?>><?php echo $row->id == 20 ? '<span class="red">- '.$row->data : '<span class="green">+ '.$row->points; ?></span></td>
						</tr>
					<?php 					$i++;
				}
			?>
				</table>
				<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td>
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td >
										<?php // page pr�c�dente
										if($search['page'] > 1) { ?>
											<a href="<?php echo JL::url(SITE_URL.'/index.php?app=points&action=mespoints&page='.($search['page']-1).'&'.$langue); ?>" class="bouton envoyer" title="<?php echo $lang_points["PagePrecedente"];?>">&laquo; <?php echo $lang_points["PagePrecedente"];?></a>
										<?php } ?>
									</td>
									<td class="center">
										<span class="orange"><?php echo $lang_points["Pages"];?></span>:
										<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL.'/index.php?app=points&action=mespoints&page=1'.'&'.$langue); ?>" title="<?php echo $lang_points["Debut"];?>"><?php echo $lang_points["Debut"];?></a> ...<?php }?>
										<?php 											for($i=$debut; $i<=$fin; $i++) {
											?>
												 <a href="<?php echo JL::url(SITE_URL.'/index.php?app=points&action=mespoints&page='.$i.'&'.$langue); ?>" title="<?php echo $lang_points["Page"];?> <?php echo $i; ?>" <?php if($i == $search['page']) { ?>class="active"<?php } ?>><?php echo $i; ?></a>
											<?php 											}
										?>
										<?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL.'/index.php?app=points&action=mespoints&page='.$search['page_total'].'&'.$langue); ?>" title="<?php echo $lang_points["Fin"];?> <?php echo $search['page_total']; ?>"><?php echo $lang_points["Fin"];?></a><?php }?> <i>(<?php echo $search['result_total']; ?> <?php echo $search['result_total'] > 1 ? ''.$lang_points["Actions"].'' : ''.$lang_points["Action"].''; ?>)</i>
									</td>
									<td class="right">
										<?php // page suivante
										if($search['page'] < $search['page_total']) { ?>
											<a href="<?php echo JL::url(SITE_URL.'/index.php?app=points&action=mespoints&page='.($search['page']+1).'&'.$langue); ?>" class="bouton envoyer" title="<?php echo $lang_points["PageSuivante"];?>"><?php echo $lang_points["PageSuivante"];?> &raquo;</a>
										<?php } ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<?php 				} else {
				?>

						<tr><td colspan="3" align="middle"><?php echo $lang_points["AucunPoints"];?> !<?php /*Vous n'avez gagn&eacute; aucun points pour l'instant !*/ ?></td></tr>
					</table>

				<?php 				}
				?>
			
		<?php 		}


		// page d'info
		function pointsContent(&$row) {
			global $langue;
			include("lang/app_points.".$_GET['lang'].".php");

			// htmlentities
			JL::makeSafe($row, 'texte');


			?>	<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $row->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
		<!--	<h2 class="barre"></h2>-->
			<div class="texte_explicatif">
				<?php echo $row->texte;?>
			</div>
			
		<?php 		}


		// affichage du classement
		function pointsClassement(&$data, &$rows) {
			global $langue;
			include("lang/app_points.".$_GET['lang'].".php");

			?>	
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $data->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<!--<h2 class="barre"></h2>-->
			<div class="texte_explicatif">
				<?php echo $data->texte;?>
			</div>
			<br />
			<h3 class="result"><?php echo $lang_points["Classement"];?></h3>
			<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<th class="tdsmall"><?php echo $lang_points["Position"];?></th>
					<th><?php echo $lang_points["Membre"];?></th>
					<th class="tdsmall" title="<?php echo $lang_points["ClassProgress"];?>" style="cursor:help;"><?php echo $lang_points["Progression"];?></th>
				</tr>
				<?php 					// s'il y a des donn�es � afficher
					if(is_array($rows) && count($rows) > 0) {

						$i 		= 1;
						// pour chaque action du bar�me
						foreach($rows as $row) {

							// html entities
							JL::makeSafe($row);
							?>
								<tr >
									<td class="tdsmall <?php if($i==count($rows)){ echo 'point_fin'; }?>"><?php echo $i; ?></td>
									<td <?php if($i==count($rows)){ echo 'class="point_fin"'; }?>><?php if($i <= 1) { ?><img src="<?php echo SITE_URL.'/parentsolo/images/pos'.$i.'.gif'; ?>" alt="Position<?php echo $i; ?>" class="star" /> <?php } ?><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_points["VoirCeProfil"];?>"><?php echo $row->username; ?></a></td>
									<td class="tdsmall <?php if($i==count($rows)){ echo 'point_fin'; }?>">
									<?php if($row->last_rank == 0 || $row->new_rank < $row->last_rank) { ?>
										<img src="<?php echo SITE_URL; ?>/images/up.gif" alt="<?php echo $lang_points["Gaindeplaces"];?>" />
									<?php } elseif($row->new_rank > $row->last_rank) { ?>
										<img src="<?php echo SITE_URL; ?>/images/down.gif" alt="<?php echo $lang_points["Pertedeplaces"];?>" />
									<?php } else { ?>
										-
									<?php } ?>
									</td>
								</tr>
							<?php 
							$i++;

						}

					} else {
					?>
						<tr><td colspan="3"><?php echo $lang_points["AucunClassement"];?> !</td></tr>
					<?php 					}
				?>
			</table>
		<?php 		}


		// affichage du classement
		function pointsArchives(&$data, &$rows) {
			global $langue;
			include("lang/app_points.".$_GET['lang'].".php");

			
			?>	<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $data->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<!--<h2 class="barre"></h2>-->
			<div class="texte_explicatif">
				<?php echo $data->texte;?>
			</div>
			<?php 
			// s'il y a des archives � afficher
			if(is_array($rows) && count($rows)) {

				// variables locales
				$annee_mois = '';

				foreach($rows as $row) {

					if($row->annee_mois != $annee_mois) {
						if($annee_mois != '') {
						?>
							</table>
						<?php 						}

						$dateAnneeMois = explode('-', $row->annee_mois);

					?>
					<br />
					<h3 class="result"><?php echo $lang_points["Classement"];?> <?php echo date('m/Y', mktime(0,0,0, $dateAnneeMois[1], 1, $dateAnneeMois[0])); ?></h3>
					<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<th class="tdsmall" align="middle"><?php echo $lang_points["Position"];?></th>
							<th><?php echo $lang_points["Membre"];?></th>
						</tr>
						<?php 
							$class 			= 0;
							$i 				= 1;
							$annee_mois 	= $row->annee_mois;

					}

					// html entities
					JL::makeSafe($row);

					?>
						<tr >
							<td class="tdsmall <?php if($i==10){ echo 'point_fin'; }?>" align="middle"><?php echo $i; ?></td>
							<td <?php if($i==10){ echo 'class="point_fin"'; }?>><?php if($i <= 1) { ?><img src="<?php echo SITE_URL.'/parentsolo/images/pos'.$i.'.gif'; ?>" alt="Position<?php echo $i; ?>" class="star" /> <?php } ?><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_points["VoirCeProfil"];?>"><?php echo $row->username; ?></a></td>
						</tr>
					<?php 
					$class = 1 - $class;
					$i++;

				} // fin foreach rows
				?>
				</table>
			<?php 			} else {
			?>

				<br />
				<br />
				<h3 class="result"><?php echo $lang_points["Archives"];?></h3>
				<table class="table table-bordered table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td align="middle"><?php echo $lang_points["AucunClassement"];?>!</td>
					</tr>
				</table>	

			<?php 			}
		}

	}
?>

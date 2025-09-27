<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');
			include("lang/app_mod.".$_GET['lang'].".php");

	global $db, $langue;

	$annee_mois = date('Y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));

	// r&eacute;cup le dernier t&eacute;moignage en date du syst�me de points, du mois pr&eacute;c&eacute;dent
	$query = "SELECT pg.id, pg.user_id, u.username, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, IFNULL(pv.nom, '') AS ville, up.genre, up.photo_defaut, up.nb_enfants, CURRENT_DATE, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age, pg.position"
	." FROM points_gagnants AS pg"
	." INNER JOIN user AS u ON u.id = pg.user_id"
	." INNER JOIN user_profil AS up ON up.user_id = u.id"
	." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
	." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
	." WHERE pg.annee_mois = '".$db->escape($annee_mois)."'"
	." ORDER BY RAND()"
	." LIMIT 0,1"
	;
	$gagnant = $db->loadObject($query);


	// limitation de la description
	$gagnantLimite	= 280;

	// r&eacute;cup la photo de l'utilisateur
	$photo 				= JL::userGetPhoto($gagnant->user_id, '109', 'profil', $gagnant->photo_defaut);

	// photo par d&eacute;faut
	if(!$photo) {
		$photo 			= SITE_URL.'/parentsolo/images/parent-solo-109-'.$gagnant->genre.'-'.$_GET['lang'].'.jpg';
	}

	// lien "+ information"
	$link = JL::url('index.php?app=points&action=info'.'&'.$langue);


	// html entities
	JL::makeSafe($gagnant);


	?>
<?php 
	if($gagnant){
?>

<div class="col-md-6 col-sm-12">
	<div class="col-md-12"><h3 class="verela_title_h3 parentsolo_mt_20  parentsolo_pb_15"><?php echo $lang_mod["Solofleurs"];?></h3></div>
 	<div class="col-md-12 col-sm-12  testimonials-style-2  testimonials-bg_admin parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
                    <div class="outer">
                        <div class="round">
                            <a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$gagnant->user_id.'&lang='.$_GET['lang']); ?>" target="_blank"  title="<?php echo $lang_mod["VoirCeProfil"]; ?>">
                                <img width="100" height="100" src="<?php echo $photo; ?>" alt="<?php echo $gagnant->username; ?>"  class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<?php echo $photo; ?>" sizes="(max-width: 70px) 100vw, 70px">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 ">
                    <h2 class="name parentsolo_pt_10"><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$gagnant->user_id.'&lang='.$_GET['lang']); ?>" target="_blank"  title="<?php echo $lang_mod["VoirCeProfil"];?>" class="username"><?php echo $gagnant->username; ?></a></h2>
                    <div class="text-box  parentsolo_pb_10" style="line-height: 22px !important;">
<?php echo $lang_mod["ToutesNosFelicitation"]; ?>!<br />
						<a href="<?php echo $link; ?>" title="<?php echo $lang_mod["EnSavoir+"];?>" class="plus"><?php echo $lang_mod["EnSavoir+"];?></a>
					
						</div>
                   
                </div>
            </div>
			<div class="col-md-4 col-sm-4 col-sx-12">
						<h6 class="parentsolo_text-left parentsolo_txt_clr  icon_font_size" style="font-size: 12px;line-height: 22px;">
							<i class="fa fa-check-square-o"></i> <?php echo $gagnant->age; ?> <?php echo $lang_mod["ans"];?>
						</h6>
					</div>
					<div class="col-md-4 col-sm-4 col-sx-12">
						<h6 class="parentsolo_text-left parentsolo_txt_clr  icon_font_size" style="font-size: 12px;line-height: 22px;">
							<i class="fa fa-check-square-o"></i> <?php echo $gagnant->nb_enfants; ?> <?php echo $gagnant->nb_enfants > 1 ? $lang_mod["enfants"] : $lang_mod["enfant"]; ?>
						</h6>
					</div>
					<div class="col-md-4 col-sm-4 col-sx-12">
						<h6 class="parentsolo_text-left parentsolo_txt_clr  icon_font_size" style="font-size: 12px;line-height: 22px;">
							<i class="fa fa-check-square-o"></i> <?php echo $gagnant->canton; ?>
						</h6>
					</div>
        </div>
		
		</div>

		<!--<div class="bloc bloc_left bloc_solofleurs_groupes 1">
			<h3><?php// echo $lang_mod["Solofleurs"];?></h3>
			<table width="100%" cellpadding="0" cellspacing="0" >
				<tr>
					<td valign="top" width="75px">
						<a href="javascript:windowOpen('<?php //echo $gagnant->username; ?>','<?php // echo JL::url('index.php?app=profil&action=view&id='.$gagnant->user_id.'&lang='.$_GET['lang']); ?>','615px','511px','yes');" title="<?php //echo $lang_mod["VoirCeProfil"]; ?>"><img src="<?php // echo $photo; ?>" alt="<?php // echo $gagnant->username; ?>" class="profil"/></a>
					</td>
					<td valign="top" align="left">
						<a href="javascript:windowOpen('<?php //echo $gagnant->username; ?>','<?php // echo JL::url('index.php?app=profil&action=view&id='.$gagnant->user_id.'&lang='.$_GET['lang']); ?>','615px','511px','yes');" title="<?php // echo $lang_mod["VoirCeProfil"];?>" class="username"><?php // echo $gagnant->username; ?></a><br />
						<?php // echo $gagnant->age; ?> <?php// echo $lang_mod["ans"];?><br />
						<?php // echo $gagnant->nb_enfants; ?> <?php //echo $gagnant->nb_enfants > 1 ? $lang_mod["enfants"] : $lang_mod["enfant"]; ?><br />
						<?php //echo $gagnant->canton; ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php // echo $lang_mod["ToutesNosFelicitation"]; ?>!<br />
						<a href="<?php // echo $link; ?>" title="<?php// echo $lang_mod["EnSavoir+"];?>" class="plus"><?php// echo $lang_mod["EnSavoir+"];?></a>
					</td>
				</tr>
			</table>
		</div>-->
<?php 
	}
	
?>

<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');
			include("lang/app_mod.".$_GET['lang'].".php");

	global $db, $langue, $user;
	
	
	$query = "SELECT g.id, g.titre, g.texte, u.username"
	." FROM groupe AS g"
	." LEFT JOIN user AS u ON u.id = g.user_id"
	." WHERE g.active = 1"
	." AND g.titre != ''"
	." AND u.published > 0"
	." AND u.confirmed > 0"
	." AND g.user_id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)"
	." AND g.user_id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)"
	." ORDER BY g.date_add DESC"
	." LIMIT 0,1"
	;
	$groupe = $db->loadObject($query);

	// limitation de la longueur du titre
	if(strlen($groupe->titre) > TITRE_HOME) {
		$groupe->titre = substr($groupe->titre, 0, TITRE_HOME).'...';
	}
	
	// limitation de la longueur de l'intro
	$groupe->texte = strip_tags(html_entity_decode($groupe->texte));
	if(strlen($groupe->texte) > INTRO_HOME) {
		$groupe->texte = substr($groupe->texte, 0, INTRO_HOME).'...';
	}
	
	// &agrave; placer toujours après les 2 limitations
	JL::makeSafe($groupe, 'texte');

	// si une photo a &eacute;t&eacute; envoy&eacute;e
	$filePath = 'images/groupe/'.$groupe->id.'.jpg';
	if(is_file(SITE_PATH.'/'.$filePath)) {
		$image	= $filePath;
	} else {
		if($groupe->user_id != '1'){
			$image	= 'images/groupes-parentsolo.jpg';
		} else {
			$image	= 'parentsolo/images/parent-solo-109-'.$_GET['lang'].'.jpg';
		}
		
	}

	?>


<div class="col-md-6 col-sm-12">
	<div class="col-md-12"><h3 class="verela_title_h3 parentsolo_mt_20  parentsolo_pb_15"><?php echo $lang_mod["Groupes"];?></h3></div>
	<div class="col-md-12 col-sm-12  testimonials-style-2 testimonials-bg_admin parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
                    <div class="outer">
                        <div class="round">
                           
                                <img width="100" height="100" src="<? echo SITE_URL.'/'.$image; ?>" alt="<? echo $groupe->titre; ?>"   class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<? echo SITE_URL.'/'.$image; ?>" sizes="(max-width: 70px) 100vw, 70px">
                         
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15">
                    <h3 class="name parentsolo_pt_10"><? echo $groupe->titre; ?></h3>
                    <div class="text-box parentsolo_pt_10 parentsolo_pb_10">
						<? echo $groupe->texte; ?>
						</div>
				
						<h6 class="parentsolo_text-right parentsolo_txt_clr parentsolo_txt_overflow">
							<a href="<? echo JL::url('index.php?app=groupe&action=list&groupe_type=all'.'&'.$langue); ?>" title="<?php echo $lang_mod["TousLesGroupes"];?>" class="plus"><?php echo $lang_mod["TousLesGroupes"];?></a>
						</h6>
						<? // si user log est une femme
							if($user->genre == 'f') {
						?>
								<a href="http://www.babybook.ch/blog/forum" title="<?php echo $lang_mod["ForumEntreMamans"];?>" class="forum_maman" target="_blank"><?php echo $lang_mod["ForumEntreMamans"];?></a>
						<?
							} 
						?>
                   
                </div>
            </div>
        </div></div>

	<!--<div class="bloc bloc_right bloc_solofleurs_groupes">
		<h3><?php /* echo $lang_mod["Groupes"];?></h3>
		<table width="100%">
			<tr>
				<td valign="top">
					<img src="<? echo SITE_URL.'/'.$image; ?>" alt="<? echo $groupe->titre; ?>" />
				</td>
				<td valign="top" align="left">
					<div class="titre"><? echo $groupe->titre; ?></div>
					<? echo $groupe->texte; ?><br />
					<a href="<? echo JL::url('index.php?app=groupe&action=list&groupe_type=all'.'&'.$langue); ?>" title="<?php echo $lang_mod["TousLesGroupes"];?>" class="plus"><?php echo $lang_mod["TousLesGroupes"];?></a><br />
					<br />
					<center>
						<? // si user log est une femme
							if($user->genre == 'f') {
						?>
								<a href="http://www.babybook.ch/blog/forum" title="<?php echo $lang_mod["ForumEntreMamans"];?>" class="forum_maman" target="_blank"><?php echo $lang_mod["ForumEntreMamans"];?></a>
						<?
							} */
						?>
					</center>
				</td>
			</tr>
		</table>
	</div>
-->

<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');
			include("lang/app_mod.".$_GET['lang'].".php");

	global $db, $langue, $user;
	
	
	$query = "SELECT ec.event_name, ec.event_desc, ec.start_date, ec.end_date, ec.id, ec.uservalue, ec.username, ec.filename "
	." FROM events_creations AS ec"
	." WHERE ec.published = 0"
	." ORDER BY ec.id DESC"
	." LIMIT 0,3"	
	;
	
	
	$events = $db->loadObjectList($query);

	
	
	// &agrave; placer toujours après les 2 limitations
	//JL::makeSafe($events, 'event_desc');

	// si une photo a &eacute;t&eacute; envoy&eacute;e
	
	

	?>


<div class="col-md-6 col-sm-12">
	<div class="col-md-12"><h3 class="verela_title_h3 parentsolo_mt_20  parentsolo_pb_15"><?php echo $lang_mod["Events_title"];?></h3></div>
	<div class="clear"></div>
	<div id="events_testi" class="owl-carousel owl-theme" style="width:100% !important;">
	<?php 
	
	foreach($events as $contenu){
	
	$filePath = '/images/events/'.$contenu->filename;
	// limitation de la longueur du titre
	if(strlen($contenu->event_name) > TITRE_HOME) {
		$contenu->event_name = substr($contenu->event_name, 0, TITRE_HOME).'...';
	}
	
	// limitation de la longueur de l'intro
	$contenu->event_desc = strip_tags(html_entity_decode($contenu->event_desc));
	if(strlen($contenu->event_desc) > INTRO_HOME) {
		$contenu->event_desc = substr($contenu->event_desc, 0, INTRO_HOME).'...';
	}
				?>     
			<div class="item">
                         <div class="wd_family_member" style="margin:0px !important;">	<div class="col-md-12 col-sm-12  testimonials-style-2 testimonials-bg_admin parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
                    <div class="outer">
                        <div class="round">
								<a href="<?php echo JL::url('index.php?app=event&action=read&id='.$contenu->id.'&'.$langue); ?>" title="<?php echo $groupe->event_name; ?>"><img width="100" height="100" src="<?php echo SITE_URL.'/'.$filePath; ?>" alt="<?php echo $groupe->event_name; ?>"   class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<?php echo SITE_URL.'/'.$filePath; ?>" sizes="(max-width: 70px) 100vw, 70px"></a>
                        </div>
					</div>
				</div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15">
                   <h3 class="name " style="text-align:left"> <a href="<?php echo JL::url('index.php?app=event&action=read&id='.$contenu->id.'&'.$langue); ?>"  style="text-align:left"><?php echo $contenu->event_name; ?></a></h3>
                    <div class="text-box parentsolo_pt_10 parentsolo_pb_10">
						<?php echo $contenu->event_desc; ?>
						</div>
				
						<h6 class="parentsolo_text-right parentsolo_txt_clr parentsolo_txt_overflow">
							<a href="<?php echo JL::url('index.php?app=event'.'&'.$langue); ?>" title="<?php echo $lang_mod["More_events"];?>" class="plus"><?php echo $lang_mod["More_events"];?></a>
						</h6>
					
                   
                </div>
            </div>
        </div></div></div>
					<?php
					}
					?>	
					</div>
		</div>

	<!--<div class="bloc bloc_right bloc_solofleurs_groupes">
		<h3><?php /* echo $lang_mod["Groupes"];?></h3>
		<table width="100%">
			<tr>
				<td valign="top">
					<img src="<?php echo SITE_URL.'/'.$image; ?>" alt="<?php echo $groupe->titre; ?>" />
				</td>
				<td valign="top" align="left">
					<div class="titre"><?php echo $groupe->titre; ?></div>
					<?php echo $groupe->texte; ?><br />
					<a href="<?php echo JL::url('index.php?app=groupe&action=list&groupe_type=all'.'&'.$langue); ?>" title="<?php echo $lang_mod["TousLesGroupes"];?>" class="plus"><?php echo $lang_mod["TousLesGroupes"];?></a><br />
					<br />
					<center>
						<?php // si user log est une femme
							if($user->genre == 'f') {
						?>
								<a href="http://www.babybook.ch/blog/forum" title="<?php echo $lang_mod["ForumEntreMamans"];?>" class="forum_maman" target="_blank"><?php echo $lang_mod["ForumEntreMamans"];?></a>
						<?php 							} */
						?>
					</center>
				</td>
			</tr>
		</table>
	</div>
-->

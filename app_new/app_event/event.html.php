  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
<style>
@media (max-width: 991px) {
#divFileProgressContainer .progressWrapper{
	width:100% !important;
	}
	.validation.updateval{
	width:100% !important;
	}
}
</style>
  <?php
  
include('lang/app_event.'.$_GET["lang"].'.php');
  ?>
   
<?php

	// sécurité
	defined('JL') or die('Error 401');
	global $user;
	include("lang/app_event.".$_GET['lang'].".php");

	class table_HTML {	
	
function listevent(&$listdetails,&$search) {
include("lang/app_event.".$_GET['lang'].".php");

global $user;
$nb_listdetails		= count($listdetails);
			$rayon			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
			if($nb_listdetails!=0){

?>
<div class="parentsolo_txt_center mainhead">
         <h2 class="parentsolo_title barre "><?php echo $lang_event["ListeDesAppels"];?></h2>
         <div class="wedd-seperator" style="padding-bottom:30px;"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
	<?php if($user->id){
		?><div class="col-md-8 col-md-offset-2 parentsolo_form_style  parentsolo_mb_40" id="hide_form">
				
				<h3 class="parentsolo_title_h3 parentsolo_txt_center"><?php echo $lang_event["Search"]?></h3>
				<div class="row bottompadding parentsolo_mt_10">
							
							<div class="col-md-8">
							<input type="text"  name="search_list" id="search_list">
							</div>
				<div class="col-md-4 parentsolo_txt_center">
								<input type="button" name="searchclick" id="searchclick" style="padding:7px 25px;" value="<?php echo $lang_event["Search"]?>" class="bouton envoyer parentsolo_btn">
	
							</div>
							</div>
				
				
			</div>
	<? }?>
	
	
	
<div class="row parentsolo_pt_15 listmenu">
    <div class="col-md-12">
	
<?php

for($j=0; $j<$nb_listdetails; $j++){
if($j<6){
$listdetail = $listdetails[$j];
if(strlen($listdetail->event_desc) > LISTE_INTRO_CHAR) {
										
										$listdetail->event_desc = substr($listdetail->event_desc, 0, 100).'...';
									}
									if(strlen($listdetail->event_name) > LISTE_INTRO_CHAR) {
										
										$listdetail->event_name = substr($listdetail->event_name, 0, 10).'...';
									}
									$images=$listdetail->filename;
			$photo = SITE_URL.'/images/events/'.$images;
?>

<div class="col-md-6 col-sm-12"><div class="col-md-12 col-sm-12  testimonials-style-2 parentsolo_pl-r">
 
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
				<div class="outer">
                        <div class="round">
                        <a href="<? echo JL::url('index.php?app=event&action=read&id='.$listdetail->id.'&lang='.$_GET['lang']);  ?>" title="<?php echo $lang_appel_a_temoins["LireAppelATemoins"];?>" >
                                <img width="100" height="100" src="<? echo $photo; ?>" alt="<? echo $appel_temoins->username; ?>" class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<? echo $photo; ?>" sizes="(max-width: 70px) 100vw, 70px">
                            </a>
							</div></div>
                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                    <h2 class="name parentsolo_pt_10"><? echo $listdetail->event_name; ?></h2>
                    <div class="text-box parentsolo_pt_10 parentsolo_pb_10">
                       <? echo $listdetail->event_desc; ?>
						</div>
                    <a class="username" href="<? echo JL::url('index.php?app=event&action=read&id='.$listdetail->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_event["LireAppelATemoins"];?>">
						<h6 class="parentsolo_text-right parentsolo_txt_clr parentsolo_txt_overflow"><? echo $listdetail->username; ?></h6>
					</a>
                </div>
            </div>
        </div>
		</div>
		
<?php

	}
else{	
?>
<div class="col-md-6 col-sm-12"><div class="col-md-12 col-sm-12  testimonials-style-2 parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
				<div class="outer">
                        <div class="round">
                       <a href="<? echo JL::url('index.php?app=event&action=read&id='.$listdetail->id.'&lang='.$_GET['lang']);  ?>" title="<?php echo $lang_appel_a_temoins["LireAppelATemoins"];?>" >
                                <img width="100" height="100" src="<? echo $photo; ?>" alt="<? echo $appel_temoins->username; ?>" class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<? echo $photo; ?>" sizes="(max-width: 70px) 100vw, 70px">
                            </a> 
</div></div>							
                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                    <h2 class="name parentsolo_pt_10"><? echo $listdetail->event_name; ?></h2>
                    <div class="text-box parentsolo_pt_10 parentsolo_pb_10">
                       <? echo $listdetail->event_desc; ?>
						</div>
                    <a class="username" href="<? echo JL::url('index.php?app=event&action=read&id='.$listdetail->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_event["LireAppelATemoins"];?>">
						<h6 class="parentsolo_text-right parentsolo_txt_clr parentsolo_txt_overflow"><? echo $listdetail->username; ?></h6>
					</a>
                </div>
            </div>
        </div>
		</div>
<?	
}
}						
						?>																					
				<div class="col-md-12 parentsolo_plr_0 pagenum">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" >
						<div class="col-md-3 text-left">								
									<? // page précédente

									if($search['page'] > 1) { ?>
										<a href="<? echo JL::url(SITE_URL.'/index.php?app=event&page='.($search['page']-1).'&'.'&lang='.$_GET["lang"]); ?>" class="bouton envoyer" title="<?php echo $lang_event["PagePrecedente"];?>">&laquo; <?php echo $lang_event["PagePrecedente"];?></a>
									<? } ?>
								</div>
							<div class="col-md-6 text-center page_nav">
									<span class="orange"><?php echo $search['page_total'] == 1 ? $lang_event["Page"] : $lang_event["Pages"];?></span>:
									<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL.'/index.php?app=event&page=1'.'&'.'&lang='.$_GET["lang"]); ?>" title="<?php 'Page'?>"><?php echo $lang_event["Debut"];?></a> ...<? }?>
									<?
										for($i=$debut; $i<=$fin; $i++) {
										
										?>
											 <a href="<? echo JL::url(SITE_URL.'/index.php?app=event&page='.$i.'&'.'&lang='.$_GET["lang"]); ?>" title="<?php echo $lang_event["Page"];?> <? echo $i; ?>" <? if($i == $search['page']) { ?>class="active"<? } ?>><? echo $i; ?></a>
										<?
										}
									?>
									<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL.'/index.php?app=event&page='.$search['page_total'].'&'.'&lang='.$_GET["lang"]); ?>" title="<?php echo $lang_event["Fin"];?> <? echo $search['page_total']; ?>"><?php echo $lang_event["Fin"];?></a><? }?> <i>(<? echo $search['result_total']; ?> <? echo $search['result_total'] > 1 ? ''.$lang_event["AppelsATemoins"].'' : ''.$lang_event["AppelATemoins"].''; ?>)</i>
									</div>
								    <div class="col-md-3 text-right">
									<? // page suivante
									if($search['page'] < $search['page_total']) { ?>
										<a href="<? echo JL::url(SITE_URL.'/index.php?app=event&page='.($search['page']+1).'&'.'&lang='.$_GET["lang"]); ?>" class="bouton envoyer" title="<?php echo $lang_event["PageSuivante"];?>"><?php echo $lang_event["PageSuivante"];?> &raquo;</a>
									<? } ?>
								</div>
							</div>
						</div>
						</div></div>
<?php
}
else{
?>
<div>
									<div align="middle" class="error">
										<?php echo $lang_event["AucuneAppelATemoins"];?>
									</div>
								</div>
								
<?
}
?>
 <div class="col-lg-12" style="text-align:right">
				  <input type="button" class="bouton envoyer parentsolo_btn" name="create" id="create" value="<?php echo $lang_event["create"]; ?>">
				  </div>
<?
}
function readlist(&$readlist){
global $user;
global $langue;
include("lang/app_event.".$_GET['lang'].".php");
foreach($readlist as $contenu) { 
?>
<div class="content readcontent">
				<div class="contentl">
					<div class="colc">
						<div class="parentsolo_txt_center"><h3 class="barre parentsolo_title"><?php echo $contenu->event_name;?></h3>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
						<p>
							<div class="temoignage">
									
									<div class="row publication">
					<div class="col-md-4"><img  id="event_img" name="event_img" style="border: 1px solid rgb(72, 71, 71);box-shadow: 5px 5px 0px rgba(0, 0, 0, 0.24);" src="images/events/<?php echo $contenu->filename ?>"></div>

									<?
									if($user->id==$contenu->uservalue){
									?>
									<div class="col-md-8"><div style="text-align:right;"><div style="cursor:pointer" class="bouton envoyer a_link_icon edit fa fa-pencil-square-o" id="edit_<?php echo $contenu->id ?>"></div>&nbsp;&nbsp;&nbsp;&nbsp;<div style="color:red;cursor:pointer; font-" class="bouton envoyer a_link_icon delete fa fa-trash-o" id="delete_<?php echo $contenu->id ?>"></div></div></div>
									<?
									}
									?>
									<div class="col-md-8"><b><?php echo $lang_event["fromdate"]; ?>:</b>&nbsp;&nbsp;<?php echo date('d-m-Y',strtotime($contenu->start_date))?>&nbsp;&nbsp;<b><?php echo $lang_event["todate"]; ?></b> &nbsp;&nbsp;<?php echo date('d-m-Y',strtotime($contenu->end_date))?></div><br />
										
										<div class="col-md-8"><b><?php echo $lang_event["desc"]; ?>:</b>&nbsp;&nbsp;<?php echo $contenu->event_desc?></div><br />
										<div class="col-md-8"><div style="text-align:right; font-style: italic"><?php echo $contenu->event_name; ?></div></div>
										
										
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
}
function search(&$listdetails,&$search){
include("lang/app_event.".$_GET['lang'].".php");

global $user;
$nb_listdetails		= count($listdetails);
			$rayon			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
			if($nb_listdetails!=0){
?>
<div class="parentsolo_txt_center mainhead">
         <h2 class="parentsolo_title barre "><?php echo $lang_event["ListeDesAppels"];?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
	
	
<div class="row parentsolo_pt_15 listmenu">
    <div class="col-md-12">
	<?php

for($j=0; $j<$nb_listdetails; $j++){
if($j<6){
$listdetail = $listdetails[$j];
if(strlen($listdetail->event_desc) > LISTE_INTRO_CHAR) {
										
										$listdetail->event_desc = substr($listdetail->event_desc, 0, 100).'...';
									}
									if(strlen($contenu->event_name) > LISTE_INTRO_CHAR) {
										
										$contenu->event_name = substr($contenu->event_name, 0, 10).'...';
									}
									$images=$listdetail->filename;
			$photo = SITE_URL.'/images/events/'.$images;
?>

<div class="col-md-6 col-sm-12"><div class="col-md-12 col-sm-12  testimonials-style-2 parentsolo_pl-r">
 
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
				<div class="outer">
                        <div class="round">
                        <a href="<? echo JL::url('index.php?app=event&action=read&id='.$listdetail->id.'&lang='.$_GET['lang']);  ?>" title="<?php echo $lang_appel_a_temoins["LireAppelATemoins"];?>" >
                                <img width="100" height="100" src="<? echo $photo; ?>" alt="<? echo $appel_temoins->username; ?>" class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<? echo $photo; ?>" sizes="(max-width: 70px) 100vw, 70px">
                            </a>
							</div></div>
                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                    <h2 class="name parentsolo_pt_10"><? echo $listdetail->event_name; ?></h2>
                    <div class="text-box parentsolo_pt_10 parentsolo_pb_10">
                       <? echo $listdetail->event_desc; ?>
						</div>
                    <a class="username" href="<? echo JL::url('index.php?app=event&action=read&id='.$listdetail->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_event["LireAppelATemoins"];?>">
						<h6 class="parentsolo_text-right parentsolo_txt_clr parentsolo_txt_overflow"><? echo $listdetail->username; ?></h6>
					</a>
                </div>
            </div>
        </div>
		</div>
		
<?php

	}
else{	
?>
<div class="col-md-6 col-sm-12"><div class="col-md-12 col-sm-12  testimonials-style-2 parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
				<div class="outer">
                        <div class="round">
                       <a href="<? echo JL::url('index.php?app=event&action=read&id='.$listdetail->id.'&lang='.$_GET['lang']);  ?>" title="<?php echo $lang_appel_a_temoins["LireAppelATemoins"];?>" >
                                <img width="100" height="100" src="<? echo $photo; ?>" alt="<? echo $appel_temoins->username; ?>" class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<? echo $photo; ?>" sizes="(max-width: 70px) 100vw, 70px">
                            </a> 
</div></div>							
                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                    <h2 class="name parentsolo_pt_10"><? echo $listdetail->event_name; ?></h2>
                    <div class="text-box parentsolo_pt_10 parentsolo_pb_10">
                       <? echo $listdetail->event_desc; ?>
						</div>
                    <a class="username" href="<? echo JL::url('index.php?app=event&action=read&id='.$listdetail->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_event["LireAppelATemoins"];?>">
						<h6 class="parentsolo_text-right parentsolo_txt_clr parentsolo_txt_overflow"><? echo $listdetail->username; ?></h6>
					</a>
                </div>
            </div>
        </div>
		</div>
<?	
}
}						
						?>	
<div class="col-md-12 parentsolo_plr_0 pagenum">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" >
						<div class="col-md-3 text-left">								
									<? // page précédente

									if($search['page'] > 1) { ?>
										<a href="<? echo JL::url(SITE_URL.'/index.php?app=event&action=search&value='.$listdetail->event_name.'&page='.($search['page']-1).'&'.'&lang='.$_GET["lang"]); ?>" class="bouton envoyer" title="<?php echo $lang_event["PagePrecedente"];?>">&laquo; <?php echo $lang_event["PagePrecedente"];?></a>
									<? } ?>
								</div>
							<div class="col-md-6 text-center page_nav">
									<span class="orange"><?php echo $search['page_total'] == 1 ? $lang_event["Page"] : $lang_event["Pages"];?></span>:
									<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL.'/index.php?app=event&action=search&value='.$listdetail->event_name.'&page=1'.'&'.'&lang='.$_GET["lang"]); ?>" title="<?php 'Page'?>"><?php echo $lang_event["Debut"];?></a> ...<? }?>
									<?
										for($i=$debut; $i<=$fin; $i++) {
										
										?>
											 <a href="<? echo JL::url(SITE_URL.'/index.php?app=event&action=search&value='.$listdetail->event_name.'&page='.$i.'&'.'&lang='.$_GET["lang"]); ?>" title="<?php echo $lang_event["Page"];?> <? echo $i; ?>" <? if($i == $search['page']) { ?>class="active"<? } ?>><? echo $i; ?></a>
										<?
										}
									?>
									<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL.'/index.php?app=event&action=search&value='.$listdetail->event_name.'&page='.$search['page_total'].'&'.'&lang='.$_GET["lang"]); ?>" title="<?php echo $lang_event["Fin"];?> <? echo $search['page_total']; ?>"><?php echo $lang_event["Fin"];?></a><? }?> <i>(<? echo $search['result_total']; ?> <? echo $search['result_total'] > 1 ? ''.$lang_event["AppelsATemoins"].'' : ''.$lang_event["AppelATemoins"].''; ?>)</i>
									</div>
								    <div class="col-md-3 text-right">
									<? // page suivante
									if($search['page'] < $search['page_total']) { ?>
										<a href="<? echo JL::url(SITE_URL.'/index.php?app=event&action=search&value='.$listdetail->event_name.'&page='.($search['page']+1).'&'.'&lang='.$_GET["lang"]); ?>" class="bouton envoyer" title="<?php echo $lang_event["PageSuivante"];?>"><?php echo $lang_event["PageSuivante"];?> &raquo;</a>
									<? } ?>
								</div>
							</div>
						</div>
						</div></div>	
<?php
}
else{
?>
<div>
									<div align="middle" class="error">
										<?php echo $lang_event["AucuneAppelATemoins"];?>
									</div>
								</div>
								
<?
}
?>
 <div class="col-lg-12" style="text-align:right">
				  <input type="button" class="bouton envoyer parentsolo_btn" name="create" id="create" value="<?php echo $lang_event["create"]; ?>">
				  </div>						
<?
}
}
?>
 <div id="new_event" hidden>
 
 <form   id="formelement" name="formelement" method="post" enctype="multipart/form-data" action="app/app_event/dbevent.php">
  <div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre "><?php echo $lang_event["LireAppelATemoins"];?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
	
				<div class="col-md-8  col-md-offset-2 parentsolo_form_style" >
				
				
			
	  <h4 class=" parentsolo_pb_15 parentsolo_pt_15 parentsolo_sub_title text-center"><?php echo $lang_event["LireLAnnonce"];?></h4>
				<div class="row bottompadding">
				<div class="col-md-12">
                 <label  class="col-md-4" name="lbl_evt_name"><?php echo $lang_event["Nom"]; ?><span>*</span></label>
				<div class="col-md-8">
				<input type="text" name="txt_evt_name" class="msgtxt validation" id="txt_evt_name" required>
				</div>
				</div>
				</div>
<div class="row bottompadding">
<div class="col-md-12">
				<label class="col-md-4" name="lbl_evt_desc"><?php echo $lang_event["desc"]; ?><span>*</span></label>
				<div class="col-md-8">
				<textarea type="text" name="txt_evt_desc" style="width:100%;height:105px;" class="msgtxt validation" id="txt_evt_desc" required></textarea>
				</div>
</div>
</div>
<div class="row bottompadding">
<div class="col-md-12">
				<label class="col-md-4" name="lbl_evt_sdate"><?php echo $lang_event["sdate"]; ?><span>*</span></label>
				<div class="col-md-8">
				<input type="text" name="txt_evt_sdate" class="msgtxt datepicker validation" id="txt_evt_sdate" required>
				</div>
</div>
</div>
<div class="row bottompadding">
<div class="col-md-12">
				<label class="col-md-4" name="lbl_evt_edate"><?php echo $lang_event["edate"]; ?><span>*</span></label>
				<div class="col-md-8">
				<input type="text" name="txt_evt_edate"  class="msgtxt datepicker validation" id="txt_evt_edate" required>
				</div>
</div>
</div>
<div class="row bottompadding">
<div class="col-md-12">
				<label class="col-md-4" name="lbl_evt_logo"><?php echo $lang_event["logo"]; ?><span>*</span></label>
				<div class="col-md-8">
				<!--<label class="btn btn-default" style="padding: 2px 18px;border-width: 2px;">
				Browse&hellip; <input type="file" name="txt_evt_logo"   id="txt_evt_logo" class="validation"  accept="image/*" style="display: none;">	
				</label>-->
				<input type="file" name="txt_evt_logo"   id="txt_evt_logo" class="validation updateval">

				<input type="hidden" id="imageid" name="imageid">
				
				<img  id="event_img" class="img1" src="#">	
			<input type="hidden" name="rowid"  class="validation" id="rowid">
				<input type="hidden" name="userid"  class="" id="userid" value="<?php echo $user->id ?>" >		
				<p><small><?php echo $lang_event["GifPngJpg"];?></small></p>
				<div id='progress' hidden>
				<div class="col-md-6 parentsolo_txt_center">
								<div id="divFileProgressContainer"><div class="progressWrapper" id="divFileProgress" style="opacity: 1;    width: 265px;
    overflow: hidden;">
								<div class="progressContainer blue" style="border: solid 1px #CEE2F2;background-color: #f5fff0;padding:5px;"><a class="progressCancel" href="#" style="visibility: hidden;">
								</a><div class="progressName" id="progressName" style="font-size: 8pt;
    font-weight: 700;
    color: #555;
    width: 220px;
    height: 14px;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;"></div>
								<div class="progressBarStatus" style="margin-top: 2px;
    width: 265px;
    font-size: 7pt;
    font-family: Arial;
    text-align: left;
    white-space: nowrap;">Toutes les photos ont été réceptionnées.</div>
								<div class="progressBarComplete" style="width: 100%;height:1px;background-color: #00BFFF;;">
								 
								</div>
								</div></div></div>
							</div>
							</div>

				</div>
				
</div>
</div>
<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12">
							<h4><?php echo $lang_event["CodeDeVerification"];?></h4>
						</div>
						
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12 ">
							<?php echo $lang_event["VeuillezRecopierCodeVerification"];?> <strong class="verif" id='verif' ></strong>
						</div>
						
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12 parentsolo_txt_center">
						
						<div class="col-md-6 col-md-offset-3">
							<input type="text"  name="verif" class="verif validation updateval" id="verification"  required value="" placeholder="<?php echo $lang_event["CodeDeVerification"];?>" />
						</div>
					</div>
				</div>
				<div id="codeverify" style="color:red" hidden></div>

<div class="row bottompadding" style="text-align:center">
<a href="index.php?app=event&action=default&lang=en"><input type="submit"  name="save" id="save" value="<?php echo $lang_event["save"]; ?>" class="bouton envoyer parentsolo_btn" ></a>
<input type="submit"  id="update" name="update" accept="image/*" value="<?php echo $lang_event["update"]; ?>" class="bouton envoyer parentsolo_btn" hidden>
</div>
				</div>
				</form>
				</div>
				

<script>
(function($) {	
var userid;
var captcah;
$(document).ready(function(){
 
$('#listof').hide();
$('#new_event').hide();
userid=<?php echo $user->id ?>;
var lang="<?php echo $_GET["lang"]?>";
var codelang='<?php echo $lang_event["WarningCodeVerifIncorrect"]?>';
$( function() {
    $( ".datepicker" ).datepicker({
	dateFormat: 'dd-mm-yy'
	});
  } );
$('li>a').click(function() {
    $('li a').parent().removeClass("active");
    $(this).parent().addClass("active");
});
//initial value
$.ajax({
     type:"post",
	 url:"app/app_event/dbevent.php",
	 data:{'option':'common'},
	 success:function(data){
var value=$.parseJSON(data);	
var smaxdate=value[0][0];
var emaxdate=value[0][1];
var currectdate=value[0][2];
var eventname=value[0][3];
 captcah=value[0][4];
$('#verif').append(captcah);
//autocomplete
$( function() {  
    $( "#search_list" ).autocomplete({
      source: eventname,
	  select: function (event,ui) {
	   AutoCompleteSelectHandler(event,ui)
    }
	
	
    });
  } );
  //autocompleteselcthandler
  function AutoCompleteSelectHandler(event, ui)
{               
    var evtselectedObj = ui.item.value;              
    evtfunction(evtselectedObj)
}
  var selectevent;
  function evtfunction(evtselectedObj){
  selectevent=evtselectedObj;
  }
  $('#searchclick').click(function(){
  window.location.href='index.php?app=event&action=search&value='+selectevent+'&lang='+lang;
  })
if(emaxdate=='01-01-1970'){
$('#txt_evt_sdate').datepicker("option","minDate",currectdate);
$('#txt_evt_edate').datepicker("option","minDate",currectdate);

}
else{
$('#txt_evt_sdate').datepicker("option","minDate",emaxdate);
$('#txt_evt_edate').datepicker("option","minDate",emaxdate);
}

	 }
});
var imgsize;
$('#txt_evt_logo').change(function(e){
var filename1 = $('#txt_evt_logo').val();
$('.progressBarComplete').delay(3).fadeOut();
var ext = filename1.split('.').pop();
imgsize=e.target.files[0].size;
 
if(ext != "jpg" && ext != "png" && ext != "jpeg"
&& ext != "gif" ) {
alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
$('#save').attr('disabled','disabled');
$('#update').attr('disabled','disabled');
$('#progress').hide();
}
else{
if(imgsize > 1048576 ){
alert("Sorry, File Should not exceed 1 MB");
$('#save').attr('disabled','disabled');
$('#update').attr('disabled','disabled');
}
else{
var filename=e.target.files[0].name;
$('#progress').show();
$('#progressName').html(filename);
$('.progressBarComplete').delay(3).fadeOut();
}

}
});
$('#verification').change(function(){
var verification=$('#verification').val();
if(verification!=captcah){
$('#codeverify').show().text(codelang);
$('#save').attr('disabled','disabled');
$('#update').attr('disabled','disabled');
}
else{
$('#codeverify').hide();
}

});

//validation
$('.validation').change(function(){
var title=$('#txt_evt_name').val();
var desc=$('#txt_evt_desc').val();
var sdate=$('#txt_evt_sdate').val();
var edate=$('#txt_evt_edate').val();
var logo=$('#txt_evt_logo').val();
var extension = logo.split('.').pop();
var verification=$('#verification').val();
if(title!='' && desc!='' && sdate!='' && edate!='' && verification==captcah && imgsize < 1048576 &&(extension == "jpg" || extension == "png" || extension == "jpeg"
|| extension == "gif" )){
$('#save').removeAttr('disabled','disabled');

}
else{
//$('#save').attr('disabled','disabled');
//$('#codeverify').show().text(codelang);
}
});
$('.updateval').change(function(){
var logo=$('#txt_evt_logo').val();
var extension1 = logo.split('.').pop();
var imgval=$('#event_img').attr('src');
var extension = imgval.split('.').pop();
var verification=$('#verification').val();
if(verification==captcah && (extension == "jpg" || extension == "png" || extension == "jpeg"
|| extension == "gif" )&&(extension1=='' || extension1=="jpg" || extension == "png" || extension == "jpeg"
|| extension == "gif")){
$('#update').removeAttr('disabled','disabled');

}
else{
//$('#save').attr('disabled','disabled');
//$('#codeverify').show().text(codelang);
}
});
//creat event
$("#create").click(function(){
<?php
if(!$user->id){
?>
 window.location.href = "<?php echo JL::url('index.php?app=profil&action=inscription&lang='.$_GET['lang']); ?>"; 
<?php
}
else{
?>
$('#event_table').hide();
$('#hide_form').hide();
$('#create').hide();
$('#create').hide();
$('#update').hide();
$('#close').hide();
$('.evthead').hide();
$('#new_event').show();
$('#listof').hide();
$('.readcontent').hide();
$('.listmenu').hide();
$('.pagenum').hide();
$('.error').hide();
$('.mainhead').hide();
$('#event_img').hide();
$('#search_list').hide();
$('#searchclick').hide();
<?
}
?>
});
//information
                                 //SAVE CLICK//

                                //EDIT CLICK//
var editid;
$('.edit').click(function(){
var editvalue=$(this).attr('id');
var splitid=editvalue.split('_');
editid=splitid[1];
var updatefren=$('#updatefr').val();
$.ajax({
type:"post",
	 url:"app/app_event/dbevent.php",
	 data:{'option':'edit','editid':editid},
	 success:function(data){
	 var value=$.parseJSON(data);
	 var id=value[0][0];
	 var evtname=value[0][1];
	 var evtdesc=value[0][2];
	 var sdate=value[0][3];
	 var edate=value[0][4];
	 var photoname=value[0][5];
	 var photonamewdir=value[0][6];
	$('#txt_evt_name').val(evtname);
	$('#rowid').val(id);
$('#txt_evt_desc').val(evtdesc);
$('#txt_evt_sdate').val(sdate);
$('#txt_evt_edate').val(edate);
$('#txt_evt_logo').html(photonamewdir);
$('#imageid').val(photonamewdir);
$('#event_img').attr('src',photoname);
$('#event_table').hide();
$('#create').hide();
$('.mainhead').hide();
$('#save').hide();
$('#close').hide();
$('#new_event').show();
$('#update').show();
$('.readcontent').hide();

	 }
})

});
                                    //UPDATE CLICK//

                                        //DELETE CLICK//
$('.delete').click(function(){
var delvalue=$(this).attr('id');
var delsplitid=delvalue.split('_');
var delid=delsplitid[1];
$('.readcontent').hide();

$.ajax({
type:"post",
	 url:"app/app_event/dbevent.php",
	 data:{'option':'delete','delid':delid},
	 success:function(data){
	 if(data=1)
	 {
	 alert('Deleted Successfully');
	   // to reload the same page again
            window.location.href = "index.php?app=event&action=default&lang=en"; 
 }
	 }
});
});
});
})(jQuery);
</script>	
				
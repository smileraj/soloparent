<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $db, $user, $app, $action, $langue, $template;
	include("lang/app_mod.".$_GET['lang'].".php");
	
	
	if($user->id){


		// r&eacute;cup les stats du compte
		$query = "SELECT us.visite_total, IF(us.gold_limit_date > CURRENT_DATE, 1, 0) AS gold, us.fleur_new, us.message_new, IFNULL(COUNT(gu.user_id), 0) AS groupe_joined, us.points_total"
		." FROM user_stats AS us"
		." LEFT JOIN groupe_user AS gu ON gu.user_id = us.user_id"
		." WHERE us.user_id = '".$user->id."'"
		." GROUP BY us.user_id"
		." LIMIT 0,1"
		;
		$userStats = $db->loadObject($query);
		
		
		$photo = JL::userGetPhoto($userProfilMini->id, '109', 'profil', $userProfilMini->photo_defaut);
						
		// photo par d&eacute;faut
		if(!$photo) {
			$photo 			= SITE_URL.'/parentsolo/images/parent-solo-109-'.$userProfilMini->genre.'-'.$_GET['lang'].'.jpg';
			$noPhotoPopIn	= true;
		}
		?>
		<div class="nouveau">
			<h3><? echo $lang_mod["Nouveau"]; ?></h3>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align="right">
						<?
							if($userStats->message_new <= 0){
								echo $userStats->message_new.' '.$lang_mod["NouveauMessage"]; 
							}else{
						?>
								<a href="<? echo JL::url('index.php?app=message&action=inbox'.'&'.$langue); ?>" title="<?php echo $lang_mod["BoiteReception"];?>"><span style="font-weight:bold"><? echo $userStats->message_new; ?></span> <? echo $userStats->message_new > 1 ? ''.$lang_mod["NouveauxMessages"].'' : ''.$lang_mod["NouveauMessage"].''; ?></a>
						<?
							}
						?>
						<br />
						<?
							if($userStats->fleur_new <= 0){
								echo $userStats->fleur_new.' '.$lang_mod["NouvelleRose"]; 
							}else{
						?>
								<a href="<? echo JL::url('index.php?app=message&action=flowers'.'&'.$langue); ?>" title="<?php echo $lang_mod["BoiteReceptionRoses"];?>"><span style="font-weight:bold"><? echo $userStats->fleur_new; ?></span> <? echo $userStats->fleur_new > 1 ? ''.$lang_mod["NouvellesRoses"].'' : ''.$lang_mod["NouvelleRose"].''; ?></a>
						<?
							}
						?>
					<br />
						<?
							if($userStats->visite_total <= 0){
								echo $userStats->visite_total.' '.$lang_mod["Visite"]; 
							}else{
						?>
								<a href="<? echo JL::url('index.php?app=search&action=visits'.'&'.$langue); ?>" title="<? echo $lang_mod["VisiteursProfil"]; ?>"><span style="font-weight:bold"><? echo $userStats->visite_total; ?></span> <? echo $userStats->visite_total > 1 ? ''.$lang_mod["Visites"].'' : ''.$lang_mod["Visite"].''; ?></a>
						<?
							}
						?>
					<br />
						<?
							if($userStats->points_total <= 0){
								echo $userStats->points_total.' '.SoloFleur; 
							}else{
						?>
								<a href="<? echo JL::url('index.php?app=points&action=mespoints'.'&'.$langue); ?>" title="<?php echo $lang_mod["DetailPoints"];?>"><span style="font-weight:bold"><? echo $userStats->points_total; ?></span> SoloFleur<? echo $userStats->points_total > 0 ? 's' : ''; ?></a>
						<?
							}
						?>
					</td>
				</tr>
			</table>
		</div>
			<?
	}
	
	 /*
?>
	<div id="banner_gold" style="margin:0 0 5px 0;">
		<div class="small"><?php echo $lang_mod["Publicite"];?></div>
	<div id='skyscraper'>
<script type='text/javascript'>
if(setgbasync){googletag.cmd.push(function() { googletag.display('skyscraper'); });}else{googletag.display('skyscraper');}
</script>
</div>
		
	</div>
<?
*/
	if(!$user->id){
		
		// r&eacute;cup les stats du compte
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte, url_".$_GET['lang']." as url"
		." FROM box"
		." WHERE id = '7'"
		." LIMIT 0,1"
		;
		$box = $db->loadObject($query);
		
?>
		<div class="inscription_gratuite" style="margin:0 0 5px 0;">
			<a href="<? echo $box->url; ?>"><img src="<? echo $template; ?>/images/box/<? echo $box->id; ?>-<? echo $_GET['lang'];?>.gif" alt="<? echo $box->titre; ?>"/></a>
			<h3><a href="<? echo $box->url; ?>"><? echo $box->titre; ?></a></h3>
			<div><? echo $box->texte; ?></div>
		</div>
<?
	}
    else{  
?>
	<div class="partenaire_r res_cls_right_div">
        <?/*
		<div class="small"><?php echo $lang_mod["Partenaire"];?></div>
		<div id="partenaire_r" >
			<script type="text/javascript">
				swfobject.embedSWF("<? echo $template.'/images/pub_babybook_300x250.swf'; ?>", "partenaire_r", "300", "250", "8", "", { "width": "300", "height": "250" }, {"wmode":"transparent"}, {"id" : "partenaire_r"});
			</script>
		</div>     */?>
        
        <div id="partenaire_r"  >
            <div class="small"><?php echo $lang_mod["Partenaire"];?></div>
             <?
             if($_GET['lang']=="fr" || $_GET['lang']=="en"){
             ?>
                <img style="width: 300px" src="<? echo $template.'/images/Parentsolo.jpg'; ?>" alt="">
             <?    
             }
             else{
             ?>
                <img style="width: 300px" src="<? echo $template.'/images/Parentsolo-DE.jpg'; ?>" alt="">
             <?    
             }
             ?>
             <!--<div class="small"><?php echo $lang_mod["Publicite"];?></div>-->
        </div>
	</div>
<?
	}
    
?>
	
	<div id="banner_gold">
		<div class="small"><?php echo $lang_mod["Publicite"];?></div>
	    <div id='content'>

            <?
             if($_GET['lang']=="fr"){
            ?>
        
            <div id="div-ad-gds-464-2">

            <script type="text/javascript">

            document.write('<scr' + 'ipt type="text/javascript">gbcallslot464("div-ad-gds-464-2", "CLICK_URL_UNESC")</scr' + 'ipt>');

            </script>

            </div>

           <?
           }
           ?> 
            
            <?
             if($_GET['lang']=="de"){
            ?>
        
                <!-- 160x600, 300x600 -->
                <div id="div-ad-gds-522-2">
                <script type="text/javascript">
                gbcallslot522("div-ad-gds-522-2", "");
                </script>
                </div>

               
           <?
           }
           ?>  
           
            <?
             if($_GET['lang']=="en"){
            ?>
        
                 <!-- 160x600, 300x600 -->
                <div id="div-ad-gds-526-2">
                <script type="text/javascript">
                gbcallslot526("div-ad-gds-526-2", "");
                </script>
                </div>

            
           <?
           }
           ?>  
            
            
        </div>
	</div>  


	
	
	

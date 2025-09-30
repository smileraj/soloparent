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
			<h3><?php echo $lang_mod["Nouveau"]; ?></h3>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align="right">
						<?php 							if($userStats->message_new <= 0){
								echo $userStats->message_new.' '.$lang_mod["NouveauMessage"]; 
							}else{
						?>
								<a href="<?php echo JL::url('index.php?app=message&action=inbox'.'&'.$langue); ?>" title="<?php echo $lang_mod["BoiteReception"];?>"><span style="font-weight:bold"><?php echo $userStats->message_new; ?></span> <?php echo $userStats->message_new > 1 ? ''.$lang_mod["NouveauxMessages"].'' : ''.$lang_mod["NouveauMessage"].''; ?></a>
						<?php 							}
						?>
						<br />
						<?php 							if($userStats->fleur_new <= 0){
								echo $userStats->fleur_new.' '.$lang_mod["NouvelleRose"]; 
							}else{
						?>
								<a href="<?php echo JL::url('index.php?app=message&action=flowers'.'&'.$langue); ?>" title="<?php echo $lang_mod["BoiteReceptionRoses"];?>"><span style="font-weight:bold"><?php echo $userStats->fleur_new; ?></span> <?php echo $userStats->fleur_new > 1 ? ''.$lang_mod["NouvellesRoses"].'' : ''.$lang_mod["NouvelleRose"].''; ?></a>
						<?php 							}
						?>
					<br />
						<?php 							if($userStats->visite_total <= 0){
								echo $userStats->visite_total.' '.$lang_mod["Visite"]; 
							}else{
						?>
								<a href="<?php echo JL::url('index.php?app=search&action=visits'.'&'.$langue); ?>" title="<?php echo $lang_mod["VisiteursProfil"]; ?>"><span style="font-weight:bold"><?php echo $userStats->visite_total; ?></span> <?php echo $userStats->visite_total > 1 ? ''.$lang_mod["Visites"].'' : ''.$lang_mod["Visite"].''; ?></a>
						<?php 							}
						?>
					<br />
						<?php 							if($userStats->points_total <= 0){
								echo $userStats->points_total.' '.\SOLOFLEUR; 
							}else{
						?>
								<a href="<?php echo JL::url('index.php?app=points&action=mespoints'.'&'.$langue); ?>" title="<?php echo $lang_mod["DetailPoints"];?>"><span style="font-weight:bold"><?php echo $userStats->points_total; ?></span> SoloFleur<?php echo $userStats->points_total > 0 ? 's' : ''; ?></a>
						<?php 							}
						?>
					</td>
				</tr>
			</table>
		</div>
			<?php 	}
	
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
<?php */
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
			<a href="<?php echo $box->url; ?>"><img src="<?php echo $template; ?>/images/box/<?php echo $box->id; ?>-<?php echo $_GET['lang'];?>.gif" alt="<?php echo $box->titre; ?>"/></a>
			<h3><a href="<?php echo $box->url; ?>"><?php echo $box->titre; ?></a></h3>
			<div><?php echo $box->texte; ?></div>
		</div>
<?php 	}
    else{  
?>
	<div class="partenaire_r">
        <?php /*
		<div class="small"><?php echo $lang_mod["Partenaire"];?></div>
		<div id="partenaire_r" >
			<script type="text/javascript">
				swfobject.embedSWF("<?php echo $template.'/images/pub_babybook_300x250.swf'; ?>", "partenaire_r", "300", "250", "8", "", { "width": "300", "height": "250" }, {"wmode":"transparent"}, {"id" : "partenaire_r"});
			</script>
		</div>     */ ?>
        
        <div id="partenaire_r" >
            <div class="small"><?php echo $lang_mod["Partenaire"];?></div>
             <?php              if($_GET['lang']=="fr" || $_GET['lang']=="en"){
             ?>
                <img style="width: 300px" src="<?php echo $template.'/images/Parentsolo.jpeg'; ?>" alt="">
             <?php    
             }
             else{
             ?>
                <img style="width: 300px" src="<?php echo $template.'/images/Parentsolo-DE.jpeg'; ?>" alt="">
             <?php    
             }
             ?>
             <div class="small"><?php echo $lang_mod["Publicite"];?></div>
        </div>
	</div>
<?php 	}
    
?>
	
	<div id="banner_gold">
		<div class="small"><?php echo $lang_mod["Publicite"];?></div>
	    <div id='content'>

            <?php              if($_GET['lang']=="fr"){
            ?>
        
            <div id="div-ad-gds-464-2">

            <script type="text/javascript">

            document.write('<scr' + 'ipt type="text/javascript">gbcallslot464("div-ad-gds-464-2", "CLICK_URL_UNESC")</scr' + 'ipt>');

            </script>

            </div>

           <?php            }
           ?> 
            
            <?php              if($_GET['lang']=="de"){
            ?>
        
                <!-- 160x600, 300x600 -->
                <div id="div-ad-gds-522-2">
                <script type="text/javascript">
                gbcallslot522("div-ad-gds-522-2", "");
                </script>
                </div>

               
           <?php            }
           ?>  
           
            <?php              if($_GET['lang']=="en"){
            ?>
        
                 <!-- 160x600, 300x600 -->
                <div id="div-ad-gds-526-2">
                <script type="text/javascript">
                gbcallslot526("div-ad-gds-526-2", "");
                </script>
                </div>

            
           <?php            }
           ?>  
            
            
        </div>
	</div>  


	
	
	

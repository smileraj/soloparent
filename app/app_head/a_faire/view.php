<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class headView extends JLView {
	
		function __construct() {}
		
		// v&eacute;rifie si l'utilisateur veut se log ou est log, et renseigne la variable global $user
		function display() {
			include("lang/app_head.".$_GET['lang'].".php");
			global $db, $template;
			
			$navArr=[];
			$navString="";
			if (is_array($_GET)>1){
				foreach($_GET as $key => $value){
					if($key!='lang'){
						$navArr[]="$key=$value";
					}
				}
				$navString=implode("&",$navArr);
				$navString="&".$navString;
			}
		?>
			<div id="banner_top">
				<?php echo $lang_apphead["Hommes"];?> : <span class="homme">43%</span><br />
				<?php echo $lang_apphead["Femmes"];?> : <span class="femme">57%</span>
				<br/>
				<br />
				<a href="<?php echo $_SERVER["PHP_SELF"]."?lang=fr$navString";?>"><img src="<?php echo $template.'/images/grph_flags_fr_h20.jpg'; ?>" alt="fr" /></a> <a href="<?php echo $_SERVER["PHP_SELF"]."?lang=de$navString";?>"><img src="<?php echo $template.'/images/grph_flags_de_h20.jpg'; ?>" alt="de" /></a> <a href="<?php echo $_SERVER["PHP_SELF"]."?lang=en$navString";?>"><img src="<?php echo $template.'/images/grph_flags_en_h20.jpg'; ?>" alt="en" /></a>
			</div>
			
			<div id="banner_leader_board">
				
				<div class="small"><?php echo $lang_apphead["Publicite"];?></div>
			<?php 				if($_GET['lang']=="fr"){
			?>
					
				<!-- Start of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-MBR-T SIZE : 468x60,728x90 -->
					<script type="text/javascript">
						if(typeof(WLRCMD)=="undefined"){var WLRCMD="";}
						if(typeof(adlink_randomnumber)=="undefined"){var adlink_randomnumber=Math.floor(Math.random()*10000000000)}
						document.write('<scr'+'ipt language="JavaScript" src="http://ad.ch.doubleclick.net/adj/parentsolo.ex.ch/FR_Home_MBR_T_1x1;'+WLRCMD+';sex=,age=,kant=,plz=,kw=;sz=728x90;Tile=1;ord='+adlink_randomnumber+'?"><\/scr'+'ipt>');
					</script>
					<noscript>
						<a href="http://ad.ch.doubleclick.net/jump/parentsolo.ex.ch/FR_Home_MBR_T_1x1;sex=,age=,kant=,plz=,kw=;sz=728x90;Tile=1;ord=1234567890?" target="_blank">
							<img src="http://ad.ch.doubleclick.net/ad/parentsolo.ex.ch/FR_Home_MBR_T_1x1;sex=,age=,kant=,plz=,kw=;sz=728x90;Tile=1;ord=1234567890?" border="0" width="1" height="1">
						</a>
					</noscript>
					<!-- End of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-MBR-T SIZE : 468x60,728x90  -->
			<?php 				}elseif($_GET['lang']=="en"){
				
			?>
				<!-- Start of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-MBR-T SIZE : 468x60,728x90 -->
					<script type="text/javascript">
						if(typeof(WLRCMD)=="undefined"){var WLRCMD="";}
						if(typeof(adlink_randomnumber)=="undefined"){var adlink_randomnumber=Math.floor(Math.random()*10000000000)}
						document.write('<scr'+'ipt language="JavaScript" src="http://ad.ch.doubleclick.net/adj/parentsolo.ex.ch/FR_Home_MBR_T_1x1;'+WLRCMD+';sex=,age=,kant=,plz=,kw=;sz=728x90;Tile=1;ord='+adlink_randomnumber+'?"><\/scr'+'ipt>');
					</script>
					<noscript>
						<a href="http://ad.ch.doubleclick.net/jump/parentsolo.ex.ch/FR_Home_MBR_T_1x1;sex=,age=,kant=,plz=,kw=;sz=728x90;Tile=1;ord=1234567890?" target="_blank">
							<img src="http://ad.ch.doubleclick.net/ad/parentsolo.ex.ch/FR_Home_MBR_T_1x1;sex=,age=,kant=,plz=,kw=;sz=728x90;Tile=1;ord=1234567890?" border="0" width="1" height="1">
						</a>
					</noscript>
					<!-- End of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-FR-HOME-MBR-T SIZE : 468x60,728x90  -->
			<?php 				}else{
			?>
					<!-- Start of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-DE-HOME-MBR-T SIZE : 468x60,728x90 -->
					<script type="text/javascript">
						if(typeof(WLRCMD)=="undefined"){var WLRCMD="";}
						if(typeof(adlink_randomnumber)=="undefined"){var adlink_randomnumber=Math.floor(Math.random()*10000000000)}
					   document.write('<scr'+'ipt language="JavaScript" src="http://ad.ch.doubleclick.net/adj/parentsolo.ex.ch/DE_Home_MBR_T_1x1;'+WLRCMD+';sex=,age=,kant=,plz=,kw=;sz=728x90;Tile=1;ord='+adlink_randomnumber+'?"><\/scr'+'ipt>');
					</script>
					<noscript>
						<a href="http://ad.ch.doubleclick.net/jump/parentsolo.ex.ch/DE_Home_MBR_T_1x1;sex=,age=,kant=,plz=,kw=;sz=728x90;Tile=1;ord=1234567890?" target="_blank">
							<img src="http://ad.ch.doubleclick.net/ad/parentsolo.ex.ch/DE_Home_MBR_T_1x1;sex=,age=,kant=,plz=,kw=;sz=728x90;Tile=1;ord=1234567890?" border="0" width="1" height="1">
						</a>
					</noscript>
					<!-- End of Ad'LINK ADJ Tag for AdFRONT - Javascript Format - PARENTSOLO.EX.CH-DE-HOME-MBR-T SIZE : 468x60,728x90  -->
			<?php 				}
			?>
				
			</div>
			
			<div class="radio">
				<?php echo $lang_apphead["EcoutezLaRadioEnLive"];?><br /><br />
				<a class="lfm" href="javascript:windowOpen('LFM', 'http://www.lfm.ch/portail/player/player.php', '500', '200');"><img alt="Ecoutez Lausanne FM avec solocircl.com" src="<?php echo SITE_URL; ?>/parentsolo/images/radio-lfm.jpg"></a><a class="onefm" href="javascript:windowOpen('OneFM', 'http://www.onefm.ch/home/playerv2/player.php', '500', '320');"><img alt="Ecoutez One FM avec solocircl.com" src="<?php echo SITE_URL; ?>/parentsolo/images/radio-onefm.jpg"></a><br /><br />
			</div>
			
			<div class="twitter">
				<?php echo $lang_apphead["SuivezNous"];?><br /><br />
				<a target="_blank" href="http://www.twitter.com/parentsolo"><img src="<?php echo SITE_URL; ?>/parentsolo/images/twitter.jpg"></a>
			</div>
			
			<div class="header">
				<a href="<?php echo SITE_URL; ?>/index.php?lang=<?php echo $_GET['lang']; ?>" title="<?php echo SITE_DESCRIPTION; ?>" class="logo" onmouseover="show();">
					<img src="<?php echo SITE_URL; ?>/parentsolo/images/logo_<?php echo $_GET['lang']; ?>.jpg" alt="solocircl.com" />
				</a>
			</div>
		<?php 		
		}
		
	}
?>

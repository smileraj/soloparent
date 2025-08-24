<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	// chemin du template
	$template	= SITE_URL.'/'.SITE_TEMPLATE;
	

	global $app, $action, $user, $langue;

	// anti cache
	$version = 'v60';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" >


	<head>
		<?
			// module de gestion automatis&eacute;e des meta tags
			JL::loadMod('meta');
		?>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:400,100,300,300italic,400italic,500,500italic,600,600italic,700italic,700,800%7CLora:400,400italic,700,700italic">
		<link href="https://fonts.googleapis.com/css?family=Russo+One" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dancing+Script|Quicksand|Satisfy" rel="stylesheet">
		<link href="<? echo $template.'/'.SITE_TEMPLATE.'.css?'.$version; ?>" rel="stylesheet" type="text/css" />
		<link href="<? echo $template.'/'; ?>new_style/css/main.css" rel="stylesheet" type="text/css" />
		<link href="<? echo $template.'/'; ?>plugins.css" rel="stylesheet">		
<link rel="stylesheet" type="text/css" href="<? echo $template.'/'; ?>new_style/css/bootstrap-toggle.css">
<link rel="stylesheet" type="text/css" href="<? echo $template.'/'; ?>new_style/css/bootstrap-toggle.css">
<!--cropper-->
<link rel="stylesheet" href="<? echo SITE_URL; ?>/app/app_profil/js/cropper.min.css">
  <link rel="stylesheet" href="<? echo SITE_URL; ?>/app/app_profil/css/main.css">
  <!--cropper-->
  <script src="<? echo $template.'/'; ?>photovalidation/js/jquery-1.7.2.js"></script>
<style>
.Dboot-preloader {
            /* padding-top: 20%; */
            background-color: #fff;
            display: block;
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 999999999999999;
        }
		 .hidden {
            display: none!important;
            visibility: hidden!important;
        }
        .text-center {
            text-align: center;
        }
</style>
<script type="text/javascript" src="<? echo $template.'/'; ?>photovalidation/scripts/jquery.min.js"></script>
<script type="text/javascript" src="<? echo $template.'/'; ?>photovalidation/scripts/jquery.form.js"></script>
<?php if($user->id){ ?>
<style>
.lo_online{
	display:none !important;
}
.lo_offline{
	display:none !important;
}
</style>

<?php }
else{?>

<?php }?><!--end photo validation-->
		
		
		<?
			if($user->id){
				?>
				<script>
					jQuery.noConflict();
(function($) {
	$(document).ready(function() 
 {
	var useridval= document.getElementById('useridval').value;
	//alert(useridval);
	var sound_test=0;
	
	setInterval(function(){
	$.ajax({
	
					type:'post',
					url:'ajaxchatMessge.php',
					data:{'useridval':useridval,'cht_count':sound_test},
					success:function(data_val_ajax){
					var data_val = $.trim(data_val_ajax);
					// var data_success = data_val.split(",");
						//console.log(data_val);
						//console.log(data_success[1]);
						//if(data_val >= '0'){
						//if((sound_test != data_val) && (sound_test !='0')){
						if(data_val > 0){						
						if((sound_test != data_val) && (sound_test !=0)  && (data_val >0)){
						//alert('test1');
						$('#alert_box_chat').show();
						var audio = new Audio('sound/notify.mp3');
audio.play();
						}
						sound_test = data_val;
						$('#chatbox_val').show();	
						
						//$('#alert_box_chat').show();
						$(".result_data").html(data_val);
						
						$(".result1_data").html(data_val);
						
						
						$(".result_menu_data").html(data_val);
						
						
						//alert(sound_test);
						}
else {
$(".result_data").html(data_val);
						$(".result1_data").html(data_val);
						
							$(".result_menu_data").html('0');
						
$('#alert_box_chat').hide();
}	
						}
						
						
					

				})
	}, 1500);
	$('#alert_box_chat').hide();
	})
	})(jQuery);
				</script>
<link href="<? echo $template.'/'; ?>css/carousel/owl.carousel.css" rel="stylesheet">
<link href="<? echo $template.'/'; ?>css/carousel/owl.theme.css" rel="stylesheet">
<!-- Animation CSS -->
<link href="<? echo $template.'/'; ?>css/carousel/wedding-font-styles.css" rel="stylesheet">
		<?
			}
				?>
		<!--<link href="<? // echo $template.'/'.SITE_TEMPLATE.'_old(30-1-17).css?'.$version; ?>" rel="stylesheet" type="text/css" />-->
		<?php
			/*if($_GET['lang']!="fr"){
				?>
					<link href="<? echo $template.'/'.SITE_TEMPLATE.'.'.$_GET['lang'].'.css'; ?>" rel="stylesheet" type="text/css" />
				<?php
			}*/
		?>
		<link href="<? echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		
		<script type="text/javascript" src="<? echo SITE_URL; ?>/js/swfobject/swfobject.js"></script>
		<script type="text/javascript" src="<? echo SITE_URL; ?>/js/lightbox/lightbox.js"></script>
		<?
			if($app == 'home') {
			
		?>
				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/app_home.js?<? echo $version; ?>"></script>
				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/swfobject/swfobject.js"></script>
		<?
			
			} elseif($app == 'profil') {
			?>

				<? if(in_array($action, array('step2', 'step2submit', 'step5', 'step5submit'))) {
					/*if ($_GET["lang"]!="fr") {
						//echo $_GET["lang"];
						$jsUpExt = "-".$_GET["lang"];
					} else {
						$jsUpExt = "";
					}*/
					?>
					<script type="text/javascript" src="<? echo SITE_URL; ?>/js/swfupload<?php /*echo $jsUpExt;*/ ?>/swfupload.js"></script>
					<script type="text/javascript" src="<? echo SITE_URL; ?>/js/swfupload<?php /*echo $jsUpExt;*/ ?>/js/handlers.js?<? echo $version; ?>"></script>
					<link rel="stylesheet" type="text/css" href="<? echo SITE_URL; ?>/js/swfupload<?php /*echo $jsUpExt;*/ ?>/default.css">
				<? }?>

				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/app_profil.js?<? echo $version; ?>"></script>

				<? if($action == 'step6') { ?>
					<script type="text/javascript" src="<? echo SITE_URL; ?>/js/app_search.js"></script>
				<? } ?>

			<?
			} elseif($app == 'search') {
			?>
				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/app_search.js"></script>
			<?
			} elseif($app == 'message') {
			?>
				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/app_message.js?<? echo $version; ?>"></script>

			<?
			} elseif($app == 'redac') {
			?>
				
			<?
			} elseif($app == 'groupe' && in_array($action, array('edit', 'save'))) {
			?>
				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/app_groupe.js"></script>
				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/swfupload/swfupload.js"></script>
				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/swfupload/js/handlers.js?<? echo $version; ?>"></script>
				<link rel="stylesheet" type="text/css" href="<? echo SITE_URL; ?>/js/swfupload/default.css">
			<?
			}
			if($app == 'inviter'){
			?>
				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/app_inviter.js"></script>
			<?
			}
			//Head pub Goldbach
			/*if($_GET['lang']!="de"){
				?>
				<script type="text/javascript">
var setgbprotocoll = 'https:' == document.location.protocol;
var setgbprotocoll = (setgbprotocoll ? 'https:' : 'http:');
var setgbnuggn = "2137767787";
var setgbnuggsid = "37003039";
var setgbnuggtg = "RUNOFSITE";
if(typeof(setgbscriptloaded) == 'undefined'){setgbscriptloaded = false;}
if (!setgbscriptloaded){
document.write('<scr'+'ipt type="text/javascript" src='+setgbprotocoll+'//goldbach-targeting.ch/display/gbtargeting.js></scr'+'ipt>');
}
</script>

<script type='text/javascript'>
if(setgbasync){
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + 
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
}
else{
(function() {
var useSSL = 'https:' == document.location.protocol;
var src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
})();
}
</script>

<script type='text/javascript'>
if(setgbasync){
googletag.cmd.push(function() {
for (var key in setgbtargetingobj) {
googletag.pubads().setTargeting(key, setgbtargetingobj[key].toString());
}
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().collapseEmptyDivs();
googletag.enableServices();
});
}
else{
for (var key in setgbtargetingobj) {
googletag.pubads().setTargeting(key, setgbtargetingobj[key].toString());
}
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().enableSyncRendering();
googletag.enableServices();
}
</script>
				<?php
			}else{
				?>
				<script type="text/javascript">
var setgbprotocoll = 'https:' == document.location.protocol;
var setgbprotocoll = (setgbprotocoll ? 'https:' : 'http:');
var setgbnuggn = "2137767787";
var setgbnuggsid = "312300076";
var setgbnuggtg = "RUNOFSITE";
if(typeof(setgbscriptloaded) == 'undefined'){setgbscriptloaded = false;}
if (!setgbscriptloaded){
document.write('<scr'+'ipt type="text/javascript" src='+setgbprotocoll+'//goldbach-targeting.ch/display/gbtargeting.js></scr'+'ipt>');
}
</script>

<script type='text/javascript'>
if(setgbasync){
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + 
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
}
else{
(function() {
var useSSL = 'https:' == document.location.protocol;
var src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
})();
}
</script>

<script type='text/javascript'>
if(setgbasync){
googletag.cmd.push(function() {
for (var key in setgbtargetingobj) {
googletag.pubads().setTargeting(key, setgbtargetingobj[key].toString());
}
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().collapseEmptyDivs();
googletag.enableServices();
});
}
else{
for (var key in setgbtargetingobj) {
googletag.pubads().setTargeting(key, setgbtargetingobj[key].toString());
}
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().enableSyncRendering();
googletag.enableServices();
}
</script>
				<?php
			}  */
			
		
		?>
		<style>
		


.page-container.sidebar-collapsed {
  /* padding-right: 65px; */
  transition: all 100ms linear;
  transition-delay: 300ms;
}

.page-container.sidebar-collapsed-back {
  padding-right: 250px;
  transition: all 100ms linear;
}

.page-container.sidebar-collapsed .sidebar-menu {
  width: 65px;
  transition: all 100ms ease-in-out;
  transition-delay: 300ms;
}

.page-container.sidebar-collapsed-back .sidebar-menu {
  width: 100%;
  transition: all 100ms ease-in-out;
}

.page-container.sidebar-collapsed .sidebar-icon {
  transform: rotate(90deg);
  transition: all 300ms ease-in-out;
}

.page-container.sidebar-collapsed-back .sidebar-icon {
  transform: rotate(0deg);
  transition: all 300ms ease-in-out;
}

.page-container.sidebar-collapsed .logo {
  padding: 21px;
     height: 70px;
  box-sizing: border-box;
  transition: all 100ms ease-in-out;
  transition-delay: 300ms;
}

.page-container.sidebar-collapsed-back .logo {
  width: 100%;
  padding: 21px;
  height: 66px;
  box-sizing: border-box;
  transition: all 100ms ease-in-out;
}

.page-container.sidebar-collapsed #logo {
  opacity: 0;
  transition: all 200ms ease-in-out;
}

.page-container.sidebar-collapsed-back #logo {
  opacity: 1;
  transition: all 200ms ease-in-out;
  transition-delay: 300ms;
}

.page-container.sidebar-collapsed #menu span {
  opacity: 0;
  transition: all 50ms linear;
  display:none;
}

.page-container.sidebar-collapsed-back #menu span {
  opacity: 1;
  transition: all 200ms linear;
  transition-delay: 300ms;
  padding-top:3px;
}

.sidebar-menu {
  position: absolute; 
  /*margin-top: 40px;*/
  float: left;
  /*width: 280px;
   top: 19%;  bottom: 0;*/
  left: 0;

  background-color: #b90003;
  color: #aaabae;
  font-family: "Segoe UI";
  /* box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5); */
  z-index: 6;
}

#menu {
  list-style: none;
  margin: 0;
  padding: 0;
  margin-bottom: 20px;
}

#menu li {
  position: relative;
  margin: 0;
  font-size: 12px;
  border-bottom: 1px solid rgb(152, 9, 9);
  padding: 0;
}

#menu li ul {
  opacity: 0;
  height: 0px;
}

#menu li a {
	font-size:15px;
  font-style: normal;
  font-weight: 400;
  position: relative;
  display: block;
  padding: 15px 20px;
  color: #ffffff;
  white-space: nowrap;
  z-index: 6;
}

#menu li ul li a
{
	padding: 10px 20px;;
}

#menu li a:hover {
  color: #ffffff;
  background-color: #4a4a40;
  transition: color 250ms ease-in-out, background-color 250ms ease-in-out;
}

#menu li.active > a {
  background-color: #2b303a;
  color: #ffffff;
}

#menu ul li { background-color: #2b303a; }

#menu ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

#menu li ul {
  position: absolute;
  visibility: hidden;
  left: 100%;
  top: -1px;
  background-color: #2b303a;
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
  opacity: 0;
  transition: opacity 0.1s linear;
  border-top: 1px solid rgba(69, 74, 84, 0.7);
}

#menu li:hover > ul {
  visibility: visible;
  opacity: 1;
}

#menu li li ul {
  left: 100%;
  visibility: hidden;
  top: -1px;
  opacity: 0;
  transition: opacity 0.1s linear;
}

#menu li li:hover ul {
  visibility: visible;
  opacity: 1;
}

#menu li i
{
	font-size:20px;
}

#menu .fa {    margin-right: 10px;    margin-top: 4px; }

.sidebar-menu .logo a:hover{
	color: #ffffff !important;
    text-shadow: none;
}
.sidebar-menu .logo a{
	color: #ffffff !important;
    text-shadow: none;
}
.sidebar-icon {
  position: relative;
  float: right;
  border: 1px solid #fff;
  text-align: center;
  line-height: 1;
  font-size: 18px;
  padding: 6px 8px;
  border-radius: 3px;
  color: #fff;
  background-clip: padding-box;
  text-shadow: 4px 4px 6px rgba(0,0,0,0.4);
}
.chatbox_alert_stl{    top: 280px;
    right: 2px;
    position: fixed;
    z-index: 22;
    cursor: pointer;
    background: rgba(0, 0, 0, 0.85) !important;
    color: #fff;
    padding: 10px 15px;
    border-radius: 10px;}
.chat_box_alt{
top: 160px;right: 10px;position: fixed;z-index: 22;color: #fff;font-size: 13px;background: #949494 !important;padding: 10px 10px;border-radius: 5px;
}
@keyframes blink {
  50% {
    opacity: 0.0;
  }
}
@-webkit-keyframes blink {
  50% {
    opacity: 0.0;
  }
}
.result_data {
  animation: blink 1s step-start 0s infinite;
  -webkit-animation: blink 1s step-start 0s infinite;
}
.result1_data {
  animation: blink 1s step-start 0s infinite;
  -webkit-animation: blink 1s step-start 0s infinite;
}




.sidenav {
    height: 100%;
    width: 0;
       position: absolute;
    z-index:9999;
    top: 0;
    left: 0;
    background-color: #b90003;
   /*  overflow-x: hidden; */
    transition: 0.5s;
    padding-top: 60px;
}


.sidenav a:hover, .offcanvas a:focus{
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 25px;
    margin-left: 50px;
}

#main {
    transition: margin-left .5s;
    padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}/* 
   #loading_div{ /* padding-top: 20%; */
    background-color: #fff;
    display: block;
    width: 100%;
    height: 100%;
    position: fixed;
    z-index: 999999;
	}
	 #loading_div img{
	 margin-top:10%;
	 } */
</style>
<script language="javascript" type="text/javascript">
		var timerPaypal;	
function doHide(){
document.getElementById("loading_div").style.display = "none";
document.getElementById("cupid_status").style.display = "none";
//document.getElementById("btn_hide").style.display = "none";
document.getElementById("display_msg").style.display = "block";
clearInterval(timerPaypal);
}
function doShow()
{ 
//alert('test');
document.getElementById("loading_div").style.display = "block";
document.getElementById("display_msg").style.display = "none";
//document.getElementById("btn_hide").style.display = "none";
document.getElementById("cupid_status").style.display = "block";
timerPaypal =setInterval("doHide()", 9000);
};
function cupidShow()
{
//alert('divshow');
document.getElementById("loading_div").style.display = "block";
document.getElementById("loading_img").style.display = "none";
document.getElementById("cupid_status").style.display = "block";
timerPaypal=setInterval("doHide()", 5000);
};
				</script>
<meta name="google-site-verification" content="l0QZ_G3Cy1afhTJo_SOXnZzjl9RIUP6h44hl7exTDl4" />
</head>

	<body>
	<div class="Dboot-preloader text-center">
    <img src="<? echo SITE_URL;?>/chat2/templates/img/loader.gif" width="400"/>
</div>
<!-- Modal -->
  
    <?/*
		<script type="text/javascript">
			var WlWebsiteId="parentsolo.ch";
			var WlContentGroup="Default";
			var WlAC= true;
			document.write('<scr'+'ipt language="JavaScript" src="http://rc.ch.adlink.net/Tag/adlink/JS/Ch/'+WlWebsiteId+'/Gt.js"></scr'+'ipt>');
		</script>       */?>
		
		<div class="page" id="res_Menu_id" >
        
        <?
			//   JL::loadApp('mainlink');
		?>
        <div class="content">
            <div class="content_inner">
			<?  JL::loadApp('head'); ?>
				<div class="content1" <?php if($user->id){ echo "style='background: #b90003;'"; } ?>>
					<div class="<?php if($user->id){ } else { echo 'shell'; }?> text-left">
				<?
							if($user->id){
?>								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 hidden-xs  hidden-sm">
<?
						JL::loadMod('menu');
							
						?>
					</div>
					<div class="hidden-md  hidden-lg">
					<?
					JL::loadMod('menu');
					?>
					</div>
					<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 parentsolo_shadow">
						<div class="col-lg-9   parentsolo_pt_15">
						<?
						JL::loadMod('menu_offline');	
						?>
						<?
						JL::loadBody();
						?>
						</div>
					<?}
					else{
						?>
					<div class="col-lg-12 parentsolo_shadow">
						<div class="col-lg-9   parentsolo_pt_15">
						<?
						JL::loadMod('menu_offline');	
						?>
						<?
						JL::loadBody();
						?>
						</div>
					<?
					}
					?>
					<div class="col-lg-3"> 
						<? JL::loadMod('menu_right'); ?>
					</div>
					</div></div>
					<div style="clear:both"> </div>
				</div>
				<div class="hidden-xs">
				<div class="chatbox_alert_stl" id="alert_box_chat" style="display:none !important; text-align:center; background:rgba(0, 0, 0, 0) !important;    top: 160px;" onClick="windowOpen('ParentSoloChat','<? echo JL::url('index.php?app=chat&'.$langue); ?>','800px','600px');">
				<!--<embed src='sound/notify.mp3' autostart='false' width='0' height='0' id='sound1' enablejavascript='true'>-->
				
				<i class="fa fa-heart" style="font-size: 140px;    color: #f00;"></i><span style="position: absolute;  left: 60px;  margin-top: 45px;  z-index: 24;  font-size: 14px;"><span class="result_data"></span> 
<?php if($_GET["lang"]=="en"){ echo "New <br>Message"; }?>
				<?php if($_GET["lang"]=="de"){ echo " Neue <br>Nachricht";  }?>
				<?php if($_GET["lang"]=="fr") { echo "Nouveau <br>Message "; }?>
				</span>	</div></div>
				<div id="chatbox_val" style="display:none;"><div class="chatbox_alert_stl" onClick="windowOpen('ParentSoloChat','<? echo JL::url('index.php?app=chat&'.$langue); ?>','800px','600px');"><span class="result_data"></span> 
							<i class="fa fa-comments"></i></div></div>
							
						<div class="chatAlert" id="chatAlert1"  onClick="windowOpen('ParentSoloChat','<? echo JL::url('index.php?app=chat&'.$langue); ?>','800px','600px');"></div></div>
			<?			
						JL::loadMod('footer'); 
						
						if($user->id) {
							?>
							<form><input type="hidden" id="useridval" name="useridval" value="<?php echo $user->id;?>"/></form>
							
		</div></div></div></div></div>
		<script src="<? echo $template.'/'; ?>new_style/js/jquery.js"></script>
<?php if($app != 'profil') { ?>
<script src="<? echo $template.'/'; ?>photovalidation/bootstrap/dist/js/bootstrap.min.js"></script>	<?php }?>
    <script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/plugins/flipclock/flipclock.js"></script>
    <script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/plugins/smoothscroll/smoothscroll.js"></script>
   <!-- --photo validation---->
<script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/plugins/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/plugins/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/plugins/fancybox/jquery.fancybox.js"></script>
    <script src="<? echo $template.'/'; ?>new_style/js/plugins/owl/owl.carousel.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/custom.js"></script>
   <script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/bootstrap-toggle.js"></script>
<script>
    jQuery.noConflict();
(function($) {	
	$(window).load(function() {
        $('.Dboot-preloader').addClass('hidden');
    });
	})(jQuery);
</script>
						<script>
					
	function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
	jQuery.noConflict();
(function($) {	
$(".open_cls_main_1").click(function() {
if (toggle){	$(".open_cls_1").addClass("in");	}
else { $(".open_cls_1").removeClass("in"); }	 
 toggle = !toggle;
});

$(".open_cls_main_2").click(function() {
if (toggle){	$(".open_cls_2").addClass("in");	}
else { $(".open_cls_2").removeClass("in"); }	 
 toggle = !toggle;
});

$(".open_cls_main_3").click(function() {
if (toggle){	$(".open_cls_3").addClass("in");	}
else { $(".open_cls_3").removeClass("in"); }	 
 toggle = !toggle;
});

$(".open_cls_main_4").click(function() {
if (toggle){	$(".open_cls_4").addClass("in");	}
else { $(".open_cls_4").removeClass("in"); }	 
 toggle = !toggle;
});

$(".open_cls_main_5").click(function() {
if (toggle){	$(".open_cls_5").addClass("in");	}
else { $(".open_cls_5").removeClass("in"); }	 
 toggle = !toggle;
});

$(".open_cls_main_6").click(function() {
if (toggle){	$(".open_cls_6").addClass("in");	}
else { $(".open_cls_6").removeClass("in"); }	 
 toggle = !toggle;
});
$(".open_cls_main_7").click(function() {
if (toggle){	$(".open_cls_7").addClass("in");	}
else { $(".open_cls_7").removeClass("in"); }	 
 toggle = !toggle;
});
$(".open_cls_main_8").click(function() {
if (toggle){	$(".open_cls_8").addClass("in");	}
else { $(".open_cls_8").removeClass("in"); }	 
 toggle = !toggle;
});
							
							
							
						var w = window.innerWidth;
					
var toggle = true;
			 if (w < 992) { 
//alert('test');			 
$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");			 
			$(".sidebar-icon").click(function() {     
           
			if (toggle)
			{
			$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
				$("#menu span").css({"position":"absolute"});
			  }
			  else
			  {
$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
				setTimeout(function() {
				  $("#menu span").css({"position":"relative"});
				}, 400);
			  }
						
						toggle = !toggle;
		});
	}
	else { 
	$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
	$(".sidebar-icon").click(function() {                
			if (toggle)
			{
			// alert('hi');
			 $(".page-container").removeClass("sidebar-collapsed-back").addClass("sidebar-collapsed");
				$("#menu span").css({"position":"absolute"});
			  }
			  else
			  {			 
				$(".page-container").addClass("sidebar-collapsed-back").removeClass("sidebar-collapsed");
				setTimeout(function() {
				  $("#menu span").css({"position":"relative"});
				}, 400);
			  }
						
						toggle = !toggle;
		});
			
		}	

		
		})(jQuery);
	
</script>
						<script src="<? echo $template.'/'; ?>js/carousel/owl.carousel.js"></script>
    <!-- Theme JS -->
    <script>
	// Friend Section Carousel

jQuery.noConflict();
(function($) {
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
	$("#owl-demo").owlCarousel({
		items : 5,
		itemsDesktop : [1199,3],
		pagination:false,
		lazyload:false,
		navigation : true,
		navigationText : ["", ""],
	});
	})(jQuery);
	
	</script>
	    <?php if($app == 'profil') { ?>
			<script src="<? echo SITE_URL; ?>/app/app_profil/js/jquery-1.12.4.min.js"></script>
  <script src="<? echo SITE_URL; ?>/app/app_profil/js/bootstrap.min.js"></script>
  <script src="<? echo SITE_URL; ?>/app/app_profil/js/cropper.min.js"></script>
  <script src="<? echo SITE_URL; ?>/app/app_profil/js/main.js"></script>
<?php }?>

<!--end photo validation-->
<script type="text/javascript" src="<? echo SITE_URL; ?>/js/mootools.js?<? echo $version; ?>"></script>
						<?
					
					}
					
						// charge le module de message d'alerte de derneirs &eacute;v&eacute;nements(popin)
						JL::loadMod('popin_last_event');
						JL::loadMod('popin_chat_alert');
?><?
					if($app=='profil'&& $action=='finalisation'){
						if($_GET["lang"]=="fr" || $_GET["lang"]==""){
						?>
							<!-- Google Code for Inscription FR Conversion Page -->
							<script type="text/javascript">
							/* <![CDATA[ */
							var google_conversion_id = 965465621;
							var google_conversion_language = "fr";
							var google_conversion_format = "3";
							var google_conversion_color = "ffffff";
							var google_conversion_label = "uh5ECKOB-AgQlayvzAM";
							var google_remarketing_only = false;
							/* ]]> */
							</script>
							<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
							</script>
							<noscript>
							<div style="display:inline;">
							<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/965465621/?label=uh5ECKOB-AgQlayvzAM&amp;guid=ON&amp;script=0"/>
							</div>
							</noscript>
						<?
						}
						if($_GET["lang"]=="en"){
						?>
							<!-- Google Code for Inscription EN Conversion Page -->
							<script type="text/javascript">
							/* <![CDATA[ */
							var google_conversion_id = 965465621;
							var google_conversion_language = "en";
							var google_conversion_format = "3";
							var google_conversion_color = "ffffff";
							var google_conversion_label = "uh5ECKOB-AgQlayvzAM";
							var google_remarketing_only = false;
							/* ]]> */
							</script>
							<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
							</script>
							<noscript>
							<div style="display:inline;">
							<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/965465621/?label=uh5ECKOB-AgQlayvzAM&amp;guid=ON&amp;script=0"/>
							</div>
							</noscript>
						<?
						}
						if($_GET["lang"]=="de"){
						?>
							<!-- Google Code for Inscription DE Conversion Page -->
							<script type="text/javascript">
							/* <![CDATA[ */
							var google_conversion_id = 965465621;
							var google_conversion_language = "de";
							var google_conversion_format = "3";
							var google_conversion_color = "ffffff";
							var google_conversion_label = "uh5ECKOB-AgQlayvzAM";
							var google_remarketing_only = false;
							/* ]]> */
							</script>
							<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
							</script>
							<noscript>
							<div style="display:inline;">
							<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/965465621/?label=uh5ECKOB-AgQlayvzAM&amp;guid=ON&amp;script=0"/>
							</div>
							</noscript>
						<?
						}
					} 
				?>
						
						<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-17011285-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-17011285-1');
</script>
						
						<!--<script type="text/javascript">
						var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
						document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
						</script>
						<script type="text/javascript">
						try {
						//var pageTracker = _gat._getTracker("UA-6463477-2");
						var pageTracker = _gat._getTracker("UA-87597626-1");
						pageTracker._trackPageview();
						} catch(err) {}</script>-->
				</div>
		<?php if(!$user->id) {
							?>
			<script src="<? echo $template.'/'; ?>new_style/js/jquery.js"></script>
					<?php if($app != 'profil') { ?>
<script src="<? echo $template.'/'; ?>photovalidation/bootstrap/dist/js/bootstrap.min.js"></script>	<?php }?>
					<script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/plugins/flipclock/flipclock.js"></script>
					<script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/plugins/smoothscroll/smoothscroll.js"></script>
    
    <!-- REVOLUTION JS FILES -->
    <script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/plugins/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/plugins/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/plugins/fancybox/jquery.fancybox.js"></script>
    <script src="<? echo $template.'/'; ?>new_style/js/plugins/owl/owl.carousel.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="<? echo $template.'/'; ?>new_style/js/custom.js"></script>
   <script>
    jQuery.noConflict();
(function($) {	
	$(window).load(function() {
        $('.Dboot-preloader').addClass('hidden');
    });
	})(jQuery);
</script>
   <script>
				jQuery.noConflict();
(function($) {
	
var toggle = true;
            
$(".sidebar-icon").click(function() {                
  if (toggle)
  {
    $(".page-container").addClass("sidebar-collapsed-back").removeClass("sidebar-collapsed");
    $("#menu span").css({"position":"absolute"});
	
  }
  else
  {
    $(".page-container").removeClass("sidebar-collapsed-back").addClass("sidebar-collapsed");
    setTimeout(function() {
      $("#menu span").css({"position":"relative"});
	  
    }, 400);
  }
                
                toggle = !toggle;
            });
})(jQuery);
</script>


<?php if($app == 'profil') { ?>
			<script src="<? echo SITE_URL; ?>/app/app_profil/js/jquery-1.12.4.min.js"></script>
  <script src="<? echo SITE_URL; ?>/app/app_profil/js/bootstrap.min.js"></script>
  <script src="<? echo SITE_URL; ?>/app/app_profil/js/cropper.min.js"></script>      
<?php }?>
<?php  if($action == 'step2')  { ?>
<script src="<? echo SITE_URL; ?>/app/app_profil/js/reg_main.js"></script>      
<?php }?>
<?php if($action == 'step5') { ?>
<script src="<? echo SITE_URL; ?>/app/app_profil/js/main_chiled.js"></script>
<?php } ?>
			
<script type="text/javascript" src="<? echo SITE_URL; ?>/js/mootools.js?<? echo $version; ?>"></script>
<?php } ?>
	</body>

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
	<link href="<? echo $template.'/'.SITE_TEMPLATE.'_profil.css?'.$version; ?>" rel="stylesheet" type="text/css" />
			<!--<link href="<? echo $template.'/'; ?>new_style/css/bootstrap.css" rel="stylesheet" type="text/css" />-->
		<link href="<? echo $template.'/'; ?>new_style/css/reset.css" rel="stylesheet" type="text/css" />
		<link href="<? echo $template.'/'; ?>new_style/css/color.css" rel="stylesheet" type="text/css" />
		<link href="<? echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		
		
		<!--home page style-->
		<link href="<? echo $template.'/'.SITE_TEMPLATE.'.css?'.$version; ?>" rel="stylesheet" type="text/css" />
		<link href="<? echo $template.'/'; ?>new_style/css/main.css" rel="stylesheet" type="text/css" />
		<link href="<? echo $template.'/'; ?>plugins.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<? echo $template.'/'; ?>new_style/css/bootstrap-toggle.css">
		
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
	var chat_test=1;
	/* function fn(){
	
	setInterval(function(){ $('#alert_box_chat').hide(); }, 3000);	  
} */
	setInterval(function(){
	$.ajax({
					type:'post',
					url:'ajaxchatMessge.php',
					data:{'useridval':useridval,'cht_count':sound_test},
					success:function(data_val_ajax){
					var data_val = $.trim(data_val_ajax);
					
						if(data_val >= '0'){
						
						if((sound_test != data_val) && (sound_test !='0')){
						//alert('test1');
						$('#alert_box_chat').show();
						var audio = new Audio('sound/notify.mp3');
						audio.play();
						}						
						sound_test = data_val;
						$('#chatbox_val').show();	
						
						//$('#alert_box_chat').show();
						$(".result_data").html(data_val);
						$(".result_menu_data").html(data_val);
						$(".result1_data").html(data_val);
					//	console.log(data_val);
						}
else {
$(".result_menu_data").html('0');
console.log(data_val);
$(".result_data").html(data_val);
						$(".result1_data").html(data_val);
$('#alert_box_chat').hide();
}	
					}
					})
	}, 1500);	
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
		<!--end home page style-->
		
		<link href="<? echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		
		<!--<script type="text/javascript" src="<? echo SITE_URL; ?>/js/mootools.js?<? echo $version; ?>"></script>-->
		<script type="text/javascript" src="<? echo SITE_URL; ?>/js/swfobject/swfobject.js"></script>
		<script type="text/javascript" src="<? echo SITE_URL; ?>/js/lightbox/lightbox.js"></script>
		<?
			if($app == 'profil') {
			?>

				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/app_profil.js?<? echo $version; ?>"></script>

			<?
			}
			?>
					<?
                    
			//Head pub Goldbach
			/*if($_GET['lang']!="de"){
				?>
				<!-- nugg.ad tag to insert at the beginning of page BEFORE Google Publisher tags - Don't change anything below--->



<script type="text/javascript">

var nuggprof ="";
var nuggrid= encodeURIComponent(top.location.href);

var nuggtg= encodeURIComponent("RUNOFSITE");

document.write('<scr'+'ipt type=\"text/javascript\" src=\"http://goldbach.nuggad.net/rc?nuggn=2137767787&nuggsid=37003039&nuggrid='+nuggrid+'&nuggtg='+nuggtg+'"><\/scr'+'ipt>');
</script>



<!-- Google publisher tag header section to insert into HEADER of page - Don't change anything below--->


<script type='text/javascript'>
(function() {
var useSSL = 'https:' == document.location.protocol;
var src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
})();
</script>

<script type='text/javascript'>
googletag.cmd.push(function () {
                for (var key in NUGGarr) {
                googletag.pubads().setTargeting(key, NUGGarr[key].toString());
                }
});
googletag.defineSlot('/8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', [[728, 90], [728, 300]], 'leaderboard').addService(googletag.pubads())
.setTargeting("gender", "")
.setTargeting("age", "")
.setTargeting("plz", "")
.setTargeting("kant", "")
.setTargeting("remnant", ["1", "2", "3", "4", "5"]);
googletag.defineSlot('/8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', [[160, 600], [300, 600]], 'wideskyscraper').addService(googletag.pubads())
.setTargeting("remnant", ["1", "2", "3", "4", "5"]);
googletag.defineSlot('/8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', [300, 250], 'mediumrectangle').addService(googletag.pubads())
.setTargeting("remnant", ["1", "2", "3", "4", "5"]);
googletag.defineOutOfPageSlot('/8373/CH/Helvetica-Media/CH_Parentsolo.ch_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().enableSyncRendering();
googletag.pubads().enableSingleRequest();
googletag.enableServices();
</script>
			<?
			}else{
				?>
				<!-- nugg.ad tag to insert at the beginning of page BEFORE Google Publisher tags - Don't change anything below--->



<script type="text/javascript">

var nuggprof ="";

var nuggrid= encodeURIComponent(top.location.href);

var nuggtg= encodeURIComponent("RUNOFSITE");
document.write('<scr'+'ipt type=\"text/javascript\" src=\"http://goldbach.nuggad.net/rc?nuggn=2137767787&nuggsid=312300076&nuggrid='+nuggrid+'&nuggtg='+nuggtg+'"><\/scr'+'ipt>');

</script>



<!-- Google publisher tag header section to insert into HEADER of page - Don't change anything below--->


<script type='text/javascript'>
(function() {
var useSSL = 'https:' == document.location.protocol;
var src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
})();
</script>

<script type='text/javascript'>
googletag.cmd.push(function () {
                for (var key in NUGGarr) {
                googletag.pubads().setTargeting(key, NUGGarr[key].toString());
                }
});
googletag.defineSlot('/8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', [[728, 90], [728, 300]], 'leaderboard').addService(googletag.pubads())
.setTargeting("gender", "")
.setTargeting("age", "")
.setTargeting("plz", "")
.setTargeting("kant", "")
.setTargeting("remnant", ["1", "2", "3", "4", "5"]);
googletag.defineSlot('/8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', [[160, 600], [300, 600]], 'wideskyscraper').addService(googletag.pubads())
.setTargeting("remnant", ["1", "2", "3", "4", "5"]);
googletag.defineSlot('/8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', [300, 250], 'mediumrectangle').addService(googletag.pubads())
.setTargeting("remnant", ["1", "2", "3", "4", "5"]);
googletag.defineOutOfPageSlot('/8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().enableSyncRendering();
googletag.pubads().enableSingleRequest();
googletag.enableServices();
</script>

				<?
			} */
			
		
		?>
<meta name="google-site-verification" content="l0QZ_G3Cy1afhTJo_SOXnZzjl9RIUP6h44hl7exTDl4" />
</head>

	<body>
	<div class="Dboot-preloader text-center">
    <img src="<? echo SITE_URL;?>/chat2/templates/img/loader.gif" width="400"/>
</div>
    <?/*
		<script type="text/javascript">
			var WlWebsiteId="parentsolo.ch";
			var WlContentGroup="Default";
			var WlAC= true;
			document.write('<scr'+'ipt language="JavaScript" src="http://rc.ch.adlink.net/Tag/adlink/JS/Ch/'+WlWebsiteId+'/Gt.js"></scr'+'ipt>');
		</script>
     */?>   
        
		<!--<div class="body" id="top">-->
		<!--home style--><div  class="page" id="res_Menu_id" >
		
		<div class="content">
            <div class="content_inner">
			<? 
				JL::loadApp('head');
			?>
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
							// charge l'application demand&eacute;e
							JL::loadBody();
						
						?>
						</div>
					<? }
					else{
						?>
					<div class="col-lg-12 parentsolo_shadow">
						<div class="col-lg-9   parentsolo_pt_15">
						<?
							
						
							JL::loadMod('menu_offline');	
						?>
							
						<?
							// charge l'application demand&eacute;e
							JL::loadBody();
						
						?>
						</div>
					<?
					}
					?>

			

					<div class="col-lg-3"> 
						<? JL::loadMod('menu_right'); ?>
					</div>
					</div> 
</div>
					<div style="clear:both"> </div>
				</div>
				<div class="hidden-xs">
				<div class="chatbox_alert_stl" id="alert_box_chat" style="display:none !important; text-align:center; background:rgba(0, 0, 0, 0) !important;    top: 160px;" onClick="windowOpen('ParentSoloChat','<? echo JL::url('index.php?app=chat&'.$langue); ?>','800px','600px');">
				<!--<embed src='sound/notify.mp3' autostart='false' width='0' height='0' id='sound1' enablejavascript='true'>-->
				
				<i class="fa fa-heart" style="font-size: 140px;    color: #f00;"></i><span style="position: absolute;  left: 60px;  margin-top: 45px;  z-index: 24;  font-size: 14px;"><span class="result_data"></span> 
				<?php if($_GET["lang"]=="en"){ echo "New <br>Message"; }?>
				<?php if($_GET["lang"]=="de"){ echo " Nieuw <br>ericht";  }?>
				<?php if($_GET["lang"]=="fr") { echo "Nouveau <br>Message "; }?>
				</span>	</div></div>
				<div id="chatbox_val" style="display:none;"><div class="chatbox_alert_stl" onClick="windowOpen('ParentSoloChat','<? echo JL::url('index.php?app=chat&'.$langue); ?>','800px','600px');"><span class="result_data"></span> 
							<i class="fa fa-comments"></i></div></div>
							
						<div class="chatAlert" id="chatAlert1"  onClick="windowOpen('ParentSoloChat','<? echo JL::url('index.php?app=chat&'.$langue); ?>','800px','600px');"></div></div>
			<?			
						JL::loadMod('footer'); 
						
						JL::loadMod('popin_last_event');
						JL::loadMod('popin_chat_alert');
						if($user->id) {
							?>
							<form><input type="hidden" id="useridval" name="useridval" value="<?php echo $user->id;?>"/></form>
							
		</div></div></div></div>

		
							
   
   
   
  					
<script src="<? echo $template.'/'; ?>new_style/js/jquery.js"></script>
<script src="<? echo $template.'/'; ?>photovalidation/bootstrap/dist/js/bootstrap.min.js"></script>		
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
	/*	

 *var toggle = true;
            
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
            });*/
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
	<script type="text/javascript">
				var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
				document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
				</script>
				<script type="text/javascript">
				try {
				var pageTracker = _gat._getTracker("UA-6463477-2");
				pageTracker._trackPageview();
				} catch(err) {}</script>
		
		</div>
	   

<!--end photo validation-->
<script type="text/javascript" src="<? echo SITE_URL; ?>/js/mootools.js?<? echo $version; ?>"></script>
						<?
					// charge le module de message d'alerte de derneirs &eacute;v&eacute;nements(popin)
						
					}
					
						
?>
		
		<!--end home style-->
		
		
		
		
		
			<? 
				
				// charge l'application demand&eacute;e
				//JL::loadBody();
				
				
			?>

				


	</body>
</html>

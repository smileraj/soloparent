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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
<head>
		<?php 			// module de gestion automatis&eacute;e des meta tags
			JL::loadMod('meta');
		?>	
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="<?php echo $template.'/'.SITE_TEMPLATE.'.css?'.$version; ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo $template.'/'; ?>css/loader.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $template.'/'; ?>new_style/css/main.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="js/check/jquery.tzCheckbox/jquery.tzCheckbox.css" />
		<?php
			/*if($_GET['lang']!="fr"){
				?>
					<link href="<?php echo $template.'/'.SITE_TEMPLATE.'.'.$_GET['lang'].'.css'; ?>" rel="stylesheet" type="text/css" />
				<?php
			}*/
		?><link rel="stylesheet" href="js/check/radios-to-slider.css" type="text/css" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:400,100,300,300italic,400italic,500,500italic,600,600italic,700italic,700,800%7CLora:400,400italic,700,700italic">
		<link href="https://fonts.googleapis.com/css?family=Russo+One" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dancing+Script|Quicksand|Satisfy" rel="stylesheet">
		<link href="<?php echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<!-- <script src="js/check/jquery-1.10.2.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/lightbox/lightbox.js"></script>		
			
		<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfobject/swfobject.js"></script>
		<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/lightbox/lightbox.js"></script>
		<?php 			if($app == 'home') {
			
		?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_home.js?<?php echo $version; ?>"></script>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfobject/swfobject.js"></script>
		<?php 			
			} elseif($app == 'profil') {
			?>

				<?php if(in_array($action, ['step2', 'step2submit', 'step7', 'step7submit'])) {
					/*if ($_GET["lang"]!="fr") {
						//echo $_GET["lang"];
						$jsUpExt = "-".$_GET["lang"];
					} else {
						$jsUpExt = "";
					}*/
					?>
					<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload<?php /*echo $jsUpExt;*/ ?>/swfupload.js"></script>
					<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload<?php /*echo $jsUpExt;*/ ?>/js/handlers.js?<?php echo $version; ?>"></script>
					<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/js/swfupload<?php /*echo $jsUpExt;*/ ?>/default.css">
				<?php }?>

				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_profil.js?<?php echo $version; ?>"></script>

				<?php if($action == 'step6') { ?>
					<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_search.js"></script>
				<?php } ?>

			<?php 			} elseif($app == 'search') {
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_search.js"></script>
			<?php 			} elseif($app == 'message') {
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_message.js?<?php echo $version; ?>"></script>

			<?php 			} elseif($app == 'redac') {
			?>
				
			<?php 			} elseif($app == 'groupe' && in_array($action, ['edit', 'save'])) {
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_groupe.js"></script>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload/swfupload.js"></script>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload/js/handlers.js?<?php echo $version; ?>"></script>
				<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/js/swfupload/default.css">
			<?php 			}
			if($app == 'inviter'){
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_inviter.js"></script>
			<?php 			}
		?>
		<?php 			//Head pub Goldbach
			 /*if($_GET['lang']=="de") {
               
				?>
<script type="text/javascript">
var setgbprotocoll = 'https:' == document.location.protocol;
var setgbprotocoll = (setgbprotocoll ? 'https:' : 'http:');
var setgbnuggn = "2137767787";
var setgbnuggsid = "312300076";
var setgbnuggtg = "HOME";
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
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/Homepage/DE_Homepage_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/Homepage/DE_Homepage_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/Homepage/DE_Homepage_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/Homepage/DE_Homepage_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().collapseEmptyDivs();
googletag.enableServices();
});
}
else{
for (var key in setgbtargetingobj) {
googletag.pubads().setTargeting(key, setgbtargetingobj[key].toString());
}
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/Homepage/DE_Homepage_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/Homepage/DE_Homepage_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/Homepage/DE_Homepage_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/Homepage/DE_Homepage_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().enableSyncRendering();
googletag.enableServices();
}
</script>
				<?php 			}else{
			?>
				<script type="text/javascript">
var setgbprotocoll = 'https:' == document.location.protocol;
var setgbprotocoll = (setgbprotocoll ? 'https:' : 'http:');
var setgbnuggn = "2137767787";
var setgbnuggsid = "37003039";
var setgbnuggtg = "HOME";
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
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/Homepage/FR_Homepage_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/Homepage/FR_Homepage_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/Homepage/FR_Homepage_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/Homepage/FR_Homepage_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().collapseEmptyDivs();
googletag.enableServices();
});
}
else{
for (var key in setgbtargetingobj) {
googletag.pubads().setTargeting(key, setgbtargetingobj[key].toString());
}
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/Homepage/FR_Homepage_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/Homepage/FR_Homepage_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/Homepage/FR_Homepage_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/Homepage/FR_Homepage_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().enableSyncRendering();
googletag.enableServices();
}
</script>
<?php     
			} */ 
		?>
       
<meta name="google-site-verification" content="l0QZ_G3Cy1afhTJo_SOXnZzjl9RIUP6h44hl7exTDl4" />
</head>

	<body>
	
<div class="loader" id="page-loader"> 
  <div class="loading-wrapper">
    <div class="loader-heart loader-heart1"></div>
    <div class="loader-heart loader-heart2"></div>
    <div class="loader-heart loader-heart3"></div>
  </div>   
</div>	
	<div class="page">
    
        <div class="content">
            <div class="content_inner">
               <?php
			   JL::loadApp('head');
			   JL::loadBody();
			   JL::loadMod('footer'); 
			   ?>
             </div>
        </div>
    </div>
       <?php /*
		<script type="text/javascript">
			var WlWebsiteId="solocircl.com";
			var WlContentGroup="Default";
			var WlAC= true;
			document.write('<scr'+'ipt language="JavaScript" src="http://rc.ch.adlink.net/Tag/adlink/JS/Ch/'+WlWebsiteId+'/Gt.js"></scr'+'ipt>');
		</script>   */ ?>
        
	<!--<div class="body " id="top">-->			
	<!--data url new theme style-->

	<script src="js/check/jquery.radios-to-slider.js"></script>
	<script>jQuery.noConflict();
(function($) {
	$(document).ready(function() {
    $("#radios").radiosToSlider();
    $("#radios1").radiosToSlider();
});
})(jQuery);</script>
<script src="js/check/jquery.tzCheckbox/jquery.tzCheckbox.js"></script>
<script>
jQuery.noConflict();
(function($) {
	$(document).ready(function(){
	
	$('input[type=checkbox]').tzCheckbox({labels:['Enable','Disable']});
});
})(jQuery);
</script>
	<!--<script src="<?php echo $template.'/'; ?>js/js/commonjs.js"></script>-->   
	<script src="<?php echo $template.'/'; ?>js/main.js"></script>
	<script src="<?php echo $template.'/'; ?>js/modernizr.custom.17475.js"></script>
    <script type="text/javascript" src="<?php echo $template.'/'; ?>js/jquery.elastislide.js"></script>	
	 <script src="<?php echo $template.'/'; ?>new_style/js/jquery.js"></script>
	  <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/flipclock/flipclock.js"></script>
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/smoothscroll/smoothscroll.js"></script>
    <!-- REVOLUTION JS FILES -->
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/fancybox/jquery.fancybox.js"></script>
    <script src="<?php echo $template.'/'; ?>new_style/js/plugins/owl/owl.carousel.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/custom.js"></script>
   <!-- <script src="<?php echo $template.'/'; ?>js/core.min.js"></script> -->
    <script src="<?php echo $template.'/'; ?>js/script.js"></script>
				<script>
jQuery.noConflict();
(function($) {
	window.addEventListener("scroll", function(event) {
   var top = this.scrollY;
    var   verticalScroll = document.querySelector(".verticalScroll");
   // alert(top);
   
   if(top > 600 ){
	
  $(".Login_right1").removeClass("parentsolo_login_width-back").addClass("parentsolo_login_width");
   }
   else{
 $(".Login_right1").addClass("parentsolo_login_width-back").removeClass("parentsolo_login_width");
   }
  // horizontalScroll.innerHTML = "Scroll X: " + left + "px";
     //verticalScroll.innerHTML = "Scroll Y: " + top + "px";
  
}, false);
	})(jQuery);
</script>
				<script>
					;(function($, window, document, undefined){

	// our plugin constructor
	var OnePageNav = function(elem, options){
		this.elem = elem;
		this.$elem = $(elem);
		this.options = options;
		this.metadata = this.$elem.data('plugin-options');
		this.$win = $(window);
		this.sections = {};
		this.didScroll = false;
		this.$doc = $(document);
		this.docHeight = this.$doc.height();
	};



	OnePageNav.defaults = OnePageNav.prototype.defaults;

	$.fn.onePageNav = function(options) {
		return this.each(function() {
			new OnePageNav(this, options).init();
		});
	};

})( jQuery, window , document );
(function ($) {

$(document).ready(function () {
        /*----------------------------------------------------
          LIVE CHAT FUNCTION
        ----------------------------------------------------*/
        var $live_chat = $('.live-chat'),
            $chat_header = $('.live-chat .header'),
            $chat = $('.chat'),
            $chat_close = $('.chat-close'),
            $header_chat_btn = $('.top-header .top-button a.customer-support'),
            $message_counter = $('.header span.chat-message-counter');

        //when header clicked slide in/out the whole chat
        $chat_header.on('click', function () {
            if ($live_chat.hasClass('collapsed')) {
                $live_chat.removeClass('collapsed').addClass('expanded');
            } else {
                $live_chat.removeClass('expanded').addClass('collapsed');
            }

        });

        //when "chat close" button clicked fade out the whole chat section
        $chat_close.on('click', function () {
            $live_chat.removeClass('collapsed expanded').addClass('closed');
        });



        //show & hide message counter
        $chat_header.on('click', function () {
            if ($live_chat.hasClass('collapsed')) {
                $message_counter.show(600);
            } else if ($live_chat.hasClass('expanded')) {
                $message_counter.hide(600);
            }
        });

        //when button clicked open live chat
        $header_chat_btn.on('click', function () {
            $live_chat.removeClass('closed');
        });
	}); //end of document ready function


})(jQuery);

jQuery.noConflict();
(function($) {
var num = 50; //number of pixels before modifying styles

$(window).bind('scroll', function () {
    if ($(window).scrollTop() > num) {
        $('.menubar_fixed').addClass('fixed');
    } else {
        $('.menubar_fixed').removeClass('fixed');
    }
});
})(jQuery);
				</script>
				
				
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/mootools.js?<?php echo $version; ?>"></script>
	</body>

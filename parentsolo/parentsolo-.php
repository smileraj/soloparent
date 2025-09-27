<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');
	
	// chemin du template
	$template	= SITE_URL.'/'.SITE_TEMPLATE;
	
	global $app, $action, $user;
	
	// anti cache
	$version = 'v60';
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<?php 			// module de gestion automatis&eacute;e des meta tags
			JL::loadMod('meta');
		?>
		<link href="<?php echo $template.'/'.SITE_TEMPLATE.'.css?'.$version; ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/mootools.js?<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfobject/swfobject.js"></script>
		
		<?php 			if($app == 'home') {
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_home.js?<?php echo $version; ?>"></script>
			<?php 			} elseif($app == 'profil') {
			?>
				
				<?php if(in_array($action, array('step2', 'step2submit', 'step7', 'step7submit'))) { ?>
					<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload/swfupload.js"></script>
					<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload/js/handlers.js?<?php echo $version; ?>"></script>
					<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/js/swfupload/default.css">
				<?php }?>
				
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_profil.js?<?php echo $version; ?>"></script>
				
				<?php if($action == 'step8') { ?>
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
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/lightbox/lightbox.js"></script>
			<?php 			} elseif($app == 'groupe' && in_array($action, array('edit', 'save'))) {
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
	</head>
	
	<body>
		
		<div class="site">
			
			<div class="header">
				
				<div id="logo"></div>
				
			</div>
			
			<div class="body">
				<?php 					// charge l'application demand&eacute;e
					JL::loadBody();
				?>
			</div>
			
			<div class="footer">
				<?php 					// charge le module du footer
					JL::loadMod('footer');
				?>
			</div>
			
			<?php 			
				// si utilisateur log
				if($user->id) {
				
					// charge le module de menu
					JL::loadMod('menu');
					
				} else {
				
					// charge le module de login
					JL::loadMod('login');
					
				}
			
			/*if($app == 'home') {
			?>
				<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>" title="Appels &agrave; t&eacute;moins sur solocircl.com" class="aat"><img src="<?php echo SITE_URL; ?>/parentsolo/images/appel_a_temoins.jpg" alt="Appels &agrave; t&eacute;moins" /></a>
			<?php 			}*/
			?>
			
			<a href="javascript:windowOpen('LFM', 'http://www.lfm.ch/portail/player/player.php', '500', '200');" class="lfm"><img src="<?php echo SITE_URL; ?>/images/lausanne-fm.jpg" alt="Ecoutez Lausanne FM avec solocircl.com" /></a>
			<a href="javascript:windowOpen('OneFM', 'http://www.onefm.ch/home/playerv2/player.php', '500', '320');" class="onefm"><img src="<?php echo SITE_URL; ?>/images/one-fm.jpg" alt="Ecoutez One FM avec solocircl.com" /></a>
			
			<div class="banner_top"><div id="banner_top"></div></div>
			
			<?php 			// nouveau message sur le chat
			if($user->id) { ?>
				<div class="chatAlert" id="chatAlert" onClick="windowOpen('ParentSoloChat','<?php echo JL::url('index2.php?app=chat'); ?>','800px','600px');"></div><?php 			}
			?>
		</div>	
		<?php 		
			// charge le module de message d'alerte de derneirs &eacute;v&eacute;nements(popin)
			JL::loadMod('popin_last_event');
			JL::loadMod('popin_chat_alert');
			
		?>
		
		<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
		try {
		var pageTracker = _gat._getTracker("UA-6463477-2");
		pageTracker._trackPageview();
		} catch(err) {}</script>
		
		<script type="text/javascript">
		window.addEventListener('domready',function(){
			swfobject.embedSWF("<?php echo SITE_URL; ?>/images/logo-parentsolo.swf", "logo", "238", "196", "8.0.0", "", { "width": "238", "height": "196" }, { "wmode": "transparent"}, { "id" : "logo" });
			swfobject.embedSWF("<?php echo SITE_URL; ?>/images/banners/babybook-728x90.swf", "banner_top", "728", "90", "8.0.0", "", { "width": "728", "height": "90" }, { "wmode": "transparent"}, { "id" : "banner_topswf" });
			
			<?php if($app == 'home') { ?>
				swfobject.embedSWF("<?php echo SITE_URL; ?>/images/banners/ps-120x600.swf", "banner_right", "120", "600", "8.0.0", "", { "width": "120", "height": "600" }, { "wmode": "transparent"}, { "id" : "banner_rightswf" });
			<?php } elseif($app == 'profil' && $action == 'panel') { ?>
				swfobject.embedSWF("<?php echo SITE_URL; ?>/images/banners/dynapresse-250x250.swf", "banner_right250", "250", "250", "8.0.0", "", { "width": "250", "height": "250" }, { "wmode": "transparent"}, { "id" : "banner_right250swf" });
			<?php } elseif($app == 'profil' && preg_match('/^view/', $action)) { ?>
				swfobject.embedSWF("<?php echo SITE_URL; ?>/images/banners/babybook-728x90.swf", "profil_banner", "728", "90", "8.0.0", "", { "width": "728", "height": "90" }, { "wmode": "transparent"}, { "id" : "profil_banner" });
			<?php } ?>
			
			<?php // LEMAN BLEU SWF
			if($app == 'redac' && (int)JL::getVar('id', 0) == 7) {
			?>
			swfobject.embedSWF("<?php echo SITE_URL.'/images/sceneMenage1109.swf'; ?>", "sceneMenage", "328", "280", "8.0.0", "", { "width": "328", "height": "280" }, { "wmode": "transparent"}, { "id" : "sceneMenage" });
			<?php } ?>
		});
		</script>
	</body>
</html>
<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');
	
	// chemin du template
	$template	= SITE_URL.'/'.SITE_TEMPLATE;
	
	global $app, $action, $user;
	
	// anti cache
	$version = 'v60';
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<?php 			// module de gestion automatis&eacute;e des meta tags
			JL::loadMod('meta');
		?>
		<link href="<?php echo $template.'/'.SITE_TEMPLATE.'.css?'.$version; ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/mootools.js?<?php echo $version; ?>"></script>
		<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfobject/swfobject.js"></script>
		
		<?php 			if($app == 'home') {
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_home.js?<?php echo $version; ?>"></script>
			<?php 			} elseif($app == 'profil') {
			?>
				
				<?php if(in_array($action, array('step2', 'step2submit', 'step7', 'step7submit'))) { ?>
					<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload/swfupload.js"></script>
					<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload/js/handlers.js?<?php echo $version; ?>"></script>
					<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/js/swfupload/default.css">
				<?php }?>
				
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_profil.js?<?php echo $version; ?>"></script>
				
				<?php if($action == 'step8') { ?>
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
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/lightbox/lightbox.js"></script>
			<?php 			} elseif($app == 'groupe' && in_array($action, array('edit', 'save'))) {
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_groupe.js"></script>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload/swfupload.js"></script>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload/js/handlers.js?<?php echo $version; ?>"></script>
				<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/js/swfupload/default.css">
			<?php 			}
		?>
	</head>
	
	<body>
		
		<div class="site">
			
			<div class="header">
				
				<div id="logo"></div>
				
			</div>
			
			<div class="body">
				<?php 					// charge l'application demand&eacute;e
					JL::loadBody();
				?>
			</div>
			
			<div class="footer">
				<?php 					// charge le module du footer
					JL::loadMod('footer');
				?>
			</div>
			
			<?php 			
				// si utilisateur log
				if($user->id) {
				
					// charge le module de menu
					JL::loadMod('menu');
					
				} else {
				
					// charge le module de login
					JL::loadMod('login');
					
				}
			
			/*if($app == 'home') {
			?>
				<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>" title="Appels &agrave; t&eacute;moins sur solocircl.com" class="aat"><img src="<?php echo SITE_URL; ?>/parentsolo/images/appel_a_temoins.jpg" alt="Appels &agrave; t&eacute;moins" /></a>
			<?php 			}*/
			?>
			
			<a href="javascript:windowOpen('LFM', 'http://www.lfm.ch/portail/player/player.php', '500', '200');" class="lfm"><img src="<?php echo SITE_URL; ?>/images/lausanne-fm.jpg" alt="Ecoutez Lausanne FM avec solocircl.com" /></a>
			<a href="javascript:windowOpen('OneFM', 'http://www.onefm.ch/home/playerv2/player.php', '500', '320');" class="onefm"><img src="<?php echo SITE_URL; ?>/images/one-fm.jpg" alt="Ecoutez One FM avec solocircl.com" /></a>
			
			<div class="banner_top"><div id="banner_top"></div></div>
			
			<?php 			// nouveau message sur le chat
			if($user->id) { ?>
				<div class="chatAlert" id="chatAlert" onClick="windowOpen('ParentSoloChat','<?php echo JL::url('index2.php?app=chat'); ?>','800px','600px');"></div><?php 			}
			?>
		</div>	
		<?php 		
			// charge le module de message d'alerte de derneirs &eacute;v&eacute;nements(popin)
			JL::loadMod('popin_last_event');
			JL::loadMod('popin_chat_alert');
			
		?>
		
		<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
		try {
		var pageTracker = _gat._getTracker("UA-6463477-2");
		pageTracker._trackPageview();
		} catch(err) {}</script>
		
		<script type="text/javascript">
		window.addEventListener('domready',function(){
			swfobject.embedSWF("<?php echo SITE_URL; ?>/images/logo-parentsolo.swf", "logo", "238", "196", "8.0.0", "", { "width": "238", "height": "196" }, { "wmode": "transparent"}, { "id" : "logo" });
			swfobject.embedSWF("<?php echo SITE_URL; ?>/images/banners/babybook-728x90.swf", "banner_top", "728", "90", "8.0.0", "", { "width": "728", "height": "90" }, { "wmode": "transparent"}, { "id" : "banner_topswf" });
			
			<?php if($app == 'home') { ?>
				swfobject.embedSWF("<?php echo SITE_URL; ?>/images/banners/ps-120x600.swf", "banner_right", "120", "600", "8.0.0", "", { "width": "120", "height": "600" }, { "wmode": "transparent"}, { "id" : "banner_rightswf" });
			<?php } elseif($app == 'profil' && $action == 'panel') { ?>
				swfobject.embedSWF("<?php echo SITE_URL; ?>/images/banners/dynapresse-250x250.swf", "banner_right250", "250", "250", "8.0.0", "", { "width": "250", "height": "250" }, { "wmode": "transparent"}, { "id" : "banner_right250swf" });
			<?php } elseif($app == 'profil' && preg_match('/^view/', $action)) { ?>
				swfobject.embedSWF("<?php echo SITE_URL; ?>/images/banners/babybook-728x90.swf", "profil_banner", "728", "90", "8.0.0", "", { "width": "728", "height": "90" }, { "wmode": "transparent"}, { "id" : "profil_banner" });
			<?php } ?>
		});
		</script>
	</body>
</html>

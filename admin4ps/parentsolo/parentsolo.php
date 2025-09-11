<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	// chemin du template
	$template	= SITE_URL_ADMIN.'/'.SITE_TEMPLATE;
	
	global $user, $app;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" >
	<head>
		
		<?
			// module de gestion automatisée des meta tags
			JL::loadMod('meta', 'admin');
		?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Dancing+Script|Quicksand|Satisfy" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link href="<? echo $template.'/'; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<? echo $template.'/'; ?>css/bootstrap-reset.css" rel="stylesheet" type="text/css" />
		<!--external css-->
		<link href="<? echo $template.'/'; ?>css/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="<? echo $template.'/'; ?>css/style.css" rel="stylesheet" type="text/css" />
		<link href="<? echo $template.'/'; ?>css/style-responsive.css" rel="stylesheet" type="text/css" />		<!--css in photo edit-->		<link href="<? echo $template.'/'; ?>build/darkroom.css" rel="stylesheet" type="text/css" />		<link href="<? echo $template.'/'; ?>build/css/page.css" rel="stylesheet" type="text/css" /><!--css in photo edit-->		<script src="../parentsolo/new_style/js/jquery.js"></script>
		<!--<link href="<? // echo $template.'/'.SITE_TEMPLATE.'.css'; ?>" rel="stylesheet" type="text/css" />-->
		 <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
		<link href="<? echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<? if($app == 'expert') { ?>
			<!--<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/mootools-back.js"></script>-->
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/swfupload/swfupload.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/swfupload/handlers.js"></script>
			<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>/js/swfupload/default.css">
		<? } ?>
		<? if($app == 'mailing_auto') { 
			if($action=="edit" || $action=="save"){
		?>
				<link href="<?php echo $template; ?>/upload.css" rel="stylesheet" type="text/css" />
				<script src="<?php echo SITE_URL_ADMIN; ?>/js/ajaxupload.3.5.js"></script>
				<script src="<?php echo SITE_URL_ADMIN; ?>/js/jquery-1.3.2.js"></script>
				<script src="<?php echo SITE_URL_ADMIN; ?>/js/upload.js"></script>
		<?
			}
		?>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/mootools-back.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/app_mailing_auto.js"></script>
		<? } ?>
	</head>
	
	<body>		
		<section id="container" class="">
		  <!--header start-->
          <header class="header white-bg">
		  
		    <div class="sidebar-toggle-box">
               <i class="fa fa-bars"></i>
            </div>	
		
				<a href="<? echo SITE_URL_ADMIN; ?>/index.php" class="logo">
					<img src="<? echo $template; ?>/images/logo_en.png" alt="Parentsolo.ch" class="adminlogo" />
				</a>
				<?
					// user log
					if($user->id) {
					?>
					
                  <div class="top-nav ">
                     
						<form action="<? echo SITE_URL_ADMIN; ?>/index.php" name="login" method="post">
						 <ul class="nav pull-right top-menu">
							  <!-- user login dropdown start-->
                          <li class="dropdown">
							 <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                             <img alt="" src="<? echo SITE_URL_ADMIN; ?>/parentsolo/images/avatar-mini.jpg">
							<span class="username"><? echo $user->username; ?> ::   <b class="caret"></b></a>
							 <ul class="dropdown-menu extended logout">
                             <div class="log-arrow-up"></div>
							 <li><a href="javascript:document.login.submit();" >D&eacute;connexion</a></li>
							<input type="hidden" name="auth" value="logout" />
							 </ul>
                          </li>
						  
                        <!-- user login dropdown end -->
                        </ul>
						 
						</form>
					</div>
					<?
					}
				?>		
		  </header>
          <!--header end-->
		  
		  <!--sidebar start-->
          <aside>	
			<?
				// user log
				if($user->id) {
			?>
					
				<?
						// charge le menu de gauche (il est chargé après le Body afin de mettre à jour les nombres de textes, photos et messages dans le menu)
						JL::loadMod('menu', 'admin');
				?>
		  </aside>
		 <!--main content start-->
          <section id="main-content">
              <section class=" wrapper">
				<?
				}
					// charge l'application demandée
					JL::loadBody('admin');
					
				// user log
				if($user->id) {
			?>
			 </section>
          </section>
          <!--main content end-->
		<div style="clear:both"> </div>
			<?
				}
			?>
			
			<!-- <footer class="site-footer"></footer>-->
			
		 </section>
		
	<!-- js placed at the end of the document so the pages load faster -->
	<!-- js placed at the end of the document so the pages load faster -->
		<script src="../parentsolo/new_style/js/jquery.js"></script>
		<script src="../parentsolo/photovalidation/bootstrap/dist/js/bootstrap.min.js"></script>
   <!-- <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/bootstrap.min.js"></script>-->
    <script class="include" type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.dcjqaccordion.2.7.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo SITE_URL_ADMIN; ?>/js/slidebars.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/respond.min.js" ></script>
	 <!--common script for all pages-->
    <script src="<?php echo SITE_URL_ADMIN; ?>/js/common-scripts.js"></script>		<script>    function ajaximgFunction(ajaximgcls, ajaximgsrc) { (function($) {  var fields = ajaximgcls.split('_');var imgpathvalue = fields[1];  console.log(imgpathvalue);  console.log(ajaximgsrc);    var imgval= ajaximgsrc;								var i = new Image(); 				i.onload = function(){				var imgh = i.height;				var imgw = i.width;									var img_width = imgw;				var img_height = imgh;						var upload_dir= document.getElementById("upload_dir_"+imgpathvalue).value;	var site_url= document.getElementById("photo_id_"+imgpathvalue).value;      console.log(img_width);    console.log(img_height);    console.log(upload_dir);    console.log(site_url);       $.ajax({ 	  type:'post',       url:'https://www.parentsolo.ch/adminimgresize.php',       data: { 'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height },              success: function(response) { 	   console.log(response);			           }      }); 						};				i.src = imgval;					})(jQuery);	  }</script>	<script src="<? echo $template.'/'; ?>build/vendor/fabric.js"></script>  <script src="<? echo $template.'/'; ?>build/darkroom.js"></script>  <?php 	$query = "SELECT SUM(photo_a_valider) FROM user_stats";	$photosAValiderNb = $db->loadResult($query);	$photosAValiderNb > 0 ? ' '.$photosAValiderNb.'' : ''; 	  ?><script>jQuery.noConflict();(function($) { var lentofphoto= '<? echo $photosAValiderNb+1; ?>';var i;for (i = 1; i < lentofphoto; i++) {   	   var dkrm = new Darkroom("#target_"+i, {      minWidth: 100,      minHeight: 100,      maxWidth: 600,      maxHeight: 500,      ratio: 4/3,      backgroundColor: '#000',      plugins: {        crop: {          quickCropKey: 67,         }      },      initialize: function() {        var cropPlugin = this.plugins['crop'];                cropPlugin.requireFocus();		      }    });	}})(jQuery);</script>
	<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/mootools-back.js"></script>

	</body>
	
</html>

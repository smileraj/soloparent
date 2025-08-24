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
			JL::loadMod('meta2', 'admin');
		?>
		<link href="https://fonts.googleapis.com/css?family=Dancing+Script|Quicksand|Satisfy" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link href="<? echo $template.'/'; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<? echo $template.'/'; ?>css/bootstrap-reset.css" rel="stylesheet" type="text/css" />
		<!--external css-->
		<link href="<? echo $template.'/'; ?>css/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="<? echo $template.'/'; ?>css/style.css" rel="stylesheet" type="text/css" />
		<link href="<? echo $template.'/'; ?>css/style-responsive.css" rel="stylesheet" type="text/css" />
		<!--<link href="<? // echo $template.'/'.SITE_TEMPLATE.'.css'; ?>" rel="stylesheet" type="text/css" />-->
		 <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
		<link href="<? echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/mootools-back.js"></script>
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
					<img src="<? echo $template; ?>/images/logo-fr.png" alt="Parentsolo.ch" class="adminlogo" />
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
						// charge le menu de gauche (il est chargé après le Body afin de mettre à jour les nombres de textes, photos et messages dans le menu)
						JL::loadMod('menu', 'admin');
					}
				?>
				 </aside>
		 <!--main content start-->
          <section id="main-content">
              <section class=" wrapper">
				<?
					
					// charge l'application demandée
					JL::loadBody('admin');
					
				?>
				 </section>
          </section>
          <!--main content end-->
		<div style="clear:both"> </div>
		 <footer class="site-footer"></footer>
			
		 </section>

  
		
	<!-- js placed at the end of the document so the pages load faster -->
	<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/lightbox/lightbox.js"></script>	
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.dcjqaccordion.2.7.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.scrollTo.min.js"></script>    
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/respond.min.js" ></script>
	 <!--common script for all pages-->
    <script src="<?php echo SITE_URL_ADMIN; ?>/js/common-scripts.js"></script>

		
		
	</body>
	
</html>

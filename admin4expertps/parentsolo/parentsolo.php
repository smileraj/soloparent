<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	// chemin du template
	$template	= SITE_URL_ADMIN_EXPERT.'/'.SITE_TEMPLATE;
	
	global $user, $app;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		
		<?php 			// module de gestion automatis�e des meta tags
			JL::loadMod('meta', 'admin');
		?>
		<link href="<?php echo $template.'/'.SITE_TEMPLATE.'.css'; ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<?php if($app == 'expert') { ?>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN_EXPERT; ?>/js/mootools-back.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN_EXPERT; ?>/js/swfupload/swfupload.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN_EXPERT; ?>/js/swfupload/handlers.js"></script>
			<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN_EXPERT; ?>/js/swfupload/default.css">
		<?php } ?>
	</head>
	
	<body>
		
		<div class="body">
			
			<div class="header">
				<a href="<?php echo SITE_URL_ADMIN_EXPERT; ?>/index.php" class="logo"></a>
				<?php 					// user log
					if($user->id) {
					?>
					<div class="userlog">
						<form action="<?php echo SITE_URL_ADMIN_EXPERT; ?>/index.php" name="login" method="post">
							<b><?php echo $user->username; ?> :: <a href="javascript:document.login.submit();" >D&eacute;connexion</a></b>
							<input type="hidden" name="auth" value="logout" />
						</form>
					</div>
					<?php 					}
				?>
			</div>
			<hr/>
			<div class="content">
				<div class="contentl">
					<div class="colc">
					<?php 						// user log
						if($user->id) {
							// charge le menu de gauche (il est charg� apr�s le Body afin de mettre � jour les nombres de textes, photos et messages dans le menu)
							JL::loadModExpert('menu');
						}
					?>
					</div>
				</div>
				<div class="colr">
				<?php 					
					// charge l'application demand�e
					JL::loadBodyExpert();
					
				?>
				</div>
				<div style="clear:both"> </div>
			</div>
			<div class="footer"></div>
			
		</div>
		
	</body>
	
</html>

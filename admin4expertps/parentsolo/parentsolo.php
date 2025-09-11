<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	// chemin du template
	$template	= SITE_URL_ADMIN_EXPERT.'/'.SITE_TEMPLATE;
	
	global $user, $app;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" >
	<head>
		
		<?
			// module de gestion automatisée des meta tags
			JL::loadMod('meta', 'admin');
		?>
		<link href="<? echo $template.'/'.SITE_TEMPLATE.'.css'; ?>" rel="stylesheet" type="text/css" />
		<link href="<? echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<? if($app == 'expert') { ?>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN_EXPERT; ?>/js/mootools-back.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN_EXPERT; ?>/js/swfupload/swfupload.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN_EXPERT; ?>/js/swfupload/handlers.js"></script>
			<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN_EXPERT; ?>/js/swfupload/default.css">
		<? } ?>
	</head>
	
	<body>
		
		<div class="body">
			
			<div class="header">
				<a href="<? echo SITE_URL_ADMIN_EXPERT; ?>/index.php" class="logo"></a>
				<?
					// user log
					if($user->id) {
					?>
					<div class="userlog">
						<form action="<? echo SITE_URL_ADMIN_EXPERT; ?>/index.php" name="login" method="post">
							<b><? echo $user->username; ?> :: <a href="javascript:document.login.submit();" >D&eacute;connexion</a></b>
							<input type="hidden" name="auth" value="logout" />
						</form>
					</div>
					<?
					}
				?>
			</div>
			<hr/>
			<div class="content">
				<div class="contentl">
					<div class="colc">
					<?
						// user log
						if($user->id) {
							// charge le menu de gauche (il est chargé après le Body afin de mettre à jour les nombres de textes, photos et messages dans le menu)
							JL::loadModExpert('menu');
						}
					?>
					</div>
				</div>
				<div class="colr">
				<?
					
					// charge l'application demandée
					JL::loadBodyExpert();
					
				?>
				</div>
				<div style="clear:both"> </div>
			</div>
			<div class="footer"></div>
			
		</div>
		
	</body>
	
</html>

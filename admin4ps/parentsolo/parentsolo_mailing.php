<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	// chemin du template
	$template	= SITE_URL_ADMIN.'/'.SITE_TEMPLATE;
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Parentsolo Mailing</title>
		<meta http-equiv="content-language" content="en" />
		<link href="<?php echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	</head>
	<body>
	<?php 	
		// charge l'application principale
		JL::loadBody('admin');
	
	?>
	</body>
</html>

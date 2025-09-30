<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $app, $action, $langue;
			include("lang/app_mod.".$_GET['lang'].".php");

	$meta					= [];
	$meta['title']			= ''.$lang_mod["SiteDeRencontre"].'';
	$meta['description']	= ''.$lang_mod["LeSiteDeRencontreDes"].' !';
	$meta['keywords']		= ''.$lang_mod["celibatairesRencontre"].'';

?>

	<title><?php echo $meta['title']; ?></title>
	<meta name="description" content="<?php echo $meta['description']; ?>" />
	<meta name="keywords" content="<?php echo $meta['keywords']; ?>" />
	<meta name="robots" content="index, follow" />
	<meta http-equiv="content-language" content="<?php echo$_GET["lang"];?>" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />

<?
	// sécurité
	defined('JL') or die('Error 401');
	
	// chemin du template
	$template	= SITE_URL_ADMIN.'/'.SITE_TEMPLATE;
	global $app, $user, $action;
?>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <link href="<?php echo $template; ?>/parentsolo.css?v4" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/swfupload/recadrer-image.js"></script>
</head>

<? 
	if($action=='save'){
?>
	<body>
<?
	}else{
?>
	<body onLoad="fnOnLoad();" onMouseDown="fnOnMouseDown();" onMouseUp="fnOnMouseUp();">
<?
	}
?>

<?
	JL::loadBody('admin');
?>

</body>
</html>

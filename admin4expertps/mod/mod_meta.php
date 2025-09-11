<?php

	// sécurité
	defined('JL') or die('Error 401');

	global $app, $action;
	
	$meta					= array();
	$meta['title']			= 'ParentSolo.ch - Administration!';
	$meta['description']	= 'Le site de rencontre des parents c&eacute;libataires Suisses avec enfant(s). D&eacute;couvrez les papas et mamans de Suisse &agrave; la recherche d\'une relation s&eacute;rieuse, l\'inscription est gratuite !';
	$meta['keywords']		= 'parentsolo administration';
	
?>

	<title><? echo $meta['title']; ?></title>
	<meta name="description" content="<? echo $meta['description']; ?>" />
	<meta name="keywords" content="<? echo $meta['keywords']; ?>" />
	<meta name="robots" content="noindex, nofollow" />
	<meta http-equiv="content-language" content="fr" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	
	<script type="text/javascript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/javascript" src="lib/plugins/jquery.form.js"></script> 
	<script type="text/javascript" src="lib/lib.src.js"></script>

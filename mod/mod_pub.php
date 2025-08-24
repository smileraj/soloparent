<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $user, $app, $action, $langue;
	include("lang/app_mod.".$_GET['lang'].".php");
    
    /*
?>

	<div class="small"><? echo $lang_mod["Partenaire"]; ?></div>
	<div class="silver_banner">
		<a href="http://www.seniorsolo.net" target="_blank"><img src="<? echo SITE_URL; ?>/parentsolo/images/pub/seniorsolo.gif" alt="silver_banner"/></a>
	</div>

*/?>
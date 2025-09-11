<?php

	// sécurité
	defined('JL') or die('Error 401');

	// envoi du header 404
	header('HTTP/1.0 404 Not Found');
	include("lang/app_404.".$_GET['lang'].".php");
?>
<div class="content">
	<div class="contentl">
		<div class="colc">
			<h1><?php echo $lang_app404["PageInexistante"];?></h1>
			<br />
			<?php echo $lang_app404["PageNexistePas"];?>
		</div>
	</div>

	<div class="colr"> 
		<? JL::loadMod('menu_right');?>
	</div>
	<div style="clear:both"> </div>
</div>

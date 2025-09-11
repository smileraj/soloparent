<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	include("lang/app_mod.".$_GET['lang'].".php");
?>
	<h2 class="barre"><?php echo $lang_mod["PageInexistante"];?></h2>
	<div class="texte_explicatif">
		<?php echo $lang_mod["LaPageDemandeeNExistePasOuPlusSurParentsolo"];?>
	</div>
						
						

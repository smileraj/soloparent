<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $db, $langue;
	include("lang/app_mod.".$_GET['lang'].".php");

	// r&eacute;cup le nombre d'inscrits (table &agrave; part pour &eacute;viter les COUNT(*) sur la table user &agrave; chaque chargement de page
	$query = "SELECT papa, maman"
	." FROM inscrits"
	." LIMIT 0,1"
	;
	$inscrits = $db->loadResultArray($query);

	$total 	= $inscrits['maman'] + $inscrits['papa'];

	$mamans = ceil($inscrits['maman'] / $total * 100);
	$papas	= 100 - $mamans;

?>
<div class="inscrits">
	<table cellpadding="0" cellspacing="0" width="155px">
		<tr><td><?php echo $lang_mod["MamansInscrite"];?>:</td><td class="right"><? echo $mamans; ?>%</td></tr>
		<tr><td><?php echo $lang_mod["PapasInscrits"];?>:</td><td class="right"><? echo $papas; ?>%</td></tr>
	</table>
</div>

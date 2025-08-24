<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');
	global $langue;

	// si non, on redirige sur la page des tarifs
	if(!JL::checkAbonnement()) {
		JL::redirect(SITE_URL.'/index.php?app=abonnement&action=tarifs'.'&'.$langue);
	}

?>
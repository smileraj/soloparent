<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('sondage.html.php');

	

	switch($action) {


		default:
		contenuAfficher();
		break;

	}


	// affiche un contenu pass&eacute; en param $id
	function contenuAfficher() {

			// sinon on affiche l'article
			sondage_HTML::contenuAfficher();

		

	}

?>

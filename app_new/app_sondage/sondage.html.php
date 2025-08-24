<?php

	// sécurité
	defined('JL') or die('Error 401');

	class sondage_HTML {

		// affiche un $contenu
		function contenuAfficher() {
			

			?>
				<div class="app_body">
					<div class="contenu">
					<object data='http://mingle2.respondi.com/uc/co_parentsolo/' type='text/html' width="735" height="730"/>
					</div>
				</div> <? // fin app_body ?>
			<?

				// colonne de gauche
				JL::loadMod('profil_panel');

			?>
			<div class="clear"> </div>
			<?
		}

	}
?>

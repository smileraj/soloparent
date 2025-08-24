<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	global $db;
	
	
	?>
	<div class="menu">
		<div class="menuBody">
			<h2>Menu</h2>
			
			<h3>Experts</h3>
			<ul>
				<li><a href="<? echo SITE_URL_ADMIN_EXPERT; ?>/index.php" title="Accueil">Accueil</a></li>
				<li><a href="<? echo SITE_URL_ADMIN_EXPERT; ?>/index.php?app=questions" title="Publier les questions et r&eacute;ponse">Questions /r&eacute;ponses</a></li>
				<li><a href="<? echo SITE_URL_ADMIN_EXPERT; ?>/index.php?app=profil" title="Consulter les profils des membres">Profils membres</a></li>
			</ul>
		</div>
	</div>

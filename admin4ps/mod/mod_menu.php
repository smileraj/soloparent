<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	global $db;
	
	// calcule le nombre de photos en attente de validation
	$query = "SELECT SUM(photo_a_valider) FROM user_stats";
	$photosAValiderNb = $db->loadResult($query);
	
	// calcule le nombre de textes en attente de validation
	$query = "SELECT COUNT(*) FROM user_annonce WHERE annonce NOT LIKE '' AND published = 2";
	$textesAValiderNb = $db->loadResult($query);
	
	// calcule le nombre d'appels à témoins en attente de validation
	$query = "SELECT COUNT(*) FROM appel_a_temoins WHERE active = 2";
	$appelsNb	= $db->loadResult($query);
	
	// calcule le nombre de témoignages en attente de validation
	$query = "SELECT COUNT(*) FROM temoignage WHERE active = 2";
	$temoignagesNb	= $db->loadResult($query);
	
	// calcule le nombre de groupes en attente de validation
	$query = "SELECT COUNT(*) FROM groupe WHERE active = 2";
	$groupesAValiderNb = $db->loadResult($query);
	
	// calcule le nombre de gagnants à traiter
	$query = "SELECT COUNT(*) FROM points_gagnants WHERE traite = 0";
	$gagnantsNb = $db->loadResult($query);
	
	?>
	
	<div id="sidebar"  class="nav-collapse ">
    <!-- sidebar menu start-->
	 <ul class="sidebar-menu" id="nav-accordion">
	 <li class="sub-menu">	
	 <a href="javascript:;">
	 <i class="fa fa-cogs"></i>
     <span>Syst&egrave;me</span>	
	 </a>
		<ul class="sub">
				   <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=user&search_gid=1" title="Utilisateurs c&ocirc;t&eacute; admin">Administrateurs</a></li>
				   <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=user&search_gid=0" title="Utilisateurs c&ocirc;t&eacute; visiteur">Membres</a></li>
				   <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing" title="R&eacute;daction et envoi de mailings">Mailings</a></li>
				   <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing_auto" title="R&eacute;daction et envoi de mailings automatiques">Mailings automatiques</a></li>
				   <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=tools" title="Outils">Outils</a></li>
				   <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=generer_visite" title="G&eacute;n&eacute;rer visites">G&eacute;n&eacute;rer visites</a></li>
				   <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=envoi_mails" title="G&eacute;n&eacute;rer les envois de mails">G&eacute;n&eacute;rer mails</a></li>
		</ul>
     </li>
	 
	  <li class="sub-menu">
        <a href="javascript:;" >
        <i class="fa fa-user"></i>
        <span>Membres</span>
        </a>
        <ul class="sub">
			<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil" title="Membres">Profils</a></li>
			<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=photo_validation" title="Validation des photos">Photos<?php echo $photosAValiderNb > 0 ? ' ('.$photosAValiderNb.')' : ''; ?></a></li>
			<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=texte_validation" title="Validation des textes">Textes<?php echo $textesAValiderNb > 0 ? ' ('.$textesAValiderNb.')' : ''; ?></a></li>
			<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=groupe" title="Groupes &agrave; valider">Groupes<?php echo $groupesAValiderNb > 0 ? ' ('.$groupesAValiderNb.')' : ''; ?></a></li>
			<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=temoignage" title="T&eacute;moignages">Témoignages<?php echo $temoignagesNb > 0 ? ' ('.$temoignagesNb.')' : ''; ?></a></li>
		</ul>
     </li>
	  
	 <li class="sub-menu">
        <a href="javascript:;" >
        <i class="fa fa-heart"></i>
        <span>SoloFleurs</span>
        </a>
        <ul class="sub">
		<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=points&action=classement" title="Classements du concours SoloFleurs">Classements</a></li>
		<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=points&action=bareme" title="Bar&egrave;me du concours SoloFleurs">Bar&egrave;me</a></li>
		<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=points&action=gagnant" title="Gagnants du concours SoloFleurs">Gagnants<?php echo $gagnantsNb > 0 ? ' ('.$gagnantsNb.')' : ''; ?></a></li>
		</ul>
     </li>
		
	  <li class="sub-menu">
        <a href="javascript:;" >
        <i class="fa fa-tasks"></i>
        <span>R&eacute;dactionnel</span>
        </a>
        <ul class="sub">
		<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=appel_a_temoins" title="Appels &agrave; t&eacute;moins">Appels &agrave; t&eacute;moins<?php echo $appelsNb > 0 ? ' ('.$appelsNb.')' : ''; ?></a></li>
		<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=actu" title="Actualit&eacute;s">Actualit&eacute;s</a></li>
		<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=contenu" title="Contenus">Contenus</a></li>
		<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=box" title="Boxs">Boxs</a></li>
		<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=expert" title="Experts">Experts</a></li>
		</ul>
     </li>
	  
	  <li class="sub-menu">
        <a href="javascript:;" >
        <i class="fa fa-th"></i>
        <span>Tables</span>
        </a>
        <ul class="sub">
		  <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table" title="Traductions">Traductions</a></li>
		</ul>
     </li>
	  
	  
	  <li class="sub-menu">
        <a href="javascript:;" >
        <i class=" fa fa-bar-chart-o"></i>
        <span>Statistiques</span>
        </a>
        <ul class="sub">
		<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution" title="Evolution des membres/mois">Membres/mois</a></li>
		  <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_an" title="Evolution des membres/ann&eacute;es">Membres/ann&eacute;es</a></li>
		  <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_semaine" title="Evolution des membres/semiane">Membres/semaine</a></li>
		  <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_abonnement" title="Evolution des abonnements/ann&eacute;es">Abonnements/ann&eacute;es</a></li>
		  <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_abonne" title="Evolution des abonn&eacute;s/ann&eacute;es">Abonn&eacute;s uniques/ann&eacute;es</a></li>
		  <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_age_membre" title="Evolution de l'&acirc;ge des membres/ann&eacute;es">Age membres/ann&eacute;es</a></li>
		  <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_canton" title="Evolution des cantons des membres/ann&eacute;es">Cantons memb/ann&eacute;es</a></li>
		  <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_canton_abonne" title="Evolution des cantons des abonn&eacute;s/ann&eacute;es">Cantons abo/ann&eacute;es</a></li>
		  <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_desinscription_an" title="Evolution des d&eacute;sinscriptions/ann&eacute;es">D&eacute;sinscriptions/ann&eacute;es</a></li>
		  <li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_reactivation_an" title="Evolution des r&eacute;activations/ann&eacute;es">R&eacute;activations/ann&eacute;es</a></li>
		</ul>
     </li>
	 <li class="sub-menu">
	 <a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=event" title="event">
        <i class="fa fa-calendar-o"></i>
		
        <span>Events</span></a>
        
     </li>
	 <li class="sub-menu">
	 <a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=trigger" title="Notification">
        <i class="fa fa-bell" aria-hidden="true"></i>
		
        <span>Notification</span></a>
        
     </li>
 </ul>
   <!-- sidebar menu end-->
 </div>	 
	<!--<div class="menu">
		<div class="menuBody">
			<h3>Syst&egrave;me</h3>
			<ul>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=user&search_gid=1" title="Utilisateurs c&ocirc;t&eacute; admin">Administrateurs</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=user&search_gid=0" title="Utilisateurs c&ocirc;t&eacute; visiteur">Membres</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing" title="R&eacute;daction et envoi de mailings">Mailings</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=mailing_auto" title="R&eacute;daction et envoi de mailings automatiques">Mailings automatiques</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=tools" title="Outils">Outils</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=generer_visite" title="G&eacute;n&eacute;rer visites">G&eacute;n&eacute;rer visites</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=envoi_mails" title="G&eacute;n&eacute;rer les envois de mails">G&eacute;n&eacute;rer mails</a></li>
			</ul>
			
			<h3>Membres</h3>
			<ul>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil" title="Membres">Profils</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=photo_validation" title="Validation des photos">Photos<?php echo $photosAValiderNb > 0 ? ' ('.$photosAValiderNb.')' : ''; ?></a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=profil&action=texte_validation" title="Validation des textes">Textes<?php echo $textesAValiderNb > 0 ? ' ('.$textesAValiderNb.')' : ''; ?></a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=groupe" title="Groupes &agrave; valider">Groupes<?php echo $groupesAValiderNb > 0 ? ' ('.$groupesAValiderNb.')' : ''; ?></a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=temoignage" title="T&eacute;moignages">Témoignages<?php echo $temoignagesNb > 0 ? ' ('.$temoignagesNb.')' : ''; ?></a></li>
			</ul>
			
			<h3>SoloFleurs</h3>
			<ul>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=points&action=classement" title="Classements du concours SoloFleurs">Classements</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=points&action=bareme" title="Bar&egrave;me du concours SoloFleurs">Bar&egrave;me</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=points&action=gagnant" title="Gagnants du concours SoloFleurs">Gagnants<?php echo $gagnantsNb > 0 ? ' ('.$gagnantsNb.')' : ''; ?></a></li>
			</ul>
				
			<h3>R&eacute;dactionnel</h3>
			<ul>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=appel_a_temoins" title="Appels &agrave; t&eacute;moins">Appels &agrave; t&eacute;moins<?php echo $appelsNb > 0 ? ' ('.$appelsNb.')' : ''; ?></a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=actu" title="Actualit&eacute;s">Actualit&eacute;s</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=contenu" title="Contenus">Contenus</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=box" title="Boxs">Boxs</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=expert" title="Experts">Experts</a></li>
			</ul>
			
			<h3>Tables</h3>
			<ul>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table" title="Traductions">Traductions</a></li>
			</ul>
			
			<h3>Statistiques</h3>
			<ul>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution" title="Evolution des membres/mois">Membres/mois</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_an" title="Evolution des membres/ann&eacute;es">Membres/ann&eacute;es</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_semaine" title="Evolution des membres/semiane">Membres/semaine</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_abonnement" title="Evolution des abonnements/ann&eacute;es">Abonnements/ann&eacute;es</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_abonne" title="Evolution des abonn&eacute;s/ann&eacute;es">Abonn&eacute;s uniques/ann&eacute;es</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_age_membre" title="Evolution de l'&acirc;ge des membres/ann&eacute;es">Age membres/ann&eacute;es</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_canton" title="Evolution des cantons des membres/ann&eacute;es">Cantons memb/ann&eacute;es</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_canton_abonne" title="Evolution des cantons des abonn&eacute;s/ann&eacute;es">Cantons abo/ann&eacute;es</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_desinscription_an" title="Evolution des d&eacute;sinscriptions/ann&eacute;es">D&eacute;sinscriptions/ann&eacute;es</a></li>
				<li><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=evolution_reactivation_an" title="Evolution des r&eacute;activations/ann&eacute;es">R&eacute;activations/ann&eacute;es</a></li>
			</ul>
		</div>
	</div>-->

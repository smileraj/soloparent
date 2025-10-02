<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $db, $user, $app, $action, $langue;
	include("lang/app_mod.".$_GET['lang'].".php");

	if($user->id) {

	// r&eacute;cup le status confirmed de l'utilisateur log
	$query = "SELECT confirmed FROM user WHERE id = '".(int)$user->id."' LIMIT 0,1";
	$user->confirmed = $db->loadResult($query);


	// r&eacute;cup le mini profil de l'utilisateur log
	$query = "SELECT u.id, u.username, IFNULL(pc.nom, '') AS canton, up.genre, up.photo_defaut, up.nb_enfants, CURRENT_DATE, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age"
	." FROM user AS u"
	." INNER JOIN user_profil AS up ON up.user_id = u.id"
	." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
	." WHERE u.id = '".$user->id."'"
	." LIMIT 0,1"
	;
	$userProfilMini	= $db->loadObject($query);


	// r&eacute;cup les stats du compte
	$query = "SELECT us.visite_total, IF(us.gold_limit_date > CURRENT_DATE, 1, 0) AS gold, us.fleur_new, us.message_new, IFNULL(COUNT(gu.user_id), 0) AS groupe_joined, us.points_total"
	." FROM user_stats AS us"
	." LEFT JOIN groupe_user AS gu ON gu.user_id = us.user_id"
	." WHERE us.user_id = '".$user->id."'"
	." GROUP BY us.user_id"
	." LIMIT 0,1"
	;
	$userStats = $db->loadObject($query);


	// r&eacute;cup les 3 derniers groupes
	$query = "SELECT id, titre"
	." FROM groupe"
	." WHERE active > 0 AND titre != ''"
	." ORDER BY date_add DESC"
	." LIMIT 0,2"
	;
	$groupes = $db->loadObjectList($query);


	// r&eacute;cup la photo de l'utilisateur
	$photo 				= JL::userGetPhoto($userProfilMini->id, '109', 'profil', $userProfilMini->photo_defaut);
	$noPhotoPopIn		= false;

	// photo par d&eacute;faut
	if(!$photo) {
		$photo 			= SITE_URL.'/parentsolo/images/parent-solo-109-'.$userProfilMini->genre.'.jpg';
		$noPhotoPopIn	= true;
	}

	// nouveaux messages
	$newMessages 		= $userStats->message_new+$userStats->fleur_new;

	// listes noires / favoris
	$list_type			= (int)JL::getVar('list_type', 0) > 0 ? 1 : 0;

	// statut
	$title = ''.$lang_mod["VotreProfilAEte"].'.';
	if($user->confirmed == 2) {
		$title = ''.$lang_mod["VousAliezRecevoir"].'.';
		if($user->gold_limit_date != '1970-01-01' && strtotime($user->gold_limit_date) >= time()) {
			$title .= ' '.$lang_mod["VotreAbonnementSera"].'.';
		}
	}

	$userTime	 = strtotime($user->gold_limit_date);


	// r&eacute;cup les derni�res actu
	$query = "SELECT id, titre, date_add"
	." FROM contenu"
	." WHERE type_id = 1 AND published = 1"
	." ORDER BY date_add DESC"
	." LIMIT 0, 3"
	;
	$actus = $db->loadObjectList($query);

	?>
	<div class="profil_left">

		<div class="user_menu">
			<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$user->id.'&'.$langue); ?>" title="<?php echo $lang_mod["VoirMonProfil"];?>"><img src="<?php echo $photo; ?>" alt="<?php echo $user->username; ?>" class="photo" /></a>
			<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$user->id.'&'.$langue); ?>" class="username" title="<?php echo $lang_mod["VoirMonProfil"];?> <?php echo $userProfilMini->username; ?>"><?php echo $userProfilMini->username; ?></a>

			<ul>
				<li><a href="<?php echo JL::url('index.php?app=message&action=inbox'.'&'.$langue); ?>" title="<?php echo $lang_mod["BoiteReception"];?>"><?php echo $lang_mod["VousAvez"];?> <span class="<?php echo $userStats->message_new > 0 ? 'grey' : 'white'; ?>"><?php echo $userStats->message_new; ?></span> <?php echo $userStats->message_new > 1 ? ''.$lang_mod["Nouveaux_messages"].'' : ''.$lang_mod["Nouveau_message"].''; ?>.</a></li>
				<li><a href="<?php echo JL::url('index.php?app=message&action=flowers'.'&'.$langue); ?>" title="<?php echo $lang_mod["EnvFleurQui"];?>"><?php echo $lang_mod["VousAvez"];?> <span class="<?php echo $userStats->fleur_new > 0 ? 'grey' : 'white'; ?>"><?php echo $userStats->fleur_new; ?></span> <?php echo $userStats->fleur_new > 1 ? ''.$lang_mod["Nouvelles_roses"].'' : ''.$lang_mod["Nouvelle_rose"].''; ?>.</a></li>
				<li><a href="<?php echo JL::url('index.php?app=search&action=visits'.'&'.$langue); ?>" title="<?php echo $userStats->visite_total; ?> <?php echo $userStats->message_new > 1 ? $lang_mod["Visites_total"] : $lang_mod["Visite_total"]; ?>"><?php echo $lang_mod["VousAvezRecu"];?> <span class="<?php echo $userStats->visite_total > 0 ? 'grey' : 'white'; ?>"><?php echo $userStats->visite_total; ?></span> <?php echo $userStats->visite_total > 1 ? ''.$lang_mod["Visites"].'' : ''.$lang_mod["Visite"].''; ?>.</a></li>
				<li><a href="<?php echo JL::url('index.php?app=points&action=mespoints'.'&'.$langue); ?>" title="<?php echo $lang_mod["Detail_points"];?>"><?php echo $lang_mod["VousAvez"];?> <span class="<?php echo $userStats->points_total > 0 ? 'grey' : 'white'; ?>"><?php echo $userStats->points_total; ?></span> SoloFleur<?php echo $userStats->points_total > 0 ? 's' : ''; ?>.</a></li>

				<li><b><?php echo $lang_mod["Statut"];?>:</b> <span class="statut<?php echo $user->confirmed; ?>" title="<?php echo $title; ?>"><?php echo $user->confirmed == 2 ? $lang_mod["Attente_validation"] :  $lang_mod["Confirme"]; ?></span></li>
				<li>
				<?php 					// abonn&eacute;
					if($user->gold_limit_date != '1970-01-01' && $userTime >= time()) {
					?>
						<b><?php echo $lang_mod["FinDAbonnement"];?>:</b> <span class="black"><?php echo date('d/m/y', $userTime); ?></span>
					<?php 					} else {
					?>
						<a href="<?php echo JL::url('index.php?app=abonnement&action=tarifs'.'&'.$langue); ?>" title="<?php echo $lang_mod["AboPourToute"];?>" class="abo"><?php echo $lang_mod["AbonnezVous"];?> !</a>
					<?php 					}
				?>
				</li>
			</ul>

			<a href="<?php echo JL::url('index.php?app=inviter&action=info'.'&'.$langue); ?>" title="<?php echo $lang_mod["VosAmisTitle"];?>" class="btnProfilPanel btnParrainage"><?php echo $lang_mod["ParrainezVosAmis"];?></a>
			<a href="<?php echo JL::url('index.php?app=points&action=mespoints'.'&'.$langue); ?>" title="<?php echo $lang_mod["VousAvez"];?> <?php echo $userStats->points_total; ?> <?php echo $lang_mod["Points"];?>." class="btnProfilPanel btnSolofleur"><?php echo $userStats->points_total; ?><br />SoloFleur<?php echo $userStats->points_total > 0 ? 's' : ''; ?></a>
			<a href="<?php echo JL::url('index.php?auth=logout'.'&'.$langue); ?>" title="<?php echo $lang_mod["LogoutTitle"];?>" class="logout"><?php echo $lang_mod["Deconnexion"];?></a>

		</div>

		<div class="user_menu user_groupes">
			<a href="<?php echo JL::url('index.php?app=groupe&action=list&groupe_type=all'.'&'.$langue); ?>" title="<?php echo $lang_mod["GroupesPersos"];?>"><img src="<?php echo SITE_URL.'/images/groupes-parentsolo.jpg'; ?>" alt="<?php echo $lang_mod["GroupesPersos"];?>" class="photo" /></a>
			<a href="<?php echo JL::url('index.php?app=groupe&action=list&groupe_type=created'.'&'.$langue); ?>" class="username" title="<?php echo $lang_mod["ListeGroupesRej"];?>"><?php echo $lang_mod["MesGroupes"];?></a>
			<a href="<?php echo JL::url('index.php?app=groupe&action=info'.'&'.$langue); ?>" title="<?php echo $lang_mod["IfosCompTitle"];?>" class="<?php echo $userProfilMini->genre == 'f' ? 'informations' : 'logout'; // gg la logique d'ergo np ?>" target="_blank"><?php echo $lang_mod["Informations"];?></a>

			<?php // si user log est une femme
			if($userProfilMini->genre == 'f') { ?>
				<a href="http://www.babybook.ch/blog/forum" title="<?php echo $lang_mod["ForumMamansTitle"];?>" class="btnForumEM"><?php echo $lang_mod["ForumMamans"];?></a>
			<?php } ?>

			<ul>
				<li><a href="<?php echo JL::url('index.php?app=groupe&action=list&groupe_type=joined'.'&'.$langue); ?>" title="<?php echo $lang_mod["VousEtesMembre"];?>"><?php echo $lang_mod["VousEtesMembre"];?> <span class="<?php echo $userStats->groupe_joined > 0 ? 'grey' : 'white'; ?>"><?php echo $userStats->groupe_joined; ?></span> <?php echo $userStats->groupe_joined > 1 ? $lang_mod["groupes"] : $lang_mod["groupe"]; ?>.</a></li>
			</ul>

			<?php if(is_array($groupes) && count($groupes) > 0) { ?>
			<table class="groupes" cellpadding="0" cellspacing="0">
				<tr><th colspan="2"><?php echo $lang_mod["DerniersGroupes"];?></th></tr>
				<?php foreach($groupes as $groupe) {

					// htmlentities
					JL::makeSafe($groupe);

					// si une photo a &eacute;t&eacute; envoy&eacute;e
					$filePath = 'images/groupe/'.$groupe->id.'-mini.jpg';
					if(is_file(SITE_PATH.'/'.$filePath)) {
						$image	= $filePath;
					} else {
						$image	= 'parentsolo/images/parent-solo-35.jpg';
					}
				?>
				<tr>
					<td class="photo"><a href="<?php echo JL::url('index.php?app=groupe&action=details&id='.$groupe->id.'&'.$langue); ?>" title="<?php echo $groupe->titre; ?>" target="_blank"><img src="<?php echo SITE_URL.'/'.$image; ?>" alt="<?php echo $groupe->titre; ?>" /></a></td>
					<td><a href="<?php echo JL::url('index.php?app=groupe&action=details&id='.$groupe->id.'&'.$langue); ?>" title="<?php echo $groupe->titre; ?>" target="_blank"><?php echo $groupe->titre; ?></a></td>
				</tr>
				<?php } ?>
			</table>
			<?php } ?>
		</div>

		<?php // s'il y a des actus
		if(is_array($actus) && count($actus) > 0) {
		?>
		<div class="panel-actu">
			<h3><?php echo $lang_mod["Actualites"];?></h3>
			<ul>
			<?	// pour chaque actu
				foreach($actus as $actu) {
					JL::makeSafe($actu);
					?>
					<li>
						<a href="<?php echo JL::url('index.php?app=redac&action=item&id='.$actu->id.'&'.$langue); ?>" title="<?php echo $row->titre; ?>">&raquo; <?php echo $actu->titre; ?></a><br />
						<span><?php echo $lang_mod["ActualiteDu"];?> <?php echo date('d/m/Y', strtotime($actu->date_add)); ?></span>
					</li>
				<?php 			} ?>
			</ul>
		</div>
		<?php 		}
		?>

		<?php // pas de photo, on affiche le popin
		if($noPhotoPopIn && $action == 'panel') { ?>
		<div class="noPhotoPopIn" id="noPhotoPopIn" onClick="document.location='<?php echo JL::url('index.php?app=profil&action=step2'.'&'.$langue); ?>';"><?php echo $lang_mod["EnvoyezUnePhoto"];?> !</div>
		<script language="javascript" type="text/javascript">
			var timerAlert2;
			$('noPhotoPopIn').fadeOut('hide');
			noPhotoPopIn(0);
		</script>
		<?php }?>

	</div>

	<?php 	} else {
		// base de donn&eacute;es en fonction de la langue
		$base = "panel_g_".$_GET['lang'];
		
		$redac = array();
		
		// compte le nombre de contenu actif
		$query = "SELECT id, titre, texte FROM ".$base." WHERE active= 1";
		$redac = $db->loadObjectList($query);
		
		// bloc de gauche al&eacute;atoire
		$num = JL::getSessionInt('redaction_bloc_gauche',0) % count($redac);
		
		?>
		<div class="redac redac<?php echo $redac[$num]->id; ?>" style="background: url(parentsolo/images/redac/redac<?php echo $redac[$num]->id.'_'.$_GET['lang']; ?>.jpg)  no-repeat;background-position: 10px 10px;">
			<span class="titre"><?php echo $redac[$num]->titre; ?></span>
			<?php echo $redac[$num]->texte; ?>
		</div>
		<?php 		
		JL::setSession('redaction_bloc_gauche',($num+1));

	}
?>

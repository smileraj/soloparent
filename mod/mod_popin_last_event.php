<?php
defined('JL') or die('Error 401');

	global $user, $db, $langue;
			include("lang/app_mod.".$_GET['lang'].".php");

	$elementRight	= 10; // position Right
	$elementBottom	= 10; // position Bottom
	$message = '';

	// user log
	if($user->id) {

		// check s'il y a un &eacute;v&eacute;nement
		$query = "SELECT us.last_event_user_id AS id, us.last_event_type, us.last_event_data, u.username, up.photo_defaut, up.genre"
		." FROM user_stats AS us"
		." INNER JOIN user AS u ON u.id = us.last_event_user_id"
		." INNER JOIN user_profil AS up ON up.user_id = us.last_event_user_id"
		." WHERE us.user_id = '".$db->escape($user->id)."' AND us.last_event_type > 0"
		;
		$userFrom = $db->loadObject($query);
		
		
		if($userFrom) {

			// reset le dernier &eacute;v&eacute;nement
			JL::addLastEvent($user->id, $userFrom->id);

			// r&eacute;cup la photo de l'utilisateur
			$photo = JL::userGetPhoto($userFrom->id, '89', 'profil', $userFrom->photo_defaut);

			// photo par d&eacute;faut
			if(!$photo) {
				$photo = SITE_URL.'/parentsolo/images/parent-solo-89-'.$userFrom->genre.'-'.$_GET['lang'].'.jpg';
			}


			// en fonction du type d'&eacute;v&eacute;nement
			switch($userFrom->last_event_type) {

				// ami connect&eacute;
				case 5:
					$message = ''.$lang_mod["NientDeSeConnecte"].'!';
				break;

				// envoi message chat
				case 4:
					$message = ''.$lang_mod["VousAEnvoyeUnMessage"].' <a href="javascript:windowOpen(\'ParentSoloChat\',\''.JL::url('index2.php?app=chat&id='.$userFrom->id.'&'.$langue).'\',\'800px\',\'600px\');" title="'.$lang_mod["Chat"].'">'.$lang_mod["Chat_s"].'</a> !';
				break;

				// envoi fleur
				case 3:
					$message = ''.$lang_mod["VientDeVousEnVoyer"].' <a href="'.JL::url('index.php?app=message&action=read&id='.$userFrom->last_event_data.'&'.$langue).'">'.$lang_mod["Rose"].'</a> !';
				break;

				// envoi message
				case 2:
					$message = ''.$lang_mod["VientDeVousEnVoyerUn"].' <a href="'.JL::url('index.php?app=message&action=read&id='.$userFrom->last_event_data.'&'.$langue).'">'.$lang_mod["Message2"].'</a> !';
				break;

				// consultation profil
				case 1:
					$message = ''.$lang_mod["EstEntrainDeConsulter"].' !';
				break;

			}

		}

		?>

		<div class="popin" id="popin">
		<?php 			// s'il y a un message &agrave; afficher
			if($message) {
			?>
				<a class="photo" style="background: url(<?php echo $photo; ?>) top repeat-x;" href="<?php echo JL::url('index.php?app=profil&action=view&id='.$userFrom->id.'&'.$langue); ?>"></a>
				<p style="background: url(<?php echo SITE_URL; ?>/parentsolo/images/event-<?php echo $userFrom->last_event_type; ?>.png) bottom no-repeat;"><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$userFrom->id.'&'.$langue); ?>" title="<?php echo $userFrom->genre == 'h' ? $lang_mod["VoirSonProfilH"] : $lang_mod["VoirSonProfilF"];?>"><?php echo $userFrom->username; ?></a> <?php echo $message; ?></p>
			<?php 			}
		?>
		</div>

		<script type="text/javascript">
			var popinTimer = 0;
			window.addEventListener('domready', function(){
				var element = 'popin';

				$(element).on('click', function(){this.fadeOut(0);});

				window.onresize = function(){positionPopIn(element, <?php echo $elementRight; ?>, <?php echo $elementBottom; ?>, 1)};
				window.onscroll = function(){positionPopIn(element, <?php echo $elementRight; ?>, <?php echo $elementBottom; ?>, 1)};

				$(element).fadeOut('hide');

				<?php 				// s'il y a un message &agrave; afficher
				if($message) {
				?>
					positionPopIn(element,<?php echo $elementRight; ?>,<?php echo $elementBottom; ?>,1);
					$(element).fadeOut('show');

					popinTimer = setInterval('popinfadeOut("'+element+'");', 4000);

				<?php 				}
				?>
			});
		</script>
	<?php 
	}

?>

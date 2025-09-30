<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

global $user, $db, $langue;
include("lang/app_mod.".$_GET['lang'].".php");

	// user log
	if($user->id) {

		// variables
		$where			= [];
		$_where			= '';

		$where[]		= "cm.user_id_to = '".$user->id."'";
		$where[]		= "cm.new_user_to = '1'";

		// g&eacute;n�re le where
		$_where			= " WHERE ".implode(' AND ', $where);

		// r&eacute;cup les conversations
		$query = "SELECT COUNT(*)"
		." FROM chat_message AS cm"
		.$_where
		;
		$newMessagesNb = $db->loadResult($query);

		?>
		<div id="chatSon"></div>
		<script type="text/javascript">
			var timerAlert = 0;
			var sonJoue = 0;

			if ($('#chatAlert1').length) {
        $('#chatAlert').fadeOut('slow'); // hides it slowly
    }

			<?php if($newMessagesNb > 0) { ?>
			window.addEventListener('domready', function(){
				$('#chatAlert1').on('click', function(){clearInterval(timerAlert);$('#chatAlert1').fadeOut(0);});

				$('#chatAlert1').set('html', '<div style="margin:20px 0 0 0;"><?php echo$lang_mod["VousAvez"];?><br /><b><?php echo $newMessagesNb; ?></b> <?php echo $newMessagesNb > 1 ? $lang_mod["NouveauxMessages"] : $lang_mod["NouveauMessage"]; ?><br /><?php echo $lang_mod["SurLeChat"]; ?>!</div>');

				swfobject.embedSWF("<?php echo SITE_URL; ?>/images/chatSon.swf", "chatSon", "1", "1", "8.0.0", "", { "width": "1", "height": "1" }, { "autoplay": "true", "loop": "false" }, { "id" : "chatSon" });

				timerAlert = setInterval('chatAlert()', 1500);

			});
			<?php } ?>
		</script>
	<?php 	}

?>

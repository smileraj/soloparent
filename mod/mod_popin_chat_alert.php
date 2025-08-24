<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $user, $db, $langue;
			include("lang/app_mod.".$_GET['lang'].".php");

	// user log
	if($user->id) {

		// variables
		$where			= array();
		$_where			= '';

		$where[]		= "cm.user_id_to = '".$user->id."'";
		$where[]		= "cm.new_user_to = '1'";

		// g&eacute;nère le where
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

			$('chatAlert').fade('hide');

			<? if($newMessagesNb > 0) { ?>
			window.addEvent('domready', function(){
				$('chatAlert').addEvent('click', function(){clearInterval(timerAlert);$('chatAlert').fade(0);});

				$('chatAlert').set('html', '<div style="margin:20px 0 0 0;"><?php echo$lang_mod["VousAvez"];?><br /><b><? echo $newMessagesNb; ?></b> <? echo $newMessagesNb > 1 ? $lang_mod["NouveauxMessages"] : $lang_mod["NouveauMessage"]; ?><br /><? echo $lang_mod["SurLeChat"]; ?>!</div>');

				swfobject.embedSWF("<? echo SITE_URL; ?>/images/chatSon.swf", "chatSon", "1", "1", "8.0.0", "", { "width": "1", "height": "1" }, { "autoplay": "true", "loop": "false" }, { "id" : "chatSon" });

				timerAlert = setInterval('chatAlert()', 1500);

			});
			<? } ?>
		</script>
	<?
	}

?>

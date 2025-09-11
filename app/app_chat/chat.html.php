<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	class HTML_chat {

		public static function chatTemplate($key, $user_id_to, $conversationsNb) {
			global $langue;
			include("lang/app_chat.".$_GET['lang'].".php");
			global $user;

			// chemin du template
			$template	= SITE_URL.'/'.SITE_TEMPLATE;

			$version	= 'v3';
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<html lang="fr">
			<head>
				<title><?php echo $lang_chat["ParentSoloChat"];?></title>
				<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
				<link href="<? echo $template.'/app_chat.css?'.$version; ?>" rel="stylesheet" type="text/css">
				<link href="<? echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon">
				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/mootools.js?<? echo $version; ?>"></script>
				<script type="text/javascript" src="<? echo SITE_URL; ?>/js/app_chat.js?<? echo $version; ?>"></script>
			</head>

			<body>

				<form name="chat" action="#" method="post">
				<div class="chatBody">

					<div class="chatConversations" id="chatConversations">
						<div class="conversationUsernameOn" id="chatHelp" onClick="document.location='<? echo SITE_URL.'/index2.php?app=chat&'.$langue; ?>';"><?php echo $lang_chat["Aide"];?></div>
						<div class="conversationCloseOff" style="visibility:hidden;">&nbsp;</div>
					</div>
					<div class="chatConversations2" id="chatConversations2">&nbsp;</div>
					<div class="chatContent" id="chatContent">
						<div class="chatHelp">
							<h2><?php echo $lang_chat["BienvenueSurChat"];?></h2>
							<p>
								<? if($conversationsNb) { ?>
									<b><?php echo $lang_chat["VousAvez"];?> <? echo $conversationsNb; ?> <?php echo $lang_chat["Conversation"];?><? echo $conversationsNb > 1 ? 's' : ''; ?> <?php echo $lang_chat["EnCours"];?>.</b><br>
									<br>
									<?php echo $lang_chat["CliquezSurOnglets"];?> !
								<? } else { ?>
									<?php echo $lang_chat["VousNAvezAucune"];?>.<br>
									<br>
									<b><?php echo $lang_chat["CliquezUneIcone"];?> !</b>
								<? } ?>
							</p>

							<h2><?php echo $lang_chat["PresentationChat"];?></h2>
							<p>
								<?php echo $lang_chat["LeChatDivide"];?>:<br>
								<ul>
									<li><?php echo $lang_chat["ListeConversations"];?></li>
									<li><?php echo $lang_chat["ProfilCorrespondant"];?></li>
									<li><?php echo $lang_chat["ConversationEnCours"];?></li>
									<li><?php echo $lang_chat["ZoneSaisieTexte"];?></li>
								</ul>
							</p>

							<h2><?php echo $lang_chat["MesConversations"];?></h2>
							<p>
								<?php echo $lang_chat["VousTrouvezAGauche"];?>:<br>
								<br>
								<img src="images/chat-aide-2.jpg" alt="Chat Parentsolo.ch"><br>
								<br>
								<?php echo $lang_chat["LorsqueUnePersonne"];?>.<br>
								<?php echo $lang_chat["VousPouvezCliquer"];?>.<br>
								<br>
								<?php echo $lang_chat["VoiciLaSignification"];?>:<br>
								<ul>
									<li><?php echo $lang_chat["RoseClair"];?></li>
									<li><?php echo $lang_chat["roseFonce"];?></li>
									<li><?php echo $lang_chat["NoirConversation"];?></li>
								</ul>

							</p>

							<h2><?php echo $lang_chat["MonCorrespomdant"];?></h2>
							<p>
								<?php echo $lang_chat["VousTrouvez"];?>:<br>
								<br>
								<img src="images/chat-aide-3.jpg" alt="Chat Parentsolo.ch"><br>
								<br>
								<?php echo $lang_chat["LorsqueVous"];?> <span style="color:#0F0;"><?php echo $lang_chat["EnLigne"];?></span> <?php echo $lang_chat["Ou"];?> <span style="color:#F00;"><?php echo $lang_chat["HorsLigne"];?></span>.<br>
								<br>
								<?php echo $lang_chat["SiVotrecorrespondant"];?> !
							</p>

							<h2><?php echo $lang_chat["MaConversationEnCours"];?></h2>
							<p>
								<?php echo $lang_chat["AuMilieuDeLaFenetre"];?>:<br>
								<br>
								<img src="images/chat-aide-4.jpg" alt="Chat Parentsolo.ch"><br>
								<br>
								<?php echo $lang_chat["EnRoseSAffiche"];?>.<br>
								<?php echo $lang_chat["LosqueVousOuvrez"];?>.<br>
								<?php echo $lang_chat["CestPourquoiLaDate"];?>.
							</p>

							<h2><?php echo $lang_chat["MaZoneDeSaisie"];?></h2>
							<p>
								<?php echo $lang_chat["EnBasVousPouvez"];?>:<br>
								<br>
								<img src="images/chat-aide-5.jpg" alt="Chat Parentsolo.ch"><br>
								<br>
								<?php echo $lang_chat["EnCliquantSur"];?>.<br>
								<?php echo $lang_chat["VousPouvezAussi"];?>.
							</p>
						</div>
					</div>
				</div>

				<input type="hidden" name="user_id_from" id="user_id_from" value="<? echo $user->id; ?>">
				<input type="hidden" name="key" id="key" value="<? echo $key; ?>">
				<input type="hidden" name="lang_id" id="lang_id" value="<? echo $_GET["lang"]; ?>">
				<input type="hidden" name="site_url" id="site_url" value="<? echo SITE_URL; ?>">
				</form>

				<script type="text/javascript">
				var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
				document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
				</script>
				<script type="text/javascript">
				try {
				var pageTracker = _gat._getTracker("UA-6463477-2");
				pageTracker._trackPageview();
				} catch(err) {}</script>
				<script language="javascript" type="text/javascript">
					var timerMessages = 0;
					var timerConversations = 0;

					chatGetConversations(<? echo $user_id_to; ?>);

					timerConversations = setInterval('chatGetConversations(0)', 10000);

					/* if($('user_id_to') && $('user_id_to').value > 0) { dans la fonction */
					timerMessages = setInterval('chatGetNewMessages()', 5000);

				</script>
			</body>

		</html>
		<?
		}

	}
?>
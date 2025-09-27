<?php 	require_once('ajax.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
        <head>
			<title><?php echo $langChat["ParentSoloChat"];?></title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<link href="<?php echo SITE_URL;?>/chat_new/chat.css" rel="stylesheet" type="text/css">
			<link href="<?php echo SITE_URL;?>/parentsolo/favicon.ico" rel="shortcut icon" type="image/x-icon">
	
			<script type="text/javascript" src="<?php echo SITE_URL;?>/js/jquery-1.4.1.min.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL;?>/js/jquery-ui-1.7.2.custom.min.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL;?>/chat_new/ajax.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL;?>/chat_new/chat.js"></script>
			<script type="text/javascript">
				function initPage(){

					//resizeToInnerSize(window);
					window.resizeTo(850,700);
					id_corresp = '<?php echo (isset($_GET["id"])&&$_GET["id"]>0)?$_GET["id"]:"0" ; ?>';
					document.sendForm.id_corresp.value=id_corresp;
					if(id_corresp){
						newConversation(id_corresp);
					}
					refresh();

				}
				window.onload = initPage;

			</script>
        </head>
        <body>
		<div class="chatBody">
			<div class="chatRight">
				<div class="chatUsers">
					<div class="chatUsersScroll">
						<div id="aide" class="helpLink" onclick="affichAide();"><p><?php echo $langChat["Aide"];?></p></div>
						<div id="openConv">
						</div>
					</div>
				</div>
				<div class="chatProfileFrom" id="chatProfileFrom">
					<?php 						getUtilisateur();
					?>
				</div>
			</div>
			<div class="chatLeft">
				<div id="chatHelp" <?php if (isset($_GET["id"])&&$_GET["id"]>0){echo 'style="display:none;"';}?>>
				<?php 					loadAide();
				?>
				</div>
				<div id="chatConversation" <?php if (!isset($_GET["id"])||$_GET["id"]<=0){echo 'style="display:none;"';}?>>
					<div class="chatProfileTo" id="chatProfileTo">
					</div>
					<div class="chatWarning">
						<img src="<?php echo SITE_URL;?>/chat2/images/warning.jpg" alt="warning"/><p><?php echo $langChat["warning"];?></p>
					</div>
					<div class="chatMessages">
						<div class="chatMessagesContent" id="chatMessagesContent">
						</div>
					</div>
					<div class="toolBar">
						<div class="smileyButton" onclick="if(document.getElementById('smileyMenu').style.display==''){document.getElementById('smileyMenu').style.display='none';}else{document.getElementById('smileyMenu').style.display='';}"></div>
						<div class="smileyMenu" id="smileyMenu" style="display:none;">
							<div class="closeMenu" onclick="closeMenuSmileys();"></div>
							
								<img onclick="chatSmiley('(C)');" alt="(C)" src="<?php echo SITE_URL;?>/chat2/images/smileys/coeur.gif" />
								<img onclick="chatSmiley('(B)');" alt="(B)" src="<?php echo SITE_URL;?>/chat2/images/smileys/cool.gif">
								<img onclick="chatSmiley('^.');" alt="^." src="<?php echo SITE_URL;?>/chat2/images/smileys/001_huh.gif">
								<img onclick="chatSmiley('8)');" alt="8)" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_rolleyes.gif">
								<img onclick="chatSmiley(':)');" alt=":)" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_smile.gif">
								<img onclick="chatSmiley(':p');" alt=":p" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_tongue.gif">
								<img onclick="chatSmiley('#)');" alt="#)" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_tt1.gif">
								<img onclick="chatSmiley(':q');" alt=":q" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_tt2.gif">
								
								<img onclick="chatSmiley(':s');" alt=":s" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_unsure.gif">
								<img onclick="chatSmiley('(A)');" alt="(A)" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_wub.gif">
								<img onclick="chatSmiley('v(');" alt="v(" src="<?php echo SITE_URL;?>/chat2/images/smileys/angry.gif">
								<img onclick="chatSmiley(':D');" alt=":D" src="<?php echo SITE_URL;?>/chat2/images/smileys/biggrin.gif">
								<img onclick="chatSmiley('%|');" alt="%|" src="<?php echo SITE_URL;?>/chat2/images/smileys/blink.gif">
								<img onclick="chatSmiley('(F)');" alt="(F)" src="<?php echo SITE_URL;?>/chat2/images/smileys/blush.gif">
								<img onclick="chatSmiley('(:F)');" alt="(:F)" src="<?php echo SITE_URL;?>/chat2/images/smileys/blushing.gif">
								<img onclick="chatSmiley(':/');" alt=":/" src="<?php echo SITE_URL;?>/chat2/images/smileys/bored.gif">
								
								<img onclick="chatSmiley('||');" alt="||" src="<?php echo SITE_URL;?>/chat2/images/smileys/closedeyes.gif">
								<img onclick="chatSmiley(':?');" alt=":?" src="<?php echo SITE_URL;?>/chat2/images/smileys/confused1.gif">
								<img onclick="chatSmiley(':\'(');" alt=":'(" src="<?php echo SITE_URL;?>/chat2/images/smileys/crying.gif">
								<img onclick="chatSmiley(':@');" alt=":@" src="<?php echo SITE_URL;?>/chat2/images/smileys/cursing.gif">
								<img onclick="chatSmiley('|/');" alt="|/" src="<?php echo SITE_URL;?>/chat2/images/smileys/glare.gif">
								<img onclick="chatSmiley('^D');" alt="^D" src="<?php echo SITE_URL;?>/chat2/images/smileys/laugh.gif">
								<img onclick="chatSmiley('(lol)');" alt="(lol)" src="<?php echo SITE_URL;?>/chat2/images/smileys/lol.gif">
								<img onclick="chatSmiley('(M)');" alt="(M)" src="<?php echo SITE_URL;?>/chat2/images/smileys/mad.gif">
								
								<img onclick="chatSmiley('OMG');" alt="OMG" src="<?php echo SITE_URL;?>/chat2/images/smileys/ohmy.gif">
								<img onclick="chatSmiley(':(');" alt=":(" src="<?php echo SITE_URL;?>/chat2/images/smileys/sad.gif">
								<img onclick="chatSmiley('%(');" alt="%(" src="<?php echo SITE_URL;?>/chat2/images/smileys/scared.gif">
								<img onclick="chatSmiley('(S)');" alt="(S)" src="<?php echo SITE_URL;?>/chat2/images/smileys/sleep.gif">
								<img onclick="chatSmiley('v)');" alt="v)" src="<?php echo SITE_URL;?>/chat2/images/smileys/sneaky2.gif">
								<img onclick="chatSmiley('(N)');" alt="(N)" src="<?php echo SITE_URL;?>/chat2/images/smileys/thumbdown.gif">
								<img onclick="chatSmiley('(2Y)');" alt="(2Y)" src="<?php echo SITE_URL;?>/chat2/images/smileys/thumbup.gif">
								<img onclick="chatSmiley('(Y)');" alt="(Y)" src="<?php echo SITE_URL;?>/chat2/images/smileys/thumbup1.gif">
								
								<img onclick="chatSmiley('%D');" alt="%)" src="<?php echo SITE_URL;?>/chat2/images/smileys/w00t.gif">
								<img onclick="chatSmiley(';)');" alt=";)" src="<?php echo SITE_URL;?>/chat2/images/smileys/wink.gif">
								<img onclick="chatSmiley(':P');" alt=":P" src="<?php echo SITE_URL;?>/chat2/images/smileys/tongue_smilie.gif">
								<img onclick="chatSmiley('(a)');" alt="(a)" src="<?php echo SITE_URL;?>/chat2/images/smileys/ange.gif">
								<img onclick="chatSmiley('(h)');" alt="(h)" src="<?php echo SITE_URL;?>/chat2/images/smileys/joie.gif">
								<img onclick="chatSmiley('(d)');" alt="(d)" src="<?php echo SITE_URL;?>/chat2/images/smileys/demon.gif">
								
								<img onclick="chatSmiley('(NO)');" alt="(NO)" src="<?php echo SITE_URL;?>/chat2/images/smileys/non.gif">
								<img onclick="chatSmiley('=|');" alt="=|" src="<?php echo SITE_URL;?>/chat2/images/smileys/mellow.gif">
								<img onclick="chatSmiley(';p');" alt=";p" src="<?php echo SITE_URL;?>/chat2/images/smileys/tire-la-langue-cligne.gif">
								<img onclick="chatSmiley('(b)');" alt="(b)" src="<?php echo SITE_URL;?>/chat2/images/smileys/boude.gif">
								<img onclick="chatSmiley('^D');" alt="^D" src="<?php echo SITE_URL;?>/chat2/images/smileys/charmeur.gif">
								<img onclick="chatSmiley('(danse)');" alt="(danse)" src="<?php echo SITE_URL;?>/chat2/images/smileys/danse.gif">
								<img onclick="chatSmiley('(ptdr)');" alt="(ptdr)" src="<?php echo SITE_URL;?>/chat2/images/smileys/ptdr.gif">
								
								<img onclick="chatSmiley('^^');" alt="^^" src="<?php echo SITE_URL;?>/chat2/images/smileys/^^.gif">
								<img onclick="chatSmiley(':\')');" alt=":')" src="<?php echo SITE_URL;?>/chat2/images/smileys/emu.gif">
								<img onclick="chatSmiley(':x');" alt=":x" src="<?php echo SITE_URL;?>/chat2/images/smileys/malade.gif">
								<img onclick="chatSmiley('(mouche)');" alt="(mouche)" src="<?php echo SITE_URL;?>/chat2/images/smileys/mouche.gif">
								<img onclick="chatSmiley('(xd)');" alt="(xd)" src="<?php echo SITE_URL;?>/chat2/images/smileys/xd.gif">
								<img onclick="chatSmiley('(uC)');" alt="(uC)" src="<?php echo SITE_URL;?>/chat2/images/smileys/coeur_briser.png">
						</div>
					</div>
					<div class="chatSend">
						<form name="sendForm">
							<input type="hidden" name="user_id_from" id="user_id_from" value="<?php echo$user->id;?>">
							<input type="hidden" name="lang" id="lang_id" value="<?php echo$_GET["lang"];?>">
							<input type="hidden" name="waiting" id="waiting" value="off">
							<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL;?>">
							<input type="hidden" name="id_corresp" id="id_corresp" value="<?php echo (isset($_GET["id_corresp"])&&$_GET["id_corresp"]>0)?$_GET["id_corresp"]:"0" ; ?>">
							<input type="hidden" name="user_id_to_close" id="user_id_to_close" value="0">
							<input type="hidden" name="closeConfirm" value="<?php echo utf8_decode($langChat["closeConvConfirm"]); ?>">
							<textarea name="texte" id="texte" class="texte" onKeyUp="actionMessage(event);"></textarea>
							<div class="envoyer" onClick="sendMessage();"><?php echo $langChat["Envoyer"]; ?></div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<?php 	require_once('ajax.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
        <head>
			<title><?php echo $langChat["ParentSoloChat"];?></title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<meta http-equiv="X-UA-Compatible" content="IE=9" />
			<!--<link href="<?php echo SITE_URL;?>/chat2/chat.css" rel="stylesheet" type="text/css">-->
			<link href="<?php echo SITE_URL;?>/parentsolo/favicon.ico" rel="shortcut icon" type="image/x-icon">
			<!--chat css-->
			<link rel="stylesheet" href="<?php echo SITE_URL;?>/chat2/templates/font/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo SITE_URL;?>/chat2/templates/css/reset.css">
    <link rel="stylesheet" href="<?php echo SITE_URL;?>/chat2/templates/css/style.css">
	<style>
        /*Loader start*/

        .hidden {
            display: none!important;
            visibility: hidden!important;
        }
        .text-center {
            text-align: center;
        }
        .Dboot-preloader {
            /* padding-top: 20%; */
            background-color: #fff;
            display: block;
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 999999999999999;
        }

        /*Loader end*/

    </style>
			<!-- end chat css-->
			
	
			<script type="text/javascript" src="<?php echo SITE_URL;?>/js/jquery-1.4.1.min.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL;?>/js/jquery-ui-1.7.2.custom.min.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL;?>/chat2/ajax.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL;?>/chat2/chat.js"></script>
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
		
		<!--<div class="Dboot-preloader text-center">
    <img src="<?php echo SITE_URL;?>/chat2/templates/img/loader.gif" width="400"/>
</div>-->


<div class="wrapper">
    <div class="container">
        <div class="left">
            <div class="top">
                <input type="text" class="live-search-box" placeholder="search here" />
                <a href="javascript:;" class="search"></a>
            </div>
            <ul class="live-search-list people" style="overflow-y:scroll; height:484px;overflow-x:hidden">
						<div id="openConv">
							</div>
                
                    
                
                    <li class="person" id="chatbox1_wscopel" data-chat="person_7" href="javascript:void(0)" onclick="javascript:chatWith('wscopel','7','avatar_default.png','Offline')">
                        <div class="chatboxhead">
                            <span class="userimage">
                               <img class="direct-chat-img" src="storage/user_image/avatar_default.png" alt="wscopel" />
                            </span>
                            <span class="bname name">wscopel</span>
                            <span class="time Offline"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <span class="hidecontent">
                                <input id="to_id" name="to_id" value="7" type="hidden">
                                <input id="to_uname" name="to_uname" value="wscopel" type="hidden">
                                <input id="from_uname" name="from_uname" value="Beenny" type="hidden">
                            </span>
                            <span class="preview project">Web Developer</span>
                        </div>
                    </li>
                
                
            </ul>
        </div>
        <div class="right" id="right">
		<div class="chatProfileTo" id="chatProfileTo">
						</div>
						<div class="chatWarning">
							<img src="<?php echo SITE_URL;?>/chat2/images/warning.jpg" alt="warning"/><p><?php echo $langChat["warning"];?></p>
						</div>
						<div class="chatMessages">
							<div class="chatMessagesContent" id="chatMessagesContent">
							</div>
						</div>
            <div class="top chatboxhead">
                <span style="float: right">Project:
                    <span class="project">Title</span>
                </span>
                <span style="float: left">
                    <span class="userimage"><img src="storage/user_image/avatar_40x40.png" alt="image"></span>
                    <span class="name">Name</span>
                </span>
            </div>

            <div id="resultchat">
                <img id="loader" src='http://www.flexiglide.co.uk/img/loading.gif'>
                <!-- Here chating messages content will be show by inbox.JS-->
            </div>

            <img id="loadmsg" src="img/chatloading.gif">
        </div>
    </div>
</div>
		
		<div class="body">
			<div class="chatBody">
				<div class="chatRight">
					<div class="chatUsers">
						<div class="chatUsersScroll">
							<div id="aide" class="helpLink" onclick="affichAide();"><p><?php echo $langChat["Aide"];?></p></div>
							<!--<div id="openConv">
							</div>-->
						</div>
					</div>
					<div class="chatProfileFrom" id="chatProfileFrom">
						<?php 							getUtilisateur();
						?>
					</div>
				</div>
				<div class="chatLeft">
					<div id="chatHelp" <?php if (isset($_GET["id"])&&$_GET["id"]>0){echo 'style="display:none;"';}?>>
					<?php 						loadAide();
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
									<img onclick="chatSmiley('(^.)');" alt="^." src="<?php echo SITE_URL;?>/chat2/images/smileys/001_huh.gif">
									<img onclick="chatSmiley('(8)');" alt="8)" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_rolleyes.gif">
									<img onclick="chatSmiley('(:))');" alt=":)" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_smile.gif">
									<img onclick="chatSmiley('(:p)');" alt=":p" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_tongue.gif">
									<img onclick="chatSmiley('(\\))');" alt="\\)" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_tt1.gif">
									<img onclick="chatSmiley('(:q)');" alt=":q" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_tt2.gif">
									
									<img onclick="chatSmiley('(:s)');" alt=":s" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_unsure.gif">
									<img onclick="chatSmiley('(A)');" alt="(A)" src="<?php echo SITE_URL;?>/chat2/images/smileys/001_wub.gif">
									<img onclick="chatSmiley('(v()');" alt="v(" src="<?php echo SITE_URL;?>/chat2/images/smileys/angry.gif">
									<img onclick="chatSmiley('(:D)');" alt=":D" src="<?php echo SITE_URL;?>/chat2/images/smileys/biggrin.gif">
									<img onclick="chatSmiley('(%|)');" alt="%|" src="<?php echo SITE_URL;?>/chat2/images/smileys/blink.gif">
									<img onclick="chatSmiley('(F)');" alt="(F)" src="<?php echo SITE_URL;?>/chat2/images/smileys/blush.gif">
									<img onclick="chatSmiley('(:F)');" alt="(:F)" src="<?php echo SITE_URL;?>/chat2/images/smileys/blushing.gif">
									<img onclick="chatSmiley('(:/)');" alt=":/" src="<?php echo SITE_URL;?>/chat2/images/smileys/bored.gif">
									
									<img onclick="chatSmiley('(||)');" alt="||" src="<?php echo SITE_URL;?>/chat2/images/smileys/closedeyes.gif">
									<img onclick="chatSmiley('(:?)');" alt=":?" src="<?php echo SITE_URL;?>/chat2/images/smileys/confused1.gif">
									<img onclick="chatSmiley('(:\'()');" alt=":'(" src="<?php echo SITE_URL;?>/chat2/images/smileys/crying.gif">
									<img onclick="chatSmiley('(:@)');" alt=":@" src="<?php echo SITE_URL;?>/chat2/images/smileys/cursing.gif">
									<img onclick="chatSmiley('(|/)');" alt="|/" src="<?php echo SITE_URL;?>/chat2/images/smileys/glare.gif">
									<img onclick="chatSmiley('(^D)');" alt="^D" src="<?php echo SITE_URL;?>/chat2/images/smileys/laugh.gif">
									<img onclick="chatSmiley('(lol)');" alt="(lol)" src="<?php echo SITE_URL;?>/chat2/images/smileys/lol.gif">
									<img onclick="chatSmiley('(M)');" alt="(M)" src="<?php echo SITE_URL;?>/chat2/images/smileys/mad.gif">
									
									<img onclick="chatSmiley('(OMG)');" alt="OMG" src="<?php echo SITE_URL;?>/chat2/images/smileys/ohmy.gif">
									<img onclick="chatSmiley('(:()');" alt=":(" src="<?php echo SITE_URL;?>/chat2/images/smileys/sad.gif">
									<img onclick="chatSmiley('(%()');" alt="%(" src="<?php echo SITE_URL;?>/chat2/images/smileys/scared.gif">
									<img onclick="chatSmiley('(S)');" alt="(S)" src="<?php echo SITE_URL;?>/chat2/images/smileys/sleep.gif">
									<img onclick="chatSmiley('(v))');" alt="v)" src="<?php echo SITE_URL;?>/chat2/images/smileys/sneaky2.gif">
									<img onclick="chatSmiley('(N)');" alt="(N)" src="<?php echo SITE_URL;?>/chat2/images/smileys/thumbdown.gif">
									<img onclick="chatSmiley('(2Y)');" alt="(2Y)" src="<?php echo SITE_URL;?>/chat2/images/smileys/thumbup.gif">
									<img onclick="chatSmiley('(Y)');" alt="(Y)" src="<?php echo SITE_URL;?>/chat2/images/smileys/thumbup1.gif">
									
									<img onclick="chatSmiley('(%D)');" alt="%)" src="<?php echo SITE_URL;?>/chat2/images/smileys/w00t.gif">
									<img onclick="chatSmiley('(;))');" alt=";)" src="<?php echo SITE_URL;?>/chat2/images/smileys/wink.gif">
									<img onclick="chatSmiley('(:P)');" alt=":P" src="<?php echo SITE_URL;?>/chat2/images/smileys/tongue_smilie.gif">
									<img onclick="chatSmiley('(a)');" alt="(a)" src="<?php echo SITE_URL;?>/chat2/images/smileys/ange.gif">
									<img onclick="chatSmiley('(h)');" alt="(h)" src="<?php echo SITE_URL;?>/chat2/images/smileys/joie.gif">
									<img onclick="chatSmiley('(d)');" alt="(d)" src="<?php echo SITE_URL;?>/chat2/images/smileys/demon.gif">
									
									<img onclick="chatSmiley('(NO)');" alt="(NO)" src="<?php echo SITE_URL;?>/chat2/images/smileys/non.gif">
									<img onclick="chatSmiley('(=|)');" alt="=|" src="<?php echo SITE_URL;?>/chat2/images/smileys/mellow.gif">
									<img onclick="chatSmiley('(;p)');" alt=";p" src="<?php echo SITE_URL;?>/chat2/images/smileys/tire-la-langue-cligne.gif">
									<img onclick="chatSmiley('(b)');" alt="(b)" src="<?php echo SITE_URL;?>/chat2/images/smileys/boude.gif">
									<img onclick="chatSmiley('(^^D)');" alt="^D" src="<?php echo SITE_URL;?>/chat2/images/smileys/charmeur.gif">
									<img onclick="chatSmiley('(danse)');" alt="(danse)" src="<?php echo SITE_URL;?>/chat2/images/smileys/danse.gif">
									<img onclick="chatSmiley('(ptdr)');" alt="(ptdr)" src="<?php echo SITE_URL;?>/chat2/images/smileys/ptdr.gif">
									
									<img onclick="chatSmiley('(^^)');" alt="^^" src="<?php echo SITE_URL;?>/chat2/images/smileys/^^.gif">
									<img onclick="chatSmiley('(:\'))');" alt=":')" src="<?php echo SITE_URL;?>/chat2/images/smileys/emu.gif">
									<img onclick="chatSmiley('(:x)');" alt=":x" src="<?php echo SITE_URL;?>/chat2/images/smileys/malade.gif">
									<img onclick="chatSmiley('(mouche)');" alt="(mouche)" src="<?php echo SITE_URL;?>/chat2/images/smileys/mouche.gif">
									<img onclick="chatSmiley('(xd)');" alt="(xd)" src="<?php echo SITE_URL;?>/chat2/images/smileys/xd.gif">
									<img onclick="chatSmiley('(uC)');" alt="(uC)" src="<?php echo SITE_URL;?>/chat2/images/smileys/coeur_briser.png">
							</div>
						</div>
						<div class="chatSend">
							<form name="sendForm">
								<input type="hidden" name="user_id_from" id="user_id_from" value="<?php echo $user->id;?>">
								<input type="hidden" name="lang" id="lang_id" value="<?php echo$_GET["lang"];?>">
								<input type="hidden" name="waiting" id="waiting" value="off">
								<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL;?>">
								<input type="hidden" name="id_corresp" id="id_corresp" value="<?php echo (isset($_GET["id_corresp"])&&$_GET["id_corresp"]>0)?$_GET["id_corresp"]:"0" ; ?>">
								<input type="hidden" name="user_id_to_close" id="user_id_to_close" value="0">
								<input type="hidden" name="closeConfirm" value="<?php echo mb_convert_encoding((string) $langChat["closeConvConfirm"], 'ISO-8859-1'); ?>">
								<textarea name="texte" id="texte" class="texte" onKeyUp="actionMessage(event);"></textarea>
								<div class="envoyer" onClick="sendMessage();"><?php echo $langChat["Envoyer"]; ?></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
<!--		
<script type="text/javascript" src="<?php echo SITE_URL;?>/chat2/templates/chatjs/jquery.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>/chat2/templates/chatjs/lightbox.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>/chat2/templates/chatjs/inbox.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>/chat2/templates/js/index.js"></script>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

-->
<!--start Toggle for smiley -->

		
	</body>
</html>

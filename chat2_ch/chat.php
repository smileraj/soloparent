<?
	require_once('ajax.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
        <head>
			<title><? echo $langChat["ParentSoloChat"];?></title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<meta http-equiv="X-UA-Compatible" content="IE=9" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link href="<? echo SITE_URL;?>/chat2/parentsolo.css" rel="stylesheet" type="text/css" />
		
			<link href="<? echo SITE_URL;?>/chat2/chat.css" rel="stylesheet" type="text/css">
			<link href="<? echo SITE_URL;?>/parentsolo/favicon.ico" rel="shortcut icon" type="image/x-icon">
	<link href="<? echo SITE_URL;?>/parentsolo/favicon.ico" rel="shortcut icon" type="image/x-icon">
			<!--chat css-->
			<link rel="stylesheet" href="<? echo SITE_URL;?>/chat2/templates/font/font-awesome.min.css">
   <!-- <link rel="stylesheet" href="<? echo SITE_URL;?>/chat2/templates/css/reset.css">-->
    <link rel="stylesheet" href="<? echo SITE_URL;?>/chat2/templates/css/style.css">
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
			<script type="text/javascript" src="<? echo SITE_URL;?>/js/jquery-1.4.1.min.js"></script>
			<script type="text/javascript" src="<? echo SITE_URL;?>/js/jquery-ui-1.7.2.custom.min.js"></script>
			<script type="text/javascript" src="<? echo SITE_URL;?>/chat2/ajax.js"></script>
			<script type="text/javascript" src="<? echo SITE_URL;?>/chat2/chat.js"></script>
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
				
								
				String.prototype.replaceAll = function(searchStr, replaceStr) {
						var str = this;					
						// no match exists in string?
						if(str.indexOf(searchStr) === -1) {
							// return string
							return str;
						}					
						// replace and remove first match, and do another recursirve search/replace
						return (str.replace(searchStr, replaceStr)).replaceAll(searchStr, replaceStr);
					}

				function badwordreplace(textbox){
					var outputStr = '';
					var text_box_val=textbox.value;
					    var badwords_list=new Array();
						badwords_list=['anal','anus','ass','bastard','bitch','boob','cock','cum','cunt','dick','dildo','dyke','fag','faggot','fuck','fuk','handjob','homo','jizz','kike','kunt','muff','nigger','penis','piss','poop','pussy','queer','rape','semen','sex','shit','slut','titties','twat','vagina','vulva','wank','abruti','abrutie','baise','baisé','baiser','batard','bite','bougnoul','branleur','burne','chier','cocu','con','connard','connasse','conne','couille','couillon','couillonne','crevard','cul','encule','enculé','enculee','enculée','enculer','enfoire','enfoiré','fion','foutre','merde','negre','nègre','negresse','négresse','nique','niquer','partouze','pd','pede','pédé','petasse','pétasse','pine','pouffe','pouffiasse','putain','pute','salaud','salop','salopard','salope','sodomie','sucer','tapette','tare','taré','vagin','zob','arschfotze','arschgeige','arschgesicht','arschloch','fotze','bulle','furz','depp','möpse','drecksau','bastard','fick','muschi','sackgesicht','kackbratze','hurensohn','trottel','dummbatz','schlampe','dummkopf','fettbacke','fotze','hirnlos','kack','luder','stricher','miststück','muterfiker','mutterficker','onanieren','pisser','scheissen','scheißhaus','schise','schlampe','schwanz','schwanzlutscher','schweinepriester','schwuchtel','schwul','schwuler','scheisse','scheiße','scheise','trottel','fick','ficken','jud','jude','nazi','nsdap','dreck','wichser','wixer','wixen','sau','bums','arschloch','arsch','schwanz','fotze','hure','schlampe','titten','fotz','hitler','heil','opfer'];
						for(var index=0; index<badwords_list.length; index++){
							var tempStr = badwords_list[index];
							text_box_val = String(text_box_val).replaceAll(tempStr,'*****');
							
						}
						textbox.value = text_box_val;
				}
				
				
				
			</script>
        </head>
        <body>
			<div class="Dboot-preloader text-center">
    <img src="<? echo SITE_URL;?>/chat2/templates/img/loader.gif" width="400"/>
</div>


<div class="wrapper">
    <div class="container">
		<div class="row">
			<div class="col-md-4  col-sm-4 parentsolo_plr_0">
        <div class="left">
            
            <ul class="live-search-list people" style="overflow-y:scroll; height:530px;overflow-x:hidden">

                <div id="aide" class="helpLink" onclick="affichAide();"><p><? echo $langChat["Aide"];?></p></div>
							<div id="openConv">
							</div>
                   
                
                
            </ul>
        </div></div>
			<div class="col-md-8  col-sm-8 parentsolo_plr_0 resparentsolo_plr_0">
        <div class="right" id="right">
          

            <div id="resultchat">
				<div id="chatHelp" <? if (isset($_GET["id"])&&$_GET["id"]>0){echo 'style="display:none;"';}?>>
					<?
						loadAide();
					?>
					</div>
					<div id="chatConversation" <? if (!isset($_GET["id"])||$_GET["id"]<=0){echo 'style="display:none;"';}?>>
						<div class="chatProfileTo" id="chatProfileTo">
						</div>
						<!--<div class="chatWarning">
							<img src="<? echo SITE_URL;?>/chat2/images/warning.jpg" alt="warning"/><p><? echo $langChat["warning"];?></p>
						</div>-->
						<div class="chatMessages">
							<div class="chatMessagesContent" id="chatMessagesContent">
							</div>
						</div>
						<div class="toolBar">
							<!--<div class="smileyButton" onclick="if(document.getElementById('smileyMenu').style.display==''){document.getElementById('smileyMenu').style.display='none';}else{document.getElementById('smileyMenu').style.display='';}"></div>-->
							<div class="smileyMenu emoji-panel-body target-emoji" id="smileyMenu" style="display:none;">
								<!--<div class="closeMenu" onclick="closeMenuSmileys();"></div>-->
								
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
								<div class="write"><a  href="javascript:void(0)" class="write-smiley"   onclick="if(document.getElementById('smileyMenu').style.display==''){document.getElementById('smileyMenu').style.display='none';}else{document.getElementById('smileyMenu').style.display='';}"></a>
								<input type="hidden" name="user_id_from" id="user_id_from" value="<?php echo $user->id;?>">
								<input type="hidden" name="lang" id="lang_id" value="<?php echo$_GET["lang"];?>">
								<input type="hidden" name="waiting" id="waiting" value="off">
								<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL;?>">
								<input type="hidden" name="id_corresp" id="id_corresp" value="<?php echo (isset($_GET["id_corresp"])&&$_GET["id_corresp"]>0)?$_GET["id_corresp"]:"0" ; ?>">
								<input type="hidden" name="user_id_to_close" id="user_id_to_close" value="0">
								<input type="hidden" name="closeConfirm" value="<? echo utf8_decode($langChat["closeConvConfirm"]); ?>">
								<textarea name="texte" id="texte" class="texte" onKeyUp="badwordreplace(this);actionMessage(event);"></textarea>
								<div class="envoyer1_btn" class="chatboxtextarea" onClick="sendMessage();"><i class="fa fa-paper-plane" aria-hidden="true"></i></div>
								<span class="hidecontent"></span>
								</div>
								
							</form>
						</div>
					</div>
                <!--<img id="loader" src='http://www.flexiglide.co.uk/img/loading.gif'>
                 Here chating messages content will be show by inbox.JS-->
            </div>

            <img id="loadmsg" src="img/chatloading.gif">
        </div>
    </div>
</div>
		</div></div>	
			
		<!--<div class="body">
			<div class="chatBody">
				<div class="chatRight">
					<div class="chatUsers">
						<div class="chatUsersScroll">
							<div id="aide" class="helpLink" onclick="affichAide();"><p><? echo $langChat["Aide"];?></p></div>
							<div id="openConv">
							</div>
						</div>
					</div>
					<div class="chatProfileFrom" id="chatProfileFrom">
						<?
							getUtilisateur();
						?>
					</div>
				</div>
				<div class="chatLeft">
					<div id="chatHelp" <? if (isset($_GET["id"])&&$_GET["id"]>0){echo 'style="display:none;"';}?>>
					<?
						loadAide();
					?>
					</div>
					<div id="chatConversation" <? if (!isset($_GET["id"])||$_GET["id"]<=0){echo 'style="display:none;"';}?>>
						<div class="chatProfileTo" id="chatProfileTo">
						</div>
						<div class="chatWarning">
							<img src="<? echo SITE_URL;?>/chat2/images/warning.jpg" alt="warning"/><p><? echo $langChat["warning"];?></p>
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
								<input type="hidden" name="closeConfirm" value="<? echo utf8_decode($langChat["closeConvConfirm"]); ?>">
								<textarea name="texte" id="texte" class="texte" onKeyUp="actionMessage(event);"></textarea>
								<div class="envoyer" onClick="sendMessage();"><? echo $langChat["Envoyer"]; ?></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<? echo SITE_URL;?>/chat2/templates/chatjs/jquery.js"></script>
<script type="text/javascript" src="<? echo SITE_URL;?>/chat2/templates/chatjs/lightbox.js"></script>
<script type="text/javascript" src="<? echo SITE_URL;?>/chat2/templates/chatjs/inbox.js"></script>
<script type="text/javascript" src="<? echo SITE_URL;?>/chat2/templates/js/index.js"></script>
--><!--start Toggle for smiley -->
<script type = "text/javascript" language = "javascript">

    $(document).ready(function() {
        $(".embtn").click(function(event){
            var client = $('.chat.active-chat').attr('client');
            var prevMsg = $("#chatbox_"+client+" .chatboxtextarea").val();
            var emotiText = $(event.target).attr("alt");

            $("#chatbox_"+client+" .chatboxtextarea").val(prevMsg+' '+emotiText);
            $("#chatbox_"+client+" .chatboxtextarea").focus();
        });
    });

    function chatemoji() {
        $(".target-emoji").toggle( 'fast', function(){
        });
        var heit = $('#resultchat').css('max-height');
        if(heit == '458px'){
            $('#resultchat').css('max-height', '360px');
            $('#resultchat').css('min-height', '360px');
        }
        else{
            $('#resultchat').css('max-height', '458px');
            $('#resultchat').css('min-height', '458px');
        }
    }


</script>
<!--start Toggle for smiley -->

<script>
    $(window).load(function() {
        $('.Dboot-preloader').addClass('hidden');
    });
</script>

<script>

/*Get get on scroll*/
    $("#resultchat").scrollTop($("#resultchat")[0].scrollHeight);
    // Assign scroll function to chatBox DIV
    $('#resultchat').scroll(function(){
        if ($('#resultchat').scrollTop() == 0){

            var client = $('.chat.active-chat').attr('client');

            if($("#chatbox_"+client+" .pagenum:first").val() != $("#chatbox_"+client+" .total-page").val()) {

                $('#loader').show();
                var pagenum = parseInt($("#chatbox_"+client+" .pagenum:first").val()) + 1;

                var URL = siteurl+'chat.php?page='+pagenum+'&action=get_all_msg&client='+client;

                get_all_msg(URL);                                       // Calling get_all_msg function

                $('#loader').hide();									// Hide loader on success

                if(pagenum != $("#chatbox_"+client+" .total-page").val()) {
                    setTimeout(function () {										//Simulate server delay;

                        $('#resultchat').scrollTop(100);							// Reset scroll
                    }, 458);
                }
            }

        }
    });
/*Get get on scroll*/

//Inbox User search
    jQuery(document).ready(function($){

        $('.live-search-list li').each(function(){
            $(this).attr('data-search-term', $(this).text().toLowerCase());
        });

        $('.live-search-box').on('keyup', function(){

            var searchTerm = $(this).val().toLowerCase();

            $('.live-search-list li').each(function(){

                if ($(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }

            });

        });

    });


</script>
	</body>
</html>

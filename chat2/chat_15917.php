<?
	require_once('ajax.php');
	html_entity_decode( $newContent, ENT_NOQUOTES, 'UTF-8' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
        <head>
			<title><? echo $langChat["ParentSoloChat"];?></title>
			<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
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
.close{
	    float: right !important;
    line-height: 40px;
    font-size: 17px;
    padding-right: 20px;
    color: #b90003;
    opacity: 1 !important;
}
        /*Loader end*/

	
	#searchid
	{
	width: 100%;
    border: solid 2px rgb(218, 218, 218);
    padding: 8px;
   /*  margin-top: 12px; */
    border-radius: 17px;
    font-size: 13px;
	}
	#result
	{
		    position: absolute;
    width: 92%;
    border-radius: 3px;
    z-index: 1;
    display: none;
    margin-top: 3px;
    margin-left: 2%;
    border-top: 0px;
    overflow: hidden;
    background-color: rgb(239, 239, 239);
	}
	.search_div{
		padding: 10px 15px 10px 5px;
	}
	.show
	{
		padding:10px; 
		border-bottom:1px #999 dashed;
		font-size:15px; 
		height:50px;
	}
	.show:hover
	{
		background:rgb(160, 158, 158) !important;
		color:#FFF;
		cursor:pointer;
	}
	
.tabs-menu {
    height: 30px;
    float: left;
    clear: both;
}

.tabs-menu li {
    height: 30px;
    line-height: 30px;
    float: left;
    margin-right: 10px;
    background-color: #ccc;
    border-top: 1px solid #d4d4d1;
    border-right: 1px solid #d4d4d1;
    border-left: 1px solid #d4d4d1;
}

.tabs-menu li.current {
    position: relative;
    background-color: #fff;
    border-bottom: 1px solid #fff;
    z-index: 5;
}

.tabs-menu li a {
    padding: 10px;
    text-transform: uppercase;
    color: #fff;
    text-decoration: none; 
}

.tabs-menu .current a {
    color: #2e7da3;
}

.tab {
    border: 1px solid #d4d4d1;
    background-color: #fff;
    float: left;
    margin-bottom: 20px;
    width: auto;
}

.tab-content {
    width: 660px;
    padding: 20px;
    display: none;
}

#tab-1 {
 display: block;   
}
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
						
					<?
				if($_GET['lang']=='fr'){
			?>
			badwords_list=['anal','anus','ass ','bastard','bitch','boob','cock ','cum ','cunt ','dick','dildo','dyke','fag ','faggot','fuck','fuk','handjob','homo','jizz','kike','kunt','muff','nigger','penis','piss','poop','pussy','queer','rape','semen','sex','shit','slut','titties','twat','vagina','vulva','wank','abruti','abrutie','baise','baisé','baiser','batard','bite','bougnoul','branleur','burne','chier','cocu','con ','connard','connasse','conne','couille','couillon','couillonne','crevard','cul ','encule','enculé','enculee','enculée','enculer','enfoire','enfoiré','fion','foutre','merde','negre','nègre','negresse','négresse','nique','niquer','partouze','pede','pédé','petasse','pétasse','pine','pouffe','pouffiasse','putain','pute','salaud','salop','salopard','salope','sodomie','sucer','tapette','tare','taré','vagin','zob'];
			<?
				}elseif($_GET['lang']=='en'){
			?>
			badwords_list=['anal','anus','ass ','bastard','bitch','boob','cock ','cum ','cunt ','dick','dildo','dyke','fag ','faggot','fuck','fuk','handjob','homo','jizz','kike','kunt','muff','nigger','penis','piss','poop','pussy','queer','rape','semen','sex','shit','slut','titties','twat','vagina','vulva','wank','abruti','abrutie','baise','baisé','baiser','batard','bite','bougnoul','branleur','burne','chier','cocu','con ','connard','connasse','conne','couille','couillon','couillonne','crevard','cul ','encule','enculé','enculee','enculée','enculer','enfoire','enfoiré','fion','foutre','merde','negre','nègre','negresse','négresse','nique','niquer','partouze','pede','pédé','petasse','pétasse','pine','pouffe','pouffiasse','putain','pute','salaud','salop','salopard','salope','sodomie','sucer','tapette','tare','taré','vagin','zob'];
			<?
				}elseif($_GET['lang']=='de'){
			?>
			badwords_list=['anal','anus','ass ','bastard','bitch','boob','cock ','cum ','cunt ','dick','dildo','dyke','fag','faggot','fuck','fuk','handjob','homo','jizz','kike','kunt','muff','nigger','penis','piss','poop','pussy','queer','rape','semen','sex','shit','slut','titties','twat','vagina','vulva','wank','arschfotze','arschgeige','arschgesicht','arschloch','fotze','bulle','furz','depp','möpse','drecksau','bastard','fick','muschi','sackgesicht','kackbratze','hurensohn','trottel','dummbatz','schlampe','dummkopf','fettbacke','fotze','hirnlos','kack','luder','stricher','miststück','muterfiker','mutterficker','onanieren','pisser','scheissen','scheißhaus','schise','schlampe','schwanz','schwanzlutscher','schweinepriester','schwuchtel','schwul','schwuler','scheisse','scheiße','scheise','trottel','fick','ficken','jud','jude','nazi','nsdap','dreck','wichser','wixer','wixen','sau','bums','arschloch','arsch','schwanz','fotze','hure','schlampe','titten','fotz','hitler','heil','opfer'];
			<?
			}
			?>
						/* badwords_list=['anal','anus','ass','bastard','bitch','boob','cock','cum','cunt','dick','dildo','dyke','fag','faggot','fuck','fuk','handjob','homo','jizz','kike','kunt','muff','nigger','penis','piss','poop','pussy','queer','rape','semen','sex','shit','slut','titties','twat','vagina','vulva','wank','abruti','abrutie','baise','baisé','baiser','batard','bite','bougnoul','branleur','burne','chier','cocu','con','connard','connasse','conne','couille','couillon','couillonne','crevard','cul','encule','enculé','enculee','enculée','enculer','enfoire','enfoiré','fion','foutre','merde','negre','nègre','negresse','négresse','nique','niquer','partouze','pd','pede','pédé','petasse','pétasse','pine','pouffe','pouffiasse','putain','pute','salaud','salop','salopard','salope','sodomie','sucer','tapette','tare','taré','vagin','zob','arschfotze','arschgeige','arschgesicht','arschloch','fotze','bulle','furz','depp','möpse','drecksau','bastard','fick','muschi','sackgesicht','kackbratze','hurensohn','trottel','dummbatz','schlampe','dummkopf','fettbacke','fotze','hirnlos','kack','luder','stricher','miststück','muterfiker','mutterficker','onanieren','pisser','scheissen','scheißhaus','schise','schlampe','schwanz','schwanzlutscher','schweinepriester','schwuchtel','schwul','schwuler','scheisse','scheiße','scheise','trottel','fick','ficken','jud','jude','nazi','nsdap','dreck','wichser','wixer','wixen','sau','bums','arschloch','arsch','schwanz','fotze','hure','schlampe','titten','fotz','hitler','heil','opfer']; */
						for(var index=0; index<badwords_list.length; index++){
							var tempStr = badwords_list[index];
							text_box_val = String(text_box_val).replaceAll(tempStr,'*****');
							
						}
						textbox.value = text_box_val;
				}
				
				
				
			</script>
			<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>-->
			<script type="text/javascript">
$(function(){
$(".search").keyup(function() 
{ 
var User_id= $("#User_id").val();
var Language=$("#Language").val();
var searchid = $(this).val();
//var dataString = 'search='+ searchid;
var dataString = 'search='+ searchid+'&User_id='+User_id+'&Language='+Language;
if(searchid!='')
{
	$.ajax({
	type: "POST",
	url: "search.php",
	data: dataString,
	cache: false,
	success: function(html)
	{
	$("#result").html(html).show();
	}
	});
}return false;    
});

jQuery("#result").live("click",function(e){ 
	var $clicked = $(e.target);
	var $name = $clicked.find('.name').html();
	var decoded = $("<div/>").html($name).text();
	$('#searchid').val(decoded);
});
jQuery(document).live("click", function(e) { 
	var $clicked = $(e.target);
	if (! $clicked.hasClass("search")){
	jQuery("#result").fadeOut(); 
	}
});
$('#searchid').click(function(){
	jQuery("#result").fadeIn();
});
});
</script>
<style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 3%; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
     overflow-y: scroll;
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	    
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 94%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
#myBtn{
	    margin-top: -34px;
    background: none;
    border-radius: 100%;
    /* padding: 1px 12px; */
    border: 0px;
    float: right;
}
</style>
        </head>
        <body>
			<div class="Dboot-preloader text-center">
    <img src="<? echo SITE_URL;?>/chat2/templates/img/loader.gif" width="400"/>
</div>


<div class="wrapper">
    <div class="container" style="margin:0 auto !important;">
		<div class="row">
			<div class="col-md-4  col-sm-4 parentsolo_plr_0">
        <div class="left"><div id="aide" class="helpLink" onclick="affichAide();">
				<span><i class="fa fa-comments"></i> <? echo $langChat["title_chat"];?> </span>
				<a href="chat.php?lang=<? echo $_GET["lang"];?>"><span class="Search_box" style=""  ><i class="fa fa-search"></i></span></a></div>            
            <ul class="live-search-list people" style="overflow-y:scroll; height:582px;overflow-x:hidden">                
							<div id="openConv">
							</div>
                   
                
                
            </ul><button id="myBtn" ><span class="Search_box" style="background:#b90003;"><i class="fa fa-info"></i></span></button>
        </div></div>
			<div class="col-md-8  col-sm-8 parentsolo_plr_0 resparentsolo_plr_0">
			<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p><? loadAide(); ?></p>
  </div>

</div>
        <div class="right" id="right">
         

            <div id="resultchat">
				<div id="chatHelp" style="padding-left: 10px;" <? if (isset($_GET["id"])&& $_GET["id"]>0){echo 'style="display:none;"';}?>>
				 <div class="search_div"><input type="text" class="search" id="searchid" placeholder="<?php echo $langChat["search_people"];?>" /></div>
				  <input type="hidden" class="User_id" id="User_id" name="User_id" value="<?php echo $user->id;?>" />
				  <input type="hidden" class="Language" id="Language" name="Language" value="<?php echo $_GET["lang"];?>" />
<div id="result">
</div>
<div class=""><div style="width:100%;margin: 30% auto;">
		<img src="<?php echo SITE_URL;?>/parentsolo/images/logo_<? echo $_GET['lang']; ?>.png" alt="ParentSolo.ch" class="image_logo_login" style="width:100%"></div>
					</div></div>
					<div id="chatConversation" <? if (!isset($_GET["id"])||$_GET["id"]<=0){echo 'style="display:none;"';} ?>>
					
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
<!--<div id="tabs-container">
    <ul class="tabs-menu">
        <li class="current"><a href="#tab-1">Tab 1</a></li>
        <li><a href="#tab-2">Tab 2</a></li>
        <li><a href="#tab-3">Tab 3</a></li>
        <li><a href="#tab-4">Tab 4</a></li>
    </ul>
    <div class="tab">
        <div id="tab-1" class="tab-content">
            <p>
			
			
			</p>
        </div>
        <div id="tab-2" class="tab-content">
            <p>Donec semper dictum sem</p>
        
        </div>
        <div id="tab-3" class="tab-content">
            <p>Duis egestas fermentum</p>
        </div>
        <div id="tab-4" class="tab-content">
            <p>Proin sollicitudin tincidunt </p>
        </div>
    </div>
</div>-->
								<!--<div class="closeMenu" onclick="closeMenuSmileys();"></div>-->
								<img onclick="chatSmiley('(~ES_01)');" alt="(~ES_01)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-01.png" />
			<img onclick="chatSmiley('(~ES_02)');" alt="(~ES_02)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-02.png" />
			<img onclick="chatSmiley('(~ES_03)');" alt="(~ES_03)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-03.png" />
			<img onclick="chatSmiley('(~ES_04)');" alt="(~ES_04)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-04.png" />
			<img onclick="chatSmiley('(~ES_05)');" alt="(~ES_05)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-05.png" />
			<img onclick="chatSmiley('(~ES_06)');" alt="(~ES_06)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-06.png" />
			<img onclick="chatSmiley('(~ES_07)');" alt="(~ES_07)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-07.png" />
			<img onclick="chatSmiley('(~ES_08)');" alt="(~ES_08)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-08.png" />
			<img onclick="chatSmiley('(~ES_09)');" alt="(~ES_09)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-09.png" />
			<img onclick="chatSmiley('(~ES_10)');" alt="(~ES_10)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-10.png" />
			
			<img onclick="chatSmiley('(~ES_11)');" alt="(~ES_11)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-11.png" />
			<img onclick="chatSmiley('(~ES_12)');" alt="(~ES_12)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-12.png" />
			<img onclick="chatSmiley('(~ES_13)');" alt="(~ES_13)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-13.png" />
			<img onclick="chatSmiley('(~ES_14)');" alt="(~ES_14)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-14.png" />
			<img onclick="chatSmiley('(~ES_15)');" alt="(~ES_15)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-15.png" />
			<img onclick="chatSmiley('(~ES_16)');" alt="(~ES_16)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-16.png" />
			<img onclick="chatSmiley('(~ES_17)');" alt="(~ES_17)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-17.png" />
			<img onclick="chatSmiley('(~ES_18)');" alt="(~ES_18)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-18.png" />
			<img onclick="chatSmiley('(~ES_19)');" alt="(~ES_19)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-19.png" />
			<img onclick="chatSmiley('(~ES_20)');" alt="(~ES_20)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-20.png" />
			
			<img onclick="chatSmiley('(~ES_21)');" alt="(~ES_21)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-21.png" />
			<img onclick="chatSmiley('(~ES_22)');" alt="(~ES_22)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-22.png" />
			<img onclick="chatSmiley('(~ES_23)');" alt="(~ES_23)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-23.png" />
			<img onclick="chatSmiley('(~ES_24)');" alt="(~ES_24)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-24.png" />
			<img onclick="chatSmiley('(~ES_25)');" alt="(~ES_25)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-25.png" />
			<img onclick="chatSmiley('(~ES_26)');" alt="(~ES_26)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-26.png" />
			<img onclick="chatSmiley('(~ES_27)');" alt="(~ES_27)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-27.png" />
			<img onclick="chatSmiley('(~ES_28)');" alt="(~ES_28)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-28.png" />
			<img onclick="chatSmiley('(~ES_29)');" alt="(~ES_29)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-29.png" />
			<img onclick="chatSmiley('(~ES_30)');" alt="(~ES_30)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-30.png" />
			
			<img onclick="chatSmiley('(~ES_31)');" alt="(~ES_31)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-31.png" />
			<img onclick="chatSmiley('(~ES_32)');" alt="(~ES_32)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-32.png" />
			<img onclick="chatSmiley('(~ES_33)');" alt="(~ES_33)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-33.png" />
			<img onclick="chatSmiley('(~ES_34)');" alt="(~ES_34)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-34.png" />
			<img onclick="chatSmiley('(~ES_35)');" alt="(~ES_35)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-35.png" />
			<img onclick="chatSmiley('(~ES_36)');" alt="(~ES_36)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-36.png" />
			<img onclick="chatSmiley('(~ES_37)');" alt="(~ES_37)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-37.png" />
			<img onclick="chatSmiley('(~ES_38)');" alt="(~ES_38)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-38.png" />
			<img onclick="chatSmiley('(~ES_39)');" alt="(~ES_39)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-39.png" />
			<img onclick="chatSmiley('(~ES_40)');" alt="(~ES_40)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-40.png" />
			
			<img onclick="chatSmiley('(~ES_51)');" alt="(~ES_51)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-51.png" />
			<img onclick="chatSmiley('(~ES_52)');" alt="(~ES_52)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-52.png" />
			<img onclick="chatSmiley('(~ES_53)');" alt="(~ES_53)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-53.png" />
			<img onclick="chatSmiley('(~ES_54)');" alt="(~ES_54)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-54.png" />
			<img onclick="chatSmiley('(~ES_55)');" alt="(~ES_55)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-55.png" />
			<img onclick="chatSmiley('(~ES_56)');" alt="(~ES_56)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-56.png" />
			<img onclick="chatSmiley('(~ES_57)');" alt="(~ES_57)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-57.png" />
			<img onclick="chatSmiley('(~ES_58)');" alt="(~ES_58)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-58.png" />
			<img onclick="chatSmiley('(~ES_59)');" alt="(~ES_59)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-59.png" />
			<img onclick="chatSmiley('(~ES_60)');" alt="(~ES_60)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji_Smiley-60.png" />
		
			<img onclick="chatSmiley('(~ES_61)');" alt="(~ES_61)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-61.png" />
			<img onclick="chatSmiley('(~ES_62)');" alt="(~ES_62)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-62.png" />
			<img onclick="chatSmiley('(~ES_63)');" alt="(~ES_63)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-63.png" />
			<img onclick="chatSmiley('(~ES_64)');" alt="(~ES_64)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-64.png" />
			<img onclick="chatSmiley('(~ES_65)');" alt="(~ES_65)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-65.png" />
			<img onclick="chatSmiley('(~ES_66)');" alt="(~ES_66)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-66.png" />
			<img onclick="chatSmiley('(~ES_67)');" alt="(~ES_67)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-67.png" />
			<img onclick="chatSmiley('(~ES_68)');" alt="(~ES_68)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-68.png" />
			<img onclick="chatSmiley('(~ES_69)');" alt="(~ES_69)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-69.png" />
			<img onclick="chatSmiley('(~ES_70)');" alt="(~ES_70)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-70.png" />
			
			<img onclick="chatSmiley('(~ES_71)');" alt="(~ES_71)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-71.png" />
			<img onclick="chatSmiley('(~ES_72)');" alt="(~ES_72)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-72.png" />
			<img onclick="chatSmiley('(~ES_73)');" alt="(~ES_73)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-73.png" />
			<img onclick="chatSmiley('(~ES_74)');" alt="(~ES_74)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-74.png" />
			<img onclick="chatSmiley('(~ES_75)');" alt="(~ES_75)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-75.png" />
			<img onclick="chatSmiley('(~ES_76)');" alt="(~ES_76)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-76.png" />
			<img onclick="chatSmiley('(~ES_77)');" alt="(~ES_77)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-77.png" />
			<img onclick="chatSmiley('(~ES_78)');" alt="(~ES_78)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-78.png" />
			<img onclick="chatSmiley('(~ES_79)');" alt="(~ES_69)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-79.png" />
			<img onclick="chatSmiley('(~ES_80)');" alt="(~ES_80)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-80.png" />
			
			<img onclick="chatSmiley('(~ES_81)');" alt="(~ES_81)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-81.png" />
			<img onclick="chatSmiley('(~ES_82)');" alt="(~ES_82)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-82.png" />
			<img onclick="chatSmiley('(~ES_83)');" alt="(~ES_83)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-83.png" />
			<img onclick="chatSmiley('(~ES_84)');" alt="(~ES_84)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-84.png" />
			<img onclick="chatSmiley('(~ES_85)');" alt="(~ES_85)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-85.png" />
			<img onclick="chatSmiley('(~ES_86)');" alt="(~ES_86)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-86.png" />
			<img onclick="chatSmiley('(~ES_87)');" alt="(~ES_87)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-87.png" />
			<img onclick="chatSmiley('(~ES_88)');" alt="(~ES_88)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-88.png" />
			<img onclick="chatSmiley('(~ES_89)');" alt="(~ES_89)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-89.png" />
			<img onclick="chatSmiley('(~ES_90)');" alt="(~ES_90)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-90.png" />
			
			<img onclick="chatSmiley('(~ES_91)');" alt="(~ES_91)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-91.png" />
			<img onclick="chatSmiley('(~ES_92)');" alt="(~ES_92)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-92.png" />
			<img onclick="chatSmiley('(~ES_93)');" alt="(~ES_93)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-93.png" />
			<img onclick="chatSmiley('(~ES_94)');" alt="(~ES_94)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-94.png" />
			<img onclick="chatSmiley('(~ES_95)');" alt="(~ES_95)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-95.png" />
			<img onclick="chatSmiley('(~ES_96)');" alt="(~ES_96)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-96.png" />
			<img onclick="chatSmiley('(~ES_97)');" alt="(~ES_97)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-97.png" />
			<img onclick="chatSmiley('(~ES_98)');" alt="(~ES_98)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-98.png" />
			<img onclick="chatSmiley('(~ES_99)');" alt="(~ES_99)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-99.png" />
			<img onclick="chatSmiley('(~ES_100)');" alt="(~ES_100)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-100.png" />
			
			<img onclick="chatSmiley('(~ES_101)');" alt="(~ES_101)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-101.png" />
			<img onclick="chatSmiley('(~ES_102)');" alt="(~ES_102)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-102.png" />
			<img onclick="chatSmiley('(~ES_103)');" alt="(~ES_103)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-103.png" />
			<img onclick="chatSmiley('(~ES_104)');" alt="(~ES_104)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-104.png" />
			<img onclick="chatSmiley('(~ES_105)');" alt="(~ES_105)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-105.png" />
			<img onclick="chatSmiley('(~ES_106)');" alt="(~ES_106)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-106.png" />
			<img onclick="chatSmiley('(~ES_107)');" alt="(~ES_107)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-107.png" />
			<img onclick="chatSmiley('(~ES_108)');" alt="(~ES_108)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-108.png" />
			<img onclick="chatSmiley('(~ES_109)');" alt="(~ES_109)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-109.png" />
			<img onclick="chatSmiley('(~ES_110)');" alt="(~ES_110)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-110.png" />
			
			<img onclick="chatSmiley('(~ES_111)');" alt="(~ES_111)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-111.png" />
			<img onclick="chatSmiley('(~ES_112)');" alt="(~ES_112)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-112.png" />
			<img onclick="chatSmiley('(~ES_113)');" alt="(~ES_113)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-113.png" />
			<img onclick="chatSmiley('(~ES_114)');" alt="(~ES_114)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-114.png" />
			<img onclick="chatSmiley('(~ES_115)');" alt="(~ES_115)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-115.png" />
			<img onclick="chatSmiley('(~ES_116)');" alt="(~ES_116)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-116.png" />
			<img onclick="chatSmiley('(~ES_117)');" alt="(~ES_117)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-117.png" />
			<img onclick="chatSmiley('(~ES_118)');" alt="(~ES_118)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-118.png" />
			<img onclick="chatSmiley('(~ES_119)');" alt="(~ES_119)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-119.png" />
			<img onclick="chatSmiley('(~ES_120)');" alt="(~ES_120)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-120.png" />
			
			<img onclick="chatSmiley('(~ES_121)');" alt="(~ES_121)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-121.png" />
			<img onclick="chatSmiley('(~ES_122)');" alt="(~ES_122)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-122.png" />
			<img onclick="chatSmiley('(~ES_123)');" alt="(~ES_123)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-123.png" />
			<img onclick="chatSmiley('(~ES_124)');" alt="(~ES_124)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-124.png" />
			<img onclick="chatSmiley('(~ES_125)');" alt="(~ES_125)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-125.png" />
			<img onclick="chatSmiley('(~ES_126)');" alt="(~ES_126)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-126.png" />
			<img onclick="chatSmiley('(~ES_127)');" alt="(~ES_127)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-127.png" />
			<img onclick="chatSmiley('(~ES_128)');" alt="(~ES_128)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-128.png" />
			<img onclick="chatSmiley('(~ES_129)');" alt="(~ES_129)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-129.png" />
			<img onclick="chatSmiley('(~ES_130)');" alt="(~ES_130)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-130.png" />
			
			<img onclick="chatSmiley('(~ES_131)');" alt="(~ES_131)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-131.png" />
			<img onclick="chatSmiley('(~ES_132)');" alt="(~ES_132)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-132.png" />
			<img onclick="chatSmiley('(~ES_133)');" alt="(~ES_133)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-133.png" />
			<img onclick="chatSmiley('(~ES_134)');" alt="(~ES_134)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-134.png" />
			<img onclick="chatSmiley('(~ES_135)');" alt="(~ES_135)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-135.png" />
			<img onclick="chatSmiley('(~ES_136)');" alt="(~ES_136)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-136.png" />
			<img onclick="chatSmiley('(~ES_137)');" alt="(~ES_137)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-137.png" />
			<img onclick="chatSmiley('(~ES_138)');" alt="(~ES_138)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-138.png" />
			<img onclick="chatSmiley('(~ES_139)');" alt="(~ES_139)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-139.png" />
			<img onclick="chatSmiley('(~ES_140)');" alt="(~ES_140)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-140.png" />
			
			<img onclick="chatSmiley('(~ES_141)');" alt="(~ES_141)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-141.png" />
			<img onclick="chatSmiley('(~ES_142)');" alt="(~ES_142)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-142.png" />
			<img onclick="chatSmiley('(~ES_143)');" alt="(~ES_143)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-143.png" />
			<img onclick="chatSmiley('(~ES_144)');" alt="(~ES_144)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-144.png" />
			<img onclick="chatSmiley('(~ES_145)');" alt="(~ES_145)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-145.png" />
			<img onclick="chatSmiley('(~ES_146)');" alt="(~ES_146)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-146.png" />
			<img onclick="chatSmiley('(~ES_147)');" alt="(~ES_147)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-147.png" />
			<img onclick="chatSmiley('(~ES_148)');" alt="(~ES_148)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-148.png" />
			<img onclick="chatSmiley('(~ES_149)');" alt="(~ES_149)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-149.png" />
			<img onclick="chatSmiley('(~ES_150)');" alt="(~ES_150)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-150.png" />
			
			<img onclick="chatSmiley('(~ES_151)');" alt="(~ES_151)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-151.png" />
			<img onclick="chatSmiley('(~ES_152)');" alt="(~ES_152)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-152.png" />
			<img onclick="chatSmiley('(~ES_153)');" alt="(~ES_153)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-153.png" />
			<img onclick="chatSmiley('(~ES_154)');" alt="(~ES_154)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-154.png" />
			<img onclick="chatSmiley('(~ES_155)');" alt="(~ES_155)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-155.png" />
			<img onclick="chatSmiley('(~ES_156)');" alt="(~ES_156)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-156.png" />
			<img onclick="chatSmiley('(~ES_157)');" alt="(~ES_157)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-157.png" />
			<img onclick="chatSmiley('(~ES_158)');" alt="(~ES_158)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-158.png" />
			<img onclick="chatSmiley('(~ES_159)');" alt="(~ES_159)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-159.png" />
			<img onclick="chatSmiley('(~ES_160)');" alt="(~ES_160)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-160.png" />
			
			<img onclick="chatSmiley('(~ES_161)');" alt="(~ES_161)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-161.png" />
			<img onclick="chatSmiley('(~ES_162)');" alt="(~ES_162)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-162.png" />
			<img onclick="chatSmiley('(~ES_163)');" alt="(~ES_163)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-163.png" />
			<img onclick="chatSmiley('(~ES_164)');" alt="(~ES_164)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-164.png" />
			<img onclick="chatSmiley('(~ES_165)');" alt="(~ES_165)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-165.png" />
			<img onclick="chatSmiley('(~ES_166)');" alt="(~ES_166)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-166.png" />
			<img onclick="chatSmiley('(~ES_167)');" alt="(~ES_167)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-167.png" />
			<img onclick="chatSmiley('(~ES_168)');" alt="(~ES_168)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-168.png" />
			<img onclick="chatSmiley('(~ES_169)');" alt="(~ES_169)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-169.png" />
			<img onclick="chatSmiley('(~ES_170)');" alt="(~ES_170)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-170.png" />
			
			<img onclick="chatSmiley('(~ES_171)');" alt="(~ES_171)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-171.png" />
			<img onclick="chatSmiley('(~ES_172)');" alt="(~ES_172)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-172.png" />
			<img onclick="chatSmiley('(~ES_173)');" alt="(~ES_173)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-173.png" />
			<img onclick="chatSmiley('(~ES_174)');" alt="(~ES_174)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-174.png" />
			<img onclick="chatSmiley('(~ES_175)');" alt="(~ES_175)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-175.png" />
			<img onclick="chatSmiley('(~ES_176)');" alt="(~ES_176)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-176.png" />
			<img onclick="chatSmiley('(~ES_177)');" alt="(~ES_177)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-177.png" />
			<img onclick="chatSmiley('(~ES_178)');" alt="(~ES_178)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-178.png" />
			<img onclick="chatSmiley('(~ES_179)');" alt="(~ES_179)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-179.png" />
			<img onclick="chatSmiley('(~ES_180)');" alt="(~ES_180)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-180.png" />
			
			<img onclick="chatSmiley('(~ES_181)');" alt="(~ES_181)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-181.png" />
			<img onclick="chatSmiley('(~ES_182)');" alt="(~ES_182)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-182.png" />
			<img onclick="chatSmiley('(~ES_183)');" alt="(~ES_183)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-183.png" />
			<img onclick="chatSmiley('(~ES_184)');" alt="(~ES_184)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-184.png" />
			<img onclick="chatSmiley('(~ES_185)');" alt="(~ES_185)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-185.png" />
			<img onclick="chatSmiley('(~ES_186)');" alt="(~ES_186)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-186.png" />
			<img onclick="chatSmiley('(~ES_187)');" alt="(~ES_187)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-187.png" />
			<img onclick="chatSmiley('(~ES_188)');" alt="(~ES_188)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-188.png" />
			<img onclick="chatSmiley('(~ES_189)');" alt="(~ES_189)" src="<?php echo SITE_URL;?>/chat2/images/Emoji_Smiley/Emoji-Smiley-189.png" />
			
			<!--
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
							-->
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
$(document).ready(function() {
    $(".tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
});
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
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</script>
	</body>
</html>

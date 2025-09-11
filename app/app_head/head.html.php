<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$option = $_REQUEST['option'] ?? null;
if ($option === 'common') {
	
require_once('../../config.php');
	// framework joomlike
require_once('../../framework/joomlike.class.php');
// framework base de donn&eacute;es
require_once('../../framework/mysql.class.php');
global $user,$db;
$db	= new DB();
$value=$_REQUEST['checkvalue'];
$user=$_REQUEST['userid'];
$query="UPDATE user set on_off_status='$value' where id='$user'";
$result1 = $db->getConnexion()->query($query);
 if($result1!=mysql_query){
}
else{
}
}
// MODEL
	defined('JL') or die('Error 401');	
	class head_HTML {
	// v&eacute;rifie si l'utilisateur veut se log ou est log, et renseigne la variable global $user
	public static function head(
		$userProfilMini = [],
    $userStats = [],
    $userpercentage = 0,
    $perannounce = '',
    $userStats2 = [],
    $useronstatus = '') {
			include("lang/app_head.".$_GET['lang'].".php");
			global $db, $template, $user, $langue, $auth, $action, $app;
			$navArr=array();
			$navString="";
			if(count($_GET)>1){
				foreach($_GET as $key => $value){
					if($key!='lang'){
						$navArr[]="$key=$value";
					}
				}
				$navString= "&".implode("&",$navArr);
			}            
			if($_GET['lang']=='fr'){
                //Fran&ccedil;ais <img style='width: 16px; border: inherit; vertical-align: bottom; margin: inherit;' src='".SITE_URL."/images/icons/fr.png'>- 
			    $nav_active_string= "Fran&ccedil;ais <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/fr.png'>";
				$navString = "  
                <li><a href='index.php?lang=de".$navString."'>Deutsch <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/de.png'> </a></li>
                <li><a href='index.php?lang=en".$navString."'>English <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/en.png'></a></li> ";
			}
            elseif($_GET['lang']=='en'){
				$nav_active_string= "English <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/en.png'>";
			    $navString = "<li><a href='index.php?lang=fr".$navString."'>Fran&ccedil;ais <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/fr.png'> </a></li>
                <li><a href='index.php?lang=de".$navString."'>Deutsch <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/de.png'></a> </li>
                ";  //- English <img style='width: 16px; border: inherit; vertical-align: bottom; margin: inherit;' src='".SITE_URL."/images/icons/en.png'>
			}
            elseif($_GET['lang']=='de'){
                $nav_active_string= "Deutsch <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/de.png'>";
			    //- Deutsch <img style='width: 16px; border: inherit; vertical-align: bottom; margin: inherit;' src='".SITE_URL."/images/icons/de.png'>   
			    $navString = "<li><a href='index.php?lang=fr".$navString."'>Fran&ccedil;ais  <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/fr.png'> </a></li>
                <li><a href='index.php?lang=en".$navString."'>English <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/en.png'></a></li>";
			}
            else{
			$nav_active_string= "Fran&ccedil;ais</a> <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/fr.png'>";
			    $navString = "<li><a href='index.php?lang=fr".$navString."'>Fran&ccedil;ais  <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/fr.png'></a></li> 
                <li><a href='index.php?lang=de".$navString."'>Deutsch <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/de.png'></a></li> 
                <li><a href='index.php?lang=en".$navString."'>English <img style='width: 16px; border: inherit; ' src='".SITE_URL."/images/icons/en.png'></a></li>";
			}
		?>
		<div id="banner_leader_board" style="display:none;">
				
				<div class="small"><?php echo $lang_apphead["Publicite"];?></div>
				<div id='leaderboard'>
					<!--<a href="http://www.swiss.com" target="_blank"><img src="http://www.parentsolo.ch/images/swiss.gif"></a> -->
                    
                     <?php if($app != 'home') {
                     if($_GET['lang']=="fr"){
                     ?>    
                     <!-- config scripts -->
                   <script type="text/javascript">
                    var setgbpartnertag464 = false; if(typeof(setgbtargetingobj) == 'undefined') {var setgbtargetingobj = {};} 
                    var gbuseSSL = 'https:' == document.location.protocol;
                    var gbconfigdomain = (gbuseSSL ? 'https:' + "//secure.gbucket.ch/" : 'http:' + "//gbucket.ch/");
                    var gbadtagdomain = (gbuseSSL ? 'https:' + "//secure.gbucket.ch/" : 'http:' + "//gbucket.ch/"); 
                    document.write('<scr'+'ipt type="text/javascript" id="gbconfigscript" src="' + gbconfigdomain + 'CH/ch_config_desktop.js"></scr'+'ipt>');
                    document.write('<scr'+'ipt type="text/javascript" id="gbadtag" src="' + gbadtagdomain + 'CH/BlatMedias/Online/FR_Parentsolo_RoS_incl_Home_allAdFormats.js"></scr'+'ipt>');
                    </script>
                    
                    <!-- 728x90, 994x250 -->
                   <div id="div-ad-gds-464-1">
                    <script type="text/javascript">
                    gbcallslot464("div-ad-gds-464-1", "");
                    </script>
                    </div>
                    <?
                   }
                     
                     if($_GET['lang']=="de"){
                    ?>
                       <!-- config scripts -->
                        <script type="text/javascript">
                        var setgbpartnertag522 = false; if(typeof(setgbtargetingobj) == 'undefined') {var setgbtargetingobj = {};} 
                        var gbuseSSL = 'https:' == document.location.protocol;
                        var gbconfigdomain = (gbuseSSL ? 'https:' + "//secure.gbucket.ch/" : 'http:' + "//gbucket.ch/");
                        var gbadtagdomain = (gbuseSSL ? 'https:' + "//secure.gbucket.ch/" : 'http:' + "//gbucket.ch/"); 
                        document.write('<scr'+'ipt type="text/javascript" id="gbconfigscript" src="' + gbconfigdomain + 'CH/ch_config_desktop.js"></scr'+'ipt>');
                        document.write('<scr'+'ipt type="text/javascript" id="gbadtag" src="' + gbadtagdomain + 'CH/BlatMedias/Online/DE_Parentsolo_RoS_incl_Home_allAdFormats.js"></scr'+'ipt>');
                        </script>

                        <!-- 728x90, 940x250 -->
                        <div id="div-ad-gds-522-1">
                        <script type="text/javascript">
                        gbcallslot522("div-ad-gds-522-1", "");
                        </script>
                        </div>
                    <?
                    }
                     
                     if($_GET['lang']=="en") {
                    ?>
                        <!-- config scripts -->
                       <script type="text/javascript">
                        var setgbpartnertag526 = false; if(typeof(setgbtargetingobj) == 'undefined') {var setgbtargetingobj = {};} 
                        var gbuseSSL = 'https:' == document.location.protocol;
                        var gbconfigdomain = (gbuseSSL ? 'https:' + "//secure.gbucket.ch/" : 'http:' + "//gbucket.ch/");
                        var gbadtagdomain = (gbuseSSL ? 'https:' + "//secure.gbucket.ch/" : 'http:' + "//gbucket.ch/"); 
                        document.write('<scr'+'ipt type="text/javascript" id="gbconfigscript" src="' + gbconfigdomain + 'CH/ch_config_desktop.js"></scr'+'ipt>');
                        document.write('<scr'+'ipt type="text/javascript" id="gbadtag" src="' + gbadtagdomain + 'CH/BlatMedias/Online/EN_Parentsolo_RoS_incl_Home_allAdFormats.js"></scr'+'ipt>');
                        </script>
                    
                    
                       <!-- 728x90, 994x250 -->
                       <div id="div-ad-gds-526-1">
                        <script type="text/javascript">
                        gbcallslot526("div-ad-gds-526-1", "");
                        </script>
                        </div>
                     <?
                     }
					 }
                     ?>
				</div>
				
			</div>
			
			<!--<div id="banner_top">
				<img src="<?php  echo $template;?>/images/pastille_pourcentage_<?php  echo $_GET['lang']; ?>.png" alt="ParentSolo.ch"  />
				<?php echo $lang_apphead["Papas"];?>: <span class="homme">43%</span><br />
				<?php echo $lang_apphead["Mamans"];?>: <span class="femme">57%</span>
			</div>
			</div>-->
			
			<?
			
					if(!$user->id){
						?>
						
				
			<header class="page-head" style="margin-top:50px;">
			
			<nav class="navbar navbar-default navbar-fixed-top menubar_fixed" style="    /* margin-top: 188px; */">
      <div class="container-fluid">
	  <div class="col-md-4  col-sm-3 col-xs-9 menu_right_side float_right"> 
		<ul class="nav navbar-nav navbar-right"> 
		  <li  class="border_rght col_sm_remove_li"><a href="<?php echo JL::url('index.php?app=profil&action=inscription').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_apphead["join_link"];?>"><?php echo $lang_apphead["join_link"];?></a></li>
            <li  class="border_rght"><a href="#"  data-toggle="modal" data-target="#myModal"><?php echo $lang_apphead["Connexion"];?></a></li>
           
			 <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $nav_active_string;?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                 <?php echo $navString;?>
              </ul>
            </li>
          </ul>
		  </div><div class="col-md-2  col-sm-2 col-xs-2 hidden-xs menu_right_side float_right"> 
		<img src="parentsolo/images/mini-logo.gif"/>
		  </div>
		  
       <div class="col-md-6 col-sm-7 col-xs-12 float_Left"> <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
		  <li class="border_rght"><a href="<?php echo JL::url('index.php').'?lang='.$_GET['lang']; ?>" title="<?php echo $lang_apphead["home_menu"];?>"><?php echo $lang_apphead["home_menu"];?></a></li>
			<li class="border_rght"><a href="<?php echo JL::url('index.php?app=event').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_apphead["event_menu"];?>"><?php echo $lang_apphead["event_menu"];?></a></li>
			<li class="border_rght"><a href="<?php echo JL::url('index.php?app=contenu&id=2').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_apphead["uce_menu"]; ?>"><?php echo $lang_apphead["uce_menu"]; ?></a></li>
			<li><a href="<?php echo JL::url('index.php?app=contact').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_apphead["contact_menu"];?>"><?php echo $lang_apphead["contact_menu"];?></a></li>		
		</ul>
          
        </div><!--/.nav-collapse --></div>
		
      </div>
    </nav>
         </header>
			<?php
		}
		else{
			?>
			<style>
		@media (max-width: 767px){
.mobile_res_logo img {
    width: 70% !important;
}
}
		</style>
			<?php
		}
			?>
			<div class="header">
				<div class="col-lg-4 connexion">
					<!--<div class="langues"><?php echo $navString;?></div>-->
			<?php
				if(!$user->id){//$style = $auth == 'login' ? 'style=" border:1px solid ;"' : 'style="border: border:1px solid ;"';
/* $style = $auth == 'login' ? 'style="border: 1px solid "' : 'style="border: 1px solid"';
				$Error_message = $auth == 'login' ? 'style="display: block ! important; font-size: 13px; color: red; padding-bottom: 10px; 

text-align: center;"' : 'style="display:none !important;border:1px solid;"';
$error_style = $auth == 'login' ? 'style="display: block ! important;"' : 'style="display:none !important;"';
				//$error_class1 = $auth == 'login' ? 'in display' : '';
$error_ses = $auth == 'login' ? '1' : ''; */
if (isset($user) && isset($user->login) && $user->login === 'login') {
$style='style="border: 1px solid';
$Error_message = 'style="display: block ! important; font-size: 13px; color: red; padding-bottom: 10px; text-align: center;"';
$error_style ='style="display: block ! important;"';
$error_ses = '1';
}
else{
$Error_message = 'style="display:none !important;border:1px solid;"';
$error_style ='style="display:none !important;"';
$error_ses ='';
}

/* 

$style = $user->login == 'login' ? 'style="border: 1px solid "' : 'style="border: 1px solid"';
				$Error_message = $user->login == 'login' ? 'style="display: block ! important; font-size: 13px; color: red; padding-bottom: 10px; text-align: center;"' : 'style="display:none !important;border:1px solid;"';
$error_style = $user->login == 'login' ? 'style="display: block ! important;"' : 'style="display:none !important;"';
				//$error_class1 = $auth == 'login' ? 'in display' : '';
$error_ses = $user->login == 'login' ? '1' : ''; */

			?>
<script>
    
window.onload = function(){
 document.getElementById("close_div").onclick=function(){
	    $("myModal").removeClass("in display");
		  
    }
}
			</script>
			<style>
			.display{
			display:block !important;
background: rgba(47, 47, 47, 0.72);
			}
			</style>

		<div <?php echo $error_style; ?> class="modal fade  <?php if($error_ses=='1'){
		echo "in display";
		}
		else{
		echo "in display";
		}
		  ?>" id="myModal"  role="dialog" >
		<div class="popstl">
	    <div class="modal-dialog modal-lg popup_stl" >
        <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="close_div" data-dismiss="modal">&times;</button>
          <h5 class="modal-title"><?php echo $lang_apphead["DejaMembre"];?></h5>
        </div>
        <div class="modal-body">
          <form action="index.php?lang=<?php echo $_GET['lang'];?>" method="post">
		   <div class="row"><div class="col-md-12">
										<span <?php echo $Error_message; ?> style="display:none;"  ><?php echo $lang_apphead["error_msg"];?></span></div></div>
		  <div class="row"><div class="col-md-12">
										<input type="text" name="username" id="username" <?php echo $style??''; ?> class="connexion" value="" placeholder="<?php echo $lang_apphead["Pseudo"];?>"></div></div>
		  <div class="row"><div class="col-md-12">
										<input type="password" name="pass" id="pass" <?php echo $style??''; ?> class="connexion" value="" placeholder="<?php echo $lang_apphead["MotDePasse"];?>"><br />
		  <a href="<?php echo JL::url('index.php?app=mdp').'&lang='.$_GET['lang'];?>"><?php echo $lang_apphead["MotDePasseOublie"];?></a>
		  </div></div>
		  <div class="row"><div class="col-md-12 text_left">
		  <input type="submit" class="envoyer btn_stl" value="<?php echo $lang_apphead["Connexion"];?>" />
		  </div></div>
							<!--<table cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td valign="top">
										<label for="username"><?php echo $lang_apphead["Pseudo"];?> </label><br />
										<input type="text" name="username" id="username" <?php echo $style; ?> class="connexion" value="">
									</td>
									<td valign="top">
										<label for="mdp"><?php echo $lang_apphead["MotDePasse"];?> </label><br />
										<input type="password" name="pass" id="pass" <?php echo $style; ?> class="connexion" value=""><br />
										<a href="<?php echo JL::url('index.php?app=mdp').'&lang='.$_GET['lang'];?>"><?php echo $lang_apphead["MotDePasseOublie"];?></a>
									</td>
									<td valign="middle">
										
									</td>
								</tr>
							</table>-->
							
							<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
							<input type="hidden" name="lang" id="lang" value="<?php echo $_GET["lang"];?>" />
							<input type="hidden" name="auth" value="<?php echo $user->id ? 'logout' : 'login'; ?>" />
							
						</form>
        </div>
      </div>
    </div>
	</div>
  </div>
</div>
					
				<?
					}else{
						
						$photo = JL::userGetPhoto($userProfilMini->id, '109', 'profil', $userProfilMini->photo_defaut);
						$photo1=1;
						// photo par d&eacute;faut
						if(!$photo) {
							$photo 			= SITE_URL.'/parentsolo/images/parent-solo-109-'.$userProfilMini->genre.'-'.$_GET['lang'].'.jpg';
							$noPhotoPopIn	= true;
							$photo1=0;
						}
						 //condition 1
						  if($photo1==0 && $perannounce->annonce=='' && $userpercentage->taille_id==0 && $userpercentage->poids_id==0 && $userpercentage->silhouette_id==0&& $userpercentage->style_coiffure_id== 0&& $userpercentage->cheveux_id==0&& $userpercentage->yeux_id== 0&& $userpercentage->origine_id== 0&& $userpercentage->nationalite_id== 0&& $userpercentage->religion_id==0&& $userpercentage->statut_marital_id== 0&& $userpercentage->me_marier_id== 0&& $userpercentage->cherche_relation_id== 0&&
			$userpercentage->niveau_etude_id==0&&
			$userpercentage->secteur_activite_id==0&&
			$userpercentage->fumer_id==0&&
			$userpercentage->temperament_id==0&&
			$userpercentage->langue1_id==0&& 
			$userpercentage->langue2_id==0&& 
			$userpercentage->langue3_id==0&& 
			$userpercentage->vouloir_enfants_id==0&&
			$userpercentage->garde_id==0&&
			$userpercentage->vie_id==0&&			// profil_vie
			$userpercentage->cuisine1_id==0&&		// profil_cuisine
			$userpercentage->cuisine2_id==0&&		// profil_cuisine
			$userpercentage->cuisine3_id==0&&		// profil_cuisine
			$userpercentage->sortie1_id==0&&		// profil_sortie
			$userpercentage->sortie2_id==0&&		// profil_sortie
			$userpercentage->sortie3_id==0&&		// profil_sortie
			$userpercentage->loisir1_id==0&&	// profil_loisir
			$userpercentage->loisir2_id==0&&	// profil_loisir
			$userpercentage->loisir3_id==0&&	// profil_loisir
			$userpercentage->sport1_id==0&&// profil_sport
			$userpercentage->sport2_id==0&&// profil_sport
			$userpercentage->sport3_id==0&&// profil_sport
			$userpercentage->musique1_id==0&&		// profil_musique
			$userpercentage->musique2_id==0&&		// profil_musique
			$userpercentage->musique3_id==0&&		// profil_musique
			$userpercentage->film1_id==0&&		// profil_film
			$userpercentage->film2_id==0&&		// profil_film
			$userpercentage->film3_id==0&&		// profil_film
			$userpercentage->lecture1_id==0&&		// profil_lecture
			$userpercentage->lecture2_id==0&&		// profil_lecture
			$userpercentage->lecture3_id==0&&		// profil_lecture
			$userpercentage->animaux1_id==0 &&
			$userpercentage->animaux2_id==0 &&
			$userpercentage->animaux3_id==0){
			//100-60=40
			$percentagevalue='40%';
			}
			
			//condition 2
			if($photo1==1 && $perannounce->annonce=='' && ($userpercentage->taille_id==0 && $userpercentage->poids_id==0 && $userpercentage->silhouette_id==0&& $userpercentage->style_coiffure_id== 0&& $userpercentage->cheveux_id==0&& $userpercentage->yeux_id== 0&& $userpercentage->origine_id== 0&& $userpercentage->nationalite_id== 0&& $userpercentage->religion_id==0&& $userpercentage->statut_marital_id== 0&& $userpercentage->me_marier_id== 0&& $userpercentage->cherche_relation_id== 0&&
			$userpercentage->niveau_etude_id== 0&&
			$userpercentage->secteur_activite_id==0&&
			$userpercentage->fumer_id==0&&
			$userpercentage->temperament_id== 0&&
			$userpercentage->langue1_id==0&& 
			$userpercentage->langue2_id==0&& 
			$userpercentage->langue3_id==0&& 
			$userpercentage->vouloir_enfants_id== 0&&
			$userpercentage->garde_id== 0&&
			$userpercentage->vie_id==0&&			// profil_vie
			$userpercentage->cuisine1_id== 0&&		// profil_cuisine
			$userpercentage->cuisine2_id== 0&&		// profil_cuisine
			$userpercentage->cuisine3_id== 0&&		// profil_cuisine
			$userpercentage->sortie1_id== 0&&		// profil_sortie
			$userpercentage->sortie2_id== 0&&		// profil_sortie
			$userpercentage->sortie3_id== 0&&		// profil_sortie
			$userpercentage->loisir1_id==0&&	// profil_loisir
			$userpercentage->loisir2_id==0&&	// profil_loisir
			$userpercentage->loisir3_id==0&&	// profil_loisir
			$userpercentage->sport1_id== 0&&// profil_sport
			$userpercentage->sport2_id== 0&&// profil_sport
			$userpercentage->sport3_id== 0&&// profil_sport
			$userpercentage->musique1_id==0&&		// profil_musique
			$userpercentage->musique2_id==0&&		// profil_musique
			$userpercentage->musique3_id==0&&		// profil_musique
			$userpercentage->film1_id== 0&&		// profil_film
			$userpercentage->film2_id== 0&&		// profil_film
			$userpercentage->film3_id== 0&&		// profil_film
			$userpercentage->lecture1_id== 0&&		// profil_lecture
			$userpercentage->lecture2_id== 0&&		// profil_lecture
			$userpercentage->lecture3_id== 0&&		// profil_lecture
			$userpercentage->animaux1_id== 0 &&
			$userpercentage->animaux2_id== 0 &&
			$userpercentage->animaux3_id== 0)){
			//100-40=60
			$percentagevalue='60%';
			}	
//condition 3
if($photo1==0 && $perannounce->annonce!='' && ($userpercentage->taille_id==0 && $userpercentage->poids_id==0 && $userpercentage->silhouette_id==0&& $userpercentage->style_coiffure_id== 0&& $userpercentage->cheveux_id==0&& $userpercentage->yeux_id== 0&& $userpercentage->origine_id== 0&& $userpercentage->nationalite_id== 0&& $userpercentage->religion_id==0&& $userpercentage->statut_marital_id== 0&& $userpercentage->me_marier_id== 0&& $userpercentage->cherche_relation_id== 0&&
			$userpercentage->niveau_etude_id== 0&&
			$userpercentage->secteur_activite_id==0&&
			$userpercentage->fumer_id==0&&
			$userpercentage->temperament_id== 0&&
			$userpercentage->langue1_id==0&& 
			$userpercentage->langue2_id==0&& 
			$userpercentage->langue3_id==0&& 
			$userpercentage->vouloir_enfants_id== 0&&
			$userpercentage->garde_id== 0&&
			$userpercentage->vie_id==0&&			// profil_vie
			$userpercentage->cuisine1_id== 0&&		// profil_cuisine
			$userpercentage->cuisine2_id== 0&&		// profil_cuisine
			$userpercentage->cuisine3_id== 0&&		// profil_cuisine
			$userpercentage->sortie1_id== 0&&		// profil_sortie
			$userpercentage->sortie2_id== 0&&		// profil_sortie
			$userpercentage->sortie3_id== 0&&		// profil_sortie
			$userpercentage->loisir1_id==0&&	// profil_loisir
			$userpercentage->loisir2_id==0&&	// profil_loisir
			$userpercentage->loisir3_id==0&&	// profil_loisir
			$userpercentage->sport1_id== 0&&// profil_sport
			$userpercentage->sport2_id== 0&&// profil_sport
			$userpercentage->sport3_id== 0&&// profil_sport
			$userpercentage->musique1_id==0&&		// profil_musique
			$userpercentage->musique2_id==0&&		// profil_musique
			$userpercentage->musique3_id==0&&		// profil_musique
			$userpercentage->film1_id== 0&&		// profil_film
			$userpercentage->film2_id== 0&&		// profil_film
			$userpercentage->film3_id== 0&&		// profil_film
			$userpercentage->lecture1_id== 0&&		// profil_lecture
			$userpercentage->lecture2_id== 0&&		// profil_lecture
			$userpercentage->lecture3_id== 0&&		// profil_lecture
			$userpercentage->animaux1_id== 0 &&
			$userpercentage->animaux2_id== 0 &&
			$userpercentage->animaux3_id== 0)){
			//100-40=60
			$percentagevalue='60%';
			}	
			//condition 4
				if($photo1==1 && $perannounce->annonce!='' && ($userpercentage->taille_id==0 && $userpercentage->poids_id==0 && $userpercentage->silhouette_id==0&& $userpercentage->style_coiffure_id== 0&& $userpercentage->cheveux_id==0&& $userpercentage->yeux_id== 0&& $userpercentage->origine_id== 0&& $userpercentage->nationalite_id== 0&& $userpercentage->religion_id==0&& $userpercentage->statut_marital_id== 0&& $userpercentage->me_marier_id== 0&& $userpercentage->cherche_relation_id== 0&&
			$userpercentage->niveau_etude_id== 0&&
			$userpercentage->secteur_activite_id==0&&
			$userpercentage->fumer_id==0&&
			$userpercentage->temperament_id== 0&&
			$userpercentage->langue1_id==0&& 
			$userpercentage->langue2_id==0&& 
			$userpercentage->langue3_id==0&& 
			$userpercentage->vouloir_enfants_id== 0&&
			$userpercentage->garde_id== 0&&
			$userpercentage->vie_id==0&&			// profil_vie
			$userpercentage->cuisine1_id== 0&&		// profil_cuisine
			$userpercentage->cuisine2_id== 0&&		// profil_cuisine
			$userpercentage->cuisine3_id== 0&&		// profil_cuisine
			$userpercentage->sortie1_id== 0&&		// profil_sortie
			$userpercentage->sortie2_id== 0&&		// profil_sortie
			$userpercentage->sortie3_id== 0&&		// profil_sortie
			$userpercentage->loisir1_id==0&&	// profil_loisir
			$userpercentage->loisir2_id==0&&	// profil_loisir
			$userpercentage->loisir3_id==0&&	// profil_loisir
			$userpercentage->sport1_id== 0&&// profil_sport
			$userpercentage->sport2_id== 0&&// profil_sport
			$userpercentage->sport3_id== 0&&// profil_sport
			$userpercentage->musique1_id==0&&		// profil_musique
			$userpercentage->musique2_id==0&&		// profil_musique
			$userpercentage->musique3_id==0&&		// profil_musique
			$userpercentage->film1_id== 0&&		// profil_film
			$userpercentage->film2_id== 0&&		// profil_film
			$userpercentage->film3_id== 0&&		// profil_film
			$userpercentage->lecture1_id== 0&&		// profil_lecture
			$userpercentage->lecture2_id== 0&&		// profil_lecture
			$userpercentage->lecture3_id== 0&&		// profil_lecture
			$userpercentage->animaux1_id== 0 &&
			$userpercentage->animaux2_id== 0 &&
			$userpercentage->animaux3_id== 0)){
			//100-20=80
			$percentagevalue='80%';
			}
//condition 5

if($photo1==0 && $perannounce->annonce=='' && ($userpercentage->taille_id!=0 || $userpercentage->poids_id!=0 || $userpercentage->silhouette_id!=0 || $userpercentage->style_coiffure_id!=0 || $userpercentage->cheveux_id!=0 || $userpercentage->yeux_id!=0 || $userpercentage->origine_id!=0 || $userpercentage->nationalite_id!=0 || $userpercentage->religion_id!=0 || $userpercentage->statut_marital_id!=0 || $userpercentage->me_marier_id!=0 || $userpercentage->cherche_relation_id!=0||
			$userpercentage->niveau_etude_id!=0 ||
			$userpercentage->secteur_activite_id!=0 ||
			$userpercentage->fumer_id!=0 ||
			$userpercentage->temperament_id!=0 ||
			$userpercentage->langue1_id!=0 || 
			$userpercentage->langue2_id!=0|| 
			$userpercentage->langue3_id!=0 || 
			$userpercentage->vouloir_enfants_id!=0 ||
			$userpercentage->garde_id!=0 ||
			$userpercentage->vie_id!=0||			// profil_vie
			$userpercentage->cuisine1_id!=0||	// profil_cuisine
			$userpercentage->cuisine2_id!=0||		// profil_cuisine
			$userpercentage->cuisine3_id!=0||	// profil_cuisine
			$userpercentage->sortie1_id!=0||		// profil_sortie
			$userpercentage->sortie2_id!=0||		// profil_sortie
			$userpercentage->sortie3_id!=0||		// profil_sortie
			$userpercentage->loisir1_id!=0 ||	// profil_loisir
			$userpercentage->loisir2_id!=0||	// profil_loisir
			$userpercentage->loisir3_id!=0||	// profil_loisir
			$userpercentage->sport1_id!=0||// profil_sport
			$userpercentage->sport2_id!=0||// profil_sport
			$userpercentage->sport3_id!=0||// profil_sport
			$userpercentage->musique1_id!=0||		// profil_musique
			$userpercentage->musique2_id!=0||		// profil_musique
			$userpercentage->musique3_id!=0||		// profil_musique
			$userpercentage->film1_id!=0||		// profil_film
			$userpercentage->film2_id!=0||		// profil_film
			$userpercentage->film3_id!=0||		// profil_film
			$userpercentage->lecture1_id!=0||		// profil_lecture
			$userpercentage->lecture2_id!=0||		// profil_lecture
			$userpercentage->lecture3_id!=0||	// profil_lecture
			$userpercentage->animaux1_id!=0||
			$userpercentage->animaux2_id!=0||
			$userpercentage->animaux3_id!=0)){
			//100-40=60
			$percentagevalue='60%';
			}
//condition 6
if($photo1==1 && $perannounce->annonce=='' && ($userpercentage->taille_id!=0 || $userpercentage->poids_id!=0 || $userpercentage->silhouette_id!=0 || $userpercentage->style_coiffure_id!=0 || $userpercentage->cheveux_id!=0 || $userpercentage->yeux_id!=0 || $userpercentage->origine_id!=0 || $userpercentage->nationalite_id!=0 || $userpercentage->religion_id!=0 || $userpercentage->statut_marital_id!=0 || $userpercentage->me_marier_id!=0 || $userpercentage->cherche_relation_id!=0||
			$userpercentage->niveau_etude_id!=0 ||
			$userpercentage->secteur_activite_id!=0 ||
			$userpercentage->fumer_id!=0 ||
			$userpercentage->temperament_id!=0 ||
			$userpercentage->langue1_id!=0 || 
			$userpercentage->langue2_id!=0|| 
			$userpercentage->langue3_id!=0 || 
			$userpercentage->vouloir_enfants_id!=0 ||
			$userpercentage->garde_id!=0 ||
			$userpercentage->vie_id!=0||			// profil_vie
			$userpercentage->cuisine1_id!=0||	// profil_cuisine
			$userpercentage->cuisine2_id!=0||		// profil_cuisine
			$userpercentage->cuisine3_id!=0||	// profil_cuisine
			$userpercentage->sortie1_id!=0||		// profil_sortie
			$userpercentage->sortie2_id!=0||		// profil_sortie
			$userpercentage->sortie3_id!=0||		// profil_sortie
			$userpercentage->loisir1_id!=0 ||	// profil_loisir
			$userpercentage->loisir2_id!=0||	// profil_loisir
			$userpercentage->loisir3_id!=0||	// profil_loisir
			$userpercentage->sport1_id!=0||// profil_sport
			$userpercentage->sport2_id!=0||// profil_sport
			$userpercentage->sport3_id!=0||// profil_sport
			$userpercentage->musique1_id!=0||		// profil_musique
			$userpercentage->musique2_id!=0||		// profil_musique
			$userpercentage->musique3_id!=0||		// profil_musique
			$userpercentage->film1_id!=0||		// profil_film
			$userpercentage->film2_id!=0||		// profil_film
			$userpercentage->film3_id!=0||		// profil_film
			$userpercentage->lecture1_id!=0||		// profil_lecture
			$userpercentage->lecture2_id!=0||		// profil_lecture
			$userpercentage->lecture3_id!=0||	// profil_lecture
			$userpercentage->animaux1_id!=0||
			$userpercentage->animaux2_id!=0||
			$userpercentage->animaux3_id!=0)){
			//100-20=80
			$percentagevalue='80%';
			}
//condition 7
if($photo1==0 && $perannounce->annonce!='' && ($userpercentage->taille_id!=0 || $userpercentage->poids_id!=0 || $userpercentage->silhouette_id!=0 || $userpercentage->style_coiffure_id!=0 || $userpercentage->cheveux_id!=0 || $userpercentage->yeux_id!=0 || $userpercentage->origine_id!=0 || $userpercentage->nationalite_id!=0 || $userpercentage->religion_id!=0 || $userpercentage->statut_marital_id!=0 || $userpercentage->me_marier_id!=0 || $userpercentage->cherche_relation_id!=0||
			$userpercentage->niveau_etude_id!=0 ||
			$userpercentage->secteur_activite_id!=0 ||
			$userpercentage->fumer_id!=0 ||
			$userpercentage->temperament_id!=0 ||
			$userpercentage->langue1_id!=0 || 
			$userpercentage->langue2_id!=0|| 
			$userpercentage->langue3_id!=0 || 
			$userpercentage->vouloir_enfants_id!=0 ||
			$userpercentage->garde_id!=0 ||
			$userpercentage->vie_id!=0||			
			$userpercentage->cuisine1_id!=0||	
			$userpercentage->cuisine2_id!=0||		// profil_cuisine
			$userpercentage->cuisine3_id!=0||	// profil_cuisine
			$userpercentage->sortie1_id!=0||		// profil_sortie
			$userpercentage->sortie2_id!=0||		// profil_sortie
			$userpercentage->sortie3_id!=0||		// profil_sortie
			$userpercentage->loisir1_id!=0 ||	// profil_loisir
			$userpercentage->loisir2_id!=0||	// profil_loisir
			$userpercentage->loisir3_id!=0||	// profil_loisir
			$userpercentage->sport1_id!=0||// profil_sport
			$userpercentage->sport2_id!=0||// profil_sport
			$userpercentage->sport3_id!=0||// profil_sport
			$userpercentage->musique1_id!=0||		// profil_musique
			$userpercentage->musique2_id!=0||		// profil_musique
			$userpercentage->musique3_id!=0||		// profil_musique
			$userpercentage->film1_id!=0||		// profil_film
			$userpercentage->film2_id!=0||		// profil_film
			$userpercentage->film3_id!=0||		// profil_film
			$userpercentage->lecture1_id!=0||		// profil_lecture
			$userpercentage->lecture2_id!=0||		// profil_lecture
			$userpercentage->lecture3_id!=0||	// profil_lecture
			$userpercentage->animaux1_id!=0||
			$userpercentage->animaux2_id!=0||
			$userpercentage->animaux3_id!=0)){
			//100-20=80
			$percentagevalue='80%';
			}
			if($photo1==1 && $perannounce->annonce!='' && $userpercentage->taille_id!=0 || $userpercentage->poids_id!=0 || $userpercentage->silhouette_id!=0 || $userpercentage->style_coiffure_id!=0 || $userpercentage->cheveux_id!=0 || $userpercentage->yeux_id!=0 || $userpercentage->origine_id!=0 || $userpercentage->nationalite_id!=0 || $userpercentage->religion_id!=0 || $userpercentage->statut_marital_id!=0 || $userpercentage->me_marier_id!=0 || $userpercentage->cherche_relation_id!=0 ||
			$userpercentage->niveau_etude_id!=0 ||
			$userpercentage->secteur_activite_id!=0 ||
			$userpercentage->fumer_id!=0 ||
			$userpercentage->temperament_id!=0 ||
			$userpercentage->langue1_id!=0 || 
			$userpercentage->langue2_id!=0 || 
			$userpercentage->langue3_id!=0 || 
			$userpercentage->vouloir_enfants_id!=0 ||
			$userpercentage->garde_id!=0 ||
			$userpercentage->vie_id!=0 ||			// profil_vie
			$userpercentage->cuisine1_id!=0 ||		// profil_cuisine
			$userpercentage->cuisine2_id!=0 ||		// profil_cuisine
			$userpercentage->cuisine3_id!=0 ||		// profil_cuisine
			$userpercentage->sortie1_id!=0 ||		// profil_sortie
			$userpercentage->sortie2_id!=0 ||		// profil_sortie
			$userpercentage->sortie3_id!=0 ||		// profil_sortie
			$userpercentage->loisir1_id!=0 ||	// profil_loisir
			$userpercentage->loisir2_id!=0 ||	// profil_loisir
			$userpercentage->loisir3_id!=0 ||	// profil_loisir
			$userpercentage->sport1_id!=0 ||// profil_sport
			$userpercentage->sport2_id!=0 ||// profil_sport
			$userpercentage->sport3_id!=0 ||// profil_sport
			$userpercentage->musique1_id!=0 ||		// profil_musique
			$userpercentage->musique2_id!=0 ||		// profil_musique
			$userpercentage->musique3_id!=0 ||		// profil_musique
			$userpercentage->film1_id!=0 ||		// profil_film
			$userpercentage->film2_id!=0 ||		// profil_film
			$userpercentage->film3_id!=0 ||		// profil_film
			$userpercentage->lecture1_id!=0 ||		// profil_lecture
			$userpercentage->lecture2_id!=0 ||		// profil_lecture
			$userpercentage->lecture3_id!=0 ||		// profil_lecture
			$userpercentage->animaux1_id!=0 ||
			$userpercentage->animaux2_id!=0 ||
			$userpercentage->animaux3_id!=0){
			
			$percentagevalue='100%';
			}
		
				?>
				
				
				

						<!--<h3><?php // echo $userProfilMini->username; ?></h3>-->
						<div class="col-lg-12">
						<!--<div class="col-lg-4">
						<div class="rd-navbar-toggle_login mobile_res_lang" style="margin-top:65%;">
						<ul class="header_menu">							
						  <li  class="dropdown lang_stl" style="border-radius: 5px;">
						  <a href="javascript:void(0)" class="dropbtn" onclick="myFunction()"><?php echo $nav_active_string;?>
						  </a>
						  <div class="dropdown-content" id="myDropdown">
						  <?php echo $navString;?>
						  </div>
						  </li>
						</ul>
						</div>
						</div>-->
							
					    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<ul class="nav profileavat navbar-nav-custom pull-right">
						<li class="dropdown">
							<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo $lang_apphead["VoirMonProfil"];?>">
							<img src="<?php echo $photo; ?>" alt="<?php echo $user->username; ?>" class="img-circle profile-avatar">
							<i class="fa fa-angle-down"></i>
							</a>
						<ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-header">
                                   <h4 class="text-uppercase m-0"><?php echo $userProfilMini->username; ?></h4> 
				
						  <small class="uppercase-bold text-strong text-transparent-black"><b><?php echo $lang_apphead["Statut"];?>:</b> <span class="statut<?php echo $user->confirmed; ?>" title="<?php echo $title; ?>"><?php echo $user->confirmed ==2 ? $lang_apphead["EnAttenteDeValidation"] :  $lang_apphead["Confirme"]; ?></span></small>
                                    </li>
									<li>
										<a href="<?php echo JL::url('index.php?app=profil&action=step1&'.$langue); ?>" class="abo" title="<?php echo $lang_apphead["VoirMonProfil"];?>"><i class="fa fa-user fa-fw pull-right"></i><?php echo $lang_apphead["VoirMonProfil"];?></a>
									</li>
                                    <li>
                                     
                                            <?
										// abonn&eacute;
										if($user->gold_limit_date != '0000-00-00' && strtotime($user->gold_limit_date) >= time()) {
									?>
									<small class="uppercase-bold text-strong text-transparent-black  parentsolo_sub"><b><?php echo $lang_apphead["FinDAbonnement"];?>  :</b> <span class="parentsolo_sub"><?php echo date('d/m/y', strtotime($user->gold_limit_date)); ?></span></small>
											
									<?
										} else {
									?>
											<a href="<?php echo JL::url('index.php?app=abonnement&action=tarifs'.'&'.$langue); ?>" title="<?php echo $lang_apphead["AboPourToute"];?>" class="abo"><i class="fa fa-inbox fa-fw pull-right"></i> <?php echo $lang_apphead["AbonnezVous"];?> !</a>
									<?
										}
									?>
                                     
                                    </li>
                                    
                                    <li>    
                                       <a href="<?php echo JL::url('index.php?auth=logout'.'&'.$langue); ?>" title="<?php echo $lang_apphead["LogoutTitle"];?>" class="logout"><i class="fa fa-power-off fa-fw pull-right"></i><?php echo $lang_apphead["Deconnexion"];?></a>
                                        </a>
                                    </li>
                                </ul>
						</li>
						</ul>	
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 hidden-xs" style=" margin-top: 26px;"><a href="#" <?php if($percentagevalue!='100%'){?>data-toggle="tooltip" title="<?php echo $lang_apphead["Finalize"]; ?>"<?php } ?>><span class="percentage_span"><?php echo $percentagevalue;?></span>
						<img src="images/percentage.png" title="percentage" class="percentage" style="width: 63px; height: 61px;"></a>
						</div>
						
						
							
						<div class="tile profile-widget" style="display:none;">
						<section class="tile-widget bginfo">
							<a href="<?php echo JL::url('index.php?app=profil&action=step1&'.$langue); ?>" title="<?php echo $lang_apphead["VoirMonProfil"];?>">
							<img src="<?php echo $photo; ?>" alt="<?php echo $user->username; ?>" class="img-circle profile-avatar">
							</a>
							<div class="row">
							   <div class="col-md-12">
								  <h4 class="text-uppercase m-0"><?php echo $userProfilMini->username; ?></h4>
								  <small class="uppercase-bold text-strong text-transparent-black"><b><?php echo $lang_apphead["Statut"];?>:</b> <span class="statut<?php echo $user->confirmed; ?>" title="<?php echo $title; ?>"><?php echo $user->confirmed ==2 ? $lang_apphead["EnAttenteDeValidation"] :  $lang_apphead["Confirme"]; ?></span></small>
							   </div>
							</div>
							<div class="row bgbottom">
								 <div class="col-md-6 nopadding">
									<?
										// abonn&eacute;
										if($user->gold_limit_date != '0000-00-00' && strtotime($user->gold_limit_date) >= time()) {
									?>
											<b><?php echo $lang_apphead["FinDAbonnement"];?>:</b> <span class="black"><?php echo date('d/m/y', strtotime($user->gold_limit_date)); ?></span>
									<?
										} else {
									?>
											<a href="<?php echo JL::url('index.php?app=abonnement&action=tarifs'.'&'.$langue); ?>" title="<?php echo $lang_apphead["AboPourToute"];?>" class="abo"><?php echo $lang_apphead["AbonnezVous"];?> !</a>
									<?
										}
									?>
								 </div>
								 <div class="col-md-6 nopadding">
									<a href="<?php echo JL::url('index.php?auth=logout'.'&'.$langue); ?>" title="<?php echo $lang_apphead["LogoutTitle"];?>" class="logout"><?php echo $lang_apphead["Deconnexion"];?></a>
								 </div>
							</div>	
							<div class="divider"></div>
						 </section>	
						</div>						 
							
						
							
						</div>
				
				<?php // pas de photo, on affiche le popin
						if($noPhotoPopIn) { 
				?>
							<div class="noPhotoPopIn" id="noPhotoPopIn" onClick="document.location='<?php echo JL::url('index.php?app=profil&action=step2'.'&'.$langue); ?>';"><div ><?php echo $lang_apphead["AugmentezVosChancesPhoto"];?>!</div></div>
							<script language="javascript" type="text/javascript">
								var timerAlert2;
								$('noPhotoPopIn').fade('hide');
								noPhotoPopIn(0);
							</script>
				<?php 
						}
					}
				
				?>
			</div>						
			<?
							if(!$user->id){
								?>	
			<section class="skew-1-1 top_skew homepage_headerstyle bg-images-baner section-md-50 section-16 header_top_fixed text-center Logo_homepage" style="margin-top:0px;">
				
					<div class="shell position-r logo_res_wth mobile_res_logo">
						<a href="<?php echo SITE_URL; ?>/index.php?lang=<?php echo $_GET['lang']; ?>" title="<?// echo SITE_DESCRIPTION; ?>" class="logo" ><img src="<?php echo $template;?>/images/logo_<?php echo $_GET['lang']; ?>.png" alt="ParentSolo.ch"  /></a>
					</div>
			
				
			</section>	
			
							<?}
							else{
								?>
								<section class="skew-1-1 bg-images-baner section-md-50 section-16 header_top_fixed text-left" style="margin-top:0px;">
			<div class="position-r logo_res_wth mobile_res_logo" style="text-align:left;" >
				<a href="<?php echo SITE_URL; ?>/index.php?lang=<?php echo $_GET['lang']; ?>" title="<?// echo SITE_DESCRIPTION; ?>" class="logo" ><img src="<?php echo $template;?>/images/logo_<?php echo $_GET['lang']; ?>.png" alt="ParentSolo.ch"  class="image_logo_login" /></a>
			</div>
			</section>
			
			<header class="page-head" >
			
				<!--<div class="shell position-r logo_res_wth mobile_res">
	<a href="<?php echo SITE_URL; ?>/index.php?lang=<?php echo $_GET['lang']; ?>" title="<?// echo SITE_DESCRIPTION; ?>" class="logo" ><img src="<?php echo $template;?>/images/logo_<?php echo $_GET['lang']; ?>.png" alt="ParentSolo.ch"  /></a>
</div>-->
<nav class="navbar navbar-default menubar_fixed admin_menu_link" style="    background: #000000; border:0px; border-left: 0px; border-right: 0px;">
      <div class="container-fluid">
	  <div class="col-md-5  col-sm-4 col-xs-12 menu_right_side float_right"> 
		<ul class="nav navbar-nav navbar-right"> 
		
		 <li class="online_offline">
  <input type="checkbox" name="onlineoff" id="onlineoff" class="onlineoff"  onchange="online_btn()" data-toggle="toggle" data-on="<?php echo $lang_apphead["online_icon"];?>" data-off="<?php echo $lang_apphead["offline_icon"];?>" data-onstyle="success" data-offstyle="danger" style="    padding: 0px 10px;"> 
  </li>
  <script>

jQuery.noConflict();
(function($) {	
$(document).ready(function() 
 {
  var value1=<?php  echo $useronstatus->on_off_status ?>;
 if(value1==1){
 $('#onlineoff').prop('checked',true);
 } 
});
})(jQuery);

function online_btn(){
var checkvalue_online=document.getElementById('onlineoff');
var checkvalue = checkvalue_online.checked ? 1 : 0;
var userid='<?php echo $user->id?>';
(function($) {
$.ajax({
     type:"post",
	 url:"app/app_head/head.html.php",
	 data:{'option':'common','checkvalue':checkvalue,'userid':userid},
	 success:function(data){	 
	 }
 });
 })(jQuery);
 }
</script>
<script >

</script>			
			 <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $nav_active_string;?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                 <?php echo $navString;?>
              </ul>
           
          </ul>
		  </div>
		  <div class="col-md-2  col-sm-2 col-xs-2 menu_right_side hidden-md  hidden-lg"> 
		  <header class="logo hidden-lg hidden-md"> 
		<a href="javascript:void(0)" class="sidebar-icon closebtn" style="float:left; margin-top:8px;" onclick="openNav()"> <span class="fa fa-bars"></span> </a> <a href="#">
        </a> 
	</header>
		
		  </div>
       <div class="col-md-7 col-sm-6 col-xs-12 float_Left login_notify_link hidden-xs"> <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav" style="margin-top: 10px;">
		  <li class="border_rght">
		  <a href="<?php echo JL::url('index.php?app=message&action=inbox&').'lang='.$_GET['lang']; ?>" ><span class="alert_box_top"><?php echo $userStats->message_new; ?></span>
		  <i class="gi gi-message_new text-light-op"></i>
		  
		  </a>

		  </li>
<li class="border_rght"><a href="javascript:void(0)" onClick="windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&'.$langue); ?>','800px','600px');"><span class="alert_box_top"><span  class="result_menu_data">0</span></span> <i class="fa fa-comments text-light-op"></i></a>
						</li>
			<li class="border_rght"><a href="<?php echo JL::url('index.php?app=message&action=flowers').'&lang='.$_GET['lang']; ?>" ><span class="alert_box_top"><?php echo $userStats->fleur_new; ?></span> <i class="gi gi-flower text-light-op"></i></a>
			
			</li>
			<li class="border_rght"><a href="<?php echo JL::url('index.php?app=search&action=visits').'&lang='.$_GET['lang']; ?>" >
			<span class="alert_box_top"><?php echo $userStats->visite_total; ?></span> <i class="gi gi-user text-light-op"></i></a>
	

			</li>
			<li><a href="<?php echo JL::url('index.php?app=points&action=mespoints').'&lang='.$_GET['lang']; ?>" ><span class="alert_box_top"><?php echo $userStats->points_total; ?></span> 
			<i class="gi gi-coins text-light-op"></i></a>											


			</li>		
		</ul>
          
        </div></div>
		
		
      </div>
    </nav>
			
            </div>
         </header>

								<?
								
								//JL::loadMod('menu');
							}
						?>			
			</div>
			
		<?
		
		}
		
	}
?>
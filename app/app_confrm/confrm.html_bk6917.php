<?php

  
include('lang/app_confrm.'.$_GET["lang"].'.php');
 
	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	class HTML_confrm {		
		// affichage de la fiche d&eacute;taill&eacute;e d'un groupe
		public static function confirmationText(&$Value_up) {
			include("lang/app_confrm.".$_GET['lang'].".php");
			global $langue, $action, $user;
			?>
			
			<?
			if($Value_up=='Updated'){
			?>
			<div class="parentsolo_txt_center">
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-10 col-md-offset-1 parentsolo_form_style parentsolo_txt_center">
				
				<h3 class="parentsolo_title_h3 parentsolo_txt_center" style="    font-size: 22px !important;"><? echo $lang_confrm["success_msg"]; ?></h3>
<br><br><a href="#" data-toggle="modal" data-target="#myModal" class="bouton envoyer parentsolo_btn"><? echo $lang_confrm["click_here"]; ?></a>
				<div class="row bottompadding">
							
							<div class="col-md-12">
							
							</div>
				</div>
				
				
				
			</div>
						
					</div>
				</div>
				<div class="parentsolo_txt_center">
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
					
			<?
			
			}
			else if($Value_up=='Already'){
			?>
			<div class="parentsolo_txt_center">
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-10 col-md-offset-1 parentsolo_form_style  parentsolo_txt_center">
				
				<h3 class="parentsolo_title_h3 parentsolo_txt_center" style="    font-size: 22px !important;"><? echo $lang_confrm["alrdy_register"]; ?></h3>
				<br><br><a href="#" data-toggle="modal" data-target="#myModal" class="bouton envoyer parentsolo_btn"><? echo $lang_confrm["click_here"]; ?></a>

				<div class="row bottompadding">
							
							<div class="col-md-12">
							
							</div>
				</div>
				
				
				
			</div>
						
					</div>
				</div>
				<div class="parentsolo_txt_center">
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
					
			<?
			}
			else{
				header("Location:index.php?lang=".$_GET['lang']."");
			}
		
}
			
			
			/*
			?>
			
			
			
		<?	*/
			// pour chaque genre
			}

?>

	


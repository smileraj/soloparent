<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class presse_HTML {
	
		
		
		public static function display(&$contenu) {
			include("lang/app_presse.".$_GET['lang'].".php");
		
			if($contenu){
		?>
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title parentsolo_mt_40"><? echo $contenu->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
				<div class="texte_explicatif">
					<!-- AddThis Button BEGIN -->
					<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
						<div  style="padding:5px; text-align:right; float:right; height:50px;">
							<a class="addthis_button_facebook" style="cursor:pointer"></a><a class="addthis_button_twitter" style="cursor:pointer"></a><a class="addthis_button_email" style="cursor:pointer"></a>
							<a class="addthis_button_compact"></a>
						</div>
					</div>
					<script type="text/javascript">var addthis_config = {"data_track_clickback":false};</script>
					<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=parentsolo"></script>
					<!-- AddThis Button END -->
					
					<? echo  $contenu->texte; ?>
				</div>
		<?
			}else{
				JL::loadMod('error404');
			}	
		}
		
	}
?>

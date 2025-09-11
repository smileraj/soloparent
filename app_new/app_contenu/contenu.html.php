<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class contenu_HTML{
	
		
		
		function contenu(&$contenu) {
			global $db, $template;


			if($contenu){
		?>
			<div class="texte_explicatif">
				<div class="parentsolo_txt_center"><h2 class="parentsolo_title barre parentsolo_pt_10">
				<? echo $contenu->titre;?>
				</h2>
			<div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
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

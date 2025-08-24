<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class contenuView extends JLView {
	
		function contenuView() {}
		
		
		function display(&$contenu) {
			global $db, $template;
			
		?>
			
			<!-- Partie Droite -->
			<div class="content">
				<div class="contentl">
					<div class="colc">
						
						<h1><? echo $contenu->titre;?></h1>
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
<br />
						<p>
							<? echo  $contenu->texte; ?>
						</p>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<div class="colr"> 
				<?
					JL::loadApp('menu_offline');
				?>
				
    
		<?
		
		}
		
	}
?>

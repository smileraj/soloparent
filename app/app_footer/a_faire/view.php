<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class footerView extends JLView {
	
		function footerView() {}
		
		// v&eacute;rifie si l'utilisateur veut se log ou est log, et renseigne la variable global $user
		function display() {
			include("lang/app_footer.".$_GET['lang'].".php");
			global $db, $template;
		?>
			<div class="footer">
				<ul>
					<li><a href="<? echo JL::url('index.php?app=contenu&id=5').'&lang='.$_GET['lang']; ?>"><? echo $lang_appfooter["CGU"];?></a></li>
					<li><a href="<? echo JL::url('index.php?app=contact').'&lang='.$_GET['lang']; ?>"><? echo $lang_appfooter["Contact"];?></a></li>
					<li><a href="<? echo JL::url('index.php?app=presse').'&lang='.$_GET['lang']; ?>"><? echo $lang_appfooter["Presse"];?></a></li>
				<? 
					if($_GET['lang']=='fr' || $_GET['lang']=='en'){ 
				?>
						<li><a href="/pdf/KitMedia_PS.pdf" title="<? echo $lang_appfooter["Publicite"];?>" target="_blank"><? echo $lang_appfooter["Publicite"];?></a></li>
				<? 
					}else{ 
				?>
						<li><a href="/pdf/KitMedia_PS_DE.pdf" title="<? echo $lang_appfooter["Publicite"];?>" target="_blank"><? echo $lang_appfooter["Publicite"];?></a></li>
				<? 
					}
				?>
					<li><a href="<? echo JL::url('index.php?app=contenu&id=118').'&lang='.$_GET['lang']; ?>"><? echo $lang_appfooter["Tarifs"];?></a></li>
				</ul>
				<div class="cpr">
					Copyright &copy; 2009 - <? echo date('Y');?> - Parentsolo.ch
				</div>
			</div>
		<?
		
		}
		
	}
?>

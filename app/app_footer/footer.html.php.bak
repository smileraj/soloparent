<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class footer_HTML {
	
		
		// vérifie si l'utilisateur veut se log ou est log, et renseigne la variable global $user
		function footer() {
			include("lang/app_footer.".$_GET['lang'].".php");
			global $db, $template,$user, $langue;
		?>
			<div class="footer">
				<ul>
					<li><a href="<? echo JL::url('index.php?app=contenu&id=5').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_appfooter["CGU"];?>"><? echo $lang_appfooter["CGU"];?></a></li>
					<li><a href="<? echo JL::url('index.php?app=temoignage').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_appfooter["Temoignages"];?>"><? echo $lang_appfooter["Temoignages"];?></a></li>
					<li><a href="<? echo JL::url('index.php?app=appel_temoins').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_appfooter["AppelsATemoins"];?>"><? echo $lang_appfooter["AppelsATemoins"];?></a></li>
					<li><a href="<? echo JL::url('index.php?app=inviter').'&lang='.$_GET['lang']; ?>" title="<? if(!$user->id){echo $lang_appfooter["ConseillezCeSite"];}else{echo $lang_appfooter["Parrainage"];}?>"><? if(!$user->id){echo $lang_appfooter["ConseillezCeSite"];}else{echo $lang_appfooter["Parrainage"];}?></a></li>
					<li><a href="<? echo JL::url('index.php?app=contact').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_appfooter["Contact"];?>"><? echo $lang_appfooter["Contact"];?></a></li>
					<li><a href="<? echo JL::url('index.php?app=presse').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_appfooter["Presse"];?>"><? echo $lang_appfooter["Presse"];?></a></li>
				<?
					if($_GET['lang']=='fr'){
				?>
						<li><a href="/pdf/KitMedia_PS.pdf" title="<? echo $lang_appfooter["Publicite"];?>" target="_blank"><? echo $lang_appfooter["Publicite"];?></a></li>
				<?
					}elseif($_GET['lang']=='de'){
				?>
						<li><a href="/pdf/KitMedia_PS_DE.pdf" title="<? echo $lang_appfooter["Publicite"];?>" target="_blank"><? echo $lang_appfooter["Publicite"];?></a></li>
				<?
					}elseif($_GET['lang']=='en'){
				?>
						<li><a href="/pdf/KitMedia_PS_EN.pdf" title="<? echo $lang_appfooter["Publicite"];?>" target="_blank"><? echo $lang_appfooter["Publicite"];?></a></li>
				<?
					}
				?>
					<!--<li><a href="<? echo JL::url('index.php?app=contenu&id=118').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_appfooter["Tarifs"];?>"><? echo $lang_appfooter["Tarifs"];?></a></li> -->
				</ul>
				<div class="cpr">
					<? echo $lang_appfooter["Copyright"];?>
				</div>
			</div>
		<?
		
		}
		
	}
?>

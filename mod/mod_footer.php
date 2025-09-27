<?php

	// scurit
	defined('JL') or die('Error 401');

	global $user, $db, $template;
	include("lang/app_mod.".$_GET['lang'].".php");
	
	if($_GET['lang']=='de'){
		$class = 'class="footer_de"';
	}
?>
<!--<footer class="page-foot section-md-top-50 section-34 border-top position-r">-->
<footer class="page-foot section-top-34 border-top position-r parentsolo_zindex_footer">
<div class="shell">
	<div class="range range-md-reverse">
		<div class="cell-md-3 cell-sm-6">
			<img  src="images/payment.jpg" >
	
			</div>
		<div class="cell-md-3 cell-sm-6  cell-xs-6">
			<ul class="footer_ul_cls"><li><a href="<?php echo JL::url('index.php?app=temoignage').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["Temoignages"];?>"><?php echo $lang_mod["Temoignages"];?></a></li>
			<li><a href="<?php echo JL::url('index.php?app=temoignage&action=edit').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["JeDesireTemoigner"];?>"><?php echo $lang_mod["JeDesireTemoigner"];?></a></li>
		<li><a href="<?php echo JL::url('index.php?app=appel_a_temoins').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["AppelsATemoins"];?>"><?php echo $lang_mod["AppelsATemoins"];?></a></li>
<li><a href="<?php echo JL::url('index.php?app=contenu&id=126').'&lang='.$_GET['lang']; ?>" title="<?php echo "FAQ";?>"><?php echo "FAQ";?></a></li>
			</ul>
		</div>
		<div class="cell-md-3 cell-sm-6  cell-xs-6">
			<ul class="footer_ul_cls">
				<li><a href="<?php echo JL::url('index.php?app=presse').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["Presse"];?>"><?php echo $lang_mod["Presse"];?></a></li>
			
					<li><a href="<?php echo JL::url('index.php?app=contenu&id=110').'&lang='.$_GET['lang']; ?>" title="<?php if(!$user->id){echo $lang_mod["ConseillezCeSite"];}else{echo $lang_mod["Parrainage"];}?>"><?php if(!$user->id){echo $lang_mod["ConseillezCeSite"];}else{echo $lang_mod["Parrainage"];}?></a></li>
					
					<?php if($user->id){  ?>
                     <li> <a href="<?php echo JL::url('index.php?app=abonnement&action=infos').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["Tarifs"];?>"><?php echo $lang_mod["Tarifs"];?></a></li>
                     <?php }?>
			</ul>
		</div>
		<div class="cell-md-3 cell-sm-6  cell-xs-6">
			<ul class="footer_ul_cls"><li><a href="<?php echo JL::url('index.php').'?lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["Accueil"];?>"><?php echo $lang_mod["Accueil"];?></a></li>
			<!-- <li><a href="<?php echo JL::url('index.php?app=contenu&id=2').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["ConceptUnique"];?>"><?php echo $lang_mod["ConceptUnique"];?></a></li> -->
			<li><a href="<?php echo JL::url('index.php?app=contenu&id=5').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["CGU"];?>"><?php echo $lang_mod["CGU"];?></a></li>
			<li><a href="<?php echo JL::url('index.php?app=contact').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["Contact"];?>"><?php echo $lang_mod["Contact"];?></a></li>
			</ul>
		</div>
	</div>
<div class="range range-md-reverse">
<div class="cell-md-7 position-r text-md-left">
	<ul class="list-inline">
<li>
  <a target="_blank" href="<?php echo defined('FACEBOOKURL') ? FACEBOOKURL : '#'; ?>" class="fa-facebook-official icon icon-sm"></a>
</li>
<li>
  <a target="_blank" href="<?php echo defined('TWITTERURL') ? TWITTERURL : '#'; ?>" class="fa-twitter-square icon icon-sm"></a>
</li>

</ul>	
</div>

<div class="cell-md-5 text-md-left">
<p style="padding-top:12px; padding-bottom:0px; margin-bottom:5px !important"><?php echo $lang_mod["Copyright"];?>
</p>
</div>
</div>
</div>
</footer>
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
			<img  src="images/paiement_<? echo $_GET['lang']; ?>.jpg" >
	
			</div>
		<div class="cell-md-3 cell-sm-6  cell-xs-6">
			<ul class="footer_ul_cls"><li><a href="<? echo JL::url('index.php?app=temoignage').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["Temoignages"];?>"><? echo $lang_mod["Temoignages"];?></a></li>
			<li><a href="<? echo JL::url('index.php?app=temoignage&action=edit').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["JeDesireTemoigner"];?>"><? echo $lang_mod["JeDesireTemoigner"];?></a></li>
		<li><a href="<? echo JL::url('index.php?app=appel_a_temoins').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["AppelsATemoins"];?>"><? echo $lang_mod["AppelsATemoins"];?></a></li>
<li><a href="<? echo JL::url('index.php?app=contenu&id=126').'&lang='.$_GET['lang']; ?>" title="<? echo "FAQ";?>"><? echo "FAQ";?></a></li>
			</ul>
		</div>
		<div class="cell-md-3 cell-sm-6  cell-xs-6">
			<ul class="footer_ul_cls">
				<li><a href="<? echo JL::url('index.php?app=presse').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["Presse"];?>"><? echo $lang_mod["Presse"];?></a></li>
			<? if($_GET['lang']=='de'){?>
						<li><a href="http://www.goldbachaudience.com" title="<? echo $lang_mod["Publicite"];?>" target="_blank"><? echo $lang_mod["Publicite"];?></a></li>
					<? }elseif($_GET['lang']=='en') { ?>
						<li><a href="http://www.goldbachaudience.com" title="<? echo $lang_mod["Publicite"];?>" target="_blank"><? echo $lang_mod["Publicite"];?></a></li>
					<? }else{ ?>
						<li><a href="http://www.goldbachaudience.com" title="<? echo $lang_mod["Publicite"];?>" target="_blank"><? echo $lang_mod["Publicite"];?></a></li>
					<? } ?>
					<li><a href="<? echo JL::url('index.php?app=contenu&id=110').'&lang='.$_GET['lang']; ?>" title="<? if(!$user->id){echo $lang_mod["ConseillezCeSite"];}else{echo $lang_mod["Parrainage"];}?>"><? if(!$user->id){echo $lang_mod["ConseillezCeSite"];}else{echo $lang_mod["Parrainage"];}?></a></li>
					
					<? if($user->id){  ?>
                     <li> <a href="<? echo JL::url('index.php?app=abonnement&action=infos').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["Tarifs"];?>"><? echo $lang_mod["Tarifs"];?></a></li>
                     <? }?>
			</ul>
		</div>
		<div class="cell-md-3 cell-sm-6  cell-xs-6">
			<ul class="footer_ul_cls"><li><a href="<? echo JL::url('index.php').'?lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["Accueil"];?>"><? echo $lang_mod["Accueil"];?></a></li>
			<li><a href="<? echo JL::url('index.php?app=contenu&id=2').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["ConceptUnique"];?>"><? echo $lang_mod["ConceptUnique"];?></a></li>
			<li><a href="<? echo JL::url('index.php?app=contenu&id=5').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["CGU"];?>"><? echo $lang_mod["CGU"];?></a></li>
			<li><a href="<? echo JL::url('index.php?app=contact').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["Contact"];?>"><? echo $lang_mod["Contact"];?></a></li>
			</ul>
		</div>
	</div>
<div class="range range-md-reverse">
<div class="cell-md-7 position-r text-md-left">
	<ul class="list-inline">
<li><a target="_blank" href="https://www.facebook.com/ParentsoloSingleltern/?ref=bookmarks" class="fa-facebook-official icon icon-sm"></a></li>
<li><a target="_blank" href="http://www.twitter.com/parentsolo" class="fa-twitter-square icon icon-sm"></a></li>
</ul>	
</div>

<div class="cell-md-5 text-md-left">
<p style="padding-top:12px; padding-bottom:0px; margin-bottom:5px !important"><? echo $lang_mod["Copyright"];?>
</p>
</div>
</div>
</div>
</footer>

	<!--<footer class="footer">
		<!--<div class="reseaux_sociaux">
			<table>
				<tr>
					<td valign="middle"><b>R&eacute;seaux sociaux</b></td>
					<td><a target="_blank" href="http://www.twitter.com/parentsolo"><img src="<? echo $template;?>/images/twitter.jpg"></a>
                        <a target="_blank" href="https://www.facebook.com/Parentsoloch-Singlelternch-197136890695271"><img src="<? echo $template;?>/images/facebook_square.png"></a>
                    </td>
				</tr>
			</table>
		</div>
		<div style="clear:both"> </div>
		<div class="menu_footer">
			<table width="100%">
				<tr>
					<td width="25%"><a href="<? echo JL::url('index.php').'?lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["Accueil"];?>"><? echo $lang_mod["Accueil"];?></a></td>
					<td><a href="<? echo JL::url('index.php?app=presse').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["Presse"];?>"><? echo $lang_mod["Presse"];?></a></td>
					<td width="25%"><a href="<? echo JL::url('index.php?app=temoignage').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["Temoignages"];?>"><? echo $lang_mod["Temoignages"];?></a></td>
					<td width="25%" rowspan="4"><!--<img src="http://www.parentsolo.ch/images/paiement.jpg" style="width:180px"></td>
				</tr>
				<tr>
					<td><a href="<? echo JL::url('index.php?app=contenu&id=2').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["ConceptUnique"];?>"><? echo $lang_mod["ConceptUnique"];?></a></td>
					<? if($_GET['lang']=='de'){?>
						<td><a href="http://www.goldbachaudience.com" title="<? echo $lang_mod["Publicite"];?>" target="_blank"><? echo $lang_mod["Publicite"];?></a></td>
					<? }elseif($_GET['lang']=='en') { ?>
						<td><a href="http://www.goldbachaudience.com" title="<? echo $lang_mod["Publicite"];?>" target="_blank"><? echo $lang_mod["Publicite"];?></a></td>
					<? }else{ ?>
						<td><a href="http://www.goldbachaudience.com" title="<? echo $lang_mod["Publicite"];?>" target="_blank"><? echo $lang_mod["Publicite"];?></a></td>
					<? } ?>
					<td><a href="<? echo JL::url('index.php?app=temoignage&action=edit').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["JeDesireTemoigner"];?>"><? echo $lang_mod["JeDesireTemoigner"];?></a></td>
				</tr>
				<tr>
					<td><a href="<? echo JL::url('index.php?app=contenu&id=5').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["CGU"];?>"><? echo $lang_mod["CGU"];?></a></td>
                    <td><a href="<? echo JL::url('index.php?app=contenu&id=110').'&lang='.$_GET['lang']; ?>" title="<? if(!$user->id){echo $lang_mod["ConseillezCeSite"];}else{echo $lang_mod["Parrainage"];}?>"><? if(!$user->id){echo $lang_mod["ConseillezCeSite"];}else{echo $lang_mod["Parrainage"];}?></a> </td>
					<td width="25%"><a href="<? echo JL::url('index.php?app=partenaire').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["Partenaires"];?>"><? echo $lang_mod["Partenaires"];?></a></td>
					<td><a href="<? echo JL::url('index.php?app=appel_a_temoins').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["AppelsATemoins"];?>"><? echo $lang_mod["AppelsATemoins"];?></a></td>
				</tr>
				<tr>
					<td><a href="<? echo JL::url('index.php?app=contact').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["Contact"];?>"><? echo $lang_mod["Contact"];?></a></td>
					
                    <td>
                      <? if($user->id){  ?>
                      <a href="<? echo JL::url('index.php?app=abonnement&action=infos').'&lang='.$_GET['lang']; ?>" title="<? echo $lang_mod["Tarifs"];?>"><? echo $lang_mod["Tarifs"];?></a>
                     <? }?>
                    </td>
                    
				</tr>
			</table>
			<div class="cpr">
				<? echo $lang_mod["Copyright"];?>
			</div>
			<div class="groupe">

				<div class="cl_header"></div>
			</div>
		</div>
	</footer>-->

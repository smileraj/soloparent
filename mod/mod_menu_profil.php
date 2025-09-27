<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $user, $app, $action, $langue, $db;
	include("lang/app_mod.".$_GET['lang'].".php");

	$id	= JL::getVar('id', 0);

	// variable pour d&eacute;terminer quel <li> est en class="active"
	$active = -1;

	if($app == 'profil') {		
		if($action=="view") {
			$active = 1;
		}elseif($action=="view2"){
			$active = 2;
		}elseif($action=="view3"){
			$active = 3;
		}elseif($action=="view4"){
			$active = 4;
		}elseif($action=="view5"){
			$active = 5;
		}
	
	?>
	<ul class="top-menu profil_menu_nav profil_shadow">
		<li <?if($active==1){echo 'class="active"';}?>> <a class="<?if($active==1){echo 'selected ';}?> page-scroll" href="<?php echo JL::url('index.php?app=profil&action=view&id='.$id.'&'.$langue); ?>" title="<?php echo $lang_mod["Description"];?>"><i class="fa fa-user"></i> <span> <?php echo $lang_mod["Description"];?> </span></a></li>
        <li <?if($active==2){echo 'class="active"';}?>> <a class="<?if($active==2){echo 'selected ';}?> page-scroll" href="<?php echo JL::url('index.php?app=profil&action=view2&id='.$id.'&'.$langue); ?>" title="<?php echo $lang_mod["Annonce"];?>"><i class="fa fa-file-text-o"></i>  <span> <?php echo $lang_mod["Annonce"];?> </span></a></li>
        <li <?if($active==3){echo 'class="active"';}?>> <a class="<?if($active==3){echo 'selected ';}?> page-scroll" href="<?php echo JL::url('index.php?app=profil&action=view3&id='.$id.'&'.$langue); ?>" title="<?php echo $lang_mod["Photos"];?>"><i class="fa fa-picture-o"></i>  <span> <?php echo $lang_mod["Photos"];?></span></a></li>
        <li <?if($active==4){echo 'class="active"';}?>> <a class="<?if($active==4){echo 'selected ';}?> page-scroll" href="<?php echo JL::url('index.php?app=profil&action=view4&id='.$id.'&'.$langue); ?>" title="<?php echo $lang_mod["Enfants"];?>"><i class="fa fa-comments"></i> <span> <?php echo $lang_mod["Enfants"];?></span></a></li>
        <li <?if($active==5){echo 'class="active"';}?>> <a class="<?if($active==5){echo 'selected ';}?> page-scroll" href="<?php echo JL::url('index.php?app=profil&action=view5&id='.$id.'&'.$langue); ?>" title="<?php echo $lang_mod["Groupes"];?>"><i class="fa fa-map-marker"></i> <span> <?php echo $lang_mod["Groupes"];?> </span></a></li>
    </ul>
							
	<!--	<tr>
			<td <?if($active==1){echo 'class="active"';}?>><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$id.'&'.$langue); ?>" title="<?php echo $lang_mod["Description"];?>"><?php echo $lang_mod["Description"];?></a></td>
			<td <?if($active==2){echo 'class="active"';}?>><a href="<?php echo JL::url('index.php?app=profil&action=view2&id='.$id.'&'.$langue); ?>" title="<?php echo $lang_mod["Annonce"];?>"><?php echo $lang_mod["Annonce"];?></a></td>
			<td <?if($active==3){echo 'class="active"';}?>><a href="<?php echo JL::url('index.php?app=profil&action=view3&id='.$id.'&'.$langue); ?>" title="<?php echo $lang_mod["Photos"];?>"><?php echo $lang_mod["Photos"];?></a></td>
			<td <?if($active==4){echo 'class="active"';}?>><a href="<?php echo JL::url('index.php?app=profil&action=view4&id='.$id.'&'.$langue); ?>" title="<?php echo $lang_mod["Enfants"];?>"><?php echo $lang_mod["Enfants"];?></a></td>
			<td <?if($active==5){echo 'class="active"';}?>><a href="<?php echo JL::url('index.php?app=profil&action=view5&id='.$id.'&'.$langue); ?>" title="<?php echo $lang_mod["Groupes"];?>"><?php echo $lang_mod["Groupes"];?></a></td>
		</tr>
	</table>-->
	<?php 	
	}

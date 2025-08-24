<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $user, $app, $action, $langue, $db;
	include("lang/app_mod.".$_GET['lang'].".php");

	$id	= JL::getVar('id', 0);

	// variable pour d&eacute;terminer quel <li> est en class="active"
	$active = -1;

	if($app == 'temoignage') {
		$menu = 1;
	} elseif($app == 'appel_a_temoins') {
		$menu = 2;
	} elseif($app == 'presse') {
		$menu = 3;
	}



	if($menu){
		?>
		<ul class="nav nav-pills nav-justified parentsolo_testimony">
  
		<?
			switch($menu){
				
				case 3:
				if(isset($_GET['action'])!=''){		$get_action_val=$_GET['action'];}	else{$get_action_val='';}
					?>
						<li class="<? if(($get_action_val=='videos') || ($get_action_val=='') ){ echo "active";} else{  } ?>"><a href="<? echo JL::url('index.php?app=presse&action=videos').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["Videos"];?>"><?php echo $lang_mod["Videos"];?></a></li>
						<li class="<? if($get_action_val=='articles'){ echo "active";} else{  } ?>"><a href="<? echo JL::url('index.php?app=presse&action=articles').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["Articles"];?>"><?php echo $lang_mod["Articles"];?></a></li>
						<li class="<? if($get_action_val=='radios'){ echo "active";} else{  } ?>"><a href="<? echo JL::url('index.php?app=presse&action=radios').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["Radios"];?>"><?php echo $lang_mod["Radios"];?></a></li>
						<li class="<? if($get_action_val=='affiches'){ echo "active";} else{  } ?>"><a href="<? echo JL::url('index.php?app=presse&action=affiches').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["Affiches"];?>"><?php echo $lang_mod["Affiches"];?></a></li>
					<?
				break;
				case 2:
					//9057
					if(isset($_GET['action'])!=''){		$get_action_val=$_GET['action'];}	else{$get_action_val='';}
					//9057
					?>
						<li class="<? if($get_action_val=='info'){ echo "active";} else{  } ?>"><a href="<? echo JL::url('index.php?app=appel_a_temoins&action=info').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["Informations"];?>"><?php echo $lang_mod["Informations"];?></a></li>
						<li class="<? if(($get_action_val=='') || ($get_action_val=='read') ){ echo "active";} else{  } ?>"><a href="<? echo JL::url('index.php?app=appel_a_temoins').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["TousLesAppelsATemoins"];?>"><?php echo $lang_mod["TousLesAppelsATemoins"];?></a></li>
						<li class="<? if($get_action_val=='new'){ echo "active";} else{  } ?>"><a href="<? echo JL::url('index.php?app=appel_a_temoins&action=new').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["LancerUnAppelATemoins"];?>"><?php echo $lang_mod["LancerUnAppelATemoins"];?></a></li>
					<?
				break;
				
				case 1:
				default:
					//9057
					if(isset($_GET['action'])!=''){		$get_action_val=$_GET['action'];}	else{$get_action_val='';}
					//9057
					
					?>
						<li class="<? if($get_action_val=='infos'){ echo "active";} else{  } ?>"><a href="<? echo JL::url('index.php?app=temoignage&action=infos').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["Informations"];?>"><?php echo $lang_mod["Informations"];?></a></li>
						<li class="<? if(($get_action_val=='') || ($get_action_val=='lire') ){ echo "active";} else{  } ?>"><a href="<? echo JL::url('index.php?app=temoignage').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["TousLesTemoignages"];?>"><?php echo $lang_mod["TousLesTemoignages"];?></a></li>
						<li class="<? if($get_action_val=='edit'){ echo "active";} else{  } ?>"><a href="<? echo JL::url('index.php?app=temoignage&action=edit').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mod["JeDesireTemoigner"];?>"><?php echo $lang_mod["JeDesireTemoigner"];?></a></li>
					<?
				break;
			}
		?>	
			</ul>
		<?
		
	}

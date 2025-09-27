<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class mainlink_HTML {
	
		
		// v&eacute;rifie si l'utilisateur veut se log ou est log, et renseigne la variable global $user
	public static function mainlink() {
			include("lang/mainlink.".$_GET['lang'].".php");
			//global $db, $template,$user, $langue;
		?>
		<ul class="menu_items">
			<li><a href="<?php echo JL::url('index.php').'?lang='.$_GET['lang']; ?>" title="<?php echo $lang_mainlink["Accueil"];?>"><i class="icon fa fa-home fa-2x"></i> <?php echo $lang_mainlink["Accueil"];?></a></li>
			<li><a href="<?php echo JL::url('index.php?app=temoignage').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mainlink["Temoignages"];?>"><i class="icon fa fa-star-half-o fa-2x"></i> <?php echo $lang_mainlink["Temoignages"];?></a></li>
			<li><a href="<?php echo JL::url('index.php?app=contenu&id=2').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mainlink["ConceptUnique"];?>"><i class="icon fa fa-connectdevelop fa-2x"></i> <?php echo $lang_mainlink["ConceptUnique"];?></a></li>
			<li><a href="<?php echo JL::url('index.php?app=appel_a_temoins').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mainlink["AppelsATemoins"];?>"><i class="icon fa fa-microphone fa-2x"></i>  <?php echo $lang_mainlink["AppelsATemoins"];?></a></li>
			<li><a href="<?php echo JL::url('index.php?app=contenu&id=5').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mainlink["CGU"];?>"><i class="icon fa fa-info-circle fa-2x"></i> <?php echo $lang_mainlink["CGU"];?></a></li>
			<li><a href="<?php echo JL::url('index.php?app=contact').'&lang='.$_GET['lang']; ?>" title="<?php echo $lang_mainlink["Contact"];?>"><i class="icon fa fa-map-marker fa-2x"></i> <?php echo $lang_mainlink["Contact"];?></a></li>		
			
			</ul>
			
			<?php 		
		}
		
	}
?>

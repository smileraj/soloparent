<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');
			include("lang/app_mod.".$_GET['lang'].".php");

	global $db, $langue, $user;
	
	
	//**R&eacute;cup les derni&egrave;res actu
	$query = "SELECT id, titre as titre, date_add"
	." FROM actualite"
	." WHERE published = 1"
	." ORDER BY date_add DESC"
	." LIMIT 0, 4"
	;
	$actualites = $db->loadObjectList($query);

	?>

<div class="col-md-6 col-sm-12">
	<div class="col-md-12"><h3 class="verela_title_h3  parentsolo_pb_15"><?php echo $lang_mod["Actualites"];?></h3></div>
 	<div class="col-md-12 col-sm-12  testimonials-style-2  testimonials-bg_admin parentsolo_pl-r">
            
             <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                   <ul class="ul_stl parentsolo_pt_15 ">
					<?php 						foreach($actualites as $actualite) {
						JL::makeSafe($actualite);
						?>
							<li>
								<i class="fa fa-check-square-o"></i> <a href="<?php echo JL::url('index.php?app=contenu&action=actu&id='.$actualite->id).'&lang='.$_GET['lang']; ?>" title="<?php echo $actualite->titre; ?>"><?php echo $actualite->titre; ?></a>
							</li>
						<?php 						}
					?>
					</ul>
                   
                </div>
            </div>
        </div>
	<!--<div class="bloc bloc_left">
		<h3><?php // echo $lang_mod["Actualites"];?></h3>
		<table width="100%">
			<tr>
				<td>
					<ul>
					<?php 					/*	foreach($actualites as $actualite) {
						JL::makeSafe($actualite);
						?>
							<li>
								<a href="<?php echo JL::url('index.php?app=contenu&action=actu&id='.$actualite->id).'&lang='.$_GET['lang']; ?>" title="<?php echo $actualite->titre; ?>"><?php echo $actualite->titre; ?></a>
							</li>
						<?php 						}*/
					?>
					</ul>
				</td>
			</tr>
		</table>
	</div>-->


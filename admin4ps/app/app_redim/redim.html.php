<?php 	defined('JL') or die ('Error 401');
	
	class redim_HTML{
		
		public static function edit($row, $dim){
			
			?>
			<div id="conteneur" style="background: url(<?php echo SITE_URL.'/images/'.$row->dossier.'/'.$row->id.'/m-'.$row->img; ?>) no-repeat; width: <?php echo $dim->largeur.'px';?>; height: <?php echo $dim->hauteur.'px';?>;  margin: 0 auto;">
			 <div id="bloc_recadre" name="bloc_recadre" onMouseOver="fnOnMouseOver('bloc_recadre', 'conteneur');" onMouseOut="fnOnMouseOver();"></div> 
			</div>

			<form name="adminForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
				<input type="hidden" name="app" value="redim" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="photo" value="<?php echo $row->img; ?>" />
				<input type="hidden" name="dossier" value="<?php echo $row->dossier; ?>" />
				
			
				<input type="hidden" id="sx" name="sx" value="" /> 
				<input type="hidden" id="sy" name="sy" value="" />
				<input type="hidden" id="ex" name="ex" value="" /> 
				<input type="hidden" id="ey" name="ey" value="" />

				<center><input type="submit" value="Redimensionner" /></center>
			</form>


			<?php 		}
		
		public static function resultat($row){
			?>
			<img src='<?php echo SITE_URL.'/images/'.$row->dossier.'/'.$row->id.'/m-'.$row->img;?>'><br/><br/>
			<img src='<?php echo SITE_URL.'/images/'.$row->dossier.'/'.$row->id.'/s-preview-'.$row->img;?>'><br/>

			<a href="<?php echo JL::url('index.php?app=redim&action=edit&dossier='.$row->dossier.'&id='.$row->id.'&photo='.$row->img);?>">R&eacute;essayer</a><br/>
			
		<?php 			if($row->dossier == 'experts'){
		?>
				<a href="<?php echo JL::url('index.php?app=expert&action=edit&id='.$row->id); ?>">Retour &agrave; l'annonce de l'expert</a>
		<?php 			}
		}
	}
?>

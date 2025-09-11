<?
	defined('JL') or die ('Error 401');
	
	class redim_HTML{
		
		public static function edit($row, $dim){
			
			?>
			<div id="conteneur" style="background: url(<? echo SITE_URL.'/images/'.$row->dossier.'/'.$row->id.'/m-'.$row->img; ?>) no-repeat; width: <? echo $dim->largeur.'px';?>; height: <? echo $dim->hauteur.'px';?>;  margin: 0 auto;">
			 <div id="bloc_recadre" name="bloc_recadre" onMouseOver="fnOnMouseOver('bloc_recadre', 'conteneur');" onMouseOut="fnOnMouseOver();"></div> 
			</div>

			<form name="adminForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<input type="hidden" name="id" value="<? echo $row->id; ?>" />
				<input type="hidden" name="app" value="redim" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="photo" value="<? echo $row->img; ?>" />
				<input type="hidden" name="dossier" value="<? echo $row->dossier; ?>" />
				
			
				<input type="hidden" id="sx" name="sx" value="" /> 
				<input type="hidden" id="sy" name="sy" value="" />
				<input type="hidden" id="ex" name="ex" value="" /> 
				<input type="hidden" id="ey" name="ey" value="" />

				<center><input type="submit" value="Redimensionner" /></center>
			</form>


			<?
		}
		
		public static function resultat($row){
			?>
			<img src='<? echo SITE_URL.'/images/'.$row->dossier.'/'.$row->id.'/m-'.$row->img;?>'><br/><br/>
			<img src='<? echo SITE_URL.'/images/'.$row->dossier.'/'.$row->id.'/s-preview-'.$row->img;?>'><br/>

			<a href="<? echo JL::url('index.php?app=redim&action=edit&dossier='.$row->dossier.'&id='.$row->id.'&photo='.$row->img);?>">R&eacute;essayer</a><br/>
			
		<?
			if($row->dossier == 'experts'){
		?>
				<a href="<? echo JL::url('index.php?app=expert&action=edit&id='.$row->id); ?>">Retour &agrave; l'annonce de l'expert</a>
		<?
			}
		}
	}
?>

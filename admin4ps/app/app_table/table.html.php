<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class table_HTML {	
		
		// liste les $contenus
		public static function listerAll() {
			
			?>
			<script>
			function cancelsubmit(action) {
						
						var form = document.listForm;
						var ok = true;
						
						
						 if(action == 'Fermer') {
							if(!confirm('�tes-vous s�r de vouloir Fermer?')) {
								ok = false;
								
							}
						}
						
						if(ok) {
						
							document.location = "<?php echo SITE_URL_ADMIN; ?>"; 
						}
						
					}
			</script>
			<section class="panel">
                  <header class="panel-heading">
                     <h2>Tables</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
					<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
				</div>
				
			</div>
		</div>
			<div class="tableAdmin">
				<table cellpadding="0" cellspacing="0"class="table table-bordered table-striped table-condensed cf lister" style="text-align: center;">
					<tr>
						<th>Table</th>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=appel_media" title="Lister cette table">M&eacute;dias (Appels &agrave; t&eacute;moins)</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=fleur" title="Lister cette table">Fleurs</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_animaux" title="Lister cette table">Animaux</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_canton" title="Lister cette table">Cantons</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_cherche_relation" title="Lister cette table">Relations cherch&eacute;es</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_cheveux" title="Lister cette table">Couleurs de cheveux</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_cuisine" title="Lister cette table">Cuisines</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_film" title="Lister cette table">Films</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_fumer" title="Lister cette table">Fumeurs</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_garde" title="Lister cette table">Qui a la garde?</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_langue" title="Lister cette table">Langues</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_lecture" title="Lister cette table">Lectures</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_loisir" title="Lister cette table">Loisirs</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_me_marier" title="Lister cette table">Mariage?</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_musique" title="Lister cette table">Musiques</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_nationalite" title="Lister cette table">Nationalit&eacute;s</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_niveau_etude" title="Lister cette table">Niveaux d'&eacute;tudes</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_origine" title="Lister cette table">Origine</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_religion" title="Lister cette table">Religions</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_secteur_activite" title="Lister cette table">Secteurs d'activit&eacute;</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_signe_astrologique" title="Lister cette table">Signes astrologiques</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_silhouette" title="Lister cette table">Silhouettes</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_sortie" title="Lister cette table">Sorties</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_sport" title="Lister cette table">Sports</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_statut_marital" title="Lister cette table">Statuts maritals</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_style_coiffure" title="Lister cette table">Styles de coiffure</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_temperament" title="Lister cette table">Temp&eacute;rament</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_vie" title="Lister cette table">Styles de vie</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_vouloir_enfants" title="Lister cette table">Envie d'enfants?</a></td>
					</tr>
					<tr class="list">
						<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=profil_yeux" title="Lister cette table">Couleurs des yeux</a></td>
					</tr>
				</table>
			</div>
			</section>
			<?php 		}
		
		// liste les $contenus
		public static function lister(&$contenus, &$search, &$table) {
			
			$rayon 			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
			
			?>
			<script>
			function cancelsubmit(action) {
						
						var form = document.listForm;
						var ok = true;
						
						
						 if(action == 'Fermer') {
							if(!confirm('�tes-vous s�r de vouloir Fermer?')) {
								ok = false;
								
							}
						}
						
						if(ok) {
						
							document.location = "<?php echo SITE_URL_ADMIN; ?>/index.php?app=table"; 
						}
						
					}
			</script>
			<form name="listForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                     		<h2>Contenus</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
					</div>
				
				</div>
				</div>
				<div class="tableAdmin">
					<div class="filtre">
						<table class="form-group table col-md-5">
							<tr>
								<td><b>Recherche:</b></td>
								<td><input type="text" name="search_at_word" id="search_at_word" value="<?php echo makeSafe($search['word']); ?>" class="form-control searchInput" /></td>
								<td><a href="javascript:document.listForm.submit();" class="btn btn-info"" style="margin-left:15px;" />Rechercher</a></td>
							</tr>
						</table>
					</div>
					<?php if (is_array($contenus)) { ?>
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
						<tr>
							<th>Description</th>
							<th>Fran&ccedil;ais</th>
							<th>Allemand</th>
							<th>Anglais</th>
							<th align="center">Publi&eacute;</th>
						</tr>
						<?php 
						foreach($contenus as $contenu) { 
							JL::makeSafe($contenu);
							?>
							<tr class="list">
								<td><a href="<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=edit&table=<?php echo $table; ?>&id=<?php echo $contenu->id; ?>" title="Modifier ce contenu"><?php echo $contenu->description; ?></a></td>
								<td><?php echo $contenu->nom_fr; ?></td>
								<td><?php echo $contenu->nom_de; ?></td>
								<td><?php echo $contenu->nom_en; ?></td>
								<td align="center"><img src="images/<?php echo $contenu->published; ?>.png" /></td>
							</tr>
							<?php 						} 
					?>
					<tr>
							<td colspan="5">
								<b>Pages</b>:
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=table&action=list&table='.$table.'&search_at_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=table&action=list&table='.$table.'&search_at_page='.$i); ?>" title="Afficher la page <?php echo $i; ?>" <?php if($i == $search['page']) { ?>style="font-weight:bold;"<?php } ?>><?php echo $i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL_ADMIN.'/index.php?app=table&action=list&table='.$table.'&search_at_page='.$search['page_total']); ?>" title="Afficher la page <?php echo $search['page_total']; ?>">Fin</a><?php }?> <i>(<?php echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
					<?php 					} else { ?>
					<tr>
						<th>Aucun contenu ne correspond &agrave; votre recherche.</th>
					</tr>
						
				<?php } ?>
					</table>
				</div>
			<input type="hidden" name="search_at_page" value="1" />
			<input type="hidden" name="app" value="table" />
			<input type="hidden" name="action" value="list" />
			<input type="hidden" name="table" value="<?php echo $table;?>" />
				</section>
		</form>
			<?php 		}
		
		// affiche un $contenu
		public static function editer(&$contenu, &$messages) {
			
			if($contenu->table == "fleur"){
				JL::makeSafe($contenu, 'signification_fr,signification_de,signification_en');
			}else{
				JL::makeSafe($contenu);
			}
			
			include(SITE_PATH.'/fckeditor/fckeditor.php');
			?>
			<script>
			function cancelsubmit(action) {
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'Annuler') {
							if(!confirm('�tes-vous s�r de vouloir Annuler?')) {
								ok = false;
							}
						} 
						else if(action == 'Fermer') {
							if(!confirm('�tes-vous s�r de vouloir Fermer?')) {
								ok = false;
								
							}
						}
						
						if(ok) {
						
							document.location = "<?php echo SITE_URL_ADMIN; ?>/index.php?app=table&action=list&table=<?php echo $contenu->table;?>"; 
						}
						
					}
			</script>
			<script type="text/javascript" src="<?php echo SITE_URL; ?>/fckeditor/fckeditor.js"></script>
			
			<form name="editForm" action="<?php echo SITE_URL_ADMIN; ?>/index.php" method="post">
			<section class="panel">
                  <header class="panel-heading">
                     <h2>Contenu: <?php echo $contenu->id ? 'Editer' : 'Nouveau'; ?></h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:document.editForm.submit();" title="Sauver" class="btn btn-success">Sauver</a>
						<a href="javascript:cancelsubmit('Annuler')" title="Annuler" class="btn btn-success">Annuler</a>
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
					</div>	
				</div>
				</div>
				<?php if (is_array($messages)) { ?>
						<div class="messages">
							<?php JL::messages($messages); ?>
						</div>
						<br />
				<?php } ?>
				<div class="tableAdmin">
					<h3>Information</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Description:</td>
							<td><input type="text" name="description" maxlength="255" size="100" class="inputtext" value="<?php echo $contenu->description; ?>" /></td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Contenu <img width="20px;" src="<?php echo SITE_URL; ?>/parentsolo/images/grph_flags_fr_h20.jpg" alt="fr"></h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer" >
						<tr>
							<td class="key">Nom:</td>
							<td><input type="text" name="nom_fr" maxlength="255" size="100" class="inputtext" value="<?php echo $contenu->nom_fr; ?>" /></td>
						</tr>
					<?php 						if($contenu->table == "fleur"){
					?>
						<tr>
							<td class="key">Texte:</td>
							<td>
							<?php
								
								$oFCKeditor = new FCKeditor('signification_fr', '400', '571px') ;
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
								
								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
								$oFCKeditor->ToolbarSet			= 'Basic';
								
								$oFCKeditor->Value = $contenu->signification_fr;
								$oFCKeditor->Create() ;
								
							?>
							</td>
						</tr>
					<?php 						}
					?>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Contenu <img width="20px;" src="<?php echo SITE_URL; ?>/parentsolo/images/grph_flags_de_h20.jpg" alt="de"></h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						
						<tr>
							<td class="key">Nom:</td>
							<td><input type="text" name="nom_de" maxlength="255" size="100" class="inputtext" value="<?php echo $contenu->nom_de; ?>" /></td>
						</tr>
						<?php 						if($contenu->table == "fleur"){
					?>
						<tr>
							<td class="key">Texte:</td>
							<td>
							<?php
								
								$oFCKeditor = new FCKeditor('signification_de', '400', '571px') ;
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
								
								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
								$oFCKeditor->ToolbarSet			= 'Basic';
								
								$oFCKeditor->Value = $contenu->signification_de;
								$oFCKeditor->Create() ;
								
							?>
							</td>
						</tr>
					<?php 						}
					?>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Contenu <img width="20px;" src="<?php echo SITE_URL; ?>/parentsolo/images/grph_flags_en_h20.jpg" alt="en"></h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Nom:</td>
							<td><input type="text" name="nom_en" maxlength="255" size="100" class="inputtext" value="<?php echo $contenu->nom_en; ?>" /></td>
						</tr>
						<?php 						if($contenu->table == "fleur"){
					?>
						<tr>
							<td class="key">Texte:</td>
							<td>
							<?php
								
								$oFCKeditor = new FCKeditor('signification_en', '400', '571px') ;
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';
								
								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath . 'editor/skins/silver/' ;
								$oFCKeditor->ToolbarSet			= 'Basic';
								
								$oFCKeditor->Value = $contenu->signification_en;
								$oFCKeditor->Create() ;
								
							?>
							</td>
						</tr>
					<?php 						}
					?>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Publication</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key">Publi&eacute;:</td>
							<td><input type="radio" id="pu1" name="published" value="1" <?php if($contenu->published) { ?>checked<?php } ?> /> <label for="pu1">Oui</label>&nbsp;<input type="radio" id="pu0" name="published" value="0" <?php if(!$contenu->published) { ?>checked<?php } ?> /> <label for="pu0">Non</label></td>
						</tr>
					</tr>
				</table>
				</div>
				<input type="hidden" name="id" value="<?php echo $contenu->id; ?>" />
				<input type="hidden" name="table" value="<?php echo $contenu->table; ?>" />
				<input type="hidden" name="app" value="table" />
				<input type="hidden" name="action" value="save" />
			</section>
			</form>
			<?php 		}
		
	}
?>

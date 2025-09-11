<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class HTML_temoignage {	
		
		// liste les profils
		public static function temoignageLister(&$rows, &$search, &$lists, &$messages) {
		
			// variables
			$i 				= 0; // compteur de tr
			$td 			= 0; // compteur de td
			$tdParTr		= 4; // nombre de td par ligne
			$rayon 			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
			
			?>
				<script language="javascript" type="text/javascript">
					function submitform(action) {
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'supprimer') {
							if(!confirm('Voulez-vous vraiment supprimer les appels à témoins sélectionnés ?')) {
								ok = false;
							}
						} else if(action == 'desactiver') {
							if(!confirm('Voulez-vous vraiment désactiver les appels à témoins sélectionnés ?')) {
								ok = false;
							}
						} else if(action == 'activer') {
							if(!confirm('Voulez-vous vraiment activer les appels à témoins sélectionnés ?')) {
								ok = false;
							}
						}
						
						if(ok) {
							form.action.value = action;
							form.submit();
						}
						
					}
			function cancelsubmit(action) {
						
						var form = document.listForm;
						var ok = true;
						
						
						 if(action == 'Fermer') {
							if(!confirm('Êtes-vous sûr de vouloir Fermer?')) {
								ok = false;
								
							}
						}
						
						if(ok) {
						
							document.location = "<? echo SITE_URL_ADMIN; ?>"; 
						}
						
					}
					
			
				</script>
				
				<form name="listForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                    	<h2>T&eacute;moignages</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
						<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
					</div>
				  </div>	
				</div>
				
				<? if(count($messages)) { ?>
						<div class="messages">
							<? JL::messages($messages); ?>
						</div>
						<br />
				<? } ?>
				<div class="tableAdmin">
					<table class="table table-bordered table-striped table-condensed cf">
						<tr>
							<td><b>Recherche:</b></td>
							<td><input type="text" name="search_t_word" id="search_t_word" value="<? echo htmlentities($search['word']); ?>" class="searchInput" /></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><b>Tri par:</b></td>
							<td><? echo $lists['order']; ?></td>
							<td><b>Statut:</b></td>
							<td><? echo $lists['active']; ?></td>
						</tr>
						<tr>
							<td><b>Ordre:</b></td>
							<td><? echo $lists['ascdesc']; ?></td>
							<td></td>
							<td></td>
						<tr>
						<tr>
							<td colspan="4" align="right">
								<a href="javascript:document.listForm.submit();" class="bouton envoyer" >Rechercher</a>
							</td>
						</tr>
					</table>
							
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf lister">
						<? if(count($rows)) { ?>
						<tr>
							<th width="20px"></th>
							<th style="width:50px; text-align:center;">Statut</th>
							<th>Titre</th>
							<th>Date de cr&eacute;ation</th>
						</tr>
						<?
						foreach($rows as $row) {
						
							// htmlentities
							JL::makeSafe($row);
							
							?>
							<tr class="list">
								<td align="center"><input type="checkbox" name="id[]" value="<? echo $row->id; ?>" id="user_<? echo $row->id; ?>"></td>
								<td align="center"><img src="images/<? echo $row->active; ?>.png" alt="" /></td>
								<td>
									<a href="<? echo SITE_URL_ADMIN; ?>/index.php?app=temoignage&action=edit&id=<? echo $row->id; ?>" title="Modifier le t&eacute;moignage"><? echo $row->titre; ?></a><br />
									<i>par <b><? echo $row->username; ?></b></i>
								</td>
								<td><? echo date('d/m/Y à H:i:s', strtotime($row->date_add)); ?></td>
							</tr>
							<?
						}
						?>
					
						<tr>
							<td colspan="<? echo $tdParTr; ?>">
								<b>Pages</b>:
								<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=temoignage&search_t_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<? }?>
								<?
									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=temoignage&search_t_page='.$i); ?>" title="Afficher la page <? echo $i; ?>" <? if($i == $search['page']) { ?>class="displayActive"<? } ?>><? echo $i; ?></a>
									<?
									}
								?>
								<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=temoignage&search_t_page='.$search['page_total']); ?>" title="Afficher la page <? echo $search['page_total']; ?>">Fin</a><? }?> <i>(<? echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
					<? } else { ?>
						<tr>
							<th colspan="<? echo $tdParTr; ?>">Aucun t&eacute;moignage ne correspond &agrave; votre recherche.</th>
						</tr>
					<? } ?>
					</table>
				</div>
					<input type="hidden" name="search_t_page" value="1" />
					<input type="hidden" name="app" value="temoignage" />
					<input type="hidden" name="action" value="" />
				</section>
				</form>
			<?
		}
		
		
		// formlaire d'édition d'un profil
		public static function temoignageEditer(&$row, &$messages) {
			
			// htmlentities
			JL::makeSafe($row);
			
			?>
			<script>
			function cancelsubmit(action) {
						
						var form = document.listForm;
						var ok = true;
						
						if(action == 'Annuler') {
							if(!confirm('Êtes-vous sûr de vouloir Annuler?')) {
								ok = false;
							}
						} 
						else if(action == 'Fermer') {
							if(!confirm('Êtes-vous sûr de vouloir Fermer?')) {
								ok = false;
								
							}
						}
						
						if(ok) {
						
							document.location = "<? echo SITE_URL_ADMIN; ?>/index.php?app=temoignage"; 
						}
						
					}
				</script>
			<form name="editForm" action="<? echo SITE_URL_ADMIN; ?>/index.php" method="post">
				<section class="panel">
                  <header class="panel-heading">
                     	<h2>T&eacute;moignage</h2>
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
				<? // messages d'erreurs
				if(count($messages)) { ?>
					<div class="messages">
						<? JL::messages($messages); ?>
					</div>
					<br />
				<? } ?>
				<div class="tableAdmin">
					<h3>Information</h3>
					<br />
					<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped table-condensed cf editer">
						<tr>
							<td class="key"><label for="titre">Titre:</label></td>
							<td><input type="text" id="titre" class="msgtxt" name="titre" maxlength="150" value="<? echo $row->titre; ?>"></td>
						</tr>
						<tr>
							<td class="key"><label for="texte">Texte:</label></td>
							<td>
								<textarea name="texte" id="texte" rows="10" cols="72"><? echo $row->texte; ?></textarea>
							</td>
						</tr>
					</table>
				</div>
				<br />
				<div class="tableAdmin">
					<h3>Administration</h3>
					<br />
					<table class="table table-bordered table-striped table-condensed cf editer" cellpadding="0" cellspacing="0">
						<tr>
							<td class="key"><label for="statut">Statut:</label></td>
							<td>
								<div class="statut statut1"><input type="radio" name="active" value="1" id="active1" <? if($row->active == 1) { ?>checked="true"<? } ?> /> <label for="active1">Publi&eacute;</label></div>
								<div class="statut statut0"><input type="radio" name="active" value="0" id="active0" <? if($row->active == 0) { ?>checked="true"<? } ?> /> <label for="active0">Refus&eacute;</label></div>
								<div class="statut statut2"><input type="radio" name="active" value="2" id="active2" <? if($row->active == 2) { ?>checked="true"<? } ?> /> <label for="active2">En attente</label></div>
								<span class="attention">
									<b>Attention !</b><br />
									Un email sera envoy&eacute; &agrave; l'auteur si le statut<br />
									passe de &quot;En attente&quot; &agrave; &quot;Publi&eacute;&quot; ou &quot;Refus&eacute;&quot;
								</span>
							</td>
						</tr>
						<tr>
							<td class="key"><label for="motif">Message:</label></td>
							<td>
								<textarea name="motif" id="motif" rows="10" cols="72"><? echo $row->motif; ?></textarea><br />
								<i>Vous pouvez joindre un message &agrave; l'email automatiquement envoy&eacute;<br />
								en cas de refus (ex: motif du refus) ou de validation.</i>
							</td>
						</tr>
					</table>
				</div>
				<input type="hidden" name="id" value="<? echo $row->id; ?>" />
				<input type="hidden" name="app" value="temoignage" />
				<input type="hidden" name="action" value="save" />
				</section>
			</form>
			<?
		}
		
	}
?>

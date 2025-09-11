<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	class HTML_appel_a_temoins {
		
		// affichage des messages système
		function messages(&$messages) {
			
			// s'il y a des messages à afficher
			if(count($messages)) {
			?>
				<h2>Messages</h2>
				<div class="messages">
				<?
					// affiche les messages
					JL::messages($messages);
				?>
				</div>
			<? 
			}
			
		}
		
		
		// menu de l'appel à témoins
		function appel_a_temoinsMenu($h1Force = '') {
			global $action;
			
			if($h1Force) {
				$h1 = $h1Force;
			} else {
			
				switch($action) {
				
					case 'new':
					case 'save':
						$h1 = 'Lancer un appel &agrave; t&eacute;moins';
					break;
					
					case 'info':
						$h1 = 'Informations appels &agrave; t&eacute;moins';
					break;
					
					case 'list':
					default:
						$h1 = 'Liste des appels &agrave; t&eacute;moins';
					break;
				
				}
			
			}
			
			?>
				<table class="profil_menu"><tr>
					<td <? if(in_array($action, array('list','read'))) { ?>class="active"<? } ?>><a href="<? echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>" title="Liste des appels &agrave; t&eacute;moins propos&eacute;s">Appels &agrave; t&eacute;moins</a></td>
					<td <? if($action == 'info') { ?>class="active"<? } ?>><a href="<? echo JL::url('index.php?app=appel_a_temoins&action=info'); ?>" title="Informations concernant les appels &agrave; t&eacute;moins">Informations</a></td>
					<td <? if(in_array($action, array('new','save'))) { ?>class="active"<? } ?>><a href="<? echo JL::url('index.php?app=appel_a_temoins&action=new'); ?>" title="Lancez votre appel &agrave; t&eacute;moins">Lancer un appel &agrave; t&eacute;moins</a></td>
					<td style="width:40%;"> </td>
				</tr></table>
				<h1 class="aat"><? echo $h1; ?></h1>
			<?
		
		}
		
		
		// affiche la liste des appels à témoins
		function appel_a_temoinsList(&$rows, &$messages, &$search) {
			
			// variables
			$rayon			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
						
			?>
			<div class="app_body appel_a_temoins">
			<?
				
				// affichage du menu
				HTML_appel_a_temoins::appel_a_temoinsMenu();
				
				// affichage des messages
				HTML_appel_a_temoins::messages($messages);
				

				// liste les messages
				if(is_array($rows) && count($rows)) {
					foreach($rows as $row) {
					
						// limitation de la description
						$annonceLimite	= 470;
						if(strlen($row->annonce) > $annonceLimite) {
							$row->annonce = substr($row->annonce, 0, $annonceLimite).'...';
						}
						
					
						// htmlentities
						JL::makeSafe($row);
						
						
						?>
							<div class="top">&nbsp;</div><div class="center">
								
								<? if(is_file('images/appel-a-temoins/'.$row->id.'.jpg')) { ?>
									<a href="<? echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$row->id); ?>" title="Lire l'appel &agrave; t&eacute;moins pour parents solos"><img src="<? echo SITE_URL.'/images/appel-a-temoins/'.$row->id.'.jpg'; ?>" alt="" class="AATlogo" /></a>
								<? } ?>
								
								<h3><a href="<? echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$row->id); ?>" title="Lire l'appel &agrave; t&eacute;moins pour parents solos"><span><? echo $row->media; ?>:</span> <? echo $row->titre; ?></a></h3>
								<? echo $row->annonce; ?>
								<a href="<? echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$row->id); ?>" title="Lire l'appel &agrave; t&eacute;moins pour parents solos" class="more">Lire l'annonce compl&egrave;te &raquo;</a>
								
								<? if(is_file('images/appel-a-temoins/'.$row->id.'.jpg')) { ?>
									<div class="clear">&nbsp;</div>
								<? } ?>
							</div>
							<div class="bottom">&nbsp;</div>
						<?
					}
					
					?>
					<table class="searchnavbar" cellpadding="0" cellspacing="0">
						<tr>
							<td class="left">
								<? // page précédente
								if($search['page'] > 1) { ?>
									<a href="<? echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&action=list&page='.($search['page']-1)); ?>" class="bouton step_previous" title="Page pr&eacute;c&eacute;dente">&laquo; Page pr&eacute;c&eacute;dente</a>
								<? } ?>
							</td>
							<td class="center">
								<span class="orange">Pages</span>:
								<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&action=list&page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<? }?>
								<?
									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<? echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&action=list&page='.$i); ?>" title="Afficher la page <? echo $i; ?>" <? if($i == $search['page']) { ?>class="active"<? } ?>><? echo $i; ?></a>
									<?
									}
								?>
								<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&action=list&page='.$search['page_total']); ?>" title="Afficher la page <? echo $search['page_total']; ?>">Fin</a><? }?> <i>(<? echo $search['result_total']; ?> appel<? echo $search['result_total'] > 1 ? 's' : ''; ?>)</i>
							</td>
							<td class="right">
								<? // page suivante
								if($search['page'] < $search['page_total']) { ?>
									<a href="<? echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&action=list&page='.($search['page']+1)); ?>" class="bouton step_next" title="Page suivante">&raquo; Page suivante</a>
								<? } ?>
							</td>
						</tr>
					</table>
					
				<?
				} else {
				?>
					
					<div class="top">&nbsp;</div>
					<div class="center">
						Aucun appel &agrave; t&eacute;moins n'a encore &eacute;t&eacute; publi&eacute; !
					</div>
					<div class="bottom">&nbsp;</div>
					
				<?
				}
			?>
			
				<br />
				<br />
				<a href="<? echo JL::url('index.php'); ?>" class="bouton return_home" title="Retour &agrave; l'accueil de ParentSolo.ch">Retour &agrave; l'accueil</a>
			</div><? // fin app_body ?>
		
			<?
		
			// colonne de gauche
			JL::loadMod('profil_panel');
			
		?>
		<div class="clear"> </div>
		<?
		}
		
		
		// formulaire de rédaction d'un appel
		function appel_a_temoinsWrite(&$row, &$messages, &$list) {
		
			// htmlentities
			JL::makeSafe($row);
			
			?>
			
			<div class="app_body">
			
			<?
			
				// affichage du menu
				HTML_appel_a_temoins::appel_a_temoinsMenu();
				
			?>
			
			<form action="index.php" name="appel_a_temoins" method="post" enctype="multipart/form-data">
				
				<p>
					&quot;Vous &ecirc;tes un institutionnel de type m&eacute;dia presse, radio ou t&eacute;l&eacute; ou un particulier, vous d&eacute;sirez lancer un appel &agrave; t&eacute;moin ?<br />
					<br />
					Profitez de notre site pour le faire en remplissant les champs suivants.&quot;<br />
					<br />
					Votre appel &agrave; t&eacute;moins sera v&eacute;rifi&eacute; par un mod&eacute;rateur de ParentSolo.ch.<br />
					Vous serez averti(e) &agrave; l'adresse email indiqu&eacute;e de la publication ou non de votre appel &agrave; t&eacute;moins.<br />
					<br />
					<i>Les champs marqu&eacute;s d'un ast&eacute;risque * sont obligatoires.</i>
				</p>
				
				<?
				
					// affichage des messages
					HTML_appel_a_temoins::messages($messages);
					
				?>
				
				<h2>Votre annonce</h2>
				<table class="message_table appel" cellpadding="0" cellspacing="0">
					<tr>
						<td class="key"><label for="media_id">Type de M&eacute;dia:</label></td>
						<td><? echo $list['media_id']; ?></td>
					</tr>
					<tr>
						<td class="key"><label for="titre">Titre:*</label></td>
						<td><input type="text" id="titre" class="msgtxt" name="titre" maxlength="150" value="<? echo $row->titre; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="annonce">Annonce:*</label></td>
						<td>
							<textarea name="annonce" id="annonce" class="msgtxt"><? echo $row->annonce; ?></textarea>
						</td>
					</tr>
					<tr>
						<td class="key"><label for="date_limite">Date limite:</label></td>
						<td><input type="text" id="date_limite" class="msgtxt" name="date_limite" maxlength="50" value="<? echo $row->date_limite; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="date_diffusion">Date de publication:</label></td>
						<td><input type="text" id="date_diffusion" class="msgtxt" name="date_diffusion" maxlength="50" value="<? echo $row->date_diffusion; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="file_logo">Logo:</label></td>
						<td>
							<input type="file" id="file_logo" name="file_logo" /><br />
							<i>(GIF, PNG et JPG uniquement)</i>
						</td>
					</tr>
				</table>
				
				<h2>Vos coordonn&eacute;es</h2>
				<table class="message_table appel" cellpadding="0" cellspacing="0">
					<tr>
						<td class="key"><label for="nom">Nom:*</label></td>
						<td><input type="text" id="nom" class="msgtxt" name="nom" maxlength="50" value="<? echo $row->nom; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="prenom">Pr&eacute;nom:*</label></td>
						<td><input type="text" id="prenom" class="msgtxt" name="prenom" maxlength="50" value="<? echo $row->prenom; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="telephone">Telephone:*</label></td>
						<td><input type="text" id="telephone" class="msgtxt" name="telephone" maxlength="50" value="<? echo $row->telephone; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="adresse">Adresse:</label></td>
						<td>
							<textarea name="adresse" class="msgtxt" style="height:50px;"><? echo $row->adresse; ?></textarea>
						</td>
					</tr>
					<tr>
						<td class="key"><label for="email">Email:*</label></td>
						<td><input type="text" id="email" class="msgtxt" name="email" maxlength="50" value="<? echo $row->email; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="email2">Email:*<br /><i>confirmation</i></label></td>
						<td><input type="text" id="email2" class="msgtxt" name="email2" maxlength="50" value="<? echo $row->email2; ?>"></td>
					</tr>
				</table>
					
					
					
				<h2>Code de s&eacute;curit&eacute;</h2>
				<table class="message_table appel" cellpadding="0" cellspacing="0">
					<tr>
						<td class="key"> </td>
						<td><u><b>Combien y a-t-il de fleurs ci-dessous ?</b></u><br /><br />
						<?
						for($i=0;$i<$list['captcha'];$i++){
						?>
							<img src="<? echo SITE_URL; ?>/parentsolo/images/flower.jpg" alt="Fleur" align="left" />
						<?
						}
						?>
						&nbsp;=&nbsp;<input type="text" name="codesecurite" id="codesecurite" value="" maxlength="1" />
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<table cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<a href="javascript:if(confirm('Voulez-vous vraiment annuler la r&eacute;daction de cet appel ?')){document.location='<? echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>';}" class="bouton annuler">Annuler</a>
								</td>
								<td>
									<a href="javascript:document.appel_a_temoins.submit();" class="bouton envoyer">Envoyer</a>
								</td>
							</tr>
							</table>
						</td>
					</tr>
				</table>
				
				<input type="hidden" name="app" value="appel_a_temoins" />
				<input type="hidden" name="action" value="save" />
			</form>
			</div><? // fin app_body ?>
		
			<?
		
			// colonne de gauche
			JL::loadMod('profil_panel');
			
		?>
		<div class="clear"> </div>
		<?
		}
		
		
		// affichage d'un appel à témoins
		function appel_a_temoinsRead(&$row) {
		
			JL::makeSafe($row);
			
			?>
			<div class="app_body appel_a_temoins">
			<?
				
				// affichage du menu
				HTML_appel_a_temoins::appel_a_temoinsMenu($row->titre);
				
				?>
				<div class="appel_annonce">
					<? if(is_file('images/appel-a-temoins/'.$row->id.'.jpg')) { ?>
						<img src="<? echo SITE_URL.'/images/appel-a-temoins/'.$row->id.'.jpg' ?>" alt="" class="AATlogo" />
					<? } ?>
					<? echo nl2br($row->annonce); ?>
					<div class="clear">&nbsp;</div>
				</div>
				
				<div class="top">&nbsp;</div><div class="center">
				
					<span class="infos">Informations compl&eacute;mentaires:</span><br />
					<br />
					<? if($row->date_limite) { ?><b>Date de l'appel:</b> <? echo date('d/m/Y', strtotime($row->date_add)); ?><br /><? } ?>
					<? if($row->date_limite) { ?><b>Date limite d'inscription:</b> <? echo $row->date_limite; ?><br /><? } ?>
					<? if($row->date_diffusion) { ?><b>Date de diffusion:</b> <? echo $row->date_diffusion; ?><br /><? } ?>
					<br />
				
					<span class="infos">Pour plus d'informations, veuillez contacter:</span><br />
					<br />
					<? echo $row->prenom.' '.$row->nom; ?><br />
					<? if($row->adresse) nl2br($row->adresse).'<br />'; ?>
					<br />
					<b>Email:</b> <a href="mailto:<? echo $row->email; ?>" title="Contacter <? echo $row->prenom.' '.$row->nom; ?> par email"><? echo $row->email; ?></a><br />
					<b>T&eacute;l&eacute;phone:</b> <? echo $row->telephone; ?>
					
				</div>
				<div class="bottom">&nbsp;</div>

				<a href="<? echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>" class="bouton page_previous">&laquo; Page pr&eacute;c&eacute;dente</a>
			</div><? // fin app_body ?>
			
			<?
		
			// colonne de gauche
			JL::loadMod('profil_panel');
			
		?>
		<div class="clear"> </div>
		<?
		}
		
		
		// page d'info
		function appel_a_temoinsInfo(&$row) {
			
			// htmlentities
			JL::makeSafe($row, 'texte');
			
			?>
			<div class="app_body">
				<?
					
					// affichage du menu
					HTML_appel_a_temoins::appel_a_temoinsMenu($row->titre);
					
				?>
					
				<div class="contenu">
					<? echo $row->texte; ?>
					
				</div>
			
				<a href="<? echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>" class="bouton page_previous">&laquo; Page pr&eacute;c&eacute;dente</a>
				
			</div><? // fin app_body ?>
			
			<?
		
			// colonne de gauche
			JL::loadMod('profil_panel');
			
		?>
		<div class="clear"> </div>
		<?
		}
		
	}
?>
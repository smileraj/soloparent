<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	class HTML_appel_a_temoins {
		
		// affichage des messages syst�me
		function messages(&$messages) {
			
			// s'il y a des messages � afficher
			if (is_array($messages)) {
			?>
				<h2>Messages</h2>
				<div class="messages">
				<?php 					// affiche les messages
					JL::messages($messages);
				?>
				</div>
			<?php 
			}
			
		}
		
		
		// menu de l'appel � t�moins
		function appel_a_temoinsMenu($h1Force = '') {
			global $action;
			
			if($h1Force) {
				$h1 = $h1Force;
			} else {
			
				$h1 = match ($action) {
                    'new', 'save' => 'Lancer un appel &agrave; t&eacute;moins',
                    'info' => 'Informations appels &agrave; t&eacute;moins',
                    default => 'Liste des appels &agrave; t&eacute;moins',
                };
			
			}
			
			?>
				<table class="profil_menu"><tr>
					<td <?php if(in_array($action, ['list','read'])) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>" title="Liste des appels &agrave; t&eacute;moins propos&eacute;s">Appels &agrave; t&eacute;moins</a></td>
					<td <?php if($action == 'info') { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=info'); ?>" title="Informations concernant les appels &agrave; t&eacute;moins">Informations</a></td>
					<td <?php if(in_array($action, ['new','save'])) { ?>class="active"<?php } ?>><a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=new'); ?>" title="Lancez votre appel &agrave; t&eacute;moins">Lancer un appel &agrave; t&eacute;moins</a></td>
					<td style="width:40%;"> </td>
				</tr></table>
				<h1 class="aat"><?php echo $h1; ?></h1>
			<?php 		
		}
		
		
		// affiche la liste des appels � t�moins
		function appel_a_temoinsList(&$rows, &$messages, &$search) {
			
			// variables
			$rayon			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
						
			?>
			<div class="app_body appel_a_temoins">
			<?php 				
				// affichage du menu
				HTML_appel_a_temoins::appel_a_temoinsMenu();
				
				// affichage des messages
				HTML_appel_a_temoins::messages($messages);
				

				// liste les messages
				if(is_array($rows) && count($rows)) {
					foreach($rows as $row) {
					
						// limitation de la description
						$annonceLimite	= 470;
						if(strlen((string) $row->annonce) > $annonceLimite) {
							$row->annonce = substr((string) $row->annonce, 0, $annonceLimite).'...';
						}
						
					
						// htmlentities
						JL::makeSafe($row);
						
						
						?>
							<div class="top">&nbsp;</div><div class="center">
								
								<?php if(is_file('images/appel-a-temoins/'.$row->id.'.jpg')) { ?>
									<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$row->id); ?>" title="Lire l'appel &agrave; t&eacute;moins pour parents solos"><img src="<?php echo SITE_URL.'/images/appel-a-temoins/'.$row->id.'.jpg'; ?>" alt="" class="AATlogo" /></a>
								<?php } ?>
								
								<h3><a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$row->id); ?>" title="Lire l'appel &agrave; t&eacute;moins pour parents solos"><span><?php echo $row->media; ?>:</span> <?php echo $row->titre; ?></a></h3>
								<?php echo $row->annonce; ?>
								<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=read&id='.$row->id); ?>" title="Lire l'appel &agrave; t&eacute;moins pour parents solos" class="more">Lire l'annonce compl&egrave;te &raquo;</a>
								
								<?php if(is_file('images/appel-a-temoins/'.$row->id.'.jpg')) { ?>
									<div class="clear">&nbsp;</div>
								<?php } ?>
							</div>
							<div class="bottom">&nbsp;</div>
						<?php 					}
					
					?>
					<table class="searchnavbar" cellpadding="0" cellspacing="0">
						<tr>
							<td class="left">
								<?php // page pr�c�dente
								if($search['page'] > 1) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&action=list&page='.($search['page']-1)); ?>" class="bouton step_previous" title="Page pr&eacute;c&eacute;dente">&laquo; Page pr&eacute;c&eacute;dente</a>
								<?php } ?>
							</td>
							<td class="center">
								<span class="orange">Pages</span>:
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&action=list&page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&action=list&page='.$i); ?>" title="Afficher la page <?php echo $i; ?>" <?php if($i == $search['page']) { ?>class="active"<?php } ?>><?php echo $i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $search['page_total']) { ?> ... <a href="<?php echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&action=list&page='.$search['page_total']); ?>" title="Afficher la page <?php echo $search['page_total']; ?>">Fin</a><?php }?> <i>(<?php echo $search['result_total']; ?> appel<?php echo $search['result_total'] > 1 ? 's' : ''; ?>)</i>
							</td>
							<td class="right">
								<?php // page suivante
								if($search['page'] < $search['page_total']) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=appel_a_temoins&action=list&page='.($search['page']+1)); ?>" class="bouton step_next" title="Page suivante">&raquo; Page suivante</a>
								<?php } ?>
							</td>
						</tr>
					</table>
					
				<?php 				} else {
				?>
					
					<div class="top">&nbsp;</div>
					<div class="center">
						Aucun appel &agrave; t&eacute;moins n'a encore &eacute;t&eacute; publi&eacute; !
					</div>
					<div class="bottom">&nbsp;</div>
					
				<?php 				}
			?>
			
				<br />
				<br />
				<a href="<?php echo JL::url('index.php'); ?>" class="bouton return_home" title="Retour &agrave; l'accueil de solocircl.com">Retour &agrave; l'accueil</a>
			</div><?php // fin app_body ?>
		
			<?php 		
			// colonne de gauche
			JL::loadMod('profil_panel');
			
		?>
		<div class="clear"> </div>
		<?php 		}
		
		
		// formulaire de r�daction d'un appel
		function appel_a_temoinsWrite(&$row, &$messages, &$list) {
		
			// htmlentities
			JL::makeSafe($row);
			
			?>
			
			<div class="app_body">
			
			<?php 			
				// affichage du menu
				HTML_appel_a_temoins::appel_a_temoinsMenu();
				
			?>
			
			<form action="index.php" name="appel_a_temoins" method="post" enctype="multipart/form-data">
				
				<p>
					&quot;Vous &ecirc;tes un institutionnel de type m&eacute;dia presse, radio ou t&eacute;l&eacute; ou un particulier, vous d&eacute;sirez lancer un appel &agrave; t&eacute;moin ?<br />
					<br />
					Profitez de notre site pour le faire en remplissant les champs suivants.&quot;<br />
					<br />
					Votre appel &agrave; t&eacute;moins sera v&eacute;rifi&eacute; par un mod&eacute;rateur de solocircl.com.<br />
					Vous serez averti(e) &agrave; l'adresse email indiqu&eacute;e de la publication ou non de votre appel &agrave; t&eacute;moins.<br />
					<br />
					<i>Les champs marqu&eacute;s d'un ast&eacute;risque * sont obligatoires.</i>
				</p>
				
				<?php 				
					// affichage des messages
					HTML_appel_a_temoins::messages($messages);
					
				?>
				
				<h2>Votre annonce</h2>
				<table class="message_table appel" cellpadding="0" cellspacing="0">
					<tr>
						<td class="key"><label for="media_id">Type de M&eacute;dia:</label></td>
						<td><?php echo $list['media_id']; ?></td>
					</tr>
					<tr>
						<td class="key"><label for="titre">Titre:*</label></td>
						<td><input type="text" id="titre" class="msgtxt" name="titre" maxlength="150" value="<?php echo $row->titre; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="annonce">Annonce:*</label></td>
						<td>
							<textarea name="annonce" id="annonce" class="msgtxt"><?php echo $row->annonce; ?></textarea>
						</td>
					</tr>
					<tr>
						<td class="key"><label for="date_limite">Date limite:</label></td>
						<td><input type="text" id="date_limite" class="msgtxt" name="date_limite" maxlength="50" value="<?php echo $row->date_limite; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="date_diffusion">Date de publication:</label></td>
						<td><input type="text" id="date_diffusion" class="msgtxt" name="date_diffusion" maxlength="50" value="<?php echo $row->date_diffusion; ?>"></td>
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
						<td><input type="text" id="nom" class="msgtxt" name="nom" maxlength="50" value="<?php echo $row->nom; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="prenom">Pr&eacute;nom:*</label></td>
						<td><input type="text" id="prenom" class="msgtxt" name="prenom" maxlength="50" value="<?php echo $row->prenom; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="telephone">Telephone:*</label></td>
						<td><input type="text" id="telephone" class="msgtxt" name="telephone" maxlength="50" value="<?php echo $row->telephone; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="adresse">Adresse:</label></td>
						<td>
							<textarea name="adresse" class="msgtxt" style="height:50px;"><?php echo $row->adresse; ?></textarea>
						</td>
					</tr>
					<tr>
						<td class="key"><label for="email">Email:*</label></td>
						<td><input type="text" id="email" class="msgtxt" name="email" maxlength="50" value="<?php echo $row->email; ?>"></td>
					</tr>
					<tr>
						<td class="key"><label for="email2">Email:*<br /><i>confirmation</i></label></td>
						<td><input type="text" id="email2" class="msgtxt" name="email2" maxlength="50" value="<?php echo $row->email2; ?>"></td>
					</tr>
				</table>
					
					
					
				<h2>Code de s&eacute;curit&eacute;</h2>
				<table class="message_table appel" cellpadding="0" cellspacing="0">
					<tr>
						<td class="key"> </td>
						<td><u><b>Combien y a-t-il de fleurs ci-dessous ?</b></u><br /><br />
						<?php 						for($i=0;$i<$list['captcha'];$i++){
						?>
							<img src="<?php echo SITE_URL; ?>/parentsolo/images/flower.jpg" alt="Fleur" align="left" />
						<?php 						}
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
									<a href="javascript:if(confirm('Voulez-vous vraiment annuler la r&eacute;daction de cet appel ?')){document.location='<?php echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>';}" class="bouton annuler">Annuler</a>
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
			</div><?php // fin app_body ?>
		
			<?php 		
			// colonne de gauche
			JL::loadMod('profil_panel');
			
		?>
		<div class="clear"> </div>
		<?php 		}
		
		
		// affichage d'un appel � t�moins
		function appel_a_temoinsRead(&$row) {
		
			JL::makeSafe($row);
			
			?>
			<div class="app_body appel_a_temoins">
			<?php 				
				// affichage du menu
				HTML_appel_a_temoins::appel_a_temoinsMenu($row->titre);
				
				?>
				<div class="appel_annonce">
					<?php if(is_file('images/appel-a-temoins/'.$row->id.'.jpg')) { ?>
						<img src="<?php echo SITE_URL.'/images/appel-a-temoins/'.$row->id.'.jpg' ?>" alt="" class="AATlogo" />
					<?php } ?>
					<?php echo nl2br((string) $row->annonce); ?>
					<div class="clear">&nbsp;</div>
				</div>
				
				<div class="top">&nbsp;</div><div class="center">
				
					<span class="infos">Informations compl&eacute;mentaires:</span><br />
					<br />
					<?php if($row->date_limite) { ?><b>Date de l'appel:</b> <?php echo date('d/m/Y', strtotime((string) $row->date_add)); ?><br /><?php } ?>
					<?php if($row->date_limite) { ?><b>Date limite d'inscription:</b> <?php echo $row->date_limite; ?><br /><?php } ?>
					<?php if($row->date_diffusion) { ?><b>Date de diffusion:</b> <?php echo $row->date_diffusion; ?><br /><?php } ?>
					<br />
				
					<span class="infos">Pour plus d'informations, veuillez contacter:</span><br />
					<br />
					<?php echo $row->prenom.' '.$row->nom; ?><br />
					<?php if($row->adresse) nl2br((string) $row->adresse).'<br />'; ?>
					<br />
					<b>Email:</b> <a href="mailto:<?php echo $row->email; ?>" title="Contacter <?php echo $row->prenom.' '.$row->nom; ?> par email"><?php echo $row->email; ?></a><br />
					<b>T&eacute;l&eacute;phone:</b> <?php echo $row->telephone; ?>
					
				</div>
				<div class="bottom">&nbsp;</div>

				<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>" class="bouton page_previous">&laquo; Page pr&eacute;c&eacute;dente</a>
			</div><?php // fin app_body ?>
			
			<?php 		
			// colonne de gauche
			JL::loadMod('profil_panel');
			
		?>
		<div class="clear"> </div>
		<?php 		}
		
		
		// page d'info
		function appel_a_temoinsInfo(&$row) {
			
			// htmlentities
			JL::makeSafe($row, 'texte');
			
			?>
			<div class="app_body">
				<?php 					
					// affichage du menu
					HTML_appel_a_temoins::appel_a_temoinsMenu($row->titre);
					
				?>
					
				<div class="contenu">
					<?php echo $row->texte; ?>
					
				</div>
			
				<a href="<?php echo JL::url('index.php?app=appel_a_temoins&action=list'); ?>" class="bouton page_previous">&laquo; Page pr&eacute;c&eacute;dente</a>
				
			</div><?php // fin app_body ?>
			
			<?php 		
			// colonne de gauche
			JL::loadMod('profil_panel');
			
		?>
		<div class="clear"> </div>
		<?php 		}
		
	}
?>
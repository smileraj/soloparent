<?php

	// s�curit�
	defined('JL') or die('Error 401');

	class HTML_inviter {

		// affichage des messages syst�me
		function messages(&$messages) {
			global $langue;
			include("lang/app_inviter.".$_GET['lang'].".php");

			// s'il y a des messages � afficher
			if (is_array($messages)) {
			?>
				<h2 class="messages"><?php echo $lang_inviter["MessagesParentsolo"];?></h2>
				<div class="messages">
				<?php 					// affiche les messages
					JL::messages($messages);
				?>
				</div>
				<br />
			<?php 			}

		}

		function parrainage(&$data, &$row, $messages = array()) {
			global $langue;
			include("lang/app_inviter.".$_GET['lang'].".php");
			global $user;

			JL::makeSafe($row);

			?>
			
			<h2 class="barre"><?php echo $data->titre; ?></h2>
			<div class="texte_explicatif">
				<?php echo $data->texte; ?>
			</div>
			<br />
			<?php 					// affichage des messages
					HTML_inviter::messages($messages);

				?>

			<h3 class="form"><?php echo $lang_inviter["ParrainezVosAmis"];?></h3>
			<form action="index.php<?php echo '?'.$langue;?>" name="parrainage" method="post">
				<table class="table_form" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td class="key" colspan="2"><h4><?php echo $lang_inviter["EmailsDeVosAmis"];?></h4></td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="email1"><?php echo $lang_inviter["Email"];?> 1</label></td>
						<td>
							<input type="text" name="email1" id="email1" value="<?php echo $row->email1; ?>">
						</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="email2"><?php echo $lang_inviter["Email"];?> 2</label></td>
						<td>
							<input type="text" name="email2" id="email2" value="<?php echo $row->email2; ?>">
						</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="email3"><?php echo $lang_inviter["Email"];?> 3</label></td>
						<td>
							<input type="text" name="email3" id="email3" value="<?php echo $row->email3; ?>">
						</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="email4"><?php echo $lang_inviter["Email"];?> 4</label></td>
						<td>
							<input type="text" name="email4" id="email4" value="<?php echo $row->email4; ?>">
						</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="email5"><?php echo $lang_inviter["Email"];?> 5</label></td>
						<td>
							<input type="text" name="email5" id="email5" value="<?php echo $row->email5; ?>">
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td class="key" colspan="2"><h4><?php echo $lang_inviter["MessagePersonnel"];?></h4></td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="message"><?php echo $lang_inviter["VotreMessage"];?></label></td>
						<td>
							<textarea name="message" id="message"><?php echo $row->message; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td></td>
						<td align="right">
							<a href="javascript:document.parrainage.submit();" class="bouton envoyer" style="float:none;"><?php echo $lang_inviter["Envoyer"];?></a>
						</td>
					</tr>
				</table>
				<input type="hidden" name="app" value="inviter" />
				<input type="hidden" name="action" value="parrainagesubmit" />
			</form>
			<?php 
		}

	
		function conseiller(&$data, &$row, $messages = array()) {
			global $langue;
			include("lang/app_inviter.".$_GET['lang'].".php");
			global $user;

			JL::makeSafe($row);

			?>
			
			<h2 class="barre"><?php echo $data->titre; ?></h2>
			<div class="texte_explicatif">
				<?php echo $data->texte; ?>
			</div>
			<br />
		<?php 			// affichage des messages
			HTML_inviter::messages($messages);

		?>
			<h3 class="form"><?php echo $lang_inviter["ConseillezSiteAmis"];?></h3>
			<form action="index.php<?php echo '?'.$langue;?>" name="conseillez_site" method="post">
				<table class="table_form" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td class="key" colspan="2"><h4><?php echo $lang_inviter["VosCoordonnees"];?></h4></td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="nom"><?php echo $lang_inviter["Nom"];?></label></td>
						<td>
							<input type="text" name="nom" id="nom" value="<?php echo $row->nom; ?>">
						</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="prenom"><?php echo $lang_inviter["Prenom"];?></label></td>
						<td>
							<input type="text" name="prenom" id="prenom" value="<?php echo $row->prenom; ?>">
						</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="email"><?php echo $lang_inviter["Email"];?></label></td>
						<td>
							<input type="text" name="email" id="email" value="<?php echo $row->email; ?>">
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td class="key" colspan="2"><h4><?php echo $lang_inviter["EmailsDeVosAmis"];?></h4></td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="email1"><?php echo $lang_inviter["Email"];?> 1</label></td>
						<td>
							<input type="text" name="email1" id="email1" value="<?php echo $row->email1; ?>">
						</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="email2"><?php echo $lang_inviter["Email"];?> 2</label></td>
						<td>
							<input type="text" name="email2" id="email2" value="<?php echo $row->email2; ?>">
						</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="email3"><?php echo $lang_inviter["Email"];?> 3</label></td>
						<td>
							<input type="text" name="email3" id="email3" value="<?php echo $row->email3; ?>">
						</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="email4"><?php echo $lang_inviter["Email"];?> 4</label></td>
						<td>
							<input type="text" name="email4" id="email4" value="<?php echo $row->email4; ?>">
						</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="email5"><?php echo $lang_inviter["Email"];?> 5</label></td>
						<td>
							<input type="text" name="email5" id="email5" value="<?php echo $row->email5; ?>">
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td class="key" colspan="2"><h4><?php echo $lang_inviter["MessagePersonnel"];?></h4></td>
					</tr>
					<tr>
						<td class="key" valign="top"><label for="message"><?php echo $lang_inviter["VotreMessage"];?></label></td>
						<td>
							<textarea name="message" id="message"><?php echo $row->message; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td></td>
						<td align="right">
							<a href="javascript:document.conseillez_site.submit();" class="bouton envoyer" ><?php echo $lang_inviter["Envoyer"];?></a>
						</td>
					</tr>
				</table>
				<input type="hidden" name="app" value="inviter" />
				<input type="hidden" name="action" value="conseillersubmit" />
			</form>
			<?php 
		}

		
}

?>

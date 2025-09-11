<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class mdp_HTML {
	
		
		
		// vérifie si l'utilisateur veut se log ou est log, et renseigne la variable global $user
		function messages(&$messages) {
			global $langue;
			include("lang/app_mdp.".$_GET['lang'].".php");
			// s'il y a des messages à afficher
			if(count($messages)) {
			?>
				<script src="../../Scripts/swfobject_modified.js" type="text/javascript"></script>

				<h2 class="messages"><?php echo $lang_appmdp["MessagesParentSolo"];?></h2>
				<div class="messages">
				<?
					// affiche les messages
					JL::messages($messages);
				?>
				</div>
				<br />
			<?
			}

		} 

		// reset du mdp
		function mdp(&$data, &$row, &$messages) {
			global $langue;
			include("lang/app_mdp.".$_GET['lang'].".php");
			global $user;
			global $db, $template, $user, $langue;
			
			?>
			
			<h2 class="barre"><?php echo $data->titre; ?></h2>
			<div class="texte_explicatif">
				<? echo $data->texte; ?>
			</div>
			<br />
		<?
			// affichage des messages
			mdp_HTML::messages($messages);

		?>
			
			<form action="<? echo JL::url(SITE_URL.'/index.php?app=mdp&action=mdp'.'&'.$langue); ?>" name="mdpForm" method="post">
				<h3 class="form"><?php echo $lang_appmdp["ChangerMonMotPasse"];?></h3>
				<table class="table_form" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td class="key">
							<label for="email"><?php echo $lang_appmdp["EmailInscription"];?></label>
						</td>
						<td>
							<input type="text" name="email" id="email" value="<? echo $row->email; ?>" class="inputtext" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="password"><?php echo $lang_appmdp["NouveauMdp"];?></label>
						</td>
						<td>
							<input type="password" name="password" id="password" value="" class="inputtext" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="password2">
								<?php echo $lang_appmdp["NouveauMdp"];?><br />
								(<?php echo $lang_appmdp["Confirmation"];?>)
							</label>
						</td>
						<td>
							<input type="password" name="password2" id="password2" value="" class="inputtext" />
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td colspan="2"><h4><?php echo $lang_appmdp["CodeDeSecurite"];?></h4></td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td class="key">
							<?php echo $lang_appmdp["CombienDeFleurs"];?>?
						</td>
						<td>
						<?
							for($i=0;$i<$row->captcha;$i++){
						?>
								<img src="parentsolo/images/flower.png" alt="Fleur" align="left" />
						<?
							}
						?>
						&nbsp;=&nbsp;<input type="text" name="verif" id="codesecurite" value="" maxlength="2" style="width:30px;"/>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td colspan="2" align="right">
							<a href="javascript:document.mdpForm.submit();" class="bouton envoyer"><?php echo $lang_appmdp["Envoyer"];?></a>
						</td>
					</tr>
				</table>
				<input type="hidden" name="captchaMd5" value="<?php echo $row->captchaMd5; ?>" />
				<input type="hidden" name="save" value="1" />
			</form>
		<?
		}


		// confirmation de changement de mot de passe
		function mdpChanged() {
			global $langue;
			include("lang/app_mdp.".$_GET['lang'].".php");
			global $user;
			?>
			<h2 class="barre"><?php echo $lang_appmdp["MdpModifieSucces"];?>!</h2>
			<div class="texte_explicatif">
				<?php echo $lang_appmdp["MdpModifie"];?>!<br />
				<br />
				<?php echo $lang_appmdp["ConnexionOk"];?>.<br />
				<br />
				<?php echo $lang_appmdp["ABientotSurParentsolo"];?>!
			</div>
		<?
		}


		// confirmation de changement non valide
		function mdpError() {
			global $langue;
			include("lang/app_mdp.".$_GET['lang'].".php");
			global $user;
			?>
			<h2 class="barre"><?php echo $lang_appmdp["MdpNonModifie"];?>!</h2>
			<div class="texte_explicatif">
				<?php echo $lang_appmdp["MdpPasModifie"];?>!<br />
				<br />
				<?php echo $lang_appmdp["LienNonValide"];?>.<br />
				<br />
				<?php echo $lang_appmdp["RecommencerProcedureMdpOublie"];?>.<br />
				<br />
				<?php echo $lang_appmdp["ABientotSurParentsolo"];?>!
			</div>
		<?
		}
		
	}
?>

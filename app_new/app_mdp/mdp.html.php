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
			<div class="col-md-12 accountset">			
				<h3 class="form"><?php echo $lang_appmdp["ChangerMonMotPasse"];?></h3>
				<div class="formwidth bottompadding">
					<div class="col-md-4"><label for="email"><?php echo $lang_appmdp["EmailInscription"];?></label></div>
					<div class="col-md-8"><input type="text" name="email" id="email" value="<? echo $row->email; ?>" class="inputtext" /></div>						
				</div>
				<div class="formwidth bottompadding">
					<div class="col-md-4"><label for="password"><?php echo $lang_appmdp["NouveauMdp"];?></label></div>
					<div class="col-md-8"><input type="password" name="password" id="password" value="" class="inputtext" /></div>						
				</div>
				<div class="formwidth bottompadding">
					<div class="col-md-4"><label for="password2">
								<?php echo $lang_appmdp["NouveauMdp"];?><br />
								(<?php echo $lang_appmdp["Confirmation"];?>)
							</label></div>
					<div class="col-md-8"><input type="password" name="password2" id="password2" value="" class="inputtext" /></div>						
				</div>
				<div class="formwidth bottompadding">
				<h4><?php echo $lang_appmdp["CodeDeSecurite"];?></h4>
				</div>
				<div class="formwidth bottompadding">
					<div class="col-md-5"><?php echo $lang_appmdp["CombienDeFleurs"];?>?</div>
					<div class="col-md-7">
						<?
							for($i=0;$i<$row->captcha;$i++){
						?>
								<img src="parentsolo/images/flower.png" alt="Fleur" align="left" />
						<?
							}
						?>
						&nbsp;=&nbsp;<input type="text" name="verif" id="codesecurite" value="" maxlength="2" style="width:80px;"/>
					</div>
				</div>
				<div class="descriptionform bottompadding" align="right">
					<a href="javascript:document.mdpForm.submit();" class="btn btn-primary bouton envoyer"><?php echo $lang_appmdp["Envoyer"];?></a>
				</div>	
				<!--<table class="table_form" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td class="key">
							
						</td>
						<td>
						
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td colspan="2" align="right">
							
						</td>
					</tr>
				</table>-->
				<input type="hidden" name="captchaMd5" value="<?php echo $row->captchaMd5; ?>" />
				<input type="hidden" name="save" value="1" />
			</div>
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

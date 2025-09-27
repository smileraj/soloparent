<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class mdp_HTML {
	
		
		
		// v&eacute;rifie si l'utilisateur veut se log ou est log, et renseigne la variable global $user
		public static function messages(&$messages) {
			global $langue;
			include("lang/app_mdp.".$_GET['lang'].".php");
			// s'il y a des messages &agrave; afficher
			if (is_array($messages)) {
			?>
				<script src="../../Scripts/swfobject_modified.js" type="text/javascript"></script>

				<h2 class="messages"><?php echo $lang_appmdp["MessagesParentSolo"];?></h2>
				<div class="messages">
				<?php 					// affiche les messages
					JL::messages($messages);
				?>
				</div>
				<br />
			<?php 			}

		} 

		// reset du mdp
		function mdp(&$data, &$row, &$messages) {
			global $langue;
			include("lang/app_mdp.".$_GET['lang'].".php");
			global $user;
			global $db, $template, $user, $langue;
			
			?>
			
			<div class="parentsolo_txt_center"><h2 class="parentsolo_title barre parentsolo_pt_10"><?php echo $data->titre; ?></h2>
			<div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			
			<div class="texte_explicatif">
				<?php echo $data->texte; ?>
			</div>
			<br />
		<?php 			// affichage des messages
			mdp_HTML::messages($messages);

		?>
			
			<form action="<?php echo JL::url(SITE_URL.'/index.php?app=mdp&action=mdp'.'&'.$langue); ?>" name="mdpForm" method="post">
			<div class="col-md-12 accountset">			
				<h3 class="form"><?php echo $lang_appmdp["ChangerMonMotPasse"];?></h3>
				<div class="formwidth bottompadding">
					<div class="col-md-6"><label for="email"><?php echo $lang_appmdp["EmailInscription"];?></label></div>
					<div class="col-md-6"><input type="text" name="email" id="email" value="<?php echo $row->email; ?>" class="inputtext" /></div>						
				</div>
				<div class="formwidth bottompadding">
					<div class="col-md-6"><label for="password"><?php echo $lang_appmdp["NouveauMdp"];?></label></div>
					<div class="col-md-6"><input type="password" name="password" id="password" value="" class="inputtext" /></div>						
				</div>
				<div class="formwidth bottompadding">
					<div class="col-md-6"><label for="password2">
								<?php echo $lang_appmdp["NouveauMdp"];?><br />
								(<?php echo $lang_appmdp["Confirmation"];?>)
							</label></div>
					<div class="col-md-6"><input type="password" name="password2" id="password2" value="" class="inputtext" /></div>						
				</div>
				<div class="formwidth bottompadding">
				<h4><?php echo $lang_appmdp["CodeDeSecurite"];?></h4>
				</div>
				<div class="formwidth bottompadding">
					<div class="col-md-12"><?php echo $lang_appmdp["CombienDeFleurs"];?>?</div>
					<div class="col-md-6">
						<?php 							for($i=0;$i<$row->captcha;$i++){
						?>
								<img src="parentsolo/images/flower.png" alt="Fleur" align="left" />
						<?php 							}
						?>
						
					</div>
					<div class="col-md-6"><input type="text" name="verif" id="codesecurite" value="" maxlength="2" style="width:100px !important;"/></div>
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
		<?php 		}


		// confirmation de changement de mot de passe
		public static function mdpChanged() {
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
		<?php 		}


		// confirmation de changement non valide
		public static function mdpError() {
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
		<?php 		}
		
	}
?>

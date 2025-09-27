<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class contactView extends JLView{
	
		function contactView() {}
		
		
		function display(&$contenu, &$row, &$list, &$messages) {
			include("lang/app_contact.".$_GET['lang'].".php");
			global $db, $template, $action;
			
		?>
			
			<!-- Partie Droite -->
			<div class="content">
				<div class="contentl">
					<div class="colc">
						
						<h1><?php echo $contenu->titre;?></h1>
						<br />
						<p>
							<?php echo  $contenu->texte; ?>
						</p>
						
						
					<?php 						// messages d'erreurs
						if (is_array($messages)) {
							
							// affichage des messages
							$this->messages($messages, false);
							
						}
					?>
						
						<form action="<?php echo JL::url('index.php?app=contact').'&lang='.$_GET['lang']; ?>" method="post" name="contactForm">
							
							<div class="questions">
								<h2><?php echo $lang_appcontact["FormulaireDeContact"];?></h2>
								<table class="membre" cellpadding="0" cellspacing="0">
									<tr>
										<td class="key"><label for="email"><?php echo $lang_appcontact["Email"];?></label></td>
										<td><input type="text" name="email" id="email" value="<?php echo $row->email; ?>" class="inputtext2" /></td>
									</tr>
									<tr>
										<td class="key"><label for="email"><?php echo $lang_appcontact["Sujet"];?></label></td>
										<td><?php echo $list['type_id']; ?></td>
									</tr>
									<tr>
										<td class="key"><label for="message"><?php echo $lang_appcontact["Message"];?></label></td>
										<td><textarea name="message" id="message" class="inputtext2"><?php echo $row->message; ?></textarea></td>
									</tr>
								</table>
							</div>
								
							<div class="verif">
								<h2><?php echo $lang_appcontact["CodeDeVerification"];?></h2>
								<table cellpadding="0" cellspacing="0">
									<tr>
										<td colspan="2">
											<?php echo $lang_appcontact["VeuillezRecopierCodeVerification"];?> <span class="verif"><?php echo $row->captcha; ?></span><br />
											<br />
											<b><?php echo $lang_appcontact["CodeDeVerification"];?></b> <input type="text" name="verif" class="verif" value="" />
										</td>
									</tr>
								</table>
							<input type="hidden" name="action" value="envoyer" />
							<input type="hidden" name="captchaAbo" value="<?php echo $row->captchaAbo; ?>" />
							</div>
							<div style="margin-top:30px;">
								<a href="javascript:document.contactForm.submit();" title="<?php echo $lang_appcontact["Envoyer"];?>" class="envoyer"><?php echo $lang_appcontact["Envoyer"];?></a>
							</div>
							
						</form>
					</div>
				</div>
				
				
				
				
				
				<!-- Partie Droite -->
				<div class="colr"> 
				<?php 					JL::loadApp('menu_offline');
				?>
				</div>
				<div style="clear:both"> </div>
			</div>
    
		<?php 		
		}
		
	}
?>

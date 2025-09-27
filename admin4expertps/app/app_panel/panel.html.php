<?php

	// s�curit�
	defined('JL') or die('Error 401');

	class HTML_panel {
		
		// page de login
	public static function loginPage() {
		?>
		<div class="login">
		<form action="<?php echo SITE_URL_ADMIN_EXPERT; ?>/index.php" name="login" method="post">
			<table cellpadding="0" cellspacing="0" width="100%">
			<?php 				// demande d'authentification ?
				$auth	= JL::getVar('auth', '');
				?>
				<tr>
					<td colspan="2">
						<center><h1>Authentification</h1></center>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td class="key"><label for="username">Pseudo</label></td>
					<td><input type="text" name="username" id="username" value="" class="loginText" /></td>
				</tr>
				<tr>
					<td class="key"><label for="pass">Mot de passe</label></td>
					<td><input type="password" name="pass" id="pass" value="" class="loginText" /></td>
				</tr>
				<?php // demande de login �chou�e
				if($auth == 'login') {
				?>
				<tr>
					<td class="errorLogin" colspan="2">
						Login ou mot de passe incorrect(s) !
					</td>
				</tr>
				<?php 					}
				?>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" align="right"><a href="javascript:document.login.submit();" class="bouton envoyer">Valider</a></td>
				</tr>
				
				
				
			</table>
			<input type="hidden" name="auth" value="login" />
		</form>
		</div>
		
		<?php 		}
		
		// page d'accueil admin
	public static function homePage() {
		?>
			<h1>Panneau d'administration pour les experts de solocircl.com</h1>
			<br />
			<div class="tableAdmin">
				<table>
					<tr>
						<td>
							Depuis cette administration des experts en naviguant via le menu se situant &agrave; gauche, vous pourrez &agrave; votre convenance:<br />
							<br />
							<ul>
								<li>- publier les questions pos&eacute;es par les membres et vos r&eacute;ponses</li>
								<li>- consulter les profils des membres vous ayant pos&eacute; ces m&ecirc;mes questions</li>
							</ul>
							<br />
							Pour toutes questions ou remarques, merci de poser vos questions &agrave; <a href="mailto:m.jombart@babybook.ch">m.jombart@babybook.ch</a>.
						</td>
				</table>
			</div>
		<?php 		
		}
		
	}
	
?>

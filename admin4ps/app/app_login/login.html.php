<?php

	// sécurité
	defined('JL') or die('Error 401');

	class HTML_login {
		
		public static function loginForm() {
			global $user;
		?>
		<div class="login">
		<form action="<? echo SITE_URL_ADMIN; ?>/index.php" name="login" method="post">
			<table cellpadding="0" cellspacing="0">
				<? // si utilisateur log
				if($user->id) {
				?>
					<tr class="loginright">
						<td>Bienvenue <span class="pink"><? echo $user->username; ?></span></td><td><input type="image" src="<? echo SITE_URL; ?>/parentsolo/images/logout.jpg" /></td>
					</tr>
				<?
				} else {
					
					// demande d'authentification ?
					$auth	= JL::getVar('auth', '');
					?>
					<tr>
						<td><label for="username">Pseudo</label></td>
						<td><input type="text" name="username" id="username" value="" class="loginText" /></td>
					</tr>
					<tr>
						<td><label for="pass">Mot de passe</label></td>
						<td><input type="password" name="pass" id="pass" value="" class="loginText" /></td>
					</tr>
					<td>
						<td><input type="image" src="<? echo SITE_URL; ?>/parentsolo/images/login-ok.jpg" /></td>
					</tr>
					
					<? // demande de login échouée
					if($auth == 'login') {
					?>
					<tr>
						<td colspan="5">
							<span class="pink">Login ou mot de passe incorrect(s) !</span>
						</td>
					</tr>
					<?
					}
					?>
					
				<?
				} ?>
			</table>
			<input type="hidden" name="auth" value="<? echo $user->id ? 'logout' : 'login'; ?>" />
		</form>
		</div>

<?
		}
	
	}
?>

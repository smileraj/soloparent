<?php

	// s�curit�
	defined('JL') or die('Error 401');

	global $db, $user;
	
?>
<div class="login">
<form action="<?php echo SITE_URL; ?>/index.php" name="login" method="post">
	<table cellpadding="0" cellspacing="0">
		<?php // si utilisateur log
		if($user->id) {
		?>
			<tr class="loginright">
				<td>Bienvenue <span class="pink"><?php echo $user->username; ?></span></td><td><input type="image" src="<?php echo SITE_URL; ?>/parentsolo/images/logout.jpg" /></td>
			</tr>
		<?php 		} else {
			
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
			<tr>
				<td><input type="image" src="<?php echo SITE_URL; ?>/parentsolo/images/login-ok.jpg" /></td>
			</tr>
			
			<?php // demande de login �chou�e
			if($auth == 'login') {
			?>
			<tr>
				<td colspan="5">
					<span class="pink">Login ou mot de passe incorrect(s) !</span>
				</td>
			</tr>
			<?php 			}
			?>
			
		<?php 		} ?>
	</table>
	<input type="hidden" name="auth" value="<?php echo $user->id ? 'logout' : 'login'; ?>" />
</form>
</div>

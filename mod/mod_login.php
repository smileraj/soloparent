<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $user, $langue;
			include("lang/app_mod.".$_GET['lang'].".php");

	// demande d'authentification ?
	$auth	= JL::getVar('auth', '');

	?>

	<a href="<? echo JL::url('index.php?app=inviter&action=conseil'.'&'.$langue); ?>" title="<?php echo $lang_mod["Invitez_vos_amis"];?>" class="inviter" ><img src="<? echo SITE_URL; ?>/parentsolo/images/parrainage<?php echo($_GET["lang"]!="fr")?"-":""; echo($_GET["lang"]!="fr")?$_GET["lang"]:"";?>.jpg" ></a>

	<form action="index.php?<?php echo $langue;?>" name="login" method="post">
		<a href="<? echo JL::url('index.php?app=profil&action=mdp'.'&'.$langue); ?>" title="<?php echo $lang_mod["MotDePasseOublie"];?> ?" class="loginMdpOublie"><?php echo $lang_mod["MotDePasseOublie"];?> ?<br /><?php echo $lang_mod["CliquezIci"];?> !</a>

		<label for="username" class="loginLogLabel"><?php echo $lang_mod["Pseudo"];?>:</label>
		<input type="text" name="username" id="username" value="" class="loginLogInput<? if($auth == 'login') { ?> badLogin<? } ?>" />

		<label for="pass" class="loginPassLabel"><?php echo $lang_mod["Pass"];?>:</label>
		<input type="password" name="pass" id="pass" value="" class="loginPassInput<? if($auth == 'login') { ?> badLogin<? } ?>" />

		<input type="image" src="<? echo SITE_URL; ?>/parentsolo/images/ok.jpg" class="loginOkButton" />

		<input type="hidden" name="auth" value="<? echo $user->id ? 'logout' : 'login'; ?>" />
	</form>
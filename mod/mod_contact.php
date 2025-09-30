<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $db, $user, $langue;
			include("lang/app_mod.".$_GET['lang'].".php");

	// variables
	$captcha	= random_int(2,7);
	$messages	= [];
	$options	= [];


	// r&eacute;cup les donn&eacute;es du formulaire
	$envoi			= JL::getVar('envoi', 0);
	$email			= JL::getVar('email', '');
	$sujet			= intval(JL::getVar('sujet', 4));
	$texte			= JL::getVar('texte', '');
	$codesecurite	= JL::getVar('codesecurite', '');

	$sujets			= ["".$lang_mod['Autre']."", "".$lang_mod['changementdAdresse']."", "".$lang_mod['ChangementPseudo']."", "".$lang_mod['InformationAbonnements']."", "".$lang_mod['InformationGenerales']."", "".$lang_mod['JeSouhaiteDesinscrire']."", "".$lang_mod['ProblemeTechnique'].""];

	for($i=0;$i<count($sujets);$i++) {
		$options[] 	= JL::makeOption($i, $sujets[$i]);
	}

	$listSujets		= JL::makeSelectList($options, 'sujet', 'class="contact"', 'value', 'text', $sujet);


	// correction de l'email
	if($email == '' && $user->id) {
		$email	= $user->email;
	}

	// si le formulaire a &eacute;t&eacute; submit
	if($envoi) {

		// v&eacute;rification du captcha
		if($codesecurite != JL::getSession('captcha', 0)) {
			$messages[]	= '<span class="error">'.$lang_mod["LeCodeSecurite"].'.</span>';
		}

		// si le sujet n'est pas renseign&eacute; (tentative de triche)
		if($sujet < 0 || $sujet >= count($sujets)) {
			$sujet	= 4;
		}

		// si le texte n'est pas renseign&eacute;
		if($texte == '') {
			$messages[]	= '<span class="error">'.$lang_mod["VeuillezRediger"].'.</span>';
		}

		// si l'email est incorrect
		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $email)) {
			$messages[]	= '<span class="error">'.$lang_mod["VotreAdresseEmail"].'.</span>';
		}

		if(!count($messages)) {

			// envoi du message
			JL::mail('info@solocircl.com', '[ Contact ] '.$sujets[$sujet], nl2br("De: ".$email."\n\n".$texte));

			// confirmation
			$messages[]	= '<span class="valid">'.$lang_mod["MessageEnvoye"].' !</span>';

			// r&eacute;initialise les valeurs
			$sujet	= '';
			$texte	= '';

		}

	}

?>

<form name="contactform" action="<?php echo JL::url('index.php?app=redac&action=item&id=6&'.$langue); ?>" method="post">
	<div class="profil_form contact">
		<?php 			// s'il y a des messages &agrave; afficher
			if (is_array($messages)) {
			?>
				<div class="messages">
				<?php 					// affiche les messages
					JL::messages($messages);
				?>
				</div>
			<?php 			}
		?>

		<p>
			<label for="email"><?php echo $lang_mod["VotreEmail"];?>:</label><br />
			<input type="text" name="email" id="email" value="<?php echo makeSafe($email); ?>" class="contact" />
		</p>
		<p>
			<label for="sujet"><?php echo $lang_mod["Sujet"];?>:</label><br />
			<?php echo $listSujets; ?>
		</p>
		<p>
			<label for="texte"><?php echo $lang_mod["Message"];?>:</label><br />
			<textarea name="texte" id="texte" class="contact" rows="5" cols="10"><?php echo makeSafe($texte); ?></textarea>
		</p>
		<p>
			<label for="codesecurite"><u><?php echo $lang_mod["CodeDeSecurite"];?>:</u> <?php echo $lang_mod["CombienYATIlDe"];?> ?</label><br /><br />
			<?php 				JL::setSession('captcha', $captcha);
				for($i=0;$i<$captcha;$i++){
				?>
					<img src="parentsolo/images/flower.jpg" alt="Fleur" align="left" />
				<?php 				}
				?>
				&nbsp;=&nbsp;<input type="text" name="codesecurite" id="codesecurite" value="" maxlength="1" />
		</p>
	</div>
	<input type="hidden" name="envoi" value="1" />
</form>
<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	global $db, $user, $langue;
	include("lang/app_mod.".$_GET['lang'].".php");

	// variables
	$captcha	= rand(2,7);
	$messages	= array();


	// r&eacute;cup les donn&eacute;es du formulaire
	$envoi				= JL::getVar('envoi', 0);
	$email				= trim(JL::getVar('email', ''));
	$sujet				= JL::getVar('sujet', '');
	$texte				= JL::getVar('texte', '');
	$codesecurite	= JL::getVar('codesecurite', '');
	$user_id_to		= (int)JL::getVar('user_id_to', 0, true);

	// r&eacute;cup le pseudo de l'utilisateur
	$query = "SELECT username FROM user WHERE id ='".$user_id_to."' LIMIT 0,1";
	$username = $db->loadResult($query);
	// pas de sujet
	if($sujet == '' && $user_id_to > 0)
		$sujet = ''.$lang_mod["SignalerUAbus"].' de '.$username.' par '.$user->username;



	// correction de l'email
	if($email == '' && $user->id) {
		$email	= $user->email;
	}

	// si le formulaire a &eacute;t&eacute; submit
	if($envoi) {

		// si l'email est incorrect
		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $email)) {
			$messages[]	= '<span class="error">'.$lang_mod["VotreAdresseEmail"].'.</span>';
		}

		// si le sujet n'est pas renseign&eacute;
		if($sujet == '') {
			$sujet	= 'Pas de sujet';
		}

		// si le texte n'est pas renseign&eacute;
		if($texte == '') {
			$messages[]	= '<span class="error">'.$lang_mod["VeuillezRedigerMessage"].'.</span>';
		}

		// v&eacute;rification du captcha
		if($codesecurite != JL::getSession('captcha', 0)) {
			$messages[]	= '<span class="error">'.$lang_mod["LeCodeSecurite"].'.</span>';
		}

		if(!count($messages)) {

			// envoi du message
			JL::mail('n.favaron@babybook.ch', '[ '.$lang_mod["SignalerUAbus"].' ] '.$sujet, nl2br($lang_mod["SignalerUAbus"].": De ".$username." par ".$user->username." (".$user->email.") \n\n".$texte));
			JL::mail('info@parentsolo.ch', '[ '.$lang_mod["SignalerUAbus"].' ] '.$sujet, nl2br($lang_mod["SignalerUAbus"].": De ".$username." par ".$user->username." (".$user->email.") \n\n".$texte));

			// confirmation
			$messages[]	= '<span class="valid">'.$lang_mod["MessageEnvoye"].' !</span>';

			// r&eacute;initialise les valeurs
			$sujet	= '';
			$texte	= '';
			$email	= '';

		}

	}

?>

<form name="abusform" action="<? echo JL::url('index.php?app=redac&action=item&id=8'.'&'.$langue); ?>" method="post">
	<div class="profil_form contact">
		<?
			// s'il y a des messages &agrave; afficher
			if(count($messages)) {
			?>
				<div class="messages">
				<?
					// affiche les messages
					JL::messages($messages);
				?>
				</div>
			<?
			}

		if(!$user->id) {
		?>
		<p>
			<label for="email"><?php echo $lang_mod["VotreEmail"];?>Votre email:</label><br />
			<input type="text" name="email" id="email" value="<? echo htmlentities($email); ?>" class="contact" />
		</p>
		<?
		}
		?>
		<p>
			<label for="sujet"><?php echo $lang_mod["Sujet"];?>:</label><br />
			<input type="text" name="sujet" id="sujet" value="<? echo htmlentities($sujet); ?>" class="contact" />
		</p>
		<p>
			<label for="texte"><?php echo $lang_mod["Message"];?>:</label><br />
			<textarea name="texte" id="texte" class="contact" rows="5" cols="10"><? echo htmlentities($texte); ?></textarea>
		</p>
		<p>
			<label for="codesecurite"><u><?php echo $lang_mod["CodeDeSecurite"];?>:</u> <?php echo $lang_mod["CombienYATIlDe"];?> ?</label><br /><br />
			<?
				JL::setSession('captcha', $captcha);
				for($i=0;$i<$captcha;$i++){
				?>
					<img src="parentsolo/images/flower.jpg" alt="Fleur" align="left" />
				<?
				}
				?>
				&nbsp;=&nbsp;<input type="text" name="codesecurite" id="codesecurite" value="" maxlength="1" />
		</p>
	</div>
	<input type="hidden" name="envoi" value="1" />
	<input type="hidden" name="user_id_to" value="<? echo htmlentities($user_id_to); ?>" />
</form>

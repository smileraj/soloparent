<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

class HTML_signaler_abus {


	// affichage des messages syst&egrave;me
	public static function messages(&$messages) {
			global $langue;
			include("lang/app_signaler_abus.".$_GET['lang'].".php");

		// s'il y a des messages &agrave; afficher
		if(count($messages)) {
		?>
			
			<h2 class="messages"><?php echo $lang_signaler_abus["MessagesParentsolo"];?></h2>
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

	
	public static function signaler(&$contenu, &$row, &$messages, $list) {
		global $langue;
		include("lang/app_signaler_abus.".$_GET['lang'].".php");
		global $action;


		?>

		<h2 class="barre"><?php echo $contenu->titre;?></h2>
		<div class="texte_explicatif">
			<? echo $contenu -> texte; ?>
		</div>
		<br />
	<?				
		// affichage des messages
		HTML_signaler_abus::messages($messages);

	?>
		<form name="abusform" action="<? echo JL::url('index.php?app=signaler_abus&user_id_to='.$row->user_id_to.'&lang='.$_GET['lang']); ?>" method="post">
			<h3 class="form"><?php echo $contenu->titre;?></h3>
			<table class="table_form" cellpadding="0" cellspacing="0" style="width:100%;">
				<tr>
					<td class="key"><label><?php echo $lang_signaler_abus["Sujet"];?>:</label></td>
					<td><b><? echo $row->sujet; ?></b></td>
				</tr>
				<tr>
					<td class="key" valign="top"><label for="message"><?php echo $lang_signaler_abus["Message"];?>:</label></td>
					<td><textarea name="message" id="message" ><? echo htmlentities($row->message); ?></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2"><h4><?php echo $lang_signaler_abus["CodeSecurite"];?></h4></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">
						<u><b><? echo $lang_signaler_abus["CombienDeFleurs"];?>?</b></u><br />
						<br />
					<?
						for($i=0;$i<$list['captcha'];$i++){
						?>
							<img src="<? echo SITE_URL; ?>/parentsolo/images/flower.png" alt="Fleur" align="left" />
						<?
						}
					?>
						&nbsp;=&nbsp;<input type="text" name="codesecurite" id="codesecurite" value="" maxlength="2" style="width:30px;" />
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" align="right"><a href="javascript:document.abusform.submit();" class="bouton envoyer"><?php echo $lang_signaler_abus["Envoyer"];?></a></td>
				</tr>
			</table>
			<input type="hidden" name="envoi" value="1" />
			<input type="hidden" name="action" value="send" />
			<input type="hidden" name="user_id_to" value="<? echo htmlentities($row->user_id_to); ?>" />
		</form>
	<?
	}

}
?>

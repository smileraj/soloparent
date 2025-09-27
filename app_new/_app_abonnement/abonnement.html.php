<?php

	// s�curit�
	defined('JL') or die('Error 401');

class HTML_abonnement {


	// affichage des messages syst�me
	function messages(&$messages) {
		global $langue;
			include("lang/app_abonnement.".$_GET['lang'].".php");

		// s'il y a des messages � afficher
		if (is_array($messages)) {
		?>
			<div class="profil_form">
				<h2 class="messages"><?php echo $lang_appabonnement["MessagesParentsolo"];?></h2>
				<div class="messages">
				<?php 					// affiche les messages
					JL::messages($messages);
				?>
				</div>
			</div>
		<?php 		}

	}


	// formulaire d'abonnement
	function abonnementForm($methode_id, &$paiement, &$debut, $duree, $montant) {
		global $langue;
		include("lang/app_abonnement.".$_GET['lang'].".php");

		?>
		<div class="content">
			<div class="contentl">
				<div class="colc">

				<h1><?php echo $lang_appabonnement["Abonnement"];?></h1>
				<br />
				<h2><?php echo $paiement->titre; ?></h2>
				<br />
				<?php echo $lang_appabonnement["VeuillezTrouverAbonnementDureeMontant"];?>.<br />
				<br />
				<div style="border: 1px solid #3b3f40; padding:10px;">
					<?php echo $paiement->texte; ?>

				<?php // BVR
					if($methode_id == 3) {
						
						if($montant == 38.00) {
						$imageBVR	= is_file('images/bvr-parentsolo-'.$montant.'.jpg') ? 'images/bvr-parentsolo-'.$montant.'.jpg' : 'images/bvr-parentsolo-38-'.$_GET['lang'].'.jpg'; }
						
						if($montant == 64.50) {
						$imageBVR	= is_file('images/bvr-parentsolo-'.$montant.'.jpg') ? 'images/bvr-parentsolo-'.$montant.'.jpg' : 'images/bvr-parentsolo-64-'.$_GET['lang'].'.jpg'; }
						
						if($montant == 78.00) {
						$imageBVR	= is_file('images/bvr-parentsolo-'.$montant.'.jpg') ? 'images/bvr-parentsolo-'.$montant.'.jpg' : 'images/bvr-parentsolo-78-'.$_GET['lang'].'.jpg'; }
						
						if($montant == 114.00) {
						$imageBVR	= is_file('images/bvr-parentsolo-'.$montant.'.jpg') ? 'images/bvr-parentsolo-'.$montant.'.jpg' : 'images/bvr-parentsolo-114-'.$_GET['lang'].'.jpg'; }
						
						?>
					
					<br />
					<br />
					<img src="<?php echo SITE_URL; ?>/<?php echo $imageBVR; ?>?<?php echo time(); ?>" alt="BVR solocircl.com CHF <?php echo $montant; ?>.-" style="width:630px" />
				<?php 
					} 
				?>
				</div>
				<br />
				<br />
				<h2><?php echo $debut->titre;?></h2>
				<br />
				<?php echo $debut->texte; ?>

		</div>
		</div>
		<div class="colr"> 
					<?php JL::loadMod('menu_right');?>
				</div>
			<div style="clear:both"> </div>
			</div>
		<?php 	}

	// formulaire de recherche + r�sultats
	function abonnementTarifs(&$contenu, &$debut) {
		global $langue;
		include("lang/app_abonnement.".$_GET['lang'].".php");
		?>
		<div class="content">
			<div class="contentl">
				<div class="colc">
			
			<h1><?php echo $lang_appabonnement["Abonnement"];?></h1>
			<br />
			<h2><?php echo $lang_appabonnement["AvantagesAbonne"];?></h2>
			<br />
			<table class="abonnement" width="100%">
				<tbody>
					<tr>
						<td width="50%">&nbsp;</td>
						<td align="center"><?php echo $lang_appabonnement["Visiteur"];?></td>
						<td align="center"><?php echo $lang_appabonnement["Membre"];?></td>
						<td align="center"><?php echo $lang_appabonnement["Abonne"];?></td>
					</tr>
					<tr class="abonnement_blanc">
						<td><?php echo $lang_appabonnement["EffectuerDesRecherches"];?></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
					</tr>
					<tr>
						<td><?php echo $lang_appabonnement["CreerSonProfil"];?></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
					</tr>
					<tr class="abonnement_blanc">
						<td><?php echo $lang_appabonnement["VoirLesProfils"];?></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
					</tr>
					<tr>
						<td><?php echo $lang_appabonnement["RecevoirDesMessages"];?></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
					</tr>
					<tr class="abonnement_blanc">
						<td><?php echo $lang_appabonnement["RecevoirDesFleurs"];?></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
					</tr>
					<tr>
						<td><?php echo $lang_appabonnement["CreerRejoindreGroupes"];?></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
					</tr>
					<tr class="abonnement_blanc">
						<td><?php echo $lang_appabonnement["EnvoyerDesMessages"];?></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
					</tr>
					<tr>
						<td><?php echo $lang_appabonnement["EnvoyerDesFleurs"];?></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
					</tr>
					<tr class="abonnement_blanc">
						<td><?php echo $lang_appabonnement["DialoguerSurChat"];?></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/non.gif" /></td>
						<td align="center"><img alt="" src="http://www.solocircl.com/~dev/images/oui.gif" /></td>
					</tr>
				</tbody>
			</table>
			<br />
			<br />
			<form name="abonnementForm" action="index.php?<?php echo$langue;?>" method="post">
				<center>
					<h2><?php echo $lang_appabonnement["SelectionAbonnement"];?></h2>
					<br />
					<div class="tarifs">
						<a href="javascript:offre(4);">
							<img src="<?php echo SITE_URL; ?>/images/offreOn.gif" alt="" id="abo4" />
							<span class="abo"><?php echo $lang_appabonnement["Mois12"];?></span><br />
							<i><?php echo $lang_appabonnement["Duree360"];?></i>
						</a>
						<br />
						<a href="javascript:offre(3);">
							<img src="<?php echo SITE_URL; ?>/images/offreOn.gif" alt="" id="abo3" />
							<span class="abo"><?php echo $lang_appabonnement["Mois6"];?></span><br />
							<i><?php echo $lang_appabonnement["Duree180"];?></i>
						</a>
						<br />
						<a href="javascript:offre(2);">
							<img src="<?php echo SITE_URL; ?>/images/offreOn.gif" alt="" id="abo2" />
							<span class="abo"><?php echo $lang_appabonnement["Mois3"];?></span><br />
							<i><?php echo $lang_appabonnement["Duree90"];?></i>
						</a>
						<br />
						<a href="javascript:offre(1);">
							<img src="<?php echo SITE_URL; ?>/images/offreOn.gif" alt="" id="abo1" />
							<span class="abo"><?php echo $lang_appabonnement["Mois1"];?></span><br />
							<i><?php echo $lang_appabonnement["Duree30"];?></i>
						</a>
					</div>
				</center>
				<br />
				<br />
				<h2><?php echo $lang_appabonnement["SelectionMethodePaiement"];?></h2>
				<br />
				<a href="javascript:abonnementFormSubmit(1);" class="methode m1" title="<?php echo $lang_appabonnement["PaiementEnLigne"];?>"><img src="<?php echo SITE_URL; ?>/images/methode1-<?php echo $_GET['lang']?>.png" alt="<?php echo $lang_appabonnement["PaiementEnLigne"];?>" /></a>
				<a href="javascript:abonnementFormSubmit(2);" class="methode m2" title="<?php echo $lang_appabonnement["VirementBancaire"];?>"><img src="<?php echo SITE_URL; ?>/images/methode2-<?php echo $_GET['lang']?>.png" alt="<?php echo $lang_appabonnement["VirementBancaire"];?>" /></a>
				<a href="javascript:abonnementFormSubmit(3);" class="methode m3" title="<?php echo $lang_appabonnement["BulletinVersement"];?>"><img src="<?php echo SITE_URL; ?>/images/methode3-<?php echo $_GET['lang']?>.png" alt="<?php echo $lang_appabonnement["BulletinVersement"];?>" /></a>
				<br />
				<br />				
				<h2><?php echo $debut->titre;?></h2>
				<br />
				<?php echo $debut->texte;?>


				<input type="hidden" name="app" value="abonnement" />
				<input type="hidden" name="action" value="methode" />
				<input type="hidden" name="abonnement_id" id="abonnement_id" value="2" />
				<input type="hidden" name="methode_id" id="methode_id" value="1" />
			</form>

		

		</div>
		</div>
		<div class="colr"> 
					<?php JL::loadMod('menu_right');?>
				</div>
			<div style="clear:both"> </div>
			</div>

		<script language="javascript" type="text/javascript">
			function abonnementFormSubmit(methode_id) {
				$('methode_id').value = methode_id;
				document.abonnementForm.submit();
			}
			function offre(abonnement_id) {
				if($('abonnement_id').value != abonnement_id) {
					$('abo1').style.visibility = 'hidden';
					$('abo2').style.visibility = 'hidden';
					$('abo3').style.visibility = 'hidden';
					$('abo4').style.visibility = 'hidden';
					$('abo'+abonnement_id).style.visibility = 'visible';
					$('abonnement_id').value = abonnement_id;
				}
			}
			$('abo2').style.visibility = 'visible';
			$('abo1').style.visibility = 'hidden';
			$('abo3').style.visibility = 'hidden';
			$('abo4').style.visibility = 'hidden';
		</script>
	<?php 	}



	// formulaire paypal
	function paypalForm(&$row) {
			include("lang/app_abonnement.".$_GET['lang'].".php");
		global $langue;
		global $user;
		?>
		<div class="content">
			<div class="contentl">
				<div class="colc">
					<form name="formPaypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_xclick">
						<input type="hidden" name="lc" value="<?php echo $_GET['lang']; ?>">
						<input type="hidden" name="business" value="BRS9LKSKQ72EQ">
						<input type="hidden" name="item_name" value="<?php echo makeSafe($row->nom); ?> (ref <?php echo $row->paypal_id; ?>)">
						<input type="hidden" name="item_number" value="1">
						<input type="hidden" name="amount" value="<?php echo $row->prix; ?>">
						<input type="hidden" name="currency_code" value="CHF">
						<input type="hidden" name="no_note" value="1">
						<input type="hidden" name="no_shipping" value="1">
						<input type="hidden" name="return" value="<?php echo SITE_URL; ?>/index.php?app=abonnement&action=methode&<?php echo $langue; ?>">
						<input type="hidden" name="cancel_return" value="<?php echo SITE_URL; ?>/index.php?app=abonnement&action=methode&custom=0&<?php echo $langue; ?>">
						<input type="hidden" name="notify_url" value="<?php echo SITE_URL; ?>/paypal.php">
						<input type="hidden" name="custom" value="<?php echo $row->custom; ?>">
					</form>
					<script language="javascript" type="text/javascript">
						function formPaypal(){try{clearInterval(timerPaypal);}catch(e){}document.formPaypal.submit();}
						var timerPaypal=setInterval("formPaypal();", 1000);
					</script>
					
					<h1><?php echo $lang_appabonnement["Abonnement"];?></h1>
					<br />
					<h2><?php echo $lang_appabonnement["RedirectionVersPaypal"];?></h2>
					<br />
					<div style="text-align:center;padding:20px; border:solid 1px #3b3f40">
						<img src="<?php echo SITE_URL; ?>/images/paypal-logo.jpg" alt="Paypal" /><br />
						<br />
						<?php echo $lang_appabonnement["RedirectionPaypal"];?>.<br />
						<br />
						<img src="<?php echo SITE_URL; ?>/images/paypal-loading.gif" alt="Chargement..." /><br />
						<br />
						<?php echo $lang_appabonnement["NePasAttendre"];?>, <a href="javascript:formPaypal();" title="<?php echo $lang_appabonnement["AccesDirectPaypal"];?>"><?php echo $lang_appabonnement["CliquezIci"];?></a>.
					</div>
				</div>
			</div>
			<div class="colr"> 
				<?php JL::loadMod('menu_right');?>
			</div>
			<div style="clear:both"> </div>
		</div>
	<?php 	}


	function paypalReturn($duree_credite) {
		global $langue;
			include("lang/app_abonnement.".$_GET['lang'].".php");

		?>
		<div class="content">
			<div class="contentl">
				<div class="colc">
					<h1><?php echo $lang_appabonnement["Abonnement"];?></h1>
					<br />
		<?php 		
		// paiement OK
		if($duree_credite) {
		?>
			<h2><?php echo $lang_appabonnement["FinalisationDuPaiement"];?></h2>
			<br />
			<?php echo $lang_appabonnement["TransactionValidee"];?> !<br />
			<br />
			<?php echo $lang_appabonnement["CompteCredite"];?>.<br />
			<br />
			<?php echo $lang_appabonnement["ParentsoloVousRemercie"];?> !
			
		<?php 		} else {
		?>
			<h2><?php echo $lang_appabonnement["TransactionAnnulee"];?></h2>
			<br />
			<?php echo $lang_appabonnement["ErreurTransaction"];?> !
		<?php 		}
		?>
	</div>
		</div>
		<div class="colr"> 
					<?php JL::loadMod('menu_right');?>
				</div>
			<div style="clear:both"> </div>
			</div>
	<?php 	}
}
?>

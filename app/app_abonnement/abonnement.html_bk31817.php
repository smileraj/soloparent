<?php
session_start();
	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');?>
<script type = "text/javascript" >
    //history.pushState(null, null, 'index.php?app=abonnement');
   // window.addEventListener('popstate', function(event) {
   // history.pushState(null, null, 'index.php?app=abonnement');
   // });
    </script>
<?php 
class HTML_abonnement {


	// affichage des messages syst&egrave;me
	public static function messages(&$messages) {
		global $langue;
			include("lang/app_abonnement.".$_GET['lang'].".php");

		// s'il y a des messages &agrave; afficher
		if (is_array($messages)) {
		?>
			
			<h2 class="messages"><?php echo $lang_appabonnement["Messages"];?></h2>
			<div class="messages">
			<?php
				// affiche les messages
				JL::messages($messages);
			?>
			</div>
			<br />
		<?php
		}

	}

	// formulaire d'abonnement
	public static function abonnementForm($methode_id, &$paiement, &$debut, $duree, $montant) {
		global $langue;
		include("lang/app_abonnement.".$_GET['lang'].".php");
?>
		<h2 class="barre"><?php echo $paiement->titre; ?></h2>
		<div class="texte_explicatif">
			<?php echo $lang_appabonnement["VeuillezTrouverAbonnementDureeMontant"];?>.<br />
			<br />
			
				<?php echo $paiement->texte; ?>

		<?php // BVR
				if($methode_id == 3) {
					$imageBVR	= 'images/BVR.png';
					/* if($montant == 52.00) {
					$imageBVR	= 'images/bvr-parentsolo-38-'.$_GET['lang'].'.png';
					}
					
					if($montant == 96.00) {
					$imageBVR	= 'images/bvr-parentsolo-64-'.$_GET['lang'].'.png';}
					
					if($montant == 115.00) {
					$imageBVR	= 'images/bvr-parentsolo-78-'.$_GET['lang'].'.png';}
					
					if($montant == 168.00) {
					$imageBVR	= 'images/bvr-parentsolo-114-'.$_GET['lang'].'.png';} */
					
					?>
				
				<br />
				<br />
	<img src="<?php echo SITE_URL; ?>/<?php echo $imageBVR; ?>?<?php echo time(); ?>" alt="BVR solocircl.com CHF <?php echo $montant; ?>.-" style="width:610px" />
			<?php 
				} 
			?>
			<br />
			<br />
			<h4><?php echo $debut->titre;?></h4>
			<br />
			<?php echo $debut->texte; ?>
		</div>
		<?php
	}

	// formulaire de recherche + r&eacute;sultats
	public static function abonnementTarifs(&$debut) {
		global $langue;
		include("lang/app_abonnement.".$_GET['lang'].".php");
		
		?>
		<form name="abonnementForm" class="" action="index.php?<?php echo$langue;?>" method="post">
   <div class="price_cls">
      <div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre parentsolo_pt_10"><?php echo $lang_appabonnement["Abonnez-vous"];?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
      <div class="col-md-12">
         <h3 class="verela_title_h3 parentsolo_mt_20  parentsolo_pb_15"><?php echo $lang_appabonnement["SelectionAbonnement"];?></h3>
      </div>
      <div class="col-md-12 price_cls parentsolo_txt_center parentsolo_mt_10">
         <div class="col-md-3 col-sm-6">
            <img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/abonnement/1mois_<?php echo $_GET['lang'];?>.png" />
            <p><input type="radio" name="abonnement_id" id="abonnement_id1" value="1"  style="width:20px;" /><label for="abonnement_id1" class="text-center"><?php echo $lang_appabonnement["1Mois"];?></label>
            </p>
            <p class="parentsolo_pb_10 parentsolo_pt_10 font_size_16"><i><?php echo $lang_appabonnement["Duree30"];?></i></p>
         </div>
         <div class="col-md-3 col-sm-6">
            <img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/abonnement/3mois_<?php echo $_GET['lang'];?>.png" />
            <p><input type="radio" name="abonnement_id" id="abonnement_id2" value="2"  style="width:20px;" checked /><label for="abonnement_id2" class="text-center"><?php echo $lang_appabonnement["3Mois"];?></label></p>
            <p class="parentsolo_pb_10 parentsolo_pt_10 font_size_16"><i><?php echo $lang_appabonnement["Duree90"];?></i></p>
         </div>
         <div class="col-md-3 col-sm-6">
            <img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/abonnement/6mois_<?php echo $_GET['lang'];?>.png" />
            <p><input type="radio" name="abonnement_id" id="abonnement_id3" value="3"  style="width:20px;" /><label for="abonnement_id3" class="text-center"><?php echo $lang_appabonnement["6Mois"];?></label></p>
            <p class="parentsolo_pb_10 parentsolo_pt_10 font_size_16"><i><?php echo $lang_appabonnement["Duree180"];?></i></p>
         </div>
         <div class="col-md-3 col-sm-6">
            <img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/abonnement/12mois_<?php echo $_GET['lang'];?>.png" />
            <p><input type="radio" name="abonnement_id" id="abonnement_id4" value="4"  style="width:20px;" /><label for="abonnement_id4" class="text-center"><?php echo $lang_appabonnement["12Mois"];?></label></p>
            <p class="parentsolo_pb_10 parentsolo_pt_10 font_size_16"><i><?php echo $lang_appabonnement["Duree360"];?></i></p>
         </div>
      </div>
      <div class="col-md-12">
         <h3 class="verela_title_h3 parentsolo_mt_20  parentsolo_pb_15"><?php echo $lang_appabonnement['AcceptezCGU']; ?></h3>
      </div>
      <div class="col-md-12 parentsolo_txt_center parentsolo_mb_20 ">
         <p class="parentsolo_pb_10 parentsolo_pt_10"><label for="acceptation_cgu"><input type="checkbox" name="acceptation_cgu" id="acceptation_cgu" value="1"  style="width:20px;" /> <?php echo $lang_appabonnement['JAccepteCGU']; ?></label></p>
      </div>
      <div class="col-md-12  col-xs-12">
         <div class="col-md-3 col-sm-3  col-xs-3">
            <a href="javascript:abonnementFormSubmit(1);" class="methode m1" title="<?php echo $lang_appabonnement["PaiementEnLigne"];?>"><img src="<?php echo SITE_URL; ?>/images/methode1-<?php echo $_GET['lang']?>.png" alt="<?php echo $lang_appabonnement["PaiementEnLigne"];?>" /></a>
         </div>
		 <div class="col-md-3 col-sm-3  col-xs-3">
            <a href="javascript:abonnementFormSubmit(4);" class="methode m1" title="<?php echo $lang_appabonnement["PaiementEnLigne"];?>"><img src="<?php echo SITE_URL; ?>/images/methode4-<?php echo $_GET['lang']?>.png" alt="<?php echo $lang_appabonnement["PaiementEnLigne"];?>" /></a>
         </div>
         <div class="col-md-3 col-sm-3 col-xs-3 ">
            <a href="javascript:abonnementFormSubmit(2);" class="methode m2" title="<?php echo $lang_appabonnement["VirementBancaire"];?>"><img src="<?php echo SITE_URL; ?>/images/methode2-<?php echo $_GET['lang']?>.png" alt="<?php echo $lang_appabonnement["VirementBancaire"];?>" /></a>
         </div>
         <div class="col-md-3 col-sm-3  col-xs-3">
            <a href="javascript:abonnementFormSubmit(3);" class="methode m3" title="<?php echo $lang_appabonnement["BulletinVersement"];?>"><img src="<?php echo SITE_URL; ?>/images/methode3-<?php echo $_GET['lang']?>.png" alt="<?php echo $lang_appabonnement["BulletinVersement"];?>" /></a>							
         </div>
      </div><br><div class="clear"></div>
      <div class="col-md-12">
         <h3 class="verela_title_h3 parentsolo_mt_20  parentsolo_pb_15"><?php echo $debut->titre;?></h3>
         <div class="texte_explicatif">
            <?php echo $debut->texte;?>
         </div>
         <input type="hidden" name="app" value="abonnement" />
         <input type="hidden" name="action" value="methode" />
         <input type="hidden" name="methode_id" id="methode_id" value="1" />
      </div>
   </div>
</form>
			

	<script language="javascript" type="text/javascript">
		function abonnementFormSubmit(methode_id) {
			$('methode_id').value = methode_id;
			
			if($('acceptation_cgu').checked == true){
				document.abonnementForm.submit();
			}else{
				alert("<?php echo $lang_appabonnement['IndicationAcceptationCGU']; ?>");
			}
		}
	</script>
	<?php
	}
	
	
	// Tarifs hors connection
	public static function abonnementInfos() {
		global $langue, $user;
		include("lang/app_abonnement.".$_GET['lang'].".php");
		
		?>
			<div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre parentsolo_pt_10"><?php echo $lang_appabonnement["Tarifs"];?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
			
			<div class="texte_explicatif">
			<div class="col-md-12">
         <h3 class="verela_title_h3 parentsolo_mt_20  parentsolo_pb_15"><?php echo $lang_appabonnement["Abonnements"];?></h3>
      </div>
      <div class="col-md-12 price_cls parentsolo_txt_center parentsolo_mt_10">
         <div class="col-md-3 col-sm-6">
            <img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/abonnement/1mois_<?php echo $_GET['lang'];?>.png" />
            <p><label for="abonnement_id1" class="text-center"><?php echo $lang_appabonnement["1Mois"];?></label>
            </p>
            <p class="parentsolo_pb_10 parentsolo_pt_10 font_size_16"><i><?php echo $lang_appabonnement["Duree30"];?></i></p>
         </div>
         <div class="col-md-3 col-sm-6">
            <img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/abonnement/3mois_<?php echo $_GET['lang'];?>.png" />
            <p><label for="abonnement_id2" class="text-center"><?php echo $lang_appabonnement["3Mois"];?></label></p>
            <p class="parentsolo_pb_10 parentsolo_pt_10 font_size_16"><i><?php echo $lang_appabonnement["Duree90"];?></i></p>
         </div>
         <div class="col-md-3 col-sm-6">
            <img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/abonnement/6mois_<?php echo $_GET['lang'];?>.png" />
            <p><label for="abonnement_id3" class="text-center"><?php echo $lang_appabonnement["6Mois"];?></label></p>
            <p class="parentsolo_pb_10 parentsolo_pt_10 font_size_16"><i><?php echo $lang_appabonnement["Duree180"];?></i></p>
         </div>
         <div class="col-md-3 col-sm-6">
            <img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/abonnement/12mois_<?php echo $_GET['lang'];?>.png" />
            <p><label for="abonnement_id4" class="text-center"><?php echo $lang_appabonnement["12Mois"];?></label></p>
            <p class="parentsolo_pb_10 parentsolo_pt_10 font_size_16"><i><?php echo $lang_appabonnement["Duree360"];?></i></p>
         </div>
      </div>
				
				<br />
				<br />
				<h4><?php echo $lang_appabonnement["LesDifferentsModesDePaiement"];?></h4>
				<br />
				<div>
					<ul>
						<li><b><?php echo $lang_appabonnement["PaiementEnLigne"];?></b> <i><?php echo $lang_appabonnement["Delais1"];?></i></li>
						<li><b><?php echo $lang_appabonnement["VirementBancaire"];?></b> <i><?php echo $lang_appabonnement["Delais2"];?></i></li>
						<li><b><?php echo $lang_appabonnement["BulletinVersement"];?></b> <i><?php echo $lang_appabonnement["Delais3"];?></i></li>
					</ul>
					<br />
					<?php echo $lang_appabonnement["DelaisValidation"];?>
				</div>
				<br />
				<br />
				<h4><?php echo $lang_appabonnement["AvantagesAbonne"];?></h4>
				<br />
				<table class="abonnements_table avantages" cellpadding="0" cellspacing="0" width="100%">
					<tbody>
						<tr>
							<th width="50%">&nbsp;</td>
							<th align="center" style="text-align:center !important;"><?php echo $lang_appabonnement["Visiteur"];?></td>
							<th align="center" style="text-align:center !important;"><?php echo $lang_appabonnement["Membre"];?></td>
							<th align="center" style="text-align:center !important;"><?php echo $lang_appabonnement["Abonne"];?></td>
						</tr>
						<tr>
							<td><?php echo $lang_appabonnement["EffectuerDesRecherches"];?></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
						</tr>
						<tr>
							<td><?php echo $lang_appabonnement["CreerSonProfil"];?></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
						</tr>
						<tr>
							<td><?php echo $lang_appabonnement["VoirLesProfils"];?></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
						</tr>
						<tr>
							<td><?php echo $lang_appabonnement["RecevoirDesMessages"];?></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
						</tr>
						<tr>
							<td><?php echo $lang_appabonnement["RecevoirDesFleurs"];?></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
						</tr>
						<tr>
							<td><?php echo $lang_appabonnement["CreerRejoindreGroupes"];?></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
						</tr>
						<tr>
							<td><?php echo $lang_appabonnement["EnvoyerDesMessages"];?></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
						</tr>
						<tr>
							<td><?php echo $lang_appabonnement["EnvoyerDesFleurs"];?></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
						</tr>
						<tr>
							<td class='fin' <?php /* if($_GET['lang']!='fr'){ echo "class='fin'";} */ ?> ><?php echo $lang_appabonnement["DialoguerSurChat"]; ?></td>
							<td class='fin' <?php /* if($_GET['lang']!='fr'){ echo "class='fin'";} */ ?> align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td class='fin' <?php /* if($_GET['lang']!='fr'){ echo "class='fin'";} */ ?> align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/non.gif" /></td>
							<td class='fin' <?php /* if($_GET['lang']!='fr'){ echo "class='fin'";} */ ?> align="center"><img alt="" src="<?php echo SITE_URL; ?>/images/oui.gif" /></td>
						</tr>
						<?php
							/*if($_GET['lang']=='fr'){
						?>
							<tr>
								<td class='fin'><?php echo $lang_appabonnement["QuestionsExperts"];?></td>
								<td class='fin' align="center"><img alt="" src="http://www.solocircl.com/images/non.gif" /></td>
								<td class='fin' align="center"><img alt="" src="http://www.solocircl.com/images/non.gif" /></td>
								<td class='fin' align="center"><img alt="" src="http://www.solocircl.com/images/oui.gif" /></td>
							</tr>
						<?php
							}*/
						?>
					</tbody>
				</table>
	
		</div>
			
	<?php
	}
	
	// Service indisponible
	public static function abonnementServiceIndisponible() {
		global $langue, $user;
		include("lang/app_abonnement.".$_GET['lang'].".php");
		
		?>
			<h2 class="barre"><?php echo $lang_appabonnement["Abonnements"];?></h2>
			<div class="texte_explicatif">
				<p><?php echo $lang_appabonnement["ServiceIndisponible"];?></p>
			</div>
			
	<?php
	}


	// formulaire paypal
	public static function paypalForm(&$row) {
			include("lang/app_abonnement.".$_GET['lang'].".php");
		global $langue;
		global $user;

		?>
		
			<form name="formPaypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_xclick-subscriptions">
				<input type="hidden" name="business" value="paypal@solocircl.com">
				<input type="hidden" name="item_name" value="<?php echo makeSafe($row->nom); ?> (ref <?php echo $row->paypal_id; ?>)">
				<input type="hidden" name="item_number" value="1">
				<input type="hidden" name="no_shipping" value="1">
				<input type="hidden" name="return" value="<?php echo SITE_URL; ?>/index.php?app=abonnement&action=methode&<?php echo $langue; ?>">
				<input type="hidden" name="cancel_return" value="<?php echo SITE_URL; ?>/index.php?app=abonnement&action=methode&custom=0&<?php echo $langue; ?>">
				<input type="hidden" name="a3" value="<?php echo $row->montant; ?>">
				<input type="hidden" name="p3" value="<?php echo $row->duree_paypal; ?>">
				<input type="hidden" name="t3" value="<?php echo $row->unite_duree_paypal; ?>">
				<input type="hidden" name="src" value="1">
				<input type="hidden" name="sra" value="1">
				<input type="hidden" name="no_note" value="1">
				<input type="hidden" name="custom" value="<?php echo $row->custom; ?>">
				<input type="hidden" name="currency_code" value="CHF">
				<input type="hidden" name="lc" value="FR">
				<input type="hidden" name="notify_url" value="<?php echo SITE_URL; ?>/paypal.php">
			</form>
			<script language="javascript" type="text/javascript">
				function formPaypal(){try{clearInterval(timerPaypal);}catch(e){}document.formPaypal.submit();}
				var timerPaypal=setInterval("formPaypal();", 1000);
			</script>

		
			<div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre parentsolo_pt_10"><?php echo $lang_appabonnement["RedirectionVersPaypal"];?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
			<div class="texte_explicatif paypal_redirection text-center">
				<img src="<?php echo SITE_URL; ?>/images/paypal-logo.jpg" alt="Paypal" /><br />
				<br />
				<?php echo $lang_appabonnement["RedirectionPaypal"];?>.<br />
				<br />
				<img src="<?php echo SITE_URL; ?>/images/paypal-loading.gif" alt="Chargement..." /><br />
				<br />
				<?php echo $lang_appabonnement["NePasAttendre"];?>, <a href="javascript:formPaypal();" title="<?php echo $lang_appabonnement["AccesDirectPaypal"];?>"><?php echo $lang_appabonnement["CliquezIci"];?></a>.
			</div>
				
	<?php
	}
	
	
	// formulaire paypal
	function paypalImpossible() {
			include("lang/app_abonnement.".$_GET['lang'].".php");
		global $langue;
		global $user;

		?>
		<h2  class="barre"><?php echo $lang_appabonnement["AbonnementImpossible"];?></h2>
		<div class="texte_explicatif">
			<?php echo $lang_appabonnement["VousNePouvezPas"];?>.
		</div>
		
	<?php
	}


	public static function paypalReturn($duree_credite) {
		global $langue;
			include("lang/app_abonnement.".$_GET['lang'].".php");


			// paiement OK
			if($duree_credite) {
		?>
				<h2  class="barre"><?php echo $lang_appabonnement["FinalisationDuPaiement"];?></h2>
				<h2  class="barre"><?php echo $lang_appabonnement["FinalisationDuPaiement"];?></h2>
				<div class="texte_explicatif">
					<?php echo $lang_appabonnement["TransactionValidee"];?>!<br />
					<br />
					<?php echo $lang_appabonnement["CompteCredite"];?>.<br />
					<br />
					<?php echo $lang_appabonnement["ParentsoloVousRemercie"];?>!
				</div>
			
		<?php
		} else {
		?>
			<h2  class="barre"><?php echo $lang_appabonnement["TransactionAnnulee"];?></h2>
				<div class="texte_explicatif">
					<?php echo $lang_appabonnement["ErreurTransaction"];?>!
				</div>
		<?php
		}
	}
	// formulaire paypal
	public static function postfinanceForm(&$row,&$row1) {
			include("lang/app_abonnement.".$_GET['lang'].".php");
		global $langue;
		global $user;
$ogone_SHA = 'Parentsoloch@123';
$ogone_PSPID = 'parentsolo';
$ogone_ORDERID = $row->id.'_'.rand(100,10000); 
$ogone_CURRENCY = "CHF"; 
$ogone_LANGUAGE = 'en_US'; 
$ogone_ACCEPTURL = SITE_URL.'/index.php?app=abonnement&action=details&lang='.$_GET['lang'].'&result=Success';
$ogone_CANCELURL = SITE_URL.'/index.php?app=abonnement&action=details&lang='.$_GET['lang'].'&result=canceled';
$ogone_DECLINEURL = SITE_URL.'/index.php?app=abonnement&action=details&lang='.$_GET['lang'].'&result=decline';
$ogone_EXCEPTIONURL = SITE_URL.'/index.php?app=abonnement&action=details&lang='.$_GET['lang'].'&result=exception';
$ogone_ACCEPTURL_alias = SITE_URL.'/index.php?app=abonnement&action=SavedCarddetails&lang='.$_GET['lang'].'&result=Success';
$ogone_EXCEPTIONURL_alias = SITE_URL.'/index.php?app=abonnement&action=SavedCarddetails&lang='.$_GET['lang'].'&result=exception';


$ogone_AMOUNT1 ='0.01'; 
$ogone_CN = $row->username;
$ogone_EMAIL = $row->email;
$ogone_OWNERZIP = $row->ville_id;
$ogone_OWNERADDRESS = $row->adresse;
$ogone_OWNERCTY = $row->canton;
$ogone_OWNERTOWN = $row->ville;
$ogone_OWNERTELNO = $row->telephone;
//$ogone_USERID = $row->user_id ;
$ogone_USERID = 'parentsoloCH' ;
$ogone_AMOUNT = $ogone_AMOUNT1;


	?>
	<div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre parentsolo_pt_10"><?php echo $lang_appabonnement["RedirectionVersPostFinance"];?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
	  <div class="col-md-8 col-md-offset-2  col-sm-8 col-sm-offset-2  parentsolo_form_style  parentsolo_mt_40">
<form method="post" action="ajax_paymnetRedirection.php"><!--ajax_savedcard.php-->
		<input type="hidden" name="PSPID" value="<?php echo $ogone_PSPID;?>">
		<input type="hidden" name="ORDERID"     value="<?php echo $ogone_ORDERID;?>">
        <input type="hidden" name="CURRENCY"    value="<?php echo $ogone_CURRENCY;?>">
        <input type="hidden" name="LANGUAGE"    value="<?php echo $ogone_LANGUAGE;?>">
        <input type="hidden" name="AMOUNT"      value="<?php echo $ogone_AMOUNT;?>">
      <!--  <input type="hidden" name="OWNERZIP" value="<?php echo $ogone_OWNERZIP;?>">
        <input type="hidden" name="OWNERADDRESS" value="<?php echo $ogone_OWNERADDRESS;?>"> 
        <input type="hidden" name="OWNERCTY" value="<?php echo $ogone_OWNERCTY;?>">  
        <input type="hidden" name="OWNERTOWN" value="<?php echo $ogone_OWNERTOWN; ?>">  -->
        <input type="hidden" name="USERID" value="<?php echo $ogone_USERID;?>">
		<input type="hidden" name="ACCEPTURL" value="<?php echo $ogone_ACCEPTURL;?>">
        <input type="hidden" name="DECLINEURL" value="<?php echo $ogone_DECLINEURL;?>">
        <input type="hidden" name="EXCEPTIONURL" value="<?php echo $ogone_EXCEPTIONURL;?>">
		<input type="hidden" name="WIN3DS" value="MAINW">
        <input type="hidden" name="CANCELURL" value="<?php echo $ogone_CANCELURL;?>">		
		<input type="hidden" name="ACCEPTURL_saved" value="<?php echo $ogone_ACCEPTURL_alias;?>"> 
		<input type="hidden" name="EXCEPTIONURL_saved" value="<?php echo $ogone_EXCEPTIONURL_alias; ?>"> 
		<input type="hidden" name="Amount_valenc" value="<?php echo base64_encode($ogone_AMOUNT);?>"> 
<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4 text-right">
							<label for="media_id"  class="lable_right"><?php echo $lang_appabonnement["Card_holder_name"];?> :</label>
						</div>
						<div class="col-md-8">
							<!--<input type="text"  required="" class="msgtxt" name="CN_holder_name" maxlength="35" value="<?php echo $row->username;?>" pattern="[a-zA-Z][a-zA-Z0-9\s]*">-->
<input type="text"  required class="msgtxt" name="CN_holder_name" maxlength="35" placeholder="<?php echo $lang_appabonnement["Card_holder_name"];?>"  pattern="[a-zA-Z][a-zA-Z0-9\s]*" >
						</div>
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4 text-right">
							<label for="media_id"  class="lable_right"><?php echo $lang_appabonnement["Email_address"];?> :</label>
						</div>
						<div class="col-md-8">
							<input type="email"  required class="msgtxt" name="Email_address" maxlength="50" value="<?php echo $row->email;?>" >
						</div>
					</div>
				</div>
				
				<!--<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4 text-right">
							<label for="media_id"  class="lable_right"><?php echo $lang_appabonnement["Phone_Number"];?> :</label>
						</div>
						<div class="col-md-8">
							<input type="text"  required class="msgtxt" name="phone_number" maxlength="15" value="<?php echo $row->telephone;?>"  pattern="[-+]?[0-9]*[.,]?[0-9]+">
						</div>
					</div>
				</div>-->
				<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4 text-right">
							<label for="media_id"  class="lable_right"><?php echo $lang_appabonnement["Amount"];?> :</label>
						</div>
						<div class="col-md-8">
							<input type="text" readonly class="msgtxt" readonly name="amount" maxlength="10" value="<?php echo $row1->montant;?>" >
							
						</div>
					</div>
				</div>
				
				<div class="row bottompadding " style="display:none;">
					<div class="col-md-12 parentsolo_pt_10 parentsolo_pb_10">
						
						<div class="col-md-12 text-center ">
							<input type="checkbox"  checked class="msgtxt Saved_card_option"  id="Saved_card_option" name="Saved_card_option" Value="Yes" onclick="onclick_show_card()"> &nbsp;<?php echo $lang_appabonnement["save_card_msg"];?>
						</div>
					</div>
				</div>
<!--<div id="card_details" style="display:none;">-->
				<div >
				<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4 text-right">
							<label for="media_id" class="lable_right"><?php echo $lang_appabonnement["Pay_With"];?> :</label>
						</div>
						<div class="col-md-8">
							<select name="BRAND_val"  id="BRAND_val" required >
							<option value="">Select</option>
							<option value="American Express">American Express</option>
							<option value="VISA">VISA</option>
							<option value="MasterCard">MasterCard</option>
							<option value="PostFinance Card">PostFinance Card</option>
							</select>
						</div>
					</div>
				</div>
				
				
		<!--<input type="text" name="CARDNO" value="<?php echo $ogone_CARDNO_alias; ?>">--> 
				<div class="row bottompadding">
							<div class="col-md-12">
								<div class="col-md-4 text-right">
									<label for="media_id"  class="lable_right"><?php echo $lang_appabonnement["Card_number"];?> :</label>
								</div>
								<div class="col-md-8">
									<input type="text" id="CARDNO_number" required placeholder="<?php echo $lang_appabonnement["Card_number"];?>" class="msgtxt" name="CARDNO_number" maxlength="21" value=""  pattern="[0-9]*">
								</div>
							</div>
				</div>
		<!--<input type="text" name="CVC" value="<?php echo $ogone_CVC_alias; ?>"> -->
		<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4 text-right">
							<label for="media_id"  class="lable_right"> <?php echo $lang_appabonnement["CVC"];?>  :</label>
						</div>
						<div class="col-md-8">
							<input type="text"   id="CVC_number" class="msgtxt" required placeholder="<?php echo $lang_appabonnement["CVC"];?>" style="width: 100px !important;" name="CVC_number" maxlength="5"  pattern="[0-9]*" >
						</div>
					</div>
					</div>
			<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-4 text-right">
							<label for="media_id"  class="lable_right"><?php echo $lang_appabonnement["Card_expiration_date"];?>  :</label>
						</div>
						<div class="col-md-8">
							<div class="col-md-3 col-sm-4 col-xs-5 nopadding padding-rt_10">
								<input type="text"   class="msgtxt" id="ECOM_CARDINFO_EXPDATE_MONTH_number"  name="ECOM_CARDINFO_EXPDATE_MONTH_number"  placeholder="MM"  pattern="[0-9]*" maxlength="2" style="width: 100px !important;" required value="">
							</div>
							<div class="col-md-3 col-sm-4 col-xs-5 nopadding padding-lt_10">
								<input type="text"   class="msgtxt" id="ECOM_CARDINFO_EXPDATE_YEAR_number"  name="ECOM_CARDINFO_EXPDATE_YEAR_number" placeholder="YYYY" pattern="[0-9]*" maxlength="4" style="width: 100px !important;" required value="">
							</div>
						</div>
					</div>
			</div>
				

		</div>
		<div class="row bottompadding">
						<div class="col-md-12 text-center">
						<input type="hidden"   class="msgtxt" name="idval_name" maxlength="50" value="<?php echo $row->id;  ?>">
						<input type="submit" name="submit_btn"    value="<?php echo $lang_appabonnement["submit_btn"];?>"  class="bouton annuler  parentsolo_btn">
						</div>
					</div>
			</form>
	  </div><div class="clear"></div>
	  <script>
	
	/*
function onclick_show_card(){	
   if(document.getElementById('Saved_card_option').checked){	   
  //alert('hai');
    document.getElementById('card_details').style.display = "block";
	document.getElementById('BRAND_val').required = true;
	document.getElementById('CARDNO_number').required = true;
	document.getElementById('CVC_number').required = true;
	document.getElementById('ECOM_CARDINFO_EXPDATE_MONTH_number').required = true;
	document.getElementById('ECOM_CARDINFO_EXPDATE_YEAR_number').required = true;
	
   }  else{
	   // alert('esle');
   document.getElementById('card_details').style.display = "none";
   document.getElementById('BRAND_val').required = false;
	document.getElementById('CARDNO_number').required = false;
	document.getElementById('CVC_number').required = false;
	document.getElementById('ECOM_CARDINFO_EXPDATE_MONTH_number').required = false;
	document.getElementById('ECOM_CARDINFO_EXPDATE_YEAR_number').required = false;
   }
} */
	  </script>
	  
			<!--<div class="texte_explicatif paypal_redirection parentsolo_txt_center parentsolo_mt_20">
				<img src="<?php echo SITE_URL; ?>/images/postfinance-logo.jpg" alt="Paypal" /><br />
				<br />
				<?php echo $lang_appabonnement["RedirectionPaypal"];?>.<br />
				<br />
				<img src="<?php echo SITE_URL; ?>/images/postfinance-loading.gif" alt="Chargement..." /><br />
				<br />
				<?php echo $lang_appabonnement["NePasAttendre"];?>, <a href="javascript:form1();" title="<?php echo $lang_appabonnement["AccesDirectPaypal"];?>"><?php echo $lang_appabonnement["CliquezIci"];?></a>.
			</div>-->
				
	<?php
	}
public static function SavedCarddetails(&$Saved_OrderID,&$Saved_CN,&$Saved_NCErrorCN,&$Saved_CardNo,&$Saved_Brand,&$Saved_NCErrorCardNo,&$Saved_CVC,&$Saved_NCErrorCVC,&$Saved_ED,&$Saved_NCErrorED,&$Saved_NCError,&$Saved_Alias,&$Saved_status,&$Saved_SHASign,&$row){
	global $langue;
	include("lang/app_abonnement.".$_GET['lang'].".php");
	if($Saved_Alias !=''){
	
	$ogone_SHA = 'Parentsoloch@123';
	$ogone_PSPID = $_SESSION['PSPID_saved'];
$ogone_ALIAS = $Saved_Alias;
$ogone_ALIASUSAGE= 'parentsolo';
$ogone_ORDERID = $Saved_OrderID; 
$ogone_ED=$Saved_ED;
$ogone_CARDNO = $Saved_CardNo; 
$ogone_AMOUNT =$_SESSION['Amount_valenc_saved']; 
$ogone_CN = $Saved_CN;
$ogone_EMAIL = $_SESSION['Email_address_saved'];
/* $ogone_OWNERZIP = $_SESSION['OWNERZIP_saved'];
$ogone_OWNERADDRESS = $_SESSION['OWNERADDRESS_saved'];
$ogone_OWNERCTY = $_SESSION['OWNERCTY_saved'];
$ogone_OWNERTOWN = $_SESSION['OWNERTOWN_saved'];
$ogone_OWNERTELNO = $_SESSION['phone_number_saved'];
 */
 $ogone_USERID = $_SESSION['USERID_saved'];
$ogone_AMOUNT = round($_SESSION['Amount_valenc_saved'], 2)*100;
$ogone_CURRENCY = $_SESSION['CURRENCY_saved']; 
$ogone_LANGUAGE = $_SESSION['LANGUAGE_saved']; 
$ogone_Logo = 'logo_fr.png'; 
$ogone_WIN3DS = 'MAINW';
$ogone_FLAG3D = 'Y';
$ogone_ACCEPTURL = $_SESSION['ACCEPTURL_saved'];
$ogone_CANCELURL = $_SESSION['CANCELURL_saved'];
$ogone_DECLINEURL = $_SESSION['DECLINEURL_saved'];
$ogone_EXCEPTIONURL = $_SESSION['EXCEPTIONURL_saved'];
$ogone_SHASIGN = "ACCEPTURL=$ogone_ACCEPTURL$ogone_SHA". 
"ALIAS=$ogone_ALIAS$ogone_SHA". 
"ALIASUSAGE=$ogone_ALIASUSAGE$ogone_SHA".
"AMOUNT=$ogone_AMOUNT$ogone_SHA".
"CANCELURL=$ogone_CANCELURL$ogone_SHA".
"CARDNO=$ogone_CARDNO$ogone_SHA".
"CN=$ogone_CN$ogone_SHA".
"CURRENCY=$ogone_CURRENCY$ogone_SHA".
"DECLINEURL=$ogone_DECLINEURL$ogone_SHA".
"ED=$ogone_ED$ogone_SHA".
"EMAIL=$ogone_EMAIL$ogone_SHA".
"EXCEPTIONURL=$ogone_EXCEPTIONURL$ogone_SHA".
"FLAG3D=$ogone_FLAG3D$ogone_SHA".
"LANGUAGE=$ogone_LANGUAGE$ogone_SHA".
"LOGO=$ogone_Logo$ogone_SHA".
"ORDERID=$ogone_ORDERID$ogone_SHA".
"PSPID=$ogone_PSPID$ogone_SHA".
"USERID=$ogone_USERID$ogone_SHA".
"WIN3DS=$ogone_WIN3DS$ogone_SHA";
/* "OWNERADDRESS=$ogone_OWNERADDRESS$ogone_SHA".
"OWNERCTY=$ogone_OWNERCTY$ogone_SHA".
"OWNERTELNO=$ogone_OWNERTELNO$ogone_SHA".
"OWNERTOWN=$ogone_OWNERTOWN$ogone_SHA".
"OWNERZIP=$ogone_OWNERZIP$ogone_SHA". */
$ogone_SHASIGN = sha1($ogone_SHASIGN);
	?>
	
<form method="post" action="https://secure.ogone.com/ncol/prod/orderstandard_utf8.asp" id=form3 name=form3>
        <input type="hidden" name="PSPID"       value="<?php echo $ogone_PSPID;?>">
        <input type="hidden" name="ALIAS"       value="<?php echo $ogone_ALIAS;?>">
        <input type="hidden" name="CARDNO"       value="<?php echo $ogone_CARDNO;?>">
        <input type="hidden" name="ED"       value="<?php echo $ogone_ED;?>">
        <input type="hidden" name="CN"       value="<?php echo $ogone_CN;?>">
        <input type="hidden" name="ORDERID"     value="<?php echo $ogone_ORDERID;?>">
        <input type="hidden" name="AMOUNT"  readonly   value="<?php echo $ogone_AMOUNT;?>">
        <input type="hidden" name="ALIASUSAGE"      value="<?php echo $ogone_ALIASUSAGE;?>">
        <input type="hidden" name="CURRENCY"    value="<?php echo $ogone_CURRENCY;?>">
        <input type="hidden" name="LANGUAGE"    value="<?php echo $ogone_LANGUAGE;?>">
        <!-- <input type="hidden" name="CN" value="<?php echo $ogone_CN; ?>">  Le nom du client (facultatif) -->
        <input type="hidden" name="EMAIL" value="<?php echo $ogone_EMAIL;?>"> 
      <!--  <input type="hidden" name="OWNERZIP" value="<?php echo $ogone_OWNERZIP;?>"> 
        <input type="hidden" name="OWNERADDRESS" value="<?php echo $ogone_OWNERADDRESS;?>">
        <input type="hidden" name="OWNERCTY" value="<?php echo $ogone_OWNERCTY;?>"> 
        <input type="hidden" name="OWNERTOWN" value="<?php echo $ogone_OWNERTOWN; ?>">  
        <input type="hidden" name="OWNERTELNO" value="<?php echo $ogone_OWNERTELNO;?>">  -->
        <input type="hidden" name="USERID" value="<?php echo $ogone_USERID;?>">
		<input type="hidden" name="WIN3DS" value="MAINW">
		<input type="hidden" name="FLAG3D" value="Y">
        <!-- v&eacute;rification avant le paiement : voir S&eacute;curit&eacute; : v&eacute;rification avant le paiement (facultatif) -->
        <input type="hidden" name="SHASIGN" value="<?php echo $ogone_SHASIGN;?>">

        <!-- apparence et impression: voir Apparence de la page de paiement -->
        <input type="hidden" name="TITLE" value="">
        <input type="hidden" name="BGCOLOR" value="">
        <input type="hidden" name="TXTCOLOR" value="">
        <input type="hidden" name="TBLBGCOLOR" value="">
        <input type="hidden" name="TBLTXTCOLOR" value="">
        <input type="hidden" name="BUTTONBGCOLOR" value="">
        <input type="hidden" name="BUTTONTXTCOLOR" value="">
        <input type="hidden" name="LOGO" value="<?php echo $ogone_Logo;?>">
        <input type="hidden" name="FONTTYPE" value="">
        <!-- redirection apr&egrave;s la transaction : voir Feedback au client sur la transaction -->
        <input type="hidden" name="ACCEPTURL" value="<?php echo $ogone_ACCEPTURL;?>">
        <input type="hidden" name="DECLINEURL" value="<?php echo $ogone_DECLINEURL;?>">
        <input type="hidden" name="EXCEPTIONURL" value="<?php echo $ogone_EXCEPTIONURL;?>">
        <input type="hidden" name="CANCELURL" value="<?php echo $ogone_CANCELURL;?>">

<form>
<script language="javascript" type="text/javascript">
				function form3(){try{clearInterval(timerPaypal);}catch(e){}document.form3.submit();}
				var timerPaypal=setInterval("form3();", 50);
			</script>
					<?php 	
	
	}
	else{  
	if($_GET['result']=='exception'){ ?>	
	<style>
table.ncoltable1 td {
    
    color: #000000;
    font-family: Verdana;
}
td.ncoltxtl {
    color: #000000;
    text-align: right;
    font-weight: bold;
    font-family: Verdana;
}
table.ncoltable1 {
   
    color: #000000;
  
}
.line_ht_30{
line-height:30px;
}
.margin_l_10{
margin-left:10px;
}

</style>
<div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre "><?php echo $lang_appabonnement["E_Payment"];?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>	
<div class="col-md-8 col-md-offset-2  col-sm-8 col-sm-offset-2  parentsolo_form_style  parentsolo_mt_40">


				
	  					
						
						<table class="ncoltable1"  border="0" cellpadding="2" cellspacing="0" width="100%" id="ncol_ref">
			
							<tbody>
							
							<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["payment_status"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><b style="text-transform: uppercase;" class="margin_l_10"> <?php echo "Decline"; ?></b></td>
					</tr>
							<tr>
								<td class="ncoltxtl" colspan="1" align="right" width="50%"><small><?php echo $lang_appabonnement["Order_reference"];?> :<!--External reference--></small></td>
								<td class="ncoltxtr" colspan="1" width="50%"><small class="margin_l_10"> <?php echo $Saved_OrderID; ?></small></td>
							</tr>
						<tr><td class="ncoltxtl" colspan="1" align="right" width="50%"><small><?php echo $lang_appabonnement["Customer_Name"];?> :<!--External reference--></small></td>
							<td class="ncoltxtr" colspan="1" width="50%"><small class="margin_l_10"> <?php echo $Saved_CN; ?></small></td>
							</tr>
							
				<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Expiry_date"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $Saved_ED ?></small></td>
					</tr>
					
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Cardno"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $Saved_CardNo; ?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Brand"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $Saved_Brand; ?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["error_msg"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1" st>
						<?php if($Saved_NCErrorCN=='60001057'){?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["60001057_NCERRORCN"]; ?></small>
						<?php } else if($Saved_NCErrorCN=='50001174'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["50001174_NCERRORCN"]; ?></small>						
						<?} else if($Saved_NCErrorCardNo=='30141001'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["30141001_NCERRORCARDNO"]; ?></small>						
						<?} else if($Saved_NCErrorCardNo=='50001069'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["50001069_NCERRORCARDNO"]; ?></small>						
						<?} else if($Saved_NCErrorCardNo=='50001176'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["50001176_NCERRORCARDNO"]; ?></small>						
						<?} else if($Saved_NCErrorCardNo=='50001177'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["50001177_NCERRORCARDNO"]; ?></small>						
						<?} else if($Saved_NCErrorCardNo=='50001178'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["50001178_NCERRORCARDNO"]; ?></small>						
						<?} else if($Saved_NCErrorCVC=='50001090'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["50001090_NCERRORCVC"]; ?></small>						
						<?} else if($Saved_NCErrorCVC=='50001179'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["50001179_NCERRORCVC"]; ?></small>						
						<?} else if($Saved_NCErrorCVC=='50001180'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["50001180_NCERRORCVC"]; ?></small>						
						<?} else if($Saved_NCErrorED=='50001181'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["50001181_NCERRORED"]; ?></small>						
						<?} else if($Saved_NCErrorED=='50001182'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["50001182_NCERRORED"]; ?></small>						
						<?} else if($Saved_NCErrorED=='50001183'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["50001183_NCERRORED"]; ?></small>						
						<?} else if($Saved_NCErrorED=='31061001'){ ?>
						<small class="margin_l_10"> <?php echo $lang_appabonnement["31061001_NCERRORED"]; ?></small>						
						<?php } else{ } ?>
						
						
						</td>
					</tr>
					
	</tbody></table>
	<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12 text-center parentsolo_mt_40">
							<a href="index.php?app=abonnement&action=tarifs&lang=<?echo $_GET['lang'];?>" class="bouton annuler  parentsolo_btn"><?echo $lang_appabonnement["retry"];?></a>
						</div>
					</div>
			</div>
						</div><div class="clear"></div>
	<?php 	}
	}
	}
	public static function paymentdetails(&$customerid,&$CN,&$amount,&$currency,&$PM,&$ACCEPTANCE,&$PAYID,&$NCERROR,&$BRAND,&$SHASIGN,&$CARDNO,&$txn_type,&$ALIAS,&$ECI){
	global $langue;
			include("lang/app_abonnement.".$_GET['lang'].".php");
			//echo $_SESSION['PSPID_saved'];
			
			unset($_SESSION['PSPID_saved']);
unset($_SESSION['ORDERID_saved']); 
unset($_SESSION['Amount_valenc_saved']); 
unset($_SESSION['CN_holder_name_saved']);
unset($_SESSION['Email_address_saved']);
unset($_SESSION['OWNERZIP_saved']);
unset($_SESSION['OWNERADDRESS_saved']);
unset($_SESSION['OWNERCTY_saved']);
unset($_SESSION['OWNERTOWN_saved']);
unset($_SESSION['phone_number_saved']);
unset($_SESSION['USERID_saved']);
unset($_SESSION['CURRENCY_saved']);
unset($_SESSION['LANGUAGE_saved']);
unset($_SESSION['ACCEPTURL_saved']);
unset($_SESSION['DECLINEURL_saved']);
unset($_SESSION['EXCEPTIONURL_saved']);
unset($_SESSION['CANCELURL_saved']);
unset($_SESSION['CVC_number']);
			
		echo $_SESSION['PSPID_saved'];	
	?>
	
						<head>
<style>
table.ncoltable1 td {
    
    color: #000000;
    font-family: Verdana;
}
td.ncoltxtl {
    color: #000000;
    text-align: right;
    font-weight: bold;
    font-family: Verdana;
}
table.ncoltable1 {
   
    color: #000000;
  
}
.line_ht_30{
line-height:30px;
}
.margin_l_10{
margin-left:10px;
}

</style>
						</head>
						<div text="#000000" bgcolor="#FFCC00">
						<div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre "><?php echo $lang_appabonnement["E_Payment"];?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
					
<div class="col-md-8 col-md-offset-2   col-sm-8 col-sm-offset-2 parentsolo_form_style  parentsolo_mt_40">


				
	  					
						
						<table class="ncoltable1"  border="0" cellpadding="2" cellspacing="0" width="100%" id="ncol_ref">
			
							<tbody>
							<?php if($_GET['result']=='Success'){ ?>
							<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["payment_status"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><b style="text-transform: uppercase;" class="margin_l_10"> <?php echo $txn_type; ?></b></td>
					</tr>
							<tr>
								<td class="ncoltxtl" colspan="1" align="right" width="50%"><small><?php echo $lang_appabonnement["Order_reference"];?> :<!--External reference--></small></td>
								<td class="ncoltxtr" colspan="1" width="50%"><small class="margin_l_10"> <?php echo $customerid ?></small></td>
							</tr>
						<tr><td class="ncoltxtl" colspan="1" align="right" width="50%"><small><?php echo $lang_appabonnement["Customer_Name"];?> :<!--External reference--></small></td>
							<td class="ncoltxtr" colspan="1" width="50%"><small class="margin_l_10"> <?php echo $CN ?></small></td>
							</tr>
							<tr><td class="ncoltxtl" colspan="1" align="right" width="50%"><small>
							<?php echo $lang_appabonnement["Amount"];?> :<!--Total to pay--></small></td>
							<td class="ncoltxtr" colspan="1" width="50%">
								<small class="margin_l_10"> <?php echo $amount;?>
							</small>
							</td></tr>
				<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Currency"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $currency ?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Pm"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $PM ?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Acceptance"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $ACCEPTANCE ?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Pay_Id"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $PAYID;?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Brand"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $BRAND ?></small></td>
					</tr>
					<?if($ALIAS!=''){ ?><tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["alias_acc"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $ALIAS ?></small></td>
					</tr><?php } ?>  
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Cardno"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $CARDNO ?></small></td>
					</tr>
					<?php }
else if(($_GET['result']=='canceled') || ($_GET['result']=='decline') || ($_GET['result']=='exception')){?>
<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["payment_status"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><b style="text-transform: uppercase;" class="margin_l_10"> <?php echo $txn_type; ?></b></td>
					</tr>
<tr>
								<td class="ncoltxtl" colspan="1" align="right" width="50%"><small><?php echo $lang_appabonnement["Order_reference"];?> :<!--External reference--></small></td>
								<td class="ncoltxtr" colspan="1" width="50%"><small class="margin_l_10"> <?php echo $customerid ?></small></td>
							</tr>
						<tr><td class="ncoltxtl" colspan="1" align="right" width="50%"><small><?php echo $lang_appabonnement["Customer_Name"];?> :<!--External reference--></small></td>
							<td class="ncoltxtr" colspan="1" width="50%"><small class="margin_l_10"> <?php echo $CN ?></small></td>
							</tr>
							<tr><td class="ncoltxtl" colspan="1" align="right" width="50%"><small>
							<?php echo $lang_appabonnement["Amount"];?> :<!--Total to pay--></small></td>
							<td class="ncoltxtr" colspan="1" width="50%">
								<small class="margin_l_10"><?php echo $amount;?>
							</small>
							</td></tr>
				<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Currency"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $currency ?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Pm"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $PM ?></small></td>
					</tr>
					
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small><?php echo $lang_appabonnement["Pay_Id"];?> :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small class="margin_l_10"> <?php echo $PAYID;?></small></td>
					</tr>
					
					
<?php }					?>
	</tbody></table>
						</div></div>
						<div class="clear"></div>
						
	<?php 	}
}

?>

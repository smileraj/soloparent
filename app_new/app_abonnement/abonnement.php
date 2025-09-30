<?php

	// s�curit�
	defined('JL') or die('Error 401');

	require_once('abonnement.html.php');
			include("lang/app_abonnement.".$_GET['lang'].".php");

	global $action, $user, $langue,$langString;

	if(!$user->id && $action!='infos') {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription&lang='.$_GET['lang']);
	}

	if($_GET['lang']=='fr'){
		$langString = '';
	}else{
		$langString = "_".$_GET['lang'];
	}

	// gestion des messages d'erreurs
	$messages	= [];


	// controller
	switch($action) {

		case 'methode':
			$methode_id		= (int)JL::getVar('methode_id', 1);
			$abonnement_id 	= (int)JL::getVar('abonnement_id', 2, true);

			// paypal
			if($methode_id == 1) {

				$custom 	= JL::getVar('custom', '');
				if($custom == '') {

					// si pas log
					if(!$user->id) {
						JL::redirect('index.php?app=profil&action=inscription&'.$langue);
					}

					abonnementPaypalForm($abonnement_id);

				} else {

					abonnementPaypalReturn($custom);

				}
			} 
			elseif($methode_id == 4) {
				$custom 	= JL::getVar('custom', '');
				if($custom == '') {
					// si pas log
					if(!$user->id) {
						JL::redirect('index.php?app=profil&action=inscription&'.$langue);
					}
					abonnementPostFinanceForm($abonnement_id);
				} else {
					abonnementPaypalReturn($custom);
					}

} 
else {

				abonnementPaiment($methode_id, $abonnement_id);

			}
		break;

		case 'tarifs':
			abonnementTarifs();
			//HTML_abonnement::abonnementServiceIndisponible();
		break;
		
		case 'infos':
			HTML_abonnement::abonnementInfos();
		break; 
		case 'SavedCarddetails':
			SavedCarddetails();
		break;
        case 'details':
			paymentdetails();
		break;
		default:
			JL::loadApp('404');
		break;

	}

	// affiche la page des tarifs
	function abonnementTarifs() {
		global $langue, $langString;
		global $db;

		
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 106";
		$debut = $db->loadObject($query);

		// affiche la page
		HTML_abonnement::abonnementTarifs($debut);

	}


	// formulaire de paiement paypal
	function abonnementPaypalForm($abonnement_id) {
		global $langue;
		global $db, $user;

		// variables
		$time = time();

		// tarifs de l'abonnement d�sir�
		$query = "SELECT * FROM abonnement_description WHERE id = '".(int)$abonnement_id."' AND active = 1 LIMIT 0,1";
		$row = $db->loadObject($query);

		// abonnement inconnu
		if(!$row) {
			JL::redirect('index.php?app=abonnement&action=tarifs&'.$langue);
		}
		
		$query = "SELECT *"
		." FROM abonnement_paypal"
		." WHERE user_id = '".$user->id."' AND valide = 1"
		;
		$abo = $db->loadObject($query);
		
		if(!$abo){

			// conserve la demande de transaction
			$query = "INSERT INTO abonnement_paypal SET"
			." user_id = '".$user->id."',"
			." date_enregistrement = '".date('Y-m-d H:i:s', $time)."',"
			." date_souscription = '',"
			." date_dernier_renouvellement = '',"
			." date_annulation = '',"
			." valide = 0," //0 = non valid�, 1 = en cours, 2 = annul�
			." intitule_abo = '".$row->nom."',"
			." montant = '".$row->montant."',"
			." duree_paypal = '".$row->duree_paypal."',"
			." unite_duree_paypal = '".$row->unite_duree_paypal."',"
			." nb_paiement = 0"
			;
			$db->query($query);
			$row->paypal_id = $db->insert_id();


			// g�n�ration de la valeur de retour 'custom'
			$row->custom 	= base64_encode(MD5($user->username.$user->gid.date('Y-m-d H:i:s', $time)).":".$row->paypal_id);


			HTML_abonnement::paypalForm($row);
		}else{
			
			HTML_abonnement::paypalImpossible();
			
		}

	}


	// page de retour de paypal
	function abonnementPaypalReturn($custom) {
		global $langue;
		global $db;

		// r�cup les valeurs qui �taient pass�es dans custom
		$arguments 		= explode(":", base64_decode((string) $custom));
		$md5			= $arguments[0]; 		// md5 de v�rfication
		$paypal_id		= isset($arguments[1]) ? (int)$arguments[1] : 0; 	// SQL: paypal.id

		// r�cup la dur�e d'abo
		$query = "SELECT duree_paypal, unite_duree_paypal"
		." FROM abonnement_paypal"
		." WHERE id = '".$paypal_id."'"
		." LIMIT 0,1"
		;
		$duree_abo = $db->loadObject($query);

		HTML_abonnement::paypalReturn($duree_abo);

	}


	// methode de paiement standard
	function abonnementPaiment($methode_id, $abonnement_id) {
		global $langue, $langString;
		global $db;

		// tarifs de l'abonnement d�sir�
		$query = "SELECT duree_non_paypal, montant FROM abonnement_description WHERE id = '".(int)$abonnement_id."' AND active = 1 LIMIT 0,1";
		$row = $db->loadObject($query);

		// abonnement ou m�thodes inconnu(e)(s)
		if(!$row || !in_array($methode_id, [2,3])) {
			JL::redirect('index.php?app=abonnement&action=tarifs&'.$langue);
		}
		
		if($methode_id == 2){
			
			$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 104";
			$paiement = $db->loadObject($query);
			
			$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 105";
			$debut = $db->loadObject($query);
			
		}else{
			
			$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 107";
			$paiement = $db->loadObject($query);
			
			$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 108";
			$debut = $db->loadObject($query);
			
		}

		HTML_abonnement::abonnementForm($methode_id, $paiement, $debut, $row->duree_non_paypal, $row->montant);

	}

	function abonnementPostFinanceForm($abonnement_id) {
		global $langue;
		global $db, $user;

		// variables
		$time = time();

		// tarifs de l'abonnement d�sir�
		$query = "SELECT * FROM abonnement_description WHERE id = '".(int)$abonnement_id."' AND active = 1 LIMIT 0,1";
		$row1 = $db->loadObject($query);

		// abonnement inconnu
		if(!$row1) {
			JL::redirect('index.php?app=abonnement&action=tarifs&'.$langue);
		}
		$query = "SELECT *"
		." FROM abonnemnet_postfinance"
		." WHERE user_id = '".$user->id."' AND valide = 1";
		$abo = $db->loadObject($query);
		if(!$abo){

		
			// conserve la demande de transaction
			$query = "INSERT INTO abonnemnet_postfinance SET"
			." user_id = '".$user->id."',"
			." date_enregistrement = '".date('Y-m-d H:i:s', $time)."',"
			." date_souscription = '',"
			." date_dernier_renouvellement = '',"
			." date_annulation = '',"
			." valide = 0," //0 = non valid�, 1 = en cours, 2 = annul�
			." intitule_abo = '".$row1->nom."',"
			." montant = '".$row1->montant."',"
			." duree_paypal = '".$row1->duree_paypal."',"
			." unite_duree_paypal = '".$row1->unite_duree_paypal."',"
			." nb_paiement = 0"
			;
			$db->query($query);
			$row->paypal_id = $db->insert_id();

		$query_val = "SELECT u.id, u.username,up.user_id,u.email,IFNULL(pc.nom_".$_GET['lang'].", '') AS canton,IFNULL(pv.nom, '') AS ville, up.genre, up.ville_id,up.photo_defaut, up.nb_enfants,up.adresse,up.telephone,CURRENT_DATE, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)< RIGHT(up.naissance_date,5)) AS age"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		." WHERE u.id = '".$user->id."'"
		." LIMIT 0,1";
		$row = $db->loadObject($query_val);

			// g�n�ration de la valeur de retour 'custom'
			$row->custom 	= base64_encode(MD5($user->username.$user->gid.date('Y-m-d H:i:s', $time)).":".$row->paypal_id);


			HTML_abonnement::postfinanceForm($row,$row1);
		}else{
			
			HTML_abonnement::paypalImpossible();
			
		}

	}
	
	//savedcards
	function SavedCarddetails() {
		global $langue;
		global $db;
		$Saved_OrderID=$_GET['OrderID'];
		$Saved_CN=$_GET['CN'];
		$Saved_NCErrorCN=$_GET['NCErrorCN'];
		$Saved_CardNo=$_GET['CardNo'];
		$Saved_Brand=$_GET['Brand'];
		$Saved_NCErrorCardNo=$_GET['NCErrorCardNo'];
		$Saved_CVC=$_GET['CVC'];
		$Saved_NCErrorCVC=$_GET['NCErrorCVC'];
		$Saved_ED=$_GET['ED'];
		$Saved_NCErrorED=$_GET['NCErrorED'];
		$Saved_NCError=$_GET['NCError'];
		$Saved_Alias=$_GET['Alias'];
		$Saved_status=$_GET['status'];
		$Saved_SHASign=$_GET['SHASign'];
		$custormersplit_id=explode('_',(string) $Saved_OrderID);
$userid=$custormersplit_id[0];
		$time = time();
		$query = "INSERT INTO acc_saved_cards SET"
			." acc_saved_orderid = '".$Saved_OrderID."',"
			." acc_saved_cn = '".$Saved_CN."',"
			." acc_saved_cardno = '".$Saved_CardNo."',"
			." acc_saved_ncerrorcn = '".$Saved_NCErrorCN."',"
			." acc_saved_brand = '".$Saved_Brand."',"
			." acc_saved_ncerrorcardno = '".$Saved_NCErrorCardNo."',"
			." acc_saved_cvc = '".$Saved_CVC."',"
			." acc_saved_ncerrorcvc = '".$Saved_NCErrorCVC."',"
			." acc_saved_ed = '".$Saved_ED."',"
			." acc_saved_ncerrored = '".$Saved_NCErrorED."',"
			." acc_saved_ncerror = '".$Saved_NCError."',"
			." acc_saved_alias = '".$Saved_Alias."',"
			." acc_saved_status = '".$Saved_status."',"
			." acc_saved_shasign = '".$Saved_SHASign."',"
			." acc_saved_create_date = '".date('Y-m-d H:i:s', $time)."',"
			." acc_saved_ref_no = '".$_SESSION['CVC_number']."',"
			." acc_saved_user_id = '".$userid."'";
			//." acc_saved_option = '".$userid."',"
			$db->query($query);
			$query_val = "SELECT u.id, u.username,up.user_id,u.email,IFNULL(pc.nom_".$_GET['lang'].", '') AS canton,IFNULL(pv.nom, '') AS ville, up.genre, up.ville_id,up.photo_defaut, up.nb_enfants,up.adresse,up.telephone,CURRENT_DATE, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)< RIGHT(up.naissance_date,5)) AS age"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		." WHERE u.id = '".$userid."'"
		." LIMIT 0,1";
		$row = $db->loadObject($query_val);
		
		HTML_abonnement::SavedCarddetails($Saved_OrderID,$Saved_CN,$Saved_NCErrorCN,$Saved_CardNo,$Saved_Brand,$Saved_NCErrorCardNo,$Saved_CVC,$Saved_NCErrorCVC,$Saved_ED,$Saved_NCErrorED,$Saved_NCError,$Saved_Alias,$Saved_status,$Saved_SHASign,$row);	
		}
	//savedcards 
	
	
	
	
function paymentdetails(){
global $db;
$txn_type=$_GET['result'];
$customerid=$_GET['orderID'];
$currency=$_GET['currency'];
$amount=$_GET['amount'];
$PM=$_GET['PM'];
$ACCEPTANCE=$_GET['ACCEPTANCE'];
$STATUS=$_GET['STATUS'];
$CN=$_GET['CN'];
$PAYID=$_GET['PAYID'];
$NCERROR=$_GET['NCERROR'];
$BRAND=$_GET['BRAND'];
$SHASIGN=$_GET['SHASIGN'];
$CARDNO=$_GET['CARDNO'];
$ALIAS=$_GET['ALIAS'];
$ECI=$_GET['ECI'];
$custormersplit=explode('_',(string) $customerid);
$userid=$custormersplit[0];
$query1="SELECT up.nom as nome, up.prenom, ap.date_enregistrement,ap.id as apid,ap.valide, ap.montant, ad.nom
FROM user_profil up, abonnemnet_postfinance ap, abonnement_description ad
WHERE up.user_id = ap.user_id
AND ad.nom = ap.intitule_abo
AND up.user_id ='".$userid."' order by ap.id desc LIMIT 1 ";
$abonnement_paypal_id= $db->loadObject($query1);
$time = time();
$query="SELECT orderid,payid from postfinance where orderid='$customerid' and payid='$PAYID' and user_id='$userid'";
$loadresults = $db->loadResult($query);
if($loadresults==''){
if($ALIAS!=''){
			$alias_query="acc_alias = '".$ALIAS."', acc_eci = '".$ECI."',";
			}
			else{
			$alias_query="acc_alias = ' ', acc_eci = ' ',";
			}
$query = "INSERT INTO postfinance SET"
			." user_id = '".$userid."',"
			." abonnement_id = '".$abonnement_paypal_id->apid."',"
			." datetime = '".date('Y-m-d H:i:s', $time)."',"
			." valide = '".$abonnement_paypal_id->valide."',"
			." montant = '".$abonnement_paypal_id->montant."',"
			." nom = '".$abonnement_paypal_id->nome."',"
			." prenom = '".$abonnement_paypal_id->prenom."'," 
			." result = '".$txn_type."'," 
			." orderid = '".$customerid."'," 
			." currency = '".$currency."'," 
			." pm = '".$PM."'," 
			." acceptance = '".$ACCEPTANCE."'," 
			." status = '".$STATUS."'," 
			." cn = '".$CN."'," 
			." payid = '".$PAYID."'," 
			." ncerror = '".$NCERROR."'," 
			." brand = '".$BRAND."'," 
			." cardno = '".$CARDNO."'," 
			.$alias_query
			." shasign = '".$SHASIGN."'";
			$db->query($query);
			
	// config
	$notify_email	= 'developer@esales.in';
	$dev_email		= 'developer@esales.in';
	$server			= 'ssl://www.paypal.com';
			
				if($txn_type == 'Success'){
					// r�cup les d�tails du paiement
					$query = "SELECT *"
					." FROM abonnemnet_postfinance"
					." WHERE id = '$abonnement_paypal_id->apid'"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// r�cup les d�tails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.email, u.gid, IF(us.gold_limit_date < NOW(), '0000-00-00', us.gold_limit_date) AS date_reference, us.gold_limit_date"
					." FROM user AS u"
					." INNER JOIN user_stats AS us ON us.user_id = u.id"
					." WHERE u.id = '".(int)$abonnement_paypal->user_id."'"
					;
					$userProfil = $db->loadObject($queryUser);
					
					//if($abonnement_paypal && $userProfil && $mc_currency == $currency_check && $mc_gross == $abonnement_paypal->montant){
						
						// pas de date de fin d'abo
						if($userProfil->date_reference == '0000-00-00') {
							$date	= explode('-', date('Y-m-d'));
						} else {
							// parse la date de fin d'abonnement
							$date	= explode('-', (string) $userProfil->date_reference);
			
						}
	                    $jour	= $date[2];
						$mois	= $date[1];
						$annee	= $date[0];
						
						if($abonnement_paypal->unite_duree_paypal == 'M'){
							$gold_limit_date	= date('Y-m-d', mktime(0, 0, 0, $mois+ $abonnement_paypal->duree_paypal, $jour, $annee));
						}elseif($abonnement_paypal->unite_duree_paypal == 'Y'){
							$gold_limit_date	= date('Y-m-d', mktime(0, 0, 0, $mois, $jour, $annee + $abonnement_paypal->duree_paypal));
						}
						if($payment_date){
							$arg = explode(" PST", $payment_date);
							$arg = explode(" PDT", $arg[0]);
							
							$arg1 = explode(", ", $arg[0]);
							$annee_payment_date = $arg1[1];
							
							$arg2 = explode(" ",$arg1[0]);
							$horaire_payment_date = $arg2[0];
							$jour_payment_date = $arg2[2];
							
							$mois_payment_date = match ($arg2[1]) {
                                'Feb' => '02',
                                'Mar' => '03',
                                'Apr' => '04',
                                'May' => '05',
                                'Jun' => '06',
                                'Jul' => '07',
                                'Aug' => '08',
                                'Sep' => '09',
                                'Oct' => '10',
                                'Nov' => '11',
                                'Dec' => '12',
                                default => '01',
                            };
							
							$date_payment = $annee_payment_date.'-'.$mois_payment_date.'-'.$jour_payment_date.' '.$horaire_payment_date;
						}
						// met � jour le status de la demande de transaction
						$query = "UPDATE abonnemnet_postfinance SET"
						." date_dernier_renouvellement = '".$date_payment."',"
						." nb_paiement = ".($abonnement_paypal->nb_paiement + 1).""
						." WHERE id = '".(int)$abonnement_paypal_id->apid."'";
						$db->query($query);
						
						// met � jour la date limite d'abonnement
						$query = "UPDATE user_stats SET gold_limit_date = '".$gold_limit_date."' WHERE user_id = '".$userProfil->id."'";
						$db->query($query);
						
						if($abonnement_paypal->duree_paypal==1 && $abonnement_paypal->unite_duree_paypal=='M') {
							//1 mois
							JL::addPoints(19, $userProfil->id);
							$points = "L'abonn&eacute; a b&eacute;n&eacute;fici&eacute; des points correspondant &agrave; 1 mois";
							
						}elseif($abonnement_paypal->duree_paypal==3 && $abonnement_paypal->unite_duree_paypal=='M'){
							//3 mois
							JL::addPoints(1, $userProfil->id);
							$points = "L'abonn&eacute; a b&eacute;n&eacute;fici&eacute; des points correspondant &agrave; 3 mois";
						
						}elseif($abonnement_paypal->duree_paypal==6 && $abonnement_paypal->unite_duree_paypal=='M'){
							//6 mois
							JL::addPoints(2, $userProfil->id);
							$points = "L'abonn&eacute; a b&eacute;n&eacute;fici&eacute; des points correspondant &agrave; 6 mois";
						
						}elseif($abonnement_paypal->duree_paypal==1 && $abonnement_paypal->unite_duree_paypal=='Y'){
						
							//1 an
							JL::addPoints(3, $userProfil->id);
							$points = "L'abonn&eacute; a b&eacute;n&eacute;fici&eacute; des points correspondant &agrave; 1 an";
						
						}
						
						if(!$points){
							$nonpoints = "L'abonn&eacute; n'a pas b&eacute;n&eacute;fici&eacute; des points concernant son abonnement";
						}
						
						JL::mail($notify_email, '['.$_SERVER['REMOTE_ADDR'].'] VERIFIED', "Paiement d'un abonnement<br /><br />Username: ".$userProfil->username."<br />Abonnement: ".$abonnement_paypal->intitule_abo."<br />Paiement: CHF ".$currency."<br />Date limite d'abonnement chang&eacute;e de ".$userProfil->gold_limit_date." &agrave; ".$gold_limit_date."<br /><br />".$points."<br /><br />".$nonpoints,false);
						$notify_email1 = $userProfil->email;
						if($_GET['lang']=='en'){
$confrm_subject="solocircl.com Payment Details";
			 $message_con="<table cellpadding='0' cellspacing='0' style='width:590px;margin:auto;text-align:left;font-family:Arial, Verdana, Helvetica, sans-serif;font-size:12px;color:#000; background-color:#FFF;border:2px solid #ccc;'>
		<tr><td align='center' style='width:590px; background-color:#fff; height:120px'><img src='http://www.parentsolo.swiss/images/mail/header-en.jpg'/></td></tr>
		<tr><td style='text-align:justify;padding:10px 30px 10px 30px;'>
		<p><br />Hello <strong>".$CN."</strong>,<br /><br /><br />
		<strong>Payment of a subscription</strong><br /><br />
		<strong >Username </strong>: ".$userProfil->username."<br /><br />
		<strong >Amount </strong>: ".$amount."<br /><br />
		<strong >Pay Id </strong>: ".$PAYID."<br /><br />
		<strong >Order reference </strong>: ".$customerid."<br/><br />
		<strong >Subscription </strong>: ".$abonnement_paypal->intitule_abo."<br /><br />
		<strong >Paiement </strong>: CHF ".$currency."<br />Subscription deadline changed from ".$userProfil->gold_limit_date." to ".$gold_limit_date."<br /><br />".$points."<br /><br />
		<b>For technical reasons, the cancellation of the subscription can not be made during the 24 hours after the purchase of the subscription and the 48 hours before the due date of the current subscription, unless you benefit from an offer test.</b>  
		</p></td></tr>
		</table>";
	} else if($_GET['lang']=='de'){
	$confrm_subject="solocircl.com Betalingsdetails";
			 $message_con="	<table cellpadding='0' cellspacing='0' style='width:590px;margin:auto;text-align:left;font-family:Arial, Verdana, Helvetica, sans-serif;font-size:12px;color:#000; background-color:#FFF;border:2px solid #ccc;'>
		<tr><td align='center' style='width:590px; background-color:#fff; height:120px'><img src='http://www.parentsolo.swiss/images/mail/header-en.jpg'/></td></tr>
		<tr><td style='text-align:justify;padding:10px 30px 10px 30px;'>
		<p><br />Hello <strong>".$CN."</strong>,<br /><br /><br />
		<strong>De betaling van een abonnement</strong><br /><br />
		<strong >Gebruikersnaam </strong>: ".$userProfil->username."<br /><br />
		<strong >Prijs </strong>: ".$amount."<br /><br />
		<strong >Pay Id </strong>: ".$PAYID."<br /><br />
		<strong >Order code </strong>: ".$customerid."<br/><br />
		<strong >Inschrijving </strong>: ".$abonnement_paypal->intitule_abo."<br /><br />
		<strong >Betaling </strong>: CHF ".$currency."<br />Date veranderd abonnement limiet ".$userProfil->gold_limit_date." tot ".$gold_limit_date."<br /><br />".$points."<br /><br />
		<b>Om technische redenen kan de annulering van het abonnement niet gedaan worden binnen de 24 uur na de aankoop van het abonnement en de 48 uur voor de vervaldag van het huidige abonnement, tenzij u profiteert van een offertest.</b>  
		</p></td></tr>
		</table>";
	
	}
	else{
	$confrm_subject="solocircl.com D�tails de paiement";
			 $message_con="	<table cellpadding='0' cellspacing='0' style='width:590px;margin:auto;text-align:left;font-family:Arial, Verdana, Helvetica, sans-serif;font-size:12px;color:#000; background-color:#FFF;border:2px solid #ccc;'>
		<tr><td align='center' style='width:590px; background-color:#fff; height:120px'><img src='http://www.parentsolo.swiss/images/mail/header-en.jpg'/></td></tr>
		<tr><td style='text-align:justify;padding:10px 30px 10px 30px;'>
		<p><br />Hello <strong>".$CN."</strong>,<br /><br /><br />
		<strong>Paiement d'un abonnement</strong><br /><br />
		<strong >Username </strong>: ".$userProfil->username."<br /><br />
		<strong >Montant </strong>: ".$amount."<br /><br />
		<strong >Pay Id </strong>: ".$PAYID."<br /><br />
		<strong >R�f�rence de commande </strong>: ".$customerid."<br/><br />
		<strong >Abonnement </strong>: ".$abonnement_paypal->intitule_abo."<br /><br />
		<strong >Paiement </strong>: CHF ".$currency."<br />Date limite d'abonnement chang&eacute;e de ".$userProfil->gold_limit_date." &agrave; ".$gold_limit_date."<br /><br />".$points."<br /><br />
		<b>Pour des raisons techniques, la r�siliation de l�abonnement ne pourra �tre faite pendant les 24h apr�s l�achat de l�abonnement et les 48h avant la date d��ch�ance de l�abonnement en cours, sauf si vous b�n�ficiez d'une offre d'essai.   </b>  
		</p></td></tr>
		</table>";
	}
						JL::mail($notify_email1, $confrm_subject, $message_con,false);
						
						
					//}
				}elseif($txn_type == 'canceled'){
					
					// r�cup les d�tails du paiement
					$query = "SELECT user_id, date_enregistrement, intitule_abo, montant, nb_paiement"
					." FROM abonnemnet_postfinance"
					." WHERE id = '$abonnement_paypal_id->apid'"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// r�cup les d�tails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid, IF(us.gold_limit_date < NOW(), '0000-00-00', us.gold_limit_date) AS date_reference"
					." FROM user AS u"
					." INNER JOIN user_stats AS us ON us.user_id = u.id"
					." WHERE u.id = '".(int)$abonnement_paypal->user_id."'"
					." LIMIT 0,1"
					;
					$userProfil = $db->loadObject($queryUser);
					
					if($reattempt){
						
						$tentative = "Oui";
						
					}else{
						
						$tentative = "Non";
						
					}
				
					JL::mail($notify_email, '['.$_SERVER['REMOTE_ADDR'].'] VERIFIED', "Echec du paiement d'un abonnement<br /><br />Username: ".$userProfil->username."<br />Abonnement: ".$abonnement_paypal->intitule_abo."<br />Nouvelle tentative en attente: ".$tentative);
					JL::mail($dev_email, '['.$_SERVER['REMOTE_ADDR'].'] VERIFIED', "Echec du paiement d'un abonnement<br /><br />Username: ".$userProfil->username."<br />Abonnement: ".$abonnement_paypal->intitule_abo."<br />Nouvelle tentative en attente: ".$tentative);
		
				}					
			}
		
	
	HTML_abonnement::paymentdetails($customerid,$CN,$amount,$currency,$PM,$ACCEPTANCE,$PAYID,$NCERROR,$BRAND,$SHASIGN,$CARDNO,$txn_type,$ALIAS,$ECI);	
	}
	
?>

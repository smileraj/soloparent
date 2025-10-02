<?php 	// PHP 4.1

	// config
	require_once('config.php');

	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');

	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');
	$db	= new DB();
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
$custormersplit=preg_split('#_#m',(string) $customerid);
$userid=$custormersplit[0];
$query="SELECT email,id from user where username='$customername'";
$user= $db->loadObject($query);
$query1="SELECT up.nom as nome, up.prenom, ap.date_enregistrement,ap.id as apid,ap.valide, ap.montant, ad.nom
FROM user_profil up, abonnemnet_postfinance ap, abonnement_description ad
WHERE up.user_id = ap.user_id
AND ad.nom = ap.intitule_abo
AND up.user_id ='".$userid."' order by ap.id desc LIMIT 1 ";
$abonnement_paypal_id= $db->loadObject($query1);
$time = time();
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
			." shasign = '".$SHASIGN."'";
			$db->query($query);
	// config
	/* $notify_email	= 'paypal@solocircl.com';
	$dev_email		= 'm.jombart@babybook.ch';
	$server			= 'ssl://www.paypal.com'; */
	
	$notify_email	= 'developer@esales.in';
	$dev_email		= 'developer@esales.in';
	$server			= 'ssl://www.paypal.com';


	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';

	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes((string) $value));
		$req .= "&$key=$value";
	}

	// post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
	
	if (!$fp) {
		// HTTP ERROR
		JL::mail($dev_email, '['.$_SERVER['REMOTE_ADDR'].'] ERROR', 'Connexion impossible au serveur: '.$server);
	} else {
		fwrite ($fp, $header . $req);
		while (!feof($fp)) {
		$res = fgets ($fp, 128);
			if (strcmp ($res, "INVALID") == 0) {
				$message = "";
				foreach($_POST as $key => $value){
					$message .= $key." = ". $value." <br />";
				}
				
				$prenom	  				= JL::getVar('first_name', '', true);
				$nom						= JL::getVar('last_name', '', true);
				$invoice 					= JL::getVar('invoice', '');
				$subscr_date			= JL::getVar('subscr_date','');
				$payment_date			= JL::getVar('payment_date','');
				$mc_amount3			= JL::getVar('mc_amount3','');
				$currency_check		= 'CHF';
				$mc_currency			= JL::getVar('mc_currency', '');
				$mc_gross			= JL::getVar('mc_gross', '');
				$recurring				= JL::getVar('recurring', '');
				$reattempt				= JL::getVar('reattempt', '');
				//$reference_paypal	= JL::getVar('subscr_id', '', true);
				$reference_paypal	= JL::getVar('ipn_track_id', '', true);
				
				// récup les valeurs qui étaient passées dans custom
				//$arguments 							= explode(":", base64_decode($user->id));
			
				//$md5										= $arguments[0]; 	// md5 de vérfication
				//$abonnement_paypal_id 		= $arguments[1]; 	// référence du paiement, à parser
				if($txn_type == 'subscr_signup'){
					
					// récup les détails du paiement
					$query = "SELECT user_id, date_enregistrement, intitule_abo, montant"
					." FROM abonnemnet_postfinance"
					." WHERE id = $abonnement_paypal_id->id"
					." LIMIT 0,1";
					
					$abonnement_paypal	= $db->loadObject($query);
					
					// récup les détails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid, IF(us.gold_limit_date < NOW(), '1970-01-01', us.gold_limit_date) AS date_reference"
					." FROM user AS u"
					." INNER JOIN user_stats AS us ON us.user_id = u.id"
					." WHERE u.id = '".(int)$abonnement_paypal->user_id."'"
					." LIMIT 0,1"
					;
					$userProfil = $db->loadObject($queryUser);
					
					if($abonnement_paypal && $userProfil && $md5 == MD5($userProfil->username.$userProfil->gid.$abonnement_paypal->date_enregistrement)){
						
						if($subscr_date){
							$arg = explode(" PST", $subscr_date);
							$arg = explode(" PDT", $arg[0]);
							
							$arg1 = explode(", ", $arg[0]);
							$annee_subscr_date = $arg1[1];
							
							$arg2 = explode(" ",$arg1[0]);
							$horaire_subscr_date = $arg2[0];
							$jour_subscr_date = $arg2[2];
							
							$mois_subscr_date = match ($arg2[1]) {
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
							
							$date_souscription = $annee_subscr_date.'-'.$mois_subscr_date.'-'.$jour_subscr_date.' '.$horaire_subscr_date;
							
							// met à jour le status de la demande de transaction
							$query = "UPDATE abonnemnet_postfinance SET"
							." valide = 1,"
							." date_souscription = '".$date_souscription."',"
							." nom_paypal = '".$nom."',"
							." prenom_paypal = '".$prenom."',"
							." reference_paypal = '".$reference_paypal."'"
							." WHERE id = '".(int)$abonnement_paypal_id."'";
							$db->query($query);
							
						}
					}
					
					JL::mail($notify_email, '['.$_SERVER['REMOTE_ADDR'].'] VERIFIED', "Souscription d'un abonnement<br /><br />Username: ".$userProfil->username."<br />Abonnement: ".$abonnement_paypal->intitule_abo."<br />Date de souscription: ".$jour_subscr_date."-".$mois_subscr_date."-".$annee_subscr_date."");
					
					
					
				}elseif($txn_type == 'Success'){
					// récup les détails du paiement
					$query = "SELECT *"
					." FROM abonnemnet_postfinance"
					." WHERE id = '$abonnement_paypal_id->apid'"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// récup les détails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid, IF(us.gold_limit_date < NOW(), '1970-01-01', us.gold_limit_date) AS date_reference, us.gold_limit_date"
					." FROM user AS u"
					." INNER JOIN user_stats AS us ON us.user_id = u.id"
					." WHERE u.id = '".(int)$abonnement_paypal->user_id."'"
					." LIMIT 0,1"
					;
					$userProfil = $db->loadObject($queryUser);
					
					//if($abonnement_paypal && $userProfil && $mc_currency == $currency_check && $mc_gross == $abonnement_paypal->montant){
						
						// pas de date de fin d'abo
						if($userProfil->date_reference == '1970-01-01') {
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
						// met à jour le status de la demande de transaction
						$query = "UPDATE abonnemnet_postfinance SET"
						." date_dernier_renouvellement = '".$date_payment."',"
						." nb_paiement = ".($abonnement_paypal->nb_paiement + 1).""
						." WHERE id = '".(int)$abonnement_paypal_id->apid."'";
						$db->query($query);
						
						// met à jour la date limite d'abonnement
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
						?>
						<html>
						<head>
<style>
table.ncoltable1 td {
    background-color: #F5F5F5;
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
    background-color: #F5F5F5;
    color: #000000;
    border: 1px solid #000000;
}
</style>
						</head>
						<body text="#000000" bgcolor="#FFCC00">
						<h2 style="text-align:center">E-Payment Details</h2>
						<table class="ncoltable1"  border="0" cellpadding="2" cellspacing="0" width="95%" id="ncol_ref">
			
							<tbody><tr>
								<td class="ncoltxtl" colspan="1" align="right" width="50%"><small>Order reference :<!--External reference--></small></td>
								<td class="ncoltxtr" colspan="1" width="50%"><small><?php echo $customerid ?></small></td>
							</tr>
						<tr>
								<td class="ncoltxtl" colspan="1" align="right" width="50%"><small>Customer Name :<!--External reference--></small></td>
								<td class="ncoltxtr" colspan="1" width="50%"><small><?php echo $CN ?></small></td>
							</tr>

				<tr>
					
							<td class="ncoltxtl" colspan="1" align="right" width="50%"><small>
							Amount :<!--Total to pay-->
							
							</small></td>
							<td class="ncoltxtr" colspan="1" width="50%">
								<small><?php echo $amount;?>
							</small>
							</td>
					
				</tr>
				
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small>Currency :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small><?php echo $currency ?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small>Pm :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small><?php echo $PM ?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small>Acceptance :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small><?php echo $ACCEPTANCE ?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small>Pay Id:<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small><?php echo $PAYID;?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small>Ncerror :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small><?php echo NCERROR;?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small>Brand :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small><?php echo $BRAND ?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small>ShaSign :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small><?php echo $SHASIGN ?></small></td>
					</tr>
					<tr>
						<td class="ncoltxtl" colspan="1" align="right"><small>Cardno :<!--Beneficiary--></small></td>
						<td class="ncoltxtr" colspan="1"><small><?php echo $CARDNO ?></small></td>
					</tr>
	</tbody></table>
						</body>
						</html>
						<?php 						JL::mail($notify_email, '['.$_SERVER['REMOTE_ADDR'].'] VERIFIED', "Paiement d'un abonnement<br /><br />Username: ".$userProfil->username."<br />Abonnement: ".$abonnement_paypal->intitule_abo."<br />Paiement: CHF ".$mc_gross."<br />Date limite d'abonnement chang&eacute;e de ".$userProfil->gold_limit_date." &agrave; ".$gold_limit_date."<br /><br />".$points."<br /><br />".$nonpoints,false);
						
					//}
				}elseif($txn_type == 'canceled'){
					
					// récup les détails du paiement
					$query = "SELECT user_id, date_enregistrement, intitule_abo, montant, nb_paiement"
					." FROM abonnemnet_postfinance"
					." WHERE id = '$abonnement_paypal_id->apid'"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// récup les détails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid, IF(us.gold_limit_date < NOW(), '1970-01-01', us.gold_limit_date) AS date_reference"
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
		
				}elseif($txn_type == 'subscr_cancel'){
					
					// récup les détails du paiement
					$query = "SELECT user_id, date_enregistrement, intitule_abo, montant, nb_paiement"
					." FROM abonnemnet_postfinance"
					." WHERE id = '".(int)$abonnement_paypal_id."'"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// récup les détails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid, IF(us.gold_limit_date < NOW(), '1970-01-01', us.gold_limit_date) AS date_reference"
					." FROM user AS u"
					." INNER JOIN user_stats AS us ON us.user_id = u.id"
					." WHERE u.id = '".(int)$abonnement_paypal->user_id."'"
					." LIMIT 0,1"
					;
					$userProfil = $db->loadObject($queryUser);
				
					if($abonnement_paypal && $userProfil){
						
						if($subscr_date){
							$arg = explode(" PST", $subscr_date);
							$arg = explode(" PDT", $arg[0]);
							
							$arg1 = explode(", ", $arg[0]);
							$annee_subscr_date = $arg1[1];
							
							$arg2 = explode(" ",$arg1[0]);
							$horaire_subscr_date = $arg2[0];
							$jour_subscr_date = $arg2[2];
							
							$mois_subscr_date = match ($arg2[1]) {
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
							
							$date_annulation = $annee_subscr_date.'-'.$mois_subscr_date.'-'.$jour_subscr_date.' '.$horaire_subscr_date;
							
							// met à jour le status de la demande de transaction
							$query = "UPDATE abonnemnet_postfinance SET"
							." valide = 2,"
							." date_annulation = '".$date_annulation."'"
							." WHERE id = '".(int)$abonnement_paypal_id."'";
							$db->query($query);
							
						}
					}
					
					JL::mail($notify_email, '['.$_SERVER['REMOTE_ADDR'].'] VERIFIED', "Annulation d'un abonnement<br /><br />Username: ".$userProfil->username."<br />Abonnement: ".$abonnement_paypal->intitule_abo."<br />Date d'annulation: ".$jour_subscr_date."-".$mois_subscr_date."-".$annee_subscr_date."");
				}
			}
			else if (strcmp ($res, "VERIFIED") == 0) {
				foreach($_POST as $key => $value){
					$message .= $key." = ". $value." \n";
				}
				
				JL::mail($notify_email, '['.$_SERVER['REMOTE_ADDR'].'] INVALID', "Paiement refus&eacute; (fonds insuffisants, carte de cr&eacute;dit refus&eacute;e, etc..)<br /><br />".$message,false);
				
			}
		}
		fclose ($fp);
	}
?>

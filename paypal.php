<?php 	// PHP 4.1

	// config
	require_once('config.php');

	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');

	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');
	$db	= new DB();

	// config
	$notify_email	= 'paypal@solocircl.com';
	$dev_email		= 'm.jombart@babybook.ch';
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

	// assign posted variables to local variables
	$item_name = $_POST['item_name'];
	$item_number = $_POST['item_number'];
	$payment_status = $_POST['payment_status'];
	$payment_amount = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$txn_id = $_POST['txn_id'];
	$receiver_email = $_POST['receiver_email'];
	$payer_email = $_POST['payer_email'];

	if (!$fp) {
		// HTTP ERROR
		JL::mail($dev_email, '['.$_SERVER['REMOTE_ADDR'].'] ERROR', 'Connexion impossible au serveur: '.$server);
	} else {
		fputs ($fp, $header . $req);
		while (!feof($fp)) {
		$res = fgets ($fp, 1024);
			if (strcmp ($res, "VERIFIED") == 0) {
				
				$message = "";
				foreach($_POST as $key => $value){
					$message .= $key." = ". $value." <br />";
				}
				
				$prenom	  				= JL::getVar('first_name', '', true);
				$nom						= JL::getVar('last_name', '', true);
				$custom 					= JL::getVar('custom', '0:0');
				$invoice 					= JL::getVar('invoice', '');
				
				$txn_type					= JL::getVar('txn_type','');
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
				$arguments 							= explode(":", base64_decode($custom));
				$md5										= $arguments[0]; 	// md5 de vérfication
				$abonnement_paypal_id 		= $arguments[1]; 	// référence du paiement, à parser
				
				
				if($txn_type == 'subscr_signup'){
					
					// récup les détails du paiement
					$query = "SELECT user_id, date_enregistrement, intitule_abo, montant"
					." FROM abonnement_paypal"
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
							$query = "UPDATE abonnement_paypal SET"
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
					
					
					
				}elseif($txn_type == 'subscr_payment'){
					
					// récup les détails du paiement
					$query = "SELECT *"
					." FROM abonnement_paypal"
					." WHERE id = '".(int)$abonnement_paypal_id."'"
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
					
					if($abonnement_paypal && $userProfil && $mc_currency == $currency_check && $mc_gross == $abonnement_paypal->montant){
						
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
						$query = "UPDATE abonnement_paypal SET"
						." date_dernier_renouvellement = '".$date_payment."',"
						." nb_paiement = ".($abonnement_paypal->nb_paiement + 1).""
						." WHERE id = '".(int)$abonnement_paypal_id."'";
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
						
						JL::mail($notify_email, '['.$_SERVER['REMOTE_ADDR'].'] VERIFIED', "Paiement d'un abonnement<br /><br />Username: ".$userProfil->username."<br />Abonnement: ".$abonnement_paypal->intitule_abo."<br />Paiement: CHF ".$mc_gross."<br />Date limite d'abonnement chang&eacute;e de ".$userProfil->gold_limit_date." &agrave; ".$gold_limit_date."<br /><br />".$points."<br /><br />".$nonpoints,false);
						
					}
				}elseif($txn_type == 'subscr_failed'){
					
					// récup les détails du paiement
					$query = "SELECT user_id, date_enregistrement, intitule_abo, montant, nb_paiement"
					." FROM abonnement_paypal"
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
					." FROM abonnement_paypal"
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
							$query = "UPDATE abonnement_paypal SET"
							." valide = 2,"
							." date_annulation = '".$date_annulation."'"
							." WHERE id = '".(int)$abonnement_paypal_id."'";
							$db->query($query);
							
						}
					}
					
					JL::mail($notify_email, '['.$_SERVER['REMOTE_ADDR'].'] VERIFIED', "Annulation d'un abonnement<br /><br />Username: ".$userProfil->username."<br />Abonnement: ".$abonnement_paypal->intitule_abo."<br />Date d'annulation: ".$jour_subscr_date."-".$mois_subscr_date."-".$annee_subscr_date."");
				}
			}
			else if (strcmp ($res, "INVALID") == 0) {
				
				foreach($_POST as $key => $value){
					$message .= $key." = ". $value." \n";
				}
				JL::mail($notify_email, '['.$_SERVER['REMOTE_ADDR'].'] INVALID', "Paiement refus&eacute; (fonds insuffisants, carte de cr&eacute;dit refus&eacute;e, etc..)<br /><br />".$message,false);
			}
		}
		fclose ($fp);
	}
?>

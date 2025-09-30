<?php
session_start();
// config
	require_once('config.php');	
	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');
	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');
	$db	= new DB();

	echo $queryUser = "SELECT u.id, u.username, u.gid, IF(us.gold_limit_date < NOW(), '0000-00-00', us.gold_limit_date) AS date_reference, ascard.acc_saved_ref_no, 	ascard.acc_saved_cardno, ascard.acc_saved_brand, ascard.acc_saved_cn, ascard.acc_saved_status, abpf.unite_duree_paypal,  ascard.acc_saved_ed, abpf.montant,  ascard.acc_saved_alias,  us.gold_limit_date"
					." FROM (select id, username, gid FROM user union all select id, username, gid from user_suppr) AS u"
					." INNER JOIN acc_saved_cards AS ascard ON ascard.acc_saved_user_id = u.id "
					." INNER JOIN user_stats AS us ON us.user_id =ascard.acc_saved_user_id"
					." INNER JOIN postfinance AS pf ON pf.orderid = ascard.acc_saved_orderid "
					 ." INNER JOIN abonnemnet_postfinance AS abpf ON abpf.user_id = ascard.acc_saved_orderid " 
					." WHERE ascard.acc_saved_status = '0' and us.gold_limit_date < NOW() and abpf.nb_paiement GROUP BY ascard.acc_saved_user_id HAVING COUNT(*) "
					;
					
					$userProfil_val = $db->loadObjectList($queryUser);					
					

foreach($userProfil_val as $userProfil) { 
$file_number='File'.random_int(10,10000);
$acc_saved_alias=$userProfil->acc_saved_alias;
$_SESSION['acc_saved_alias']=$userProfil->acc_saved_alias;
				$username=$userProfil->acc_saved_cn;
				$_SESSION['username']=$userProfil->acc_saved_cn;
					$acc_saved_ed=$userProfil->acc_saved_ed;
					$_SESSION['acc_saved_ed']=$userProfil->acc_saved_ed;
					$acc_saved_brand=$userProfil->acc_saved_brand;
					$_SESSION['acc_saved_brand']=$userProfil->acc_saved_brand;
					$acc_saved_cardno=$userProfil->acc_saved_cardno;
					$_SESSION['acc_saved_cardno']=$userProfil->acc_saved_cardno;
					$acc_saved_ref_no=$userProfil->acc_saved_ref_no;
					$montant=(($userProfil->montant)*100);
					$_SESSION['montant']=(($userProfil->montant)*100);
					$order_id_user=$userProfil->id."_00".random_int(100,10000);
					$_SESSION['order_id_user']=$order_id_user;
					$_SESSION['user_id']=$userProfil->id;
					$amount_type=$userProfil->unite_duree_paypal;
					if($acc_saved_alias!=''){
					$query = "INSERT INTO save_card_batch SET"
			." batch_filename = '".$file_number."',"
			." betch_saved_cn = '".$username."',"
			." batch_saved_ed = '".$acc_saved_ed."',"
			." batch_saved_alias = '".$acc_saved_alias."',"
			." batch_saved_brand = '".$acc_saved_brand."',"
			." batch_saved_cardno = '".$acc_saved_cardno."'," 
			." batch_saved_ref_no = '".$acc_saved_ref_no."'," 
			." batch_montant = '".$montant."'," 
			." batch_order_id_user = '".$_SESSION['order_id_user']."'," 
			." batch_amount_type = '".$amount_type."'," 
			." batch_runing_date = NOW()";
			$db->query($query);
			$row->batch_id = $db->insert_id();
			if($row->batch_id!='1' && $acc_saved_alias!=''){
			echo $loopfileVal= $montant.";CHF;".$acc_saved_brand.";".$acc_saved_cardno.";".$acc_saved_ed.";".$order_id_user.";;".$username.";;;;;;;;;".$acc_saved_alias.";;;;;;;;;;;;;;;;;;9;\r\n";
		 $urlVal= 'https://e-payment.postfinance.ch/ncol/prod/AFU_agree.asp';	

		$file = fopen(SITE_PATH."/processFile.txt","w");
		fwrite($file,$loopfileVal);
		fclose($file);
		$filename = SITE_PATH.'processFile.txt';
		if (function_exists('curl_file_create')) { 
				$cFile = curl_file_create($filename, $mimetype = 'text/plain', $postfilename = 'test_name');
		} else { 
				$cFile = '@' . realpath($filename);
		}
		$post = ['FILE' => $cFile,'FILE_REFERENCE' => 'File3599','PSPID' => 'Parentsolo','USERID' => 'parentsoloCH','PSWD' => 'Septembre2017*','TRANSACTION_CODE' => 'ATR','OPERATION' => 'SAL','NB_PAYMENTS' => '1','REPLY_TYPE' => 'XML','MODE' => 'SYNC','PROCESS_MODE' => 'SEND'];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_URL, $urlVal);			
			curl_setopt($ch, CURLOPT_POST, 1);			
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_ENCODING, "UTF-8") ;
			echo $output = curl_exec($ch);
			curl_close($ch);
			//print_r($output);			
			$xmlrespond = new SimpleXMLElement($output);
			$fileId = $xmlrespond->SEND_FILE->FILEID; 
			$guId = $xmlrespond->SEND_FILE->GUID; 
			$paymentCount = $xmlrespond->SEND_FILE->SUMMARY->NB_PAYMENTS;
if($fileId!=''){
	$query = "INSERT INTO batch_send_file SET"
			." batch_send_file_fileid = '".$fileId."',"
			." batch_send_file_guid = '".$guId."',"
			." batch_send_file_nbpayment = '".$paymentCount."',"
			." batch_common_id = '".$_SESSION['order_id_user']."',"			
			." batch_send_file_date = NOW()";
			$db->query($query);
			$row->batch_id = $db->insert_id();
			
			if($row->batch_id!='1' && $fileId!=''){
					$urlVal= 'https://e-payment.postfinance.ch/ncol/prod/AFU_agree.asp';	
					$post1 = ['PSPID' => 'Parentsolo','USERID' => 'parentsoloCH','PSWD' => 'Septembre2017*','REPLY_TYPE' =>'XML','MODE' =>'SYNC','PFID'=>$fileId,'PROCESS_MODE' =>'PROCESS'];
						
					$ch1 = curl_init();
					curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($ch1, CURLOPT_URL, $urlVal);			
					curl_setopt($ch1, CURLOPT_POST, 1);
					//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);			
					curl_setopt($ch1, CURLOPT_POSTFIELDS, $post1);
					curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch1, CURLOPT_ENCODING, "UTF-8");
					echo $output1 = curl_exec($ch1);	
					curl_close($ch1);
					echo $output1;
					echo $xmlrespond = new SimpleXMLElement($output1);
								$FILEID=  $xmlrespond->PROCESSING->FILEID;
								$NB_PAYMENTS=  $xmlrespond->PROCESSING->SUMMARY->NB_PAYMENTS;
								$OK_PAYMENTS=  $xmlrespond->PROCESSING->SUMMARY->OK_PAYMENTS;
								$RANGE_START=  $xmlrespond->PROCESSING->SUMMARY->RANGE_START;
								$RANGE_STOP=  $xmlrespond->PROCESSING->SUMMARY->RANGE_STOP;
								
								$FILE_ERROR=  $xmlrespond->FILE_ERROR;
								$PARAMS_ERROR=  $xmlrespond->PARAMS_ERROR;
								$NCERROR=  $xmlrespond->NCERROR;
								if($FILEID != ''){
								$query = "INSERT INTO batch_process_file SET"
					." batch_process_fileid = '".$FILEID."',"
					." batch_process_nbpayments = '".$NB_PAYMENTS."',"
					." batch_process_okpayments = '".$OK_PAYMENTS."',"
					." batch_process_range_start = '".$RANGE_START."',"
					." batch_process_range_stop = '".$RANGE_STOP."',"
					." batch_process_common_payment_id = '".$_SESSION['order_id_user']."',"			
					." batch_process_date = NOW()";
					$db->query($query);
					$row->batch_id = $db->insert_id();
					if($row->batch_id!='1'){
					//update value in live site
					
					
$txn_type='Success';
$customerid=$_SESSION['order_id_user'];
$currency='CHF';
$amount=$_SESSION['montant'];
$PM=$_SESSION['acc_saved_ed'];
$CN=$_SESSION['username'];
$BRAND=$_SESSION['acc_saved_brand'];
$CARDNO=$_SESSION['acc_saved_cardno'];
$ALIAS=$_SESSION['acc_saved_alias'];
$ECI='9';
$custormersplit=explode('_',$customerid);
$userid=$custormersplit[0];
$query1="SELECT up.nom as nome, up.prenom, ap.date_enregistrement,ap.id as apid,ap.valide, ap.montant, ad.nom
FROM user_profil up, abonnemnet_postfinance ap, abonnement_description ad
WHERE up.user_id = ap.user_id
AND ad.nom = ap.intitule_abo
AND up.user_id ='".$_SESSION['user_id']."' order by ap.id desc LIMIT 1 ";
$abonnement_paypal_id= $db->loadObject($query1);
$time = time();
$query="SELECT orderid,payid from postfinance where orderid='$customerid' and payid='$PAYID' and user_id='$userid'";
$loadresults = $db->loadResult($query);
if($loadresults==''){

			$alias_query="acc_alias = '".$ALIAS."', acc_eci = '".$ECI."',";
			
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
			." cn = '".$CN."'," 
			." brand = '".$BRAND."'," 
			.$alias_query
			." cardno = '".$CARDNO."'";
			$db->query($query);
			
	// config
	$notify_email	= 'paypal@solocircl.com';
	$dev_email		= 'm.jombart@babybook.ch';
	$server			= 'ssl://www.paypal.com';
			
				if($txn_type == 'Success'){
					// récup les détails du paiement
					$query = "SELECT *"
					." FROM abonnemnet_postfinance"
					." WHERE id = '$abonnement_paypal_id->apid'"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// récup les détails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid, IF(us.gold_limit_date < NOW(), '0000-00-00', us.gold_limit_date) AS date_reference, us.gold_limit_date"
					." FROM (select id, username, gid FROM user union all select id, username, gid from user_suppr) AS u"
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
							$arg = explode(" PST", (string) $payment_date);
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
						
						JL::mail($notify_email, '['.$_SERVER['REMOTE_ADDR'].'] VERIFIED', "Paiement d'un abonnement<br /><br />Username: ".$userProfil->username."<br />Abonnement: ".$abonnement_paypal->intitule_abo."<br />Paiement: CHF ".$currency."<br />Date limite d'abonnement chang&eacute;e de ".$userProfil->gold_limit_date." &agrave; ".$gold_limit_date."<br /><br />".$points."<br /><br />".$nonpoints,false);
						
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
					$queryUser = "SELECT u.id, u.username, u.gid, IF(us.gold_limit_date < NOW(), '0000-00-00', us.gold_limit_date) AS date_reference"
					." FROM (select id, username, gid FROM user union all select id, username, gid from user_suppr) AS u"
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
					
					
					
					
					//end update value in live site
					echo "success success";
					}
					else{
					echo "success else";
					}
						}
						else{
								 $xmlrespond = new SimpleXMLElement($output);
								 $PARAMS_ERROR=  $xmlrespond->PARAMS_ERROR;
								 $NCERROR=  $xmlrespond->NCERROR;
								if($NCERROR != ''){
								$query = "INSERT INTO batch_process_error SET"
					." 	batch_process_error_params_error = '".$PARAMS_ERROR."',"
					." batch_process_error_ncerror = '".$NCERROR."',"
					." batch_process_common_id = '".$_SESSION['order_id_user']."',"		
					." batch_process_error_date = NOW()";
					$db->query($query);
					
					$row->batch_id = $db->insert_id();
					if($row->batch_id!='1'){
					echo "error success";
					}
					else{
					echo "error else";
					}
						}
								} 
					
					
			}
			else{
			echo "send success else";
			}

}
else{
}
unset($_SESSION['order_id_user']);
unset($_SESSION['montant']);
unset($_SESSION['user_id']);
unset($_SESSION['acc_saved_ed']);
unset($_SESSION['acc_saved_brand']);
unset($_SESSION['acc_saved_cardno']);
unset($_SESSION['acc_saved_alias']);
unset($_SESSION['username']); 
			}
			else{
			}
			}
			
}

			/* $post1 = array('PSPID' => 'parentsoloTEST','USERID' => 'parentsoloEsales','PSWD' => 'zxn=b31zl@','REPLY_TYPE' =>'XML','MODE' =>'SYNC','PFID'=>'1235372','PROCESS_MODE' =>'PROCESS');
				$options = array(
				CURLOPT_URL => $url,
				CURLOPT_HEADER => true,
				CURLOPT_POST => 1,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_POSTFIELDS => $post1,
				CURLOPT_RETURNTRANSFER => true
				);  
	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_URL, $urlVal);			
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);			
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_ENCODING, "UTF-8") ;
			$output = curl_exec($ch);	
			curl_close($ch);
			echo $output;
			echo $xmlrespond = new SimpleXMLElement($output);
						echo $FILEID=  $xmlrespond->PROCESSING->FILEID;
						echo $NB_PAYMENTS=  $xmlrespond->PROCESSING->SUMMARY->NB_PAYMENTS;
						echo $OK_PAYMENTS=  $xmlrespond->PROCESSING->SUMMARY->OK_PAYMENTS;
						echo $RANGE_START=  $xmlrespond->PROCESSING->SUMMARY->RANGE_START;
						echo $RANGE_STOP=  $xmlrespond->PROCESSING->SUMMARY->RANGE_STOP;
						
						echo $FILE_ERROR=  $xmlrespond->FILE_ERROR;
						echo $PARAMS_ERROR=  $xmlrespond->PARAMS_ERROR;
						echo $NCERROR=  $xmlrespond->NCERROR;
						if($FILEID != ''){
						$query = "INSERT INTO batch_process_file SET"
			." batch_process_fileid = '".$FILEID."',"
			." batch_process_nbpayments = '".$NB_PAYMENTS."',"
			." batch_process_okpayments = '".$OK_PAYMENTS."',"
			." batch_process_range_start = '".$RANGE_START."',"
			." batch_process_range_stop = '".$RANGE_STOP."',"
			." batch_process_common_payment_id = '".$common_batch_id."',"			
			." batch_process_date = NOW()";
			$db->query($query);
			$row->batch_id = $db->insert_id();
			if($row->batch_id!='1'){
			echo "success success";
			}
			else{
			echo "success else";
			}
				}
				else{
						echo $xmlrespond = new SimpleXMLElement($output);
						echo $PARAMS_ERROR=  $xmlrespond->PARAMS_ERROR;
						echo $NCERROR=  $xmlrespond->NCERROR;
						if($NCERROR != ''){
						$query = "INSERT INTO batch_process_error SET"
			." 	batch_process_error_params_error = '".$PARAMS_ERROR."',"
			." batch_process_error_ncerror = '".$NCERROR."',"
			." batch_process_common_id = '".$common_batch_id."',"		
			." batch_process_error_date = NOW()";
			$db->query($query);
			
			$row->batch_id = $db->insert_id();
			if($row->batch_id!='1'){
			echo "error success";
			}
			else{
			echo "error else";
			}
				}
						} */
						

?>


<?php
// config
	require_once('config.php');
	
	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');

	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');
	$db	= new DB();

	
	
	
	echo $queryUser = "SELECT u.id, u.username, u.gid, IF(us.gold_limit_date < NOW(), '1970-01-01', us.gold_limit_date) AS date_reference, ascard.acc_saved_ref_no, 
	ascard.acc_saved_cardno, ascard.acc_saved_brand, ascard.acc_saved_cn, ascard.acc_saved_status, abpf.unite_duree_paypal,  ascard.acc_saved_ed, abpf.montant,  ascard.acc_saved_alias,  us.gold_limit_date"
					." FROM user AS u"
					." INNER JOIN acc_saved_cards AS ascard ON ascard.acc_saved_user_id = u.id "
					." INNER JOIN user_stats AS us ON us.user_id =ascard.acc_saved_user_id"
					." INNER JOIN postfinance AS pf ON pf.orderid = ascard.acc_saved_orderid "
					 ." INNER JOIN abonnemnet_postfinance AS abpf ON abpf.user_id = ascard.acc_saved_orderid " 
					." WHERE ascard.acc_saved_status = '0' and us.gold_limit_date < NOW() GROUP BY ascard.acc_saved_user_id HAVING COUNT(*) "
					;
					$userProfil_val = $db->loadObjectList($queryUser);
					
					
					
	
		?>
		<!---->
		
		
<!--<form action='https://e-payment.postfinance.ch/ncol/test/AFU_agree.asp' method=POST  id=form4 name=form4>-->
<form onsubmit="submitForm()"  method="POST"  id="form4" name="form4">
<textarea name=FILE >
<?php 
$file_number='File'.random_int(10,10000);
$i=0;
foreach($userProfil_val as $userProfil) { 
$acc_saved_alias=$userProfil->acc_saved_alias;
				$username=$userProfil->acc_saved_cn;
					$acc_saved_ed=$userProfil->acc_saved_ed;
					$acc_saved_brand=$userProfil->acc_saved_brand;
					$acc_saved_cardno=$userProfil->acc_saved_cardno;
					$acc_saved_ref_no=$userProfil->acc_saved_ref_no;
					$montant=(($userProfil->montant)*100);
					$order_id_user=$userProfil->id."_00".random_int(100,10000);
					$amount_type=$userProfil->unite_duree_paypal;
					if($acc_saved_alias==''){
					$query = "INSERT INTO save_card_batch SET"
			." batch_filename = '".$file_number."',"
			." betch_saved_cn = '".$username."',"
			." batch_saved_ed = '".$acc_saved_ed."',"
			." batch_saved_alias = '".$acc_saved_alias."',"
			." batch_saved_brand = '".$acc_saved_brand."',"
			." batch_saved_cardno = '".$acc_saved_cardno."'," 
			." batch_saved_ref_no = '".$acc_saved_ref_no."'," 
			." batch_montant = '".$montant."'," 
			." batch_order_id_user = '".$order_id_user."'," 
			." batch_amount_type = '".$amount_type."'," 
			." batch_runing_date = NOW()";
			$db->query($query);
			}
			echo $montant.";CHF;".$acc_saved_brand.";".$acc_saved_cardno.";".$acc_saved_ed.";".$order_id_user.";;".$username.";;;;;;;;;".$acc_saved_alias.";;;;;;;;;;;;;;;;;;9;\r\n";
$i++;
			}
			
			?>
</textarea>

<input type="text" name="FILE_REFERENCE" value='<?php echo $file_number;?>'>
<input type="text" name="PSPID" value='parentsoloTEST'>
<input type="text" name="USERID" value='parentsoloEsales'> 
<input type="text" name="PSWD" value='zxn=b31zl@'> 
<input type="text" name="TRANSACTION_CODE" value='ATR'> 
<input type="text" name="OPERATION" value='SAL'> 
<input type="text" name="NB_PAYMENTS" value='<?echo $i; ?>'>
<input type="text" name="REPLY_TYPE" value='XML'>
<!--<input type="text" name="PFID" value='tst'>-->
<input type="text" name="MODE" value='SYNC'>
<input type="text" name="PROCESS_MODE" value='SEND'>
<input type="submit" name="Submit" value="Submit"/>
</form>


<form action='https://e-payment.postfinance.ch/ncol/test/payment_download_ncp.asp' method=POST  id=form5 name=form5>

<input type="text" name="PSPID" value='parentsoloTEST'>
<input type="text" name="USERID" value='parentsoloEsales'> 
<input type="text" name="PSWD" value='Abcd@345678'>
<input type="text" name="ID" value='1235389'>
<!--<input type="text" name="GUID" value='5F859767B573A3A4D285A377E01BF5EA0F53540F'>-->
<input type="text" name="LEVEL" value='ORDERLEVEL'>
<!--<input type="text" name="ORDERID" value='14362_00539'>-->
<input type="text" name="ofd" value='01'> 
<input type="text" name="ofm" value='06'> 
<input type="text" name="ofy" value='2017'>
<input type="text" name="otd" value='24'>
<input type="text" name="otm" value='06'>
<input type="text" name="oty" value='2017'>
<input type="text" name="ST1" value='1'>
<input type="text" name="FORMAT" value='Delimited'>

<input type="submit" name="Submit" value="Submit"/>
</form>
<form action='https://e-payment.postfinance.ch/ncol/test/payment_download_ncp.asp' method=POST  id=form5 name=form5>

<input type="text" name="PSPID" value='parentsoloTEST'>
<input type="text" name="USERID" value='parentsoloEsales'> 
<input type="text" name="PSWD" value='zxn=b31zl@'>
<input type="text" name="ID" value='1235376'>
<input type="text" name="LEVEL" value='HISTLEVEL'>
<input type="text" name="AFD" value='01'> 
<input type="text" name="AFM" value='06'> 
<input type="text" name="AFY" value='2017'>
<input type="text" name="ATD" value='24'>
<input type="text" name="ATM" value='06'>
<input type="text" name="ATY" value='2017'>
<input type="text" name="ST1" value='1'>
<input type="text" name="FORMAT" value='Delimited'>

<input type="submit" name="Submit" value="Submit"/>
</form>
<form action='https://e-payment.postfinance.ch/ncol/test/payment_download_ncp.asp' method=POST  id=form5 name=form5>

<input type="text" name="PSPID" value='parentsoloTEST'>
<input type="text" name="USERID" value='parentsoloEsales'> 
<input type="text" name="PSWD" value='zxn=b31zl@'>
<input type="text" name="ID" value='1235376'>
<input type="text" name="LEVEL" value='HISTLEVEL'>
<input type="text" name="AFD" value='01'> 
<input type="text" name="AFM" value='06'> 
<input type="text" name="AFY" value='2017'>
<input type="text" name="ATD" value='24'>
<input type="text" name="ATM" value='06'>
<input type="text" name="ATY" value='2017'>
<input type="text" name="ST1" value='1'>
<input type="text" name="FORMAT" value='Delimited'>

<input type="submit" name="Submit" value="Submit"/>
</form>



			
<!--
<form action="https://e-payment.postfinance.ch/ncol/test/AFU_agree.asp" method=POST  id=form4 name=form4>
<input type=text name=PSPID value="parentsoloTEST">
<input type=text name=USERID value="parentsoloEsales"> 
<input type=text name=PSWD value="zxn=b31zl@"> 
<input type=text name=REPLY_TYPE value="XML">
<input type=text name=MODE value="SYNC">
<input type=text name=PFID value="1234812">
<input type=text name=PROCESS_MODE value="CHECKED">
</form>

<form action="https://e-payment.postfinance.ch/ncol/test/AFU_agree.asp" method=POST  id=form4 name=form4>
<input type=text name=PSPID value="parentsoloTEST">
<input type=text name=USERID value="parentsoloEsales"> 
<input type=text name=PSWD value="zxn=b31zl@"> 
<input type=text name=REPLY_TYPE value="XML">
<input type=text name=MODE value="SYNC">
<input type=text name=PFID value="1234822">
<input type=text name=PROCESS_MODE value="PROCESS">
</form>-->
<script language="javascript" type="text/javascript">
console.log("Test");
console.log(window.location);
console.log(window.location.origin);
console.log(window.location.href);
console.log(window.location.replace);
function submitForm(){

console.log("Test");
//var formObj = document.getElementById("form4");
//console.log(formObj);
var http = new XMLHttpRequest();

var url = "https://e-payment.postfinance.ch/ncol/test/AFU_agree.asp";
var params = "lorem=ipsum&name=binny";
http.open("POST", url, true);
var formObj = document.getElementById("form4");
console.log(formObj);
//Send the proper header information along with the request
http.setRequestHeader("Content-type", "text/plain");
http.setRequestHeader("Access-Control-Allow-Origin", "*");

http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
        console.log(http.responseText);
    }
}


http.send(formObj);

return formObj;

}

			//function form4(){try{clearInterval(timerPaypal);}catch(e){}document.form4.submit();}
				//var timerPaypal=setInterval("form4();", 5000);
			</script>
<?php if($txn_type == 'Success'){
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
				}
?>


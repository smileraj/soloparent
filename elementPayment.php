

<?php
//$currentDay = date('d');
 $jsFile = 'newPayment';
	$paid = '';
	$hasLateRent = '';

	// Get the Current Month
    $currentMonth = date('F');
	// Get the Current Day
    $currentDay = date('d');
	// Get the Current Date
    $currentDate = date("Y-m-d");
	
// Add a New Payment information //

	$creval = "
		SELECT
            tenants.propertyId,
			tenants.tenantLastName,
			tenants.tenantFirstName,
			tenants.tenantEmail,
            tenants.leaseId,
			tenants.tenantAddress,
			tenants.tenantPhone,
			tenants.accountnumber,
			properties.propertyName,
            properties.propertyName,
			properties.propertyAddress,
			properties.propertyRate,
			properties.latePenalty,
			properties.fuelsurcharge,
			properties.security,
			properties.coaptax,
			properties.garage,
			properties.startxcredits,
			properties.repairs,
			properties.subletfee,
			properties.veteranstxcredits,
			leases.leaseTerm,
			leases.leaseStart,
            DATE_FORMAT(leases.leaseEnd,'%M %d, %Y') AS leaseEnd,
			assignedproperties.adminId,
			admins.adminFirstName,
			admins.adminLastName
		FROM
			tenants
            LEFT JOIN properties ON tenants.propertyId = properties.propertyId
            LEFT JOIN leases ON tenants.leaseId = leases.leaseId
			LEFT JOIN assignedproperties ON tenants.propertyId = assignedproperties.propertyId
			LEFT JOIN admins ON assignedproperties.adminId = admins.adminId
		WHERE
            tenants.tenantId = ".$tenantId;
	$creval1 = mysqli_query($mysqli, $creval) or die('Error, retrieving Property Data failed. ' . mysqli_error());
    $row1 = mysqli_fetch_assoc($creval1);
	$leaseID=$row1['leaseId'];
	 $accidnumber=$row1['accountnumber'];
	 $tntName=$row1['tenantFirstName']." ".$row1['tenantLastName'];
	$propertyID=$row1['propertyId']; //echeck
	
	$paymentType=$_GET['paymentype'];
	
	 //Get all value in rentcharges table for unpaid values
	$unpaiddetails ="SELECT chargeid, propertyname, MIN(chargedate) as firestdate, MAX(chargedate) as lastdate, chargemonth,
	SUM(propertyRate) as propertyRate, latePenalty, SUM(fuelsurcharge) as fuelsurcharge, SUM(security) as security, SUM(coaptax) as coaptax,
	SUM(garage) as garage, SUM(startxcredits) as startxcredits, SUM(repairs) as repairs, SUM(subletfee) as subletfee,
	SUM(veteranstxcredits) as veteranstxcredits, SUM(scrietaxcredits) as scrietaxcredits, SUM(schetax) as schetax,
	SUM(moveinoutfees) as moveinoutfees, SUM(rentals) as rentals, SUM(securitydeposits) as securitydeposits,
    SUM(fines) as fines, SUM(disabilityrent) as disabilityrent, SUM(legalfee) as legalfee, SUM(taxrebatecredit) as taxrebatecredit,
	PaymentStatus, TransactionID FROM rentcharges WHERE  tenantId = ".$tenantId." and PaymentStatus='unpaid'";
	$rentunpaid  = mysqli_query($mysqli, $unpaiddetails) or die('Error, retrieving Late Rent Data failed. ' . mysqli_error());
	$unpaid = mysqli_fetch_assoc($rentunpaid);
	// get the number of months between last paid month and current month
	 $day = $unpaid['firestdate'];
	  $day11 = $unpaid['lastdate'];
	  
	  
	  //loop exe
	$unpaiddetails1 ="SELECT chargeid FROM rentcharges WHERE  tenantId = ".$tenantId." and PaymentStatus='unpaid'";
	$rentunpaid1  = mysqli_query($mysqli, $unpaiddetails1) or die('Error, retrieving Late Rent Data failed. ' . mysqli_error());
    $RentMonth = "";
	  while ($topic = mysqli_fetch_assoc($rentunpaid1)) {
		 $RentMonth .= $topic['chargeid'] ."-";
	  }
	   $RentMonth = trim($RentMonth); 
   //End loop exe

 
$datetime1 = date_create($day);
$datetime2 = date_create($currentDate);
$interval = date_diff($datetime1, $datetime2);

$count= $interval->format('%m');
$date=array();
for ($i = 0; $i <= $count; $i++)
{
	
	$datetime1 =  $day;
	//echo $datetime1;
	$datetime2 = $currentDate;
	$date[]=date('F', strtotime('+'.$i.'month', strtotime($datetime1)));
}



// get the list of months between last paid month and current month

	// $datetime1= implode(",",  $date);
	// if($currentMonth == $date[0])
	// {
	//	$premonth = $date[0];
	//	
	// }else
	// {
	//	$premonth = $date[0];
	//	$befomonth = '-' . $date[$count];
	// }
	
	
if($count == '0' ){
//echo date("F",strtotime($unpaid['firestdate']));	
 $first =  date("F",strtotime($unpaid['lastdate']));
}else{
 $first = date("F",strtotime($unpaid['firestdate']));	
 $last = date("F",strtotime($unpaid['lastdate']));
}



	
// calculate late month penalty  fee
	if($currentDay<=5)
	{
		 $pen = ($count-1) * $unpaid['latePenalty'];
		 $panalty = $currencySym.format_amount($pen, 2);
	
	}else{
		 $pen = $count * $unpaid['latePenalty'];
		 $panalty = $currencySym.format_amount($pen, 2);
	}
	
	

//echo $unpaid['sumval'];
	 $calmainamount =  $unpaid['propertyRate'];
	   $latemaintainfee = $currencySym.format_amount($calmainamount, 2);
	  
	  $fuelsurcharge= $unpaid['fuelsurcharge'];
	  $fuelsurcharge1 = $currencySym.format_amount($fuelsurcharge, 2);
	  
	  $security = $unpaid['security'];
	   $security1 = $currencySym.format_amount($security, 2);
	  
	  $coaptax = $unpaid['coaptax'];
	    $coaptax1 = $currencySym.format_amount($coaptax, 2);
	  
	  $garage = $unpaid['garage'];
	    $garage1 = $currencySym.format_amount($garage, 2);
	  
	  $startxcredits = $unpaid['startxcredits'];
	   $startxcredits1 = $currencySym.format_amount($startxcredits, 2);
	  
      $repairs = $unpaid['repairs'];
	 $repairs1 = $currencySym.format_amount($repairs, 2);
	  
      $subletfee = $unpaid['subletfee'];
	  $subletfee1 = $currencySym.format_amount($subletfee, 2);
	  
      $veteranstxcredits= $unpaid['veteranstxcredits'];
	   $veteranstxcredits1 = $currencySym.format_amount($veteranstxcredits, 2);
	  
	  $latepenalty=$unpaid['latePenalty'];
	  
	  $scrietaxcredits= $unpaid['scrietaxcredits'];
	  $scrietaxcredits1 = $currencySym.format_amount($scrietaxcredits, 2);
	  
	  $schetax= $unpaid['schetax'];
	  $schetax1 = $currencySym.format_amount($schetax, 2);
	  
	  $moveinoutfees= $unpaid['moveinoutfees'];
	  $moveinoutfees1 = $currencySym.format_amount($moveinoutfees, 2);
	  
	  $rentals= $unpaid['rentals'];
	  $rentals1 = $currencySym.format_amount($rentals, 2);
	  
	  $securitydeposits= $unpaid['securitydeposits'];
	  $securitydeposits1 = $currencySym.format_amount($securitydeposits, 2);
	  
	  $fines= $unpaid['fines'];
	  $fines1 = $currencySym.format_amount($fines, 2);
	  
	  $disabilityrent= $unpaid['disabilityrent'];
	  $disabilityrent1 = $currencySym.format_amount($disabilityrent, 2);
	  $legalfee= $unpaid['legalfee'];
	  $legalfee1 = $currencySym.format_amount($legalfee, 2);
	  $taxrebatecredit= $unpaid['taxrebatecredit'];
	  $taxrebatecredit1 = $currencySym.format_amount($taxrebatecredit, 2);
	  
	
	
	 if($paymentType=="CreditCard"){
		 // calculate amount and late fee 
	 if($count == '0' || $currentDay <= '5'){
		 $totalDuees_val = $calmainamount + $fuelsurcharge + $security + $coaptax + $garage + $startxcredits + $repairs + $subletfee + $veteranstxcredits + $scrietaxcredits + $schetax + $moveinoutfees + $rentals + $securitydeposits + $fines + $disabilityrent +$legalfee + $taxrebatecredit;
		  $processfee_val1=($totalDuees_val * 0.03);
		  $processfee_val=round($processfee_val1, 2);
		  $totalDuees1=$processfee_val+$totalDuees_val;
		 $totalDuees = $currencySym.format_amount($totalDuees1, 2);
		
		 
	 }else{
 $totalDuees_val = $calmainamount + $fuelsurcharge + $security + $coaptax + $garage + $startxcredits + $repairs + $subletfee + $veteranstxcredits + $scrietaxcredits + $schetax + $moveinoutfees + $rentals + $securitydeposits + $fines + $disabilityrent +$legalfee + $taxrebatecredit;
		  $processfee_val1=($totalDuees_val * 0.03);
		  $processfee_val=round($processfee_val1, 2);
		  $totalDuees1=$processfee_val+$totalDuees_val;
		 $totalDuees = $currencySym.format_amount($totalDuees1, 2);
		
	 }
	 // tenants late month due ends //
					    } 
						else {
							// calculate amount and late fee 
	 if($count == '0' || $currentDay <= '5'){
		$totalDuees_val = $calmainamount + $fuelsurcharge + $security + $coaptax + $garage + $startxcredits + $repairs + $subletfee + $veteranstxcredits + $scrietaxcredits + $schetax + $moveinoutfees + $rentals + $securitydeposits + $fines + $disabilityrent +$legalfee + $taxrebatecredit;
		//  $processfee_val1=($totalDuees_val * 0.0025);
		//  $processfee_val=round($processfee_val1, 2);
		$totalDuees1=$totalDuees_val;
		 $totalDuees = $currencySym.format_amount($totalDuees_val, 2);
		
		
	 }else{
		$totalDuees_val = $calmainamount + $fuelsurcharge + $security + $coaptax + $garage + $startxcredits + $repairs + $subletfee + $veteranstxcredits + $scrietaxcredits + $schetax + $moveinoutfees + $rentals + $securitydeposits + $fines + $disabilityrent +$legalfee + $taxrebatecredit;
		 //	$processfee_val1=($totalDuees_val * 0.0025);
		//  $processfee_val=round($processfee_val1, 2);
		 $totalDuees1=$totalDuees_val;
		 $totalDuees = $currencySym.format_amount($totalDuees_val, 2);
		
	 }
	 // tenants late month due ends //
							 } 
	
	
	 
	 
	
	
	$billing_accnumber=$row1['accountnumber'];
	$propertyAddress=$row1['propertyAddress'];
	//propertyAddress
	//echo $billing_accnumber;
	$billing_unitnumber=$row1['propertyName'];
	$ifLate1 = $row1['propertyRate'] + $row1['latePenalty'];
	
	$lateTotal1 = $ifLate1;
	$billing_rentamount=$lateTotal1;
	$billing_date=date("Y-m-d h:i:sa");
	//echo $billing_unitnumber;
	
    if (isset($_POST['form']) && $_POST['form'] == 'New Payment') {     	
	
	$invalid = 0;	
	$billing_firstname = $mysqli->real_escape_string($_POST['billing_Name']);
	$billing_lastname = $mysqli->real_escape_string($_POST['billing_lastName']);
	$billing_address = $mysqli->real_escape_string($_POST['billing_address']);
	$amount = $mysqli->real_escape_string($_POST['amount']);
	$billing_phone = $mysqli->real_escape_string($_POST['billing_phone']);
	//echo $billing_phone;
	
	$CardNumber = $mysqli->real_escape_string($_POST['CardNumber']);
	//echo $CardNumber;
	$savedcard = $mysqli->real_escape_string($_POST['savedcard']);
	$billing_email = $mysqli->real_escape_string($_POST['billing_email']);
	$name_exp = '/^[A-Za-z][A-Za-z]{1,31}$/';		
    $city_ex = '/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/';
	$routingnumber_exp = '/^[0-9]{3,31}$/';
	$acountnumber_exp = ' /^\w{1,17}$/';
	$email_exp = "/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i";
	//echo $billing_rentamount;
	//$BankName_exp = '/^[A-Za-z][A-Za-z]{3,31}$/';
	//check Values
	 $hide = $mysqli->real_escape_string($_POST['hide']);
	 $checkname = $mysqli->real_escape_string($_POST['checkname']);
	 $checknumber = $tenantId.rand();
	 $routingno = $mysqli->real_escape_string($_POST['routingno']);
	 $accnumber = $mysqli->real_escape_string($_POST['accnumber']);
	
	 $checktype = $mysqli->real_escape_string($_POST['checktype']);
	 $ddacctype = $mysqli->real_escape_string($_POST['ddacctype']);
	
	// if(empty($billing_firstname) || !preg_match($name_exp, $billing_firstname)) {
    //        $err['name'] = "Please Enter a valid name";
	//		$invalid++;
     //   }
		$invalid="0";
 if($invalid == 0){		
	
				$stmt = $mysqli->prepare("
								INSERT INTO
									billinginformation(
										payee_firstname,
										payee_lastname,
										payee_address,
										payee_phone,
										payee_emailid,
										payee_accnumber,
										payee_unitnumber,
										payee_rentamount,
										payee_tenantId,
										payee_savecard,
										payee_date,
										payee_checkname,
										payee_checknumber,
										payee_routno,
										payee_accountno,
										payee_checktype,
										payee_ddatype											
										) VALUES (
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?
									)");
				$stmt->bind_param('sssssssssssssssss',
					$billing_firstname,
					$billing_lastname,
					$billing_address,
					$billing_phone,
					$billing_email,
					$billing_accnumber,
					$billing_unitnumber,
					$amount,
					$tenantId,
					$savedcard,
					$billing_date,
					$checkname,
					$checknumber,
					$routingno,
					$accnumber, 
					$checktype,
					$ddacctype
				);
			
		$exe=$stmt->execute();
		//echo $billing_rentamount;
			if($exe=='1'){
				if($paymentType != 'eCheck')
			{	
				if(($_POST['CardNumber'] != '0') && ($_POST['CardNumber'] != '')){
					//echo "hello".$_POST['CardNumber'];
					
					$CardNumbers=base64_encode(base64_encode($_POST['CardNumber']));
					$amountval=base64_encode(base64_encode($amount));
					
		$url_op='http://windsoroaksbayside.com/rentalpayments/index.php?page=paymentexistinguser&process='.$CardNumbers.'&staus='.$amountval;
		echo '<script>window.location = "'.$url_op.'";</script>';
		 include('./includes/paymentexistinguser.php');
		unset($_POST['CardNumber']);
			}	
			else{				
				$date_string = date('Ymd', strtotime(date('Y-m-d')));
			$refnumber=$tenantId.$date_string;
				$xml =  "<?xml version='1.0' encoding='UTF-8'?>
		<TransactionSetup xmlns='https://transaction.elementexpress.com'>
		<Application>
		<ApplicationID>7449</ApplicationID>
		<ApplicationName>windsoroaksbayside</ApplicationName>
		<ApplicationVersion>1.0</ApplicationVersion>
		</Application>
		<Credentials>
		<AccountID>1016336</AccountID>
		<AccountToken>67FEEB7FC97AD9463D0251E975CEB60A791B0750F1A10D3F3E569F66F00EFC650D097801</AccountToken>
		<AcceptorID>3928907</AcceptorID>
		</Credentials>
		<Transaction>
		<TransactionAmount>".$amount."</TransactionAmount>
		<MarketCode>3</MarketCode>
		<ReferenceNumber>".$refnumber."</ReferenceNumber>
		<TicketNumber>".$date_string."</TicketNumber>
		<PartialApprovedFlag>1</PartialApprovedFlag>
		<DuplicateCheckDisableFlag>1</DuplicateCheckDisableFlag>
		</Transaction>
		<Terminal><TerminalID>0001</TerminalID>
		<CardholderPresentCode>7</CardholderPresentCode>
		<CardInputCode>4</CardInputCode>
		<CardPresentCode>3</CardPresentCode>
		<CVVPresenceCode>2</CVVPresenceCode>
		<TerminalCapabilityCode>5</TerminalCapabilityCode>
		<TerminalEnvironmentCode>6</TerminalEnvironmentCode>
		<MotoECICode>7</MotoECICode>
		<TerminalType>2</TerminalType>
		</Terminal>
		<TransactionSetup>
		<TransactionSetupMethod>1</TransactionSetupMethod>
		<Embedded>1</Embedded>
		<AutoReturn>1</AutoReturn>
		<CompanyName>Windsoroaks</CompanyName>
		<ReturnURL>http://windsoroaksbayside.com/rentalpayments/index.php?page=elementPaymentcheck</ReturnURL>
		<ReturnURLTitle>WOTC Rentalpayment</ReturnURLTitle>
		</TransactionSetup>
		</TransactionSetup>";
					//echo $xml;
$headers = array(
    "Content-type: text/xml",
    "Content-length: " . strlen($xml),
    "Connection: close",
);
	$urlVal='https://transaction.elementexpress.com/';

			$ch = curl_init($urlVal);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);			
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_ENCODING, "UTF-8") ;
			$output = curl_exec($ch);
			curl_close($ch);			
			//echo $output;
			
			$xmlrespond = new SimpleXMLElement($output);		
			$TransactionSetupID =  $xmlrespond->Response->Transaction->TransactionSetupID;
			//echo $TransactionSetupID;
			
		if($TransactionSetupID !=''){
			//echo 'helkd';
			
			$en_transaction=base64_encode(base64_encode($TransactionSetupID));
			
			
		$url_op='http://windsoroaksbayside.com/rentalpayments/index.php?page=elementPaymentprocess&TransactionSetupID='.$en_transaction;
		echo '<script>window.location = "'.$url_op.'";</script>';
			
		} 
		else { 
		echo "notsuccessmsg"; 
		}
		
}
} 
else{
				//echo 'success check payment tab';
				$date_string = date('Ymd', strtotime(date('Y-m-d')));
			$refnumber=$tenantId.$date_string;
				$xml =  "<?xml version='1.0' encoding='UTF-8' standalone='no'?>
							<CheckSale xmlns='https://transaction.elementexpress.com'>
							<Application>
							<ApplicationID>7449</ApplicationID>
							<ApplicationName>windsoroaksbayside</ApplicationName>
							<ApplicationVersion>1.0</ApplicationVersion>
							</Application>
							<Credentials>
							<AccountID>1016336</AccountID>
							<AccountToken>67FEEB7FC97AD9463D0251E975CEB60A791B0750F1A10D3F3E569F66F00EFC650D097801</AccountToken>
							<AcceptorID>3928907</AcceptorID>
							</Credentials>
							<Transaction>
							<TransactionAmount>".$amount."</TransactionAmount>
							<ReferenceNumber>".$refnumber."</ReferenceNumber>
							<MarketCode>3</MarketCode>
							</Transaction>
							<Terminal>
							<TerminalID>0001</TerminalID> 
							</Terminal>
							<DemandDepositAccount>
							<AccountNumber>".$accnumber."</AccountNumber>
							<RoutingNumber>".$routingno."</RoutingNumber>
							<CheckType>".$checktype."</CheckType>
							<DDAAccountType>".$ddacctype."</DDAAccountType>
							</DemandDepositAccount>
							<Address>
							<BillingName>".$billing_firstname."</BillingName>
							<BillingAddress1>".$billing_address."</BillingAddress1>
							<BillingEmail>".$billing_email."</BillingEmail>
							</Address>
							</CheckSale>";
						//echo $xml;
						
						$headers = array(
							"Content-type: text/xml",
							"Content-length: " . strlen($xml),
							"Connection: close",
						);
						
						$urlVal='https://certtransaction.elementexpress.com/';

						$ch = curl_init($urlVal);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);			
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_ENCODING, "UTF-8") ;
						$output = curl_exec($ch);
						curl_close($ch);			
						//echo $output;
			
						$xmlrespond = new SimpleXMLElement($output);
						
						$Expresscode=  $xmlrespond->Response->ExpressResponseCode;
						$Expressmessage =  $xmlrespond->Response->ExpressResponseMessage;
						$Hostcode =  $xmlrespond->Response->HostResponseCode;
						$Hostmessage =  $xmlrespond->Response->HostResponseMessage;
						$Transactiondate =  $xmlrespond->Response->ExpressTransactionDate;
						$Transactiontime =  $xmlrespond->Response->ExpressTransactionTime;
						$Transactiontimezone =  $xmlrespond->Response->ExpressTransactionTimezone;
						$transactionids =  $xmlrespond->Response->Transaction->TransactionID;
						$refferencenumber =  $xmlrespond->Response->Transaction->ReferenceNumber;
						$processorname =  $xmlrespond->Response->Transaction->ProcessorName;
						$Transactionstatus =  $xmlrespond->Response->Transaction->TransactionStatus;
						$Transactionstatuscode =  $xmlrespond->Response->Transaction->TransactionStatusCode;
						$billingaddress =  $xmlrespond->Response->Address->BillingAddress1;
			

			
			
			  $stmt1 = $mysqli->prepare("
								INSERT INTO
									checkpayments(
										tenantId,
										leaseId,
										propertyId,
										ExpressResponseCode,
										ExpressResponseMessage,
										HostResponseCode,
										HostResponseMessage,
										ExpressTransactionDate,
										ExpressTransactionTime,
										ExpressTransactionTimezone,
										TransactionId,
										ReferenceNumber,
										ProcessorName,
										TransactionStatus,
										TransactionStatusCode,
										checkNumber,
										RentMonth,
										BillingAddress1
										) VALUES (
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?,
										?
										
									)");
				$stmt1->bind_param('ssssssssssssssssss',
					$tenantId,
					$leaseID,
					$propertyID,
					$Expresscode,
					$Expressmessage,
					$Hostcode,
					$Hostmessage,
					$Transactiondate,
					$Transactiontime,
					$Transactiontimezone,
					$transactionids,
					$refferencenumber,
					$processorname,
					$Transactionstatus,
					$Transactionstatuscode,
					$checknumber,
					$RentMonth,
					$billingaddress
					
				);

				$exe1=$stmt1->execute();
				//echo $transactionids;
				if($exe1=='1'){
				// mail sending sucessfull Mail
				    $totenantemail = $billing_email;
					$siteName = 'Windsor Oaks';
					$newEmail = 'developer@esales.in';
					$businessEmail = $totenantemail;
					$username = $mysqli->real_escape_string($_POST['tenantaccountnumber']);
					$newPass = $mysqli->real_escape_string($_POST['password1']);

					$subject = 'Windsor Oaks - Your eCheck Payment Confirmation for '.$accidnumber.'';

					$message = "<html>
<body>
<table style=' width:600px; color:rgba(66, 66, 66, 0.81); line-height: 30px; font-size: 14px; border-collapse: collapse; '  >
<tr style='background-color:#055769;' border='0'><td colspan='2' align='center'><img src='http://windsoroaksbayside.com/wotc/wp-content/uploads/2014/04/wotc_newlogo.png' alt='WOTC LOGO'></td></tr>
<tr ><td colspan='2' align='left' style='padding: 8px; border: 1px solid #d5d5d5;'>Hello <strong>".$tntName."</strong></td>
<tr ><td colspan='2' align='left' style='padding: 8px; font-weight:normal; border: 1px solid #d5d5d5;'>Thank you for your payment. Your eCheck payment has been processing. Electronic check payment takes 5-10 business days to process. You will receive an additional email when your payment has cleared</strong></td>
<tr style=' border: 1px solid #d5d5d5; ' ><th style=' border: 1px solid #d5d5d5;  background: #f5f5f5;    text-align:left; padding-left: 10px;'>Transaction Status</th><td   style=' border: 1px solid #d5d5d5; padding-left: 10px;'><strong>".$Transactionstatus."</strong></td></tr>
<tr style=' border: 1px solid #d5d5d5; ' ><th style=' border: 1px solid #d5d5d5;  background: #f5f5f5;    text-align:left; padding-left:10px;'>Merchant Name</th><td  style=' border: 1px solid #d5d5d5;  padding-left: 10px;'><strong>".$siteName."</strong></td></tr>
<tr  style=' border: 1px solid #d5d5d5; '><th style=' border: 1px solid #d5d5d5;  background: #f5f5f5;    text-align:left; padding-left:10px;'>Transaction Amount(USD $)</th><td style=' border: 1px solid #d5d5d5; padding-left: 10px;'><strong>".$amount."</strong></td></tr>
<tr  style=' border: 1px solid #d5d5d5; '><th style=' border: 1px solid #d5d5d5;  background: #f5f5f5;    text-align:left; padding-left:10px;'>Transaction ID</th><td style=' border: 1px solid #d5d5d5; padding-left: 10px;'><strong>".$transactionids."</strong></td></tr>
<tr  style=' border: 1px solid #d5d5d5; '><th style=' border: 1px solid #d5d5d5;  background: #f5f5f5;    text-align:left; padding-left:10px;'>TransactionDate</th><td style=' border: 1px solid #d5d5d5; padding-left: 10px;'><strong>".$Transactiondate."</strong></td></tr>
<tr  style=' border: 1px solid #d5d5d5; '><th style=' border: 1px solid #d5d5d5;  background: #f5f5f5;    text-align:left; padding-left:10px;'>Account Number</th><td style=' border: 1px solid #d5d5d5; padding-left: 10px;'><strong>".$accnumber."</strong></td></tr>
<tr  style=' border: 1px solid #d5d5d5; '><th style=' border: 1px solid #d5d5d5;  background: #f5f5f5;    text-align:left; padding-left:10px;'>Reference Number</th><td style=' border: 1px solid #d5d5d5; padding-left: 10px;'><strong>".$refferencenumber."</strong></td></tr>
<tr  style=' border: 1px solid #d5d5d5; '><th style=' border: 1px solid #d5d5d5;  background: #f5f5f5;    text-align:left; padding-left:10px;'>Link</th><td  style=' border: 1px solid #d5d5d5; padding-left: 10px;'><a href='http://windsoroaksbayside.com/rentalpayments/'><strong>Windsor Oaks</strong></a></td></tr>
<tr ><td colspan='4' style='padding-right: 30px; text-align:center; font-weight:normal; border: 1px solid #d5d5d5;'>Please contact us if you have any questions about your payment</td>
<tr style='background-color:#055769; color:#fff; ' align='center'><td colspan='2' style='padding:20px;'> Thank you </td></tr>
</table>
</body>
</html>";
					

					$headers = "From: ".$siteName." <".$newEmail.">\r\n";
					$headers .= "Reply-To: ".$newEmail."\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

					if (mail($businessEmail, $subject, $message, $headers)) {
					if($transactionids !='')
						{
							//echo 'helkd';
							$en_transaction=base64_encode(base64_encode($transactionids));
							$url_op='index.php?page=checkapprovedmsg&TransactionID='.$en_transaction;
							echo '<script>window.location = "'.$url_op.'";</script>';
								
						} 
						else { 
						echo "Your Check Payment Not Processed Successfully. Please Try again"; 
						}
				} else {
					if($transactionids !='')
						{
							//echo 'helkd';
							$en_transaction=base64_encode(base64_encode($transactionids));
							$url_op='index.php?page=checkapprovedmsg&TransactionID='.$en_transaction;
							echo '<script>window.location = "'.$url_op.'";</script>';
								
						} 
						else { 
						echo "Your Check Payment Not Processed Successfully. Please Try again"; 
						}
					
				}// mail sending sucessfull Mail
			}				
			}
			}
			else{
				echo "hello";
			}
			  $bill_created = 1;
			  //echo "hai1";
			
		
			
			//$msgBox = alertBox($tenantAccountActivated, "<i class='fa fa-check-square-o'></i>", "success");
			$stmt->close();
			//header("Location:https://certtransaction.hostedpayments.com/?TransactionSetupID=".$TransactionSetupID);
	}
	$_POST['billing_Name'] = $_POST['billing_lastName'] = $_POST['billing_address']  = $_POST['billing_phone'] = $_POST['billing_email'] = $_POST['form'] =  '';
	

	}



	// Get Current Property Info
	$lease = "
		SELECT
            tenants.propertyId,
            tenants.leaseId,
            properties.propertyName,
			properties.propertyRate,
			properties.latePenalty,
			leases.leaseTerm,
			leases.leaseStart,
            DATE_FORMAT(leases.leaseEnd,'%M %d, %Y') AS leaseEnd,
			assignedproperties.adminId,
			admins.adminFirstName,
			admins.adminLastName
		FROM
			tenants
            LEFT JOIN properties ON tenants.propertyId = properties.propertyId
            LEFT JOIN leases ON tenants.leaseId = leases.leaseId
			LEFT JOIN assignedproperties ON tenants.propertyId = assignedproperties.propertyId
			LEFT JOIN admins ON assignedproperties.adminId = admins.adminId
		WHERE
            tenants.tenantId = ".$tenantId;
	$leaseres = mysqli_query($mysqli, $lease) or die('Error, retrieving Property Data failed. ' . mysqli_error());
    $row = mysqli_fetch_assoc($leaseres);

	// Format the Amounts
	
	$propertyRate = $currencySym.format_amount($row['propertyRate'], 2);
	//$latePenalty = $currencySym.format_amount($row['latePenalty'], 2);
	$totalToPay	= $row['propertyRate'];
	$ifLate = $row['propertyRate'] + $row['latePenalty'];
	$lateTotal = $ifLate.'.00';
	
	// Check if the Tenant is late on current month's rent
	if ($currentDate > $row['leaseStart']) {
		$latecheck = "SELECT
						payments.isRent,
						payments.rentMonth,
						tenants.propertyId
					FROM
						payments
						LEFT JOIN tenants ON payments.tenantId = tenants.tenantId
					WHERE
						tenants.propertyId = ".$row['propertyId']." AND
						payments.isRent = 1 AND
						payments.rentMonth = '".$currentMonth."'";
		$lateres = mysqli_query($mysqli, $latecheck) or die('Error, retrieving Late Rent Data failed. ' . mysqli_error());
		
		if (mysqli_num_rows($lateres) < 1) {
			$hasLateRent = 'true';
			if ($currentDay > '5') {
				$totalToPay	= $lateTotal;
			} else {
				$totalToPay	= $row['propertyRate'];
			}
		}
	} else {
		$hasLateRent = '';
	}
?>
<h3 class="success"><?php echo clean($row['propertyName']).' '.$newPaymentH3; ?></h3>
<p class="lead">Windsor Oaks rental payment accepts card and eCheck for Maintenance Payments.</p>
<!-- <?php if ($set['enablePayments'] == '1') { ?>
	<p class="lead"><?php echo $newPaymentQuipPaypal; ?></p>
<?php } else { ?>
	<p class="lead"><?php echo $newPaymentQuipNoPaypal; ?></p>
<?php } ?> -->


<div class="col-md-8" style="padding-left:0px !important; padding-top:15px;  padding-right:10px !important">
<?php if ($set['enablePayments'] == '1') { ?>
	

	<div class="errorNote"></div>
    <?php if($invalid > 0):?>
     <div class="alertMsg danger">
        <?php foreach ($err as $key=> $val):?>
           <span><?php echo $val; ?></span><br />
        <?php endforeach;?>
     </div>
    <?php endif; ?> 
    <?php if(isset($_GET['status'])=='Cancelled'): ?>
      <div class="alertMsg danger">
       <span> Transaction has been Cancelled</span>
      </div> 
    <?php endif; ?> 
    
    
    
   <?php /*?> <?php if($TransactionSetupID !=''){
			$url_op='https://certtransaction.hostedpayments.com/?TransactionSetupID='.$TransactionSetupID;
			?>
			<iframe  onload="load(this)" name="Google"  id="iframeid"  scrolling="auto" style="width:95%; height:600px" src="<?php echo $url_op; ?>"  ></iframe>
			<?php
		
			
		}  ?><?php */?>
    <!--https://certtransaction.elementexpress.com/index.php?page=elementPaymentprocess-->
    <form action="" method="post" id="billing-form">
     <h4 class="primary">Enter your Billing Information</h4> 
			<div style="margin-bottom:10px;">Please enter the following information</div>
					<div class="form-group">
                    <div class="col-md-6">
                        <label for="billing_Name">First Name</label>
                        <input type="text"   name="billing_Name" id="billing_Name" value="<?php echo  $row1['tenantFirstName']; ?>"  readonly /> 
                     
                     </div>
                      <div class="col-md-6">
                        <label for="billing_lastName">Last Name</label>
                        <input type="text" name="billing_lastName" id="billing_lastName" value="<?php echo $row1['tenantLastName']; ?>" readonly />
                     </div>
                    </div>         
                    <div class="form-group" style="padding-top:10px; clear:both">
                    <div class="col-md-6">
                        <label for="billing_Name">Unit Number</label>
                        <input type="text"  name="Unit_Number" id="Unit_Number" value="<?php echo  $row1['propertyName']; ?>"  readonly /> 
                     
                     </div>
                      <div class="col-md-6">
                        <label for="billing_lastName">Account Number</label>
                        <input type="text" name="acc_number" id="acc_number" value="<?php echo $row1['accountnumber']; ?>" readonly />
                     </div>
                    </div>                    					
					<div class="form-group" style="padding-top:10px; clear:both">
                    <div class="col-md-12">
						<label for="billing_address">Address</label>
                        <textarea type="text"   name="billing_address" id="billing_address" readonly ><?php if( $row1['propertyAddress'] != '' ){ echo $row1['propertyAddress'];} else{} ?></textarea> 
						</div>
					</div>
					                  
                    <div class="form-group" style="clear:both; padding:10px 0px; ">
                    <div class="col-md-6">
                     <label for="billing_phone">Phone</label>
                        <input type="text" class="form-control" name="billing_phone" id="billing_phone" maxlength="14" value="<?php if( $row1['tenantPhone'] != '' ){echo decryptIt($row1['tenantPhone']);} else{} ?>" >
                    </div>
                    <div class="col-md-6">
                     <label for="billing_email">Email Address</label>
                        <input type="text"  name="billing_email" id="billing_email" maxlength="32" value="<?php echo $row1['tenantEmail']; ?>" >
                    </div>                       
                    </div>
                  <div class="form-group" style="clear:both;  padding:10px 0px;"><div class="col-md-12">
                     <label for="billing_phone">Total Amount</label>
                       <input type="text" class="form-control" name="amount" id="amount" maxlength="14" value="<?php echo number_format((float)$totalDuees1, 2, '.', ''); ?>" >
					  
					   
                    </div>
                    </div> 
                    <!--tabs-->
                    <div class="clear"></div>
			<div class="row" style="margin-bottom: 0px;">
				<div class="col-md-12">
					<?php if($paymentType=="CreditCard"){?> <h4 class="primary active" id="card">Card Payment</h4><?php } else{ ?>
					<h4 class="primary active" id="check">Check Payment</h4><?php }?>
					
				</div>
		   </div>
        
                    <div class="tab-content col-md-12 spacing">
			<?php if($paymentType=="CreditCard"){?>	<div  class=" ">
                    <?php $exeuse ="SELECT Max(payee_savecard) as  payee_savecard FROM billinginformation WHERE  payee_tenantId = ".$tenantId;
	$exeusercardval  = mysqli_query($mysqli, $exeuse) or die('Error, retrieving Late Rent Data failed. ' . mysqli_error());
	$fileter = mysqli_fetch_assoc($exeusercardval); 
	$savecardcode=$fileter['payee_savecard'];
	
	$exeuse1 ="SELECT SaveCardsID FROM paymentsavecards WHERE  PaymentAccountReferenceNumber = ".$tenantId;
	$exeusercardval1  = mysqli_query($mysqli, $exeuse1) or die('Error, retrieving Late Rent Data failed. ' . mysqli_error());
	$fileter1 = mysqli_fetch_assoc($exeusercardval1); 
	$savecardcode1=$fileter1['SaveCardsID'];
	
	 if(($savecardcode=='1') && ($savecardcode1 != '')){?>
	    <table style="margin:0px;"> <tr   style="border:0px; text-align: left;"><td  style="border:0px;  text-align: left;"> <div style="padding-top:15px; clear:both">
                 <input id="savecard" type="checkbox" name="savedcard" class="selectcards1" value="1">
              Save your Card</div></td>
			  <td style="border:0px;  text-align: left;" ></td>
			  <td  style="border:0px; text-align: left;">
                 <div style="padding-top:15px; clear:both">
         
  <input type='checkbox' value='<?php echo $tenantId; ?>' class="selectcards" name='execard'>
              Saved Card</div></td><td  style="border:0px; text-align: left; width:300px;"> <div id="show_div" ><select name="CardNumber" class="cardname form-control">
<option selected="selected" value="0">--Select Card--</option>
</select></div></td></tr></table>
                 
	<?php  }
	 else if(($savecardcode=='0') || ($savecardcode=='') || ($savecardcode1 == '')){?>
		  <table style="margin:0px;"> <tr   style="border:0px; text-align: left;"><td  style="border:0px;  text-align: left;"> <div style="padding-top:15px; clear:both">
                 <input id="savecard" type="checkbox" name="savedcard" class="selectcards" value="1">
              Save Card</div></td></tr></table>
	<?php	 }?>
             </div><?php } else{ ?>
            <div  class="">
						
						<!--<p id="hide"></p>-->
						
					   <div class="form-group row" style="padding-top: 10px;">
						   <div class="col-md-6">
							   <label for="checkname">Name On Check</label>
							   <input type="text" class="control" id="checkname" name="checkname"  />
						   </div>
						     <div class="col-md-6">
							   <label for="routingno">Routing Number</label>
							   <input type="text" class="control" name="routingno" id="routingno"  maxlength="9" required >
						   </div>
					   </div>
							   
					   <div class="form-group row">
						 
						   <div class="col-md-6">
							   <label for="accnumber">Account Number</label>
							   <input type="text" class="control" name="accnumber" id="accnumber"  maxlength="20" required>
						   </div>
                            <div class="col-md-6">
							   <label for="checktype">Check Type</label>
							   <select class="form-control" name="checktype" id="checktype" required />
								   <option value="0" selected="selected">Personal</option>
								 <!--  <option value="1">Bussiness</option> -->
							   </select>
						   </div>
					   </div>
							   
					   <div class="form-group row">
						   
						  
                           <div class="col-md-6">
                              <label for="ddacctype">Demand Deposit Account Type</label>
							   <select class="form-control" name="ddacctype" id="ddacctype" required>
								 <option value="0" selected="selected">Checking</option>
								 <option value="1">Savings</option>
							   </select>
							
						   </div>
					   </div>
							   
					   <div class="form-group row">
						   <div class="col-md-12">
							
						
						   </div>
					   </div>
                        </div><?php } ?>
                        <!--taps-->
             
             </div>
            
               
				 		 
              	   
				<input type="hidden" name="form" value="New Payment"  />
				<div style="padding-top:15px; clear:both;">
				   <div class="clear"></div>
<div id="payment">
				<!--<ul class="payment_methods methods">
									<li style="list-style:none; list-style-type:none;" class="payment_method_element">
							<input id="payment_method_element" type="radio" class="input-radio" name="payment_method" value="element" checked="checked" data-order_button_text="">
							<label for="payment_method_element">Pay with Credit Card (Element PS) </label>
							<div class="payment_box payment_method_element"><p>Pay with Element Payment Services. You will be redirected to element PS secure website where you will be able to pay with credit card. After the payment – you will be redirected back to our site.</p>
						   </div>
						   </li>
					</ul>	-->

		

	</div>	   <div style="padding-top:15px; clear:both">
                 <input id="authorize" type="checkbox" name="authorize" value="authorize">
                 I hereby authorize windsor Oaks to deduct from my account indicated above.  </div>
				<div style="float:left; padding-right:15px;">	
                <button type="button" id="form-submit" class="btn btn-success btn-icon">
                <i class="fa fa-check-square-o"></i>Proceed</button> 
                </div>
				<div style="width:10%; float:left">	
                <button type="reset" class="btn btn-success btn-icon"><i class="fa fa-times-circle"></i> Reset</button>
                </div>
				</div>
			</form>
    

<?php } ?>
</div>
<div class="col-md-4" style="padding-top:15px;">
<h4 class="primary">Payment Summary</h4>

<?php if ($set['enablePayments'] == '1') { ?>
	<!--<p class="lead"><?php// echo $payByOtherQuip; ?></p>-->
<?php } ?>

<table id="responsiveTableTwo" class="large-only" cellspacing="0">
			
			<?php if($totalDuees=='$0.00'){?> <tr ><th style="text-align:left;"><?php echo $tab_duemonth; ?></th><td style="text-align:right; border-top:1px solid #d5d5d5;"><?php echo date("F"); ?></td></tr><?php } else{ ?><tr ><th style="text-align:left;"><?php echo $tab_duemonth; ?></th><td style="text-align:right; border-top:1px solid #d5d5d5;"><?php if(date("F",strtotime($unpaid['firestdate'])) == date("F",strtotime($unpaid['lastdate']))){echo date("F",strtotime($unpaid['lastdate']));}else{ echo date("F",strtotime($unpaid['firestdate'])) .'-'.date("F",strtotime($unpaid['lastdate']));} ?></td></tr><?php }?>
			<tr><th style="text-align:left;"><?php echo $tab_monthlyRent; ?></th><td style="text-align:right;"><?php echo $latemaintainfee; ?></td></tr>
			<?php  if(($unpaid['latePenalty'])=='0' || $count == '0' || $currentDay <= '5'){} else{ ?><tr><th style="text-align:left;"><?php echo $tab_lateFee; ?></th><td style="text-align:right;"><?php echo $panalty; ?></td></tr><?php }?>
			<?php if($fuelsurcharge1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $fuelSurCharge; ?></th>	<td style="text-align:right;"><?php echo $fuelsurcharge1; ?></td></tr><?php }?>
			<?php if($security1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $securityCharge; ?></th>	<td style="text-align:right;"><?php echo $security1; ?></td></tr><?php }?>
			<?php if($coaptax1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $coaptaxCharge; ?></th>	<td style="text-align:right;"><?php echo $coaptax1; ?></td></tr><?php }?>
			<?php if($garage1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $garageCharge; ?></th>	<td style="text-align:right;"><?php echo $garage1; ?></td></tr><?php }?>
			<?php if($startxcredits1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $startxcreditsCharge; ?></th>	<td style="text-align:right;"><?php echo $startxcredits1; ?></td></tr><?php }?>
			<?php if($repairs1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $repairsCharge; ?></th>	<td style="text-align:right;"><?php echo $repairs1; ?></td></tr><?php }?>
			<?php if($subletfee1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $subletfeeCharge; ?></th>	<td style="text-align:right;"><?php echo $subletfee1; ?></td></tr><?php }?>
			<?php if($scrietaxcredits1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $tab_scrietax; ?></th>	<td style="text-align:right;"><?php echo $scrietaxcredits1; ?></td></tr><?php }?>
			<?php if($schetax1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $tab_schetax; ?></th>	<td style="text-align:right;"><?php echo $schetax1; ?></td></tr><?php }?>
			<?php if($moveinoutfees1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $tab_moveinout; ?></th>	<td style="text-align:right;"><?php echo $moveinoutfees1; ?></td></tr><?php }?>
			<?php if($rentals1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $tab_rentals; ?></th>	<td style="text-align:right;"><?php echo $rentals1; ?></td></tr><?php }?>
			<?php if($securitydeposits1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $tab_securitydeposit; ?></th>	<td style="text-align:right;"><?php echo $securitydeposits1; ?></td></tr><?php }?>
			<?php if($fines1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $tab_Fines; ?></th>	<td style="text-align:right;"><?php echo $fines1; ?></td></tr><?php }?>
			<?php if($disabilityrent1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $tab_disability; ?></th>	<td style="text-align:right;"><?php echo $disabilityrent1; ?></td></tr><?php }?>
            <?php if($legalfee1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $tab_legalfee; ?></th>	<td style="text-align:right;"><?php echo $legalfee1; ?></td></tr><?php }?>
			<?php if($taxrebatecredit1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $tab_taxrebate; ?></th>	<td style="text-align:right;"><?php echo $taxrebatecredit1; ?></td></tr><?php }?>
			<?php if($veteranstxcredits1=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo $veteranstxcreditsCharge; ?></th>	<td style="text-align:right;"><?php echo $veteranstxcredits1; ?></td></tr><?php }?>
			<tr><th style="text-align:left;"><?php echo $totalAmountDue; ?></th>	<td style="text-align:right;">$<?php echo $totalDuees_val ?></td></tr>
			<?php if($paymentType=="CreditCard"){ if($totalDuees=='$0.00'){} else{ ?><tr><th style="text-align:left;"><?php echo "Processing Fee"; ?></th>	<td style="text-align:right;"><?php echo $currencySym.format_amount($processfee_val, 2); ?></td></tr><?php } } else {}?>
			<tr><th style="text-align:left;"><?php echo "Amount to be Paid" ?></th>	<td style="text-align:right;"><?php echo $totalDuees; ?></td></tr>
</table>
<?php /*?><form action="" method="post">
<div class="list-group padTop">
<div class="form-group col-lg-12" >
			<label class="detailinformation" for="priceSet"><?php echo $paymentAmountField; ?> :</label>
			<input type="text" class="noborder form-control" name="priceSet" id="priceSet" value="<?php echo $propertyRate; ?>" />
           <!--<input type="text" class="noborder form-control" name="priceSet" id="priceSet" value="<?php echo $propertyRate; ?>" />-->
			<span class="help-block paymenthelp"><?php echo $paymentAmountHelper; ?></span>
		</div>
        <div class="form-group col-lg-12">
			<label class="detailinformation" for="priceSet">Due Amount :</label>
			<input type="text" class="noborder form-control" name="duepriceSet" id="duepriceSet" value="<?php echo $latePenalty; ?>" />
           <!-- <input type="text" class="noborder form-control" name="duepriceSet" id="duepriceSet" value="<?php echo $latePenalty; ?>" />-->
			<span class="help-block paymenthelp"><?php echo $paymentAmountHelper; ?></span>
		</div>
		<div class="form-group col-lg-12">      
			<label class="detailinformation" for="pricePlusFee"><?php echo $totalAmountField; ?> :</label>
            <input type="text" class="noborder form-control"  value="$<?php echo $lateTotal; ?>" />
			<!--<input type="text" class="noborder form-control"  value="$<?php echo $lateTotal; ?>" />-->
			<span class="help-block paymenthelp"><?php echo $totalAmountHelper; ?></span>
		</div>

	
</div>
</form><?php */?>
<hr style="margin: 0.35em auto;"></hr>
<div class="list-group ">
		<img src="images/Acceptscreditcard.jpg">
	</div>
<div style="width:100%; float:left; position:relative">

<hr style="margin: 0.35em auto;"></hr>
<h4 class="primary"><?php echo $paymentQuestionsH3; ?></h4>
<p class="lead"><?php echo $paymentQuestionsQuip; ?></p>

<!-- <div style="width:100%; float:left; position:relative">

	<hr />
<img src="images/check_option.jpg" style="padding-bottom:10px;" >

<strong>KEY:</strong>
<p>1. Customer name or names<br>
2. Customer address<br>
3. Check number – usually appears both in upper corner and in the MICR imprinting along the bottom of the check<br>
4. Customer account number<br>
5. Routing/Transit Number<br>
6. Bank Name and address<br>
</div> -->

</div>
<hr />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function(e) {
   var invalid = 0; 
   $('#form-submit').click(function(e) {
	invalid = 0;
	e.preventDefault();
	$('.err').detach(); 
    $('.form-control').each(function(index, element) {
		element = $(this).attr('id');
        if(!$(this).val())
		 { 
		     invalid++;
			 $(this).after('<span class="err">This field is required.</span>');
		 }
		else
		 {
			  switch(element){
				  case 'billing_Name': var nameReg = /^[a-zA-Z ]+$/;
				  					  if(!nameReg.test($(this).val()))
									   {
										 invalid++;  
									   	 $(this).after('<span class="err">Name must Contain only alphabets</span>');
									   }
									  break;
				  case 'billing_address':
				  case 'billing_address2': 
				  						var adrEXp = /^[a-zA-Z0-9\s\[\]\.\-#',]*$/;
				  						 if(!adrEXp.test($(this).val()))
										   {
											 invalid++;  
											 $(this).after('<span class="err">Address is Invalid</span>');
										   }
									  break; 
				  case 'billing_email': var emailReg = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
				  					  if(!emailReg.test($(this).val()))
									   {
										 invalid++;  
									   	 $(this).after('<span class="err">Email Format is example@domain.com</span>');
									   }
									
									  break;
				  
				 case 'bnk_BankName': var nameReg = /^[a-zA-Z ]+$/;
				  					  if(!nameReg.test($(this).val()))
									   {
										 invalid++;  
									   	 $(this).after('<span class="err">BankName must Contain only alphabets</span>');
									   }
									  break;
				 case 'bnk_BankName': var nameReg = /^[a-zA-Z ]+$/;
				  					  if(!nameReg.test($(this).val()))
									   {
										 invalid++;  
									   	 $(this).after('<span class="err">BankName must Contain only alphabets</span>');
									   }
									  break;
				case 'bnk_Banklocated': var nameReg = /^[a-zA-Z ]+$/;
				  					  if(!nameReg.test($(this).val()))
									   {
										 invalid++;  
									   	 $(this).after('<span class="err">Bank Location must Contain only alphabets</span>');
									   }
									  break;		
				case 'bnk_RoutingNumber': var rtnReg = /^((0[0-9])|(1[0-2])|(2[1-9])|(3[0-2])|(6[1-9])|(7[0-2])|80)([0-9]{7})$/;
				  					  if(!rtnReg.test($(this).val()))
									   {
										 invalid++;  
									   	 $(this).after('<span class="err">Invalid Routing Number</span>');
									   }
									  break;
			   case 'bnk_AccountNumber': var bacReg = /^\w{1,17}$/;
			 	  					  if(!bacReg.test($(this).val()))
									   {
										 invalid++;  
									   	 $(this).after('<span class="err">Invalid bank account Number</span>');
									   }
									  break;	
				  default: break; 
				  
			  }
		 }
		
    }); 
	 if($('#check').hasClass('active'))
			{
				$("#hide").val("check");
				$('.control').each(function(index, element)
					{
						element = $(this).attr('id');
							if(!$(this).val())
								{ 
									invalid++;
									$(this).after('<span class="err">This field is required.</span>');
								}
						
								else
								{
								 switch(element){
									case 'checkname': var nameReg = /^[a-zA-Z ]+$/;
													   if(!nameReg.test($(this).val()))
															{
																invalid++;  
																$(this).after('<span class="err">Check name must Contain only alphabets</span>');
															}
														break;
															
									case 'routingno': var rtnReg = /^[0-9]+$/;
														if(!rtnReg.test($(this).val()))
															  {
																 invalid++;  
																 $(this).after('<span class="err">Routing Number Maximum 9 Digit Only</span>');
															  }
														break;
															
									case 'accnumber': var acbReg = /^[0-9]+$/;
																if(!acbReg.test($(this).val()))
																	{
																		invalid++;  
																		$(this).after('<span class="err">Account Number Maximum 9 Digit Only</span>');
															        }
														      break;
									
									
									default: break; 
				  
			  }
		 }
				});
			}
	if(invalid>0)
	 {
		alert("Please fill all the required fields") ;
	 	return false;
	 }
	else
	   if(!$('#authorize').is(':checked'))
	    {
		   alert("Please read and accept the terms and conditions");
		   return false;
		}
	   else	   
		  $('#billing-form').submit(); 
		   //document.getElementById("billing-form").value = "";
		  
   });
  
});
 
</script>

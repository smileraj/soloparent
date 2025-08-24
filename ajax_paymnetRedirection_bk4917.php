<?php
session_start();
 /*
if($_POST['submit_btn']=='Submit'){
$ogone_SHA_alias = 'Parentsoloch@123';
$ogone_PSPID_alias = 'parentsoloTEST';
$ogone_BRAND_alias = $_POST["BRAND_val"];
$ogone_CARDNO_alias = $_POST["CARDNO_number"];
$ogone_CN_alias = $_POST['CN_holder_name'];
$ogone_CVC_alias = $_POST['CVC_number'];
$ogone_ECOM_CARDINFO_EXPDATE_MONTH_alias = $_POST['ECOM_CARDINFO_EXPDATE_MONTH_number'];
$ogone_ECOM_CARDINFO_EXPDATE_YEAR_alias = $_POST['ECOM_CARDINFO_EXPDATE_YEAR_number'];
$ogone_ACCEPTURL_alias = 'http://20.1.1.115/Parentsolo_new/index.php?app=abonnement&action=SavedCarddetails&lang=en&result=Success';
$ogone_EXCEPTIONURL_alias = 'http://20.1.1.115/Parentsolo_new/index.php?app=abonnement&action=SavedCarddetails&lang=en&result=exception';
$ogone_PARAMPLUS_alias = 'TestVal';
$ogone_ORDERID_alias =$_POST['idval_name'].'_'.rand(100,10000); 
$ogone_LANGUAGE_alias = 'en_US';
$ogone_SHASIGN_alias = "ACCEPTURL=$ogone_ACCEPTURL_alias$ogone_SHA_alias". 
"BRAND=$ogone_BRAND_alias$ogone_SHA_alias". 
"EXCEPTIONURL=$ogone_EXCEPTIONURL_alias$ogone_SHA_alias". 
"LANGUAGE=$ogone_LANGUAGE_alias$ogone_SHA_alias". 
"ORDERID=$ogone_ORDERID_alias$ogone_SHA_alias". 
"PARAMPLUS=$ogone_PARAMPLUS_alias$ogone_SHA_alias". 
"PSPID=$ogone_PSPID_alias$ogone_SHA_alias";
$ogone_SHASIGN_val = sha1($ogone_SHASIGN_alias);
?>
		<form method="post" action="https://e-payment.postfinance.ch/ncol/test/alias_gateway.asp" id=form2 name=form2>
		<input type="hidden" name="PSPID" value="<?php echo $ogone_PSPID_alias;?>">
		<input type="hidden" name="BRAND" value="<?php echo $ogone_BRAND_alias;?>">
		<input type="hidden" name="CN" value="<?php echo $ogone_CN_alias; ?>"> 
		<input type="hidden" name="CARDNO" value="<?php echo $ogone_CARDNO_alias; ?>"> 
		<input type="hidden" name="CVC" value="<?php echo $ogone_CVC_alias; ?>"> 
		<input type="hidden" name="ED" value="<?php echo $ogone_ED_alias; ?>"> 
		<input type="hidden" name="ECOM_CARDINFO_EXPDATE_MONTH" value="<?php echo $ogone_ECOM_CARDINFO_EXPDATE_MONTH_alias; ?>"> 
		<input type="hidden" name="ECOM_CARDINFO_EXPDATE_YEAR" value="<?php echo $ogone_ECOM_CARDINFO_EXPDATE_YEAR_alias; ?>"> 
		<input type="hidden" name="ACCEPTURL" value="<?php echo $ogone_ACCEPTURL_alias;?>"> 
		<input type="hidden" name="EXCEPTIONURL" value="<?php echo $ogone_EXCEPTIONURL_alias; ?>"> 
		<input type="hidden" name="PARAMPLUS" value="<?php echo $ogone_PARAMPLUS_alias; ?>"> 
		<input type="hidden" name="SHASIGN" value="<?php echo $ogone_SHASIGN_val; ?>"> 
		<input type="hidden" name="ORDERID"     value="<?php echo $ogone_ORDERID_alias;?>">
		<input type="hidden" name="LANGUAGE"    value="<?php echo $ogone_LANGUAGE_alias;?>">
		</form>
		<script language="javascript" type="text/javascript">
				function form2(){try{clearInterval(timerPaypal);}catch(e){}document.form2.submit();}
				var timerPaypal=setInterval("form2();", 100);
		</script>
			
			<? 
			}*/
			?>
			
			

			<?php 
		
if(($_POST['submit_btn']=='Submit') || ($_POST['submit_btn']=='Voorleggen') || ($_POST['submit_btn']=='Soumettre')){
$ogone_Saved_card_option = $_POST["Saved_card_option"];
if($ogone_Saved_card_option=='Yes'){
$ogone_SHA_alias = 'Parentsoloch@123';
$ogone_PSPID_alias = $_POST["PSPID"];
$ogone_BRAND_alias = $_POST["BRAND_val"];
$ogone_CARDNO_alias = $_POST["CARDNO_number"];
$ogone_CN_alias = $_POST['CN_holder_name'];
$ogone_CVC_alias = $_POST['CVC_number'];
$ogone_ECOM_CARDINFO_EXPDATE_MONTH_alias = $_POST['ECOM_CARDINFO_EXPDATE_MONTH_number'];
$ogone_ECOM_CARDINFO_EXPDATE_YEAR_alias = $_POST['ECOM_CARDINFO_EXPDATE_YEAR_number'];
$ogone_ACCEPTURL_alias = $_POST['ACCEPTURL_saved'];
$ogone_EXCEPTIONURL_alias = $_POST['EXCEPTIONURL_saved'];
$ogone_PARAMPLUS_alias = 'parentsolo';
$ogone_ORDERID_alias =$_POST['ORDERID']; 
$ogone_LANGUAGE_alias = $_POST["LANGUAGE"];
$ogone_SHASIGN_alias = "ACCEPTURL=$ogone_ACCEPTURL_alias$ogone_SHA_alias". 
"BRAND=$ogone_BRAND_alias$ogone_SHA_alias". 
"EXCEPTIONURL=$ogone_EXCEPTIONURL_alias$ogone_SHA_alias". 
"LANGUAGE=$ogone_LANGUAGE_alias$ogone_SHA_alias". 
"ORDERID=$ogone_ORDERID_alias$ogone_SHA_alias". 
"PARAMPLUS=$ogone_PARAMPLUS_alias$ogone_SHA_alias". 
"PSPID=$ogone_PSPID_alias$ogone_SHA_alias";
$ogone_SHASIGN_val = sha1($ogone_SHASIGN_alias);



//session_val for saved card payment


$_SESSION['PSPID_saved'] = $_POST["PSPID"];
$_SESSION['ORDERID_saved'] = $_POST["ORDERID"]; 
$_SESSION['Amount_valenc_saved'] = base64_decode($_POST["Amount_valenc"]); 
$_SESSION['CN_holder_name_saved'] = $_POST["CN_holder_name"];
$_SESSION['Email_address_saved'] = $_POST["Email_address"];
$_SESSION['OWNERZIP_saved'] = $_POST["OWNERZIP"];
$_SESSION['CVC_number'] = $_POST['CVC_number'];
$_SESSION['OWNERADDRESS_saved'] = $_POST["OWNERADDRESS"];
$_SESSION['OWNERCTY_saved'] = $_POST["OWNERCTY"];
$_SESSION['OWNERTOWN_saved'] = $_POST["OWNERTOWN"];
$_SESSION['phone_number_saved'] = $_POST["phone_number"];
$_SESSION['USERID_saved'] = $_POST["USERID"];
$_SESSION['CURRENCY_saved'] = $_POST["CURRENCY"];
$_SESSION['LANGUAGE_saved'] = $_POST["LANGUAGE"];
$_SESSION['ACCEPTURL_saved'] = $_POST["ACCEPTURL"];
$_SESSION['DECLINEURL_saved'] = $_POST["DECLINEURL"];
$_SESSION['EXCEPTIONURL_saved'] = $_POST["EXCEPTIONURL"];
$_SESSION['CANCELURL_saved'] = $_POST["CANCELURL"];


?>
		<form method="post" action="https://e-payment.postfinance.ch/ncol/prod/alias_gateway.asp" id=form2 name=form2>
		<input type="hidden" name="PSPID" value="<?php echo $ogone_PSPID_alias;?>">
		<input type="hidden" name="BRAND" value="<?php echo $ogone_BRAND_alias;?>">
		<input type="hidden" name="CN" value="<?php echo $ogone_CN_alias; ?>"> 
		<input type="hidden" name="CARDNO" value="<?php echo $ogone_CARDNO_alias; ?>"> 
		<input type="hidden" name="CVC" value="<?php echo $ogone_CVC_alias; ?>"> 
		<!--<input type="hidden" name="ED" value="<?php echo $ogone_ED_alias; ?>"> -->
		<input type="hidden" name="ECOM_CARDINFO_EXPDATE_MONTH" value="<?php echo $ogone_ECOM_CARDINFO_EXPDATE_MONTH_alias; ?>"> 
		<input type="hidden" name="ECOM_CARDINFO_EXPDATE_YEAR" value="<?php echo $ogone_ECOM_CARDINFO_EXPDATE_YEAR_alias; ?>"> 
		<input type="hidden" name="ACCEPTURL" value="<?php echo $ogone_ACCEPTURL_alias;?>"> 
		<input type="hidden" name="EXCEPTIONURL" value="<?php echo $ogone_EXCEPTIONURL_alias; ?>"> 
		<input type="hidden" name="PARAMPLUS" value="<?php echo $ogone_PARAMPLUS_alias; ?>"> 
	
		<input type="hidden" name="SHASIGN" value="<?php echo $ogone_SHASIGN_val; ?>"> 
		<input type="hidden" name="ORDERID"     value="<?php echo $ogone_ORDERID_alias;?>">
		<input type="hidden" name="LANGUAGE"    value="<?php echo $ogone_LANGUAGE_alias;?>">
		</form>
		<script language="javascript" type="text/javascript">
				function form2(){try{clearInterval(timerPaypal);}catch(e){}document.form2.submit();}
				var timerPaypal=setInterval("form2();", 50);
		</script>
			<?
}
else {
$ogone_SHA = 'Parentsoloch@123';
$ogone_PSPID = $_POST["PSPID"];
$ogone_ORDERID = $_POST["ORDERID"]; 
$ogone_AMOUNT1 = base64_decode($_POST["Amount_valenc"]); 
$ogone_CN = $_POST["CN_holder_name"];
$ogone_EMAIL = $_POST["Email_address"];
$ogone_OWNERZIP = $_POST["OWNERZIP"];
$ogone_OWNERADDRESS = $_POST["OWNERADDRESS"];
$ogone_OWNERCTY = $_POST["OWNERCTY"];
$ogone_OWNERTOWN = $_POST["OWNERTOWN"];
$ogone_OWNERTELNO = $_POST["phone_number"];
$ogone_USERID = $_POST["USERID"];
//$ogone_AMOUNT = round($ogone_AMOUNT1, 2)*100;
$ogone_AMOUNT = $ogone_AMOUNT1;
$ogone_CURRENCY = $_POST["CURRENCY"];
$ogone_LANGUAGE = $_POST["LANGUAGE"];
$ogone_Logo = 'logo_fr.png';
$ogone_ACCEPTURL = $_POST["ACCEPTURL"];
$ogone_CANCELURL = $_POST["DECLINEURL"];
$ogone_DECLINEURL = $_POST["EXCEPTIONURL"];
$ogone_WIN3DS = 'MAINW';
$ogone_FLAG3D = 'Y';
$ogone_EXCEPTIONURL = $_POST["CANCELURL"];
$ogone_SHASIGN = "ACCEPTURL=$ogone_ACCEPTURL$ogone_SHA".
"AMOUNT=$ogone_AMOUNT$ogone_SHA".
"CANCELURL=$ogone_CANCELURL$ogone_SHA".
"CN=$ogone_CN$ogone_SHA".
"CURRENCY=$ogone_CURRENCY$ogone_SHA".
"DECLINEURL=$ogone_DECLINEURL$ogone_SHA".
"EMAIL=$ogone_EMAIL$ogone_SHA".
"EXCEPTIONURL=$ogone_EXCEPTIONURL$ogone_SHA".
"FLAG3D=$ogone_FLAG3D$ogone_SHA".
"LANGUAGE=$ogone_LANGUAGE$ogone_SHA".
"LOGO=$ogone_Logo$ogone_SHA".
"ORDERID=$ogone_ORDERID$ogone_SHA".
"OWNERADDRESS=$ogone_OWNERADDRESS$ogone_SHA".
"OWNERCTY=$ogone_OWNERCTY$ogone_SHA".
"OWNERTELNO=$ogone_OWNERTELNO$ogone_SHA".
"OWNERTOWN=$ogone_OWNERTOWN$ogone_SHA".
"OWNERZIP=$ogone_OWNERZIP$ogone_SHA".
"PSPID=$ogone_PSPID$ogone_SHA".
"USERID=$ogone_USERID$ogone_SHA".
"WIN3DS=$ogone_WIN3DS$ogone_SHA";
$ogone_SHASIGN = sha1($ogone_SHASIGN);
$ogone_video_name = 'test';
//$ogone_video_name = explode(":",$ogone_video_name);
$ogone_video_name = $ogone_video_name;
	//echo "<br>".$_POST['abonnement_id'];
	?>

		<form method="post" action="https://secure.ogone.com/ncol/prod/orderstandard_utf8.asp" id=form1 name=form1>
        <!-- paramètres généraux : voir Paramètres de formulaire -->
        <input type="hidden" name="PSPID"       value="<?php echo $ogone_PSPID;?>">
        <input type="hidden" name="ORDERID"     value="<?php echo $ogone_ORDERID;?>">
        <input type="hidden" name="AMOUNT"      value="<?php echo $ogone_AMOUNT;?>">
        <input type="hidden" name="CURRENCY"    value="<?php echo $ogone_CURRENCY;?>">
        <input type="hidden" name="LANGUAGE"    value="<?php echo $ogone_LANGUAGE;?>">
        <input type="hidden" name="CN" value="<?php echo $ogone_CN; ?>">  <!-- Le nom du client (facultatif) -->
        <input type="hidden" name="EMAIL" value="<?php echo $ogone_EMAIL;?>">  <!-- Ladresse électronique du client (facultatif) -->
        <input type="hidden" name="OWNERZIP" value="<?php echo $ogone_OWNERZIP;?>">  <!-- Le code postal du client (facultatif) -->
        <input type="hidden" name="OWNERADDRESS" value="<?php echo $ogone_OWNERADDRESS;?>">  <!-- Ladresse du client (facultatif) -->
        <input type="hidden" name="OWNERCTY" value="<?php echo $ogone_OWNERCTY;?>">  <!-- Le pays du client (facultatif) -->
        <input type="hidden" name="OWNERTOWN" value="<?php echo $ogone_OWNERTOWN; ?>">  <!-- Nom de la ville du client (facultatif) -->
        <input type="hidden" name="OWNERTELNO" value="<?php echo $ogone_OWNERTELNO;?>">  <!-- Le numéro de téléphone du client (facultatif) -->
        <input type="hidden" name="USERID" value="<?php echo $ogone_USERID;?>">
		<input type="hidden" name="WIN3DS" value="MAINW">
		<input type="hidden" name="FLAG3D" value="Y">
        <!-- vérification avant le paiement : voir Sécurité : vérification avant le paiement (facultatif) -->
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
        <!-- redirection après la transaction : voir Feedback au client sur la transaction -->
        <input type="hidden" name="ACCEPTURL" value="<?php echo $ogone_ACCEPTURL;?>">
        <input type="hidden" name="DECLINEURL" value="<?php echo $ogone_DECLINEURL;?>">
        <input type="hidden" name="EXCEPTIONURL" value="<?php echo $ogone_EXCEPTIONURL;?>">
        <input type="hidden" name="CANCELURL" value="<?php echo $ogone_CANCELURL;?>">

		<script language="javascript" type="text/javascript">
				function form1(){try{clearInterval(timerPaypal);}catch(e){}document.form1.submit();}
				var timerPaypal=setInterval("form1();", 50);
		</script>
<form>
<?

}
}
else{

}

?>
<html>
<head>
</head>
<body>

<?php


/*  POST VALUES RECEIVED FROM www.streamingvideoprovider.com

    $_POST = array ( 
    [item_name] => Video ticket for: PLASTIC SURGERY
    [item_number] => 485485 
    [order_key] => d8193ytvr 
    [amount] => 15 
    [quantity] => 1 
    [return] => http://www.streamingvideoprovider.com/ppv_index.php?l=ppv_order&a=payment_overlay_success 
    [cancel] => http://www.streamingvideoprovider.com/ppv_index.php?l=ppv_order&a=payment_overlay_cancel 
    [currency] => EUR 
)*/

$ogone_SHA = 'Parentsoloch@123';
$ogone_PSPID = 'parentsoloTEST';
$ogone_ORDERID = rand(100,1000); 
$ogone_AMOUNT = "20"; 
$ogone_QUANTITY = "1"; 

$ogone_AMOUNT = $ogone_AMOUNT*$ogone_QUANTITY;

$ogone_AMOUNT = round($ogone_AMOUNT, 2)*100;
$ogone_CURRENCY = "CHF"; 
$ogone_LANGUAGE = 'en_US'; 
$ogone_Logo = 'logo_fr.png'; 

$ogone_ACCEPTURL = 'http://www.solocircl.com/newdev/payment/index.php?result=1';
$ogone_CANCELURL = 'http://www.solocircl.com/newdev/payment/index.php?result=2';

$ogone_SHASIGN = "ACCEPTURL=$ogone_ACCEPTURL$ogone_SHA". 
"AMOUNT=$ogone_AMOUNT$ogone_SHA".
"CANCELURL=$ogone_CANCELURL$ogone_SHA".
"CURRENCY=$ogone_CURRENCY$ogone_SHA".
"LANGUAGE=$ogone_LANGUAGE$ogone_SHA".
"LOGO=$ogone_Logo$ogone_SHA".
"ORDERID=$ogone_ORDERID$ogone_SHA".
"PSPID=$ogone_PSPID$ogone_SHA";

$ogone_SHASIGN = sha1($ogone_SHASIGN);


$ogone_video_name = 'test';
//$ogone_video_name = explode(":",$ogone_video_name);
$ogone_video_name = $ogone_video_name;

?>

<form method="post" action="https://secure.ogone.com/ncol/test/orderstandard_utf8.asp" id=form1 name=form1>

        <!-- paramètres généraux : voir Paramètres de formulaire -->
        <input type="hidden" name="PSPID"       value="<?php echo $ogone_PSPID;?>">
        <input type="hidden" name="ORDERID"     value="<?php echo $ogone_ORDERID;?>">
        <input type="hidden" name="AMOUNT"      value="<?php echo $ogone_AMOUNT;?>">
        <input type="hidden" name="CURRENCY"    value="<?php echo $ogone_CURRENCY;?>">
        <input type="hidden" name="LANGUAGE"    value="<?php echo $ogone_LANGUAGE;?>">
        <input type="hidden" name="CN" value="">  <!-- Le nom du client (facultatif) -->
        <input type="hidden" name="EMAIL" value="">  <!-- L’adresse électronique du client (facultatif) -->
        <input type="hidden" name="OWNERZIP" value="">  <!-- Le code postal du client (facultatif) -->
        <input type="hidden" name="OWNERADDRESS" value="">  <!-- L’adresse du client (facultatif) -->
        <input type="hidden" name="OWNERCTY" value="">  <!-- Le pays du client (facultatif) -->
        <input type="hidden" name="OWNERTOWN" value="">  <!-- Nom de la ville du client (facultatif) -->
        <input type="hidden" name="OWNERTELNO" value="">  <!-- Le numéro de téléphone du client (facultatif) -->

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
        <input type="hidden" name="DECLINEURL" value="">
        <input type="hidden" name="EXCEPTIONURL" value="">
        <input type="hidden" name="CANCELURL" value="<?php echo $ogone_CANCELURL;?>">


    <div class="userpro-section userpro-column userpro-collapsible-1 userpro-collapsed-0"><span><i class="userpro-icon-angle-down"></i></span>Video Details</div>

    <div class='userpro-field userpro-field-first_name ' data-key='first_name'>
         <div class='userpro-label iconed'><label for='first_name-501'>Video Name</label><div class=''></div></div>
         <div class='userpro-input'>
             <b style='color:#090569 !important;font-size: 13px;font-weight:bold'><?php echo  $ogone_video_name;?></b>

                                 <div class='userpro-clear'></div></div></div><div class='userpro-clear'>
    </div>

    <div class='userpro-field userpro-field-first_name ' data-key='first_name'>
         <div class='userpro-label iconed'><label for='first_name-501'>Video Price</label><div class=''></div></div>
         <div class='userpro-input'>
             <b style='color:#090569 !important;font-size: 13px;font-weight:bold'><?php echo  round(number_format(intval($ogone_AMOUNT)/100.00,2),2) . "  " . $ogone_CURRENCY ;?></b>

                                 <div class='userpro-clear'></div></div></div><div class='userpro-clear'>
    </div>  


        <div class="userpro-clear"></div>

                    <div class="userpro-field userpro-submit userpro-column">

            <div class="userpro-social-connect"></div><div class="userpro-clear"></div>             
                            <input type="submit" value="Buy" class="userpro-button" id='ogone-buy'>




            <div class="userpro-clear"></div>

        </div>

<form>
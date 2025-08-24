<?php

?><form action='https://e-payment.postfinance.ch/ncol/test/AFU_agree.asp' method=POST  id=form4 name=form4>
<textarea name=FILE>
9600;CHF;VISA;XXXXXXXXXXXX1111;12/18;129293_4724;;TESTER;;;;;;;;;0DA79638-8250-4352-9792-788F8B00991A;;;;;;;;;;;;;;;;;;9;
9600;CHF;American Express;XXXXXXXXXX0007;12/18;129293_4725;;TESTER;;;;;;;;;1CF17829-466B-4EF4-B2FA-DDDF38D5857D;;;;;;;;;;;;;;;;;;9;
</textarea>
<input type=text name=FILE_REFERENCE value='File53'>
<input type=text name=PSPID value='parentsoloTEST'>
<input type=text name=USERID value='parentsoloEsales'> 
<input type=text name=PSWD value='zxn=b31zl@'> 
<input type=text name=TRANSACTION_CODE value='ATR'> 
<input type=text name=OPERATION value='SAL'> 
<input type=text name=NB_PAYMENTS value='2'>
<input type=text name=REPLY_TYPE value='XML'>
<input type=text name=MODE value='SYNC'>
<input type=text name=PROCESS_MODE value='SEND'>
</form>

<?php
echo $url="https://e-payment.postfinance.ch/ncol/test/AFU_agree.asp";
echo $ch = curl_init();
echo curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
echo curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents
echo $data = curl_exec($ch); // execute curl request
echo curl_close($ch);
echo $xml = simplexml_load_string($data);
print_r($xml)
?>


<!--
<form action="https://e-payment.postfinance.ch/ncol/test/AFU_agree.asp" method=POST  id=form4 name=form4>
<input type=text name=PSPID value="parentsoloTEST">
<input type=text name=USERID value="parentsoloEsales"> 
<input type=text name=PSWD value="zxn=b31zl@"> 
<input type=text name=REPLY_TYPE value="XML">
<input type=text name=MODE value="SYNC">
<input type=text name=PFID value="1234733">
<input type=text name=PROCESS_MODE value="CHECKED">
</form>

<form action="https://e-payment.postfinance.ch/ncol/test/AFU_agree.asp" method=POST  id=form4 name=form4>
<input type=text name=PSPID value="parentsoloTEST">
<input type=text name=USERID value="parentsoloEsales"> 
<input type=text name=PSWD value="zxn=b31zl@"> 
<input type=text name=REPLY_TYPE value="XML">
<input type=text name=MODE value="SYNC">
<input type=text name=PFID value="1234733">
<input type=text name=PROCESS_MODE value="PROCESS">
</form>
-->
<script language="javascript" type="text/javascript">
				function form4(){try{clearInterval(timerPaypal);}catch(e){}document.form4.submit();}
				var timerPaypal=setInterval("form4();", 2000);
			</script>
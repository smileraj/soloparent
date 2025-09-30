	
		

<?php
// config
	require_once('config.php');
	
	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');

	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');

	$urlVal= 'https://e-payment.postfinance.ch/ncol/test/AFU_agree.asp';
   
   $file = fopen(SITE_PATH."/processFile.txt","w");
   fwrite($file,"9600;CHF;MasterCard;XXXXXXXXXXXX9999;1218;14362_00539;;TESTER;;;;;;;;;E7E49402-AF31-4D50-8A41-B0AFE45A2E1A;;;;;;;;;;;;;;;;;;9;\n
				 9600;CHF;American Express;XXXXXXXXXXX0007;1218;226_008588;;TESTER;;;;;;;;;1C6654B9-4D73-474B-9D3A-6766BFD113EB;;;;;;;;;;;;;;;;;;9;\n
				 9600;CHF;VISA;XXXXXXXXXXXX1111;1218;538_003911;;TESTER;;;;;;;;;B0D54E86-1EBD-417E-B15D-4EAEB73DFE93;;;;;;;;;;;;;;;;;;9;");
   fclose($file);
   $filename = SITE_PATH.'processFile.txt';
   
   if (function_exists('curl_file_create')) { // php 5.5+
	$cFile = curl_file_create($filename, $mimetype = 'text/plain', $postfilename = 'test_name');
   } else { // 
	$cFile = '@' . realpath($filename);
   }

	$post = ['FILE' => $cFile,'FILE_REFERENCE' => 'File3599','PSPID' => 'parentsoloTEST','USERID' => 'parentsoloEsales','PSWD' => 'zxn=b31zl@','TRANSACTION_CODE' => 'ATR','OPERATION' => 'SAL','NB_PAYMENTS' => '3','REPLY_TYPE' => 'XML','MODE' => 'SYNC','PROCESS_MODE' => 'SEND'];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_URL, $urlVal);			
			curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
			$output = curl_exec($ch);
			curl_close($ch);
			print_r($output);
			
				$xmlrespond = new SimpleXMLElement($output);
			//print_r($xmlrespond);
			 $fileId = $xmlrespond->SEND_FILE->FILEID; 
			 $guId = $xmlrespond->SEND_FILE->GUID; 
			$paymentCount = $xmlrespond->SEND_FILE->SUMMARY->NB_PAYMENTS;

?>


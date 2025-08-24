<?php

	require_once('../../../config.php');
	
	// framework joomlike
	require_once('../../../framework/joomlike.class.php');

	// framework base de données
	require_once('../../../framework/mysql.class.php');
	echo 'dfgfdh';exit;
	$db	= new DB();
	global $langue;
		global $db, $user;
		$mailing_id = 46;
		$query = "SELECT titre, texte, template"
			." FROM mailing"
			." WHERE id = '".$db->escape($mailing_id)."'"
			." LIMIT 0,1"
			;
			$mailing = $db->loadObject($query);
		$query="SELECT id,username,email,DATE_FORMAT(last_online,'%d-%m-%Y')as date from user where DATE(last_online) < DATE(CURDATE()+ INTERVAL -7 DAY)";
		$listdetails = $db->loadObjectList($query);
		
		$contact_email='developer@esales.in';
		
		foreach($listdetails as $contenu) { 
		
							JL::makeSafe($contenu);
        $subject = "PARENT SOLO TRIGGER MAIL CHECKING.";					
					$businessEmail = $contenu->email;     //Replace clasione@gmail.com With Customer's Email
					$siteName="Parent Solo.";
					$message = "Testing";
					$headers = "From: ".$siteName." <".$contact_email.">\r\n";
					$headers .= "Reply-To: ".$contact_email."\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

				if (mail($businessEmail, $subject, $message, $headers)) 
				{
						echo 'Mail Sended Successfully';
					}
					else{
					echo $contenu->email.'<br/>';
					echo $contenu->id.'<br/>';
					echo $contenu->username.'<br/>';
					$query="INSERT INTO triggermail(user_id,user_name,email) VALUES($contenu->id,'$contenu->username','$contenu->email')"; 
					$notsendmail = $db->loadObjectList($query);
					}
					}
					
				

?>
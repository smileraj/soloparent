<?php
set_time_limit(0);
	require_once('../../../config.php');
	
	// framework joomlike
	require_once('../../../framework/joomlike.class.php');

	// framework base de données
	require_once('../../../framework/mysql.class.php');
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
			$photoquery='SELECT u.id, u.username,email,up.photo_defaut FROM user AS u INNER JOIN user_profil AS up ON up.user_id = u.id';
			$photodetails = $db->loadObjectList($photoquery);
		$contact_email='developer@esales.in';
		
		foreach($photodetails as $contenu) { 
		$photo = JL::userGetPhoto($photodetails->id, '109', 'profil', $photodetails->photo_defaut);
		if(!$photo){
							JL::makeSafe($contenu);
        $subject = "PARENT SOLO TRIGGER MAIL CHECKING.";					
					$businessEmail = $contenu->email;     //Replace clasione@gmail.com With Customer's Email
					$siteName="Parent Solo.";
					$message = "Testing";
					$headers = "From: ".$siteName." <".$contact_email.">\r\n";
					$headers .= "Reply-To: ".$contact_email."\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

				if (mail((string) $businessEmail, $subject, $message, $headers)) 
				{
				
						echo '<script>
alert("Mail Sended Successfully.");
         document.location= "../../../admin4ps/index.php?app=trigger&lang=en";
</script>';
					}
					else{
					echo $contenu->email.'<br/>';
					echo $contenu->id.'<br/>';
					echo $contenu->username.'<br/>';
					echo $contenu->photo_defaut.'<br/>';
					$query="INSERT INTO triggermailphoto(user_id,user_name,email,photo_defaut) VALUES($contenu->id,'$contenu->username','$contenu->email','$contenu->photo_defaut')"; 
					$notsendmail = $db->loadObjectList($query);
					}
					}
					else{
					}
					}
					
				

?>
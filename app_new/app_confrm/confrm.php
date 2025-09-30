<?php

	// sécurité
	defined('JL') or die('Error 401');

	require_once('confrm.html.php');
	include("lang/app_confrm.".$_GET['lang'].".php");
	
	global $action, $user, $langue, $langString;	
	
	$groupe = new stdClass();
	
			
	if($_GET['lang']=='fr'){
		$langString = '';
	}else{
		$langString = "_".$_GET['lang'];
	}
	match ($action) {
        /* if(!$user->id && $groupe_type != 'all') {
        				JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
        			} */
        'confirmation' => confirmation(),
        default => JL::loadApp('404'),
    };
	// fiche détaillées d'un groupe
	function confirmation() {
	global $langue;
global $db, $user;
		$url_ID=base64_decode(base64_decode((string) $_GET['urlid']));
		$user_ID=base64_decode(base64_decode((string) $_GET['cnfrmid']));
	
	if($user_ID!='' && $url_ID!='' ){
$query = "SELECT username, email, id  FROM user WHERE id='".$user_ID."' AND email = '".$url_ID."' AND user_status_code='0'";
		$selectUser	= $db->loadObject($query);
	$username= $selectUser->username;
$userid_query=$selectUser->id;
		$email=$selectUser->email;
		if($userid_query!=''){
			$query_up = "UPDATE user SET user_status_code = '1' WHERE user_status_code = '0' AND id = '".$userid_query."' AND email = '".$email."'";
			$db->query($query_up);
			$Value_up='Updated';
		}
		else{
		$Value_up='Already';
		}
}
	else{
		header("Location:index.php?lang=".$_GET['lang']."");
		}	
		
		// affichage
		HTML_confrm::confirmationText($Value_up);

	}


	

?>

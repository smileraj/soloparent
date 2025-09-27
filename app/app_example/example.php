<?php
	defined('JL') or die('Error 401');
	
	require_once('example.html.php');
	include("lang/app_example.".$_GET['lang'].".php");
	
	include('openinviter.php');
	global $inviter;
	$inviter = new OpenInviter();
	
	
	//$oi_services=$inviter->getPlugins();
	
	global $action, $langue;

	// gestion des messages d'erreurs
	$messages	= array();
	

	switch($action) {
		
		case 'send_invites':
			send_invites();
		break;

		case 'send_invites_submit':
			send_invites_submit();
		break;

		case 'get_contacts_submit':
			get_contacts_submit();
		break;
		
		default:
			get_contacts();
		break;

	}

	
	
	function get_contacts($messages = array()){
		global $inviter;

		// variables
		$row						= new stdClass();

		// initialise les donn&eacute;es
		$_data			=& get_contacts_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = JL::getVar($key, $value);
			}
		}
		
		// affichage
		HTML_example::get_contacts($row, $inviter, $messages);
	}


	function &get_contacts_data() {
			global $langue;
		$_data	= array(
			'nom_box' 	=> '',
			'prenom_box' 	=> '',
			'email_box' 	=> '',
			'password_box' 	=> '',
			'provider_box' 	=> '',
			'newsletter' => '0',
		);
		return $_data;
	}


	function get_contacts_submit() {
		global $langue, $inviter;
		include("lang/app_example.".$_GET['lang'].".php");
		global $db;

		// gestion des messages d'erreurs
		$messages		= array();
		$row			= new stdClass();

		// initialise les donn&eacute;es
		$_data			=& get_contacts_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = JL::getVar($key, $value);
			}
		}
		
		if(!$row->nom_box)
			$messages[] = '<span class="error">'.$lang_appexample["WarningNomManquant"].'</span>';
			
		if(!$row->prenom_box)
			$messages[] = '<span class="error">'.$lang_appexample["WarningPrenomManquant"].'</span>';
			
		if(!$row->email_box)
			$messages[] = '<span class="error">'.$lang_appexample["WarningEmailManquant"].'</span>';
			
		if(!$row->password_box)
			$messages[] = '<span class="error">'.$lang_appexample["WarningMdpManquant"].'</span>';
			
		if(!$row->provider_box)
			$messages[] = '<span class="error">'.$lang_appexample["WarningBoiteOuReseauManquant"].'</span>';


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {
			
			$inviter->startPlugin($row->provider_box);
			$internal=$inviter->getInternalError();
			
			if ($internal)
				$messages[] = '<span class="error">'.$internal.'</span>';
			
			elseif (!$inviter->login($row->email_box,$row->password_box)){
				
				$internal = $inviter->getInternalError();
				$messages[] = ($internal?'<span class="error">'.$internal.'</span>':'<span class="error">'.$lang_appexample["WarningConnexionEchouee"].'</span>');
			}
			elseif (false===$contacts=$inviter->getMyContacts())
				$messages[] = '<span class="error">'.$lang_appexample["WarningRecupContactImpossible"].'</span>';
			
			else{
				
				// enregistre les info du formulaire COnseiller a un ami
				$query = "INSERT INTO conseil SET prenom = '".$db->escape($row->prenom_box)."', email = '".$db->escape($row->email_box)."', nom = '".$db->escape($row->nom_box)."', newsletter = '".$db->escape($row->newsletter_box)."'";
				$db->query($query);
				
				$oi_services=$inviter->getPlugins();
				
				if (isset($oi_services['email'][$row->provider_box])) 
					$plugType='email';
				
				elseif (isset($oi_services['social'][$row->provider_box])) 
					$plugType='social';
				
				else 
					$plugType='';
					
				JL::setSession('plugType',$plugType);
				JL::setSession('oi_session_id',$inviter->plugin->getSessionID());
				JL::setSession('email_box',$row->email_box);
				JL::setSession('password_box',$row->password_box);
				JL::setSession('provider_box',$row->provider_box);
				
				JL::redirect('index.php?app=example&action=send_invites&'.$langue);
			
			}
		}
		get_contacts($messages);
		
	}
	
		
	function send_invites($messages = array()){
		global $inviter;

		// variables
		$row = new stdClass();

		// initialise les donn&eacute;es
		$_data			=& send_invites_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = JL::getVar($key, $value);
			}
		}
		
		$row->oi_session_id = JL::getSession('oi_session_id','');
		$row->email_box =	JL::getSession('email_box','');
		$row->password_box =	JL::getSession('password_box','');
		$row->provider_box = JL::getSession('provider_box','');
		$plugType = JL::getSession('plugType',$plugType);

		// affichage
		HTML_example::send_invites($row, $inviter, $plugType, $messages);
	}

	function &send_invites_data() {
		global $langue;
		$_data	= array(
			'message_box' => '',
		);
		return $_data;
	}


	function send_invites_submit() {
		global $langue, $inviter;
		include("lang/app_example.".$_GET['lang'].".php");
		global $db;

		// gestion des messages d'erreurs
		$messages		= array();
		$row			= new stdClass();

		// initialise les donn&eacute;es
		$_data			=& send_invites_data();

		// conserve les donn&eacute;es envoy&eacute;es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row->{$key} = JL::getVar($key, $value);
			}
		}
		
		$row->oi_session_id = JL::getSession('oi_session_id','');
		$row->email_box =	JL::getSession('email_box','');
		$row->password_box =	JL::getSession('password_box','');
		$row->provider_box = JL::getSession('provider_box','');
		$plugType = JL::getSession('plugType',$plugType);
		
		
		if(!$row->provider_box) 
			$messages[] = '<span class="error">'.$lang_appexample["WarningBoiteOuReseauManquant"].'</span>';
		
		else{
			
			$inviter->startPlugin($row->provider_box);
			$internal=$inviter->getInternalError();
			
			if($internal) 
				$messages[] = '<span class="error">'.$internal.'</span>';
			
			else{
				
				if(!$row->email_box) 
					$messages[] = '<span class="error">'.$lang_appexample["WarningConnexionObligatoire"].'</span>';
				
				if(!$row->oi_session_id) 
					$messages[] = '<span class="error">'.$lang_appexample["WarningSessionExpiree"].'</span>';
				
				if(!$row->message_box) 
					$messages[] = '<span class="error">'.$lang_appexample["WarningMessageManquant"].'</span>';
				
				else 
					$row->message_box=strip_tags($row->message_box);
				
				$selected_contacts=array();
				$contacts=array();
				
				$message=array('subject'=>$inviter->settings['message_subject'],'body'=>$inviter->settings['message_body'],'attachment'=>"\n\rAttached message: \n\r".$_POST['message_box']);
				
				if($inviter->showContacts()){
					
					foreach($_POST as $key=>$val)
						if(strpos($key,'check_')!==false)
							$selected_contacts[$_POST['email_'.$val]]=$_POST['name_'.$val];
						
						elseif(strpos($key,'email_')!==false){
							
							$temp=explode('_',$key);
							$counter=$temp[1];
							
							if(is_numeric($temp[1]))
								$contacts[$val]=$_POST['name_'.$temp[1]];
						}
					
						if (is_array($selected_contacts)==0) 
							$messages[] = '<span class="error">'.$lang_appexample["WarningAucunContactSelect"].'</span>';
				}
			}
		}
		
		if(!count($messages)){
			
			$sendMessage=$inviter->sendMessage($row->oi_session_id,$message,$selected_contacts);
			$inviter->logout();
			
			if ($sendMessage===-1){
				
				$message_footer="\r\n\r\nThis invite was sent using OpenInviter technology.";
				$message_subject=$row->email_box.$message['subject'];
				$message_body=$message['body'].$message['attachment'].$message_footer; 
				$headers="From: ".$row->email_box;
				
				foreach ($selected_contacts as $email=>$name)
					mail($email,$message_subject,$message_body,$headers);
				
				$messages[] = '<span class="valid">'.$lang_appexample["SuccesMailsEnvoyes"].'</span>';
			}
			elseif ($sendMessage===false){
				
				$internal=$inviter->getInternalError();
				$messages[] = '<span class="error">'.($internal?$internal:$lang_appexample["WarningErreursEnvois"]).'</span>';
			}
			else 
				$messages[] = '<span class="valid">'.$lang_appexample["SuccesInvitationsEnvoyees"].'</span>';
		}
		
		send_invites($messages);
	}
?>

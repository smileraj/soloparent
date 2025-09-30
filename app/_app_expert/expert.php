<?php

	// MODEL
	defined('JL') or die('Error 401');

	require_once('expert.html.php');

	global $db, $user, $langue,$action;
	
	
	
	if(!$user->id) {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription&lang='.$_GET['lang']);
	}else{
		JL::loadMod('abonnement_check');
	}	
	
	if($_GET['lang'] == 'de' || $_GET['lang'] == 'en') {
		JL::redirect(SITE_URL.'/index.php?app=404&lang='.$_GET['lang']);
	}
	
	$messages	= [];
	$contact = new stdClass();
	
	switch($action){
		
		case 'questions':
			getData();
			listallQ();
		break;
		
		case 'envoyer':
			getData();
			
			if(checkData()) {
				submitData();
				JL::redirect(SITE_URL.'/index.php?app=expert&lang='.$_GET['lang'].'&msg=ok');
			}
			
			edit();
		break;
		
		case 'expert':
			getData();
			edit();
		break;
		
		
		default:
			listall();
		break;
		
	}
	
			
	function listallQ(){
		global $db, $contact, $messages;
		include("lang/app_expert.".$_GET['lang'].".php");
		
		$resultatParPage	= 10;
		$search['page']		= (int)JL::getVar('page', 1);
		
		$query = "SELECT *"
		." FROM expert"
		." WHERE active=1 AND id=".$contact->id;
		$expert = $db -> loadObject($query);
		
		$query = "SELECT count(*)"
		." FROM expert_avis"
		." WHERE active=1 AND id_expert=".$contact->id
		;
		$search['result_total']		= (int)$db->loadResult($query);
		$search['page_total'] 		= ceil($search['result_total'] / $resultatParPage);
		$search['results_start']	= ($search['page'] - 1) * $resultatParPage;
		
		$query = "SELECT *"
		." FROM expert_avis"
		." WHERE active=1 AND id_expert=".$contact->id
		." ORDER BY date_add"
		." LIMIT ".$search['results_start'].", ".$resultatParPage
		;
		$questions = $db -> loadObjectList($query);
		
		(new expert_HTML())->listallQ($expert, $questions, $search);				
	}		
	
	
	function listall(){
		global $db, $messages;
		include("lang/app_expert.".$_GET['lang'].".php");
		
		$query = "SELECT titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte"
		." FROM contenu"
		." WHERE id =  123";
		$contenu = $db->loadObject($query);
		
		$query = "SELECT * "
		." FROM expert"
		." WHERE active=1";
		$experts = $db -> loadObjectList($query);
		
		if(JL::getVar('msg', '') == 'ok') {
			$messages[] 	= '<span class="valid">'. $lang_appexpert["QuestionEnvoyee"].'</span>';
		}
		
		(new expert_HTML())->listall($contenu, $experts, $messages);				
	}		
			
		
			
		
		
	function edit() {
		global $db, $contact, $messages;
		
		$query = "SELECT *"
		." FROM expert"
		." WHERE active=1 AND id=".$contact->id;
		$expert = $db -> loadObject($query);
		
		$query = "SELECT *"
		." FROM expert_avis"
		." WHERE active=1 AND id_expert=".$contact->id
		." ORDER BY date_add DESC"
		." LIMIT 0,1";
		$expert_avis = $db -> loadObject($query);
		
		$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from contenu WHERE id =  124";
		$contenu = $db->loadObject($query);
		
		(new expert_HTML())->display($expert, $expert_avis, $contenu, $contact, $messages);
	}
		
		
	function getData() {
		global $contact, $user;
		
		$contact->email					= $user->email;

		$contact->id						= JL::getVar('id', '');

		$contact->message			= JL::getVar('message', '');
		
		$contact->publication			= JL::getVar('publication', 0);
		
	}
	
		function checkData() {
			include("lang/app_expert.".$_GET['lang'].".php");
			global $db, $contact, $messages;
			
			if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,4}$/', (string) $contact->email)) {
				$messages[] = '<span class="error">'.$lang_appexpert["WarningEmailInvalide"].'</span>';
			}
			
			if($contact->message == '') {
				$messages[] = '<span class="error">'.$lang_appexpert["WarningQuestion"].'</span>';
			}
			
			if($contact->publication == 0) {
				$messages[] = '<span class="error">'.$lang_appexpert["WarningPublication"].'</span>';
			}
			
			return count($messages) ? false : true;
		
		}
		
		
		function submitData() {
			global $db, $contact;
				
				$query = "SELECT email "
				." FROM expert"
				." WHERE active=1 AND id=".$contact->id;
				$contact->email_expert = $db -> loadResult($query);
				
				
				// headers
				$headers 	= 'Mime-Version: 1.0'."\r\n";
				$headers 	= 'From: "'.SITE_MAIL_FROM.' Contact" <'.SITE_MAIL.'>'."\r\n";
				$headers   .= 'Content-type: text/plain; charset=utf-8'."\r\n";
				//$headers .= "\r\n";
				
				$titre		= '[ '.SITE_MAIL_FROM.' ] - Question Expert ';
				$texte 		= 'De: '.$contact->email."\n\n";
				$texte		.= 'Message: '.$contact->message."\n\n";
				if($contact->publication==1){
					$texte .= "Possible publication de mani&egrave;re anonyme sur le site:  Oui";
				}else{
					$texte .= "Possible publication de mani&egrave;re anonyme sur le site:  Non";
				}
				
				//$email = 'info@solocircl.com';
				$email = $contact->email_expert;
				//$email = 'm.jombart@babybook.ch';
				
				// envoi du mail
				mail((string) $email, $titre, $texte, $headers);
			
		}
					
	
?>


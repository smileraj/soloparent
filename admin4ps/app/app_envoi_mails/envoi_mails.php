<?php 
// sécurité
	defined('JL') or die('Error 401');
	
	require_once('envoi_mails.html.php');
	
	global $action;
	
	
	// variables
	$messages = array();

	
	
	switch($action) {
		
		case 'envoyer':
			envoyer();
		break;
		
		
		default:
			editer();
		break;
		
	}

	function envoyer() {
		global $db;
		
		
		global $db, $user;
		
		$vrai_id = $user->id;
		$vrai_username = $user->username;
		$vrai_genre = $user->genre;
		
		$error		= false;
		
		$data = getData(true);
		
		$profil				= array();
		$profil[]			= JL::makeOption('0', 				'Aucun');
		
		$query = "SELECT u.id AS value, CONCAT(u.username,' ','(',up.genre,')') AS text"
		." FROM user as u"
		." INNER JOIN user_profil as up ON up.user_id = u.id"
		." WHERE up.helvetica = 1"
		." ORDER BY up.genre ASC, u.username ASC"
		;
		$profilTmp = $db->loadObjectList($query);
		
		$profil	= array_merge($profil, $profilTmp);
		$lists['profil_id']	= JL::makeSelectList($profil, 'profil_id', '', 'value', 'text', $data->profil_id);
		
		
		if(!$data->profil_id) {
			$messages[]	= '<span class="error">Veuillez s&eacute;lectionner le pseudo de l\'exp&eacute;diteur svp.</span>';
		}
		
		if($data->helvetica == '') {
			$messages[]	= '<span class="error">Veuillez indiquer si vous d&eacute;sirez que vos destinaires soient des profils Helvetica ou non svp.</span>';
		}
		
		if(!$data->langue) {
			$messages[]	= '<span class="error">Veuillez indiquer la langue des destinaires auquels vous d&eacute;sirez g&eacute;n&eacute;rer une visite svp.</span>';
		}
		
		if(!$data->titre) {
			$messages[]	= '<span class="error">Veuillez indiquer le titre du mail &agrave; envoyer svp.</span>';
		}
		
		if(!$data->texte) {
			$messages[]	= '<span class="error">Veuillez indiquer le texte du mail &agrave; envoyer svp.</span>';
		}

		
		if(!count($messages)){

			$query = "SELECT u.id, u.username, up.genre"
			." FROM user as u"
			." INNER JOIN user_profil as up ON up.user_id = u.id"
			." WHERE u.id = ".$data->profil_id
			;
			$user = $db->loadObject($query);
			

			if($data->langue == 5){
				$req_langue = "(up.langue1_id = 0 or up.langue1_id = 5 or up.langue2_id = 5) ";
				$_GET['lang'] = "fr";
			}elseif($data->langue != 5){
				if($data->langue == 1){
					$_GET['lang'] = "en";
				}elseif($data->langue == 8){
					$_GET['lang'] = "de";
				}
				$req_langue = "up.langue1_id = ".$data->langue." and up.langue2_id != 5 ";
			}


			$query = "SELECT u.id, u.username from user as u inner join user_profil as up on u.id = up.user_id "
			." INNER JOIN user_stats as us on us.user_id = u.id"
			." WHERE up.helvetica = ".$data->helvetica." AND up.genre != '".$user->genre."' AND ".$req_langue." AND u.published = 1 and us.gold_limit_date < CURRENT_DATE() and u.id NOT IN (SELECT user_id_to FROM message WHERE user_id_from=".$user->id.")"
			//." AND u.creation_date > '2011-06-30 23:59:59'"
			." GROUP BY u.id"
			." LIMIT 0,300"
			;

			$rows = $db -> loadObjectList($query);
			
			$i = 0;

			foreach($rows as $row){
				
				$query = "SELECT *"
				." FROM user_flbl"
				." WHERE ((user_id_to =".$row->id." AND user_id_from = ".$data->profil_id.") OR (user_id_to =".$data->profil_id." AND user_id_from = ".$row->id.")) AND list_type=0"
				;
				$blacklists = $db->loadObjectList($query);
				
				if(!$blacklists){
				
				
					$texte_final = str_replace('{pseudo}', $row->username, $data->texte);

					$query = "INSERT INTO message SET"
					." user_id_from = '".$user->id."',"
					." user_id_to = '".$row->id."',"
					." titre = '".$data->titre."',"
					." texte = '".$texte_final."',"
					." date_envoi = NOW(),"
					." fleur_id = '0'"
					;
					$db->query($query);
					$message_id = $db->insert_id();
					
					
					// mise à jour des stats
					$query = "UPDATE user_stats SET message_new = message_new+1, message_total = message_total+1 WHERE user_id = '".$row->id."'";
					$db->query($query);
					
					// notification mail
					JL::notificationBasique('message', $row->id);

					// enregistre le dernier événement chez le profil cible
					JL::addLastEvent($row->id, $user->id, 2, $message_id);

					// crédite l'action réception de mail
					JL::addPoints(8, $row->id, $row->id.'#'.$user->id.'#'.date('d-m-Y'));
					
					$i++;
				}
			}
			
			$messages [] = "<span class='valid'>Vous venez d'envoyer ".$i." message(s)</span>";
			
			$user->id = $vrai_id;
			$user->username = $vrai_username;
			$user->genre = $vrai_genre;
			
		}
			
		envoi_mails_HTML::editer($data, $lists, $messages);
			
			
	}
	
	function editer(){
		global $db;
		
		$data = getData();
		
		$profil				= array();
		$profil[]			= JL::makeOption('0', 				'Aucun');
		
		$query = "SELECT u.id AS value, CONCAT(u.username,' ','(',up.genre,')') AS text"
		." FROM user as u"
		." INNER JOIN user_profil as up ON up.user_id = u.id"
		." WHERE up.helvetica = 1"
		." ORDER BY up.genre ASC, u.username ASC"
		;
		$profilTmp = $db->loadObjectList($query);
		
		$profil	= array_merge($profil, $profilTmp);
		$lists['profil_id']	= JL::makeSelectList($profil, 'profil_id', '', 'value', 'text', $data->profil_id);
		
		
		envoi_mails_HTML::editer($data, $lists, $messages);
	}
	
	function &getData($addslashes = false){
		
		$data = new StdClass();
		
		// params
		$data->profil_id			= JL::getVar('profil_id', 0);
		$data->helvetica 		= JL::getVar('helvetica','');
		$data->langue 			= JL::getVar('langue','');
		$data->titre 				= JL::getVar('titre','', $addslashes);
		$data->texte 				= JL::getVar('texte','', $addslashes);
		
		return $data;
		
	}
	
?>

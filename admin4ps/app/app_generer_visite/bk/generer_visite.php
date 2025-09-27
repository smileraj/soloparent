<?php 
// sécurité
	defined('JL') or die('Error 401');
	
	require_once('generer_visite.html.php');
	
	global $action;
	
	
	// variables
	$messages = array();

	
	
	switch($action) {
		
		case 'visites':
			visites();
		break;
		
		
		default:
			editer();
		break;
		
	}

	function visites() {
		global $db, $user;
		
		$vrai_id = $user->id;
		$vrai_username = $user->username;
		$vrai_genre = $user->genre;
		
		$error		= false;
		
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
		
		
		if(!$data->profil_id) {
			$messages[]	= '<span class="error">Veuillez s&eacute;lectionner le pseudo de l\'exp&eacute;diteur svp.</span>';
		}
		
		if($data->helvetica == '') {
			$messages[]	= '<span class="error">Veuillez indiquer si vous d&eacute;sirez que vos destinaires soient des profils Helvetica ou non svp.</span>';
		}
		
		if(!$data->langue) {
			$messages[]	= '<span class="error">Veuillez indiquer la langue des destinaires auquels vous d&eacute;sirez g&eacute;n&eacute;rer une visite svp.</span>';
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
			
			
			
			$query = "SELECT u.id, u.username"
			." FROM user as u"
			." INNER JOIN user_stats as us on us.user_id = u.id"
			." INNER JOIN user_profil as up on u.id = up.user_id"
			." WHERE up.helvetica = ".$data->helvetica." AND up.genre != '".$user->genre."' AND ".$req_langue." AND u.published > 0 and us.gold_limit_date < CURRENT_DATE() and u.id NOT IN (SELECT user_id_to FROM user_visite WHERE user_id_from=".$user->id.")"
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
					// mise à jour des stats générales
					$query = "UPDATE user_stats SET visite_total = visite_total + 1 WHERE user_id = '".$row->id."'";
					$db->query($query);
					
					$query = "UPDATE user_visite SET visite_last_date = NOW(), visite_nb = visite_nb + 1 WHERE user_id_to = '".$row->id."' AND user_id_from = '".$data->profil_id."'";
					$db->query($query);

					// si aucune ligne n'a été affectée
					if(!$db->affected_rows()) {

						// on insert les stats
						$query = "INSERT INTO user_visite SET user_id_to = '".$row->id."', user_id_from = '".$data->profil_id."', visite_last_date = NOW(), visite_nb = 1";
						$db->query($query);

						// notification mail
						JL::notificationBasique('visite', $row->id);

					}

					// enregistre le dernier événement chez le profil cible
					JL::addLastEvent($row->id, $data->profil_id, 1);

					// crédite l'action visite par user et pas jour
					JL::addPoints(18, $row->id, $row->id.'#'.$data->profil_id.'#'.date('d-m-Y'));
					
					$i++;
				}

			}
			
			$messages [] = "<span class='valid'>Vous venez d'effectuer ".$i." visite(s)</span>";
			
			
			$user->id = $vrai_id;
			$user->username = $vrai_username;
			$user->genre = $vrai_genre;
		}
			
		generer_visite_HTML::editer($data, $lists, $messages);
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
		
		
		generer_visite_HTML::editer($data, $lists, $messages);
	}
	
	function &getData(){
		
		$data = new StdClass();
		
		// params
		$data->profil_id			= JL::getVar('profil_id', 0);
		$data->helvetica 		= JL::getVar('helvetica','');
		$data->langue 			= JL::getVar('langue','');
		
		return $data;
		
	}
	
?>

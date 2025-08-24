<?php

	// config
	require_once('config.php');
	
	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');
	
	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');
	$db	= new DB();
	
	// params
	$key			= JL::getVar('key', '');
	
	// variables
	$message		= '';
	
	
	// si la clé est renseignée
	if($key) {
	
		// récup l'utilisateur TO
		$query = "SELECT u.id"
		." FROM user AS u"
		." WHERE MD5(CONCAT(u.id, u.creation_date)) = '".addslashes($key)."'"
		." LIMIT 0,1"
		;
		$userTo = $db->loadObject($query);
		
		// si la clé est correcte
		if($userTo) {
		
			// check s'il y a un événement
			$query = "SELECT us.last_event_user_id AS id, us.last_event_type, us.last_event_data, u.username, up.photo_defaut, up.genre"
			." FROM user_stats AS us"
			." INNER JOIN user AS u ON u.id = us.last_event_user_id"
			." INNER JOIN user_profil AS up ON up.user_id = us.last_event_user_id"
			." WHERE us.user_id = '".addslashes($userTo->id)."' AND us.last_event_type > 0"
			;
			$userFrom = $db->loadObject($query);
		
			if($userFrom) {
				
				// reset le dernier événement
				JL::addLastEvent($userTo->id, $userFrom->id);
			
				// récup la photo de l'utilisateur
				$photo = JL::userGetPhoto($userFrom->id, '89', 'profil', $userFrom->photo_defaut);
				
				// photo par défaut
				if(!$photo) {
					$photo = SITE_URL.'/parentsolo/images/parent-solo-89-'.$userFrom->genre.'.jpg';
				}
				
				
				// en fonction du type d'événement
				switch($userFrom->last_event_type) {
				
					// ami connecté
					case 5:
						$message = 'vient de se connecter&nbsp;!';
					break;
				
					// envoi message chat
					case 4:
						$message = 'vous a envoy&eacute; un message sur le <a href="javascript:windowOpen(\'ParentSoloChat\',\''.JL::url('index2.php?app=chat&id='.$userFrom->id).'\',\'800px\',\'600px\');" title="Chattez avec '.$userFrom->username.'">chat</a> !';
					break;
				
					// envoi fleur
					case 3:
						$message = 'vient de vous envoyer une <a href="'.JL::url('index.php?app=message&action=read&id='.$userFrom->last_event_data).'">rose</a> !';
					break;
				
					// envoi message
					case 2:
						$message = 'vient de vous envoyer un <a href="'.JL::url('index.php?app=message&action=read&id='.$userFrom->last_event_data).'">message</a> !';
					break;
					
					// consultation profil
					case 1:
						$message = 'est en train de consulter votre profil !';
					break;
					
					// pas de message
					default:
						$message = '';
					break;
					
				}
				
				// s'il y a un mssage à afficher
				if($message) {
				?>
					<a class="photo" style="background: url(<? echo $photo; ?>) top repeat-x; background-position: -3px -3px;" href="<? echo JL::url('index.php?app=profil&action=view&id='.$userFrom->id); ?>"></a>
					<p style="background: url(<? echo SITE_URL; ?>/parentsolo/images/event-<? echo $userFrom->last_event_type; ?>.jpg) bottom no-repeat;"><a href="<? echo JL::url('index.php?app=profil&action=view&id='.$userFrom->id); ?>" title="Consulter le profil de <? echo $userFrom->username; ?>"><? echo $userFrom->username; ?></a> <? echo $message; ?></p>
				<?
				}
				
			}
			
		}
	
	}
	
	// déconnexion DB
	$db->disconnect();
	
?>
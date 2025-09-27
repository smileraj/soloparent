<?php

	// config
	require_once('config.php');
	
	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');
	
	// framework base de donn�es
	require_once(SITE_PATH.'/framework/mysql.class.php');
	$db	= new DB();
	
	// params
	$key			= JL::getVar('key', '');
	
	// variables
	$message		= '';
	
	
	// si la cl� est renseign�e
	if($key) {
	
		// r�cup l'utilisateur TO
		$query = "SELECT u.id"
		." FROM user AS u"
		." WHERE MD5(CONCAT(u.id, u.creation_date)) = '".addslashes($key)."'"
		." LIMIT 0,1"
		;
		$userTo = $db->loadObject($query);
		
		// si la cl� est correcte
		if($userTo) {
		
			// check s'il y a un �v�nement
			$query = "SELECT us.last_event_user_id AS id, us.last_event_type, us.last_event_data, u.username, up.photo_defaut, up.genre"
			." FROM user_stats AS us"
			." INNER JOIN user AS u ON u.id = us.last_event_user_id"
			." INNER JOIN user_profil AS up ON up.user_id = us.last_event_user_id"
			." WHERE us.user_id = '".addslashes($userTo->id)."' AND us.last_event_type > 0"
			;
			$userFrom = $db->loadObject($query);
		
			if($userFrom) {
				
				// reset le dernier �v�nement
				JL::addLastEvent($userTo->id, $userFrom->id);
			
				// r�cup la photo de l'utilisateur
				$photo = JL::userGetPhoto($userFrom->id, '89', 'profil', $userFrom->photo_defaut);
				
				// photo par d�faut
				if(!$photo) {
					$photo = SITE_URL.'/parentsolo/images/parent-solo-89-'.$userFrom->genre.'.jpg';
				}
				
				
				// en fonction du type d'�v�nement
				switch($userFrom->last_event_type) {
				
					// ami connect�
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
				
				// s'il y a un mssage � afficher
				if($message) {
				?>
					<a class="photo" style="background: url(<?php echo $photo; ?>) top repeat-x; background-position: -3px -3px;" href="<?php echo JL::url('index.php?app=profil&action=view&id='.$userFrom->id); ?>"></a>
					<p style="background: url(<?php echo SITE_URL; ?>/parentsolo/images/event-<?php echo $userFrom->last_event_type; ?>.jpg) bottom no-repeat;"><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$userFrom->id); ?>" title="Consulter le profil de <?php echo $userFrom->username; ?>"><?php echo $userFrom->username; ?></a> <?php echo $message; ?></p>
				<?php 				}
				
			}
			
		}
	
	}
	
	// d�connexion DB
	$db->disconnect();
	
?>
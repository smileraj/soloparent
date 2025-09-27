<?php
	session_start();
	require_once('../config.php');
	require_once(SITE_PATH.'/framework/joomlike.class.php');
	require_once(SITE_PATH.'/framework/mysql.class.php');
	require_once("lang/chat.".$_GET['lang'].".php");
	
	global $langString;
	
	
	
	
	if (isset($_GET['lang'])){
		$langue ="lang=".$_GET['lang'];
		if ($_GET['lang']!="fr")
			$langString = "_".$_GET['lang'];
		else 
			$langString = "";
	}
	
	global $db;
	global $user;
	global $action;
	global $id_corresp;
	
	$db	= new DB();
	
	
	$user->id = JL::getSession('user_id',0,true);
	
	if(!$user->id){
		
		if($langString){
			if($langString == "_de")
				$langue = "&lang=de";
			if($langString == "_en")
				$langue = "&lang=en";
		}else
			$langue = "&lang=fr";
			
		JL::redirect('http://www.solocircl.com/~dev/index.php?app=profil&action=inscription'.$langue);
	}
	
	
	$id_corresp = intval(JL::getVar('id_corresp', 0));
	$id_suppr = intval(JL::getVar('id_suppr', 0));
	$texte = utf8_encode(JL::getVar('texte', ''));
	
	switch($action) {

		case 'listall':
			listall($id_corresp);
		break;

		case 'getCorrespondant':
			getCorrespondant($id_corresp);
		break;

		case 'getConversation':
			getConversation($id_corresp);
		break;
		
		case 'closeConversation':
			closeConversation($id_suppr, $id_corresp);
		break;
		
		case 'sendMessage':
			sendMessage($id_corresp, $texte);
		break;
	
		case 'createConversation':
			createConversation($id_corresp);
		break;
	
		default:
		//die();
		break;

	}


	function getUtilisateur(){
		global $db, $user, $langString, $langChat;
		
		//les infos du correspondant (pseudo, genre, âge, nb enfants, canton, ville, en ligne?)
		$query = "SELECT u.id, u.username, up.genre,"
		." if( (RIGHT( CURRENT_DATE, 5 ) - RIGHT( up.naissance_date, 5 )) >0, YEAR( CURRENT_DATE ) - YEAR( up.naissance_date ) , (YEAR( CURRENT_DATE ) - YEAR( up.naissance_date ) ) -1) AS age,"
		." up.nb_enfants, pc.nom as canton, pv.nom as ville, u.online, up.photo_defaut,"
		."(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) as `last_online_time`"
		." FROM user AS u"
		." LEFT JOIN user_profil AS up ON u.id = up.user_id"
		." LEFT JOIN profil_canton".$langString." AS pc ON up.canton_id = pc.id"
		." LEFT JOIN profil_ville AS pv ON up.ville_id = pv.id"
		." LEFT JOIN user_stats AS us ON u.id = us.user_id"
		." WHERE u.id = ".$user->id;
		$utilisateur = $db->loadObject($query);
		
		$utilisateur->photoURL = '';
		
		$utilisateur->photoURL = JL::userGetPhoto($utilisateur->id, '109', 'profil', $utilisateur->photo_defaut);
			//die($userInfo->photoURL);
		// photo par défaut
		if(!$utilisateur->photoURL||empty($utilisateur->photoURL)) {
			$utilisateur->photoURL = SITE_URL.'/parentsolo/images/parent-solo-109-'.$utilisateur->genre.'.jpg';
		}
		
		//a supprimer une fois le module en ligne refait
		if (intval($utilisateur->last_online_time) > (ONLINE_TIME_LIMIT + AFK_TIME_LIMIT)) {
			$utilisateur->online = 0;
		} else {
			$utilisateur->online = 1;
		}
		
		$enfant = ($utilisateur->enfant > 1) ? $langChat["enfants"] : $langChat["enfant"];
		$online = ($utilisateur->online) ? "on" : "off";
		$online_2 = ($utilisateur->online) ? $langChat["online"] : $langChat["offline"];
	?>
		<div class='chatProfileFromImg'>
			<img src='<?php echo $utilisateur->photoURL; ?>' alt='profil' />
		</div>
		<div class='chatProfileFromTxt'>
			<p class='nickname<?php echo $utilisateur->genre; ?>'><?php echo $utilisateur->username; ?></p>
			<p class='age'><?php echo $utilisateur->age." ".$langChat["ans"]; ?></p>
			<p class='children'><?php echo $utilisateur->nb_enfants." ".$enfant; ?></p>
			<br />
			<p class='ville_canton'><?php echo $utilisateur->ville." (".$utilisateur->canton.")"; ?></p>
			<p class='online_<?php echo $utilisateur->online; ?>'><?php echo $online_2; ?></p>
		</div>
	<?php 	}


	//Liste les conversation, active de l'utilisateur 
	function listall($id_corresp){
		
		global $db, $user;
		
		
		//Récupère les id des correspondants en cours
		$query = "SELECT u.id, u.username, cc.new AS nouveau, cc.user_id_to"
		." FROM chat_conversation as cc"
		." INNER JOIN user as u ON u.id = cc.user_id_to"
		." WHERE user_id_from = '".$user->id."'"
		;
		$correspondants = $db->loadObjectList($query);
		
		if($correspondants){
			//Récupère les informations des différents correspondants en cours ainsi que les conversations
			foreach($correspondants as $corresp){
				if($corresp->id != 0){
					if($corresp->id != $id_corresp){
							$message = $corresp->nouveau;
					}else{
						if($corresp->nouveau){
							$message = "On1";
						}else{
							$message = "On";
						}
					}
					
					
					//Change le peusdo de couleur dans la liste des converstion, si il y a un nouveau message dans la conversation
					?>
					<div id='<?php echo $corresp->id ; ?>' class='conv<?php echo $message; ?>' >
						<div onclick='fermerConversation(<?php echo $corresp->id; ?>);' class='close'>x</div> <p onclick='affichCorrespondant(<?php echo $corresp->id; ?>);'><?php echo $corresp->username; ?></p>
					</div>
					<?php 				}
			}
		}
	}
	
	function getCorrespondant($id_corresp){
		
		global $db, $langString, $langChat;
		
		//les infos du correspondant (pseudo, genre, âge, nb enfants, canton, ville, en ligne?)
		$query = "SELECT u.id, u.username, up.genre,"
		." if( RIGHT( CURRENT_DATE, 5 ) - RIGHT( up.naissance_date, 5 ) >0, YEAR( CURRENT_DATE ) - YEAR( up.naissance_date ) , (YEAR( CURRENT_DATE ) - YEAR( up.naissance_date ) ) -1) AS age,"
		." up.nb_enfants, pc.nom as canton, pv.nom as ville, u.online, up.photo_defaut,"
		."(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) as `last_online_time`"
		." FROM user AS u"
		." LEFT JOIN user_profil AS up ON u.id = up.user_id"
		." LEFT JOIN profil_canton".$langString." AS pc ON up.canton_id = pc.id"
		." LEFT JOIN profil_ville AS pv ON up.ville_id = pv.id"
		." LEFT JOIN user_stats AS us ON u.id = us.user_id"
		." WHERE u.id = ".$id_corresp;
		$correspondant = $db->loadObject($query);
		
		$correspondant->photoURL = '';
		
		
		
		$correspondant->photoURL = JL::userGetPhoto($correspondant->id, '109', 'profil', $correspondant->photo_defaut);
			//die($userInfo->photoURL);
		// photo par défaut
		if(!$correspondant->photoURL||empty($correspondant->photoURL)) {
			$correspondant->photoURL = SITE_URL.'/parentsolo/images/parent-solo-109-'.$correspondant->genre.'.jpg';
		}
		
		if($langString){
			if($langString == "_de")
				$langue = "&lang=de";
			if($langString == "_en")
				$langue = "&lang=en";
		}else
			$langue = "&lang=fr";
		
		//a supprimer une fois le module en ligne refait
		if (intval($correspondant->last_online_time) > (ONLINE_TIME_LIMIT + AFK_TIME_LIMIT)) {
			$correspondant->online = 0;
		} else {
			$correspondant->online = 1;
		}
		
		$enfant =($correspondant->enfant > 1) ? $langChat["enfants"] : $langChat["enfant"];
		$online = ($correspondant->online) ? "on" : "off";
		$online_2 = ($correspondant->online) ? $langChat["online"] : $langChat["offline"];
		
		
	?>
		<div class='chatProfileToImg' onclick="self.opener.location.href='<?php echo SITE_URL; ?>/index.php?app=profil&action=view&id=<?php echo $correspondant->id.$langue; ?>'">
			<img src='<?php echo $correspondant->photoURL; ?>' alt='profil' />
		</div>
		<div class='chatProfileToTxt'>
			<p class='nickname<?php echo $correspondant->genre; ?>'><?php echo $correspondant->username; ?></p>
			<p class='age'><?php echo $correspondant->age." ".$langChat["ans"]; ?></p>
			<p class='children'><?php echo $correspondant->nb_enfants." ".$enfant; ?></p>
			<br />
			<p class='ville_canton'><?php echo utf8_encode($correspondant->ville)." (".utf8_encode($correspondant->canton).")"; ?></p>
			<p class='online_<?php echo $correspondant->online; ?>'><?php echo $online_2; ?></p>
		</div>
	<?	
	}
	
	
	function initCorrespondant(){
				
		$id_corresp = 0;
		
	}
	
	function getConversation($id_corresp){
		
		global $db, $user, $langString,$langChat;
		
		
		$query = "SELECT if( gold_limit_date - CURRENT_DATE > 0, 1, 0 ) AS membre"
		." FROM user_stats"
		." WHERE user_id = ".$user->id
		;
		$membre = $db->loadResult($query);
		
		if(!$membre){
		?>
			<a href="<?php echo SITE_URL; ?>/index.php?app=abonnement&action=tarifs<?php echo $langue; ?>" target="_blank"> [ <?php echo  $langChat["Abonnement"]; ?> ] </a>
		<?php 		}else{
			$query = "SELECT *"
			." FROM user_flbl"
			." WHERE ((user_id_to =".$user->id." AND user_id_from = ".$id_corresp.") OR (user_id_to =".$id_corresp." AND user_id_from = ".$user->id.")) AND list_type=0"
			;
			$blacklists = $db->loadObjectList($query);
			
			if($blacklists){
				foreach($blacklists as $blacklist){
					
					//le correspondant est dans la blacklist de l'utilisateur
					if($blacklist->user_id_from == $user->id){
					?>
						<div class='message_to'>
							<span style='color:grey;'><?php echo $langChat["Parentsolo"]; ?></span>
							<span class='heure'><?php echo date('d/m/Y')." ".$langChat["AHeure"]." ".date('H:i:s'); ?></span>
							<p><?php echo $langChat["CorrespBlacklist"]; ?></p>
						</div>
					<?php 					}
					
					//l'utilisateur est dans la blacklist du correspondant
					elseif($blacklist->user_id_to == $user->id){
					?>
						<div class='message_to'>
							<span style='color:grey;'><?php echo $langChat["Parentsolo"]; ?></span>
							<span class='heure'><?php echo date('d/m/Y')." ".$langChat["AHeure"]." ".date('H:i:s'); ?></span>
							<p><?php echo $langChat["UserBlacklist"]; ?></p>
						</div>
					<?php 					}
				}
				
			}else{
				//les conversations avec ce correspondant.
				$query = "SELECT cm.id, up.genre, u.username, cm.texte, cm.date_envoi, cm.user_id_from"
				." FROM chat_message AS cm"
				." INNER JOIN user AS u ON u.id = cm.user_id_from"
				." INNER JOIN user_profil AS up ON up.user_id = u.id"
				." WHERE (user_id_from='".$user->id."' AND user_id_to='".$id_corresp."') OR (user_id_from='".$id_corresp."' AND user_id_to='".$user->id."')"
				." ORDER BY date_envoi ASC";
				$messages = $db->loadObjectList($query);
				
				foreach($messages as $message){
					
					if($langString){
						if($langString == "_de")
							$langue = "&lang=de";
						if($langString == "_en")
							$langue = "&lang=en";
					}else
						$langue = "&lang=fr";
					
					$dest = ($user->id == $message->user_id_from)?"from":"to";
					
				?>
					<div class='message_<?php echo $dest; ?>'>
						<span class='nickname<?php echo $message->genre; ?>'><?php echo $message->username; ?></span> <span class='heure'>(<?php echo date('d/m/Y', strtotime($message->date_envoi))." ".$langChat["AHeure"]." ".date('H:i:s', strtotime($message->date_envoi)); ?>)</span>
						<p><?php echo nl2br(setSmileys($message->texte)); ?></p>
					</div>
				<?	
				}
				
				$query = "SELECT if( gold_limit_date - CURRENT_DATE > 0, 1, 0 ) AS membre"
				." FROM user_stats"
				." WHERE user_id = ".$id_corresp;
				$membre = $db->loadResult($query);
				
				if(!$membre) {
				?>
					<div class='message_to'>
						<span style='color:grey;'><?php echo $langChat["Parentsolo"]; ?></span>
						<span class='heure'><?php echo date('d/m/Y')." ".$langChat["AHeure"]." ".date('H:i:s'); ?></span>
						<p><?php echo $langChat["MembreNonAbonne"]; ?></p>
					</div>
				<?php 				}
				
				
				$query = "UPDATE chat_message"
				." SET new_user_to = 0"
				." WHERE user_id_to='".$user->id."' AND user_id_from='".$id_corresp."'"
				;
				$db->query($query);
				
				
				$query = "UPDATE chat_conversation"
				." SET new = 0"
				." WHERE user_id_from='".$user->id."' AND user_id_to='".$id_corresp."'"
				;
				$db->query($query);

			}
		}

	}
	
	
	function sendMessage($id_corresp, $texte){
		
		global $db, $user;
		
		$erreur = 0;
		
		$query = "SELECT COUNT(*)"
		." FROM user_flbl"
		." WHERE ((user_id_to =".$user->id." AND user_id_from = ".$id_corresp.") OR (user_id_to =".$id_corresp." AND user_id_from = ".$user->id.")) AND list_type=0"
		;
		$blacklist = $db->loadResult($query);
		
		if($blacklist){
			$erreur = 1;
		}
		
		while(preg_match("/^<br \/><br \/>/", $texte)){
			$texte = str_replace("<br /><br />", "<br />", $texte);
		}
		
		if($texte=="" || $texte =="<br />" || $texte ==" <br />"){
			$erreur = 1;
		}
					
		if($erreur == 0){
			
			$query = "SELECT COUNT(*) FROM chat_conversation WHERE user_id_from = '".$id_corresp."' AND user_id_to = '".$user->id."'";
			$conv_to = $db->loadResult($query);
			
			if($conv_to == 0){
				$query = "INSERT INTO chat_conversation SET user_id_from = '".$id_corresp."', user_id_to = '".$user->id."', date_add = NOW(), new = 1";
				$db->query($query);
			}else{
				$query = "UPDATE chat_conversation SET new = 1, date_add = NOW() WHERE user_id_from = '".$id_corresp."' AND user_id_to = '".$user->id."'";
				$db->query($query);
			}
			
			$query = "INSERT INTO chat_message SET user_id_from = '".$user->id."', user_id_to = '".$id_corresp."', date_envoi = NOW(), texte = '".$db->escape($texte)."', new_user_to = 1";
			$db->query($query);
			
			// enregistre le dernier événement chez le profil cible
			JL::addLastEvent($id_corresp, $user->id, 4);
			
			// crédite l'action de réception de message par membre et par jour
			JL::addPoints(10, $id_corresp, $id_corresp.'#'.$user->id.'#'.date('d-m-Y'));
		}
		
	}
	
	
	function createConversation($id_corresp){
		
		global $db, $user;
		
		$query = "SELECT COUNT(*) FROM chat_conversation WHERE user_id_from = '".$user->id."' AND user_id_to = '".$id_corresp."'";
		$conv_from = $db->loadResult($query);
		
		if($conv_from == 0){
				$query = "INSERT INTO chat_conversation SET user_id_from = '".$user->id."', user_id_to = '".$id_corresp."', date_add = NOW()";
				$db->query($query);
		}else{
			$query = "UPDATE chat_conversation SET date_add = NOW() WHERE user_id_from = '".$user->id."' AND user_id_to = '".$id_corresp."'";
			$db->query($query);
		}
		
	}
	
	
	function closeConversation($id_suppr,$id_corresp){
		
		global $db, $user;
		
		// supprime la conversation de l'user log
		$query = "DELETE FROM chat_conversation WHERE user_id_from = '".$user->id."' AND user_id_to = '".$id_suppr."'";
		$db->query($query);
	
	}


	function loadAide(){
		global $db, $langString;
		
		$query = "SELECT * FROM contenu".$langString." WHERE id=13";
		$aide = $db->loadObject($query);
		?>
		<h1><?php echo $aide->titre; ?></h1><?php echo $aide->texte; ?>
		<?php 	}

	
	function setSmileys($texte) {
		
		/*
		* 	Il faudrait gerer dynamiquement les smileys car ceci n'est pas une bonne methode. Elle existe historiquement uniquement.
		*/
		$texte = str_replace('(C)', '<img src="'.SITE_URL.'/chat2/images/smileys/coeur.gif" />',$texte);
		$texte = str_replace('(B)', '<img src="'.SITE_URL.'/chat2/images/smileys/cool.gif" />',$texte);
		$texte = str_replace(' ^. ', ' <img src="'.SITE_URL.'/chat2/images/smileys/001_huh.gif" /> ',$texte);
		$texte = str_replace(' 8) ', ' <img src="'.SITE_URL.'/chat2/images/smileys/001_rolleyes.gif" /> ',$texte);
		$texte = str_replace(' :) ', ' <img src="'.SITE_URL.'/chat2/images/smileys/001_smile.gif" /> ',$texte);
		$texte = str_replace(' :p ', ' <img src="'.SITE_URL.'/chat2/images/smileys/001_tongue.gif" /> ',$texte);
		$texte = str_replace(' #) ', ' <img src="'.SITE_URL.'/chat2/images/smileys/001_tt1.gif" /> ',$texte);
		$texte = str_replace(' :q ', ' <img src="'.SITE_URL.'/chat2/images/smileys/001_tt2.gif" /> ',$texte);
		
		$texte = str_replace(' :s ', ' <img src="'.SITE_URL.'/chat2/images/smileys/001_unsure.gif" /> ',$texte);
		$texte = str_replace('(A)', '<img src="'.SITE_URL.'/chat2/images/smileys/001_wub.gif" />',$texte);
		$texte = str_replace(' v( ', ' <img src="'.SITE_URL.'/chat2/images/smileys/angry.gif" /> ',$texte);
		$texte = str_replace(' :D ', ' <img src="'.SITE_URL.'/chat2/images/smileys/biggrin.gif" /> ',$texte);
		$texte = str_replace(' %| ', ' <img src="'.SITE_URL.'/chat2/images/smileys/blink.gif" /> ',$texte);
		$texte = str_replace('(F)', '<img src="'.SITE_URL.'/chat2/images/smileys/blush.gif" />',$texte);
		$texte = str_replace('(:F)', '<img src="'.SITE_URL.'/chat2/images/smileys/blushing.gif" />',$texte);
		$texte = str_replace(' :/ ', ' <img src="'.SITE_URL.'/chat2/images/smileys/bored.gif" /> ',$texte);
		
		$texte = str_replace(' || ', ' <img src="'.SITE_URL.'/chat2/images/smileys/closedeyes.gif" /> ',$texte);
		$texte = str_replace(' :? ', ' <img src="'.SITE_URL.'/chat2/images/smileys/confused1.gif" /> ',$texte);
		$texte = str_replace(' :\'( ', ' <img src="'.SITE_URL.'/chat2/images/smileys/crying.gif" /> ',$texte);
		$texte = str_replace(' :@ ', ' <img src="'.SITE_URL.'/chat2/images/smileys/cursing.gif" /> ',$texte);
		$texte = str_replace(' |/ ', ' <img src="'.SITE_URL.'/chat2/images/smileys/glare.gif" /> ',$texte);
		$texte = str_replace(' ^D ', ' <img src="'.SITE_URL.'/chat2/images/smileys/laugh.gif" /> ',$texte);
		$texte = str_replace('(lol)', '<img src="'.SITE_URL.'/chat2/images/smileys/lol.gif" />',$texte);
		$texte = str_replace('(M)', '<img src="'.SITE_URL.'/chat2/images/smileys/mad.gif" />',$texte);
		
		$texte = str_replace(' OMG ', ' <img src="'.SITE_URL.'/chat2/images/smileys/ohmy.gif" /> ',$texte);
		$texte = str_replace(' :( ', ' <img src="'.SITE_URL.'/chat2/images/smileys/sad.gif" /> ',$texte);
		$texte = str_replace(' %( ', ' <img src="'.SITE_URL.'/chat2/images/smileys/scared.gif" /> ',$texte);
		$texte = str_replace('(S)', '<img src="'.SITE_URL.'/chat2/images/smileys/sleep.gif" />',$texte);
		$texte = str_replace(' v) ', ' <img src="'.SITE_URL.'/chat2/images/smileys/sneaky2.gif" /> ',$texte);
		$texte = str_replace('(N)', '<img src="'.SITE_URL.'/chat2/images/smileys/thumbdown.gif" />',$texte);
		$texte = str_replace('(2Y)', '<img src="'.SITE_URL.'/chat2/images/smileys/thumbup.gif" />',$texte);
		$texte = str_replace('(Y)', '<img src="'.SITE_URL.'/chat2/images/smileys/thumbup1.gif" />',$texte);
		
		$texte = str_replace(' %D ', ' <img src="'.SITE_URL.'/chat2/images/smileys/w00t.gif" /> ',$texte);
		$texte = str_replace(' ;) ', ' <img src="'.SITE_URL.'/chat2/images/smileys/wink.gif" /> ',$texte);
		$texte = str_replace(' :P ', ' <img src="'.SITE_URL.'/chat2/images/smileys/tongue_smilie.gif" /> ',$texte);
		$texte = str_replace('(a)', '<img src="'.SITE_URL.'/chat2/images/smileys/ange.gif" />',$texte);
		$texte = str_replace('(h)', '<img src="'.SITE_URL.'/chat2/images/smileys/joie.gif" />',$texte);
		$texte = str_replace('(d)', '<img src="'.SITE_URL.'/chat2/images/smileys/demon.gif" />',$texte);
		
		$texte = str_replace('(NO)', '<img src="'.SITE_URL.'/chat2/images/smileys/non.gif" />',$texte);
		$texte = str_replace(' =| ', ' <img src="'.SITE_URL.'/chat2/images/smileys/mellow.gif" /> ',$texte);
		$texte = str_replace(' ;p ', ' <img src="'.SITE_URL.'/chat2/images/smileys/tire-la-langue-cligne.gif" /> ',$texte);
		$texte = str_replace('(b)', ' <img src="'.SITE_URL.'/chat2/images/smileys/boude.gif" /> ',$texte);
		$texte = str_replace(' ^D ', ' <img src="'.SITE_URL.'/chat2/images/smileys/charmeur.gif" /> ',$texte);
		$texte = str_replace('(danse)', '<img src="'.SITE_URL.'/chat2/images/smileys/danse.gif" />',$texte);
		$texte = str_replace('(ptdr)', '<img src="'.SITE_URL.'/chat2/images/smileys/ptdr.gif" />',$texte);
		
		$texte = str_replace(' ^^ ', ' <img src="'.SITE_URL.'/chat2/images/smileys/^^.gif" /> ',$texte);
		$texte = str_replace(' :\') ', ' <img src="'.SITE_URL.'/chat2/images/smileys/emu.gif" /> ',$texte);
		$texte = str_replace(' :x ', ' <img src="'.SITE_URL.'/chat2/images/smileys/malade.gif" /> ',$texte);
		$texte = str_replace('(mouche)', '<img src="'.SITE_URL.'/chat2/images/smileys/mouche.gif" />',$texte);
		$texte = str_replace('(xd)', '<img src="'.SITE_URL.'/chat2/images/smileys/xd.gif" />',$texte);
		$texte = str_replace('(uC)', '<img src="'.SITE_URL.'/chat2/images/smileys/coeur_briser.png" />',$texte);

		return $texte;
	}
?>

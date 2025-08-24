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
			
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.$langue);
	}
	
	
        $id_corresp = intval(JL::getVar('id_corresp', 0));
	$id_suppr = intval(JL::getVar('id_suppr', 0));
	///$texte = utf8_encode(JL::getVar('texte', ''));
	$texte = JL::getVar('texte', '');
	
	switch($_GET['action']) {

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
		$query = "SELECT u.id, u.username, up.genre, up.naissance_date,"
		." up.nb_enfants, pc.nom_".$_GET['lang']." as canton, pv.nom as ville, u.online,u.on_off_status,up.photo_defaut,"
		."(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) as `last_online_time`"
		." FROM user AS u"
		." LEFT JOIN user_profil AS up ON u.id = up.user_id"
		." LEFT JOIN profil_canton AS pc ON up.canton_id = pc.id"
		." LEFT JOIN profil_ville AS pv ON up.ville_id = pv.id"
		." LEFT JOIN user_stats AS us ON u.id = us.user_id"
		." WHERE u.id = ".$user->id;
		$utilisateur = $db->loadObject($query);
		$utilisateur->photoURL = '';
		$utilisateur->photoURL = JL::userGetPhoto($utilisateur->id, 'profil', '', $utilisateur->photo_defaut);
		if(!$utilisateur->photoURL||empty($utilisateur->photoURL)) {
			$utilisateur->photoURL = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$utilisateur->genre.'-'.$_GET['lang'].'.jpg';
		}
		if (intval($utilisateur->last_online_time) > (ONLINE_TIME_LIMIT + AFK_TIME_LIMIT)) {
		if($utilisateur->on_off_status==0)
		{
			$utilisateur->online = 0;
		}
		 else {
			$utilisateur->online = 1;
		}
		}
		else{
		if($utilisateur->on_off_status==0)
		{
			$utilisateur->online = 0;
			}
		 else {
			$utilisateur->online = 1;
		}
		}
		
		$enfant = (@$utilisateur->enfant > 1) ? $langChat["enfants"] : $langChat["enfant"];
		$online = (@$utilisateur->online) ? "on" : "off";
		$online_2 = (@$utilisateur->online) ? $langChat["online"] : $langChat["offline"];
	?>
		<div class='chatProfileFromImg'>
			<img src='<? echo $utilisateur->photoURL; ?>' alt='profil' />
		</div>
		<div class='chatProfileFromTxt'>
			<p class='nickname<? echo $utilisateur->genre; ?>'><? echo $utilisateur->username; ?></p>
			<p class='age'><? echo JL::calcul_age($utilisateur->naissance_date); ?></p>
			<p class='children'><? echo $utilisateur->nb_enfants." ".$enfant; ?></p>
			<p class='ville'><? echo $utilisateur->ville ? $utilisateur->ville:"&nbsp;"; ?></p>
			<p class='canton'><? echo $utilisateur->canton; ?></p>
			<p class='online_<? echo $utilisateur->online; ?>'><? echo $online_2; ?></p>
		</div>
	<?
	}


	//Liste les conversation, active de l'utilisateur 
	function listall($id_corresp){
		
		global $db, $user, $langChat;
		// module d'authentification, qui n'affiche rien
		JL::loadMod('auth');
		
		//Récupère les id des correspondants en cours
		$query = "SELECT u.id, u.username, cc.new AS nouveau, cc.user_id_to, up.photo_defaut, up.genre, u.online,u.on_off_status,"
		."(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) as `last_online_time`"
		." FROM chat_conversation as cc"
		." INNER JOIN user as u ON u.id = cc.user_id_to"
		." INNER JOIN user_profil as up ON u.id = up.user_id"
		." WHERE user_id_from = '".$user->id."'"
		;
		$correspondants = $db->loadObjectList($query);
		
		if($correspondants){
			//Récupère les informations des différents correspondants en cours ainsi que les conversations
			foreach($correspondants as $corresp){
				$corresp->photo = '';			
			
			// récup la photo de l'utilisateur
		$corresp->photo 	= JL::userGetPhoto($corresp->id, '89', 'profil', $corresp->photo_defaut);

		// photo par défaut
		if(!$corresp->photo) {
			 $corresp->photo = SITE_URL.'/parentsolo/images/parent-solo-89-'.$corresp->genre.'-'.$_GET['lang'].'.jpg';
		}
		/*	echo $corresp->last_online_time;
			echo $corresp->online;
			*/
					//a supprimer une fois le module en ligne refait
					//updated online status if they put offline
					if($corresp->on_off_status==0)
		{
					if (intval($corresp->last_online_time) > (ONLINE_TIME_LIMIT + AFK_TIME_LIMIT)) {
				$corresp->online = 0;
			} else {
				$corresp->online = 0;
			}
				
}else{
if (intval($corresp->last_online_time) > (ONLINE_TIME_LIMIT + AFK_TIME_LIMIT)) {
				$corresp->online = 0;
			} else {
				$corresp->online = 1;
			}
}				
			
		
				
			
			$enfant =($corresp->enfant > 1) ? $langChat["enfants"] : $langChat["enfant"];
			$online = ($corresp->online) ? "on" : "off";
			$online_2 = ($corresp->online) ? $langChat["online"] : $langChat["offline"];
				
				 if($corresp->id != 0){
					$query = "SELECT u.id, u.username, cc.new AS nouveau, cc.user_id_to"
							." FROM chat_conversation as cc"
							." INNER JOIN user as u ON u.id = cc.user_id_to"
							." WHERE user_id_from = '".$corresp->id."'"
							;
		$correspondants = $db->loadObjectList($query);
					if($corresp->id != $id_corresp){
							 $message = $corresp->nouveau;
					}else{
						if($corresp->nouveau){
							 $message = "On1";
						}else{
							 $message = "On";
						}
					}
						//echo $corresp->photoURL;
					
					//Change le peusdo de couleur dans la liste des converstion, si il y a un nouveau message dans la conversation
					?><!--<span class="conv<? echo $message; ?>">
						<div class="alert-box notice"><span>notice: </span>Write your notice message here.</div>
					</span>-->
				<li class="person" >
                        <div class="conv<? echo $message; ?>"  id='<? echo $corresp->id ; ?>'>
						<div class="chatboxhead" onclick='affichCorrespondant(<? echo $corresp->id; ?>);'>
                            <span class="userimage">
                               <img class="direct-chat-img" src="<? echo $corresp->photo; ?>" alt="chat image" />
                            </span>
                            <span><span class="bname name"><? echo $corresp->username; ?></span>
							<span onclick='fermerConversation(<? echo $corresp->id; ?>);' class='close time'><i class="fa fa-times" aria-hidden="true"></i></span>
							 <span class="preview project Offline online_<? echo $corresp->online; ?>"><? echo $online_2; ?></span>
							<!---<span class="bname name1 time1 Offline online_<? echo $corresp->online; ?>"></span></span>
                            <span class="time Offline online_<? echo $corresp->online; ?>"><i class="fa fa-circle" aria-hidden="true"></i></span>-->
                            
                            
                        </div></div>
                    </li>
					
					<!--	<div id='<? echo $corresp->id ; ?>' class='conv<? echo $message; ?>' >
						<div onclick='fermerConversation(<? echo $corresp->id; ?>);' class='close'>x</div> <p onclick='affichCorrespondant(<? echo $corresp->id; ?>);'><? echo $corresp->username; ?></p>
					</div>-->
					<?
				}
			}
		}
	}
	
	function getCorrespondant($id_corresp){
		
		
		global $db, $user, $langString, $langChat;
		
		$query = "SELECT *"
		." FROM user_flbl"
		." WHERE ((user_id_to =".$user->id." AND user_id_from = ".$id_corresp.") OR (user_id_to =".$id_corresp." AND user_id_from = ".$user->id.")) AND list_type=0"
		;
		$blacklists = $db->loadObjectList($query);
		
		if(!$blacklists){
			//les infos du correspondant (pseudo, genre, âge, nb enfants, canton, ville, en ligne?)
			$query = "SELECT u.id, u.username, up.genre, up.naissance_date,"
			." up.nb_enfants, pc.nom_".$_GET['lang']." as canton, pv.nom as ville, u.online,u.on_off_status,up.photo_defaut,"
			."(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) as `last_online_time`"
			." FROM user AS u"
			." LEFT JOIN user_profil AS up ON u.id = up.user_id"
			." LEFT JOIN profil_canton AS pc ON up.canton_id = pc.id"
			." LEFT JOIN profil_ville AS pv ON up.ville_id = pv.id"
			." LEFT JOIN user_stats AS us ON u.id = us.user_id"
			." WHERE u.id = ".$id_corresp;
			$correspondant = $db->loadObject($query);
			
			$correspondant->photoURL = '';
			
			
			$correspondant->photoURL = JL::userGetPhoto($correspondant->id, 'profil', '', $correspondant->photo_defaut);

			if(!$correspondant->photoURL||empty($correspondant->photoURL)) {
				$correspondant->photoURL = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$correspondant->genre.'-'.$_GET['lang'].'.jpg';
			}
			
			if($langString){
				if($langString == "_de")
					$langue = "&lang=de";
				if($langString == "_en")
					$langue = "&lang=en";
			}else
				$langue = "&lang=fr";
			
			//a supprimer une fois le module en ligne refait
			//updated online status if they put offline
		if($correspondant->on_off_status==0)
		{
					if (intval($correspondant->last_online_time) > (ONLINE_TIME_LIMIT + AFK_TIME_LIMIT)) {
				$correspondant->online = 0;
			} else {
				$correspondant->online = 0;
			}
			}else{
			if (intval($correspondant->last_online_time) > (ONLINE_TIME_LIMIT + AFK_TIME_LIMIT)) {
				$correspondant->online = 0;
			} else {
				$correspondant->online = 1;
			}
			}	
				
			
			$enfant =($correspondant->enfant > 1) ? $langChat["enfants"] : $langChat["enfant"];
			$online = ($correspondant->online) ? "on" : "off";
			$online_2 = ($correspondant->online) ? $langChat["online"] : $langChat["offline"];
			
			
		?>
		
		 <div class="top chatboxhead">
			<div class="col-md-6 col-sm-6 col-xs-6  parentsolo_plr_0"> <div class="col-md-3  col-sm-3 col-xs-3  parentsolo_plr_0 parentsolo_mt_20">  <span style="">
                     <a class="userimage chatProfileToImg " href="<? echo SITE_URL; ?>/index.php?app=profil&action=view&id=<? echo $correspondant->id.$langue; ?>'" target="_blank">
					<img src='<? echo $correspondant->photoURL; ?>' alt='profil' /></a>
                   </div> <div class="col-md-9  col-sm-9 col-xs-9 parentsolo_plr_0" style=" line-height: 16px;   margin-top: 8px;"
> <span  class="name nickname<? echo $correspondant->genre; ?>"><? echo $correspondant->username; ?></span><br>
					<span class='online_<? echo $correspondant->online; ?>'><? echo $online_2; ?></span>
                </span></div></div>
               <div class="col-md-6  col-sm-6 col-xs-6"><div class='chatProfileToTxt  text-right'>
					<span style="line-height: 23px;" class="parentsolo_pt_15">
                    <span class="project"><? echo JL::calcul_age($correspondant->naissance_date); ?></span><br>
					<span class="project"><? echo $correspondant->nb_enfants." ".$enfant; ?></span>
                </span></div></div> 
              
            </div>
			<!--<div class='chatProfileToImg' onclick="self.opener.location.href='<? echo SITE_URL; ?>/index.php?app=profil&action=view&id=<? echo $correspondant->id.$langue; ?>'">
				<img src='<? echo $correspondant->photoURL; ?>' alt='profil' />
			</div>
			<div class='chatProfileToTxt'>
				<p class='nickname<? echo $correspondant->genre; ?>'><? echo $correspondant->username; ?></p>
				<p class='age'><? echo JL::calcul_age($correspondant->naissance_date); ?></p>
				<p class='children'><? echo $correspondant->nb_enfants." ".$enfant; ?></p>
				<p class='ville'><? echo $correspondant->ville ? utf8_encode($correspondant->ville):"&nbsp;"; ?></p>
				<p class='canton'><? echo utf8_encode($correspondant->canton); ?></p>
				<p class='online_<? echo $correspondant->online; ?>'><? echo $online_2; ?></p>
			</div>-->
		<?	
		}
	
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
		$abonne = $db->loadResult($query);
		
		$query = "SELECT confirmed"
		." FROM user"
		." WHERE id = ".$user->id
		;
		$membre = $db->loadResult($query);
		
		if(!$abonne){
		?>
		<br>
			<a href="<? echo SITE_URL; ?>/index.php?app=abonnement&action=tarifs<? echo $langue; ?>" target="_blank"> [ <? echo  $langChat["Abonnement"]; ?> ] </a>
		<?
							
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
			
			
		}elseif($membre == 2){
			?>
			<div class='message_to'>
				<span style='color:grey;'><? echo $langChat["Parentsolo"]; ?></span>				
				<div class="bubble chat_box"><? echo $langChat["ProfilNonValide"].'<br />'.$langChat["QualiteServiceOptimale"]; ?></div>
				<span class='heure'><? echo date('d/m/Y')." ".$langChat["AHeure"]." ".date('H:i:s'); ?></span>
			</div>
			<?
		
							
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
			
			
		} else {
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
							<span style='color:grey;'><? echo $langChat["Parentsolo"]; ?></span>							
							<div class="bubble chat_box"><? echo $langChat["CorrespBlacklist"]; ?></div>
							<span class='heure'><? echo date('d/m/Y')." ".$langChat["AHeure"]." ".date('H:i:s'); ?></span>
						</div>
					<?
					}
					
					//l'utilisateur est dans la blacklist du correspondant
					elseif($blacklist->user_id_to == $user->id){
					?>
						<div class='message_to'>
							<span style='color:grey;'><? echo $langChat["Parentsolo"]; ?></span>
							<div class="bubble chat_box"><? echo $langChat["UserBlacklist"]; ?></div>
							<span class='heure'><? echo date('d/m/Y')." ".$langChat["AHeure"]." ".date('H:i:s'); ?></span>
							
						</div>
					<?
					}
				}
				
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
					
					///$message->texte = utf8_encode($message->texte);
					$message->texte = $message->texte;
				?>
					<div class='message_<? echo $dest; ?>'>
						<span class='nickname<? echo $message->genre; ?>'><? echo $message->username; ?></span>
						<div class="clear"></div>
						
						<div class="bubble chat_box"><? echo nl2br(setSmileys($message->texte)); ?></div>
						<div class="clear"></div>
						<span class='heure'>(<? echo date('d/m/Y', strtotime($message->date_envoi))." ".$langChat["AHeure"]." ".date('H:i:s', strtotime($message->date_envoi)); ?>)</span>
						
					</div>
				<?	
				}
				
				$query = "SELECT if( gold_limit_date - CURRENT_DATE > 0, 1, 0 ) AS membre"
				." FROM user_stats"
				." WHERE user_id = ".$id_corresp;
				$abonne = $db->loadResult($query);
				
				
				$query = "SELECT confirmed"
				." FROM user"
				." WHERE id = ".$id_corresp;
				$membre = $db->loadResult($query);
				
				if(!$abonne) {
				?>
					<div class='message_to'>
						<span style='color:grey;'><? echo $langChat["Parentsolo"]; ?></span>
						<div class="bubble chat_box"><? echo $langChat["MembreNonAbonne"]; ?></div>
						<span class='heure'><? echo date('d/m/Y')." ".$langChat["AHeure"]." ".date('H:i:s'); ?></span>
						
					</div>
				<?
				}
				
				if($membre == 2) {
				?>
					<div class='message_to'>
						<span style='color:grey;'><? echo $langChat["Parentsolo"]; ?></span>
						<div class="bubble chat_box"><? echo $langChat["MembreNonConfirme"]; ?></div>
						<span class='heure'><? echo date('d/m/Y')." ".$langChat["AHeure"]." ".date('H:i:s'); ?></span>
						
					</div>
				<?
				}
				
				
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
	preg_match('/(foo)(bar)(baz)/', 'foobarbaz', $matches, PREG_OFFSET_CAPTURE);
print_r($matches);
		$erreur = 0;
		
		$query = "SELECT COUNT(*)"
		." FROM user_flbl"
		." WHERE ((user_id_to =".$user->id." AND user_id_from = ".$id_corresp.") OR (user_id_to =".$id_corresp." AND user_id_from = ".$user->id.")) AND list_type=0"
		;
		$blacklist = $db->loadResult($query);
		
		if($blacklist){
			$erreur = 1;
		}
		
		$query = "SELECT if( gold_limit_date - CURRENT_DATE > 0, 1, 0 ) AS membre"
		." FROM user_stats"
		." WHERE user_id = ".$user->id
		;
		$abonne = $db->loadResult($query);
		
		if(!$abonne){
			$erreur = 1;
		}
		
		$query = "SELECT confirmed"
		." FROM user"
		." WHERE id = ".$user->id
		;
		$membre = $db->loadResult($query);
		
		if($membre == 2){
			$erreur = 1;
		}
		
		while(preg_match("/^<br \/><br \/>/", $texte)){
			$texte = str_replace("<br /><br />", "<br />", $texte);
		}
		
		if($texte=="" || $texte =="<br />" || $texte ==" <br />"){
			$erreur = 1;
		}
		
		//$texte = utf8_decode($texte);
		$texte = $texte;
		
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
		$query = "UPDATE chat_message SET new_user_to = 0 WHERE user_id_to = '".$user->id."' AND user_id_from = '".$id_suppr."'";
		$db->query($query);
		
		$query = "DELETE FROM chat_conversation WHERE user_id_from = '".$user->id."' AND user_id_to = '".$id_suppr."'";
		$db->query($query);
	
	}


	function loadAide(){
		global $db, $langString;
		
		$query = "SELECT id, titre_".$_GET['lang']." as titre,  texte_".$_GET['lang']." as texte FROM contenu WHERE id=13";
		$aide = $db->loadObject($query);
		?>
	<h1><? echo $aide->titre; ?></h1>	<br />
		<? echo $aide->texte; ?>
		<?
	}

	
	function setSmileys($texte) {
		
		/*
		* 	Il faudrait gerer dynamiquement les smileys car ceci n'est pas une bonne methode. Elle existe historiquement uniquement.
		*/
			
		$texte = str_replace('(~ES_01)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-01.png" />',$texte);
		$texte = str_replace('(~ES_02)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-02.png" />',$texte);
		$texte = str_replace('(~ES_03)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-03.png" />',$texte);
		$texte = str_replace('(~ES_04)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-04.png" />',$texte);
		$texte = str_replace('(~ES_05)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-05.png" />',$texte);
		$texte = str_replace('(~ES_06)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-06.png" />',$texte);
		$texte = str_replace('(~ES_07)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-07.png" />',$texte);
		$texte = str_replace('(~ES_08)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-08.png" />',$texte);
		$texte = str_replace('(~ES_09)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-09.png" />',$texte);
		$texte = str_replace('(~ES_10)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-10.png" />',$texte);
		
		$texte = str_replace('(~ES_11)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-11.png" />',$texte);
		$texte = str_replace('(~ES_12)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-12.png" />',$texte);
		$texte = str_replace('(~ES_13)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-13.png" />',$texte);
		$texte = str_replace('(~ES_14)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-14.png" />',$texte);
		$texte = str_replace('(~ES_15)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-15.png" />',$texte);
		$texte = str_replace('(~ES_16)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-16.png" />',$texte);
		$texte = str_replace('(~ES_17)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-17.png" />',$texte);
		$texte = str_replace('(~ES_18)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-18.png" />',$texte);
		$texte = str_replace('(~ES_19)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-19.png" />',$texte);
		$texte = str_replace('(~ES_20)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-20.png" />',$texte);
		
		$texte = str_replace('(~ES_21)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-21.png" />',$texte);
		$texte = str_replace('(~ES_22)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-22.png" />',$texte);
		$texte = str_replace('(~ES_23)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-23.png" />',$texte);
		$texte = str_replace('(~ES_24)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-24.png" />',$texte);
		$texte = str_replace('(~ES_25)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-25.png" />',$texte);
		$texte = str_replace('(~ES_26)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-26.png" />',$texte);
		$texte = str_replace('(~ES_27)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-27.png" />',$texte);
		$texte = str_replace('(~ES_28)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-28.png" />',$texte);
		$texte = str_replace('(~ES_29)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-29.png" />',$texte);
		$texte = str_replace('(~ES_30)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-30.png" />',$texte);
		
		$texte = str_replace('(~ES_31)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-31.png" />',$texte);
		$texte = str_replace('(~ES_32)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-32.png" />',$texte);
		$texte = str_replace('(~ES_33)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-33.png" />',$texte);
		$texte = str_replace('(~ES_34)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-34.png" />',$texte);
		$texte = str_replace('(~ES_35)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-35.png" />',$texte);
		$texte = str_replace('(~ES_36)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-36.png" />',$texte);
		$texte = str_replace('(~ES_37)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-37.png" />',$texte);
		$texte = str_replace('(~ES_38)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-38.png" />',$texte);
		$texte = str_replace('(~ES_39)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-39.png" />',$texte);
		$texte = str_replace('(~ES_40)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-40.png" />',$texte);
		
		$texte = str_replace('(~ES_41)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-41.png" />',$texte);
		$texte = str_replace('(~ES_42)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-42.png" />',$texte);
		$texte = str_replace('(~ES_43)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-43.png" />',$texte);
		$texte = str_replace('(~ES_44)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-44.png" />',$texte);
		$texte = str_replace('(~ES_45)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-45.png" />',$texte);
		$texte = str_replace('(~ES_46)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-46.png" />',$texte);
		$texte = str_replace('(~ES_47)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-47.png" />',$texte);
		$texte = str_replace('(~ES_48)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-48.png" />',$texte);
		$texte = str_replace('(~ES_49)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-49.png" />',$texte);
		$texte = str_replace('(~ES_50)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-50.png" />',$texte);
		
		$texte = str_replace('(~ES_51)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-51.png" />',$texte);
		$texte = str_replace('(~ES_52)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-52.png" />',$texte);
		$texte = str_replace('(~ES_53)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-53.png" />',$texte);
		$texte = str_replace('(~ES_54)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-54.png" />',$texte);
		$texte = str_replace('(~ES_55)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-55.png" />',$texte);
		$texte = str_replace('(~ES_56)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-56.png" />',$texte);
		$texte = str_replace('(~ES_57)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-57.png" />',$texte);
		$texte = str_replace('(~ES_58)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-58.png" />',$texte);
		$texte = str_replace('(~ES_59)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-59.png" />',$texte);
		$texte = str_replace('(~ES_60)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji_Smiley-60.png" />',$texte);
		
		$texte = str_replace('(~ES_61)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-61.png" />',$texte);
		$texte = str_replace('(~ES_62)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-62.png" />',$texte);
		$texte = str_replace('(~ES_63)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-63.png" />',$texte);
		$texte = str_replace('(~ES_64)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-64.png" />',$texte);
		$texte = str_replace('(~ES_65)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-65.png" />',$texte);
		$texte = str_replace('(~ES_66)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-66.png" />',$texte);
		$texte = str_replace('(~ES_67)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-67.png" />',$texte);
		$texte = str_replace('(~ES_68)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-68.png" />',$texte);
		$texte = str_replace('(~ES_69)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-69.png" />',$texte);
		$texte = str_replace('(~ES_70)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-70.png" />',$texte);
		
		$texte = str_replace('(~ES_71)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-71.png" />',$texte);
		$texte = str_replace('(~ES_72)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-72.png" />',$texte);
		$texte = str_replace('(~ES_73)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-73.png" />',$texte);
		$texte = str_replace('(~ES_74)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-74.png" />',$texte);
		$texte = str_replace('(~ES_75)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-75.png" />',$texte);
		$texte = str_replace('(~ES_76)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-76.png" />',$texte);
		$texte = str_replace('(~ES_77)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-77.png" />',$texte);
		$texte = str_replace('(~ES_78)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-78.png" />',$texte);
		$texte = str_replace('(~ES_79)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-79.png" />',$texte);
		$texte = str_replace('(~ES_80)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-80.png" />',$texte);
		
		$texte = str_replace('(~ES_81)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-81.png" />',$texte);
		$texte = str_replace('(~ES_82)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-82.png" />',$texte);
		$texte = str_replace('(~ES_83)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-83.png" />',$texte);
		$texte = str_replace('(~ES_84)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-84.png" />',$texte);
		$texte = str_replace('(~ES_85)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-85.png" />',$texte);
		$texte = str_replace('(~ES_86)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-86.png" />',$texte);
		$texte = str_replace('(~ES_87)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-87.png" />',$texte);
		$texte = str_replace('(~ES_88)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-88.png" />',$texte);
		$texte = str_replace('(~ES_89)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-89.png" />',$texte);
		$texte = str_replace('(~ES_90)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-90.png" />',$texte);
		
		$texte = str_replace('(~ES_91)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-91.png" />',$texte);
		$texte = str_replace('(~ES_92)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-92.png" />',$texte);
		$texte = str_replace('(~ES_93)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-93.png" />',$texte);
		$texte = str_replace('(~ES_94)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-94.png" />',$texte);
		$texte = str_replace('(~ES_95)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-95.png" />',$texte);
		$texte = str_replace('(~ES_96)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-96.png" />',$texte);
		$texte = str_replace('(~ES_97)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-97.png" />',$texte);
		$texte = str_replace('(~ES_98)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-98.png" />',$texte);
		$texte = str_replace('(~ES_99)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-99.png" />',$texte);
		$texte = str_replace('(~ES_100)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-100.png" />',$texte);
		
		$texte = str_replace('(~ES_101)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-101.png" />',$texte);
		$texte = str_replace('(~ES_102)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-102.png" />',$texte);
		$texte = str_replace('(~ES_103)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-103.png" />',$texte);
		$texte = str_replace('(~ES_104)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-104.png" />',$texte);
		$texte = str_replace('(~ES_105)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-105.png" />',$texte);
		$texte = str_replace('(~ES_106)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-106.png" />',$texte);
		$texte = str_replace('(~ES_107)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-107.png" />',$texte);
		$texte = str_replace('(~ES_108)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-108.png" />',$texte);
		$texte = str_replace('(~ES_109)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-109.png" />',$texte);
		$texte = str_replace('(~ES_110)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-110.png" />',$texte);
		
		$texte = str_replace('(~ES_111)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-111.png" />',$texte);
		$texte = str_replace('(~ES_112)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-112.png" />',$texte);
		$texte = str_replace('(~ES_113)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-113.png" />',$texte);
		$texte = str_replace('(~ES_114)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-114.png" />',$texte);
		$texte = str_replace('(~ES_115)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-115.png" />',$texte);
		$texte = str_replace('(~ES_116)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-116.png" />',$texte);
		$texte = str_replace('(~ES_117)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-117.png" />',$texte);
		$texte = str_replace('(~ES_118)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-118.png" />',$texte);
		$texte = str_replace('(~ES_119)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-119.png" />',$texte);
		$texte = str_replace('(~ES_120)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-120.png" />',$texte);
		
		$texte = str_replace('(~ES_121)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-121.png" />',$texte);
		$texte = str_replace('(~ES_122)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-122.png" />',$texte);
		$texte = str_replace('(~ES_123)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-123.png" />',$texte);
		$texte = str_replace('(~ES_124)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-124.png" />',$texte);
		$texte = str_replace('(~ES_125)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-125.png" />',$texte);
		$texte = str_replace('(~ES_126)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-126.png" />',$texte);
		$texte = str_replace('(~ES_127)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-127.png" />',$texte);
		$texte = str_replace('(~ES_128)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-128.png" />',$texte);
		$texte = str_replace('(~ES_129)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-129.png" />',$texte);
		$texte = str_replace('(~ES_130)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-130.png" />',$texte);
		
		$texte = str_replace('(~ES_131)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-131.png" />',$texte);
		$texte = str_replace('(~ES_132)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-132.png" />',$texte);
		$texte = str_replace('(~ES_133)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-133.png" />',$texte);
		$texte = str_replace('(~ES_134)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-134.png" />',$texte);
		$texte = str_replace('(~ES_135)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-135.png" />',$texte);
		$texte = str_replace('(~ES_136)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-136.png" />',$texte);
		$texte = str_replace('(~ES_137)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-137.png" />',$texte);
		$texte = str_replace('(~ES_138)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-138.png" />',$texte);
		$texte = str_replace('(~ES_139)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-139.png" />',$texte);
		$texte = str_replace('(~ES_140)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-140.png" />',$texte);
		
		$texte = str_replace('(~ES_141)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-141.png" />',$texte);
		$texte = str_replace('(~ES_142)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-142.png" />',$texte);
		$texte = str_replace('(~ES_143)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-143.png" />',$texte);
		$texte = str_replace('(~ES_144)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-144.png" />',$texte);
		$texte = str_replace('(~ES_145)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-145.png" />',$texte);
		$texte = str_replace('(~ES_146)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-146.png" />',$texte);
		$texte = str_replace('(~ES_147)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-147.png" />',$texte);
		$texte = str_replace('(~ES_148)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-148.png" />',$texte);
		$texte = str_replace('(~ES_149)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-149.png" />',$texte);
		$texte = str_replace('(~ES_150)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-150.png" />',$texte);
		
		$texte = str_replace('(~ES_151)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-151.png" />',$texte);
		$texte = str_replace('(~ES_152)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-152.png" />',$texte);
		$texte = str_replace('(~ES_153)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-153.png" />',$texte);
		$texte = str_replace('(~ES_154)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-154.png" />',$texte);
		$texte = str_replace('(~ES_155)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-155.png" />',$texte);
		$texte = str_replace('(~ES_156)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-156.png" />',$texte);
		$texte = str_replace('(~ES_157)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-157.png" />',$texte);
		$texte = str_replace('(~ES_158)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-158.png" />',$texte);
		$texte = str_replace('(~ES_159)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-159.png" />',$texte);
		$texte = str_replace('(~ES_160)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-160.png" />',$texte);
		
		$texte = str_replace('(~ES_161)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-161.png" />',$texte);
		$texte = str_replace('(~ES_162)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-162.png" />',$texte);
		$texte = str_replace('(~ES_163)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-163.png" />',$texte);
		$texte = str_replace('(~ES_164)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-164.png" />',$texte);
		$texte = str_replace('(~ES_165)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-165.png" />',$texte);
		$texte = str_replace('(~ES_166)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-166.png" />',$texte);
		$texte = str_replace('(~ES_167)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-167.png" />',$texte);
		$texte = str_replace('(~ES_168)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-168.png" />',$texte);
		$texte = str_replace('(~ES_169)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-169.png" />',$texte);
		$texte = str_replace('(~ES_170)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-170.png" />',$texte);
		
		$texte = str_replace('(~ES_171)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-171.png" />',$texte);
		$texte = str_replace('(~ES_172)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-172.png" />',$texte);
		$texte = str_replace('(~ES_173)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-173.png" />',$texte);
		$texte = str_replace('(~ES_174)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-174.png" />',$texte);
		$texte = str_replace('(~ES_175)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-175.png" />',$texte);
		$texte = str_replace('(~ES_176)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-176.png" />',$texte);
		$texte = str_replace('(~ES_177)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-177.png" />',$texte);
		$texte = str_replace('(~ES_178)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-178.png" />',$texte);
		$texte = str_replace('(~ES_179)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-179.png" />',$texte);
		$texte = str_replace('(~ES_180)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-180.png" />',$texte);
		
		$texte = str_replace('(~ES_181)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-181.png" />',$texte);
		$texte = str_replace('(~ES_182)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-182.png" />',$texte);
		$texte = str_replace('(~ES_183)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-183.png" />',$texte);
		$texte = str_replace('(~ES_184)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-184.png" />',$texte);
		$texte = str_replace('(~ES_185)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-185.png" />',$texte);
		$texte = str_replace('(~ES_186)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-186.png" />',$texte);
		$texte = str_replace('(~ES_187)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-187.png" />',$texte);
		$texte = str_replace('(~ES_188)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-188.png" />',$texte);
		$texte = str_replace('(~ES_189)', '<img src="'.SITE_URL.'/chat2/images/Emoji_Smiley/Emoji-Smiley-189.png" />',$texte);
		
		/*
		$texte = str_replace('(C)', '<img src="'.SITE_URL.'/chat2/images/smileys/coeur.gif" />',$texte);
		$texte = str_replace('(B)', '<img src="'.SITE_URL.'/chat2/images/smileys/cool.gif" />',$texte);
		$texte = str_replace('(^.)', '<img src="'.SITE_URL.'/chat2/images/smileys/001_huh.gif" />',$texte);
		$texte = str_replace('(8)', '<img src="'.SITE_URL.'/chat2/images/smileys/001_rolleyes.gif" />',$texte);
		$texte = str_replace('(:))', '<img src="'.SITE_URL.'/chat2/images/smileys/001_smile.gif" />',$texte);
		$texte = str_replace('(:p)', '<img src="'.SITE_URL.'/chat2/images/smileys/001_tongue.gif" />',$texte);
		$texte = str_replace('(\\))', '<img src="'.SITE_URL.'/chat2/images/smileys/001_tt1.gif" />',$texte);
		$texte = str_replace('(:q)', '<img src="'.SITE_URL.'/chat2/images/smileys/001_tt2.gif" />',$texte);
		
		$texte = str_replace('(:s)', '<img src="'.SITE_URL.'/chat2/images/smileys/001_unsure.gif" />',$texte);
		$texte = str_replace('(A)', '<img src="'.SITE_URL.'/chat2/images/smileys/001_wub.gif" />',$texte);
		$texte = str_replace('(v()', '<img src="'.SITE_URL.'/chat2/images/smileys/angry.gif" />',$texte);
		$texte = str_replace('(:D)', '<img src="'.SITE_URL.'/chat2/images/smileys/biggrin.gif" />',$texte);
		$texte = str_replace('(%|)', '<img src="'.SITE_URL.'/chat2/images/smileys/blink.gif" />',$texte);
		$texte = str_replace('(F)', '<img src="'.SITE_URL.'/chat2/images/smileys/blush.gif" />',$texte);
		$texte = str_replace('(:F)', '<img src="'.SITE_URL.'/chat2/images/smileys/blushing.gif" />',$texte);
		$texte = str_replace('(:/)', '<img src="'.SITE_URL.'/chat2/images/smileys/bored.gif" />',$texte);
		
		$texte = str_replace('(||)', '<img src="'.SITE_URL.'/chat2/images/smileys/closedeyes.gif" />',$texte);
		$texte = str_replace('(:?)', '<img src="'.SITE_URL.'/chat2/images/smileys/confused1.gif" />',$texte);
		$texte = str_replace('(:\'()', '<img src="'.SITE_URL.'/chat2/images/smileys/crying.gif" />',$texte);
		$texte = str_replace('(:@)', '<img src="'.SITE_URL.'/chat2/images/smileys/cursing.gif" />',$texte);
		$texte = str_replace('(|/)', '<img src="'.SITE_URL.'/chat2/images/smileys/glare.gif" />',$texte);
		$texte = str_replace('(^D)', '<img src="'.SITE_URL.'/chat2/images/smileys/laugh.gif" />',$texte);
		$texte = str_replace('(lol)', '<img src="'.SITE_URL.'/chat2/images/smileys/lol.gif" />',$texte);
		$texte = str_replace('(M)', '<img src="'.SITE_URL.'/chat2/images/smileys/mad.gif" />',$texte);
		
		$texte = str_replace('(OMG)', '<img src="'.SITE_URL.'/chat2/images/smileys/ohmy.gif" />',$texte);
		$texte = str_replace('(:()', '<img src="'.SITE_URL.'/chat2/images/smileys/sad.gif" />',$texte);
		$texte = str_replace('(%()', '<img src="'.SITE_URL.'/chat2/images/smileys/scared.gif" />',$texte);
		$texte = str_replace('(S)', '<img src="'.SITE_URL.'/chat2/images/smileys/sleep.gif" />',$texte);
		$texte = str_replace('(v))', '<img src="'.SITE_URL.'/chat2/images/smileys/sneaky2.gif" />',$texte);
		$texte = str_replace('(N)', '<img src="'.SITE_URL.'/chat2/images/smileys/thumbdown.gif" />',$texte);
		$texte = str_replace('(2Y)', '<img src="'.SITE_URL.'/chat2/images/smileys/thumbup.gif" />',$texte);
		$texte = str_replace('(Y)', '<img src="'.SITE_URL.'/chat2/images/smileys/thumbup1.gif" />',$texte);
		
		$texte = str_replace('(%D)', '<img src="'.SITE_URL.'/chat2/images/smileys/w00t.gif" />',$texte);
		$texte = str_replace('(;))', '<img src="'.SITE_URL.'/chat2/images/smileys/wink.gif" />',$texte);
		$texte = str_replace('(:P)', '<img src="'.SITE_URL.'/chat2/images/smileys/tongue_smilie.gif" />',$texte);
		$texte = str_replace('(a)', '<img src="'.SITE_URL.'/chat2/images/smileys/ange.gif" />',$texte);
		$texte = str_replace('(h)', '<img src="'.SITE_URL.'/chat2/images/smileys/joie.gif" />',$texte);
		$texte = str_replace('(d)', '<img src="'.SITE_URL.'/chat2/images/smileys/demon.gif" />',$texte);
		
		$texte = str_replace('(NO)', '<img src="'.SITE_URL.'/chat2/images/smileys/non.gif" />',$texte);
		$texte = str_replace('(=|)', '<img src="'.SITE_URL.'/chat2/images/smileys/mellow.gif" />',$texte);
		$texte = str_replace('(;p)', '<img src="'.SITE_URL.'/chat2/images/smileys/tire-la-langue-cligne.gif" />',$texte);
		$texte = str_replace('(b)', ' <img src="'.SITE_URL.'/chat2/images/smileys/boude.gif" /> ',$texte);
		$texte = str_replace('(^^D)', '<img src="'.SITE_URL.'/chat2/images/smileys/charmeur.gif" />',$texte);
		$texte = str_replace('(danse)', '<img src="'.SITE_URL.'/chat2/images/smileys/danse.gif" />',$texte);
		$texte = str_replace('(ptdr)', '<img src="'.SITE_URL.'/chat2/images/smileys/ptdr.gif" />',$texte);
		
		$texte = str_replace('(^^)', '<img src="'.SITE_URL.'/chat2/images/smileys/^^.gif" />',$texte);
		$texte = str_replace('(:\'))', '<img src="'.SITE_URL.'/chat2/images/smileys/emu.gif" />',$texte);
		$texte = str_replace('(:x)', '<img src="'.SITE_URL.'/chat2/images/smileys/malade.gif" />',$texte);
		$texte = str_replace('(mouche)', '<img src="'.SITE_URL.'/chat2/images/smileys/mouche.gif" />',$texte);
		$texte = str_replace('(xd)', '<img src="'.SITE_URL.'/chat2/images/smileys/xd.gif" />',$texte);
		$texte = str_replace('(uC)', '<img src="'.SITE_URL.'/chat2/images/smileys/coeur_briser.png" />',$texte);*/

		return $texte;
	}
?>

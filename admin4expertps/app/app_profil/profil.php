<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	require_once('profil.html.php');
	
	global $action;
	
	
	// variables
	$messages = [];

	
	
	switch($action) {
		
		case 'photo_validation_submit':
		photoSubmit();
		
		case 'photo_validation':
		photoLister();
		break;
		
		
		case 'texte_validation_submit':
		texteSubmit();
		
		case 'texte_validation':
		texteLister();
		break;
		
		case 'supprimer':
		profilSuppression();
		profilLister();
		break;
		
		case 'desactiver':
		profilActivation(0);
		profilLister();
		break;
		
		case 'activer':
		profilActivation(1);
		profilLister();
		break;
		
		
		case 'editer':
		profilEditer();
		break;
		
		case 'save':
		$messages = profilSave();
		profilEditer();
		break;
				
		
		default:
		profilLister();
		break;
		
	}
	
	
	// �diter profil
	function profilEditer() {
		global $db, $messages;
		
		// r�cup les donn�es par d�faut
		$data 		= getData();
	
		// nouvel utilisateur
		if(!$data->id) {
		
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=profil');
		
		} else {
			
			// r�cup les infos du profil
			$query = "SELECT u.id, u.username, u.email, up.langue_appel, up.helvetica, up.genre, up.nom, up.prenom, up.telephone, up.adresse, up.code_postal, up.nom_origine, up.prenom_origine, up.telephone_origine, up.adresse_origine, up.code_postal_origine, us.gold_limit_date, 0 AS abonnement_crediter, us.appel_date, us.appel_date2, us.commentaire, u.confirmed, u.creation_date, ua.annonce_valide, us.points_total"
			." FROM user AS u"
			." INNER JOIN user_profil AS up ON up.user_id = u.id"
			." INNER JOIN user_stats AS us ON us.user_id = u.id"
			." INNER JOIN user_annonce AS ua ON ua.user_id = u.id"
			." WHERE u.id = '".$data->id."'"
			." LIMIT 0,1"
			;
			$userObj = $db->loadObject($query);
			
			
			// variables non issues de la DB
			$userObj->points_id			= 0;
			$userObj->points_retirer	= 0;
			
			
			// variables par d�faut
			foreach($data as $k => $v) {
				$userObj->{$k} = $v ?: $userObj->{$k};
			}
			
			
			// r�cup le dernier abonnement pay� par carte
			$query = "SELECT nom_paypal, prenom_paypal, IF(date_dernier_renouvellement = '0000-00-00 00:00:00', date_souscription, date_dernier_renouvellement) as datetime, valide"
			." FROM abonnement_paypal"
			." WHERE user_id = '".$userObj->id."' AND valide > 0"
			." ORDER BY datetime DESC"
			." LIMIT 0,1"
			;
			$abonnement_carte = $db->loadObject($query);
			$userObj->abonnement_carte = $abonnement_carte->datetime ?: false;
			
			if($userObj>\ABONNEMENT_CARTE){
				$userObj->abonnement_carte_nom = $abonnement_carte->nom_paypal;
				$userObj->abonnement_carte_prenom = $abonnement_carte->prenom_paypal;
				$userObj->abonnement_carte_valide = $abonnement_carte->valide;
			}
			
			
			// r�cup les 4 actions d'abonnement, id en dur !
			$query = "SELECT id, nom_fr as nom, points"
			." FROM points"
			." WHERE id IN (1,2,3,19)"
			." ORDER BY nom ASC"
			." LIMIT 0,4"
			;
			$points = $db->loadObjectList($query);
			
			
			// affichage du formulaire d'�dition
			profil_HTML::profilEditer($userObj, $messages, $points);
		
		}
	
	}
	
	
	// liste les profils
	function profilLister() {
		global $db, $messages;
		
		// variables
		$resultatParPage		= RESULTS_NB_LISTE_ADMIN;
		$search					= [];
		$where					= [];
		$_where					= '';
		
		// params
		
		// si on passe une recherche en param, alors on force la page 1 (pour �viter de charger la page 36, s'il n'y a que 2 pages � voir)
		$search['page']			= JL::getVar('search_page', JL::getSessionInt('search_page', 1));
		
		// mot cherch�
		$search['word']			= trim(JL::getVar('search_word', JL::getSession('search_word', ''), true));
		
		// conserve en session ces param�tres
		JL::setSession('search_page', 		$search['page']);
		JL::setSession('search_word', 		$search['word']);
		
		
		// on n'affiche pas les admins
		$where[]				= "u.gid = 0";
		
		
		
		// recherche d'un pseudo
		if($search['word']) {
			$where[]			= "u.email LIKE '%".$search['word']."%'";
		}
		
		
		// g�n�re le where
		if (is_array($where)) {
			$_where				= " WHERE ".implode(' AND ', $where);
		}
		
		
		// compte le nombre de r�sultats
		echo $query = "SELECT COUNT(*)"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		// recherche des donn�es
		$query = "SELECT u.id, u.username, u.email, up.genre, IFNULL(pc.nom_fr, '') AS canton, IFNULL(pv.nom, '') AS ville, up.genre, up.nb_enfants, CURRENT_DATE, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		.$_where
		." ORDER BY ".strtolower($search['order'])." ".strtoupper($search['ascdesc'])
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$results	= $db->loadObjectList($query);
		
		
		// r�cup le nombre d'inscrits (table � part pour �viter les COUNT(*) sur la table user � chaque chargement de pag
		
		profil_HTML::profilLister($results, $search);
		
	}
	
	
	// liste les photos � valider
	function photoLister() {
		global $db, $messages;
		
		
		// r�cup 10 utilisateurs pour qui il faut valider des photos
		$query = "SELECT u.username, us.user_id"
		." FROM user_stats AS us"
		." INNER JOIN user AS u ON u.id = us.user_id"
		." WHERE us.photo_a_valider > 0"
		." ORDER BY us.user_id ASC"
		." LIMIT 0, 10";
		$users = $db->loadObjectList($query);
		
		// parcourt la lsite des utilisateurs avec photo � valider
		$usersTotal	= count($users);
		for($i=0; $i<$usersTotal; $i++) {
			$users[$i]->photos = [];
			
			// parcourt le r�pertoire de photos de l'utilisateur
			$dir = '../images/profil/'.$users[$i]->user_id;
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {
					
					// r�cup les photos � valider
					if(preg_match('#^pending.*109#', $file)) {
						$photo = preg_replace('#^.*-(.*-[0-9]+)\.jpg#', '$1', $file);
						$users[$i]->photos[] = $photo;
					}
				}
			}
			
		}
		
		profil_HTML::photoLister($users, $messages);
		
	}
	
	
	// traitement des photos
	function photoSubmit() {
		global $db, $messages;
		
		// params
		$photos = JL::getVar('photo', []);
		$task 	= JL::getVar('task', '');
		
		// variables
		$msg		= '';
		
		// si des photos ont �t� coch�es
		if (is_array($photos)) {
			
			foreach($photos as $photo) {
				
				$photoTmp	= explode('_', (string) $photo);
				$user_id	= $photoTmp[0];
				$file		= $photoTmp[1];
				
				if(is_file('../images/profil/'.$user_id.'/pending-parent-solo-'.$file.'.jpg')) {
				
					// suppression
					if($task == 'supprimer') {
					
						@unlink('../images/profil/'.$user_id.'/pending-parent-solo-'.$file.'.jpg');
						@unlink('../images/profil/'.$user_id.'/pending-parent-solo-35-'.$file.'.jpg');
						@unlink('../images/profil/'.$user_id.'/pending-parent-solo-89-'.$file.'.jpg'); // profil only
						@unlink('../images/profil/'.$user_id.'/pending-parent-solo-109-'.$file.'.jpg');
						@unlink('../images/profil/'.$user_id.'/pending-parent-solo-220-'.$file.'.jpg');
						
						// retire la photo de la liste des derni�res photos ajout�es
						$query = "DELETE FROM photo_last WHERE user_id = '".$user_id."' AND photo_name = '".$file."'";
						$db->query($query);
						
					}
					
					// validation
					if($task == 'valider') {
					
						@rename('../images/profil/'.$user_id.'/pending-parent-solo-'.$file.'.jpg', '../images/profil/'.$user_id.'/parent-solo-'.$file.'.jpg');
						@rename('../images/profil/'.$user_id.'/pending-parent-solo-35-'.$file.'.jpg', '../images/profil/'.$user_id.'/parent-solo-35-'.$file.'.jpg');
						@rename('../images/profil/'.$user_id.'/pending-parent-solo-89-'.$file.'.jpg', '../images/profil/'.$user_id.'/parent-solo-89-'.$file.'.jpg');  // profil only
						@rename('../images/profil/'.$user_id.'/pending-parent-solo-109-'.$file.'.jpg', '../images/profil/'.$user_id.'/parent-solo-109-'.$file.'.jpg');
						@rename('../images/profil/'.$user_id.'/pending-parent-solo-220-'.$file.'.jpg', '../images/profil/'.$user_id.'/parent-solo-220-'.$file.'.jpg');
						
						// sauvegarde dans la table des derni�res photos valid�es
						$query = "INSERT INTO photo_last SET user_id = '".$user_id."', photo_name = '".$file."'";
						$db->query($query);
						
						// cr�dite l'action 6 photos valid�es
						JL::addPoints(6, $user_id);
						
					}
					
					// mise � jour de la table user_stats
					$query = "UPDATE user_stats SET photo_a_valider = photo_a_valider - 1 WHERE photo_a_valider > 0 AND user_id = '".$user_id."'";
					$db->query($query);
				
				}
				
			}
			
			if($task == 'supprimer') {
				$msg	= '<span class="valid">Photos supprim&eacute;es.</span>';
			}
			if($task == 'valider') {
				$msg	= '<span class="valid">Photos valid&eacute;es.</span>';
			}
			
		} else {
			if($task == 'supprimer') {
				$msg	= '<span class="error">Aucune photo n\'a &eacute;t&eacute; supprim&eacute;e.</span>';
			}
			if($task == 'valider') {
				$msg	= '<span class="error">Aucune photo n\'a &eacute;t&eacute; valid&eacute;e.</span>';
			}
		}
		
		$messages[] = $msg;
		
	}
	
	// liste les photos � valider
	function texteLister() {
		global $db, $messages;
		
		// r�cup 10 utilisateurs pour qui il faut valider des textes
		$query = "SELECT u.username, ua.user_id, ua.annonce"
		." FROM user_annonce AS ua"
		." INNER JOIN user AS u ON u.id = ua.user_id"
		." WHERE ua.annonce NOT LIKE '' AND ua.published = 2"
		." ORDER BY ua.user_id ASC"
		." LIMIT 0, 10";
		$textes = $db->loadObjectList($query);
		
		profil_HTML::texteLister($textes, $messages);
		
	}
	
	
	// traitement des photos
	function texteSubmit() {
		global $db, $messages;
		
		// params
		$textes = JL::getVar('texte', []);
		$task 	= JL::getVar('task', '');
		
		// variables
		$msg		= '';
		
		// si des photos ont �t� coch�es
		if (is_array($textes)) {
			
			foreach($textes as $texte) {
				
				// suppression
				if($task == 'refuser') {
					// mise � jour de la table user_annonce
					$query = "UPDATE user_annonce SET published = '0' WHERE user_id = '".$texte."'";
					$db->query($query);
				}
				
				// validation
				if($task == 'valider') {
				
					// r�cup le texte de l'annonce
					$annonce	= JL::getVar('annonce'.$texte, '', true);
					
					// mise � jour de la table user_annonce
					$query = "UPDATE user_annonce SET annonce = '".$annonce."', annonce_valide = '".$annonce."', published = '1' WHERE user_id = '".$texte."'";
					$db->query($query);
					
				}
				
			}
			
			if($task == 'refuser') {
				$msg	= '<span class="valid">Textes refus&eacute;s.</span>';
			}
			if($task == 'valider') {
				$msg	= '<span class="valid">Textes valid&eacute;s.</span>';
			}
			
		} else {
			if($task == 'refuser') {
				$msg	= '<span class="error">Aucun texte n\'a &eacute;t&eacute; refus&eacute;.</span>';
			}
			if($task == 'valider') {
				$msg	= '<span class="error">Aucun texte n\'a &eacute;t&eacute; valid&eacute;.</span>';
			}
		}
		
		$messages[] = $msg;
		
	}
	
	// donn�es de l'utilisateur
	function &getData() {
		global $userObj;
		
		$data = new StdClass();
		
		// params
		$data->id 						= JL::getVar('id', 0);
		$data->nom_origine 				= JL::getVar('nom', '');
		$data->prenom_origine			= JL::getVar('prenom', '');
		$data->telephone_origine		= JL::getVar('telephone', '');
		$data->adresse_origine			= JL::getVar('adresse', '');
		$data->code_postal_origine		= JL::getVar('code_postal', '');
		$data->langue_appel				= JL::getVar('langue_appel', '');
		$data->helvetica 				= (int)JL::getVar('helvetica', '');
		
		$data->gold_limit_date 			= JL::getVar('gold_limit_date', '');
		$data->appel_date 				= JL::getVar('appel_date', '');
		$data->appel_date2 				= JL::getVar('appel_date2', '');
		$data->commentaire 				= JL::getVar('commentaire', '');
		$data->abonnement_crediter 		= (int)JL::getVar('abonnement_crediter', 0);
		
		$data->confirmed				= (int)JL::getVar('confirmed', 0);
		$data->points_id				= (int)JL::getVar('points_id', 0);
		$data->points_retirer			= abs((int)JL::getVar('points_retirer', 0));
		
		$data->annonce_valide 			= JL::getVar('annonce_valide', '');
		
		return $data;
		
	}
	
	
	// mise � jour des messages
	function profilUpdateMessages($ids) {
		global $db;
		
		$in_id	= implode(',', $ids);
		
		// parcourt tous les utilisateurs � d�sactiver
		foreach($ids as $id) {
		
			// r�cup tous les profils � qui l'utilisateur a envoy� des messages, et ceux-ci �tant non lu
			$query = "SELECT m.user_id_to AS user_id, IF(m.fleur_id>0,1,0) AS fleur, COUNT(*) AS total"
			." FROM message AS m"
			." WHERE m.user_id_from = '".(int)$id."' AND m.non_lu = 1"
			." GROUP BY m.user_id_to, IF(m.fleur_id>0,1,0)"
			;
			$nonLus = $db->loadObjectList($query);
			
			// s'il y a des messages non lus
			if(is_array($nonLus)) {
				foreach($nonLus as $nonLu) {
				
					if($nonLu->fleur > 0) {
						$field = 'fleur';
					} else {
						$field = 'message';
					}
					
					// d�cr�mente le total de nouveaux messages/fleurs
					$query = "UPDATE user_stats SET ".$field."_new = ".$field."_new - ".$nonLu->total." WHERE user_id = '".$nonLu->user_id."'";
					$db->query($query);
				
				}
			}
			
		}
		
	}
	
?>

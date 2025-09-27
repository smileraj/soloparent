<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('user.html.php');
	
	global $action;
	

	
	// variables
	$messages = array();

	
	
	switch($action) {
			
		case 'supprimer':
		$messages = userSupprimer();
		userLister();
		break;
		
		
		case 'save':
		$messages = userSave();
		userEditer();
		break;
		
		
		case 'nouveau':
		case 'editer':
		userEditer();
		break;
		
		
		case 'activer':
		userActivation(1);
		userLister();
		break;
		
		case 'desactiver':
		userActivation(0);
		userLister();
		break;
		
		
		default:
		userLister();
		break;
		
	}
	
	
	// sauvegarder utilisateur
	function userSave() {
		global $db, $messages;
		
		
		// récup les données
		$data 		= getData(true);
		
		// passe les variables en session
		foreach($data as $k => $v) {
			JL::setSession('userForm_'.$k, $v);
		}
		
		
		// vérifs
		if(!$data->username) {
			$messages[]	= '<span class="error">Veuillez indiquer un pseudo svp.</span>';
		}
		if(!$data->email) {
			$messages[]	= '<span class="error">Veuillez indiquer une adresse email svp.</span>';
		}
		
		// nouvel utilisateur
		if(!$data->id) {
			
			// vérifie si le pseudo est dispo
			$query = "SELECT id FROM user WHERE username LIKE '".$data->username."' LIMIT 0,1";
			$userObjnameExistant = $db->loadResult($query);
			
			// pseudo déjà pris
			if($userObjnameExistant) {
				$messages[]	= '<span class="error">Veuillez indiquer un autre pseudo svp, celui-ci est déjà pris.</span>';
			}
			
			// vérifie si l'adresse email est dispo
			$query = "SELECT id FROM user WHERE email LIKE '".$data->email."' LIMIT 0,1";
			$emailExistant = $db->loadResult($query);
			
			// email déjà pris
			if($emailExistant) {
				$messages[]	= '<span class="error">Veuillez indiquer une autre adresse email svp, celle-ci est déjà prise.</span>';
			}
		
		}
		
		if(strlen($data->username) < 4 || strlen($data->username) > 50) {
			$messages[]	= '<span class="error">Votre pseudo n\'est pas valide. Celui-ci doit comporter entre 4 et 50 caractères inclus.</span>';
		}
		
		if(!preg_match('/^[a-zA-Z0-9._-]+$/', $data->username)) {
			$messages[]	= '<span class="error">Votre pseudo n\'est pas valide. Celui-ci ne doit contenir que des caractères non accentués et des chiffres.</span>';
		}
		
		// user log et change de mdp, ou user non log
		if($data->password && !preg_match('/^[a-zA-Z0-9._-]+$/', $data->password)) {
			$messages[]	= '<span class="error">Votre mot de passe n\'est pas valide. Celui-ci ne doit contenir que des caractères non accentués et des chiffres.</span>';
		}
		
		// user log et change de mdp, ou user non log
		if($data->password2 && !preg_match('/^[a-zA-Z0-9._-]+$/', $data->password2)) {
			$messages[]	= '<span class="error">La confirmation du mot de passe n\'est pas valide. Celle-ci ne doit contenir que des caractères non accentués et des chiffres.</span>';
		}
		
		if(($data->password || $data->password2) && $data->password != $data->password2) {
			$messages[]	= '<span class="error">La confirmation du mot de passe ne correspond pas avec le premier mot de passe entré.</span>';
		}
		
		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $data->email)) {
			$messages[]	= '<span class="error">Votre adresse e-mail n\'est pas valide.</span>';
		}
		
		
		// s'il n'y a pas d'erreur
		if(!count($messages)) {
		
			// on sauvegarde
			if($data->id) {
			if($data->password ==''){
				$query 	= "UPDATE user SET"
				." username = '".$data->username."',"
				." email = '".$data->email."',"
				." published = '".$data->published."',"
				." user_status_code = '".$data->published."'"
				." WHERE id = '".$data->id."'"
				;
				}
				else{
				$query 	= "UPDATE user SET"
				." username = '".$data->username."',"
				." email = '".$data->email."',"
				." password = MD5('".$data->password."'),"
				." published = '".$data->published."',"
				." user_status_code = '".$data->published."'"
				." WHERE id = '".$data->id."'"
				;
				}
				$db->query($query);
				
				$messages[]	= '<span class="valid">Modifications enregistrées.</span>';
				
			} else {
			
				$query 	= "INSERT INTO user SET"
				." username = '".$data->username."',"
				." email = '".$data->email."',"
				." password = MD5('".$data->password."'),"
				." published = '".$data->published."',"
				." user_status_code = '".$data->published."',"
				." gid = 1,"
				." confirmed = 0,"
				." creation_date = NOW()"
				;
				$db->query($query);
				JL::setVar('id', $db->insert_id());
				
				$messages[]	= '<span class="valid">Utilisateur ajouté.</span>';
				
			}
				
			// passe les variables en session
			foreach($data as $k => $v) {
				JL::setSession('userForm_'.$k, '');
			}
			
		}
	
		return $messages;
		
	}
	
	
	// éditer utilisateur
	function userEditer() {
		global $db, $messages;
		
		// params
		$id	= JL::getVar('id', 0, true);
		
		
		// nouvel utilisateur
		if(!$id) {
		
			$userObj = new stdClass();
			$userObj->id				= 0;
			$userObj->username			= JL::getSession('userForm_username', '');
			$userObj->email				= JL::getSession('userForm_email', '');
			$userObj->published			= JL::getSession('userForm_published', 0);
			$userObj->confirmed			= 0;
			$userObj->creation_date		= date('Y-m-d H:i:s');
			$userObj->last_online		= '0000-00-00'; 
		
		} else {
			
			// récup les infos du profil
			$query = "SELECT id, username, email, published, confirmed, creation_date, last_online, gid"
			." FROM user"
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			$userObj = $db->loadObject($query);
			
		}
		
		user_HTML::userEditer($userObj, $messages);
		
	}
	
	
	// active/désactive des profils passés en param
	function userActivation($published) {
		global $db, $messages;
		
		$ids = JL::getVar('id', array());
		
		// s'il y a des id passés
		if (is_array($ids)) {
			$in_id	= implode(',', $ids);
			
			// mise à jour du champ id
		//	$query = "UPDATE user SET published = '".$published."' WHERE id IN (".$in_id.")";
		$query = "UPDATE user SET published = '".$published."', user_status_code='".$published."' WHERE id IN (".$in_id.")";
			$db->query($query);
			
			// message de confirmation
			if($published) {
				$messages[]	= '<span class="valid">Utilisateur(s) activé(s).</span>';
			} else {
				$messages[]	= '<span class="valid">Utilisateur(s) désactivé(s).</span>';
			}
			
			
			// utilisateur à désactiver
			if($published == 0) {
				
				// mise à jour des stats nouveaux messages
				userUpdateMessages($ids);
				
				foreach($ids as $id){
					
					// récup les détails du paiement
					$query = "SELECT id, reference_paypal, intitule_abo, montant, nom_paypal, prenom_paypal, valide"
					." FROM abonnement_paypal"
					." WHERE user_id = '".(int)$id."' and valide=1"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// récup les détails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid"
					." FROM user AS u"
					." WHERE u.id = '".(int)$id."'"
					." LIMIT 0,1"
					;
					$userProfil = $db->loadObject($queryUser);
				
					if($abonnement_paypal && $userProfil){
						mail('abonnement@solocircl.com', 'Désactivation d\'un membre', "Désactivation d'un membre abonné\n\n Username : ".$userProfil->username."\n Id User (Marie) : ".$userProfil->id."\n\n Intitulé Abo : ".$abonnement_paypal->intitule_abo."\n Montant : ".$abonnement_paypal->montant."\n Nom Paypal : ".$abonnement_paypal->nom_paypal."\n Prénom Paypal : ".$abonnement_paypal->prenom_paypal."\n Référence Paypal : ".$abonnement_paypal->reference_paypal."\n Validité de l'Abonnement (0->non validé, 1->en cours, 2->annulé) : ".$abonnement_paypal->valide."\n Id Abonnement Paypal (Marie) : ".$abonnement_paypal->id."\n");
					}
				
				}
				
			}
			
			
		} else {
		
			$messages[]	= '<span class="error">Veuillez sélectionner un ou des utilisateur(s) valide(s).</span>';
			
		}
	
	}
	
	
	// liste les profils
	function userLister() {
		global $db, $messages;
		
		// variables
		$resultatParPage	= RESULTS_NB_LISTE_ADMIN;
		$search				= array();
		$where				= null;
		$_where				= '';
		
		// params
		$search['username']	= JL::getVar('search_username', '');
		$search['page']		= JL::getVar('search_page', 1);
		$search['gid']		= JL::getVar('search_gid', -1) > -1 ? JL::getVar('search_gid', -1) : JL::getSessionInt('search_gid', 0);
		JL::setSession('search_gid', $search['gid']);
		
		$where[]		= "u.gid = '".$search['gid']."'";
		
		// recherche d'un pseudo
		if($search['username']) {
			$where[]		= "u.username LIKE '%".$search['username']."%'";
		}
		
		// génère le where
		if (is_array($where)) {
			$_where		= " WHERE ".implode(' AND ', $where);
		}
		
		
		// compte le nombre de résultats
		$query = "SELECT COUNT(*)"
		." FROM user AS u"
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		// recherche des données
		$query = "SELECT u.id, u.username, u.confirmed, u.published, u.creation_date, u.last_online"
		." FROM user AS u"
		.$_where
		." ORDER BY u.username ASC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$results	= $db->loadObjectList($query);
	
		// affiche le liste des utilisateurs
		user_HTML::userLister($results, $search, $messages);
		
	}
	
	
	// supprime des profils passés en param
	function userSupprimer() {
		global $db, $messages;
		
		$ids 		= JL::getVar('id', array());
		$ids_profil	= array();
		
		// s'il y a des id passés
		if (is_array($ids)) {
		
			// mise à jour des stats nouveaux messages
			userUpdateMessages($ids);
			
			// pour chaque utilisateur à supprimer
			foreach($ids as $id) {
			
				// check si c'est un profil
				$query = "SELECT user_id FROM user_profil WHERE user_id = '".$id."' LIMIT 0,1";
				$userObj_id = $db->loadResult($query);
				
				// si c'est un utilisateur avec profil
				if($userObj_id) {
				
					// récup le genre
					$query = "SELECT genre FROM user_profil WHERE user_id = '".$id."' LIMIT 0,1";
					$genre = $db->loadResult($query);
				
					// met à jour les stats
					$field = ($genre == 'h') ? 'papa' : 'maman';
					$query = "UPDATE inscrits SET ".$field." = ".$field." - 1 WHERE 1";
					$db->query($query);
					
					// supprime les photos
					$dest_dossier = '../images/profil/'.$userObj_id;
					if(is_dir($dest_dossier)) {
						$dir_id 	= opendir($dest_dossier);
						while($file = trim(readdir($dir_id))) {
							if($file != '.' && $file != '..') {
								unlink($dest_dossier.'/'.$file);
							}
						}
						rmdir($dest_dossier);
					}
					
					// tableau des utilisateurs avec profil
					$ids_profil[]	= $userObj_id;
				
				}
				
			}
			
		
			// crée une chaine contenant tous les id à supprimer
			$in_id	= implode(',', $ids);
			
			// supprime de la table USER
			$query = "DELETE FROM user WHERE id IN (".$in_id.")";
			$db->query($query);
			
			
			// crée une chaine contenant tous les id de profils à supprimer
			$in_id_profil	= implode(',', $ids_profil);
			
			// supprime de la table USER_PROFIL
			$query = "DELETE FROM user_profil WHERE user_id IN (".$in_id_profil.")";
			$db->query($query);
			
			// supprime de la table USER_ANNONCE
			$query = "DELETE FROM user_annonce WHERE user_id IN (".$in_id_profil.")";
			$db->query($query);
			
			// supprime de la table USER_ENFANT
			$query = "DELETE FROM user_enfant WHERE user_id IN (".$in_id_profil.")";
			$db->query($query);
			
			// supprime de la table USER_RECHERCHE
			$query = "DELETE FROM user_recherche WHERE user_id IN (".$in_id_profil.")";
			$db->query($query);
			
			// supprime de la table USER_STATS
			$query = "DELETE FROM user_stats WHERE user_id IN (".$in_id_profil.")";
			$db->query($query);
			
			// supprime de la table PHOTO_LAST
			$query = "DELETE FROM photo_last WHERE user_id IN (".$in_id_profil.")";
			$db->query($query);
			
			foreach($ids_profil as $id_profil){
					
					// récup les détails du paiement
					$query = "SELECT id, reference_paypal, intitule_abo, montant, nom_paypal, prenom_paypal, valide"
					." FROM abonnement_paypal"
					." WHERE user_id = '".(int)$id_profil."'"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// récup les détails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid"
					." FROM user AS u"
					." WHERE u.id = '".(int)$id_profil."'"
					." LIMIT 0,1"
					;
					$userProfil = $db->loadObject($queryUser);
				
					if($abonnement_paypal && $userProfil){
						mail('abonnement@solocircl.com', 'Suppression d\'un membre', "Suppression d'un membre abonné\n\n Username : ".$userProfil->username."\n Id User (Marie) : ".$userProfil->id."\n\n Intitulé Abo : ".$abonnement_paypal->intitule_abo."\n Montant : ".$abonnement_paypal->montant."\n Nom Paypal : ".$abonnement_paypal->nom_paypal."\n Prénom Paypal : ".$abonnement_paypal->prenom_paypal."\n Référence Paypal : ".$abonnement_paypal->reference_paypal."\n Validité de l'Abonnement (0->non validé, 1->en cours, 2->annulé) : ".$abonnement_paypal->valide."\n  Id Abonnement Paypal (Marie) : ".$abonnement_paypal->id."\n");
					}
				
				}
						
			// message de confirmation
			$messages[]	= '<span class="valid">Utilisateur(s) supprimé(s).</span>';

		} else {
		
			$messages[]	= '<span class="error">Veuillez sélectionner un ou des utilisateur(s) valide(s).</span>';
			
		}
	
	}
	
	
	// données de l'utilisateur
	function &getData($addslashes = false) {
		global $userObj;
		
		$data = new StdClass();
		
		// params
		$data->id 				= JL::getVar('id', 0);
		$data->username 		= JL::getVar('user_username', '', $addslashes);
		$data->password 		= JL::getVar('user_password', '');
		$data->password2 		= JL::getVar('user_password2', '');
		$data->email 			= JL::getVar('user_email', '', $addslashes);
		$data->published 		= JL::getVar('user_published', 0);
		
		return $data;
		
	}
	
	
	function userUpdateMessages($ids) {
		global $db;
		
		$in_id	= implode(',', $ids);
			
		// parcourt tous les utilisateurs à désactiver
		foreach($ids as $id) {
		
			// récup tous les profils à qui l'utilisateur a envoyé des messages, et ceux-ci étant non lu
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
					
					// décrémente le total de nouveaux messages/fleurs
					$query = "UPDATE user_stats SET ".$field."_new = ".$field."_new - ".$nonLu->total." WHERE user_id = '".$nonLu->user_id."'";
					$db->query($query);
				
				}
			}
			
		}
		
		// mise à jour des messages non lus envoyés par cet utilisateur
		$query = "UPDATE message SET non_lu = 0 WHERE user_id_from IN (".$in_id.")";
		$db->query($query);
	
	}
	
?>

<?php

	// s�curit�
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
		
		
		// r�cup les donn�es
		$data 		= getData(true);
		
		// passe les variables en session
		foreach($data as $k => $v) {
			JL::setSession('userForm_'.$k, $v);
		}
		
		
		// v�rifs
		if(!$data->username) {
			$messages[]	= '<span class="error">Veuillez indiquer un pseudo svp.</span>';
		}
		if(!$data->email) {
			$messages[]	= '<span class="error">Veuillez indiquer une adresse email svp.</span>';
		}
		
		// nouvel utilisateur
		if(!$data->id) {
			
			// v�rifie si le pseudo est dispo
			$query = "SELECT id FROM user WHERE username LIKE '".$data->username."' LIMIT 0,1";
			$userObjnameExistant = $db->loadResult($query);
			
			// pseudo d�j� pris
			if($userObjnameExistant) {
				$messages[]	= '<span class="error">Veuillez indiquer un autre pseudo svp, celui-ci est d&eacute;j&agrave; pris.</span>';
			}
			
			// v�rifie si l'adresse email est dispo
			$query = "SELECT id FROM user WHERE email LIKE '".$data->email."' LIMIT 0,1";
			$emailExistant = $db->loadResult($query);
			
			// email d�j� pris
			if($emailExistant) {
				$messages[]	= '<span class="error">Veuillez indiquer une autre adresse email svp, celle-ci est d&eacute;j&agrave; prise.</span>';
			}
		
		}
		
		if(strlen($data->username) < 4 || strlen($data->username) > 12) {
			$messages[]	= '<span class="error">Votre pseudo n\'est pas valide. Celui-ci doit comporter entre 4 et 12 caract&egrave;res inclus.</span>';
		}
		
		if(!preg_match('/^[a-zA-Z0-9._-]+$/', $data->username)) {
			$messages[]	= '<span class="error">Votre pseudo n\'est pas valide. Celui-ci ne doit contenir que des caract&egrave;res non accentu&eacute;s et des chiffres.</span>';
		}
		
		// user log et change de mdp, ou user non log
		if($data->password && !preg_match('/^[a-zA-Z0-9._-]+$/', $data->password)) {
			$messages[]	= '<span class="error">Votre mot de passe n\'est pas valide. Celui-ci ne doit contenir que des caract&egrave;res non accentu&eacute;s et des chiffres.</span>';
		}
		
		// user log et change de mdp, ou user non log
		if($data->password2 && !preg_match('/^[a-zA-Z0-9._-]+$/', $data->password2)) {
			$messages[]	= '<span class="error">La confirmation du mot de passe n\'est pas valide. Celle-ci ne doit contenir que des caract&egrave;res non accentu&eacute;s et des chiffres.</span>';
		}
		
		if(($data->password || $data->password2) && $data->password != $data->password2) {
			$messages[]	= '<span class="error">La confirmation du mot de passe ne correspond pas avec le premier mot de passe entr&eacute;.</span>';
		}
		
		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', $data->email)) {
			$messages[]	= '<span class="error">Votre adresse e-mail n\'est pas valide.</span>';
		}
		
		
		// s'il n'y a pas d'erreur
		if(!count($messages)) {
		
			// on sauvegarde
			if($data->id) {
			
				$query 	= "UPDATE user SET"
				." username = '".$data->username."',"
				." email = '".$data->email."',"
				." password = MD5('".$data->password."'),"
				." published = '".$data->published."'"
				." WHERE id = '".$data->id."'"
				;
				$db->query($query);
				
				$messages[]	= '<span class="valid">Modifications enregistr&eacute;es.</span>';
				
			} else {
			
				$query 	= "INSERT INTO user SET"
				." username = '".$data->username."',"
				." email = '".$data->email."',"
				." password = MD5('".$data->password."'),"
				." published = '".$data->published."',"
				." gid = 1,"
				." confirmed = 0,"
				." creation_date = NOW()"
				;
				$db->query($query);
				JL::setVar('id', $db->insert_id());
				
				$messages[]	= '<span class="valid">Utilisateur ajout&eacute;.</span>';
				
			}
				
			// passe les variables en session
			foreach($data as $k => $v) {
				JL::setSession('userForm_'.$k, '');
			}
			
		}
	
		return $messages;
		
	}
	
	
	// �diter utilisateur
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
			
			// r�cup les infos du profil
			$query = "SELECT id, username, email, published, confirmed, creation_date, last_online, gid"
			." FROM user"
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			$userObj = $db->loadObject($query);
			
		}
		
		user_HTML::userEditer($userObj, $messages);
		
	}
	
	
	// active/d�sactive des profils pass�s en param
	function userActivation($published) {
		global $db, $messages;
		
		$ids = JL::getVar('id', array());
		
		// s'il y a des id pass�s
		if (is_array($ids)) {
			$in_id	= implode(',', $ids);
			
			// mise � jour du champ id
			$query = "UPDATE user SET published = '".$published."' WHERE id IN (".$in_id.")";
			$db->query($query);
			
			// message de confirmation
			if($published) {
				$messages[]	= '<span class="valid">Utilisateur(s) activ&eacute;(s).</span>';
			} else {
				$messages[]	= '<span class="valid">Utilisateur(s) d&eacute;sactiv&eacute;(s).</span>';
			}
			
			
			// utilisateur � d�sactiver
			if($published == 0) {
				
				// mise � jour des stats nouveaux messages
				userUpdateMessages($ids);
				
				foreach($ids as $id){
					
					// r�cup les d�tails du paiement
					$query = "SELECT id, reference_paypal, intitule_abo, montant, nom_paypal, prenom_paypal, valide"
					." FROM abonnement_paypal"
					." WHERE user_id = '".(int)$id."' and valide=1"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// r�cup les d�tails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid"
					." FROM user AS u"
					." WHERE u.id = '".(int)$id."'"
					." LIMIT 0,1"
					;
					$userProfil = $db->loadObject($queryUser);
				
					if($abonnement_paypal && $userProfil){
						mail('abonnement@solocircl.com', 'D�sactivation d\'un membre', "D�sactivation d'un membre abonn�\n\n Username : ".$userProfil->username."\n Id User (Marie) : ".$userProfil->id."\n\n Intitul� Abo : ".$abonnement_paypal->intitule_abo."\n Montant : ".$abonnement_paypal->montant."\n Nom Paypal : ".$abonnement_paypal->nom_paypal."\n Pr�nom Paypal : ".$abonnement_paypal->prenom_paypal."\n R�f�rence Paypal : ".$abonnement_paypal->reference_paypal."\n Validit� de l'Abonnement (0->non valid�, 1->en cours, 2->annul�) : ".$abonnement_paypal->valide."\n Id Abonnement Paypal (Marie) : ".$abonnement_paypal->id."\n");
					}
				
				}
				
			}
			
			
		} else {
		
			$messages[]	= '<span class="error">Veuillez s&eacute;lectionner un ou des utilisateur(s) valide(s).</span>';
			
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
		
		// g�n�re le where
		if (is_array($where)) {
			$_where		= " WHERE ".implode(' AND ', $where);
		}
		
		
		// compte le nombre de r�sultats
		$query = "SELECT COUNT(*)"
		." FROM user AS u"
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		// recherche des donn�es
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
	
	
	// supprime des profils pass�s en param
	function userSupprimer() {
		global $db, $messages;
		
		$ids 		= JL::getVar('id', array());
		$ids_profil	= array();
		
		// s'il y a des id pass�s
		if (is_array($ids)) {
		
			// mise � jour des stats nouveaux messages
			userUpdateMessages($ids);
			
			// pour chaque utilisateur � supprimer
			foreach($ids as $id) {
			
				// check si c'est un profil
				$query = "SELECT user_id FROM user_profil WHERE user_id = '".$id."' LIMIT 0,1";
				$userObj_id = $db->loadResult($query);
				
				// si c'est un utilisateur avec profil
				if($userObj_id) {
				
					// r�cup le genre
					$query = "SELECT genre FROM user_profil WHERE user_id = '".$id."' LIMIT 0,1";
					$genre = $db->loadResult($query);
				
					// met � jour les stats
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
			
		
			// cr�e une chaine contenant tous les id � supprimer
			$in_id	= implode(',', $ids);
			
			// supprime de la table USER
			$query = "DELETE FROM user WHERE id IN (".$in_id.")";
			$db->query($query);
			
			
			// cr�e une chaine contenant tous les id de profils � supprimer
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
					
					// r�cup les d�tails du paiement
					$query = "SELECT id, reference_paypal, intitule_abo, montant, nom_paypal, prenom_paypal, valide"
					." FROM abonnement_paypal"
					." WHERE user_id = '".(int)$id_profil."'"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// r�cup les d�tails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid"
					." FROM user AS u"
					." WHERE u.id = '".(int)$id_profil."'"
					." LIMIT 0,1"
					;
					$userProfil = $db->loadObject($queryUser);
				
					if($abonnement_paypal && $userProfil){
						mail('abonnement@solocircl.com', 'Suppression d\'un membre', "Suppression d'un membre abonn�\n\n Username : ".$userProfil->username."\n Id User (Marie) : ".$userProfil->id."\n\n Intitul� Abo : ".$abonnement_paypal->intitule_abo."\n Montant : ".$abonnement_paypal->montant."\n Nom Paypal : ".$abonnement_paypal->nom_paypal."\n Pr�nom Paypal : ".$abonnement_paypal->prenom_paypal."\n R�f�rence Paypal : ".$abonnement_paypal->reference_paypal."\n Validit� de l'Abonnement (0->non valid�, 1->en cours, 2->annul�) : ".$abonnement_paypal->valide."\n  Id Abonnement Paypal (Marie) : ".$abonnement_paypal->id."\n");
					}
				
				}
						
			// message de confirmation
			$messages[]	= '<span class="valid">Utilisateur(s) supprim&eacute;(s).</span>';

		} else {
		
			$messages[]	= '<span class="error">Veuillez s&eacute;lectionner un ou des utilisateur(s) valide(s).</span>';
			
		}
	
	}
	
	
	// donn�es de l'utilisateur
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
		
		// mise � jour des messages non lus envoy�s par cet utilisateur
		$query = "UPDATE message SET non_lu = 0 WHERE user_id_from IN (".$in_id.")";
		$db->query($query);
	
	}
	
?>

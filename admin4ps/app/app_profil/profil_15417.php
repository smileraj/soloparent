<?php

	// s�curit�
	defined('JL') or die('Error 401');
	
	require_once('profil.html.php');
	
	global $action;
	
	
	// variables
	$messages = array();

	
	
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
	
	// sauvegarder les infos du profil
	function profilSave() {
		global $db, $messages;
		
		// params
		$photos 	= JL::getVar('photo', array());
		
		// r�cup les donn�es
		$data 		= getData();
		
		// correction de la date, pour passer le texte de format de date
		if($data->gold_limit_date == '') {
			$data->gold_limit_date = '00/00/2000';
		}
		
		
		// r�cup le confirmed actuel
		$query = "SELECT confirmed FROM user WHERE id = '".(int)$data->id."' LIMIT 0,1";
		$confirmed = $db->loadResult($query);
		
		// on veut confirmer un profil en attente de validation
		if($confirmed == 2 && $data->confirmed == 1) {
		
			// r�cup le dernier abonnement pay� par carte
			$query = "SELECT datetime"
			." FROM paypal"
			." WHERE user_id = '".$data->id."' AND valide = 1"
			." ORDER BY datetime DESC"
			." LIMIT 0,1"
			;
			$abonnement_carte = $db->loadResult($query);
			
			// si l'utilisateur a d�j� pay� par carte
			if($abonnement_carte) {
			
				// date actuelle
				$datetime	= date('Y-m-d H:i:s');
				
				// si la date de validation est sup�rieure � la date d'abonnements
				if($datetime > $abonnement_carte) {
				
					// dur�e pendant laquelle l'abonn� n'a pu envoyer de messages
					$data->abonnement_crediter += ceil((strtotime($datetime) - strtotime($abonnement_carte))/3600.0/24.0);
				
				}
			
			}
		
		}
		
		
		// date non valide
		if(!preg_match('/^[0-3][0-9]\/0|1[0-9]\/20[0-9][0-9]$/', $data->gold_limit_date)) {
		
			$messages[]	= '<span class="error">La date limite d\'abonnement n\'est pas valide.</span>';
			
			// r�affecte la variable de date
			JL::setVar('gold_limit_date', '');
			
		} elseif($data->appel_date != '' && !preg_match('/^[0-3][0-9]\/0|1[0-9]\/200|1[0-9]$/', $data->appel_date)) {
		
			$messages[]	= '<span class="error">La date d\'appel n\'est pas valide.</span>';
			
			// r�affecte la variable de date
			JL::setVar('appel_date', '');
			
		} elseif($data->appel_date2 != '' && !preg_match('/^[0-3][0-9]\/0|1[0-9]\/200|1[0-9]$/', $data->appel_date2)) {
		
			$messages[]	= '<span class="error">La date d\'appel 2 n\'est pas valide.</span>';
			
			// r�affecte la variable de date 2
			JL::setVar('appel_date2', '');
		
		} else { // date valide
		
			// modifie la date de fin d'abonnement
			$date	= explode('/', $data->gold_limit_date);
			$jour	= $date[0];
			$mois	= $date[1];
			$annee	= $date[2];
			
			// si on veut cr�diter des jours en +
			if($data->abonnement_crediter) {
			
				// si le d�but d'abonnement est ant�rieur � la date du jour
				if($annee.'-'.$mois.'-'.$jour < date('Y-m-d')) {
					$date	= explode('/', date('d/m/Y'));
					$jour	= $date[0];
					$mois	= $date[1];
					$annee	= $date[2];
				}
				$data->gold_limit_date	= date('Y-m-d', mktime(0, 0, 0, $mois, $jour + $data->abonnement_crediter, $annee));
			
			} elseif($data->gold_limit_date != '00/00/2000') {
			
				$data->gold_limit_date = $annee.'-'.$mois.'-'.$jour;
				
			} else {
			
				$data->gold_limit_date = '0000-00-00';
				
			}
			
			// r�affecte la variable de date de fin d'abonnement
			JL::setVar('gold_limit_date', $data->gold_limit_date);
			
			// si la date d'appel est renseign�e
			if($data->appel_date != '') {
			
				// modifie la date de fin d'abonnement
				$date	= explode('/', $data->appel_date);
				$jour	= $date[0];
				$mois	= $date[1];
				$annee	= $date[2];
			
			} else {
			
				$jour	= '00';
				$mois	= '00';
				$annee	= '0000';
				
			}
			
			// r�affecte la variable de date d'appel
			JL::setVar('appel_date', $annee.'-'.$mois.'-'.$jour);
			$data->appel_date	= $annee.'-'.$mois.'-'.$jour;
			
			
			// si la date d'appel 2 est renseign�e
			if($data->appel_date2 != '') {
			
				// modifie la date de fin d'abonnement
				$date	= explode('/', $data->appel_date2);
				$jour	= $date[0];
				$mois	= $date[1];
				$annee	= $date[2];
			
			} else {
			
				$jour	= '00';
				$mois	= '00';
				$annee	= '0000';
				
			}
			
			// r�affecte la variable de date d'appel 2
			JL::setVar('appel_date2', $annee.'-'.$mois.'-'.$jour);
			$data->appel_date2	= $annee.'-'.$mois.'-'.$jour;
			
		}
		
		
		// si des photos ont �t� coch�es
		if (is_array($photos)) {
			
			foreach($photos as $photo) {
				
				$photoTmp	= explode('-', $photo);
				$file		= str_replace('.jpg','',$photoTmp[3].'-'.$photoTmp[4]);
				
				if(is_file('../images/profil/'.$data->id.'/parent-solo-'.$file.'.jpg')) {
				
					@unlink('../images/profil/'.$data->id.'/parent-solo-'.$file.'.jpg');
					@unlink('../images/profil/'.$data->id.'/parent-solo-35-'.$file.'.jpg');
					@unlink('../images/profil/'.$data->id.'/parent-solo-89-'.$file.'.jpg');
					@unlink('../images/profil/'.$data->id.'/parent-solo-109-'.$file.'.jpg');
					@unlink('../images/profil/'.$data->id.'/parent-solo-220-'.$file.'.jpg');
					
					// retire la photo de la liste des derni�res photos ajout�es
					$query = "DELETE FROM photo_last WHERE user_id = '".$data->id."' AND photo_name = '".$file."'";
					$db->query($query);
				
				}
				
			}
			
		}
		
		
		// s'il n'y a pas d'erreur
		if(!count($messages)) {
		
			// on sauvegarde
			if($data->id) {
				
				
				if($data->confirmed == 0){
					// r�cup les d�tails du paiement
					$query = "SELECT id, reference_paypal, intitule_abo, montant, nom_paypal, prenom_paypal, valide"
					." FROM abonnement_paypal"
					." WHERE user_id = '".(int)$data->id."' and valide=1"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// r�cup les d�tails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid, u.confirmed"
					." FROM user AS u"
					." WHERE u.id = '".(int)$data->id."'"
					." LIMIT 0,1"
					;
					$userProfil = $db->loadObject($queryUser);
				
					if($abonnement_paypal && $userProfil){
						mail('abonnement@solocircl.com', 'D�sactivation d\'un membre', "D�sactivation d'un membre abonn�\n\n Username : ".$userProfil->username."\n Id User (Marie) : ".$userProfil->id."\n\n Intitul� Abo : ".$abonnement_paypal->intitule_abo."\n Montant : ".$abonnement_paypal->montant."\n Nom Paypal : ".$abonnement_paypal->nom_paypal."\n Pr�nom Paypal : ".$abonnement_paypal->prenom_paypal."\n R�f�rence Paypal : ".$abonnement_paypal->reference_paypal."\n Validit� de l'Abonnement (0->non valid�, 1->en cours, 2->annul�) : ".$abonnement_paypal->valide."\n Id Abonnement Paypal (Marie) : ".$abonnement_paypal->id."\n");
					}
					
					if($userProfil->confirmed){
						$q = "INSERT INTO user_desinscription SET"
						." user_id = '".(int)$data->id."',"
						." datetime = NOW()"
						;
						$db->query($q);
					}
				}	
				
				if($data->confirmed == 1){
					$queryUser = "SELECT datetime"
					." FROM user_desinscription"
					." WHERE user_id = '".(int)$data->id."' AND datetime_reactive is null"
					." LIMIT 0,1"
					;
					$userDesactive = $db->loadObject($queryUser);
				
					if($userDesactive->datetime){
						$q = "UPDATE user_desinscription SET"
						." datetime_reactive = NOW()"
						." WHERE user_id = '".(int)$data->id."' AND datetime_reactive is null"
						;
						$db->query($q);
					}
				}	
					
				
				// mise � jour du profil
				$query 	= "UPDATE user_profil SET"
				." nom_origine = '".$db->escape($data->nom_origine)."',"
				." prenom_origine = '".$db->escape($data->prenom_origine)."',"
				." telephone_origine = '".$db->escape($data->telephone_origine)."',"
				." adresse_origine = '".$db->escape($data->adresse_origine)."',"
				." code_postal_origine = '".$db->escape($data->code_postal_origine)."',"
				." helvetica = '".$db->escape($data->helvetica)."'"
				." WHERE user_id = '".$data->id."'"
				;
				$db->query($query);
				
				// mise � jour des stats du compte
				$query 	= "UPDATE user_stats SET"
				." gold_limit_date = '".$db->escape($data->gold_limit_date)."',"
				." appel_date = '".$db->escape($data->appel_date)."',"
				." appel_date2 = '".$db->escape($data->appel_date2)."',"
				." commentaire = '".$db->escape($data->commentaire)."'"
				." WHERE user_id = '".$db->escape($data->id)."'"
				;
				$db->query($query);
				
				
				// d�sactivation du profil si confirmed = 0
				if($data->confirmed == 0) {
					$updatePublished = ', published = 0';
				} else {
					$updatePublished = ', published = 1';
				}
				
				// mise � jour de la confirmation du compte
			 	$query	= "UPDATE user SET"
				." confirmed = '".$data->confirmed."'"
				.$updatePublished
				." WHERE id = '".$data->id."'"
				;
				$db->query($query);
				
				
				// mise � jour de l'annonce du profil
				$query = "UPDATE user_annonce SET"
				." annonce_valide = '".$db->escape($data->annonce_valide)."'"
				." WHERE user_id = '".$db->escape($data->id)."'"
				;
				$db->query($query);
				
				
				// si des jours ont �t� cr�dit�s
				if($data->abonnement_crediter) {
					$messages[]	= '<span class="valid">'.$data->abonnement_crediter.' jour(s) cr&eacute;dit&eacute;(s).</span>';
				}
				
				
				// si des points ont �t� cr�dit�s
				if($data->points_id > 0) {
				
					$query = "SELECT points FROM points WHERE id = '".$db->escape($data->points_id)."' LIMIT 0,1";
					$points = $db->loadResult($query);
					
					// cr�dite les points
					JL::addPoints($data->points_id, $data->id);
					
					// message de confirmation
					$messages[]	= '<span class="valid">'.$points.' points cr&eacute;dit&eacute;(s).</span>';
				
				}
				
				
				// points � retirer
				if($data->points_retirer > 0) {
				
					JL::addPoints(20, $data->id, $data->points_retirer);
					
					// message de confirmation
					$messages[]	= '<span class="valid">'.$data->points_retirer.' points retir&eacute;(s).</span>';
					
				}
				
				
				if($data->confirmed == 1) {
					
					// cr�dite l'action profil complet (compt� qu'une fois np)
					JL::addPoints(5, $data->id);
					
					// r�cup le parrain_id de l'utilisateur
					$query = "SELECT parrain_id FROM user_profil WHERE user_id = '".$db->escape($data->id)."' LIMIT 0,1";
					$parrain_id = $db->loadResult($query);
					
					// parrainage
					if($parrain_id > 0) {
					
						// cr�dite les points: �tre parrain�
						JL::addPoints(21, $data->id, $parrain_id);
						
						// cr�dite les points: parrainer un(e) ami(e)
						JL::addPoints(22, $parrain_id, $data->id);
						
					}
				
				}
				
			
				// mesage de confirmation
				$messages[]	= '<span class="valid">Modifications enregistr&eacute;es.</span>';
				
			}
			
		}
		
		return $messages;
		
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
				$userObj->{$k} = $v ? $v : $userObj->{$k};
			}
			
			
			// r�cup le dernier abonnement pay� par carte
			$query = "SELECT nom_paypal, prenom_paypal, IF(date_dernier_renouvellement = '0000-00-00 00:00:00', date_souscription, date_dernier_renouvellement) as datetime, valide"
			." FROM abonnement_paypal"
			." WHERE user_id = '".$userObj->id."' AND valide > 0"
			." ORDER BY id DESC"
			." LIMIT 0,1"
			;
			$abonnement_carte = $db->loadObject($query);
			$userObj->abonnement_carte = $abonnement_carte->datetime ? $abonnement_carte->datetime : false;
			
			if($userObj>abonnement_carte){
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
	
	function profilSuppression(){
		global $db, $messages;
		
		$ids = JL::getVar('id', array());
		
		// s'il y a des id pass�s
		if (is_array($ids)) {
			
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
				
				$q = "INSERT INTO user_desinscription SET"
				." user_id = '".(int)$id."',"
				." datetime = NOW()"
				;
				$db->query($q);
			}
			
			$in_id	= implode(',', $ids);
			
			
			// mise � jour du champ id
			$query = "INSERT INTO `user_suppr` (id,username,password,password_new,email,gid,published,confirmed,creation_date,last_online,ip,ip_pays,online) SELECT id,username,password,password_new,email,gid,published,confirmed,creation_date,last_online,ip,ip_pays,online FROM `user` where id IN (".$in_id.")";
			$db->query($query);
			$insert_user_suppr = $db->affected_rows();
			
			$query = "UPDATE user_annonce SET annonce='' where user_id IN (".$in_id.")";
			$db->query($query);
			
			$query = "UPDATE user_stats SET photo_a_valider=0 where user_id IN (".$in_id.")";
			$db->query($query);
			
			$query = "DELETE FROM user where id IN (".$in_id.")";
			$db->query($query);
			$delete_user = $db->affected_rows();
			
			// message de confirmation
			if($insert_user_suppr == $delete_user) {
				$messages[]	= '<span class="valid">Profil(s) supprim&eacute;(s).</span>';
			} else {
				$messages[]	= '<span class="error">Probl&egrave;me au niveau de la suppression.</span>';
			}
			
							
			// mise � jour des messages
			profilUpdateMessages($ids);
				
			// mise � jour des messages non lus envoy�s par cet utilisateur
			$query = "UPDATE message SET non_lu = 0 WHERE user_id_from IN (".$in_id.")";
			$db->query($query);
				
			
			
		} else {
		
			$messages[]	= '<span class="error">Veuillez s&eacute;lectionner un ou des profil(s) valide(s).</span>';
			
		}
		
	
	}
	
	
	// active/d�sactive des profils pass�s en param
	function profilActivation($published) {
		global $db, $messages;
		
		$ids = JL::getVar('id', array());
		
		// s'il y a des id pass�s
		if (is_array($ids)) {
			
			if($published == 0){
				foreach($ids as $id){
					// r�cup les d�tails du paiement
					$query = "SELECT id, reference_paypal, intitule_abo, montant, nom_paypal, prenom_paypal, valide"
					." FROM abonnement_paypal"
					." WHERE user_id = '".(int)$id."' and valide=1"
					." LIMIT 0,1"
					;
					$abonnement_paypal	= $db->loadObject($query);
					
					// r�cup les d�tails de l'utilisateur
					$queryUser = "SELECT u.id, u.username, u.gid, u.confirmed"
					." FROM user AS u"
					." WHERE u.id = '".(int)$id."'"
					." LIMIT 0,1"
					;
					$userProfil = $db->loadObject($queryUser);
				
					if($abonnement_paypal && $userProfil){
						mail('abonnement@solocircl.com', 'D�sactivation d\'un membre', "D�sactivation d'un membre abonn�\n\n Username : ".$userProfil->username."\n Id User (Marie) : ".$userProfil->id."\n\n Intitul� Abo : ".$abonnement_paypal->intitule_abo."\n Montant : ".$abonnement_paypal->montant."\n Nom Paypal : ".$abonnement_paypal->nom_paypal."\n Pr�nom Paypal : ".$abonnement_paypal->prenom_paypal."\n R�f�rence Paypal : ".$abonnement_paypal->reference_paypal."\n Validit� de l'Abonnement (0->non valid�, 1->en cours, 2->annul�) : ".$abonnement_paypal->valide."\n Id Abonnement Paypal (Marie) : ".$abonnement_paypal->id."\n");
					}
					
						
					if($userProfil->confirmed){
						$q = "INSERT INTO user_desinscription SET"
						." user_id = '".(int)$id."',"
						." datetime = NOW()"
						;
						$db->query($q);
					}
				}
			}
			
			if($published == 1){
				foreach($ids as $id){
					$queryUser = "SELECT datetime"
					." FROM user_desinscription"
					." WHERE user_id = '".(int)$id."' AND datetime_reactive is null"
					." LIMIT 0,1"
					;
					$userDesactive = $db->loadObject($queryUser);
				
					if($userDesactive->datetime){
						$q = "UPDATE user_desinscription SET"
						." datetime_reactive = NOW()"
						." WHERE user_id = '".(int)$id."' AND datetime_reactive is null"
						;
						$db->query($q);
					}
				}
			}	
			
			$in_id	= implode(',', $ids);
			
			// mise � jour du champ id
			$query = "UPDATE user SET published = '".$published."' WHERE id IN (".$in_id.")";
			$db->query($query);
			
			// message de confirmation
			if($published) {
				$messages[]	= '<span class="valid">Profil(s) activ&eacute;(s).</span>';
			} else {
				$messages[]	= '<span class="valid">Profil(s) d&eacute;sactiv&eacute;(s).</span>';
			}
			
			// utilisateur � d�sactiver
			if($published == 0) {
				
				// mise � jour des messages
				profilUpdateMessages($ids);
				
				// mise � jour des messages non lus envoy�s par cet utilisateur
				$query = "UPDATE message SET non_lu = 0 WHERE user_id_from IN (".$in_id.")";
				$db->query($query);
				
			}
			
		} else {
		
			$messages[]	= '<span class="error">Veuillez s&eacute;lectionner un ou des profil(s) valide(s).</span>';
			
		}
	
	}
	
	// liste les profils
	function profilLister() {
		global $db, $messages;
		
		// variables
		$resultatParPage		= RESULTS_NB_LISTE_ADMIN;
		$stats					= array();
		$search					= array();
		$lists					= array();
		$where					= array();
		$_where					= '';
		
		// params
		
		// si on passe une recherche en param, alors on force la page 1 (pour �viter de charger la page 36, s'il n'y a que 2 pages � voir)
		$search['page']			= JL::getVar('search_page', JL::getSessionInt('search_page', 1));
		
		// mot cherch�
		$search['word']			= trim(JL::getVar('search_word', JL::getSession('search_word', ''), true));
		$search['order']		= JL::getVar('search_order', JL::getSession('search_order', 'u.creation_date'));
		$search['ascdesc']		= JL::getVar('search_ascdesc', JL::getSession('search_ascdesc', 'desc'));
		$search['confirmed']	= JL::getVar('search_confirmed', JL::getSession('search_confirmed', -1));
		$search['genre']		= JL::getVar('search_genre', JL::getSession('search_genre', ''));
		$search['abonnement']	= JL::getVar('search_abonnement', JL::getSession('search_abonnement', ''));
		$search['helvetica']	= (int)JL::getVar('search_helvetica', JL::getSession('search_helvetica', 2));
		
		// conserve en session ces param�tres
		JL::setSession('search_page', 		$search['page']);
		JL::setSession('search_word', 		$search['word']);
		JL::setSession('search_order', 		$search['order']);
		JL::setSession('search_ascdesc', 	$search['ascdesc']);
		JL::setSession('search_confirmed', 	$search['confirmed']);
		JL::setSession('search_genre', 		$search['genre']);
		JL::setSession('search_abonnement', $search['abonnement']);
		JL::setSession('search_helvetica', 	$search['helvetica']);
		
		
		// crit�re de tri
		$order					= array();
		$order[]				= JL::makeOption('u.creation_date', 	'Date inscription');
		$order[]				= JL::makeOption('us.appel_date', 	'Date appel');
		$order[]				= JL::makeOption('u.last_online', 		'Derni�re connexion');
		$order[]				= JL::makeOption('us.gold_limit_date', 	'Fin abonnement');
		$order[]				= JL::makeOption('u.ip_pays', 			'Pays');
		$order[]				= JL::makeOption('us.points_total', 	'Points Total');
		$order[]				= JL::makeOption('u.username', 			'Pseudo');
		$lists['order']			= JL::makeSelectList($order, 'search_order', 'class="searchInput"', 'value', 'text', $search['order']);

		// ordre croissant/d�croissant
		$ascdesc				= array();
		$ascdesc[]				= JL::makeOption('asc', 			'Croissant');
		$ascdesc[]				= JL::makeOption('desc', 			'D�croissant');
		$lists['ascdesc']		= JL::makeSelectList($ascdesc, 'search_ascdesc', 'class="searchInput"', 'value', 'text', $search['ascdesc']);
		
		// statut
		$confirmed				= array();
		$confirmed[]			= JL::makeOption('-1', 				'Tous');
		$confirmed[]			= JL::makeOption('2', 				'A valider');
		$confirmed[]			= JL::makeOption('1', 				'Confirm�s');
		$confirmed[]			= JL::makeOption('0', 				'Refus�s');
		$lists['confirmed']		= JL::makeSelectList($confirmed, 'search_confirmed', 'class="searchInput"', 'value', 'text', $search['confirmed']);
		
		// genre
		$genre					= array();
		$genre[]				= JL::makeOption('', 				'Tous');
		$genre[]				= JL::makeOption('f', 				'Femme');
		$genre[]				= JL::makeOption('h', 				'Homme');
		$lists['genre']			= JL::makeSelectList($genre, 'search_genre', 'class="searchInput"', 'value', 'text', $search['genre']);
		
		// abonnement
		$abonnement				= array();
		$abonnement[]			= JL::makeOption('', 				'Tous');
		$abonnement[]			= JL::makeOption('1',				'Aucun');
		$abonnement[]			= JL::makeOption('2', 				'En cours');
		$abonnement[]			= JL::makeOption('3', 				'Termin�');
		$lists['abonnement']	= JL::makeSelectList($abonnement, 'search_abonnement', 'class="searchInput"', 'value', 'text', $search['abonnement']);
		
		// profil helvetica
		$lists['helvetica']		= '<input type="radio" name="search_helvetica" id="search_helvetica1" value="1" '.($search['helvetica'] == 1 ? 'checked' : '').' /> <label for="search_helvetica1">Oui</label> <input type="radio" name="search_helvetica" id="search_helvetica0" value="0" '.($search['helvetica'] == 0 ? 'checked' : '').' /> <label for="search_helvetica0">Non</label> <input type="radio" name="search_helvetica" id="search_helvetica2" value="2" '.($search['helvetica'] == 2 ? 'checked' : '').' /> <label for="search_helvetica2">Peu importe</label>';
		
		
		// on n'affiche pas les admins
		$where[]				= "u.gid = 0";
		
		// date d'abonnement
		if($search['abonnement']) {
			
			// aucun abo
			if($search['abonnement'] == '1') {
			
				$where[]		= "us.gold_limit_date = '0000-00-00'";
				
			} elseif($search['abonnement'] == '2') { // abo en cours
			
				$where[]		= "us.gold_limit_date >= NOW()";
			
			} elseif($search['abonnement'] == '3') { // abo termin�
			
				$where[]		= "us.gold_limit_date < NOW()";
				$where[]		= "us.gold_limit_date != '0000-00-00'";
				
			}
			
		}
		
		// recherche d'un pseudo
		if($search['word']) {
			$where[]			= "(u.username LIKE '%".$search['word']."%' OR u.email LIKE '%".$search['word']."%' OR up.nom LIKE '%".$search['word']."%' OR up.nom_origine LIKE '%".$search['word']."%' OR up.prenom LIKE '%".$search['word']."%' OR up.prenom_origine LIKE '%".$search['word']."%' OR up.telephone LIKE '%".$search['word']."%')";
		}
		
		// profils actifs
		if($search['confirmed'] >= 0) {
			$where[]			= "u.confirmed = '".addslashes($search['confirmed'])."'";
		}
		
		// genre
		if($search['genre'] != '') {
			$where[]			= "up.genre = '".addslashes($search['genre'])."'";
		}
		
		// profil helvetica
		if($search['helvetica'] == 1) {
			$where[]			= "up.helvetica = 1";
		} elseif($search['helvetica'] == 0) {
			$where[]			= "up.helvetica = 0";
		}
		
		// g�n�re le where
		if (is_array($where)) {
			$_where				= " WHERE ".implode(' AND ', $where);
		}
		
		
		// compte le nombre de r�sultats
		$query = "SELECT COUNT(*)"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_stats AS us ON us.user_id = u.id"
		.$_where
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		// recherche des donn�es
		$query = "SELECT u.id, u.username, u.confirmed, u.published, u.ip, u.ip_pays, up.helvetica, up.genre, us.gold_limit_date, up.nom_origine, up.prenom_origine, up.telephone_origine, us.appel_date, us.appel_date2, us.points_total"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." INNER JOIN user_stats AS us ON us.user_id = u.id"
		.$_where
		." ORDER BY ".strtolower($search['order'])." ".strtoupper($search['ascdesc'])
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$results	= $db->loadObjectList($query);
		
		
		// r�cup le nombre d'inscrits (table � part pour �viter les COUNT(*) sur la table user � chaque chargement de page
		/*$query = "SELECT papa, maman"
		." FROM inscrits"
		." LIMIT 0,1"
		;
		$inscrits = $db->loadObjectList($query);
		
		$total 	= $inscrits['maman'] + $inscrits['papa'];
		
		$stats['mamans'] 	= ceil($inscrits['maman'] / $total * 100);
		$stats['papas']		= 100 - $stats['mamans'];*/
		$query = "SELECT count(*)"
		." FROM user as u"
		." LEFT JOIN user_profil as up ON up.user_id = u.id"
		." WHERE up.genre = 'f' AND u.confirmed=1"
		;
		$inscrits_mamans = $db->loadResult($query);
		
		$query = "SELECT count(*)"
		." FROM user as u"
		." LEFT JOIN user_profil as up ON up.user_id = u.id"
		." WHERE up.genre = 'h' AND u.confirmed=1"
		;
		$inscrits_papas = $db->loadResult($query);
		
		$stats['mamans'] 	= ceil($inscrits_mamans / ($inscrits_mamans+$inscrits_papas) * 100);
		$stats['papas']		= 100 - $stats['mamans'];
		
		profil_HTML::profilLister($results, $search, $lists, $messages, $stats);
		
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
		;
		$users = $db->loadObjectList($query);
		
		// parcourt la lsite des utilisateurs avec photo � valider
		$usersTotal	= count($users);
		for($i=0; $i<$usersTotal; $i++) {
			$users[$i]->photos = array();
			
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
		$photos = JL::getVar('photo', array());
		$task 	= JL::getVar('task', '');
		
		// variables
		$msg		= '';
		
		// si des photos ont �t� coch�es
		if (is_array($photos)) {
			
			foreach($photos as $photo) {
				
				$photoTmp	= explode('_', $photo);
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
		$textes = JL::getVar('texte', array());
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

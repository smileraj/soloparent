<?php

	// sécurité
	defined('JL') or die('Error 401');

	require_once('abonnement.html.php');
			include("lang/app_abonnement.".$_GET['lang'].".php");

	global $action, $user, $langue,$langString;
	
	// si non log dans l'appli search (hors step8submit qui fait partie du processus compliqué d'inscription)
	if(!$user->id) {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription'.'&'.$langue);
	}

	if($_GET['lang']=='fr'){
		$langString = '';
	}else{
		$langString = "_".$_GET['lang'];
	}

	// gestion des messages d'erreurs
	$messages	= [];


	// controller
	switch($action) {

		case 'methode':
			$methode_id		= (int)JL::getVar('methode_id', 1);
			$abonnement_id 	= (int)JL::getVar('abonnement_id', 1, true);

			// paypal
			if($methode_id == 1) {

				$custom 	= JL::getVar('custom', '');
				if($custom == '') {

					// si pas log
					if(!$user->id) {
						JL::redirect('index.php?app=profil&action=inscription&'.$langue);
					}

					abonnementPaypalForm($abonnement_id);

				} else {

					abonnementPaypalReturn($custom);

				}

			} else {

				abonnementPaiment($methode_id, $abonnement_id);

			}
		break;

		case 'tarifs':
			abonnementTarifs();
		break;

		default:
			JL::loadApp('404');
		break;

	}

	// affiche la page des tarifs
	function abonnementTarifs() {
		global $langue, $langString;
		global $db;

		// variables
		$contenu	= [];

		// récup le contenu de la page
		$query = "SELECT  titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte"
		." FROM contenu"
		." WHERE id = '12'"
		." LIMIT 0,1"
		;
		$contenu = $db->loadObject($query);
		
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 106";
		$debut = $db->loadObject($query);

		// affiche la page
		HTML_abonnement::abonnementTarifs($contenu, $debut);

	}


	// formulaire de paiement paypal
	function abonnementPaypalForm($abonnement_id) {
		global $langue;
		global $db, $user;

		// variables
		$time = time();

		// tarifs de l'abonnement désiré
		$query = "SELECT id, nom, prix FROM abonnement WHERE id = '".(int)$abonnement_id."' AND active = 1 LIMIT 0,1";
		$row = $db->loadObject($query);

		// abonnement inconnu
		if(!$row) {
			JL::redirect('index.php?app=abonnement&action=abonner&'.$langue);
		}


		// conserve la demande de transaction
		$query = "INSERT INTO paypal SET"
		." user_id = '".$user->id."',"
		." abonnement_id = '".(int)$abonnement_id."',"
		." datetime = '".date('Y-m-d H:i:s', $time)."',"
		." valide = 0,"
		." montant = '".$row->prix."'"
		;
		$db->query($query);
		$row->paypal_id = $db->insert_id();


		// génération de la valeur de retour 'custom'
		$row->custom 	= base64_encode(MD5($user->username.$user->gid.date('Y-m-d H:i:s', $time)).":".$row->paypal_id);


		HTML_abonnement::paypalForm($row);

	}


	// page de retour de paypal
	function abonnementPaypalReturn($custom) {
		global $langue;
		global $db;

		// récup les valeurs qui étaient passées dans custom
		$arguments 		= explode(":", base64_decode((string) $custom));
		$md5			= $arguments[0]; 		// md5 de vérfication
		$paypal_id		= isset($arguments[1]) ? (int)$arguments[1] : 0; 	// SQL: paypal.id

		// récup la durée d'abo
		$query = "SELECT a.duree"
		." FROM paypal AS p"
		." INNER JOIN abonnement AS a ON a.id = p.abonnement_id"
		." WHERE p.id = '".$paypal_id."' AND a.active = 1"
		." LIMIT 0,1"
		;
		$duree_credite = $db->loadResult($query);
		
		HTML_abonnement::paypalReturn($duree_credite ?: false);

	}


	// methode de paiement standard
	function abonnementPaiment($methode_id, $abonnement_id) {
		global $langue, $langString;
		global $db;

		// tarifs de l'abonnement désiré
		$query = "SELECT duree, prix FROM abonnement WHERE id = '".(int)$abonnement_id."' AND active = 1 LIMIT 0,1";
		$row = $db->loadObject($query);

		// abonnement ou méthodes inconnu(e)(s)
		if(!$row || !in_array($methode_id, [2,3])) {
			JL::redirect('index.php?app=abonnement&action=abonner&'.$langue);
		}
		
		if($methode_id == 2){
			
			$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 104";
			$paiement = $db->loadObject($query);
			
			$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 105";
			$debut = $db->loadObject($query);
			
		}else{
			
			$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 107";
			$paiement = $db->loadObject($query);
			
			$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 108";
			$debut = $db->loadObject($query);
			
		}

		HTML_abonnement::abonnementForm($methode_id, $paiement, $debut, $row->duree, $row->prix);

	}

?>

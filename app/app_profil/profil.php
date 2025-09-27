
<script language="javascript" type="text/javascript">
function sunsign() 
{
   document.step1.naissance_jour.selectedIndex;
   document.step1.naissance_mois.selectedIndex;
   document.step1.signe_astrologique_id.value;
    if (document.step1.naissance_mois.selectedIndex == 1 && document.step1.naissance_jour.selectedIndex <=19)
   {	
   document.step1.signe_astrologique_id.value = "10";
   }
   if (document.step1.naissance_mois.selectedIndex == 1 && document.step1.naissance_jour.selectedIndex >=20) {document.step1.signe_astrologique_id.value = "11";}
   if (document.step1.naissance_mois.selectedIndex == 2 && document.step1.naissance_jour.selectedIndex <=18) {document.step1.signe_astrologique_id.value = "11";}
   if (document.step1.naissance_mois.selectedIndex == 2 && document.step1.naissance_jour.selectedIndex >=19) {document.step1.signe_astrologique_id.value = "12";}
   if (document.step1.naissance_mois.selectedIndex == 3 && document.step1.naissance_jour.selectedIndex <=20) {document.step1.signe_astrologique_id.value = "12";}
   if (document.step1.naissance_mois.selectedIndex == 3 && document.step1.naissance_jour.selectedIndex >=21) {document.step1.signe_astrologique_id.value = "1";}
   if (document.step1.naissance_mois.selectedIndex == 4 && document.step1.naissance_jour.selectedIndex <=20) {document.step1.signe_astrologique_id.value = "1";}
   if (document.step1.naissance_mois.selectedIndex == 4 && document.step1.naissance_jour.selectedIndex >=21) {
   
   document.step1.signe_astrologique_id.value = "6";}
   if (document.step1.naissance_mois.selectedIndex == 5 && document.step1.naissance_jour.selectedIndex <=20) {document.step1.signe_astrologique_id.value = "6";}
   if (document.step1.naissance_mois.selectedIndex == 5 && document.step1.naissance_jour.selectedIndex >=21) {document.step1.signe_astrologique_id.value = "3";}
   if (document.step1.naissance_mois.selectedIndex == 6 && document.step1.naissance_jour.selectedIndex <=20) {document.step1.signe_astrologique_id.value = "3";}
   if (document.step1.naissance_mois.selectedIndex == 6 && document.step1.naissance_jour.selectedIndex >=21) {document.step1.signe_astrologique_id.value = "4";}
   if (document.step1.naissance_mois.selectedIndex == 7 && document.step1.naissance_jour.selectedIndex <=21) {document.step1.signe_astrologique_id.value = "4";}
   if (document.step1.naissance_mois.selectedIndex == 7 && document.step1.naissance_jour.selectedIndex >=22) {document.step1.signe_astrologique_id.value = "5";}
   if (document.step1.naissance_mois.selectedIndex == 8 && document.step1.naissance_jour.selectedIndex <=21) {document.step1.signe_astrologique_id.value = "5";}
   if (document.step1.naissance_mois.selectedIndex == 8 && document.step1.naissance_jour.selectedIndex >=22) {document.step1.signe_astrologique_id.value = "2";}
   if (document.step1.naissance_mois.selectedIndex == 9 && document.step1.naissance_jour.selectedIndex <=21) {document.step1.signe_astrologique_id.value = "2";}
   if (document.step1.naissance_mois.selectedIndex == 9 && document.step1.naissance_jour.selectedIndex >=22) {document.step1.signe_astrologique_id.value = "7";}
   if (document.step1.naissance_mois.selectedIndex == 10 && document.step1.naissance_jour.selectedIndex <=21) {document.step1.signe_astrologique_id.value = "7";}
   if (document.step1.naissance_mois.selectedIndex == 10 && document.step1.naissance_jour.selectedIndex >=22) {document.step1.signe_astrologique_id.value = "8";}
   if (document.step1.naissance_mois.selectedIndex == 11 && document.step1.naissance_jour.selectedIndex <=21) {document.step1.signe_astrologique_id.value = "8";}
   if (document.step1.naissance_mois.selectedIndex == 11 && document.step1.naissance_jour.selectedIndex >=22) {document.step1.signe_astrologique_id.value = "9";}
   if (document.step1.naissance_mois.selectedIndex == 12 && document.step1.naissance_jour.selectedIndex <=20) {document.step1.signe_astrologique_id.value = "9";}
   if (document.step1.naissance_mois.selectedIndex == 12 && document.step1.naissance_jour.selectedIndex >=21) {document.step1.signe_astrologique_id.value = "10";}

   if (document.step1.naissance_mois.selectedIndex == "x" || document.step1.naissance_jour.selectedIndex == "y") return;
 }

function valinaissance_jour() {
   if (document.step1.naissance_mois.selectedIndex == 2 && document.step1.naissance_jour.selectedIndex > 29) {alert("There are only a maximum of 29 days in February."); return false;}
   if (document.step1.naissance_mois.selectedIndex == 4 && document.step1.naissance_jour.selectedIndex == 31) {alert("There are only 30 days in April."); return false;}
   if (document.step1.naissance_mois.selectedIndex == 6 && document.step1.naissance_jour.selectedIndex == 31) {alert("There are only 30 days in June."); return false;}
   if (document.step1.naissance_mois.selectedIndex == 9 && document.step1.naissance_jour.selectedIndex == 31) {alert("There are only 30 days in September."); return false;}
   if (document.step1.naissance_mois.selectedIndex == 11 && document.step1.naissance_jour.selectedIndex == 31) {alert("There are only 30 days in November."); return false;}
else{
return true;
}
 }
</script>
<?php
	// s�curit�
	defined('JL') or die('Error 401');

	require_once('profil.html.php');
	include("lang/app_profil.".$_GET['lang'].".php");

	// variables
	global $action, $user, $langue, $langString;
	$messages	= array(); // gestion des messages d'erreurs
	if($_GET["lang"]=='fr')
		$langString = "";
	else
		$langString = "_".$_GET["lang"];
	

	// librairie de fonctions
	if(in_array($action, array('panel', 'step6', 'step6submit'))) {
		require_once(SITE_PATH.'/framework/functions.php');
	}


	// pseudo controller � la joomla 1.0
	switch($action) {



		// VISUALISATION
		case 'view':
		case 'view2':
		case 'view3':
		case 'view4':
		case 'view5':
		case 'view6': // groupes
		/*case 'view7': // messages �chang�s */
			if(!$user->id) {
				JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			}
			profil();
		break;


		// GROUPES
		case 'view6':
			profilGroupes((int)JL::getVar('id', 0));
		break;


		// LOGGED
		case 'panel':

			// utilisateur non log
			if(!$user->id) {
				JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			}

			panel();
		break;

		case 'notification':

			// user non log
			if(!$user->id) {
				// redirige sur l'inscription
				JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			}

			// gestion des notifications de l'utilisateur
			notification();

		break;

		case 'notificationsubmit':

			// user non log
			if(!$user->id) {
				// redirige sur l'inscription
				JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			}

			// traitement des donn�es du formulaire
			$messages = notificationsubmit();

			// r�-affiche le formulaire avec message de validation
			notification($messages);

		break;


		


		// INSCRIPTION
		/*case 'confirmation':
			confirmation();
		break;*/

		case 'finalisation':
			step_check(6);
			finalisation();
		break;


		case 'step5':
			step_check(5);
			step5();
		break;

		case 'step5submit':

			// traitement des donn�es du formulaire
			$messages = step5submit();

			// messages pr�sents (un message seul = message de validation, donc user log)
			if (is_array($messages)) {

				// r�-affiche l'�tape
				step5($messages);

			} else {

				// passe � l'�tape suivante
				JL::redirect('index.php?app=profil&action=finalisation'.'&'.$langue);

			}

		break;



		case 'step4':
			step_check(4);
			step4();
		break;

		case 'step4submit':

			// traitement des donn�es du formulaire
			$messages = step4submit();

			// messages pr�sents (un message seul = message de validation, donc user log)
			if (is_array($messages)) {

				// r�-affiche l'�tape
				step4($messages);

			} else {

				// passe � l'�tape suivante
				JL::redirect('index.php?app=profil&action=step5'.'&'.$langue);

			}

		break;



		case 'step3':
			step_check(3);
			step3();
		break;

		case 'step3submit':

			// traitement des donn�es du formulaire
			$messages = step3submit();

			// messages pr�sents (un message seul = message de validation, donc user log)
			if (is_array($messages)) {

				// r�-affiche l'�tape
				step3($messages);

			} else {

				// passe � l'�tape suivante
				JL::redirect('index.php?app=profil&action=step4'.'&'.$langue);

			}

		break;



		case 'step2':
			step_check(2);
			step2();
		break;

		case 'step2submit':

			// traitement des donn�es du formulaire
			$messages = step2submit();

			// messages pr�sents (un message seul = message de validation, donc user log)
			if (is_array($messages)) {

				// r�-affiche l'�tape
				step2($messages);

			} else {

				// passe � l'�tape suivante
				JL::redirect('index.php?app=profil&action=step3'.'&'.$langue);

			}

		break;


		case 'inscription':
		case 'step1':
			step1();
		break;

		case 'step1submit':

			// traitement des donn�es du formulaire
			$messages = step1submit();

			// messages pr�sents (un message seul = message de validation, donc user log)
			if (is_array($messages)) {

				// r�-affiche l'�tape
				step1($messages);

			} else {

				// passe � l'�tape suivante
				JL::redirect('index.php?app=profil&action=step2'.'&'.$langue);

			}

		break;



		default:
			JL::loadApp('404');
		break;

	}


	


	// le visiteur a-t-il rempli l'�tape pr�c�dent la num�ro $step_num
	function step_check($step_num) {
		global $langue;
		global $db, $user;
		// utilisateur non log
		if(!$user->id) {
			/*if(isset($_SESSION['step_ok']) && $step_num > ($_SESSION['step_ok']+1)) {
				JL::redirect("index.php?app=profil&action=step".($_SESSION['step_ok']+1));
			} elseif(!isset($_SESSION['step_ok'])) {
				JL::redirect("index.php?app=profil&action=inscription");*/

			if($step_num > 1 && JL::getSessionInt('step_ok', 0) < 1) { // page inscription obligatoire (�tape 1)
				JL::redirect("index.php?app=profil&action=inscription".'&'.$langue);
			} else {
				$query = "UPDATE user_inscription SET step = '".$step_num."', ip = '".$_SERVER["REMOTE_ADDR"]."' WHERE username LIKE '".JL::getSession('username', '', true)."'";
				$db->query($query);
			}
		}

	}

	// r�cup la notice/indication de gauche affich�e lors de l'inscription
	function getNotice($step_num) {
		global $langue, $langString;
		global $db;

		if($step_num == 7) { // photos enfant

			$id = 21;

		} elseif($step_num == 2) { // photos profil

			$id = 23;

		} elseif($step_num == 3) { // mon annonce

			$id = 22;

		} else { // if(in_array($step_num, array(1,4,5,6,8,9,10))) { // pour vous guider

			$id = 20;

		}

		// r�cup le texte
		$query = "SELECT titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = '".(int)$id."' LIMIT 0,1";
		$notice = $db->loadObject($query);

		return $notice;

	}
	

	function step1($messages = array()) {

		global $langue,$langString;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;


		// affecte un ID temporaire au visiteur s'il n'en a pas encore
		// ATTENTION: ne surtout pas mettre le id_tmp en donn�e du formulaire, quelqu'un pourrait voler l'id_tmp d'une autre personne sinon !
		if(!isset($_SESSION['id_tmp'])) {
			JL::setSession('id_tmp', JL::microtime_float()*10000);
		}


		// variables
		$_data						= step1_data();
		$row						= array();
		$list						= array();
		$list_genre					= array();
		$list_naissance_jour		= array();
		$list_naissance_mois		= array();
		$list_naissance_annee		= array();
		$list_signe_astrologique_id	= array();
		$list_nb_enfants			= array();
		$list_canton_id				= array();
		$list_ville_id				= array();
		
		


		// conserve les donn�es envoy�es en session, si on vient de l'inscription rapide uniquement !
		if((int)JL::getVar('inscriptionrapide', 0) > 0 || (int)JL::getVar('parrain_id', 0) > 0) {
			if (is_array($_data)) {
				foreach($_data as $key => $value) {
					JL::setSession($key, JL::getVar($key, $value));
				}
			}
		}

		// utilisateur log et aucun message pr�sent
		if($user->id && !count($messages)) {

			// r�cup les donn�es en db
			$query = "SELECT signe_astrologique_id, genre, naissance_date, nb_enfants, canton_id, ville_id, offres, recherche_age_min, recherche_age_max, recherche_nb_enfants, parrain_id"
			." FROM user_profil"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$tmp = $db->loadObjectList($query);

			// extrait les valeurs de la date de naissance
			$naissance_date	= explode('-', $tmp['naissance_date']);
			$tmp['naissance_annee'] 	= $naissance_date[0];
			$tmp['naissance_mois'] 		= $naissance_date[1];
			$tmp['naissance_jour'] 		= $naissance_date[2];

			// conditions g�n�rales accept�es par d�faut si l'utilisateur est log ! possibilit� de reset les conditions comme �a
			$tmp['conditions']			= 1;

			// pseudo
			$tmp['username']			= $user->username;

			// email
			$tmp['email']				= $user->email;

			// r�cup les donn�es en db
			$query = "SELECT nom, prenom, telephone, adresse, code_postal, langue_appel"
			." FROM user_profil"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$userProfil = $db->loadObject($query);

			// mise en session de la valeur
			JL::setSession('nom', $userProfil->nom);
			JL::setSession('prenom', $userProfil->prenom);
			JL::setSession('telephone', $userProfil->telephone);
			JL::setSession('adresse', $userProfil->adresse);
			JL::setSession('code_postal', $userProfil->code_postal);
			JL::setSession('langue_appel', $userProfil->langue_appel);


			// mise en session des valeurs
			foreach($tmp as $key => $value) {
				JL::setSession($key, $tmp[$key]);
			}

		}


		// r�cup les donn�es temporaires en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}

		// signe astrologique
		$list_signe_astrologique_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_signe_astrologique"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_signe_astrologique_id = array_merge($list_signe_astrologique_id, $db->loadObjectList($query));
		$list['signe_astrologique_id'] = JL::makeSelectList( $list_signe_astrologique_id, 'signe_astrologique_id', 'class="select_profil"', 'value', 'text', $row['signe_astrologique_id']);

		// homme / femme
		$list_genre[] = JL::makeOption('', '> '.$lang_appprofil["Genre"]);
		$list_genre[] = JL::makeOption('f', $lang_appprofil["UneFemme"]);
		$list_genre[] = JL::makeOption('h', $lang_appprofil["UnHomme"]);
		$list['genre'] = JL::makeSelectList( $list_genre, 'genre', 'onChange="step1GenderChange(this.value);" class="genreCanton"', 'value', 'text', $row['genre']);
		// jour de naissance
		$list_naissance_jour[] = JL::makeOption('0', '> '.$lang_appprofil["JJ"]);
		for($i=1; $i<=31; $i++) {
			$list_naissance_jour[] = JL::makeOption($i, sprintf('%02d', $i));
		}
		$list['naissance_jour'] = JL::makeSelectList( $list_naissance_jour, 'naissance_jour','onChange="sunsign();"', 'value', 'text', $row['naissance_jour']);

		// mois de naissance
		$list_naissance_mois[] = JL::makeOption('0', '> '.$lang_appprofil["MM"]);
		for($i=1; $i<=12; $i++) {
			$list_naissance_mois[] = JL::makeOption($i, sprintf('%02d', $i));
		}
		$list['naissance_mois'] = JL::makeSelectList( $list_naissance_mois, 'naissance_mois','onChange="sunsign();"', 'value', 'text', $row['naissance_mois']);

		// ann�e de naissance
		$list_naissance_annee[] = JL::makeOption('0', '> '.$lang_appprofil["AAAA"]);
		for($i=(intval(date('Y'))-18); $i>=1930; $i--) {
			$list_naissance_annee[] = JL::makeOption($i, sprintf('%04d', $i));
		}
		$list['naissance_annee'] = JL::makeSelectList( $list_naissance_annee, 'naissance_annee', '', 'value', 'text', $row['naissance_annee']);


		// nombre d'enfants
		for($i=1; $i<=4; $i++) {
			$list_nb_enfants[] = JL::makeOption($i, $i);
		}
		$list_nb_enfants[] = JL::makeOption(5, '5+');
		$list['nb_enfants'] = JL::makeSelectList( $list_nb_enfants, 'nb_enfants', '', 'value', 'text', $row['nb_enfants']);

		// cantons
		$list_canton_id[] = JL::makeOption('0', '> '.$lang_appprofil["Canton"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_canton"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;
		$list_canton_id = array_merge($list_canton_id, $db->loadObjectList($query));
		$list['canton_id'] 	= JL::makeSelectList( $list_canton_id, 'canton_id', 'id="canton_id" onChange="loadVilles();" class="genreCanton"', 'value', 'text', $row['canton_id']);
		//$list['canton_id'] 	= JL::makeSelectList( $list_canton_id, 'canton_id', 'id="canton_id" onSelect="loadVilles();" class="genreCanton"', 'value', 'text', $row['canton_id']);
		//$list['ville_id']	= '<input type="hidden" id="ville_id" name="ville_id" value="'.$row['ville_id'].'" />';
		$canton= $row['canton_id'];
// ville
		$list_Ville_id[] = JL::makeOption('0', '> '.$lang_appprofil["Ville"]);
		$query = "SELECT id AS value, nom AS text"
		." FROM profil_ville"
		." WHERE canton_id = '".$canton."' and published = 1"
		." ORDER BY nom ASC"
		;
		$list_Ville_id = array_merge($list_Ville_id, $db->loadObjectList($query));
		$list['ville_id'] 	= JL::makeSelectList( $list_Ville_id, 'ville_id', 'id="ville_id"  class="genreCanton"', 'value', 'text', $row['ville_id']);
		$query = "SELECT area_code FROM user_zipcode WHERE zipcode_id='".$canton."'";
		$zipcode_id=$db->loadObject($query);

		// r�cup le message d'explication
		$query = "SELECT titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 1 LIMIT 0,1";
		$row['disclaimer']	= $db->loadObject($query);
		

		// r�cup le texte de gauche pendant l'inscription
		$notice = getNotice(1);

		// r�cup les conditions g�n�rales d'utilisation
		$query = "SELECT texte_".$_GET['lang']." as texte FROM contenu WHERE id = 5 LIMIT 0,1";
		$conditions = $db->loadResult($query);

		
		
		// parrainage
		if($row['parrain_id'] > 0) {

			// r�cup le pseudo du parrain
			$query = "SELECT username FROM user WHERE id = '".$db->escape($row['parrain_id'])."' LIMIT 0,1";
			$list['parrain'] = $db->loadResult($query);

		}

		HTML_profil::step1($row, $list, $messages, $notice, $conditions,$zipcode_id);

	}

	function step1_data() {
		global $langue;
		$_data	= array(
				'signe_astrologique_id' => 0,
				'genre' => '',
				'naissance_jour' => 0,
				'naissance_mois' => 0,
				'naissance_annee' => 0,
				'nb_enfants' => 0,
				'canton_id' => 0,
				'ville_id' => 0,
				'nom' 			=> '',
				'prenom' 		=> '',
				'telephone'	 	=> '',
				'adresse' 		=> '',
				'code_postal' 	=> '',
				'langue_appel'  => '',
				'username' => '',
				'password' => '',
				'password2' => '',
				'email' => '',
				'email2' => '',
				'conditions' => -1,
				'offres' => '0',
				'parrain_id' => 0
			);
		return $_data;
	}

	function step1submit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn�es � r�cup de l'�tape pr�c�dente + valeur par d�faut
		$_data	= step1_data();
		if(!$user->id){
		// conserve les donn�es envoy�es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
//terms and conditions
       if(JL::getSession('conditions', -1) <= 0) {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["LectureCGU"].'.</span>';
		}
			// correction de offres
			if(JL::getSession('offres', '') == 'on') {
				JL::setSession('offres', '1');
			} else {
				JL::setSession('offres', '0');
			}

		}


		// v�rif les donn�es
		if(JL::getSession('genre', '') == '') {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezVotreGenre"].'.</span>';
		}

		if(!JL::getSessionInt('naissance_jour', 0) || !JL::getSessionInt('naissance_mois', 0) || !JL::getSessionInt('naissance_annee', 0)) {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezVotreDateNaissance"].'.</span>';
		} elseif(mktime(0, 0, 0, JL::getSessionInt('naissance_mois', 0), JL::getSessionInt('naissance_jour', 0), JL::getSessionInt('naissance_annee', 0)+18) > time()) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VousDevezEtreMajeur"].'.</span>';
		}
		
		if(!JL::getSessionInt('canton_id', 0)) {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezVotreCanton"].'.</span>';
		}
		
		
		

		// pr�nom non renseign�
		if(strlen(JL::getSession('prenom', '', false)) == '') {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezPrenom"].'.</span>';
		}
		//zipcodevalidation 
		$canton=$_REQUEST['canton_id'];
		$codepost=$_REQUEST['code_postal'];
		$zipquery="Select zipcode_id from user_zipcode where postal_code=$codepost";
		echo $zipquery;
	   $zipresult = $db->loadResult($zipquery);	
	   print_R($zipresult);die;
 if($zipresult!=$canton){
 				$messages[]	= '<span class="error">'.var_dump(zipresult).$lang_appprofil["zipcodevalidation"].'.</span>';

 }
 	
		
//already exit validation telephone
		$telephoneval=$_REQUEST['telephone'];
		$telelength=strlen($telephoneval);
		if($telephoneval!='+41-' || $telephoneval!='+41'){
		$telquery="select telephone from user_profil where telephone='$telephoneval' and user_active=1";
		$telresult = $db->loadResult($telquery);
		if(($telresult!='') && ($telelength>5))
		{
		$messages[]	= '<span class="error">'.$lang_appprofil["telephonealreadyexist"].'.</span>';
		}
		}
		if($telelength==6 || $telephoneval=='+41-' || $telephoneval==''||$telephoneval=='+41') {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezNumTel"].'.</span>';
		}
		// nom non renseign�
		if(strlen(JL::getSession('nom', '', false)) == '') {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezNom"].'.</span>';
		}

		// adresse non renseign�
		if(strlen(JL::getSession('adresse', '', false)) == '') {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezAdresse"].'.</span>';
		}

		// code postal non renseign�
		if(strlen(JL::getSession('code_postal', '', false)) == '') {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezCodePostal"].'.</span>';
		}
		
		// langue_appel non renseign�e
		if(strlen(JL::getSession('langue_appel', '', false)) == '') {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezLangueAppel"].'.</span>';
		}
		if(strlen(JL::getSession('username', '')) < 4 || strlen(JL::getSession('username', '')) > 13) {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["PseudoInvalideNbCaracteres"].'.</span>';
		}

		if(!preg_match('/^[a-zA-Z0-9._-]+$/', JL::getSession('username', ''))) {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["PseudoInvalideCaracteresSpeciaux"].'.</span>';
		}

		// user log et change de mdp, ou user non log
		if(($user->id && JL::getSession('password', '') || !$user->id) && !preg_match('/^[a-zA-Z0-9._-]+$/', JL::getSession('password', ''))) {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["MdpInvalideCaracteresSpeciaux"].'.</span>';
		}

		// user log et change de mdp, ou user non log
		if((JL::getSession('password', '') || JL::getSession('password2', '')) && JL::getSession('password', '') != JL::getSession('password2', '')) {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["ConfirmationMdpInvalide"].'.</span>';
		}

		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', JL::getSession('email', ''))) {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["EmailInvalide"].'.</span>';
		}

		if(JL::getSession('email', '') != JL::getSession('email2', '')) {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["ConfirmationEmailInvalide"].'.</span>';
		}
		// v�rification du captcha
		if(!$user->id && intval(JL::getVar('codesecurite', -1)) != JL::getSession('captcha', 0)) {
		if(JL::getSession('conditions', -1) > 0) {
				JL::setSession('conditions', '');
			} else {
				JL::setSession('conditions', -1);
			}
			$messages[]	= '<span class="error">'.$lang_appprofil["CodeSecuriteIncorrect"].'.</span>';
		}
		}
		else{
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
//terms and conditions
      
			// correction de offres
			if(JL::getSession('offres', '') == 'on') {
				JL::setSession('offres', '1');
			} else {
				JL::setSession('offres', '0');
			}

		}


		// v�rif les donn�es
		if(JL::getSession('genre', '') == '') {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezVotreGenre"].'.</span>';
		}

		if(!JL::getSessionInt('naissance_jour', 0) || !JL::getSessionInt('naissance_mois', 0) || !JL::getSessionInt('naissance_annee', 0)) {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezVotreDateNaissance"].'.</span>';
		} elseif(mktime(0, 0, 0, JL::getSessionInt('naissance_mois', 0), JL::getSessionInt('naissance_jour', 0), JL::getSessionInt('naissance_annee', 0)+18) > time()) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VousDevezEtreMajeur"].'.</span>';
		}
		
		if(!JL::getSessionInt('canton_id', 0)) {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezVotreCanton"].'.</span>';
		}
		
		
		

		// pr�nom non renseign�
		if(strlen(JL::getSession('prenom', '', false)) == '') {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezPrenom"].'.</span>';
		}
		//zipcodevalidation 
		$canton=$_REQUEST['canton_id'];
		$codepost=$_REQUEST['code_postal'];
		$zipquery="Select zipcode_id from user_zipcode where postal_code=$codepost";
	   $zipresult = $db->loadResult($zipquery);
 if($zipresult!=$canton){
 				$messages[]	= '<span class="error">'.$lang_appprofil["zipcodevalidation"].'.</span>';

 }                                                                                                                                                                                                                                                                  
		// nom non renseign�
		if(strlen(JL::getSession('nom', '', false)) == '') {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezNom"].'.</span>';
		}
//telephone
$telephoneval=$_REQUEST['telephone'];
		$telelength=strlen($telephoneval);
if($telelength==6 || $telephoneval=='+41-' || $telephoneval==''||$telephoneval=='+41') {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezNumTel"].'.</span>';
		}
		// adresse non renseign�
		if(strlen(JL::getSession('adresse', '', false)) == '') {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezAdresse"].'.</span>';
		}

		// code postal non renseign�
		if(strlen(JL::getSession('code_postal', '', false)) == '') {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezCodePostal"].'.</span>';
		}
		
		// langue_appel non renseign�e
		if(strlen(JL::getSession('langue_appel', '', false)) == '') {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezLangueAppel"].'.</span>';
		}
		if(strlen(JL::getSession('username', '')) < 4 || strlen(JL::getSession('username', '')) > 13) {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["PseudoInvalideNbCaracteres"].'.</span>';
		}

		if(!preg_match('/^[a-zA-Z0-9._-]+$/', JL::getSession('username', ''))) {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["PseudoInvalideCaracteresSpeciaux"].'.</span>';
		}

		// user log et change de mdp, ou user non log
		if(($user->id && JL::getSession('password', '') || !$user->id) && !preg_match('/^[a-zA-Z0-9._-]+$/', JL::getSession('password', ''))) {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["MdpInvalideCaracteresSpeciaux"].'.</span>';
		}

		// user log et change de mdp, ou user non log
		if((JL::getSession('password', '') || JL::getSession('password2', '')) && JL::getSession('password', '') != JL::getSession('password2', '')) {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["ConfirmationMdpInvalide"].'.</span>';
		}

		if(!preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9.-]{2,}[.][A-Za-z]{2,3}$/', JL::getSession('email', ''))) {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["EmailInvalide"].'.</span>';
		}

		if(JL::getSession('email', '') != JL::getSession('email2', '')) {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["ConfirmationEmailInvalide"].'.</span>';
		}
		// v�rification du captcha
		if(!$user->id && intval(JL::getVar('codesecurite', -1)) != JL::getSession('captcha', 0)) {
		
			$messages[]	= '<span class="error">'.$lang_appprofil["CodeSecuriteIncorrect"].'.</span>';
		}
		}

		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// enregistre les modifs en DB (certains champs ne sont pas mis � jour volontairement ==> s�curit� oblige !)
				$query = "UPDATE user_profil SET"
				." signe_astrologique_id = '".JL::getSessionInt('signe_astrologique_id', 0)."',"
				." offres = '".JL::getSession('offres', '0', true)."',"
				." naissance_date = '".JL::getSessionInt('naissance_annee', 0)."-".JL::getSessionInt('naissance_mois', 0)."-".JL::getSessionInt('naissance_jour', 0)."',"
				." nb_enfants = '".JL::getSessionInt('nb_enfants', 1)."',"
				." canton_id = '".JL::getSessionInt('canton_id', 0)."',"
				." ville_id = '".JL::getSessionInt('ville_id', 0)."',"
				." parrain_id = '".JL::getSessionInt('parrain_id', 0)."',"
				." nom = '".JL::getSession('nom', '', true)."',"
				." prenom = '".JL::getSession('prenom', '', true)."',"
				." telephone = '".JL::getSession('telephone', '', true)."',"
				." adresse = '".JL::getSession('adresse', '', true)."',"
				." code_postal = '".JL::getSession('code_postal', '', true)."',"
				." langue_appel = '".JL::getSession('langue_appel', '', true)."'"
				." WHERE user_id = '".$user->id."'"
				;
				$db->query($query);


				// changement de mdp
				if(JL::getSession('password', '')) {
					$query = "UPDATE user SET password = MD5('".JL::getSession('password', '', true)."') WHERE id = '".$user->id."'";
					$db->query($query);
				}

				// � laisser que l'user soit log ou pas, m�me si on affiche pas le message (utile dans le swtich case sur $action
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

			} else { // user non log

				// check que le pseudo n'est pas d�j� pris
				$query = "SELECT id FROM user WHERE username LIKE '".JL::getSession('username', '', true)."' LIMIT 0,1";
				$pseudoExistantUser = $db->loadResult($query);
				
				$query = "SELECT id FROM user_suppr WHERE username LIKE '".JL::getSession('username', '', true)."' LIMIT 0,1";
				$pseudoSupprUser = $db->loadResult($query);

				// check que le pseudo n'est pas d�j� r�serv� par un autre utilisateur (en cours d'inscription), max 1 heure de r�servation
				$query = "SELECT username FROM user_inscription WHERE username LIKE '".JL::getSession('username', '', true)."' AND id_tmp NOT LIKE '".JL::getSession('id_tmp', '')."' AND (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(reservation_date)) < 3600 LIMIT 0,1";
				$pseudoExistantTmp = $db->loadResult($query);

				// pseudo d�j� prisif($pseudoExistantUser || $pseudoExistantTmp || $pseudoSupprUser) {
				if($pseudoExistantUser || $pseudoExistantTmp) {
					$messages[]	= '<span class="error">'.$lang_appprofil["PseudoDejaEnregistre"].'.</span>';
				}

				// check que l'email n'est pas d�j� prise
				$query = "SELECT id FROM user WHERE email LIKE '".JL::getSession('email', '', true)."' LIMIT 0,1";
				$emailExistantUser = $db->loadResult($query);

				// check que l'email n'est pas d�j� r�serv� par un autre utilisateur (en cours d'inscription), max 1 heure de r�servation
				$query = "SELECT email FROM user_inscription WHERE email LIKE '".JL::getSession('email', '', true)."' AND id_tmp NOT LIKE '".JL::getSession('id_tmp', '')."' AND (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(reservation_date)) < 3600 LIMIT 0,1";
				$emailExistantTmp = $db->loadResult($query);

				// pseudo d�j� pris
				if($emailExistantUser || $emailExistantTmp) {
					$messages[]	= '<span class="error">'.$lang_appprofil["EmailDejaEnregistre"].'.</span>';
				}

				// si l'email et le pseudo sont dispo
				if(!$pseudoExistantUser && !$pseudoExistantTmp && !$emailExistantUser && !$emailExistantTmp) {

					// efface la pr�c�dente r�servation de l'utilisateur au cas o�
					$query = "DELETE FROM user_inscription WHERE username LIKE '".JL::getSession('username','',true)."' OR email LIKE '".JL::getSession('email','',true)."'";
					$db->query($query);


					// r�serve le pseudo et l'email
					$query = "INSERT INTO user_inscription SET "
					." username = '".JL::getSession('username', '', true)."',"
					." email = '".JL::getSession('email', '', true)."',"
					." id_tmp = '".JL::getSession('id_tmp', '')."',"
					." reservation_date = NOW()"
					;
					$db->query($query);

				}


				// valide l'�tape
				if(!isset($_SESSION['step_ok'])) {
					$_SESSION['step_ok']	= 1;
				}

			}

		}

		// retourne la liste des messages d'erreur
		return $messages;

	}


	function step2($messages = array()) {
		global $langue, $langString;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// cr�e le dossier d'upload temporaire
		JL::makeUploadDir();


		// donn�es de l'�tape + valeurs par d�faut
		$_data					= step2_data();
		$row					= array();
		$list					= array();


		// utilisateur log
		if($user->id) {

			// r�cup les donn�es en db
			$query = "SELECT photo_defaut, photo_home"
			." FROM user_profil"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$obj = $db->loadObject($query);

			// mise en session des valeurs
			JL::setSession('photo_defaut', $obj->photo_defaut);
			JL::setSession('photo_home', $obj->photo_home);

		}


		// r�cup les champs correspondant en session, sinon valeur par d�faut
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}


		// r�cup le texte de gauche pendant l'inscription
		$notice = getNotice(2);
		
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 101";
		$data = $db->loadObject($query);
		HTML_profil::step2($data, $row, $list, $messages, $notice);

	}

	function step2_data() {
		global $langue;
		$_data	= array(
			'photo_defaut' => 1,
			'photo_home' => 1
		);
		return $_data;
	}

	function step2submit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn�es � r�cup de l'�tape pr�c�dente + valeur par d�faut
		$_data	= step2_data();

		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// sauvegarde les photos
				photosSave('profil');


				// enregistre les modifs en DB
				$query = "UPDATE user_profil SET"
				." photo_home = '".JL::getSessionInt('photo_home', 1)."'"
				." WHERE user_id = '".$user->id."'"
				;
				$db->query($query);


				// � laisser que l'user soit log ou pas, m�me si on affiche pas le message (utile dans le swtich case sur $action
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].'!</span>';

			} else { // user non log

				// valide l'�tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 2) {
					$_SESSION['step_ok']	= 2;
				}

			}

		}

		// retourne la liste des messages d'erreur
		return $messages;

	}


	function step3($messages = array()) {
		global $langue;
		global $db, $user;

		// donn�es de l'�tape + valeurs par d�faut
		$_data						= step3_data();
		$row						= array();
		$list						= array();


		// utilisateur log et aucun message pr�sent
		if($user->id && !count($messages)) {

			// r�cup les donn�es en db
			$query = "SELECT annonce, published"
			." FROM user_annonce"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$annonce = $db->loadObject($query);

			// mise en session de la valeur
			JL::setSession('annonce', $annonce->annonce);
			JL::setSession('published', $annonce->published);

		}


		// r�cup les champs correspondant en session, sinon valeur par d�faut
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}

		// r�cup le texte de gauche pendant l'inscription
		$notice = getNotice(3);
		
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 22";
		$data = $db->loadObject($query);

		HTML_profil::step3($data, $row, $list, $messages, $notice);

	}

	function step3_data() {
		global $langue;
		$_data	= array(
				'annonce' => '',
				'published' => 2
			);
		return $_data;
	}

	function step3submit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn�es � r�cup de l'�tape pr�c�dente + valeur par d�faut
		$_data	= step3_data();

		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}


		// si l'annonce (sans retours � la ligne) d�passe les 2000 caract�res
		if(strlen(str_replace("\n",'',JL::getSession('annonce', '', false))) > 2000) {

			// on tronque
			JL::setSession('annonce', substr(0, 2000, JL::getSession('annonce', '', false)));

		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// r�cup l'annonce existante
				$query = "SELECT annonce FROM user_annonce WHERE user_id = '".$user->id."' LIMIT 0,1";
				$annonce = $db->loadResult($query);

				// si l'annonce r�dig�e est diff�rente de l'ancienne
				if(strcmp($annonce, JL::getSession('annonce', ''))) {

					// enregistre les modifs en DB (certains champs ne sont pas mis � jour volontairement ==> s�curit� oblige !)
					$query = "UPDATE user_annonce SET"
					." annonce = '".JL::getSession('annonce', '', true)."',"
					." published = 2"
					." WHERE user_id = '".$user->id."'"
					;
					$db->query($query);
					
					// enregistre un backup des annonces
					$query_backup = "INSERT INTO user_annonce_backup SET"
					." user_id = '".$user->id."',"
					." annonce = '".JL::getSession('annonce', '', true)."',"
					." datetime = NOW()"
					;
					$db->query($query_backup);

					// � laisser que l'user soit log ou pas, m�me si on affiche pas le message (utile dans le swtich case sur $action
					$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

				} else {

					// � laisser que l'user soit log ou pas, m�me si on affiche pas le message (utile dans le swtich case sur $action
					$messages[]	= '<span class="warning">'.$lang_appprofil["AucuneModificationEnregistrees"].' !</span>';

				}


			} else { // user non log

				// valide l'�tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 3) {
					$_SESSION['step_ok']	= 3;
				}

			}

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}


	function step4($messages = array()) {
		global $langue,$langString;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// donn�es de l'�tape + valeurs par d�faut
		$_data						= step4_data();
		$row						= array();
		$list						= array();
		$list_taille_id				= array();
		$list_poids_id				= array();
		$list_silhouette_id			= array();
		$list_style_coiffure_id		= array();
		$list_cheveux_id			= array();
		$list_yeux_id				= array();
		$list_origine_id			= array();

		$list_nationalite_id 		= array();
		$list_religion_id 			= array();
		$list_langue_id 			= array();
		
		$list_statut_marital_id 	= array();
		$list_me_marier_id 			= array();
		$list_cherche_relation_id 	= array();
		$list_niveau_etude_id 		= array();
		$list_secteur_activite_id 	= array();
		$list_fumer_id 				= array();
		$list_temperament_id 		= array();
		$list_vouloir_enfants_id 	= array();
		$list_garde_id 				= array();

		$list_vie_id 				= array();
		$list_cuisine_id 			= array();
		$list_sortie_id 			= array();
		$list_loisir_id 			= array();
		$list_sport_id 				= array();
		$list_musique_id 			= array();
		$list_film_id 				= array();
		$list_lecture_id 			= array();
		$list_animaux_id 			= array();
		
		// utilisateur log et aucun message pr�sent
		if($user->id && !count($messages)) {

			// r�cup les donn�es en db
			$query = "SELECT taille_id, poids_id, silhouette_id, style_coiffure_id, cheveux_id, yeux_id, origine_id, nationalite_id, religion_id, langue1_id, langue2_id, langue3_id, statut_marital_id, me_marier_id, cherche_relation_id, niveau_etude_id, secteur_activite_id, fumer_id, temperament_id, vouloir_enfants_id, garde_id,vie_id, cuisine1_id, cuisine2_id, cuisine3_id, sortie1_id, sortie2_id, sortie3_id, loisir1_id, loisir2_id, loisir3_id, sport1_id, sport2_id, sport3_id, musique1_id, musique2_id, musique3_id, film1_id, film2_id, film3_id, lecture1_id, lecture2_id, lecture3_id, animaux1_id, animaux2_id, animaux3_id"
			." FROM user_profil"
			." WHERE user_id = '".$user->id."'"
			." LIMIT 0,1"
			;
			$tmp = $db->loadObjectList($query);

			// mise en session des valeurs
			foreach($tmp as $key => $value) {
				JL::setSession($key, $tmp[$key]);
			}
		}

		// r�cup les champs correspondant en session, sinon valeur par d�faut
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				//exceptions checkboxs
				if($key=='langue' || $key=='cuisine' || $key=='sortie' || $key=='loisir' || $key=='sport' || $key=='musique' || $key=='film' || $key=='lecture' || $key=='animaux'){
					for($i=1;$i<=3;$i++){
						$row[$key.$i.'_id']	= JL::getSession($key.$i.'_id', $value);
					}
				}else{
					$row[$key]	= JL::getSession($key, $value);
				}
			}
		}

		// taille
		$list_taille_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		for($i=140; $i<=200; $i++) {
			$list_taille_id[] = JL::makeOption($i, $i.'cm');
		}

		$list['taille_id'] = JL::makeSelectList( $list_taille_id, 'taille_id', 'class="select_profil"', 'value', 'text', $row['taille_id']);

		// poids
		$list_poids_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		for($i=40; $i<=120; $i++) {
			$list_poids_id[] = JL::makeOption($i, $i.'kg');
		}

		$list['poids_id'] = JL::makeSelectList( $list_poids_id, 'poids_id', 'class="select_profil"', 'value', 'text', $row['poids_id']);

		// silhouette
		$list_silhouette_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_silhouette"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_silhouette_id = array_merge($list_silhouette_id, $db->loadObjectList($query));
		$list['silhouette_id'] = JL::makeSelectList( $list_silhouette_id, 'silhouette_id', 'class="select_profil"', 'value', 'text', $row['silhouette_id']);

		// style coiffure
		$list_style_coiffure_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_style_coiffure"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_style_coiffure_id = array_merge($list_style_coiffure_id, $db->loadObjectList($query));
		$list['style_coiffure_id'] = JL::makeSelectList( $list_style_coiffure_id, 'style_coiffure_id', 'class="select_profil"', 'value', 'text', $row['style_coiffure_id']);

		// cheveux
		$list_cheveux_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_cheveux"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_cheveux_id = array_merge($list_cheveux_id, $db->loadObjectList($query));
		$list['cheveux_id'] = JL::makeSelectList( $list_cheveux_id, 'cheveux_id', 'class="select_profil"', 'value', 'text', $row['cheveux_id']);

		// yeux
		$list_yeux_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_yeux"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_yeux_id = array_merge($list_yeux_id, $db->loadObjectList($query));
		$list['yeux_id'] = JL::makeSelectList( $list_yeux_id, 'yeux_id', 'class="select_profil"', 'value', 'text', $row['yeux_id']);

		// origine
		$list_origine_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_origine"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_origine_id = array_merge($list_origine_id, $db->loadObjectList($query));
		$list['origine_id'] = JL::makeSelectList( $list_origine_id, 'origine_id', 'class="select_profil"', 'value', 'text', $row['origine_id']);

		
		// nationalit�
		$list_nationalite_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_nationalite"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_nationalite_id = array_merge($list_nationalite_id, $db->loadObjectList($query));
		$list['nationalite_id'] = JL::makeSelectList( $list_nationalite_id, 'nationalite_id', 'class="select_profil"', 'value', 'text', $row['nationalite_id']);

		// religion
		$list_religion_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_religion"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_religion_id = array_merge($list_religion_id, $db->loadObjectList($query));
		$list['religion_id'] = JL::makeSelectList( $list_religion_id, 'religion_id', 'class="select_profil"', 'value', 'text', $row['religion_id']);

		// langues
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_langue"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;
$dblangu=$db->loadObjectList($query);
		$list['langue_id'] = JL::makeCheckboxList($dblangu, 'langue[]', '', 'value', 'text', $row['langue1_id'], $row['langue2_id'], $row['langue3_id'], $_GET['lang']);  

		// statut marital
		$list_statut_marital_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_statut_marital"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_statut_marital_id = array_merge($list_statut_marital_id, $db->loadObjectList($query));
		$list['statut_marital_id'] = JL::makeSelectList( $list_statut_marital_id, 'statut_marital_id', 'class="select_profil"', 'value', 'text', $row['statut_marital_id']);

		// me marier c'est...
		$list_me_marier_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_me_marier"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_me_marier_id = array_merge($list_me_marier_id, $db->loadObjectList($query));
		$list['me_marier_id'] = JL::makeSelectList( $list_me_marier_id, 'me_marier_id', 'class="select_profil"', 'value', 'text', $row['me_marier_id']);

		// je cherche une relation
		$list_cherche_relation_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_cherche_relation"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_cherche_relation_id = array_merge($list_cherche_relation_id, $db->loadObjectList($query));
		$list['cherche_relation_id'] = JL::makeSelectList( $list_cherche_relation_id, 'cherche_relation_id', 'class="select_profil"', 'value', 'text', $row['cherche_relation_id']);

		// niveau d'�tudes
		$list_niveau_etude_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_niveau_etude"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_niveau_etude_id = array_merge($list_niveau_etude_id, $db->loadObjectList($query));
		$list['niveau_etude_id'] = JL::makeSelectList( $list_niveau_etude_id, 'niveau_etude_id', 'class="select_profil"', 'value', 'text', $row['niveau_etude_id']);

		// secteur d'activit�
		$list_secteur_activite_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_secteur_activite"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_secteur_activite_id = array_merge($list_secteur_activite_id, $db->loadObjectList($query));
		$list['secteur_activite_id'] = JL::makeSelectList( $list_secteur_activite_id, 'secteur_activite_id', 'class="select_profil"', 'value', 'text', $row['secteur_activite_id']);

		// je fume
		$list_fumer_id[] = JL::makeOption('0',  '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_fumer"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_fumer_id = array_merge($list_fumer_id, $db->loadObjectList($query));
		$list['fumer_id'] = JL::makeSelectList( $list_fumer_id, 'fumer_id', 'class="select_profil"', 'value', 'text', $row['fumer_id']);

		// temp�rament
		$list_temperament_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_temperament"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_temperament_id = array_merge($list_temperament_id, $db->loadObjectList($query));
		$list['temperament_id'] = JL::makeSelectList( $list_temperament_id, 'temperament_id', 'class="select_profil"', 'value', 'text', $row['temperament_id']);

		// veux des enfants
		$list_vouloir_enfants_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_vouloir_enfants"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_vouloir_enfants_id = array_merge($list_vouloir_enfants_id, $db->loadObjectList($query));
		$list['vouloir_enfants_id'] = JL::makeSelectList( $list_vouloir_enfants_id, 'vouloir_enfants_id', 'class="select_profil"', 'value', 'text', $row['vouloir_enfants_id']);

		// qui a la garde ?
		$list_garde_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_garde"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_garde_id = array_merge($list_garde_id, $db->loadObjectList($query));
		$list['garde_id'] = JL::makeSelectList( $list_garde_id, 'garde_id', 'class="select_profil"', 'value', 'text', $row['garde_id']);

		// style de vie
		$list_vie_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_vie"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;

		$list_vie_id = array_merge($list_vie_id, $db->loadObjectList($query));
		$list['vie_id'] = JL::makeSelectList( $list_vie_id, 'vie_id', 'class="select_profil"', 'value', 'text', $row['vie_id']);


		// cuisine
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_cuisine"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;
$dbcuisine=$db->loadObjectList($query);
		$list['cuisine_id'] = JL::makeCheckboxList($dbcuisine, 'cuisine[]', '', 'value', 'text', $row['cuisine1_id'], $row['cuisine2_id'], $row['cuisine3_id'], $_GET['lang']);  


		// sortie
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_sortie"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;
$dbsortie=$db->loadObjectList($query);

		$list['sortie_id'] = JL::makeCheckboxList($dbsortie, 'sortie[]', '', 'value', 'text', $row['sortie1_id'], $row['sortie2_id'], $row['sortie3_id'], $_GET['lang']);  


		// loisir
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_loisir"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;
$dbloisir=$db->loadObjectList($query);

		$list['loisir_id'] = JL::makeCheckboxList($dbloisir, 'loisir[]', '', 'value', 'text', $row['loisir1_id'], $row['loisir2_id'], $row['loisir3_id'], $_GET['lang']);  


		// sport
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_sport"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;
$dbsport=$db->loadObjectList($query);

		$list['sport_id'] = JL::makeCheckboxList($dbsport, 'sport[]', '', 'value', 'text', $row['sport1_id'], $row['sport2_id'], $row['sport3_id'], $_GET['lang']);  


		// musique
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_musique"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;
$dbmusique=$db->loadObjectList($query);

		$list['musique_id'] = JL::makeCheckboxList($dbmusique, 'musique[]', '', 'value', 'text', $row['musique1_id'], $row['musique2_id'], $row['musique3_id'], $_GET['lang']);  


		// film
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_film"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;
$dbfilm=$db->loadObjectList($query);

		$list['film_id'] = JL::makeCheckboxList($dbfilm, 'film[]', '', 'value', 'text', $row['film1_id'], $row['film2_id'], $row['film3_id'], $_GET['lang']);  


		// lecture
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_lecture"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;
$dblecture=$db->loadObjectList($query);

		$list['lecture_id'] = JL::makeCheckboxList($dblecture, 'lecture[]', '', 'value', 'text', $row['lecture1_id'], $row['lecture2_id'], $row['lecture3_id'], $_GET['lang']);  


		// animaux
		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_animaux"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;
$dbanimaux=$db->loadObjectList($query);

		$list['animaux_id'] = JL::makeCheckboxList($dbanimaux, 'animaux[]', '', 'value', 'text', $row['animaux1_id'], $row['animaux2_id'], $row['animaux3_id'], $_GET['lang']);  

		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 125";
		$data = $db->loadObject($query);

		// r�cup le texte de gauche pendant l'inscription
		$notice = getNotice(4);

		HTML_profil::step4($data, $row, $list, $messages, $notice);

	}

	function step4_data() {
		global $langue;
		$_data	= array(
			'taille_id' => 0,
			'poids_id' => 0,
			'silhouette_id' => 0,
			'style_coiffure_id' => 0,
			'cheveux_id' => 0,
			'yeux_id' => 0,
			'origine_id' => 0,
			'nationalite_id' => 0,
			'religion_id' => 0,
			'statut_marital_id' => 0,
			'me_marier_id' => 0,
			'cherche_relation_id' => 0,
			'niveau_etude_id' => 0,
			'secteur_activite_id' => 0,
			'fumer_id' => 0,
			'temperament_id' => 0,
			'langue' => 0,
			'vouloir_enfants_id' => 0,
			'garde_id' => 0,
			'vie_id' => 0,			// profil_vie
			'cuisine' => 0,		// profil_cuisine
			'sortie' => 0,		// profil_sortie
			'loisir' => 0,		// profil_loisir
			'sport' => 0,		// profil_sport
			'musique' => 0,		// profil_musique
			'film' => 0,		// profil_film
			'lecture' => 0,		// profil_lecture
			'animaux' => 0,		// profil_animaux
		);
		return $_data;
	}

	function step4submit() {
		include("lang/app_profil.".$_GET['lang'].".php");
		global $langue;
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();

		

		// donn�es � r�cup de l'�tape pr�c�dente + valeur par d�faut
		$_data	= step4_data();
		
		if (is_array($_data)) {
			foreach($_data as $key => $value) {				
				//exceptions checkboxs
				if($key=='langue' || $key=='cuisine' || $key=='sortie' || $key=='loisir' || $key=='sport' || $key=='musique' || $key=='film' || $key=='lecture' || $key=='animaux'){
					$i=1;
					foreach(JL::getVar($key,array()) as $k){
						 JL::setSession($key.$i.'_id', $k);
						$i++;
					}
					//met � z�ro les cases vides en cas d'annulation de s�lection
					for($i;$i<=3;$i++){
						JL::setSession($key.$i.'_id', $value);
					}
					
				}else{
					JL::setSession($key, JL::getVar($key, $value));
				}
			}
		}

		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// enregistre les modifs en DB (certains champs ne sont pas mis � jour volontairement ==> s�curit� oblige !)
				$query = "UPDATE user_profil SET"
				." taille_id = '".JL::getSessionInt('taille_id', 0)."',"
				." poids_id = '".JL::getSessionInt('poids_id', 0)."',"
				." silhouette_id = '".JL::getSessionInt('silhouette_id', 0)."',"
				." style_coiffure_id = '".JL::getSessionInt('style_coiffure_id', 0)."',"
				." cheveux_id = '".JL::getSessionInt('cheveux_id', 0)."',"
				." yeux_id = '".JL::getSessionInt('yeux_id', 0)."',"
				." origine_id = '".JL::getSessionInt('origine_id', 0)."',"
				." nationalite_id = '".JL::getSessionInt('nationalite_id', 0)."',"
				." religion_id = '".JL::getSessionInt('religion_id', 0)."',"
				." langue1_id = '".JL::getSessionInt('langue1_id', 0)."',"
				." langue2_id = '".JL::getSessionInt('langue2_id', 0)."',"
				." langue3_id = '".JL::getSessionInt('langue3_id', 0)."',"
				." statut_marital_id = '".JL::getSessionInt('statut_marital_id', 0)."',"
				." me_marier_id = '".JL::getSessionInt('me_marier_id', 0)."',"
				." cherche_relation_id = '".JL::getSessionInt('cherche_relation_id', 0)."',"
				." niveau_etude_id = '".JL::getSessionInt('niveau_etude_id', 0)."',"
				." secteur_activite_id = '".JL::getSessionInt('secteur_activite_id', 0)."',"
				." fumer_id = '".JL::getSessionInt('fumer_id', 0)."',"
				." temperament_id = '".JL::getSessionInt('temperament_id', 0)."',"
				." vouloir_enfants_id = '".JL::getSessionInt('vouloir_enfants_id', 0)."',"
				." garde_id = '".JL::getSessionInt('garde_id', 0)."',"
				." vie_id = '".JL::getSessionInt('vie_id', 0)."',"
				." cuisine1_id = '".JL::getSessionInt('cuisine1_id', 0)."',"
				." cuisine2_id = '".JL::getSessionInt('cuisine2_id', 0)."',"
				." cuisine3_id = '".JL::getSessionInt('cuisine3_id', 0)."',"
				." sortie1_id = '".JL::getSessionInt('sortie1_id', 0)."',"
				." sortie2_id = '".JL::getSessionInt('sortie2_id', 0)."',"
				." sortie3_id = '".JL::getSessionInt('sortie3_id', 0)."',"
				." loisir1_id = '".JL::getSessionInt('loisir1_id', 0)."',"
				." loisir2_id = '".JL::getSessionInt('loisir2_id', 0)."',"
				." loisir3_id = '".JL::getSessionInt('loisir3_id', 0)."',"
				." sport1_id = '".JL::getSessionInt('sport1_id', 0)."',"
				." sport2_id = '".JL::getSessionInt('sport2_id', 0)."',"
				." sport3_id = '".JL::getSessionInt('sport3_id', 0)."',"
				." musique1_id = '".JL::getSessionInt('musique1_id', 0)."',"
				." musique2_id = '".JL::getSessionInt('musique2_id', 0)."',"
				." musique3_id = '".JL::getSessionInt('musique3_id', 0)."',"
				." film1_id = '".JL::getSessionInt('film1_id', 0)."',"
				." film2_id = '".JL::getSessionInt('film2_id', 0)."',"
				." film3_id = '".JL::getSessionInt('film3_id', 0)."',"
				." lecture1_id = '".JL::getSessionInt('lecture1_id', 0)."',"
				." lecture2_id = '".JL::getSessionInt('lecture2_id', 0)."',"
				." lecture3_id = '".JL::getSessionInt('lecture3_id', 0)."',"
				." animaux1_id = '".JL::getSessionInt('animaux1_id', 0)."',"
				." animaux2_id = '".JL::getSessionInt('animaux2_id', 0)."',"
				." animaux3_id = '".JL::getSessionInt('animaux3_id', 0)."'"
				." WHERE user_id = '".$user->id."'"
				;
				$db->query($query);

				// � laisser que l'user soit log ou pas, m�me si on affiche pas le message (utile dans le swtich case sur $action
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

			} else { // user non log

				// valide l'�tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 4) {
					$_SESSION['step_ok']	= 4;
				}

			}

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}


	


	function step5($messages = array()) {
		global $langue,$langString;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user, $action;


		// cr�e le dossier d'uplaod temporaire
		JL::makeUploadDir();



		// donn�es de l'�tape + valeurs par d�faut
		$_data						= step5_data();
		$row						= array();
		$list						= array();
		$list_genre					= array();
		$list_naissance_jour		= array();
		$list_naissance_mois		= array();
		$list_naissance_annee		= array();
		$list_signe_astrologique_id	= array();


		// utilisateur log et aucun message pr�sent
		if($user->id && !count($messages)) {

			// r�cup les donn�es en db
			$query = "SELECT num, naissance_date, signe_astrologique_id, genre"
			." FROM user_enfant"
			." WHERE user_id = '".$user->id."'"
			." ORDER BY num ASC"
			." LIMIT 0,6"
			;
			$tmps = $db->loadObjectList($query);

			// mise en session des valeurs
			if (is_array($tmps)) {
				foreach($tmps as $tmp) {

					// extrait les valeurs de la date de naissance
					$naissance_date	= explode('-', $tmp->naissance_date);
					$tmp->naissance_annee 	= $naissance_date[0];
					$tmp->naissance_mois 	= $naissance_date[1];
					$tmp->naissance_jour 	= $naissance_date[2];

					JL::setSession('child'.$tmp->num, 1);
					JL::setSession('naissance_jour'.$tmp->num, $tmp->naissance_jour);
					JL::setSession('naissance_mois'.$tmp->num, $tmp->naissance_mois);
					JL::setSession('naissance_annee'.$tmp->num, $tmp->naissance_annee);
					JL::setSession('genre'.$tmp->num, $tmp->genre);
					JL::setSession('signe_astrologique'.$tmp->num.'_id', $tmp->signe_astrologique_id);

				}
			}

			// r�cup la valeur de photo_montrer
			$query = "SELECT photo_montrer FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
			$photo_montrer = $db->loadResult($query);
			JL::setSession('photo_montrer', $photo_montrer);

		}


		// r�cup les champs correspondant en session, sinon valeur par d�faut
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row[$key]	= JL::getSession($key, $value);
			}
		}


		// gar�on / fille
		$list_genre[] = JL::makeOption('', '> '.$lang_appprofil["Genre"]);
		$list_genre[] = JL::makeOption('f', $lang_appprofil["UneFille"]);
		$list_genre[] = JL::makeOption('g', $lang_appprofil["UnGarcon"]);


		// jour de naissance
		$list_naissance_jour[] = JL::makeOption('0', '> '.$lang_appprofil["JJ"]);
		for($i=1; $i<=31; $i++) {
			$list_naissance_jour[] = JL::makeOption($i, sprintf('%02d', $i));
		}


		// mois de naissance
		$list_naissance_mois[] = JL::makeOption('0', '> '.$lang_appprofil["MM"]);
		for($i=1; $i<=12; $i++) {
			$list_naissance_mois[] = JL::makeOption($i, sprintf('%02d', $i));
		}


		// ann�e de naissance
		$list_naissance_annee[] = JL::makeOption('0', '> '.$lang_appprofil["AAAA"]);
		for($i=intval(date('Y')); $i>=1950; $i--) {
			$list_naissance_annee[] = JL::makeOption($i, sprintf('%04d', $i));
		}


		// signe astrologique
		$list_signe_astrologique_id[] = JL::makeOption('0', '> '.$lang_appprofil["JeLeGarde"]);

		$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
		." FROM profil_signe_astrologique"
		." WHERE published = 1"
		." ORDER BY nom_".$_GET['lang']." ASC"
		;
		$list_signe_astrologique_id = array_merge($list_signe_astrologique_id, $db->loadObjectList($query));


		// cr�ations des 6 sets de listes d�roulantes
		for($i=1; $i<=6; $i++) {
			$list['genre'.$i] 						= JL::makeSelectList( $list_genre, 'genre'.$i, 'class="select_profil"', 'value', 'text', $row['genre'.$i]);
			$list['naissance_jour'.$i] 				= JL::makeSelectList( $list_naissance_jour, 'naissance_jour'.$i, '', 'value', 'text', $row['naissance_jour'.$i]);
			$list['naissance_mois'.$i] 				= JL::makeSelectList( $list_naissance_mois, 'naissance_mois'.$i, '', 'value', 'text', $row['naissance_mois'.$i]);
			$list['naissance_annee'.$i] 			= JL::makeSelectList( $list_naissance_annee, 'naissance_annee'.$i, '', 'value', 'text', $row['naissance_annee'.$i]);
			$list['signe_astrologique'.$i.'_id'] 	= JL::makeSelectList( $list_signe_astrologique_id, 'signe_astrologique'.$i.'_id', 'class="select_profil"', 'value', 'text', $row['signe_astrologique'.$i.'_id']);
		}


		// r�cup le texte de gauche pendant l'inscription
		$notice = getNotice(7);
		
		$query = "SELECT id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte FROM contenu WHERE id = 21";
		$data = $db->loadObject($query);

		HTML_profil::step5($data, $row, $list, $messages, $notice);

	}

	function step5_data() {
		global $langue;
		$_data	= array(
			'child1' => 1,
			'child2' => 0,
			'child3' => 0,
			'child4' => 0,
			'child5' => 0,
			'child6' => 0,
			'naissance_jour1' => 0,
			'naissance_jour2' => 0,
			'naissance_jour3' => 0,
			'naissance_jour4' => 0,
			'naissance_jour5' => 0,
			'naissance_jour6' => 0,
			'naissance_mois1' => 0,
			'naissance_mois2' => 0,
			'naissance_mois3' => 0,
			'naissance_mois4' => 0,
			'naissance_mois5' => 0,
			'naissance_mois6' => 0,
			'naissance_annee1' => 0,
			'naissance_annee2' => 0,
			'naissance_annee3' => 0,
			'naissance_annee4' => 0,
			'naissance_annee5' => 0,
			'naissance_annee6' => 0,
			'genre1' => '',
			'genre2' => '',
			'genre3' => '',
			'genre4' => '',
			'genre5' => '',
			'genre6' => '',
			'signe_astrologique1_id' => 0,
			'signe_astrologique2_id' => 0,
			'signe_astrologique3_id' => 0,
			'signe_astrologique4_id' => 0,
			'signe_astrologique5_id' => 0,
			'signe_astrologique6_id' => 0,
			'photo_montrer' => 2
		);
		return $_data;
	}

	function step5submit() {
		global $langue;
		include("lang/app_profil.".$_GET['lang'].".php");
		global $db, $user;

		// gestion des messages d'erreurs
		$messages			= array();


		// donn�es � r�cup de l'�tape pr�c�dente + valeur par d�faut
		$_data	= step5_data();

		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				JL::setSession($key, JL::getVar($key, $value));
			}
		}


		// l'utilisateur doit au moins renseigner le premier enfant
		/*if(!JL::getSessionInt('child1', 0)) {
			$messages[]	= '<span class="error">'.$lang_appprofil["VeuillezindiquerLeGenre"].'.</span>';
		}*/


		// v�rification des enfants
		for($i=1; $i<=6; $i++) {
			$child	= JL::getSessionInt('child'.$i, 0);
			if($child) {

				switch($i) {
					case 1:
						$enfant_num = ''.$lang_appprofil["PremierEnfant"].'';
					break;

					case 2:
						$enfant_num = ''.$lang_appprofil["SecondEnfant"].'';
					break;

					case 3:
						$enfant_num = ''.$lang_appprofil["TroisiemeEnfant"].'';
					break;

					case 4:
						$enfant_num = ''.$lang_appprofil["QuatriemeEnfant"].'';
					break;

					case 5:
						$enfant_num = ''.$lang_appprofil["CinquiemeEnfant"].'';
					break;

					case 6:
						$enfant_num = ''.$lang_appprofil["SixiemeEnfant"].'';
					break;

				}

				if(JL::getSession('genre'.$i, '', true) != 'f' && JL::getSession('genre'.$i, '', true) != 'g') {

					$messages[]	= '<span class="error">'.$lang_appprofil["IndiquezGenreEnfantNum"].' '.$enfant_num.' '.$lang_appprofil["enfant2"].'.</span>';

				}

				if((JL::getSessionInt('naissance_jour'.$i, 0) + JL::getSessionInt('naissance_mois'.$i, 0) + JL::getSessionInt('naissance_annee'.$i, 0) > 0) && in_array(0, array(JL::getSessionInt('naissance_jour'.$i, 0), JL::getSessionInt('naissance_mois'.$i, 0), JL::getSessionInt('naissance_annee'.$i, 0)))) {

					$messages[]	= '<span class="error">'.$lang_appprofil["IndiquerDateNaissanceEnfantNum"].' '.$enfant_num.' '.$lang_appprofil["enfant2"].'.</span>';

				}

			}
		}

		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// user log
			if($user->id) {

				// sauvegarde les photos
				photosSave('enfant');

				// mise � jour des enfants
				for($i=1; $i<=6; $i++) {
					$child	= JL::getSessionInt('child'.$i, 0);

					// dans tous les cas, supprime l'ancien enregistrement (�vite un select puis test si insert ou update...)
					$query = "DELETE FROM user_enfant WHERE user_id = '".$user->id."' AND num = '".$i."'";
					$db->query($query);

					// si l'enfant a �t� ajout� par l'utilisateur
					if($child) {

						// ajoute l'enfant dans la db
						$query = "INSERT INTO user_enfant SET"
						." num = '".$i."',"
						." user_id = '".$user->id."',"
						." naissance_date = '".JL::getSessionInt('naissance_annee'.$i, 0)."-".JL::getSessionInt('naissance_mois'.$i, 0)."-".JL::getSessionInt('naissance_jour'.$i, 0)."',"
						." signe_astrologique_id = '".JL::getSessionInt('signe_astrologique'.$i.'_id', 0)."',"
						." genre = '".JL::getSession('genre'.$i, '', true)."'"
						;
						$db->query($query);

					} else {

						// supprime les photos car l'enfant n'est pas ou plus pr�sent dans la liste
						$dir 			= 'images/profil/'.JL::getSession('upload_dir', 'error');
						$file 			= $dir.'/parent-solo-109-enfant-'.$i.'.jpg';
						$file_pending 	= $dir.'/pending-parent-solo-109-enfant-'.$i.'.jpg';
						$file_temp 		= $dir.'/temp-parent-solo-109-enfant-'.$i.'.jpg';

						if(is_file($file)) {
							unlink($dir.'/parent-solo-109-enfant-'.$i.'.jpg');
							unlink($dir.'/parent-solo-35-enfant-'.$i.'.jpg');
							unlink($dir.'/parent-solo-enfant-'.$i.'.jpg');
						}
						if(is_file($file_pending)) {
							unlink($dir.'/pending-parent-solo-109-enfant-'.$i.'.jpg');
							unlink($dir.'/pending-parent-solo-35-enfant-'.$i.'.jpg');
							unlink($dir.'/pending-parent-solo-enfant-'.$i.'.jpg');
						}
						if(is_file($file_temp)) {
							unlink($dir.'/temp-parent-solo-109-enfant-'.$i.'.jpg');
							unlink($dir.'/temp-parent-solo-35-enfant-'.$i.'.jpg');
							unlink($dir.'/temp-parent-solo-enfant-'.$i.'.jpg');
						}

					}

				}


				// mise � jour du champ photo_montrer
				$photo_montrer = JL::getSessionInt('photo_montrer', 0);
				$query = "UPDATE user_profil SET photo_montrer = '".$photo_montrer."' WHERE user_id = '".$user->id."'";
				$db->query($query);


				// � laisser que l'user soit log ou pas, m�me si on affiche pas le message (util dans le swtich case sur $action)
				$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

			} else { // user non log

				// valide l'�tape
				if(isset($_SESSION['step_ok']) && $_SESSION['step_ok'] < 5) {
					$_SESSION['step_ok']	= 5;
				}

			}

		}


		// retourne la liste des messages d'erreur
		return $messages;

	}


	
	
	function finalisation() {
		global $langue;
		global $db;

		// v�rifie une nouvelle fois que l'email n'est pas d�j� renseign�
		$query = "SELECT id FROM user WHERE email = '".JL::getSession('email', '', true)."' LIMIT 0,1";
		$emailExistant	= $db->loadResult($query);

		// si l'email n'est pas d�j� pr�sent dans la DB
		if(!$emailExistant) {

			// conserve l'heure de cr�ation
			JL::setSession('creation_time', time());

			// check l'ip du visiteur
			$url_check_pays		= 'http://api.hostip.info/country.php?ip='.$_SERVER['REMOTE_ADDR'];

			// echo $url_check_pays;

//echo '------------------';
			// check la provenance du visiteur
			$ch 				= @curl_init($url_check_pays);
			@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$ip_pays 			= 'need to fix';//@curl_exec($ch);
			//echo '================='.$ip_pays;

			// cr�ation du compte utilisateur
			$query = "INSERT INTO user SET"
			." username = '".JL::getSession('username', '', true)."',"
			." password = MD5('".JL::getSession('password', '', true)."'),"
			." email = '".JL::getSession('email', '', true)."',"
			." gid = 0,"
			." creation_date = '".date('Y-m-d H:i:s', JL::getSession('creation_time', 0, true))."',"
			." ip_pays = '".addslashes($ip_pays)."'"
			;
			//echo '====================';
			//echo $query;
			$db->query($query);
			JL::setSession('user_id', $db->insert_id());

			// cr�ation du profil
			$query = "INSERT INTO user_profil SET"
			." user_id = '".JL::getSessionInt('user_id', 0)."',"
			." offres = '".JL::getSessionInt('offres', 0)."',"
			." genre = '".JL::getSession('genre', '', true)."',"
			." naissance_date = '".JL::getSessionInt('naissance_annee', 0)."-".JL::getSession('naissance_mois', 0)."-".JL::getSession('naissance_jour', 0)."',"
			." nb_enfants = '".JL::getSessionInt('nb_enfants', 0)."',"
			." canton_id = '".JL::getSessionInt('canton_id', 0)."',"
			." ville_id = '".JL::getSessionInt('ville_id', 0)."',"
			." photo_defaut = '".JL::getSessionInt('photo_defaut', 1)."',"
			." vie_id = '".JL::getSessionInt('vie_id', 0)."',"
			." cuisine1_id = '".JL::getSessionInt('cuisine1_id', 0)."',"
			." cuisine2_id = '".JL::getSessionInt('cuisine2_id', 0)."',"
			." cuisine3_id = '".JL::getSessionInt('cuisine3_id', 0)."',"
			." sortie1_id = '".JL::getSessionInt('sortie1_id', 0)."',"
			." sortie2_id = '".JL::getSessionInt('sortie2_id', 0)."',"
			." sortie3_id = '".JL::getSessionInt('sortie3_id', 0)."',"
			." loisir1_id = '".JL::getSessionInt('loisir1_id', 0)."',"
			." loisir2_id = '".JL::getSessionInt('loisir2_id', 0)."',"
			." loisir3_id = '".JL::getSessionInt('loisir3_id', 0)."',"
			." sport1_id = '".JL::getSessionInt('sport1_id', 0)."',"
			." sport2_id = '".JL::getSessionInt('sport2_id', 0)."',"
			." sport3_id = '".JL::getSessionInt('sport3_id', 0)."',"
			." musique1_id = '".JL::getSessionInt('musique1_id', 0)."',"
			." musique2_id = '".JL::getSessionInt('musique2_id', 0)."',"
			." musique3_id = '".JL::getSessionInt('musique3_id', 0)."',"
			." film1_id = '".JL::getSessionInt('film1_id', 0)."',"
			." film2_id = '".JL::getSessionInt('film2_id', 0)."',"
			." film3_id = '".JL::getSessionInt('film3_id', 0)."',"
			." lecture1_id = '".JL::getSessionInt('lecture1_id', 0)."',"
			." lecture2_id = '".JL::getSessionInt('lecture2_id', 0)."',"
			." lecture3_id = '".JL::getSessionInt('lecture3_id', 0)."',"
			." animaux1_id = '".JL::getSessionInt('animaux1_id', 0)."',"
			." animaux2_id = '".JL::getSessionInt('animaux2_id', 0)."',"
			." animaux3_id = '".JL::getSessionInt('animaux3_id', 0)."',"
			." nationalite_id = '".JL::getSessionInt('nationalite_id', 0)."',"
			." religion_id = '".JL::getSessionInt('religion_id', 0)."',"
			." langue1_id = '".JL::getSessionInt('langue1_id', 0)."',"
			." langue2_id = '".JL::getSessionInt('langue2_id', 0)."',"
			." langue3_id = '".JL::getSessionInt('langue3_id', 0)."',"
			." statut_marital_id = '".JL::getSessionInt('statut_marital_id', 0)."',"
			." me_marier_id = '".JL::getSessionInt('me_marier_id', 0)."',"
			." cherche_relation_id = '".JL::getSessionInt('cherche_relation_id', 0)."',"
			." niveau_etude_id = '".JL::getSessionInt('niveau_etude_id', 0)."',"
			." secteur_activite_id = '".JL::getSessionInt('secteur_activite_id', 0)."',"
			." fumer_id = '".JL::getSessionInt('fumer_id', 0)."',"
			." temperament_id = '".JL::getSessionInt('temperament_id', 0)."',"
			." vouloir_enfants_id = '".JL::getSessionInt('vouloir_enfants_id', 0)."',"
			." garde_id = '".JL::getSessionInt('garde_id', 0)."',"
			." signe_astrologique_id = '".JL::getSessionInt('signe_astrologique_id', 0)."',"
			." taille_id = '".JL::getSessionInt('taille_id', 0)."',"
			." poids_id = '".JL::getSessionInt('poids_id', 0)."',"
			." silhouette_id = '".JL::getSessionInt('silhouette_id', 0)."',"
			." style_coiffure_id = '".JL::getSessionInt('style_coiffure_id', 0)."',"
			." cheveux_id = '".JL::getSessionInt('cheveux_id', 0)."',"
			." yeux_id = '".JL::getSessionInt('yeux_id', 0)."',"
			." origine_id = '".JL::getSessionInt('origine_id', 0)."',"
			." photo_montrer = '".JL::getSessionInt('photo_montrer', 0)."',"
			." photo_home = '".JL::getSession('photo_home', '', true)."',"
			." nom = '".JL::getSession('nom', '', true)."',"
			." nom_origine = '".JL::getSession('nom', '', true)."',"
			." prenom = '".JL::getSession('prenom', '', true)."',"
			." prenom_origine = '".JL::getSession('prenom', '', true)."',"
			." telephone = '".JL::getSession('telephone', '', true)."',"
			." telephone_origine = '".JL::getSession('telephone', '', true)."',"
			." adresse = '".JL::getSession('adresse', '', true)."',"
			." adresse_origine = '".JL::getSession('adresse', '', true)."',"
			." code_postal = '".JL::getSession('code_postal', '', true)."',"
			." code_postal_origine = '".JL::getSession('code_postal', '', true)."',"
			." parrain_id = '".JL::getSession('parrain_id', 0, true)."',"
			." langue_appel = '".JL::getSession('langue_appel','',true)."'"
			;
			$db->query($query);


			// cr�ation de l'annonce
			$query = "INSERT INTO user_annonce SET"
			." user_id = '".JL::getSessionInt('user_id', 0)."',"
			." annonce = '".JL::getSession('annonce', '', true)."'"
			;
			$db->query($query);


			// abonnement initial
			$gold_limit_date	= '0000-00-00';

			// si des jours sont offerts (d�fini dans config.php)
			if(ABONNEMENT_INITIAL > 0) {

				$date	= explode('/', date('d/m/Y'));
				$jour	= $date[0];
				$mois	= $date[1];
				$annee	= $date[2];
				$gold_limit_date	= date('Y-m-d', mktime(0, 0, 0, $mois, $jour + ABONNEMENT_INITIAL, $annee));

			}


			// cr�ation des stats
			$query = "INSERT INTO user_stats SET"
			." user_id = '".JL::getSessionInt('user_id', 0)."',"
			." gold_limit_date = '".$gold_limit_date."',"
			." gold_total = '0'"
			;
			$db->query($query);


			// inscription au groupe par d�faut
			$query = "INSERT INTO groupe_user SET groupe_id = 1, user_id = '".JL::getSessionInt('user_id', 0)."', date_join = NOW()";
			$db->query($query);


			// gestion des notifications
			$query = "INSERT INTO user_notification SET user_id = '".JL::getSessionInt('user_id', 0)."'";
			$db->query($query);


			// cr�ation des enfants
			for($i=1; $i<=6; $i++) {
				$child	= JL::getSessionInt('child'.$i, 0);
				if($child) {
					$query = "INSERT INTO user_enfant SET"
					." user_id = '".JL::getSessionInt('user_id', 0)."',"
					." num = '".$i."',"
					." naissance_date = '".JL::getSessionInt('naissance_annee'.$i, 0)."-".JL::getSessionInt('naissance_mois'.$i, 0)."-".JL::getSessionInt('naissance_jour'.$i, 0)."',"
					." signe_astrologique_id = '".JL::getSessionInt('signe_astrologique'.$i.'_id', 0)."',"
					." genre = '".JL::getSession('genre'.$i, '', true)."'"
					;
					$db->query($query);
				}
			}


			// enregistre la recherche de l'utilisateur
			$query = "UPDATE user_recherche SET user_id = '".JL::getSessionInt('user_id', 0)."' WHERE user_id_tmp LIKE '".JL::getSession('upload_dir', 0)."'";
			$db->query($query);


			// supprime la r�servation username et email
			$query = "DELETE FROM user_inscription WHERE username LIKE '".JL::getSession('username','',true)."' OR email LIKE '".JL::getSession('email','',true)."'";
			$db->query($query);


			// met � jour la table du nombre d'inscrits
			$field = JL::getSession('genre', '', true) == 'h' ? 'papa' : 'maman';
			$query = "UPDATE inscrits SET ".$field." = ".$field." + 1";
			$db->query($query);


			// sauvegarde les photos et suppression du r�pertoire temporaire d'upload
			photosSave('', true);


			// r�cup le message priv�e de bienvenue
			$query = "SELECT titre, texte"
			." FROM notification"
			." WHERE id = 2"
			." LIMIT 0,1"
			;
			$mp = $db->loadObject($query);

			// envoie le message priv�e de bienvenue
			$query = "INSERT INTO message SET"
			." user_id_from = '1',"
			." user_id_to = '".JL::getSessionInt('user_id', 0)."',"
			." titre = '".$mp->titre."',"
			." texte = '".$db->escape(sprintf($mp->texte, JL::getSession('username', '')))."',"
			." date_envoi = NOW()"
			;
			$db->query($query);

			// cr�dite les points
			JL::addPoints(4, JL::getSessionInt('user_id', 0), '');

		
			// variables locales
			if($_GET['lang']=='de'){
				$mailing_id = 39;
			}elseif($_GET['lang']=='en'){
				$mailing_id = 46;
			}else{
				$mailing_id = 31;
			}
			
			// charge le texte du mail
			$query = "SELECT titre, texte, template"
			." FROM mailing"
			." WHERE id = '".$db->escape($mailing_id)."'"
			." LIMIT 0,1"
			;
			$mailing = $db->loadObject($query);

			$query = "UPDATE user_stats SET message_new = message_new+1, message_total = message_total+1 WHERE user_id = '".JL::getSessionInt('user_id', 0)."'";
			$db->query($query);
			$user_email=JL::getSession('email', '', true);
			$confrm_encripted_url=base64_encode(base64_encode($user_email));
			$confrm_encripted_id=base64_encode(base64_encode(JL::getSessionInt('user_id', 0)));
			
$confrm_url=SITE_URL."/index.php?lang=".$_GET['lang']."&app=confrm&action=confirmation&urlid=".$confrm_encripted_url."&cnfrmid=".$confrm_encripted_id;
$site_url=SITE_URL;

$user_email=JL::getSession('email', '', true);
			// envoi du mail de confirmation
			// int�gration du texte et du template, ainsi que traitement des mots cls
			//$mailingTexte 	= JL::getMailHtml(SITE_PATH_ADMIN.'/app/app_mailing/template/'.$mailing->template, $mailing->titre, $mailing->texte, $confrm_url, JL::getSession('username', ''), array(JL::getSession('password', '')));
if($_GET['lang']=='en'){
$confrm_subject="Confirmation of the registration";
			 $message_con="<table style='width:590px;margin:auto;text-align:center;font-family:Arial, Verdana, Helvetica, sans-serif;font-size:11px;color:#fff; background-color:#b4ada5;'></table>
	<table cellpadding='0' cellspacing='0' style='width:590px;margin:auto;text-align:left;font-family:Arial, Verdana, Helvetica, sans-serif;font-size:12px;color:#000; background-color:#FFF'>
		<tr><td style='width:590px; background-color:#c32a2c; height:10px'>&nbsp;</td></tr>
		<tr><td style='width:590px; background-color:#82817d; text-align:left'><img src='".$site_url."/images/mail/inscription-en.jpg'/></td></tr>
		<tr><td align='center' style='width:590px; background-color:#fff; height:120px'><img src='".$site_url."/images/mail/header-en.jpg'/></td></tr>
		<tr><td style='text-align:justify;padding:40px;'>
		<p><h1 style='font-family: Impact,Times,Arial,Verdana,Helvetica,sans-serif; font-size: 24px; color: rgb(220, 155, 156); font-weight: normal;'>Confirmation of the registration</h1>
<br />Hello <strong>".JL::getSession('username', '', true)."</strong>,<br /><br /><br />
Welcome on solocircl.com!<br /><br /><br />
Here are your connecting values again:<br /><br />
User name: <strong>".JL::getSession('username', '', true)."</strong><br />
Password: <strong>".JL::getSession('password', '', true)."</strong><br />
URL: <strong><a href='".$confrm_url."' >Click here</a></strong><br /><br /><br />
You can connect to your profile up to now.<br /><br /><br />
See you soon on solocircl.com!<br /><br /></p></td></tr>
	<tr><td style='background-color:#c32a2c;color:#fff; font-size:11px; padding:0px 10px;'><p>
					Cette lettre d'information vous a &eacute;t&eacute; envoy&eacute;e par <a href='".$site_url."' style='color:#fff;font-size:11px;font-weight:bold'>solocircl.com</a>.<br />
					Si vous ne souhaitez plus recevoir cet email, connectez-vous &agrave; votre compte sur solocircl.com, puis allez dans 'Mes notifications', et d&eacute;cochez la case qui correspond &agrave; cet email.
	</p></td></tr></table>";
	} else if($_GET['lang']=='de'){
	$confrm_subject="Anmeldungsbestätigung";
	 $message_con="<table style='width:590px;margin:auto;text-align:center;font-family:Arial, Verdana, Helvetica, sans-serif;font-size:11px;color:#fff; background-color:#b4ada5;'></table>
	<table cellpadding='0' cellspacing='0' style='width:590px;margin:auto;text-align:left;font-family:Arial, Verdana, Helvetica, sans-serif;font-size:12px;color:#000; background-color:#FFF'>
		<tr><td style='width:590px; background-color:#c32a2c; height:10px'>&nbsp;</td></tr>
		<tr><td style='width:590px; background-color:#82817d; text-align:left'><img src='".$site_url."/images/mail/inscription-de.jpg'/></td></tr>
		<tr><td align='center' style='width:590px; background-color:#fff; height:120px'><img src='".$site_url."/images/mail/header-de.jpg'/></td></tr>
		<tr><td style='text-align:justify;padding:40px;'>
		<p><h1 style='font-family: Impact,Times,Arial,Verdana,Helvetica,sans-serif; font-size: 24px; color: rgb(220, 155, 156); font-weight: normal;'>Anmeldungsbest&auml;tigung</h1>
<br />Guten Tag <strong>".JL::getSession('username', '', true)."</strong>,<br /><br /><br />
Willkommen auf SinglEltern.ch!<br /><br /><br />
Hier sind Ihre Kennw&ouml;rter wieder:<br /><br />
Benutzername: <strong>".JL::getSession('username', '', true)."</strong><br />
Passwort: <strong>".JL::getSession('password', '', true)."</strong><br />
URL: <strong><a href='".$confrm_url."' >Hier klicken</a></strong><br /><br /><br />
Sie k&ouml;nnen sich ab jetzt in Ihrem Profil einloggen.<br /><br /><br />
Bis bald auf SinglEltern.ch!<br /><br /></p></td></tr>
	<tr><td style='background-color:#c32a2c;color:#fff;font-size:11px; padding:0px 10px;'><p>
					Cette lettre d'information vous a &eacute;t&eacute; envoy&eacute;e par <a href='".$site_url."' style='color:#fff;font-size:11px;font-weight:bold'>solocircl.com</a>.<br />
					Si vous ne souhaitez plus recevoir cet email, connectez-vous &agrave; votre compte sur solocircl.com, puis allez dans 'Mes notifications', et d&eacute;cochez la case qui correspond &agrave; cet email.
	</p></td></tr></table>";
	}
	else{
	$confrm_subject="Confirmation d'inscription";
	 $message_con="<table style='width:590px;margin:auto;text-align:center;font-family:Arial, Verdana, Helvetica, sans-serif;font-size:11px;color:#fff; background-color:#b4ada5;'></table>
	<table cellpadding='0' cellspacing='0' style='width:590px;margin:auto;text-align:left;font-family:Arial, Verdana, Helvetica, sans-serif;font-size:12px;color:#000; background-color:#FFF'>
		<tr><td style='width:590px; background-color:#c32a2c; height:10px'>&nbsp;</td></tr>
		<tr><td style='width:590px; background-color:#82817d; text-align:left'><img src='".$site_url."/images/mail/inscription-fr.jpg'/></td></tr>
		<tr><td align='center' style='width:590px; background-color:#fff; height:120px'><img src='".$site_url."/images/mail/header-fr.jpg'/></td></tr>
		<tr><td style='text-align:justify;padding:40px;'>
		<p><h1 style='font-family: Impact,Times,Arial,Verdana,Helvetica,sans-serif; font-size: 24px; color: rgb(220, 155, 156); font-weight: normal;'>Confirmation d'inscription</h1>
<br />Bonjour <strong>".JL::getSession('username', '', true)."</strong>,<br /><br /><br />
Bienvenue sur solocircl.com!<br /><br /><br />
Voici le rappel de vos identifiants:<br /><br />
pseudo: <strong>".JL::getSession('username', '', true)."</strong><br />
mot de passe: <strong>".JL::getSession('password', '', true)."</strong><br />
URL: <strong><a href='".$confrm_url."' >Cliquez ici</a></strong><br /><br /><br />
Vous pouvez d&egrave;s &agrave; pr&eacute;sent vous connecter &agrave; votre profil.<br /><br /><br />
A bient&ocirc;t sur solocircl.com!<br /><br /></p></td></tr>
	<tr><td style='background-color:#c32a2c;color:#fff;font-size:11px; padding:0px 10px;'><p>
Cette lettre d'information vous a &eacute;t&eacute; envoy&eacute;e par <a href='".$site_url."' style='color:#fff;font-size:11px;font-weight:bold'>solocircl.com</a>.<br />
					Si vous ne souhaitez plus recevoir cet email, connectez-vous &agrave; votre compte sur solocircl.com, puis allez dans 'Mes notifications', et d&eacute;cochez la case qui correspond &agrave; cet email.
	</p></td></tr></table>";
	}
			JL::mail($user_email, $confrm_subject, $message_con);
			// envoi du mail
		//	@JL::mail(JL::getSession('email','',true), $mailing->titre, $mailingTexte);
			// r�cup le texte de gauche pendant l'inscription
			$notice = getNotice(9); 
			HTML_profil::finalisation($notice);
		}else{			
			// r�cup le texte de gauche pendant l'inscription
			$notice = getNotice(9);
			HTML_profil::inscription_interrompu($notice);
			
		}

	}
	
	
	function inscription_interrompu() {
		global $langue;

		// r�cup le texte de gauche pendant l'inscription
		$notice = getNotice(9);

		HTML_profil::inscription_interrompu($notice);
			
	}


	function notification($messages = array()) {
		global $langue,$langString;
		include("lang/app_profil.".$_GET['lang'].".php");;
		global $db, $user;

		// variables
		$row						= array();

		// r�cup les donn�es en db
		$query = "SELECT *"
		." FROM user_notification"
		." WHERE user_id = '".$user->id."'"
		." LIMIT 0,1"
		;
		$row = $db->loadObjectList($query);


		// r�cup le genre de l'user log
		$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
		$row['genre']	= $db->loadResult($query);

		HTML_profil::notification($row, $messages);

	}

	function &notification_data() {
		global $langue;
		$_data	= array(
			'new_message' 	=> 0,
			'new_fleur' 	=> 0,
			'new_flash' 	=> 0,
			'new_inscrits' 	=> 0,
			'new_visite' 	=> 0,
			'rappels' 		=> 0
		);
		return $_data;
	}

	function notificationsubmit() {
		include("lang/app_profil.".$_GET['lang'].".php");
		global $langue;
		global $db, $user;

		// gestion des messages d'erreurs
		$messages		= array();
		$row			= array();

		// initialise les donn�es
		$_data			=& notification_data();

		// conserve les donn�es envoy�es en session
		if (is_array($_data)) {
			foreach($_data as $key => $value) {
				$row[$key] = JL::getVar($key, $value) ? 1 : 0;
			}
		}


		// s'il n'y a pas d'erreurs
		if(!count($messages)) {

			// enregistre les modifs en DB
			$query = "UPDATE user_notification SET"
			." new_message = '".$row['new_message']."',"
			." new_fleur = '".$row['new_fleur']."',"
			." new_visite = '".$row['new_visite']."',"
			." rappels = '".$row['rappels']."'"
			." WHERE user_id = '".$user->id."'"
			;
			$db->query($query);

			// message de confirmation
			$messages[]	= '<span class="valid">'.$lang_appprofil["ModificationEnregistrees"].' !</span>';

		}

		// retourne la liste des messages d'erreur
		return $messages;

	}
	
	
	
	// affiche le profil
	function profil() {
		global $langue,$langString;
		global $db, $user, $action;
		
		$where = array();
		
		// variables
		$profilEnfants			= array();
		$profilDescription		= array();
		$profilInfosEnVrac1		= array();
		$profilInfosEnVrac2		= array();
		$profilQuotidien1		= array();
		$profilQuotidien2		= array();
		$profilQuotidien3		= array();
		$profilQuotidien4		= array();
		$profilGroupes			= array();


		// id du profil � afficher
		$id	= JL::getVar('id', 0, true);

		// r�cup le genre de l'utilisateur log
		$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
		$genre = $db->loadResult($query);


		// champs obligatoires
		$where[]	= "u.id = '".$id."'";
		$where[]	= "u.confirmed > 0";
		$where[]	= "u.published = 1";
		$where[]	= "u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)";
		$where[]	= "u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)";


		// g�n�re le where
		$_where	=	JL::setWhere($where);


		// r�cup les infos de base du profil
		$query = "SELECT u.id, IF(up.genre!='".$db->escape($genre)."' OR u.id = '".$db->escape($user->id)."',1,0) AS accessok, u.username, u.email, u.creation_date, IFNULL(ua.annonce_valide, '') AS annonce, up.genre, up.photo_defaut, up.nb_enfants, pc.nom_".$_GET['lang']." AS canton, IFNULL(pv.nom, '') AS ville, up.naissance_date, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, up.photo_montrer, u.online"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN user_annonce AS ua ON ua.user_id = u.id"
		." INNER JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN profil_ville AS pv ON pv.id = up.ville_id"
		.$_where
		." LIMIT 0,1"
		;
		$profil = $db->loadObject($query);
		
		
		// si le profil est trouv�
		if($profil->id) {

			// si l'user log visite un profil de genre oppos�, et ne visite pas son propre profil
			if($profil->accessok == 1 && $id != $user->id && $action=='view') {

				// mise � jour des stats g�n�rales
				$query = "UPDATE user_stats SET visite_total = visite_total + 1 WHERE user_id = '".$id."'";
				$db->query($query);

				// si un utilisateur n'est pas en blacklist de l'autre
				if($profil->blacklist == 0) {

					// mise � jour des stats de visites
					$query = "UPDATE user_visite SET visite_last_date = NOW(), visite_nb = visite_nb + 1 WHERE user_id_to = '".$id."' AND user_id_from = '".$user->id."'";
					$db->query($query);

					// si aucune ligne n'a �t� affect�e
					if(!$db->affected_rows()) {

						// on insert les stats
						$query = "INSERT INTO user_visite SET user_id_to = '".$id."', user_id_from = '".$user->id."', visite_last_date = NOW(), visite_nb = 1";
						$db->query($query);

						// notification mail
						JL::notificationBasique('visite', $profil->id);

					}

					// enregistre le dernier �v�nement chez le profil cible
					JL::addLastEvent($profil->id, $user->id, 1);

					// cr�dite l'action visite par user et pas jour
					JL::addPoints(18, $profil->id, $profil->id.'#'.$user->id.'#'.date('d-m-Y'));

				}

			}

			// r�cup la description
			$query = "SELECT psa.nom_".$_GET['lang']." AS signe_astrologique, up.taille_id AS taille, up.poids_id AS poids, ps.nom_".$_GET['lang']." AS silhouette, psc.nom_".$_GET['lang']." AS style_coiffure, pc.nom_".$_GET['lang']." AS cheveux, py.nom_".$_GET['lang']." AS yeux, po.nom_".$_GET['lang']." AS origine"
			." FROM user_profil AS up"
			." LEFT JOIN profil_signe_astrologique AS psa ON psa.id = up.signe_astrologique_id AND psa.published = 1"
			." LEFT JOIN profil_silhouette AS ps ON ps.id = up.silhouette_id AND ps.published = 1"
			." LEFT JOIN profil_style_coiffure AS psc ON psc.id = up.style_coiffure_id AND psc.published = 1"
			." LEFT JOIN profil_cheveux AS pc ON pc.id = up.cheveux_id AND pc.published = 1"
			." LEFT JOIN profil_yeux AS py ON py.id = up.yeux_id AND py.published = 1"
			." LEFT JOIN profil_origine AS po ON po.id = up.origine_id AND po.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilDescription = $db->loadObject($query);


			

			// r�cup les enfants
			$query = "SELECT ue.num, ue.genre, IFNULL(psa.nom_".$_GET['lang'].", '') AS signe_astrologique, ue.naissance_date"
			." FROM user_enfant AS ue"
			." LEFT JOIN profil_signe_astrologique AS psa ON psa.id = ue.signe_astrologique_id"
			." WHERE ue.user_id = '".$profil->id."'"
			." LIMIT 0,6"
			;
			$profilEnfants = $db->loadObjectList($query);

			


			// r�cup les infos diverses (partie 1)
			$query = "SELECT pn.nom_".$_GET['lang']." AS nationalite, pr.nom_".$_GET['lang']." AS religion, pl1.nom_".$_GET['lang']." AS langue1, pl2.nom_".$_GET['lang']." AS langue2, pl3.nom_".$_GET['lang']." AS langue3, psm.nom_".$_GET['lang']." AS statut_marital, pmm.nom_".$_GET['lang']." AS me_marier"
			." FROM user_profil AS up"
			." LEFT JOIN profil_nationalite AS pn ON pn.id = up.nationalite_id AND pn.published = 1"
			." LEFT JOIN profil_religion AS pr ON pr.id = up.religion_id AND pr.published = 1"
			." LEFT JOIN profil_langue AS pl1 ON pl1.id = up.langue1_id AND pl1.published = 1"
			." LEFT JOIN profil_langue AS pl2 ON pl2.id = up.langue2_id AND pl2.published = 1"
			." LEFT JOIN profil_langue AS pl3 ON pl3.id = up.langue3_id AND pl3.published = 1"
			." LEFT JOIN profil_statut_marital AS psm ON psm.id = up.statut_marital_id AND psm.published = 1"
			." LEFT JOIN profil_me_marier AS pmm ON pmm.id = up.me_marier_id AND pmm.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilInfosEnVrac1 = $db->loadObject($query);


			// r�cup les infos diverses (partie 2)
			$query = "SELECT pcr.nom_".$_GET['lang']." AS cherche_relation, pne.nom_".$_GET['lang']." AS niveau_etude, psa.nom_".$_GET['lang']." AS secteur_activite, pf.nom_".$_GET['lang']." AS fumer, pt.nom_".$_GET['lang']." AS temperament, pve.nom_".$_GET['lang']." AS vouloir_enfants, pg.nom_".$_GET['lang']." AS garde"
			." FROM user_profil AS up"
			." LEFT JOIN profil_cherche_relation AS pcr ON pcr.id = up.cherche_relation_id AND pcr.published = 1"
			." LEFT JOIN profil_niveau_etude AS pne ON pne.id = up.niveau_etude_id AND pne.published = 1"
			." LEFT JOIN profil_secteur_activite AS psa ON psa.id = up.secteur_activite_id AND psa.published = 1"
			." LEFT JOIN profil_fumer AS pf ON pf.id = up.fumer_id AND pf.published = 1"
			." LEFT JOIN profil_temperament AS pt ON pt.id = up.temperament_id AND pt.published = 1"
			." LEFT JOIN profil_vouloir_enfants AS pve ON pve.id = up.vouloir_enfants_id AND pve.published = 1"
			." LEFT JOIN profil_garde AS pg ON pg.id = up.garde_id AND pg.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilInfosEnVrac2 = $db->loadObject($query);


			// r�cup le quotidien 1
			$query = "SELECT pv.nom_".$_GET['lang']." AS vie, pc1.nom_".$_GET['lang']." AS cuisine1, pc2.nom_".$_GET['lang']." AS cuisine2, pc3.nom_".$_GET['lang']." AS cuisine3, ps1.nom_".$_GET['lang']." AS sortie1, ps2.nom_".$_GET['lang']." AS sortie2, ps3.nom_".$_GET['lang']." AS sortie3"
			." FROM user_profil AS up"
			." LEFT JOIN profil_vie AS pv ON pv.id = up.vie_id AND pv.published = 1"
			." LEFT JOIN profil_cuisine AS pc1 ON pc1.id = up.cuisine1_id AND pc1.published = 1"
			." LEFT JOIN profil_cuisine AS pc2 ON pc2.id = up.cuisine2_id AND pc2.published = 1"
			." LEFT JOIN profil_cuisine AS pc3 ON pc3.id = up.cuisine3_id AND pc3.published = 1"
			." LEFT JOIN profil_sortie AS ps1 ON ps1.id = up.sortie1_id AND ps1.published = 1"
			." LEFT JOIN profil_sortie AS ps2 ON ps2.id = up.sortie2_id AND ps2.published = 1"
			." LEFT JOIN profil_sortie AS ps3 ON ps3.id = up.sortie3_id AND ps3.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilQuotidien1 = $db->loadObject($query);


			// r�cup le quotidien 2
			$query = "SELECT pl1.nom_".$_GET['lang']." AS loisir1, pl2.nom_".$_GET['lang']." AS loisir2, pl3.nom_".$_GET['lang']." AS loisir3, ps1.nom_".$_GET['lang']." AS sport1, ps2.nom_".$_GET['lang']." AS sport2, ps3.nom_".$_GET['lang']." AS sport3"
			." FROM user_profil AS up"
			." LEFT JOIN profil_loisir AS pl1 ON pl1.id = up.loisir1_id AND pl1.published = 1"
			." LEFT JOIN profil_loisir AS pl2 ON pl2.id = up.loisir2_id AND pl2.published = 1"
			." LEFT JOIN profil_loisir AS pl3 ON pl3.id = up.loisir3_id AND pl3.published = 1"
			." LEFT JOIN profil_sport AS ps1 ON ps1.id = up.sport1_id AND ps1.published = 1"
			." LEFT JOIN profil_sport AS ps2 ON ps2.id = up.sport2_id AND ps2.published = 1"
			." LEFT JOIN profil_sport AS ps3 ON ps3.id = up.sport3_id AND ps3.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilQuotidien2 = $db->loadObject($query);


			// r�cup le quotidien 3
			$query = "SELECT pm1.nom_".$_GET['lang']." AS musique1, pm2.nom_".$_GET['lang']." AS musique2, pm3.nom_".$_GET['lang']." AS musique3, pf1.nom_".$_GET['lang']." AS film1, pf2.nom_".$_GET['lang']." AS film2, pf3.nom_".$_GET['lang']." AS film3"
			." FROM user_profil AS up"
			." LEFT JOIN profil_musique AS pm1 ON pm1.id = up.musique1_id AND pm1.published = 1"
			." LEFT JOIN profil_musique AS pm2 ON pm2.id = up.musique2_id AND pm2.published = 1"
			." LEFT JOIN profil_musique AS pm3 ON pm3.id = up.musique3_id AND pm3.published = 1"
			." LEFT JOIN profil_film AS pf1 ON pf1.id = up.film1_id AND pf1.published = 1"
			." LEFT JOIN profil_film AS pf2 ON pf2.id = up.film2_id AND pf2.published = 1"
			." LEFT JOIN profil_film AS pf3 ON pf3.id = up.film3_id AND pf3.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilQuotidien3 = $db->loadObject($query);


			// r�cup le quotidien 4
			$query = "SELECT pl1.nom_".$_GET['lang']." AS lecture1, pl2.nom_".$_GET['lang']." AS lecture2, pl3.nom_".$_GET['lang']." AS lecture3, pa1.nom_".$_GET['lang']." AS animaux1, pa2.nom_".$_GET['lang']." AS animaux2, pa3.nom_".$_GET['lang']." AS animaux3"
			." FROM user_profil AS up"
			." LEFT JOIN profil_lecture AS pl1 ON pl1.id = up.lecture1_id AND pl1.published = 1"
			." LEFT JOIN profil_lecture AS pl2 ON pl2.id = up.lecture2_id AND pl2.published = 1"
			." LEFT JOIN profil_lecture AS pl3 ON pl3.id = up.lecture3_id AND pl3.published = 1"
			." LEFT JOIN profil_animaux AS pa1 ON pa1.id = up.animaux1_id AND pa1.published = 1"
			." LEFT JOIN profil_animaux AS pa2 ON pa2.id = up.animaux2_id AND pa2.published = 1"
			." LEFT JOIN profil_animaux AS pa3 ON pa3.id = up.animaux3_id AND pa3.published = 1"
			." WHERE up.user_id = '".$profil->id."'"
			." LIMIT 0,1"
			;
			$profilQuotidien4 = $db->loadObject($query);


			// r�cup les groupes du profil
			$query = "SELECT g.id, g.titre, g.texte"
			." FROM groupe AS g"
			." INNER JOIN groupe_user AS gu ON gu.groupe_id = g.id"
			." WHERE g.active > 0 AND g.titre != '' AND gu.user_id = '".$profil->id."'"
			." ORDER BY gu.date_join DESC"
			;
			$profilGroupes = $db->loadObjectList($query);

		}

		// affiche le profil
		HTML_profil::profil($profil, $profilEnfants, $profilDescription, $profilInfosEnVrac1, $profilInfosEnVrac2, $profilQuotidien1, $profilQuotidien2, $profilQuotidien3, $profilQuotidien4, $profilGroupes);

	}
	
	
	
	
	// panneau d'admin utilisateur une fois log
	function panel() {
		global $langue,$langString;
		global $db, $user;


		// r�cup le genre de l'utilisateur
		$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
		$genre = $db->loadResult($query);

		// si c'est un homme
		if($genre == 'h') {
			$genreRecherche =  'f';
		} else { // sinon si c'est une femme
			$genreRecherche =  'h';
		}

		$query = "SELECT confirmed FROM user WHERE id = '".(int)$user->id."' LIMIT 0,1";
		$user->confirmed = $db->loadResult($query);
	
		$query = "SELECT u.id, u.username, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton, up.genre, up.photo_defaut, up.nb_enfants, CURRENT_DATE, up.naissance_date"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." WHERE u.id = '".$user->id."'"
		." LIMIT 0,1"
		;
		$userProfilMini	= $db->loadObject($query);


		// r�cup les stats du compte
		$query = "SELECT us.visite_total, IF(us.gold_limit_date > CURRENT_DATE, 1, 0) AS gold, us.fleur_new, us.message_new, IFNULL(COUNT(gu.user_id), 0) AS groupe_joined, us.points_total"
		." FROM user_stats AS us"
		." LEFT JOIN groupe_user AS gu ON gu.user_id = us.user_id"
		." WHERE us.user_id = '".$user->id."'"
		." GROUP BY us.user_id"
		." LIMIT 0,1"
		;
		$userStats = $db->loadObject($query);

		// r�cup des membres en ligne (sans prendre l'utilisateur log)
		$query = "SELECT u.id, u.username, pc.abreviation AS canton, up.genre, up.photo_defaut, up.nb_enfants, IFNULL(ua.annonce_valide, '') AS annonce, CURRENT_DATE, up.naissance_date, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, u.online"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN user_annonce AS ua ON (ua.user_id = u.id AND ua.published = 1)"
		." WHERE u.published = 1 AND u.confirmed > 0 AND u.id != '".$user->id."' AND up.genre = '".$genreRecherche."' AND (u.online='1' And (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) < ".(ONLINE_TIME_LIMIT+AFK_TIME_LIMIT)." AND u.on_off_status='1')"
		." AND u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)"
		." AND u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)"
		." GROUP BY u.id"
		." ORDER BY u.last_online DESC"
		." LIMIT 0,8"
		;
		$profilsOnline 		= $db->loadObjectList($query);
		
		

		// R cup the last registered (without taking log user)
		$query = "SELECT u.id, u.username, pc.abreviation AS canton, up.genre, up.photo_defaut, up.nb_enfants, IFNULL(ua.annonce_valide, '') AS annonce, CURRENT_DATE, up.naissance_date, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, u.online,u.on_off_status"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN user_annonce AS ua ON (ua.user_id = u.id AND ua.published = 1)"
		." WHERE u.published = 1 AND u.confirmed > 0 AND u.id != '".$user->id."' AND up.genre = '".$genreRecherche."'"
		." AND u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)"
		." AND u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)"
		." GROUP BY u.id"
		." ORDER BY u.creation_date DESC"
		." LIMIT 0,8"
		;
		$profilsInscrits 	= $db->loadObjectList($query);

		
		
		// Profile Matching
		$query = "SELECT religion_id, nationalite_id, canton_id, recherche_age_min, TIMESTAMPDIFF(YEAR,naissance_date,CURDATE()) as userage, recherche_age_max FROM user_profil WHERE user_id = '".$user->id."'";
		$values_select = $db->loadObject($query);
$age_max_pro=(($values_select->userage)+5);
		$age_min_pro=(($values_select->userage)-5);
		//$whereQuery= "((up.religion_id = '".$values_select->religion_id."' OR up.nationalite_id = '".$values_select->nationalite_id."' OR up.canton_id = '".$values_select->canton_id."') or (TIMESTAMPDIFF(YEAR,up.naissance_date,NOW()) BETWEEN '".$values_select->recherche_age_min."' and '".$values_select->recherche_age_max."'))";//profile
		
		$query = "SELECT u.id, u.username, pc.abreviation AS canton, up.genre, up.photo_defaut, up.nb_enfants, IFNULL(ua.annonce_valide, '') AS annonce, CURRENT_DATE, up.naissance_date, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, u.online"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." LEFT JOIN user_annonce AS ua ON (ua.user_id = u.id AND ua.published = 1)"
		." WHERE u.published = 1 AND u.confirmed > 0 AND u.id != '".$user->id."' AND up.genre = '".$genreRecherche."'"
		."AND (((up.religion_id = '".$values_select->religion_id."' or up.nationalite_id = '".$values_select->nationalite_id."') and up.canton_id = '".$values_select->canton_id."') and (TIMESTAMPDIFF(YEAR,up.naissance_date,NOW()) BETWEEN '".$age_min_pro."' and '".$age_max_pro."'))"
		//."AND ((up.religion_id = '".$values_select->religion_id."' or up.nationalite_id = '".$values_select->nationalite_id."' or up.canton_id = '".$values_select->canton_id."') or (TIMESTAMPDIFF(YEAR,up.naissance_date,NOW()) BETWEEN '".$values_select->recherche_age_min."' and '".$values_select->recherche_age_max."'))"
		." AND u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$user->id."  AND list_type=0)"
		." AND u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$user->id." AND list_type=0)"
		." GROUP BY u.id"
		." LIMIT 0,8"
		;
		$profilsMatching 	= $db->loadObjectList($query);
		

		// R cup search engine fields
		$list	=& FCT::getSearchEngine();

$query = "SELECT at.id, at.titre, at.annonce, m.nom_en AS media"
       . " FROM appel_a_temoins AS at"
       . " INNER JOIN appel_media AS m ON m.id = at.media_id"
       . " WHERE at.active = 1 AND m.published = 1"
       . " ORDER BY at.date_add DESC"
       . " LIMIT 0,1";

$appel_a_temoins = $db->loadObject($query);



		// r�cup le dernier t�moignage
		$query = "SELECT t.id, t.titre, t.texte, t.user_id, u.username, up.photo_defaut, up.genre"
		." FROM temoignage AS t"
		." INNER JOIN user AS u ON u.id = t.user_id"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." WHERE t.active = 1"
		." ORDER BY t.date_add DESC"
		." LIMIT 0,1"
		;
		$temoignage = $db->loadObject($query);


		HTML_profil::panel($userProfilMini, $userStats, $profilsOnline, $profilsInscrits, $profilsMatching, $genreRecherche, $list, $appel_a_temoins, $temoignage);

	}


	


	// copie les images du r�pertoire d'upload temporaire vers le r�pertoire de l'utilisateur, en ajoutant 'pending-' au d�but du nom de chaque fichier
	function photosSave($photo_type = '', $rmdir = false) {
		global $langue;
		global $db, $user;

		$user_id 			= $user->id ? $user->id : JL::getSessionInt('user_id', 0);
		$dest_dir			= 'images/profil/'.$user_id;
		$photo_a_valider	= 0;

		if($user_id) {

			// cr�ation du dossier utilisateur si besoin est
			if(!is_dir($dest_dir)) {
				mkdir($dest_dir);
				chmod($dest_dir, 0777);
			}

			// r�cup les miniatures de photos d�j� envoy�es
			$dir = 'images/profil/'.JL::getSession('upload_dir', 'error');
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {
					if(preg_match('#^temp.*'.$photo_type.'#', $file)) {
						copy($dir.'/'.$file, $dest_dir.'/'.str_replace('temp-', 'pending-', $file));
						@unlink($dir.'/'.$file);

						/* A NE SURTOUT PAS FAIRE CA ICI !!: je le laisse pour l'exemple
						Car on peut envoyer une photo de l'enfant 1, qui �crasera la photo existante en pending.
						Ainsi, la nouvelle photo sera ajout�e � $photo_a_valider, alors qu'elle �tait d�j� compt�e !

						if(preg_match('#.*109-'.$photo_type.'#', $file)) {
							$photo_a_valider++;
						}
						*/
					}
				}
				closedir($dir_id);
			}

			
			if($dir!=$dest_dir){
				if(is_dir($dest_dir)) {
					$dir_id 	= opendir($dest_dir);
					while($file = trim(readdir($dir_id))) {
						if(preg_match('#^pending.*109-#', $file)) {
							$photo_a_valider++;
						}
					}
					closedir($dir_id);
				}
			}

			// PATCH ANTI PHOTOS FANTOMES: enfin !
			// d�termine le nombre de photos � valider pour cet utilisateur, peu importe le type de photos
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {
					if(preg_match('#^pending.*109-#', $file)) {
						$photo_a_valider++;
					}
				}
				closedir($dir_id);
			}

			if($photo_a_valider > 0) {

				// mise � jour du champ photo_a_valider de l'utilisateur.
				$query = "UPDATE user_stats SET photo_a_valider = ".strval($photo_a_valider)." WHERE user_id = '".$user_id."'";
				$db->query($query);

			}

			// profil uniquement
			if($photo_type == 'profil') {

				// mise � jour de la photo par d�faut.
				$query = "UPDATE user_profil SET photo_defaut = '".intval(JL::getVar('photo_defaut', true))."' WHERE user_id = '".$user_id."'";
				$db->query($query);

			}

			// demande de suppression du dossier d'upload
			if($rmdir) {
				rmdir($dir);
				unset($_SESSION['upload_dir']);
			}

		}

	}


	


	


?>

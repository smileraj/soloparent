<?php

	// MODEL
	defined('JL') or die('Error 401');

	require_once('temoignage.html.php');

	global $db, $user, $action, $langue;

	$messages	= [];
	$temoignage = new stdClass();

	switch($action){
				
		case 'envoyer':
			getData();
			if(checkData()){
				send();
				JL::redirect(SITE_URL.'/index.php?app=temoignage&action=edit&lang='.$_GET["lang"].'&msg=ok');
			}
			
			edit();
		break;
		
		case 'edit':
			getData();
			checkUser();
			edit();
		break;
		
		case 'infos':
			infos();
		break;
		
		case 'lire' : 
			lire((int)JL::getVar('id',1));
		break;
		
		default : 
			listall((int)JL::getVar('page',1));
		break;
	}
	
	
	
	function infos(){
		global $db;
		
		$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from contenu WHERE id = 28";
		$contenu = $db->loadObject($query);
		
		temoignage_HTML::infos($contenu);
		
	}
	
	function listall($page){
		global $db;
		
		
		// variables
		$where			= [];
		
		// WHERE
		$where[]			= "t.active = 1";

		// g&eacute;n&egrave;re le where
		$_where = JL::setWhere($where);
		
		// pagination
		// pagination
		$resultatParPage	= LISTE_RESULT;
		

		// correction au cas o&ugrave; le visiteur s'amuserait avec les params de l'url
		$search['page']		= (int)JL::getVar('page', 1);
		if($search['page'] <= 0) JL::redirect(SITE_URL.'/index.php?app=temoignage&action=listall'.'&'.$langue);
		// r&eacute;cup le total
		
		$query = "SELECT COUNT(*)"
		." FROM temoignage AS t"
		.$_where
		;
		$search['result_total']	= (int)$db->loadResult($query);
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);


		// r&eacute;cup les messages de l'utilisateur log
		$query = "SELECT id, titre, texte, date_add, user_id, username, photo_defaut, genre"
		." FROM"
		." ("
		." SELECT t.id, t.titre, t.texte, t.date_add, t.user_id, u.username, up.photo_defaut, up.genre"
		." FROM temoignage AS t"
		." INNER JOIN user AS u ON u.id = t.user_id"
		." INNER JOIN user_profil AS up ON up.user_id = t.user_id"
		.$_where
		." UNION ALL"
		." SELECT t.id, t.titre, t.texte, t.date_add, t.user_id, us.username, up.photo_defaut = 0, up.genre"
		." FROM temoignage AS t"
		." INNER JOIN user_suppr AS us ON us.id = t.user_id"
		." INNER JOIN user_profil AS up ON up.user_id = t.user_id"
		.$_where
		." ) as xxx"
		." ORDER BY date_add DESC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$temoignages = $db->loadObjectList($query);
		
		temoignage_HTML::listall($temoignages, $search);
		
	}
	
	function lire($id){
		global $db;

		// variables
		$where 		= [];

		$where[]	= "t.id = '".$id."'";
		$where[]	= "t.active = 1";

		// g&eacute;n&egrave;re le where
		$_where = JL::setWhere($where);


		// r&eacute;cup le message de l'utilisateur log
		$query = "SELECT id, titre, texte, date_add, user_id, username, photo_defaut, genre"
		." FROM"
		." ("
		." SELECT t.id, t.titre, t.texte, t.date_add, t.user_id, u.username, up.photo_defaut, up.genre"
		." FROM temoignage AS t"
		." INNER JOIN user AS u ON u.id = t.user_id"
		." INNER JOIN user_profil AS up ON up.user_id = t.user_id"
		.$_where
		." UNION ALL"
		." SELECT t.id, t.titre, t.texte, t.date_add, t.user_id, us.username, up.photo_defaut = 0, up.genre"
		." FROM temoignage AS t"
		." INNER JOIN user_suppr AS us ON us.id = t.user_id"
		." INNER JOIN user_profil AS up ON up.user_id = t.user_id"
		.$_where
		." ) as xxx"
		." LIMIT 0,1"
		;
		$temoignage = $db->loadObject($query);

		temoignage_HTML::lire($temoignage);
	}
	function edit(){
		global $db,$messages,$temoignage;
		include("lang/app_temoignage.".$_GET['lang'].".php");
		
		$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from contenu WHERE id = 111";
		$contenu = $db->loadObject($query);
		
		if(JL::getVar('msg', '') == 'ok'){
			$messages[]	= '<span class="valid">'.$lang_apptemoignage["TemoignageEnvoye"].' !</span>';
		}
		$temoignage->captcha		= random_int(10,99).chr(random_int(65,90)).random_int(10,99).chr(random_int(65,90));
			$temoignage->captchaAbo		= md5(date('m/Y').$temoignage->captcha);
		temoignage_HTML::edit($contenu, $temoignage, $messages);
	}
	
	function getData(){
		global $temoignage;
		$temoignage->titre = JL::getVar('titre', '');
		$temoignage->texte = JL::getVar('texte', '');
		 $temoignage->captchaAbo = JL::getVar('captchaAbo', '');
	     $temoignage->verif = trim(JL::getVar('verif', ''));
	}
	
	function checkData(){
		global $user, $temoignage,$messages;
		include("lang/app_temoignage.".$_GET['lang'].".php");
		
		if(!$user->id) {
			$messages[]	= '<span class="error">'.$lang_apptemoignage["VousDevezEtreConnecte"].' !</span>';
		}
		
		if($temoignage->titre==''){
			$messages[]	= '<span class="error">'.$lang_apptemoignage["VeuillezIndiquerTitre"].' !</span>';
		}
		
		if($temoignage->texte==''){
			$messages[]	= '<span class="error">'.$lang_apptemoignage["VeuillezIndiquerTexte"].' !</span>';
		}
		if($temoignage->verif == '' || md5(date('m/Y').strtoupper((string) $temoignage->verif)) != $temoignage->captchaAbo) {
				$messages[] = '<span class="error">'.$lang_apptemoignage["WarningCodeVerifIncorrect"].'</span>';
			}
		return count($messages) ? false : true;
	}
	
	function checkUser(){
		global $user, $messages;
		include("lang/app_temoignage.".$_GET['lang'].".php");
		
		if(!$user->id) {
			$messages[]	= '<span class="warning">'.$lang_apptemoignage["VousDevezEtreConnecte"].' !</span>';
		}
		
		return count($messages) ? false : true;	
	}
	
	
	
	
	function send(){
		global $db,$messages,$temoignage,$user;
		
		$query = "INSERT INTO temoignage SET"
		." titre = '".$db->escape($temoignage->titre)."',"
		." texte = '".$db->escape($temoignage->texte)."',"
		." user_id = '".$db->escape($user->id)."',"
		." date_add = NOW()"
		;
		$db->query($query);
		
	}
	
?>


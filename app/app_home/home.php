<?php

	// MODEL
	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('home.html.php');
	
	
	global $db, $user, $langue;
	
	if($user->id) {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=panel'.'&'.$langue);
	}
	
	include("lang/app_home.".$_GET['lang'].".php");
		
			
	//*Partie gauche
	
	//***Photos de profil par ordre d&eacute;croissant
	$query = "SELECT u.id, u.username, up.photo_defaut"
	." FROM user AS u"
	." INNER JOIN user_profil AS up ON up.user_id = u.id"
	." INNER JOIN photo_last AS pl ON pl.user_id = u.id"
	." WHERE up.photo_home = 1 AND u.published = 1 AND u.confirmed >= 1 AND pl.photo_name LIKE 'profil%'"
	." GROUP BY u.id"
	." ORDER BY u.creation_date DESC"
	;
	$profils = $db->loadObjectList($query);


	
	//**Inscription
	
	//***Genre
	$list_genre[] = JL::makeOption('', "> ".$lang_apphome["Genre"]);
	$list_genre[] = JL::makeOption('f', $lang_apphome["UneMaman"]);
	$list_genre[] = JL::makeOption('h', $lang_apphome["UnPapa"]);
	$list['genre'] = JL::makeSelectList($list_genre, 'genre', '', 'value', 'text', '');



	//***Date de naissance
	$list_naissance_jour[] = JL::makeOption('0', "".$lang_apphome["JJ"]);
	for($i=1; $i<=31; $i++) {
		$list_naissance_jour[] = JL::makeOption($i, sprintf('%02d', $i));
	}
	$list['naissance_jour'] = JL::makeSelectList( $list_naissance_jour, 'naissance_jour', 'class="size2"', 'value', 'text', '0');

	
	$list_naissance_mois[] = JL::makeOption('0', "".$lang_apphome["MM"]);
	for($i=1; $i<=12; $i++) {
		$list_naissance_mois[] = JL::makeOption($i, sprintf('%02d', $i));
	}
	$list['naissance_mois'] = JL::makeSelectList( $list_naissance_mois, 'naissance_mois', 'class="size2"', 'value', 'text', '0');



	$list_naissance_annee[] = JL::makeOption('0', "".$lang_apphome["AAAA"]);
	for($i=(intval(date('Y'))-18); $i>=1930; $i--) {
		$list_naissance_annee[] = JL::makeOption($i, sprintf('%04d', $i));
	}
	$list['naissance_annee'] = JL::makeSelectList( $list_naissance_annee, 'naissance_annee', 'class="size2"', 'value', 'text', '0');



	//***Nb d'enfants
	for($i=1; $i<=4; $i++) {
		$list_nb_enfants[] = JL::makeOption($i, $i);
	}
	$list_nb_enfants[] = JL::makeOption(5, $lang_apphome["PlusDe4"]);
	$list['nb_enfants'] = JL::makeSelectList($list_nb_enfants, 'nb_enfants', 'class="size4"', 'value', 'text', 1);



	//***Canton
	$list_canton_id[] = JL::makeOption('0', "> ".$lang_apphome["Canton"]);
	$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
	." FROM profil_canton"
	." WHERE published = 1"
	." ORDER BY nom_".$_GET['lang']." ASC"
	;

	$list_canton_id 	= array_merge($list_canton_id, $db->loadObjectList($query));
	$list['canton_id'] 	= JL::makeSelectList( $list_canton_id, 'canton_id', 'id="canton_id" class="size5" onChange="loadVilles();"', 'value', 'text', '0');



	//***Ville
	$list_ville_id[] 	= JL::makeOption('0', "> ".$lang_apphome["Ville"]);
	$list['ville_id']	= JL::makeSelectList( $list_ville_id, 'ville_id', 'id="ville_id" class="size5"', 'value', 'text', '0');
	
	
	// variables
	$where			= array();
	
	// WHERE
	$where[]			= "t.active = 1";

	// g&eacute;n&egrave;re le where
	$_where = JL::setWhere($where);
	
	//**Dernier t&eacute;moignage
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
	." LIMIT 0,1"
	;
	$temoignage = $db->loadObject($query);
	//events
	$query1="select * from events_creations order by id desc LIMIT 0,3";
	$events = $db->loadObjectList($query1);
	//**Descriptif du site 4 box
	$query = "Select id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte, url_".$_GET['lang']." as url  from box WHERE box_emplacement_id = 1 and published = 1";
	$homes_1 = $db->loadObjectList($query);
	
	$num = JL::getSessionInt('box_home1',0) % count($homes_1);
	$home_1 = $homes_1[$num];
	JL::setSession('box_home1',($num+1));
	
	
	$query = "Select id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte, url_".$_GET['lang']." as url  from box WHERE box_emplacement_id = 2 and published = 1";
	$homes_2 = $db->loadObjectList($query);
	
	$num = JL::getSessionInt('box_home2',0) % count($homes_2);
	$home_2 = $homes_2[$num];
	JL::setSession('box_home2',($num+1));
	
	
	$query = "Select id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte, url_".$_GET['lang']." as url  from box WHERE box_emplacement_id = 3 and published = 1";
	$homes_3 = $db->loadObjectList($query);
	
	$num = JL::getSessionInt('box_home3',0) % count($homes_3);
	$home_3 = $homes_3[$num];
	JL::setSession('box_home3',($num+1));
	
	
	$query = "Select id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte, url_".$_GET['lang']." as url  from box WHERE box_emplacement_id = 4 and published = 1";
	$homes_4 = $db->loadObjectList($query);
	
	$num = JL::getSessionInt('box_home4',0) % count($homes_4);
	$home_4 = $homes_4[$num];
	JL::setSession('box_home4',($num+1));
	

	
	//**Partenaires
	$query = "Select id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte, url_".$_GET['lang']." as url  from box WHERE box_emplacement_id = 7 and published = 1";
	$partenaires_1 = $db->loadObjectList($query);
	
    if($partenaires_1) {
        $num = JL::getSessionInt('box_partenaire1',0) % count($partenaires_1);
        $partenaire_1 = $partenaires_1[$num];
        JL::setSession('box_partenaire1',($num+1));    
    }
	
	
		
	//*Partie gauche
	
	
	//**R&eacute;cup les derni&egrave;res actu
	$query = "SELECT id, titre as titre, date_add"
	." FROM actualite"
	." WHERE published = 1"
	." ORDER BY date_add DESC"
	." LIMIT 0, 3"
	;
	$actualites = $db->loadObjectList($query);
	
	
	
	//**Box 2 Menu right
	$query = "Select id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte, url_".$_GET['lang']." as url from box WHERE box_emplacement_id = 6 and published = 1";
	$box_menus_2 = $db->loadObjectList($query);
	
    if(count($box_menus_2) > 0){
        $num = JL::getSessionInt('box_menu2',0) % count($box_menus_2);
        $box_menu_2 = $box_menus_2[$num];
        JL::setSession('box_menu2',($num+1));    
    }
	
    
	//affichage
	home_HTML::home(JL::getVar('auth',''), $profils,  $list, $temoignage, $home_1, $home_2, $home_3, $home_4, $partenaire_1, $actualites, $box_menu_2,$events);
?>


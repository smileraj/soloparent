<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('flbl.html.php');
	include("lang/app_flbl.".$_GET['lang'].".php");

	global $action, $user, $langue;

	// user non log
	if(!$user->id) {
		JL::redirect(SITE_URL.'/index.php?app=profil&action=inscription&'.$langue);
	}


	// gestion des messages d'erreurs
	$messages	= array();


	switch($action) {

		case 'add':
			flblAdd();
		break;

		case 'remove':
			$user_id_to	= (int)JL::getVar('id', 0, true);
			$list_type	= (int)JL::getVar('list_type', 0);
			flblRemove($user_id_to, $list_type);
			JL::redirect(SITE_URL.'/index.php?app=flbl&action=list&list_type='.$list_type.'&removed='.$user_id_to.'&'.$langue);
		break;

		case 'save':
			$added = flblSave();
			JL::redirect(SITE_URL.'/index.php?app=flbl&action=list&list_type='.(int)JL::getVar('list_type', 0).'&added='.$added.'&'.$langue);
		break;

		case 'list':
			flblList((int)JL::getVar('list_type', 0));
		break;

		default:
			JL::loadApp('404');
		break;

	}

	function &flbl_data() {
		global $langue;
		$_data	= array(
				'username' 		=> '',
				'user_id_to' 	=> '',
				'description' 	=> '',
				'list_type' 	=> ''
			);
		return $_data;
	}

	function flblList($list_type) {
		global $langue;
		include("lang/app_flbl.".$_GET['lang'].".php");
		global $db, $user, $messages;

		// variables
		$where 		= array();
		$_where		= '';

		$where[]	= "uf.list_type = '".($list_type > 0 ? 1 : 0)."'";
		$where[]	= "uf.user_id_from = '".$user->id."'";
		$where[]	= "u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to = ".$user->id." AND list_type=0)";

		if (is_array($where)) {
			$_where = " WHERE ".implode(" AND ", $where);
		}

		// r&eacute;cup les users en friend/black list
		$query = "SELECT u.id, u.username, uf.description, uf.datetime_add, up.genre, up.photo_defaut, ((YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5))) AS age, pc.abreviation AS canton_abrev, up.nb_enfants, (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) AS last_online_time, u.online"
		." FROM user_flbl AS uf"
		." INNER JOIN user AS u ON u.id = uf.user_id_to"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		.$_where
		." ORDER BY u.username ASC"
		;
		$rows = $db->loadObjectList($query);

		// messages de confirmation
		$added		= (int)JL::getVar('added', 0, true); 	// id de l'utilisateur ajout&eacute; &agrave; $list_type
		$removed	= (int)JL::getVar('removed', 0, true); 	// id de l'utilisateur retir&eacute; de $list_type

		if($added || $removed) {

			// utilisateur cibl&eacute;
			$user_id	= $added ? $added : $removed;

			// r&eacute;cup le pseudo de l'utilisateur
			$query = "SELECT u.username, up.genre"
			." FROM user AS u"
			." INNER JOIN user_profil AS up ON up.user_id = u.id"
			." WHERE u.id = '".$user_id."' AND u.gid = 0"
			." LIMIT 0,1"
			;
			$userObj = $db->loadObject($query);
			if($userObj) {
				if($added > 0) {
					if($list_type == 1){
						$userAction = $lang_flbl["AjoutFavorisReussi"];
					}else{
						$userAction = $lang_flbl["AjoutListeNoireReussi"];
					}
				}else{
					if($list_type ==1){
						$userAction = $lang_flbl["RetraitFavorisReussi"];
					}else{
						$userAction = $lang_flbl["RetraitListeNoireReussi"];
					}
				}

				$messages[]	= '<span class="valid">'.$userAction.' !</span>';

			} else {

				$messages[]	= '<span class="valid">'.$lang_flbl["ProfilIntrouvabe"].' !</span>';

			}

		}

		// affiche la liste des messages
		HTML_flbl::flblList($rows, $messages, $list_type);

	}


	// ajoute un utilisateur &agrave; la fl/bl de l'utilisateur log
	function flblAdd() {
		global $langue;
		global $db, $messages, $user;

		// r&eacute;cup les donn&eacute;es du formulaire
		$row	= new stdClass();
		$_data 	=& flbl_data();

		foreach($_data as $k => $v) {
			$row->{$k}		= JL::getVar($k, $v, true);
		}

		// check si l'utilisateur cible existe
		$query = "SELECT u.id, u.username, up.genre, up.nb_enfants, up.photo_defaut, ((YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5))) AS age, IFNULL(pc.nom_".$_GET['lang'].", '') AS canton"
		." FROM user AS u"
		." INNER JOIN user_profil AS up ON up.user_id = u.id"
		." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
		." WHERE u.id = '".$row->user_id_to."' AND u.gid = 0"
		." LIMIT 0,1"
		;
		$user_to = $db->loadObject($query);

		// si l'utilisateur existe
		if($user_to->id) {

			// v&eacute;rifie si l'utilisateur cible est d&eacute;j&agrave; dans la FL/BL
			$query = "SELECT user_id_to, list_type, description"
			." FROM user_flbl"
			." WHERE user_id_from = '".$user->id."' AND list_type = '".$row->list_type."' AND user_id_to = '".$row->user_id_to."'"
			." LIMIT 0,1"
			;
			$flbl	= $db->loadObject($query);

			// si d&eacute;j&agrave; dans la flbl
			if($flbl->user_id_to) {
				$row->list_type		= $flbl->list_type;
				$row->description	= $flbl->description;
			}

			// que l'utilisateur soit ou non en flbl
			$row->user_id_to		= $row->user_id_to;
			$row->username			= $user_to->username;
			$row->photo_defaut	= $user_to->photo_defaut;
			$row->genre				= $user_to->genre;
			$row->age					= $user_to->age;
			$row->canton				= $user_to->canton;
			$row->nb_enfants		= $user_to->nb_enfants;

			// affiche la liste des messages
			HTML_flbl::flblAdd($row, $messages);

		} else {

			// redirection sur page d'erreur d'ajout
			JL::redirect(SITE_URL.'/index.php?app=flbl&action=list&added='.$user_id_to.'&'.$langue);

		}

	}


	// ajoute un utilisateur &agrave; la fl/bl de l'utilisateur log
	function flblSave() {
		global $langue;
		global $db, $user;

		// r&eacute;cup les donn&eacute;es du formulaire
		$_data 	=& flbl_data();
		$row	= new stdClass();
		foreach($_data as $k => $v) {
			$row->{$k}	= JL::getVar($k, $v, true);
		}

		if($row->user_id_to) {

			// supprime l'enregistrement existant (permet de passer de BL &agrave; FL et inversement &agrave; coup s&ucirc;r)
			$query = "DELETE FROM user_flbl WHERE user_id_to = '".(int)$row->user_id_to."' AND user_id_from = '".$user->id."'";
			$db->query($query);

			// enregistrement
			$query = "INSERT INTO user_flbl SET"
			." user_id_from = '".$user->id."',"
			." user_id_to = '".(int)$row->user_id_to."',"
			." list_type = '".$row->list_type."',"
			." description = '".$row->description."',"
			." datetime_add = NOW()"
			;
			$db->query($query);

		}

		return $row->user_id_to;

	}

	function flblRemove($user_id_to, $list_type) {
			global $langue;
		global $db, $user;

		// supprime l'enregistrement existant
		$query = "DELETE FROM user_flbl WHERE user_id_to = '".(int)$user_id_to."' AND user_id_from = '".$user->id."' AND list_type = '".$list_type."'";
		$db->query($query);

	}

?>

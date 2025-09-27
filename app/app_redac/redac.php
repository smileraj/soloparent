<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	require_once('redac.html.php');

	global $action, $langue, $langString;
	if($_GET["lang"]=='fr')
		$langString = "";
	else
		$langString = "_".$_GET[lang];

	switch($action) {

		case 'item':
		contenuAfficher();
		break;

		default:
		JL::loadApp('404');
		break;

	}


	// affiche un contenu pass&eacute; en param $id
	function contenuAfficher() {
		global $langue;
		global $langString;
		global $db;

		$id = intval(JL::getVar('id', 0));

		$where	= array();
		$_where	= '';

		$where[]	= "c.id = ".$id;		// contenu
		$where[]	= "c.published = 1";	// contenu published

		// g&eacute;n&eacute;ration de la clause where
		if (is_array($where)) {
			$_where		= " WHERE ".implode(' AND ', $where);
		}

		// r&eacute;cup le contenu
		$query = "SELECT c.id, c.titre, c.texte, c.date_add, c.type_id"
		." FROM contenu".$langString." AS c"
		.$_where
		." LIMIT 0,1"
		;
		$contenu	= $db->loadObject($query);

		// si l'article n'existe pas en allemand voir en fr
		if(!$contenu->id) {

			// erreur 404
			$query = "SELECT c.id, c.titre, c.texte, c.date_add, c.type_id"
			." FROM contenu AS c"
			.$_where
			." LIMIT 0,1"
			;
			$contenu	= $db->loadObject($query);

		}

		// si l'article n'existe pas
		if(!$contenu->id) {

			// erreur 404
			JL::loadApp('404');

		} else {

			// communiqu&eacute; de presse
			if($contenu->id == 27) {

				// variables
				$facteurMytho = 1.1; // coef multiplicateur du nombre de membres

				// r&eacute;cup le nombre d'inscrits, peu importe leur statut 'active'
				$query = "SELECT COUNT(*) FROM user WHERE gid = 0";
				$membres = $db->loadResult($query);

				$contenu->texte = str_replace('[[membres]]', round(($membres * $facteurMytho)/100)*100, $contenu->texte);

			}

			// sinon on affiche l'article
			redac_HTML::contenuAfficher($contenu);

		}

	}

?>

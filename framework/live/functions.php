<?php

	// class regroupant des fonctions partagées entre plusieures composants (méthode has been issue de joomla 1.0)
	class FCT {

		// génère les champs du moteur de recherche
		function &getSearchEngine($search_nb_enfants = 0, $search_recherche_age_min = 18, $search_recherche_age_max = 70, $search_canton_id = 0, $search_ville_id = 0, $search_username = '', $search_online = 0, $search_titre = '') {
			include("lang/app_framework.".$_GET['lang'].".php");
			global $db, $user, $langue, $langString;


			// variables
			$list	= array();

			// nombre d'enfants
			for($i=1; $i<=4; $i++) {
				$list_nb_enfants[] = JL::makeOption($i, $i.' '.$lang_framework["OuPlus"].'');
			}
			$list_nb_enfants[] = JL::makeOption(5, ''.$lang_framework["PlusDe4"].'');
			$list['search_nb_enfants'] = JL::makeSelectList( $list_nb_enfants, 'search_nb_enfants', 'class="enfants"', 'value', 'text', $search_nb_enfants);


			// recherche âge mini
			$list_recherche_age_min[] = JL::makeOption('0', '--');
			for($i=18; $i<=(intval(date('Y'))-1930); $i++) {
				$list_recherche_age_min[] = JL::makeOption($i, $i);
			}
			$list['search_recherche_age_min'] = JL::makeSelectList( $list_recherche_age_min, 'search_recherche_age_min', 'class="age"', 'value', 'text', $search_recherche_age_min);

			$list_recherche_age_max[] = JL::makeOption('0', '--');
			for($i=18; $i<=(intval(date('Y'))-1930); $i++) {
				$list_recherche_age_max[] = JL::makeOption($i, $i);
			}
			$list['search_recherche_age_max'] = JL::makeSelectList( $list_recherche_age_max, 'search_recherche_age_max', 'class="age"', 'value', 'text', $search_recherche_age_max);


			// canton
			$list_canton_id[] = JL::makeOption('0', '> '.$lang_framework["Canton"]);
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_canton"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;

			$list_canton_id = array_merge($list_canton_id, $db->loadObjectList($query));
			$list['search_canton_id'] 	= JL::makeSelectList( $list_canton_id, 'search_canton_id', 'id="search_canton_id" onChange="loadVilles(\'search_\');"', 'value', 'text', $search_canton_id);
			$list['search_ville_id']	= '<input type="hidden" id="search_ville_id" name="search_ville_id" value="'.$search_ville_id.'" />';

			$list['search_username']	= $search_username;
			$list['search_online']		= $search_online;

			// user log
			if($user->id) {

				// récup le genre de l'utilisateur
				$query = "SELECT genre FROM user_profil WHERE user_id = '".$user->id."' LIMIT 0,1";
				$genre = $db->loadResult($query);

			} else { // user en corus d'inscription

				$genre = JL::getSession('genre', '', true);

			}

			// si c'est un homme
			if($genre == 'h') {

				$list['search_genre']	= '<span class="femme">'.$lang_framework["UneMaman"].'</span>';

			} else { // sinon si c'est une femme

				$list['search_genre']	= '<span class="homme">'.$lang_framework["UnPapa"].'</span>';

			}

			$list['search_titre']		= $search_titre;

			return $list;

		}

	}

?>

<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class homeModel extends JLModel {
	
	
		function __construct() {
			//$this->_messages = JL::getMessages();
		}
		
		function display(){
			include("lang/app_home.".$_GET['lang'].".php");
			global $db;
			
			
			
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
			$this->profils = $db->loadObjectList($query);


			
			//**Inscription
			
			//***Genre
			$list_genre[] = JL::makeOption('', "> ".$lang_apphome["Genre"]);
			$list_genre[] = JL::makeOption('f', $lang_apphome["UneFemme"]);
			$list_genre[] = JL::makeOption('h', $lang_apphome["UnHomme"]);
			$this->list['genre'] = JL::makeSelectList($list_genre, 'genre', '', 'value', 'text', '');



			//***Date de naissance
			$list_naissance_jour[] = JL::makeOption('0', "> ".$lang_apphome["JJ"]);
			for($i=1; $i<=31; $i++) {
				$list_naissance_jour[] = JL::makeOption($i, sprintf('%02d', $i));
			}
			$this->list['naissance_jour'] = JL::makeSelectList( $list_naissance_jour, 'naissance_jour', 'class="size2"', 'value', 'text', '0');

			
			$list_naissance_mois[] = JL::makeOption('0', "> ".$lang_apphome["MM"]);
			for($i=1; $i<=12; $i++) {
				$list_naissance_mois[] = JL::makeOption($i, sprintf('%02d', $i));
			}
			$this->list['naissance_mois'] = JL::makeSelectList( $list_naissance_mois, 'naissance_mois', 'class="size2"', 'value', 'text', '0');

		
		
			$list_naissance_annee[] = JL::makeOption('0', "> ".$lang_apphome["AAAA"]);
			for($i=(intval(date('Y'))-18); $i>=1930; $i--) {
				$list_naissance_annee[] = JL::makeOption($i, sprintf('%04d', $i));
			}
			$this->list['naissance_annee'] = JL::makeSelectList( $list_naissance_annee, 'naissance_annee', 'class="size2"', 'value', 'text', '0');



			//***Nb d'enfants
			for($i=1; $i<=4; $i++) {
				$list_nb_enfants[] = JL::makeOption($i, $i);
			}
			$list_nb_enfants[] = JL::makeOption(5, $lang_apphome["PlusDe4"]);
			$this->list['nb_enfants'] = JL::makeSelectList($list_nb_enfants, 'nb_enfants', 'class="size4"', 'value', 'text', 1);



			//***Canton
			$list_canton_id[] = JL::makeOption('0', "> ".$lang_apphome["Canton"]);
			$query = "SELECT id AS value, nom_".$_GET['lang']." AS text"
			." FROM profil_canton"
			." WHERE published = 1"
			." ORDER BY nom_".$_GET['lang']." ASC"
			;

			$list_canton_id 	= array_merge($list_canton_id, $db->loadObjectList($query));
			$this->list['canton_id'] 	= JL::makeSelectList( $list_canton_id, 'canton_id', 'id="canton_id" class="size5" onChange="loadVilles();"', 'value', 'text', '0');



			//***Ville
			$list_ville_id[] 	= JL::makeOption('0', "> ".$lang_apphome["Ville"]);
			$this->list['ville_id']	= JL::makeSelectList( $list_ville_id, 'ville_id', 'id="ville_id" class="size5"', 'value', 'text', '0');
			
			
			
			
			//**Descriptif du site 3 box
			$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from home WHERE id = 2";
			$this->colonne_1 = $db->loadObject($query);
			
			
			$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from home WHERE id = 4";
			$this->colonne_2 = $db->loadObject($query);
			
			
			$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from home WHERE id = 3";
			$this->colonne_3 = $db->loadObject($query);
			
			
			
			//**Partenaire One fm et LFM
			$num = JL::getSessionInt('partenaire_l',0) % 2;
			
			if($num == 0)
				$id_partenaire_l = 5;
			else
				$id_partenaire_l = 6;
				
			//colonne 4
			$query = "Select id, titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from home WHERE id =  '".$db->escape($id_partenaire_l)."'";
			$this->partenaire_l = $db->loadObject($query);
			
			JL::setSession('partenaire_l',($num+1));
			
			
			
			
			
			
			//*Partie gauche
			
			
			//**R&eacute;cup les derni&egrave;res actu
			$query = "SELECT id, titre as titre, date_add"
			." FROM actualite"
			." WHERE published = 1"
			." ORDER BY date_add DESC"
			." LIMIT 0, 3"
			;
			$this->actualites = $db->loadObjectList($query);
			
			
			
			//**R&eacute;cup&egrave;re les donn&eacute;es sur Babybook
			$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from home WHERE id =  1";
			$this->partenaire_r = $db->loadObject($query);
			
			
			

		}
		
		
		
	}
?>


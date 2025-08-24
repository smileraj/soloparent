<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class temoignageModel extends JLModel {
	
	
		function temoignageModel() {
			parent::JLModel();
			//$this->_messages = JL::getMessages();
			$this->pagination = new JLPagination(CONTENU_PAGINATION_RAYON);
		}
		
		function infos(){
			global $db;
			
			$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from contenu WHERE id = 28";
			$this->contenu = $db->loadObject($query);
			
		}
		
		function listall($page){
			global $db;
			
			// variables
			$where			= array();
			
			// WHERE
			$where[]			= "t.active = 1";

			// génère le where
			$_where = JL::setWhere($where);
			
			// pagination
			$this->pagination->setPage($page);


			// récup le total
			
			$query = "SELECT COUNT(*)"
			." FROM temoignage AS t"
			.$_where
			;
			
			$this->pagination->setPageTotal($db->loadResult($query), LISTE_RESULT);
				
			// vérifie que la page demandée existe
			if($this->pagination->page < 0 || $this->pagination->page > $this->pagination->pageTotal) {
				return false;
			}
			
			// construit le tableau contenant la liste des pages
			$this->pagination->setPageList();


			// récup les messages de l'utilisateur log
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
			." LIMIT ".$this->pagination->getLimit()
			;
			$this->temoignages = $db->loadObjectList($query);
			
		}
		
		function lire($id){
			global $db;

			// variables
			$where 		= array();

			$where[]	= "t.id = '".$id."'";
			$where[]	= "t.active = 1";

			// génère le where
			$_where = JL::setWhere($where);


			// récup le message de l'utilisateur log
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
			$this->temoignage = $db->loadObject($query);

		}
		
		function getData(){
			
			$this->temoignage = new stdClass();
			
			$this->temoignage->titre = JL::getVar('titre', '');
			$this->temoignage->texte = JL::getVar('texte', '');
			
		}
		
		function checkData(){
			global $user;
			include("lang/app_temoignage.".$_GET['lang'].".php");
			
			if(!$user->id) {
				$this->_messages[]	= '<span class="warning">'.$lang_apptemoignage["VousDevezEtreConnecte"].' !</span>';
			}
			
			if($this->temoignage->titre==''){
				$this->_messages[]	= '<span class="warning">'.$lang_apptemoignage["VeuillezIndiquerTitre"].' !</span>';
			}
			
			if($this->temoignage->texte==''){
				$this->_messages[]	= '<span class="warning">'.$lang_apptemoignage["VeuillezIndiquerTexte"].' !</span>';
			}
			
			return count($this->_messages) ? false : true;
		}
		
		function checkUser(){
			global $user;
			include("lang/app_temoignage.".$_GET['lang'].".php");
			
			if(!$user->id) {
				$this->_messages[]	= '<span class="warning">'.$lang_apptemoignage["VousDevezEtreConnecte"].' !</span>';
			}
			
			return count($this->_messages) ? false : true;	
		}
		
		function edit(){
			global $db;
			
			$query = "Select titre_".$_GET['lang']." as titre, texte_".$_GET['lang']." as texte from contenu WHERE id = 111";
			$this->contenu = $db->loadObject($query);
			
		}
		
		
		
		
		
		
	}
?>


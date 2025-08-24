<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('mailing.html.php');
	
	global $action;
	
	
	// variables
	$messages = array();

	switch($action) {
	
		case 'envoyer':
			mailingSend();
		break;
		
		case 'save':
			mailingSave();
		break;
		
		case 'edit':
			mailingEdit();
		break;
		
		case 'apercu':
			mailingApercu();
		break;
		
		default:
			mailingLister();
		break;
		
	}
	
	
	function &getData() {
		
		$data = new StdClass();
		
		// params
		$data->id 				= JL::getVar('id', 0);
		$data->nom 				= JL::getVar('nom', '');
		$data->commentaire 		= JL::getVar('commentaire', '');
		$data->titre 			= JL::getVar('titre', '');
		$data->texte 			= JL::getVar('texte', '');
		$data->template 		= JL::getVar('template', '_defaut');
		
		return $data;
		
	}
	
	
	function mailingSend() {
		global $db;
		
		// params
		$id 	= JL::getVar('id', 0);
		
		// récup le mailing
		$query = "SELECT *"
		." FROM mailing"
		." WHERE id = '".$id."'"
		." LIMIT 0,1"
		;
		
		$mailing	= $db->loadObject($query);
		
		// variables
		$listGroups 	= array();
		$listGroups[] 	= JL::makeOption('0', '- Tous -', 'id', 'nom');
		$listGroups[]	= JL::makeOption('1', 'Hommes', 'id', 'nom');
		$listGroups[]	= JL::makeOption('2', 'Femmes', 'id', 'nom');
		$listGroups[]	= JL::makeOption('3', 'Français', 'id', 'nom');
		$listGroups[]	= JL::makeOption('4', 'Anglais', 'id', 'nom');
		$listGroups[]	= JL::makeOption('5', 'Allemand', 'id', 'nom');
		
		$list['group_id'] = JL::makeSelectList($listGroups, 'group_id', 'id="group_id" onChange="javascript:rechercheDestinataires();"', 'id', 'nom', 0);
		
		if(!$mailing->id) {
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=mailing');
		}
		
		HTML_mailing::mailingSend($mailing, $list);
		
	}
	
	
	function mailingEdit() {
		global $db, $messages, $action;
		
		// params
		$id 	= JL::getVar('id', 0);
		
		// message de confirmation de sauvegarde
		if(JL::getVar('save', 0)) {
			$messages[] = '<span class="valid">Enregistrement effectu&eacute; !</span>';
		}
		
		
		// nouveau ou enregistrement/erreur
		if(!$id || $action == 'save') {
			
			$mailing		=& getData();
			
		} else {
			
			// récup le mailing
			$query = "SELECT *"
			." FROM mailing"
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			
			$mailing	= $db->loadObject($query);
			
		}
		
		
		// parcourt le dossier des templates et récup les fichiers
		$dir = SITE_PATH_ADMIN.'/app/app_mailing/template';
		if(is_dir($dir)) {
		
			$dir_id 	= opendir($dir);
			while($file = trim(readdir($dir_id))) {
			
				// récup les miniatures de photos valides
				if(preg_match('/\.html$/', $file)) {
					
					$listTemplate[] = JL::makeOption($file, str_replace('.html', '', $file), 'value', 'text');
					
				}
			
			}
		
		}
		
		// réordonne le tableau par ordre alphabétique
		sort($listTemplate);
		
		// génère la liste déroulante
		$list['template'] = JL::makeSelectList($listTemplate, 'template', 'id="template"', 'value', 'text', $mailing->template);
		
		
		HTML_mailing::mailingEdit($mailing, $list, $messages);
		
	}
	
	
	// liste les mailings
	function mailingLister() {
		global $db, $messages;
		
		// variables
		$resultatParPage	= RESULTS_NB_LISTE_ADMIN;
		$search				= array();
		
		// si on passe une recherche en param, alors on force la page 1 (pour éviter de charger la page 36, s'il n'y a que 2 pages à voir)
		$search['page']			= JL::getVar('search_at_page', JL::getSessionInt('search_at_page', 1));
		
		// compte le nombre de résultats
		$query = "SELECT COUNT(*)"
		." FROM mailing AS m"
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		// recherche des données
		$query = "SELECT m.id, m.nom, m.datetime_update"
		." FROM mailing AS m"
		." ORDER BY m.datetime_update DESC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$results	= $db->loadObjectList($query);
		
		HTML_mailing::mailingLister($results, $search, $messages);
		
	}
	
	
	function mailingSave() {
		global $db, $user, $messages;
		
		// récup les données
		$data 		= getData();
		
		if($data->nom == '') {
			$messages[]	= '<span class="error">Veuillez indiquer le nom du mailing.</span>';
		}
		
		if($data->titre == '') {
			$messages[]	= '<span class="error">Veuillez indiquer le titre du mail.</span>';
		}
		
		if(strlen(html_entity_decode($data->texte)) < 10) {
			$messages[]	= '<span class="error">Veuillez indiquer le texte du mail (mini 10 caract&egrave;res).</span>';
		}

		
		// pas d'erreur
		if(!count($messages)) {
			
			// update
			if($data->id) {
			
				$query = "UPDATE mailing SET";
			
			} else { // insert
			
				$query = "INSERT INTO mailing SET";
			
			}
			
			
			// partie commune
			$query .= " datetime_update = NOW(),";
			$query .= " nom = '".$db->escape($data->nom)."',";
			$query .= " commentaire = '".$db->escape($data->commentaire)."',";
			$query .= " template = '".$db->escape($data->template)."',";
			$query .= " titre = '".$db->escape($data->titre)."',";
			$query .= " texte = '".$db->escape($data->texte)."'";
			
			
			// update
			if($data->id) {
			
				$query .= " WHERE id = '".$db->escape($data->id)."'";
				
			}
			
			// exécute la requête
			$db->query($query);
			
			
			// récup l'id généré en cas d'insertion
			if(!$data->id) {
				$data->id = $db->insert_id();
			}
			
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=mailing&action=edit&id='.$data->id.'&save=1');
			
		}
		
		HTML_mailing::mailingEdit($data, $list, $messages);
		
	}
	
	function mailingApercu(){
		global $db;
		
		// params
		$id 	= JL::getVar('id', 0);
		
		// récup le mailing
		$query = "SELECT *"
		." FROM mailing"
		." WHERE id = '".$id."'"
		." LIMIT 0,1"
		;
		
		$mailing	= $db->loadObject($query);
		
		if(!$mailing->id) {
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=mailing');
		}
		
		HTML_mailing::mailingApercu($mailing);
	}
	
?>

<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('mailing_auto.html.php');
	require_once('mailing_auto.function.php');
	
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
		
		$data 								= new StdClass();
		
		// params
		$data->id 							= JL::getVar('id', 0);
		$data->nom 							= JL::getVar('nom', '');
		$data->description 					= JL::getVar('description', '');
		
		$data->template 					= JL::getVar('template', '_defaut');
		$data->sujet 						= JL::getVar('sujet', '');
		
		$data->pub_medium_rectangle 		= JL::getVar('pub_medium_rectangle', '');
		$data->active_pub_medium_rectangle 	= JL::getVar('active_pub_medium_rectangle', 0);
		$data->pub_leaderboard 				= JL::getVar('pub_leaderboard', '');
		$data->active_pub_leaderboard 		= JL::getVar('active_pub_leaderboard', 0);
		
		$data->titre_actu_ps 				= JL::getVar('titre_actu_ps', '');
		$data->texte_actu_ps 				= JL::getVar('texte_actu_ps', '');
		$data->lien_actu_ps 				= JL::getVar('lien_actu_ps', '');
		$data->active_actu_ps 				= JL::getVar('active_actu_ps', 0);
		
		$data->titre_news_publi 			= JL::getVar('titre_news_publi', '');
		$data->texte_news_publi 			= JL::getVar('texte_news_publi', '');
		$data->lien_news_publi 				= JL::getVar('lien_news_publi', '');
		$data->active_news_publi 			= JL::getVar('active_news_publi', 0);
		
		$data->active_agendas		 				= JL::getVar('active_agendas', 0);
		
		$data->agenda1_titre 				= JL::getVar('agenda1_titre', '');
		$data->agenda1_date 				= JL::getVar('agenda1_date', '');
		$data->agenda1_lieu 				= JL::getVar('agenda1_lieu', '');
		$data->agenda1_image 				= JL::getVar('agenda1_image', '');
		$data->agenda1_intro 				= JL::getVar('agenda1_intro', '');
		$data->agenda1_lien 				= JL::getVar('agenda1_lien', '');
		
		$data->agenda2_titre 				= JL::getVar('agenda2_titre', '');
		$data->agenda2_date 				= JL::getVar('agenda2_date', '');
		$data->agenda2_lieu 				= JL::getVar('agenda2_lieu', '');
		$data->agenda2_image 				= JL::getVar('agenda2_image', '');
		$data->agenda2_intro 				= JL::getVar('agenda2_intro', '');
		$data->agenda2_lien 				= JL::getVar('agenda2_lien', '');
		
		$data->upload_dir 					= JL::getVar('upload_dir', '');
		
		return $data;
		
	}
	
	
	function mailingSend() {
		global $db;
		
		// params
		$id 	= JL::getVar('id', 0);
		
		// récup le mailing
		$query = "SELECT *"
		." FROM mailing_auto"
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
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=mailing_auto');
		}
		
		HTML_mailing_auto::mailingSend($mailing, $list);
		
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
			." FROM mailing_auto"
			." WHERE id = '".$id."'"
			." LIMIT 0,1"
			;
			
			$mailing	= $db->loadObject($query);
			
		}
		
		
		// parcourt le dossier des templates et récup les fichiers
		$dir = SITE_PATH_ADMIN.'/app/app_mailing_auto/template';
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
		
		// dossier d'upload des photos
		$mailing->upload_dir = JL::getUploadDir('../images/mailing_auto', $mailing->id);
		
		HTML_mailing_auto::mailingEdit($mailing, $list, $messages);
		
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
		." FROM mailing_auto AS m"
		;
		$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
		
		
		// recherche des données
		$query = "SELECT m.id, m.nom, m.datetime_update"
		." FROM mailing_auto AS m"
		." ORDER BY m.datetime_update DESC"
		." LIMIT ".(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage
		;
		$results	= $db->loadObjectList($query);
		
		HTML_mailing_auto::mailingLister($results, $search, $messages);
		
	}
	
	
	function mailingSave() {
		global $db, $user, $messages;
		
		// récup les données
		$data 		= getData();
		
		//mailing et informations
		if($data->nom == '') {
			$messages[]	= '<span class="error">Veuillez indiquer le nom du mailing.</span>';
		}
		
		if($data->sujet == '') {
			$messages[]	= '<span class="error">Veuillez indiquer le sujet du mail.</span>';
		}
		
		//pubs
		if($data->active_pub_medium_rectangle) {
			if($data->pub_medium_rectangle == '')
				$messages[]	= '<span class="error">Veuillez indiquer le code de la pub medium rectangle.</span>';
		}
		
		if($data->active_pub_leaderboard) {
			if($data->pub_leaderboard == '')
				$messages[]	= '<span class="error">Veuillez indiquer le code de la pub leaderboard.</span>';
		}
		
		//actualité parentsolo
		if($data->active_actu_ps) {
			if($data->titre_actu_ps == '')
				$messages[]	= '<span class="error">Veuillez indiquer le titre de l\'actualit&eacute; Parentsolo.</span>';
				
			if($data->texte_actu_ps == '')
				$messages[]	= '<span class="error">Veuillez indiquer le texte de l\'actualit&eacute;Parentsolo.</span>';
		}
		
		//news publi
		if($data->active_news_publi) {
			if($data->titre_news_publi == '')
				$messages[]	= '<span class="error">Veuillez indiquer le titre de la news publi.</span>';
				
			if($data->texte_news_publi == '')
				$messages[]	= '<span class="error">Veuillez indiquer le texte de la news publi.</span>';
		}
		
		//Agendas
		if($data->active_agendas) {
			//agenda 1
			if($data->agenda1_titre == '') {
				$messages[]	= '<span class="error">Veuillez indiquer le titre du 1er agenda Babybook.</span>';
			}
			
			if(!preg_match('/^[0-9]{2}[\/][0-9]{2}[\/][0-9]{4}$/', $data->agenda1_date)&&!preg_match('/^[0-9]{2}[\/][0-9]{2}[\/][0-9]{4}[-][0-9]{2}[\/][0-9]{2}[\/][0-9]{4}$/', $data->agenda1_date)) {
				$messages[]	= '<span class="error">Veuillez indiquer la date du 1er agenda Babybook.</span>';
			}
			
			if($data->agenda1_lieu == '') {
				$messages[]	= '<span class="error">Veuillez indiquer le lieu du 1er agenda Babybook.</span>';
			}
			
			if($data->agenda1_image == '') {
				$messages[]	= '<span class="error">Veuillez indiquer le chemin sur le site Babybook de l\'image du 1er agenda Babybook.</span>';
			}
			
			if($data->agenda1_intro == '') {
				$messages[]	= '<span class="error">Veuillez indiquer l\'introduction du 1er agenda Babybook.</span>';
			}
			
			if($data->agenda1_lien == '') {
				$messages[]	= '<span class="error">Veuillez indiquer le lien sur le site Babybook du 1er agenda Babybook.</span>';
			}
			
			//agenda 2
			if($data->agenda2_titre == '') {
				$messages[]	= '<span class="error">Veuillez indiquer le titre du 2e agenda Babybook.</span>';
			}
			
			if(!preg_match('/^[0-9]{2}[\/][0-9]{2}[\/][0-9]{4}$/', $data->agenda2_date)&&!preg_match('/^[0-9]{2}[\/][0-9]{2}[\/][0-9]{4}[-][0-9]{2}[\/][0-9]{2}[\/][0-9]{4}$/', $data->agenda2_date)) {
				$messages[]	= '<span class="error">Veuillez indiquer la date du 2e agenda Babybook.</span>';
			}
			
			if($data->agenda2_lieu == '') {
				$messages[]	= '<span class="error">Veuillez indiquer le lieu du 2e agenda Babybook.</span>';
			}
			
			if($data->agenda2_image == '') {
				$messages[]	= '<span class="error">Veuillez indiquer le chemin sur le site Babybook de l\'image du 2e agenda Babybook.</span>';
			}
			
			if($data->agenda2_intro == '') {
				$messages[]	= '<span class="error">Veuillez indiquer l\'introduction du 2e agenda Babybook.</span>';
			}
			
			if($data->agenda2_lien == '') {
				$messages[]	= '<span class="error">Veuillez indiquer le lien sur le site Babybook du 2e agenda Babybook.</span>';
			}
		}
		
		// pas d'erreur
		if(!count($messages)) {
			
			// update
			if($data->id) {
			
				$query = "UPDATE mailing_auto SET";
				$query .= " datetime_update = NOW(),";
				
				
			
			} else { // insert
			
				$query = "INSERT INTO mailing_auto SET";
				$query .= " datetime_creation = NOW(),";
				$query .= " datetime_update = NOW(),";
			
			}
			
			
			// partie commune
			$query .= " nom = '".$db->escape($data->nom)."',";
			$query .= " description = '".$db->escape($data->description)."',";
			$query .= " sujet = '".$db->escape($data->sujet)."',";
			$query .= " titre_actu_ps = '".$db->escape($data->titre_actu_ps)."',";
			$query .= " texte_actu_ps = '".$db->escape($data->texte_actu_ps)."',";
			$query .= " lien_actu_ps = '".$db->escape($data->lien_actu_ps)."',";
			$query .= " active_actu_ps = '".$db->escape($data->active_actu_ps)."',";
			$query .= " titre_news_publi = '".$db->escape($data->titre_news_publi)."',";
			$query .= " texte_news_publi = '".$db->escape($data->texte_news_publi)."',";
			$query .= " lien_news_publi = '".$db->escape($data->lien_news_publi)."',";
			$query .= " active_news_publi = '".$db->escape($data->active_news_publi)."',";
			$query .= " active_agendas = '".$db->escape($data->active_agendas)."',";
			$query .= " agenda1_titre = '".$db->escape($data->agenda1_titre)."',";
			$query .= " agenda1_date = '".$db->escape($data->agenda1_date)."',";
			$query .= " agenda1_lieu = '".$db->escape($data->agenda1_lieu)."',";
			$query .= " agenda1_image = '".$db->escape($data->agenda1_image)."',";
			$query .= " agenda1_intro = '".$db->escape($data->agenda1_intro)."',";
			$query .= " agenda1_lien = '".$db->escape($data->agenda1_lien)."',";
			$query .= " agenda2_titre = '".$db->escape($data->agenda2_titre)."',";
			$query .= " agenda2_date = '".$db->escape($data->agenda2_date)."',";
			$query .= " agenda2_lieu = '".$db->escape($data->agenda2_lieu)."',";
			$query .= " agenda2_image = '".$db->escape($data->agenda2_image)."',";
			$query .= " agenda2_intro = '".$db->escape($data->agenda2_intro)."',";
			$query .= " agenda2_lien = '".$db->escape($data->agenda2_lien)."',";
			$query .= " pub_medium_rectangle = '".$db->escape($data->pub_medium_rectangle)."',";
			$query .= " active_pub_medium_rectangle = '".$db->escape($data->active_pub_medium_rectangle)."',";
			$query .= " pub_leaderboard = '".$db->escape($data->pub_leaderboard)."',";
			$query .= " active_pub_leaderboard = '".$db->escape($data->active_pub_leaderboard)."',";
			$query .= " template = '".$db->escape($data->template)."'";
			
			
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
			
			// récup les miniatures de photos déjà envoyées
			$dir 		= $data->upload_dir;
			$dest_dir	= '../images/mailing_auto/'.$data->id;
			if(!is_dir($dest_dir)) {
				mkdir($dest_dir);
				chmod($dest_dir, 0777);
			}
			
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {
					if(preg_match('/^temp/', $file)) {
						copy($dir.'/'.$file, $dest_dir.'/'.str_replace('temp-', '', $file));
						@unlink($dir.'/'.$file);
					}
				}
				closedir($dir);
				@rmdir($dir);
			}
		
			
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=mailing_auto&action=edit&id='.$data->id.'&save=1');
			
		}
		
		HTML_mailing_auto::mailingEdit($data, $list, $messages);
		
	}
	
	function mailingApercu(){
		global $db;
		
		// params
		$id 	= JL::getVar('id', 0);
		
		// récup le mailing
		$query = "SELECT *"
		." FROM mailing_auto"
		." WHERE id = '".$id."'"
		." LIMIT 0,1"
		;
		
		$mailing	= $db->loadObject($query);
		
		if(!$mailing->id) {
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=mailing_auto');
		}
		
		$templatePath	= SITE_PATH_ADMIN.'/app/app_mailing_auto/template/'.$mailing->template;
		
		if(!is_file($templatePath)) {
			JL::redirect(SITE_URL_ADMIN.'/index.php?app=mailing_auto&id=3');
		}
		
		$mailingTexte = FUNCTION_mailing_auto::getMailHtml($templatePath,$mailing);
		
		HTML_mailing_auto::mailingApercu($mailingTexte);
	}
	
?>

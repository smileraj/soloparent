<?php

	// MODEL
	defined('JL') or die('Error 401');

	$location = "";
	$cookiearr = array();
	$csv_source_encoding='utf-8';

	class fairepartModel extends JLModel {

		var $pagination;


		function fairepartModel() {
			global $langue;
			parent::JLModel();

			$this->pagination = new JLPagination(PAGINATION_RAYON_BACKEND);

			$this->_messages = JL::getMessages();

		}

		function listall() {
			global $langue;
			global $db, $user;

			$query = "SELECT * FROM fairepart"
			." WHERE user_id = ".$db->escape($user->id);

			$this->_data = $db->loadObjectList($query);

		}


		// récup les données
		function getData() {
			global $langue;
			global $db, $user;

			$this->_data 						= new stdClass();
			$this->_data->id 					= (int)JL::getVar('id', 0);

			// données modifiables par l'utilisateur
			$this->_data->user_id			= JL::cleanVar(JL::getVar('userId', ''));
			$this->_data->prenom 			= JL::cleanVar(JL::getVar('prenom', ''));
			$this->_data->texte 			= JL::cleanVar(JL::getVar('texte', ''));
			$this->_data->date				= JL::cleanVar(JL::getVar('date', ''));
			$this->_data->active 			= (int)JL::getVar('active', 1);
			$this->_data->upload_dir 		= JL::getVar('upload_dir', '');
			$this->_data->template 			= JL::cleanVar(JL::getVar('template', '_defaut'));

			//formulaire pour envoyé aux amis
			$this->_data->login = JL::cleanVar(JL::getVar('username', ''));
			$this->_data->password = JL::cleanVar(JL::getVar('password', ''));

		}

		function getContact() {
			global $langue;
			global $db, $user;

			$this->_data 						= new stdClass();
			$this->_data->id 					= (int)JL::getVar('id', 0);

			$this->_data->indice = JL::getVar('taille', '');

			$j = 0;
			for($i=0; $i<=$this->_data->indice; $i++){
				if(JL::getVar('contact'.$i, '') != ""){
					$this->_data->tabContact[$j] = JL::getVar('contact'.$i, '');
					$j++;
				}
			}

		}

		// vérifie les données
		function checkData() {
			global $langue;
			include("lang/app_inviter.".$_GET['lang'].".php");
			global $db;

			if($this->_data->prenom == '') {
				$this->_messages[]	= '<span class="error">'.$lang_inviter["VeuillezIndiquezPrenom"].'.</span>';
			}

			if($this->_data->texte == '') {
				$this->_messages[]	= '<span class="error">'.$lang_inviter["VeuillezIndiquezText"].'.</span>';
			}

			if($this->_data->date == '' || !JL::checkDateFr($this->_data->date, '.')) {
				$this->_messages[]	= '<span class="error">'.$lang_inviter["VeuillezIndiquezDate"].'.</span>';
			}

			return count($this->_messages) ? false : true;

		}


		// edition d'un message
		function edit() {
			global $langue;
			global $db, $user;

			// initialise les données
			$this->getData();

			// édition
			if($this->_data->id) {

				// récup les données
				$query = "SELECT f.id, f.prenom, f.active, f.date, f.texte, f.user_id, f.template"
				." FROM fairepart AS f"
				." WHERE f.id = '".$this->_data->id."' "
				." LIMIT 0,1";

				$_data = $db->loadObject($query);

				if($_data->user_id != $user->id){
					JL::redirect('index.php?app=fairepart'.'&'.$langue);
				}

				// si données trouvées
				if($_data) {
					$this->_data 		= $_data;
				} else { // sinon reset l'id des valeurs envoyées
					$this->_data->id 	= 0;
				}
				//transformatiom de la date en US vers le format Francais
				JL::dateUsToFr($this->_data->date);

				// dossier d'upload des photos
				$this->_data->upload_dir = JL::getUploadDir('images/fairepart', $this->_data->id);


				//recherche des destinataires du fairepart
				$req = "SELECT DISTINCT id, fairepart_id, mail"
				." FROM fairepart_envoi"
				." WHERE fairepart_id = '".$this->_data->id."'"
				." GROUP BY mail";

				$result = $db->loadObjectList($req);
				$this->result = $result;

			}


		}


		// sauvegarde le message
		function save() {
			global $langue;
			global $db, $user;

			// récup les données du formulaire
			$this->getData();

			// vérif ok
			if($this->checkData()) {

				//transformatiom de la date en Francais vers le format US
				JL::dateFrToUs($this->_data->date);

				// update
				if($this->_data->id) {

					$query = "UPDATE fairepart SET";

				} else { // insert

					$query = "INSERT INTO fairepart SET";

				}

				// partie commune
				$query .= " user_id ='".$user->id."',";
				$query .= " prenom = '".$db->escape($this->_data->prenom)."',";
				$query .= " texte = '".$db->escape($this->_data->texte)."',";
				$query .= " date = '".$db->escape($this->_data->date)."',";
				$query .= " template = '".$db->escape($this->_data->template)."',";
				$query .= " active = '".$db->escape($this->_data->active)."'";

				// update
				if($this->_data->id) {

					$query .= " WHERE id = '".$db->escape($this->_data->id)."' AND user_id = '".$db->escape($user->id)."' ";

				}

				// exécute la requête
				$db->query($query);

				// récup le nouvel id
				if(!$this->_data->id) {
					$this->_data->id = $db->insert_id();
				}

				// récup les miniatures de photos déjà envoyées
				$dir 		= $this->_data->upload_dir;
				$dest_dir	= 'images/fairepart/'.$this->_data->id;
				if(!is_dir($dest_dir)) {
					mkdir($dest_dir);
					chmod($dest_dir, 0777);
				}

				if($dir != $dest_dir && is_dir($dir)) {
					$dir_id 	= opendir($dir);
					while($file = trim(readdir($dir_id))) {
						copy($dir.'/'.$file, $dest_dir.'/'.$file);
						@unlink($dir.'/'.$file);
					}
				}

				return true;

			} else {

				return false;

			}
		}


		// active/désactive un enregistrement
		function active($id) {
			global $langue;
			global $db, $user;

			if($id) {
				$query = "UPDATE fairepart SET active = !active WHERE id = '".$db->escape($id)."' "
				." AND user_id = '".$db->escape($user->id)."' ";
				$db->query($query);
			}

		}


		function listTemplate($template = 0, $js = '') {
			global $langue;
			global $db;

			// variables
			$listTemplate 	= array();


			// parcourt le dossier des templates et récup les fichiers
			$dir = SITE_PATH.'/app/app_fairepart/template';
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
			$this->_list['template'] = JL::makeSelectList($listTemplate, 'template', 'id="template" '.$js, 'value', 'text', $template);

		}

		//fonction d'aperçu du faire-part
		function preview($id) {
			global $langue;
			global $db, $user;

			// édition
			if($id) {

				// récup les données
				$query = "SELECT * FROM fairepart WHERE id = '".$id."' LIMIT 0,1";
				$fairepart = $db->loadObject($query);
				if($fairepart->template == "_defaut.html"){
					$photo = 'images/fairepart/'.$id.'/fairepart-micro.jpg';
				}else{
					$photo = 'images/fairepart/'.$id.'/fairepart-250.jpg';
				}
				$zoom = 'images/fairepart/'.$id.'/fairepart.jpg';

			}

			// chemin du template
			$templatePath	= SITE_PATH.'/app/app_fairepart/template/'.$fairepart->template;

			if(!is_file($templatePath)) {
				return false;
			}

			if($fairepart->id && $fairepart->active == 1) {

				JL::dateUsToFr($fairepart->date);

				// génère le code html du message
				$this->_data	= $this->getFairepartHtml($templatePath, $fairepart->prenom, $fairepart->texte, $fairepart->date, $photo, $zoom);

				return true;

			} else {

				return false;
			}

		}

		// remplace les mots clés du genre {texte}, {site_url}, {username}, etc...
		function getFairepartHtml($templatePath, $prenom = '', $texte = '', $date = '', $photo = '', $zoom = '') {

			global $langue;

				// récup le code html du template
				$html		= str_replace('{texte}', 	$texte, 	file_get_contents($templatePath));

				// remplace les mots clés
				$html		= str_replace('{prenom}', 	$prenom, 	$html);
				$html		= str_replace('{date}', $date, 	$html);
				$html		= str_replace('{photo}', 	$photo, 	$html);
				$html		= str_replace('{zoom}', 	$zoom, 	$html);
				$html		= str_replace('{site_url}', SITE_URL, 	$html);

				return $html;


		}

		function import($id){
			global $langue;
			include("lang/app_inviter.".$_GET['lang'].".php");
			global $db, $user;

			$this->_data->indice;
			$this->_data->tabContact;

			$query = "SELECT f.prenom, f.date FROM fairepart AS f"
			." WHERE id = '".$id."'";
			$result = $db->loadObject($query);

			JL::dateUsToFr($result->date);

			$texte = "".$lang_inviter['Bonjour'].",<br><br>".$lang_inviter['NousAvonsLePlaisir']." <a href='mailto:".$user->email."'>".$user->email."</a> ".$lang_inviter['VousAEnvoyeUnFairePart']." <a href='http://www.babybook.ch' target='_blank'>www.babybook.ch</a>";
			$texte .= "<br><br> ".$lang_inviter['VousPourrezLeRetrouver']." : ";
			$texte .= "<a href='".SITE_URL."/index.php?app=fairepart&action=preview&id=".$id."&template=fairepart&".$langue."' target='_blank'>".$lang_inviter['VoirLeFairPart']."</a>";
			$texte .= "<br><br>".$lang_inviter['ABientotSur']." <a href='http://www.babybook.ch' target='_blank'>www.babybook.ch</a>  ";
			$texte .= "<br><br>------------------------------------- <br><br>".$lang_inviter['LEquipeDe']."";

			$titre = "".$lang_inviter['FairePart']." : ".$result->prenom." ".$lang_inviter['Le']." ".$result->date;

			foreach($this->_data->tabContact as $contact){
				JL::mail($contact,$titre,$texte,false);

				//inserer dans la table fairepart_envoi
				$query = "INSERT INTO fairepart_envoi(fairepart_id,mail) VALUES ('".$id."','".$contact."')";
				$db->setQuery($query);
			}

		}


	}

?>
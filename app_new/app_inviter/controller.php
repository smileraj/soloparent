<?php

	// CONTROLLER
	defined('JL') or die('Error 401');

	//classes utiles pour les faire-parts seulement
	require_once(SITE_PATH.'/framework/panel.class.php');
	require_once(SITE_PATH.'/framework/toolbar.class.php');

	class fairepartController extends JLController {

		function __construct($appLoad) {
			parent::JLController($appLoad); // obligatoire pour l'instanciation
			global $langue;

			// ajoute le model par défaut
			$this->addModel();

			// ajoute la view par défaut
			$this->addView();

		}

		function execute() {
			global $langue;
			global $action;

			switch($action) {

				// sauvegarde d'un post
				case 'apply' :
				case 'save':

					if($this->model->save()){
						// redirect
						if($action == 'save'){
							JL::redirect(SITE_URL.'/'.JL::url('index.php?app=fairepart&msg=saved&'.$langue));
						}else{
							JL::redirect(SITE_URL.'/'.JL::url('index.php?app=fairepart&action=edit&id='.$this->model->_data->id.'&msg=saved&'.$langue));
						}
						//$action == 'save' ? JL::redirect(SITE_URL.'/'.JL::url('index.php?app=fairepart&msg=saved')) : JL::redirect(SITE_URL.'/'.JL::url('index.php?app=fairepart&action=edit&id='.$this->model->_data->id.'&msg=saved'));
					}else {

						// model
						$this->model->getData();

						// formulaire l'édition
						$this->editForm();

					}

				break;


				// modif/création d'un post
				case 'edit':

					// check user droit de poster
					if(!JL::checkAccess(14)) {
						JL::redirect(JL::url(SITE_URL.'/index.php?app=membre&action=inscription&'.$langue));
					}

					// model
					$this->model->edit();

					// formulaire l'édition
					$this->editForm();

				break;

				case 'active':

					// model
					$this->model->active((int)JL::getVar('id', 0));

					// redirection
					JL::redirect(SITE_URL.'/index.php?app=fairepart&msg=saved&'.$langue);

				break;

				case 'preview' :

					$id	= (int)JL::getVar('id', 0);

					// model
					if($this->model->preview($id)) {

						// view
						$this->view->preview($this->model->_data);

					} else {

						//appel de la fonction erreur si le faire part est desactive
						$this->view->error404();

					}

				break;

				case 'envoyer':

					// model
					$this->model->edit();

					if($this->model->_data->id > 0) {

						// view
						$this->view->envoyer($this->model->_data);

					} else {

						// redirection: nouveau faire-part
						JL::redirect(SITE_URL.'/index.php?app=fairepart&action=edit&'.$langue);

					}

				break;

				case 'import' :

					$this->model->edit();

					if($this->model->_data->id > 0){
						$this->model->getContact();
						$this->model->import($this->model->_data->id);
						$this->view->import($this->model->_data);

					}else{

						// redirection: liste faire-part
						JL::redirect(SITE_URL.'/index.php?app=fairepart&'.$langue);

					}

				break;

				// afficher la liste des catégories forums
				default:

					// model
					$this->model->listall();

					// view
					$this->view->listall($this->model->_data, $this->model->_messages, $this->model->_list, $this->model->pagination);
				break;

			}

		}

		function editForm() {
			global $langue;

			//liste des templates
			$this->model->listTemplate($this->model->_data->template, 'class="input255"');

			// view
			$this->view->edit($this->model->_data, $this->model->_messages, $this->model->_list, $this->model->result);

		}

	}

?>
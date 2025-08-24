
<?php

	// sécurité
	defined('JL') or die('Error 401');
	global $action,$user;
	require_once('event.html.php');	
		
		switch($action) {
		
		
		
		default:
		gettable();
		break;
		
	}
		
	
	function gettable() {
	global $db;
	$resultatParPage	= RESULTS_NB_LISTE_ADMIN;
		$search				= array();
		
		
		// params
		
		// si on passe une recherche en param, alors on force la page 1 (pour éviter de charger la page 36, s'il n'y a que 2 pages à voir)
		$search['page']			= JL::getVar('search_t_page', JL::getSessionInt('search_t_page', 1));
		
		// mot cherché
		$search['word']			= trim(JL::getVar('search_t_word', JL::getSession('search_t_word', ''), true));
		$search['order']		= JL::getVar('search_t_order', JL::getSession('search_t_order', 'date_add'), 'date_add');
		$search['ascdesc']		= JL::getVar('search_t_ascdesc', JL::getSession('search_t_ascdesc', 'desc'), 'desc');
		$search['active']		= JL::getVar('search_t_active', JL::getSession('search_t_active', -1), -1);
		
		// conserve en session ces paramètres
		JL::setSession('search_t_page', 		$search['page']);
		
		
		
		

		
		
		
		
		// temoignage actifs
		if($search['active'] >= 0) {
			$where[]		= "t.active = '".addslashes($search['active'])."'";
		}
		
		// génère le where
		if(count($where)) {
			$_where			= " WHERE ".implode(' AND ', $where);
		}
		
		
	$query = "SELECT COUNT(*) FROM events_creations";
	
$search['result_total'] = intval($db->loadResult($query));
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
	$query1="select * from events_creations order by id desc LIMIT " .(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage;
	$eventdetails = $db->loadObjectList($query1);
		table_HTML::gettable($eventdetails,$search);
		}
		
		
?>


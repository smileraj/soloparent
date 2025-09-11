<?php

	// sécurité
	defined('JL') or die('Error 401');
	
	require_once('event.html.php');

global $action, $langue, $langString;
	
			
		switch($action) {

		case 'read':
			
			$id	= JL::getVar('id', 0, true);
			readlist($id);
		break;
		case 'create':
			
			create();
		break;
		case 'search':
			$value=JL::getVar('value', 0, true);
			search($value);
		break;

		default:
			listevent((int)JL::getVar('page',1));
			
		break;
		}
	
	function gettable() {
	global $db,$user;
	
	$query="select * from events_creations where uservalue=$user->id";
	$eventdetails = $db->loadObjectList($query);
		table_HTML::gettable($eventdetails);
		}
	
	function listevent($page) {
	
	global $db,$user;

	$resultatParPage	= LISTE_RESULT;
	$search['page']		= (int)JL::getVar('page', 1);
		if($search['page'] <= 0) JL::redirect(SITE_URL.'/index.php?app=event'.'&'.$langue);
	$query = "SELECT COUNT(*) FROM events_creations";
	
$search['result_total']	= (int)$db->loadResult($query);
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
     
		
	$query="select * from events_creations order by id desc LIMIT " .(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage;
	$listdetails = $db->loadObjectList($query);
		table_HTML::listevent($listdetails,$search);
		}	
		function readlist($id){
		global $db,$user;
		$query="select * from events_creations where id=$id";
		
	   $readlist = $db->loadObjectList($query);
		table_HTML::readlist($readlist);
		}
		function create(){
		table_HTML::create();
		}
    function search($value){
	global $db,$user;
	$resultatParPage	= LISTE_RESULT;
	$search['page']		= (int)JL::getVar('page', 1);
		if($search['page'] <= 0) JL::redirect(SITE_URL.'/index.php?app=event'.'&'.'&lang='.$_GET["lang"]);
	$query = "SELECT COUNT(*) FROM events_creations where event_name='$value'";
	
$search['result_total']	= (int)$db->loadResult($query);
		$search['page_total'] 	= ceil($search['result_total']/$resultatParPage);
     
		
	$query="select * from events_creations where event_name='$value' order by id desc LIMIT " .(($search['page'] - 1) * $resultatParPage).", ".$resultatParPage;
	$listdetails = $db->loadObjectList($query);
	table_HTML::search($listdetails,$search);
	}
		
?>


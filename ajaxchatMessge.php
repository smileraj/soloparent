<?php
// config
	require_once('config.php');
	
	// framework joomlike
	require_once(SITE_PATH.'/framework/joomlike.class.php');

	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');
	$db	= new DB();

	// params
	$action			= JL::getVar('action', false);
	$lang_id		= JL::getVar('lang_id', 'fr');
	$user_id_from	= intval(JL::getVar('user_id_from', 0));
	$user_id_to		= intval(JL::getVar('user_id_to', 0));
	$user_id_to_new	= intval(JL::getVar('user_id_to_new', 0));
	$newOnly		= intval(JL::getVar('newonly', 0));
	$key			= JL::getVar('key', '');
	$texte			= mb_convert_encoding(JL::getVar('texte', '', true), 'ISO-8859-1');

	

	$useridval=$_POST['useridval'];
	$cht_count=$_POST['cht_count'];
	$where			= [];
		$_where			= '';
$where[]		= "cm.user_id_to = '".$useridval."'";
		$where[]		= "cm.new_user_to = '1'";

		// génère le where
		$_where			= " WHERE ".implode(' AND ', $where);
		// récup les conversations
		$query = "SELECT COUNT(*) as totalMessage"
		." FROM chat_message AS cm"
		.$_where
		;
		$correspondants=$db->loadObject($query);
		if($correspondants->totalMessage >'0'){
		//echo $correspondants->totalMessage;
		$totalmessge=$correspondants->totalMessage;
		// echo $useridval.",".$cht_count;
		//if(($cht_count==$totalmessge) && ($cht_count!='0')){
		//$Sound_val= "<embed src='sound/notify.mp3' autostart='false' width='0' height='0' id='sound1' enablejavascript='true'>";
		//}
	//	$cht_count_msg="1";
		echo $totalmessge;
		 
		} else {
		
		//$cht_count_msg="1";
		//if(($cht_count!=$totalmessge) && ($cht_count!='0')){
		//$Sound_val= "<embed src='sound/notify.mp3' autostart='false' width='0' height='0' id='sound1' enablejavascript='true'>";
		//}	 echo $cht_count_msg.",".$Sound_val;
		 
		}
		





	

	

?>
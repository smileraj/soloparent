<?php
	require_once(SITE_PATH.'/chat2/ajaxFct.php');

/*	session_start();
//echo$_GET["userTo"];die();


	// mode offline avec erreur 404: à décommenter que lorsque l'on veut masquer le site en dév
	//include('offline404.php');


	// config
	require_once('../config.php');

	// framework joomlike

	// framework base de données
	require_once(SITE_PATH.'/framework/mysql.class.php');
	$db	= new DB();

	require_once(SITE_PATH.'/chat2/chatFct.php');
	// si connexion DB impossible
	if(!$db->getConnexion()) {
		include('../offline.php');
		exit;
	}

	if (isset($_GET['lang'])){
		$langue="lang=".$_GET['lang'];

	} else {
		header('Status: 301 Moved Permanently', false, 301);
		if(isset($_SERVER["QUERY_STRING"]) && !empty($_SERVER["QUERY_STRING"])){
			$string="?".$_SERVER["QUERY_STRING"]."&lang=fr";
		} else {
			$string="?lang=fr";
		}
		header("Location: ".$_SERVER["PHP_SELF"].$string);
		die();
	}

	// crée l'objet global $user
	$user			= new stdClass();

	if ($_GET['lang']!="fr")$langString="_".$_GET['lang'];
	else $langString="";
	global $langString;
	require_once(SITE_PATH.'/chat2/lang/chat.'.$_GET['lang'].'.php');



	// module d'authentification, qui n'affiche rien
	JL::loadMod('auth');
	if(!$user->id) {
		echo "noMoreAuth"; die();
	}
//	else$*/

	$userTo = getUserInfo($_GET["userTo"]);
	//$user_id_to	= intval(JL::getVar('id', 0));


?>
<div class="chatProfileToImg"><img src="<?php echo $userTo->photoURL;?>" alt="profil" /></div>
<div class="chatProfileToTxt">
<p class="nickname"><?php echo $userTo->username;?></p>
<p class="age"><?php echo JL::calcul_age($userTo->naissance_date); ?></p>
<p class="children"><?php echo $userTo->enfants." ".(($userTo->enfants>1)?$langChat["enfants"]:$langChat["enfant"]);?></p>
<p class="canton"><?php echo $userTo->canton;?></p>
<p class="ville"><?php echo $userTo->ville;?></p>
<p class="online"><?php echo ($userTo->is_online)?$langChat["online"]:$langChat["offline"];?></p>
</div>

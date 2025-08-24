<?php
require_once('../config.php');
require_once(SITE_PATH.'/framework/joomlike.class.php');
require_once(SITE_PATH.'/framework/mysql.class.php');
	
if($_POST)
{
	$q=$_POST['search'];
	$User_id=$_POST['User_id'];
	$Language=$_POST['Language'];
	$db	= new DB();
	$getgenre="select genre from user_profil where user_id=$User_id";
	$utilisateur = $db->loadObject($getgenre);
	if($utilisateur->genre=='h')
	{
	$genre='f';
	}
	if($utilisateur->genre=='f')
	{
	$genre='h';
	}
	if($Language =='en'){
		$enfant='child';
	}else if($Language =='fr'){
		$enfant='enfant';
	}
	else if($Language =='de'){
		$enfant='kind';
	}
$query="SELECT u.id, u.username, up.genre, up.naissance_date,"
		." up.nb_enfants,  pc.nom_".$Language." as canton,  pv.nom as ville, u.online, up.photo_defaut,"
		."(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(u.last_online)) as `last_online_time`"
		." FROM user AS u"
		." LEFT JOIN user_profil AS up ON u.id = up.user_id"
		." LEFT JOIN profil_canton AS pc ON up.canton_id = pc.id"
		." LEFT JOIN profil_ville AS pv ON up.ville_id = pv.id"
		." Where  u.username like '%$q%' order by u.id LIMIT 5";
	$readlist = $db->loadObjectList($query);
foreach($readlist as $corresp){
			$corresp->photoURL = '';			
			$corresp->photoURL = JL::userGetPhoto($corresp->id, 'profil', '', $corresp->photo_defaut);
			if(!$corresp->photoURL||empty($corresp->photoURL)) {
				$corresp->photoURL = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$corresp->genre.'-'.$Language.'.jpg';
			}
			
			if($langString){
				if($langString == "_de")
					$langue = "&lang=de";
				if($langString == "_en")
					$langue = "&lang=en";
			}else
				$langue = "&lang=fr";
			
			//a supprimer une fois le module en ligne refait
			if (intval($corresp->last_online_time) > (ONLINE_TIME_LIMIT + AFK_TIME_LIMIT)) {
				$corresp->online = 0;
			} else {
				$corresp->online = 1;
			}
			
$username=$corresp->username;
$id=$corresp->id;
if(($corresp->id != $User_id) && ($genre ==$corresp->genre)){
$b_username='<strong>'.$q.'</strong>';
$b_email='<strong>'.$q.'</strong>';
$final_username = str_ireplace($q, $b_username, $username);
$final_email = str_ireplace($q, $b_email, $id);
?>
<div class="top chatboxhead show">
			<a href="<? echo SITE_URL; ?>/chat2/chat.php?lang=<?php echo $Language;?>&id=<?php echo $id;?>"><div class="col-md-6 col-sm-6 col-xs-6  parentsolo_plr_0"> <div class="col-md-3  col-sm-3 col-xs-3  parentsolo_plr_0 parentsolo_mt_20">  <span style="">
                    <span class="userimage chatProfileToImg " onclick="self.opener.location.href='<? echo SITE_URL; ?>/index.php?app=profil&action=view&id=<? echo $correspondant->id.$langue; ?>'">
					<img src='<? echo $corresp->photoURL; ?>' alt='profil' /></span>
                   </div> <div class="col-md-9  col-sm-9 col-xs-9 parentsolo_plr_0" style=" line-height: 30px;   margin-top: 8px;"
> <span  class="name nickname<? echo $corresp->genre; ?>"><? echo $username; ?></span><br>
					<span class='online_<? echo $corresp->online; ?>'><? echo $online_2; ?></span>
                </span></div></div>
               <div class="col-md-6  col-sm-6 col-xs-6"><div class='chatProfileToTxt  text-right'>
					
					<span class="project" style="line-height:45px;"><? echo $corresp->nb_enfants." ".$enfant; ?></span>
                </div></div> </a>
              
            </div>

<!--
<a href="http://www.parentsolo.ch/newdev/index.php?app=chat&id=<?php echo $id;?>&lang=<?php echo $Language;?>" >
<div class="show" align="left"><span class="name"><?php echo $final_username; ?></span>&nbsp;<br/><?php echo $final_email; ?><br/>
</div></a>-->
<?php
}
}
}
?>

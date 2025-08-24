<?php

	require_once('ajaxFct.php');

	$userTo = getUserInfo($_GET["userTo"]);
	//$user_id_to	= intval(JL::getVar('id', 0));


?>
<input type="hidden" id="profileToId" value="<?php echo $userTo->id;?>" />
<!--<div onclick="self.opener.location.href='<?php echo SITE_URL;?>/index.php?app=profil&action=view&id=<?php echo $userTo->id;?>'">-->
<div class="chatProfileToImg"><img src="<?php echo $userTo->photoURL;?>" alt="profil" /></div>
<div class="chatProfileToTxt">
<p class="nickname"><?php echo $userTo->username;?></p>
<p class="age"><? echo JL::calcul_age($userTo->naissance_date); ?></p>
<p class="children"><?php echo $userTo->enfants." ".(($userTo->enfants>1)?$langChat["enfants"]:$langChat["enfant"]);?></p>
<p class="canton"><?php echo $userTo->canton;?></p>
<p class="ville"><?php echo $userTo->ville;?></p>
<p class="online_<?php echo ($userTo->is_online)?"on":"off";?>"><?php echo ($userTo->is_online)?$langChat["online"]:$langChat["offline"];?></p>
</div>
<!--</div>-->

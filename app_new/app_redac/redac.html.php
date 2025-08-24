<?php

	// sécurité
	defined('JL') or die('Error 401');

	class redac_HTML {

		// affiche un $contenu
		function contenuAfficher(&$contenu) {
			global $langue;
			include("lang/app_redac.".$_GET['lang'].".php");
			global $user;

			$id	= JL::getVar('id', 0);
			JL::makeSafe($contenu, 'texte');

			?>
				<div class="app_body">
					<div class="contenu">
						<h1><? echo $contenu->titre; ?><? if($contenu->type_id == 1) { ?><br /><span><?php echo $lang_redac["ActualiteDu"];?> <? echo date('d/m/Y', strtotime($contenu->date_add)); ?><? } ?></h1>

<script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=f2854e08-c05e-4df9-ac08-339db394a21f&amp;type=website&amp;post_services=email%2Cfacebook%2Ctwitter%2Cgbuzz%2Cmyspace%2Cdigg%2Csms%2Cwindows_live%2Cdelicious%2Cstumbleupon%2Creddit%2Cgoogle_bmarks%2Clinkedin%2Cbebo%2Cybuzz%2Cblogger%2Cyahoo_bmarks%2Cmixx%2Ctechnorati%2Cfriendfeed%2Cpropeller%2Cwordpress%2Cnewsvine&amp;button=false"></script>
<style type="text/css">
body {font-family:helvetica,sans-serif;font-size:12px;}
a.stbar.chicklet img {border:0;height:16px;width:16px;margin-right:3px;vertical-align:middle;}
a.stbar.chicklet {height:16px;line-height:16px;}
</style>

<a id="ck_email" class="stbar chicklet" href="javascript:void(0);"><img src="http://w.sharethis.com/chicklets/email.gif" /></a>
<a id="ck_facebook" class="stbar chicklet" href="javascript:void(0);"><img src="http://w.sharethis.com/chicklets/facebook.gif" /></a>
<a id="ck_twitter" class="stbar chicklet" href="javascript:void(0);"><img src="http://w.sharethis.com/chicklets/twitter.gif" /></a>
<a id="ck_sharethis" class="stbar chicklet" href="javascript:void(0);"><img src="http://w.sharethis.com/chicklets/sharethis.gif" />ShareThis</a>
<script type="text/javascript">
	var shared_object = SHARETHIS.addEntry({
	title: document.title,
	url: document.location.href
});

shared_object.attachButton(document.getElementById("ck_sharethis"));
shared_object.attachChicklet("email", document.getElementById("ck_email"));
shared_object.attachChicklet("facebook", document.getElementById("ck_facebook"));
shared_object.attachChicklet("twitter", document.getElementById("ck_twitter"));
</script>




						<? if(in_array($id, array(7, 19, 27, 29))) { ?>
<div class="radio">
<div class="radio1">&nbsp;</div>
<div class="radio2" style="text-align:right;"><span style="color: rgb(0, 0, 0); font-size: 14px;"><strong><?php echo $lang_redac["MenuPresse"];?></strong></span><br />
<a href="<? echo JL::url('index.php?app=redac&action=item&id=7'.'&'.$langue); ?>" title="<?php echo $lang_redac["ParentsoloDansPresse"];?>" <? if($id == 7) { ?>class="active"<? } ?>><?php echo $lang_redac["ParentsoloDansPresse"];?></a><br />
<a href="<? echo JL::url('index.php?app=redac&action=item&id=27'.'&'.$langue); ?>" title="<?php echo $lang_redac["CommuniqueDePresse"];?>" <? if($id == 27) { ?>class="active"<? } ?>><?php echo $lang_redac["CommuniqueDePresse"];?></a><br />
<a href="<? echo JL::url('index.php?app=redac&action=item&id=29'.'&'.$langue); ?>" title="<?php echo $lang_redac["DossierDePresse"];?>" <? if($id == 29) { ?>class="active"<? } ?>><?php echo $lang_redac["DossierDePresse"];?></a><br />
<!--<a href="<? echo JL::url('index.php?app=redac&action=item&id=19'.'&'.$langue); ?>" title="<?php echo $lang_redac["Medias"];?>" <? if($id == 19) { ?>class="active"<? } ?>><?php echo $lang_redac["Medias"];?></a>-->
</div>
<div class="radio3">&nbsp;</div>
</div>
<p><br /><span style="color: #797971; font-size: 14px;"><strong><?php echo $lang_redac["RebriquePresse"];?></strong></span><br />
<br />
<?php echo $lang_redac["VousPouvezUtiliser"];?>.</p>
<div class="clear">&nbsp;</div>
<br />
<br />

						<? } ?>

						<? echo str_replace('<p>&nbsp;</p>','',$contenu->texte); ?>

						<?
						if($id == 6) {
							JL::loadMod('contact');
						} elseif($id == 8) {
							JL::loadMod('signaler_abus');
						}
						?>

						<? if($id == 6 || $id == 8) { ?>
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td><a href="<? echo $user->id ? JL::url('index.php?app=profil&action=panel'.'&'.$langue) : JL::url('index.php'.'?'.$langue); ?>" class="bouton return_home" style="margin:0;"><strong><?php echo $lang_redac["RetourALAccueil"];?></a></td>
									<td><a href="javascript:document.<? echo $id == 6 ? 'contactform' : 'abusform'; ?>.submit();" class="bouton envoyer"><?php echo $lang_redac["Envoyer"];?></a></td>
								</tr>
							</table>
						<? } else { ?>
							<a href="<? echo $user->id ? JL::url('index.php?app=profil&action=panel'.'&'.$langue) : JL::url('index.php'.'?'.$langue); ?>" class="bouton return_home"><?php echo $lang_redac["RetourALAccueil"];?></a>
						<? } ?>
					</div>
				</div> <? // fin app_body ?>
			<?

				// colonne de gauche
				JL::loadMod('profil_panel');

			?>
			<div class="clear"> </div>
			<?
		}

	}
?>

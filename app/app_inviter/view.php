<?php
	include_once("usage_test.php");
	// VIEW
	defined('JL') or die('Error 401');

	class fairepartView extends JLView {

		function __construct(){}


		// affiche la liste des forums
		function listall(&$rows, &$messages, &$list, &$pagination) {
			global $langue;
			include("lang/app_inviter.".$_GET['lang'].".php");
			global $user;

			// variables
			$i		= 1;
			$rowsNb	= count($rows);

			JLToolbar::open();
			JLToolbar::title(''.$lang_inviter["FairePartDeNaissance"].'');
			JLToolbar::close();

			if(!$user->id){ //article pour les conditions des castings et si utilisateur n'est pas identifi&eacute;
			?>
				<p>
				<?php echo $lang_inviter["IlVousFautTout"];?> <b><?php echo $lang_inviter["ConnecterAVotre"];?></b> ! <i>(<?php echo $lang_inviter["ToutEnHautSite"];?>)</i><br />
				<br />
				<?php echo $lang_inviter["SiVousNEtesPas"];?> <b><a href="<?php echo JL::url('index.php?app=membre&action=inscription'.'&'.$langue); ?>" title="<?php echo $lang_inviter["CreerCompteBaby"];?>"><?php echo $lang_inviter["CreerUneCompte"];?></a></b>, <?php echo $lang_inviter["EtSerezImmediatement"];?>.<br />
				<br />
				<?php echo $lang_inviter["UneFoisInscrit"];?>.
				</p>

				<a href="<?php echo SITE_URL.'?'.$langue; ?>" title="<?php echo SITE_DESCRIPTION; ?>" class="retour"><?php echo $lang_inviter["RetourALaPage"];?></a>
			<?php 			}else{

				// toolbar
				JLToolbar::open();
				JLToolbar::link(JL::url('index.php?app=membre&'.$langue), 'Fermer', 'Retour &agrave; la liste des faire-parts', 'annuler');
				JLToolbar::link(JL::url('index.php?app=fairepart&action=edit&'.$langue), 'Nouveau', 'Cr&eacute;er un nouveau faire-part', 'nouveau');
				JLToolbar::close();

				?>

				<br><br>
				<br><br>
				<center><table cellpadding="0" cellspacing="0" border="0" width="95%" class="fairepart">
						<tr class="key">
							<th width="50%"><?php echo $lang_inviter["Prenom"];?></th>
							<th width="20%" class="date"><?php echo $lang_inviter["Date"];?></th>
							<th width="15%"><?php echo $lang_inviter["Active"];?></th>
							<th width="15%" class="date"><?php echo $lang_inviter["Envoyer"];?></th>
						</tr>
						<?php 						if(is_array($rows) && count($rows)) {

								// pour chaque cat&eacute;gorie
								foreach($rows as $row) {
									JL::makeSafe($row);
									JL::dateUsToFr($row->date);
								?>
								<tr class="list">
									<td><a href="<?php echo JL::url('index.php?app=fairepart&action=edit&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_inviter["Modifierlefairepart"];?>"><?php echo $row->prenom; ?></a></td>
									<td class="date"><?php echo $row->date; ?></td>
									<td class="active"><a href="<?php echo JL::url('index.php?app=fairepart&action=active&id='.$row->id.'&'.$langue); ?>" title="<?php echo $row->active ? $lang_inviter["Desactiver"] : $lang_inviter["Activer"]; ?>"><img src="admin/images/<?php echo $row->active; ?>.gif" alt="<?php echo $row->active ? $lang_inviter["Active"] : $lang_inviter["Desactive"]; ?>" /></a></td>
									<td class="date"><a href="<?php echo JL::url('index.php?app=fairepart&action=envoyer&id='.$row->id.'&'.$langue); ?>" title="<?php echo $lang_inviter["Envoyercefairepart"];?>"><img src="<?php echo SITE_URL_ADMIN; ?>/images/mailing.png" alt="" /></a></td>
								</tr>
								<?php 								}

							} else {
							?>
							<tr class="list">
								<td colspan="4"><?php echo $lang_inviter["AuncunFairePart"];?>.</td>
							</tr>
							<?php 							}
						?>
				</table></center>
				<?php 			}
		}


		// formulaire d'&eacute;dition
		function edit(&$row, &$messages, &$list, &$destinataire) {
			global $langue;
			include("lang/app_inviter.".$_GET['lang'].".php");
			global $user;

			// variables
			JL::makeSafe($row, 'texte');

			// toolbar
			JLToolbar::open();
			JLToolbar::title('Faire-part : '.($row->id ? 'Modifier' : 'Nouveau'));
			JLToolbar::link(JL::url('index.php?app=fairepart&'.$langue), 'Fermer', 'Retour &agrave; la liste des faire-parts', 'annuler');
			JLToolbar::link("javascript:valider('apply');", 'Appliquer', 'Appliquer les modifications', 'appliquer');
			JLToolbar::link("javascript:valider('save');", 'Sauver', 'Sauvegarder le faire-part', 'sauver');

			// si on &eacute;dite un faire part existant
			if($row->id) {
				JLToolbar::link(JL::url(SITE_URL.'/index.php?app=fairepart&action=preview&id='.$row->id.'&template=fairepart&'.$langue), 'Aper&ccedil;u', 'Voir un aper&ccedil;u du faire-part', 'apercu', true);
			}

			JLToolbar::close();

			//fckEditor
				require_once(SITE_PATH.'/fckeditor/fckeditor.php');
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/fckeditor/fckeditor.js"></script>

			<?php
			// affichage des messages
			if($messages){
				echo "<br><br><br><br>";
				$this->messages($messages);
			}else{
				echo "<br><br><br><br>";
			}

			?>

			<center><form name="adminForm" action="<?php echo SITE_URL; ?>/index.php?<?php echo $langue;?>" method="post">
				<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
				<input type="hidden" name="app" value="fairepart" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="upload_dir" id="upload_dir" value="<?php echo $row->upload_dir; ?>" />
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />

				<table cellpadding="0" cellspacing="0" border="0" width="95%" class="fairepartEdit">
					<tr>
						<td colspan="2"><?php echo $lang_inviter["ApliquezVosModification"];?>.</td>
					</tr>
					<tr>
						<td width="25%" class="key"><label for="template"><?php echo $lang_inviter["Template"];?>:</label></td>
						<td width="75%"><?php echo $list['template']; ?></td>
					</tr>

					<tr>
						<td class="key"><label for="date"><?php echo $lang_inviter["DateJJMMAAAA"];?>:</label></td>
						<td><input type="date" name="date" id="date" value="<?php echo $row->date; ?>" class="input255" /></td>
					</tr>
					<tr class="key">
						<td class="key"><label for="prenom"><?php echo $lang_inviter["Prenom"];?>:</label></td>
						<td><input type="text" name="prenom" id="prenom" value="<?php echo $row->prenom; ?>" class="input255" /></td>
					</tr>
					<tr>
						<td class="key">
							<label for="texte"><?php echo $lang_inviter["Texte"];?>:</label>
						</td>
						<td>
							<?php

								$oFCKeditor = new FCKeditor('texte', '300', '430px'); // FCKeditor1
								$oFCKeditor->BasePath = SITE_URL.'/fckeditor/';

								$oFCKeditor->Config['SkinPath'] = $oFCKeditor->BasePath.'editor/skins/silver/';
								$oFCKeditor->ToolbarSet			= 'Mailing';

								$oFCKeditor->Value = $row->texte;
								$oFCKeditor->Create();

							?>
						</td>
					</tr>
					<tr>
						<td class="key"><?php echo $lang_inviter["Active"];?>:</td>
						<td><?php JL::radioYesNo('active', $row->active); ?></td>
					</tr>
					<tr>
						<td class="key" rowspan="2" width="25%"><?php echo $lang_inviter["Photo"];?>:</td>
						<td colspan="2">
							<div class="miniatures" id="miniaturesfairepart">
							<?php 								// image existe
								if(is_file($row->upload_dir.'/fairepart.jpg')) {
								?>
									<div id="<?php echo $row->upload_dir.'/fairepart-micro.jpg'; ?>" class="miniature">
									<img src="<?php echo $row->upload_dir.'/fairepart-micro.jpg'; ?>"/>
									<a class="btnDelete" href="javascript:deleteImage('<?php echo $row->upload_dir.'/fairepart-micro.jpg'; ?>', 'miniaturesfairepart');"><?php echo $lang_inviter["Supprimer"];?></a>
									</div>
								<?php 								}
							?>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="swfu_btnR"><span id="spanButtonPlaceholder"></span></div>
							<div id="divFileProgressContainer"></div>
						</td>
					</tr>
					<?php 					if($row->id && $destinataire) {
					?>
					<tr>
						<td class="key"><?php echo $lang_inviter["EmailsDestinqtaires"];?> :</td>
						<td style="padding-top:10px;"> <?php echo $lang_inviter["CeFairePartAEte"];?> :<br><br>
							<?php 							foreach($destinataire as $dest){
								echo $dest->mail."<br>";
							}
							?>
							<br>
						</td>
					</tr>
					<?php 					}
					?>
				</table>
			</form></center>
			<script language="javascript" type="text/javascript">
				var photoUpload;
				function photoUploadInit() {
					photoUpload = new SWFUpload({
						upload_url: "<?php echo SITE_URL; ?>/js/swfupload/upload-fairepart.php",
						post_params: {"site_url": "<?php echo SITE_URL; ?>", "upload_dir": $('upload_dir').value},
						file_size_limit : "2 MB",
						file_types : "*.jpg",
						file_types_description : "JPG",
						file_upload_limit : "0",
						file_queue_error_handler : fileQueueError,
						file_dialog_complete_handler : fileDialogComplete,
						upload_progress_handler : uploadProgress,
						upload_error_handler : uploadError,
						upload_success_handler : uploadSuccessFairepart,
						upload_complete_handler : uploadComplete,
						button_image_url : "",
						button_placeholder_id : "spanButtonPlaceholder",
						button_width: 120,
						button_height: 40,
						button_text : '',
						button_text_style : '',
						button_text_top_padding: 0,
						button_text_left_padding: 18,
						button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
						button_cursor: SWFUpload.CURSOR.HAND,
						flash_url : "<?php echo SITE_URL; ?>/js/swfupload/swfupload.swf",
						custom_settings : {
							upload_target : "divFileProgressContainer"
						},
						debug: false
					});
				};
				photoUploadInit();
			</script>
			<?php 		}

		function preview(&$html) {
			global $langue;

			echo $html;

		}

		//affiche la page d'erreur si le faire part est d&eacute;sactiv&eacute;
		function error404(){
			global $langue;

			?>
			<center>
			<a href="<?php echo SITE_URL.'?'.$langue; ?>"><img src="<?php echo SITE_URL; ?>/app/app_fairepart/template/images/_defaut/header.jpg" ></a>
			<div style="background:#fff; border:solid 1px #d00072; width:450px; padding:30px 0; font-family:Verdana; font-size:16px; color:#000; font-weight:bold; text-align:center;">
			<?php 			echo "Le faire-part n'est pas ou plus disponible.<br><br>";
			?>
			<a href="<?php echo SITE_URL.'?'.$langue; ?>" style="font-size:12px; text-decoration:none; color:#000;"><?php echo $lang_inviter["RetourALaPageDAccueil"];?> <span style="text-decoration:underline; color:#d00072;">Babybook.ch</span></a>
			</div>
			<img src="<?php echo SITE_URL; ?>/app/app_fairepart/template/images/_defaut/footer.jpg" >
			</center>
			<?php 		}

		function envoyer(&$row) {
			global $langue;
			include("lang/app_inviter.".$_GET['lang'].".php");
			global $user;

			// variables
			JL::makeSafe($row, 'texte');

			// toolbar
			JLToolbar::open();
			JLToolbar::title('Faire-part: Envoi');
			JLToolbar::link(JL::url('index.php?app=fairepart&'.$langue), 'Fermer', 'Retour &agrave; la liste des faire-parts', 'annuler');

			JLToolbar::close();

			// panel haut
			JLPanel::open();

			?>


			<h4><?php echo $lang_inviter["ChoisissezVotreBoite"];?></h4>


			<table>
			<tr>
				<td><center>
				<a href="<?php echo JL::url('index.php?app=inviter&action=envoyer&id='.$row->id.'&type=hotmail').'&'.$langue; ?>"><img src="<?php echo SITE_URL; ?>/images/logo/hotmail.jpg"></a>
				<a href="<?php echo JL::url('index.php?app=inviter&action=envoyer&id='.$row->id.'&type=gmail').'&'.$langue; ?>"><img src="<?php echo SITE_URL; ?>/images/logo/gmail.jpg" style="padding:0 10px;"></a>
				<a href="<?php echo JL::url('index.php?app=inviter&action=envoyer&id='.$row->id.'&type=yahoo').'&'.$langue; ?>"><img src="<?php echo SITE_URL; ?>/images/logo/yahoo.jpg"></a>
				</center></td>
			</tr>
			</table>


			<?php 
			if(JL::cleanVar(JL::getVar('type', '')) == 'gmail'){
			?>
				<div id="gmail" name="gmail" class="gmail" >
				<form name="form1" method="post" action="<?php echo SITE_URL; ?>/index.php?<?php echo$langue;?>">
				  <table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><img src="<?php echo SITE_URL; ?>/images/logo/gmail-logo.jpg"></td>
						<td class="rose"><center><b><?php echo $lang_inviter["RechercherVosContacts"];?></b></center></td>
					</tr>
					<tr>
					  <td width="30%" class="roseClair"><strong><?php echo $lang_inviter["Email"];?>:</strong></td>
					  <td width="70%" class="roseClair"><input name="username" value="" type="text" id="username" class="input255"></td>
					</tr>
					<tr>
					  <td width="30%" class="roseClair"><strong><?php echo $lang_inviter["MotDePasse"];?>:</strong></td>
					  <td width="70%" class="roseClair"><input name="password" type="password" id="password" class="input255"></td>
					</tr>
					<tr>
					  <td colspan="2" class="rosePetit">*<?php echo $lang_inviter["VotreEmailEtMoi"];?>.</td>
					</tr>
					<tr>
					  <td colspan="2" class="rose"><center>
					  <input type="hidden" name="app" value="fairepart">
					  <input type="hidden" name="type" value="gmail" id="type">
					  <input type="hidden" name="site_url" value="<?php echo SITE_URL; ?>">
					  <img src="<?php echo SITE_URL; ?>/template/images/login-ok.jpg" onclick="javascript:rechercheContact();" style="cursor:pointer; " height="20" ></center></td>
					</tr>
				  </table>
				</form>
				</div>

			<?php 			}
			if(JL::cleanVar(JL::getVar('type', '')) == 'hotmail'){
			?>
				<div id="hotmail" name="hotmail" class="hotmail" >
				<form name="form2" method="post" action="<?php echo SITE_URL; ?>/index.php?<?php echo$langue?>">
				  <table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><img src="<?php echo SITE_URL; ?>/images/logo/hotmail-logo.jpg"></td>
						<td class="rose"><center><b><?php echo $lang_inviter["RechercherContactsHotmail"];?></b></center></td>
					</tr>
					<tr>
					  <td width="30%" class="roseClair"><strong><?php echo $lang_inviter["Email"];?>:</strong></td>
					  <td width="70%" class="roseClair"><input name="username" value="" type="text" id="username" class="input255"></td>
					</tr>
					<tr>
					  <td width="30%" class="roseClair"><strong><?php echo $lang_inviter["MotDePasse"];?>:</strong></td>
					  <td width="70%" class="roseClair"><input name="password" type="password" id="password" class="input255"></td>
					</tr>
					<tr>
					  <td colspan="2" class="rosePetit">*<?php echo $lang_inviter["VotreEmailEtMoi"];?>.</td>
					</tr>
					<tr>
					  <td colspan="2" class="rose"><center>
					  <input type="hidden" name="app" value="fairepart">
					  <input type="hidden" name="type" value="hotmail" id="type">
					  <input type="hidden" name="site_url" value="<?php echo SITE_URL; ?>">
					  <img src="<?php echo SITE_URL; ?>/template/images/login-ok.jpg" onclick="javascript:rechercheContact();" style="cursor:pointer; " height="20"></center></td>
					</tr>
				  </table>
				</form>
				</div>

			<?php 			}

			if(JL::cleanVar(JL::getVar('type', '')) == 'yahoo'){
			?>
			<div id="yahoo" name="yahoo" class="yahoo">
			<form name="form3" method="post" action="">
			  <table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><img src="<?php echo SITE_URL; ?>/images/logo/yahoo-logo.jpg"></td>
					<td class="rose"><center><b><?php echo $lang_inviter["RechercherContactsYahoo"];?></b></center></td>
				</tr>
				<tr>
				  <td width="30%" class="roseClair"><strong><?php echo $lang_inviter["Email"];?>:</strong></td>
				  <td width="70%" class="roseClair"><input name="username" value="" type="text" id="username" class="input255"></td>
				</tr>
				<tr>
				  <td width="30%" class="roseClair"><strong><?php echo $lang_inviter["MotDePasse"];?>:</strong></td>
				  <td width="70%" class="roseClair"><input name="password" type="password" id="password" class="input255"></td>
				</tr>
				<tr>
				  <td colspan="2" class="rosePetit">*<?php echo $lang_inviter["VotreEmailEtMoi"];?>.</td>
				</tr>
				<tr>
					  <td colspan="2" class="rose"><center>
					  <input type="hidden" name="app" value="fairepart">
					  <input type="hidden" name="type" value="yahoo" id="type">
					  <input type="hidden" name="site_url" value="<?php echo SITE_URL; ?>">
					  <img src="<?php echo SITE_URL; ?>/template/images/login-ok.jpg" onclick="javascript:rechercheContact();" style="cursor:pointer; " height="20"></center></td>
					</tr>
			  </table>
			</form>

			</div>
			<?php 			}
			?>
			<img src="<?php echo SITE_URL_ADMIN; ?>/images/loading.gif" id="loading" alt="Chargement..." class="loading" />
			<div class="contact" id="contact" style="display:none;">
				<div style="width:473px;"><?php echo $lang_inviter["SupprimerLesContacts"];?>.</div><br><br>
				<form name="listeContact" method="post" action="" id="listeContact">
					<input type="hidden" name="app" value="fairepart">
					<input type="hidden" name="site_url" value="<?php echo SITE_URL; ?>">
					<input type="hidden" name="action" value="import">
					<input type="image" src="<?php echo SITE_URL; ?>/template/images/abonnement/envoyer.jpg" name="envoyer" height="20" id="envoyer">
				</form>

			</div>
			<?php 			// panel bas
			JLPanel::close();

		}

		function import(&$row){
			global $langue;
			include("lang/app_inviter.".$_GET['lang'].".php");
			global $user;

			$tailleTab = sizeof($row->tabContact);

			// toolbar
			JLToolbar::open();
			JLToolbar::title('Faire-part: Envoi');
			JLToolbar::link(JL::url('index.php?app=fairepart&'.$langue), 'Fermer', 'Retour &agrave; la liste des faire-parts', 'annuler');

			JLToolbar::close();

			// panel haut
			JLPanel::open();
			?>
				<div class="boiteMail">
				<div class="fairepartHaut"></div>
				<div class="fairepartMilieu">
				<?php echo $lang_inviter["LeFairePartAEte"];?> :<br><br>

			<?php 				for($i=0; $i<$tailleTab; $i++){
					echo $row->tabContact[$i]."<br>";
				}
			?>
				</div>
				<div class="fairepartBas"></div>
				</div>
			<?php 			// panel bas
			JLPanel::close();



		}
	}
?>
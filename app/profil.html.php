<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	class HTML_profil {
		var $lang_appprofil;

		// affichage des messages syst&egrave;me
		function HTML_profil() {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			$this->lang_appprofil=$lang_appprofil;
		}
		
		
		function messages(&$messages) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			// s'il y a des messages &agrave; afficher
			if (is_array($messages)) {
			?>
				<script src="../../Scripts/swfobject_modified.js" type="text/javascript"></script>

				<h2 class="messages"><?php echo $lang_appprofil["MessagesParentSolo"];?></h2>
				<div class="messages">
				<?php 					// affiche les messages
					JL::messages($messages);
				?>
				</div>
				<br />
			<?php 			}

		}
		

		// menu en haut avec les steps
		function profil_titre($step_num = 0) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user, $action;
				
			
			// d&eacute;termine le texte du h1
			switch($step_num) {
				
				case 7:
					$etape = '';
					$h1 = $lang_appprofil["InscriptionInterrompu"];
					$pourcentage = '';
				break;
				
				case 6:
					$etape = '';
					$h1 = $lang_appprofil["InscriptionTerminee"];
					$pourcentage = ' - 100%';
				break;

				case 5:
					$etape = $lang_appprofil["Etape"].' '.$step_num.'/5 - ';
					$h1 = $lang_appprofil["Inscription"];
					$pourcentage = ' - 80%';
				break;

				case 4:
					$etape = $lang_appprofil["Etape"].' '.$step_num.'/5 - ';
					$h1 = $lang_appprofil["Inscription"];
					$pourcentage = ' - 60%';
				break;

				case 3:
					$etape = $lang_appprofil["Etape"].' '.$step_num.'/5 - ';
					$h1 = $lang_appprofil["Inscription"];
					$pourcentage = ' - 40%';
				break;

				case 2:
					$etape = $lang_appprofil["Etape"].' '.$step_num.'/5 - ';
					$h1 = $lang_appprofil["Inscription"];
					$pourcentage = ' - 20%';
				break;

				case 1:
				default:
					$etape = $lang_appprofil["Etape"].' 1/5 - ';
					$h1 = $lang_appprofil["Inscription"];
					$pourcentage = ' - 0%';
				break;

			}
			
			echo "<h2 class='barre'>".$etape.$h1.$pourcentage."</h2>"; 

		}


		function step1(&$row, &$list, $messages = array(), $notice = '', $conditions = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			// variables
			$captcha	= rand(2,7);

			
			if(!$user->id){
				// menu steps
				HTML_profil::profil_titre(1);
			}
		
		?>
		
		
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $row['disclaimer']->titre; ?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<div class="texte_explicatif"><?php echo $row['disclaimer']->texte; ?></div>
			<br />
			<?php 				// affichage des messages
				HTML_profil::messages($messages);
			?>
			<form action="index.php?app=profil&action=step1<?php echo '&'.$langue;?>" name="step1" method="post">
				<h3 class="form"><?php echo $lang_appprofil["ParametresCompte"];?></h2>			
				
				
				<div class="col-md-12 accountset">
				<div align="right" class="requiretext" ><small><?php echo $lang_appprofil["champsObligatoires"];?></small></div>
					<!-- Name -->
					<div class="formwidth bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["Nom"];?> *</label></div>
					<div class="col-md-9"><input type="text" name="nom" value="<?php echo $row['nom']; ?>" /></div>						
					</div>
					
					
					<div class="formwidth bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["Prenom"];?> *</label></div>
					<div class="col-md-9"><input type="text" name="prenom" value="<?php echo $row['prenom']; ?>" /></div>						
					</div>
					
					
					<div class="formwidth bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["Telephone"];?> *</label></div>
					<div class="col-md-9"><input type="text" name="telephone" value="<?php echo ($row['telephone']=='')?"+91":$row['telephone']; ?>" class="telephone" /></div>						
					</div>
					
					
					<div class="formwidth bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["Adresse"];?> *</label></div>
					<div class="col-md-9"><input type="text" name="adresse" value="<?php echo $row['adresse']; ?>" /></div>						
					</div>
					
					
					<div class="formwidth bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["CodePostal"];?> *</label></div>
					<div class="col-md-9"><input type="text" name="code_postal" value="<?php echo $row['code_postal']; ?>" /></div>						
					</div>
					
					
					<div class="formwidth bottompadding">
					<div class="col-md-12"><label><?php echo $lang_appprofil["LangueAppel"]; ?> *</label></div>
				    <div class="col-md-5">
						<?php if($row['langue_appel'] == 1){ ?>
									<input type="radio" name="langue_appel" value="1" style="width:20px;" CHECKED>
								<?php }else{ ?>
									<input type="radio" name="langue_appel" value="1" style="width:20px;">
								<?php } ?>
								<?php echo $lang_appprofil['Francais']; ?>
								
								<br />
								
								<?php if($row['langue_appel'] == 2){ ?>
									<input type="radio" name="langue_appel" value="2" style="width:20px;" CHECKED>
								<?php }else{ ?>
									<input type="radio" name="langue_appel" value="2" style="width:20px;">
								<?php } ?>
								<?php echo $lang_appprofil['Anglais']; ?>
								
								<br />
								
								<?php if($row['langue_appel'] == 3){ ?>
									<input type="radio" name="langue_appel" value="3" style="width:20px;" CHECKED>
								<?php }else{ ?>
									<input type="radio" name="langue_appel" value="3" style="width:20px;">
								<?php } ?>	
								<?php echo $lang_appprofil['Allemand']; ?>
						
					</div>
					</div>
					<br/> <hr /> <br/>
					<div class="formwidth bottompadding">
					<h4><?php echo $lang_appprofil["Moi"];?></h4>
				    </div>
					
					<div class="formwidth bottompadding">
					<div class="col-md-3"><label for="genre"><?php echo $lang_appprofil["Genre"];?> *</label></div>	
					<div class="col-md-9">	<?php 									// user log
									if($user->id) {

										?>
										<input type="hidden" name="genre" value="<?php echo $row['genre']; ?>" />
										<b>
										<?php 										if($row['genre'] == 'h') {
											echo $lang_appprofil["UnHomme"];
										} else {
											echo $lang_appprofil["UneFemme"];
										}
										?>
										</b>
										<?php 
									} else {
										echo $list['genre'];
									}
								?></div>
						
					</div>	
											
					<div class="formwidth bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["DateDeNaissance"];?> *</label></div>	
					<div class="col-md-9">
					<span class="col-md-3 nopadding"><?php echo $list['naissance_jour']; ?></span> <span class="nopadding col-md-3"><?php echo $list['naissance_mois']; ?></span> <span class="nopadding col-md-4"><?php echo $list['naissance_annee']; ?></span></div>
					</div>	
						
				    <div class="formwidth bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["SigneAstrologique"];?></label></div>	
					<div class="col-md-9"><?php echo $list['signe_astrologique_id']; ?></div>
					</div>
					
					<div class="formwidth bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["NombreDEnfants"];?></label></div>	
					<div class="col-md-9">	<?php echo $list['nb_enfants']; ?> <?php echo $lang_appprofil["enfant(s)"];?></div>
					</div>
					
					<div class="formwidth bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["Canton"];?> *</label></div>	
					<div class="col-md-9"><?php echo $list['canton_id']; ?></div>
					</div>
					
					<div class="formwidth bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["Ville"];?></label></div>	
					<div class="col-md-9" id="villes">	<?php echo $list['ville_id']; ?></div>
					</div>	
					
					<div class="formwidth bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["JesouhaiteTrouver"];?></label></div>
					<div class="col-md-9" id="step1gender">
						<?php 									switch($row['genre']) {

										case 'h':
											echo "<span class='femme'>".$lang_appprofil["UneFemme"]."</span>";
										break;

										case 'f':
											echo "<span class='homme'>".$lang_appprofil["UnHomme"]."</span>";
										break;

										default:
											echo $lang_appprofil["ChoisissezVotreGenre"];
										break;

									}
								?>
					
					</div>
					
				</div>
				<br /><hr /> <br />
				
				<div class="formwidth bottompadding">
				<div class="col-md-12"><h4><?php echo $lang_appprofil["MesDonnees"];?></h4></div>
				</div>
				
				<div class="formwidth bottompadding">
					<?php 						if(isset($list['parrain'])) {
					?>
					<div class="col-md-3">	<label><?php echo $lang_appprofil["Parrain"];?></label>
					</div>
					<div class="col-md-9"><span class="pink"><?php echo $list['parrain']; ?></span><?php if(!$user->id) { ?><input type="hidden" name="parrain_id" value="<?php echo $row['parrain_id']; ?>" /><?php } ?>
					</div>
					<?php 					   }
					?>
				</div>
				
				<div class="formwidth bottompadding">
					<div class="col-md-3"><?php 									// user log
									if($user->id) {
									?>
										<label><?php echo $lang_appprofil["Pseudo"];?> </label>
									<?php 									} else {
									?>
										<label for="usernameIns"><?php echo $lang_appprofil["Pseudo"];?> *</label>
									<?php 									}
								?></div>
					<div class="col-md-9"><?php 									// user log
									if($user->id) {
									?>
									<input type="hidden" name="username" value="<?php echo $row['username']; ?>" />
									<b><?php echo $row['username']; ?></b>
									<?php 									} else {
									?>
									<input type="text" name="username" id="usernameIns" value="<?php echo $row['username']; ?>" />
									<?php 									}
								?></div>
				</div>
				
				<div class="formwidth bottompadding">
				<div class="col-md-3">
					<label for="passwordIns">
								<?php 									// user log
									if($user->id) {
									?>
										<?php echo $lang_appprofil["ChangerMonMdp"];?>
									<?php 									} else {
									?>
										<?php echo $lang_appprofil["MotDePasse"];?>
									<?php 									}
								?> * 
					</label>
				</div>
				<div class="col-md-9">
					<input type="password" id="passwordIns" name="password" value="" />
                     &nbsp; <small> <?php echo $lang_appprofil["MdpInvalideCaracteresSpeciaux"];?> </small>					
				</div>
					
				</div>
				
				<div class="formwidth bottompadding">
				<div class="col-md-3">
	            <label for="password2Ins"><?php echo $lang_appprofil["ConfirmationDuMdp"];?> *</label>
				</div>
				<div class="col-md-9"><input type="password" name="password2" id="password2Ins" value="" />
				</div>
				</div>
				
				<div class="formwidth bottompadding">
				<div class="col-md-3"><label for="emailIns"><?php echo $lang_appprofil["Email"];?> *</label></div>
				<div class="col-md-9"><?php 									// user log
									if($user->id) {
									?>
										<b><?php echo $row['email']; ?></b>
										<input type="hidden" name="email" id="emailIns" value="<?php echo $row['email']; ?>" />
										<input type="hidden" name="email2" value="<?php echo $row['email']; ?>" />
									<?php 									} else {
									?>
										<input type="text" name="email" id="emailIns" value="<?php echo $row['email']; ?>" />
									<?php 									}
								?></div>					
				</div>
						
				<?php 				// user non log
				if(!$user->id)
				{
				?>
				
				<div class="formwidth bottompadding">
				<div class="col-md-3"><label for="email2Ins"><?php echo $lang_appprofil["ConfirmationEmail"];?> *</label></div>
				<div class="col-md-9"><input type="text" name="email2" id="email2Ins" value="<?php echo $row['email2']; ?>" /></div>
				</div>
					 
				<div class="row bottompadding">
				<div class="col-md-12">
					<input type="checkbox" name="offres" <?php if($row['offres'] == 1) {?>checked<?php } ?> style="width:20px;"  /> <b><?php echo $lang_appprofil["JeSouhaiteRecevoirOffresPartenaires"];?></b>
				</div>				
				</div>
				<div class="formwidth bottompadding">
				<div class="col-md-3"><label for="codesecurite"><?php echo $lang_appprofil["CodeDeSecurite"];?> *</label></div>
				<div class="col-md-9">
						<span class="capQ"><?php echo $lang_appprofil["CombienDeFleurs"];?> ?</span><br />
									<br />
									<?php 									$captcha = rand(2,7);
									JL::setSession('captcha', $captcha);
									for($i=0;$i<$captcha;$i++) {
									?>
										<img src="<?php echo SITE_URL; ?>/parentsolo/images/flower.png" alt="Fleur" align="left" />
									<?php 									}
									?>
									= <input type="text" name="codesecurite" id="codesecurite" value="" maxlength="2" style="width:60px;"/>					
				</div>
				</div>
				<?php 				}
				
				if(!$user->id) {
				?>
				<br /><hr /> <br />
				<div class="formwidth bottompadding">
				<div class="col-md-12"><h4><?php echo $lang_appprofil["CGU"];?></h4></div>									
				</div>
				<div class="row bottompadding">
				<div class="col-md-12">
				<div class="conditions">
										<div id="divConditions">
											<?php echo $conditions; ?>
										</div>
										
									
											<center>
												<input type="button" onClick="btnconditions(1);" id="conditionsAccept" value="<?php echo $lang_appprofil["JAccepte"];?>" style="width:100px;"/> <input type="button" onClick="btnconditions(0);" id="conditionsRefuse" value="<?php echo $lang_appprofil["JeRefuse"];?>" style="width:100px;"/><br />
											</center>
												<br />
												<b><?php echo $lang_appprofil["Conditions"];?>:</b> <span id="reponse"><?php echo $lang_appprofil["VeuillezLireLesCGU"];?></span>.
												<br />
												<br />
												<?php echo $lang_appprofil["EnCliquantSurLeBouton"];?>.
									
									</div>
							</div>
						</div>
						<?php 
							} 
						?>
				
					<div class="col-lg-12">
						<div class="text-right">
							<a href="javascript:document.step1.submit();" class="btn btn-primary bouton envoyer"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
						</div>							
					</div>
					<input type="hidden" name="lang" id="lang" value="<?php echo $_GET["lang"];?>" />
					<input type="hidden" id="condReadAccepted" value="<?php echo $lang_appprofil["condReadAccepted"];?>" />
					<input type="hidden" id="condReadNotAccepted" value="<?php echo $lang_appprofil["condReadNotAccepted"];?>" />
					<input type="hidden" name="conditions" id="inputconditions" value="<?php echo $row['conditions'] ; ?>" />
					<input type="hidden" name="app" value="profil" />
					<input type="hidden" name="action" value="step1submit" />
					<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
				</form>
</div>
				<script language="javascript" type="text/javascript">
					var scrollMax = 0;
					window.addEventListener('domready',function(){

						scrollMax = getScrollMax('divConditions');

						<?php if($row['conditions'] > 0) { ?>
							$('#conditionsAccept').disabled = false;
							$('#conditionsRefuse').disabled = false;
							$('#conditionsAccept').className = 'accept';
							$('#conditionsRefuse').className = 'refuse';
							btnconditions(1);
							$('#divConditions').scrollTop = scrollMax;
						<?php } else { ?>
							$('#conditionsAccept').disabled = true;
							$('#conditionsRefuse').disabled = true;
							$('#conditionsAccept').className = '';
							$('#conditionsRefuse').className = '';
							<?php if($row['conditions'] == 0) { ?>
								btnconditions(0);
							<?php } ?>
						<?php } ?>
					});
					
					<?php if(!$user->id) { ?>
					$('#divConditions').on('scroll', function() {
						if(this.scrollTop == scrollMax) {
							$('#conditionsAccept').disabled 	= false;
							$('#conditionsRefuse').disabled 	= false;
							$('#conditionsAccept').className = 'accept';
							$('#conditionsRefuse').className = 'refuse';
						} else {
							$('#conditionsAccept').disabled 	= true;
							$('#conditionsRefuse').disabled 	= true;
							$('#conditionsAccept').className = '';
							$('#conditionsRefuse').className = '';
						}
					});
					<?php } ?>
					function loadVilles(prefix) {
    prefix = prefix || '';

    var canton_id = $( prefix + 'canton_id').val() || '';
    var ville_id  = $( prefix + 'ville_id').val() || '';
    var lang      = $( prefix + 'lang').val() || '';
console.log(canton_id);
    $.ajax({
        url: site_url + '/app/app_home/ajax.php',
        method: 'GET',
        headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
        data: {
            canton_id: canton_id,
            ville_id: ville_id,
            lang: lang,
            prefix: prefix
        },
        success: function(response){
            $("#villes").html(response);
        },
        error: function(){
            console.log('Failed to load villes');
        }
    });
}

loadVilles();

				</script>
			<?php 		}


		function step2(&$data, &$row, &$list, $messages = array(), $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;


			// tableaux des photos
			$photos		= array();
			$valid		= false;

			// r&eacute;cup les miniatures de photos d&eacute;j&agrave; envoy&eacute;es
			$dir = 'images/profil/'.JL::getSession('upload_dir', 'error');
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {

					// r&eacute;cup les miniatures de photos pending
					if(preg_match('/pending.*109-profil/', $file)) {

						$photos_attente[]	= $dir.'/'.$file;
						$attente = 1;

					} elseif(preg_match('/109-profil/', $file) && !preg_match('/pending/', $file) && !preg_match('/temp/', $file)) { // r&eacute;cup les miniatures de photos valid&eacute;es

						$photos_validee[]	= $dir.'/'.$file;

					} elseif(preg_match('/temp.*109-profil/', $file)) { // photos temporaires

						$photos_temp[]	= $dir.'/'.$file;

					}

				}

			}			

			if(!$user->id){
				// menu steps
				HTML_profil::profil_titre(2);
			}		
			
		?>
			<h2 class="barre 3"><?php echo $data->titre; ?></h2>
			<div class="texte_explicatif">
				<img src="<?php echo SITE_URL; ?>/parentsolo/images/step2photo.png" alt="" align="right" style="margin:10px;" />
				<?php echo $data->texte; ?>
			</div>
		
			<?php 				// affichage des messages
				HTML_profil::messages($messages);
			?>
			<form action="index.php?app=profil&action=step2<?php echo '&'.$langue;?>" name="step2" method="post" enctype="multipart/form-data">
				
				<h3 class="form"><?php echo $lang_appprofil["MesPhotos"];?></h3>
				<!--<div class="formwidth bottompadding">
				<div class="col-md-3"></div>
				<div class="col-md-9"></div>
				</div>
				
				<div class="formwidth bottompadding">
				<div class="col-md-3"></div>
				<div class="col-md-9"></div>
				</div>
				
				<div class="formwidth bottompadding">
				<div class="col-md-3"></div>
				<div class="col-md-9"></div>	
				</div>-->
					
				
				
				
				
				<!--photo validation-->

	<div class="row content">
		

		<!--Ex 1-->
		<!--<div class="col-xs-12">
				<div class="demo profile-picture">
				<div class="crop-element circle" 
				data-name="profile_picture" 
				data-crop=">=200,>=200" 
				data-crop-open="true">
					<img class="circle findface"/>
					<input type="file"/>
				</div>
			</div>
			
		</div>

		Ex 6-->
		
			
		

		
		
		
		
		
	

		
		
		
		
		

		
	</div>

				<!--end photo Validation-->
				
				
				
				
				
				<table class="table_form" cellpadding="0" cellspacing="0">
					<tr>
						<td >
							<?php 								if($_GET['lang']=='fr'){
							?>
									<div class="swfu_btn 1 "><span id="spanButtonPlaceholder"></span></div>
							<?php 								}elseif($_GET['lang']=='en'){
							?>
							<div class="row content">
		

		<!--Ex -->
					<form action="index.php?app=profil&action=step2<?php echo '&'.$langue;?>" name="step2" method="post" enctype="multipart/form-data">

		<!--<div class="col-xs-12">
				<div class="demo profile-picture">
				<div class="crop-element circle1" 
				data-name="profile_picture" 
				data-crop=">=200,>=200" 
				data-crop-open="true">
					<img class="circle findface"  id="getval_id"/>
					
					<input type="file" name="Filedata" />
				</div>
			</div>
<div class="col-xs-12">
	<input type="submit" name="action" value="Submit" />
	


<div id='preview'>
</div>
</div><input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step2submit" />
				<input type="hidden" name="photo_defaut" value="<?php echo $row['photo_defaut']; ?>" />

				<?php // indispensable pour swfupload version s&eacute;curis&eacute; ?>
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
				<input type="hidden" name="upload_dir" id="upload_dir" value="<?php echo JL::getSession('upload_dir', 'error'); ?>" />
				<input type="hidden" name="hash" id="hash" value="<?php echo md5(date('y').JL::getSession('upload_dir', 'error').date('Y')); ?>" />

			</form>
		</div>-->
							
							
<form id="imageform" method="post" enctype="multipart/form-data" action='http://www.solocircl.com/newdev/ajaximage.php'>
<div class="demo profile-picture">
				<div class="crop-element circle1" 
				data-name="profile_picture" 
				data-crop=">=200,>=200" 
				data-crop-open="true">
					<img class="circle findface"  id="imag_val"/>				
					<input type="file" name="photoimg" id="photoimg" /><br>
			</div></div>	<br><input type="button" value="Add" class="submit" id="formsubmitval">
			<div id="newregimage" style="padding-top:20px;" ></div>
<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
<input type="hidden" name="upload_dir" id="upload_dir" value="<?php echo JL::getSession('upload_dir', 'error'); ?>" />

</form>
							<!--<span id="spanButtonPlaceholder"></span>-->
								<!--<div class="swfu_btn_en 1" onclick="alert();"><div class="demo profile-picture"><span id="spanButtonPlaceholder"></span></div></div>-->
								
							<?php 								}elseif($_GET['lang']=='de'){
							?>
								<div class="swfu_btn_de 1"><span id="spanButtonPlaceholder"></span></div>
							<?php 							}
							?>
						</td>
						<td>
							<div id="divFileProgressContainer"></div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div id="thumbnails">
							<?php 
								// affiche les miniatures de photos VALIDEES
								if (is_array($photos_temp)) {
									foreach($photos_temp as $photo_temp) {
										$photo_i_temp = preg_replace('#^.*([0-9]{1}).*$#', '$1', $photo_temp);
										?>
										<div class="miniature" id="<?php echo $photo_temp; ?>">
											<img src="<?php echo $photo_temp; ?>" class="findface" />
											<a href="javascript:deleteImage('<?php echo $photo_temp; ?>','','thumbnails');" class="btnDelete"><?php echo $lang_appprofil["Supprimer"];?></a>
											<?php if(!$user->id){?><a href="javascript:setDefault('<?php echo $photo_i_temp; ?>');" class="<?php echo $row['photo_defaut'] == $photo_i_temp ? 'yes' : 'no'; ?>" id="photo<?php echo $photo_i_temp; ?>"><?php echo $lang_appprofil["ParDefaut"];?></a><?}?>
										</div>
									<?php 									}
								}

							?>
							</div>
						</td>
					</tr>
				<?php 
					if(!$user->id){
				?>
						<tr>
							<td colspan="2">
								<div class="messages">
									<div class="warning">
										<span class="warning"><?php echo $lang_appprofil["AvantEtrePublierPhotos"];?>.</span>
									</div>
								</div>
							</td>
						</tr>
				<?	
					}
				?>
				<?php 
					if($user->id){
						// s'il y a des photos
						if (is_array($photos_temp)) {
						?>
						<tr>
							<td colspan="2">
								<div class="messages">
									<div class="warning">
										<span class="warning"><?php echo $lang_appprofil["PhotosNonEnAttente"];?>.</span>
									</div>
								</div>
							</td>
						</tr>
						<?php 						}
						?>
						<tr>
							<td colspan="2">
								<br /><hr /><br />
							</td>
						</tr>
						<tr>
							<td colspan="2" colspan="2">
							<h4><?php echo $lang_appprofil["PhotosAttente"];?></h4>
							<br />
								<div id="attente">
								
								<?php 
									// affiche les miniatures de photos VALIDEES
									if (is_array($photos_attente)) {
										foreach($photos_attente as $photo_attente) {
											$photo_i_attente = preg_replace('#^.*([0-9]{1}).*$#', '$1', $photo_attente);
											?>
											<div class="miniature" id="<?php echo $photo_attente; ?>">
												<img src="<?php echo $photo_attente; ?>" />
												<a href="javascript:deleteImage('<?php echo $photo_attente; ?>','','attente');" class="btnDelete"><?php echo $lang_appprofil["Supprimer"];?></a>
											</div>
										<?php 										}
									}

								?>
								</div>
							</td>
						</tr>
						<?php 						// s'il y a des photos
						if (is_array($photos_attente)) {
						?>
						<tr>
							<td colspan="2">
								<div class="messages">
									<div class="warning">
										<span class="warning"><?php echo $lang_appprofil["AvantEtrePublierPhotos"];?>.</span>
									</div>
								</div>
							</td>
						</tr>
						<?php 						}
						?>
						<tr>
							<td colspan="2">
								<br /><hr /><br />
							</td>
						</tr>
						<tr>
							<td colspan="2" colspan="2">
							<h4><?php echo $lang_appprofil["PhotosValidees"];?></h4>
							<br />
								<div id="validees">
								
								<?php 
									// affiche les miniatures de photos VALIDEES
									if (is_array($photos_validee)) {
										foreach($photos_validee as $photo_validee) {
											$photo_i_validee = preg_replace('#^.*([0-9]{1}).*$#', '$1', $photo_validee);
											?>
											<div class="miniature" id="<?php echo $photo_validee; ?>">
												<img src="<?php echo $photo_validee; ?>" />
												<a href="javascript:deleteImage('<?php echo $photo_validee; ?>','','validees');" class="btnDelete"><?php echo $lang_appprofil["Supprimer"];?></a>
												<a href="javascript:setDefault('<?php echo $photo_i_validee; ?>');" class="<?php echo $row['photo_defaut'] == $photo_i_validee ? 'yes' : 'no'; ?>" id="photo<?php echo $photo_i_validee; ?>"><?php echo $lang_appprofil["ParDefaut"];?></a>
											</div>
										<?php 										}
									}

								?>
								</div>
							</td>
						</tr>
					<?php 						}
					?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td class="key" valign="top"><label><?php echo $lang_appprofil["PageAccueil"];?></label></td>
						<td>
							<label class="radio-inline" for="photo_home_1"><input type="radio" name="photo_home" id="photo_home_1" value="1" <?php if($row['photo_home'] == 1) { ?>checked<?php } ?> style="width:20px;"/> <?php echo $lang_appprofil["MontrerPhotoHomePage"];?>.</label><br />
							<label class="radio-inline" for="photo_home_0"><input type="radio" name="photo_home" id="photo_home_0" value="0" <?php if($row['photo_home'] == 0) { ?>checked<?php } ?> style="width:20px;"/> <?php echo $lang_appprofil["NePasMontrerPhotoHomePage"];?>.</label>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<table class="toolbarsteps" cellpadding="0" cellspacing="0">
								<tr>
									<td class="text-left">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=inscription"."&".$langue); ?>" class="btn btn-primary bouton envoyer"><?php echo '&laquo; '.$lang_appprofil["EtapePrecedente"];?></a>
										<?php } ?>
									</td>
									<td class="text-center">
									</td>
									<td class="text-right">
										<a href="javascript:document.step2.submit();" class="btn btn-primary bouton envoyer"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step2submit" />
				<input type="hidden" name="photo_defaut" value="<?php echo $row['photo_defaut']; ?>" />

				<?php // indispensable pour swfupload version s&eacute;curis&eacute; ?>
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
				<input type="hidden" name="upload_dir" id="upload_dir" value="<?php echo JL::getSession('upload_dir', 'error'); ?>" />
				<input type="hidden" name="hash" id="hash" value="<?php echo md5(date('y').JL::getSession('upload_dir', 'error').date('Y')); ?>" />

			</form>
			
			<?php 				if($_GET['lang']=='fr'){
			?>
				<script type="text/javascript">
					uploaderInit_fr();
				</script>
			<?php 				}elseif($_GET['lang']=='en'){
			?>
				<script type="text/javascript">
					uploaderInit_en();
				</script>
			<?php 				}elseif($_GET['lang']=='de'){
			?>
				<script type="text/javascript">
					uploaderInit_de();
				</script>
			<?php 			}
			?>
			
		<?php 		}


		function step3(&$data, &$row, &$list, $messages = array(), $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			$annonce_limite = 2000;

			

			if(!$user->id){
				// menu steps
				HTML_profil::profil_titre(3);
			}
		

		?>
			<h2 class="barre 4"><?php echo $data->titre; ?></h2>
			<div class="texte_explicatif">
				<?php echo $data->texte; ?>
			</div>
			<br />
			<?php 				// affichage des messages
				HTML_profil::messages($messages);
			?>
			<form action="index.php?app=profil&action=step3<?php echo '&'.$langue;?>" name="step3" method="post">
				<h3 class="form"><?php echo $lang_appprofil["MonAnnonce"];?></h3>
				<div class="col-lg-12">
					<textarea name="annonce" class="annonce" onKeyDown="textCounter(this.form.annonce,parseInt(document.getElementById('chars_limit').innerHTML),<?php echo $annonce_limite; ?>);" onKeyUp="textCounter(this.form.annonce,parseInt(document.getElementById('chars_limit').innerHTML),<?php echo $annonce_limite; ?>);"><?php echo $row['annonce']; ?></textarea>
				    <label><?php echo $lang_appprofil["NombreDeCaracteres"];?>: <span id="chars_limit"><?php echo $annonce_limite-strlen(str_replace("\n",'',$row['annonce'])); ?></span></label>
					<div class="messages">
							<?php 								if($row['published'] == 0) {
								?>
									<div class="error">
										<span class="error"><?php echo $lang_appprofil["AnnonceRefusee"];?>.</span>
									</div>
								<?php 								} elseif($row['published'] == 1) {
								?>
									<div class="valid">
										<span class="valid"><?php echo $lang_appprofil["AnnonceValidee"];?> !</span>
									</div>
								<?php 								} elseif($row['annonce'] != '') {
								?>
									<div class="warning">
										<span class="warning"><?php echo $lang_appprofil["AvantEtrePublierAnnonce"];?>.</span>
									</div>
								<?php 								}
							?>
							
								<div class="warning">
									<span class="warning"><?php echo $lang_appprofil["ModificationAnnonce"];?>.</span>
								</div>
							</div>
				
					<div class="col-lg-12">
							<div class="text-left">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step2".'&'.$langue); ?>" class="btn btn-primary bouton envoyer"><?php echo '&laquo; '.$lang_appprofil["EtapePrecedente"];?></a>
										<?php } ?>
									</div>
									<div class="text-center">
									</div>
									<div class="text-right">
										<a href="javascript:document.step3.submit();" class="btn btn-primary bouton envoyer"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
									</div>
					</div>			
				</div>
				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step3submit" />
			</form>
			<?php 
		}


		function step4(&$data, &$row, &$list, $messages = array(), $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

		
			if(!$user->id){
				// menu steps
				HTML_profil::profil_titre(4);
			}
		
		?>
		<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title "><?php echo $data-> titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<div class="texte_explicatif"><?php echo $data-> texte;?></div>
			<?php 				// affichage des messages
				HTML_profil::messages($messages);
			?>
			<form action="index.php?app=profil&action=step4<?php echo '&'.$langue;?>" name="step4" method="post">
				<h3 class="form"><?php echo $lang_appprofil["MaDescription"];?></h3>
				
				<div class="col-md-12 accountset">
				<h4><?php echo $lang_appprofil["General"];?></h4>
				<br>
				<div class="descriptionform bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["Nationalite"];?></label></div>
					<div class="col-md-3"><?php echo $list['nationalite_id']; ?></div>
					<div class="col-md-3"><label><?php echo $lang_appprofil["Religion"];?></label></div>
					<div class="col-md-3"><?php echo $list['religion_id']; ?></div>
				</div>
				<div class="descriptionform bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["NiveauEtudes"];?></label></div>
					<div class="col-md-3"><?php echo $list['niveau_etude_id']; ?></div>
					<div class="col-md-3"><label><?php echo $lang_appprofil["SecteurActivite"];?></label></div>						
					<div class="col-md-3"><?php echo $list['secteur_activite_id']; ?></div>
				</div>
				
				<div class="descriptionform bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["StatutMarital"];?></label></div>
					<div class="col-md-3">	<?php echo $list['statut_marital_id']; ?></div>
				</div>
				
				<div class="descriptionform bottompadding">
					<div class="col-md-3"><label><?php echo $lang_appprofil["ModeDeVie"];?></label></div>
					<div class="col-md-3"><?php echo $list['vie_id']; ?></div>
				</div>
				<div class="descriptionform bottompadding">
				<div class="col-md-3"><label><?php echo $lang_appprofil["QuiLaGarde"];?> ?</label></div>
				<div class="col-md-3"><?php echo $list['garde_id']; ?></div>
				</div>
				
				<div class="descriptionform bottompadding">
				<div class="col-md-3"><label><?php echo $lang_appprofil["Fumeur"];?>?</label></div>
				<div class="col-md-3"><?php echo $list['fumer_id']; ?></div>
				</div>
				
				<div class="descriptionform bottompadding">
				<div class="col-md-3"><label><?php echo $lang_appprofil["Temperament"];?></label></div>
				<div class="col-md-3"><?php echo $list['temperament_id']; ?></div>
				</div>
				<br><hr />
				<div class="descriptionform bottompadding">
				<label><?php echo $lang_appprofil["LanguesParlees"];?></label>
				<div class="col-md-12" style="padding-top:8px;">
				<?php echo $list['langue_id']; ?>	
				</div>	
				</div>
				
				<div class="descriptionform bottompadding">
				<div class="col-md-3"><label><?php echo $lang_appprofil["RelationCherchee"];?></label></div>
				<div class="col-md-3"><?php echo $list['cherche_relation_id']; ?></div>
				<div class="col-md-3"><label><?php echo $lang_appprofil["LeMariageEst"];?></label></div>
				<div class="col-md-3"><?php echo $list['me_marier_id']; ?></div>
				</div>
				
				<div class="descriptionform bottompadding">
				<div class="col-md-3"><label><?php echo $lang_appprofil["NombreEnfantsSouhaites"];?></label></div>
				<div class="col-md-3"><?php echo $list['vouloir_enfants_id']; ?></div>
				</div>
				
				<hr /><br>
				
				<div class="descriptionform bottompadding">
				<h4><?php echo $lang_appprofil["Physique"];?></h4>
				</div>
				
				<div class="descriptionform bottompadding">
				<div class="col-md-2"><label><?php echo $lang_appprofil["Taille"];?></label></div>
				<div class="col-md-2"><?php echo $list['taille_id']; ?></div>
				<div class="col-md-2"><label><?php echo $lang_appprofil["Poids"];?></label></div>
				<div class="col-md-2"><?php echo $list['poids_id']; ?></div>
				<div class="col-md-2"><label><?php echo $lang_appprofil["Silhouette"];?></label></div>
				<div class="col-md-2"><?php echo $list['silhouette_id']; ?></div>
				</div>
				
				<div class="descriptionform bottompadding">
				<div class="col-md-2"><label><?php echo $lang_appprofil["Yeux"];?></label></div>
				<div class="col-md-2"><?php echo $list['yeux_id']; ?></div>
				<div class="col-md-2"><label><?php echo $lang_appprofil["Cheveux"];?></label></div>
				<div class="col-md-2"><?php echo $list['cheveux_id']; ?></div>
				<div class="col-md-2"><label><?php echo $lang_appprofil["Coiffure"];?></label></div>
				<div class="col-md-2"><?php echo $list['style_coiffure_id']; ?></div>
				</div>
				
				<div class="descriptionform bottompadding">
				<div class="col-md-2"><label><?php echo $lang_appprofil["Origine"];?></label></div>
				<div class="col-md-2"><?php echo $list['origine_id']; ?></div>
				</div>
				
				<br /><hr /><br />
				
				<div class="descriptionform bottompadding">
				<h4><?php echo $lang_appprofil["CentresInterets"];?></h4>
				</div>
				
				<div class="descriptionform bottompadding">
				<label><?php echo $lang_appprofil["Cuisine"];?></label>
				<div class="col-md-12">
				<?php echo $list['cuisine_id']; ?>
				</div>
				</div>
				
				<div class="descriptionform bottompadding">
				<label><?php echo $lang_appprofil["Sorties"];?></label>
				<div class="col-md-12">
				<?php echo $list['sortie_id']; ?>
				</div>
				</div>
				
				<div class="descriptionform bottompadding">
				<label><?php echo $lang_appprofil["Loisirs"];?></label>
				<div class="col-md-12">
				<?php echo $list['loisir_id']; ?>
				</div>
				</div>
				
				<div class="descriptionform bottompadding">
				<label><?php echo $lang_appprofil["PratiquesSportives"];?></label>
				<div class="col-md-12">
				<?php echo $list['sport_id']; ?>
				</div>
				</div>
				
				<div class="descriptionform bottompadding">
				<label><?php echo $lang_appprofil["Musique"];?></label>
				<div class="col-md-12">
				<?php echo $list['musique_id']; ?>
				</div>
				</div>
				
				<div class="descriptionform bottompadding">
				<label><?php echo $lang_appprofil["Films"];?></label>
				<div class="col-md-12">
				<?php echo $list['film_id']; ?>
				</div>
				</div>
				
				<div class="descriptionform bottompadding">
				<label><?php echo $lang_appprofil["Lecture"];?></label>
				<div class="col-md-12">
				<?php echo $list['lecture_id']; ?>
				</div>
				</div>
				
				<div class="descriptionform bottompadding">
				<label><?php echo $lang_appprofil["Animaux"];?></label>
				<div class="col-md-12">
				<?php echo $list['animaux_id']; ?>
				</div>
				</div>
				
				<div class="descriptionform bottompadding">
				<label><?php echo $lang_appprofil["Animaux"];?></label>
				<div class="col-md-12">
				<?php echo $list['animaux_id']; ?>
				</div>
				</div>
				<br /><hr /><br />
				<div class="descriptionform bottompadding">
				<div class="toolbarsteps">
				<div class="col-md-5">
				    <?php // user non log
					if(!$user->id) { ?>
							<a href="<?php echo JL::url("index.php?app=profil&action=step4".'&'.$langue); ?>" class="btn btn-primary bouton envoyer"><?php echo '&laquo; '.$lang_appprofil["EtapePrecedente"];?></a>
					<?php } ?>
				</div>
				<div class="col-md-4">
				</div>	
				<div class="col-md-3">
				<a href="javascript:document.step4.submit();" class="btn btn-primary bouton envoyer"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
				</div>	
					
				</div>	
				</div>				
				
				
				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step4submit" />
				
				</div>
				
			</form>
			<?php 
		}
		


		function step5(&$data, &$row, &$list, $messages = array(), $notice = '') {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

			

			// r&eacute;cup les miniatures de photos d&eacute;j&agrave; envoy&eacute;es
			
			$dir = 'images/profil/'.JL::getSession('upload_dir', 'error');
			if(is_dir($dir)) {
				$dir_id 	= opendir($dir);
				while($file = trim(readdir($dir_id))) {
					
					for($i=1;$i<=6;$i++) {
						// r&eacute;cup les miniatures de photos pending
						if(preg_match('/pending.*109-enfant-'.$i.'/', $file)) {

							$photo_attente[$i]	= $dir.'/'.$file;
							$attente[$i] = 1;

						} elseif(preg_match('/109-enfant-'.$i.'/', $file) && !preg_match('/pending/', $file) && !preg_match('/temp/', $file)) { // r&eacute;cup les miniatures de photos valid&eacute;es

							$photo_validee[$i]	= $dir.'/'.$file;

						} elseif(preg_match('/temp.*109-enfant-'.$i.'/', $file)) { // photos temporaires

							$photo_temp[$i]	= $dir.'/'.$file;

						}
					}
				}

			}
			
			if(!$user->id){
				// menu steps
				HTML_profil::profil_titre(5);
			}		

		?>
			
			<div class="parentsolo_txt_center"><h2 class="barre 7 parentsolo_title "><?php echo $data-> titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<div class="texte_explicatif"><?php echo $data-> texte;?></div>
			
			
		<?php 			// affichage des messages
			HTML_profil::messages($messages);
		?>
			<form action="index.php?app=profil&action=step5<?php echo '&'.$langue;?>" name="step5" method="post">
				<h3 class="form"><?php echo $lang_appprofil["MesEnfants"];?></h3>
				
				<div class="col-md-12 accountset">
					
			<?php 				// cr&eacute;ation des 6 blocks d'enfants
				for($i=1; $i<=6; $i++) {

					switch($i) {
						case 1:
							$enfant_num = $lang_appprofil["PremierEnfant"];
						break;

						case 2:
							$enfant_num = $lang_appprofil["SecondEnfant"];
						break;

						case 3:
							$enfant_num = $lang_appprofil["TroisiemeEnfant"];
						break;

						case 4:
							$enfant_num = $lang_appprofil["QuatriemeEnfant"];
						break;

						case 5:
							$enfant_num = $lang_appprofil["CinquiemeEnfant"];
						break;

						case 6:
							$enfant_num = $lang_appprofil["SixiemeEnfant"];
						break;

					}

				?>
				
					<div class="col-md-12">
							<div  id="child<?php echo $i; ?>" style="display:<?php echo $row['child'.$i] ? 'block' : 'none'; ?>;">
								<h4><?php echo $enfant_num; ?></h4>
								<br />
									<div class="formwidth bottompadding">
									<div class="col-md-3"><label><span class="childTitle"><?php echo $lang_appprofil["DateDeNaissance"];?></span></label></div>
									<div class="col-md-9">
									<div class="col-md-3 nopadding"><?php echo $list['naissance_jour'.$i]; ?></div>
									<div class="col-md-3 nopadding"><?php echo $list['naissance_mois'.$i]; ?></div>
									<div class="col-md-4 nopadding"><?php echo $list['naissance_annee'.$i]; ?></div>
									</div>
									</div>
									
									<div class="formwidth bottompadding">
									<div class="col-md-3"><label><span class="childTitle"><?php echo $lang_appprofil["Genre"];?></span></label></div>
									<div class="col-md-9"><?php echo $list['genre'.$i]; ?></div>
									</div>
									
									<div class="formwidth bottompadding">
									<div class="col-md-3"><label><span class="childTitle"><?php echo $lang_appprofil["SigneAstrologique"];?></span></label></div>
									<div class="col-md-9"><?php echo $list['signe_astrologique'.$i.'_id']; ?></div>
									</div>
									<br /><hr /><br />
								
								
								
									<div class="formwidth bottompadding">
										<div class="col-md-3">
										<?php 											if($_GET['lang']=='fr'){
										?>
												<div class="swfu_btn"><span id="spanButtonPlaceholder<?php echo $i; ?>"></span></div>
										<?php 											}elseif($_GET['lang']=='en'){
										?>
											<div class="swfu_btn_en"><span id="spanButtonPlaceholder<?php echo $i; ?>"></span></div>
										<?php 											}elseif($_GET['lang']=='de'){
										?>
											<div class="swfu_btn_de"><span id="spanButtonPlaceholder<?php echo $i; ?>"></span></div>
										<?php 										}
										?>
										</div>
										<div class="col-md-9">
											<div id="divFileProgressContainer<?php echo $i; ?>"></div>
										</div>
									   </div>
									
									
									
									<div class="formwidth bottompadding">
										<div class="col-md-12">
											<div id="thumbnails<?php echo $i; ?>">
											<?php 
												// affiche les miniatures de photos VALIDEES
												if($photo_temp[$i]) {
											?>
													<div class="miniature" id="<?php echo $photo_temp[$i]; ?>">
														<img src="<?php echo $photo_temp[$i]; ?>" />
														<a href="javascript:deleteImage('<?php echo $photo_temp[$i]; ?>','<?php echo $i; ?>','thumbnails<?php echo $i; ?>');" class="btnDelete"><?php echo $lang_appprofil["Supprimer"];?></a>
													</div>
											<?php 												}

											?>
											</div>
											</div>
										</div>
								
								<?php 
									if(!$user->id){
								?>
										<div class="formwidth bottompadding">
										<div class="col-md-12">
												<div class="messages">
													<div class="warning">
														<span class="warning"><?php echo $lang_appprofil["AvantEtrePublierPhotos"];?>.</span>
													</div>
												</div>
										</div>
										</div>
								<?	
									}
								?>
								<?php 
									if($user->id){
										// s'il y a des photos
										if($photo_temp[$i]) {
										?>
											
										<div class="formwidth bottompadding">
										<div class="col-md-12">
												<div class="messages">
													<div class="warning">
														<span class="warning"><?php echo $lang_appprofil["PhotosNonEnAttente"];?>.</span>
													</div>
												</div>
											</div>
										</div>
										<?php 										}
										?>
										
										<div class="formwidth bottompadding">
										<div class="col-md-12">
											<h2><?php echo $lang_appprofil["PhotosAttente"];?></h2>
											<br />
											<div id="attente<?php echo $i; ?>">
												
												<?php 
													// affiche les miniatures de photos VALIDEES
													if($photo_attente[$i]) {
												?>
														<div class="miniature" id="<?php echo $photo_attente[$i]; ?>">
															<img src="<?php echo $photo_attente[$i]; ?>" />
															<a href="javascript:deleteImage('<?php echo $photo_attente[$i]; ?>','<?php echo $i; ?>','attente<?php echo $i; ?>');" class="btnDelete"><?php echo $lang_appprofil["Supprimer"];?></a>
														</div>
												<?php 
													}

												?>
												</div>
											</div>
										</div>
										<?php 										// s'il y a des photos
										if (is_array($photo_attente[$i])) {
										?>
										
										<div class="formwidth bottompadding">
										<div class="col-md-12">
												<div class="messages">
													<div class="warning">
														<span class="warning"><?php echo $lang_appprofil["AvantEtrePublierPhotos"];?>.</span>
													</div>
												</div>
											</div>
										</div>
										<?php 										}
										?>
										
										<div class="formwidth bottompadding">
										<div class="col-md-12">
											<h3><?php echo $lang_appprofil["PhotosValidees"];?></h3>
											<br />
												<div id="validees<?php echo $i; ?>">
												
												<?php 
													// affiche les miniatures de photos VALIDEES
													if($photo_validee[$i]) {
												?>
														<div class="miniature" id="<?php echo $photo_validee[$i]; ?>">
															<img src="<?php echo $photo_validee[$i]; ?>" />
															<a href="javascript:deleteImage('<?php echo $photo_validee[$i]; ?>','<?php echo $i; ?>','validees<?php echo $i; ?>');" class="btnDelete"><?php echo $lang_appprofil["Supprimer"];?></a>
														</div>
													<?php 
													}

												?>
												</div>
											</div>
										</div>
									<?php 										}
									?>
									
									<br /><hr /><br />
										
							</div>
						</div>					
						
					<input type="hidden" name="child<?php echo $i; ?>" value="<?php echo $row['child'.$i] ? 1 : 0; ?>" />
							
						
				<?php 
					}

				?>

				<div class="formwidth bottompadding">
						<div class="col-md-12" align="middle">
							<div class="child_bar">
							<div class="col-md-4"><a href="javascript:childChange('+');" class="child_plus"><i style="padding-right:6px;" class="fa fa-plus" aria-hidden="true"></i><?php echo $lang_appprofil["AjouterEnfant"];?></a></div>
							<div class="col-md-4"><a href="javascript:childChange('-');" class="child_minus"><i style="padding-right:6px;" class="fa fa-minus" aria-hidden="true"></i><?php echo $lang_appprofil["RetirerEnfant"];?></a></div>
							</div>
						</div>
					</div>
				<br /><hr /><br />
					<div class="formwidth bottompadding">
					<div class="col-md-12"><?php echo $lang_appprofil["QuiPeutVoirLesPhotosDeMesEnfants"];?>?</h4></div>
					</div>
					<div class="formwidth bottompadding">
						<div class="col-md-12">
						   <div class="col-md-1"><input type="radio" name="photo_montrer" <?php if($row['photo_montrer'] == 0) { ?>checked<?php } ?> value="0" id="photo_montrer_0"  style="width:20px;" /></div><div class="col-md-11 nopadding"><label class="notoppadding" for="photo_montrer_0"><?php echo $lang_appprofil["UniquementLesModerateursDeParentsolo_ch"];?>.</label></div>
					    </div>
						<div class="col-md-12">
						  <div class="col-md-1"><input type="radio" name="photo_montrer" <?php if($row['photo_montrer'] == 2) { ?>checked<?php } ?> value="2" id="photo_montrer_2" style="width:20px;" /></div> <div class="col-md-11 nopadding"><label class="notoppadding" for="photo_montrer_2"><?php echo $lang_appprofil["TousLesMembresDeParentsolo_ch"];?>.</label></div>
					    </div> 
						</div>
					<div class="formwidth bottompadding">
							<div class="toolbarsteps" cellpadding="0" cellspacing="0">
								<div class="col-md-4">
										<?php // user non log
										if(!$user->id) { ?>
											<a href="<?php echo JL::url("index.php?app=profil&action=step4".'&'.$langue); ?>" class="btn btn-primary bouton envoyer"><?php echo '&laquo; '.$lang_appprofil["EtapePrecedente"];?></a>
										<?php } ?>
									</div>
									<div class="col-md-4">
									</div>
									<div class="col-md-4">
										<a href="javascript:document.step5.submit();" class="btn btn-primary bouton envoyer"><?php echo $user->id ? $lang_appprofil["Valider"] : $lang_appprofil["EtapeSuivante"].' &raquo;'; ?></a>
									</div>
							</div>
						</div>
				</div>
				
				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="step5submit" />

				<?php // indispensable pour swfupload version s&eacute;curis&eacute; ?>
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
				<input type="hidden" name="upload_dir" id="upload_dir" value="<?php echo JL::getSession('upload_dir', 'error'); ?>" />
				<input type="hidden" name="hash" id="hash" value="<?php echo md5(date('y').JL::getSession('upload_dir', 'error').date('Y')); ?>" />
				<input type="hidden" name="key" id="key" value="<?php echo $user->id ? md5($user->id) : md5(time()); ?>" />
				<input type="hidden" name="childNum" id="childNum" value="1" />

			</form>
				

			<?php 				if($_GET['lang']=='fr'){
			?>
				<script type="text/javascript">
					uploaderInitChildren_fr();
				</script>
			<?php 				}elseif($_GET['lang']=='en'){
			?>
				<script type="text/javascript">
					uploaderInitChildren_en();
				</script>
			<?php 				}elseif($_GET['lang']=='de'){
			?>
				<script type="text/javascript">
					uploaderInitChildren_de();
				</script>
			<?php 			}

		}


		function finalisation($notice) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			

			// menu steps
			HTML_profil::profil_titre(6);
		
			// affichage des messages
			HTML_profil::messages($messages);

		?>
				<div class="texte_explicatif">
					<?php echo $lang_appprofil["FelicitationsProfilCree"];?> !<br />
					<br />
					<br />
					<?php echo $lang_appprofil["ConnexionOK"];?><br />
					<br />
					<b><?php echo $lang_appprofil["Pseudo"];?>:</b> <?php echo makeSafe(JL::getSession('username', '')); ?><br />
					<b><?php echo $lang_appprofil["Pass"];?>:</b> <?php echo makeSafe(JL::getSession('password', '')); ?><br />
					<br />
					<br />
					<?php echo $lang_appprofil["NousVousSouhaitons"];?>.<br />
					<br />
					<?php echo $lang_appprofil["LequipeDeParentsolo"];?>
				</div>
			<?php 
		}
		
		function inscription_interrompu($notice) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			

			// menu steps
			HTML_profil::profil_titre(7);

			// affichage des messages
			HTML_profil::messages($messages);

		?>
			<div class="texte_explicatif">
				<?php echo $lang_appprofil["MalheureusementInscriptionInterrompu"];?> !<br />
				<br />
				<?php echo $lang_appprofil["VousPouvezRetenter"];?><br />
				<br />
				<br />
				<?php echo $lang_appprofil["LequipeDeParentsolo"];?>.<br />
				<br />
				<table class="toolbarsteps" cellpadding="0" cellspacing="0" style="width:100%;" >
					<tr>
						<td class="left"> </td>
						<td class="center">
							<a href="<?php echo JL::url('index.php?app=profil&action=inscription'.'&'.$langue); ?>" class="btn btn-primary bouton envoyer"><?php echo $lang_appprofil["NouvelleInscription"];?></a>
						</td>
						<td class="right"> </td>
					</tr>
				</table>
			</div>

			<?php 
		}
		
		
		
		// gestion des notifications de l'utilisateur
		function notification(&$row, $messages = array()) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $user;

		
			// affichage des messages
			HTML_profil::messages($messages);

		?>
			<form action="index.php?app=profil&action=notification<?php echo '&'.$langue;?>" name="notification" method="post">
				<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title"><?php echo $lang_appprofil["NotificationEmail"];?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
				
				<div class="col-sm-12 nopadding parentsolo_pt_10">
				<label><?php echo $lang_appprofil["CochezLesCasesSouhaites"];?>.</label>
				<div class="radio">					
				<label for="new_visite" <?php if($row['new_visite']) { ?>class="notificationActive"<?php } ?>>
				<input type="checkbox" name="new_visite" id="new_visite" <?php if($row['new_visite']) { ?>checked<?php } ?> style="width:20px;" />
				 <?php echo $row['genre'] == 'h' ? $lang_appprofil["UneMamanAConsulteVotreProfil"] : $lang_appprofil["UnPapaAConsulteVotreProfil"]; ?>.
				</label>
				</div>
				
				<div class="radio">
				<label for="new_message" <?php if($row['new_message']) { ?>class="notificationActive"<?php } ?>>
				<input type="checkbox" name="new_message" id="new_message" <?php if($row['new_message']) { ?>checked<?php } ?> style="width:20px;" />
				<?php echo $lang_appprofil["VousAvezNouveauMessage"];?>.
				</label>
				</div>
				
				<div class="radio">
				<label for="new_fleur" <?php if($row['new_fleur']) { ?>class="notificationActive"<?php } ?>><input type="checkbox" name="new_fleur" id="new_fleur" <?php if($row['new_fleur']) { ?>checked<?php } ?> style="width:20px;" /> <?php echo $lang_appprofil["VousAvezRecuNouvelleFleur"];?>.</label>
				</div>
				
				<div class="radio">
				<label for="rappels" <?php if($row['rappels']) { ?>class="notificationActive"<?php } ?>><input type="checkbox" name="rappels" id="rappels" <?php if($row['rappels']) { ?>checked<?php } ?> style="width:20px;" /> <?php echo $lang_appprofil["DiversRappels"];?>.</label>
				</div>
				
				</div>	
				<div class="col-sm-12 nopadding">							
					
									<div class="text-right">
										<a href="javascript:document.notification.submit();" class="btn btn-primary bouton envoyer"><?php echo $lang_appprofil["Valider"];?></a>
									</div>
									</div>
					
				
				<input type="hidden" name="app" value="profil" />
				<input type="hidden" name="action" value="notificationsubmit" />
			</form>
			<?php 
		}
		
		
		// affichage du profil
		function profil(&$profil, &$profilEnfants, &$profilDescription, &$profilInfosEnVrac1, &$profilInfosEnVrac2, &$profilQuotidien1, &$profilQuotidien2, &$profilQuotidien3, &$profilQuotidien4, &$profilGroupes) {
			global $langue;
			include("lang/app_profil.".$_GET['lang'].".php");
			global $action, $user;

			// variables
			$dir 			= 'images/profil/'.$profil->id; // dossier contenant les photos du membre
			$photos			= array(); // tableaux des photos
			$nonRenseigne	= $lang_appprofil["JeLeGarde"].'.';
			$langues		= array();
			
			
			$labelEnfant		= $lang_appprofil["Enfants"];
			$labelDescription	= $lang_appprofil["Description"];
			$labelPhotos	= $lang_appprofil["Photos"];
			$labelGroupes		= $lang_appprofil["Groupes"];
			$labelAnnonce		= $lang_appprofil["Annonce"];

			// htmlentities
			JL::makeSafe($profil);
			JL::makeSafe($profilDescription);
			JL::makeSafe($profilInfosEnVrac1);
			JL::makeSafe($profilInfosEnVrac2);
			JL::makeSafe($profilQuotidien1);
			
			// profil existe
			if($profil->accessok) {

				// r&eacute;cup la photo par d&eacute;faut de l'utilisateur
				$photoDefaut = JL::userGetPhoto($profil->id, 'profil', '', $profil->photo_defaut);

				// pas de photo par d&eacute;faut
				if(!$photoDefaut) {
					$photoDefaut = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$profil->genre.'-'.$_GET['lang'].'.jpg';
				}

				// r&eacute;cup les photos de l'utilisateur, autres que celle par d&eacute;faut
				if(is_dir($dir)) {

					$dir_id 	= opendir($dir);
					while($file = trim(readdir($dir_id))) {

						// r&eacute;cup les miniatures de photos
						if(preg_match('/^parent-solo-35-profil/', $file)) { // r&eacute;cup les micro-miniatures de photos valid&eacute;es

							$photos[]	= $dir.'/'.$file;

						}

					}

				}

				// conserve le nombre de photos
				$photosNb	= count($photos);

				// g&eacute;n&eacute;ration de la chaine des langues
				$profilInfosEnVrac1->langues	= HTML_profil::profil3values($profilInfosEnVrac1, 'langue', $nonRenseigne);

				// g&eacute;n&eacute;ration de la chaine des cuisines
				$profilQuotidien1->cuisines		= HTML_profil::profil3values($profilQuotidien1, 'cuisine', $nonRenseigne);
				$profilQuotidien1->sorties		= HTML_profil::profil3values($profilQuotidien1, 'sortie', $nonRenseigne);
				$profilQuotidien2->loisirs		= HTML_profil::profil3values($profilQuotidien2, 'loisir', $nonRenseigne);
				$profilQuotidien2->sports		= HTML_profil::profil3values($profilQuotidien2, 'sport', $nonRenseigne);
				$profilQuotidien3->musiques		= HTML_profil::profil3values($profilQuotidien3, 'musique', $nonRenseigne);
				$profilQuotidien3->films		= HTML_profil::profil3values($profilQuotidien3, 'film', $nonRenseigne);
				$profilQuotidien4->animaux		= HTML_profil::profil3values($profilQuotidien4, 'animaux', $nonRenseigne);
				$profilQuotidien4->lectures		= HTML_profil::profil3values($profilQuotidien4, 'lecture', $nonRenseigne);

				// class suppl&eacute;mentaire au last_online

				
				// en ligne
				if($profil->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $profil->online) { // 30 minutes (60*30)

					$last_online_class 		= 'lo_online';
					$last_online_label		= $lang_appprofil["EnLigne"];

				} elseif($profil->last_online_time < 86400) { // aujourd'hui (60*60*24)

					$last_online_class 	= 'lo_offline';
					$last_online_label	= $lang_appprofil["Aujourdhui"];

				} elseif($profil->last_online_time < 172800) { // hier (60*60*24*2)

					$last_online_class 	= 'lo_offline';
					$last_online_label	= $lang_appprofil["Hier"];

				} elseif($profil->last_online_time < 604800) { // cette semaine (60*60*24*7)

					$last_online_class 	= 'lo_offline';
					$last_online_label	= $lang_appprofil["CetteSemaine"];

				} else {
				
					$last_online_class 		= 'lo_offline';
					$last_online_label		= $lang_appprofil["PlusDe2Semaines"];
				
				}

				?>
				
				  <div class="parallax"> </div>
				  <div id="wrapper">
				  <div class="container">
			      <div class="row">
			      <!-- Profile Informations-->
                <div class="profile col-md-3 wow fadeInDown">
                    <div class="profile-image">
                      <img src="<?php echo $photoDefaut; ?>" alt="<?php echo $profil->username; ?>" />
                    </div>
                    <div class="profile-info">
                    	<div class="name-job">
                            <h1><span class="<?php echo $profil->genre == 'h' ? "homme" : "femme"; ?>"><?php echo $profil->username; ?></span></h1>
                            <span class="job"><?php echo $lang_appprofil["DerniereConnexion"];?>:
							<span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span><br />
							<?php echo $lang_appprofil["Inscription"]; ?>: <?php echo date('d.m.Y', strtotime($profil->creation_date)); ?></span>
                        </div><!-- .name-job -->                        
                       
					   <div class="col-md-12">
						<div class="service">
                            <a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$profil->username.'&'.$langue); ?>" target="_blank" title="<?php echo $lang_appprofil["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
                            <span><b><a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$profil->username.'&'.$langue); ?>" target="_blank" title="<?php echo $lang_appprofil["EnvoyerUnMail"];?>"><?php echo $lang_appprofil["EnvoyerUnMail"];?></a></b></span>                                  
                        </div>
					   </div>
					   
					   <div class="col-md-12">
					   <div class="service">
						<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$profil->username.'&'.$langue); ?>" target="_blank" title="<?php echo $lang_appprofil["EnvoyerUneRose"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
					     <span><b><a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$profil->username.'&'.$langue); ?>" target="_blank" title="<?php echo $lang_appprofil["EnvoyerUneRose"];?>"><?php echo $lang_appprofil["EnvoyerUneRose"];?></a></b></span>        
					   </div>
					   </div>
					   
					   <div class="col-md-12">
					   <div class="service">
						<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$profil->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_appprofil["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a></td>
						<span><b><a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$profil->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_appprofil["Chat"];?>"><?php echo $lang_appprofil["Chat"];?></a></b></span>        
					   </div>
					   </div>
					
					
						<div class="col-md-12">
					    <div class="service">
						<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["AjouterAuxFavoris"];?>" target="_blank"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a></td>
						<span><b><a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["AjouterAuxFavoris"];?>" target="_blank"><?php echo $lang_appprofil["AjouterAuxFavoris"];?></a></b></span>
						</div>
					    </div>
						<div class="col-md-12">
					    <div class="service">
						<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["AjouterALaListeNoire"];?>" target="_blank"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a></td>
						<span><b><a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["AjouterALaListeNoire"];?>" target="_blank"><?php echo $lang_appprofil["AjouterALaListeNoire"];?></a></b></span>
						</div>
					    </div>
						<div class="col-md-12">
					    <div class="service">
						<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["SignalerUnAbus"];?>" target="_blank"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a></td>
						<span><b><a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["SignalerUnAbus"];?>" target="_blank"><?php echo $lang_appprofil["SignalerUnAbus"];?></a></b></span>
						</div>
					    </div>
						<div style="clear:both;"></div>
                    </div>
                </div> <!--.profile .col-md-3-->
				
				 <!--Right Section-->
                <div id="tab-container" class="col-md-9">
                    	<!--Top Menu -->
                        <div class="responsive-menu hidden-md hidden-lg">MENU</div>				
						<?php JL::loadMod("menu_profil");?>
					
					<?php 
							// affichage des donn&eacute;es sp&eacute;cifiques de la page
							switch($action) {
								
								// DESCRIPTION
								case 'view':
								?>
							
                       <!--Description Section-->
                    <div id="about" class="content col-md-12 fadeInUp">
                    	<div class="row">
                    		<div class="page-title">
								<h2 class="result"><?php echo $labelDescription; ?></h2>
						 </div>
						 <div class="col-md-12 pinfo">	
						<table class="result" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td>
												<h2 class="section-title"><?php echo $lang_appprofil["Moi"];?></h2>
												<table class="detail_table" cellpadding="0" cellspacing="0" width="100%">
													<tr><td class="key"><?php echo $lang_appprofil["Age"];?></td><td class="result"><?php echo JL::calcul_age($profil->naissance_date); ?></td></tr>
													<tr><td class="key"><?php echo $labelEnfant;?></td><td class="result"><?php echo $profil->nb_enfants; ?> <?php echo $profil->nb_enfants > 1 ? $lang_appprofil["enfants"] : $lang_appprofil["enfant"]; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Canton"];?></td><td class="result"><?php echo $profil->canton; ?></td></tr>
													<tr><td class="key fin"><?php echo $lang_appprofil["Ville"];?></td><td class="result fin"><?php echo $profil->ville ? $profil->ville : $lang_appprofil["NonRenseigne"]; ?></td></tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>
												<h2 class="section-title"><?php echo $lang_appprofil["General"];?></h2>
												<table class="detail_table" cellpadding="0" cellspacing="0" width="100%">
													<tr><td class="key"><?php echo $lang_appprofil["Nationalite"];?></td><td class="result"><?php echo $profilInfosEnVrac1->nationalite ? $profilInfosEnVrac1->nationalite : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Religion"];?></td><td class="result"><?php echo $profilInfosEnVrac1->religion ? $profilInfosEnVrac1->religion : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["NiveauEtudes"];?></td><td class="result"><?php echo $profilInfosEnVrac2->niveau_etude ? $profilInfosEnVrac2->niveau_etude : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["SecteurActivite"];?></td><td class="result"><?php echo $profilInfosEnVrac2->secteur_activite ? $profilInfosEnVrac2->secteur_activite : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["StatutMarital"];?></td><td class="result"><?php echo $profilInfosEnVrac1->statut_marital ? $profilInfosEnVrac1->statut_marital : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["ModeDeVie"];?></td><td class="result"><?php echo $profilQuotidien1->vie ? $profilQuotidien1->vie : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["QuiLaGarde"];?>?</td><td class="result"><?php echo $profilInfosEnVrac2->garde ? $profilInfosEnVrac2->garde : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Fumeur"];?>?</td><td class="result"><?php echo $profilInfosEnVrac2->fumer ? $profilInfosEnVrac2->fumer : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Temperament"];?></td><td class="result"><?php echo $profilInfosEnVrac2->temperament ? $profilInfosEnVrac2->temperament : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["LanguesParlees"];?></td><td class="result"><?php echo $profilInfosEnVrac1->langues ?></td></tr>
													<tr><td>&nbsp;</td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["RelationCherchee"];?></td><td class="result"><?php echo $profilInfosEnVrac2->cherche_relation ? $profilInfosEnVrac2->cherche_relation : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["LeMariageEst"];?></td><td class="result"><?php echo $profilInfosEnVrac1->me_marier ? $profilInfosEnVrac1->me_marier : $nonRenseigne; ?></td></tr>
													<tr><td class="key fin"><?php echo $lang_appprofil["NombreEnfantsSouhaites"];?></td><td class="result fin"><?php echo $profilInfosEnVrac2->vouloir_enfants ? $profilInfosEnVrac2->vouloir_enfants : $nonRenseigne; ?></td></tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>
												<h2 class="section-title"><?php echo $lang_appprofil["Physique"];?></h2>
												<table class="detail_table" cellpadding="0" cellspacing="0" width="100%">
													<tr><td class="key"><?php echo $lang_appprofil["Taille"];?></td><td class="result"><?php echo $profilDescription->taille ? $profilDescription->taille.' cm' : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Poids"];?></td><td class="result"><?php echo $profilDescription->poids ? $profilDescription->poids.' kg' : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Silhouette"];?></td><td class="result"><?php echo $profilDescription->silhouette ? $profilDescription->silhouette : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Yeux"];?></td><td class="result"><?php echo $profilDescription->yeux ? $profilDescription->yeux : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Cheveux"];?></td><td class="result"><?php echo $profilDescription->cheveux ? $profilDescription->cheveux : $nonRenseigne; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Coiffure"];?></td><td class="result"><?php echo $profilDescription->style_coiffure ? $profilDescription->style_coiffure : $nonRenseigne; ?></td></tr>
													<tr><td class="key fin"><?php echo $lang_appprofil["Origine"];?></td><td class="result fin"><?php echo $profilDescription->origine ? $profilDescription->origine : $nonRenseigne; ?></td></tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>
												<h2 class="section-title"><?php echo $lang_appprofil["CentresInterets"];?></h2>
												<table class="detail_table" cellpadding="0" cellspacing="0" width="100%">
													<tr><td class="key"><?php echo $lang_appprofil["Cuisine"];?></td><td class="result"><?php echo $profilQuotidien1->cuisines; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Sorties"];?></td><td class="result"><?php echo $profilQuotidien1->sorties; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Loisirs"];?></td><td class="result"><?php echo $profilQuotidien2->loisirs; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["PratiquesSportives"];?></td><td class="result"><?php echo $profilQuotidien2->sports; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Musique"];?></td><td class="result"><?php echo $profilQuotidien3->musiques; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Films"];?></td><td class="result"><?php echo $profilQuotidien3->films; ?></td></tr>
													<tr><td class="key"><?php echo $lang_appprofil["Lecture"];?></td><td class="result"><?php echo $profilQuotidien4->lectures; ?></td></tr>
													<tr><td class="key fin"><?php echo $lang_appprofil["Animaux"];?></td><td class="result fin"><?php echo $profilQuotidien4->animaux; ?></td></tr>
												</table>
											</td>
										</tr>
									</table>
						</div>
					</div>
					</div>
					<?php 					break;
					// ANNONCE
					case 'view2':
					?>
					 <div id="advertisement" class="content col-md-12">
						<div class="row">
						<div class="page-title">
							<h2 class="detail"><?php echo $labelAnnonce; ?></h2>
						</div>
						<div class="col-md-12 pinfo">
						<table class="detail_table" cellpadding="0" cellspacing="0" width="100%">
							<tr>
							<td class="annonce"><?php echo $profil->annonce ? nl2br($profil->annonce) : $lang_appprofil["NAPasRedigeAnnonce"].' .'; ?></td>
							</tr>
						</table>
						</div>
						</div>
						</div>
					 
					 	
								<?php 								break;
								// PHOTOS
								case 'view3':
									
								?>
								 <div id="resume" class="content col-md-12">
                    	         <div class="row">
									<div class="page-title">
									<h2 class="result"><?php echo $labelPhotos; ?></h2>
									</div>
									<div class="col-md-12 pinfo">
									<table class="result" cellpadding="0" cellspacing="0" width="100%">
										<tr><td align="middle"><img src="<?php echo $photoDefaut; ?>" alt="Parent c&eacute;libataire <?php echo $profil->username; ?>" class="big" id="profilPhotoDefaut" /></td></tr>
									<?php 										// s'il y a plus d'une photo
										if($photosNb > 1) {
											$i = 0;
											?>
											<tr><td>&nbsp;</td></tr>
											<tr>
												<td>
													<table class="miniatures" cellpadding="0" cellspacing="0" width="100%">
														<tr align="middle">
														<?php 															// pour chaque photo
															foreach($photos as $photo) {

																// on limite &agrave; 6 photos
																if($i < 6) {
																	$photo_i = preg_replace('#^.*([0-9]{1}).*$#', '$1', $photo);

																	?>
																		<td class="miniature"><img src="<?php echo SITE_URL.'/'.$photo; ?>" alt="<?php echo $profil->username; ?><?php echo $photo_i; ?>" class="mini_photo <?php echo $i; ?>" id="profilPhoto<?php echo $photo_i; ?>" onClick="javascript:setProfilPhoto('<?php echo $profil->id; ?>', '<?php echo $photo_i; ?>');" /></td>
																	<?php 																	$i++;
																}

															}
														?>
														</tr>
													</table>
												</td>
											</tr>
									<?php 										}
									?>	
					        </table>
							</div>
							</div>
							</div>
					 
					     	   <?php 								break;
								// ENFANTS
								case 'view4':
								?>
								    <!--result Section -->
                                    <div id="result" class="content col-md-12">
									<div class="row">
									<div class="page-title">
									<h2 class="result"><?php echo $labelEnfant; ?></h2>
									</div>
									<div class="col-md-12 pinfo">
									<table class="result" cellpadding="0" cellspacing="0" width="100%">
									<?php 										// montrer photos des enfants
										if (is_array($profilEnfants)) {
										
											// pour chaque enfant
											$i		= 1;
											$iMin 	= 1;
											$iMax	= count($profilEnfants);
											foreach($profilEnfants as $enfant) {

												switch($i) {
													case 1:
														$enfant_num = $lang_appprofil["PremierEnfant"];
													break;

													case 2:
														$enfant_num = $lang_appprofil["SecondEnfant"];
													break;

													case 3:
														$enfant_num = $lang_appprofil["TroisiemeEnfant"];
													break;

													case 4:
														$enfant_num = $lang_appprofil["QuatriemeEnfant"];
													break;

													case 5:
														$enfant_num = $lang_appprofil["CinquiemeEnfant"];
													break;

													case 6:
														$enfant_num = $lang_appprofil["SixiemeEnfant"];
													break;

												}
												
												// r&eacute;cup la photo
												$file 				= $dir.'/parent-solo-enfant-'.$enfant->num.'.jpg';
												$file				= is_file($file) && $profil->photo_montrer == 2 ? $file : 'parentsolo/images/parent-solo-enfant-'.$enfant->genre.'-'.$_GET['lang'].'.jpg';

												// modifie le genre
												$enfant->genre		= $enfant->genre == 'f' ? $lang_appprofil["Fille"] : $lang_appprofil["Garcon"];

											?>
												<tr>
													<td>
														
														<div class="col-md-4 parentsolo_txt_center">
														
														<div class="hovereffect ">
															<img src="<?php echo SITE_URL.'/'.$file; ?>" alt="<?php echo $enfant->genre; ?> - <?php echo $profil->username; ?>" />														
														
														<div class="overlay"><h2><?php echo $enfant_num;?></h2></div>
														</div>
														<div class="clear"></div>
														<h3 class=""></h3>
														<div class="col-md-12 nopadding">
														<div class="col-md-4" style="text-align:left"><?php echo $enfant->genre; ?></div>
														<div class="col-md-8" style="text-align:right"><?php echo JL::calcul_age($enfant->naissance_date); ?></div>
														</div>
														<div class="col-md-12">
														<?php 														if($enfant->signe_astrologique) { 
														?>
														<p><?php echo $enfant->signe_astrologique; ?></p>
														<?php 														} 
														?>
														
														</div>
														
														</div>
														
														<!--<table class="detail_table" cellpadding="0" cellspacing="0" width="100%">
															<tr>
																<td class="photo">
																	
																</td>
																<td class="detail_enfant">
																	<table class="detail_enfant" cellpadding="0" cellspacing="0" width="100%">
																		<tr>
																			<td><?php echo $enfant->genre; ?></td>
																		</tr>
																			<tr>
																				<td>
																					<?php echo JL::calcul_age($enfant->naissance_date); ?>
																				</td>
																			</tr>
																	<?php 																		if($enfant->signe_astrologique) { 
																	?>
																			<tr>
																				<td><?php echo $enfant->signe_astrologique; ?></td>
																			</tr>
																	<?php 																		} 
																	?>
																	</table>
																</td>
															</tr>
														</table>-->
													</td>
												</tr>
											<?php 												if($i!=$iMax){
													echo "<tr><td>&nbsp;</td></tr>";
												}
										
												$i++;
											}
												
										} else {
								?>			
											
										<tr>
											<td align="middle"><?php echo $lang_appprofil["DetailsEnfantNonIndique"].' .' ;?></td>
										</tr>
								<?php
										}
								?>
											
						</table>
						</div>
						</div>
						</div>
					<?php 								break;
								// GROUPES
								case 'view5':
								?>
								<!--Group Section -->
                                    <div id="group" class="content col-md-12">
									<div class="row">
									<div class="page-title">										
									<h2 class="result"><?php echo $labelGroupes; ?></h2>
									</div>
									<div class="col-md-12 pinfo">
									<table class="result" cellpadding="0" cellspacing="0" width="100%">
									<?php 										// s'il y a des groupes
										if (is_array($profilGroupes) > 0) {
											
												$i = 1;

												// pour chaque groupe
												foreach($profilGroupes as $groupe) {
													
													$groupe->texte = strip_tags(html_entity_decode($groupe->texte));
													if(strlen($groupe->texte) > LISTE_INTRO_CHAR) {
														$groupe->texte = substr($groupe->texte, 0, LISTE_INTRO_CHAR).'...';
													}
													
													// htmlentities
													JL::makeSafe($groupe,'texte');

													// si une photo a &eacute;t&eacute; envoy&eacute;e
													$filePath = 'images/groupe/'.$groupe->id.'.jpg';
													if(is_file(SITE_PATH.'/'.$filePath)) {
														$image	= $filePath;
													} else {
														$image	= 'parentsolo/images/parent-solo-109-'.$_GET['lang'].'.jpg';
													}

												?>
													<tr>
														<td>
															<h3 class="profilegroup"><a href="<?php echo JL::url('index.php?app=groupe&action=details&id='.$groupe->id.'&'.$langue); ?>" title="<?php echo $groupe->titre; ?>" target="_blank"><?php echo $groupe->titre; ?></a></h3>
															<table class="detail_table" cellpadding="0" cellspacing="0" width="100%">
																<tr>
																	<td class="groupe"><a href="<?php echo JL::url('index.php?app=groupe&action=details&id='.$groupe->id.'&'.$langue); ?>" title="<?php echo $groupe->titre; ?>" target="_blank">
																	<img class="groupeffect parentsolo_border_radius" src="<?php echo SITE_URL.'/'.$image; ?>" alt="<?php echo $groupe->titre; ?>" /></a></td>
																	<td class="annonce"><?php echo $groupe->texte; ?></td>
																</tr>
															</table>
														</td>
													</tr>
												<?php 												if($i!=count($profilGroupes)){
													echo "<tr><td>&nbsp;</td></tr>";
												}
										
												$i++;
											}
												
										} else {
										?>
											<tr>
												<td align="middle"><?php echo $lang_appprofil["NARejointAucunGroupe"];?>!</td>
											</tr>
									<?php 										}
									?>
									</table>
							</div>
							</div>
							</div>
					<?php 								break;



							}

					?>				
                   	<!--Right Content -->
                   
                </div> <!-- #tab-container .col-md-9 end -->
				
				
		</div>	
		</div>
		</div>
				
				<div class="content">
					<!--<div class="contentl">
						<div class="profil">
							<img src="<?php echo $photoDefaut; ?>" alt="<?php echo $profil->username; ?>" />
					
							<h3><span class="<?php echo $profil->genre == 'h' ? "homme" : "femme"; ?>"><?php echo $profil->username; ?></span></h2>
							<?php echo $lang_appprofil["DerniereConnexion"];?>:<br />
							<span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span><br />
							<?php echo $lang_appprofil["Inscription"]; ?>: <?php echo date('d.m.Y', strtotime($profil->creation_date)); ?>
						</div>	
						<br />
						<div class="actions">
							<table class="actions message" cellpadding="0" cellspacing="0">
								<tr>
									<td class="img"><a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$profil->username.'&'.$langue); ?>" target="_blank" title="<?php echo $lang_appprofil["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a></td>
									<td><a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$profil->username.'&'.$langue); ?>" target="_blank" title="<?php echo $lang_appprofil["EnvoyerUnMail"];?>"><?php echo $lang_appprofil["EnvoyerUnMail"];?></a></td>
								</tr>
							</table>
							<table class="actions" cellpadding="0" cellspacing="0">
								<tr>
									<td class="img"><a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$profil->username.'&'.$langue); ?>" target="_blank" title="<?php echo $lang_appprofil["EnvoyerUneRose"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a></td>
									<td><a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$profil->username.'&'.$langue); ?>" target="_blank" title="<?php echo $lang_appprofil["EnvoyerUneRose"];?>"><?php echo $lang_appprofil["EnvoyerUneRose"];?></a></td>
								</tr>
							</table>
							<table class="actions" cellpadding="0" cellspacing="0">
								<tr>
									<td class="img"><a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$profil->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_appprofil["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a></td>
									<td><a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$profil->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_appprofil["Chat"];?>"><?php echo $lang_appprofil["Chat"];?></a></td>
								</tr>
							</table>
							<table class="actions_secondaire" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td><a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["AjouterAuxFavoris"];?>" target="_blank"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a></td>
									<td><a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["AjouterAuxFavoris"];?>" target="_blank"><?php echo $lang_appprofil["AjouterAuxFavoris"];?></a></td>
								</tr>
								<tr>
									<td><a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["AjouterALaListeNoire"];?>" target="_blank"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a></td>
									<td><a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["AjouterALaListeNoire"];?>" target="_blank"><?php echo $lang_appprofil["AjouterALaListeNoire"];?></a></td>
								</tr>
								<tr>
									<td><a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["SignalerUnAbus"];?>" target="_blank"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a></td>
									<td><a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$profil->id.'&'.$langue); ?>" title="<?php echo $lang_appprofil["SignalerUnAbus"];?>" target="_blank"><?php echo $lang_appprofil["SignalerUnAbus"];?></a></td>
								</tr>
							</table>
						</div>	
					</div>-->
				
					
						
				
									
								
								
								
									
								
								
								
					</div>
					<div style="clear:both"> </div>
				
				
			<?php 				} elseif($profil->id && $profil->accessok == 0) { // profil n'existe pas
				?>
					<h2 class="barre 2"><?php echo $lang_appprofil["ProfilInaccessible"];?></h2>
					<div class="texte_explicatif">
						<b><?php echo $profil->genre == 'h' ? $lang_appprofil["CeProfilNEstPAsAccessiblePapas"] : $lang_appprofil["CeProfilNEstPAsAccessibleMamans"]; ?></b>!
					</div>
					
				<?php 				} else {
				?>
					<h2 class="barre 1"><?php echo $lang_appprofil["ProfilInaccessible"];?></h2>
					<div class="texte_explicatif">
						<?php echo $lang_appprofil["CeProfilNEstPasAccessible"];?>!
					</div>
				<?php 				}
			?>
			</div>
			<?php 		}
		
		
		// page 'mon compte'
		function panel(&$userProfilMini, &$userStats, &$profilsOnline, &$profilsInscrits, $profilsMatching, $genreRecherche, &$list, &$appel_a_temoins, &$temoignage) {
			global $langue,$user;
			include("lang/app_profil.".$_GET['lang'].".php");

			// limitation appel &agrave; t&eacute;moins
			$annonceLimite	= 125;
			if(strlen($appel_a_temoins->annonce) > $annonceLimite) {
				$appel_a_temoins->annonce = substr($appel_a_temoins->annonce, 0, $annonceLimite).'...';
			}

			// limitation t&eacute;moignage
			$annonceLimite	= 125;
			if(strlen($temoignage->texte) > $annonceLimite) {
				$temoignage->texte = substr($temoignage->texte, 0, $annonceLimite).'...';
			}

			// htmlentities
			JL::makeSafe($appel_a_temoins);
			JL::makeSafe($temoignage);

			?>
			
				<div class="blocs">
					
				<div class="col-md-12">
					<div class="row">
						<!--<div class="parentsolo_txt_center">
							<h3 class=" verela_title_h3  parentsolo_mt_20 parentsolo_pb_15"><?php // echo $lang_appprofil["Nouveau"];?></h3>
						</div>-->
					<div   class="col-md-12 ">
					<!--<h3><?php // echo $lang_appprofil["Nouveau"];?></h3>-->
					
					   
							<!-- Start - New UI for Widget - 9005 -->
							
							  <div class="row">
                            <!-- Simple Stats Widgets -->
                            <div class="col-sm-6 col-lg-3  parentsolo_pt_10">
                                                               
                                    <div class="widget-content info-box themed-background-social clearfix">
                                        <div class="widget-icon pull-right">
											<i class="gi gi-message_new text-light-op"></i>                                          
                                        </div>
										 <h2 class="widget-heading h3 text-light">
											<?php 											if($userStats->message_new <= 0){
											echo $userStats->message_new;
											?>
											</h2>
										   <span class="text-light-op">
											<?php 											echo $lang_appprofil["NouveauMessage"];  
											?>
										   </span>
											<?php 											}
											else{
											?>										
										
                                         <h2 class="widget-heading h3 text-light"><strong><?php echo $userStats->message_new; ?></strong></h2>
                                        <span class="text-light-op"><?php echo $userStats->message_new > 1 ? ''.$lang_appprofil["NouveauxMessages"].'' : ''.$lang_appprofil["NouveauMessage"].''; ?></span>
										<?php 										}
									?>
                                    </div>
                              
                            </div>
							<div class="col-sm-6 col-lg-3 parentsolo_pt_10">
                               
                                   
                                    <div class="widget-content info-box themed-background-flat clearfix">
                                        <div class="widget-icon pull-right">
                                            <i class="gi gi-flower text-light-op"></i>
                                        </div>
										 <h2 class="widget-heading h3 text-light">
										<?php 										if($userStats->fleur_new <= 0){
											echo $userStats->fleur_new; 
										?>
										</h2>
										 <span class="text-light-op">
										<?php 										echo $lang_appprofil["NouvelleRose"]; 
										?>
										 </span>
										<?php 										}
										else
										{
									   ?>
											<h2 class="widget-heading h3 text-light"><strong><?php echo $userStats->fleur_new; ?></strong></h2>
											<a href="<?php echo JL::url('index.php?app=message&action=flowers'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["BoiteReceptionRoses"];?>"> <span class="text-light-op"><?php echo $userStats->fleur_new > 1 ? ''.$lang_appprofil["NouvellesRoses"].'' : ''.$lang_appprofil["NouvelleRose"].''; ?></span></a>
									   <?php 										}
									?>
                                      
                                    </div>
                               
                            </div>
                            <div class="col-sm-6 col-lg-3 parentsolo_pt_10">
                                                             
                                    <div class="widget-content info-box themed-background-creme clearfix">
                                        <div class="widget-icon pull-right">
                                            <i class="gi gi-user text-light-op"></i>
                                        </div>
										 <h2 class="widget-heading h3 text-light">
										<?php 										if($userStats->visite_total <= 0){
											echo $userStats->visite_total;
											?>
										</h2>
										 <span class="text-light-op">
										<?	
										echo $lang_appprofil["Visite"];
										?>
										 </span>
										<?php 										}
										else
										{
									   ?>
											<h2 class="widget-heading h3 text-light"><?php echo $userStats->visite_total; ?></h2>
											<a href="<?php echo JL::url('index.php?app=search&action=visits'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["VisiteursProfil"]; ?>">
											 <span class="text-light-op"><?php echo $userStats->visite_total > 1 ? ''.$lang_appprofil["Visites"].'' : ''.$lang_appprofil["Visite"].''; ?>
											</span></a>
									<?php 										}
									?>
                                    </div>
                             
                            </div>
                           <div class="col-sm-6 col-lg-3 parentsolo_pt_10">                                                             
                                      <div class="widget-content info-box themed-background-amethyst clearfix">
                                        <div class="widget-icon pull-right">
                                            <i class="gi gi-coins text-light-op"></i>
                                        </div>
										<h2 class="widget-heading h3 text-light">
										<?php 											if($userStats->points_total <= 0){
											echo $userStats->points_total; 
											?>
										</h2>
										 <span class="text-light-op">
										<?	
										echo SoloFleur;
										?>
										 </span>
										<?php 										}
										else
										{
									   ?>
											<h2 class="widget-heading h3 text-light"><?php echo $userStats->points_total; ?></h2>
											<a href="<?php echo JL::url('index.php?app=points&action=mespoints'.'&'.$langue); ?>" title="<?php echo $lang_appprofil["DetailPoints"];?>">
											 <span class="text-light-op">SoloFleur<?php echo $userStats->points_total > 0 ? 's' : ''; ?>
											</span></a>
									<?php 										}
									?>
                                    </div>
                             
                            </div>
							</div>
							
							<!-- End - New UI for Widget - 9005 -->
					
						
					</div>
				</div>
				</div>
				
					<div class="col-md-6">
						
						<div class="block-title row">						 
						     <h3 class="loginprofile_title_h3 parentsolo_mt_20 parentsolo_pb_15">  <i class="gi gi-coins text-light-op">  </i><?php echo $lang_appprofil["RechercheRapide"];?></h3>
					     
						</div>
						<div class="row">
					<div class="col-md-12  parentsolo_form_style">
						<form name="search" action="<?php echo JL::url(SITE_URL.'/index.php?'.$langue); ?>" method="post">
						<div class="col-md-12 nopadding">
						<div class="col-md-4 nopadding parentsolo_mt_20">
							<h4 class=" parentsolo_pb_15 parentsolo_pt_15 parentsolo_sub_title_blk"><?php echo $list['search_genre']; ?></h4>
						</div>
						<div class="col-md-8">
							<div class="col-md-5 parentsolo_pl_0"><?php echo $lang_appprofil["Entre"];?>
										<?php echo $list['search_recherche_age_min']; ?></div>
										<div class="col-md-5 parentsolo_pl_0"><?php echo $lang_appprofil["et"];?>
										<?php echo $list['search_recherche_age_max']; ?></div>
										<div class="col-md-2 parentsolo_mt_40 parentsolo_pl_0"><?php echo $lang_appprofil["ans"];?></div>
						</div>
					</div>
						<div class="col-md-12 nopadding">
						
						<div class="col-md-8  col-md-offset-4 parentsolo_mt_20"><?php echo $list['search_canton_id']; ?>
							<span id="villes"><?php echo $list['search_ville_id']; ?></span>
						</div>
					</div>
						<div class="col-md-12 nopadding">
						<div class="col-md-4 nopadding parentsolo_mt_10">
							<h4 class=" parentsolo_pb_15 parentsolo_pt_15 parentsolo_sub_title_blk"><?php echo $lang_appprofil["Enfants"];?> </h4>
						</div>
						<div class="col-md-8 parentsolo_mt_20">
							<?php echo $list['search_nb_enfants']; ?>
						</div>
					</div>
						<div class="col-md-12 nopadding">
						<div class="col-md-12 nopadding parentsolo_mt_10">
							<input type="checkbox" name="search_online" id="search_online" style='width:20px;'/><?php echo $lang_appprofil["EnLigne"];?>
									
						</div>
						
					</div>
						<div class="col-md-12">
						<div class="col-md-12 parentsolo_mt_20 parentsolo_txt_center">
							<a href="javascript:document.search.submit();" class="bouton envoyer parentsolo_btn"><?php echo $lang_appprofil["Rechercher"];?></a>
									<input type="hidden" name="search_display" value="0" />
							<input type="hidden" name="app" value="search" />
							<input type="hidden" name="action" value="searchsubmit" />
							<input type="hidden" name="search_lang" id="search_lang" value="<?php echo $_GET['lang']; ?>" />
							<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
									
						</div>
						
					</div>
						</form>
					</div>
				</div>
						<!--<form name="search" action="<?php //echo JL::url(SITE_URL.'/index.php?'.$langue); ?>" method="post">
							<table cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td class="key_rr">
										<span id="step1gender"><?php //echo $list['search_genre']; ?></span>
									</td>
									<td class="key_rr" colspan="2">
										<?php //echo $lang_appprofil["Entre"];?>
										<?php //echo $list['search_recherche_age_min']; ?>
										<?php //echo $lang_appprofil["et"];?>
										<?php //echo $list['search_recherche_age_max']; ?>
										<?php// echo $lang_appprofil["ans"];?>
									</td>
								</tr>
								<tr>
									<td class="key_rr">
										<?php //echo $list['search_canton_id']; ?>
									</td>
									<td class="key_rr" colspan="2">
										<span id="villes"><?php //echo $list['search_ville_id']; ?></span>
									</td>
								</tr>
								<tr>
									<td class="key_rr">
										<input type="checkbox" name="search_online" id="search_online" style='width:20px;'/> <label><?php //echo $lang_appprofil["EnLigne"];?></label>
									</td>
									<td class="key_rr">
										<?php// echo $lang_appprofil["Enfants"];?> <?php //echo $list['search_nb_enfants']; ?>
									</td>
									
									<td align="right">
										<a href="javascript:document.search.submit();" class="bouton envoyer"><?php //echo $lang_appprofil["Rechercher"];?></a>
									</td>
								</tr>
							</table>
							<input type="hidden" name="search_display" value="0" />
							<input type="hidden" name="app" value="search" />
							<input type="hidden" name="action" value="searchsubmit" />
							<input type="hidden" name="search_lang" id="search_lang" value="<?php echo $_GET['lang']; ?>" />
							<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
						</form>-->
						<script language="javascript" type="text/javascript">
							function loadVilles(prefix) {
								if(prefix==null){
									prefix='';
								} 
								console.log($( prefix+'canton_id').val());
								console.log($('.' + prefix+'canton_id').val());
								
								new Request({
									url: $('site_url').value+'/app/app_home/ajax.php',
									method: 'get',
									headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
									data: {
										"canton_id": $( prefix+'canton_id').val(), 
										"ville_id": $( prefix +'ville_id').val(), 
										"lang": $( prefix +'lang').val(), 
										"prefix": prefix
									},
									onSuccess: function(ajax_return) {
										$("villes").set('html', ajax_return);
									},
									onFailure: function(){
									}
								}).send();
							}
							loadVilles('search_');
						</script>
					
					</div>
					<div class="col-md-6">
						<div class="block-title ">
						<h3 class="loginprofile_title_h3 parentsolo_mt_20  parentsolo_pb_15 "><?php echo $genreRecherche == 'h' ? $lang_appprofil["PAPASENLIGNE"] : $lang_appprofil["MAMANSENLIGNE"]; ?></h3>
						</div>
						
						
						 
						 
										
						<div class="parentsolo_txt_center parentsolo_mt_20 text-center" ><!--BEGIN: CAROUSEL -->
							<div id="owl_online_family" class="owl-carousel owl-theme">
							<?php 								if (is_array($profilsOnline)) {
									$i=1;
									?>
										
									<?php					
									foreach($profilsOnline as $profil) {
										
										// &agrave; placer toujours apr&egrave;s les 2 limitations
										JL::makeSafe($profil);
										
										if($profil->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $profil->online) { // 30 minutes (60*30)

											$last_online_class 		= 'lo_online';
											$last_online_label		= $lang_appprofil["EnLigne"];

										} else{ // aujourd'hui (60*60*24)

											$last_online_class 	= 'lo_offline';
											$last_online_label	= $lang_appprofil["HorsLigne"];

										}
										
										// r&eacute;cup la photo de l'utilisateur
										$photo = JL::userGetPhoto($profil->id, 'profil', '', $profil->photo_defaut);

										if(!$photo) {
											$photo = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$profil->genre.'-'.$_GET['lang'].'.jpg';
										}
										?>
										<div class="item">
											   <div class="friend-img">
												   <div class="imgoverlay wd_gal_img">
													   <a href="javascript:windowOpen('<?php echo str_replace('-', '', $profil->username); ?>','<?php echo JL::url('index.php?app=profil&action=view&id='.$profil->id.'&lang='.$_GET['lang']); ?>','615px','511px','yes');" title="<?php echo $lang_appprofil["VoirCeProfil"]; ?>"><img src="<?php echo $photo; ?>" alt="<?php echo $profil->username; ?>" class="profil"/>
													    <span class="wd_gal_overlay span_stl_over"><?php echo JL::calcul_age($profil->naissance_date); ?><br />
													<?php echo $profil->nb_enfants; ?> <?php echo $profil->nb_enfants > 1 ? $lang_appprofil["enfants"] : $lang_appprofil["enfant"]; ?><br />
													<?php echo $profil->canton; ?>
													</span>
													   </a>
											  
											   </div>
												    
											   </div>
												   <h3>
													<a href="javascript:windowOpen('<?php echo str_replace('-', '', $profil->username); ?>','<?php echo JL::url('index.php?app=profil&action=view&id='.$profil->id.'&lang='.$_GET['lang']); ?>','615px','511px','yes');" title="<?php echo $lang_appprofil["VoirCeProfil"];?>" class="username"><?php echo $profil->username; ?></a>	
												   </h3>
												   <p  class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></p>
												  
										   </div>
												
											
										<?php 											if($i%2==0){
												echo "";
											}
											$i++;
									}
						
									while($i<9){
										echo '<div class="preview_off"></div>';
										if($i%2==0){
											echo "";
										}
										$i++;
									}
							
								}else{
							?>
									<tr>
										<td colspan="2" align="middle">
							<?php	
											echo $genreRecherche == 'h' ? $lang_appprofil["AucunPapaEnLigne"] : $lang_appprofil["AucuneMamanEnLigne"];
							?>
										</td>
							<?		
								}
							?>
						<?php if (is_array($profilsOnline)==8){ ?>
								<tr>
										<td colspan="2" align="right">
											<div class="lien_plus"><a href="<?php echo JL::url('index.php?app=search&action=search_online'.'&'.$langue); ?>" title="<?php echo $genreRecherche == 'h' ? $lang_appprofil["VoirPlusDePapaEnLigne"] : $lang_appprofil["VoirPlusDeMamanEnLigne"]; ?>"><?php echo $genreRecherche == 'h' ? $lang_appprofil["VoirPlusDePapaEnLigne"] : $lang_appprofil["VoirPlusDeMamanEnLigne"]; ?></a></div> <a href="<?php echo JL::url('index.php?app=search&action=search_online'.'&'.$langue); ?>" title="<?php echo $genreRecherche == 'h' ? $lang_appprofil["VoirPlusDePapaEnLigne"] : $lang_appprofil["VoirPlusDeMamanEnLigne"]; ?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/preview-plus.png"  class="plus"/></a>
										</td>
						<?php } ?>
							</tr>
									</div></div>
					</div>
					<div style="clear:both"> </div>
				</div>
				
				<div class="blocs">
					<div class="bloc bloc_right bloc_4profil ">
							<div class="block-title">
						<h3 class="loginprofile_title_h3 parentsolo_mt_20 parentsolo_pb_15"><?php echo $genreRecherche == 'h' ? $lang_appprofil["LESDERNIERSPAPASINSCRITS"] : $lang_appprofil["LESDERNIERESMAMANSINSCRITES"]; ?></h3>
							</div>
							<div class="parentsolo_txt_center parentsolo_mt_20" ><!--BEGIN: CAROUSEL -->
							<div class="bridegroom-friend fade_in_hide element_fade_in">
									<div id="owl-demo" class="owl-carousel col-sm-10 col-xs-12 col-md-10">
		                <?php 								if (is_array($profilsInscrits)) {
									$i=1;
									?>
									<tr>
									<?	
									foreach($profilsInscrits as $profil) {
										
										
										// &agrave; placer toujours apr&egrave;s les 2 limitations
										JL::makeSafe($profil);
										
										if($profil->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $profil->online) { // 30 minutes (60*30)
											$last_online_class 		= 'lo_online';
											$last_online_label		= $lang_appprofil["EnLigne"];
										} else{ // aujourd'hui (60*60*24)
											$last_online_class 	= 'lo_offline';
											$last_online_label	= $lang_appprofil["HorsLigne"];
										}
										
										// r&eacute;cup la photo de l'utilisateur
										$photo = JL::userGetPhoto($profil->id, 'profil', '', $profil->photo_defaut);

										if(!$photo) {
											$photo = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$profil->genre.'-'.$_GET['lang'].'.jpg';
										}
										?>
											<div class="item">
											   <div class="friend-img">
												   <div class="imgoverlay"></div>
													   <a href="javascript:windowOpen('<?php echo str_replace('-', '', $profil->username); ?>','<?php echo JL::url('index.php?app=profil&action=view&id='.$profil->id.'&lang='.$_GET['lang']); ?>','615px','511px','yes');" title="<?php echo $lang_appprofil["VoirCeProfil"]; ?>">
													   <img src="<?php echo $photo; ?>" alt="<?php echo $profil->username; ?>">
													   </a>
											   </div>
												   <h3>
													<a href="javascript:windowOpen('<?php echo str_replace('-', '', $profil->username); ?>','<?php echo JL::url('index.php?app=profil&action=view&id='.$profil->id.'&lang='.$_GET['lang']); ?>','615px','511px','yes');" title="<?php echo $lang_appprofil["VoirCeProfil"];?>" class="username">
													<?php echo $profil->username; ?>
													</a>
												   </h3><p class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></p>
												   <span><?php echo JL::calcul_age($profil->naissance_date); ?><br />
													<?php echo $profil->nb_enfants; ?> <?php echo $profil->nb_enfants > 1 ? $lang_appprofil["enfants"] : $lang_appprofil["enfant"]; ?><br />
													<?php echo $profil->canton; ?>
													</span>
										   </div>
											<!--<td class="preview">
												<a href="javascript:windowOpen('<?php // echo str_replace('-', '', $profil->username); ?>','<?php // echo JL::url('index.php?app=profil&action=view&id='.$profil->id.'&lang='.$_GET['lang']); ?>','615px','511px','yes');" title="<?php echo $lang_appprofil["VoirCeProfil"]; ?>"><img src="<?php echo $photo; ?>" alt="<?php echo $profil->username; ?>" class="profil"/></a>
												<div class="infos">
													<?php // echo JL::calcul_age($profil->naissance_date); ?><br />
													<?php //echo $profil->nb_enfants; ?> <?php // echo $profil->nb_enfants > 1 ? $lang_appprofil["enfants"] : $lang_appprofil["enfant"]; ?><br />
													<?php //echo $profil->canton; ?><br />
													<br />
													<span class="<?php // echo $last_online_class; ?>"><?php // echo $last_online_label; ?></span>
												</div>
												<div style="clear:both"> </div>
												<div class="username">
													<a href="javascript:windowOpen('<?php // echo str_replace('-', '', $profil->username); ?>','<?php echo JL::url('index.php?app=profil&action=view&id='.$profil->id.'&lang='.$_GET['lang']); ?>','615px','511px','yes');" title="<?php echo $lang_appprofil["VoirCeProfil"];?>" class="username"><?php echo $profil->username; ?></a>	
												</div>
											</td>	-->
											
										<?php 											if($i%2==0){
												echo "</tr><tr>";
											}
											$i++;
									}
									
										
									while($i<9){
										echo '<td class="preview_off"></td>';
										if($i%2==0){
											echo "</tr><tr>";
										}
										$i++;
									}
								
							
								}else{
							?>
									<tr>
										<td colspan="2" align="middle">
							<?php 											echo $genreRecherche == 'h' ? $lang_appprofil["AucunPapaInscrit"] : $lang_appprofil["AucuneMamanInscrite"];
							?>
										</td>
							<?php
								}
							?>
						
					</div>
    		</div>
		

    </div><?php if (is_array($profilsInscrits)==8){ ?>

									
										<div  class="parentsolo_mb_20 " align="right">
											<div class="lien_plus">
												<a  href="<?php echo JL::url('index.php?app=search&action=search_last_inscription'.'&'.$langue); ?>" title="<?php echo $genreRecherche == 'h' ? $lang_appprofil["VoirPlusDePapaInscrit"] : $lang_appprofil["VoirPlusDeMamanInscrit"]; ?>" class="link offset-sm-top-25 preffix-xs-left-60 "><?php echo $genreRecherche == 'h' ? $lang_appprofil["VoirPlusDePapaInscrit"] : $lang_appprofil["VoirPlusDeMamanInscrit"]; ?><span class="fl-budicons-launch-right164"></span></a>
												
										</div>
									</div>
						<?php } ?>
							
					</div>
					<div style="clear:both"> </div>
					
					<div class="bloc1 bloc_right1 bloc_4profil parentsolo_mt_20">
						<div class="block-title">
						<h3 class="loginprofile_title_h3 parentsolo_mt_20 parentsolo_pb_15"><?php echo $lang_appprofil["SELECTEDPROFILES"];  ?></h3>
						</div>
							<div class="parentsolo_txt_center parentsolo_mt_20" ><!--BEGIN: CAROUSEL -->
							<div class="bridegroom-friend fade_in_hide element_fade_in">
								 <div id="owl_woman_family" class="owl-carousel owl-theme">
                                    
									<?php 								if (is_array($profilsMatching)) {
									$i=1;
									?>
									<tr>
									<?	
									foreach($profilsMatching as $profilMatch) {
										
										
										// To always place after the 2 limitations
										JL::makeSafe($profilMatch);
										
										if($profilMatch->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $profilMatch->online) { // 30 minutes (60*30)

											$last_online_class 		= 'lo_online';
											$last_online_label		= $lang_appprofil["EnLigne"];

										} else{ // aujourd'hui (60*60*24)

											$last_online_class 	= 'lo_offline';
											$last_online_label	= $lang_appprofil["HorsLigne"];

										}
										
										// r&eacute;cup la photo de l'utilisateur
										$photo = JL::userGetPhoto($profilMatch->id, 'profil', '', $profilMatch->photo_defaut);

										if(!$photo) {
											$photo = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$profilMatch->genre.'-'.$_GET['lang'].'.jpg';
										}
										?>
										<div class="item ">
											   <div class="friend-img ">
												   <div class="imgoverlay wd_gal_img">
													   <a href="javascript:windowOpen('<?php echo str_replace('-', '', $profilMatch->username); ?>','<?php echo JL::url('index.php?app=profil&action=view&id='.$profilMatch->id.'&lang='.$_GET['lang']); ?>','615px','511px','yes');" title="<?php echo $lang_appprofil["VoirCeProfil"]; ?>">
													   <img src="<?php echo $photo; ?>" alt="<?php echo $profilMatch->username; ?>" class="hr_eff_img">
													   <span class="wd_gal_overlay span_stl_over"><?php echo JL::calcul_age($profilMatch->naissance_date); ?><br />
													<?php echo $profilMatch->nb_enfants; ?> <?php echo $profilMatch->nb_enfants > 1 ? $lang_appprofil["enfants"] : $lang_appprofil["enfant"]; ?><br />
													<?php echo $profilMatch->canton; ?>
													</span>
													   </a>
													    
											   </div>
											   
											   </div>
												   <h3>
													<a href="javascript:windowOpen('<?php echo str_replace('-', '', $profilMatch->username); ?>','<?php echo JL::url('index.php?app=profil&action=view&id='.$profilMatch->id.'&lang='.$_GET['lang']); ?>','615px','511px','yes');" title="<?php echo $lang_appprofil["VoirCeProfil"];?>" class="username">
													<?php echo $profilMatch->username; ?>
													</a>
												   </h3><p class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></p>
												  
										   </div>
											
											
										<?php 											if($i%2==0){
												echo "";
											}
											$i++;
									}
									
										
									while($i<9){
										echo '<div class="preview_off"></div>';
										if($i%2==0){
											echo "";
										}
										$i++;
									}
								
							
								}else{
							?>
									
										<div>
							<?php 											echo $genreRecherche == 'h' ? $lang_appprofil["AucunPapaInscrit"] : $lang_appprofil["AucuneMamanInscrite"];
							?>
										</div>
							<?php
								}
							?>
						
							
						</div>
								 <?php if (is_array($profilsInscrits)==8){ ?>
								
<div  class="parentsolo_mb_20 " align="right">
											<div class="lien_plus">
												<a  href="<?php echo JL::url('index.php?app=search&action=profile_matching'.'&'.$langue); ?>" title="<?php echo $genreRecherche == 'h' ? $lang_appprofil["VoirPlusDePapaInscrit_profile"] : $lang_appprofil["VoirPlusDeMamanInscrit"]; ?>" class="link offset-sm-top-25 preffix-xs-left-60 "><?php echo $genreRecherche == 'h' ? $lang_appprofil["VoirPlusDePapaInscrit_profile"] : $lang_appprofil["VoirPlusDeMamanInscrit"]; ?><span class="fl-budicons-launch-right164"></span></a>
												
										</div>
									</div>
									
						<?php } ?>
											</div>
					</div>
							</div>
					
					
					<div style="clear:both"> </div>
				</div>
				<br><hr>
				<div class="blocs blocs_home">
			<?php 
				// charge le module gagnant du mois (dernier t&eacute;moignage du syst&egrave;me de points)
				JL::loadMod('gagnant_du_mois');
				
				JL::loadMod('groupe');

			?>
				<div style="clear:both"> </div>
				</div>
				
				<div class="blocs blocs_home">
					<?php 
						// charge le module gagnant du mois (dernier t&eacute;moignage du syst&egrave;me de points)
						JL::loadMod('actu');
				

						// limitation de la longueur du titre
						if(strlen($temoignage->titre) > TITRE_HOME) {
							$temoignage->titre = substr($temoignage->titre, 0, TITRE_HOME).'...';
						}
						
						// limitation de la longueur de l'intro
						$temoignage->texte = strip_tags(html_entity_decode($temoignage->texte));
						if(strlen($temoignage->texte) > INTRO_HOME) {
							$temoignage->texte = substr($temoignage->texte, 0, INTRO_HOME).'...';
						}
						
						// &agrave; placer toujours apr&egrave;s les 2 limitations
						JL::makeSafe($temoignage, 'texte');
						
						// r&eacute;cup la photo de l'utilisateur
						$photo = JL::userGetPhoto($temoignage->user_id, '109', 'profil', $temoignage->photo_defaut);

						// photo par d&eacute;faut
						if(!$photo) {
							$photo = SITE_URL.'/parentsolo/images/parent-solo-109-'.$temoignage->genre.'-'.$_GET['lang'].'.jpg';
						}
			?>
			
<div class="col-md-6 col-sm-12">
	<div class="col-md-12"><h3 class="verela_title_h3 parentsolo_pb_15"><?php echo $lang_appprofil["Temoignages"];?></h3></div>
 	<div class="col-md-12 col-sm-12  testimonials-style-2  testimonials-bg_admin parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
                    <div class="outer">
                        <div class="round">
                            <img width="100" height="100" src="<?php echo $photo; ?>" alt="<?php echo $temoignage->username; ?>"  class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<?php echo $photo; ?>" sizes="(max-width: 70px) 100vw, 70px">
                            
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                    <h2 class="name parentsolo_pt_10"><?php echo $temoignage->username; ?></h2>
                    <div class="text-box parentsolo_pt_10 parentsolo_pb_10">
						<h6 class="parentsolo_text-left parentsolo_txt_clr parentsolo_txt_overflow icon_font_size"><?php echo $temoignage->titre; ?></h6>
<?php echo $temoignage->texte; ?>
<h6 class="parentsolo_text-right parentsolo_txt_clr parentsolo_txt_overflow icon_font_size">
							<a href="<?php echo JL::url('index.php?app=temoignage&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"]; ?>" class="lire">Tous les t&eacute;moignages</a>
						</h6>
						</div>
                   
                </div>
            </div>
        </div></div>

			
					<!--<div class="bloc bloc_right">
						<h3><?php /* echo $lang_appprofil["Temoignages"];?></h3>
						<table width="100%">
							<tr>
								<td valign="top"><img src="<?php echo $photo; ?>" alt="<?php echo $temoignage->username; ?>" /></td>
								<td>
									<div class="titre"><?php echo $temoignage->titre; ?></div>
									<?php echo $temoignage->texte; ?><br />
									<span class="username"><?php echo $temoignage->username; ?></span><br />
									<a href="<?php echo JL::url('index.php?app=temoignage&lang='.$_GET['lang']); ?>" title="<?php echo $lang_apptemoignage["LireLeTemoignage"]; */ ?>" class="lire">Tous les t&eacute;moignages</a>
								</td>
							</tr>
						</table>
					</div>-->
					<div style="clear:both"> </div>
				</div>
					
		<?php 		}



		

		// r&eacute;cup&egrave;re les 3 $field dans l'objet $obj, pour retourner une chaine concat&eacute;n&eacute;e avec les valeurs renseign&eacute;es, sinon retourne $defaut
		function profil3values(&$obj, $field, $defaut) {
			global $langue;

			// variables
			$tab	= array();

			if($obj->{$field.'1'}) {
				$tab[]	= $obj->{$field.'1'};
			}
			if($obj->{$field.'2'}) {
				$tab[]	= $obj->{$field.'2'};
			}
			if($obj->{$field.'3'}) {
				$tab[]	= $obj->{$field.'3'};
			}

			if (is_array($tab)) {
				return implode('<br /> ', $tab);
			} else {
				return $defaut;
			}

		}


		// affichage des conditions g&eacute;n&eacute;rales en popup
		function conditionsPopUp($texte) {
			global $langue;
		?>
			<style>
				body {background:#000;color:#fff;font-size:11px;font-family:Verdana,Arial,Helvetica;}
				h1,h2 {font-size:18px;font-weight:bold;color:#CC0066;padding:0 0 0 25px;background:url(<?php echo SITE_URL; ?>/parentsolo/images/flower.jpg) left no-repeat;}
				p{padding:10px;}
			</style>

			<?php echo $texte; ?>

		<?php 		}

	}
?>
		<script type="text/javascript">
<!--
swfobject.registerObject("FlashID");
//-->
        </script>
		
		

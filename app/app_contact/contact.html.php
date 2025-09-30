<?php  

	// MODEL
	defined('JL') or die('Error 401');
	
	class contact_HTML{
	
		
			public static function messages(&$messages) {
			global $langue;
			include("lang/app_contact.".$_GET['lang'].".php");

			// s'il y a des messages &agrave; afficher
			if (is_array($messages)) {
			?>
				<h2 class="messages parentsolo_title_h3"><?php   echo $lang_appcontact["MessagesParentsolo"];?></h2>
				<div class="messages">
				<?php  
					// affiche les messages
					JL::messages($messages);
				?>
				</div>
				<br />
			<?php  
			}

		}
		
		public static function display(&$contenu, &$row, &$list, &$messages) {
			include("lang/app_contact.".$_GET['lang'].".php");
			global $db, $template, $action, $user;
			
		?>
			
			
			<div class="parentsolo_txt_center"><h2 class="barre parentsolo_title parentsolo_mt_40"><?php    echo $contenu->titre;?></h2>
			<div class="wedd-seperator parentsolo_pb_10"><img src="images/bg_img/saprator.png" alt=""></div>
			</div>
			<div class="texte_explicatif"><?php    echo  $contenu->texte; ?>
			</div>
			<br />
			
		<?php  
		$messages ??= [];
			// messages d'erreurs
			if (is_array($messages)){
				// affichage des messages
				contact_HTML::messages($messages);
			}
		?>
		

			<div class="row">
				<div class="col-md-8 col-md-offset-2 parentsolo_form_style">
			<form action="<?php    echo JL::url('index.php?app=contact').'&lang='.$_GET['lang']; ?>" method="post" name="contactForm">
				<h3 class="parentsolo_title_h3 parentsolo_txt_center parentsolo_pb_15 parentsolo_pt_15"><?php   echo $lang_appcontact["FormulaireDeContact"];?></h3>
				<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12">
							<?php    // change version error in contact form @$user['id'] to @$user->id
							if($user->id){ ?>
							<?php    echo $user->email; ?>
							<?php    }else{?>
							<input type="email" required name="email" id="email"  value="<?php    echo $row->email; ?>" placeholder="<?php   echo $lang_appcontact["Email"];?>"  maxlength="255" />
							<?php  }?>
						</div>
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12">
						
						<div class="col-md-12">
							<?php    echo $list['type_id']; ?>
						</div>
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12">
						
						<div class="col-md-12">
							<textarea name="message" required style="width:100%; height: 155px;" id="message" placeholder="<?php   echo $lang_appcontact["Message"];?>" class="inputtext2"><?php    echo $row->message; ?></textarea>
						</div>
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12 parentsolo_mt_20 ">
							<h4><?php   echo $lang_appcontact["CodeDeVerification"];?></h4>
						</div>
						
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12 ">
							<?php   echo $lang_appcontact["VeuillezRecopierCodeVerification"];?> <strong class="verif"><?php   echo $row->captcha; ?></strong>
						</div>
						
					</div>
				</div>
				<div class="row bottompadding">
					<div class="col-md-12 parentsolo_txt_center">
						
						<div class="col-md-6 col-md-offset-3">
							<input type="text"  name="verif" class="verif"  required value="" placeholder="<?php   echo $lang_appcontact["CodeDeVerification"];?>" />
						</div>
					</div>
				</div>
						<div class="row bottompadding">
					<div class="col-md-12">
						<div class="col-md-12 parentsolo_txt_center parentsolo_mt_20">
							<!--<a href="javascript:document.contactForm.submit();" title="<?php   echo $lang_appcontact["Envoyer"];?>" class="bouton envoyer parentsolo_btn"><?php   echo $lang_appcontact["Envoyer"];?></a>-->
							<input type="submit" value="<?php   echo $lang_appcontact["Envoyer"];?>" class="bouton envoyer parentsolo_btn">
						
				<input type="hidden" name="action" value="envoyer" />
				<input type="hidden" name="captchaAbo" value="<?php   echo $row->captchaAbo; ?>" />
				</div>
							
						</div>
					</div>
			   </div>
			</div>
			</form>
    
		<?php  
		
		}
		
	}
?>

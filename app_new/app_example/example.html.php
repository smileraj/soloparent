<?php 	// sécurité
	defined('JL') or die('Error 401');

	class HTML_example {

		// affichage des messages système
		function messages(&$messages) {
			global $langue;
			include("lang/app_example.".$_GET['lang'].".php");

			// s'il y a des messages à afficher
			if (is_array($messages)) {
			?>
				<h2><?php echo $lang_appexample["Messages"];?></h2>
				<div class="messages">
				<?php 					// affiche les messages
					JL::messages($messages);
				?>
				</div>
			<?php 			}

		}
		
		function get_contacts(&$row, &$inviter, $messages =array()){
			include("lang/app_example.".$_GET['lang'].".php");
			$oi_services=$inviter->getPlugins();

				JL::makeSafe($row);
			?>
			<script type='text/javascript'>
				function toggleAll(element) 
				{
				var form = document.forms.openinviter, z = 0;
				for(z=0; z<form.length;z++)
					{
					if(form[z].type == 'checkbox')
						form[z].checked = element.checked;
					}
				}
			</script>
			
			<div class="app_body">
				<div class="contenu">

					<?php 						// affichage des messages
						HTML_example::messages($messages);

					?>
					<form action='' method='POST' name='openinviter'>
						<table align='center'  cellspacing='2' cellpadding='0' style='border:none;'>
							<tr>
								<td><label for='nom_box'><?php echo $lang_appexample["Nom"];?></label></td>
								<td><input type='text' name='nom_box' value='<?php echo $row->prenom_box; ?>'></td>
							</tr>
							<tr>
								<td><label for='prenom_box'><?php echo $lang_appexample["Prenom"];?></label></td>
								<td><input type='text' name='prenom_box' value='<?php echo $row->prenom_box; ?>'></td>
							</tr>
							<tr>
								<td><label for='email_box'><?php echo $lang_appexample["Email"];?></label></td>
								<td><input type='text' name='email_box' value='<?php echo $row->email_box; ?>'></td>
							</tr>
							<tr>
								<td><label for='password_box'><?php echo $lang_appexample["Mdp"];?></label></td>
								<td><input type='password' name='password_box' value='<?php echo $row->password_box; ?>'></td>
							</tr>
							<tr>
								<td><label for='provider_box'><?php echo $lang_appexample["BoiteOuReseau"];?></label></td>
								<td><select name='provider_box'>
									<option value=''></option>
						<?php 							foreach ($oi_services as $type=>$providers){
						?>		
								<optgroup label='<?php echo $inviter->pluginTypes[$type]; ?>'>
						<?php 								foreach ($providers as $provider=>$details){
						?>
									<option value='<?php echo $provider; ?>' <?php  if($_POST['provider_box']==$provider){ echo 'selected';}?> ><?php echo $details['name']; ?></option>
						<?php 								}
						?>
								</optgroup>
						<?	
							}
						?>
						
								</select></td>
							</tr>
							<tr>
								<td colspan='2'><input type='checkbox' style="size:20px; width:20px" name="newsletter" id="newsletter" value="1" checked><?php echo $lang_appexample["JeDesireRecevoirNewsletter"];?></td>
							</tr>
							<tr>
								<td colspan='2' align='center'><input type='submit' name='import' value='<?php echo $lang_appexample["ImporterContacts"];?>'></td>
							</tr>
						</table>
						<input type='hidden' name='action' value='get_contacts_submit'>
					</form>
					
					<br><br>
				</div>
			</div>
			<div class="clear"> </div>
			<?php 		}
		
		
		function send_invites(&$row, &$inviter, &$plugType, $messages =array()){
			include("lang/app_example.".$_GET['lang'].".php");

				JL::makeSafe($row);
			?>
			<script type='text/javascript'>
				function toggleAll(element) 
				{
				var form = document.forms.openinviter, z = 0;
				for(z=0; z<form.length;z++)
					{
					if(form[z].type == 'checkbox')
						form[z].checked = element.checked;
					}
				}
			</script>
			
			<div class="app_body">
				<div class="contenu">

					<?php 						// affichage des messages
						HTML_example::messages($messages);

					?>
					<form action='' method='POST' name='openinviter'>
					<?php 						$inviter->startPlugin($row->provider_box);
						$inviter->login($row->email_box,$row->password_box);
						$contacts=$inviter->getMyContacts();
					
						if ($inviter->showContacts()){
					?>
							<table class='thTable' align='center' cellspacing='0' cellpadding='0'><tr class='thTableHeader'><td colspan='<?php if($plugType=='email'){ echo "3";} else{ echo "2";} ?>'>Your contacts</td></tr>
					<?php 							if (count($contacts)==0){
					?>
								<tr class='thTableOddRow'><td align='center' style='padding:20px;' colspan='<?php if($plugType=='email'){ echo "3";} else{ echo "2";} ?>'>You do not have any contacts in your address book.</td></tr>
					<?php 							}else{
					?>
								<tr class='thTableDesc'><td><input type='checkbox' onChange='toggleAll(this)' name='toggle_all' title='Select/Deselect all' checked>Invite?</td><td>Name</td><?php if($plugType=='email'){ echo "<td>E-mail</td>";} ?></tr>
					<?php 								//$odd=true;
								$counter=0;
				
								foreach ($contacts as $email=>$name){
						
									$counter++;
						
									if ($odd) 
										$class='style="background-color:grey;"'; 
									else 
										$class='';
					?>
									<tr <?php echo $class; ?>><td><input name='check_<?php echo $counter; ?>' value='<?php echo $counter; ?>' type='checkbox' class='thCheckbox' checked><input type='hidden' name='email_<?php echo $counter; ?>' value='<?php echo $email; ?>'><input type='hidden' name='name_<?php echo $counter; ?>' value='<?php echo $name; ?>'></td><td><?php echo $name; ?></td><?php if($plugType=='email'){ echo "<td>".$email."</td>";} ?></tr>
					<?php 									$odd=!$odd;
								}
					?>
								<tr class='thTableFooter'><td colspan='<?php if($plugType=='email'){ echo "3";} else{ echo "2";} ?>' style='padding:3px;'><input type='submit' name='send' value='Send invites' class='thButton'></td></tr>
					<?php 							}
					?>
							</table>
					<?	
						}
					?>
						<table class='thTable' cellspacing='0' cellpadding='0' style='border:none;'>
							<tr class='thTableRow'><td align='right' valign='top'><label for='message_box'>Message</label></td><td><textarea rows='5' cols='50' name='message_box' class='thTextArea' style='width:300px;'><?php echo $row->message_box; ?></textarea></td></tr>
						</table>
						<input type='hidden' name='action' value='send_invites_submit'>
					<?php 					/*
						<input type='hidden' name='provider_box' value='{$_POST['provider_box']}'>
						<input type='hidden' name='email_box' value='{$_POST['email_box']}'>
						<input type='hidden' name='oi_session_id' value='{$_POST['oi_session_id']}'>";
					*/
					?>
					</form>
					<br><br>
				</div>
			</div>
			<div class="clear"> </div>
			<?php 		}
	}
?>



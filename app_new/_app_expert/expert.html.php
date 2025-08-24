<?php

	// MODEL
	defined('JL') or die('Error 401');
	
	class expert_HTML{
	
		
		function messages(&$messages) {
			global $langue;
			include("lang/app_expert.".$_GET['lang'].".php");

			// s'il y a des messages à afficher
			if(count($messages)) {
			?>
				<h2 class="messages"><?php echo $lang_appexpert["MessagesParentsolo"];?></h2>
				<div class="messages">
				<?
					// affiche les messages
					JL::messages($messages);
				?>
				</div>
				<br />
			<?
			}

		}
		
		
		function listallQ(&$expert, &$questions, &$search) {
			include("lang/app_expert.".$_GET['lang'].".php");
			global $db, $template, $action, $user;
			
			$rayon			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
			
			if($expert){
			
			?>
				<h3 class="result"><?php echo $lang_appexpert["ToutesLesQuestionsTraiteesPar"];?></h3>
				<table class="result expert" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td align="middle">
						<?
							if(count($questions)){
								foreach($questions as $question) {

								?>
									<table class="detail_table" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td class="question" colspan="2"><? echo $question->question;?></td>
										</tr>
										<tr>
											<td colspan="2"><br /><hr /><br /></td>
										</tr>
										<tr>
											<td class="reponse" colspan="2"><? echo $question->reponse;?></td>
										</tr>
									</table>
								<?
								}
							} else {
							?>
								<?php echo $lang_appexpert["AucuneQuestionTraitee"];?>.
							<?
							}
						?>
					</td>
				</tr>			
			</table>
			<table class="result" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td>
						<table class="toolbarsteps" cellpadding="0" cellspacing="0">
							<tr>
								<td class="left">
									<? // page précédente
									if($search['page'] > 1) { ?>
										<a href="<? echo JL::url(SITE_URL.'/index.php?app=expert&action='.$action.'&id='.$expert->id.'&page='.($search['page']-1)).'&lang='.$_GET["lang"]; ?>" class="bouton envoyer" title="<?php echo $lang_appexpert["PagePrecedente"];?>">&laquo; <?php echo $lang_appexpert["PagePrecedente"];?></a>
									<? } ?>
								</td>
								<td class="center pagination">
									<b><?php echo $search['page_total'] == 1 ? $lang_appexpert["Page"] : $lang_appexpert["Pages"];?></b>:
									<? if($debut > 1) { ?> <a href="<? echo JL::url(SITE_URL.'/index.php?app=expert&action='.$action.'&id='.$expert->id.'&page=1').'&lang='.$_GET["lang"]; ?>" title="<?php echo $lang_appexpert["Debut"];?>"><?php echo $lang_appexpert["Debut"];?></a> ...<? }?>
									<?
										for($i=$debut; $i<=$fin; $i++) {
										?>
											 <a href="<? echo JL::url(SITE_URL.'/index.php?app=expert&action='.$action.'&id='.$expert->id.'&page='.$i).'&lang='.$_GET["lang"]; ?>" title="<?php echo $lang_appexpert["Page"];?> <? echo $i; ?>" <? if($i == $search['page']) { ?>class="active"<? } ?>><? echo $i; ?></a>
										<?
										}
									?>
									<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL.'/index.php?app=expert&action='.$action.'&id='.$expert->id.'&page='.$search['page_total']).'&lang='.$_GET["lang"]; ?>" title="<?php echo $lang_appexpert["Fin"];?>"><?php echo $lang_appexpert["Fin"];?></a><? }?> <i>(<? echo $search['result_total'] ==1 ? $search['result_total']." ".$lang_appexpert["question"] : $search['result_total']." ".$lang_appexpert["questions"];?>)</i>
								</td>
								<td class="right">
									<? // page suivante
									if($search['page'] < $search['page_total']) { ?>
										<a href="<? echo JL::url(SITE_URL.'/index.php?app=expert&action='.$action.'&id='.$expert->id.'&page='.($search['page']+1)).'&lang='.$_GET["lang"]; ?>" class="bouton envoyer" title="<?php echo $lang_appexpert["PageSuivante"];?>"><?php echo $lang_appexpert["PageSuivante"];?> &raquo;</a>
									<? } ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>			
			</table>
		<?
			}else{
				JL::redirect(SITE_URL.'/index.php?app=expert&lang='.$_GET['lang']);
			}
		
		}
		
		
		function listall(&$contenu, &$experts, &$messages) {
			include("lang/app_expert.".$_GET['lang'].".php");
			global $db, $template, $action, $user;
			
		?>
			<h2 class="barre"><? echo $contenu->titre;?></h2>
			<div class="texte_explicatif">
				<? echo  $contenu->texte; ?>
			</div>
			<br />
			
		<?
			// messages d'erreurs
			if(count($messages)){
					// affichage des messages
					expert_HTML::messages($messages);
				}
		?>
			<h3 class="result"><?php echo $lang_appexpert["TousLesExperts"];?></h3>
			<table class="result" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td>
						<table class="previews_liste" cellpadding="0" cellspacing="0" width="100%">
						<?
							$i = 1;
							// liste les profils
							if(is_array($experts) && count($experts)) {
							
								foreach($experts as $row) {

									// si une photo a été envoyée
									$filePath = 'images/experts/'.$row->id.'/s-preview-expert.jpg';
									if(is_file(SITE_PATH.'/'.$filePath)) {
										$image	= $filePath;
									}
									
									if($i%2 == 1){ echo '<tr>';}
									
								?>
									<td class="preview_liste">
										<div class="actions">
											<a href="<? echo JL::url('index.php?app=expert&action=expert&id='.$row->id.'&lang='.$_GET['lang']); ?>" title="<? echo $row->titre; ?>"><img src="<? echo SITE_URL.'/'.$image; ?>" alt="<? echo $row->titre; ?>" class="profil" /></a>
										</div>
										<div class="infos"><? echo $row->specialite; ?></div>
										<div class="description">
											<? echo $row->introduction; ?>
										</div>
										<div style="clear:both"> </div>
										<div class="username">
											<a class="username" href="<? echo JL::url('index.php?app=expert&action=expert&id='.$row->id.'&lang='.$_GET['lang']); ?>" title="<? echo $row->titre; ?>" class="titre"><? echo $row->titre; ?></a>
										</div>
									</td>
								<?
								
									if($i%2 == 0){echo "</tr>"; }
								
									$i++;
								}
								
								if($i%2!=1){
									while($i%2!=1){
										echo '<td class="preview_liste_off"></td>';
										if($i%2 == 0){echo "</tr>"; }
										
										$i++;
									}
								}
								
							}else{
							?>
								<tr>
									<td align="middle">
										<?php echo $lang_appexpert["AucunExpert"];?>.
									</td>
								</tr>
							<?
							}
						?>
						</table>
					</td>
				</tr>
			</table>
    
		<?
		
		}
		
		
		
		function display(&$expert, &$avis, &$contenu, &$contact, &$messages) {
			include("lang/app_expert.".$_GET['lang'].".php");
			global $db, $template, $action, $user;
			
			
			$filePath = 'images/experts/'.$expert->id.'/m-expert.jpg';
			if(is_file(SITE_PATH.'/'.$filePath)) {
				$image	= $filePath;
			}
		
			if($expert){
		?>
			<h2 class="barre"><? echo $expert->titre;?></h2>
			<div class="texte_explicatif">
				<b><? echo $lang_appexpert["Specialite"].$expert->specialite;?></b><br />
				<br />
				<img src="<? echo SITE_URL.'/'.$image; ?>" alt="<? echo $expert->specialite.": ".$expert->titre;?>" style="float:left;margin:0 10px 10px 0;" /><? echo  $expert->texte; ?>
			</div>
			<br />
			<h3 class="result"><?php echo $lang_appexpert["DerniereQuestionTraitee"];?></h3>
		<?
			if($avis){
		?>
				<table class="result expert" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td align="middle">
							<table class="detail_table" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td class="question" colspan="2"><? echo $avis->question;?></td>
								</tr>
								<tr>
									<td colspan="2"><br /><hr /><br /></td>
								</tr>
								<tr>
									<td class="reponse" colspan="2"><? echo $avis->reponse;?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table class="result expert" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td align="right">
							<a href="<? echo JL::url('index.php?app=expert&action=questions&id='.$expert->id.'&'.$langue); ?>"><?php echo $lang_appexpert["ToutesLesQuestionsTraitees"];?></a>
						</td>
						<td align="middle" width="30px;">
							<a href="<? echo JL::url('index.php?app=expert&action=questions&id='.$expert->id.'&'.$langue); ?>" title="<?php echo $lang_appexpert["ToutesLesQuestionsTraitees"];?>"><img src="<? echo SITE_URL; ?>/<? echo SITE_TEMPLATE; ?>/images/preview-plus.png" /></a>
						</td>
					</tr>
				</table>
		<? 
			}else{
		?>	<table class="result expert" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td align="middle">
						<?php echo $lang_appexpert["AucuneQuestionTraitee"];?>.
						</td>
					</tr>
				</table>
		<?
			}
		?>
			<br />
			<hr />
			<br />
			<h2 class="barre"><? echo $contenu->titre;?></h2>
			<div class="texte_explicatif">
				<? echo  $contenu->texte; ?>						
			</div>
			<br />	
			<?
				// messages d'erreurs
				if(count($messages)){
					// affichage des messages
					expert_HTML::messages($messages);
				}
			?>
			<form action="<? echo JL::url('index.php?app=expert').'&lang='.$_GET['lang']; ?>" method="post" name="contactForm">
				<h3 class="form"><?php echo $lang_appexpert["PosezVotreQuestion"];?></h3>
				<table class="table_form" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="key">
								<label for="email"><?php echo $lang_appexpert["Email"];?></label>
							</td>
							<td><b><? echo $user->email; ?></b></td>
						</tr>
						<tr>
							<td class="key">
								<label for="message"><?php echo $lang_appexpert["VotreQuestion"];?></label>
							</td>
							<td>
								<textarea name="message" id="message" class="inputtext2"><? echo $contact->message; ?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2"><input type="checkbox" name="publication" id="publication" checked value='1' style="width:10px;"> <?php echo $lang_appexpert["JAcceptePublication"];?></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="right">
								<a href="javascript:document.contactForm.submit();" title="<?php echo $lang_appexpert["Envoyer"];?>" class="envoyer"><?php echo $lang_appexpert["Envoyer"];?></a>
							</td>
						</tr>
					</table>
					
				<input type="hidden" name="action" value="envoyer" />
				<input type="hidden" name="id" value="<? echo $expert->id; ?>" />
				<input type="hidden" name="lang" value="<? echo $_GET['lang']; ?>" />
				
			</form>
			<?
			}else{
				JL::redirect(SITE_URL.'/index.php?app=expert&lang='.$_GET['lang']);
			}
		
		}
		
	}
?>

<?
	// sécurité
	defined('JL') or die('Error 401');
	
	class FUNCTION_mailing_auto {
	
		// remplace les mots clés du genre {texte}, {site_url}, {username}, etc...
		function getMailHtml($templatePath, $mailing,$prefix_ajax='', $id=0, $genre='f', $langue=0) {
			global $db;
			
			//Pub Leaderboard
			if($mailing->active_pub_leaderboard){
				if($langue==5){
					$html		= str_replace('{pub_leaderboard}',"<tr><td align='left' style='padding:15px 11px 0 11px;' colspan='2'><span style='color: #B4ADA5;font-size: 11px;font-weight: normal;margin: 0;padding: 0;'>Werbung</span><br />".$mailing->pub_leaderboard."</td></tr>", file_get_contents($templatePath));
				}elseif($langue==4){
					$html		= str_replace('{pub_leaderboard}',"<tr><td align='left' style='padding:15px 11px 0 11px;' colspan='2'><span style='color: #B4ADA5;font-size: 11px;font-weight: normal;margin: 0;padding: 0;'>Advertising</span><br />".$mailing->pub_leaderboard."</td></tr>", file_get_contents($templatePath));
				}else{
					$html		= str_replace('{pub_leaderboard}',"<tr><td align='left' style='padding:15px 11px 0 11px;' colspan='2'><span style='color: #B4ADA5;font-size: 11px;font-weight: normal;margin: 0;padding: 0;'>Publicité</span><br />".$mailing->pub_leaderboard."</td></tr>", file_get_contents($templatePath));
				}
			}else{
				$html		= str_replace('{pub_leaderboard}', "", file_get_contents($templatePath));
			}
			
			//Nouveaux profils
			if($genre == 'h') {
				$genreRecherche =  'f';
			} else { // sinon si c'est une femme
				$genreRecherche =  'h';
			}
			
			// récup les derniers inscrits (sans prendre l'utilisateur log)
			$query = "SELECT u.id, u.username, pc.abreviation AS canton, up.genre, up.photo_defaut, up.nb_enfants, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age"
			." FROM user AS u"
			." INNER JOIN user_profil AS up ON up.user_id = u.id"
			." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
			." LEFT JOIN user_annonce AS ua ON (ua.user_id = u.id AND ua.published = 1)"
			." WHERE u.published = 1 AND u.confirmed > 0 AND u.id != '".$id."' AND up.genre = '".$genreRecherche."'"
			." AND u.id NOT IN (SELECT user_id_from FROM user_flbl WHERE user_id_to =".$id."  AND list_type=0)"
			." AND u.id NOT IN (SELECT user_id_to FROM user_flbl WHERE user_id_from = ".$id." AND list_type=0)"
			." GROUP BY u.id"
			." ORDER BY u.creation_date DESC"
			." LIMIT 0,5"
			;
			$profilsInscrits 	= $db->loadObjectList($query);
			
			$i=1;
			
			foreach($profilsInscrits as $profilinscrit){
				$photo = JL::userGetPhoto($profilinscrit->id, '109', 'profil', $profilinscrit->photo_defaut);
				
				if(!$photo) {
					if($langue==5){
						$lang = "de";
						$pluriel = "er";
					}elseif($langue==4){
						$lang = "en";
						$pluriel = "ren";
					}else{
						$lang = "fr";
						$pluriel = "s";
					}
						
					$photo = SITE_URL.'/parentsolo/images/parent-solo-109-'.$profilinscrit->genre.'-'.$lang.'.jpg';
				}
				
				$html		= str_replace('{photo'.$i.'}', $photo, $html);
				$html		= str_replace('{pseudo'.$i.'}', $profilinscrit->username, $html);
				$html		= str_replace('{age'.$i.'}', $profilinscrit->age, $html);
				$html		= str_replace('{enfant'.$i.'}', $profilinscrit->nb_enfants, $html);
				
				if($profilinscrit->nb_enfants > 1)
					$html		= str_replace('{pluriel'.$i.'}', $pluriel, $html);
				else
					$html		= str_replace('{pluriel'.$i.'}', "", $html);
				
				$html		= str_replace('{canton'.$i.'}', $profilinscrit->canton, $html);
				
				$i++;
			}
			
			
			//News publi
			
			if($mailing->active_news_publi){
				
				if(is_file($prefix_ajax.'../images/mailing_auto/'.$mailing->id.'/news_publi.png')){
					if($mailing->lien_news_publi)
						$html =str_replace('{news_publi}', "<div style='clear:both;padding-top:20px;'></div><div style='padding:15px 15px 35px 15px;background:#F3BCBC;color:#333;'><h1 style='font-family: Verdana,Helvetica,sans-serif; font-size: 20px; color: #333; font-weight: normal;margin:0;'>".$mailing->titre_news_publi."</h1><br /><a href='".$mailing->lien_news_publi."' target='_blank'><img src='http://www.parentsolo.ch/images/mailing_auto/".$mailing->id."/news_publi.png' alt='' style='float:left;margin-right:10px;' /></a>".$mailing->texte_news_publi."<div style='clear:both'></div></div>",$html);
					else
						$html =str_replace('{news_publi}', "<div style='clear:both;padding-top:20px;'></div><div style='padding:15px 15px 35px 15px;background:#F3BCBC;color:#333;'><h1 style='font-family: Verdana,Helvetica,sans-serif; font-size: 20px; color: #333; font-weight: normal;margin:0;'>".$mailing->titre_news_publi."</h1><br /><img src='http://www.parentsolo.ch/images/mailing_auto/".$mailing->id."/news_publi.png' alt='' style='float:left;margin-right:10px;' />".$mailing->texte_news_publi."<div style='clear:both'></div></div>",$html);
				}else{
					$html =str_replace('{news_publi}', "<div style='clear:both;padding-top:20px;'></div><div style='padding:15px 15px 35px 15px;background:#F3BCBC;color:#333;'><h1 style='font-family: Verdana,Helvetica,sans-serif; font-size: 20px; color: #333; font-weight: normal;margin:0;'>".$mailing->titre_news_publi."</h1><br />".$mailing->texte_news_publi."</div>",$html);
				}
				
			}else{
				$html		= str_replace('{news_publi}', "", $html);
			}
			
			
			//Actu parentsolo
			
			if($mailing->active_actu_ps){
				if(!$mailing->active_news_publi){
					if(is_file($prefix_ajax.'../images/mailing_auto/'.$mailing->id.'/actu_ps.png')){
						if($mailing->lien_actu_ps){
							$html =str_replace('{actu_ps}', 
							"<div style='padding:15px 15px 35px 15px;background:#F3BCBC;color:#333;'>
								<h1 style='font-family: Verdana,Helvetica,sans-serif; font-size: 20px; color: #333; font-weight: normal;margin:0;'>".$mailing->titre_actu_ps."</h1><br />
								<table style='text-align:justify;font-family:Arial,Verdana, Helvetica, sans-serif;font-size:12px;'>
									<tr>
										<td valign='top'><a href='".$mailing->lien_actu_ps."' target='_blank'><img src='http://www.parentsolo.ch/images/mailing_auto/".$mailing->id."/actu_ps.png' alt='' /></a></td>
										<td style='width:10px;'></td>
										<td>".$mailing->texte_actu_ps."</td>
									</tr>
								</table>
								<div style='clear:both'></div>
							</div>",$html);
						}else{
							$html =str_replace('{actu_ps}', 
							"<div style='padding:15px 15px 35px 15px;background:#F3BCBC;color:#333;'>
								<h1 style='font-family: Verdana,Helvetica,sans-serif; font-size: 20px; color: #333; font-weight: normal;margin:0;'>".$mailing->titre_actu_ps."</h1><br />
								<table style='text-align:justify;font-family:Arial,Verdana, Helvetica, sans-serif;font-size:12px;'>
									<tr>
										<td valign='top'><img src='http://www.parentsolo.ch/images/mailing_auto/".$mailing->id."/actu_ps.png' alt='' /></td>
										<td style='width:10px;'></td>
										<td>".$mailing->texte_actu_ps."</td>
									</tr>
								</table>
								<div style='clear:both'></div>
							</div>",$html);
						}
					}else{
						$html =str_replace('{actu_ps}', "<div style='padding:15px 15px 35px 15px;background:#E2DCCE;color:#333;'><h1 style='font-family: Verdana,Helvetica,sans-serif; font-size: 20px; color: #333; font-weight: normal;margin:0;'>".$mailing->titre_actu_ps."</h1><br />".$mailing->texte_actu_ps."</div>",$html);
					}
				
				}else{
				
					if(is_file($prefix_ajax.'../images/mailing_auto/'.$mailing->id.'/actu_ps.png')){
						if($mailing->lien_actu_ps){
							$html =str_replace('{actu_ps}', 
							"<div style='clear:both;padding-top:20px;'></div>
							<div style ='padding:10px; border:1px solid #F3BCBC;'>
								<h1 style='font-family: Verdana,Helvetica,sans-serif; font-size: 20px; color: #c32a2c; font-weight: normal;margin:0;'>".$mailing->titre_actu_ps."</h1><br />
								<table style='text-align:justify;font-family:Arial,Verdana, Helvetica, sans-serif;font-size:12px;'>
									<tr>
										<td valign='top'><a href='".$mailing->lien_actu_ps."' target='_blank'><img src='http://www.parentsolo.ch/images/mailing_auto/".$mailing->id."/actu_ps.png' alt='' /></a></td>
										<td style='width:10px;'></td>
											<td>".$mailing->texte_actu_ps."</td>
									</tr>
								</table>
							</div>",$html);
						}else{
							$html =str_replace('{actu_ps}', 
							"<div style='clear:both;padding-top:20px;'></div>
							<div style ='padding:10px; border:1px solid #F3BCBC;'>
								<h1 style='font-family: Verdana,Helvetica,sans-serif; font-size: 20px; color: #c32a2c; font-weight: normal;margin:0;'>".$mailing->titre_actu_ps."</h1><br />
								<table style='text-align:justify;font-family:Arial,Verdana, Helvetica, sans-serif;font-size:12px;'>
									<tr>
										<td valign='top'><img src='http://www.parentsolo.ch/images/mailing_auto/".$mailing->id."/actu_ps.png' alt='' /></td>
										<td style='width:10px;'></td>
											<td>".$mailing->texte_actu_ps."</td>
									</tr>
								</table>
							</div>",$html);
						}
					}else{
						$html =str_replace('{actu_ps}', "<div style='clear:both;padding-top:20px;'></div><div style ='padding:10px; border:1px solid #F3BCBC;'><h1 style='font-family: Verdana,Helvetica,sans-serif; font-size: 20px; color: #c32a2c; font-weight: normal;margin:0;'>".$mailing->titre_actu_ps."</h1><br />".$mailing->texte_actu_ps."</div>",$html);
					}
				
				}
				
			}else{
				$html		= str_replace('{actu_ps}',"", $html);
			}
			
			
			//Gagnant du mois
			$annee_mois = date('Y-m', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));

			// récup le dernier témoignage en date du système de points, du mois précédent
			$query = "SELECT pg.id, pg.user_id, u.username, pc.abreviation AS canton, up.genre, up.photo_defaut, up.nb_enfants, (YEAR(CURRENT_DATE)-YEAR(up.naissance_date)) - (RIGHT(CURRENT_DATE,5)<RIGHT(up.naissance_date,5)) AS age"
			." FROM points_gagnants AS pg"
			." INNER JOIN user AS u ON u.id = pg.user_id"
			." INNER JOIN user_profil AS up ON up.user_id = u.id"
			." LEFT JOIN profil_canton AS pc ON pc.id = up.canton_id"
			." WHERE pg.annee_mois = '".$db->escape($annee_mois)."'"
			." ORDER BY RAND()"
			." LIMIT 0,1"
			;
			$gagnant = $db->loadObject($query);
			
			$photo = JL::userGetPhoto($gagnant->user_id, 'profil', '', $gagnant->photo_defaut);
			
			if(!$photo) {
				if($langue==5){
					$lang = "de";
					$pluriel = "er";
				}elseif($langue==4){
					$lang = "en";
					$pluriel = "ren";
				}else{
					$lang = "fr";
					$pluriel = "s";
				}
					
				$photo = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$gagnant->genre.'-'.$lang.'.jpg';
			}
			
			$html		= str_replace('{solofleurs_photo}', $photo, $html);
			$html		= str_replace('{solofleurs_pseudo}', $gagnant->username, $html);
			$html		= str_replace('{solofleurs_age}', $gagnant->age, $html);
			$html		= str_replace('{solofleurs_enfant}', $gagnant->nb_enfants, $html);
			
			if($profilinscrit->nb_enfants > 1)
				$html		= str_replace('{solofleurs_pluriel}', $pluriel, $html);
			else
				$html		= str_replace('{solofleurs_pluriel}', "", $html);
			
			$html		= str_replace('{solofleurs_canton}', $gagnant->canton, $html);
			
			
			//Pub Medium Rectangle
			
			if($mailing->active_pub_medium_rectangle){
				if($langue==5){
					$html		= str_replace('{pub_medium_rectangle}', "<td valign='middle' style='width:300px;text-align:left;'><span style='color: #B4ADA5;font-size: 11px;font-weight: normal;margin: 0;padding: 0;'>Werbung</span><br />".$mailing->pub_medium_rectangle."</td>", $html);
				}elseif($langue==4){
					$html		= str_replace('{pub_medium_rectangle}', "<td valign='middle' style='width:300px;text-align:left;'><span style='color: #B4ADA5;font-size: 11px;font-weight: normal;margin: 0;padding: 0;'>Advertising</span><br />".$mailing->pub_medium_rectangle."</td>", $html);
				}else{
					$html		= str_replace('{pub_medium_rectangle}', "<td valign='middle' style='width:300px;text-align:left;'><span style='color: #B4ADA5;font-size: 11px;font-weight: normal;margin: 0;padding: 0;'>Publicité</span><br />".$mailing->pub_medium_rectangle."</td>", $html);
				}
			}else{
				$html		= str_replace('{pub_medium_rectangle}',"", $html);
			}
			
			//Agendas
			if($mailing->active_agendas){
				//Agenda1
				$html		= str_replace('{agenda1_titre}', $mailing->agenda1_titre, $html);
				$html		= str_replace('{agenda1_date}', $mailing->agenda1_date, $html);
				$html		= str_replace('{agenda1_lieu}', $mailing->agenda1_lieu, $html);
				$html		= str_replace('{agenda1_image}', $mailing->agenda1_image, $html);
				$html		= str_replace('{agenda1_lien}', $mailing->agenda1_lien, $html);
				$html		= str_replace('{agenda1_intro}', $mailing->agenda1_intro, $html);
				
				//Agenda2
				$html		= str_replace('{agenda2_titre}', $mailing->agenda2_titre, $html);
				$html		= str_replace('{agenda2_date}', $mailing->agenda2_date, $html);
				$html		= str_replace('{agenda2_lieu}', $mailing->agenda2_lieu, $html);
				$html		= str_replace('{agenda2_image}', $mailing->agenda2_image, $html);
				$html		= str_replace('{agenda2_lien}', $mailing->agenda2_lien, $html);
				$html		= str_replace('{agenda2_intro}', $mailing->agenda2_intro, $html);
			}
			
			
			
			// remplace les mots clés
			$html		= str_replace('{id}', $mailing->id, $html);
			$html		= str_replace('{titre}', 	$titre, 	$html);
			$html		= str_replace('{site_url}', SITE_URL, 	$html);
			
			return $html;
		
		}
	}
?>

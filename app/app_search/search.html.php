<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

class HTML_search {


	// affichage des messages syst&egrave;me
	public static function messages(&$messages) {
			global $langue;
			include("lang/app_search.".$_GET['lang'].".php");

		// s'il y a des messages &agrave; afficher
		if (is_array($messages)) {
		?>
			<h2 class="messages"><?php echo $lang_search["MessagesParentsolo"];?></h2>
			<div class="messages">
			<?php 				// affiche les messages
				JL::messages($messages);
			?>
			</div>
			<br />
		<?php 		}

	}


	public static function search(&$list, &$results, &$messages) {
		global $langue;
		include("lang/app_search.".$_GET['lang'].".php");
		global $action;


		// variables
		$page 		= JL::getSessionInt('search_page', 1);
		$pageTotal 	= JL::getSessionInt('search_page_total', 1)== 0 ? 1 : JL::getSessionInt('search_page_total', 1);
		$rayon 		= 5;
		$debut		= ($page - $rayon) >= 1 ? $page - $rayon : 1;
		$fin		= ($page + $rayon) <= $pageTotal ? $page + $rayon : $pageTotal;

		$page_prev	= $page-1 >= 1 ? $page-1 : 0;
		$page_next	= $page+1 <= $pageTotal ? $page+1 : 0;

				
		// affichage des messages
		HTML_search::messages($messages);

	?>
		<form name="search" id="search" action="<?php echo JL::url(SITE_URL.'/index.php?'.$langue); ?>" method="post">
			<div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre "><?php echo $lang_search["Recherche"];?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
			
			
			<div class="row searchform">
				<div class="col-md-12 parentsolo_plr_0 parentsolo_pt_10">
						<div class="col-md-4">
								<label><?php echo $lang_search["Genre"];?></label>
							<div class="col-md-12 parentsolo_plr_0"><span class="genre"><?php echo $list['search_genre']; ?></span></div>
						</div>
						<div class="col-md-4">
								<label><?php echo $lang_search["Age"];?></label>
								<div class="col-md-12 parentsolo_plr_0">
								<div class="col-md-2 nopadding parentsolo_pl_0"><?php echo $lang_search["De"];?></div>
								<div class="col-md-3 nopadding parentsolo_plr_0"><?php echo $list['search_recherche_age_min']; ?></div>
								<div class="col-md-2"><?php echo $lang_search["A"];?></div>
								<div class="col-md-3 nopadding parentsolo_plr_0"><?php echo $list['search_recherche_age_max']; ?></div>
								<div class="col-md-2"><?php echo $lang_search["Ans"];?></div>
								</div>
						</div>
						<div class="col-md-4 ">
								<label><?php echo $lang_search["Enfants"];?></label>
							<div class="col-md-12 parentsolo_plr_0"><?php echo $list['search_nb_enfants']; ?></div>
						</div>
				</div>
				<div class="col-md-12 parentsolo_plr_0 parentsolo_pt_10">
						<div class="col-md-4">
								<label><?php echo $lang_search["Canton"];?></label>
							<div class="col-md-12 parentsolo_plr_0"><?php echo $list['search_canton_id']; ?></div>
						</div>
						<div class="col-md-4"><label><?php echo $lang_search["Ville"];?></label>
						<div class="col-md-12 parentsolo_plr_0"><span id="villes"><?php echo $list['search_ville_id']; ?></span></div>
						</div>
						<div class="col-md-4">
								<label><?php echo $lang_search["EnLigne"];?></label>
								<div class="col-md-12 parentsolo_plr_0">
										<span style="font-weight:normal;"><input type="radio" name="search_online" value="1" id="search_online_1" <?php echo $list['search_online'] ? 'checked' : ''; ?> style="width:20px;"> <span for="search_online_1"><?php echo $lang_search["Oui"];?></span> <input type="radio" name="search_online" value="0" id="search_online_0" class="searchRadio" <?php echo !$list['search_online'] ? 'checked' : ''; ?> style="width:20px;"> <span for="search_online_0"><?php echo $lang_search["PeuImporte"];?></span></span>
										
								</div>
						</div>
				</div>
				<div class="col-md-12 parentsolo_plr_0 parentsolo_pt_10">
						<div class="col-md-4"><label for="search_username"><?php echo $lang_search["Pseudo"];?></label>
							<div class="col-md-12 parentsolo_plr_0"><input type="text" name="search_username" required id="search_username" value="<?php echo $list['search_username']; ?>" /></div>
						</div>
						<div class="col-md-4">
						</div>
						<div class="col-md-4">
						</div>
				</div>
			</div>
			
				<table class="table_form form_recherche_avancee" cellpadding="0" cellspacing="0">
					
					
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td class="key_rr recherche_avancee"><?php echo $lang_search["RechercheAvancee"];?> <a href="javascript:afficher_recherche_avance();" class="voir_plus" id="recherche_avancee_voir_plus">(+)</a><a href="javascript:effacer_recherche_avance();" class="voir_moins" id="recherche_avancee_voir_moins" hidden>(-)</a></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="3">
							<table class="recherche_avancee_critere" id="recherche_avancee_critere" cellpadding="0" cellspacing="0" hidden>
								<tr>
									<td id="signe_astro"><label>- <?php echo $lang_search["SigneAstrologique"];?> <a href="javascript:afficher_critere('signe_astro');" class="voir_plus" id="signe_astro_voir_plus">(+)</a><a href="javascript:effacer_critere('signe_astro');" class="voir_moins" id="signe_astro_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_signe_astro" hidden><?php echo $list['search_signe_astrologique_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="search_hr"><hr /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="taille"><label>- <?php echo $lang_search["Taille"];?> <a href="javascript:afficher_critere('taille');" class="voir_plus" id="taille_voir_plus">(+)</a><a href="javascript:effacer_critere('taille');" class="voir_moins" id="taille_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_taille" hidden><span style="font-weight:normal;"><?php echo $lang_search["Entre"];?> <?php echo $list['search_recherche_taille_min']; ?> <?php echo $lang_search["et"];?> <?php echo $list['search_recherche_taille_max']; ?> cm</span></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="poids"><label>- <?php echo $lang_search["Poids"];?> <a href="javascript:afficher_critere('poids');" class="voir_plus" id="poids_voir_plus">(+)</a><a href="javascript:effacer_critere('poids');" class="voir_moins" id="poids_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_poids" hidden><span style="font-weight:normal;"><?php echo $lang_search["Entre"];?> <?php echo $list['search_recherche_poids_min']; ?> <?php echo $lang_search["et"];?> <?php echo $list['search_recherche_poids_max']; ?> kg</span></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="silhouette"><label>- <?php echo $lang_search["Silhouette"];?> <a href="javascript:afficher_critere('silhouette');" class="voir_plus" id="silhouette_voir_plus">(+)</a><a href="javascript:effacer_critere('silhouette');" class="voir_moins" id="silhouette_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_silhouette" hidden><?php echo $list['search_silhouette_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="yeux"><label>- <?php echo $lang_search["Yeux"];?> <a href="javascript:afficher_critere('yeux');" class="voir_plus" id="yeux_voir_plus">(+)</a><a href="javascript:effacer_critere('yeux');" class="voir_moins" id="yeux_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_yeux" hidden><?php echo $list['search_yeux_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="cheveux"><label>- <?php echo $lang_search["Cheveux"];?> <a href="javascript:afficher_critere('cheveux');" class="voir_plus" id="cheveux_voir_plus">(+)</a><a href="javascript:effacer_critere('cheveux');" class="voir_moins" id="cheveux_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_cheveux" hidden><?php echo $list['search_cheveux_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="style_coiffure"><label>- <?php echo $lang_search["Coiffure"];?> <a href="javascript:afficher_critere('style_coiffure');" class="voir_plus" id="style_coiffure_voir_plus">(+)</a><a href="javascript:effacer_critere('style_coiffure');" class="voir_moins" id="style_coiffure_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_style_coiffure" hidden><?php echo $list['search_style_coiffure_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="origine"><label>- <?php echo $lang_search["Origine"];?> <a href="javascript:afficher_critere('origine');" class="voir_plus" id="origine_voir_plus">(+)</a><a href="javascript:effacer_critere('origine');" class="voir_moins" id="origine_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_origine" hidden><?php echo $list['search_origine_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="search_hr"><hr /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="nationalite"><label>- <?php echo $lang_search["Nationalite"];?> <a href="javascript:afficher_critere('nationalite');" class="voir_plus" id="nationalite_voir_plus">(+)</a><a href="javascript:effacer_critere('nationalite');" class="voir_moins" id="nationalite_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_nationalite" hidden><?php echo $list['search_nationalite_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="religion"><label>- <?php echo $lang_search["Religion"];?> <a href="javascript:afficher_critere('religion');" class="voir_plus" id="religion_voir_plus">(+)</a><a href="javascript:effacer_critere('religion');" class="voir_moins" id="religion_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_religion" hidden><?php echo $list['search_religion_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="niveau_etude"><label>- <?php echo $lang_search["NiveauEtudes"];?> <a href="javascript:afficher_critere('niveau_etude');" class="voir_plus" id="niveau_etude_voir_plus">(+)</a><a href="javascript:effacer_critere('niveau_etude');" class="voir_moins" id="niveau_etude_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_niveau_etude" hidden><?php echo $list['search_niveau_etude_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="secteur_activite"><label>- <?php echo $lang_search["SecteurActivite"];?> <a href="javascript:afficher_critere('secteur_activite');" class="voir_plus" id="secteur_activite_voir_plus">(+)</a><a href="javascript:effacer_critere('secteur_activite');" class="voir_moins" id="secteur_activite_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_secteur_activite" hidden><?php echo $list['search_secteur_activite_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="statut_marital"><label>- <?php echo $lang_search["StatutMarital"];?> <a href="javascript:afficher_critere('statut_marital');" class="voir_plus" id="statut_marital_voir_plus">(+)</a><a href="javascript:effacer_critere('statut_marital');" class="voir_moins" id="statut_marital_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_statut_marital" hidden><?php echo $list['search_statut_marital_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="vie"><label>- <?php echo $lang_search["ModeDeVie"];?> <a href="javascript:afficher_critere('vie');" class="voir_plus" id="vie_voir_plus">(+)</a><a href="javascript:effacer_critere('vie');" class="voir_moins" id="vie_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_vie" hidden><?php echo $list['search_vie_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="garde"><label>- <?php echo $lang_search["QuiLaGarde"];?>? <a href="javascript:afficher_critere('garde');" class="voir_plus" id="garde_voir_plus">(+)</a><a href="javascript:effacer_critere('garde');" class="voir_moins" id="garde_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_garde" hidden><?php echo $list['search_garde_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="fumer"><label>- <?php echo $lang_search["Fumeur"];?>? <a href="javascript:afficher_critere('fumer');" class="voir_plus" id="fumer_voir_plus">(+)</a><a href="javascript:effacer_critere('fumer');" class="voir_moins" id="fumer_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_fumer" hidden><?php echo $list['search_fumer_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="temperament"><label>- <?php echo $lang_search["Temperament"];?> <a href="javascript:afficher_critere('temperament');" class="voir_plus" id="temperament_voir_plus">(+)</a><a href="javascript:effacer_critere('temperament');" class="voir_moins" id="temperament_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_temperament" hidden><?php echo $list['search_temperament_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="langue"><label>- <?php echo $lang_search["LanguesParlees"];?> <a href="javascript:afficher_critere('langue');" class="voir_plus" id="langue_voir_plus">(+)</a><a href="javascript:effacer_critere('langue');" class="voir_moins" id="langue_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_langue" hidden><?php echo $list['search_langue_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="cherche_relation"><label>- <?php echo $lang_search["RelationCherchee"];?> <a href="javascript:afficher_critere('cherche_relation');" class="voir_plus" id="cherche_relation_voir_plus">(+)</a><a href="javascript:effacer_critere('cherche_relation');" class="voir_moins" id="cherche_relation_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_cherche_relation" hidden><?php echo $list['search_cherche_relation_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="me_marier"><label>- <?php echo $lang_search["LeMariageEst"];?> <a href="javascript:afficher_critere('me_marier');" class="voir_plus" id="me_marier_voir_plus">(+)</a><a href="javascript:effacer_critere('me_marier');" class="voir_moins" id="me_marier_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_me_marier" hidden><?php echo $list['search_me_marier_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="vouloir_enfants"><label>- <?php echo $lang_search["NombreEnfantsSouhaites"];?> <a href="javascript:afficher_critere('vouloir_enfants');" class="voir_plus" id="vouloir_enfants_voir_plus">(+)</a><a href="javascript:effacer_critere('vouloir_enfants');" class="voir_moins" id="vouloir_enfants_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_vouloir_enfants" hidden><?php echo $list['search_vouloir_enfants_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="search_hr"><hr /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="cuisine"><label>- <?php echo $lang_search["Cuisine"];?> <a href="javascript:afficher_critere('cuisine');" class="voir_plus" id="cuisine_voir_plus">(+)</a><a href="javascript:effacer_critere('cuisine');" class="voir_moins" id="cuisine_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_cuisine" hidden><?php echo $list['search_cuisine_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="sortie"><label>- <?php echo $lang_search["Sorties"];?> <a href="javascript:afficher_critere('sortie');" class="voir_plus" id="sortie_voir_plus">(+)</a><a href="javascript:effacer_critere('sortie');" class="voir_moins" id="sortie_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_sortie" hidden><?php echo $list['search_sortie_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="loisir"><label>- <?php echo $lang_search["Loisirs"];?> <a href="javascript:afficher_critere('loisir');" class="voir_plus" id="loisir_voir_plus">(+)</a><a href="javascript:effacer_critere('loisir');" class="voir_moins" id="loisir_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_loisir" hidden><?php echo $list['search_loisir_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="sport"><label>- <?php echo $lang_search["PratiquesSportives"];?> <a href="javascript:afficher_critere('sport');" class="voir_plus" id="sport_voir_plus">(+)</a><a href="javascript:effacer_critere('sport');" class="voir_moins" id="sport_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_sport" hidden><?php echo $list['search_sport_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="musique"><label>- <?php echo $lang_search["Musique"];?> <a href="javascript:afficher_critere('musique');" class="voir_plus" id="musique_voir_plus">(+)</a><a href="javascript:effacer_critere('musique');" class="voir_moins" id="musique_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_musique" hidden><?php echo $list['search_musique_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="film"><label>- <?php echo $lang_search["Films"];?> <a href="javascript:afficher_critere('film');" class="voir_plus" id="film_voir_plus">(+)</a><a href="javascript:effacer_critere('film');" class="voir_moins" id="film_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_film" hidden><?php echo $list['search_film_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="lecture"><label>- <?php echo $lang_search["Lecture"];?> <a href="javascript:afficher_critere('lecture');" class="voir_plus" id="lecture_voir_plus">(+)</a><a href="javascript:effacer_critere('lecture');" class="voir_moins" id="lecture_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_lecture" hidden><?php echo $list['search_lecture_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td id="animaux"><label>- <?php echo $lang_search["Animaux"];?> <a href="javascript:afficher_critere('animaux');" class="voir_plus" id="animaux_voir_plus">(+)</a><a href="javascript:effacer_critere('animaux');" class="voir_moins" id="animaux_voir_moins" hidden>(-)</a></label></td>
								</tr>
								<tr>
									<td class="critere" id="critere_animaux" hidden><?php echo $list['search_animaux_id']; ?></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					<!--<tr>
						<td colspan="3" align="right">
								<a href="javascript:document.search.action.value='save';document.search.submit();" class="bouton annuler"><?php echo $lang_search["Enregistrer"];?></a> <a href="javascript:document.search.submit();" class="bouton envoyer"><?php echo $lang_search["Rechercher"];?></a>
						</td>
					</tr>-->
				</table>
				<div class="row searchform">
					<div class="col-md-12 parentsolo_plr_0 parentsolo_txt_center parentsolo_mt_20">
					<a href="javascript:document.search.action.value='save';document.search.submit();" class="bouton annuler  parentsolo_btn"><?php echo $lang_search["Enregistrer"];?></a> 
					<a href="javascript:document.search.submit();" class="bouton envoyer  parentsolo_btn"><?php echo $lang_search["Rechercher"];?></a>

					</div>
					</div>
				<input type="hidden" name="search_lang" id="search_lang" value="<?php echo $_GET["lang"];?>">
				<input type="hidden" name="lang" id="lang" value="<?php echo $_GET["lang"];?>">
				<input type="hidden" name="app" value="search" />
				<input type="hidden" name="action" value="<?php echo $action == 'step6' ? 'step6submit' : 'searchsubmit'; ?>" />
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
			</form>
	
			<script language="javascript" type="text/javascript">
				function loadVilles(prefix) {
					if(prefix==null){
						prefix='';
					} 
					
					new Request({
						url: $('site_url').value+'/app/app_home/ajax.php',
						method: 'get',
						headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
						data: {
							"canton_id": $(prefix+'canton_id').value, 
							"ville_id": $(prefix+'ville_id').value, 
							"lang": $(prefix+'lang').value, 
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

			<br />
			<hr>
			<div <?php if($list['search_display']==0){echo "style=display:block;";}else{ echo "style=display:none;";}?>>
				<form name="search_affichage_liste" >
						<h3 class="loginprofile_title_h3 parentsolo_mt_20 parentsolo_txt_center  parentsolo_pb_15">
				<?php echo $lang_search["ResultatDeMaRecherche"]; ?> </h3>
				<h3 class="loginprofile_title_h3 parentsolo_mt_20 parentsolo_pb_15">
						<?php echo $lang_search["Affichage"]; ?> :<input type="radio" name="search_display" value="0" id="search_display_0" checked style="width:20px;">
				<span for="search_display_0"><i class="fa fa-th-large"></i> <?php echo $lang_search["Galerie"]; ?></span>
				<input type="radio" name="search_display" value="1" id="search_display_1" class="searchRadio" onclick="javascript:document.search_affichage_liste.submit();" style="width:20px;">
				<span for="search_display_1"><i class="fa fa-th-list"></i> <?php echo $lang_search["Liste"]; ?></span>
				</h3>
				<input type="hidden" name="lang" id="lang" value="<?php echo $_GET["lang"];?>">
				<input type="hidden" name="app" value="search" />
				<input type="hidden" name="search_page" value="<?php echo $page;?>" />
				<input type="hidden" name="action" value="<?php echo 'searchaffichage'; ?>" />
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
				</form>
					<div class="row">
					<div class="col-md-12 group">
					
					<?php 						$nb_results		= count($results);
				
						$i = 1;
					
						if(is_array($results) && $nb_results){
				
							$nb_fin = ($nb_results < 8) ? $nb_results : 8;
							
							for($j=0; $j<$nb_fin; $j++) {
								$result = $results[$j];
								// limitation de la longueur de l'intro
								$result->annonce = strip_tags(html_entity_decode($result->annonce));
								if(strlen($result->annonce) > LISTE_INTRO_CHAR_text) {
									$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text).'...';
								}
								
								// &agrave; placer toujours apr&egrave;s les 2 limitations
								JL::makeSafe($result, 'annonce');
								
								if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

									$last_online_class 		= 'lo_online';
									$last_online_label		= $lang_search["EnLigne"];

								} else{ // aujourd'hui (60*60*24)

									$last_online_class 	= 'lo_offline';
									$last_online_label	= $lang_search["HorsLigne"];

								}
								
								
								// r&eacute;cup la photo de l'utilisateur
								$photo_galerie = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

								if(!$photo_galerie) {
									$photo_galerie = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
								}
								
								
								if($i%4 == 1){ echo '';}
								
								?>
								
								<div class="col-md-3 col-xs-12 parentsolo_txt_center">
												<div class="hovereffect ">
														<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"]; ?>"><img src="<?php echo $photo_galerie; ?>" alt="<?php echo $result->username; ?>" class="profil"/></a>
														<div class="overlay">
																<h2><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>" title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a></h2>
<span><br><?php echo JL::calcul_age($result->naissance_date); ?><br />
											<?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?><br />
											<?php echo $result->canton_abrev; ?><br /></span>
																											</div>
												</div>
												<div class="clear"></div>
												<h3 class="">
													<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
												</h3>
												<p class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></p>
											</div>
								
									
					<?php 								
								if($i%4 == 0){echo ""; }
								
								$i++;
							}
							
							if($i%4!=1){
								while($i%4!=1){
									echo '<div class="preview_off"></div>';
									if($i%4 == 0){echo ""; }
									
									$i++;
								}
							}
							
						}else{
					?>
							<tr>
								<td align="middle">
									<?php echo $lang_search["RechercheAucunMembre"];?>!
								</td>
							</tr>
					<?php 						}
					?>
								
					</div>
				</div>
					<table class="result search_previews" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="pub">
								<?JL::loadMod('pub'); ?>
							</td>
						</tr>
					</table>
					<?php	
					
						if($nb_results>8){
							?>
								<div class="row">
					<div class="col-md-12 group">
					<?php 							
							for($j=8; $j<$nb_results; $j++) {
								
								$result = $results[$j];
								// limitation de la longueur de l'intro
								$result->annonce = strip_tags(html_entity_decode($result->annonce));
								if(strlen($result->annonce) > LISTE_INTRO_CHAR_text) {
									$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text).'...';
								}
								
								// &agrave; placer toujours apr&egrave;s les 2 limitations
								JL::makeSafe($result, 'annonce');
								
								if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

									$last_online_class 		= 'lo_online';
									$last_online_label		= $lang_search["EnLigne"];

								} else{ // aujourd'hui (60*60*24)

									$last_online_class 	= 'lo_offline';
									$last_online_label	= $lang_search["HorsLigne"];

								}
								
								// r&eacute;cup la photo de l'utilisateur
								$photo_galerie = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

								if(!$photo_galerie) {
									$photo_galerie = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
								}
								
								
								if($i%4 == 1){ echo '';}
								
								?>
								<div class="col-md-3 col-xs-12 parentsolo_txt_center">
												<div class="hovereffect ">
														<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"]; ?>"><img src="<?php echo $photo_galerie; ?>" alt="<?php echo $result->username; ?>" class="profil"/></a>
														<div class="overlay">
																<h2><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"  title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a></h2>
<span><br><?php echo JL::calcul_age($result->naissance_date); ?><br />
											<?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?><br />
											<?php echo $result->canton_abrev; ?><br />
											</span>
																											</div>
												</div>
												<div class="clear"></div>
												<h3 class="">
													<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"  title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>	
												</h3>
												<p class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></p>
											</div>
									
					<?php 								
								if($i%4 == 0){echo ""; }
								
								$i++;
							}
							
							if($i%4!=1){
								while($i%4!=1){
									echo '<div class="preview_off"></div>';
									if($i%4 == 0){echo ""; }
									
									$i++;
								}
							}
							
						?>
					</div>
								</div>
				<?php 					}
					?>
			</div>
		
			<div <?php if($list['search_display']==0){echo "style=display:none;";}else{ echo "style=display:block;";}?>>
				<hr><form name="search_affichage_galerie" >
						<h3 class="loginprofile_title_h3 parentsolo_mt_20 parentsolo_txt_center  parentsolo_pb_15">
				<?php echo $lang_search["ResultatDeMaRecherche"]; ?> </h3>
				<h3 class="loginprofile_title_h3 parentsolo_mt_20 parentsolo_pb_15">
						<?php echo $lang_search["Affichage"]; ?> :
				<input type="radio" name="search_display" value="0" id="search_display_0" onclick="javascript:document.search_affichage_galerie.submit();" style="width:20px;">
				<span for="search_display_0"><i class="fa fa-th-large"></i> <?php echo $lang_search["Galerie"]; ?></span>
				<input type="radio" name="search_display" value="1" id="search_display_1" class="searchRadio" checked style="width:20px;">
				<span for="search_display_1"><i class="fa fa-th-list"></i> <?php echo $lang_search["Liste"]; ?></span>
				</h3>		
				<input type="hidden" name="lang" id="lang" value="<?php echo $_GET["lang"];?>">
				<input type="hidden" name="app" value="search" />
				<input type="hidden" name="search_page" value="<?php echo $page;?>" />
				<input type="hidden" name="action" value="<?php echo 'searchaffichage'; ?>" />
				<input type="hidden" name="site_url" id="site_url" value="<?php echo SITE_URL; ?>" />
				</form>
					
					<div class="row">
				<div class="col-md-12">
					
				<?php 						$nb_results		= count($results);
				
						$i = 1;
					
						if(is_array($results) && $nb_results){
				
							$nb_fin = ($nb_results < 8) ? $nb_results : 8;

							for($j=0; $j<$nb_fin; $j++) {
								$result = $results[$j];
								// limitation de la longueur de l'intro
								$result->annonce = strip_tags(html_entity_decode($result->annonce));
								if(strlen($result->annonce) > LISTE_INTRO_CHAR_text) {
									$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text).'...';
								}
								
								
								// r&eacute;cup la photo de l'utilisateur
								$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

								if(!$photo_liste) {
									$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
								}
								
								
								if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

									$last_online_class 		= 'lo_online';
									$last_online_label		= $lang_search["EnLigne"];

								} else{ // aujourd'hui (60*60*24)

									$last_online_class 	= 'lo_offline';
									$last_online_label	= $lang_search["HorsLigne"];

								}
								
								if($i%2 == 1){ echo '';}
								
								?>
								<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						
						<div class="col-md-4 col-sm-3  col-xs-12  parentsolo_pt_10">
							<div class="hovereffect parentsolo_border_radius  ">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"  title="<?php echo $lang_search["VoirCeProfil"]; ?>">
										<img src="<?php echo $photo_liste; ?>" alt="<?php echo $result->username; ?>" class="profil"/>
										</a>
						
													</div>
						</div>
						<div class="col-md-8 col-sm-9  col-xs-12  parentsolo_pt_10 parentsolo_pb_10">
								<h4 class="letter_spacing_0  parentsolo_pb_10 parentsolo_font-size parentsolo_txt_overflow_title">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
						</h4>
						<div class="supplement members_cls line_height_25">
										<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>">
										<img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" >
										<img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
										<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
										
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
									
										</div>
						<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
												<!--<div class="connect">
														<span class="<?php echo $last_online_class; ?>">
														<?php echo $last_online_label; ?></span>
												</div>-->
												</div>
						</div>
						<div class="col-md-12 parentsolo_pt_10">
					
												
										
										<div class="description text-box">
											<?php echo $result->annonce; ?>
										</div>
						</div>
								</div>
					</div>
								
					<?php 								
								if($i%2 == 0){echo "<div class='clear'></div>"; }
								
								$i++;
							}
							
							if($i%2!=1){
								while($i%2!=1){
									echo '<div class="preview_liste_off"></div>';
									if($i%2 == 0){echo ""; }
									
									$i++;
								}
							}
							
						}else{
					?>
							<tr>
								<td align="middle">
									<?php echo $lang_search["RechercheAucunMembre"];?>!
								</td>
							</tr>
					<?php 						}
					?>
								
						</div>
				</div>
					<table class="result search_previews" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="pub">
								<?JL::loadMod('pub'); ?>
							</td>
						</tr>
					</table>
				<?php 					
						if($nb_results>8){
							?>
							<div class="row">
				<div class="col-md-12">
							<?php 							for($j=8; $j<$nb_results; $j++) {
								$result = $results[$j];
								// limitation de la longueur de l'intro
								$result->annonce = strip_tags(html_entity_decode($result->annonce));
								if(strlen($result->annonce) > LISTE_INTRO_CHAR_text) {
									$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text).'...';
								}
								
								
								// r&eacute;cup la photo de l'utilisateur
								$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

								if(!$photo_liste) {
									$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
								}
								
								if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

									$last_online_class 		= 'lo_online';
									$last_online_label		= $lang_search["EnLigne"];

								} else{ // aujourd'hui (60*60*24)

									$last_online_class 	= 'lo_offline';
									$last_online_label	= $lang_search["HorsLigne"];

								}
								
								if($i%2 == 1){ echo '';}
								
								?>
								<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						
						<div class="col-md-4 col-sm-3  col-xs-12  parentsolo_pt_10">
							<div class="hovereffect parentsolo_border_radius  ">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"]; ?>">
								<img src="<?php echo $photo_liste; ?>" alt="<?php echo $result->username; ?>" class="profil"/>
								</a>
						
													</div>
						</div>
						<div class="col-md-8 col-sm-9  col-xs-12  parentsolo_pt_10 parentsolo_pb_10">
								<h4 class="letter_spacing_0  parentsolo_pb_10 parentsolo_font-size parentsolo_txt_overflow_title">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
						</h4>
						<div class="supplement members_cls line_height_25">
										<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
										<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
										
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
									
										</div>
						<div class="infos">
								<?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
								<!--<div class="connect">
								<span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?>
								</span>
								</div>-->
								</div>
						</div>
						
						<div class="col-md-12 parentsolo_pt_10">
					
												
										
										<div class="description text-box">
											<?php echo $result->annonce; ?>
										</div>
						</div>
								</div>
					</div>
								
					<?php 								
								if($i%2 == 0){echo "<div class='clear'></div>"; }
								
								$i++;
							}
							
							if($i%2!=1){
								while($i%2!=1){
									echo '<div class="preview_liste_off"></div>';
									if($i%2 == 0){echo ""; }
									
									$i++;
								}
							}
							
						?>
						
				</div>
							</div>
		<?php 			}
			?>
			</div>
			<div class="col-md-12 parentsolo_plr_0">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" cellpadding="0" cellspacing="0">
						<div class="col-md-3 text-left">
								<?php if($page_prev > 0) { ?>
										<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$page_prev.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["PagePrecedente"];?>" class="bouton envoyer">&laquo; <?php echo $lang_search["PagePrecedente"];?></a>
									<?php } ?>
							</div>
							<div class="col-md-6 text-center page_nav">
								<span style="font-weight:bold;"><?php echo $pageTotal==1 ? $lang_search["Page"] : $lang_search["Pages"];?> :</span>
									<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page=1'.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["Debut"];?>"><?php echo $lang_search["Debut"];?></a> |<?php }?>
									<?php 										for($i=$debut; $i<=$fin; $i++) {
										?>
											 <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page='.@$i.(@$search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["Page"];?> <?php echo @$i; ?>" <?php if(@$i == @$page) { ?>class="active"<?php } ?>><?php echo @$i; ?></a>
										<?php 										}
									?>
									<?php if($fin < $pageTotal) { ?> | <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$pageTotal.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["Fin"];?>"><?php echo $lang_search["Fin"];?></a><?php }?>
								</div>
							<div class="col-md-3 text-right">
								<?php if($page_next > 0) { ?>
										<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$page_next.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["PageSuivante"];?>" class="bouton envoyer"><?php echo $lang_search["PageSuivante"];?> &raquo;</a>
									<?php } ?>
							</div>
					</div>
				</div>
				<div class="clear"></div>
			
			
			
	<?php 	}



	public static function searchVisits(&$list, &$results, &$messages) {
		global $langue;
		include("lang/app_search.".$_GET['lang'].".php");
		global $action;

		// variables
		$page 		= JL::getSessionInt('search_page', 1);
		$pageTotal 	= JL::getSessionInt('search_page_total', 1)== 0 ? 1 : JL::getSessionInt('search_page_total', 1);
		$rayon 		= 5;
		$debut		= ($page - $rayon) >= 1 ? $page - $rayon : 1;
		$fin		= ($page + $rayon) <= $pageTotal ? $page + $rayon : $pageTotal;

		$page_prev	= $page-1 >= 1 ? $page-1 : 0;
		$page_next	= $page+1 <= $pageTotal ? $page+1 : 0;
		
		// affichage des messages
		HTML_search::messages($messages);

	?>
		
		<form name="search_affichage_liste" >
				<div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre cur"><?php echo $lang_search["QuiAConsulteMonProfil"]; ?>? </h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
				
	<div class="row">
				<div class="col-md-12">
			
				<?php 					$nb_results		= count($results);
			
					$i = 1;
				
					if(is_array($results) && $nb_results){
			
						$nb_fin = ($nb_results < 8) ? $nb_results : 8;

						for($j=0; $j<$nb_fin; $j++) {
							$result = $results[$j];
							// limitation de la longueur de l'intro
							$result->annonce = strip_tags(html_entity_decode($result->annonce));
							if(strlen($result->annonce) > LISTE_INTRO_CHAR_text_over) {
								$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text_over).'...';
							}
							
							JL::makeSafe($result, 'annonce');
							
							// r&eacute;cup la photo de l'utilisateur
							$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

							if(!$photo_liste) {
								$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
							}
							
							
							if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online && $result->on_off_status==1) { // 30 minutes (60*30)

								$last_online_class 		= 'lo_online';
								$last_online_label		= $lang_search["EnLigne"];

							} else{ // aujourd'hui (60*60*24)

								$last_online_class 	= 'lo_offline';
								$last_online_label	= $lang_search["HorsLigne"];

							}
							
							if($i%2 == 1){ echo '';}
							
							?>
							<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						
						<div class="col-md-4 col-sm-3  col-xs-12  parentsolo_pt_10">
							<div class="hovereffect parentsolo_border_radius  ">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"]; ?>">
								<img src="<?php echo $photo_liste; ?>" alt="<?php echo $result->username; ?>" class="profil"/>
								</a>
								
						
													</div>
						</div>
						<div class="col-md-8 col-sm-9  col-xs-12  parentsolo_pt_10 parentsolo_pb_10">
								<h4 class="letter_spacing_0  parentsolo_pb_10 parentsolo_font-size parentsolo_txt_overflow_title">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
						</h4>
						<div class="supplement members_cls line_height_25">
										<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
										<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
								</div>
						<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
						
						</div>
						<div class="supplement">
									<b><?php echo $lang_search["DerniereVisite"];?>:</b> <?php echo date('d/m/Y', strtotime($result->visite_last_date)); ?><br>
									<b><?php echo $lang_search["NombreTotalVisites"];?>:</b> <?php echo $result->visite_nb; ?>
								</div>
						<!--<div class="connect">
								<span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span>
						</div>-->
						</div>
						
						<div class="col-md-12 parentsolo_pt_10">
					
												
										
										<div class="description text-box">
											<?php echo $result->annonce; ?>
										</div>
						</div>
								</div>
					</div>
							
							
							
							
			<?php 							
							if($i%2 == 0){echo "<div class='clear'></div>"; }
							
							$i++;
						}
						
						if($i%2!=1){
							while($i%2!=1){
								echo '<div class="preview_liste_off"></div>';
								if($i%2 == 0){echo ""; }
								
								$i++;
							}
						}
						
					}else{
				?>
						<div class="col-md-12 text-center">
							<div align="middle">
								<?php echo $lang_search["VisitesAucunMembre"];?>!
							</div>
						</div >
				<?php 					}
				?>
				</div></div>
				<div class="row">
					<div class=>
						<td class="pub">
							<?JL::loadMod('pub'); ?>
						</td>
					</div>
				</div>
			<?php 				
					if($nb_results>8){
						?>
							<div class="row">
				<div class="col-md-12">
						<?php 						for($j=8; $j<$nb_results; $j++) {
							$result = $results[$j];
							// limitation de la longueur de l'intro
							$result->annonce = strip_tags(html_entity_decode($result->annonce));
							if(strlen($result->annonce) > LISTE_INTRO_CHAR_text_over) {
								$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text_over).'...';
							}
							
							JL::makeSafe($result, 'annonce');
							
							// r&eacute;cup la photo de l'utilisateur
							$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

							if(!$photo_liste) {
								$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
							}
							
							if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

								$last_online_class 		= 'lo_online';
								$last_online_label		= $lang_search["EnLigne"];

							} else{ // aujourd'hui (60*60*24)

								$last_online_class 	= 'lo_offline';
								$last_online_label	= $lang_search["HorsLigne"];

							}
								
							if($i%2 == 1){ echo '<tr>';}
							
							?>
							<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						
						<div class="col-md-4 col-sm-3  col-xs-12  parentsolo_pt_10">
							<div class="hovereffect parentsolo_border_radius  ">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"]; ?>">
								<img src="<?php echo $photo_liste; ?>" alt="<?php echo $result->username; ?>" class="profil"/>
								</a>
						
													</div>
						</div>
						<div class="col-md-8 col-sm-9  col-xs-12  parentsolo_pt_10 parentsolo_pb_10">
								<h4 class="letter_spacing_0  parentsolo_pb_10 parentsolo_font-size parentsolo_txt_overflow_title">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
						</h4>
						<div class="supplement members_cls line_height_25">
									<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
									<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
								</div>
						<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
						</div>
						<div class="supplement">
									<b><?php echo $lang_search["DerniereVisite"];?>:</b> <?php echo date('d/m/Y', strtotime($result->visite_last_date)); ?><br />
									<b><?php echo $lang_search["NombreTotalVisites"];?>:</b> <?php echo $result->visite_nb; ?>
								</div>
								<!--<div class="connect"><span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span></div>-->
						</div>
						
						<div class="col-md-12 parentsolo_pt_10">
					
												
										
										<div class="description text-box">
												<?php echo $result->annonce; ?>
										</div>
						</div>
								</div>
					</div>
							
							
							
							
			<?php 							
							if($i%2 == 0){echo "<div class='clear'></div>"; }
							
							$i++;
						}
						
						if($i%2!=1){
							while($i%2!=1){
								echo '<td class="preview_liste_off"></td>';
								if($i%2 == 0){echo "</tr>"; }
								
								$i++;
							}
						}
						
					?>
				</div></div>
	<?php 		}
		?>
		
    
    
    <div class="col-md-12 parentsolo_plr_0">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" cellpadding="0" cellspacing="0">
						<div class="col-md-3 text-left">
								<?php if($page_prev > 0) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$page_prev.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["PagePrecedente"];?>" class="bouton envoyer">&laquo; <?php echo $lang_search["PagePrecedente"];?></a>
								<?php } ?>
							</div>
							<div class="col-md-6 text-center page_nav">
								<span style="font-weight:bold;"><?php echo $pageTotal==1 ? $lang_search["Page"] : $lang_search["Pages"];?> : </span>
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page=1'.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["Debut"];?>"><?php echo $lang_search["Debut"];?></a> |<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page='.$i.(@$search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["Page"];?> <?php echo @$i; ?>" <?php if(@$i == @$page) { ?>class="active"<?php } ?>><?php echo @$i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $pageTotal) { ?> | <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$pageTotal.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["Fin"];?>"><?php echo $lang_search["Fin"];?></a><?php }?>
							</div>
							<div class="col-md-3 text-right">
								<?php if($page_next > 0) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$page_next.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["PageSuivante"];?>" class="bouton envoyer"><?php echo $lang_search["PageSuivante"];?> &raquo;</a>
								<?php } ?>
							</div>
					</div>
				</div>
				<div class="clear"></div>
	<?php 	}

	public static function searchMyprofile(&$list, &$results, &$messages) {
		global $langue;
		include("lang/app_search.".$_GET['lang'].".php");
		global $action;

		// variables
		$page 		= JL::getSessionInt('search_page', 1);
		$pageTotal 	= JL::getSessionInt('search_page_total', 1)== 0 ? 1 : JL::getSessionInt('search_page_total', 1);
		$rayon 		= 5;
		$debut		= ($page - $rayon) >= 1 ? $page - $rayon : 1;
		$fin		= ($page + $rayon) <= $pageTotal ? $page + $rayon : $pageTotal;

		$page_prev	= $page-1 >= 1 ? $page-1 : 0;
		$page_next	= $page+1 <= $pageTotal ? $page+1 : 0;
		
		// affichage des messages
		HTML_search::messages($messages);

	?>
		
		<form name="search_affichage_liste" >
				<div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre cur"><?php echo $lang_search["mylastvisites"]; ?>? </h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
				
	<div class="row">
				<div class="col-md-12">
			
				<?php 					$nb_results		= count($results);
			
					$i = 1;
				
					if(is_array($results) && $nb_results){
			
						$nb_fin = ($nb_results < 8) ? $nb_results : 8;

						for($j=0; $j<$nb_fin; $j++) {
							$result = $results[$j];
							// limitation de la longueur de l'intro
							$result->annonce = strip_tags(html_entity_decode($result->annonce));
							if(strlen($result->annonce) > LISTE_INTRO_CHAR_text_over) {
								$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text_over).'...';
							}
							
							JL::makeSafe($result, 'annonce');
							
							// r&eacute;cup la photo de l'utilisateur
							$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

							if(!$photo_liste) {
								$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
							}
							
							
							if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online && $result->on_off_status==1) { // 30 minutes (60*30)

								$last_online_class 		= 'lo_online';
								$last_online_label		= $lang_search["EnLigne"];

							} else{ // aujourd'hui (60*60*24)

								$last_online_class 	= 'lo_offline';
								$last_online_label	= $lang_search["HorsLigne"];

							}
							
							if($i%2 == 1){ echo '';}
							
							?>
							<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						
						<div class="col-md-4 col-sm-3  col-xs-12  parentsolo_pt_10">
							<div class="hovereffect parentsolo_border_radius  ">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"]; ?>">
								<img src="<?php echo $photo_liste; ?>" alt="<?php echo $result->username; ?>" class="profil"/>
								</a>
								
						
													</div>
						</div>
						<div class="col-md-8 col-sm-9  col-xs-12  parentsolo_pt_10 parentsolo_pb_10">
								<h4 class="letter_spacing_0  parentsolo_pb_10 parentsolo_font-size parentsolo_txt_overflow_title">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
						</h4>
						<div class="supplement members_cls line_height_25">
										<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
										<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
								</div>
						<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
						
						</div>
						<div class="supplement">
									<b><?php echo $lang_search["DerniereVisite"];?>:</b> <?php echo date('d/m/Y', strtotime($result->visite_last_date)); ?><br>
									<b><?php echo $lang_search["NombreTotalVisites"];?>:</b> <?php echo $result->visite_nb; ?>
								</div>
						<!--<div class="connect">
								<span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span>
						</div>-->
						</div>
						
						<div class="col-md-12 parentsolo_pt_10">
					
												
										
										<div class="description text-box">
											<?php echo $result->annonce; ?>
										</div>
						</div>
								</div>
					</div>
							
							
							
							
			<?php 							
							if($i%2 == 0){echo "<div class='clear'></div>"; }
							
							$i++;
						}
						
						if($i%2!=1){
							while($i%2!=1){
								echo '<div class="preview_liste_off"></div>';
								if($i%2 == 0){echo ""; }
								
								$i++;
							}
						}
						
					}else{
				?>
						<div class="col-md-12 text-center">
							<div align="middle">
								<?php echo $lang_search["VisitesAucunMembre"];?>!
							</div>
						</div >
				<?php 					}
				?>
				</div></div>
				<div class="row">
					<div class=>
						<td class="pub">
							<?JL::loadMod('pub'); ?>
						</td>
					</div>
				</div>
			<?php 				
					if($nb_results>8){
						?>
							<div class="row">
				<div class="col-md-12">
						<?php 						for($j=8; $j<$nb_results; $j++) {
							$result = $results[$j];
							// limitation de la longueur de l'intro
							$result->annonce = strip_tags(html_entity_decode($result->annonce));
							if(strlen($result->annonce) > LISTE_INTRO_CHAR_text_over) {
								$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text_over).'...';
							}
							
							JL::makeSafe($result, 'annonce');
							
							// r&eacute;cup la photo de l'utilisateur
							$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

							if(!$photo_liste) {
								$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
							}
							
							if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

								$last_online_class 		= 'lo_online';
								$last_online_label		= $lang_search["EnLigne"];

							} else{ // aujourd'hui (60*60*24)

								$last_online_class 	= 'lo_offline';
								$last_online_label	= $lang_search["HorsLigne"];

							}
								
							if($i%2 == 1){ echo '<tr>';}
							
							?>
							<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						
						<div class="col-md-4 col-sm-3  col-xs-12  parentsolo_pt_10">
							<div class="hovereffect parentsolo_border_radius  ">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"]; ?>">
								<img src="<?php echo $photo_liste; ?>" alt="<?php echo $result->username; ?>" class="profil"/>
								</a>
						
													</div>
						</div>
						<div class="col-md-8 col-sm-9  col-xs-12  parentsolo_pt_10 parentsolo_pb_10">
								<h4 class="letter_spacing_0  parentsolo_pb_10 parentsolo_font-size parentsolo_txt_overflow_title">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
						</h4>
						<div class="supplement members_cls line_height_25">
									<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
									<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
								</div>
						<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
						</div>
						<div class="supplement">
									<b><?php echo $lang_search["DerniereVisite"];?>:</b> <?php echo date('d/m/Y', strtotime($result->visite_last_date)); ?><br />
									<b><?php echo $lang_search["NombreTotalVisites"];?>:</b> <?php echo $result->visite_nb; ?>
								</div>
								<!--<div class="connect"><span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span></div>-->
						</div>
						
						<div class="col-md-12 parentsolo_pt_10">
					
												
										
										<div class="description text-box">
												<?php echo $result->annonce; ?>
										</div>
						</div>
								</div>
					</div>
							
							
							
							
			<?php 							
							if($i%2 == 0){echo "<div class='clear'></div>"; }
							
							$i++;
						}
						
						if($i%2!=1){
							while($i%2!=1){
								echo '<td class="preview_liste_off"></td>';
								if($i%2 == 0){echo "</tr>"; }
								
								$i++;
							}
						}
						
					?>
				</div></div>
	<?php 		}
		?>
		
    
    
    <div class="col-md-12 parentsolo_plr_0">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" cellpadding="0" cellspacing="0">
						<div class="col-md-3 text-left">
								<?php if($page_prev > 0) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$page_prev.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["PagePrecedente"];?>" class="bouton envoyer">&laquo; <?php echo $lang_search["PagePrecedente"];?></a>
								<?php } ?>
							</div>
							<div class="col-md-6 text-center page_nav">
								<span style="font-weight:bold;"><?php echo $pageTotal==1 ? $lang_search["Page"] : $lang_search["Pages"];?> : </span>
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page=1'.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["Debut"];?>"><?php echo $lang_search["Debut"];?></a> |<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page='.$i.(@$search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["Page"];?> <?php echo @$i; ?>" <?php if(@$i == @$page) { ?>class="active"<?php } ?>><?php echo @$i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $pageTotal) { ?> | <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$pageTotal.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["Fin"];?>"><?php echo $lang_search["Fin"];?></a><?php }?>
							</div>
							<div class="col-md-3 text-right">
								<?php if($page_next > 0) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$page_next.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["PageSuivante"];?>" class="bouton envoyer"><?php echo $lang_search["PageSuivante"];?> &raquo;</a>
								<?php } ?>
							</div>
					</div>
				</div>
				<div class="clear"></div>
	<?php 	}
	
	
	
	
	public static function searchOnline(&$list, &$results, &$messages) {
		global $langue;
		include("lang/app_search.".$_GET['lang'].".php");
		global $action;

		// variables
		$page 		= JL::getSessionInt('search_page', 1);
		$pageTotal 	= JL::getSessionInt('search_page_total', 1)== 0 ? 1 : JL::getSessionInt('search_page_total', 1);
		$rayon 		= 5;
		$debut		= ($page - $rayon) >= 1 ? $page - $rayon : 1;
		$fin		= ($page + $rayon) <= $pageTotal ? $page + $rayon : $pageTotal;

		$page_prev	= $page-1 >= 1 ? $page-1 : 0;
		$page_next	= $page+1 <= $pageTotal ? $page+1 : 0;

		// affichage des messages
		HTML_search::messages($messages);

	?>
	<div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre "><?php echo $lang_search["EnLigne"]; ?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
		
		
			<div class="row">
				<div class="col-md-12">
				<?php 					$nb_results		= count($results);
			
					$i = 1;
				
					if(is_array($results) && $nb_results){
			
						$nb_fin = ($nb_results < 8) ? $nb_results : 8;

						for($j=0; $j<$nb_fin; $j++) {
							$result = $results[$j];
							// limitation de la longueur de l'intro
							$result->annonce = strip_tags(html_entity_decode($result->annonce));
							if(strlen($result->annonce) > LISTE_INTRO_CHAR_text) {
								$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text).'...';
							}
							
							JL::makeSafe($result, 'annonce');
							
							// r&eacute;cup la photo de l'utilisateur
							$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

							if(!$photo_liste) {
								$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
							}
							
							
							if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

								$last_online_class 		= 'lo_online';
								$last_online_label		= $lang_search["EnLigne"];

							} else{ // aujourd'hui (60*60*24)

								$last_online_class 	= 'lo_offline';
								$last_online_label	= $lang_search["HorsLigne"];

							}
							
							if($i%2 == 1){ echo '';}
							
							?>
							<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						
						<div class="col-md-4 col-sm-3  col-xs-12  parentsolo_pt_10">
							<div class="hovereffect parentsolo_border_radius  ">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"]; ?>">
								<img src="<?php echo $photo_liste; ?>" alt="<?php echo $result->username; ?>" class="profil"/>
								</a>
						
													</div>
						</div>
						<div class="col-md-8 col-sm-9  col-xs-12  parentsolo_pt_10 parentsolo_pb_10">
								<h4 class="letter_spacing_0  parentsolo_pb_10 parentsolo_font-size parentsolo_txt_overflow_title">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
						</h4>
						<div class="supplement members_cls line_height_25">
									<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
									<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
								</div>
						<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
						
						</div>
						
						<!--<div class="connect">
								<span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span>
						</div>-->
						</div>
						
						<div class="col-md-12 parentsolo_pt_10">
						<div class="description text-box">
											<?php echo $result->annonce; ?>
										</div>
						</div>
								</div>
					</div>
							
			<?php 							
							if($i%2 == 0){echo "<div class='clear'></div>"; }
							
							$i++;
						}
						
						if($i%2!=1){
							while($i%2!=1){
								echo '<div class="preview_liste_off"></div>';
								if($i%2 == 0){echo ""; }
								
								$i++;
							}
						}
						
					}else{
				?>
						
							<div class="col-md-12 text-center">
								<?php echo $lang_search["OnlineAucunMembre"];?>!
							</div>
						
				<?php 					}
				?>
				</div></div>
				<div class="row" cellpadding="0" cellspacing="0" width="100%">
					<div class="col-md-12">
						<div class="text-center">
							<?JL::loadMod('pub'); ?>
						</div>
					</div>
				</div>
			<?php 				
					if($nb_results>8){
						?>
							<div class="row">
				<div class="col-md-12">
						<?php 						for($j=8; $j<$nb_results; $j++) {
							$result = $results[$j];
							// limitation de la longueur de l'intro
							$result->annonce = strip_tags(html_entity_decode($result->annonce));
							if(strlen($result->annonce) > LISTE_INTRO_CHAR_text) {
								$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text).'...';
							}
							
							JL::makeSafe($result, 'annonce');
							
							// r&eacute;cup la photo de l'utilisateur
							$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

							if(!$photo_liste) {
								$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
							}
							
							if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

								$last_online_class 		= 'lo_online';
								$last_online_label		= $lang_search["EnLigne"];

							} else{ // aujourd'hui (60*60*24)

								$last_online_class 	= 'lo_offline';
								$last_online_label	= $lang_search["HorsLigne"];

							}
							
							if($i%2 == 1){ echo '';}
							
							?>
							<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						
						<div class="col-md-4 col-sm-3  col-xs-12  parentsolo_pt_10">
							<div class="hovereffect parentsolo_border_radius  ">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"]; ?>">
								<img src="<?php echo $photo_liste; ?>" alt="<?php echo $result->username; ?>" class="profil"/>
								</a>
						
													</div>
						</div>
						<div class="col-md-8 col-sm-9  col-xs-12  parentsolo_pt_10 parentsolo_pb_10">
								<h4 class="letter_spacing_0  parentsolo_pb_10 parentsolo_font-size parentsolo_txt_overflow_title">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
						</h4>
						<div class="supplement members_cls line_height_25">
									<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
									<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
								</div>
						<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
						
						</div>
						
						<!--<div class="connect">
								<span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span>
						</div>-->
						</div>
						
						<div class="col-md-12 parentsolo_pt_10">
						<div class="description text-box">
											<?php echo $result->annonce; ?>
										</div>
						</div>
								</div>
					</div>
			<?php 							
							if($i%2 == 0){echo "<div class='clear'></div>"; }
							
							$i++;
						}
						
						if($i%2!=1){
							while($i%2!=1){
								echo '<div class="preview_liste_off"></div>';
								if($i%2 == 0){echo ""; }
								
								$i++;
							}
						}
						
					?>
					</div>
					</div>
	<?php 		}
		?>
		
		 <div class="col-md-12 parentsolo_plr_0">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" cellpadding="0" cellspacing="0">
						<div class="col-md-3 text-left">
								<?php if($page_prev > 0) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$page_prev.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["PagePrecedente"];?>" class="bouton envoyer">&laquo; <?php echo $lang_search["PagePrecedente"];?></a>
								<?php } ?>
							</div>
							<div class="col-md-6 text-center page_nav">
								<span style="font-weight:bold;"><?php echo $pageTotal==1 ? $lang_search["Page"] : $lang_search["Pages"];?> : </span>
								 <?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page=1'.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["Debut"];?>"><?php echo $lang_search["Debut"];?></a> |<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$i.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["Page"];?> <?php echo $i; ?>" <?php if($i == $page) { ?>class="active"<?php } ?>><?php echo $i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $pageTotal) { ?> | <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$pageTotal.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["Fin"];?>"><?php echo $lang_search["Fin"];?></a><?php }?>
							</div>
							<div class="col-md-3 text-right">
								<?php if($page_next > 0) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.$action.'&search_page='.$page_next.($search_online ? '&search_online=1' : '').'&'.$langue); ?>" title="<?php echo $lang_search["PageSuivante"];?>" class="bouton envoyer"><?php echo $lang_search["PageSuivante"];?> &raquo;</a>
								<?php } ?>
							</div>
					</div>
				</div>
		<div class="clear"></div>
		
	<?php 	}
	
	
	
	public static function searchLastInscription(&$list, &$results, &$messages) {
		global $langue;
		include("lang/app_search.".$_GET['lang'].".php");
		global $action, $user;

		// variables
		$page 		= JL::getSessionInt('search_page', 1);
		$pageTotal 	= JL::getSessionInt('search_page_total', 1)== 0 ? 1 : JL::getSessionInt('search_page_total', 1);
		$rayon 		= 5;
		$debut		= ($page - $rayon) >= 1 ? $page - $rayon : 1;
		$fin		= ($page + $rayon) <= $pageTotal ? $page + $rayon : $pageTotal;

		$page_prev	= $page-1 >= 1 ? $page-1 : 0;
		$page_next	= $page+1 <= $pageTotal ? $page+1 : 0;

		
		switch($user->genre){
			case 'h':
				$h2 = $lang_search["DernieresMamansInscrites"];
			break;
			
			case 'f':
				$h2 = $lang_search["DerniersPapasInscrits"];
			break;
		}

		// affichage des messages
		HTML_search::messages($messages);
		
	?>
	<div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre"><?php echo $h2; ?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
		
		<div class="row">
				<div class="col-md-12">
			<?php 					$nb_results		= count($results);
			
					$i = 1;
				
					if(is_array($results) && $nb_results){
			
						$nb_fin = ($nb_results < 8) ? $nb_results : 8;

						for($j=0; $j<$nb_fin; $j++) {
							$result = $results[$j];
							// limitation de la longueur de l'intro
							$result->annonce = strip_tags(html_entity_decode($result->annonce));
							if(strlen($result->annonce) > LISTE_INTRO_CHAR_text) {
								$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text).'...';
							}
							
							JL::makeSafe($result, 'annonce');
							
							// r&eacute;cup la photo de l'utilisateur
							$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

							if(!$photo_liste) {
								$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
							}
							
							
							if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

								$last_online_class 		= 'lo_online';
								$last_online_label		= $lang_search["EnLigne"];

							} else{ // aujourd'hui (60*60*24)

								$last_online_class 	= 'lo_offline';
								$last_online_label	= $lang_search["HorsLigne"];

							}
						$time_creation=date('Y-m-d', strtotime($result->creation_date));						
						$newdate= date('Y-m-d', strtotime("-30 days"));
						//echo strtotime($time_creation)."-".strtotime($newdate);
						//echo $time_creation."-".$newdate;
if(strtotime($time_creation) > strtotime($newdate)){   $connexion_date	= date('d/m/Y', strtotime($result->creation_date));  }
else{  $connexion_date	= $lang_search["connexion_date"];   } 
						
							if($i%2 == 1){ echo '';}
							
							?>
							<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						
						<div class="col-md-4 col-sm-3  col-xs-12  parentsolo_pt_10">
							<div class="hovereffect parentsolo_border_radius  ">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"  title="<?php echo $lang_search["VoirCeProfil"]; ?>">
								<img src="<?php echo $photo_liste; ?>" alt="<?php echo $result->username; ?>" class="profil"/>
								</a>
						
													</div>
						</div>
						<div class="col-md-8 col-sm-9  col-xs-12  parentsolo_pt_10 parentsolo_pb_10">
								<h4 class="letter_spacing_0  parentsolo_pb_10 parentsolo_font-size parentsolo_txt_overflow_title">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"  title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
						</h4>
						<div class="supplement members_cls line_height_25">
										<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
										<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
								</div>
						<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
						
						</div>
						<div class="supplement">
									<b><?php echo $lang_search["DateInscription"];?>:</b> <?php echo $connexion_date;/* date('d/m/Y', strtotime($result->creation_date)); */ ?>
								</div>
						<!--<div class="connect">
								<span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span>
						</div>-->
						</div>
						
						<div class="col-md-12 parentsolo_pt_10">
					
												
										
										<div class="description text-box">
											<?php echo $result->annonce; ?>
										</div>
						</div>
								</div>
					</div>
							
			<?php 							
							if($i%2 == 0){echo "<div class='clear'></div>"; }
							
							$i++;
						}
						
						if($i%2!=1){
							while($i%2!=1){
								echo '<div class="preview_liste_off"></div>';
								if($i%2 == 0){echo ""; }
								
								$i++;
							}
						}
						
					}else{
				?>
						<tr>
							<td align="middle">
								<?php echo $lang_search["VisitesAucunMembre"];?>!
							</td>
						</tr>
				<?php 					}
				?>
						
				</div></div>
				<table class="result search_previews" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td class="pub">
							<?JL::loadMod('pub'); ?>
						</td>
					</tr>
				</table>
			<?php 				
					if($nb_results>8){
						?>
						<div class="row">
				<div class="col-md-12">
			<?php 						for($j=8; $j<$nb_results; $j++) {
							$result = $results[$j];
							// limitation de la longueur de l'intro
							$result->annonce = strip_tags(html_entity_decode($result->annonce));
							if(strlen($result->annonce) > LISTE_INTRO_CHAR_text) {
								$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text).'...';
							}
							
							JL::makeSafe($result, 'annonce');
							
							// r&eacute;cup la photo de l'utilisateur
							$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

							if(!$photo_liste) {
								$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
							}
							
							if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

								$last_online_class 		= 'lo_online';
								$last_online_label		= $lang_search["EnLigne"];

							} else{ // aujourd'hui (60*60*24)

								$last_online_class 	= 'lo_offline';
								$last_online_label	= $lang_search["HorsLigne"];

							}
							
							$time_creation=date('Y-m-d', strtotime($result->creation_date));						
						$newdate= date('Y-m-d', strtotime("-30 days"));
						//echo strtotime($time_creation)."-".strtotime($newdate);
						//echo $time_creation."-".$newdate;
if(strtotime($time_creation) > strtotime($newdate)){   $connexion_date	= date('d/m/Y', strtotime($result->creation_date));  }
else{  $connexion_date	= $lang_search["connexion_date"];   } 

							if($i%2 == 1){ echo '';}
							
							?>
							<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						
						<div class="col-md-4 col-sm-3  col-xs-12  parentsolo_pt_10">
							<div class="hovereffect parentsolo_border_radius  ">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"]; ?>">
								<img src="<?php echo $photo_liste; ?>" alt="<?php echo $result->username; ?>" class="profil"/>
								</a>
						
													</div>
						</div>
						<div class="col-md-8 col-sm-9  col-xs-12  parentsolo_pt_10 parentsolo_pb_10">
								<h4 class="letter_spacing_0  parentsolo_pb_10 parentsolo_font-size parentsolo_txt_overflow_title">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
						</h4>
						<div class="supplement members_cls line_height_25">
									<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
									<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
								</div>
						<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
						</div>
						<div class="supplement">
									<b><?php echo $lang_search["DateInscription"];?>:</b> <?php echo $connexion_date;/* date('d/m/Y', strtotime($result->creation_date)); */ ?>
								</div><!--<div class="connect"><span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span></div>-->
						</div>
						
						<div class="col-md-12 parentsolo_pt_10">
					
												
										
										<div class="description text-box">
											<?php echo $result->annonce; ?>
										</div>
						</div>
								</div>
					</div>
							
							
							
							
							
						
			<?php 							
							if($i%2 == 0){echo "<div class='clear'></div>"; }
							
							$i++;
						}
						
						if($i%2!=1){
							while($i%2!=1){
								echo '<div class="preview_liste_off"></div>';
								if($i%2 == 0){echo ""; }
								
								$i++;
							}
						}
						
					?>
					
				</div></div>
	<?php 		}
		?>
		
		<div class="col-md-12 parentsolo_plr_0">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" cellpadding="0" cellspacing="0">
						<div class="col-md-3 text-left">
								<?php if($page_prev > 0) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page='.@$page_prev.(@$search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["PagePrecedente"];?>" class="bouton envoyer">&laquo; <?php echo @$lang_search["PagePrecedente"];?></a>
								<?php } ?>
							</div>
							<div class="col-md-6 text-center page_nav">
								<span style="font-weight:bold;"><?php echo $pageTotal==1 ? $lang_search["Page"] : $lang_search["Pages"];?> : </span>
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page=1'.(@$search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["Debut"];?>"><?php echo @$lang_search["Debut"];?></a> |<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page='.@$i.(@$search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["Page"];?> <?php echo $i; ?>" <?php if($i == @$page) { ?>class="active"<?php } ?>><?php echo @$i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $pageTotal) { ?> | <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page='.@$pageTotal.($search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["Fin"];?>"><?php echo @$lang_search["Fin"];?></a><?php }?>
							</div>
							<div class="col-md-3 text-right">
								<?php if($page_next > 0) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page='.@$page_next.(@$search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["PageSuivante"];?>" class="bouton envoyer"><?php echo @$lang_search["PageSuivante"];?> &raquo;</a>
								<?php } ?>
							</div>
					</div>
				</div>
			<div class="clear"></div>
		
	<?php 	}
	
	
	//Profile Matching
	
	public static function profile_matching(&$list, &$results, &$messages) {
		global $langue;
		include("lang/app_search.".$_GET['lang'].".php");
		global $action, $user;

		// variables
		$page 		= JL::getSessionInt('search_page', 1);
		$pageTotal 	= JL::getSessionInt('search_page_total', 1)== 0 ? 1 : JL::getSessionInt('search_page_total', 1);
		$rayon 		= 5;
		$debut		= ($page - $rayon) >= 1 ? $page - $rayon : 1;
		$fin		= ($page + $rayon) <= $pageTotal ? $page + $rayon : $pageTotal;

		$page_prev	= $page-1 >= 1 ? $page-1 : 0;
		$page_next	= $page+1 <= $pageTotal ? $page+1 : 0;

		
		

		// affichage des messages
		HTML_search::messages($messages);
		
	?><div class="parentsolo_txt_center">
         <h2 class="parentsolo_title barre "><?php echo $lang_search["SELECTEDPROFILES"]; ?></h2>
         <div class="wedd-seperator"><img src="images/bg_img/saprator.png" alt=""></div>
      </div>
		
		
			<div class="row">
				<div class="col-md-12">
				<?php 					$nb_results		= count($results);
			
					$i = 1;
				
					if(is_array($results) && $nb_results){
			
						$nb_fin = ($nb_results < 8) ? $nb_results : 8;

						for($j=0; $j<$nb_fin; $j++) {
							$result = $results[$j];
							// limitation de la longueur de l'intro
							$result->annonce = strip_tags(html_entity_decode($result->annonce));
							if(strlen($result->annonce) > LISTE_INTRO_CHAR_text) {
								$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text).'...';
							}
							
							JL::makeSafe($result, 'annonce');
							
							// r&eacute;cup la photo de l'utilisateur
							$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

							if(!$photo_liste) {
								$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
							}
							
							
							if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online && $result->on_off_status==1) { // 30 minutes (60*30)

								$last_online_class 		= 'lo_online';
								$last_online_label		= $lang_search["EnLigne"];

							} else{ // aujourd'hui (60*60*24)

								$last_online_class 	= 'lo_offline';
								$last_online_label	= $lang_search["HorsLigne"];

							}
						
							if($i%2 == 1){ echo '';}
							
							?>
							<div class="col-md-6 col-sm-12"><div class="col-md-12 col-sm-12  testimonials-style-2 parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
                    <div class="outer">
                        <div class="round">
                            <a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"  title="<?php echo $lang_search["VoirCeProfil"]; ?>">
                                <img width="100" height="100" src="<?php echo $photo_liste; ?>" class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<?php echo $photo_liste; ?>" sizes="(max-width: 70px) 100vw, 70px">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                    <h2 class="name parentsolo_pt_10"><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"  title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a></h2>
                    <div class="text-box testimonialbox parentsolo_pt_10 parentsolo_pb_10">
                        <div class="supplement members_cls line_height_25">
										<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
										<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
								</div>
								<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
								</div>
								<!--<div class="supplement">
									<b><?php echo $lang_search["DateInscription"];?>:</b> <?php echo date('d/m/Y', strtotime($result->creation_date)); ?>
								</div>-->
								<div class="supplement">
								<span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span>
								</div>
								<div class="description text-box">
											<?php echo $result->annonce; ?>
										</div>
						</div>
                    
                </div>
            </div>
        </div></div>
	
		
							
							
			<?php 							
							if($i%2 == 0){echo "<div class='clear'></div>"; }
							
							$i++;
						}
						
						if($i%2!=1){
							while($i%2!=1){
								echo '<div class="preview_liste_off"></div>';
								if($i%2 == 0){echo ""; }
								
								$i++;
							}
						}
						
					}else{
				?>
						<tr>
							<td align="middle">
								<?php echo $lang_search["VisitesAucunMembre"];?>!
							</td>
						</tr>
				<?php 					}
				?>
						
				</div></div>
				<table class="result search_previews" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td class="pub">
							<?JL::loadMod('pub'); ?>
						</td>
					</tr>
				</table>
			<?php 				
					if($nb_results>8){
						?>
						<div class="row">
				<div class="col-md-12">
			<?php 						for($j=8; $j<$nb_results; $j++) {
							$result = $results[$j];
							// limitation de la longueur de l'intro
							$result->annonce = strip_tags(html_entity_decode($result->annonce));
							if(strlen($result->annonce) > LISTE_INTRO_CHAR_text) {
								$result->annonce = substr($result->annonce, 0, LISTE_INTRO_CHAR_text).'...';
							}
							
							JL::makeSafe($result, 'annonce');
							
							// r&eacute;cup la photo de l'utilisateur
							$photo_liste = JL::userGetPhoto($result->id, 'profil', '', $result->photo_defaut);

							if(!$photo_liste) {
								$photo_liste = SITE_URL.'/parentsolo/images/parent-solo-profil-'.$result->genre.'-'.$_GET['lang'].'.jpg';
							}
							
							if($result->last_online_time < ONLINE_TIME_LIMIT+AFK_TIME_LIMIT && $result->online) { // 30 minutes (60*30)

								$last_online_class 		= 'lo_online';
								$last_online_label		= $lang_search["EnLigne"];

							} else{ // aujourd'hui (60*60*24)

								$last_online_class 	= 'lo_offline';
								$last_online_label	= $lang_search["HorsLigne"];

							}
							
							if($i%2 == 1){ echo '';}
							
							?>
							<div class="col-md-6 col-sm-12"><div class="col-md-12 col-sm-12  testimonials-style-2 parentsolo_pl-r">
            <div class="col-md-3 col-sm-4 col-sx-4 parentsolo_pl_0 Parentsolo_imgbg_color">
                <div class="box">
                    <div class="outer">
                        <div class="round">
                            <a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"  title="<?php echo $lang_search["VoirCeProfil"]; ?>">
                                <img width="100" height="100" src="<?php echo $photo_liste; ?>" class="attachment-70x70 size-70x70 wp-post-image" alt="26" srcset="<?php echo $photo_liste; ?>" sizes="(max-width: 70px) 100vw, 70px">
                            </a>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-sx-8">
                <div class="parentsolo_pt_15 parentsolo_pl_15 parentsolo_pb_15">
                    <h2 class="name parentsolo_pt_10"><a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>"   title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a></h2>
                    <div class="text-box testimonialbox parentsolo_pt_10 parentsolo_pb_10">
                        <div class="supplement members_cls line_height_25">
										<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
										<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
										<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
								</div>
								<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
								</div>
								<!--<div class="supplement">
									<b><?php echo $lang_search["DateInscription"];?>:</b> <?php echo date('d/m/Y', strtotime($result->creation_date)); ?>
								</div>-->
								<div class="supplement">
								<span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span>
								</div>
								<div class="description text-box">
											<?php echo $result->annonce; ?>
										</div>
						</div>
                    
                </div>
            </div>
        </div></div>
							<!--<div class="col-md-6 parentsolo_pt_15 parentsolo_pb_15">
									<div class="member_box">
						
						<div class="col-md-4 col-sm-3  col-xs-12  parentsolo_pt_10">
							<div class="hovereffect parentsolo_border_radius  ">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>" target="_blank" title="<?php echo $lang_search["VoirCeProfil"]; ?>">
								<img src="<?php echo $photo_liste; ?>" alt="<?php echo $result->username; ?>" class="profil"/>
								</a>
						
													</div>
						</div>
						<div class="col-md-8 col-sm-9  col-xs-12  parentsolo_pt_10 parentsolo_pb_10">
								<h4 class="letter_spacing_0  parentsolo_pb_10 parentsolo_font-size parentsolo_txt_overflow_title">
								<a href="<?php echo JL::url('index.php?app=profil&action=view&id='.$result->id.'&lang='.$_GET['lang']); ?>" target="_blank" title="<?php echo $lang_search["VoirCeProfil"];?>" class="username"><?php echo $result->username; ?></a>
						</h4>
						<div class="supplement members_cls line_height_25">
									<a href="<?php echo JL::url('index.php?app=message&action=write&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUnMail"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_message.png" alt="<?php echo $lang_search["EnvoyerUnMail"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=message&action=flower&user_to='.$result->username.'&'.$langue); ?>" title="<?php echo $lang_search["EnvoyerUneRose"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_rose.png" alt="<?php echo $lang_search["EnvoyerUneRose"];?>" /></a>
									<a href="javascript:windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&id='.$result->id.'&'.$langue); ?>','800px','600px');" title="<?php echo $lang_search["Chat"];?>"><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_chat.png" alt="<?php echo $lang_search["Chat"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=1&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterAuxFavoris"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_favoris.png" alt="<?php echo $lang_search["AjouterAuxFavoris"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=flbl&action=add&list_type=0&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["AjouterALaListeNoire"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_black.png" alt="<?php echo $lang_search["AjouterALaListeNoire"];?>" /></a>
									<a href="<?php echo JL::url('index.php?app=signaler_abus&user_id_to='.$result->id.'&'.$langue); ?>" title="<?php echo $lang_search["SignalerUnAbus"];?>" ><img src="<?php echo SITE_URL; ?>/<?php echo SITE_TEMPLATE; ?>/images/btn_abus.png" alt="<?php echo $lang_search["SignalerUnAbus"];?>" /></a>
								</div>
						<div class="infos"><?php echo JL::calcul_age($result->naissance_date); ?> - <?php echo $result->nb_enfants; ?> <?php echo $result->nb_enfants > 1 ? $lang_search["enfants"] : $lang_search["enfant"]; ?> - <?php echo $result->canton_abrev; ?>
						</div>
						<div class="supplement">
									<b><?php echo $lang_search["DateInscription"];?>:</b> <?php echo date('d/m/Y', strtotime($result->creation_date)); ?>
								</div><div class="connect"><span class="<?php echo $last_online_class; ?>"><?php echo $last_online_label; ?></span></div>
						</div>
						
						<div class="col-md-12 parentsolo_pt_10">
					
												
										
										<div class="description text-box">
											<?php echo $result->annonce; ?>
										</div>
						</div>
								</div>
					</div>
							-->
							
							
							
							
						
			<?php 			if($i%2 == 0){ echo "<div class='clear'></div>"; }
							
							$i++;
						}
						
						if($i%2!=1){
							while($i%2!=1){
								echo '<div class="preview_liste_off"></div>';
								if($i%2 == 0){echo ""; }
								
								$i++;
							}
						}
						
					?>
					
				</div></div>
	<?php 		}
		?>
		<!--<div class="col-md-12 parentsolo_plr_0">
					<div class="col-md-12 parentsolo_pagination parentsolo_plr_0" cellpadding="0" cellspacing="0">
						<div class="col-md-3 text-left">
								<?php if($page_prev > 0) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page='.@$page_prev.(@$search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["PagePrecedente"];?>" class="bouton envoyer">&laquo; <?php echo @$lang_search["PagePrecedente"];?></a>
								<?php } ?>
							</div>
							<div class="col-md-6 text-center page_nav">
								<span style="font-weight:bold;"><?php echo $pageTotal==1 ? $lang_search["Page"] : $lang_search["Pages"];?> : </span>
								<?php if($debut > 1) { ?> <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page=1'.(@$search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["Debut"];?>"><?php echo @$lang_search["Debut"];?></a> |<?php }?>
								<?php 									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page='.@$i.(@$search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["Page"];?> <?php echo $i; ?>" <?php if($i == @$page) { ?>class="active"<?php } ?>><?php echo @$i; ?></a>
									<?php 									}
								?>
								<?php if($fin < $pageTotal) { ?> | <a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page='.@$pageTotal.($search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["Fin"];?>"><?php echo @$lang_search["Fin"];?></a><?php }?>
							</div>
							<div class="col-md-3 text-right">
								<?php if($page_next > 0) { ?>
									<a href="<?php echo JL::url(SITE_URL.'/index.php?app=search&action='.@$action.'&search_page='.@$page_next.(@$search_online ? '&search_online=1' : '').'&'.@$langue); ?>" title="<?php echo @$lang_search["PageSuivante"];?>" class="bouton envoyer"><?php echo @$lang_search["PageSuivante"];?> &raquo;</a>
								<?php } ?>
							</div>
					</div>
				</div>-->
		
	<?php 	}
	//end Profile Matching
	
	
	/* affiche le formulaire d'un crit&egrave;re facultatif
		$field: nom du champ html
		$title: intitul&eacute; du crit&egrave;re
		$list: tableau d'objet{value, text}
	*/
	public static function searchFormCritereFacultatif($field, $title, &$lists) {
			global $langue;
			include("lang/app_search.".$_GET['lang'].".php");

		// variables
		$list		= $lists[$field];
		$tdParLigne = 6;	// nombre de crit&egrave;res facultatifs par ligne

		?>
			<table class="table_search2" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="<?php echo $tdParLigne; ?>" class="tdCritFac">
						<?php echo makeSafe($title); ?>
					</td>
				</tr>
				<?php 
					// d&eacute;termine les it&eacute;rations &agrave; effectuer
					$animauxCount	= count($list);
					$animauxCountx2	= count($list) * 2;
					$iterationMax	= $animauxCount + $animauxCountx2%($tdParLigne/2);
					$valuesArray	= JL::getSession($field, array(0));

					// g&eacute;n&egrave;re les cases
					for($i=0; $i<$iterationMax; $i++) {

						if(($i*2)%$tdParLigne == 0) {
						?>
						<tr>
						<?php 						}

						?>
							<td class="cb">
							<?php 							if($i < $animauxCount) {
							?>
								<input type="checkbox" name="<?php echo $field; ?>[]" id="<?php echo $field.$i; ?>" onClick="toggleCritFac('<?php echo $field; ?>', <?php echo $i; ?>);" value="<?php echo $list[$i]->value; ?>" <?php if(in_array($list[$i]->value, $valuesArray)) { ?>checked<?php } ?> />
							<?php 							}
							?>
							</td>
							<td class="label">
							<?php 							if($i < $animauxCount) {
							?>
								<label for="<?php echo $field.$i; ?>" id="lbl<?php echo $field.$i; ?>" class="labelOff"><?php echo makeSafe($list[$i]->text); ?></label>
							<?php 							}
							?>
							</td>
						<?php 
						if(($i*2+2)%$tdParLigne == 0) {
						?>
						</tr>
						<?php 						}

					}

				if(($i*2+2)%$tdParLigne != 0) {
				?>
				</tr>
				<?php 				}
				?>
			</table>
			<script language="javascript" type="text/javascript">
				toggleCritFac('<?php echo $field; ?>', <?php echo in_array(0, $valuesArray) ? 0 : 1; ?>);
			</script>
		<?php 	}


	

}
?>

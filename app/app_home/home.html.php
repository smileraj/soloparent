<?php 

	// MODEL
	defined('JL') or die('Error 401');
	
	class home_HTML {		
		
		public static function home(
			&$profils,
			&$list,
			&$temoignage,
			&$home_1,
			&$home_2,
			&$home_3,
			&$home_4,
			&$partenaire_1,
			&$actualites,
			&$box_menu_2,
			&$events,
			$auth = ''
		) {
		
			include("lang/app_home.".$_GET['lang'].".php");
			global $db, $template;
			
		?>
			<!--new start theme-->		
			<!--header new theme start style-->
			<style>.header_top_fixed
			{
				position: absolute;
				margin: 0 auto;
				width: 100%;
			}
			.logo_res_wth{    
			margin-top: 120px;
			}
			@media (min-width: 992px) and (max-width:1199px) {
			.logo_res_wth{    
			margin-top: 150px !important;
			text-align: center;
			}
			.min_width_year{
			    width: 125px  !important;
			}
			.min_width_month{
			width:70px !important;
			}
			.min_width_date{
			width:70px !important;
			}
			
			}
			@media (max-width:991px) {
			#header_adver{
			font-size:14px !important;
			}
			.logo_res_wth{    
			margin-top: 150px !important;
			text-align: center;
			}
			.custom.form-search label{
			
			}
			}
			@media (max-width:480px) {
			#header_adver{
			font-size:12px !important;
			}
			.logo_res_wth{    
			margin-top: 180px !important;
			text-align: center;
			}
			}
			</style>
				
            <section class="rd-parallax" style="border-top: 2px solid #bd282a !important;">
			<div class="container-fluid shell">
            <div class="col-md-12 res_padding_zero">
            <!--<div class="col-md-6"><div class="shell position-r logo_res_wth mobile_res_logo">
						<a href="<?php  echo SITE_URL; ?>/index.php?lang=<?php  echo $_GET['lang']; ?>" title="<?php // echo SITE_DESCRIPTION; ?>" class="logo" ><img src="<?php  echo $template;?>/images/logo_<?php  echo $_GET['lang']; ?>.png" alt="solocircl.com"  /></a>
					</div>
					</div>-->
            <div class="col-md-12 top_res_div_car res_padding_zero" >
					
			
            <div class="col-md-12 res_padding_zero">
					<div id="header_adver" class="owl-carousel owl-theme">
					<div class="item">
                         <div class="wd_family_member">
                         <div class="range offset-top-20 profiles position-r" style="text-align: center !important;"><div class="col-md-2  col-sm-3 hidden-xs font_clr parentsolo_center" style="text-align:right;"><img src="images/icons/icon1.png" style="border-radius:0px !important;" /></div><div class="col-md-10  col-sm-9 font_clr parentsolo_left">
							<div class="col-md-12  col-sm-12 font_clr parentsolo_center res_padding_zero"><p class="text-white letter-spacing offset-top-10 padding-bottom-10  text-left" style="color: #000;"><?php  echo $lang_apphome["unique"];?></p>
					</div></div></div>
                    </div>
					</div><div class="item">
                         <div class="wd_family_member">
                         <div class="range offset-top-20 profiles position-r" style="text-align: center !important;"><div class="col-md-2  col-sm-3 hidden-xs font_clr parentsolo_center" style="text-align:right;"><img src="images/icons/icon2.png" style="border-radius:0px !important;" /></div><div class="col-md-10  col-sm-9 font_clr parentsolo_left">
							<div class="col-md-12  col-sm-12 font_clr parentsolo_center res_padding_zero"><p class="text-white letter-spacing offset-top-10 padding-bottom-10  text-left" style="color: #000;"><?php  echo $lang_apphome["nouveau"];?></p>
					</div></div></div>
                    </div>
					</div>
					<div class="item">
                         <div class="wd_family_member">
							<div class="range offset-top-20 profiles position-r" style="text-align: center !important;">
							<div class="col-md-12  col-sm-12 font_clr parentsolo_center res_padding_zero"><div class="col-md-2  col-sm-3 hidden-xs font_clr parentsolo_center " style="text-align:right;"><img src="images/icons/icon3.png" style="border-radius:0px !important;"/></div><div class="col-md-10  col-sm-9 font_clr parentsolo_left">
								<p class="text-white letter-spacing offset-top-10 padding-bottom-10  text-left" style="color: #000;"><?php  echo $lang_apphome["acces"];?></p></div>
					</div>
					</div>
                   			</div>
					</div>
<div class="item">
                         <div class="wd_family_member">
							<div class="range offset-top-20 profiles position-r" style="text-align: center !important;">
							<div class="col-md-12  col-sm-12 font_clr parentsolo_center res_padding_zero"><div class="col-md-2  col-sm-3 hidden-xs font_clr parentsolo_center " style="text-align:right;"><img src="images/icons/icon4.png" style="border-radius:0px !important;"/></div><div class="col-md-10  col-sm-9 font_clr parentsolo_left">
								<p class="text-white letter-spacing offset-top-10 padding-bottom-10  text-left" style="color: #000;"><?php  echo $lang_apphome["concept"];?></p></div>
					</div>
					</div>
                    </div>
					</div>
					<div class="item">
                         <div class="wd_family_member">
							<div class="range offset-top-20 profiles position-r" style="text-align: center !important;">
							<div class="col-md-12  col-sm-12 font_clr parentsolo_center res_padding_zero"><div class="col-md-2  col-sm-3 hidden-xs font_clr parentsolo_center " style="text-align:right;"><img src="images/icons/icon5.png" style="border-radius:0px !important;"/></div><div class="col-md-10  col-sm-9 font_clr parentsolo_left">
								<p class="text-white letter-spacing offset-top-10 padding-bottom-10  text-left" style="color: #000;"><?php  echo $lang_apphome["matching_header"];?></p></div>
					</div>
					</div>
                    </div>
					</div>
					<div class="item">
                         <div class="wd_family_member">
							<div class="range offset-top-20 profiles position-r" style="text-align: center !important;">
							<div class="col-md-12  col-sm-12 font_clr parentsolo_center res_padding_zero"><div class="col-md-2  col-sm-3 hidden-xs font_clr parentsolo_center " style="text-align:right;"><img src="images/icons/icon6.png" style="border-radius:0px !important;"/></div><div class="col-md-10  col-sm-9 font_clr parentsolo_left">
								<p class="text-white letter-spacing offset-top-10 padding-bottom-10  text-left" style="color: #000;"><?php  echo $lang_apphome["events_header"];?></p></div>
					</div>
					</div>
                    </div>
					</div>
										 </div>
										 </div>
										 </div></div>
				</div>		
				<style>
				/* .homepage_headerstyle{
				 display:none; 
				margin-top:0px !important;
				} */
				.fixed{
				margin-top:0px !important;
				}
				.Logo_homepage{
				     margin-top:0px !important;  
				}
				
				</style>
               <div data-speed="0.4" data-type="media" data-url="parentsolo/images/home-01.jpg" class="rd-parallax-layer parallax_pstn" ></div>
			
               <div data-speed="0" data-type="html" class="rd-parallax-layer">
                  <div class="shell section-md-top-0 section-md-bottom-100 section-80 text-center text-l margin-top_res_div">
                   <!-- <a href="<?php  // echo SITE_URL; ?>/index.php?lang=<?php  //echo $_GET['lang']; ?>" title="<?php  //echo SITE_DESCRIPTION; ?>" class="logo" ><img src="<?php  // echo $template;?>/images/logo_<?php  // echo $_GET['lang']; ?>.jpg" alt="solocircl.com"  /></a>-->
                     <div class="range offset-lg-top-0 offset-top-0 offset-sm-top-0">
                        <div class="col-md-6 col-lg-4 col-sm-12 col-xs-12  text-center text-md-left">
			  	
				<!-- Join its free Section Start -->
				    <div class="form-wrapper joinform" >
						<div class="form-header">
						<!--<h4 class="white-text">Create an Account</h4>
					<p class="reg-form-details">
						Registering for this site is easy, just fill in the fields below and we will get a new account set up for you in no time.
					</p>-->
						<?php  echo $lang_apphome["Inscription"];?>
						<?php  echo $lang_apphome["free"];?>
				</div>
					<!--<h3><?php  echo $lang_apphome["InscriptionGratuite"];?></h3> -->
					    <form action="<?php  echo JL::url('index.php?app=profil&action=inscription').'&lang='.$_GET['lang'];?>" name="inscriptionMini" method="post" class="custom form-search parentsolo_hide_plr">
						<input type="hidden" name="site_url" id="site_url" value="<?php  echo SITE_URL; ?>" />
						<input type="hidden" name="inscriptionrapide" value="1" />
						<input type="hidden" name="lang_id" id="lang_id" value="<?php  echo $_GET["lang"];?>" />
						
						<!--- Join form Starts-->
						
						<div class="row bottompadding ">
							<div class="col-md-4 parentsolo_hide_plr">
								<label class="right inline line_height_35" for="genre" ><?php  echo $lang_apphome["JeSuis"];?></label>
							</div>
							<div class="col-md-8 parentsolo_hide_plr">
							<div class="block select_box_sli back_clr">
    			<div id="radios1">
    				<input id="option6" name="genre"  type="radio" value="f" >
    				<label for="option6" class="inscription_icon1"><span><i class="fa fa-male"></i>&nbsp;<?php  echo $lang_apphome["gendre_lan_m"];?></span></label>

    				<input id="option7" name="genre" type="radio" value="h" checked>
    				<label for="option7" class="inscription_icon"><span <?php  if($_GET['lang']=="fr"){ ?>class="fr_label" style="margin-left: -65px !important;"  <?php  } ?> ><?php  echo $lang_apphome["gendre_lan_f"];?><i class="fa fa-female"></i></span></label>

    			</div>
    		</div>
								<?php  // echo $list['genre']; ?>
							</div>
						</div>
											
						<div class="row bottompadding">
							<div class="col-md-4 parentsolo_hide_plr">
								  <label class="right inline line_height_35" for="date_naissance" style=""><?php  echo $lang_apphome["NeeLe"];?></label>
							</div>
							<div class="col-md-8 parentsolo_hide_plr">								
							<div class="col-md-3 col-sm-3 padding_left_0 padding_right_5 col-sm-width parentsolo_hide_plr min_width_date"><?php  echo $list['naissance_jour']; ?></div>
							<div class="col-md-4 col-sm-4 padding_left_0 padding_right_5 col-sm-width parentsolo_hide_plr min_width_month"><?php  echo $list['naissance_mois']; ?></div>
							<div class="col-md-5 col-sm-5  padding_left_0 padding_right_0 col-sm-width parentsolo_hide_plr padding-rgt-0 min_width_year"><?php  echo $list['naissance_annee']; ?></div>	
								 <?php  // echo $list['naissance_jour'].$list['naissance_mois'].$list['naissance_annee']; ?>
							</div>
							
						</div>
						
						<div class="row bottompadding">
							<div class="col-md-4 parentsolo_hide_plr">
								<label class="right inline " for="canton" style="line-height:22px; margin-bottom:0px;"><?php  echo $lang_apphome["JhabiteDansLeCantonDe"];?></label>
							</div>
							<div class="col-md-8 parentsolo_hide_plr">
								<?php  echo $list['canton_id']; ?>  
							</div>
							
						</div>
						
						<div class="row bottompadding">
							<div class="col-md-4 parentsolo_hide_plr">
							  <label class="right inline line_height_35" for="ville" ><?php  echo $lang_apphome["A(Ville)"];?></label>
							</div>
							<div class="col-md-8 parentsolo_hide_plr">
								<span id="villes"><?php  echo $list['ville_id']; ?></span>
							</div>							
						</div>
						
						<div class="row bottompadding">
							<div class="col-md-4 parentsolo_hide_plr">
							 <label class="right inline line_height_35" for="enfant" ><?php  echo $lang_apphome["Jai"];?></label>
							</div>
							<div class="col-md-8 parentsolo_hide_plr">
							<div class="block select_box_sli">
    			<div id="radios" class="btm">
    				<input id="option1" name="nb_enfants" type="radio" checked value="1">
    				<label for="option1">1</label>

    				<input id="option2" name="nb_enfants" type="radio" value="2">
    				<label for="option2">2</label>

    				<input id="option3" name="nb_enfants" type="radio"  value="3">
    				<label for="option3">3</label>
<input id="option4" name="nb_enfants" type="radio"  value="4">
    				<label for="option4">4</label>
    				<input id="option5" name="nb_enfants" type="radio" value="5">
    				<label for="option5">+&nbsp;<?php  echo $lang_apphome["than"];?>&nbsp;5</label>


    			</div>
    		</div>
								 <?php  // echo $list['nb_enfants']; ?>
								 <label class="right inline enfant" for="enfant"><?php  echo $lang_apphome["Enfant(s)"];?></label>
							</div>							
						</div>
						<div class="row bottompadding text-center"><div class="col-md-12">
						<input type="submit" class="freesignup" value="<?php  echo $lang_apphome["JeMinscris"];?>" />
					</div></div>
					</form>
					
					
				</div>
				<!-- Join its free Section end -->
				
				<script type="text/javascript">
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
				</script>
                        </div>
                        <div class="cell-md-6" >
						</div>
						<!--<div class="cell-md-6" style="">
						&nbsp;
						</div>
                        <div class="cell-md-6 cell-md-preffix-1 text-md-left"><a href="#" class="link offset-top-77">Join us<span class="fl-budicons-launch-right164"></span></a></div>-->
					   <!--<div class="cell-md-6 nopadding text-md-left security_res_cls">
					
					<div class="col-md-2 nopadding" align="center"><img style="margin:0px;" src="<?php  echo $template;?>/images/home/Cadena.png" /></div>
					<div class="col-md-7 nopadding"><?php  echo $lang_apphome["DescriptionCallCenter"];?></div>	
					</div>-->
				
                     </div>
                  </div>
               </div>
            </section>
		
			<section class="section-bottom-50 section-top-80 section-md-top-0 backrgound">
				<div class="shell">
				<div class="img-baner"><!--<img src="parentsolo/images/home-02.png" alt="">--></div>
				<div class="row row-no-gutter position-r ">
				<div class="col-sm-6 col-md-6">
				<div class="block-3 con section-lg-top-77 inset-md-left-15">
				
				<div class="col-md-12">
				<div class="baner text-left">
				<h1 class="position-r whyparentsolo font_size_sm"><?php  echo $lang_apphome["PourquoiChoisirParentsolo"];?>?</h1>
				<div class="text-italic whysolo">
					<ul class="font_icons">
					<li><i class="fa fa-check-square-o"></i> <?php  echo $lang_apphome["ReserveAuxParentsCelibataires"];?></li>
					<li><i class="fa fa-check-square-o"></i> <?php  echo $lang_apphome["QualiteDesProfilsResidantEnSuisse"];?></li>
					<li><i class="fa fa-check-square-o"></i> <?php  echo $lang_apphome["ProtectionDesDonnees"];?></li>
					<li><i class="fa fa-check-square-o"></i> <?php  echo $lang_apphome["Matching_home"];?></li>
					<li><i class="fa fa-check-square-o"></i> <?php  echo $lang_apphome["Evenements_home"];?></li>
					</ul>
				</div>	
				<div class="col-md-12 mamas">
				
				<div class="col-md-12">
				<div class="col-md-6"><h4 class="parentsolo_title_h3"  style="color:#bf181a !important;"><?php  echo $lang_apphome["Mamans"];?></h4></div>
				<div class="col-md-6"><h4 class="parentsolo_title_h3 " style="color:#bf181a !important;"><?php  echo $lang_apphome["Papas"];?></h4></div>
				</div>
					
				</div>
				</div>
				</div>
				<!--<a href="#" class="link offset-sm-top-77 preffix-xs-left-60 offset-top-50">read more stories<span class="fl-budicons-launch-right164"></span></a>-->
				</div>
				</div>
				<div class="col-sm-6 col-md-4 about aboutimages">
				<div class="block-1 img-cont"><img src="parentsolo/images/home-03.jpg" alt=""></div>
				</div>
				<div class="col-xs-6 col-sm-3 col-md-2  dn aboutimages">
				<div class="block-0 emp"></div>
				</div>
				<div class="col-xs-6 col-sm-3 col-md-2 aboutimages">
				<div class="block-0 img-cont"><img src="parentsolo/images/home-04.jpg" alt=""></div>
				</div>
				<div class="col-xs-6 col-sm-3 col-md-2 aboutimages">
				<div class="block-0 img-cont"><img src="parentsolo/images/home-05.jpg" alt=""></div>
				</div>
				<div class="col-xs-6 col-sm-3 col-md-2 aboutimages">
				<div class="block-0 img-cont"><img src="parentsolo/images/home-06.jpg" alt=""></div>
				</div>
				<div class="col-xs-6 col-sm-3 col-md-2 aboutimages">
				<div class="block-0 img-cont"><img src="parentsolo/images/home-07.jpg" alt=""></div>
				</div>
				<!--<div class="col-xs-6 col-sm-3 col-md-4 dn aboutimages">
				<div class="block-0 emp"></div>
				</div> -->
				<div class="col-xs-6 col-sm-3 col-md-2 aboutimages">
				<div class="block-0 img-cont"><img src="parentsolo/images/home-08.jpg" alt=""></div>
				</div>
				<div class="col-xs-6 col-sm-3 col-md-2 aboutimages">
				<div class="block-0 img-cont"><img src="parentsolo/images/home-09.jpg" alt=""></div>
				</div>
				<div class="col-xs-6 col-sm-3 col-md-2 aboutimages">
				<div class="block-0 img-cont"><img src="parentsolo/images/home-10.jpg" alt=""></div>
				</div>
			
				</div>
				</div>
				</section>
							
				<!-- Adding New members section -->
				
				<section class="skew-2 section-md-top-0 section-md-bottom-290 section-top-60 section-lg-bottom-315">
				<div class="text-left position-r">
				<h1 class="text-white text-center headerskin parentsolo_title_font parentsolo_mb_40" style="padding-bottom:20px; font-size:32px;"><?php  echo $lang_apphome["NewMembers"];?></h1>
				<!--<ul class="list-index range offset-top-93">
				<li class="cell-md-3 cell-sm-6"><span class="list-index-counter"></span>
				<h5>Join and<br>find your love</h5>
				</li>
				<li class="cell-md-3 cell-sm-6 offset-top-77 offset-sm-top-0"><span class="list-index-counter"></span>
				<h5>add information about yourself</h5>
				</li>
				<li class="cell-md-3 cell-sm-6 offset-top-77 offset-md-top-0"><span class="list-index-counter"></span>
				<h5>Analyze the list of people</h5>
				</li>
				<li class="cell-md-3 cell-sm-6 offset-top-77 offset-md-top-0"><span class="list-index-counter"></span>
				<h5>get in touch and be happy</h5>
				</li>
				</ul>-->
				
				
				
				
			<div class="membercontainer demo-3">
			<?php 
			$i=0;
			$profils_home = array();
			foreach($profils as $profil){
				JL::makeSafe($profil);
				if($i != 30){
					if(is_file('images/profil/'.$profil->id.'/parent-solo-109-profil-'.$profil->photo_defaut.'.jpg')){
						$i++;
						$profils_home[] = $profil;
					}
				}
			}
		?>
			
			<!--Photo dÃ©filante des membres-->
			<!-- Profile Members section Starts -->
			<!-- Elastislide Carousel -->
			
				<!-- Elastislide Carousel -->
				 <div id="owl_man_family" class="owl-carousel owl-theme">
                                   <?php 
						foreach($profils_home as $profil){
						?><div class="item">
                         <div class="wd_family_member">
                          <?php 							JL::makeSafe($profil);
							if(is_file('images/profil/'.$profil->id.'/parent-solo-109-profil-'.$profil->photo_defaut.'.jpg')){
							?>
							<!-- <img class="img-responsive" src="images/family_members/03.jpg" alt="" style="width:200px;" />-->
                                          <a title="<?php  echo $profil->username; ?>" href="<?php  echo JL::url('index.php?app=profil&action=view&id='.$profil->id.'&lang='.$_GET['lang']);?>">
									<!--<a title="<?php  // echo $profil->username; ?>" href="#">-->
									<div class="cache"></div>
									<img class="img-responsive" src="<?php  echo SITE_URL; ?>/images/profil/<?php  echo $profil->id;?>/parent-solo-220-profil-<?php  echo $profil->photo_defaut; ?>.jpg" alt="<?php  echo $profil->username; ?>" onclick="" />
								    </a>
                                       
										<?php 
							}?> </div></div><?php 						}
					?>
                                    
				 </div>
				
				<!-- Profile Members section ends -->
			
					
</div>
</section>
			
<section class="skew-1-1 section-lg-bottom-187 position-r-1 section-top-80 section-md-top-0 section-bottom-90">
<div class="img-baner-var-1"><img src="parentsolo/images/home-11.png" alt="" class="position-r"></div>
<div class="shell offset-md-top--80">
<div class="range profiles">
<div class="cell-lg-9 cell-lg-preffix-3 position-r">

<div class="range offset-top-16 tab_div_stl">
	<!--
	<div class="col-lg-4 col-md-4 col-sm-6 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-xs-offset-2 col-xs-8 wd_card">
                            <div class="wd_event_section text-center">
                             
                                <div class="wd_item wd_square effect9 bottom_to_top">
                                    <a href="#">
                                        <div class="img"> <a href="<?php  echo $home_1->url; ?>" title="<?php  echo $home_1->titre;?>" >
					   <img  src="<?php  echo $template; ?>/images/box/<?php  echo $home_1->id; ?>-<?php  echo $_GET['lang']; ?>.jpg" title="<?php  echo $home_1->titre;?>"/>
					   </a>
                                        </div>
                                        <div class="wd_event_info">
                                            <div class="wd_event_info_back">
                                              
                                                <div class="info_box">
                                                     <?php  echo $home_1->texte; ?></div>
                                                </div>                                               
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                       
                        <div class="col-lg-4 col-md-4 col-sm-6 col-lg-offset-0 col-md-offset-0 col-sm-offset-0 col-xs-offset-2 col-xs-8 wd_card">
                            <div class="wd_event_section text-center">
                              
                                <div class="wd_item wd_square effect9 bottom_to_top">
                                    <a href="#">
                                        <div class="img">
											<a href="<?php  echo $home_1->url; ?>" title="<?php  echo $home_1->titre;?>" >
											<img  src="<?php  echo $template; ?>/images/box/<?php  echo $home_1->id; ?>-<?php  echo $_GET['lang']; ?>.jpg" title="<?php  echo $home_1->titre;?>"/>
											</a>
                                        </div>
                                        <div class="wd_event_info">
                                            <div class="wd_event_info_back">
                                              
                                                <div class="info_box">
                                                     <?php  echo $home_1->texte; ?>
                                                </div>                                     
                                               </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>-->
						<div class="col-lg-4 col-md-4 col-sm-6 col-lg-offset-0 col-md-offset-0 col-sm-offset-3 col-xs-offset-2 col-xs-8 wd_card">
                            <div class="ih-item square effect15 bottom_to_top"><div class="hover_stl">
							<a href="#">
                                        <div class="img">
											<a href="<?php  echo $home_1->url; ?>" title="<?php  echo $home_1->titre;?>" ><img style="width:100%"  src="<?php  echo $template; ?>/images/box/<?php  echo $home_1->id; ?>-<?php  echo $_GET['lang']; ?>.jpg" title="<?php  echo $home_1->titre;?>"/>
											</a>
                                        </div>
                                        <div class="info"><div class="para_val">
                                                       <?php  echo $home_1->texte; ?>
                                                </div>
											</div>
                                        
                                    </a>
                                
                        </div>
						
</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-6 col-lg-offset-0 col-md-offset-0 col-sm-offset-3 col-xs-offset-2 col-xs-8 wd_card">
                            <div class="ih-item square effect15 bottom_to_top"><div class="hover_stl">
							<a href="#">
                                        <div class="img">
											<a href="<?php  echo $home_3->url; ?>" title="<?php  echo $home_3->titre;?>" ><img style="width:100%"  src="<?php  echo $template; ?>/images/box/<?php  echo $home_3->id; ?>-<?php  echo $_GET['lang']; ?>.jpg" title="<?php  echo $home_3->titre;?>"/>
											</a>
                                        </div>
                                        <div class="info"><div class="para_val">
                                                       <?php  echo $home_3->texte; ?>
                                                </div>
											</div>
                                        
                                    </a>
                                
                        </div>
						
</div>
</div>

                        <div class="col-lg-4 col-md-4 col-sm-6 col-lg-offset-0 col-md-offset-0 col-sm-offset-3 col-xs-offset-2 col-xs-8 wd_card">
                            <div class="ih-item square effect15 bottom_to_top"><div class="hover_stl">
							<a href="#">
                                        <div class="img">
											<a href="<?php  echo $home_4->url; ?>" title="<?php  echo $home_4->titre;?>" ><img style="width:100%"  src="<?php  echo $template; ?>/images/box/<?php  echo $home_4->id; ?>-<?php  echo $_GET['lang']; ?>.jpg" title="<?php  echo $home_4->titre;?>"/>
											</a>
                                        </div>
                                        <div class="info"><div class="para_val">
                                                       <?php  echo $home_4->texte; ?>
                                                </div>
											</div>
                                        
                                    </a>
                                
                        </div>
						
</div>
</div>

</div>
</section><section class="skew-3 section-md-top-10 section-md-bottom-290 section-top-80 section-bottom-77">


				<div class="shell text-left position-r">
				<ul class="range res_width offset-top-37">

<li class="cell-md-6 cell-sm-12 col-xs-12 res_li_cls1" >

					<h2 class="text-white  text-center headerskin parentsolo_title_font" ><?php  echo $lang_apphome["Events_lan"];?></h2>
				<?php  /* foreach($events as $contenu){
				?>
				<div class="range offset-top-20 profiles position-r" style="text-align: center;">
					<div class="cell-md-2  cell-sm-12"><img class="image_bg_sty" src="images/events/<?php  echo $contenu->filename; ?>" alt="<?php  echo $contenu->username; ?>" />
				</div>
				<div class="cell-md-12  cell-sm-12 font_clr"><h4 class="text-white letter-spacing offset-top-10 padding-bottom-10"><?php  echo $contenu->event_name; ?></h4>
					<p style="font-size:15px;" class="height_p"><?php  echo $contenu->event_desc; ?><br>
					</p>
					<span class="username text-right" ><h6 class="offset-top-10"><?php  //echo $events->username; ?> &nbsp;</h6></span>
						<a href="<?php  echo JL::url('index.php?app=event&lang='.$_GET['lang']); ?>"  title="<?php  echo $lang_apphome["readmore"];?>" class="link offset-top-16 testi_link_stl"><?php  echo $lang_apphome["readmore"];?><span class="fl-budicons-launch-right164"></span></a>
					</div>
					</div>
					<?php 
					}
					*/ ?>
 <div id="testi" class="owl-carousel owl-theme" style="width:100% !important;">
<?php  foreach($events as $contenu){
				?>            <div class="item">
                         <div class="wd_family_member">
                         <div class="range offset-top-20 profiles position-r" style="text-align: center;">
					<div class="cell-md-3  cell-sm-4"><img class="image_bg_sty" style="height:90px !important; width:90px  !important;" src="images/events/<?php  echo $contenu->filename; ?>" alt="<?php  echo $contenu->username; ?>" />
				</div>
				<div class="cell-md-9  cell-sm-8 font_clr" style="overflow:hidden"><h4 class="text-white letter-spacing offset-top-10 padding-bottom-10"><?php  echo $contenu->event_name; ?></h4>
					<p style="font-size:15px;" class="height_p overflow_res"><?php  echo $contenu->event_desc; ?><br>
					</p>
					<span class="username text-right" ><h6 class="offset-top-10"><?php  //echo $events->username; ?> &nbsp;</h6></span>
						<a href="<?php  echo JL::url('index.php?app=event&lang='.$_GET['lang']); ?>"  title="<?php  echo $lang_apphome["readmore"];?>" class="link offset-top-16 testi_link_stl"><?php  echo $lang_apphome["readmore"];?><span class="fl-budicons-launch-right164"></span></a>
					</div>
					</div>
                                       
										 </div></div>
								<?php 
					}
					?>			 
                                    
				 </div>
</li>
<li class="cell-md-6 cell-sm-12  col-xs-12 res_li_cls">
<h2 class="text-white text-center headerskin  parentsolo_title_font" >
					<?php  echo $lang_apphome["testimonial"];?></h2>
					<?php 
								// limitation de la longueur du titre
								if(strlen($temoignage->titre) > TITRE_HOME) {
									$temoignage->titre = substr($temoignage->titre, 0, TITRE_HOME).'...';
								}
								
								// limitation de la longueur de l'intro
								$temoignage->texte = strip_tags(html_entity_decode($temoignage->texte));
								if(strlen($temoignage->texte) > INTRO_HOME) {
									$temoignage->texte = substr($temoignage->texte, 0, 280).'...';
								}
								
								// &agrave; placer toujours apr&egrave;s les 2 limitations
								JL::makeSafe($temoignage, 'texte');
								
								// rÃ©cup la photo de l'utilisateur
								$photo = JL::userGetPhoto($temoignage->user_id, '220', 'profil', $temoignage->photo_defaut);

								// photo par d&eacute;faut
								if(!$photo) {
									$photo = SITE_URL.'/parentsolo/images/parent-solo-220-'.$temoignage->genre.'-'.$_GET['lang'].'.jpg';
								}
					?>
				<div class="range offset-top-20 profiles position-r" style="text-align: center;">
					<div class="cell-md-3  cell-sm-4"><img class="image_bg_sty" style="height:90px !important; width:90px  !important;"  src="<?php  echo $photo; ?>" alt="<?php  echo $temoignage->username; ?>" />
				</div>
				<div class="cell-md-9  cell-sm-8 font_clr"><h4 class="text-white letter-spacing offset-top-10 padding-bottom-10"><?php  echo $temoignage->titre; ?></h4>
					<p  style="font-size:15px;" class="height_p"><?php  echo $temoignage->texte; ?>
					<span class="username text_left" ><h6 class="offset-top-10"><?php  echo $temoignage->username; ?></h6></span>
					</p>
					
					<a href="<?php  echo JL::url('index.php?app=temoignage&lang='.$_GET['lang']); ?>"  title="<?php  echo $lang_apphome["readmore"];?>" class="link offset-top-16 testi_link_stl"><?php  echo $lang_apphome["readmore"];?><span class="fl-budicons-launch-right164"></span></a>
					</div>
					</div>
</li>
</ul>
			
			
				
				
				</div>
				
			
				
				
			</section>				
<section class="skew-1-1 section-lg-bottom-130 position-r-1 section-top-80 section-md-top-0 section-bottom-90 anydevice_res">
<div class="img-baner-var-2"><img src="parentsolo/images/parentsolo_responsive.png" alt="" class="position-r"></div>
<div class="shell offset-md-top--80">
<div class="range profiles">
<div class="cell-lg-7 position-l">

<div class="range tab_div_stl">
	
	
                        <div class="col-lg-10 col-md-10 col-sm-10 col-lg-offset-0 col-md-offset-0 col-sm-offset-1 col-xs-offset-0 col-xs-12 wd_card  ">
						<h1 class="position-r restitle font_size_sm"><?php   echo $lang_apphome["ANY_DEVICE"]; ?></h1>
<?php   echo $lang_apphome["ANY_DEVICE_para"];?>
                        </div>
</div>
</div>
</div>

</div>
</section>
				

			<!-- End new members section -->
			
			<!--header new theme end style-->
			<!--new end theme-->	
			<!-- Partie Droite -->		
				
			<!--<div class="btn" id="defileNext"></div>-->
				
			<!--  Commenting old slider -->
			<!-- <div class="inscription">
				<div class="pastille_offre_speciale">
					<!--<img src="<?php  // echo $template;?>/images/home/offre_speciale_papa_<?php  echo $_GET['lang'];?>.png" />-->
				<!-- </div> -->
                 <?php /*
				<div class="site_annee">
					<img src="<?php  echo $template;?>/images/home/site_annee-<?php  echo $_GET['lang'];?>.png" />
				</div>   */ ?>				
			<!--</div> -->
			<div class="content1">
				<div class="contentl">
					
					
					<div class="colc">
						<div class="blocs blocs_home">
							<!--  Why choosing Parentsolo? Section -->
							<!--<div class="bloc bloc_left">
								<h3><?php  // echo $lang_apphome["PourquoiChoisirParentsolo"];?>?</h3>
								<table width="100%">
									<tr>
										<td><img src="<?php  // echo $template;?>/images/home/drapeau_carte.png" /></td>
										<td>
											<ul>
												<li><?php  // echo $lang_apphome["ReserveAuxParentsCelibataires"];?></li>
												<li><?php  // echo $lang_apphome["QualiteDesProfilsResidantEnSuisse"];?></li>
												<li><?php  // echo $lang_apphome["ProtectionDesDonnees"];?></li>
											</ul>
										</td>
									</tr>
								</table>
							</div>-->
					
							<!--  TÃ©moignage Section -->
							<!--<div class="bloc bloc_right">
								<h3>T&eacute;moignage</h3>
								<table width="100%">
									<tr>
										<td valign="top"><img src="<?php  echo $photo; ?>" alt="<?php  echo $temoignage->username; ?>" /></td>
										<td>
											<div class="titre"><?php  echo $temoignage->titre; ?></div>
											<?php  echo $temoignage->texte; ?><br />
											<span class="username"><?php  echo $temoignage->username; ?></span><br />
											<a href="<?php  echo JL::url('index.php?app=temoignage&lang='.$_GET['lang']); ?>" title="<?php  echo $lang_apptemoignage["LireLeTemoignage"]; ?>" class="lire">Tous les t&eacute;moignages</a>
										</td>
									</tr>
								</table>
							</div>
							<div style="clear:both"> </div>
						</div>
						-->
						
					
					<!--<?php 
						if($_GET['lang']=="fr"){
					?>
						<div class="inscription_gratuite_home">
							<div id="inscription_gratuite_home">
								<script type="text/javascript">
									swfobject.embedSWF("<?php  echo $template.'/images/home/inscription_gratuite_home.swf'; ?>", "inscription_gratuite_home", "650", "426", "8", "", { "width": "650", "height": "426" }, {"wmode":"transparent"}, {"id" : "inscription_gratuite_home"});
								</script>
							</div>
						</div>
					<?php 
						}elseif($_GET['lang']=="de"){
					?>
						<div class="video">
							<div id="video">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/FKopJSUGx4k" frameborder="0" allowfullscreen></iframe> 
								--><!--<script type="text/javascript">
									swfobject.embedSWF("<?php  echo SITE_URL.'/presse/videos/Werbung_SinglEltern.swf'; ?>", "video", "650", "426", "8", "", { "width": "650", "height": "426", "urlVideo" : "<?php  echo SITE_URL.'/presse/videos/Werbung_SinglEltern.flv'; ?>" }, {"wmode":"transparent", "loop":"true", "bgcolor":"#000000"}, {"id" : "video"});
								</script>  -->
							<!--</div>
						</div>
					<?php 
						}else{
					?>
						<div class="inscription_gratuite_home">
							<div id="inscription_gratuite_home">
								<script type="text/javascript">
									swfobject.embedSWF("<?php  echo $template.'/images/home/inscription_gratuite_home_en.swf'; ?>", "inscription_gratuite_home", "650", "426", "8", "", { "width": "650", "height": "426" }, {"wmode":"transparent"}, {"id" : "inscription_gratuite_home"});
								</script>
							</div>
						</div>
					<?php 
						}
					?>
					</div>
				</div>-->

				<!-- Partie Droite - Rught Banner in home page-->
				<!--<div class="colr"> 

					<div id="banner_gold">
						<div class="small"><?php  echo $lang_apphome["Publicite"];?></div>     
						
                        <?php                         if($_GET['lang']=="fr"){
                        ?>
                    
                        <div id="div-ad-gds-464-2">
                        <script type="text/javascript">
                        document.write('<scr' + 'ipt type="text/javascript">gbcallslot464("div-ad-gds-464-2", "CLICK_URL_UNESC")</scr' + 'ipt>');
                        </script>
                        </div>
                       <?php                        }

                        if($_GET['lang']=="de"){
                        ?>
                            --><!-- 160x600, 300x600 -->
                            <!--<div id="div-ad-gds-522-2">
                            <script type="text/javascript">
                            gbcallslot522("div-ad-gds-522-2", "");
                            </script>
                            </div>
                       <?php                        }

                       if($_GET['lang']=="en"){
                       ?>-->
                            <!-- 160x600, 300x600 -->
                           <!-- <div id="div-ad-gds-526-2">
                            <script type="text/javascript">
                            gbcallslot526("div-ad-gds-526-2", "");
                            </script>
                            </div>
                       <?php                        }
                       ?>  
                          
					</div>
                    -->
                    <?php /*
                    <div id="banner_medium_rectangle">
                        <div class="small"><?php  echo $lang_apphome["Publicite"];?></div>
                        <div id='content'>
                            <script type='text/javascript'>
                                if(setgbasync){googletag.cmd.push(function() { googletag.display('content'); });}else{googletag.display('content');}
                            </script> 
                        </div>
                    </div>*/ ?>

                <!--</div>-->
					

				<div style="clear:both"> </div>     
			</div>
    
	
					 <!-- ===== Start of Live Chat ===== -->
    <div class="live-chat collapsed Login_right1 parentsolo_login_width-back" >

        <!-- start of live chat header -->
        <div class="header">
            <a href="#" onclick="return(false);" class="chat-close"><i class="fa fa-times"></i></a>
            	<p class="p11"  style="font-size:16px"><?php  echo $lang_apphome["Join_lan"];?><span style="font-size:18px"> <?php  echo $lang_apphome["free_lan"];?></span></p>
            
        </div>
        <!-- end of live chat header -->

        <!-- start of chat -->
        <div class="chat">
            <!-- start of chat history -->
            <div class="chat-history">
               <!-- Join its free Section Start -->
				    <div class="form-wrapper Login_right parentsolo_mb_0" >
						
					<!--<h3><?php  echo $lang_apphome["free_lan"];?></h3>-->
					    <form action="<?php  echo JL::url('index.php?app=profil&action=inscription').'&lang='.$_GET['lang'];?>" name="inscriptionMini" 
						method="post" class="custom">
						<input type="hidden" name="site_url" id="site_url" value="<?php  echo SITE_URL; ?>" />
						<input type="hidden" name="inscriptionrapide" value="1" />
						<input type="hidden" name="lang_id" id="lang_id" value="<?php  echo $_GET["lang"];?>" />
						
						<!--- Join form Starts-->
						
						<div class="row bottompadding">
							<div class="block select_box_sli back_clr">
							<div id="radios1">
							<div class="col-md-12 parentsolo_plr_0"><?php  echo $lang_apphome["JeSuis"];?>
								<?php  echo $list['genre']; ?>
							</div>

							</div>
						</div>
						</div>
											
						<div class="row bottompadding">
							<?php  echo $lang_apphome["NeeLe"];?>
							<div class="col-md-12 parentsolo_plr_0">								
							<div class="col-md-3  col-sm-3 parentsolo_plr_0 padding_left_0 padding_right_5 col-sm-width"><?php  echo $list['naissance_jour']; ?></div>
							<div class="col-md-3 col-sm-3 parentsolo_plr_0 padding_left_0 padding_right_5 col-sm-width"><?php  echo $list['naissance_mois']; ?></div>
							<div class="col-md-6 col-sm-6  parentsolo_plr_0 padding_left_0 padding_right_0 col-sm-width"><?php  echo $list['naissance_annee']; ?></div>	
								 <?php  // echo $list['naissance_jour'].$list['naissance_mois'].$list['naissance_annee']; ?>
							</div>
							
						</div>
						
						<div class="row bottompadding">
							
							<div class="col-md-12 parentsolo_plr_0"><?php  echo $lang_apphome["JhabiteDansLeCantonDe"];?>
								<?php  echo $list['canton_id']; ?>  
							</div>
							
						</div>
						
						
						
						
						<div class="row text-center"><div class="col-md-12 parentsolo_plr_0">
						<input type="submit" class="freesignup" value="<?php  echo $lang_apphome["JeMinscris"];?>" />
						</div>
						</div>
					</form>
					
					
				</div>

            </div>
            <!-- end of chat history -->

                        </div>
        </div>
        <!-- end of chat -->
    </div>
					</div>		</div>
	<!-- ===== End Start of Live Chat ===== -->
				<!-- Join its free Section end -->
				
				<script type="text/javascript">
					(function($) {
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
					})(jQuery);
				</script>
						<!--register-->
		<?php 
		
		}
		
	}
?>

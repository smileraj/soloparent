<?php

defined('JL') or die('Error 401');

global $user, $app, $action, $langue, $db;

// Safely include language file
$langParam = JL::getVar('lang', 'en'); // default 'en' if not set
$langFile = __DIR__ . "/lang/app_mod.$langParam.php"; // absolute path

if (file_exists($langFile)) {
    include($langFile);
   
}


$id = JL::getVar('id', 0);

// Variables for active menu classes
$active = 1;
$menu = 1;
$ss_menu = 3; // last value counts, no need multiple assignments

// Determine active menu
if ($app === 'profil') {
    if ($user->id > 0 && (preg_match('/^step/', $action) || $action === "notification")) {
        // any specific logic here
    } elseif ($action === 'panel') {
        $active = 0;
    }
} elseif ($app === 'message' || $app === 'flbl') {
    $active = 1;
    $menu = 1;
} elseif ($app === 'search') {
    $active = ($action === 'search_online') ? 6 : 2;
    $menu = 2;
} elseif ($app === 'chat') {
    $active = 3;
} elseif ($app === 'groupe') {
    $active = 4;
    $menu = 3;
} elseif ($app === 'points') {
    $active = 5;
    $menu = 4;
} elseif ($app === 'abonnement') {
    $active = 7;
    $menu = 6;
} elseif ($app === 'contenu' && $id == 13) { // strict comparison
    $active = 8;
}

// Determine sidebar active value
$action1 = JL::getVar('action', '');
$listType = JL::getVar('list_type', '');
$groupeType = JL::getVar('groupe_type', '');
$appParam = JL::getVar('app', '');

if ($action1 === 'panel') {
    $active_val = 'home';
} elseif (in_array($action1, ['step1','step2','step3','step4','step5','notification'])) {
    $active_val = 'account';
} elseif (in_array($action1, ['inbox','sent','trash','archive'])) {
    $active_val = 'message';
} elseif (in_array($action1, ['visits','profile_matching','mylastvisits','search_last_inscription']) || $listType === '1') {
    $active_val = 'search';
} elseif ($action1 === 'event' || $appParam === 'event') {
    $active_val = 'event';
} elseif (in_array($groupeType, ['all','joined','created']) || $action1 === 'edit') {
    $active_val = 'groups';
} elseif (in_array($action1, ['info','reglement','cadeaux','bareme','classement','archives','mespoints'])) {
    $active_val = 'solofleurs';
} elseif (in_array($appParam, ['contact','abonnement']) || $action1 === 'tarifs') {
    $active_val = 'subscribe';
} elseif ($appParam === 'contenu' || in_array($id, [126,13])) {
    $active_val = 'help';
} else {
    $active_val = 'home';
}
	?>
   <div class="nav-side-menu">
    
        <div class="menu-list" id="accordion">
  
            <ul id="menu-content" class="panel menu-content collapse out">
                <li class="<?php if($active_val=='home'){ echo 'active'; } ?>">
                  <a href="<?php echo $user->id ? JL::url('index.php?app=profil&action=panel'.'&'.$langue) : SITE_URL.'?'.$langue; ?>" title="<?php echo $lang_mod["Accueil"];?>">
						<i class="fa fa-dashboard"></i> <?php echo $lang_mod["Accueil"];?>
                  </a>
                </li>

                <li  data-toggle="collapse"  href="#MonCompte" data-parent="#accordion" class="collapsed <?php if($active_val=='account'){ echo 'active'; } ?>">
                  <a href="javascript:void(0);" title="<?php echo $lang_mod["MonCompte"];?>"><i class="fa fa-file-image-o"></i> <?php echo $lang_mod["MonCompte"];?> <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse  <?php if($active_val=='account'){ echo 'in'; } ?>" id="MonCompte">
                    <?php 					if($menu)
					{
					?>
					<li class="<?php if($action=='step2'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step2&'.$langue); ?>" title="<?php echo $lang_mod["MesPhotos"]; ?>"><?php echo $lang_mod["MesPhotos"]; ?></a></li>
					<?php 					if($ss_menu){				
					?>
					<!--<li class="<?php if($action=='step2'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step2&'.$langue); ?>" title="<?php echo $lang_mod["MesPhotos"]; ?>"><?php echo $lang_mod["MesPhotos"]; ?></a></li>-->
					<li class="<?php if($action=='step3'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step3&'.$langue); ?>" title="<?php echo $lang_mod["MonAnnonce"]; ?>"><?php echo $lang_mod["MonAnnonce"]; ?></a></li>
					<li class="<?php if($action=='step4'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step4&'.$langue); ?>" title="<?php echo $lang_mod["MaDescription"]; ?>"><?php echo $lang_mod["MaDescription"]; ?></a></li>
					<li class="<?php if($action=='step5'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step5&'.$langue); ?>" title="<?php echo $lang_mod["MesEnfants"]; ?>"><?php echo $lang_mod["MesEnfants"]; ?></a></li>
					<?php 					}
					?>
					
					<li class="<?php if($action=='step1'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step1&'.$langue); ?>" title="<?php echo $lang_mod["ParametresCompte"]; ?>"><?php echo $lang_mod["ParametresCompte"]; ?></a></li>
					<li class="<?php if($action=='notification'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=notification&'.$langue); ?>" title="<?php echo $lang_mod["Notifications"]; ?>"><?php echo $lang_mod["Notifications"]; ?></a></li>
					
					
					<?php }
						
					?>
                </ul>


                <li data-toggle="collapse" href="#Message" data-parent="#accordion" class="collapsed <?php if($active_val=='message'){ echo 'active'; } ?>">
                  <a href="javascript:void(0);" title="<?php echo $lang_mod["Message"];?>"><i class="fa fa-comments"></i><?php echo $lang_mod["Message"];?> <span class="arrow"></span></a>
                </li>  
                <ul class="sub-menu collapse <?php if($active_val=='message'){ echo 'in'; } ?>" id="Message">
                 <li>
		<a href="<?php if($user->id) { ?>javascript:windowOpen('ParentSoloChat','<?php echo JL::url(SITE_URL.'/chat2/chat.php?'.$langue); ?>','810px','610px');<?php } else { echo JL::url('index.php?app=profil&action=inscription&'.$langue); } ?>" title="<?php echo $lang_mod["Chat"];?>">
		<?php echo $lang_mod["Chat"];?>
		</a>
		</li>
		<?php 					if($ss_menu){				
					?>
						<li class="<?php if($action=='inbox'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=message&action=inbox&'.$langue); ?>" title="<?php echo $lang_mod["BoiteReception"]; ?>"><?php echo $lang_mod["BoiteReception"]; ?></a></li>
						<li class="<?php if($action=='sent'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=message&action=sent&'.$langue); ?>" title="<?php echo $lang_mod["Envois"]; ?>"><?php echo $lang_mod["Envois"]; ?></a></li>
						<li class="<?php if($action=='trash'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=message&action=trash&'.$langue); ?>" title="<?php echo $lang_mod["Corbeille"]; ?>"><?php echo $lang_mod["Corbeille"]; ?></a></li>
						<li class="<?php if($action=='archive'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=message&action=archive&'.$langue); ?>" title="<?php echo $lang_mod["Archives"]; ?>"><?php echo $lang_mod["Archives"]; ?></a></li>
						
					<?php 					}
					?>
                </ul>


                <li data-toggle="collapse" data-target="#Recherche" data-parent="#accordion"  class="collapsed <?php if($active_val=='search'){ echo 'active'; } ?>">
                  <a href="javascript:void(0);" title="<?php echo $lang_mod["Recherche"];?>"><i class="fa fa-search"></i><?php echo $lang_mod["Recherche"];?> <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php if($active_val=='search'){ echo 'in'; } ?>" id="Recherche">
                  <?php 			if($menu){
			?>
			<li class="<?php if($action=='visits'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=search&action=visits&'.$langue); ?>" title="<?php echo $lang_mod["QuiAVisiteMonProfil"]; ?>"><?php echo $lang_mod["QuiAVisiteMonProfil"]; ?></a></li>
			<li class="<?php if($action=='profile_matching'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=search&action=profile_matching&'.$langue); ?>" title="<?php echo $lang_mod["Suggestions"]; ?>"><?php echo $lang_mod["Suggestions"]; ?></a></li>
			<li class="<?php if(isset($_GET['list_type']) && $_GET['list_type']=='1'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=flbl&action=list&list_type=1&'.$langue); ?>" title="<?php echo $lang_mod["MesListes"]; ?>"><?php echo $lang_mod["MesListes"]; ?></a></li>
			<li class="<?php if($action=='mylastvisits'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=search&action=mylastvisits&'.$langue); ?>" title="<?php echo $lang_mod["last_visits"]; ?>"><?php echo $lang_mod["last_visits"]; ?></a></li>
									
				<!--<li><a href="<?php echo JL::url('index.php?app=search&action=search_online&'.$langue); ?>" title="<?php echo $lang_mod["EnLigne"]; ?>"><?php echo $lang_mod["EnLigne"]; ?></a></li>-->
				<?php 					if($user->genre=='h'){
				?>
						<li class="<?php if($action=='search_last_inscription'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=search&action=search_last_inscription&'.$langue); ?>" title="<?php echo $lang_mod["DerniersMamansInscrits"]; ?>"><?php echo $lang_mod["DerniersMamansInscrits"]; ?></a></li>
				<?php 					}elseif($user->genre=='f'){
				?>
						<li class="<?php if($action=='search_last_inscription'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=search&action=search_last_inscription&'.$langue); ?>" title="<?php echo $lang_mod["DerniersPapasInscrits"]; ?>"><?php echo $lang_mod["DerniersPapasInscrits"]; ?></a></li>
				<?php 					}
				?>
				
				<!--	<li><a href="<?php echo JL::url('index.php?app=search&action=search&'.$langue); ?>" title="<?php echo $lang_mod["RechercheAvancee"]; ?>"><?php echo $lang_mod["RechercheAvancee"]; ?></a></li>-->
				<?php }

				?>
                </ul>
				
				<li data-toggle="collapse" data-target="#evt" class="collapsed <?php if($active_val=='event'){ echo 'active'; } ?>" data-parent="#accordion" >
                  <a href="javascript:void(0);" title="<?php echo $lang_mod["evt"];?>"><i class="fa fa-calendar-o"></i><?php echo $lang_mod["evt"];?> <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php if($active_val=='event'){ echo 'in'; } ?>" id="evt">
                <li class="<?php if($_GET['app']=='event'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=event&'.$langue); ?>" title="<?php echo $lang_mod["search_events"]; ?>"><?php echo $lang_mod["search_events"]; ?></a></li>
				 <li ><a href="<?php echo JL::url('index.php?app=event&'.$langue); ?>" title="<?php echo $lang_mod["Share_events"]; ?>"><?php echo $lang_mod["Share_events"]; ?></a></li>
                </ul>
				
				<li data-toggle="collapse" data-target="#Groupes" class="collapsed <?php if($active_val=='groups'){ echo 'active'; } ?>" data-parent="#accordion" >
                  <a href="javascript:void(0);" title="<?php echo $lang_mod["Groupes"];?>"> <i class="fa fa-users"></i><?php echo $lang_mod["Groupes"];?> <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php if($active_val=='groups'){ echo 'in'; } ?>" id="Groupes">
                	<?php 			if($menu){
			?>
			<li class="<?php if(isset($_GET['groupe_type']) && $_GET['groupe_type']=='all'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=groupe&action=list&groupe_type=all&'.$langue); ?>" title="<?php echo $lang_mod["TousLesGroupes"]; ?>"><?php echo $lang_mod["TousLesGroupes"]; ?></a></li>
					<li class="<?php if(isset($_GET['groupe_type']) && $_GET['groupe_type']=='joined'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=groupe&action=list&groupe_type=joined&'.$langue); ?>" title="<?php echo $lang_mod["GroupesRejoints"]; ?>"><?php echo $lang_mod["GroupesRejoints"]; ?></a></li>
				<li class="<?php if(isset($_GET['groupe_type']) && $_GET['groupe_type']=='created'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=groupe&action=list&groupe_type=created&'.$langue); ?>" title="<?php echo $lang_mod["MesCreations"]; ?>"><?php echo $lang_mod["MesCreations"]; ?></a></li>
					<li class="<?php if($action=='edit'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=groupe&action=edit&'.$langue); ?>" title="<?php echo $lang_mod["CreerUnGroupe"]; ?>"><?php echo $lang_mod["CreerUnGroupe"]; ?></a></li>
					<?php 					}
				?>
                </ul>
				
		 
				<li data-toggle="collapse" data-target="#Solofleurs" class="collapsed <?php if($active_val=='solofleurs'){ echo 'active'; } ?>" data-parent="#accordion" >
                 <a href="javascript:void(0);" title="<?php echo $lang_mod["Solofleurs"];?>"><i class="fa fa-heart-o"></i><?php echo $lang_mod["Solofleurs"];?> <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse <?php if($active_val=='solofleurs'){ echo 'in'; } ?>" id="Solofleurs">
					<li class="<?php if($action=='info'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=info&'.$langue); ?>" title="<?php echo $lang_mod["Informations"];?>"><?php echo $lang_mod["Informations"];?></a></li>
					<li class="<?php if($action=='reglement'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=reglement&'.$langue); ?>" title="<?php echo $lang_mod["Reglement"];?>"><?php echo $lang_mod["Reglement"];?></a></li>
					<li class="<?php if($action=='cadeaux'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=cadeaux&'.$langue); ?>" title="<?php echo $lang_mod["Cadeau"];?>"><?php echo $lang_mod["Cadeau"];?></a></li>
					<li class="<?php if($action=='bareme'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=bareme&'.$langue); ?>" title="<?php echo $lang_mod["Bareme"];?>"><?php echo $lang_mod["Bareme"];?></a></li>
					<li class="<?php if($action=='classement'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=classement&'.$langue); ?>" title="<?php echo $lang_mod["Classement"];?>"><?php echo $lang_mod["Classement"];?></a></li>
					<li class="<?php if($action=='archives'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=archives&'.$langue); ?>" title="<?php echo $lang_mod["Archives"];?>"><?php echo $lang_mod["Archives"];?></a></li>
					<li class="<?php if($action=='mespoints'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=mespoints&'.$langue); ?>" title="<?php echo $lang_mod["MesSolofleurs"];?>"><?php echo $lang_mod["MesSolofleurs"];?></a></li>
				</ul>
				<li data-toggle="collapse" data-target="#Abonnement" class="collapsed <?php if($active_val=='subscribe'){ echo 'active'; } ?>" data-parent="#accordion" >
					<a href="javascript:void(0);" title="<?php echo $lang_mod["Abonnement"];?>"><i class="fa fa-newspaper-o"></i><?php echo $lang_mod["Abonnement"];?> <span class="arrow"></span></a>
					</li>
					<ul class="sub-menu collapse <?php if($active_val=='subscribe'){ echo 'in'; } ?>" id="Abonnement">
						<li class="<?php if($action=='infos'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=abonnement&action=infos&'.$langue); ?>" title="<?php echo $lang_mod["Informations"]; ?>"><?php echo $lang_mod["Informations"]; ?> </a>
						</li><?php 					if($ss_menu)	{				
					?>
						<li class="<?php if($_GET['app']=='contact'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=contact&lang='.$_GET['lang']); ?>" title="<?php echo $lang_mod["PoserUneQuestion"]; ?>"><?php echo $lang_mod["PoserUneQuestion"]; ?></a></li>
						
					
					<?php 					}
					?>
						
					<li class="<?php if($action=='tarifs'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=abonnement&action=tarifs&'.$langue); ?>" title="<?php echo $lang_mod["Abonnez-vous"]; ?>"><?php echo $lang_mod["Abonnez-vous"]; ?></a></li>			
				</ul>
				<li data-toggle="collapse" data-target="#help" class="collapsed <?php if($active_val=='help'){ echo 'active'; } ?>" data-parent="#accordion" >
					<a href="javascript:void(0);" title="<?php echo $lang_mod["ToutesLesQuestionsTraitees"];?>"><i class="fa fa-question-circle"></i><?php echo $lang_mod["ToutesLesQuestionsTraitees"];?> <span class="arrow"></span></a>
					</li>
				<ul class="sub-menu collapse <?php if($active_val=='help'){ echo 'in'; } ?>" id="help">
					<li class="<?php if(isset($_GET['id']) && $_GET['id']=='126'){ echo 'active';} ?>"><a href="<?php echo JL::url('index.php?app=contenu&id=126&lang='.$_GET['lang']); ?>" title="<?php echo $lang_mod["ToutesLesQuestionsTraitees"]; ?>"><?php echo $lang_mod["ToutesLesQuestionsTraitees"]; ?></a></li>
					<li class="<?php if(isset($_GET['id']) && $_GET['id']=='13'){ echo 'active'; } ?>">
					<a href="<?php echo JL::url('index.php?app=contenu&id=13'.'&'.$langue); ?>" title="<?php echo $lang_mod["Aide"];?>"><?php echo $lang_mod["Aide"];?>
                  </a>
                  </li>
				  </ul>

                 
            </ul>
     </div>
</div>
    
  </div>
  
</div>


<div class="page-container  sidebar-collapsed hidden-md  hidden-lg sidenav" id="mySidenav"  >

  <header class=" hidden-lg hidden-md"> 
		<a href="javascript:void(0)" class="sidebar-icon closebtn" onclick="closeNav()"> <span class="fa fa-times"></span> </a> <a href="#">
        </a> 
	</header>
	
  
	
	
  <div class="sidebar-menu">
   <div style="border-top:1px solid rgb(152, 9, 9);"></div>
   
   <div class="nav-side-menu">
    
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse in">
                <li class="<?php if($active_val=='home'){ echo 'active'; } ?>">
                  <a href="<?php echo $user->id ? JL::url('index.php?app=profil&action=panel'.'&'.$langue) : SITE_URL.'?'.$langue; ?>" title="<?php echo $lang_mod["Accueil"];?>">
						<i class="fa fa-dashboard"></i> <?php echo $lang_mod["Accueil"];?>
                  </a>
                </li>

                <li  data-toggle="collapse" data-target="#MonCompte" class="collapsed open_cls_main_1 <?php if($active_val=='account'){ echo 'active'; } ?>">
                  <a href="javascript:void(0)" title="<?php echo $lang_mod["MonCompte"];?>"><i class="fa fa-file-image-o"></i> <?php echo $lang_mod["MonCompte"];?> <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu open_cls_1 collapse  <?php if($active_val=='account'){ echo 'in'; } ?>" id="MonCompte">
                    <?php 					if($menu)
					{
					?>
					<li class="<?php if($action=='step2'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step2&'.$langue); ?>" title="<?php echo $lang_mod["MesPhotos"]; ?>"><?php echo $lang_mod["MesPhotos"]; ?></a></li>
					<?php 					if($ss_menu){				
					?>
					<!--<li  class="<?php if($action=='step2'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step2&'.$langue); ?>" title="<?php echo $lang_mod["MesPhotos"]; ?>"><?php echo $lang_mod["MesPhotos"]; ?></a></li>-->
					<li  class="<?php if($action=='step3'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step3&'.$langue); ?>" title="<?php echo $lang_mod["MonAnnonce"]; ?>"><?php echo $lang_mod["MonAnnonce"]; ?></a></li>
					<li  class="<?php if($action=='step4'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step4&'.$langue); ?>" title="<?php echo $lang_mod["MaDescription"]; ?>"><?php echo $lang_mod["MaDescription"]; ?></a></li>
					<li class="<?php if($action=='step5'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step5&'.$langue); ?>" title="<?php echo $lang_mod["MesEnfants"]; ?>"><?php echo $lang_mod["MesEnfants"]; ?></a></li>
					<?php 					}
					?>
					
					<li class="<?php if($action=='step1'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=step1&'.$langue); ?>" title="<?php echo $lang_mod["ParametresCompte"]; ?>"><?php echo $lang_mod["ParametresCompte"]; ?></a>
					</li><li class="<?php if($action=='notification'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=profil&action=notification&'.$langue); ?>" title="<?php echo $lang_mod["Notifications"]; ?>"><?php echo $lang_mod["Notifications"]; ?></a></li>
					
					
					<?php }
						
					?>
                </ul>


                <li data-toggle="collapse" data-target="#Message" class="collapsed open_cls_main_2  <?php if($active_val=='message'){ echo 'active'; } ?>">
                  <a href="javascript:void(0);" title="<?php echo $lang_mod["Message"];?>"><i class="fa fa-comments"></i><?php echo $lang_mod["Message"];?> <span class="arrow"></span></a>
                </li>  
                <ul class="sub-menu open_cls_2 collapse <?php if($active_val=='message'){ echo 'in'; } ?>" id="Message">
                 <li>
		<a href="<?php if($user->id) { ?>javascript:windowOpen('ParentSoloChat','<?php echo JL::url(SITE_URL.'/chat2/chat.php?'.$langue); ?>','810px','610px');<?php } else { echo JL::url('index.php?app=profil&action=inscription&'.$langue); } ?>" title="<?php echo $lang_mod["Chat"];?>">
		<?php echo $lang_mod["Chat"];?>
		</a>
		</li>
		<?php 					if($ss_menu){				
					?>
						<li  class="<?php if($action=='inbox'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=message&action=inbox&'.$langue); ?>" title="<?php echo $lang_mod["BoiteReception"]; ?>"><?php echo $lang_mod["BoiteReception"]; ?></a></li>
						<li class="<?php if($action=='sent'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=message&action=sent&'.$langue); ?>" title="<?php echo $lang_mod["Envois"]; ?>"><?php echo $lang_mod["Envois"]; ?></a></li>
						<li class="<?php if($action=='trash'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=message&action=trash&'.$langue); ?>" title="<?php echo $lang_mod["Corbeille"]; ?>"><?php echo $lang_mod["Corbeille"]; ?></a></li>
						<li class="<?php if($action=='archive'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=message&action=archive&'.$langue); ?>" title="<?php echo $lang_mod["Archives"]; ?>"><?php echo $lang_mod["Archives"]; ?></a></li>
						
					<?php 					}
					?>
                </ul>


                <li data-toggle="collapse" data-target="#Recherche" class="collapsed open_cls_main_3 <?php if($active_val=='search'){ echo 'active'; } ?>">
                  <a href="javascript:void(0);" title="<?php echo $lang_mod["Recherche"];?>"><i class="fa fa-search"></i><?php echo $lang_mod["Recherche"];?> <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu open_cls_3 collapse <?php if($active_val=='search'){ echo 'in'; } ?>" id="Recherche">
                  <?php 			if($menu){
			?>
			<li class="<?php if($action=='visits'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=search&action=visits&'.$langue); ?>" title="<?php echo $lang_mod["QuiAVisiteMonProfil"]; ?>"><?php echo $lang_mod["QuiAVisiteMonProfil"]; ?></a></li>
			<li class="<?php if($action=='profile_matching'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=search&action=profile_matching&'.$langue); ?>" title="<?php echo $lang_mod["Suggestions"]; ?>"><?php echo $lang_mod["Suggestions"]; ?></a></li>
			<li class="<?php if($_GET['list_type']=='1'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=flbl&action=list&list_type=1&'.$langue); ?>" title="<?php echo $lang_mod["MesListes"]; ?>"><?php echo $lang_mod["MesListes"]; ?></a></li>
			<li class="<?php if($action=='mylastvisits'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=search&action=mylastvisits&'.$langue); ?>" title="<?php echo $lang_mod["last_visits"]; ?>"><?php echo $lang_mod["last_visits"]; ?></a></li>
									
				<!--<li><a href="<?php echo JL::url('index.php?app=search&action=search_online&'.$langue); ?>" title="<?php echo $lang_mod["EnLigne"]; ?>"><?php echo $lang_mod["EnLigne"]; ?></a></li>-->
				<?php 					if($user->genre=='h'){
				?>
						<li class="<?php if($action=='search_last_inscription'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=search&action=search_last_inscription&'.$langue); ?>" title="<?php echo $lang_mod["DerniersMamansInscrits"]; ?>"><?php echo $lang_mod["DerniersMamansInscrits"]; ?></a></li>
				<?php 					}elseif($user->genre=='f'){
				?>
						<li class="<?php if($action=='search_last_inscription'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=search&action=search_last_inscription&'.$langue); ?>" title="<?php echo $lang_mod["DerniersPapasInscrits"]; ?>"><?php echo $lang_mod["DerniersPapasInscrits"]; ?></a></li>
				<?php 					}
				?>
				
				<!--	<li><a href="<?php echo JL::url('index.php?app=search&action=search&'.$langue); ?>" title="<?php echo $lang_mod["RechercheAvancee"]; ?>"><?php echo $lang_mod["RechercheAvancee"]; ?></a></li>-->
				<?php }

				?>
                </ul>
				
				<li data-toggle="collapse" data-target="#evt" class="collapsed open_cls_main_4 <?php if($active_val=='event'){ echo 'active'; } ?>">
                  <a href="javascript:void(0);" title="<?php echo $lang_mod["evt"];?>"><i class="fa fa-calendar-o"></i><?php echo $lang_mod["evt"];?> <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu open_cls_4 collapse <?php if($active_val=='event'){ echo 'in'; } ?>" id="evt">
                 <li class="<?php if($_GET['app']=='event'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=event&'.$langue); ?>" title="<?php echo $lang_mod["search_events"]; ?>"><?php echo $lang_mod["search_events"]; ?></a></li>
				 <li><a href="<?php echo JL::url('index.php?app=event&'.$langue); ?>" title="<?php echo $lang_mod["Share_events"]; ?>"><?php echo $lang_mod["Share_events"]; ?></a></li>
                </ul>
				
				<li data-toggle="collapse" data-target="#Groupes" class="collapsed open_cls_main_5 <?php if($active_val=='groups'){ echo 'active'; } ?>">
                  <a href="javascript:void(0);" title="<?php echo $lang_mod["Groupes"];?>"> <i class="fa fa-users"></i><?php echo $lang_mod["Groupes"];?> <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu open_cls_5 collapse <?php if($active_val=='groups'){ echo 'in'; } ?>" id="Groupes">
                	<?php 			if($menu){
			?>
			<li class="<?php if(isset($_GET['groupe_type']) && $_GET['groupe_type']=='all'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=groupe&action=list&groupe_type=all&'.$langue); ?>" title="<?php echo $lang_mod["TousLesGroupes"]; ?>"><?php echo $lang_mod["TousLesGroupes"]; ?></a></li>
					<li class="<?php if(isset($_GET['groupe_type']) && $_GET['groupe_type']=='joined'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=groupe&action=list&groupe_type=joined&'.$langue); ?>" title="<?php echo $lang_mod["GroupesRejoints"]; ?>"><?php echo $lang_mod["GroupesRejoints"]; ?></a></li>
				<li class="<?php if(isset($_GET['groupe_type']) && $_GET['groupe_type']=='created'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=groupe&action=list&groupe_type=created&'.$langue); ?>" title="<?php echo $lang_mod["MesCreations"]; ?>"><?php echo $lang_mod["MesCreations"]; ?></a></li>
					<li class="<?php if($action=='edit'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=groupe&action=edit&'.$langue); ?>" title="<?php echo $lang_mod["CreerUnGroupe"]; ?>"><?php echo $lang_mod["CreerUnGroupe"]; ?></a></li>
					<?php 					}
				?>
                </ul>
				
		 
				<li data-toggle="collapse" data-target="#Solofleurs" class="collapsed open_cls_main_6 <?php if($active_val=='solofleurs'){ echo 'active'; } ?>">
                 <a href="javascript:void(0);" title="<?php echo $lang_mod["Solofleurs"];?>"><i class="fa fa-heart-o"></i><?php echo $lang_mod["Solofleurs"];?> <span class="arrow  open_cls_main_7"></span></a>
                </li>
                <ul class="sub-menu open_cls_6 collapse <?php if($active_val=='solofleurs'){ echo 'in'; } ?>" id="Solofleurs">
					<li class="<?php if($action=='info'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=info&'.$langue); ?>" title="<?php echo $lang_mod["Informations"];?>"><?php echo $lang_mod["Informations"];?></a></li>
					<li class="<?php if($action=='reglement'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=reglement&'.$langue); ?>" title="<?php echo $lang_mod["Reglement"];?>"><?php echo $lang_mod["Reglement"];?></a></li>
					<li class="<?php if($action=='cadeaux'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=cadeaux&'.$langue); ?>" title="<?php echo $lang_mod["Cadeau"];?>"><?php echo $lang_mod["Cadeau"];?></a></li>
					<li class="<?php if($action=='bareme'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=bareme&'.$langue); ?>" title="<?php echo $lang_mod["Bareme"];?>"><?php echo $lang_mod["Bareme"];?></a></li>
					<li class="<?php if($action=='classement'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=classement&'.$langue); ?>" title="<?php echo $lang_mod["Classement"];?>"><?php echo $lang_mod["Classement"];?></a></li>
					<li class="<?php if($action=='archives'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=archives&'.$langue); ?>" title="<?php echo $lang_mod["Archives"];?>"><?php echo $lang_mod["Archives"];?></a></li>
					<li class="<?php if($action=='mespoints'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=points&action=mespoints&'.$langue); ?>" title="<?php echo $lang_mod["MesSolofleurs"];?>"><?php echo $lang_mod["MesSolofleurs"];?></a></li>
				</ul>
				<li data-toggle="collapse" data-target="#Abonnement" class="collapsed <?php if($active_val=='subscribe'){ echo 'active'; } ?>">
					<a href="javascript:void(0);" title="<?php echo $lang_mod["Abonnement"];?>"><i class="fa fa-newspaper-o"></i><?php echo $lang_mod["Abonnement"];?> <span class="arrow  open_cls_main_7"></span></a>
					</li>
					<ul class="sub-menu open_cls_7 collapse <?php if($active_val=='subscribe'){ echo 'in'; } ?>" id="Abonnement">
						<li class="<?php if($action=='infos'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=abonnement&action=infos&'.$langue); ?>" title="<?php echo $lang_mod["Informations"]; ?>"><?php echo $lang_mod["Informations"]; ?> </a>
						</li><?php 					if($ss_menu)	{				
					?>
						<li class="<?php if($_GET['app']=='contact'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=contact&lang='.$_GET['lang']); ?>" title="<?php echo $lang_mod["PoserUneQuestion"]; ?>"><?php echo $lang_mod["PoserUneQuestion"]; ?></a></li>
						
					<?php 					}
					?>
						
					<li class="<?php if($action=='tarifs'){ echo 'active';}?>"><a href="<?php echo JL::url('index.php?app=abonnement&action=tarifs&'.$langue); ?>" title="<?php echo $lang_mod["Abonnez-vous"]; ?>"><?php echo $lang_mod["Abonnez-vous"]; ?></a></li>			
				</ul>
		
                
<li data-toggle="collapse" data-target="#help" class="collapsed <?php if($active_val=='help'){ echo 'active'; } ?>" data-parent="#accordion" >
					<a href="javascript:void(0);" title="<?php echo $lang_mod["ToutesLesQuestionsTraitees"];?>"><i class="fa fa-newspaper-o"></i><?php echo $lang_mod["ToutesLesQuestionsTraitees"];?> <span class="arrow open_cls_main_8"></span></a>
					</li>
				<ul class="sub-menu open_cls_8 collapse <?php if($active_val=='help'){ echo 'in'; } ?>" id="help">
					<li class="<?php if(isset($_GET['id']) && $_GET['id']=='126'){ echo 'active'; }?>">
					<a href="<?php echo JL::url('index.php?app=contenu&id=126&lang='.$_GET['lang']); ?>" title="<?php echo $lang_mod["ToutesLesQuestionsTraitees"]; ?>"><?php echo $lang_mod["ToutesLesQuestionsTraitees"]; ?></a></li>
					<li class="<?php if(isset($_GET['id']) && $_GET['id']=='13'){ echo 'active'; } ?>">
					<a href="<?php echo JL::url('index.php?app=contenu&id=13'.'&'.$langue); ?>" title="<?php echo $lang_mod["Aide"];?>"><?php echo $lang_mod["Aide"];?>
                  </a>
                  </li>
				  </ul>
                 
            </ul>
     </div>
</div>
   
   
   
    
  </div>
</div>



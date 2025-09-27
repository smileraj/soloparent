<?php

	// s�curit�
	defined('JL') or die('Error 401');
	// chemin du template
	$template	= SITE_URL_ADMIN.'/'.SITE_TEMPLATE;
	
	global $user, $app;
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
	<head>
		
		<?php 			// module de gestion automatis�e des meta tags
			JL::loadMod('meta', 'admin');
		?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Dancing+Script|Quicksand|Satisfy" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link href="<?php echo $template.'/'; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $template.'/'; ?>css/bootstrap-reset.css" rel="stylesheet" type="text/css" />
		<!--external css-->
		<link href="<?php echo $template.'/'; ?>css/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="<?php echo $template.'/'; ?>css/style.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $template.'/'; ?>css/style-responsive.css" rel="stylesheet" type="text/css" />
		<!--<link href="<?php // echo $template.'/'.SITE_TEMPLATE.'.css'; ?>" rel="stylesheet" type="text/css" />-->
		 <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
		<link href="<?php echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<?php if($app == 'expert') { ?>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/mootools-back.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/swfupload/swfupload.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/swfupload/handlers.js"></script>
			<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>/js/swfupload/default.css">
		<?php } ?>
		<?php if($app == 'mailing_auto') { 
			if($action=="edit" || $action=="save"){
		?>
				<link href="<?php echo $template; ?>/upload.css" rel="stylesheet" type="text/css" />
				<script src="<?php echo SITE_URL_ADMIN; ?>/js/ajaxupload.3.5.js"></script>
				<script src="<?php echo SITE_URL_ADMIN; ?>/js/jquery-1.3.2.js"></script>
				<script src="<?php echo SITE_URL_ADMIN; ?>/js/upload.js"></script>
		<?php 			}
		?>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/mootools-back.js"></script>
			<script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/app_mailing_auto.js"></script>
		<?php } ?>
		<script>(function($){
  var methods = {
    init: function(options) {
      var state = {
        timer: null,
        timerSeconds: 10,
        callback: function() {},
        timerCurrent: 0,
        showPercentage: false,
        fill: false,
        color: '#CCC'
      };

      state = $.extend(state, options);

      return this.each(function() {
        var $this = $(this);
        var data = $this.data('pietimer');
        if (!data) {
          $this.addClass('pietimer');
          $this.css({fontSize: $this.width()});
          $this.data('pietimer', state);
          if (state.showPercentage) {
            $this.find('.percent').show();
          }
          if (state.fill) {
            $this.addClass('fill');
          }
          $this.pietimer('start');
        }
      });
    },

    stopWatch: function() {
      var data = $(this).data('pietimer');
      if (data) {
        var seconds = (data.timerFinish-(new Date().getTime()))/1000;
        if (seconds <= 0) {
          clearInterval(data.timer);
          $(this).pietimer('drawTimer', 100);
          data.callback();
        } else {
          var percent = 100-((seconds/(data.timerSeconds))*100);
          $(this).pietimer('drawTimer', percent);
        }
      }
    },

    drawTimer: function(percent) {
      $this = $(this);
      var data = $this.data('pietimer');
      if (data) {
        $this.html('<div class="percent"></div><div class="slice'+(percent > 50?' gt50"':'"')+'><div class="pie"></div>'+(percent > 50?'<div class="pie fill"></div>':'')+'</div>');
        var deg = 360/100*percent;
        $this.find('.slice .pie').css({
          '-moz-transform':'rotate('+deg+'deg)',
          '-webkit-transform':'rotate('+deg+'deg)',
          '-o-transform':'rotate('+deg+'deg)',
          'transform':'rotate('+deg+'deg)'
        });
        $this.find('.percent').html(Math.round(percent)+'%');
        if (data.showPercentage) {
          $this.find('.percent').show();
        }
        if ($this.hasClass('fill')) {
          $this.find('.slice .pie').css({backgroundColor: data.color});
        }
        else {
          $this.find('.slice .pie').css({borderColor: data.color});
        }
      }
    },
    
    start: function() {
      var data = $(this).data('pietimer');
      if (data) {
        data.timerFinish = new Date().getTime()+(data.timerSeconds*1000);
        $(this).pietimer('drawTimer', 0);
        data.timer = setInterval("$this.pietimer('stopWatch')", 50);
      }
    },

    reset: function() {
      var data = $(this).data('pietimer');
      if (data) {
        clearInterval(data.timer);
        $(this).pietimer('drawTimer', 0);
      }
    }
  };

  $.fn.pietimer = function(method) {
    if (methods[method]) {
      return methods[method].apply( this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof method === 'object' || !method) {
      return methods.init.apply(this, arguments);
    } else {
      $.error('Method ' +  method + ' does not exist on jQuery.pietimer');
    }
  };
})(jQuery);

</script>
<script type="text/javascript">
    $(function() {
      $('#timer').pietimer({
          timerSeconds: 10,
          color: '#234',
          fill: false,
          showPercentage: true,
          callback: function() {
              alert("yahoo, timer is done!");
              $('#timer').pietimer('reset');
          }
      });
    });
  </script>
	</head>
	
	<body>		
		<section id="container" class="">
		  <!--header start-->
          <header class="header white-bg">
		  
		    <div class="sidebar-toggle-box">
               <i class="fa fa-bars"></i>
            </div>	
		
				<a href="<?php echo SITE_URL_ADMIN; ?>/index.php" class="logo">
					<img src="<?php echo $template; ?>/images/logo_en.png" alt="SoloCircl.com" class="adminlogo" />
				</a>
				<?php 					// user log
					if($user->id) {
					?>
					
                  <div class="top-nav ">
                     
						<form action="<?php echo SITE_URL_ADMIN; ?>/index.php" name="login" method="post">
						 <ul class="nav pull-right top-menu">
							  <!-- user login dropdown start-->
                          <li class="dropdown">
							 <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                             <img alt="" src="<?php echo SITE_URL_ADMIN; ?>/parentsolo/images/avatar-mini.jpg">
							<span class="username"><?php echo $user->username; ?> ::   <b class="caret"></b></a>
							 <ul class="dropdown-menu extended logout">
                             <div class="log-arrow-up"></div>
							 <li><a href="javascript:document.login.submit();" >D&eacute;connexion</a></li>
							<input type="hidden" name="auth" value="logout" />
							 </ul>
                          </li>
						  
                        <!-- user login dropdown end -->
                        </ul>
						 
						</form>
					</div>
					<?php 					}
				?>		
		  </header>
          <!--header end-->
		  
		  <!--sidebar start-->
          <aside>	
			<?php 				// user log
				if($user->id) {
			?>
					
				<?php 						// charge le menu de gauche (il est charg� apr�s le Body afin de mettre � jour les nombres de textes, photos et messages dans le menu)
						JL::loadMod('menu', 'admin');
				?>
		  </aside>
		 <!--main content start-->
          <section id="main-content">
              <section class=" wrapper">
				<?php 				}
					// charge l'application demand�e
					JL::loadBody('admin');
					
				// user log
				if($user->id) {
			?>
			 </section>
          </section>
          <!--main content end-->
		<div style="clear:both"> </div>
			<?php 				}
			?>
			
			<!-- <footer class="site-footer"></footer>-->
			
		 </section>
		
	<!-- js placed at the end of the document so the pages load faster -->
	
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.dcjqaccordion.2.7.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo SITE_URL_ADMIN; ?>/js/slidebars.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>/js/respond.min.js" ></script>
	 <!--common script for all pages-->
    <script src="<?php echo SITE_URL_ADMIN; ?>/js/common-scripts.js"></script>

	</body>
	
</html>

<?php

	// s�curit�
	defined('JL') or die('Error 401');

	class HTML_panel {
		
		// page de login
		public static function loginPage() {
		?>
		<style>
		.sidebar-toggle-box
		{
			display:none;
		}
		body
		{
		    background-color: rgba(173, 53, 53, 0.89);
			background-image: url(../parentsolo/images/login-bg.png);    
			background-attachment: fixed;
			height: 100%;
			max-height: 100%;
background-size:cover;
			min-height: 99%;
			overflow: hidden;
			width: 100%;
		}		
		</style>
		 <div class="login-wrapper login_page">
            <div id="login" class="login loginpage col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-2 col-xs-8">
				<form action="<?php echo SITE_URL_ADMIN; ?>/index.php" name="login" method="post">
				<h1>Authentification</h1>
				<?php 						// demande d'authentification ?
						$auth	= JL::getVar('auth', '');
				?>
				 <p>
                       <label for="username">Pseudo</label>
						<input type="text" name="username" id="username" value="" class="loginText" />
                    </p>
                    <p>
                       <label for="pass">Mot de passe</label>
					   <input type="password" name="pass" id="pass" value="" class="loginText" />
                    </p>
                   
                   
                     <a href="javascript:document.login.submit();" class="bouton envoyer"> <p class="submit btnvalider">Valider </p></a>
                   
					<?php // demande de login �chou�e
						if($auth == 'login') {
						?>
						<p class="errorlogin">
							
								Login ou mot de passe incorrect(s) !
							
						</p>
						<?php 							}
						?>
						
					<input type="hidden" name="auth" value="login" />	
				
					
				
				</form>
			</div>
		</div>
		
		<?php 		}
		
		// page d'accueil admin
		public static function homePage(&$maintenance) {
		?>
		<section class="panel">
                  <header class="panel-heading">
                    <h2>Panneau d'administration solocircl.com</h2>
                  </header>
			
			<div class="tableAdmin">
				<h3>Op&eacute;rations de maintenance</h3>
				<br />
				<table class="table table-bordered table-striped table-condensed cf">
					<tr><td class="key_long">Suppression des messages du chat de plus de 15j</td><td width="80px;" align="center"><span style="<?php echo $maintenance->chat_message > 0 ? 'color:#00CC00;font-weight:bold;' : ''; ?>"><?php echo $maintenance->chat_message; ?></span></td></tr>
					<tr><td class="key_long">Suppression des conversations du chat de plus de 15j</td><td align="center"><span style="<?php echo $maintenance->chat_conversation > 0 ? 'color:#00CC00;font-weight:bold;' : ''; ?>"><?php echo $maintenance->chat_conversation; ?></span></td></tr>
					<tr><td class="key_long">Suppression des messages des corbeilles vid&eacute;es de plus de 7j</td><td align="center"><span style="<?php echo $maintenance->message > 0 ? 'color:#00CC00;font-weight:bold;' : ''; ?>"><?php echo $maintenance->message; ?></span></td></tr>
					<tr><td class="key_long">Suppression des r&eacute;servations de pseudo de plus de 3j</td><td align="center"><span style="<?php echo $maintenance->message > 0 ? 'color:#00CC00;font-weight:bold;' : ''; ?>"><?php echo $maintenance->user_inscription; ?></span></td></tr>
				</table>
			</div>
		</section>
		<?php 		
		}
		
	}
	
?>

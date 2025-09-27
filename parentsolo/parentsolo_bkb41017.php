<?php

	// s&eacute;curit&eacute;
	defined('JL') or die('Error 401');

	// chemin du template
	$template	= SITE_URL.'/'.SITE_TEMPLATE;
	

	global $app, $action, $user, $langue;

	// anti cache
	$version = 'v60';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >


	<head>
		<?php 			// module de gestion automatis&eacute;e des meta tags
			JL::loadMod('meta');
		?>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:400,100,300,300italic,400italic,500,500italic,600,600italic,700italic,700,800%7CLora:400,400italic,700,700italic">
		<link href="https://fonts.googleapis.com/css?family=Russo+One" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dancing+Script|Quicksand|Satisfy" rel="stylesheet">
		<link href="<?php echo $template.'/'.SITE_TEMPLATE.'.css?'.$version; ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo $template.'/'; ?>new_style/css/main.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $template.'/'; ?>plugins.css" rel="stylesheet">
		<!--photo validation-->
<link rel="stylesheet" type="text/css" href="<?php echo $template.'/'; ?>photovalidation/robocrop/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo $template.'/'; ?>photovalidation/demo.css">
<link rel="stylesheet" type="text/css" href="<?php echo $template.'/'; ?>new_style/css/bootstrap-toggle.css">
<link rel="stylesheet" type="text/css" href="<?php echo $template.'/'; ?>new_style/css/bootstrap-toggle.css">

<script src="<?php echo $template.'/'; ?>photovalidation/js/jquery-1.7.2.js"></script>
<script src="<?php echo $template.'/'; ?>photovalidation/js/facedetection/ccv.js"></script> 
		<script src="<?php echo $template.'/'; ?>photovalidation/js/facedetection/face.js"></script>
		<script src="<?php echo $template.'/'; ?>photovalidation/js/jquery.facedetection.js"></script>
		<script src="<?php echo $template.'/'; ?>photovalidation/canvas-toBlob.js"></script> 
<style>
.Dboot-preloader {
            /* padding-top: 20%; */
            background-color: #fff;
            display: block;
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 999999999999999;
        }
		 .hidden {
            display: none!important;
            visibility: hidden!important;
        }
        .text-center {
            text-align: center;
        }
</style>
<script>
//alert('hi');
var uploadId = 0;
jQuery.noConflict();
(function($) {	
	var tagnumber = 1;
		$(document).ready(function(){
$('.circle').on('load',function(){
		$(document).find('.findface').click();
	})
	$('.circle').on('load',function(){
	//alert(uploadId);
	if(uploadId == 1){
		$(document).find('.findface1').click();
	}
	else if(uploadId == 2){
		$(document).find('.findface2').click();
	}
	else if(uploadId == 3){
		$(document).find('.findface3').click();
	}
	else if(uploadId == 4){
		$(document).find('.findface4').click();
	}
	else if(uploadId == 5){
		$(document).find('.findface5').click();
	}
	else if(uploadId == 6){
		$(document).find('.findface6').click();
	}
	uploadId = 0;
	})
	
	
	
			//when you hover on a photo
			$('.findface').click(function(){

				//set $(this) in a variable to avoid conflict
				var $this = $(this);	

				//find the exact face and make it display:block
				$($this).parent().find('.face').show();			

				//find whether the faces are already detected or not
				//if not then call the faceDetection() to find the faces
				if(!($($this).hasClass('done'))){
					var coords = $($this).faceDetection({
						complete:function() {
							$($this).addClass('done1');
						}
					});
					
					<?php if($user->id){ ?>
				var imgval= document.getElementById('imag_val').src;
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;
var upload_dir= document.getElementById("upload_dir").value;
						//alert(upload_dir);
						var site_url= document.getElementById("site_url").value;
					
				$.ajax({
					type:'post',
					url:'ajaximage.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height},
					success:function(data){
						if(data==1)
						{
						window.location.reload();
						}
						else if($.trim(data)=='Limited_Images')
						{
							alert("Image reached the limit");
							window.location.reload();
						}
						
					}
				})
					};

			i.src = imgval;		
					
					<?} else {?>
					$('#newregimage').html(''); 
				var imgval= document.getElementById('imag_val').src;
				
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;					
	var upload_dir= document.getElementById("upload_dir").value;
	var site_url= document.getElementById("site_url").value;	
				$.ajax({
					type:'post',
					url:'newregajaximage.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height},
					success:function(data){
				$('#newregimage').show();
					$('#newregimage').html('<img src="'+data+'"  style="border:1px solid black;"/>')
					if(data=='Limited Images')
					{
					alert('Limited Images');
					$('#newregimage').hide();
					}
					if(data=='Please Select Images'){
					alert('Please Select Images');
					$('#newregimage').hide();
					}
					if(data=='New Register'){
					alert('New Register');
					$('#newregimage').hide();
					}
											
					}
				})
			};

			i.src = imgval;		
					
					
					<?}?>
					
					
				}
			})
			
			//1 photo
			//when you hover on a photo
			$('.findface1').click(function(){
				//set $(this) in a variable to avoid conflict
				var $this = $(this);	
				//find the exact face and make it display:block
				$($this).parent().find('.face1').show();			
				//find whether the faces are already detected or not
				//if not then call the faceDetection() to find the faces
				if(!($($this).hasClass('done'))){
					var coords = $($this).faceDetection({
						complete:function() {
							$($this).addClass('done1');
						}
					});
					
					<?php if($user->id){ ?>
				var imgval= document.getElementById('imag_val1').src;
				
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;

						var upload_dir= document.getElementById("upload_dir1").value;
						//alert(upload_dir);
						var site_url= document.getElementById("site_url1").value;
					var child_img="1";
				$.ajax({
					type:'post',
					url:'ajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
						if(data==1)
						{
						window.location.reload();
						}
						
					}
				})
			};

			i.src = imgval;
					<?} else {?>
					$('#newregimage1').html(''); 
				var imgval= document.getElementById('imag_val1').src;			

				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;

				
	var upload_dir= document.getElementById("upload_dir1").value;
	var site_url= document.getElementById("site_url1").value;	
	var child_img="1";
				$.ajax({
					type:'post',
					url:'newregajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
				$('#newregimage1').show();
					$('#newregimage1').html('<img src="'+data+'"  style="border:1px solid black;"/>')
					if(data=='Limited Images')
					{
					alert('Limited Images');
					$('#newregimage1').hide();
					}
					if(data=='Please Select Images'){
					alert('Please Select Images');
					$('#newregimage1').hide();
					}
					if(data=='New Register'){
					alert('New Register');
					$('#newregimage1').hide();
					}
											
					}
				})
			};

			i.src = imgval;		
					<?}?>
					
					
				}
			})
			//2nd photo 
			
			//when you hover on a photo
			$('.findface2').click(function(){
				//set $(this) in a variable to avoid conflict
				var $this = $(this);	
				//find the exact face and make it display:block
				$($this).parent().find('.face2').show();			
				//find whether the faces are already detected or not
				//if not then call the faceDetection() to find the faces
				if(!($($this).hasClass('done'))){
					var coords = $($this).faceDetection({
						complete:function() {
							$($this).addClass('done1');
						}
					});
					
					<?php if($user->id){ ?>
				var imgval= document.getElementById('imag_val2').src;
				
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;
				
						var upload_dir= document.getElementById("upload_dir2").value;
						//alert(upload_dir);
						var site_url= document.getElementById("site_url2").value;
					var child_img="2";
				$.ajax({
					type:'post',
					url:'ajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
						if(data==1)
						{
						window.location.reload();
						}
						
					}
				})
				
				};
				i.src = imgval;
					
					<?} else {?>
					$('#newregimage2').html(''); 
				var imgval= document.getElementById('imag_val2').src;			
				
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;
	var upload_dir= document.getElementById("upload_dir2").value;
	var site_url= document.getElementById("site_url2").value;	
	var child_img="2";
				$.ajax({
					type:'post',
					url:'newregajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
				$('#newregimage2').show();
					$('#newregimage2').html('<img src="'+data+'"  style="border:1px solid black;"/>')
					if(data=='Limited Images')
					{
					alert('Limited Images');
					$('#newregimage2').hide();
					}
					if(data=='Please Select Images'){
					alert('Please Select Images');
					$('#newregimage2').hide();
					}
					if(data=='New Register'){
					alert('New Register');
					$('#newregimage2').hide();
					}
											
					}
				})
					};
				i.src = imgval;
					<?}?>
					
					
				}
			}) 
			
			//3rd photo
			//when you hover on a photo
			$('.findface3').click(function(){
				//set $(this) in a variable to avoid conflict
				var $this = $(this);	
				//find the exact face and make it display:block
				$($this).parent().find('.face3').show();			
				//find whether the faces are already detected or not
				//if not then call the faceDetection() to find the faces
				if(!($($this).hasClass('done'))){
					var coords = $($this).faceDetection({
						complete:function() {
							$($this).addClass('done1');
						}
					});
					
					<?php if($user->id){ ?>
				var imgval= document.getElementById('imag_val3').src;
					
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;

						var upload_dir= document.getElementById("upload_dir3").value;
						//alert(upload_dir);
						var site_url= document.getElementById("site_url3").value;
					var child_img="3";
				$.ajax({
					type:'post',
					url:'ajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
						if(data==1)
						{
						window.location.reload();
						}
						
					}
				})
				
			};
			i.src = imgval;	
					<?} else {?>
					$('#newregimage3').html(''); 
				var imgval= document.getElementById('imag_val3').src;			
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;					
	var upload_dir= document.getElementById("upload_dir3").value;
	var site_url= document.getElementById("site_url3").value;	
	var child_img="3";
				$.ajax({
					type:'post',
					url:'newregajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
				$('#newregimage3').show();
					$('#newregimage3').html('<img src="'+data+'"  style="border:1px solid black;"/>')
					if(data=='Limited Images')
					{
					alert('Limited Images');
					$('#newregimage3').hide();
					}
					if(data=='Please Select Images'){
					alert('Please Select Images');
					$('#newregimage3').hide();
					}
					if(data=='New Register'){
					alert('New Register');
					$('#newregimage3').hide();
					}
											
					}
				})
			};
			i.src = imgval;	
			
			<?}?>
					
					
				}
			}) 
			
			//4th photo
			//when you hover on a photo
			$('.findface4').click(function(){
				//set $(this) in a variable to avoid conflict
				var $this = $(this);	
				//find the exact face and make it display:block
				$($this).parent().find('.face4').show();			
				//find whether the faces are already detected or not
				//if not then call the faceDetection() to find the faces
				if(!($($this).hasClass('done'))){
					var coords = $($this).faceDetection({
						complete:function() {
							$($this).addClass('done1');
						}
					});
					
					<?php if($user->id){ ?>
				var imgval= document.getElementById('imag_val4').src;
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;

						var upload_dir= document.getElementById("upload_dir4").value;
						//alert(upload_dir);
						var site_url= document.getElementById("site_url4").value;
					var child_img="4";
				$.ajax({
					type:'post',
					url:'ajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
						if(data==1)
						{
						window.location.reload();
						}
						
					}
				})
			};
			i.src = imgval;		
					
					
					<?} else {?>
					$('#newregimage4').html(''); 
				var imgval= document.getElementById('imag_val4').src;			
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;					
	var upload_dir= document.getElementById("upload_dir4").value;
	var site_url= document.getElementById("site_url4").value;	
	var child_img="4";
				$.ajax({
					type:'post',
					url:'newregajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
				$('#newregimage4').show();
					$('#newregimage4').html('<img src="'+data+'"  style="border:1px solid black;"/>')
					if(data=='Limited Images')
					{
					alert('Limited Images');
					$('#newregimage4').hide();
					}
					if(data=='Please Select Images'){
					alert('Please Select Images');
					$('#newregimage4').hide();
					}
					if(data=='New Register'){
					alert('New Register');
					$('#newregimage4').hide();
					}
											
					}
				})
				};
			i.src = imgval;	
					<?}?>
					
					
				}
			}) 
			
			//5th photo
			//when you hover on a photo
			$('.findface5').click(function(){
				//set $(this) in a variable to avoid conflict
				var $this = $(this);	
				//find the exact face and make it display:block
				$($this).parent().find('.face5').show();			
				//find whether the faces are already detected or not
				//if not then call the faceDetection() to find the faces
				if(!($($this).hasClass('done'))){
					var coords = $($this).faceDetection({
						complete:function() {
							$($this).addClass('done1');
						}
					});
					
					<?php if($user->id){ ?>
				var imgval= document.getElementById('imag_val5').src;
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;

						var upload_dir= document.getElementById("upload_dir5").value;
						//alert(upload_dir);
						var site_url= document.getElementById("site_url5").value;
					var child_img="5";
				$.ajax({
					type:'post',
					url:'ajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
						if(data==1)
						{
						window.location.reload();
						}
						
					}
				})
				};
			i.src = imgval;	

			<?} else {?>
					$('#newregimage5').html(''); 
				var imgval= document.getElementById('imag_val5').src;			
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;					
	var upload_dir= document.getElementById("upload_dir5").value;
	var site_url= document.getElementById("site_url5").value;	
	var child_img="5";
				$.ajax({
					type:'post',
					url:'newregajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
				$('#newregimage5').show();
					$('#newregimage5').html('<img src="'+data+'"  style="border:1px solid black;"/>')
					if(data=='Limited Images')
					{
					alert('Limited Images');
					$('#newregimage5').hide();
					}
					if(data=='Please Select Images'){
					alert('Please Select Images');
					$('#newregimage5').hide();
					}
					if(data=='New Register'){
					alert('New Register');
					$('#newregimage5').hide();
					}
											
					}
				})
					};
			i.src = imgval;	
			<?}?>
					
					
				}
			}) 
			
			//6th photo
			//when you hover on a photo
			$('.findface6').click(function(){
				//set $(this) in a variable to avoid conflict
				var $this = $(this);	
				//find the exact face and make it display:block
				$($this).parent().find('.face6').show();			
				//find whether the faces are already detected or not
				//if not then call the faceDetection() to find the faces
				if(!($($this).hasClass('done'))){
					var coords = $($this).faceDetection({
						complete:function() {
							$($this).addClass('done1');
						}
					});
					
					<?php if($user->id){ ?>
				var imgval= document.getElementById('imag_val6').src;
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;

						var upload_dir= document.getElementById("upload_dir6").value;
						//alert(upload_dir);
						var site_url= document.getElementById("site_url6").value;
					var child_img="6";
				$.ajax({
					type:'post',
					url:'ajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
						if(data==1)
						{
						window.location.reload();
						}
						
					}
				})
			};
			i.src = imgval;	
					<?php } else {?>
					$('#newregimage6').html(''); 
				var imgval= document.getElementById('imag_val6').src;			
				var i = new Image(); 
				i.onload = function(){
				var imgh = i.height;
				var imgw = i.width;	
				
				var img_width = imgw;
				var img_height = imgh;					
	var upload_dir= document.getElementById("upload_dir6").value;
	var site_url= document.getElementById("site_url6").value;	
	var child_img="6";
				$.ajax({
					type:'post',
					url:'newregajaximagechild.php',
					data:{'imgval':imgval,'upload_dir':upload_dir,'site_url':site_url,'img_width':img_width,'img_height':img_height,'child_img':child_img},
					success:function(data){
				$('#newregimage6').show();
					$('#newregimage16').html('<img src="'+data+'"  style="border:1px solid black;"/>')
					if(data=='Limited Images')
					{
					alert('Limited Images');
					$('#newregimage6').hide();
					}
					if(data=='Please Select Images'){
					alert('Please Select Images');
					$('#newregimage6').hide();
					}
					if(data=='New Register'){
					alert('New Register');
					$('#newregimage6').hide();
					}
											
					}
				})
				};
			i.src = imgval;		
					<?}?>
					
					
				}
			}) 
			
			
			
		});
		})(jQuery);
	</script>

<script type="text/javascript" src="<?php echo $template.'/'; ?>photovalidation/scripts/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $template.'/'; ?>photovalidation/scripts/jquery.form.js"></script>
<?php if($user->id){ ?>

<?php }
else{?>

<?php }?><!--end photo validation-->
		
		
		<?php 			if($user->id){
				?>
				<script>
					jQuery.noConflict();
(function($) {
	$(document).ready(function() 
 {
	var useridval= document.getElementById('useridval').value;
	//alert(useridval);
	var sound_test=0;
	
	setInterval(function(){
	$.ajax({
	
					type:'post',
					url:'ajaxchatMessge.php',
					data:{'useridval':useridval,'cht_count':sound_test},
					success:function(data_val_ajax){
					var data_val = $.trim(data_val_ajax);
					// var data_success = data_val.split(",");
						//console.log(data_val);
						//console.log(data_success[1]);
						//if(data_val >= '0'){
						//if((sound_test != data_val) && (sound_test !='0')){
						if(data_val > 0){						
						if((sound_test != data_val) && (sound_test !=0)  && (data_val >0)){
						//alert('test1');
						$('#alert_box_chat').show();
						var audio = new Audio('sound/notify.mp3');
audio.play();
						}
						sound_test = data_val;
						$('#chatbox_val').show();	
						
						//$('#alert_box_chat').show();
						$(".result_data").html(data_val);
						
						$(".result1_data").html(data_val);
						
						
						$(".result_menu_data").html(data_val);
						
						
						//alert(sound_test);
						}
else {
$(".result_data").html(data_val);
						$(".result1_data").html(data_val);
						
							$(".result_menu_data").html('0');
						
$('#alert_box_chat').hide();
}	
						}
						
						
					

				})
	}, 1500);
	$('#alert_box_chat').hide();
	})
	})(jQuery);
				</script>
<link href="<?php echo $template.'/'; ?>css/carousel/owl.carousel.css" rel="stylesheet">
<link href="<?php echo $template.'/'; ?>css/carousel/owl.theme.css" rel="stylesheet">
<!-- Animation CSS -->
<link href="<?php echo $template.'/'; ?>css/carousel/wedding-font-styles.css" rel="stylesheet">
		<?php 			}
				?>
		<!--<link href="<?php // echo $template.'/'.SITE_TEMPLATE.'_old(30-1-17).css?'.$version; ?>" rel="stylesheet" type="text/css" />-->
		<?php
			/*if($_GET['lang']!="fr"){
				?>
					<link href="<?php echo $template.'/'.SITE_TEMPLATE.'.'.$_GET['lang'].'.css'; ?>" rel="stylesheet" type="text/css" />
				<?php
			}*/
		?>
		<link href="<?php echo $template; ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		
		<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfobject/swfobject.js"></script>
		<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/lightbox/lightbox.js"></script>
		<?php 			if($app == 'home') {
			
		?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_home.js?<?php echo $version; ?>"></script>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfobject/swfobject.js"></script>
		<?php 			
			} elseif($app == 'profil') {
			?>

				<?php if(in_array($action, array('step2', 'step2submit', 'step5', 'step5submit'))) {
					/*if ($_GET["lang"]!="fr") {
						//echo $_GET["lang"];
						$jsUpExt = "-".$_GET["lang"];
					} else {
						$jsUpExt = "";
					}*/
					?>
					<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload<?php /*echo $jsUpExt;*/ ?>/swfupload.js"></script>
					<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload<?php /*echo $jsUpExt;*/ ?>/js/handlers.js?<?php echo $version; ?>"></script>
					<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/js/swfupload<?php /*echo $jsUpExt;*/ ?>/default.css">
				<?php }?>

				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_profil.js?<?php echo $version; ?>"></script>

				<?php if($action == 'step6') { ?>
					<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_search.js"></script>
				<?php } ?>

			<?php 			} elseif($app == 'search') {
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_search.js"></script>
			<?php 			} elseif($app == 'message') {
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_message.js?<?php echo $version; ?>"></script>

			<?php 			} elseif($app == 'redac') {
			?>
				
			<?php 			} elseif($app == 'groupe' && in_array($action, array('edit', 'save'))) {
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_groupe.js"></script>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload/swfupload.js"></script>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/swfupload/js/handlers.js?<?php echo $version; ?>"></script>
				<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>/js/swfupload/default.css">
			<?php 			}
			if($app == 'inviter'){
			?>
				<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/app_inviter.js"></script>
			<?php 			}
			//Head pub Goldbach
			/*if($_GET['lang']!="de"){
				?>
				<script type="text/javascript">
var setgbprotocoll = 'https:' == document.location.protocol;
var setgbprotocoll = (setgbprotocoll ? 'https:' : 'http:');
var setgbnuggn = "2137767787";
var setgbnuggsid = "37003039";
var setgbnuggtg = "RUNOFSITE";
if(typeof(setgbscriptloaded) == 'undefined'){setgbscriptloaded = false;}
if (!setgbscriptloaded){
document.write('<scr'+'ipt type="text/javascript" src='+setgbprotocoll+'//goldbach-targeting.ch/display/gbtargeting.js></scr'+'ipt>');
}
</script>

<script type='text/javascript'>
if(setgbasync){
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + 
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
}
else{
(function() {
var useSSL = 'https:' == document.location.protocol;
var src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
})();
}
</script>

<script type='text/javascript'>
if(setgbasync){
googletag.cmd.push(function() {
for (var key in setgbtargetingobj) {
googletag.pubads().setTargeting(key, setgbtargetingobj[key].toString());
}
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().collapseEmptyDivs();
googletag.enableServices();
});
}
else{
for (var key in setgbtargetingobj) {
googletag.pubads().setTargeting(key, setgbtargetingobj[key].toString());
}
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_solocircl.com_EX/ROS-excl-Homepage/FR_ROS-excl-Home_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().enableSyncRendering();
googletag.enableServices();
}
</script>
				<?php
			}else{
				?>
				<script type="text/javascript">
var setgbprotocoll = 'https:' == document.location.protocol;
var setgbprotocoll = (setgbprotocoll ? 'https:' : 'http:');
var setgbnuggn = "2137767787";
var setgbnuggsid = "312300076";
var setgbnuggtg = "RUNOFSITE";
if(typeof(setgbscriptloaded) == 'undefined'){setgbscriptloaded = false;}
if (!setgbscriptloaded){
document.write('<scr'+'ipt type="text/javascript" src='+setgbprotocoll+'//goldbach-targeting.ch/display/gbtargeting.js></scr'+'ipt>');
}
</script>

<script type='text/javascript'>
if(setgbasync){
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + 
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
}
else{
(function() {
var useSSL = 'https:' == document.location.protocol;
var src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
})();
}
</script>

<script type='text/javascript'>
if(setgbasync){
googletag.cmd.push(function() {
for (var key in setgbtargetingobj) {
googletag.pubads().setTargeting(key, setgbtargetingobj[key].toString());
}
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().collapseEmptyDivs();
googletag.enableServices();
});
}
else{
for (var key in setgbtargetingobj) {
googletag.pubads().setTargeting(key, setgbtargetingobj[key].toString());
}
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbldbSizes, 'leaderboard').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbskySizes, 'skyscraper').addService(googletag.pubads());
googletag.defineSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', setgbrecSizes, 'content').addService(googletag.pubads());
googletag.defineOutOfPageSlot('8373/CH/Helvetica-Media/CH_Singleltern.ch_EX/ROS-excl-Homepage/DE_ROS-excl-Home_allAdformats', 'outofpage').addService(googletag.pubads());
googletag.pubads().enableSyncRendering();
googletag.enableServices();
}
</script>
				<?php
			}  */
			
		
		?>
		<style>
		


.page-container.sidebar-collapsed {
  /* padding-right: 65px; */
  transition: all 100ms linear;
  transition-delay: 300ms;
}

.page-container.sidebar-collapsed-back {
  padding-right: 250px;
  transition: all 100ms linear;
}

.page-container.sidebar-collapsed .sidebar-menu {
  width: 65px;
  transition: all 100ms ease-in-out;
  transition-delay: 300ms;
}

.page-container.sidebar-collapsed-back .sidebar-menu {
  width: 100%;
  transition: all 100ms ease-in-out;
}

.page-container.sidebar-collapsed .sidebar-icon {
  transform: rotate(90deg);
  transition: all 300ms ease-in-out;
}

.page-container.sidebar-collapsed-back .sidebar-icon {
  transform: rotate(0deg);
  transition: all 300ms ease-in-out;
}

.page-container.sidebar-collapsed .logo {
  padding: 21px;
     height: 70px;
  box-sizing: border-box;
  transition: all 100ms ease-in-out;
  transition-delay: 300ms;
}

.page-container.sidebar-collapsed-back .logo {
  width: 100%;
  padding: 21px;
  height: 66px;
  box-sizing: border-box;
  transition: all 100ms ease-in-out;
}

.page-container.sidebar-collapsed #logo {
  opacity: 0;
  transition: all 200ms ease-in-out;
}

.page-container.sidebar-collapsed-back #logo {
  opacity: 1;
  transition: all 200ms ease-in-out;
  transition-delay: 300ms;
}

.page-container.sidebar-collapsed #menu span {
  opacity: 0;
  transition: all 50ms linear;
  display:none;
}

.page-container.sidebar-collapsed-back #menu span {
  opacity: 1;
  transition: all 200ms linear;
  transition-delay: 300ms;
  padding-top:3px;
}

.sidebar-menu {
  position: absolute; 
  /*margin-top: 40px;*/
  float: left;
  /*width: 280px;
   top: 19%;  bottom: 0;*/
  left: 0;

  background-color: #b90003;
  color: #aaabae;
  font-family: "Segoe UI";
  /* box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5); */
  z-index: 6;
}

#menu {
  list-style: none;
  margin: 0;
  padding: 0;
  margin-bottom: 20px;
}

#menu li {
  position: relative;
  margin: 0;
  font-size: 12px;
  border-bottom: 1px solid rgb(152, 9, 9);
  padding: 0;
}

#menu li ul {
  opacity: 0;
  height: 0px;
}

#menu li a {
	font-size:15px;
  font-style: normal;
  font-weight: 400;
  position: relative;
  display: block;
  padding: 15px 20px;
  color: #ffffff;
  white-space: nowrap;
  z-index: 6;
}

#menu li ul li a
{
	padding: 10px 20px;;
}

#menu li a:hover {
  color: #ffffff;
  background-color: #4a4a40;
  transition: color 250ms ease-in-out, background-color 250ms ease-in-out;
}

#menu li.active > a {
  background-color: #2b303a;
  color: #ffffff;
}

#menu ul li { background-color: #2b303a; }

#menu ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

#menu li ul {
  position: absolute;
  visibility: hidden;
  left: 100%;
  top: -1px;
  background-color: #2b303a;
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
  opacity: 0;
  transition: opacity 0.1s linear;
  border-top: 1px solid rgba(69, 74, 84, 0.7);
}

#menu li:hover > ul {
  visibility: visible;
  opacity: 1;
}

#menu li li ul {
  left: 100%;
  visibility: hidden;
  top: -1px;
  opacity: 0;
  transition: opacity 0.1s linear;
}

#menu li li:hover ul {
  visibility: visible;
  opacity: 1;
}

#menu li i
{
	font-size:20px;
}

#menu .fa {    margin-right: 10px;    margin-top: 4px; }

.sidebar-menu .logo a:hover{
	color: #ffffff !important;
    text-shadow: none;
}
.sidebar-menu .logo a{
	color: #ffffff !important;
    text-shadow: none;
}
.sidebar-icon {
  position: relative;
  float: right;
  border: 1px solid #fff;
  text-align: center;
  line-height: 1;
  font-size: 18px;
  padding: 6px 8px;
  border-radius: 3px;
  color: #fff;
  background-clip: padding-box;
  text-shadow: 4px 4px 6px rgba(0,0,0,0.4);
}
.chatbox_alert_stl{    top: 280px;
    right: 2px;
    position: fixed;
    z-index: 22;
    cursor: pointer;
    background: rgba(0, 0, 0, 0.85) !important;
    color: #fff;
    padding: 10px 15px;
    border-radius: 10px;}
.chat_box_alt{
top: 160px;right: 10px;position: fixed;z-index: 22;color: #fff;font-size: 13px;background: #949494 !important;padding: 10px 10px;border-radius: 5px;
}
@keyframes blink {
  50% {
    opacity: 0.0;
  }
}
@-webkit-keyframes blink {
  50% {
    opacity: 0.0;
  }
}
.result_data {
  animation: blink 1s step-start 0s infinite;
  -webkit-animation: blink 1s step-start 0s infinite;
}
.result1_data {
  animation: blink 1s step-start 0s infinite;
  -webkit-animation: blink 1s step-start 0s infinite;
}




.sidenav {
    height: 100%;
    width: 0;
       position: absolute;
    z-index:9999;
    top: 0;
    left: 0;
    background-color: #b90003;
   /*  overflow-x: hidden; */
    transition: 0.5s;
    padding-top: 60px;
}


.sidenav a:hover, .offcanvas a:focus{
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 25px;
    margin-left: 50px;
}

#main {
    transition: margin-left .5s;
    padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}/* 
   #loading_div{ /* padding-top: 20%; */
    background-color: #fff;
    display: block;
    width: 100%;
    height: 100%;
    position: fixed;
    z-index: 999999;
	}
	 #loading_div img{
	 margin-top:10%;
	 } */
</style>
<script language="javascript" type="text/javascript">
		var timerPaypal;	
function doHide(){
document.getElementById("loading_div").style.display = "none";
document.getElementById("cupid_status").style.display = "none";
//document.getElementById("btn_hide").style.display = "none";
document.getElementById("display_msg").style.display = "block";
clearInterval(timerPaypal);
}
function doShow()
{ 
//alert('test');
document.getElementById("loading_div").style.display = "block";
document.getElementById("display_msg").style.display = "none";
//document.getElementById("btn_hide").style.display = "none";
document.getElementById("cupid_status").style.display = "block";
timerPaypal =setInterval("doHide()", 9000);
};
function cupidShow()
{
//alert('divshow');
document.getElementById("loading_div").style.display = "block";
document.getElementById("loading_img").style.display = "none";
document.getElementById("cupid_status").style.display = "block";
timerPaypal=setInterval("doHide()", 5000);
};
				</script>
<meta name="google-site-verification" content="l0QZ_G3Cy1afhTJo_SOXnZzjl9RIUP6h44hl7exTDl4" />
</head>

	<body>
	<div class="Dboot-preloader text-center">
    <img src="<?php echo SITE_URL;?>/chat2/templates/img/loader.gif" width="400"/>
</div>
<!-- Modal -->
  
    <?php /*
		<script type="text/javascript">
			var WlWebsiteId="solocircl.com";
			var WlContentGroup="Default";
			var WlAC= true;
			document.write('<scr'+'ipt language="JavaScript" src="http://rc.ch.adlink.net/Tag/adlink/JS/Ch/'+WlWebsiteId+'/Gt.js"></scr'+'ipt>');
		</script>       */ ?>
		
		<div class="page" id="res_Menu_id" >
        
        <?php 			//   JL::loadApp('mainlink');
		?>
        <div class="content">
            <div class="content_inner">
			<?php  JL::loadApp('head'); ?>
				<div class="content1" <?php if($user->id){ echo "style='background: #b90003;'"; } ?>>
					<div class="<?php if($user->id){ } else { echo 'shell'; }?> text-left">
				<?php 							if($user->id){
?>								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 hidden-xs  hidden-sm">
<?php 						JL::loadMod('menu');
							
						?>
					</div>
					<div class="hidden-md  hidden-lg">
					<?php 					JL::loadMod('menu');
					?>
					</div>
					<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 parentsolo_shadow">
						<div class="col-lg-9   parentsolo_pt_15">
						<?php 						JL::loadMod('menu_offline');	
						?>
						<?php 						JL::loadBody();
						?>
						</div>
					<?}
					else{
						?>
					<div class="col-lg-12 parentsolo_shadow">
						<div class="col-lg-9   parentsolo_pt_15">
						<?php 						JL::loadMod('menu_offline');	
						?>
						<?php 						JL::loadBody();
						?>
						</div>
					<?php 					}
					?>
					<div class="col-lg-3"> 
						<?php JL::loadMod('menu_right'); ?>
					</div>
					</div></div>
					<div style="clear:both"> </div>
				</div>
				<div class="hidden-xs">
				<div class="chatbox_alert_stl" id="alert_box_chat" style="display:none !important; text-align:center; background:rgba(0, 0, 0, 0) !important;    top: 160px;" onClick="windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&'.$langue); ?>','800px','600px');">
				<!--<embed src='sound/notify.mp3' autostart='false' width='0' height='0' id='sound1' enablejavascript='true'>-->
				
				<i class="fa fa-heart" style="font-size: 140px;    color: #f00;"></i><span style="position: absolute;  left: 60px;  margin-top: 45px;  z-index: 24;  font-size: 14px;"><span class="result_data"></span> 
<?php if($_GET["lang"]=="en"){ echo "New <br>Message"; }?>
				<?php if($_GET["lang"]=="de"){ echo " Neue <br>Nachricht";  }?>
				<?php if($_GET["lang"]=="fr") { echo "Nouveau <br>Message "; }?>
				</span>	</div></div>
				<div id="chatbox_val" style="display:none;"><div class="chatbox_alert_stl" onClick="windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&'.$langue); ?>','800px','600px');"><span class="result_data"></span> 
							<i class="fa fa-comments"></i></div></div>
							
						<div class="chatAlert" id="chatAlert1"  onClick="windowOpen('ParentSoloChat','<?php echo JL::url('index.php?app=chat&'.$langue); ?>','800px','600px');"></div></div>
			<?php
						JL::loadMod('footer'); 
						
						if($user->id) {
							?>
							<form><input type="hidden" id="useridval" name="useridval" value="<?php echo $user->id;?>"/></form>
							
		</div></div></div></div></div>
		<script src="<?php echo $template.'/'; ?>new_style/js/jquery.js"></script>
<script src="<?php echo $template.'/'; ?>photovalidation/bootstrap/dist/js/bootstrap.min.js"></script>		
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/flipclock/flipclock.js"></script>
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/smoothscroll/smoothscroll.js"></script>
   <!-- --photo validation---->
<script src="<?php echo $template.'/'; ?>photovalidation/robocrop/robocrop.demo.js"></script>
<script src="<?php echo $template.'/'; ?>photovalidation/demo.js"></script>    
 <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/fancybox/jquery.fancybox.js"></script>
    <script src="<?php echo $template.'/'; ?>new_style/js/plugins/owl/owl.carousel.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/custom.js"></script>
   <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/bootstrap-toggle.js"></script>
<script>
    jQuery.noConflict();
(function($) {	
	$(window).load(function() {
        $('.Dboot-preloader').addClass('hidden');
    });
	})(jQuery);
</script>
						<script>
					
	function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
	jQuery.noConflict();
(function($) {	
$(".open_cls_main_1").click(function() {
if (toggle){	$(".open_cls_1").addClass("in");	}
else { $(".open_cls_1").removeClass("in"); }	 
 toggle = !toggle;
});

$(".open_cls_main_2").click(function() {
if (toggle){	$(".open_cls_2").addClass("in");	}
else { $(".open_cls_2").removeClass("in"); }	 
 toggle = !toggle;
});

$(".open_cls_main_3").click(function() {
if (toggle){	$(".open_cls_3").addClass("in");	}
else { $(".open_cls_3").removeClass("in"); }	 
 toggle = !toggle;
});

$(".open_cls_main_4").click(function() {
if (toggle){	$(".open_cls_4").addClass("in");	}
else { $(".open_cls_4").removeClass("in"); }	 
 toggle = !toggle;
});

$(".open_cls_main_5").click(function() {
if (toggle){	$(".open_cls_5").addClass("in");	}
else { $(".open_cls_5").removeClass("in"); }	 
 toggle = !toggle;
});

$(".open_cls_main_6").click(function() {
if (toggle){	$(".open_cls_6").addClass("in");	}
else { $(".open_cls_6").removeClass("in"); }	 
 toggle = !toggle;
});
$(".open_cls_main_7").click(function() {
if (toggle){	$(".open_cls_7").addClass("in");	}
else { $(".open_cls_7").removeClass("in"); }	 
 toggle = !toggle;
});
$(".open_cls_main_8").click(function() {
if (toggle){	$(".open_cls_8").addClass("in");	}
else { $(".open_cls_8").removeClass("in"); }	 
 toggle = !toggle;
});
							
							
							
						var w = window.innerWidth;
					
var toggle = true;
			 if (w < 992) { 
//alert('test');			 
$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");			 
			$(".sidebar-icon").click(function() {     
           
			if (toggle)
			{
			$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
				$("#menu span").css({"position":"absolute"});
			  }
			  else
			  {
$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
				setTimeout(function() {
				  $("#menu span").css({"position":"relative"});
				}, 400);
			  }
						
						toggle = !toggle;
		});
	}
	else { 
	$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
	$(".sidebar-icon").click(function() {                
			if (toggle)
			{
			// alert('hi');
			 $(".page-container").removeClass("sidebar-collapsed-back").addClass("sidebar-collapsed");
				$("#menu span").css({"position":"absolute"});
			  }
			  else
			  {			 
				$(".page-container").addClass("sidebar-collapsed-back").removeClass("sidebar-collapsed");
				setTimeout(function() {
				  $("#menu span").css({"position":"relative"});
				}, 400);
			  }
						
						toggle = !toggle;
		});
			
		}	

		
		})(jQuery);
	/*	

 *var toggle = true;
            
$(".sidebar-icon").click(function() {                
  if (toggle)
  {
    $(".page-container").addClass("sidebar-collapsed-back").removeClass("sidebar-collapsed");
    $("#menu span").css({"position":"absolute"});
  }
  else
  {
    $(".page-container").removeClass("sidebar-collapsed-back").addClass("sidebar-collapsed");
    setTimeout(function() {
      $("#menu span").css({"position":"relative"});
    }, 400);
  }
                
                toggle = !toggle;
            });*/
</script>
						<script src="<?php echo $template.'/'; ?>js/carousel/owl.carousel.js"></script>
    <!-- Theme JS -->
    <script>
	// Friend Section Carousel

jQuery.noConflict();
(function($) {
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
	$("#owl-demo").owlCarousel({
		items : 5,
		itemsDesktop : [1199,3],
		pagination:false,
		lazyload:false,
		navigation : true,
		navigationText : ["", ""],
	});
	})(jQuery);
	
	</script>
	   

<!--end photo validation-->
<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/mootools.js?<?php echo $version; ?>"></script>
						<?php 					
					}
					
						// charge le module de message d'alerte de derneirs &eacute;v&eacute;nements(popin)
						JL::loadMod('popin_last_event');
						JL::loadMod('popin_chat_alert');
?><?php 					if($app=='profil'&& $action=='finalisation'){
						if($_GET["lang"]=="fr" || $_GET["lang"]==""){
						?>
							<!-- Google Code for Inscription FR Conversion Page -->
							<script type="text/javascript">
							/* <![CDATA[ */
							var google_conversion_id = 965465621;
							var google_conversion_language = "fr";
							var google_conversion_format = "3";
							var google_conversion_color = "ffffff";
							var google_conversion_label = "";
							var google_remarketing_only = false;
							/* ]]> */
							</script>
							<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
							</script>
							<noscript>
							<div style="display:inline;">
							<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/965465621/?label=&amp;guid=ON&amp;script=0"/>
							</div>
							</noscript>
						<?php 						}
						if($_GET["lang"]=="en"){
						?>
							<!-- Google Code for Inscription EN Conversion Page -->
							<script type="text/javascript">
							/* <![CDATA[ */
							var google_conversion_id = 965465621;
							var google_conversion_language = "en";
							var google_conversion_format = "3";
							var google_conversion_color = "ffffff";
							var google_conversion_label = "";
							var google_remarketing_only = false;
							/* ]]> */
							</script>
							<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
							</script>
							<noscript>
							<div style="display:inline;">
							<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/965465621/?label=&amp;guid=ON&amp;script=0"/>
							</div>
							</noscript>
						<?php 						}
						if($_GET["lang"]=="de"){
						?>
							<!-- Google Code for Inscription DE Conversion Page -->
							<script type="text/javascript">
							/* <![CDATA[ */
							var google_conversion_id = 965465621;
							var google_conversion_language = "de";
							var google_conversion_format = "3";
							var google_conversion_color = "ffffff";
							var google_conversion_label = "";
							var google_remarketing_only = false;
							/* ]]> */
							</script>
							<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
							</script>
							<noscript>
							<div style="display:inline;">
							<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/965465621/?label=&amp;guid=ON&amp;script=0"/>
							</div>
							</noscript>
						<?php 						}
					} 
				?>
						<script type="text/javascript">
						var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
						document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
						</script>
						<script type="text/javascript">
						try {
						var pageTracker = _gat._getTracker("UA-6463477-2");
						pageTracker._trackPageview();
						} catch(err) {}</script>
				</div>
		<?php if(!$user->id) {
							?>
			<!--<script src="<?php echo $template.'/'; ?>js/core.min.js"></script>
			<script src="<?php echo $template.'/'; ?>js/script.js"></script>-->
			<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			<script src="<?php echo $template.'/'; ?>photovalidation/bootstrap/dist/js/bootstrap.min.js"></script>-->
					<script src="<?php echo $template.'/'; ?>new_style/js/jquery.js"></script>
					<script src="<?php echo $template.'/'; ?>photovalidation/bootstrap/dist/js/bootstrap.min.js"></script>
					<script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/flipclock/flipclock.js"></script>
					<script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/smoothscroll/smoothscroll.js"></script>
    <!--photo validation-->
					<script src="<?php echo $template.'/'; ?>photovalidation/robocrop/robocrop.demo.js"></script>
					<script src="<?php echo $template.'/'; ?>photovalidation/demo.js"></script>
    <!-- REVOLUTION JS FILES -->
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/plugins/fancybox/jquery.fancybox.js"></script>
    <script src="<?php echo $template.'/'; ?>new_style/js/plugins/owl/owl.carousel.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="<?php echo $template.'/'; ?>new_style/js/custom.js"></script>
   <script>
    jQuery.noConflict();
(function($) {	
	$(window).load(function() {
        $('.Dboot-preloader').addClass('hidden');
    });
	})(jQuery);
</script>
   <script>
				jQuery.noConflict();
(function($) {
	
var toggle = true;
            
$(".sidebar-icon").click(function() {                
  if (toggle)
  {
    $(".page-container").addClass("sidebar-collapsed-back").removeClass("sidebar-collapsed");
    $("#menu span").css({"position":"absolute"});
	
  }
  else
  {
    $(".page-container").removeClass("sidebar-collapsed-back").addClass("sidebar-collapsed");
    setTimeout(function() {
      $("#menu span").css({"position":"relative"});
	  
    }, 400);
  }
                
                toggle = !toggle;
            });
})(jQuery);
</script>


			
<script type="text/javascript" src="<?php echo SITE_URL; ?>/js/mootools.js?<?php echo $version; ?>"></script>
<?php } ?>
	</body>

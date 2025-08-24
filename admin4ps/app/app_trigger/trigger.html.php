
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <style>
 #txt_notification{
 font-size:15px;
padding-top:8px;
 }
 </style>
 <?php
defined('JL') or die('Error 401');
class mail_HTML
{
public static function initialload(){
?>
<script>

function cancelsubmit(action) {
						
						var form = document.listForm;
						var ok = true;
						
						
						 if(action == 'Fermer') {
							if(!confirm('Êtes-vous sûr de vouloir Fermer?')) {
								ok = false;
								
							}
						}
						
						if(ok) {
						
							document.location = "<? echo SITE_URL_ADMIN; ?>"; 
						}
						
					}
$(document).ready(function(){
$('#sel_notification').change(function(){
var notifi=$('#sel_notification').val();
if(notifi==0)
{
$('#send').removeAttr('disabled','disabled');

}
});
$('#send').click(function(){
var notification=$('#sel_notification').val();
if(notification==1){
window.location.href='app/app_trigger/triggermailphoto.php';
$('#send').attr('disabled','disabled');
}
if(notification==2)
{
window.location.href='app/app_trigger/triggermail.php';
$('#send').attr('disabled','disabled');
}
});
					
					});	
</script>
<section class="panel">
                  <header class="panel-heading">
                     <h2>Notification</h2>
                  </header>
				
				<div class="row">
                  <div class="col-lg-12">				
					<div class="toolbar">
					<a href="javascript:cancelsubmit('Fermer')" title="Fermer" class="btn btn-success">Fermer</a>
				</div>
				
			</div>
		</div>
		<div class="form-group row parentsolomobealign">
		<label name="txt_notification" id="txt_notification" class="col-sm-2">Select a Notification:</label>
		<div class="col-sm-3">
		<select name="sel_notification" id="sel_notification" class="form-control">
		<option value="0">Select</option>
		<option value="1">Uploading Photos</option>
		<option value="2">Inactive users</option>
		</select>
		</div>
		</div>
		<div class="form-group row sendresp" style="text-align:center;">
		<input type="button" class="send btn btn-success" name="send" id="send" value="Send">
		</div>
		</section>
<?
}
}
?>

   
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
  .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default{
  border: 1px solid #c5c5c5 !important;
    background: #f6f6f6 !important;
    font-weight: normal !important;
    color: #454545 !important;
	 border-radius: 0px !important;
    -webkit-border-radius:0px !important;
  }
  
  </style>
<?php

	// sécurité
	defined('JL') or die('Error 401');
	class table_HTML {	
	
	
 public static function gettable(&$eventdetails,&$search) {
global $user;
$i 				= 0; // compteur de tr
			$td 			= 0; // compteur de td
			$tdParTr		= 4; // nombre de td par ligne
			$rayon 			= 5;
			$debut			= ($search['page'] - $rayon) >= 1 ? $search['page'] - $rayon : 1;
			$fin			= ($search['page'] + $rayon) <= $search['page_total'] ? $search['page'] + $rayon : $search['page_total'];
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
			</script>
<section class="panel">
<div class="eventtable">
                  <header class="panel-heading head">
                     <h2>Events</h2>
                  </header> 
				<div class="row" >
                  <div class="col-lg-12">				
					<div class="toolbar">
					
				</div>
				
			</div>
		</div>
				  
				 <div class="parentadmintab">
				  <table id="event_table" cellpadding="0" cellspacing="0"class="table table-bordered table-striped table-condensed cf lister" style="text-align: center;">
				  <tr>
				  <th>Title</th>
				  <th>Description</th>
				  <th>Start Date</th>
				  <th>End Date</th>
				  <th>Edit/Delete</th>
				  </tr>
			
						
						
				 <? 
						foreach($eventdetails as $contenu) { 
							if(strlen($contenu->event_desc) > LISTE_INTRO_CHAR) {
										
										$contenu->event_desc = substr($contenu->event_desc, 0, 100).'...';
									}
									if(strlen($contenu->event_name) > LISTE_INTRO_CHAR) {
										
										$contenu->event_name = substr($contenu->event_name, 0, 100).'...';
									}
	
							?>
							<tr class="list">
							
							<td style="width:150px;"><?php echo $contenu->event_name ?></td>
							<td style="width:300px;"><?php echo $contenu->event_desc ?></td>
							<td style="width:100px;white-space:nowrap"><?php echo date('d-m-Y',strtotime($contenu->start_date)) ?></td>
							<td style="width:100px;white-space:nowrap"><?php echo date('d-m-Y',strtotime($contenu->end_date ))?></td>
							<td style="width:100px;"><table><tr><div style="cursor:pointer" class="edit fa fa-pencil-square-o" id="edit_<?php echo $contenu->id ?>"></div>&nbsp;&nbsp;&nbsp;&nbsp;<div style="color:red;cursor:pointer" class="delete fa fa-trash-o" id="delete_<?php echo $contenu->id ?>"></div></tr></table></td>
							</tr>
							<?
					}
					?>
				<tr>
							<td colspan="5">
								<b>Pages</b>:
								<? if($debut > 1) {
 
								?> <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=event&search_t_page=1'); ?>" title="Afficher la page 1">D&eacute;but</a> ...<? }?>
								<?
									for($i=$debut; $i<=$fin; $i++) {
									?>
										 <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=event&search_t_page='.$i); ?>" title="Afficher la page <? echo $i; ?>" <? if($i == $search['page']) { ?>class="displayActive"<? } ?>><? echo $i; ?></a>
									<?
									}
								?>
								<? if($fin < $search['page_total']) { ?> ... <a href="<? echo JL::url(SITE_URL_ADMIN.'/index.php?app=event&search_t_page='.$search['page_total']); ?>" title="Afficher la page <? echo $search['page_total']; ?>">Fin</a><? }?> <i>(<? echo $search['result_total']; ?> r&eacute;sultats)</i>
							</td>
						</tr>
				  </table>
				  </div>
				  </div>
				  <input type="hidden" name="search_t_page" value="1" />
					<input type="hidden" name="app" value="temoignage" />
					<input type="hidden" name="action" value="" />
					
				  <div class="col-lg-12" style="text-align:right">
				  <div class="parentsolomobealigfgfdg">
				  <input type="button" class="btn btn-success" name="create" id="create" value="create">
				
					<a href="javascript:cancelsubmit('Fermer')" title="Fermer"?><input type="button" class="btn btn-success" name="close" id="close" value="close"></a>
					</div>
			
				  </div>
				 
				  
				  </section>
				  
<?php
}
}
?>
				<div id="new_event" class="col-sm-12" style="padding-top:10px;" hidden>
				 <form   id="formelement" name="formelement" method="post" enctype="multipart/form-data" action="app/app_event/dbevent.php">

				<header class="panel-heading head2">
                     <h2>Create an Events</h2>
                  </header> 
				<div class="row" >
                  <div class="col-lg-12">				
					<div class="toolbar">
					
				</div>
				
			</div>
			</div>
			
						<div id="updatehead" hidden>

			<header class="panel-heading head3">
                     <h2>Update an Events</h2>
                  </header> 
				<div class="row" >
                  <div class="col-lg-12">				
					<div class="toolbar">
					
				</div>
				
			</div>
		</div>
		</div>
				<div class="form-group row" style="padding-top:40px;" >
                 <label  class="col-sm-2" name="lbl_evt_name">Title<span>*</span></label>
				<div class="col-sm-3">
				<input type="text" name="txt_evt_name" required class="form-control validation updateval" id="txt_evt_name">
				</div>
				</div>
				
<div class="form-group row">
				<label class="col-sm-2" name="lbl_evt_desc">Description<span>*</span></label>
				<div class="col-sm-3">
				<textarea type="text" name="txt_evt_desc" required style="height:100px;" class="form-control validation updateval" id="txt_evt_desc"></textarea>
				</div>
</div>
<div class="form-group row">
				<label class="col-sm-2" name="lbl_evt_sdate">Start Date<span>*</span></label>
				<div class="col-sm-3">
				<input type="text" name="txt_evt_sdate" required  class="form-control validation datepicker updateval" id="txt_evt_sdate">
				</div>
				
</div>
<div class="form-group row">
				<label class="col-sm-2" name="lbl_evt_edate">End Date<span>*</span></label>
				<div class="col-sm-3">
				<input type="text" name="txt_evt_edate" required  class="form-control datepicker validation updateval" id="txt_evt_edate">
				</div>
</div>
<div class="form-group row">
				<label class="col-sm-2" name="lbl_evt_logo">Logo<span>*</span></label>
				<div class="col-sm-3">
				<input type="file" name="txt_evt_logo" required class="validation updateval"   id="txt_evt_logo">	
				<input type="hidden" id="imageid" name="imageid">
				<img  id="event_img" src="#">	
			<input type="hidden" name="rowid"  class="validation updateval" id="rowid">
				<input type="hidden" name="userid"  class="" id="userid" value="<?php echo $user->id ?>">		
				<p><small><?php echo $lang_event["GifPngJpg"];?></small></p>
				</div>
				
</div>
<div class="form-group row" style="text-align:center">
<input type="submit"  name="save" id="save" value="Save" class="btn btn-success">
<input type="submit"  name="update" id="update" value="Update" class="btn btn-success" hidden>
</div>
</form>
				</div>

			
<script>
(function($) {
var userid;
var username;
$(document).ready(function(){

$('#update').hide();
		userid=<?php echo $user->id ?>; 
  $( function() {
    $( ".datepicker" ).datepicker({
	dateFormat: 'dd-mm-yy'
	});
  });
  $.ajax({
     type:"post",
	 url:"app/app_event/dbevent.php",
	 data:{'option':'common'},
	 success:function(data){
var value=$.parseJSON(data);	
var smaxdate=value[0][0];
var emaxdate=value[0][1];
var currectdate=value[0][2];
if(emaxdate=='01-01-1970'){
$('#txt_evt_sdate').datepicker("option","minDate",currectdate);
$('#txt_evt_edate').datepicker("option","minDate",currectdate);

}
else{
$('#txt_evt_sdate').datepicker("option","minDate",emaxdate);
$('#txt_evt_edate').datepicker("option","minDate",emaxdate);
}

	 }
});
	 // CREATE CLICK//
$('#create').on('click',function(){
$('#event_table').hide();
$('.head').hide();
$('#create').hide();
$('#update').hide();
$('#close').hide();
$('#new_event').show();
$('#event_img').hide();

});
 var imgsize;
$('#txt_evt_logo').change(function(e){
var filename1 = $('#txt_evt_logo').val();
$('.progressBarComplete').delay(3).fadeOut();
var ext = filename1.split('.').pop();
imgsize=e.target.files[0].size;
if(ext != "jpg" && ext != "png" && ext != "jpeg"
&& ext != "gif" ) {
alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
$('#save').attr('disabled','disabled');
$('#update').attr('disabled','disabled');
$('#progress').hide();
}
else{
if(imgsize > 1048576 ){
alert("Sorry, File Should not exceed 1 MB");
$('#save').attr('disabled','disabled');
$('#update').attr('disabled','disabled');
}
else{
var filename=e.target.files[0].name;
$('#progress').show();
$('#progressName').html(filename);
$('.progressBarComplete').delay(3).fadeOut();
}

}
});
//validation
$('.validation').change(function(){
var title=$('#txt_evt_name').val();
var desc=$('#txt_evt_desc').val();
var sdate=$('#txt_evt_sdate').val();
var edate=$('#txt_evt_edate').val();
var logo=$('#txt_evt_logo').val();
var extension = logo.split('.').pop();
if(title!='' && desc!='' && sdate!='' && edate!='' && imgsize < 1048576 && (extension == "jpg" || ext == "png" || ext == "jpeg"
|| ext == "gif")){
$('#save').removeAttr('disabled','disabled');
}
else{
//$('#save').attr('disabled','disabled');
//$('#codeverify').show().text(codelang);
}
});
$('.updateval').change(function(){
var logo=$('#txt_evt_logo').val();
var extension1 = logo.split('.').pop();
var imgval=$('#event_img').attr('src');
var extension = imgval.split('.').pop();
if((extension == "jpg" || extension == "png" || extension == "jpeg"
|| extension == "gif" )&&(extension1=='' || extension1=="jpg" || extension == "png" || extension == "jpeg"
|| extension == "gif")){
$('#update').removeAttr('disabled','disabled');

}
});
  //SAVE CLICK//

                                //EDIT CLICK//
var editid;
$('.edit').on('click',function(){
var editvalue=$(this).attr('id');
var splitid=editvalue.split('_');
editid=splitid[1];

$.ajax({
type:"post",
	 url:"app/app_event/dbevent.php",
	 data:{'option':'edit','editid':editid},
	 success:function(data){
	 var value=JSON.parse(data);
	 var id=value[0][0];
	 var evtname=value[0][1];
	 var evtdesc=value[0][2];
	 var sdate=value[0][3];
	 var edate=value[0][4];
	  var photoname=value[0][5];
	 var photonamewdir=value[0][6];
	  $('#rowid').val(id);
	$('#txt_evt_name').val(evtname);
$('#txt_evt_desc').val(evtdesc);
$('#txt_evt_sdate').val(sdate);
$('#txt_evt_edate').val(edate);
$('#txt_evt_logo').html(photonamewdir);
$('#imageid').val(photonamewdir);
$('#event_img').attr('src',photoname);
$('#event_table').hide();
$('.head').hide();
$('.head2').hide();
$('.head3').show();
$('#create').hide();
$('#update').show();
$('#updatehead').show();
$('#save').hide();
$('#close').hide();
$('#new_event').show();
	 }
})

});
                                    //UPDATE CLICK//

                                        //DELETE CLICK//
$('.delete').on('click',function(){
var delvalue=$(this).attr('id');
var delsplitid=delvalue.split('_');
var delid=delsplitid[1];

$.ajax({
type:"post",
	 url:"app/app_event/dbevent.php",
	 data:{'option':'delete','delid':delid},
	 success:function(data){
	 if(data=1)
	 {
	 alert('Deleted succesfully');
	 window.location.reload();
	 }
	 }
});
});
});
})(jQuery);
</script>	
				
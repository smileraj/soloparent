$(document).ready(function() {
		
	$('#do_visite').click(function() {
		
		$('#do_visite').attr('disabled','disabled');
		 
		$("#action").val("visits");
		
		var val = [];
		var val_from_id = [];
		
		$(":checkbox:checked").each(function(i){
	      val[i] = $(this).val();
	      val_from_id[i] = $(this).parent().parent().children("td:eq(3)").find(".list").val();
	    	//$(this).parent().parent().children("td:eq(3)").css("background-color", "red") ;
	    	//$(this).parent().parent().children("td:eq(3)").find(".list").toggle();
			//alert($(this).parent().parent().children("td:eq(3)").find(".list").val());
	    });
	    	      
		$.post("lib/lib.php",
			{
				action: $("#action").val()
				, arr:val
				, arr_id:val_from_id
				//, arr_id:{"1":$("#id-19").val()}
			}
			,
			function(result){
				$("#result").html( result );
				//alert( val_from_id );
			}
		);				
		
	});



  
  
   var $checkboxes = $('input[type=checkbox]'); 
	$('#selection').toggle(function() { 
	  $checkboxes.attr('checked','checked'); 
	  return false; 
	}, function() { 
	
	  $checkboxes.removeAttr('checked'); 
	  return false; 
	}); 
	  
  
});
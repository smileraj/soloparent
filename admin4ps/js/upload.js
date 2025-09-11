function photoUpload(btn, etat, fichier, format, photo, nb_max){
	
	var btnUpload=$('#'+btn+'');
	var status=$('#'+etat+'');
	
	new AjaxUpload(btnUpload, {
		action: 'js/upload.php',
		//Name of the file input box
		name: btn,
		
		data: { "upload_dir": $('#upload_dir').val(), "nom_image": photo, "format": format, "btn": btn, "nb_max": nb_max},
		
		onSubmit: function(file, ext){
			$('#'+fichier+'_error').empty();
			
			if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                  // check for valid file extension 
				$('<li></li>').appendTo('#'+fichier+'_error').html('Erreur de chargement:<br />Vous pouvez t\351l\351charger uniquement des images au format JPG, PNG ou GIF').addClass('error');
				return false;
			}
			
			if(this._input.files[0].size >= 2097152){
				$('<li></li>').appendTo('#'+fichier+'_error').html('Erreur de chargement:<br />L\'image t\351l\351charg\351e doit faire moins de 2Mo').addClass('error');
				return false;
			}
			
			status.text('Uploading...');
		},
		onComplete: function(file, response){
			//On completion clear the status
			status.text('');
			$('#'+fichier+'_error').empty();
			
			//tabResponse = new Array();
			tabResponse =response.split(',')
			
			//Add uploaded file to list
			if(tabResponse[0]==="success"){
				$('<li></li>').appendTo('#'+fichier+'').html('<img src="'+tabResponse[2]+'/'+tabResponse[1]+'" alt="'+tabResponse[1]+'" /><br /><a href="javascript:deletePhoto( \''+tabResponse[1]+'\', \''+tabResponse[3]+'\')" id="'+tabResponse[3]+'" >X Supprimer</a>').addClass(tabResponse[0]);
			} else{
				$('<li></li>').appendTo('#'+fichier+'_error').html('Erreur de chargement'+tabResponse[1]+'').addClass(tabResponse[0]);
			}
		}
	});
}

function deletePhoto(img, div){
		
	var commentContainer = $('#'+div).parent();
		
	$.ajax({
		type: "POST",
		url: "js/delete.php",
		data: { "upload_dir": $('#upload_dir').val(), "img": img},
		cache: false,
		success: function(){
			commentContainer.slideUp('slow', function() {$(this).remove();});
		}
	});
	return false;
}

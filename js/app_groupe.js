var groupeUpload;
function uploaderInitGroupe_fr() {
	groupeUpload = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/groupe.php",
		post_params: {"upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value},
		file_size_limit : "2 MB",
		file_types : "*.jpg",
		file_types_description : "JPG",
		file_upload_limit : "0",
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		button_image_url : document.getElementById('site_url').value+"/js/swfupload/images/parcourir.png",
		button_placeholder_id : "spanButtonPlaceholder",
		button_width: 120,
		button_height: 40,
		button_text : '',
		button_text_style : '',
		button_text_top_padding: 0,
		button_text_left_padding: 18,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		flash_url : document.getElementById('site_url').value+"/js/swfupload/swfupload.swf",
		custom_settings : {
			upload_target : "divFileProgressContainer",
			uploadGroupe : 1
		},
		debug: false
	});
}

function uploaderInitGroupe_de() {
	groupeUpload = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/groupe.php",
		post_params: {"upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value},
		file_size_limit : "2 MB",
		file_types : "*.jpg",
		file_types_description : "JPG",
		file_upload_limit : "0",
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		button_image_url : document.getElementById('site_url').value+"/js/swfupload/images/parcourir_de.png",
		button_placeholder_id : "spanButtonPlaceholder",
		button_width: 120,
		button_height: 40,
		button_text : '',
		button_text_style : '',
		button_text_top_padding: 0,
		button_text_left_padding: 18,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		flash_url : document.getElementById('site_url').value+"/js/swfupload/swfupload.swf",
		custom_settings : {
			upload_target : "divFileProgressContainer",
			uploadGroupe : 1
		},
		debug: false
	});
}

function uploaderInitGroupe_en() {
	groupeUpload = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/groupe.php",
		post_params: {"upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value},
		file_size_limit : "2 MB",
		file_types : "*.jpg",
		file_types_description : "JPG",
		file_upload_limit : "0",
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		button_image_url : document.getElementById('site_url').value+"/js/swfupload/images/parcourir_en.png",
		button_placeholder_id : "spanButtonPlaceholder",
		button_width: 120,
		button_height: 40,
		button_text : '',
		button_text_style : '',
		button_text_top_padding: 0,
		button_text_left_padding: 18,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		flash_url : document.getElementById('site_url').value+"/js/swfupload/swfupload.swf",
		custom_settings : {
			upload_target : "divFileProgressContainer",
			uploadGroupe : 1
		},
		debug: false
	});
}

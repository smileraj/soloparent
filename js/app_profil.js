function step1GenderChange(new_value) {
	if(new_value == 'f') {
    new_text = '<span class="man">a man</span>';
} else if(new_value == 'h') {
    new_text = '<span class="woman">a woman</span>';
} else {
    new_text = 'choose your gender';
}

	document.getElementById('step1gender').innerHTML = new_text;
}

function textCounter(field, counter, maxlimit) {
	if (field.value.length > maxlimit) {
		field.value = field.value.substring(0, maxlimit);
	} else  {
		document.getElementById('chars_limit').innerHTML = maxlimit - field.value.length;
	}
}

var step2upload;
function uploaderInit_fr() {
	step2upload = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "profil", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value},
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
			upload_target : "divFileProgressContainer"
		},
		debug: false
	});
};

function uploaderInit_de() {
	step2upload = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "profil", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value},
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
			upload_target : "divFileProgressContainer"
		},
		debug: false
	});
};

function uploaderInit_en() {
	step2upload = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "profil", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value},
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
			upload_target : "divFileProgressContainer"
		},
		debug: false
	});
};

function setDefault(i) {
	try{document.getElementById('photo'+document.step2.photo_defaut.value).className = 'no';}catch(e){}
	document.getElementById('photo'+i).className = 'yes';
	document.step2.photo_defaut.value = i;
}

function childChange(op) {
	var displayValue;
	var childNb = 6;
	var f = document.step5;

	if(op == '+') {
		displayValue = 'block';
		for(i=2;i<=childNb;i++) {
			if(document.getElementById('child'+i).style.display!=displayValue) {
				document.getElementById('child'+i).style.display=displayValue;
				f['child'+i].value = 1;
				return;
			}
		}
	} else {
		displayValue = 'none';
		for(i=childNb;i>=2;i--) {
			if(document.getElementById('child'+i).style.display!=displayValue) {
				document.getElementById('child'+i).style.display=displayValue;
				f['child'+i].value = 0;
				return;
			}
		}
	}

}

var step5upload1;
var step5upload2;
var step5upload3;
var step5upload4;
var step5upload5;
var step5upload6;
function uploaderInitChildren_fr() {
	step5upload1 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 1},
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
		button_placeholder_id : "spanButtonPlaceholder1",
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
			upload_target : "divFileProgressContainer1",
			childNum : 1
		},
		debug: false
	});
	step5upload2 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 2},
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
		button_placeholder_id : "spanButtonPlaceholder2",
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
			upload_target : "divFileProgressContainer2",
			childNum : 2
		},
		debug: false
	});
	step5upload3 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 3},
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
		button_placeholder_id : "spanButtonPlaceholder3",
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
			upload_target : "divFileProgressContainer3",
			childNum : 3
		},
		debug: false
	});
	step5upload4 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 4},
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
		button_placeholder_id : "spanButtonPlaceholder4",
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
			upload_target : "divFileProgressContainer4",
			childNum : 4
		},
		debug: false
	});
	step5upload5 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 5},
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
		button_placeholder_id : "spanButtonPlaceholder5",
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
			upload_target : "divFileProgressContainer5",
			childNum : 5
		},
		debug: false
	});
	step5upload6 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 6},
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
		button_placeholder_id : "spanButtonPlaceholder6",
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
			upload_target : "divFileProgressContainer6",
			childNum : 6
		},
		debug: false
	});
}
function uploaderInitChildren_en() {
	step5upload1 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 1},
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
		button_placeholder_id : "spanButtonPlaceholder1",
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
			upload_target : "divFileProgressContainer1",
			childNum : 1
		},
		debug: false
	});
	step5upload2 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 2},
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
		button_placeholder_id : "spanButtonPlaceholder2",
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
			upload_target : "divFileProgressContainer2",
			childNum : 2
		},
		debug: false
	});
	step5upload3 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 3},
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
		button_placeholder_id : "spanButtonPlaceholder3",
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
			upload_target : "divFileProgressContainer3",
			childNum : 3
		},
		debug: false
	});
	step5upload4 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 4},
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
		button_placeholder_id : "spanButtonPlaceholder4",
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
			upload_target : "divFileProgressContainer4",
			childNum : 4
		},
		debug: false
	});
	step5upload5 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 5},
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
		button_placeholder_id : "spanButtonPlaceholder5",
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
			upload_target : "divFileProgressContainer5",
			childNum : 5
		},
		debug: false
	});
	step5upload6 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 6},
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
		button_placeholder_id : "spanButtonPlaceholder6",
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
			upload_target : "divFileProgressContainer6",
			childNum : 6
		},
		debug: false
	});
}



function uploaderInitChildren_de() {
	step5upload1 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 1},
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
		button_placeholder_id : "spanButtonPlaceholder1",
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
			upload_target : "divFileProgressContainer1",
			childNum : 1
		},
		debug: false
	});
	step5upload2 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 2},
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
		button_placeholder_id : "spanButtonPlaceholder2",
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
			upload_target : "divFileProgressContainer2",
			childNum : 2
		},
		debug: false
	});
	step5upload3 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 3},
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
		button_placeholder_id : "spanButtonPlaceholder3",
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
			upload_target : "divFileProgressContainer3",
			childNum : 3
		},
		debug: false
	});
	step5upload4 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 4},
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
		button_placeholder_id : "spanButtonPlaceholder4",
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
			upload_target : "divFileProgressContainer4",
			childNum : 4
		},
		debug: false
	});
	step5upload5 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 5},
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
		button_placeholder_id : "spanButtonPlaceholder5",
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
			upload_target : "divFileProgressContainer5",
			childNum : 5
		},
		debug: false
	});
	step5upload6 = new SWFUpload({
		upload_url: document.getElementById('site_url').value+"/js/swfupload/upload.php",
		post_params: {"upload_type": "enfant", "upload_dir": document.getElementById('upload_dir').value, "hash": document.getElementById('hash').value, "childNum": 6},
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
		button_placeholder_id : "spanButtonPlaceholder6",
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
			upload_target : "divFileProgressContainer6",
			childNum : 6
		},
		debug: false
	});
}

function setProfilPhoto(dir_id, photo_i) {
	$('profilPhotoDefaut').src = 'images/profil/'+dir_id+'/parent-solo-profil-'+photo_i+'.jpg';
}

function getScrollMax(id){
	divCond = $(id);
	divCond.scrollTop = 0;
	n= 0;
	currPos = 0;
	newPos = 1;
	while (newPos > currPos) {
		currPos = divCond.scrollTop;
		n = n+50;
		divCond.scrollTop = n;
		newPos = divCond.scrollTop;
	}
	divCond.scrollTop = 0;
	return newPos;
}

function btnconditions(newValue) {
	$('#inputconditions').val(newValue);
	if(newValue > 0) {
		$('#reponse').innerHTML = $('#condReadAccepted').value;
		$('#reponse').className = 'accepted';
	} else {
		$('#reponse').innerHTML = $('#condReadNotAccepted').value;
		$('#reponse').className = 'refused';
	}
}

function chkcontrol_fr(j,ckb) {
	var total=0;
	for(var i=0; i < document.step4.elements[ckb].length; i++){
		if(document.step4.elements[ckb][i].checked){
			total =total +1;
		}
		if(total > 3){
			alert("Seulement 3 réponses sont possibles, merci!") 
			document.step4.elements[ckb][j].checked = false ;
			return false;
		}
	}
}

function chkcontrol_en(j,ckb) {
	var total=0;
	for(var i=0; i < document.step4.elements[ckb].length; i++){
		if(document.step4.elements[ckb][i].checked){
			total =total +1;
		}
		if(total > 3){
			alert("Only 3 answers are possible, thank you!") 
			document.step4.elements[ckb][j].checked = false ;
			return false;
		}
	}
}

function chkcontrol_de(j,ckb) {
	var total=0;
	for(var i=0; i < document.step4.elements[ckb].length; i++){
		if(document.step4.elements[ckb][i].checked){
			total =total +1;
		}
		if(total > 3){
			alert("Nur 3 Antworten möglich, danke!") 
			document.step4.elements[ckb][j].checked = false ;
			return false;
		}
	}
}

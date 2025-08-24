/*function chatLoadHelp() {
	new Request(
	{
		url: $('site_url').value+'/ajaxChat.php',
		method: 'get',
		headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
		data: {
				"user_id_from": $('user_id_from').value,
				"key": $('key').value,
				"action": 'getHelp'
		},
		onSuccess: function(ajax_return) {
			$('chatHelp').className = 'conversationUsernameOn';
			$("chatContent").set('html', ajax_return);
		},
		onFailure: function(){}
	}
	).send();
}*/

function chatOpenConversation(user_id_to) {
	$('conversationOpen'+user_id_to).className = 'conversationUsernameOn';
	new Request(
	{
		url: $('site_url').value+'/ajaxChat.php',
		method: 'get',
		headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
		data: {
				"lang_id": $('lang_id').value,
				"user_id_from": $('user_id_from').value,
				"user_id_to": user_id_to,
				"key": $('key').value,
				"action": 'openConversation'
		},
		onSuccess: function(ajax_return) {
			$("chatContent").set('html', ajax_return);
			chatScroll('messages');
		},
		onFailure: function(){}
	}
	).send();
}

function chatGetConversations(user_id_to_new) {
	var user_id_to = 0;
	try {
		user_id_to =  $('user_id_to').value;
	}catch(e){}

	new Request(
	{
		url: $('site_url').value+'/ajaxChat.php',
		method: 'get',
		headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
		data: {
				"lang_id": $('lang_id').value,
				"user_id_from": $('user_id_from').value,
				"user_id_to": user_id_to,
				"user_id_to_new": user_id_to_new,
				"key": $('key').value,
				"action": 'getConversations'
		},
		onSuccess: function(ajax_return) {
			$("chatConversations2").style.display='block';
			$("chatConversations2").set('html', ajax_return);
			$("chatConversations").set('html', ajax_return);
			$("chatConversations2").set('html', '');
			$("chatConversations2").style.display='none';
			if(user_id_to_new > 0) {
				chatOpenConversation(user_id_to_new);
			}
		},
		onFailure: function(){}
	}
	).send();
}

function chatSendMessage() {
	$('loadingSend').style.visibility = 'visible';
	new Request(
	{
		url: $('site_url').value+'/ajaxChat.php',
		method: 'get',
		headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
		data: {
				"lang_id": $('lang_id').value,
				"user_id_from": $('user_id_from').value,
				"user_id_to": $('user_id_to').value,
				"key": $('key').value,
				"texte": $('texte').value,
				"action": 'sendMessage'
		},
		onSuccess: function(ajax_return) {
			$('texte').value = '';
			$("messages").set('html', $("messages").innerHTML+ajax_return);
			chatScroll('messages');
			$('loadingSend').style.visibility = 'hidden';
		},
		onFailure: function(){}
	}
	).send();
}

function chatScroll(id) {
	var el = $(id);
	if (typeof el.scrollTop != 'undefined') {
		el.scrollTop = 10000;
	}
}

function chatGetNewMessages() {
	try {
	if($('user_id_to') && $('user_id_to').value > 0) {
		new Request(
		{
			url: $('site_url').value+'/ajaxChat.php',
			method: 'get',
			headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
			data: {
					"lang_id": $('lang_id').value,
					"user_id_from": $('user_id_from').value,
					"user_id_to": $('user_id_to').value,
					"key": $('key').value,
					"newonly": 1,
					"action": 'getNewMessages'
			},
			onSuccess: function(ajax_return) {
				if(ajax_return != '') {
					$("messages").set('html', $("messages").innerHTML+ajax_return);
					chatScroll('messages');
				}
			},
			onFailure: function(){}
		}
		).send();
	}
	}catch(e){}
}

function chatCloseConversation(user_id_to) {
	new Request(
	{
		url: $('site_url').value+'/ajaxChat.php',
		method: 'get',
		headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
		data: {
				"lang_id": $('lang_id').value,
				"user_id_from": $('user_id_from').value,
				"user_id_to": user_id_to,
				"key": $('key').value,
				"action": 'closeConversation'
		},
		onSuccess: function(ajax_return) {
			$('chatConversations').removeChild($('conversationOpen'+user_id_to));
			$('chatConversations').removeChild($('conversationClose'+user_id_to));
			document.location = $('site_url').value+'/index2.php?app=chat';
		},
		onFailure: function(){}
	}
	).send();
}

function chatSmiley(smiley) {
	$('texte').value = $('texte').value+' '+smiley+' ';
}

function chatKey(e) {
	var keynum;
	var keychar;
	if(window.event) {
		keynum = e.keyCode;
	} else if(e.which) {
		keynum = e.which;
	}
	if(keynum == 13) {
		chatSendMessage();
	}
}
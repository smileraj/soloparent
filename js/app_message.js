function messageAction(action) {
	var form = document.messageList;
	form.action.value = action;
	form.submit();
}

function fleur(fleurId, fleurNom, bgColor) {

	$('signification').style.backgroundColor = '#fff';
	$('signification').style.borderColor = bgColor;
	$('signification').style.borderWidth = '2px';
	$('signification').innerHTML='<img src="images/fleur/'+fleurId+'.png" alt="" style="margin-right:5px;float:left;" /><b>'+fleurNom+'</b><br />'+$('label_fleur_id_'+fleurId).getAttribute('title')+'<div class="clear">&nbsp;</div>';
	$('fleur_id_'+fleurId).checked = true;
}

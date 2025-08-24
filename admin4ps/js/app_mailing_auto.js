function rechercheDestinataires() {
	try {
		$('loading').style.visibility = "visible";
		if($('envoiEnCours').value == 0) {
			new Request(
			{
				url: $('site_url').value+'/app/app_mailing_auto/ajax.php',
				method: 'get',
				headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
				data: {
					"action": 'search',
					"id": $('id').value,
					"username": $('username').value,
					"email": $('email').value,
					"group_id": $('group_id').value,
					"user_id": $('user_id').value,
					"hash": $('hash').value
				},
				onSuccess: function(ajax_return) {
					if(ajax_return != '') {
						$('destinataires').innerHTML = ajax_return;
						$('destinatairesNb').value = ajax_return;
						mailingProgressBar(0);
						$('loading').style.visibility = "hidden";
					}
				},
				onFailure: function(){
					$('loading').style.visibility = "hidden";
					if(confirm('Une erreur s\'est produite lors de la recherche de destinataires... Voulez-vous essayer à nouveau ?')) {
						rechercheDestinataires();
					}
				}
			}
			).send();
		}
	}catch(e){alert(e);}
}

function mailingEnvoi(serie) {
	if(serie == null) {
		serie = 0;
		if($('destinatairesNb').value == 0) {
			alert('Votre recherche n\'a retourné aucun destinataire ! Envoi impossible.');
			return 0;
		}
		if(confirm('Attention, vous êtes sur le point d\'envoyer '+$('destinatairesNb').value+' email(s) ! Confirmez-vous ?')) {
			$('destinataires').innerHTML = '<ul><li>Envoi du mailing aux <b>'+$('destinatairesNb').value+'</b> destinataires.</li><li style="color:red;">Ne changez pas de page.</li><li style="color:red;">Ne fermez pas votre navigateur.</li></ul>';
		} else {
			return 0;
		}
	}

	try {
		$('loading2').style.visibility = "visible";
		rechercheOnOff(false);
		new Request(
		{
			url: $('site_url').value+'/app/app_mailing_auto/ajax.php',
			method: 'get',
			headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
			data: {
				"action": 'send',
				"id": $('id').value,
				"username": $('username').value,
				"email": $('email').value,
				"group_id": $('group_id').value,
				"serie": serie,
				"user_id": $('user_id').value,
				"hash": $('hash').value
			},
			onSuccess: function(ajax_return) {
				if(ajax_return == 'end') {
					mailingProgressBar(100);
					$('loading2').style.visibility = "hidden";
					rechercheOnOff(true);
				} else {
					mailingProgressBar(ajax_return);
					mailingEnvoi(serie+1);
				}
			},
			onFailure: function() {
				$('destinataires').innerHTML = 'Un erreur est survenue lors de l\'envoi de la série de mails numéro '+serie+' !, le mailing a été interrompu.';
				$('loading2').style.visibility = "hidden";
			}
		}
		).send();
		
	}catch(e){alert(e);}
}

function rechercheOnOff(disabledVal) {
	$('username').disabled = !disabledVal;
	$('email').disabled = !disabledVal;
	$('group_id').disabled = !disabledVal;
	$('mailingEnvoyer').disabled = !disabledVal;
	$('envoiEnCours').value = disabledVal == false ? 1 : 0;
}

function mailingProgressBar(pourcentage) {
	if(pourcentage > 100) pourcentage = 100;
	if(pourcentage < 0) pourcentage = 0;
	$('mailingProgressBar').style.width = pourcentage+'%';
	if(pourcentage < 100) {
		$('mailingAvancement').innerHTML = pourcentage+'%';
	} else {
		$('mailingAvancement').innerHTML = 'Termin&eacute;.';
	}
}

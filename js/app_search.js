function afficher_recherche_avance() {
	$('recherche_avancee_critere').style.display ='block';
	$('recherche_avancee_critere').style.width ='100%';
	$('search_hr').style.width ='658px';
	$('recherche_avancee_voir_plus').style.display ='none';
	$('recherche_avancee_voir_moins').style.display ='inline';
}

function effacer_recherche_avance() {
	$('recherche_avancee_critere').style.display ='none';
	$('recherche_avancee_voir_plus').style.display ='inline';
	$('recherche_avancee_voir_moins').style.display ='none';
}

function afficher_critere(critere) {
	$('critere_'+critere).style.display ='block';
	$('critere_'+critere).style.width ='100%';
	$(critere+'_voir_plus').style.display ='none';
	$(critere+'_voir_moins').style.display ='inline';
}

function effacer_critere(critere) {
	$('critere_'+critere).style.display ='none';
	$(critere+'_voir_plus').style.display ='inline';
	$(critere+'_voir_moins').style.display ='none';
}

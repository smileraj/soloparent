function masquer(thingId,num){
	var targetElement;
	if(num == 1){
		if(thingId == "hotmail"){
			var tableau = ["gmail","yahoo"];
		}
		if(thingId == "gmail"){
			var tableau = ["hotmail","yahoo"];
		}
		if(thingId == "yahoo"){
			var tableau = ["gmail","hotmail"];
		}
		
		targetElement = document.getElementById(thingId) ;
		if (targetElement.style.display == "none"){
			targetElement.style.display = "" ;
		} else {
			targetElement.style.display = "none" ;
		}
		
		var i;
		for(i = 0; i < tableau.length; i++){
			document.getElementById(tableau[i]).style.display = "none";
		}
		num++;
	}
}

	
function rechercheContact() {
	try {
		
		if($('type').value == "hotmail"){
			$('hotmail').style.display = "none";
		}
		if($('type').value == "gmail"){
			$('gmail').style.display = "none";
		}
		if($('type').value == "yahoo"){
			$('yahoo').style.display = "none";
		}
		
		$('loading').style.visibility = "visible";
		
		new Request(
		{
			/* etape 2 */
			url: 'http://www.solocircl.com/app/app_inviter/contact-ajax.php',
			method: 'get',
			headers: {'If-Modified-Since': 'Sat, 1 Jan 2000 00:00:00 GMT'},
			data: {
				"mail": $('username').value,
				"mdp": $('password').value,
				"type": $('type').value
			},
			/* etape 7 */
			onSuccess: function(ajax_return) {
				/*alert(ajax_return);*/
				
				if(ajax_return == "Erreur" || ajax_return == 2 || ajax_return == 1){
					
					var erreur = document.createElement('div');
					erreur.setAttribute('id','erreur');
					erreur.setAttribute('class','erreur');
					erreur.innerHTML = "<br><center>Une erreur a �t� rencontr�e. Veuillez r�essayer.</center>";
					
					if($('type').value == "hotmail"){
						$('hotmail').style.display = "";
						$("hotmail").appendChild(erreur);
					}
					if($('type').value == "gmail"){
						$('gmail').style.display = "";
						$("gmail").appendChild(erreur);
					}
					if($('type').value == "yahoo"){
						$('yahoo').style.display = "";
						$("yahoo").appendChild(erreur);
					}
					
				}else{
				
					/* decoupage de ajax_return en tableau */
					var tab = ajax_return.split("00babybook");
					
					
					if($('type').value == "hotmail"){
						var nbContact = (tab.length - 2); /* calcul du nombre de contact total */
					}
					if($('type').value == "gmail"){
						var nbContact = (tab.length - 3);
					}
					if($('type').value == "yahoo"){
						var nbContact = (tab.length - 3);
					}
					
					/* Affiche le div contact */
					$('#contact').style.display = "";
					
					/* affiche la taille du tableau total */
					var taille = document.createElement('div');
					taille.setAttribute('id','tailleDiv');
					taille.innerHTML = "<input type='hidden' value='"+nbContact+"' name='taille' id='taille' />";
					$("listeContact").appendChild(taille);
					
					/* haut du tableau (nom - email - supp) */
					var haut = document.createElement('div');
					haut.innerHTML = '<table border="0" width="473"><tr bgcolor="#7d7d7d" style="border:solid 1px #000;" height="30" ><td width="200">Nom</td><td>Email</td><td width="20"><center><img src="images/non.gif"></center></td></tr></table>';
					$("listeContact").appendChild(haut);
					
					var i=0; 
					while(i<tab.length-1){						
						var nom = "calque"+i;
						var id_nom = "contact"+i;
						nom = document.createElement('div');
						nom.setAttribute('id',id_nom);
						nom.setAttribute('style','width:473px;');
						nom.innerHTML = '<table width="473"><tr style="height:25px; line-height:25px; background:#292929;"><td style="width:200px;"><input name="'+id_nom+'" type="hidden" value="'+tab[i+1]+'">'+tab[i]+'</td><td >'+tab[i+1]+'</td><td style="width:20px;"><input style="width:20px;" type="checkbox" checked="checked" onclick="supprimerContact(\''+id_nom+'\');" ></td></tr></table>';
						/*nom.innerHTML = "<table border='0' width='473'><tr style=\"border:solid 1px #000; height:30px; background-color:#292929;\" ><td style=\"width:200px;\" ><input name='"+id_nom+"' type='hidden' value='"+tab[i+1]+"' />"+tab[i]+"</td><td>"+tab[i+1]+"</td><td style=\"width:20px;\"><center><input type='checkbox' onClick='supprimerContact(\""+id_nom+"\")'></center></td></tr></table>";
						*/$("listeContact").appendChild(nom);
						i = i+2;
					}
				}
				$('loading').style.visibility = "hidden";

			},
			onFailure: function(){
				alert('onFailure');
			}
		}
		).send();
			
	}catch(e){alert(e);}
}

function supprimerContact(element){
	document.getElementById(element).style.display = "none";
	$('listeContact').removeChild(document.getElementById(element));
}


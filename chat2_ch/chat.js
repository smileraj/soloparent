function refresh(){
	
	var xhr = getXhr();
	lang = document.sendForm.lang.value;
	id_corresp = document.sendForm.id_corresp.value;
	xhr.onreadystatechange = function(){

		if(xhr.readyState == 4 && xhr.status == 200){
			lareponse = xhr.responseText;

			document.getElementById('openConv').innerHTML = lareponse;
			pulsate();
			
			if(lareponse.indexOf("convOn1",0)!=-1){
				affichConversation(id_corresp);
			}
			setTimeout("refresh()",90000);
			
		}
	}
	xhr.open("GET","ajax.php?action=listall&lang="+lang+"&id_corresp="+id_corresp,true);
	xhr.send();
	
}


function affichAide(){
	
	var xhr = getXhr();
	lang = document.sendForm.lang.value;
	xhr.onreadystatechange = function(){

		if(xhr.readyState == 4 && xhr.status == 200){
			lareponse = xhr.responseText;
			document.getElementById(id_corresp).className="conv0";
			document.sendForm.id_corresp.value=0;
			document.getElementById('chatConversation').style.display="none";
			document.getElementById('chatHelp').style.display="";
			document.getElementById('chatHelp_wrng').style.display="none";
		}
	}
	xhr.open("GET","ajax.php?action=initCorrespondant&lang="+lang,true);
	xhr.send();
	
}


function affichCorrespondant(id_corresp){
	
	var xhr = getXhr();
	lang = document.sendForm.lang.value;
	id_corresp_old = document.sendForm.id_corresp.value;
	if(id_corresp_old != 0 && id_corresp_old != id_corresp){
		document.getElementById(id_corresp_old).className="conv0";
	}
	xhr.onreadystatechange = function(){

		if(xhr.readyState == 4 && xhr.status == 200){
			lareponse = xhr.responseText;

			document.getElementById(id_corresp).className="convOn";
			document.sendForm.id_corresp.value=id_corresp;
			document.getElementById('chatHelp').style.display="none";
			document.getElementById('chatHelp_wrng').style.display="none";
			document.getElementById('chatConversation').style.display="";
			document.getElementById('chatProfileTo').innerHTML = lareponse;
			affichConversation(id_corresp);
		}
		
	}
	xhr.open("GET","ajax.php?action=getCorrespondant&lang="+lang+"&id_corresp="+id_corresp,true);
	xhr.send();

}


function affichConversation(id_corresp){
	var xhr = getXhr();
	lang = document.sendForm.lang.value;
	xhr.onreadystatechange = function(){

		if(xhr.readyState == 4 && xhr.status == 200){
			lareponse = xhr.responseText;

			document.getElementById('chatMessagesContent').innerHTML = lareponse;
			scrollBottom();
			focusTexte();
		}
	}
	xhr.open("GET","ajax.php?action=getConversation&lang="+lang+"&id_corresp="+id_corresp,true);
	xhr.send();

}


function newConversation(id_corresp){
	var xhr = getXhr();
	lang = document.sendForm.lang.value;
	xhr.onreadystatechange = function(){

		if(xhr.readyState == 4 && xhr.status == 200){
			lareponse = xhr.responseText;
			refresh();
			affichCorrespondant(id_corresp);	
		}
	}
	xhr.open("GET","ajax.php?action=createConversation&lang="+lang+"&id_corresp="+id_corresp,true);
	xhr.send();

}


function pulsate() {
	$(".conv1").effect( "pulsate", {times:8}, 2000 );
}

function scrollBottom(){
	var objDiv = document.getElementById("chatMessagesContent");
	objDiv.scrollTop = objDiv.scrollHeight;
}


function chatSmiley(smiley) {
	document.sendForm.texte.value = document.sendForm.texte.value+' '+smiley+' ';
}

function focusTexte(){
	document.getElementById('texte').focus();
}


function closeMenuSmileys(){
	document.getElementById('smileyMenu').style.display='none';
}


function fermerConversation(id_suppr){
	if(confirm(document.sendForm.closeConfirm.value)) {
		var xhr = getXhr();
		lang = document.sendForm.lang.value;
		id_corresp = document.sendForm.id_corresp.value;
		xhr.onreadystatechange = function(){

			if(xhr.readyState == 4 && xhr.status == 200){
				lareponse = xhr.responseText;
				affichAide();
			}
		}
		xhr.open("GET","ajax.php?action=closeConversation&lang="+lang+"&id_corresp="+id_corresp+"&id_suppr="+id_suppr,true);
		xhr.send();
	}
}


function actionMessage(e) {
	if(e.keyCode == 13){
		if(!e.shiftKey){
			sendMessage();
		}
	}
}


function sendMessage(){
	
	var xhr = getXhr();
	lang = document.sendForm.lang.value;
	texte = document.sendForm.texte.value;
	texte_final = Remplace(texte,"\n","<br />");
	id_corresp = document.sendForm.id_corresp.value;
	xhr.onreadystatechange = function(){

		if(xhr.readyState == 4 && xhr.status == 200){
			lareponse = xhr.responseText;
			affichConversation(id_corresp);
			closeMenuSmileys();
			document.sendForm.texte.value = '';
		}
	}
	xhr.open("GET","ajax.php?action=sendMessage&lang="+lang+"&id_corresp="+id_corresp+"&texte="+texte_final,true);
	xhr.send();
	
}

function Remplace(expr,a,b) {
	var i=0
	while (i!=-1) {
		i=expr.indexOf(a,i);
		if (i>=0) {
			expr=expr.substring(0,i)+b+expr.substring(i+a.length);
			i+=b.length;
		}
	}
	return expr;
}

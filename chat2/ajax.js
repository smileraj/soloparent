/**
* Constructeur de l'objet XmlHttpRequest
* @return objet xhr XmlHttpRequest
*/
function getXhr(){
 var xhr = null;
 if(window.XMLHttpRequest)       // Firefox et autres
    xhr = new XMLHttpRequest();
 else if(window.ActiveXObject){       // Internet Explorer
    try { xhr = new ActiveXObject("Msxml2.XMLHTTP"); }
    catch (e) { xhr = new ActiveXObject("Microsoft.XMLHTTP"); }
 }
 else { // XMLHttpRequest non supporté par le navigateur
       alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
       xhr = false;
      }
 return xhr;
}

/**
* Nettoyeur de noeuds qui supprime les noeuds textes vides (ne contenant que des caractères blancs, sous Firefox)
* c'est le documentElement de la responseXML qu'il faut transmettre au nettoyeur
* @param string d documentElement de la réponse XML
* @return string d documentElement de la réponse XML sans les noeuds textes vides
*/
function NodeCleaner(d){

  function go(c){
    if(!c.data.replace(/\s/g,''))
      c.parentNode.removeChild(c);
  }

  var bal=d.getElementsByTagName('*');

  for(i=0;i<bal.length;i++){
    a=bal[i].previousSibling;
    if(a && a.nodeType==3)
      go(a);
    b=bal[i].nextSibling;
    if(b && b.nodeType==3)
      go(b);
  }
  return d;
}
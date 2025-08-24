<html>
  <head><script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

  </head>
  <body>
    <iframe  seamless  sandbox="allow-same-origin allow-top-navigation allow-scripts allow-popups allow-forms" id="myIframe" name="myIframe" src="ajax_paymentBatch.php" style="height:670px; width:100%"></iframe><br />
	
	
      <textarea id='textId'></textarea>
    <input type="button" value="click" id="btn" onclick="aa()">
    <script type="text/javascript">
	     function aa(){ 
		var iFrame =  document.getElementById('myIframe');
		console.log($(document.getElementById('myIframe')).document)
console.log(document.frames['myIframe'].location.href)
console.log(window.parent)
console.log(document.getElementById('myIframe').contentWindow)
console.log($("#myIframe"))
		console.log(iFrame.getElementsByTagName("html"));
		console.log($(iFrame.find("#document")));
		console.log($("#document"));
   //var iFrameBody;
   //if ( iFrame.contentDocument ) 
   //{ // FF
    // iFrameBody = iFrame.contentDocument.getElementsByTagName('body')[0];
   //}
   //else if ( iFrame.contentWindow ) 
   //{ // IE
     //iFrameBody = iFrame.contentWindow.document.getElementsByTagName('body')[0];
   //}
    alert(iFrameBody.innerHTML);

        
    }
    </script>
  </body>
</html>

var name = navigator.appName
if (name == "Microsoft Internet Explorer")
	var ie = true;
else
	var ie = false;

var X_OTHER	= 1;
var X_LEFT	= 2;
var X_RIGHT = 3;

var Y_OTHER	= 1;
var Y_UP		= 2;
var Y_DOWN	= 3;

var vgCurrentElement = null;
var vgCurrentPositionX = X_OTHER;
var vgCurrentPositionY = Y_OTHER;
	
var vgCurrentX 				= 0;
var vgCurrentY 				= 0;
var vgCurrentWidth 		= 0;
var vgCurrentHeight 	= 0;
var vgConteneurX			= 0;
var vgConteneurY			= 0;
var vgConteneurWidth	= 0;
var vgConteneurHeight	= 0;

var TailleBorder			= 1;

if(ie) {
	var vgConteneurSizeBorder			= 1 * TailleBorder;
	var vgConteneurSizeWidth			= vgConteneurSizeBorder * 2;
	var vgCurrentSizeWidth				= 0;
}
else {
	var vgConteneurSizeBorder			= 1 * TailleBorder;
	var vgConteneurSizeWidth			= 0;
	var vgCurrentSizeWidth				= 1 * TailleBorder;
}

var vgMouseX 			= 0;
var vgMouseY 			= 0;
var vgMouseDiffX 	= 0;
var vgMouseDiffY 	= 0;
var vgMouseDown 	= false;

var vgTimerMouse;
var vgTimerTime = 20;

var ratio = 0;


//----------------------------//
function position(e)
{
	vgMouseX = (navigator.appName.substring(0,3) == "Net") ? e.pageX : event.x+document.body.scrollLeft;
	vgMouseY = (navigator.appName.substring(0,3) == "Net") ? e.pageY : event.y+document.body.scrollTop;
	
	PositionX = document.getElementById('bloc_recadre').offsetLeft;
	PositionY = document.getElementById('bloc_recadre').offsetTop;
	TailleX = document.getElementById('bloc_recadre').offsetWidth;
	TailleY = document.getElementById('bloc_recadre').offsetHeight;
	
	if(vgMouseX >= PositionX && vgMouseX <= PositionX + 10 && vgMouseY >= PositionY && vgMouseY <= PositionY + (TailleY / 2))
		document.getElementById('bloc_recadre').style.cursor = "nw-resize";
	else if(vgMouseX >= PositionX && vgMouseX <= PositionX + 10 && vgMouseY >= PositionY + (TailleY / 2) && vgMouseY <= PositionY + TailleY)
		document.getElementById('bloc_recadre').style.cursor = "sw-resize";
	else if(vgMouseX >= PositionX + TailleX - 10 && vgMouseX <= PositionX + TailleX && vgMouseY >= PositionY && vgMouseY <= PositionY + (TailleY / 2))
		document.getElementById('bloc_recadre').style.cursor = "ne-resize";
	else if(vgMouseX >= PositionX + TailleX - 10 && vgMouseX <= PositionX + TailleX && vgMouseY >= PositionY + (TailleY / 2) && vgMouseY <= PositionY + TailleY)
		document.getElementById('bloc_recadre').style.cursor = "se-resize";
	else
		document.getElementById('bloc_recadre').style.cursor = "move";
}

//----------------------------//
function fnResizeDiv()
{
	if(vgCurrentElement!=null && vgCurrentElement!=undefined && (vgCurrentWidth <= vgConteneurWidth && vgCurrentHeight <= vgConteneurHeight))
	{
		if(vgCurrentX <= vgConteneurX)
			document.getElementById(vgCurrentElement).style.left = vgConteneurX;
		else if((vgCurrentX + vgCurrentWidth) >= (vgConteneurX + vgConteneurWidth))
			document.getElementById(vgCurrentElement).style.left = vgConteneurX + vgConteneurWidth - vgCurrentWidth;
		else if(vgCurrentX > vgConteneurX)
			document.getElementById(vgCurrentElement).style.left = vgCurrentX;
		
		if(vgCurrentY <= vgConteneurY)
			document.getElementById(vgCurrentElement).style.top = vgConteneurY;
		else if((vgCurrentY + vgCurrentHeight) >= (vgConteneurY + vgConteneurHeight))
			document.getElementById(vgCurrentElement).style.top = vgConteneurY + vgConteneurHeight - vgCurrentHeight;
		else if(vgCurrentY > vgConteneurY)
			document.getElementById(vgCurrentElement).style.top = vgCurrentY;
	}
	
	if(vgCurrentWidth <= vgConteneurWidth && vgCurrentWidth * ratio <= vgConteneurHeight + 1 && vgCurrentWidth > 108 && vgCurrentWidth * ratio > 108 * ratio) {
		document.getElementById(vgCurrentElement).style.width = vgCurrentWidth;
		document.getElementById(vgCurrentElement).style.height = vgCurrentWidth * ratio;
	}
	
	checkForm();
}

//----------------------------//
function fnOnMouseDown()
{
	vgMouseDown = true;
	
	if(vgCurrentElement!=null && vgCurrentElement!=undefined)
	{
		//Init of size
		vgCurrentX 					= document.getElementById(vgCurrentElement).offsetLeft;
		vgCurrentY 					= document.getElementById(vgCurrentElement).offsetTop;
		vgCurrentWidth 			= document.getElementById(vgCurrentElement).offsetWidth - (vgCurrentSizeWidth * 2);
		vgCurrentHeight 		= document.getElementById(vgCurrentElement).offsetHeight - (vgCurrentSizeWidth * 2);
		vgConteneurX				= document.getElementById(var_conteneur).offsetLeft - vgConteneurSizeBorder;
		vgConteneurY				= document.getElementById(var_conteneur).offsetTop - vgConteneurSizeBorder;
		vgConteneurWidth 		= document.getElementById(var_conteneur).offsetWidth + vgConteneurSizeWidth;
		vgConteneurHeight 	= document.getElementById(var_conteneur).offsetHeight + vgConteneurSizeWidth;
		ratio								= vgCurrentHeight / vgCurrentWidth;
		
		//Init of distance
		vgMouseDiffX = vgMouseX-vgCurrentX;
		vgMouseDiffY = vgMouseY-vgCurrentY;
		
		//Init of position
		if(vgMouseDiffX < 10 || (vgCurrentWidth-vgMouseDiffX) < 10)
		{
			if(vgMouseDiffX < vgCurrentWidth/2)
				vgCurrentPositionX = X_LEFT;
			else
				vgCurrentPositionX = X_RIGHT;
		}
		else
			vgCurrentPositionX = X_OTHER;
			
		
		if(vgMouseDiffY < 10 || (vgCurrentHeight-vgMouseDiffY) < 10)
		{
			if(vgMouseDiffY > vgCurrentHeight/2)
				vgCurrentPositionY = Y_DOWN;
			else
				vgCurrentPositionY = Y_UP;
		}
		else
			vgCurrentPositionY = Y_OTHER;
			
		
		vgTimerMouse = setInterval("fnOnMouseMove();", vgTimerTime);
	}
}

function fnOnMouseUp()
{
	vgMouseDown = false;
	clearInterval(vgTimerMouse);
}

function fnOnMouseMove()
{
	if(vgMouseDown && vgCurrentElement!=null && vgCurrentElement!=undefined)
	{
		switch(vgCurrentPositionX)
		{
			case X_LEFT:	vgCurrentWidth += vgCurrentX-vgMouseX;
										if(vgCurrentWidth<0)
											vgCurrentWidth = 0;
										else
											vgCurrentX = vgMouseX;
										break;
			case X_RIGHT:	vgCurrentWidth = vgMouseX-vgCurrentX;
										if(vgCurrentWidth<0)
											vgCurrentWidth = 0;
										break;
			default: break;
		}
		switch(vgCurrentPositionY)
		{
			case Y_UP:		vgCurrentHeight += vgCurrentY-vgMouseY;
										if(vgCurrentHeight<0)
											vgCurrentHeight = 0;
										else
											vgCurrentY = vgMouseY;
										break;
			case Y_DOWN:	vgCurrentHeight = vgMouseY-vgCurrentY;
										if(vgCurrentHeight<0)
											vgCurrentHeight = 0;
										break;
			default: break;
		}
									
		if(vgCurrentPositionX==X_OTHER && vgCurrentPositionY==Y_OTHER)
		{
			vgCurrentX = vgMouseX-vgMouseDiffX;
			vgCurrentY = vgMouseY-vgMouseDiffY;
		}
		
		
		
		fnResizeDiv();
	}
}

function fnOnMouseOver(sSelectedElementName, sSelectedElementName2)
{
	document.getElementById('bloc_recadre').style.cursor = "move";
	if(!vgMouseDown)
	{
		if(sSelectedElementName==null && sSelectedElementName!="undefined")
		{
			vgCurrentElement = null;
			var_conteneur = null;
		}
		else
		{
			
			vgCurrentElement = sSelectedElementName;
			var_conteneur = sSelectedElementName2;
		}
	}
}


//----------------------------//
function fnOnLoad()
{
	if(navigator.appName.substring(0,3) == "Net")
		document.captureEvents(Event.MOUSEMOVE);
	document.onmousemove = position;
}

function checkForm() {
	value_sx = document.getElementById(vgCurrentElement).style.left;
	value_sy = document.getElementById(vgCurrentElement).style.top;
	value_ex = document.getElementById(vgCurrentElement).style.width;
	value_ey = document.getElementById(vgCurrentElement).style.height;
	
	document.getElementById('sx').value = value_sx.slice(0, -2) - vgConteneurX;
	document.getElementById('sy').value = value_sy.slice(0, -2) - vgConteneurY;
	document.getElementById('ex').value = value_ex.slice(0, -2) - vgConteneurSizeWidth;
	document.getElementById('ey').value = value_ey.slice(0, -2) - vgConteneurSizeWidth;
	return false;
}

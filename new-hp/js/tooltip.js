/***********************************************
* Cool DHTML tooltip script- � Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
var agt=navigator.userAgent.toLowerCase();
var offsetxpoint=10 //Customize x offset of tooltip
var offsetypoint=-10 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var is_safari = ((agt.indexOf('safari')!=-1)&&(agt.indexOf('mac')!=-1))?true:false;
var enabletip=false


var contentobj=document.getElementById("contents");
var tipTextObj=document.getElementById("tooltipText");
var dynamicTipObj=document.all? document.all["dynamicTooltip"] : document.getElementById? document.getElementById("dynamicTooltip") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
tipTextObj=document.getElementById("tooltipText");
contentobj=document.getElementById("contents");
if (thetext.indexOf("~") >= 0 && 1==2)
	tipTextObj.innerHTML = dynamicTipObj.innerHTML;
else {
	tipTextObj.innerHTML = thetext;
	tipTextObj.style.color=thecolor;
}

if (typeof thewidth=="undefined"){ 
	contentobj.style.width=tipTextObj.clientWidth+"px";
	contentobj.style.height=tipTextObj.clientHeight+"px";
} else {

	contentobj.style.width=thewidth+"px";
}

enabletip=true
return false
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.x+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.y+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<contentobj.offsetWidth) {
//move the horizontal position of the menu to the left by it's width
contentobj.style.left=ie? ietruebody().scrollLeft+event.clientX-contentobj.offsetWidth+"px" : window.pageXOffset+e.clientX-contentobj.offsetWidth+"px"
} else if (curX<leftedge) {
contentobj.style.left="5px"
} else {
//position the horizontal position of the menu where the mouse is positioned
contentobj.style.left=curX+offsetxpoint+"px"
}
//same concept with the vertical position
if ((bottomedge<contentobj.offsetHeight)&&!is_safari) {
contentobj.style.top=ie? ietruebody().scrollTop+event.clientY-contentobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-contentobj.offsetHeight-offsetypoint+"px"
contentobj.style.visibility="visible"
tipTextObj.style.visibility="visible"
} else {
contentobj.style.top=curY+offsetypoint+"px"
contentobj.style.visibility="visible"
tipTextObj.style.visibility="visible"
}
}
}

function hideddrivetip(){
enabletip=false
contentobj.style.visibility="hidden"
contentobj.style.left="-1000px"
contentobj.style.backgroundColor=''
contentobj.style.width=''
}

document.onmousemove=positiontip

var activerequests = 0;
var itemTooltips = new Array()
function dump(arr,level) {
var dumped_text = "";
if(!level) level = 0;
var level_padding = "";
for(var j=0;j<level+1;j++) level_padding += "    ";
if(typeof(arr) == 'object') { //Array/Hashes/Objects
 for(var item in arr) {
  var value = arr[item];
  if(typeof(value) == 'object') { //If it is an array,
   dumped_text += level_padding + "'" + item + "' ...";
   dumped_text += dump(value,level+1);
  } else {
   dumped_text += level_padding + "'" + item + "' -> " + value + "<br>";
  }
 }
} else { //Stings/Chars/Numbers etc.
 dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
}
return dumped_text;
}
Array.prototype.in_array = function ( obj ) {
	var len = this.length;
	for ( var x = 0 ; x <= len; x++ ) {
		if ( this[x] == obj ) return true;
	}
	return false;
}
function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  //FF, Opera, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}
function showTooltip(itemId,setData)
{
var iscached = -1
for( var i = 0 ; i < itemTooltips.length ; i ++ )
{
if( itemTooltips[i][0] == itemId )
{
iscached = i
}
}
if( iscached != -1 )
{
showTip(itemTooltips[iscached][1])
iscached = -1
}
else
if( activerequests <= 2 )
{
activerequests += 1
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  return;
  } 
var url='source/ajax/ajax-itemtooltip-get.php?item=' + itemId + '&setdata=' + setData;
xmlHttp.onreadystatechange = function(){ currentItem = itemId; updateItemTooltip() };
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}
}
function updateItemTooltip() 
{
if (xmlHttp.readyState==4)
{
activerequests = 0
tooltipResult = xmlHttp.responseText;
tooltipResult = tooltipResult.replace(/'/g,'\'')
elemtb1.innerHTML=tooltipResult;
if(elemt1c.offsetWidth > 299) {
		elemt1c.style.width="300px";
	}
xmlHttp.onreadystatechange = tipPosition
thisTooltip = new Array()
thisTooltip[0]=currentItem
thisTooltip[1]=tooltipResult
itemTooltips.push(thisTooltip)
}
}
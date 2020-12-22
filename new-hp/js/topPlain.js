
operaBool=1;

function schedule(objectID, functionCall)
{
	if (document.getElementById(objectID))
	{
		eval(functionCall);
	}
	else
	{
		setTimeout("schedule('" + objectID + "', '" + functionCall + "')", 2000);
	}
	
	return true;
}

/* Thanks to Scott Andrew */
function addEvent(obj, evType, fn) {
	
    if (obj.addEventListener) {

        obj.addEventListener(evType, fn, false);
        return true;
    } else if (obj.attachEvent) {

        var r = obj.attachEvent("on"+evType, fn);
        return r;
    } else {

        return false;
    }
}


function Init(){

	if (is_ie && !is_opera) {
	
		
		var xml = new ActiveXObject("Microsoft.XMLDOM")
		xml.async = false
		xml.load("../new-hp/layout/layout.html")// Load XSL
		var xsl = new ActiveXObject("Microsoft.XMLDOM")
		xsl.async = false
		xsl.load("/new-hp/layout/layout.xsl")// Transform
		document.write(xml.transformNode(xsl));
		//alert("IE");
		
	
	} else if (is_moz) {
			var xslStylesheet;
			var xsltProcessor = new XSLTProcessor();
			var myDOM;
			
			var xmlDoc;
		  // load the xslt file, example1.xsl
		  var myXMLHTTPRequest = new XMLHttpRequest();
		  myXMLHTTPRequest.open("GET.html", "/new-hp/layout/layout.xsl", false);
		  myXMLHTTPRequest.send(null);
		
		  xslStylesheet = myXMLHTTPRequest.responseXML;
		  xsltProcessor.importStylesheet(xslStylesheet);
		
		  // load the xml file, example1.xml
		  myXMLHTTPRequest = new XMLHttpRequest();
		  myXMLHTTPRequest.open("GET.html", "../new-hp/layout/layout.html", false);
		  myXMLHTTPRequest.send(null);
		
		  xmlDoc = myXMLHTTPRequest.responseXML;
		
		  var fragment = xsltProcessor.transformToFragment(xmlDoc, document);
		
		  document.getElementById("headerFooter").innerHTML = "";
		
		  myDOM = fragment;
		  document.getElementById("headerFooter").appendChild(fragment);
		  //alert("Firefox");
		  
	} else {

		//alert("Opera");
	
	}

}



		function headerLoad() {

			var obj = document.getElementById("headerFooter");
			obj.innerHTML = document.getElementById('xmlFrame').document.body.innerHTML;		
			//var obj3 = document.getElementById("cnt");
			//obj3.style.width="790px";

		
		}
		

 

 
	 

		function resizeContainer(){

			
			resizeContainer2();
			
			try {rePosition();}catch(er){}
			
			try {
				if (toolTipPage) {
						loadTable(); switchClick('alliance','horde');
						levelBracket=5; reloadTable();
				}
			}catch(er){}
		
		
		}
		
		function resizeContainer2(){
	
			var obj = document.getElementById("pageContent");
			var obj2= document.getElementById("cnt");
			var obj3 = document.getElementById("contentTable");
			
			var newHeight=obj.offsetHeight+5;

			var oldWidth=713;
			var newWidth=obj3.offsetWidth;

			if(newWidth>oldWidth){
				
				if(is_safari)
					obj2.style.width=newWidth+60+"px";
				else
					obj2.style.width=newWidth+"px";
				
				
				if(is_moz || is_opera || is_safari){

					obj.style.width=newWidth;
				}
			}


			if(newHeight>1000)
				obj2.style.height=newHeight;
			else
				obj2.style.height=1000;		
		
		}		
		
		
		function beforeResize() {
		
			if (is_opera)
				setTimeout("resizeContainer()", 50);
			else
				resizeContainer();
		
		
		}
		
		addEvent(window, 'load', beforeResize);
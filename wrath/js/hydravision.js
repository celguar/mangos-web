/* Omega Skip's Lightbox - SAFETY NOT GUARANTEED! */
/* Memo to self: Clean up this code, for it is wretched */
/* ############# GLOBAL VARIABLES, DEFAULT VALUES ############# */
function addStylesheet(href, media) {
	document.getElementsByTagName("head")[0].appendChild(createElement('link', {
		'rel': 'stylesheet',
		'type': 'text/css',
		'media': media ? media : 'screen, projection',
		'href': href
	}));
}
function createElement(name, attrs, doc, xmlns) {
	var doc = doc ? doc : document;
	var elm;
	if(doc.createElementNS)
		elm = doc.createElementNS(xmlns ? xmlns : "http://www.w3.org/1999/xhtml", name);
	else
		elm = doc.createElement(name);
	if(attrs)
		for(attr in attrs)
			elm.setAttribute(attr, attrs[attr]);
	return elm;
}
function addEvent(obj, evType, fn) {
	if(obj.addEventListener) {
		obj.addEventListener(evType, fn, false);
		return true;
	} else if(obj.attachEvent)
		return obj.attachEvent("on" + evType, fn);
	return false;
}
function $(e) {
	if(typeof e == 'string')
    	return document.getElementById(e);
	return e;
}
/**/
ticked = 0;
hideMe = true;
sliderTicked = 0;
loadBarTicked = 0;
nowViewing = 0;
animationLock = false;
currentPage = 0;
shotsPerPage = 9;
firstLoad = true;
shotList = new Array();
slideShow = false;
slideShowDirection = 1;
screenImage = "";
crossfadeTime = 80;
topBrowserOffset = 70;
downloadString = false;

lightboxClosed = true;
dumpsterIsReady = false;
galleryPageImages = 12;
/* ############# FUNCTIONS ############# */

function linkHere() { document.location = "#" + (currentShotNumber - nowViewing); }

function hydraVision(thisScreenshot, noHiRes)
{
	lightboxClosed = false;
	showHiRes = (typeof noHiRes!= "undefined")?noHiRes:true;
	notViewingGallery = (typeof thisScreenshot == "string");
	if(notViewingGallery) hydraLightbox(thisScreenshot)
	else hydraGalleryLightbox(thisScreenshot)
}

function hydraLightbox(thisScreenshot)
{
	screenImage = new Image();
	screenImage.src = thisScreenshot;
	if(!dumpsterIsReady) { createLightboxFramework(); }
	hiResLinkElement.style.display = (showHiRes)?"block":"none";
	loadHydraScreenshot(thisScreenshot);
}

function hydraGalleryLightbox(thisScreenshot)
{
	nowViewing = eval(thisScreenshot);
	screenImage = new Image();
	crossfadeTime = (crossfadeTime!=80)?80:crossfadeTime;
	screenImage.src = shotList[nowViewing];
	nextShot = new Image();
	nextShot.src = (shotList[nowViewing+1]) ? shotList[nowViewing+1] : shotList[0];
	prevShot = new Image();
	prevShot.src = (shotList[nowViewing-1]) ? shotList[nowViewing-1] : shotList[shotList.length-1];
	if(!dumpsterIsReady) { createLightboxFramework(); }
	hiResLinkElement.style.display = (showHiRes)?"block":"none";
	if (navigator.userAgent.toLowerCase().indexOf('mac') != -1) { macGalleryScroll(); }
	else loadHydraScreenshot(thisScreenshot);
}

function macGalleryScroll(thisScreenshot)
{
	macScreenshot = thisScreenshot;
	animationLock = true;
	isSafari = (navigator.userAgent.indexOf("Safari")==-1)?false:true;
	windowHeight = (window.innerHeight) ? window.innerHeight : documentBody.clientHeight;
	bodyHeight = document.getElementsByTagName("body")[0].offsetHeight;
	scrollDistance = (isSafari) ? document.documentElement.scrollTop : window.pageYOffset;
	deltaScroll = (bodyHeight-windowHeight-scrollDistance)/(crossfadeTime/10);
	macScrollDown = window.setInterval("scrollMac()",10);
}

function scrollMac()
{
	if (sliderTicked >= crossfadeTime+10)
  {
    window.clearInterval(macScrollDown);
		sliderTicked = 0;
		animationLock = false;
		loadHydraScreenshot(macScreenshot);
	}
	else
	{
		window.scrollBy(0,deltaScroll);
		sliderTicked += 10;
	}
}

function loadHydraScreenshot(thisScreenshot)
{
	getWindowDimensions();
	if(!downloadString) 
	{
		//downloadString = $("hiResStringContainer").innerHTML;
		downloadString = ($("hiResStringContainer"))?$("hiResStringContainer").innerHTML:"";
	}
	documentBody.appendChild(lightboxAnchor);
	if(screenImage.complete && !animationLock)
	{
		if(!lightboxClosed)
		{
			screenieElement.style.height = screenImage.height+"px";
			screenieElement.style.width = screenImage.width+"px";
			screenieElement.style.backgroundImage = "url('"+screenImage.src+"')";
			animationLock = (notViewingGallery);
			if(!notViewingGallery)
			{
				$("currentImageCounter").innerHTML = shotList.length-nowViewing;
				linkDivElement.value = document.location.href.split("#")[0]+"#"+(shotList.length - nowViewing);
			}
			hiResLinkElement.innerHTML = "<a href='"+screenImage.src.replace(".jpg","-hires.jpg")+"' target='_blank'>"+downloadString+"</a>";
			screenieElement.style.left = windowWidth/2-screenImage.width/2+"px";
			pictureFrameElement.style.display = "block";
		}
	}
	else { window.setTimeout("loadHydraScreenshot('"+thisScreenshot+"')",250); }
}

function getWindowDimensions()
{
/*
	docbody = (document.documentElement)?document.documentElement:document.body
	windowHeight = (window.innerHeight) ? window.innerHeight : docbody.clientHeight;
	windowWidth = (window.innerWidth) ? window.innerWidth : docbody.clientHeight;
	c0verElement.style.width = docbody.scrollWidth + "px";
	c0verElement.style.height = docbody.scrollHeight + "px";
	scrollDistance = (document.body.scrollTop)?document.body.scrollTop:docbody.scrollTop
	screenieElement.style.top = scrollDistance + topBrowserOffset + "px";	
*/

	windowHeight = (window.innerHeight) ? window.innerHeight : documentBody.clientHeight;
	windowWidth = (window.innerWidth) ? window.innerWidth : documentBody.clientWidth;
	c0verElement.style.width = documentBody.scrollWidth + "px";
	c0verElement.style.height = document.documentElement.scrollHeight + "px";
	if(navigator.userAgent.indexOf("MSIE")!=-1) c0verElement.style.height = (document.location.href.indexOf("wrath")!= -1)?document.documentElement.scrollHeight + "px":document.body.scrollHeight + "px";
	scrollDistance = (navigator.userAgent.indexOf("Safari")==-1) ? document.documentElement.scrollTop : window.pageYOffset;
	if(navigator.userAgent.indexOf("MSIE")!=-1) scrollDistance = (document.location.href.indexOf("wrath")!= -1)?document.documentElement.scrollTop:document.body.scrollTop;
	else if(document.location.href.indexOf("html")!= -1) scrollDistance = document.body.scrollTop;
	screenieElement.style.top = screenie2Element.style.top = scrollDistance + topBrowserOffset + "px";
}

function setHide(thisValue) { hideMe = thisValue; }

function hideLightbox()
{
	if(hideMe)
	{
		screenieElement.style.width = "1px";
		screenieElement.style.height = "1px";
		dumpsterElement.appendChild(lightboxAnchor);
		window.setTimeout("animationLock = false;",50);
		hideMe = false;
		pictureFrameElement.style.display = "none";
		lightboxClosed = true;
	}
}

function nextScreenshot()
{
	if(!animationLock)
	{
		backGifElement.style.backgroundPosition = "0 top";
		fwdGifElement.style.backgroundPosition = "0 bottom";
		goToNextShot();
	}
}

function prevScreenshot()
{
	if(!animationLock)
	{
		backGifElement.style.backgroundPosition = "0 bottom";
		fwdGifElement.style.backgroundPosition = "0 top";
		goToPrevShot();
	}
}

function goToNextShot()
{
	animationLock = true;
	if(nextShot.complete)
	{
		screenieElement.style.cursor = "default";
		nowViewing = (shotList[nowViewing+1]) ? nowViewing+1 : 0;
		screenie2Element.style.backgroundImage = "url('"+nextShot.src+"')";
		deltaY = nextShot.height - screenImage.height;
		deltaX = nextShot.width - screenImage.width;
		screenie2Element.onclick = function(){nextScreenshot()};
		screenieElement.onclick = function(){setHide(false);nextScreenshot()};
		if(navigator.userAgent.toLowerCase().indexOf('firefox') != -1 && deltaX != 0)
		{
			//crossfadeTime = 10;
		}
		nextFade = window.setInterval("fadeToNextShot()",10);
		if(nowViewing%shotsPerPage == 0) galleryNext();
	}
	else
	{
		screenieElement.style.cursor = "wait";
		window.setTimeout("goToNextShot()",250);
	}
}

function goToPrevShot()
{
	animationLock = true;
	if(prevShot.complete)
	{
		if(nowViewing%shotsPerPage == 0) galleryPrev();
		screenieElement.style.cursor = "default";
		nowViewing = (shotList[nowViewing-1]) ? nowViewing-1 : shotList.length-1;
		screenie2Element.style.backgroundImage = "url('"+prevShot.src+"')";
		deltaY = prevShot.height - screenImage.height;
		deltaX = prevShot.width - screenImage.width;
		screenie2Element.onclick = function(){prevScreenshot()};
		screenieElement.onclick = function(){setHide(false);prevScreenshot()};
		if(navigator.userAgent.toLowerCase().indexOf('firefox') != -1 && deltaX != 0)
		{
			//crossfadeTime = 10;
		}
		prevFade = window.setInterval("fadeToPrevShot()",10);
	}
	else
	{
		screenieElement.style.cursor = "wait";
		window.setTimeout("goToPrevShot()",250);
	}
}

function fadeToNextShot()
{
	if (sliderTicked >= crossfadeTime+10)
  {
    window.clearInterval(nextFade);
		screenieElement.style.backgroundImage = "url('"+shotList[nowViewing]+"')";
		screenie2Element.style.opacity = 0;
		screenie2Element.style.filter = "alpha(opacity=0)";
		sliderTicked = 0;
		animationLock = false;
		delete prevShot;
		prevShot = screenImage;
		delete screenImage;
		screenImage = nextShot;
		delete nextShot;
		nextShot = new Image();
		nextShot.src = (shotList[nowViewing+1]) ? shotList[nowViewing+1] : shotList[0];
		linkDivElement.value = document.location.href.split("#")[0]+"#"+(shotList.length - nowViewing);
		hiResLinkElement.innerHTML = "<a href='"+screenImage.src.replace(".jpg","-hires.jpg")+"' target='_blank'>"+downloadString+"</a>";
		$("currentImageCounter").innerHTML = shotList.length-nowViewing;
	}
	else
	{
		animationProgress = sliderTicked/crossfadeTime
		screenie2Element.style.opacity = animationProgress;
		screenie2Element.style.filter = "alpha(opacity="+(animationProgress)*100+")";
		screenieElement.style.width = screenie2Element.style.width = (screenImage.width+(deltaX*animationProgress)) + "px";
		screenieElement.style.height = screenie2Element.style.height = (screenImage.height+(deltaY*animationProgress)) + "px";
		screenieElement.style.left = screenie2Element.style.left = windowWidth/2-(screenImage.width+(deltaX*animationProgress))/2+"px";
		sliderTicked += 10;
	}
}

function fadeToPrevShot()
{
	if (sliderTicked >= crossfadeTime+10)
  {
    window.clearInterval(prevFade);
		screenieElement.style.backgroundImage = "url('"+shotList[nowViewing]+"')";
		screenie2Element.style.opacity = 0;
		screenie2Element.style.filter = "alpha(opacity=0)";
		sliderTicked = 0;
		animationLock = false;
		delete nextShot;
		nextShot = screenImage;
		delete screenImage;
		screenImage = prevShot;
		delete prevShot;
		prevShot = new Image();
		prevShot.src = (shotList[nowViewing-1]) ? shotList[nowViewing-1] : shotList[shotList.length-1];
		linkDivElement.value = document.location.href.split("#")[0]+"#"+(shotList.length - nowViewing);
		hiResLinkElement.innerHTML = "<a href='"+screenImage.src.replace(".jpg","-hires.jpg")+"' target='_blank'>"+downloadString+"</a>";
		$("currentImageCounter").innerHTML = shotList.length-nowViewing;
	}
	else
	{
		animationProgress = sliderTicked/crossfadeTime
		screenie2Element.style.opacity = animationProgress;
		screenie2Element.style.filter = "alpha(opacity="+(animationProgress)*100+")"; //;
		screenieElement.style.width = screenie2Element.style.width = (screenImage.width+(deltaX*animationProgress)) + "px";
		screenieElement.style.height = screenie2Element.style.height = (screenImage.height+(deltaY*animationProgress)) + "px";
		screenieElement.style.left = screenie2Element.style.left = windowWidth/2-(screenImage.width+(deltaX*animationProgress))/2+"px";
		sliderTicked += 10;
	}
}

function createLightboxFramework()
{
	documentBody = document.getElementsByTagName("body")[0];
	addStylesheet("/wrath/css/lightboxstyles.css");
	if(!notViewingGallery)
	{
		backGifElement = createElement("a");
		backGifElement.onclick = function(){prevScreenshot()};
		backGifElement.onmouseover = function(){ this.style.backgroundPosition = "0 100%"; };
		backGifElement.onmouseout = function(){ this.style.backgroundPosition = "0 0"; };
		backGifElement.className = "backGifStyle";

		fwdGifElement = createElement("a");
		fwdGifElement.onclick = function(){nextScreenshot()};
		fwdGifElement.onmouseover = function(){ this.style.backgroundPosition = "0 100%"; };
		fwdGifElement.onmouseout = function(){ this.style.backgroundPosition = "0 0"; };
		fwdGifElement.className = "fwdGifStyle";

		linkDivElement = createElement("input");
		linkDivElement.className = "linkHereStyle";
		linkDivElement.size = "50";
		linkDivElement.onclick = function() { animationLock = true; this.select(); window.setTimeout("animationLock = false",50) }

		imageCounterElement = createElement("div");
		imageCounterElement.className = "imageCounterStyle";
		imageCounterElement.innerHTML = "<span id='currentImageCounter'></span> / "+shotList.length;
	}

	closeGifElement = createElement("div");
	closeGifElement.onclick = function(){this.style.backgroundPosition = "0 top"; setHide(true); animationLock = true; hideLightbox()};
	closeGifElement.onmouseover = function(){ this.style.backgroundPosition = "0 100%"; };
	closeGifElement.onmouseout = function(){ this.style.backgroundPosition = "0 0"; };
	closeGifElement.className = "closeDivStyle";

	hiResLinkElement = createElement("div");
	hiResLinkElement.onclick = function() { animationLock = true; window.setTimeout("animationLock = false",50) }
	hiResLinkElement.className = "hiResLinkStyle";

	screenie2Element = createElement("div");
	screenie2Element.id = "Screenie2";
	screenie2Element.className = "screenie2Style";
	screenie2Element.onclick = function(){setHide(false); nextScreenshot()};

	screenieElement = createElement("div");
	screenieElement.id = "Screenie";
	screenieElement.className = "screenieStyle";
	screenieElement.onclick = function(){setHide(false); nextScreenshot()};	
	
	screenieElement.appendChild(createBorderElement("top"));
	screenieElement.appendChild(createBorderElement("right"));
	screenieElement.appendChild(createBorderElement("bottom"));
	screenieElement.appendChild(createBorderElement("left"));
	screenieElement.appendChild(createBorderElement("topLeft"));
	screenieElement.appendChild(createBorderElement("topRight"));
	screenieElement.appendChild(createBorderElement("bottomRight"));
	screenieElement.appendChild(createBorderElement("bottomLeft"));

	screenieElement.appendChild(hiResLinkElement);
	screenieElement.appendChild(closeGifElement);
	if(!notViewingGallery)
	{
		screenieElement.appendChild(fwdGifElement);
		screenieElement.appendChild(linkDivElement);
		screenieElement.appendChild(backGifElement);
		screenieElement.appendChild(imageCounterElement);
	}

	centerElement = createElement("center");
	centerElement.appendChild(screenieElement);

	pictureFrameElement = createElement("div");
	pictureFrameElement.id = "pictureFrame";
	pictureFrameElement.className = "pictureFrameStyle";
	pictureFrameElement.style.display = "none";
	pictureFrameElement.onclick = (notViewingGallery)? function(){setHide(true); hideLightbox()} : function(){hideLightbox()};
	pictureFrameElement.appendChild(screenieElement);
	pictureFrameElement.appendChild(screenie2Element);

	c0verElement = createElement("div");
	c0verElement.id = "c0ver";
	c0verElement.className = "c0verStyle";
	c0verElement.onclick = function(){setHide(true); hideLightbox()};
	if (navigator.userAgent.toLowerCase().indexOf('mac') == -1)
	{
		c0verElement.style.opacity = "0.7";
		c0verElement.style.backgroundColor = "#000000";
		c0verElement.style.filter = "alpha(opacity=70)";
	}

	lightboxAnchor = createElement("div");
	lightboxAnchor.id = "lightboxAnchorDiv";
	lightboxAnchor.className = "lightboxAnchorStyle";
	lightboxAnchor.appendChild(c0verElement);
	lightboxAnchor.appendChild(pictureFrameElement);

	dumpsterElement = createElement("div");
	dumpsterElement.id = "dumpster";
	dumpsterElement.className = "dumpsterStyle";
	dumpsterElement.appendChild(lightboxAnchor);

	document.getElementsByTagName("body")[0].appendChild(dumpsterElement);
	addEvent(window, 'resize', getWindowDimensions);
	dumpsterIsReady = true;
}

function hydraAttribute(thisElement,thisAttribute,thisValue)
{
	var newAttribute = document.createAttribute(thisAttribute);
	newAttribute.value = thisValue;
	thisElement.setAttributeNode(newAttribute);
}

function createBorderElement(thisElement)
{
	var newElement = createElement("div");
	newElement.className = thisElement+"DivStyle";
	return newElement;
}

function pause() { alert("HALT! Hammerzeit!"); }

function addshots(dir,filename,endnum)
{
	startnum = 0;
	for(i=endnum; i>0; i--)
	{
		shotList[endnum-i] = "" + dir + "/" + filename + (i) +".jpg";
	}
	currentShotNumber = shotList.length;
	printPages();
}

function printPages()
{
	numPages = Math.ceil(shotList.length/shotsPerPage);
	if(document.location.href.split("#")[1] > 0 && firstLoad)
	{
		calculatedIndex = currentShotNumber - document.location.href.split("#")[1];
		currentPage = Math.floor(calculatedIndex/shotsPerPage);
	}
	outString = "";
	alertString = "Opening image: ";
	for(i = 0; i < shotsPerPage; i++)
	{
		n = shotsPerPage*currentPage+i;
		if(shotList[n])
		{
			thumbnail = shotList[n].replace(".jpg","-thumb.jpg");
			outString += "<div><span style='background-image:url("+thumbnail+")'><div><a href='javascript:void(0)' onclick='hydraVision("+n+"); return false'></a></div></span></div>";
		}
	}
	$("galleryPictures").innerHTML = outString;
	$("currentPageSpan").innerHTML = Number(currentPage+1);
	$("maxPageSpan").innerHTML = numPages;
	if(document.location.href.split("#")[1] != null && firstLoad)
	{
		if(document.location.href.split("#")[1] > 0) { window.setTimeout('hydraVision(calculatedIndex)',250); }
		else { window.setTimeout('hydraVision(0)',250); }
		firstLoad = false;
	}
}

function galleryPrev()
{
	if(currentPage > 0) { currentPage--; }
	else { currentPage = numPages-1; }
	printPages();
}

function galleryNext()
{
	if(currentPage < numPages-1) { currentPage++; }
	else { currentPage = 0; }
	printPages();
}

function galleryLast()
{
	currentPage = numPages-1;
	printPages();
}

function galleryFirst()
{
	currentPage = 0;
	printPages();
}

function ThumbSize(size)
{
	currimage = shotsPerPage * currentPage;
	shotsPerPage = (size=="sixteen")?16:(size=="twelve")?12:9;
	document.getElementById("galleryPictures").className = "pictureGallery " + size;
	currentPage = Math.floor(currimage / shotsPerPage);
	printPages();
	if(currentPage > numPages)
	{
		currentPage = numPages-1;
		printPages();
	}
}

function selectThis()
{
	this.select();
}
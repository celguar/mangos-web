	clickToHideString = "Click to Hide";
	learnMoreString = "Click to Learn More";
	zoneLightsList = false;
	i = 0;
	zoneNames = new Array();
	zoneNames[i++] = "Dalaran";
	zoneNames[i++] = "Storm Peaks";
	zoneNames[i++] = "Zul'Drak";
	zoneNames[i++] = "Howling Fjord";
	zoneNames[i++] = "Grizzly Hills";
	zoneNames[i++] = "Dragonblight";
	zoneNames[i++] = "Borean Tundra";
	zoneNames[i++] = "Sholazar Basin";
	zoneNames[i++] = "Wintergrasp";
	zoneNames[i++] = "Icecrown";
	
	function toggleZone(thisZone) { document.getElementById(thisZone).style.visibility = (document.getElementById(thisZone).style.visibility!="hidden")?"hidden":"visible"; }
	
/* ####################################################### */

ticked = 0;													//global variable, used to keep track of time
okayToGo = true;											//global variable; if false, locks the animation function call down as long as an animation is in progress
forwardBackward = 1;										//global variable, determines whether animation cycles normally (1) or in reverse (-1)
currentZone = "none";
theNewContainer = 1;
theOldContainer = 2;
containerDeployed = false;
zonePic = "/wrath/images/bestiary/creature0.jpg";
numZones = 10;
animationFunction = "rightOrLeft()";
correctionValue = 0;
flyOutLock = false;

function toggleContainers()
{
  theNewContainer = (theNewContainer == "1") ? "2" : "1";
  theOldContainer = (theOldContainer == "1") ? "2" : "1";
}

function containerSwitch()
{
  toggleContainers();
  document.getElementById("loreContainer_"+theNewContainer).innerHTML = document.getElementById("zone"+newZone).innerHTML;
//	document.getElementById("screenshotBox_"+theNewContainer).style.backgroundColor = "red";
	document.getElementById("screenshotBox_"+theNewContainer).style.backgroundImage = "url(/wrath/images/worldmap/thumb-"+newZone+".jpg)";
	document.getElementById("screenshotTitle_"+theNewContainer).innerHTML = document.getElementById("zone"+newZone).className+"<div>"+document.getElementById("zone"+newZone).className+"</div>";
}

function itemSlideShow(prevOrNext)								//called if the user clicks "Previous" or "Next"; has 1 (next) or -1 (previous) as a parameter
{
  if (okayToGo)													//if the function is not locked
  {
		newZone = currentZone + prevOrNext;							//used later to determine the next Div ID in the monsterNames array
    if (newZone >= numZones) newZone = 0;			//overflow catch; if the new identifier is larger than the number of elements in the array 
    else if (newZone < 0) newZone = numZones-1;		//or less than zero, jump to zero (the former) or to the last element in the array (the latter)
		forwardBackward = prevOrNext;								//grabs the function parameter, sets the scroll direction accordingly
    if(prevOrNext!= 1) animationFunction = "backwardScroll()"
		moveItem(newZone);											//calls the Animation Control Function, passing the new item identifier as a parameter
  }
}

function moveItem(thisZone)										//Animation Control Function
{
  if(okayToGo && thisZone != currentZone)						//if the function is not locked and the user clicked on a new item (not the current one)
  {
		newZone = thisZone;											//grabs the parameter, stores it for later use
		containerSwitch();
		newBestiaryContainer = document.getElementById("mainContainer_"+theNewContainer);
		newBestiaryContainer.style.zIndex = 50+10*forwardBackward;		//tricky; if forward, new item slides in behind the current item
		oldBestiaryContainer = document.getElementById("mainContainer_"+theOldContainer);
		oldBestiaryContainer.style.zIndex = 50+20*forwardBackward;	    //if backward, new item slides in in front of the current item
		startTheMove = window.setInterval(animationFunction,10);		//calls the Animation Execution Function
  }
	else if(thisZone == currentZone) hideContainerFunction();
}

function rightOrLeft()										//Animation Execution Function
{
  if (ticked > 1000)											//after one second has passed, i.e. one cycle is finished
  {
		window.clearInterval(startTheMove);		//stop the animation
		ticked = 0;														//reset the timer
		forwardBackward = 1;									//reset the scroll direction
		currentZone = newZone;								//make the new item the current item
		correctionValue = 0;
		okayToGo = true;											//unlock the Animation Control Function
		containerDeployed = true;
  }
  else
  {
		okayToGo = false;
		thisAngle = (Math.PI/2)*(ticked/990);	
		newBestiaryContainer.style.left = (965-Math.sin(thisAngle+correctionValue)*295)+"px"; 
		newBestiaryContainer.style.top = (50-(forwardBackward*Math.cos(thisAngle+correctionValue)*30))+"px";
		if(containerDeployed)
		{
			oldBestiaryContainer.style.left = (965-Math.sin(thisAngle+Math.PI/2)*295)+"px"; 
			oldBestiaryContainer.style.top = (50-(forwardBackward*Math.cos(thisAngle+Math.PI/2)*30))+"px"; 
		}
		ticked += 30;
  }
}

function hideContainer() { window.setTimeout("hideContainerFunction()",10); }

function hideContainerFunction()
{
	if(okayToGo)
	{
		if(containerDeployed)
		{
			containerDeployed = false;
			currentZone = "reset";
			startTheHideMove = window.setInterval("hideContainerAnimation()",10);
		}
	}
}

function hideContainerAnimation()										//Animation Execution Function
{
  if (ticked > 1000)											//after one second has passed, i.e. one cycle is finished
  {
		window.clearInterval(startTheHideMove);		//stop the animation
		ticked = 0;														//reset the timer
		forwardBackward = 1;									//reset the scroll direction
		correctionValue = 0;
		okayToGo = true;											//unlock the Animation Control Function
  }
  else
  {
		okayToGo = false;
		thisAngle = (Math.PI/2)*(ticked/990);	
		newBestiaryContainer.style.left = (965-Math.sin(thisAngle+Math.PI/2)*295)+"px"; 
		newBestiaryContainer.style.top = (50-(forwardBackward*Math.cos(thisAngle+Math.PI/2)*30))+"px"; 
		ticked += 30;
  }
}

/*##### Totally not an easter egg #####*/

	function addSegments(thisWidth,thisHeight,idBase)
	{
		targetElement = document.getElementById("notAnEasterEgg");
		baseId = idBase;
		for(i=0;i<thisHeight;i++)
		{
			targetElement.appendChild(newSegment(thisWidth,thisHeight,i));
		}
		fadeSetup(thisHeight);
	}
	
	function newSegment(thisWidth,thisHeight,thisID)
	{
		var newElement = document.createElement("div");
		newElement.style.backgroundImage = "url(/wrath/images/worldmap/rainbow.gif)"
		newElement.style.backgroundPosition = "0px -"+(thisHeight-thisID-1)*3+"px";
		newElement.style.height = "3px";
		newElement.style.width = thisWidth+"px";
		newElement.style.opacity = "0";
		newElement.style.filter = "alpha(opacity=0)";
		newElement.style.position = "absolute";
		newElement.style.top = eval(thisHeight-thisID-1)*3+"px";
		newElement.style.left = "0";
		newElement.id = baseId+thisID;
		return newElement;
	}
	
	function fadeSetup(thisHeight)
	{
		faderArray = new Array();
		faderCounter = 0;
		for(j=0;j<thisHeight;j++)
		{
			window.setTimeout("launchFade("+j+")",j*30);
		}
	}
	
	function launchFade(thisElement)
	{
		faderArray[faderCounter++] = window.setInterval("fadeSegment("+thisElement+")",10);
	}
	
	function fadeSegment(thisElement)
	{
		var currentSegment = document.getElementById(baseId+thisElement);
		if(currentSegment.style.opacity >= 1)
		{
			window.clearInterval(faderArray[thisElement]);
		}
		else
		{
			currentSegment.style.opacity = eval(currentSegment.style.opacity)+0.01;
			currentSegment.style.filter = "alpha(opacity="+(eval(currentSegment.style.opacity)+0.01)*100+")";
		}
	}
	
	unicorns = 0;
	candyLand = new Array();
	candyLand[0] = 1;
	candyLand[1] = 2;
	candyLand[2] = 3;
	candyLand[3] = 4;
	candyLand[4] = 5;
	candyLand[5] = 6;
	function checkForTreasure(thisZone)
	{
		if(candyLand[unicorns] == thisZone)
		{
			unicorns++;
			if(unicorns>5)
			{
				addSegments(495,58,'element');
				candyLand[0] = "Pie > Cake";
				unicorns = 42;
			}
		}
		else
		{
			unicorns=0;
		}
	}
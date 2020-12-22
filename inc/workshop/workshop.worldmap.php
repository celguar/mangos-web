<?php 

	echo '<br><span><b style="font-size: 16px">World Map - ';

switch ($_REQUEST['m']) {
	case "outland":
		echo 'Outland</b></span><br><span style="font-size: 10px">[<a href="?">Main Menu</a>] [<a href="?n=workshop.worldmap&m=azeroth">Change to Azeroth</a>] [<a href="?n=workshop.worldmap&m=northrend">Change to Northrend</a>]</span><br><br>';
		goldborderup(true); 
		?>
		<link rel="stylesheet" type="text/css" href="new-hp/css/wowmap.css">
		<script language="javascript" src="new-hp/js/bestiary-script.js"></script>
		<script language="javascript">
		is_safari = ((navigator.userAgent.indexOf("Safari")!=-1))?true:false;
		isShowing = false;

		function showTip(thisText)
		{
		  isShowing = true;
		  document.getElementById("toolBox").style.left = mouseX+10+"px";
		  document.getElementById("toolBox").style.top = mouseY+10+document.body.scrollTop+"px";
		  document.getElementById("toolBox").innerHTML = thisText;
		  document.getElementById("toolBox").style.display = "block";
		}

		function hideTip()
		{
		  document.getElementById("toolBox").style.display = "none";
		  isShowing = false;
		}

		function tipPosition(callingEvent)
		{
		  if (!callingEvent) callingEvent = window.event;
		  mouseX = callingEvent.clientX;
		  mouseY = callingEvent.clientY-1;
		  if (isShowing)
		  {
			document.getElementById("toolBox").style.left = mouseX+10+"px";
			document.getElementById("toolBox").style.top = (!is_safari) ? mouseY-80+document.body.scrollTop+"px" : mouseY+10+"px" ;
		  }
		}

		function popUpOmega (screenshot, width, height, caption) 
		{
			//Browser detection - is the user relying on the one browser where this script does not work?
			
			var name = "Sheenscrot"; 
			widthHeight = "width=" + width + ",height=" + height;
			winFeatures = "width=" + width + ",height=" + height + ",left=50,top=50,menubar=no,resizable=no,scrollbars=no,statusbar=no,toolbar=no,locationbar=no"
			if (is_safari) spawn = window.open(screenshot,name,winFeatures);
			else
			{
				spawn = window.open("new-hp/images/pixel.gif",name,winFeatures)
				spawn.document.write("<html> <head> <title>" + caption + "<\/title> <\/head> <body onBlur='self.close()' style='background-image:url(" + screenshot + "); background-repeat:no-repeat;'><\/body><\/html>"); 
				spawn.document.close();
			}
		}
		zoneNames = new Array("blades","hellfire","nagrand","nether","shadow","terokkar","zangar");
		zoneLore = new Array();
		i = 0;
		zoneLore[i++] = "\
		<span class='myTitle'>Blade's Edge Mountains</span>\
		<br><br>\
		<b>Level Range:</b> 65-68\
		<br><br>\
		<b>Cities:</b><br>\
		<div class='myBlue'>Sylvanaar</div>\
		<div class='myRed'>Thunderlord Stronghold</div>\
		<div class='myOrange'>Gronn'bor Shrine</div>\
		<br><br>\
		<b>Dungeon: Gruul's Lair</b> (Raid)<br>";
		zoneLore[i++] = "\
		<span class='myTitle'>Hellfire Peninsula</span>\
		<br><br>\
		<b>Level Range:</b> 58-63\
		<br><br>\
		<b>Cities:</b><br>\
		<div class='myBlue'>Honor Hold</div>\
		<div class='myBlue'>Temple of Sha'naar</div>\
		<div class='myRed'>Thrallmar</div>\
		<div class='myRed'>Falcon Watch</div>\
		<br><br>\
		<b>Dungeon: Hellfire Citadel</b><br>\
		<div class='myRight'>Level 60-62</div><div class='myLeft'>Hellfire Ramparts</div>\
		<div class='myRight'>Level 61-63</div><div class='myLeft'>The Blood Furnace</div>\
		<div class='myRight'>Level 70-72</div><div class='myLeft'>The Shattered Halls</div>\
		<div class='myRight'><b>Raid</b></div><div class='myLeft'>Magtheridon's Lair</div>\
		";
		zoneLore[i++] = "\
		<span class='myTitle'>Nagrand</span>\
		<br><br>\
		<b>Level Range:</b> 64-67\
		<br><br>\
		<b>Cities:</b><br>\
		<div class='myBlue'>Telaar</div>\
		<div class='myRed'>Garadar</div>\
		<div class='myOrange'>Aeris</div>\
		<div class='myYellow'>Halaa</div>\
		";
		zoneLore[i++] = "\
		<span class='myTitle'>Netherstorm</span>\
		<br><br>\
		<b>Level Range:</b> 67-70\
		<br><br>\
		<b>Cities:</b><br>\
		<div class='myYellow'>Area 52</div>\
		<div class='myYellow'>The Stormspire</div>\
		<br><br>\
		<b>Dungeon: Tempest Keep</b><br>\
		<div class='myRight'>Level 69-72</div><div class='myLeft'>The Mechanar</div>\
		<div class='myRight'>Level 70-72</div><div class='myLeft'>The Botanica</div>\
		<div class='myRight'>Level 70-72</div><div class='myLeft'>The Arcatraz</div>\
		<div class='myRight'><b>Raid</b></div><div class='myLeft'>Eye of the Storm</div>";
		zoneLore[i++] = "\
		<span class='myTitle'>Shadowmoon Valley</span>\
		<br><br>\
		<b>Level Range:</b> 67-70\
		<br><br>\
		<b>Cities:</b><br>\
		<div class='myBlue'>Wildhammer Stronghold</div>\
		<div class='myRed'>Shadowmoon Village</div>\
		<div class='myOrange'>Ancient Draenei Base</div>\
		<br><br>\
		<b>Dungeon: Black Temple</b> (Raid)<br>";
		zoneLore[i++] = "\
		<span class='myTitle'>Terokkar Forest</span>\
		<br><br>\
		<b>Level Range:</b> 62-65\
		<br><br>\
		<b>Cities:</b><br>\
		<div class='myBlue'>Allerian Stronghold</div>\
		<div class='myRed'>Stonebreaker Hold</div>\
		<div class='myYellow'>Shattrath City</div>\
		<br><br>\
		<b>Dungeon: Auchindoun</b><br>\
		<div class='myRight'>Level 64-66</div><div class='myLeft'>Auchenai Crypts</div>\
		<div class='myRight'>Level 65-67</div><div class='myLeft'>Shadow Labyrinth</div>\
		<div class='myRight'>Level 67-69</div><div class='myLeft'>Sethekk Halls</div>\
		<div class='myRight'>Level 70-72</div><div class='myLeft'>Mana-Tombs</div>\
		";
		zoneLore[i++] = "\
		<span class='myTitle'>Zangarmarsh</span>\
		<br><br>\
		<b>Level Range:</b> 60-64\
		<br><br>\
		<b>Cities:</b><br>\
		<div class='myBlue'>Telredor</div>\
		<div class='myBlue'>Orebor Harborage</div>\
		<div class='myRed'>Swamprat Post</div>\
		<div class='myRed'>Zabra'jin</div>\
		<div class='myOrange'>Cenarion Refuge</div>\
		<div class='myOrange'>Sporeggar</div>\
		<br><br>\
		<b>Dungeon: Coilfang Reservoir</b><br>\
		<div class='myRight'>Level 62-64</div><div class='myLeft'>The Slave Pens</div>\
		<div class='myRight'>Level 63-65</div><div class='myLeft'>The Underbog</div>\
		<div class='myRight'>Level 70-72</div><div class='myLeft'>The Steamvault</div>\
		<div class='myRight'><b>Raid</b></div><div class='myLeft'>Serpentshrine Cavern</div>\
		";
		i = 0;

		function showInfo(thisZone)
		{
		  document.getElementById("infoBox").innerHTML = zoneLore[thisZone];
		  document.getElementById("zoneLink").href = "javascript:popUpOmega('new-hp/images/maps/outland/ss"+thisZone+".jpg',800,600);";
		  document.getElementById("zoneThumb").src = "new-hp/images/maps/outland/ss"+thisZone+"-thumb.jpg";
		  checkForInteger(thisZone);
		}

		function toggleZoneOn(thisZone) { clearHighlights(); document.getElementById(thisZone).className = "zoneDivVis"; }
		function toggleZoneOff(thisZone) { document.getElementById(thisZone).className = "zoneDivHide"; }

		function clearHighlights()
		{
		  document.getElementById("blades").className = "zoneDivHide";
		  document.getElementById("hellfire").className = "zoneDivHide";
		  document.getElementById("nagrand").className = "zoneDivHide";
		  document.getElementById("nether").className = "zoneDivHide";
		  document.getElementById("shadow").className = "zoneDivHide";
		  document.getElementById("terokkar").className = "zoneDivHide";
		  document.getElementById("zangar").className = "zoneDivHide";
		}

		//-------- Frost's pointless integer check stuff for Rupert
		listOfIntegers = new Array(4,0,2,3,6,1,5);
		neitherFourNor = "false";

		function setNextToInteger() { for(j=0;j<7;j++) document.getElementById("nonInteger"+j).style.visibility = "hidden"; }

		function checkForInteger(notFour)
		{
		  if(notFour == 4) { neitherFourNor = "true"; setNextToInteger(); } if(neitherFourNor) { if(notFour != listOfIntegers[i]) { neitherFourNor = "false";
		  i = 0; setNextToInteger(); } else { document.getElementById("nonInteger"+notFour).style.visibility = "visible"; i++; } if(i==7) { resetAllIntegers();
		  } } else { setNextToInteger(); } document.getElementById("nonInteger"+notFour).style.visibility = "visible";
		}

		letterCounter = 0;
		ticToc = 0;
		function resetAllIntegers() { revealerContainer = window.setInterval("unfadeLetter("+letterCounter+")",30); }

		function unfadeLetter(thisLetter)
		{
		  if (ticToc > 500)
		  {
			window.clearInterval(revealerContainer);
			letterCounter++;
			ticToc = 0;
			if (letterCounter < 7)
			{
			  revealerContainer = window.setInterval("unfadeLetter("+letterCounter+")",30);
			}
			else
			{
			  document.getElementById("rupert").src = "new-hp/images/maps/outland/elf-dance.gif";
			}
		  }
		  else
		  {
			ticToc += 20;
			document.getElementById("stage"+thisLetter).style.opacity = ticToc / 500;
			document.getElementById("stage"+thisLetter).style.filter = "alpha(opacity="+(ticToc/5)+")";
		  }
		}

		document.onmousemove = tipPosition;
		</script>

		</head>

		<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0" bgcolor="#000000">
		<style type="text/css">

		.tooltipText{
		color: #ffffff;
		font-family: verdana, arial, sans-serif;
		font-size:11px;
		font-weight:normal;
		padding: 6px;
		text-align:justify;
		}

		.bandAidForIE
		{
		  position:absolute;
		  left:0px;
		  top:8px;
		}

		.goomba
		{
		  position:absolute;
		  left:-40px;
		  bottom:-20px;
		  _top:-52px;
		}

		.topLeft{width:14px; height:24px; background-repeat:no-repeat; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='new-hp/images/maps/outland/bestiary/top-left.png',sizingMethod='scale');}
		.topBox{height:24px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='new-hp/images/maps/outland/bestiary/top.png',sizingMethod='scale'); background-repeat:repeat-x;}
		.topRight{width:14px; height:24px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='new-hp/images/maps/outland/bestiary/top-right.png',sizingMethod='scale'); background-repeat:no-repeat;}
		.leftBox{width:14px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='new-hp/images/maps/outland/bestiary/left.png',sizingMethod='scale'); background-repeat:repeat-y;}
		.rightBox{width:14px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='new-hp/images/maps/outland/bestiary/right.png',sizingMethod='scale'); background-repeat:repeat-y;}
		.botLeft{width:14px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='new-hp/images/maps/outland/bestiary/bot-left.png',sizingMethod='scale'); background-repeat:no-repeat;}
		.botBox{height:24px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='new-hp/images/maps/outland/bestiary/bot.png',sizingMethod='scale'); background-repeat:repeat-x;}
		.botRight{width:14px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='new-hp/images/maps/outland/bestiary/bot-right.png',sizingMethod='scale'); background-repeat:no-repeat;}
		.mainBod{filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='new-hp/images/maps/outland/bestiary/black-bg.png',sizingMethod='scale');}

		.topLeft[class]{width:14px; height:24px; background-image:url(new-hp/images/maps/outland/bestiary/top-left.png); background-repeat:no-repeat;}
		.topBox[class]{height:24px; background-image:url(new-hp/images/maps/outland/bestiary/top.png); background-repeat:repeat-x;}
		.topRight[class]{width:14px; height:24px; background-image:url(new-hp/images/maps/outland/bestiary/top-right.png); background-repeat:no-repeat;}
		.leftBox[class]{width:14px; background-image:url(new-hp/images/maps/outland/bestiary/left.png); background-repeat:repeat-y;}
		.rightBox[class]{width:14px; background-image:url(new-hp/images/maps/outland/bestiary/right.png); background-repeat:repeat-y;}
		.botLeft[class]{width:14px; height:24px; background-image:url(new-hp/images/maps/outland/bestiary/bot-left.png); background-repeat:no-repeat;}
		.botBox[class]{height:24px; background-image:url(new-hp/images/maps/outland/bestiary/bot.png); background-repeat:repeat-x;}
		.botRight[class]{width:14px; height:24px; background-image:url(new-hp/images/maps/outland/bestiary/bot-right.png); background-repeat:no-repeat;}
		.mainBod[class]{background-image:url(new-hp/images/maps/outland/bestiary/black-bg.png)}

		.zoneDivHide { background-repeat:no-repeat; position:absolute; visibility:hidden; }
		.zoneDivVis { background-repeat:no-repeat; position:absolute; cursor:pointer; visibility:visible; }

		.myPurple { color: A335EE; font-weight: bold; }
		.myTitle { font-size:10pt; font-weight:bold; }
		.myBlue { color: 0070DD; font-weight: bold; margin-left:7px; font-size:11px; line-height:13px; }
		.myRed { color: DD0000; font-weight: bold; margin-left:7px; font-size:11px; line-height:13px; }
		.myOrange { color: DD7000; font-weight: bold; margin-left:7px; font-size:11px; line-height:13px; }
		.myYellow { color: DDDD00; font-weight: bold; margin-left:7px; font-size:11px; line-height:13px; }
		.myLeft { margin-left:7px; font-size:11px; line-height:13px; }
		.myRight { position:absolute; right:5px; font-size:11px; }

		.cNeu { color: DD7000; font-weight: bold; font-size:11px; line-height:13px; }
		.cAll { color: 0070DD; font-weight: bold; font-size:11px; line-height:13px; }
		.cHor { color: DD0000; font-weight: bold; font-size:11px; line-height:13px; }
		.cYel { color: DDDD00; font-weight: bold; font-size:11px; line-height:13px; }
		.cPur { color: A335EE; font-weight: bold; font-size:11px; line-height:13px; }

		.integerStyle { position:absolute; background-color:#BCBCBC; width:2px; height:2px; line-height:2px; font-size:2px; top:490px; visibility:hidden; }
		.POIstyle { position:absolute; width:15px; height:15px; line-height:2px; font-size:2px; }
		.letterStyle { filter:alpha(opacity=0); position:absolute; top:482px; left:30px; opacity:0; }

		</style>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000" style="background-image:url(new-hp/images/maps/outland/2_bgtile.jpg); background-position:top; background-repeat:repeat-x;">
		  <tr>
			<td width="50%" valign="top" style="background-image:url(new-hp/images/maps/outland/2_leftbg.gif); background-repeat:repeat-y; background-position:top right;">
			  <div style="background-image:url(new-hp/images/maps/outland/2_topleft.jpg); background-repeat:no-repeat; background-position:top right; width:100%; height:170;"></div>
			</td>
			<td width="955" style="background-image:url(new-hp/images/maps/outland/bestiary/bg-fix.gif); background-repeat:repeat-y; background-position:top right;">
			  <div style="background-image:url(new-hp/images/maps/outland/bg-center.jpg); position:relative; background-repeat:no-repeat; background-position:top; width:955px; height:635px;">

				<table border="0" cellpadding="0" cellspacing="0" style="margin-left:15px; margin-top:10px;">
				  <tr>
					<td class="topLeft"></td>
					<td class="topBox"></td>
					<td class="topRight"></td>
				  </tr>
				  <tr>
					<td class="leftBox"></td>
					<td>
		<div style="background-image:url(new-hp/images/maps/outland/mapback.jpg); width:800px; height:579px; position:relative;">

		<map name="zoneMap">
		<!--
		<area shape="poly" onMouseOver="clearHighlights();" coords="377,2, 377,56, 325,65, 308,78, 259,88, 249,104, 224,211, 184,210, 153,287, 169,322, 161,342, 117,352, 117,386, 131,394, 138,409, 187,463, 312,483, 322,513, 377,516, 377,577, 0,574, 4,0">
		<area shape="poly" coords="799,4, 795,578, 378,577, 378,516, 430,522, 457,538, 593,537, 669,502, 690,470, 661,446, 568,415, 506,422, 500,409, 478,387, 512,382, 542,387, 591,374, 629,343, 639,305, 617,258, 572,222, 506,221, 501,240, 457,235, 451,249, 397,250, 397,216, 423,206, 414,154, 428,153, 433,174, 496,198, 560,201, 606,162, 628,109, 611,53, 579,31, 506,20, 452,31, 389,57, 378,56, 378,2">
		-->
		<area href="javascript:showInfo(4);" coords="642,467,657,482" onMouseOver="showTip('<span class=cPur>Black Temple</span><br>- Dungeon -')" onMouseOut="hideTip()" shape="rect">
		<area href="javascript:showInfo(4);" coords="538,500,553,515" onMouseOver="showTip('<span class=cAll>Wildhammer Stronghold</span><br>- Alliance -')" onMouseOut="hideTip()" shape="rect">
		<area href="javascript:showInfo(4);" coords="585,449,600,464" onMouseOver="showTip('<span class=cNeu>Ancient Draenei Base</span><br>- Faction -')" onMouseOut="hideTip()" shape="rect">
		<area href="javascript:showInfo(4);" coords="514,451,529,466" onMouseOver="showTip('<span class=cHor>Shadowmoon Village</span><br>- Horde -')" onMouseOut="hideTip()" shape="rect">

		<area href="javascript:showInfo(5);" shape="rect" coords="433,455,448,470" onMouseOver="showTip('<span class=cAll>Allerian Stronghold</span><br>- Alliance -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(5);" shape="rect" coords="385,469,400,484" onMouseOver="showTip('<span class=cPur>Auchindoun</span><br>- Dungeon -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(5);" shape="rect" coords="407,432,422,447" onMouseOver="showTip('<span class=cHor>Stonebreaker Hold</span><br>- Horde -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(5);" shape="rect" coords="361,389,376,404" onMouseOver="showTip('<span class=cYel>Shattrath City</span><br>- Neutral -')" onMouseOut="hideTip()">

		<area href="javascript:showInfo(2);" shape="rect" coords="256,430,271,445" onMouseOver="showTip('<span class=cAll>Telaar</span><br>- Alliance -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(2);" shape="rect" coords="188,397,203,412" onMouseOver="showTip('<span class=cNeu>Aeris</span><br>- Faction -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(2);" shape="rect" coords="260,356,275,371" onMouseOver="showTip('<span class=cHor>Garadar</span><br>- Horde -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(2);" shape="rect" coords="221,371,236,386" onMouseOver="showTip('<span class=cYel>Halaa</span><br>- Neutral -')" onMouseOut="hideTip()">

		<area href="javascript:showInfo(6);" shape="rect" coords="191,272,206,287" onMouseOver="showTip('<span class=cNeu>Sporeggar</span><br>- Faction -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(6);" shape="rect" coords="223,270,238,285" onMouseOver="showTip('<span class=cHor>Zabra\'jin</span><br>- Horde -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(6);" shape="rect" coords="276,254,291,269" onMouseOver="showTip('<span class=cPur>Coilfang Reservoir</span><br>- Dungeon -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(6);" shape="rect" coords="250,234,265,249" onMouseOver="showTip('<span class=cAll>Orebor Harborage</span><br>- Alliance -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(6);" shape="rect" coords="325,271,340,286" onMouseOver="showTip('<span class=cAll>Telredor</span><br>- Alliance -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(6);" shape="rect" coords="354,296,369,311" onMouseOver="showTip('<span class=cNeu>Cenarion Refuge</span><br>- Faction -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(6);" shape="rect" coords="369,279,384,294" onMouseOver="showTip('<span class=cHor>Swamprat Post</span><br>- Horde -')" onMouseOut="hideTip()">

		<area href="javascript:showInfo(1);" shape="rect" coords="430,320,445,335" onMouseOver="showTip('<span class=cHor>Falcon Watch</span><br>- Horde -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(1);" shape="rect" coords="420,276,435,291" onMouseOver="showTip('<span class=cAll>Temple of Sha\'naar</span><br>- Alliance -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(1);" shape="rect" coords="510,324,525,339" onMouseOver="showTip('<span class=cAll>Honor Hold</span><br>- Alliance -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(1);" shape="rect" coords="489,300,504,315" onMouseOver="showTip('<span class=cPur>Hellfire Citadel</span><br>- Dungeon -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(1);" shape="rect" coords="601,297,616,312" onMouseOver="showTip('<span class=cNeu>The Dark Portal</span><br>')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(1);" shape="rect" coords="509,271,524,286" onMouseOver="showTip('<span class=cHor>Thrallmar</span><br>- Horde -')" onMouseOut="hideTip()">

		<area href="javascript:showInfo(3);" shape="rect" coords="596,133,611,148" onMouseOver="showTip('<span class=cPur>Tempest Keep</span><br>- Dungeon -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(3);" shape="rect" coords="498,71,513,86" onMouseOver="showTip('<span class=cYel>The Stormspire</span><br>- Neutral -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(3);" shape="rect" coords="467,138,482,153" onMouseOver="showTip('<span class=cYel>Area 52</span><br>- Neutral -')" onMouseOut="hideTip()">

		<area href="javascript:showInfo(0);" shape="rect" coords="332,153,347,168" onMouseOver="showTip('<span class=cHor>Thunderlord Stronghold</span><br>- Horde -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(0);" shape="rect" coords="283,176,298,191" onMouseOver="showTip('<span class=cAll>Sylvanaar</span><br>- Alliance -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(0);" shape="rect" coords="298,152,313,167" onMouseOver="showTip('<span class=cNeu>Gronn\'bor Shrine</span><br>- Faction -')" onMouseOut="hideTip()">
		<area href="javascript:showInfo(0);" shape="rect" coords="347,106,362,121" onMouseOver="showTip('<span class=cPur>Gruul\'s Lair</span><br>- Dungeon -')" onMouseOut="hideTip()">

		<area href="javascript:showInfo(4);" onMouseOver="toggleZoneOn('shadow');" shape="poly" coords="526,427, 497,443, 488,460, 503,483, 531,495, 538,508, 530,533, 580,536, 663,500, 685,470, 664,453, 618,443, 575,420">
		<area href="javascript:showInfo(5);" onMouseOver="toggleZoneOn('terokkar');" shape="poly" coords="345,357, 345,363, 360,371, 348,379, 358,386, 348,432, 357,435, 355,455, 343,460, 332,484, 324,484, 326,507, 422,511, 457,532, 524,528, 532,509, 523,499, 495,486, 483,461, 491,438, 498,434, 499,417, 485,400, 461,390, 438,398, 387,374, 373,359">
		<area href="javascript:showInfo(2);" onMouseOver="toggleZoneOn('nagrand');" shape="poly" coords="176,323, 176,333, 166,347, 122,352, 119,383, 135,388, 137,399, 186,457, 328,476, 338,453, 349,450, 350,439, 342,438, 352,388, 336,379, 347,371, 334,365, 332,352, 302,324, 245,319, 200,330">
		<area href="javascript:showInfo(6);" onMouseOver="toggleZoneOn('zangar');" shape="poly" coords="232,219, 248,230, 270,230, 270,247, 382,269, 388,278, 387,297, 369,315, 368,333, 387,345, 377,354, 342,353, 308,319, 241,314, 202,323, 177,318, 160,284, 188,213">
		<area href="javascript:showInfo(1);" onMouseOver="toggleZoneOn('hellfire');" shape="poly" coords="396,261, 391,265, 394,298, 378,315, 378,330, 397,343, 385,357, 393,370, 439,392, 501,371, 537,384, 577,374, 621,346, 632,310, 614,266, 572,228, 512,223, 509,248, 480,240, 462,242, 459,253">
		<area href="javascript:showInfo(3);" onMouseOver="toggleZoneOn('nether');" shape="poly" coords="429,82, 416,99, 429,131, 435,168, 488,191, 551,199, 614,156, 623,114, 609,59, 580,38, 520,26, 467,28, 424,51">
		<area href="javascript:showInfo(0);" onMouseOver="toggleZoneOn('blades');" shape="poly" coords="317,80, 267,87, 256,101, 239,212, 252,221, 274,224, 281,244, 381,263, 389,257, 389,212, 417,203, 405,151, 422,131, 408,97, 421,81, 415,67, 372,60, 332,66">

		<area shape="rect" onMouseOver="clearHighlights();" coords="0,0, 800,579">
		</map>

		  <div id="blades" class="zoneDivHide" style="width:207px; height:230px; background-image:url(new-hp/images/maps/outland/blades.jpg); left:227px; top:47px;"></div>
		  <div id="hellfire" class="zoneDivHide" style="width:274px; height:188px; background-image:url(new-hp/images/maps/outland/hellfire.jpg); left:361px; top:215px;"></div>
		  <div id="zangar" class="zoneDivHide" style="width:252px; height:165px; background-image:url(new-hp/images/maps/outland/zangar.jpg); left:149px; top:202px;"></div>
		  <div id="nagrand" class="zoneDivHide" style="width:258px; height:182px; background-image:url(new-hp/images/maps/outland/nagrand.jpg); left:106px; top:303px;"></div>
		  <div id="nether" class="zoneDivHide" style="width:213px; height:184px; background-image:url(new-hp/images/maps/outland/nether.jpg); left:405px; top:23px;"></div>
		  <div id="terokkar" class="zoneDivHide" style="width:236px; height:202px; background-image:url(new-hp/images/maps/outland/terokkar.jpg); left:310px; top:344px;"></div>
		  <div id="shadow" class="zoneDivHide" style="width:213px; height:133px; background-image:url(new-hp/images/maps/outland/shadow.jpg); left:477px; top:413px;"></div>

		  <span style="position:absolute; top:-48px; left:-33px;"><script language="javascript">pngImage("new-hp/images/maps/outland/page-title.png");</script></span>
		  <div style="position:absolute; top:-10px; left:-30px;"><img id="rupert" SRC="new-hp/images/maps/outland/elf-stand2.gif"></div>
		  <img SRC="new-hp/images/pixel.gif" width="800" height="579" border="0" usemap="#zoneMap" style="position:absolute;"/>
		<!--
		  <div class="POIstyle" style="border:1px solid red; left:283px; top:174px;" onMouseOver="showTip('<span class=cAll>Sylvanaar</span><br>- Alliance -')" onMouseOut="hideTip()"></div>
		-->

		  <div id="nonInteger4" class="integerStyle" style="left:70px;"></div><div id="nonInteger0" class="integerStyle" style="left:110px;"></div>
		  <div id="nonInteger2" class="integerStyle" style="left:145px;"></div><div id="nonInteger3" class="integerStyle" style="left:170px;"></div>
		  <div id="nonInteger6" class="integerStyle" style="left:208px;"></div><div id="nonInteger1" class="integerStyle" style="left:246px;"></div>
		  <div id="nonInteger5" class="integerStyle" style="left:283px;"></div>

		  <img id="stage0" class="letterStyle" SRC="new-hp/images/maps/outland/stage0.jpg"><img id="stage1" class="letterStyle" SRC="new-hp/images/maps/outland/stage1.jpg">
		  <img id="stage2" class="letterStyle" SRC="new-hp/images/maps/outland/stage2.jpg"><img id="stage3" class="letterStyle" SRC="new-hp/images/maps/outland/stage3.jpg">
		  <img id="stage4" class="letterStyle" SRC="new-hp/images/maps/outland/stage4.jpg"><img id="stage5" class="letterStyle" SRC="new-hp/images/maps/outland/stage5.jpg">
		  <img id="stage6" class="letterStyle" SRC="new-hp/images/maps/outland/stage6.jpg">
		  
		  <div style="width:270px; height:405px; position:absolute; top:30px; right:-117px;">
				<table border="0" cellpadding="0" cellspacing="0" width="270" height="405">
				  <tr>
					<td class="topLeft"></td>
					<td class="topBox"></td>
					<td class="topRight"></td>
				  </tr>
				  <tr>
					<td class="leftBox"></td>
					<td class="mainBod" valign="top">
					  <div class="tooltipText" style="text-align:left; position:relative;">
						<div id="infoBox">
						<span class='myTitle'>Outland awaits...</span>
						<br><br>
						Beyond the Dark Portal lies the shattered realm of Outland, the broken remains of the orcs' homeworld, Draenor. Among the ruins of this world, the survivors of the cataclysm are trying to rebuild, and in other parts of Outland, life continues to thrive. Those brave enough to make the journey through the Dark Portal will find new allies, new enemies, and limitless adventure beyond an untamed horizon.
						<br><br>
						Click on any region in the map to learn more about that zone's faction bases, dungeons, and neutral cities waiting to be discovered in World of Warcraft: The Burning Crusade.
						</div>
					  </div>
					</td>
					<td class="rightBox"></td>
				  </tr>
				  <tr>
					<td class="botLeft"></td>
					<td class="botBox"></td>
					<td class="botRight"></td>
				  </tr>
				</table>  
		  </div>
		  <div style="position:absolute; right:-120px; top:325px;"><a id="zoneLink" href="javascript:popUpOmega('new-hp/images/maps/outland/ss01.jpg',800,600);"><img id="zoneThumb" SRC="new-hp/images/maps/outland/ss01-thumb.jpg" border="0"></a></div>
		</div>
					</td>
					<td class="rightBox"></td>
				  </tr>
				  <tr>
					<td class="botLeft"></td>
					<td class="botBox"></td>
					<td class="botRight"></td>
				  </tr>
				</table>  
				<div style="padding-left:45px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:white;">Note: All dungeon and region levels on this page are the expected monster levels, not player character levels</div>
		<!-- END OF MAIN BACKGROUND -->
			 </div>
			</td>
			<td width="50%" valign="top" style="background-image:url(new-hp/images/maps/outland/2_rightbg.gif); background-repeat:repeat-y; background-position:top left;">
			 <div style="background-image:url(new-hp/images/maps/outland/2_topright.jpg); background-repeat:no-repeat; background-position:top left; width:100%; height:170;"></div>
			</td>
		  </tr>
		</table>
		<br>
		<?php
		goldborderdown(true); 
		?>
		<div id="toolBox" style="display:none; width: 100px; position:absolute; top:20px; color:#FFFFFF; background-color:#000000; border:1px solid #DDDDDD; font-family:Arial, Helvetica, sans-serif; padding:3px; text-align:center; font-size:9px; border-bottom-color:#666666; border-right-color:#666666;">InfoTip</div>
		<?
	break;
	case "azeroth":
	default:
		?>
		<?
		echo 'Azeroth</b></span><br><span style="font-size: 10px">[<a href="?">Main Menu</a>] [<a href="?n=workshop.worldmap&m=outland">Change to Outland</a>][<a href="?n=workshop.worldmap&m=northrend">Change to Northrend</a>]</span><br><br>';
		goldborderup(true); 

		?>
		<embed src="new-hp/flash/00_world.swf" wmode="transparent"
		quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" 
		type="application/x-shockwave-flash" width="800" height="533"></embed>
		<?

		goldborderdown(true);
		 
	break;
	case "Northrend":
	default:
			?>
		<?
		echo 'Northrend</b></span><br><span style="font-size: 10px">[<a href="?">Main Menu</a>] [<a href="?n=workshop.worldmap&m=outland">Change to Outland</a>][<a href="?n=workshop.worldmap&m=azeroth">Change to Azeroth</a>]</span><br><br>';


$varri = "/wrath/index.xml";
?>

  <iframe src=<?php print $varri; ?> align=center width=100% height="900" scrolling="no" frameborder="no"> </iframe><?;
		goldborderdown(true);
		 
	break;
}


<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="global.xsl"/>

<xsl:template name="styles">
	div.sub-header-top { background-image:url('<xsl:value-of select="$baseurl"/>images/worldmap/header.jpg'); }
	.worldmapPageContent { background:url('<xsl:value-of select="$baseurl"/>images/worldmap/<xsl:value-of select="$lang"/>/pagebg.jpg') no-repeat; width:100%; position:relative; height:625px; }
</xsl:template>

<xsl:template match="wrathmap">
	<xsl:variable name="class" select="@class"/>
	<xsl:call-template name="mapPage">
		<xsl:with-param name="subtitlename" select="$loc/strs/worldmap/str[@id=$class]"/>
	</xsl:call-template>
</xsl:template>

<xsl:template name="mapPage">
	<xsl:param name="subtitlename"/>
	<div class="sub-header-top">
		<xsl:call-template name="wrathlogo-subpage"/>	
	</div>
	<div>
		<xsl:call-template name="pagecontents"/>
		<div>
			<div class="blizzlogocontainer" style="margin-top:0;">
				<xsl:call-template name="blizzardlogo"/>
			</div>
		</div>
	</div>
</xsl:template>

<xsl:template name="pagecontents">
	<xsl:call-template name="wrathmap">
		<xsl:with-param name="class" select="@class"/>
	</xsl:call-template>
</xsl:template>

<xsl:template name="wrathmap">
	<xsl:param name="class"/>
	<xsl:variable name="textPath" select="document(concat('../strings/',$lang,'/features/worldmap.xml'))"/>
	<div style="display:none;" id="hiResStringContainer"><xsl:value-of select="$loc/strs/str[@id='labels.downloadhires']"/></div>
	<script language="javascript" src="/wrath/js/worldmap-script.js"/>
	<script language="javascript" src="/wrath/js/hydravision.js"/>

	<style type="text/css">
		.nothrend { position:relative; }
		.myMapClass { width:952px; height:635px; position:relative; background:url(/wrath/images/worldmap/northrend.jpg); overflow:hidden; }
		.infoBox { width:281px; position:absolute; top:0; right:-325px; }
		.infoBoxTop {width:100%; height:21px; background:url(/wrath/images/worldmap/infobox-top.gif); }
		.infoBoxDiv { position:relative; width:100%; height:100%; background:url(/wrath/images/worldmap/infobox-back.jpg); }
		.infoBoxBottom {width:100%; height:21px; background:url(/wrath/images/worldmap/infobox-bottom.gif); }
		
		.loreDiv { margin:0 20px; font-family: Arial, Helvetica, sans-serif; color: #EAFDFF; font-size:12px; line-height:16px; }
		.loreDiv p { margin-top:15px; }
		.loreDiv span { float:right; margin-right:20px; color:white; }
		.loreDiv div { padding-left:20px; }
		
		.allianceTowns { color:#6699ff; background:url(/wrath/images/worldmap/alliance.gif) 0px 3px no-repeat; font-size:1px; line-height:12px; padding-top:5px; }
		.allianceTowns b { font-size:12px; }
		.hordeTowns { color:#ff3300; background:url(/wrath/images/worldmap/horde.gif) 0px 3px no-repeat; font-size:1px; line-height:12px; padding-top:5px; }
		.hordeTowns b { font-size:12px; }
		.neutralTowns { color:#9e761d; background:url(/wrath/images/worldmap/neutral.gif) 0px 3px no-repeat; font-size:1px; line-height:12px; padding-top:5px; }
		.neutralTowns b { font-size:12px; }
		
		.closerDiv { position:absolute; top:-18px; right:3px; width:17px; height:17px; line-height:1px; background:url(/wrath/images/worldmap/closer.gif) no-repeat; background-position:0 0; overflow:hidden; cursor:pointer; }
		.screenshotBackplate { position:relative; width:281px; height:184px; background:url(/wrath/images/worldmap/zonescreenbackplate.jpg) no-repeat 13px 0; }
		.screenshotDiv { position:absolute; top:0; left:21px; width:237px; height:176px; cursor:pointer; }
		.screenshotTitle { position:absolute; bottom:7px; left:18px; width:220px; font:bold 24px Georgia, "Times New Roman", Times, serif; letter-spacing:-1px; font-variant:small-caps; color:#000000; }
		.screenshotTitle div { position:absolute; top:-2px; left:-2px; color:#9ed1f3; }
		.dungeonStyle { color:black; position:relative; display:block; }
		.dungeonStyle b { text-decoration:none; position:absolute; top:-1px; left:-1px; color:#0066BB; }
		.wingedStyle { color:black; position:relative; display:block; }
		.wingedStyle b { text-decoration:none; position:absolute; top:-1px; left:-1px; color:white; }
		.raidStyle { color:black; position:relative; display:block; }
		.raidStyle b { text-decoration:none; position:absolute; top:-1px; left:-1px; color:#b520f3; }
		.wingedDungeon b { color:white; }

		#borean { width:280px; height:220px; position:absolute; top:292px; left:62px; background:url(/wrath/images/worldmap/<xsl:value-of select="$lang"/>/borean.jpg) no-repeat; }
		#sholazar { width:196px; height:160px; position:absolute; top:189px; left:147px; background:url(/wrath/images/worldmap/<xsl:value-of select="$lang"/>/sholazar.jpg) no-repeat; }
		#wintergrasp { width:164px; height:106px; position:absolute; top:251px; left:250px; background:url(/wrath/images/worldmap/<xsl:value-of select="$lang"/>/wintergrasp.jpg) no-repeat; }
		#dragonblight { width:291px; height:182px; position:absolute; top:270px; left:311px; background:url(/wrath/images/worldmap/<xsl:value-of select="$lang"/>/dragonblight.jpg) no-repeat; }
		#grizzly { width:230px; height:189px; position:absolute; top:264px; left:569px; background:url(/wrath/images/worldmap/<xsl:value-of select="$lang"/>/grizzly.jpg) no-repeat; }
		#howling { width:227px; height:248px; position:absolute; top:359px; left:627px; background:url(/wrath/images/worldmap/<xsl:value-of select="$lang"/>/howling.jpg) no-repeat; }
		#zul { width:250px; height:214px; position:absolute; top:155px; left:549px; background:url(/wrath/images/worldmap/<xsl:value-of select="$lang"/>/zul.jpg) no-repeat; }
		#storm { width:334px; height:314px; position:absolute; top:21px; left:417px; background:url(/wrath/images/worldmap/<xsl:value-of select="$lang"/>/storm.jpg) no-repeat; }
		#icecrown { width:257px; height:257px; position:absolute; top:74px; left:218px; background:url(/wrath/images/worldmap/<xsl:value-of select="$lang"/>/icecrown.jpg) no-repeat; }
		#dalaran { width:200px; height:193px; position:absolute; top:0; left:762px; background:url(/wrath/images/worldmap/<xsl:value-of select="$lang"/>/dalaran.jpg) no-repeat; }
		#crystalsong { width:168px; height:92px; position:absolute; top:225px; left:412px; background:url(/wrath/images/worldmap/<xsl:value-of select="$lang"/>/crystalsong.jpg) no-repeat; }
	</style>

	<map name="zoneMap">
		<area shape="poly" href="javascript:moveItem(0);" onmouseover="toggleZone('dalaran');" onmouseout="toggleZone('dalaran');" coords="834,8, 816,74, 809,51, 777,105, 790,123, 809,116, 860,169, 909,124, 923,136, 938,107, 929,106, 942,91, 925,85, 913,48, 904,48, 898,70, 886,41, 880,67, 855,66, 847,42, 843,49, 839,40, 845,32"/>
		<area shape="poly" href="javascript:moveItem(1);" onmouseover="toggleZone('storm');" onmouseout="toggleZone('storm');" coords="525,39, 509,63, 514,103, 484,101, 466,118, 441,119, 440,173, 456,186, 456,226, 442,234, 459,251, 481,251, 494,265, 549,273, 566,241, 645,209, 703,207, 714,183, 668,108, 627,91, 595,95, 591,56, 569,35"/>
		<area shape="poly" href="javascript:moveItem(2);" onmouseover="toggleZone('zul');" onmouseout="toggleZone('zul');" coords="744,165, 716,190, 713,214, 659,221, 573,253, 562,278, 576,285, 571,302, 571,333, 600,343, 638,341, 691,297, 703,298, 736,281, 736,231, 773,195"/>
		<area shape="poly" href="javascript:moveItem(3);" onmouseover="toggleZone('howling');" onmouseout="toggleZone('howling');" coords="710,372, 683,375, 642,441, 645,536, 683,576, 728,564, 768,583, 812,563, 830,498, 809,434, 816,415, 775,370, 748,375, 736,390, 723,390"/>
		<area shape="poly" href="javascript:moveItem(4);" onmouseover="toggleZone('grizzly');" onmouseout="toggleZone('grizzly');" coords="585,356, 585,416, 637,432, 675,367, 722,362, 726,380, 736,380, 748,367, 769,361, 768,347, 753,334, 764,304, 753,280, 742,278, 740,290, 704,311, 697,306, 640,352"/>
		<area shape="poly" href="javascript:moveItem(5);" onmouseover="toggleZone('dragonblight');" onmouseout="toggleZone('dragonblight');" coords="401,301, 399,335, 348,348, 340,370, 346,389, 387,420, 496,420, 516,430, 560,412, 571,420, 573,370, 560,305, 545,317, 478,291, 462,302, 433,290"/>
		<area shape="poly" href="javascript:moveItem(6);" onmouseover="toggleZone('borean');" onmouseout="toggleZone('borean');" coords="121,319, 80,347, 87,395, 130,413, 135,441, 183,465, 211,437, 230,397, 266,409, 304,395, 319,367, 304,343, 280,328, 232,338, 181,326"/>
		<area shape="poly" href="javascript:moveItem(7);" onmouseover="toggleZone('sholazar');" onmouseout="toggleZone('sholazar');" coords="222,202, 198,226, 177,233, 165,257, 167,307, 238,324, 274,311, 304,277, 323,268, 308,254, 304,242, 280,231, 269,207"/>
		<area shape="poly" href="javascript:moveItem(8);" onmouseover="toggleZone('wintergrasp');" onmouseout="toggleZone('wintergrasp');" coords="342,264, 330,268, 325,280, 311,285, 288,314, 316,337, 344,337, 371,326, 389,328, 390,298, 374,281"/>
		<area shape="poly" href="javascript:moveItem(9);" onmouseover="toggleZone('icecrown');" onmouseout="toggleZone('icecrown');" coords="337,91, 317,116, 304,114, 282,136, 282,159, 238,189, 238,198, 276,202, 288,224, 315,241, 317,257, 326,260, 350,257, 397,291, 435,279, 421,259, 431,223, 447,221, 444,189, 431,177, 433,111, 420,91, 408,104, 366,99, 358,88"/>
		<area shape="poly" href="javascript:moveItem(10);" onmouseover="toggleZone('crystalsong');" onmouseout="toggleZone('crystalsong');" coords="436,239, 430,264, 440,273, 440,282, 457,292, 479,279, 545,307, 563,294, 546,281, 492,273, 479,259, 457,256"/>
  </map>

	<div class="worldmapPageContent">
		<div style="position:absolute; left:14px; top:-20px; width:952px; height:635px;">
			<div style="position:relative; width:965px; height:100%; overflow:hidden;">
				
				<div id="borean" name="zoneLight" style="visibility:hidden;"/>
				<div id="sholazar" name="zoneLight" style="visibility:hidden;"/>
				<div id="wintergrasp" name="zoneLight" style="visibility:hidden;"/>
				<div id="dragonblight" name="zoneLight" style="visibility:hidden;"/>
				<div id="grizzly" name="zoneLight" style="visibility:hidden;"/>
				<div id="howling" name="zoneLight" style="visibility:hidden;"/>
				<div id="zul" name="zoneLight" style="visibility:hidden;"/>
				<div id="storm" name="zoneLight" style="visibility:hidden;"/>
				<div id="icecrown" name="zoneLight" style="visibility:hidden;"/>
				<div id="dalaran" name="zoneLight" style="visibility:hidden;"/>
				<div id="crystalsong" name="zoneLight" style="visibility:hidden;"/>
				
				<div style="position:absolute; top:443px; left:116px;">
					<div id="notAnEasterEgg" style="width:495px; height:174px; position:relative;"/>
				</div>
				
				<div class="infoBox" id="mainContainer_1">
					<div class="infoBoxTop"/>
					<div class="infoBoxDiv">
						<div class="screenshotBackplate" onclick="hydraVision('/wrath/images/worldmap/zone'+newZone+'.jpg');" id="screenshotLauncher_1">
							<div class="screenshotDiv" id="screenshotBox_1"/>
							<div class="screenshotTitle" id="screenshotTitle_1"/>
						</div>
						<div class="closerDiv" onmouseover="this.style.backgroundPosition = '0px -17px'" onmouseout="this.style.backgroundPosition = '0 0'" onclick="hideContainerFunction()"/>
						<div id="loreContainer_1" class="loreDiv"/>
					</div>
					<div class="infoBoxBottom"/>
				</div>
		
				<div class="infoBox" id="mainContainer_2">
					<div class="infoBoxTop"/>
					<div class="infoBoxDiv">
						<div class="screenshotBackplate" onclick="hydraVision('/wrath/images/worldmap/zone'+newZone+'.jpg');" id="screenshotLauncher_2">
							<div class="screenshotDiv" id="screenshotBox_2"/>
							<div class="screenshotTitle" id="screenshotTitle_2"/>
						</div>
						<div class="closerDiv" onmouseover="this.style.backgroundPosition = '0px -17px'" onmouseout="this.style.backgroundPosition = '0 0'" onclick="hideContainerFunction()"/>
						<div id="loreContainer_2" class="loreDiv"/>
					</div>
					<div class="infoBoxBottom"/>
				</div>
		
				<img id="northrendMap" class="nothrend" src="/wrath/images/worldmap/bigfoot.gif" width="1002" height="668" border="0" usemap="#zoneMap"/>

			</div>
		</div>
	</div>
	
	<div onclick="addSegments(495,58,'element');"/>

	<div style="display:none;">
		<xsl:for-each select="$textPath/content/zones/zone">
			<div id="zone{@zoneId}" class="{@zoneName}">
				<b><xsl:value-of select="$textPath/content/strings/levelRange"/></b> <xsl:value-of select="@levelRange"/>
				<xsl:for-each select="cities">
					<p>
						<b><xsl:value-of select="$textPath/content/strings/flightPoints"/></b>
						<xsl:if test="@alliance='true'">
							<div class="allianceTowns">
								<xsl:for-each select="alliance"><b><xsl:apply-templates/></b><br/></xsl:for-each>
							</div>
						</xsl:if>
						<xsl:if test="@horde='true'">
							<div class="hordeTowns">
								<xsl:for-each select="horde"><b><xsl:apply-templates/></b><br/></xsl:for-each>
							</div>
						</xsl:if>
						<xsl:if test="@neutral='true'">
							<div class="neutralTowns">
								<xsl:for-each select="neutral"><b><xsl:apply-templates/></b><br/></xsl:for-each>
							</div>
						</xsl:if>
					</p>
				</xsl:for-each>
				<xsl:for-each select="dungeons/dungeon">
					<p>
						<b class="{@type}Style {@winged}">
							<xsl:choose>
								<xsl:when test="@type = 'dungeon'"><xsl:value-of select="$textPath/content/strings/dungeon"/></xsl:when>
								<xsl:otherwise><xsl:value-of select="$textPath/content/strings/raid"/>: </xsl:otherwise>
							</xsl:choose>
							<xsl:value-of select="@name"/>
							<b>
								<xsl:choose>
									<xsl:when test="@type = 'dungeon'"><xsl:value-of select="$textPath/content/strings/dungeon"/></xsl:when>
									<xsl:otherwise><xsl:value-of select="$textPath/content/strings/raid"/>: </xsl:otherwise>
								</xsl:choose>
								<xsl:value-of select="@name"/>
							</b>
						</b>
						<div>
							<xsl:for-each select="wing">
								<b class="{@type}Style">
									<xsl:choose>
										<xsl:when test="@type = 'raid'">
											<span><xsl:value-of select="$textPath/content/strings/raid"/></span>
											<xsl:value-of select="@name"/>
											<b><xsl:value-of select="@name"/></b>
											<br/>
										</xsl:when>
										<xsl:otherwise>
											<span><xsl:value-of select="$textPath/content/strings/level"/><xsl:value-of select="@levelRange"/></span>
											<xsl:value-of select="@name"/>
											<b><xsl:value-of select="@name"/></b>
											<br/>
										</xsl:otherwise>
									</xsl:choose>
								</b>
							</xsl:for-each>
						</div>
					</p>
				</xsl:for-each>
				<p style="margin-right:20px">
					<xsl:for-each select="learnMore">
						<a href="{@url}" style="font-weight:bold; text-decoration:underline; font-size:10px; float:right;"><xsl:value-of select="$textPath/content/strings/learnMore"/></a>
					</xsl:for-each>
					<a href="javascript:hydraVision('/wrath/images/worldmap/{$lang}/map-{@mapName}.jpg',false);" style="font-weight:bold; text-decoration:underline; font-size:10px;"><xsl:value-of select="$textPath/content/strings/viewMap"/></a>
				</p>
			</div>
		</xsl:for-each>
		<div id="hiResStringContainer"/>
	</div>
	
</xsl:template>

</xsl:stylesheet>
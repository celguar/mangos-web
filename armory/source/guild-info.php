<?php
if(!defined('Armory'))
{
	header('Location: ../guild-search.php');
	exit();
}
?>
<script type="text/javascript">
	rightSideImage = "guild";
	changeRightSideImage(rightSideImage);
</script>
<?php
if(!isset($_GET["guildid"]))
{
	$o->setobvar("GUILD_NAME", "");
	$o->showerror("Invalid Use of File", "The parameter &quot;guildid&quot; was not specified.<br>\n&gt;&nbsp;<a href=\"guild-search.php\">Return to Guild List</a>");
}
else
{
	if(!isset($_GET["realm"]) || !isset($_GET["realm"]["name"]) || !array_key_exists(stripslashes($_GET["realm"]), $realms))
		$o->showerror("No Realm Specified", "Oops! If you are seeing this error message, you must have followed a bad link to this page.");
	else
	{
		switchConnection($realms[stripslashes($_GET["realm"])][0]);
		define("REALM_KEY", $realms[stripslashes($_GET["realm"])][0]);
		define("REALM_NAME", stripslashes($_GET["realm"]));
		// The guild ID was set.. Now, get information on the guild //
		$guildId = (int) $_GET["guildid"];
		$query = "SELECT * FROM `guild` WHERE `guildid` = '" .$guildId."'";
		$guildquery = mysql_query($query) or $o->string(mysql_error());
		$numresults = mysql_num_rows($guildquery);
		// If there were no results, the guild did not exist //
		if($numresults == 0)
		{
			// And it did not //
			$o->setobvar("GUILD_NAME", "");
			$o->showerror("Guild does not exist", "The guild with the ID &quot;".$guildId."&quot; does not exist.<br>\n&gt;&nbsp;<a href=\"guild-search.php\">Return to Guild List</a>");
		}
		else
		{
			// The guild exists //
			$guild = mysql_fetch_assoc($guildquery);
			$o->setobvar("GUILD_NAME", $guild["name"]);
			// Basic Information on Guild //
			// Get the guild leader if it exists //
			if($guild["leaderguid"] == "" or $guild["leaderguid"] == 0)
			{
				// Guild has no master? err //
				$guild_master = "&lt;Guild has no leader&gt;";
				$gmdata = "none";
			}
			else
			{
				// Return the leader of the guild //
				$gleader = mysql_query("SELECT `name`, `race`, `class`, `data` FROM `characters` WHERE `guid` = '".$guild["leaderguid"]."'");
				$gmdata = mysql_fetch_assoc($gleader);
				$char_data = explode(' ',$gmdata["data"]);
				$gmdata["level"] = $char_data[LEVEL];
				$gm_gender = dechex($char_data[GENDER]);
				$gm_gender = str_pad($gm_gender,8, 0, STR_PAD_LEFT);
				$gmdata["gender"] = $gm_gender{3};
			}
			// Get number of members in guild //
			$mquery = mysql_query("SELECT count(*) FROM `guild_member` WHERE `guildid` = '".$guild["guildid"] ."'");
			$guild_members = mysql_result($mquery, 0, 0);
			// Faction Info //
			// Member Data //
			$mlquery = mysql_query("SELECT * FROM `characters`, `guild_member` WHERE `characters`.`guid`=`guild_member`.`guid` and `guildid` = '".$guild["guildid"]."' ORDER BY `rank` ASC");
			$faction = GetFaction ($gmdata["race"]);?>
<div class="list">
<div class="player-side">
<div class="tip" style="clear: left;">
<table>
<tr>
<td class="tip-top-left"></td><td class="tip-top"></td><td class="tip-top-right"></td>
</tr>
<tr>
<td class="tip-left"></td><td class="tip-bg">
<div>
<div class="generic-wrapper">
<div class="generic-right">
<div class="genericHeader">
<div style="margin-top: 10px;">
<div class="profile">
<div class="guildbanks-faction-<?php echo $faction ?>">
<div class="profile-left">
<div class="profile-right">
<div style="height: 140px; width: 100%;">
<div class="reldiv">
<div class="guildheadertext">
<div class="guild-details">
<div class="guild-shadow">
<table>
<tr>
<td>
<h1>Guild:&nbsp;<?php print $guild["name"] ?></h1>
<h2><?php print $guild_members ?>&nbsp;Members</h2>
<h1>Master:&nbsp;<?php print $gmdata["name"] ?></h1>
<h2>faction:&nbsp;<?php print ucfirst($faction) ?></h2>
</td>
</tr>
</table>
</div>
<div class="guild-white">
<table>
<tr>
<td>
<h1>Guild:&nbsp;<?php print $guild["name"] ?></h1>
<h2><?php print $guild_members ?>&nbsp;Members</h2>
<h1>Master:&nbsp;<?php print $gmdata["name"] ?></h1>
<h2>faction:&nbsp;<?php print ucfirst($faction) ?></h2>
</td>
</tr>
</table>
</div>
</div>
</div>
<div style="position: absolute; margin: 15px 0 0 40px; z-index: 10000;">
<?php
			print "<a href=\"index.php?searchType=profile&character=".$gmdata["name"]."&realm=".REALM_NAME."\"><img width=\"72\" height=\"72\" src=\"images/portraits/".GetCharacterPortrait($gmdata["level"], $gmdata["gender"], $gmdata["race"], $gmdata["class"])."\" class=\"profile-header-portrait-img-".$faction."\" onmouseover=\"showTip('<span class=\'tooltip-whitetext\'>".$gmdata["name"].": Level ".$gmdata["level"]." ".$races[$gmdata["race"]]." ".$classes[$gmdata["class"]]."</span>')\" onmouseout=\"hideTip()\"></a>\n";
?>
</div>
<div style="position: absolute; margin: 116px 0 0 210px;">
<div class="smallframe-a"></div>
<div class="smallframe-b"><?php print REALM_NAME ?></div>
<div class="smallframe-icon">
<div class="reldiv">
<div class="smallframe-realm"></div>
</div>
</div>
<div class="smallframe-c"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="parch-profile-banner" id="banner" style="margin-top: -10px;">
<h1>Guild Roster</h1>
</div>
</div>
<div class="filtercrest">
<a class="bluebutton" href="javascript: resetFilters();" id="loginreloadbutton" style="float: right;">
<div class="bluebutton-a"></div>
<div class="bluebutton-b">
<div class="reldiv">
<div class="bluebutton-color">Reset Filters</div>
</div>Reset Filters</div>
<div class="bluebutton-reload"></div>
<div class="bluebutton-c"></div>
</a>
<div class="filtertitle" style="float: left;">
<img src="images/guildbank-arrow-light.gif">Guild Roster Filters</div>
</div>
<div class="arena-list">
<div class="filtercontainer">
<div class="clearfilterboxsm"></div>
<div class="bankcontentsfiltercontainer" style="width: 19%; float: left;">
<div class="bankcontentsfilter">Name:<br>
<span><input class="guildbankitemname" id="inputName" onClick="javascript:this.select()" onKeyUp="javascript: gFname = this.value; filterArray();" size="12" style="width: 90px;" type="text"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 14%; float: left;">
<div class="bankcontentsfilter">Level:<br>
<span><input class="guildbankitemname" id="inputMinlvl" onClick="javascript:this.select()" onKeyUp="javascript: gFminlvl = this.value; filterArray();" size="2" style="width: 16px; padding-left: 2px;" type="text" value="1"> - <input class="guildbankitemname" id="inputMaxlvl" onClick="javascript:this.select()" onKeyUp="javascript: gFmaxlvl = this.value; filterArray();" size="2" style="width: 16px; padding-left: 2px;" type="text" value="80"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 17%; float: left;">
<div class="bankcontentsfilter">Race:<br>
<span id="divReplaceOptionRace"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 19%; float: right;">
<div class="bankcontentsfilter">Rank:<br>
<span id="replaceOptionRank"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 15%;  float: right;">
<div class="bankcontentsfilter">Class:<br>
<span id="divReplaceOptionClass"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 15%;  float: right;">
<div class="bankcontentsfilter">Gender:<br>
<select class="bankselect" id="selectGender" onChange="gFgender = this.value; filterArray();" style="width: 70px;"><option value="-1">Both</option><option value="0">Male</option><option value="1">Female</option></select>
</div>
</div>
<div class="clearfilterboxsm"></div>
</div>
</div>
</div>
</div>
<div class="bottomshadow"></div>
</div>
</div>
<div style="padding: 0 0 20px 10px; clear:both; ">
<div class="filtertitle" style="font-size: 16px; letter-spacing: -1px; padding: 0;">Total Results:&nbsp;<span id="replaceTotal"><?php print $guild_members ?></span>
</div>
</div>
<center>
<div class="armory-news" id="showTooMany" style="display: none; ">
<div id="rDivNews">
<h1>
<p></p>Note: Too many guild members. Only high level members are listed.</h1>
</div>
</div>
</center>
<div class="paging">
<div id="replacePagesTop"></div>
</div>
<div>
<b><img height="1" src="images/pixel.gif" width="1"></b>
</div>
<div class="data" style="margin-top: 4px;">
<div id="replaceSearchTable"></div>
<script src="js/data.js" type="text/javascript"></script><script type="text/javascript">
	if ((is_opera || is_mac) && <?php print $guild_members ?> > 600)
		document.getElementById('showTooMany').style.display = "block";
	var globalResultsPerPage = <?php print $results_per_page_guild ?>;
</script><script src="js/paging/functions.js" type="text/javascript"></script><script type="text/javascript">	thisRaceArray = <?php echo $faction ?>RaceArray;
	replaceString = "";
	replaceString = '<select  class="bankselect" style="width: 80px;" id = "selectRace" onChange = "gFrace = this.value; filterArray();" name = "optionRace">';
	replaceString += '<option value = "-1">All</option>';
	var raceArrayLength = thisRaceArray.length;
	for (d = 0; d < raceArrayLength; d++){
		replaceString += '<option value = "'+ thisRaceArray[d][1] +'">'+ thisRaceArray[d][0] +'</option>';
	}
	replaceString += '</select>';
	document.getElementById('divReplaceOptionRace').innerHTML = replaceString;	
	replaceString = "";
	replaceString = '<select id = "selectClass"  class="bankselect" style="width: 70px;" onChange = "gFclass = this.value; filterArray();" name = "optionClass"><option value = "-1">All</option>';
	for (d = 0; d < classStringArray.length; d++){
	replaceString +='<option value = "'+ classStringArray[d][1] +'">'+ classStringArray[d][0] +'</option>';
	}
	replaceString += '</select>';
	document.getElementById('divReplaceOptionClass').innerHTML = replaceString;
	var textMembers = "Members";
	var textLevel = "Level";
	var textRace = "Race";
	var textClass = "Class";
	var textGuildRank = "Guild Rank";
	var theArray = new Array();
<?php
			$mlquerystring = "SELECT * FROM `characters`, `guild_member` WHERE `characters`.`guid`=`guild_member`.`guid` and `guildid` = '".$guild["guildid"]."' ORDER BY `rank` ASC";
			$mlquery = mysql_query($mlquerystring);
			$i=0;
			while($cdata = mysql_fetch_array($mlquery))
			{
				$_char_data = explode(' ',$cdata["data"]);
				$cdata["level"]=$_char_data[LEVEL];
				$_char_gender = dechex($_char_data[GENDER]);
				$_char_gender = str_pad($_char_gender,8, 0, STR_PAD_LEFT);
				$cdata["gender"] = $_char_gender{3};
				$faction = getFaction($cdata["race"]);
				$i=$i + 1;
				print "theArray[".$i." - 1] = [[\"&character=".$cdata["name"]."&realm=".REALM_NAME."\"], [\"".$cdata["name"]."\"], [".$_char_data[LEVEL]."], [\"".$cdata["race"]."\", \"".$cdata["gender"]."\", \"".$races[$cdata["race"]]."\"], [\"".$cdata["class"]."\", \"".$classes[$cdata["class"]]."\"], [\"".$cdata["rank"]."\"]]; \n";
			}
?>
	var gHighestRank = 0;
	for (var x = 0; x < theArray.length; x++) {
		if (gHighestRank < theArray[x][5][0])
			gHighestRank = theArray[x][5][0];
	}
	replaceString = '<select  class="bankselect" style="width: 100px;" id = "selectRank" onChange = "gFrank = this.value; filterArray();" name = "optionRank"><option value = "-1">All Ranks</option>';
	replaceString += '<option value = "0">Guild Master</option>';
	for (d = 1; d <= gHighestRank; d++){
		replaceString +='<option value = "'+ d +'">Rank  '+ d +'</option>';
	}
	replaceString += '</select>';
	document.getElementById('replaceOptionRank').innerHTML = replaceString;
	var globalResultsTotal = theArray.length;
	var globalPages = Math.ceil(globalResultsTotal/globalResultsPerPage);	
	var savedArray = theArray.slice();
	var gFname = "";
	var gFminlvl = 1;
	var gFmaxlvl = 80;
	var gFrace = -1;
	var gFgender = -1;
	var gFclass = -1;
	var gFrank = -1;

	function resetFilters() {
		gFname = "";
		gFminlvl = 1;
		gFmaxlvl = 80;
		gFrace = -1;
		gFgender = -1;
		gFclass = -1;
		gFrank = -1;
		document.getElementById('inputName').value = "";
		document.getElementById('inputMinlvl').value = gFminlvl;
		document.getElementById('inputMaxlvl').value = gFmaxlvl;
		document.getElementById('selectRace').selectedIndex = 0;
		document.getElementById('selectClass').selectedIndex = 0;
		document.getElementById('selectGender').selectedIndex = 0;
		document.getElementById('selectRank').selectedIndex = 0;
		globalSort[0] = arrayCol.length;
		globalSort[1] = 'd';
		filterArray();
	}

	function filterArray() {
		if (gFminlvl > gFmaxlvl)
			return false;
		var counter = 0;
		for (var i = 0; i < savedArray.length; i++) {
			if (filterName(i) &&
				filterClass(i) && 
				filterRace(i) && 
				filterGender(i) && 
				filterRank(i) &&
				filterLevel(i)
			) {
				theArray[counter] = savedArray[i];
				counter++
			}
		}
		theArray.length = counter;
		globalPages = Math.ceil(counter/globalResultsPerPage);
		if (counter)
			setResultsPage(1);
		else
			elemRST.innerHTML = printSearchCol(arrayCol, globalSort[0], globalSort[1]) + "</table>\
			No Results Found";
		document.getElementById('replaceTotal').innerHTML = counter;
	}

	function filterName(whichOne) {
		if (gFname == "" || (savedArray[whichOne][1][0].toLowerCase()).match((gFname.toLowerCase())))
			return true;
		else
			return false;
	}

	function filterClass(whichOne) {
		if (gFclass == -1 || savedArray[whichOne][4][0] == gFclass)
			return true;
		else
			return false;
	}

	function filterRace(whichOne) {
		if (gFrace == -1 || savedArray[whichOne][3][0] == gFrace)
			return true;
		else
			return false;
	}

	function filterGender(whichOne) {
		if (gFgender == -1 || savedArray[whichOne][3][1] == gFgender)
			return true;
		else
			return false;
	}

	function filterLevel(whichOne) {
		if (gFminlvl <= savedArray[whichOne][2][0] && gFmaxlvl >= savedArray[whichOne][2][0])
			return true;
		else
			return false;
	}

	function filterRank(whichOne) {
		if (gFrank == -1 || savedArray[whichOne][5][0] == gFrank)
			return true;
		else
			return false;
	}

</script><script src="js/paging/guildRoster.js" type="text/javascript"></script><script type="text/javascript">
//
	setcookie("cookieRightPage", 1);
	var globalSort = [arrayCol.length, 'd'];
	var globalColSelected = new Array();
	clearColSelected();
	setColSelected(arrayCol.length);
	var replaceStringGuildBot = '</table>';
	setResultsPage(1, arrayCol.length, 'd');
//
</script>
</div>
<div class="paging" style="margin-top: 8px;">
<div id="replacePagesBot"></div>
</div>
<div>
<b><img height="1" src="images/pixel.gif" width="1"></b>
</div>
<script type="text/javascript">
	var elemRPB = document.getElementById('replacePagesBot');
	elemRPB.innerHTML = printPage(1);
	filterArray();
</script></td><td class="tip-right"></td>
</tr>
<tr>
<td class="tip-bot-left"></td><td class="tip-bot"></td><td class="tip-bot-right"></td>
</tr>
</table>
</div>
</div>
<div id="miniSearchElement">
<script type="text/javascript">
	//
	function value(a,b) {
		a = a[globalSort[0]] + a[0][0];
		b = b[globalSort[0]] + b[0][0];
		return a == b ? 0 : (a < b ? -1 : 1)
	}

	function valueAs(a,b) {
		a = a[globalSort[0]] + a[0][0];
		b = b[globalSort[0]] + b[0][0];
		return a == b ? 0 : (a < b ? 1 : -1)
	}

	function sortNumber(a, b) {
		return b[globalSort[0]][0] - a[globalSort[0]][0];
	}

	function sortNumberAs(a, b) {
		return a[globalSort[0]][0] - b[globalSort[0]][0];
	}

	var globalSort = new Array;

	function sortSearch2(whichElement) {
		if (whichElement < 0)
			whichElement = 0 - whichElement;
		globalSort[0] = whichElement;
		globalSort[1] = getcookie2("cookieLeftSortUD");
		if ((typeof rightArray[0][whichElement][0]) == 'string') {
			sortAs = valueAs;
			sortDe = value;
		} else {
			sortAs = sortNumberAs;
			sortDe = sortNumber;
		}
		if (globalSort[1] == 'u')
			rightArray.sort(eval(sortAs));
		else
			rightArray.sort(eval(sortDe));
	}
	//
</script>
</div>
<div class="rinfo">
</div>
<?php
		}
	}
}
?>
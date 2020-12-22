<?php
if(!defined('Armory'))
{
	header('Location: ../arenateam-search.php');
	exit();
}
?>
<script type="text/javascript">
	rightSideImage = "arena";
	changeRightSideImage(rightSideImage);
</script>
<?php
if(!isset($_GET["arenateamid"]))
{
	$o->setobvar("GUILD_NAME", "");
	$o->showerror("Invalid Use of File", "The parameter &quot;arenateamid&quot; was not specified.<br>\n&gt;&nbsp;<a href=\"arenateams-search.php\">Return to Arena Team List</a>");
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
		// The arenateam ID was set.. Now, get information on the arenateam //
		$arenateamId = (int) $_GET["arenateamid"];
		$query = "SELECT * FROM `arena_team` WHERE `arenateamid` = '" .$arenateamId."'";
		$arenateamquery = mysql_query($query) or $o->string(mysql_error());
		$numresults = mysql_num_rows($arenateamquery);
		// If there were no results, the arenateam did not exist //
		if($numresults == 0)
		{
			// And it did not //
			$o->setobvar("GUILD_NAME", "");
			$o->showerror("Arena does not exist", "The arenateam with the ID &quot;".$arenateamId."&quot; does not exist.<br>\n&gt;&nbsp;<a href=\"arenateams-search.php\">Return to Arena Team List</a>");
		}
		else
		{
			// The arenateam exists //
			$arenateam = mysql_fetch_assoc($arenateamquery);
			$o->setobvar("GUILD_NAME", $arenateam["name"]);
			// Basic Information on Arena Team //
			// Get the arenateam captain if it exists //
			if($arenateam["captainguid"] == "" or $arenateam["captainguid"] == 0)
			{
				// Arena Team has no master? err //
				$arenateam_master = "&lt;Arena Team has no captain&gt;";
				$gmdata = "none";
			}
			else
			{
				// Return the captain of the arenateam //
				$gcaptain = mysql_query("SELECT `name`, `race`, `class`, `data` FROM `characters` WHERE `guid` = '".$arenateam["captainguid"]."'");
				$gmdata = mysql_fetch_assoc($gcaptain);
				$char_data = explode(' ',$gmdata["data"]);
				$gmdata["level"] = $char_data[LEVEL];
				$gm_gender = dechex($char_data[GENDER]);
				$gm_gender = str_pad($gm_gender,8, 0, STR_PAD_LEFT);
				$gmdata["gender"] = $gm_gender{3};
			}
			// Get number of members in arenateam //
			$mquery = mysql_query("SELECT count(*) FROM `arena_team_member` WHERE `arenateamid` = '".$arenateam["arenateamid"] ."'");
			$arenateam_members = mysql_result($mquery, 0, 0);
			// Faction Info //
			// Member Data //
			$mlquery = mysql_query("SELECT * FROM `characters`, `arena_team_member` WHERE `characters`.`guid`=`arena_team_member`.`guid` and `arenateamid` = '".$arenateam["arenateamid"]."' ORDER BY `wons_season` DESC");
			$faction = GetFaction ($gmdata["race"]);
			$o->string("<div class=\"list\">
			<div class=\"player-side\">
			<div class=\"tip\" style=\"clear: left;\">
			<table width=\"100\">
			<tr>
			<td class=\"tip-top-left\"></td><td class=\"tip-top\"></td><td class=\"tip-top-right\"></td>
			</tr>
			<tr>
			<td class=\"tip-left\"></td><td class=\"tip-bg\">
			<div>
			<div class=\"generic-wrapper\">
			<div class=\"generic-right\">
			<div class=\"genericHeader\">
			<div style=\"margin-top: 10px;\">
			<div class=\"profile\">
			<div class=\"guildbanks-faction-".$faction."\">
			<div class=\"profile-left\">
			<div class=\"profile-right\">
			<div style=\"height: 140px; width: 100%;\">
			<div class=\"reldiv\">
			<div class=\"guildheadertext\">
			<div class=\"guild-details\">
			<div class=\"guild-shadow\">
			<table>
			<tr>
			<td>
			<h1>Team:&nbsp;".$arenateam["name"]."</h1>
			<h2>".$arenateam_members."&nbsp;Members</h2>
			<h1>Captain:&nbsp;".$gmdata["name"]."</h1>
			<h2>faction:&nbsp;".ucfirst($faction)."</h2>
			</td>
			</tr>
			</table>
			</div>
			<div class=\"guild-white\">
			<table>
			<tr>
			<td>
			<h1>Team:&nbsp;".$arenateam["name"]."</h1>
			<h2>".$arenateam_members."&nbsp;Members</h2>
			<h1>Captain:&nbsp;".$gmdata["name"]."</h1>
			<h2>faction:&nbsp;".ucfirst($faction)."</h2>
			</td>
			</tr>
			</table>
			</div>
			</div>
			</div>
			<div style=\"position: absolute; margin: 15px 0 0 40px; z-index: 10000;\">
			<a href=\"index.php?searchType=profile&character=".$gmdata["name"]."&realm=".REALM_NAME."\"><img width=\"72\" height=\"72\" src=\"images/portraits/".GetCharacterPortrait($gmdata["level"], $gmdata["gender"], $gmdata["race"], $gmdata["class"])."\" class=\"profile-header-portrait-img-".$faction."\" onmouseover=\"showTip('<span class=\'tooltip-whitetext\'>".$gmdata["name"].": Level ".$gmdata["level"]." ".$races[$gmdata["race"]]." ".$classes[$gmdata["class"]]."</span>')\" onmouseout=\"hideTip()\"></a>
			</div>
			<div style=\"position: absolute; margin: 116px 0 0 210px;\">
			<div class=\"smallframe-a\"></div>
			<div class=\"smallframe-b\">".REALM_NAME."</div>
			<div class=\"smallframe-icon\">
			<div class=\"reldiv\">
			<div class=\"smallframe-realm\"></div>
			</div>
			</div>
			<div class=\"smallframe-c\"></div>
			</div>
			</div>
			</div>
			</div>
			</div>
			</div>
			</div>
			</div>");
			$mlquerystring = "SELECT * FROM `characters`, `arena_team_member` WHERE `characters`.`guid`=`arena_team_member`.`guid` and `arenateamid` = '".$arenateam["arenateamid"]."' ORDER BY `personal_rating` DESC";
			$mlquery = mysql_query($mlquerystring);
			// Output //
			// Table Header //
			$o->string("<div class=\"data\">
			<table class=\"data-table\">
			<tr class=\"masthead\">
			<td>
			<div>
			<p></p>
			</div>
			</td><td><a class=\"noLink\">Team Members: </a></td>
			<td><a class=\"noLink\">Guild</a></td>
			<td align=\"center\"><a class=\"noLink\">Race/Class</a></td>
			<td align=\"center\"><a class=\"noLink\">Faction</a></td>
			<td align=\"center\"><a class=\"noLink\">Games</a></td>
			<td align=\"center\"><a class=\"noLink\">Wins</a></td>
			<td align=\"center\"><a class=\"noLink\">Losses</a></td>
			<td align=\"center\"><a class=\"noLink\">Win %</a></td>
			<td align=\"center\"><a class=\"noLink\">Personal Rating</a></td><td align=\"right\">
			<div>
			<b></b>
			</div>
			</td>
			</tr>");
			// Loops ftw //
			while($cdata = mysql_fetch_array($mlquery))
			{
				$_char_data = explode(' ',$cdata["data"]);
				$_char_gender = dechex($_char_data[GENDER]);
				$_char_gender = str_pad($_char_gender,8, 0, STR_PAD_LEFT);
				$cdata["gender"] = $_char_gender{3};
				$faction = getFaction($cdata["race"]);
				$o->string("<tr class=\"");
				if ($gmdata["name"] == $cdata["name"])
					$o->string("data3");
				$o->string("\">
				<td>
				<div>
				<p></p>
				</div>
				</td><td><q><span class=\"");
				if ($gmdata["name"] == $cdata["name"])
					$o->string("gm");
				$o->string("\"><a href=\"index.php?searchType=profile&character=".$cdata["name"]."&realm=".REALM_NAME."\">".$cdata["name"]."</a></span></q></td>");
				$guildquerystring = "SELECT `guildid` FROM `guild_member` WHERE `guid` = '".$cdata["guid"]."'";
				$guildquery = mysql_query($guildquerystring);
				// No Team //
				if(mysql_num_rows($guildquery) == "0")
					$o->string("<td class=\"\"><q>None</q></td>");
				else
				{
					// P2A: please review this if you have time to check for sluggishness, loop within loop reconnecting to DB! //
					$guild = mysql_fetch_array($guildquery);
					$glinkquery = mysql_query("SELECT * FROM `guild` WHERE `guildid` = '".$guild["guildid"]."'");
					$glinkresults = mysql_fetch_assoc($glinkquery);
					$guildInfoTooltip = "<span class=\'profile-tooltip-header\'>".$glinkresults["name"]."</span><br>";
					$gleadq = mysql_query("SELECT `name` FROM `characters` WHERE `guid` = '".$glinkresults["leaderguid"]."'");
					if(mysql_num_rows($gleadq) > 0)
						$guildInfoTooltip .= "<span class=\'profile-tooltip-description\'>Leader: ".mysql_result($gleadq, 0, 0)."<br>";
					else
						$guildInfoTooltip .= "<span class=\'profile-tooltip-description\'>Unknown Leader<br>";
					$guildInfoTooltip .= "Realm: ".addslashes(REALM_NAME)."<br>";
					$gnumq = mysql_query("SELECT count(*) FROM `guild_member` WHERE `guildid` = '".$guild["guildid"]."'");
					if(mysql_num_rows($gleadq) > 0)
						$guildInfoTooltip .= "Members: ".mysql_result($gnumq, 0, 0)."</span>";
					else
						$guildInfoTooltip .= "No Members (?)</span>";
					$o->string("<td class=\"\"><q><a href=\"index.php?searchType=guildinfo&guildid=".$guild["guildid"]."&realm=".REALM_NAME."\" onmouseover=\"showTip('".$guildInfoTooltip."')\" onmouseout=\"hideTip()\">".$glinkresults["name"]."</a></q></td>\n");
				}
				if ($cdata["played_season"] <> 0)
					$win_percent=round(($cdata["wons_season"]/$cdata["played_season"])*100);
				else
					$win_percent='0';
				$o->string("<td align=\"center\"><q><img src=\"images/icons/race/".$cdata["race"]."-".$cdata["gender"].".gif\" onMouseOver=\"showTip('".$races[$cdata["race"]]."')\" onmouseout=\"hideTip()\">
				<img src=\"images/icons/class/".$cdata["class"].".gif\" onMouseOver=\"showTip('".$classes[$cdata["class"]]."')\" onmouseout=\"hideTip()\"></q></td>
				<td align=\"center\"><q><img src=\"images/icon-".$faction.".gif\" width=\"20\" height=\"20\" onmouseover=\"showTip('".ucfirst($faction)."')\" onmouseout=\"hideTip()\"></q></td>
				<td align=\"center\"><q><i><span class=\"veryplain\">".$cdata["played_season"]."</span></i></q></td>
				<td align=\"center\"><q><i><span class=\"g\">".$cdata["wons_season"]."</span></i></q></td>
				<td align=\"center\"><q><i><span class=\"r\">".($cdata["played_season"]-$cdata["wons_season"])."</span></i></q></td>
				<td align=\"center\"><q><i><span class=\"veryplain\">".$win_percent."%</span></i></q></td>
				<td align=\"center\"><q><i><span class=\"veryplain\">".$cdata["personal_rating"]."</span></i></q></td><td align=\"right\">
				<div>
				<b></b>
				</div>
				</td>
				</tr>");
			}
			$o->string("</table>
			</div>");
			$o->string("</td>
			<td class=\"tip-right\"></td>
			</tr>
			<tr>
			<td class=\"tip-bot-left\"></td><td class=\"tip-bot\"></td><td class=\"tip-bot-right\"></td>
			</tr>
			</table>
			</div>
			</div>");
		}
	}
}
?>
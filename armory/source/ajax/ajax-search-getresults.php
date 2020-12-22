<?php
require "../../configuration/mysql.php";
require "../../configuration/resources.inc.php";
require "../../configuration/functions.php";
require "../../configuration/defines.php";
error_reporting(E_ALL);
// Check if any input is set //
if (!isset($_GET["searchQuery"]))
	$do_query = 0;
else
{
	$SearchQuery = validate_string($_GET["searchQuery"]);
	if(strlen($SearchQuery) >= $min_char_search)
		$do_query = 1;
	else
		$do_query = 0;
}
if ($do_query == 1)
{
	// Loop on each realm and save character data in DB so it can be ordered/sorted //
	$characters = array();
	foreach($realms as $realm_name => $realm_data)
	{
		switchConnection($realm_data[0]);
		$squery = mysql_query("SELECT `guid`, `data`, `name`, `race`, `class` FROM `characters` WHERE `name` LIKE ('%".change_whitespace($SearchQuery)."%')");
		$snumresults = mysql_num_rows($squery);
		while($sresults = mysql_fetch_assoc($squery))
		{
			$theGuid = $sresults["guid"];
			$theName = $sresults["name"];
			$char_data = explode(' ',$sresults["data"]);
			$theLevel = $char_data[LEVEL];
			$theRace = $sresults["race"];
			$char_gender = dechex($char_data[GENDER]);
			$char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
			$theGender = $char_gender{3};
			$theClass = $sresults["class"];
			$gquery = mysql_query("SELECT `guildid` FROM `guild_member` WHERE `guid` = ".$sresults["guid"]);
			$guildid = mysql_fetch_assoc($gquery);
			$theGuildId = ($guildid)?$guildid["guildid"]:0;
			$theServerName = $realm_name;
			$theFaction = GetFaction($theRace);
			$characters[] = array($theGuid, $theName, $theLevel, $theRace, $theGender, $theClass, $theGuildId, $theServerName, $theFaction);
		}
	}
	if(count($characters) > 0)
	{
		// Now output character data //
		$orders = array("name", "level", "guild", "realm", "race", "class", "faction");
		$orderOppositeSort = array();
		$orderSymbol = array();
		$orderClassSuffix = array();
		foreach($orders as $val)
		{
			$orderOppositeSort[$val] = "DESC";
			$orderSymbol[$val] = "";
			$orderClassSuffix[$val] = "";
		}
		if(isset($_GET["orderBy"]))
		{
			// client is using an order by //
			$orderBy = addslashes($_GET["orderBy"]);
			$orderSort = addslashes($_GET["orderSort"]);
			if($orderBy == "name" or $orderBy == "level" or $orderBy == "guild" or $orderBy == "realm" or $orderBy == "race" or $orderBy == "class" or $orderBy == "faction")
			{
				if($orderSort == "ASC")
				{
					$orderOppositeSort[$orderBy] = "DESC";
					$orderSymbol[$orderBy] = "\/";
				}
				else
				{
					$orderOppositeSort[$orderBy] = "ASC";
					$orderSymbol[$orderBy] = "/\\";
				}
				$orderClassSuffix[$orderBy] = "-ordered";
			}
		}
		else
			$orderBy = 2;
		$pages = ceil(count($characters)/$results_per_page_char);
		if(isset($_GET["page"]))
			$pageNo = ValidatePageNumber((int) $_GET["page"], $pages);
		else
			$pageNo = 1;
		print "<span class=\"csearch-results-info\">".count($characters)."&nbsp;results for&nbsp;<em>".stripslashes($SearchQuery)."</em>:</span><br>\n";
		print "<div class=\"data\" style=\"clear: both;\">
		<table class=\"data-table\">
		<tr class=\"masthead\">
		<td>
		<div>
		<p></p>
		</div>
		</td><td width=\"25%\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=name&orderSort=".$orderOppositeSort['name']."','source/ajax/ajax-search-getresults.php')\">Character Name ".$orderSymbol['name']."</a></td>
		<td width=\"9%\" align=\"center\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=level&orderSort=".$orderOppositeSort['level']."','source/ajax/ajax-search-getresults.php')\">Level ".$orderSymbol['level']."</a></td>
		<td width=\"6%\" align=\"right\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=race&orderSort=".$orderOppositeSort['race']."','source/ajax/ajax-search-getresults.php')\">Race</a></td>
		<td width=\"6%\" align=\"left\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=class&orderSort=".$orderOppositeSort['class']."','source/ajax/ajax-search-getresults.php')\">Class</a></td>
		<td width=\"9%\" align=\"center\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=faction&orderSort=".$orderOppositeSort['faction']."','source/ajax/ajax-search-getresults.php')\">Faction</a></td>
		<td width=\"25%\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=guild&orderSort=".$orderOppositeSort['guild']."','source/ajax/ajax-search-getresults.php')\">Guild ".$orderSymbol['guild']."</a></td>
		<td width=\"20%\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=realm&orderSort=".$orderOppositeSort['realm']."','source/ajax/ajax-search-getresults.php')\">Realm ".$orderSymbol['realm']."</a></td><td align=\"right\">
		<div>
		<b></b>
		</div>
		</td>
		</tr>";
		// Any ordering of the array $characters can occur here //
		if(!isset($orderSort))
			$characters = asort2d($characters, 2, 1, 7);
		else
		{
			if($orderBy == "name")
				$theSortId = 1;
			else if($orderBy == "level")
				$theSortId = 2;
			else if($orderBy == "race")
				$theSortId = 3;
			else if($orderBy == "class")
				$theSortId = 5;
			else if($orderBy == "guild")
				$theSortId = 6;
			else if($orderBy == "realm")
				$theSortId = 7;
			else if($orderBy == "faction")
				$theSortId = 8;
			if($orderSort == "DESC")
				$theSortType = 1;
			else
				$theSortType = 0;
			$characters = asort2d($characters, $theSortId, $theSortType, 7);
		}
		$chunks = array_chunk($characters, $results_per_page_char, 1);
		$characters = $chunks[ ($pageNo - 1)];
		foreach($characters as $key => $data)
		{
			print "<tr>
			<td>
			<div>
			<p></p>
			</div>
			</td><td class=\"csearch-results-table-item".$orderClassSuffix['name']."\"><q><a href=\"index.php?searchType=profile&character=".$data[1]."&realm=".$data[7]."\">".$data[1]."</a></q></td>
			<td align=\"center\" class=\"csearch-results-table-item".$orderClassSuffix['level']."\"><q>".$data[2]."</q></td>
			<td align=\"right\" class=\"csearch-results-table-item".$orderClassSuffix['race']."\"><q><img src=\"images/icons/race/".$data[3]."-".$data[4].".gif\" onmouseover=\"showTip('".$races[$data[3]]."')\" onmouseout=\"hideTip()\"></q></td>
			<td align=\"left\" class=\"csearch-results-table-item".$orderClassSuffix['class']."\"><q><img src=\"images/icons/class/".$data[5].".gif\" onmouseover=\"showTip('".$classes[$data[5]]."')\" onmouseout=\"hideTip()\"></q></td>
			<td align=\"center\" class=\"csearch-results-table-item".$orderClassSuffix['faction']."\"><q><img src=\"images/icon-".$data[8].".gif\" width=\"20\" height=\"20\" onmouseover=\"showTip('".ucfirst($data[8])."')\" onmouseout=\"hideTip()\"></q></td>";
			// Get Guild Info //
			// No Guild //
			if($data[6] == "0")
				print "<td class=\"csearch-results-table-item\"><q>None</q></td>";
			else
			{
				/* P2A: please review this if you have time to check for sluggishness, loop within loop reconnecting to DB! */
				if(getConnection() != $realms[$realm_name][0])
					switchConnection($realms[$data[7]][0]);
				$glinkquery = mysql_query("SELECT * FROM `guild` WHERE `guildid` = '".$data[6]."'");
				$glinkresults = mysql_fetch_assoc($glinkquery);
				$guildInfoTooltip = "<span class=\'profile-tooltip-header\'>".$glinkresults["name"]."</span><br>";
				$gleadq = mysql_query("SELECT `name` FROM `characters` WHERE `guid` = '".$glinkresults["leaderguid"]."'");
				if(mysql_num_rows($gleadq) > 0)
					$guildInfoTooltip .= "<span class=\'profile-tooltip-description\'>Leader: ".mysql_result($gleadq, 0, 0)."<br>";
				else
					$guildInfoTooltip .= "<span class=\'profile-tooltip-description\'>Unknown Leader<br>";
				$guildInfoTooltip .= "Realm: ".addslashes($data[7])."<br>";
				$gnumq = mysql_query("SELECT count(*) FROM `guild_member` WHERE `guildid` = '".$data[6]."'");
				if(mysql_num_rows($gleadq) > 0)
					$guildInfoTooltip .= "Members: ".mysql_result($gnumq, 0, 0)."</span>";
				else
					$guildInfoTooltip .= "No Members (?)</span>";
				print "<td class=\"csearch-results-table-item".$orderClassSuffix['guild']."\"><q><a href=\"index.php?searchType=guildinfo&guildid=".$data[6]."&realm=".$data[7]."\" onmouseover=\"showTip('".$guildInfoTooltip."')\" onmouseout=\"hideTip()\">".$glinkresults["name"]."</a></q></td>\n";
			}
			print "<td class=\"csearch-results-table-item".$orderClassSuffix['realm']."\"><q>".$data[7]."</q></td><td align=\"right\">
			<div>
			<b></b>
			</div>
			</td>
			</tr>";
		}
		print "</table></div>";
		print "<table><tr>\n";
		print "<td align=\"left\">\n";
		print "Page ". $pageNo." of ".$pages;
		print "</td>\n";
		print "<td align=\"right\">\n";
		print BuildPageButtons($pageNo, $pages, "?searchQuery=".$SearchQuery, "source/ajax/ajax-search-getresults.php");
		print "</td>\n";
		print "</tr>\n";
		print "</table>";
	}
	else
	{
		// No Results for search //
		print "<span class=\"csearch-results-info\">0&nbsp;results for&nbsp;<em>".stripslashes($SearchQuery)."</em>:</span><br>\n";
		print "<div class=\"data\" style=\"clear: both;\">
		<table class=\"data-table\">
		<tr class=\"masthead\">
		<td>
		<div>
		<p></p>
		</div>
		</td><td width=\"25%\"><a class=\"noLink\">Character Name</a></td>
		<td width=\"9%\" align=\"center\"><a class=\"noLink\">Level</a></td>
		<td width=\"6%\" align=\"right\"><a class=\"noLink\">Race</a></td>
		<td width=\"6%\" align=\"left\"><a class=\"noLink\">Class</a></td>
		<td width=\"9%\" align=\"center\"><a class=\"noLink\">Faction</a></td>
		<td width=\"25%\"><a class=\"noLink\">Guild</a></td>
		<td width=\"20%\"><a class=\"noLink\">Realm</a></td><td align=\"right\">
		<div>
		<b></b>
		</div>
		</td>
		</tr>";
		print "<tr>\n";
		print "<td align=\"center\" colspan=\"9\">There were no results for your search!</td>\n";
		print "</tr>\n";
	}
	print "</table></div>";
}
else
	print "<span class=\"csearch-results-info\">Error, you either failed to provide a character name or your search string was too short (&lt;".$min_char_search."characters) or you used invalid symbols (only alphabetic characters, digits and whitespace are allowed - whitespace can be used as any symbol)</span><br>\n";
?>
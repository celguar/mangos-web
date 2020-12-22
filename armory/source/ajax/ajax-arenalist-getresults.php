<?php
require "../../configuration/mysql.php";
require "../../configuration/resources.inc.php";
require "../../configuration/functions.php";
require "../../configuration/defines.php";
error_reporting(E_ALL);
if (!isset($_GET["searchQuery"]))
	$do_query = 0;
else
{
	$SearchQuery = validate_string($_GET["searchQuery"]);
	if(strlen($SearchQuery) >= $min_arenateam_search)
		$do_query = 1;
	else
		$do_query = 0;
}
if ($do_query == 1)
{
	$arenateams = array();
	$totalResults = 0;
	foreach($realms as $realm_name => $realm_data)
	{
		switchConnection($realm_data[0]);
		$gquery = mysql_query("SELECT `arenateamid`, `name`, `captainguid` FROM `arena_team` WHERE `name` LIKE ('%".change_whitespace($SearchQuery)."%')");
		$totalResults += mysql_num_rows($gquery);
		while($gresults = mysql_fetch_assoc($gquery))
		{
			$theGuid = $gresults["arenateamid"];
			$theName = $gresults["name"];
			$theCaptain = $gresults["captainguid"];
			$memquery = mysql_query("SELECT count(*) FROM `arena_team_member` WHERE `arenateamid` = '".$gresults["arenateamid"]."'");
			$theMembers = mysql_result($memquery, 0, 0);
			$theRealm = $realm_name;
			$captainquery = mysql_query("SELECT `data`, `name`, `race`, `class` FROM `characters` WHERE `guid` = '".$theCaptain."'");
			$captaindata = mysql_fetch_assoc($captainquery);
			$char_data = explode(' ', $captaindata['data']);
			$theCaptainName = $captaindata["name"];
			$theCaptainRace = $captaindata["race"];
			$theCaptainClass = $captaindata["class"];
			$char_gender = dechex($char_data[GENDER]);
			$char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
			$theCaptainGender = $char_gender{3};
			$theCaptainLevel = $char_data[LEVEL];
			$theFaction = GetFaction($theCaptainRace);
			$arenateams[] = array($theGuid, $theName, $theCaptain, $theMembers, $theRealm, $theCaptainName, $theCaptainRace, $theCaptainClass, $theCaptainGender, $theCaptainLevel, $theFaction);
		}
	}
	if(count($arenateams) > 0)
	{
		// Now output arenateam data //
		$orders = array("name", "captain", "faction", "members", "realm");
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
			if($orderBy == "name" or $orderBy == "captain" or $orderBy == "members" or $orderBy == "realm" or $orderBy == "faction")
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
		$pages = ceil(count($arenateams) / $results_per_page_arenateam);
		if(isset($_GET["page"]))
			$pageNo = ValidatePageNumber((int) $_GET["page"], $pages);
		else
			$pageNo = 1;
		print "<span class=\"csearch-results-info\">".$totalResults."&nbsp;results for&nbsp;<em>".stripslashes($SearchQuery)."</em>:</span><br>\n";
		print "<div class=\"data\" style=\"clear: both;\">
		<table class=\"data-table\">
		<tr class=\"masthead\">
		<td>
		<div>
		<p></p>
		</div>
		</td><td width=\"30%\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=name&orderSort=".$orderOppositeSort['name']."','source/ajax/ajax-arenalist-getresults.php')\">Team Name ".$orderSymbol['name']."</a></td>
		<td width=\"10%\" align=\"center\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=faction&orderSort=".$orderOppositeSort['faction']."','source/ajax/ajax-arenalist-getresults.php')\">Faction</a></td>
		<td width=\"25%\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=realm&orderSort=".$orderOppositeSort['realm']."','source/ajax/ajax-arenalist-getresults.php')\">Realm ".$orderSymbol['realm']."</a></td>
		<td width=\"25%\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=captain&orderSort=".$orderOppositeSort['captain']."','source/ajax/ajax-arenalist-getresults.php')\">Captain ".$orderSymbol['captain']."</a></td>
		<td width=\"10%\" align=\"center\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$pageNo."&orderBy=members&orderSort=".$orderOppositeSort['members']."','source/ajax/ajax-arenalist-getresults.php')\">Members ".$orderSymbol['members']."</a></td></td><td align=\"right\">
		<div>
		<b></b>
		</div>
		</td>
		</tr>";
		// Any ordering of the array $arenateams can occur here //
		if(!isset($orderSort))
		{
			$theSortId = 0;
			$theSortType = 0;
		}
		else
		{
			if($orderBy == "name")
				$theSortId = 1;
			else if($orderBy == "captain")
				$theSortId = 2;
			else if($orderBy == "members")
				$theSortId = 3;
			else if($orderBy == "realm")
				$theSortId = 4;
			else if($orderBy == "faction")
				$theSortId = 10;
			else 
				$theSortId = 0;
			if($orderSort == "DESC")
				$theSortType = 1;
			else
				$theSortType = 0;
		}
		//print nl2br(print_r($arenateams, 1));
		$arenateams = asort2d($arenateams, $theSortId, $theSortType, 0); // Default, sort by 0 (arenateam ID) //
		$chunks = array_chunk($arenateams, $results_per_page_arenateam, 1);
		$arenateams = $chunks[ ($pageNo - 1)];
		// How I managed to get that to work on the first try I don't know //
		foreach($arenateams as $key => $data)
		{
			print "<tr>
			<td>
			<div>
			<p></p>
			</div>
			</td><td class=\"csearch-results-table-item".$orderClassSuffix['name']."\"><q><a href=\"index.php?searchType=teaminfo&arenateamid=".$data[0]."&realm=".$data[4]."\">".$data[1]."</a></q></td>
			<td align=\"center\" class=\"csearch-results-table-item".$orderClassSuffix['faction']."\"><q><img src=\"images/icon-".$data[10].".gif\" height=\"20\" onmouseover=\"showTip('".ucfirst($data[10])."')\" onmouseout=\"hideTip()\"></q></td>
			<td class=\"csearch-results-table-item".$orderClassSuffix['realm']."\"><q>".$data[4]."</q></td>
			<td class=\"csearch-results-table-item".$orderClassSuffix['captain']."\"><q><a href=\"index.php?searchType=profile&character=".$data[5]."&realm=".$data[4]."\" onmouseover=\"showTip('Clicking this link will take you to the character profiles.')\" onmouseout=\"hideTip()\">".$data[5]."</a></q></td>
			<td align=\"center\" class=\"csearch-results-table-item".$orderClassSuffix['members']."\"><q>".$data[3]."</q></td><td align=\"right\">
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
		print BuildPageButtons($pageNo, $pages, "?searchQuery=".$SearchQuery, "source/ajax/ajax-arenalist-getresults.php");
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
		</td><td width=\"30%\"><a class=\"noLink\">Team Name</a></td>
		<td width=\"10%\" align=\"center\"><a class=\"noLink\">Faction</a></td>
		<td width=\"25%\"><a class=\"noLink\">Realm</a></td>
		<td width=\"25%\"><a class=\"noLink\">Captain</a></td>
		<td width=\"10%\" align=\"center\"><a class=\"noLink\">Members</a></td></td><td align=\"right\">
		<div>
		<b></b>
		</div>
		</td>
		</tr>";
		print "<tr>\n";
		print "<td align=\"center\" colspan=\"7\">There were no results for your search!</td>\n";
		print "</tr>\n";
	}
	print "</table></div>";
}
else
	print "<span class=\"csearch-results-info\">Error, you either failed to provide a arena team name or your search string was too short (&lt; ".$min_arenateam_search." characters) or you used invalid symbols (only alphabetic characters, digits and whitespace are allowed - whitespace can be used as any symbol)</span><br>\n";
?>
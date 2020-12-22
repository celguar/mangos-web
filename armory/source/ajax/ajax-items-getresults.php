<?php
require "../../configuration/mysql.php";
require "../../configuration/resources.inc.php";
require "../../configuration/functions.php";
error_reporting(E_ALL);
if (!isset($_GET["searchQuery"]))
	$do_query = 0;
else
{
	$SearchQuery = validate_string($_GET["searchQuery"]);
	if(strlen($SearchQuery) >= $MinItemsSearch)
		$do_query = 1;
	else
		$do_query = 0;
}
if ($do_query == 1)
{
	define("REALM_KEY", "");
	switchConnection("WEBSITE");
	$query_pls_gm = "SELECT * FROM `cache_item` WHERE `item_name` like '%".change_whitespace($SearchQuery)."%'";
	$doquery_pls_gm = mysql_query($query_pls_gm) or print mysql_error();
	$item_cache = array();
	while($result_pls_gm = mysql_fetch_assoc($doquery_pls_gm))
		$item_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
	$query_pls_gm = "SELECT * FROM `cache_item_search` WHERE `item_name` like '%".change_whitespace($SearchQuery)."%'";
	$doquery_pls_gm = mysql_query($query_pls_gm) or print mysql_error();
	$item_search_cache = array();
	while($result_pls_gm = mysql_fetch_assoc($doquery_pls_gm))
		$item_search_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
	switchConnection("WORLD");
	$ItemsQuery = mysql_query("SELECT `entry` FROM `item_template` WHERE `name` like '%".change_whitespace($SearchQuery)."%'") or die(mysql_error());
	$TotalItems = mysql_num_rows($ItemsQuery);
	while($ItemInfo = mysql_fetch_assoc($ItemsQuery))
	{
		if(!array_key_exists($ItemInfo["entry"], $item_search_cache))
		{
			set_time_limit(5);
			$item_search_cache[$ItemInfo["entry"]]=cache_item_search($ItemInfo["entry"]);
		}
	}
	switchConnection("WEBSITE");
	$ItemsQuery = mysql_query("SELECT `item_id`, `item_name`, `item_level`, `item_source`, `item_relevance` FROM `cache_item_search` WHERE `item_name` like '%".change_whitespace($SearchQuery)."%'") or die(mysql_error());
	if($TotalItems > 0)
	{
		while($ItemInfo = mysql_fetch_assoc($ItemsQuery))
			$Items[] = array($ItemInfo["item_id"], $ItemInfo["item_name"], $ItemInfo["item_level"], $ItemInfo["item_source"], $ItemInfo["item_relevance"]);
		$Orders = array("ItemName", "ItemLevel", "Source", "Relevance");
		$OrderOppositeSort = array();
		$OrderSymbol = array();
		$OrderSuffix = array();
		foreach($Orders as $Val)
		{
			$OrderOppositeSort[$Val] = "DESC";
			$OrderSymbol[$Val] = "";
			$OrderSuffix[$Val] = "";
		}
		if(isset($_GET["OrderBy"]))
		{
			$OrderBy = addslashes($_GET["OrderBy"]);
			$OrderSort = addslashes($_GET["OrderSort"]);
			if($OrderBy == "ItemName" || $OrderBy == "ItemLevel" || $OrderBy == "Source" || $OrderBy == "Relevance")
			{
				if($OrderSort == "ASC")
				{
					$OrderOppositeSort[$OrderBy] = "DESC";
					$OrderSymbol[$OrderBy] = "\/";
				}
				else
				{
					$OrderOppositeSort[$OrderBy] = "ASC";
					$OrderSymbol[$OrderBy] = "/\\";
				}
				$OrderSuffix[$OrderBy] = "-ordered";
			}
		}
		else
			$OrderBy = 2;
		$TotalPages = ceil($TotalItems/$ResultsPerPageItems);
		if(isset($_GET["page"]))
			$PageNo = ValidatePageNumber((int) $_GET["page"], $TotalPages);
		else
			$PageNo = 1;
		print "<span class=\"csearch-results-info\">".$TotalItems."&nbsp;results for&nbsp;<em>".stripslashes($SearchQuery)."</em>:</span><br>";
		print "<div id=\"big-results\" style=\"clear: both;\">
		<div class=\"data\">
		<table class=\"data-table\">
		<tr class=\"masthead\">
		<td>
		<div>
		<p></p>
		</div>
		</td><td style=\"width: 5%;\"></td>
		<td style=\"width: 35%;\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$PageNo."&OrderBy=ItemName&OrderSort=".$OrderOppositeSort['ItemName']."', 'source/ajax/ajax-items-getresults.php')\">Item Name ".$OrderSymbol['ItemName']."</a></td>
		<td style=\"width: 20%;\" align=\"center\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$PageNo."&OrderBy=ItemLevel&OrderSort=".$OrderOppositeSort['ItemLevel']."', 'source/ajax/ajax-items-getresults.php')\">Item Level ".$OrderSymbol['ItemLevel']."</a></td>
		<td style=\"width: 25%;\" align=\"center\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$PageNo."&OrderBy=Source&OrderSort=".$OrderOppositeSort['Source']."', 'source/ajax/ajax-items-getresults.php')\">Source ".$OrderSymbol['Source']."</a></td>
		<td style=\"width: 15%;\" align=\"center\"><a href=\"#\" onclick=\"showResult('?searchQuery=".$SearchQuery."&page=".$PageNo."&OrderBy=Relevance&OrderSort=".$OrderOppositeSort['Relevance']."', 'source/ajax/ajax-items-getresults.php')\">Relevance ".$OrderSymbol['Relevance']."</a></td><td align=\"right\">
		<div>
		<b></b>
		</div>
		</td>
		</tr>";
		if(!isset($OrderSort))
		{
			$TheSortId = 4;
			$TheSortType = 1;
		}
		else
		{
			if($OrderBy == "ItemName")
				$TheSortId = 1;
			else if($OrderBy == "ItemLevel")
				$TheSortId = 2;
			else if($OrderBy == "Source")
				$TheSortId = 3;
			else if($OrderBy == "Relevance")
				$TheSortId = 4;
			if($OrderSort == "DESC")
				$TheSortType = 1;
			else
				$TheSortType = 0;
		}
		$Items = asort2d($Items, $TheSortId, $TheSortType);
		$Chunks = array_chunk($Items, $ResultsPerPageItems);
		$Items = $Chunks[($PageNo - 1)];
		foreach($Items as $Key => $Data)
		{
			if(!array_key_exists($Data[0], $item_cache))
			{
				set_time_limit(5);
				$item_cache[$Data[0]]=cache_item($Data[0]);
			}
			$item_icon = $item_cache[$Data[0]]["item_icon"];
			$item_quality = $item_cache[$Data[0]]["item_quality"];
			$thissetdata = "";
			print "<tr>
			<td>
			<div>
			<p></p>
			</div>
			</td>";
			print "<td><img class=\"p43\" onMouseOut=\"hideTip();\" onmouseover=\"showTip('<span class=\'profile-tooltip-description\'>Loading...</span>'); showTooltip(".$Data[0].",'".$thissetdata."')\" src=\"".$item_icon."\"></td>
			<td class=\"csearch-results-table-item".$OrderSuffix['ItemName']."\"><span class=\"item-icon\"><q><a class=\"rarity".$item_quality."\" href=\"index.php?searchType=iteminfo&item=".$Data[0]."\" onMouseOut=\"hideTip();\" onmouseover=\"showTip('<span class=\'profile-tooltip-description\'>Loading...</span>'); showTooltip(".$Data[0].",'".$thissetdata."')\">".$Data[1]."</a><strong class=\"rarityShadow".$item_quality."\">".$Data[1]."</strong></q></span></td>
			<td align=\"center\" class=\"csearch-results-table-item".$OrderSuffix['ItemLevel']."\"><q>".$Data[2]."</q></td>
			<td align=\"center\" class=\"csearch-results-table-item".$OrderSuffix['Source']."\"><q>".$Data[3]."</q></td>
			<td align=\"center\" class=\"csearch-results-table-item".$OrderSuffix['Relevance']."\"><q>".$Data[4]."</q></td>";
			print "<td align=\"right\">
			<div>
			<b></b>
			</div>
			</td>
			</tr>";
		}
		print "</table></div>";
		print "<table><tr>\n";
		print "<td align=\"left\">\n";
		print "Page ". $PageNo." of ".$TotalPages;
		print "</td>\n";
		print "<td align=\"right\">\n";
		print BuildPageButtons($PageNo, $TotalPages, "?searchQuery=".$SearchQuery, "source/ajax/ajax-items-getresults.php");
		print "</td>\n";
		print "</tr>\n";
		print "</table>";
	}
	else
	{
		print "<span class=\"csearch-results-info\">0&nbsp;results for&nbsp;<em>".stripslashes($SearchQuery)."</em>:</span><br>";
		print "<div id=\"big-results\" style=\"clear: both;\">
		<div class=\"data\">
		<table class=\"data-table\">
		<tr class=\"masthead\">
		<td>
		<div>
		<p></p>
		</div>
		</td><td style=\"width: 5%;\"></td>
		<td style=\"width: 30%;\"><a class=\"noLink\">Item Name</a></td>
		<td style=\"width: 25%;\" align=\"center\"><a class=\"noLink\">Item Level</a></td>
		<td style=\"width: 25%;\" align=\"center\"><a class=\"noLink\">Source</a></td>
		<td style=\"width: 15%;\" align=\"center\"><a class=\"noLink\">Relevance</a></td><td align=\"right\">
		<div>
		<b></b>
		</div>
		</td>
		</tr>";
		print "<tr>";
		print "<td align=\"center\" colspan=\"7\">There were no results for your search!</td>";
		print "</tr>";
		print "</table></div>";
	}
}
else
	print "<span class=\"csearch-results-info\">Error, you either failed to provide a item name or your search string was too short (&lt; ".$MinItemsSearch." characters) or you used invalid symbols (only alphabetic characters, digits and whitespace are allowed - whitespace can be used as any symbol)</span><br>";
?>
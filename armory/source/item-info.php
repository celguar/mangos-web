<?php
if(!defined('Armory'))
{
	header('Location: ../item-search.php');
	exit();
}
error_reporting(E_ALL);
require "configuration/tooltipmgr.inc.php";
if(isset($_GET["item"]))
{
	switchConnection("WORLD");
	$itemQuery = mysql_query("SELECT * FROM `item_template` WHERE `entry` = '".(int) $_GET["item"]."'");
	if(mysql_num_rows($itemQuery) == 0)
		$o->showerror("That item does not exist!", "");
	else
	{
		$itemData = mysql_fetch_assoc($itemQuery);
?>
<span style="display:none;">start</span><script type="text/javascript">
	rightSideImage = "item";
	changeRightSideImage(rightSideImage);
</script>
<div class="results-side-collapsed" id="results-side-switch">
<div class="list">
<div class="team-side">
<div class="tip" style="clear: left;">
<table>
<tr>
<td class="tip-top-left"></td><td class="tip-top"></td><td class="tip-top-right"></td>
</tr>
<tr>
<td class="tip-left"></td><td class="tip-bg">
<div class="profile-wrapper">
<style type="text/css">
.genericHeader { padding: 33px 0 0 0; }
.shadow-tip .myItemName, .item-double .myItemName	{ font-size:18px; font-family: Arial, Helvetica, sans-serif; }
.shadow-tip .myGold 		{ color: black;}
.shadow-tip .myOrange		{ color: black;}
.shadow-tip .myPurple		{ color: black;}
.shadow-tip .myBlue			{ color: black;}
.shadow-tip .myGray			{ color: black;}  
.shadow-tip .myGreen		{ color: black;}
.shadow-tip .myYellow		{ color: black;} 
.shadow-tip .myRed			{ color: black;}
.shadow-tip .myWhite		{ color: black;} 
.shadow-tip .myTable		{ color: black;}
.shadow-tip .bonusGreen		{ color: black; }
.shadow-tip .myTable		{ color: black; }
.shadow-tip .bonusGreen		{ color: black; }
.shadow-tip .setNameYellow	{ color: black; font-size:11px; }
.shadow-tip .setItemYellow	{ color: black; }
.shadow-tip .setItemGray	{ color: black; }
.item-double .myTable, .shadow-tip .myTable		{ font-size: 13px; line-height: 23px; }
</style>
<blockquote>
<b class="iitems">
<h4>
<a href="item-search.php">Items</a>
</h4>
<h3>Item Search Results</h3>
</b>
</blockquote>
<div class="generic-wrapper">
<div class="generic-right">
<div class="genericHeader">
<div class="scroll" style="width: 100%;">
<div class="scroll-bot">
<div class="scroll-top">
<div class="scroll-right">
<div class="scroll-left">
<div class="scroll-bot-right">
<div class="scroll-bot-left">
<div class="scroll-top-right">
<div class="scroll-top-left">
<div class="item-padding">
<div class="displayTable">
<img height="250" src="images/pixel.gif" style="float: left;" width="1"><div class="icon-container">
<p></p>
<?php
		echo "<img class=\"p\" src=\"".GetIcon("item",$itemData["displayid"])."\"></div>"
?>
<div class="alt-stats">
<div class="as-top">
<div class="as-bot">
<em></em>
<p>
<span>Item Level:</span>
<br>
<?php
		echo "<strong>".$itemData["ItemLevel"]."</strong>";
?>
</p>
<?php
		if($itemData["BuyPrice"] > 0)
		{
			$BuyPrice = $itemData["BuyPrice"];
			ShowPrice($BuyPrice,1);
		}
		if($itemData["SellPrice"] > 0)
		{
			$SellPrice = $itemData["SellPrice"];
			ShowPrice($SellPrice,0);
		}
		if($itemData["RequiredDisenchantSkill"] > -1)
		{
			$width=($itemData["RequiredDisenchantSkill"]/375)*100;
			echo "<p><span>Disenchantable:</span>
			<br>
			<div class=\"skill-bar\">
			<b style=\"width: ".$width."%\"></b>";
			echo "<img onMouseOut=\"javascript: hideTip();\" onMouseOver=\"javascript: showTip('Requires <strong>".$itemData["RequiredDisenchantSkill"]."</strong> Enchanting to disenchant');\" src=\"images/icons/icon-disenchant-sm.gif\"><strong onMouseOut=\"javascript: hideTip();\" onMouseOver=\"javascript: showTip('Requires <strong>".$itemData["RequiredDisenchantSkill"]."</strong> Enchanting to disenchant');\">".$itemData["RequiredDisenchantSkill"]."</strong>";
		}
?>
</div>
</p>
</div>
</div>
</div>
<div class="item-info">
<div class="item-bound">
<div class="item-double">
<table border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td>
<?php
		echo outputTooltip((int) $_GET["item"], array(), "WSERVER", false, false);
?>
</td>
</tr>
</tbody>
</table>
</div>
<div class="id">
<table>
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"><q></q></td><td class="bg">
<div class="id-pad">
<div class="shadow-tip">
<table border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td>
<?php
		echo outputTooltip((int) $_GET["item"], array(), "WSERVER", false, false);
?>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</td><td class="r"><q></q></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="item-related">
<?php
/******************************************************************************************************************************************************************/
// Random Enchantment
		if($config["ShowRandomEnch"] == 1)
		{
			if($itemData["RandomProperty"] > 0 || $itemData["RandomSuffix"] > 0)
			{
				if($itemData["RandomProperty"] > 0)
				{
					$randomtable = 'itemrandomproperties';
					$randomentry = $itemData["RandomProperty"];
				}
				if($itemData["RandomSuffix"] > 0)
				{
					$randomtable = 'itemrandomsuffix';
					$randomentry = $itemData["RandomSuffix"];
				}
				switchConnection("WORLD");
				$RandomQuery = mysql_query("SELECT * FROM `item_enchantment_template` WHERE `entry` = ".$randomentry."") or die(mysql_error());
				if($RandomQuery)
				{
					echo "<div class=\"scroll-padding\"></div>
					<div class=\"rel-tab\">
					<p class=\"rel-randomchant\"></p>
					<h3>Random Enchantment:</h3>
					</div>
					<div class=\"data\" style=\"clear: both;\">
					<table class=\"data-table\">
					<tr class=\"masthead\">
					<td>
					<div>
					<p></p>
					</div>
					</td><td width=\"25%\"><a class=\"noLink\">Enchantment</a></td><td width=\"60%\"><a class=\"noLink\">Effects</a></td><td width=\"15%\" align=\"center\"><a class=\"noLink\">Chance</a></td><td align=\"right\">
					<div>
					<b></b>
					</div>
					</td>
					</tr>";
					switchConnection("WEBSITE");
					while($Random = mysql_fetch_assoc($RandomQuery))
					{
						$enchantment = mysql_fetch_array(mysql_query("SELECT * from `$randomtable` where id=".$Random["ench"].""));
						$enchantmentbonus="";
						for($i=1;$i<=3;$i++)
						{
							if($enchantment["spellitemench_".$i] <> 0)
							{
								$enchantmentbonus_select = mysql_fetch_array(mysql_query("SELECT name from `spellitemenchantment` where id=".$enchantment["spellitemench_".$i].""));
								if($enchantmentbonus<>"")
									$enchantmentbonus .=", ";
									$enchantmentbonus .= $enchantmentbonus_select["name"];
								/* For future development
								if($itemData["RandomSuffix"] > 0)
								{
									switch($enchantment["enchvalue_".$i])
									{
										default: $enchantvalue=0;
									}
									$enchantmentbonus = str_replace("\$i", $enchantvalue, $enchantmentbonus);
								}*/
							}
						}
						echo "<tr>
						<td>
						<div>
						<p></p>
						</div>
						</td><td valign=\"top\"><q>
						<div class=\"enchantName\">
						".$enchantment["name"]."<div class=\"enchantNameClone\">
						".$enchantment["name"]."</div>
						</div>
						</q></td><td valign=\"top\"><q>".$enchantmentbonus."</q></td><td align=\"center\"><q>".$Random["chance"]."%</q></td><td align=\"right\">
						<div>
						<b></b>
						</div>
						</td>
						</tr>";
					}
					echo "</table></div>";
				}
			}
		}
/******************************************************************************************************************************************************************/
// Disenchant
		if($config["ShowDisenchant"] == 1)
		{
			if($itemData["RequiredDisenchantSkill"] > -1 && $itemData["DisenchantID"] > 0)		
			{
				switchConnection("WORLD");
				$DisenchantLootQuery = mysql_query("SELECT * FROM `disenchant_loot_template` WHERE `entry` = '".$itemData["DisenchantID"]."'");
				if($DisenchantLootQuery)
				{
					echo "<div class=\"scroll-padding\"></div>
					<div class=\"rel-tab\">
					<p class=\"rel-de\"></p>
					<h3>Disenchants into</h3>
					</div>
					<div id=\"big-results\" style=\"clear: both;\">
					<div class=\"data\">
					<table class=\"data-table\">
					<tr class=\"masthead\">
					<td>
					<div>
					<p></p>
					</div>
					</td><td colspan=\"2\" style=\"width: 50%;\"><a class=\"noLink\">Name</a></td><td align=\"center\"><a class=\"noLink\">Drop Chance</a></td><td align=\"center\"><a class=\"noLink\">Count</a></td><td align=\"right\">
					<div>
					<b></b>
					</div>
					</td>
					</tr>";
					define("REALM_KEY", "");
					switchConnection("WEBSITE");
					$query_pls_gm = "SELECT * FROM `cache_item`";
					$doquery_pls_gm = mysql_query($query_pls_gm) or print mysql_error();
					$item_cache = array();
					while($result_pls_gm = mysql_fetch_assoc($doquery_pls_gm))
						$item_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
					while($DisenchantLootDetail = mysql_fetch_assoc($DisenchantLootQuery))
					{
						switchConnection("WORLD");
						$DisenchantItems = mysql_query("SELECT `entry`, `name`, `displayid`, `Quality` FROM `item_template` WHERE `entry` = '".$DisenchantLootDetail["item"]."'") or die(mysql_error());
						$DisenchantItemsDisplay = mysql_fetch_assoc($DisenchantItems);
						if(!array_key_exists($DisenchantItemsDisplay["entry"], $item_cache))
							$item_cache[$DisenchantItemsDisplay["entry"]] = cache_item($DisenchantItemsDisplay["entry"]);
						$thissetdata = "";
						echo "<tr>
						<td>
						<div>
						<p></p>
						</div>
						</td>
						<td width=\"55\"><img class=\"p43\" onMouseOut=\"hideTip();\" onmouseover=\"showTip('<span class=\'profile-tooltip-description\'>Loading...</span>'); showTooltip(".$DisenchantItemsDisplay["entry"].",'".$thissetdata."')\" src=\"".GetIcon("item",$DisenchantItemsDisplay["displayid"])."\"></td>
						<td class=\"item-icon\" width=\"50%\"><q><a class=\"rarity".$DisenchantItemsDisplay["Quality"]."\" href=\"index.php?searchType=iteminfo&item=".$DisenchantItemsDisplay["entry"]."\" onMouseOut=\"hideTip();\" onmouseover=\"showTip('<span class=\'profile-tooltip-description\'>Loading...</span>'); showTooltip(".$DisenchantItemsDisplay["entry"].",'".$thissetdata."')\">".$DisenchantItemsDisplay["name"]."</a><strong class=\"rarityShadow".$DisenchantItemsDisplay["Quality"]."\">".$DisenchantItemsDisplay["name"]."</strong></q></td>
						<td align=\"center\"><q>".GetChance($DisenchantLootDetail["ChanceOrQuestChance"])."</q></td>";
						if($DisenchantLootDetail["mincountOrRef"] != $DisenchantLootDetail["maxcount"])
							echo "<td align=\"center\"><q>".$DisenchantLootDetail["mincountOrRef"]." - ".$DisenchantLootDetail["maxcount"]."</q></td>";
						else
							echo "<td align=\"center\"><q>".$DisenchantLootDetail["mincountOrRef"]."</q></td>";
						echo "<td align=\"right\">
						<div>
						<b></b>
						</div>
						</td>
						</tr>";
					}
					echo "</table></div>";
				}
				else if($itemData["RequiredDisenchantSkill"] > -1 && $config["ShowError"] == 1)
					echo showerror("Disenchanting (DB error)", "Item <b>".$itemData["entry"]."</b> have RequiredDisenchantSkill <b>".$itemData["RequiredDisenchantSkill"]."</b> and DisenchantID <b>".$itemData["DisenchantID"]."</b> but have no records in <b>disenchant_loot_template</b> for entry <b>".$itemData["DisenchantID"]."</b> , please <b>report to GM</b>");
			}
			else if($itemData["RequiredDisenchantSkill"] > -1 && $config["ShowError"] == 1)
				echo showerror("Disenchanting (DB error)", "Item <b>".$itemData["entry"]."</b> have RequiredDisenchantSkill <b>".$itemData["RequiredDisenchantSkill"]."</b> but DisenchantID  <b>0</b>, please <b>report to GM</b>");
		}
/******************************************************************************************************************************************************************/
?>
</div>
</div>
</div>
</td><td class="tip-right"></td>
</tr>
<tr>
<td class="tip-bot-left"></td><td class="tip-bot"></td><td class="tip-bot-right"></td>
</tr>
</table>
</div>
</div>
<div class="rinfo">
</div>
</div>
<?php
	}
}
?>
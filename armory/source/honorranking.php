<?php
if(!defined('Armory'))
{
	header('Location: ../index.php?searchType=honor');
	exit();
}
// Get realm - copied from profileview.php //
if(!isset($_GET["realm"]))
{
	switchConnection("DEFAULT_REALM");
	define("REALM_KEY", $realms[$realmName["DEFAULT_REALM"]][0]);
	define("REALM_NAME", $realmName["DEFAULT_REALM"]);
}
else
{
	switchConnection($realms[stripslashes($_GET["realm"])][0]);
	define("REALM_KEY", $realms[stripslashes($_GET["realm"])][0]);
	define("REALM_NAME", stripslashes($_GET["realm"]));
}
$o->string("<div class=\"list\">
			<div class=\"full-list\">
			<div class=\"tip\" style=\"clear: left;\">
			<table width=\"100\">
			<tr>
			<td class=\"tip-top-left\"></td><td class=\"tip-top\"></td><td class=\"tip-top-right\"></td>
			</tr>
			<tr>
			<td class=\"tip-left\"></td><td class=\"tip-bg\">");
$o->string("<h3 align='center'>Honor Top ".$config['PvPTop'].": ".REALM_NAME."</h3>\n");
$realmsselect = "";
$realmnr = 0;
if(isset($_GET["sortBy"]))
{
	$sort = addslashes($_GET["sortBy"]);
	if($sort == "kills")
		$orderField = "kills";
	else if($sort == "honor")
		$orderField = "honor";
	else
		$orderField = "kills";
}
else
	$orderField = "kills";
foreach($realms as $key => $data)
{
	$realmsselect .= "<a href=\"index.php?searchType=honor&realm=".$key."&sortBy=".$orderField."\">".$key."</a>";
	$realmnr ++;
	if($realmnr < count($realms))
		$realmsselect .= " | ";
}
$o->string("<span class=\"page-subheader\"><p align='center'>(Realms: ".$realmsselect.")</p></span><br>\n");
$o->string("<div class=\"data\" style=\"clear: both;\">
<table class=\"data-table\">
<tr class=\"masthead\">
<td>
<div>
<p></p>
</div>
</td><td width=\"3%\"><a class=\"noLink\">Pos.</a></td>
<td width=\"25%\"><a class=\"noLink\">Character Name</a></td>
<td width=\"9%\" align=\"center\"><a class=\"noLink\">Level</a></td>
<td width=\"6%\" align=\"right\"><a class=\"noLink\">Race</a></td>
<td width=\"6%\" align=\"left\"><a class=\"noLink\">Class</a></td>
<td width=\"9%\" align=\"center\"><a class=\"noLink\">Faction</a></td>
<td width=\"20%\"><a class=\"noLink\">Guild</a></td>
<td width=\"9%\"><a href=\"index.php?searchType=honor&realm=".REALM_NAME."&sortBy=kills\">Kills</a></td>
<td width=\"9%\"><a href=\"index.php?searchType=honor&realm=".REALM_NAME."&sortBy=honor\">Honor</a></td><td width=\"1%\" align=\"right\">
<div>
<b></b>
</div>
</td>
</tr>");
// Query //
switchConnection(REALM_KEY);
$pvpquery = mysql_query("SELECT `guid`, `data`, `name`, `race`, `class` FROM `characters` 
WHERE CAST( SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', ".(HONOR+1)."), ' ', -1) AS UNSIGNED) >0
OR CAST( SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', ".(KILLS+1)."), ' ', -1) AS UNSIGNED) >0");
$characters=array();
$alen=0;
while($chardata = mysql_fetch_assoc($pvpquery))
{
	$char["guid"]=$chardata["guid"];
	$char["name"]=$chardata["name"];
	$char["race"]=$chardata["race"];	
	$char["class"]=$chardata["class"];
	$char_data = explode(' ',$chardata["data"]);	
	$char["kills"]=$char_data[KILLS];
	$char["honor"]=$char_data[HONOR];
	$char["level"] = $char_data[LEVEL];
	$char_gender = dechex($char_data[GENDER]);
	$char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
	$char["gender"] = $char_gender{3};
	$char["guildid"] = -1;
	$gquery=mysql_query("SELECT `guildid` FROM `guild_member` WHERE `guid` = '".$char["guid"]."'");	
	if(mysql_fetch_row($gquery)>0)
		$char["guildid"]=mysql_result($gquery,0,0);
	$characters[]=$char;
	$alen++;
}
function killsComp($a,$b)
{
	if($a["kills"]===$b["kills"])
		return 0;
	return ($a["kills"]<$b["kills"])?1:-1;
}
function honorComp($a,$b)
{
	if($a["honor"]===$b["honor"])
		return 0;
	return ($a["honor"]<$b["honor"])?1:-1;
}

switch($orderField)
{
	case "honor": usort($characters,"honorComp"); break;
	default: usort($characters,"killsComp"); break;
}
$counter = 1;
$guildInfoTooltip = array();
$mlen=($alen > $config['PvPTop'])?$config['PvPTop']:$alen;
for($i=0; $i < $mlen; $i++)
{
	$thisFaction = getFaction($characters[$i]["race"]);
	$thisName = "<a href=\"index.php?searchType=profile&character=".$characters[$i]["name"]."&realm=".REALM_NAME."\" onmouseover=\"showTip('Clicking this link will take you to the character profiles.')\" onmouseout=\"hideTip()\">".$characters[$i]["name"]."</a>";
	$thisRaceIcon = "<img src=\"images/icons/race/".$characters[$i]["race"]."-".$characters[$i]["gender"].".gif\" onmouseover=\"showTip('".$races[$characters[$i]["race"]] ."')\" onmouseout=\"hideTip()\">";
	$thisClassIcon = "<img src=\"images/icons/class/".$characters[$i]["class"].".gif\" onmouseover=\"showTip('".$classes[$characters[$i]["class"]] ."')\" onmouseout=\"hideTip()\">";
	if($characters[$i]["guildid"] > 0)
	{
		$gQuery = mysql_query("SELECT `guild`.`name` as `name`,`guild`.`guildid` as `guildid`,`guild`.`leaderguid` as `leaderguid` FROM `guild`,`guild_member` WHERE `guild`.`guildid`=`guild_member`.`guildid` and `guild_member`.`guildid` = '".$characters[$i]["guildid"]."'") or print mysql_error();
		$gData = mysql_fetch_assoc($gQuery);
		if(!isset($guildInfoTooltip[$chardata["guildid"]]))
		{
			$guildInfoTooltip[$characters[$i]["guildid"]] = "<span class=\'profile-tooltip-header\'>".$gData["name"]."</span><br>";
			$gleadq = mysql_query("SELECT `name` FROM `characters` WHERE `guid` = '".$gData["leaderguid"]."'");
			if(mysql_num_rows($gleadq) > 0)
				$guildInfoTooltip[$characters[$i]["guildid"]] .= "<span class=\'profile-tooltip-description\'>Leader: ".mysql_result($gleadq, 0, 0)."<br>";
			else
				$guildInfoTooltip[$characters[$i]["guildid"]] .= "<span class=\'profile-tooltip-description\'>Unknown Leader<br>";
			$guildInfoTooltip[$characters[$i]["guildid"]] .= "Realm: ".addslashes(REALM_NAME)."<br>";
			$gnumq = mysql_query("SELECT count(*) FROM `guild_member` WHERE `guildid` = '".$characters[$i]["guildid"]."'");
			if(mysql_num_rows($gleadq) > 0)
				$guildInfoTooltip[$characters[$i]["guildid"]] .= "Members: ".mysql_result($gnumq, 0, 0)."</span>";
			else
				$guildInfoTooltip[$characters[$i]["guildid"]] .= "No Members (?)</span>";	
		}
		$thisGuild = "<a href=\"index.php?searchType=guildinfo&guildid=".$gData["guildid"]."&realm=".REALM_NAME."\" onmouseover=\"showTip('".$guildInfoTooltip[$characters[$i]["guildid"]]."')\" onmouseout=\"hideTip()\">".$gData["name"]."</a>";
	}
	else
		$thisGuild = "None";
	$o->string("<tr>
	<td>
	<div>
	<p></p>
	</div>
	</td><td class=\"csearch-results-table-item\"><q>".$counter."</q></td>
	<td class=\"csearch-results-table-item\"><q>".$thisName."</q></td>
	<td align=\"center\" class=\"csearch-results-table-item\"><q>".$characters[$i]["level"]."</q></td>
	<td align=\"right\" class=\"csearch-results-table-item rightalign nopadding\"><q>".$thisRaceIcon."</q></td>
	<td align=\"left\" class=\"csearch-results-table-item leftalign nopadding\"><q>".$thisClassIcon."</q></td>
	<td align=\"center\" class=\"csearch-results-table-item\"><q><img width=\"20\" height=\"20\" src=\"images/icon-".$thisFaction.".gif\" onMouseOver=\"showTip('".ucfirst($thisFaction)."')\" onmouseout=\"hideTip()\"></q></td>
	<td class=\"csearch-results-table-item\"><q>".$thisGuild."</q></td>
	<td class=\"csearch-results-table-item\"><q>".$characters[$i]["kills"]."</q></td>
	<td class=\"csearch-results-table-item\"><q>".$characters[$i]["honor"]."</q></td><td align=\"right\">
	<div>
	<b></b>
	</div>
	</td>
	</tr>");
	$counter++;
}
$o->string("</table></div>");
$o->string("</td>
			<td class=\"tip-right\"></td>
			</tr>
			<tr>
			<td class=\"tip-bot-left\"></td><td class=\"tip-bot\"></td><td class=\"tip-bot-right\"></td>
			</tr>
			</table>
			</div>
			</div>");
?>
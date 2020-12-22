<?php
if(!defined('Armory'))
{
	header('Location: ../index.php?searchType=arena');
	exit();
}
// Get realm - copied from profileview.php //
?>
<script type="text/javascript">
	rightSideImage = "arena";
	changeRightSideImage(rightSideImage);
</script>
<?php
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
if(!isset($_GET["type"]))
	$type = 2;
else
{
	$type = (int) $_GET["type"];
	if(($type <> 2) && ($type <> 3) && ($type <> 5))
		$type = 2;
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
$o->string("<h3 align='center'>Arena ".$type."v".$type." Top ".$config['ArenaTop'].": ".REALM_NAME."</h3>\n");
$realmsselect = "";
$realmnr = 0;
if(isset($_GET["sortBy"]))
{
	$sort = addslashes($_GET["sortBy"]);
	if($sort == "personalrating")
		$orderField = "personalrating";
	else if($sort == "arenapoints")
		$orderField = "arenapoints";
	else
		$orderField = "personalrating";
}
else
	$orderField = "personalrating";
$o->string("<span class=\"page-subheader\"><p align='center'>(Types: ");
$o->string("<a href=\"index.php?searchType=arena&realm=".REALM_NAME."&sortBy=".$orderField."&type=2\">2v2</a>");
$o->string(" | ");
$o->string("<a href=\"index.php?searchType=arena&realm=".REALM_NAME."&sortBy=".$orderField."&type=3\">3v3</a>");
$o->string(" | ");
$o->string("<a href=\"index.php?searchType=arena&realm=".REALM_NAME."&sortBy=".$orderField."&type=5\">5v5</a>");
$o->string(" )</p></span>\n");
foreach($realms as $key => $data)
{
	$realmsselect .= "<a href=\"index.php?searchType=arena&realm=".$key."&sortBy=".$orderField."&type=".$type."\">".$key."</a>";
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
<td width=\"20%\"><a class=\"noLink\">Arena Team</a></td>
<td width=\"9%\"><a href=\"index.php?searchType=arena&realm=".REALM_NAME."&sortBy=personalrating&type=".$type."\">Rating</a></td>
<td width=\"9%\"><a href=\"index.php?searchType=arena&realm=".REALM_NAME."&sortBy=arenapoints&type=".$type."\">Points</a></td><td width=\"1%\" align=\"right\">
<div>
<b></b>
</div>
</td>
</tr>");
// Query //
switchConnection(REALM_KEY);
$pvpquery = mysql_query("SELECT `guid`, `data`, `name`, `race`, `class` FROM `characters`
 WHERE `guid` IN (SELECT `guid` FROM `arena_team_member`
 WHERE `arenateamid` IN (SELECT `arenateamid` FROM `arena_team` WHERE `type` = ".$type."))");
$characters=array();
$alen=0;
while($chardata = mysql_fetch_assoc($pvpquery))
{
	$char["guid"]=$chardata["guid"];
	$char["name"]=$chardata["name"];
	$char["race"]=$chardata["race"];
	$char["class"]=$chardata["class"];
	$char_data = explode(' ',$chardata["data"]);
	$char["arenapoints"]=$char_data[ARENAPOINTS];
	$char["level"] = $char_data[LEVEL];
	$char_gender = dechex($char_data[GENDER]);
	$char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
	$char["gender"] = $char_gender{3};
	$gquery=mysql_query("SELECT `arenateamid`, `personal_rating` FROM `arena_team_member` WHERE `guid` = '".$char["guid"]."' AND
	 `arenateamid` IN (SELECT `arenateamid` FROM `arena_team` WHERE `type` = ".$type.")");
	$char["arenateamid"]=mysql_result($gquery,0,0);
	$char["personalrating"]=mysql_result($gquery,0,1);
	$characters[]=$char;
	$alen++;
}
function personalratingComp($a,$b)
{
	if($a["personalrating"]===$b["personalrating"])
		return 0;
	return ($a["personalrating"]<$b["personalrating"])?1:-1;
}
function arenapointsComp($a,$b)
{
	if($a["arenapoints"]===$b["arenapoints"])
		return 0;
	return ($a["arenapoints"]<$b["arenapoints"])?1:-1;
}
switch($orderField)
{
	case "arenapoints": usort($characters,"arenapointsComp"); break;
	default: usort($characters,"personalratingComp"); break;
}
$counter = 1;
$arenateamInfoTooltip = array();
$mlen=($alen > $config['ArenaTop'])?$config['ArenaTop']:$alen;
for($i=0; $i < $mlen; $i++)
{
	$thisFaction = getFaction($characters[$i]["race"]);
	$thisName = "<a href=\"index.php?searchType=profile&character=".$characters[$i]["name"]."&realm=".REALM_NAME."\" onmouseover=\"showTip('Clicking this link will take you to the character profiles.')\" onmouseout=\"hideTip()\">".$characters[$i]["name"]."</a>";
	$thisRaceIcon = "<img src=\"images/icons/race/".$characters[$i]["race"]."-".$characters[$i]["gender"].".gif\" onmouseover=\"showTip('".$races[$characters[$i]["race"]] ."')\" onmouseout=\"hideTip()\">";
	$thisClassIcon = "<img src=\"images/icons/class/".$characters[$i]["class"].".gif\" onmouseover=\"showTip('".$classes[$characters[$i]["class"]] ."')\" onmouseout=\"hideTip()\">";
	if($characters[$i]["arenateamid"] > 0)
	{
		$gQuery = mysql_query("SELECT `arena_team`.`name` as `name`,`arena_team`.`arenateamid` as `arenateamid`,`arena_team`.`captainguid` as `captainguid` FROM `arena_team`,`arena_team_member` WHERE `arena_team`.`arenateamid`=`arena_team_member`.`arenateamid` and `arena_team_member`.`arenateamid` = '".$characters[$i]["arenateamid"]."'") or print mysql_error();
		$gData = mysql_fetch_assoc($gQuery);
		if(!isset($arenateamInfoTooltip[$chardata["arenateamid"]]))
		{
			$arenateamInfoTooltip[$characters[$i]["arenateamid"]] = "<span class=\'profile-tooltip-header\'>".$gData["name"]."</span><br>";
			$gleadq = mysql_query("SELECT `name` FROM `characters` WHERE `guid` = '".$gData["captainguid"]."'");
			if(mysql_num_rows($gleadq) > 0)
				$arenateamInfoTooltip[$characters[$i]["arenateamid"]] .= "<span class=\'profile-tooltip-description\'>Captain: ".mysql_result($gleadq, 0, 0)."<br>";
			else
				$arenateamInfoTooltip[$characters[$i]["arenateamid"]] .= "<span class=\'profile-tooltip-description\'>Unknown Captain<br>";
			$arenateamInfoTooltip[$characters[$i]["arenateamid"]] .= "Realm: ".addslashes(REALM_NAME)."<br>";
			$gnumq = mysql_query("SELECT count(*) FROM `arena_team_member` WHERE `arenateamid` = '".$characters[$i]["arenateamid"]."'");
			if(mysql_num_rows($gleadq) > 0)
				$arenateamInfoTooltip[$characters[$i]["arenateamid"]] .= "Members: ".mysql_result($gnumq, 0, 0)."</span>";
			else
				$arenateamInfoTooltip[$characters[$i]["arenateamid"]] .= "No Members (?)</span>";
		}
		$thisArenaTeam = "<a href=\"index.php?searchType=teaminfo&arenateamid=".$gData["arenateamid"]."&realm=".REALM_NAME."\" onmouseover=\"showTip('".$arenateamInfoTooltip[$characters[$i]["arenateamid"]]."')\" onmouseout=\"hideTip()\">".$gData["name"]."</a>";
	}
	else
	$thisArenaTeam = "None";
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
	<td class=\"csearch-results-table-item\"><q>".$thisArenaTeam."</q></td>
	<td class=\"csearch-results-table-item\"><q>".$characters[$i]["personalrating"]."</q></td>
	<td class=\"csearch-results-table-item\"><q>".$characters[$i]["arenapoints"]."</q></td><td align=\"right\">
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
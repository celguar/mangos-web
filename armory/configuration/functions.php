<?php
function GetCharacterPortrait($CharacterLevel, $CharacterGender, $CharacterRace, $CharacterClass)
{
	if($CharacterLevel <= 59)
		$CharacterPortrait = "wow-default/".$CharacterGender."-".$CharacterRace."-".$CharacterClass.".gif";
	else if($CharacterLevel >= 60 && $CharacterLevel <=69)
		$CharacterPortrait = "wow/".$CharacterGender."-".$CharacterRace."-".$CharacterClass.".gif";
	else if($CharacterLevel >= 70 && $CharacterLevel <=79)
		$CharacterPortrait = "wow-70/".$CharacterGender."-".$CharacterRace."-".$CharacterClass.".gif";
	else if($CharacterLevel >= 80)
		$CharacterPortrait = "wow-80/".$CharacterGender."-".$CharacterRace."-".$CharacterClass.".gif";
	return $CharacterPortrait;
}
function GetFaction($CharacterRace)
{
	if($CharacterRace == 1 || $CharacterRace == 3 || $CharacterRace == 4 || $CharacterRace == 7 || $CharacterRace == 11)
		return "alliance";
	else
		return "horde";
}
function GetIcon($Type, $DisplayIconId)
{
	if($Type == "item")
	{
		$Table = "itemdisplayinfo";
		$Field = "icon";
	}
	else if ($Type == "spell")
	{
		$Table = "spellicon";
		$Field = "name";
	}
	switchConnection("WEBSITE");
	$DisplayIconQuery = mysql_query("SELECT * FROM `".$Table."` WHERE `id` = '".$DisplayIconId."'");
	if(mysql_num_rows($DisplayIconQuery) > 0)
	{
		$Icon = mysql_fetch_assoc($DisplayIconQuery);
		$IconName = str_replace("/images/icons/64x64/", "images/icons/64x64/", $Icon[$Field]);
		$IconDisplay = "images/icons/64x64/".$IconName.".png";
	}
	else
		$IconDisplay = "images/icons/64x64/404.png";
	return $IconDisplay;
}
function GetChance($Chance)
{
	if($Chance == 100)
		$Chance = "Guaranteed (".$Chance."%)";
	else if($Chance >= 51 && $Chance < 100)
		$Chance = "High (".$Chance."%)";
	else if($Chance >= 15 && $Chance < 51)
		$Chance = "Low (".$Chance."%)";
	else
		$Chance = "Very Low (".$Chance."%)";
	return $Chance;
}
function GetItemSource($item_id, $pvpreward = 0)
{
	switchConnection("WORLD");
	if(mysql_num_rows(mysql_query("SELECT `entry` FROM `quest_template` WHERE `SrcItemId` = '".$item_id."' LIMIT 1")) == 1)
		$sourceText = "Quest Item";
	else if(mysql_num_rows(mysql_query("SELECT `entry` FROM `npc_vendor` WHERE `item` = '".$item_id."' LIMIT 1")) == 1)
	{
		if($pvpreward)
			$sourceText = "PVP Reward";
		else
			$sourceText = "Vendor";
	}
	else if(mysql_num_rows(mysql_query("SELECT `entry` FROM `gameobject_loot_template` WHERE `item` = '".$item_id."' LIMIT 1")) == 1)
		$sourceText = "Chest Drop";
	else if(mysql_num_rows(mysql_query("SELECT `entry` FROM `creature_loot_template` WHERE `item` = '".$item_id."' LIMIT 1")) == 1)
		$sourceText = "Drop";
	else if(mysql_num_rows(mysql_query("SELECT `entry` FROM `quest_template` WHERE `RewChoiceItemId1` = '".$item_id."' OR `RewChoiceItemId2` = '".$item_id."'
	OR `RewChoiceItemId3` = '".$item_id."' OR `RewChoiceItemId4` = '".$item_id."' OR `RewChoiceItemId5` = '".$item_id."' OR `RewChoiceItemId6` = '".$item_id."'
	OR `RewItemId1` = '".$item_id."' OR `RewItemId2` = '".$item_id."' OR `RewItemId3` = '".$item_id."' OR `RewItemId4` = '".$item_id."' LIMIT 1")) == 1)
		$sourceText = "Quest reward";
	else
		$sourceText = "Created";
	return $sourceText;
}
function cache_item($itemid)
{
	global $stattype;
	// Check if the item is already cached //
	switchConnection("WEBSITE");
	$query = mysql_query("SELECT * FROM `cache_item` WHERE `item_id` = '".$itemid."'");
	if(mysql_num_rows($query) > 0)
		return 0;
	else
	{
		// Custom item 
		require_once "tooltipmgr.inc.php";
		$tooltip_html = outputTooltip($itemid, array(), REALM_KEY);
		//Get item data 
		switchConnection("WORLD");
		$itemQuery = mysql_query("SELECT * FROM `item_template` WHERE `entry` = '".$itemid."'") or die("<b>Fatal Error:</b> Error in item cache process for item ".$itemid.": ".mysql_error());
		$itemData = mysql_fetch_assoc($itemQuery);
		// Initialise stats that can't immediately be pulled from database
		$itemStat = array(
		"strength" => 0,
		"stamina" => 0,
		"agility" => 0,
		"intellect" => 0,
		"spirit" => 0,
		"critrating" => 0,
		"hitrating" => 0,
		"defenserating" => 0,
		"attackpower" => 0,
		"dodgerating" => 0,
		"parryrating" => 0,
		"resiliencerating" => 0,
		"hit" => 0,
		"crit" => 0,
		"mana" => 0,
		"health" => 0,
		"meleecritrating" => 0,
		"meleehitrating" => 0,
		"rangecritrating" => 0,
		"rangehitrating" => 0,
		"frostdmg" => 0,
		"firedmg" => 0,
		"naturedmg" => 0,
		"shadowdmg" => 0,
		"arcanedmg" => 0,
		"holydmg" => 0,
		"healing" => 0,
		"spelldmg" => 0,
		"spellhit" => 0,
		"spellcrit" => 0,
		"spelleffect" => 0,
		"spellhaste" => 0,
		"shieldblock" => 0,
		"blockrating" => 0,
		"haste" => 0,
		"expertise" => 0,
		"attackpower" => 0,
		"manaregen" => 0,
		"spellpower" => 0
		);
		for($i = 1; $i <= 10; $i ++)
		{
			if($itemData["stat_type".$i] > 0)
			{
				$statId = $itemData["stat_type".$i];
				$itemStat[$stattype[$statId]] += $itemData["stat_value".$i];
			}
		}
		$applyAuras = array(
		1 => array("attackpower", 1),
		9 => array("attackpower", 1),
		13 => array("spelldmg", 1),
		49 => array("dodgerating", 12),
		52 => array("critrating", 14),
		54 => array("hitrating", 12),
		99 => array("attackpower", 1),
		135 => array("healing", 1),
		158 => array("shieldblock", 1),
		);
		switchConnection("WEBSITE");
		for($i = 1 ; $i <= 5 ; $i ++)
		{
			// only when effect is triggered "on equip"
			if(($itemData["spellid_".$i] > 0) && ($itemData["spelltrigger_".$i] == 1))
			{
				for($ii = 1 ; $ii <= 3 ; $ii ++)
				{
					//Get the spell data 
					$sQuery = mysql_query("SELECT `id`,`effect_basepoints_".$ii."`,`effect_aura_".$ii."` FROM `spell` WHERE `id` = '".$itemData["spellid_".$i]."'") or print mysql_error();
					if(mysql_num_rows($sQuery) <> 0)
					{
						$sData = mysql_fetch_assoc($sQuery);
						if(array_key_exists($sData["effect_aura_".$ii], $applyAuras))
							$itemStat[$applyAuras[$sData["effect_aura_".$ii]][0]] += ($sData["effect_basepoints_".$ii]+1)*$applyAuras[$sData["effect_aura_".$ii]][1];
					}
				}
			}
		}
		// Hit+Crit gets added to melee and ranged hit+crit 
		$itemStat["meleehitrating"] += $itemStat["hit"];
		$itemStat["rangehitrating"] += $itemStat["hit"];
		$itemStat["meleecritrating"] += $itemStat["crit"];
		$itemStat["rangecritrating"] += $itemStat["crit"];
		$itemStat["healing"] = $itemStat["spelldmg"]+$itemStat["healing"];
		$db_fields = array(
		"item_id" => $itemData["entry"],
		"item_name" => $itemData["name"],
		"item_quality" => $itemData["Quality"],
		"item_html" => $tooltip_html,
		"item_icon" => GetIcon("item",$itemData["displayid"]),
		"item_armor" => $itemData["armor"],
		"item_dmg_high" => ceil($itemData["dmg_max1"]),
		"item_dmg_low"  => ceil($itemData["dmg_min1"]),
		"item_speed" => $itemData["delay"],
		"item_strength" => $itemStat["strength"],
		"item_stamina" => $itemStat["stamina"], 
		"item_agility" => $itemStat["agility"], 
		"item_intellect" => $itemStat["intellect"], 
		"item_spirit" => $itemStat["spirit"], 
		"item_critrating" => $itemStat["critrating"], 
		"item_hitrating" => $itemStat["hitrating"], 
		"item_defenserating" => $itemStat["defenserating"], 
		"item_block" => $itemData["block"],
		"item_attack" => $itemStat["attackpower"],
		"item_dodgerating" => $itemStat["dodgerating"],
		"item_parryrating" => $itemStat["parryrating"],
		"item_resiliencerating" => $itemStat["resiliencerating"],
		"item_meleecritrating" => $itemStat["meleecritrating"],
		"item_meleehitrating" => $itemStat["meleehitrating"],
		"item_rangecritrating" => $itemStat["rangecritrating"],
		"item_rangehitrating" => $itemStat["rangehitrating"],
		"item_arcane_resist" => $itemData["arcane_res"],
		"item_fire_resist" => $itemData["fire_res"],
		"item_frost_resist" => $itemData["frost_res"],
		"item_nature_resist" => $itemData["nature_res"],
		"item_shadow_resist" => $itemData["shadow_res"],
		"item_holy_resist" => $itemData["holy_res"],
		"item_frostdmg" => $itemStat["frostdmg"],
		"item_firedmg" => $itemStat["firedmg"],
		"item_naturedmg" => $itemStat["naturedmg"],
		"item_shadowdmg" => $itemStat["shadowdmg"],
		"item_arcanedmg" => $itemStat["arcanedmg"],
		"item_holydmg" => $itemStat["holydmg"],
		"item_healing" => $itemStat["healing"],
		"item_spelldmg" => $itemStat["spelldmg"],
		"item_spellhit" => $itemStat["spellhit"],
		"item_spellcrit" => $itemStat["spellcrit"],
		"item_haste" => $itemStat["haste"]
		);
		return InsertCache($db_fields , 'cache_item');
	}
}
function cache_item_search($itemid)
{
	// Check if the item is already cached //
	switchConnection("WEBSITE");
	$query = mysql_query("SELECT * FROM `cache_item_search` WHERE `item_id` = '".$itemid."'");
	if(mysql_num_rows($query) > 0)
		return 0;
	else
	{
		switchConnection("WORLD");
		$itemQuery = mysql_query("SELECT * FROM `item_template` WHERE `entry` = '".$itemid."'") or die("<b>Fatal Error:</b> Error in item cache process for item ".$itemid.": ".mysql_error());
		$itemData = mysql_fetch_assoc($itemQuery);
		if(($itemData["Flags"] & 32768) == 32768)
			$pvpreward = 1;
		else
			$pvpreward = 0;
		$db_fields = array(
		"item_id" => $itemData["entry"],
		"item_name" => $itemData["name"],
		"item_level" => $itemData["ItemLevel"],
		"item_source" => GetItemSource($itemData["entry"],$pvpreward),
		"item_relevance" => $itemData["Quality"]*25+$itemData["ItemLevel"]
		);
		return InsertCache($db_fields, 'cache_item_search');
	}
}
function InsertCache($db_fields, $db)
{
	// Insert
	switchConnection("WEBSITE");
	$querystring = "INSERT INTO `".$db."` (";
	foreach($db_fields as $field => $value)
		$querystring .= "`".$field."`,";
	// Chop the end of $querystring off
	$querystring = substr($querystring, 0, -1);
	$querystring .= ") VALUES (";
	foreach($db_fields as $field => $value)
		$querystring .= "'".str_replace("'", "\'", $value)."',";
	// Chop the end off again 
	$querystring = substr($querystring, 0, -1);
	$querystring .= ")";
	mysql_query($querystring) or die("Could not cache: ".mysql_error()); 
	return $db_fields; //return an associative array
}
function ShowPrice($Price, $buyorsell)
{
	echo "<p><span>";
	if ($buyorsell == 1)
		echo "Cost";
	else
		echo "Sells for";
	echo ":</span>
	<br>
	<strong>";
	$Gold = floor($Price/10000);
	$Silver = floor(($Price-$Gold*10000)/100);
	$Copper = floor($Price-$Gold*10000-$Silver*100);
	if ($Gold <> 0)
		echo $Gold."<img class=\"pMoney\" src=\"images/icons/money-gold.gif\">";
	if ($Silver <> 0)
		echo $Silver."<img class=\"pMoney\" src=\"images/icons/money-silver.gif\">";
	if ($Copper <> 0)
		echo $Copper."<img class=\"pMoney\" src=\"images/icons/money-copper.gif\">";
	echo "&nbsp;</strong>
	</p>";
}
function ShowAllowable($Allowable, $classorrace)
{
	require "infoarray.php";
	$AllowableString = "";
	if ($classorrace == 1)
		$AllowableTab = $AllowableClass;
	else 
		$AllowableTab=$AllowableRace;
	foreach ($AllowableTab as $value)
	{
		if (($Allowable & $value[0]) <> 0)
		{
			if ($AllowableString <> "")
				$AllowableString .= ",";
			$AllowableString .= "&nbsp;".$value[1];
		}
	}
	return $AllowableString;
}
function GetNameFromDB($Id, $table = "skillline")
{
	switchConnection("WEBSITE");
	$Query = mysql_query("SELECT `name` FROM `".$table."` WHERE `id`='".$Id."'") or die(mysql_error());
	$Result = mysql_fetch_assoc($Query);
	if (mysql_num_rows($Query) > 0)
		return $Result["name"];
	else 
		return "";
}
function ValidatePageNumber($Cur_Page = 1, $TotalPages = 1)
{
	if($Cur_Page > $TotalPages)
		$Cur_Page = $TotalPages;
	if($Cur_Page < 1)
		$Cur_Page = 1;
	return $Cur_Page;
}
function BuildPageButtons($Cur_Page = 1, $TotalPages = 1, $Main_Link, $File)
{
	$Cur_Page = ValidatePageNumber($Cur_Page, $TotalPages);
	$PageText = "";
	if($Cur_Page == 1)
		$PageText .= "<div class = \"pnav\"><ul><li><a class=\"prev-first-off\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li><li><a class=\"prev-off\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li>";
	else
	{
		$ActionRewind = $Main_Link."&page=1";
		$ActionBack =  $Main_Link."&page=".($Cur_Page - 1);
		$PageText .= "<div class = \"pnav\"><ul><li><a class=\"prev-first\" onclick=\"showResult('".$ActionRewind."', '".$File."')\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li><li><a class=\"prev\" onclick=\"showResult('".$ActionBack."', '".$File."')\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li>";
	}
	for($I = 0 ; $I < $TotalPages ; $I ++)
	{
		if(($I + 1) == ($Cur_Page))
			$PageText .= "<li><a class=\"sel\">" .($I+1)."</a></li>";
		else if($I <= 8 or ($I + 1) == $TotalPages)
		{
			$ActionClick = $Main_Link."&page=".($I+1);
			$PageText .= "<li><a class=\"p\" onclick=\"showResult('".$ActionClick."', '".$File."')\">".($I+1)."</a></li>";
		}
	}
	if($Cur_Page >= $TotalPages)
		$PageText .= "<li><a class=\"next-off\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li><li><a class=\"next-last-off\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li></ul></div>";
	else
	{
		$ActionFastforward = $Main_Link."&page=".$TotalPages;
		$ActionForward =  $Main_Link."&page=".($Cur_Page+1);
		$PageText .= "<li><a class=\"next\" onclick=\"showResult('".$ActionForward."', '".$File."')\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li><li><a class=\"next-last\" onclick=\"showResult('".$ActionFastforward."', '".$File."')\"><img src=\"images/pixel.gif\" height=\"1\" width=\"1\" /></a></li></ul></div>";
	}
	return $PageText;
}
// validate input - preventing SQL injection
function validate_string($string)
{
	$string = trim($string);
	// strips excess whitespace
	$string = preg_replace('/\s\s+/', ' ', $string);
	if(preg_match('/[^[:alnum:]\sР-пр-џ]/', iconv('UTF-8', 'cp1251//IGNORE', $string)))
		$string = "";
	return $string;
}
// for searching in db
function change_whitespace($string)
{
	$string = str_replace(' ', '%', $string);
	return $string;
}
//talent counting
function talentCounting($guid, $tab)
{
	$pt = 0;
	switchConnection(REALM_KEY, "character");
	$selSpell = "SELECT `spell` FROM `character_spell` WHERE `guid` = '".$guid."' AND `disabled` = '0'";
	$resSpell = mysql_query($selSpell) or die (mysql_error());
	while($getSpell = mysql_fetch_assoc($resSpell))
		$spells[] = $getSpell['spell'];
	switchConnection("WEBSITE");
	$selTal = "SELECT rank1, rank2, rank3, rank4, rank5 FROM `talent` WHERE `ref_tab` = '".$tab."'";
	$resTal = mysql_query($selTal) or die (mysql_error());
	while($row = mysql_fetch_assoc($resTal))
		$ranks[] = $row;
	foreach($ranks as $key=>$val)
	{
		foreach($spells as $k=>$v)
		{
			if(in_array($v, $val))
			{
				if(array_search($v, $val) == "rank1")
					$pt += 1;
				elseif(array_search($v, $val) == "rank2")
					$pt += 2;
				elseif(array_search($v, $val) == "rank3")
					$pt += 3;
				elseif(array_search($v, $val) == "rank4")
					$pt += 4;
				elseif(array_search($v, $val) == "rank5")
					$pt += 5;
			}
			else
				$pt += 0;
		}
	}
	return $pt;
}

//get a tab from TalentTab
function getTabOrBuild($class, $type, $tabnum)
{
	if($type == "tab")
		$field = "id";
	elseif($type == "build")
		$field = "name";
	switchConnection("WEBSITE");
	$selTab = "SELECT ".$field." FROM `talenttab` WHERE `refmask_chrclasses` = '".pow(2,($class-1))."' AND `tab_number` = '".$tabnum."'";
	$resTab = mysql_query($selTab) or die (mysql_error());
	$getTab = mysql_fetch_assoc($resTab);
	return $getTab[$field];
}
?>
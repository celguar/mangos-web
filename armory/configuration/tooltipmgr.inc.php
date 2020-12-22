<?php
function tooltip_addsinglerow($text, $classname = '')
{
	if($classname == '')
		$class = "item-text-standard";
	else
		$class = $classname;
	$tooltipText = "<tr><td class=\"".$class."\" colspan=\"2\">".$text."</td></tr>";
	return $tooltipText;
}
function tooltip_adddoublerow($text1, $text2, $classname1 = '', $classname2 = '')
{
	if($classname1 == '')
		$class1 = "item-text-standard";
	else
		$class1 = $classname1;
	if($classname2 == '')
		$class2 = "item-text-standard";
	else
		$class2 = $classname2;
	$tooltipText = "<tr><td class=\"".$class1."\" width=\"50%\">".$text1."</td><td class=\"".$class2." item-righttext\" width=\"50%\">".$text2."</td></tr>";
	return $tooltipText;
}
//Spell data
function spell_parsedata($spellinfo,$isitbuff=0)
{
	if(isset($spellinfo["id"]))
	{
		// exceptions
		$excarr=array(
		"46851" => "Increases the effective spell power of your Holy Shock when used as a healing spell by 15%.",
		"38437" => "Whenever you have an air totem, an earth totem, a fire totem, and a water totem active at the same time, you gain 15 mana per 5 sec, 35 spell critical strike rating, and up to 45 spell damage.",
		"38443" => "Whenever you have an air totem, an earth totem, a fire totem, and a water totem active at the same time, you gain 15 mana per 5 sec, 35 spell critical strike rating, and up to 45 spell damage.",
		"38430" => "Whenever you use Stormstrike, you gain 70 attack power for 12 sec",
		"38432" => "Whenever you use Stormstrike, you gain 70 attack power for 12 sec"
		);
		if((!$isitbuff) and (array_key_exists($spellinfo["id"], $excarr)))
			$spellText= $excarr[$spellinfo["id"]];
		else
		{
			if($isitbuff)
				$spellText = $spellinfo["description_buff"];
			else
				$spellText = $spellinfo["description"];
			//Spell Duration
			if($spellinfo["ref_duration"] > 0)
			{
				switchConnection("WEBSITE");
				$durationQuery = mysql_query("SELECT `durationValue` FROM `spellduration` WHERE `id` = '".$spellinfo["ref_duration"]."'") or print mysql_error();
				$thisDuration = (mysql_result($durationQuery, 0, 0)/1000)." sec";
				if ($thisDuration>60)
					$thisDuration = ($thisDuration/60)." min";
			}
			else
				$thisDuration = 0;
			for($i = 1 ; $i <= 3 ; $i ++)
			{
				if($spellinfo["effect_trigger_".$i] > 0)
				{
					$sepQuery = mysql_query("SELECT `ref_duration`, `effect_basepoints_1`, `effect_basepoints_2`, `effect_basepoints_3`, `effect_1`, `effect_2`, `effect_3` FROM `spell` WHERE `id` = '".$spellinfo["effect_trigger_".$i]."'");
					$triggerdata = mysql_fetch_assoc($sepQuery);
					$mySpellId = $spellinfo["effect_trigger_".$i];
					if($triggerdata["ref_duration"] > 0)
					{
						$durationQuery = mysql_query("SELECT `durationValue` FROM `spellduration` WHERE `id` = '".$triggerdata["ref_duration"]."'") or print mysql_error();
						$thisDurationTrigger = mysql_result($durationQuery, 0, 0)/1000;
						$spellText = str_replace("\$".$mySpellId."d", $thisDurationTrigger, $spellText);
					}
					for($l = 1 ; $l <= 3 ; $l ++)
					{
						$thisBasePoints = abs($triggerdata["effect_basepoints_".$l] + 1);
						$spellText = str_replace("\$".$mySpellId."s".$l, $thisBasePoints, $spellText);
						$spellText = str_replace("\$".$mySpellId."t".$l, ($triggerdata["effect_".$l] + 1), $spellText);
					}
				}
			}
			for($i=1;$i<=3;$i++)
			{
				$effectBasePoints = abs($spellinfo["effect_basepoints_".$i] + 1);
				if($effectBasePoints >1)
				{
					$switches = array(
					"#\\\${\\\$m".$i."/1000}#" => $effectBasePoints/1000,
					"#\\\${\\\$m".$i."/-1000}#" => $effectBasePoints/1000,
					"#\\\${\\\$m".$i."/10}#" => $effectBasePoints/10,
					"#\\\${\\\$m".$i."/-10}#" => $effectBasePoints/10,
					"#\\\$\/60000;([s,S])".$i."#" => $effectBasePoints/60000,
					"#\\\$\/1000;([s,S])".$i."#" => $effectBasePoints/1000,
					"#\\\$\/10;([s,S])".$i."#" => $effectBasePoints/10,
					"#\\\$\/5;([s,S])".$i."#" => $effectBasePoints/10,
					"#\\\$([s,m,M])".$i."#" => $effectBasePoints,
					);
					foreach($switches as $search => $replace)
						$spellText = preg_replace($search, $replace, $spellText);
				}
			}
			$standardSwitch = array(
			"\$d" => $thisDuration,
			"\$n" => $spellinfo["proc_charges"],
			"\$x1" => $spellinfo["effect_chaintarget_1"],
			"\$x2" => $spellinfo["effect_chaintarget_2"],
			"\$x3" => $spellinfo["effect_chaintarget_3"],
			);
			foreach($standardSwitch as $search => $replace)
				$spellText = str_replace($search, $replace, $spellText);
			for($i=1;$i<=3;$i++)
			{
				if($spellinfo["effect_amplitude_".$i]<>0)
				{
					$spellText = str_replace("\$t", $spellinfo["effect_amplitude_".$i]/1000, $spellText);
					$spellText = str_replace("\$o".$i, ($thisDuration/($spellinfo["effect_amplitude_".$i]/1000))*abs($spellinfo["effect_basepoints_".$i] + 1), $spellText);
				}
			}
			if($spellinfo["ref_radius_1"]<>0)
			{
				$radiusQuery = mysql_query("SELECT `yards_base` FROM `spellradius` WHERE `id` = '".$spellinfo["ref_radius_1"]."'");
				$radiusdata = mysql_fetch_assoc($radiusQuery);
				$spellText = str_replace("\$a1", $radiusdata["yards_base"], $spellText);
			}
		}
		return $spellText;
	}
	else
		return "[Database Error: Nonexistant spell.]";
}
function getStatType($statType, $statVal)
{
	$isGreenStat = 0;
	$statName = "";
	switch($statType)
	{
		case 0: $isGreenStat = 1; $statName = "Mana"; break;
		case 1: $isGreenStat = 1; $statName = "Health"; break;
		case 3: $isGreenStat = 0; $statName = "Agility"; break;
		case 4: $isGreenStat = 0; $statName = "Strength"; break;
		case 5: $isGreenStat = 0; $statName = "Intellect"; break;
		case 6: $isGreenStat = 0; $statName = "Spirit"; break;
		case 7: $isGreenStat = 0; $statName = "Stamina"; break;
		case 12: $isGreenStat = 1; $statName = "Equip: Increases defense rating by ".$statVal."."; break;
		case 13: $isGreenStat = 1; $statName = "Equip: Increases your dodge rating by ".$statVal."."; break;
		case 14: $isGreenStat = 1; $statName = "Equip: Increases your parry Rating by ".$statVal."."; break;
		case 15: $isGreenStat = 1; $statName = "Equip: Improves shield block rating by ".$statVal."."; break;
		case 16: $isGreenStat = 1; $statName = "Equip: Improves melee hit rating rating by ".$statVal."."; break;
		case 17: $isGreenStat = 1; $statName = "Equip: Improves ranged hit rating rating by ".$statVal."."; break;
		case 18: $isGreenStat = 1; $statName = "Equip: Improves spell hit rating by ".$statVal."."; break;
		case 19: $isGreenStat = 1; $statName = "Equip: Improves melee critical strike rating by ".$statVal."."; break;
		case 20: $isGreenStat = 1; $statName = "Equip: Improves ranged critical strike rating by ".$statVal."."; break;
		case 21: $isGreenStat = 1; $statName = "Equip: Improves spell critical strike rating by ".$statVal."."; break;
		case 22: $isGreenStat = 1; $statName = "Equip: Improves melee hit avoidance rating by ".$statVal."."; break;
		case 23: $isGreenStat = 1; $statName = "Equip: Improves ranged hit avoidance rating by ".$statVal."."; break;
		case 24: $isGreenStat = 1; $statName = "Equip: Improves spell hit avoidance rating by ".$statVal."."; break;
		case 25: $isGreenStat = 1; $statName = "Equip: Improves melee critical avoidance rating by ".$statVal."."; break;
		case 26: $isGreenStat = 1; $statName = "Equip: Improves ranged critical avoidance rating by ".$statVal."."; break;
		case 27: $isGreenStat = 1; $statName = "Equip: Improves spell critical avoidance rating by ".$statVal."."; break;
		case 28: $isGreenStat = 1; $statName = "Equip: Improves melee haste rating by ".$statVal."."; break;
		case 29: $isGreenStat = 1; $statName = "Equip: Improves ranged haste rating by ".$statVal."."; break;
		case 30: $isGreenStat = 1; $statName = "Equip: Improves spell haste rating by ".$statVal."."; break;
		case 31: $isGreenStat = 1; $statName = "Equip: Improves hit rating by ".$statVal."."; break;
		case 32: $isGreenStat = 1; $statName = "Equip: Improves critical strike rating by ".$statVal."."; break;
		case 33: $isGreenStat = 1; $statName = "Equip: Improves hit avoidance rating by ".$statVal."."; break;
		case 34: $isGreenStat = 1; $statName = "Equip: Improves critical avoidance rating by ".$statVal."."; break;
		case 35: $isGreenStat = 1; $statName = "Equip: Increases your resilience rating by ".$statVal."."; break;
		case 36: $isGreenStat = 1; $statName = "Equip: Improves haste rating by ".$statVal."."; break;
		case 37: $isGreenStat = 1; $statName = "Equip: Increases your expertise rating by ".$statVal."."; break;
		case 38: $isGreenStat = 1; $statName = "Equip: Increases attack power by ".$statVal."."; break;
		case 43: $isGreenStat = 1; $statName = "Equip: Increases your mana regen by ".$statVal."."; break;
		case 45: $isGreenStat = 1; $statName = "Equip: Increases spell power by ".$statVal."."; break;
		default: $isGreenStat = 1; $statName = "Error: Unknown Stat Type: ".$statType."/Value: ".$statVal;
	}
	if($isGreenStat == 1)
		return "[GREEN]".$statName;
	else if ($statVal<0)
		return $statVal." ".$statName;
	else
		return "+".$statVal." ".$statName;
}
/* ---- Generate a full item tooltip based on $itemid ---- */
/* ---- Returns the item HTML in one line ---- */
function outputTooltip($itemid, $mySetData = array(), $connection = "WSERVER", $input_playeritemsdata = false, $isittooltip = true)
{
	global $inventorytype, $tooltip_skillref, $tooltip_spellref;
	require "settings.inc.php"; // for error messages
	/* Item Tooltip Output Function */
	if(isset($itemid))
	{
		if($input_playeritemsdata != false)
			$itemIsOwned = 1;
		else
			$itemIsOwned = 0;
		/* Get Item Info */
		$itemid = (int) $itemid;
		switchConnection("WORLD");
		$tooltipText = "";
		$itemtable = "";
		$itemdataq = mysql_query("SELECT * FROM `item_template` WHERE `entry` = '".$itemid."'");
		$itemdata = mysql_fetch_assoc($itemdataq);
		$tooltipText .= "<table class=\"item-tooltip-table\" cellpadding=\"0\">";
		$itemtable .= "<div class=\"myTable\">";
		/* Item Quality */
		switch($itemdata["Quality"])
		{
			case 0: $itemQuality = "gray"; break;
			case 1: $itemQuality = "white"; break;
			case 2: $itemQuality = "green"; break;
			case 3: $itemQuality = "blue"; break;
			case 4: $itemQuality = "purple"; break;
			case 5: $itemQuality = "orange"; break;
			case 6: $itemQuality = "gold"; break;
		}
		$tooltipText .= tooltip_addsinglerow("<span class=\"item-quality-".$itemQuality."\">".$itemdata["name"]."</span>", "item-text-name");
		$itemtable .= "<span class=\"my".ucfirst($itemQuality)." myBold myItemName\"><span class=\"\">".$itemdata["name"]."</span><span class=\"\"> </span></span>";
		require "infoarray.php";
		/* Item Binding */
		switch($itemdata["bonding"])
		{
			case 1: $itemBinding = "Binds when picked up"; break;
			case 2: $itemBinding = "Binds when equipped"; break;
			case 3: $itemBinding = "Binds when used"; break;
			case 4: $itemBinding = "Quest item"; break;
			default: $itemBinding = "";
		}
		if($itemBinding != "")
		{
			$tooltipText .= tooltip_addsinglerow($itemBinding);
			$itemtable .= "<br>".$itemBinding;
		}
		/* Unique Status */
		if ($itemdata["Flags"] <> 0)
		{
			$count=0;
			$UniqueString="";
			foreach ($ItemFlags as $value)
			{
				if (($itemdata["Flags"] & $value[0]) <> 0)
				{
					$count=$count+1;
					if ($value[1] <> "")
						$UniqueString =$value[1];
				}
			}
			if (($UniqueString <> "") and ($count <> 0))
			{
				$tooltipText .= tooltip_addsinglerow($UniqueString);
				$itemtable .= "<br>".$UniqueString;
			}
			else if (($config["ShowError"] == 1) and ($count == 0))
			{
				$tooltipText .= tooltip_addsinglerow("<span class=\"error\">Error: Unknown item Flag ".$itemdata["Flags"].", please report to GM</span>");
				$itemtable .= "<br><span class=\"error\">Error: Unknown item Flag ".$itemdata["Flags"].", please report to GM</span>";
			}
		}
		$greenStats = array();
		/* Item Type (I.E.One Hand | Sword) */
		if($itemdata["InventoryType"] != 0)
		{
			$invType = $itemdata["InventoryType"];
			$itemClassRight = ""; /* Default Value */
			$itmSubClass = $itemdata["subclass"];
			$armorInventoryTypes = array(1, 3, 5, 6, 7, 8, 9, 10, 14, 20); /* Anything that might have a type such as "Leather" or "Plate" */
			$weaponInventoryTypes = array(13, 15, 17, 20, 21, 22, 23, 24, 25, 26, 27); /* Anything that might have a type such as Dagger, Shield..*/
			$relicInventoryTypes = array(28);
			if(in_array($invType, $armorInventoryTypes))
			{
				/* This is armor! */
				switch($itmSubClass)
				{
					case 1: $itemClassRight = "Cloth"; break;
					case 2: $itemClassRight = "Leather"; break;
					case 3: $itemClassRight = "Mail"; break;
					case 4: $itemClassRight = "Plate"; break;
					case 6: $itemClassRight = "Shield"; break;
					default: $itemClassRight = "";
				}
			}
			else if(in_array($invType, $weaponInventoryTypes))
			{
				switch($itmSubClass)
				{
					case 0: case 1: $itemClassRight = "Axe"; break; /* 1h and 2h axes */
					case 2: $itemClassRight = "Bow"; break;
					case 3: $itemClassRight = "Gun"; break;
					case 4: case 5: $itemClassRight = "Mace"; break;
					case 6: $itemClassRight = "Polearm"; break;
					case 7: case 8: $itemClassRight = "Sword"; break;
					case 10: $itemClassRight = "Staff"; break;
					case 13: $itemClassRight = "Fist Weapon"; break;
					case 15: $itemClassRight = "Dagger"; break;
					case 16: $itemClassRight = "Thrown"; break;
					case 18: $itemClassRight = "Crossbow"; break;
					case 19: $itemClassRight = "Wand"; break;
					default: $itemClassRight = "";
				}
			}
			else if(in_array($invType, $relicInventoryTypes))
			{
				switch($itmSubClass)
				{
					case 7: $itemClassRight = "Libram"; break;
					case 8: $itemClassRight = "Idol"; break;
					case 9: $itemClassRight = "Totem"; break;
					default: $itemClassRight = "";
				}
			}
			if($invType == 18)
			{
				$itemClassLeft = $itemdata["ContainerSlots"]." Slot ".$BagType[$itemdata["BagFamily"]]." Bag";
				$tooltipText .= tooltip_addsinglerow($itemClassLeft);
				$itemtable .= "<br>".$itemClassLeft;
			}
			else
			{
				$itemClassLeft = $inventorytype[$invType];
				$tooltipText .= tooltip_adddoublerow($itemClassLeft,$itemClassRight);
				$itemtable .= "<span class=\"tooltipRight\">".$itemClassRight."</span><br>".$itemClassLeft;
			}
			/* Damage */
			$itemIsWeapon = 0;
			$minDamage = 0;
			$totalMinDamage = 0;
			$maxDamage = 0;
			$totalMaxDamage = 0;
			/* Loop through item data to check if any of the dmg_min and dmg_max fields are set and handle output as such */
			for($i = 1; $i <= 5; $i ++)
			{
				if($itemdata["dmg_min".$i] != 0)
				{
					$itemIsWeapon = 1;
					$thisDelay = round($itemdata["delay"]/1000, 2);
					$minDamage = $itemdata["dmg_min".$i];
					$totalMinDamage += $minDamage;
					$maxDamage = $itemdata["dmg_max".$i];
					$totalMaxDamage += $maxDamage;
					switch($itemdata["dmg_type".$i])
					{
						case 0: $itemDamageType = ""; break;
						case 1: $itemDamageType = " Holy"; break;
						case 2: $itemDamageType = " Fire"; break;
						case 3: $itemDamageType = " Nature"; break;
						case 4: $itemDamageType = " Frost"; break;
						case 5: $itemDamageType = " Shadow"; break;
						case 6: $itemDamageType = " Arcane"; break;
						default: $itemDamageType = " Unknown:".$itemdata["dmg_type".$i];
					}
					if($i == 1)
					{
						$tooltipText .= tooltip_addsinglerow($minDamage."-".$maxDamage.$itemDamageType." Dmg");
						$itemtable .= "<br><span class=\"\">".$minDamage."-".$maxDamage."</span><span class=\"\">".$itemDamageType."&nbsp;</span><span class=\"\">Dmg</span>";
					}
					else
					{
						$tooltipText .= tooltip_addsinglerow("+".$minDamage."-".$maxDamage.$itemDamageType." Damage");
						$itemtable .= "<br><span class=\"\">+".$minDamage."-".$maxDamage."</span><span class=\"\">".$itemDamageType."&nbsp;</span><span class=\"\">Damage</span>";
					}
				}
			}
			if($itemIsWeapon == 1)
			{
				/* Convert delay to string to get .0 if it's not there */
				$thisDelayString = explode(".", $thisDelay);
				if(count($thisDelayString) == 1)
					$thisDelay = $thisDelayString[0].".00";
				else if(count($thisDelayString) == 2 and strlen($thisDelayString[1]) == 1)
					$thisDelay."0";
				/* Calculate DPS */
				$itemAverageDamage = ( $totalMinDamage + $totalMaxDamage)/2;
				$itemDamagePerSecond = round($itemAverageDamage/$thisDelay, 1);
				/* Convert to string to get .0 if it's not there */
				$itemDPSString = explode(".", $itemDamagePerSecond);
				if(count($itemDPSString) == 1)
					$itemDamagePerSecond .= ".0";
				$tooltipText .= tooltip_adddoublerow("(".$itemDamagePerSecond." damage per second)", "Speed ".$thisDelay);
				$itemtable .= "<span class=\"tooltipRight\">Speed&nbsp;".$thisDelay."</span><br>(<span class=\"\">".$itemDamagePerSecond."&nbsp;</span><span class=\"\">damage per second</span>)";
			}
			/* Armor Value */
			if($itemdata["armor"] > 0)
			{
				$tooltipText .= tooltip_addsinglerow($itemdata["armor"]." Armor");
				$itemtable .= "<br><span class=\"\"><span class=\"\">".$itemdata["armor"]."&nbsp;</span><span class=\"\">Armor</span></span>";
			}
			if($itemdata["RandomProperty"] > 0 || $itemdata["RandomSuffix"] > 0)
			{
				//на герое должны показываться статы...
				$tooltipText .= tooltip_addsinglerow("<span class=\"item-greenstat\">&lt;Random enchantment&gt;</span>");
				$itemtable .= "<br><span class=\"bonusGreen\">&lt;Random enchantment&gt;</span>";
			}
			/* Shield Block */
			if($itemdata["block"] > 0)
			{
				$tooltipText .= tooltip_addsinglerow($itemdata["block"]." Block");
				$itemtable .= "<br><span class=\"\"><span class=\"\">".$itemdata["block"]."&nbsp;</span><span class=\"\">Block</span></span>";
			}
			/* Statistics */
			$isGreenStat = 0;
			for($i = 1 ; $i <= 10 ; $i ++)
			{
				if($itemdata["stat_type".$i] > 0)
				{
					/* Confirmed stat */
					$statType = $itemdata["stat_type".$i];
					$statVal = $itemdata["stat_value".$i];
					$isGreenStat = 0;
					$statInfo = getStatType($statType, $statVal);
					if(strstr($statInfo, "[GREEN]"))
					{
						$isGreenStat = 1;
						$greenStats[] = str_replace("[GREEN]", "", $statInfo);
					}
					else
					{
						$tooltipText .= tooltip_addsinglerow($statInfo);
						$itemtable .= "<br><span class=\"\"><span class=\"\">".$statInfo."&nbsp;</span></span>";
					}
				}
			}
			/* More on $greenStats after Required Level line */
			/* Resistances */
			$resistances = array("arcane", "fire", "nature", "frost", "shadow");
			foreach($resistances as $resistance)
			{
				if($itemdata[$resistance."_res"] > 0)
				{
					$tooltipText .= tooltip_addsinglerow("+".$itemdata[$resistance."_res"]." ".ucfirst($resistance)." Resistance");
					$itemtable .= "<br><span class=\"\"><span class=\"\">+".$itemdata[$resistance."_res"]." ".ucfirst($resistance)." Resistance</span></span>";
				}
			}
			/* Sockets */
			for($i = 1 ; $i <= 3 ; $i ++)
			{
				if($itemdata["socketColor_".$i] > 0)
				{
					switch($itemdata["socketColor_".$i])
					{
						case 1:
						$sockcol = "Meta";
						break;
						case 2:
						$sockcol = "Red";
						break;
						case 4:
						$sockcol = "Yellow";
						break;
						case 8:
						$sockcol = "Blue";
						break;
						default:
						$sockcol = "Unk";
					}
					$tooltipText .= tooltip_addsinglerow("<img src=\"shared/global/tooltip/images/icons/Socket_".$sockcol.".png\"> ".ucfirst($sockcol)." Socket","setItemGray");
					$itemtable .= "<br><span class=\"setItemGray\"><img class=\"socketImg\" src=\"shared/global/tooltip/images/icons/Socket_".$sockcol.".png\">".ucfirst($sockcol)." Socket</span>";
				}
			}
			//socket Bonus
			if($itemdata["socketBonus"] <> 0)
			{
				switchConnection("WEBSITE");
				$socketQuery = mysql_query("SELECT name FROM `spellitemenchantment` WHERE `id` = '".$itemdata["socketBonus"]."'");
				if(mysql_num_rows($socketQuery) == 0 && $config["ShowError"] == 1)
				{
					$tooltipText .= tooltip_addsinglerow("<span class=\"error\">Error: Unknown socketBonus ".$itemdata["socketBonus"].", please report to GM</span>");
					$itemtable .= "<br><span class=\"error\">Error: Unknown socketBonus ".$itemdata["socketBonus"].", please report to GM</span>";
				}
				else
				{
					$SocketBonus = mysql_fetch_assoc($socketQuery);
					$tooltipText .= tooltip_addsinglerow("Socket Bonus: ".$SocketBonus["name"],"setItemGray");
					$itemtable .= "<br><span class=\"setItemGray\">Socket Bonus:&nbsp;".$SocketBonus["name"]."</span>";
				}
			}
			/* Durability */
			if($itemdata["MaxDurability"] != 0)
			{
				if($itemIsOwned == 0)
					$tooltipText .= tooltip_addsinglerow("Durability ".$itemdata["MaxDurability"]."&nbsp;/&nbsp;".$itemdata["MaxDurability"]);
				$itemtable .= "<br>Durability:&nbsp;".$itemdata["MaxDurability"]."&nbsp;/&nbsp;".$itemdata["MaxDurability"];
			}
		}
		//Requires Class
		$allowclass=$itemdata["AllowableClass"];
		if (($allowclass <> -1) and (($allowclass & 1535) <> 1535))
		{
			$ClassesString = ShowAllowable($allowclass,1);
			if ($ClassesString <> "")
			{
				$tooltipText .= tooltip_addsinglerow("Classes:".$ClassesString);
				$itemtable .= "<br>Classes:".$ClassesString;
			} 
			else if($config["ShowError"] == 1)
			{
				$tooltipText .= tooltip_addsinglerow("<span class=\"error\">Error: Unknown AllowableClass ".$itemdata["AllowableClass"]." item ".$itemdata["entry"].", please report to GM</span>");
				$itemtable .= "<br><span class=\"error\">Error: Unknown AllowableClass ".$itemdata["AllowableClass"]." item ".$itemdata["entry"].", please report to GM</span>";
			}
		}
		//Requires Race
		$allowrace=$itemdata["AllowableRace"];
		if (($allowrace <> -1) and (($allowrace & 1791) <> 1791))
		{
			$RacesString = ShowAllowable($allowrace,0);
			if ($RacesString <> "")
			{
				$tooltipText .= tooltip_addsinglerow("Races:".$RacesString);
				$itemtable .= "<br>Races:".$RacesString;
			}
			else if($config["ShowError"] == 1)
			{
				$tooltipText .= tooltip_addsinglerow("<span class=\"error\">Error: Unknown AllowableRace ".$itemdata["AllowableRace"]." item ".$itemdata["entry"].", please report to GM</span>");
				$itemtable .= "<br><span class=\"error\">Error: Unknown AllowableRace ".$itemdata["AllowableRace"]." item ".$itemdata["entry"].", please report to GM</span>";
			}
				
		  }
		// Requires Level 
		if($itemdata["RequiredLevel"] > 0)
		{
			$tooltipText .= tooltip_addsinglerow("Requires Level ".$itemdata["RequiredLevel"]);
			$itemtable .= "<br>Requires Level&nbsp;".$itemdata["RequiredLevel"];
		}
		/* Required Skill (riding, blacksmithing..) */
		if($itemdata["RequiredSkill"] > 0)
		{
			$requiredSkill = GetNameFromDB($itemdata["RequiredSkill"]);
			if($requiredSkill<>"")
			{
				$tooltipText .= tooltip_addsinglerow("Requires ".$requiredSkill." ".$itemdata["RequiredSkillRank"]);
				$itemtable .= "<br><span class=\"\">Requires&nbsp;</span><span class=\"\">".$requiredSkill."&nbsp;</span><span class=\"\"></span><span class=\"\">".$itemdata["RequiredSkillRank"]."</span><span class=\"\"></span>";
			}
			else if($config["ShowError"] == 1)
			{
				$tooltipText .= tooltip_addsinglerow("<span class=\"error\">Error: Unknown RequiredSkill ".$itemdata["RequiredSkill"]." item ".$itemdata["entry"].", please report to GM</span>");
				$itemtable .= "<br><span class=\"error\">Error: Unknown RequiredSkill ".$itemdata["RequiredSkill"]." item ".$itemdata["entry"].", please report to GM</span>";
			}
		}
		// Required Spell
		if($itemdata["requiredspell"] > 0)
		{
			$requiredSpell = GetNameFromDB($itemdata["requiredspell"],"spell");
			if($requiredSpell<>"")
			{
				$tooltipText .= tooltip_addsinglerow("Requires ".$requiredSpell);
				$itemtable .= "<br><span class=\"\">Requires&nbsp;</span><span class=\"\">".$requiredSpell."&nbsp;</span><span class=\"\"></span>";
			}
			else if($config["ShowError"] == 1)
			{
				$tooltipText .= tooltip_addsinglerow("<span class=\"error\">Error: Unknown requiredspell ".$itemdata["requiredspell"]." item ".$itemdata["entry"].", please report to GM</span>");
				$itemtable .= "<br><span class=\"error\">Error: Unknown requiredspell ".$itemdata["requiredspell"]." item ".$itemdata["entry"].", please report to GM</span>";
			}
	}
	// Green Statistics 
	if(count($greenStats) > 0)
	{
		foreach($greenStats as $key => $val)
		{
			$tooltipText .= tooltip_addsinglerow("<span class=\"item-greenstat\">".$val."</span>");
			$itemtable .= "<br><span class=\"bonusGreen\">".$val."</span>";
		}
	}
	// Spell Data
	$showspelldata = 1;
	for($i = 1 ; $i <= 5 ; $i ++)
	{
		if ($itemdata["spelltrigger_".$i] == 6)
			$showspelldata = 0;
	}
	if ($showspelldata <> 0)
	{
		for($i = 1 ; $i <= 5 ; $i ++)
		{
			if($itemdata["spellid_".$i] > 0)
			{
				switch($itemdata["spelltrigger_".$i])
				{
					case 0: $spellTrigger = "Use"; break;
					case 1: $spellTrigger = "Equip"; break;
					case 2: $spellTrigger = "Chance on Hit"; break;
					default: $spellTrigger = "UNKNOWN TRIGGER ".$itemdata["spelltrigger_".$i];
				}
				switchConnection("WEBSITE"); 
				$spellInfoQuery = mysql_query("SELECT * FROM `spell` WHERE `id` = '".$itemdata["spellid_".$i]."'") or print mysql_error();
				$spellData = mysql_fetch_assoc($spellInfoQuery);
				$spellDescription = spell_parsedata($spellData);
				$tooltipText .= tooltip_addsinglerow("<span class=\"item-greenstat\">".$spellTrigger.": ".$spellDescription."</span>");
				$itemtable .= "<br><span class=\"bonusGreen\">".$spellTrigger.": ".$spellDescription."</span>";
			}
		}
	}
	/* Item Set Data */
	if($itemdata["itemset"] != 0)
	{
		$itemSet = $itemdata["itemset"];
		if (strpos($itemdata["name"],"Gladiator") <> "")
			$gladiator_set = "AND `ItemLevel` = ".$itemdata["ItemLevel"]." AND `Quality` = ".$itemdata["Quality"];
		else
			$gladiator_set = "";
		/* Get Items in set */
		switchConnection("WORLD");
		$setItemsQuery = mysql_query("SELECT `entry`, `name`, `itemset` FROM `item_template` WHERE `itemset` = '".$itemSet."' ".$gladiator_set) or print mysql_error();
		$setItems = array();
		while($setItemData = mysql_fetch_assoc($setItemsQuery))
			$setItems[$setItemData["entry"]] = $setItemData["name"];
		/* Get Set Name */
		switchConnection("WEBSITE");
		$setQuery = mysql_query("SELECT * FROM `itemset` WHERE `id` = '".$itemSet."'") or print mysql_error();
		$setData = mysql_fetch_assoc($setQuery);
		$setName = $setData["name"];
		$tooltipText .= tooltip_addsinglerow("<br>".$setName." (".count($mySetData)."/".count($setItems).")", "item-set-name");
		$itemtable .= "<br><br><span class=\"setNameYellow\">".$setName." (".count($mySetData)."/".count($setItems).")</span><div class=\"setItemIndent\">";
		/* Output items in set */
		if(!isset($mySetData))
			$mySetData = array();
		foreach($setItems as $itemID => $itemName)
		{
			if(!in_array($itemID, $mySetData))
			{
				$tooltipText .= tooltip_addsinglerow($itemName, "item-set-item-unacquired"); // Player does not have this item
				$itemtable .= "<br><span class=\"setItemGray\">".$itemName."</span>";
			}
			else
			{
				$tooltipText .= tooltip_addsinglerow($itemName, "item-set-item-acquired"); // Player has this item
				$itemtable .= "<br><span class=\"\">".$itemName."</span>";
			}
		}
		$tooltipText .= tooltip_addsinglerow("<br>");
		$itemtable .= "</div><br>";
		$setBonuses = array();
		$setBonusesRequired = array();
		$setDataArray = array();
		for($i = 1 ; $i <= 8 ; $i ++)
		{
			if($setData["bonus_".$i] > 0)
			{
				//How many pieces do we need?
				$requiredSetPieces = $setData["pieces_".$i];
				//SET BONUSES
				$spellInfoQuery = mysql_query("SELECT * FROM `spell` WHERE `id` = '".$setData["bonus_".$i]."'");
				$spellInfo = mysql_fetch_assoc($spellInfoQuery);
				$setBonusesRequired[] = $requiredSetPieces;
				$setBonuses[] = spell_parsedata($spellInfo);
				$tooltipText .= tooltip_addsinglerow("(".$requiredSetPieces.") Set: ".spell_parsedata($spellInfo), "setItemGray");
				$itemtable .= "<br><span class=\"setItemGray\">(".$requiredSetPieces.") Set: ".spell_parsedata($spellInfo)."</span>";
			}
		}
	}
	/* Flavour Text */
	if($itemdata["description"] != NULL)
	{
		$tooltipText .= tooltip_addsinglerow("<span class=\"myYellow\">&quot;".$itemdata["description"]."&quot;</span>");
		$itemtable .= "<br><span class=\"myYellow\">&quot;".$itemdata["description"]."&quot;</span>";
	}
	if($config["ShowSource"] == 1)
	{
		switchConnection("WEBSITE");
		$SourceQuery = mysql_query("SELECT `item_source` FROM `cache_item_search` WHERE `item_id` = '".$itemdata["entry"]."'");
		if(mysql_num_rows($SourceQuery) > 0)
		{
			$SourceResult = mysql_fetch_assoc($SourceQuery);
			$ItemSource = $SourceResult["item_source"];
		}
		else
			$ItemSource = GetItemSource($itemdata["entry"]);
		$tooltipText .= "<tr><td colspan=\"2\"><br><span class=\"myYellow\">Source:&nbsp;</span><span class=\"\">".$ItemSource."</span></td></tr>";
		$itemtable .= "<br><br><span class=\"myYellow\">Source:&nbsp;</span><span class=\"\">".$ItemSource."</span>";
	}
	$tooltipText .= "</table>";
	$itemtable .= "</div>";
	}
	if($isittooltip == true)
		return $tooltipText;
	else
		return $itemtable;
}
?>
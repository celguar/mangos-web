<?php
function assign_stats($data)
{
	$statistic_data = explode(' ',$data["data"]);
	switchConnection("WORLD");
	$stat = array();
	$query = mysql_query("SELECT * FROM `player_levelstats` WHERE `race` = '".$data["race"]."' AND `class` = '".$data["class"]."' AND `level` = '".$statistic_data[LEVEL]."'");
	$results = mysql_fetch_assoc($query);
	$gender = dechex($statistic_data[GENDER]);
	$gender = str_pad($gender, 8, 0, STR_PAD_LEFT);
	require "settings.inc.php";
	if ($config['Client'] == 0)
		$eff = "_eff";
	else
		$eff = "";
	$stat["strength".$eff] = $statistic_data[STRENGTH];
	$stat["strength_base"] = $results["str"];
	$stat["agility".$eff] = $statistic_data[AGILITY];
	$stat["agility_base"] = $results["agi"];
	$stat["stamina".$eff] = $statistic_data[STAMINA];
	$stat["stamina_base"] = $results["sta"];
	$stat["intellect".$eff] = $statistic_data[INTELLECT];
	$stat["intellect_base"] = $results["inte"];
	$stat["spirit".$eff] = $statistic_data[SPIRIT];
	$stat["spirit_base"] = $results["spi"];
	$stat["hp"] = $statistic_data[HP];
	$stat["hero_mana"] = $statistic_data[MANA];
	$stat["rage"] = $statistic_data[RAGE]/10;
	$stat["energy"] = $statistic_data[ENERGY];
	$stat["armor_base"] = $statistic_data[ARMOR];
	$stat["armor".$eff] = $statistic_data[ARMOR];
	$stat["holy_res"] = $statistic_data[HOLY_RES];
	$stat["fire_res"] = $statistic_data[FIRE_RES];
	$stat["nature_res"] = $statistic_data[NATURE_RES];
	$stat["frost_res"] = $statistic_data[FROST_RES];
	$stat["shadow_res"] = $statistic_data[SHADOW_RES];
	$stat["arcane_res"] = $statistic_data[ARCANE_RES];
	$stat["level"] = $statistic_data[LEVEL];
	$stat["guild"] = $statistic_data[GUILD];
	$stat["guildrank"] = $statistic_data[GUILD_RANK];
	$stat["kills"] = $statistic_data[KILLS];
	$stat["honor"] = $statistic_data[HONOR];
	$stat["arenapoints"] = $statistic_data[ARENAPOINTS];
	$stat["gender"] = $gender{3};
	$stat["race"] = $data["race"];
	$stat["class"] = $data["class"];
	$stat["name"] = $data["name"];
	$stat["guid"] = $data["guid"];
	$stat["melee_ap_base"] = $statistic_data[MELEE_AP_BASE];
	$stat["melee_ap_bonus"] = $statistic_data[MELEE_AP_BONUS];
	$stat["melee_ap"] = $stat["melee_ap_base"] + $stat["melee_ap_bonus"];
	$stat["ranged_ap_base"] = $statistic_data[RANGED_AP_BASE];
	$stat["ranged_ap_bonus"] = $statistic_data[RANGED_AP_BONUS];
	$stat["ranged_ap"] = $stat["ranged_ap_base"] + $stat["ranged_ap_bonus"];
	$stat["block_percent"] = unpack("f", pack("L", $statistic_data[BLOCK_PERCENTAGE]));
	$stat["dodge_percent"] = unpack("f", pack("L", $statistic_data[DODGE_PERCENTAGE]));
	$stat["parry_percent"] = unpack("f", pack("L", $statistic_data[PARRY_PERCENTAGE]));
	$stat["crit_percent"] = unpack("f", pack("L", $statistic_data[CRIT_PERCENTAGE]));
	$stat["ranged_crit_percent"] = unpack("f", pack("L", $statistic_data[RANGED_CRIT_PERCENTAGE]));
	$stat["spell_crit_percent"] = unpack("f", pack("L", $statistic_data[SPELL_CRIT_PERCENTAGE]));
	$stat["defense_rating"] = $statistic_data[DEFENSE_RATING];
	$stat["dodge_rating"] = $statistic_data[DODGE_RATING];
	$stat["parry_rating"] = $statistic_data[PARRY_RATING];
	$stat["block_rating"] = $statistic_data[BLOCK_RATING];
	$stat["melee_hit_rating"] = $statistic_data[MELEE_HIT_RATING];
	$stat["ranged_hit_rating"] = $statistic_data[RANGED_HIT_RATING];
	$stat["spell_hit_rating"] = $statistic_data[SPELL_HIT_RATING];
	$stat["melee_crit_rating"] = $statistic_data[MELEE_CRIT_RATING];
	$stat["ranged_crit_rating"] = $statistic_data[RANGED_CRIT_RATING];
	$stat["spell_crit_rating"] = $statistic_data[SPELL_CRIT_RATING];
	$stat["resilience_rating"] = $statistic_data[RESILIENCE_RATING];
	$stat["meele_main_hand_min_dmg"] = unpack("f", pack("L", $statistic_data[MEELE_MAIN_HAND_MIN_DAMAGE]));
	$stat["meele_main_hand_max_dmg"] = unpack("f", pack("L", $statistic_data[MEELE_MAIN_HAND_MAX_DAMAGE]));
	$stat["meele_main_hand_attack_time"] = unpack("f", pack("L", $statistic_data[MEELE_MAIN_HAND_ATTACK_TIME]));
	$stat["meele_off_hand_min_dmg"] = unpack("f", pack("L", $statistic_data[MEELE_OFF_HAND_MIN_DAMAGE]));
	$stat["meele_off_hand_max_dmg"] = unpack("f", pack("L", $statistic_data[MEELE_OFF_HAND_MAX_DAMAGE]));
	$stat["meele_off_hand_attack_time"] = unpack("f", pack("L", $statistic_data[MEELE_OFF_HAND_ATTACK_TIME]));
	$stat["ranged_attack_time"] = unpack("f", pack("L", $statistic_data[RANGED_ATTACK_TIME]));
	$stat["ranged_min_dmg"] = unpack("f", pack("L", $statistic_data[RANGED_MIN_DAMAGE]));
	$stat["ranged_max_dmg"] = unpack("f", pack("L", $statistic_data[RANGED_MAX_DAMAGE]));
	return $stat;
}
function get_base($Rating, $CharLevel)
{
	require "infoarray.php";
	if ($CharLevel <= 60)
		return $RatingBases60[$Rating];
	else
		return $RatingBases70[$Rating];
}
function stathandler_getratingformula($Type, $Stat, $CharacterLevel, $RoundPoints = 2)
{
	$Base = get_base($Type, $CharacterLevel);
	if (($CharacterLevel <= 34) && (($Type == "dodge") || ($Type == "block") || ($Type == "parry") || ($Type == "defense")))
		$RequiredPercent = $Base/2;
	else if($CharacterLevel <= 10)
		$RequiredPercent = $Base/26;
	else if($CharacterLevel <= 60)
		$RequiredPercent = $Base*($CharacterLevel-8)/52;
	else if($CharacterLevel >= 61 && $CharacterLevel <= 70)
		$RequiredPercent = $Base*82/(262-3*$CharacterLevel);
	else
		$RequiredPercent = $Base*($CharacterLevel+12)/52;
	$FinalValue = round($Stat/$RequiredPercent, $RoundPoints);
	return $FinalValue;
}
// Damage Reduction from Armor //
function stathandler_getdamagereduction($cLevel, $cArmor)
{
	// From WoWWiki: Level 1-60 %Reduction = (Armor/(Armor+400+85*Enemy_Level))*100 //
	// From WoWWiki: 60+ %Reduction = (Armor/(Armor-22167.5+467.5*Enemy_Level))*100 //
	if($cLevel <= 60)
		return round(($cArmor/($cArmor+400+85*$cLevel))*100, 2);
	else
		return round(($cArmor/($cArmor-22167.5+467.5*$cLevel))*100, 2);
}
?>
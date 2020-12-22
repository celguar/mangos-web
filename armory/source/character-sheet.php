<?php
if(!defined('Armory'))
{
	header('Location: ../character-search.php');
	exit();
}
error_reporting(E_ALL);
if(!isset($_GET["character"]) || !isset($_GET["character"]["name"]) || !isset($_GET["realm"]) || !isset($_GET["realm"]["name"]) || !array_key_exists(stripslashes($_GET["realm"]), $realms))
{
	echo "Hack?";
	$do_query = 0;
}
else
{
	$request = validate_string($_GET["character"]);
	if ($request == "")
	{
		echo "Hack?";
		$do_query = 0;
	}
	else
	{
		define("CURRENT_CHARACTER", $request);
		$o->setobvar("CURRENT_CHARACTER", CURRENT_CHARACTER);
		switchConnection($realms[stripslashes($_GET["realm"])][0]);
		define("REALM_KEY", $realms[stripslashes($_GET["realm"])][0]);
		define("REALM_NAME", stripslashes($_GET["realm"]));
		$StatQuery = mysql_query("SELECT `guid`, `data`, `name`, `race`, `class` FROM `characters` WHERE `name` = '".CURRENT_CHARACTER."'") or print mysql_error();
		if(!mysql_num_rows($StatQuery))
		{
			$do_query = 0;
			$o->showerror("Character ".CURRENT_CHARACTER, "not exist on realm ".REALM_NAME);
		}
		else
			$do_query = 1;
	}
}
if($do_query == 1)
{
	$data = mysql_fetch_assoc($StatQuery);
	require "configuration/statisticshandler.inc.php";
	$stat = assign_stats($data);
	switchConnection(REALM_KEY, "character");
	if($stat["guild"] != 0)
	{
		$stat["guildrank"] = $stat["guildrank"] + 1;
		$GuildRankQuery = mysql_query("SELECT `rname` FROM `guild_rank` WHERE `guildid`='".$stat["guild"]."' AND `rid`='".$stat["guildrank"]."'") or die(mysql_error());
		$GuildNameQuery = mysql_query("SELECT `name` FROM `guild` WHERE `guildid`='".$stat["guild"]."'") or die(mysql_error());
		$GuildMembersQuery = mysql_query("SELECT `guid` FROM `guild_member` WHERE `guildid`='".$stat["guild"]."'") or die(mysql_error());
		$GuildRank = mysql_fetch_assoc($GuildRankQuery);
		$GuildName = mysql_fetch_assoc($GuildNameQuery);
		$GuildMembers = mysql_num_rows($GuildMembersQuery);
	}
	define("CURRENT_CHARACTER_ID", $stat["guid"]);
	echo "<script type='text/javascript'>
	var theClassId = ".$stat["class"].";
	var theRaceId = ".$stat["race"].";
	var theClassName = '".strtoupper($classes[$stat["class"]])."';
	var theLevel = ".$stat["level"].";
	var theRealmName = \"".$_GET["realm"]."\";
	var theCharName = '".$stat["name"]."';
	</script>";
?>
<div class="mini-search-start-state" id="results-side-switch">
<div class="list">
<div class="player-side">
<div class="tip" style="clear: left; position: relative; z-index: 99;">
<table>
<tr>
<td class="tip-top-left"></td><td class="tip-top"></td><td class="tip-top-right"></td>
</tr>
<tr>
<td class="tip-left"></td><td class="tip-bg">
<div class="profile-wrapper">
<div class="profile">
<?php
	echo "<div class='faction-".GetFaction($stat["race"])."'>";
?>
<div class="profile-left">
<div class="profile-right">
<div class="profile-content">
<script type="text/javascript">
	rightSideImage = "character";
	changeRightSideImage(rightSideImage);
</script>
<div class="profile-header">
<div class="profile-avatar">
<div class="profile-placeholder">
<?php
	echo "<a class='avatar-position'><img src='images/portraits/".GetCharacterPortrait($stat["level"], $stat["gender"], $stat["race"], $stat["class"])."' onmouseover=\"showTip('<span class=\'tooltip-whitetext\'>".$races[$stat["race"]]." ".$classes[$stat["class"]]."</span>')\" onmouseout=\"hideTip()\" ></a>";
?>
<p>
<div class="level-noflash"><?php echo $stat["level"]."<em>".$stat["level"] ?></em></div>
</p>
</div>
</div>
<div class="flash-profile" id="profile">
<div class="character-details">
<div class="character-outer">
<table>
<tr>
<td>
<h1>
<span style="font-size: 16px;"></span>
</h1>
<?php
	echo "<h2>".$stat["name"]."<span style='font-size: 16px; font-weight: normal'></span></h2>";
	if($stat["guild"] != 0)
		echo "<h3>".$GuildName["name"]."</h3>";
?>
<h4>
<span class="">Level&nbsp;</span><span class=''><?php echo $stat["level"] ?>&nbsp;</span><span class=""><?php echo strtoupper($races[$stat["race"]]) ?>&nbsp;</span><span class=""><?php echo strtoupper($classes[$stat["class"]]) ?></span>
</h4>
</td>
</tr>
</table>
</div>
<div class="character-clone">
<table>
<tr>
<td>
<h1>
<span style="font-size: 16px; color: #fff7d2"></span>
</h1>
<?php
	echo "<h2>".$stat["name"]."<span style='font-size: 16px; font-weight: normal;  color: #fff7d2'></span></h2>";
	if($stat["guild"] != 0)
		echo "<h3><a href=\"index.php?searchType=guildinfo&guildid=".$stat["guild"]."&realm=".REALM_NAME."\"><span onmouseover=\"showTip('<span class=\'profile-tooltip-header\'>Guild - ".$GuildName["name"]."\</span><br><span class=\'profile-tooltip-description\'>Guild Rank: ".$GuildRank["rname"]."<br>Members: ".$GuildMembers."</span>')\" onmouseout=\"hideTip()\">".$GuildName["name"]."</span></a></h3>";
?>
<h4>
<span class="">Level&nbsp;</span><span class=''><?php echo $stat["level"] ?>&nbsp;</span><span class=""><?php echo strtoupper($races[$stat["race"]]) ?>&nbsp;</span><span class=""><?php echo strtoupper($classes[$stat["class"]]) ?></span>
</h4>
</td>
</tr>
</table>
</div>
<div style="reldiv">
<div style="position: absolute; margin: 0px 0 0 0px; width: 700px;">
<div class="smallframe-a"></div>
<?php
	echo "<div class='smallframe-b'>".REALM_NAME."</div>";
?>
<div class="smallframe-icon">
<div class="reldiv">
<div class="smallframe-realm"></div>
</div>
</div>
<div class="smallframe-c"></div>
</div>
</div>
</div>
</div>
</div>
<div class="parch-profile-banner" id="banner" style="margin-top: -7px!important;">
<h1>Profile</h1>
</div>
<script src="js/character/pinChar.js" type="text/javascript"></script><script src="js/character/functions.js" type="text/javascript"></script><script type="text/javascript">
<?php
	foreach($ItemBaseStats as $key)
	{
		if(!isset($stat[$key]))
			$stat[$key] = 0;
	}
	$weapondata = array();
	$myinventory = array();
	switchConnection(REALM_KEY, "character");
	$invq = mysql_query("SELECT `item_template`, `slot` FROM `character_inventory` WHERE  `guid` = '".$stat["guid"]."' AND `bag` = '0'  AND `slot` <= '22'  ORDER BY `slot` LIMIT 22");
	$numresults = mysql_num_rows($invq);
	$query_pls_gm = "";
	if($numresults > 0)
	{
		$up = 0;
		$query_pls_gm = "SELECT * FROM `cache_item` WHERE ";
		while($invd = mysql_fetch_assoc($invq))
		{
			$myinventory[$invd["slot"]] = $invd;
			$myinventory[$invd["slot"]]["enchantments"]="";
			$query_pls_gm .= "`item_id` = '".$invd["item_template"]."'";
			if($up < $numresults - 1)
				$query_pls_gm .= " OR ";
			$up ++;
		}
		$query_pls_gm .= " LIMIT 22";
		switchConnection("WEBSITE");
		$item_cache = array();
		$doquery_pls_gm = mysql_query($query_pls_gm) or print mysql_error();
		while($result_pls_gm = mysql_fetch_assoc($doquery_pls_gm))
			$item_cache[$result_pls_gm["item_id"]] = $result_pls_gm;
	}
	for($i = 0 ; $i <= 22 ; $i ++)
	{
		// fill in nonexistant slots
		if(!isset($myinventory[$i]))
			$myinventory[$i] = array("item_template" => -1, "enchantments" => "", "slot" => $i);
		/* Get my id */
		switchConnection(REALM_KEY, "character");
		$bigselecton=mysql_query("SET SQL_BIG_SELECTS=1;");
		$itmq = mysql_query("SELECT * FROM `character_inventory`, `item_instance` WHERE `item_instance`.`owner_guid` = '".$stat["guid"]."' AND `character_inventory`.`slot` = '".$i."' LIMIT 1") or print mysql_error();
		$plritems_assoc[$i] = mysql_fetch_assoc($itmq);
		$itemid[$i] = $myinventory[$i]["item_template"];
		$thisId = $itemid[$i];
		$enchanttext[$i] = "";
		if($myinventory[$i]["enchantments"] != "")
			$itemenchants[$i] = $myinventory[$i]["enchantments"];
		else
			$itemenchants[$i] = "";
		if($itemid[$i] > 0)
		{
			if(!array_key_exists($itemid[$i], $item_cache))
				$item_cache[$itemid[$i]] = cache_item($itemid[$i]);
			// Item Icon //
			$itemicon[$i] = $item_cache[$thisId]["item_icon"];
			foreach($ItemBaseStats as $key)
			{
				if($item_cache[$thisId]["item_".$key] != 0)
					$stat[$key] += $item_cache[$thisId]["item_".$key];
			}
			$thissetdata = "";
		}
		else
		{
			$itemid[$i] = "-1";
			$itemicon[$i] = "images/icons/64x64/404.png";
		}
	}
	// WEAPON //
	$MainMin = floor($stat["meele_main_hand_min_dmg"][1]);
	$MainMax = floor($stat["meele_main_hand_max_dmg"][1]);
	$MainAttSpe = number_format(round(($stat["meele_main_hand_attack_time"][1]/1000),2), 2, '.', '');
	if ($MainAttSpe <> 0)
		$MainDPS = number_format(round((($MainMin+$MainMax)/2)/$MainAttSpe, 1), 1, '.', '');
	else
		$MainDPS = 0;
	$OffMin = floor($stat["meele_off_hand_min_dmg"][1]);
	$OffMax = floor($stat["meele_off_hand_max_dmg"][1]);
	$OffAttSpe = number_format(round(($stat["meele_off_hand_attack_time"][1]/1000),2), 2, '.', '');
	if ($OffAttSpe <> 0)
		$OffDPS = number_format(round((($OffMin+$OffMax)/2)/$OffAttSpe, 1), 1, '.', '');
	else
		$OffDPS = 0;
	$RangedMin = floor($stat["ranged_min_dmg"][1]);
	$RangedMax = floor($stat["ranged_max_dmg"][1]);
	$RangedAttSpe = number_format(round(($stat["ranged_attack_time"][1]/1000),2), 2, '.', '');
	if ($RangedAttSpe <> 0)
		$RangedDPS = number_format(round((($RangedMin+$RangedMax)/2)/$RangedAttSpe, 1), 1, '.', '');
	else
		$RangedDPS = 0;
	// END WEAPON //
	if ($config['Client'] == 0)
		$eff = "_eff";
	else
		$eff = "";
	// Strength
	switch($stat["class"])
	{
		case 1:
		case 2:
		case 6:
		$attackpowerstr = ($stat["strength".$eff]*2)-20;
		break;
		case 3:
		case 4:
		$attackpowerstr = $stat["strength".$eff]-20;
		break;
		case 7:
		case 11:
		$attackpowerstr = ($stat["strength".$eff]*2)-20;
		break;
		case 5:
		case 8:
		case 9:
		$attackpowerstr = $stat["strength".$eff]-10;
		break;
	}
	//Agility
	if($stat["class"] >= 3 && $stat["class"] <= 4)
		$attackpoweragi = ($stat["agility".$eff]-10);
	else
		$attackpoweragi = 0;
	$critConstant = 0;
	switch($stat["class"])
	{
		case CLASS_ROGUE:
		case CLASS_HUNTER:
		$critConstant = 40;
		break;
		case CLASS_DRUID:
		case CLASS_MAGE:
		case CLASS_PALADIN:
		case CLASS_PRIEST:
		case CLASS_SHAMAN:
		$critConstant = 25;
		break;
		case CLASS_WARLOCK:
		$critConstant = 24.69;
		break;
		case CLASS_WARRIOR:
		case CLASS_DEATH_KNIGHT:
		$critConstant = 33; 
		break;
	}
	$critchanceagi = round($stat["agility".$eff]/$critConstant, 2);
	$armoragi = $stat["agility".$eff]*2;
	//Stamina
	$increasehealthsta = $stat["stamina".$eff]*10-180;
	//Intelect
	if($stat["class"] == 2 or $stat["class"] >= 5)
		$increasemanaint = $stat["stamina".$eff]*15;
	else
		$increasemanaint = 0;
	//Spirit
	switch($stat["class"])
	{
		case CLASS_DRUID:
		$HPRegen = $stat["spirit".$eff]*0.09;
		break;
		case CLASS_PALADIN:
		case CLASS_HUNTER:
		$HPRegen = $stat["spirit".$eff]*0.25;
		break;
		case CLASS_PRIEST:
		case CLASS_MAGE:
		$HPRegen = $stat["spirit".$eff]*0.1;
		break;
		case CLASS_WARRIOR:
		case CLASS_ROGUE:
		case CLASS_DEATH_KNIGHT:
		$HPRegen = $stat["spirit".$eff]*0.5;
		break;
		case CLASS_SHAMAN:
		$HPRegen = $stat["spirit".$eff]*0.11;
		break;
		case CLASS_WARLOCK:
		$HPRegen = $stat["spirit".$eff]*0.07;
		break;
	}
	$HPRegen = ceil($HPRegen);
	switch($stat["class"])
	{
		case CLASS_DRUID:
		$ManaRegen = $stat["spirit".$eff]/4.5+15;
		break;
		case CLASS_PALADIN:
		case CLASS_HUNTER:
		case CLASS_SHAMAN:
		case CLASS_WARLOCK:
		$ManaRegen = $stat["spirit".$eff]/5+15;
		break;
		case CLASS_PRIEST:
		case CLASS_MAGE:
		$ManaRegen = $stat["spirit".$eff]/4+12;
		break;
	}
	if($stat["class"] != 1 && $stat["class"] != 4 && $stat["class"] != 6)
		$ManaRegen = ceil($ManaRegen)*2.5;
	else
		$ManaRegen = 0;
	// Armor
	$Reducedphysicaldamage = stathandler_getdamagereduction($stat["level"], $stat["armor".$eff]);
	if($stat["class"] == 3 || $stat["class"] == 9)
		$PetArmorBonus = floor($stat["armor".$eff]/2.857);
	else
		$PetArmorBonus = 0;
	//Melee Attack Power
	$increasedmgmeleatkpow = round($stat["melee_ap"]/14, 1);
	//Ranged Attack Power
	$increasedmgrngatpow = round($stat["ranged_ap"]/14, 1);
	if($stat["class"] == 3) // what about the warlocks pet?
	{
		$increasepetatpower = ceil($stat["ranged_ap"]*0.222);
		$increasepetspedmg = ceil($stat["ranged_ap"]*0.1287);
	}
	else
	{
		$increasepetatpower = 0;
		$increasepetspedmg = 0;
	}
	//Crit increase percent from rating
	$crit_increase_percent = stathandler_getratingformula("crit", $stat["melee_crit_rating"], $stat["level"], $RoundPoints = 2);
	//Hit increase percent from rating
	$hit_increase_percent = stathandler_getratingformula("hit", $stat["melee_hit_rating"], $stat["level"], $RoundPoints = 2);
	//Ranged Crit increase percent from rating
	$rangedcrit_increase_percent = stathandler_getratingformula("crit", $stat["ranged_crit_rating"], $stat["level"], $RoundPoints = 2);
	//Ranged Hit increase percent from rating
	$rangedhit_increase_percent = stathandler_getratingformula("hit", $stat["ranged_hit_rating"], $stat["level"], $RoundPoints = 2);
	//Spell Hit increase percent from rating
	$spellhit_increase_percent = stathandler_getratingformula("spell_hit", $stat["spell_hit_rating"], $stat["level"], $RoundPoints = 2);
	//Dodge increase percent from rating
	$dodge_increase_percent = stathandler_getratingformula("dodge", $stat["dodge_rating"], $stat["level"], $RoundPoints = 2);
	//Block increase percent from rating
	$block_increase_percent = stathandler_getratingformula("block", $stat["block_rating"], $stat["level"], $RoundPoints = 2);
	//Parry increase percent from rating
	$parry_increase_percent = stathandler_getratingformula("parry", $stat["parry_rating"], $stat["level"], $RoundPoints = 2);
	//Block Percent
	$stat["block_percent"] = round($stat["block_percent"][1],2);
	//Dodge Percent
	$stat["dodge_percent"] = round($stat["dodge_percent"][1],2);
	//Parry Percent
	$stat["parry_percent"] = round($stat["parry_percent"][1],2);
	//Crit Percent
	$stat["crit_percent"] = round($stat["crit_percent"][1],2);
	//Range Crit Percent
	$stat["ranged_crit_percent"] = round($stat["ranged_crit_percent"][1],2);
	//Spell Crit Percent
	$stat["spell_crit_percent"] = round($stat["spell_crit_percent"][1],2);
	echo "function strengthObject() {
		this.base = '".$stat["strength_base"]."';
		this.effective = '".$stat["strength".$eff]."';
		this.block = '0';
		this.attack = '".$attackpowerstr."';

		this.diff = this.effective - this.base;
	}

	function agilityObject() {
		this.base = '".$stat["agility_base"]."';
		this.effective = '".$stat["agility".$eff]."';
		this.critHitPercent = '".$critchanceagi."';
		this.attack = '".$attackpoweragi."';
		this.armor = '".$armoragi."';
		
		this.diff = this.effective - this.base;
	}

	function staminaObject(base, effective, health, petBonus) {
		this.base = '".$stat["stamina_base"]."';
		this.effective = '".$stat["stamina".$eff]."';
		this.health = '".$increasehealthsta."';
		this.petBonus = '0';

		this.diff = this.effective - this.base;
	}

	function intellectObject() {
		this.base = '".$stat["intellect_base"]."';
		this.effective = '".$stat["intellect".$eff]."';
		this.mana = '".$increasemanaint."';
		this.critHitPercent = '0';
		this.petBonus = '0';

		this.diff = this.effective - this.base;
	}

	function spiritObject() {
		this.base = '".$stat["spirit_base"]."';
		this.effective = '".$stat["spirit".$eff]."';
		this.healthRegen = '".$HPRegen."';
		this.manaRegen = '".$ManaRegen."';

		this.diff = this.effective - this.base;
	}

	function armorObject() {
		this.base = '".$stat["armor_base"]."';
		this.effective = '".$stat["armor".$eff]."';
		this.reductionPercent = '".$Reducedphysicaldamage."';
		this.petBonus = '".$PetArmorBonus."';
		
		this.diff = this.effective - this.base;	
	}

	function resistancesObject() {
		this.arcane = new resistArcaneObject('".$stat["arcane_res"]."', '0');
		this.nature = new resistNatureObject('".$stat["nature_res"]."', '0');	
		this.fire = new resistFireObject('".$stat["fire_res"]."', '0');
		this.frost = new resistFrostObject('".$stat["frost_res"]."', '0');
		this.shadow = new resistShadowObject('".$stat["shadow_res"]."', '0');
	}

	function meleeMainHandWeaponSkillObject() {
		this.value = '0';
		this.rating = '0';
		this.additional = '0';
		this.percent = '0.00';	
	}

	function meleeOffHandWeaponSkillObject() {
		this.value = '1';
		this.rating = '0';
	}


	function meleeMainHandDamageObject() {
		this.speed = '".$MainAttSpe."';
		this.min = '".$MainMin."';
		this.max = '".$MainMax."';
		this.percent = '0';	
		this.dps = '".$MainDPS."';	

		if (this.percent > 0)
			this.effectiveColor = \"class = 'mod'\";
		else if (this.percent < 0)
			this.effectiveColor = \"class = 'moddown'\";

	}

	function meleeOffHandDamageObject() {
		this.speed = '".$OffAttSpe."';
		this.min = '".$OffMin."';
		this.max = '".$OffMax."';
		this.percent = '0';	
		this.dps = '".$OffDPS."';	
	}


	function meleeMainHandSpeedObject() {
		this.value = '".$MainAttSpe."';
		this.hasteRating = '0';
		this.hastePercent = '0.00';
	}

	function meleeOffHandSpeedObject() {
		this.value = '".$OffAttSpe."';
		this.hasteRating = '0';
		this.hastePercent = '0.00';
	}

	function meleePowerObject() {
		this.base = '".$stat["melee_ap_base"]."';
		this.effective = '".$stat["melee_ap"]."';	
		this.increasedDps = '".$increasedmgmeleatkpow."';
		
		this.diff = this.effective - this.base;
	}

	function meleeHitRatingObject() {
		this.value = '".$stat["melee_hit_rating"]."';
		this.increasedHitPercent = '".$hit_increase_percent."';
	}

	function meleeCritChanceObject() {
		this.percent = '".$stat["crit_percent"]."';
		this.rating = '".$stat["melee_crit_rating"]."';
		this.plusPercent = '".$crit_increase_percent."';
	}

	function rangedWeaponSkillObject() {
		this.value = 0;
		this.rating = 0;
	}

	function rangedDamageObject() {
		this.speed = ".$RangedAttSpe.";
		this.min = ".$RangedMin.";
		this.max = ".$RangedMax.";
		this.dps = ".$RangedDPS.";
		this.percent = 0;

		if (this.percent > 0)
			this.effectiveColor = \"class = 'mod'\";
		else if (this.percent < 0)
			this.effectiveColor = \"class = 'moddown'\";

	}

	function rangedSpeedObject() {
		this.value = ".$RangedAttSpe.";
		this.hasteRating = 0;
		this.hastePercent = 0.00;
	}

	function rangedPowerObject() {
		this.base = ".$stat["ranged_ap_base"].";
		this.effective = ".$stat["ranged_ap"].";
		this.increasedDps = ".$increasedmgrngatpow.";
		this.petAttack = ".$increasepetatpower.";
		this.petSpell = ".$increasepetspedmg.";
		
		this.diff = this.effective - this.base;
	}

	function rangedHitRatingObject() {
		this.value = '".$stat["ranged_hit_rating"]."';
		this.increasedHitPercent = '".$rangedhit_increase_percent."';
	}

	function rangedCritChanceObject() {
		this.percent = '".$stat["ranged_crit_percent"]."';
		this.rating = '".$stat["ranged_crit_rating"]."';
		this.plusPercent = '".$rangedcrit_increase_percent."';
	}

	function spellBonusDamageObject() {
		this.holy = ".($stat["spelldmg"]+$stat["holydmg"]).";
		this.arcane = ".($stat["spelldmg"]+$stat["arcanedmg"]).";
		this.fire = ".($stat["spelldmg"]+$stat["firedmg"]).";
		this.nature = ".($stat["spelldmg"]+$stat["naturedmg"]).";
		this.frost = ".($stat["spelldmg"]+$stat["frostdmg"]).";
		this.shadow = ".($stat["spelldmg"]+$stat["shadowdmg"]).";
		this.petBonusAttack = -1;
		this.petBonusDamage = -1;
		this.petBonusFromType = '';
		
		this.value = this.holy;
		if (this.value > this.arcane)
			this.value = this.arcane;
		if (this.value > this.fire)
			this.value = this.fire;
		if (this.value > this.nature)
			this.value = this.nature;
		if (this.value > this.frost)
			this.value = this.frost;
		if (this.value > this.shadow)
			this.value = this.shadow;
	}

	function spellBonusHealingObject() {
		this.value = ".$stat["healing"].";
	}

	function spellHitRatingObject() {
		this.value = '".$stat["spell_hit_rating"]."';
		this.increasedHitPercent = '".$spellhit_increase_percent."';
	}

	function spellCritChanceObject() {
		this.rating = '".$stat["spell_crit_rating"]."';
		this.holy = '".$stat["spell_crit_percent"]."';
		this.arcane = '".$stat["spell_crit_percent"]."';
		this.fire = '".$stat["spell_crit_percent"]."';
		this.nature = '".$stat["spell_crit_percent"]."';
		this.frost = '".$stat["spell_crit_percent"]."';
		this.shadow = '".$stat["spell_crit_percent"]."';

		this.percent = this.holy;
		if (this.percent > this.arcane)
			this.percent = this.arcane;
		if (this.percent > this.fire)
			this.percent = this.fire;
		if (this.percent > this.nature)
			this.percent = this.nature;
		if (this.percent > this.frost)
			this.percent = this.frost;
		if (this.percent > this.shadow)
			this.percent = this.shadow;

	}

	function spellPenetrationObject() {
		this.value = 0;
	}

	function spellManaRegenObject() {
		this.casting = 0.00;
		this.notCasting = 0.00;
	}

	function defensesArmorObject() {
		this.base = ".$stat["armor_base"].";
		this.effective = ".$stat["armor".$eff].";
		this.percent = 0.00;
		this.petBonus = 0;
		
		this.diff = this.effective - this.base;
	}

	function defensesDefenseObject() {
		this.rating = '".$stat["defense_rating"]."';
		this.plusDefense = 0;
		this.increasePercent = 0.00;
		this.decreasePercent = 0.00;
		this.value = 0 + this.plusDefense;
	}

	function defensesDodgeObject() {
		this.percent = '".$stat["dodge_percent"]."';
		this.rating = '".$stat["dodge_rating"]."';
		this.increasePercent = '".$dodge_increase_percent."';
	}

	function defensesParryObject() {
		this.percent = '".$stat["parry_percent"]."';
		this.rating = '".$stat["parry_rating"]."';
		this.increasePercent = '".$parry_increase_percent."';
	}

	function defensesBlockObject() {
		this.percent = '".$stat["block_percent"]."';
		this.rating = '".$stat["block_rating"]."';
		this.increasePercent = '".$block_increase_percent."';
	}

	function defensesResilienceObject() {
		this.value = '".$stat["resilience_rating"]."';
		this.hitPercent = 0.00;	
		this.damagePercent = 0.00;
	}
";
?>
	var theCharacter = new characterObject();
	<!-- var theCharUrl = "r=Doomhammer&n=Super"; -->
</script><script src="js/en_us/character-sheet.js" type="text/javascript"></script>
<div class="profile-master" style="height: 500px;">
<div class="stack1">
<img class="ieimg" height="1" src="images/pixel.gif" width="1"><div class="items-left">
<ul>
<?php
	$player_items_order = array(0,1,2,14,4,3,18,8);
	for ($i=0; $i<=7; $i++)
	{
		echo "<li>";
		if ($itemid[$player_items_order[$i]] != "-1")
			echo "<img id='slot".$player_items_order[$i]."x' src='".$itemicon[$player_items_order[$i]]."'><a class=\"thisTip\" href='index.php?searchType=iteminfo&item=".$itemid[$player_items_order[$i]]."' id=\"slotOver".$player_items_order[$i]."x\" onMouseOut=\"hideTip();\" onmouseover=\"showTip('<span class=\'profile-tooltip-description\'>Loading...</span>'); showTooltip(".$itemid[$player_items_order[$i]].",'".$thissetdata."')\"></a>";
		echo "<div id=\"flyOver".$player_items_order[$i]."x\" onMouseOut=\"javascript: mouseOutArrow('".$player_items_order[$i]."');\" onMouseOver=\"javascript: mouseOverUpgradeBox('".$player_items_order[$i]."');\" style=\"visibility: hidden;\">
		</div>
		</li>";
	}
?>
</ul>
</div>
<div class="buffs">
<ul>
<?php
	require_once "configuration/tooltipmgr.inc.php";
	switchConnection(REALM_KEY, "character");
	$CharacterAuraQuery = mysql_query("SELECT `spell` FROM `character_aura` WHERE `guid`='".$stat["guid"]."' AND `effect_index`='0'") or die(mysql_error());
	$aura_i=0;
	while ($CharacterAura = mysql_fetch_assoc($CharacterAuraQuery))
	{
		$aura_i=$aura_i+1;
		switchConnection("WEBSITE");
		$SpellQuery = mysql_query("SELECT * FROM `spell` WHERE `id`='".$CharacterAura["spell"]."'") or die(mysql_error());
		$Spell = mysql_fetch_assoc($SpellQuery);
?>
<script type="text/javascript">
	buffArray[<?php echo $aura_i ?>] = "<span class='tooltipContentSpecial tooltipTitle'><?php echo addslashes($Spell["name"]) ?></span>\
	<?php echo spell_parsedata($Spell,1) ?>";
</script>
<li>
<img class="ci" height="21" onMouseOut="hideTip()" onMouseOver="showTip(buffArray[<?php echo $aura_i ?>]);" src="<?php echo GetIcon("spell",$Spell["ref_icon"]) ?>" width="21"></li>
<?php
	}
?>
</ul>
</div>
<div class="debuffs">
<ul></ul>
</div>
<div class="items-right">
<ul>
<?php
	$player_items_order = array(9,5,6,7,10,11,12,13);
	for ($i=0; $i<=7; $i++)
	{
		echo "<li>";
		if ($itemid[$player_items_order[$i]] != "-1")
			echo "<img id='slot".$player_items_order[$i]."x' src='".$itemicon[$player_items_order[$i]]."'><a class=\"thisTip\" href='index.php?searchType=iteminfo&item=".$itemid[$player_items_order[$i]]."' id=\"slotOver".$player_items_order[$i]."x\" onMouseOut=\"hideTip();\" onmouseover=\"showTip('<span class=\'profile-tooltip-description\'>Loading...</span>'); showTooltip(".$itemid[$player_items_order[$i]].",'".$thissetdata."')\"></a>";
		echo "<div id=\"flyOver".$player_items_order[$i]."x\" onMouseOut=\"javascript: mouseOutArrow('".$player_items_order[$i]."');\" onMouseOver=\"javascript: mouseOverUpgradeBox('".$player_items_order[$i]."');\" style=\"visibility: hidden;\">
		</div>
		</li>";
	}
?>
</ul>
</div>
<div class="spec">
<img class="ieimg" height="1" src="images/pixel.gif" width="1"><em class="ptl"></em><em class="ptr"></em><em class="pbl"></em><em class="pbr"></em>
<h4>Talent Specialization:</h4>
<div class="spec-wrapper">
<div style="position:absolute; left:15px;">
<img id="talentSpecImage"></div>
<h4>
<!--<a href="character-talents.php?character=<?php echo $stat['name']; ?>">-->
<div id="replaceTalentSpecText"></div>
</a>
</h4>
<span>
<?php
	for($i=0; $i<3; $i++)
	{
		if($i)
			echo " / ";
		echo talentCounting($stat['guid'], getTabOrBuild($stat['class'], "tab", $i));
	}
?>
</span>
</div>
<span style="display:none;">start</span><script type="text/javascript">
	var talentsTreeArray = new Array;
<?php
	for($i=0; $i<3; $i++)
		echo "talentsTreeArray[".$i."] = [".($i+1).", ".talentCounting($stat['guid'], getTabOrBuild($stat['class'], "tab", $i)).", \"".getTabOrBuild($stat['class'], "build", $i)."\"];\n";
?>
</script>
</div>
<div class="resists">
<em class="ptl"></em><em class="ptr"></em><em class="pbl"></em><em class="pbr"></em>
<h4>Resistances:</h4>
<ul>
<li class="arcane" onMouseOut="hideTip();" onMouseOver="showTip(theText.resistances.arcane.tooltip);">
<?php
	echo "<b>".$stat["arcane_res"]."</b><span id='spanResistArcane'>".$stat["arcane_res"]."</span>";
?>
<h4>
<a>Arcane</a>
</h4>
</li>
<li class="fire" onMouseOut="hideTip();" onMouseOver="showTip(theText.resistances.fire.tooltip);">
<?php
	echo "<b>".$stat["fire_res"]."</b><span id='spanResistFire'>".$stat["fire_res"]."</span>";
?>
<h4>
<a>Fire</a>
</h4>
</li>
<li class="nature" onMouseOut="hideTip();" onMouseOver="showTip(theText.resistances.nature.tooltip);">
<?php
	echo "<b>".$stat["nature_res"]."</b><span id='spanResistNature'>".$stat["nature_res"]."</span>";
?>
<h4>
<a>Nature</a>
</h4>
</li>
<li class="frost" onMouseOut="hideTip();" onMouseOver="showTip(theText.resistances.frost.tooltip);">
<?php
	echo "<b>".$stat["frost_res"]."</b><span id='spanResistFrost'>".$stat["frost_res"]."</span>";
?>
<h4>
<a>Frost</a>
</h4>
</li>
<li class="shadow" onMouseOut="hideTip();" onMouseOver="showTip(theText.resistances.shadow.tooltip);">
<?php
	echo "<b>".$stat["shadow_res"]."</b><span id='spanResistShadow'>".$stat["shadow_res"]."</span>";
?>
<h4>
<a>Shadow</a>
</h4>
</li>
</ul>
</div>
<?php
//Professions and Skills
	$primary_prof_array = array();
	$secondary_prof_array = array();
	$skill_array = array();
	$statistic_data = explode(' ',$data["data"]);
	for($i = SKILL_DATA; $i <= SKILL_DATA+384 ; $i += 3)
	{
		if(($statistic_data[$i]) && (GetNameFromDB($statistic_data[$i] & 0x0000FFFF)))
		{
			$temp = unpack("S", pack("L", $statistic_data[$i+1]));
			$skill = ($statistic_data[$i] & 0x0000FFFF);
			if($skill == 185 || $skill == 129 || $skill == 356 || $skill == 762)
				array_push($secondary_prof_array, array(($stat["level"]?$skill:''), GetNameFromDB($skill), $temp[1]));
			else if($skill == 171 || $skill == 182 || $skill == 186 || $skill == 197 || $skill == 202 || $skill == 333 ||
					 $skill == 393 || $skill == 755 || $skill == 164 || $skill == 165 || $skill == 773)
				array_push($primary_prof_array, array(($stat["level"]?$skill:''), GetNameFromDB($skill), $temp[1]));
			else
				array_push($skill_array, array(($stat["level"]?$skill:''), GetNameFromDB($skill), $temp[1]));
		}
	}
	unset($statistic_data);
	asort($skill_array);
	asort($primary_prof_array);
	asort($secondary_prof_array);
?>
<div class="profs">
<em class="ptl"></em><em class="ptr"></em><em class="pbl"></em><em class="pbr"></em>
<h4>Primary Professions:</h4>
<?php
	$num_primary_prof = count($primary_prof_array);
	if($num_primary_prof > 2)
	{ 
		for($i=2;$i<$num_primary_prof;$i++)
			unset($primary_prof_array[$i]);
	}
	foreach ($primary_prof_array as $data)
	{
		$max = ($data[2] < 76?75:($data[2] < 151?150:($data[2] < 226?225:($data[2] < 301?300:($data[2] < 351?350:($data[2] < 376?375:($data[2] < 451?450:460)))))));
		echo "<div class='prof1'>
		<div class='profImage'>
		<img src='images/icons/professions/".GetNameFromDB($data[0]).".gif'></div>
		<h4>".GetNameFromDB($data[0])."</h4>
		<div class='bar-container'>
		<img class='ieimg' height='1' src='images/pixel.gif' width='1'><b style=' width: ".(100*$data[2]/$max)."%'></b><span>".$data[2]."/".$max."</span>
		</div>
		</div>";
	}
	if($num_primary_prof < 2)
	{
		if($num_primary_prof == 1)
			$repeat=1;
		else 
			$repeat=2;
		for($i=0;$i<$repeat;$i++)
		{
			echo "<div class='prof1'>
			<div class='profImage'>
			<img src='images/icons/professions/None.gif'></div>
			<h4>None</h4>
			<div class='bar-container'>
			<img class='ieimg' height='1' src='images/pixel.gif' width='1'><b style=' width: 0%'></b><span>0 / 0</span>
			</div>
			</div>";
		}
	}
?>
</div>
</div>
<div class="stack2">
<em class="ptl"></em><em class="ptr"></em><em class="pbl"></em><em class="pbr"></em>
<div class="health-stat">
<h4>Health:</h4>
<p>
<?php
	echo "<span>".$stat["hp"]."</span>";
?>
</p>
</div>
<?php
	if($stat["class"] == 1)
	{
		$barType = "rage";
		$mypower = $stat["rage"];
		$bartext = "Rage";
	}
	else if($stat["class"] == 4)
	{
		$barType = "energy";
		$mypower = $stat["energy"];
		$bartext = "Energy";
	}
	else if($stat["class"] == 6)
	{
		$barType = "runic";
		$mypower = $stat["energy"];
		$bartext = "Runic";
	}
	else
	{
		$barType = "mana";
		$mypower = $stat["hero_mana"];
		$bartext = "Mana";
	}
	echo "<div class='".$barType."-stat'>";
	echo "<h4>".$bartext.":</h4>";
?>
<p>
<?php
	echo "<span>".$mypower."</span>";
?>
</p>
</div>
</div>
<div class="stack3">
<script type="text/javascript">
	var varOverLeft = 0;
</script>
<div class="dropdown1" onMouseOut="javascript: varOverLeft = 0;" onMouseOver="javascript: varOverLeft = 1;">
<a class="profile-stats" href="javascript: document.formDropdownLeft.dummyLeft.focus();" id="displayLeft">Base Stats</a>
</div>
<div style="position: relative;">
<div style="position: absolute;">
<form id="formDropdownLeft" name="formDropdownLeft" style="height: 0px;">
<input id="dummyLeft" onBlur="javascript: if(!varOverLeft) document.getElementById('dropdownHiddenLeft').style.display='none';" onFocus="javascript: dropdownMenuToggle('dropdownHiddenLeft');" size="2" style="position: relative; left: -5000px;" type="button">
</form>
</div>
</div>
<div class="drop-stats" id="dropdownHiddenLeft" onMouseOut="javascript: varOverLeft = 0;" onMouseOver="javascript: varOverLeft = 1;" style="display: none; z-index: 99999;">
<div class="tooltip">
<table>
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"></td><td class="bg">
<ul>
<li>
<a href="#" onClick="changeStats('Left', replaceStringBaseStats, 'BaseStats', baseStatsDisplay); return false;">Base Stats<img class="checkmark" id="checkLeftBaseStats" src="images/icon-check.gif" style="visibility: visible;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Left', replaceStringMelee, 'Melee', meleeDisplay); return false;">Melee<img class="checkmark" id="checkLeftMelee" src="images/icon-check.gif" style="visibility: hidden;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Left', replaceStringRanged, 'Ranged', rangedDisplay); return false;">Ranged<img class="checkmark" id="checkLeftRanged" src="images/icon-check.gif" style="visibility: hidden;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Left', replaceStringSpell, 'Spell', spellDisplay); return false;">Spell<img class="checkmark" id="checkLeftSpell" src="images/icon-check.gif" style="visibility: hidden;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Left', replaceStringDefenses, 'Defenses', defensesDisplay); return false;">Defense<img class="checkmark" id="checkLeftDefenses" src="images/icon-check.gif" style="visibility: hidden;"></a>
</li>
</ul>
</td><td class="r"></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
</div>
</div>
<script type="text/javascript">
	var varOverRight = 0;
</script>
<div class="dropdown2" onMouseOut="javascript: varOverRight = 0;" onMouseOver="javascript: varOverRight = 1;">
<a class="profile-stats" href="javascript: document.formDropdownRight.dummyRight.focus();" id="displayRight">Base Stats</a>
</div>
<div style="position: relative;">
<div style="position: absolute;">
<form id="formDropdownRight" name="formDropdownRight" style="height: 0px;">
<input id="dummyRight" onBlur="javascript: if(!varOverRight) document.getElementById('dropdownHiddenRight').style.display='none';" onFocus="javascript: dropdownMenuToggle('dropdownHiddenRight');" size="2" style="position: relative; left: -5000px;" type="button">
</form>
</div>
</div>
<div class="drop-stats" id="dropdownHiddenRight" onMouseOut="javascript: varOverRight = 0;" onMouseOver="javascript: varOverRight = 1;" style="display: none; z-index: 9999999; left: 190px;">
<div class="tooltip">
<table>
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"></td><td class="bg">
<ul>
<li>
<a href="#" onClick="changeStats('Right', replaceStringBaseStats, 'BaseStats', baseStatsDisplay); return false;">Base Stats<img class="checkmark" id="checkRightBaseStats" src="images/icon-check.gif" style="visibility: hidden;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Right', replaceStringMelee, 'Melee', meleeDisplay); return false;">Melee<img class="checkmark" id="checkRightMelee" src="images/icon-check.gif" style="visibility: hidden;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Right', replaceStringRanged, 'Ranged', rangedDisplay); return false;">Ranged<img class="checkmark" id="checkRightRanged" src="images/icon-check.gif" style="visibility: hidden;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Right', replaceStringSpell, 'Spell', spellDisplay); return false;">Spell<img class="checkmark" id="checkRightSpell" src="images/icon-check.gif" style="visibility: hidden;"></a>
</li>
<li>
<a href="#" onClick="changeStats('Right', replaceStringDefenses, 'Defenses', defensesDisplay); return false;">Defense<img class="checkmark" id="checkRightDefenses" src="images/icon-check.gif" style="visibility: hidden;"></a>
</li>
</ul>
</td><td class="r"></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
</div>
</div>
<div class="stats1">
<em class="ptl"></em><em class="ptr"></em><em class="pbl"></em><em class="pbr"></em>
<div class="character-stats">
<div id="replaceStatsLeft"></div>
</div>
</div>
<div class="stats2">
<em class="ptl"></em><em class="ptr"></em><em class="pbl"></em><em class="pbr"></em>
<div class="character-stats">
<div id="replaceStatsRight"></div>
<script src="js/character/textObjects.js" type="text/javascript"></script>
</div>
</div>
</div>
<div class="stack4">
<div class="items-bot">
<ul>
<?php
	$player_items_order = array(15,16,17);
	for ($i=0; $i<=2; $i++)
	{
		echo "<li>";
		if ($itemid[$player_items_order[$i]] != "-1")
			echo "<img id='slot".$player_items_order[$i]."x' src='".$itemicon[$player_items_order[$i]]."'><a class=\"thisTip\" href='index.php?searchType=iteminfo&item=".$itemid[$player_items_order[$i]]."' id=\"slotOver".$player_items_order[$i]."x\" onMouseOut=\"hideTip();\" onmouseover=\"showTip('<span class=\'profile-tooltip-description\'>Loading...</span>'); showTooltip(".$itemid[$player_items_order[$i]].",'".$thissetdata."')\"></a>";
		echo "<div id=\"flyOver".$player_items_order[$i]."x\" onMouseOut=\"javascript: mouseOutArrow('".$player_items_order[$i]."');\" onMouseOver=\"javascript: mouseOverUpgradeBox('".$player_items_order[$i]."');\" style=\"visibility: hidden;\">
		</div>
		</li>";
	}
?>
</ul>
</div>
<script type="text/javascript">
	var items = new itemsObject();
</script>
</div>
</div>
<div class="bonus-stats" style="">
<table class="deco-frame">
<thead>
<tr>
<td class="sl"></td><td class="ct st"></td><td class="sr"></td>
</tr>
</thead>
<tbody>
<tr>
<td class="sl"><b><em class="port"></em></b></td><td class="ct">
<table>
<tr>
<td class="s-top-left"></td><td class="s-top"></td><td class="s-top-right"></td>
</tr>
<tr>
<td class="s-left">
<div class="shim stable"></div>
</td><td class="s-bg">
<div class="bonus-stats-content">
<div>
<em class="b-title"></em>
<div class="achievements external">
<h2>PvP</h2>
<h3>Lifetime Honorable Kills:
<?php
	echo "<strong>".$stat["kills"]."</strong>";
?>
<br>Honor Points:
<?php
	echo "<strong>".$stat["honor"]."</strong>";
?>
<br>Arena Points:
<?php
	echo "<strong>".$stat["arenapoints"]."</strong>";
?>
</h3>
<div style="clear:both;"></div>
</div>
</div>
</div>
</td><td class="s-right">
<div class="shim stable"></div>
</td>
</tr>
<tr>
<td class="s-bot-left"></td><td class="s-bot"></td><td class="s-bot-right"></td>
</tr>
</table>
</td><td class="sr"><b><em class="star"></em></b></td>
</tr>
</tbody>
<tfoot>
<tr>
<td class="sl"></td><td align="center" class="ct sb"><b><em class="foot"></em></b></td><td class="sr"></td>
</tr>
</tfoot>
</table>
</div>
</div>
</div>
</div>
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
</div>
</div>
<div class="rinfo">
</div>
<?php
}
?>
<?php
require "settings.inc.php";
if ($config['Client'] == 0)
{
	// for client 2.4.3
	define('HP', 28);
	define('MANA', 29);
	define('RAGE', 30);
	define('ENERGY', 32);
	define('LEVEL',34);
	define('GENDER',36);
	define('MEELE_MAIN_HAND_ATTACK_TIME', 147);
	define('MEELE_OFF_HAND_ATTACK_TIME', 148);
	define('RANGED_ATTACK_TIME', 149);
	define('MEELE_MAIN_HAND_MIN_DAMAGE', 155);
	define('MEELE_MAIN_HAND_MAX_DAMAGE', 156);
	define('MEELE_OFF_HAND_MIN_DAMAGE', 157);
	define('MEELE_OFF_HAND_MAX_DAMAGE', 158);
	define('STRENGTH', 171);
	define('AGILITY', 172);
	define('STAMINA', 173);
	define('INTELLECT', 174);
	define('SPIRIT', 175);
	define('ARMOR', 186);
	define('HOLY_RES', 187);
	define('FIRE_RES', 188);
	define('NATURE_RES', 189);
	define('FROST_RES', 190);
	define('SHADOW_RES', 191);
	define('ARCANE_RES', 192);
	define('MELEE_AP_BASE', 210);
	define('MELEE_AP_BONUS', 211);
	define('RANGED_AP_BASE', 213);
	define('RANGED_AP_BONUS', 214);
	define('RANGED_MIN_DAMAGE', 216);
	define('RANGED_MAX_DAMAGE', 217);
	define('GUILD', 237);
	define('GUILD_RANK', 238);
	define('SKILL_DATA', 928);
	define('BLOCK_PERCENTAGE', 1316);
	define('DODGE_PERCENTAGE', 1317);
	define('PARRY_PERCENTAGE', 1318);
	define('CRIT_PERCENTAGE', 1321);
	define('RANGED_CRIT_PERCENTAGE', 1322);
	define('SPELL_CRIT_PERCENTAGE', 1323);
	define('KILLS', 1517);
	define('DEFENSE_RATING', 1521);
	define('DODGE_RATING', 1522);
	define('PARRY_RATING', 1523);
	define('BLOCK_RATING', 1524);
	define('MELEE_HIT_RATING', 1525);
	define('RANGED_HIT_RATING', 1526);
	define('SPELL_HIT_RATING', 1527);
	define('MELEE_CRIT_RATING', 1528);
	define('RANGED_CRIT_RATING', 1529);
	define('SPELL_CRIT_RATING', 1530);
	define('RESILIENCE_RATING', 1534);
	define('HONOR', 1562);
	define('ARENAPOINTS', 1563);
}
else
{
	// for client 3.0.3
	define('HP', 31);
	define('MANA', 32);
	define('RAGE', 33);
	define('ENERGY', 35); // Runic for DK
	define('LEVEL', 53);
	define('GENDER', 22);
	define('MEELE_MAIN_HAND_ATTACK_TIME', 61);
	define('MEELE_OFF_HAND_ATTACK_TIME', 62);
	define('RANGED_ATTACK_TIME', 63);
	define('MEELE_MAIN_HAND_MIN_DAMAGE', 69);
	define('MEELE_MAIN_HAND_MAX_DAMAGE', 70);
	define('MEELE_OFF_HAND_MIN_DAMAGE', 71);
	define('MEELE_OFF_HAND_MAX_DAMAGE', 72);
	define('STRENGTH', 84);
	define('AGILITY', 85);
	define('STAMINA', 86);
	define('INTELLECT', 87);
	define('SPIRIT', 88);
	define('ARMOR', 99);
	define('HOLY_RES', 100);
	define('FIRE_RES', 101);
	define('NATURE_RES', 102);
	define('FROST_RES', 103);
	define('SHADOW_RES', 104);
	define('ARCANE_RES', 105);
	define('MELEE_AP_BASE', 123);
	define('MELEE_AP_BONUS', 124);
	define('RANGED_AP_BASE', 126);
	define('RANGED_AP_BONUS', 127);
	define('RANGED_MIN_DAMAGE', 129);
	define('RANGED_MAX_DAMAGE', 130);
	define('GUILD', 151);
	define('GUILD_RANK', 152);
	define('SKILL_DATA', 1012);
	define('BLOCK_PERCENTAGE', 1400);
	define('DODGE_PERCENTAGE', 1401);
	define('PARRY_PERCENTAGE', 1402);
	define('CRIT_PERCENTAGE', 1405);
	define('RANGED_CRIT_PERCENTAGE', 1406);
	define('SPELL_CRIT_PERCENTAGE', 1408);
	define('KILLS', 1602);
	define('DEFENSE_RATING', 1606);
	define('DODGE_RATING', 1607);
	define('PARRY_RATING', 1608);
	define('BLOCK_RATING', 1609);
	define('MELEE_HIT_RATING', 1610);
	define('RANGED_HIT_RATING', 1611);
	define('SPELL_HIT_RATING', 1612);
	define('MELEE_CRIT_RATING', 1613);
	define('RANGED_CRIT_RATING', 1614);
	define('SPELL_CRIT_RATING', 1615);
	define('RESILIENCE_RATING', 1616);
	define('HONOR', 1648);
	define('ARENAPOINTS', 1649);
}
?>
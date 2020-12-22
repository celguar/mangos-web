<?php
$AllowableClass = array(
array(1,"Warrior"),
array(2,"Paladin"),
array(4,"Hunter"),
array(8,"Rogue"),
array(16,"Priest"),
array(32,"Death Knight"),
array(64,"Shaman"),
array(128,"Mage"),
array(256,"Warlock"),
array(1024,"Druid")
);
$AllowableRace = array(
array(1,"Human"),
array(2,"Orc"),
array(4,"Dwarf"),
array(8,"Night Elf"),
array(16,"Undead"),
array(32,"Tauren"),
array(64,"Gnome"),
array(128,"Troll"),
array(512,"Blood Elf"),
array(1024,"Draenei")
);
$ItemFlags = array(
array(1,""), // Soulbond
array(2,"Conjured"),
array(4,""), // Right Click To Open
array(8,""), // Wrapped
array(32,"Unique"), // Totem
array(64,""), // Right Click To Use
array(256,""), // Wrapper
array(512,""), // Ribboned Wrapping Paper
array(1024,""), // Gifts
array(2048,""), // Quests Item
array(8192,"Unique"), // Charter
array(32768,"Unique"), // PvP Reward Item
array(524288,"Unique-Equipped"),
array(2097154,"Conjured"),
array(4194304,""), // Throwable
array(8388608,"") // Special Use
);
$SkillRankName = array(
75 => "Apprentice",
150 => "Journeyman",
225 => "Expert",
300 => "Artisan",
375 => "Master",
450 => "Grand Master"
);
$BagType = array(
0 => "",
1 => "Arrow",
2 => "Bullet",
4 => "Soul",
8 => "Leatherworking",
16 => "Inscription",
32 => "Herb",
64 => "Enchanting",
128 => "Engineering",
256 => "Key",
512 => "Gem",
1024 => "Mining"
);
$ItemBaseStats = array(
"armor",
"strength",
"stamina",
"agility",
"intellect",
"spirit",
"critrating",
"hitrating",
"defenserating",
"block",
"attack",
"dodgerating",
"parryrating",
"resiliencerating",
"meleecritrating",
"meleehitrating",
"rangecritrating",
"rangehitrating",
"arcane_resist",
"fire_resist",
"frost_resist",
"nature_resist",
"shadow_resist",
"holy_resist",
"frostdmg",
"firedmg",
"naturedmg",
"shadowdmg",
"arcanedmg",
"holydmg",
"healing",
"spelldmg",
"spellhit",
"spellcrit",
"haste"
);
$RatingBases60 = array(
"crit" => 14,
"hit" => 10,
"haste" => 10,
"spell_crit" => 14,
"spell_hit" => 8,
"spell_haste" => 10,
"dodge" => 12,
"block" => 5,
"parry" => 15,
"defense" => 1.5
);
$RatingBases70 = array(
"crit" => 22.08,
"hit" => 15.77,
"haste" => 15.77,
"spell_crit" => 22.08,
"spell_hit" => 12.62,
"spell_haste" => 15.77,
"dodge" => 12,
"block" => 7.88,
"parry" => 23.65,
"defense" => 2.36
);
?>
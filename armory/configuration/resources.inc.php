<?php
$races = array(
"1" => "Human",
"2" => "Orc",
"3" => "Dwarf",
"4" => "Night Elf",
"5" => "Undead",
"6" => "Tauren",
"7" => "Gnome",
"8" => "Troll",
"10" => "Blood Elf",
"11" => "Draenei",
);
foreach($races as $key => $val)
{
define("RACE_".$val, $key);
}
$classes = array(
"1"=>"Warrior",
"2"=>"Paladin",
"3"=>"Hunter",
"4"=>"Rogue",
"6"=>"Death Knight",
"5"=>"Priest",
"7"=>"Shaman",
"8"=>"Mage",
"9"=>"Warlock",
"11"=>"Druid",
);
foreach($classes as $key => $val)
{
define(str_replace(" ", "_", "CLASS_".strtoupper($val)), $key);
define(strtoupper($val), $key);
}
define("STAT_STRENGTH", 0);
define("STAT_AGILITY", 1);
define("STAT_STAMINA", 2);
define("STAT_INTELLECT", 3);
define("STAT_SPIRIT", 4);
$equipslots = array(
0 => "Head",
1 => "Neck",
2 => "Shoulder",
3 => "Shirt",
4 => "Chest",
5 => "Belt",
6 => "Legs",
7 => "Feet",
8 => "Wrist",
9 => "Hands",
10 => "Finger",
11 => "Finger",
12 => "Trinket",
14 => "Cloak",
15 => "Main Hand",
16 => "Off Hand",
17 => "Ranged",
18 => "Tabard",
19 => "Bag 1",
20 => "Bag 2",
21 => "Bag 3",
22 => "Bag 4",
);
$inventorytype = array(
1 => "Head",
2 => "Neck",
3 => "Shoulders",
4 => "Shirt",
5 => "Chest",
6 => "Waist",
7 => "Legs",
8 => "Feet",
9 => "Wrists",
10 => "Hands",
11 => "Finger",
12 => "Trinket",
13 => "One Hand",
14 => "Off Hand", /* Shield */
15 => "Ranged",
16 => "Back",
17 => "Two Hand",
18 => "Bag",
19 => "Tabard",
20 => "Chest", /* Robe */
21 => "Main Hand",
22 => "Off Hand", /* Weapon */
23 => "Off Hand", /* Orb, etc */
24 => "Ammunition",
25 => "Thrown",
26 => "Ranged",
27 => "Test",
28 => "Relic",
);
// Stats (as in, from item table) //
$stattype = array(
0 => "mana",
1 => "health",
3 => "agility",
4 => "strength",
5 => "intellect",
6 => "spirit",
7 => "stamina",
12 => "defenserating",
13 => "dodgerating",
14 => "parryrating",
15 => "blockrating",
16 => "meleehitrating",
17 => "rangehitrating",
18 => "spellhit",
19 => "meleecritrating",
20 => "rangecritrating",
21 => "spellcrit",
30 => "spellhaste",
31 => "hit",
32 => "crit",
35 => "resiliencerating",
36 => "haste",
37 => "expertise",
38 => "attackpower",
43 => "manaregen",
45 => "spellpower"
);
// 2D Array Sorting - by nilesh at gmail dot com @ php.net //
function asort2d($records, $field, $reverse, $defaultSortField = 0)
{
	$uniqueSortId = 0;
	$hash = array(); $sortedRecords = array(); $tempArr = array(); $indexedArray = array(); $recordArray = array();
	foreach($records as $record)
	{
		$uniqueSortId++;
		$recordStr = implode("|", $record)."|".$uniqueSortId;
		$recordArray[] = explode("|", $recordStr);
	}
	$primarySortIndex = count($record);
	$records = $recordArray;
	foreach($records as $record)
		$hash[$record[$primarySortIndex]] = $record[$field];
	uasort($hash, "strnatcasecmp");
	if($reverse)
		$hash = array_reverse($hash, true);
	$valueCount = array_count_values($hash);
	foreach($hash as $primaryKey => $value)
		$indexedArray[] = $primaryKey;
	$i = 0;
	foreach($hash as $primaryKey => $value)
	{
		$i++;
		if($valueCount[$value] > 1) 
		{
			foreach($records as $record)
			{
				if($primaryKey == $record[$primarySortIndex])
				{
					$tempArr[$record[$defaultSortField]."__".$i] = $record;
					break;
				}
			}
			$index = array_search($primaryKey, $indexedArray);
			if(($i == count($records)) || ($value != $hash[$indexedArray[$index+1]]))
			{
				uksort($tempArr, "strnatcasecmp");
				if($reverse)
					$tempArr = array_reverse($tempArr);
				foreach($tempArr as $newRecs)
					$sortedRecords [] = $newRecs;
				$tempArr = array();
			}
		}
		else 
		{
			foreach($records as $record)
			{
				if($primaryKey == $record[$primarySortIndex])
				{
					$sortedRecords[] = $record;
					break;
				}
			}
		}
	}
	return $sortedRecords;
}
?>
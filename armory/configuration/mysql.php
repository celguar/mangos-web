<?php
$realms = array(
// Your realm name + connection to characters DB and realmd DB
"Realm name" => array("1", "UserName", "Password", "HostName", "characters", "realmd")/*,
"Realm name2" => array("2", "root", "root_pass", "localhost", "characters2", "realmd")*/
);
/* Default Realm if not set */
$realmName["DEFAULT_REALM"] = "Realm Name"; // your Realm name or Realm name2 chosen upper in $realms

// Connection to mangos DB
$MySQL_User["WORLD"] = "UserName";
$MySQL_Password["WORLD"] = "Password";
$MySQL_Host["WORLD"] = "HostName";
$MySQL_DB["WORLD"] = "mangos";
// Connection to armory DB  - the DB is in \trunk\sql\armory.zip
$MySQL_User["WEBSITE"] = "Username";
$MySQL_Password["WEBSITE"] = "Password";
$MySQL_Host["WEBSITE"] = "HostName";
$MySQL_DB["WEBSITE"] = "armory";

// Min number of characters used in search (this is not related to new javascript limitation to 2 chars)
$min_guild_search = 2;
$min_arenateam_search = 2;
$min_char_search = 2;
$MinItemsSearch = 2;
// Results number per page
$results_per_page_guild = 20;
$results_per_page_arenateam = 20;
$results_per_page_char = 20;
$ResultsPerPageItems = 15;

/* Don't touch anything beyond this point. */
$MySQL_User["DEFAULT_REALM"] = $realms[$realmName["DEFAULT_REALM"]][1];
$MySQL_Password["DEFAULT_REALM"] =  $realms[$realmName["DEFAULT_REALM"]][2];
$MySQL_Host["DEFAULT_REALM"] =  $realms[$realmName["DEFAULT_REALM"]][3];
$MySQL_DB["DEFAULT_REALM"] =  $realms[$realmName["DEFAULT_REALM"]][4];
$RealmDB["DEFAULT_REALM"] =  $realms[$realmName["DEFAULT_REALM"]][5];
foreach($realms as $key => $val)
{
	$realmName[$val[0]] = $key;
	$MySQL_User[$val[0]] = $val[1];
	$MySQL_Password[$val[0]] = $val[2];
	$MySQL_Host[$val[0]] = $val[3];
	$MySQL_DB[$val[0]] = $val[4];
	$RealmDB[$val[0]] = $val[5];
}
function switchDatabase($realm, $db_type = 'character')
{
	global $MySQL_DB, $RealmDB, $CurrentDB;
	if($db_type == 'character')
	{
		if($CurrentDB != sha1($MySQL_DB[$realm]))
		{
			mysql_select_db($MySQL_DB[$realm]) or die("Unable to connect to Character SQL database: ".mysql_error());
			$CurrentDB = sha1($MySQL_DB[$realm]);
		}
	}
	else if($db_type == 'WORLD')
	{
		if($CurrentDB != sha1($MySQL_DB["WORLD"]))
		{
			mysql_select_db($MySQL_DB["WORLD"]) or die("Unable to connect to World SQL database: ".mysql_error());
			$CurrentDB = sha1($MySQL_DB["WORLD"]);
		}
	}
	else
	{
		mysql_select_db($RealmDB[$realm]) or die("Unable to connect to Realm SQL database: ".mysql_error());
		$CurrentDB = sha1($RealmDB[$realm]);
	}
	mysql_query("SET CHARSET utf8") or die(mysql_error());
}
function switchConnection($key, $db_type = 'character')
{
	global $MySQL_User, $MySQL_Password, $MySQL_Host, $MySQL_DB, $RealmDB, $CurrentConnection, $CurrentDB, $querystack;
	if($CurrentConnection != sha1($MySQL_Host[$key]))
	{
		mysql_connect($MySQL_Host[$key], $MySQL_User[$key], $MySQL_Password[$key]) or die("Unable to connect to SQL host: ".mysql_error());
		$CurrentConnection = sha1($MySQL_Host[$key]);
		$querystack[] = array("query" => "Connected to ".$key.".", "time" => 0, "line" => 0, "function" => "switchConnection");
	}
	if($db_type == 'character')
	{
		if($CurrentDB != sha1($MySQL_DB[$key]))
		{
			mysql_select_db($MySQL_DB[$key]) or die("Unable to connect to Character SQL database: ".mysql_error());
			$CurrentDB = sha1($MySQL_DB[$key]);
		}
	}
	else if($db_type == 'world')
	{
		if($CurrentDB != sha1($MySQL_DB["WORLD"]))
		{
			mysql_select_db($MySQL_DB["WORLD"]) or die("Unable to connect to World SQL database: ".mysql_error());
			$CurrentDB = sha1($MySQL_DB["WORLD"]);
		}
	}
	else
	{
		mysql_select_db($RealmDB[$key]) or die("Unable to connect to Realm SQL database: ".mysql_error());
		$CurrentDB = sha1($RealmDB[$key]);
	}
	mysql_query("SET CHARSET utf8") or die(mysql_error());
}
function getConnection()
{
	global $CurrentConnection;
	return $CurrentConnection;
}
function getDatabase()
{
	global $CurrentDB;
	return $CurrentDB;
}
switchConnection("WEBSITE");
switchDatabase("WEBSITE");
?>
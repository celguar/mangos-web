<?php
define('Armory', 1);
require "configuration/settings.inc.php";
require "configuration/functions.php";
require "configuration/mysql.php";
require "configuration/output.inc.php";
require "configuration/infoarray.php";
require "configuration/resources.inc.php";
require "configuration/defines.php";
$o = new Output;
$o->init();
// Security Check //
$PagesArray = array( 
'idx' => 'main.php',
'profile' => 'character-sheet.php',
'characters' => 'charlist.php',
'guilds' => 'guildlist.php',
'guildinfo' => 'guild-info.php',
'honor' => 'honorranking.php',
'Items' => 'itemlist.php',
'items' => 'itemlist.php',
'iteminfo' => 'item-info.php',
'arena' => 'arenaranking.php',
'arenateams' => 'arenalist.php',
'teaminfo' => 'team-info.php',
'registration' => 'registration.php',
'login' => 'login.php'
);
if(isset($_GET["searchType"]))
{
	if (array_key_exists($_GET["searchType"], $PagesArray))
		define("REQUESTED_ACTION", $_GET["searchType"]);
	else
		define("REQUESTED_ACTION", 'idx');
}
else
	define("REQUESTED_ACTION", 'idx');
error_reporting(E_ALL);
session_start();
function session_security($fingerprint = 'fingerprint001')
{
	if(isset($_SESSION["HTTP_USER_AGENT"]))
	{
		if($_SESSION["HTTP_USER_AGENT"] != md5($_SERVER["HTTP_USER_AGENT"].$fingerprint))
		{
			print "Session Terminated. This has been recorded as a possible session hijack attempt and the session has been terminated for security reasons. If this is an inconvenience, please contact the administrator.<br><b>What this means:</b> You have been logged out.";
			session_destroy();
		}
	}
	else
		$_SESSION["HTTP_USER_AGENT"] = md5($_SERVER["HTTP_USER_AGENT"].$fingerprint);
}
$o->string("<head>");
$o->string("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/armory-css.css\">");
// Tooltips stylesheet(s)//
$o->string("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/armory-tooltips.css\">");
// Ajax //
$o->string("<script src=\"source/ajax/coreajax.js\" type=\"text/javascript\">  </script>");
$o->string("</head>");
$o->string("<body OB_AFTER_BODYTAG>");
$o->setobvar("AFTER_BODYTAG", "");
// Javascript Tooltips //
// aah //
$o->string("<script type=\"text/javascript\" src=\"source/ajax/tooltipajax.js\"></script>");

include "head.php";

// Make sure the session is secure... //
session_security();
require_once $o->sourcefolder."/".$PagesArray[REQUESTED_ACTION];
$o->string("<div id=\"loading-box\">LOADING</div>");

// The final output call. Any $o-> calls after this will be ignored //
$o->outputPage();

include "foot.php";
?>
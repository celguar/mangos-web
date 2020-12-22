<?php
require "../../configuration/mysql.php";
require "../../configuration/tooltipmgr.inc.php";
require "../../configuration/resources.inc.php";
if(isset($_GET["item"]))
{
	switchConnection("WEBSITE");
	$itemid = (int) $_GET["item"];
	$query = mysql_query("SELECT * FROM `cache_item` WHERE `item_id` = '".$itemid."'");
	if(mysql_num_rows($query) > 0)
	{
		$result = mysql_fetch_assoc($query);
		print $result["item_html"];
	}
	else
	{
		if(!isset($_GET["setdata"]))
			$setdata = '';
		else
		{
			$setdatatext = addslashes($_GET["setdata"]);
			$setdatatext = substr($setdatatext, 0, -1);
			$setdata = explode(",", $setdatatext); // Chop the last character off the setdata string 
		}
		$tipText = outputTooltip($_GET["item"], $setdata);
		print $tipText;
	}
}
else
	print "<span class=\"profile-tooltip-description\">Error: Get lost</span>\n";
?>
<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

//PHP Definitions
error_reporting(E_ALL ^ E_NOTICE);

//Web Definitions
$query=mysql_query("SELECT * FROM `web_settings`", $MySQL_CON) or die(mysql_error());
while ($row=mysql_fetch_array($query)) {
	$SETTING[strtoupper($row['setting'])]=$row['value'];
}

?>
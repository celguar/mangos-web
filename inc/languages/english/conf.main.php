<?php
/*
English - v1.0
*/

//General
$_LANG['LANG']['YES']='Yes';
$_LANG['LANG']['NO']='No';
$_LANG['LANG']['CHARSET']='charset=ISO-8859-1';

//Error
$_LANG['ERROR']['DEFAULT']="Error Not Specified.";
$_LANG['ERROR']['ACCESS']="You don't have the required user level to access this part of the site.";
$_LANG['ERROR']['CONST']="This page is under construction.";
$_LANG['ERROR']['DISABLED']="This page was disabled by an Administrator.";
$_LANG['ERROR']['DENY_INSTALL']="The install file cannot be accessed by this computer (".$_SERVER['REMOTE_ADDR'].").";
$_LANG['ERROR']['CANT_INSTALL']="Delete the file <i>inc/conf/conf.database.php</i>, in order to proceed.";
$_LANG['ERROR']['NEED_LOGIN']="You need to be Logged in order to access that page.<META HTTP-EQUIV=REFRESH CONTENT='2; URL=?n=account.login'>";
$_LANG['ERROR']['BAD_LOGIN']="Incorrect Account Name or/and Password!";
$_LANG['ERROR']['REALM_OFFLINE']="The selected Realm is currently Off-Line!";
$_LANG['ERROR']['REALM_NO_ON_CHARS']="The realm do NOT contains any On-Line Characters!";
$_LANG['ERROR']['REALM_NOT_EXIST']="The realm do NOT exists.";
$_LANG['ERROR']['ACCOUNT_BANNED']="You're BANNED from this server!<br>For more information contact an Administrator.";

//Success
$_LANG['SUCCESS']['DEFAULT']="The changes were applied successfully.";
$_LANG['SUCCESS']['ACCOUNT_CREATED']="The Account was successfully Created.<META HTTP-EQUIV=REFRESH CONTENT='3; URL=index.php'>";
$_LANG['SUCCESS']['ACCOUNT_CREATED_MAIL']="The Account was successfully Created.<br>An E-mail will be sent to you (might take up to 10mins), so you can activate your account.<META HTTP-EQUIV=REFRESH CONTENT='5; URL=index.php'>";
$_LANG['SUCCESS']['INSTALLED']="Website Successfuly Installed!<META HTTP-EQUIV=REFRESH CONTENT='2; URL=index.php'>";
$_LANG['SUCCESS']['ACCOUNT_UPDATED']="The Account Informations were successfully Updated.<META HTTP-EQUIV=REFRESH CONTENT='2; URL=index.php?n=account.manage'>";
$_LANG['SUCCESS']['ADMIN_SET']="The changes were applied successfully.<META HTTP-EQUIV=REFRESH CONTENT='2; URL=index.php?n=admin'>";

?>

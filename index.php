<?php

session_start();

$startTime = array_sum(explode(" ",microtime()));

define('INCLUDED', true);

$DEFAULT_LANG='english';
$SHOW_LINKS=false;
$FULL_LAYOUT=true;
$BROWSER_LANG=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

if ($_REQUEST['n']=="language" AND $_REQUEST['set']!='') { //Select Language
	setcookie("SITE_LANG", $_REQUEST['set'], time()+(3600*24*365));
	echo '<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
}

if ($_COOKIE['ALOG_ID']!='' AND $_SESSION['userid']=='') { //Auto-Login
	$_SESSION['userid'] = $_COOKIE['ALOG_ID'];
	$_SESSION['username'] = $_COOKIE['ALOG_USER'];
	$_SESSION['password'] = SHA1(strtoupper($_COOKIE['ALOG_USER'].':'.$_COOKIE['ALOG_PASS']));
}

foreach(glob('inc/languages/*', GLOB_ONLYDIR) as $filename) { //Check All the Languages
	if (file_exists($filename.'/conf.settings.php')) {
		@include($filename.'/conf.settings.php');
		$langfile = explode('/', $filename);
		if ($_LANG['LANG']['SHORT_TAG'] != "" AND $_LANG['LANG']['LARGE_TAG'] != "") {
			$_LANG['LANG']['SHORT_TAG_LIST'][]=$_LANG['LANG']['SHORT_TAG'];
			$_LANG['LANG']['LARGE_TAG_LIST'][]=$_LANG['LANG']['LARGE_TAG'];
			$_LANG['LANG']['FOLDER'][]=$langfile[(count($langfile)-1)];
			if ($_COOKIE['SITE_LANG']=='' AND strtolower($_LANG['LANG']['SHORT_TAG'])==strtolower($BROWSER_LANG)) { //If no language Selected try get browsers language
				$_COOKIE['SITE_LANG'] = $langfile[(count($langfile)-1)];
				setcookie("SITE_LANG", $_COOKIE['SITE_LANG'], time()+(3600*24*365));
			}
		}
	}
}

if (!@file_exists('inc/languages/'.$_COOKIE['SITE_LANG'].'/conf.settings.php')) { //See if selected language exists
	setcookie("SITE_LANG", $DEFAULT_LANG, time()+(3600*24*365));
}

if (@file_exists('inc/languages/'.$DEFAULT_LANG.'/conf.settings.php')) { //See if default language exists and load it
	foreach(glob('inc/languages/'.$DEFAULT_LANG.'/*.php') as $filename) {
		@include($filename);
	}
	if (@file_exists('inc/languages/'.$_COOKIE['SITE_LANG'].'/conf.settings.php') AND $DEFAULT_LANG!=$_COOKIE['SITE_LANG']) { //See if selected language exists and load it
		foreach(glob('inc/languages/'.$_COOKIE['SITE_LANG'].'/*.php') as $filename) {
			@include($filename);
		}
	}
} else {
	$haserrors = "Couldn't load the Default (".$DEFAULT_LANG.") Language!";
}

require_once ('inc/conf/conf.classes.php');
require_once ('inc/conf/conf.functions.php');

if (@file_exists('inc/conf/conf.database.php')) { //Check the Database Settings (inc/conf/conf.database.php), if not exists then install page shows up
	require_once ('inc/conf/conf.database.php');
	if ($haserrors=='') {
		if ($_REQUEST['n']=="install") {
			$haserrors = $_LANG['ERROR']['CANT_INSTALL'];
		} else if (!validateip()) {
			$haserrors = $_LANG['ERROR']['ACCOUNT_BANNED'];
			log_out(false);
		} else {
			require_once ('inc/conf/conf.main.php');
		}
	}
} else {
	$_REQUEST['n']="install";
	$FULL_LAYOUT=false;
}

if ($haserrors!='') { //If Has General Erros, Block Page showing the Errors
	$_REQUEST['n']="blocked";
	$FULL_LAYOUT=false;
} else {
	if ($_REQUEST['n']=='forums') { //Load Speciffic Layouts for Forums, Wallpapers, Screenshots, Fan Art, World Map and Armory
		$diflayout=".forums";
	} else if ($_REQUEST['n']=='armory') {
		$diflayout=".armory";
	} else if ($_REQUEST['n']=='media.wallpapers' OR $_REQUEST['n']=='media.screenshots' OR $_REQUEST['n']=='community.fanart' OR $_REQUEST['n']=='workshop.worldmap' OR $_REQUEST['n']=='workshop.eventscalendar' ) {
		$diflayout=".media";
	} else {
		$diflayout="";
	}
}

require_once ('inc/layout/page.body'.$diflayout.'.php');
require_once ('inc/layout/page.body.main.php');

if ($_REQUEST['n']!="install" AND $_REQUEST['n']!="blocked") {
	validatelogin(); //for Login security reasons.
	setonline($_SERVER['REQUEST_URI']); //Who's On-Line
}

require ('inc/layout/page.head'.$diflayout.'.php'); //Load Layout

switch ($_REQUEST['n']) { //Load Selected Page
	case "news.archive":
		require('inc/news/news.archive.php');
	break;
	case "account.create":
		require('inc/account/account.create.php');
	break;
	case "account.manage":
		require('inc/account/account.manage.php');
	break;
	case "account.pm":
		require('inc/account/account.pm.php');
	break;
	case "account.login":
		require('inc/account/account.login.php');
	break;
	case "account.activation":
		require('inc/account/account.activation.php');
	break;
	case "account.logout":
		log_out(true);
	break;
	case "account.retrieve":
		require('inc/account/account.retrieve.php');
	break;
	case "account.realmstatus":
		include('inc/account/account.realmstatus.php');
	break;
	case "gameguide.introduction":
	case "gameguide.gettingstarted":
	case "gameguide.faq":
	case "gameguide":
		include('inc/gameguide/gameguide.main.php');
	break;
	case "workshop.pvprankings":
		include('inc/workshop/workshop.pvprankings.php');
	break;
	case "workshop.eventscalendar":
		include('inc/workshop/workshop.eventscalendar.php'); parchdown();
	break;
	case "workshop.worldmap":
		include('inc/workshop/workshop.worldmap.php');
	break;
	case "workshop.talentcalculator":
		parchup(); errborder($_LANG['ERROR']['CONST']); 
	case "media.screenshots":
		include('inc/media/media.screenshots.php');
	break;
	case "media.wallpapers":
		include('inc/media/media.wallpapers.php');
	break;
	case "media.otherdownloads":
		parchup(); errborder($_LANG['ERROR']['CONST']); parchdown();
	break;
	case "armory":
		include('/armory/index.php');
	break;
	case "forums":
		include('inc/forum/forums.main.php');
	break;
	case "error.maintenance":
		include('inc/error/error.maintenance.php');
	break;
	case "error.required":
		include('inc/error/error.required.php');
	break;
	case "error.denied":
		include('inc/error/error.denied.php');
	break;
	case "error.forbidden":
		include('inc/error/error.forbidden.php');
	break;
	case "community":
	case "community.spotlight":
		include('inc/community/community.main.php');
	break;
	case "community.online":
		require('inc/community/community.online.php');
	break;
	case "community.contests":
		include('inc/community/community.contests.php');
	break;
	case "community.fanart":
		include('inc/community/community.fanart.php');
	break;
	case "support.ingame":
		include('inc/support/support.ingame.php');
	break;
	case "support.donations":
		include('inc/support/support.donations.php');
	break;
	case "support.staff":
		include('inc/support/support.staff.php');
	break;
	case "support.license":
		include('inc/support/support.license.php');
	break;
	case "support":
	case "support.jobs":
	case "support.rules":
		include('inc/support/support.main.php');
	break;
	case "admin":
	case "admin.realms":
	case "admin.text":
	case "admin.database":
	case "admin.gallery":
	case "admin.web":
	case "admin.forums":
	case "admin.accounts":
	case "admin.donations":
	case "admin.email":
	case "admin.misc":
		include('inc/admin/admin.main.php');
	break;
	case "install":
		require('inc/install/page.install.php');
	break;
	case "blocked":
		parchup(); errborder($haserrors); parchdown();
	break;
	case "news":
	default:
		$SHOW_LINKS=true;
		require('inc/news/news.main.php');
	break;
}
require ('inc/layout/page.foot'.$diflayout.'.php'); //Load Layout

include('inc/forum/forum.new.php');

if ($_REQUEST['n']!="install") {
	echo '<script>document.title="'.$SETTING['WEB_SITE_NAME'].' :: '.onlinelocation($_SERVER['REQUEST_URI']).'";</script>'; // Name Window Title;
	@mysql_close($MySQL_CON); //cloeses MySQL Connection
}

?>

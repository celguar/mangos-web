<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="favicon.ico" rel="shortcut icon">
<?php
require "configuration/settings.inc.php";
?>
<title><?php echo $config['Title'] ?></title>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<meta content="Mangos Blizzlike Armory." name="description">
<script src="shared/global/third-party/detection.js" type="text/javascript"></script>
<style media="screen, projection" type="text/css">
	@import "css/master.css";
	@import "css/en_us/language.css";
</style>
<script type="text/javascript">
//
if (is_moz) {
} else if (is_ie7) {
	document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/ie7.css" />');
}	
else if (is_ie6) {
	document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/ie.css" />');

	try {
	  document.execCommand("BackgroundImageCache", false, true);
	} catch(err) {}
}	
else if (is_opera) {
    document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/opera.css" />');
}
if (is_mac && !is_moz) {
	document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/opera-mac.css" />');
}

if (is_safari && is_mac) {
	if (is_safari3)
		document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/safari3.css" />');
	document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/safari.css" />');
} else if (is_safari) {
	document.write('<link rel="stylesheet" type="text/css" media="screen, projection" href="css/safari-pc.css" />');
}
	
//
</script>
<div id="containerJavascript"></div>
</head>
<body>
<style> @import "shared/global/menu/topnav/topnav.css"; </style>
<script>global_nav_lang = 'en_us'</script>
<div class="tn_armory" id="shared_topnav">
<script src="shared/global/menu/topnav/buildtopnav.js"></script>
</div>
<form id="historyStorageForm" method="GET">
<textarea id="historyStorageField" name="historyStorageField"></textarea>
</form>
<script src="js/armory.js" type="text/javascript"></script><script src="js/dhtmlHistory.js" type="text/javascript"></script><script src="js/en_us/strings.js" type="text/javascript"></script>
<table id="armory">
<tr>
<td width="50%"></td><td>
<div class="deco">
<a class="logo" href="index.php"><!--<span>World of Warcraft</span>--></a>
</div>
<div class="top-anchor-int" id="divChains">
<em></em><em class="rc"></em>
</div>
<script type="text/javascript">
	var theLang = "en_us";
	var searchQueryValue = '';
<?php
if(defined("REQUESTED_ACTION") and isset($_GET["searchQuery"]))
{
?>
	searchQueryValue = "<?php echo $_GET["searchQuery"]; ?>";
	setcookie("armory.cookieSearch", searchQueryValue);
<?php
}
?>
	if (getcookie2("armory.cookieSearch")) {
		searchQueryValue = getcookie2("armory.cookieSearch");
	} else {
		searchQueryValue = 'Search the Armory';	
	}

	/*if(region != "KR" && region != "TW"){
		searchQueryValue = unescape(searchQueryValue);
	}*/
	var globalSearch = "1";
	setcookie("cookieLangId", theLang); // fixed a bug (when the page used a function 'document(url)')
</script>
<div class="other" id="indexChange1">
<div class="search-container" id="indexChange2">
<div class="search">
<div class="adv-search">
<em></em><a class="title-advsearch"></a><a class="advsearch" href="item-search.php">Items</a>
</div>
<div class="search-right">
<a class="title-search"><!--<span>Search the Armory</span>--></a>
<div class="input">
<div class="dd">
<div class="dropDowner">
<a class="dropTrigger" href="javascript:void(0);" id="replaceSearchOption" onmouseout="javascript: getElementById('searchCat').style.display='none';" onmouseover="javascript: getElementById('searchCat').style.display='block';">Characters</a>
<div class="searchMenu" id="searchCat" onmouseout="javascript: getElementById('searchCat').style.display='none';" onmouseover="javascript: getElementById('searchCat').style.display='block';">
<del></del>
<div class="sm-content">
<a href="#" onClick="javascript: menuSelect('Characters', 'characters'); return false;">Characters</a><a href="#" onClick="javascript: menuSelect('Guilds', 'guilds'); return false;">Guilds</a><a href="#" onClick="javascript: menuSelect('Arena Teams', 'arenateams'); return false;">Arena Teams</a><a href="#" onClick="javascript: menuSelect('Items', 'items'); return false;">Items</a>
</div>
<q></q>
</div>
</div>
</div>
<div class="arrow"></div>
<form action="index.php" method="get" name="formSearch" onSubmit="javascript: return menuCheckLength(document.formSearch);">
<div class="ipl">
<div style="position: relative; z-index: 90; left: -160px;">
<input id="armorySearch" maxlength="72" name="searchQuery" onBlur="javascript: checkBlur();" onFocus="javascript: checkClear();" size="16" type="text" value="Search the Armory">
</div>
<div id="errorSearchType"></div>
<div id="formSearch_errorSearchLength" onMouseOver="javascript: this.innerHTML = '';"></div>
<input name="searchType" type="hidden" value= "<?php if (isset($_COOKIE["cookieMenu"])) echo ($_COOKIE["cookieMenu"]); else echo "characters"; ?>" >
</div>
<script type="text/javascript">
<?php
if(defined("REQUESTED_ACTION") and isset($_GET["searchQuery"]))
{
	if(REQUESTED_ACTION <> "characters" && REQUESTED_ACTION <> "guilds" && REQUESTED_ACTION <> "arenateams" && REQUESTED_ACTION <> "items")
		$searchTypeValue = "characters";
	else
		$searchTypeValue = REQUESTED_ACTION;
?>

	var searchTypeValue = "<?php echo $searchTypeValue ?>";
	setcookie("cookieMenu", searchTypeValue);
function ucfirst( str ) {
	var f = str.charAt(0).toUpperCase();
	return f + str.substr(1, str.length-1);
}
	setcookie("cookieMenuText", ucfirst(searchTypeValue));
<?php
}
?>
	var searchTypeValue = getcookie2("cookieMenu");
	searchTypeValue = searchTypeValue.replace("ext=", "");
	if (searchTypeValue == "Characters")
		searchTypeValue = "characters";
	var searchTypeText = getcookie2("cookieMenuText");
	if (!searchTypeValue) {
		searchTypeValue	= "characters";
		setcookie('cookieMenu', "characters");
	} else {
		if (searchTypeValue != 'characters')
			document.getElementById('replaceSearchOption').innerHTML = searchTypeText;
	}

document.formSearch.searchQuery.value = searchQueryValue;
document.formSearch.searchType.value = searchTypeValue;

</script>
<div class="ip">
<div class="fb"></div>
</div>
<div class="submit" style="position:relative; z-index: 100;">
<a class="submit" href="javascript:void(0);" onClick="javascript: return menuCheckLength(document.formSearch);"></a>
</div>
<div class="searchTrick">
<input id="dummy" onBlur="javascript: hideDropBox();" size="2" type="button">
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<div class="backplate">
<div class="bp2">
<span class="general-image" id="imageLeft"></span>
<div class="ab-container">
<h3 class="banner">
<span class="armory-left"></span><a class="armory-title" href="index.php"><!--<span id="armoryTitleRef">The Armory</span>--></a>
</h3>
</div>
<div class="pin-container">
<?php
if($config['Login'] == 1)
{
?>
<div class="loginBox">
<div class="loginContents">
<div class="toplogincontainer">
<div class="toploginright"></div>
<div style="height: 23px; background: url('images/login-armory-bg.gif') repeat-x top left; float: right; padding: 3px 7px 0;">
<form id="loginRedirect" method="post" name="loginRedirect">
<input id="passThrough" name="passThrough" type="hidden" value="1"><input id="redirectUrl" name="redirectUrl" type="hidden"><a alt="" href="javascript: document.loginRedirect.submit()">
<div style="display: block; float: left; vertical-align: baseline; margin-top: -2px;  width: 25px; height: 23px; background: url('images/tab-key-3.gif') no-repeat top left; margin-right: 4px;"></div>Log In</a>
</form>
<script type="text/javascript">
		  document.getElementById('loginRedirect').action = "index.php?searchType=login";
		  </script>
</div>
<div class="toploginleft"></div>
</div>
<script type="text/javascript">document.getElementById('redirectUrl').value = window.location.pathname + window.location.search;</script>
</div>
</div>
<?php
}
if($config['Registration'] == 1)
{
?>
<div class="pinProfile" id="showHidePin">
<div class="pin-back">
<div class="hord" id="changeClassFaction">
<h1></h1>
<div class="pin-base">
<strong id="replacePinCharName1"></strong>
<p id="replacePinGuildName1"></p>
</div>
<div class="pin-clone">
<strong id="replacePinCharName2"></strong>
<p id="replacePinGuildName2"></p>
</div>
<div class="pinArena">
<div id="replaceTeam2"></div>
<div id="replaceTeam3"></div>
<div id="replaceTeam5"></div>
</div>
<div class="pinNav">
<a class="pdown0" href="javascript: ;" id="idPinNavArrow" onMouseOut="javascript: document.getElementById('pinprofile').style.visibility = 'hidden';" onMouseOver="javascript: hoverPinOption();"></a>
</div>
</div>
</div>
<div class="tooltip" id="pinprofile" onMouseOut="javascript: document.getElementById('pinprofile').style.visibility='hidden';" onMouseOver="javascript: document.getElementById('pinprofile').style.visibility='visible';">
</div>
</div>
<?php
}
?>
</div>
<div class="global-nav">
<a class="wowcom" href="index.php"></a>
<div id="arenaMenu"></div>
</div>
</div>
<script type="text/javascript">
//
if (getcookie2("armory.cookieCharProfileUrl") !=0) {
	showPin();
if (getcookie2("armory.cookieDualTooltip") == 1)
	document.getElementById('checkboxDualTooltip').checked = 1;
} else {
	hidePin();
}
//
</script>
<div id="replaceMain">
<div id="dataElement">

<div class="parchment-top">
<div class="parchment-content">
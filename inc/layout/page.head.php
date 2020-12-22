<?php
if (INCLUDED!==true) { include('index.htm'); exit; }
?>
<html>
<head>
    <META http-equiv="Content-Type" content="text/html; <? echo $_LANG['LANG']['CHARSET']; ?>">
	<link REL="SHORTCUT ICON" HREF="new-hp/images/favicon.ico">
    <title><?php echo $SETTING['WEB_SITE_NAME']; ?></title>
    <style media="screen" title="currentStyle" type="text/css">
        @import "new-hp/css/loader_screen.css";
	</style>
		<?php 
			if (isset($_SESSION['userid']) and $FULL_LAYOUT==true) { 
				$query = @mysql_query("SELECT template FROM forum_accounts WHERE id_account='".$_SESSION['userid']."'"); 
				$query = @mysql_fetch_array($query);
				if ($query['template']!="") { $SETTING['WEB_DEF_TEMPLATE'] = $query['template']; }
			}
			if (!file_exists('new-hp/templates/'.$SETTING['WEB_DEF_TEMPLATE'].'/layout.css')) {
				$SETTING['WEB_DEF_TEMPLATE'] = "Wrath_of_the_Lich_King";
			}
		?>

	<script type="text/javascript">
		function changelayout(layout) {
			if (layout=="") { layout='<?php echo $SETTING['WEB_DEF_TEMPLATE'];  ?>'; }
			var oLink = document.createElement("link")
			oLink.href = 'new-hp/templates/' + layout + "/layout.css";
			oLink.rel = "stylesheet";
			oLink.type = "text/css";
			document.body.appendChild(oLink);
			if (is_ie) { 
				var eoLink = document.createElement("link")
				eoLink.href = 'new-hp/templates/' + layout + "/layout_ie.css";
				eoLink.rel = "stylesheet";
				eoLink.type = "text/css";
				document.body.appendChild(eoLink);
			}
		}

		var scriptsLoaded=0;
	</script>
    <link title="orc" href="new-hp/css/orc.css" media="screen, projection" type="text/css" rel="alternate stylesheet">
	<link rel="stylesheet" href="new-hp/css/extra.css">
	<script language="JavaScript" type="text/javascript" src='new-hp/js/tooltip.js'></script>
	<script language="JavaScript" type="text/javascript" src='new-hp/js/menu132_com.js'></script>
	<link rel="alternate" href="inc/news/news.rss.xml" type="application/rss+xml" title="<?php echo $SETTING['WEB_SITE_NAME'] . " Latest News"; ?>"/>
    <script src="shared/wow-com/includes-client/detection.js" language="JavaScript"></script>
	
	<link rel="stylesheet" href="new-hp/templates/<?php echo $SETTING['WEB_DEF_TEMPLATE']; ?>/layout.css">
	<script language="javascript">	
	//
	if (is_ie) {
		document.write('<link rel="stylesheet" href="new-hp/templates/<?php echo $SETTING['WEB_DEF_TEMPLATE']; ?>/layout_ie.css" />');
		document.write('<link rel="stylesheet" type="text/css" href="new-hp/css/additional_win_ie.css" media="screen, projection" />');
	}

	if(is_opera)
		document.write('<link rel="stylesheet" type="text/css" href="new-hp/css/additional_opera.css" media="screen, projection" />');
	//
	</script>
	<script src="new-hp/js/cookies.js" type="text/javascript"></script>
	<script src="new-hp/js/functions.js" type="text/javascript"></script>
	<script src="new-hp/js/p7_eqCols2_10.js" type="text/javascript"></script>
  </head>
  <body>
<div style="height: 21px; left: -1000px; top: 484px; visibility: hidden;" id="contents">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody>
	<tr>
		<td><img src="new-hp/images/pixel.gif" height="1" width="1"></td>
		<td bgcolor="#000000"></td>

		<td><img src="new-hp/images/pixel.gif" height="1" width="1"></td>
	</tr>
	<tr>
		<td bgcolor="#000000"></td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tbody>
				<tr>
					<td bgcolor="#000000" height="1" width="1"></td>

					<td bgcolor="#d5d5d7" height="1"><img src="new-hp/images/pixel.gif" height="1" width="1"></td>
					<td bgcolor="#000000" height="1" width="1"></td>
				</tr>
				<tr>
					<td bgcolor="#a5a5a5" width="1"><img src="new-hp/images/pixel.gif" height="1" width="1"></td>
					<td class="trans_div" valign="top"><div style="visibility: visible;" id="tooltipText"></div></td> 
					<td bgcolor="#a5a5a5" width="1"><img src="new-hp/images/pixel.gif" height="1" width="1"></td>
				</tr>
				<tr>

					<td bgcolor="#000000" height="1" width="1"></td>
					<td bgcolor="#4f4f4f"><img src="new-hp/images/pixel.gif" height="2" width="1"></td>
					<td bgcolor="#000000" height="1" width="1"></td>
				</tr>
				</tbody>
			</table>
		</td>
		<td bgcolor="#000000"></td>
	</tr>

	<tr>
		<td><img src="new-hp/images/pixel.gif" height="1" width="1"></td>
		<td bgcolor="#000000"></td>
		<td><img src="new-hp/images/pixel.gif" height="1" width="1"></td>
	</tr>
	</tbody>
</table>
</div>
  <style><!--
 #contents{
	visibility: hidden;
	position: absolute;
	Z-INDEX: 999999;
	width: 5px;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=scale src='new-hp/images/blue-bg.png');
}
.trans_div[class] {
background-image:url(new-hp/images/blue-bg.png);
}
	--></style>
<? 
topnav();
?>
    <div class="page-bg-top">
		<div id="header" align=center>
			<div class="logo-container">
				<div class="logo-right">
					<h1 class="wow-logof"><a HREF="?"><img SRC="new-hp/images/pixel.gif" border="0" alt="World Of Warcraft" title="World Of Warcraft" width="262" height="106" /></a></h1>
				</div>
			</div>
		</div>
	</div>
<script>

function countryopt(state) {

	cm = document.getElementById('countrymenu');

	if (state == "") {
		if (cm.style.visibility == "visible") {
			cm.style.visibility = "hidden";
		} else {
			cm.style.visibility = "visible";
		}
	} else {
		cm.style.visibility = state;
	}
	
}

</script>
<?php
	$ChooseLangStr = "Choose a Language";
	for ($i=0; $i<count($_LANG['LANG']['FOLDER']);$i++) {
		if ($_LANG['LANG']['FOLDER'][$i]==$_COOKIE['SITE_LANG']) {
			$ChooseLangStr = $_LANG['LANG']['LARGE_TAG_LIST'][$i];
			$LangI = $i;
		} else {
			$LangListStr .= '	<div OnMouseOver="this.style.backgroundColor=\'rgb(100, 100, 100)\';" OnMouseOut="this.style.backgroundColor=\'rgb(29, 28, 27)\';" style="cursor: pointer; background-color: rgb(29, 28, 27); color: rgb(244, 196, 0); font-family: arial,comic sans ms,technical; font-size: 12px; font-weight: bold; font-style: normal; text-align: left; background-image: url(new-hp/images/mainmenu/bullet-trans-bg.gif); width: 131px; height: 15px; padding-left: 9px; padding-top: 0px; left: 1px; top: 1px;">
						<a href="?n=language&set='.$_LANG['LANG']['FOLDER'][$i].'" class="menuLink">'.$_LANG['LANG']['LARGE_TAG_LIST'][$i].'</a><div style="position: relative; right: -93px; top: 2px; margin: -20 0 0 0;"><img border=0 src="new-hp/images/flags/'.strtolower($_LANG['LANG']['SHORT_TAG_LIST'][$i]).'.gif" width="24" height="22"></div>
					</div>';
		}
	}
?>
<div id="menuContainer9" OnMouseOut="javascript:countryopt('hidden');"  OnMouseOver="javascript:countryopt('visible');" OnClick="javascript:countryopt('');" style="position: absolute; visibility: visible; background-color: transparent; z-index: 101; opacity: 0.857143; width: 149px; height: 21px; top: 68px; right: 180px;">
	<div style="overflow: hidden; position: absolute; visibility: inherit; cursor: default; background-color: transparent; color: rgb(244, 196, 0); font-family: arial,comic sans ms,technical; font-size: 12px; font-weight: bold; font-style: normal; text-align: left; background-image: url(new-hp/images/countrymenu-bg.gif); width: 149px; height: 21px; padding-left: 0px; padding-top: 0px; left: 0px; top: 0px;">
		<div style="position: absolute; top: 2px; left: 10px; cursor: pointer;"><div style="width: 58; white-space: nowrap;"><? echo $ChooseLangStr; ?></div><div style="position: absolute; right: -58px; top: -3px;"><img border=0 src="new-hp/images/flags/<?php echo strtolower($_LANG['LANG']['SHORT_TAG_LIST'][$LangI]); ?>.gif" width="24" height="22"></div></div>	
	</div>
	<div id="countrymenu" OnClick="javascript:countryopt('hidden');" style="border: 1px solid gray; filter:progid:DXImageTransform.Microsoft.dropshadow(OffX=2, OffY=2, Positive='true')progid:DXImageTransform.Microsoft.Alpha(opacity=90)progid:DXImageTransform.Microsoft.Shadow(color=#000000, direction=135, strength=3); position: absolute; visibility: hidden; cursor: default; background-color: transparent; color: rgb(244, 196, 0); font-family: arial,comic sans ms,technical; font-size: 12px; font-weight: bold; font-style: normal; text-align: left; padding-left: 0px; padding-top: 0px; left: 0px; top: 20px;">
		<?php echo $LangListStr; ?>
	</div>
</div>
	<div class="mainlayout" align=center style="position: absolute; width: 100%;">
    <center>
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <div id="hp">
              <div style="position:relative; z-index:999999;">
                <div class="top-nav">
<?php if ($FULL_LAYOUT==true) { ?>
                  <form method=post action="index.php?n=forum&f=search" id="topSearch" name="topSearch" onsubmit="return se_valid()">
                    <div id="searchBoxContainer">
                      <div class="searchBoxLeft"></div>
                      <div class="searchBoxBg">
                        <ul>
                          <li class="searchBoxInput">
                            <input class="searchBoxForm" id="searchBox" name="searchBox" value="<?php echo $searchBox; ?>">
                          </li>
                          <li class="searchBoxSelect">
                            <select class="searchBoxForm" name="t" id="searchType">
							<option value="community" SELECTED>All</option>
							<option value="news">News</option>
							<option value="community">Community</option>
							</select>
                          </li>
                          <li class="searchBoxButton"><a href="#">
                            <div class="redButton-container">
                              <div class="leftNopadd">
                                <img height="22" width="5" src="new-hp/images/button-left.gif"></div>
                              <div class="leftNopadd">
                                <div id="searchBoxButton"> </div>
									<img onclick="return se_valid(); javascript:document.topSearch.submit()" OnMouseOver='javascript:void(document.topSearch.searchbt.src="shared/wow-com/images/buttons/searchrol.png");' OnMouseOut='javascript:void(document.topSearch.searchbt.src="shared/wow-com/images/buttons/search.png");' name="searchbt" src='shared/wow-com/images/buttons/search.png'>
                              </div>
                              <div class="leftNopadd">
                                <img height="22" width="7" src="new-hp/images/button-right.gif"></div>
                            </div></a>
                          </li>
                        </ul>
                      </div>
                      <div class="searchBoxRight"></div>
                    </div>
                  </form>
<?php } ?>
                </div>
              </div>
              <div class="top-nav-container">
                <div style="position: absolute; right: 170px; top: 38px; z-index:98">
                  <div style="z-index:999999999;" id="countryDropDown"></div>
                </div>
                <div style="position: absolute; top: 0; left: 0; z-index: 99;">
                 <div id="wow-logo">
                    <a href="?"><img src="new-hp/images/pixel.gif" width="200" height="100"></a>
                  </div>
                </div>
              </div>
              <div>
                <div id="hpWrapper">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td valign="top">
                        <div id="navWrapper">
                          <div id="nav">
                            <div id="ne-top-left"></div>
                            <div id="ne-center"></div>
                            <div id="ne-bottom-left"></div>
                            <div id="ne-nav-bg"></div>
                            <div id="leftMenu">
<?php if ($FULL_LAYOUT==true) { ?>
<style>
.menuNews-header-on { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-news-on.gif'); }
.menuNews-header-off { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-news-off.gif'); }
.menuGameGuide-header-on { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-gameguide-on.gif'); }
.menuGameGuide-header-off { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-gameguide-off.gif'); }
.menuInteractive-header-on { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-workshop-on.gif'); }
.menuInteractive-header-off { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-workshop-off.gif'); }
.menuCommunity-header-on { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-community-on.gif'); }
.menuCommunity-header-off { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-community-off.gif'); }
.menuForums-header-on {	background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-forums-on.gif'); }
.menuForums-header-off { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-forums-off.gif'); }
.menuAccount-header-on { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-account-on.gif'); }
.menuAccount-header-off { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-account-off.gif'); }
.menuSupport-header-on { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-support-on.gif'); }
.menuSupport-header-off { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-support-off.gif'); }
.menuMedia-header-on { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-media-on.gif'); }
.menuMedia-header-off { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/leftmenu/header-media-off.gif'); }
</style>
                              <div id="leftMenuContainer">
                                <div id="menuNews">
                                  <div onclick="javascript:toggleNewMenu(1-1);" class="menu-button-off" id="menuNews-button">
                                    <span class="menuNews-icon-off" id="menuNews-icon">&nbsp;</span><a class="menuNews-header-off" id="menuNews-header"><em>Game Guide</em></a><a id="menuNews-collapse"></a><span class="menuEntry-rightBorder"></span>
                                  </div>
                                  <div id="menuNews-inner">
                                    <script type="text/javascript">

								//This script handles the default status of each menu based on the user's cookies
                                if (menuCookie[1-1] == 0) {
		
                                    document.getElementById("menuNews-inner").style.display = "none";		
                                    document.getElementById("menuNews-button").className = "menu-button-off";
                                    document.getElementById("menuNews-collapse").className = "leftMenu-plusLink";
                                    document.getElementById("menuNews-icon").className = "menuNews-icon-off";
                                    document.getElementById("menuNews-header").className = "menuNews-header-off";
                                } else {

                                    document.getElementById("menuNews-inner").style.display = "block";		
                                    document.getElementById("menuNews-button").className = "menu-button-on";
                                    document.getElementById("menuNews-collapse").className = "leftMenu-minusLink";
                                    document.getElementById("menuNews-icon").className = "menuNews-icon-on";
                                    document.getElementById("menuNews-header").className = "menuNews-header-on";
                                }

                            </script>
                                    <div class="leftMenu-cont-top"></div>
                                    <div class="leftMenu-cont-mid">
                                      <div class="m-left">
                                        <div class="m-right">
                                          <div class="leftMenu-cnt">
                                            <ul class="mainNav">
                                              <div style="position:relative;" id="menuFiller1">
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php">Current News</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=news.archive">Archived News</a>
                                                </div>
											    <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="inc/news/news.rss.xml">RSS Feeds</a>
                                                </div>
                                              </div>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="leftMenu-cont-bot"></div>
                                  </div>
                                </div>
                                <div id="menuAccount">
                                  <div onclick="javascript:toggleNewMenu(2-1);" class="menu-button-off" id="menuAccount-button">
                                    <span class="menuAccount-icon-off" id="menuAccount-icon">&nbsp;</span><a class="menuAccount-header-off" id="menuAccount-header"><em>Game Guide</em></a><a id="menuAccount-collapse"></a><span class="menuEntry-rightBorder"></span>
                                  </div>
                                  <div id="menuAccount-inner">
                                    <script type="text/javascript">

								//This script handles the default status of each menu based on the user's cookies
                                if (menuCookie[2-1] == 0) {
		
                                    document.getElementById("menuAccount-inner").style.display = "none";		
                                    document.getElementById("menuAccount-button").className = "menu-button-off";
                                    document.getElementById("menuAccount-collapse").className = "leftMenu-plusLink";
                                    document.getElementById("menuAccount-icon").className = "menuAccount-icon-off";
                                    document.getElementById("menuAccount-header").className = "menuAccount-header-off";
                                } else {

                                    document.getElementById("menuAccount-inner").style.display = "block";		
                                    document.getElementById("menuAccount-button").className = "menu-button-on";
                                    document.getElementById("menuAccount-collapse").className = "leftMenu-minusLink";
                                    document.getElementById("menuAccount-icon").className = "menuAccount-icon-on";
                                    document.getElementById("menuAccount-header").className = "menuAccount-header-on";
                                }
                            </script>
                                    <div class="leftMenu-cont-top"></div>
                                    <div class="leftMenu-cont-mid">
                                      <div class="m-left">
                                        <div class="m-right">
                                          <div class="leftMenu-cnt">
                                            <ul class="mainNav">
                                              <div style="position:relative;" id="menuFiller2">
<?php if (!isset($_SESSION['userid'])) { ?>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=account.create">Create Account</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=account.activate">Activate Account</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=account.login">Log In</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=account.retrievepassword">Retrieve Password</a>
                                                </div>
<?php } else { ?>
												<div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=account.manage">Manage Account</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=account.pm">Private Messages (<?php $query = mysql_query("SELECT id_pm FROM forum_pm WHERE id_account_to='".$_SESSION['userid']."' and isread='0'"); $PMTotal=mysql_num_rows($query); echo $PMTotal;?>)</a>
			<?php if(mysql_num_rows($query)>=1) { echo '<script>
														var answer;

														if (getCookie("pmask")!="no" || getCookie("pmtt")<'.(mysql_num_rows($query)).') {
															answer = confirm ("You have '.(mysql_num_rows($query)).' unread messages!\n\nWant to read them now?");
														}
														if (answer) { 
															setCookie("pmask","no", now);
															setCookie("pmtt", "'.(mysql_num_rows($query)).'", now);
															window.location="?n=account.pm&f=inbox";
														} else {
															setCookie("pmask","no", now);
															setCookie("pmtt","'.(mysql_num_rows($query)).'", now);
														}
														</script>';
			} ?>
                                                </div>
												<div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=account.logout">Log Out [<?php echo $_SESSION['nickname']; ?>]</a>
                                                </div>
<?php } ?>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=account.realmstatus">Realm Status</a>
                                                </div>
                                              </div>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="leftMenu-cont-bot"></div>
                                  </div>
                                </div>
                                <div id="menuGameGuide">
                                  <div onclick="javascript:toggleNewMenu(3-1);" class="menu-button-off" id="menuGameGuide-button">
                                    <span class="menuGameGuide-icon-off" id="menuGameGuide-icon">&nbsp;</span><a class="menuGameGuide-header-off" id="menuGameGuide-header"><em>Game Guide</em></a><a id="menuGameGuide-collapse"></a><span class="menuEntry-rightBorder"></span>
                                  </div>
                                  <div id="menuGameGuide-inner">
                                    <script type="text/javascript">

								//This script handles the default status of each menu based on the user's cookies
                                if (menuCookie[3-1] == 0) {
		
                                    document.getElementById("menuGameGuide-inner").style.display = "none";		
                                    document.getElementById("menuGameGuide-button").className = "menu-button-off";
                                    document.getElementById("menuGameGuide-collapse").className = "leftMenu-plusLink";
                                    document.getElementById("menuGameGuide-icon").className = "menuGameGuide-icon-off";
                                    document.getElementById("menuGameGuide-header").className = "menuGameGuide-header-off";
                                } else {

                                    document.getElementById("menuGameGuide-inner").style.display = "block";		
                                    document.getElementById("menuGameGuide-button").className = "menu-button-on";
                                    document.getElementById("menuGameGuide-collapse").className = "leftMenu-minusLink";
                                    document.getElementById("menuGameGuide-icon").className = "menuGameGuide-icon-on";
                                    document.getElementById("menuGameGuide-header").className = "menuGameGuide-header-on";
                                }

                            </script>
                                    <div class="leftMenu-cont-top"></div>
                                    <div class="leftMenu-cont-mid">
                                      <div class="m-left">
                                        <div class="m-right">
                                          <div class="leftMenu-cnt">
                                            <ul class="mainNav">
                                              <div style="position:relative;" id="menuFiller3">
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif'); width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;"><a class="menuFiller" href="index.php?n=gameguide.introduction">Introduction</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif'); width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;"><a class="menuFiller" href="index.php?n=gameguide.gettingstarted">Getting Started</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif'); width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;"><a class="menuFiller" href="index.php?n=gameguide.faq">FAQ</a>
                                                </div>
                                              </div>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="leftMenu-cont-bot"></div>
                                  </div>
                                </div>
                                <div id="menuInteractive">
                                  <div onclick="javascript:toggleNewMenu(4-1);" class="menu-button-off" id="menuInteractive-button">
                                    <span class="menuInteractive-icon-off" id="menuInteractive-icon">&nbsp;</span><a class="menuInteractive-header-off" id="menuInteractive-header"><em>Game Guide</em></a><a id="menuInteractive-collapse"></a><span class="menuEntry-rightBorder"></span>
                                  </div>
                                  <div id="menuInteractive-inner">
                                    <script type="text/javascript">

								//This script handles the default status of each menu based on the user's cookies
                                if (menuCookie[4-1] == 0) {
		
                                    document.getElementById("menuInteractive-inner").style.display = "none";		
                                    document.getElementById("menuInteractive-button").className = "menu-button-off";
                                    document.getElementById("menuInteractive-collapse").className = "leftMenu-plusLink";
                                    document.getElementById("menuInteractive-icon").className = "menuInteractive-icon-off";
                                    document.getElementById("menuInteractive-header").className = "menuInteractive-header-off";
                                } else {

                                    document.getElementById("menuInteractive-inner").style.display = "block";		
                                    document.getElementById("menuInteractive-button").className = "menu-button-on";
                                    document.getElementById("menuInteractive-collapse").className = "leftMenu-minusLink";
                                    document.getElementById("menuInteractive-icon").className = "menuInteractive-icon-on";
                                    document.getElementById("menuInteractive-header").className = "menuInteractive-header-on";
                                }

                            </script>
                                    <div class="leftMenu-cont-top"></div>
                                    <div class="leftMenu-cont-mid">
                                      <div class="m-left">
                                        <div class="m-right">
                                          <div class="leftMenu-cnt">
                                            <ul class="mainNav">
                                              <div style="position:relative;" id="menuFiller4">
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=workshop.pvprankings">PvP Rankings</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=workshop.eventscalendar">Events Calendar</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=workshop.worldmap">World Map</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=workshop.talentcalculator">Talent Calculators</a>
                                                </div>
                                              </div>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="leftMenu-cont-bot"></div>
                                  </div>
                                </div>
                                <div id="menuMedia">
                                  <div onclick="javascript:toggleNewMenu(5-1);" class="menu-button-off" id="menuMedia-button">
                                    <span class="menuMedia-icon-off" id="menuMedia-icon">&nbsp;</span><a class="menuMedia-header-off" id="menuMedia-header"><em>Game Guide</em></a><a id="menuMedia-collapse"></a><span class="menuEntry-rightBorder"></span>
                                  </div>
                                  <div id="menuMedia-inner">
                                    <script type="text/javascript">

								//This script handles the default status of each menu based on the user's cookies
                                if (menuCookie[5-1] == 0) {
		
                                    document.getElementById("menuMedia-inner").style.display = "none";		
                                    document.getElementById("menuMedia-button").className = "menu-button-off";
                                    document.getElementById("menuMedia-collapse").className = "leftMenu-plusLink";
                                    document.getElementById("menuMedia-icon").className = "menuMedia-icon-off";
                                    document.getElementById("menuMedia-header").className = "menuMedia-header-off";
                                } else {

                                    document.getElementById("menuMedia-inner").style.display = "block";		
                                    document.getElementById("menuMedia-button").className = "menu-button-on";
                                    document.getElementById("menuMedia-collapse").className = "leftMenu-minusLink";
                                    document.getElementById("menuMedia-icon").className = "menuMedia-icon-on";
                                    document.getElementById("menuMedia-header").className = "menuMedia-header-on";
                                }

                            </script>
                                    <div class="leftMenu-cont-top"></div>
                                    <div class="leftMenu-cont-mid">
                                      <div class="m-left">
                                        <div class="m-right">
                                          <div class="leftMenu-cnt">
                                            <ul class="mainNav">
                                              <div style="position:relative;" id="menuFiller5">
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=media.screenshots">Screenshots</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=media.wallpapers">Wallpapers</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=media.otherdownloads">Other Downloads</a>
                                                </div>
                                              </div>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="leftMenu-cont-bot"></div>
                                  </div>
                                </div>
<?php if ($SETTING['FORUM_ENABLED']==1 AND mysql_num_rows(mysql_query("SELECT `id_forum` FROM forums"))>0) { ?>
                                <div id="menuForums">
                                  <div onclick="javascript:toggleNewMenu(6-1);" class="menu-button-off" id="menuForums-button">
                                    <span class="menuForums-icon-off" id="menuForums-icon">&nbsp;</span><a class="menuForums-header-off" id="menuForums-header"><em>Game Guide</em></a><a id="menuForums-collapse"></a><span class="menuEntry-rightBorder"></span>
                                  </div>
                                  <div id="menuForums-inner">
                                    <script type="text/javascript">

								//This script handles the default status of each menu based on the user's cookies
                                if (menuCookie[6-1] == 0) {
		
                                    document.getElementById("menuForums-inner").style.display = "none";		
                                    document.getElementById("menuForums-button").className = "menu-button-off";
                                    document.getElementById("menuForums-collapse").className = "leftMenu-plusLink";
                                    document.getElementById("menuForums-icon").className = "menuForums-icon-off";
                                    document.getElementById("menuForums-header").className = "menuForums-header-off";
                                } else {

                                    document.getElementById("menuForums-inner").style.display = "block";		
                                    document.getElementById("menuForums-button").className = "menu-button-on";
                                    document.getElementById("menuForums-collapse").className = "leftMenu-minusLink";
                                    document.getElementById("menuForums-icon").className = "menuForums-icon-on";
                                    document.getElementById("menuForums-header").className = "menuForums-header-on";
                                }

                            </script>
                                    <div class="leftMenu-cont-top"></div>
                                    <div class="leftMenu-cont-mid">
                                      <div class="m-left">
                                        <div class="m-right">
                                          <div class="leftMenu-cnt">
                                            <ul class="mainNav">
                                              <div style="position:relative;" id="menuFiller6">
<?php

	$qquery = mysql_query("SELECT `id_forum`, `group` FROM `forums` GROUP BY `group` ORDER BY `group` ASC") OR DIE(mysql_error());
	while ($rowx = mysql_fetch_array($qquery)) {
		echo '<div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url(\'new-hp/images/menu/mainmenu/bullet-trans-bg.gif\'); width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
				  <a class="menuFiller" href="index.php?n=forums">'.$FORUM_GROUP[$rowx['group']].'</a>
				</div>';
	}
	?>
                                              </div>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="leftMenu-cont-bot"></div>
                                  </div>
                                </div>
 <iframe name="menuIframe6" id="menuIframe6" frameborder="0" height="0" width="0" src="new-hp/menus/menu6.php?UID=<? echo $_SESSION['userid']; ?>"></iframe>
<?php } ?>
                                <div id="menuCommunity">
                                  <div onclick="javascript:toggleNewMenu(7-1);" class="menu-button-off" id="menuCommunity-button">
                                    <span class="menuCommunity-icon-off" id="menuCommunity-icon">&nbsp;</span><a class="menuCommunity-header-off" id="menuCommunity-header"><em>Game Guide</em></a><a id="menuCommunity-collapse"></a><span class="menuEntry-rightBorder"></span>
                                  </div>
                                  <div id="menuCommunity-inner">
                                    <script type="text/javascript">

								//This script handles the default status of each menu based on the user's cookies
                                if (menuCookie[7-1] == 0) {
		
                                    document.getElementById("menuCommunity-inner").style.display = "none";		
                                    document.getElementById("menuCommunity-button").className = "menu-button-off";
                                    document.getElementById("menuCommunity-collapse").className = "leftMenu-plusLink";
                                    document.getElementById("menuCommunity-icon").className = "menuCommunity-icon-off";
                                    document.getElementById("menuCommunity-header").className = "menuCommunity-header-off";
                                } else {

                                    document.getElementById("menuCommunity-inner").style.display = "block";		
                                    document.getElementById("menuCommunity-button").className = "menu-button-on";
                                    document.getElementById("menuCommunity-collapse").className = "leftMenu-minusLink";
                                    document.getElementById("menuCommunity-icon").className = "menuCommunity-icon-on";
                                    document.getElementById("menuCommunity-header").className = "menuCommunity-header-on";
                                }

                            </script>
                                    <div class="leftMenu-cont-top"></div>
                                    <div class="leftMenu-cont-mid">
                                      <div class="m-left">
                                        <div class="m-right">
                                          <div class="leftMenu-cnt">
                                            <ul class="mainNav">
                                              <div style="position:relative;" id="menuFiller7">
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=community.spotlight">Community Spotlight</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=community.online">Users On-Line (<?php echo mysql_num_rows(mysql_query("SELECT id FROM web_online")); ?>)</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=community.contests">Contests</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=community.fanart">Fan Art</a>
                                                </div>
                                              </div>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="leftMenu-cont-bot"></div>
                                  </div>
                                </div>
                                <div id="menuSupport">
                                  <div onclick="javascript:toggleNewMenu(8-1);" class="menu-button-off" id="menuSupport-button">
                                    <span class="menuSupport-icon-off" id="menuSupport-icon">&nbsp;</span><a class="menuSupport-header-off" id="menuSupport-header"><em>Game Guide</em></a><a id="menuSupport-collapse"></a><span class="menuEntry-rightBorder"></span>
                                  </div>
                                  <div id="menuSupport-inner">
                                    <script type="text/javascript">

								//This script handles the default status of each menu based on the user's cookies
                                if (menuCookie[8-1] == 0) {
		
                                    document.getElementById("menuSupport-inner").style.display = "none";		
                                    document.getElementById("menuSupport-button").className = "menu-button-off";
                                    document.getElementById("menuSupport-collapse").className = "leftMenu-plusLink";
                                    document.getElementById("menuSupport-icon").className = "menuSupport-icon-off";
                                    document.getElementById("menuSupport-header").className = "menuSupport-header-off";
                                } else {

                                    document.getElementById("menuSupport-inner").style.display = "block";		
                                    document.getElementById("menuSupport-button").className = "menu-button-on";
                                    document.getElementById("menuSupport-collapse").className = "leftMenu-minusLink";
                                    document.getElementById("menuSupport-icon").className = "menuSupport-icon-on";
                                    document.getElementById("menuSupport-header").className = "menuSupport-header-on";
                                }

                            </script>
                                    <div class="leftMenu-cont-top"></div>
                                    <div class="leftMenu-cont-mid">
                                      <div class="m-left">
                                        <div class="m-right">
                                          <div class="leftMenu-cnt">
                                            <ul class="mainNav">
                                              <div style="position:relative;" id="menuFiller8">
												<div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=support.staff">Staff Personal</a>
                                                </div>
                                                <div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=support.ingame">In-Game Support</a>
                                                </div>
												<div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=support.donations">Donations</a>
                                                </div>
												<div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=support.rules">Rules</a>
                                                </div>
												<?php if (verifylevel($_SESSION['userid'])>=1) { ?>
												<div style="font-weight:bold; text-decoration: none; font-family:arial,comic sans ms,technical; font-size: 11px; position: relative; left: -3px; background-image:url('new-hp/images/menu/mainmenu/bullet-trans-bg.gif');        width:139px; height:15px; _height:18px; padding:0px; margin:0px; _margin-bottom:-3px; border:0px; padding-left:10px;">
                                                  <a class="menuFiller" href="index.php?n=admin">Site Administration</a>
                                                </div>
												<?php } ?>
                                              </div>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="leftMenu-cont-bot"></div>
                                  </div>
                                </div>
                              </div>
<?php } ?>
                            </div>
                          </div>
                          <div style="clear: both;"></div>
                        </div>
                      </td><td valign="top">
					  <div id="mainWrapper">

                          <div id="main">
                            <div id="main-content-wrapper">
                              <div id="main-content">

                                <table cellspacing="0" cellpadding="0" border="0">
                                  <tr>
                                    <td>
									
                                      <div id="main-top">

                                        <div>
                                          <div></div>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <div id="contentPadding">
                                        <div id="cnt">
                                          <div id="cnt-wrapper">
                                            <div id="contentContainer">

                                              <link href="new-hp/css/newhp_specific.css" media="screen, projection" rel="stylesheet" type="text/css">
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="/new-hp/css/newhp_specific_ie.css" media="screen, projection" />
<![endif]-->
<?php if ($FULL_LAYOUT==true) { ?>
    <iframe name="menuIframe1" id="menuIframe1" frameborder="0" height="0" width="0" src="new-hp/menus/menu1.php"></iframe>
    <iframe name="menuIframe2" id="menuIframe2" frameborder="0" height="0" width="0" src="new-hp/menus/menu2.php?islog=<? echo $_SESSION['nickname']; ?>&ttpm=<? echo $PMTotal; ?>&actpm=<? echo $PMEnabled; ?>"></iframe>
    <iframe name="menuIframe3" id="menuIframe3" frameborder="0" height="0" width="0" src="new-hp/menus/menu3.php"></iframe>
    <iframe name="menuIframe4" id="menuIframe4" frameborder="0" height="0" width="0" src="new-hp/menus/menu4.php"></iframe>
    <iframe name="menuIframe5" id="menuIframe5" frameborder="0" height="0" width="0" src="new-hp/menus/menu5.php"></iframe>
    <iframe name="menuIframe7" id="menuIframe7" frameborder="0" height="0" width="0" src="new-hp/menus/menu7.php"></iframe>
    <iframe name="menuIframe8" id="menuIframe8" frameborder="0" height="0" width="0" src="new-hp/menus/menu8.php?level=<? echo verifylevel($_SESSION['userid']); ?>"></iframe>
<?php } ?>
                                              <table border="0" cellpadding="0" cellspacing="0" width=710 height=900>
                                                <tr>
                                                  <td valign="top">
                                                    <div>
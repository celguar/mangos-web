<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; <?php echo $_LANG['LANG']['CHAR_SET']; ?>" />
<title>Forums</title>
<link href="new-hp/images/favicon.ico" rel="shortcut icon" />
<style type="text/css" title="currentStyle" media="screen">
	@import "new-hp/css/forums.css";
	@import "new-hp/css/forum_master.css";
</style>

<link rel="stylesheet" href="new-hp/css/forum_languages.css" type="text/css" media="screen" charset="utf-8" />
<link rel="alternate stylesheet" type="text/css" media="screen, projection" href="new-hp/css/additional-mac-safari.css" title="safari" />
<!--[if lte IE 7]>
<link rel="stylesheet" href="new-hp/css/forum_additional-win-ie.css" type="text/css"  />
<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" href="new-hp/css/forum_additional-win-ie7.css" type="text/css" />
<![endif]-->
<script src="new-hp/js/cookies.js" type="text/javascript"></script>
<script type="text/javascript" src="new-hp/js/detection.js"></script>
</head>
<body>
<script language="JavaScript" type="text/javascript" src='new-hp/js/tooltip.js'></script>
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
<script type="text/javascript">
	function changelayout(layout) {
		if (layout=="") { layout='The Burning Crusade'; }
		var oLink = document.createElement("link")
		oLink.href = 'new-hp/templates/Forum ' + layout + "/layout.css";
		oLink.rel = "stylesheet";
		oLink.type = "text/css";
		document.body.appendChild(oLink);
		if (is_ie) { 
			var eoLink = document.createElement("link")
			eoLink.href = 'new-hp/templates/Forum ' + layout + "/layout_ie.css";
			eoLink.rel = "stylesheet";
			eoLink.type = "text/css";
			document.body.appendChild(eoLink);
		}
		setCookie("FORUM_SKIN", layout, now);
	}
	
</script>
<style>
.index-spacer { height: 0px; }
.tcg { height: 134px; width: 595px; background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/udtcg.gif') no-repeat; margin: -20px auto; }
.tcg p { padding: 48px 0 0 155px; }

/*\ Account Options \*/
/*_________________________________________________________________________*/

#post .options-box h1 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/login-account.gif') no-repeat; }
#post .options-email h2 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/options-email.gif') no-repeat; }
#post .options-basic h3 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/options-timezone.gif') no-repeat; }
#post .options-basic h4 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/options-talents.gif') no-repeat; }
#post .message-top h5 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/options-signature.gif') no-repeat; }
.options-title { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/options-title.gif') no-repeat; }


/*\ Login Page \*/
/*_________________________________________________________________________*/

.login-title { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/login-title.gif') no-repeat; }
#login-page h4 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/login-account.gif') no-repeat; }
#login-page h5 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/login-password.gif') no-repeat; }
a.quickadmin { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/icon-admin.gif') no-repeat 0 0; }


/*\ Forum Selector \*/
/*_________________________________________________________________________*/

#forumHead .list { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/header-blank.gif') no-repeat 0 16px;  }


/*\ Post Topic / Reply \*/
/*_________________________________________________________________________*/

.post-title { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/post-title.gif') no-repeat; }
.post-title2 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/post-title.gif') no-repeat; }
#post h1 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/post-subject.gif') no-repeat; }
#post h2 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/post-message.gif') no-repeat; }
#admin-container h1 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/title-admin.gif') no-repeat; }
#post li.bold { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-bold.gif') no-repeat; }
#post li.italic { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-italic.gif') no-repeat; }
#post li.underline { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-underline.gif') no-repeat; }
#post li.list { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-list.gif') no-repeat; }
#post li.tabbed-list { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/button-tabbed-list.gif') no-repeat; }
#post li.hr { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-hr.gif') no-repeat; }
#post li.pre { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-pre.gif') no-repeat; }
#post li.quote { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-quote.gif') no-repeat; }
.char-admin-tools { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/account-tools.gif') no-repeat; }

/*\ Theme Switcher \*/
/*_________________________________________________________________________*/

h1.theme-title { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/theme-select-banner.gif') no-repeat; }

/*\ Language Switcher \*/
/*_________________________________________________________________________*/
h1.language-title { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/language-select-banner.gif') no-repeat; }


/*\ Quick Search \*/
/*_________________________________________________________________________*/


img#forum-menu-quicksearch { left: 203px; }
#search div.advanced-search { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/forum-menu-advanced-search.gif') no-repeat 0 0; left: 288px; }
#search div.advanced-search a:link, #search div.advanced-search a:active, #search div.advanced-search a:visited { background:  transparent; }
#search div.advanced-search a:hover { background:url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/forum-menu-advanced-search.gif') no-repeat 0 -17px; }


/*  Polls */
/*_________________________________________________________________________*/

.poll-date { top:0; left:5px; }
.deco-frame h2 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/poll.gif') no-repeat; }
.poll-footer input, a.vote-link { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-vote.gif') no-repeat !important; }
a.result { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-results.gif') no-repeat; }
a.result-inactive { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-results-inactive.gif') no-repeat; }
a.vote-link-inactive, .vote-inactive { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-vote-inactive.gif') no-repeat; }
.df h3 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/poll-results.gif') no-repeat; }


/*\ Error Handling \*/
/*_________________________________________________________________________*/

a.redirect, a.redirect:active, a.redirect:visited { display: block; background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-clickhere.gif') no-repeat; height: 36px; width: 200px; margin: 10px auto; }
a.redirect:hover { background-position: 0 -36px; }
</style>
<?php
topnav();
?>
<script language = "javascript">
<?php
if ($_COOKIE['FORUM_SKIN']!='' AND $_COOKIE['FORUM_SKIN']!='null') {
	echo "changelayout('".$_COOKIE['FORUM_SKIN']."');";
} else {
	echo "changelayout('The Burning Crusade');";
}
?>
</script>
<map id="blizzmap" name="blizzlogo_Map">
	<area shape="rect" href="http://www.blizzard.com" alt="Blizzard Entertainment" coords="6,49,74,84" />
</map>
<map id="wowmap" name="wowlogo_Map">

	<area shape="poly" href="?" alt="World of Warcraft" coords="145,77, 162,52, 167,49, 170,41, 177,34, 204,34, 212,19, 208,15, 209,11, 275,11, 289,6, 305,6, 320,12, 383,12, 376,19, 385,31, 386,36, 403,33, 413,35, 415,40, 421,42, 422,49, 435,60, 442,78, 432,103, 418,112, 168,112, 158,102" />
</map>

<div id="shared_topnav" class="tn_forums"><script src="/js/buildtopnav.js"></script></div>

<a name="top"></a>

<!-- headers/links -->

<div id="header">
	<div class="logo-container">
		<div class="logo-right">

			<h1 class="wow-logo"><a href="?"><img src="new-hp/images/pixel.gif" border="0" alt="World Of Warcraft" title="World Of Warcraft" width="262" height="106" /></a></h1>
		</div>
	</div>
</div>
<div class="gryph-container">
	<div class="gryph-z">
		<span class="left-gryphon"></span>
		<span class="right-gryphon"></span>
	</div>
<!--[if lte IE 6]>
<img src="new-hp/images/pixel.gif" border="0" width="775" height="1" alt="" />
<![endif]-->

</div>
<div id="style-switcher">
	<div class="switcher-container">
		<h1 class="theme-title"></h1>
		<ul>
			<li class="alliance"><a href="javascript:changelayout('Alliance');"><img src="new-hp/images/pixel.gif" height=" 25" width="30" border="0" title="Select Alliance Theme" alt="alliance" /></a></li>
			<li class="bc"><a href="javascript:changelayout('The Burning Crusade');"><img src="new-hp/images/pixel.gif" height=" 25" width="30" border="0" title="Select Burning Crusade Theme" alt="burningcrusade" /></a></li>
			<li class="horde"><a href="javascript:changelayout('Horde');"><img src="new-hp/images/pixel.gif" height=" 25" width="30" border="0" title="Select Horde Theme" alt="horde" /></a></li>
			<!--<li class="xmas"><a href="#X-Mas" onClick="setActiveStyleSheet('xmas', 1);return false;"><img src="new-hp/images/pixel.gif" height=" 25" width="30" border="0" title="Select Winter's Veil Theme" alt="christmas" /></a></li>-->
			

		</ul>
	</div>
</div>
<div class="drop-shadow"></div>
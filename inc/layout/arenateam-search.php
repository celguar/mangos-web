<?php
include "head.php"
?>
<div class="list">
<div class="full-list">
<div class="tip" style="clear: left;">
<table>
<tr>
<td class="tip-top-left"></td><td class="tip-top"></td><td class="tip-top-right"></td>
</tr>
<tr>
<td class="tip-left"></td><td class="tip-bg">
<div class="profile-wrapper">
<blockquote>
<b class="iarenateams">
<h4>
<a href="arenateam-search.php">Arena Team Profiles</a>
</h4>
<h3>Arena Team Search</h3>
</b>
</blockquote>
<ul class="heading">
<img class="ieimg" src="images/pixel.gif"><li class="hleft"></li>
<li class="hcont">
<div class="generic-title">
<h1>Search for Arena Team Profiles:</h1>
</div>
</li>
<li class="hright"></li>
</ul>
<form action="index.php" method="get" name="formSearchArenaTeams" onsubmit="javascript: return menuCheckLength(document.formSearchArenaTeams);">
<div id="formSearchArenaTeams_errorSearchLength" style="position: relative; left: 150px; top: 150px; white-space: nowrap;"></div>
<p class="scroll-padding"></p>
<div class="scroll">
<div class="scroll-top">
<div class="scroll-bot">
<div class="scroll-right">
<div class="scroll-left">
<div class="scroll-bot-right">
<div class="scroll-bot-left">
<div class="scroll-top-right">
<div class="scroll-top-left">
<div class="header-tp">
<span>Arena Team Profile</span>
</div>
<table class="scroll-content">
<tr>
<td><a class="title-tn"><!--<span></span>--></a></td><td><input maxlength="72" name="searchQuery" onblur="if (this.value=='') this.value='Enter Team Name'" onfocus="this.value=''" size="16" type="text" value="Enter Arena Team Name"></td><td class="srch"><a class="scroll-search" onClick="javascript: return menuCheckLength(document.formSearchArenaTeams);"><!--<span>Search</span>--></a></td>
</tr>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<input name="searchType" type="hidden" value="arenateams">
</form>
</div>
</td><td class="tip-right"></td>
</tr>
<tr>
<td class="tip-bot-left"></td><td class="tip-bot"></td><td class="tip-bot-right"></td>
</tr>
</table>
</div>
</div>
<?php
include "foot.php"
?>
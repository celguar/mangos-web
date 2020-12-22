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
<b class="icharacters">
<h4>
<a href="character-search.php">Character Profiles</a>
</h4>
<h3>Character Search</h3>
</b>
</blockquote>
<ul class="heading">
<img class="ieimg" src="images/pixel.gif"><li class="hleft"></li>
<li class="hcont">
<div class="generic-title">
<h1>Search for Character Profiles:</h1>
</div>
</li>
<li class="hright"></li>
</ul>
<form action="index.php" method="get" name="formSearchCharacter" onsubmit="javascript: return menuCheckLength(document.formSearchCharacter);">
<div id="formSearchCharacter_errorSearchLength" style="position: relative; left: 150px; top: 150px; white-space: nowrap;"></div>
<input name="searchType" type="hidden" value="characters">
<p class="scroll-padding"></p>
<div class="scroll">
<div class="scroll-bot">
<div class="scroll-top">
<div class="scroll-right">
<div class="scroll-left">
<div class="scroll-bot-right">
<div class="scroll-bot-left">
<div class="scroll-top-right">
<div class="scroll-top-left">
<div class="header-cp">
<span>Character Profile</span>
</div>
<table class="scroll-content">
<tr>
<td><a class="title-cn"><!--<span>Character Name</span>--></a></td><td><input maxlength="72" name="searchQuery" onblur="if (this.value=='') this.value='Enter Character Name'" onfocus="this.value=''" size="16" type="text" value="Enter Character Name"></td><td class="srch"><a class="scroll-search" onClick="javascript: return menuCheckLength(document.formSearchCharacter);"><!--<span>Search</span>--></a></td>
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
</div>
<?php
include "foot.php"
?>
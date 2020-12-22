<?php
if(!defined('Armory'))
{
	header('Location: ../arenateam-search.php');
	exit();
}
?>
<script type="text/javascript">
	rightSideImage = "arena";
	changeRightSideImage(rightSideImage);
</script>
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
<a href="index.php">Search The Armory</a>
</h4>
<h3>Arena Teams</h3>
</b>
</blockquote>
<?php
if(isset($_GET["searchQuery"]))
{
	$currentSearchString = $_GET["searchQuery"];
	$o->setobvar("AFTER_BODYTAG", "onLoad=\"showResult('?searchQuery=".urlencode($currentSearchString)."','source/ajax/ajax-arenalist-getresults.php')\"");
}
else
	$currentSearchString = "";
?>
<div id="ajaxResult">
<span class="csearch-results-info">Results for your search will be displayed here.</span>
</div>
</td><td class="tip-right"></td>
</tr>
<tr>
<td class="tip-bot-left"></td><td class="tip-bot"></td><td class="tip-bot-right"></td>
</tr>
</table>
</div>
</div>
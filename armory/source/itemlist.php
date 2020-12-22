<?php
if(!defined('Armory'))
{
	header('Location: ../item-search.php');
	exit();
}
?>
<script type="text/javascript">
	rightSideImage = "item";
	changeRightSideImage(rightSideImage);
</script>
<div class="list">
<div class="full-list">
<div class="tip" style="clear: left;z-index: 99;">
<table>
<tr>
<td class="tip-top-left"></td><td class="tip-top"></td><td class="tip-top-right"></td>
</tr>
<tr>
<td class="tip-left"></td><td class="tip-bg">
<div class="profile-wrapper">
<blockquote>
<b class="iitems">
<h4>
<a href="index.php">Search The Armory</a>
</h4>
<h3>All Items</h3>
</b>
</blockquote>
<?php
if(isset($_GET["searchQuery"]))
{
	$CurrentSearchString = $_GET["searchQuery"];
	$o->setobvar("AFTER_BODYTAG", "onLoad=\"showResult('?searchQuery=".urlencode($CurrentSearchString)."', 'source/ajax/ajax-items-getresults.php')\"");
}
else
	$CurrentSearchString = "";
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
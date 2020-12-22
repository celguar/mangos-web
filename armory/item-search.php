<?php
include "head.php"
?>
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
<a href="item-search.php">Item Lookup</a>
</h4>
<h3>Item Search</h3>
</b>
</blockquote>
<div class="generic-wrapper">
<div class="generic-right">
<div class="genericHeader">
<p class="items-icon"></p>
<div class="item-title"></div>
<form action="index.php" id="formItem" method="get" name="formItem" onSubmit="javascript: return menuCheckLength(document.formSearchItem);">
<div class="detail-search">
<div class="detail-search-top">
<div id="parentItemName"></div>
<div class="filter-left">
<div id="parentSource"></div>
<div id="parentSourceSub1"></div>
</div>
<div class="filter-right">
<div id="parentItemType"></div>
<div id="parentSingle"></div>
</div>
<div class="multi-filter">
<div id="parentMultiple"></div>
<div id="parentComplex"></div>
</div>
</div>
</div>
<div class="detail-search-bot"></div>
<div class="button-row">
<a class="button-red" href="javascript: submitForm();">
<p>Search</p>Search</a><span class="shrb"></span>
</div>
<div class="item-errors" id="showHideError" style="display:none; ">
<div class="insert-error">
<em></em><span id="replaceError"></span>
</div>
</div>
<div class="item-errors" id="showHideError2" style="display:none; ">
<div class="insert-error">
<em></em><span id="replaceError2"></span>
</div>
</div>
<input name="searchType" type="hidden" value="items">
</form>
<form id="formPhantom" style="display: none; ">
<div id="divDelete"></div>
<div class="showFilter" id="divMultiple">
<span class="shr"></span>
</div>
<div class="filter-container" id="childItemName">
<div class="option-cont">Item Name:</div>
<div class="input-cont" id="divSearchQuery">
<input id="searchQuery" name="searchQuery" type="text">
</div>
</div>
</form>
<script src="js/items/functions.js" type="text/javascript"></script><script type="text/javascript">


  theCurrentForm = "default";

  cloneDelete('childItemName', 'parentItemName');
  cloneDelete('childItemType', 'parentItemType');
  cloneDelete('childSource', 'parentSource');  
  
var currentAdvOpt = "";  
var theCounter = 0;

  document.getElementById('parentAdvancedFilters').appendChild(document.getElementById('childAdvOptionsWeapon'));		

  /* prepopulate the form */

  changetype('all');



  var advOptArray = new Array;




	for (y = 0; y < advOptArray.length; y++) {
		theString = advOptArray[y];
		theString = theString.split("_");
		addPredefinedAdvOpt(theString[0], theString);
	}

theCounter = 0;
searchText="black"
document.getElementById('searchQuery').value = "";

</script>
</div>
</div>
</div>
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
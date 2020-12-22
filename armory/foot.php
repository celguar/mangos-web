</div>
<script type="text/javascript">
var blah = new Array(); var i = 0;

	blah[i] = "<h1>Latest News:</h1> This is news one! Change in foot.php!"; i++;

	blah[i] = "<h1>Latest News:</h1> This is news two! Change in foot.php!"; i++;

	blah[i] = "<h1>Latest News:</h1> This is news three! Change in foot.php!"; i++;

	i = Math.round(Math.random()*100)%i;
	document.getElementById('rDivNews').innerHTML = blah[i];
	rightSideImage = "general";
	changeRightSideImage(rightSideImage);

function setArmorySearchFocus() {
document.formSearch.armorySearch.focus();
}

window.onload = setArmorySearchFocus;

</script>
</div>
</div>
</div>
</div>
<div class="tooltip" id="tooltipcontainer" onmouseout="hideTip();">
<div id="tool1container">
<table>
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"><q></q></td><td class="bg">
<div id="toolBox">TEST</div>
</td><td class="r"><q></q></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
</div>
<table id="tool2container" style="float:left; display:none; margin-top: 10px;">
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"><q></q></td><td class="bg">
<div id="toolBox_two">TEST</div>
</td><td class="r"><q></q></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
<table id="tool3container" style="float:left; display:none; margin-top: 10px;">
<tr>
<td class="tl"></td><td class="t"></td><td class="tr"></td>
</tr>
<tr>
<td class="l"><q></q></td><td class="bg">
<div id="toolBox_three">TEST</div>
</td><td class="r"><q></q></td>
</tr>
<tr>
<td class="bl"></td><td class="b"></td><td class="br"></td>
</tr>
</table>
</div>
</div>
<div class="footerplate">
<a href="index.php"></a>
</div>
<div class="copyright">MBA project leader - SUPERGADGET<br>2008-2009</div>
</td><td class="section-general" id="imageRight" width="50%"></td>
</tr>
</table>
<div id="output"></div>
<script type="text/javascript">
  rightSideImageReady=1;
  if(rightSideImage)
	changeRightSideImage(rightSideImage);


	var elemt1c = document.getElementById("tool1container");
	var elemttc = document.getElementById("tooltipcontainer");
	var elemt2c = document.getElementById("tool2container");
	var elemt3c = document.getElementById("tool3container");
	var elemtb1 = document.getElementById("toolBox");
	var elemtb2 = document.getElementById("toolBox_two");
	var elemtb3 = document.getElementById("toolBox_three");
	var elemDoc = document.documentElement;

</script><script src="shared/global/menu/en_us/menutree.js" type="text/javascript"></script><script src="shared/global/menu/menu132_com.js" type="text/javascript"></script><script src="js/en_us/menus.js" type="text/javascript"></script><script src="shared/global/third-party/sarissa/0.9.7.6/sarissa.js" type="text/javascript"></script><script src="shared/global/third-party/sarissa/0.9.7.6/sarissa_dhtml.js" type="text/javascript"></script><script src="js/ajaxtooltip.js" type="text/javascript"></script>
</body>
</html>

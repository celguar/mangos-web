<?
if (INCLUDED!==true) { include('index.htm'); exit; }

$forceshow=true;

if ($_REQUEST['lang']=='') { $_REQUEST['lang']=$_COOKIE['SITE_LANG']; }

$textpath = "inc/languages/".$_REQUEST['lang']."/text.".$_REQUEST['t'].".txt";

	if ($_POST['save']=='true') {
		$fhw = @fopen($textpath , "w");
		if ($fhw) {
			if (@fwrite($fhw, $_POST['newstext'])) {
				goodborder('Changes successfuly applied.');
			} else {
				errborder('Could not apply new changes.');
			}
		} else {
			errborder('Could not use file.');
		}
		@fclose($fhw);
	}

if ($forceshow==true) {

	
	
?>
<form method=post action="index.php?n=admin.text&t=<?php echo $_REQUEST['t']; ?>" name="texts" onsubmit='return fas_valid()'>
<script language="javascript">
function fas_valid() {
	void(document.texts.save.value="true");
	return true;
}
</script>
	<input type=hidden name="save">
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Edit Text Dialog:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <?php bbcode_toolbar('texts.newstext'); ?>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right valign=top>
		  <font face="arial,helvetica" size=-1><span><b>
		  Language: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="textlang" onchange="javascript:window.location='?n=admin.text&t=<?php echo $_REQUEST['t']; ?>&lang=' + this.value">
		  <?
			for ($i=0; $i<count($_LANG['LANG']['FOLDER']);$i++) {
					echo '<option value="'.$_LANG['LANG']['FOLDER'][$i].'">'.$_LANG['LANG']['LARGE_TAG_LIST'][$i];
			}
		  ?>
		  </select>
		  <script>
		  document.texts.textlang.value = '<?php echo $_REQUEST['lang']; ?>';
		  </script>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right valign=top>
		  <font face="arial,helvetica" size=-1><span><b>
		  Message: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <textarea name="newstext"  style="overflow: auto; width: 350px; height: 500px; display: block;"><?php
		  $fh = @fopen($textpath , "r");
		  echo @fread($fh, filesize($textpath));
		  @fclose($fh);
		  ?></textarea>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>
		<div align=center><a href="index.php?n=admin"><img SRC="shared/wow-com/images/buttons/button-back.gif"></a><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>
		
</form>
		
<?
}
?>
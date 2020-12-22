<?
if (INCLUDED!==true) { include('index.htm'); exit; }

?>
<style>
select.icon-menu option {
	background-repeat: no-repeat;
	background-position: center left;
	padding-left: 60px;
	padding-bottom: 40px;
}
</style>
<?php

switch($_REQUEST['t']) {
	
	case "add": /////////////////////////////////////////////////ADD
	
	$forceshow=true;
	
	if ($_POST['save']=='true') {

	$dbquery = mysql_query("INSERT INTO web_misc (title,text,urls,image) VALUES('".$_POST['title']."','".$_POST['newstext']."','".$_POST['newurls']."','".$_POST['newicon']."')");

		$forceshow=false;
	
		if ($dbquery) {
			newrssfeed();
			goodborder('Miscellaneous Successfully Added.');
			echo '<META HTTP-EQUIV=REFRESH CONTENT="1; URL=index.php?n=admin.misc">';
		} else {
			$forceshow=true;
			errborder('MySQL Error: '.mysql_error());	
		}

	}		
	
if ($forceshow==true) {
	remslashall();		
?>
<form method=post action="index.php?n=admin.misc&l=news&t=add" name="addnew" onsubmit='return fas_valid()'>
<script language="javascript">
function fas_valid() {
	void(document.addnew.save.value="true");
	return true;
}
</script>
	<input type=hidden name="save">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Add Miscellaneous:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Title:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input type=text name='wtitle' value='<?php echo $row2['title']; ?>' maxlength=200 size=30>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right valign=top>
		  <font face="arial,helvetica" size=-1><span><b>
		  Message:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <textarea name="newstext" rows=5 cols=50><?php echo $row2['text']; ?></textarea>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right valign=top>
		  <font face="arial,helvetica" size=-1><span><b>
		  Urls:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <textarea name="newurls" rows=5 cols=50><?php echo $row2['urls']; ?></textarea>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Icon:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name='newicon' style="height:20px;" class="icon-menu" OnChange='javascript:void(document.addnew.newiconex.src="new-hp/images/"
			+ document.addnew.newicon.value)'>
			<?php
				foreach (glob('new-hp/images/misc-*.gif') as $tempname) {
					$tempname = str_replace(dirname($tempname).'/','',$tempname);
					echo '<option value="'.$tempname.'" style="background-image: url(new-hp/images/'.$tempname.');">'.str_replace('misc-', '', $tempname);
				}
			?>
		  </td><td valign = "top"> <img name='newiconex' src='new-hp/images/icon-insider.gif'>
		   </td></tr></table></td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>
		<div align=center><a href="index.php?n=admin.misc&t=manage"><img SRC="shared/wow-com/images/buttons/button-back.gif"></a><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>
		
</form>
		
<?
			}
		break;
		case "edit": /////////////////////////////////////////////////EDIT

	$forceshow=true;
	
	if ($_POST['save']=='true') {

		$dbquery = mysql_query("UPDATE web_misc SET title='".$_POST['wtitle']."', text='".$_POST['newstext']."', urls='".$_POST['newurls']."', image='".$_POST['newicon']."' WHERE id_misc='".$_REQUEST['id']."'");

		$forceshow=false;
	
		if ($dbquery) {
			newrssfeed();
			goodborder('Miscellaneous Successfully Edited.');
			echo '<META HTTP-EQUIV=REFRESH CONTENT="1; URL=index.php?n=admin.misc">';		
		} else {
		$forceshow=true;
		errborder('MySQL Error: '.mysql_error());		
		}
	}		
	
if ($forceshow==true) {

	$query=mysql_query("SELECT * FROM web_misc wc WHERE id_misc='".$_REQUEST['id']."'");
	
	if (mysql_num_rows($query)==1) {

	while ($row2 = mysql_fetch_array($query, MYSQL_ASSOC)) {

	$newtext = $row2['text'];
	$newimage = $row2['image'];
	$newtitle = $row2['title'];
	?>
<form method=post action="index.php?n=admin.misc&l=news&t=edit&id=<? echo $_REQUEST['id']; ?>" name="editnew" onsubmit="return fas_valid();">
<script language="javascript">
function fas_valid() {
	void(document.editnew.save.value="true");
	return true;
}
</script>
	<input type=hidden name="save">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Edit Miscellaneous:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>

	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Title:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input type=text name='wtitle' value='<?php echo $row2['title']; ?>' maxlength=200 size=30>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right valign=top>
		  <font face="arial,helvetica" size=-1><span><b>
		  Message:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <textarea name="newstext" rows=5 cols=50><?php echo $row2['text']; ?></textarea>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right valign=top>
		  <font face="arial,helvetica" size=-1><span><b>
		  Urls:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <textarea name="newurls" rows=5 cols=50><?php echo $row2['urls']; ?></textarea>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Icon:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name='newicon' style="height:20px;" class="icon-menu" OnChange='javascript:void(document.editnew.newiconex.src="new-hp/images/"
			+ document.editnew.newicon.value)'>
			<?php
				foreach (glob('new-hp/images/misc-*.gif') as $tempname) {
					$tempname = str_replace(dirname($tempname).'/','',$tempname);
					echo '<option value="'.$tempname.'" style="background-image: url(new-hp/images/'.$tempname.');">'.str_replace('misc-', '', $tempname);
				}
			?>
			</select>			
		  </td><td valign = "top"> <img name='newiconex' src='new-hp/images/<?php echo $row2['image']; ?>'>
		  <script language="javascript">
			void(document.editnew.newicon.value='<?php echo $row2['image']; ?>');
			void(document.editnew.newiconex.src="new-hp/images/<?php echo $row2['image']; ?>");
		  </script>
		  </td></tr></table></td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>
		<div align=center><a href="index.php?n=admin.misc&t=manage"><img SRC="shared/wow-com/images/buttons/button-back.gif"></a><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>
		
</form>
<?
	break;
	}
} else {
	echo errborder('MySQL Error: '.mysql_error());	
}
}
		break;
		case "remove": /////////////////////////////////////////////////REMOVE

		$query=mysql_query("DELETE FROM web_misc WHERE id_misc='".$_REQUEST['id']."'");
		
		if ($query) {
			newrssfeed();
			goodborder('Miscellaneous Successfully Removed.');

		} else {
			errborder('MySQL Error: '.mysql_error());
		}
		echo '<META HTTP-EQUIV=REFRESH CONTENT="1; URL=index.php?n=admin.misc">'; 
		
		break;
		default: /////////////////////////////////////////////////ELSE
		
?><form name="siteadmin" method=post action="index.php?n=admin.misc" >
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Search For Miscellaneous:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>


	<table border=0 cellspacing=0 cellpadding=4>

	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Miscellaneous Title/Text:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input type=text size=30 name="s" value="<? echo $_POST['s']; ?>">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>
		<div align=center>
<script language="javascript">
function searchaccount() {
	if (document.siteadmin.s.value.length>0 && document.siteadmin.s.value.length<3) {
		alert('Account Name length must be at least 3 characters.');
		return false;
	} else {
		return true;
	}
}
</script>
<input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" onclick="return searchaccount();">

		</div>
		</form>
<?php

parchdown();

parchup(true);

subtitle('Miscellaneous');

$query="SELECT * FROM web_misc wm";
if ($_POST['s']!='') { $query .= " WHERE LOWER(title) LIKE LOWER('%".$_POST['s']."%') or LOWER(text) LIKE LOWER('%".$_POST['s']."%') or LOWER(urls) LIKE LOWER('%".$_POST['s']."%')"; } unset($_POST['s']);
$query.=" ORDER BY id_misc DESC";
$query=mysql_query($query);

if (mysql_num_rows($query)>0) {

?>
<table border="0" cellpadding="0" cellspacing="0">	
<?php

$i=1;
while ($row2 = mysql_fetch_array($query, MYSQL_ASSOC)) {

$newid = $row2['id_misc'];
$newdesc = $row2['text'];
$newtext = bbcode($row2['urls']);
$newimage = bbcode($row2['image']);
$newtitle = $row2['title'];
?>
<tr>
<td>
 <div class="container-misc">
	<div class="miscBox1 left">
		<div class="miscBox-top">
			<h4> <?php echo $newtitle; ?></h4>

		</div>
		<table>
			<tr>
				<td align=center valign=top>
			<img alt="image-miscbox1" class="left" height="50" src="new-hp/images/<?php echo $newimage; ?>" width="54"/>
			</td>
			<td valign=top>
			<font size=2px><?php echo $newdesc; ?></font><?php if ($newdesc!="") echo "<br><img src='new-hp/images/pixel.gif' width=7>" ?>
			<ul class="bullet-list">
			<?php 
			$ss = explode("\r", $newtext);
			for ($i=0;$i<count($ss);$i++) {
				echo '<li>'.$ss[$i].'</li>';
			}			
			?>
			</ul>
			</span>
			</td><tr>
		</table><br>
	</div>
<div>
</td>
<td valign=top width=5><a href="index.php?n=admin.misc&t=edit&id=<?php echo $newid;?>"><img src="new-hp/images/v2/edit.gif"></a>
</td>
<td valign=top width=5><a href="index.php?n=admin.misc&t=remove&id=<?php echo $newid;?>"><img src="new-hp/images/v2/remove.gif"></a>
</td>
</tr>
<?
$i +=1;
}

?>
</table>
<?php
} else {
	errborder('No community spotlights were found.');
}


		break;
}
?>
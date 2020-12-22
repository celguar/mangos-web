<?php

if (INCLUDED!==true) { include('index.htm'); exit; }
?>
<style>
select.icon-menu option {
	background-repeat: no-repeat;
	background-position: center left;
	padding-left: 40px;
	padding-bottom: 30px;
}
</style>
<?php
$USER_LEVEL['-1'] = 'Any User';
$USER_LEVEL['4'] = 'Owner';

	$forceshow=true;
			
	if ($_POST['update']=='settings') {
			
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wenableforums']."' WHERE setting='forum_enabled'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wusereditownposts']."' WHERE setting='user_edit_own_posts'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wuserremoveownposts']."' WHERE setting='user_remove_own_posts'");
			
		if ($query) {
						
			goodborder($_LANG['SUCCESS']['ADMIN_SET']);
			$forceshow=false;
			
		} else {		
				$haserrors .= mysql_error();
		}
		
	} else if ($_POST['update']=='add') {
		
		if ($_POST['viewlevel'] > $_POST['postlevel']) { $_POST['postlevel'] = $_POST['viewlevel']; }
	
		$rowi = mysql_fetch_array(mysql_query('SELECT `ordenation` FROM forums ORDER BY `ordenation` DESC LIMIT 0, 1'));
		$query = mysql_query('INSERT INTO forums(title,postlevel,viewlevel,description,`group`,image,ordenation,categorized) VALUES(
		"'.$_POST['wtitle'].'","'.$_POST['postlevel'].'","'.$_POST['viewlevel'].'","'.$_POST['wdescription'].'", "'.$_POST['fgroup'].'",
		"'.$_POST['newicon'].'", "'.($rowi['ordenation']+1).'", "'.$_POST['fcat'].'")')or die (mysql_error());
			
		if($query) {
			goodborder("Forum Successfuly Added!<META HTTP-EQUIV=REFRESH CONTENT='2; URL=index.php?n=admin.forums&t=manage'>");
			$forceshow=false;
			
		} else {		
			$haserrors .= 'Cannot save the settings!';
		}	
	
	} else if ($_POST['update']=='edit') {

		if ($_POST['viewlevel'] > $_POST['postlevel']) { $_POST['postlevel'] = $_POST['viewlevel']; }
	
		$query = mysql_query('UPDATE forums SET title="'.$_POST['wtitle'].'",postlevel="'.$_POST['postlevel'].'",
		viewlevel="'.$_POST['viewlevel'].'",description="'.$_POST['wdescription'].'", `group`="'.$_POST['fgroup'].'",
		image="'.$_POST['newicon'].'",categorized="'.$_POST['fcat'].'" WHERE id_forum="'.$_REQUEST['id'].'" AND postlevel <= "'.$userlevel.'"')or die (mysql_error());
			
		if($query) {
			goodborder("Forum Successfuly Edited!<META HTTP-EQUIV=REFRESH CONTENT='2; URL=index.php?n=admin.forums&t=manage'>");
			$forceshow=false;
			
		} else {		
			$haserrors .= 'Cannot Update It!';
		}	
	
	} else if ($_POST['update']=='remove') {
		if (mysql_num_rows(mysql_query('SELECT postlevel FROM forums WHERE id_forum="'.$_REQUEST['id'].'" AND postlevel <= "'.$userlevel.'"'))==1) {
		
			if ($_POST['wtopicsdo']=="0" or $_POST['wtopicsdo']=="") {
			
				$query = mysql_query('DELETE FROM forum_topics WHERE id_forum="'.$_REQUEST['id'].'" AND postlevel <= "'.$userlevel.'"')or die (mysql_error());
				$query = mysql_query('DELETE FROM forum_posts WHERE id_topic NOT IN (SELECT id_topic FROM `forum_topics`)')or die (mysql_error());
			
			} else {
			
				$query = mysql_query('UPDATE forum_topics SET id_forum="'.$_POST['wtopicsdo'].'" WHERE id_forum="'.$_REQUEST['id'].'" AND postlevel <= "'.$userlevel.'"')or die (mysql_error());
			
			}
			
			if(!$query) {	
				$haserrors .= 'Couldn\'t remove the selected Forum!';
			}	
			
			$query = mysql_query('DELETE FROM `forums` WHERE id_forum="'.$_REQUEST['id'].'" AND postlevel <= "'.$userlevel.'"')or die (mysql_error());
				
			if($query) {
				goodborder("Forum Successfuly Removed!<META HTTP-EQUIV=REFRESH CONTENT='2; URL=index.php?n=admin.forums&t=manage'>");
				$forceshow=false;
				
			} else {		
				$haserrors .= 'Couldn\'t remove the selected Forum!';
			}
		} else {
			errborder($_LANG['ERROR']['ACESS']);
			$forceshow=false;
		}
	
	}
	
	if ($forceshow==true) {
		
	switch ($_REQUEST['t']) {
		case 'smiles':
		
			if( $_SERVER['REQUEST_METHOD']=='POST') {

				for($i=0;$i<count($_POST['smiletag']);$i++) {
					$smileconf .= $_POST['smilepath'][$i]. '|' . $_POST['smiletag'][$i];
				}
			}
		
			subtitle('Manage Smiles:');

			?>
<form method=post action="index.php?n=admin.forums&t=smiles" name="siteadmin" onsubmit="fas_valid()">
			<?
			metalborderup();
			?>
						<table cellpadding='3' cellspacing='0' width=420>
							<tbody>
							<tr>
								<td class='rankingHeader' align='left' nowrap='nowrap'>&nbsp;</td>
								<td class='rankingHeader' align='left' nowrap='nowrap' width=30%>Tag</td>
								<td class='rankingHeader' align='center' nowrap='nowrap'>File Name</td>
								<td class='rankingHeader' align='left' nowrap='nowrap'><a onmouseover='ddrivetip("Remove")' onmouseout='hideddrivetip()'><img src='new-hp/images/v2/remove.gif'></a></td>
							</tr>
							<tr>
								<td colspan='8' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
								</td>
							</tr>
			<?php 
			$querysm = mysql_query('SELECT * FROM `forum_smiles`');
			$res_color=2;
			$i=0;
			while ($row = mysql_fetch_array($querysm)) {
				if($res_color==1) { $res_color=2; } else { $res_color=1; }
				echo "<tr>
					<td class='serverStatus".$res_color."' align='center'><img name='preimg[]' src='".$row['path']."'></td>
					<td class='serverStatus".$res_color."' align='center'><input type=text name='smiletag[]' value='".$row['id_smile']."'></td>
					<td class='serverStatus".$res_color."' align='center'><input type=text onchange='javascript:document.siteadmin.preimg[".$i."].src=this.value;' name='smilepath[]' value='".$row['path']."'></td>
					<td class='serverStatus".$res_color."' align='center'><input type=checkbox name='smileremove[]'></td>
					</tr>";
				$i++;
			}
			
			?>
							</tbody>
						</table>
			<?php
			metalborderdown();
			
			?><br>
	<div align=center><input type=image SRC="shared/wow-com/images/buttons/update-button.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"></div>
			<?

		break;		
		case 'remove':
		
$query = mysql_query('SELECT * FROM `forums` ft WHERE id_forum="'.$_REQUEST['id'].'"');
		remslashall();
if (mysql_num_rows($query)==1) {
		while ($row=mysql_fetch_array($query)) {
		?>
<form method=post action="index.php?n=admin.forums&t=remove&id=<?php echo $_REQUEST['id']; ?>" name="siteadmin" onsubmit="fas_valid()">
<script language="javascript">
function fas_valid() {
	void(document.siteadmin.update.value="remove");
	return true;
}
</script>
	<input type=hidden name="update">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Remove Forum:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>

	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Title:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <?php echo $row['title']; ?>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Description:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <?php echo $row['description']; ?>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
<?php
$queryb = mysql_query('SELECT id_topic FROM `forum_topics` WHERE id_forum="'.$_REQUEST['id'].'"');
if (mysql_num_rows($queryb)>0) {
?>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Topics And Posts:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
			<select name="wtopicsdo">
			<optgroup label="Remove:">
			<option value=0>Remove All
<?php
$queryb = mysql_query('SELECT id_forum, title FROM `forums` WHERE id_forum!="'.$_REQUEST['id'].'"');
if (mysql_num_rows($queryb)>0) {
?>
			<optgroup label="Move to Forum:">
<?php
	while ($rowa=mysql_fetch_array($queryb)) {
		echo '<option value="'.$rowa['id_forum'].'">'.$rowa['title'];
	}
}
?>
			</select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
<?php
}
?>
	</table>
	</td></tr></table>
	</td></tr></table><br>
		<div align=center><a href="index.php?n=admin.forums&t=manage"><img SRC="shared/wow-com/images/buttons/button-back.gif"></a><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>
		<?php
		break;
		}
		
} else {

	errborder($_LANG['ERROR']['DEFAULT']);

}
		break;
		case 'edit':
		
	$query = mysql_query('SELECT * FROM `forums` ft WHERE id_forum="'.$_REQUEST['id'].'" AND postlevel <= "'.$userlevel.'"') OR DIE(mysql_error());
		remslashall();
if (mysql_num_rows($query)==1) {
		while ($row=mysql_fetch_array($query)) {
		?>
<form method=post action="index.php?n=admin.forums&t=edit&id=<?php echo $_REQUEST['id']; ?>" name="siteadmin" onsubmit="fas_valid()">
<script language="javascript">
function fas_valid() {
	void();
	return true;
}
</script>
	<input type=hidden name="update">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Edit Forum:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>

	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Name:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input type=text name='wtitle' value='<?php echo $row['title']; ?>' maxlength=200 size=30>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  View Level:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		 		<select name="viewlevel" onchange='document.siteadmin.update.value="viewlevel"; document.siteadmin.submit();'>
				<?php
					if (verifylevel($_SESSION['userid']) > 3) { $ulvl = 3; } else { $ulvl=verifylevel($_SESSION['userid']); }
					for ($i=-1;$i<=$ulvl;$i++) {
						echo '<option value="'.$i.'">'.$USER_LEVEL[$i];
					}
				?>
				</select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Post Level:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		 		<select name="postlevel">
				<?php
				if ( alphanum($_POST['viewlevel'],true, false)==false OR $_POST['viewlevel'] < 0 OR $_POST['viewlevel'] == '' ) {
					$postlvl=0;
				} else { 
					$postlvl = $_POST['viewlevel']; 
				}
				for ($i=$postlvl;$i<=verifylevel($_SESSION['userid']);$i++) {
					echo '<option value="'.$i.'">'.$USER_LEVEL[$i];
				}
				?>
				</select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Description:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <textarea name="wdescription" maxlength=200 cols=35 rows=2><?php echo $row['description']; ?></textarea>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		<td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Icon:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
	  <select name='newicon' style="height:20px;" class="icon-menu" OnChange='javascript:void(document.siteadmin.newiconex.src="new-hp/images/forum/forumbullets/"
		+ document.siteadmin.newicon.value)'>
			<?php
				foreach (glob('new-hp/images/forum/forumbullets/*.gif') as $tempname) {
					$tempname = str_replace(dirname($tempname).'/','',$tempname);
					echo '<option value="'.$tempname.'" style="background-image: url(new-hp/images/forum/forumbullets/'.$tempname.');">'.$tempname;
				}
			?>
		</select>
		  </td><td valign = "top">&nbsp;<img name='newiconex' src='new-hp/images/forum/forumbullets/bullet.gif'>
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Group:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="fgroup">
				<?php
					for($i=0;$i<count($FORUM_GROUP);$i++) {
						echo '<option value="'.$i.'">'.$FORUM_GROUP[$i].'</option>';
					}
				?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Is Categorized:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="fcat">
			<option value="1">Yes
			<option value="0" SELECTED>No
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>
		<script language="javascript">
		void(document.siteadmin.newicon.value='<?php echo $row['image']; ?>');
		void(document.siteadmin.fgroup.value='<?php echo $row['group']; ?>');
		void(document.siteadmin.fcat.value='<?php echo $row['categorized']; ?>');
		void(document.siteadmin.newiconex.src='new-hp/images/forum/forumbullets/<?php echo $row['image']; ?>');
		document.siteadmin.viewlevel.value = '<?php if ($_POST['viewlevel']!='') { echo $_POST['viewlevel']; } else {  echo $row['viewlevel']; } ?>';
		document.siteadmin.postlevel.value = '<?php if ($_POST['viewlevel']!='') { echo $_POST['postlevel']; } else { echo $row['postlevel']; } ?>';
		void(document.siteadmin.wisblocked.value='<?php echo $row['isblocked'];?>');
		</script>
		<div align=center><a href="index.php?n=admin.forums&t=manage"><img SRC="shared/wow-com/images/buttons/button-back.gif"></a><input onclick="document.siteadmin.update.value='edit'" type=image SRC="shared/wow-com/images/buttons/update-button.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>
		<?php
		break;
		}
		
} else {

	errborder('Forum non-existent or you require higher priviledges to access it.');

}
		break;
		case "settings":

			?>				
<form method=post action="index.php?n=admin.forums&t=settings" name="siteadmin" onsubmit="fas_valid()">
<script language="javascript">

function fas_valid() {
	void(document.siteadmin.update.value="settings");
	return true;
}
</script>
	<input type=hidden name="update">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Forums Settings:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>

	<tr>
		  <td width=45% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Enable Forums:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="wenableforums"><option value=1>Yes<option value=0>No</select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Edit Own Forum Posts:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="wusereditownposts"><option value=0>No<option value=1 SELECTED>Yes<option value=2 >Only Last Replies
		  </td><td valign = "top"><small>&nbsp;(Only for Normal Users)
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Remove Own Forum Posts:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="wuserremoveownposts"><option value=0>No<option value=1 SELECTED>Yes<option value=2 >Only Last Replies
		  </td><td valign = "top"><small>&nbsp;(Only for Normal Users)
		   </td></tr></table></td>
	</tr>
	</table>
<script language="javascript">
void(document.siteadmin.wenableforums.value='<?php echo $SETTING['FORUM_ENABLED'];?>');
void(document.siteadmin.wusereditownposts.value='<?php echo $SETTING['FORUM_EDIT_OWN_POSTS'];?>');
void(document.siteadmin.wuserremoveownposts.value='<?php echo $SETTING['FORUM_REMOVE_OWN_POSTS'];?>');
void(document.siteadmin.wenablepm.value='<?php echo $SETTING['FORUM_ENABLE_PM'];?>');
void(document.siteadmin.wenableusersig.value='<?php echo $SETTING['FORUM_ENABLE_SIGNATURE'];?>');
void(document.siteadmin.needlogin.value='<?php echo $SETTING['FORUM_NEED_LOGIN'];?>');
</script>
	</td></tr></table>
	</td></tr></table><br>
		
		<div align=center><input type=image SRC="shared/wow-com/images/buttons/update-button.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>
<?php
	break;
	case "add":
		remslashall();	?>				
<form method=post action="index.php?n=admin.forums&t=add" name="siteadmin" onsubmit="fas_valid()">
<script language="javascript">

function fas_valid() {
	void(document.siteadmin.update.value="add");
	return true;
}
</script>
	<input type=hidden name="update">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Add Forum:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>

	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Name:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input type=text name='wtitle' maxlength=200 size=30 value="<? echo $_POST['wtitle'] ?>">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  View Level:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		 		<select name="viewlevel" onchange='document.siteadmin.update.value="viewlevel"; document.siteadmin.submit();'>
				<?php
					if (verifylevel($_SESSION['userid']) > 3) { $ulvl = 3; } else { $ulvl=verifylevel($_SESSION['userid']); }
					for ($i=-1;$i<=$ulvl;$i++) {
						echo '<option value="'.$i.'">'.$USER_LEVEL[$i];
					}
				?>
				</select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Post Level:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		 		<select name="postlevel">
				<?php
				if ( alphanum($_POST['viewlevel'],true, false)==false OR $_POST['viewlevel'] < 0 OR $_POST['viewlevel'] == '' ) {
					$postlvl=0;
				} else { 
					$postlvl = $_POST['viewlevel']; 
				}
				for ($i=$postlvl;$i<=verifylevel($_SESSION['userid']);$i++) {
					echo '<option value="'.$i.'">'.$USER_LEVEL[$i];
				}
				?>
				</select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Description:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <textarea name="wdescription" maxlength=200 cols=35 rows=2><? echo $_POST['wdescription']; ?></textarea>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Icon:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		<select name='newicon'  style="height:20px;" class="icon-menu" OnChange='javascript:void(document.siteadmin.newiconex.src="new-hp/images/forum/forumbullets/"
		+ document.siteadmin.newicon.value)'>
			<?php
				foreach (glob('new-hp/images/forum/forumbullets/*.gif') as $tempname) {
					$tempname = str_replace(dirname($tempname).'/','',$tempname);
					echo '<option value="'.$tempname.'" style="background-image: url(new-hp/images/forum/forumbullets/'.$tempname.');">'.$tempname;
				}
			?>
		</select>
		  </td><td valign = "top">&nbsp;<img name='newiconex' src='new-hp/images/forum/forumbullets/bullet.gif'>
		   </td></tr></table></td>
	</tr>
			<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Group:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="fgroup">
				<?php
					for($i=0;$i<count($FORUM_GROUP);$i++) {
						echo '<option value="'.$i.'">'.$FORUM_GROUP[$i].'</option>';
					}
				?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Is Categorized:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="fcat">
			<option value="1">Yes
			<option value="0" SELECTED>No
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>
<script language="javascript">
<?php if ($_SERVER['REQUEST_METHOD']!='POST') { ?>
	void(document.siteadmin.newicon.value='bullet.gif');
	void(document.siteadmin.fgroup.value='0');
	void(document.siteadmin.newiconex.src='new-hp/images/forum/forumbullets/bullet.gif');
<? } else { ?>
	void(document.siteadmin.newicon.value='<? echo $_POST['newicon']; ?>');
	void(document.siteadmin.fgroup.value='<? echo $_POST['fgroup']; ?>');
	void(document.siteadmin.newiconex.src='new-hp/images/forum/forumbullets/'+document.siteadmin.newicon.value);
<? } ?>
	document.siteadmin.viewlevel.value = '<?php if ($_POST['viewlevel']!='') { echo $_POST['viewlevel']; } else { echo '-1'; } ?>';
	document.siteadmin.postlevel.value = '<?php if ($_POST['viewlevel']!='') { echo $_POST['postlevel']; } else { echo '0'; } ?>';
</script>
	</td></tr></table>
	</td></tr></table><br>
		
		<div align=center><a href="index.php?n=admin.forums&t=manage"><img SRC="shared/wow-com/images/buttons/button-back.gif"></a><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>
<?php
	break;
	case "reports":
	
?>
<div style='cursor: auto;' id='dataElement'>
<span>
<?php
subtitle('Forums Reports:');

if ($_REQUEST['id']!='') { @mysql_query("DELETE FROM `forum_reports` WHERE id_report='".$_REQUEST['id']."'"); }

$newquery = mysql_query("SELECT *, fp.id_topic as id_topic, a.username as id_account, fp.isreply as isreply FROM `forum_reports` fr 
						INNER JOIN `account` a ON a.id = fr.id_account
						INNER JOIN `forum_posts` fp ON fr.id_post = fp.id_post") or die (mysql_error());

if (mysql_num_rows($newquery)>0) {

metalborderup();
?>
			<table cellpadding='3' cellspacing='0' width=450>
				<tbody>
				<tr>
					<td class='rankingHeader' align='left' nowrap='nowrap'>#</td>
					<td class='rankingHeader' align='center' nowrap='nowrap'>Post</td>
					<td class='rankingHeader' align='center' nowrap='nowrap'width=70%>Reason</td>
					<td class='rankingHeader' align='center' nowrap='nowrap'width=30%>By</td>
					<td class='rankingHeader' align='center' nowrap='nowrap'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan='8' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
					</td>
				</tr>
<?php 

$res_color=2;
$i=0;
while($rowa = mysql_fetch_array($newquery)) {
	$i++;
	if($res_color==1) { $res_color=2; } else { $res_color=1; }
	if ($rowa['isreply']=='0') { $type='topic'; } else { $type='post'; }
	echo "<tr>
		<td class='serverStatus".$res_color."' align='center'><span style='color: rgb(102, 13, 2);'>".$rowa['id_report']."</td>
		<td class='serverStatus".$res_color."' align='center'><span style='color: rgb(102, 13, 2);'><a href='?n=forums&t=".$rowa['id_topic']."&r=".$rowa['id_post']."&".$type."=edit' target='_blanc'>View</a></span>
		<td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);'>".$rowa['reason']."</span><br><span style='color: rgb(35, 67, 3);'>".$rowa['description']."</span></td>
		<td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);'>".$rowa['id_account']."</span>
		<td class='serverStatus".$res_color."' align='center'><a onmouseover='ddrivetip(\"Remove\")' onmouseout='hideddrivetip()' href='index.php?n=admin.forums&t=reports&id=".$rowa['id_report']."'><img src='new-hp/images/v2/remove.gif'></a></td>
	</tr>";
				
}

?>
				</tbody>
			</table>
<?php
metalborderdown();
?>
</span>
</div>
<?
} else {
	goodborder('No Report Exists.');
}

	break;
	default:
	
		if ($_REQUEST['ord']!='' AND $_REQUEST['id']!='' AND alphanum($_REQUEST['id'],true,false)==true) {
			
			if 	($_REQUEST['ord']=='up') {
				$row = mysql_fetch_array(mysql_query("SELECT ordenation FROM forums WHERE id_forum='".$_REQUEST['id']."'"));
				$qquery = mysql_query("SELECT id_forum FROM forums WHERE `ordenation`='".($row['ordenation']-1)."' ORDER BY `ordenation` DESC LIMIT 0, 1");
				if (mysql_num_rows ($qquery)>0) {
					$row = mysql_fetch_array($qquery);
					mysql_query("UPDATE forums SET `ordenation`=`ordenation`+1 WHERE id_forum='".$row['id_forum']."'");
					mysql_query("UPDATE forums SET `ordenation`=`ordenation`-1 WHERE id_forum='".$_REQUEST['id']."'");
				}
			} else if ($_REQUEST['ord']=='down') {
				$row = mysql_fetch_array(mysql_query("SELECT ordenation FROM forums WHERE id_forum='".$_REQUEST['id']."'"));
				$qquery = mysql_query("SELECT id_forum FROM forums WHERE `ordenation`='".($row['ordenation']+1)."' ORDER BY `ordenation` DESC LIMIT 0, 1");
				if (mysql_num_rows ($qquery)>0) {
					$row = mysql_fetch_array($qquery);
					mysql_query("UPDATE forums SET `ordenation`=`ordenation`-1 WHERE id_forum='".$row['id_forum']."'");
					mysql_query("UPDATE forums SET `ordenation`=`ordenation`+1 WHERE id_forum='".$_REQUEST['id']."'");
				}
			}
			
		}
		
	?>

<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
	
<div style='cursor: auto;' id='dataElement'>
<span>
<?php
subtitle('Manage Forums:');

metalborderup();
?>
			<table cellpadding='3' cellspacing='0' width=100%>
				<tbody>
				<tr>
					<td class='rankingHeader' align='left' nowrap='nowrap'>&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=70%>Name</td>
					<td class='rankingHeader' align='center' nowrap='nowrap'>Group</td>
					<td class='rankingHeader' align='center' nowrap='nowrap'width=30%>Access Levels</td>
					<td class='rankingHeader' align='center' nowrap='nowrap'>Order</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan='8' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
					</td>
				</tr>
<?php 

$newquery = mysql_query("SELECT * FROM `forums` ft WHERE postlevel <= '".$userlevel."' ORDER BY `ordenation` ASC") or die (mysql_error());

$res_color=2;
$i=0;
while($rowa = mysql_fetch_array($newquery)) {
	$i++;
	if($res_color==1) { $res_color=2; } else { $res_color=1; }
	
	if ($rowa['isblocked']==1) { $rowa['isblocked'] = "Yes"; } else { $rowa['isblocked'] = "No"; }
	
	echo "<tr>
		<td class='serverStatus".$res_color."' align='center'><img src='new-hp/images/forum/forumbullets/".$rowa['image']."'></td>
		<td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);'>".$rowa['title']."</span><br><span style='color: rgb(35, 67, 3);'>".$rowa['description']."</span></td>
		<td class='serverStatus".$res_color."' align='center'><span style='color: rgb(102, 13, 2);'>".$FORUM_GROUP[$rowa['group']];
	if ($rowa['categorized']=='1') { echo "<br>(Categorized)"; }
	echo"</small></td>
		<td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);'>View: ".$USER_LEVEL[$rowa['viewlevel']]."<br>Post: ".$USER_LEVEL[$rowa['postlevel']]."</span></td>
		<td class='serverStatus".$res_color."' align='center'><span style='color: rgb(102, 13, 2);'>";
	if ($i!=1) { echo "<a href='?n=admin.forums&ord=up&id=".$rowa['id_forum']."' onmouseover='ddrivetip(\"Move Up\")' onmouseout='hideddrivetip()'><img src='new-hp/images/forum/arrow-top.gif'></a>"; } else { echo '<img width=17 height=20 src="new-hp/images/pixel.gif">'; }
	echo "<br>";
	if ($i!=mysql_num_rows($newquery)) { echo "<a href='?n=admin.forums&ord=down&id=".$rowa['id_forum']."' onmouseover='ddrivetip(\"Move Down\")' onmouseout='hideddrivetip()'><img src='new-hp/images/forum/arrow-bottom.gif'></a>"; } else { echo '<img width=17 height=20 src="new-hp/images/pixel.gif">'; }
	echo "</span></td>
		<td class='serverStatus".$res_color."' align='center'><a onmouseover='ddrivetip(\"Edit\")' onmouseout='hideddrivetip()' href='index.php?n=admin.forums&t=edit&id=".$rowa['id_forum']."'><img src='new-hp/images/v2/edit.gif'></a></td>
		<td class='serverStatus".$res_color."' align='center'><a onmouseover='ddrivetip(\"Remove\")' onmouseout='hideddrivetip()' href='index.php?n=admin.forums&t=remove&id=".$rowa['id_forum']."'><img src='new-hp/images/v2/remove.gif'></a></td>
	</tr>";
				
}

?>
				</tbody>
			</table>
<?php
metalborderdown();
?>
</span>
</div>
	<?php
	break;
	}
}
?>
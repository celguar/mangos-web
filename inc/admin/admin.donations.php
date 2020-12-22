<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

	$forceshow=true;
			
	if ($_POST['update']=='settings') {
		
		if (valdate($_POST['wdonationstartdate']!=true)) {
			$haserrors .='Invalid Date on Donations Start Date field.';
		} else {
			$_POST['wdonationstartdate'] = explode('/',$_POST['wdonationstartdate']);
			$_POST['wdonationstartdate'] = $_POST['wdonationstartdate'][2].'-'.$_POST['wdonationstartdate'][1].'-'.$_POST['wdonationstartdate'][0];
		}
		if (valdate($_POST['wdonationenddate']!=true)) {
			$haserrors .='Invalid Date on Donations End Date field.';
		} else {
			$_POST['wdonationenddate'] = explode('/',$_POST['wdonationenddate']);
			$_POST['wdonationenddate'] = $_POST['wdonationenddate'][2].'-'.$_POST['wdonationenddate'][1].'-'.$_POST['wdonationenddate'][0];
		}
		
		if ($haserrors=='') {
			
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wenabledonations']."' WHERE setting='donations_enabled'");
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wpayurl']."' WHERE setting='donations_pay_obj'");
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wdonationneed']."' WHERE setting='donations_needed_value'");
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wdonationstartdate']."' WHERE setting='donations_day_start'");
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wdonationenddate']."' WHERE setting='donations_day_end'");
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wcurrency']."' WHERE setting='donations_currency'");
		
			if ($query) {
							
				goodborder($_LANG['SUCCESS']['ADMIN_SET']);
				$forceshow=false;
				
			} else {		
				$haserrors .= mysql_error();
			}
		}
		
	} else if ($_POST['update']=='add') {
	
		$query = mysql_query('SELECT a.id as id FROM forum_accounts fa LEFT JOIN (account a) ON a.id = fa.id_account WHERE '.$_POST['namesel'].'="'.$_POST['wid'].'"')or die (mysql_error());
	
		if (!$query or mysql_num_rows($query)==0) {
				$haserrors .= 'Account Name do NOT exist.<br>';
				} else {
			while ($row=mysql_fetch_array($query)) {
				$_POST['wid']=$row['id'];
				break;
			}
		}
		if (alphanum($_POST['value'],true,false,'.')==false) {
			$haserrors .= 'Invalid Donation Value.<br>';
		}
		if (valdate($_POST['wdate'],date('Y')-100,date('Y')+1)==false) {
			$haserrors .= 'Invalid Date.<br>';
		} else {
			$_POST['wdate'] = explode("/",$_POST['wdate']);
			$_POST['wdate'] = $_POST['wdate'][2].'-'.$_POST['wdate'][1].'-'.$_POST['wdate'][0];
		}
		
		if ($haserrors=='') {
			$query = mysql_query('INSERT INTO web_donations(id_account,value,date,hide) VALUES(
			"'.$_POST['wid'].'","'.$_POST['wvalue'].'","'.$_POST['wdate'].'","'.$_POST['hided'].'")')or die (mysql_error());
				
			if($query) {
				goodborder("Donation Successfuly Added!<META HTTP-EQUIV=REFRESH CONTENT='2; URL=index.php?n=admin.donations&t=manage'>");
				$forceshow=false;
				
			} else {		
				$haserrors .= mysql_error();
			}	
		}
	
	} else if ($_POST['update']=='edit') {
	
	$query = mysql_query('SELECT a.id as id FROM forum_accounts fa LEFT JOIN (account a) ON a.id = fa.id_account WHERE '.$_POST['namesel'].'="'.$_POST['wid'].'"')or die (mysql_error());
	
		if (!$query or mysql_num_rows($query)==0) {
			$haserrors .= 'Account Name do NOT exist.<br>';
		} else {
			while ($row=mysql_fetch_array($query)) {
				$_POST['wid']=$row['id'];
				break;
			}
		}
		if (alphanum($_POST['value'],true,false,'.')==false) {
			$haserrors .= 'Invalid Donation Value.<br>';
		}
		if (valdate($_POST['wdate'],date('Y')-100,date('Y')+1)==false) {
			$haserrors .= 'Invalid Date.<br>';
		} else {
			$_POST['wdate'] = explode("/",$_POST['wdate']);
			$_POST['wdate'] = $_POST['wdate'][2].'-'.$_POST['wdate'][1].'-'.$_POST['wdate'][0];
		}
		
		if ($haserrors=='') {
			$query = mysql_query('UPDATE web_donations SET id_account="'.$_POST['wid'].'", hide="'.$_POST['hided'].'", date="'.$_POST['wdate'].'", value="'.$_POST['wvalue'].'" WHERE id_donation="'.$_REQUEST['id'].'"') or die (mysql_error());
				
			if($query) {
				goodborder("Donation Successfuly Edited!<META HTTP-EQUIV=REFRESH CONTENT='2; URL=index.php?n=admin.donations&t=manage'>");
				$forceshow=false;
				
			} else {		
				$haserrors .= mysql_error();
			}
		}
	}
	
	if ($forceshow==true) {
		
	switch ($_REQUEST['t']) {
		
		case 'remove':
		
		$query = mysql_query('DELETE FROM web_donations WHERE id_donation="'.$_REQUEST['id'].'"')or die (mysql_error());
		
		if($query) {
			goodborder("Donation Successfuly Removed!<META HTTP-EQUIV=REFRESH CONTENT='2; URL=index.php?n=admin.donations&t=manage'>");
			$forceshow=false;
			
		} else {		
			$haserrors .= mysql_error();
		}	

		break;
		case 'edit':
		
	$query = mysql_query('SELECT *, a.username as username FROM `web_donations` ft LEFT JOIN (account a) ON ft.id_account = a.id WHERE id_donation="'.$_REQUEST['id'].' GROUP BY a.id"');
		
if (mysql_num_rows($query)==1) {
		while ($row=mysql_fetch_array($query)) {
		?>
<form method=post action="index.php?n=admin.donations&t=edit&id=<?php echo $_REQUEST['id']; ?>" name="siteadmin" onsubmit="fas_valid()">
<script language="javascript">
function fas_valid() {
	void(document.siteadmin.update.value="edit");
	return true;
}
</script>
	<input type=hidden name="update">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Edit Donation:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td width=170 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Account <select name="namesel">
					<option value="fa.id_account" SELECTED>ID	
					<option value="a.username" SELECTED>Name
					<option value="fa.displayname">Display Name
					<option value="a.email">E-mail
				</select>:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input type=text size=20 name="wid">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Value Donated: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		 		<input type=text size=10 name="wvalue" value="<?php echo $row['value']; ?>">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Date: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  		<input type=text width=20 maxlength=10 name="wdate" value="<?php 
				$row['date'] = explode("-",$row['date']);
				$row['date'] = $row['date'][2].'/'.$row['date'][1].'/'.$row['date'][0];
				echo $row['date']; 
				?>"> <small>(dd/mm/yyyy)</small>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Remain Anonymous: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  		<select name="hided">
					<option value="0" SELECTED>No
					<option value="1">Yes
				</select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
<script>
<?php if ($_SERVER['REQUEST_METHOD']=='POST') { ?>
	document.siteadmin.namesel.value='<?php echo $_POST['namesel']; ?>';
	document.siteadmin.wid.value='<?php echo $_POST['wid']; ?>';
<?php } else { ?>
	document.siteadmin.namesel.value='a.`username`';
	document.siteadmin.wid.value='<?php echo $row['username']; ?>';
<?php } ?>
document.siteadmin.hided.value='<?php echo $row['hide']; ?>';
</script>
	</table>
	</td></tr></table>
	</td></tr></table><br>
		<div align=center><a href="index.php?n=admin.donations&t=manage"><img SRC="shared/wow-com/images/buttons/button-back.gif"></a><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>
		<?php
		break;
		}
		
} else {

	errborder($_LANG['ERROR']['DEFAULT']);

}
		break;
		case "settings":

			?>				
<form method=post action="index.php?n=admin.donations&t=settings" name="siteadmin" onsubmit="fas_valid()">
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
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Donations Settings:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>

	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Enable Donations:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="wenabledonations"><option value=1>Yes<option value=0>No</select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  URL Payment Object (HTML Code):  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <textarea name="wpayurl" rows=7 cols=35 wrap=off onchange="javascript:document.getElementById('previewurl').innerHTML=this.value;"><? echo $SETTING['DONATIONS_PAY_OBJ']; ?></textarea>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Preview Object:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <div id="previewurl">
		  </div>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Currency: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input name="wcurrency" type=text size=3 value="<? echo $SETTING['DONATIONS_CURRENCY']; ?>">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Value Needed: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input name="wdonationneed" type=text size=10 value="<? echo $SETTING['DONATIONS_NEEDED_VALUE']; ?>">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Starting Date: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input name="wdonationstartdate" type=text size=15 value="<? 
		  $SETTING['DONATIONS_DAY_START']=explode('-',$SETTING['DONATIONS_DAY_START']); 
		  echo $SETTING['DONATIONS_DAY_START'][2].'/'.$SETTING['DONATIONS_DAY_START'][1].'/'.$SETTING['DONATIONS_DAY_START'][0];
		  ?>">
		  </td><td valign = "top"> <small>(dd/mm/yyyy)</small>
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Ending Date: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input name="wdonationenddate" type=text size=15 value="<?
		  $SETTING['DONATIONS_DAY_END']=explode('-',$SETTING['DONATIONS_DAY_END']); 
		  echo $SETTING['DONATIONS_DAY_END'][2].'/'.$SETTING['DONATIONS_DAY_END'][1].'/'.$SETTING['DONATIONS_DAY_END'][0];
		  ?>">
		  </td><td valign = "top"> <small>(dd/mm/yyyy)</small>
		   </td></tr></table></td>
	</tr>
	</table>
<script language="javascript">
void(document.siteadmin.wenabledonations.value='<?php echo $SETTING['DONATIONS_ENABLED'];?>');
</script>
	</td></tr></table>
	</td></tr></table><br>
		
		<div align=center><input type=image SRC="shared/wow-com/images/buttons/update-button.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>
<?php
	break;
	case "add":
				?>				
<form method=post action="index.php?n=admin.donations&t=add" name="siteadmin" onsubmit="fas_valid()">
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
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Add Donation:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td width=170 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Account <select name="namesel">
					<option value="fa.id_account" SELECTED>ID	
					<option value="a.username" SELECTED>Name
					<option value="fa.displayname">Display Name
					<option value="a.email">E-mail
				</select>:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input type=text size=20 name="wid">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Value Donated: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		 		<input type=text size=10 name="wvalue">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Date: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  		<input type=text width=20 maxlength=10 name="wdate"> <small>(dd/mm/yyyy)</small>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Remain Anonymous: </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  		<select name="hided">
					<option value="0" SELECTED>No
					<option value="1">Yes
				</select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>

	</td></tr></table>
	</td></tr></table><br>
		
		<div align=center><a href="index.php?n=admin.donations&t=manage"><img SRC="shared/wow-com/images/buttons/button-back.gif"></a><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>
<?php
	break;
	case "manage";
	default:
	?>

<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
	
	<div style='cursor: auto;' id='dataElement'>
<span>
<?php
subtitle('Manage Donations:');

metalborderup();
?>
			<table cellpadding='3' cellspacing='0' width=100%>
				<tbody>
				<tr>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=120>Name</td>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=120>Value</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>Date</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>Hided</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan='6' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
					</td>
				</tr>
<?php 

$newquery = mysql_query("SELECT *, a.username as uname FROM `web_donations` ft LEFT JOIN (account a) ON a.id = ft.id_account") or die (mysql_error());
$yesno[0]='No';
$yesno[1]='yes';
$res_color=2;
while($rowa = mysql_fetch_array($newquery)) {
	
	if($res_color==1) { $res_color=2; } else { $res_color=1; }
	$totalvalue+=$rowa['value'];
	
	echo "<tr>
		<td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);'>".$rowa['uname']."</span></td>
		<td class='serverStatus".$res_color."' align='center'><span style='color: rgb(102, 13, 2);'>".$rowa['value']." ".$SETTING['DONATIONS_CURRENCY']."</span></td>
		<td class='serverStatus".$res_color."' align='center'><span style='color: rgb(102, 13, 2);'>".$rowa['date']."</span></td>
		<td class='serverStatus".$res_color."' align='center'><span style='color: rgb(102, 13, 2);'>".$yesno[$rowa['hide']]."</span></td>
		<td class='serverStatus".$res_color."' align='center'><a onmouseover='ddrivetip(\"Edit\")' onmouseout='hideddrivetip()' href='index.php?n=admin.donations&t=edit&id=".$rowa['id_donation']."'><img src='new-hp/images/v2/edit.gif'></a></td>
		<td class='serverStatus".$res_color."' align='center'><a onmouseover='ddrivetip(\"Remove\")' onmouseout='hideddrivetip()' href='index.php?n=admin.donations&t=remove&id=".$rowa['id_donation']."'><img src='new-hp/images/v2/remove.gif'></a></td>
	</tr>";
				
}

	echo "<tr>
		<td colspan='6' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
		</td>
	</tr>
	<tr>
		<td class='serverStatus1' align='left'><span style='color: rgb(102, 13, 2);'>Total</span></td>
		<td class='serverStatus1' align='center'><span style='color: rgb(102, 13, 2);'>".$totalvalue." ".$SETTING['DONATIONS_CURRENCY']."</span></td>
		<td class='serverStatus1' align='center'><span style='color: rgb(102, 13, 2);'>&nbsp;</span></td>
		<td class='serverStatus1' align='center'>&nbsp;</td>
		<td class='serverStatus1' align='center'>&nbsp;</td>
	</tr>";

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

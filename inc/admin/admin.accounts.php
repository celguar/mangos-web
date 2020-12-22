<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

$USER_LEVEL[4]='Owner'; 
$usergmt=verifygmt($_SESSION['userid']);

switch ($_REQUEST['t']) {
	case "ipban":

		if ($_REQUEST['ip']!='' AND $_REQUEST['a']=='remove') {
			if (@mysql_query("DELETE FROM ip_banned WHERE ip = '".$_REQUEST['ip']."'")) {
				goodborder('Successfuly Removed.'); echo '<br>';
			} else {
				errborder('Couldn\'t Remove IP.'); 
			}
		} else if ($_REQUEST['ip']!='' AND $_REQUEST['a']=='add') { 
			if (($binIp = ip2long($_POST['ip'])) !== false) { 
				
				if ($_POST['banfors']>='0') { 
					if (alphanum($_POST['banfori'],true,false)==false OR $_POST['banfori']=='' OR $_POST['banfori']=='0') { $_POST['banfori']='1'; }
					$_POST['banfori'] = '(UNIX_TIMESTAMP(NOW()) + '.($_POST['banfori'] * $_POST['banfors']).')'; } 
				else { $_POST['banfori']='-1'; }
				if (@mysql_query("INSERT INTO `ip_banned`(ip, bandate, unbandate, bannedby, banreason) VALUES('".long2ip(ip2long($_POST['ip']))."', UNIX_TIMESTAMP(NOW()), ".$_POST['banfori'].",'".$_SESSION['userid']."','".$_POST['reason']."')")) { 
					goodborder('Successfuly Added.'); 
					echo '<br>'; 
					unset($_POST['ip']); 
				} else {
					errborder('Couldn\'t Add IP.');
				}
			} else { 
				errborder('Invalid IP.'); 
			} 
		}

		?>
<form name="siteadmin" method=post action="index.php?n=admin.accounts&t=ipban&a=add">
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Add IP to Ban List:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>


	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td width=120 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  IP:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input type=text size=20 maxlength=15 name="ip">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td  align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		 Ban For:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
			<input name="banfori" type=text style="height:19px; width:20px;" maxlength=2 value="2">
		  </td><td valign = "top" style="font-size: 13px;">
		  <select name="banfors">
			<option value="-1">Permanently
			<option value="60">Minutes
			<option value="3600">Hours
			<option value="86400">Days
			<option value="604888" SELECTED>Weeks
			<option value="2592000">Months
			<option value="31104000.25">Years
		  </select>
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td  align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Reason:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input type=text size=40 maxlength=50 name="reason">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>
		<div align=center>
		<input type=image SRC="shared/wow-com/images/buttons/button-continue.gif">

		</div>
		</form><br><br>
		<div style='cursor: auto;' id='dataElement'>
		<span>
		<?php
		subtitle('IP Banned:');

		$newquery = @mysql_query("SELECT *, fa.displayname as dn FROM `ip_banned` ib LEFT JOIN forum_accounts fa ON ib.bannedby = fa.id_account ORDER BY ip ASC") or die (mysql_error());

		if (@mysql_num_rows($newquery)>0) {

		metalborderup();
		?>
					<table cellpadding='3' cellspacing='0' width=420>
						<tbody>
						<tr>
							<td class='rankingHeader' align='left' nowrap='nowrap'>IP</td>
							<td class='rankingHeader' align='left' nowrap='nowrap'>Time</td>
							<td class='rankingHeader' align='left' nowrap='nowrap'>By</td>
							<td class='rankingHeader' align='left' nowrap='nowrap'>Reason</td>
							<td class='rankingHeader' align='center' nowrap='nowrap'>&nbsp;</td>
						</tr>
						<tr>
							<td colspan='8' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
							</td>
						</tr>
		<?php 

		$res_color=2;
		$i=0;
		while($rowa = @mysql_fetch_array($newquery)) {
			$i++;
			if($res_color==1) { $res_color=2; } else { $res_color=1; }
				
			echo "<tr>
				<td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);'>".$rowa['ip']."</td>
				<td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);'>";
			if ($rowa['unbandate']<0) { echo 'Permanently'; } else { echo 'Until '.date('d-m-Y \a\t h:i:s A', $rowa['unbandate']); }
			echo "</td><td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);'>".$rowa['dn']."</td>
				<td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);'>".$rowa['banreason']."&nbsp;</td>
				<td class='serverStatus".$res_color."' align='center'><a onmouseover='ddrivetip(\"Remove\")' onmouseout='hideddrivetip()' href='index.php?n=admin.accounts&t=ipban&a=remove&ip=".$rowa['ip']."'><img src='new-hp/images/v2/remove.gif'></a></td>
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
			goodborder('No IP Banned Exists.');
		}
	break;
	case "settings":
	
			$forceshow=true;
			
			if ($_POST['update']=='settings1') {
			
				$query=mysql_query("UPDATE web_settings SET value='".$_POST['waccreg']."' WHERE setting='user_reg_active'");
				$query=mysql_query("UPDATE web_settings SET value='".$_POST['waccregmail']."' WHERE setting='user_reg_mail'");
			
				if ($query) {
								
					goodborder($_LANG['SUCCESS']['ADMIN_SET']);
					$forceshow=false;
					
				} else {		
					$haserrors .= mysql_error();
				}	
			}
			
	if ($forceshow==true) {
	
?>
<form method=post action="index.php?n=admin.accounts&t=settings" name="siteadmin" onsubmit="fas_valid()">
<script language="javascript">

function fas_valid() {
	void(document.siteadmin.update.value="settings1");
	return true;
}
</script>
	<input type=hidden name="update">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">User Group Settings:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td  align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Account Registrations:<br>
		  </span></b></font>
		  </td>
		  <td 70% align=left>
		  <table border=0 cellspacing=0 cellpadding=0>
			<tr>
				<td><select name="waccreg"><option value="1">Enabled<option value="0">Disabled</select></td>
			</tr>
		  </table>
<script>void(document.siteadmin.waccreg.value='<?php echo $SETTING['USER_REG_ACTIVE']; ?>')</script>
		  </td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Account E-Mail Activation:<br>
		  </span></b></font>
		  </td>
		  <td 70% align=left>
		  <table border=0 cellspacing=0 cellpadding=0>
			<tr>
				<td><select name="waccregmail"><optgroup label="Requires?"><option value="1">Yes<option value="0">No</select></td>
			</tr>
		  </table>
<script>void(document.siteadmin.waccregmail.value='<?php echo $SETTING['USER_REG_MAIL']; ?>')</script>
		  </td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>
		
		<div align=center><input type=image SRC="shared/wow-com/images/buttons/update-button.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>
<?php
}
	break;
	case "priviledges":

?>
			<?php

			$forceshow=true;
			
			if ($_POST['update']=='settings') {
			
				$langerrgreed = "You're not allowed to change the Setting %ACCPRIVSET%!<br>";
				if ($SETTING['DB_BACKUP']>$userlevel AND $_POST['wdbback']<$SETTING['DB_BACKUP']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Database: Backup', $langerrgreed); }
				if ($SETTING['DB_RESTORE']>$userlevel AND $_POST['wdbrest']<$SETTING['DB_RESTORE']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Database: Restore', $langerrgreed); }
				
				if ($SETTING['USER_WEB']>$userlevel AND $_POST['waccweb']<$SETTING['USER_WEB']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Website: Manage Settings/Layout', $langerrgreed); }
				if ($SETTING['USER_MISC']>$userlevel AND $_POST['waccmisc']<$SETTING['USER_MISC']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Website: Manage Miscellaneous', $langerrgreed); }
				if ($SETTING['USER_DONATIONS']>$userlevel AND $_POST['waccdonate']<$SETTING['USER_DONATIONS']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Website: Manage Donations', $langerrgreed); }
				if ($SETTING['USER_EMAIL']>$userlevel AND $_POST['waccemail']<$SETTING['USER_EMAIL']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Website:  Manage E-mail Settings', $langerrgreed); }
				
				if ($SETTING['UER_FORUMS']>$userlevel AND $_POST['waccforum']<$SETTING['UER_FORUMS']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Forum: Manage Forums', $langerrgreed); }
				if ($SETTING['USER_POLL']>$userlevel AND $_POST['wuserpoll']<$SETTING['USER_POLL']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Forum: Start New Polls', $langerrgreed); }
				if ($SETTING['USER_ENABLE_SIGNATURE']>$userlevel AND $_POST['wenableusersig']<$SETTING['USER_ENABLE_SIGNATURE']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Forum: Enable Signature', $langerrgreed); }
				
				if ($SETTING['USER_ACCOUNTS']>$userlevel AND $_POST['waccacc']<$SETTING['USER_ACCOUNTS']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Account: Manage Accounts', $langerrgreed); }
				if ($SETTING['USER_ENABLE_PM']>$userlevel AND $_POST['wenablepmsend']<$SETTING['USER_ENABLE_PM']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Account: Enable E-mail Sending', $langerrgreed); }
				if ($SETTING['USER_ENABLE_EMAIL']>$userlevel AND $_POST['wenablemailsend']<$SETTING['USER_ENABLE_EMAIL']) { $haserrors.=str_replace('%ACCPRIVSET%', 'Account: Enable Private Messages Sending', $langerrgreed); }
				
				if ($_POST['wserverown']=='' AND $_SESSION['userid']==$SETTING['SERVER_OWNER']) {
					$haserrors="The Server Owner field cannot be empty.";
				} else if ($_SESSION['userid']!=$SETTING['SERVER_OWNER']) {
					$_POST['wserverown'] = $SETTING['SERVER_OWNER'];
				} else {
					$newquery = "SELECT id, gmlevel FROM account a WHERE LOWER(username)=LOWER('".$_POST['wserverown']."')";
					$newquery = mysql_query($newquery) OR DIE (mysql_error());	
					if (mysql_num_rows($newquery)==1) {
						$newquery = mysql_fetch_array($newquery);
						if ($newquery['gmlevel']<'3') {
							$haserrors="To become an Owner the Account Name Priviledge must be first an Administrator.";
						} else {
							$_POST['wserverown'] = $newquery['id'];
						}
					} else {
						$haserrors="Invalid Account Name.";
					}
				}
					
				if ($haserrors=="") { 
				
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['wserverown']."' WHERE setting='server_owner'");
		
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['wdbback']."' WHERE setting='db_backup'");
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['wdbrest']."' WHERE setting='db_restore'");
		
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['waccweb']."' WHERE setting='user_web'");
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['waccmisc']."' WHERE setting='user_misc'");
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['waccdonate']."' WHERE setting='user_donations'");
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['waccemail']."' WHERE setting='user_email'");
					
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['waccforum']."' WHERE setting='user_forums'");
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['wuserpoll']."' WHERE setting='user_poll'");
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['wenableusersig']."' WHERE setting='user_enable_signature'");
					
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['waccacc']."' WHERE setting='user_accounts'");
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['wenablepmsend']."' WHERE setting='user_enable_pm'");
					$query=mysql_query("UPDATE web_settings SET value='".$_POST['wenablemailsend']."' WHERE setting='user_enable_email'");
					
					if ($query) {
									
						goodborder($_LANG['SUCCESS']['ADMIN_SET']);
						$forceshow=false;
						
					} else {		
						$haserrors .= mysql_error();
					}
				}
				
			}
			
	if ($forceshow==true) {
	
			?>
<form method=post action="index.php?n=admin.accounts&t=priviledges" name="siteadmin" onsubmit="fas_valid()">
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
		<td width = "100%" bgcolor = "#05374A"><b class = "white">User Group Priviledges:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td width=250 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Server Owner (Account Name):  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input <? if ($userlevel!=4) { echo 'readonly'; } ?> type=text name="wserverown" value="">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>

<?php

function setminmaxlvl($sett=1, $start=1) {
	if ($GLOBALS['userlevel']<$sett) { 
		echo '<option value='.$sett.'>'.$GLOBALS['USER_LEVEL'][$sett];
	} else {
		for ($i=$start;$i<=$GLOBALS['userlevel'];$i++) {
			echo '<option value='.$i.'>'.$GLOBALS['USER_LEVEL'][$i];
		}
	}
}

?>
	
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Database:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td width=250 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Backup:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="wdbback">
		  <?
		    setminmaxlvl($SETTING['DB_BACKUP']);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td  align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Restore:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="wdbrest">
			<?
			setminmaxlvl($SETTING['DB_RESTORE']);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>
		

<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Website:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td width=250 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Manage Website Settings/Layout:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="waccweb">
		  <?
			setminmaxlvl($SETTING['USER_WEB']);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td  align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Manage Miscellaneous:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="waccmisc">
			<?
			setminmaxlvl($SETTING['USER_MISC']);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td  align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Manage Donations:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="waccdonate">
		  <?
			setminmaxlvl($SETTING['USER_DONATIONS']);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td  align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Manage E-mail Settings:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="waccemail">
		  <?
			setminmaxlvl($SETTING['USER_EMAIL']);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>
	
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Forum:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td  align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Manage Forums:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="waccforum">
		  			<?
			setminmaxlvl($SETTING['USER_FORUMS']);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=250 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Enable Signature For:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="wenableusersig">
		  <?
			setminmaxlvl($SETTING['USER_ENABLE_SIGNATURE'], 0);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Start New Polls:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="wuserpoll">
		  <?
			setminmaxlvl($SETTING['USER_POLL'], 0);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>
	<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Account:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td  align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Manage Accounts:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="waccacc">
		  <?
			setminmaxlvl($SETTING['USER_ACCOUNTS']);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=250 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Enable E-mail Sending For:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="wenablemailsend">
		  <?
			setminmaxlvl($SETTING['USER_ENABLE_PM'],0);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Enable Private Messages Sending For:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="wenablepmsend">
		  <?
			setminmaxlvl($SETTING['USER_ENABLE_EMAIL'],0);
		  ?>
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>
	</td></tr></table>
	</td></tr></table><br>
<script language="javascript">
void(document.siteadmin.wserverown.value='<?php 
							$newquery = mysql_fetch_array(mysql_query("SELECT username FROM account a WHERE id='".$SETTING['SERVER_OWNER']."'"));
							echo $newquery[0];?>');
void(document.siteadmin.wdbback.value='<?php echo $SETTING['DB_BACKUP'];?>');
void(document.siteadmin.wdbrest.value='<?php echo $SETTING['DB_RESTORE'];?>');
void(document.siteadmin.waccweb.value='<?php echo $SETTING['USER_WEB'];?>');
void(document.siteadmin.waccforum.value='<?php echo $SETTING['USER_FORUMS'];?>');
void(document.siteadmin.waccacc.value='<?php echo $SETTING['USER_ACCOUNTS'];?>');
void(document.siteadmin.waccmisc.value='<?php echo $SETTING['USER_MISC'];?>');
void(document.siteadmin.waccdonate.value='<?php echo $SETTING['USER_DONATIONS'];?>');
void(document.siteadmin.waccemail.value='<?php echo $SETTING['USER_EMAIL'];?>');
void(document.siteadmin.wuserpoll.value='<?php echo $SETTING['USER_POLL'];?>');
void(document.siteadmin.wenablepmsend.value='<?php echo $SETTING['USER_ENABLE_EMAIL'];?>');
void(document.siteadmin.wenablemailsend.value='<?php echo $SETTING['USER_ENABLE_PM'];?>');
void(document.siteadmin.wenableusersig.value='<?php echo $SETTING['USER_ENABLE_SIGNATURE'];?>');
</script>
		
		<div align=center><input type=image SRC="shared/wow-com/images/buttons/update-button.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>
<?php
}
	break;
	case 'cleanup':
	
	$forceshow=true;
	
		if ($_POST['update']=='delete') {
		
			if ($_POST['acctype']=='normal') {
				$newquery = "SELECT a.id as id FROM account a LEFT JOIN (`forum_accounts` fa) ON fa.id_account = a.id WHERE a.id!='".$SETTING['SERVER_OWNER']."' AND a.gmlevel='0' AND
							(DATEDIFF(NOW(), ".$_POST['llogo'].") >=".round($_POST['llogd'] * $_POST['llogt'], 0)." OR ".$_POST['llogo']."='0000-00-00 00:00:00')";
			} else if ($_POST['acctype']=='ghost') {
				$newquery = "SELECT id_account as id FROM forum_accounts WHERE id_account NOT IN (SELECT id FROM account)";
			}
			$newquery = mysql_query($newquery) OR DIE (mysql_error());
				while($rowa = mysql_fetch_array($newquery)) {
					if ($_POST['acctype']=='normal') {
						$queryzed = mysql_query("SELECT name, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
						rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (realm_settings rs) ON r.id = rs.id_realm 
						GROUP BY r.id ORDER BY r.name", $MySQL_CON) OR DIE(mysql_error());
						while($rowo = mysql_fetch_array($queryzed)) {
							$newconb = mysql_connect($rowo['rsdbhost'].':'.$rowo['rsdbport'], $rowo['rsdbuser'], $rowo['rsdbpass']);
							$newdbb = mysql_select_db ($rowo['rsdbname'], $newconb) OR DIE(mysql_error());
							$cleanacc = mysql_query('DELETE FROM `characters` WHERE `account`="'.$rowa['id'].'"', $newconb);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
							$cleanacc = mysql_query('DELETE FROM `character_inventory` WHERE guid NOT IN (SELECT guid FROM `characters`) AND guid!=0', $newconb);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
							$cleanacc = mysql_query('DELETE FROM `character_inventory` WHERE item NOT IN (SELECT guid FROM `item_instance`) AND item!=0', $newconb);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
							$cleanacc = mysql_query('DELETE FROM `item_instance` WHERE guid NOT IN(SELECT item FROM `character_inventory`) AND guid NOT IN(SELECT id FROM mail) AND guid NOT IN(SELECT itemguid FROM `auctionhouse`)', $newconb);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
							$cleanacc = mysql_query('DELETE FROM `mail` WHERE id NOT IN (SELECT guid FROM `item_instance`) AND id!=0', $newconb);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
							$cleanacc = mysql_query('DELETE FROM `auctionhouse` WHERE itemguid NOT IN (SELECT guid FROM `item_instance`) AND itemguid!=0;', $newconb);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
							if ($haserrors!='') {  break; }
						}
						mysql_select_db ($MySQL_Set['DBREALM'], $MySQL_CON);
					}
					if ($haserrors!='') {  break; }
					$cleanacc = mysql_query('DELETE FROM `forum_accounts` WHERE id_account="'.$rowa['id'].'"', $MySQL_CON);
					if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
					if ($_POST['accconv']=='0' OR $_POST['acctype']=='ghost') {
						$cleanacc = mysql_query('UPDATE forum_posts SET id_account_edit=0 WHERE id_account="'.$rowa['id'].'"', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `forum_posts` WHERE `id_account`="'.$rowa['id'].'"', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `forum_topics` WHERE id_topic NOT IN (SELECT id_topic FROM forum_posts)', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `web_donations` WHERE id_account="'.$rowa['id'].'"', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `forum_rel_account_polls` WHERE `id_account`="'.$rowa['id'].'"', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `forum_rel_topics_polls` WHERE id_topic NOT IN (SELECT id_topic FROM forum_topics)', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
					} else if ($_POST['accconv']=='1') {
						$cleanacc = mysql_query('INSERT INTO `forum_accounts`(id_account, displayname) VALUES("'.$rowa['id_account'].'", "'.$rowa['displayname'].'")', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
					}
					$cleanacc = mysql_query('DELETE FROM `forum_pm` WHERE `id_account_from`="'.$rowa['id'].'" OR `id_account_to`="'.$rowa['id'].'"', $MySQL_CON);
					if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
					$cleanacc = mysql_query('DELETE FROM `forum_reports` WHERE `id_account`="'.$rowa['id'].'"', $MySQL_CON);
					if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
					$cleanacc = mysql_query('DELETE FROM `forum_views` WHERE `id_account`="'.$rowa['id'].'"', $MySQL_CON);
					if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
					$cleanacc = mysql_query('DELETE FROM `web_online` WHERE `id`="'.$rowa['id'].'"', $MySQL_CON);
					if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
					$cleanacc = mysql_query('DELETE FROM `account_banned` WHERE id="'.$rowa['id'].'"', $MySQL_CON);
					if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
					$cleanacc = mysql_query('DELETE FROM `account` WHERE id="'.$rowa['id'].'"', $MySQL_CON);
					if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
					if ($haserrors!='') {  break; }
				}
			if ($haserrors=='') {
				$forceshow=false;
				goodborder('A total of '.mysql_num_rows($newquery).' accounts were successfuly deleted!<META HTTP-EQUIV=REFRESH CONTENT="2; URL=?n=admin.accounts">');
			} else {
				$forceshow=true;
				errborder($haserrors);
			}

		}
if ($forceshow==true) {
?>
<form name="siteadmin" method=post action="index.php?n=admin.accounts&t=cleanup">
<input type=hidden name="update">
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Search Normal User Accounts For Clean Up:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
		<tr>
		  <td width=180 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Account Type:</span></b></font></td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="acctype" Onchange="document.siteadmin.submit();">
			<option value="normal">Normal
			<option value="ghost">Ghost
		  </select>
		  </td><td valign = "top">
		   </td></tr></table></td>
		</tr>
<?php if ($_POST['acctype']=='normal' OR $_SERVER['REQUEST_METHOD']!='POST') { ?>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Last Login On:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		<select name="llogo">
			<option value="a.last_login">Game Server
			<option value="fa.lastlogin">Website
			</select>
		  </td><td valign = "top" style="font-size: 13px;">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Last Login Was:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
			<input name="llogd" type=text style="height:19px; width:20px;" maxlength=2 value="2">
		  </td><td valign = "top" style="font-size: 13px;">
		  <select name="llogt">
			<option value="1">Days Ago
			<option value="7">Weeks Ago
			<option value="30" SELECTED>Months Ago
			<option value="365.25">Years Ago
		  </select> or higher.
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  Convert To Ghost Account:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		   <select name="accconv" onchange="vallog()">
			<option value="1">Yes
			<option value="0" SELECTED>No
		  </select>
		  </td><td valign = "top" style="font-size: 13px;">
		   </td></tr></table></td>
	</tr>
<?php } ?>
	</table>
	</td></tr></table>
	</td></tr></table><br>
<div align=center><input onclick='javascript:document.siteadmin.update.value="search";' type=image SRC="shared/wow-com/images/buttons/button-continue.gif"></div>
</form>
<?

	if ($_POST['update']=='search') {

		if (alphanum($_POST['llogd'],true,false)==false OR $_POST['llogd']=='' OR $_POST['llogd']=='0') { $_POST['llogd']='1'; }

		parchdown();
		
		parchup(true);

			if ($_POST['acctype']=='normal') {
				$newquery = "SELECT a.id as id FROM account a LEFT JOIN (`forum_accounts` fa) ON fa.id_account = a.id WHERE a.id!='".$SETTING['SERVER_OWNER']."' AND a.gmlevel='0' AND
							(DATEDIFF(NOW(), ".$_POST['llogo'].") >=".round($_POST['llogd'] * $_POST['llogt'], 0)." OR ".$_POST['llogo']."='0000-00-00 00:00:00')";
			} else {
				$newquery = "SELECT id_account FROM forum_accounts WHERE id_account NOT IN (SELECT id FROM account)";
			}
			
			$newquery = mysql_query($newquery) OR DIE (mysql_error());	
			
			if (mysql_num_rows($newquery)>0) {
				echo '<b>Found <font color=green>' . mysql_num_rows($newquery) . '</font> Accounts ready for the Delete Process.</b><br><br>';
		?>
		<font color=red>Before pressing "Continue", make sure all realms databases are On-Line!</font><br><br>
		<div align=center><input onclick='javascript:document.siteadmin.update.value="delete";document.siteadmin.submit();' type=image SRC="shared/wow-com/images/buttons/button-continue.gif"></div>
		<?php
			} else {
				echo '<b>No Accounts were Found with those requirements.</b><br>';
			}
	}
?>
<script>
	document.siteadmin.acctype.value='<?php echo $_POST['acctype']; ?>';
<?php if ($_POST['acctype']=='normal' OR $_SERVER['REQUEST_METHOD']!='POST') { ?>
	document.siteadmin.llogd.value='<?php echo $_POST['llogd']; ?>';
	document.siteadmin.llogt.value='<?php echo $_POST['llogt']; ?>';
	document.siteadmin.llogo.value='<?php echo $_POST['llogo']; ?>';
	document.siteadmin.accconv.value='<?php echo $_POST['accconv']; ?>';
	document.siteadmin.accact.value='<?php echo $_POST['accact']; ?>';
	document.siteadmin.accban.value='<?php echo $_POST['accban']; ?>';
<? } ?>
</script>
<?php
}

	break;
	case "manage":
	default:
	if ($_REQUEST['id'] =='') {
	
		if ($_REQUEST['by']=='') { $_REQUEST['by']='a.`username`'; }

?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Search For Accounts:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
 <form name="siteadmin" Onsubmit="return false;">
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td width=170 align=right>
		 
		  <font face="arial,helvetica" size=-1><span><b>
		  Account <select name="by">
					<option value="fa.`id_account`" SELECTED>ID	
					<option value="a.`username`" SELECTED>Name
					<option value="fa.`displayname`">Display Name
					<option value="a.`email`">E-mail
				</select>:</span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <input type=text size=20 name="s" value="<? echo $_REQUEST['s']; ?>">
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>
</form>
	</td></tr></table>
	</td></tr></table><br>
		<div align=center>
<script language="javascript">
document.siteadmin.by.value='<?php echo $_REQUEST['by']; ?>';
document.siteadmin.s.value='<?php echo $_REQUEST['s']; ?>';
function sorter(vabym, vas) {
	window.location='index.php?n=admin.accounts&t=manage&by=' + vabym + '&s=' + vas;
}
</script>
<a href="javascript:sorter(document.siteadmin.by.value, document.siteadmin.s.value)"><img type=image SRC="shared/wow-com/images/buttons/button-continue.gif"></a>
</div>
<?

parchdown();

parchup(true);

	$ppag=50;
	$newquery = "SELECT fa.activation as activation, a.username as username, fa.displayname as dn, fa.id_account as id, a.gmlevel as gmlevel, 
				fa.enableemail as enableemail, fa.location as location, fa.city as city, fa.showlocation as showlocation,
				DATE_FORMAT(CONVERT_TZ(fa.`lastlogin`, '".$GMT[$SETTING['WEB_GMT']][0]."', '".$usergmt."'), '%d-%m-%Y at %h:%i %p') as lastlogin, 
				DATE_FORMAT(CONVERT_TZ(a.`joindate`, '".$GMT[$SETTING['WEB_GMT']][0]."', '".$usergmt."'), '%d-%m-%Y at %h:%i %p') as joindate,  
				DATE_FORMAT(CONVERT_TZ(a.`last_login`, '".$GMT[$SETTING['WEB_GMT']][0]."', '".$usergmt."'), '%d-%m-%Y at %h:%i %p') as last_login
				FROM forum_accounts fa 
				LEFT JOIN (account a) ON fa.id_account = a.id
				WHERE (a.gmlevel < '".$userlevel."' OR a.id = '".$_SESSION['userid']."' OR fa.id_account NOT IN (SELECT id FROM `account`))";
	if ($_REQUEST['s']!='') { $newquery .= " AND ".$_REQUEST['by']." LIKE '%".$_REQUEST['s']."%'"; }
	$newquery .= " GROUP BY a.id ORDER BY ".$_REQUEST['by']." ASC";
	$newquery2 = mysql_query($newquery) or die (mysql_error());
	if (alphanum($_REQUEST['p'],true,false)==false OR $_REQUEST['p']=='') { $_REQUEST['p']=1;}
	$newquery .= " LIMIT ".(($_REQUEST['p'] - 1) * $ppag).",".$ppag."";
	$newquery = mysql_query($newquery) or die (mysql_error());
	$pages = '<div style="width: 400;" align=center><table><tr>'. pages($_REQUEST['p'], mysql_num_rows($newquery2), $ppag, "index.php?n=admin.accounts&t=manage&by=".$_REQUEST['by']."&s=".$_REQUEST['s'], ' | ', true, 0, false).'</tr></table></div>';
	
subtitle('User Accounts ('.mysql_num_rows($newquery2).'):');
	
	echo $pages;
	
metalborderup();

?>
			<table cellpadding='3' cellspacing='0' width=450>
				<tr>
					<td class='rankingHeader' align='left' nowrap='nowrap'>#</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>Account Name</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>Characters</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>Log</td>
				</tr>
				<tr>
					<td colspan='7' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
					</td>
				</tr>
				<style>
					span.white { font-size: 11px; color: white; }
				</style>
<?php 

if (mysql_num_rows($newquery)>0) {
$res_color=2;
$tt='';
$i=0;
while($rowa = mysql_fetch_array($newquery)) {
	
	if($res_color==1) { $res_color=2; } else { $res_color=1; }
	
		$queryzed = mysql_query("SELECT name, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
		rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (realm_settings rs) ON r.id = rs.id_realm 
		GROUP BY r.id ORDER BY r.name", $MySQL_CON) OR DIE(mysql_error());
		while($rowo = @mysql_fetch_array($queryzed)) {
					
			$newconb = mysql_connect($rowo['rsdbhost'].':'.$rowo['rsdbport'], $rowo['rsdbuser'], $rowo['rsdbpass'])OR DIE(mysql_error());
			$newdbb = mysql_select_db ($rowo['rsdbname'], $newconb) OR DIE(mysql_error());
			$newqueryz = mysql_query("SELECT name, race, class, data FROM `characters` WHERE `account`='".$rowa['id']."' ORDER BY name ASC", $newconb);
			
			$tt.='<table><tr><td colspan=4 align=center NOWRAP><span class=white><b>'.$rowo['name'].':</span></td></tr>';
			
			while ($rowz = @mysql_fetch_array($newqueryz)) {
				$i++;
				$rowz['data'] = explode(' ',$rowz['data']);		
				$char_gender = dechex($rowz['data'][36]);
				$char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
				$char_gender = $char_gender{3};
				$tt.='<tr><td NOWRAP><span class=white>'.$rowz['name'].'</span><td></td><img src=new-hp/images/picons/'.$rowz['race'].'-'.$char_gender.'.gif><td></td><img src=new-hp/images/picons/'.$rowz['class'].'.gif></td><td NOWRAP><span class=white>Lvl. '.$rowz['data'][34].'</span></td></tr>';
			}
			
			$tt.='</tr></table>';
			
			mysql_select_db ($MySQL_Set['DBREALM'], $MySQL_CON) OR DIE (mysql_error());

		}
	
	if ($rowa['id']==$SETTING['SERVER_OWNER']) { $rowa['gmlevel']=4; }
		if ($rowa['username']!='') {
			echo "<tr>
				<td class='serverStatus".$res_color."'><span style='color: rgb(35, 67, 3);'>".$rowa['id']."</td>
				<td class='serverStatus".$res_color."'><span style='color: rgb(35, 67, 3);'><a href='index.php?n=admin.accounts&t=manage&id=".$rowa['id']."'>".
				$rowa['username']."</a>";
			$banquery=mysql_num_rows(mysql_query("SELECT id FROM account_banned WHERE id='".$rowa['id']."' AND active=1", $MySQL_CON));
			if ($rowa['activation']!='' AND $banquery=='1') { echo " <span onmouseover=\"ddrivetip('Status: Not Activated')\" onmouseout=\"hideddrivetip()\" style='-moz-border-radius:10px;background:black; color:orange'><b>&nbsp;@&nbsp;</b></span>"; }
			else if ($banquery=='1') { echo " <span onmouseover=\"ddrivetip('Status: Banned')\" onmouseout=\"hideddrivetip()\" style='-moz-border-radius:10px;background:black; color:red'><b>&nbsp;Ø&nbsp;</b></span>"; }
			echo "<br>".$rowa['dn']."</span>
				<br><span style='color: rgb(102, 13, 2);'>".$USER_LEVEL[$rowa['gmlevel']]."</span></td>
				<td class='serverStatus".$res_color."' align='center'><span";
			if ($i>0) { echo " onmouseover=\"ddrivetip('".$tt."')\" onmouseout=\"hideddrivetip()\"";  } else { $i = "None"; }
			echo " style='color: rgb(35, 67, 3);'>".$i."</span></td>
				<td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);'>Created: ".$rowa['joindate']."<br>
				Game Server: ";
			if ($rowa['last_login']=='') { echo 'Never'; } else { echo $rowa['last_login']; }
			echo "<br>Website: ";
			if ($rowa['lastlogin']=='') { echo 'Never'; } else { echo $rowa['lastlogin']; }
			echo "</small></td>
			</tr>";
		} else {
			echo "<tr>
					<td class='serverStatus".$res_color."'><span style='color: rgb(35, 67, 3);'>".$rowa['id']."</td>
					</td>
					<td class='serverStatus".$res_color."'><span style='color: rgb(102, 13, 2);'><a href='index.php?n=admin.accounts&t=manage&id=".$rowa['id']."'>".$rowa['dn']."</a></td>
					</td>
					<td colspan=3 class='serverStatus".$res_color."'><span style='color: rgb(35, 67, 3);'>Ghost Account</td>
					</td>
				</tr>";
		}
		$tt='';
		$i=0;
	}
	
} else {
	
	echo "<tr><td colspan=7 align=center><small style='color: rgb(102, 13, 2);'>No Accounts were found!</td></tr>";

}

?>
			</table>

<?php

metalborderdown();

echo $pages;

if ($_POST['namesel']!='') { echo $pages; }

	} else {
		$newquery = mysql_query("SELECT *, DATE_FORMAT(`bday`,'%d/%m/%Y') as `bday`, a.username as username, a.joindate as joindate, a.last_login as last_login, 
				a.gmlevel as gmlevel, a.email as email, a.sha_pass_hash as password FROM forum_accounts fa LEFT JOIN (account a) ON fa.id_account = a.id
				WHERE fa.id_account='".$_REQUEST['id']."' AND (a.gmlevel < '".$userlevel."' OR a.id = '".$_SESSION['userid']."' OR fa.id_account NOT IN (SELECT id FROM `account`))") OR DIE (mysql_error());

		if (mysql_num_rows($newquery)==1) {
		
			$getbanned=mysql_fetch_array(mysql_query("SELECT *, fa.displayname as dn FROM account_banned ab LEFT JOIN (forum_accounts fa) ON fa.id_account = ab.bannedby WHERE id='".$_REQUEST['id']."' AND ab.active=1"));
			
			$rowa = mysql_fetch_array($newquery);
			$forceshow=true;
			
			if ($_POST['step']=='save') {
					if ($_POST['deleteacc']>'0') {
					$queryzed = mysql_query("SELECT name, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
					rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (realm_settings rs) ON r.id = rs.id_realm 
					GROUP BY r.id ORDER BY r.name", $MySQL_CON) OR DIE(mysql_error());
					while($rowo = mysql_fetch_array($queryzed)) {
						$newconb = mysql_connect($rowo['rsdbhost'].':'.$rowo['rsdbport'], $rowo['rsdbuser'], $rowo['rsdbpass']);
						$newdbb = mysql_select_db ($rowo['rsdbname'], $newconb) OR DIE(mysql_error());
						$cleanacc = mysql_query('DELETE FROM `characters` WHERE `account`="'.$rowa['id_account'].'"', $newconb);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `character_inventory` WHERE guid NOT IN (SELECT guid FROM `characters`) AND guid!=0', $newconb);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `character_inventory` WHERE item NOT IN (SELECT guid FROM `item_instance`) AND item!=0', $newconb);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `item_instance` WHERE guid NOT IN(SELECT item FROM `character_inventory`) AND guid NOT IN(SELECT guid FROM mail) AND guid NOT IN(SELECT itemguid FROM `auctionhouse`)', $newconb);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `mail` WHERE guid NOT IN (SELECT guid FROM `item_instance`) AND guid!=0', $newconb);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `auctionhouse` WHERE itemguid NOT IN (SELECT guid FROM `item_instance`) AND itemguid!=0;', $newconb);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						if ($haserrors!='') {  break; }
					}
					mysql_select_db ($MySQL_Set['DBREALM'], $MySQL_CON);
					if ($haserrors=='') {
						$cleanacc = mysql_query('DELETE FROM `forum_accounts` WHERE id_account="'.$rowa['id_account'].'"', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						if ($_POST['deleteacc']=='1') {
							$cleanacc = mysql_query('UPDATE forum_posts SET id_account_edit=0 WHERE id_account="'.$rowa['id_account'].'"', $MySQL_CON);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
							$cleanacc = mysql_query('DELETE FROM `forum_posts` WHERE `id_account`="'.$rowa['id_account'].'"', $MySQL_CON);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
							$cleanacc = mysql_query('DELETE FROM `forum_topics` WHERE id_topic NOT IN (SELECT id_topic FROM forum_posts)', $MySQL_CON);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
							$cleanacc = mysql_query('DELETE FROM `web_donations` WHERE id_account="'.$rowa['id_account'].'"', $MySQL_CON);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
							$cleanacc = mysql_query('DELETE FROM `forum_rel_account_polls` WHERE `id_account`="'.$rowa['id_account'].'"', $MySQL_CON);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
							$cleanacc = mysql_query('DELETE FROM `forum_rel_topics_polls` WHERE id_topic NOT IN (SELECT id_topic FROM forum_topics)', $MySQL_CON);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						} else if ($_POST['deleteacc']=='2') {
							$cleanacc = mysql_query('INSERT INTO `forum_accounts`(id_account, displayname) VALUES("'.$rowa['id_account'].'", "'.$rowa['displayname'].'")', $MySQL_CON);
							if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						}
						$cleanacc = mysql_query('DELETE FROM `forum_pm` WHERE `id_account_from`="'.$rowa['id_account'].'" OR `id_account_to`="'.$rowa['id'].'"', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `forum_reports` WHERE `id_account`="'.$rowa['id_account'].'"', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `forum_views` WHERE `id_account`="'.$rowa['id_account'].'"', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `web_online` WHERE `id`="'.$rowa['id_account'].'"', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `account_banned` WHERE id="'.$rowa['id'].'"', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
						$cleanacc = mysql_query('DELETE FROM `account` WHERE id="'.$rowa['id_account'].'"', $MySQL_CON);
						if (!$cleanacc) {  $haserrors.=mysql_error().'<br>'; }
					}
					if ($haserrors=='') {
						$forceshow=false;
						goodborder('Account Successfuly Removed!<META HTTP-EQUIV=REFRESH CONTENT="2; URL=?n=admin.accounts">');
					} else {
						$forceshow=true;
						errborder($haserrors);
					}
				} else if ($_POST['update']=='charinfo') {
					$queryz = mysql_query('UPDATE forum_accounts SET avatar="'.$_POST['avatar'].'" WHERE id_account="'.$rowa['id_account'].'"');
					goodborder('Account Forum Avatar Successfuly Updated.<meta http-equiv="refresh" content="2; ?n=admin.accounts&t=manage&id='.$rowa['id_account'].'">');
					$forceshow=false;
				} else {
					if ($rowa['username']!='') {
						if (strlen($_POST['fname'])<1 or strlen($_POST['fname'])>45) {
							$haserrors .="Invalid length on First Name field.<br>";		
						} else {
							if (alphanum($_POST['fname'],false)==false) {
								$haserrors .="Invalid chars on First Name field.<br>";		
							}
						}
						if (strlen($_POST['lname'])<1 or strlen($_POST['lname'])>45) {
							$haserrors .="Invalid length on Last Name field.<br>";		
						} else {
							if (alphanum($_POST['lname'],false)==false) {
								$haserrors .="Invalid chars on Last Name field.<br>";		
							}
						}
						if (strlen($_POST['city'])<1 or strlen($_POST['city'])>45) {
							$haserrors .="Invalid length on City field.<br>";		
						}
						if (strlen($_POST['lo'])<1) {
							$haserrors .="Invalid selected option on Country field.<br>";		
						}
						if (strlen($_POST['em'])<1 or strlen($_POST['em'])>255) {
							$haserrors .="Invalid length on E-mail field.<br>";	
						} else {
							if (valemail($_POST['em'])==false) {
								$haserrors .="Invalid E-mail.<br>";		
							} else {
								$query=mysql_query("SELECT email FROM account WHERE LOWER(email)=LOWER('".$_POST['em']."') and id!='".$rowa['id_account']."'");
								if (mysql_num_rows($query)!=0) {
									$haserrors .="E-mail already exists.<br>";
								}
							}
						}
						if (strlen($_POST['p'])>0) {
							if (strlen($_POST['p'])<6 or strlen($_POST['p'])>16) {
								$haserrors .="Invalid length on New Account Password field.<br>";		
							} else {
								if (alphanum($_POST['p'],true,true,'_')==false) {
									$haserrors .="Invalid chars on New Account Password field.<br>";		
								} else {
									if ($_POST['p']!=$_POST['cp']) {
										$haserrors .="New Account and Verification Password fields must match.<br>";		
									} else {
										if ($row['username']==$_POST['p']) {
											$haserrors .="New Account Name and Password fields must differ.<br>";		
										}
									}
								}
							}
						}
						if ($_POST['ask']<1) {
							$haserrors .="Invalid selected option on Password Hint field.<br>";		
						} else {
							if (strlen($_POST['ans'])<1 and strlen($_POST['ans'])>255) {
								$haserrors .="Invalid length on Answer field.<br>";		
							}
						}
						if ($_POST['lockacc']=='1' AND ($binIp = ip2long($_POST['lockip'])) !== false) {
							$haserrors .="Invalid Locked IP.<br>";
						} else {
							$_POST['lockip']=$rowa['last_ip'];
						}
						if ($rowa['id_account']==$SETTING['SERVER_OWNER']) {
							$_POST['gmlvl']='3';
						} else if ($_POST['gmlvl']>'0') {
							$_POST['accmvp']='0';
						}
						if ($haserrors=='') {
							if ($_POST['banfors']>='0') { 
								if (alphanum($_POST['banfori'],true,false)==false OR $_POST['banfori']=='' OR $_POST['banfori']=='0') { $_POST['banfori']='1'; }
								$_POST['banfori'] = '(UNIX_TIMESTAMP(NOW()) + '.($_POST['banfori'] * $_POST['banfors']).')'; 
							} else { 
								$_POST['banfori']='-1'; 
							}
							if ($_POST['accstatus']=='1') {
								mysql_query("UPDATE account_banned SET active='0' WHERE id='".$_REQUEST['id']."'");
								mysql_query("INSERT INTO account_banned(id, bandate,unbandate,bannedby, banreason) VALUES('".$_REQUEST['id']."', UNIX_TIMESTAMP(NOW()), ".$_POST['banfori'].",'".$_SESSION['userid']."','".$_POST['reason']."')");
								$ACC_ACT='';
							} else if ($_POST['accstatus']=='2' AND $rowa['activation']=='') {
								mysql_query("UPDATE account_banned SET active='0' WHERE id='".$_REQUEST['id']."'");
								mysql_query("INSERT INTO account_banned(id, bandate,unbandate,bannedby, banreason) VALUES('".$_REQUEST['id']."', UNIX_TIMESTAMP(NOW()), ".$_POST['banfori'].",'".$_SESSION['userid']."','Waiting for Activation')");
								$ACC_ACT=secuimg(32);
							} else if ($_POST['accstatus']=='2') {
								$ACC_ACT=$rowa['activation'];
							} else if ($_POST['accstatus']=='0') {	
								mysql_query("UPDATE account_banned SET active='0' WHERE id='".$_REQUEST['id']."'");
								$ACC_ACT='';
							}
						}
					}
					if (strlen($_POST['nick'])<3 or strlen($_POST['nick'])>16) {
						$haserrors .="Invalid length on Display Name field.<br>";		
					} else {
						if (alphanum($_POST['Display Name'],true,true,'_')==false) {
							$haserrors .="Invalid chars on Display Name field.<br>";		
						} else {
							$query=mysql_query("SELECT displayname FROM forum_accounts WHERE LOWER(displayname)=LOWER('".$_POST['nick']."') and id_account !='".$rowa['id_account']."'");
							if (mysql_num_rows($query)!=0) {
								$haserrors .="Display Name already exists.<br>";
							}
						}
					}
					if ($haserrors=='') {
						if ($rowa['username']!='') {
							if ($_POST['p']=='') { $_POST['p']=$rowa['password']; } else { $_POST['p']=sha1(strtoupper($rowa['username']).":".strtoupper($_POST['p'])); }
							$_POST['bd'] = explode("/",$_POST['bd']);
							$_POST['bd'] = $_POST['bd'][2] . "-" . $_POST['bd'][1] . "-" . $_POST['bd'][0];
							$savequery=mysql_query("UPDATE account SET gmlevel='".$_POST['gmlvl']."', sha_pass_hash='".$_POST['p']."', expansion='".$_POST['uptbc']."', email='".$_POST['em']."' WHERE id='".$rowa['id_account']."'") or die (mysql_error());
							$queryb=mysql_query("UPDATE forum_accounts SET passask='".$_POST['ask']."', passans='".$_POST['ans']."', displayname='".$_POST['nick']."', location='".$_POST['lo']."', showlocation='".$_POST['shlo']."', bday='".$_POST['bd']."', showbday='".$_POST['shbd']."',
							signature='".$_POST['sig']."', enableemail='".$_POST['shem']."',gmt='".$_POST['gmt']."',webpage='".$_POST['weburl']."',
							fname='".$_POST['fname']."',lname='".$_POST['lname']."',city='".$_POST['city']."',aim='".$_POST['aim']."',msn='".$_POST['msn']."',yahoo='".$_POST['yahoo']."',
							skype='".$_POST['skype']."',icq='".$_POST['icq']."', ismvp='".$_POST['accmvp']."', enablepm='".$_POST['shpm']."', template='".$_POST['skin']."', gender='".$_POST['gender']."', activation='".$ACC_ACT."' WHERE id_account='".$rowa['id_account']."'") or die (mysql_error());
						} else {
							$savequery=mysql_query("UPDATE forum_accounts SET displayname='".$_POST['nick']."' WHERE id_account='".$rowa['id_account']."'") or die (mysql_error());
						}
						goodborder('Account Successfuly Updated!<meta http-equiv="refresh" content="2; ?n=admin.accounts&t=manage">');
						$forceshow=false;
					} else {
						errborder($haserrors);
					}
				}
			}
		
		if ($forceshow==true) {
			remslashall();
?>
	<center>
	<form method=post name="siteadmin" action="?n=admin.accounts&t=manage&id=<?php echo $rowa['id_account']; ?>">
	<input type=hidden name="step">
	<input type=hidden name="update">
	<input type=hidden name="avatar" value="nochar">
<?php if ($rowa['username']!='') { ?>
		<table cellspacing = "0" cellpadding = "0" border = "0" width = 450>
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = 450 bgcolor = "#05374A"><b class = "white">Account Administration:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>

			<table width = 450 style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
			<table border=0 cellspacing=0 cellpadding=4>
			<tr>
				  <td align=right NOWRAP><span><b>Account Priviledges:</b></span></td>
																		  
					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td style="font-size: 13px;">
<?php if ($rowa['id_account']!=$SETTING['SERVER_OWNER']) { ?>
						 <select name="gmlvl">
<?php
	if ($_SESSION['userid']==$rowa['id_account']) { $userlevel+=1; }
	for($i=0;$i<$userlevel;$i++) {
		echo '<option value="'.$i.'"';
		if ($i==$rowa['gmlevel']) { echo ' SELECTED'; }
		echo '>'.$USER_LEVEL[$i].'</option>';
	}
} else {
	echo $USER_LEVEL[$userlevel];
}
?>
					  </select>
					  </td><td valign = "top">
				   </td></tr></table>
			</tr>
<?php if (0==$rowa['gmlevel']) { ?>
			<tr>
				  <td align=right NOWRAP valign=top><span><b>Most Valuable Player:</b></span></td>
																		  
					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td style="font-size: 13px;">
					  <select name="accmvp">
						<option value="1">Yes
						<option value="0" SELECTED>No
					  </select>

					  </td><td valign = "top">
					 </td></tr></table>
			</tr>
<?php } ?>
			<tr>
				  <td align=right NOWRAP valign=top><span><b>Account Created:</b></span></td>
																		  
					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td style="font-size: 13px;">
					 <?php
					 echo 'In '.str_replace(' ', ' at ', $rowa['joindate']);
					 ?>
					  </td><td valign = "top">
					 </td></tr></table>
			</tr>
			<tr>
				  <td align=right NOWRAP valign=top><span><b>Last Login:</b></span></td>
																		  
					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td style="font-size: 13px;">
					 <?php
					 echo 'On Game Server: '.str_replace(' ', ' at ', str_replace('0000-00-00 00:00:00', 'Never', $rowa['last_login']));
					 echo '<br>On Website: '.str_replace(' ', ' at ', str_replace('0000-00-00 00:00:00', 'Never', $rowa['lastlogin']));
					 ?>
					  </td><td valign = "top">
				   </td></tr></table>
			</tr>
			<tr>
				  <td align=right NOWRAP valign=top><span><b>Last IP:</b></span></td>
																		  
					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td style="font-size: 13px;">
					  <?php echo $rowa['last_ip']; ?>
					  </td><td valign = "top">
				   </td></tr></table>
			</tr>
			<tr>
				  <td align=right NOWRAP><span><b>Account Status:</b></span></td>
																		  
					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td style="font-size: 13px;">
<?php if ($rowa['gmlevel']=='0') { ?>
					  <select name="accstatus" onchange='document.siteadmin.submit()'>
						<option value="1">Banned
						<option value="2">Not Activated
						<option value="0">Active
					  </select>
<?php } else {
		echo 'Active';
	} 
?>
					  </td><td valign = "top" style="font-size: 13px;">		  
				   </td></tr></table>
			</tr>
<?php if(($getbanned['id']=='' AND $_POST['accstatus']=='1') OR ($rowa['activation']!='' AND $_POST['accstatus']=='1')) { ?>
			<tr>
				  <td  align=right>
				  <font face="arial,helvetica" size=-1><span><b>
				  Ban For:</span></b></font> </td>
				  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
					<input name="banfori" type=text style="height:19px; width:20px;" maxlength=2 value="2">
				  </td><td valign = "top" style="font-size: 13px;">
				  <select name="banfors">
					<option value="-1">Permanently
					<option value="60">Minutes
					<option value="3600">Hours
					<option value="86400">Days
					<option value="604888" SELECTED>Weeks
					<option value="2592000">Months
					<option value="31104000.25">Years
				  </select>
				   </td></tr></table></td>
			</tr>
			<tr>
				  <td  align=right>
				  <font face="arial,helvetica" size=-1><span><b>
				  Reason:</span></b></font> </td>
				  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
				  <input type=text size=40 maxlength=255 name="reason">
				  </td><td valign = "top">
				   </td></tr></table></td>
			</tr>
<?php } else if(($rowa['activation']!='' AND $_POST['accstatus']=='2') OR ($rowa['activation']!='' AND $_SERVER['REQUEST_METHOD']!='POST')) { ?>	
			<tr>
				  <td align=right NOWRAP><span><b>Activation Code:</b></span></td>									  
					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td style="font-size: 13px;">
			<?php echo $rowa['activation']; ?>
					  </td><td valign = "top" style="font-size: 13px;">			  
				   </td></tr></table>
			</tr>
<?php } ?>	
			<tr>
				  <td align=right NOWRAP valign=top><span><b>Ban Log:</b></span></td>
																		  
					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td style="font-size: 13px;">
<?

$banquery = mysql_query("SELECT *, fa.displayname as dn FROM account_banned ab LEFT JOIN (forum_accounts fa) ON fa.id_account=ab.bannedby WHERE id='".$rowa['id']."'") OR DIE (mysql_error());
$res_color=2;
if (mysql_num_rows($banquery)>0) {

	echo '<table border=0 cellspacing = "0" cellpadding = "2" width=250>';
	
	while ($rowi=mysql_fetch_array($banquery)) {
		if($res_color==1) { $res_color=2; } else { $res_color=1; }
		echo '<tr ';
		if ($rowa['activation']!='' and $rowi['active']=='1') { echo 'bgcolor=lightyellow'; }
		else if ($rowi['active']=='1') { echo 'bgcolor=lightpink'; }
		if (is_integer($rowi['dn'])=='') { $rowi['dn'] = $rowi['bannedby']; }
		echo ' class="serverStatus'.$res_color.'" style="font-size: 13px;">
				<td align=left>'.$rowi['dn'].': '.$rowi['banreason'].'<br>
				<span style="font-size: 10px;">';
		echo 'Since '.date("Y-m-d \a\\t H:i", $rowi['bandate']);
		if ($rowi['unbandate']>'-1') { ' till '.date("Y-m-d \a\\t H:i", $rowi['unbandate']); }
		else { echo ', Permanently'; }
		echo '</td>
			</tr>';
	}
	
	echo '</table>';

} else {

	echo 'No records were found';

}

?>
					  </td><td valign = "top" style="font-size: 13px;">		  
				   </td></tr></table>
			</tr>
			<tr>
				  <td align=right NOWRAP><span><b>Locked IP:</b></span></td>
																		  
					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td>
					  <select name="lockacc">
						<option value="1">Yes
						<option value="0" SELECTED>No
					  </select>
					  </td><td valign = "top">&nbsp;
					 <input type=text name="lockip" style="height: 20px; width: 120px;" maxlength=15>
				   </td></tr></table>
			</tr>
<?php if ($rowa['id_account']!=$SETTING['SERVER_OWNER']) { ?>
			<tr>
				  <td align=right NOWRAP><span><b>Delete Account:</b></span></td>
																		  
					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td>
					  <select name="deleteacc">
						<option value="1">Yes
						<option value="2">Yes, Leaving Ghost
						<option value="0" SELECTED>No
					  </select>
					  </td><td valign = "top">
				   </td></tr></table>
			</tr>
<?php } ?>
			</table>
	</td>
</tr>
</table>
			</td>
		</tr>
	</table>
	<p>
		<table cellspacing = "0" cellpadding = "0" border = "0" width = 450>
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = 450 bgcolor = "#05374A"><b class = "white">Account Info:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>

			<table width = 450 style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
			<table border=0 cellspacing=0 cellpadding=4>

			<tr>

				  <td align=right width=150 NOWRAP><span><b>Account Name:</b></span></td>
				  
				  <td align=left NOWRAP>
				  <table border=0 cellspacing=0 cellpadding=0><tr><td><?php echo $rowa['username']; ?></td><td valign = "top">


				   </td></tr></table>
				  </td>
				  

			</tr>
			<tr>
				  <td align=right NOWRAP><span><b>Account New Password:</b></span></td>
				  
				  <td align=left>
				  <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="p" MaxLength=16 width=150 type=Password taborder="2" taborder=2 /></td><td valign = "top">

				   </td></tr></table>
				  </td>
				  
			</tr>
			<tr>
				  <td align=right><span><b>Verify New Password:</b></span></td>
				  
				  <td align=left>
				  <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="cp" MaxLength=16 width=150 type=Password taborder="3" /></td><td valign = "top">


				   </td></tr></table>
				  </td>
				  
			</tr>
			<tr>
				  <td align=right NOWRAP><span><b>Password Hint:</b></span><br></td>

				  
				  <td align=left NOWRAP>
					<table border=0 cellspacing=0 cellpadding=0><tr><td>
					 <select name="ask" taborder=4>
					  <option value="0">Please Select A Secret Question</option>															          
<?php
for($i=1;$i<=count($PASSWORD_QUESTION);$i++) {
echo '<option value="'.$i.'">'.$PASSWORD_QUESTION[$i].'</option>';
}
?>
					 </select>

					</td><td valign = "top">

				   </td></tr></table>

				  </td>
			</tr>
			<tr>
				  <td align=right NOWRAP><span><b>Answer:</b></span></td>
				  
				  <td align=left NOWRAP>
				  <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="ans" MaxLength=32 width=150 taborder="5" value="" taborder=5/></td><td valign = "top">
				   </td></tr></table>
			</tr>
			<tr>
				  <td align=right NOWRAP><span><b></b></span></td>

					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td><label for='upgtbc'><input type=Radio value='0' id="upgtbc" name="uptbc" ><span style="font-size: 13px;">No Expansion</label></td><td valign = "top">
				   </td></tr></table>
			</tr>
            <tr>
				  <td align=right NOWRAP><span><b>Upgrades:</b></span></td>

					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td><label for='upgtbc1'><input type=Radio value='1' id="upgtbc1" name="uptbc" ><span style="font-size: 13px;">The Burning Crusades</label></td><td valign = "top">
				   </td></tr></table>
			</tr>
            <tr>
				  <td align=right NOWRAP><span><b></b></span></td>

					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td><label for='upgtbc2'><input type=Radio value='32' id="upgtbc2" name="uptbc" CHECKED><span style="font-size: 13px;">Wrath of the Lich King</label></td><td valign = "top">
				   </td></tr></table>
			</tr>
			</table>
	</td>
</tr>
</table>
			</td>
		</tr>
	</table>
	<p>
<table cellspacing = "0" cellpadding = "0" border = "0" width = 450>
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = 450 bgcolor = "#05374A"><b class = "white">Characters Info:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>

			<table width = 450 style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
			<table border=0 cellspacing=0 cellpadding=4>
	<?
	$qquery = mysql_query("SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
	rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (`realm_settings` rs) ON r.id = rs.id_realm 
	GROUP BY r.id ORDER BY r.name", $MySQL_CON) OR DIE(mysql_error());
	$i=0;
	while ($rowx = mysql_fetch_array($qquery)) {
		$newcon = @mysql_connect($rowx['rsdbhost'].':'.$rowx['rsdbport'], $rowx['rsdbuser'], $rowx['rsdbpass']);;
		$newdb = @mysql_select_db ($rowx['rsdbname'], $newcon);
		$newquery = @mysql_query("SELECT name, data, class, race, online FROM `characters` WHERE `account`='".$rowa['id_account']."'", $newcon);
		echo "<tr>
				  <td align=right valign=top width=150 NOWRAP><span><b>".$rowx['name']."</b></span></td>
				  <td align=left NOWRAP>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td>";
					while($rowc = @mysql_fetch_array($newquery)) {		
						$rowc['data'] = explode(' ',$rowc['data']);		
						$char_gender = dechex($rowc['data'][36]);
						$char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
						$char_gender = $char_gender{3};		
						echo "<table><tr>
								<td width=120 align='left'><span>".$rowc['name']."</span></td>
								<td align='left'><img onmouseover='ddrivetip(\"<b>".$CHAR_RACE[$rowc['race']][0]."</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/picons/".$rowc['race']."-".$char_gender.".gif'></td>
								<td align='left'><img onmouseover='ddrivetip(\"<b>".$CHAR_CLASS[$rowc['class']]."</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/picons/".$rowc['class'].".gif'></td>
								<td align='left' nowrap='nowrap' width=40><small style='color: rgb(102, 13, 2);'>Lvl. ".$rowc['data'][34]."</span></td>
								<td width=0% align='left' nowrap='nowrap'><small style='color: rgb(102, 13, 2);'>";
						if ($rowc['online']==1) { echo "<img onmouseover='ddrivetip(\"<b>On-Line</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/favicon.ico'>"; } 
						else { echo "<a href='#'><img onmouseover='ddrivetip(\"<b>Remove</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/v2/remove.gif'></a>"; }
						echo "</td></tr></table>";
						$i++;
					}
					if (!$newcon OR !$newdb OR !$newquery) { echo '<span style="color: red;"><i>Server is Off-Line.</i></span>'; }
					else if ($i==0) { echo '<span><i>None</i></span>'; }
		echo '		</td></tr></table>
				</td>
			</tr>';
	}
	?>
				   </table>
	 </td></tr></table> 
	</td>
</tr>
</table>
	<p>
		<table cellspacing = "0" cellpadding = "0" border = "0" width = 450>
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white">Contact Address:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>

			<table width = 450 style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
			<table border=0 cellspacing=0 cellpadding=4>

			<tr>
			      <td width=150 align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      <font color="#FF0000">*</font> First Name:
			      </span></b></font>
			      </td>
			      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="fname" MaxLength="32" style = "Width:200" taborder=1 /></td><td valign = "top">

				   </td></tr></table></td>
			</tr>
			<tr>
			      <td align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      <font color="#FF0000">*</font> Last Name:
			      </span></b></font>
			      </td>

			      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="lname" MaxLength="32" style = "Width:200" taborder=2 /></td><td valign = "top">

				   </td></tr></table></td>
			</tr>
			<tr>
			      <td align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      <font color="#FF0000">*</font> City:
			      </span></b></font>
			      </td>
			      <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="city" MaxLength="32" style = "Width:150" taborder=5/ ></td><td valign = "top">

				   </td></tr></table></td>
			</tr>
			<tr>
			      <td align=right>
			      <font face="arial,helvetica" size=-1><span><b>

			      <font color="#FF0000">*</font> Country:
				  
			      </span></b></font>
			      </td>
			      <td align=left colspan = "2">
				  	<table border=0 cellspacing=0 cellpadding=2><tr>
						<td><select name="lo" style="width: 150;" OnChange="javascript:document.siteadmin.cflag.src = 'new-hp/images/flags/' + this.value + '.gif';">
<?
foreach ($COUNTRY as $key=>$value) {
	echo '<option value="'.$key.'">'.$value.'</option>';
}
?></selected>
						</td>
						<td><img name="cflag" src="new-hp/images/flags/00.gif"></td>
				   </tr></table>
			      </td>
			</tr>
				<tr>
				<td align=right>
				<font face="arial,helvetica" size=-1><span><b>
				Show Location:<br>
				</span></b></font>
				</td>
				<td align=left>
				<table border=0 cellspacing=0 cellpadding=0>
				<tr>
				<td><select name="shlo"><option value=1 SELECTED>To Everyone<option value=0>Only To Administrators</td>
				</tr>
				</table>
				</td>
				</tr>
			</table>

			</td></tr></table>
			</td></tr></table>

			</center>

			<p>

			<table cellspacing = "0" cellpadding = "0" border = "0" width = 450>
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white">Email Address:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>

			<center>
			<a name = "phone"></a>
			<table width = 450 style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>

			<table border=0 cellspacing=0 cellpadding=4 width = "100%">
			<tr>
			      <td width=150 align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      <font color="#FF0000">*</font> Email:<br>
			      </span></b></font>
			      </td>
			      <td align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><input name="em" MaxLength="250" Width=130 taborder=9 /></td>
					</tr>
				  </table>
				  </td>
			</tr>
						<tr>
				<td align=right>
					<font face="arial,helvetica" size=-1><span><b>
					Enable Email:<br>
					</span></b></font>
					</td>
					<td align=left>
					<table border=0 cellspacing=0 cellpadding=0>
						<tr>
							<td><select name="shem"><option value=1>For Everyone<option value=0 SELECTED>Only For Administrators</td>
						</tr>
					</table>
				</td>
			</tr>
			</table>

			</td></tr></table>
			</td></tr></table>

			</center>

			<p>

			<table cellspacing = "0" cellpadding = "0" border = "0" width = 450>
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white">Forum Settings:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>

			<center>
			<a name = "phone"></a>
			<table width = "450" style = "border-width: 1px; border-style: dotted; border-color: #928058;">
				<tr>
					<td>
						<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');">
							<tr>
								<td>
									<table border=0 cellspacing=0 cellpadding=4 width = "100%">
										<tr>
											<td width=150 align=right>
												<font face="arial,helvetica" size=-1><span><b>
												 <font color="#FF0000">*</font> Display Name:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><input type=text name="nick" maxlength="16"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												Birthday:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><input type=text name="bd" maxlength="10"></td><td>&nbsp;<span>(dd/mm/yyyy)</span></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												Show Birthday:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><select name="shbd"><option value=3>Date (dd/mm/yyyy), Age (X years)<option value=1>Date (dd/mm/yyyy)<option value=2 SELECTED>Age (X years)<option value=0>No</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												Gender:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><select name="gender"><option value=0>Female<option value=1 SELECTED>Male
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												Time Zone (GMT):<br>
												</span></b></font>
												</td>
												<td align=left >
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><select name="gmt" style="width: 250;"> 
<?php
for($i=-12;$i<count($GMT)-12;$i++) {
	echo '<option value="'.$i.'">(GMT '.$GMT[$i][0].') '.$GMT[$i][1].'</option>';
}
?>
														</select></td>
				<script type="text/javascript">
						document.siteadmin.gmt.value='<?php echo $SETTING['WEB_GMT']; ?>';
				</script>
												</selected>
													</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												Enable Private Messages:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><select name="shpm"><option value=1 SELECTED>From Everyone<option value=0>Only From Administrators
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												MSN:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><input type=text name="msn"></td><td>&nbsp;<img src="new-hp/images/im/im_msn.gif"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												Skype:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><input type=text name="skype"></td><td>&nbsp;<img src="new-hp/images/im/im_skype.gif"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												ICQ:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><input type=text name="icq"></td><td>&nbsp;<img src="new-hp/images/im/im_icq.gif"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												AIM:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><input type=text name="aim"></td><td>&nbsp;<img src="new-hp/images/im/im_aim.gif"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												Yahoo:<br>
												</span></b></font>
												</td>
												<td align=left >
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><input type=text name="yahoo"></td><td>&nbsp;<img src="new-hp/images/im/im_yahoo.gif"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											  <td align=left>
											  <font face="arial,helvetica" size=-1><span><b>
											  </span></b></font> </td>
											  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
											  <?php bbcode_toolbar('siteadmin.sig'); ?>
											  </td><td valign = "top">
											   </td></tr></table></td>
										</tr>
										<tr>
											<td align=right valign=top >
												<font face="arial,helvetica" size=-1><span><b>
												Signature:<br>
												</span></b></font>
												</td>
												<td align=left >
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><textarea rows=4 name="sig" cols=40><?php if ($haserrors!='') { echo $_POST['sig']; } else { echo $rowa['signature']; } ?></textarea></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right >
												<font face="arial,helvetica" size=-1><span><b>
												Home Page URL:<br>
												</span></b></font>
												</td>
												<td align=left >
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><input type=text size=40 name="weburl"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
										  <td  align=right>
										  <font face="arial,helvetica" size=-1><span><b>
										  Skin:<br>
										  </span></b></font>
										  </td>
										  <td 60% align=left>
										  <table border=0 cellspacing=0 cellpadding=0>
											<tr>
												<td><select name="skin" OnChange="javascript:changelayout(this.value);">
												<option value="" SELECTED>Default
												<?php
													foreach (glob('new-hp/templates/*', GLOB_ONLYDIR) as $tempname) {
														if (file_exists($tempname.'/layout.css') and (stristr($tempname, 'forum')==false)) {
															$tempname = str_replace(dirname($tempname).'/','',$tempname);
															echo '<option value="'.$tempname.'">'.$tempname;
														}
													}
												?>
												</select>
													
														</td>
													</tr>
												  </table>
											  </td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
	<p>
	<input onclick="javascript:document.siteadmin.step.value='save';" type=image SRC="shared/wow-com/images/buttons/update-button.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 >
	<p>
<style type="text/css">
#character-post-info { display: table; padding: 10px; border: 1px dashed #252525; text-align: center; background: url('new-hp/images/forum/back.png') repeat 0 0; margin: 0 auto; width: 567px; }
#talent-input { display: table; width: 400px; padding: 0; margin: 0; text-align: left; }
table#dlcharacters { border: 1px solid black; border-collapse: collapse; }
small.smallBold { color: #fff; font-size: 8pt; font-weight: bold; }
.avatarselect { margin: 0; width: 82px; }
.avatarselect .shell { position: relative; margin: 10px auto; width: 64px; height: 64px; }
.avatarselect .frame  { position: absolute; background: url('new-hp/images/forum/portrait-frame.gif') no-repeat; width: 82px; height: 83px; top: -8px; left: -8px; z-index: 200; }
.avatarselect .iconPosition { position: absolute; top: -22px; right: 2px; width: 24px; text-align: center; color: #FFD823; z-index: 300; }
table.charselectborder { border: 1px solid #4C4C4C; }
span.mine { color: #a0a1a3; }
a:link.mine, a:hover.mine, a:visited.mine, a.mine { color: orange; font-weight: bold; }
small.mine { color: white; }
div.framenochar { position: absolute; background: url('new-hp/images/forum/portraits/no-character-icon.gif') no-repeat; width: 82px; height: 83px; top: -8px; left: -8px; z-index: 200; }
div.framenocharblizz { position: absolute; background: url('new-hp/images/forum/portraits/no-character-icon-blizz.gif') no-repeat; width: 82px; height: 83px; top: -8px; left: -8px; z-index: 200; }
</style>
<!--[if lte IE 6]>
<style type="text/css">
.avatarselect .shell { left: 10px; }
</style>
<![endif]-->
			<table cellspacing = "0" cellpadding = "0" border = "0" width = 450>
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white">Forum Avatar:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>
			<table width = "450" style = "border-width: 1px; border-style: dotted; border-color: #928058;">
				<tr>
					<td>
						<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');">
							<tr>
								<td>
									<table border=0 cellspacing=0 cellpadding=4 width = "100%">
										<tr>
											<td width=50% align=left>
		<?php
			$splitline=2;
			$charset[0]=$rowa['displayname'];
			$upname[0] = 'siteadmin';
			$imgset[0] = 'nochar';
			if ($rowa['id_account']==$SETTING['SERVER_OWNER']) { $rowa['gmlevel']=4; }
			if ($rowa['gmlevel']>0) { $imgset[1] = $rowa['gmlevel']; } else if ($rowa['ismvp']=='1') { $imgset[1] = 'mvp'; }
			
			$upname[1] = 'nochar';
			if ($upname[1]==$rowa['avatar']) { $upname[2]='sel'; } else { $upname[2]=''; }
		    charavatar($charset, $imgset, $upname);
			echo '</td>';
			
			mysql_select_db ($MySQL_Set['DBREALM'], $MySQL_CON);
			$qquery = mysql_query("SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
			rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (`realm_settings` rs) ON r.id = rs.id_realm 
			GROUP BY r.id ORDER BY r.name", $MySQL_CON) OR DIE(mysql_error());
			$i=1;
			while ($rowx = mysql_fetch_array($qquery)) {
				$newcon = @mysql_connect($rowx['rsdbhost'].':'.$rowx['rsdbport'], $rowx['rsdbuser'], $rowx['rsdbpass']);;
				$newdb = @mysql_select_db ($rowx['rsdbname'], $newcon);
				$newquery = @mysql_query("SELECT guid, name, data, class, race FROM `characters` WHERE `account`='".$rowa['id_account']."'", $newcon);
					while($rowc = @mysql_fetch_array($newquery)) {
						if (is_int($i/$splitline)) { echo '</tr><tr>'; }
						echo '<td align=left>';
						$rowc['data'] = explode(' ',$rowc['data']);		
						$char_gender = str_pad(dechex($rowc['data'][36]),8, 0, STR_PAD_LEFT);
						$char_gender = $char_gender{3};		
						$charset[0]=$rowc['name'];
						$charset[1]=$rowc['data'][34];
						$charset[2]=$rowc['race'];
						$charset[3]=$char_gender;
						$charset[4]=$rowc['class'];
						$charset[5]=$rowx['name'];
						$upname[1] = $rowc['guid'].'/'.$rowx['id'];
						if ($upname[1]==$rowa['avatar']) { $upname[2]='sel'; } else { $upname[2]=''; }
						charavatar($charset, '', $upname);
						echo '</td>';
						$i++;
					}
			}
			if ($rowa['gmlevel']>0) {
				foreach (glob('new-hp/images/forum/portraits/gm/*.gif') as $tempname) {
					if (is_int($i/$splitline)) { echo '</tr><tr>'; }
					echo '<td align=left>';
					$charset[0]=$rowa['displayname'];
					$imgset[0] = str_replace('new-hp/images/forum/portraits/', '', $tempname);
					$upname[1] = $imgset[0];
					if ($upname[1]==$rowa['avatar']) { $upname[2]='sel'; } else { $upname[2]=''; }
					charavatar($charset, $imgset, $upname);
					echo '</td>';
					$i++;
				}
			}
			if ($rowa['ismvp']=='1') { 
				foreach (glob('new-hp/images/forum/portraits/mvp/*.gif') as $tempname) {
					if (is_int($i/$splitline)) { echo '</tr><tr>'; }
					echo '<td align=left>';
					$charset[0]=$rowa['displayname'];
					$imgset[0] = str_replace('new-hp/images/forum/portraits/', '', $tempname);
					$upname[1] = $imgset[0];
					if ($upname[1]==$rowa['avatar']) { $upname[2]='sel'; } else { $upname[2]=''; }
					charavatar($charset, $imgset, $upname);
					echo '</td>';
					$i++;
				}
			}
		?>
													</tr>
												  </table>
											  </td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
			
		<?php if ($_SERVER['REQUEST_METHOD']!='POST') { ?>
			<script>
			document.siteadmin.ask.value='<?php echo $rowa['passask']; ?>';
			document.siteadmin.ans.value='<?php echo $rowa['passans']; ?>';
			document.siteadmin.uptbc.checked=<?php echo $rowa['expansion']; ?>;
			void(document.siteadmin.fname.value='<?php echo $rowa['fname']; ?>');
			void(document.siteadmin.lname.value='<?php echo $rowa['lname']; ?>');
			void(document.siteadmin.city.value='<?php echo $rowa['city']; ?>');
			void(document.siteadmin.lo.value='<?php echo $rowa['location']; ?>');
			<?php if ($rowa['bday']!='00/00/0000') { ?>void(document.siteadmin.bd.value='<?php echo $rowa['bday']; ?>'); <? } 
			if ($getbanned['id']!='' AND $rowa['gmlevel']==0) { 
				if ($rowa['activation']!='') { 
					echo "document.siteadmin.accstatus.value='2';"; 
				} else { 
					echo "document.siteadmin.accstatus.value='1';"; 
				} 
			} else if ($rowa['id_account']!=$_SESSION['userid'] AND $rowa['gmlevel']==0) { 
				echo "document.siteadmin.accstatus.value='0';"; 
			} ?>
			void(document.siteadmin.shbd.value='<?php echo $rowa['showbday']; ?>');
			void(document.siteadmin.cflag.src = 'new-hp/images/flags/' + document.siteadmin.lo.value + '.gif');
			void(document.siteadmin.gmt.value='<?php echo $rowa['gmt']; ?>');
			void(document.siteadmin.shlo.value='<?php echo $rowa['showlocation']; ?>');
			void(document.siteadmin.shem.value='<?php echo $rowa['enableemail']; ?>');
			void(document.siteadmin.em.value='<?php echo $rowa['email']; ?>');
			void(document.siteadmin.shpm.value='<?php echo $rowa['enablepm']; ?>');
			void(document.siteadmin.msn.value='<?php echo $rowa['msn']; ?>');
			void(document.siteadmin.skype.value='<?php echo $rowa['skype']; ?>');
			void(document.siteadmin.aim.value='<?php echo $rowa['aim']; ?>');
			void(document.siteadmin.icq.value='<?php echo $rowa['icq']; ?>');
			void(document.siteadmin.yahoo.value='<?php echo $rowa['yahoo']; ?>');
			void(document.siteadmin.weburl.value='<?php echo $rowa['weburl']; ?>');
			void(document.siteadmin.skin.value='<?php echo $rowa['template']; ?>');
			void(document.siteadmin.nick.value='<?php echo $rowa['displayname']; ?>');
			void(document.siteadmin.gender.value='<?php echo $rowa['gender']; ?>');
			void(document.siteadmin.lockacc.value='<?php echo $rowa['locked']; ?>');
			void(document.siteadmin.lockip.value='<?php echo $rowa['last_ip']; ?>');
			<?php if ($rowa['gmlevel']==0) { ?>void(document.siteadmin.accmvp.value='<?php echo $rowa['ismvp']; ?>'); <? } ?>
			</script>
		<?php
		} else {
		?>
			<script>
			document.siteadmin.ask.value='<?php echo $_POST['ask']; ?>';
			document.siteadmin.ans.value='<?php echo $_POST['ans']; ?>';
			document.siteadmin.uptbc.checked=<?php echo $_POST['uptbc']; ?>;
			document.siteadmin.lname.value='<?php echo $_POST['lname']; ?>';
			document.siteadmin.fname.value='<?php echo $_POST['fname']; ?>';
			document.siteadmin.city.value='<?php echo $_POST['city']; ?>';
			document.siteadmin.lo.value='<?php echo $_POST['lo']; ?>';
			document.siteadmin.shbd.value='<?php echo $_POST['shbd']; ?>';
			document.siteadmin.cflag.src = 'new-hp/images/flags/' + document.siteadmin.lo.value + '.gif';
			document.siteadmin.gmt.value='<?php echo $_POST['gmt']; ?>';
			document.siteadmin.shlo.value='<?php echo $_POST['shlo']; ?>';
			document.siteadmin.em.value='<?php echo $_POST['em']; ?>';
			document.siteadmin.shem.value='<?php echo $_POST['shem']; ?>';
			document.siteadmin.shpm.value='<?php echo $_POST['shpm']; ?>';
			document.siteadmin.nick.value='<?php echo $_POST['nick']; ?>';
			document.siteadmin.bd.value='<?php echo $_POST['bd']; ?>';
			document.siteadmin.msn.value='<?php echo $_POST['msn']; ?>';
			document.siteadmin.skype.value='<?php echo $_POST['skype']; ?>';
			document.siteadmin.aim.value='<?php echo $_POST['aim']; ?>';
			document.siteadmin.icq.value='<?php echo $_POST['icq']; ?>';
			document.siteadmin.yahoo.value='<?php echo $_POST['yahoo']; ?>';
			document.siteadmin.weburl.value='<?php echo $_POST['weburl']; ?>';
			document.siteadmin.skin.value='<?php echo $_POST['skin']; ?>';
			<?php if ($rowa['gmlevel']=='0') { ?>document.siteadmin.accstatus.value='<?php echo $_POST['accstatus']; ?>';<?php } ?>
			void(document.siteadmin.gender.value='<?php echo $_POST['gender']; ?>');
			void(document.siteadmin.lockacc.value='<?php echo $_POST['lockacc']; ?>');
			void(document.siteadmin.lockip.value='<?php echo $_POST['lockip']; ?>');
			<?php if ($rowa['gmlevel']==0) { ?>document.siteadmin.accmvp.value='<?php echo $_POST['accmvp']; ?>';<? } ?>
			</script>
			<?php
			}
		} else {
		?>
		<table cellspacing = "0" cellpadding = "0" border = "0" width = 450>
				<tr>
					<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
					<td width = 450 bgcolor = "#05374A"><b class = "white">Ghost Account Info:</b></td>
					<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
				</tr>
				</table>
				<table width = 450 style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
				<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
				<table border=0 cellspacing=0 cellpadding=4>
					<tr>
						<td width=150 align=right>
							<font face="arial,helvetica" size=-1><span><b>
							 <font color="#FF0000">*</font> Display Name:<br>
							</span></b></font>
							</td>
							<td align=left>
							<table border=0 cellspacing=0 cellpadding=0>
								<tr>
									<td><input type=text name="nick" maxlength="16"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
				  <td align=right NOWRAP><span><b>Delete Account:</b></span></td>
																		  
					  <td align=left NOWRAP>
					  <table border=0 cellspacing=0 cellpadding=0><tr><td>
					  <select name="deleteacc">
						<option value="1">Yes
						<option value="0" SELECTED>No
					  </select>
					  </td><td valign = "top">
				   </td></tr></table>
			</tr>
				</table>
		</td></tr></table></td></tr></table>	
	<p>
	<input onclick="javascript:document.siteadmin.step.value='save';" type=image SRC="shared/wow-com/images/buttons/update-button.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 >
	<p>
		<?php if ($haserrors=="") { ?>
			<script>
			void(document.siteadmin.nick.value='<?php echo $rowa['displayname']; ?>');
			</script>
			<?php
			} else {
			?>
			<script>
			document.siteadmin.nick.value='<?php echo $_POST['nick']; ?>';
			</script>
			<?php
			}
		} ?>
			</center>
	</form>
<?php
			}
		} else {
			errborder('Account do NOT exists.');
		}

	}
	
}



?>
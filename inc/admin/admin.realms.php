<?
if (INCLUDED!==true) { include('index.htm'); exit; }

switch($_REQUEST['t']) {

		case "edit":
		
$forceshow=true;
		
	if ($_POST['update']=="save") {

		if (strlen($_POST['wrsql_host'])<1) {
			$haserrors .="Invalid length on MySQL Server Host field.<br>";		
		}
		if (strlen($_POST['wrsql_port'])<1) {
			$haserrors .="Invalid length on MySQL Server Port field.<br>";		
		}
		if (strlen($_POST['wrsql_dbmangos'])<1) {
			$haserrors .="Invalid length on Mangos 'realmd' Database field.<br>";		
		}
		
		if ($haserrors=="") {
			
			$sqlcon = @mysql_connect($_POST['wrsql_host'], $_POST['wrsql_user'], $_POST['wrsql_pass']);			
			if (!$sqlcon) $haserrors.=mysql_error().'.<br>';
		
			$sqldb = @mysql_select_db($_POST['wrsql_dbmangos'], $sqlcon);			
			if (!$sqldb) $haserrors.=mysql_error().'.<br>';
			
			if ($haserrors=="") {
				$newquery =mysql_query("UPDATE realmlist SET name='".$_POST['wrname']."', icon='".$_POST['wrtype']."', address='".$_POST['wraddress']."', timezone='".($_POST['wgmt']+1)."' WHERE id='".$_REQUEST['id']."'", $MySQL_CON);
				if (!$newquery) $haserrors.=mysql_error().'.<br>';
				$newquery =mysql_query("DELETE FROM realm_settings WHERE id_realm='".$_REQUEST['id']."'", $MySQL_CON);
				if (!$newquery) $haserrors.=mysql_error().'.<br>';
				$newquery =mysql_query("INSERT INTO realm_settings(id_realm,dbhost,dbport,dbuser,dbpass,dbname) VALUES('".$_REQUEST['id']."','".$_POST['wrsql_host']."','".$_POST['wrsql_port']."','".$_POST['wrsql_user']."','".$_POST['wrsql_pass']."','".$_POST['wrsql_dbmangos']."')", $MySQL_CON);
				if (!$newquery) $haserrors.=mysql_error().'.<br>';
			}
			
			if ($haserrors=="") {

				goodborder($_LANG['SUCCESS']['ADMIN_SET']);
			
				$forceshow=false;
			
			} 
		
		}
	
	}

if ($forceshow==true) {
$query = mysql_query("SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (realm_settings rs) ON r.id = rs.id_realm 
WHERE r.id='".$_REQUEST['id']."' GROUP BY r.id ORDER BY r.name", $MySQL_CON) OR DIE(mysql_error());

while($row = mysql_fetch_array($query)) {
	remslashall();	
?>
<form method=post action="index.php?n=admin.realms&t=edit&id=<?php echo $_REQUEST['id']; ?>" name="siteadmin" onsubmit="db_valid()">
<script language="javascript">
function db_valid() {
	void(document.siteadmin.update.value="save");
	return true;
}
</script>
	<input type=hidden name="update" value="">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Realm:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>

	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Name:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wrname" style = "Width:150" taborder=1 value="<? echo $row['name']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Address:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wraddress" style = "Width:150" taborder=1 value="<? echo $row['address']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Type:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name="wrtype">
		  <option value="0">Normal
		  <option value="1">PvP
		  <option value="4">Normal
		  <option value="6">RP
		  <option value="8">RPPvP
		  </select>
		  <script>
		  void(document.siteadmin.wrtype.value=<? echo $row['icon']; ?>);
		  </script>
		  </td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		<td align=right width=40%>
			<font face="arial,helvetica" size=-1><span><b>
			Time Zone (GMT):<br>
			</span></b></font>
			</td>
			<td align=left width=60%>
			<table border=0 cellspacing=0 cellpadding=0>
				<tr>
					<td><select name="wgmt" style="width: 245px;"> 
<?php
for($i=-12;$i<count($GMT)-12;$i++) {
	echo '<option value="'.$i.'">(GMT '.$GMT[$i][0].') '.$GMT[$i][1].'</option>';
}
?>
			</selected>
<script type="text/javascript">
void(document.siteadmin.wgmt.value='<?php echo $row['timezone']; ?>');
</script>
				</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>

	</td></tr></table>
	</td></tr></table>
			<table width = "450">
				<tr>
					<td><span><small><b class = "error">Changes above might only be applied uppon the next restart of the realm.</small></span></td>
				</tr>
			</table><p>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Realm Database Settings:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>

	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		MySQL Server Host:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wrsql_host" style = "Width:150" taborder=1 value="<? echo $row['rsdbhost']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		MySQL Server Port:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input maxlength=5 name="wrsql_port" style = "Width:50" taborder=1 value="<? echo $row['rsdbport']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		 MySQL Username:
		  </span></b></font>
		  </td>

		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wrsql_user"  style = "Width:150" taborder=2 value="<? echo $row['rsdbuser']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td  width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		MySQL Password:
		  </span></b></font>
		  </td>
		  <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wrsql_pass" type=password style = "Width:150" taborder=5/ value="<? echo $row['rsdbpass']; ?>"></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Mangos 'mangos' Database Name:
		  </span></b></font>
		  </td>
		  <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wrsql_dbmangos" style = "Width:150" taborder=5/ value="<? echo $row['rsdbname']; ?>"></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	</table>

	</td></tr></table>
	</td></tr></table><br>
		
		<div align=center><input type=image SRC="shared/wow-com/images/buttons/update-button.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>
<?php
	break;
}
}
		break;
		default:

		subtitle('Realms List:');

		metalborderup();
		?>
		<div style='cursor: auto;' id='dataElement'>
		<span>
				<table cellpadding='3' cellspacing='0' width=450>
					<tbody>
					<tr>
						<td class='rankingHeader' align='left' nowrap='nowrap' width=70%>Realm Name&nbsp;</td>
						<td class='rankingHeader' align='left' nowrap='nowrap' width=30%>Type&nbsp;</td>
						<td class='rankingHeader' align='left' nowrap='nowrap' width=0%>&nbsp;</td>
					</tr>
					<tr>
						<td colspan='5' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
						</td>
					</tr>
		<?php 

	$query = mysql_query("SELECT * FROM `realmlist`");

	$res_color=2;
	while($rowa = mysql_fetch_array($query)) {
	
	if($res_color==1) { $res_color=2; } else { $res_color=1; }
			echo "	<tr>
						<td class='serverStatus$res_color'><b><small style='color: rgb(35, 67, 3);'>";
						if ($res_alt=='Up') { echo "<b><a href='index.php?n=account.realmstatus&t=".$rowa['id']."'>"; } 
						echo $rowa['name']."</a></b><small style='color: darkorange;'><br>".$rowa['address']."<small></td>
						<td class='serverStatus".$res_color."' align='center'><small style='color: rgb(102, 13, 2);'>".$REALM_TYPE[$rowa['icon']]."</small></td>
						<td class='serverStatus".$res_color."' align='center'><a onmouseover='ddrivetip(\"Edit\")' onmouseout='hideddrivetip()' href='index.php?n=admin.realms&t=edit&id=".$rowa['id']."'><img src='new-hp/images/v2/edit.gif'></a></td>
					</tr>";
					
	}

		?>
					</tbody>
				</table>

		</span>
		<?php

		metalborderdown();


		break;

}
?>
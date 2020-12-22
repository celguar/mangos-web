<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

$forceshow=true;

switch($_REQUEST['t']) {
	case "restore":
		$varri = "/inc/admin/backup2/restore.php";
?>

  <iframe src=<?php print $varri; ?> width=500px height=200px frameborder="0"> </iframe><?;
	break;
	case "backup":
		$varri = "/inc/admin/backup2/main.php";
?>

  <iframe src=<?php print $varri; ?> width=500px height=1100px scrolling="no" frameborder="0"> </iframe><?;
	break;
	case "settings":
	default:
	if (strstr($_POST['update'],"database")!=false) {

		if (strlen($_POST['sqlhost'])<1) {
			$haserrors .="Invalid length on MySQL Server Host field.<br>";
		}
		if (strlen($_POST['sqlport'])<1) {
			$haserrors .="Invalid length on MySQL Server Port field.<br>";
		}
		if (strlen($_POST['sqldb'])<1) {
			$haserrors .="Invalid length on Mangos 'realmd' Database field.<br>";
		}

		if ($haserrors=="") {

			$sqlcon = @mysql_connect($_POST['sqlhost'].':'.$_POST['sqlport'], $_POST['sqluser'], $_POST['sqlpass']);
			if (!$sqlcon) $haserrors.=mysql_error().'.<br>';

			if ($haserrors=="") {
				$sqldb = @mysql_select_db($_POST['sqldb']);
				if (!$sqldb) $haserrors.=mysql_error().'.<br>';

				if (!newdbsettings($_POST['sqlhost'], $_POST['sqlport'], $_POST['sqluser'], $_POST['sqlpass'], $_POST['sqldb'])) {
					$haserrors .= "Couldn't save general settings!";
				} else {
					goodborder($_LANG['SUCCESS']['ADMIN_SET']);
					$forceshow=false;
				}

			}
		}

	}

if ($forceshow==true) {
	remslashall();
			?>
<form method=post action="index.php?n=admin.database" name="siteadmin" onsubmit="db_valid()">
<script language="javascript">
function db_valid() {
	void(document.siteadmin.update.value="database");
	return true;
}
</script>
	<input type=hidden name="update">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
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
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		MySQL Server Host:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="sqlhost" style = "Width:150" taborder=1 value="<? echo $MySQL_Set['HOST']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		MySQL Server Port:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input maxlength=5 name="sqlport" style = "Width:50" taborder=1 value="<? echo $MySQL_Set['PORT']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		 MySQL Username:
		  </span></b></font>
		  </td>

		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="sqluser"  style = "Width:150" taborder=2 value="<? echo $MySQL_Set['USERNAME']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td  width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		MySQL Password:
		  </span></b></font>
		  </td>
		  <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="sqlpass" type=password style = "Width:150" taborder=5/ value="<? echo $MySQL_Set['PASSWORD']; ?>"></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Mangos 'realmd' Database Name:
		  </span></b></font>
		  </td>
		  <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="sqldb"  style = "Width:150" taborder=5/ value="<? echo $MySQL_Set['DBREALM']; ?>"><small> (Also Website Tables)</small></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
    <tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Mangos 'world' Database Name:
		  </span></b></font>
		  </td>
		  <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td>
			<input name="sqlwdb"  value="<? echo $MySQL_Set['DBWORLD']; ?>" style = "Width:150" taborder=5/ value="<? echo $MySQL_Set['DBWORLD']; ?>"><small> (Mangos 
			World Tables)</small></td><td valign = "top">

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

?>
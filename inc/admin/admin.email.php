<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

$forceshow=true;
	
	if ($_POST['step']=='update') {

		if (valemail($_POST['wemailmain'])==false) {
			$haserrors .="Invalid E-Mail.<br>";		
		}
		if ($_POST['EMAIL_ENABLED']=='1'){
			if (!check_port_status($_POST['wemailhost'], $_POST['wemailport'], 5)) {
				$haserrors .="Couln\'t connect to mail server.<br>";		
			}
		}
		if ($haserrors=='') {
		
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wemailmain']."' WHERE setting='email_main'", $MySQL_CON);
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wenablemail']."' WHERE setting='email_enabled'", $MySQL_CON);
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wemailhost']."' WHERE setting='email_host'", $MySQL_CON);
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wemailport']."' WHERE setting='email_port'", $MySQL_CON);
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wemailuser']."' WHERE setting='email_username'", $MySQL_CON);
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wemailpass']."' WHERE setting='email_password'", $MySQL_CON);
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wemailauth']."' WHERE setting='email_auth'", $MySQL_CON);
			$query=mysql_query("UPDATE web_settings SET value='".$_POST['wemailssl']."' WHERE setting='email_ssl'", $MySQL_CON);
			
			if ($query) {
							
				goodborder($_LANG['SUCCESS']['ADMIN_SET']);
				$forceshow=false;
				
			} else {		
				$haserrors .= mysql_error();
			}
		}
	} else 	if ($_POST['step']=='send') {
	
		if (sendemail($_POST['wto'], $_POST['wto'], $SETTING['WEB_SITE_NAME'].': '.$_POST['wsubject'], $_POST['wmsg'], bbcode($_POST['wmsg']))) {
			goodborder('E-Mail Successfully Sent!');
		} else {
			errborder('Couldn\'t Send E-Mail!');
		}	

	}

if ($forceshow==true) {
	remslashall();
	switch($_REQUEST['t']) {
		case "send":
		
		if ($SETTING['EMAIL_ENABLED']=='1' AND $SETTING['USER_ENABLE_MASS_EMAIL']<=verifylevel($_SESSION['userid'])) {
?>
<form method=post action="index.php?n=admin.email&t=send" name="siteadmin" onsubmit="db_valid()">
<script language="javascript">
function db_valid() {
	void(document.siteadmin.step.value="send");
	return true;
}
</script>
	<input type=hidden name="step">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">Send E-mail:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		To:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wto" value="<?php echo $_POST['wto']; ?>" style = "Width:250" taborder=1 /></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Subject:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wsubject" value="<?php echo $_POST['wsubject']; ?>" style = "Width:250" taborder=1 /></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <?php bbcode_toolbar('siteadmin.wmsg'); ?>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=40% align=right valign=top>
		  <font face="arial,helvetica" size=-1><span><b>
		  Message:  </span></b></font> </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <textarea name="wmsg"  rows=30 cols=45><?php echo $_POST['wmsg']; ?></textarea>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	</table>

	</td></tr></table>
	</td></tr></table><br>
		
		<div align=center><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>

<?php
		} else {
			errborder($_LANG['ERROR']['ACCESS']);
		}

		break;
		case "settings":
		default:

			?>
<form method=post action="index.php?n=admin.email&t=settings" name="siteadmin" onsubmit="db_valid()">
<script language="javascript">
function db_valid() {
	void(document.siteadmin.step.value="update");
	return true;
}
</script>
	<input type=hidden name="step">
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
	<tr>
		<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
		<td width = "100%" bgcolor = "#05374A"><b class = "white">SMTP Settings:</b></td>
		<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
	<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<table border=0 cellspacing=0 cellpadding=4>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Main E-mail:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wemailmain" style = "Width:150" taborder=1 value="<? echo $SETTING['EMAIL_MAIN']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Use SMTP Server:
		  </span></b></font>
		  </td>
		  <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name='wenablemail'>
		  <option value='1'>Yes
		  <option value='0' SELECTED>No
		  </select>
<script>
	document.siteadmin.wenablemail.value='<?php echo $SETTING['EMAIL_ENABLED']; ?>';
</script>
		  </td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Server Host:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wemailhost" style = "Width:150" taborder=1 value="<? echo $SETTING['EMAIL_HOST']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Server Port:
		  </span></b></font>
		  </td>
		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input maxlength=5 name="wemailport" style = "Width:50" taborder=1 value="<? echo $SETTING['EMAIL_PORT']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Server Username:
		  </span></b></font>
		  </td>

		  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wemailuser"  style = "Width:150" taborder=2 value="<? echo $SETTING['EMAIL_USERNAME']; ?>"/></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td  width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Server Password:
		  </span></b></font>
		  </td>
		  <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wemailpass" type=password style = "Width:150" taborder=5/ value="<? echo $SETTING['EMAIL_PASSWORD']; ?>"></td><td valign = "top">

		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Authentication Type:
		  </span></b></font>
		  </td>
		  <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name='wemailauth'>
		  <option value='autodetect' SELECTED>Auto Detect
		  <option value='login'>Log In
		  <option value='plain'>Plain
		  </select>
<script>
	document.siteadmin.wemailauth.value='<?php echo $SETTING['EMAIL_AUTH']; ?>';
</script>
		  </td><td valign = "top">
		   </td></tr></table></td>
	</tr>
	<tr>
		  <td width=160 align=right>
		  <font face="arial,helvetica" size=-1><span><b>
		Encryption Type:
		  </span></b></font>
		  </td>
		  <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td>
		  <select name='wemailssl'>
		  <option value='false' SELECTED>None
		  <option value='tls' SELECTED>TLS
		  <option value='ssl'>SSL
		  </select>
<script>
	document.siteadmin.wemailssl.value='<?php echo $SETTING['EMAIL_SSL']; ?>';
</script>
		  </td><td valign = "top">
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
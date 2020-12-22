<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title($_LANG['ACCOUNT']['LOG_IN']);

parchdown();

parchup(true);

$forceshow=true;

if($_SERVER['REQUEST_METHOD']=='POST' AND (stristr($_SERVER['HTTP_REFERER'], 'account.login')!==false OR stristr($_SERVER['HTTP_REFERER'], 'account.activation')!==false) AND $_SESSION['REDIRECT']=='') {
	$_SESSION['REDIRECT'] = '?';
} else if ($_SESSION['REDIRECT']==''){
	$_SESSION['REDIRECT'] = $_SERVER['HTTP_REFERER'];
}

if ($_POST['save']=='true') {

	$dbquery = mysql_query("SELECT a.id as id, a.username as un, a.sha_pass_hash as pw, fa.displayname as dn, fa.activation as act FROM account a 
	LEFT JOIN (`forum_accounts` fa) ON fa.id_account = a.id 
	WHERE LOWER(a.username)=LOWER('".$_POST['u']."') and a.sha_pass_hash=SHA1('".strtoupper($_POST['u'].":".$_POST['p'])."') 
	GROUP BY a.id", $MySQL_CON) or die (mysql_error());

	$forceshow=false;

	if (mysql_num_rows($dbquery)==1) {

		$row = mysql_fetch_array($dbquery);		
			
		if ($row['act']=='') {
			$_SESSION['username'] = $row['un'];
			$_SESSION['password'] = $row['pw'];
			$_SESSION['userid'] = $row['id'];
			if ($row['dn']=="") { $row['dn']=$_SESSION['username']; }
			$_SESSION['nickname'] = $row['dn'];
			
			if ($_POST['ACCOUNT_AUTO_LOGIN']=='on') {
				?>
				<script>
					setCookie("ALOG_ID",'<?php echo $row['id']; ?>', now);
					setCookie("ALOG_USER",'<?php echo $_POST['u']; ?>', now);
					setCookie("ALOG_PASS",'<?php echo $_POST['p']; ?>', now);
				</script>
				<?
			}
			
			mysql_query("INSERT IGNORE INTO forum_accounts(id_account) VALUES ('".$row['id']."')") or die (mysql_error());
			$dbquery = mysql_query("UPDATE forum_accounts SET lastlogin='".date('Y-m-d H:i:s')."' WHERE id_account = '" . $row['id'] . "'", $MySQL_CON) or die (mysql_error());
			goodborder("You Logged In successfully.<META HTTP-EQUIV=REFRESH CONTENT='2; URL=".$_SESSION['REDIRECT']."'>");
			unset($_SESSION['REDIRECT']);
			
		} else {
		
			errborder(str_replace("ROW_ID",$row['id'],$_LANG['ACCOUNT']['ACC_TO_BE_ACTIVATED']));
				
			$forceshow=true;
		
		}

	} else { 
	
		errborder($_LANG['ERROR']['BAD_LOGIN']);
	
		$forceshow=true;
	
	}
}

if ($forceshow==true) {

goldborderup(true); 

?>
<link rel="stylesheet" href="new-hp/css/loginstyle.css" type="text/css" id = "bnetstyle">
<table border="0" cellpadding="0" cellspacing="0" background = "new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/login-bg.jpg">
<form method="post" name="login_form">
<input type=hidden name="save" value="false">
	<tr>
		<td valign = "top">
			<div style = "position: relative;">
			<div style = "width: 400px; position: absolute; left: 130px; top: 0px;">
			</div>
			</div>
		</td>
		<td><img src = "new-hp/images/pixel.gif" width = "1" height = "169"></td>
		<td></td>
	</tr>
	<tr>
		<td><img src = "new-hp/images/pixel.gif" width = "203" height = "1"></td>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" width = "220">
			<tr>
				<td rowspan = "6"><img src = "new-hp/images/pixel.gif" width = "15" height = "110"></td>
				<td valign="center" align="left" width = "190"><b style = "color:white; font-size:8pt; font-variant: small-caps; letter-spacing:3px;"><label for="username"><?php echo $_LANG['ACCOUNT']['ACCOUNT_NAME']; ?>:</label>&nbsp;</b><br/><input type="text" name="u" size = "18" MaxLength="16" style = "width: 175px;" tabindex="1"/></td>
				<td rowspan = "6"><img src = "new-hp/images/pixel.gif" width = "15" height = "1"></td>
			</tr>
			<tr>
				<td align = "left" width = "190"><a href = "index.php?n=account.create" class = "Asmall"><?php echo $_LANG['ACCOUNT']['NEW_ACC_LINK_MEX']; ?></a></td>
			</tr>
			<tr>
				<td width = "190"><img src = "new-hp/images/pixel.gif" width = "190" height = "6"></td>
			</tr>
			<tr>
				<td valign="center" align="left" width = "190"><b style = "color:white; font-size:8pt; font-variant: small-caps; letter-spacing:3px;"><label for="password"><?php echo $_LANG['ACCOUNT']['PASSWORD']; ?>:</label>&nbsp;</b><br/><input type="password" name="p" size = "18" MaxLength="16" style = "width: 175px;" tabindex="2"></td>
			</tr>
			<tr>
				<td align = "left" width = "190"><a href = "index.php?n=account.retrieve&t=password" class = "Asmall"><?php echo $_LANG['ACCOUNT']['LOST_ACC_LINK_MEX']; ?></a></td>
			</tr>
			<tr>
				<td align = "left">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><img src = "new-hp/images/pixel.gif" width = "1" height = "7"></td>
							<td></td>
							<td></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan = "3" align = "left">
					<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td><INPUT onclick='javascript:void(document.login_form.save.value="true");' TYPE=image src="new-hp/images/pixel.gif" alt = "Login" value="Login" style = "width:100px; height:40px;" border = "0" class = "button" tabindex="3"></td>
						<td><a href = "index.php" tabindex="4"><img src = "new-hp/images/pixel.gif" width = "105" height = "40" border = "0" alt = "Cancel"></a></td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</td>
		<td><img src = "new-hp/images/pixel.gif" width = "217" height = "1"></td>
	</tr>
	<tr>
		<td colspan = "3">
			<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan = "3"><img src = "new-hp/images/pixel.gif" width = "1" height = "20"></td>
			</tr>
			<tr>
				<td width = "106"><img src = "new-hp/images/pixel.gif" width = "106" height = "1"></td>
				<td width = "410" height=20>
					<small>
					<center><input type=checkbox name="ACCOUNT_AUTO_LOGIN" id="alog"><label for="alog"><?php echo $_LANG['ACCOUNT']['REMEMBER_LOGIN']; ?></label></center>
					</small>
				</td>
			</tr>
			<tr>
				<td width = "106"><img src = "new-hp/images/pixel.gif" width = "106" height = "1"></td>
				<td width = "410" height=95>
					<small>
					  <?php
						$_LANG_msg_tmp = str_replace('\\','',$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));
						$_LANG_msg = str_replace("SERVER_HTTP_HOST_dirname_SERVER_PHP_SELF",$_LANG_msg_tmp,$_LANG['ACCOUNT']['SECUR_MEX_QUIT_BROWSER']);
						echo $_LANG_msg; ?>
					</small>
				</td>
				<td width = "124"><img src = "new-hp/images/pixel.gif" width = "124" height = "1"></td>
			</tr>
			<tr>
				<td colspan = "3"><img src = "new-hp/images/pixel.gif" width = "1" height = "30"></td>
			</tr>
			</table>
		</td>
	</tr>
	</form>
</table>

<?php 

goldborderdown(true); 
}

parchdown();
?>

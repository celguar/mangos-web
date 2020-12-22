<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title($_LANG['ACCOUNT']['ACC_ACTIVATION']); 

parchdown();

parchup(true);

if (isset($_SESSION['userid'])) {
		errborder($_LANG['ACCOUNT']['ACC_ALREADY_ACTIVATED']); 
} else {

$forceshow=true;

if ($_POST['save']=='true' OR ($_REQUEST['id']!='' AND $_REQUEST['act']!='')) {

	if ($_REQUEST['act']!='' AND $_POST['save']=='') {$_POST['actcode']=$_REQUEST['act']; }

	$dbquery = mysql_query("SELECT *, fa.activation as act, fa.displayname as dn FROM account a 
	LEFT JOIN (`forum_accounts` fa) ON fa.id_account = a.id 
	WHERE LOWER(a.username)=LOWER('".$_POST['user']."') OR a.id='".$_REQUEST['id']."' 
	GROUP BY a.id", $MySQL_CON) or die (mysql_error());

	if (mysql_num_rows($dbquery)==1) {

		$row = mysql_fetch_array($dbquery);

		$_POST['user']=$row['username'];
			
		if ($row['act']=='') {
			errborder($_LANG['ACCOUNT']['ACC_ALREADY_ACTIVATED']);
		} else if ($_POST['sendmail']=='true') {
			$msg = str_replace('ROW_DN',$row['dn'],$_LANG['ACCOUNT']['ACC_INACTIVE']);
			$msg = str_replace('SETTING_WEB_SITE_NAME',$SETTING['WEB_SITE_NAME'],$msg);
			$msg = str_replace('SERVER_HTTP_HOST_dirname_SERVER_PHP_SELF',$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']),$msg);
			$msg = str_replace('ROW_ID',$row['id'],$msg);
			$msg = str_replace('ROW_ACT',$row['act'],$msg);
							
			if(@sendemail($row['email'], $row['username'],$SETTING['WEB_SITE_NAME'].' '.$_LANG['ACCOUNT']['ACC_ACTIVATION'], $msg, $msg)){
				goodborder($_LANG['ACCOUNT']['ACTIV_ACC_EMAIL_SENT']);
			} else {
				errborder($_LANG['ACCOUNT']['ACTIV_ACC_EMAIL_ERR']);
			}
		} else if ($row['act']!=$_POST['actcode']) {
			errborder($_LANG['ACCOUNT']['WRONG_ACTIV_CODE']);
		} else {
			$dbquery = mysql_query("UPDATE forum_accounts SET activation='' WHERE id_account='".$row['id']."'");
			if ($dbquery) {
				mysql_query("UPDATE account_banned SET active='0' WHERE id='".$row['id']."'");
				$_SESSION['userid'] = $row['id'];
				$_SESSION['password'] = $row['sha_pass_hash'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['nickname'] = $row['dn'];
				goodborder($_LANG['ACCOUNT']['ACCOUNT_SUCCESS_CREATED']);
				$forceshow=false;
			} else {
				errboerder($_LANG['ACCOUNT']['ACTIV_ACC_ERROR']);
			}
		}

	} else { 
	
		errborder($_LANG['ACCOUNT']['ACC_NOT_EXIST']);
	
	}
}

if ($forceshow==true) {

goldborderup(true); 

?>
 <link rel="stylesheet" href="new-hp/css/loginstyle.css" type="text/css" id = "bnetstyle">
<table border="0" cellpadding="0" cellspacing="0" background = "new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/act-bg.jpg">
<form method="post" name="login_form">
<input type=hidden name="save" value="false">
<input type=hidden name="sendmail" value="false">
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
				<td valign="center" align="left" width = "190"><b style = "color:white; font-size:8pt; font-variant: small-caps; letter-spacing:3px;"><label for="username"><?php echo $_LANG['ACCOUNT']['ACC_NAME']; ?>:</label>&nbsp;</b><br/><input type="text" name="user" size = "18" MaxLength="16" style = "width: 175px;" value='<?php echo $_POST['user']; ?>' tabindex="1"/></td>
				<td rowspan = "6"><img src = "new-hp/images/pixel.gif" width = "15" height = "1"></td>
			</tr>
			<tr>
				<td align = "left" width = "190"></td>
			</tr>
			<tr>
				<td width = "190"><img src = "new-hp/images/pixel.gif" width = "190" height = "6"></td>
			</tr>
			<tr>
				<td valign="center" align="left" width = "190"><b style = "color:white; font-size:8pt; font-variant: small-caps; letter-spacing:3px;"><label for="password"><?php echo $_LANG['ACCOUNT']['ACTIV_CODE']; ?>:</label>&nbsp;</b><br/><input type="text" name="actcode" size = "18" MaxLength="32" style = "width: 175px;" value='<?php echo $_POST['actcode']; ?>' tabindex="2"></td>
			</tr>
			<tr>
				<td align = "left" width = "190"><a href ='javascript:void(document.login_form.sendmail.value="true");javascript:void(document.login_form.save.value="true");javascript:document.login_form.submit();' class = "Asmall"><?php echo $_LANG['ACCOUNT']['ACTIV_CODE_SEND_MAIL']; ?></a></td>
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
						<td><INPUT onclick='javascript:void(document.login_form.save.value="true");' TYPE=image src="new-hp/images/pixel.gif" alt = "<?php $_LANG['ACCOUNT']['LOGIN']; ?>" value="<?php $_LANG['ACCOUNT']['LOGIN']; ?>" style = "width:205px; height:40px;" border = "0" class = "button" tabindex="3"></td>
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
				<td width = "410" height=115>
					<small>				  
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
}

parchdown();
?>

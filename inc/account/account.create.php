<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title($_LANG['ACCOUNT']['ACC_CREATE']);

parchdown();

if ($SETTING['USER_REG_ACTIVE']=='0') {

	parchup(true);

	errborder($_LANG['ACCOUNT']['USER_REG_INACTIVE']);

} else {

if ($_POST['update']=="valcode" and $_POST['save']=="true") {

	if ($_POST['key']!=$_SESSION['CA_key']) {
		$haserrors .= $_LANG['ACCOUNT']['INVALID_SECUR_CODE'];
	}

	if ($haserrors=="") {
		$_SESSION['CA_valcode'] = true;
		$_POST['step']='userinfo';
	} else {
		$_SESSION['CA_valcode'] = false;
		$_POST['step']='valcode';
	}

} else if (strstr($_POST['update'],"userinfo")!=false and $_POST['save']=="true") {

	if (strlen($_POST['fname'])<1 or strlen($_POST['fname'])>45) {
		$haserrors .=$_LANG['ACCOUNT']['INVALID_LENGHT_NAME'];
	} else {
		if (alphanum($_POST['fname'],false)==false) {
			$haserrors .= $_LANG['ACCOUNT']['INVALID_CHAR_NAME'];
		}
	}
	if (strlen($_POST['lname'])<1 or strlen($_POST['lname'])>45) {
		$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_SURNAME'];
	} else {
		if (alphanum($_POST['lname'],false)==false) {
			$haserrors .= $_LANG['ACCOUNT']['INVALID_CHAR_SURNAME'];
		}
	}
	if (strlen($_POST['city'])<1 or strlen($_POST['city'])>45) {
		$haserrors .= $_LANG['ACCOUNT']['INVALID_CITY_LENGHT'];
	}
	if (strlen($_POST['lo'])<1) {
		$haserrors .= $_LANG['ACCOUNT']['INVALID_COUNTRY_SEL'];
	}
	if (strlen($_POST['em'])<1 or strlen($_POST['em'])>255) {
		$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_EMAIL'];
	} else {
		if (valemail($_POST['em'])==false) {
			$haserrors .= $_LANG['ACCOUNT']['INVALID_EMAIL'];
		} else {
			$query=mysql_query("SELECT email FROM account WHERE LOWER(email)=LOWER('".$_POST['em']."')");
			if (mysql_num_rows($query)!=0) {
				$haserrors .= $_LANG['ACCOUNT']['EMAIL_ALREADY_EXISTS'];
			}
		}
	}
	if (strlen($_POST['nick'])<3 or strlen($_POST['nick'])>16) {
		$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_DISP_NAME'];
	} else {
		if (alphanum($_POST['Display Name'],true,true,'_')==false) {
			$haserrors .= $_LANG['ACCOUNT']['INVALID_CHAR_DISP_NAME'];
		} else {
			$query=mysql_query("SELECT displayname FROM forum_accounts WHERE LOWER(displayname)=LOWER('".$_POST['nick']."')");
			if (mysql_num_rows($query)!=0) {
				$haserrors .= $_LANG['ACCOUNT']['DISP_NAME_ALREADY_EXISTS'];
			}
		}
	}
	if (strlen($_POST['bd'])>1) {
		if (valdate($_POST['bd'])==false) {
			$haserrors .= $_LANG['ACCOUNT']['INVALID_BIRTH_DATE'];
		}
	} else {
		$_POST['shbd'] = '0';
	}

	if ($haserrors=="") {
		$_SESSION['CA_fname'] = $_POST['fname'];
		$_SESSION['CA_lname'] = $_POST['lname'];
		$_SESSION['CA_city'] = $_POST['city'];
		$_SESSION['CA_lo'] = $_POST['lo'];
		$_SESSION['CA_shlo'] = $_POST['shlo'];
		$_SESSION['CA_em'] = $_POST['em'];
		$_SESSION['CA_shem'] = $_POST['shem'];
		$_SESSION['CA_bd'] = $_POST['bd'];
		$_SESSION['CA_shbd'] = $_POST['shbd'];
		$_SESSION['CA_gmt'] = $_POST['gmt'];
		$_SESSION['CA_shpm'] = $_POST['shpm'];
		$_SESSION['CA_msn'] = $_POST['msn'];
		$_SESSION['CA_icq'] = $_POST['icq'];
		$_SESSION['CA_aim'] = $_POST['aim'];
		$_SESSION['CA_yahoo'] = $_POST['yahoo'];
		$_SESSION['CA_skype'] = $_POST['skype'];
		$_SESSION['CA_sig'] = $_POST['sig'];
		$_SESSION['CA_weburl'] = $_POST['weburl'];
		$_SESSION['CA_skin'] = $_POST['skin'];
		$_SESSION['CA_nick'] = $_POST['nick'];
		$_SESSION['CA_gender'] = $_POST['gender'];
		$_SESSION['CA_userset'] = true;
	} else {
		$_SESSION['CA_userset'] = false;
		$_POST['step']='userinfo';
	}

} else if (strstr($_POST['update'],"accountinfo")!=false and $_POST['save']=="true") {

	if (strlen($_POST['u'])<3 or strlen($_POST['u'])>16) {
		$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_ACC_NAME'];
	} else {
		if (alphanum($_POST['u'],true,true,'_')==false) {
			$haserrors .= $_LANG['ACCOUNT']['INVALID_CHAR_ACC_NAME'];
		} else {
			$query=mysql_query("SELECT username FROM account WHERE LOWER(username)=LOWER('".$_POST['u']."')");
			if (mysql_num_rows($query)!=0) {
				$haserrors .= $_LANG['ACCOUNT']['ACC_NAME_ALREADY_EXISTS'];
			}
		}
	}
	if (strlen($_POST['p'])<6 or strlen($_POST['p'])>16) {
		$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_PASSW'];
	} else {
		if (alphanum($_POST['p'],true,true,'_')==false) {
			$haserrors .= $_LANG['ACCOUNT']['INVALID_CHAR_PASSW'];
		} else {
			if ($_POST['p']!=$_POST['cp']) {
				$haserrors .= $_LANG['ACCOUNT']['PASSW_MISMATCH'];
			} else {
				if ($_POST['u']==$_POST['p']) {
					$haserrors .= $_LANG['ACCOUNT']['ACC_EQUAL_PASSW'];
				}
			}
		}
	}
	if ($_POST['ask']<1) {
		$haserrors .= $_LANG['ACCOUNT']['INVALID_OPTION_PASS_HINT'];
	} else {
		if (strlen($_POST['ans'])<1 OR strlen($_POST['ans'])>255) {
			$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_ANSWER'];
		}
	}

	if ($haserrors=="") {
		$_SESSION['CA_u'] = $_POST['u'];
		$_SESSION['CA_p'] = $_POST['p'];
		$_SESSION['CA_ask'] = $_POST['ask'];
		$_SESSION['CA_ans'] = $_POST['ans'];
		$_SESSION['CA_tbc'] = $_POST['uptbc'];
		$_SESSION['CA_accountset'] = true;
	} else {
		$_SESSION['CA_accountset'] = false;
		$_POST['step']='accountinfo';
	}

}

if ($_POST['step']=="save") { parchup(true); } else { parchup(false,false,''); }
?>
<form name="createaccount" method="post" action="index.php?n=account.create" onsubmit="javascript:ca_valid();">
<input type=hidden name="update" value="">
<input type=hidden name="save" value="">
<input type=hidden name="step" value="">
<?php

switch ($_POST['step']) {

case "save": ////////////////SAVE

	//javascript:document.createaccount.step.value='save';javascript:createaccount.submit();

	$query=mysql_query("SELECT id, username FROM account WHERE LOWER(username)=LOWER('".$_SESSION['CA_u']."')");
	$queryb=mysql_query("SELECT id FROM account WHERE LOWER(email)=LOWER('".$_SESSION['CA_em']."')");

	if (mysql_num_rows($query) == 0 and mysql_num_rows($queryb) == 0 and $_SESSION['CA_accountset']!="" and $_SESSION['CA_userset']!="" and $_SESSION['CA_valcode']!="" and $haserrors=="") {

		$isactive=secuimg(32);

		$savequery=mysql_query("INSERT INTO account(username,sha_pass_hash,gmlevel,sessionkey,email,failed_logins,locked,online,joindate, expansion, last_ip) VALUES (
		'".$_SESSION['CA_u']."', SHA1('".strtoupper($_SESSION['CA_u']).":".strtoupper($_SESSION['CA_p'])."'), '0', '0', '".$_SESSION['CA_em']."', '0', '0', '0', '".date("Y-m-d H:i:s")."', '".$_SESSION['CA_tbc']."', '".$_SERVER['REMOTE_ADDR']."')") or die (mysql_error());

		if ($savequery) {
			$rowID = mysql_insert_id();
		} else {
			$haserrors=mysql_error().'<br>';
		}

		if ($haserrors=='') {
			$_SESSION['CA_bd'] = explode("/", $_SESSION['CA_bd']);
			$_SESSION['CA_bd'] = $_SESSION['CA_bd'][2] . '-' . $_SESSION['CA_bd'][1] . '-' . $_SESSION['CA_bd'][0];

			$queryb=mysql_query("INSERT INTO forum_accounts(id_account,location,showlocation,bday,showbday,signature,enableemail,gmt,webpage,fname,
			lname,passask,passans,city,aim,msn,yahoo,skype,icq,enablepm,template,displayname,lastlogin,activation, gender) VALUES(LAST_INSERT_ID(),'".$_SESSION['CA_lo']."',
			'".$_SESSION['CA_shlo']."','".$_SESSION['CA_bd']."','".$_SESSION['CA_shbd']."','".$_SESSION['CA_sig']."','".$_SESSION['CA_shem']."',
			'".$_SESSION['CA_gmt']."','".$_SESSION['CA_weburl']."','".$_SESSION['CA_fname']."','".$_SESSION['CA_lname']."','".$_SESSION['CA_ask']."',
			'".$_SESSION['CA_ans']."','".$_SESSION['CA_city']."','".$_SESSION['CA_aim']."','".$_SESSION['CA_msn']."','".$_SESSION['CA_yahoo']."',
			'".$_SESSION['CA_skype']."','".$_SESSION['CA_icq']."','".$_SESSION['CA_shpm']."','".$_SESSION['CA_skin']."','".$_SESSION['CA_nick']."',
			'0000-00-00 00:00:00','".$isactive."','".$_SESSION['CA_gender']."')") or die (mysql_error());
			if ($savequery) {
					unset($_POST['step']);

					$msg = str_replace("SESSION_CA_nick",$_SESSION['CA_nick'],$_LANG['ACCOUNT']['MSG_EMAIL_ACC_CREATED']);
					$msg = str_replace("SETTING_WEB_SITE_NAME",$SETTING['WEB_SITE_NAME'],$msg);
					$msg = str_replace("SERVER_HTTP_HOST.@STR_REPLACE_\\_dirname_SERVER_PHP_SELF",$_SERVER['HTTP_HOST'].@str_replace('\\', '', dirname($_SERVER['PHP_SELF'])),$msg);
					$msg = str_replace("ROWA_0",$rowID,$msg);
					$msg = str_replace("ISACTIVE",$isactive,$msg);

					if ($SETTING['USER_REG_MAIL']=='1' AND $SETTING['EMAIL_ENABLED']=='1' AND @sendemail($_SESSION['CA_em'], $_SESSION['CA_nick'],$SETTING['WEB_SITE_NAME'].' '.$_LANG['ACCOUNT']['ACC_ACTIVATION'],$msg, $msg)) {
						@mysql_query("INSERT INTO account_banned(id, banreason, bannedby, active, bandate, unbandate) VALUES('".$rowID."', 'Waiting for Activation', '[Website]', 1 , UNIX_TIMESTAMP(NOW()), '-1')");
						goodborder($_LANG['SUCCESS']['ACCOUNT_CREATED_MAIL']);
					} else {
						mysql_query("UPDATE forum_accounts SET activation='' WHERE id_account='".$rowID."'", $MySQL_CON);
						$_SESSION['userid'] = $rowID;
						$_SESSION['password'] = $_SESSION['CA_p'];
						$_SESSION['username'] = $_SESSION['CA_u'];
						$_SESSION['nickname'] = $_SESSION['CA_nick'];
						goodborder($_LANG['SUCCESS']['ACCOUNT_CREATED']);
					}

				cleanCA('');
			} else {
				$querydek=mysql_query("DELETE FROM accounts WHERE id=LAST_INSERT_ID()");
				$haserrors=mysql_error().'<br>';
			}
		}
	} else {

		$_LANG_msg = str_replace("SESSION_CA_u",$_SESSION['CA_u'],$_LANG['ACCOUNT']['SESSION_ACC_NAME_ALREADY_EXISTS']);
		if (mysql_num_rows($query)!=0) { $haserrors .= $_LANG_msg; }
		$_LANG_msg = str_replace("SESSION_CA_u",$_SESSION['CA_em'],$_LANG['ACCOUNT']['SESSION_EMAIL_ALREADY_EXISTS']);
		if (mysql_num_rows($queryb)!=0) { $haserrors .= $_LANG_msg; }
		if ($_SESSION['CA_accountset']==false or $_SESSION['CA_userset']==false or $_SESSION['CA_valcode']==false) { echo '<META HTTP-EQUIV=REFRESH CONTENT="0; URL=index.php?n=account.create">'; }

	}

	break;

case "verifyaccount": ////////////////VERIFY ACCOUNT -5

?>
<script type="text/javascript">
function ca_valid() {
	document.createaccount.step.value="save";
	document.createaccount.update.value="";
	document.createaccount.save.value="";
	return true;
}
</script>
			<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
			<tr>

				<td width = "60%" style = "background-image: url('new-hp/images/frame-left-bg.gif'); background-repeat: repeat-y;" bgcolor = "#E0BC7E">

					<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "background-image: url('new-hp/images/frame-right-bg.gif'); background-repeat: repeat-y; background-position: top right;">
					<tr>
						<td width = "100%" rowspan = "2">
			<div style = "position: relative;">

				<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
				<div style = "padding:5px; background-image: url('new-hp/images/layout/header-gradiant.jpg'); background-repeat: no-repeat;">
			<h3 class="title">Step 5 - Account Verification</h3>
			<p>
			<center>
						<table border=0 cellspacing=0 cellpadding=0><tr><td><img src="new-hp/images/navbar/left-end.gif" width="12" height="45" alt="" border="0"><td><td><img src="new-hp/images/navbar/step1b.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step2b.gif" width="73" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step3b.gif" width="73" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step4b.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step5c.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/right-end.gif" width="13" height="45" alt="" border="0"></td></tr></table>

			<p>
			<table width = "520">
			<tr>
			<td>
			<span>
<?php if ($haserrors) { ?>
			<center>

<?php errborder($haserrors); remslashall(); ?>
			</center>
			<br>
			<br>
<?php } ?>
			<img src = "new-hp/images/twoheaded-ogre.jpg" width = "180" height = "138" align = "right">

			<?php echo $_LANG['ACCOUNT']['CONFIRMATION_INFOS']; ?>


			</tr></td></table>

			<img src = "new-hp/images/layout/hr.gif" width = "450" height = "1">

			<p>
			</center>
			<center>

			<table><tr><td>
			<table border=0 cellspacing=0 cellpadding=0 width = "100%"><tr><td valign = "top">
			<table width = "100%"><tr><td><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>

				<td width = "100%" bgcolor = "#05374A"><b class = "white"><?php echo $_LANG['ACCOUNT']['ACC_DETAILS']; ?>:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table></td></table>
			<table width = "260" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = "100%" style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td align = "right">
			<table border=0 cellspacing=1 cellpadding=2 width = "100%">
			<tr>
			      <td width=125 align=right  class = "bevel" NOWRAP><span><?php echo $_LANG['ACCOUNT']['ACC_NAME']; ?>:</span></td>
			      <td width = "145" align=left  bgcolor = "#E5CDA1" NOWRAP><b><span><?php echo $_SESSION['CA_u']; ?></span><b></td>

			</tr>
			<tr>
			      <td width=125 align=right  class = "bevel" NOWRAP><span><?php echo $_LANG['ACCOUNT']['PASSWORD']; ?>:</span></td>
			      <td width = "120" align=left  bgcolor = "#E5CDA1" NOWRAP><span><?php
				  for ($i=0;$i<strlen($_SESSION['CA_p']);$i++){
					echo "*";
				  }
				  ?></span></td>
			</tr>
			<tr>
			      <td width=125 align=right  class = "bevel" NOWRAP><span><?php echo $_LANG['ACCOUNT']['PASSWD_QUESTION']; ?>:</span></td>
			      <td width = "120" align=left  bgcolor = "#E5CDA1" NOWRAP><span><?php echo $PASSWORD_QUESTION[$_SESSION['CA_ask']]; ?></span></td>
			</tr>

			<tr>
			      <td width=125 align=right  class = "bevel" NOWRAP><span><?php echo $_LANG['ACCOUNT']['PASSWD_ANSWER']; ?>:</span></td>
			      <td width = "120" align=left  bgcolor = "#E5CDA1" NOWRAP><span><?php echo $_SESSION['CA_ans']; ?></span></td>
			</tr>
			<tr>
			      <td width=125 align=right  class = "bevel" NOWRAP><span><?php echo $_LANG['ACCOUNT']['UPGRADES']; ?>:</span></td>
                  <td width = "120" align=left  bgcolor = "#E5CDA1" NOWRAP><span><?php if ($_SESSION['CA_tbc']=='32') { echo 'Wrath of the Lich King'; } if ($_SESSION['CA_tbc']=='1') { echo 'tbc'; } else { echo 'None'; } ?></span></td>
			</tr>
			</tr>
			<tr>
				<td align = "right" colspan="2">

					<table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><img src = "new-hp/images/pixel.gif" width = "231" height = "1"></td>

					</tr>
					<tr>
						<td align = "right">
							<table border=0 cellspacing=0 cellpadding=0>
							<tr>
								<td><small class = "tiny"><a href="#" onclick="javascript:document.createaccount.step.value='accountinfo'; javascript:document.createaccount.update.value='accountinfo2'; javascript:createaccount.submit()"><img src = "new-hp/images/icons/edit-button.gif" width = "16" height = "18" border = "0"></a></td>
								<td><small class = "tiny">&nbsp;</span></td><td><small class = "tiny"><a href="#" onclick="javascript:document.createaccount.step.value='accountinfo'; javascript:document.createaccount.update.value='accountinfo2'; javascript:createaccount.submit()"><?php echo $_LANG['ACCOUNT']['UPDATE_INFO']; ?></a></span></td>
							</tr>
							</table>
						</td>

					</tr>
					</table>


				</td>
			</tr>
			</table>


			</td></tr></table>
			</td></tr></table>

			</td>
			<td width = "5"><img src = "new-hp/images/pixel.gif" width = "5" height = "1"></td>
			<td valign = "top">
			<table width = "100%"><tr><td><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
			<tr>

				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white">Contact Info:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table></td></table>

					<table width = "100%" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
					<table width = "100%" style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
					<table border=0 cellspacing=1 cellpadding=2 width = "100%">
					<tr>

					      <td align=left valign=top bgcolor = "#E5CDA1">
						  <img src = "new-hp/images/pixel.gif" width = "1" height = "83" align = "right">
					<span>
					<b class = "smallBold">
<?php echo $_SESSION['CA_fname']; ?> <?php echo $_SESSION['CA_lname']; ?>
					</b><br>
<?php echo $_SESSION['CA_city']; ?>, <?php echo $COUNTRY[$_SESSION['CA_lo']]; ?><br>

<?php if ($_SESSION['CA_bd']!='0000-00-00') { echo $_SESSION['CA_bd']; } ?><br>

<a href = "mailto:<?php echo $_SESSION['CA_em']; ?>"><?php echo $_SESSION['CA_em']; ?></a>
					</span>

						</td>
					</tr>
					<tr>
						<td align = "right">

							<table border=0 cellspacing=0 cellpadding=0>

							<tr>
								<td><img src = "new-hp/images/pixel.gif" width = "200" height = "1"></td>
							</tr>
							<tr>
								<td align = "right">
									<table border=0 cellspacing=0 cellpadding=0>
									<tr>
										<td><a href="#" onclick="javascript:document.createaccount.step.value='userinfo'; javascript:document.createaccount.update.value='userinfo2'; javascript:createaccount.submit()"><img src = "new-hp/images/icons/edit-button.gif" width = "16" height = "18" border = "0"></a></td>
										<td><small class = "tiny">&nbsp;</span></td><td><small class = "tiny"><a href="#" onclick="javascript:document.createaccount.step.value='userinfo'; javascript:document.createaccount.update.value='userinfo2'; javascript:createaccount.submit()"><?php echo $_LANG['ACCOUNT']['UPDATE_INFO']; ?></a></span></td>

									</tr>
									</table>
								</td>
							</tr>
							</table>


						</td>
					</tr>
					</table>

					</td></tr></table>
					</td></tr></table>


			</td></tr></table>


			</center>
			<p>

			<center>

			<p>

			</center>

			</td></tr></table>
				<center>

			            <table cellspacing = "0" cellpadding = "0" border = "0">
			            <tr>
			                <td width="174">
<!-- CREATE ACCOUNT--><input TYPE="image" SRC="shared/wow-com/images/buttons/createaccount-button.gif" NAME="submit" alt="<?php echo $_LANG['ACCOUNT']['ACC_CREATE']; ?>" Width="174" Height="46" Border=0 class="button"   taborder=5>
							</td>
						</tr>
			            </table>


				</center>

			<img src = "new-hp/images/pixel.gif" width = "500" height = "1">
				</div>
				</div>

						</td>
					</tr>
					</table>

				</td>
			</tr>
			</table>
<?php
break;
case "accountinfo": ////////////////ACCOUNT INFO -4

?>
<script type="text/javascript">
function ca_valid() {

	if (document.createaccount.update.value=="accountinfo") {
		document.createaccount.step.value="verifyaccount";
	} else if (document.createaccount.update.value=="accountinfo2") {
		document.createaccount.step.value="verifyaccount";
	} else {
		document.createaccount.step.value="verifyaccount";
		document.createaccount.update.value="accountinfo";
	}
	document.createaccount.save.value="true";

	return true;
}
</script>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
<tr>

<td width = "60%" style = "background-image: url('new-hp/images/frame-left-bg.gif'); background-repeat: repeat-y;" bgcolor = "#E0BC7E">

<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "background-image: url('new-hp/images/frame-right-bg.gif'); background-repeat: repeat-y; background-position: top right;">
	<tr>
		<td width = "100%" rowspan = "2">


		<div style = "position: relative;">

			<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
			<div style = "padding:5px; background-image: url('new-hp/images/layout/header-gradiant.jpg'); background-repeat: no-repeat;">


		<h3 class="title"><?php echo $_LANG['ACCOUNT']['REG_STEP_4']; ?></h3>
		<p>

		<center>

		<table border=0 cellspacing=0 cellpadding=0><tr><td><img src="new-hp/images/navbar/left-end.gif" width="12" height="45" alt="" border="0"><td><td><img src="new-hp/images/navbar/step1b.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step2b.gif" width="73" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step3b.gif" width="73" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step4c.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step5a.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/right-end.gif" width="13" height="45" alt="" border="0">
		</td></tr></table>

		<p>

		<table width = "520">
			<tr>
				<td>

				<span>
<?php if ($haserrors) { ?>
			<center>

<?php errborder($haserrors); remslashall(); ?>
			</center>
			<br>
			<br>
<?php } ?>
					<img src = "new-hp/images/orc2.jpg" width = "170" height = "280" align = "right">

					<?php echo $_LANG['ACCOUNT']['INFO_CHOOSE_NAME_PASSWD']; ?>
					<p>

					<img src = "new-hp/images/pixel.gif" width = "10" height = "200" align = "left">

					<table cellspacing = "0" cellpadding = "0" border = "0" width = "305">
					<tr>
						<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
						<td width = "100%" bgcolor = "#05374A"><b class = "white"><?php echo $_LANG['ACCOUNT']['ACC_NAME_RULES']; ?>:</b></td>
						<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
					</tr>
					</table>

				<!--PlainBox Top-->
					<table cellspacing = "0" cellpadding = "0" border = "0" width = "305">
						<tr>
							<td><img src = "new-hp/images/plainbox/plainbox-top-left.gif" width = "3" height = "3" border = "0"></td><td background = "new-hp/images/plainbox/plainbox-top.gif"></td><td><img src = "new-hp/images/plainbox/plainbox-top-right.gif" width = "3" height = "3" border = "0"></td></tr><tr><td background = "new-hp/images/plainbox/plainbox-left.gif"></td><td bgcolor = "#CDB68E">
								<!--PlainBox Top-->
								<span>

								<ul><li><?php echo $_LANG['ACCOUNT']['CHAR_TYPES_ADVICE']; ?>
								</span>
								<!--PlainBox Bottom-->
								</td><td background = "new-hp/images/plainbox/plainbox-right.gif"></td></tr><tr><td><img src = "new-hp/images/plainbox/plainbox-bot-left.gif" width = "3" height = "3" border = "0"></td><td background = "new-hp/images/plainbox/plainbox-bot.gif"></td><td><img src = "new-hp/images/plainbox/plainbox-bot-right.gif" width = "3" height = "3" border = "0"></td></tr></table>
								<!--PlainBox Bottom-->
								<br>
								<table cellspacing = "0" cellpadding = "0" border = "0" width = "305">
								<tr>
									<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
									<td width = "100%" bgcolor = "#05374A"><b class = "white"><?php echo $_LANG['ACCOUNT']['PASSWD_RULES']; ?>:</b></td>
									<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
								</tr>

								</table>


								<!--PlainBox Top-->
								<table cellspacing = "0" cellpadding = "0" border = "0" width = "305"><tr><td><img src = "new-hp/images/plainbox/plainbox-top-left.gif" width = "3" height = "3" border = "0"></td><td background = "new-hp/images/plainbox/plainbox-top.gif"></td><td><img src = "new-hp/images/plainbox/plainbox-top-right.gif" width = "3" height = "3" border = "0"></td></tr><tr><td background = "new-hp/images/plainbox/plainbox-left.gif"></td><td bgcolor = "#CDB68E">
								<!--PlainBox Top-->
										<span>
										<ul><li><?php echo $_LANG['ACCOUNT']['PWD_CHAR_TYPES_ADVICE']; ?>
										</span>
										<!--PlainBox Bottom-->
										</td><td background = "new-hp/images/plainbox/plainbox-right.gif"></td></tr><tr><td><img src = "new-hp/images/plainbox/plainbox-bot-left.gif" width = "3" height = "3" border = "0"></td><td background = "new-hp/images/plainbox/plainbox-bot.gif"></td><td><img src = "new-hp/images/plainbox/plainbox-bot-right.gif" width = "3" height = "3" border = "0"></td></tr></table>
										<!--PlainBox Bottom-->
										<p>
										<?php echo $_LANG['ACCOUNT']['PWD_HINT_INFO']; ?>

										</span>
										</td>
									</tr>
								</table>
								</center>
								<p>

								<br>
								<center>
								<table style = "border-width: 1px; border-style: dotted; border-color: #928058;">
									<tr>
										<td>
											<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');">
												<tr>
													<td>
														<table border=0 cellspacing=0 cellpadding=4 width = "510">
															<tr>
																<td colspan = "3">
																<span>

															<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>
															<br>
																</span>
																</td>

															</tr>
															<tr>

															      <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['ACCOUNT_NAME']; ?>:</b></span></td>

															      <td align=left NOWRAP>
															      <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="u" MaxLength=16 width=150 taborder="1" value="" taborder=1/></td><td valign = "top">


																   </td></tr></table>
																  </td>


															</tr>
															<tr>
															      <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['ACCOUNT_PWD']; ?>:</b></span></td>

															      <td align=left>
															      <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="p" MaxLength=16 width=150 type=Password taborder="2" taborder=2 /></td><td valign = "top">

																   </td></tr></table>
															      </td>

															</tr>
															<tr>
															      <td align=right><span><b><?php echo $_LANG['ACCOUNT']['PWD_CHECK']; ?>:</b></span></td>

															      <td align=left>
															      <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="cp" MaxLength=16 width=150 type=Password taborder="3" /></td><td valign = "top">


																   </td></tr></table>
															      </td>

															</tr>
															<tr>
																<td colspan = "3">
																<span>
															<br>
															<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>

																</span>
																</td>

															</tr>
															<tr>
																<td colspan = "3">
																<span>
															<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>
															<br>
																</span>
																</td>

															</tr>
															<tr>
															      <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['PWD_HINT']; ?>:</b></span><br></td>


															      <td align=left NOWRAP>
																	<table border=0 cellspacing=0 cellpadding=0><tr><td>
															         <select name="ask" taborder=4>
															          <option value="0"><?php echo $_LANG['ACCOUNT']['SEL_SECRET_QUESTION']; ?></option>
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
															      <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['ANSWER']; ?>:</b></span></td>

															      <td align=left NOWRAP>
																  <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="ans" MaxLength=32 width=150 taborder="5" value="" taborder=5/></td><td valign = "top">
																   </td></tr></table>
															</tr>
															<tr>
																<td colspan = "3">
																	<span>

																	<span>
																	<?php echo $_LANG['ACCOUNT']['ANSWER_INFO']; ?>
																	</span>

																		<P>
																		<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>

																			</span>
																			</td>

																		</tr>
																		<tr>
																			<td colspan = "3">
																			<span>
																		<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>
																		<br>
																			</span>
																			</td>

																		</tr>
                                                                            <tr>
																				  <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['UPGRADES']; ?>:</b></span></td>

																					  <td align=left NOWRAP>
																					  <table border=0 cellspacing=0 cellpadding=0><tr><td><lable for='upgtbc2'><input type=radio value='0' id="upgtbc2" name="uptbc"  > No Expansion</label></td><td valign = "top">
																				   </td></tr></table></td>
																			</tr>
                                                                            <tr>
																				  <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['UPGRADES']; ?>:</b></span></td>

																					  <td align=left NOWRAP>
																					  <table border=0 cellspacing=0 cellpadding=0><tr><td><lable for='upgtbc1'><input type=radio value='1' id="upgtbc1" name="uptbc"  > The Burning Crudades</label></td><td valign = "top">
																				   </td></tr></table></td>
																			</tr>
																			<tr>
																				  <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['UPGRADES']; ?>:</b></span></td>

																					  <td align=left NOWRAP>
																					  <table border=0 cellspacing=0 cellpadding=0><tr><td><label for='upgtbc'><input type=radio value='32' id="upgtbc" name="uptbc" CHECKED> Wrath of the Lich King</label></td><td valign = "top">
																				   </td></tr></table></td>
																			</tr>

																		<tr>

																			<td colspan = "3">
																			<p><span>

																				<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>
																				<br>
																			</span>
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

								<table width = "520">
									<tr>
										<td><span><b class = "error"><?php echo $_LANG['ACCOUNT']['ACC_PWD_INFO']; ?></span></td>
									</tr>
								</table>
								</center>
								<P>
								<center>
								<table cellspacing = "0" cellpadding = "0" border = "0">
									<tr>
										<td Width="91">
<?php if ($_POST['update']=="accountinfo2") { ?>
<!-- UPDATE --><input onclick='javascript:document.createaccount.update.value="accountinfo2";' src="shared/wow-com/images/buttons/update-button.gif" name="submit" alt="<?php echo $_LANG['ACCOUNT']['UPDATE']; ?>" class="button" taborder="6" border="0" height="46" type="image" width="174"><br>
<!-- CANCEL -->	<a href="javascript:document.createaccount.step.value='verifyaccount'; javascript:document.createaccount.update.value='';  javascript:createaccount.submit()"><img src="shared/wow-com/images/buttons/button-cancel.gif" alt="<?php echo $_LANG['ACCOUNT']['CANCEL']; ?>" class="button" taborder="7" border="0" height="46" width="174">
<?php } else { ?>
<!-- BACK-->		<a href="javascript:document.createaccount.save.value='false'; javascript:document.createaccount.step.value='userinfo'; javascript:document.createaccount.update.value='';  javascript:createaccount.submit()"><img src="shared/wow-com/images/buttons/button-back.gif" alt="<?php echo $_LANG['ACCOUNT']['BACK']; ?>" Width="91" Height="46" Border=0 CSSclass="button" taborder=7></a>
<!-- CONTINUE --><td width="174"><input type="image" SRC="shared/wow-com/images/buttons/button-continue.gif" NAME="submit" alt="<?php echo $_LANG['ACCOUNT']['CONTINUE']; ?>" Width="174" Height="46" Border=0 class="button"  taborder=6 >
<?php } ?>
										</td>
									</tr>
					            </table>
								</center>
								<img src = "new-hp/images/pixel.gif" width = "500" height = "1">
							</div>
							</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
<?php if ($haserrors!="") { ?>
		<script>
		document.createaccount.u.value='<?php echo $_POST['u']; ?>';
		document.createaccount.ask.value='<?php echo $_POST['ask']; ?>';
		document.createaccount.ans.value='<?php echo $_POST['ans']; ?>';
		document.createaccount.uptbc.checked=<?php echo $_POST['uptbc']; ?>;
		</script>

	<?php } else /*if ($_POST['update']=="accountinfo2")*/ { ?>
		<script>
		document.createaccount.u.value='<?php echo $_SESSION['CA_u']; ?>';
		document.createaccount.ask.value='<?php echo $_SESSION['CA_ask']; ?>';
		document.createaccount.ans.value='<?php echo $_SESSION['CA_ans']; ?>';
		document.createaccount.uptbc.checked=1<?php echo $_SESSION['CA_tbc']; ?>;
		</script>

<?php }
break;
case "userinfo": ////////////////USER INFO -3

?>
<script type="text/javascript">
function ca_valid() {

	if (document.createaccount.update.value=="userinfo") {
		document.createaccount.step.value='verifyaccount';
	} else if (document.createaccount.update.value=="userinfo2") {
		document.createaccount.step.value='verifyaccount';
	} else {
		document.createaccount.step.value="accountinfo";
		document.createaccount.update.value="userinfo";
	}
	document.createaccount.save.value="true";

	return true;
}
</script>
			<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
			<tr>

				<td width = "60%" style = "background-image: url('images/frame-left-bg.gif'); background-repeat: repeat-y;" bgcolor = "#E0BC7E">

					<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "background-image: url('images/frame-right-bg.gif'); background-repeat: repeat-y; background-position: top right;">
					<tr>
						<td width = "100%" rowspan = "2">


			<div style = "position: relative;">

				<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
				<div style = "padding:5px; background-image: url('new-hp/images/layout/header-gradiant.jpg'); background-repeat: no-repeat;">


			<h3 class="title"><?php echo $_LANG['ACCOUNT']['REG_STEP_3']; ?></h3>
			<p>

			<center>

						<table border=0 cellspacing=0 cellpadding=0><tr><td><img src="new-hp/images/navbar/left-end.gif" width="12" height="45" alt="" border="0"><td><td><img src="new-hp/images/navbar/step1b.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step2b.gif" width="73" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step3c.gif" width="73" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step4a.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step5a.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/right-end.gif" width="13" height="45" alt="" border="0"></td></tr></table>

			<p>

			<table width = "520">
			<tr>
			<td>

			<span>

<?php if ($haserrors) { ?>
			<center>

<?php errborder($haserrors); remslashall(); ?>
			</center>
			<br>
			<br>
<?php } ?>

			<?php echo $_LANG['ACCOUNT']['PERSONAL_DATA_INFO']; ?>

			<p>

			<?php echo $_LANG['ACCOUNT']['FIELDS_REQ']; ?>

			<p>

			<center>
			<a name = "address"></a>

			<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white"><?php echo $_LANG['ACCOUNT']['CONTACT_ADDRESS']; ?>:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>

			<table width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
			<table border=0 cellspacing=0 cellpadding=4>

			<tr>
			      <td width=200 align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      <font color="#FF0000">*</font> <?php echo $_LANG['ACCOUNT']['FIRST_NAME']; ?>:
			      </span></b></font>
			      </td>
			      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="fname" MaxLength="32" style = "Width:200" taborder=1 /></td><td valign = "top">

				   </td></tr></table></td>
			</tr>
			<tr>
			      <td align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      <font color="#FF0000">*</font> <?php echo $_LANG['ACCOUNT']['LAST_NAME']; ?>:
			      </span></b></font>
			      </td>

			      <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="lname" MaxLength="32" style = "Width:200" taborder=2 /></td><td valign = "top">

				   </td></tr></table></td>
			</tr>
			<tr>
			      <td align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      <font color="#FF0000">*</font> <?php echo $_LANG['ACCOUNT']['CITY']; ?>:
			      </span></b></font>
			      </td>
			      <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="city" MaxLength="32" style = "Width:150" taborder=5/ ></td><td valign = "top">

				   </td></tr></table></td>
			</tr>
			<tr>
			      <td align=right>
			      <font face="arial,helvetica" size=-1><span><b>

			      <font color="#FF0000">*</font> <?php echo $_LANG['ACCOUNT']['COUNTRY']; ?>:

			      </span></b></font>
			      </td>
			      <td align=left colspan = "2">
				  	<table border=0 cellspacing=0 cellpadding=2><tr>
						<td><select name="lo" style="width: 150;" OnChange="javascript:document.createaccount.cflag.src = 'new-hp/images/flags/' + this.value + '.gif';">
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
				<td><select name="shlo"><option value=1 SELECTED><?php echo $_LANG['ACCOUNT']['TO_EVERYONE']; ?><option value=0><?php echo $_LANG['ACCOUNT']['TO_ADMINS']; ?></td>
				</tr>
				</table>
				</td>
				</tr>
			</table>

			</td></tr></table>
			</td></tr></table>

			</center>

			<p>

			<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white"><?php echo $_LANG['ACCOUNT']['EMAIL_ADDRESS']; ?>:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>

			<center>
			<a name = "phone"></a>
			<table width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>

			<table border=0 cellspacing=0 cellpadding=4 width = "100%">
			<tr>
			      <td width=200 align=right>
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
					<?php echo $_LANG['ACCOUNT']['ENABLE_EMAIL']; ?>:<br>
					</span></b></font>
					</td>
					<td align=left>
					<table border=0 cellspacing=0 cellpadding=0>
						<tr>
							<td><select name="shem"><option value=1><?php echo $_LANG['ACCOUNT']['FOR_EVERYONE']; ?><option value=0 SELECTED><?php echo $_LANG['ACCOUNT']['FOR_ADMINS']; ?></td>
						</tr>
					</table>
				</td>
			</tr>
			</table>

			</td></tr></table>
			</td></tr></table>

			</center>

			<p>

			<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white"><?php echo $_LANG['ACCOUNT']['FORUM_SETTINGS']; ?>:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>

			<center>
			<a name = "phone"></a>
			<table width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;">
				<tr>
					<td>
						<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');">
							<tr>
								<td>
									<table border=0 cellspacing=0 cellpadding=4 width = "100%">
										<tr>
											<td width=200 align=right>
												<font face="arial,helvetica" size=-1><span><b>
												 <font color="#FF0000">*</font> <?php echo $_LANG['ACCOUNT']['DISPLAY_NAME']; ?>:<br>
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
												<?php echo $_LANG['ACCOUNT']['BIRTHDAY']; ?>:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><input type=text name="bd" maxlength="10"></td><td>&nbsp;<span>(<?php echo $_LANG['ACCOUNT']['DDMMAAAA']; ?>)</span></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												<?php echo $_LANG['ACCOUNT']['SHOW_BIRTHDAY']; ?>:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><select name="shbd"><option value=3><?php echo $_LANG['ACCOUNT']['DATE_AND_AGE']; ?><option value=1><?php echo $_LANG['ACCOUNT']['DATE']; ?><option value=2 SELECTED><?php echo $_LANG['ACCOUNT']['AGE']; ?><option value=0>No</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												<?php echo $_LANG['ACCOUNT']['GENDER']; ?>:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><select name="gender"><option value=0><?php echo $_LANG['ACCOUNT']['FEMALE']; ?><option value=1 SELECTED><?php echo $_LANG['ACCOUNT']['MALE']; ?>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right>
												<font face="arial,helvetica" size=-1><span><b>
												<?php echo $_LANG['ACCOUNT']['TIME_ZONE']; ?>:<br>
												</span></b></font>
												</td>
												<td align=left width=60%>
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
						document.createaccount.gmt.value='<?php echo $SETTING['WEB_GMT']; ?>';
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
												<?php echo $_LANG['ACCOUNT']['ENABLE_PM']; ?>:<br>
												</span></b></font>
												</td>
												<td align=left>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><select name="shpm"><option value=1 SELECTED><?php echo $_LANG['ACCOUNT']['FROM_EVERYONE']; ?><option value=0><?php echo $_LANG['ACCOUNT']['FROM_ADMINS']; ?>
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
												<td align=left width=60%>
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
											  <?php bbcode_toolbar('createaccount.sig'); ?>
											  </td><td valign = "top">
											   </td></tr></table></td>
										</tr>
										<tr>
											<td align=right valign=top width=40%>
												<font face="arial,helvetica" size=-1><span><b>
												<?php echo $_LANG['ACCOUNT']['SIGNATURE']; ?>:<br>
												</span></b></font>
												</td>
												<td align=left width=60%>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><textarea rows=4 name="sig" cols=40></textarea></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align=right width=40%>
												<font face="arial,helvetica" size=-1><span><b>
												<?php echo $_LANG['ACCOUNT']['HOMEPAGE_URL']; ?>:<br>
												</span></b></font>
												</td>
												<td align=left width=60%>
												<table border=0 cellspacing=0 cellpadding=0>
													<tr>
														<td><input type=text size=40 name="weburl"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
										  <td width=40% align=right>
										  <font face="arial,helvetica" size=-1><span><b>
										  <?php echo $_LANG['ACCOUNT']['SKIN']; ?>:<br>
										  </span></b></font>
										  </td>
										  <td 60% align=left>
										  <table border=0 cellspacing=0 cellpadding=0>
											<tr>
												<td><select name="skin" OnChange="javascript:changelayout(this.value);">
												<option value="" SELECTED><?php echo $_LANG['ACCOUNT']['DEFAULT']; ?>
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

			</center>

			<p>
				<center>

			            <table cellspacing = "0" cellpadding = "0" border = "0">
			            <tr>
			<td Width="91">
<?php if ($_POST['update']=="userinfo2") { ?>
<!-- UPDATE --><input onclick='javascript:document.createaccount.update.value="userinfo2");' src="shared/wow-com/images/buttons/update-button.gif" name="submit" alt="<?php echo $_LANG['ACCOUNT']['UPDATE']; ?>" class="button" taborder="6" border="0" height="46" type="image" width="174"><br>
<!-- CANCEL -->	<a href="javascript:document.createaccount.step.value='verifyaccount'; javascript:document.createaccount.update.value='';  javascript:createaccount.submit()"><img src="shared/wow-com/images/buttons/button-cancel.gif" alt="<?php echo $_LANG['ACCOUNT']['CANCEL']; ?>" class="button" taborder="7" border="0" height="46" width="174">
<?php } else { ?>
<!-- BACK-->		<a href="javascript:document.createaccount.save.value='false'; javascript:document.createaccount.step.value='valcode'; javascript:document.createaccount.update.value=''; javascript:createaccount.submit()"><img src="shared/wow-com/images/buttons/button-back.gif" alt="<?php echo $_LANG['ACCOUNT']['BACK']; ?>" Width="91" Height="46" Border=0 CSSclass="button" taborder=7></a>
<!-- CONTINUE --><td width="174"><input type="image" SRC="shared/wow-com/images/buttons/button-continue.gif" NAME="submit" alt="<?php echo $_LANG['ACCOUNT']['CONTINUE']; ?>" Width="174" Height="46" Border=0 class="button"  taborder=6 >
<?php } ?></td>

			</td>
			            </tr>
			            </table>

				</center>

			</span>
			</td>
			</tr>
			</table>
			</center>

			<img src = "images/pixel.gif" width = "500" height = "1">
			</div>
				</div>
					</tr>
					</table>


			</tr>
			</table>
	<?php if ($haserrors!="") { ?>
		<script type="text/javascript">
		document.createaccount.lname.value='<?php echo $_POST['lname']; ?>';
		document.createaccount.fname.value='<?php echo $_POST['fname']; ?>';
		document.createaccount.city.value='<?php echo $_POST['city']; ?>';
		document.createaccount.lo.value='<?php echo $_POST['lo']; ?>';
		document.createaccount.shbd.value='<?php echo $_POST['shbd']; ?>';
		document.createaccount.cflag.src = 'new-hp/images/flags/' + document.createaccount.lo.value + '.gif';
		document.createaccount.gmt.value='<?php echo $_POST['gmt']; ?>';
		document.createaccount.shlo.value='<?php echo $_POST['shlo']; ?>';
		document.createaccount.em.value='<?php echo $_POST['em']; ?>';
		document.createaccount.shem.value='<?php echo $_POST['shem']; ?>';
		document.createaccount.shpm.value='<?php echo $_POST['shpm']; ?>';
		document.createaccount.nick.value='<?php echo $_POST['nick']; ?>';
		document.createaccount.bd.value='<?php echo $_POST['bd']; ?>';
		document.createaccount.msn.value='<?php echo $_POST['msn']; ?>';
		document.createaccount.skype.value='<?php echo $_POST['skype']; ?>';
		document.createaccount.aim.value='<?php echo $_POST['aim']; ?>';
		document.createaccount.icq.value='<?php echo $_POST['icq']; ?>';
		document.createaccount.yahoo.value='<?php echo $_POST['yahoo']; ?>';
		document.createaccount.sig.value='<?php echo $_POST['sig']; ?>';
		document.createaccount.weburl.value='<?php echo $_POST['weburl']; ?>';
		document.createaccount.skin.value='<?php echo $_POST['skin']; ?>';
		document.createaccount.gender.value='<?php echo $_POST['gender']; ?>';
		</script>
	<?php } else /*if ($_POST['update']=="userinfo2")*/ { ?>
		<script type="text/javascript">
		document.createaccount.lname.value='<?php echo $_SESSION['CA_lname']; ?>';
		document.createaccount.fname.value='<?php echo $_SESSION['CA_fname']; ?>';
		document.createaccount.city.value='<?php echo $_SESSION['CA_city']; ?>';
		document.createaccount.lo.value='<?php echo $_SESSION['CA_lo']; ?>';
		document.createaccount.shbd.value='<?php echo $_SESSION['CA_shbd']; ?>';
		document.createaccount.cflag.src = 'new-hp/images/flags/' + document.createaccount.lo.value + '.gif';
		document.createaccount.gmt.value='<?php echo $_SESSION['CA_gmt']; ?>';
		document.createaccount.shlo.value='<?php echo $_SESSION['CA_shlo']; ?>';
		document.createaccount.em.value='<?php echo $_SESSION['CA_em']; ?>';
		document.createaccount.shem.value='<?php echo $_SESSION['CA_shem']; ?>';
		document.createaccount.shpm.value='<?php echo $_SESSION['CA_shpm']; ?>';
		document.createaccount.nick.value='<?php echo $_SESSION['CA_nick']; ?>';
		document.createaccount.bd.value='<?php echo $_SESSION['CA_bd']; ?>';
		document.createaccount.msn.value='<?php echo $_SESSION['msn']; ?>';
		document.createaccount.skype.value='<?php echo $_SESSION['CA_skype']; ?>';
		document.createaccount.aim.value='<?php echo $_SESSION['CA_aim']; ?>';
		document.createaccount.icq.value='<?php echo $_SESSION['CA_icq']; ?>';
		document.createaccount.yahoo.value='<?php echo $_SESSION['CA_yahoo']; ?>';
		document.createaccount.sig.value='<?php echo $_SESSION['CA_sig']; ?>';
		document.createaccount.weburl.value='<?php echo $_SESSION['CA_weburl']; ?>';
		document.createaccount.skin.value='<?php echo $_SESSION['CA_skin']; ?>';
		document.createaccount.gender.value='<?php echo $_SESSION['CA_gender']; ?>';
		</script>
	<?php
	}
break;
case "valcode": ////////////////SECURITY CODE -2

?>
<script type="text/javascript">
function ca_valid() {

	document.createaccount.update.value="valcode";
	document.createaccount.save.value="true";

	return true;
}
</script>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
		<tr>
			<td width = "78" valign = "top"></td>
			<td width = "100%" rowspan = "2">
				<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
					<div style = "padding:5px; background-image: url('new-hp/images/layout/header-gradiant.jpg'); background-repeat: no-repeat;">
						<h3 class="title"><?php echo $_LANG['ACCOUNT']['REG_STEP_2']; ?></h3>
						<p>
						<center>
						<table border=0 cellspacing=0 cellpadding=0><tr><td><img src="new-hp/images/navbar/left-end.gif" width="12" height="45" alt="" border="0"><td><td><img src="new-hp/images/navbar/step1b.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step2c.gif" width="73" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step3a.gif" width="73" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step4a.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/step5a.gif" width="74" height="45" alt="" border="0"></td><td><img src="new-hp/images/navbar/right-end.gif" width="13" height="45" alt="" border="0"></td></tr></table>
						<p>
						<table width = "520">
							<tr>
							  <td>
									<span>

<?php if ($haserrors!="") { ?>
			<center>

<?php errborder($haserrors); ?>
			</center>
			<br>
			<br>
<?php } ?>
									<table width = "520">
										<tr>
										  <td>
											<span>
											<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
											<tr>
												<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
												<td width = "100%" bgcolor = "#05374A" height = "20"><b class = "white"><?php echo $_LANG['ACCOUNT']['SECURITY_CHECK']; ?></b></td>
												<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
											</tr>
											</table>
									<table style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
										<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
											<table border=0 cellspacing=0 cellpadding=4 width = "510">
												<tr>
													<td colspan = "2">
													<span>
													<?php echo $_LANG['ACCOUNT']['SECURITY_CODE_INFO']; ?>
													</span>
													</td>
												</tr>
												<tr>
													<td colspan = "2">
													<span>

												<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>
													</span>
													</td>
												</tr>
												<tr>
													<td colspan = "2" align = "center">
													<table cellspacing = "0" cellpadding = "0" border = "0">
													<tr>
														<td colspan = "3"  background= "new-hp/images/layout/security-border-top.gif"><img src="new-hp/images/pixel.gif" width=300 height=4></td>
													</tr>
													<tr>
														<td background= "new-hp/images/layout/security-border-left.gif"><img src="new-hp/images/pixel.gif" width=3 height=70></td>
														<td align=center background="inc/account/account.securitycode.php?i=<? echo secuimg(8); ?>">
															<img src="new-hp/images/pixel.gif" width=293 height=1>
														</td>
														<td background = "new-hp/images/layout/security-border-right.gif"><img src="new-hp/images/pixel.gif" width=4 height=70></td>
													</tr>
													<tr>
														<td colspan = "3" background= "new-hp/images/layout/security-border-bot.gif"><img src="new-hp/images/pixel.gif" width=300 height=3></td>
													</tr>
													</table>
														<table border=0 cellspacing=0 cellpadding=4>
														<tr>
															  <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['SECURITY_INPUT']; ?>:</b></span></td>

															  <td NOWRAP align = "center">

																	<table border=0 cellspacing=0 cellpadding=0><tr><td><input name="key" MaxLength="8" Width="300" taborder=6 /></td><td valign = "top">
													   </td></tr></table>
															  </td>
														</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan = "2">
													<span>
														<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>
													</span>
													</td>
												</tr>
											</table>
										</td></tr></table>
									</td></tr></table>
									</span>

								</td>
										</tr></table>
								    <P>
								<center>
								<table cellspacing = "0" cellpadding = "0" border = "0">
								<tr>
<!-- BACK-->		<td Width="91"><a href="javascript:document.createaccount.step.value='agreement'; javascript:createaccount.submit()"><img src="shared/wow-com/images/buttons/button-back.gif" alt="<?php echo $_LANG['ACCOUNT']['BACK']; ?>" Width="91" Height="46" taborder=8></a></td>
<!-- CONTINUE-->	<td width="174"><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="<?php echo $_LANG['ACCOUNT']['CONTINUE']; ?>" Width="174" Height="46" Border=0 class="button"  taborder=7 ></td>
								</tr>
								</table>
							</center>
						<img src = "new-hp/images/pixel.gif" width = "500" height = "1">
						<center><span></td>
			<td width = "76" valign = "top"></td>
		</tr>
		<tr>
			<td valign = "bottom"></td>
			<td valign = "bottom"></td>
		</tr>
			</table>
		</td>
	</tr>
</table>
<?php
break;
default:
cleanCA($_POST['step']);

?>
<script type="text/javascript"> ////////////////AGREEMENT -1
function ca_valid() {
	document.createaccount.step.value="valcode";
	document.createaccount.update.value="";
	document.createaccount.save.value="";
	return true;
}
</script>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
	<tr>
		<td width = "60%">
			<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "background-image: url('new-hp/images/frame-right-bg.gif'); background-repeat: repeat-y; background-position: top right;">
				<tr>
					<td width = "78" valign = "top"></td>
					<td width = "100%" rowspan = "2">
						<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
							<div style = "padding:5px; background-image: url('new-hp/images/layout/header-gradiant.jpg'); background-repeat: no-repeat;">
								<h3 class="title">
									<?php
										$_LANG_msg = str_replace("SETTING_WEB_SITE_NAME",$SETTING['WEB_SITE_NAME'],$_LANG['ACCOUNT']['REG_STEP_1']);
										echo $_LANG_msg;
									?></h3>
								<p>
								<p>
								<center>
									<table border=0 cellspacing=0 cellpadding=0>
										<tr>
											<td><img src="new-hp/images/navbar/left-end.gif" width="12" height="45" alt="" border="0"></td>
											<td><img src="new-hp/images/navbar/step1c.gif" width="74" height="45" alt="" border="0"></td>
											<td><img src="new-hp/images/navbar/step2a.gif" width="73" height="45" alt="" border="0"></td>
											<td><img src="new-hp/images/navbar/step3a.gif" width="73" height="45" alt="" border="0"></td>
											<td><img src="new-hp/images/navbar/step4a.gif" width="74" height="45" alt="" border="0"></td>
											<td><img src="new-hp/images/navbar/step5a.gif" width="74" height="45" alt="" border="0"></td>
											<td><img src="new-hp/images/navbar/right-end.gif" width="13" height="45" alt="" border="0"></td>
										</tr>
									</table>
									<p>
									<table style = "border-width: 1px; border-style: dotted; border-color: #928058;" width = "80%">
										<tr>
											<td>
												<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');">
													<tr>
														<td>
															<table border=0 cellspacing=0 cellpadding=4>
																<tr>
																	<td align=left>
																		<span><?php echo $_LANG['ACCOUNT']['AGREEMENT_INFO']; ?></span>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<table border=0 cellspacing=0 cellpadding=4 width = "80%">
										<tr>
											<td align=left>
												<center>
												<img src = "new-hp/images/layout/hr.gif" width = "520" height = "1">
												</center>
												<span>
												<?php
													$fh = @fopen("inc/languages/".$_COOKIE['SITE_LANG']."/text.agreement.txt" , "r");
													echo bbcode(@fread($fh, filesize("inc/languages/".$_COOKIE['SITE_LANG']."/text.agreement.txt")));
													@fclose($fh);
												?>
												</span>
											</td>
										</tr>
									</table>
								</center>
								<p>
								<center>
									<table>
<!-- I AGREE-->	<tr><td><input TYPE="image" SRC="shared/wow-com/images/buttons/agree-button.gif" NAME="submit" alt="<?php echo $_LANG['ACCOUNT']['I_AGREE']; ?>" Width="174" Height="46" Border=0 class="button" ></td></tr>
<!-- I DISAGREE--><tr><td><a href = "index.php"><img src = "shared/wow-com/images/buttons/disagree-button.gif" alt = "<?php echo $_LANG['ACCOUNT']['I_DISAGREE']; ?>" Width="174" Height="46" border = "0"></a></td></tr>
									</table>
								</center>
								<img src = "new-hp/images/pixel.gif" width = "500" height = "1">
								<center><span>
							</div>
						</div>
					</td>
					<td width = "76" valign = "top"></td>
				</tr>
				<tr>
					<td valign = "bottom"></td>
					<td valign = "bottom"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php
break;
}

?>
</form>
<?php
}

parchdown();

?>

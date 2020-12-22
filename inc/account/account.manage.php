<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title($_LANG['ACCOUNT']['ACC_MANAG']);

image('manageacc');

parchdown();

parchup(true);

if  (!isset($_SESSION['userid'])) {

	errborder($_LANG['ACCOUNT']['NEED_TO_BE_LOGGED']."<META HTTP-EQUIV='Refresh' CONTENT='2; URL=?n=account.login'>");

} else {

	if ($_REQUEST['f']=='account') {
		$_POST['step']="accountinfo";
	} else if ($_REQUEST['f']=='contact') {
		$_POST['step']="userinfo";
	} else if ($_REQUEST['f']=='character') {
		$_POST['step']="charinfo";
	} else if ($_REQUEST['f']=='signature') {
		$_POST['step']="signature";
	}

$query=mysql_query("SELECT *, TIMESTAMPDIFF(MINUTE, last_login, NOW()) as lastlogin2, TIMESTAMPDIFF(MINUTE, joindate, NOW()) as joindate2 FROM account WHERE id='".$_SESSION['userid']."'") or die (mysql_error());
$row = mysql_fetch_array($query);
$query=mysql_query("SELECT *, DATE_FORMAT(`bday`,'%d/%m/%Y') as `bday`, TIMESTAMPDIFF(YEAR,`bday`, CONVERT_TZ(NOW(), '".$GMT[$SETTING['WEB_GMT']][0]."', '".verifygmt($_SESSION['userid'])."')) as `bdage` FROM forum_accounts WHERE id_account='".$_SESSION['userid']."'") or die (mysql_error());
$rowb = mysql_fetch_array($query);
?>
<form name="manageaccount" method="post" action="index.php?n=account.manage" onsubmit="ma_valid();">
<input type="hidden" name="step" value="">
<input type="hidden" name="update" value="">
<?php


if ($_POST['update'] == "userinfo" and $_POST['step']=="save") {

	if (strlen($_POST['fname'])<1 or strlen($_POST['fname'])>45) {
		$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_NAME'];		
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
			$query=mysql_query("SELECT email FROM account WHERE LOWER(email)=LOWER('".$_POST['em']."') and id!='".$row['id']."'");
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
			$query=mysql_query("SELECT displayname FROM forum_accounts WHERE LOWER(displayname)=LOWER('".$_POST['nick']."') and id_account !='".$row['id']."'");
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
	
} else if ($_POST['update']=="accountinfo" and $_POST['step']=="save") {

	if (strlen($_POST['np'])>0) {
		if (strlen($_POST['p'])<1 or strlen($_POST['p'])>16) {
			$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_OLD_ACC_PWD'];	
		} else {
			if (SHA1(strtoupper($row['username']).":".strtoupper($_POST['p']))!=$row['sha_pass_hash']) {
					$haserrors .= $_LANG['ACCOUNT']['INCORRECT_OLD_ACC_PWD'];		
			} 
		}
		if (strlen($_POST['np'])<6 or strlen($_POST['np'])>16) {
			$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_NEW_ACC_PWD'];		
		} else {
			if (alphanum($_POST['np'],true,true,'_')==false) {
				$haserrors .= $_LANG['ACCOUNT']['INVALID_CHAR_NEW_ACC_PWD'];		
			} else {
				if ($_POST['np']!=$_POST['cnp']) {
					$haserrors .= $_LANG['ACCOUNT']['NEW_ACC_VER_PWD_MISMATCH'];		
				} else {
					if ($row['username']==$_POST['np']) {
						$haserrors .= $_LANG['ACCOUNT']['NEW_ACC_NAME_PWD_MUST_DIFFER'];		
					}
				}
			}
		}
	}
	if ($_POST['ask']<1) {
		$haserrors .= $_LANG['ACCOUNT']['INVALID_OPTION_PASS_HINT'];
	} else {
		if (strlen($_POST['ans'])<1 or strlen($_POST['ans'])>255) {
			$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_ANSWER'];		
		}
	}

} else if ($_POST['update']=="charinfo" and $_POST['step']=="save") {
	if ($_POST['avatar']=='') {
		$_POST['update']="nochar";
	}
}

if ($haserrors=="") {
	$_SESSION['MA_saveset'] = true;
} else {
	$_SESSION['MA_saveset'] = false;
	$_POST['step']=$_POST['update'];
}

switch($_POST['step']) {

	case "save": ////////////////SAVE
	
		if ($_POST['update']=="accountinfo" and $haserrors=="") {
			if ($_POST['np']=='') { $_POST['np']=$row['sha_pass_hash']; } else { $_POST['np']=strtoupper($row['username']).":".strtoupper($_POST['np']); }
			$savequery=mysql_query("UPDATE account SET sha_pass_hash=SHA1('".$_POST['np']."'), expansion='".$_POST['uptbc']."' WHERE id='".$row['id']."'") or die (mysql_error());
			$savequery=mysql_query("UPDATE forum_accounts SET passask='".$_POST['ask']."', passans='".$_POST['ans']."' WHERE id_account='".$row['id']."'") or die (mysql_error());
			
			$_SESSION['password'] = $_POST['np'];
			?>
			<script>
				setCookie("ALOG_PASS",'<?php echo $_POST['np']; ?>', now);
			</script>
			<?
			
			goodborder($_LANG['SUCCESS']['ACCOUNT_UPDATED']);
			
			break;

		} else if ($_POST['update']=="userinfo" and $haserrors=="") {
			
			$_POST['bd'] = explode("/",$_POST['bd']);
			$_POST['bd'] = $_POST['bd'][2] . "-" . $_POST['bd'][1] . "-" . $_POST['bd'][0];
			
			$savequery=mysql_query("UPDATE account SET email='".$_POST['em']."' WHERE id='".$row['id']."'") or die (mysql_error());
			$queryb=mysql_query("UPDATE forum_accounts SET displayname='".$_POST['nick']."', location='".$_POST['lo']."', showlocation='".$_POST['shlo']."', bday='".$_POST['bd']."', showbday='".$_POST['shbd']."',
			signature='".$_POST['sig']."', enableemail='".$_POST['shem']."',gmt='".$_POST['gmt']."',webpage='".$_POST['weburl']."',
			fname='".$_POST['fname']."',lname='".$_POST['lname']."',city='".$_POST['city']."',aim='".$_POST['aim']."',msn='".$_POST['msn']."',yahoo='".$_POST['yahoo']."',
			skype='".$_POST['skype']."',icq='".$_POST['icq']."',enablepm='".$_POST['shpm']."', template='".$_POST['skin']."', gender='".$_POST['gender']."' WHERE id_account='".$row['id']."'") or die (mysql_error());
						
			goodborder($_LANG['SUCCESS']['ACCOUNT_UPDATED']);
			
		} else if ($_POST['update']=="charinfo" and $haserrors=="") {
		
			$savequery=mysql_query("UPDATE forum_accounts SET avatar='".$_POST['avatar']."' WHERE id_account='".$row['id']."'") or die (mysql_error());
			
			goodborder($_LANG['SUCCESS']['ACCOUNT_UPDATED']);
			
		} else if ($_POST['update']=="signature" and $haserrors=="") {
		
			//$savequery=mysql_query("") or die (mysql_error());
			
			goodborder($_LANG['SUCCESS']['ACCOUNT_UPDATED']);
		
		} else {
		
			if ($_SESSION['MA_saveset']==false) { echo '<META HTTP-EQUIV=REFRESH CONTENT="0; URL=index.php?n=account.manage">'; }
		
		}
		
		unset($_POST['step']);
		unset($_SESSION['MA_saveset']);
		
		break;
	case "charinfo": ////////////////CHARACTER INFO (FORUM)
		
		?>
<script type="text/javascript">
function ma_valid() {

	void(document.manageaccount.update.value="charinfo");
	void(document.manageaccount.step.value="save");

	return true;		
}
</script>
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
<input type="hidden" name="avatar" value="nochar">
<div id="character-post-info"><img src="new-hp/images/pixel.gif" height="1"><span class="mine">Please, Select a Character Avatar to Represent you in Forums:</span>
</div><br>
<table border="0" cellspacing="5" cellpadding="5" align="center" bgcolor=black width=500>
	<tr>
		<td align=center>
<?php
	$splitline=3;
	$charset[0]=$rowb['displayname'];
	$upname[0] = 'manageaccount';
	$imgset[0] = 'nochar';
	if ($row['id']==$SETTING['SERVER_OWNER']) { $row['gmlevel']=4; }
	if ($row['gmlevel']>0) { $imgset[1] = $row['gmlevel']; } else if ($rowb['ismvp']=='1') { $imgset[1] = 'mvp'; }
	
	$upname[1] = 'nochar';
	if ($upname[1]==$rowb['avatar']) { $upname[2]='sel'; } else { $upname[2]=''; }
    charavatar($charset, $imgset, $upname);
	echo '</td>';
	
	$qquery = mysql_query("SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
	rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (`realm_settings` rs) ON r.id = rs.id_realm 
	GROUP BY r.id ORDER BY r.name", $MySQL_CON) OR DIE(mysql_error());
	$i=1;
	while ($rowx = mysql_fetch_array($qquery)) {
		$newcon = @mysql_connect($rowx['rsdbhost'].':'.$rowx['rsdbport'], $rowx['rsdbuser'], $rowx['rsdbpass']);;
		$newdb = @mysql_select_db ($rowx['rsdbname'], $newcon);
		$newquery = @mysql_query("SELECT guid, name, data, class, race FROM `characters` WHERE `account`='".$row['id']."'", $newcon);
			while($rowc = @mysql_fetch_array($newquery)) {
				if (is_int($i/$splitline)) { echo '</tr><tr>'; }
				echo '<td align=center>';
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
				if ($upname[1]==$rowb['avatar']) { $upname[2]='sel'; } else { $upname[2]=''; }
				charavatar($charset, '', $upname);
				echo '</td>';
				$i++;
			} 
	}
	if ($row['gmlevel']>0) {
		foreach (glob('new-hp/images/forum/portraits/gm/*.gif') as $tempname) {
			if (is_int($i/$splitline)) { echo '</tr><tr>'; }
			echo '<td align=center>';
			$charset[0]=$rowb['displayname'];
			$imgset[0] = str_replace('new-hp/images/forum/portraits/', '', $tempname);
			$upname[1] = $imgset[0];
			if ($upname[1]==$rowb['avatar']) { $upname[2]='sel'; } else { $upname[2]=''; }
			charavatar($charset, $imgset, $upname);
			echo '</td>';
			$i++;
		}
	}
	if ($rowb['ismvp']=='1') { 
		foreach (glob('new-hp/images/forum/portraits/mvp/*.gif') as $tempname) {
			if (is_int($i/$splitline)) { echo '</tr><tr>'; }
			echo '<td align=center>';
			$charset[0]=$rowb['displayname'];
			$imgset[0] = str_replace('new-hp/images/forum/portraits/', '', $tempname);
			$upname[1] = $imgset[0];
			if ($upname[1]==$rowb['avatar']) { $upname[2]='sel'; } else { $upname[2]=''; }
			charavatar($charset, $imgset, $upname);
			echo '</td>';
			$i++;
		}
	}
?>
	</tr>
</table>

</form>
		<?
		
	break;	
	case "accountinfo": ////////////////ACCOUNT INFO -4
	
?>
<script type="text/javascript">
function ma_valid() {

	void(document.manageaccount.update.value="accountinfo");
	void(document.manageaccount.step.value="save");

	return true;		
}
</script>
				<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%">
				<tr>

					<td width = "60%" style = "background-image: url('new-hp/images/frame-left-bg.gif'); background-repeat: repeat-y;" bgcolor = "#E0BC7E">

						<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "background-image: url('new-hp/images/frame-right-bg.gif'); background-repeat: repeat-y; background-position: top right;">
						<tr>
							<td width = "100%" rowspan = "2">


				<div style = "position: relative;">

					<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; background-color: #E7CFA3; line-height:140%;">
				<center>

				<table width = "520">
				<tr>
				<td>

				<span>
<?php if ($haserrors) { ?>
			<center>

<?php errborder($haserrors); ?>
			</center>
			<br>
			<br>
<?php } ?>
				<img src = "new-hp/images/orc2.jpg" width = "170" height = "280" align = "right">

				<?php echo $_LANG['ACCOUNT']['INFO_CHOOSE_PASSWD']; ?>
				<p>

				<img src = "new-hp/images/pixel.gif" width = "10" height = "150" align = "left">
						
				
				<table cellspacing = "0" cellpadding = "0" border = "0" width = "305">
				<tr>
					<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
					<td width = "100%" bgcolor = "#05374A"><b class = "white">Password Rules:</b></td>
					<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
				</tr>

				</table>
						
						
				<!--PlainBox Top-->
				<table cellspacing = "0" cellpadding = "0" border = "0" width = "305"><tr><td><img src = "new-hp/images/plainbox/plainbox-top-left.gif" width = "3" height = "3" border = "0"></td><td background = "new-hp/images/plainbox/plainbox-top.gif"></td><td><img src = "new-hp/images/plainbox/plainbox-top-right.gif" width = "3" height = "3" border = "0"></td></tr><tr><td background = "new-hp/images/plainbox/plainbox-left.gif"></td><td bgcolor = "#CDB68E">														
				<!--PlainBox Top-->
				<span>
				<ul><?php echo $_LANG['ACCOUNT']['PWD_CHAR_TYPES_ADVICE']; ?>
				</span>
				<!--PlainBox Bottom-->
				</td><td background = "new-hp/images/plainbox/plainbox-right.gif"></td></tr><tr><td><img src = "new-hp/images/plainbox/plainbox-bot-left.gif" width = "3" height = "3" border = "0"></td><td background = "new-hp/images/plainbox/plainbox-bot.gif"></td><td><img src = "new-hp/images/plainbox/plainbox-bot-right.gif" width = "3" height = "3" border = "0"></td></tr></table>
				<!--PlainBox Bottom-->
				<p><br>	<br>
				<?php echo $_LANG['ACCOUNT']['PWD_HINT_INFO']; ?>

				</span>
				</td>
				</tr>
				</table>
				</center>
				<p>

				<br>
				<center>
				<table style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
				<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
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

				      <td align=right NOWRAP><span><b>Account Name:</b></span></td>
				      
				      <td align=left NOWRAP>
				      <table border=0 cellspacing=0 cellpadding=0><tr><td><?php echo $row['username']; ?></td><td valign = "top">


					   </td></tr></table>
					  </td>
				      

				</tr>
				<tr>
				      <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['OLD_ACC_PWD']; ?>:</b></span></td>
				      
				      <td align=left>
				      <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="p" MaxLength=16 width=150 type=Password taborder="2" /></td><td valign = "top">

					   </td></tr></table>
				      </td>
				      
				</tr>
				<tr>
				      <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['NEW_ACC_PWD']; ?>:</b></span></td>
				      
				      <td align=left>
				      <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="np" MaxLength=16 width=150 type=Password taborder="2" /></td><td valign = "top">

					   </td></tr></table>
				      </td>
				      
				</tr>
				<tr>
				      <td align=right><span><b><?php echo $_LANG['ACCOUNT']['VERIFY_NEW_PWD']; ?>:</b></span></td>
				      
				      <td align=left>
				      <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="cnp" MaxLength=16 width=150 type=Password taborder="3" /></td><td valign = "top">


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
					  <table border=0 cellspacing=0 cellpadding=0><tr><td><input name="ans" value="" MaxLength=32 width=150 taborder="5" value="" taborder=5/></td><td valign = "top">


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
							  <table border=0 cellspacing=0 cellpadding=0><tr><td><label for='upgtbc2'><input type=radio value='0' id="upgtbc2" name="uptbc"> No Expansion</label></td><td valign = "top">
						   </td></tr></table></td>
					</tr>
                     <tr>
						  <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['UPGRADES']; ?>:</b></span></td>

							  <td align=left NOWRAP>
							  <table border=0 cellspacing=0 cellpadding=0><tr><td><label for='upgtbc1'><input type=radio value='1' id="upgtbc1" name="uptbc"> The Burning Crusades</label></td><td valign = "top">
						   </td></tr></table></td>
					</tr>
				<tr>
						  <td align=right NOWRAP><span><b><?php echo $_LANG['ACCOUNT']['UPGRADES']; ?>:</b></span></td>

							  <td align=left NOWRAP>
							  <table border=0 cellspacing=0 cellpadding=0><tr><td><label for='upgtbc'><input type=radio value='32' id="upgtbc" name="uptbc"> Wrath of the Lich King</label></td><td valign = "top">
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

				</td></tr></table>
				</td></tr></table>

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
<!-- UPDATE --><input src="shared/wow-com/images/buttons/update-button.gif" name="submit" alt="<?php echo $_LANG['ACCOUNT']['UPDATE']; ?>" class="button" taborder="6" border="0" height="46" type="image" width="174"><br>
<!-- CANCEL -->	<a href="index.php?n=account.manage"><img src="shared/wow-com/images/buttons/button-cancel.gif" alt="<?php echo $_LANG['ACCOUNT']['CANCEL']; ?>" class="button" taborder="7" border="0" height="46" width="174"> 
</td>		
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
<?php if ($haserrors=="") { ?>
	<script>
	document.manageaccount.ask.value='<?php echo $rowb['passask']; ?>';
	document.manageaccount.ans.value='<?php echo $rowb['passans']; ?>';
	document.manageaccount.uptbc.checked=<?php echo $row['tbc']; ?>;
	</script>
<?php
} else {
?>
	<script>
	document.manageaccount.ask.value='<?php echo $_POST['ask']; ?>';
	document.manageaccount.ans.value='<?php echo $_POST['ans']; ?>';
	document.manageaccount.uptbc.checked=<?php echo $_POST['uptbc']; ?>;
	</script>
<?php
}
break;
	case "userinfo": ////////////////USER INFO -3

?>
<script type="text/javascript">
function ma_valid() {

	void(document.manageaccount.step.value="save");	
	void(document.manageaccount.update.value="userinfo");	

	return true;	
}
</script>	
			<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" >
			<tr>

				<td width = "60%" bgcolor = "#E0BC7E">

					<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "background-image: url('images/frame-right-bg.gif'); background-repeat: repeat-y; background-position: top right;">
					<tr>
						<td width = "100%" rowspan = "2">


			<div style = "position: relative;">

				<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; background-color: #E7CFA3; line-height:140%;">
				
				<center>

			<table width = "520">
			<tr>
			<td>

			<span>

<?php if ($haserrors) { ?>
			<center>

<?php errborder($haserrors); ?>
			</center>
			<br>
			<br>
<?php } ?>

			<?php echo $_LANG['ACCOUNT']['PERSONAL_DATA_INFO_2']; ?>

			<p>

			<b><?php echo $_LANG['ACCOUNT']['REQUIRED_FIELDS']; ?></b>  

			<p>

			<center>
			<a name = "address"></a>

			<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white">Contact Address:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>

			<table width = "520" style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
			<table border=0 cellspacing=0 cellpadding=4>

			<tr>
			      <td width=200 align=right>
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
						<td><select name="lo" style="width: 150;" OnChange="javascript:document.createaccount.cflag.src = 'new-hp/images/Flags/' + this.value + '.gif';">
<?
foreach ($COUNTRY as $key=>$value) {
	echo '<option value="'.$key.'">'.$value.'</option>';
}
?></selected>
						</td>
						<td><img name="cflag" src="new-hp/images/Flags/00.gif"></td>
				   </tr></table>
			      </td>
			</tr>
				<tr>
				<td align=right>
				<font face="arial,helvetica" size=-1><span><b>
				<?php echo $_LANG['ACCOUNT']['SHOW_LOCATION']; ?>:<br>
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
					Enable Email:<br>
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
											  <?php bbcode_toolbar('manageaccount.sig'); ?>
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
														<td><textarea name="sig" style="width: 270px; height: 100px"><?php if ($haserrors!='') { echo $_POST['sig']; } else { echo $rowb['signature']; } ?></textarea></td>
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

			</center>

			<p>
				<center>
			            
			            <table cellspacing = "0" cellpadding = "0" border = "0">
			            <tr>
			<td Width="91">
<!-- UPDATE --><input src="shared/wow-com/images/buttons/update-button.gif" name="submit" alt="<?php echo $_LANG['ACCOUNT']['UPDATE']; ?>" class="button" taborder="6" border="0" height="46" type="image" width="174"><br>
<!-- CANCEL -->	<a href="index.php?n=account.manage"><img src="shared/wow-com/images/buttons/button-cancel.gif" alt="<?php echo $_LANG['ACCOUNT']['CANCEL']; ?>" class="button" taborder="7" border="0" height="46" width="174"> 
</td>
							
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
	<?php if ($haserrors=="") { ?>
		<script>
		void(document.manageaccount.fname.value='<?php echo $rowb['fname']; ?>');
		void(document.manageaccount.lname.value='<?php echo $rowb['lname']; ?>');
		void(document.manageaccount.city.value='<?php echo $rowb['city']; ?>');
		void(document.manageaccount.lo.value='<?php echo $rowb['location']; ?>');
		<?php if ($rowb['bday']!='00/00/0000') { ?> void(document.manageaccount.bd.value='<?php echo $rowb['bday']; ?>'); <?php } ?>
		void(document.manageaccount.shbd.value='<?php echo $rowb['showbday']; ?>');
		void(document.manageaccount.cflag.src = 'new-hp/images/Flags/' + document.manageaccount.lo.value + '.gif');
		void(document.manageaccount.gmt.value='<?php echo $rowb['gmt']; ?>');
		void(document.manageaccount.shlo.value='<?php echo $rowb['showlocation']; ?>');
		void(document.manageaccount.shem.value='<?php echo $rowb['enableemail']; ?>');
		void(document.manageaccount.em.value='<?php echo $row['email']; ?>');
		void(document.manageaccount.shpm.value='<?php echo $rowb['enablepm']; ?>');
		void(document.manageaccount.msn.value='<?php echo $rowb['msn']; ?>');
		void(document.manageaccount.skype.value='<?php echo $rowb['skype']; ?>');
		void(document.manageaccount.aim.value='<?php echo $rowb['aim']; ?>');
		void(document.manageaccount.icq.value='<?php echo $rowb['icq']; ?>');
		void(document.manageaccount.yahoo.value='<?php echo $rowb['yahoo']; ?>');
		void(document.manageaccount.weburl.value='<?php echo $rowb['weburl']; ?>');
		void(document.manageaccount.skin.value='<?php echo $rowb['template']; ?>');
		void(document.manageaccount.nick.value='<?php echo $rowb['displayname']; ?>');
		void(document.manageaccount.gender.value='<?php echo $rowb['gender']; ?>');
		</script>
	<?php
	} else {
	?>
		<script>
		document.manageaccount.lname.value='<?php echo $_POST['lname']; ?>';
		document.manageaccount.fname.value='<?php echo $_POST['fname']; ?>';
		document.manageaccount.city.value='<?php echo $_POST['city']; ?>';
		document.manageaccount.lo.value='<?php echo $_POST['lo']; ?>';
		document.manageaccount.shbd.value='<?php echo $_POST['shbd']; ?>';
		document.manageaccount.cflag.src = 'new-hp/images/Flags/' + document.manageaccount.lo.value + '.gif';
		document.manageaccount.gmt.value='<?php echo $_POST['gmt']; ?>';
		document.manageaccount.shlo.value='<?php echo $_POST['shlo']; ?>';
		document.manageaccount.em.value='<?php echo $_POST['em']; ?>';
		document.manageaccount.shem.value='<?php echo $_POST['shem']; ?>';
		document.manageaccount.shpm.value='<?php echo $_POST['shpm']; ?>';
		document.manageaccount.nick.value='<?php echo $_POST['nick']; ?>';
		document.manageaccount.bd.value='<?php echo $_POST['bd']; ?>';
		document.manageaccount.msn.value='<?php echo $_POST['msn']; ?>';
		document.manageaccount.skype.value='<?php echo $_POST['skype']; ?>';
		document.manageaccount.aim.value='<?php echo $_POST['aim']; ?>';
		document.manageaccount.icq.value='<?php echo $_POST['icq']; ?>';
		document.manageaccount.yahoo.value='<?php echo $_POST['yahoo']; ?>';
		document.manageaccount.weburl.value='<?php echo $_POST['weburl']; ?>';
		document.manageaccount.skin.value='<?php echo $_POST['skin']; ?>';
		document.manageaccount.gender.value='<?php echo $_POST['gender']; ?>';
		</script>
	<?php
	}
	break;
	case "signature":
	
	subtitle('Armory Character Signature Design and Layout Workbench:');
	
	?>
	<script type="text/javascript">
	function ma_valid() {

		void(document.manageaccount.update.value="signature");
		void(document.manageaccount.step.value="save");

		return true;		
	}
	</script>
	<style type="text/css">
	.drsElement { position: absolute; margin: 0 0 0 0; padding: 0 0 0 0; background-position: 0px 0px; }
	.drsMoveHandle { height: 20px; cursor: move; }
	.dragresize { position: absolute; width: 5px; height: 5px; font-size: 1px; border: 1px solid #333; }
	.dragresize-tl { top: -8px; left: -8px; cursor: nw-resize;	}
	.dragresize-tm { top: -8px; left: 50%; margin-left: -4px; cursor: n-resize;}
	.dragresize-tr { top: -8px; right: -8px; cursor: ne-resize;	}
	.dragresize-ml { top: 50%; margin-top: -4px; left: -8px; cursor: w-resize; }
	.dragresize-mr { top: 50%; margin-top: -4px; right: -8px; cursor: e-resize; }
	.dragresize-bl { bottom: -8px; left: -8px; cursor: sw-resize; }
	.dragresize-bm { bottom: -8px; left: 50%; margin-left: -4px; cursor: s-resize; }
	.dragresize-br { bottom: -8px; right: -8px; cursor: se-resize; }
	</style>
	<script type="text/javascript" src="new-hp/js/dragresize.js"></script>
	<script>
	var db_obj_char_name = 0;
	var db_obj_border = 0;
	var db_obj_avatar = 0;
	var db_obj_background = 0;
	var focus_obj = '';
	
	function wb_resize(changeinto) {
	
		wb_area.style.cssText += changeinto;
		document.getElementById('wb_tb_size_height').value = wb_area.style.height;
		document.getElementById('wb_tb_size_width').value = wb_area.style.width;
			
		dragresize = new DragResize('dragresize',
		{ minWidth: 0, minHeight: 0, minLeft: 0, minTop: 0, maxLeft: document.getElementById('workbench_space').style.width.replace('px',''), maxTop: document.getElementById('workbench_space').style.height.replace('px','') });
		
		dragresize.isElement = function(elm) {
		 if (elm.className && elm.className.indexOf('drsElement') > -1) return true;
		};
		dragresize.isHandle = function(elm) {
		 if (elm.className && elm.className.indexOf('drsMoveHandle') > -1) return true;
		};
		
		dragresize.ondragfocus = function() { };
		dragresize.ondragstart = function(isResize) { };
		dragresize.ondragmove = function(isResize) { };
		dragresize.ondragend = function(isResize) { };
		dragresize.ondragblur = function() { };
		
		dragresize.apply(document);
	}
	
	function setfocus(wb_obj){
	
		focus_obj = wb_obj;
		if (wb_obj!='') {
			document.getElementById('wb_tb_font_type').value = wb_obj.style.fontFamily;
			document.getElementById('wb_tb_font_size').value = wb_obj.style.fontSize.replace('pt','');
			document.getElementById('wb_tb_font_color').value = wb_obj.style.color.replace('rgb(','').replace(')','');
		}
	}
	
	setfocus('');
	
	function remove_obj() {
		if (focus_obj!='') {;
			wb_area.removeChild(focus_obj);
			setfocus('');
		}
	}
	
	function sendback_obj() {
		if (focus_obj!='') {;
			zIndex=1;
			focus_obj.style.cssText += 'z-index: 0;';			
			focus_obj='';
		}
	}
	
	function add_obj(wb_obj) {
		var newobj='';
		switch (wb_obj) {
		case "wb_obj_char_name":
			db_obj_char_name += 1;
			wb_area.innerHTML += '<div id="wb_obj_char_name_' + db_obj_char_name + '" name="wb_obj_char_name[]" onclick="setfocus(this);" class="drsElement drsMoveHandle" style="margin:0 0 0 0; left: 0px; top: 0px; width: 136px; height: 20px; text-align: left; white-space: nowrap; font-family: morpheus; font-size: 16pt; color: rgb(0,0,0); background: url(\'inc/armory/armory.charactersignature.php?type=genimg&text=Charcter_Name&font=morpheus&size=16&color=0,0,0\') no-repeat 0px 0px;"></div>';
			setfocus(document.getElementById(wb_obj + '_' + db_obj_char_name));
		break;
		case "wb_obj_border":
			db_obj_border += 1;
			wb_area.innerHTML += '<div id="wb_obj_border_' + db_obj_border + '" name="wb_obj_border[]" onclick="setfocus(this);" class="drsElement drsMoveHandle" style="left: 0px; top: 0px; width: 50px; height: 50px; text-align: left; white-space: nowrap; font-family: fritzquadrata; font-size: 16pt; color: rgb(0,0,0)"><table cellpadding=0 cellspacing=0 width=100% height=100%><tr><td width=0% height=0%><img src="new-hp/images/signature/other/Border-TL.png"></td><td background="new-hp/images/signature/other/Border-TC.png"></td><td><img src="new-hp/images/signature/other/Border-TR.png"></td></tr><tr><td background="new-hp/images/signature/other/Border-ML.png"></td><td width=100% height=100%></td><td style="background: url(\'new-hp/images/signature/other/Border-MR.png\') repeat-y 1px 0px;"></td></tr><tr><td><img src="new-hp/images/signature/other/Border-BL.png"></td><td style="background: url(\'new-hp/images/signature/other/Border-BC.png\') repeat-x 0px 1px;"></td><td width=0% height=0%><img class="img" src="new-hp/images/signature/other/Border-BR.png"></td></tr></table></div>';
			setfocus(document.getElementById(wb_obj + '_' + db_obj_border));
		break;
		case "wb_obj_avatar":
			db_obj_border += 1;
			wb_area.innerHTML += '<div id="wb_obj_avatar_' + db_obj_border + '" name="wb_obj_avatar[]"  onclick="setfocus(this);" class="drsElement drsMoveHandle" style="left: 0px; top: 0px; width: 30px; height: 30px;"><img src="new-hp/images/signature/other/Avatar.png" width=100% height=100%></div>';
			setfocus(document.getElementById(wb_obj + '_' + db_obj_border));
		break;
		case "wb_obj_background":
			db_obj_background += 1;
			wb_area.innerHTML += '<div id="wb_obj_background_' + db_obj_background + '" name="wb_obj_background[]"  onclick="setfocus(this);" class="drsElement drsMoveHandle" style="left: 0px; top: 0px; width: 50px; height: 30px;"><img src="new-hp/images/signature/other/Background-GM.png" width=100% height=100%></div>';
			setfocus(document.getElementById(wb_obj + '_' + db_obj_background));
		break;
		case "wb_obj_logo_background":
			db_obj_background += 1;
			wb_area.innerHTML += '<div id="wb_obj_logo_background_' + db_obj_background + '" name="wb_obj_logo_background[]"  onclick="setfocus(this);" class="drsElement drsMoveHandle" style="left: 0px; top: 0px; width: 50px; height: 30px;"><img src="new-hp/images/signature/other/Logo_Background-WoW.png" width=100% height=100%></div>';
			setfocus(document.getElementById(wb_obj + '_' + db_obj_background));
		break;
		case "wb_obj_line":
			db_obj_background += 1;
			wb_area.innerHTML += '<div id="wb_obj_lline_' + db_obj_background + '" name="wb_obj_line[]"  onclick="setfocus(this);" class="drsElement drsMoveHandle" style="left: 0px; top: 0px; width: 50px; height: 30px;"><img src="new-hp/images/signature/other/Line.png" width=100% height=100%></div>';
			setfocus(document.getElementById(wb_obj + '_' + db_obj_background));
		break;
		}
		
	}
	
	function applypropertie(changeinto) {
		if (focus_obj!='') {
			focus_obj.style.cssText += changeinto;
			focus_obj.style.cssText += 'background: url(inc/armory/armory.charactersignature.php?type=genimg&text='+'Changed!'+'&font='+document.getElementById('wb_tb_font_type').value+'&size='+document.getElementById('wb_tb_font_size').value+'&color='+document.getElementById('wb_tb_font_color').value.replace('rgb(','').replace(')','')+') no-repeat 0px 0px;';
		}
	}
	</script>
	<table cellpadding=0 cellspacing=0 align=center height=100%>
	<tr>
		<td>	
		</td>
		<td>
		<div id="workbench_toolbar">
			<table cellpadding=2 cellspacing=2 style="background-color: #999999; border: 2px solid black; color: white; font-size: 12px;">
				<tr>
				<td>Area Width:<br><select id="wb_tb_size_width" onChange="wb_resize('width:'+ this.value +'px;');"><option value="450">450<option value="496">496</select></td>
				<td>Area Height:<br><select id="wb_tb_size_height" onChange="wb_resize('height:'+ this.value +'px;');"><option value="64">64<option value="95">95</select></td>
				<td>Font Type:<br><select id="wb_tb_font_type" onChange="applypropertie('font-family:'+ this.value +';');"><option value="morpheus">Morpheus<option value="fritzquadrata">FritzQuadrata</select></td>
				<td>Font Size:<br><select id="wb_tb_font_size" onChange="applypropertie('font-size:'+ this.value +'pt;');"><option value="8">8<option value="11">11<option value="12">12<option value="14">14<option value="16">16</select></td>
				<td>Font Color:<br><select id="wb_tb_font_color" onChange="applypropertie('color:rgb('+ this.value+');');"><option value="0,0,0" style="background: #000000; color: white;">Black<option value="255,255,255" style="background: #FFFFFF;">White</select></td>
				<td><a  href="javascript:sendback_obj();"><img src="new-hp/images/v2/sendback.png"></a><br><a  href="javascript:remove_obj();"><img src="new-hp/images/v2/remove.gif"></a></td>
				</tr>
			</table>
		</div>
		</td>
	<tr valign=top style="background-color: #999999;">	
		<td style="border: 2px solid black;" align=center>
			<!-- ITEM LIST START -->
			<table  cellpadding=0 cellspacing=0 style="color: white; font-size: 12px; width: 150px;">
			<tr>
				<td colspan=2 align=center><span style="font-size: 14px;"><b>Add New Item</b><br>
				</td>
			</tr>
			<tr>
				<td><a href="javascript:add_obj('wb_obj_background');"><img src="new-hp/images/v2/add.gif"></a>
				</td>
				<td align=left>Background:
				</td>
			</tr>
			<tr>
				<td colspan=2 align=center>
					<div style="left: 0px; top: 0px; width: 50px; height: 30px;"><img src="new-hp/images/signature/other/Background-GM.png" width=100% height=100%></div>
				</td>
			</tr>
			<tr>
				<td><a href="javascript:add_obj('wb_obj_border');"><img src="new-hp/images/v2/add.gif"></a>
				</td>
				<td align=left>Border:
				</td>
			</tr>
			<tr>
				<td colspan=2 align=center>
					<div style="left: 0px; top: 0px; width: 50px; height: 20px; text-align: left; white-space: nowrap; font-family: fritzquadrata; font-size: 16pt; color: rgb(0, 0, 0)">
						<table cellpadding=0 cellspacing=0 width=20 height=20>
						<tr><td width=0% height=0%><img src="new-hp/images/signature/other/Border-TL.png"></td>
							<td background="new-hp/images/signature/other/Border-TC.png"></td>
							<td><img src="new-hp/images/signature/other/Border-TR.png"></td></tr>
						<tr><td background="new-hp/images/signature/other/Border-ML.png"></td>
							<td width=100% height=100%></td>
							<td style="background: url('new-hp/images/signature/other/Border-MR.png') repeat-x 1px 0px;"></td></tr>
						<tr><td><img src="new-hp/images/signature/other/Border-BL.png"></td>
							<td style="background: url('new-hp/images/signature/other/Border-BC.png') repeat-x 0px 1px;"></td>
							<td width=0% height=0%><img class="img" src="new-hp/images/signature/other/Border-BR.png"></td></tr>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td><a href="javascript:add_obj('wb_obj_logo_background');"><img src="new-hp/images/v2/add.gif"></a>
				</td>
				<td align=left>Logo Background:
				</td>
			</tr>
			<tr>
				<td colspan=2 align=center>
					<div style="left: 0px; top: 0px; width: 50px; height: 30px;"><img src="new-hp/images/signature/other/Logo_Background-WoW.png" width=100% height=100%></div>
				</td>
			</tr>
			<tr>
				<td><a href="javascript:add_obj('wb_obj_line');"><img src="new-hp/images/v2/add.gif"></a>
				</td>
				<td align=left>Line:
				</td>
			</tr>
			<tr>
				<td colspan=2 align=center>
					<div style="left: 0px; top: 0px; width: 50px; height: 15px;"><img src="new-hp/images/signature/other/Line.png" width=100% height=100%></div>
				</td>
			</tr>
			<tr>
				<td><a href="javascript:add_obj('wb_obj_avatar');"><img src="new-hp/images/v2/add.gif"></a>
				</td>
				<td align=left>Avatar:
				</td>
			</tr>
			<tr>
				<td colspan=2 align=center>
					<div style="left: 0px; top: 0px; width: 30px; height: 30px;"><img src="new-hp/images/signature/other/Avatar.png" width=100% height=100%></div>
				</td>
			</tr>
			<tr>
				<td><a href="javascript:add_obj('wb_obj_char_name');"><img src="new-hp/images/v2/add.gif"></a>
				</td>
				<td align=left>Character Name:
				</td>
			</tr>
			<tr>
				<td colspan=2 align=center>
					<div style="margin:0 0 0 0; left: 0px; top: 0px; width: 138px; height: 20px; text-align: left; white-space: nowrap; font-family: morpheus; font-size: 16pt; color: rgb(0,0,0); background: url('inc/armory/armory.charactersignature.php?type=genimg&text=Charcter_Name&font=morpheus&size=16&color=0,0,0') no-repeat 0px 0px;"></div>
				</td>
			</tr>
			</table><br>
			<!-- ITEM LIST END -->
		</td>
		<td style="border: 2px solid black;">
		<div id="workbench_space" style="width: 496px; height: 296px; background: #9999999; position: relative;">
			<div id="workbench_area" style="width: 496px; height: 95px; background: #FFFFFF; position: relative;">
			</div>
		</div>
		</td>
	</tr>
	</table>
<!-- UPDATE --><br><input src="shared/wow-com/images/buttons/update-button.gif" name="submit" alt="<?php echo $_LANG['ACCOUNT']['UPDATE']; ?>" class="button" taborder="6" border="0" height="46" type="image" width="174"><br>
	<script type="text/javascript"><!--
	
	var wb_area = document.getElementById('workbench_area');
	wb_resize('width: 450px; height: 64px;');
	
	add_obj('wb_obj_char_name');
	add_obj('wb_obj_border');
	
	--></script>
	<?
	
	break;
	default:

	unset($_SESSION['MA_saveset']);
?>
	<script type="text/javascript">
	function ma_valid() {
		void(document.manageaccount.update.value="");
		void(document.manageaccount.save.value="");
		return true;	
	}	
	</script>
	<table cellspacing = "0" cellpadding = "10" border = "0" width = "70%"><tr><td valign = "top">


	<span>

	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
	<tr valign="bottom">
		<td width = "100%">
			<table cellspacing = "0" cellpadding = "0" border = "0">
			<tr>

			<td>
	<div style="padding-right:10px;">
	<span>
	<img src = "new-hp/images/smallcaps/plain/w.gif" width = "40" height = "38" align = "left">elcome&#130; <b><i><?php echo $rowb['displayname']; ?></i></b>. <?php
				$_LANG_msg = str_replace("GLOBALS_WEB_SET_SITE_NAME",$GLOBALS['WEB_SET']['SITE_NAME'],$_LANG['ACCOUNT']['CONTACT_EMAIL_INFO']);
				$_LANG_msg = str_replace("SETTING_EMAIL_MAIN",$SETTING['EMAIL_MAIN'],$_LANG_msg);
				echo $_LANG_msg; ?>
	</span>

	</div>
	<p>
			</td>


			</tr>
			</table>
	</tr>
	<tr>
		<td align = "center">

					
											
			
		</td>
	</tr>
	</table>



	<p>
	</span>


	   
	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
	<tr>
	<td valign = "top" width = "50%">


	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
	<tr>
	<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
	<td width = "100%" bgcolor = "#05374A"><b class = "white"><?php echo $_LANG['ACCOUNT']['ACC_INFORMATION']; ?>&#058;</b></td>
	<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>


	<!--Shadow Top-->
	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "5"><img src = "shared/wow-com/images/borders/shadow/shadow-top-left.gif" width = "5" height = "4"></td><td width = "50%" background = "shared/wow-com/images/borders/shadow/shadow-top.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-top-left-left.gif" width = "12" height = "4"></td><td width = "50%" align = "right" background = "shared/wow-com/images/borders/shadow/shadow-top.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-top-right-right.gif" width = "12" height = "4"></td><td width = "9"><img src = "shared/wow-com/images/borders/shadow/shadow-top-right.gif" width = "9" height = "4"></td></tr><tr><td valign = "top" background = "shared/wow-com/images/borders/shadow/shadow-left.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-left-top.gif" width = "5" height = "12"></td><td colspan = "2" rowspan = "2">

	<!--Shadow Top-->

	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" class = "listOuter2"><tr><td>
	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" class = "listOuter"><tr><td>

	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "border-collapse:collapse;">

	<tr>
		<td class = "listrow">
	<table width = "100%" style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('shared/wow-com/images/parchment/plain/light3.jpg');"><tr><td>
	<table width = "100%" cellspacing = "0" cellpadding = "0" border = "0">
	<tr>
	<td>

	<span>

	<span style = " font-variant: small-caps; font-size: 13pt; font-weight: bold; font-style: italic; letter-spacing: 1px;"><?php echo $row['username']; ?></span> <span>[<a href = "index.php?n=account.logout"><?php echo $_LANG['ACCOUNT']['LOG_OUT']; ?></a>]</span>

	<!--PlainBox Top-->
	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "3"><img src = "new-hp/images/plainbox/plainbox-top-left.gif" width = "3" height = "3" border = "0"></td><td width = "100%" background = "new-hp/images/plainbox/plainbox-top.gif"></td><td width = "3"><img src = "new-hp/images/plainbox/plainbox-top-right.gif" width = "3" height = "3" border = "0"></td></tr><tr><td background = "new-hp/images/plainbox/plainbox-left.gif"><img src = "shared/wow-com/images/layout/pixel.gif" width = "1" height = "176"></td><td bgcolor = "#E5CDA1" valign = "top">
	<!--PlainBox Top-->

	<table width = "100%" border=0 cellspacing=1 cellpadding=3>


	<tr>
	  <td width = "100%"><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td><td bgcolor = "#464B3F" width = "100%"><span class = "smallBold" style = "color:white;">&nbsp;Account Status&#058;</span></td><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td></tr></table><table cellspacing = "0" cellpadding = "5" border = "0" width = "100%"><tr><td><span class = "smallBold">
	  <?php 
	  $getban= mysql_fetch_array(mysql_query("SELECT bandate, unbandate, banreason FROM account_banned WHERE id='".$row['id']."' AND active=1"));
	  if ($getban['unbandate']=='') { 
			echo "Active"; 
	   } else { 
			echo "<font color=red>".$_LANG['ACCOUNT']['BANNED2'];
			if ($row['unbandate']>=0) {
				echo " until ".date('d-m-Y \a\t h:i A', $row['unbandate'])."."; 
			} 
			echo "<br>".$_LANG['ACCOUNT']['REASON'].": ".$getban['banreason'].".</font>"; 
		} 
	  ?>
	  </span></td></tr></table></td>
	</tr>
	
	<tr>
	  <td width = "100%"><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td><td bgcolor = "#464B3F" width = "100%"><span class = "smallBold" style = "color:white;">&nbsp;<?php echo $_LANG['ACCOUNT']['ACCOUNT_PRIVILEGES']; ?>&#058;</span></td><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td></tr></table><table cellspacing = "0" cellpadding = "5" border = "0" width = "100%"><tr><td><span class = "smallBold"><?php echo $USER_LEVEL[$row['gmlevel']]; ?><?php if ($row['id']==$SETTING['SERVER_OWNER']) { echo ' (Owner)'; } ?></span></td></tr></table></td>
	</tr>
	
	<tr>
	  <td width = "100%"><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td><td bgcolor = "#464B3F" width = "100%"><span class = "smallBold" style = "color:white;">&nbsp;<?php echo $_LANG['ACCOUNT']['ACCOUNT_UPGRADES']; ?>&#058;</span></td><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td></tr></table><table cellspacing = "0" cellpadding = "5" border = "0" width = "100%"><tr><td><span class = "smallBold">
	  <?php if ($row['tbc']=='32') { echo "Wrath of the Lich King"; } if ($row['tbc']=='1') { echo "The Burning Crusades"; }  else { echo 'None'; } ?>
	  </span></td></tr></table></td>
	</tr>

	<tr>
	  <td width = "100%"><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td><td bgcolor = "#464B3F" width = "100%"><span class = "smallBold" style = "color:white;">&nbsp;Account Created In&#058;</span></td><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td></tr></table><table cellspacing = "0" cellpadding = "5" border = "0" width = "100%"><tr><td><span><i><? echo $row['joindate']; ?></i></span></td></tr></table></td>
	</tr>


	<tr>
	  <td width = "100%"><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td><td bgcolor = "#464B3F" width = "100%"><span class = "smallBold" style = "color:white;">&nbsp;<?php echo $_LANG['ACCOUNT']['LAST_LOGIN']; ?>&#058;</span></td><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td></tr></table><table cellspacing = "0" cellpadding = "5" border = "0" width = "100%"><tr><td><span><i>
	  <? if ($row['last_login']=="0000-00-00 00:00:00") { echo '<span style="color: red;">Never'; } else { echo str_replace(' ', ' at ', $row['last_login']); } ; ?>
	  </i></span></td></tr></table></td>
	</tr>
	
	<tr>
	  <td width = "100%"><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td><td bgcolor = "#464B3F" width = "100%"><span class = "smallBold" style = "color:white;">&nbsp;<?php echo $_LANG['ACCOUNT']['CHARACTERS']; ?>&#058;</span></td><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td></tr></table><table cellspacing = "0" cellpadding = "5" border = "0" width = "100%"><tr>
	  <td>
	  <span>
	  <table width=100%>
	<?
	$qquery = mysql_query("SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
	rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (`realm_settings` rs) ON r.id = rs.id_realm 
	GROUP BY r.id ORDER BY r.name", $MySQL_CON) OR DIE(mysql_error());
	$i=0;
	while ($rowx = mysql_fetch_array($qquery)) {
		$newcon = @mysql_connect($rowx['rsdbhost'].':'.$rowx['rsdbport'], $rowx['rsdbuser'], $rowx['rsdbpass']);;
		$newdb = @mysql_select_db ($rowx['rsdbname'], $newcon);
		$newquery = @mysql_query("SELECT name, data, class, race, online FROM `characters` WHERE `account`='".$row['id']."'", $newcon);
		echo "<tr><td colspan=5 width=100% align='left'><b><span>".$rowx['name']."</b></td></tr>";
		
			while($rowc = @mysql_fetch_array($newquery)) {		
				$rowc['data'] = explode(' ',$rowc['data']);		
				$char_gender = dechex($rowc['data'][36]);
				$char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
				$char_gender = $char_gender{3};		
				echo "<tr>
						<td width=100% align='left'><span>".$rowc['name']."</span></td>
						<td align='left'><img onmouseover='ddrivetip(\"<b>".$CHAR_RACE[$rowc['race']][0]."</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/picons/".$rowc['race']."-".$char_gender.".gif'></td>
						<td align='left'><img onmouseover='ddrivetip(\"<b>".$CHAR_CLASS[$rowc['class']]."</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/picons/".$rowc['class'].".gif'></td>
						<td align='left' nowrap='nowrap'><small style='color: rgb(102, 13, 2);'>Lvl. ".$rowc['data'][34]."</span></td>
						<td width=0% align='left' nowrap='nowrap'><small style='color: rgb(102, 13, 2);'>";
				if ($rowc['online']==1) { echo "<img onmouseover='ddrivetip(\"<b>On-Line</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/favicon.ico'>"; }
				echo "</span></td>
						</tr>";
				$i++;
			}
			if (!$newcon OR !$newdb OR !$newquery) { echo '<tr><td aling=left><span style="color: red;"><i>'.$_LANG['ACCOUNT']['SERVER_OFFLINE'].'</i></span><td></tr>'; }
			else if ($i==0) { echo '<tr><td aling=left><span><i>None</i></span><td></tr>'; }
	}
	echo'</table>';
	?>
	  </span></td>
	  </tr></table></td>
	</tr>


	</table>

	<!--PlainBox Bottom-->
	</td><td background = "new-hp/images/plainbox/plainbox-right.gif"></td></tr><tr><td><img src = "new-hp/images/plainbox/plainbox-bot-left.gif" width = "3" height = "3" border = "0"></td><td background = "new-hp/images/plainbox/plainbox-bot.gif"></td><td><img src = "new-hp/images/plainbox/plainbox-bot-right.gif" width = "3" height = "3" border = "0"></td></tr></table>
	<!--PlainBox Bottom-->

	<img src = "shared/wow-com/images/layout/pixel.gif" width = "1" height = "5"><br>
	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">

	<tr>
	<td align = "right" width = "100%"><input type=image onclick="javascript:void(document.manageaccount.step.value='accountinfo');"  src = "shared/wow-com/images/buttons/button-red-change-password.gif" height = "22" border = "0"></a></td>
	<td width = "7"><img src = "shared/wow-com/images/layout/pixel.gif" width = "7" height = "1"></td>
	</tr>
	</table>


	</td></tr></table>
	</span>
	</td>
	</tr>
	</table>

		</td>
	</tr>
	</table>

	</td></tr></table>
	</td></tr></table>
	<!--Shadow Bottom-->
	</td><td valign = "top" background = "shared/wow-com/images/borders/shadow/shadow-right.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-right-top.gif" width = "9" height = "12"></td></tr><tr><td valign = "bottom" background = "shared/wow-com/images/borders/shadow/shadow-left.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-left-bot.gif" width = "5" height = "12"></td><td valign = "bottom" background = "shared/wow-com/images/borders/shadow/shadow-right.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-right-bot.gif" width = "9" height = "12"></td></tr><tr><td><img src = "shared/wow-com/images/borders/shadow/shadow-bot-left.gif" width = "5" height = "10"></td><td background = "shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-bot-left-left.gif" width = "12" height = "10"></td><td align = "right" background = "shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-bot-right-right.gif" width = "12" height = "10"></td><td><img src = "shared/wow-com/images/borders/shadow/shadow-bot-right.gif" width = "9" height = "10"></td></tr></table>
	<!--Shadow Bottom-->


	</td>
	<td valign = "top" width = "50%">


	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
	<tr>
	<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
	<td width = "100%" bgcolor = "#05374A"><b class = "white">Contact Information&#058;</b></td>
	<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
	</tr>
	</table>
	<!--Shadow Top-->
	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "5"><img src = "shared/wow-com/images/borders/shadow/shadow-top-left.gif" width = "5" height = "4"></td><td width = "50%" background = "shared/wow-com/images/borders/shadow/shadow-top.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-top-left-left.gif" width = "12" height = "4"></td><td width = "50%" align = "right" background = "shared/wow-com/images/borders/shadow/shadow-top.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-top-right-right.gif" width = "12" height = "4"></td><td width = "9"><img src = "shared/wow-com/images/borders/shadow/shadow-top-right.gif" width = "9" height = "4"></td></tr><tr><td valign = "top" background = "shared/wow-com/images/borders/shadow/shadow-left.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-left-top.gif" width = "5" height = "12"></td><td colspan = "2" rowspan = "2">
	<!--Shadow Top-->
	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" class = "listOuter2"><tr><td>

	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" class = "listOuter"><tr><td>

	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" style = "border-collapse:collapse;">

	<tr>
		<td class = "listrow">
	<table width = "100%" style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('shared/wow-com/images/parchment/plain/light3.jpg');"><tr><td>
	<table width = "100%" cellspacing = "0" cellpadding = "0" border = "0">
	<tr>
	<td>
	<span>

	<!--PlainBox Top-->
	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "3"><img src = "new-hp/images/plainbox/plainbox-top-left.gif" width = "3" height = "3" border = "0"></td><td width = "100%" background = "new-hp/images/plainbox/plainbox-top.gif"></td><td width = "3"><img src = "new-hp/images/plainbox/plainbox-top-right.gif" width = "3" height = "3" border = "0"></td></tr><tr><td background = "new-hp/images/plainbox/plainbox-left.gif"><img src = "shared/wow-com/images/layout/pixel.gif" width = "1" height = "200"></td><td bgcolor = "#E5CDA1">
	<!--PlainBox Top-->

	<table width = "100%" border=0 cellspacing=1 cellpadding=3>
	<tr>
	  <td width = "100%" bgcolor = "#E5CDA1">
	  <table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td><td bgcolor = "#464B3F" width = "100%"><span class = "smallBold" style = "color:white;">&nbsp;<?php echo $_LANG['ACCOUNT']['CONTACT_ADDRESS']; ?>&#058;</span></td><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td></tr></table><table cellspacing = "0" cellpadding = "5" border = "0" width = "100%"><tr><td><span>

	  <?php echo $rowb['fname'] .' '. $rowb['lname']; ?><br>
	  <?php echo $rowb['city'] .', '. $COUNTRY[$rowb['location']]; if($rowb['showlocation']=='0') { echo ' (Hidden)'; }?><BR>
	  
	  </span></td></tr></table></td>
	</tr>
	<tr>
	  <td width = "100%" bgcolor = "#E5CDA1"><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td><td bgcolor = "#464B3F" width = "100%"><span class = "smallBold" style = "color:white;">&nbsp;<?php echo $_LANG['ACCOUNT']['EMAIL_ADDRESS']; ?>&#058;</span></td><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td></tr></table><table cellspacing = "0" cellpadding = "5" border = "0" width = "100%"><tr><td><span><?php echo $row['email']; ?></span></td></tr></table></td>
	</tr>
	<tr>
	  <td width = "100%" bgcolor = "#E5CDA1"><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td><td bgcolor = "#464B3F" width = "100%"><span class = "smallBold" style = "color:white;">&nbsp;<?php echo $_LANG['ACCOUNT']['FORUM_SETTINGS']; ?>&#058;</span></td><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td></tr></table><table cellspacing = "0" cellpadding = "5" border = "0" width = "100%"><tr>
	  <td><span>
	  <?php echo $rowb['displayname']; ?><br>
	  <?php if ($rowb['bday']!="00/00/0000") { echo $rowb['bday'] .', '.$rowb['bdage'].' years' ; if($rowb['showbday']=='0') { echo ' (Hidden)'; } echo '<br>'; }?>
	  Time Zone: GMT <?php echo $GMT[$rowb['gmt']][0]; ?><BR>	  
	  <?php echo $rowb['webpage']; ?>
	  </span></td></tr></table></td>
	</tr>
	<tr>
	  <td width = "100%" bgcolor = "#E5CDA1"><table cellspacing = "0" cellpadding = "0" border = "0" width = "100%"><tr><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td><td bgcolor = "#464B3F" width = "100%"><span class = "smallBold" style = "color:white;">&nbsp;<?php echo $_LANG['ACCOUNT']['SIGNATURE']; ?>&#058;</span></td><td width = "1"><img src = "shared/wow-com/images/headers/minisubheader/minisubheader-end.gif" width = "1" height = "16"></td></tr></table><table cellspacing = "0" cellpadding = "5" border = "0" width = "100%"><tr>
	  <td><span><div style="overflow: auto; width: 220px; height: 88px ">
	  <?php echo bbcode($rowb['signature']); ?>
	  </div></span></td></tr></table></td>
	</tr>
	</table>


	<!--PlainBox Bottom-->
	</td><td background = "new-hp/images/plainbox/plainbox-right.gif"></td></tr><tr><td><img src = "new-hp/images/plainbox/plainbox-bot-left.gif" width = "3" height = "3" border = "0"></td><td background = "new-hp/images/plainbox/plainbox-bot.gif"></td><td><img src = "new-hp/images/plainbox/plainbox-bot-right.gif" width = "3" height = "3" border = "0"></td></tr></table>
	<!--PlainBox Bottom-->

	<img src = "shared/wow-com/images/layout/pixel.gif" width = "1" height = "5"><br>

	<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
	<tr>
	<td align = "right" width = "100%"><input type="image" onclick="javascript:void(document.manageaccount.step.value='userinfo');" src = "shared/wow-com/images/buttons/button-red-contact-info.gif" height = "22" border = "0"></a></td>
	<td width = "7"><img src = "shared/wow-com/images/layout/pixel.gif" width = "7" height = "1"></td>
	</tr>
	</table>



	</td></tr></table>
	</span>
	</td>
	</tr>

	</table>

		</td>
	</tr>
	</table>

	</td></tr></table>
	</td></tr></table>
	<!--Shadow Bottom-->
	</td><td valign = "top" background = "shared/wow-com/images/borders/shadow/shadow-right.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-right-top.gif" width = "9" height = "12"></td></tr><tr><td valign = "bottom" background = "shared/wow-com/images/borders/shadow/shadow-left.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-left-bot.gif" width = "5" height = "12"></td><td valign = "bottom" background = "shared/wow-com/images/borders/shadow/shadow-right.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-right-bot.gif" width = "9" height = "12"></td></tr><tr><td><img src = "shared/wow-com/images/borders/shadow/shadow-bot-left.gif" width = "5" height = "10"></td><td background = "shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-bot-left-left.gif" width = "12" height = "10"></td><td align = "right" background = "shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src = "shared/wow-com/images/borders/shadow/shadow-bot-right-right.gif" width = "12" height = "10"></td><td><img src = "shared/wow-com/images/borders/shadow/shadow-bot-right.gif" width = "9" height = "10"></td></tr></table>
	<!--Shadow Bottom-->

	</td>

	</tr>
	</table>

	<p>

	<p>
	<img src = "shared/wow-com/images/layout/pixel.gif" width = "520" height = "1">
	</td></tr></table>
<?php
		break;
	}
?>
</form>
<?php
}

parchdown();

?>

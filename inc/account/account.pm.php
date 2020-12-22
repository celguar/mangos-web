<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title($_LANG['ACCOUNT']['PRIVATE_MESSAGES']);

parchdown();

parchup(true);

if (isset($_SESSION['userid'])) {

	if ($_POST['send']=="true") {
		if (strlen($_POST['uto'])<3) {
			$haserrors = $_LANG['ACCOUNT']['MUST_TYPE_MEMBER_NAME'];
		} else {
			$query = mysql_query("SELECT fa.id_account as id_account, a.gmlevel as gmlvl, fa.enablepm as enablepm FROM account a LEFT JOIN (forum_accounts fa) ON a.id = fa.id_account WHERE LOWER(fa.displayname)=LOWER('".$_POST['uto']."')");
			$my = mysql_fetch_array($query);
			if (mysql_num_rows($query)==0) {
				$haserrors = $_LANG['ACCOUNT']['MEMBER_NOT_FOUND'];
			} else if ($my['id_account']==$_SESSION['userid']) {
				$haserrors = $_LANG['ACCOUNT']['CANT_SEND_TO_YOURSELF'];
			} else if (verifylevel($_SESSION['userid'])<$SETTING['USER_ENABLE_PM'] AND $SETTING['USER_ENABLE_PM']>=$my['gmlvl']) {
				$_LANG_msg = str_replace("USER_LEVEL_USER_ENABLE_PM",$USER_LEVEL[$SETTING['USER_ENABLE_PM']],$_LANG['ACCOUNT']['CANT_SEND_WITHOUT_PRIVILEGES']);
				$haserrors = $_LANG_msg;
			} else if ($my['enablepm']==0 AND verifylevel($_SESSION['userid'])<$SETTING['USER_ENABLE_PM']) {
				$haserrors = $_LANG['ACCOUNT']['MEMBER_W_MESSAGES_DISABLED'];
			} else {
				$queryb = mysql_query("SELECT id_account_to FROM forum_pm WHERE id_account_to='".$my['id_account']."' AND isdeleted!='".$my['id_account']."'") OR DIE (mysql_error());
				if (mysql_num_rows($queryb)>=50 AND '1'>$my['gmlvl']) {
					$haserrors = $_LANG['ACCOUNT']['MEMBER_W_MAX_INBOX'];
				}
			}
		}
		if (strlen($_POST['usu'])<3) {
			$haserrors .= $_LANG['ACCOUNT']['SUBJECT_CHAR_MORE_3'];
		}
		if (strlen($_POST['ume'])<5) {
			$haserrors .= $_LANG['ACCOUNT']['MEX_CHAR_MORE_5'];
		} 
		if ($haserrors!='') {
			errborder($haserrors); remslashall();
		} else {
			$queryc = mysql_query("INSERT INTO forum_pm(id_account_to, id_account_from, subject, message, isread, date, hour, issignature, isbbcode) VALUES ('".$my['id_account']."','".$_SESSION['userid']."','".$_POST['usu']."','".$_POST['ume']."','0','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['issigned']."','".$_POST['isbbcode']."')") or die (mysql_error());
			if ($queryc) {
				unset($_POST['send']);
				unset($_POST['uto']);
				unset($_POST['usu']);
				unset($_POST['ume']);
				goodborder($_LANG['ACCOUNT']['MEX_SENT_OK'].'<META HTTP-EQUIV=REFRESH CONTENT="2; URL=?n=account.pm&f=outbox">'); echo '<br>'; exit;
			} else {
				errborder ($_LANG['ACCOUNT']['MEX_SENT_KO']); echo '<br>';
				
			}
		}
	}
	if ($_REQUEST['t']=='delete' AND ($_REQUEST['f']=='inbox' or $_REQUEST['f']=='outbox')) {
		if ($_REQUEST['f']=='inbox') {
			$source = 'to';
		} else if ($_REQUEST['f']=='outbox') {
			$source = 'from';
		}
		for($i=0;$i<count($_POST['pmdelete']);$i++) {
			@mysql_query("UPDATE forum_pm SET isdeleted='".$_SESSION['userid']."' WHERE id_pm='".$_POST['pmdelete'][$i]."' AND id_account_".$source."='".$_SESSION['userid']."' AND isdeleted=0") or die (mysql_error());
			@mysql_query("DELETE FROM forum_pm WHERE id_pm='".$_POST['pmdelete'][$i]."' AND id_account_".$source."='".$_SESSION['userid']."' AND isdeleted!='".$_SESSION['userid']."' AND isdeleted!=0") or die (mysql_error());
		}
	} else if ($_REQUEST['t']=='cancel' AND $_REQUEST['f']=='outbox') {
		for($i=0;$i<count($_POST['pmdelete']);$i++) {
			@mysql_query("DELETE FROM forum_pm WHERE id_pm='".$_POST['pmdelete'][$i]."' AND id_account_from='".$_SESSION['userid']."' AND isread=0") or die (mysql_error());
		}
	}
	
	
	$YESNO = array('0' => 'No', '1' => 'Yes');

?>
<style type="text/css" title="currentStyle" media="screen">
	.avatar-nav { width: 580px; height: 27px; position: relative; display: block; margin-top: 20px; }
	.avatar-nav span { font-size: 11px; }
	.avatar-nav ol { list-style: none; margin: 0; padding: 0; }
	.avatar-nav ol li { position: absolute; top: 0px; width: 104px; height: 30px; background: url('new-hp/images/forum/tab-nf.gif') no-repeat top right; padding: 5px 0 0 0; text-align: center; }
	.avatar-nav ol li.selected { background: url('new-hp/images/forum/tab-f.gif') no-repeat top right; z-index: 90; height: 28px; }
	.avatar-nav ol li.selected a, #avatar-nav ol li.selected a:active, #avatar-nav ol li.selected a:visited { color: white; } 
	.avatar-nav ol li.tab-one { right: -10px; }
	.avatar-nav ol li.tab-two { right: 90px; }
	.avatar-nav ol li.tab-three { right: 190px; }
	.avatar-nav span.grey { color: #666666; }
	span.grey { color: grey; font-size: 12px; }
	span.white { color: white; font-size: 12px; }
	span.grey a { color: orange; font-size: 12px; }
	span.grey a:visited { color: orange; font-size: 12px; }
	span.grey a:hover { color: white; font-size: 12px; }
	span.grey a:active { color: orange; font-size: 12px; }
	.avatar-nav a, #avatar-nav a:visited, #avatar-nav a:active { text-decoration: none; }
	.avatar-nav a:hover { color: white; text-decoration: none; }
	.list-avatars { width: 600px; border: 1px solid #424242; display: table; background: black; padding: 7px; color: orange;  }
	.list-avatars h1 { color: #FF9900; padding: 10px; font-size: 18px; font-family: Georgia, 'Times New Roman', Times, serif; font-weight: normal; }
	.list-avatars p { margin: 5px 0 0 0; font-size: 11px; }
</style>
<script type="text/javascript">
//<![CDATA[
function toggleAlliance(thisDirectory)
{
  document.getElementById("seventyA").className="tab-three";
  document.getElementById("sixtyA").className="tab-two";
  document.getElementById("defaultA").className="tab-one";
  document.getElementById(thisDirectory).className = document.getElementById(thisDirectory).className + " selected";
}
//]]>
</script>
<table align=center>
	<tr>
		<td><?php
			$top .= '<div class="avatar-nav">
				<ol>
					<li id="seventyA" class="tab-three ';
			if ($_REQUEST['f']!='send' AND $_REQUEST['f']!='outbox') { $top .= 'selected'; }  
			$top .= '"><span class="grey"><strong><a href="?n=account.pm">'.$_LANG['ACCOUNT']['INBOX'].'</a></span></strong></li>
					<li id="sixtyA" class="tab-two ';
			if ($_REQUEST['f']=='outbox') { $top .=  'selected'; } 
			$top .= '"><strong><span class="grey"><strong><a href="?n=account.pm&f=outbox">'.$_LANG['ACCOUNT']['OUTBOX'].'</a></span></strong></li>
					<li id="defaultA" class="tab-one '; 
			if ($_REQUEST['f']=='send') { $top .= 'selected'; } 
			$top .= '"><strong><span class="grey"><a href="?n=account.pm&f=send">'.$_LANG['ACCOUNT']['SEND'].'</a></span></strong></li>
				</ol>
			</div>';

			echo $top; ?>
			<div class="list-avatars">
				<span class="grey">
				<?php 
				
				switch($_REQUEST['f']) {
					case "send":
					
					if ($_POST['issigned']=='') { $_POST['issigned']='1'; }
					if ($_POST['isbbcode']=='') { $_POST['isbbcode']='1'; }
					
					?><h1>Send</h1>
					<br><form method=post action="?n=account.pm&f=send" name="accpm">
					<input type=hidden name="send" value="true">
							<table align=center width = 98% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
							<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
							<table border=0 cellspacing=0 cellpadding=4>
							<tr>
								  <td width=120 align=right>
								  <font face="arial,helvetica" size=-1><span><b>
								To:
								  </span></b></font>
								  </td>
								  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="uto" value="<? echo $_REQUEST['to']; echo $_POST['uto'];?>" style = "Width:250" taborder=1 /></td><td valign = "top">
									&nbsp;<small>(<?php echo $_LANG['ACCOUNT']['ACC_DISPLAY_NAME']; ?>)</small>
								   </td></tr></table></td>
							</tr>
							<tr>
								  <td align=right>
								  <font face="arial,helvetica" size=-1><span><b>
								Subject:
								  </span></b></font>
								  </td>
								  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="usu" value="<? echo $_POST['usu'];?>" style = "Width:250" taborder=1 /></td><td valign = "top">

								   </td></tr></table></td>
							</tr>
							<tr>
								  <td align=right>
								  <font face="arial,helvetica" size=-1><span><b>
								  </span></b></font> </td>
								  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
								  <? bbcode_toolbar('accpm.ume');?>
								  </td><td valign = "top">
								   </td></tr></table></td>
							</tr>
							<tr>
								  <td align=right valign=top>
								  <font face="arial,helvetica" size=-1><span><b>
								  Message:  </span></b></font> </td>
								  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
								  <textarea name="ume"  rows=10 cols=63><? echo $_POST['ume']; ?></textarea>
								  </td><td valign = "top">
								   </td></tr></table></td>
							</tr>
							<tr>
								  <td align=right valign=top>
								  <font face="arial,helvetica" size=-1><span><b>
								  Enable BBCode:  </span></b></font> </td>
								  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
								  <select name="isbbcode">
									  <option value="1" SELECTED><?php echo $_LANG['ACCOUNT']['YES']; ?>
									  <option value="0"><?php echo $_LANG['ACCOUNT']['NO']; ?>
								  </select>
								  </td><td valign = "top">
								   </td></tr></table></td>
							</tr>
							<tr>
								  <td align=right valign=top>
								  <font face="arial,helvetica" size=-1><span><b>
								  Include Signature:  </span></b></font> </td>
								  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
								  <select name="issigned">
									  <option value="1" SELECTED><?php echo $_LANG['ACCOUNT']['YES']; ?>
									  <option value="0"><?php echo $_LANG['ACCOUNT']['NO']; ?>
								  </select>
								  </td><td valign = "top">
								   </td></tr></table></td>
							</tr>
							<tr>
								  <td align=center valign=top colspan=2>
									<br><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Send" Width="174" Height="46" Border=0 class="button"  taborder=7 >
								   </td>
							</tr>
							</table>

							</td></tr></table>
							</td></tr></table><br>
<script>
	document.accpm.issigned.value="<? echo $_POST['issigned']; ?>";
	document.accpm.isbbcode.value="<? echo $_POST['isbbcode']; ?>";
</script>
</form><?
					break;
					case "outbox":
						$body .= '<h1>'.$_LANG['ACCOUNT']['OUTBOX'];
						if ($_REQUEST['pm']!='') {
							$query = mysql_query("SELECT *, a.displayname as dn, a.signature as signa FROM forum_pm p LEFT JOIN (forum_accounts a) ON p.id_account_to = a.id_account WHERE id_account_from='".$_SESSION['userid']."' AND isdeleted!='".$_SESSION['userid']."' AND id_pm='".$_REQUEST['pm']."' GROUP BY p.id_pm") or die (mysql_error());
							if (mysql_num_rows($query)!=0) {
								$row = mysql_fetch_array($query);
								$body .= ' - <span style="color: white">'.$row['subject'].'</span></h1><br>
								To: </span><span class="white">'.$row['dn'].' in '.$row['date'].' at '.$row['hour'].'<br><br>
									<span class="grey">'.$_LANG['ACCOUNT']['MESSAGE'].':<br>
									</span><span class="white">'.bbcode($row['message'],true,true,$row['isbbcode']).'<br><br>
								';
								if ($row['issignature']=='1') { $row = mysql_fetch_array(mysql_query("SELECT a.signature as signa FROM forum_accounts a WHERE id_account='".$_SESSION['userid']."'")); $body .= '<img src="new-hp/images/pixel.gif" style="background-color: white;" width=100% height=1><br><div style="margin-top: 10px; width: 100%; min-height: 50px; max-height: 170px; overflow: auto;">'.bbcode($row['signa']).'</div>'; }
							} else {
								errborder($_LANG['ACCOUNT']['INVALID_MEX']);
							}
						} else {
						$query = mysql_query("SELECT *, DATE_FORMAT(CONVERT_TZ(CONCAT(`date`, ' ', `hour`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".verifygmt($_SESSION['userid'])."'), '%Y-%m-%d at %h:%i %p') as `date`, a.displayname as dn FROM forum_pm p LEFT JOIN (forum_accounts a) ON p.id_account_to = a.id_account WHERE id_account_from='".$_SESSION['userid']."' AND isdeleted!='".$_SESSION['userid']."' GROUP BY p.id_pm ORDER BY isread ASC, date DESC, hour DESC") or die (mysql_error());
							if (mysql_num_rows($query)>0) {
								$body .= '</h1><br><form method=post action="?n=account.pm&f=outbox&t=delete" name="accpm"><table width=100%>
											<tr>
												<td width=30><span class="grey">To:</td>
												<td width=50%><span class="grey">Subject:</td>
												<td width=20><span class="grey">Date:</td>
												<td width=20><span class="grey">Read:</td>
												<td><input type=checkbox onclick="chgall(this)"></td>
											</tr>';
								while ($row=mysql_fetch_array($query)) {
									$body .= '<tr class=grey><td><span class="grey"><a href="#">'.$row['dn'].'</td><td><span class="grey"><a href="?n=account.pm&f=outbox&pm='.$row['id_pm'].'">'.$row['subject'].'</td><td><span class="grey">'.$row['date'].'</td><td><span class="grey">'.$YESNO[$row['isread']].'</td><td><input type=checkbox name="pmdelete[]" value="'.$row['id_pm'].'"></td>';
								}
								$body .= '</table><br>
								<div align=right><input type=submit onclick="document.accpm.action=\'?n=account.pm&f=outbox&t=cancel\'" value ="'.$_LANG['ACCOUNT']['CANCEL_SELECTED'].'">&nbsp;<input type=submit value ="'.$_LANG['ACCOUNT']['DELETE_SELECTED'].'"></div><form>';
							} else {
								$body .= '</h1><br>'.$_LANG['ACCOUNT']['NO_MEX_SENT'];
							}
						}
					break;
					case "inbox":
					default:
						$body .= '<h1>'.$_LANG['ACCOUNT']['INBOX'];
						if ($_REQUEST['pm']!='') {
							$query = mysql_query("SELECT *, a.displayname as dn, a.signature as signa FROM forum_pm p LEFT JOIN (forum_accounts a) ON p.id_account_from = a.id_account WHERE id_account_to='".$_SESSION['userid']."' AND isdeleted!='".$_SESSION['userid']."' AND id_pm='".$_REQUEST['pm']."'GROUP BY p.id_pm") or die (mysql_error());
							if (mysql_num_rows($query)!=0) {
								$row = mysql_fetch_array($query);
								$body .= ' - <span style="color: white">'.$row['subject'].'</span></h1><br>
								From: </span><span class="white">'.$row['dn'].' in '.$row['date'].' at '.$row['hour'].'<br><br>
									<span class="grey">'.$_LANG['ACCOUNT']['MESSAGE'].':<br>
									</span><span class="white">'.bbcode($row['message'],true,true,$row['isbbcode']).'<br><br>
								';
								if ($row['issignature']=='1') { $body .= '<img src="new-hp/images/pixel.gif" style="background-color: white;" width=100% height=1><br><div style="margin-top: 10px; width: 100%; min-height: 50px; max-height: 170px; overflow: auto;">'.bbcode($row['signa']).'</div>'; }
								$query = mysql_query("UPDATE forum_pm SET isread='1' WHERE id_pm='".$row['id_pm']."'") or die (mysql_error());
							} else {
								errborder($_LANG['ACCOUNT']['INVALID_MEX']);
							}
						} else {
							$query = mysql_query("SELECT *, DATE_FORMAT(CONVERT_TZ(CONCAT(`date`, ' ', `hour`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".verifygmt($_SESSION['userid'])."'), '%Y-%m-%d at %h:%i %p') as `date`, a.displayname as dn FROM forum_pm p LEFT JOIN (forum_accounts a) ON p.id_account_from = a.id_account WHERE id_account_to='".$_SESSION['userid']."' AND isdeleted!='".$_SESSION['userid']."' GROUP BY p.id_pm ORDER BY isread ASC, date DESC, hour DESC") or die (mysql_error());
							if (mysql_num_rows($query)>0) {
								$body .= '</h1><br><form method=post action="?n=account.pm&f=inbox&t=delete" name="accpm"><table width=100%>
											<tr>
												<td width=30><span class="grey">From:</td>
												<td width=45%><span class="grey">Subject:</td>
												<td width=20><span class="grey">Date:</td>
												<td width=20><span class="grey">Read:</td>
												<td><input type=checkbox onclick="chgall(this)"></td>
											</tr>';
								$i=0;
								while ($row=mysql_fetch_array($query)) {
									$body .= '<tr class=grey><td><span class="grey"><a href="#">'.$row['dn'].'</td><td><span class="grey"><a href="?n=account.pm&f=inbox&pm='.$row['id_pm'].'">'.$row['subject'].'</td><td><span class="grey">'.$row['date'].'</td><td><span class="grey">'.$YESNO[$row['isread']] .'</td><td><input type=checkbox name="pmdelete[]" value="'.$row['id_pm'].'"></td>';
									if ($row['isread']=='0') { $i++; }
								}
								$tit .= ' ('.$i.' New)';
								$body .= '</table><br>
								<div align=right><input type=submit value ="'.$_LANG['ACCOUNT']['DELETE_SELECTED'].'"></div></form>';
							} else {
								$body .= '</h1><br>'.$_LANG['ACCOUNT']['NO_MEX_RECEIVED'];
							}
						}
					break;
				}
				echo $body;
			?>
<? if ($_REQUEST['pm']=='') {?>
<script>
function chgall(valor) {

	for(i=0;i<<? echo mysql_num_rows($query);?>;i++) {
		document.getElementsByName('pmdelete[]')[i].checked = valor.checked;
	}

}
<? } ?>
</script>
				</span>
			</div>
		</td>
	</tr>
</table>
<?php

} else {
	errborder($_LANG['ERROR']['NEED_LOGIN']);
}

parchdown();

?>

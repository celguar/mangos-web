<?php
if(!defined('Armory') || ($config['Login'] == 0))
{
	header('Location: ../');
	exit();
}
if(isset($_POST['name']) && isset($_POST['pass']))
{
	switchConnection($realms[urldecode($_POST["realm"])][0],"");
	$banip = mysql_query("SELECT `ip` from `ip_banned` WHERE `ip` = '".$_SERVER['REMOTE_ADDR']."'");
	$numban = mysql_num_rows($banip);
	if($numban > 0)
		$banned = 1;
	else
	{
		$user_name = $_POST['name'];
		$user_pass = sha1(strtoupper($_POST['name'].":".$_POST['pass']));
		$select_acc = "SELECT username FROM account WHERE username='$user_name' AND sha_pass_hash='$user_pass'";
		$results=mysql_query($select_acc) or die (mysql_error());
		if(mysql_num_rows($results) == 1)
		{
			$row=mysql_fetch_array($results);
			$_SESSION['user_name'] = $row['username'];
			$_SESSION['logged_MBA'] = 1;
			$_SESSION['realm'] = urldecode($_POST["realm"]);
		}
		else
			$wrong=1;
	}
}
if (!isset($_SESSION['logged_MBA']) || isset($_POST["logout"]))
{
	session_destroy();
?>
<div class="list">
<div class="full-list">
<div class="tip" style="clear: left;">
<table>
<tr>
<td class="tip-top-left"></td><td class="tip-top"></td><td class="tip-top-right"></td>
</tr>
<tr>
<td class="tip-left"></td><td class="tip-bg">
<div class="profile-wrapper">
<blockquote>
<b class="icharacters">
<h4>
<a href="character-search.php">Log In</a>
</h4>
<h3>Log In</h3>
</b>
</blockquote>
<div class="login-box">
<div class="login-contents">
<div class="login-text">
<form action="?searchType=login" method="post" name="login">
<div class="reldiv">
<a class="login-x" href="index.php"></a>
<div class="login-title">Login Required</div>
<div class="login-intromsg">You must log in with your server account to access protected areas of the Armory.</div>
<div class="login-inputcontainer1">
<div class="reldiv">
<div class="login-inputitem1">Account Name</div>
<div class="login-inputitem2">
<input class="login-accountname" id="accountName" name="name" onkeypress="submitViaEnter(event)" tabindex="1" type="text" value="">
</div>
<div class="login-inputitem3">
Realm
<select class="login-accountname" id="realm" name="realm" onkeypress="submitViaEnter(event)" tabindex="1" type="text" value="">
<?php
	foreach($realms as $key => $data)
		echo "<option value='".urlencode($key)."'>".$key."</option>";
?>
</select>
<!--<a href="account-name.html">Forgot your Account Name?</a>-->
</div>
</div>
</div>
<div class="login-inputcontainer2">
<div class="reldiv">
<div class="login-inputitem1">Password</div>
<div class="login-inputitem2">
<input class="login-accountname" name="pass" onkeypress="submitViaEnter(event)" tabindex="2" type="password" value="">
</div>
<div class="login-inputitem3">
<?php
	if (isset($banned))
		echo "<center>IP ".$_SERVER['REMOTE_ADDR']." is banned.</center>";
	else if (isset($wrong))
		echo "<center>Wrong username or password</center>";
?>
<!--<a href="password.html">Forgot your Password?</a> -->
</div>
</div>
</div>
<div class="login-buttons">
<a class="bluebutton" href="javascript:document.login.submit();" id="loginsubmitbutton">
<div class="bluebutton-a"></div>
<div class="bluebutton-b">
<div class="reldiv">
<div class="bluebutton-color">Login</div>
</div>Login</div>
<div class="bluebutton-key"></div>
<div class="bluebutton-c"></div>
</a><a class="bluebutton" href="index.php" id="logincancelbutton">
<div class="bluebutton-a"></div>
<div class="bluebutton-b">
<div class="reldiv">
<div class="bluebutton-color">Cancel</div>
</div>Cancel</div>
<div class="bluebutton-c"></div>
</a>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</td><td class="tip-right"></td>
</tr>
<tr>
<td class="tip-bot-left"></td><td class="tip-bot"></td><td class="tip-bot-right"></td>
</tr>
</table>
</div>
</div>
<?php
}
else
{
	$username = $_SESSION['user_name'];
	$o->string("<br><br><br><center><span class=\"csearch-results-header\">You are logged as ".$username."</span></center>");
	$o->string("<center><form method=\"post\" action=\"?searchType=login\"><input name=\"logout\" style=\"border: 1px solid; font-weight: bold; background-color: rgb(0, 0, 0); color: rgb(255, 172, 4);\" value=\"Log out\" type=\"submit\"></form></center>");
	$o->string("<br><center><span class=\"csearch-results-header\">Change Password</span><br><br>");
	$o->string("<form method=\"post\" action=\"?searchType=login\">");
	$o->string("<table border=\"0\">");
	$o->string("<tr>");
	$o->string("<td><span class=\"csearch-results-header\">Old Password:</span></td>");
	$o->string("<td><input class=\"reg\" maxlength=\"30\" type=\"password\" name=\"old_pass\" size=\"30\"></td>");
	$o->string("</tr>");
	$o->string("<tr>");
	$o->string("<td><span class=\"csearch-results-header\">New Password:</span></td>");
	$o->string("<td><input class=\"reg\" maxlength=\"30\" type=\"password\" name=\"new_pass\" size=\"30\"></td>");
	$o->string("</tr>");
	$o->string("<tr>");
	$o->string("<td><span class=\"csearch-results-header\">Repeat New Password:</span></td>");
	$o->string("<td><input class=\"reg\" maxlength=\"30\" type=\"password\" name=\"rep_newpass\" size=\"30\"></td>");
	$o->string("</tr>");
	$o->string("</table>");
	$o->string("<center><input name=\"change\" style=\"border: 1px solid; font-weight: bold; background-color: rgb(0, 0, 0); color: rgb(255, 172, 4);\" value=\"Change password\" type=\"submit\"></center>");
	$o->string("</form>");
	$o->string("</center>");
	if(isset($_POST['old_pass']) && isset($_POST['new_pass']) && isset($_POST['rep_newpass']))
	{
		$pass_len = strlen($_POST['new_pass']);
		if(($pass_len >= 5) && ($pass_len <= 30))
		{
			if($_POST['new_pass'] == $_POST['rep_newpass'])
			{
				switchConnection($realms[$_SESSION["realm"]][0],"");
				$query = "SELECT `sha_pass_hash` FROM `account` WHERE `username` LIKE '$username' LIMIT 1";
				$result = mysql_query($query) or die (mysql_error());
				$row = mysql_fetch_assoc($result);
				$old_password = sha1(strtoupper($username.":".$_POST['old_pass']));
				if($old_password==$row["sha_pass_hash"])
				{
					$new_password = sha1(strtoupper($username.":".$_POST['new_pass']));
					$query = "UPDATE `account` SET `sha_pass_hash` = '$new_password' WHERE `username` = '$username' LIMIT 1";
					$result = mysql_query($query) or die (mysql_error());
					echo $o->string("<br><center>Password Changed</center>");
				}
				else
					$o->string("<br><center>Wrong Old Password</center>");
			}
			else
				$o->string("<br><center>New Password and Repeat New Password fields must match.</center>");
		}
		else
			$o->string("<br><center>Invalid length on New Password field (min5, max 30)</center>");
	}
}
?>
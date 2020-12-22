<?php
if(!defined('Armory') || ($config['Registration'] == 0))
{
	header('Location: ../');
	exit();
}
$o->string("<br><br><br>");
$o->string("<center><span class=\"csearch-results-header\">Create Account</span><br><br>");
$o->string("<form method=\"post\" action=\"?searchType=registration\">");
$o->string("<table border=\"0\">");
$o->string("<tr>");
$o->string("<td></td>");
$o->string("</tr>");
$o->string("<tr>");
$o->string("<td><span class=\"csearch-results-header\">Realm:</span></td>");
$o->string("<td><select class=\"reg\" name=\"realm\">");
foreach($realms as $key => $data)
	$o->string("<option value='".urlencode($key)."'>".$key."</option>");
$o->string("</select></td>");
$o->string("</tr>");
$o->string("<tr>");
$o->string("<td><span class=\"csearch-results-header\">Account name:</span></td>");
$o->string("<td><input class=\"reg\" maxlength=\"25\" type=\"text\" name=\"name\" size=\"30\"></td>");
$o->string("</tr>");
$o->string("<tr>");
$o->string("<td><span class=\"csearch-results-header\">Account password:</span></td>");
$o->string("<td><input class=\"reg\" maxlength=\"30\" type=\"password\" name=\"pass\" size=\"30\"></td>");
$o->string("</tr>");
$o->string("<tr>");
$o->string("<td><span class=\"csearch-results-header\">Verify Password:</span></td>");
$o->string("<td><input class=\"reg\" maxlength=\"30\" type=\"password\" name=\"pass2\" size=\"30\"></td>");
$o->string("</tr>");
$o->string("<tr>");  
$o->string("<td><span class=\"csearch-results-header\">Email:</span></td>");
$o->string("<td><input class=\"reg\" maxlength=\"60\" type=\"text\" name=\"email\" size=\"30\"></td>");
$o->string("</tr>");
$o->string("</table>");
$o->string("<br>");
$o->string("<center><input name=\"reg\" value=\"Create\" style=\"border: 1px solid; font-weight: bold; background-color: rgb(0, 0, 0); color: rgb(255, 172, 4);\" type=\"submit\"></center>");
$o->string("</form>");
$o->string("</center>");
if(isset($_POST['reg']) && isset($_POST['name']) && isset($_POST['pass']) && isset($_POST['pass2']) && isset($_POST['email']))
{
	switchConnection($realms[urldecode($_POST["realm"])][0],"");
	$banip = mysql_query("SELECT `ip` from `ip_banned` WHERE `ip` = '".$_SERVER['REMOTE_ADDR']."'");
	$numban = mysql_num_rows($banip);
	if($numban > 0)
		$o->string("<center>IP ".$_SERVER['REMOTE_ADDR']." is banned.</center>");
	else if($config['LockReg'] > 0)
	{
		$ipq = mysql_query("SELECT `last_ip` from `account` WHERE `last_ip` = '".$_SERVER['REMOTE_ADDR']."'");
		$numip = mysql_num_rows($ipq);
		if($numip >= $config['LockReg'])
			$o->string("<center>From you IP maximum accounts are already created (".$config['LockReg'].")</center>");
	}
	else
	{
		$username = strtoupper(trim(htmlspecialchars(addslashes($_POST['name']))));
		$pass = trim(htmlspecialchars(addslashes($_POST['pass'])));
		$pass2 = trim(htmlspecialchars(addslashes($_POST['pass2'])));
		$email = trim(htmlspecialchars(addslashes($_POST['email'])));
		$I = SHA1(strtoupper($username).':'.strtoupper($pass));
		$name_q = mysql_query("SELECT `username` FROM `account` WHERE `username` = '".$username."'") or die(mysql_error());
		$name_r = mysql_num_rows($name_q);
		if($name_r > 0)
			$o->string("<center>Account Name already exists.<center>");
		else
		{
			$name_len = strlen($username);
			if($name_len < 4 || $name_len > 25)
			{
				$o->string("<center>Invalid length on Account Name field (min 4, max 25).</center><br>");
				$name_er = 1;
			}
			else $name_er = 0;
			$pass_len = strlen($pass);
			if($pass_len < 5 || $pass_len > 30)
			{
				$o->string("<center>Invalid length on Account Password field (min5, max 30).</center><br>");
				$pass_er_len = 1;
			}
			else
				$pass_er_len = 0;
			if($pass != $pass2)
			{
				$o->string("<center>Password and Verification Password fields must match.</center><br>");
				$pass_er = 1;
			}
			else
				$pass_er = 0;
			if(!preg_match("|^[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,10}$|i", $email))
			{
				$o->string("<center>Invalid E-mail.</center>");
				$email_er = 1;
			}
			else
				$email_er = 0;
			if($name_er == 0 && $pass_er == 0 && $pass_er_len == 0 && $email_er == 0)
			{
				mysql_query("INSERT INTO `account` (username, sha_pass_hash, gmlevel, email, locked, last_ip, expansion) VALUES ('".$username."', '".$I."', '".$config['GmLevel']."', '".$email."', '".$config['LockAcc']."', '".$_SERVER['REMOTE_ADDR']."', '".$config['AccExpansion']."')") or die(mysql_error());
				$o->string("<center>Creation of account ".$username." is completed.</center>");
			}
		}
	}
}
?>
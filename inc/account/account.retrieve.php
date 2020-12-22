<?php

if (INCLUDED!==true) { include('index.htm'); exit; }


parchup();

title('Retrieve Account Name or Password');

subnav('Retrieve Account');

parchdown();

parchup(true);

switch($_REQUEST['t']) {
	
	case "name":
		if ($_SERVER['REQUEST_METHOD']=='POST') {
		
			$maila = mysql_query("SELECT username FROM account WHERE email='".$_POST['uemail']."'");
			$mailb = mysql_fetch_array($maila);
			$msg = 'Hello, here\'s your Account Name:<br>
				<b>'.$mailb['username'].'</b>
				<br><br>Thank you!';
			if (valemail($_POST['uemail'])==false) {
				errborder('Invalid E-mail.');
				$_SERVER['REQUEST_METHOD']='GET';
			} else if (mysql_num_rows($maila)==0) {
				errborder('E-mail Non-existent.');
				$_SERVER['REQUEST_METHOD']='GET';
			} else if (!sendemail($_POST['uemail'], $mailb['username'], $SETTING['WEB_SITE_NAME'].': Account Name Request', '',$msg)) {
				echo '<script>
							  window.location="mailto:'.$SETTING['EMAIL_MAIN'].'?subject=Account Name Request&body=Account E-mail: '.$_POST['uemail'].'";
							  window.location="?";
				</script>';
				$_SERVER['REQUEST_METHOD']='GET';
			} else {
				?>
				<center>
				<!--Shadow Top-->
				<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><img src="shared/wow-com/images/borders/shadow/shadow-top-left.gif" height="4" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-top.gif"><img src="shared/wow-com/images/borders/shadow/shadow-top-left-left.gif" height="4" width="12"></td><td align="right" background="shared/wow-com/images/borders/shadow/shadow-top.gif"><img src="shared/wow-com/images/borders/shadow/shadow-top-right-right.gif" height="4" width="12"></td><td><img src="shared/wow-com/images/borders/shadow/shadow-top-right.gif" height="4" width="9"></td></tr><tr><td background="shared/wow-com/images/borders/shadow/shadow-left.gif" valign="top"><img src="shared/wow-com/images/borders/shadow/shadow-left-top.gif" height="12" width="5"></td><td colspan="2" rowspan="2" style="background-image: url(shared/wow-com/images/headers/header-left2.jpg); background-repeat: no-repeat;">
				<!--Shadow Top-->
				<table class="listOuter2" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td>
				<table class="listOuter" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td>

				<table border="0" cellpadding="4" cellspacing="0" width="435">
				<tbody><tr>

				<td><h3 class="title">

				Your Account Name Has Been Sent!

				</h3></td>
				</tr>
				</tbody></table>
				<table style="background-image: url(shared/wow-com/images/characters/ingame/success.jpg); background-position: left center; background-repeat: no-repeat;" border="0" cellpadding="10" cellspacing="0" width="435">
				<tbody><tr>
				<td>
				<table border="0" cellpadding="0" cellspacing="0" width="245">
				<tbody><tr>
					<td>
					<span>
				    
					<span style="font-size: 13px;"><img src="shared/wow-com/images/smallcaps/plain/y.gif" align="left" height="38" width="40">our account name has been sent to <b><?php echo $_POST['uemail']; ?></b>.  If you are having difficulties recovering your account name, try to reach an administrator by replying to <a href="mailto:<?php echo $SETTING['EMAIL_MAIN']; ?>"><?php echo $SETTING['EMAIL_MAIN']; ?></a>.
				    
					</span>

					</td>
				</tr>
				</tbody></table>
				<br>
				<img src="shared/wow-com/images/layout/pixel.gif" height="280" width="1">
					<br>
					<center>

					<a href="?"><img src="shared/wow-com/images/buttons/button-complete.gif" border="0" height="46" width="174"></a>

					</center>

				</td></tr></tbody></table>


				</td></tr></tbody></table>
				</td></tr></tbody></table>

				<!--Shadow Bottom-->
				</td><td background="shared/wow-com/images/borders/shadow/shadow-right.gif" valign="top"><img src="shared/wow-com/images/borders/shadow/shadow-right-top.gif" height="12" width="9"></td></tr><tr><td background="shared/wow-com/images/borders/shadow/shadow-left.gif" valign="bottom"><img src="shared/wow-com/images/borders/shadow/shadow-left-bot.gif" height="12" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-right.gif" valign="bottom"><img src="shared/wow-com/images/borders/shadow/shadow-right-bot.gif" height="12" width="9"></td></tr><tr><td><img src="shared/wow-com/images/borders/shadow/shadow-bot-left.gif" height="10" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src="shared/wow-com/images/borders/shadow/shadow-bot-left-left.gif" height="10" width="12"></td><td align="right" background="shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src="shared/wow-com/images/borders/shadow/shadow-bot-right-right.gif" height="10" width="12"></td><td><img src="shared/wow-com/images/borders/shadow/shadow-bot-right.gif" height="10" width="9"></td></tr></tbody></table>
				<!--Shadow Bottom-->

				</center>

				<?
				unset($_POST['uemail']);
			}
		}
		if ($_SERVER['REQUEST_METHOD']!='POST') {
			?>
			<center>
			<!--Shadow Top-->
			<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><img src="shared/wow-com/images/borders/shadow/shadow-top-left.gif" height="4" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-top.gif"><img src="shared/wow-com/images/borders/shadow/shadow-top-left-left.gif" height="4" width="12"></td><td align="right" background="shared/wow-com/images/borders/shadow/shadow-top.gif"><img src="shared/wow-com/images/borders/shadow/shadow-top-right-right.gif" height="4" width="12"></td><td><img src="shared/wow-com/images/borders/shadow/shadow-top-right.gif" height="4" width="9"></td></tr><tr><td background="shared/wow-com/images/borders/shadow/shadow-left.gif" valign="top"><img src="shared/wow-com/images/borders/shadow/shadow-left-top.gif" height="12" width="5"></td><td colspan="2" rowspan="2" style="background-image: url(shared/wow-com/images/headers/header-left2.jpg); background-repeat: no-repeat;">
			<!--Shadow Top-->

			<table class="listOuter2" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td>
			<table class="listOuter" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td>
			<form name="retrieveaccount" method="post" action="?n=account.retrieve&t=name">

			<table border="0" cellpadding="4" cellspacing="0">
			<tbody><tr>
				<td><h3 class="title">Enter your Email Address Below:</h3></td>
			</tr>

			</tbody></table>
			
			<table cellpadding="10" cellspacing="0" width="500">
			<tbody><tr>
				<td>
				<span>

				<table border="0" cellpadding="0" cellspacing="0">
				<tbody><tr>
					<td>
					<span>

			   		<span style="font-size: 13px;"><img src="shared/wow-com/images/smallcaps/plain/w.gif" align="left" height="38" width="40">ait... you forgot your Account Name? That's pretty embarrassing, don't you think? I mean, forgetting your password, that's understandable... but your <i>account name</i>?  Well... don't worry, we won't tell anyone.  Your shame is safe with us.  Enter the email address associated with your account in the box below:
					</span>
					</td>
					<td><img src="new-hp/images/confusedorc.jpg" height="200" width="153"></td>
				</tr>
				<tr>
					<td colspan="2"><img src="shared/wow-com/images/layout/hr.gif" height="1" width="500"><br><img src="shared/wow-com/images/layout/pixel.gif" height="10" width="1"></td>
				</tr>

				<tr>
					<td colspan="2" align="center">

			<table style="border: 1px dotted rgb(146, 128, 88);" width="520"><tbody><tr><td>
			<table style="border: 1px solid black; background-image: url(shared/wow-com/images/parchment/plain/light3.jpg);" width="100%"><tbody><tr><td align="center">


						<table border="0" cellpadding="4" cellspacing="0">
						<tbody><tr>
						      <td align="right">
						  	  <span style="font-size: 13px;"><b>Email Address:</b></span>

						      </td>
						      
						      <td align="left"><input name="uemail" value="" maxlength="50" style="width: 250px;" tabindex="2" type="text"></td>
							  <td align="left" valign="top">

				   </td>
						      
						</tr>
						</tbody></table>
						
			</td></tr></tbody></table>

			</td></tr></tbody></table> 
					
					</td>
				</tr>
				<tr>
					<td colspan="2"><img src="shared/wow-com/images/layout/pixel.gif" height="10" width="1"><br><img src="shared/wow-com/images/layout/hr.gif" height="1" width="500"></td>
				</tr>	
				</tbody></table>

			    <p>

			    </p><center>
			    <table border="0" cellpadding="0" cellspacing="0">

			    <tbody><tr>
			    <td width="91"><a href="?"><img src="shared/wow-com/images/buttons/button-back.gif" alt="Back" class="button" border="0" height="46" width="91"></a></td>
			    <td width="174"><input src="shared/wow-com/images/buttons/button-continue.gif" name="submit" alt="Continue" class="button" border="0" height="46" type="image" width="174"></td>
			    </tr>
			    </tbody></table>
			    </center>
				
				</span></td>
			</tr>
			</tbody></table>

			</form></td></tr></tbody></table>
			</td></tr></tbody></table>

			<!--Shadow Bottom-->
			</td><td background="shared/wow-com/images/borders/shadow/shadow-right.gif" valign="top"><img src="shared/wow-com/images/borders/shadow/shadow-right-top.gif" height="12" width="9"></td></tr><tr><td background="shared/wow-com/images/borders/shadow/shadow-left.gif" valign="bottom"><img src="shared/wow-com/images/borders/shadow/shadow-left-bot.gif" height="12" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-right.gif" valign="bottom"><img src="shared/wow-com/images/borders/shadow/shadow-right-bot.gif" height="12" width="9"></td></tr><tr><td><img src="shared/wow-com/images/borders/shadow/shadow-bot-left.gif" height="10" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src="shared/wow-com/images/borders/shadow/shadow-bot-left-left.gif" height="10" width="12"></td><td align="right" background="shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src="shared/wow-com/images/borders/shadow/shadow-bot-right-right.gif" height="10" width="12"></td><td><img src="shared/wow-com/images/borders/shadow/shadow-bot-right.gif" height="10" width="9"></td></tr></tbody></table>
			<!--Shadow Bottom-->
			<br><br>
			</center>
			<?
		}
	break;
	case "password":
	default:
		$forceshow=true;
		if ($_SERVER['REQUEST_METHOD']=='POST' AND $_POST['uname']!='') {
			$row = mysql_fetch_array(mysql_query("SELECT id_account, passask FROM forum_accounts f LEFT JOIN (account a) ON a.id = f.id_account WHERE LOWER(username)=LOWER('".$_POST['uname']."')"));
			if ($row['id_account'] == '') {
				unset($_POST['uname']);
				errborder('Invalid Account Name.');
			}
		}
		if ($_SERVER['REQUEST_METHOD']=='POST' AND $_POST['uname']!='' AND $_POST['uemail']!='') {
			$newpass =secuimg(8);
			$maila = mysql_query("SELECT a.username as username, a.id as id, f.displayname as dn, a.sha_pass_hash as password FROM forum_accounts f LEFT JOIN (account a) ON a.id = f.id_account WHERE LOWER(a.username)=LOWER('".$_POST['uname']."') AND f.passask='".$row['passask']."' AND LOWER(f.passans)=LOWER('".$_POST['passans']."') AND LOWER(a.email)=LOWER('".$_POST['uemail']."')");
			$mailb = mysql_fetch_array($maila);
			$msg = 'Hello, here\'s your New Account Password:<br>
				<b>'.$newpass.'</b>
				<br><br>Thank you!';
			if (mysql_num_rows($maila)==0) {
				errborder('Invalid Settings!');
			} else if (!@sendemail($_POST['uemail'], $_POST['dn'],$SETTING['WEB_SITE_NAME'].': Account Password Request','', $msg)) {
				echo '<script>
							  window.location="mailto:'.$SETTING['EMAIL_MAIN'].'?subject=Account Password Request&body=Account Details:%0AName: '.$_POST['uname'].'%0AE-mail: '.$_POST['uemail'].'%0ASecret Question: ('.$row['passask'].') '.$PASSWORD_QUESTION[$row['passask']].'%0AAnswer: '.$_POST['passans'].'";
							  window.location="?";
				</script>';
			} else {
				mysql_query("UPDATE account SET sha_pass_hash=SHA1('".strtoupper($mailb['username']).":".strtoupper($newpass)."') WHERE id='".$mailb['id']."'");
				?>
				<center>
				<!--Shadow Top-->
				<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><img src="shared/wow-com/images/borders/shadow/shadow-top-left.gif" height="4" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-top.gif"><img src="shared/wow-com/images/borders/shadow/shadow-top-left-left.gif" height="4" width="12"></td><td align="right" background="shared/wow-com/images/borders/shadow/shadow-top.gif"><img src="shared/wow-com/images/borders/shadow/shadow-top-right-right.gif" height="4" width="12"></td><td><img src="shared/wow-com/images/borders/shadow/shadow-top-right.gif" height="4" width="9"></td></tr><tr><td background="shared/wow-com/images/borders/shadow/shadow-left.gif" valign="top"><img src="shared/wow-com/images/borders/shadow/shadow-left-top.gif" height="12" width="5"></td><td colspan="2" rowspan="2" style="background-image: url(shared/wow-com/images/headers/header-left2.jpg); background-repeat: no-repeat;">
				<!--Shadow Top-->
				<table class="listOuter2" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td>
				<table class="listOuter" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td>

				<table border="0" cellpadding="4" cellspacing="0" width="435">
				<tbody><tr>

				<td><h3 class="title">

				Your Account Password Has Been Sent!

				</h3></td>
				</tr>
				</tbody></table>
				<table style="background-image: url(shared/wow-com/images/characters/ingame/success.jpg); background-position: left center; background-repeat: no-repeat;" border="0" cellpadding="10" cellspacing="0" width="435">
				<tbody><tr>
				<td>
				<table border="0" cellpadding="0" cellspacing="0" width="245">
				<tbody><tr>
					<td>
					<span>
				    
					<span style="font-size: 13px;"><img src="shared/wow-com/images/smallcaps/plain/y.gif" align="left" height="38" width="40">our account password has been sent to <b><?php echo $_POST['uemail']; ?></b>.  If you are having difficulties recovering your account password, try to reach an administrator by replying to <a href="mailto:<?php echo $SETTING['EMAIL_MAIN']; ?>"><?php echo $SETTING['EMAIL_MAIN']; ?></a>.
				    
					</span>

					</td>
				</tr>
				</tbody></table>
				<br>
				<img src="shared/wow-com/images/layout/pixel.gif" height="280" width="1">
					<br>
					<center>

					<a href="?"><img src="shared/wow-com/images/buttons/button-complete.gif" border="0" height="46" width="174"></a>

					</center>

				</td></tr></tbody></table>


				</td></tr></tbody></table>
				</td></tr></tbody></table>

				<!--Shadow Bottom-->
				</td><td background="shared/wow-com/images/borders/shadow/shadow-right.gif" valign="top"><img src="shared/wow-com/images/borders/shadow/shadow-right-top.gif" height="12" width="9"></td></tr><tr><td background="shared/wow-com/images/borders/shadow/shadow-left.gif" valign="bottom"><img src="shared/wow-com/images/borders/shadow/shadow-left-bot.gif" height="12" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-right.gif" valign="bottom"><img src="shared/wow-com/images/borders/shadow/shadow-right-bot.gif" height="12" width="9"></td></tr><tr><td><img src="shared/wow-com/images/borders/shadow/shadow-bot-left.gif" height="10" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src="shared/wow-com/images/borders/shadow/shadow-bot-left-left.gif" height="10" width="12"></td><td align="right" background="shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src="shared/wow-com/images/borders/shadow/shadow-bot-right-right.gif" height="10" width="12"></td><td><img src="shared/wow-com/images/borders/shadow/shadow-bot-right.gif" height="10" width="9"></td></tr></tbody></table>
				<!--Shadow Bottom-->

				</center>

				<?
				unset($_POST['passans']);
				unset($_POST['uemail']);
				$forceshow=false;
			}
		}
		if ($forceshow==true) {
		?>
		<center>

		<!--Shadow Top-->
		<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><img src="shared/wow-com/images/borders/shadow/shadow-top-left.gif" height="4" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-top.gif"><img src="shared/wow-com/images/borders/shadow/shadow-top-left-left.gif" height="4" width="12"></td><td align="right" background="shared/wow-com/images/borders/shadow/shadow-top.gif"><img src="shared/wow-com/images/borders/shadow/shadow-top-right-right.gif" height="4" width="12"></td><td><img src="shared/wow-com/images/borders/shadow/shadow-top-right.gif" height="4" width="9"></td></tr><tr><td background="shared/wow-com/images/borders/shadow/shadow-left.gif" valign="top"><img src="shared/wow-com/images/borders/shadow/shadow-left-top.gif" height="12" width="5"></td><td colspan="2" rowspan="2" style="background-image: url(shared/wow-com/images/headers/header-left2.jpg); background-repeat: no-repeat;">
		<!--Shadow Top-->

		<table class="listOuter2" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td>
		<table class="listOuter" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td>
		<form name="form1" method="post" action="?n=account.retrieve&t=password">

		<table border="0" cellpadding="4" cellspacing="0">
		<tbody><tr>
			<td><h3 class="title">Enter your <?php echo $SETTING['WEB_SITE_NAME']; ?> Account Info Below:</h3></td>
		</tr>
		</tbody></table>


		<table cellpadding="10" cellspacing="0" width="500">
		<tbody><tr>
			<td>

			<span>
			
			<table border="0" cellpadding="0" cellspacing="0">
			<tbody><tr>
				<td>
				<span>
		   		<span style="font-size: 13px;"><img src="shared/wow-com/images/smallcaps/plain/y.gif" align="left" height="38" width="40">ou forgot your password!? When we said "keep it secret, keep it safe" we didn't mean for you to take it this far. For future reference, forgetting your password completely is just a hair <i>too secret</i> to be practical. Well, no worries.  We'll try to get it back for you. Start by entering your Account Name into the box below.<br>Then answer your secret question and then input your phone number and email address. A new password will be sent to you. Once you recieve the new password, you can log on to Account Management and change it.  
				<p>
				If you've forgotten your Account Name as well, try the <a href="?n=account.retrieve&t=name">Account Name retrieval page</a> first. 

				</p></span><br>

				</td>
				<td><img src="new-hp/images/confusedorc.jpg" height="200" width="153"></td>
			</tr>
			<tr>
				<td colspan="2"><img src="shared/wow-com/images/layout/hr.gif" height="1" width="500"><br><img src="shared/wow-com/images/layout/pixel.gif" height="10" width="1"></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
							

		<table style="border: 1px dotted rgb(146, 128, 88);" width="520"><tbody><tr><td>
		<table style="border: 1px solid black; background-image: url(shared/wow-com/images/parchment/plain/light3.jpg);" width="100%"><tbody><tr><td align="center">


					<table border="0" cellpadding="4" cellspacing="0">
					<tbody>
			<?php if ($_POST['uname']=='') { ?>
			<tr>
					      <td align="right">
					  	  <span style="font-size: 13px;"><b>Your World of Warcraft Account Name:</b></span>
					      </td>
					      
					      <td align="left">

					      <input name="uname" value="" maxlength="16" tabindex="1" type="text" width="150">
					      </td>
						  <td align="left" valign="top">



			   </td> 
			</tr>
			<?php } else if ($_POST['uname']!='') { ?>
			<input name="uname" value="<?php echo $_POST['uname']; ?>" type="hidden">
			<tr>
				      <td align="right"><span style="font-size: 13px;"><b>Secret Question:</b></span></td>

				      <td align="left"><span style="font-size: 13px;"><? echo $PASSWORD_QUESTION[$row['passask']]; ?></span>
				      </td>
					  <td align="left" nowrap="nowrap"></td>

				</tr>			
				<tr>

				      <td align="right">
				  	  <span style="font-size: 13px;"><b>Answer:</b></span>
				      </td>
				      
				      <td align="left">
				      <input name="passans" maxlength="32" tabindex="1" value="<? echo $_POST['passans']; ?>" type="text" width="150">
				      </td>
					  <td align="left" valign="top">


		   </td>
				      
				</tr>
				<tr>
				      <td align="right">

				  	  <span style="font-size: 13px;"><b>Email Address:</b></span>
				      </td>
				      
				      <td align="left">

				      <input name="uemail" maxlength="50" tabindex="2" value="<? echo $_POST['uemail']; ?>" type="text" width="150">

				      </td>
					  <td align="left" valign="top">

		   </td>
				      
				</tr>
			<?php } ?>
						</tbody></table>
						
						
			</td></tr></tbody></table>

			</td></tr></tbody></table> 
					
					</td>
				</tr>
				<tr>
					<td colspan="2"><img src="shared/wow-com/images/layout/pixel.gif" height="10" width="1"><br><img src="shared/wow-com/images/layout/hr.gif" height="1" width="500"></td>
				</tr>	
				</tbody></table>
				
		    <p>

		    </p><center>
		    <table border="0" cellpadding="0" cellspacing="0">

		    <tbody><tr>
		    <td width="91"><a href="?<?php if ($_POST['uname']!='') { echo 'n=account.retrieve&t=password'; } ?>"><img src="shared/wow-com/images/buttons/button-back.gif" alt="Back" class="button" tabindex="3" border="0" height="46" width="91"></a></td>
		    <td width="174"><input src="shared/wow-com/images/buttons/button-continue.gif" name="submit" alt="Continue" class="button" tabindex="2" border="0" height="46" type="image" width="174"></td>
		    </tr>
		    </tbody></table>
		    </center>
			
			</span></td>
		</tr>
		</tbody></table>

		</form></td></tr></tbody></table>
		</td></tr></tbody></table>

		<!--Shadow Bottom-->
		</td><td background="shared/wow-com/images/borders/shadow/shadow-right.gif" valign="top"><img src="shared/wow-com/images/borders/shadow/shadow-right-top.gif" height="12" width="9"></td></tr><tr><td background="shared/wow-com/images/borders/shadow/shadow-left.gif" valign="bottom"><img src="shared/wow-com/images/borders/shadow/shadow-left-bot.gif" height="12" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-right.gif" valign="bottom"><img src="shared/wow-com/images/borders/shadow/shadow-right-bot.gif" height="12" width="9"></td></tr><tr><td><img src="shared/wow-com/images/borders/shadow/shadow-bot-left.gif" height="10" width="5"></td><td background="shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src="shared/wow-com/images/borders/shadow/shadow-bot-left-left.gif" height="10" width="12"></td><td align="right" background="shared/wow-com/images/borders/shadow/shadow-bot.gif"><img src="shared/wow-com/images/borders/shadow/shadow-bot-right-right.gif" height="10" width="12"></td><td><img src="shared/wow-com/images/borders/shadow/shadow-bot-right.gif" height="10" width="9"></td></tr></tbody></table>
		<!--Shadow Bottom-->
		<br><br>

		<center>
		<?
		}
	break;
}
parchdown();

?>
<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title('Site Administration');

parchdown();

$userlevel=verifylevel($_SESSION['userid']);

if (!isset($_SESSION['userid'])) {

	parchup(true);
	errborder($_LANG['ERROR']['NEED_LOGIN']);
	parchdown();

} elseif ($userlevel<1) {

	parchup(true);
	errborder($_LANG['ERROR']['DENY_ACCESS']);
	parchdown();

} else {

	?>
<style><!--
 img.bul {
	background-image: url('new-hp/images/icons/bullet.gif');
	background-repeat: no-repeat;
	background-position: 100% 50%;
	width: 25;
	height: 15;
}
--></style>
					<table width=100%>
					<tr>
					<td align=center valign=top width=220>
					<style>
						#quicklinks h3 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-control-panel.jpg') no-repeat 30px 8px; }
					</style>
					  <div id="quicklinks" align=left>

						<div class="plainBox-top">
						  <h3>
							<span>Control Panel</span>
						  </h3>
						</div>

						<div class="plainBox-cnt">

						  <div class="plainBox-cnt-top">

							<div class="plainBox-cnt-bot">

							  <ul class="none">
								<li>
								  <img src="new-hp/images/pixel.gif" height=5>
								</li>
<?php 
if ($userlevel>=3) { 
?>
								<li>
								  <a><img src="new-hp/images/icons/support.jpg">Database</a>
								</li>
								<li>
								  <a href="index.php?n=admin.database&t=settings"><img class="bul" src="new-hp/images/pixel.gif" >Settings</a>
								</li>
								
	<? if ($userlevel>=$SETTING['DB_BACKUP']) { ?>
								<li>
								  <a href="index.php?n=admin.database&t=backup"><img class="bul" src="new-hp/images/pixel.gif" >Backup</a>
								</li>
	<?php } ?>
	<? if ($userlevel>=$SETTING['DB_RESTORE']) { ?>
								<li>
								  <a href="index.php?n=admin.database&t=restore"><img class="bul" src="new-hp/images/pixel.gif" >Restore</a>
								</li>
	<?php } ?>
								<li>
								  <img src="new-hp/images/pixel.gif" height=5>
								</li>
<?php 
}

if ($userlevel>=3) { 
?>
								<li>
								  <a><img src="new-hp/images/icons/realmstatus.jpg">Realms</a>
								</li>
								<li>
								  <a href="index.php?n=admin.realms"><img class="bul" src="new-hp/images/pixel.gif" >Manage</a>
								</li>
								<li>
								  <img src="new-hp/images/pixel.gif" height=5>
								</li>
<?php 
}

if ($userlevel>=$SETTING['USER_WEB']) { 
?>

								<li>
								  <a><img src="new-hp/images/icons/faq.jpg">Website</a>
								</li>
								<li>
								  <a href="index.php?n=admin.web&t=settings"><img class="bul" src="new-hp/images/pixel.gif" >Settings</a>
								</li>
								<li>
								  <a href="index.php?n=admin.web&t=layout"><img class="bul" src="new-hp/images/pixel.gif" >Layout</a>
								</li>
								<li>
								  <img src="new-hp/images/pixel.gif" height=5>
								</li>
<?php 
}

if ($userlevel>=$SETTING['USER_FORUMS']) { 
?>
								<li>
								  <a><img src="new-hp/images/icons/faq.jpg">Forums</a>
								</li>
	<? if ($userlevel>=3) { ?>
								<li>
								  <a href="index.php?n=admin.forums&t=settings"><img class="bul" src="new-hp/images/pixel.gif" >Settings</a>
								</li>
	<?php } ?>
								<li>
								  <a href="index.php?n=admin.forums&t=add"><img class="bul" src="new-hp/images/pixel.gif" >Add</a>
								</li>
								<li>
								  <a href="index.php?n=admin.forums"><img class="bul" src="new-hp/images/pixel.gif" >Manage</a>
								</li>
								<li>
								  <a href="index.php?n=admin.forums&t=reports"><img class="bul" src="new-hp/images/pixel.gif" >Reports</a>
								</li>
								<li>
								  <a href="index.php?n=admin.forums&t=smiles"><img class="bul" src="new-hp/images/pixel.gif" >Smiles</a>
								</li>
								<li>
								  <img src="new-hp/images/pixel.gif" height=5>
								</li>
<?php 
}

if ($userlevel>=$SETTING['USER_ACCOUNTS']) { 
?>
								<li>
								  <a><img src="new-hp/images/icons/retrieve_pwd.jpg">User Accounts</a>
								</li>
	<?php 
	if ($userlevel>=3) { 
	?>
									<li>
									  <a href="index.php?n=admin.accounts&t=settings"><img class="bul" src="new-hp/images/pixel.gif" >Settings</a>
									</li>
									<li>
									  <a href="index.php?n=admin.accounts&t=priviledges"><img class="bul" src="new-hp/images/pixel.gif" >Priviledges</a>
									</li>

	<?php 
	}
	if ($userlevel>=$SETTING['USER_ACCOUNTS']) { 
	?>
									<li>
									  <a href="index.php?n=admin.accounts"><img class="bul" src="new-hp/images/pixel.gif" >Manage</a>
									</li>
									<li>
									  <a href="index.php?n=admin.accounts&t=cleanup"><img class="bul" src="new-hp/images/pixel.gif" >Clean Up</a>
									</li>
									<li>
									  <a href="index.php?n=admin.accounts&t=ipban"><img class="bul" src="new-hp/images/pixel.gif" >IP Ban</a>
									</li>
									<li>
									  <img src="new-hp/images/pixel.gif" height=5>
									</li>
	<?php 
	}
}

if ($userlevel>=$SETTING['USER_MISC']) { 
?>
								<li>
								  <a><img src="new-hp/images/icons/acc_creation.jpg">Miscellaneous</a>
								</li>
								<li>
								  <a href="index.php?n=admin.misc&t=add"><img class="bul" src="new-hp/images/pixel.gif" >Add</a>
								</li>
								<li>
								  <a href="index.php?n=admin.misc"><img class="bul" src="new-hp/images/pixel.gif" >Manage</a>
								</li>
								<li>
								  <img src="new-hp/images/pixel.gif" height=5>
								</li>
<?php 
}

if ($userlevel>=$SETTING['USER_DONATIONS']) { 
?>
								<li>
								  <a><img src="new-hp/images/icons/acct_management.jpg">Donations</a>
								</li>
								<li>
								  <a href="index.php?n=admin.donations&t=settings"><img class="bul" src="new-hp/images/pixel.gif" >Settings</a>
								</li>
								<li>
								  <a href="index.php?n=admin.donations&t=add"><img class="bul" src="new-hp/images/pixel.gif" >Add</a>
								</li>
								<li>
								  <a href="index.php?n=admin.donations"><img class="bul" src="new-hp/images/pixel.gif" >Manage</a>
								</li>
								<li>
								  <img src="new-hp/images/pixel.gif" height=5>
								</li>
<?php 
}

if ($userlevel>=$SETTING['USER_EMAIL']) { 
?>
								<li>
								  <a><img src="new-hp/images/icons/download.jpg">E-mail</a>
								</li>
								<li>
								  <a href="index.php?n=admin.email&t=settings"><img class="bul" src="new-hp/images/pixel.gif" >Settings</a>
								</li>
								<li>
								  <a href="index.php?n=admin.email&t=send"><img class="bul" src="new-hp/images/pixel.gif" >Send E-mail</a>
								</li>
								<li>
								  <img src="new-hp/images/pixel.gif" height=5>
								</li>
<?php 
}

if ($userlevel>=1) { 
?>
								<li>
								  <a><img src="new-hp/images/icons/patch_notes.jpg">Pictures Gallery</a>
								</li>
								<li>
								  <a href="index.php?n=admin.gallery&t=add"><img class="bul" src="new-hp/images/pixel.gif" >Add</a>
								</li>
								<li>
								  <a href="index.php?n=admin.gallery&t=manage"><img class="bul" src="new-hp/images/pixel.gif">Manage</a>
								</li>
								<li>
								  <img src="new-hp/images/pixel.gif" height=5>
								</li>
<?php 
}

if ($userlevel>=3) { 
?>
								<li>
								  <a><img src="new-hp/images/icons/patch_notes.jpg">Text Dialogs</a>
								</li>
								<li>
								  <a href="index.php?n=admin.text&t=agreement"><img class="bul" src="new-hp/images/pixel.gif" >Agreement</a>
								</li>
								<li>
								  <a href="index.php?n=admin.text&t=introduction"><img class="bul" src="new-hp/images/pixel.gif" >Introduction</a>
								</li>
								<li>
								  <a href="index.php?n=admin.text&t=gettingstarted"><img class="bul" src="new-hp/images/pixel.gif" >Getting Started</a>
								</li>
								<li>
								  <a href="index.php?n=admin.text&t=faq"><img class="bul" src="new-hp/images/pixel.gif" >FAQ</a>
								</li>
								<li>
								  <a href="index.php?n=admin.text&t=rules"><img class="bul" src="new-hp/images/pixel.gif" >Rules</a>
								</li>
								<li>
								  <a href="index.php?n=admin.text&t=jobs"><img class="bul" src="new-hp/images/pixel.gif" >Jobs</a>
								</li>
<?php 
}
?>
								<li>
								  <img src="new-hp/images/pixel.gif" height=5>
								</li>
							  </ul>

							</div>

						  </div>

						</div>

						<div class="plainBox-bot"></div>

					  </div> 
					</td>
					<td valign=top>
<?php

parchup(true);

switch($_REQUEST['n']) {
	case "admin.web":
	
		if ($userlevel>=$SETTING['USER_WEB']) require('admin.web.php'); else errborder($_LANG['ERROR']['DENY_ACCESS']);
	
	break;
	case "admin.misc":
	
		if ($userlevel>=$SETTING['USER_MISC']) require('admin.misc.php'); else errborder($_LANG['ERROR']['DENY_ACCESS']);
	
	break;
	case "admin.accounts":
		
		if ($_REQUEST['t']=='priviledges' OR $_REQUEST['t']=='settings') { 
			if ($userlevel>=3) { require('admin.accounts.php'); } else { errborder($_LANG['ERROR']['DENY_ACCESS']); } }
		else if ($userlevel>=$SETTING['USER_ACCOUNTS']) { require('admin.accounts.php'); } 
		else { errborder($_LANG['ERROR']['DENY_ACCESS']); }
		
	
	break;
	case "admin.forums":
	
		if ($_REQUEST['t']=='settings') { 
			if ($userlevel>=3) { require('admin.forums.php'); } else { errborder($_LANG['ERROR']['DENY_ACCESS']); } }
		else if ($userlevel>=$SETTING['USER_FORUMS']) require('admin.forums.php'); else errborder($_LANG['ERROR']['DENY_ACCESS']);
	
	break;
	case "admin.database":
	
		if ($userlevel>=3) require('admin.database.php'); else errborder($_LANG['ERROR']['DENY_ACCESS']);
	
	break;
	case "admin.gallery":
	
		if ($userlevel>=1) require('admin.gallery.php'); else errborder($_LANG['ERROR']['DENY_ACCESS']);
	
	break;
	case "admin.donations":
	
		if ($userlevel>=$SETTING['USER_DONATIONS']) require('admin.donations.php'); else errborder($_LANG['ERROR']['DENY_ACCESS']);
	
	break;
	case "admin.email":
	
		if ($userlevel>=$SETTING['USER_EMAIL']) require('admin.email.php'); else errborder($_LANG['ERROR']['DENY_ACCESS']);
	
	break;
	case "admin.text":
	
		if ($userlevel>=3) require('admin.text.php'); else errborder($_LANG['ERROR']['DENY_ACCESS']);
	
	break;
	case "admin.realms":
	
		if ($userlevel>=3) require('admin.realms.php'); else errborder($_LANG['ERROR']['DENY_ACCESS']);
	
	break;
	default:
		
		goodborder('Welcome to Site Administration area!');
	
	break;
}

parchdown();

?>
					</td>
					  <tr>
					 </table>
	<?php
	
}

?>
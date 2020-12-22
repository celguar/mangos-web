<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

	$forceshow=true;
	
	if ($_POST['update']=='web1') {
	
		if (alphanum($_POST['wsitename'],true,true," _-")==false) {
			$haserrors .= 'Invalid Web Site Name!';
		}
		
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wsitename']."' WHERE setting='web_site_name'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wcountry']."' WHERE setting='web_location'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wgmt']."' WHERE setting='web_gmt'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wmodules']."' WHERE setting='web_enable_modules'");
			
		if ($query) {
						
			goodborder($_LANG['SUCCESS']['ADMIN_SET']);
			newrssfeed();
			$forceshow=false;
			
		} else {
		
			$haserrors .= mysql_error();
		}
	} else if ($_POST['update']=='web2') {
		
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wshowflash']."' WHERE setting='web_show_flash'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wflashurl']."' WHERE setting='web_flash_url'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wshownews']."' WHERE setting='web_show_news'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wshowcontests']."' WHERE setting='web_show_contests'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wshowfanart']."' WHERE setting='web_show_fanart'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wshowwallpapers']."' WHERE setting='web_show_wallpapers'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wshowcommunity']."' WHERE setting='web_show_community'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wshowsupport']."' WHERE setting='web_show_support'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wshowjobs']."' WHERE setting='web_show_jobs'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wshowmisc']."' WHERE setting='web_show_misc'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wshowdonations']."' WHERE setting='web_show_donations'");
		$query=mysql_query("UPDATE web_settings SET value='".$_POST['wdeftemp']."' WHERE setting='web_def_template'");
		
		if ($query) {
						
			goodborder($_LANG['SUCCESS']['ADMIN_SET']);
			$forceshow=false;
			
		} else {
		
			$haserrors .= mysql_error();
		}
	}
			
	if ($forceshow==true) {
		remslashall();
	if ($_REQUEST['t']=="settings") {

			?>
<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>			
			<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%" align=center>
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white">Website Settings:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>
			<center>
			<a name = "phone"></a>
			<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<form method=post action="index.php?n=admin.web&t=settings" name="siteadmin" onsubmit="aw_valid()">
	<input type=hidden name="update">
<script type="text/javascript">
function aw_valid() {
	void(document.siteadmin.update.value="web1");
	return true;	
}
</script>
			<table border=0 cellspacing=0 cellpadding=4 width = "100%">
			<tr>
			      <td width=30% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Website Name:<br>
			      </span></b></font>
			      </td>
			      <td 70% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><input name="wsitename" type=text size=40 maxlength=80 value="<?php echo $SETTING['WEB_SITE_NAME']; ?>"></td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Server Location:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wcountry" style="width: 250px;" OnChange="javascript:void(document.siteadmin.cflag.src = 'new-hp/images/flags/' + this.value + '.gif')">
<?
foreach ($COUNTRY as $key=>$value) {
	echo '<option value="'.$key.'">'.$value.'</option>';
}
?></selected>
						</td>
						<td>&nbsp;<img name="cflag" src="new-hp/images/flags/00.gif"></td>
					</tr>
				  </table>
<script>
void(document.siteadmin.wcountry.value='<?php echo $SETTING['WEB_LOCATION']; ?>');
void(document.siteadmin.cflag.src = 'new-hp/images/flags/<?php echo $SETTING['WEB_LOCATION']; ?>.gif');
</script>				
				  </td>
			</tr>
			<tr>
			      <td align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Server Time Zone:<br>
			      </span></b></font>
			      </td>
			      <td align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td>
						<select name="wgmt" style="width: 250px;"> 
<?php
for($i=-12;$i<count($GMT)-12;$i++) {
	echo '<option value="'.$i.'">(GMT '.$GMT[$i][0].') '.$GMT[$i][1].'</option>';
}
?><script>void(document.siteadmin.wgmt.value='<?php echo $SETTING['WEB_GMT']; ?>')</script>
						</select>
						</td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=30% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Enable Modules:<br>
			      </span></b></font>
			      </td>
			      <td 70% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wmodules"><option value="1">Yes<option value="0">No</select></td>
					</tr>
				  </table>
<script>void(document.siteadmin.wmodules.value='<?php echo $SETTING['WEB_ENABLE_MODULES']; ?>')</script>
				  </td>
			</tr>
			</table>

			</td></tr></table>
			</td></tr></table>

			</center>
			<br>
		
		<div align=center><input type=image SRC="shared/wow-com/images/buttons/update-button.gif" name="Submit" alt="Continue" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

</form>

<?php
	} else {
	
		?>
			
			<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%" align=center>
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white">Website Main Page Layout:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>
			<center>
			<a name = "phone"></a>
			<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
	<form method=post action="index.php?n=admin.web&t=layout" name="siteadmin" onsubmit="aw_valid()">
	<input type=hidden name="update">
<script type="text/javascript">
function aw_valid() {
	void(document.siteadmin.update.value="web2");
	return true;	
}
</script>
			<table border=0 cellspacing=0 cellpadding=4 width = "100%">
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Default Template:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wdeftemp" OnChange="javascript:changelayout(this.value);">
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
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Show Flash:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wshowflash"><option value="1">Yes<option value="0">No</select></td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Flash URL:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><input type=text value="<?php echo $SETTING['WEB_FLASH_URL']; ?>" name="wflashurl" maxlength="255" size=35></td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Show News:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wshownews"><option value="1">Yes<option value="0">No</select></td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Show Contests:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wshowcontests"><option value="1">Yes<option value="0">No</select></td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Show Fan Art:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wshowfanart"><option value="1">Yes<option value="0">No</select></td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Show Wallpapers:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wshowwallpapers"><option value="1">Yes<option value="0">No</select></td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Show Community Spotlight:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wshowcommunity"><option value="1">Yes<option value="0">No</select></td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Show Support:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wshowsupport"><option value="1">Yes<option value="0">No</select></td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Show Jobs:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wshowjobs"><option value="1">Yes<option value="0">No</select></td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Show Miscellaneous:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wshowmisc"><option value="1">Yes<option value="0">No</select></td>
					</tr>
				  </table>
				  </td>
			</tr>
			<tr>
			      <td width=40% align=right>
			      <font face="arial,helvetica" size=-1><span><b>
			      Show Donations:<br>
			      </span></b></font>
			      </td>
			      <td 60% align=left>
				  <table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td><select name="wshowdonations"><option value="1">Yes<option value="0">No</select></td>
					</tr>
				  </table>
				  </td>
			</tr>
			</table>
			</td></tr></table>
			</td></tr></table>
			</center>
			<br>
		
		<div align=center><input type=image SRC="shared/wow-com/images/buttons/update-button.gif" name="Submit" alt="Continue" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>
<script>
	void(document.siteadmin.wshowflash.value='<?php echo $SETTING['WEB_SHOW_FLASH']; ?>');
	void(document.siteadmin.wshownews.value='<?php echo $SETTING['WEB_SHOW_NEWS']; ?>');
	void(document.siteadmin.wshowcontests.value='<?php echo $SETTING['WEB_SHOW_CONTESTS']; ?>');
	void(document.siteadmin.wshowfanart.value='<?php echo $SETTING['WEB_SHOW_FANART']; ?>');
	void(document.siteadmin.wshowwallpapers.value='<?php echo $SETTING['WEB_SHOW_WALLPAPERS']; ?>');
	void(document.siteadmin.wshowcommunity.value='<?php echo $SETTING['WEB_SHOW_COMMUNITY']; ?>');
	void(document.siteadmin.wshowsupport.value='<?php echo $SETTING['WEB_SHOW_SUPPORT']; ?>');
	void(document.siteadmin.wshowjobs.value='<?php echo $SETTING['WEB_SHOW_JOBS']; ?>');
	void(document.siteadmin.wshowmisc.value='<?php echo $SETTING['WEB_SHOW_MISC']; ?>');
	void(document.siteadmin.wshowdonations.value='<?php echo $SETTING['WEB_SHOW_DONATIONS']; ?>');
	void(document.siteadmin.wdeftemp.value='<?php echo $SETTING['WEB_DEF_TEMPLATE']; ?>');
</script>
</form>

<?php
	
	}
}

?>
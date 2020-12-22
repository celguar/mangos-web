<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

	$gal[0]='Screenshots';
	$gal[1]='Wallpapers';
	$gal[2]='Fan Art';

switch($_REQUEST['t']) {
	
	case "add": /////////////////////////////////////////////////ADD
		$forceshow=true;
		if ($_SERVER['REQUEST_METHOD']=='POST' AND $_FILES["filie"]["name"]!='') {
			$path='media/'.$_POST['galy'].'/';
			$maxsize=512000;
			$maxheight=800;
			$maxwidth=1024;
			$imgdim = getimagesize($_FILES["filie"]["tmp_name"]);
			if ($_FILES["filie"]["type"] != "image/jpeg" AND $_FILES["filie"]["type"] != "image/pjpeg") {
				errborder('Invalid File Type (Only JPEG allowed).');
			} else if ($_FILES["filie"]["size"] > $maxsize) {
				errborder('Invalid File Size (Max '.@round($maxsize/1024,0).'kb).');
			} else if ($imgdim[0] > $maxwidth OR $imgdim[1] > $maxheight) {
				errborder('Invalid File Dimensions (Max '.$maxwidth.'x'.$maxheight.').');
			} else if ($_FILES["filie"]["error"] > 0) {
				errborder($_FILES["filie"]["error"]);
			} else if (move_uploaded_file($_FILES["filie"]["tmp_name"], $path.$_SESSION['userid'].'_'.date('YmdHis').'.jpg')) {
				goodborder('Picture Successfuly Added.<META HTTP-EQUIV=REFRESH CONTENT="2; URL=?n=admin.gallery&t=manage">');
				unset($_FILES["filie"]["name"]);
				$forceshow=false;
			} else {
				errborder('Couldnt\'t upload the file.');
			}
		} else if ($_SERVER['REQUEST_METHOD']=='POST' AND $_POST['filie']=='') {
			errborder('All fields must be filled.');
		}
		if ($forceshow==true) {
			?>
		<form method=post action="index.php?n=admin.gallery&t=add" name="siteadmin" enctype="multipart/form-data">
			<input type=hidden name="update">
		<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
		<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white">Add Picture:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>
			<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
			<table border=0 cellspacing=0 cellpadding=4>
			<tr>
				  <td width=100 align=right>
				  <font face="arial,helvetica" size=-1><span><b>
				  Picture: </span></b></font> </td>
				  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
				  		<input name="filie" type=file taborder=1 />
				  </td><td valign = "top">
				   </td></tr></table></td>
			</tr>
			<tr>
				  <td width=100 align=right>
				  <font face="arial,helvetica" size=-1><span><b>
				  Gallery: </span></b></font> </td>
				  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
						<select name="galy">
							<option value="wallpapers">Wallpapers
							<option value="screenshots" SELECTED>Screenshots
							<option value="fanart">Fan Art
						</select>
				  </td><td valign = "top">
				   </td></tr></table></td>
			</tr>
			</table>
			</td></tr></table>
			</td></tr></table><br>
				<div align=center><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

		</form>
			<?php
		} 
	
	break;
	case "remove":
		if ($_REQUEST['id']!='' AND $_REQUEST['cat']!='') {
			$delfile="media/".str_replace(" ", "", strtolower($gal[$_REQUEST['cat']]))."/".$_REQUEST['id'].".jpg";
			if (@file_exists($delfile)) {
				if ($_POST['update']=='') {
					?>
		<form method=post action="index.php?n=admin.gallery&t=remove&cat=<?php echo $_REQUEST['cat']; ?>&id=<?php echo $_REQUEST['id']; ?>" name="siteadmin" onsubmit="fas_valid()">
		<script language="javascript">
		function fas_valid() {
			void(document.siteadmin.update.value="true");
			return true;
		}
		</script>
			<input type=hidden name="update">
		<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
		<table cellspacing = "0" cellpadding = "0" border = "0" width = "95%">
			<tr>
				<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
				<td width = "100%" bgcolor = "#05374A"><b class = "white">Remove Picture:</b></td>
				<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
			</tr>
			</table>
			<table width = 95% style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
			<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
			<table border=0 cellspacing=0 cellpadding=4>
			<tr>
				  <td width=120 align=right>
				  <font face="arial,helvetica" size=-1><span><b>
				  Gallery:</span></b></font> </td>
				  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
				  <?php echo $gal[$_REQUEST['cat']]; ?>
				  </td><td valign = "top">
				   </td></tr></table></td>
			</tr>
			<tr>
				  <td width=120 align=right>
				  <font face="arial,helvetica" size=-1><span><b>
				  Preview:</span></b></font> </td>
				  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
				  <a href="<?php echo $delfile; ?>" target="_blank"><img src="<?php echo $delfile; ?>" width="300" height="230"></a>
				  </td><td valign = "top">
				   </td></tr></table></td>
			</tr>
			</table>
			</td></tr></table>
			</td></tr></table><br>
				<div align=center><a href="index.php?n=admin.gallery&t=manage"><img SRC="shared/wow-com/images/buttons/button-back.gif"></a><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

		</form>
					<?
					break;
				} else if ($_POST['update']=='true') {
					if (unlink($delfile)) {
						goodborder('Picture Successfully Removed!'); echo '<br>';
					} else {
						$haserrors ='Couldn\'t Delete Picture!';
					}
				}
			} else {
				$haserrors = 'Picture do not exists!';
			}
		}
	case "manage":
	default:
	
	subtitle('Manage Gallery');
	?>

<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
	
	<div style='cursor: auto;' id='dataElement'>
		<span>
		<?php
		metalborderup();
		?>
					<table cellpadding='3' cellspacing='0' width=420>
						<tbody>
						<tr>
							<td class='rankingHeader' align='left' nowrap='nowrap' width=20%>Preview</td>
							<td class='rankingHeader' align='left' nowrap='nowrap' width=80%>Account</td>
							<td class='rankingHeader' align='left' nowrap='nowrap'>Slot</td>
							<td class='rankingHeader' align='left' nowrap='nowrap'>&nbsp;</td>
						</tr>
		<?php 
		for ($i=0;$i<3;$i++) {
			echo "
				<tr>
					<td colspan=6 class='rankingHeader' align='center' nowrap='nowrap' width=120>".$gal[$i]."</td>
				</tr>
				<tr>
					<td colspan='6' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
					</td>
				</tr>";
			$res_color=2;
			foreach(glob("media/".str_replace(" ", "", strtolower($gal[$i]))."/*.jpg") as $filename) {
				if($res_color==1) { $res_color=2; } else { $res_color=1; }
				$userd = explode('/', $filename);
				$userd = explode('_', $userd[2]);
				$userd[2] = explode('.', $userd[1]);
				
				$newquery = mysql_query("SELECT username, gmlevel, fa.displayname as fdn FROM account a LEFT JOIN forum_accounts fa ON a.id = fa.id_account WHERE a.id = '".$userd[0]."' GROUP BY a.id", $MySQL_CON) OR DIE (mysql_error());
				$rowa = mysql_fetch_array($newquery);
				
				echo "
					<tr>
						<td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);'><a href='".$filename."' target='_blank'><img src=".$filename." width=100 height=75></a></span></td>
						<td class='serverStatus".$res_color."' align='left'><span style='color: rgb(102, 13, 2);' onmouseover='ddrivetip(\"".$rowa['username']."\")' onmouseout='hideddrivetip()'>".$rowa['fdn']."&nbsp;<br>".$USER_LEVEL[$rowa['gmlevel']]."</span></td>
						<td class='serverStatus".$res_color."' align='center'><span style='color: rgb(102, 13, 2);'>".$userd[2][0]."&nbsp;</span></td>
						<td class='serverStatus".$res_color."' align='center'><a onmouseover='ddrivetip(\"Remove\")' onmouseout='hideddrivetip()' href='?n=admin.gallery&t=remove&cat=".$i."&id=".$userd[0].'_'.$userd[2][0]."'><img src='new-hp/images/v2/remove.gif'></a></td>
					</tr>";
			}
		}

		?>
						</tbody>
					</table>
		<?php
		metalborderdown();
		?>
		</span>
		</div>
	<?php
	
	break;

}

?>
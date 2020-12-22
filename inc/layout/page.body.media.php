<?php
function gallerymanage($title, $url, $path, $maxsize, $maxwidth, $maxheight, $maxslots) {
	
	$forceshow=true;
	
	if ($_REQUEST['t']=='remove') {
		if (isset($_SESSION['userid'])) {
			if ($_REQUEST['slot']!='' AND alphanum($_REQUEST['slot'],true,false)==true) {
				if ($_REQUEST['slot']<1 OR $_REQUEST['slot']>6) {
					errborder('Invalid Gallery Slot Selection.');
				} else if (@unlink($path.$_SESSION['userid'].'_'.$_REQUEST['slot'].'.jpg')) {
					goodborder($title.' Successfuly Removed.<META HTTP-EQUIV=REFRESH CONTENT="2; URL=?n='.$url.'">');
				} else if (file_exists($path.$_SESSION['userid'].'_'.$_REQUEST['slot'].'.jpg')) {
					errborder('Couldn\'t Remove the Fan Art.');
				}
			} else {
				errborder('Invalid Gallery Slot.');
			}
		} else {
			errborder($_LANG['ERROR']['NEED_LOGIN']);
		}
		$forceshow=false;
	} else if ($_REQUEST['t']=='add') {
		if (isset($_SESSION['userid'])) {
			if ($_REQUEST['slot']!='' AND alphanum($_REQUEST['slot'],true,false)==true) {
				if ($_REQUEST['slot']<1 OR $_REQUEST['slot']>6) {
					errborder('Invalid Gallery Slot.');
				} else {
					$forceshow=true;
					if ($_SERVER['REQUEST_METHOD']=='POST' AND $_FILES["filie"]["name"]!='') {
						$imgdim = getimagesize($_FILES["filie"]["tmp_name"]);
						if ($_FILES["filie"]["type"] != "image/jpeg" AND $_FILES["filie"]["type"] != "image/pjpeg") {
							errborder('Invalid File Type (Only JPEG allowed).');
						} else if ($_FILES["filie"]["size"] > $maxsize) {
							errborder('Invalid File Size (Max '.round($maxsize/1024,0).'kb).');
						} else if ($imgdim[0] > $maxwidth OR $imgdim[1] > $maxheight) {
							errborder('Invalid File Dimentions (Max '.$maxwidth.'x'.$maxheight.'kb).');
						} else  if ($_FILES["filie"]["error"] > 0) {
							errborder($_FILES["filie"]["error"]);
						} else if (move_uploaded_file($_FILES["filie"]["tmp_name"], $path.$_SESSION['userid'].'_'.$_REQUEST['slot'].'.jpg')) {
							goodborder('Screenshot Successfuly Added.<META HTTP-EQUIV=REFRESH CONTENT="2; URL=?n='.$url.'&p='.$_SESSION['userid'].'_'.$_REQUEST['slot'].'">');
							unset($_FILES["filie"]["name"]);
							$forceshow=false;
						} else {
							errborder('Couldnt\'t upload the file.');
						}
					} else if ($_SERVER['REQUEST_METHOD']=='POST' AND $_POST['filie']=='') {
						errborder('All fields must be filled.');
					}
					if ($forceshow==true) {
						?><br>
						<form method=post action="?n=<?php echo $url; ?>&t=add&slot=<?php echo $_REQUEST['slot']; ?>" name="media" enctype="multipart/form-data">
						<input type=hidden name="send" value="true">
								<table align=center width = 500 style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
								<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
								<table border=0 cellspacing=0 cellpadding=4 width=100%>
								<tr>
									  <td width=120 align=right>
									  <font face="arial,helvetica" size=-1><span><b>
									<span style="color: black;"><? echo $title; ?> Picture:
									  </span></b></font>
									  </td>
									  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="filie" type=file taborder=1 /></td><td valign = "top">

									   </td></tr></table></td>
								</tr>
								<tr>
									  <td align=center valign=top colspan=2>
										<br><a href="?n=<?php echo $url; ?>"><img src="shared/wow-com/images/buttons/button-back.gif" border=0></a><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Send" Width="174" Height="46" Border=0 class="button"  taborder=7 >
									   </td>
								</tr>
								</table>

								</td></tr></table>
								</td></tr></table><br>
								</form>
						<?php
					}
				}
			} else {
				errborder('Invalid Gallery Slot.');
			}
		} else {
			errborder($_LANG['ERROR']['NEED_LOGIN']);
		}
		$forceshow=false;
	}

	if ($forceshow==true) { ?>
	<table cellspacing = "0" cellpadding = "0" border = "0">
	<tr>
		<td colspan = "3">
		
			<table cellspacing = "0" cellpadding = "0" border = "0" background = "new-hp/images/ss-border-top-bg.gif" width = "100%">
			<tr>
				<td><img src = "new-hp/images/ss-border-top-left.gif" width = "113" height = "14"></td>
				<td align = "right"><img src = "new-hp/images/ss-border-top-right.gif" width = "113" height = "14"></td>
			</tr>

			</table>
		
		</td>
	</tr>
	<tr>
		<td background = "new-hp/images/ss-border-left.gif"><img src = "new-hp/images/pixel.gif" width = "21" height = "1"></td>
		<td <?php echo 'width = "'.$maxwidth.'" height="'.$maxheight.'"'; ?> align=center valign=middle>
		<?php $p = explode ('_', $_REQUEST['p']);
		$i=0;
		$tt=0;
		if ($p[0]!='' AND alphanum($p[0],true,false)==false OR $p[0]=='') { $p[0]=1; }
		if ($p[1]!='' AND alphanum($p[1],true,false)==false) { $p[1]=''; }
		foreach (glob($path.'{*.jpg,*.JPG}', GLOB_BRACE) as $tempname) {
			$tt++;
			if ($p[1]!='') {
				if ($stop!=true) { $i++; }
				if (strtolower($tempname)==strtolower($path.$p[0].'_'.$p[1].'.jpg')) { 
					$style= 'style="background: url('.$tempname.') no-repeat 50% 50%;"';
					$urla = $tempname;
					$stop=true; 
				}
			} else {
				if ($i < $p[0]) { $i++; }
				if ($tt==$p[0]) { $style= 'style="background: url('.$tempname.') no-repeat 50% 50%;"'; $urla = $tempname;}
			}
		}
		if ($i==0 AND $p[1]=='') { 
			errborder('No '.$title.' Pictures Avaliable.'); 
		} else if ($p[0]>$tt AND $p[1]=='') {
			echo '<script>window.location="?n='.$url.'&p='.$tt.'"</script>';
		} else {
			echo '<a href="'.$urla.'" target="_blank"><img '.$style.' src = "new-hp/images/pixel.gif" border = "0" width = "'.$maxwidth.'" height="'.$maxheight.'">';
		} ?>
			</td>
		<td background = "new-hp/images/ss-border-right.gif"><img src = "new-hp/images/pixel.gif" width = "21" height = "1"></td>
	</tr>
	<tr>
		<td colspan = "3">
		
			<table cellspacing = "0" cellpadding = "0" border = "0" background = "new-hp/images/ss-border-bot-bg.gif" width = "100%">

			<tr>
				<td valign = "top">
					<table cellspacing = "0" cellpadding = "0" border = "0" background = "new-hp/images/ss-border-bot-left.gif">
					<tr>
						<td rowspan = "3"><img src = "new-hp/images/pixel.gif" width = "40" height = "58" border = "0"></td>
						<td height = "17"><img src = "new-hp/images/pixel.gif" width = "148" height = "17" border = "0"></td>
					</tr>
					<tr>
						<td><span><a href = "?n=<?php echo $url; ?>&p=<?php if ($i-1<1) { echo $tt; } else { echo ($i-1); }; ?>">Previous Image</a></span></td>

					</tr>
					<tr>
						<td height = "11"><img src = "new-hp/images/pixel.gif" width = "58" height = "11" border = "0"></td>
					</tr>
					</table>
				</td>
				<td align = "center"><span><b class = "white"><br><br></b><b>Image <?php echo $i .' of '. $tt; ?></b></span></td>
				<td align = "right" valign = "top">

					
	<table cellspacing = "0" cellpadding = "0" border = "0" background = "new-hp/images/ss-border-bot-right.gif">
					<tr>
						<td height = 17><img src = "new-hp/images/pixel.gif" width = "148" height = "17" border = "0"></td>
						<td rowspan = "3"><img src = "new-hp/images/pixel.gif" width = "40" height = "58" border = "0"></td>
					</tr>
					<tr>
						<td align = "right"><span><a href = "?n=<?php echo $url; ?>&p=<?php if (($i+1)>$tt) { echo '1'; } else { echo ($i+1); }; ?>">Next Image</a></span></td>
					</tr>

					<tr>
						<td height = "11"><img src = "new-hp/images/pixel.gif" width = "58" height = "11" border = "0"></td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		
		</td>
	</tr>
	</table><br>
	<?php 
	}
	if (isset($_SESSION['userid'])) { ?>
	<br>
	<span style="font-size: 20px"><b>My <?php echo $title; ?> Gallery<b></span>
	<table cellpadding=10 cellspacing=10 border=0>
		<tr>	
				<?php for($i=1;$i<=$maxslots;$i++) { 
					echo '<td>';
						goldborderup(true);
							if (file_exists($path.$_SESSION['userid'].'_'.$i.'.jpg')) { 
								echo '<a href="?n='.$url.'&p='.$_SESSION['userid'].'_'.$i.'"><img border=0 src="'.$path.$_SESSION['userid'].'_'.$i.'.jpg" width=170 height=120></a>';
							} else {
								echo '<span style="">Empty</span>';
							}goldborderdown(true);
					echo '<table>
						<tr>
							<td align=center colspan=3 width=170><span style="font-family: arial; color: orange;">';
						if (!file_exists($path.$_SESSION['userid'].'_'.$i.'.jpg')) { echo '<a href="?n='.$url.'&t=add&slot='.$i.'">Add</a>'; }
						else { echo '<a href="?n='.$url.'&t=remove&slot='.$i.'">Remove</a>'; }
						echo '</span></td>
						</tr>
					</table>
					</td>';
					if (is_int($i/3)) { echo '</tr><tr>'; }
				} ?>
		</tr>
	</table>
	<?php
	}	
}
?>
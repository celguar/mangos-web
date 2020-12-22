<?php
function mainup() {
?>
													<div id="cntMain">
                                                      <div id="cnt-top">
                                                        <div>
                                                          <div></div>
                                                        </div>
                                                      </div>
	
                                                      <div id="content">
		
                                                        <div id="content-left">
			
                                                          <div id="content-right">
				
                                                            <div id="cnt-wrapper">    
<?php
}

function maindown() {
?>
													</div>
                                                      </div>
													   </div>
                                                      </div>
                                                      <div id="cnt-bot">
                                                        <div>
                                                          <div>&nbsp;</div>
                                                        </div>
                                                      </div>
													</div>
													<br>

<?php
}

function subtitle($tit, $sz='90%') {

?>
<table border='0' cellpadding='0' cellspacing='0' width='<?php echo $sz; ?>'>
<tbody><tr>
	<td width='24'><img src='shared/wow-com/images/headers/subheader/subheader-left-sword.gif' height='20' width='24'></td>
	<td bgcolor='#05374a' width='100%'><b class='white'><?php echo $tit; ?></b></td>
	<td width='10'><img src='shared/wow-com/images/headers/subheader/subheader-right.gif' height='20' width='10'></td>
</tr>
<tr>
	<td  height=10></td>
</tr>
</tbody></table>
<?php

}

function title($tit) {

?>
<table cellspacing =" 0" cellpadding =" 0" border =" 0" width ="710">
	<tr>
		<td width=10>&nbsp;</td>
		<td width =" 29"><img src ="shared/wow-com/images/headers/dateheader/dateheader-left.gif" width =" 31" height =" 38"></td>
		<td background ="shared/wow-com/images/headers/dateheader/dateheader-bg.gif"><h3 class =" titleLight"> <font color=white><?php echo $tit; ?></font> </h3></td>
		<td width =" 17"><img src ="shared/wow-com/images/headers/dateheader/dateheader-right.gif" width =" 17" height =" 38"></td>
		<td width=10>&nbsp;</td>
	</tr>
	<tr>
		<td  height=3></td>
	</tr>
</table>
<?php
}

function image($img) {

?>
<table cellspacing =" 0" cellpadding =" 0" border =" 0" width ="710">
				<tr>
						<td  width=10></td>
						<td background="shared/wow-com/images/headers/<?php echo $img; ?>bg.jpg" align=left>
							<img src="shared/wow-com/images/headers/<?php echo $img; ?>head.jpg">
						</td>
						<td  width=10></td>
				</tr>
				<tr>
						<td  height=10></td>
				</tr>
</table>
<?php
}

function parchup($lineup=false,$linedown=true,$par='light.jpg') {
?>
							<table cellspacing =" 0" cellpadding =" 0" border =" 0" width ="100%" style="
							<?php if ($lineup==true) { echo "border-top: 1px solid #666666;"; } if ($linedown==true) { echo "border-bottom: 1px solid #666666;"; } ?>
							" <?php if ($par!="") { echo "background='shared/wow-com/images/parchment/plain/".$par."'"; }?>>
							<tr>
								<td colspan =" 5"><img src ="new-hp/images/pixel.gif" width =" 1" height =" 12"></td>
							</tr>
							<tr>
							<tr>
							
								<td align=center>
<?php
}

function parchdown() { 
?><br>
								</td>
							</tr>
						</table>
						<table cellspacing =" 0" cellpadding =" 0" border =" 0" width ="100%">
							<tr >
								<td  height=5></td>
							</tr>
						</table>
<?php
}

function metalborderup() {
?>
<table border="0" cellpadding="0" cellspacing="0">
<tr height=12>
	<td background="shared/wow-com/images/borders/metalborder/metalborder-top-left.gif">
    </td>
	<td background="shared/wow-com/images/borders/metalborder/metalborder-top.gif">
	</td>
	<td background="shared/wow-com/images/borders/metalborder/metalborder-top-right.gif">
    </td>
</tr>
<tr>
	<td background="shared/wow-com/images/borders/metalborder/metalborder-left.gif" width=12>
	</td>
	<td>
<?php
}
function metalborderdown() {
?>
	</td>
	<td background="shared/wow-com/images/borders/metalborder/metalborder-right.gif" width=12>
</tr>
<tr height=11>
			<td background="shared/wow-com/images/borders/metalborder/metalborder-bot-left.gif">
            </td>
			<td background="shared/wow-com/images/borders/metalborder/metalborder-bot.gif">
			</td>
			<td background="shared/wow-com/images/borders/metalborder/metalborder-bot-right.gif">
            </td>
</tr>

</table>
<?php
}

function subnav($menuname) {

	?>
<!---Subnav----->
<script language = "javascript">
var pageId = "<?php echo $menuname; ?>";
</script>
<?php sitemap(); ?>
<script type="text/javascript" src="shared/wow-com/new-hp/js/menu132_com.js"></script>
<script type="text/javascript" src="shared/wow-com/includes-client/navtreefunctions.js"></script>
<style type="text/css">

.navigation
		{
		font-family:arial,palatino, georgia, verdana, arial, sans-serif;
		color:#000000;
		padding:5px;
		margin-bottom: 4px;
		}

.button
		{
		color:#FFFFFF;
		font-size:9px;
		letter-spacing:-1px;
		}

a.nav:link		{ 	
			font-family: arial,verdana, sans-serif;
			color: CBA300;
			font-size: 11px;
			font-weight:normal;
			}
			
a.nav:visited 	{
			font-family: arial,verdana, sans-serif;
			color: CBA300;
			font-size: 11px;
			font-weight:normal;
			}
			
a.nav:hover		{ 
			font-family: arial,verdana, sans-serif;
			color: FFFFFF;
			font-size: 11px;
			font-weight:normal;
			}
			
a.nav:active 	{ 
			font-family: arial,verdana, sans-serif;
			color: CBA300;
			font-size: 11px;
			font-weight:normal;
			}

</style>
<div class="navigation2">
<center>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "96%">
<tr>

<script language = "javascript">
	var iconId;
	if (result!=1)
		document.write('<td width="59" rowspan="3" valign = "top"><a href = "' + Menu2[1] + '"><img src = "shared/wow-com/images/subnav/icon_' + Menu2[0].toLowerCase() + '.jpg" width="59" height="65" border = "0"></a></td>');
	else 
		document.write('<td width="59" rowspan="3" valign = "top"><a href = "?"><img src = "shared/wow-com/images/subnav/icon_community.jpg" width="59" height="65" border = "0"></a></td>');
</script>

<td height="15" background="shared/wow-com/images/subnav/nav_top.jpg"></td>
<td width="18" height="65" rowspan="3" style="background-image:url(shared/wow-com/images/subnav/nav_right.jpg); background-position:top; background-repeat:no-repeat;"></td>
</tr>

<tr>
<td height="17" background="shared/wow-com/images/subnav/nav_middle.jpg" nowrap><div id = "filterMenu"></div></td>
</tr>

<tr>
<td>
	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td width="5" height="33" style="background-image:url(shared/wow-com/images/subnav/leftsubnav.jpg); background-position:top; background-repeat:repeat-x;"><img src="shared/wow-com/images/layout/pixel.gif" width="5" height="1"></td>

	<td height="33" background="shared/wow-com/images/subnav/subnav.jpg" width="100%">
		<table width="100%" height="33" cellpadding="0" cellspacing="0" border="0">
		<tr>
		<td width="5" height="5" background="shared/wow-com/images/subnav/subnav_topleft.gif"></td>
		<td height="5" background="shared/wow-com/images/subnav/subnav_top.gif"></td>
		<td width="6" height="5" background="shared/wow-com/images/subnav/subnav_topright.gif"></td>
		</tr> 
		<tr>
		<td width="5" height="19" background="shared/wow-com/images/subnav/subnav_left.gif"><img src = "shared/wow-com/images/layout/pixel.gif" width = "5"></td>

		<td height="19" style="text-align:center;" background="shared/wow-com/images/subnav/subnav_bg.gif" valign="middle"><img src="shared/wow-com/images/layout/pixel.gif" width="1" height="1"><small class="button" style="color:#808080; letter-spacing:normal;">
		
<script language = "javascript">

printSubNav2(result);

</script>
		
		
		</small></td>
		<td width="6" height="19" background="shared/wow-com/images/subnav/subnav_right.gif"><img src = "shared/wow-com/images/layout/pixel.gif" width = "6"></td>
		</tr>
		<tr>
		<td width="5" height="9" background="shared/wow-com/images/subnav/subnav_botleft.gif"></td>
		<td height="9" background="shared/wow-com/images/subnav/subnav_bot.gif"></td>

		<td width="6" height="9" background="shared/wow-com/images/subnav/subnav_botright.gif"></td>
		</tr>
		</table>
	</td>
	</tr>
	</table>
</td>
</tr>

</table>
</center>

</div>
<!---End Subnav----->
	<?php
}

function charavatar($charset='', $imageset='', $upname) {
?>
<?php  if ($imageset[0]=='nochar') { ?>
<style>
div.framenochar<? if ($imageset[1]!='') { echo 'blizz'; } ?> { 
	background: url('new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/no-character-icon<?php  if ($imageset[1]!='') { echo '-blizz'; }?>.gif');
}
</style>
<? } ?>
<div style="position: absolute; z-index: 2000002;"><a class="mine" href="javascript:document.<?php echo $upname[0]; ?>.avatar.value='<?php echo $upname[1]; ?>';javascript:document.<?php echo $upname[0]; ?>.update.value='charinfo';javascript:document.<?php echo $upname[0]; ?>.step.value='save';javascript:document.<?php echo $upname[0]; ?>.submit();" ><img src="new-hp/images/pixel.gif" width="185" height="118" border="0" alt="" /></a>
</div>
<table width=185 height=118 cellspacing="0" cellpadding="1" class="charselectborder" border="0" <? if ($upname[2]=='sel') { echo 'bgcolor=red'; } ?>>
	<tr>
		<td>
			<table width="100%" height=100% cellspacing="0" cellpadding="2" border="0" bgcolor="#252525">
				<tr>
					<td>
<!--[if IE]>
<style>
div.shell {
left: 10px;
}
</style>
<![endif]-->
			<div class="avatarselect">
				<div class="shell">

					<table cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td width="64" height="64" style="background: url('new-hp/images/forum/portraits/<?php 
							if ($imageset[0]=='') {
								if ($charset[1]=='70') { echo 'wow-70/'; }
								else if ($charset[1]>='60') { echo 'wow/'; }
								else { echo 'wow-default/'; }
								echo $charset[3].'-'.$charset[2].'-'.$charset[4].'.gif';
							} else if ($imageset[0]!='nochar') {
								echo $imageset[0];
							}
							?>');"</td>
						</tr>
					</table>
						<div class="frame<?php  if ($imageset[0]=='nochar') { echo 'nochar';  if ($imageset[1]!='') { echo 'blizz'; } } ?>"><img src="new-hp/images/pixel.gif" width= "82" height="83" border="0" alt=""></div></div>
						<div style="position: relative;"><div class="iconPosition"><b><small class="mine" ><?	
									if ($imageset[0]=='') { 
										echo $charset[1];
									} else if ($imageset[1]=='mvp') {
										echo '<img src="new-hp/images/pixel.gif" height=2><br><img src="new-hp/images/forum/icons/modr-small.gif">';
									} else if ($imageset[1]>0) {
										echo '<img src="new-hp/images/forum/blizz.gif">';
									}
				?></small></b></div>
				</div>

			</div>
				</td>
				<td><span class="mine"><a class="mine"  href='#'><?php echo $charset[0]; ?></a></span>
					<table cellspacing="2" cellpadding="0" border="0"><?php if ($imageset[0]=='') { ?>
						<tr><td><small  class="smallBold">Level:</small></td><td> <small class="mine" ><?php echo $charset[1]; ?></small></td></tr>
						<tr><td><small  class="smallBold">Race:</small></td><td> <small class="mine" ><?php echo $GLOBALS['CHAR_RACE'][$charset[2]][0]; ?></small></td></tr>

						<tr><td><small  class="smallBold">Class:</small></td><td> <small class="mine" ><?php echo $GLOBALS['CHAR_CLASS'][$charset[4]]; ?></small>
							</td>
						</tr>
						<?php } else if ($imageset[1]=='mvp') {?>
						<tr><td><small class="mine" ><?php echo 'Most Valuable Player'; ?></small>
						</td>
						<?php } else if ($imageset[1]>0) {?>
						<tr><td><small class="mine" ><?php $GLOBALS['USER_LEVEL'][4]='Owner'; echo $GLOBALS['USER_LEVEL'][$imageset[1]]; ?></small>
						</td><?php } ?>
						</tr>
					</table>
					
				</td>
			</tr>
			<tr>
			<td colspan="2">
			<?php if ($imageset[0]=='') { ?>
				<table cellspacing="3" cellpadding="0" border="0">
					<tr>
						<td><small  class="smallBold">Realm:</small></td>
						<td><small class="mine"><?php echo $charset[5]; ?></small></td>
					</tr>
				</table>
			<?php } ?>
			</td>
		</tr>

	</table>
		</td>
	</tr>
</table>	
<?php } 

function tabtitle($tit, $linedown=true, $par='light.jpg') {

?>
<table cellspacing =" 0" cellpadding =" 0" border =" 0" width ="100%" style="<? if ($linedown==true) { echo "border-bottom: 1px solid #666666;"; } ?>"
<?php if ($par!="") { echo "background='shared/wow-com/images/parchment/plain/".$par."'"; }?>>
	<tr style="background: url('shared/wow-com/images/parchment/plain/light2.jpg')">
		<td width="10"><img src="shared/wow-com/images/headers/tabheader/tabheader-left-left.jpg" border="0" height="29" width="17"></td>
		<td align="left" background="shared/wow-com/images/headers/tabheader/tabheader-left.jpg" nowrap="nowrap" width="362"><h3 class="guideTitle"><?php echo $tit; ?></h3></td>
		<td background="shared/wow-com/images/headers/tabheader/tabheader-bg.jpg" width="100%"></td>
		<td width="26"><img src="shared/wow-com/images/headers/tabheader/tabheader-right.jpg" border="0" height="29" width="26"></td>
		<td width="50"><img src="new-hp/images/pixel.gif" border="0" height="28" width="50" style="border-bottom: 1px solid #666666;"></td>
	</tr>
	<tr>
		<td align=center colspan=5>
<?

}
?>
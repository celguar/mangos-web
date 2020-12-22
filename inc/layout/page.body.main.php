<?php 
function errborder($er) {
?>
<center>
<table border="0" cellpadding="0" cellspacing="0" width="300"><tbody><tr><td width="3"><img src="new-hp/images/plainbox-red/plainbox-red-top-left.gif" border="0" height="3" width="3"></td><td background="new-hp/images/plainbox-red/plainbox-red-top.gif" width="100%"></td><td width="3"><img src="new-hp/images/plainbox-red/plainbox-red-top-right.gif" border="0" height="3" width="3"></td></tr><tr><td background="new-hp/images/plainbox-red/plainbox-red-left.gif"></td><td bgcolor="#db0101">
<table>
<tbody><tr>
	<td><img src="new-hp/images/icons/error.gif" height="57" width="59"></td>
	<td><span><font size=2><b class="white">An error has Occurred on this page</b></font></span><br>

<small style="color: rgb(0, 0, 0);">
<?php echo $er; ?>
</small>
	</td>
</tr>
</tbody></table>
</td><td background="new-hp/images/plainbox-red/plainbox-red-right.gif"></td></tr><tr><td><img src="new-hp/images/plainbox-red/plainbox-red-top-right.gif" border="0" height="3" width="3"></td><td background="new-hp/images/plainbox-red/plainbox-red-bot.gif"></td><td><img src="new-hp/images/plainbox-red/plainbox-red-top-left.gif" border="0" height="3" width="3"></td></tr></tbody></table>
</center>
<?php
}

function goodborder($er) {
?>
<center>
<table border="0" cellpadding="0" cellspacing="0" width="300"><tbody><tr><td width="3"><img src="new-hp/images/plainbox-red/plainbox-red-top-left.gif" border="0" height="3" width="3"></td><td background="new-hp/images/plainbox-red/plainbox-red-top.gif" width="100%"></td><td width="3"><img src="new-hp/images/plainbox-red/plainbox-red-top-right.gif" border="0" height="3" width="3"></td></tr><tr><td background="new-hp/images/plainbox-red/plainbox-red-left.gif"></td><td bgcolor="#009900">
<table>
<tbody><tr>
	<td><img src="new-hp/images/icons/success.gif" height="57" width="59"></td>
	<td><span><font size=2><b class="white">Success</b></font></span><br>

<small style="color: rgb(0, 0, 0);">
<?php echo $er; ?>
</small>
	</td>
</tr>
</tbody></table>
</td><td background="new-hp/images/plainbox-red/plainbox-red-right.gif"></td></tr><tr><td><img src="new-hp/images/plainbox-red/plainbox-red-top-right.gif" border="0" height="3" width="3"></td><td background="new-hp/images/plainbox-red/plainbox-red-bot.gif"></td><td><img src="new-hp/images/plainbox-red/plainbox-red-top-left.gif" border="0" height="3" width="3"></td></tr></tbody></table>
</center>
<?php
}

function goldborderup($red=false, $w=170, $h=120) {

?>
<table cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td <? if ($red==true) { ?> style="background-position: 0px -3px;" height=14 width=4 <?php } else { ?> height=17 width=9 <?php } ?> background="shared/wow-com/images/borders/greyandgold/greyandgold-top-left.gif"></td>
						<td <? if ($red==true) { ?> style="background-position: 50% -3px;" <?php } else { ?> height=17 <?php } ?> background="shared/wow-com/images/borders/greyandgold/greyandgold-top.gif"></td>
						<td <? if ($red==true) { ?> style="background-position: 100% -3px;" width=4 <?php } else { ?> width=9 <?php } ?> background="shared/wow-com/images/borders/greyandgold/greyandgold-top-right.gif"></td>
					</tr>
					<tr>
						<td background="shared/wow-com/images/borders/greyandgold/greyandgold-left.gif"></td>
						<td width=<? echo $w; ?> height=<? echo $h; ?> align=center valign=middle>
<?php
}
function goldborderdown($red=false) {

?>
</td>
			<td <? if ($red==true) { ?>style="background-position: -5px 0px;"<?php } ?> background="shared/wow-com/images/borders/greyandgold/greyandgold-right.gif"></td>
		</tr>
		<tr>
			<td <? if ($red==true) { ?> height=14 <?php } else { ?> height=17 <?php } ?> background="shared/wow-com/images/borders/greyandgold/greyandgold-bot-left.gif"></td>
			<td <? if ($red==true) { ?> style="background-position: 50% 0px;"<?php } ?> background="shared/wow-com/images/borders/greyandgold/greyandgold-bot.gif"></td>
			<td <? if ($red==true) { ?> style="background-position: 100% 0px;"<?php } ?> background="shared/wow-com/images/borders/greyandgold/greyandgold-bot-right.gif"></td>
</tr>
</table>
<?php
}

function sitemap() {

?>
<script language = "javascript">
	var linkClass="subMenuLink";//defines initial css class of the links
	var menuNumber=9;
	var agt=navigator.userAgent.toLowerCase(), appVer = navigator.appVersion.toLowerCase(), iePos  = appVer.indexOf('msie'), is_opera = (agt.indexOf("opera") != -1), is_ie   = ((iePos!=-1) && (!is_opera));
	if(is_ie){
		var menuBg="";
		var menuBgIndent="";
		var underLine="<img src=new-hp/images/menu/mainmenu/bullet-trans-line-blue.gif />";
		var bulletImg="<img src=new-hp/images/menu/mainmenu/bullet-trans-dot-blue.gif align=left />";
		var bulletImgIndent="<img src=new-hp/images/menu/mainmenu/bullet-trans-dot-indent.gif align=left />";
	}else{
		var menuBg="new-hp/images/menu/mainmenu/bullet-trans-bg-blue.gif";
		var menuBgIndent="new-hp/images/menu/mainmenu/bullet-trans-indent-bg.gif";
		var bulletImgIndent="<img src = new-hp/images/pixel.gif width=16 height=1 />";
		var underLine="";
		var bulletImg="";
	}
	var NoOffFirstLineMenus=1;			// Number of main menu  items
						// Colorvariables:
						// Color variables take HTML predefined color names or "#rrggbb" strings
						//For transparency make colors and border color ""
	var LowBgColor="#051B38";			// Background color when mouse is not over
	var HighBgColor="#013A88";			// Background color when mouse is over
	var FontLowColor="white";			// Font color when mouse is not over
	var FontHighColor="white";			// Font color when mouse is over
	var BorderColor="#116EED";			// Border color
	var BorderWidthMain=0;			// Border width main items
	var BorderWidthSub=1;			// Border width sub items
 	var BorderBtwnMain=0;			// Border width between elements main items
	var BorderBtwnSub=0;			// Border width between elements sub items
	var FontFamily="arial,comic sans ms,technical";	// Font family menu items
	var FontSize=11;				// Font size menu items
	var FontBold=0;				// Bold menu items 1 or 0
	var FontItalic=0;				// Italic menu items 1 or 0
	var MenuTextCentered="left";		// Item text position left, center or right
	var MenuCentered="left";			// Menu horizontal position can be: left, center, right
	var MenuVerticalCentered="top";		// Menu vertical position top, middle,bottom or static
	var ChildOverlap=.2;			// horizontal overlap child/ parent
	var ChildVerticalOverlap=.2;			// vertical overlap child/ parent
	var StartTop=-9;				// Menu offset x coordinate
	var StartLeft=0;				// Menu offset y coordinate
	var VerCorrect=0;				// Multiple frames y correction
	var HorCorrect=0;				// Multiple frames x correction
	var DistFrmFrameBrdr=0;			// Distance between main menu and frame border
	if(is_ie)
		var LeftPaddng=9;				// Left padding
	else
		var LeftPaddng=9;				// Left padding
	var TopPaddng=-1;				// Top padding. If set to -1 text is vertically centered
	var FirstLineHorizontal=1;			// Number defines to which level the menu must unfold horizontal; 0 is all vertical
	var MenuFramesVertical=1;			// Frames in cols or rows 1 or 0
	var DissapearDelay=500;			// delay before menu folds in
	var UnfoldDelay=0;			// delay before sub unfolds
	var UnfoldDelay2=200;			// delay before sub builds
	var TakeOverBgColor=1;			// Menu frame takes over background color subitem frame
	var FirstLineFrame="space";			// Frame where first level appears
	var SecLineFrame="space";			// Frame where sub levels appear
	var DocTargetFrame="space";		// Frame where target documents appear
	var TargetLoc="filterMenu";				// span id for relative positioning
	var MenuWrap=1;				// enables/ disables menu wrap 1 or 0
	var RightToLeft=0;				// enables/ disables right to left unfold 1 or 0
	var BottomUp=0;				// enables/ disables Bottom up unfold 1 or 0
	var UnfoldsOnClick=0;			// Level 1 unfolds onclick/ onmouseover
	var BaseHref="";				// BaseHref lets you specify the root directory for relative links. 
						// The script precedes your relative links with BaseHref
						// For instance: 
						// when your BaseHref= "http://www.MyDomain/" and a link in the menu is "subdir/MyFile.htm",
						// the script renders to: "http://www.MyDomain/subdir/MyFile.htm"
						// Can also be used when you use images in the textfields of the menu
						// "MenuX=new Array("<img src=\""+BaseHref+"MyImage\">"
						// For testing on your harddisk use syntax like: BaseHref="file:///C|/MyFiles/Homepage/"


	var Arrws=['shared/wow-com/images/subnav/tri.gif',14,15,'shared/wow-com/images/subnav/arrow_right2.gif',18,12,'shared/wow-com/images/subnav/arrow_right2.gif',5,10];	// Arrow source, width and height


						// Arrow source, width and height.
						// If arrow images are not needed keep source ""

	var MenuUsesFrames=0;			// MenuUsesFrames is only 0 when Main menu, submenus,
						// document targets and script are in the same frame.
						// In all other cases it must be 1

	var RememberStatus=0;			// RememberStatus: When set to 1, menu unfolds to the presetted menu item. 
						// When set to 2 only the relevant main item stays highligthed
						// The preset is done by setting a variable in the head section of the target document.
						// 2_2_1 represents the menu item Menu2_2_1=new Array(.......

	var OverFormElements=0;			// Set this to 0 when the menu does not need to cover form elements.
	var BuildOnDemand=1;			// 1/0 When set to 1 the sub menus are build when the parent is moused over
	var BgImgLeftOffset=5;			// Only relevant when bg image is used as rollover
	var ScaleMenu=0;				// 1/0 When set to 0 Menu scales with browser text size setting

	var HooverBold=0;				// 1 or 0
	var HooverItalic=0;				// 1 or 0
	var HooverUnderLine=0;			// 1 or 0
	var HooverTextSize=0;			// 0=off, number is font size difference on hoover
	var HooverVariant=0;			// 1 or 0

						// Below some pretty useless effects, since only IE6+ supports them
						// I provided 3 effects: MenuSlide, MenuShadow and MenuOpacity
						// If you don't need MenuSlide just leave in the line var MenuSlide="";
						// delete the other MenuSlide statements
						// In general leave the MenuSlide you need in and delete the others.
						// Above is also valid for MenuShadow and MenuOpacity
						// You can also use other effects by specifying another filter for MenuShadow and MenuOpacity.
						// You can add more filters by concanating the strings
	var MenuSlide="";

	var MenuShadow="";
	var MenuShadow="progid:DXImageTransform.Microsoft.DropShadow(color=#000000, offX=2, offY=2, positive=1)";
	var MenuShadow="progid:DXImageTransform.Microsoft.Shadow(color=#000000, direction=135, strength=3)";

	var MenuOpacity="";
	var MenuOpacity="progid:DXImageTransform.Microsoft.Alpha(opacity=90)";

	function BeforeStart(){return}
	function AfterBuild(){return}
	function BeforeFirstOpen(){return}
	function AfterCloseAll(){return}

Menu1=new Array("<?php echo $GLOBALS['SETTING']['WEB_SITE_NAME']; ?>","?","shared/wow-com/images/subnav/button_bg.gif",<?php if ($GLOBALS['SETTING']['FORUM_ENABLED']=='1') { echo '8'; } else { echo '7'; } ?>,15,110,"","","","","","",-1,-1,-1,"","");

	Menu1_1=new Array(bulletImg+"News"+underLine,"?",menuBg,3,15,110,"","","","","","",-1,-1,-1,"","");

		Menu1_1_1=new Array(bulletImg+"Current News"+underLine,"?",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");

		<?php
		$lvlu=verifylevel($_SESSION['userid']);
		$query = "SELECT DATE_FORMAT(`date`, '%Y-%m') as `date` FROM forum_posts fp
				INNER JOIN `forum_topics` ft ON (ft.id_topic = fp.id_topic)
				WHERE DATEDIFF(NOW(), fp.`date`) < 365 AND fp.isreply=0 AND ft.category=1 AND viewlevel <='".$lvlu."'
				GROUP BY fp.`id_post` 
				ORDER BY `date` ASC";
		$query = mysql_query($query) OR DIE (mysql_error());
		while ($row = mysql_fetch_array($query)) {
			if (stristr($strdate, $row['date'])==false) {
				$strdate .= $row['date'] . ',';
			}
		}
		$strdate = explode (',', $strdate);
		 ?>
		Menu1_1_2=new Array(bulletImg+"Archived News"+underLine,"?n=news.archive",menuBg,<?php echo count($strdate)-1; ?>,15,140,"","","","","","",-1,-1,-1,"","");

		<?php
			for ($i=0; $i<count($strdate)-1;$i++) {
				$strdate[$i]= explode ('-',$strdate[$i]);
				$ddate = date("F, Y", mktime(0, 0, 0, @intval($strdate[$i][1]), 1, $strdate[$i][0]));
				$ddate2 = date("Y-m", mktime(0, 0, 0, @intval($strdate[$i][1]), 1, $strdate[$i][0]));
				echo 'Menu1_1_2_'.($i+1).'=new Array(bulletImg+"'.$ddate.'"+underLine,"?n=news.archive&m='.$ddate2.'",menuBg,0,15,125,"","","","","","",-1,-1,-1,"","");';
			}
		?>
		Menu1_1_3=new Array(bulletImg+"RSS Feeds"+underLine,"inc/news/news.rss.xml",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		
	Menu1_2=new Array(bulletImg+"Account"+underLine,"?",menuBg,<? if (isset($_SESSION['userid'])) { $menutt=4; } else { $menutt=5; } echo $menutt;?>,15,110,"","","","","","",-1,-1,-1,"","");
	
		<?php if (isset($_SESSION['userid'])) {	?>
		Menu1_2_1=new Array(bulletImg+"Manage Account"+underLine,"?n=account.manage",menuBg,3,15,140,"","","","","","",-1,-1,-1,"",""); 
			Menu1_2_1_1=new Array(bulletImg+"Account Info"+underLine,"?n=account.manage&f=account",menuBg,0,15,135,"","","","","","",-1,-1,-1,"","");
			Menu1_2_1_2=new Array(bulletImg+"Contact & Forum Info"+underLine,"?n=account.manage&f=contact",menuBg,0,15,135,"","","","","","",-1,-1,-1,"","");
			Menu1_2_1_3=new Array(bulletImg+"Forum Avatar"+underLine,"?n=account.manage&f=character",menuBg,0,15,135,"","","","","","",-1,-1,-1,"","");
		Menu1_2_2=new Array(bulletImg+"Private Messages"+underLine,"?n=account.pm",menuBg,2,15,140,"","","","","","",-1,-1,-1,"",""); 
			Menu1_2_2_1=new Array(bulletImg+"Inbox (<?php echo mysql_num_rows(mysql_query("SELECT id_pm FROM forum_pm WHERE isread='0' AND id_account_to='".$_SESSION['userid']."'",$GLOBALS['MySQL_CON'])); ?> New)"+underLine,"?n=account.pm&f=inbox",menuBg,0,15,105,"","","","","","",-1,-1,-1,"",""); 
			Menu1_2_2_2=new Array(bulletImg+"Send"+underLine,"?n=account.pm&f=send",menuBg,0,15,105,"","","","","","",-1,-1,-1,"",""); 
		Menu1_2_3=new Array(bulletImg+"Log Out [<?php echo $_SESSION['nickname']; ?>]"+underLine,"?n=account.logout",menuBg,0,15,140,"","","","","","",-1,-1,-1,"",""); 
			
		<?php 
			} else {
		?>
		Menu1_2_1=new Array(bulletImg+"Create Account"+underLine,"?n=account.create",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		Menu1_2_2=new Array(bulletImg+"Activate Account"+underLine,"?n=account.activation",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		Menu1_2_3=new Array(bulletImg+"Log In"+underLine,"?n=account.login",menuBg,0,15,140,"","","","","","",-1,-1,-1,"",""); 
		Menu1_2_4=new Array(bulletImg+"Retrieve Account"+underLine,"?n=account.retrieve",menuBg,2,15,140,"","","","","","",-1,-1,-1,"","");
			Menu1_2_4_1=new Array(bulletImg+"Name"+underLine,"?n=account.retrieve&t=name",menuBg,0,15,85,"","","","","","",-1,-1,-1,"","");
			Menu1_2_4_2=new Array(bulletImg+"Password"+underLine,"?n=account.retrieve&t=password",menuBg,0,15,85,"","","","","","",-1,-1,-1,"",""); 
		<?php
			}

			$qquery = mysql_query("SELECT `id`, `name`, `address`, `port` FROM `realmlist` ORDER BY `name`", $GLOBALS['MySQL_CON']);
			$i=0;
			while ($rowx = mysql_fetch_array($qquery)) {
				if (check_port_status($rowx['address'], $rowx['port'], 0.3)) {
					$i++;
					$strmenu .= '	Menu1_2_'. $menutt .'_'.$i.'=new Array(bulletImg+"'.$rowx['name'].'"+underLine,"?n=account.realmstatus&t='.$rowx['id'].'",menuBg,0,15,150,"","","","","","",-1,-1,-1,"","");';
				}
			}

		?>
	
		Menu1_2_<?php echo $menutt; ?>=new Array(bulletImg+"Realm Status"+underLine,"?n=account.realmstatus",menuBg,<?php echo $i; ?>,15,140,"","","","","","",-1,-1,-1,"","");
		<?php echo $strmenu; ?>
	
	Menu1_3=new Array(bulletImg+"Game Guide"+underLine,"?",menuBg,3,15,110,"","","","","","",-1,-1,-1,"","");

		Menu1_3_1=new Array(bulletImg+"Introduction"+underLine,"?n=gameguide.introduction",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		Menu1_3_2=new Array(bulletImg+"Getting Started"+underLine,"?n=gameguide.gettingstarted",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		Menu1_3_3=new Array(bulletImg+"FAQ"+underLine,"?n=gameguide.faq",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		
	Menu1_4=new Array(bulletImg+"Workshop"+underLine,"?",menuBg,3,15,110,"","","","","","",-1,-1,-1,"","");
			
		<?php
		$qquery = mysql_query("SELECT `id`, `name`, rs.dbhost as rsdbhost, rs.dbport as rsdbport
					FROM `realmlist` r LEFT JOIN (realm_settings rs) ON r.id = rs.id_realm 
					GROUP BY r.id ORDER BY r.name",  $GLOBALS['MySQL_CON']) OR DIE(mysql_error());
		$i=0;
		while ($rowx = mysql_fetch_array($qquery)) {
			if (check_port_status($rowx['rsdbhost'], $rowx['rsdbport'], 0.3)) {
				$i++;
				$strmenu .= '	Menu1_4_1_'.$i.'=new Array(bulletImg+"'.$rowx['name'].'"+underLine,"?n=workshop.pvprankings&r='.$rowx['id'].'",menuBg,2,15,150,"","","","","","",-1,-1,-1,"","");
							Menu1_4_1_'.$i.'_1=new Array(bulletImg+"Alliance"+underLine,"?n=workshop.pvprankings&r='.$rowx['id'].'&f=alliance",menuBg,0,15,65,"","","","","","",-1,-1,-1,"","");
							Menu1_4_1_'.$i.'_2=new Array(bulletImg+"Horde"+underLine,"?n=workshop.pvprankings&r='.$rowx['id'].'&f=horde",menuBg,0,15,65,"","","","","","",-1,-1,-1,"","");';
			}
		}
		?>
		Menu1_4_1=new Array(bulletImg+"PvP Rankings"+underLine,"?n=workshop.pvprankings",menuBg,<?php echo $i; ?>,15,140,"","","","","","",-1,-1,-1,"","");
		<? echo $strmenu; ?>
		Menu1_4_2=new Array(bulletImg+"Events Calendar"+underLine,"?n=workshop.eventscalendar",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		Menu1_4_3=new Array(bulletImg+"World Map"+underLine,"?n=workshop.worldmap",menuBg,2,15,140,"","","","","","",-1,-1,-1,"","");
			Menu1_4_3_1=new Array(bulletImg+"Azeroth"+underLine,"?n=workshop.worldmap&m=azeroth",menuBg,0,15,65,"","","","","","",-1,-1,-1,"","");
			Menu1_4_3_2=new Array(bulletImg+"Outland"+underLine,"?n=workshop.worldmap&m=outland",menuBg,0,15,65,"","","","","","",-1,-1,-1,"","");
			
	Menu1_5=new Array(bulletImg+"Media"+underLine,"?",menuBg,3,15,110,"","","","","","",-1,-1,-1,"","");
	
		Menu1_5_1=new Array(bulletImg+"Screenshots"+underLine,"?n=media.screenshots ",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		Menu1_5_2=new Array(bulletImg+"Wallpapers"+underLine,"?n=media.wallpapers",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		Menu1_5_3=new Array(bulletImg+"Other Downloads"+underLine,"?n=media.otherdownloads",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
	
	<?php $menui=6; 
		if ($GLOBALS['SETTING']['FORUM_ENABLED']=='1') { 
			$menui++; ?>
	
	Menu1_6=new Array(bulletImg+"Forums"+underLine,"?n=forums",menuBg,<?php echo mysql_num_rows(mysql_query("SELECT id_forum FROM `forums` WHERE viewlevel<=".$lvlu." GROUP BY `group`",  $GLOBALS['MySQL_CON'])); ?>,15,110,"","","","","","",-1,-1,-1,"","");
	
		<?php

		$qquery = mysql_query("SELECT `group` FROM `forums` WHERE viewlevel<=".$lvlu." GROUP BY `group` ORDER BY `group` ASC", $GLOBALS['MySQL_CON']);
		$i=1;
		while ($rowx = mysql_fetch_array($qquery)) {
			$j=1;
				$qqueryb = mysql_query("SELECT `id_forum`, title FROM `forums` WHERE viewlevel<=".$lvlu." AND `group`='".$rowx['group']."' ORDER BY `id_forum` ASC", $GLOBALS['MySQL_CON']);
				echo '
				Menu1_6_'.$i.'=new Array(bulletImg+"'.$GLOBALS['FORUM_GROUP'][$rowx['group']].'"+underLine,"?n=forums",menuBg,'.mysql_num_rows($qqueryb).',15,140,"","","","","","",-1,-1,-1,"","");';
				while ($rowc = mysql_fetch_array($qqueryb)) {
					echo '
					Menu1_6_'.$i.'_'.$j.'=new Array(bulletImg+"'.$rowc['title'].'"+underLine,"?n=forums&f='.$rowc['id_forum'].'",menuBg,0,15,150,"","","","","","",-1,-1,-1,"","");';
					$j++;
				}
			$i++;
		}
		?>
	<?php } ?>
	Menu1_<?php echo $menui; ?>=new Array(bulletImg+"Community"+underLine,"?",menuBg,4,15,110,"","","","","","",-1,-1,-1,"","");
		<?php
		$query = "SELECT DATE_FORMAT(`date`, '%Y-%m') as `date` FROM forum_posts fp
				INNER JOIN `forum_topics` ft ON (ft.id_topic = fp.id_topic)
				WHERE DATEDIFF(NOW(), fp.`date`) < 365 AND fp.isreply=0 AND ft.category=2 AND viewlevel <='".$lvlu."'
				GROUP BY fp.`id_post` 
				ORDER BY `date` ASC";
		$query = mysql_query($query, $GLOBALS['MySQL_CON']);
		$strdate='';
		while ($row = mysql_fetch_array($query)) {
			if (stristr($strdate, $row['date'])==false) {
				$strdate .= $row['date'] . ',';
			}
		}
		$strdate = explode (',', $strdate);
		 ?>
		Menu1_<?php echo $menui; ?>_1=new Array(bulletImg+"Spotlight"+underLine,"?n=community.spotlight",menuBg,<?php echo count($strdate)-1; ?>,15,140,"","","","","","",-1,-1,-1,"","");
		<?php
			for ($i=0; $i<count($strdate)-1;$i++) {
				$strdate[$i]= explode ('-',$strdate[$i]);
				$ddate = date("F, Y", mktime(0, 0, 0, @intval($strdate[$i][1]), 1, $strdate[$i][0]));
				$ddate2 = date("Y-m", mktime(0, 0, 0, @intval($strdate[$i][1]), 1, $strdate[$i][0]));
				echo 'Menu1_'.$menui.'_1_'.($i+1).'=new Array(bulletImg+"'.$ddate.'"+underLine,"?n=community.spotlight&m='.$ddate2.'",menuBg,0,15,125,"","","","","","",-1,-1,-1,"","");';
			}
		?>
		Menu1_<?php echo $menui; ?>_2=new Array(bulletImg+"Users On-Line (<?php echo mysql_num_rows(mysql_query("SELECT id FROM web_online", $GLOBALS['MySQL_CON']));?>)"+underLine,"?n=community.online",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		Menu1_<?php echo $menui; ?>_3=new Array(bulletImg+"Contests"+underLine,"?n=community.contests",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		Menu1_<?php echo $menui; ?>_4=new Array(bulletImg+"Fan Art"+underLine,"?n=community.fanart",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");

	Menu1_<?php echo ($menui+1); ?>=new Array(bulletImg+"Support"+underLine,"?",menuBg,<?php if ($lvlu>0) { echo '5'; } else { echo '4'; } ?>,15,110,"","","","","","",-1,-1,-1,"","");
	<?php if ($lvlu>0) {
		$nextmen=2;?>
		Menu1_<?php echo ($menui+1); ?>_1=new Array(bulletImg+"Site Administration"+underLine,"?n=admin",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
	<?php } else { 
		$nextmen=1;?>
	<?php } ?>
		Menu1_<?php echo ($menui+1); ?>_<? echo $nextmen; ?>=new Array(bulletImg+"Staff Personel"+underLine,"?n=support.staff",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		<?php
			$qquery = mysql_query("SELECT `id`, `name`, `address`, `port`, rs.dbhost as rsdbhost, rs.dbport as rsdbport
				FROM `realmlist` r LEFT JOIN (realm_settings rs) ON r.id = rs.id_realm 
				GROUP BY r.id ORDER BY r.name", $GLOBALS['MySQL_CON']);
			$i=0;
			$strmenu='';
			while ($rowx = mysql_fetch_array($qquery)) {
				if (check_port_status($rowx['rsdbhost'], $rowx['rsdbport'], 0.3)) {
					$i++;
					$strmenu .= 'Menu1_'.($menui+1).'_'.($nextmen+1).'_'.$i.'=new Array(bulletImg+"'.$rowx['name'].'"+underLine,"?n=support.ingame&r='.$rowx['id'].'",menuBg,2,15,150,"","","","","","",-1,-1,-1,"","");
					';
					$strmenu .= 'Menu1_'.($menui+1).'_'.($nextmen+1).'_'.$i.'_1=new Array(bulletImg+"Commands"+underLine,"?n=support.ingame&r='.$rowx['id'].'&t=commands",menuBg,0,15,125,"","","","","","",-1,-1,-1,"","");
					';
					$strmenu .= 'Menu1_'.($menui+1).'_'.($nextmen+1).'_'.$i.'_2=new Array(bulletImg+"Tickets"+underLine,"?n=support.ingame&r='.$rowx['id'].'&t=tickets",menuBg,0,15,125,"","","","","","",-1,-1,-1,"","");
					';
				}
			}
		?>
		Menu1_<?php echo ($menui+1); ?>_<? echo ($nextmen+1); ?>=new Array(bulletImg+"In-Game Support"+underLine,"?n=support.ingame",menuBg,<?php echo $i; ?>,15,140,"","","","","","",-1,-1,-1,"","");
		<?php echo $strmenu; ?>
		Menu1_<?php echo ($menui+1); ?>_<? echo ($nextmen+2); ?>=new Array(bulletImg+"Donations"+underLine,"?n=support.donations",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
		Menu1_<?php echo ($menui+1); ?>_<? echo ($nextmen+3); ?>=new Array(bulletImg+"Rules"+underLine,"?n=support.rules",menuBg,0,15,140,"","","","","","",-1,-1,-1,"","");
</script>
<?php
}

function topnav() {

	?>
	<link rel="stylesheet"  type="text/css" href="new-hp/css/topnav.css">
	<div class="tn_wow" id="shared_topnav" style="position: inherit; height: 25px;">
		<div class="topnav">
			<div class="tn_interior">
			<?php if ($GLOBALS['FULL_LAYOUT']==true) { ?>
			<a href="?"><?php echo $GLOBALS['SETTING']['WEB_SITE_NAME']; ?></a>
				<img src="shared/wow-com/images/topnav/topnav_div.gif">
			<a href="?n=armory">The Armory</a>
				<img src="shared/wow-com/images/topnav/topnav_div.gif">
			<a href="?n=forums"><img src="new-hp/images/pixel.gif" style="position: absolute; width: 15px; height: 15px; border: 0;" id="topnaveforums">Forums</a>
			<?php } else { ?>
			<a href="#" style="color: white;">&nbsp;<!--Install</a>
				<img src="shared/wow-com/images/topnav/topnav_div.gif">
			<a href="#" style="color: white;"> Step 1 </a>
				<img src="shared/wow-com/images/topnav/topnav_div.gif">
			<a href="#" style="color: white;"> Step 2 --></a>
			<?php } ?>
			</div>
		</div>
	</div>

	<?

}
?>
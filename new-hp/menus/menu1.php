<?php 
define('INCLUDED', true);
require ('../../inc/conf/conf.database.php');
require ('../../inc/conf/conf.functions.php');
?>
<html>
<head></head>
<body>
	<script type='text/javascript'>function Go(){return}</script>
	<script type='text/javascript'>
	var linkClass="menuLink";//initial css style of links
	var menuNumber=1;
	var agt=navigator.userAgent.toLowerCase(), appVer = navigator.appVersion.toLowerCase(), iePos  = appVer.indexOf('msie'), is_opera = (agt.indexOf("opera") != -1), is_ie   = ((iePos!=-1) && (!is_opera));
	if(is_ie){
		var menuBg="";
		var menuBgIndent="";
		var underLine="<img src='new-hp/images/menu/mainmenu/bullet-trans-line.gif'/>";
		var bulletImg="<img src='new-hp/images/menu/mainmenu/bullet-trans-dot.gif' align='left'/>";
		var bulletImgIndent="<img src='new-hp/images/menu/mainmenu/bullet-trans-dot-indent.gif' align='left'/>";
	}else{
		var menuBg="new-hp/images/menu/mainmenu/bullet-trans-bg.gif";
		var menuBgIndent="new-hp/images/menu/mainmenu/bullet-trans-indent-bg.gif";
		var bulletImgIndent="<img src =new-hp/images/pixel.gif width=16 height=1/>";
		var underLine="";
		var bulletImg="";
	}
	var NoOffFirstLineMenus=3;			// Number of main menu  items
						// Colorvariables:
						// Color variables take HTML predefined color names or "#rrggbb" strings
						//For transparency make colors and border color ""
	var LowBgColor="black";			// Background color when mouse is not over
	var HighBgColor="#0B2237";			// Background color when mouse is over
	var FontLowColor="#F4C400";			// Font color when mouse is not over
	var FontHighColor="white";			// Font color when mouse is over
	var BorderColor="#A5A5A5";			// Border color
	var BorderWidthMain=0;			// Border width main items
	var BorderWidthSub=1;			// Border width sub items
 	var BorderBtwnMain=0;			// Border width between elements main items
	var BorderBtwnSub=0;			// Border width between elements sub items
	var FontFamily="arial,comic sans ms,technical";	// Font family menu items
	var FontSize=11;				// Font size menu items
	var FontBold=1;				// Bold menu items 1 or 0
	var FontItalic=0;				// Italic menu items 1 or 0
	var MenuTextCentered="left";		// Item text position left, center or right
	var MenuCentered="left";			// Menu horizontal position can be: left, center, right
	var MenuVerticalCentered="top";		// Menu vertical position top, middle,bottom or static
	var ChildOverlap=.2;			// horizontal overlap child/ parent
	var ChildVerticalOverlap=.2;			// vertical overlap child/ parent
	var StartTop=33;				// Menu offset x coordinate
	var StartLeft=17;				// Menu offset y coordinate
	
	if(!is_ie)StartLeft=6;

	var VerCorrect=0;				// Multiple frames y correction
	var HorCorrect=0;				// Multiple frames x correction
	var DistFrmFrameBrdr=0;			// Distance between main menu and frame border
	if(is_ie)
		var LeftPaddng=0;				// Left padding
	else
		var LeftPaddng=10;				// Left padding
	var TopPaddng=-1;				// Top padding. If set to -1 text is vertically centered
	var FirstLineHorizontal=0;			// Number defines to which level the menu must unfold horizontal; 0 is all vertical
	var MenuFramesVertical=1;			// Frames in cols or rows 1 or 0
	var DissapearDelay=500;			// delay before menu folds in
	var UnfoldDelay=0;			// delay before sub unfolds
	var UnfoldDelay2=100;			// delay before sub builds
	var TakeOverBgColor=1;			// Menu frame takes over background color subitem frame
	var FirstLineFrame="space";			// Frame where first level appears
	var SecLineFrame="space";			// Frame where sub levels appear
	var DocTargetFrame="space";		// Frame where target documents appear
	var TargetLoc="menuNews";				// span id for relative positioning
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
						// "MenuX=new Array(bulletImg+"<img src=\""+BaseHref+"MyImage\">"
						// For testing on your harddisk use syntax like: BaseHref="file:///C|/MyFiles/Homepage/"

	var Arrws=["shared/wow-com/images/subnav/tri.gif",14,15,"shared/wow-com/images/subnav/tri.gif",14,15,"shared/wow-com/images/subnav/tri.gif",14,15,"shared/wow-com/images/subnav/tri.gif",14,15];

						// Arrow source, width and height.
						// If arrow images are not needed keep source ""

	var MenuUsesFrames=1;			// MenuUsesFrames is only 0 when Main menu, submenus,
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
	var MenuOpacity="progid:DXImageTransform.Microsoft.Alpha(opacity=85)";

	function BeforeStart(){return}
	function AfterBuild(){parent.clearFiller(menuNumber);return}
	function BeforeFirstOpen(){return}
	function AfterCloseAll(){return}

// Menu tree:
// MenuX=new Array(bulletImg+"ItemText","Link","background image",number of sub elements,height,width,"bgcolor","bghighcolor",
//	"fontcolor","fonthighcolor","bordercolor","fontfamily",fontsize,fontbold,fontitalic,"textalign","statustext");
// Color and font variables defined in the menu tree take precedence over the global variables
// Fontsize, fontbold and fontitalic are ignored when set to -1.
// For rollover images ItemText or background image format is:  "rollover?"+BaseHref+"Image1.jpg?"+BaseHref+"Image2.jpg" 
Menu1=new Array(bulletImg+"Current News"+underLine,"?",menuBg,0,15,140,"transparent","","","","transparent","",-1,-1,-1,"","");

<?php
$query = "SELECT DATE_FORMAT(`date`, '%Y-%m') as `date` FROM forum_posts fp
		INNER JOIN `forum_topics` ft ON (ft.id_topic = fp.id_topic)
		WHERE DATEDIFF(NOW(), fp.`date`) < 365 AND fp.isreply=0 AND ft.category=1 AND viewlevel <='".verifylevel($_SESSION['userid'])."'
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
Menu2=new Array(bulletImg+"Archived News"+underLine,"?n=news.archive",menuBg,<?php echo count($strdate)-1; ?>,15,140,"transparent","","","","transparent","",-1,-1,-1,"","");

<?php
	for ($i=0; $i<count($strdate)-1;$i++) {
		$strdate[$i]= explode ('-',$strdate[$i]);
		$ddate = date("F, Y", mktime(0, 0, 0, @intval($strdate[$i][1]), 1, $strdate[$i][0]));
		$ddate2 = date("Y-m", mktime(0, 0, 0, @intval($strdate[$i][1]), 1, $strdate[$i][0]));
		echo 'Menu2_'.($i+1).'=new Array(bulletImg+"'.$ddate.'"+underLine,"?n=news.archive&m='.$ddate2.'",menuBg,0,15,125,"","","","","","",-1,-1,-1,"","");';
	}
?>
Menu3=new Array(bulletImg+"RSS Feeds"+underLine,"inc/news/news.rss.xml",menuBg,0,15,140,"transparent","","","","transparent","",-1,-1,-1,"","");
	</script>
	<script type='text/javascript' src='../js/menu132_com.js'></script>
<noscript>Your browser does not support script</noscript>
</body>
</html>
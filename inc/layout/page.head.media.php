<?php
if (INCLUDED!==true) { include('index.htm'); exit; }
?>

<html>
<head>
	<link REL="SHORTCUT ICON" HREF="new-hp/images/favicon.ico">
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title><?php echo $SETTING['WEB_SITE_NAME']; ?></title>
	<style type = "text/css" id = "bnetstyle">
	
		BODY	  {  BACKGROUND-COLOR: #000000;BACKGROUND-REPEAT: repeat-x; }
		
	</style>
	
<style type = "text/css">
		
		BODY	  { margin: 0px; }
		
		A:link    { color: #FFB019; font-weight: bold; }
		A:active  { color: #FFB019; font-weight: bold; }
		A:visited { color: #B1B1B1; font-weight: bold; }
		A:hover   { color: white;   font-weight: bold; }

		span.grey { font-family: Arial,Helvetica,Sans-Serif; color: #A0A1A3; font-size: 9pt; }
		span	  { font-family: Arial,Helvetica,Sans-Serif; color: #CCCCCC; font-size: 9pt; }
		span.lite { font-family: Arial,Helvetica,Sans-Serif; color: #F0E7BE; font-size: 9pt; }
		
		small	  { font-family: Arial,Helvetica,Sans-Serif; color: #D7CEA4; font-size: 8pt; }
		small.gold{ font-family: Arial,Helvetica,Sans-Serif; color: #C4C4C4; font-size: 8pt; }
		
		B		  { color: #E2D9B0; font-weight: bold; }
		B.white   { color: #ffffff; font-weight: bold; }
		span.red  { color: red; }
		
		#header        { COLOR: white; FONT-WEIGHT: bold; FONT-VARIANT: small-caps; TEXT-DECORATION: none; LETTER-SPACING: 4px;}
	
		span.blue		{ font-family: Arial,Helvetica,Sans-Serif; color:#00C0FF; font-size: 10pt; }
		span.mvp		{ font-family: Arial,Helvetica,Sans-Serif; color:#A7BFD8; font-size: 10pt; }	
		input.button 	{ background-color: transparent; border-style: none; }
	
	</style>
	
	
</head>
	
<body background='new-hp/images/page-bg.jpg' bgcolor=black>

<MAP NAME="blizzlogo_Map">
<AREA SHAPE="rect" HREF="http://www.blizzard.com" ALT="Blizzard Entertainment" COORDS="6,49,74,84">
</MAP>
<MAP NAME="wowlogo_Map">
<AREA SHAPE="poly" HREF="?" ALT="World of Warcraft" COORDS="145,77, 162,52, 167,49, 170,41, 177,34, 204,34, 212,19, 208,15, 209,11, 275,11, 289,6, 305,6, 320,12, 383,12, 376,19, 385,31, 386,36, 403,33, 413,35, 415,40, 421,42, 422,49, 435,60, 442,78, 432,103, 418,112, 168,112, 158,102">
</MAP>

<a name = "top"></a>
<!---headers/links--->

<div style = "position: absolute; width: 100%; top: 0px;">

<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
<tr>

	<td colspan = "3"><img src = "new-hp/images/pixel.gif" width = "1" height = "8"></td>

</tr>
<tr>
	<td><img src = "new-hp/images/pixel.gif" width = "240" height = "1"></td>
	<td align = "center"><a href = "?"><img src = "new-hp/images/wowlogo2.gif" width = "262" height = "108" border = "0"></a></td>

	<td><img src = "new-hp/images/pixel.gif" width = "247" height = "1"></td>
</tr>
</table>

</div>


<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
<tr>
	<td background = "new-hp/images/gold-bg.gif">
	
		<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
		<tr>
			<td background = "new-hp/images/topbg-left.gif">

			
				<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
				<tr>
					<td width = "68"><img src = "new-hp/images/gryph-left.gif" width = "68" height = "80"></td>
					<td align = "right" valign = "bottom"><img src = "new-hp/images/wowlogo-left.gif" width = "291" height = "65"></td>

				</tr>
				</table>			
			
			</td>
			<td background = "new-hp/images/topbg-right.gif">
			
				<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">

				<tr>
					<td align = "left" valign = "bottom"><img src = "new-hp/images/wowlogo-right.gif" width = "291" height = "65"></td>
					<td width = "68"><img src = "new-hp/images/gryph-right.gif" width = "68" height = "80"></td>
				</tr>
				</table>			
			
			</td>
		</tr>
		</table>
	
	</td>

</tr>
</table>
<center>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
<tr>
	<td>
		<table  cellspacing = "0" cellpadding = "0" border = "0" width = "100%" background = "new-hp/images/gold-border.gif">
		<tr>
			<td><img src = "new-hp/images/left-finger.gif" width = "97" height = "19"></td>
			<td align = "right"><img src = "new-hp/images/right-finger.gif" width = "97" height = "19"></td>
		</tr>
		</table>


		<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%" background = "new-hp/images/linksbar-bg.gif">
			<tr>
				<td width = "88" valign = "top"><img src = "new-hp/images/linksbar-left.gif" width = "106" height = "53"></td>
				<td width = "100%" align = "center">
			
				<table cellspacing = "0" cellpadding = "0" border = "0" width = "600">
				<tr>
					<td colspan = "3"><img src = "new-hp/images/pixel.gif" width = "600" height = "16"></td>
				</tr>
				<tr>
					<td><img src = "new-hp/images/pixel.gif" width = "1" height = "37"></td>

					<td align = "center" valign = "top"><?php sitemap(); ?></td>

				
					

					<td><img src = "new-hp/images/pixel.gif" width = "1" height = "37"></td>
				</tr>
				</table>
			
			</td>
			<td width = "88" valign = "top"><img src = "new-hp/images/linksbar-right.gif" width = "106" height = "53"></td>
		</tr>
		</table>

	</td>

</tr>
</table>

<center>
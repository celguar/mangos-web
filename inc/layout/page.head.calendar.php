


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>WoW &gt; Info &gt; Events &gt; Calendar</title>


<style type="text/css">

		BODY	  {  BACKGROUND-COLOR: #000000; BACKGROUND-IMAGE: url('/shared/screenshots/backgrounds/tirisfal-bg.jpg'); BACKGROUND-REPEAT: repeat-x; }

	td.featured		{ color: #ffea00; font-family: tahoma; font-size: 13pt; padding-left: 8px;}
	td.featuredimage{ padding-left: 2px;}
	td.featureddate	{ color: #ffffff; font-family: tahoma; font-size: 9pt; align: right; padding-right: 3px; text-align: right;}
	
	td.monthly		{ color: #feb300; font-family: tahoma; font-size: 10pt; font-weight: bold; padding-left: 8px;}
	td.monthlyimage{ padding-left: 15px;}
	
		A:link    { color: #FFB019; font-weight: bold; font-family: arial; font-size: 10pt;}
		A:active  { color: #FFB019; font-weight: bold; font-family: arial; font-size: 10pt; }
		A:visited { color: #B1B1B1; font-weight: bold; font-family: arial; font-size: 10pt; }
		A:hover   { color: white;   font-weight: bold; font-family: arial; font-size: 10pt; }	
	

		A.linkFeatured:link    { color: #ffea00; font-weight: normal; text-decoration: none; font-family: tahoma; font-size: 13pt;}
		A.linkFeatured:active  { color: #ffea00; font-weight: normal; text-decoration: none; font-family: tahoma; font-size: 13pt;}
		A.linkFeatured:visited { color: #ffea00; font-weight: normal; text-decoration: none; font-family: tahoma; font-size: 13pt;}
		A.linkFeatured:hover   { color: #ffffff; font-weight: normal; text-decoration: underline; font-family: tahoma; font-size: 13pt;}	
	
		A.linkMonthly:link    { color: #feb300; font-weight: bold; text-decoration: none; font-family: tahoma; font-size: 10pt;}
		A.linkMonhtly:active  { color: #feb300; font-weight: bold; text-decoration: none; font-family: tahoma; font-size: 10pt;}
		A.linkMonthly:visited { color: #feb300; font-weight: bold; text-decoration: none; font-family: tahoma; font-size: 10pt;}
		A.linkMonthly:hover   { color: #ffffff; font-weight: bold; text-decoration: underline; font-family: tahoma; font-size: 10pt;}	
	
		small	  { font-family: Arial,Helvetica,Sans-Serif; color: #D7CEA4; font-size: 8pt; }	
	
hr {
  border: 0;
  width: 98%;
  color: #292929;
background-color: #292929;
height: 1px;
}
		span.grey { font-family: Arial,Helvetica,Sans-Serif; color: #A0A1A3; font-size: 9pt; }
.main {
width:181px;
}


.daysofweek {
background-color: #0e0e0e;
font: 12px verdana;
color:white;
padding: 5px;
border-top: 1px solid black;
border-bottom: 1px solid black;
}

.days {
font-size: 12px;
font-family:tahoma;
color: #efefef;
background-color: #121a21;
padding: 2px;
}

.days #today{
color: #ffffff;
background-color: #253e5a;
border: 1px solid #feb300;
padding: 1;
}
	
</style>

<script language = "javascript" src = "/shared/wow-com/includes-client/screenshot.js"></script>

<script language = "javascript">
//uncomment below to set a different abolute path; ex: /path/path/
//path = "";
var theDirectory = "images/";
var screenshotsTotal = 1;
</script>

<script language = javascript>

/***********************************************
* Basic Calendar-By Brian Gosselin at http://scriptasylum.com/bgaudiodr/
* Script featured on Dynamic Drive (http://www.dynamicdrive.com)
* This notice must stay intact for use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

function buildCal(m, y, cM, cH, cDW, cD){
var dim=[31,0,31,30,31,30,31,31,30,31,30,31];

var oD = new Date(y, m-1, 1); //DD replaced line to fix date bug when current day is 31st
oD.od=oD.getDay()+1; //DD replaced line to fix date bug when current day is 31st

var todaydate=new Date() //DD added
var scanfortoday=(y==todaydate.getFullYear() && m==todaydate.getMonth()+1)? todaydate.getDate() : 0 //DD added

dim[1]=(((oD.getFullYear()%100!=0)&&(oD.getFullYear()%4==0))||(oD.getFullYear()%400==0))?29:28;
var t='<div class="'+cM+'"><table class="'+cM+'" cols="7" cellpadding="0" cellspacing="0">';
t+='<tr align="center">';
for(s=0;s<7;s++)t+='<td class="'+cDW+'">'+"SMTWTFS".substr(s,1)+'</td>';
t+='</tr><tr align="center">';
for(i=1;i<=42;i++){
var x=((i-oD.od>=0)&&(i-oD.od<dim[m-1]))? i-oD.od+1 : '&nbsp;';
if (x==scanfortoday) //DD added
x='<span id="today">'+x+'</span>' //DD added
t+='<td class="'+cD+'">'+x+'</td>';
if(((i)%7==0)&&(i<36))t+='</tr><tr align="center">';
}
return t+='</tr></table></div>';
}

var todaydate=new Date()
var curmonth //get current month (1-12)
var curyear=todaydate.getFullYear() //get current year
</script>

<script language = "javascript">
var darkmoonelwynn = '<table cellspacing = "0" cellpadding = "0" border = "0" width = 300><tr><td><span style = "font-family: tahoma; color: ffffff; font-size: 10pt;">\
<b style = "color: ffea00">Darkmoon Faire</b><br>Silas Darkmoon has brought together the Darkmoon Faire as a celebration of the wondrous and mysterious found in Azeroth. The faire has it all: delicious food, strong drink, exotic artifacts, fortunes read, amazing prizes, and excitement without end!\
</span></td></tr></table>';
</script>

</head>
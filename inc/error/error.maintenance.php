<?
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title('Error 404: Not Found');

subnav('Maintenance');

parchdown();

parchup(true);

$query="SELECT isbbcode, `text`, DATE_FORMAT(CONVERT_TZ(CONCAT(fp.`date`, ' ', fp.`hour`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".verifygmt($_SESSION['userid'])."'), '%d-%m-%y') as `date`, ft.image as image, ft.title as title, ft.issticked, fa.displayname as dn, fa.id_account as ida FROM `forum_posts` fp
					INNER JOIN `forum_accounts` fa ON (fa.id_account = fp.id_account)
					INNER JOIN `forum_topics` ft ON (ft.id_topic = fp.id_topic)
					WHERE ft.category=2 AND ft.`viewlevel` <= '".verifylevel($_SESSION['userid'])."' AND isreply=0";
if ($_REQUEST['m']=="") {
	$_REQUEST['m'] = date('Y-m');
} else { 
			$query .= " AND fp.`date` LIKE '".$_REQUEST['m']."%'"; 
}
			$query .=" GROUP BY fp.id_post
					ORDER BY fp.date DESC, fp.hour DESC";
$query = mysql_query($query) or die (mysql_error());
while ($row2 = mysql_fetch_array($query)) {

$newtitle = $row2['title'];
	
	$newdate = $row2['date'];
	$newposter = $row2['dn'];
	$newtext = bbcode($row2['text'],true,true,$row2['isbbcode']);


?>
<table>
<tr><td>
		<div id="container-community">

							<div class="phatLootBox-top">

							  <a href="index.php?n=community" style="cursor: hand;">
								<h2 class="community">
								  <span class="hide">Community</span>
								</h2>
							  </a>
<a href="index.php?n=community" style="cursor: hand;"><span class="phatLootBox-visual comm"></span></a>
<span class="arrow-readmore"><a href="index.php?n=community"><span>read more...</span></a></span>

							</div>

							<div class="phatLootBox-wrapper">

							  <div class="community-top">

								<h3>NOT FOUND
								</h3>

							  </div>

							  <div class="community-cnt">



								<p>
<script language="JavaScript">
function rotateEvery(refresh)
{
	var Quotation=new Array()

	// QUOTATIONS
	Quotation[0] = 'The Page you have requested seems to be on vacation, Please check back later.';
	Quotation[1] = 'The Page you have requested is at a L70ETC Consert and will be back soon.';
	Quotation[2] = 'The Page you have requested is currently raiding Naxxramas now Please check back later';
	Quotation[3] = 'Gnomes are working on this page and have gone to Ratchet to get their tools. Please Check back later.';
	Quotation[4] = 'An Oger was playing Hide-and-Seek with the page you have requested and lost it. Blizzard Employees are working to find it, Please come back later.'; 

	var which = Math.round(Math.random()*(Quotation.length - 1));
	document.getElementById('textrotator').innerHTML = Quotation[which];
	
	setTimeout('rotateEvery('+sec+')', sec*1000);
}
</script>
</head>
<body onload="rotateEvery(1)">
<div id="textrotator"><!--Quotations will be displayed here--></div>
								</p>

							  </div>

							  </div>

							<div class="phatLootBox-bottom">
							</div>

						  </div>
</td></tr>
</table>
<?
}

parchdown();
?>
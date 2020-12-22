<?
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title('Error 403 Access Denied');

subnav('Accessdenied');

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

								<h3>ACCESS DENIED
								</h3>

							  </div>

							  <div class="community-cnt">



								<p>This page or resourse you are trying to access has been disabled.
                                <br />Please Contact the website owner is this continues.</p>
								<p>
                                 <br  />
                                  Please Contact your administrator is this continues.
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
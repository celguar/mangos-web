<?
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title('Community Contest');

subnav('Challenges');

parchdown();

parchup(true);

$query="SELECT isbbcode, `text`, DATE_FORMAT(CONVERT_TZ(CONCAT(fp.`date`, ' ', fp.`hour`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".verifygmt($_SESSION['userid'])."'), '%d-%m-%y') as `date`, ft.image as image, ft.title as title, ft.issticked, fa.displayname as dn, fa.id_account as ida FROM `forum_posts` fp
					INNER JOIN `forum_accounts` fa ON (fa.id_account = fp.id_account)
					INNER JOIN `forum_topics` ft ON (ft.id_topic = fp.id_topic)
					WHERE ft.category=3 AND ft.`viewlevel` <= '".verifylevel($_SESSION['userid'])."' AND isreply=0";
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

								<h3><?php echo $newtitle; ?><i> - <?php echo $newposter; ?> on <?php echo $newdate; ?> </i>
								</h3>

							  </div>

							  <div class="community-cnt">

								<div class="community-portrait">
								  <img alt="" src="new-hp/images/portrait-frame.gif" style="background: url(new-hp/images/<? 
								$avatar = mysql_fetch_array(mysql_query("SELECT avatar FROM forum_accounts WHERE id_account='".$row2['ida']."'", $GLOBALS['MySQL_CON']));
								$avatar = explode('/', $avatar['avatar']);
								if ($avatar[0]!='gm' AND $avatar[0]!='mvp' AND $avatar[0]!='nochar') {
									$qquery = mysql_query("SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
										rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (`realm_settings` rs) ON r.id = rs.id_realm 
										WHERE r.id='".$avatar[1]."' GROUP BY r.id ORDER BY r.name") OR DIE(mysql_error());
										if (mysql_num_rows($qquery)==1) {
											$rowg = mysql_fetch_array($qquery);
											$newcon = mysql_connect($rowg['rsdbhost'].':'.$rowg['rsdbport'], $rowg['rsdbuser'], $rowg['rsdbpass']);;
											$newdb = mysql_select_db ($rowg['rsdbname'], $newcon);
											$newquery = mysql_query("SELECT name, data, class, race FROM `character` WHERE `account`='".$row2['ida']."' AND guid=".$avatar[0]."", $newcon);
											if (mysql_num_rows($newquery)==1) {
												$rowc = mysql_fetch_array($newquery);
													$rowc['data'] = explode(' ',$rowc['data']);		
													$char_gender = str_pad(dechex($rowc['data'][36]),8, 0, STR_PAD_LEFT);
													$char_gender = $char_gender{3};		
													$charset[1]=$rowc['data'][34];
													$charset[2]=$rowc['race'];
													$charset[3]=$char_gender;
													$charset[4]=$rowc['class'];
											}
										}
										@mysql_select_db($GLOBALS['MySQL_Set']['DBREALM'], $GLOBALS['MySQL_CON']);
								}
								if ($avatar[0]!='nochar' AND $avatar[0]!='gm' AND $avatar[0]!='mvp') {
									if ($charset[1]=='70') { echo 'wow-70/'; }
									else if ($charset[1]>='60') { echo 'wow/'; }
									else { echo 'forum/portraits/wow-default/'; }
									echo $charset[3].'-'.$charset[2].'-'.$charset[4].'.gif';
								} else if ($avatar[0]=='gm' OR $avatar[0]=='mvp') {
									echo 'forum/portraits/'.$avatar[0].'/'.$avatar[1];
								} else {
									echo $_LANG['LANG']['SHORT_TAG'].'/forum/no-character-icon.gif';
								} ?>) no-repeat 50% 50%; vertical-align: bottom;"></div>

								<p>
								<?php echo $newtext; ?>
								<p>

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
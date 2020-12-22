<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

mainup();

$userlvl = verifylevel($_SESSION['userid']);

if ($SETTING['WEB_SHOW_FLASH']==1) {
?>
<style>
.news-archive-button { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/news-archives.gif') no-repeat; }
.news-archive-button { height: 15px; width: 136px; margin: 5px auto 0; background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/news-archives.gif') no-repeat; }
.news-archive-button a, .news-archive-button a:active, .news-archive-button a:visited { display: block; height: 15px; width: 136px; background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/news-archives.gif') no-repeat 0 0; }

.smallTeaser h3.contests { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-contest.gif'); }
.smallTeaser h3.wallpapers { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-wallpapers.gif'); }
.smallTeaser h3.fanarts { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-fanarts.gif'); }

h2.community { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-comm.gif') no-repeat 0 0; }

.twoCol-smallTeaser h3.needhelp { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-needhelp.gif'); }
.twoCol-smallTeaser h3.jobs { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-jobs.gif'); }
</style>
<div id="imageSwitcher" style="z-index: 11;">

							<div id="flashContainer">

							  <div id="mainFlash"></div>
							<script language="javascript">
							printFlash("mainFlash", "<?php echo $SETTING['WEB_FLASH_URL']; ?>", "transparent", "false", "#000000", "540", "320", "high", "new-hp/flash", "xmlname=news.xmls", "<div style='position:relative;top:52px;left:32px;'></div>");
							</script>

							</div>

						  </div>


						  <script language="javascript">
//
if(is_mac && is_moz) document.getElementById("flashContainer").style.left="-30px";
//
</script>
<?php
}
?>
<div class="module-container">
<?php

if ($SETTING['WEB_SHOW_NEWS']==1) {

$query=mysql_query("SELECT isbbcode, `text`, DATE_FORMAT(CONVERT_TZ(CONCAT(fp.`date`, ' ', fp.`hour`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".verifygmt($_SESSION['userid'])."'), '%e-%c-%y') as `date`, DATEDIFF(NOW(), fp.`date`) as dayspost, ft.image as image, ft.title as title, ft.issticked, fa.displayname as dn FROM `forum_posts` fp
					INNER JOIN `forum_accounts` fa ON (fa.id_account = fp.id_account)
					INNER JOIN `forum_topics` ft ON (ft.id_topic = fp.id_topic)
					WHERE ft.category=1 AND ft.`viewlevel` <= '".$userlvl."' AND isreply=0
					GROUP BY fp.id_post
					ORDER BY ft.issticked DESC, fp.date DESC, fp.hour DESC 
					LIMIT 0, 10") or die (mysql_error());
$i=1;
while ($row2 = mysql_fetch_array($query)) {

$newimage = $row2['image'];
$newtitle = $row2['title'];
	
	$newdate = $row2['date'];
	$newposter = $row2['dn'];
	$newtext = bbcode($row2['text'],true,true,$row2['isbbcode']);;

?>
<script type="text/javascript">
var postId1=<?php echo $newdate."-".$i; ?>
</script>
							<div class="news-expand" id="news<?php echo $newdate."-".$i; ?>">
							  <div class="news-border-left"></div>
							  <div class="news-border-right"></div>
							  <div class="news-listing">
								<div onclick="javascript:toggleEntry('<?php echo $newdate."-".$i; ?>','<?php 
								if (is_integer(($i+1)/2)) { echo "alt"; } ?>')" onmouseout="javascript:this.style.background='none'" onmouseover="javascript:this.style.background='#EEDB99'" class="hoverContainer">
								  <div>
									<div class="news-top">
									  <ul>
										<li class="item-icon">
										  <img border="0" src="new-hp/images/icons/<? echo $newimage; ?>">
										</li>
										<li class="news-entry">
										  <h1>
											<a href="javascript:dummyFunction();"><? echo $newtitle; ?></a>
										  </h1>
										  <span class="user">Posted by: </span><small><? echo $newposter; ?><span class="user">|</span>&nbsp;<span class="posted-date"><?php echo $newdate ;if($row2['issticked']==1) { echo ' <img src="new-hp/images/v2/sticked.gif">'; }?></span></small>
										</li>
										<li class="news-entry-date">
										  <span><strong><?php if($row2['issticked']==1) { echo ' <img src="new-hp/images/v2/sticked.gif">'; } else { echo $newdate; } ?></strong></span>
										</li>
										<li class="news-toggle">
										  <a href="javascript:toggleEntry('<? echo $newdate."-".$i; ?>','')"><img alt="" src="new-hp/images/pixel.gif"></a>
										</li>
									  </ul>
									</div>
								  </div>
								</div>
							  </div>
							  <div class="news-item">
								<blockquote>
								  <dl>
									<dd>
									  <ul>
										<li>
										  <div class="letter-box0"></div>
										  <div class="blog-post">
											<description>
											<?php echo $newtext; ?>
											</description>
										  </div>
										</li>
									  </ul>
									</dd>
								  </dl>
								</blockquote>
							  </div>
							</div>
<script>
<?php if ($row2['dayspost']>3) { ?>
toggleEntry('<?php echo $newdate."-".$i; ?>','<?php if (is_integer(($i+1)/2)) { echo "alt"; } ?>')
<?php } ?>
</script>
<?php
$i++;
}
	if (mysql_num_rows($query) > 0) {
	?>

							  <div class="news-archive-link">

								<div class="news-archive-button">
								  <a href="?n=news.archive"><span>News Archives</span></a>
								</div>

							  </div>
	<div id="threeCol-teasers">

	<?php
	}
}
?>
							<h2>
							  <span class="hide">Community Teasers</span>
							</h2>

<?php
if ($SETTING['WEB_SHOW_CONTESTS']==1) {
?>								
							<div class="smallTeaser firstTeaser">

							  <span class="smallTeaser-visual community-contests"></span>

							  <div class="smallTeaser-bg">

								<h3 class="contests">
								  <span>Contests</span>
								</h3>


								<span class="arrow-readmore"><a href="?n=community.contests"><span>Click here to see more Contests</span></a></span>
<a href="?n=community.contests"><img alt="Contest" src="new-hp/images/featured/contest.jpg" title="Contest"></a>
<span class="button-readmore"><a href="?n=contest.php"><span>read more...</span></a></span>


							  </div>                                                        

							</div>
<?php 
}
if ($SETTING['WEB_SHOW_FANART']==1) {
?>	
							<div class="smallTeaser">

							  <span class="smallTeaser-visual community-fanarts"></span>

							  <div class="smallTeaser-bg">

								<h3 class="fanarts">
								  <span>Fan Art</span>
								</h3>

								<span class="arrow-readmore"><a href="?n=community.fanart"><span>Click here to see more Fan Art</span></a></span>
<a href="?n=community.fanart"><img alt="Fan Art" border="0" src="new-hp/images/featured/fanart.jpg" title="Fan Art"></a>
<span class="button-readmore"><a href="?n=fanart"><span>read more...</span></a></span>

							  </div>

							</div>
<?php 
}
if ($SETTING['WEB_SHOW_WALLPAPERS']==1) {
?>
							<div class="smallTeaser">

							  <span class="smallTeaser-visual community-wallpapers"></span>

							  <div class="smallTeaser-bg">


								<h3 class="wallpapers">
								  <span>Wallpapers</span>
								</h3>

								<span class="arrow-readmore"><a href="?n=media.wallpapers"><span>Click here to see more Wallpapers</span></a></span>
<!--<img src="/new-hp/images/featured/wallpaperfloat.gif" width="32" height="10" style="width:32px; height:10px; position:absolute; left:52px; top:10px;" />-->
<a href="?n=media.wallpapers"><img alt="Wallpapers" src="new-hp/images/featured/wallpaper.jpg" title="Wallpapers"></a>									
<span class="button-readmore"><a href="?n=wallpapers"><span>read more...</span></a></span>                                                            
							  </div>

							</div>

<?php
}

if ($SETTING['WEB_SHOW_COMMUNITY']==1) {

$query=mysql_query("SELECT isbbcode, `text`, DATE_FORMAT(CONVERT_TZ(CONCAT(fp.`date`, ' ', fp.`hour`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".verifygmt($_SESSION['userid'])."'),  '%d-%m-%y') as `date`, ft.title as title, ft.issticked, fa.displayname as dn, fa.id_account as ida FROM `forum_posts` fp
					INNER JOIN `forum_accounts` fa ON (fa.id_account = fp.id_account)
					INNER JOIN `forum_topics` ft ON (ft.id_topic = fp.id_topic)
					WHERE ft.category=2 AND ft.`viewlevel` <= '".$userlvl."' AND isreply=0
					GROUP BY fp.id_post
					ORDER BY fp.date DESC, fp.hour DESC 
					LIMIT 0, 1") or die (mysql_error());
while ($row2 = mysql_fetch_array($query)) {

$newtitle = $row2['title'];
	
	$newdate = $row2['date'];
	$newposter = $row2['dn'];
	if ($rowz['isbbcode']=='0') {
		$newtext = $row2['text'];
	} else {
		$newtext = bbcode($row2['text'], true, true, $row2['isbbcode']);
	}

?>

						  </div>


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
							  <div>
								<a href="index.php?n=community"><img alt="button-red-more" height="12" src="new-hp/images/icons/button-red-more.jpg" width="72"></a>
							  </div>
							</div>

						  </div>

<hr>

						  <div id="container-service">
<?php 
break;
}
}

if ($SETTING['WEB_SHOW_SUPPORT']==1) {
?>
							<h2>
							  <span class="hide">Customer Services</span>
							</h2>

							<div class="twoCol-smallTeaser left" style="margin-left: 1px;">

							  <a href="?n=support" style="cursor: hand;"><span class="smallTeaser-visual services-needhelp"></span></a>

							  <div class="twoCol-smallTeaser-bg">

								<div class="chains"></div>

								<a href="?n=forums&f=1" style="cursor: hand;">
								  <h3 class="needhelp">
									<span>Need Help?</span>
								  </h3>
								</a>
<span class="arrow-readmore"><a href="?n=support"><span>Click here to get to our Support website</span></a></span>
<a href="?n=support"><img alt="needhelp-gnome" height="89" src="new-hp/images/needhelp-gnome.gif" style="position: absolute; left: 105px; top: -8px; cursor: pointer;" title="Support" width="111">
<div style="background: url(new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/needhelp-bg.jpg) no-repeat 0 0; height: 61px; width: 211px; margin-left: 8px; cursor: pointer;">

								  </div>
								</a>
<span class="button-readmore"><a href="?n=support"><span>read more...</span></a></span>                                            

							  </div>
	

							  </div>
<?php
}
if ($SETTING['WEB_SHOW_JOBS']==1) {
?>
<!-- Jobs -->

							<div class="twoCol-smallTeaser right">

							  <a href="?n=support.jobs" style="cursor: hand;"><span class="smallTeaser-visual services-jobs"></span></a>

							  <div class="twoCol-smallTeaser-bg">

								<div class="chains"></div>

								<a href="?n=support.jobs" style="cursor: hand;">
								  <h3 class="jobs">
									<span>Jobs</span>
								  </h3>
								</a>
<span class="arrow-readmore"><a href="?n=support.jobs"><span>Click here to get to our Support website</span></a></span>
<a href="?n=support.jobs"><img alt="jobs-orc" src="new-hp/images/jobs-orc.gif" style="position: absolute; left: 125px; top: 3px; cursor: pointer;" title="Job Opportunities">
<div style="background: url(new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/jobs-bg.jpg) no-repeat 0 0; margin-left: 8px; height: 61px; cursor: pointer;">

								  </div>
								</a>
<span class="button-readmore"><a href="?n=support.jobs"><span>read more...</span></a></span>                                            

							  </div>

							</div>
<?php
}
?>

						  </div>

						
<?php

if ($SETTING['WEB_SHOW_MISC']==1) {

	

	$query=mysql_query("SELECT * FROM web_misc w");

	$pos="left";
	$j=1;
	while ($row2 = mysql_fetch_array($query)) {
	
	if ($pos=="left") {
?>  
<div class="container-misc"> 
<?php }
	
	$newtitle=$row2['title'];
	$newdesc=bbcode($row2['text']);
	$newtext=bbcode($row2['urls']);
	$newimage=$row2['image'];
?>
	
	<div class="miscBox1 <?php echo $pos; ?>">
		<div class="miscBox-top">
			<h4> <?php echo $newtitle; ?></h4>

		</div>
		<table>
			<tr>
				<td align=center valign=top>
			<img alt="image-miscbox1" class="left" height="50" src="new-hp/images/<?php echo $newimage; ?>" width="54"/>
			</td>
			<td valign=top>
			<font size=2px><?php echo $newdesc; ?></font><?php if ($newdesc!="") echo "<br><img src='new-hp/images/pixel.gif' width=7>" ?>
			<ul class="bullet-list">
			<?php 
			$ss = explode("\r", $newtext);
			for ($i=0;$i<count($ss);$i++) {
				echo '<li>'.$ss[$i].'</li>';
			}			
			?>
			</ul>
			</span>
			</td><tr>
		</table>
	</div>
				
<?php 
		if ($pos=="left") { 
			$pos="right"; 
			if (mysql_num_rows($query)==$j) { echo "</div><br><img src='new-hp/images/pixel.gif' width=7>";  }
		} else { 
			$pos="left"; echo "</div><img src='new-hp/images/pixel.gif' width=7>";  
		}
		$j++;
	} 
}

?>
<br></div>
<?php
maindown();
?>
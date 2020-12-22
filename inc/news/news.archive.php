<?
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title('News Archive');

subnav('News');

parchdown();

parchup(true);

metalborderup();

$query="SELECT id_post, isbbcode, `text`, DATE_FORMAT(CONVERT_TZ(CONCAT(fp.`date`, ' ', fp.`hour`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".verifygmt($_SESSION['userid'])."'), '%e-%c-%y') as `date`, DATEDIFF(NOW(), fp.`date`) as dayspost, ft.image as image, ft.title as title, ft.issticked, fa.displayname as dn FROM `forum_posts` fp
					INNER JOIN `forum_accounts` fa ON (fa.id_account = fp.id_account)
					INNER JOIN `forum_topics` ft ON (ft.id_topic = fp.id_topic)
					WHERE ft.category=1 AND ft.`viewlevel` <= '".verifylevel($_SESSION['userid'])."' AND isreply=0";
if ($_REQUEST['m']=="") {
	$_REQUEST['m'] = date('Y-m');
} else { 
			$query .= " AND fp.`date` LIKE '".$_REQUEST['m']."%'"; 
}
			$query .=" GROUP BY fp.id_post
					ORDER BY fp.date DESC, fp.hour DESC";
$query = mysql_query($query) or die (mysql_error());
$i=1;
while ($row2 = mysql_fetch_array($query)) {

$newimage = $row2['image'];
$newtitle = $row2['title'];
	
	$newdate = $row2['date'];
	$newposter = $row2['dn'];
	$newtext = bbcode($row2['text'],true,true,$row2['isbbcode']);

?>
<script type="text/javascript">

var postId1=<? echo $newdate."-".$i; ?>
</script>					<a name="<?php echo $row2['id_post']; ?>"></a>
							<div class="news-expand" id="news<? echo $newdate."-".$i; ?>">
							  <div class="news-listing">
								<div onclick="javascript:toggleEntry('<? echo $newdate."-".$i; ?>','<? 
								if (is_integer(($i+1)/2)) { echo "alt"; } ?>')" onmouseout="javascript:this.style.background='none'" onmouseover="javascript:this.style.background='#EEDB99'" class="hoverContainer">
								  <div>
									<div class="news-top">
									  <ul>
										<li class="item-icon">
										  <img border="0" src="new-hp/images/icons/<? echo $newimage; ?>"></li>
										<li class="news-entry">
										  <h1>
											<a href="javascript:dummyFunction();"><? echo $newtitle; ?></a>
										  </h1>
										  <span class="user">Posted by: </span><small><? echo $newposter; ?><span class="user">|</span>&nbsp;<span class="posted-date"><? echo $newdate; ?></span></small>
										</li>
										<li class="news-entry-date">
										  <span><strong><? echo $newdate; ?></strong></span>
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
											<? echo $newtext; ?>
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
$i +=1;
}
metalborderdown();

parchdown();
?>
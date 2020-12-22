<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

$userlvl = verifylevel($_SESSION['userid']);

if ($SETTING['FORUM_ENABLED']==0 AND $userlvl<1) {

	errborder('The Forums Are Disabled!');

	
} else {

	$ttpage=40; //Topics per page
	$tppage=25; // Posts per page
	
	$usergmt = verifygmt($_SESSION['userid']);
	$userbanned = mysql_num_rows(mysql_query("SELECT id FROM account_banned WHERE id='".$_SESSION['userid']."' AND active=1", $MySQL_CON));
	
	$USER_LEVEL['-1'] = 'Any User';
	$USER_LEVEL['4'] = 'Owner';
	
	if ($_REQUEST['f']=='search') {
	
		include ('inc/forum/forums.search.php');
	
	} else if ($_REQUEST['f']=='' AND $_REQUEST['t']=='') {
			?>
<center>
<div id="container" style="width: 775px; position: relative; text-align:right;">

<!--// Begin Small Box //-->

<div style="position: absolute; top: 0; right: 35px; z-index: 100; width: 270px;">

<div class="gborder" style="width: 270px; margin: 0 auto;">
	<ul>
		<li class="bg">
	<div class="a">
		<ul>

			<li class="bg">
		<div class="b">
			<ul>
				<li class="bg">
								<center>
									<div class="d" style=" width: 215px; vertical-spacing: 10;">
										<ul>
											<li><span><small><b>New to the forums?</b><br>Read our <a href="?n=gameguide.introduction#forums">Introduction to the Forums</a>. This includes information about getting started, forum features, forum icons, and more.</small></span>
											</li>
										</ul>
										<ul>
											<li><span><small><b>Found a bad post or account name?</b><br><img src="new-hp/images/forum/biohazard-button.gif" align="left" border="0" height="21" width="23">If you find a bad forum post or account name that violates the forum guidelines, you can report it by clicking on this red button.</small></span>

											</li>
										</ul>
									</div>

								</center>
				</li><!-- end bg -->
			</ul>
		</div>
			</li>
		</ul>
	</div>
		</li>
	</ul>

</div><!-- end gborder -->
</div>
<!--// End Small Box //-->

<!--// Begin Large Box //-->

<div class="gborder" style="width: 775px; margin: 0 auto;">
	<ul>
		<li class="bg">
	<div class="a">
		<ul>
			<li class="bg">

		<div class="b">
			<ul>
				<li class="bg">
<div style="background: none; width: 100%; display: block;">									
										<div class="c" style="width: 700px;">
<!-- Begin Content -->
											<div style="float: left; position: relative; width: 420px; height: 210px; color:white; padding-left: 3px;">
												<img src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/header-forums.gif" alt="Forum Community" /><br/><b>Welcome to the World of Warcraft community forums!</b>
												<p><span>
														We provide the community forums for our players to chat, exchange ideas, and submit feedback.<br>
														Also we provide a <a href="?n=forums&f=search" style="font-size: 12px; font-weight: normal;">Search Tool</a> so you can find the information you want in a fast and easyer way.<br>
												</span>

												</p>
											</div>
										<div class="clear"></div>
										<div class="index-spacer"></div>

										<div id="forumlistcontainer">
	<?php

	$newquery = mysql_query("SELECT * FROM `forums` WHERE `viewlevel` <= '".$userlvl."' ORDER BY `ordenation` ASC", $MySQL_CON) or die (mysql_error());
	$i=0;
		while($rowa = mysql_fetch_array($newquery)) {
		if ($rowa['categorized']=='1') {
				for ($j=0;$j<count($sstr);$j++) {
					if ($sstr[$j][0]==$rowa['group']) {	
						break;
					} else if ($sstr[$j][0]!=$rowa['group'] and ($j==$i-1)) {
						$sstr[$i][0]=$rowa['group'];
						$sstr[$i][1]=true;
					}
				}
		} else {
			$sstr[$i][0]= "<a href='?n=forums&f=".$rowa['id_forum']."'><img id='fbullet_".$rowa['id_forum']."' src='new-hp/images/forum/forumbullets/".$rowa['image']."' border='0' alt='".$rowa['title']."' align='left' />".$rowa['title']."</a><br />".$rowa['description']."</span>";
			$sstr[$i][1]=false;
		}
		$i++;
	}
	
	$sidec=0;
	for ($i=0;$i<count($sstr);$i++) {		
		
		if ($side=='left') { 
			if ($sidec>0) { $sidec--; } else { $side='right';  } 
		} else { 
			if ($sidec>0) { $sidec--; }  else {	$side='left'; 	}
		}
			
		echo "
<div class='".$side."'>";
		if ($sstr[$i][1]==true) {
			echo "
	<ol>
		<li class='b'>
			<span>
				<a name='classes'><img id='fbullet_".$rowa['id_forum']."' src='new-hp/images/forum/forumbullets/bullet.gif' border='0' align='left' /><b>
							".$FORUM_GROUP[$sstr[$i][0]]."
						</b></a>
			</span>
		</li>
	</ol>
<div id='classforumlist'>
	<table border='0' cellpadding='0' cellspacing='0'>
		<tr>";
				$newquery = mysql_query("SELECT * FROM `forums` WHERE `viewlevel` <= '".$userlvl."' and `group`='".$sstr[$i][0]."' and categorized=1 ORDER BY `ordenation` ASC", $MySQL_CON) or die (mysql_error());
				$j=1;
				while($rowa = mysql_fetch_array($newquery)) {
					$sstr[$i][0] = '
					<td width=38><a href="?n=forums&f='.$rowa['id_forum'].'"><img id="fbullet_'.$rowa['id_forum'].'" src="new-hp/images/forum/forumbullets/'.$rowa['image'].'" border="0" height="35" width="38"></a></td>
					<td align=left valign=middle><span style="font-size: 12px;"><a href="?n=forums&f='.$rowa['id_forum'].'">'.$rowa['title'].'</a></span></td>';
					if (is_int($j/3)) {	echo $sstr[$i][0].'
		</tr>
		<tr>'; } else { echo $sstr[$i][0]; }
					if ($j==1 OR is_int(($j/4)+1)) { $sidec++; }
					$j++;
				}
				if ($sidec>0) { if ($side=='left') { $side='right'; } else { $side='left'; } }
			echo "
		</tr>
	</table>
</div>";
		} else {
			
				echo "
	<ol>
		<li class='a'><span>".$sstr[$i][0]."</span></li>
	</ol>";
				
		}
		echo "
</div>";
		
	}

	?>
											
								
										</div>
<div class="clear" style="width: 100%; text-align: center;"></div>
					</div>

<!-- End Content -->

										</div>
								</div>
				</li><!-- end bg -->
			</ul>
		</div>
			</li>
		</ul>
	</div>

		</li>
	</ul>
</div><!-- end gborder -->

<!--// End Large Box //-->

</div>
</center>
		<?php

	} else if ($_REQUEST['f']!='') {
		
		$selforum =  mysql_query("SELECT id_forum, image, title, viewlevel, postlevel FROM `forums` WHERE `id_forum`='".$_REQUEST['f']."' ORDER BY `id_forum` ASC LIMIT 0, 1", $MySQL_CON) or die (mysql_error());

		$rowz = mysql_fetch_array($selforum);

		if (mysql_num_rows($selforum) > 0) {
			navigation($rowz['id_forum'], $_REQUEST['topic']);
		}
		
		if (mysql_num_rows($selforum) == 0) {
			echo '<br><br><br><br>';
			errborder('Forum non-existent.');
			echo '<br><br><br><br>';
		} else if (($rowz['viewlevel']=='0') AND !isset($_SESSION['userid'])) {
			echo '<br><br><br><br>';
			errborder($_LANG['ERROR']['NEED_LOGIN']);
			echo '<br><br><br><br>';
		} else if ($userbanned==1 AND ($_REQUEST['topic']!='')) {
			echo '<br><br><br><br>';
			errborder('You\'re are BANNED.');
			echo '<br><br><br><br>';
		} else if ($rowz['viewlevel']>$userlvl) {
			echo '<br><br><br><br>';
			errborder('You are not allowed to see this Forum.');
			echo '<br><br><br><br>';
		} else if (!isset($_SESSION['userid']) AND $_REQUEST['topic']!='') {
			echo '<br><br><br><br>';
			errborder($_LANG['ERROR']['NEED_LOGIN']);
			echo '<br><br><br><br>';
		} else if ($rowz['postlevel']>$userlvl AND $_REQUEST['topic']=='new') {
			echo '<br><br><br><br>';
			errborder('You are not allowed to post topics in this Forum.');
			echo '<br><br><br><br>';
		}  else {
			
			include('forums.topics.php');
			
		}
	} else if ($_REQUEST['f']=='' AND $_REQUEST['t']!='') {
			
		$selforum =  mysql_query("SELECT f.id_forum, f.image, f.title, f.viewlevel, f.postlevel, ft.id_topic as id_topic, ft.title as ttitle, 
								ft.viewlevel as ftvlvl, ft.postlevel as ftplvl, ft.issticked as st, ft.poll_question as poll, ft.poll_lasts as poll_lasts, ft.poll_stamp as poll_stamp
								FROM `forums` f
								LEFT JOIN (`forum_topics` ft) ON f.id_forum = ft.id_forum
								WHERE ft.`id_topic`='".$_REQUEST['t']."' LIMIT 0, 1", $MySQL_CON) or die (mysql_error());
		
		$rowz = mysql_fetch_array($selforum);
		
		if (mysql_num_rows($selforum) > 0) {
			navigation($rowz['id_forum'],$_REQUEST['post'].$_REQUEST['topic']);
		}
		
		if (mysql_num_rows($selforum) == 0) {
			echo '<br><br><br><br>';
			errborder('Topic non-existent.');
			echo '<br><br><br><br>';
		} else if (($rowz['viewlevel']=='0' OR  $rowz['ftvlvl']=='0') AND !isset($_SESSION['userid'])) {
			echo '<br><br><br><br>';
			errborder($_LANG['ERROR']['NEED_LOGIN']);
			echo '<br><br><br><br>';
		} else if ($userbanned==1 AND ($_REQUEST['topic']!='' OR $_REQUEST['post']!='')) {
			echo '<br><br><br><br>';
			errborder('You\'re are BANNED.');
			echo '<br><br><br><br>';
		} else if ($rowz['viewlevel']>$userlvl) {
			echo '<br><br><br><br>';
			errborder('You are not allowed to view this Forum.');
			echo '<br><br><br><br>';
		} else if ($rowz['ftvlvl']>$userlvl) {
			echo '<br><br><br><br>';
			errborder('You are not allowed to view this Topic.');
			echo '<br><br><br><br>';
		} else if (!isset($_SESSION['userid']) AND ($_REQUEST['topic']!='' OR $_REQUEST['post']!='')) {
			echo '<br><br><br><br>';
			errborder($_LANG['ERROR']['NEED_LOGIN']);
			echo '<br><br><br><br>';
		} else if ($rowz['postlevel']>$userlvl AND $_REQUEST['post']=='new') {
			echo '<br><br><br><br>';
			errborder('You are not allowed to post replies in this Forum.');
			echo '<br><br><br><br>';
		} else if ($rowz['ftplvl']>$userlvl AND $_REQUEST['post']=='new') {
			echo '<br><br><br><br>';
			errborder('You are not allowed to post replies in this Topic.');
			echo '<br><br><br><br>';
		} else if ($rowz['postlevel']>$userlvl AND $_REQUEST['post']!='') {
			echo '<br><br><br><br>';
			errborder('You are not allowed to manage replies in this Forum.');
			echo '<br><br><br><br>';
		} else if ($rowz['ftplvl']>$userlvl AND $_REQUEST['post']!='') {
			echo '<br><br><br><br>';
			errborder('You are not allowed to manage replies in this Topic.');
			echo '<br><br><br><br>';
		} else if ($rowz['postlevel']>$userlvl AND $_REQUEST['topic']!='') {
			echo '<br><br><br><br>';
			errborder('You are not allowed to manage topics in this Forum.');
			echo '<br><br><br><br>';
		} else if ($rowz['ftplvl']>$userlvl AND $_REQUEST['topic']!='') {
			echo '<br><br><br><br>';
			errborder('You are not allowed to manage topics in this Forum.');
			echo '<br><br><br><br>';
		} else if (($rowz['postlevel']>$userlvl OR $rowz['ftplvl']>$userlvl) AND $_POST['rpoll']!='') {
			echo '<br><br><br><br>';
			errborder('You are not allowed to vote in this Topic.');
			echo '<br><br><br><br>';
		} else {
			
			if (isset($_SESSION['userid'])) {
				viewedtopic($_REQUEST['t']);
			} else {
				mysql_query("UPDATE forum_topics SET `views` = `views` + 1 WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON) or die (mysql_error());
			}
			
			if ($_REQUEST['topic']=='') {
				
				include('forums.posts.php');
				
			} else {
			
				include('forums.topics.php');
			}
		}
			
	}

}

?>
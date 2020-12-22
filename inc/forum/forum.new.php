<?

if (INCLUDED!==true) { include('index.htm'); exit; }

if(($_REQUEST['n']=='forums' OR  $_REQUEST['n']=='') AND $_REQUEST['f']=='' AND $_REQUEST['t']=='') {
		
	if (isset($_SESSION['userid'])) {
		//0 - Viewed | 1 - Unviewed | 2 - New | 3 - Update
		$qquery =  mysql_query("SELECT id_topic, id_forum FROM `forum_topics` WHERE `viewlevel` <= '".$userlvl."'", $MySQL_CON) or die (mysql_error());
		while ($rowc = mysql_fetch_array($qquery)) {
		
			$author =  mysql_query("SELECT fp.id_post, fp.id_account, fp.`date`, fp.`hour`, a.gmlevel as gmlvl, fa.displayname as dn FROM `forum_posts` fp
						LEFT JOIN `forum_accounts` fa ON (fa.id_account = fp.id_account)
						LEFT JOIN `account` a ON (fa.id_account = a.id)
						WHERE fp.id_topic='".$rowc['id_topic']."'
						ORDER BY fp.id_post ASC LIMIT 0, 1", $MySQL_CON) or die (mysql_error());			
			$rowauthor = mysql_fetch_array($author);
			
			$rowtotalrows = mysql_query("SELECT id_post FROM forum_posts WHERE id_topic='".$rowc['id_topic']."'", $MySQL_CON) or die (mysql_error());
	
			$topicviewed =  mysql_query("SELECT `time` FROM forum_views WHERE id_topic='".$rowc['id_topic']."' AND id_account='".$_SESSION['userid']."'", $MySQL_CON) or die (mysql_error());
			
			if (mysql_num_rows($topicviewed)==1) {
					$updatelink = mysql_fetch_array($topicviewed);
					$topicviewed = mysql_query("SELECT id_post FROM forum_posts
						WHERE id_topic='".$rowc['id_topic']."' AND isreply=1 AND TIMESTAMPDIFF(SECOND, '".$updatelink['time']."', CONCAT(`date`, ' ', `hour`))>0 ORDER BY `date`, `hour`, `id_post`", $MySQL_CON) or die (mysql_error());
				if (mysql_num_rows($topicviewed)>0) {
					$updatelink = ceil(((mysql_num_rows($rowtotalrows) - mysql_num_rows($topicviewed)) / $tppage));
					$row = mysql_fetch_array($topicviewed);
					$updatelink='#'.$row['id_post'];
					if ($FORUMLIST[$rowc['id_forum']]<3) { $FORUMLIST[$rowc['id_forum']] = 3; }
				} else {
					if ($FORUMLIST[$rowc['id_forum']]=='') { $FORUMLIST[$rowc['id_forum']] = 0; }
				}
			} else {
				$topicviewed =  mysql_query("SELECT a.id FROM account a, forum_posts fp
											WHERE a.id='".$_SESSION['userid']."' AND  fp.id_post='".$rowauthor['id_post']."' AND
											TIMESTAMPDIFF(SECOND, a.`joindate`, '".$rowauthor['date']." ".$rowauthor['hour']."')>0", $MySQL_CON) or die (mysql_error());
				if (mysql_num_rows($topicviewed)==1) {
					if ($FORUMLIST[$rowc['id_forum']]<2) { $FORUMLIST[$rowc['id_forum']] = 2; }
				} else {
					if ($FORUMLIST[$rowc['id_forum']]<1) { $FORUMLIST[$rowc['id_forum']] = 1; }
				}
			}
		
		}
		echo '<script>';
			echo 'document.getElementById("topnaveforums").style.background = "url(\'new-hp/images/forum/square-grey.gif\') no-repeat 0 0";';
		foreach ($FORUMLIST as $key=>$value) {
			if ($value > 0) echo '
			document.getElementById("fbullet_'.$key.'").style.background = "url("+document.getElementById("fbullet_'.$key.'").src+") no-repeat 50% 50%";
			document.getElementById("fbullet_'.$key.'").src = "inc/forum/forum.new/square-'.$value.'.gif";
			document.getElementById("fbullet_'.$key.'").src = "inc/forum/forum.new/square-'.$value.'.gif";';
		}
		echo '</script>';
			
	}

}

?>
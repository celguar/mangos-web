<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

if ($_POST["rpoll"]!='') {
	if ($rowz['poll']=='') {
		$haserrors='This poll don\'t has a vote request.';
	} else {
		if (mysql_num_rows(mysql_query("SELECT id_poll FROM forum_rel_topics_polls WHERE id_topic='".$_REQUEST['t']."' AND id_poll='".$_POST['rpoll']."'", $MySQL_CON))==0) {
			$haserrors='The option you selected is invalid.';
		} else {
			$rowj=mysql_query("SELECT * FROM forum_rel_account_polls ap
								LEFT JOIN (forum_rel_topics_polls tp) ON ap.id_poll = tp.id_poll
								WHERE tp.id_topic='".$_REQUEST['t']."' AND ap.id_account='".$_SESSION['userid']."' GROUP BY tp.id_topic", $MySQL_CON) OR DIE (mysql_error());
			if (mysql_num_rows($rowj)==0) {
				mysql_query("INSERT INTO forum_rel_account_polls(id_poll, id_account) VALUES('".$_POST['rpoll']."','".$_SESSION['userid']."')", $MySQL_CON);
			} else {
				$haserrors='You already voted for this Topic.';
			}
		}
	}
	unset($_POST["rpoll"]);
}

if ($_REQUEST['post']!='') {
	
	if ($_REQUEST['post']=='new' OR ($_REQUEST['post']=='edit' AND $_REQUEST['r']!='')) {
			
		$forceshow=true;
		
		if ($_REQUEST['post']=='edit' AND $_SERVER['REQUEST_METHOD']!='POST') {
			$rowj=mysql_fetch_array(mysql_query("SELECT *, a.gmlevel as gmlvl
						FROM forum_posts fp
						LEFT JOIN (account a) ON a.id = fp.id_account
						WHERE fp.id_post='".$_REQUEST['r']."' AND fp.isreply='1'
						ORDER BY `id_post` ASC ", $MySQL_CON));
			$rowk=mysql_fetch_array(mysql_query("SELECT id_account FROM forum_posts WHERE id_topic='".$_REQUEST['t']."' ORDER BY `id_post` DESC LIMIT 0, 1", $MySQL_CON));
			if ($_SESSION['userid']==$rowj['id_account'] AND ($SETTING['USER_EDIT_OWN_POSTS']=='1' OR ($SETTING['USER_EDIT_OWN_POSTS']=='2' AND $rowk['id_account']==$_SESSION['userid'])) OR $userlvl>0) {
				$_POST['subject']=$rowj['title'];
				$_POST['message']=$rowj['text'];
				$_POST['issigned']=$rowj['issignature'];
				$_POST['isbbcode']=$rowj['isbbcode'];				
			} else {
				echo '<br><br><br><br>';
				errborder('You are not allowed to manage this Reply.');
				echo '<br><br><br><br>';
				$forceshow=false;
			}
		} else if ($_REQUEST['post']=='new' AND $_SERVER['REQUEST_METHOD']!='POST') {
			$_POST['issigned']='1';
			$_POST['isbbcode']='1';	
		}
		?>
			<form name="postForm" id="postForm" action="?n=forums&t=<?php echo $_REQUEST['t']; ?>&post=<?php
		if ($_REQUEST['post']=='new') {
				
			echo 'new';
		} else if ($_REQUEST['post']=='edit') {
			echo 'edit&r='.$_REQUEST['r'];
		}
		?>" method="post"><?php
		if ($_POST['issigned']=='') { $_POST['issigned']='0'; } else if ($_POST['issigned']!='0') { $_POST['issigned']='1'; }
		if ($_POST['isbbcode']=='') { $_POST['isbbcode']='0'; } else if ($_POST['isbbcode']!='0') { $_POST['isbbcode']='1'; }
		if ($_POST['newpost']=='post') {
			if (strlen($_POST['message'])<5) {
					$haserrors.='Message field must have more than 5 characters.<br>';
			}
			if ($haserrors=='') {
				if ($_REQUEST['post']=='new') {
					$query =  mysql_query("INSERT INTO forum_posts(text, date, hour, isreply, issignature, isbbcode, id_account, id_topic) 
										VALUES('".$_POST['message']."','".date('Y-m-d')."','".date('H:i:s')."', 1,
										'".$_POST['issigned']."','".$_POST['isbbcode']."','".$_SESSION['userid']."','".$_REQUEST['t']."')", $MySQL_CON) OR DIE(mysql_error());					
					$_REQUEST['r']=mysql_insert_id($MySQL_CON);
				} else if ($_REQUEST['post']=='edit') {
					$query =  mysql_query("UPDATE forum_posts SET `text`='".$_POST['message']."', date_edit='".date('Y-m-d')."', 
									hour_edit='".date('H:i:s')."', id_account_edit='".$_SESSION['userid']."', 
									issignature='".$_POST['issigned']."', isbbcode='".$_POST['isbbcode']."' WHERE id_post='".$_REQUEST['r']."'", $MySQL_CON) OR DIE(mysql_error());
				}
				unset($_POST['subject']);
				unset($_POST['message']);
				echo '<br><br><br><br>';
				goodborder('Your message has been entered successfully.<META HTTP-EQUIV="Refresh" CONTENT="2; URL=?n=forums&t='.$_REQUEST['t'].'#'.$_REQUEST['r'].'">');
				viewedtopic($_REQUEST['t']);
				echo '<br><br><br><br>';
				$forceshow=false;
			}
		}

		if ($forceshow==true) {
			remslashall();
		?>
			<input type=hidden name="newpost" value='post'>
			<div id="post" align=center>
				<div class="post-box">
					<div class="post-box-bottom">
						<div class="post-box-top">
			<div id="post-topic-shell">
				<div class="resultbox">
		<?php if ($haserrors!='') { echo errborder($haserrors); } ?>
					<div id="postdisplay">
						<div class="border">
							<div class="insert">
						<blockquote>
							<div class="post-top">
			<br/>
			<!-- end admin-container -->
			<br><br>
			<!-- end subject-box -->
				
			<!-- end subject-message -->

			</div><!-- end subject-container -->
			<div class="message-container">
			<div class="post-ui-container">
				<div id="post-ui" style="width: 266px;">

					<div class="post-ui-left">
						<div class="post-ui-right"style="width: 266px;">
						<script language=javascript src="new-hp/js/quick_reply.js"></script>
						<script>
							function getTextarea()  {
								var textarea
								textarea = document.postForm.message;
								return textarea;
							}
						</script>
						<style>
						#post li.bold { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-bold.gif') no-repeat; }
						#post li.italic { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-italic.gif') no-repeat; }
						#post li.underline { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-underline.gif') no-repeat; }
						#post li.list { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-list.gif') no-repeat; }
						#post li.left{ background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-left.gif') no-repeat; cursor: hand; }
						#post li.center { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-center.gif') no-repeat; cursor: hand; }
						#post li.right { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-right.gif') no-repeat; cursor: hand; }
						#post li.link { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-link.gif') no-repeat; cursor: hand; }
						#post li.image { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-image.gif') no-repeat; cursor: hand; }
						#post li.tabbed-list { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-tabbed-list.gif') no-repeat; }
						#post li.hr { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-hr.gif') no-repeat; }
						#post li.pre { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-pre.gif') no-repeat; }
						#post li.quote { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-quote.gif') no-repeat; }
						</style>
						<ul>
							<li class="bold"><a href="javascript:edInsertTag(document.postForm.message, 0);" ><img src="new-hp/images/forum/pixel.gif" alt="bold"  onmouseover="ddrivetip('Bold','#ffffff')"; onmouseout="hideddrivetip()" /></a></li>
							<li class="italic"><a href="javascript:edInsertTag(document.postForm.message, 1);"><img src="new-hp/images/forum/pixel.gif" alt="italic" onmouseover="ddrivetip('Italic','#ffffff')"; onmouseout="hideddrivetip()" /></a></li>
							<li class="underline"><a href="javascript:edInsertTag(document.postForm.message, 2);" ><img src="new-hp/images/forum/pixel.gif" alt="underline" onmouseover="ddrivetip('Underline','#ffffff')"; onmouseout="hideddrivetip()" /></a></li>
							<li class="left"><a href="javascript:edInsertTag(document.postForm.message, 3);" ><img src="new-hp/images/forum/pixel.gif" id=bbleft  value="B" alt="Left"  onmouseover="ddrivetip('Align Left','#ffffff')"; onmouseout="hideddrivetip()" ></a></li>
							<li class="center"><a href="javascript:edInsertTag(document.postForm.message, 4);" ><img src="new-hp/images/forum/pixel.gif" id=bbcenter value="I" alt="Center" onmouseover="ddrivetip('Align Center','#ffffff')"; onmouseout="hideddrivetip()" ></a></li>
							<li class="right"><a href="javascript:edInsertTag(document.postForm.message, 5);" ><img src="new-hp/images/forum/pixel.gif" id=bbright value="U" alt="Right"  onmouseover="ddrivetip('Align Right','#ffffff')"; onmouseout="hideddrivetip()" ></a></li>
							<li class="link"><a href="javascript:edInsertLink(document.postForm.message, 2);" ><img src="new-hp/images/forum/pixel.gif" id=bblink value="Link" alt="Link"  onmouseover="ddrivetip('Insert URL','#ffffff')"; onmouseout="hideddrivetip()" ></a></li>
							<li class="image"><a href="javascript:edInsertImage(document.postForm.message);" ><img src="new-hp/images/forum/pixel.gif" id=bbimage value="Image" alt="Image"  onmouseover="ddrivetip('Insert Image','#ffffff')"; onmouseout="hideddrivetip()" ></a></li>
							<li class="quote"><a href="javascript:edInsertTag(document.postForm.message, 8);"><img src="new-hp/images/forum/pixel.gif" alt="quote" onmouseover="ddrivetip('Quote','#ffffff')"; onmouseout="hideddrivetip()" /></a></livetip('Quote','#ffffff')"; onmouseout="hideddrivetip()" /></a></li>
						</ul>
						</div>
					</div>
				</div>
			</div>

				<div class="message-body-main">
					<div class="message-bottom">

						<div class="message-top">
						<h2><span>Message:</span></h2>
							
							<textarea name="message" id="message" tabindex="4" rows="5" cols="10" class="post-message-text"><?
							if ($_REQUEST['q']!='') {
								$rowj=mysql_fetch_array(mysql_query("SELECT `text`
								FROM forum_posts fp
								WHERE id_post='".$_REQUEST['q']."' AND id_topic='".$_REQUEST['t']."'
								ORDER BY `id_post` ASC ", $MySQL_CON));
								echo '[quote]'.$rowj['text'].'[/quote]';
							}
							echo $_POST['message'];
							?></textarea>				
						</div>	
					</div>
				</div>
				
			</div>
			<div class="options-container">
				<div class="options-left">

					<div class="options-right">
						<div class="options-bot">
							<div class="options-top">
			<div class="sig-options" style="margin: 4px 30px auto;">
				<ul>
					<li class="check-box"><input class="button" type="checkbox" id="signed" name="issigned" value="1" checked="true" /></li>
					<li class="sig-desc"><label for='signed'>Include signature</label>&nbsp;&nbsp;</li>
				</ul>
				<img src="new-h/images/pixel.gif" width=0 height=4>
				<ul>
					<li class="check-box"><input class="button" type="checkbox" id="bbcode" name="isbbcode" value="1" checked="true" /></li>
					<li class="sig-desc"><label for='bbcode'>Enable BBCode</label></li>
				</ul>
			</div><!-- end sig-options-->

			<div class="post-button">
				<div class="post-button-left">
					<div class="post-button-right">
						<ul>
							<li><input type="image" class="button" src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/preview.gif" onClick="javascript: document.postForm.newpost.value = 'preview'"></li>			
							<li><input type="image" class="button" src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/post.gif" onClick="javascript: document.postForm.newpost.value = 'post'"></li>
						</ul>
					</div><!-- end post-button-right -->
				</div><!-- end post-button-left -->

			</div><!-- end post-button-->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end options-container -->
							</div><!-- end post-top -->
						</blockquote>
							</div><!-- end insert -->

						</div><!-- end border -->
					</div><!-- end postdisplay -->
				</div><!-- end resultbox -->
			</div><!-- End div postshell -->
						</div><!-- end post-box-top -->
					</div><!-- end post-box-bottom -->
				</div><!-- end post-box -->
			</div><!-- end post -->
			</form>

			<div id="postbackground">
				<div class="right">

			<!-- Edit/Quoted/Reply Post -->
			</div></div>
			<div class="forum-index">
				<div class="findex">
				<a href="?n=forums"><img src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/forum-index.gif" width="104" height="41" border="0" alt="forum-index" title="Forum Index" /></a>
				</div>
			</div>
<script>
document.postForm.issigned.checked=<?php echo $_POST['issigned']; ?>;
document.postForm.isbbcode.checked=<?php echo $_POST['isbbcode']; ?>;
</script>
			<?	
			}
		} else if ($_REQUEST['post']=='remove') {
			
			$rowj=mysql_fetch_array(mysql_query("SELECT id_post, isreply, id_account, a.gmlevel as gmlvl
			FROM forum_posts fp
			LEFT JOIN (account a) ON a.id = fp.id_account
			WHERE id_post='".$_REQUEST['r']."'
			ORDER BY `id_post` ASC ", $MySQL_CON));
			$rowk=mysql_fetch_array(mysql_query("SELECT id_post, id_account FROM forum_posts WHERE id_topic='".$_REQUEST['t']."' ORDER BY `id_post` DESC LIMIT 0, 1", $MySQL_CON));
			if ($_SESSION['userid']==$rowj['id_account'] AND ($SETTING['USER_REMOVE_OWN_POSTS']=='1' OR ($SETTING['USER_REMOVE_OWN_POSTS']=='2' AND $rowk['id_account']==$_SESSION['userid'])) OR $userlvl>0) {
			
				if ($_SERVER['REQUEST_METHOD']=='POST') {
					if ($rowj['isreply']=='0' AND $rowj['id_post']==$rowk['id_post']) { 
						mysql_query("DELETE FROM forum_topics WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON);
					} else {
						$rowd = mysql_query("SELECT id_post FROM forum_posts WHERE isreply='1' AND id_topic='".$_REQUEST['t']."' ORDER BY id_post ASC LIMIT 0, 1", $MySQL_CON) OR DIE (mysql_error());
						$rowd = mysql_fetch_array($rowd);
						mysql_query("UPDATE forum_posts SET isreply=0 WHERE id_post='".$rowd['id_post']."'", $MySQL_CON);
					}
					if (mysql_query("DELETE FROM forum_posts WHERE id_post='".$_REQUEST['r']."'", $MySQL_CON)) {
						echo '<br><br><br><br>';
						goodborder('Reply Removed Successfuly.<META HTTP-EQUIV="Refresh" CONTENT="1; URL=?n=forums&f='.$rowz['id_forum'].'">');
						echo '<br><br><br><br>';
					} else  {
						echo '<br><br><br><br>';
						errborder('Couldn\'t Remove Reply.');
						echo '<br><br><br><br>';
					}
				} else {
					
					$forceshow=true;
				}
			
			} else {
				echo '<br><br><br><br>';
				errborder('You are not allowed to Remove this Reply.');
				echo '<br><br><br><br>';
				$forceshow=false;
			}

			if ($forceshow==true) {
				?>
				<br><br><br><br>
				<div align=center><form method=post action='?n=forums&t=<?php echo $_REQUEST['t']; ?>&post=<?php echo $_REQUEST['post']; ?>&r=<?php echo $_REQUEST['r']; ?>'><div align=center style="width: 200px; border: 2px solid orange; color: white;"><br>You sure you want to Remove this Reply?<br><br>
				<input  style="width: 90px; height: 30px;" onclick="window.location='<?php echo $_SERVER['HTTP_REFERER']; ?>'" type=button value="No">&nbsp;&nbsp;<input  style="width: 90px; height: 30px;" type=submit value="Yes">
				<br><br></div></form></div>
				<br><br><br><br>
				<?
			}
			
		} else if ($_REQUEST['post']=='report') {
			
			$rowj=mysql_fetch_array(mysql_query("SELECT *, a.gmlevel as gmlvl
			FROM forum_posts fp
			LEFT JOIN (account a) ON a.id = fp.id_account
			WHERE id_post='".$_REQUEST['r']."'
			ORDER BY `id_post` ASC ", $MySQL_CON));
			if ($_SESSION['userid']!=$rowj['id_account'] AND $rowj['gmlvl']==0 and $userlvl==0) {
			
				if ($_SERVER['REQUEST_METHOD']=='POST') {
					if (mysql_query("INSERT INTO forum_reports(id_post, id_account, reason) VALUES ('".$_REQUEST['r']."','".$_SESSION['userid']."','".$_POST['message']."')", $MySQL_CON)) {
						echo '<br><br><br><br>';
						goodborder('Reply Sent Successfuly.<META HTTP-EQUIV="Refresh" CONTENT="1; URL=?n=forums&t='.$_REQUEST['t'].'">');
						echo '<br><br><br><br>';
						unset($_POST['message']);
					} else  {
						errborder('Couldn\'t Send the Report.');
						echo '<br>';
						$forceshow=true;
					}
				} else {
					
					$forceshow=true;
				}
			
			} else {
				echo '<br><br><br><br>';
				errborder('You are not allowed to Report this Reply.');
				echo '<br><br><br><br>';
				$forceshow=false;
			}

			if ($forceshow==true) {
				?>
			<form name="postForm" id="postForm" action="?n=forums&t=<?php echo $_REQUEST['t']; ?>&post=report&r=<?php echo $_REQUEST['r']; ?>" method="post" onsubmit="javascript: return checkPostForm();">
			<input type=hidden name="newpost" value='post'>
			<script>
			function checkPostForm() {
				return true;
			}
			</script>
			<div id="post" align=center>
				<div class="post-box">
					<div class="post-box-bottom">
						<div class="post-box-top">
			<div id="post-topic-shell">
				<div class="resultbox">
							<div id="postdisplay">
								<div class="border">
									<div class="insert">
								<blockquote>
									<div class="post-top">
					<br/>
					<!-- end admin-container -->
					<br><br>
					<!-- end subject-box -->
						
					<!-- end subject-message -->

					</div><!-- end subject-container -->
					<div class="message-container">

						<div class="message-body-main">
							<div class="message-bottom">

								<div class="message-top">
								<h2><span>Message:</span></h2>
									
									<textarea maxlength=255 name="message" id="message" tabindex="4" rows="5" cols="10" class="post-message-text"><?php echo $_POST['message'] ?></textarea>
									
									
								</div>	
							</div>
						</div>
						
					</div>
					<div align=right style="position:relative; right: 45px;"><input style="width: 90px; height: 30px;" type=submit value="Send"><br><br></div>
									</div><!-- end post-top -->
								</blockquote>
									</div><!-- end insert -->

								</div><!-- end border -->
							</div><!-- end postdisplay -->
						</div><!-- end resultbox -->
					</div><!-- End div postshell -->
								</div><!-- end post-box-top -->
							</div><!-- end post-box-bottom -->
						</div><!-- end post-box -->
					</div><!-- end post -->
					</form>

					<div id="postbackground">
						<div class="right">

					<!-- Edit/Quoted/Reply Post -->
					</div></div>
					<div class="forum-index">
						<div class="findex">
						<a href="?n=forums"><img src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/forum-index.gif" width="104" height="41" border="0" alt="forum-index" title="Forum Index" /></a>
						</div>
					</div>
				<?
			}
			
		} else {
			echo '<br><br><br><br>';
			errborder('Invalid Function!');
			echo '<br><br><br><br>';
		}

} else {

function imecho($mail='',$name='') {
	if ($mail!='') {
		echo '<div class="userpanel2" style="position: relative; float: right;">		
						<a href="mailto:'.$mail.'"><img border=0 src="new-hp/images/im/im_'.$name.'.gif" onmouseover="ddrivetip(\''.$name.': '.$mail.'\',\'#ffffff\');" onmouseout="hideddrivetip()" alt="view posts by this user"></a>
					</div>';
	}
} ?>

<table cellspacing="0" cellpadding="1" border="0" width="100%" class="board-clear">

	<tr>
		<td class="tableoutline">
	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="tableoutline">
		<tr>
			<td align=center>
<div class="theader">
	<div class="lpage-thread">
		<div id="topicview" style="font-weight: normal;">
			<ul>
			
				<?php if($rowz['st']=='0' AND $rowz['poll']=='') { ?><li><span title="General Thread"><img src="new-hp/images/forum/icons/index-icon.gif" width="14" height="15" border="0" alt= "General Thread" /></span></li><?php } ?>
				<?php if((($rowz['ftplvl'][$k]>0 AND $userlvl<0) OR ($rowz['ftplvl'][$k]>$userlvl AND $userlvl>=0)) OR (($rowz['postlevel'][$k]>0 AND $userlvl<0) OR ($rowz['postlevel'][$k]>$userlvl AND $userlvl>=0))) { ?><li><span title="Locked Thread"><img src="new-hp/images/forum/icons/lock-icon.gif" alt="Locked Thread" border="0" height="16" width="15"></span></li><?php } ?>				
				<?php if($rowz['st']=='1') { ?><li><span title="Sticky thread"><img src="new-hp/images/forum/icons/sticky.gif" alt="Sticky thread" border="0" height="15" width="22"></span></li><?php } ?>
				<?php if($rowz['poll']!='') { ?><li><span title="Poll thread"><img src="new-hp/images/forum/icons/poll.gif" alt="Sticky thread" border="0" height="15" width="22"></span></li><?php } ?>
				
<?php
if ($_REQUEST['p']=='' OR alphanum($_REQUEST['p'],true,false)==false) { $_REQUEST['p']=1; }

$topicid =  mysql_query("SELECT *,  DATE_FORMAT(CONVERT_TZ(CONCAT(`date`, ' ', `hour`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".$usergmt."'), '%d-%m-%Y') as date,
						DATE_FORMAT(CONVERT_TZ(CONCAT(`date`, ' ', `hour`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".$usergmt."'), '%H:%i %p') as houri,
						TIMESTAMPDIFF(MINUTE, CONCAT(`date`, ' ', `hour`), NOW()) as datei,
						DATE_FORMAT(fa.bday, '%d/%m/%Y') as bday, TIMESTAMPDIFF(YEAR, fa.bday, NOW()) as bage, fa.ismvp as ismpv,
						fa.displayname as dn, fa.avatar as avatar, fa.signature as signature, a.gmlevel as gmlvl, a.username
						FROM forum_posts fp
						LEFT JOIN (account a) ON a.id = fp.id_account
						LEFT JOIN (forum_accounts fa) ON fa.id_account = fp.id_account
						WHERE id_topic='".$_REQUEST['t']."'
						ORDER BY `id_post` ASC
						LIMIT " .(($_REQUEST['p']-1)*$tppage). ", ".$tppage, $MySQL_CON) or die (mysql_error());
$i=2;
$j=0;

while ($rowm = mysql_fetch_array($topicid)) {

	$avatar = explode('/', $rowm['avatar']);
	if ($avatar[0]!='gm' AND $avatar[0]!='mvp' AND $avatar[0]!='nochar') {
		$qquery = mysql_query("SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
			rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (`realm_settings` rs) ON r.id = rs.id_realm 
			WHERE r.id='".$avatar[1]."' GROUP BY r.id ORDER BY r.name", $MySQL_CON) OR DIE(mysql_error());
			if (mysql_num_rows($qquery)==1) {
				$rowg = mysql_fetch_array($qquery);
				$newcon = @mysql_connect($rowg['rsdbhost'].':'.$rowg['rsdbport'], $rowg['rsdbuser'], $rowg['rsdbpass']);;
				$newdb = @mysql_select_db ($rowg['rsdbname'], $newcon);
				$newquery = @mysql_query("SELECT c.name as name, data, class, race, g.name as guild
										FROM `characters` c
										LEFT JOIN guild_member gm ON gm.guid = c.guid 
										LEFT JOIN guild g ON g.guildid = gm.guildid
										WHERE `account`='".$rowm['id_account']."' AND c.guid=".$avatar[0]." GROUP BY c.guid", $newcon) OR DIE (mysql_error());
				if (mysql_num_rows($newquery)==1) {
					$rowc = @mysql_fetch_array($newquery);
					$rowc['data'] = explode(' ',$rowc['data']);		
					$char_gender = str_pad(dechex($rowc['data'][36]),8, 0, STR_PAD_LEFT);
					$char_gender = $char_gender{3};		
					$charset[0]=$rowc['name'];
					$charset[1]=$rowc['data'][34];
					$charset[2]=$rowc['race'];
					$charset[3]=$char_gender;
					$charset[4]=$rowc['class'];
					$charset[5]=$rowg['name'];
					$charset[6]=$rowc['guild'];
					$charset[7]=$rowc['data'][1416];
				} else {
					resetavatar($rowm['id_account']);
					$rowm['avatar']='nochar';
					unset($charset);
				}
			} else {
				resetavatar($rowm['id_account']);
				$rowm['avatar']='nochar';
				unset($charset);
			}
		@mysql_select_db($MySQL_Set['DBREALM'], $MySQL_CON);
	} else if (($avatar[0]=='gm' AND $rowm['gmlevel']>0) OR ($avatar[0]=='mvp' AND $rowm['ismvp']=='1')) {
		if (!file_exists('new-hp/images/forum/portraits/'.$rowm['avatar'])) {
			resetavatar($rowm['id_account']);
			$rowm['avatar']='nochar';
			unset($charset);
		}
	} else {
		resetavatar($rowm['id_account']);
		$rowm['avatar']='nochar';
		unset($charset);
	}	
					
$j++;
if ($i=='2') { $i='1'; } else { $i='2'; }
	if ($j==1) {
		if ($rowz['postlevel']>$rowm['postlevel']) { $rowm['postlevel']=$rowz['postlevel']; }
?>
				<li><span title="<?php echo $rowz['ttitle']; ?>" class="white"><small><b>&nbsp;Topic&nbsp;<a href="?n=forums&t=<?php echo $rowz['id_topic']; ?>" class="active"><?php echo $rowz['ttitle']; ?></a></b></span></li>
				<li><span title="Current Time" class="white">&nbsp; | &nbsp;<?php echo $rowm['date'].' at '.$rowm['houri']; ?>&nbsp;</small></span></li>
				
			</ul>
			
		</div><!-- end topicview -->		
	</div><!-- end lpage-thread -->
	
	<div class="rpage-thread">
	<? 
	$qqueryb =  mysql_query("SELECT id_topic FROM `forum_posts` WHERE `id_topic`='".$_REQUEST['t']."'", $MySQL_CON) or die (mysql_error());
	$pagination = '<table cellpadding = "0" cellspacing = "0" border = "0"><tr>'. pages($_REQUEST['p'], mysql_num_rows($qqueryb), $tppage, '?n=forums&t='.$_REQUEST['t'], '&nbsp;.&nbsp;', $arrows=true).'</tr></table>';
	echo $pagination;
				?>
	</div><!-- end rpage-thread -->
</div><!-- end theader -->

<div id="postbackground" align=center>
	<div class="right">
		<?php if ($haserrors!='') { echo errborder($haserrors); } ?>
		<?php if ($rowz['poll'] != '') { 
		
			$qpoll =  mysql_query("SELECT id_poll, name FROM forum_rel_topics_polls WHERE id_topic='".$_REQUEST['t']."' ORDER BY id_poll", $MySQL_CON) or die (mysql_error()); 
			$rowj=mysql_num_rows(mysql_query("SELECT * FROM forum_rel_account_polls ap
				LEFT JOIN (forum_rel_topics_polls tp) ON ap.id_poll = tp.id_poll
				WHERE tp.id_topic='".$_REQUEST['t']."' AND ap.id_account='".$_SESSION['userid']."' GROUP BY tp.id_topic", $MySQL_CON));
		?>
<div id = "postshell<?php echo $i; ?>1">
	<div class = "resultbox">
		<div class="postdisplay">
			<div class = "border">
				<div class = "postingcontainer<?php echo $i; ?>1" style="background: none; background-color: #191919;">

		<div align=center><small><br></small>
			<div class="options-container" style="background-color: #222222;"><!-- POLL!-->
				<div style="position: absolute;">
					<img src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/poll.gif">
				</div>
				<div class="options-left">
					<div class="options-right" align=left>
						
						<div class="options-bot" style="height: <?php echo (140+$sc+(mysql_num_rows($qpoll))*30) ?>px;">
							<div style="color: #FFFFFF; text-align: right; width: 620px; position: absolute;">
								<br>
								<small><?php 
									$pollcalc = mysql_fetch_array(mysql_query("SELECT TIMESTAMPDIFF(MINUTE, NOW(), INTERVAL ".$rowz['poll_lasts']." DAY + '".$rowz['poll_stamp']."')"));
									if ($rowz['poll_lasts']==0) {
										echo 'This Poll Never Ends';
									} else if ($pollcalc[0]>0){
										echo 'This Poll Ends in '.convdate($pollcalc[0]);
									} else { 
										echo 'This Poll Ended '.convdate($pollcalc[0]).' Ago';
									}  ?></small>
							</div>
							<div class="options-top">
								<div class="sig-options" style="width: 600px;" align=center>
								<br><br>
								<span class="help-tip">
								<?php
								
								if ($rowj==0 AND isset($_SESSION['userid'])) {
								?>
								<script>
								function va_vote(btn) {
									    var cnt = false;
										for (var i=0; i < btn.length; i++) { 
											if (btn[i].checked) { cnt = true; break; }
										}
									
										if (cnt == false) { alert('Please, select an option!'); return false; } 
										else { return true; }
								}
								</script>
								<form name="fpoll" method=post action="?n=forums&t=<?php echo $_REQUEST['t']; ?>" onSubmit="return va_vote(this.rpoll);">
								<table cellpadding=3 cellspacing=3 border=0 style="color: white;">
									<tr>
										<td align=center style="font-weight: bold;" colspan=2><?php echo $rowz['poll']; ?><br>
										<img src="new-hp/images/pixel.gif" height=3><br>
										<img src="new-hp/images/pixel.gif" style="background-color: orange; width: 270px; height: 1px"></td>
									</tr>
									<?
									while ($rowpoll = mysql_fetch_array($qpoll)) {
										echo '<tr><td><input type=radio id="rpollid'.$rowpoll['id_poll'].'" name="rpoll" value="'.$rowpoll['id_poll'].'"><label for="rpollid'.$rowpoll['id_poll'].'">&nbsp;&nbsp;'.$rowpoll['name'].'</label><br></td></tr>';
									}
									?>
									<tr>
										<td align=center><input type=submit value="Vote"></td>
									<tr>
								</table>
								</form>
								<? } else { ?>
									<table cellpadding=3 cellspacing=3 border=0 style="color: white;">
									<tr>
										<td align=center style="font-weight: bold;" colspan=2><?php echo $rowz['poll']; ?><br>
										<img src="new-hp/images/pixel.gif" height=3><br>
										<img src="new-hp/images/pixel.gif" style="background-color: orange; width: 270px; height: 1px"></td>
									</tr>
									<?
									$pollcount=mysql_query("SELECT ap.id_poll as id_poll FROM forum_rel_topics_polls tp
															LEFT JOIN (forum_rel_account_polls ap) ON ap.id_poll = tp.id_poll
															WHERE tp.id_topic='".$_REQUEST['t']."'", $MySQL_CON) or die (mysql_error());
									while ($rowpoll = mysql_fetch_array($pollcount)) {
										if ($rowpoll['id_poll']!='') { 
											$totalpoll+=1;
											$newpoll[$rowpoll['id_poll']]+=1;
										}										
									}
									while ($rowpoll = mysql_fetch_array($qpoll)) { 
										echo '<tr><td>'.$rowpoll['name'].' (';
										echo $newpoll[$rowpoll['id_poll']]?$newpoll[$rowpoll['id_poll']]:'0';
										echo ')<br></td><td width=10 align=right>';
										echo $newpoll[$rowpoll['id_poll']]?round($newpoll[$rowpoll['id_poll']]/$totalpoll*100, 0):'0';
										echo '%</td></tr>';
									}
									?>
									<tr>
										<td align=center colspan=2><small><br><?php echo isset($_SESSION['userid'])?'You already voted in this topic.':'You must be logged in order to vote!'; ?><small></td>
									<tr>
								</table>
								<? } ?>
								</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		

				</div>
			</div>
		</div>
	</div>
</div>
		<?php } ?>
<!-- Main Post Body -->
<?php } ?>
<a name="<?php echo $rowm['id_post']; ?>"></a>


<div id = "postshell<?php echo $i; ?>1">
	<div class = "resultbox">
	
<?php  if ($avatar[0]=='nochar') { ?>
<style>
div.framenochar<? if ($rowm['gmlevel']>0) { echo 'blizz'; } ?> { 
	background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/no-character-icon<?php  if ($rowm['gmlevel']>0) { echo '-blizz'; } ?>.gif');
}
</style>
<? } ?>
		<div class="postdisplay">
			<div class = "border">
				<div class = "postingcontainer<?php echo $i; ?>1">
					<div class = "insert">
<table id = "posttable<?php echo $i; ?>1" cellpadding = "0" cellspacing = "0">
	<tr>
		
		<td class = "id<? if ($rowm['gmlevel'] > 0 ) { echo 'bliz'; }  else if ($rowm['ismvp'] > 0 ) { echo 'mvp'; }  ?><?php echo $i; ?>1" rowspan = "2" valign=bottom>
<!-- Begin Avatar Panel -->
<div>
	<div id="avatar<?php echo $i; ?>1">

		<div class="shell">
			<table cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td style="background: url(new-hp/images/forum/portraits/<? 
					if ($rowm['avatar']!='nochar' AND $avatar[0]!='gm' AND $avatar[0]!='mvp') {
						if ($charset[1]=='70') { echo 'wow-70/'; }
						else if ($charset[1]>='60') { echo 'wow/'; }
						else { echo 'wow-default/'; }
						echo $charset[3].'-'.$charset[2].'-'.$charset[4].'.gif';
					} else {
						echo $rowm['avatar'];
					} ?>); width: 64px; height: 64px; vertical-align: bottom;">
					</td>
				</tr>
			</table>
			<div class="frame<?php if ($rowm['avatar']=='nochar') { echo 'nochar'; if ($rowm['gmlevel']>0) { echo 'blizz'; } }?>">
			
				<a href="#armory=<? echo $rowm['id']; ?>" target="_blank"><img src="new-hp/images/forum/pixel.gif" width="82" height="83" border="0" alt="" /></a>
			
			</div>
		</div><!-- end shell -->
		<div style="position: relative;">
			<div class="iconPosition">
			
				<b><small><?php 
				if ($rowm['avatar']!='nochar' AND $avatar[0]!='gm' AND $avatar[0]!='mvp') {
					echo $charset[1];
				} else if (($rowm['avatar']=='nochar' OR $avatar[0]=='gm') AND $rowm['gmlevel']>'0') {
					echo '<img src="new-hp/images/forum/icons/blizz.gif">';
				} else if (($rowm['avatar']=='nochar' OR $avatar[0]=='mvp') AND $rowm['ismvp']=='1') {
					echo '<img src="new-hp/images/forum/icons/modr-small.gif">';
				}
				?></small></b>
			
			</div>
		
<!-- //Begin Character ID Panel// -->		
			
				<? if ($rowm['avatar']!='nochar' AND $avatar[0]!='gm' AND $avatar[0]!='mvp') { ?><div id="iconpanelhide<?php echo $i; ?>1">
					<div id="iconpanel"></div>

						<div id="default-icon-panel">
						<div class="player-icons-race" style="background: url('new-hp/images/forum/icons/race/<?php echo $charset[2].'-'.$charset[3]; //RACE, GENDER  ?>.gif') no-repeat;" onmouseover="ddrivetip('<b><?php echo $CHAR_RACE[$charset[2]][0]; ?></b>','#ffffff');" onmouseout="hideddrivetip()">
						<img src = "new-hp/images/forum/pixel.gif" height="18" width="18" alt="" />
						</div>						
						<div class="player-icons-class" style="background: url('new-hp/images/forum/icons/class/<?php echo $charset[4]; //CLASS ?>.gif') no-repeat;" onmouseover="ddrivetip('<b><?php echo $CHAR_CLASS[$charset[4]]; ?></b><br><i>Click to View Talent Build</i>','#ffffff');" onmouseout="hideddrivetip()">						
						
						<a href="#armory" target="_blank"><img src="new-hp/images/forum/icons/icon-active.png" alt="" class="png" border="0" height="18" width="18" /></a>
						</div>						
							
																					
						<div class="player-icons-pvprank" style="background: url('new-hp/images/forum/icons/pvpranks/rank<?php echo pvp_ranks($charset[7],$CHAR_RACE[$rowc['race']][1]); //RANK ?>.gif') no-repeat;" onmouseover="ddrivetip('<b>Rank: <?php echo $CHAR_RANK[$CHAR_RACE[$rowc['race']][1]][pvp_ranks($charset[7])]; //RANK ?></b><br><i>Lifetime Highest PvP Rank</i>','#ffffff');" onmouseout="hideddrivetip()"></div>
						
						</div>
					</div><? } ?>
			
		</div><!-- end shell -->
	</div><!-- end avatar collapse -->
</div><!-- end avatar -->
<!-- //End Avatar Panel// -->

<!-- //Begin Character Control Panel// -->

<div style="position: relative; width: 200px;">
	<div  class="userpanel">		
		<a href="#"><img class="icon-search" src="new-hp/images/forum/icons/search.gif" onmouseover="ddrivetip('View All Posts by This User','#ffffff');" onmouseout="hideddrivetip()" alt="view posts by this user"></a>
		<!--<a href="javascript: collapse(648806676);"><img class="icon-ignore" src="new-hp/images/forum/icons/ignore-user.gif" id="ignore976013081_648806676_switch1" onmouseover="ddrivetip('Toggle Ignore / Unignore This User','#ffffff');" onmouseout="hideddrivetip()" alt="ignore" /></a>-->
	</div>
</div>
<?php if ($rowm['username']!='') { ?>
<div style="position: relative; width: 200px; top: 36px;">
	<div  class="userpanel3" style="padding: 7px 5px 0px 0px;">
	<? if  (@mysql_num_rows(@mysql_query("SELECT id FROM web_online WHERE id='".$rowm['id_account']."'", $MySQL_CON))>0) { ?>
		<img src="new-hp/images/favicon.gif" width=16 height=16 border=0 onmouseover="ddrivetip('On-Line','#ffffff');" onmouseout="hideddrivetip()" alt="view posts by this user">
	<? } else { ?>
		<img src="new-hp/images/favicon-bnw.gif" border=0 onmouseover="ddrivetip('Off-Line','#ffffff');" onmouseout="hideddrivetip()" alt="view posts by this user">
	<? } ?>
	</div>
</div>
<?php } ?>


<!-- End Character Control Panel -->
<!-- Begin Character Information Display -->
<div style="position: relative; width: 200px;">
<? if (($avatar[0]!='gm' AND $avatar[0]!='nochar')  OR ($avatar[0]=='nochar' AND $rowm['gmlevel']<'1')) { ?>

<div class="pinfo">
	<div id="pinfobackground_switch<? echo $i; ?>" class="pinfobackground">

	<span style="font-size: 12px; line-height: 1.8em; color: white;"><b style="color:#ffac04;"><a href="#armory" target="_blank" <? if ($charset[0]!='') { echo 'onmouseover="ddrivetip(\''.$rowm['dn']; if ($rowm['gmlevel']>0) { echo ' <img src=new-hp/images/forum/icons/blizz.gif>'; } echo '\',\'#ffffff\');" onmouseout="hideddrivetip()"'; } ?>><?php if ($charset[0]!='') { echo $charset[0]; } else { echo $rowm['dn']; } ?></a></b><br>
	<?php if ($rowm['username']=='') { echo '<a href="#">Ghost Account</a>'; } ?>
	<?php if ($charset[6]!='') { ?><b><a href="#armory" target="_blank">&lt; <?php echo $charset[6]; //Guild ?> &gt;</a></b><br><?php } ?>

	<b><?php echo $charset[5]; ?></b></span>

	</div><!-- end pinfobackground -->
	</div><!-- end pinfo -->
	<div>
		<div class="pinfobottom">
			<div class="pifooter"></div>
		</div>
	</div>

<? } else { ?>
	
		<div style="padding-top: 5px;"></div>
			
	<span><b style="color:#ffac04; font-size:12;"><?php echo $rowm['dn'] ?></b></span>
	
	<div id="afterAvatar_switch<?php echo $i; ?>">
		
			<small><span class="blue"><?php if ($rowm['id_account']==$SETTING['SERVER_OWNER']) { echo 'Owner'; } else { echo $USER_LEVEL[$rowm['gmlevel']]; } ?></span></small>

	</div>

<? } ?>
</div>
<!-- //End Character Display// --><!-- //grabs character info -->
	<?php if ($rowm['bday']!='00/00/0000' AND $rowm['showbday']>'0' OR $rowm['showlocation']>'0') { ?>
	<div style="position: relative; color: white; font-size: 11px; left: 15px" align=left>
		<br>
		<table cellpadding=0 cellspacing=0 border=0>
		<?php 
			if ($rowm['bday']!='00/00/0000' AND $rowm['showbday']>'0') {
				echo '<tr><td colspan=2 style="color: white; font-size: 12px; vertical-align: middle">';
				if ($rowm['showbday']=='2') { echo $rowm['bage'].' years'; }
				else if ($rowm['showbday']=='1') { echo $rowm['bday']; }
				else if ($rowm['showbday']=='3') { echo $rowm['bday']. ', ' .$rowm['bage'].' years'; }
				echo '</td></tr>';
			}
			if ($rowm['showlocation']>'0') { 
				echo '<tr><td style="color: white; font-size: 12px; vertical-align: middle">'.$rowm['city'].', '. $COUNTRY[$rowm['location']].'</td>
				<td><img src="new-hp/images/pixel.gif" style="background: url(new-hp/images/flags/'.$rowm['location'].'.gif) no-repeat 0px -6px;" width=32 height=20></td></tr>'; 
			}
			$ttpost=@mysql_num_rows(@mysql_query("SELECT id_post FROM forum_posts WHERE id_account='".$rowm['id_account']."'", $MySQL_CON));
			echo '<tr><td colspan=2 style="color: white; font-size: 12px; vertical-align: middle">Posts: '.number_format ($ttpost).'<td></tr>';
		?>
		</table>
	</div>
	<?php } ?>
	<?php if ($rowm['msn']!='' OR $rowm['yahoo']!='' Or $rowm['skype']!='' Or $rowm['aim']!='' or $rowm['icq']!='') { ?>
	<div style="position: relative; color: white; font-size: 11px" align=center>
		<? if ($rowm['msn']!='') { imecho($rowm['msn'],'MSN'); }
			if ($rowm['skype']!='') { imecho($rowm['skype'],'Skype'); } 
			if ($rowm['yahoo']!='') { imecho($rowm['yahoo'],'Yahoo'); } 
			if ($rowm['icq']!='') { imecho($rowm['icq'],'ICQ'); } 
			if ($rowm['aim']!='') { imecho($rowm['aim'],'AIM'); } 
		?>
		<br>
	</div>
	<?php } ?>
	</td>

		<td class = "tools<?php echo $i; ?>1" style="height: 32px;">
			<!-- Begin Post Info -->
<div id="postid<?php echo $i; ?>1">
	<ul>
		<li style="display:table-cell;"><a href="#<?php echo $rowm['id_post']; ?>" style="font-size: 12px; color: white; text-decoration: none;"><span><? echo ($j + (($_REQUEST['p']-1)* $tppage)); ?>.&nbsp;&nbsp;|&nbsp;&nbsp;<? echo $rowm['date']. ' at '.$rowm['houri']; ?></span></a></li>
	</ul>
</div>

<!-- End Post Info --><!-- //grabs post title info -->
			
<!-- Begin Post Control Panel -->

<div class="miniadmin">
	<ul>
		
	
	<!-- Post Admin -->
	<?php if ($rowm['gmlevel']>'0') {
	
			$blizzreply = mysql_query("SELECT id_post, a.gmlevel as gmlvl FROM `forum_posts` fp
											LEFT JOIN (`account` a) ON fp.id_account = a.id
											WHERE fp.id_post>'".$rowm['id_post']."' AND fp.id_topic='".$_REQUEST['t']."'
											ORDER BY `id_post` ASC", $MySQL_CON) or die (mysql_error());
			$iblizz=0;
			while ($rowblizz =  mysql_fetch_array($blizzreply)) {
				$iblizz++;
				if ($rowblizz['gmlvl']>0) {
					$totalpages=($iblizz+$j)/$tppage;
					$totalpages=explode(".", $totalpages);
					if ($totalpages[1]!=0) { $totalpages[0]+=1; }
					echo '<a href="';
					if ($_REQUEST['p']!=$totalpages[0]) { echo '?n=forums&t='.$_REQUEST['t'].'&p='.$totalpages[0]; }
					echo '#'.$rowblizz['id_post'].'"><img src="new-hp/images/forum/icons/blizz-post.gif" border="0" title="Next Blizzard Post" alt="quote" /></a>';
					break;
				}
			}
		}
		  if ($rowz['ftplvl']<=$userlvl AND $rowz['postlevel']<=$userlvl) {  
			if ($rowm['gmlevel']=='0' AND $rowm['id_account']!=$_SESSION['userid'] AND $userlvl==0) { ?>
			<a href="?n=forums&t=<?php echo $_REQUEST['t']; ?>&post=report&r=<?php echo $rowm['id_post']; ?>"><img src="new-hp/images/forum/biohazard-button.gif" border="0" title="Quote this post" alt="quote" /></a>
		<?php }
		    if ($_SESSION['userid']==$rowm['id_account'] AND ($SETTING['USER_EDIT_OWN_POSTS']=='1' OR ($SETTING['USER_EDIT_OWN_POSTS']=='2' AND $j==mysql_num_rows($qqueryb))) OR $userlvl>0) { ?>
			<a href="?n=forums&t=<?php echo $_REQUEST['t']; ?>&<?php if ($rowm['isreply']=='0') { echo 'topic'; } else { echo 'post'; } ?>=edit&r=<?php echo $rowm['id_post']; ?>"><img src="new-hp/images/v2/edit.gif" border="0" title="Edit this Reply" alt="quote" /></a>
		<? 
		   }
		   if ($_SESSION['userid']==$rowm['id_account'] AND ($SETTING['USER_REMOVE_OWN_POSTS']=='1' OR ($SETTING['USER_REMOVE_OWN_POSTS']=='2' AND $j==mysql_num_rows($qqueryb))) OR $userlvl>0) { ?>
			<a href="?n=forums&t=<?php echo $_REQUEST['t']; ?>&post=remove&r=<?php echo $rowm['id_post']; ?>"><img src="new-hp/images/v2/remove.gif" border="0" title="Remove this Reply" alt="reply" /></a>
		<? }?>
		<a href="?n=forums&t=<?php echo $_REQUEST['t']; ?>&post=new&q=<?php echo $rowm['id_post']; ?>"><img src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/quote-button.gif" width="63" height="18" border="0" title="Quote this post" alt="quote" /></a>
		<a href="?n=forums&t=<?php echo $_REQUEST['t']; ?>&post=new"><img src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/reply-button.gif" width="63" height="18" border="0" title="Reply to this post" alt="reply" /></a>
	<?php } else { ?>
		<img src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/quote-button-inactive.gif" width="63" height="18" border="0" />
		<img src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/reply-button-inactive.gif" width="63" height="18" border="0"  />
	<?php } ?>
				
	</ul>		
</div>

<!-- End Post control Panel --><!-- //grabs moderator tools -->

		</td>
	</tr>
	<tr>
		<td class = "message<?php echo $i; ?>1">
			<table id="postbody<?php echo $i; ?>1" cellspacing="0" border="0">
	<tr>
		<td>
			<div class="breakWord">
				<div class="message-format">
				
				<span <? if ($rowm['gmlevel'] > 0 ) { echo 'class="blue"'; } else if ($rowm['ismvp'] > 0 ) { echo 'class="mvp"'; } ?> style="font-size: 12px;">
<?php
	$rowm['text'] = bbcode($rowm['text'],true,true,$rowm['isbbcode']);
	if ($_REQUEST['hl']!='') { $rowm['text'] = preg_replace('/'.$_REQUEST['hl'].'/is','<span class="highlight">'.$_REQUEST['hl'].'</span>', $rowm['text']); }
	echo $rowm['text'];
?>
<br><br>
<p><small><font color=red>
<?php
if ($rowm['id_account_edit']!='0' ) {
		if ($rowm['id_account_edit']!=$rowm['id_account']) { 
		$ltedit=mysql_query("SELECT DATE_FORMAT(CONVERT_TZ(CONCAT(`date_edit`, ' ', `hour_edit`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".$usergmt."'), '%d-%m-%Y') as date_edit, DATE_FORMAT(CONVERT_TZ(CONCAT(`date_edit`, ' ', `hour_edit`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".$usergmt."'), '%h:%i %p') as  hour_edit, a.gmlevel as gmlevel, fa.displayname as dn, fa.ismvp as ismvp FROM forum_posts fp
			LEFT JOIN (account a) ON a.id = fp.id_account_edit
			LEFT JOIN (forum_accounts fa) ON fa.id_account = fp.id_account_edit 
			WHERE fp.id_post='".$rowm['id_post']."'", $MySQL_CON)  OR DIE (mysql_error());
			if (@mysql_num_rows($ltedit)>0) {
				$ltedit=mysql_fetch_array($ltedit);
				?>
					[ <span <? if ($ltedit['gmlevel'] > 0 ) { echo 'class="blue"'; } else if ($ltedit['ismvp'] > 0 ) { echo 'class="mvp"'; } else { echo 'style="color: red"'; } ?>>Post edited by <? echo $ltedit['dn']; ?> in <? echo $ltedit['date_edit'].' at '. $ltedit['hour_edit'] ; ?> </span>]
				<? 
			}
		}  else { 
					?>
					[ <span <? if ($rowm['gmlevel'] > 0 ) { echo 'class="blue"'; } else if ($rowm['ismvp'] > 0 ) { echo 'class="mvp"'; } else { echo 'style="color: red"'; } ?>>Post edited by <? echo $rowm['dn']; ?> in <? echo $rowm['date_edit'].' at '. $rowm['hour_edit'] ; ?> </span>]
<?php 	} 
} 
?></small></font></p>
				<!--<p><small><font color="red">[ <span class="blue">Post edited by Syndri </span>]</font></small></p>-->
				<ins><hr noshade="noshade" size="1" color="#9e9e9e" /></ins></span>
				<div style="width: 100%; min-height: 50px; max-height: 170px; overflow: auto;"><span style="font-size: 12px;">
<?php
if ($rowm['issignature']=='1') {
	echo bbcode($rowm['signature']);
}
?></span></div>
				</div>
			</div>
			</div>

		</td>
	</tr>
</table>
		</td>
	</tr>
</table><!-- End table posttable -->

					</div><!-- end insert -->
				</div><!-- end innercontainer -->

			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div><!-- End div postshell -->
<?php /* */
}
?>
			</td>
		</tr>
	</table>

		</td>
	</tr>
</table>
<div id="topicfooter">
	<div class="rpage">
		<?php echo $pagination; ?>
	</div>
</div>
<div class="forum-index">
	<div class="findex">
		<a href="?n=forums"><img src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/forum-index.gif" width="104" height="41" border="0" title="" alt="" /></a>
	</div>

</div>
<div style="width: 100%; height: 20px;"></div>
	<div style="position: relative; width: 100%;">
		<div style="position: absolute; left: 20px; top: -78px;_top: -85px;">
				<span><small class="nav">Forum Nav :</small></span>

<small>
<select id="selectNavb" onchange="javascript:window.location='?n=forums&f=' + this.value" class="forum-dropdown" style="display:inline; width: 185px; margin-left: 10px;">							
<?php echo $GLOBALS['allf']; ?>
</select>
</small>	
<a href="#" onclick="javascript:window.location='?n=forums&f=' + selectNavb.value"><img src="new-hp/images/forum/jump-button.gif" alt="Jump To This Forum" width="21" height="19" border="0" style="margin-bottom: 3px;" align="top" title="Jump To This Forum"/></a>
		</div>
	</div>
<br clear="all" />
<? 
}
?>
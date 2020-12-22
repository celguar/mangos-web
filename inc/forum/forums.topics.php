<?php

if (INCLUDED!==true) { include('index.htm'); exit; }
?>
<style>
select.icon-menu option {
	background-repeat: no-repeat;
	background-position: center left;
	padding-left: 30px;
	padding-bottom: 12px;
}
</style>
<?php

if ($_REQUEST['topic']!='') {
	if ($_REQUEST['topic']=='new' OR ($_REQUEST['topic']=='edit' AND $_REQUEST['t']!='')) {
	
		$forceshow=true;
		
		if ($_REQUEST['topic']=='edit' AND $_SERVER['REQUEST_METHOD']!='POST') {
			$rowj=mysql_fetch_array(mysql_query("SELECT *, ft.title as title, ft.category as category, ft.image as image
						FROM forum_posts fp
						LEFT JOIN (forum_topics ft) ON ft.id_topic = fp.id_topic
						LEFT JOIN (account a) ON a.id = fp.id_account
						WHERE fp.id_topic='".$_REQUEST['t']."' AND fp.isreply='0'
						ORDER BY `id_post` ASC ", $MySQL_CON));
			$rowk=mysql_fetch_array(mysql_query("SELECT id_post FROM forum_posts WHERE id_topic='".$_REQUEST['t']."' ORDER BY `id_post` DESC LIMIT 0, 1", $MySQL_CON));
			if ($_SESSION['userid']==$rowj['id_account'] AND ($SETTING['USER_EDIT_OWN_POSTS']=='1' OR ($SETTING['USER_EDIT_OWN_POSTS']=='2' AND $rowk['id_account']==$_SESSION['userid'])) OR $userlvl>0) {
				
				$_POST['subject']=$rowj['title'];
				$_POST['message']=$rowj['text'];
				
				$_POST['viewlevel']=$rowj['viewlevel'];
				$_POST['postlevel']=$rowj['postlevel'];
				$_POST['issticked']=$rowj['issticked'];
				$_POST['category']=$rowj['category'];
				$_POST['posticon']=$rowj['image'];
				
				$_POST['pollask']=$rowj['poll_question'];
				if ($rowj['poll_question']!='') {
					$getvote = mysql_query("SELECT name FROM forum_rel_topics_polls WHERE id_topic='".$_REQUEST['t']."' ORDER by id_poll ASC", $MySQL_CON);
					while ($rowg=mysql_fetch_array($getvote)) {
						$_POST['polloption'][] = $rowg['name'];
					}
				}
				$_POST['pollfor']=$rowj['poll_lasts'];
				$_POST['issigned']=$rowj['issignature'];
				$_POST['isbbcode']=$rowj['isbbcode'];
			
			} else {
				echo '<br><br><br><br>';
				errborder('You are not allowed to Edit this Topic.');
				echo '<br><br><br><br>';
				$forceshow=false;
			}
		} else if ($_REQUEST['topic']=='new' AND $_SERVER['REQUEST_METHOD']!='POST') {
			$_POST['issigned']='1';
			$_POST['isbbcode']='1';	
		}
		?>
			<form name="postForm" id="postForm" action="<?php
		if ($_REQUEST['topic']=='new') {
			echo '?n=forums&f='.$_REQUEST['f'].'&topic=new';
		} else if ($_REQUEST['topic']=='edit') {
			echo '?n=forums&t='.$_REQUEST['t'].'&topic=edit&r='.$_REQUEST['r'];
		}
		?>" method="post">		
		<?php
		
		if ($_POST['viewlevel']!='' AND alphanum($_POST['viewlevel'], true, false)==false OR $_POST['viewlevel']=='') { $_POST['viewlevel']='-1'; }
		if ($_POST['postlevel'] < '0') { $_POST['postlevel'] = '0'; }
		if ($_POST['viewlevel'] > $_POST['postlevel']) { $_POST['postlevel'] = $_POST['viewlevel']; }
		if ($_POST['pollfor']=='') { $_POST['pollfor']='0'; }
		if ($_POST['issigned']=='') { $_POST['issigned']='0'; } else if ($_POST['issigned']!='0') { $_POST['issigned']='1'; }
		if ($_POST['isbbcode']=='') { $_POST['isbbcode']='0'; } else if ($_POST['isbbcode']!='0') { $_POST['isbbcode']='1'; }
		
		if ($_POST['newpost']=='post') {
			if (strlen($_POST['subject'])<5) {
				$haserrors.='Subject field must have more than 5 characters.<br>';
			} 
			if (strlen($_POST['message'])<5) {
				$haserrors.='Message field must have more than 5 characters.<br>';
			}
			if (strlen($_POST['pollask'])>0 AND strlen($_POST['pollask'])<3) {
				$haserrors.='Poll Question field must have more than 3 characters<br>';
			} else if (strlen($_POST['pollask'])>=3) {
				$j=0;
				for ($i=0;$i<count($_POST['polloption']);$i++) {
					if (strlen($_POST['polloption'][$i])>0) { $j++; }
				}
				if ($j<2) {
					$haserrors.='You need at least 2 Options fields filled in order to create a poll.<br>';
				}
				if ($_POST['pollfor']!='' AND alphanum($_POST['pollfor'],true,false)==false) {
					$haserrors.='Invalid value in a Poll Duration field.<br>';
				}
			}
			if ($haserrors=='') {
				if ($_REQUEST['topic']=='new') {
					if (strlen($_POST['pollask'])>0) { $pollstamp=date('y-m-d H:i:s'); } else { $pollstamp='0000-00-00 00:00:00'; }
					$query =  "INSERT INTO forum_topics(title, poll_question, poll_lasts, id_forum, poll_stamp";
					if ($userlvl>0) { $query .=  ", viewlevel, postlevel, issticked, category, image"; }
					$query .= ") VALUES('".$_POST["subject"]."','".$_POST["pollask"]."','".$_POST["pollfor"]."','".$_REQUEST["f"]."', '".$pollstamp."'";
					if ($userlvl>0) { $query .=  ",'".$_POST["viewlevel"]."','".$_POST["postlevel"]."',	'".$_POST["issticked"]."','".$_POST["category"]."',
											'".$_POST["posticon"]."'"; }
					$query .= ")";
					$query =  mysql_query($query, $MySQL_CON) OR DIE(mysql_error());
					$lasttopicid = mysql_insert_id($MySQL_CON);
					$query =  mysql_query("INSERT INTO forum_posts(text, date, hour, isreply, issignature, isbbcode, id_account, id_topic) 
										VALUES('".$_POST['message']."','".date('Y-m-d')."','".date('H:i:s')."', 0,
										'".$_POST['issigned']."','".$_POST['isbbcode']."','".$_SESSION['userid']."','".$lasttopicid."')", $MySQL_CON) OR DIE(mysql_error());
					if (strlen($_POST['pollask'])>0) {
						for($i=0;$i<(count($_POST['polloption']));$i++) {
							if (strlen($_POST['polloption'][$i])>0) {
								$query =  mysql_query("INSERT INTO forum_rel_topics_polls(id_topic, name) 
												VALUES('".$lasttopicid."','".$_POST['polloption'][$i]."')", $MySQL_CON) OR DIE(mysql_error());
							}
						}
					}
				} else if ($_REQUEST['topic']=='edit') {
					$query = "UPDATE forum_topics SET title='".$_POST["subject"]."'";
					if ($userlvl>0) { $query .= ", viewlevel='".$_POST["viewlevel"]."', postlevel='".$_POST["postlevel"]."', issticked='".$_POST["issticked"]."', 
							category='".$_POST["category"]."', image='".$_POST["posticon"]."'"; }
					$query .= "WHERE id_topic='".$_REQUEST['t']."'";
					$query =  mysql_query($query, $MySQL_CON) OR DIE(mysql_error());
					$query =  mysql_query("UPDATE forum_posts SET `text`='".$_POST['message']."', date_edit='".date('Y-m-d')."', 
										hour_edit='".date('H:i:s')."', id_account_edit='".$_SESSION['userid']."', 
										issignature='".$_POST['issigned']."', isbbcode='".$_POST['isbbcode']."' WHERE id_topic='".$_REQUEST['t']."' AND isreply=0", $MySQL_CON) OR DIE(mysql_error());
					if ($_POST['removepoll']=='1') { 
						mysql_query("DELETE FROM forum_rel_topics_polls WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON); 
						mysql_query("DELETE FROM forum_rel_account_polls WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON); 
						mysql_query("DELETE FROM forum_rel_account_polls WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON); 
						mysql_query("UPDATE forum_topics SET poll_question='', poll_lasts='0', poll_stamp='0000-00-00 00:00:00' WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON) OR DIE(mysql_error());
					} else {
						if (strlen($_POST['pollask'])>0) {
							$query =  mysql_query("UPDATE forum_topics SET poll_question='".$_POST["pollask"]."', poll_lasts='".$_POST["pollfor"]."' WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON) OR DIE(mysql_error());
						}
						if (strlen($_POST['pollask'])>0) {
							for($i=0;$i<(count($_POST['polloption']));$i++) {
								if (strlen($_POST['polloption'][$i])>0) {
									$query =  mysql_query("INSERT INTO forum_rel_topics_polls(id_topic, name) 
													VALUES('".$_REQUEST['t']."','".$_POST['polloption'][$i]."')", $MySQL_CON) OR DIE(mysql_error());
								}
							}
						}
					}

					$lasttopicid = $_REQUEST['t'];
				}
				viewedtopic($lasttopicid);
				
				unset($_POST['subject']);
				unset($_POST['message']);
				
				echo '<br><br><br><br>';
				goodborder('Your message has been entered successfully.<META HTTP-EQUIV="Refresh" CONTENT="1; URL=?n=forums&t='.$lasttopicid.'">');
				
				newrssfeed();
				
				$forceshow=false;
				echo '<br><br><br><br>';
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
			<div class="subject-container">

			<div class="subject-box">
				
				
				
				<div class="post-title"></div>

				
				
				<h1><span>Subject:</span></h1>
				
				<input name="subject" size="20" tabindex="3" maxlength="45" class="post-subject-field" value="<?php echo $_POST['subject']; ?>"/>
					
				
			</div>
			<!-- end subject-box -->
				
			<!-- end subject-message -->

			</div><!-- end subject-container -->
			<div class="message-container">
			<div class="post-ui-container">
				<div id="post-ui" style="width: 266px;">

					<div class="post-ui-left">
						<div class="post-ui-right"style="width: 266px;">
						<script language=javascript src="new-hp/js/quick_reply.js"></script>
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
							<li class="quote"><a href="javascript:edInsertTag(document.postForm.message, 8);"><img src="new-hp/images/forum/pixel.gif" alt="quote" onmouseover="ddrivetip('Quote','#ffffff')"; onmouseout="hideddrivetip()" /></a></li>
						</ul>
						</div>
					</div>
				</div>
			</div>
				<div class="message-body-main">
					<div class="message-bottom">

						<div class="message-top">
						<h2><span>Message:</span></h2>
							
							<textarea name="message" id="message" tabindex="4" rows="5" cols="10" class="post-message-text"><?php echo $_POST['message'] ?></textarea>
							
							
						</div>	
					</div>
				</div>
				
			</div><!-- end message-container -->
	<?php if ($userlvl>0) { ?>
			<div class="options-container">
				<div class="options-left">
					<div class="options-right">
				<?php 
				$sz=165;
				if ($_POST['category']=='1') { $sz+=35; } else if ($_POST['category']=='3')	 { $sz+=70; }
				?>
					<div class="options-bot" style="height: <?php echo $sz; ?>;">
						<div class="options-top" >
							<div class="sig-options" style="width: 500;" align=left>
								<span class="help-tip" style="font-size: 12px;">View Level:</span>&nbsp;&nbsp;
									<select name='viewlevel' onchange='document.postForm.newpost.value="viewlevel"; document.postForm.submit();'>
										<?php
										if ($userlvl > 3) { $ulvl = 3; } else { $ulvl=$userlvl; }
										for ($i=$rowz['viewlevel'];$i<=$ulvl;$i++) {
											echo '<option value="'.$i.'">'.$USER_LEVEL[$i];
										}
										?>
									</select><br><br>
									<script>
									<?php if ($_POST['viewlevel']!='') { ?> document.postForm.viewlevel.value = '<?php echo $_POST['viewlevel']; ?>';<?php } ?>
									</script>

									<span class="help-tip" style="font-size: 12px;">Post Level:</span>&nbsp;&nbsp;
										<select name='postlevel'>
										<?php
										if ( $_POST['viewlevel'] < $rowz['postlevel'] ) { 
											$postlvl = $rowz['postlevel']; 
										} else if ( alphanum($_POST['viewlevel'],true, false)==false OR $_POST['viewlevel'] < 0 OR $_POST['viewlevel'] == '' ) {
											$postlvl=0;
										} else if ( $_POST['viewlevel'] >= $rowz['postlevel'] ) { 
											$postlvl = $_POST['viewlevel']; 
										} else if ( $_POST['viewlevel'] >= $rowz['viewlevel'] ) { 
											$postlvl = $_POST['viewlevel']; 
										} else { 
											$postlvl = $rowz['viewlevel']; 
										}
										for ($i=$postlvl;$i<=$userlvl;$i++) {
											echo '<option value="'.$i.'">'.$USER_LEVEL[$i];
										}
										?>
										</select>
									<script>
									<?php if ($_POST['viewlevel']!='') { ?> document.postForm.postlevel.value = '<?php echo $_POST['postlevel']; ?>';<?php } ?>
									</script><br><br>
									<span class="help-tip" style="font-size: 12px;">Sticked:</span>&nbsp;&nbsp;
									<select name='issticked'>
										<option value='0' SELECTED>No
										<option value='1'>Yes
									</select>
									<script>
									<?php if ($_POST['viewlevel']!='') { ?> document.postForm.issticked.value = '<?php echo $_POST['issticked']; ?>';<?php } ?>
									</script><br><br>
									<span class="help-tip" style="font-size: 12px;">Category:</span>&nbsp;&nbsp;
									<select name='category' onchange='document.postForm.newpost.value="category"; document.postForm.submit();'>
										<option value='0'>None
										<option value='1'>News
										<option value='2'>Community
										<option value='3'>Contests
									</select>
									<script>
									<?php if ($_POST['viewlevel']!='') { ?> document.postForm.category.value = '<?php echo $_POST['category']; ?>';<?php } ?>
									</script>
		<?php if ($_POST['category']=='1') { ?>
						<br><br><div style="float: left;"><span class="help-tip">Choose Icon:</span>&nbsp;&nbsp;
						<select name='posticon' style="height:20px;" class="icon-menu" onchange='posticonex.src = "new-hp/images/icons/" + this.value;'>
							<?php
								foreach (glob('new-hp/images/icons/news-*.gif') as $tempname) {
									$tempname = str_replace(dirname($tempname).'/','',$tempname);
									echo '<option value="'.$tempname.' "style="background-image: url(new-hp/images/icons/'.$tempname.');">'.str_replace('.gif','',str_replace('news-','',$tempname));
								}
							?>
						</select>&nbsp;&nbsp;</div><div style="float: left;"><img name='posticonex' src=''></div>
						<script>
						<?php if ($_POST['viewlevel']!='') { ?> document.postForm.posticon.value = '<?php echo $_POST['posticon']; ?>';
						document.postForm.posticonex.src = "new-hp/images/icons/" + document.postForm.posticon.value;<?php } ?>
						</script>
		<?php } else if ($_POST['category']>='3') { ?>
						<span class="help-tip"><br><br>Starting Day:&nbsp;&nbsp;<input type=text value="" name="startdate" size=12 maxlength=10>&nbsp;&nbsp;(dd/mm/yyyy)<br><br>
				Ending Day:&nbsp;&nbsp;&nbsp;<input type=text value="" name="startdate" size=12 maxlength=10>&nbsp;&nbsp;(dd/mm/yyyy)</span>

		<?php } ?>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
<?php } 
	if ($userlvl>=$SETTING['USER_POLL']) {
?>
			<div class="options-container">
				<div style="position: absolute;"><img src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/poll.gif"></div>
				<div class="options-left">
					<div class="options-right" align=left>
						<?php
						$maxpolls=10;
						$sz=160;
						$_POST['newpost'] = explode('.',$_POST['newpost']);
						$remi = $_POST['newpost'][1];
						$_POST['newpost'] = $_POST['newpost'][0];
						$ap=0; 
						if ($_POST['newpost']=='addpoll' AND count($_POST['polloption'])<$maxpolls) { $ap=1; } 
						else if ($_POST['newpost']=='removepoll') { $ap=0; }
						@remove_array_item($_POST['polloption'], $remi);
						if (mysql_num_rows(mysql_query("SELECT poll_question FROM forum_topics WHERE id_topic='".$_REQUEST['t']."' AND poll_question!=''", $MySQL_CON))>0) { $showrempoll=true; $sz+=35; }
						?>
						<div class="options-bot" style="height: <?php if (count($_POST['polloption'])!=0) { echo (count($_POST['polloption'])*35+35+$sz); } else { echo '230'; }?>px;">
							<div class="options-top">
								<div class="sig-options" style="width: 500;">
								<br><br>
								<span class="help-tip">
<? if (mysql_num_rows(mysql_query("SELECT * FROM forum_rel_topics_polls ft LEFT JOIN (forum_rel_account_polls fa) ON fa.id_poll=ft.id_poll WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON))==0) { ?>
								
								Question:&nbsp;&nbsp;<input type="text" name="pollask" size=40 maxlength=45 value='<?php echo $_POST['pollask'];?>'><br><br>
								Option 1:&nbsp;&nbsp;<input type="text" name="polloption[]" size=30 maxlength=45 value='<?php echo $_POST['polloption'][0];?>'><br><br>
								Option 2:&nbsp;&nbsp;<input type="text" name="polloption[]" size=30 maxlength=45 value='<?php echo $_POST['polloption'][1];?>'><br><br>
								<?php
									for($m=2;$m<count($_POST['polloption'])+$ap;$m++) {
										echo 'Option '.($m+1); ?>:&nbsp;&nbsp;<input type="text" name="polloption[]" size=30 maxlength=45 value='<?php echo $_POST['polloption'][$m];?>'>&nbsp;&nbsp;<input onClick="javascript:document.postForm.newpost.value = 'removepoll.<?php echo $m; ?>';" type="submit" value='Remove Option'><br><br><?php
									}
								?>
								<?php if (count($_POST['polloption'])+$ap<$maxpolls) { ?><input onClick="javascript:document.postForm.newpost.value='addpoll';" type="submit" value='Add New Option'><?php } ?><br><br>
								Run poll for&nbsp;&nbsp;<input type="text" name="pollfor" size=2 maxlength=3 value='<?php echo $_POST['pollfor'];?>'>&nbsp;&nbsp;days. (Enter 0 or leave blank for a never-ending poll) <br><br>
								<? if ($_REQUEST['topic']=='edit' AND $showrempoll==true) { ?>Remove Poll:&nbsp;&nbsp;<input class="button" name="removepoll" type="checkbox" value="1"><?php } ?>
<? } else {
		echo 'Question: '.$_POST['pollask'].'<br><br>';
		for($i=0;$i<(count($_POST['polloption'])+$ap);$i++) {
			echo 'Option '.($i+1) . ': '. $_POST['polloption'][$i].'<br><br>';
		}
		if ($_POST['pollfor']==0) {	echo 'Poll never ends.';} 
		else { echo 'Run poll for '.$_POST['pollfor'].' days.'; }
		echo '<br><br><br>';
							
		echo 'Remove Poll:&nbsp;&nbsp;<input class="button" name="removepoll" type="checkbox" value="1">';
	}
?>
								</span>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
			<!-- end options-container -->
<?
}
?>
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
							<li><input type="image" class="button" src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/preview.gif" onClick="javascript: document.postForm.newpost.value = 'preview'"/></li>			
							<li><input type="image" class="button" src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/post.gif" onClick="javascript: document.postForm.newpost.value = 'post'"/></li>
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
</div>
<script>
document.postForm.issigned.checked=<?php echo $_POST['issigned']; ?>;
document.postForm.isbbcode.checked=<?php echo $_POST['isbbcode']; ?>;
</script>
		<?	
		}
	} else if ($_REQUEST['topic']=='remove') {
		
		$rowj=mysql_fetch_array(mysql_query("SELECT *, a.gmlevel as gmlvl
					FROM forum_posts fp
					LEFT JOIN (account a) ON a.id = fp.id_account
					WHERE id_topic='".$_REQUEST['t']."' AND isreply=0 
					ORDER BY `id_post` ASC ", $MySQL_CON));
		$rowk=mysql_fetch_array(mysql_query("SELECT id_post FROM forum_posts WHERE id_topic='".$_REQUEST['t']."' ORDER BY `id_post` DESC LIMIT 0, 1", $MySQL_CON));
		if ($_SESSION['userid']==$rowj['id_account'] AND ($SETTING['USER_REMOVE_OWN_POSTS']=='1' OR ($SETTING['USER_REMOVE_OWN_POSTS']=='2' AND $rowk['id_account']==$_SESSION['userid'])) OR $userlvl>0) {
		
			if ($_REQUEST['g']=='true') {
				if (mysql_query("UPDATE forum_topics SET id_forum_moved = '0' WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON)) {
					echo '<br><br><br><br>';
					goodborder('Ghost Topic Removed Successfuly.<META HTTP-EQUIV="Refresh" CONTENT="1; URL=?n=forums&f='.$rowz['id_forum'].'">');
					echo '<br><br><br><br>';					
				} else  {
					echo '<br><br><br><br>';
					errborder('Couldn\'t Remove Ghost Topic.');
					echo '<br><br><br><br>';

				}
				$forceshow=false;
			} else if ($_SERVER['REQUEST_METHOD']=='POST') {
				
				$qrem1 = mysql_query("DELETE FROM forum_topics WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON);
				$qrem = mysql_query("DELETE FROM forum_views WHERE id_topic NOT IN (SELECT id_topic FROM forum_topics)", $MySQL_CON);
				if ($qrem1) { mysql_query("DELETE FROM forum_posts WHERE id_topic NOT IN (SELECT id_topic FROM forum_topics)", $MySQL_CON);
					echo '<br><br><br><br>';
					goodborder('Topic Removed Successfuly.<META HTTP-EQUIV="Refresh" CONTENT="1; URL=?n=forums&f='.$rowz['id_forum'].'">');
					echo '<br><br><br><br>';

					newrssfeed();
					
				} else  {
					echo '<br><br><br><br>';
					errborder('Couldn\'t Remove Topic.');
					echo '<br><br><br><br>';

				}
			} else {
				$forceshow=true;
			}
		
		} else {
			echo '<br><br><br><br>';
			errborder('You are not allowed to Remove this Topic.');
			echo '<br><br><br><br>';
			$forceshow=false;
		}

		if ($forceshow==true) {
			?>
			<br><br><br><br>
			<div align=center><form method=post action='?n=forums&t=<?php echo $_REQUEST['t']; ?>&topic=<?php echo $_REQUEST['topic']; ?>'><div align=center style="width: 200px; border: 2px solid orange; color: white;"><br>You sure you want to Remove this Topic aswell as All Posts?<br><br>
			<input onclick="window.location='<?php echo $_SERVER['HTTP_REFERER']; ?>'" type=button value="No" style="width: 90px; height: 30px;" >&nbsp;&nbsp;<input type=submit value="Yes" style="width: 90px; height: 30px;" >
			<br><br></div></form></div>
			<br><br><br><br>
			<?
		}
		
	} else if ($_REQUEST['topic']=='move') {
	
		$rowj=mysql_fetch_array(mysql_query("SELECT * FROM forum_posts fp WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON));
		if ($rowj['postlevel']<=$userlvl AND $userlvl>1) {
			if ($_SERVER['REQUEST_METHOD']=='POST' AND $_POST['moveto']!='') {
				if ($_POST['lghost']=='1') {
					@mysql_query("UPDATE forum_topics SET id_forum_moved=id_forum WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON);
				} else {
					@mysql_query("UPDATE forum_topics SET id_forum_moved='0' WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON);
				}
				if (mysql_query("UPDATE forum_topics SET id_forum='".$_POST['moveto']."' WHERE id_topic='".$_REQUEST['t']."'", $MySQL_CON)){ 
					echo '<br><br><br><br>';
					goodborder('Topic Moved Successfuly.<META HTTP-EQUIV="Refresh" CONTENT="1; URL=?n=forums&f='.$_POST['moveto'].'">');
					echo '<br><br><br><br>';
				} else  {
					echo '<br><br><br><br>';
					errborder('Couldn\'t Move the Topic.');
					echo '<br><br><br><br>';
				}
			} else {
				$forceshow=true;
			}
		} else {
			echo '<br><br><br><br>';
			errborder('You are not allowed to Move this Topic.');
			echo '<br><br><br><br>';
			$forceshow=false;
		}
		
		if ($forceshow==true) {
			?>
			<br><br><br><br>
			<div align=center><form method=post action='?n=forums&t=<?php echo $_REQUEST['t']; ?>&topic=<?php echo $_REQUEST['topic']; ?>'><div align=center style="width: 200px; border: 2px solid orange; color: white;"><br>Move this Topic to:<br><br>
			<select name="moveto" class="icon-menu" style="height: 20px;">
			<?php
			$rowq=mysql_query("SELECT image, id_forum, title FROM forums WHERE id_forum!='".$rowz['id_forum']."' AND postlevel <= '".$userlvl."'", $MySQL_CON);
			while ($rowb = mysql_fetch_array($rowq)) {
				echo '<option value="'.$rowb['id_forum'].'" style="background: url(new-hp/images/forum/forumbullets/'.$rowb['image'].') no-repeat;  padding-left: 40px; padding-bottom: 26px;">'.$rowb['title'];
			}
			?>
			</select><br><br>
			<input type=checkbox value='1' name="lghost" id="idlghost"><label for="idlghost">Leave Ghost?</label><br><br>
			<input onclick="window.location='<?php echo $_SERVER['HTTP_REFERER']; ?>'" type=button value="Cancel" style="width: 90px; height: 30px;" >&nbsp;&nbsp;<input type=submit value="Move" style="width: 90px; height: 30px;" >
			<br><br></div></form></div>
			<br><br><br><br>
			<?
		}

	} else {
		echo '<br><br><br><br>';
		errborder('Invalid Function!');
		echo '<br><br><br><br>';
	}
			
} else {

//0 - Viewed | 1 - Unviewed | 2 - New | 3 - Update
$TOPIC_VIEW = array(
	0 => 'square-grey.gif',
	1 => 'square.gif', 
	2 => 'square-new.gif', 
	3 => 'square-update.gif'
);

function reorder($set) {
	if ($_REQUEST['z']=='desc') { echo 'asc'; } else { echo 'desc'; }
}

if ($_REQUEST['z']=='asc') { $_REQUEST['z']='desc'; } else { $_REQUEST['z']='asc'; }

if ($_REQUEST['sort']=='') { $_REQUEST['sort']='lastreply'; }
		?>
	
				<!--[if gt IE 6]>
				<div class="ie7margin"></div>
				<![endif]-->
				<table cellspacing="0" cellpadding="1" border="0" width="100%" class="board-clear">
					<tr>
						<td class="tableoutline">
					<table cellspacing="0"cellpadding="0" border="0" width="100%" class="tableoutline">
						<tr>
							<td  align=center>
							<div class="theader">
								<div class="lpage">
									<span>
				<?php
				if ($_REQUEST['p']=='' OR alphanum($_REQUEST['p'],true,false)==false OR $_REQUEST['p']=='0') { $_REQUEST['p']=1; }
				$qquery =  mysql_query("SELECT * FROM `forum_topics` ft WHERE ft.`viewlevel` <= '".$userlvl."' and (`id_forum`='".$_REQUEST['f']."' OR `id_forum_moved`='".$_REQUEST['f']."') ORDER BY issticked DESC, id_topic DESC", $MySQL_CON) or die (mysql_error());
				
				if (mysql_num_rows($qquery)>0) {
				?>
				
							<table cellpadding = "0" cellspacing = "0" border = "0" >
							<tbody>
								<tr>
									<td>
				<?php
				$qqueryb =  mysql_query("SELECT id_topic FROM `forum_topics` WHERE `viewlevel` <= '".$userlvl."' and `id_forum`='".$_REQUEST['f']."'", $MySQL_CON) or die (mysql_error());
				$pagination = pages($_REQUEST['p'], mysql_num_rows($qqueryb), $ttpage, '?n=forums&f='.$_REQUEST['f'], '&nbsp;.&nbsp;', $arrows=true);
				echo $pagination;
				?>
								</td></tr></tbody></table>
							</span>
							</div>
					<div class="rpage" style ="width: 250px;">
						<ul>
							<li>
								<select class="gray" id="ordertopics" onchange="javascript: window.location.href='?n=forums&f=<? echo $_REQUEST['f']; ?>&sort=<?php echo $_REQUEST['sort']; ?>&z='+this.value">
								<option value="asc" >Ascending</option>
								<option value="desc" SELECTED>Descending</option>
								</select>
							</li>
							<li>
								<select class="gray" id="sorttopics" onchange="javascript: window.location.href='?n=forums&f=<? echo $_REQUEST['f']; ?>&sort='+this.value+'&z=<?php reorder($_REQUEST['z']); ?>'">
								<option value="lastreply" SELECTED>Latest Reply</option>
								<option value="created">Creation Date</option>

								<option value="views"># of Views</option>
								<option value="replies"># of Replies</option>
								<option value="subject">Subject</option>
								<option value="author">Author</option>
								</select>&nbsp;
							</li>
							<li style="margin: 3px 2px 0pt 3px;">
								<span><b>Sort by:&nbsp;</b></span>
							</li>
						</ul>
					</div>
				</div>
<script>
	document.getElementById('ordertopics').value = "<? reorder($_REQUEST['z']); ?>";
	document.getElementById('sorttopics').value = "<? echo $_REQUEST['sort']; ?>";
</script>
				<div id="postbackground">
					<div class="right">
						<table width="90%" border="0" cellpadding="0" cellspacing="0" class="tableoutline" style="margin: 0 auto;">
						<tr>
						<td class="tableheader" style="text-align: center; width:120px;"><img SRC="new-hp/images/forum/icons/flag.gif" border="0" width="18" height="13"alt="forum-flag" title="Flags" /></td>
						<td class="tableheader">
							<table cellspacing="0" cellpadding="0" border="0">
								<tr>
									<td><img SRC="new-hp/images/pixel.gif" border="0" width="1" height="22" alt="" /></td>
									<td style="padding: 0 0 0 5px;"><span>
										<a class="filter" HREF="?n=forums&f=<? echo $_REQUEST['f']; ?>&sort=subject&z=<? if ($_REQUEST['sort']=='subject') { echo $_REQUEST['z']; } else { reorder($_REQUEST['z']); } ?>">Subject<? if ($_REQUEST['sort']=='subject') { ?><img border=0 src="new-hp/images/forum/arrow-<? echo reorder($_REQUEST['z']); ?>.gif"><?php } ?></a></span></td>
								</tr>
							</table>
						</td>
						<td align="center" class="tableheader"><span>
							<a class="filter" HREF="?n=forums&f=<? echo $_REQUEST['f']; ?>&sort=author&z=<? if ($_REQUEST['sort']=='author') { echo $_REQUEST['z']; } else { reorder($_REQUEST['z']); } ?>">Author<? if ($_REQUEST['sort']=='author') { ?><img border=0 src="new-hp/images/forum/arrow-<? echo reorder($_REQUEST['z']); ?>.gif"><?php } ?></a><br /><img SRC="new-hp/images/pixel.gif" width="25" height="1" alt="" /></span></td>
						<td align="center" class="tableheader"><span>
							<a class="filter" HREF="?n=forums&f=<? echo $_REQUEST['f']; ?>&sort=replies&z=<? if ($_REQUEST['sort']=='replies') { echo $_REQUEST['z']; } else { reorder($_REQUEST['z']); } ?>">Replies<? if ($_REQUEST['sort']=='replies') { ?><img border=0 src="new-hp/images/forum/arrow-<? echo reorder($_REQUEST['z']); ?>.gif"><?php } ?></a><br /><img SRC="new-hp/images/pixel.gif" width="25" height="1" alt="" /></span></td>
						<td align="center" class="tableheader"><span>
							<a class="filter" HREF="?n=forums&f=<? echo $_REQUEST['f']; ?>&sort=views&z=<? if ($_REQUEST['sort']=='views') { echo $_REQUEST['z']; } else { reorder($_REQUEST['z']); } ?>">Views<? if ($_REQUEST['sort']=='views') { ?><img border=0 src="new-hp/images/forum/arrow-<? echo reorder($_REQUEST['z']); ?>.gif"><?php } ?></a><br /><img SRC="new-hp/images/pixel.gif" width="25" height="1" alt="" /></span></td>
						<td align="center" class="tableheader"><span>
							<a class="filter" HREF="?n=forums&f=<? echo $_REQUEST['f']; ?>&sort=lastreply&z=<? if ($_REQUEST['sort']=='lastreply') { echo $_REQUEST['z']; } else { reorder($_REQUEST['z']); } ?>">Last Post<? if ($_REQUEST['sort']=='lastreply') { ?><img border=0 src="new-hp/images/forum/arrow-<? echo reorder($_REQUEST['z']); ?>.gif"><?php } ?></a><br /><img SRC="new-hp/images/pixel.gif" width="25" height="1" alt="" /></span></td>
						<?php 
						if ($userlvl>=$rowz['postlevel'] AND $userlvl>=1) { ?>
						<td align="center" class="tableheader"><span>
							<a class="filter">Manage</a><br /><img SRC="new-hp/images/pixel.gif" width="25" height="1" alt="" /></span></td>
						<?php } ?>
						</tr>						
<?php
		while ($rowc = mysql_fetch_array($qquery)) {
		
			$author =  mysql_query("SELECT fp.id_post, fp.id_account, fp.`date`, fp.`hour`, a.gmlevel as gmlvl, fa.displayname as dn FROM `forum_posts` fp
									LEFT JOIN `forum_accounts` fa ON (fa.id_account = fp.id_account)
									LEFT JOIN `account` a ON (fa.id_account = a.id)
									WHERE fp.id_topic='".$rowc['id_topic']."'
									ORDER BY fp.id_post ASC LIMIT 0, 1", $MySQL_CON) or die (mysql_error());			
			$rowauthor = mysql_fetch_array($author);
			
			$rowtotalrows = mysql_query("SELECT id_post FROM forum_posts WHERE id_topic='".$rowc['id_topic']."'", $MySQL_CON) or die (mysql_error());
			
			$blizzreply = mysql_query("SELECT id_post FROM `forum_posts` fp
									LEFT JOIN (`account` a) ON fp.id_account = a.id
									WHERE fp.id_topic='".$rowc['id_topic']."' AND a.gmlevel > 0
									ORDER BY fp.id_post ASC LIMIT 0, 1", $MySQL_CON) or die (mysql_error());			
			
			$lastreply = mysql_query("SELECT id_post, DATE_FORMAT(CONVERT_TZ(CONCAT(`date`, ' ', `hour`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".$usergmt."'), '%h:%i %p') as houri,
									TIMESTAMPDIFF(MINUTE, CONCAT(`date`, ' ', `hour`), NOW()) as datei,
									DATE_FORMAT(CONVERT_TZ(CONCAT(`date`, ' ', `hour`), '".$GMT[$SETTING['WEB_GMT']][0]."', '".$usergmt."'), '%Y-%m-%d') as `date`,
									fa.displayname as dn FROM `forum_posts` fp
									LEFT JOIN (`forum_accounts` fa) ON fa.id_account = fp.id_account
									WHERE fp.id_topic='".$rowc['id_topic']."'
									ORDER BY fp.id_post DESC LIMIT 0, 1", $MySQL_CON) or die (mysql_error());			
			$rowlastreply = mysql_fetch_array($lastreply);
			
			if (isset($_SESSION['userid'])) {
				$topicviewed =  mysql_query("SELECT `time` FROM forum_views WHERE id_topic='".$rowc['id_topic']."' AND id_account='".$_SESSION['userid']."'", $MySQL_CON) or die (mysql_error());
				if (mysql_num_rows($topicviewed)==1) {
						$updatelink = mysql_fetch_array($topicviewed);
						$topicviewed = mysql_query("SELECT id_post FROM forum_posts
							WHERE id_topic='".$rowc['id_topic']."' AND isreply=1 AND TIMESTAMPDIFF(SECOND, '".$updatelink['time']."', CONCAT(`date`, ' ', `hour`))>0 ORDER BY `date`, `hour`, `id_post`", $MySQL_CON) or die (mysql_error());
					if (mysql_num_rows($topicviewed)>0) {
						$updatelink = ceil(((mysql_num_rows($rowtotalrows) - mysql_num_rows($topicviewed)) / $tppage));
						$row = mysql_fetch_array($topicviewed);
						$updatelink='#'.$row['id_post'];
						$rowtopicviewed = 3;
					} else {
						$rowtopicviewed = 0;
					}
				} else {
					$topicviewed =  mysql_query("SELECT a.id FROM account a, forum_posts fp
												WHERE a.id='".$_SESSION['userid']."' AND  fp.id_post='".$rowauthor['id_post']."' AND
												TIMESTAMPDIFF(SECOND, a.`joindate`, '".$rowauthor['date']." ".$rowauthor['hour']."')>0", $MySQL_CON) or die (mysql_error());
					if (mysql_num_rows($topicviewed)==1) {
						$rowtopicviewed = 2;
					} else {
						$rowtopicviewed = 1;
					}
				}
			} else {
				$rowtopicviewed = 1;
			}
			
			if (mysql_num_rows($blizzreply)>0) {
				$rowblizzreply = mysql_fetch_array($blizzreply);
				$blizzreplyloc =  mysql_query("SELECT id_post FROM `forum_posts` fp 
												WHERE fp.id_post<='".$rowblizzreply['id_post']."' AND fp.id_topic='".$rowc['id_topic']."'
												ORDER BY `date` ASC, `hour` ASC", $MySQL_CON) or die (mysql_error());
				$totalpages=mysql_num_rows($blizzreplyloc)/$tppage;
				$totalpages=explode(".", $totalpages);
				if ($totalpages[1]!=0) { $totalpages[0]+=1; }
				
				$blizzreply = '<a HREF="?n=forums&t='.$rowc['id_topic'].'&p='.$totalpages[0].'#'.$rowblizzreply['id_post'].'"><img SRC="new-hp/images/forum/icons/blizz.gif" border="0" title="Blizzard Response" alt="blizz-response" /></a>';
			} else {
				$blizzreply = '<img SRC="new-hp/images/pixel.gif" width="22" height="15" border="0" alt="" />';
			}
						
			if ($rowz['postlevel']>$rowc['postlevel']) { $rowc['postlevel']=$rowz['postlevel']; }
			$ROWF['userview'][] = $rowtopicviewed; //2
			$ROWF['lastreply'][] = strtolower('In '. $rowlastreply['date'].' at '. $rowlastreply['houri'] . ' by <b>'.$rowlastreply['dn'].'</b>');
			$ROWF['created'][] = $rowc['date'].' '.$rowc['hour']; //4
			$ROWF['subject'][] = strtolower($rowc['title']);		
			$ROWF['author'][] = strtolower($rowauthor['dn']);
			$ROWF['trows'][] = mysql_num_rows($rowtotalrows);
			$ROWF['replies'][] = ($ROWF['trows'][count($ROWF['trows'])-1] - 1);
			$ROWF['views'][] = ($rowc['views'] + mysql_num_rows(mysql_query("SELECT id_topic FROM forum_views WHERE id_topic='".$rowc['id_topic']."'", $MySQL_CON)));
			$ROWF['blocked'][] = $rowc['postlevel'];
			$ROWF['poll'][] = $rowc['poll_question'];
			$ROWF['blizzreply'][] = $blizzreply;
			$ROWF['moved'][] = $rowc['id_forum_moved'];
			$ROWF['updated'][] = $updatelink[0];
			$ROWF['idtopic'][] = $rowc['id_topic'];
			$ROWF['postlevel'][] = $rowc['postlevel'];
			
			//Bypass Case Sensivity!
			$ROWF['lastreplyH'][] = 'In '. $rowlastreply['date'].' at '. $rowlastreply['houri']. ' by <b>'.$rowlastreply['dn'].'</b>';
			$ROWF['subjectH'][] = $rowc['title'];
			$ROWF['authorH'][] = $rowauthor['dn']. '|' . $rowauthor['gmlvl'];
			//start counting from here
			$ROWF['sticked'][] = $rowc['issticked'];
		}
				
		if ($_REQUEST['z']=='desc') { $_REQUEST['z']='asc'; } else { $_REQUEST['z']='desc'; }
		
		foreach ($ROWF as $key=>$value) {
			if ($key==$_REQUEST['sort']) {	
				$scode = "\$ROWF['".$key."'], SORT_".strtoupper($_REQUEST['z']).", SORT_STRING, " . $scode;
			} else {
				if ($key=='sticked') {
					$scode = "\$ROWF['".$key."'], SORT_DESC, SORT_STRING, " . $scode;
				} else {
					if ($key=='userview') { $scode .= "\$ROWF['".$key."'], SORT_DESC, SORT_STRING, "; }
					$scode .= "\$ROWF['".$key."'], ";
				}
			}
		}
		
		eval(str_replace(', )',')',"array_multisort(".$scode.");"));
				
		$i='a';
		$k=(($_REQUEST['p']-1)*$ttpage);
		while ($k<((($_REQUEST['p']-1)*$ttpage)+$ttpage) AND $k<count($ROWF['idtopic'])) {
					$gmlevel=explode('|', $ROWF['authorH'][$k]);$ROWF['authorH'][$k]=$gmlevel[0];$gmlevel=$gmlevel[1];
				echo '<tr class="rows">
					<td class="n'.$i.'1" style="width:120px;">';
					if ($ROWF['sticked'][$k]=='1') { echo '<img SRC="new-hp/images/forum/icons/sticky.gif" border="0" width="22" height="15" title="Sticky thread" />';	} 
					else { echo '<img SRC="new-hp/images/pixel.gif" width="22" height="15" border="0" alt="" />'; }
					echo '&nbsp;';
					if (($ROWF['blocked'][$k]>0 AND $userlvl<0) OR ($ROWF['blocked'][$k]>$userlvl AND $userlvl>=0)) { echo '<img SRC="new-hp/images/forum/icons/lock-icon.gif" width="15" height="16" border="0" title="Locked thread" alt="locked" />'; } 
					else { echo '<img SRC="new-hp/images/pixel.gif" width="15" height="16" border="0" alt="" />'; }
					echo '&nbsp;';
					if ($ROWF['poll'][$k]!='') { echo '<img SRC="new-hp/images/forum/icons/poll.gif" border="0" title="Poll Thread" alt="Poll Thread" />'; } 
					else { echo '<img SRC="new-hp/images/pixel.gif" width="20" height="17" border="0" alt="" />'; }
					echo '&nbsp;';
					echo $ROWF['blizzreply'][$k];
					echo '&nbsp;';
					if ($ROWF['moved'][$k]!='0') { echo '<img SRC="new-hp/images/forum/icons/arrow.gif" border="0" title="Thread Moved" alt="Moved" />';	} 
					else { echo '<img SRC="new-hp/images/pixel.gif" width="17" height="11" border="0" alt="" />'; }
					echo '</td>
						<td class="t'.$i.'2">';
					if ($ROWF['userview'][$k]==3) {
						echo '<a HREF="?n=forums&t='.$ROWF['idtopic'][$k].'&p='.$ROWF['updated'][$k].'"><img SRC="new-hp/images/forum/'.$TOPIC_VIEW[$ROWF['userview'][$k]].'" width="15" height="15" style="vertical-align:middle;" border="0" alt="square" /></a>';
					} else {
						echo '<a HREF="?n=forums&t='.$ROWF['idtopic'][$k].'"><img SRC="new-hp/images/forum/'.$TOPIC_VIEW[$ROWF['userview'][$k]].'" width="15" height="15" style="vertical-align:middle;" border="0" alt="square" /></a>';
					}
					if ($_REQUEST['hl']!='') { $ROWF['subjectH'][$k] = preg_replace('/'.$_REQUEST['hl'].'/is','<span class="highlight">'.$_REQUEST['hl'].'</span>',$ROWF['subjectH'][$k]); }
					echo '<a HREF="?n=forums&t='.$ROWF['idtopic'][$k].'" class="active">'.$ROWF['subjectH'][$k].'</a>';
					if (($ROWF['trows'][$k]/$tppage)>1) { echo ' <small>[Page: '.pages(0, $ROWF['trows'][$k], $tppage, '?n=forums&t='.$ROWF['idtopic'][$k], '&nbsp;.&nbsp;', false, 5, false).']</small>'; }
					echo'</td>
						<td class="t'.$i.'3" style="white-space:nowrap">';
					if ($gmlevel>0) { 
						echo '<span title="Blizzard Rep">
							<span class=" blue">'.$ROWF['authorH'][$k].'</span>
							<img SRC="new-hp/images/forum/icons/blizz.gif" border="0" alt="Blizzard Rep" />
							</span>';
					} else {
						echo $ROWF['authorH'][$k];
					}
					echo '</td>';
					echo '<td class="t'.$i.'4">'.$ROWF['replies'][$k].'</td>
						<td class="t'.$i.'5">'.$ROWF['views'][$k].'</td>
						<td class="t'.$i.'6" style="white-space: nowrap">'.$ROWF['lastreplyH'][$k].'</td>';
						
					if ($userlvl >= $ROWF['postlevel'][$k] AND $userlvl>=$rowz['postlevel'] AND $userlvl>=1) {
						if ($ROWF['moved'][$k]>'0' AND $ROWF['moved'][$k]==$rowz['id_forum']) {
							echo'<td class="t'.$i.'1" style="white-space: nowrap; width: 0px;"><a href="?n=forums&t='.$ROWF['idtopic'][$k].'&topic=remove&g=true"><img onmouseover="ddrivetip(\'Remove Ghost\',\'#ffffff\')"; onmouseout="hideddrivetip()" border=0 src="new-hp/images/v2/remove.gif">
							</a></td>'; 
						} else {
							echo'<td class="t'.$i.'1" style="white-space: nowrap; width: 0px;">
								<a href="?n=forums&t='.$ROWF['idtopic'][$k].'&topic=move"><img onmouseover="ddrivetip(\'Move\',\'#ffffff\')"; onmouseout="hideddrivetip()" border=0 src="new-hp/images/forum/icons/arrow.gif"></a>
								<a href="?n=forums&t='.$ROWF['idtopic'][$k].'&topic=edit"><img onmouseover="ddrivetip(\'Edit\',\'#ffffff\')"; onmouseout="hideddrivetip()" border=0 src="new-hp/images/v2/edit.gif"></a>
							&nbsp;<a href="?n=forums&t='.$ROWF['idtopic'][$k].'&topic=remove"><img onmouseover="ddrivetip(\'Remove\',\'#ffffff\')"; onmouseout="hideddrivetip()" border=0 src="new-hp/images/v2/remove.gif">
							</a></td>'; 
						} 
					}
					else if ($userlvl>=1) { echo '<td class="t'.$i.'1" style="white-space: nowrap; width: 0px;">&nbsp;</td>'; }
				echo '</tr>';
			
			if ($i=='a') { $i=''; } else { $i='a'; }
			$k++;
		}

		
	} else {
		echo '<tr><td><br>';
		echo '<div align=center style="color: white;">Forum do not contains any topics or you not allowed to see them.</div>';
		echo '<br><td></tr>';
	}
?>
					
					</table>	
					
					</div>
				</div>		
			
						<div class="theader">
							<div class="lpage">
						
						<table cellpadding = "0" cellspacing = "0" border = "0">
				<tbody><tr>
				<td>
				<?php
				echo $pagination;
				?>
				</td></tr></tbody></table>

							</div>
						</div>
				
		<div class="tbottom"></div>
				<div style="position: relative; width: 100%;">
					<div style="position: absolute; right: 20px; top: -38px;">
					<span><small class="nav">Forum Nav :</small></span>

				<small>
				<select id="selectNavfooter" onchange="javascript:window.location='?n=forums&f=' + this.value" style="display:inline; width: 185px; margin-left: 10px;">							

				<?php echo $allf; ?>

				</select>
				</small>	
				<a href="#" onclick="javascript:window.location='?n=forums&f=' + selectNavfooter.value" class="index"><img SRC="new-hp/images/forum/jump-button.gif" alt="Jump To This Forum" width="21" height="19" border="0" style="margin-bottom: 3px;" align="top" title="Jump To This Forum"/></a>
					</div>
				</div>
							</td>
						</tr>
					</table>
						</td>
					</tr>
				</table>
<?
	iconlegend();
}
?>
<?php function iconlegend() {
					?>
					<div align="center" style="padding: 10px;">
					<span><b>Icon Legend</b></span>
					<table cellspacing="0" cellpadding="0" id="iconLegend">
						<tr>
							<td>
						<table class="tb2" width="100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td><img SRC="new-hp/images/forum/square.gif" style="margin: 0 3px 0 2px;" border="0" alt="Unviewed Post" /><small>&nbsp;Unviewed Post</small></td>
								<td><img SRC="new-hp/images/forum/square-grey.gif" border="0" alt="Viewed Post" /><small>&nbsp;Viewed Post</small></td>
								<td><img SRC="new-hp/images/forum/square-new.gif" style="margin: 0 3px 0 2px;" border="0" alt="New Post" /><small>&nbsp;New Post</small></td>
								<td colspan="2"><img SRC="new-hp/images/forum/square-update.gif" style="margin: 0 3px 0 2px;" border="0" alt="Updated Post" /><small>&nbsp;Updated Post (click to jump to latest unviewed reply)</small></td>
							</tr>
							<tr>
								<td><img SRC="new-hp/images/forum/icons/sticky.gif" border="0" alt="Sticky Post" /><small>&nbsp;Sticky Post</small></td>
								<td><img SRC="new-hp/images/forum/icons/lock-icon.gif" border="0" alt="Locked Post" /><small>&nbsp;Locked Post</small></td>

								<td><img src="new-hp/images/forum/icons/poll.gif" style="margin: 0 3px 0 2px;" border="0" alt="Poll Thread" /><small>&nbsp;Poll Thread</small></td>
	
								<td colspan="2"><img SRC="new-hp/images/forum/icons/blizz.gif" border="0" alt="Blizzard Rep" /><small>&nbsp;Blizzard Rep</small></td>
							</tr>
						</table>
							</td>
						</tr>
					</table>
					</div>
					<?php
}

function navigation($forum, $newpost='') {

?>

<div class="bg-theme">

				<!-- Start Login Box -->
				<div class="login-header-container">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
					<tr>
						<td>

				<div id="forumHead" style="background: url('new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/header-blank.gif') no-repeat 85px 16px;">
			<?php 

				$newqueryb = mysql_query("SELECT id_forum, title, image, postlevel FROM `forums` ORDER BY `title` ASC") or die (mysql_error());
				while ($rowb = mysql_fetch_array($newqueryb)) {
					$GLOBALS['allf'] .= '
							<option value="'.$rowb['id_forum'] .'"';
					if ($forum==$rowb['id_forum']) { $GLOBALS['allf'] .= ' SELECTED'; $image=$rowb['image']; $pstlvl=$rowb['postlevel']; $title=$rowb['title'];  }
					
					$GLOBALS['allf'] .= '>'.$rowb['title'];
				}
						
			?>		
					<div class="icon"><a HREF=""><img SRC="new-hp/images/forum/forumbullets/elite/wow-base-<?php echo $image; ?>" width="85" height="89" border="0" /></a></div>
					<div class="list">
						<ul>
							<li class="title">
							
							
							<h1 class="ftitle"><a HREF="" class="index"><?php echo $title; ?></a></h1>
							
							</li>
							<li class="sel">
							<div style="white-space:nowrap;" class="text"><span><small class="nav">Forum Nav:</small></span></div>
							<select id="selectNav" onchange="javascript:window.location='?n=forums&f=' + this.value" class="forum-dropdown">
				<?php 
					echo $GLOBALS['allf'];
				?>			
							</select>
							<a href="#" onclick="javascript:window.location='?n=forums&f=' + selectNav.value"><img SRC="new-hp/images/pixel.gif" alt="Jump To This Forum" width="21" height="21" border="0" align="middle" title="Jump To This Forum" /></a>
							</li>
						</ul>										
					</div>
				</div> 

				<!-- Logged In View --><?php if (!isset($_SESSION['userid'])) { ?>
				<form action="?n=account.login" method="post">
 				<input type="hidden" value="true" name="save">
					<div id="login">
						<div class="top"></div>

						<div class="textfields">
							<ul class="hdr">
								<li class="title"><img src="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/account.gif" alt="account" /></li>
								<li><input type="text" name="u" size="16" style="width: 120px;" /></li>
							</ul>
								<br clear="all" />
							<ul>
								<li class="title"><img src="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/password.gif" alt="password" /></li>
								<li><input type="password" name="p" size="16" style="width: 120px;" /></li>
							</ul>
								<br clear="all" />
							<ul>
								<li class="title"><div align=right width=100%><input type=checkbox name="ACCOUNT_AUTO_LOGIN" id="alog"></div></li>
								<li class="right"><label for="alog"><small style="color: white;"><?php echo $GLOBALS['_LANG']['ACCOUNT']['REMEMBER_LOGIN']; ?></span></label></li>
							</ul>
						</div>
					</div>
					<div id="loginbuttons">
						<ul>
							<li class="left"></li>
							<li class="login"><input type="image" src="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/login-bot-login.gif" class="button" /></li>
							<li class="mid"></li>
							<li class="help"><a href="javascript: popUp('login-help-forums.html', 500, 450, 'LogInHelp');"><img src="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/login-bot-help.gif" width="98" height="42" alt="help" border="0" /></a></li>

							<li class="right"></li>
						</ul>
					</div>
				</form><span style="font-size: 12px;">
				<?php } else { ?>
				<div id="user">
					<div class="top"></div>
					<div class="body">
					<?php
					$avatar = mysql_fetch_array(mysql_query("SELECT avatar FROM forum_accounts WHERE id_account='".$_SESSION['userid']."'", $GLOBALS['MySQL_CON']));
					$avatar = explode('/', $avatar['avatar']);
					if ($avatar[0]!='gm' AND $avatar[0]!='mvp' AND $avatar[0]!='nochar') {
						$qquery = mysql_query("SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
							rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (`realm_settings` rs) ON r.id = rs.id_realm 
							WHERE r.id='".$avatar[1]."' GROUP BY r.id ORDER BY r.name") OR DIE(mysql_error());
							if (mysql_num_rows($qquery)==1) {
								$rowg = mysql_fetch_array($qquery);
								$newcon = mysql_connect($rowg['rsdbhost'].':'.$rowg['rsdbport'], $rowg['rsdbuser'], $rowg['rsdbpass']);;
								$newdb = mysql_select_db ($rowg['rsdbname'], $newcon);
								$newquery = mysql_query("SELECT name, data, class, race FROM `characters` WHERE `account`='".$_SESSION['userid']."' AND guid=".$avatar[0]."", $newcon);
								if (mysql_num_rows($newquery)==1) {
									$rowc = mysql_fetch_array($newquery);
										$rowc['data'] = explode(' ',$rowc['data']);		
										$char_gender = str_pad(dechex($rowc['data'][36]),8, 0, STR_PAD_LEFT);
										$char_gender = $char_gender{3};		
										$charset[0]=$rowc['name'];
										$charset[1]=$rowc['data'][34];
										$charset[2]=$rowc['race'];
										$charset[3]=$char_gender;
										$charset[4]=$rowc['class'];
										$charset[5]=$rowg['name'];
								} else {
									resetavatar($_SESSION['userid']);
									$avatar[0]='nochar';
								}
							} else {
								resetavatar($_SESSION['userid']);
								$avatar[0]='nochar';
							}
							@mysql_select_db($GLOBALS['MySQL_Set']['DBREALM'], $GLOBALS['MySQL_CON']);
					} else if (($avatar[0]=='gm' AND $GLOBALS['userlvl']>0) OR ($avatar[0]=='mvp' AND $GLOBALS['usermvp']=='1')) {
						if (!file_exists('new-hp/images/forum/portraits/'.$avatar[0].'/'.$avatar[1])) {
							resetavatar($_SESSION['userid']);
							$avatar[0]='nochar';
						}
					} else {
						resetavatar($_SESSION['userid']);
						$avatar[0]='nochar';
					}
					
					?>
							<?php if ($avatar[0]!='nochar' AND $avatar[0]!='gm' AND $avatar[0]!='mvp') { ?>
								<span style="font-size: 11px; color: white;">
								Name: <b><?php echo $charset[0]; ?></b><br/>
								Realm: <b><?php echo $charset[5]; ?></b><br/>
								</span>			
							<?php } else { ?>
								<span><b><a href="#armory" style="text-decoration: none; color: white;"><small><?php echo $_SESSION['nickname']; ?></small></a></b></span></li><br>

								<span><b><small><?php echo $GLOBALS['USER_LEVEL'][$GLOBALS['userlvl']]; ?></small></b></span><br>
							<?php } ?>						
								<span style="color: orange; font-size: 11px;"><a href="?n=account.manage&f=character" style="text-decoration: none;">Select Character</a></span>
					</div>
					<?php  if ($avatar[0]=='nochar') { ?>
					<style>
					div.framenochar<? if ($GLOBALS['userlvl']>0) { echo 'blizz'; } ?> { 
						background: url('new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/no-character-icon<?php  if ($GLOBALS['userlvl']>0) { echo '-blizz'; } ?>.gif');
					}
					</style>
					<? } ?>
					<div id="portrait">

						<div class="shell">
				<table cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td width="64" height="64" style="background: url('new-hp/images/forum/portraits/<?php 
					if ($avatar[0]!='nochar' AND $avatar[0]!='gm' AND $avatar[0]!='mvp') {
						if ($charset[1]=='70') { echo 'wow-70/'; }
						else if ($charset[1]>='60') { echo 'wow/'; }
						else { echo 'wow-default/'; }
						echo $charset[3].'-'.$charset[2].'-'.$charset[4].'.gif';
					} else {
						echo $avatar[0].'/'.$avatar[1];
					} ?>');">
					</td>
				</tr>
				</table>
				<div class="frame<?php if ($avatar[0]=='nochar') { echo 'nochar'; if ($GLOBALS['userlvl']>0) { echo 'blizz'; } }?>"><img src="new-hp/images/pixel.gif" width= "82" height="83" border="0" alt="" />
				</div>
						</div>
					</div>
				 

				</div>

				<div id="logoutbuttons">
					<div style="position: relative;">
						<div class="iconPosition">
							
							
							<b><small><?php 
										if ($avatar[0]!='nochar' AND $avatar[0]!='gm' AND $avatar[0]!='mvp') {
											echo $charset[1];
										} else if (($avatar[0]=='nochar' OR $avatar[0]=='gm') AND $GLOBALS['userlvl']>'0') {
											echo '<img src="new-hp/images/forum/icons/blizz.gif">';
										} else if (($avatar[0]=='nochar' OR $avatar[0]=='mvp') AND $GLOBALS['usermvp']=='1') {
											echo '<img src="new-hp/images/forum/icons/modr-small.gif">';
										}
										?></small></b>
							
					</div>
				</div>
					<ul>
						<li class="left"></li>

						
						<li><a href="?n=account.logout"><img src="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/login-bot-logout.gif" width="97" height="42" border="0" alt="Log Out" /></a></li>
						<li class="mid"></li>
						
						<li><a href="?n=account.manage&f=contact"><img src="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/login-bot-options.gif" width="98" height="42" border="0" alt="options" /></a></li>
						<li class="right"></li>
					</ul>
				</div>
						</td>
					</tr>

				</table>
				</div>
				<?php }  ?>
				<!-- End Login Box -->
				<div class="clear" style="height: 1px;"></div>
<?php if ($newpost=='') { ?>
				<form action="?n=forums&f=search" name="searchForm" accept-charset="UTF-8" method="post">
<?php } ?>
				<div id="search">
<?php if ($newpost=='') { ?>
					<ul>
						<li class="a"></li>
						<li>
							<?php if ($pstlvl<=$GLOBALS['userlvl']) { ?>
								<a HREF="?n=forums&f=<?php echo $forum; ?>&topic=new">
									<img SRC="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/forum-menu-newtopic.gif" alt="New Topic" title="New Topic" border="0" />
									<img SRC="new-hp/images/forum/newpost-icon-quill.gif" alt="New Topic" width="33" height="35" border="0" style="position: absolute; top: -7px; left: 49px;" />
								</a>
							<?php } else { ?>
								<img SRC="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/forum-menu-newtopic-inactive.gif" border="0" />
								<img SRC="new-hp/images/forum/newpost-icon-quill-inactive.gif" width="33" height="35" border="0" style="position: absolute; top: -7px; left: 49px;" />
							<?php } ?>
						</li>

						<li><img SRC="new-hp/images/forum/forum-menu-mid.gif" alt="" width="19" height="39" border="0" /></li>
						<li><img SRC="new-hp/images/forum/forum-menu-search-left.gif" alt="" width="12" height="39" border="0" />
							<img SRC="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/forum-menu-quicksearch.gif" alt="quick search" width="85" height="17" border="0" style="position: absolute; top: -6px;" id="forum-menu-quicksearch" />
						<style>
							#search div.advanced-search { background: url('new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/forum-menu-advanced-search.gif') no-repeat 0 0; left: 288px; }
							#search div.advanced-search a:hover { background:url('new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/forum-menu-advanced-search.gif') no-repeat 0 -17px; }
						</style>
							<div class="advanced-search">
								<a HREF="?n=forums&f=search"><!-- new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/forum-menu-advanced-search.gif -->
									<img SRC="new-hp/images/pixel.gif" alt="Advanced Search" title="Advanced Search" width="107" height="15" border="0" />
								</a>
							</div>
						</li>
						<li class="b"><input name="searchText" size="20" class="quick-search-field"/></li>
						<li>
							<input type="image" SRC="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/forum-menu-search.gif" class="button" title="Search" />
						</li>
						<li><img SRC="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/forum-menu-search-right.gif" alt="" width="83" height="39" border="0" /></li>
					</ul>
<?php } ?>
				<div class="forum-index" id="forum-index">
				<a HREF="?n=forums">
					<img SRC="new-hp/images/<?php echo $GLOBALS['_LANG']['LANG']['SHORT_TAG']; ?>/forum/forum-index.gif" width="104" height="41" border="0" alt="Forum Index" title="Forum Index" />
				</a>
				</div>

				</div>
<?php if ($newpost=='') { ?>
				</form>
<?php } ?>
				</div>
<?

}
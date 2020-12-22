<?
if (INCLUDED!==true) { include('index.htm'); exit; }
?>
                                                    </div>
                                                  </td>
											<td valign="top">
													         
<? if ($SHOW_LINKS==true) { ?>	
<style>
	a.button-forums, a.button-armory { display: block; height: 63px; width: 220px; position: relative; top: -5px; }
	a.button-forums { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/button-forums.gif') no-repeat 0 0; }
	a.button-armory { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/button-armory.gif') no-repeat 0 0; }
	a.button-forums:hover, a.button-armory:hover  { background-position: 0 -63px; }
	
	#quicklinks h3 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-quick_links.jpg') no-repeat 30px 8px; }
	
	#ssotd-container h3 { background: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-ssotd.gif') no-repeat 50px 5px; }
	
	#gameinfo-don-container h3 { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-don.gif'); }
	
	#gameinfo-newcomers-container h3 { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-newcomers.jpg'); }
	#marginal h4.begin-journey { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-journey.gif'); }
	#marginal h4.newbie-faq { background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/subheader-newbiefaq.jpg'); }
	#marginal h4.discover {  background-image: url('new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/header-discoverwow.gif'); }
	
</style>
												<div id="margial" style="margin-bottom: -5px; margin-top: 4px;">
														<a class="button-download" href="javascript:alert('Not Yet Avaliable!')"></a>
														<a class="button-armory" href="?n=armory"></a>
														<a class="button-forums" href="?n=forums"></a>
												</div>  
												<div id="marginal"> 
											<!-- quicklinks-section -->
	
                                                      <div id="quicklinks">
		
                                                        <div class="plainBox-top">
                                                          <h3>
                                                            <span>Quicklinks</span>
                                                          </h3>
                                                        </div>
		
                                                        <div class="plainBox-cnt">
			
                                                          <div class="plainBox-cnt-top">
				
                                                            <div class="plainBox-cnt-bot">
					<!--<img src="/new-hp/images/quicklinks-testimage.jpg" width="195" height="66" alt="quicklinks-testimage" /> -->
					
                                                              <ul class="none">
															  
<? if (verifylevel($_SESSION['userid'])>0) { ?> <li>
                                                                <a href="index.php?n=admin"><img src="new-hp/images/icons/patch_notes.jpg">Site Administration</a>
                                                                </li>
<? } ?>
						
<? if (isset($_SESSION['userid'])) { ?>                                                                <li>
                                                                  <a href="index.php?n=account.manage"><img src="new-hp/images/icons/acct_management.jpg">Account Management</a>
                                                                </li>
<? } ?>							
                                                                <li>
                                                                  <a href="index.php?n=forum&topic=Y"><img src="new-hp/images/icons/support.jpg">Support Site</a>
                                                                </li>
					
                                                                <li>
                                                                  <a href="index.php?n=account.realmstatus"><img src="new-hp/images/icons/realmstatus.jpg">Realm Status</a>
                                                                </li> 
						
<? if (!isset($_SESSION['userid'])) { ?>                                      <li>
                                                              <a href="index.php?n=account.create"><img src="new-hp/images/icons/acc_creation.jpg">Account Creation</a>
                                                                </li>
						
																<li>
                                                                  <a href="index.php?n=account.retrievepassword"><img src="new-hp/images/icons/retrieve_pwd.jpg">Retrieve Password</a>
                                                                </li>
<? } ?>						
                                                                <li>
                                                                  <a href="index.php?n=gameguide.faq"><img src="new-hp/images/icons/faq.jpg">FAQ Site</a>
                                                                </li>
	
					
                                                              </ul>
				
                                                            </div>
			
                                                          </div>
		
                                                        </div>
		
                                                        <div class="plainBox-bot"></div>
	
                                                      </div> 
	
<? if (isset($_SESSION['userid']) AND $SETTING['USER_REG_ACTIVE']=='1') { ?>   
                                                      <div style="width: 213px; margin-left: auto; margin-right: auto; margin-top:0px; margin-bottom:8px;">
	<? if (verifylevel($_SESSION['userid'])<=$SETTING['USER_MAIL_ENABLE']) { ?>   
                                                        <A HREF="mailto:?subject=Join <?php echo $_SESSION['nickname']; ?> at <?php echo $SETTING['WEB_SITE_NAME']; ?>&body=Hello Friend, <?php echo $_SESSION['nickname']; ?> is asking you if you want to join him at <?php echo $SETTING['WEB_SITE_NAME']; ?> (World of Warcraft Server).%0A %0AIf you want so, you're welcome to create your account at http://<?php echo $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']); ?>. %0A %0AThank you."><img border="0" height="91" src="new-hp/images/featured/button_raf.gif" width="213"></a>
	<? } else { ?>  
	<script>
		function recruitfriend() {
			var n = prompt('Friend\'s E-mail:');
			if (n) {
				document.mailet.mailer.value=n;
				document.mailet.submit();
			} else {
				
			};
		}
	<?php if ($_SERVER['REQUEST_METHOD']=='POST') {
				if (valemail($_POST['mailer'])==true) {
					if (@sendemail($_POST['mailer'], $_POST['mailer'], $SETTING['WEB_SITE_NAME'].': Request-a-Friend', '', '')) {
						echo 'alert("E-mail Successfuly Sent!");';
					} else {
						echo ' window.location="mailto:'.$_POST['mailer'].'?subject='.$SETTING['WEB_SITE_NAME'].': Request-a-Friend&body=";
							  window.location="?";';
					}
				} else {
					echo 'alert("Invalid E-mail!");';
				}
			}
			unset($_POST['mailer']);
	?>
	</script>
	<form method=post name="mailet" action="?">
	<input type=hidden name="mailer">
														<A HREF="#" onclick="recruitfriend()"><img border="0" height="91" src="new-hp/images/featured/button_raf.gif" width="213"></a>
	</form>
	<? } ?>   
                                                      </div>
<? } ?>   
        
<!-- ssotd-section-->

							 <?php	
								$tp = 'media/screenshots/ssday.txt';
								$fh = @fopen($tp, 'r');
								$css = @fread($fh, filesize($tp));
								$css = explode('|',$css);
								@fclose($fh);
								if (date('Y-m-d') != $css[0]) {
									$css[1]=savenewss($tp);
								} else if (!file_exists($css[1])) {
									$css[1]=savenewss($tp);
								}
								$css[0]=str_replace('media/screenshots/','',str_replace('.jpg','',$css[1]));
								
								if ($css[1]!='') {
								?>
	
                                                      <div id="ssotd-container">
		
                                                        <div class="marginal-infoBox-top">
			
                                                          <a href="index.php?n=media.screenshots" target="_blank" style="cursor: hand;">
                                                            <h3>
                                                              <span>Screenshot of the Day</span>
                                                            </h3>
                                                          </a>                                                               
			<a href="index.php?n=media.screenshots" target="_blank" style="cursor: hand;"><span class="infoBox-visual ssotd"></span></a>
			<span class="arrow-readmore"><a href="index.php?n=media.screenshots" target="_blank"><span>Click here to see more Screenshots</span></a></span>
		
                                                        </div>
		
                                                        <div class="marginal-infoBox">
			
                                                          <div class="marginal-infoBox-cnt">
                                                            <div id="ssotdContainer" style="height: 151;">	 
									<a href = "?n=media.screenshots&p=<?php echo $css[0]; ?>" target="_blank"><img src = "<?php echo $css[1]; ?>" width =195 height =151 border =0></a>

							</div>
                                                          </div>
		
                                                        </div>
		
                                                        <div class="marginal-infoBox-bottom">&nbsp;</div>
	
                                                      </div>


<?php 
									}
										
if ($SETTING['DONATIONS_ENABLED']==1 and $SETTING['WEB_SHOW_DONATIONS']==1) { ?>
<!-- donations-section-->
                                                      <div id="gameinfo-don-container">
		
                                                        <div class="marginal-infoBox-top">
			
                                                            <a href="index.php?n=support.donations"><h3>
                                                              <span>Donations</span>
                                                            </h3></a>
			<a href="index.php?n=support.donations"><span class="infoBox-visual don"></span>
			<span class="arrow-readmore"><span>Donations</span></span></a>
		
                                                        </div>
		
                                                        <div class="marginal-infoBox">
			
                                                          <div class="marginal-infoBox-cnt">
				
                                                            <div class="parchment">
					
                                                              <div class="parchment-top">
						
                                                                <div class="parchment-bot">

                                                                  <div class="gameinfo-entry thirdEntry">
<?php
$totaldon=0;
$query = mysql_query("SELECT value FROM web_donations WHERE `date`>='".$SETTING['DONATIONS_DAY_START']."' AND `date`<='".$SETTING['DONATIONS_DAY_END']."'", $MySQL_CON) or die(mysql_error());
while ($row=mysql_fetch_array($query)) {
	$totaldon+=$row['value'];
}
$percdon = @round( $totaldon * 100 / $SETTING['DONATIONS_NEEDED_VALUE']);
if ($percdon>100) {$percdon=100;}
else if ($percdon<0) {$percdon=0;}

 ?>								
					<table width=100% border=0 cellpadding=0 cellspacing=5>
						<tr><td align=right colspan=2>
						<small>Since <?php echo $SETTING['DONATIONS_DAY_START'] .' till '. $SETTING['DONATIONS_DAY_END']; ?></small>
						</td></tr>
						<tr><td align=left>
						Target: </td><td align=right><?php echo $SETTING['DONATIONS_NEEDED_VALUE'] .' '. $SETTING['DONATIONS_CURRENCY']; ?>
						</td></tr>
						<tr><td align=left>
						Current: </td><td align=right><?php echo $totaldon .' '. $SETTING['DONATIONS_CURRENCY'];  ?>
						</td></tr>
						<tr><td align=left style="background-repeat: no-repeat;" colspan=2 background="new-hp/images/loadingscreen.png" height=26>
						<div id="percbar" align=center STYLE="position:absolute; height: 26; width: 170;"><small><img width=1 height=5 src="new-hp/images/pixel.gif"><br><font color=white><?php echo $percdon.'%'; ?></font></small></div>
						<?php if ($percdon>0) { ?><img src="new-hp/images/leftbar.gif"><img src="new-hp/images/midbar.gif" height=26 width=<?php echo @round($percdon*136/100); ?>><img src="new-hp/images/rightbar.gif">
						<?php } else { ?><img src="new-hp/images/pixel.gif" height=26 width=170>
						<?php } ?>
						</td></tr>
						<?php if($SETTING['DONATIONS_PAY_OBJ']!='') { ?><tr>
							<td align=center colspan=2>
							<?php echo $SETTING['DONATIONS_PAY_OBJ']; ?>
							</td>
						</tr><?php } ?>
					</table>
								
                                                                    <div class="opera-break"></div>

                                                                  </div>
							
                                                                  <div style="clear: both; height: 1px; font-size: 0;">&nbsp;</div>
						
                                                                </div>
					
                                                              </div>
				
                                                            </div>
				
                                                            <div style="background: url(new-hp/images/marginal-infoBox-cnt-bottompaper.jpg) no-repeat 0 0; height: 6px; font-size: 1px;"></div>
			
                                                          </div>
		
                                                        </div>
		
                                                        <div class="marginal-infoBox-bottom"></div>
	
                                                      </div>
<?php } ?>
<!-- newbieguide-section -->
	
                                                      <div id="gameinfo-newcomers-container">
		
                                                        <div class="marginal-infoBox-top">
			
                                                            <h3>
                                                              <span>Newcomers Section</span>
                                                            </h3>
			<span class="infoBox-visual newbieguide"></span>
			<span class="arrow-readmore"><span>open Newcommers Section</span></span>
		
                                                        </div>
		
                                                        <div class="marginal-infoBox">
			
                                                          <div class="marginal-infoBox-cnt">
				
                                                            <div style="background: url(new-hp/images/marginal-infoBox-cnt-banner.jpg) no-repeat 0 0; height: 22px;">
                                                              <h4 class="discover">
                                                                <span>Discover World of Warcraft</span>
                                                              </h4>
                                                            </div>
				
                                                            <div class="parchment">
					
                                                              <div class="parchment-top">
						
                                                                <div class="parchment-bot">
							
                                                                  <div class="gameinfo-entry firstEntry">
								
                                                                    <img alt="image-retailbox" class="left" src="new-hp/images/image-retailbox.gif" style="padding-left: 5px;">
								<p>
									Looking to download <a href="">World of Warcraft</a>? Then use one of the bellow links!<br>
                                                                      <br>
								
                                                                    </p>
							
                                                                    <div class="gameinfo-entry secondEntry">
								
                                                                      <ul class="link-list">		
                                                                        <li>
                                                                          <a href="http://www.worldofwarcraft.com/downloads/files/pc/wowclient-downloader.exe">World of Warcraft</a>
                                                                        </li>
																		<li>
                                                                          <br>
                                                                        </li>
																		<li>
                                                                          <br>
                                                                        </li>
                                                                      </ul>
								
                                                                      <div id="elf-ear">
							   
                                                                        <img alt="" src="new-hp/images/elf-ear.gif"></div>
						   
                                                                    </div>
							
                                                                  </div>
				
							
                                                                  <hr>
							
                                                                  <div class="parchment-subHeader secondSubHeadline" >
								
                                                                    <h4 class="begin-journey">
                                                                      <span>Begin Your Journey</span>
                                                                    </h4>
							
                                                                  </div>
						  
                                                                  <div class="gameinfo-entry thirdEntry">
								
                                                                    <img alt="journey-human" class="left" src="new-hp/images/bg-journey-human.gif"><img alt="journey-human" class="tpng" src="new-hp/images/journey-human.gif" style="position: absolute; top: -15px; right: 130px; _right: 130px;">
								<p>
									
                                                                      <b>Connecting to the Server?</b>
                                                                      <br>
									Find how to do it in the users <a href="index.php?n=support">Support Site</a>!
								</p>
								
                                                                    <div class="opera-break"></div>
							
							   					
                                                                    <script language="javascript">
						//
						if(is_mac) document.getElementById("elf-ear").style.top="-19px";
						//
						</script>			
							
                                                                  </div>
							
                                                                  <div style="clear: both; height: 1px; font-size: 0;">&nbsp;</div>
						
                                                                </div>
					
                                                              </div>
				
                                                            </div>
				
                                                            <div style="background: url(new-hp/images/marginal-infoBox-cnt-bottompaper.jpg) no-repeat 0 0; height: 6px; font-size: 1px;"></div>
				
                                                          </div>
		
                                                        </div>
		
                                                        <div class="marginal-infoBox-bottom"></div>
	
                                                      </div>

                                                    </div>
                                                    <!-- #marginal end -->
                                                  </td>
													
<?php } ?>
                                                </tr>
                                              </table>

                                            </div>
                                          </div>
                                        </div>

                                        <div style="clear: both; font-size: 1px; position: relative;">&nbsp;</div>
                                        <center>
                                          <div id="copyright">
                                            <?php include ('page.copyright.php'); ?>
                                          </div>
                                        </center>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>

                                      <div id="main-bottom">
                                        <div>
                                          <div>							  
                                            <!-- ex blizz logo-->
                                          </div>

                                        </div>

                                      </div>
                                    </td>
                                  </tr>
                                </table>
								
                              </div>
                            </div>

                           <div style="position: relative;">
                              <img class="statue-left" src="new-hp/images/pixel.gif"></div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
				 </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
      </table>
    </center>

    <div id="ironFrame">
		<table align=center border=0 cellspacing=0 cellpadding=0>
			<tr>
				<td width=130 class="tbblizzlogo">
				</td>
				<td width=760 align=center>
					<div id="blizzlogo-bot">
		            <a href="http://www.blizzard.com"><img alt="Blizzard.com" border="0" class="blizzylogo" src="new-hp/images/pixel.gif"></a>
			</div>
				</td>
			</tr>
		</table>
	</div>
    <div id="pageEnd"></div>
  </body>
<script>window.status='Welcome to <?php echo $SETTING['WEB_SITE_NAME']; ?>!';</script>
</html>
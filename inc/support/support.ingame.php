<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title("In-Game Support");

subnav('Support');

parchdown();

if (isset($_SESSION['userid'])) {

	if ($_REQUEST['r']!='') {
	
		if ($_REQUEST['t']!='') {
	
		$query = mysql_query("SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
				rs.dbpass as rsdbpass,rs.dbname as rsdbname, rs.dbname1 as rsdbname1 FROM `realmlist` r LEFT JOIN (realm_settings rs) ON r.id = rs.id_realm
				WHERE id='".$_REQUEST['r']."'
				GROUP BY r.id ORDER BY r.name", $MySQL_CON) OR DIE(mysql_error());
		
		$rowa = mysql_fetch_array($query);
		
		if (mysql_num_rows($query)>0) {
		
			if(check_port_status($rowa['rsdbhost'], $rowa['rsdbport'])===true) {
			
				$newcon = @mysql_connect($rowa['rsdbhost'].':'.$rowa['rsdbport'], $rowa['rsdbuser'], $rowa['rsdbpass'], true);
				if (!$newcon) { $haserrors.=mysql_error().'<br>'; }
				$newdb = mysql_select_db($rowa['rsdbname'], $newcon);
				if (!$newdb) { $haserrors.=mysql_error().'<br>'; }
				
				if ($haserrors!='') {
					
					errborder($haserrors);

				} else if ($_REQUEST['t']=='tickets') {
				
					tabtitle($rowa['name']. ' - Tickets Manager:');
									
					$newquery = mysql_query("SELECT guid, name FROM `characters.character` WHERE account='".$_SESSION['userid']."' ORDER BY name ASC", $newcon);
				
					if (mysql_num_rows($newquery)>0) {
					
					echo '<br><a href="index.php?n=support.ingame&r='.$_REQUEST['r'].'&t=tickets&m=add"><img src="new-hp/images/v2/add.gif"> New</a> | <a href="index.php?n=support.ingame&r='.$_REQUEST['r'].'&t=tickets&m=manage"><img src="new-hp/images/v2/manage.gif"> Manage</a><br><br>';
									
						switch ($_REQUEST['m']) {
							case "edit":
							
								$queryedit = mysql_query("SELECT * FROM character_ticket WHERE ticket_id='".$_REQUEST['id']."'", $newcon);
							
							case "add":
							
								$forceshow=true;
								
								if ($_POST['save']=='add') {
								
									$saveq = mysql_query("INSERT INTO character_ticket(guid, ticket_text, ticket_category) VALUES('".$_POST['charguid']."','".$_POST['issuetext']."','".$_POST['ticketcat']."')", $newcon);
								
									goodborder('New Ticket successfully added.<meta http-equiv="refresh" content="2;url=index.php?n=support.ingame&r='.$_REQUEST['r'].'&t=tickets&m=manage">');							
									
									$forceshow=false;
								
								} else if ($_POST['save']=='edit') {

									$saveq = mysql_query("UPDATE character_ticket SET guid='".$_POST['charguid']."', ticket_text='".$_POST['issuetext']."', ticket_category='".$_POST['ticketcat']."' WHERE ticket_id='".$_REQUEST['id']."'", $newcon);

									goodborder('Ticket was successfully edited.<meta http-equiv="refresh" content="2;url=index.php?n=support.ingame&r='.$_REQUEST['r'].'&t=tickets&m=manage">');

									$forceshow=false;

								}
								if ($forceshow==true) {
									?>
									<form method=post action="index.php?n=support.ingame&r=<?php echo $_REQUEST['r']; ?>&t=tickets&m=<?php echo $_REQUEST['m']; ?>&id=<?php echo $_REQUEST['id']; ?>" name="addnew" onsubmit='return fas_valid()'>
									<script language="javascript">
									function fas_valid() {
										void(document.addnew.save.value="<? echo $_REQUEST['m']; ?>");
										return true;
									}
									</script>
										<input type=hidden name="save">
									<?php if ($haserrors!="") { errborder($haserrors) .'<br>';} ?>
									<table cellspacing = "0" cellpadding = "0" border = "0" width = "500">
										<tr>
											<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
											<td width = "100%" bgcolor = "#05374A"><b class = "white">Add New Ticket:</b></td>
											<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
										</tr>
										</table>
										<table width = 500 style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
										<table width = 100% style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
										<table border=0 cellspacing=0 cellpadding=4>
										<tr>
											  <td width=40% align=right>
											  <font face="arial,helvetica" size=-1><span><b>
											  Character:  </span></b></font> </td>
											  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
											  <select name="charguid">
											  <?
											  while ($rowb = mysql_fetch_array($newquery)) {
												echo '<option value="'.$rowb['guid'].'">'.$rowb['name'];
											  }
											  ?>
											  </select>
											  </td><td valign = "top">
											   </td></tr></table></td>
										</tr>
										<tr>
											  <td width=40% align=right>
											  <font face="arial,helvetica" size=-1><span><b>
											  Category: </span></b></font> </td>
											  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
											  <select name="ticketcat">
											  <?
											  foreach ($TICKET_CATEGORY as $key => $value) {
												echo '<option value="'.$key.'">'.$value;
											  }
											  ?>
											  </select>
											  </td><td valign = "top">
											   </td></tr></table></td>
										</tr>
										<tr>
											  <td width=40% align=right valign=top>
											  <font face="arial,helvetica" size=-1><span><b>
											  Message:  </span></b></font> </td>
											  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td>
											  <textarea name="issuetext" rows=5 cols=45><?
												if ($_REQUEST['m']=='edit') {
													$rowedit = mysql_fetch_array($queryedit);
													echo $rowedit['ticket_text'];
												}
											?></textarea>
											  </td><td valign = "top">
											   </td></tr></table></td>
										</tr>
										</table>
										</td></tr></table>
										</td></tr></table><br>
											<div align=center><a href="index.php?n=support.ingame&r=<?php echo $_REQUEST['r']; ?>&t=tickets&m=manage"><img SRC="shared/wow-com/images/buttons/button-back.gif"></a><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="Update" Width="174" Height="46" Border=0 class="button"  taborder=7 ></div>

									</form>
									<script>
									<? if ($_REQUEST['m']=='edit') { ?>
									document.addnew.charguid.value="<?php echo $rowedit['guid']; ?>";
									document.addnew.ticketcat.value="<?php echo $rowedit['ticket_category']; ?>";
									<? 	} ?>
									</script>
									<?
								}
							break;
							case "remove":

								$saveq = mysql_query("DELETE FROM character_ticket WHERE ticket_id='".$_REQUEST['id']."'", $newcon);

								goodborder('Ticket was successfully removed.<meta http-equiv="refresh" content="2;url=index.php?n=support.ingame&r='.$_REQUEST['r'].'&t=tickets&m=manage;">');

							break;
							case "manage":
							default:

							$newquery = mysql_query("SELECT ticket_id, c.guid, ticket_text, ticket_category, c.name FROM `character_ticket` ct LEFT JOIN `character` c ON ct.guid = c.guid WHERE c.account='".$_SESSION['userid']."' GROUP BY ct.ticket_id ORDER BY c.name ASC", $newcon);

							if (mysql_num_rows($newquery)>0) {

							metalborderup();

							?>
							<div style='cursor: auto;' id='dataElement'>
							<span>
										<table cellpadding='3' cellspacing='0' width=320>
											<tbody>
											<tr>
												<td class='rankingHeader' align='left' nowrap='nowrap' width=80%>Character - Issue&nbsp;</td>
												<td class='rankingHeader' align='left' nowrap='nowrap' width=20%>&nbsp;</td>
												<td class='rankingHeader' align='left' nowrap='nowrap' width=20%>&nbsp;</td>
											</tr>
											<tr>
												<td colspan='5' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
												</td>
											</tr>
							<?php
									$res_color=2;
									while($rowc = mysql_fetch_array($newquery)) {

										if($res_color==1) { $res_color=2; } else { $res_color=1; }

									echo "<tr><td class='serverStatus$res_color'>
											<span style='color: #BB5500;'><b>". $rowc['name']." - <i>".$TICKET_CATEGORY[$rowc['ticket_category']]."</i>:</b></span><span style='color: #005500;'><br>
											<div style='overflow: auto; width: 400px; max-height: 100px; height: expression(this.scrollHeight > 100 ? 100 : true); border: 1px solid #666666; white-spacing: wrap;'>".bbcode($rowc['ticket_text'])."</div>
											</span></td>
										<td align=center class='serverStatus$res_color'><a href='index.php?n=support.ingame&r=".$_REQUEST['r']."&t=tickets&m=edit&id=".$rowc['ticket_id']."' onmouseover='ddrivetip(\"Edit\")' onmouseout='hideddrivetip()'><img src='new-hp/images/v2/edit.gif'></a></td>
										<td align=center class='serverStatus$res_color'><a href='index.php?n=support.ingame&r=".$_REQUEST['r']."&t=tickets&m=remove&id=".$rowc['ticket_id']."' onmouseover='ddrivetip(\"Remove\")' onmouseout='hideddrivetip()'><img src='new-hp/images/v2/remove.gif'></a></td>
									</tr>";

									}

									?>
													</tbody>
												</table>

									</span>
							</div>
							<?

							metalborderdown();

							} else {

								goodborder("You don't have any Tickets!");

							}

							break;
						}

					} else {

						errborder("You don't have any characters in this realm therefore you're not allowed to manage tickets.");

					}

				} else {

					tabtitle($rowa['name']. ' - Commands List:');
					
					$newquery = mysql_query("SELECT * FROM command WHERE security<='".verifylevel($_SESSION['userid'])."' ORDER BY security DESC", $newcon);
					
					if (mysql_num_rows($newquery)>0) {

						echo '<br>';
						metalborderup();
						?>
							<table cellpadding='3' cellspacing='0' width=517>
								<tr>
									<td class='rankingHeader' align='left' nowrap='nowrap'>Command&nbsp;</td>
									<td class='rankingHeader' align='left' nowrap='nowrap' width=100%>Description&nbsp;</td>
								</tr>
							</table>
							<div style='overflow: auto; max-height: 800px; height: expression(this.scrollHeight > 800 ? 800 : true); width: 100%;' id='dataElement'>
									<span>
												<table cellpadding='3' cellspacing='0' width=500>
													</tr>
								<?php
															
								$res_color=2;
								$gmlvl='';
								while ($rowc = mysql_fetch_array($newquery)) {
									if($res_color==1) { $res_color=2; } else { $res_color=1; }
									if ($gmlvl!=$rowc['security']) {
										echo "<tr>
												<td class='rankingHeader' colspan=2 align='center' nowrap='nowrap'>".$USER_LEVEL[$rowc['security']]."</td>
											</tr>
											<tr>
												<td colspan='5' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
												</td>
											</tr>";
										$gmlvl=$rowc['security'];
										$res_color=1;
									}
									echo "<tr>
										<td align=left class='serverStatus$res_color'><span style='color: rgb(102, 13, 2);'>.".$rowc['name']."</span></td>
										<td align=left class='serverStatus$res_color'><span style='color: rgb(35, 67, 3);'>".$rowc['help']."</span></td>
									</tr>";
								}
								?>
											</table>

								</span>
						</div>
						<?php
						
						metalborderdown();
						
					} else {
					 
						errborder('No Commands were found.');
						
					}
						
				}
				
			} else {
				errborder('Realm is unavaliable.');	
			}
				
		} else {
		
		}
	} else {
				
		tabtitle('<a href="?n=support.ingame&r='.$_REQUEST['r'].'&t=commands">Commands List</a>');
		
		parchdown();
		
		tabtitle('<a href="?n=support.ingame&r='.$_REQUEST['r'].'&t=tickets">Ticket System</a>');
		
	}
				
	} else {
		tabtitle('Select a Realm:');
		
		echo '<br>';
		metalborderup();
		?>
		<div style='cursor: auto;' id='dataElement'>
		<span>
					<table cellpadding='3' cellspacing='0' width=320>
						<tbody>
						<tr>
							<td class='rankingHeader' align='left' nowrap='nowrap' width=50%>Realm Name&nbsp;</td>
							<td class='rankingHeader' align='left' nowrap='nowrap' width=20%>Type&nbsp;</td>
						</tr>
						<tr>
							<td colspan='5' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
							</td>
						</tr>
		<?php
				$query = mysql_query("SELECT * FROM `realmlist` r", $MySQL_CON) OR DIE(mysql_error());
				$res_color=2;
				while($rowa = mysql_fetch_array($query)) {

					if($res_color==1) { $res_color=2; } else { $res_color=1; }
					
				echo "<tr><td class='serverStatus$res_color'>
						<b><span style='color: rgb(35, 67, 3);'><a href='?n=support.ingame&r=".$rowa['id']."&t=".$_REQUEST['t']."'>". $rowa['name']."</a></span><b></td>
					<td align=center class='serverStatus$res_color'>
						<span style='color: rgb(102, 13, 2);'>".$REALM_TYPE[$rowa['icon']]."</span></td>
				</tr>";
								
				}

				?>
								</tbody>
							</table>

				</span>
		</div>
		<?php

		metalborderdown();
	}

} else {
	errborder($_LANG['ERROR']['NEED_LOGIN']);
}

parchdown();
	
?>

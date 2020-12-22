<?php 

parchup();

title('PvP Rankings');

parchdown();

parchup(true);

if ($_REQUEST['r']!='') {
	if ($_REQUEST['f']!='') {
		
		$query = "SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
		rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (realm_settings rs) ON r.id = rs.id_realm 
		WHERE id='".$_REQUEST['r']."' GROUP BY r.id ORDER BY r.name";
		
		$query = mysql_query($query, $MySQL_CON) OR DIE(mysql_error());

		if (mysql_num_rows($query)>0) {
		
			$rowa = mysql_fetch_array($query);

				if(check_port_status($rowa['rsdbhost'], $rowa['rsdbport'])===true) {
			
					if ($_REQUEST['f']=='alliance') {
						$fac = 'race=1 OR race=3 OR race=4 OR race=7 OR race=11';
					} else {
						$fac = 'race=2 OR race=5 OR race=6 OR race=8 OR race=10';
					}
			
					$newcon = mysql_connect($rowa['rsdbhost'].':'.$rowa['rsdbport'], $rowa['rsdbuser'], $rowa['rsdbpass'])or die (mysql_error());;
					$newdb = mysql_select_db ($rowa['rsdbname'],$newcon) or die (mysql_error());
					$newquery = mysql_query("SELECT account, c.name as name, race, class, data, g.name as guild,											
											CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 1433), ' ', -1) AS UNSIGNED) as honor,
											CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 1388), ' ', -1) AS UNSIGNED) as kills
											FROM `characters` c 
											LEFT JOIN guild_member gm ON gm.guid = c.guid 
											LEFT JOIN guild g ON g.guildid = gm.guildid
											WHERE ".$fac." ORDER BY honor DESC, kills DESC, guild ASC, c.name ASC LIMIT 0, 50", $newcon) or die (mysql_error());
										
					subtitle($rowa['name']);
					
					if (mysql_num_rows($newquery)>0) {
					
		echo '<img src="new-hp/images/pvp/'.$_REQUEST['f'].'.gif" border=0><img src="new-hp/images/pvp/'.$_REQUEST['f'].'-title.jpg"><img src="new-hp/images/pixel.gif" width=400 height=56 style="background: url(new-hp/images/pvp/'.$_REQUEST['f'].'-bg.jpg) repeat-x -120px 0px;" border=0><img src="new-hp/images/pvp/'.$_REQUEST['f'].'-right.gif" border=0>';

			metalborderup();
			
		?>
			<table cellpadding='3' cellspacing='0' width=560>
				<tbody>
				<tr>
					<td class='rankingHeader' align='left' nowrap='nowrap'>#&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>Rank&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=50%>Guild&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=50%>Character Name&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>Race&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>Class&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>Level&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap'>Honor - Kills&nbsp;</td>
				</tr>
				<?
				$res_color=2;
				$j=0;
				while($rowc = mysql_fetch_array($newquery)) {
					$j++;
					$MySQL_DB = @mysql_select_db($MySQL_Set['DBREALM'], $MySQL_CON);
					$queryb = mysql_query("SELECT displayname as dn FROM forum_accounts WHERE id_account='".$rowc['account']."'", $MySQL_CON) or die (mysql_error());
						
						$rowb = mysql_fetch_array($queryb);
						
							if($res_color==1) { $res_color=2; } else { $res_color=1; }
							
							$rowc['data'] = explode(' ',$rowc['data']);
							
							$char_gender = dechex($rowc['data'][36]);
							$char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
							$char_gender = $char_gender{3};
							if ($_REQUEST['f']=='alliance') { $ccolor='#000033'; } else { $ccolor='#660000'; }
							$echorow .="<tr bgcolor=black id='tabtr".$j."' OnMouseOver='javascript:this.style.backgroundColor=\"".$ccolor."\";' OnMouseOut='javascript:this.style.backgroundColor=\"black\";'>
									<td align='center'><span style='color: white;'>".$j."</span></td>
									<td align='center'><span onmouseover='ddrivetip(\"<b>".$CHAR_RANK[$CHAR_RACE[$rowc['race']][1]][pvp_ranks($rowc['honor'])]."</b>\")' onmouseout='hideddrivetip()' style='color: white;'><img src='new-hp/images/forum/icons/pvpranks/rank".pvp_ranks($rowc['honor'],$CHAR_RACE[$rowc['race']][1]).".gif'></span></td>
									<td align='left'><span style='color: white;'>".$rowc['guild']."</span></td>
									<td align='left'><span onmouseover='ddrivetip(\"<b>".$rowb['dn']."</b>\")' onmouseout='hideddrivetip()' style='color: white;'>".$rowc['name']."</span></td>
									<td align='center'><img onmouseover='ddrivetip(\"<b>".$CHAR_RACE[$rowc['race']][0]."</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/picons/".$rowc['race']."-".$char_gender.".gif'></td>
									<td align='center'><img onmouseover='ddrivetip(\"<b>".$CHAR_CLASS[$rowc['class']]."</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/picons/".$rowc['class'].".gif'></td>
									<td align='center'><span style='color: white;'>".$rowc['data'][34]."</td>
									<td align='center'><span style='color: green;'><b>".$rowc['honor']."</b></span><span style='color: white;'> - </span><span style='color: red;'>".$rowc['kills']."</td>
								</tr>";
						
					}
					echo $echorow;
					?>
				</tbody>
			</table>
			<?
			metalborderdown();
					} else {
						errborder('Realm has No Characters.');
					}
				} else {
					errborder('Couldn\'t Access the Realm.');
				}
		} else {
			errborder('Invalid Realm.');
		}

	} else {
		
		subtitle('Select a Faction:');
		
		?><table cellpadding='0' cellspacing='0' width=320>
				<tr>
					<td align=center>
						<a href='?n=workshop.pvprankings&r=<?php echo $_REQUEST['r'] ?>&f=alliance'><img src="new-hp/images/alliance.jpg"></a>
					</td>
					<td width=20>
					</td>
					<td align=center>
						<a href='?n=workshop.pvprankings&r=<?php echo $_REQUEST['r'] ?>&f=horde'><img src="new-hp/images/horde.jpg"></a>
					</td>
				</tr>
		</table>
		<?php
	}	
} else {

	subtitle('Select a Realm:');

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
				<b><span style='color: rgb(35, 67, 3);'><a href='?n=workshop.pvprankings&r=".$rowa['id']."&f=".$_REQUEST['f']."'>". $rowa['name']."</a></span><b></td>
			<td align=center class='serverStatus$res_color'>
				<span style='color: rgb(102, 13, 2);'>".$REALM_TYPE[$rowa['icon']]."</span></td>
		</tr>";
						
		}

		unset($mangos_db);
		?>
						</tbody>
					</table>

		</span>
</div>
		<?php

		metalborderdown();
		//ASKS FOR REALM
}

parchdown();

 ?>
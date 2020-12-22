<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title($_LANG['ACCOUNT']['REALM_STATUS']);

image('realm');

parchdown();

parchup(true);

if ($_REQUEST['t']=="") {
?>

<table border='0' cellpadding='0' cellspacing='0' width='90%'>
<tbody>
<tr>
	<td colspan='2'>
	<span>

	<?php echo $_LANG['ACCOUNT']['REALM_STATUS_INFO']; ?>
	<br>
	</span>
	</td>
</tr>
</table>
<?php

parchdown();

parchup(true);

subtitle($_LANG['ACCOUNT']['REALM_STATUS'].':');

metalborderup();
?>
<div style='cursor: auto;' id='dataElement'>
<span>
			<table cellpadding='3' cellspacing='0' width=620>
				<tbody>
				<tr>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=10%><?php echo $_LANG['ACCOUNT']['STATUS']; ?>&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=50%><?php echo $_LANG['ACCOUNT']['REALM_NAME']; ?>&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=20%><?php echo $_LANG['ACCOUNT']['TYPE']; ?>&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=20%><?php echo $_LANG['ACCOUNT']['POPULATION']; ?>&nbsp;</td>
				</tr>
				<tr>
					<td colspan='5' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
					</td>
				</tr>
<?php
$query = mysql_query("SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (realm_settings rs) ON r.id = rs.id_realm 
GROUP BY r.id ORDER BY r.name", $MySQL_CON) OR DIE(mysql_error());
$res_color=2;
while($rowa = mysql_fetch_array($query)) {

	if($res_color==1) { $res_color=2; } else { $res_color=1; }
	
	if(check_port_status($rowa['address'], $rowa['port'])===true) {
		$res_img = 'shared/wow-com/images/icons/serverstatus/uparrow2.gif';
		$res_alt = 'Up';
		
		$newcon = @mysql_connect($rowa['rsdbhost'].':'.$rowa['rsdbport'], $rowa['rsdbuser'], $rowa['rsdbpass']);
		$newdb = @mysql_select_db ($rowa['rsdbname'], $newcon);
		$newquery = @mysql_query("SELECT account FROM `characters` WHERE `online`='1'", $newcon);
		$population_str = @mysql_num_rows($newquery);
			
	} else {
		$res_img = 'shared/wow-com/images/icons/serverstatus/downarrow2.gif';
		$res_alt = 'Down';
		$population_str = 0;
	}
		echo "	<tr>
					<td class='serverStatus$res_color' align='center'><img src='".$res_img."' alt=".$res_img."></td>
					<td class='serverStatus$res_color'><b><span style='color: rgb(35, 67, 3);'>";
					if ($res_alt=='Up') { echo "<a href='index.php?n=account.realmstatus&t=".$rowa['id']."'>"; } 
					echo $rowa['name']."</a></span><b></td>
					<td align=center class='serverStatus$res_color'><span style='color: rgb(102, 13, 2);'>".$REALM_TYPE[$rowa['icon']]."</span></td>
					<td align=center class='serverStatus$res_color'><span style='color: rgb(35, 67, 3);'>".population_view($population_str) . "</span></td>
				</tr>";
				
}

unset($mangos_db);
?>
				</tbody>
			</table>

</span>
<?php

metalborderdown();

} else { 
	
	$query = "SELECT *, rs.dbhost as rsdbhost, rs.dbport as rsdbport,rs.dbuser as rsdbuser,
	rs.dbpass as rsdbpass,rs.dbname as rsdbname FROM `realmlist` r LEFT JOIN (realm_settings rs) ON r.id = rs.id_realm 
	WHERE id='".$_REQUEST['t']."' GROUP BY r.id ORDER BY r.name";
	
	$query = mysql_query($query, $MySQL_CON) OR DIE(mysql_error());

	if (mysql_num_rows($query)>0) {
	
		while($rowa = mysql_fetch_array($query)) {
	
			$res_color=2;
	
			if(check_port_status($rowa['address'], $rowa['port'])===true) {
		
				$newcon = mysql_connect($rowa['rsdbhost'].':'.$rowa['rsdbport'], $rowa['rsdbuser'], $rowa['rsdbpass'],true)or die (mysql_error());;
				$newdb = mysql_select_db ($rowa['rsdbname'],$newcon) or die (mysql_error());
				$newquery = mysql_query("SELECT account, name, race, data, class, map, position_x, position_y FROM `characters` c WHERE `online`='1'", $newcon) or die (mysql_error());
			
				if (mysql_num_rows($newquery)>0) {
				
				subtitle($rowa['name'].' - '.$_LANG['ACCOUNT']['PLAYERS_ONLINE'].' ('.mysql_num_rows($newquery).'):');
		
					metalborderup();
				
				
	?>
<div style='cursor: auto;' id='dataElement'>
<span>
				<table cellpadding='3' cellspacing='0' width=620>
					<tbody>
					<tr>
						<td class='rankingHeader' align='left' nowrap='nowrap' width=2%>#&nbsp;</td>
						<td class='rankingHeader' align='left' nowrap='nowrap' width=30%><?php echo $_LANG['ACCOUNT']['NAME']; ?>&nbsp;</td>
						<td class='rankingHeader' align='left' nowrap='nowrap' width=10%><?php echo $_LANG['ACCOUNT']['RACE']; ?>&nbsp;</td>
						<td class='rankingHeader' align='left' nowrap='nowrap' width=10%><?php echo $_LANG['ACCOUNT']['CLASS']; ?>&nbsp;</td>
						<td class='rankingHeader' align='left' nowrap='nowrap' width=10%><?php echo $_LANG['ACCOUNT']['LEVEL']; ?>&nbsp;</td>
						<td class='rankingHeader' align='left' nowrap='nowrap' width=33%><?php echo $_LANG['ACCOUNT']['LOCATION']; ?>&nbsp;</td>
					</tr>
					<tr>
						<td colspan='7' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
						</td>
					</tr>	
		
		<?php
					while($rowc = mysql_fetch_array($newquery)) {
					
					$MySQL_DB = @mysql_select_db($MySQL_Set['DBREALM'], $MySQL_CON);
					$queryb = mysql_query("SELECT id, username, gmlevel, last_login, fa.displayname as dn 
					FROM `account` a LEFT JOIN (`forum_accounts` fa) ON a.id = fa.id_account 
					WHERE a.id='".$rowc['account']."' GROUP BY a.id ORDER BY a.username", $MySQL_CON) or die (mysql_error());
						
						$rowb = mysql_fetch_array($queryb);
						
							if($res_color==1) { $res_color=2; } else { $res_color=1; }
							
							$rowc['data'] = explode(' ',$rowc['data']);
							
							$char_gender = dechex($rowc['data'][36]);
							$char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
							$char_gender = $char_gender{3};
							
							$echorow .="<tr>
									<td class='serverStatus$res_color' align='center'><span style='color: rgb(35, 67, 3);'>".$rowb['id']."</td>
									<td class='serverStatus$res_color' align='left'><span onmouseover='ddrivetip(\"<b>".$rowb['dn']."</b>";
							if (verifylevel($_SESSION['userid'])>0) {
								$echorow .= " (".$rowb['username'].")<br><i>" . $USER_LEVEL[$rowb['gmlevel']]."</i><br>";
							}
							
							$echorow .= "\")' onmouseout='hideddrivetip()' style='color: rgb(35, 67, 3);'>".$rowc['name']."</small></td>
									<td class='serverStatus$res_color' align='center'><img onmouseover='ddrivetip(\"<b>".$CHAR_RACE[$rowc['race']][0]."</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/picons/".$rowc['race']."-".$char_gender.".gif'></td>
									<td class='serverStatus$res_color' align='center'><img onmouseover='ddrivetip(\"<b>".$CHAR_CLASS[$rowc['class']]."</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/picons/".$rowc['class'].".gif'></td>
									<td class='serverStatus$res_color' align='center'><span style='color: rgb(102, 13, 2);'>".$rowc['data'][34]."</td>
									<td class='serverStatus$res_color' align='center'><span style='color: rgb(35, 67, 3);'>".playerpos($rowc['map'],$rowc['position_x'],$rowc['position_y'])."</td>
								</tr>";
					}
					echo $echorow;
		?>
			</tbody>
			</table>

</span>
</div>
		<?php
		
					metalborderdown();
				
					echo '<br>';		
					
				} else {
				
					errborder($_LANG['ERROR']['REALM_NO_ON_CHARS']);
					
					echo '<br>';			
		
				}
		
			} else {
			
				subtitle($rowa['name'].':');
				
				errborder($_LANG['ERROR']['REALM_OFFLINE']);

				echo '<br>';
				
			}
		
		}
		
	} else {
	
		errborder($_LANG['ERROR']['REALM_NOT_EXISTS']);
	
	}
	
?>

<?php

}

parchdown();
?>

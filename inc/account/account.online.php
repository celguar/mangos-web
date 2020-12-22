<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title($_LANG['ACCOUNT']['ACCOUNTS_ONLINE']);

subnav($_LANG['ACCOUNT']['ACCOUNTS_ONLINE']);

parchdown();

parchup(true);

echo $_LANG['ACCOUNT']['ACCOUNTS_ONLINE_INFO'];

$dbquery = mysql_query("SELECT page, TIMESTAMPDIFF(MINUTE, CONVERT_TZ(`time`, '".$GMT[$SETTING['WEB_GMT']][0]."', fa.gmt), NOW()) as time, fa.displayname as dn FROM web_online wo LEFT JOIN (forum_accounts fa) ON wo.id = fa.id_account", $MySQL_CON) or die (mysql_error());

if (mysql_num_rows($dbquery)>0) {
	
	metalborderup();
	?>
	<table cellpadding='3' cellspacing='0' width=620>
		<tbody>
			<tr>
				<td class='rankingHeader' align='left' nowrap='nowrap' width=10%><?php echo $_LANG['ACCOUNT']['ACCOUNT']; ?>&nbsp;</td>
				<td class='rankingHeader' align='left' nowrap='nowrap' width=50%><?php echo $_LANG['ACCOUNT']['LOCATION']; ?>&nbsp;</td>
				<td class='rankingHeader' align='left' nowrap='nowrap' width=20%><?php echo $_LANG['ACCOUNT']['LAST_UPDATE']; ?>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='5' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
				</td>
			</tr>
	<?php

	$res_color=2;
	while($rowd	= mysql_fetch_array($dbquery)) {
	
		if($res_color==1) { $res_color=2; } else { $res_color=1; }
		
		$rowd['page']=parse_url($rowd['page'], PHP_URL_QUERY);
		$loc=explode('&',$rowd['page']);
		
		for ($i=0;$i<count($rowd['page']);$i++) {
			$loc[$i]=explode('=',$loc[$i]);
			eval("$".$loc[$i][0]."='".$loc[$i][1]."';");
		}
		
		switch($n) {
			case "account.online";
				$rowd['page'] = $_LANG['ACCOUNT']['VIEW_ONLINE_ACCOUNTS'];
			break;
			default:
				$rowd['page'] = $_LANG['ACCOUNT']['UNKNOWN'] . ' - '.$rowd['page'];
			break;
		}
		
		echo "<tr>
				<td class='serverStatus$res_color' align='center'><span style='color: rgb(102, 13, 2);'>".$rowd['dn']."</span></td>
				<td class='serverStatus$res_color'><b><span style='color: rgb(35, 67, 3);'>".$rowd['page']."</span></td>
				<td align=center class='serverStatus$res_color'><span style='color: rgb(102, 13, 2);'>".gmtdate($rowd['time'], '',$rowd['time'])."</span></td>
			</tr>";
	}
	
	?>
		</tbody>
	</table>
	<?php
	
	metalborderdown();
	
} else {
	errborder('No Accounts were found with On-Line status.');
}

parchdown();

?>

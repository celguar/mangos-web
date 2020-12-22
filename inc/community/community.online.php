<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title('Users On-Line');

subnav('Community');

parchdown();

parchup(true);

?>
This data is based on accounts active over the past 5 minutes<br><br>
<?php

$dbquery = mysql_query("SELECT *, DATE_FORMAT(CONVERT_TZ(wo.`time`, '".$GMT[$SETTING['WEB_GMT']][0]."', '".verifygmt($_SESSION['userid'])."'), '%d-%m-%Y at %h:%i %p') as `time`, fa.displayname as dn FROM web_online wo LEFT JOIN (forum_accounts fa) ON wo.id = fa.id_account ORDER BY isguest, dn, id", $MySQL_CON) or die (mysql_error());

if (mysql_num_rows($dbquery)>0) {
	
	metalborderup();
	?>
	<table cellpadding='3' cellspacing='0' width=620>
		<tbody>
			<tr>
				<td class='rankingHeader' align='left' nowrap='nowrap' width=10%>Account&nbsp;</td>
				<td class='rankingHeader' align='left' nowrap='nowrap' width=50%>Location&nbsp;</td>
				<td class='rankingHeader' align='left' nowrap='nowrap' width=20%>Last Update&nbsp;</td>
			</tr>
			<tr>
				<td colspan='5' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
				</td>
			</tr>
	<?php

	$res_color=2;
	while($rowd	= mysql_fetch_array($dbquery)) {
	
		if($res_color==1) { $res_color=2; } else { $res_color=1; }
		
		if ($rowd['isguest']=='1') { $rowd['dn']='Guest '.$rowd['id']; }
		
		echo "<tr>
				<td class='serverStatus$res_color' align='center'><span style='color: rgb(102, 13, 2);'>".$rowd['dn']."</span></td>
				<td class='serverStatus$res_color'><b><span style='color: rgb(35, 67, 3);'>".onlinelocation($rowd['page'])."</span></td>
				<td align=center class='serverStatus$res_color'><span style='color: rgb(102, 13, 2);'>".$rowd['time']."</span></td>
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
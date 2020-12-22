<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title("Staff Personel");

subnav('Support');

parchdown();

parchup(true);

metalborderup();
?>
<div style='cursor: auto;' id='dataElement'>
<span>
			<table cellpadding='3' cellspacing='0' width=320>
				<tbody>
				<tr>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=50%>Account&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=20%>E-Mail&nbsp;</td>
					<td class='rankingHeader' align='left' nowrap='nowrap' width=20%>Status&nbsp;</td>
				</tr>	
<?php
		$query = mysql_query("SELECT id, email, gmlevel, fa.displayname as dn, fa.enableemail as eemail, fa.enablepm as epm FROM `account` a 
		LEFT JOIN (forum_accounts fa) ON a.id = fa.id_account 
		WHERE gmlevel>0 GROUP BY a.id ORDER BY gmlevel DESC, a.id ASC", $MySQL_CON) OR DIE(mysql_error());
		$res_color=2;
		$gmlvl=0;
		while($rowa = mysql_fetch_array($query)) {
		
			if($res_color==1) { $res_color=2; } else { $res_color=1; }
			if ($gmlvl!=$rowa['gmlevel']) {
				echo "<tr>
						<td class='rankingHeader' colspan=3 align='center' nowrap='nowrap'>".$USER_LEVEL[$rowa['gmlevel']]."</td>
					</tr>
					<tr>
						<td colspan='3' background='shared/wow-com/images/borders/metalborder/shadow.gif' height=8>
						</td>
					</tr>";
				$gmlvl=$rowa['gmlevel'];
				$res_color=1;
			}
			if (isset($_SESSION['userid']) AND $rowa['epm']=='1') { $rowa['dn']='<a href="?n=account.pm&f=send&to='.$rowa['dn'].'">'.$rowa['dn'].'</a>'; }
			if ($rowa['eemail']=='1') { $rowa['email']="<a href='mailto:".$rowa['email']."'>".$rowa['email'].'</a>'; } else { $rowa['email']='&nbsp;'; }
			
			echo "<tr><td class='serverStatus$res_color'>
					<b><span style='color: rgb(35, 67, 3);'>". $rowa['dn']."</span><b></td>
				<td align=left class='serverStatus$res_color'>";
			echo "<span style='color: rgb(102, 13, 2);'>".$rowa['email']."</span></td>
				<td align=center class='serverStatus$res_color'>";
				if (@mysql_num_rows(@mysql_query("SELECT page FROM web_online WHERE id='".$rowa['id']."'"))==1) {
					echo "<img onmouseover='ddrivetip(\"<b>On-Line on Website</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/favicon.gif'>";
				} else {
					echo "<img onmouseover='ddrivetip(\"<b>Off-Line</b>\")' onmouseout='hideddrivetip()' src='new-hp/images/favicon-bnw.gif'>";
				}
				echo "</td>
			</tr>";
							
			}
		?>
						</tbody>
					</table>

		</span>
</div>

<?php

metalborderdown();

parchdown();

?>

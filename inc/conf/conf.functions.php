<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

function addslashall() {

	foreach ($_POST as $key=>$value) {
		if (is_array($value)) {
			foreach ($value as $key2=>$value2) {
				$_POST[$key][$key2] = addslashes($value2);
			}
		} else {
			$_POST[$key] = addslashes($value);
		}
	}

	foreach ($_REQUEST as $key=>$value) {
		$_REQUEST[$key] = addslashes($value);
	}

}

addslashall(); // Prevents SQL Injection

function remslashall() {

	foreach ($_POST as $key=>$value) {
		if (is_array($value)) {
			foreach ($value as $key2=>$value2) {
				$_POST[$key][$key2] = stripslashes($value2);
			}
		} else {
			$_POST[$key] = stripslashes($value);
		}
	}

	foreach ($_REQUEST as $key=>$value) {
		$_REQUEST[$key] = stripslashes($value);
	}

}

function newdbsettings($h, $pt, $u, $pw, $db) {

		$fh = fopen('inc/conf/conf.database.php', 'w');
		if ($fh) {
		$stringData = "<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

\$MySQL_Set = array(
'HOST' => '".$h."',
'PORT' => '".$pt."',
'USERNAME' => '".$u."',
'PASSWORD' => '".$pw."',
'DBREALM' => '".$db."',
);

\$MySQL_CON = @mysql_connect(\$MySQL_Set['HOST'].':'.\$MySQL_Set['PORT'], \$MySQL_Set['USERNAME'], \$MySQL_Set['PASSWORD']);
if (!\$MySQL_CON) { \$haserrors.=mysql_error().'<br>'; }
\$MySQL_DB = @mysql_select_db(\$MySQL_Set['DBREALM'], \$MySQL_CON);
if (!\$MySQL_DB) { \$haserrors.=mysql_error().'<br>'; }
?>";

		fwrite($fh, $stringData);
		fclose($fh);

			return true;
		} else {
			return false;
		}
}

function bbcode($str, $entities=true, $null=true, $isbb=true, $issmile=true) {

	if ($entities) $str = htmlentities($str);
	if ($null) $str = nl2br($str);

	if ($isbb==true) {
	    $simple_search = array(
					//By Me TAGS
					'/\[indent\=([1-3])\](.*?)\[\/indent\]/is',
	                '/\[community\](.*?)\[\/community\]/is',
					'/\[youtube\](.*?)youtube\.com\/watch\?v\=(.*?)\[\/youtube\]/is',
	                //added line break
					'/\[hr\]/is',
	                '/\[b\](.*?)\[\/b\]/is',
	                '/\[i\](.*?)\[\/i\]/is',
	                '/\[u\](.*?)\[\/u\]/is',
					// added nofollow to prevent spam
					'/\[anchor\=(.*?)\](.*?)\[\/anchor\]/is',
	                '/\[url\=(.*?)\](.*?)\[\/url\]/is',
	                '/\[url\](.*?)\[\/url\]/is',
	                '/\[left\](.*?)\[\/left\]/is',
					'/\[right\](.*?)\[\/right\]/is',
					'/\[center\](.*?)\[\/center\]/is',
					//added alt attribute for validation
	                '/\[img\](.*?)\[\/img\]/is',
	                '/\[email\=(.*?)\](.*?)\[\/email\]/is',
	                '/\[email\](.*?)\[\/email\]/is',
	                '/\[font\=(.*?)\](.*?)\[\/font\]/is',
	                '/\[size\=(.*?)\](.*?)\[\/size\]/is',
	                '/\[color\=(.*?)\](.*?)\[\/color\]/is',
	                 //added textarea for code presentation
					'/\[codearea\](.*?)\[\/codearea\]/is',
					//added pre class for code presentation
					'/\[code\](.*?)\[\/code\]/is',
					//added paragraph
					'/\[p\](.*?)\[\/p\]/is',
					'/\[quote\](.*?)\[\/quote\]/is',
					//By Me REPS
					'/\%SITENAME\%/is',
					'/\%USERNAME\%/is',
					);
	    $simple_replace = array(
					//By Me
					'<div style="margin: -5px 0 -5px ${1}cm">$2</div>',
					'<div class="community-watch">$1</div>',
					'<embed type="application/x-shockwave-flash" wmode="transparent" width="425" height="366" src="http://www.youtube.com/v/$2"></embed>',
					//added line break
					'<hr>',
	                '<strong>$1</strong>',
	                '<em>$1</em>',
	                '<u>$1</u>',
					// added nofollow to prevent spam
					'<a name="$1">$2</a>',
	                '<a href="$1">$2</a>',
					'<a href="$1">$1</a>',
	                '<div style="text-align: left;">$1</div>',
					'<div style="text-align: right;">$1</div>',
					'<div style="text-align: center;">$1</div>',
					//added alt attribute for validation
	                '<img src="$1" border=0>',
	                '<a href="mailto:$1" target="_blank">$2</a>',
	                '<a href="mailto:$1" target="_blank">$1</a>',
	                '<span style="font-family: $1;">$2</span>',
	                '<span style="font-size: $1;">$2</span>',
	                '<span style="color: $1;">$2</span>',
					//added textarea for code presentation
					'<textarea class="code_container" rows="30" cols="70">$1</textarea>',
					//added pre class for code presentation
					'<blockquote><small><hr color="#9e9e9e" noshade="noshade" size="1"><small class="white">Code:</small><br><div style="overflow: auto; background-color: #666666; color: #FFFFFF; width: 100%; max-height: 300px; height: expression(this.scrollHeight > 300 ? 300 : true); white-space: nowrap;"><pre class="code">$1</pre></div><hr color="#9e9e9e" noshade="noshade" size="1"></small></blockquote>',
					//added paragraph
					'<p>$1</p>',
					'<blockquote><small><hr color="#9e9e9e" noshade="noshade" size="1"><small class="white">Quote:</small><br>$1<hr color="#9e9e9e" noshade="noshade" size="1"></small></blockquote>',
					//By Me REPS
					$GLOBALS['SETTING']['WEB_SITE_NAME'],
					$_SESSION['nickname'],
	                );

	    // Do simple BBCode's

	    $str = preg_replace ($simple_search, $simple_replace, $str);

		//Listing
		preg_match_all ("/\[list\](.*?)\[\*\](.*?)\[\/list\]/si", $str, $match);
		for ($j=0;$j<=count($match[0]);$j++) {
			for ($i=0;$i<=substr_count($match[0][$j], '[*]');$i++) {
				$str = preg_replace ("/\[list\](.*?)\[\*\](.*?)\[\/list\]/si", "[list]$1</li><li>$2[/list]", $str);
			}
		}
		$str = preg_replace ("/\[list\](.*?)\[\/list\]/si", "<ul><li>$1</li></ul>", $str);

		preg_match_all ("/\[list=([aAiI1])\](.*?)\[\*\](.*?)\[\/list\]/si", $str, $match);
		for ($j=0;$j<=count($match[0]);$j++) {
			for ($i=0;$i<=substr_count($match[0][$j], '[*]');$i++) {
				$str = preg_replace ("/\[list\=([aAiI1])\](.*?)\[\*\](.*?)\[\/list\]/si", "[list=$1]$2</li><li>$3[/list]", $str);
			}
		}
		$str = preg_replace ("/\[list=([aAiI1])\](.*?)\[\/list\]/si", "<ol type=$1><li>$2</li></ol>", $str);
	}

	if ($issmile==true) {
		/*
		//Smiles
		$querysm=mysql_query('SELECT * FROM `forum_smiles`', $GLOBALS['MySQL_CON']);
		while ($row = mysql_fetch_array($querysm)) {
			$key[] = '/'.preg_quote($row['id_smile']).'/';
			$value[] = '<img src="'.$row['path'].'">';
		}
		$str = preg_replace ($key, $value, $str);
		*/
	}

    return $str;
}

function bbcode_toolbar($inputname) {

$getbyid=explode('.',$inputname);
$getbyid=$getbyid[count($getbyid)-1];

?>
<script language=javascript src="new-hp/js/quick_reply.js"></script>
<table cellpadding=0 cellspacing=0 width=225>
<style>
img.mousing:link, img.mousing:visited {
	background-color: transparent;
}
img.mousing:hover {
	background-color: orange;
}
img.mousing:active {
	background-color: darkorange;
}
</style>
	<tr>
		<td><img class="mousing" src="new-hp/images/bbcode/bold.gif" id=ed_bold onclick="edInsertTag(<? echo $inputname; ?>, 0);" value="B" alt="Bold"></td>
		<td><img class="mousing" src="new-hp/images/bbcode/italic.gif" id=ed_italic onclick="edInsertTag(<? echo $inputname; ?>, 1);" value="I" alt="Italic"></td>
		<td><img class="mousing" src="new-hp/images/bbcode/underline.gif" id=ed_underline onclick="edInsertTag(<? echo $inputname; ?>, 2);" value="U" alt="Underline"></td>
		<td><img class="mousing" src="new-hp/images/bbcode/left.gif" id=ed_left onclick="edInsertTag(<? echo $inputname; ?>, 3);" value="B" alt="Left"></td>
		<td><img class="mousing" src="new-hp/images/bbcode/center.gif" id=ed_center onclick="edInsertTag(<? echo $inputname; ?>, 4);" value="I" alt="Center"></td>
		<td><img class="mousing" src="new-hp/images/bbcode/right.gif" id=ed_right onclick="edInsertTag(<? echo $inputname; ?>, 5);" value="U" alt="Right"></td>
		<td><img class="mousing" src="new-hp/images/bbcode/link.gif" id=ed_link onclick="edInsertLink(<? echo $inputname; ?>, 2);" value="Link" alt="Link"></td>
		<td><img class="mousing" src="new-hp/images/bbcode/image.gif" id=ed_img onclick="edInsertImage(<? echo $inputname; ?>);" value="Image" alt="Image"></td>
		<td><img class="mousing" src="new-hp/images/bbcode/quote.gif" id=ed_quote onclick="edInsertTag(<? echo $inputname; ?>, 8);" value="Quote" alt="Quote"></td>
	</tr>
</table>
<?php
}

function secuimg($length) {
	$p_chars="abcdefghijklmnopqrstuvwxyz123456789";
	while(strlen($out_str)< $length)
	{
		$out_str.=substr($p_chars,(rand()%(strlen($p_chars))),1);
	}
	$_SESSION['CA_key'] = $out_str;
	return $out_str;
}

function bday($iDay, $iMonth, $iYear) {

    $year_diff  = date("Y") - $iYear;
    $month_diff = date("m") - $iMonth;
    $day_diff   = date("d") - $iDay;
    if ($month_diff < 0) $year_diff--;
    elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
    return $year_diff;
}


function cleanCA($sstr) {

	if ($sstr=="") {

		unset($_SESSION['CA_key']);

		unset($_SESSION['CA_u']);
		unset($_SESSION['CA_p']);
		unset($_SESSION['CA_ask']);
		unset($_SESSION['CA_ans']);
		unset($_SESSION['CA_tbc']);

		unset($_SESSION['CA_fname']);
		unset($_SESSION['CA_lname']);
		unset($_SESSION['CA_city']);
		unset($_SESSION['CA_lo']);
		unset($_SESSION['CA_em']);
		unset($_SESSION['CA_shem']);
		unset($_SESSION['CA_bd']);
		unset($_SESSION['CA_shbd']);
		unset($_SESSION['CA_gmt']);
		unset($_SESSION['CA_shpm']);
		unset($_SESSION['CA_msn']);
		unset($_SESSION['CA_icq']);
		unset($_SESSION['CA_aim']);
		unset($_SESSION['CA_yahoo']);
		unset($_SESSION['CA_skype']);
		unset($_SESSION['CA_sig']);
		unset($_SESSION['CA_avtrd']);
		unset($_SESSION['CA_weburl']);
		unset($_SESSION['CA_accountset']);
		unset($_SESSION['CA_userset']);
		unset($_SESSION['CA_valcode']);
		unset($_SESSION['CA_skin']);
		unset($_SESSION['CA_nick']);

	}
}

function sendemail($to_email,$to_name,$theme,$text_text,$text_html=''){

	if (extension_loaded('openssl')) {
	    set_time_limit(300);
	    require_once 'inc/mail/smtp.php';
	    $mail = new SMTP;
	    $mail->Delivery('relay');
	    $mail->Relay($GLOBALS['SETTING']['EMAIL_HOST'],$GLOBALS['SETTING']['EMAIL_USERNAME'],$GLOBALS['SETTING']['EMAIL_PASSWORD'], intval($GLOBALS['SETTING']['EMAIL_PORT']), $GLOBALS['SETTING']['EMAIL_AUTH'], $GLOBALS['SETTING']['EMAIL_SSL']);
	    $mail->From($GLOBALS['SETTING']['EMAIL_MAIN'], $GLOBALS['SETTING']['WEB_SITE_NAME']);
	    $mail->AddTo($to_email, $to_name);
	    $mail->Text($text_text);
	    if($text_html)$mail->Html($text_html);
	    $sent = $mail->Send($theme);
	    return $sent;
	} else {
		errborder('Extension OpenSSL Must be Enabled!');
	}
}

function verifylevel($uid) {

	if ($_SESSION['userid']==$GLOBALS['SETTING']['SERVER_OWNER']) {

		return 4;

	} else {
		mysql_select_db($GLOBALS['MySQL_Set']['DBREALM'], $GLOBALS['MySQL_CON']);
		$dbquery = mysql_query("SELECT gmlevel FROM account WHERE id='".$uid."'", $GLOBALS['MySQL_CON']);

		if (mysql_num_rows($dbquery)==1) {
			$row = mysql_fetch_array($dbquery);
			return $row['gmlevel'];
		} else {
			return -1;
		}
	}
}

function verifygmt($uid) {

	$dbquery = mysql_query("SELECT gmt FROM forum_accounts WHERE id_account='".$uid."'", $GLOBALS['MySQL_CON']);

	if (mysql_num_rows($dbquery)==1) {
		$row = mysql_fetch_array($dbquery);
		return $GLOBALS['GMT'][$row['gmt']][0];
	} else {
		return $GLOBALS['GMT'][$GLOBALS['SETTING']['WEB_GMT']][0];
	}

}

function validatelogin() {

	if (isset($_SESSION['userid'])) {
		$dbquery = mysql_query("SELECT a.id, fa.displayname as fdn FROM account a LEFT JOIN (forum_accounts fa) ON fa.id_account = a.id WHERE sha_pass_hash='".$_SESSION['password']."' AND id='".$_SESSION['userid']."' GROUP BY a.id", $GLOBALS['MySQL_CON']);

		if (mysql_num_rows($dbquery)!=1) {
			log_out(false);
			echo '<div style="position: absolute; z-index: 999999999; text-align: center;">';
			errborder($GLOBALS['_LANG']['ERROR']['BAD_LOGIN']);
			echo '</div>';
		} else {
			$dbquery=mysql_fetch_array($dbquery);
			$_SESSION['nickname']=$dbquery['fdn'];
			$dbquery = mysql_query("DELETE FROM `web_online` WHERE id='".$_SESSION['guestid']."' AND isguest='1'", $GLOBALS['MySQL_CON']);
			unset($_SESSION['guestid']);
		}
	} else if ($_SESSION['guestid']=='') {
		$qr = mysql_fetch_array(mysql_query("SELECT id FROM `web_online` WHERE isguest=1 ORDER BY id DESC LIMIT 0, 1", $GLOBALS['MySQL_CON']));
		$_SESSION['guestid'] = ($qr['id'] + 1);
	}
}

function log_out($redirect=true) {

	@mysql_query('DELETE FROM web_online WHERE id="'.$_SESSION['userid'].'"', $GLOBALS['MySQL_CON']);
	unset($_SESSION['username']);
	unset($_SESSION['password']);
	unset($_SESSION['userid']);
	unset($_SESSION['nickname']);

	?><script src="new-hp/js/cookies.js" type="text/javascript"></script>
	<script>
	setCookie("ALOG_ID", '', now);
	setCookie("ALOG_USER", '', now);
	setCookie("ALOG_PASS", '', now);
	</script>
	<?
	if ($redirect==true) {echo '<script> window.location="?" </script>'; }

}

function valemail($stremail) {

	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $stremail)) {
		return true;
	} else {
		return false;
	}

}

function valdate($strdate, $miny = 0, $maxy = 0) {

	if ($miny== 0) { $miny  = date("Y")-100; }
	if ($maxy== 0) { $maxy = date("Y")-1; }

	if((strlen($strdate)<10)OR(strlen($strdate)>10)){
		return false;
	}
	else{

		if((substr_count($strdate,"/"))<>2){
		return false;
		}
		else{
			$pos=strpos($strdate,"/");
			$date=substr($strdate,0,($pos));
			$result=ereg("^[0-9]+$",$date,$trashed);
			if(!($result)){return false;}
			else{
			if(($date<=0)OR($date>31)){return false;}
			}
			$month=substr($strdate,($pos+1),($pos));
			if(($month<=0)OR($month>12)){return false;}
			else{
			$result=ereg("^[0-9]+$",$month,$trashed);
			if(!($result)){return false;}
			}
			$year=substr($strdate,($pos+4),strlen($strdate));
			$result=ereg("^[0-9]+$",$year,$trashed);
			if(!($result)){return false;}
			else{
				if(($year<$miny)OR($year>$maxy)){return false;}
			}
		}
	}
	return true;
}

function alphanum($sstr, $num=true, $alpha=true, $extra="") {

	$exp="^[";
	if ($alpha==true) { $exp.="a-zA-Z"; }
	if ($num==true) { $exp.="0-9"; }
	$exp.=$extra;
	$exp.="]{".strlen($sstr).",".strlen($sstr)."}$";

	return ereg($exp,$sstr);

}

function newrssfeed() {

		$link=str_replace('\\','',$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));

		$stringData .= '<?xml version="1.0" encoding="windows-1252"?>
		<rss version="2.0">
			<channel>
			<link>http://'.$link.'/</link>
			<title>'.$GLOBALS['SETTING']['WEB_SITE_NAME'].'</title>
			<description>Lastest News</description>';

		@mysql_select_db($GLOBALS['MySQL_Set']['DBREALM'], $GLOBALS['$MySQL_CON']);
		$query= mysql_query("SELECT id_post, isbbcode, `text`, DATE_FORMAT(`date`, '%Y-%m') as datei, DATE_FORMAT(CONCAT(`date`,' ',`hour`), '%d-%m-%Y at %H:%i:%s') as `date`, fa.displayname as dn, ft.title as title FROM `forum_posts` fp
				INNER JOIN `forum_accounts` fa ON (fa.id_account = fp.id_account)
				INNER JOIN `forum_topics` ft ON (ft.id_topic = fp.id_topic)
				WHERE ft.category=1 AND ft.`viewlevel` <= 0 AND isreply=0
				GROUP BY fp.id_post ORDER BY fp.date DESC, fp.hour DESC LIMIT 0, 20", $GLOBALS['MySQL_CON']) OR DIE(mysql_error());

		while ($row2 = mysql_fetch_array($query)) {

			$stringData .='<item>
							<link>http://'.$link.'/?n=news.archive&amp;m='.$row2['datei'].'#'.$row2['id_post'].'</link>
							<title>'.$row2['title'].' - '.$row2['dn'].' on '.$row2['date'].'</title>
							<description>'.htmlentities(bbcode($row2['text'],true,true,$row2['isbbcode'])).'</description>
							<guid isPermaLink="false">'.$row2['id_post'].'</guid>
						</item>';

		}

		$stringData .='</channel>
					</rss>';

		$fh = @fopen('inc/news/news.rss.xml', 'w');
		@fwrite($fh, $stringData);
		@fclose($fh);
}

function population_view($n) {
	$low=100; $medium=200; $high=300;
	if($n==0){return 'N/A (0)';}
	elseif($n < $low){return 'Low ('.$n.')';}
	elseif($n >= $low && $n < $medium){return 'Medium ('.$n.')';}
	elseif($n >= $high){return 'High ('.$n.')';}
}

function check_port_status($ip, $port, $delay=0.5) {
	error_reporting(0);
	$fp = fsockopen($ip, $port, $e,$f, (float) $delay);
	if($fp) {
		return true;
		fclose($fp);
	} else {
		return false;
	}
	error_reporting(1);
}

function playerpos($mapid, $x, $y) {

global $MAP, $ZONE;
if (!empty($MAP[$mapid]))
  {
  $zmap=$MAP[$mapid];
  if (($mapid==0) or ($mapid==1))
    {
    $i=0; $c=count($ZONE[$mapid]);
    while ($i<$c)
      {
  if ($ZONE[$mapid][$i][2] < $x  AND $ZONE[$mapid][$i][3] > $x AND $ZONE[$mapid][$i][1] < $y  AND $ZONE[$mapid][$i][0] > $y) { $zmap.=' - '. $ZONE[$mapid][$i][4]; break; }
      $i++;
      }
    }
  } else $zmap="Unknown zone";
return $zmap;

}

function setonline($page) {

	if (isset($_SESSION['userid'])) {
		mysql_select_db ($GLOBALS['MySQL_Set']['DBREALM'], $GLOBALS['MySQL_CON']);
		mysql_query('INSERT INTO web_online VALUES("'.$_SESSION['userid'].'","'.$page.'","'.date('Y-m-d H:i:s').'", "'.$_SERVER['REMOTE_ADDR'].'", 0) ON DUPLICATE KEY UPDATE page="'.$page.'", time ="'.date('Y-m-d H:i:s').'", ip="'.$_SERVER['REMOTE_ADDR'].'", isguest=0', $GLOBALS['MySQL_CON']) OR DIE (mysql_error());
	} else {
		mysql_query('INSERT INTO web_online VALUES("'.$_SESSION['guestid'].'","'.$page.'","'.date('Y-m-d H:i:s').'", "'.$_SERVER['REMOTE_ADDR'].'", 1) ON DUPLICATE KEY UPDATE page="'.$page.'", time ="'.date('Y-m-d H:i:s').'", ip="'.$_SERVER['REMOTE_ADDR'].'", isguest=1', $GLOBALS['MySQL_CON']) OR DIE (mysql_error());
	}
	@mysql_query('DELETE FROM web_online WHERE TIMESTAMPDIFF(MINUTE, `time`, NOW())>=5', $GLOBALS['MySQL_CON']);

}

function pages($currentpage, $totalrows, $rowsperpage, $url, $sep='&nbsp;|&nbsp;', $arrows=true, $uptopage=0, $incdiv=true) {


	if ($incdiv==true) {
		echo '<div align=center style="width: 80%;">';
	}

	$totalpages=ceil($totalrows/$rowsperpage);

	for ($i=1;$i<=$totalpages;$i++) {
		if ($i>$uptopage AND $uptopage >0) {
			$pages .= ".&nbsp;.&nbsp;<a href='".$url."&p=".$totalpages."'>Last</a>";
			break;
		} else if ($currentpage!=$i) {
			$pages .= "<a href='".$url."&p=".$i."'>".$i."</a>";
		} else {
			$pages .= "<a href='".$url."&p=".$i."' class='current'><b>".$i."</b></a>";
		}
		if ($i < $totalpages) { $pages .= $sep; }
	}

	if ($arrows==true) {
		if (($currentpage - 1)<1) { $lowpage=1; } else { $lowpage=$currentpage-1 ;}
		if (($currentpage + 1)>$totalpages) { $highpage=$totalpages; } else { $highpage=$currentpage+1 ;}
		$pages = '<td><a href="'.$url.'&p='.$lowpage.'"><img SRC="new-hp/images/forum/arrow-left.gif" border=0></a></td><td><small>'.$pages.'</small></td><td><a href="'.$url.'&p='.$highpage.'"><img SRC="new-hp/images/forum/arrow-right.gif" border=0></a></td>';
	}

	if ($totalpages>1) { return $pages; }

	if ($incdiv==true) {
		echo '</div>';
	}

}

function convdate($mins) {

	if (stristr($mins,'-') != false) { $mins *=-1; }

	if ($mins<(1)) {
		return 'Less than a Minute';
	} else if ($mins>=(1) AND $mins<(60) ) {
		return $mins.' Minute(s)';
	} else if ($mins>=(60) AND $mins<(60*24)) {
		return round($mins/60,0).' Hour(s)';
	} else {
		return round($mins/60/24,0).' Day(s)';
	}
}

function savenewss($txtp) {
	$fc=0;
	foreach(glob("media/screenshots/*.jpg") as $filename) {
		$fc++;
		$css[$fc] = $filename;
	}
	$fc = rand(1,($fc));
	$css = $css[$fc];
	$fh = @fopen($txtp, 'w');
	@fwrite($fh, date('Y-m-d') . '|' . $css);
	@fclose($fh);
	return $css;
}

function validateip() {
	$allow=true;
	$dbquery = mysql_query("SELECT ip FROM ip_banned", $GLOBALS['MySQL_CON']) OR DIE (mysql_error());
	while ($row =  mysql_fetch_array($dbquery)) {
		if ($row['ip']==$_SERVER['REMOTE_ADDR']) {
			$allow=false;
			break;
		} else {
			$ipdb = explode('.',$row['ip']);
			$ipuser = explode('.',$_SERVER['REMOTE_ADDR']);
			if ($ipdb[0]==$ipuser[0] AND $ipdb[1]=='0' AND $ipdb[2]=='0' AND $ipdb[3]=='0') {

				$allow=false;
				break;

			} else if ($ipdb[0]==$ipuser[0]) {

				if ($ipdb[1]==$ipuser[1] AND $ipdb[2]=='0' AND $ipdb[3]=='0') {

					$allow=false;
					break;

				} else if ($ipdb[1]==$ipuser[1]) {

					if ($ipdb[2]==$ipuser[2] AND $ipdb[3]=='0') {

						$allow=false;
						break;

					} else if ($ipdb[2]==$ipuser[2]) {

						if ($ipdb[3]==$ipuser[3] OR ($ipdb[3]=='0')) {

							$allow=false;
							break;

						}
					}
				}
			}
		}
	}

	return $allow;
}

function viewedtopic($tid) {

	mysql_query("INSERT INTO forum_views(id_topic,id_account,`time`) VALUES('".$tid."','".$_SESSION['userid']."','".date('Y-m-d H:i:s')."')
				ON DUPLICATE KEY UPDATE `time`='".date('Y-m-d H:i:s')."'", $GLOBALS['MySQL_CON']) or die (mysql_error());

}

function pvp_ranks($honor=0, $faction=0){
    $rank = '0'.$faction;
    if($honor > 0){
        if($honor < 2000) $rank = 1;
        else $rank = ceil($honor / 5000) + 1;
    }

	if ($rank>14) { $rank = 14; }
    return $rank;
}

function resetavatar($uid) {
	@mysql_query("UPDATE forum_accounts SET avatar='nochar' WHERE id_account='".$uid."'");
}

function onlinelocation($url, $sep='>', $incurl=false) {

	$url2=parse_url($url, PHP_URL_QUERY);
	$url2=explode('&',$url2);

	for ($i=0;$i<count($url2);$i++) {
		$loc[$i]=explode('=',$url2[$i]);
		if ($loc[$i][0]!='') {
			eval("$".$loc[$i][0]."='".$loc[$i][1]."';");
		}
	}

	switch($n) {
		case "news.archive":
			$url='News '.$sep.' Archived News';
		break;
		case "account.create":
			$url='Account '.$sep.' Create Account';
		break;
		case "account.manage":
			$url='Account '.$sep.' Manage Account';
			switch ($f) {
				case "character":
					$url.=' '.$sep.' Forum Avatar';
				break;
				case "account":
					$url.=' '.$sep.' Account Info';
				break;
				case "contact":
					$url.=' '.$sep.' Contact & Forum Info';
				break;
			}
		break;
		case "account.pm":
			$url='Account '.$sep.' Private Messages';
			switch ($f) {
				case "outbox":
					$url.=' '.$sep.' Outbox';
				break;
				case "send":
					$url.=' '.$sep.' Sending';
				break;
				case "inbox":
				default:
					$url.=' '.$sep.' Inbox';
				break;
			}
		break;
		case "account.login":
			$url='Account '.$sep.' Log In';
		break;
		case "account.activation":
			$url='Account '.$sep.' Activation';
		break;
		case "account.logout":
			$url='Account '.$sep.' Log Out';
		break;
		case "account.retrieve":
			$url='Account '.$sep.' Retrieve Account';
			switch ($t) {
				case "name":
					$url.=' Name';
				break;
				case "password":
					$url.=' Password';
				break;
			}
		break;
		case "account.realmstatus":
			$url='Account '.$sep.' Realm Status';
			if ($t!='') {
				$dbvar = mysql_fetch_array(mysql_query("SELECT name FROM realmlist WHERE id='".$t."'", $GLOBALS['MySQL_CON']));
				$url.=' '.$sep.' '.$dbvar['name'].' '.$sep.' Players On-Line';
			}
		break;
		case "gameguide.gettingstarted":
			$url='Game Guide '.$sep.' Getting Started';
		break;
		case "gameguide.faq":
			$url='Game Guide '.$sep.' F. A. Q.';
		break;
		case "gameguide.introduction":
		case "gameguide":
			$url='Game Guide '.$sep.' Introduction';
		break;
		case "workshop.pvprankings":
			$url='Workshop '.$sep.' PvP Rankings';
			if ($r!='') {
				$dbvar = mysql_fetch_array(mysql_query("SELECT name FROM realmlist WHERE id='".$r."'", $GLOBALS['MySQL_CON']));
				$url.=' '.$sep.' '.$dbvar['name'];
				if ($f=='alliance') {
					$url.=' '.$sep.' Alliance';
				} else if ($f=='horde') {
					$url.=' '.$sep.' Horde';
				}
			}
		break;
		case "workshop.eventscalendar":
			$url='Workshop '.$sep.' Events Calendar';
		break;
		case "workshop.worldmap":
			$url='Workshop '.$sep;
			if ($m=='outland') {
				$url.=' World Map of Outland';
			} else {
				$url.=' World Map of Azeroth';
			}
		break;
		case "media.screenshots":
			$url='Media '.$sep.' Screenshots';
		break;
		case "media.wallpapers":
			$url='Media '.$sep.' Wallpapers';
		break;
		case "media.otherdownloads":
			$url='Media '.$sep.' Other Downloads';
		break;
		case "language":
			$url='Language '.$sep.' Change To '.mb_convert_case($set, MB_CASE_TITLE);
		break;
		case "armory":
		case "armory.accounts":
		case "armory.guilds":
		case "armory.characters":
			$url='Armory';
		break;
		case "forums":
			$url='Forums';
			if ($f!='') {
				$dbvar = mysql_fetch_array(mysql_query("SELECT title FROM forums WHERE id_forum='".$f."'", $GLOBALS['MySQL_CON']));
				$url.=' - '.$dbvar['title'];
				if ($topic=='new') {
					$url.=' '.$sep.' Creating New Topic';
				}
			} else if ($t!='') {
				$dbvar = mysql_fetch_array(mysql_query("SELECT ft.title, f.title as ftitle FROM forum_topics ft INNER JOIN (forums f) ON f.id_forum=ft.id_forum WHERE ft.id_topic='".$t."'", $GLOBALS['MySQL_CON']));
				if ($topic=='edit') {
					$type = 'Editing Topic';
				} else if ($topic=='remove') {
					$type = 'Removing Topic';
				} else if ($topic=='move') {
					$type = 'Moving Topic';
				} else if ($post=='new') {
					$type = 'Replying to Topic';
				} else if ($post=='new') {
					$type = 'Editing Reply in Topic';
				} else if ($post=='remove') {
					$type = 'Removing Reply from Topic';
				} else {
					$type= 'Topic';
				}
				$url.=' - '.$dbvar['ftitle'].' '.$sep.' '.$type.' - '.$dbvar['title'];
			}
		break;
		case "community":
		case "community.spotlight":
			$url='Community '.$sep.' Spotlight';
		break;
		case "community.online":
			$url='Community '.$sep.' Users On-Line';
		break;
		case "community.contests":
			$url='Community '.$sep.' Contests';
		break;
		case "community.fanart":
			$url='Community '.$sep.' Fan Art';
		break;
		case "support":
			$url='Support';
		break;
		case "support.ingame":
			$url='Support '.$sep.' In-Game Support';
			if ($r!='') {
				$dbvar = mysql_fetch_array(mysql_query("SELECT name FROM realmlist WHERE id='".$r."'", $GLOBALS['MySQL_CON']));
				$url.=' '.$sep.' '.$dbvar['name'];
				if ($t=='') {
					$url.=' '.$sep.' Tickets';
				} else {
					$url.=' '.$sep.' Commands';
				}
			}
		break;
		case "support.donations":
			$url='Support '.$sep.' Donations';
		break;
		case "support.staff":
			$url='Support '.$sep.' Staff Personel';
		break;
		case "support.license":
			$url='Support '.$sep.' GNU License';
		break;
		case "support.jobs":
			$url='Support '.$sep.' Jobs';
		break;
		case "support.rules":
			$url='Support '.$sep.' Rules';
		break;
		case "admin":
			$url='Site Administration';
		break;
		case "admin.realms":
			$url='Site Administration '.$sep.' Realms';
		break;
		case "admin.text":
			$url='Site Administration '.$sep.' Text Dialogs';
		break;
		case "admin.database":
			$url='Site Administration '.$sep.' Database Settings';
		break;
		case "admin.web":
			$url='Site Administration '.$sep.' Website';
		break;
		case "admin.forums":
			$url='Site Administration '.$sep.' Forums';
		break;
		case "admin.accounts":
			$url='Site Administration '.$sep.' User Accounts';
		break;
		case "admin.donations":
			$url='Site Administration '.$sep.' Donations';
		break;
		case "admin.email":
			$url='Site Administration '.$sep.' E-mail';
		break;
		case "admin.misc":
			$url='Site Administration '.$sep.' Miscellaneous';
		break;
		case "":
		case "news":
			$url='Main Page';
		break;
		default:
			$url='Unknown '.$sep.' '.$url;
		break;
	}

	return $url;

}

function remove_array_item(&$arr, $index) {
    if(isset($arr[$index])){
        array_splice($arr, $index, 1);
    }
}

?>
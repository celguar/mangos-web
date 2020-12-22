<?
extract ($_REQUEST);
if (!file_exists("dbinfo.php")) {
   die("Cannot find backup info file, restore aborted");
}   

include "dbinfo.php"; 
$password = $dbpass;
?>
<html>
<head>
<title>MySQL PHP Helper :: Restore</title>
<style type="text/css">
body { font-family: "verdana", sans-serif }
.style1 {
	background-image: url('../../../shared/wow-com/images/parchment/plain/light3.jpg');
}
.style2 {
	background-image: url('../../../shared/wow-com/images/parchment/plain/light.jpg');
}
.style3 {
	color: #000080;
	font-weight: bold;
}
.style4 {
	color: #000080;
}
</style>
</head>

<body bgcolor="#f4f4f4" link="#000000" alink="#000000" vlink="#000000" style="background-image: url('../../../shared/wow-com/images/parchment/plain/light2.jpg')">

<center>
  <TABLE WIDTH="80%" border="0" cellspacing="0" bgcolor="#8BA5C5" class="style2">
    <TR> 
      <TD valign="top" class="style1"> <h4>MySQL PHP Backup :: Restore</h4>
      </TD>
    </TR>  

<?
if (isset($fselect)) {
    echo '
    <TR> 
      <TD valign="top">
        Below is your backup file. Click the Restore link to restore this backup. 
        Note that by restoring your database you will overwrite its current entries 
        with the backup file. </TD>
    </TR> ';
} ?>    

    <TR> 
      <TD valign="top" class="style2"> 
        <?
$x=  $_SERVER[SERVER_SOFTWARE];
if (strpos($x,"Win32")!=0) {
   $path = $path . "dump\\";
} else {
   $path = $path . "dump/";
}

// IF WINDOWS GIVES PROBLEMS
// FOR WINDOWS change to ==> $path = $path . "dump\\";
if ($fselect!="") {
      if (eregi("gz",$fselect)) { //zip file decompress first than show only
         $x=strpos($fselect,"_");
         $sqlname=substr($fselect,0,$x).".sql";
         echo $sqlname;
         @unlink($path.$sqlname);
         $fp2 = @fopen("dump/".$sqlname,"w");
         fwrite ($fp2,"");
	 fclose ($fp2);
         chmod($path.$sqlname, 0777);
         $fp = @fopen("dump/".$sqlname,"w");
         $zp = @gzopen("dump/".$fselect, "rb");
         if(!$fp) {
              die("Sql file cannot be created"); 
         }    
         if(!$zp) {
              die("Cannot read zip file");
         }    
         while(!gzeof($zp)){
	      $data=gzgets($zp, 8192);// buffer php
	      fwrite($fp,$data);
         }
         fclose($fp);
         gzclose($zp);
         $file=$sqlname;
         echo " <br><font color=red>File ".$sqlname." extracted from $file.</font> <br>";
         $file='';
      } // end of unzip
}

if ($file!=""){  
      $dbname=str_replace(".sql","",$file);    
      flush();
      $conn = mysql_connect($dbhost,$dbuser,$password) or die(mysql_error());
      	$filename = $file;
	set_time_limit(1000);
	$file=fread(fopen($path.$file, "r"), filesize($path.$file));
	$query=explode(";#%%\n",$file);
	for ($i=0;$i < count($query)-1;$i++) {
		mysql_db_query($dbname,$query[$i],$conn) or die(mysql_error());
	}
	echo "<table width=\"90%\"><tr><td align=\"center\"><b>Your restore 
request was processed.</b> If you did not receive any errors on the screen, then 
you should find that your database tables have been restored. If you attemped to restore your 
database using a backup file that was not created from this script, you likely encountered 
errors. This script can <b>only</b> restore backups made with this script.<br><br></td></tr></table>";

?>
      </TD>
    </TR>
<? } else { ?>
    <TR> 
      <TD valign="top"><table width="625" cellspacing="0">
          <tr> 
            <td width="125" align="center"><font size="2"><u><i>File</i></u></font></td>
            <td width="125" align="center"><font size="2"><u><i>Size</i></u></font></td>
            <td width="125" align="center"><font size="2"><u><i>Date</i></u></font></td>
            <td width="125"><font size="2">&nbsp;</font></td>
            <td width="125"><font size="2">&nbsp;</font></td>
          </tr>
          <?
	$dir=opendir($path); 
	$file = readdir($dir);
	while ($file = readdir ($dir)) { 
	    if ($file != "." && $file != ".." &&  (eregi("\.sql",$file) || eregi("\.gz",$file))){ 
	        if (eregi("\.sql",$file) ) {
	           echo "<tr><td nowrap bgcolor=\"#dddddd\" align=\"center\">$file</td>
	        	 <td nowrap bgcolor=\"#dddddd\" align=\"center\">".round(filesize($path.$file) / 1024, 2)." KB</td>
	        	 <td nowrap bgcolor=\"#dddddd\" align=\"center\">".date("d-m-Y",filemtime($path.$file))."</td>
	        	 <td nowrap align=\"center\"><a href=\"restore.php?file=$file\">Restore</a></td>
	        	 <td nowrap align=\"center\"><a href=\"dump/$file\">View</a></td></tr>"; 
	        }
	    } 
	}
	closedir($dir);
    ?>
        </table></TD>
    </TR>
    <? } ?>
    <TR> 
      <TD height="20" valign="top"><p><br>
          <a href="main.php"><font size="1"><span class="style3">Return to Main</span></font></a></p></TD>
    </TR>
    <TR>
      <TD height="15" valign="top" bgcolor="#FFFFFF" class="style2"><div align="right"><font color="#9999CC" face="Arial, Helvetica, sans-serif" style="font-size:6Pt">
        <span class="style4">MySql Php Multiple-Database Backup Version 1.0 &copy; 2003-<?=date("Y");?> by 
		</span> <a href="http://www.absoft-my.com" target="_blank">
		<span class="style4">AB 
          Webservices</span></a></div>
     </TD>
    </TR>
  </TABLE>
</center>
</body>
</html>

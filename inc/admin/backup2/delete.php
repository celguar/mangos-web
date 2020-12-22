<?
if (file_exists($path."dbinfo.php")) {
   $dir=opendir($path."dump/"); 
   $fl = readdir($dir);
   while ($fl = readdir ($dir)) { 
       if ($fl != "." && $fl != ".." &&  (eregi("\.sql",$fl) || eregi("\.gz",$fl))){ 
         unlink($path."dump/".$fl); // del all sql and gz
       }
   } 
   closedir($dir); 
   unlink($path."dbinfo.php"); 
}
 
?>
<html>
<head>
<title>MySQL PHP Helper :: Delete</title>
<style type="text/css">
body { font-family: "verdana", sans-serif }
</style>
</head>

<body bgcolor="#f4f4f4" link="#000000" alink="#000000" vlink="#000000">

<center>

  <TABLE WIDTH="80%" border="0" cellspacing="0" bgcolor="#8BA5C5">
    <TR> 
      <TD  valign="top"> <h4>MySQL PHP Backup :: Delete</h4>
        <b><font color="#990000">Your delete request was processed.</font></b><font size="2"> 
        <br>
        The following directory and files should now be deleted from your server:<br>
        <br>
        1. backup.sql file and any *.gz file (if created earlier)<br>
        2. dbinfo.php file is also deleted as it contains sensitive info.<br>
        <br>
        You should view your account to verify that this delete request was processed 
        accordingly. </font></TD>
    </TR>
    <TR> 
      <TD height="40" valign="top"><b><br>
        <a href="index.php"><font color="#FFFFFF" size="1">Return to Main</font></a> 
        </b></TD>
    </TR>
    <TR>
      <TD height="15" valign="top" bgcolor="#FFFFFF"><div align="right"><font color="#9999CC" face="Arial, Helvetica, sans-serif" style="font-size:6Pt">
        <div align="right">MySql Php Multiple-Database Backup Version 1.0 &copy; 2003-<?=date("Y");?> by <a href="http://www.absoft-my.com" target="_blank">AB 
          Webservices</a></font></div>
      </TD>
    </TR>
  </TABLE>

<br><br>
  <br>
  <br>
  <br>
  <br>
  <br>

</center>
</body>
</html>

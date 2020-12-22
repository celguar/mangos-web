<?
// version 1.0 may 2005 Unix version for multiple databases
// for win32 replace with backup_timeout.php
// multiple databases
include "dbinfo.php";
ini_set("max_execution_time","0");


function get_def($dbname, $table) {
    global $conn;
    $def = "";
    $def .= "DROP TABLE IF EXISTS $table;#%%\n";
    $def .= "CREATE TABLE $table (\n";
    $result = mysql_db_query($dbname, "SHOW FIELDS FROM $table",$conn) or die("Table $table not existing in database");
    while($row = mysql_fetch_array($result)) {
        $def .= "    $row[Field] $row[Type]";
        if ($row["Default"] != "") $def .= " DEFAULT '$row[Default]'";
        if ($row["Null"] != "YES") $def .= " NOT NULL";
       	if ($row[Extra] != "") $def .= " $row[Extra]";
        	$def .= ",\n";
     }
     $def = ereg_replace(",\n$","", $def);
     $result = mysql_db_query($dbname, "SHOW KEYS FROM $table",$conn);
     while($row = mysql_fetch_array($result)) {
          $kname=$row[Key_name];
          if(($kname != "PRIMARY") && ($row[Non_unique] == 0)) $kname="UNIQUE|$kname";
          if(!isset($index[$kname])) $index[$kname] = array();
          $index[$kname][] = $row[Column_name];
     }
     while(list($x, $columns) = @each($index)) {
          $def .= ",\n";
          if($x == "PRIMARY") $def .= "   PRIMARY KEY (" . implode($columns, ", ") . ")";
          else if (substr($x,0,6) == "UNIQUE") $def .= "   UNIQUE ".substr($x,7)." (" . implode($columns, ", ") . ")";
          else $def .= "   KEY $x (" . implode($columns, ", ") . ")";
     }

     $def .= "\n);#%%";
     return (stripslashes($def));
}

function get_content($dbname, $table) {
     global $conn;
     $content="";
     mysql_query("LOCK TABLES ".$table." WRITE");
     $result = mysql_db_query($dbname, "SELECT * FROM $table",$conn);
     while($row = mysql_fetch_row($result)) {
         $insert = "INSERT INTO $table VALUES (";
         for($j=0; $j<mysql_num_fields($result);$j++) {
            if(!isset($row[$j])) $insert .= "NULL,";
            else if($row[$j] != "") $insert .= "'".addslashes($row[$j])."',";
            else $insert .= "'',";
         }
         $insert = ereg_replace(",$","",$insert);
         $insert .= ");#%%\n";
         $content .= $insert;
     }
     mysql_query("UNLOCK TABLES");
     return $content;
}

// run all databases


extract($_POST);
?>
<html>
<head>
<title>MySQL PHP Backup :: Backup</title>
<style type="text/css">
body { font-family: "verdana", sans-serif }
</style>
</head>

<?

flush();
$conn = @mysql_connect($dbhost,$dbuser,$dbpass);
if ($conn==false)  die("password / user wrong");     

$cc=0;

while ($cc<=$num_dbs) {
   $check='check'.$cc;
   if ($$check=='on') {
      $dbname     ='database'.$cc;
      $backup_name=$$dbname.'.sql';
      $backup_gz  =$$dbname.'.gz';
      mysql_select_db($$dbname,$conn);

      $x=$_SERVER[SERVER_SOFTWARE];
      if (strpos($x,"Win32")!=0) {
         $path = $path . "dump\\";
      } else {
         $path = $path . "dump/";
      }

      // If windows gives problems
      // FOR WINDOWS change to ==> $path = $path . "dump\\";
   
      if (!is_dir($path)) mkdir($path, 0766);
      chmod($path, 0777);
	$fp2 = fopen ($path."$backup_name","w");
        $copyr="# Table backup from MySql PHP Backup\n".
               "# AB Webservices 1999-2004\n".
               "# www.absoft-my.com/pondok\n".
               "# Creation date: ".date("d-M-Y h:s",time())."\n".
               "# Database: ".$$database."\n\n" ;

	fwrite ($fp2,$copyr);
	fclose ($fp2);
        chmod($path.$backup_name, 0777);

      if(file_exists($path . $backup_gz)) { 
         unlink($path.$backup_gz);
      } 
      $recreate = 0;

      if (!eregi("/restore\.",$PHP_SELF)) {
	 $cur_time=date("Y-m-d H:i");
	 $i = 0;  
         $tres = mysql_list_tables($$dbname,$conn);
         while ($tables=mysql_fetch_row($tres)) {
               
              if ($tables[0] != "") {
	         $newfile .= get_def($$dbname,$tables[0]);
	         $newfile .= "\n\n";
	         if ($structonly!="Yes") {
	            $newfile .= get_content($$dbname,$tables[0]);
	            $newfile .= "\n\n";
                 }	      
	      }
	      $i++;
	 }	
	 $fp = fopen ($path.$backup_name,"a");
	 fwrite ($fp,$newfile);
	 fwrite ($fp,"# Valid end of backup from MySql PHP Backup\n");
	 fclose ($fp);
      }
    }
    $cc++;

} // end if $dbase exists
?>
<body bgcolor="#f4f4f4" link="#000000" alink="#000000" vlink="#000000">


<CENTER>
  <BR>
  <TABLE WIDTH="80%" border="0" cellspacing="0" bgcolor="#8BA5C5">
    <TR> 
      <TD height="215" valign="top"> <h4>MySQL PHP Backup :: Backup</h4>
        <b><font color="#990000">Your backup request was processed.</font></b> 
        <br> <font size="2"> If you did not receive any errors on the screen, 
        then you should find a directory called "dump" (without the quotes) in 
        the sub-directory of MySQL PHP Backup. <br>
        In the "dump" directory, you should find files titled "database_name.sql" (without 
        the quotes). <br>
        The following tables have been backed up:<br>
        <? 
        $xx=0;
        while ($xx<=$num_dbs) {
           $check='check'.$xx;
           if ($$check=='on') {
             $dbname  ='database'.$xx;                    
             echo "<b>&nbsp;&nbsp;&nbsp;- ".$$dbname ."</b><br>";
           }
           $xx++;
        }  
        ?>   
        <br>These files are an unzipped backup of your database and must have the <em>same 
        name</em> if you wish to do a restore using MySQL PHP Backup. </font> 
      </TD>
    </TR>
    
    <TR> 
      <TD height="27" valign="top"><B><A HREF="main.php"><font color="#FFFFFF" size="1"><br>
        Return to Main</font></A></B></TD>
    </TR>
    <TR>
      <TD height="15" valign="top" bgcolor="#FFFFFF">
      <div align="right"><font color="#9999CC" face="Arial, Helvetica, sans-serif" style="font-size:6Pt">
        MySql Php Multiple-Database Backup Version 1.0 &copy; 2003-<?=date("Y");?> by <a href="http://www.absoft-my.com" target="_blank">AB 
          Webservices</a></font></div>
      </td>
    </TR>
  </TABLE>

<BR><BR>
  <BR>
  <BR>
</CENTER>
</body>
</html>
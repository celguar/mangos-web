<HTML>
<HEAD>
<TITLE>MySQL PHP Helper :: Main</TITLE>
<STYLE type="text/css">
BODY {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10pt;
}

.textbox {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 8pt;
	background-color: #BDD7F7;
	border: 1px solid #000000;
	color: #000000;
}
.style1 {
	background-color: #990000;
	background-image: url('../../../shared/wow-com/images/parchment/plain/light3.jpg');
}
.style2 {
	background-image: url('../../../shared/wow-com/images/parchment/plain/light2.jpg');
}
.style3 {
	background-image: url('../../../shared/wow-com/images/parchment/plain/light3.jpg');
}
.style4 {
	background-image: url('../../../shared/wow-com/images/parchment/plain/light.jpg');
}
.style5 {
	font-weight: bold;
	background-image: url('../../../shared/wow-com/images/parchment/plain/light3.jpg');
}
.style9 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 8pt;
	background-color: #000000;
	border: 1px solid #000000;
	color: #FFCC00;
}
.style10 {
	color: #000000;
	background-color: #000000;
}
.style11 {
	background-color: #FFFFFF;
}
.style13 {
	color: #FFCC00;
}
.style14 {
	color: #000000;
}
.style15 {
	font-size: smaller;
}
.style16 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 8pt;
	background-color: #FFCC00;
	border: 1px solid #000000;
	color: #000000;
}
</STYLE>
</HEAD>
<?


$base_url    = "http://".$_SERVER['SERVER_NAME'];
$directory   = $_SERVER['PHP_SELF'];
$script_base = "$base_url$directory";
$base_path   = $_SERVER['PATH_TRANSLATED'];
$root_path_www = $_SERVER['DOCUMENT_ROOT'];
$remove_end  = strrchr($root_path_www,"/");
$root_path   = ereg_replace("$remove_end", '', $root_path_www);
$url_base    = "$base_url$directory";
$url_base    = ereg_replace("main.php", '', "$_SERVER[PATH_TRANSLATED]");
//$path        = ereg_replace("main.php",'',$url_base);
extract($_POST);
if ($send2 == "  Find  ") {
  $conn = @mysql_connect($dbhost,$dbuser,$dbpass); 
  if ($conn==FALSE) {
      die("<BR>ERROR: cannot connect to MySql<BR>" );
  }

  $dbs = mysql_list_dbs($conn);
  $num_dbs = @mysql_num_rows($dbs);
  if ($num_dbs==0) {
     die("ERROR: No databases found");
  }   

  $fp3 = fopen ($path."dbinfo.php","wb");
  fwrite ($fp3,"<?\n");
  fwrite ($fp3,"\$dbhost=\"$dbhost\";\n");
  fwrite ($fp3,"\$dbuser=\"$dbuser\";\n");
  fwrite ($fp3,"\$dbpass=\"$dbpass\";\n");
  fwrite ($fp3,"\$path=\"$path\";\n");
  $i = 0;
  while($i < $num_dbs) { 
      $db = mysql_dbname($dbs, $i);

      fwrite ($fp3,"\$dbase$i=\"$db\";\n");
      $i++;
  }
  $i--;
  fwrite ($fp3,"\$num_dbs=\"$i\";\n");	
  fwrite ($fp3,"?>\n");
  fclose ($fp3);
  @chmod($path."dbinfo.php", 0644);
  include ("dbinfo.php");
} else {
  if (!file_exists("dbinfo.php")) {
    echo "<meta http-equiv=Refresh  content='0;URL=index.php'>";
    die("Start from index.php");
  } 
  include "dbinfo.php";
  $conn = @mysql_connect($dbhost,$dbuser,$dbpass); 
  if ($conn==FALSE) {
      die("<BR>ERROR: cannot connect to MySql<BR>" );
  }
}   
?>
<BODY BGCOLOR="#F4F4F4" style="background-image: url('../../../shared/wow-com/images/parchment/plain/light.jpg')">
<CENTER>
  <TABLE bgcolor="#8BA5C5" style="width: 69%" class="style2">
    <TR>
      <TD class="style1"><h3 class="style15">MySQL PHP Multiple-Database Backup :: Help</h3></TD>
    </TR>
    <TR> 
      <TD valign="top"> 
        <ul>        
		<li><font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">After 
            downloading the backup, delete it from the server.</font></li>
          <li><font color="#990000" size="1" face="Verdana, Arial, Helvetica, sans-serif">Php 
            might time out if max_execution_time is to short on very large tables 
            (several Mb).</font></li>
            
          <li><?
          if (get_extension_funcs('zlib'))  {
             echo "<font color='green'>Zlib has been found on the server." ;
          } else {
             echo "<font color='red'>Zlib is NOT installed on the server !";
          } ?>
          </font></li>      
        </ul>
        <font color="#66FFFF" face="Arial, Helvetica, sans-serif" style="font-size:6Pt">
        <span class="style14">MySql Php Multiple-Database Backup Version 1.0 &copy; 2003-</span><span class="style11"><span class="style10"><?=date("Y");?></span></span><span class="style13"><span class="style14"> by 
		</span></span> <a href="http://www.absoft-my.com" target="_blank">AB 
          Webservices</a></font>
        </TD>
    </TR>
  </TABLE><br>



 
<FORM NAME="dobackup" METHOD="post" ACTION="backup.php"> 
    <table border="0" cellspacing=0 cellpadding=0 bgcolor="#8BA5C5" align="center" style="width: 69%" class="style2">
      <tr align=center> 
        <td width="46%" > <TABLE WIDTH="500" BORDER="0" CELLPADDING="5" CELLSPACING="1" bgcolor="#8BA5C5">
            <TR> 
              <TD colspan="2" NOWRAP class="style3"><div align="center"><strong>CREATE A BACKUP</strong></div></TD>
            </TR>
            <TR> 
              <TD NOWRAP style="width: 182px" class="style4"> <FONT SIZE="2" FACE="verdana,sans-serif">Your 
                database host:</FONT></TD>
              <TD NOWRAP WIDTH="300" class="style4"> 
				<INPUT NAME="dbhost" TYPE="text" class="style9" VALUE="<?=$dbhost; ?>" SIZE="37" MAXLENGTH="100"> 
              </TD>
            </TR>
            <TR> 
              <TD NOWRAP style="width: 182px" class="style4"> <FONT SIZE="2" FACE="verdana,sans-serif">Database 
                user name:</FONT></TD>
              <TD NOWRAP WIDTH="300" class="style4"> 
				<INPUT NAME="dbuser" TYPE="text" class="style9" VALUE="<?=$dbuser; ?>" SIZE="37" MAXLENGTH="100"> 
              </TD>
            </TR>
            <TR> 
              <TD NOWRAP style="width: 182px" class="style4"> <FONT SIZE="2" FACE="verdana,sans-serif">Database 
                password:</FONT></TD>
              <TD NOWRAP WIDTH="300" class="style4"> 
				<INPUT NAME="dbpass" TYPE="password" class="style9" VALUE="<?=$dbpass; ?>" SIZE="37" MAXLENGTH="100"> 
              </TD>
            </TR>
            <TR> 
              <TD NOWRAP style="width: 182px" class="style4"> <FONT SIZE="2" FACE="verdana,sans-serif">Select 
                databases :</FONT></TD>
              <TD NOWRAP WIDTH="300" class="style4"><FONT SIZE="2" FACE="verdana,sans-serif"> 
              <? 
              $c=0; 
              $res=mysql_list_dbs($conn);
              $i=mysql_num_rows($res);
              while($c<$i)  {
                 $database=mysql_db_name($res, $c);
                 echo '<input type="checkbox" name="check'.$c.'">';
                 echo '<b> '.$database.'</b> contains '.mysql_num_rows(mysql_list_tables($database,$conn)).
                      ' tables.<br>'; 
                 echo '<input type="hidden" name="database'.$c.'" value="'.$database.'">';
                 $c++;
              }
              
              ?>
              </TD>
            </TR>
            <TR> 
              <TD NOWRAP style="width: 182px" class="style4"> <FONT SIZE="2" FACE="verdana,sans-serif">Full 
                path to this script:</FONT><br> <br></TD>
              <TD NOWRAP WIDTH="300" class="style4"> 
				<INPUT NAME="path" TYPE="text" class="style9" VALUE="<?=$url_base;?>" SIZE="37" MAXLENGTH="100"> 
                <br> <br> </TD>
            </TR>
          </table></td>
      </tr>
      <?   

?>
      <tr> 
        <td>
          <FONT SIZE='1' FACE='verdana,sans-serif'> 
          <input type='submit' name='send2' align="absmiddle" value ='Backup'></font><br> <input type='checkbox' name='structonly' value='Yes'>
          <FONT SIZE='1' FACE='verdana,sans-serif'> Backup Structures only </font><br> 
<?
$i=$num_dbs+1;
echo " 
<input type='radio' name='chg' onclick='for(i=0;i<$i;i++){document.getElementById(\"check\"+i).checked=true;}'><FONT SIZE='1' FACE='verdana,sans-serif'> Check All  &nbsp;&nbsp;</font>
<input type='radio' name='chg' onclick='for(i=0;i<$i;i++){document.getElementById(\"check\"+i).checked=false;}'><FONT SIZE='1' FACE='verdana,sans-serif'> Uncheck All &nbsp;&nbsp;</font>
<font color='#990000' size='1'><strong>Backup File Names: backup_name.sql</strong></font>
<p align=right></td><td align='center' ><br>";
?>&nbsp; </td>
      </tr>
    </table>
</form>


<FORM NAME="dorestore" METHOD="post" ACTION="restore.php">
    <TABLE WIDTH="500" HEIGHT="93" BORDER="0" CELLPADDING="5" CELLSPACING="1" bgcolor="#8BA5C5">
     <tr><td height="54" class="style3"><div align="center"> <B>RESTORE A BACKUP</B><br>
            <font color="#FFFFFF" size="1">Backup must be on server</font></div></td></tr> 
     <tr>
        <td class="style2"><CENTER>
            <font color="#FFFFFF" size="1" face="Verdana, Arial, Helvetica, sans-serif">Database Password:</font> 
            <input name="password" type="password" id="password" size="15" maxlength="15" class="style9" value=<?=$dbpass; ?>>
            <br><br>
            <select name="fselect" style='font-size:8px'>
        <? 
            $x=$_SERVER[SERVER_SOFTWARE];
             if (strpos($x,"Win32")!=0) {
               $path = $path . "dump\\";
             } else {
               $path = $path . "dump/";
             }
             if ($hdl=opendir($path)){
                while (false !== ($file = readdir($hdl))) { 
                   if ($file != "." && $file != "..") { 
                     echo '<option value="'.$file.'">'.$file.'</option>\n';
                   } 
                }
                closedir($hdl);          
             }
         ?>  
            </select>
            
            <INPUT NAME="send" TYPE="submit" VALUE="Restore"></CENTER>
		</td>
	  </tr>	
    </table>
</FORM>

<FORM NAME="dodelete" METHOD="post" ACTION="delete.php">
<CENTER>
      <TABLE WIDTH="500" HEIGHT="75" BORDER="0" CELLPADDING="5" CELLSPACING="1" bgcolor="#8BA5C5">
        <tr>
          <td class="style5"><div align="center">DELETE A BACKUP</div></td>
        </tr>
        <tr> 
          <td class="style2"><CENTER>
           <select name="fselect" style='font-size:8px'>
          <? 
          if ($hdl=opendir($path)){
             while (false !== ($file = readdir($hdl))) { 
                 if ($file != "." && $file != "..") { 
                    echo '<option value="'.$file.'">'.$file.'</option>\n';
                 } 
             }
             closedir($hdl);          
          }
          ?>  
            </select>
            <INPUT NAME="send4" TYPE="submit" VALUE="Delete">
            </CENTER></td>
        </tr>
      </table>
      
    </CENTER>
  </FORM>
<FORM NAME="dodownload" METHOD="post" ACTION="download.php">
<CENTER>
      <TABLE WIDTH="500" HEIGHT="75" BORDER="0" CELLPADDING="5" CELLSPACING="1" bgcolor="#8BA5C5" class="style2">
        <tr> 
          <td class="style5"><div align="center">DOWNLOAD BACKUP</div></td>
        </tr>
        <tr> 
          <td valign="top"> <div align="right"> 
              <div align="center"></div>
              <table width="365" align="center">
                <tr> 
                  <td align="center" class="style4"><font size="1"> 
                      <input name="zipit" type="radio" class="textbox" value="1" onClick="if (this.value=1) { document.dodownload.zipname.disabled=true;}">
                      Download as Sql
                      </font></td>
                </tr>
                <tr> 
                  <td align="center" class="style4"><font size="1"> &nbsp; 
                    <input name="zipit" type="radio" class="textbox" value="2" checked onclick="if (this.value=1){ document.dodownload.zipname.disabled=false;}">
                    Download as Gzip </font></td>
                </tr>
                <tr>
                  <td align="center" class="style4"><font size="1" face="Arial, Helvetica, sans-serif"> 
                     Select file: 
                     <select name="fselect" style='font-size:8px'>
          <? 
          if ($hdl=opendir($path)){
             while (false !== ($file = readdir($hdl))) { 
                 if ($file != "." && $file != "..") { 
                    echo '<option value="'.$file.'">'.$file.'</option>\n';
                 } 
             }
             closedir($hdl);          
          }
          ?>  
                     </select><br><br>
                       File name for zip: 
                       <b> sql_file_ <?=date("Y-M-d");?></b>
                       </font></td>
                </tr>
              </table>
            </div></td>
        </tr>
        <tr> 
          <td><CENTER>
              <br>
&nbsp;</CENTER></td>
        </tr>
      </table>
      
    </CENTER>
  </FORM>


</CENTER>
</BODY>
</HTML>


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
</STYLE>
</HEAD>
<?
$script 	= "index.php";
$directory 	= $_SERVER['PHP_SELF'];
$script_base = "$base_url$directory";
$base_path = $_SERVER['PATH_TRANSLATED'];
$url_base = ereg_replace("$script", '', "$_SERVER[PATH_TRANSLATED]");
?>
<BODY BGCOLOR="#F4F4F4" style="background-image: url('../../../shared/wow-com/images/parchment/plain/light.jpg')">
<CENTER>
  
          
<FORM NAME="dobackup" METHOD="post" ACTION="main.php" style="width: 584px; height: 152px">
    
  <TABLE  BORDER="0" align="left" CELLPADDING="3" CELLSPACING="1" bgcolor="#8BA5C5" style="width: 456px">
    <TR> 
      <TD colspan="2" NOWRAP><div align="center"><strong>FIND ALL DATABASES</strong></div></TD>
    </TR>
    <TR> 
      <TD NOWRAP WIDTH="200"> <FONT SIZE="2" FACE="verdana,sans-serif">Your database 
        host:</FONT></TD>
      <TD NOWRAP WIDTH="270"> <INPUT NAME="dbhost" TYPE="text" class="textbox" VALUE="localhost" SIZE="37" MAXLENGTH="100"> 
      </TD>
    </TR>
    <TR> 
      <TD NOWRAP WIDTH="200"> <FONT SIZE="2" FACE="verdana,sans-serif">Database 
        user name:</FONT></TD>
      <TD NOWRAP WIDTH="270"> <INPUT NAME="dbuser" TYPE="text" class="textbox" VALUE="username" SIZE="37" MAXLENGTH="100"> 
      </TD>
    </TR>
    <TR> 
      <TD NOWRAP WIDTH="200"> <FONT SIZE="2" FACE="verdana,sans-serif">Database 
        password:</FONT></TD>
      <TD NOWRAP WIDTH="270"> <INPUT NAME="dbpass" TYPE="password" class="textbox" VALUE="" SIZE="37" MAXLENGTH="100"> 
      </TD>
    </TR>
    <TR> 
      <TD NOWRAP WIDTH="200"> <FONT SIZE="2" FACE="verdana,sans-serif">Full path 
        to this script:</FONT></TD>
      <TD NOWRAP WIDTH="270"> <INPUT NAME="path" TYPE="text" class="textbox" VALUE="<? echo $url_base; ?>" SIZE="37" MAXLENGTH="100"> 
      </TD>
    </TR>
    <TR> 
      <TD NOWRAP></TD>
      <TD NOWRAP><INPUT NAME="send2" TYPE="submit" class="textbox" VALUE="  Find  "></TD>
    </TR>
    <TR bgcolor="#BDD7F7"> 
      <TD valign="top" colspan=2><font color="#9999CC" face="Arial, Helvetica, sans-serif" style="font-size:6Pt">
        <div align="right">MySql Php Multiple-Database Backup Version 1.0 &copy; 2003-<?=date("Y");?> by <a href="http://www.absoft-my.com" target="_blank">AB 
          Webservices</a></div>
        </font> </TD>
    </TR>
  </TABLE>
</FORM>
          

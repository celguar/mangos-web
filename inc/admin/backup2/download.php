<?PHP
extract($_POST);
include ("dbinfo.php");

function compress($zip,$zipname) {
   // compress a file without using shell
   $zip=rtrim($zip); 
   $fp = @fopen("dump/".$zip,"rb");
   if (!$fp) {
      die("No sql file found"); 
   }    
   if (file_exists("dump/*.gz")) unlink("dump/*.gz");
   $zipname=str_replace(".sql","",$zipname);
   $zp = @gzopen("dump/".$zipname, "wb9");
   if(!$zp) {
      die("Cannot create zip file");
   }    

   while(!feof($fp)){
	$data=fgets($fp, 8192);	// buffer php
	gzwrite($zp,$data);
   }
   fclose($fp);
   gzclose($zp);
   return true;
}
// end function

if ($zipit==1) {
   $farr[0]=$fselect;
} elseif ($zipit==2 && compress($fselect,$fselect."_".date('Y-m-d').".gz")==true ) {
   $farr[0]=str_replace(".sql","",$fselect)."_".date('Y-m-d').".gz";
} else {
   die("File error");
}
  header('Cache-control: private');
  header('Content-Description: File Transfer');
  header('Content-Type: application/force-download');
// header("location:".$path."dump/".$farr[0]);
  header("location:".dirname($_SERVER[PHP_SELF])."/dump/".$farr[0]);;   

?>         

	
	


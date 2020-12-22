<?php
header("Content-type: image/png");
$im    = imagecreatefromjpeg("./../../new-hp/images/rndimages/rndimg".rand(0,4).".jpg");
$orange = imagecolorallocate($im, 220, 210, 60);
imagettftext($im, 20, 0, 25, 47, $orange, "./arial.ttf" , preg_replace('//','  ',$_REQUEST['i']));
imagepng($im);
imagedestroy($im);
?>
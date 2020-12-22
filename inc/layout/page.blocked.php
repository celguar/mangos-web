<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title('IP Banned');

parchdown();

parchup(true);

if (validateip()==false) { errborder('Your IP is banned from our websites ('.$_SERVER['REMOTE_ADDR'].').'); }
else { goodborder('Your IP is NOT banned from our websites ('.$_SERVER['REMOTE_ADDR'].').'); }

parchdown();

?>
<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

parchup(); 

title ('Donations');

subnav ('Donations');

parchdown(); 

parchup(true); 

if ($SETTING['DONATIONS_ENABLED']=='0') {
	errborder('Donations are DISABLED.');
} else {
	errborder($_LANG['ERROR']['CONST']);
}

parchdown();

?>
<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

$_REQUEST['n'] = explode('.', $_REQUEST['n']);

switch ($_REQUEST['n'][1]) {
	case "gettingstarted":
		$tit = "Getting Started";
		$pat = "gettingstarted";
		$bookpos['l']=21;
		$bookpos['t']=-110;
		$detail = 'Everything you need to know to get started on your heroic journey in the World of Warcraft.';
	break;
	case "faq":
		$tit = "F. A. Q.";
		$pat = "faq";
		$bookpos['l']=40;
		$bookpos['t']=-107;
		$detail = "Got a question but don't know where to look? Try one of our Frequently Asked Questions lists!";
	break;
	case "introduction":
	default:
		$tit = "Introduction";
		$pat = "introduction";
		$bookpos['l']=39;
		$bookpos['t']=-146;
		$detail = 'World of Warcraft is an online role-playing experience set in the award-winning Warcraft universe.';
	break;
}

parchup();

title($tit);

subnav('Game Guide');

parchdown();

parchup(true);

?>
<table cellspacing="0" cellpadding="0" border="0">
	<tr>
	<td width="157" height="151" background="new-hp/images/dialogs/book.jpg" rowspan="4"><div style="position:relative;"><div style="position:absolute; left: <?php echo $bookpos['l'];?>; top: <?php echo $bookpos['t'];?>;"><img src="new-hp/images/dialogs/<?php echo str_replace('text_','',$pat); ?>_book.gif"></div></div></td>
	
	<td width="474" height="59" background="new-hp/images/dialogs/top.jpg" colspan="2"><img src = "/shared/wow-com/images/layout/pixel.gif" width="1" height = "59"></td>
	</tr>
	<tr>
	<td width="474" height="44" background="new-hp/images/dialogs/title_bg.jpg" colspan="2"><img src="new-hp/images/<?php echo $_LANG['LANG']['SHORT_TAG']; ?>/dialogs/<?php echo $pat; ?>_title.jpg" height="44" align="left"></td>
	</tr>
	
	<tr>

	<td width="432" height="39" background="new-hp/images/dialogs/description.jpg"><small style="color:#FFFFFF"><?php echo $detail; ?></small></td>
	<td width="42" height="39" background="new-hp/images/dialogs/description_right.jpg"><img src = "/shared/wow-com/images/layout/pixel.gif" width="1" height = "39"></td>
	</tr>
	
	<tr>
	<td width="474" height="9" background="new-hp/images/dialogs/description_bottom.jpg" colspan="2"><img src = "/shared/wow-com/images/layout/pixel.gif" width="1" height = "9"></td>
	</tr>
</table>

<table cellspacing="0" cellpadding="0" border="0">
<tr>

<td>
	<table width="631" cellpadding="0" cellspacing="0" border="0"><tr>
	<td width="81" background="new-hp/images/dialogs/parchment_left.jpg" valign="top"><img src="new-hp/images/dialogs/bookmark.jpg" width="81" height="42"></td>
	
	<td>
		<table width="508" cellpadding="0" cellspacing="0" border="0" style="background: url('new-hp/images/dialogs/bg.jpg');">
		<tr><td width="508" height="30" background="new-hp/images/dialogs/decline.jpg" width="508" height="30"></tr>
		<tr><td width="508">
			<table cellpadding="0" cellspacing="0" border="0" style="background: url('new-hp/images/dialogs/parchment.jpg'); background-position: bottom right; background-repeat:no-repeat;" width="100%"><tr><td>
			<span style="display:block; margin:0 15 10 15;">

		

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr valign="top">
<td>
<span>
<?php

$fh = @fopen("inc/languages/".$_COOKIE['SITE_LANG']."/text.".$pat.".txt" , "r");
echo bbcode(@fread($fh, filesize("inc/languages/".$_COOKIE['SITE_LANG']."/text.".$pat.".txt")));
@fclose($fh);
	
?>
</span>

</td></tr></table>
			</td></tr></table>
		
		
		
		</span></td>
		</tr>
		</table>
	</td>
	
	<td width="42" style="background: url('new-hp/images/dialogs/parchment_right.jpg'); background-position: top; background-repeat:repeat-y;" valign="top"><img src="new-hp/images/dialogs/bookmark_right.jpg" width="42" height="29"></td>

	</tr>
	
	</table>
</td>
</tr>


<tr>
<td colspan="3" width="631" height="16" background="new-hp/images/dialogs/parchment_bottom.jpg" valign="top"><a name="gettingstarted"><img src = "/shared/wow-com/images/layout/pixel.gif" width="1" height = "16"></a></td>
</tr>

</table>

<table cellspacing="0" cellpadding="0" border="0">
<tr><td width="631" background="new-hp/images/dialogs/alsosee_bg.jpg">
	<table width="631" cellspacing="0" cellpadding="0" border="0" style="background: url('new-hp/images/dialogs/bottom.jpg'); background-position: bottom; background-repeat:no-repeat;">

	<tr><td><br><br></td></tr>
	</table>
</td></tr>
</table>

<?php
parchdown();

?>

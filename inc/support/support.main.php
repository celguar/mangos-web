<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

if ($_REQUEST['n']=='support') {

	parchup();

	title('Support');

	subnav('Support');

	parchdown();

	tabtitle('<a href="?n=support.staff">Staff Personal</a>');
?>
<div class="postBody" align=left>
<img src="new-hp/images/smallcaps/plain/s.gif" align="left">taff Personel, also called "GMs" are Kashimashi-WoW employees who provide in-game assistance. They can help you with a multitude of issues. However, while it may be tempting to ask them about in-game content or ask them to assist you with a quest, please remember that the Game Masters are not players; they are Employees.
<br><br>
<b>How will the Game Masters contact me?</b><br>
The Game Masters will contact you either in-game, by whispering you, by in-game mail (it will be on a distinctive, Blizzard stationary) or by email. If you log on and notice that your ticket is gone, please check your email to see if the GMs have sent the response to your issue there. Please note that if you are using Hotmail, MSN.com, Yahoo!, or Gmail, you may need to check the Junk folder if you don't see the mail in your Inbox.
<br><br>
<b>Where can I send feedback or suggestions?</b><br>
Please do not send feedback or suggestions to the Game Masters. Instead, post these in our Suggestions Forum.
<br><br>
<b>My problem fixed itself. Do I still need to keep my petition active?</b><br>
That, actually, is entirely up to you. However, if your problem fixes itself or if you found the solution to it before a GM could contact you, just abandon your ticket.
<br><br>
<b>When I edited my petition, the text was gone!</b><br>
Editing a ticket can, depending on the amount of text originally submitted, destroy the ticket text. If this happens, you will need to rewrite the ticket entirely. Otherwise, it will appear blank to the GMs and they will not be able to assist you.
<br><br>
<b>I have concerns about a particular Game Master. Who can I talk to about it?</b><br>
If you have problems with a Game Master, please email admin.kashimashi@gmail.com.com.
<br><br>
<b>How do I know if someone is really a Game Master?</b><br>
GMs will always identify themselves when contacting a player about an issue. They can be identified by the blizz logo before their names in chat.
Example:<img src="new-hp/images/forum/icons/blizz.gif">Junco whispers: Hello.
<br></br>
<b>What is it like to be a Game Master?</b><br>
If you'd like to see the kinds of things that Game Masters handle, read this page.
<br><br>
<b>How can I become a Game Master?</b><br>
If you are interested in joining our GM team, please check our Job Opportunity page for more information about the position.
<br><br>
<b>The Crash-reporting program doesn't work!</b><br>
If you crash in Windows XP the operating system offers to send crash logs of the incident to the manufacturer. This is not a feature of WoW, it is a feature of Microsoft XP, and it is not supported by Blizzard.
<br><br>
<b>What are the known issues at this time?</b><br>
Right now, there are several known issues. You can read about them and about the solutions to them in our In-Game Customer Support forum.
</div>
<?	
	parchdown();

	tabtitle('<a href="?n=support.staff">In-Game Support</a>');
	
?>
<div class="postBody" align=left>
<img src="new-hp/images/smallcaps/plain/i.gif" align="left">n-game support is provide by our Game Masters. 
Take a look at our Game Master and Ticketing pages to determine if your problem is an in-game issue and, if so, what to do about it.
<br>
There are also several commands for every user levels that help you in game.
</div>
<?
	
	parchdown();

	tabtitle('Rules');
?>
<div class="postBody" align=left>
<img src="new-hp/images/smallcaps/plain/t.gif" align="left">o be completed.
</div>
<?
	parchdown();

	tabtitle('Forums');
	
?>
<div class="postBody" align=left>
<img src="new-hp/images/smallcaps/plain/t.gif" align="left">o be completed.
</div>
<?
	
} else {

switch ($_REQUEST['n']) {
	case "support.jobs":
		$tit = "Jobs";
		$pat = "jobs";
		$bookpos['l']=-9;
		$bookpos['t']=-99;
		$detail = '';
	break;
	default:
	case "support.rules":
		$tit = "Rules";
		$pat = "rules";
		$bookpos['l']=-4;
		$bookpos['t']=-98;
		$detail = "These are to be followed or be doomed!";
	break;
}

	parchup();

	title($tit);

	subnav('Support');

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

}

parchdown();

?>

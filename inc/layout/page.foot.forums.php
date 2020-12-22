<?
if (INCLUDED!==true) { include('index.htm'); exit; }
?>
<map id="bottommap" name="bottom_blizzlogo_Map">
	<area shape="rect" href="http://www.blizzard.com/" alt="Blizzard Entertainment" coords="161,6,239,42" />
</map>
<div id="ftrText">

	<div class="width">
		<font color=white>All times are GMT <?php echo $GMT[$SETTING['WEB_GMT']][0]; ?>. The time now is <?php echo date('h:i A'); ?>.</font>
		<br><br><br>
		 <?php include ('page.copyright.php'); ?>
	</div>
</div>
<div id="footerShell">
	<div class="logo"><img src="new-hp/images/forum/bottom-blizzlogo.gif" width="400" height="46" border="0" usemap="#bottom_blizzlogo_Map" alt="Blizzard Entertainment" />
	</div>
</div>
</body>
<script>window.status='Welcome to <?php echo $SETTING['WEB_SITE_NAME']; ?>!';</script>
</html>
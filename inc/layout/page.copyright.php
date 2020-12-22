<?php
if (INCLUDED!==true) { include('index.htm'); exit; }

?>
 <span class="textlinks"><small><a href="index.php?n=support.rules">Rules</a> | <a href="index.php?n=support.license">License</a> | <a href="mailto:<? echo $SETTING['EMAIL_MAIN']; ?>">Contact</a>
                                                <br>&copy; World of Warcraft and Blizzard Entertainment are trademarks or registered trademarks of Blizzard Entertainment, Inc. in the U.S. and/or other countries.<br>
													<?php echo $SETTING['WEB_SITE_NAME']; ?> is in no way associated with Blizzard Entertainment.<br>
												WeboW BL for Mangos v1.0.2.6 Beta | Main Developer, Author - Zynaga | Page Load Time - <?php echo round((array_sum(explode(" ",microtime())) - $startTime),2).' Second(s)'; ?></small></span>
<?php

$ANY_ACCESS = true; //False - Only allows the website to be installed from Local Network; True - Allows to install the website from any external or internal computer;
$DEFAULT_USERNAME='webow'; //Default Username to Access Installation Page;
$DEFAULT_PASSWORD='webow'; //Default Password to Access Installation Page;

if (INCLUDED!==true) { include('index.htm'); exit; }

parchup();

title('Install WoW Website Template');

unset($_SESSION['userid']);
unset($_COOKIE['ALOG_ID']);

parchdown();

$USER_ACCESS = explode(".", $_SERVER['REMOTE_ADDR'], 4);

//VALIDATE NETWORK ACCESS
if ($USER_ACCESS[0] == '127' or $USER_ACCESS[0] =='192' or $USER_ACCESS[0] == '10' or $USER_ACCESS[0] == 'localhost' or $ANY_ACCESS == true) {

$forceshow=false;

//VALIDATE PHP/MODULES VERSION
if (@version_compare(phpversion(), "5.0.0", "<")==-1) {
	$haserrors.='Your PHP version must be 5.0.0 or later (Currently is '.phpversion().').<br>';
}
if (!@extension_loaded('mysql')) {
	$haserrors.="Your 'MySQL' Extension must be Enabled.<br>";
}
if (!@extension_loaded('gd')) {
	$haserrors.="Your 'GD' Extension must be Enabled.<br>";
}
if (!@is_writable('inc/conf/')) {
	$haserrors.="The folder <i>inc/conf</i> must be set writable.<br>";
}
if ($haserrors=='') {

//MySQL NEW CONNECTION
if ($_SESSION['IN_MYSQL_HOST']!='') {
	$MySQL_CON = @mysql_connect($_SESSION['IN_MYSQL_HOST'].':'.$_SESSION['IN_MYSQL_PORT'], $_SESSION['IN_MYSQL_USER'], $_SESSION['IN_MYSQL_PASS']);
	if ($MySQL_CON) $sqldb = @mysql_select_db($_SESSION['IN_MYSQL_DB'], $MySQL_CON);
}

$forceshow=true;

//VALIDATION SWITCH
switch ($_POST['step']) {
		case "complete":
			//Validate Settings
			if ($_POST['update']=='true') {
				if (alphanum($_POST['wsitename'],true,true," _-")==false) {
					$haserrors .= 'Invalid Web Site Name!<br>';
				}
				if (valemail($_POST['wemailmain'])==false) {
					$haserrors .= 'Invalid E-mail!<br>';
				}
			}

			if ($haserrors!="") {
				$_POST['step']='settings';
				$_SESSION['IN_COMPLETED']=false;
			} else {
				$_SESSION['IN_SETTINGS_WEB_NAME']=$_POST['wsitename'];
				$_SESSION['IN_SETTINGS_WEB_LOCATION']=$_POST['wcountry'];
				$_SESSION['IN_SETTINGS_WEB_GMT']=$_POST['wgmt'];

				$_SESSION['IN_SETTINGS_MAIL_MAIN']=$_POST['wemailmain'];
				$_SESSION['IN_COMPLETED']=true;
			}

			//Complete Installation
			if ($_SESSION['IN_COMPLETED']==true) {

				if ($_SESSION['IN_SETTINGS']==false) {
					$haserrors='This Step was Skipped!';
					$_POST['step']='settings';
				} else if ($_SESSION['IN_OWNER']==false) {
					$haserrors='This Step was Skipped!';
					$_POST['step']='setowner';
				} else if ($_SESSION['IN_MYSQL']==false) {
					$haserrors='This Step was Skipped!';
					$_POST['step']='mysqlserver';
				} else if ($_SESSION['IN_DEFUSER']==false) {
					$haserrors='This Step was Skipped!';
					$_POST['step']='defuser';
				} else if ($_SESSION['IN_AGREEMENT']==false) {
					$haserrors='This Step was Skipped!';
					$_POST['step']='agreement';
				} else if ($_SESSION['IN_WELCOME']==false) {
					$haserrors='This Step was Skipped!';
					$_POST['step']='welcome';
				} else {
					//Save Settings

					//Owner Validate/Create
					if ($_SESSION['IN_OWNER_TYPE']=='new') {
						//New
						$queryowner = mysql_query('SELECT id FROM account WHERE username="'.$_SESSION['IN_OWNER_NAME'].'"', $MySQL_CON);
						if (mysql_num_rows($queryowner)>0) {
							$haserrors = 'Username Already Exists.';
						} else {
							$queryowner = mysql_query('INSERT INTO account (username, sha_pass_hash, gmlevel) VALUES("'.$_SESSION['IN_OWNER_NAME'].'", "'.SHA1(strtoupper($_SESSION['IN_OWNER_NAME'].':'.$_SESSION['IN_OWNER_PASS'])).'", "3")', $MySQL_CON);
							if ($queryowner) {
								$WEBOW_OWNER = mysql_insert_id($MySQL_CON);
								$_SESSION['IN_OWNER_TYPE']='exist';
							}
						}
					} else {
						//Exist
						$queryowner = mysql_query('SELECT id FROM account WHERE gmlevel=3 AND username="'.$_SESSION['IN_OWNER_NAME'].'" AND sha_pass_hash="'.SHA1(strtoupper($_SESSION['IN_OWNER_NAME'].':'.$_SESSION['IN_OWNER_PASS'])).'"', $MySQL_CON);
						if (mysql_num_rows($queryowner)!=1) {
							$haserrors = 'Invalid Account Name or/and Account Pasword!';
						} else {
							$queryowner=mysql_fetch_array($queryowner);
							$WEBOW_OWNER = $queryowner['id'];
						}
					}

					//DB CREATE
					if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" AND $haserrors=='') {

						$newquery =mysql_query("DROP TABLE IF EXISTS web_misc", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS forum_accounts", $MySQL_CON);
						if (!$newquery)$haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS forum_pm", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS forums", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS forum_views", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS forum_reports", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS forum_topics", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS forum_posts", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS forum_rel_account_polls", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS forum_rel_topics_polls", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS web_donations", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS web_online", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

                        $newquery =mysql_query("DROP TABLE IF EXISTS forum_smiles", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS web_settings", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("DROP TABLE IF EXISTS realm_settings", $MySQL_CON);
						if (!$newquery) $haserrors.=mysql_error().'.<br>';
					} else {
						$_POST['step']='setowner';
						$_SESSION['IN_SETTINGS']=false;
					}

					if ($haserrors=="") {
						$newquery =mysql_query("CREATE TABLE `forum_views` (
												`id_topic` int(10) unsigned NOT NULL auto_increment,
												`id_account` varchar(45) collate latin1_general_ci NOT NULL,
												`time` datetime NOT NULL default '0000-00-00 00:00:00',
												PRIMARY KEY  (`id_topic`,`id_account`)
												) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `web_misc` (
												`id_misc` int(11) NOT NULL auto_increment,
												`title` varchar(100) collate latin1_general_ci default NULL,
												`text` varchar(200) collate latin1_general_ci default NULL,
												`urls` text collate latin1_general_ci default NULL,
												`image` varchar(200) collate latin1_general_ci default NULL,
												PRIMARY KEY  (`id_misc`)
												) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

                        $newquery =mysql_query("CREATE TABLE `forum_smiles` (
												`id_smile` varchar(7) NOT NULL ,
                                                `path` varchar(255) NOT NULL ,
												PRIMARY KEY  (`id_smile`)
												) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `web_donations` (
												`id_donation` int(10) unsigned NOT NULL auto_increment,
												`id_account` int(10) unsigned NOT NULL,
												`value` varchar(45) collate latin1_general_ci NOT NULL default '0',
												`date` date NOT NULL default '0000-00-00',
												`hide` TINYINT(1) NOT NULL default '0',
												PRIMARY KEY  (`id_donation`,`id_account`)
												) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `forum_accounts` (
												`id_account` int(10) unsigned NOT NULL default '0',
												`location` varchar(2) collate latin1_general_ci NOT NULL default '00',
												`showlocation` tinyint(1) unsigned NOT NULL default '0',
												`bday` date NOT NULL default '0000-00-00',
												`showbday` tinyint(1) unsigned NOT NULL default '0',
												`signature` text collate latin1_general_ci,
												`gmt` varchar(6) collate latin1_general_ci NOT NULL default '0:00',
												`webpage` varchar(200) collate latin1_general_ci default NULL,
												`fname` varchar(50) collate latin1_general_ci default NULL,
												`lname` varchar(50) collate latin1_general_ci default NULL,
												`passask` varchar(200) collate latin1_general_ci default NULL,
												`passans` varchar(200) collate latin1_general_ci default NULL,
												`city` varchar(50) collate latin1_general_ci default NULL,
												`aim` varchar(200) collate latin1_general_ci default NULL,
												`msn` varchar(200) collate latin1_general_ci default NULL,
												`yahoo` varchar(200) collate latin1_general_ci default NULL,
												`skype` varchar(200) collate latin1_general_ci default NULL,
												`icq` varchar(200) collate latin1_general_ci default NULL,
												`enablepm` tinyint(1) unsigned NOT NULL default '0',
												`enableemail` tinyint(1) unsigned NOT NULL default '0',
												`template` varchar(50) collate latin1_general_ci default NULL,
												`avatar` varchar(50) collate latin1_general_ci NOT NULL default 'nochar',
												`lastlogin` datetime NOT NULL default '0000-00-00 00:00:00',
												`displayname` varchar(25) collate latin1_general_ci NOT NULL,
												`activation` varchar(32) collate latin1_general_ci default NULL,
												`ismvp` tinyint(1) unsigned NOT NULL default '0',
												`gender` tinyint(1) unsigned NOT NULL default '0',
												PRIMARY KEY  (`id_account`)
												) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `forum_reports` (
												`id_report` int(10) unsigned NOT NULL auto_increment,
												`id_account` int(10) unsigned NOT NULL default '0',
												`id_post` int(10) unsigned NOT NULL default '0',
												`reason` varchar(255) collate latin1_general_ci NOT NULL,
												PRIMARY KEY  (`id_report`)
												) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `forum_pm` (
												`id_pm` int(10) unsigned NOT NULL auto_increment,
												`id_account_to` int(10) unsigned NOT NULL,
												`message` text collate latin1_general_ci,
												`date` date NOT NULL default '0000-00-00',
												`hour` time NOT NULL default '00:00:00',
												`isread` tinyint(1) unsigned NOT NULL default '0',
												`id_account_from` int(10) unsigned NOT NULL default '0',
												`subject` varchar(100) collate latin1_general_ci default NULL,
												`isdeleted` int(10) unsigned NOT NULL default '0',
												`issignature` tinyint(1) unsigned NOT NULL default '1',
												`isbbcode` tinyint(1) unsigned NOT NULL default '1',
												PRIMARY KEY  (`id_pm`,`id_account_to`,`id_account_from`,`isdeleted`)
												) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `forum_posts` (
												`id_post` int(10) unsigned NOT NULL auto_increment,
												`id_topic` int(10) unsigned NOT NULL,
												`text` text collate latin1_general_ci,
												`isbbcode` tinyint(1) unsigned NOT NULL default '0',
												`issignature` tinyint(1) unsigned NOT NULL default '0',
												`id_account` int(10) unsigned NOT NULL,
												`date` date NOT NULL default '0000-00-00',
												`hour` time NOT NULL default '00:00:00',
												`isreply` tinyint(1) unsigned NOT NULL default '1',
												`id_account_edit` int(10) unsigned NOT NULL default '0',
												`date_edit` date NOT NULL default '0000-00-00',
												`hour_edit` time NOT NULL default '00:00:00',
												PRIMARY KEY  (`id_post`,`id_topic`,`id_account`)
												) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `forum_topics` (
												`id_topic` int(10) unsigned NOT NULL auto_increment,
												`viewlevel` varchar(2) collate latin1_general_ci NOT NULL default '-1',
												`postlevel` varchar(2) collate latin1_general_ci NOT NULL default '0',
												`title` varchar(200) collate latin1_general_ci default NULL,
												`image` varchar(40) collate latin1_general_ci default NULL,
												`views` int(10) unsigned NOT NULL default '0',
												`issticked` tinyint(1) unsigned NOT NULL default '0',
												`category` tinyint(1) unsigned NOT NULL default '0',
												`id_forum_moved` int(10) unsigned NOT NULL default '0',
												`poll_question` varchar(45) collate latin1_general_ci default NULL,
												`poll_lasts` tinyint(3) unsigned NOT NULL default '0',
												`poll_stamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
												`id_forum` int(10) unsigned NOT NULL default '0',
												PRIMARY KEY  (`id_topic`,`id_forum_moved`,`id_forum`)
												) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `forums` (
												`id_forum` int(10) unsigned NOT NULL auto_increment,
												`title` varchar(45) collate latin1_general_ci NOT NULL,
												`description` varchar(255) collate latin1_general_ci NOT NULL,
												`group` tinyint(2) unsigned NOT NULL default '0',
												`image` varchar(50) collate latin1_general_ci NOT NULL default 'bullet.gif',
												`viewlevel` varchar(2) collate latin1_general_ci NOT NULL default '-1',
												`postlevel` varchar(2) collate latin1_general_ci NOT NULL default '0',
												`ordenation` int(10) unsigned NOT NULL default '0',
												`categorized` tinyint(1) unsigned NOT NULL default '0',
												PRIMARY KEY  (`id_forum`)
												) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `web_settings` (
												`setting` varchar(25) collate latin1_general_ci NOT NULL,
												`value` text collate latin1_general_ci default NULL,
												UNIQUE KEY `Locked` (`setting`)
												) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `forum_rel_account_polls` (
												`id_poll` int(10) unsigned NOT NULL,
												`id_account` int(10) unsigned NOT NULL,
												PRIMARY KEY  USING BTREE (`id_poll`,`id_account`)
												) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `forum_rel_topics_polls` (
												`id_poll` int(10) unsigned NOT NULL auto_increment,
												`id_topic` int(10) unsigned NOT NULL,
												`name` varchar(45) collate latin1_general_ci NOT NULL,
												PRIMARY KEY  (`id_poll`)
												) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';

						$newquery =mysql_query("CREATE TABLE `realm_settings` (
												`id_realm` int(10) unsigned NOT NULL,
												`dbuser` varchar(25) collate latin1_general_ci NOT NULL,
												`dbpass` varchar(25) collate latin1_general_ci NOT NULL,
												`dbhost` varchar(25) collate latin1_general_ci NOT NULL,
												`dbport` varchar(5) collate latin1_general_ci NOT NULL,
												`dbname` varchar(25) collate latin1_general_ci NOT NULL,
												`uptime` datetime NOT NULL default '0000-00-00 00:00:00',
												PRIMARY KEY  (`id_realm`)
												) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';
						
						$newquery =mysql_query("CREATE TABLE `web_online` (
												`id` int(10) unsigned NOT NULL default '0',
												`page` varchar(50) collate latin1_general_ci NOT NULL default 'news.current',
												`time` datetime NOT NULL default '0000-00-00 00:00:00',
												`ip` varchar(15) collate latin1_general_ci NOT NULL default '0.0.0.0',
												`isguest` tinyint(1) unsigned NOT NULL default '0',
												PRIMARY KEY  USING BTREE (`id`,`isguest`)
												) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';
					} else {
						$_POST['step']='mysql';
						$_SESSION['IN_OWNER']=false;
					}
					
					if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and $haserrors=="") {					
						$newquery =mysql_query("INSERT INTO web_misc(`id_misc`, title, `text`, urls, image) VALUES(1,'Pictures', 'Enjoy our Picture Galleries. Share yours with us aswell.', '[url=?n=media.screenshots]Screenshots[/url]\r\n[url=?n=media.wallpapers]Wallpapers[/url]\r\n[url=?n=community.fanart]Fan Art[/url]', 'misc-image-bc.gif');", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';
						
						$newquery =mysql_query("INSERT INTO web_misc(`id_misc`, title, `text`, urls, image) VALUES(2,'Challenges', 'Two different types where you must use your strategy or creativity.', '[url=?n=community.contests]Contests[/url]\r\n[url=?n=workshop.eventscalendar]Events Calendar[/url]', 'misc-icon-insider.gif');", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';
						
						$newquery =mysql_query("INSERT INTO web_settings (`setting`,`value`) VALUES 
												('email_main','".$_SESSION['IN_SETTINGS_MAIL_MAIN']."'),
												('email_host',''),
												('email_password',''),
												('email_port',''),
												('email_username',''),
												('email_ssl','0'),
												('forum_enabled','1'),
												('email_enabled','0'),
												('web_gmt','".$_SESSION['IN_SETTINGS_WEB_GMT']."'),
												('donations_enabled','0'),
												('user_edit_own_posts','1'),
												('user_enable_pm','0'),
												('user_enable_signature','0'),
												('user_reg_active','1'),
												('user_remove_own_posts','1'),
												('web_enable_modules','1'),
												('web_show_community','1'),
												('web_show_contests','1'),
												('web_show_donations','1'),
												('web_show_fanart','1'),
												('web_show_flash','1'),
												('web_show_jobs','1'),
												('web_show_misc','1'),
												('web_show_news','1'),
												('web_show_support','1'),
												('web_show_wallpapers','1'),
												('user_accounts','2'),
												('user_enable_email','1'),
												('user_misc','2'),
												('user_reg_mail','0'),
												('user_poll','0'),
												('donations_day_start','0000-00-00'),
												('donations_day_end','0000-00-00'),
												('user_donations','0'),
												('user_email','3'),
												('user_forums','2'),
												('user_web','2'),
												('donations_needed_value','100'),
												('donations_pay_obj',''),
												('donations_currency','€'),
												('web_flash_url','new-hp/flash/loader.swf'),
												('web_location','".$_SESSION['IN_SETTINGS_MAIL_WEB_LOCATION']."'),
												('web_site_name','".$_SESSION['IN_SETTINGS_WEB_NAME']."'),										
												('web_def_template','Wrath_of_the_Lich_King'),
												('db_restore','4'),
												('db_backup','2'),
												('server_owner','".$WEBOW_OWNER."');", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';
						
						$query = mysql_query("SELECT * FROM realmlist", $MySQL_CON);
						while($row = mysql_fetch_array($query)) {
							$newquery =mysql_query("INSERT INTO realm_settings(id_realm,dbhost,dbport,dbuser,dbpass,dbname) VALUES('".$row['id']."','".$_POST['sqlhost']."','".$_POST['sqlport']."','".$_POST['sqluser']."','".$_POST['sqlpass']."','mangos')", $MySQL_CON);
						}
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';
						
						$query = mysql_query("SELECT id, username FROM `account`", $MySQL_CON);
						while($row = mysql_fetch_array($query)) {
							$newquery =mysql_query("INSERT INTO forum_accounts(id_account, displayname) VALUES('".$row['id']."', '".$row['username']."')", $MySQL_CON);
						}
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';
						
						$newquery =mysql_query("INSERT INTO `forums` (`id_forum`,`title`,`description`,`group`,`image`,`viewlevel`,`postlevel`,`ordenation`,`categorized`) VALUES 
												 (1,'Welcome to WoW- A Beginner’s Forum','New to the World of Warcraft? Ask questions from experienced players and learn more about the adventures that await you!',0,'newplayers.gif','-1','0',0,0),
												 (2,'Realm Status','Collection of important messages regarding the status of the Realms.',3,'serverstatus.gif','-1','0',1,0),
												 (3,'Customer Service Forum','Keeps us informed about spammers or any other abusive manners. And post bugs/problems here.',6,'cs.gif','-1','0',2,0),
												 (4,'General Discussion','Discuss World of Warcraft.',0,'general.gif','-1','0',3,0),
												 (5,'UI & Macros Forum','Work with other players to create your own special custom interfaces and macros.',0,'uicustomizations.gif','-1','0',5,0),
												 (7,'Druid','',1,'druid.gif','-1','0',7,1),
												 (8,'Suggestions','Have a suggestion for ".$_SESSION['IN_SETTINGS_WEB_NAME']."? Please post it here. ',3,'suggestions.gif','-1','0',6,0),
												 (9,'Proffesions','Discuss professions in detail.',0,'professions.gif','-1','0',8,0),
												 (10,'PvP Discussion','Discuss player versus player combat.',5,'pvp.gif','-1','0',9,0),
												 (11,'Realm Forums','Discuss topics related to World of Warcraft with players on your specific Realm.',3,'realms.gif','-1','0',10,0),
												 (12,'Quests','Talk about and get help with the countless quests in World of Warcraft.',3,'quests.gif','-1','0',11,0),
												 (13,'Off-topic Discussion','Off-topic posts of interest to the ".$_SESSION['IN_SETTINGS_WEB_NAME']." community.',0,'offtopic.gif','-1','0',12,0),
												 (14,'".$_SESSION['IN_SETTINGS_WEB_NAME']." Archive','A collection of important messages and announcements, including the extended forum guidelines.',6,'blizzard.gif','-1','0',13,0),
												 (15,'Guild Recruitment','Searching for a guild, or do you want to advertise your guild?',4,'guilds.gif','-1','0',14,0),
												 (16,'Role-Playing','Pull up a chair, drink a mug of ale, meet new friends, tell stories, and role-play in this forum.',3,'roleplaying.gif','-1','0',15,0),
												 (17,'Guild Relations','Step in and share ideas and experiences on in-guild and inter-guild relationships.',4,'guildrelations.gif','-1','0',16,0),
												 (18,'Raids & Dungeons','Share your victories and discuss tactics, encounters and group composition, and look to future challenges for your band of heroes.',4,'dungeons.gif','-1','0',17,0),
												 (20,'Battlegroup Forums','Discuss your latest victories with your Battlegroup and show off your realm pride!',5,'battlegroup.gif','-1','0',20,0),
												 (21,'Realm Status','Collection of important messages regarding the status of the Realms.!',5,'serverstatus.gif','-1','0',20,0),
												 (22,'Guide Forum','Share your guides for classes, professions, leveling and more.',5,'guides.gif','-1','0',20,0),
												 (23,'Bug Report Forum','Found a bug in the game or on our website? Help us squash it by reporting it here!',5,'bugs.gif','-1','0',20,0),
												 (24,'Rogue','',1,'rogue.gif','-1','0',21,1),
												 (25,'Priest','',1,'priest.gif','-1','0',22,1),
												 (26,'Hunter','',1,'hunter.gif','-1','0',23,1),
												 (27,'Shaman','',1,'shaman.gif','-1','0',24,1),
												 (28,'Warrior','',1,'warrior.gif','-1','0',25,1),
												 (29,'Mage','',1,'mage.gif','-1','0',26,1),
												 (30,'Paladin','',1,'paladin.gif','-1','0',27,1),
												 (31,'Warlock','',1,'warlock.gif','-1','0',28,1);", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';
						
						$newquery =mysql_query("INSERT INTO `forum_topics` (`id_topic`,`viewlevel`,`postlevel`,`title`,`image`,`views`,`issticked`,`category`,`id_forum_moved`,`poll_question`,`poll_lasts`,`id_forum`) VALUES 
												 (1,'-1','1','How to connect to our Server?','',0,1,2,0,'',0,1),
												 (2,'-1','1','Welcome!','news-alert.gif ',0,1,1,0,'',0,1);", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';
						
						$newquery =mysql_query("INSERT INTO `forum_posts` (`id_post`,`id_topic`,`text`,`isbbcode`,`issignature`,`id_account`,`date`,`hour`,`isreply`,`id_account_edit`,`date_edit`,`hour_edit`) VALUES 
												(1,1,'First make an account on our website then, set your realmlist.wtf (edit it with Notepad), located in your World of Warcraft root folder, to:\r\n\r\n[community]set realmlist 0.0.0.0[/community]\r\n[p]Login and have fun.\r\n\r\nThank You.[/p]',1,1,'".$WEBOW_OWNER."','".date('Y-m-d')."','".date('H:i:s')."',0,0,'0000-00-00','00:00:00'),
												(2,2,'Welcome to %SITENAME%!\r\nWe hope you enjoy playing here.\r\nFeel free to explore our Website.',1,1,'".$WEBOW_OWNER."','".date('Y-m-d')."','".date('H:i:s')."',0,0,'0000-00-00','00:00:00');", $MySQL_CON);
						if ($_SESSION['IN_MYSQL_TABLES']=="dropcreate" and !$newquery) $haserrors.=mysql_error().'.<br>';
						
					}  else {
						$_POST['step']='mysql';
						$_SESSION['IN_OWNER']=false;
					}
					
					if ($haserrors=='') {
						if (!newdbsettings($_SESSION['IN_MYSQL_HOST'], $_SESSION['IN_MYSQL_PORT'], $_SESSION['IN_MYSQL_USER'], $_SESSION['IN_MYSQL_PASS'], $_SESSION['IN_MYSQL_DB'])) {  
							$haserrors .= "Couldn't save general settings!";	
						}
						if ($haserrors=='') {
							$forceshow=false;

							parchup(true);
			
							goodborder($_LANG['SUCCESS']['INSTALLED']);
							
							parchdown();
							
							unset($_POST['step']);
							unset($_SESSION);
						} else {					
							$_POST['step']='welcome';
						}
					}  else {
						$_POST['step']='mysql';
						$_SESSION['IN_OWNER']=false;
					}
				}
			}
		break;
		case "settings":
			//Validate SetOnwer
			if ($_POST['update']=='true') {
				if ($_POST['acctype']=='new') {
					//Validate New User
					if (strlen($_POST['accname'])<3 or strlen($_POST['accname'])>16) {
						$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_ACC_NAME'];		
					} else {
						if (alphanum($_POST['accname'],true,true,'_')==false) {
							$haserrors .= $_LANG['ACCOUNT']['INVALID_CHAR_ACC_NAME'];		
						} else {
							$query=mysql_query("SELECT username FROM account WHERE LOWER(username)=LOWER('".$_POST['accname']."')");
							if (mysql_num_rows($query)!=0) {
								$haserrors .= $_LANG['ACCOUNT']['ACC_NAME_ALREADY_EXISTS'];
							}
						}
					}
					if (strlen($_POST['accpass'])<6 or strlen($_POST['accpass'])>16) {
						$haserrors .= $_LANG['ACCOUNT']['INVALID_LENGHT_PASSW'];		
					} else {
						if (alphanum($_POST['accpass'],true,true,'_')==false) {
							$haserrors .= $_LANG['ACCOUNT']['INVALID_CHAR_PASSW'];		
						} else {
							if ($_POST['accpass']!=$_POST['caccpass']) {
								$haserrors .= $_LANG['ACCOUNT']['PASSW_MISMATCH'];		
							} else {
								if ($_POST['accname']==$_POST['accpass']) {
									$haserrors .= $_LANG['ACCOUNT']['ACC_EQUAL_PASSW'];
								}
							}
						}
					} //Fixed by Twister1002
				} else {
                    $queryowner = mysql_query("SELECT * FROM `account` WHERE `gmlevel` = '3' AND `username` = '".$_POST['accname']."' AND `sha_pass_hash` = '".sha1(strtoupper($_POST['accname'].":".$_POST['accpass']))."'", $MySQL_CON) or die(mysql_error());
                    if (mysql_num_rows($queryowner) < 1) {
                        $haserrors = 'Invalid Account Name or/and Account Pasword!';

					}
				}
				if ($haserrors!="") {
					$_POST['step']='setowner';
					$_SESSION['IN_SETTINGS']=false;
				} else {
					$_SESSION['IN_OWNER_TYPE']=$_POST['acctype'];
					$_SESSION['IN_OWNER_NAME']=$_POST['accname'];
					$_SESSION['IN_OWNER_PASS']=$_POST['accpass'];
					$_SESSION['IN_SETTINGS']=true;
				}
			}													
		break;
		case "setowner":
			//Validate MySQL
			if ($_POST['update']=='true') {
				if (strlen($_POST['sqlhost'])<1) {
					$haserrors .="Invalid length on MySQL Server Host field.<br>";
				}
				if (strlen($_POST['sqlport'])<1) {
					$haserrors .="Invalid length on MySQL Server Port field.<br>";
				}
				if (strlen($_POST['sqldb'])<1) {
					$haserrors .="Invalid length on Mangos 'realmd' Database field.<br>";
				}
				if ($haserrors=="") {
					$MySQL_CON = @mysql_connect($_POST['sqlhost'].':'.$_POST['sqlport'], $_POST['sqluser'], $_POST['sqlpass']);
					if (!$MySQL_CON) $haserrors.="Couldn't connect to MySQL Server.<br>";

					if ($haserrors=="") {
						$sqldb = @mysql_select_db($_POST['sqldb'], $MySQL_CON);
						if (!$sqldb) $haserrors.="Coulnd't Select Database.<br>";
					}
				}
				if ($haserrors!="") {
					$_POST['step']='mysqlserver';
					$_SESSION['IN_OWNER']=false;
				} else {
					$_SESSION['IN_MYSQL_HOST']=$_POST['sqlhost'];
					$_SESSION['IN_MYSQL_PORT']=$_POST['sqlport'];
					$_SESSION['IN_MYSQL_USER']=$_POST['sqluser'];
					$_SESSION['IN_MYSQL_PASS']=$_POST['sqlpass'];
					$_SESSION['IN_MYSQL_DB']=$_POST['sqldb'];
					$_SESSION['IN_MYSQL_TABLES']=$_POST['dropt'];
					$_SESSION['IN_OWNER']=true;
				}
			}
		break;
		case "mysqlserver":
			//Validate Defuser
			if ($_POST['update']=='true') {
				if (($DEFAULT_USERNAME != $_POST['insu'] OR $DEFAULT_PASSWORD != $_POST['insp'])) {
					$haserrors='Invalid Username Or/And Password!';
					$_POST['step']='defuser';
					$_SESSION['IN_MYSQL']=false;
				} else {
					$_SESSION['IN_DEF_USERNAME']=$_POST['insu'];
					$_SESSION['IN_DEF_PASSWORD']=$_POST['insp'];
					$_SESSION['IN_MYSQL']=true;
				}
			}
		break;
		case "defuser":
			//Validate Agreement
			if ($_POST['update']=='true') {
				$_SESSION['IN_DEFUSER']=true;
			}
		break;		
		case "agreement":
			//Validate Welcome
			if ($_POST['update']=='true') {
				$_SESSION['IN_AGREEMENT']=true;
			}
		break;
		case "welcome":
		default: 
			$_SESSION['IN_WELCOME']=true;
		break;		
}

if ($forceshow==true) {

	?>
	<div align=center>
	<form name="installform" method="post" action="?n=install" onsubmit="return if_valid();">
	<input type=hidden name="step" value="">
	<input type=hidden name="update" value="">
	<?
	
//GRAFICAL SWITCH
	switch ($_POST['step']) {
		case "settings":
?>
<script type="text/javascript">
function if_valid() {
	document.installform.step.value="complete";
	document.installform.update.value="true";
	return true;	
}
</script><br>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
		<tr>
			<td width = "78" valign = "top"></td>
			<td width = "100%" rowspan = "2">
				<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
					<div style = "padding:5px; background-image: url('new-hp/images/layout/header-gradiant.jpg'); background-repeat: no-repeat;">
						<h3 class="title">Step 6 - Costumize Settings</h3>
						<p>	
						<center>
						<p>
						<table width = "520">
							<tr>
							  <td>
									<span>

<?php if ($haserrors!="") { ?>
			<center>

<?php errborder($haserrors); ?>
			</center>
			<br>
<?php } ?>
									<table width = "520">
										<tr>
										  <td>
											<span>
											<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
											<tr>
												<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
												<td width = "100%" bgcolor = "#05374A" height = "20"><b class = "white">Website Settings:</b></td>
												<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
											</tr>
											</table>
									<table style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
										<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
											<table border=0 cellspacing=0 cellpadding=4 width = "510">
												<tr>
													<td colspan = "2">
													<table border=0 cellspacing=0 cellpadding=4 width = "100%">
													<tr>
													      <td width=200 align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Website Name:<br>
													      </span></b></font>
													      </td>
													      <td 60% align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td><input name=wsitename type=text size=40 maxlength=80 value="WeboW BL for Mangos"></td>
															</tr>
														  </table>
														  </td>
													</tr>
													<tr>
													      <td align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Server Location:<br>
													      </span></b></font>
													      </td>
													      <td align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td><select style="width: 150px;" name="wcountry" OnChange="javascript:void(document.installform.cflag.src = 'new-hp/images/flags/' + this.value + '.gif')">
<?
foreach ($COUNTRY as $key=>$value) {
											echo '<option value="'.$key.'">'.$value.'</option>';
}?></selected><script>void(document.installform.wcountry.value='00')</script>
																</td>
																<td>&nbsp;<img name="cflag" src="new-hp/images/flags/00.gif"></td>
															</tr>
														  </table>
														  </td>
													</tr>
													<tr>
													      <td align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Server Time Zone:<br>
													      </span></b></font>
													      </td>
													      <td 60% align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td>
																<select style="width: 250px;" name="wgmt"> 
<?
for($i=-12;$i<count($GMT)-12;$i++) {
											echo '<option value="'.$i.'">(GMT '.$GMT[$i][0].') '.$GMT[$i][1].'</option>';
}
?><script>void(document.installform.wgmt.value='0')</script>
																</select>
																</td>
															</tr>
														  </table>
														  </td>
													</tr>
													</table>
													</td>
												</tr>
												<tr>
													<td colspan = "2">
														
													</td>
												</tr>
											</table>
										</td></tr></table>
									</td></tr></table>
									</span>

								</td>
										</tr></table>
								    <P>
<table width = "520">
										<tr>
										  <td>
											<span>
											<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
											<tr>
												<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
												<td width = "100%" bgcolor = "#05374A" height = "20"><b class = "white">E-Mail Settings:</b></td>
												<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
											</tr>
											</table>
									<table style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
										<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
											<table border=0 cellspacing=0 cellpadding=4 width = "510">
												<tr>
													<td colspan = "2">
													<table border=0 cellspacing=0 cellpadding=4 width = "100%">
														<tr>
														  <td width=200 align=right>
														  <font face="arial,helvetica" size=-1><span><b>
														Main E-mail:
														  </span></b></font>
														  </td>
														  <td align=left><table border=0 cellspacing=0 cellpadding=0><tr><td><input name="wemailmain" style = "Width:150" taborder=1/></td><td valign = "top">

														   </td></tr></table></td>
													</tr>
													</table>
													</td>
												</tr>
												<tr>
													<td colspan = "2">
														
													</td>
												</tr>
											</table>
										</td></tr></table>
									</td></tr></table>
									</span>

								</td>
										</tr></table>
								    <P>
								<center>
								<table cellspacing = "0" cellpadding = "0" border = "0">
								<tr>
<!-- BACK-->		<td Width="91"><a href="javascript:document.installform.step.value='setowner'; javascript:document.installform.update.value=''; javascript:installform.submit()"><img src="shared/wow-com/images/buttons/button-back.gif" alt="<?php echo $_LANG['ACCOUNT']['BACK']; ?>" Width="91" Height="46" taborder=8></a></td>
<!-- CONTINUE-->	<td width="174"><input type=image SRC="shared/wow-com/images/buttons/button-complete.gif" name="Submit" alt="<?php echo $_LANG['ACCOUNT']['CONTINUE']; ?>" Width="174" Height="46" Border=0 class="button"  taborder=7 ></td>
								</tr>
								</table>
							</center>
						<img src = "new-hp/images/pixel.gif" width = "500" height = "1">
						<center><span></td>
			<td width = "76" valign = "top"></td>
		</tr>
		<tr>
			<td valign = "bottom"></td>
			<td valign = "bottom"></td>
		</tr>
			</table>
		</td>
	</tr>
</table>
<script>
<?php if ($haserrors!='' OR $_POST['update']=='change') { ?>
document.installform.wsitename.value="<?php echo $_POST['wsitename']; ?>";
document.installform.wcountry.value="<?php echo $_POST['wcountry']; ?>";
document.installform.wgmt.value="<?php echo $_POST['wgmt']; ?>";
document.installform.wemailmain.value="<?php echo $_POST['wemailmain']; ?>";
<?php } else if ($_SESSION['IN_COMPLETED']==true AND $_POST['update']!='change') { ?>
document.installform.wsitename.value="<?php echo $_SESSION['IN_SETTINGS_WEB_NAME']; ?>";
document.installform.wcountry.value="<?php echo $_SESSION['IN_SETTINGS_WEB_LOCATION']; ?>";
document.installform.wgmt.value="<?php echo $_SESSION['IN_SETTINGS_WEB_GMT']; ?>";
document.installform.wemailmain.value="<?php echo $_SESSION['IN_SETTINGS_MAIL_MAIN']; ?>";
<?php } ?>
</script>
<?
		break;
		case "setowner":
?>
<script type="text/javascript">
function if_valid() {
	document.installform.step.value="settings";
	document.installform.update.value="true";
	return true;	
}
</script><br>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
		<tr>
			<td width = "78" valign = "top"></td>
			<td width = "100%" rowspan = "2">
				<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
					<div style = "padding:5px; background-image: url('new-hp/images/layout/header-gradiant.jpg'); background-repeat: no-repeat;">
						<h3 class="title">Step 5 - Server Owner</h3>
						<p>	
						<center>
						<p>
						<table width = "520">
							<tr>
							  <td>
									<span>

<?php if ($haserrors!="") { ?>
			<center>

<?php errborder($haserrors); ?>
			</center>
			<br>
<?php } ?>
									<table width = "520">
										<tr>
										  <td>
											<span>
											<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
											<tr>
												<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
												<td width = "100%" bgcolor = "#05374A" height = "20"><b class = "white">Choose the Server Owner:</b></td>
												<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
											</tr>
											</table>
									<table style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
										<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
											<table border=0 cellspacing=0 cellpadding=4 width = "510">
												<tr>
													<td colspan = "2">
													<span>
													The Server Owner is the Master Account. That Account must have Administrator Level, and it will be the Head Administrator
													</span>
													<table border=0 cellspacing=0 cellpadding=4 width = "100%">
													<tr>
														<td colspan = "2">
														<span>
															<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>
														</span>
														</td>
													</tr>
													<?php 
														if ($_SESSION['IN_SETTINGS']==true AND $_POST['update']!='change') {
															$_POST['acctype'] = $_SESSION['IN_OWNER_TYPE'];
														}
													?>
													<tr>
													      <td width=200 align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Account Type:<br>
													      </span></b></font>
													      </td>
													      <td align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td>
																<select name="acctype" onChange="document.installform.step.value='setowner';document.installform.update.value='change';document.installform.submit();">
																<option value="new">New
                                                                <option value="exist" SELECTED>Existing
																</select>
																</td>
															</tr>
														  </table>
														  </td>
													</tr>
													<?php $queryowner = mysql_query('SELECT username FROM account WHERE gmlevel>=3', $MySQL_CON); ?>
                                                    <tr>
														  <?php if ((@mysql_num_rows($queryowner)>0 AND $_POST['acctype']!='new') OR $_POST['acctype']=='new') { ?>
													      <td width=200 align=right >
													      <font face="arial,helvetica" size=-1><span><b>
													      Account Name:<br>
													      </span></b></font>
													      </td>
														  <?php } ?>
													      <td align=left colspan=2>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td>
																<?php if ($_POST['acctype']=='new') { ?>
																<input type=text name="accname" MaxLength="16" Width=130>
																<?php } else {
																			if (@mysql_num_rows($queryowner)>0) {
																				echo '<select name="accname">';
																				while ($rowg = @mysql_fetch_array($queryowner)) {
																					echo '<option value="'.$rowg['username'].'">'.$rowg['username'];
																				}
																				echo '</select>';
																			} else {
																				echo '<span style="color: red;">No Account Exists! Please, select New Account Type.</span>';
																			}
																		}
																?>
																</td>
															</tr>
														  </table>
														  </td>
													</tr>
													<?php if ((@mysql_num_rows($queryowner)>0 AND $_POST['acctype']!='new') OR $_POST['acctype']=='new') { ?>
													<tr>
													      <td width=200 align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Account Password:<br>
													      </span></b></font>
													      </td>
													      <td align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td><input type=password name="accpass" MaxLength="16" Width=130 ></td>
															</tr>
														  </table>
														  </td>
													</tr>
														<?php if ($_POST['acctype']=='new') { ?>
													<tr>
													      <td width=200 align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Confirm Account Password:<br>
													      </span></b></font>
													      </td>
													      <td align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td><input type=password name="caccpass" MaxLength="16" Width=130></td>
															</tr>
														  </table>
														  </td>
													</tr>
														<?php } ?>
													<?php } ?>
													</table>
													</td>
												</tr>
												<tr>
													<td colspan = "2">

													</td>
												</tr>
											</table>
										</td></tr></table>
									</td></tr></table>
									</span>

								</td>
										</tr></table>
								    <P>
								<center>
								<table cellspacing = "0" cellpadding = "0" border = "0">
								<tr>
<!-- BACK-->		<td Width="91"><a href="javascript:document.installform.step.value='mysqlserver'; javascript:document.installform.update.value=''; javascript:installform.submit()"><img src="shared/wow-com/images/buttons/button-back.gif" alt="<?php echo $_LANG['ACCOUNT']['BACK']; ?>" Width="91" Height="46" taborder=8></a></td>
<!-- CONTINUE-->	<td width="174"><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="<?php echo $_LANG['ACCOUNT']['CONTINUE']; ?>" Width="174" Height="46" Border=0 class="button"  taborder=7 ></td>
								</tr>
								</table>
							</center>
						<img src = "new-hp/images/pixel.gif" width = "500" height = "1">
						<center><span></td>
			<td width = "76" valign = "top"></td>
		</tr>
		<tr>
			<td valign = "bottom"></td>
			<td valign = "bottom"></td>
		</tr>
			</table>
		</td>
	</tr>
</table>
<script>
<?php if ($haserrors!='' OR $_POST['update']=='change') { ?>
document.installform.acctype.value="<?php echo $_POST['acctype']; ?>";
document.installform.accname.value="<?php echo $_POST['accname']; ?>";
document.installform.accpass.value="<?php echo $_POST['accpass']; ?>";
if (document.installform.acctype.value=='new') {
document.installform.caccpass.value="<?php echo $_POST['caccpass']; ?>";
}
<?php } else if ($_SESSION['IN_SETTINGS']==true AND $_POST['update']!='change') { ?>
document.installform.acctype.value="<?php echo $_POST['acctype']; ?>";
document.installform.accname.value="<?php echo $_SESSION['IN_OWNER_NAME']; ?>";
document.installform.accpass.value="<?php echo $_SESSION['IN_OWNER_PASS']; ?>";
if (document.installform.acctype.value=='new') {
document.installform.caccpass.value="<?php echo $_SESSION['IN_OWNER_PASS']; ?>";
}
<?php } ?>
</script>
<?		
		break;
		case "mysqlserver":
?>
<script type="text/javascript">
function if_valid() {
	document.installform.step.value="setowner";
	document.installform.update.value="true";
	return true;	
}
</script><br>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
		<tr>
			<td width = "78" valign = "top"></td>
			<td width = "100%" rowspan = "2">
				<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
					<div style = "padding:5px; background-image: url('new-hp/images/layout/header-gradiant.jpg'); background-repeat: no-repeat;">
						<h3 class="title">Step 4 - MySQL Server</h3>
						<p>	
						<center>
						<p>
						<table width = "520">
							<tr>
							  <td>
									<span>

<?php if ($haserrors!="") { ?>
			<center>

<?php errborder($haserrors); ?>
			</center>
			<br>
<?php } ?>
									<table width = "520">
										<tr>
										  <td>
											<span>
											<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
											<tr>
												<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
												<td width = "100%" bgcolor = "#05374A" height = "20"><b class = "white">Settings:</b></td>
												<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
											</tr>
											</table>
									<table style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
										<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
											<table border=0 cellspacing=0 cellpadding=4 width = "510">
												<tr>
													<td colspan = "2">
													<span>
													Fill all the fields to create your MySQL Connection and WeboW Database Tables.
													</span>
													<p>
													<table border=0 cellspacing=0 cellpadding=4 width = "100%">
													<tr>
														<td colspan = "2">
														<span>
															<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>
														</span>
														</td>
													</tr>
													<tr>
													      <td width=200 align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Host Adress:<br>
													      </span></b></font>
													      </td>
													      <td align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td><input type=text name="sqlhost" MaxLength="250" Width=130 value="localhost"></td>
															</tr>
														  </table>
														  </td>
													</tr>
													<tr>
													      <td width=200 align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Port:<br>
													      </span></b></font>
													      </td>
													      <td align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td><input type=text name="sqlport" MaxLength="5" Width=130 value="3306"></td>
															</tr>
														  </table>
														  </td>
													</tr>
													<tr>
													      <td width=200 align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Username:<br>
													      </span></b></font>
													      </td>
													      <td align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td><input type=text name="sqluser" MaxLength="250" Width=130></td>
															</tr>
														  </table>
														  </td>
													</tr>
													<tr>
													      <td width=200 align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Password:<br>
													      </span></b></font>
													      </td>
													      <td align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td><input type=password name="sqlpass" MaxLength="250" Width=130></td>
															</tr>
														  </table>
														  </td>
													</tr>
													<tr>
													      <td width=200 align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Database (realmd):<br>
													      </span></b></font>
													      </td>
													      <td align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td><input type=text name="sqldb" MaxLength="250" Width=130 value="realmd"><small> (Also Website Tables)</small></td>
															</tr>
														  </table>
														  </td>
													</tr>
													<tr>
														<td colspan = "2">
														<span>
															<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>
														</span>
														</td>
													</tr>
													</table>
													<p>
													<span>
													If you have WeboW already installed, choose what you want to do with the existing tables. And be careful because existing tables will NOT be updated.<br><span style="color: red;">Mangos Tables will not be affected but still, it is highly recommended to back them up.</span>
													</span>
													<p>
													<table border=0 cellspacing=0 cellpadding=4 width = "100%">
													<tr>
														<td colspan = "2">
														<span>
															<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>
														</span>
														</td>
													</tr>
													<tr>
														  <td align=right>
														  <font face="arial,helvetica" size=-1><span><b>
															WeboW Tables:
														  </span></b></font>
														  </td>
														  <td align=left colspan = "2"><table border=0 cellspacing=0 cellpadding=0><tr><td><select name=dropt>
														  <option value="dropcreate" SELECTED>Delete Existing and Create New Tables
														  <option value="use">Use Existing and Create Missing Tables
														  </select></td><td valign = "top">

														   </td></tr></table></td>
													</tr>
													</table>
													</td>
												</tr>
												<tr>
													<td colspan = "2">
														
													</td>
												</tr>
											</table>
										</td></tr></table>
									</td></tr></table>
									</span>

								</td>
										</tr></table>
								    <P>
								<center>
								<table cellspacing = "0" cellpadding = "0" border = "0">
								<tr>
<!-- BACK-->		<td Width="91"><a href="javascript:document.installform.step.value='defuser'; javascript:document.installform.update.value=''; javascript:installform.submit()"><img src="shared/wow-com/images/buttons/button-back.gif" alt="<?php echo $_LANG['ACCOUNT']['BACK']; ?>" Width="91" Height="46" taborder=8></a></td>
<!-- CONTINUE-->	<td width="174"><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="<?php echo $_LANG['ACCOUNT']['CONTINUE']; ?>" Width="174" Height="46" Border=0 class="button"  taborder=7 ></td>
								</tr>
								</table>
							</center>
						<img src = "new-hp/images/pixel.gif" width = "500" height = "1">
						<center><span></td>
			<td width = "76" valign = "top"></td>
		</tr>
		<tr>
			<td valign = "bottom"></td>
			<td valign = "bottom"></td>
		</tr>
			</table>
		</td>
	</tr>
</table>
<script>
<?php if ($haserrors!='') { ?>
document.installform.sqlhost.value="<?php echo $_POST['sqlhost']; ?>";
document.installform.sqlport.value="<?php echo $_POST['sqlport']; ?>";
document.installform.sqluser.value="<?php echo $_POST['sqluser']; ?>";
document.installform.sqlpass.value="<?php echo $_POST['sqlpass']; ?>";
document.installform.sqldb.value="<?php echo $_POST['sqldb']; ?>";
document.installform.dropt.value="<?php echo $_POST['dropt']; ?>";
<?php } else if ($_SESSION['IN_OWNER']==true) { ?>
document.installform.sqlhost.value="<?php echo $_SESSION['IN_MYSQL_HOST']; ?>";
document.installform.sqlport.value="<?php echo $_SESSION['IN_MYSQL_PORT']; ?>";
document.installform.sqluser.value="<?php echo $_SESSION['IN_MYSQL_USER']; ?>";
document.installform.sqlpass.value="<?php echo $_SESSION['IN_MYSQL_PASS']; ?>";
document.installform.sqldb.value="<?php echo $_SESSION['IN_MYSQL_DB']; ?>";
document.installform.dropt.value="<?php echo $_SESSION['IN_MYSQL_TABLES']; ?>";
<?php } ?>
</script>
<?
		break;
		case "defuser":
	?>
<script type="text/javascript">
function if_valid() {
	document.installform.step.value="mysqlserver";
	document.installform.update.value="true";
	return true;	
}
</script><br>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
		<tr>
			<td width = "78" valign = "top"></td>
			<td width = "100%" rowspan = "2">
				<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
					<div style = "padding:5px; background-image: url('new-hp/images/layout/header-gradiant.jpg'); background-repeat: no-repeat;">
						<h3 class="title">Step 3 - Authentication</h3>
						<p>	
						<center>
						<p>
						<table width = "520">
							<tr>
							  <td>
									<span>

<?php if ($haserrors!="") { ?>
			<center>

<?php errborder($haserrors); ?>
			</center>
			<br>
<?php } ?>
									<table width = "520">
										<tr>
										  <td>
											<span>
											<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
											<tr>
												<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
												<td width = "100%" bgcolor = "#05374A" height = "20"><b class = "white">Secure Installation:</b></td>
												<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
											</tr>
											</table>
									<table style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
										<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
											<table border=0 cellspacing=0 cellpadding=4 width = "510">
												<tr>
													<td colspan = "2">
													<span>
													In order to make the installation process more secure, there is an editable Username and Password that allows you to proceed to the next step.
													</span>
													<p>
													<table border=0 cellspacing=0 cellpadding=4 width = "100%">
													<tr>
														<td colspan = "2">
														<span>
															<center><img src = "new-hp/images/layout/hr.gif" width = "450" height = "1"></center>
														</span>
														</td>
													</tr>
													<tr>
													      <td width=200 align=right>
													      <font face="arial,helvetica" size=-1><span><b>
													      Username:<br>
													      </span></b></font>
													      </td>
													      <td align=left>
														  <table border=0 cellspacing=0 cellpadding=0>
															<tr>
																<td><input type=text name="insu" MaxLength="250" Width=130></td>
															</tr>
														  </table>
														  </td>
													</tr>
													<tr>
														<td align=right>
															<font face="arial,helvetica" size=-1><span><b>
															Password:<br>
															</span></b></font>
															</td>
															<td align=left>
															<table border=0 cellspacing=0 cellpadding=0>
																<tr>
																	<td><input type=password name="insp" MaxLength="250" Width=130></td>
																</tr>
															</table>
														</td>
													</tr>
													</table>
													</td>
												</tr>
												<tr>
													<td colspan = "2">
														
													</td>
												</tr>
											</table>
										</td></tr></table>
									</td></tr></table>
									</span>

								</td>
										</tr></table>
								    <P>
								<center>
								<table cellspacing = "0" cellpadding = "0" border = "0">
								<tr>
<!-- BACK-->		<td Width="91"><a href="javascript:document.installform.step.value='agreement'; javascript:document.installform.update.value=''; javascript:installform.submit()"><img src="shared/wow-com/images/buttons/button-back.gif" alt="<?php echo $_LANG['ACCOUNT']['BACK']; ?>" Width="91" Height="46" taborder=8></a></td>
<!-- CONTINUE-->	<td width="174"><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="<?php echo $_LANG['ACCOUNT']['CONTINUE']; ?>" Width="174" Height="46" Border=0 class="button"  taborder=7 ></td>
								</tr>
								</table>
							</center>
						<img src = "new-hp/images/pixel.gif" width = "500" height = "1">
						<center><span></td>
			<td width = "76" valign = "top"></td>
		</tr>
		<tr>
			<td valign = "bottom"></td>
			<td valign = "bottom"></td>
		</tr>
			</table>
		</td>
	</tr>
</table>
<script>
<?php if ($haserrors!='') { ?>
document.installform.insu.value="<?php echo $_POST['insu']; ?>";
document.installform.insp.value="<?php echo $_POST['insp']; ?>";
<?php } else if ($_SESSION['IN_DEFUSER']==true) { ?>
document.installform.insu.value="<?php echo $_SESSION['IN_DEF_USERNAME']; ?>";
document.installform.insp.value="<?php echo $_SESSION['IN_DEF_PASSWORD']; ?>";
<?php } ?>
</script>
	<?
		break;
		case "agreement":
	?>
<script type="text/javascript">
function if_valid() {
	document.installform.step.value="defuser";
	document.installform.update.value="true";
	return true;	
}
</script><br>	
<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
		<tr>
			<td width = "78" valign = "top"></td>
			<td width = "100%" rowspan = "2">
				<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
					<div style = "padding:5px; background-image: url('new-hp/images/layout/header-gradiant.jpg'); background-repeat: no-repeat;">
						<h3 class="title">Step 2 - Agreement</h3>
						<p>	
						<center>
						<p>
						<table width = "520">
							<tr>
							  <td>
									<span>

<?php if ($haserrors!="") { ?>
			<center>

<?php errborder($haserrors); ?>
			</center>
			<br>
<?php } ?>
									<table width = "520">
										<tr>
										  <td>
											<span>
											<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
											<tr>
												<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
												<td width = "100%" bgcolor = "#05374A" height = "20"><b class = "white">Terms and Conditions:</b></td>
												<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
											</tr>
											</table>
									<table style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
										<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
											<table border=0 cellspacing=0 cellpadding=4 width = "510">
												<tr>
													<td colspan = "2">
													<span>
													All trademarks and copyrights held by respective owners.
                                                    Webow has been created by Zyanga and has been updated by Computerwiz656.
                                                    THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY
APPLICABLE LAW.  EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT
HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY
OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO,
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
PURPOSE.  THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM
IS WITH YOU.  SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
ALL NECESSARY SERVICING, REPAIR OR CORRECTION.
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    IF YOU BOUGHT THIS PROGRAM GET YOUR MONEY BACK THIS IS FREEWARE.



													</span>
													</td>
												</tr>
												<tr>
													<td colspan = "2">
														
													</td>
												</tr>
											</table>
										</td></tr></table>
									</td></tr></table>
									</span>

								</td>
										</tr></table>
								    <P>
								<center>
								<table cellspacing = "0" cellpadding = "0" border = "0">
								<tr>
<!-- BACK-->		<td Width="91"><a href="javascript:document.installform.step.value=''; javascript:document.installform.update.value=''; javascript:installform.submit()"><img src="shared/wow-com/images/buttons/disagree-button.gif" alt="<?php echo $_LANG['ACCOUNT']['BACK']; ?>" Height="46" taborder=8></a></td>
<!-- CONTINUE-->	<td width="174"><input type=image SRC="shared/wow-com/images/buttons/agree-button.gif" name="Submit" alt="<?php echo $_LANG['ACCOUNT']['CONTINUE']; ?>" Width="174" Height="46" Border=0 class="button"  taborder=7 ></td>
								</tr>
								</table>
							</center>
						<img src = "new-hp/images/pixel.gif" width = "500" height = "1">
						<center><span></td>
			<td width = "76" valign = "top"></td>
		</tr>
		<tr>
			<td valign = "bottom"></td>
			<td valign = "bottom"></td>
		</tr>
			</table>
		</td>
	</tr>
</table>
	<?
		break;	
		case "welcome":
		default:
	?>
<script type="text/javascript">
function if_valid() {
	document.installform.step.value="agreement";
	document.installform.update.value="true";
	return true;	
}
</script><br>
<table cellspacing = "0" cellpadding = "0" border = "0" width = "90%" style="border-left: 1px solid black; border-right: 1px solid black">
		<tr>
			<td width = "78" valign = "top"></td>
			<td width = "100%" rowspan = "2">
				<div style = "font-family:arial,palatino, georgia, verdana, arial, sans-serif; color:#200F01; font-size: 10pt; font-weight: normal; background-image: url('new-hp/images/layout/parchment-light.jpg'); border-style: solid; border-color: #000000; border-width: 0px; border-bottom-width:1px; border-top-width:1px; background-color: #E7CFA3; line-height:140%;">
					<div style = "padding:5px; background-image: url('new-hp/images/layout/header-gradiant.jpg'); background-repeat: no-repeat;">
						<h3 class="title">Step 1 - Welcome to WeboW</h3>
						<p>	
						<center>
						<p>
						<table width = "520">
							<tr>
							  <td>
									<span>

<?php if ($haserrors!="") { ?>
			<center>

<?php errborder($haserrors); ?>
			</center>
			<br>
<?php } ?>
									<table width = "520">
										<tr>
										  <td>
											<span>
											<table cellspacing = "0" cellpadding = "0" border = "0" width = "100%">
											<tr>
												<td width = "24"><img src = "shared/wow-com/images/headers/subheader/subheader-left-sword.gif" width = "24" height = "20"></td>
												<td width = "100%" bgcolor = "#05374A" height = "20"><b class = "white">Greetings:</b></td>
												<td width = "10"><img src = "shared/wow-com/images/headers/subheader/subheader-right.gif" width = "10" height = "20"></td>
											</tr>
											</table>
									<table style = "border-width: 1px; border-style: dotted; border-color: #928058;"><tr><td>
										<table style = "border-width: 1px; border-style: solid; border-color: black; background-image: url('new-hp/images/layout/parch-light2.jpg');"><tr><td>
											<table border=0 cellspacing=0 cellpadding=4 width = "510">
												<tr>
													<td colspan = "2">
													<div align=left>
													Welcome, and thank you for choosing WeboW as Web Front for your Server! The default installation user name and password is "webow". Without quotes.
<br> 
TO ENSURE FULL WEBSITE WORKING ORDER:
<span>Please Enable:</span>
<?
if (!file_exists(".htaccess")) {
die ("<font='red'>Fix .htaccess authentication before continuing</font>");
}
?>
<li> <font color='orange'>.htaccess</font> <small>(In your httpd.conf file Google it if you do not know to enable.)</small></li>
<li>
<?
          if (get_extension_funcs('GD'))  {
             echo "<font color='green'>GD is installed." ;
          } else {
             echo "<font color='red'>GD is NOT installed on the server !";
          } ?>

</li></font>
<li>
<?
          if (get_extension_funcs('MYSQL'))  {
             echo "<font color='green'>MySQL is installed.</font>" ;
          } else {
             echo "<font color='red'>MySQL is NOT installed on the server !";
          } ?></font></li>
<li><font color='green'> PHP is installed</font></li>
<br> 
Run realmd.sql(Website will not install if necessary tables are not present).  
													</div>
													</td>
												</tr>
												<tr>
													<td colspan = "2">
													</td>
												</tr>
											</table>
										</td></tr></table>
									</td></tr></table>
									</span>

								</td>
										</tr></table>
								    <P>
								<center>
								<table cellspacing = "0" cellpadding = "0" border = "0">
								<tr>
<!-- CONTINUE-->	<td width="174"><input type=image SRC="shared/wow-com/images/buttons/button-continue.gif" name="Submit" alt="<?php echo $_LANG['ACCOUNT']['CONTINUE']; ?>" Width="174" Height="46" Border=0 class="button"  taborder=7 ></td>
								</tr>
								</table>
							</center>
						<img src = "new-hp/images/pixel.gif" width = "500" height = "1">
						<center><span></td>
			<td width = "76" valign = "top"></td>
		</tr>
		<tr>
			<td valign = "bottom"></td>
			<td valign = "bottom"></td>
		</tr>
			</table>
		</td>
	</tr>
</table>
	<?
		break;
	}
	?>
	</form>
	</div>
	<?
	
	}
	
	} else {
		parchup(true);
		
		errborder($haserrors);
		
		parchdown();
	}
}

?>
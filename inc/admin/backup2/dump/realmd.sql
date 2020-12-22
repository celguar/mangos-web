# Table backup from MySql PHP Backup
# AB Webservices 1999-2004
# www.absoft-my.com/pondok
# Creation date: 15-May-2009 07:59
# Database: 

DROP TABLE IF EXISTS account;#%%
CREATE TABLE account (
    id bigint(20) unsigned NOT NULL auto_increment,
    username varchar(32) NOT NULL,
    sha_pass_hash varchar(40) NOT NULL,
    gmlevel tinyint(3) unsigned DEFAULT '0' NOT NULL,
    sessionkey longtext,
    v longtext,
    s longtext,
    email varchar(320) NOT NULL,
    joindate timestamp DEFAULT 'CURRENT_TIMESTAMP' NOT NULL,
    last_ip varchar(30) DEFAULT '127.0.0.1' NOT NULL,
    failed_logins int(11) unsigned DEFAULT '0' NOT NULL,
    locked tinyint(3) unsigned DEFAULT '0' NOT NULL,
    last_login timestamp DEFAULT '0000-00-00 00:00:00' NOT NULL,
    online tinyint(4) DEFAULT '0' NOT NULL,
    expansion tinyint(3) unsigned DEFAULT '0' NOT NULL,
    mutetime bigint(40) unsigned DEFAULT '0' NOT NULL,
    locale tinyint(3) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (id),
   UNIQUE idx_username (username),
   KEY idx_gmlevel (gmlevel)
);#%%

INSERT INTO account VALUES ('1','ADMINISTRATOR','a34b29541b87b7e4823683ce6c7bf6ae68beaaac','3','','0','0','','2006-04-25 06:18:56','127.0.0.1','0','0','0000-00-00 00:00:00','0','0','0','0');#%%
INSERT INTO account VALUES ('2','GAMEMASTER','7841e21831d7c6bc0b57fbe7151eb82bd65ea1f9','2','','0','0','','2006-04-25 06:18:56','127.0.0.1','0','0','0000-00-00 00:00:00','0','0','0','0');#%%
INSERT INTO account VALUES ('3','MODERATOR','a7f5fbff0b4eec2d6b6e78e38e8312e64d700008','1','','0','0','','2006-04-25 06:19:35','127.0.0.1','0','0','0000-00-00 00:00:00','0','0','0','0');#%%
INSERT INTO account VALUES ('4','PLAYER','3ce8a96d17c5ae88a30681024e86279f1a38c041','0','','0','0','','2006-04-25 06:19:35','127.0.0.1','0','0','0000-00-00 00:00:00','0','0','0','0');#%%


DROP TABLE IF EXISTS account_banned;#%%
CREATE TABLE account_banned (
    id int(11) DEFAULT '0' NOT NULL,
    bandate bigint(40) DEFAULT '0' NOT NULL,
    unbandate bigint(40) DEFAULT '0' NOT NULL,
    bannedby varchar(50) NOT NULL,
    banreason varchar(255) NOT NULL,
    active tinyint(4) DEFAULT '1' NOT NULL,
   PRIMARY KEY (id, bandate)
);#%%



DROP TABLE IF EXISTS forum_accounts;#%%
CREATE TABLE forum_accounts (
    id_account int(10) unsigned DEFAULT '0' NOT NULL,
    location varchar(2) DEFAULT '00' NOT NULL,
    showlocation tinyint(1) unsigned DEFAULT '0' NOT NULL,
    bday date DEFAULT '0000-00-00' NOT NULL,
    showbday tinyint(1) unsigned DEFAULT '0' NOT NULL,
    signature text,
    gmt varchar(6) DEFAULT '0:00' NOT NULL,
    webpage varchar(200),
    fname varchar(50),
    lname varchar(50),
    passask varchar(200),
    passans varchar(200),
    city varchar(50),
    aim varchar(200),
    msn varchar(200),
    yahoo varchar(200),
    skype varchar(200),
    icq varchar(200),
    enablepm tinyint(1) unsigned DEFAULT '0' NOT NULL,
    enableemail tinyint(1) unsigned DEFAULT '0' NOT NULL,
    template varchar(50),
    avatar varchar(50) DEFAULT 'nochar' NOT NULL,
    lastlogin datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    displayname varchar(25) NOT NULL,
    activation varchar(32),
    ismvp tinyint(1) unsigned DEFAULT '0' NOT NULL,
    gender tinyint(1) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (id_account)
);#%%

INSERT INTO forum_accounts VALUES ('1','00','0','0000-00-00','0',NULL,'0:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0',NULL,'nochar','2009-05-15 07:01:33','ADMINISTRATOR',NULL,'0','0');#%%
INSERT INTO forum_accounts VALUES ('2','00','0','0000-00-00','0',NULL,'0:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0',NULL,'nochar','0000-00-00 00:00:00','GAMEMASTER',NULL,'0','0');#%%
INSERT INTO forum_accounts VALUES ('3','00','0','0000-00-00','0',NULL,'0:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0',NULL,'nochar','0000-00-00 00:00:00','MODERATOR',NULL,'0','0');#%%
INSERT INTO forum_accounts VALUES ('4','00','0','0000-00-00','0',NULL,'0:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0','0',NULL,'nochar','0000-00-00 00:00:00','PLAYER',NULL,'0','0');#%%


DROP TABLE IF EXISTS forum_pm;#%%
CREATE TABLE forum_pm (
    id_pm int(10) unsigned NOT NULL auto_increment,
    id_account_to int(10) unsigned NOT NULL,
    message text,
    date date DEFAULT '0000-00-00' NOT NULL,
    hour time DEFAULT '00:00:00' NOT NULL,
    isread tinyint(1) unsigned DEFAULT '0' NOT NULL,
    id_account_from int(10) unsigned DEFAULT '0' NOT NULL,
    subject varchar(100),
    isdeleted int(10) unsigned DEFAULT '0' NOT NULL,
    issignature tinyint(1) unsigned DEFAULT '1' NOT NULL,
    isbbcode tinyint(1) unsigned DEFAULT '1' NOT NULL,
   PRIMARY KEY (id_pm, id_account_to, id_account_from, isdeleted)
);#%%

INSERT INTO forum_pm VALUES ('1','2','hellow','2009-05-13','06:28:00','0','1','hello','0','1','1');#%%


DROP TABLE IF EXISTS forum_posts;#%%
CREATE TABLE forum_posts (
    id_post int(10) unsigned NOT NULL auto_increment,
    id_topic int(10) unsigned NOT NULL,
    text text,
    isbbcode tinyint(1) unsigned DEFAULT '0' NOT NULL,
    issignature tinyint(1) unsigned DEFAULT '0' NOT NULL,
    id_account int(10) unsigned NOT NULL,
    date date DEFAULT '0000-00-00' NOT NULL,
    hour time DEFAULT '00:00:00' NOT NULL,
    isreply tinyint(1) unsigned DEFAULT '1' NOT NULL,
    id_account_edit int(10) unsigned DEFAULT '0' NOT NULL,
    date_edit date DEFAULT '0000-00-00' NOT NULL,
    hour_edit time DEFAULT '00:00:00' NOT NULL,
   PRIMARY KEY (id_post, id_topic, id_account)
);#%%

INSERT INTO forum_posts VALUES ('1','1','First make an account on our website then, set your realmlist.wtf (edit it with Notepad), located in your World of Warcraft root folder, to:

[community]set realmlist 0.0.0.0[/community]
[p]Login and have fun.

Thank You.[/p]','1','1','1','2009-05-13','06:24:13','0','0','0000-00-00','00:00:00');#%%
INSERT INTO forum_posts VALUES ('2','2','Welcome to %SITENAME%!
We hope you enjoy playing here.
Feel free to explore our Website.','1','1','1','2009-05-13','06:24:13','0','0','0000-00-00','00:00:00');#%%


DROP TABLE IF EXISTS forum_rel_account_polls;#%%
CREATE TABLE forum_rel_account_polls (
    id_poll int(10) unsigned NOT NULL,
    id_account int(10) unsigned NOT NULL,
   PRIMARY KEY (id_poll, id_account)
);#%%



DROP TABLE IF EXISTS forum_rel_topics_polls;#%%
CREATE TABLE forum_rel_topics_polls (
    id_poll int(10) unsigned NOT NULL auto_increment,
    id_topic int(10) unsigned NOT NULL,
    name varchar(45) NOT NULL,
   PRIMARY KEY (id_poll)
);#%%



DROP TABLE IF EXISTS forum_reports;#%%
CREATE TABLE forum_reports (
    id_report int(10) unsigned NOT NULL auto_increment,
    id_account int(10) unsigned DEFAULT '0' NOT NULL,
    id_post int(10) unsigned DEFAULT '0' NOT NULL,
    reason varchar(255) NOT NULL,
   PRIMARY KEY (id_report)
);#%%



DROP TABLE IF EXISTS forum_smiles;#%%
CREATE TABLE forum_smiles (
    id_smile varchar(7) NOT NULL,
    path varchar(255) NOT NULL,
   PRIMARY KEY (id_smile)
);#%%



DROP TABLE IF EXISTS forum_topics;#%%
CREATE TABLE forum_topics (
    id_topic int(10) unsigned NOT NULL auto_increment,
    viewlevel varchar(2) DEFAULT '-1' NOT NULL,
    postlevel varchar(2) DEFAULT '0' NOT NULL,
    title varchar(200),
    image varchar(40),
    views int(10) unsigned DEFAULT '0' NOT NULL,
    issticked tinyint(1) unsigned DEFAULT '0' NOT NULL,
    category tinyint(1) unsigned DEFAULT '0' NOT NULL,
    id_forum_moved int(10) unsigned DEFAULT '0' NOT NULL,
    poll_question varchar(45),
    poll_lasts tinyint(3) unsigned DEFAULT '0' NOT NULL,
    poll_stamp timestamp DEFAULT 'CURRENT_TIMESTAMP' NOT NULL,
    id_forum int(10) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (id_topic, id_forum_moved, id_forum)
);#%%

INSERT INTO forum_topics VALUES ('1','-1','1','How to connect to our Server?','','0','1','2','0','','0','2009-05-13 06:24:13','1');#%%
INSERT INTO forum_topics VALUES ('2','-1','1','Welcome!','news-alert.gif ','0','1','1','0','','0','2009-05-13 06:24:13','1');#%%


DROP TABLE IF EXISTS forum_views;#%%
CREATE TABLE forum_views (
    id_topic int(10) unsigned NOT NULL auto_increment,
    id_account varchar(45) NOT NULL,
    time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   PRIMARY KEY (id_topic, id_account)
);#%%



DROP TABLE IF EXISTS forums;#%%
CREATE TABLE forums (
    id_forum int(10) unsigned NOT NULL auto_increment,
    title varchar(45) NOT NULL,
    description varchar(255) NOT NULL,
    group tinyint(2) unsigned DEFAULT '0' NOT NULL,
    image varchar(50) DEFAULT 'bullet.gif' NOT NULL,
    viewlevel varchar(2) DEFAULT '-1' NOT NULL,
    postlevel varchar(2) DEFAULT '0' NOT NULL,
    ordenation int(10) unsigned DEFAULT '0' NOT NULL,
    categorized tinyint(1) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (id_forum)
);#%%

INSERT INTO forums VALUES ('1','Welcome to WoW- A Beginner’s Forum','New to the World of Warcraft? Ask questions from experienced players and learn more about the adventures that await you!','0','newplayers.gif','-1','0','0','0');#%%
INSERT INTO forums VALUES ('2','Realm Status','Collection of important messages regarding the status of the Realms.','3','serverstatus.gif','-1','0','1','0');#%%
INSERT INTO forums VALUES ('3','Customer Service Forum','Keeps us informed about spammers or any other abusive manners. And post bugs/problems here.','6','cs.gif','-1','0','2','0');#%%
INSERT INTO forums VALUES ('4','General Discussion','Discuss World of Warcraft.','0','general.gif','-1','0','3','0');#%%
INSERT INTO forums VALUES ('5','UI & Macros Forum','Work with other players to create your own special custom interfaces and macros.','0','uicustomizations.gif','-1','0','5','0');#%%
INSERT INTO forums VALUES ('7','Druid','','1','druid.gif','-1','0','7','1');#%%
INSERT INTO forums VALUES ('8','Suggestions','Have a suggestion for WeboW BL for Mangos? Please post it here. ','3','suggestions.gif','-1','0','6','0');#%%
INSERT INTO forums VALUES ('9','Proffesions','Discuss professions in detail.','0','professions.gif','-1','0','8','0');#%%
INSERT INTO forums VALUES ('10','PvP Discussion','Discuss player versus player combat.','5','pvp.gif','-1','0','9','0');#%%
INSERT INTO forums VALUES ('11','Realm Forums','Discuss topics related to World of Warcraft with players on your specific Realm.','3','realms.gif','-1','0','10','0');#%%
INSERT INTO forums VALUES ('12','Quests','Talk about and get help with the countless quests in World of Warcraft.','3','quests.gif','-1','0','11','0');#%%
INSERT INTO forums VALUES ('13','Off-topic Discussion','Off-topic posts of interest to the WeboW BL for Mangos community.','0','offtopic.gif','-1','0','12','0');#%%
INSERT INTO forums VALUES ('14','WeboW BL for Mangos Archive','A collection of important messages and announcements, including the extended forum guidelines.','6','blizzard.gif','-1','0','13','0');#%%
INSERT INTO forums VALUES ('15','Guild Recruitment','Searching for a guild, or do you want to advertise your guild?','4','guilds.gif','-1','0','14','0');#%%
INSERT INTO forums VALUES ('16','Role-Playing','Pull up a chair, drink a mug of ale, meet new friends, tell stories, and role-play in this forum.','3','roleplaying.gif','-1','0','15','0');#%%
INSERT INTO forums VALUES ('17','Guild Relations','Step in and share ideas and experiences on in-guild and inter-guild relationships.','4','guildrelations.gif','-1','0','16','0');#%%
INSERT INTO forums VALUES ('18','Raids & Dungeons','Share your victories and discuss tactics, encounters and group composition, and look to future challenges for your band of heroes.','4','dungeons.gif','-1','0','17','0');#%%
INSERT INTO forums VALUES ('20','Battlegroup Forums','Discuss your latest victories with your Battlegroup and show off your realm pride!','5','battlegroup.gif','-1','0','20','0');#%%
INSERT INTO forums VALUES ('21','Realm Status','Collection of important messages regarding the status of the Realms.!','5','serverstatus.gif','-1','0','20','0');#%%
INSERT INTO forums VALUES ('22','Guide Forum','Share your guides for classes, professions, leveling and more.','5','guides.gif','-1','0','20','0');#%%
INSERT INTO forums VALUES ('23','Bug Report Forum','Found a bug in the game or on our website? Help us squash it by reporting it here!','5','bugs.gif','-1','0','20','0');#%%
INSERT INTO forums VALUES ('24','Rogue','','1','rogue.gif','-1','0','21','1');#%%
INSERT INTO forums VALUES ('25','Priest','','1','priest.gif','-1','0','22','1');#%%
INSERT INTO forums VALUES ('26','Hunter','','1','hunter.gif','-1','0','23','1');#%%
INSERT INTO forums VALUES ('27','Shaman','','1','shaman.gif','-1','0','24','1');#%%
INSERT INTO forums VALUES ('28','Warrior','','1','warrior.gif','-1','0','25','1');#%%
INSERT INTO forums VALUES ('29','Mage','','1','mage.gif','-1','0','26','1');#%%
INSERT INTO forums VALUES ('30','Paladin','','1','paladin.gif','-1','0','27','1');#%%
INSERT INTO forums VALUES ('31','Warlock','','1','warlock.gif','-1','0','28','1');#%%


DROP TABLE IF EXISTS ip_banned;#%%
CREATE TABLE ip_banned (
    ip varchar(32) DEFAULT '127.0.0.1' NOT NULL,
    bandate bigint(40) NOT NULL,
    unbandate bigint(40) NOT NULL,
    bannedby varchar(50) DEFAULT '[Console]' NOT NULL,
    banreason varchar(255) DEFAULT 'no reason' NOT NULL,
   PRIMARY KEY (ip, bandate)
);#%%



DROP TABLE IF EXISTS realm_settings;#%%
CREATE TABLE realm_settings (
    id_realm int(10) unsigned NOT NULL,
    dbuser varchar(25) NOT NULL,
    dbpass varchar(25) NOT NULL,
    dbhost varchar(25) NOT NULL,
    dbport varchar(5) NOT NULL,
    dbname varchar(25) NOT NULL,
    uptime datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   PRIMARY KEY (id_realm)
);#%%

INSERT INTO realm_settings VALUES ('1','','','','','mangos','0000-00-00 00:00:00');#%%


DROP TABLE IF EXISTS realmcharacters;#%%
CREATE TABLE realmcharacters (
    realmid int(11) unsigned DEFAULT '0' NOT NULL,
    acctid bigint(20) unsigned NOT NULL,
    numchars tinyint(3) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (realmid, acctid)
);#%%



DROP TABLE IF EXISTS realmlist;#%%
CREATE TABLE realmlist (
    id int(11) unsigned NOT NULL auto_increment,
    name varchar(32) NOT NULL,
    address varchar(32) DEFAULT '127.0.0.1' NOT NULL,
    port int(11) DEFAULT '8085' NOT NULL,
    icon tinyint(3) unsigned DEFAULT '0' NOT NULL,
    color tinyint(3) unsigned DEFAULT '2' NOT NULL,
    timezone tinyint(3) unsigned DEFAULT '0' NOT NULL,
    allowedSecurityLevel tinyint(3) unsigned DEFAULT '0' NOT NULL,
    population float unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (id),
   UNIQUE idx_name (name)
);#%%

INSERT INTO realmlist VALUES ('1','MaNGOS','127.0.0.1','8085','1','0','1','0','0');#%%


DROP TABLE IF EXISTS web_donations;#%%
CREATE TABLE web_donations (
    id_donation int(10) unsigned NOT NULL auto_increment,
    id_account int(10) unsigned NOT NULL,
    value varchar(45) DEFAULT '0' NOT NULL,
    date date DEFAULT '0000-00-00' NOT NULL,
    hide tinyint(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (id_donation, id_account)
);#%%



DROP TABLE IF EXISTS web_misc;#%%
CREATE TABLE web_misc (
    id_misc int(11) NOT NULL auto_increment,
    title varchar(100),
    text varchar(200),
    urls text,
    image varchar(200),
   PRIMARY KEY (id_misc)
);#%%

INSERT INTO web_misc VALUES ('1','Pictures','Enjoy our Picture Galleries. Share yours with us aswell.','[url=?n=media.screenshots]Screenshots[/url]
[url=?n=media.wallpapers]Wallpapers[/url]
[url=?n=community.fanart]Fan Art[/url]','misc-image-bc.gif');#%%
INSERT INTO web_misc VALUES ('2','Challenges','Two different types where you must use your strategy or creativity.','[url=?n=community.contests]Contests[/url]
[url=?n=workshop.eventscalendar]Events Calendar[/url]','misc-icon-insider.gif');#%%


DROP TABLE IF EXISTS web_online;#%%
CREATE TABLE web_online (
    id int(10) unsigned DEFAULT '0' NOT NULL,
    page varchar(50) DEFAULT 'news.current' NOT NULL,
    time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    ip varchar(15) DEFAULT '0.0.0.0' NOT NULL,
    isguest tinyint(1) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (id, isguest)
);#%%

INSERT INTO web_online VALUES ('1','/index.php?n=error.maintenance','2009-05-15 07:03:47','127.0.0.1','0');#%%


DROP TABLE IF EXISTS web_settings;#%%
CREATE TABLE web_settings (
    setting varchar(25) NOT NULL,
    value text,
   UNIQUE Locked (setting)
);#%%

INSERT INTO web_settings VALUES ('email_main','admin@email.com');#%%
INSERT INTO web_settings VALUES ('email_host','');#%%
INSERT INTO web_settings VALUES ('email_password','');#%%
INSERT INTO web_settings VALUES ('email_port','');#%%
INSERT INTO web_settings VALUES ('email_username','');#%%
INSERT INTO web_settings VALUES ('email_ssl','0');#%%
INSERT INTO web_settings VALUES ('forum_enabled','1');#%%
INSERT INTO web_settings VALUES ('email_enabled','0');#%%
INSERT INTO web_settings VALUES ('web_gmt','0');#%%
INSERT INTO web_settings VALUES ('donations_enabled','0');#%%
INSERT INTO web_settings VALUES ('user_edit_own_posts','1');#%%
INSERT INTO web_settings VALUES ('user_enable_pm','0');#%%
INSERT INTO web_settings VALUES ('user_enable_signature','0');#%%
INSERT INTO web_settings VALUES ('user_reg_active','1');#%%
INSERT INTO web_settings VALUES ('user_remove_own_posts','1');#%%
INSERT INTO web_settings VALUES ('web_enable_modules','1');#%%
INSERT INTO web_settings VALUES ('web_show_community','1');#%%
INSERT INTO web_settings VALUES ('web_show_contests','1');#%%
INSERT INTO web_settings VALUES ('web_show_donations','1');#%%
INSERT INTO web_settings VALUES ('web_show_fanart','1');#%%
INSERT INTO web_settings VALUES ('web_show_flash','1');#%%
INSERT INTO web_settings VALUES ('web_show_jobs','1');#%%
INSERT INTO web_settings VALUES ('web_show_misc','1');#%%
INSERT INTO web_settings VALUES ('web_show_news','1');#%%
INSERT INTO web_settings VALUES ('web_show_support','1');#%%
INSERT INTO web_settings VALUES ('web_show_wallpapers','1');#%%
INSERT INTO web_settings VALUES ('user_accounts','2');#%%
INSERT INTO web_settings VALUES ('user_enable_email','1');#%%
INSERT INTO web_settings VALUES ('user_misc','2');#%%
INSERT INTO web_settings VALUES ('user_reg_mail','0');#%%
INSERT INTO web_settings VALUES ('user_poll','0');#%%
INSERT INTO web_settings VALUES ('donations_day_start','0000-00-00');#%%
INSERT INTO web_settings VALUES ('donations_day_end','0000-00-00');#%%
INSERT INTO web_settings VALUES ('user_donations','0');#%%
INSERT INTO web_settings VALUES ('user_email','3');#%%
INSERT INTO web_settings VALUES ('user_forums','2');#%%
INSERT INTO web_settings VALUES ('user_web','2');#%%
INSERT INTO web_settings VALUES ('donations_needed_value','100');#%%
INSERT INTO web_settings VALUES ('donations_pay_obj','');#%%
INSERT INTO web_settings VALUES ('donations_currency','€');#%%
INSERT INTO web_settings VALUES ('web_flash_url','new-hp/flash/loader.swf');#%%
INSERT INTO web_settings VALUES ('web_location','');#%%
INSERT INTO web_settings VALUES ('web_site_name','WeboW BL for Mangos');#%%
INSERT INTO web_settings VALUES ('web_def_template','Wrath_of_the_Lich_King');#%%
INSERT INTO web_settings VALUES ('db_restore','4');#%%
INSERT INTO web_settings VALUES ('db_backup','2');#%%
INSERT INTO web_settings VALUES ('server_owner','1');#%%


# Valid end of backup from MySql PHP Backup

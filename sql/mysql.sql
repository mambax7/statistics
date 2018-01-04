#
# Table structure for table `counter`
#

CREATE TABLE `counter` (
  `type`  VARCHAR(80)      NOT NULL DEFAULT '',
  `var`   VARCHAR(80)      NOT NULL DEFAULT '',
  `count` INT(10) UNSIGNED NOT NULL DEFAULT '0'
)
  ENGINE = MyISAM;

#
# Dumping data for table `counter`
#

INSERT INTO `counter` VALUES ('total', 'hits', 0);
INSERT INTO `counter` VALUES ('browser', 'WebTV', 0);
INSERT INTO `counter` VALUES ('browser', 'Lynx', 0);
INSERT INTO `counter` VALUES ('browser', 'MSIE', 0);
INSERT INTO `counter` VALUES ('browser', 'Opera', 0);
INSERT INTO `counter` VALUES ('browser', 'Konqueror', 0);
INSERT INTO `counter` VALUES ('browser', 'Netscape', 0);
INSERT INTO `counter` VALUES ('browser', 'Deepnet', 0);
INSERT INTO `counter` VALUES ('browser', 'Avant', 0);
INSERT INTO `counter` VALUES ('browser', 'Bot', 0);
INSERT INTO `counter` VALUES ('browser', 'Other', 0);
INSERT INTO `counter` VALUES ('os', 'Windows', 0);
INSERT INTO `counter` VALUES ('os', 'Linux', 0);
INSERT INTO `counter` VALUES ('os', 'Mac', 0);
INSERT INTO `counter` VALUES ('os', 'FreeBSD', 0);
INSERT INTO `counter` VALUES ('os', 'SunOS', 0);
INSERT INTO `counter` VALUES ('os', 'IRIX', 0);
INSERT INTO `counter` VALUES ('os', 'BeOS', 0);
INSERT INTO `counter` VALUES ('os', 'OS/2', 0);
INSERT INTO `counter` VALUES ('os', 'AIX', 0);
INSERT INTO `counter` VALUES ('os', 'Other', 0);
INSERT INTO `counter` VALUES ('browser', 'AppleWeb', 0);
INSERT INTO `counter` VALUES ('browser', 'Firefox', 0);
INSERT INTO `counter` VALUES ('browser', 'Mozilla', 0);
INSERT INTO `counter` VALUES ('totalblocked', 'hits', 0);
INSERT INTO `counter` VALUES ('blocked', 'bots', 0);
INSERT INTO `counter` VALUES ('blocked', 'referers', 0);

#
# Table structure for table `stats_date`
#

CREATE TABLE `stats_date` (
  `year`  SMALLINT(6) NOT NULL DEFAULT '0',
  `month` TINYINT(4)  NOT NULL DEFAULT '0',
  `date`  TINYINT(4)  NOT NULL DEFAULT '0',
  `hits`  BIGINT(20)  NOT NULL DEFAULT '0'
)
  ENGINE = MyISAM;

#
# Table structure for table `stats_hour`
#

CREATE TABLE `stats_hour` (
  `year`  SMALLINT(6) NOT NULL DEFAULT '0',
  `month` TINYINT(4)  NOT NULL DEFAULT '0',
  `date`  TINYINT(4)  NOT NULL DEFAULT '0',
  `hour`  TINYINT(4)  NOT NULL DEFAULT '0',
  `hits`  INT(11)     NOT NULL DEFAULT '0'
)
  ENGINE = MyISAM;

#
# Table structure for table `stats_month`
#

CREATE TABLE `stats_month` (
  `year`  SMALLINT(6) NOT NULL DEFAULT '0',
  `month` TINYINT(4)  NOT NULL DEFAULT '0',
  `hits`  BIGINT(20)  NOT NULL DEFAULT '0'
)
  ENGINE = MyISAM;

#
# Table structure for table `stats_year`
#

CREATE TABLE `stats_year` (
  `year` SMALLINT(6) NOT NULL DEFAULT '0',
  `hits` BIGINT(20)  NOT NULL DEFAULT '0'
)
  ENGINE = MyISAM;

#
# Table structure for table `stats_ip`
#

CREATE TABLE `stats_ip` (
  `id`   INT(11)      NOT NULL AUTO_INCREMENT,
  `ip`   VARCHAR(150) NOT NULL,
  `date` VARCHAR(150) NOT NULL,
  `hits` BIGINT(20)   NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM;

#
# Table structure for table `stats_refer`
#

CREATE TABLE `stats_refer` (
  `id`        INT(11)      NOT NULL AUTO_INCREMENT,
  `ip`        VARCHAR(20)  NOT NULL,
  `refer`     VARCHAR(150) NOT NULL,
  `date`      VARCHAR(150) NOT NULL,
  `hits`      BIGINT(20)   NOT NULL DEFAULT '0',
  `referpath` VARCHAR(150) NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE = MyISAM;

CREATE TABLE `stats_refer_blacklist` (
  `id`      INT(3) NOT NULL AUTO_INCREMENT,
  `referer` TEXT   NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE = MyISAM;

INSERT INTO `stats_refer_blacklist` VALUES (1,
                                            'a:68:{i:0;s:15:"allnetgoods.com";i:1;s:23:"100-online-gambling.com";i:2;s:8:"amkf.com";i:3;s:18:"keytomarketing.com";i:4;s:26:"dental-insurance-plan.info";i:5;s:9:"paint.com";i:6;s:6:"7h.com";i:7;s:7:"dad.com";i:8;s:15:"bigsitecity.com";i:9;s:8:"ds4a.com";i:10;s:7:"9cy.com";i:11;s:10:"palajo.com";i:12;s:9:"imals.com";i:13;s:15:"bigsitecity.com";i:14;s:8:"hamj.com";i:15;s:9:"iemkt.com";i:16;s:11:"sidelog.com";i:17;s:8:"zuvl.com";i:18;s:9:"dfing.com";i:19;s:10:"gasvac.com";i:20;s:10:"gasvac.net";i:21;s:9:"lojka.com";i:22;s:9:"aubek.com";i:23;s:12:"maclenet.com";i:24;s:15:"gay[A-Za-z0-9]*";i:25;s:9:"jsvan.com";i:26;s:11:"tellima.com";i:27;s:7:"jixx.de";i:28;s:17:"detox[A-Za-z0-9]*";i:29;s:16:"drug[A-Za-z0-9]*";i:30;s:15:"buy[A-Za-z0-9]*";i:31;s:15:"ass[A-Za-z0-9]*";i:32;s:7:"move.to";i:33;s:13:"fullspeed.com";i:34;s:18:"viagra[A-Za-z0-9]*";i:35;s:14:"givemepink.com";i:36;s:17:"sperm[A-Za-z0-9]*";i:37;s:16:"fuck[A-Za-z0-9]*";i:38;s:11:"shemale.com";i:39;s:16:"cock[A-Za-z0-9]*";i:40;s:7:"jixx.de";i:41;s:16:"plugherholes.com";i:42;s:18:"hentai[A-Za-z0-9]*";i:43;s:9:"pagina.de";i:44;s:19:"shemale[A-Za-z0-9]*";i:45;s:17:"bitch[A-Za-z0-9]*";i:46;s:19:"bondage[A-Za-z0-9]*";i:47;s:19:"blowjob[A-Za-z0-9]*";i:48;s:17:"semen[A-Za-z0-9]*";i:49;s:15:"cum[A-Za-z0-9]*";i:50;s:19:"bondage[A-Za-z0-9]*";i:51;s:7:"3333.ws";i:52;s:15:"ebony-white.com";i:53;s:19:"thebest[A-Za-z0-9]*";i:54;s:17:"nice-[A-Za-z0-9]*";i:55;s:15:"ime[A-Za-z0-9]*";i:56;s:14:"bjsandwich.com";i:57;s:16:"bdsm[A-Za-z0-9]*";i:58;s:17:"gooey[A-Za-z0-9]*";i:59;s:11:"21ebony.com";i:60;s:6:"olo.cc";i:61;s:18:"18inch[A-Za-z0-9]*";i:62;s:23:"allinternal[A-Za-z0-9]*";i:63;s:25:"furniturefind[A-Za-z0-9]*";i:64;s:17:"poker[A-Za-z0-9]*";i:65;s:7:"2rx.biz";i:66;s:7:"0me.com";i:67;s:15:"ads[A-Za-z0-9]*";}');

CREATE TABLE `stats_userscreen`
(
  `id`   INT(1) NOT NULL,
  `hits` INT(5) NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE = MyISAM;

INSERT INTO `stats_userscreen` VALUES (1, 0);
INSERT INTO `stats_userscreen` VALUES (2, 0);
INSERT INTO `stats_userscreen` VALUES (3, 0);
INSERT INTO `stats_userscreen` VALUES (4, 0);
INSERT INTO `stats_userscreen` VALUES (5, 0);
INSERT INTO `stats_userscreen` VALUES (6, 0);
INSERT INTO `stats_userscreen` VALUES (7, 0);

CREATE TABLE `stats_usercolor`
(
  `id`   INT(1) NOT NULL,
  `hits` INT(5) NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE = MyISAM;

INSERT INTO `stats_usercolor` VALUES (1, 0);
INSERT INTO `stats_usercolor` VALUES (2, 0);
INSERT INTO `stats_usercolor` VALUES (3, 0);
INSERT INTO `stats_usercolor` VALUES (4, 0);
INSERT INTO `stats_usercolor` VALUES (5, 0);

CREATE TABLE `stats_blockedyear` (
  `year` SMALLINT(6) NOT NULL DEFAULT '0',
  `hits` BIGINT(20)  NOT NULL DEFAULT '0'
)
  ENGINE = MyISAM;

CREATE TABLE `stats_blockedmonth` (
  `year`  SMALLINT(6) NOT NULL DEFAULT '0',
  `month` TINYINT(4)  NOT NULL DEFAULT '0',
  `hits`  BIGINT(20)  NOT NULL DEFAULT '0'
)
  ENGINE = MyISAM;

CREATE TABLE `stats_blockeddate` (
  `year`  SMALLINT(6) NOT NULL DEFAULT '0',
  `month` TINYINT(4)  NOT NULL DEFAULT '0',
  `date`  TINYINT(4)  NOT NULL DEFAULT '0',
  `hits`  BIGINT(20)  NOT NULL DEFAULT '0'
)
  ENGINE = MyISAM;

CREATE TABLE `stats_blockedhour` (
  `year`  SMALLINT(6) NOT NULL DEFAULT '0',
  `month` TINYINT(4)  NOT NULL DEFAULT '0',
  `date`  TINYINT(4)  NOT NULL DEFAULT '0',
  `hour`  TINYINT(4)  NOT NULL DEFAULT '0',
  `hits`  INT(11)     NOT NULL DEFAULT '0'
)
  ENGINE = MyISAM;


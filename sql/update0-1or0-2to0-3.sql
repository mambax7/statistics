# FROM ANY version 0.1 OR 0.2 TO version 0.45

CREATE TABLE `xoops_stats_refer_blacklist` (
  `id`      INT(3)       NOT NULL AUTO_INCREMENT,
  `referer` VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE = MyISAM;
#
# Table structure for table `xoops_stats_refer`
#

ALTER TABLE `xoops_stats_refer`
  ADD `referpath` VARCHAR(150) NOT NULL;

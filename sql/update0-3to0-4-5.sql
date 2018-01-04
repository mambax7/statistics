# FROM ANY version 0.3 TO version 0.45

CREATE TABLE `xoops_stats_userscreen`
(
  `id`   INT(1) NOT NULL,
  `hits` INT(5) NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE = MyISAM;

INSERT INTO `xoops_stats_userscreen` VALUES (1, 0);
INSERT INTO `xoops_stats_userscreen` VALUES (2, 0);
INSERT INTO `xoops_stats_userscreen` VALUES (3, 0);
INSERT INTO `xoops_stats_userscreen` VALUES (4, 0);
INSERT INTO `xoops_stats_userscreen` VALUES (5, 0);
INSERT INTO `xoops_stats_userscreen` VALUES (6, 0);
INSERT INTO `xoops_stats_userscreen` VALUES (7, 0);

CREATE TABLE `xoops_stats_usercolor`
(
  `id`   INT(1) NOT NULL,
  `hits` INT(5) NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE = MyISAM;

INSERT INTO `xoops_stats_usercolor` VALUES (1, 0);
INSERT INTO `xoops_stats_usercolor` VALUES (2, 0);
INSERT INTO `xoops_stats_usercolor` VALUES (3, 0);
INSERT INTO `xoops_stats_usercolor` VALUES (4, 0);
INSERT INTO `xoops_stats_usercolor` VALUES (5, 0);

INSERT INTO `xoops_counter` VALUES ('browser', 'Deepnet', 0);
INSERT INTO `xoops_counter` VALUES ('browser', 'Avant', 0);

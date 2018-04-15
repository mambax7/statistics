<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright      {@link https://xoops.org/ XOOPS Project}
 * @license        {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package
 * @since
 * @author         XOOPS Development Team
 */

require_once  dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
xoops_cp_header();

function TableExists($tablename)
{
    global $xoopsDB;
    $result = $xoopsDB->queryF("SHOW TABLES LIKE '$tablename'");

    return ($xoopsDB->getRowsNum($result) > 0);
}

function FieldExists($fieldname, $table)
{
    global $xoopsDB;
    $result = $xoopsDB->queryF("SHOW COLUMNS FROM $table LIKE '$fieldname'");

    return ($xoopsDB->getRowsNum($result) > 0);
}

function AddField($field, $table)
{
    global $xoopsDB;
    $result = $xoopsDB->queryF('ALTER TABLE ' . $table . " ADD $field;");

    return $result;
}

if (is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid())) {
    $errors  = 0;
    $warning = 0;
    // 1) Create, if it does not exists
    if (!TableExists($xoopsDB->prefix('stats_refer_blacklist'))) {
        $sql = 'CREATE TABLE ' . $xoopsDB->prefix('stats_refer_blacklist') . '  (
                `id` INT( 3 ) NOT NULL AUTO_INCREMENT ,
                `referer` VARCHAR( 255 ) NOT NULL,
                PRIMARY KEY (id)
               ) ENGINE=MyISAM';

        if (!$xoopsDB->queryF($sql)) {
            echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED1;
            ++$errors;
        }
    } else {
        $sql = 'TRUNCATE TABLE ' . $xoopsDB->prefix('stats_refer_blacklist');

        if (!$xoopsDB->queryF($sql)) {
            echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED10;
            ++$errors;
        } else {
            $sql = 'INSERT INTO '
                   . $xoopsDB->prefix('stats_refer_blacklist')
                   . " VALUES (1, 'a:101:{i:0;s:11:\"bergvall.nu\";i:1;"
                   . 's:15:"allnetgoods.com";i:2;s:23:"100-online-gambling.com";i:3;s:8:"amkf.com";i:4;s:18:"keytomarketing.com";i:5;s'
                   . ':18:"dental[A-Za-z0-9]*";i:6;s:9:"paint.com";i:7;s:6:"7h.com";i:8;s:7:"dad.com";i:9;s:8:"ds4a.com";i:10;s'
                   . ':7:"9cy.com";i:11;s:10:"palajo.com";i:12;s:9:"imals.com";i:13;s:15:"bigsitecity.com";i:14;s:8:"hamj.com";i:15;s'
                   . ':9:"iemkt.com";i:16;s:11:"sidelog.com";i:17;s:8:"zuvl.com";i:18;s:9:"dfing.com";i:19;s:10:"gasvac.com";i:20;s'
                   . ':10:"gasvac.net";i:21;s:9:"lojka.com";i:22;s:9:"aubek.com";i:23;s:12:"maclenet.com";i:24;s:15:"gay[A-Za-z0-9]*";i:25;s'
                   . ':9:"jsvan.com";i:26;s:11:"tellima.com";i:27;s:7:"jixx.de";i:28;s:17:"detox[A-Za-z0-9]*";i:29;s:16'
                   . ':"drug[A-Za-z0-9]*";i:30;s:15:"buy[A-Za-z0-9]*";i:31;s:15:"ass[A-Za-z0-9]*";i:32;s:7:"move.to";i:33;s:13'
                   . ':"fullspeed.com";i:34;s:18:"viagra[A-Za-z0-9]*";i:35;s:14:"givemepink.com";i:36;s:17:"sperm[A-Za-z0-9]*";i:37;s:16'
                   . ':"fuck[A-Za-z0-9]*";i:38;s:11:"shemale.com";i:39;s:16:"cock[A-Za-z0-9]*";i:40;s:7:"jixx.de";i:41;s:16'
                   . ':"plugherholes.com";i:42;s:18:"hentai[A-Za-z0-9]*";i:43;s:9:"pagina.de";i:44;s:19:"shemale[A-Za-z0-9]*";i:45;s:17'
                   . ':"bitch[A-Za-z0-9]*";i:46;s:19:"bondage[A-Za-z0-9]*";i:47;s:19:"blowjob[A-Za-z0-9]*";i:48;s:17:"semen[A-Za-z0-9]*";i:49;s:15'
                   . ':"cum[A-Za-z0-9]*";i:50;s:19:"bondage[A-Za-z0-9]*";i:51;s:7:"3333.ws";i:52;s:15:"ebony-white.com";i:53;s:19'
                   . ':"thebest[A-Za-z0-9]*";i:54;s:17:"nice-[A-Za-z0-9]*";i:55;s:15:"ime[A-Za-z0-9]*";i:56;s:14:"bjsandwich.com";i:57;s'
                   . ':16:"bdsm[A-Za-z0-9]*";i:58;s:17:"gooey[A-Za-z0-9]*";i:59;s:11:"21ebony.com";i:60;s:6:"olo.cc";i:61;s:18'
                   . ':"18inch[A-Za-z0-9]*";i:62;s:23:"allinternal[A-Za-z0-9]*";i:63;s:25:"furniturefind[A-Za-z0-9]*";i:64;s:17'
                   . ':"poker[A-Za-z0-9]*";i:65;s:7:"2rx.biz";i:66;s:7:"0me.com";i:67;s:15:"ads[A-Za-z0-9]*";i:68;s:16:"diet[A-Za-z0-9]*";i'
                   . ':69;s:20:"ringtone[A-Za-z0-9]*";i:70;s:8:"a1a1.com";i:71;s:8:"b1b1.com";i:72;s:16:"shit[A-Za-z0-9]*";i:73;s:15'
                   . ':"sex[A-Za-z0-9]*";i:74;s:16:"porn[A-Za-z0-9]*";i:75;s:18:"ambien[A-Za-z0-9]*";i:76;s:6:"get.to";i:77;s:17'
                   . ':"xanax[A-Za-z0-9]*";i:78;s:19:"vicodin[A-Za-z0-9]*";i:79;s:22:"alprazolam[A-Za-z0-9]*";i:80;s:5:"go.to";i:81;s:15'
                   . ':"circleofsex.net";i:82;s:20:"fioricet[A-Za-z0-9]*";i:83;s:23:"phentermine[A-Za-z0-9]*";i:84;s:7:"come.to";i:85;s'
                   . ':7:"drop.to";i:86;s:9:"mysite.de";i:87;s:23:"hydrocodone[A-Za-z0-9]*";i:88;s:6:"hey.to";i:89;s:18'
                   . ':"cialis[A-Za-z0-9]*";i:90;s:23:"bikinibabes[A-Za-z0-9]*";i:91;s:19:"wrongsideoftown.com";i:92;s:8:"babes.tv";i:93'
                   . ';s:6:"v3.com";i:94;s:16:"myphotoalbum.com";i:95;s:12:"hotgames.com";i:96;s:14:"myblogsite.com";i:97;s:15'
                   . ":\"fortunecity.com\";i:98;s:14:\"dreambabes.com\";i:99;s:6:\"lol.to\";i:100;s:8:\"blogs.it\";}')";

            if (!$xoopsDB->queryF($sql)) {
                echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED11;
                ++$errors;
            }
        }
    }

    if (!TableExists($xoopsDB->prefix('stats_userscreen'))) {
        $sql = 'CREATE TABLE ' . $xoopsDB->prefix('stats_userscreen') . ' (
               `id` INT( 1 ) NOT NULL,
               `hits` INT( 5 ) NOT NULL,
               PRIMARY KEY (id)
              ) ENGINE=MyISAM';

        if (!$xoopsDB->queryF($sql)) {
            echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED3;
            ++$errors;
        } else {
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (1, 0)');
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (2, 0)');
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (3, 0)');
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (4, 0)');
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (5, 0)');
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (6, 0)');
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (7, 0)');
        }
    }

    if (!TableExists($xoopsDB->prefix('stats_usercolor'))) {
        $sql = 'CREATE TABLE ' . $xoopsDB->prefix('stats_usercolor') . ' (
               `id` INT( 1 ) NOT NULL,
               `hits` INT( 5 ) NOT NULL,
               PRIMARY KEY (id)
              ) ENGINE=MyISAM';

        if (!$xoopsDB->queryF($sql)) {
            echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED4;
            ++$errors;
        } else {
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_usercolor') . ' VALUES (1, 0)');
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_usercolor') . ' VALUES (2, 0)');
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_usercolor') . ' VALUES (3, 0)');
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_usercolor') . ' VALUES (4, 0)');
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_usercolor') . ' VALUES (5, 0)');
        }
    }

    if (!TableExists($xoopsDB->prefix('stats_blockedyear'))) {
        $sql = 'CREATE TABLE ' . $xoopsDB->prefix('stats_blockedyear') . " (
               `year` SMALLINT(6) NOT NULL DEFAULT '0',
               `hits` BIGINT(20) NOT NULL DEFAULT '0'
              ) ENGINE=MyISAM";

        if (!$xoopsDB->queryF($sql)) {
            echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED6;
            ++$errors;
        }
    }

    if (!TableExists($xoopsDB->prefix('stats_blockedmonth'))) {
        $sql = 'CREATE TABLE ' . $xoopsDB->prefix('stats_blockedmonth') . " (
               `year` SMALLINT(6) NOT NULL DEFAULT '0',
               `month` TINYINT(4) NOT NULL DEFAULT '0',
               `hits` BIGINT(20) NOT NULL DEFAULT '0'
               ) ENGINE=MyISAM";

        if (!$xoopsDB->queryF($sql)) {
            echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED7;
            ++$errors;
        }
    }

    if (!TableExists($xoopsDB->prefix('stats_blockeddate'))) {
        $sql = 'CREATE TABLE ' . $xoopsDB->prefix('stats_blockeddate') . " (
               `year` SMALLINT(6) NOT NULL DEFAULT '0',
               `month` TINYINT(4) NOT NULL DEFAULT '0',
               `date` TINYINT(4) NOT NULL DEFAULT '0',
               `hits` BIGINT(20) NOT NULL DEFAULT '0'
               ) ENGINE=MyISAM";

        if (!$xoopsDB->queryF($sql)) {
            echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED8;
            ++$errors;
        }
    }

    if (!TableExists($xoopsDB->prefix('stats_blockedhour'))) {
        $sql = 'CREATE TABLE ' . $xoopsDB->prefix('stats_blockedhour') . " (
               `year` SMALLINT(6) NOT NULL DEFAULT '0',
               `month` TINYINT(4) NOT NULL DEFAULT '0',
               `date` TINYINT(4) NOT NULL DEFAULT '0',
               `hour` TINYINT(4) NOT NULL DEFAULT '0',
               `hits` INT(11) NOT NULL DEFAULT '0'
               ) ENGINE=MyISAM";

        if (!$xoopsDB->queryF($sql)) {
            echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED9;
            ++$errors;
        }
    }

    // 2) Change some fields
    if (!FieldExists('referpath', $xoopsDB->prefix('stats_refer'))) {
        $sql    = 'ALTER TABLE ' . $xoopsDB->prefix('stats_refer') . ' ADD `referpath` VARCHAR(150) NOT NULL';
        $result = $xoopsDB->queryF($sql);
        if (!$result) {
            echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED2;
            ++$warning;
        }
    }

    $sql    = 'INSERT INTO ' . $xoopsDB->prefix('counter') . " VALUES ('browser', 'Deepnet', 0)";
    $result = $xoopsDB->queryF($sql);
    if (!$result) {
        echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED5;
        ++$errors;
    }
    $sql    = 'INSERT INTO ' . $xoopsDB->prefix('counter') . " VALUES ('browser', 'Avant', 0)";
    $result = $xoopsDB->queryF($sql);
    if (!$result) {
        echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED5;
        ++$errors;
    }
    $sql    = 'INSERT INTO ' . $xoopsDB->prefix('counter') . " VALUES ('totalblocked', 'hits', 0 )";
    $result = $xoopsDB->queryF($sql);
    if (!$result) {
        echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED5;
        ++$errors;
    }
    $sql    = 'INSERT INTO ' . $xoopsDB->prefix('counter') . " VALUES ('blocked', 'bots', 0)";
    $result = $xoopsDB->queryF($sql);
    if (!$result) {
        echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED5;
        ++$errors;
    }
    $sql    = 'INSERT INTO ' . $xoopsDB->prefix('counter') . " VALUES ('blocked', 'referers', 0)";
    $result = $xoopsDB->queryF($sql);
    if (!$result) {
        echo '<br>' . _STATS_UPGRADEFAILED . ' ' . _STATS_UPGRADEFAILED5;
        ++$errors;
    }

    if (!FieldExists('ip', $xoopsDB->prefix('stats_refer'))) {
        AddField("'ip' VARCHAR(20) NOT NULL", $xoopsDB->prefix('stats_refer'));
    }

    // At the end, if there was errors, show them or redirect user to the module's upgrade page
    if ($errors) {
        echo '<H1>' . _STATS_UPGRADEFAILED . '</H1>';
        echo '<br>' . _STATS_UPGRADEFAILED0;
    } elseif ($warning) {
        echo '<H1>' . _STATS_UPGRADEFAILEDWWARN . '</H1>';
        echo '<br>' . _STATS_UPGRADECOMPLETEWITHWARN;
    } else {
        echo _STATS_UPGRADECOMPLETE . " - <a href='" . XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module=statistics'>" . _AM_NEWS_UPDATEMODULE . '</a>';
    }
} else {
    printf("<H2>%s</H2>\n", _STATS_UPGR_ACCESS_ERROR);
}
xoops_cp_footer();

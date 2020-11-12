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
 * @license        {@link https://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package
 * @since
 * @author         XOOPS Development Team
 */
require_once dirname(dirname(__DIR__)) . '/mainfile.php';
$GLOBALS['xoopsOption']['template_main'] = 'statistics.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

function mainStats()
{
    global $xoopsDB, $xoopsTpl;
    $count  = 0;
    $result = $xoopsDB->queryF('SELECT type, var, count FROM ' . $xoopsDB->prefix('counter') . " WHERE type='total' AND var='hits'");
    [$type, $var, $count] = $xoopsDB->fetchRow($result);
    $total = $count;

    $count  = 0;
    $result = $xoopsDB->queryF('SELECT type, var, count FROM ' . $xoopsDB->prefix('counter') . " WHERE type='totalblocked' AND var='hits'");
    [$type, $var, $count] = $xoopsDB->fetchRow($result);
    $totalblocked = $count;

    $result = $xoopsDB->queryF('SELECT type, var, count FROM ' . $xoopsDB->prefix('counter') . ' ORDER BY type DESC');
    while (list($type, $var, $count) = $xoopsDB->fetchRow($result)) {
        if ('browser' === $type) {
            if ('Netscape' === $var) {
                $netscape[] = $count;
                $percent    = (0 == $total ? 0 : $count / $total);
                $netscape[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('MSIE' === $var) {
                $msie[]  = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $msie[]  = mb_substr(100 * $percent, 0, 5);
            } elseif ('Konqueror' === $var) {
                $konqueror[] = $count;
                $percent     = (0 == $total ? 0 : $count / $total);
                $konqueror[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('Opera' === $var) {
                $opera[] = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $opera[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('Lynx' === $var) {
                $lynx[]  = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $lynx[]  = mb_substr(100 * $percent, 0, 5);
            } elseif ('Bot' === $var) {
                $bot[]   = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $bot[]   = mb_substr(100 * $percent, 0, 5);
            } elseif ('AppleWeb' === $var) {
                $apple[] = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $apple[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('Firefox' === $var) {
                $firefox[] = $count;
                $percent   = (0 == $total ? 0 : $count / $total);
                $firefox[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('Mozilla' === $var) {
                $mozilla[] = $count;
                $percent   = (0 == $total ? 0 : $count / $total);
                $mozilla[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('Deepnet' === $var) {
                $deepnet[] = $count;
                $percent   = (0 == $total ? 0 : $count / $total);
                $deepnet[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('Avant' === $var) {
                $avant[] = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $avant[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('Other' === $var) {
                $b_other[] = $count;
                $percent   = (0 == $total ? 0 : $count / $total);
                $b_other[] = mb_substr(100 * $percent, 0, 5);
            }
        } elseif ('os' === $type) {
            if ('Windows' === $var) {
                $windows[] = $count;
                $percent   = (0 == $total ? 0 : $count / $total);
                $windows[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('Mac' === $var) {
                $mac[]   = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $mac[]   = mb_substr(100 * $percent, 0, 5);
            } elseif ('Linux' === $var) {
                $linux[] = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $linux[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('FreeBSD' === $var) {
                $freebsd[] = $count;
                $percent   = (0 == $total ? 0 : $count / $total);
                $freebsd[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('SunOS' === $var) {
                $sunos[] = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $sunos[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('IRIX' === $var) {
                $irix[]  = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $irix[]  = mb_substr(100 * $percent, 0, 5);
            } elseif ('BeOS' === $var) {
                $beos[]  = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $beos[]  = mb_substr(100 * $percent, 0, 5);
            } elseif ('OS/2' === $var) {
                $os2[]   = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $os2[]   = mb_substr(100 * $percent, 0, 5);
            } elseif ('AIX' === $var) {
                $aix[]   = $count;
                $percent = (0 == $total ? 0 : $count / $total);
                $aix[]   = mb_substr(100 * $percent, 0, 5);
            } elseif ('Other' === $var) {
                $os_other[] = $count;
                $percent    = (0 == $total ? 0 : $count / $total);
                $os_other[] = mb_substr(100 * $percent, 0, 5);
            }
        } elseif ('blocked' === $type) {
            if ('bots' === $var) {
                $blockedbots[] = $count;
                $percent       = (0 == $totalblocked ? 0 : $count / $totalblocked);
                $blockedbots[] = mb_substr(100 * $percent, 0, 5);
            } elseif ('referers' === $var) {
                $blockedreferers[] = $count;
                $percent           = (0 == $totalblocked ? 0 : $count / $totalblocked);
                $blockedreferers[] = mb_substr(100 * $percent, 0, 5);
            }
        }
    }

    $l_size = getimagesize('assets/images/leftbar.gif');
    $m_size = getimagesize('assets/images/mainbar.gif');
    $r_size = getimagesize('assets/images/rightbar.gif');

    $xoopsTpl->assign('lang_stat_heading', STATS_HEADING);

    $result   = $xoopsDB->queryF('SELECT year, hits FROM ' . $xoopsDB->prefix('stats_year'));
    $yearhits = [];
    $i        = 0;
    while (list($year, $hits) = $xoopsDB->fetchRow($result)) {
        $yearhits[$i]['year'] = $year;
        $yearhits[$i]['hits'] = $hits;
        ++$i;
    }
    $xoopsTpl->assign('yearhits', $yearhits);
    $xoopsTpl->assign('lang_stats_yearhits', STATS_YEARHITS);

    $result    = $xoopsDB->queryF('SELECT year, hits FROM ' . $xoopsDB->prefix('stats_blockedyear'));
    $byearhits = [];
    $i         = 0;
    while (list($year, $hits) = $xoopsDB->fetchRow($result)) {
        $byearhits[$i]['year'] = $year;
        $byearhits[$i]['hits'] = $hits;
        ++$i;
    }
    $xoopsTpl->assign('byearhits', $byearhits);
    $xoopsTpl->assign('lang_stats_byearhits', STATS_BYEARHITS);

    $xoopsTpl->assign('lang_stat_browser', STATS_BROWSERS);
    $xoopsTpl->assign('lang_stat_thissite', $_SERVER['HTTP_HOST']);
    $xoopsTpl->assign('lang_stat_useragent', $_SERVER['HTTP_USER_AGENT']);
    $xoopsTpl->assign('lang_stat_uahead', STATS_USER_AGENT);
    $xoopsTpl->assign(
        'lang_stat_msie',
        "<tr><td><img src=\"assets/images/explorer.gif\" border=\"0\" alt=\"\">MSIE:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Internet Explorer\"><img src=\"assets/images/mainbar.gif\" Alt=\"Internet Explorer\" height=\"$m_size[1]\" width=\"$msie[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Internet Explorer\">$msie[1] % ($msie[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_netscape',
        "<tr><td><img src=\"assets/images/netscape.gif\" border=\"0\" alt=\"\">Netscape:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Netscape\"><img src=\"assets/images/mainbar.gif\" Alt=\"Netscape\" height=\"$m_size[1]\" width=\"$netscape[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Netscape\"> $netscape[1] % ($netscape[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_opera',
        "<tr><td><img src=\"assets/images/opera.gif\" border=\"0\" alt=\"\">&nbsp;Opera: </td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Opera\"><img src=\"assets/images/mainbar.gif\" Alt=\"Opera\" height=\"$m_size[1]\" width=\"$opera[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Opera\"> $opera[1] % ($opera[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_kon',
        "<tr><td><img src=\"assets/images/konqueror.gif\" border=\"0\" alt=\"\">&nbsp;Konqueror: </td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Konqueror\"><img src=\"assets/images/mainbar.gif\" Alt=\"Konqueror (KDE)\" height=\"$m_size[1]\" width=\"$konqueror[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Konqueror\"> $konqueror[1] % ($konqueror[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_lynx',
        "<tr><td><img src=\"assets/images/lynx.gif\" border=\"0\" alt=\"\">&nbsp;Lynx: </td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Lynx\"><img src=\"assets/images/mainbar.gif\" Alt=\"Lynx\" height=\"$m_size[1]\" width=\"$lynx[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Lynx\"> $lynx[1] % ($lynx[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_apple',
        "<tr><td><img src=\"assets/images/apple.png\" border=\"0\" alt=\"\">&nbsp;AppleWebKit: </td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"AppleWebKit\"><img src=\"assets/images/mainbar.gif\" Alt=\"AppleWebKit\" height=\"$m_size[1]\" width=\"$apple[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"AppleWebKit\"> $apple[1] % ($apple[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_firefox',
        "<tr><td><img src=\"assets/images/firefox.png\" border=\"0\" alt=\"\">&nbsp;Firefox: </td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Firefox\"><img src=\"assets/images/mainbar.gif\" Alt=\"Firefox\" height=\"$m_size[1]\" width=\"$firefox[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Firefox\"> $firefox[1] % ($firefox[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_mozilla',
        "<tr><td><img src=\"assets/images/mozilla.png\" border=\"0\" alt=\"\">&nbsp;Mozilla: </td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Mozilla\"><img src=\"assets/images/mainbar.gif\" Alt=\"Mozilla\" height=\"$m_size[1]\" width=\"$mozilla[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Mozilla\"> $mozilla[1] % ($mozilla[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_deepnet',
        "<tr><td><img src=\"assets/images/deepnet.gif\" border=\"0\" alt=\"\">&nbsp;Deepnet: </td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Deepnet\"><img src=\"assets/images/mainbar.gif\" Alt=\"Deepnet\" height=\"$m_size[1]\" width=\"$deepnet[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Deepnet\"> $deepnet[1] % ($deepnet[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_avant',
        "<tr><td><img src=\"assets/images/avant.gif\" border=\"0\" alt=\"\">&nbsp;Avant: </td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Avant\"><img src=\"assets/images/mainbar.gif\" Alt=\"Avant\" height=\"$m_size[1]\" width=\"$avant[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Avant\"> $avant[1] % ($avant[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_altavista',
        '<tr><td><img src="assets/images/altavista.gif" border="0" alt="">&nbsp;'
        . STATS_SEARCHENGINES
        . ": </td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Robots - Spiders - Buscadores\"><img src=\"assets/images/mainbar.gif\" Alt=\"Robots - Spiders - Buscadores\" height=\"$m_size[1]\" width=\"$bot[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\""
        . STATS_BOTS
        . "\"> $bot[1] % ($bot[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_question',
        '<tr><td><img src="assets/images/question.gif" border="0" alt="">&nbsp;'
        . STATS_UNKNOWN
        . ": </td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Otros - Desconocidos\"><img src=\"assets/images/mainbar.gif\" Alt=\"Otros - Desconocidos\" height=\"$m_size[1]\" width=\"$b_other[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\""
        . STATS_OTHER
        . "\"> $b_other[1] % ($b_other[0])"
    );

    $xoopsTpl->assign('lang_stat_opersys', STATS_OPERATINGSYS);
    $xoopsTpl->assign(
        'lang_stat_windows',
        "<tr><td><img src=\"assets/images/windows.gif\" border=\"0\" alt=\"\">Windows:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Windows\"><img src=\"assets/images/mainbar.gif\" Alt=\"Windows\" height=\"$m_size[1]\" width=\"$windows[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Windows\"> $windows[1] % ($windows[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_linux',
        "<tr><td><img src=\"assets/images/linux.gif\" border=\"0\" alt=\"\">Linux:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Linux\"><img src=\"assets/images/mainbar.gif\" Alt=\"Linux\" height=\"$m_size[1]\" width=\"$linux[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Linux\"> $linux[1] % ($linux[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_mac',
        "<tr><td><img src=\"assets/images/mac.gif\" border=\"0\" alt=\"\">Mac/PPC:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Mac/PPC\"><img src=\"assets/images/mainbar.gif\" Alt=\"Mac - PPC\" height=\"$m_size[1]\" width=\"$mac[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Mac/PPC\"> $mac[1] % ($mac[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_bsd',
        "<tr><td><img src=\"assets/images/bsd.gif\" border=\"0\" alt=\"\">FreeBSD:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"FreeBSD\"><img src=\"assets/images/mainbar.gif\" Alt=\"FreeBSD\" height=\"$m_size[1]\" width=\"$freebsd[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"FreeBSD\"> $freebsd[1] % ($freebsd[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_sun',
        "<tr><td><img src=\"assets/images/sun.gif\" border=\"0\" alt=\"\">SunOS:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"SunOS\"><img src=\"assets/images/mainbar.gif\" Alt=\"SunOS\" height=\"$m_size[1]\" width=\"$sunos[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"SunOS\"> $sunos[1] % ($sunos[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_irix',
        "<tr><td><img src=\"assets/images/irix.gif\" border=\"0\" alt=\"\">IRIX:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"SGI Irix\"><img src=\"assets/images/mainbar.gif\" Alt=\"SGI Irix\" height=\"$m_size[1]\" width=\"$irix[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"SGI Irix\"> $irix[1] % ($irix[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_be',
        "<tr><td><img src=\"assets/images/be.gif\" border=\"0\" alt=\"\">BeOS:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"BeOS\"><img src=\"assets/images/mainbar.gif\" Alt=\"BeOS\" height=\"$m_size[1]\" width=\"$beos[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"BeOS\"> $beos[1] % ($beos[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_os2',
        "<tr><td><img src=\"assets/images/os2.gif\" border=\"0\" alt=\"\">OS/2:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"OS/2\"><img src=\"assets/images/mainbar.gif\" Alt=\"OS/2\" height=\"$m_size[1]\" width=\"$os2[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"OS/2\"> $os2[1] % ($os2[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_aix',
        "<tr><td><img src=\"assets/images/aix.gif\" border=\"0\" alt=\"\">&nbsp;AIX:</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"AIX\"><img src=\"assets/images/mainbar.gif\" Alt=\"AIX\" height=\"$m_size[1]\" width=\"$aix[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"AIX\"> $aix[1] % ($aix[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_osquestion',
        '<tr><td><img src="assets/images/question.gif" border="0" alt="">&nbsp;'
        . STATS_UNKNOWN
        . ":</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Otros - Desconocidos\"><img src=\"assets/images/mainbar.gif\" ALt=\"Otros - Desconocidos\" height=\"$m_size[1]\" width=\"$os_other[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\""
        . STATS_OTHER
        . "\"> $os_other[1] % ($os_other[0])"
    );

    $xoopsTpl->assign('lang_stat_blockedtype', STATS_BLOCKEDTYPE);
    $xoopsTpl->assign(
        'lang_stat_blockedbots',
        "<tr><td><img src=\"assets/images/altavista.gif\" border=\"0\" alt=\"\">Bots:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Bots\"><img src=\"assets/images/mainbar.gif\" Alt=\"Bots\" height=\"$m_size[1]\" width=\"$blockedbots[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Bots\"> $blockedbots[1] % ($blockedbots[0])</td></tr>"
    );
    $xoopsTpl->assign(
        'lang_stat_blockedreferers',
        "<tr><td><img src=\"assets/images/explorer.gif\" border=\"0\" alt=\"\">Referers:&nbsp;</td><td><img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Referers\"><img src=\"assets/images/mainbar.gif\" Alt=\"Referers\" height=\"$m_size[1]\" width=\"$blockedreferers[1] * 2\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Referers\"> $blockedreferers[1] % ($blockedreferers[0])</td></tr>"
    );

    $xoopsTpl->assign('lang_misc_stats', STATS_MISC);
    $unum = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('users')));
    $xoopsTpl->assign('lang_stats_regusers', STATS_REGUSERS);
    $xoopsTpl->assign('lang_stats_users', $unum);

    $usersonline = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('online')));
    $xoopsTpl->assign('lang_stats_usersonline', STATS_USERS_ONLINE);
    $xoopsTpl->assign('lang_stats_usersolcnt', $usersonline);

    $authorscnt = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('users') . ' WHERE posts>0'));
    $xoopsTpl->assign('lang_stats_auth', STATS_AUTHORS);
    $xoopsTpl->assign('lang_stats_authors', $authorscnt);

    $anum = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('session')));
    $xoopsTpl->assign('lang_stats_ausers', STATS_ACTIVEUSERS);
    $xoopsTpl->assign('lang_stats_activeusers', $anum);

    $cnum = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('xoopscomments')));
    $xoopsTpl->assign('lang_stats_commentsposted', STATS_COMMENTSPOSTED);
    $xoopsTpl->assign('lang_stats_comments', $cnum);

    $xoopsTpl->assign('lang_xoops_version', STATS_XOOPS_VERSION);

    // see if sections is active
    if ($xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('modules') . " WHERE dirname='sections' AND isactive='1'")) > 0) {
        $xoopsTpl->assign('sections_active', true);
        $secnum  = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('sections')));
        $secanum = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('seccont')));
        $xoopsTpl->assign('lang_stat_section', STATS_SECTION);
        $xoopsTpl->assign('lang_stat_sectioncnt', $secnum);
        $xoopsTpl->assign('lang_stat_article', STATS_ARTICLE);
        $xoopsTpl->assign('lang_stat_articlecnt', $secanum);
    }

    // see if news is active
    if ($xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('modules') . " WHERE dirname='news' AND isactive='1'")) > 0) {
        $xoopsTpl->assign('news_active', true);
        $snum = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('stories') . ' WHERE published!=0'));
        $xoopsTpl->assign('lang_stats_storiespublished', STATS_STORIESPUBLISHED);
        $xoopsTpl->assign('lang_stats_stories', $snum);

        $swait = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('stories') . ' WHERE published=0'));
        $xoopsTpl->assign('lang_stats_waitingstories', STATS_STORIESWAITING);
        $xoopsTpl->assign('lang_stats_waiting', $swait);

        $tnum = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('topics')));
        $xoopsTpl->assign('lang_stats_topics', STATS_TOPICS);
        $xoopsTpl->assign('lang_stats_topicscnt', $tnum);
    }

    // see if AMS is active
    if ($xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('modules') . " WHERE dirname='AMS' AND isactive='1'")) > 0) {
        $xoopsTpl->assign('amsnews_active', true);
        $snum = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('ams_article') . ' WHERE published!=0'));
        $xoopsTpl->assign('lang_stats_amsstoriespublished', STATS_AMSARTICLE);
        $xoopsTpl->assign('lang_stats_amsstories', $snum);

        $swait = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('ams_article') . ' WHERE published=0'));
        $xoopsTpl->assign('lang_stats_amswaitingstories', STATS_AMSSTORIESWAITING);
        $xoopsTpl->assign('lang_stats_amswaiting', $swait);

        $tnum = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('ams_topics')));
        $xoopsTpl->assign('lang_stats_amstopics', STATS_AMSTOPICS);
        $xoopsTpl->assign('lang_stats_amstopicscnt', $tnum);
    }

    // see if mylinks is active
    if ($xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('modules') . " WHERE dirname='mylinks' AND isactive='1'")) > 0) {
        $xoopsTpl->assign('links_active', true);
        $links = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('mylinks_links')));
        $xoopsTpl->assign('lang_stats_links', STATS_LINKS);
        $xoopsTpl->assign('lang_stats_linkscnt', $links);

        $cat = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('mylinks_cat')));
        $xoopsTpl->assign('lang_stats_linkcat', STATS_LINKCAT);
        $xoopsTpl->assign('lang_stats_linkcatcnt', $cat);
    }

    // see if xoopsgallery is active
    if ($xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('modules') . " WHERE dirname='xoopsgallery' AND isactive='1'")) > 0) {
        $xoopsTpl->assign('xoopsgallery_active', true);
        $links = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('xoopsgallery_image')));
        $xoopsTpl->assign('lang_stats_gimages', STATS_GALLERY_IMAGES);
        $xoopsTpl->assign('lang_stats_gimagescnt', $links);

        $cat = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT DISTINCT image_albumdir FROM ' . $xoopsDB->prefix('xoopsgallery_image')));
        $xoopsTpl->assign('lang_stats_galbums', STATS_GALLERY_ALBUMS);
        $xoopsTpl->assign('lang_stats_galbumscnt', $cat);
    }

    // see if tinycontent is active
    if ($xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('modules') . " WHERE dirname='tinycontent' AND isactive='1'")) > 0) {
        $xoopsTpl->assign('tinycontent_active', true);
        $links = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('tinycontent')));
        $xoopsTpl->assign('lang_stats_tinycontent', STATS_TCONTENT_AVAIL);
        $xoopsTpl->assign('lang_stats_tccnt', $links);

        $cat = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('tinycontent') . " WHERE visible='1'"));
        $xoopsTpl->assign('lang_stats_tcvisible', STATS_TCONTENT_VISIBLE);
        $xoopsTpl->assign('lang_stats_tcvcnt', $cat);
    }

    // see if mydownloads is active
    if ($xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('modules') . " WHERE dirname='downloads' AND isactive='1'")) > 0) {
        $xoopsTpl->assign('dl_active', true);
        $dlcat = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('mydownloads_cat')));
        $xoopsTpl->assign('lang_stats_dlcat', STATS_DLCAT);
        $xoopsTpl->assign('lang_stats_dlcatcnt', $dlcat);

        $dlfiles = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('mydownloads_downloads')));
        $xoopsTpl->assign('lang_stats_dlfiles', STATS_DLFILES);
        $xoopsTpl->assign('lang_stats_dlfilescnt', $dlfiles);
    }

    // see if wfdownloads is active
    if ($xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('modules') . " WHERE dirname='wfdownloads' AND isactive='1'")) > 0) {
        $xoopsTpl->assign('wfdl_active', true);
        $wfdlcat = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('wfdownloads_cat')));
        $xoopsTpl->assign('lang_stats_wfdlcat', STATS_WFDLCAT);
        $xoopsTpl->assign('lang_stats_wfdlcatcnt', $wfdlcat);

        $wfdlfiles = $xoopsDB->getRowsNum($xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('wfdownloads_downloads')));
        $xoopsTpl->assign('lang_stats_wfdlfiles', STATS_WFDLFILES);
        $xoopsTpl->assign('lang_stats_wfdlfilescnt', $wfdlfiles);
    }
}

mainStats();

require_once XOOPS_ROOT_PATH . '/footer.php';

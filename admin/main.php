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
$moduleDirName = basename(dirname(__DIR__));
xoops_loadLanguage('main', $moduleDirName);

// require_once  dirname(__DIR__) . '/class/clsWhois.php';
require_once  dirname(__DIR__) . '/include/statutils.php';

function remoteAddr()
{
    global $xoopsDB;

    $result = $xoopsDB->queryF('SELECT ip, date, hits FROM ' . $xoopsDB->prefix('stats_ip') . ' ORDER BY date');
    $iplist = [];
    $i      = 0;
    while (false !== (list($ip, $date, $hits) = $xoopsDB->fetchRow($result))) {
        $iplist[$i]['ip']   = $ip;
        $iplist[$i]['hits'] = $hits;
        preg_match('/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})/', $date, $regs);
        $iplist[$i]['ipyear']  = $regs[1];
        $iplist[$i]['ipmonth'] = $regs[2];
        $iplist[$i]['ipday']   = $regs[3];
        $iplist[$i]['iphour']  = $regs[4];
        ++$i;
    }

    echo "<h4 style='text-align:left;'>" . STATS_REMOTEADDR_HEAD . ' - ' . STATS_STDIP . "</h4><br>\n";
    echo "<table><tr><td>\n";
    echo "<form action='main.php' method='post'>\n";
    echo $GLOBALS['xoopsSecurity']->getTokenHTML();
    echo "<input type='hidden' name='op' value='purge_ips'>\n";
    echo "<input type='submit' value='" . STATS_IPPURGE . "' name='selsubmit'>";
    echo "</form>\n";
    echo "</td><td>\n";
    echo "<form action='main.php' method='post'>\n";
    echo $GLOBALS['xoopsSecurity']->getTokenHTML();
    echo "<input type='hidden' name='op' value='unique_ips'>\n";
    echo "<input type='submit' value='" . STATS_UNIQUEIP . "' name='selsubmit'>";
    echo "</form>\n";
    echo "</td></tr></table>\n";
    echo "<table>\n";
    echo '<tr><th>' . STATS_REMOTE_IP . '</th><th>' . STATS_REMOTE_DATE . '</th><th>' . STATS_REMOTE_HOUR . '</th><th>' . STATS_REMOTE_HITS . "</th></tr>\n";
    foreach ($iplist as $item) {
        echo '<tr><td><a href="main.php?op=reverseip&amp;iplookup=' . $item['ip'] . '">' . $item['ip'] . '</a></td>' . '<td>' . $item['ipmonth'] . '-' . $item['ipday'] . '-' . $item['ipyear'] . '</td><td>' . $item['iphour'] . '</td><td>' . $item['hits'] . "</td></tr>\n";
    }

    echo '</table>';
}

function uniqueRemoteAddr()
{
    global $xoopsDB;

    $result = $xoopsDB->queryF('SELECT ip, SUM(hits) AS total FROM ' . $xoopsDB->prefix('stats_ip') . ' GROUP BY ip ORDER BY total DESC');
    $iplist = [];
    $i      = 0;
    while (false !== (list($ip, $total) = $xoopsDB->fetchRow($result))) {
        $iplist[$i]['ip']   = $ip;
        $iplist[$i]['hits'] = $total;
        ++$i;
    }

    echo "<h4 style='text-align:left;'>" . STATS_REMOTEADDR_HEAD . ' - ' . STATS_UNIQUEIP . "</h4><br>\n";
    echo "<table><tr><td>\n";
    echo "<form action='main.php' method='post'>\n";
    echo $GLOBALS['xoopsSecurity']->getTokenHTML();
    echo "<input type='hidden' name='op' value='purge_ips'>\n";
    echo "<input type='submit' value='" . STATS_IPPURGE . "' name='selsubmit'>";
    echo "</form>\n";
    echo "</td><td>\n";
    echo "<form action='main.php' method='post'>\n";
    echo $GLOBALS['xoopsSecurity']->getTokenHTML();
    echo "<input type='hidden' name='op' value='remote_addr'>\n";
    echo "<input type='submit' value='" . STATS_STDIP . "' name='selsubmit'>";
    echo "</form>\n";
    echo "</td></tr></table>\n";
    echo "<table>\n";
    echo '<tr><th>' . STATS_REMOTE_IP . '</th><th>' . STATS_REMOTE_HITS . "</th></tr>\n";
    foreach ($iplist as $item) {
        echo '<tr><td><a href="main.php?op=reverseip&amp;iplookup=' . $item['ip'] . '">' . $item['ip'] . '</a></td>' . '<td>' . $item['hits'] . "</td></tr>\n";
    }

    echo '</table>';
}

function purgeRemoteAddr()
{
    global $xoopsDB;

    echo "<h4 style='text-align:left;'>" . STATS_REMOTEADDR_HEAD . "</h4><br>\n";

    $result = $xoopsDB->queryF('truncate table ' . $xoopsDB->prefix('stats_ip'));
    if ($result) {
        echo STATS_REMOTEADDR_PURGE;
    } else {
        echo STATS_REMOTEADDR_NPURGE;
    }
}

function referDB($orderby)
{
    global $xoopsDB;

    // get the current referers
    $result    = $xoopsDB->queryF('select ip, refer, date, hits, referpath from ' . $xoopsDB->prefix('stats_refer') . " order by $orderby DESC");
    $referlist = [];
    $i         = 0;
    while (false !== (list($ip, $refer, $date, $hits, $referpath) = $xoopsDB->fetchRow($result))) {
        $referpathparts = explode('|', $referpath);

        $referlist[$i]['ip']        = $ip;
        $referlist[$i]['refer']     = $refer;
        $referlist[$i]['referpath'] = $referpathparts[0];

        if (isset($referpathparts[1])) {
            $querystr = $referpathparts[1];
        } else {
            $querystr = '';
        }

        $referlist[$i]['query'] = $querystr;

        if (isset($referpathparts[2])) {
            $fragmentstr = $referpathparts[2];
        } else {
            $fragmentstr = '';
        }

        $referlist[$i]['fragment'] = $fragmentstr;

        $referlist[$i]['hits'] = $hits;
        preg_match('/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})/', $date, $regs);
        $referlist[$i]['referyear']  = $regs[1];
        $referlist[$i]['refermonth'] = $regs[2];
        $referlist[$i]['referday']   = $regs[3];
        $referlist[$i]['referhour']  = $regs[4];
        ++$i;
    }

    // get any current blacklist
    $result = $xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('stats_refer_blacklist'));
    list($id, $referer) = $xoopsDB->fetchRow($result);
    $referblacklist = unserialize(stripslashes($referer));
    if (!is_array($referblacklist)) { // something went wrong, or there is no data...
        $referblacklist = [];
    }

    echo "<h4 style='text-align:left;'>" . STATS_REFER_HEAD . "</h4><br>\n";
    echo "<div style=\"font-size: x-small;\"><table cellspacing=\"0\" cellpadding=\"0\" border='1'><tr><td><form action='main.php' method='post'>\n";
    echo "<input type='hidden' name='op' value='purge_refer'>\n";
    echo "<input style=\"font-size: x-small;\" type='submit' value='" . STATS_REFERPURGE . "' name='selsubmit'>";
    echo "</form></td>\n";
    echo "<td><form action='main.php' method='post'>\n";
    echo STATS_STATSBL_INST . "<input type='hidden' name='op' value='blacklist_refer'>\n";
    echo "<br><textarea name='bad_refer' id='bad_refer' rows='5' cols='50'>\n";

    $rbldelimited = implode('|', $referblacklist);
    echo $rbldelimited;

    echo "</textarea><br>\n";

    echo STATS_STATSBL_HELP;
    echo "<br><input style=\"font-size: x-small;\" type='submit' value='" . STATS_REFERBLACKLIST . "' name='selsubmit'>\n";
    echo "</form>\n";
    echo "<form action='main.php' method='post'>\n";
    echo $GLOBALS['xoopsSecurity']->getTokenHTML();
    echo "<input type='hidden' name='op' value='purge_blacklist'>\n";
    echo "<input style=\"font-size: x-small;\" type='submit' value='" . STATS_PURGEBL . "' name='purgesubmit'>";
    echo "</td></tr></table></div>\n";

    // figure out which arrow image to display
    $referimg = 'refer' === $orderby ? 'arrowup.gif' : 'arrowdn.gif';
    $hitsimg  = 'hits' === $orderby ? 'arrowup.gif' : 'arrowdn.gif';
    $dateimg  = 'date' === $orderby ? 'arrowup.gif' : 'arrowdn.gif';

    echo "<div style=\"font-size: xx-small;\"><table>\n";
    echo '<tr><th>'
         . STATS_REMOTE_IP
         . '</th><th>'
         . STATS_REFER
         . ': <A href="main.php?op=refer&amp;orderby=refer"><img src="../assets/images/'
         . $referimg
         . '"></a></th>'
         . '<th>'
         . STATS_XWHOIS
         . '</th><th>'
         . STATS_REFER_PATH
         . "</th><th>\n"
         . STATS_QUERYSTRING
         . '</th><th>'
         . STATS_FRAGMENTSTRING
         . "</th><th>\n"
         . STATS_REFER_DATE
         . ': <a href="main.php?op=refer&amp;orderby=date"><img src="../assets/images/'
         . $dateimg
         . '"></a></th><th>'
         . STATS_REFER_HOUR
         . "</th><th>\n"
         . STATS_REFER_HITS
         . ': <a href="main.php?op=refer&amp;orderby=hits"><img src="../assets/images/'
         . $hitsimg
         . "\"></a></th></tr>\n";
    foreach ($referlist as $item) {
        $dn   = explode('.', $item['refer']);
        $name = $dn[1];
        if (isset($dn[2])) {
            $name .= '.' . $dn[2];
        }

        echo "<tr><td align='left'><a href=\"main.php?op=reverseip&amp;iplookup="
             . $item['ip']
             . '">'
             . $item['ip']
             . '</a></td>'
             . "<td align='right'><a href='http://"
             . $item['refer']
             . "' target='_new'>"
             . $item['refer']
             . "</a></td>\n"
             . '<td><a href="main.php?op=xwhois&amp;dnslookup='
             . $name
             . '&amp;orderby='
             . $orderby
             . '">'
             . STATS_XWHOIS
             . "</a></td>\n"
             . "<td><a href='http://"
             . $item['refer']
             . $item['referpath']
             . "' target='_new'>"
             . $item['referpath']
             . "</a></td>\n"
             . '<td>'
             . $item['query']
             . '</td><td>'
             . $item['fragment']
             . "</td>\n"
             . '<td>'
             . $item['refermonth']
             . '-'
             . $item['referday']
             . '-'
             . $item['referyear']
             . "</td>\n"
             . '<td>'
             . $item['referhour']
             . '</td><td>'
             . $item['hits']
             . "</td></tr>\n";
    }

    echo '</table></div>';
}

function purgeReferDB()
{
    global $xoopsDB;

    echo "<h4 style='text-align:left;'>" . STATS_REFER_HEAD . "</h4><br>\n";

    $result = $xoopsDB->queryF('truncate table ' . $xoopsDB->prefix('stats_refer'));
    if ($result) {
        echo STATS_REFER_PURGE;
    } else {
        echo STATS_REFER_NPURGE;
    }
}

function purgeBlacklist()
{
    global $xoopsDB;

    echo "<h4 style='text-align:left;'>" . STATS_PURGEBL . "</h4><br>\n";

    $result = $xoopsDB->queryF('truncate table ' . $xoopsDB->prefix('stats_refer_blacklist'));
    if ($result) {
        echo STATS_BLACKLIST_PURGE;
    } else {
        echo STATS_BLACKLIST_NPURGE;
    }
}

function blacklistReferDB($blr)
{
    global $xoopsDB;

    // truncate table first
    $result = $xoopsDB->queryF('truncate table ' . $xoopsDB->prefix('stats_refer_blacklist'));

    echo "<h4 style='text-align:left;'>" . STATS_BLACKLIST_CREATED . "</h4><br>\n";

    $rbl = explode('|', $blr);
    // insert into database table
    $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_refer_blacklist') . " (referer) VALUES ('" . addslashes(serialize($rbl)) . "')");

    if ($result) {
        foreach ($rbl as $item) {
            echo STATS_BLACKLISTED . $item . '<br>';
        }
    }
}

function userScreen()
{
    global $xoopsDB;

    $result  = $xoopsDB->queryF('SELECT id, hits FROM ' . $xoopsDB->prefix('stats_userscreen'));
    $usWidth = [];
    $i       = 0;
    while (false !== (list($id, $hits) = $xoopsDB->fetchRow($result))) {
        switch ($id) {
            case '1':
                $usWidth[$i]['id'] = '640';
                break;

            case '2':
                $usWidth[$i]['id'] = '800';
                break;

            case '3':
                $usWidth[$i]['id'] = '1024';
                break;

            case '4':
                $usWidth[$i]['id'] = '1152';
                break;

            case '5':
                $usWidth[$i]['id'] = '1280';
                break;

            case '6':
                $usWidth[$i]['id'] = '1600';
                break;

            default:
                $usWidth[$i]['id'] = STATS_SW_UNKNOWN;
                break;
        }
        $usWidth[$i]['hits'] = $hits;
        ++$i;
    }

    $result  = $xoopsDB->queryF('SELECT id, hits FROM ' . $xoopsDB->prefix('stats_usercolor'));
    $usColor = [];
    $i       = 0;
    while (false !== (list($id, $hits) = $xoopsDB->fetchRow($result))) {
        switch ($id) {
            case '1':
                $usColor[$i]['id'] = '8';
                break;

            case '2':
                $usColor[$i]['id'] = '16';
                break;

            case '3':
                $usColor[$i]['id'] = '24';
                break;

            case '4':
                $usColor[$i]['id'] = '32';
                break;

            default:
                $usColor[$i]['id'] = STATS_SC_UNKNOWN;
                break;
        }
        $usColor[$i]['hits'] = $hits;
        ++$i;
    }

    echo '<table width="100%" cellpadding="1" cellspacing="1" border="0"><tr><th colspan="2">' . STATS_USERSCREEN_HEAD . "</th></tr><tr><td align=\"center\" valign=\"top\" width=\"50%\">\n";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n" . '<tr><th width="50%">' . STATS_SW_HEAD . '</th><th width="50%">' . STATS_SCREEN_HITS . "</th></tr>\n";
    foreach ($usWidth as $current) {
        echo '<tr><td>' . $current['id'] . '</td><td>' . $current['hits'] . "</td></tr>\n";
    }
    echo "</table></td><td align=\"center\" valign=\"top\" width=\"50%\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n";
    echo '<tr><th width="50%">' . STATS_SC_HEAD . '</th><th width="50%">' . STATS_SCREEN_HITS . "</th></tr>\n";
    foreach ($usColor as $current) {
        echo '<tr><td>' . $current['id'] . '</td><td>' . $current['hits'] . "</td></tr>\n";
    }
    echo "</table>\n";
    echo "</td></tr>\n";
    echo "<tr><td>\n";
    echo "<form action='main.php' method='post'>\n";
    echo $GLOBALS['xoopsSecurity']->getTokenHTML();
    echo "<input type='hidden' name='op' value='purge_userscreen'>\n";
    echo "<input style=\"font-size: x-small;\" type='submit' value='" . STATS_SCREEN_PURGE . "' name='selsubmit'>";
    echo "</form>\n";
    echo "</td></tr>\n";
    echo "</table>\n";
}

function purgeUserScreen()
{
    global $xoopsDB;

    echo "<h4 style='text-align:left;'>" . STATS_SCREEN_PURGE . "</h4><br>\n";

    $result_one = $xoopsDB->queryF('truncate table ' . $xoopsDB->prefix('stats_usercolor'));
    $result_two = $xoopsDB->queryF('truncate table ' . $xoopsDB->prefix('stats_userscreen'));
    if ($result_one && $result_two) {
        echo STATS_USERSCREEN_PURGE;
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (1, 0)');
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (2, 0)');
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (3, 0)');
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (4, 0)');
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (5, 0)');
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (6, 0)');
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_userscreen') . ' VALUES (7, 0)');
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_usercolor') . ' VALUES (1, 0)');
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_usercolor') . ' VALUES (2, 0)');
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_usercolor') . ' VALUES (3, 0)');
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_usercolor') . ' VALUES (4, 0)');
        $result = $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_usercolor') . ' VALUES (5, 0)');
    } else {
        echo STATS_USERSCREEN_NPURGE;
    }
}

function statsreverselookup($ip)
{
    $whois = new xWhois();

    $d = $whois->reverselookup($ip);

    echo "<table width='100%' cellpadding='0' cellspacing='0'>\n" . '<tr><th>' . STATS_REVERSELOOKUP . "$ip</th></tr>\n" . '<tr><td>' . $d . "</td></tr></table>\n";
}

function statsdnslookup($domainname)
{
    $whois = new xWhois();

    $d = $whois->lookup($domainname);

    echo "<table width='100%' cellpadding='0' cellspacing='0'>\n" . '<tr><th>' . STATS_DNSLOOKUP . "$ip</th></tr>\n" . '<tr><td>' . $d . "</td></tr></table>\n";
}

if (!isset($_POST['op'])) {
    $op = \Xmf\Request::getString('op', '', 'GET');
} else {
    $op = $_POST['op'];
}

xoops_cp_header();

switch ($op) {
    case INFO_CREDITS:
        phpcredits(CREDITS_ALL - CREDITS_FULLPAGE);
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case INFO_GENERAL:
    case INFO_CONFIGURATION:
    case INFO_MODULES:
    case INFO_ENVIRONMENT:
    case INFO_VARIABLES:
    case INFO_LICENSE:
    case INFO_ALL:
        ob_start();

        phpinfo($op);

        $php_info = ob_get_contents();
        ob_end_clean();

        $php_info = str_replace('<html><body>', '', $php_info);
        $php_info = str_replace('</body></html>', '', $php_info);

        $offset = strpos($php_info, '<table');

        print substr($php_info, $offset);
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case 'reverseip':
        if (!isset($_POST['iplookup'])) {
            $iplookup = \Xmf\Request::getString('iplookup', '', 'GET');
        } else {
            $iplookup = $_POST['iplookup'];
        }

        if ('' != $iplookup) {
            statsreverselookup($iplookup);
        }
        remoteAddr();
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case 'xwhois':
        if (!isset($_POST['dnslookup'])) {
            $dnslookup = \Xmf\Request::getString('dnslookup', '', 'GET');
        } else {
            $dnslookup = $_POST['dnslookup'];
        }

        if ('' != $dnslookup) {
            statsdnslookup($dnslookup);
        }

        if (!isset($_POST['orderby'])) {
            $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'date';
        } else {
            $orderby = $_POST['orderby'];
        }

        referDB($orderby);
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case 'unique_ips':
        uniqueRemoteAddr();
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case 'remote_addr':
        remoteAddr();
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case 'purge_ips':
        if (isset($_POST['confirm']) && 'purge_ips' === $_POST['confirm']) {
            purgeRemoteAddr();
        } else {
            $hidden = [
                confirm => 'purge_ips',
                op      => 'purge_ips'
            ];
            xoops_confirm($hidden, 'main.php', STATS_REMOTEADDR_PURGESURE, STATS_IPPURGE);
        }
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case 'refer':
        if (!isset($_POST['orderby'])) {
            $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'date';
        } else {
            $orderby = $_POST['orderby'];
        }

        referDB($orderby);
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case 'purge_refer':
        if (isset($_POST['confirm']) && 'purge_refer' === $_POST['confirm']) {
            purgeReferDB();
        } else {
            $hidden = [
                confirm => 'purge_refer',
                op      => 'purge_refer'
            ];
            xoops_confirm($hidden, 'main.php', STATS_REFER_PURGESURE, STATS_REFERPURGE);
        }
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case 'blacklist_refer':
        if (isset($_POST['bad_refer']) && '' != $_POST['bad_refer']) {
            $hidden = [
                confirm => 'blacklist_refer',
                op      => 'blacklist_refer',
                blr     => $_POST['bad_refer']
            ];
            xoops_confirm($hidden, 'main.php', STATS_REFER_BLSURE, STATS_REFERBLACKLIST);
        } elseif (isset($_POST['confirm']) && 'blacklist_refer' === $_POST['confirm']) {
            blacklistReferDB($_POST['blr']);
        } else {
            referDB();
        }
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case 'purge_blacklist':
        if (isset($_POST['confirm']) && 'purge_blacklist' === $_POST['confirm']) {
            purgeBlacklist();
        } else {
            $hidden = [
                confirm => 'purge_blacklist',
                op      => 'purge_blacklist'
            ];
            xoops_confirm($hidden, 'main.php', STATS_REFER_PURGEBL, STATS_PURGEBL);
        }
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case 'userscreen':
        userScreen();
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    case 'purge_userscreen':
        if (isset($_POST['confirm']) && 'purge_userscreen' === $_POST['confirm']) {
            purgeUserScreen();
        } else {
            $hidden = [
                confirm => 'purge_userscreen',
                op      => 'purge_userscreen'
            ];
            xoops_confirm($hidden, 'main.php', STATS_REFER_PURGEUS, STATS_SCREEN_PURGE);
        }
        echo '<hr><a href="main.php">' . STATS_ADMINHEAD . "</a>\n";
        break;

    default:
        //    stats_adminmenu( STATS_ADMINHEAD );
        break;
}

xoops_cp_footer();

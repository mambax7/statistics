<?php

/************************************************************************/
/* XOOPS: Web Portal System                                             */
/* ========================                                             */
/*                                                                      */
/* Copyright (c) 2004 by John Horne                                     */
/* http://xoops.ibdeeming.com                                           */
/*                                                                      */
/* By Seventhseal@ibdeeming.com Version 1.0 8/2004                      */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

require_once XOOPS_ROOT_PATH . '/modules/statistics/language/' . $xoopsConfig['language'] . '/main.php';
// Load required configs
global $stats_secure_const, $configHandler, $xoopsStatConfig;

/** @var XoopsModuleHandler $moduleHandler */
$moduleHandler   = xoops_getHandler('module');
$xoopsStatModule = $moduleHandler->getByDirname('statistics');
$xoopsStatConfig = $configHandler->getConfigsByCat(0, $xoopsStatModule->getVar('mid'));

$stats_secure_const['server_ip']           = get_server_ip();
$stats_secure_const['client_ip']           = get_client_ip();
$stats_secure_const['forward_ip']          = get_x_forwarded();
$stats_secure_const['remote_addr']         = get_remote_addr();
$stats_secure_const['remote_ip']           = get_ip();
$stats_secure_const['remote_port']         = get_remote_port();
$stats_secure_const['request_method']      = get_request_method();
$stats_secure_const['script_name']         = get_script_name();
$stats_secure_const['http_host']           = get_http_host();
$stats_secure_const['query_string']        = st_clean_string(get_query_string());
$stats_secure_const['get_string']          = st_clean_string(get_get_string());
$stats_secure_const['post_string']         = st_clean_string(get_post_string());
$stats_secure_const['query_string_base64'] = st_clean_string(base64_decode($stats_secure_const['query_string']));
$stats_secure_const['get_string_base64']   = st_clean_string(base64_decode($stats_secure_const['get_string']));
$stats_secure_const['post_string_base64']  = st_clean_string(base64_decode($stats_secure_const['post_string']));
$stats_secure_const['user_agent']          = get_user_agent();
$stats_secure_const['referer']             = get_referer();
$stats_secure_const['script_name']         = get_script_name();
$stats_secure_const['ban_time']            = time();
$stats_secure_const['ban_ip']              = '';

// $var == 'bots' or 'referers'
function setBlockedCounter($var)
{
    global $xoopsDB, $stats_secure_const, $xoopsStatConfig;

    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('counter') . " SET count=count+1 WHERE (type='totalblocked' AND var='hits') OR (var='$var' AND type='blocked')");

    /* Start Detailed Statistics */
    $dot        = date('d-m-Y-H');
    $now        = explode('-', $dot);
    $nowHour    = $now[3];
    $nowYear    = $now[2];
    $nowMonth   = $now[1];
    $nowDate    = $now[0];
    $sql        = 'SELECT year FROM ' . $xoopsDB->prefix('stats_blockedyear') . " WHERE year='$nowYear'";
    $resultyear = $xoopsDB->queryF($sql);
    $jml        = $xoopsDB->getRowsNum($resultyear);
    if ($jml <= 0) {
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('stats_blockedyear') . " VALUES ('$nowYear','0')";
        $xoopsDB->queryF($sql);
        for ($i = 1; $i <= 12; ++$i) {
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_blockedmonth') . " VALUES ('$nowYear','$i','0')");
            if (1 == $i) {
                $TotalDay = 31;
            }
            if (2 == $i) {
                if (true === date('L')) {
                    $TotalDay = 29;
                } else {
                    $TotalDay = 28;
                }
            }
            if (3 == $i) {
                $TotalDay = 31;
            }
            if (4 == $i) {
                $TotalDay = 30;
            }
            if (5 == $i) {
                $TotalDay = 31;
            }
            if (6 == $i) {
                $TotalDay = 30;
            }
            if (7 == $i) {
                $TotalDay = 31;
            }
            if (8 == $i) {
                $TotalDay = 31;
            }
            if (9 == $i) {
                $TotalDay = 30;
            }
            if (10 == $i) {
                $TotalDay = 31;
            }
            if (11 == $i) {
                $TotalDay = 30;
            }
            if (12 == $i) {
                $TotalDay = 31;
            }
            for ($k = 1; $k <= $TotalDay; ++$k) {
                $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_blockeddate') . " VALUES ('$nowYear','$i','$k','0')");
            }
        }
    }

    $sql     = 'SELECT hour FROM ' . $xoopsDB->prefix('stats_blockedhour') . " WHERE (year='$nowYear') AND (month='$nowMonth') AND (date='$nowDate')";
    $result  = $xoopsDB->queryF($sql);
    $numrows = $xoopsDB->getRowsNum($result);

    if ($numrows <= 0) {
        for ($z = 0; $z <= 23; ++$z) {
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_blockedhour') . " VALUES ('$nowYear','$nowMonth','$nowDate','$z','0')");
        }
    }

    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_blockedyear') . " SET hits=hits+1 WHERE year='$nowYear'");
    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_blockedmonth') . " SET hits=hits+1 WHERE (year='$nowYear') AND (month='$nowMonth')");
    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_blockeddate') . " SET hits=hits+1 WHERE (year='$nowYear') AND (month='$nowMonth') AND (date='$nowDate')");
    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_blockedhour') . " SET hits=hits+1 WHERE (year='$nowYear') AND (month='$nowMonth') AND (date='$nowDate') AND (hour='$nowHour')");
}

// ************************** Begin Security Checks ******************************
function prematureDeath($str)
{
    if (isset($_COOKIE[$xoopsConfig['session_name']])) {
        setcookie($xoopsConfig['session_name'], '', time() - 42000, '/');
    }

    $_SESSION = [];

    session_destroy();

    die($str);
}

// check no count IP - this is when webmaster doesn't want an IP to count in stats
function checkNoCountIP()
{
    global $xoopsStatConfig, $stats_secure_const;

    $ret_result = false;
    $ip         = $stats_secure_const['remote_ip'];

    // check for filtering of IP from hits
    if ('1' == $xoopsStatConfig['stats_allowfilteriphits']) {
        // filtering is ON
        $filteriplist = $xoopsStatConfig['stats_filteriplist'];
        if (is_array($filteriplist)) { // make sure we have an array
            if (count($filteriplist) > 0) { // check how many items I have
                foreach ($filteriplist as $fipl) {
                    //    print( $ip."&nbsp;-&nbsp;".$fipl."<br>" );
                    if (preg_match('/' . $fipl . '/', $ip)) { // look at each item in list, see if it matches current IP
                        $ret_result = true;  // if it matches, don't count it
                        continue;
                    }
                }
            }
        }
    }

    return $ret_result;
}

// check block bots list
function checkBlockBotslist()
{
    global $stats_secure_const, $xoopsStatConfig;

    $ret_result = false;  // set default return value for function

    if ('1' == $xoopsStatConfig['stats_forbidbots']) {  // is it on?
        $blockedbotslist = $xoopsStatConfig['stats_botstoblock'];

        if (is_array($blockedbotslist)) {  // make sure it's an array
            if (count($blockedbotslist) > 0) {
                foreach ($blockedbotslist as $bot) {
                    if (preg_match('/' . $bot . '/', $stats_secure_const['user_agent'])) {
                        $ret_result = true;
                        continue;
                    }
                }
            }
        }
    }

    return $ret_result;
}

if (true === checkBlockBotslist()) {
    global $xoopsStatConfig;

    setBlockedCounter('bots');/* Save the obtained values */

    die($xoopsStatConfig['stats_customforbidmsg'] . '<br>********<br>' . $stats_secure_const['user_agent']);
}

// check blacklisted referers - if a match, die!
function checkBlacklist()
{
    global $xoopsDB, $stats_secure_const;

    $ret_result = false;

    // get any current blacklist
    $result = $xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('stats_refer_blacklist'));
    list($id, $referer) = $xoopsDB->fetchRow($result);
    $referblacklist = unserialize(stripslashes($referer));

    if (is_array($referblacklist)) { // make sure we have an array

        // attempt to strip anthing but the URL i.e. http://www.abc.com instead of http://www.abc.com/dirname
        // this is not the same as $stats_secure_const['http_host'] above.
        $dnsarray = parse_url($stats_secure_const['referer']);
        if (!isset($dnsarray['host']) || '' == $dnsarray['host']) {
            $dnsarray['host'] = $stats_secure_const['referer'];
        }

        if (count($referblacklist) > 0) {
            foreach ($referblacklist as $item) {
                if (preg_match('/' . $item . '/', $dnsarray['host'])) {
                    $ret_result = true;
                    continue;
                }
            }
        }
    }

    return $ret_result;
}

if (true === checkBlacklist()) {
    global $xoopsDB, $stats_secure_const, $xoopsStatConfig;

    $switchval = $xoopsStatConfig['refererspam'];

    switch ($switchval) {
        case 'Forbidden':
            /* Save the obtained values */
            setBlockedCounter('referers');
            prematureDeath($xoopsStatConfig['stats_customforbidmsg'] . '<br>********<br>' . $stats_secure_const['referer']);
            break;

        case 'Reflect':
            /* Save the obtained values */
            setBlockedCounter('referers');

            preg_match("/^(http:\/\/)?([^\/]+)/i", $stats_secure_const['referer'], $matches);
            $prefix = $matches[1];
            $host   = $matches[2];

            // get last two segments of host name
            preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
            $domain_tld = $matches[0];

            header('Location: ' . $prefix . $domain_tld . '/');
            prematureDeath('Location: ' . $stats_secure_const['referer']);
            break;

        default:
            break;
    }
}

// Invalid ip check
if ('none' === $stats_secure_const['remote_ip']) {
    prematureDeath(STATS_INVALIDIP);
}

// Invalid request method check
if ('get' !== strtolower($stats_secure_const['request_method']) && 'head' !== strtolower($stats_secure_const['request_method']) && 'post' !== strtolower($stats_secure_const['request_method'])
    && 'put' !== strtolower($stats_secure_const['request_method'])) {
    prematureDeath(STATS_INVALIDMETHOD);
}

// DOS Attack Blocker
if (empty($stats_secure_const['user_agent']) || '-' == $stats_secure_const['user_agent']
    || !isset($stats_secure_const['user_agent'])) {
    prematureDeath($xoopsStatConfig['stats_customforbidmsg']);
}
// Check for UNION attack
if (stristr($stats_secure_const['query_string'], '+union+')
    or stristr($stats_secure_const['query_string'], '%20union%20')
    or stristr($stats_secure_const['query_string'], '*/union/*')
    or stristr($stats_secure_const['query_string'], ' union ')
    or stristr($stats_secure_const['query_string_base64'], '+union+')
    or stristr($stats_secure_const['query_string_base64'], '%20union%20')
    or stristr($stats_secure_const['query_string_base64'], '*/union/*')
    or stristr($stats_secure_const['query_string_base64'], ' union ')) {
    prematureDeath($xoopsStatConfig['stats_customforbidmsg']);
}

// ********************** END SECURITY CHECKS *********************************

function getRemoteAddr()
{
    global $xoopsDB, $stats_secure_const;

    $ip = $stats_secure_const['remote_ip'];

    $now_ip    = date('YmdH');
    $past_hour = $now_ip - 1;
    $resultip  = $xoopsDB->queryF('SELECT id FROM ' . $xoopsDB->prefix('stats_ip') . " WHERE ip='$ip' AND date>'$past_hour'");
    if ($xoopsDB->getRowsNum($resultip) > 0) {
        $row = $xoopsDB->fetchRow($resultip);
        $id  = $row[0];
        $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_ip') . " SET date='$now_ip', hits=hits+1 WHERE id='$id'");
    } else {
        $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_ip') . " (ip, date, hits) VALUES ('$ip', '$now_ip', '1')");
    }
}

function autoPurgeRefererList()
{
    global $xoopsDB, $xoopsStatConfig;

    $now_refer = date('YmdH');
    $timelimit = 0;

    switch ($xoopsStatConfig['autopurgereferer']) {
        case 'never':
            return;

        case 'fiveday':
            $timelimit = 120;
            break;

        case 'oneday':
            $timelimit = 24;
            break;

        case 'sixhour':
            $timelimit = 6;
            break;

        case 'twelvehour':
            $timelimit = 12;
            break;
    }

    $timestamp  = time() - ($timelimit * 60 * 60);
    $purge_date = date('Ymdh', $timestamp);

    $xoopsDB->queryF('DELETE FROM ' . $xoopsDB->prefix('stats_refer') . " where date <= '$purge_date'");
}

function getRemoteReferer()
{
    global $xoopsDB, $stats_secure_const;

    // do a little house cleaning
    autoPurgeRefererList();

    $refer = $stats_secure_const['referer'];
    $ip    = get_ip();

    if ('' != $refer) {
        // break it down!!
        $dnsarray = parse_url($refer);
    }

    if (!isset($dnsarray['host'])) {
        $dnsarray['host'] = $stats_secure_const['http_host'];
    }

    if ('' != $dnsarray['host']) {
        $now_refer = date('YmdH');
        $past_hour = $now_refer - 1;

        // figure out if we are saving hits by refer and path or just refer
        $resultoption = $xoopsDB->queryF('SELECT options FROM ' . $xoopsDB->prefix('newblocks') . " WHERE name='Top Referers' AND dirname='statistics'");
        $optionsret   = $xoopsDB->fetchRow($resultoption);
        $options      = unserialize(stripslashes($optionsret[0]));
        $options      = explode('|', $optionsret[0]);

        if ((count($options) <= 1) || '' == $options[1]) {
            $options[1] = 0;
        }

        if (!isset($dnsarray['path']) || '' == $dnsarray['path']) {
            $pathfordb = '';
        } else {
            $pathfordb = $dnsarray['path'];
        }

        if (isset($dnsarray['query']) && '' != $dnsarray['query']) {
            $pathfordb .= '|' . st_clean_string($dnsarray['query']);
        } else {
            $querystr  = $stats_secure_const['query_string'];
            $pathfordb .= '|' . $querystr;
        }

        if (isset($dnsarray['fragment']) && '' != $dnsarray['fragment']) {
            $pathfordb .= '|' . $dnsarray['fragment'];
        }

        if (1 == $options[1]) {    // domain only, don't care about rest, but will store.  Uniqueness in query isn't as granular
            $resultrefer      = $xoopsDB->queryF('SELECT id FROM ' . $xoopsDB->prefix('stats_refer') . " WHERE refer='" . $dnsarray['host'] . "' AND referpath='' and date>'$past_hour' and ip='$ip'");
            $dnsarray['path'] = '';
        } else {
            $resultrefer = $xoopsDB->queryF('SELECT id FROM ' . $xoopsDB->prefix('stats_refer') . " WHERE refer='" . $dnsarray['host'] . "' AND referpath='" . $pathfordb . "' AND date>'$past_hour' and ip='$ip'");
        }

        if ($xoopsDB->getRowsNum($resultrefer) > 0) {
            $row = $xoopsDB->fetchRow($resultrefer);
            $id  = $row[0];
            $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_refer') . " SET date='$now_refer', hits=hits+1 WHERE id='$id' && ip='$ip'");
        } else {
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_refer') . " (ip, refer, date, hits, referpath) VALUES ('$ip', '" . $dnsarray['host'] . "', '$now_refer', '1', '" . $pathfordb . "')");
        }
    }
}

function getGeneralStats()
{
    global $xoopsDB, $stats_secure_const, $xoopsStatConfig;

    /* Get the Browser data */
    $user_agent = $stats_secure_const['user_agent'];

    $botarray = $xoopsStatConfig['stats_botidentities'];
    if (!is_array($botarray)) { // make sure it's an array
        // something went wrong, initialize as an array
        $botarray = [];
    }

    $pipesepbots = '/' . implode('|', $botarray) . '/i';

    if (preg_match($pipesepbots, $user_agent)) {
        $browser = 'Bot';
    } elseif (preg_match('/Nav|Gold|X11|Netscape/', $user_agent) && (false === preg_match('/MSIE|Konqueror|Slurp|AppleWeb|Firefox|Firebird|Opera/', $user_agent))) {
        $browser = 'Netscape';
    } elseif (preg_match('/Opera/', $user_agent)) {
        $browser = 'Opera';
    } elseif (preg_match('/Lynx/', $user_agent)) {
        $browser = 'Lynx';
    } elseif (preg_match('/WebTV/', $user_agent)) {
        $browser = 'WebTV';
    } elseif (preg_match('/Konqueror/', $user_agent)) {
        $browser = 'Konqueror';
    } elseif (preg_match('/AppleWeb/', $user_agent)) {
        $browser = 'AppleWeb';
    } elseif (preg_match('/Firefox/', $user_agent)) {
        $browser = 'Firefox';
    } elseif (preg_match('/Deepnet/', $user_agent)) {
        $browser = 'Deepnet';
    } elseif (preg_match('/Avant/', $user_agent)) {
        $browser = 'Avant';
    } elseif (preg_match('/MSIE/', $user_agent)) {
        $browser = 'MSIE';
    } elseif (preg_match('/Mozilla/', $user_agent)) {
        $browser = 'Mozilla';
    } else {
        $browser = 'Other';
    }

    /* Get the Operating System data */

    if (preg_match('/Win/', $user_agent)) {
        $os = 'Windows';
    } elseif (preg_match('/Mac|PPC/', $user_agent)) {
        $os = 'Mac';
    } elseif (preg_match('/Linux/', $user_agent)) {
        $os = 'Linux';
    } elseif (preg_match('/FreeBSD/', $user_agent)) {
        $os = 'FreeBSD';
    } elseif (preg_match('/SunOS/', $user_agent)) {
        $os = 'SunOS';
    } elseif (preg_match('/IRIX/', $user_agent)) {
        $os = 'IRIX';
    } elseif (preg_match('/BeOS/', $user_agent)) {
        $os = 'BeOS';
    } elseif (preg_match('/OS/2/', $user_agent)) {
        $os = 'OS/2';
    } elseif (preg_match('/AIX/', $user_agent)) {
        $os = 'AIX';
    } else {
        $os = 'Other';
    }

    /* Save the obtained values */
    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('counter') . " SET count=count+1 WHERE (type='total' AND var='hits') OR (var='$browser' AND type='browser') OR (var='$os' AND type='os')");

    /* Start Detailed Statistics */

    $dot        = date('d-m-Y-H');
    $now        = explode('-', $dot);
    $nowHour    = $now[3];
    $nowYear    = $now[2];
    $nowMonth   = $now[1];
    $nowDate    = $now[0];
    $sql        = 'SELECT year FROM ' . $xoopsDB->prefix('stats_year') . " WHERE year='$nowYear'";
    $resultyear = $xoopsDB->queryF($sql);
    $jml        = $xoopsDB->getRowsNum($resultyear);
    if ($jml <= 0) {
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('stats_year') . " VALUES ('$nowYear','0')";
        $xoopsDB->queryF($sql);
        for ($i = 1; $i <= 12; ++$i) {
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_month') . " VALUES ('$nowYear','$i','0')");
            if (1 == $i) {
                $TotalDay = 31;
            }
            if (2 == $i) {
                if (true === date('L')) {
                    $TotalDay = 29;
                } else {
                    $TotalDay = 28;
                }
            }
            if (3 == $i) {
                $TotalDay = 31;
            }
            if (4 == $i) {
                $TotalDay = 30;
            }
            if (5 == $i) {
                $TotalDay = 31;
            }
            if (6 == $i) {
                $TotalDay = 30;
            }
            if (7 == $i) {
                $TotalDay = 31;
            }
            if (8 == $i) {
                $TotalDay = 31;
            }
            if (9 == $i) {
                $TotalDay = 30;
            }
            if (10 == $i) {
                $TotalDay = 31;
            }
            if (11 == $i) {
                $TotalDay = 30;
            }
            if (12 == $i) {
                $TotalDay = 31;
            }
            for ($k = 1; $k <= $TotalDay; ++$k) {
                $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_date') . " VALUES ('$nowYear','$i','$k','0')");
            }
        }
    }

    $sql     = 'SELECT hour FROM ' . $xoopsDB->prefix('stats_hour') . " WHERE (year='$nowYear') AND (month='$nowMonth') AND (date='$nowDate')";
    $result  = $xoopsDB->queryF($sql);
    $numrows = $xoopsDB->getRowsNum($result);

    if ($numrows <= 0) {
        for ($z = 0; $z <= 23; ++$z) {
            $xoopsDB->queryF('INSERT INTO ' . $xoopsDB->prefix('stats_hour') . " VALUES ('$nowYear','$nowMonth','$nowDate','$z','0')");
        }
    }

    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_year') . " SET hits=hits+1 WHERE year='$nowYear'");
    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_month') . " SET hits=hits+1 WHERE (year='$nowYear') AND (month='$nowMonth')");
    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_date') . " SET hits=hits+1 WHERE (year='$nowYear') AND (month='$nowMonth') AND (date='$nowDate')");
    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_hour') . " SET hits=hits+1 WHERE (year='$nowYear') AND (month='$nowMonth') AND (date='$nowDate') AND (hour='$nowHour')");
}

function getScreenDims()
{
    global $xoopsDB;

    $sw = isset($_COOKIE['sw']) ? $_COOKIE['sw'] : '';
    $sc = isset($_COOKIE['sc']) ? $_COOKIE['sc'] : '';

    /**
     * @feature
     * Keeps track of visitors screen size ie 800x600
     */
    // update screen width
    if ('' != $sw) {
        switch ($sw) {
            case '640':
                $sw_id = 1;
                break;

            case '800':
                $sw_id = 2;
                break;

            case '1024':
                $sw_id = 3;
                break;

            case '1152':
                $sw_id = 4;
                break;

            case '1280':
                $sw_id = 5;
                break;

            case '1600':
                $sw_id = 6;
                break;

            default:
                $sw_id = 7;
                break;
        }

        $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_userscreen') . " SET hits=hits+1 WHERE id='$sw_id'");
    }

    /**
     * @feature
     * Keeps track of visitors screen colour depth
     */
    // update screen color
    if ('' != $sc) {
        switch ($sc) {
            case '8':
                $sc_id = 1;
                break;

            case '16':
                $sc_id = 2;
                break;

            case '24':
                $sc_id = 3;
                break;

            case '32':
                $sc_id = 4;
                break;

            default:
                $sc_id = 5;
                break;
        }

        $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('stats_usercolor') . " SET hits=hits+1 WHERE id='$sc_id'");
    }
}

/*******************************/
/* BEGIN FUNCTIONS             */
/*******************************/
function stats_getservervar($var)
{
    if (isset($_SERVER[$var])) {
        return $_SERVER[$var];
    } elseif (isset($HTTP_SERVER_VARS[$var])) {
        return $HTTP_SERVER_VARS[$var];
    } elseif (getenv($var)) {
        return getenv($var);
    } else {
        return 'none';
    }
}

function get_remote_port()
{
    return stats_getservervar('REMOTE_PORT');
}

function get_request_method()
{
    return stats_getservervar('REQUEST_METHOD');
}

function get_script_name()
{
    return stats_getservervar('SCRIPT_NAME');
}

function get_http_host()
{
    return stats_getservervar('HTTP_HOST');
}

function st_clean_string($cleanstring)
{
    $st_fr1      = [
        '%25',
        '%00',
        '%01',
        '%02',
        '%03',
        '%04',
        '%05',
        '%06',
        '%07',
        '%08',
        '%09',
        '%0A',
        '%0B',
        '%0C',
        '%0D',
        '%0E',
        '%0F',
        '%10',
        '%11',
        '%12',
        '%13',
        '%14',
        '%15',
        '%16',
        '%17',
        '%18',
        '%19',
        '%1A',
        '%1B',
        '%1C',
        '%1D',
        '%1E',
        '%1F'
    ];
    $st_to1      = [
        '%',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        ''
    ];
    $st_fr2      = [
        '%20',
        '%21',
        '%22',
        '%23',
        '%24',
        '%25',
        '%26',
        '%27',
        '%28',
        '%29',
        '%2A',
        '%2B',
        '%2C',
        '%2D',
        '%2E',
        '%2F',
        '%30',
        '%31',
        '%32',
        '%33',
        '%34',
        '%35',
        '%36',
        '%37',
        '%38',
        '%39',
        '%3A',
        '%3B',
        '%3C',
        '%3D',
        '%3E',
        '%3F'
    ];
    $st_to2      = [
        ' ',
        '!',
        '"',
        '#',
        '$',
        '%',
        '&',
        "'",
        '(',
        ')',
        '*',
        '+',
        ',',
        '-',
        '.',
        '/',
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        ':',
        ';',
        '<',
        '=',
        '>',
        '?'
    ];
    $st_fr3      = [
        '%40',
        '%41',
        '%42',
        '%43',
        '%44',
        '%45',
        '%46',
        '%47',
        '%48',
        '%49',
        '%4A',
        '%4B',
        '%4C',
        '%4D',
        '%4E',
        '%4F',
        '%50',
        '%51',
        '%52',
        '%53',
        '%54',
        '%55',
        '%56',
        '%57',
        '%58',
        '%59',
        '%5A',
        '%5B',
        '%5C',
        '%5D',
        '%5E',
        '%5F'
    ];
    $st_to3      = [
        '@',
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z',
        '[',
        "\\",
        ']',
        '^',
        '_'
    ];
    $st_fr4      = [
        '%60',
        '%61',
        '%62',
        '%63',
        '%64',
        '%65',
        '%66',
        '%67',
        '%68',
        '%69',
        '%6A',
        '%6B',
        '%6C',
        '%6D',
        '%6E',
        '%6F',
        '%70',
        '%71',
        '%72',
        '%73',
        '%74',
        '%75',
        '%76',
        '%77',
        '%78',
        '%79',
        '%7A',
        '%7B',
        '%7C',
        '%7D',
        '%7E',
        '%7F'
    ];
    $st_to4      = [
        '`',
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g',
        'h',
        'i',
        'j',
        'k',
        'l',
        'm',
        'n',
        'o',
        'p',
        'q',
        'r',
        's',
        't',
        'u',
        'v',
        'w',
        'x',
        'y',
        'z',
        '{',
        '|',
        '}',
        '`',
        ''
    ];
    $cleanstring = str_replace($st_fr1, $st_to1, $cleanstring);
    $cleanstring = str_replace($st_fr2, $st_to2, $cleanstring);
    $cleanstring = str_replace($st_fr3, $st_to3, $cleanstring);
    $cleanstring = str_replace($st_fr4, $st_to4, $cleanstring);

    return $cleanstring;
}

function get_query_string()
{
    if (isset($_SERVER['QUERY_STRING'])) {
        return str_replace('%09', '%20', $_SERVER['QUERY_STRING']);
    } elseif (isset($HTTP_SERVER_VARS['QUERY_STRING'])) {
        return str_replace('%09', '%20', $HTTP_SERVER_VARS['QUERY_STRING']);
    } elseif (getenv('QUERY_STRING')) {
        return str_replace('%09', '%20', getenv('QUERY_STRING'));
    } else {
        return 'none';
    }
}

function get_get_string()
{
    $getstring = '';
    if (isset($_GET)) {
        $ST_GET = $_GET;
    } elseif (isset($HTTP_GET_VARS)) {
        $ST_GET = $HTTP_GET_VARS;
    } elseif (getenv('GET')) {
        $ST_GET = getenv('GET');
    } else {
        $ST_GET = '';
    }
    foreach ($ST_GET as $getkey => $getvalue) {
        if (!empty($getstring)) {
            $getstring .= '&' . $getkey . '=' . $getvalue;
        } else {
            $getstring .= $getkey . '=' . $getvalue;
        }
    }

    return str_replace('%09', '%20', $getstring);
}

function get_post_string()
{
    $poststring = '';
    if (isset($_POST)) {
        $ST_POST = $_POST;
    } elseif (isset($HTTP_POST_VARS)) {
        $ST_POST = $HTTP_POST_VARS;
    } elseif (getenv('POST')) {
        $ST_POST = getenv('POST');
    } else {
        $ST_POST = '';
    }
    foreach ($ST_POST as $postkey => $postvalue) {
        if (!empty($poststring)) {
            $poststring .= '&' . $postkey . '=' . $postvalue;
        } else {
            $poststring .= $postkey . '=' . $postvalue;
        }
    }

    return str_replace('%09', '%20', $poststring);
}

function get_user_agent()
{
    return stats_getservervar('HTTP_USER_AGENT');
}

function get_referer()
{
    return stats_getservervar('HTTP_REFERER');
}

function get_ip()
{
    global $stats_secure_const;
    if (strpos($stats_secure_const['client_ip'], ', ') && isset($stats_secure_const['client_ip'])) {
        $client_ips = explode(', ', $stats_secure_const['client_ip']);
        if ('unknown' !== $client_ips[0] && 'none' !== $client_ips[0] && !empty($client_ips[0]) && !is_reserved($client_ips[0])) {
            $stats_secure_const['client_ip'] = $client_ips[0];
        } else {
            $stats_secure_const['client_ip'] = $client_ips[1];
        }
    }
    if (strpos($stats_secure_const['forward_ip'], ', ') && isset($stats_secure_const['forward_ip'])) {
        $x_forwardeds = explode(', ', $stats_secure_const['forward_ip']);
        if ('unknown' !== $x_forwardeds[0] && 'none' !== $x_forwardeds[0] && !empty($x_forwardeds[0]) && !is_reserved($x_forwardeds[0])) {
            $stats_secure_const['forward_ip'] = $x_forwardeds[0];
        } else {
            $stats_secure_const['forward_ip'] = $x_forwardeds[1];
        }
    }
    if (strpos($stats_secure_const['remote_addr'], ', ') && isset($stats_secure_const['remote_addr'])) {
        $remote_addrs = explode(', ', $stats_secure_const['remote_addr']);
        if ('unknown' !== $remote_addrs[0] && 'none' !== $remote_addrs[0] && !empty($remote_addrs[0]) && !is_reserved($remote_addrs[0])) {
            $stats_secure_const['remote_addr'] = $remote_addrs[0];
        } else {
            $stats_secure_const['remote_addr'] = $remote_addrs[1];
        }
    }
    if (isset($stats_secure_const['client_ip']) && !stristr($stats_secure_const['client_ip'], 'none')
        && !stristr($stats_secure_const['client_ip'], 'unknown') /* && !is_reserved($stats_secure_const['client_ip']) */) {
        return $stats_secure_const['client_ip'];
    } elseif (isset($stats_secure_const['forward_ip']) && !stristr($stats_secure_const['forward_ip'], 'none')
              && !stristr($stats_secure_const['forward_ip'], 'unknown') /* && !is_reserved($stats_secure_const['forward_ip']) */) {
        return $stats_secure_const['forward_ip'];
    } elseif (isset($stats_secure_const['remote_addr']) && !stristr($stats_secure_const['remote_addr'], 'none')
              && !stristr($stats_secure_const['remote_addr'], 'unknown') /* && !is_reserved($stats_secure_const['remote_addr']) */) {
        return $stats_secure_const['remote_addr'];
    } else {
        return 'none';
    }
}

function get_server_ip()
{
    return stats_getservervar('SERVER_ADDR');
}

function get_client_ip()
{
    return stats_getservervar('HTTP_CLIENT_IP');
}

function get_x_forwarded()
{
    return stats_getservervar('HTTP_X_FORWARDED_FOR');
}

function get_remote_addr()
{
    return stats_getservervar('REMOTE_ADDR');
}

if (false === checkNoCountIP()) {
    getGeneralStats();
}

getRemoteAddr();
getRemoteReferer();
getScreenDims();

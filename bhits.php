<?php

include __DIR__ . '/../../mainfile.php';
$GLOBALS['xoopsOption']['template_main'] = 'hits.tpl';
include XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/statutils.php';

$now      = date('d-m-Y');
$dot      = explode('-', $now);
$nowdate  = $dot[0];
$nowmonth = $dot[1];
$nowyear  = $dot[2];

$xoopsTpl->assign('lang_stat_hitdetail', STATS_BHITDETAIL);
$xoopsTpl->assign('lang_stat_thissite', $_SERVER['HTTP_HOST']);

$result = $xoopsDB->queryF('SELECT count FROM ' . $xoopsDB->prefix('counter') . " WHERE type='totalblocked'");
list($count) = $xoopsDB->fetchRow($result);
$xoopsTpl->assign('lang_stat_recvtotal', $count);

$xoopsTpl->assign('lang_stat_werereceived', STATS_WERERECEIVED);
$xoopsTpl->assign('lang_stat_pageviews', STATS_BLOCKEDREQUESTS);
$xoopsTpl->assign('lang_stat_todayis', STATS_TODAYIS);
$xoopsTpl->assign('lang_stat_nowdate', "$nowmonth/$nowdate/$nowyear");

$result = $xoopsDB->queryF('SELECT year, month, hits FROM ' . $xoopsDB->prefix('stats_blockedmonth') . ' ORDER BY hits DESC LIMIT 0,1');
list($year, $month, $hits) = $xoopsDB->fetchRow($result);
$month = getMonth($month);
$xoopsTpl->assign('lang_stat_mostmonth', STATS_MOSTMONTH);
$xoopsTpl->assign('lang_stat_mmdata', "$month $year ($hits " . STATS_HITS . ')');

$result = $xoopsDB->queryF('SELECT year, month, date, hits FROM ' . $xoopsDB->prefix('stats_blockeddate') . ' ORDER BY hits DESC LIMIT 0,1');
list($year, $month, $date, $hits) = $xoopsDB->fetchRow($result);
$month = getMonth($month);
$xoopsTpl->assign('lang_stat_mostday', STATS_MOSTDAY);
$xoopsTpl->assign('lang_stat_mddata', "$month $date, $year ($hits " . STATS_HITS . ')');

$result = $xoopsDB->queryF('SELECT year, month, date, hour, hits FROM ' . $xoopsDB->prefix('stats_blockedhour') . ' ORDER BY hits DESC LIMIT 0,1');
list($year, $month, $date, $hour, $hits) = $xoopsDB->fetchRow($result);
$month = getMonth($month);
$hour  = ($hour < 10 ? "0$hour:00 - 0$hour:59" : "$hour:00 - $hour:59");
$xoopsTpl->assign('lang_stat_mosthour', STATS_MOSTHOUR);
$xoopsTpl->assign('lang_stat_mhdata', "$hour " . STATS_ON . " $month $date, $year ($hits " . STATS_HITS . ')');

$l_size = getimagesize('assets/images/leftbar.gif');
$m_size = getimagesize('assets/images/mainbar.gif');
$r_size = getimagesize('assets/images/rightbar.gif');

// get year stats and display
$resulttotal = $xoopsDB->queryF('SELECT sum(hits) AS totalhitsyear FROM ' . $xoopsDB->prefix('stats_blockedyear'));
list($totalhitsyear) = $xoopsDB->fetchRow($resulttotal);
$xoopsDB->freeRecordSet($resulttotal);
$result = $xoopsDB->queryF('SELECT year,hits FROM ' . $xoopsDB->prefix('stats_blockedyear') . ' ORDER BY year');
$xoopsTpl->assign('lang_stat_yearlystats', STATS_BLOCKEDYEARLYSTATS);
$xoopsTpl->assign('lang_stat_yearhead', STATS_YEAR);
$xoopsTpl->assign('lang_stat_pagesviewed', STATS_BLOCKEDPAGES);
$yearlist = [];
$i        = 0;
while (list($year, $hits) = $xoopsDB->fetchRow($result)) {
    $yearlist[$i]['year'] = $year;
    $yearlist[$i]['hits'] = $hits;
    if ($year != $nowyear) {
        $yearlist[$i]['link'] = "<a href=\"statdetails.php?op=b_yearlystats&amp;year=$year\">$year</a>";
    } else {
        $yearlist[$i]['link'] = '';
    }
    $midbarsize              = substr(100 * $hits / $count, 0, 5);
    $yearlist[$i]['percent'] = $midbarsize . '%';
    $yearlist[$i]['graph']   = "<img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"$year - $hits\"><img src=\"assets/images/mainbar.gif\" Alt=\"$year - $hits\" height=\"$m_size[1]\" width=\"$midbarsize\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"$year - $hits\">";
    ++$i;
}
$xoopsDB->freeRecordSet($result);
$xoopsTpl->assign('yearlist', $yearlist);

getBlockedMonthlyStats($nowyear);
getBlockedDailyStats($nowyear, $nowmonth);
getBlockedHourlyStats($nowyear, $nowmonth, $nowdate);

include XOOPS_ROOT_PATH . '/footer.php';

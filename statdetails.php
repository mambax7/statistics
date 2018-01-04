<?php

include __DIR__ . '/../../mainfile.php';
include __DIR__ . '/include/statutils.php';

if (!isset($HTTP_POST_VARS['op'])) {
    $op = isset($HTTP_GET_VARS['op']) ? $HTTP_GET_VARS['op'] : 'main';
} else {
    $op = $HTTP_POST_VARS['op'];
}
if (isset($HTTP_GET_VARS['year'])) {
    $year = $HTTP_GET_VARS['year'];
}
if (isset($HTTP_GET_VARS['month'])) {
    $month = $HTTP_GET_VARS['month'];
}
if (isset($HTTP_GET_VARS['date'])) {
    $date = $HTTP_GET_VARS['date'];
}

include XOOPS_ROOT_PATH . '/header.php';

function statDetails($op, $year, $month, $date)
{
    global $xoopsTpl, $xoopsOption;

    $xoopsTpl->assign('lang_stat_thissite', $_SERVER['HTTP_HOST']);

    $l_size = getimagesize('assets/images/leftbar.gif');
    $m_size = getimagesize('assets/images/mainbar.gif');
    $r_size = getimagesize('assets/images/rightbar.gif');

    switch ($op) {
        case b_yearlystats:
            $GLOBALS['xoopsOption']['template_main'] = 'y_statdetails.tpl';
            $xoopsTpl->assign('lang_stat_hitdetail', STATS_BHITDETAIL);
            getBlockedMonthlyStats($year);
            break;

        case b_monthlystats:
            $GLOBALS['xoopsOption']['template_main'] = 'm_statdetails.tpl';
            $xoopsTpl->assign('lang_stat_hitdetail', STATS_BHITDETAIL);
            getBlockedDailyStats($year, $month);
            break;

        case b_dailystats:
            $GLOBALS['xoopsOption']['template_main'] = 'd_statdetails.tpl';
            $xoopsTpl->assign('lang_stat_hitdetail', STATS_BHITDETAIL);
            getBlockedHourlyStats($year, $month, $date);
            break;

        case yearlystats:
            $GLOBALS['xoopsOption']['template_main'] = 'y_statdetails.tpl';
            $xoopsTpl->assign('lang_stat_hitdetail', STATS_HITDETAIL);
            getMonthlyStats($year);
            break;

        case monthlystats:
            $GLOBALS['xoopsOption']['template_main'] = 'm_statdetails.tpl';
            $xoopsTpl->assign('lang_stat_hitdetail', STATS_HITDETAIL);
            getDailyStats($year, $month);
            break;

        case dailystats:
            $GLOBALS['xoopsOption']['template_main'] = 'd_statdetails.tpl';
            $xoopsTpl->assign('lang_stat_hitdetail', STATS_HITDETAIL);
            getHourlyStats($year, $month, $date);
            break;

        default:
            $GLOBALS['xoopsOption']['template_main'] = 'statdetails.tpl';
            $xoopsTpl->assign('lang_stat_invalidoperation', STATS_INVALIDOPERATION);
            break;
    }
}

statDetails($op, $year, $month, $date);

include XOOPS_ROOT_PATH . '/footer.php';

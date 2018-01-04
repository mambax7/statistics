<?php
function getMonthlyStats($year)
{
    global $xoopsDB, $xoopsTpl;

    $now      = date('d-m-Y');
    $dot      = explode('-', $now);
    $nowmonth = $dot[1];

    $l_size = getimagesize('assets/images/leftbar.gif');
    $m_size = getimagesize('assets/images/mainbar.gif');
    $r_size = getimagesize('assets/images/rightbar.gif');

    // get monthly stats and display
    $resultmonth = $xoopsDB->queryF('select sum(hits) as totalhitsmonth from ' . $xoopsDB->prefix('stats_month') . " where year='$year'");
    list($totalhitsmonth) = $xoopsDB->fetchRow($resultmonth);
    $xoopsDB->freeRecordSet($resultmonth);
    $result = $xoopsDB->queryF('select month,hits from ' . $xoopsDB->prefix('stats_month') . " where year='$year'");
    $xoopsTpl->assign('lang_stat_monthlystats', STATS_MONTHLYSTATS . '&nbsp;-&nbsp;' . $year);
    $xoopsTpl->assign('lang_stat_monthhead', STATS_MONTH);
    $resulttotal = $xoopsDB->queryF('select hits from ' . $xoopsDB->prefix('stats_year') . " where year='$year'");
    list($hitsforyear) = $xoopsDB->fetchRow($resulttotal);
    $monthlist = [];
    $i         = 0;
    while (list($month, $hits) = $xoopsDB->fetchRow($result)) {
        $monthlist[$i]['month'] = getMonth($month);
        $monthlist[$i]['hits']  = $hits;
        if ($month != $nowmonth) {
            $monthlist[$i]['link'] = "<a href=\"statdetails.php?op=monthlystats&year=$year&month=$month\">" . $monthlist[$i]['month'] . '</a>';
        } else {
            $monthlist[$i]['link'] = '';
        }

        $midbarsize               = substr(100 * $hits / $hitsforyear, 0, 5);
        $monthlist[$i]['percent'] = $midbarsize . '%';
        $m_name                   = getMonth($month);
        $monthlist[$i]['graph']   = "<img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"$m_name - $hits\"><img src=\"assets/images/mainbar.gif\" Alt=\"$m_name - $hits\" height=\"$m_size[1]\" width=\"$midbarsize\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"$m_name - $hits\">";
        ++$i;
    }
    $xoopsDB->freeRecordSet($result);
    $xoopsTpl->assign('monthlist', $monthlist);
}

function getDailyStats($year, $month)
{
    global $xoopsDB, $xoopsTpl;

    $now     = date('d-m-Y');
    $dot     = explode('-', $now);
    $nowdate = $dot[0];

    $l_size = getimagesize('assets/images/leftbar.gif');
    $m_size = getimagesize('assets/images/mainbar.gif');
    $r_size = getimagesize('assets/images/rightbar.gif');

    // get the daily stats and show
    $resulttotal = $xoopsDB->queryF('select sum(hits) as totalhitsdate from ' . $xoopsDB->prefix('stats_date') . " where year='$year' and month='$month'");
    list($totalhitsdate) = $xoopsDB->fetchRow($resulttotal);
    $xoopsDB->freeRecordSet($resulttotal);
    $result = $xoopsDB->queryF('select year,month,date,hits from ' . $xoopsDB->prefix('stats_date') . " where year='$year' and month='$month' order by date");
    $total  = $xoopsDB->getRowsNum($result);
    $xoopsTpl->assign('lang_stat_dailystats', STATS_DAILYSTATS . '&nbsp;-&nbsp;' . getMonth($month) . '&nbsp;-&nbsp;' . $year);
    $xoopsTpl->assign('lang_stat_dailyhead', STATS_DAILY);
    $dailylist = [];
    $i         = 0;
    while (list($year, $month, $date, $hits) = $xoopsDB->fetchRow($result)) {
        $dailylist[$i]['year']  = $year;
        $dailylist[$i]['month'] = getMonth($month);
        $dailylist[$i]['date']  = $date;
        $dailylist[$i]['hits']  = $hits;
        if ($date != $nowdate) {
            $dailylist[$i]['link'] = "<a href=\"statdetails.php?op=dailystats&year=$year&month=$month&date=$date\">" . $date . '</a>';
        } else {
            $dailylist[$i]['link'] = '';
        }
        $midbarsize               = substr(100 * $hits / $totalhitsdate, 0, 5);
        $dailylist[$i]['percent'] = $midbarsize . '%';
        $dailylist[$i]['graph']   = "<img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"$date - $hits\"><img src=\"assets/images/mainbar.gif\" Alt=\"$date - $hits\" height=\"$m_size[1]\" width=\"$midbarsize\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"$date - $hits\">";
        ++$i;
    }
    $xoopsDB->freeRecordSet($result);
    $xoopsTpl->assign('dailylist', $dailylist);
}

function getHourlyStats($year, $month, $date)
{
    global $xoopsDB, $xoopsTpl;

    $l_size = getimagesize('assets/images/leftbar.gif');
    $m_size = getimagesize('assets/images/mainbar.gif');
    $r_size = getimagesize('assets/images/rightbar.gif');

    $now = date('d-m-Y');

    // show hourly stats and display
    $resulttotal = $xoopsDB->queryF('select sum(hits) as totalhitshour from ' . $xoopsDB->prefix('stats_hour') . " where year='$year' and month='$month' and date='$date'");
    list($totalhitshour) = $xoopsDB->fetchRow($resulttotal);
    $xoopsDB->freeRecordSet($resulttotal);
    $date_arr = explode('-', $now);
    $xoopsTpl->assign('lang_stat_hourlystats', STATS_HOURLYSTATS . '&nbsp;-&nbsp;' . getMonth($month) . '&nbsp;' . $date . '&nbsp;' . $year);
    $xoopsTpl->assign('lang_stat_hourlyhead', STATS_HOURLY);
    $hourlist = [];

    for ($k = 0; $k <= 23; ++$k) {
        $result = $xoopsDB->queryF('select hour,hits from ' . $xoopsDB->prefix('stats_hour') . " where year='$year' and month='$month' and date='$date' and hour='$k'");
        if (0 == $xoopsDB->getRowsNum($result)) {
            $hits = 0;
            $hour = $k;
        } else {
            list($hour, $hits) = $xoopsDB->fetchRow($result);
        }

        $a                    = (($k < 10) ? "0$k" : $k);
        $hourlist[$k]['hour'] = "$a:00 - $a:59";

        $a = '';

        $midbarsize              = ((0 == $hits) ? 0 : substr(100 * $hits / $totalhitshour, 0, 5));
        $hourlist[$k]['hits']    = $hits;
        $hourlist[$k]['percent'] = $midbarsize . '%';
        $hourlist[$k]['graph']   = "<img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"$hour - $hits\"><img src=\"assets/images/mainbar.gif\" Alt=\"$hour - $hits\" height=\"$m_size[1]\" width=\"$midbarsize\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"$hour - $hits\">";
    }

    $xoopsDB->freeRecordSet($result);
    $xoopsTpl->assign('hourlist', $hourlist);
}

function getBlockedMonthlyStats($year)
{
    global $xoopsDB, $xoopsTpl;

    $now      = date('d-m-Y');
    $dot      = explode('-', $now);
    $nowmonth = $dot[1];

    $l_size = getimagesize('assets/images/leftbar.gif');
    $m_size = getimagesize('assets/images/mainbar.gif');
    $r_size = getimagesize('assets/images/rightbar.gif');

    // get monthly stats and display
    $resultmonth = $xoopsDB->queryF('select sum(hits) as totalhitsmonth from ' . $xoopsDB->prefix('stats_blockedmonth') . " where year='$year'");
    list($totalhitsmonth) = $xoopsDB->fetchRow($resultmonth);
    $xoopsDB->freeRecordSet($resultmonth);
    $result = $xoopsDB->queryF('select month,hits from ' . $xoopsDB->prefix('stats_blockedmonth') . " where year='$year'");
    $xoopsTpl->assign('lang_stat_monthlystats', STATS_BLOCKEDMONTHLYSTATS . '&nbsp;-&nbsp;' . $year);
    $xoopsTpl->assign('lang_stat_monthhead', STATS_MONTH);
    $resulttotal = $xoopsDB->queryF('select hits from ' . $xoopsDB->prefix('stats_blockedyear') . " where year='$year'");
    list($hitsforyear) = $xoopsDB->fetchRow($resulttotal);
    $monthlist = [];
    $i         = 0;
    while (list($month, $hits) = $xoopsDB->fetchRow($result)) {
        $monthlist[$i]['month'] = getMonth($month);
        $monthlist[$i]['hits']  = $hits;
        if ($month != $nowmonth) {
            $monthlist[$i]['link'] = "<a href=\"statdetails.php?op=b_monthlystats&year=$year&month=$month\">" . $monthlist[$i]['month'] . '</a>';
        } else {
            $monthlist[$i]['link'] = '';
        }

        $midbarsize               = substr(100 * $hits / $hitsforyear, 0, 5);
        $monthlist[$i]['percent'] = $midbarsize . '%';
        $m_name                   = getMonth($month);
        $monthlist[$i]['graph']   = "<img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"$m_name - $hits\"><img src=\"assets/images/mainbar.gif\" Alt=\"$m_name - $hits\" height=\"$m_size[1]\" width=\"$midbarsize\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"$m_name - $hits\">";
        ++$i;
    }
    $xoopsDB->freeRecordSet($result);
    $xoopsTpl->assign('monthlist', $monthlist);
}

function getBlockedDailyStats($year, $month)
{
    global $xoopsDB, $xoopsTpl;

    $now     = date('d-m-Y');
    $dot     = explode('-', $now);
    $nowdate = $dot[0];

    $l_size = getimagesize('assets/images/leftbar.gif');
    $m_size = getimagesize('assets/images/mainbar.gif');
    $r_size = getimagesize('assets/images/rightbar.gif');

    // get the daily stats and show
    $resulttotal = $xoopsDB->queryF('select sum(hits) as totalhitsdate from ' . $xoopsDB->prefix('stats_blockeddate') . " where year='$year' and month='$month'");
    list($totalhitsdate) = $xoopsDB->fetchRow($resulttotal);
    $xoopsDB->freeRecordSet($resulttotal);
    $result = $xoopsDB->queryF('select year,month,date,hits from ' . $xoopsDB->prefix('stats_blockeddate') . " where year='$year' and month='$month' order by date");
    $total  = $xoopsDB->getRowsNum($result);
    $xoopsTpl->assign('lang_stat_dailystats', STATS_BLOCKEDDAILYSTATS . '&nbsp;-&nbsp;' . getMonth($month) . '&nbsp;-&nbsp;' . $year);
    $xoopsTpl->assign('lang_stat_dailyhead', STATS_DAILY);
    $dailylist = [];
    $i         = 0;
    while (list($year, $month, $date, $hits) = $xoopsDB->fetchRow($result)) {
        $dailylist[$i]['year']  = $year;
        $dailylist[$i]['month'] = getMonth($month);
        $dailylist[$i]['date']  = $date;
        $dailylist[$i]['hits']  = $hits;
        if ($date != $nowdate) {
            $dailylist[$i]['link'] = "<a href=\"statdetails.php?op=b_dailystats&year=$year&month=$month&date=$date\">" . $date . '</a>';
        } else {
            $dailylist[$i]['link'] = '';
        }
        $midbarsize               = substr(100 * $hits / $totalhitsdate, 0, 5);
        $dailylist[$i]['percent'] = $midbarsize . '%';
        $dailylist[$i]['graph']   = "<img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"$date - $hits\"><img src=\"assets/images/mainbar.gif\" Alt=\"$date - $hits\" height=\"$m_size[1]\" width=\"$midbarsize\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"$date - $hits\">";
        ++$i;
    }
    $xoopsDB->freeRecordSet($result);
    $xoopsTpl->assign('dailylist', $dailylist);
}

function getBlockedHourlyStats($year, $month, $date)
{
    global $xoopsDB, $xoopsTpl;

    $l_size = getimagesize('assets/images/leftbar.gif');
    $m_size = getimagesize('assets/images/mainbar.gif');
    $r_size = getimagesize('assets/images/rightbar.gif');

    $now = date('d-m-Y');

    // show hourly stats and display
    $resulttotal = $xoopsDB->queryF('select sum(hits) as totalhitshour from ' . $xoopsDB->prefix('stats_blockedhour') . " where year='$year' and month='$month' and date='$date'");
    list($totalhitshour) = $xoopsDB->fetchRow($resulttotal);
    $xoopsDB->freeRecordSet($resulttotal);
    $date_arr = explode('-', $now);
    $xoopsTpl->assign('lang_stat_hourlystats', STATS_BLOCKEDHOURLYSTATS . '&nbsp;-&nbsp;' . getMonth($month) . '&nbsp;' . $date . '&nbsp;' . $year);
    $xoopsTpl->assign('lang_stat_hourlyhead', STATS_HOURLY);
    $hourlist = [];

    for ($k = 0; $k <= 23; ++$k) {
        $result = $xoopsDB->queryF('select hour,hits from ' . $xoopsDB->prefix('stats_blockedhour') . " where year='$year' and month='$month' and date='$date' and hour='$k'");
        if (0 == $xoopsDB->getRowsNum($result)) {
            $hits = 0;
            $hour = $k;
        } else {
            list($hour, $hits) = $xoopsDB->fetchRow($result);
        }

        $a                    = (($k < 10) ? "0$k" : $k);
        $hourlist[$k]['hour'] = "$a:00 - $a:59";

        $a = '';

        $midbarsize              = ((0 == $hits) ? 0 : substr(100 * $hits / $totalhitshour, 0, 5));
        $hourlist[$k]['hits']    = $hits;
        $hourlist[$k]['percent'] = $midbarsize . '%';
        $hourlist[$k]['graph']   = "<img src=\"assets/images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"$hour - $hits\"><img src=\"assets/images/mainbar.gif\" Alt=\"$hour - $hits\" height=\"$m_size[1]\" width=\"$midbarsize\"><img src=\"assets/images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"$hour - $hits\">";
    }

    $xoopsDB->freeRecordSet($result);
    $xoopsTpl->assign('hourlist', $hourlist);
}

function getMonth($month)
{
    switch ($month) {
        case 1:
            return STATS_JANUARY;

        case 2:
            return STATS_FEBRUARY;

        case 3:
            return STATS_MARCH;

        case 4:
            return STATS_APRIL;

        case 5:
            return STATS_MAY;

        case 6:
            return STATS_JUNE;

        case 7:
            return STATS_JULY;

        case 8:
            return STATS_AUGUST;

        case 9:
            return STATS_SEPTEMBER;

        case 10:
            return STATS_OCTOBER;

        case 11:
            return STATS_NOVEMBER;

        default:
            return STATS_DECEMBER;
    }
}

/**
 * adminmenu()
 *
 * @param  string      $header optional : You can gice the menu a nice header
 * @param  string      $extra  optional : You can gice the menu a nice footer
 * @param array|string $menu   required : This is an array of links. U can
 * @param  int         $scount required : This will difine the amount of cells long the menu will have.
 *                             NB: using a value of 3 at the moment will break the menu where the cell colours will be off display.
 * @return THIS ONE WORKS CORRECTLY
 */
function stats_adminmenu($header = '', $extra = '', $menu = '', $scount = 4)
{
    global $xoopsConfig, $xoopsModule;

    if (empty($menu)) {
        /**
         * You can change this part to suit your own module. Defining this here will save you form having to do this each time.
         */

        $menu = [
            STATS_ADMENU1  => XOOPS_URL . '/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid'),
            STATS_ADMENU2  => 'index.php?op=' . INFO_GENERAL,
            STATS_ADMENU3  => 'index.php?op=' . INFO_CREDITS,
            STATS_ADMENU4  => 'index.php?op=' . INFO_CONFIGURATION,
            STATS_ADMENU5  => 'index.php?op=' . INFO_MODULES,
            STATS_ADMENU6  => 'index.php?op=' . INFO_ENVIRONMENT,
            STATS_ADMENU7  => 'index.php?op=' . INFO_VARIABLES,
            STATS_ADMENU8  => 'index.php?op=' . INFO_LICENSE,
            STATS_ADMENU9  => 'index.php?op=' . INFO_ALL,
            STATS_ADMENU10 => 'index.php?op=remote_addr',
            STATS_ADMENU11 => 'index.php?op=refer',
            STATS_ADMENU12 => 'index.php?op=userscreen',
        ];
    }

    $oddnum = [1 => '1', 3 => '3', 5 => '5', 7 => '7', 9 => '9', 11 => '11', 13 => '13'];

    /**
     * the amount of cells per menu row
     */
    $count = 0;
    /**
     * Set up the first class
     */
    $class = 'even';
    /**
     * Sets up the width of each menu cell
     */

    echo '<h3>' . $header . '</h3>';
    echo "<table width = '100%' cellpadding= '2' cellspacing= '1' class='outer'><tr>";

    /**
     * Check to see if $menu is and array
     */
    if (is_array($menu)) {
        foreach ($menu as $menutitle => $menulink) {
            ++$count;
            $width = 100 / $scount;
            $width = round($width);
            /**
             * Menu table begin
             */
            echo "<td class='$class' align='center' valign='middle' width= $width%>";
            echo "<a href='" . $menulink . "'>" . $menutitle . '</a></td>';

            /**
             * Break menu cells to start a new row if $count > $scount
             */
            if ($count >= $scount) {
                /**
                 * If $class is the same for the end and start cells, invert $class
                 */
                $class = ('odd' == $class && in_array($count, $oddnum)) ? 'even' : 'odd';
                echo '</tr>';
                $count = 0;
            } else {
                $class = ('even' == $class) ? 'odd' : 'even';
            }
        }
        /**
         * checks to see if there are enough cell to fill menu row, if not add empty cells
         */
        if ($count >= 1) {
            $counter = 0;
            while ($counter < $scount - $count) {
                echo '<td class="' . $class . '">&nbsp;</td>';
                $class = ('even' == $class) ? 'odd' : 'even';
                ++$counter;
            }
        }
        echo '</table><br>';
    }
    if ($extra) {
        echo "<div>$extra</div>";
    }
}

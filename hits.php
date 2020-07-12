<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
include_once "../../mainfile.php";
$xoopsOption['template_main'] = 'hits.html';
include XOOPS_ROOT_PATH."/header.php";
include_once "include/statutils.php";

$now = date("d-m-Y");
$dot = explode ("-",$now);
$nowdate = $dot[0];
$nowmonth = $dot[1];
$nowyear = $dot[2];

$xoopsTpl->assign('lang_stat_hitdetail', STATS_HITDETAIL );
$xoopsTpl->assign('lang_stat_thissite', $_SERVER['HTTP_HOST']);

$result = $xoopsDB->queryF("select count from ".$xoopsDB->prefix("counter")." where type='total'");
list($count) = $xoopsDB->fetchRow($result);
$xoopsTpl->assign('lang_stat_recvtotal', $count);

$xoopsTpl->assign('lang_stat_werereceived', STATS_WERERECEIVED );
$xoopsTpl->assign('lang_stat_pageviews', STATS_PAGEVIEWS );
$xoopsTpl->assign('lang_stat_todayis', STATS_TODAYIS );
$xoopsTpl->assign('lang_stat_nowdate', "$nowmonth/$nowdate/$nowyear" );

$result = $xoopsDB->queryF("select year, month, hits from ".$xoopsDB->prefix("stats_month")." order by hits DESC limit 0,1");
list($year, $month, $hits) = $xoopsDB->fetchRow($result);
$month = getMonth( $month );
$xoopsTpl->assign('lang_stat_mostmonth', STATS_MOSTMONTH );
$xoopsTpl->assign('lang_stat_mmdata', "$month $year ($hits ".STATS_HITS.")" );

$result = $xoopsDB->queryF("select year, month, date, hits from ".$xoopsDB->prefix("stats_date")." order by hits DESC limit 0,1");
list($year, $month, $date, $hits) = $xoopsDB->fetchRow($result);
$month = getMonth($month);
$xoopsTpl->assign('lang_stat_mostday', STATS_MOSTDAY);
$xoopsTpl->assign('lang_stat_mddata', "$month $date, $year ($hits ".STATS_HITS.")" );

$result = $xoopsDB->queryF("select year, month, date, hour, hits from ".$xoopsDB->prefix("stats_hour")." order by hits DESC limit 0,1");
list($year, $month, $date, $hour, $hits) = $xoopsDB->fetchRow($result);
$month = getMonth($month);
$hour = ($hour < 10 ? "0$hour:00 - 0$hour:59" : "$hour:00 - $hour:59");
$xoopsTpl->assign('lang_stat_mosthour', STATS_MOSTHOUR );
$xoopsTpl->assign('lang_stat_mhdata', "$hour ".STATS_ON." $month $date, $year ($hits ".STATS_HITS.")" );

$l_size = getimagesize("images/leftbar.gif");
$m_size = getimagesize("images/mainbar.gif");
$r_size = getimagesize("images/rightbar.gif");

// get year stats and display
$resulttotal = $xoopsDB->queryF("select sum(hits) as totalhitsyear from ".$xoopsDB->prefix("stats_year"));
list($totalhitsyear) = $xoopsDB->fetchRow($resulttotal);
$xoopsDB->freeRecordSet($resulttotal);
$result = $xoopsDB->queryF("select year,hits from ".$xoopsDB->prefix("stats_year")." order by year");
$xoopsTpl->assign('lang_stat_yearlystats', STATS_YEARLYSTATS );
$xoopsTpl->assign('lang_stat_yearhead', STATS_YEAR );
$xoopsTpl->assign('lang_stat_pagesviewed', STATS_PAGESVIEWED );
$yearlist = array();
$i = 0;
while (list($year,$hits) = $xoopsDB->fetchRow($result))
{
  $yearlist[$i]['year'] = $year;
  $yearlist[$i]['hits'] = $hits;
  if ( $year != $nowyear )
  {
    $yearlist[$i]['link'] = "<a href=\"statdetails.php?op=yearlystats&amp;year=$year\">$year</a>";
  }
  else
  {
    $yearlist[$i]['link'] = "";
  }
  $midbarsize = substr(100 * $hits / $count, 0, 5);
  $yearlist[$i]['percent'] = $midbarsize."%";
  $yearlist[$i]['graph'] = "<img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"$year - $hits\"><img src=\"images/mainbar.gif\" Alt=\"$year - $hits\" height=\"$m_size[1]\" width=\"$midbarsize\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"$year - $hits\">";
  $i++;
}
$xoopsDB->freeRecordSet($result);
$xoopsTpl->assign('yearlist', $yearlist );

getMonthlyStats( $nowyear );
getDailyStats( $nowyear, $nowmonth );
getHourlyStats( $nowyear, $nowmonth, $nowdate );

include XOOPS_ROOT_PATH.'/footer.php';

?>

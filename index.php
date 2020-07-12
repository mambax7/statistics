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
$xoopsOption['template_main'] = 'statistics.html';
include XOOPS_ROOT_PATH."/header.php";

function mainStats()
{
    global $xoopsDB, $xoopsTpl;
	$count = 0;
	$result = $xoopsDB->queryF( "SELECT type, var, count from ".$xoopsDB->prefix('counter')." where type='total' and var='hits'");
	list( $type, $var, $count) = $xoopsDB->fetchRow( $result );
	$total = $count;
	
	$count = 0;
    $result = $xoopsDB->queryF( "SELECT type, var, count from ".$xoopsDB->prefix('counter')." where type='totalblocked' and var='hits'");
	list( $type, $var, $count) = $xoopsDB->fetchRow( $result );
	$totalblocked = $count;

$result = $xoopsDB->queryF("SELECT type, var, count from ".$xoopsDB->prefix('counter')." order by type desc");
while (list($type, $var, $count) = $xoopsDB->fetchRow($result) ) 
{
  if($type == "browser") 
  {
    if($var == "Netscape") 
	{
	  $netscape[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $netscape[] =  substr(100 * $percent, 0, 5);
	}
	elseif($var == "MSIE") 
	{
	  $msie[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $msie[] =  substr(100 * $percent, 0, 5);
	}
	elseif($var == "Konqueror") 
	{
	  $konqueror[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $konqueror[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "Opera") 
	{
	  $opera[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $opera[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "Lynx") 
	{
	  $lynx[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $lynx[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "Bot") 
	{
	  $bot[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $bot[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "AppleWeb") 
	{
	  $apple[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $apple[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "Firefox") 
	{
	  $firefox[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $firefox[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "Mozilla") 
	{
	  $mozilla[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $mozilla[] =  substr(100 * $percent, 0, 5);
	}
	elseif($var == "Deepnet")
	{
	  $deepnet[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $deepnet[] = substr(100 * $percent, 0, 5 );
	} 
	elseif($var == "Avant")
	{
	  $avant[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $avant[] = substr(100 * $percent, 0, 5 );
	} 
	elseif($var == "Other") 
	{
	  $b_other[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $b_other[] =  substr(100 * $percent, 0, 5);
	}
  } 
  elseif($type == "os") 
  {
    if($var == "Windows")
	{
	  $windows[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $windows[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "Mac") 
	{
	  $mac[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $mac[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "Linux") 
	{
	  $linux[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $linux[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "FreeBSD") 
	{
	  $freebsd[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $freebsd[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "SunOS") 
	{
	  $sunos[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $sunos[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "IRIX") 
	{
	  $irix[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $irix[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "BeOS") 
	{
	  $beos[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $beos[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "OS/2") 
	{
	  $os2[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $os2[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "AIX") 
	{
	  $aix[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $aix[] =  substr(100 * $percent, 0, 5);
	} 
	elseif($var == "Other") 
	{
	  $os_other[] = $count;
	  $percent = ( $total == 0 ? 0 : $count / $total );
	  $os_other[] =  substr(100 * $percent, 0, 5);
	}
  }
  elseif( $type == "blocked" )
  {
    if ( $var == "bots" )
	{
	  $blockedbots[] = $count;
	  $percent = ( $totalblocked == 0 ? 0 : $count / $totalblocked );
	  $blockedbots[] = substr( 100 * $percent, 0, 5 );
	}
	elseif( $var == "referers" )
	{
	  $blockedreferers[] = $count;
	  $percent = ( $totalblocked == 0 ? 0 : $count / $totalblocked );
	  $blockedreferers[] = substr( 100 * $percent, 0, 5 );
	}
  }
}

$l_size = getimagesize("images/leftbar.gif");
$m_size = getimagesize("images/mainbar.gif");
$r_size = getimagesize("images/rightbar.gif");

$xoopsTpl->assign('lang_stat_heading', STATS_HEADING);

$result = $xoopsDB->queryF("SELECT year, hits from ".$xoopsDB->prefix('stats_year'));
$yearhits = array();
$i = 0;
while (list($year, $hits) = $xoopsDB->fetchRow($result) ) 
{
  $yearhits[$i]['year'] = $year;
  $yearhits[$i]['hits'] = $hits;
  $i++;   
}
$xoopsTpl->assign('yearhits', $yearhits );
$xoopsTpl->assign('lang_stats_yearhits', STATS_YEARHITS );

$result = $xoopsDB->queryF("SELECT year, hits from ".$xoopsDB->prefix('stats_blockedyear'));
$byearhits = array();
$i = 0;
while (list($year, $hits) = $xoopsDB->fetchRow($result) ) 
{
  $byearhits[$i]['year'] = $year;
  $byearhits[$i]['hits'] = $hits;
  $i++;   
}
$xoopsTpl->assign('byearhits', $byearhits );
$xoopsTpl->assign('lang_stats_byearhits', STATS_BYEARHITS );

$xoopsTpl->assign('lang_stat_browser', STATS_BROWSERS);
$xoopsTpl->assign('lang_stat_thissite', $_SERVER['HTTP_HOST']);
$xoopsTpl->assign('lang_stat_useragent', $_SERVER['HTTP_USER_AGENT']);
$xoopsTpl->assign('lang_stat_uahead', STATS_USER_AGENT);
$xoopsTpl->assign('lang_stat_msie', "<tr><td><img src=\"images/explorer.gif\" border=\"0\" alt=\"\">MSIE:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Internet Explorer\"><img src=\"images/mainbar.gif\" Alt=\"Internet Explorer\" height=\"$m_size[1]\" width=\"$msie[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Internet Explorer\">$msie[1] % ($msie[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_netscape', "<tr><td><img src=\"images/netscape.gif\" border=\"0\" alt=\"\">Netscape:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Netscape\"><img src=\"images/mainbar.gif\" Alt=\"Netscape\" height=\"$m_size[1]\" width=\"$netscape[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Netscape\"> $netscape[1] % ($netscape[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_opera', "<tr><td><img src=\"images/opera.gif\" border=\"0\" alt=\"\">&nbsp;Opera: </td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Opera\"><img src=\"images/mainbar.gif\" Alt=\"Opera\" height=\"$m_size[1]\" width=\"$opera[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Opera\"> $opera[1] % ($opera[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_kon', "<tr><td><img src=\"images/konqueror.gif\" border=\"0\" alt=\"\">&nbsp;Konqueror: </td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Konqueror\"><img src=\"images/mainbar.gif\" Alt=\"Konqueror (KDE)\" height=\"$m_size[1]\" width=\"$konqueror[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Konqueror\"> $konqueror[1] % ($konqueror[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_lynx', "<tr><td><img src=\"images/lynx.gif\" border=\"0\" alt=\"\">&nbsp;Lynx: </td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Lynx\"><img src=\"images/mainbar.gif\" Alt=\"Lynx\" height=\"$m_size[1]\" width=\"$lynx[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Lynx\"> $lynx[1] % ($lynx[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_apple', "<tr><td><img src=\"images/apple.png\" border=\"0\" alt=\"\">&nbsp;AppleWebKit: </td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"AppleWebKit\"><img src=\"images/mainbar.gif\" Alt=\"AppleWebKit\" height=\"$m_size[1]\" width=\"$apple[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"AppleWebKit\"> $apple[1] % ($apple[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_firefox', "<tr><td><img src=\"images/firefox.png\" border=\"0\" alt=\"\">&nbsp;Firefox: </td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Firefox\"><img src=\"images/mainbar.gif\" Alt=\"Firefox\" height=\"$m_size[1]\" width=\"$firefox[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Firefox\"> $firefox[1] % ($firefox[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_mozilla', "<tr><td><img src=\"images/mozilla.png\" border=\"0\" alt=\"\">&nbsp;Mozilla: </td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Mozilla\"><img src=\"images/mainbar.gif\" Alt=\"Mozilla\" height=\"$m_size[1]\" width=\"$mozilla[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Mozilla\"> $mozilla[1] % ($mozilla[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_deepnet', "<tr><td><img src=\"images/deepnet.gif\" border=\"0\" alt=\"\">&nbsp;Deepnet: </td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Deepnet\"><img src=\"images/mainbar.gif\" Alt=\"Deepnet\" height=\"$m_size[1]\" width=\"$deepnet[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Deepnet\"> $deepnet[1] % ($deepnet[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_avant', "<tr><td><img src=\"images/avant.gif\" border=\"0\" alt=\"\">&nbsp;Avant: </td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Avant\"><img src=\"images/mainbar.gif\" Alt=\"Avant\" height=\"$m_size[1]\" width=\"$avant[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Avant\"> $avant[1] % ($avant[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_altavista', "<tr><td><img src=\"images/altavista.gif\" border=\"0\" alt=\"\">&nbsp;".STATS_SEARCHENGINES.": </td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Robots - Spiders - Buscadores\"><img src=\"images/mainbar.gif\" Alt=\"Robots - Spiders - Buscadores\" height=\"$m_size[1]\" width=\"$bot[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"".STATS_BOTS."\"> $bot[1] % ($bot[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_question', "<tr><td><img src=\"images/question.gif\" border=\"0\" alt=\"\">&nbsp;".STATS_UNKNOWN.": </td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Otros - Desconocidos\"><img src=\"images/mainbar.gif\" Alt=\"Otros - Desconocidos\" height=\"$m_size[1]\" width=\"$b_other[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"".STATS_OTHER."\"> $b_other[1] % ($b_other[0])" );
	
$xoopsTpl->assign('lang_stat_opersys', STATS_OPERATINGSYS );
$xoopsTpl->assign('lang_stat_windows', "<tr><td><img src=\"images/windows.gif\" border=\"0\" alt=\"\">Windows:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Windows\"><img src=\"images/mainbar.gif\" Alt=\"Windows\" height=\"$m_size[1]\" width=\"$windows[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Windows\"> $windows[1] % ($windows[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_linux', "<tr><td><img src=\"images/linux.gif\" border=\"0\" alt=\"\">Linux:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Linux\"><img src=\"images/mainbar.gif\" Alt=\"Linux\" height=\"$m_size[1]\" width=\"$linux[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Linux\"> $linux[1] % ($linux[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_mac', "<tr><td><img src=\"images/mac.gif\" border=\"0\" alt=\"\">Mac/PPC:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Mac/PPC\"><img src=\"images/mainbar.gif\" Alt=\"Mac - PPC\" height=\"$m_size[1]\" width=\"$mac[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Mac/PPC\"> $mac[1] % ($mac[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_bsd', "<tr><td><img src=\"images/bsd.gif\" border=\"0\" alt=\"\">FreeBSD:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"FreeBSD\"><img src=\"images/mainbar.gif\" Alt=\"FreeBSD\" height=\"$m_size[1]\" width=\"$freebsd[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"FreeBSD\"> $freebsd[1] % ($freebsd[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_sun', "<tr><td><img src=\"images/sun.gif\" border=\"0\" alt=\"\">SunOS:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"SunOS\"><img src=\"images/mainbar.gif\" Alt=\"SunOS\" height=\"$m_size[1]\" width=\"$sunos[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"SunOS\"> $sunos[1] % ($sunos[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_irix', "<tr><td><img src=\"images/irix.gif\" border=\"0\" alt=\"\">IRIX:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"SGI Irix\"><img src=\"images/mainbar.gif\" Alt=\"SGI Irix\" height=\"$m_size[1]\" width=\"$irix[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"SGI Irix\"> $irix[1] % ($irix[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_be', "<tr><td><img src=\"images/be.gif\" border=\"0\" alt=\"\">BeOS:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"BeOS\"><img src=\"images/mainbar.gif\" Alt=\"BeOS\" height=\"$m_size[1]\" width=\"$beos[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"BeOS\"> $beos[1] % ($beos[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_os2', "<tr><td><img src=\"images/os2.gif\" border=\"0\" alt=\"\">OS/2:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"OS/2\"><img src=\"images/mainbar.gif\" Alt=\"OS/2\" height=\"$m_size[1]\" width=\"$os2[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"OS/2\"> $os2[1] % ($os2[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_aix', "<tr><td><img src=\"images/aix.gif\" border=\"0\" alt=\"\">&nbsp;AIX:</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"AIX\"><img src=\"images/mainbar.gif\" Alt=\"AIX\" height=\"$m_size[1]\" width=\"$aix[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"AIX\"> $aix[1] % ($aix[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_osquestion', "<tr><td><img src=\"images/question.gif\" border=\"0\" alt=\"\">&nbsp;".STATS_UNKNOWN.":</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Otros - Desconocidos\"><img src=\"images/mainbar.gif\" ALt=\"Otros - Desconocidos\" height=\"$m_size[1]\" width=\"$os_other[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"".STATS_OTHER."\"> $os_other[1] % ($os_other[0])" );

$xoopsTpl->assign('lang_stat_blockedtype', STATS_BLOCKEDTYPE );
$xoopsTpl->assign('lang_stat_blockedbots', "<tr><td><img src=\"images/altavista.gif\" border=\"0\" alt=\"\">Bots:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Bots\"><img src=\"images/mainbar.gif\" Alt=\"Bots\" height=\"$m_size[1]\" width=\"$blockedbots[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Bots\"> $blockedbots[1] % ($blockedbots[0])</td></tr>" );
$xoopsTpl->assign('lang_stat_blockedreferers', "<tr><td><img src=\"images/explorer.gif\" border=\"0\" alt=\"\">Referers:&nbsp;</td><td><img src=\"images/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Referers\"><img src=\"images/mainbar.gif\" Alt=\"Referers\" height=\"$m_size[1]\" width=\"$blockedreferers[1] * 2\"><img src=\"images/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Referers\"> $blockedreferers[1] % ($blockedreferers[0])</td></tr>" );

$xoopsTpl->assign('lang_misc_stats', STATS_MISC );
$unum = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("users")));
$xoopsTpl->assign('lang_stats_regusers', STATS_REGUSERS );
$xoopsTpl->assign('lang_stats_users', $unum );

$usersonline = $xoopsDB->getRowsNum($xoopsDB->queryF( "select * from ".$xoopsDB->prefix("online")));
$xoopsTpl->assign('lang_stats_usersonline', STATS_USERS_ONLINE );
$xoopsTpl->assign('lang_stats_usersolcnt', $usersonline );

$authorscnt = $xoopsDB->getRowsNum( $xoopsDB->queryF("select * from ".$xoopsDB->prefix("users")." where posts>0" ) );
$xoopsTpl->assign('lang_stats_auth', STATS_AUTHORS );
$xoopsTpl->assign('lang_stats_authors', $authorscnt );

$anum = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("session")));
$xoopsTpl->assign('lang_stats_ausers', STATS_ACTIVEUSERS );
$xoopsTpl->assign('lang_stats_activeusers', $anum );

$cnum = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("xoopscomments")));
$xoopsTpl->assign('lang_stats_commentsposted', STATS_COMMENTSPOSTED );
$xoopsTpl->assign('lang_stats_comments', $cnum );

$xoopsTpl->assign('lang_xoops_version', STATS_XOOPS_VERSION );

// see if sections is active
if ( $xoopsDB->getRowsNum( $xoopsDB->queryF("select * from ".$xoopsDB->prefix("modules")." where dirname='sections' AND isactive='1'") ) > 0 )
{
  $xoopsTpl->assign('sections_active', true );
  $secnum = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("sections") ) );
  $secanum = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("seccont") ) );
  $xoopsTpl->assign('lang_stat_section', STATS_SECTION );
  $xoopsTpl->assign('lang_stat_sectioncnt', $secnum );
  $xoopsTpl->assign('lang_stat_article', STATS_ARTICLE );
  $xoopsTpl->assign('lang_stat_articlecnt', $secanum );
}

// see if news is active
if ( $xoopsDB->getRowsNum( $xoopsDB->queryF("select * from ".$xoopsDB->prefix("modules")." where dirname='news' AND isactive='1'" ) ) > 0 )
{
  $xoopsTpl->assign('news_active', true );
  $snum = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("stories")." where published!=0"));
  $xoopsTpl->assign('lang_stats_storiespublished', STATS_STORIESPUBLISHED );
  $xoopsTpl->assign('lang_stats_stories', $snum );

  $swait = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("stories")." where published=0"));
  $xoopsTpl->assign('lang_stats_waitingstories', STATS_STORIESWAITING );
  $xoopsTpl->assign('lang_stats_waiting', $swait );

  $tnum = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("topics") ) );
  $xoopsTpl->assign('lang_stats_topics', STATS_TOPICS );
  $xoopsTpl->assign('lang_stats_topicscnt', $tnum );
}

// see if AMS is active
if ( $xoopsDB->getRowsNum( $xoopsDB->queryF("select * from ".$xoopsDB->prefix("modules")." where dirname='AMS' AND isactive='1'" ) ) > 0 )
{
  $xoopsTpl->assign('amsnews_active', true );
  $snum = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("ams_article")." where published!=0"));
  $xoopsTpl->assign('lang_stats_amsstoriespublished', STATS_AMSARTICLE );
  $xoopsTpl->assign('lang_stats_amsstories', $snum );

  $swait = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("ams_article")." where published=0"));
  $xoopsTpl->assign('lang_stats_amswaitingstories', STATS_AMSSTORIESWAITING );
  $xoopsTpl->assign('lang_stats_amswaiting', $swait );

  $tnum = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("ams_topics") ) );
  $xoopsTpl->assign('lang_stats_amstopics', STATS_AMSTOPICS );
  $xoopsTpl->assign('lang_stats_amstopicscnt', $tnum );
}

// see if mylinks is active
if ( $xoopsDB->getRowsNum( $xoopsDB->queryF("select * from ".$xoopsDB->prefix("modules")." where dirname='mylinks' AND isactive='1'" ) ) > 0 )
{
  $xoopsTpl->assign('links_active', true );
  $links = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("mylinks_links") ) );
  $xoopsTpl->assign('lang_stats_links', STATS_LINKS );
  $xoopsTpl->assign('lang_stats_linkscnt', $links );
  
  $cat = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("mylinks_cat") ) );
  $xoopsTpl->assign('lang_stats_linkcat', STATS_LINKCAT );
  $xoopsTpl->assign('lang_stats_linkcatcnt', $cat ); 
}

// see if xoopsgallery is active
if ( $xoopsDB->getRowsNum( $xoopsDB->queryF("select * from ".$xoopsDB->prefix("modules")." where dirname='xoopsgallery' AND isactive='1'" ) ) > 0 )
{
  $xoopsTpl->assign('xoopsgallery_active', true );
  $links = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("xoopsgallery_image") ) );
  $xoopsTpl->assign('lang_stats_gimages', STATS_GALLERY_IMAGES );
  $xoopsTpl->assign('lang_stats_gimagescnt', $links );
  
  $cat = $xoopsDB->getRowsNum($xoopsDB->queryF("select DISTINCT image_albumdir from ".$xoopsDB->prefix("xoopsgallery_image") ) );
  $xoopsTpl->assign('lang_stats_galbums', STATS_GALLERY_ALBUMS );
  $xoopsTpl->assign('lang_stats_galbumscnt', $cat ); 
}

// see if tinycontent is active
if ( $xoopsDB->getRowsNum( $xoopsDB->queryF("select * from ".$xoopsDB->prefix("modules")." where dirname='tinycontent' AND isactive='1'" ) ) > 0 )
{
  $xoopsTpl->assign('tinycontent_active', true );
  $links = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("tinycontent") ) );
  $xoopsTpl->assign('lang_stats_tinycontent', STATS_TCONTENT_AVAIL );
  $xoopsTpl->assign('lang_stats_tccnt', $links );
  
  $cat = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("tinycontent")." where visible='1'" ) );
  $xoopsTpl->assign('lang_stats_tcvisible', STATS_TCONTENT_VISIBLE );
  $xoopsTpl->assign('lang_stats_tcvcnt', $cat ); 
}

// see if mydownloads is active
if ( $xoopsDB->getRowsNum( $xoopsDB->queryF("select * from ".$xoopsDB->prefix("modules")." where dirname='downloads' AND isactive='1'" ) ) > 0 )
{
  $xoopsTpl->assign('dl_active', true );
  $dlcat = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("mydownloads_cat") ) );
  $xoopsTpl->assign('lang_stats_dlcat', STATS_DLCAT );
  $xoopsTpl->assign('lang_stats_dlcatcnt', $dlcat );
  
  $dlfiles = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("mydownloads_downloads") ) );
  $xoopsTpl->assign('lang_stats_dlfiles', STATS_DLFILES );
  $xoopsTpl->assign('lang_stats_dlfilescnt', $dlfiles ); 
}

// see if wfdownloads is active
if ( $xoopsDB->getRowsNum( $xoopsDB->queryF("select * from ".$xoopsDB->prefix("modules")." where dirname='wfdownloads' AND isactive='1'" ) ) > 0 )
{
  $xoopsTpl->assign('wfdl_active', true );
  $wfdlcat = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("wfdownloads_cat") ) );
  $xoopsTpl->assign('lang_stats_wfdlcat', STATS_WFDLCAT );
  $xoopsTpl->assign('lang_stats_wfdlcatcnt', $wfdlcat );
  
  $wfdlfiles = $xoopsDB->getRowsNum($xoopsDB->queryF("select * from ".$xoopsDB->prefix("wfdownloads_downloads") ) );
  $xoopsTpl->assign('lang_stats_wfdlfiles', STATS_WFDLFILES );
  $xoopsTpl->assign('lang_stats_wfdlfilescnt', $wfdlfiles ); 
}
}

mainStats();

include XOOPS_ROOT_PATH.'/footer.php';
?>

<?php
// $Id: referaccum.php, 12-08-2004 seventhseal Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
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

/******************************************************************************
 * Function: b_referaccum_show
 * Output  : retruns the total of hit for a given referer
 ******************************************************************************/
function b_referaccum_show($options)
{
  global $xoopsDB, $config_handler, $xoopsStatConfig;

  $module_handler =& xoops_gethandler('module');
  $xoopsStatModule =& $module_handler->getByDirname('statistics');
  $xoopsStatConfig =& $config_handler->getConfigsByCat(0, $xoopsStatModule->getVar('mid'));

  $showhowmany = $options[0];
  $showselfrefer = $options[1];
  
  // get any current blacklist
  $result = $xoopsDB->queryF("select * from ".$xoopsDB->prefix("stats_refer_blacklist") );
  list( $id, $referer ) = $xoopsDB->fetchRow( $result );
  $referblacklist = unserialize( stripslashes( $referer ));
  if ( !is_array( $referblacklist ) ) // something went wrong, or there is no data...
  {
    $referblacklist = array();
  }

  $block = array();
  // this sql is getting the total hits for a refer by summing the hits and grouping by refer.  We order
  // by the total hits in DESC fashion.  Highest is first.  total is an alias for SUM(hits)
  $result = $xoopsDB->queryF("SELECT refer, SUM(hits) as total from ".$xoopsDB->prefix('stats_refer')." group by refer order by total DESC");
  $referhits = array();
  $cnt = 0;
  while (list( $refer, $total ) = $xoopsDB->fetchRow($result) )
  {
    if ( ($showselfrefer == 0 && !strcmp($refer, $_SERVER['HTTP_HOST'])) || $refer == "" )
    {
      continue;
    }
    else
    {
      // see if we have a blacklist
      $blacklisted = false;

      if ( $xoopsStatConfig['refererspam'] != 'Allow' )  // make sure they really want them ignored
      {
        if ( count( $referblacklist ) > 0)
        {
          $rbldelimited = implode( '|', $referblacklist );
          if ( ereg( $rbldelimited, $refer ) )
          {
            $blacklisted = true;
            continue;
          }
        }
      }

      if ( $blacklisted == false )
      {
        $referhits[$cnt]['refer'] = $refer;
        $referhits[$cnt]['hits'] = "";
        if ( strlen($total) < 3 )
        {
          $hits = sprintf("%03d", $total);
        }
        for ($i = 0 ;$i < strlen($total) ; $i++)
        {
        //the <img src> tag
          $imgsrc = SubStr($total,$i ,1);
          $referhits[$cnt]['hits'] .= "<img src=\"".XOOPS_URL."/modules/statistics/images/".$imgsrc.".gif\" border = \"0\">";
        }

        $cnt++;
      }

      if ( $cnt == $showhowmany )
        break;
    }
  }

  $block['counterhead'] = B_STATS_REFERACCUM;
  $block['referhits'] = $referhits;
  return $block;
}

function b_referaccum_edit( $options )
{
	$inputtag = "<input type='text' name='options[0]' value='".$options[0]."' />";
	$form = sprintf( B_STATS_REFERDISPLAY, $inputtag);
    $temp = sprintf( B_STATS_SELFREFERDISPLAY, $_SERVER['HTTP_HOST']);
	$form .= "<hr>".$temp
            ."<br><br><input type='radio' id='options[1]' name='options[1]' value='1'";
	if ( $options[2] == 1 )
    {
		$form .= " checked='checked'";
	}
	$form .= ">&nbsp;"._YES
            ."<br><input type='radio' id='options[1]' name='options[1]' value='0'";
	if ( $options[2] == 0 )
    {
		$form .= " checked='checked'";
	}
	$form .= ">&nbsp;"._NO;

	return $form;
}
?>


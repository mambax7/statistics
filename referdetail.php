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
if ( file_exists("language/".$xoopsConfig['language']."/blocks.php") ) {
	include "language/".$xoopsConfig['language']."/blocks.php";
} else {
	include "language/english/blocks.php";
}
$xoopsOption['template_main'] = 'referdetail.html';
include XOOPS_ROOT_PATH."/header.php";


function referDetail()
{
  global $xoopsDB, $xoopsTpl, $config_handler;
  
  $module_handler =& xoops_gethandler('module');
  $xoopsModule =& $module_handler->getByDirname('statistics');
  $xoopsModuleConfig =& $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

  // get any current blacklist
  $result = $xoopsDB->queryF("select * from ".$xoopsDB->prefix("stats_refer_blacklist") );
  list( $id, $referer ) = $xoopsDB->fetchRow( $result );
  $referblacklist = unserialize( stripslashes( $referer ));
  if ( !is_array( $referblacklist ) ) // something went wrong, or there is no data...
  {
    $referblacklist = array();
  }
  
  // figure out if we are saving hits by refer and path or just refer
  $resultoption = $xoopsDB->queryF("select options from ".$xoopsDB->prefix("newblocks")." where name='Top Referers' and dirname='statistics'" );
  $optionsret = $xoopsDB->fetchRow($resultoption);
  $options = explode("|", $optionsret[0] );
  if ( $options[1] == "" ) 
  {
    $options[1] = 0;
  }

  $showselfrefer = $options[2];

  $result = $xoopsDB->queryF("SELECT refer, date, hits, referpath from ".$xoopsDB->prefix('stats_refer')." order by hits DESC");
  $referhits = array();
  $cnt = 0;
  while (list( $refer, $date, $hits, $referpath ) = $xoopsDB->fetchRow($result) ) 
  {
    if ( ($showselfrefer == 0 && !strcmp($refer, $_SERVER['HTTP_HOST'])) || $refer == "" ) 
    {
      continue;
    }
    else
    {
        // see if we have a blacklist
      $blacklisted = false;
	  
		// check configs if we are ignoring or allowing
	  if ( $xoopsModuleConfig['refererspam'] != 'Allow' )
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
	    $referpathparts = explode("|", $referpath );
        if ( ($howmany = count( $referpathparts )) < 3 )
		{
		  switch( $howmany )
		  {
		    case 0:
			  for ( $i = 0; $i < 3; $i++ )
			  {
			    $referpathparts[$i] = "";
			  } 
			  break;
			  
			case 1:
			  for ( $i = 1; $i < 3; $i++ )
			  {
			    $referpathparts[$i] = "";
			  } 
			  break;
			  
			case 2:
	          $referpathparts[2] = "";
			  break;  
		  }
		}
		  
        $referhits[$cnt]['pathing'] = $options[1];
        $referhits[$cnt]['elipses'] = B_STATS_ELIPSES;
        $referhits[$cnt]['pathstrip'] = B_STATS_DELPATH;
        $referhits[$cnt]['pathdns'] = B_STATS_PATHDNS;
        $referhits[$cnt]['path'] = $referpathparts[0];
		$referhits[$cnt]['query'] = $referpathparts[1];
		$referhits[$cnt]['fragment'] = $referpathparts[2];
        $referhits[$cnt]['refer'] = $refer;
        $referhits[$cnt]['hits'] = "";
        ereg( "([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})", $date, $regs );
        $referhits[$cnt]['year'] = $regs[1];
        $referhits[$cnt]['month'] = $regs[2];
        $referhits[$cnt]['day'] = $regs[3];
        $referhits[$cnt]['hour'] = B_STATS_HOUR."&nbsp;".$regs[4];
        if ( strlen($hits) < 3 ) 
        {
          $hits = sprintf("%03d", $hits);
        }
        for ($i = 0 ;$i < strlen($hits) ; $i++)
        {
        //the <img src> tag
          $imgsrc = SubStr($hits,$i ,1);
          $referhits[$cnt]['hits'] .= "<img src=\"".XOOPS_URL."/modules/statistics/images/".$imgsrc.".gif\" border = \"0\">";
        }

        $cnt++;   
      }
    }
  }

  $xoopsTpl->assign('lang_refer_counterhead', B_STATS_REFERHEAD );
  $xoopsTpl->assign('lang_refer_referhits', $referhits );
}

referDetail();

include XOOPS_ROOT_PATH.'/footer.php';
?>

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

/******************************************************************************
 * Function: b_hitcounter_show
 * Output  : Returns the graphical output of site hits
 *****************************************************************************
 * @param $options
 * @return array
 */
function b_hitcounter_show($options)
{
    global $xoopsDB;
    $block    = [];
    $myts     = \MyTextSanitizer::getInstance();
    $result   = $xoopsDB->queryF('SELECT year, hits FROM ' . $xoopsDB->prefix('stats_year'));
    $counter  = 0;
    $yearhits = [];
    $cnt      = 0;
    while (false !== (list($year, $hits) = $xoopsDB->fetchRow($result))) {
        $counter += $hits;  // figure out total hits

        $yearhits[$cnt]['year']    = $year;
        $yearhits[$cnt]['counter'] = '';
        if (strlen($hits) < 5) {
            $hits = sprintf('%05d', $hits);
        }
        for ($i = 0, $iMax = strlen($hits); $i < $iMax; ++$i) {
            //the <img src> tag
            $imgsrc                    = substr($hits, $i, 1);
            $yearhits[$cnt]['counter'] .= '<img src="' . XOOPS_URL . '/modules/statistics/assets/images/' . $imgsrc . '.gif" border = "0">';
        }

        ++$cnt;
    }

    //number images are stored in the images directory
    //and are numbered from 0.gif to 9.gif
    //loop through the values of $counter and
    //use the strlen function to check the length of $counter
    $cnt_graphic = '';
    if (strlen($counter) < 5) {
        $counter = sprintf('%05d', $counter);
    }
    for ($i = 0, $iMax = strlen($counter); $i < $iMax; ++$i) {
        //the <img src> tag
        $imgsrc      = substr($counter, $i, 1);
        $cnt_graphic .= '<img src="' . XOOPS_URL . '/modules/statistics/assets/images/' . $imgsrc . '.gif" border = "0">';
    }

    if ('1' == $options[1]) { // check to see if we should show the blocked hits
        $result    = $xoopsDB->queryF('SELECT year, hits FROM ' . $xoopsDB->prefix('stats_blockedyear'));
        $bcounter  = 0;
        $byearhits = [];
        $cnt       = 0;
        while (false !== (list($year, $hits) = $xoopsDB->fetchRow($result))) {
            $bcounter += $hits;  // figure out total hits

            $byearhits[$cnt]['year']    = $year;
            $byearhits[$cnt]['counter'] = '';
            if (strlen($hits) < 5) {
                $hits = sprintf('%05d', $hits);
            }
            for ($i = 0, $iMax = strlen($hits); $i < $iMax; ++$i) {
                //the <img src> tag
                $imgsrc                     = substr($hits, $i, 1);
                $byearhits[$cnt]['counter'] .= '<img src="' . XOOPS_URL . '/modules/statistics/assets/images/' . $imgsrc . '.gif" border = "0">';
            }

            ++$cnt;
        }

        //number images are stored in the images directory
        //and are numbered from 0.gif to 9.gif
        //loop through the values of $counter and
        //use the strlen function to check the length of $counter
        $bcnt_graphic = '';
        if (strlen($bcounter) < 5) {
            $bcounter = sprintf('%05d', $bcounter);
        }
        for ($i = 0, $iMax = strlen($bcounter); $i < $iMax; ++$i) {
            //the <img src> tag
            $imgsrc       = substr($bcounter, $i, 1);
            $bcnt_graphic .= '<img src="' . XOOPS_URL . '/modules/statistics/assets/images/' . $imgsrc . '.gif" border = "0">';
        }
    }

    $block['display']            = $options[0];
    $block['displayblockedhits'] = $options[1];
    $block['counterhead']        = B_STATS_CNTHEAD;
    $block['bcounterhead']       = B_STATS_BLOCKED_CNTHEAD;
    $block['yearhead']           = B_STATS_YRHEAD;
    $block['byearhead']          = B_STATS_BLOCKED_YRHEAD;
    $block['counter']            = $cnt_graphic;
    $block['bcounter']           = $bcnt_graphic;
    $block['yearhits']           = $yearhits;
    $block['byearhits']          = $byearhits;

    return $block;
}

function b_hitcounter_edit($options)
{
    $form = '' . B_STATS_HITDISPLAY . "&nbsp;<select name='options[0]'>";
    $form .= "<option value='site'";
    if ('site' === $options[0]) {
        $form .= ' selected';
    }
    $form .= '>' . B_SITE . "</option>\n";
    $form .= "<option value='all'";
    if ('all' === $options[0]) {
        $form .= ' selected';
    }
    $form .= '>' . B_SITEALL . "</option>\n";
    $form .= "</select>\n";
    $form .= "<hr>\n";
    $form .= '' . B_STATS_BLOCKEDHITDISPLAY . '&nbsp;';
    $form .= "<input type='radio' id='options[1]' name='options[1]' value='1'";
    if (1 == $options[1]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _YES . "<br><input type='radio' id='options[1]' name='options[1]' value='0'";
    if (0 == $options[1]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _NO;

    return $form;
}

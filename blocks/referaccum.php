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
 * Function: b_referaccum_show
 * Output  : retruns the total of hit for a given referer
 *****************************************************************************
 * @param $options
 * @return array
 */
function b_referaccum_show($options)
{
    global $xoopsDB, $configHandler, $xoopsStatConfig;

    /** @var XoopsModuleHandler $moduleHandler */
    $moduleHandler   = xoops_getHandler('module');
    $xoopsStatModule = $moduleHandler->getByDirname('statistics');
    $xoopsStatConfig = $configHandler->getConfigsByCat(0, $xoopsStatModule->getVar('mid'));

    $showhowmany   = $options[0];
    $showselfrefer = $options[1];

    // get any current blacklist
    $result = $xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('stats_refer_blacklist'));
    list($id, $referer) = $xoopsDB->fetchRow($result);
    $referblacklist = unserialize(stripslashes($referer));
    if (!is_array($referblacklist)) { // something went wrong, or there is no data...
        $referblacklist = [];
    }

    $block = [];
    // this sql is getting the total hits for a refer by summing the hits and grouping by refer.  We order
    // by the total hits in DESC fashion.  Highest is first.  total is an alias for SUM(hits)
    $result    = $xoopsDB->queryF('SELECT refer, SUM(hits) AS total FROM ' . $xoopsDB->prefix('stats_refer') . ' GROUP BY refer ORDER BY total DESC');
    $referhits = [];
    $cnt       = 0;
    while (list($refer, $total) = $xoopsDB->fetchRow($result)) {
        if ((0 == $showselfrefer && !strcmp($refer, $_SERVER['HTTP_HOST'])) || '' == $refer) {
            continue;
        } else {
            // see if we have a blacklist
            $blacklisted = false;

            if ('Allow' != $xoopsStatConfig['refererspam']) {  // make sure they really want them ignored
                if (count($referblacklist) > 0) {
                    $rbldelimited = '/' . implode('|', $referblacklist) . '/';
                    if (preg_match($rbldelimited, $refer)) {
                        $blacklisted = true;
                        continue;
                    }
                }
            }

            if (false === $blacklisted) {
                $referhits[$cnt]['refer'] = $refer;
                $referhits[$cnt]['hits']  = '';
                if (strlen($total) < 3) {
                    $hits = sprintf('%03d', $total);
                }
                for ($i = 0, $iMax = strlen($total); $i < $iMax; ++$i) {
                    //the <img src> tag
                    $imgsrc                  = substr($total, $i, 1);
                    $referhits[$cnt]['hits'] .= '<img src="' . XOOPS_URL . '/modules/statistics/assets/images/' . $imgsrc . '.gif" border = "0">';
                }

                ++$cnt;
            }

            if ($cnt == $showhowmany) {
                break;
            }
        }
    }

    $block['counterhead'] = B_STATS_REFERACCUM;
    $block['referhits']   = $referhits;

    return $block;
}

function b_referaccum_edit($options)
{
    $inputtag = "<input type='text' name='options[0]' value='" . $options[0] . "'>";
    $form     = sprintf(B_STATS_REFERDISPLAY, $inputtag);
    $temp     = sprintf(B_STATS_SELFREFERDISPLAY, $_SERVER['HTTP_HOST']);
    $form     .= '<hr>' . $temp . "<br><br><input type='radio' id='options[1]' name='options[1]' value='1'";
    if (1 == $options[2]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _YES . "<br><input type='radio' id='options[1]' name='options[1]' value='0'";
    if (0 == $options[2]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _NO;

    return $form;
}

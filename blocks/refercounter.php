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
 * Function: b_refercounter_show
 * Output  : Returns the graphical output of site hits
 *****************************************************************************
 * @param $options
 * @return array
 */
function b_refercounter_show($options)
{
    global $xoopsDB, $configHandler, $xoopsStatConfig;

    /** @var XoopsModuleHandler $moduleHandler */
    $moduleHandler   = xoops_getHandler('module');
    $xoopsStatModule = $moduleHandler->getByDirname('statistics');
    $xoopsStatConfig = $configHandler->getConfigsByCat(0, $xoopsStatModule->getVar('mid'));

    $showhowmany   = $options[0];
    $showselfrefer = $options[2];

    // get any current blacklist
    $result = $xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('stats_refer_blacklist'));
    list($id, $referer) = $xoopsDB->fetchRow($result);
    $referblacklist = unserialize(stripslashes($referer));
    if (!is_array($referblacklist)) { // something went wrong, or there is no data...
        $referblacklist = [];
    }

    $block     = [];
    $result    = $xoopsDB->queryF('SELECT refer, date, hits, referpath FROM ' . $xoopsDB->prefix('stats_refer') . ' ORDER BY hits DESC');
    $referhits = [];
    $cnt       = 0;
    while (list($refer, $date, $hits, $referpath) = $xoopsDB->fetchRow($result)) {
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
                $referpathparts = explode('|', $referpath);

                $referhits[$cnt]['pathing']   = $options[1];
                $referhits[$cnt]['elipses']   = B_STATS_ELIPSES;
                $referhits[$cnt]['pathstrip'] = B_STATS_DELPATH;
                $referhits[$cnt]['pathdns']   = B_STATS_PATHDNS;
                $referhits[$cnt]['path']      = $referpathparts[0];
                $referhits[$cnt]['query']     = $referpathparts[1];
                $referhits[$cnt]['fragment']  = $referpathparts[2];
                $referhits[$cnt]['refer']     = $refer;
                $referhits[$cnt]['hits']      = '';
                preg_match('/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})/', $date, $regs);
                $referhits[$cnt]['year']  = $regs[1];
                $referhits[$cnt]['month'] = $regs[2];
                $referhits[$cnt]['day']   = $regs[3];
                $referhits[$cnt]['hour']  = B_STATS_HOUR . '&nbsp;' . $regs[4];
                if (strlen($hits) < 3) {
                    $hits = sprintf('%03d', $hits);
                }
                for ($i = 0, $iMax = strlen($hits); $i < $iMax; ++$i) {
                    //the <img src> tag
                    $imgsrc                  = substr($hits, $i, 1);
                    $referhits[$cnt]['hits'] .= '<img src="' . XOOPS_URL . '/modules/statistics/assets/images/' . $imgsrc . '.gif" border = "0">';
                }

                ++$cnt;
            }

            if ($cnt == $showhowmany) {
                break;
            }
        }
    }

    $block['counterhead'] = B_STATS_REFERHEAD;
    $block['referhits']   = $referhits;

    return $block;
}

function b_refercounter_edit($options)
{
    $inputtag = "<input type='text' name='options[0]' value='" . $options[0] . "'>";
    $form     = sprintf(B_STATS_REFERDISPLAY, $inputtag);

    $form .= '<hr>' . B_STATS_REFERERPATH_DISPLAY . '<br><br>' . "<input type='radio' id='options[1]' name='options[1]' value='0'";
    if (0 == $options[1]) {  // full path
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . B_STATS_REFER_FULLPATH . "<br><input type='radio' id='options[1]' name='options[1]' value='1'";
    if (1 == $options[1]) { // domain only
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . B_STATS_REFER_DOMAIN . "<br><input type='radio' id='options[1]' name='options[1]' value='2'";
    if (2 == $options[1]) { // show both
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . B_STATS_REFER_ALL;

    $temp = sprintf(B_STATS_SELFREFERDISPLAY, $_SERVER['HTTP_HOST']);
    $form .= '<hr>' . $temp . "<br><br><input type='radio' id='options[2]' name='options[2]' value='1'";
    if (1 == $options[2]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _YES . "<br><input type='radio' id='options[2]' name='options[2]' value='0'";
    if (0 == $options[2]) {
        $form .= ' checked';
    }
    $form .= '>&nbsp;' . _NO;

    return $form;
}

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

use XoopsModules\Statistics;

include __DIR__ . '/../../mainfile.php';

/** @var Statistics\Helper $helper */
$helper = Statistics\Helper::getInstance();
$helper->loadLanguage('blocks');

$GLOBALS['xoopsOption']['template_main'] = 'referdetail.tpl';
include XOOPS_ROOT_PATH . '/header.php';

function referDetail()
{
    global $xoopsDB, $xoopsTpl;
    /** @var Statistics\Helper $helper */
    $helper = Statistics\Helper::getInstance();


    // get any current blacklist
    $result = $xoopsDB->queryF('SELECT * FROM ' . $xoopsDB->prefix('stats_refer_blacklist'));
    list($id, $referer) = $xoopsDB->fetchRow($result);
    $referblacklist = unserialize(stripslashes($referer));
    if (!is_array($referblacklist)) { // something went wrong, or there is no data...
        $referblacklist = [];
    }

    // figure out if we are saving hits by refer and path or just refer
    $resultoption = $xoopsDB->queryF('SELECT options FROM ' . $xoopsDB->prefix('newblocks') . " WHERE name='Top Referers' AND dirname='statistics'");
    $optionsret   = $xoopsDB->fetchRow($resultoption);
    $options      = explode('|', $optionsret[0]);
    if ('' == $options[1]) {
        $options[1] = 0;
    }

    $showselfrefer = $options[2];

    $result    = $xoopsDB->queryF('SELECT refer, date, hits, referpath FROM ' . $xoopsDB->prefix('stats_refer') . ' ORDER BY hits DESC');
    $referhits = [];
    $cnt       = 0;
    while (false !== (list($refer, $date, $hits, $referpath) = $xoopsDB->fetchRow($result))) {
        if ((0 == $showselfrefer && !strcmp($refer, $_SERVER['HTTP_HOST'])) || '' == $refer) {
            continue;
        } else {
            // see if we have a blacklist
            $blacklisted = false;

            // check configs if we are ignoring or allowing
            if ('Allow' !== $helper->getConfig('refererspam')) {
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
                if (($howmany = count($referpathparts)) < 3) {
                    switch ($howmany) {
                        case 0:
                            for ($i = 0; $i < 3; ++$i) {
                                $referpathparts[$i] = '';
                            }
                            break;

                        case 1:
                            for ($i = 1; $i < 3; ++$i) {
                                $referpathparts[$i] = '';
                            }
                            break;

                        case 2:
                            $referpathparts[2] = '';
                            break;
                    }
                }

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
        }
    }

    $xoopsTpl->assign('lang_refer_counterhead', B_STATS_REFERHEAD);
    $xoopsTpl->assign('lang_refer_referhits', $referhits);
}

referDetail();

include XOOPS_ROOT_PATH . '/footer.php';

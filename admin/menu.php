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

// require_once __DIR__ . '/../class/Helper.php';
//require_once __DIR__ . '/../include/common.php';
$helper = Statistics\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');


$adminmenu[] = [
    'title' => _MI_STATISTICS_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ADMENU2,
    'link'  => 'admin/main.php?op=' . INFO_GENERAL,
    'icon'  => $pathIcon32 . '/alert.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ADMENU3,
    'link'  => 'admin/main.php?op=' . INFO_CREDITS,
    'icon'  => $pathIcon32 . '/user-icon.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ADMENU4,
    'link'  => 'admin/main.php?op=' . INFO_CONFIGURATION,
    'icon'  => $pathIcon32 . '/administration.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ADMENU5,
    'link'  => 'admin/main.php?op=' . INFO_MODULES,
    'icon'  => $pathIcon32 . '/block.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ADMENU6,
    'link'  => 'admin/main.php?op=' . INFO_ENVIRONMENT,
    'icon'  => $pathIcon32 . '/globe.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ADMENU7,
    'link'  => 'admin/main.php?op=' . INFO_VARIABLES,
    'icon'  => $pathIcon32 . '/type.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ADMENU8,
    'link'  => 'admin/main.php?op=' . INFO_LICENSE,
    'icon'  => $pathIcon32 . '/discount.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ADMENU9,
    'link'  => 'admin/main.php?op=' . INFO_ALL,
    'icon'  => $pathIcon32 . '/photo.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ADMENU10,
    'link'  => 'admin/main.php?op=remote_addr',
    'icon'  => $pathIcon32 . '/download.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ADMENU11,
    'link'  => 'admin/main.php?op=refer',
    'icon'  => $pathIcon32 . '/list.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ADMENU12,
    'link'  => 'admin/main.php?op=userscreen',
    'icon'  => $pathIcon32 . '/metagen.png',
];

$adminmenu[] = [
    'title' => _MI_STATISTICS_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];

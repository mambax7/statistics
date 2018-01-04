<?php
// version 0.60
define('_STATS_UPGRADEFAILED', 'ERROR - Unable to UPGRADE XOOPStats');
define('_STATS_UPGRADEFAILEDWWARN', 'XOOPStats upgraded with WARNINGS! - It may still function.');
define('_STATS_UPGRADEFAILED0', 'ERROR - UPGRADE failed, you may try the provideed sql');
define('_STATS_UPGRADEFAILED1', 'ERROR - Unable to create required table stats_refer_blacklist');
define('_STATS_UPGRADEFAILED2', 'ERROR - Unable to alter required table stats_refer');
define('_STATS_UPGRADEFAILED3', 'ERROR - Unable to create required table stats_userscreen');
define('_STATS_UPGRADEFAILED4', 'ERROR - Unable to create required table stats_usercolor');
define('_STATS_UPGRADEFAILED5', 'ERROR - Uanble to add new values to table counter');
define('_STATS_UPGRADEFAILED6', 'ERROR - Unable to create required table stats_blockedyear');
define('_STATS_UPGRADEFAILED7', 'ERROR - Unable to create required table stats_blockedmonth');
define('_STATS_UPGRADEFAILED8', 'ERROR - Unable to create required table stats_blockeddate');
define('_STATS_UPGRADEFAILED9', 'ERROR - Unable to create required table stats_blockedhour');
define('_STATS_UPGRADEFAILED10', 'ERROR - Unable to truncate table stats_refer_blacklist');
define('_STATS_UPGRADEFAILED11', 'ERROR - Unable to populate table stats_refer_blacklist');

define('_STATS_UPGRADECOMPLETE', 'SUCCESS - Upgrade Complete!');
define('_STATS_UPGRADECOMPLETEWITHWARN', 'WARNING - Upgrade Complete with warnings.');
define('_STATS_UPGR_ACCESS_ERROR', 'ERROR - Must be ADMIN');
//0.70
define('_AM_STATISTICS_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
define('_AM_STATISTICS_UPGRADEFAILED1', "Update failed - couldn't add new fields");
define('_AM_STATISTICS_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
define('_AM_STATISTICS_ERROR_COLUMN', 'Could not create column in database : %s');
define('_AM_STATISTICS_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
define('_AM_STATISTICS_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
define('_AM_STATISTICS_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');

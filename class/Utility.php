<?php namespace XoopsModules\Statistics;

use Xmf\Request;
use XoopsModules\Statistics;
use XoopsModules\Statistics\Common;

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------
}

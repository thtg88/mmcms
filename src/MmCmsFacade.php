<?php

namespace Thtg88\MmCms;

use Illuminate\Support\Facades\Facade;

class MmCmsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mmcms';
    }
}

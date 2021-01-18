<?php

namespace Thtg88\MmCms\Tests\Feature\ContentModel\Store;

use Thtg88\MmCms\Tests\Feature\Concerns\Store\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ContentModel\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\SeoEntry\Destroy;

use Thtg88\MmCms\Tests\Feature\Concerns\Destroy\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\Contracts\DestroyTest as DestroyTestContract;
use Thtg88\MmCms\Tests\Feature\SeoEntry\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase implements DestroyTestContract
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

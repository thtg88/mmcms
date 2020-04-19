<?php

namespace Thtg88\MmCms\Tests\Feature\SeoEntry\Restore;

use Thtg88\MmCms\Tests\Feature\Concerns\Restore\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\Contracts\RestoreTest as RestoreTestContract;
use Thtg88\MmCms\Tests\Feature\SeoEntry\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase implements RestoreTestContract
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

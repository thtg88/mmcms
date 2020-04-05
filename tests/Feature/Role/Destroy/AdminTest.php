<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Destroy;

use Thtg88\MmCms\Tests\Concerns\Destroy\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Contracts\DestroyTest as DestroyTestContract;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase implements DestroyTestContract
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

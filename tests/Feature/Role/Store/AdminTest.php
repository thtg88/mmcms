<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Store;

use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Concerns\Store\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

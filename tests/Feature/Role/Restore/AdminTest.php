<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Restore;

use Thtg88\MmCms\Tests\Feature\Concerns\Restore\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

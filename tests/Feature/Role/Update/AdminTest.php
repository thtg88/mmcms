<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Update;

use Thtg88\MmCms\Tests\Feature\Concerns\Update\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

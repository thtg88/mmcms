<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Show;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

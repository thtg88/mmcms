<?php

namespace Thtg88\MmCms\Tests\Feature\User\Restore;

use Thtg88\MmCms\Tests\Feature\Concerns\Restore\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\TestCase;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

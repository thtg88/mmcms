<?php

namespace Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\Destroy;

use Thtg88\MmCms\Tests\Feature\Concerns\Destroy\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

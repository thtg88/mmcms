<?php

namespace Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\Store;

use Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\WithModelData;
use Thtg88\MmCms\Tests\Feature\Concerns\Store\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

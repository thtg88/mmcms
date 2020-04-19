<?php

namespace Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\Restore;

use Thtg88\MmCms\Tests\Feature\Concerns\Restore\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\Contracts\RestoreTest as RestoreTestContract;
use Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements RestoreTestContract
{
    use WithModelData, WithUrl, ActingAsDevTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory\Restore;

use Thtg88\MmCms\Tests\Feature\Concerns\Restore\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\Contracts\RestoreTest as RestoreTestContract;
use Thtg88\MmCms\Tests\Feature\ImageCategory\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements RestoreTestContract
{
    use WithModelData, WithUrl, ActingAsDevTest;
}

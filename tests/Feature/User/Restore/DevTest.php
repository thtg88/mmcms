<?php

namespace Thtg88\MmCms\Tests\Feature\User\Restore;

use Thtg88\MmCms\Tests\Concerns\Restore\ActingAsDevTest;
use Thtg88\MmCms\Tests\Contracts\RestoreTest as RestoreTestContract;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements RestoreTestContract
{
    use WithModelData, WithUrl, ActingAsDevTest;
}

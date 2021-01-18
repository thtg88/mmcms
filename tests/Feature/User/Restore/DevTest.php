<?php

namespace Thtg88\MmCms\Tests\Feature\User\Restore;

use Thtg88\MmCms\Tests\Feature\Concerns\Restore\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\Contracts\RestoreTest as RestoreTestContract;
use Thtg88\MmCms\Tests\Feature\TestCase;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;

class DevTest extends TestCase implements RestoreTestContract
{
    use WithModelData;
    use WithUrl;
    use ActingAsDevTest;
}

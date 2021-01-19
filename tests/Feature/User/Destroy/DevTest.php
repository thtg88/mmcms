<?php

namespace Thtg88\MmCms\Tests\Feature\User\Destroy;

use Thtg88\MmCms\Tests\Feature\Concerns\Destroy\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\Contracts\DestroyTest as DestroyTestContract;
use Thtg88\MmCms\Tests\Feature\TestCase;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;

class DevTest extends TestCase implements DestroyTestContract
{
    use WithModelData;
    use WithUrl;
    use ActingAsDevTest;
}

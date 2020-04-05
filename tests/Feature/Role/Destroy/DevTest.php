<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Destroy;

use Thtg88\MmCms\Tests\Concerns\Destroy\ActingAsDevTest;
use Thtg88\MmCms\Tests\Contracts\DestroyTest as DestroyTestContract;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements DestroyTestContract
{
    use WithModelData, WithUrl, ActingAsDevTest;
}

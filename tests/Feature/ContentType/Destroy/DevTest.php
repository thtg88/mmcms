<?php

namespace Thtg88\MmCms\Tests\Feature\ContentType\Destroy;

use Thtg88\MmCms\Tests\Feature\Concerns\Destroy\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\ContentType\WithModelData;
use Thtg88\MmCms\Tests\Feature\Contracts\DestroyTest as DestroyTestContract;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements DestroyTestContract
{
    use WithModelData;
    use WithUrl;
    use ActingAsDevTest;
}

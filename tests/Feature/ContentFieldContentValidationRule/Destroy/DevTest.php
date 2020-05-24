<?php

namespace Thtg88\MmCms\Tests\Feature\ContentFieldContentValidationRule\Destroy;

use Thtg88\MmCms\Tests\Feature\Concerns\Destroy\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\Contracts\DestroyTest as DestroyTestContract;
use Thtg88\MmCms\Tests\Feature\ContentFieldContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements DestroyTestContract
{
    use WithModelData, WithUrl, ActingAsDevTest;
}

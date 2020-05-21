<?php

namespace Thtg88\MmCms\Tests\Feature\ContentValidationRule\Destroy;

use Thtg88\MmCms\Tests\Feature\Concerns\Destroy\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

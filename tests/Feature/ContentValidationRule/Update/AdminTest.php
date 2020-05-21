<?php

namespace Thtg88\MmCms\Tests\Feature\ContentValidationRule\Update;

use Thtg88\MmCms\Tests\Feature\Concerns\Update\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

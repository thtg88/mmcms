<?php

namespace Thtg88\MmCms\Tests\Feature\ContentValidationRule\Restore;

use Thtg88\MmCms\Tests\Feature\Concerns\Restore\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

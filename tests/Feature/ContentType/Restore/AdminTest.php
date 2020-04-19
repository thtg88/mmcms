<?php

namespace Thtg88\MmCms\Tests\Feature\ContentType\Restore;

use Thtg88\MmCms\Tests\Feature\Concerns\Restore\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ContentType\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

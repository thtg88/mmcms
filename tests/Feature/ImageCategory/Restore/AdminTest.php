<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory\Restore;

use Thtg88\MmCms\Tests\Concerns\Restore\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ImageCategory\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

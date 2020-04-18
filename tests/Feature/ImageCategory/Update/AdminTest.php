<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory\Update;

use Thtg88\MmCms\Tests\Feature\Concerns\Update\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ImageCategory\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

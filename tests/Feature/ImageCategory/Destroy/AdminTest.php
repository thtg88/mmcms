<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory\Destroy;

use Thtg88\MmCms\Tests\Concerns\Destroy\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ImageCategory\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}
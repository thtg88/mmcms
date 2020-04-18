<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory\Index;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ImageCategory\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

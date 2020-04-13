<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory\Paginate;

use Thtg88\MmCms\Tests\Concerns\Get\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ImageCategory\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Paginate;

use Thtg88\MmCms\Tests\Concerns\Get\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

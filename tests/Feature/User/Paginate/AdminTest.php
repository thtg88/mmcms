<?php

namespace Thtg88\MmCms\Tests\Feature\User\Paginate;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

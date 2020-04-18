<?php

namespace Thtg88\MmCms\Tests\Feature\User\Destroy;

use Thtg88\MmCms\Tests\Feature\Concerns\Destroy\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

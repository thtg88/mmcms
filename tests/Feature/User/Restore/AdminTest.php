<?php

namespace Thtg88\MmCms\Tests\Feature\User\Restore;

use Thtg88\MmCms\Tests\Feature\Concerns\Restore\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

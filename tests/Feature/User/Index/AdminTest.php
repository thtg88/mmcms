<?php

namespace Thtg88\MmCms\Tests\Feature\User\Index;

use Thtg88\MmCms\Tests\Concerns\Get\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

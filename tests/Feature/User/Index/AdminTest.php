<?php

namespace Thtg88\MmCms\Tests\Feature\User\Index;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\TestCase;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\User\Show;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\TestCase;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

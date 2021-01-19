<?php

namespace Thtg88\MmCms\Tests\Feature\User\Destroy;

use Thtg88\MmCms\Tests\Feature\Concerns\Destroy\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\TestCase;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;

class UserTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsUserTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\User\Show;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\TestCase;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;

class UserTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsUserTest;
}

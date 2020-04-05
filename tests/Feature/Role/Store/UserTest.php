<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Store;

use Thtg88\MmCms\Tests\Concerns\Store\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}

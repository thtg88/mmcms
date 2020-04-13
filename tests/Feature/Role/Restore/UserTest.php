<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Restore;

use Thtg88\MmCms\Tests\Concerns\Restore\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\User\Restore;

use Thtg88\MmCms\Tests\Concerns\Restore\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}

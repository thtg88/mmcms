<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory\Restore;

use Thtg88\MmCms\Tests\Concerns\Restore\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\ImageCategory\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}

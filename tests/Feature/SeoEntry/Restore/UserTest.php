<?php

namespace Thtg88\MmCms\Tests\Feature\SeoEntry\Restore;

use Thtg88\MmCms\Tests\Feature\Concerns\Restore\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\SeoEntry\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}

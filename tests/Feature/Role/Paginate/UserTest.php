<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Paginate;

use Thtg88\MmCms\Tests\Concerns\Get\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}
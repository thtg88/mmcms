<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory\Paginate;

use Thtg88\MmCms\Tests\Concerns\Get\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\ImageCategory\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}

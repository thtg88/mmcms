<?php

namespace Thtg88\MmCms\Tests\Feature\SeoEntry\Paginate;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\SeoEntry\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}

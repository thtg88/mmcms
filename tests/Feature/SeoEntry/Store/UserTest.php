<?php

namespace Thtg88\MmCms\Tests\Feature\SeoEntry\Store;

use Thtg88\MmCms\Tests\Feature\Concerns\Store\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\SeoEntry\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}
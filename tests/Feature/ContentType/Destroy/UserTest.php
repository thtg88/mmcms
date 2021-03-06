<?php

namespace Thtg88\MmCms\Tests\Feature\ContentType\Destroy;

use Thtg88\MmCms\Tests\Feature\Concerns\Destroy\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\ContentType\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsUserTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\ContentValidationRule\Store;

use Thtg88\MmCms\Tests\Feature\Concerns\Store\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\ContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsUserTest;
}

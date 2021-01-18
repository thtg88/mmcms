<?php

namespace Thtg88\MmCms\Tests\Feature\ContentValidationRule\Update;

use Thtg88\MmCms\Tests\Feature\Concerns\Update\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\ContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsUserTest;
}

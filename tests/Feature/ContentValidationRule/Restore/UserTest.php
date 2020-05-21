<?php

namespace Thtg88\MmCms\Tests\Feature\ContentValidationRule\Restore;

use Thtg88\MmCms\Tests\Feature\Concerns\Restore\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\ContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}

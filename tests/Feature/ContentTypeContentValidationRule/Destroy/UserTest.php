<?php

namespace Thtg88\MmCms\Tests\Feature\ContentTypeContentValidationRule\Destroy;

use Thtg88\MmCms\Tests\Feature\Concerns\Destroy\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\ContentTypeContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\Show;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsUserTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\Update;

use Thtg88\MmCms\Tests\Feature\Concerns\Update\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}

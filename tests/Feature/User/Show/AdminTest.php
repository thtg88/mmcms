<?php

namespace Thtg88\MmCms\Tests\Feature\User\Show;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

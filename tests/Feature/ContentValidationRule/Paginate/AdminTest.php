<?php

namespace Thtg88\MmCms\Tests\Feature\ContentValidationRule\Paginate;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsAdminTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\ContentField\Show;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ContentField\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

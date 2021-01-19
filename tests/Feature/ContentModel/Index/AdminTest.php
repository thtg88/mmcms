<?php

namespace Thtg88\MmCms\Tests\Feature\ContentModel\Index;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Unauthorized\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\ContentModel\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
}

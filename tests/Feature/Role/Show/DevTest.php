<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Show;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsDevTest;
}

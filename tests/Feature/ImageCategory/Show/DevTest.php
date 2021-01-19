<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory\Show;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\ImageCategory\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsDevTest;
}

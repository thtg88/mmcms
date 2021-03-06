<?php

namespace Thtg88\MmCms\Tests\Feature\SeoEntry\Index;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\SeoEntry\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsDevTest;
}

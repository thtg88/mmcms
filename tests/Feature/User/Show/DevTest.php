<?php

namespace Thtg88\MmCms\Tests\Feature\User\Show;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\TestCase;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;

class DevTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsDevTest;
}

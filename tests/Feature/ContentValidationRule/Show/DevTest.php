<?php

namespace Thtg88\MmCms\Tests\Feature\ContentValidationRule\Show;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\ContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsDevTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Index;

use Thtg88\MmCms\Tests\Concerns\Get\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsDevTest;
}

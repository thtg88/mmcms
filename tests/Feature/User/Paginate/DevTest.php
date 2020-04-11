<?php

namespace Thtg88\MmCms\Tests\Feature\User\Paginate;

use Thtg88\MmCms\Tests\Concerns\Get\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsDevTest;
}

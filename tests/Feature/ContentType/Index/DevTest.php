<?php

namespace Thtg88\MmCms\Tests\Feature\ContentType\Index;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\ContentType\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsDevTest;
}
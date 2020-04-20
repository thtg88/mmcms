<?php

namespace Thtg88\MmCms\Tests\Feature\ContentModel\Index;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\ContentModel\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsDevTest;
}

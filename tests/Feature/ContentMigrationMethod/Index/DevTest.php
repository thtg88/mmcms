<?php

namespace Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\Index;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\ContentMigrationMethod\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsDevTest;
}

<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategoryShow;

use Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\Unauthorized\ActingAsUserTest;
use Thtg88\MmCms\Tests\Feature\ImageCategoryWithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class UserTest extends TestCase
{
    use WithModelData, WithUrl, ActingAsUserTest;
}

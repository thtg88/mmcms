<?php

namespace Thtg88\MmCms\Tests\Feature\SeoEntry\Update;

use Thtg88\MmCms\Tests\Feature\Concerns\Update\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\Contracts\UpdateTest as UpdateTestContract;
use Thtg88\MmCms\Tests\Feature\SeoEntry\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements UpdateTestContract
{
    use WithModelData;
    use WithUrl;
    use ActingAsDevTest;
    use WithSuccessfulTests;

    /**
     * Return the factory state that represent the user role
     * acting for these tests.
     *
     * @return string
     */
    protected function getUserRoleFactoryStateName(): string
    {
        return 'dev';
    }
}

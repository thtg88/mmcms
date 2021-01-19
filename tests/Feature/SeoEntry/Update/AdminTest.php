<?php

namespace Thtg88\MmCms\Tests\Feature\SeoEntry\Update;

use Thtg88\MmCms\Tests\Feature\Concerns\Update\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\SeoEntry\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase
{
    use WithModelData;
    use WithUrl;
    use ActingAsAdminTest;
    use WithSuccessfulTests;

    /**
     * Return the factory state that represent the user role
     * acting for these tests.
     *
     * @return string
     */
    protected function getUserRoleFactoryStateName(): string
    {
        return 'admin';
    }
}

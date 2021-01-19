<?php

namespace Thtg88\MmCms\Tests\Feature\User\Update;

use Thtg88\MmCms\Tests\Feature\Concerns\Update\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Feature\Contracts\UpdateTest as UpdateTestContract;
use Thtg88\MmCms\Tests\Feature\TestCase;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;

class AdminTest extends TestCase implements UpdateTestContract
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

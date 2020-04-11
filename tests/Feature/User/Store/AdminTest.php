<?php

namespace Thtg88\MmCms\Tests\Feature\User\Store;

use Thtg88\MmCms\Tests\Contracts\StoreTest as StoreTestContract;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase implements StoreTestContract
{
    use WithModelData, WithUrl, WithSuccessfulTests;

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

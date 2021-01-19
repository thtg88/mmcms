<?php

namespace Thtg88\MmCms\Tests\Feature\User\Store;

use Thtg88\MmCms\Tests\Feature\Contracts\StoreTest as StoreTestContract;
use Thtg88\MmCms\Tests\Feature\TestCase;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;

class AdminTest extends TestCase implements StoreTestContract
{
    use WithModelData;
    use WithUrl;
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

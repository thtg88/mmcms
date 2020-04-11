<?php

namespace Thtg88\MmCms\Tests\Feature\User\Update;

use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Models\User;
use Illuminate\Support\Str;
use Thtg88\MmCms\Tests\Concerns\Update\ActingAsDevTest;
use Thtg88\MmCms\Tests\Contracts\UpdateTest as UpdateTestContract;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements UpdateTestContract
{
    use WithModelData, WithUrl, ActingAsDevTest, WithSuccessfulTests;

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

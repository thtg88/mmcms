<?php

namespace Thtg88\MmCms\Tests\Concerns\Action\Post\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsAdminTest
{
    /**
     * Test unauthorized acting as system admin.
     *
     * @return void
     * @group crud
     */
    public function testUnauthorizedActingAsSystemAdmin()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->actingAs($user)->post($this->getRoute());
        $response->assertStatus(403);
    }
}

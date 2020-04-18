<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Action\Post\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsAdminTest
{
    /**
     * Test unauthorized acting as admin.
     *
     * @return void
     * @group crud
     */
    public function testUnauthorizedActingAsSystemAdmin()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute());
        $response->assertStatus(403);
    }
}

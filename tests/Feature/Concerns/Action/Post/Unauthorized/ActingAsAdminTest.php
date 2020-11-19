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
        $user = User::factory()->emailVerified()->admin()->create();
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute());
        $response->assertStatus(403);
    }
}

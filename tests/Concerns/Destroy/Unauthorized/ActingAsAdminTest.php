<?php

namespace Thtg88\MmCms\Tests\Concerns\Destroy\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsAdminTest
{
    /**
     * @return void
     * @group crud
     * @test
     */
    public function unauthorized_acting_as_admin(): void
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('delete', $this->getRoute([$model->id]));
        $response->assertStatus(403);
    }
}

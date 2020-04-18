<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Destroy\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsUserTest
{
    /**
     * @return void
     * @group crud
     * @test
     */
    public function unauthorized_acting_as_user(): void
    {
        $user = factory(User::class)->states('email_verified', 'user')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('delete', $this->getRoute([$model->id]));
        $response->assertStatus(403);
    }
}
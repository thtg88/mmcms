<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Model\Action\Post\Unauthorized;

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
        $user = User::factory()->emailVerified()->user()->create();
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute([$model->id]));
        $response->assertStatus(403);
    }
}

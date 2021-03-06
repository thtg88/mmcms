<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Get\Model\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsAdminTest
{
    /**
     * @return void
     * @group get-tests
     * @test
     */
    public function unauthorized_acting_as_admin(): void
    {
        $user = User::factory()->emailVerified()->admin()->create();
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute([$model->id]));
        $response->assertStatus(403);
    }
}

<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Update\Unauthorized;

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
        $user = User::factory()->emailVerified()->admin()->create();
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]));
        $response->assertStatus(403);
    }
}

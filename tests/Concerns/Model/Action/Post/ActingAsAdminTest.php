<?php

namespace Thtg88\MmCms\Tests\Concerns\Model\Action\Post;

use Thtg88\MmCms\Models\User;
use Illuminate\Support\Str;

trait ActingAsAdminTest
{
    /**
     * @return void
     * @group crud
     * @test
     */
    public function non_existing_model_authorization_errors(): void
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();

        $deleted_model = factory($this->model_classname)->create();
        app()->make($this->repository_classname)
            ->destroy($deleted_model->id);

        // Test random string as id
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute([Str::random(5)]));
        $response->assertStatus(403);

        // Test random number as id
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute([rand(1000, 9999)]));
        $response->assertStatus(403);

        // Test deleted model
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute([$deleted_model->id]));
        $response->assertStatus(403);
    }

    /**
     * Test an empty payload does not have any validation errors.
     *
     * @return void
     * @group crud
     */
    public function testEmptyPayloadHasNoErrors()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute([$model->id]));
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }
}

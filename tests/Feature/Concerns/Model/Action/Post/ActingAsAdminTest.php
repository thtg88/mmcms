<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Model\Action\Post;

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
        $user = User::factory()->emailVerified()->admin()->create();
        $deleted_model = call_user_func($this->model_classname.'::factory')
            ->softDeleted()
            ->create();

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
     * @return void
     * @group crud
     * @test
     */
    public function empty_payload_has_no_errors(): void
    {
        $user = User::factory()->emailVerified()->admin()->create();
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute([$model->id]));
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }
}

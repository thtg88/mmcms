<?php

namespace Thtg88\MmCms\Tests\Concerns\Destroy;

use Thtg88\MmCms\Models\User;
use Illuminate\Support\Str;

trait ActingAsUserTest
{
    /**
     * @return void
     * @group crud
     * @test
     */
    public function non_existing_model_authorization_errors(): void
    {
        $user = factory(User::class)->states('email_verified', 'user')
            ->create();
        $deleted_model = factory($this->model_classname)->create();
        app()->make($this->repository_classname)
            ->destroy($deleted_model->id);

        // Test random string as id
        $response = $this->actingAs($user)
            ->delete($this->getRoute([Str::random(5)]));
        $response->assertStatus(403);

        // Test random number as id
        $response = $this->actingAs($user)
            ->delete($this->getRoute([rand(1000, 9999)]));
        $response->assertStatus(403);

        // Test deleted user
        $response = $this->actingAs($user)
            ->delete($this->getRoute([$deleted_model->id]));
        $response->assertStatus(403);
    }

    /**
     * @return void
     * @group crud
     * @group crud
     */
    public function successful_destroy(): void
    {
        $user = factory(User::class)->states('email_verified', 'user')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->actingAs($user)->delete($this->getRoute([$model->id]));
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertTrue($model->refresh()->deleted_at !== null);
        $this->assertNull(
            app()->make($this->repository_classname)
                ->find($model->id)
        );
    }
}

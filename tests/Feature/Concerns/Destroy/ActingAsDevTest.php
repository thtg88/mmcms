<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Destroy;

use Illuminate\Support\Str;
use Thtg88\MmCms\Models\User;

trait ActingAsDevTest
{
    /**
     * @return void
     * @group crud
     * @test
     */
    public function non_existing_model_authorization_errors(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $deleted_model = call_user_func($this->model_classname.'::factory')
            ->softDeleted()
            ->create();

        // Test random string as id
        $response = $this->passportActingAs($user)
            ->json('delete', $this->getRoute([Str::random(5)]));
        $response->assertStatus(403);

        // Test random number as id
        $response = $this->passportActingAs($user)
            ->json('delete', $this->getRoute([rand(1000, 9999)]));
        $response->assertStatus(403);

        // Test deleted model
        $response = $this->passportActingAs($user)
            ->json('delete', $this->getRoute([$deleted_model->id]));
        $response->assertStatus(403);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function successful_destroy(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->passportActingAs($user)
            ->json('delete', $this->getRoute([$model->id]));
        $response->assertStatus(200)
            ->assertJsonMissing(['errors' => []])
            ->assertJson([
                'resource' => [
                    'id'         => $model->id,
                    'created_at' => $model->created_at->toISOString(),
                ],
            ]);

        $this->assertTrue($model->refresh()->deleted_at !== null);
        $this->assertNull(
            app()->make($this->repository_classname)
                ->find($model->id)
        );
    }
}

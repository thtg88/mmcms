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
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $deleted_model = factory($this->model_classname)->create();
        app()->make($this->repository_classname)->destroy($deleted_model->id);

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
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('delete', $this->getRoute([$model->id]));
        $response->assertStatus(200)
            ->assertJsonMissing(['errors' => []])
            ->assertJson([
                'resource' => [
                    'id' => $model->id,
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

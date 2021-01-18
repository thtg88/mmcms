<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Restore;

use Illuminate\Support\Str;
use Thtg88\MmCms\Models\User;

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

        // Test random string as id
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute([Str::random(5)]));
        $response->assertStatus(403);

        // Test random number as id
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute([rand(1000, 9999)]));
        $response->assertStatus(403);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function successful_restore(): void
    {
        $user = User::factory()->emailVerified()->admin()->create();
        $model = call_user_func($this->model_classname.'::factory')
            ->softDeleted()
            ->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute([$model->id]));
        $response->assertStatus(200)
            ->assertJsonMissing(['errors' => []])
            ->assertJson([
                'success'  => true,
                'resource' => [
                    'id'         => $model->id,
                    'created_at' => $model->created_at->toISOString(),
                ],
            ]);
        $this->assertTrue($model->refresh()->deleted_at === null);
    }
}

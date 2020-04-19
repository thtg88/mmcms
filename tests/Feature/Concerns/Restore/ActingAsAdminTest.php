<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Restore;

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
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create([
            'deleted_at' => now()->toDateTimeString(),
        ]);

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute([$model->id]));
        $response->assertStatus(200)
            ->assertJsonMissing(['errors' => []])
            ->assertJson([
                'success' => true,
                'resource' => [
                    'id' => $model->id,
                    'created_at' => $model->created_at->toISOString(),
                ],
            ]);
        $this->assertTrue($model->refresh()->deleted_at === null);
    }
}

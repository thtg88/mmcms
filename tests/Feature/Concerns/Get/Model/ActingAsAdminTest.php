<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Get\Model;

use Illuminate\Support\Str;
use Thtg88\MmCms\Models\User;

trait ActingAsAdminTest
{
    /**
     * @return void
     * @group get-tests
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
            ->json('get', $this->getRoute([Str::random(5)]));
        $response->assertStatus(403);

        // Test random number as id
        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute([rand(1000, 9999)]));
        $response->assertStatus(403);

        // Test deleted model
        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute([$deleted_model->id]));
        $response->assertStatus(403);
    }

    /**
     * @return void
     * @group get-tests
     * @test
     */
    public function successful_recovery_get_as_admin(): void
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create([
            'deleted_at' => now()->toDateTimeString(),
        ]);

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute([$model->id]).'?recovery=1');
        $response->assertStatus(200);
    }

    /**
     * @return void
     * @group get-tests
     * @test
     */
    public function successful_get_as_admin(): void
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute([$model->id]));
        $response->assertStatus(200);
    }
}

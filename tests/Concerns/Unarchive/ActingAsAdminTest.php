<?php

namespace Thtg88\MmCms\Tests\Concerns\Unarchive;

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
        $response = $this->actingAs($user)
            ->post($this->getRoute([Str::random(5)]));
        $response->assertStatus(403);

        // Test random number as id
        $response = $this->actingAs($user)
            ->post($this->getRoute([rand(1000, 9999)]));
        $response->assertStatus(403);

        // Test deleted model
        $response = $this->actingAs($user)
            ->post($this->getRoute([$deleted_model->id]));
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

        $response = $this->actingAs($user)
            ->post($this->getRoute([$model->id]));
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test successful archive.
     *
     * @return void
     * @group crud
     */
    public function testSuccessfulUnarchive()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->states('archived')->create();

        $this->assertTrue($model->archived_at !== null);

        $response = $this->actingAs($user)->post($this->getRoute([$model->id]));
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $model = $model->refresh();

        $this->assertTrue($model !== null);
        $this->assertInstanceOf($this->model_classname, $model);
        $this->assertTrue($model->archived_at === null);
    }
}

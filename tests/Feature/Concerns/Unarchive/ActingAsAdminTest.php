<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Unarchive;

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

    /**
     * Test successful archive.
     *
     * @return void
     * @group crud
     */
    public function testSuccessfulUnarchive()
    {
        $user = User::factory()->emailVerified()->admin()->create();
        $model = call_user_func($this->model_classname.'::factory')->archived()
            ->create();

        $this->assertTrue($model->archived_at !== null);

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute([$model->id]));
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $model = $model->refresh();

        $this->assertTrue($model !== null);
        $this->assertInstanceOf($this->model_classname, $model);
        $this->assertTrue($model->archived_at === null);
    }
}

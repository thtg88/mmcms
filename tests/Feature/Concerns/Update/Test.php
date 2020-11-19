<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Update;

use Illuminate\Support\Str;

trait Test
{
    /**
     * @return void
     * @group crud
     * @test
     */
    public function non_existing_model_authorization_errors(): void
    {
        // Test random string as id
        $response = $this->json('put', $this->getRoute([Str::random(5)]));
        $response->assertStatus(403);

        // Test random number as id
        $response = $this->json('put', $this->getRoute([rand(1000, 9999)]));
        $response->assertStatus(403);

        // Test deleted model
        $model = call_user_func($this->model_classname.'::factory')
            ->softDeleted()
            ->create();

        $response = $this->json('put', $this->getRoute([$model->id]));
        $response->assertStatus(403);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function empty_payload_has_no_errors(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->json('put', $this->getRoute([$model->id]));

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }
}

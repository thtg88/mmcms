<?php

namespace Thtg88\MmCms\Tests\Concerns\Update;

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

        // Test deleted user
        $model = factory($this->model_classname)->create();
        app()->make($this->repository_classname)
            ->destroy($model->id);

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
        $model = factory($this->model_classname)->create();

        $response = $this->json('put', $this->getRoute([$model->id]));

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }
}

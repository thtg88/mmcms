<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Destroy;

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
        $response = $this->json('delete', $this->getRoute([Str::random(5)]));
        $response->assertStatus(403);

        // Test random number as id
        $response = $this->json('delete', $this->getRoute([rand(1000, 9999)]));
        $response->assertStatus(403);

        // Test deleted model
        $model = call_user_func($this->model_classname.'::factory')
            ->softDeleted()
            ->create();

        $response = $this->json('delete', $this->getRoute([$model->id]));
        $response->assertStatus(403);
    }

    /**
     * @return void
     * @group crud
     * @group crud
     */
    public function successful_destroy(): void
    {
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->json('delete', $this->getRoute([$model->id]));

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertTrue($model->refresh()->deleted_at !== null);
        $this->assertNull(
            app()->make($this->repository_classname)
                ->find($model->id)
        );
    }
}

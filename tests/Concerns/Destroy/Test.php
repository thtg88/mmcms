<?php

namespace Thtg88\MmCms\Tests\Concerns\Destroy;

use Illuminate\Support\Str;

trait Test
{
    /**
     * Test an empty payload has required validation errors.
     *
     * @return void
     * @group crud
     */
    public function testNonExistingModelAuthorizationErrors()
    {
        // Test random string as id
        $response = $this->delete($this->getRoute([Str::random(5)]));
        $response->assertStatus(403);

        // Test random number as id
        $response = $this->delete($this->getRoute([rand(1000, 9999)]));
        $response->assertStatus(403);

        // Test deleted user
        $model = factory($this->model_classname)->create();
        app()->make($this->repository_classname)
            ->destroy($model->id);

        $response = $this->delete($this->getRoute([$model->id]));
        $response->assertStatus(403);
    }

    /**
     * Test successful destroy.
     *
     * @return void
     * @group crud
     */
    public function testSuccessfulDestroy()
    {
        $model = factory($this->model_classname)->create();

        $response = $this->delete($this->getRoute([$model->id]));

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertTrue($model->refresh()->deleted_at !== null);
        $this->assertNull(
            app()->make($this->repository_classname)
                ->find($model->id)
        );
    }
}

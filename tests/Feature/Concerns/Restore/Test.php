<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Restore;

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
        $response = $this->json('post', $this->getRoute([Str::random(5)]));
        $response->assertStatus(403);

        // Test random number as id
        $response = $this->json('post', $this->getRoute([rand(1000, 9999)]));
        $response->assertStatus(403);

        $response = $this->json('post', $this->getRoute([$model->id]));
        $response->assertStatus(403);
    }

    /**
     * @return void
     * @group crud
     * @group crud
     */
    public function successful_restore(): void
    {
        $model = call_user_func($this->model_classname.'::factory')
            ->softDeleted()
            ->create();

        $response = $this->json('post', $this->getRoute([$model->id]));
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

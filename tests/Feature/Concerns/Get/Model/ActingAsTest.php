<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Get\Model;

use Thtg88\MmCms\Models\User;

trait ActingAsTest
{
    /**
     * @return void
     * @group get-tests
     * @test
     */
    public function successful_get(): void
    {
        $user = factory(User::class)->states('email_verified')->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute([$model->id]));
        $response->assertStatus(200);
    }
}

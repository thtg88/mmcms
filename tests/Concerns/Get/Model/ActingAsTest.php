<?php

namespace Thtg88\MmCms\Tests\Concerns\Get\Model;

use Thtg88\MmCms\Models\User;

trait ActingAsTest
{
    /**
     * Test successful get request.
     *
     * @return void
     * @group get-tests
     */
    public function testSuccessfulGet()
    {
        $user = factory(User::class)->states('email_verified')->create();

        $model = factory($this->model_classname)->create();

        $response = $this->actingAs($user)
            ->get($this->getRoute([$model->id]));

        $response->assertStatus(200);
    }
}

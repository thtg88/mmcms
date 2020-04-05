<?php

namespace Thtg88\MmCms\Tests\Concerns\Get\Model;

use Thtg88\MmCms\Models\User;

trait ActingAsUserTest
{
    /**
     * Test successful get request acting as parent.
     *
     * @return void
     * @group get-tests
     */
    public function testSuccessfulGetActingAsParent()
    {
        $user = factory(User::class)->states('email_verified', 'user')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->actingAs($user)->get($this->getRoute([$model->id]));
        $response->assertStatus(200);
    }
}

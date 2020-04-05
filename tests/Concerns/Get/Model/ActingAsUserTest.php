<?php

namespace Thtg88\MmCms\Tests\Concerns\Get\Model;

use Thtg88\MmCms\Models\User;

trait ActingAsUserTest
{
    /**
     * Test successful get request acting as user.
     *
     * @return void
     * @group get-tests
     */
    public function testSuccessfulGetActingAsUser()
    {
        $user = factory(User::class)->states('email_verified', 'user')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute([$model->id]));
        $response->assertStatus(200);
    }
}

<?php

namespace Thtg88\MmCms\Tests\Concerns\Action\Post\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsUserTest
{
    /**
     * Test unauthorized acting as parent.
     *
     * @return void
     * @group crud
     */
    public function testUnauthorizedActingAsParent()
    {
        $user = factory(User::class)->states('email_verified', 'user')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->actingAs($user)->post($this->getRoute());
        $response->assertStatus(403);
    }
}

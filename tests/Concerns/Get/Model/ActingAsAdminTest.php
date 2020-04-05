<?php

namespace Thtg88\MmCms\Tests\Concerns\Get\Model;

use Thtg88\MmCms\Models\User;

trait ActingAsAdminTest
{
    /**
     * Test successful get request acting as system admin.
     *
     * @return void
     * @group get-tests
     */
    public function testSuccessfulGetAsSystemAdmin()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute([$model->id]));
        $response->assertStatus(200);
    }
}

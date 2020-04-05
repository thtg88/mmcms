<?php

namespace Thtg88\MmCms\Tests\Concerns\Get\Model\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsAdminTest
{
    /**
     * Test unauthorized request acting as system admin.
     *
     * @return void
     * @group get-tests
     */
    public function testUnauthorizedActingAsSystemAdmin()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->actingAs($user)->get($this->getRoute([$model->id]));
        $response->assertStatus(403);
    }
}

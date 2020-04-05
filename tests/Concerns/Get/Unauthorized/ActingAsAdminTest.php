<?php

namespace Thtg88\MmCms\Tests\Concerns\Get\Unauthorized;

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

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute());
        $response->assertStatus(403);
    }
}

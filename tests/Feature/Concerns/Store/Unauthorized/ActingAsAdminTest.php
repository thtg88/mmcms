<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Store\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsAdminTest
{
    /**
     * @return void
     * @group crud
     * @test
     */
    public function unauthorized_acting_as_admin(): void
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute());
        $response->assertStatus(403);
    }
}

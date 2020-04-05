<?php

namespace Thtg88\MmCms\Tests\Concerns\Store\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsUserTest
{
    /**
     * @return void
     * @group crud
     * @test
     */
    public function unauthorized_acting_as_user(): void
    {
        $user = factory(User::class)->states('email_verified', 'user')
            ->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute());
        $response->assertStatus(403);
    }
}

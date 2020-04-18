<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Get\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsUserTest
{
    /**
     * @return void
     * @group get-tests
     * @test
     */
    public function unauthorized_acting_as_user(): void
    {
        $user = factory(User::class)->states('email_verified', 'user')
            ->create();

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute());
        $response->assertStatus(403);
    }
}

<?php

namespace Thtg88\MmCms\Tests\Concerns\Get;

use Thtg88\MmCms\Models\User;

trait ActingAsDevTest
{
    /**
     * @return void
     * @group get-tests
     * @test
     */
    public function successful_get_as_dev(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute());
        $response->assertStatus(200);
    }
}

<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Get;

use Thtg88\MmCms\Models\User;

trait ActingAsTest
{
    /**
     * @return void
     * @group get-tests
     * @test
     */
    public function successful_get(): void
    {
        $user = factory(User::class)->states('email_verified')->create();

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute());

        $response->assertStatus(200);
    }
}

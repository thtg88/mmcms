<?php

namespace Thtg88\MmCms\Tests\Concerns\Get;

use Thtg88\MmCms\Models\User;

trait ActingAsTest
{
    /**
     * Test successful get request.
     *
     * @return void
     * @group get-tests
     */
    public function testSuccessfulGet()
    {
        $user = factory(User::class)->states('email_verified')->create();

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute());

        $response->assertStatus(200);
    }
}

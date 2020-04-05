<?php

namespace Thtg88\MmCms\Tests\Concerns\Get\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsUserTest
{
    /**
     * Test unauthorized request acting as parent.
     *
     * @return void
     * @group get-tests
     */
    public function testUnauthorizedActingAsParent()
    {
        $user = factory(User::class)->states('email_verified', 'user')
            ->create();

        $response = $this->actingAs($user)->get($this->getRoute());
        $response->assertStatus(403);
    }
}

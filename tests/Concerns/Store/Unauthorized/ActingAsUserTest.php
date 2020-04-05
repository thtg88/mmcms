<?php

namespace Thtg88\MmCms\Tests\Concerns\Store\Unauthorized;

use Thtg88\MmCms\Models\User;

trait ActingAsUserTest
{
    /**
     * Test unauthorized acting as parent.
     *
     * @return void
     * @group crud
     */
    public function testUnauthorizedActingAsParent()
    {
        $user = factory(User::class)->states('email_verified', 'user')
            ->create();

        $response = $this->actingAs($user)->post($this->getRoute());
        $response->assertStatus(403);
    }
}

<?php

namespace Thtg88\MmCms\Tests\Concerns\Get;

use Thtg88\MmCms\Models\User;

trait ActingAsAdminTest
{
    /**
     * Test successful get request acting as system admin.
     *
     * @return void
     * @group get-tests
     */
    public function testSuccessfulGetAsSystemAdmin()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();

        $response = $this->actingAs($user)->get($this->getRoute());
        $response->assertStatus(200);
    }
}

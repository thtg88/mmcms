<?php

namespace Thtg88\MmCms\Tests\Feature\Concerns\Get;

use Thtg88\MmCms\Models\User;

trait ActingAsAdminTest
{
    /**
     * @return void
     * @group get-tests
     * @test
     */
    public function successful_get_as_admin(): void
    {
        $user = User::factory()->emailVerified()->admin()->create();

        $response = $this->passportActingAs($user)
            ->json('get', $this->getRoute());
        $response->assertStatus(200);
    }
}

<?php

namespace Thtg88\MmCms\Tests\Feature;

use Thtg88\MmCms\Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * The route URL.
     *
     * @var string
     */
    protected $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = route('mmcms.auth.login');
    }

    /** @test */
    public function empty_payload_has_required_validation_errors(): void
    {
        $response = $this->json('post', $this->url);
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }

    /**
     * Check that the login succeeds with correct input.
     * @return void
     */
    // public function testLoginSuccess()
    // {
    //     $input = [];
    //
    //     $response = $this->json('POST', $this->url, $input);
    //
    //     $response
    //         ->assertStatus(201)
    //         ->assertJson([
    //             'created' => true,
    //         ]);
    // }
}

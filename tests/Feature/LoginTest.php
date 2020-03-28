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

    /**
     * Check that the login fails.
     * @return void
     */
    public function testLoginFail()
    {
        $input = [];

        $response = $this->json('POST', $this->url, $input);

        $response
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email' => 'The email field is required.',
                    'password' => 'The password field is required.'
                ],
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
<?php

namespace Thtg88\MmCms\Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Tests\Feature\TestCase;

class LoginTest extends TestCase
{
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

    /** @test */
    public function wrong_credentials_error(): void
    {
        // Create test user
        $password = 'password';
        $model = factory(User::class)->create([
            'password' => $password,
        ]);

        // Test wrong email and password
        $response = $this->json('post', $this->url, [
            'email' => $this->faker->email(),
            'password' => 'wrong-password',
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email' => ['The selected email is invalid.'],
                ],
            ]);

        // Test wrong password
        $response = $this->json('post', $this->url, [
            'email' => $model->email,
            'password' => 'wrong-password',
        ]);
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'The user credentials were incorrect.',
            ]);

        // Test wrong email
        $response = $this->json('post', $this->url, [
            'email' => $this->faker->email(),
            'password' => $password,
        ]);
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email' => ['The selected email is invalid.'],
                ],
            ]);
    }

    /** @test */
    public function successful_login()
    {
        // Create test user
        $password = Str::random(8);
        $model = factory(User::class)->create([
            'password' => $password,
        ]);

        // Test successful login
        $response = $this->json('post', $this->url, [
            'email' => $model->email,
            'password' => $password,
        ]);
        $response//->assertStatus(200)
            ->assertJson(['foo' => 'bar']);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($model);

        Auth::logout();

        // Test successful login with wrong email casing
        $response = $this->json('post', $this->url, [
            'email' => strtoupper($model->email),
            'password' => $password,
        ]);
        $response->assertStatus(200)
            ->assertJson(['foo' => 'bar']);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($model);
    }
}

<?php

namespace Thtg88\MmCms\Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Laravel\Passport\Passport;
use Mockery as m;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Repositories\UserRepository;
use Thtg88\MmCms\Tests\Feature\TestCase;

class LoginTest extends TestCase
{
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
        $response = $this->mockOauthHttpClient($model->email)
            ->json('post', $this->url, [
                'email' => $model->email,
                'password' => $password,
            ]);
        $response->assertStatus(200)
            ->assertJson([
                'token_type' => 'Bearer',
                'expires_in' => 31536000,
                'access_token' => 'access-token',
                'refresh_token' => 'refresh-token',
            ]);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($model);

        $this->passportAuthLogout();

        // Test successful login with wrong email casing
        $response = $this->mockOauthHttpClient(strtoupper($model->email))
            ->json('post', $this->url, [
                'email' => strtoupper($model->email),
                'password' => $password,
            ]);
        $response->assertStatus(200)
            ->assertJson([
                'token_type' => 'Bearer',
                'expires_in' => 31536000,
                'access_token' => 'access-token',
                'refresh_token' => 'refresh-token',
            ]);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($model);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = route('mmcms.auth.login');
    }

    protected function tearDown(): void
    {
        m::close();

        parent::tearDown();
    }

    protected function mockOauthHttpClient($email): self
    {
        $user = app()->make(UserRepository::class)
            ->findByModelName(strtolower($email));

        if ($user === null) {
            throw new InvalidArgumentException(
                'The email provided does not have a corresponding user'.
                ' in the database. Please create one before continuing'
            );
        }

        Passport::actingAs($user);

        $app = Container::getInstance();

        // Mock OAuth Passport HTTP Client
        $mock = new MockHandler([
            new GuzzleResponse(200, ['Content-Type' => 'application/json'], json_encode([
                'token_type' => 'Bearer',
                'expires_in' => 31536000,
                'access_token' => 'access-token',
                'refresh_token' => 'refresh-token',
            ]))
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $app->instance('OauthHttpClient', $client);

        return $this;
    }
}

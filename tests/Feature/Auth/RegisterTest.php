<?php

namespace Thtg88\MmCms\Tests\Feature\Auth;

use Illuminate\Support\Str;
use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Repositories\UserRepository;
use Thtg88\MmCms\Tests\Feature\TestCase;

/**
 * @todo test+mock Recaptcha mode
 */
class RegisterTest extends TestCase
{
    use WithOauthHttpClientMock;

    /** @test */
    public function empty_payload_has_required_validation_errors(): void
    {
        $response = $this->json('post', $this->getRoute());

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email'    => 'The email field is required.',
                'name'     => 'The name field is required.',
                'password' => 'The password field is required.',
            ]);
    }

    /** @test */
    public function too_long_strings_have_max_validation_errors(): void
    {
        $response = $this->json('post', $this->getRoute(), [
            'email' => Str::random(256),
            'name'  => Str::random(256),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email may not be greater than 255 characters.',
                'name'  => 'The name may not be greater than 255 characters.',
            ]);
    }

    /** @test */
    public function password_too_short_validation(): void
    {
        $response = $this->json('post', $this->getRoute(), [
            'password' => Str::random(5),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'password' => 'The password must be at least 6 characters.',
            ]);
    }

    /** @test */
    public function password_confirmation_validation(): void
    {
        $response = $this->json('post', $this->getRoute(), [
            'password'              => Str::random(8),
            'password_confirmation' => Str::random(8),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'password' => 'The password confirmation does not match.',
            ]);
    }

    /** @test */
    public function unique_validation(): void
    {
        $user = User::factory()->create();

        $response = $this->json('post', $this->getRoute(), [
            'email' => $user->email,
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email has already been taken.',
            ]);

        // Test unique does not care of casing
        $response = $this->json('post', $this->getRoute(), [
            'email' => strtoupper($user->email),
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email has already been taken.',
            ]);
    }

    /** @test */
    public function successful_registration(): void
    {
        $data = User::factory()->raw();
        $data['password_confirmation'] = $data['password'];

        $response = $this->mockOauthHttpClient($data['email'], true)
            ->json('post', $this->getRoute(), $data);
        $response->assertStatus(200)
            ->assertJson([
                'token_type'    => 'Bearer',
                'expires_in'    => 31536000,
                'access_token'  => 'access-token',
                'refresh_token' => 'refresh-token',
                'resource'      => [
                    'email' => $data['email'],
                    'name'  => $data['name'],
                ],
            ]);

        $model = app()->make(UserRepository::class)
            ->findByModelName($data['email']);

        $this->passportActingAs($model);

        $response->assertJson(['resource' => ['id' => $model->id]]);

        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($model);
        $this->assertTrue($model !== null);
        $this->assertInstanceOf(User::class, $model);
        // Check the role is the default role id (user)
        $this->assertEquals(config('mmcms.roles.ids.default'), $model->role_id);
        $this->assertEquals(config('mmcms.roles.ids.user'), $model->role_id);
        $this->assertInstanceOf(Role::class, $model->role);
    }

    /**
     * Return the route to use for these tests from a given parameters array.
     *
     * @param array $parameters
     *
     * @return string
     */
    public function getRoute(array $parameters = []): string
    {
        return route('mmcms.auth.register');
    }
}

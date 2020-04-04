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
        $response = $this->json('post', $this->url);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email field is required.',
                'name' => 'The name field is required.',
                'password' => 'The password field is required.',
            ]);
    }

    /** @test */
    public function too_long_strings_have_max_validation_errors(): void
    {
        $response = $this->json('post', $this->url, [
            'email' => Str::random(256),
            'name' => Str::random(256),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email may not be greater than 255 characters.',
                'name' => 'The name may not be greater than 255 characters.',
            ]);
    }

    /** @test */
    public function password_too_short_validation(): void
    {
        $response = $this->json('post', $this->url, [
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
        $response = $this->json('post', $this->url, [
            'password' => Str::random(8),
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
        $user = factory(User::class)->create();

        $this->withoutExceptionHandling();

        $response = $this->json('post', $this->url, [
            'email' => $user->email,
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email has already been taken.',
            ]);

        // Test unique does not care of casing
        $response = $this->json('post', $this->url, [
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
        $data = factory(User::class)->raw();

        $response = $this->mockOauthHttpClient($data['email'])
            ->json('post', $this->url, $data);

        $model = app()->make(UserRepository::class)
            ->findByModelName($data['email']);

        $this->passportActingAs($model);

        $response->assertStatus(200)
            ->assertJson(['foo' => 'bar']);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($model);
        $this->assertTrue($model !== null);
        $this->assertInstanceOf(User::class, $model);
        // Check the role is the default role id (user)
        $this->assertEquals(config('mmcms.roles.ids.default'), $model->role_id);
        $this->assertEquals(config('mmcms.roles.ids.user'), $model->role_id);
        $this->assertInstanceOf(Role::class, $model->role);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = route('mmcms.auth.register');
    }
}

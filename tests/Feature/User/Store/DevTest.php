<?php

namespace Thtg88\MmCms\Tests\Feature\User\Store;

use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Thtg88\MmCms\Tests\Contracts\StoreTest as StoreTestContract;
use Thtg88\MmCms\Tests\Feature\User\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements StoreTestContract
{
    use WithModelData, WithUrl;

    /**
     * @return void
     * @group crud
     * @test
     */
    public function empty_payload_has_required_validation_errors(): void
    {
        $user = factory(User::class)
            ->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute());
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email field is required.',
                'name' => 'The name field is required.',
                'password' => 'The password field is required.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function strings_validation_errors(): void
    {
        $user = factory(User::class)
            ->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'email' => [Str::random(5)],
                'name' => [Str::random(5)],
                'password' => [Str::random(5)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email must be a string.',
                'name' => 'The name must be a string.',
                'password' => 'The password must be a string.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function too_long_strings_have_max_validation_errors(): void
    {
        $user = factory(User::class)
            ->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'email' => Str::random(256),
                'name' => Str::random(256),
                'password' => Str::random(256),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email may not be greater than 255 characters.',
                'name' => 'The name may not be greater than 255 characters.',
                'password' => 'The password may not be greater than 255 characters.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function string_min_validation(): void
    {
        $user = factory(User::class)
            ->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), ['password' => Str::random(5)]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'password' => 'The password must be at least 6 characters.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function unique_validation(): void
    {
        $user = factory(User::class)
            ->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), ['email' => $model->email]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email' => 'The email has already been taken.',
        ]);

        // Check validation is case-insensitive
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'email' => strtoupper($model->email),
            ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email' => 'The email has already been taken.',
        ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function successful_store(): void
    {
        $user = factory(User::class)
            ->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $data = factory($this->model_classname)->raw();
        $data['password_confirmation'] = $data['password'];

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), $data);
        $response->assertStatus(200);

        $model = app()->make($this->repository_classname)
            ->findByModelName($data['email']);

        $response->assertJson([
            'success' => true,
            'resource' => [
                'id' => $model->id,
                'email' => $data['email'],
                'name' => $data['name'],
            ],
        ]);

        $this->assertTrue($model !== null);
        $this->assertInstanceOf($this->model_classname, $model);
        $this->assertInstanceOf(Role::class, $model->role);
        $this->assertEquals(
            Config::get('mmcms.roles.ids.default'),
            $model->role_id
        );
        // Check all attributes match
        foreach ($data as $key => $value) {
            // Skip password_confirmation test as not stored in DB
            if ($key === 'password_confirmation') {
                continue;
            }

            if ($key === 'password') {
                $this->assertTrue(password_verify($data[$key], $model->$key));
            } else {
                $this->assertEquals($data[$key], $model->$key);
            }
        }
    }

    /**
     * Return the factory state that represent the user role
     * acting for these tests.
     *
     * @return string
     */
    protected function getUserRoleFactoryStateName(): string
    {
        return 'dev';
    }
}

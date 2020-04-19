<?php

namespace Thtg88\MmCms\Tests\Feature\User\Store;

use Illuminate\Support\Str;
use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Repositories\RoleRepository;

trait WithSuccessfulTests
{
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
    public function integer_validation(): void
    {
        $user = factory(User::class)
            ->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), ['role_id' => [Str::random(8)]]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'role_id' => 'The role id must be an integer.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function role_id_exists_validation(): void
    {
        $user = factory(User::class)
            ->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();

        $deleted_role = factory(Role::class)->create();
        app()->make(RoleRepository::class)->destroy($deleted_role->id);

        // Test random id invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), ['role_id' => rand(1000, 9999)]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'role_id' => 'The selected role id is invalid.',
            ]);

        // Test deleted role invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), ['role_id' => $deleted_role->id]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'role_id' => 'The selected role id is invalid.',
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
                'created_at' => $model->created_at->toISOString(),
                'email' => $data['email'],
                'name' => $data['name'],
            ],
        ]);

        $this->assertTrue($model !== null);
        $this->assertInstanceOf($this->model_classname, $model);
        $this->assertInstanceOf(Role::class, $model->role);
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
}

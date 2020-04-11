<?php

namespace Thtg88\MmCms\Tests\Feature\User\Update;

use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Repositories\RoleRepository;
use Thtg88\MmCms\Models\User;
use Illuminate\Support\Str;

trait WithSuccessfulTests
{
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
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'email' => [Str::random(5)],
                'name' => [Str::random(5)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email must be a string.',
                'name' => 'The name must be a string.',
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
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'email' => Str::random(256),
                'name' => Str::random(256),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email may not be greater than 255 characters.',
                'name' => 'The name may not be greater than 255 characters.',
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
        $other_model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'email' => $other_model->email,
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email has already been taken.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function successful_update(): void
    {
        $user = factory(User::class)
            ->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $model = factory($this->model_classname)->create();

        // We do not need the password on update request
        $data = factory($this->model_classname)->raw();
        unset($data['password']);

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), $data);
        $response->assertStatus(200);

        $model = $model->refresh();

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
            $this->assertEquals($data[$key], $model->$key);
        }
    }
}
